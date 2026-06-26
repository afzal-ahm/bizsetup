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
                         WHERE ssc.sub_subcategory_id = '".mysqli_real_escape_string($conn, $subsub_url)."' AND ssc.status = 1";
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
    $service_name = $service_data['sub_subcategory_name'];
    $category_name = $service_data['category_name'];
    $subcategory_name = $service_data['subcategory_name'];
    
    // Extract SEO data from service_data
    $seo_title = isset($service_data['seo_title']) && !empty(trim($service_data['seo_title'])) ? $service_data['seo_title'] : '';
    $seo_keywords = isset($service_data['seo_keywords']) && !empty(trim($service_data['seo_keywords'])) ? $service_data['seo_keywords'] : '';
    $meta_description = isset($service_data['meta_description']) && !empty(trim($service_data['meta_description'])) ? $service_data['meta_description'] : '';
    $service_image = isset($service_data['image']) && !empty(trim($service_data['image'])) ? $service_data['image'] : '';
    
    // Extract price data from service_data
    $main_price = isset($service_data['extra']) && !empty(trim($service_data['extra'])) ? trim($service_data['extra']) : '';
    $price_note = isset($service_data['meal']) && !empty(trim($service_data['meal'])) ? trim($service_data['meal']) : '';
    
    // Custom Standard and Premium Prices with fallback
    $standard_price = !empty($service_data['price']) ? trim($service_data['price']) : (is_numeric($main_price) ? (intval($main_price) + 3000) : '');
    $premium_price = !empty($service_data['day']) ? trim($service_data['day']) : (is_numeric($main_price) ? (intval($main_price) + 6000) : '');

    // Features JSON parsing
    $pricing_features_json = isset($service_data['pricing_features']) ? $service_data['pricing_features'] : '';
    $features_list = [];
    if (!empty($pricing_features_json)) {
        $features_list = json_decode($pricing_features_json, true);
    }
    if (!is_array($features_list)) {
        $features_list = [];
    }
    
    // Set page-level override variables for include/title.php
    $page_title = !empty($seo_title) ? $seo_title : $service_name . ' - ' . $company_website_name;
    $page_description = !empty($meta_description) ? $meta_description : 'Get professional consultation, pricing, and compliance requirements for ' . $service_name . ' in India with BizSetup.';
    $page_keywords = !empty($seo_keywords) ? $seo_keywords : $service_name . ', compliance, registration, tax returns';
    
    // Check if we have price data and card is active
    $show_pricing = isset($service_data['show_pricing']) ? intval($service_data['show_pricing']) : 1;
    $has_price_data = ($show_pricing == 1) && (!empty($main_price));
    
} else {
    $service_name = "Service Not Found";
    $category_name = "";
    $subcategory_name = "";
    $page_title = "Service Not Found - " . $company_website_name;
    $page_description = "The requested business registration or compliance service could not be found. Contact BizSetup for assistance.";
    $page_keywords = "service not found, business setup help";
    $service_image = '';
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
    
    <?php include "include/title.php"; ?>
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($display_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($display_description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $urlmain . 'service_detail.php?cat_url=' . urlencode($cat_url) . '&sub_url=' . urlencode($sub_url) . '&subsub_url=' . urlencode($subsub_url); ?>">
    <?php if(!empty($service_image)): ?>
    <meta property="og:image" content="<?php echo $urlmain . 'images/category/' . $service_image; ?>">
    <?php endif; ?>
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($display_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($display_description); ?>">
    <?php if(!empty($service_image)): ?>
    <meta name="twitter:image" content="<?php echo $urlmain . 'images/category/' . $service_image; ?>">
    <?php endif; ?>
    
    <!-- Additional SEO Tags -->
    <meta name="author" content="<?php echo $company_website_name; ?>">
    <link rel="canonical" href="<?php echo $urlmain . 'service_detail.php?cat_url=' . urlencode($cat_url) . '&sub_url=' . urlencode($sub_url) . '&subsub_url=' . urlencode($subsub_url); ?>">
    
    <?php include "include/css.php";?> 
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-blue: #1c4c82;
            --accent-orange: #f18d2d;
            --accent-orange-hover: #e07b1d;
            --text-gray: #475569;
            --text-dark: #1e293b;
            --bg-light: #f8fafc;
            --bg-pale-gradient: linear-gradient(135deg, #f0f6fa 0%, #ffffff 100%);
            --font-poppins: 'Poppins', 'Segoe UI', Roboto, sans-serif;
        }

        body {
            font-family: var(--font-poppins);
            color: var(--text-dark);
            background-color: #ffffff;
            transition: padding-top 0.3s ease;
        }

        /* Prevent content jump when tabs become sticky */
        html {
            scroll-behavior: smooth;
        }

        /* Hero Section Styling */
        .hero-section-custom {
            padding: 50px 0;
            background: var(--bg-pale-gradient);
            border-bottom: 1px solid rgba(28, 76, 130, 0.05);
            position: relative;
        }

        .hero-section-custom .breadcrumb {
            font-size: 13px;
            padding-bottom: 10px;
            background: transparent;
            margin: 0;
        }
        
        .hero-section-custom .breadcrumb-item a {
            color: var(--text-gray);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .hero-section-custom .breadcrumb-item a:hover {
            color: var(--accent-orange);
        }
        
        .hero-section-custom .breadcrumb-item.active {
            color: var(--primary-blue);
            font-weight: 500;
        }

        .hero-title {
            color: var(--primary-blue);
            font-size: 38px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            color: var(--text-gray);
            font-size: 16px;
            line-height: 1.65;
            margin-bottom: 25px;
        }

        /* Green circular checkmarks */
        .hero-features-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }

        .hero-features-list li {
            position: relative;
            padding-left: 32px;
            margin-bottom: 14px;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            line-height: 1.4;
            display: flex;
            align-items: center;
        }

        .hero-features-list li::before {
            content: "\f058"; /* FontAwesome circle-check */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #22c55e;
            font-size: 20px;
        }

        /* Social ratings */
        .hero-ratings-row {
            display: flex;
            gap: 30px;
            align-items: center;
            border-top: 1px solid rgba(28, 76, 130, 0.1);
            padding-top: 20px;
            flex-wrap: wrap;
        }

        .rating-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rating-logo {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary-blue);
        }
        
        .rating-logo.google {
            color: #4285F4;
        }
        
        .rating-logo.mouthshut {
            color: #e74c3c;
        }

        .rating-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .rating-header-text {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-stars {
            display: flex;
            gap: 2px;
            color: #fe9c28;
            font-size: 12px;
        }

        .rating-count {
            font-size: 12px;
            color: var(--text-gray);
        }

        /* Inquiry Form Card */
        .hero-form-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(28, 76, 130, 0.08);
            border: 1px solid rgba(28, 76, 130, 0.05);
            padding: 30px;
        }

        .hero-form-card h5 {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-blue);
            text-align: center;
            line-height: 1.4;
            margin-bottom: 6px;
        }

        .hero-form-card p {
            font-size: 13px;
            color: var(--text-gray);
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label-custom {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control-custom {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            font-size: 14px;
            color: var(--text-dark);
            background-color: #f8fafc;
            transition: all 0.2s ease;
            width: 100%;
        }

        .form-control-custom:focus {
            border-color: var(--primary-blue);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(28, 76, 130, 0.1);
            outline: none;
        }

        .input-group-phone {
            display: flex;
            align-items: center;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            overflow: hidden;
            transition: all 0.2s ease;
            width: 100%;
        }

        .input-group-phone:focus-within {
            border-color: var(--primary-blue);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(28, 76, 130, 0.1);
        }

        .input-group-phone select {
            border: none;
            background: transparent;
            padding: 12px 28px 12px 12px;
            font-size: 14px;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            border-right: 1px solid #cbd5e1;
            font-family: var(--font-poppins);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 14px;
        }

        .input-group-phone input[type="tel"] {
            border: none;
            background: transparent;
            padding: 12px 16px;
            font-size: 14px;
            color: var(--text-dark);
            outline: none;
            flex: 1;
            width: 100%;
            font-family: var(--font-poppins);
        }

        .btn-orange-cta {
            background-color: var(--accent-orange);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(241, 141, 45, 0.2);
            width: 100%;
            cursor: pointer;
        }

        .btn-orange-cta:hover {
            background-color: var(--accent-orange-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(241, 141, 45, 0.3);
        }
        
        .btn-orange-cta:active {
            transform: translateY(0);
        }

        /* What Sets Us Apart Banner */
        .what-sets-us-apart-banner {
            margin-top: 30px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid rgba(28, 76, 130, 0.08);
            padding: 16px 24px;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .stats-title-block {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 14px;
        }

        .stats-title-block i {
            font-size: 16px;
            color: #22c55e;
        }

        .stat-box {
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .stat-number {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-gray);
            font-weight: 500;
        }

        /* Pricing Section styling */
        .pricing-section {
            background-color: #f8fafc;
            padding: 60px 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .pricing-main-title {
            color: var(--primary-blue);
            font-size: 28px;
            font-weight: 700;
        }

        .pricing-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            position: relative;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: rgba(28, 76, 130, 0.15);
        }

        .pricing-card.popular {
            border-color: var(--accent-orange);
            box-shadow: 0 10px 30px rgba(241, 141, 45, 0.08);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--accent-orange);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 30px;
            letter-spacing: 0.5px;
        }

        .card-badge {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-gray);
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .pricing-card.popular .card-badge {
            color: var(--accent-orange);
        }

        .pricing-card-header .price {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-blue);
            line-height: 1;
            margin-bottom: 6px;
        }

        .pricing-card-header .price .currency {
            font-size: 22px;
            vertical-align: top;
            margin-right: 2px;
        }

        .price-subtext {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 25px;
        }

        .pricing-card-body {
            margin-bottom: 30px;
            flex-grow: 1;
        }

        .features-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 16px;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .features-list li {
            font-size: 14px;
            color: var(--text-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .features-list li.disabled {
            color: #94a3b8;
        }

        .features-list li .check-icon {
            color: #22c55e;
            font-size: 14px;
            width: 16px;
        }

        .features-list li .cross-icon {
            color: #cbd5e1;
            font-size: 14px;
            width: 16px;
        }

        /* Tab navigation section */
        .service-tabs-wrapper {
            background: #ffffff;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            padding: 6px;
            overflow: hidden;
            position: sticky;
            top: 70px;
            z-index: 999;
            transition: all 0.3s ease;
            margin-bottom: 30px !important;
        }

        .service-tabs-wrapper.sticky {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-radius: 30px;
            max-width: 1200px;
            margin: 0 auto 30px auto;
            position: fixed;
            top: 70px;
            left: 20px;
            right: 20px;
        }

        .service-nav-tabs {
            border: none;
            background: transparent;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            gap: 6px;
            padding: 0;
            margin: 0;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .service-nav-tabs::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .service-nav-tabs {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        .service-nav-tabs .nav-item {
            flex: 0 0 auto;
        }

        .service-nav-tabs .nav-link {
            border: none !important;
            background: transparent;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .service-nav-tabs .nav-link:hover {
            background: #f1f5f9;
            color: var(--primary-blue);
        }

        .service-nav-tabs .nav-link.active {
            background: var(--accent-orange) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(241, 141, 45, 0.25);
        }

        /* Main layout section */
        .content-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 35px;
            margin-bottom: 30px;
            scroll-margin-top: 100px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        }
        
        .content-section-title {
            color: var(--primary-blue);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 12px;
        }
        
        .description-content {
            color: var(--text-gray);
            font-size: 15px;
            line-height: 1.7;
        }
        
        .description-content p {
            margin-bottom: 15px;
        }
        
        .description-content h2, .description-content h3, .description-content h4 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-top: 25px;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 0;
            border: none;
        }
        
        .description-content h2::after, .description-content h3::after, .description-content h4::after {
            display: none; /* Remove repeated underlines */
        }
        
        .description-content h2 { font-size: 20px; }
        .description-content h3 { font-size: 18px; }
        .description-content h4 { font-size: 16px; }

        .description-content ul, .description-content ol {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .description-content li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 0;
        }
        
        .description-content ul li::before, .description-content ol li::before {
            display: none; /* Let browser lists render normally */
        }

        .description-content strong, .description-content b {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Sticky Sidebar */
        .sticky-sidebar {
            position: sticky;
            top: 135px;
            z-index: 10;
        }

        .sidebar-form-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(28, 76, 130, 0.04);
            padding: 24px;
        }

        .sidebar-form-card h5 {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-blue);
            text-align: center;
            margin-bottom: 4px;
        }

        .sidebar-form-card p {
            font-size: 13px;
            color: var(--text-gray);
            text-align: center;
            margin-bottom: 20px;
        }

        .form-message-container {
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        /* CTA Section Banner */
        .product-cta-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #0f2d52 100%);
            border-radius: 16px;
            padding: 40px;
            color: #ffffff;
            text-align: center;
            box-shadow: 0 10px 30px rgba(28, 76, 130, 0.15);
        }
        
        .product-cta-custom h4 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .product-cta-custom p {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 24px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-white-cta {
            background: #ffffff;
            color: var(--primary-blue);
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-white-cta:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            color: var(--primary-blue);
        }
        
        .empty-state {
            padding: 3rem 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .hero-title {
                font-size: 30px;
            }
            .sticky-sidebar {
                position: static;
                margin-top: 30px;
            }
            .service-tabs-wrapper.sticky {
                display: none !important; /* hide sticky mobile headers that overlap layout */
            }
        }
    </style>
</head>

<body>

     

   
   <?php include "include/header.php";?> 

   <?php if(mysqli_num_rows($sub_subcategory_result) > 0) { ?>
    <section class="hero-section-custom">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column: Content -->
                <div class="col-lg-7 col-md-12">
                    <div class="banner-content wow fadeInUp" data-wow-delay="0.3s">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $urlmain; ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($category_name); ?></a></li>
                                <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($subcategory_name); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?></li>
                            </ol>
                        </nav>
                        
                        <h1 class="hero-title"><?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?> Registration Online in India</h1>
                        
                        <?php if(!empty($service_data['content'])) { ?>
                            <div class="hero-subtitle"><?php echo $service_data['content']; ?></div>
                        <?php } else { ?>
                            <p class="hero-subtitle">Professional <?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?> services to help your business grow, secure compliance, and succeed.</p>
                        <?php } ?>
                        
                        <!-- Checkmark list -->
                        <ul class="hero-features-list">
                            <li>Company Incorporated in 7–10 Business Days Guaranteed</li>
                            <li>500+ MCA-Certified CA & CS Experts Handle Name Approval & Filing</li>
                            <li>PAN, TAN, DIN, DSC, MoA, AoA & Certificate — All Included</li>
                            <li>Complete Package from ₹<?php echo htmlspecialchars($main_price); ?> + Govt. Fees — Zero Hidden Charges</li>
                            <li>Trusted by 50,000+ Startups & Entrepreneurs Across India</li>
                        </ul>
                        
                        <!-- Social Ratings Row -->
                        <div class="hero-ratings-row">
                            <div class="rating-item">
                                <div class="rating-logo google"><i class="fab fa-google"></i></div>
                                <div class="rating-content">
                                    <div class="rating-header-text">4.6 out of 5</div>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span class="rating-count">(5000+ reviews)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-item">
                                <div class="rating-logo mouthshut"><i class="fas fa-bullhorn"></i></div>
                                <div class="rating-content">
                                    <div class="rating-header-text">4.7 out of 5</div>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span class="rating-count">(2453+ reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form Card -->
                <div class="col-lg-5 col-md-12 mt-5 mt-lg-0">
                    <div class="hero-form-card wow fadeInRight" data-wow-delay="0.3s">
                        <h5>Enter your details to receive a full quote and consultation</h5>
                        <p>Fill out the form below and we'll get back to you soon!</p>
                        
                        <form class="inquiry-form-submit" action="<?php echo $urlmain;?>inquiry-handler.php" method="POST">
                            <!-- Honeypot field for spam protection (hidden) -->
                            <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
                            <input type="hidden" name="source" value="service_detail_hero">
                            <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?>">
                            <input type="hidden" name="service_category" value="<?php echo htmlspecialchars($category_name . ' > ' . $subcategory_name); ?>">
                            
                            <div class="mb-3">
                                <label class="form-label-custom">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control-custom" placeholder="Enter Your First Name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-custom">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group-phone">
                                    <select name="country_code">
                                        <option value="+91">+91 (IN)</option>
                                        <option value="+1">+1 (US)</option>
                                        <option value="+44">+44 (UK)</option>
                                    </select>
                                    <input type="tel" name="phone" placeholder="Enter Your Phone Number" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control-custom" placeholder="Your Email Address" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-custom">Message / Requirements <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control-custom" rows="3" placeholder="Tell us about your requirements..." required minlength="5"></textarea>
                            </div>
                            
                            <div class="form-message-container" style="display:none;"></div>
                            
                            <button type="submit" class="btn-orange-cta d-flex align-items-center justify-content-center">
                                <span class="btn-text">Claim Your Free Consultation</span>
                                <span class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                                <i class="fas fa-arrow-right ms-2 btn-icon"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bottom Stats Banner -->
            <div class="what-sets-us-apart-banner wow fadeInUp" data-wow-delay="0.5s">
                <div class="stats-container">
                    <div class="stats-title-block">
                        <i class="fas fa-shield-alt"></i>
                        <span>What Sets Us Apart:</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">MCA Certified Experts</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">20,000+</span>
                        <span class="stat-label">Genuine Customer Reviews</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">50,000+</span>
                        <span class="stat-label">Businesses Served Pan-India</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Real-Time App-based Monitoring</span>
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
                            
                            <!-- 3-Tier Pricing Section -->
                            <?php if($has_price_data) { 
                                if (!function_exists('renderFeatures')) {
                                    function renderFeatures($features, $tier) {
                                        if (!empty($features)) {
                                            foreach ($features as $f) {
                                                $isEnabled = isset($f[$tier]) && $f[$tier] == 1;
                                                if ($isEnabled) {
                                                    echo '<li><i class="fas fa-check check-icon"></i> ' . htmlspecialchars($f['text']) . '</li>';
                                                } else {
                                                    echo '<li class="disabled"><i class="fas fa-times cross-icon"></i> ' . htmlspecialchars($f['text']) . '</li>';
                                                }
                                            }
                                        } else {
                                            // Fallback to defaults
                                            if ($tier == 'basic') {
                                                echo '<li><i class="fas fa-check check-icon"></i> 1 DSC (Digital Signature)</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> 1 DIN (Director Identification)</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> Name Reservation filing</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> SPICe+ Form Preparation</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> MOA & AOA Drafting</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> PAN & TAN Allotment</li>';
                                                echo '<li class="disabled"><i class="fas fa-times cross-icon"></i> GST Registration</li>';
                                                echo '<li class="disabled"><i class="fas fa-times cross-icon"></i> MSME (Udyam) Certificate</li>';
                                                echo '<li class="disabled"><i class="fas fa-times cross-icon"></i> PF & ESIC Registration</li>';
                                            } elseif ($tier == 'standard') {
                                                echo '<li><i class="fas fa-check check-icon"></i> 2 DSC (Digital Signatures)</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> 2 DIN (Director Identifications)</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> Name Reservation filing</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> SPICe+ Form Preparation</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> MOA & AOA Drafting</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> PAN & TAN Allotment</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> GST Registration</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> MSME (Udyam) Certificate</li>';
                                                echo '<li class="disabled"><i class="fas fa-times cross-icon"></i> PF & ESIC Registration</li>';
                                            } else {
                                                echo '<li><i class="fas fa-check check-icon"></i> 2 DSC (Digital Signatures)</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> 2 DIN (Director Identifications)</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> Name Reservation filing</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> SPICe+ Form Preparation</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> MOA & AOA Drafting</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> PAN & TAN Allotment</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> GST Registration</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> MSME (Udyam) Certificate</li>';
                                                echo '<li><i class="fas fa-check check-icon"></i> PF & ESIC Registration</li>';
                                            }
                                        }
                                    }
                                }
                            ?>
                            <section class="pricing-section">
                                <div class="container">
                                    <div class="text-center mb-5">
                                        <h2 class="pricing-main-title mb-2">Choose the Best Plan for Your Business</h2>
                                        <p class="text-muted">Register your business seamlessly with CA-assisted execution plans</p>
                                    </div>
                                    
                                    <div class="row g-4 justify-content-center">
                                        <!-- Basic Plan -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="pricing-card basic">
                                                <div class="card-badge">Basic Plan</div>
                                                <div class="pricing-card-header">
                                                    <div class="price">
                                                        <span class="currency">₹</span><?php echo htmlspecialchars($main_price); ?>
                                                    </div>
                                                    <div class="price-subtext"><?php echo !empty($price_note) ? htmlspecialchars($price_note) : '+ Govt Fees Extra'; ?></div>
                                                </div>
                                                <div class="pricing-card-body">
                                                    <p class="features-title">What you'll get:</p>
                                                    <ul class="features-list">
                                                        <?php renderFeatures($features_list, 'basic'); ?>
                                                    </ul>
                                                </div>
                                                <div class="pricing-card-footer mt-auto">
                                                    <button type="button" class="btn-orange-cta scroll-to-form-btn">Get Started</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Standard Plan -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="pricing-card standard popular">
                                                <div class="popular-badge">Most Popular</div>
                                                <div class="card-badge">Standard Plan</div>
                                                <div class="pricing-card-header">
                                                    <div class="price">
                                                        <span class="currency">₹</span><?php echo htmlspecialchars($standard_price); ?>
                                                    </div>
                                                    <div class="price-subtext"><?php echo !empty($price_note) ? htmlspecialchars($price_note) : '+ Govt Fees Extra'; ?></div>
                                                </div>
                                                <div class="pricing-card-body">
                                                    <p class="features-title">What you'll get:</p>
                                                    <ul class="features-list">
                                                        <?php renderFeatures($features_list, 'standard'); ?>
                                                    </ul>
                                                </div>
                                                <div class="pricing-card-footer mt-auto">
                                                    <button type="button" class="btn-orange-cta scroll-to-form-btn">Get Started</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Premium Plan -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="pricing-card premium">
                                                <div class="card-badge">Premium Plan</div>
                                                <div class="pricing-card-header">
                                                    <div class="price">
                                                        <span class="currency">₹</span><?php echo htmlspecialchars($premium_price); ?>
                                                    </div>
                                                    <div class="price-subtext"><?php echo !empty($price_note) ? htmlspecialchars($price_note) : '+ Govt Fees Extra'; ?></div>
                                                </div>
                                                <div class="pricing-card-body">
                                                    <p class="features-title">What you'll get:</p>
                                                    <ul class="features-list">
                                                        <?php renderFeatures($features_list, 'premium'); ?>
                                                    </ul>
                                                </div>
                                                <div class="pricing-card-footer mt-auto">
                                                    <button type="button" class="btn-orange-cta scroll-to-form-btn">Get Started</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php } ?>

                            <!-- Detailed Content Section -->
                            <section class="details-content-section py-5 bg-white">
                                <div class="container">
                                    <!-- Horizontal Tab Navigation -->
                                    <div class="service-tabs-wrapper">
                                        <div class="service-tabs-nav">
                                            <ul class="nav nav-tabs service-nav-tabs" id="serviceTabs" role="tablist">
                                            <?php foreach($products as $index => $product) { ?>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
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
                                    
                                    <div class="row g-4 g-xl-5">
                                        <!-- Left Column: Content Blocks (70% width) -->
                                        <div class="col-lg-8 col-md-12">
                                            <div class="content-blocks">
                                                <?php foreach($products as $index => $product) { ?>
                                                    <div class="content-section-card" id="product-<?php echo $index; ?>">
                                                        <h2 class="content-section-title">
                                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                                        </h2>
                                                        
                                                        <div class="description-content">
                                                            <?php if(!empty($product['description'])) { ?>
                                                                <?php echo $product['description']; ?>
                                                            <?php } else { ?>
                                                                <p>Professional <?php echo htmlspecialchars($product['product_name']); ?> details with dedicated experts handling documentation, registrations, and ROC compliance.</p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Column: Sticky Sidebar Inquiry Form (30% width) -->
                                        <div class="col-lg-4 col-md-12">
                                            <div class="sticky-sidebar">
                                                <div class="sidebar-form-card">
                                                    <h5>Talk To Our Experts</h5>
                                                    <p>We're Here To Help You</p>
                                                    
                                                    <form class="inquiry-form-submit" action="<?php echo $urlmain;?>inquiry-handler.php" method="POST">
                                                        <!-- Honeypot field for spam protection (hidden) -->
                                                        <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
                                                        <input type="hidden" name="source" value="service_detail_sidebar">
                                                        <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?>">
                                                        <input type="hidden" name="service_category" value="<?php echo htmlspecialchars($category_name . ' > ' . $subcategory_name); ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label-custom">First Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="first_name" class="form-control-custom" placeholder="Enter Your First Name" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label-custom">Phone Number <span class="text-danger">*</span></label>
                                                            <div class="input-group-phone">
                                                                <select name="country_code">
                                                                    <option value="+91">+91 (IN)</option>
                                                                    <option value="+1">+1 (US)</option>
                                                                    <option value="+44">+44 (UK)</option>
                                                                </select>
                                                                <input type="tel" name="phone" placeholder="Enter Your Phone Number" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                                            <input type="email" name="email" class="form-control-custom" placeholder="Your Email Address" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label-custom">Message / Requirements <span class="text-danger">*</span></label>
                                                            <textarea name="message" class="form-control-custom" rows="3" placeholder="Tell us about your requirements..." required minlength="5"></textarea>
                                                        </div>
                                                        
                                                        <div class="form-message-container" style="display:none;"></div>
                                                        
                                                        <button type="submit" class="btn-orange-cta d-flex align-items-center justify-content-center">
                                                            <span class="btn-text">Claim Your Free Consultation</span>
                                                            <span class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                                                            <i class="fas fa-arrow-right ms-2 btn-icon"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php } ?>
     
 
    
    <section class=" " style="    padding: 27px 0;">
    <div class="container">
    <div class="product-cta text-center p-4 bg-light rounded">
                                        <h4 class="mb-3">Ready to Get Started?</h4>
                                        <p class="mb-4">Choose our <?php echo htmlspecialchars($service_data['sub_subcategory_name']); ?> services and take your business to the next level.</p>
                                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                                            <a href="<?php echo $urlmain;?>contact.php" class="btn btn-primary btn-lg">Contact Now</a>
                                            
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
        document.addEventListener('DOMContentLoaded', function() {
            // Sticky tabs scroll state
            const tabsWrapper = document.querySelector('.service-tabs-wrapper');
            const tabsNav = document.querySelector('.service-nav-tabs');
            
            if (tabsWrapper && tabsNav) {
                const tabsOffset = tabsWrapper.offsetTop;
                
                window.addEventListener('scroll', function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const tabsHeight = tabsWrapper.offsetHeight;
                    
                    if (scrollTop >= tabsOffset - 20) {
                        tabsWrapper.classList.add('sticky');
                        // Add padding to body to prevent jump
                        document.body.style.paddingTop = tabsHeight + 30 + 'px';
                    } else {
                        tabsWrapper.classList.remove('sticky');
                        document.body.style.paddingTop = '0';
                    }
                });
                
                // Smooth scroll to specific section on clicking tabs
                const tabLinks = document.querySelectorAll('.service-nav-tabs .nav-link');
                tabLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Remove active class from all tabs
                        tabLinks.forEach(tab => tab.classList.remove('active'));
                        this.classList.add('active');
                        
                        const productId = this.getAttribute('data-product-id');
                        const targetProduct = document.getElementById('product-' + productId);
                        
                        if (targetProduct) {
                            const tabsHeight = tabsWrapper.offsetHeight;
                            const extraSpacing = 90;
                            const offsetTop = targetProduct.offsetTop - tabsHeight - extraSpacing;
                            
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                        }
                    });
                });

                // Scrollspy functionality: highlight navigation links based on scroll position
                window.addEventListener('scroll', function() {
                    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                    const tabsHeight = tabsWrapper.offsetHeight;
                    const extraSpacing = 150;
                    
                    const sections = document.querySelectorAll('.content-section-card');
                    sections.forEach(function(section) {
                        const top = section.offsetTop - tabsHeight - extraSpacing;
                        const bottom = top + section.offsetHeight;
                        
                        if (scrollPosition >= top && scrollPosition < bottom) {
                            const sectionId = section.getAttribute('id');
                            const productId = sectionId.split('-')[1];
                            const activeLink = document.querySelector(`.service-nav-tabs .nav-link[data-product-id="${productId}"]`);
                            
                            if (activeLink) {
                                tabLinks.forEach(tab => tab.classList.remove('active'));
                                activeLink.classList.add('active');
                                
                                // Scroll the tabs nav container if active link is out of view on mobile
                                const rect = activeLink.getBoundingClientRect();
                                const containerRect = tabsNav.getBoundingClientRect();
                                if (rect.left < containerRect.left || rect.right > containerRect.right) {
                                    tabsNav.scrollTo({
                                        left: activeLink.offsetLeft - (containerRect.width / 2) + (rect.width / 2),
                                        behavior: 'smooth'
                                    });
                                }
                            }
                        }
                    });
                });
            }

            // Scroll from pricing "Get Started" buttons to hero form
            const scrollBtns = document.querySelectorAll('.scroll-to-form-btn');
            scrollBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const heroForm = document.querySelector('.hero-form-card');
                    if (heroForm) {
                        const offsetTop = heroForm.getBoundingClientRect().top + window.pageYOffset - 120;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                        
                        // Highlight form inputs briefly
                        setTimeout(() => {
                            const firstInput = heroForm.querySelector('input[name="first_name"]');
                            if (firstInput) {
                                firstInput.focus();
                            }
                        }, 800);
                    }
                });
            });
        });
        
        // Generic AJAX Inquiry Form Submissions for Hero and Sidebar forms
        $(document).on('submit', '.inquiry-form-submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $btnText = $submitBtn.find('.btn-text');
            const $spinner = $submitBtn.find('.spinner-border');
            const $btnIcon = $submitBtn.find('.btn-icon');
            const $message = $form.find('.form-message-container');
            
            const firstName = $form.find('[name="first_name"]').val().trim();
            const email = $form.find('[name="email"]').val().trim();
            const message = $form.find('[name="message"]').val().trim();
            
            if (!firstName || !email || !message) {
                $message.removeClass('alert-success alert-danger').addClass('alert alert-danger')
                       .html('<i class="fas fa-exclamation-triangle me-2"></i>Please fill in all required fields.')
                       .show();
                return;
            }
            
            if (message.length < 5) {
                $message.removeClass('alert-success alert-danger').addClass('alert alert-danger')
                       .html('<i class="fas fa-exclamation-triangle me-2"></i>Message must be at least 5 characters long.')
                       .show();
                return;
            }
            
            // Show loading state
            const originalBtnText = $btnText.text();
            $submitBtn.prop('disabled', true);
            $btnText.text('Sending...');
            $spinner.show();
            if ($btnIcon.length) $btnIcon.hide();
            $message.hide();
            
            // Submit form via AJAX
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $message.removeClass('alert-danger alert-success').addClass('alert alert-success')
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
                        $message.removeClass('alert-success alert-danger').addClass('alert alert-danger')
                               .html('<i class="fas fa-exclamation-triangle me-2"></i>' + errorMsg)
                               .show();
                    }
                },
                error: function(xhr, status, error) {
                    $message.removeClass('alert-success alert-danger').addClass('alert alert-danger')
                           .html('<i class="fas fa-exclamation-triangle me-2"></i>An error occurred while sending your inquiry. Please try again.')
                           .show();
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false);
                    $btnText.text(originalBtnText);
                    $spinner.hide();
                    if ($btnIcon.length) $btnIcon.show();
                }
            });
        });
    </script>
    
     

</body>

</html>