<?php 
include "data.php";

// Get blog slug from URL parameter
$blog_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($blog_slug)) {
    header('Location: blog.php');
    exit();
}

// Fetch blog details
$blog_query = "SELECT b.*, bc.name as category_name, bc.slug as category_slug 
               FROM blog b 
               LEFT JOIN blog_categories bc ON b.category_id = bc.id 
               WHERE b.slug = ? AND b.status = 'published'";

$stmt = mysqli_prepare($conn, $blog_query);
mysqli_stmt_bind_param($stmt, 's', $blog_slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    header('HTTP/1.0 404 Not Found');
    header('Location: blog.php');
    exit();
}

// Ensure we have a valid blog before proceeding
if (empty($blog)) {
    header('Location: blog.php');
    exit();
}

// Update view count
$update_views = "UPDATE blog SET view_count = view_count + 1 WHERE id = ?";
$stmt_views = mysqli_prepare($conn, $update_views);
mysqli_stmt_bind_param($stmt_views, 'i', $blog['id']);
mysqli_stmt_execute($stmt_views);

// Get related posts (same category, excluding current post)
$related_query = "SELECT b.*, bc.name as category_name 
                  FROM blog b 
                  LEFT JOIN blog_categories bc ON b.category_id = bc.id 
                  WHERE b.category_id = ? AND b.id != ? AND b.status = 'published' 
                  ORDER BY b.published_date DESC 
                  LIMIT 3";
$stmt_related = mysqli_prepare($conn, $related_query);
mysqli_stmt_bind_param($stmt_related, 'ii', $blog['category_id'], $blog['id']);
mysqli_stmt_execute($stmt_related);
$related_result = mysqli_stmt_get_result($stmt_related);
$related_posts = [];
while($row = mysqli_fetch_assoc($related_result)) {
    $related_posts[] = $row;
}

// Get categories with post counts
$categories_query = "SELECT bc.*, COUNT(b.id) as post_count 
                     FROM blog_categories bc 
                     LEFT JOIN blog b ON bc.id = b.category_id AND b.status = 'published' 
                     WHERE bc.is_active = 1 
                     GROUP BY bc.id 
                     ORDER BY bc.sort_order, bc.name";
$categories_result = mysqli_query($conn, $categories_query);
$categories = [];
while($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row;
}

// Get popular tags
$tags_query = "SELECT bt.*, COUNT(btr.blog_id) as usage_count 
               FROM blog_tags bt 
               LEFT JOIN blog_tag_relationships btr ON bt.id = btr.tag_id 
               LEFT JOIN blog b ON btr.blog_id = b.id AND b.status = 'published'
               WHERE bt.is_active = 1 
               GROUP BY bt.id 
               ORDER BY usage_count DESC, bt.name 
               LIMIT 10";
$tags_result = mysqli_query($conn, $tags_query);
$popular_tags = [];
while($row = mysqli_fetch_assoc($tags_result)) {
    $popular_tags[] = $row;
}

// Helper functions
function formatBlogDate($date) {
    return date('d M Y', strtotime($date));
}

function createExcerpt($content, $length = 150) {
    $content = strip_tags($content);
    if (strlen($content) <= $length) {
        return $content;
    }
    return substr($content, 0, $length) . '...';
}

function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time/60) . ' minutes ago';
    if ($time < 86400) return floor($time/3600) . ' hours ago';
    if ($time < 2592000) return floor($time/86400) . ' days ago';
    if ($time < 31536000) return floor($time/2592000) . ' months ago';
    return floor($time/31536000) . ' years ago';
}

// SEO Meta variables
$page_title = !empty($blog['meta_title']) ? $blog['meta_title'] : $blog['title'] . ' - ' . $company_website_name;
$meta_description = !empty($blog['meta_description']) ? $blog['meta_description'] : createExcerpt($blog['content'], 160);
$meta_keywords = !empty($blog['meta_keywords']) ? $blog['meta_keywords'] : $blog['title'] . ', ' . (!empty($blog['category_name']) ? $blog['category_name'] : 'blog');
$canonical_url = $urlmain . 'blog-detail.php?slug=' . urlencode($blog['slug']);

