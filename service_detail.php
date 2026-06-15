<?php 
include "data.php";

// Get the URL parameters
$cat_url = isset($_GET['cat_url']) ? $_GET['cat_url'] : '';
$sub_url = isset($_GET['sub_url']) ? $_GET['sub_url'] : '';
$subsub_url = isset($_GET['subsub_url']) ? $_GET['subsub_url'] : '';

// Fetch the sub_subcategory record with price information
$sub_subcategory_query = "SELECT ssc.*, c.category_name, c.url as category_url, sc.subcategory_name, sc.url as subcategory_url 
                         FROM sub_subcategory ssc 
                         LEFT JOIN category c ON ssc.category_id = c.category_id 
                         LEFT JOIN subcategory sc ON ssc.subcategory_id = sc.subcategory_id 
                         WHERE ssc.sub_subcategory_id = '".mysqli_real_escape_string($conn, $subsub_url)."'";
$sub_subcategory_result = mysqli_query($conn, $sub_subcategory_query);

// Fetch products for this sub_subcategory with price information
$products_query = "SELECT * FROM product WHERE sub_subcategory_id = '".mysqli_real_escape_string($conn, $subsub_url)."' ORDER BY id ASC";
$products_result = mysqli_query($conn, $products_query);
$products = [];
while($product = mysqli_fetch_assoc($products_result)) {
    // Extract and clean price data for each product
    $product['clean_mrp'] = isset($product['mrp']) && !empty(trim($product['mrp'])) ? trim($product['mrp']) : '';
    $product['clean_offer_amount'] = isset($product['offer_amount']) && !empty(trim($product['offer_amount'])) ? trim($product['offer_amount']) : '';
    $product['clean_offer'] = isset($product['offer']) && !empty(trim($product['offer'])) ? trim($product['offer']) : '';
    $product['has_product_price'] = !empty($product['clean_mrp']) || !empty($product['clean_offer_amount']);
    
    $products[] = $product;
}

