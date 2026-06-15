<?php 
include "data.php";

// Get the page URL from the URL
$page_url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($page_url)) {
    header("Location: index.php");
    exit;
}

// Fetch page content from category table where show_in_footer = 1
$page_query = "SELECT * FROM category WHERE url = ? AND show_in_footer = 1  ";
$stmt = mysqli_prepare($conn, $page_query);
mysqli_stmt_bind_param($stmt, "s", $page_url);
mysqli_stmt_execute($stmt);
$page_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($page_result) == 0) {
    // Page not found
    header("HTTP/1.0 404 Not Found");
    echo '<div class="container py-5 text-center">
            <h1 class="display-1 text-muted">404</h1>
            <h2>Page Not Found</h2>
            <p>The page you are looking for does not exist.</p>
            <a href="' . $urlmain . '" class="btn btn-primary">Go Home</a>
          </div>';
    include 'include/footer.php';
    exit;
}

$page_data = mysqli_fetch_assoc($page_result);

// Set page title and meta
$page_title = $page_data['category_name'];
$page_content = $page_data['content'];
$page_heading = $page_data['heading2'] ?: $page_data['category_name'];
$page_image = $page_data['image'] ?: '';
$page_banner = $page_data['banner'] ?: '';

// SEO Meta Data
$seo_title = isset($page_data['seo_title']) && !empty(trim($page_data['seo_title'])) ? $page_data['seo_title'] : '';
$seo_keywords = isset($page_data['seo_keywords']) && !empty(trim($page_data['seo_keywords'])) ? $page_data['seo_keywords'] : '';
$meta_description = isset($page_data['meta_description']) && !empty(trim($page_data['meta_description'])) ? $page_data['meta_description'] : '';

// Check if we have SEO data to determine which title method to use
$has_seo_data = !empty($seo_title) || !empty($seo_keywords) || !empty($meta_description);

 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php if($has_seo_data): ?>
        <!-- Dynamic SEO Meta Tags from Database -->
        <title><?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : htmlspecialchars($page_title . ' - ' . $company_website_name); ?></title>
        
        <?php if(!empty($meta_description)): ?>
            <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php endif; ?>
        
        <?php if(!empty($seo_keywords)): ?>
            <meta name="keywords" content="<?php echo htmlspecialchars($seo_keywords); ?>">
        <?php endif; ?>
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="<?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : htmlspecialchars($page_title); ?>">
        <?php if(!empty($meta_description)): ?>
            <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php endif; ?>
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $urlmain . 'pages.php?url=' . urlencode($page_url); ?>">
        <?php if(!empty($page_image)): ?>
            <meta property="og:image" content="<?php echo $urlmain . 'images/category/' . $page_image; ?>">
        <?php endif; ?>
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : htmlspecialchars($page_title); ?>">
        <?php if(!empty($meta_description)): ?>
            <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php endif; ?>
        <?php if(!empty($page_image)): ?>
            <meta name="twitter:image" content="<?php echo $urlmain . 'images/category/' . $page_image; ?>">
        <?php endif; ?>
        
        <!-- Additional SEO Meta Tags -->
        <meta name="robots" content="index, follow">
        <meta name="author" content="<?php echo $company_website_name; ?>">
        <link rel="canonical" href="<?php echo $urlmain . 'pages.php?url=' . urlencode($page_url); ?>">
        
    <?php else: ?>
        <!-- Default Meta Tags from include file -->
        <?php include "include/title.php"; ?>
    <?php endif; ?>
    
    <?php include "include/css.php"; ?> 
   

</head>

<body>

     

   
   <?php include "include/header.php";?> 
   <div class="breadcrumb-bar breadcrumb-bg-01 text-center" style="    padding: 39px 0 40px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2"><?php echo htmlspecialchars($page_heading); ?></h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($page_heading); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
   
    <!-- /Hero Section -->
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
   
 

    <section class="section about ssa">
    <div class="container">
        <div class="row  ">
            <?php 
            $about_image = $page_image; // your image variable or DB value
            if (!empty($about_image) && file_exists($about_image)) { ?>
                <!-- Image column -->
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div>
                        <img style="width: 100%;" src="<?= $about_image ?>" alt="about">
                    </div>
                </div>
                <!-- Content column -->
                <div class="col-lg-8">
                    <div class="about-content mb-4">
                        <h6 class="text-primary fs-14 fw-medium mb-2"><?= $page_title; ?></h6>
                        <h2 class="display-6 mb-2"><?= $page_heading; ?></h2>
                        <div class="mb-4"><?= $page_content; ?></div>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Full width content if no image -->
                <div class="col-lg-12">
                    <div class="about-content mb-4  ">
                        <h6 class="text-primary fs-14 fw-medium mb-2"><?= $page_title; ?></h6>
                        <h2 class="display-6 mb-2"><?= $page_heading; ?></h2>
                        <div class="mb-4"><?= $page_content; ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="about-bg d-none d-md-block">
            <img src="assets/img/bg/about-bg.png" alt="img" class="about-bg-01">
        </div>
    </div>
</section>

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
    
    /* Dynamic underlines for headings - Yellow theme */
    .about-content h2,
    .about-content h3,
    .about-content h4 {
        position: relative;
        padding-bottom: 8px;
        margin-bottom: 1rem;
        display: inline-block;
        width: fit-content;
    }
    
    .about-content h2::after,
    .about-content h3::after,
    .about-content h4::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    
    /* Hover effect for dynamic underlines */
    .about-content h2:hover::after,
    .about-content h3:hover::after,
    .about-content h4:hover::after {
        background: linear-gradient(90deg, #ff9800 0%, #f57c00 100%);
        transform: scaleY(1.2);
    }
    
    /* Responsive underline adjustments */
    @media (max-width: 768px) {
        .about-content h2::after,
        .about-content h3::after,
        .about-content h4::after {
            height: 2px;
        }
        
        .about-content h2,
        .about-content h3,
        .about-content h4 {
            padding-bottom: 6px;
        }
    }
    
    /* Animation for underline appearance */
    .about-content h2,
    .about-content h3,
    .about-content h4 {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
 </style>
   
   <?php include "include/footer.php";?> 

  



   <?php include "include/js.php";?> 
    <!-- Jquery JS -->
    
 

</body>

</html>