// Parse tags if stored as comma-separated string
$blog_tags = [];
if (!empty($blog['tags'])) {
    $blog_tags = array_map('trim', explode(',', $blog['tags']));
}
 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic SEO Meta Tags -->
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($blog['author']); ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <?php if (!empty($blog['featured_image'])): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($urlmain . 'images/blog/' . $blog['featured_image']); ?>">
    <?php elseif (!empty($blog['image'])): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($urlmain . 'images/blog/' . $blog['image']); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php echo htmlspecialchars($company_website_name); ?>">
    <meta property="article:published_time" content="<?php echo date('c', strtotime(!empty($blog['published_date']) ? $blog['published_date'] : $blog['created_date'])); ?>">
    <meta property="article:author" content="<?php echo htmlspecialchars($blog['author']); ?>">
    <?php if (!empty($blog['category_name'])): ?>
    <meta property="article:section" content="<?php echo htmlspecialchars($blog['category_name']); ?>">
    <?php endif; ?>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php if (!empty($blog['featured_image'])): ?>
    <meta name="twitter:image" content="<?php echo htmlspecialchars($urlmain . 'images/blog/' . $blog['featured_image']); ?>">
    <?php elseif (!empty($blog['image'])): ?>
    <meta name="twitter:image" content="<?php echo htmlspecialchars($urlmain . 'images/blog/' . $blog['image']); ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">
    
    <!-- Favicon and other meta from settings -->
    <?php if (!empty($company_favicon)): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo htmlspecialchars($company_favicon); ?>">
    <?php endif; ?>
    
   <?php include "include/css.php";?> 
   
   <!-- Structured Data for Blog Post -->
   <script type="application/ld+json">
   {
     "@context": "https://schema.org",
     "@type": "BlogPosting",
     "headline": "<?php echo htmlspecialchars($blog['title']); ?>",
     "description": "<?php echo htmlspecialchars($meta_description); ?>",
     "author": {
       "@type": "Person",
       "name": "<?php echo htmlspecialchars($blog['author']); ?>"
     },
     "datePublished": "<?php echo date('c', strtotime(!empty($blog['published_date']) ? $blog['published_date'] : $blog['created_date'])); ?>",
     "dateModified": "<?php echo date('c', strtotime($blog['updated_date'])); ?>",
     <?php if (!empty($blog['featured_image']) || !empty($blog['image'])): ?>
     "image": "<?php echo htmlspecialchars($urlmain . 'images/blog/' . (!empty($blog['featured_image']) ? $blog['featured_image'] : $blog['image'])); ?>",
     <?php endif; ?>
     "url": "<?php echo htmlspecialchars($canonical_url); ?>",
     "publisher": {
       "@type": "Organization",
       "name": "<?php echo htmlspecialchars($company_website_name); ?>"
       <?php if (!empty($company_logo)): ?>
       ,"logo": {
         "@type": "ImageObject",
         "url": "<?php echo htmlspecialchars($urlmain . $company_logo); ?>"
       }
       <?php endif; ?>
     }
     <?php if (!empty($blog['category_name'])): ?>
     ,"articleSection": "<?php echo htmlspecialchars($blog['category_name']); ?>"
     <?php endif; ?>
     <?php if (!empty($blog_tags)): ?>
     ,"keywords": "<?php echo htmlspecialchars(implode(', ', $blog_tags)); ?>"
     <?php endif; ?>
   }
   </script>
   <style>
    /* Blog content heading styles */
    .blog-content-body h1,
    .blog-content-body h2,
    .blog-content-body h3,
    .blog-content-body h4,
    .blog-content-body h5,
    .blog-content-body h6 {
        color: #2c3e50;
        font-weight: 600;
        line-height: 1.4;
        margin-top: 25px;
        margin-bottom: 15px;
    }
    
    .blog-content-body h1 {
        font-size: 28px;
        border-bottom: 2px solid #3498db;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }
    
    .blog-content-body h2 {
        font-size: 21px;
        color: #34495e;
        margin-top: 30px;
    }
    
    .blog-content-body h3 {
        font-size: 20px;
        color: #34495e;
        margin-top: 25px;
    }
    
    .blog-content-body h4 {
        font-size: 18px;
        color: #34495e;
        font-weight: 600;
    }
    
    .blog-content-body h5 {
        font-size: 16px;
        color: #34495e;
        font-weight: 600;
    }
    
    .blog-content-body h6 {
        font-size: 14px;
        color: #34495e;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Blog content paragraph and list styling */
    .blog-content-body p {
        font-size: 16px;
        line-height: 1.7;
        color: #555;
        margin-bottom: 16px;
        text-align: justify;
    }
    
    .blog-content-body ul,
    .blog-content-body ol {
        margin: 15px 0;
        padding-left: 30px;
    }
    
    .blog-content-body li {
        font-size: 16px;
        line-height: 1.7;
        color: #555;
        margin-bottom: 8px;
    }
    
    .blog-content-body strong,
    .blog-content-body b {
        color: #2c3e50;
        font-weight: 600;
    }
    
    /* Main title styling */
    .ccdr h2 {
        font-size: 28px;
        font-weight: 600;
        margin-top: 10px;
        color: #2c3e50;
        line-height: 1.3;
    }
    
    /* Professional spacing and readability */
    .blog-content-body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .blog-content-body blockquote {
        border-left: 4px solid #3498db;
        background: #f8f9fa;
        padding: 15px 20px;
        margin: 20px 0;
        font-style: italic;
        color: #555;
    }
    
    .blog-content-body code {
        background: #f1f2f6;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 14px;
        color: #e74c3c;
    }
    
    .blog-content-body pre {
        background: #2c3e50;
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        overflow-x: auto;
        margin: 20px 0;
    }
    
    /* Table styling if any */
    .blog-content-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    
    .blog-content-body table th,
    .blog-content-body table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    
    .blog-content-body table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
    }
   </style>

</head>

<body>

     

   
   <?php include "include/header.php";?> 
   <div class="breadcrumb-bar  text-center" style="      background-color: #fc9d0b78; padding: 39px 0 40px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h1 class="breadcrumb-title mb-2"><?php echo htmlspecialchars($blog['title']); ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="<?php echo $urlmain; ?>"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item"><a href="blog.php">Blogs</a></li>
                            <?php if (!empty($blog['category_name'])): ?>
                            <li class="breadcrumb-item"><a href="blog.php?category=<?php echo urlencode($blog['category_slug']); ?>"><?php echo htmlspecialchars($blog['category_name']); ?></a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars(strlen($blog['title']) > 50 ? substr($blog['title'], 0, 50) . '...' : $blog['title']); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
   
    <div class="content">
        <div class="container">

            <!-- Blog Details -->
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card blog-details mb-4 mb-lg-0">
                        <div class="card-body">
                            <div class="blog-content">
                                <?php if (!empty($blog['featured_image']) || !empty($blog['image'])): ?>
                                <div class="blog-image mb-3">
                                    <img src="<?php echo $urlmain; ?>images/blog/<?php echo htmlspecialchars(!empty($blog['featured_image']) ? $blog['featured_image'] : $blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="img-fluid rounded">
                                </div>
                                <?php endif; ?>
                                <div class="d-flex  align-items-center flex-wrap row-gap-2 mb-3">
                                    <a href="javascript:void(0);" class=" d-flex align-items-center fs-16 text-gray-9 pe-3 border-end me-3">
                                        <?php 
                                        $author_images = [
                                            'assets/img/users/user-01.jpg',
                                            'assets/img/users/user-02.jpg',
                                            'assets/img/users/user-03.jpg'
                                        ];
                                        $author_image = $author_images[array_rand($author_images)];
                                        ?>
                                        <img src="<?php echo $author_image; ?>" alt="<?php echo htmlspecialchars($blog['author']); ?>" class="img-fluid avatar avatar-sm rounded-circle me-2"> <?php echo htmlspecialchars($blog['author']); ?>
                                    </a>
                                    <div class="pe-3 border-end me-3">
                                        <span class="d-flex align-items-center fs-16 text-gray-9 "><i class="isax isax-calendar-2 me-1"></i><?php echo formatBlogDate(!empty($blog['published_date']) ? $blog['published_date'] : $blog['created_date']); ?></span>
                                    </div>
                                    <?php if (!empty($blog['category_name'])): ?>
                                    <div class="pe-3 border-end me-3">
                                        <span class="badge badge-sm badge-primary"><?php echo htmlspecialchars($blog['category_name']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($blog['view_count'] > 0): ?>
                                    <div>
                                        <span class="d-flex align-items-center fs-16 text-gray-9"><i class="isax isax-eye me-1"></i><?php echo number_format($blog['view_count']); ?> views</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3 ccdr">
                                    <h2 style="font-size: 20px; font-weight: 500; margin-top: 31px;"><?php echo htmlspecialchars($blog['title']); ?></h2>
                                </div>
                                <?php if (!empty($blog['excerpt'])): ?>
                                <div class="mb-3">
                                    <p class="text-gray-6 lead"><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                                </div>
                                <?php endif; ?>
                                <div class="blog-content-body">
                                    <?php echo $blog['content']; ?>
                                </div>
                                <div class="pb-3 border-bottom">
                                    <?php if (!empty($blog['reading_time']) && $blog['reading_time'] > 0): ?>
                                    <p class="fs-14 text-muted mb-2">
                                        <i class="isax isax-clock me-1"></i>
                                        Estimated reading time: <?php echo $blog['reading_time']; ?> minute<?php echo $blog['reading_time'] != 1 ? 's' : ''; ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-3 pb-3 border-bottom d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <?php if (!empty($blog_tags)): ?>
                                        <p class="fs-16 text-gray-9 mb-0 me-2">Tags :</p>
                                        <?php foreach ($blog_tags as $tag): ?>
                                        <a href="blog.php?tag=<?php echo urlencode(trim($tag)); ?>" class="badge badge-sm badge-secondary me-2 mb-1"><?php echo htmlspecialchars(trim($tag)); ?></a>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="fs-16 text-gray-9 mb-0 me-2">Share On :</p>
                                        <?php 
                                        $share_url = urlencode($canonical_url);
                                        $share_title = urlencode($blog['title']);
                                        $share_text = urlencode($meta_description);
                                        ?>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" class="me-2" title="Share on Facebook"><img src="assets/img/icons/facebook.svg" alt="Facebook" class="img-fluid"></a>
                                        <a href="https://www.instagram.com/" target="_blank" class="me-2" title="Share on Instagram"><img src="assets/img/icons/insta.svg" alt="Instagram" class="img-fluid"></a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" class="me-2" title="Share on Twitter"><img src="assets/img/icons/twitter.svg" alt="Twitter" class="img-fluid"></a>
                                        <a href="https://wa.me/?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" title="Share on WhatsApp"><img src="assets/img/icons/whatsapp.svg" alt="WhatsApp" class="img-fluid"></a>
                                    </div>
                                </div>
                               
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 theiaStickySidebar">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pb-3 border-bottom mb-3">
                                <h5 class="d-flex align-items-center "><span class="me-1 fs-16"><i class="isax isax-search-normal text-primary"></i></span> Search</h5>
                            </div>
                            <div class="blog-search">
                                <div class="search-content">
                                    <div class="search-feild position-relative">
                                        <span><i class="isax isax-search-normal"></i></span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header border-0 pb-0">
                            <div class="pb-3 border-bottom">
                                <h5><i class="isax isax-candle text-primary fs-16 me-2"></i>Categories</h5>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-medium mb-0">
                                        <a href="blog.php?category=<?php echo urlencode($category['slug']); ?>"><?php echo htmlspecialchars($category['name']); ?></a>
                                    </h6>
                                    <p>(<?php echo $category['post_count']; ?>)</p>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No categories available</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    <div class="card mb-3">
                        <div class="card-header border-0 pb-0">
                            <div class="pb-3 border-bottom">
                                <h5><i class="ti ti-brand-blogger text-primary fs-16 me-2"></i>Related Posts</h5>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <?php if (!empty($related_posts)): ?>
                                <?php foreach ($related_posts as $index => $related_post): ?>
                                <?php 
                                $related_image = !empty($related_post['image']) ? $related_post['image'] : 'blog-0' . (($index % 3) + 1) . '.jpg';
                                $related_author_image = $author_images[array_rand($author_images)];
                                ?>
                                <div class="blog-post <?php echo $index < count($related_posts) - 1 ? 'mb-3' : ''; ?>">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex">
                                            <a href="blog-detail.php?slug=<?php echo urlencode($related_post['slug']); ?>" class="avatar avatar-xxl me-2">
                                                <img src="<?php echo $urlmain; ?>images/blog/<?php echo htmlspecialchars($related_image); ?>" class="rounded" alt="<?php echo htmlspecialchars($related_post['title']); ?>">
                                            </a>
                                        </div>
                                        <div>
                                            <a href="blog-detail.php?slug=<?php echo urlencode($related_post['slug']); ?>" class="two-line-ellipsis fs-14 fw-medium"><?php echo htmlspecialchars($related_post['title']); ?></a>
                                            <div class="d-flex align-items-center mt-2">
                                                <a href="javascript:void(0);" class="d-flex align-items-center border-end pe-2 me-2">
                                                    <span class="avatar avatar-xs me-1">
                                                        <img src="<?php echo $related_author_image; ?>" class="blog-user-img rounded-circle border border-light" alt="<?php echo htmlspecialchars($related_post['author']); ?>">
                                                    </span>
                                                    <p class="fs-14 text-truncate"><?php echo htmlspecialchars($related_post['author']); ?></p>
                                                </a>
                                                <p class="fs-14 text-truncate"><i class="isax isax-calendar-2 me-2"></i><?php echo formatBlogDate(!empty($related_post['published_date']) ? $related_post['published_date'] : $related_post['created_date']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No related posts found</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /Related Posts -->

                    <div class="card mb-0">
                        <div class="card-header border-0 pb-0">
                            <div class="pb-3 border-bottom">
                                <h5><i class="isax isax-tag text-primary fs-16 me-2"></i>Popular Tags</h5>
                            </div>
                        </div>
                        <div class="card-body pt-3 pb-2">
                            <div class="d-flex align-items-center flex-wrap category-tag">
                                <?php if (!empty($popular_tags)): ?>
                                    <?php foreach ($popular_tags as $tag): ?>
                                    <a href="blog.php?tag=<?php echo urlencode($tag['slug']); ?>" class="badge badge-md fw-normal me-2 mb-2"><?php echo htmlspecialchars($tag['name']); ?></a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No tags available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Blog Details -->

        </div>
    </div>
 

 
   <section class="support-section bg-primary">
        <div class="horizontal-slide d-flex" data-direction="left" data-speed="slow">
            <div class="slide-list d-flex">

            <?php
                                $ss="SELECT * from  extra_content where type='moving_line'";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?> 
                <div class="support-item">
                    <h5><?php echo $socila['heading1'];?></h5>
                </div>
               <?php } ?>
               
                
            </div>
        </div>
    </section> 
   <?php include "include/footer.php";?> 

  



   <?php include "include/js.php";?> 
    <!-- Jquery JS -->
    
 

</body>

</html>