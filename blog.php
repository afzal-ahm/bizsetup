<?php 
include "data.php";
 
// Pagination settings
$blogs_per_page = 9; // 9 blogs per page (3 rows of 3)
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $blogs_per_page;

// Filter parameters
$category_filter = isset($_GET['category']) ? trim($_GET['category']) : '';
$tag_filter = isset($_GET['tag']) ? trim($_GET['tag']) : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build WHERE conditions
$where_conditions = ["b.status = 'published'"];
$params = [];
$param_types = '';

if (!empty($category_filter)) {
    $where_conditions[] = "bc.slug = ?";
    $params[] = $category_filter;
    $param_types .= 's';
}

if (!empty($tag_filter)) {
    $where_conditions[] = "(b.tags LIKE ? OR b.tags LIKE ? OR b.tags LIKE ? OR b.tags = ?)";
    $params[] = $tag_filter . ',%';
    $params[] = '%, ' . $tag_filter . ',%';
    $params[] = '%, ' . $tag_filter;
    $params[] = $tag_filter;
    $param_types .= 'ssss';
}

if (!empty($search_query)) {
    $where_conditions[] = "(b.title LIKE ? OR b.content LIKE ? OR b.excerpt LIKE ?)";
    $search_param = '%' . $search_query . '%';
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $param_types .= 'sss';
}

$where_clause = implode(' AND ', $where_conditions);

// Get total count of filtered blogs
$count_query = "SELECT COUNT(*) as total FROM blog b 
                LEFT JOIN blog_categories bc ON b.category_id = bc.id 
                WHERE $where_clause";

if (!empty($params)) {
    $stmt_count = mysqli_prepare($conn, $count_query);
    mysqli_stmt_bind_param($stmt_count, $param_types, ...$params);
    mysqli_stmt_execute($stmt_count);
    $count_result = mysqli_stmt_get_result($stmt_count);
} else {
    $count_result = mysqli_query($conn, $count_query);
}
$total_blogs = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_blogs / $blogs_per_page);

// Fetch blogs with pagination and filters
$blog_query = "SELECT b.*, bc.name as category_name, bc.slug as category_slug 
               FROM blog b 
               LEFT JOIN blog_categories bc ON b.category_id = bc.id 
               WHERE $where_clause 
               ORDER BY b.published_date DESC, b.created_date DESC 
               LIMIT $blogs_per_page OFFSET $offset";

if (!empty($params)) {
    $stmt_blog = mysqli_prepare($conn, $blog_query);
    mysqli_stmt_bind_param($stmt_blog, $param_types, ...$params);
    mysqli_stmt_execute($stmt_blog);
    $blog_result = mysqli_stmt_get_result($stmt_blog);
} else {
    $blog_result = mysqli_query($conn, $blog_query);
}

$blogs = [];
while($row = mysqli_fetch_assoc($blog_result)) {
    $blogs[] = $row;
}

// Function to format date
function formatBlogDate($date) {
    return date('d M Y', strtotime($date));
}

// Function to get reading time
function getReadingTime($content) {
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return max(1, $reading_time); // Minimum 1 minute
}

// Function to create excerpt
function createExcerpt($content, $length = 150) {
    $content = strip_tags($content);
    if (strlen($content) <= $length) {
        return $content;
    }
    return substr($content, 0, $length) . '...';
}

// Function to build URL with filters
function buildFilterUrl($page = 1) {
    global $category_filter, $tag_filter, $search_query;
    
    $params = [];
    if ($page > 1) $params['page'] = $page;
    if (!empty($category_filter)) $params['category'] = $category_filter;
    if (!empty($tag_filter)) $params['tag'] = $tag_filter;
    if (!empty($search_query)) $params['search'] = $search_query;
    
    $query_string = !empty($params) ? '?' . http_build_query($params) : '';
    return 'blog.php' . $query_string;
}

// Get current filter description
$filter_description = '';
if (!empty($category_filter) || !empty($tag_filter) || !empty($search_query)) {
    $filters = [];
    if (!empty($category_filter)) $filters[] = "Category: " . htmlspecialchars($category_filter);
    if (!empty($tag_filter)) $filters[] = "Tag: " . htmlspecialchars($tag_filter);
    if (!empty($search_query)) $filters[] = "Search: " . htmlspecialchars($search_query);
    $filter_description = implode(', ', $filters);
}
 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "include/title.php";?> 
   <?php include "include/css.php";?> 
   

</head>