if(mysqli_num_rows($sub_subcategory_result) > 0) {
    $service_data = mysqli_fetch_assoc($sub_subcategory_result);
    $page_title = $service_data['sub_subcategory_name'];
    $category_name = $service_data['category_name'];
    $subcategory_name = $service_data['subcategory_name'];
    
    // Extract SEO data from service_data
    $seo_title = isset($service_data['seo_title']) && !empty(trim($service_data['seo_title'])) ? $service_data['seo_title'] : '';
    $seo_keywords = isset($service_data['seo_keywords']) && !empty(trim($service_data['seo_keywords'])) ? $service_data['seo_keywords'] : '';
    $meta_description = isset($service_data['meta_description']) && !empty(trim($service_data['meta_description'])) ? $service_data['meta_description'] : '';
    $service_image = isset($service_data['image']) && !empty(trim($service_data['image'])) ? $service_data['image'] : '';
    
    // Extract price data from service_data
    $main_price = isset($service_data['extra']) && !empty(trim($service_data['extra'])) ? trim($service_data['extra']) : '';
    $offer_price = isset($service_data['price']) && !empty(trim($service_data['price'])) ? trim($service_data['price']) : '';
    $price_note = isset($service_data['meal']) && !empty(trim($service_data['meal'])) ? trim($service_data['meal']) : '';
    
    // Check if we have SEO data
    $has_seo_data = !empty($seo_title) || !empty($seo_keywords) || !empty($meta_description);
    
    // Check if we have price data
    $has_price_data = !empty($main_price) || !empty($offer_price);
    
} else {
    $page_title = "Service Not Found";
    $category_name = "";
    $subcategory_name = "";
    $has_seo_data = false;
    $has_price_data = false;
    $main_price = '';
    $offer_price = '';
    $price_note = '';
}
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php if($has_seo_data): ?>
        <!-- Dynamic SEO Meta Tags -->
        <title><?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : htmlspecialchars($page_title . ' - ' . $company_website_name); ?></title>
        
        <?php if(!empty($meta_description)): ?>
        <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php endif; ?>
        
        <?php if(!empty($seo_keywords)): ?>
        <meta name="keywords" content="<?php echo htmlspecialchars($seo_keywords); ?>">
        <?php endif; ?>
        
        <!-- Open Graph Tags -->
        <meta property="og:title" content="<?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : htmlspecialchars($page_title); ?>">
        <?php if(!empty($meta_description)): ?>
        <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php endif; ?>
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $urlmain . 'service_detail.php?cat_url=' . urlencode($cat_url) . '&sub_url=' . urlencode($sub_url) . '&subsub_url=' . urlencode($subsub_url); ?>">
        <?php if(!empty($service_image)): ?>
        <meta property="og:image" content="<?php echo $urlmain . 'images/category/' . $service_image; ?>">
        <?php endif; ?>
        
        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : htmlspecialchars($page_title); ?>">
        <?php if(!empty($meta_description)): ?>
        <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php endif; ?>
        <?php if(!empty($service_image)): ?>
        <meta name="twitter:image" content="<?php echo $urlmain . 'images/category/' . $service_image; ?>">
        <?php endif; ?>
        
        <!-- Additional SEO Tags -->
        <meta name="robots" content="index, follow">
        <meta name="author" content="<?php echo $company_website_name; ?>">
        <link rel="canonical" href="<?php echo $urlmain . 'service_detail.php?cat_url=' . urlencode($cat_url) . '&sub_url=' . urlencode($sub_url) . '&subsub_url=' . urlencode($subsub_url); ?>">
        
    <?php else: ?>
        <!-- Fallback to default title -->
        <title><?php echo $page_title; ?> - <?php echo $company_website_name; ?></title>
        <?php include "include/title.php"; ?>
    <?php endif; ?>
    
    <?php include "include/css.php";?> 
    
    <style>
        /* Product Cards Styling */
        .products-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
 
        }
        
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
            border-color: rgba(0,0,0,0.12);
        }
        
        .product-title {
            color: #2c3e50;
            font-size: 1.25rem;
            line-height: 1.4;
        }
        
        .description-content {
            color: #6c757d;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        .description-content p {
            margin-bottom: 0.75rem;
        }
        
        .description-content p:last-child {
            margin-bottom: 0;
        }
        
        .description-content h1, .description-content h2, .description-content h3,
        .description-content h4, .description-content h5, .description-content h6 {
            color: #495057;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
        }
        
        /* Dynamic underlines for headings - Yellow theme */
        .description-content h2,
        .description-content h3,
        .description-content h4 {
            position: relative;
            padding-bottom: 8px;
            margin-bottom: 1rem;
            display: inline-block;
            width: fit-content;
        }
        
        .description-content h2::after,
        .description-content h3::after,
        .description-content h4::after {
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
        .description-content h2:hover::after,
        .description-content h3:hover::after,
        .description-content h4:hover::after {
            background: linear-gradient(90deg, #ff9800 0%, #f57c00 100%);
            transform: scaleY(1.2);
        }
        
        /* Responsive underline adjustments */
        @media (max-width: 768px) {
            .description-content h2::after,
            .description-content h3::after,
            .description-content h4::after {
                height: 2px;
            }
            
            .description-content h2,
            .description-content h3,
            .description-content h4 {
                padding-bottom: 6px;
            }
        }
        
        /* Animation for underline appearance */
        .description-content h2,
        .description-content h3,
        .description-content h4 {
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
        
        .description-content ul, .description-content ol {
            padding-left: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .description-content li {
            margin-bottom: 0.25rem;
        }
        
        .description-content strong, .description-content b {
            color: #495057;
            font-weight: 600;
        }
        
        .description-content a {
            color: #007bff;
            text-decoration: none;
        }
        
        .description-content a:hover {
            text-decoration: underline;
        }
        
        .product-actions .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .product-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.3);
        }
        
        .empty-state {
            padding: 3rem 1rem;
        }
        
        .empty-state i {
            opacity: 0.5;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-card {
                margin-bottom: 1rem;
            }
            
            .products-section {
                padding: 60px 0 !important;
            }
        }
        
        /* Service Tabs Styling */
        .service-tabs-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
            position: sticky;
            top: 20px;
            z-index: 1000;
            margin: 0 20px 30px 20px;
            transition: all 0.3s ease;
        }
        
        .service-tabs-wrapper.sticky {
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 12px;
            margin: 80px;
            position: fixed;
            top: 20px;
            left: 0;
            right: 0;
            max-width: calc(100% - 60px); 
        }
        
        .service-tabs-wrapper.sticky .service-nav-tabs {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Ensure smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Prevent content jump when tabs become sticky */
        body {
            transition: padding-top 0.3s ease;
        }
        
        .service-nav-tabs {
            border: none;
            background: #fff;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
        }
        
        .service-nav-tabs .nav-item {
            flex: 1;
            min-width: 0;
        }
        
        .service-nav-tabs .nav-link {
            border: none;
            background: transparent;
            color: #495057;
            font-weight: 500;
            font-size: 14px;
            padding: 16px 12px;
            text-align: center;
            border-radius: 0;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
            box-shadow: none;
        }
        
        .service-nav-tabs .nav-link:hover {
            background: linear-gradient(180deg, #ecf0f1 0%, #bdc3c7 100%);
            color: #2c3e50;
        }
        
        .service-nav-tabs .nav-link.active {
            background: linear-gradient(1deg, #f1a01c 0%, #fff9f9 101%, #ffffff 26%);
            color: #000;
            font-weight: 600;
            border: none;
            box-shadow: inset 0 1px 3px rgba(255,255,255,0.3);
        }
        
        .service-nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #1a252f;
        }
        
        /* Highlight active product section */
        .product-card {
            scroll-margin-top: 140px; /* Increased margin to prevent overlap with sticky tabs */
        }
        
        .product-card.highlighted {
            animation: highlightCard 0.5s ease-in-out;
        }
        
        @keyframes highlightCard {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
            100% { transform: scale(1); }
        }
        
        .tab-content-wrapper {
            background: #fff;
            min-height: 200px;
        }
        
        .tab-title {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .tab-description {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 0;
        }
        
        /* Mobile responsive for tabs */
        @media (max-width: 768px) {
            .service-nav-tabs {
                flex-direction: column;
            }
            
            .service-nav-tabs .nav-item {
                flex: none;
            }
            
            .service-nav-tabs .nav-link {
                text-align: left;
                padding: 14px 16px;
                border-bottom: 1px solid #e9ecef;
            }
            
            .service-nav-tabs .nav-link.active::after {
                display: none;
            }
        }
        
        strong { 
            font-weight: 400;
        }

        .product-title{
            font-size: 17px;
            font-weight: 400 !important;
        }
        .product-description h2{
            font-size: 19px;
            font-weight: 500;
            color: #2c3e50;
        }
        .product-description h3{
            font-size: 17px;
            font-weight: 500;
            color: #2c3e50;
        }
        .product-description h4{
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
        }
        
        /* Add checkmark to list items in description content */
        .description-content ul li {
            position: relative;
            padding-left: 25px;
        }
        
        .description-content ul li::before {
            content: "✅";
            position: absolute;
            left: 0;
            top: 0;
            font-size: 14px;
        }
        
        .description-content ol li {
            position: relative;
            padding-left: 25px;
        }
        
        .description-content ol li::before {
            content: "✅";
            position: absolute;
            left: 0;
            top: 0;
            font-size: 14px;
        }
        .aaxxd .description-content .description-content h2 ::before {
    width: 100%;
    height: 10px;
    content: "";
    background: #f99e0a;
    position: absolute;
    bottom: 0;
    left: 0;
    clip-path: polygon(0 0, 100% 50%, 100% 100%, 0% 100%);
}

        /* Price Display Styling */
        .price-display {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }
        
        .price-display::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
        }
        
        .price-container {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .main-price {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
        }
        
        .offer-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e74c3c;
            text-decoration: line-through;
            opacity: 0.7;
        }
        
        .price-note {
            font-size: 0.9rem;
            color: #6c757d;
            font-style: italic;
            margin-left: auto;
        }
        
        .price-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .currency-symbol {
            font-size: 1.2rem;
            vertical-align: top;
            margin-right: 2px;
        }
        
        /* Mobile responsive for price display */
        @media (max-width: 768px) {
            .price-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .main-price {
                font-size: 1.75rem;
            }
            
            .offer-price {
                font-size: 1.25rem;
            }
            
            .price-note {
                margin-left: 0;
                margin-top: 5px;
            }
        }
        
        /* Compact Price Display for Product Cards */
        .product-price-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            position: relative;
            overflow: hidden;
        }
        
        .product-price-display::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
        }
        
        .product-price-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .product-main-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
        }
        
        .product-offer-price {
            font-size: 1.1rem;
            font-weight: 600;
            color: #e74c3c;
            text-decoration: line-through;
            opacity: 0.7;
        }
        
        .product-discount-badge {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .product-price-note {
            font-size: 0.8rem;
            color: #6c757d;
            font-style: italic;
            margin-left: auto;
        }
        
        /* Mobile responsive for product price display */
        @media (max-width: 768px) {
            .product-price-container {
                flex-direction: row;
                align-items: center;
                gap: 8px;
            }
            
            .product-main-price {
                font-size: 1.3rem;
            }
            
            .product-offer-price {
                font-size: 1rem;
            }
            
            .product-price-note {
                margin-left: 0;
                margin-top: 5px;
                width: 100%;
            }
        }
    </style>

</head>

<body>

     

   
   <?php include "include/header.php";?> 

   <?php if(mysqli_num_rows($sub_subcategory_result) > 0) { ?>
   <section class=" " style="padding: 38px 0;     background-color: #fc9d0b78;">
        <div class="container">
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="banner-content wow fadeInUp" data-wow-delay="0.3">
                            <nav aria-label="breadcrumb" style="padding-bottom: 10px;">
                                <ol class="breadcrumb" style="font-size: 12px;">
                                    <li class="breadcrumb-item"><a href="<?php echo $urlmain; ?>" class="text-black">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#" class="text-black"><?php echo $category_name; ?></a></li>
                                    <li class="breadcrumb-item"><a href="#" class="text-black"><?php echo $subcategory_name; ?></a></li>
                                    <li class="breadcrumb-item active text-black" aria-current="page"><?php echo $service_data['sub_subcategory_name']; ?></li>
                                </ol>
                            </nav>
                            <h1 style="  padding-bottom: 10px;  font-size: 30px; 
    font-weight: 500;" class="text-black display-5 mb-2"><?php echo $service_data['sub_subcategory_name']; ?></h1>
                            <?php if(!empty($service_data['content'])) { ?>
                                <div class="text-black"><?php echo $service_data['content']; ?></div>
                            <?php } else { ?>
                                <P style="    font-size: 14px;" class="text-black">Professional <?php echo $service_data['sub_subcategory_name']; ?> services to help your business grow and succeed.</P>
                            <?php } ?>
                            
                           
                        </div>
                        <div class="banner-form-tab-six">
                            <ul class="nav" style="    margin-top: 28px;">
                                <li>
                                    <a href="<?php echo $urlmain;?>contact/" class="nav-link" >
                                        <i class="fa-solid fa-plane-up me-2"></i>Contact Now 
                                    </a>
                                </li>
                                 
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="banner-form card mb-0 glass-effect">
                            <div class="card-body">
                                <div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade  active show inq" id="flight"> 
                                          <form id="serviceInquiryForm" action="<?php echo $urlmain;?>inquiry-handler.php" method="POST">
                                          <!-- Honeypot field for spam protection (hidden) -->
                                          <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
                                          <input type="hidden" name="source" value="service_detail">
                                          <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?>">
                                          <input type="hidden" name="service_category" value="<?php echo htmlspecialchars($category_name . ' > ' . $subcategory_name); ?>">
                                          
                                          <div class="  mb-3">
                                          <?php if($has_price_data) { ?>
                            <!-- Price Display Section -->
                            <div class="price-display">
                                <div class="price-container">
                                    <?php if(!empty($main_price)) { ?>
                                        <div class="main-price">
                                            <span class="currency-symbol">₹</span><?php echo htmlspecialchars($main_price); ?>
                                        </div>
                                    <?php } ?>
                                    
                                    <?php if(!empty($offer_price) && $offer_price != $main_price) { ?>
                                        <div class="offer-price">
                                            <span class="currency-symbol">₹</span><?php echo htmlspecialchars($offer_price); ?>
                                        </div>
                                        <div class="price-badge">Best Offer</div>
                                    <?php } ?>
                                    
                                    <?php if(!empty($price_note)) { ?>
                                        <div class="price-note">
                                            <?php echo htmlspecialchars($price_note); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <h5 class="mb-1" style="color: #000;">Get Started!</h5>
                            <p style="   color: #000; font-size: 13px;">Fill out the form below and we'll get back to you soon!</p>
                                                        </div>
                        
                       
                                                                    <div class="row">
                       	<div class="col-md-6">
                       		   <div class="mb-2">
                            <div class="input-icon">
                                <span class="input-icon-addon">
									<i class="isax isax-user"></i>
                                </span>
                                <input type="text" name="first_name" class="form-control form-control-lg" placeholder="First Name" required>
                            </div>
                        </div>
                    </div>
                       		<div class="col-md-6">
                       		  <div class="mb-2">
                           <div class="input-icon">
                                <span class="input-icon-addon">
									<i class="isax isax-call"></i>
                                </span>
                                <input type="tel" name="phone" class="form-control form-control-lg" placeholder="Phone Number">
                            </div>
                        </div>
                    </div>
                       		<div class="col-md-12">
                       		   <div class="mb-2">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
									<i class="isax isax-message"></i>
                                </span>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Your Email Address" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                       		   <div class="mb-2">
                            <label class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Tell us about your requirements..." required minlength="5"></textarea>
                        </div>
                    </div>
                       		 
                        
                                                                            </div>
                     
                        
                        
                        <div id="serviceFormMessage" class="mb-3" style="display:none;"></div>
                        
                        <div class="mb-3">
                            <button type="submit" id="serviceSubmitBtn" class="btn btn-xl btn-primary d-flex align-items-center justify-content-center w-100">
                                <span class="btn-text">Submit Now</span>
                                <span class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                                <i class="isax isax-arrow-right-3 ms-2 btn-icon"></i>
                            </button>
                        </div>
                       
                       
                                            </form>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        @media (max-width: 768px) {
  .service-tabs-wrapper {
    display: none !important;
  }
}
     </style>
    
                            <!-- Products Section -->
                            <?php if(!empty($products)) { ?>
                            <section class="products-section" style="padding: 80px 0; background: #f8f9fa;">
                                <div class="container">
                            <!--- here make nav bar tabs  of   of service1--> 
                            <div class="service-tabs-wrapper mb-5" >
                                <div class="service-tabs-nav">
                                    <ul class="nav nav-tabs service-nav-tabs" id="serviceTabs" role="tablist">
                                    <?php foreach($products as $index => $product) { ?>
                                        <li class="nav-item" role="presentation">
                                            <button style="width: 100%;" class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                    id="product-<?php echo $index; ?>-tab" 
                                                    data-product-id="<?php echo $index; ?>" 
                                                    type="button" role="tab" 
                                                    aria-controls="product-<?php echo $index; ?>" 
                                                    aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                                <?php echo htmlspecialchars($product['product_name']); ?>
                                            </button>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                                
                                
                            </div>
                            
                            <!-- Spacer to ensure proper spacing from sticky tabs -->
                            <div class="tabs-spacer" style="height: 30px; background: transparent;"></div>
                                    
                                    <div class="row g-4">
                                        <?php foreach($products as $index => $product) { ?>
                                        <div class="col-lg-12 col-md-12" id="product-<?php echo $index; ?>">
                                            <div class="  aaxxd h-100   rounded-3 shadow-sm border-0 overflow-hidden">
                                                <div class="  p-4">
                                                    <div class="product-header mb-3">
                                                        <h4 class="product-title fw-bold text-dark mb-2">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h4>
                                                    </div>
                                                    
                                                    <div class="product-description mb-4">
                                                        <?php if(!empty($product['description'])) { ?>
                                                            <div class="description-content">
                                                                <?php echo $product['description']; ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <p class="text-muted mb-0">Professional <?php echo htmlspecialchars($product['product_name']); ?> service with expert guidance and support.</p>
                                                        <?php } ?>
                                                    </div>
                                                    
                                                    <?php if($product['has_product_price'] || $has_price_data) { ?>
                                                    <!-- Product Price Display -->
                                                    <div class="product-price-display">
                                                        <div class="product-price-container">
                                                            <?php 
                                                            // Use product-specific prices if available, otherwise fall back to service prices
                                                            $display_main_price = !empty($product['clean_mrp']) ? $product['clean_mrp'] : $main_price;
                                                            $display_offer_price = !empty($product['clean_offer_amount']) ? $product['clean_offer_amount'] : $offer_price;
                                                            $display_discount = !empty($product['clean_offer']) ? $product['clean_offer'] : '';
                                                            $display_price_note = $price_note; // Use service-level price note
                                                            ?>
                                                            
                                                            <?php if(!empty($display_main_price)) { ?>
                                                                <div class="product-main-price">
                                                                    <span class="currency-symbol">₹</span><?php echo htmlspecialchars($display_main_price); ?>
                                                                </div>
                                                            <?php } ?>
                                                            
                                                            <?php if(!empty($display_offer_price) && $display_offer_price != $display_main_price) { ?>
                                                                <div class="product-offer-price">
                                                                    <span class="currency-symbol">₹</span><?php echo htmlspecialchars($display_offer_price); ?>
                                                                </div>
                                                            <?php } ?>
                                                            
                                                            <?php if(!empty($display_discount) && $display_discount > 0) { ?>
                                                                <div class="product-discount-badge">
                                                                    <?php echo htmlspecialchars($display_discount); ?>% OFF
                                                                </div>
                                                            <?php } ?>
                                                            
                                                            <?php if(!empty($display_price_note)) { ?>
                                                                <div class="product-price-note">
                                                                    <?php echo htmlspecialchars($display_price_note); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    
                                    <?php if(count($products) == 0) { ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="isax isax-box-1 text-muted" style="font-size: 4rem;"></i>
                                                    <h4 class="text-muted mt-3">No Services Available</h4>
                                                    <p class="text-muted">Currently there are no services available in this category. Please check back later.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </section>
                            <?php } ?>
     
 
    
    <section class=" " style="    padding: 27px 0;">
    <div class="container">
    <div class="product-cta text-center p-4 bg-light rounded">
                                        <h4 class="mb-3">Ready to Get Started?</h4>
                                        <p class="mb-4">Choose our <?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?> services and take your business to the next level.</p>
                                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                                            <a href="<?php echo $urlmain;?>contact/" class="btn btn-primary btn-lg">Contact Now</a>
                                            
                                        </div>
                                    </div>
                                    </div>
                                    </section>

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

    <?php } ?>
   <?php include "include/footer.php";?> 

  



   <?php include "include/js.php";?> 
    <!-- Jquery JS -->
    
    <script>
        // Sticky tabs functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabsWrapper = document.querySelector('.service-tabs-wrapper');
            const tabsNav = document.querySelector('.service-nav-tabs');
            
            if (tabsWrapper && tabsNav) {
                // Add scroll event listener
                window.addEventListener('scroll', function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const tabsOffset = tabsWrapper.offsetTop;
                    const tabsHeight = tabsWrapper.offsetHeight;
                    
                    if (scrollTop >= tabsOffset - 20) {
                        tabsWrapper.classList.add('sticky');
                        // Add padding to body to prevent content jump
                        document.body.style.paddingTop = tabsHeight + 40 + 'px';
                    } else {
                        tabsWrapper.classList.remove('sticky');
                        document.body.style.paddingTop = '0';
                    }
                });
                
                // Smooth scroll to specific product when clicking on tab links
                const tabLinks = document.querySelectorAll('.service-nav-tabs .nav-link');
                tabLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        // Remove active class from all tabs
                        tabLinks.forEach(tab => tab.classList.remove('active'));
                        // Add active class to clicked tab
                        this.classList.add('active');
                        
                        // Get the product ID from the clicked tab
                        const productId = this.getAttribute('data-product-id');
                        const targetProduct = document.getElementById('product-' + productId);
                        
                        if (targetProduct) {
                            // Calculate scroll position with proper spacing from sticky tabs
                            const tabsHeight = tabsWrapper.offsetHeight;
                            const extraSpacing = 120; // Increased spacing for better visibility
                            const offsetTop = targetProduct.offsetTop - tabsHeight - extraSpacing;
                            
                            // Smooth scroll to the specific product
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                            
                            // Add highlight effect after scroll completes
                            setTimeout(() => {
                                // Remove highlight from all products
                                document.querySelectorAll('.product-card').forEach(card => {
                                    card.classList.remove('highlighted');
                                });
                                
                                // Add highlight to target product
                                const targetCard = targetProduct.querySelector('.product-card');
                                if (targetCard) {
                                    targetCard.classList.add('highlighted');
                                }
                            }, 800); // Wait for scroll to complete
                        }
                    });
                });
            }
        });
        
        // Service Inquiry Form Handler
        $('#serviceInquiryForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $('#serviceSubmitBtn');
            const $btnText = $submitBtn.find('.btn-text');
            const $spinner = $submitBtn.find('.spinner-border');
            const $btnIcon = $submitBtn.find('.btn-icon');
            const $message = $('#serviceFormMessage');
            
            // Basic client-side validation
            const firstName = $form.find('[name="first_name"]').val().trim();
            const email = $form.find('[name="email"]').val().trim();
            const message = $form.find('[name="message"]').val().trim();
            
            if (!firstName || !email || !message) {
                $message.removeClass('alert-success').addClass('alert alert-danger')
                       .html('<i class="fas fa-exclamation-triangle me-2"></i>Please fill in all required fields.')
                       .show();
                return;
            }
            
            if (message.length < 5) {
                $message.removeClass('alert-success').addClass('alert alert-danger')
                       .html('<i class="fas fa-exclamation-triangle me-2"></i>Message must be at least 5 characters long.')
                       .show();
                return;
            }
            
            // Show loading state
            $submitBtn.prop('disabled', true);
            $btnText.text('Sending...');
            $spinner.show();
            $btnIcon.hide();
            $message.hide();
            
            // Submit form via AJAX
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $message.removeClass('alert-danger').addClass('alert alert-success')
                               .html('<i class="fas fa-check-circle me-2"></i>' + response.message)
                               .show();
                        $form[0].reset(); // Clear form
                    } else {
                        let errorMsg = response.message;
                        if (response.errors && response.errors.length > 0) {
                            errorMsg += '<ul class="mb-0 mt-2">';
                            response.errors.forEach(function(error) {
                                errorMsg += '<li>' + error + '</li>';
                            });
                            errorMsg += '</ul>';
                        }
                        $message.removeClass('alert-success').addClass('alert alert-danger')
                               .html('<i class="fas fa-exclamation-triangle me-2"></i>' + errorMsg)
                               .show();
                    }
                },
                error: function(xhr, status, error) {
                    $message.removeClass('alert-success').addClass('alert alert-danger')
                           .html('<i class="fas fa-exclamation-triangle me-2"></i>An error occurred while sending your inquiry. Please try again.')
                           .show();
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false);
                    $btnText.text('Submit Now');
                    $spinner.hide();
                    $btnIcon.show();
                }
            });
        });
    </script>
    
     

</body>

</html>