<body>

     

   
   <?php include "include/header.php";?> 
   <div class="breadcrumb-bar  text-center" style="      background-color: #fc9d0b78; padding: 39px 0 40px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Blogs</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
   
    <div class="content">
        <div class="container">
            <?php if (!empty($filter_description)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                        <span><i class="isax isax-filter me-2"></i>Filtered by: <?php echo $filter_description; ?></span>
                        <a href="blog.php" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="row justify-content-center">

                <?php if (!empty($blogs)): ?>
                    <?php foreach ($blogs as $index => $blog): ?>
                        <?php 
                        // Calculate delay for animation
                        $delay = 0.2 + ($index % 3) * 0.1;
                        
                        // Default image if none provided
                        $default_images = [
                            'assets/img/blog/blog-01.jpg',
                            'assets/img/blog/blog-02.jpg',
                            'assets/img/blog/blog-03.jpg',
                            'assets/img/blog/blog-05.jpg',
                            'assets/img/blog/blog-06.jpg'
                        ];
                        $blog_image = !empty($blog['image']) ? $blog['image'] : $default_images[array_rand($default_images)];
                        
                        // Default author image
                        $author_images = [
                            'assets/img/users/user-01.jpg',
                            'assets/img/users/user-02.jpg',
                            'assets/img/users/user-03.jpg',
                            'assets/img/users/user-18.jpg',
                            'assets/img/users/user-20.jpg'
                        ];
                        $author_image = $author_images[array_rand($author_images)];
                        
                        // Format publish date
                        $publish_date = !empty($blog['published_date']) ? formatBlogDate($blog['published_date']) : formatBlogDate($blog['created_date']);
                        
                        // Category display
                        $category_display = !empty($blog['category_name']) ? $blog['category_name'] : 'General';
                        ?>

                <!-- Blog Item-->
                <div class="col-xl-4 col-md-6">
                            <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                                <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>" class="blog-img">
                                    <img src="<?php echo $urlmain;?>/images/blog/<?php echo htmlspecialchars($blog_image); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                </a>
                                <span class="badge bg-primary fs-13 fw-medium"><?php echo htmlspecialchars($category_display); ?></span>
                        <div class="blog-info text-center">
                            <div class="d-inline-flex align-items-center justify-content-center">
                                <div class="d-inline-flex align-items-center border-end pe-3 me-3 mb-2">
                                            
                                </div>
                                        <p class="text-white mb-2"><i class="isax isax-calendar-2 me-2"></i><?php echo $publish_date; ?></p>
                            </div>
                                    <h5><a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h5>
                                    
                                </div>
                    </div>
                </div>
                <!-- /Blog Item-->
                    <?php endforeach; ?>
                    
                <?php else: ?>
                    <!-- No blogs found -->
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="isax isax-document-text" style="font-size: 4rem; color: #ccc;"></i>
                            </div>
                            <h4 class="text-muted">No Blogs Found</h4>
                            <p class="text-muted">We're working on adding new blog posts. Please check back later!</p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav class="pagination-nav">
                    <ul class="pagination justify-content-center">
                            <!-- Previous Page -->
                            <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo ($current_page <= 1) ? 'javascript:void(0);' : buildFilterUrl($current_page - 1); ?>" aria-label="Previous">
                                <span aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                            </a>
                        </li>
                            
                            <?php
                            // Calculate page range to show
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($total_pages, $current_page + 2);
                            
                            // Adjust if we're near the beginning or end
                            if ($end_page - $start_page < 4) {
                                if ($start_page == 1) {
                                    $end_page = min($total_pages, $start_page + 4);
                                } else {
                                    $start_page = max(1, $end_page - 4);
                                }
                            }
                            
                            // Show first page if not in range
                            if ($start_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo buildFilterUrl(1); ?>">1</a>
                                </li>
                                <?php if ($start_page > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <!-- Page numbers -->
                            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo buildFilterUrl($i); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <!-- Show last page if not in range -->
                            <?php if ($end_page < $total_pages): ?>
                                <?php if ($end_page < $total_pages - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                        <li class="page-item">
                                    <a class="page-link" href="<?php echo buildFilterUrl($total_pages); ?>"><?php echo $total_pages; ?></a>
                                </li>
                            <?php endif; ?>
                            
                            <!-- Next Page -->
                            <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo ($current_page >= $total_pages) ? 'javascript:void(0);' : buildFilterUrl($current_page + 1); ?>" aria-label="Next">
                                <span aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                    
                    <!-- Blog count info -->
                    <div class="text-center mt-3">
                        <p class="text-muted">
                            Showing <?php echo (($current_page - 1) * $blogs_per_page) + 1; ?> to 
                            <?php echo min($current_page * $blogs_per_page, $total_blogs); ?> of 
                            <?php echo $total_blogs; ?> blog<?php echo $total_blogs != 1 ? 's' : ''; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <!-- /Pagination -->
            </div>
        </div>
    </div>
 
 

 <style>
    .ssa h2
    {
        font-size: 17px;
        margin-bottom: 12px;
    }
    .ssa h1
    {
        font-size: 17px;
        margin-bottom: 12px;
    }
    .ssa h3
    {
        font-size: 17px;
        margin-bottom: 12px;
    }
 </style>
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