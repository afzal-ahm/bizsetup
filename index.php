<?php 
include "data.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "include/title.php";?> 
   <?php include "include/css.php";?> 
   
    <!-- Search Dropdown CSS -->
    <style>
        .search-section {
            position: relative;
            max-width: 600px;
            margin: 30px auto;
        }
        
        .search-box {
            position: relative;
            width: 100%;
        }
        
        .search-box input[type="text"] {
            width: 100%;
            padding: 15px 60px 15px 20px;
            border: 2px solid #fff;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .search-box input[type="text"]:focus {
            background: #fff;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
            border-color: #007bff;
        }
        
        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
            pointer-events: none;
        }
        
        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 5px;
        }
        
        .search-suggestion-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .search-suggestion-item:hover {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        
        .search-suggestion-item:last-child {
            border-bottom: none;
        }
        
        .suggestion-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            font-size: 15px;
        }
        
        .suggestion-path {
            font-size: 13px;
            color: #666;
            opacity: 0.8;
        }
        
        .no-results {
            padding: 20px;
            text-align: center;
            color: #999;
            font-style: italic;
        }
        
        .loading-indicator {
            padding: 15px 20px;
            text-align: center;
            color: #666;
            font-style: italic;
            background-color: #f8f9fa;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .search-section {
                max-width: 100%;
                margin: 20px auto;
                padding: 0 15px;
            }
            
            .search-box input[type="text"] {
                padding: 12px 50px 12px 15px;
                font-size: 14px;
            }
            
            .search-icon {
                right: 15px;
                font-size: 16px;
            }
            
            .search-suggestion-item {
                padding: 12px 15px;
            }
            
            .suggestion-title {
                font-size: 14px;
            }
            
            .suggestion-path {
                font-size: 12px;
            }
        }

        /* Custom Split Hero Section Style matching Corpbiz.io */
        .hero-section-four-custom {
            padding: 80px 0;
            background: #ffffff;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid #f1f5f9;
        }

        .banner-content-custom {
            padding-right: 30px;
        }

        .hero-title-main {
            font-size: 44px;
            font-weight: 800;
            line-height: 1.25;
            color: #0b2545; /* Dark blue */
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .hero-title-main .highlight-orange {
            color: #f18d2d; /* Accent Orange */
            position: relative;
            display: inline;
        }

        .hero-subtitle-main {
            font-size: 16px;
            line-height: 1.6;
            color: #475569; /* Slate grey */
            margin-bottom: 30px;
        }

        /* Custom Search Box */
        .search-section-custom {
            margin-bottom: 25px;
            max-width: 540px;
        }

        .search-box-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 2px solid #cbd5e1;
            border-radius: 30px;
            padding: 4px 6px 4px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
        }

        .search-box-custom:focus-within {
            border-color: #1c4c82; /* Primary Blue */
            box-shadow: 0 4px 20px rgba(28, 76, 130, 0.08);
        }

        .search-box-custom input[type="text"] {
            border: none;
            background: transparent;
            font-size: 15px;
            color: #1e293b;
            outline: none;
            width: 100%;
            padding: 10px 0;
        }

        .search-btn-custom {
            background-color: #1c4c82; /* Corpbiz dark blue */
            color: #ffffff;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .search-btn-custom:hover {
            background-color: #f18d2d;
            color: #ffffff;
        }

        /* Search Dropdown custom styling positioning */
        .search-box-custom .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            z-index: 9999;
            max-height: 300px;
            overflow-y: auto;
            margin-top: 5px;
        }

        /* Recommended tags */
        .search-tags-custom {
            margin-bottom: 30px;
        }

        .tags-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-pill-btn {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tag-pill-btn:hover {
            background: #e2e8f0;
            color: #0b2545;
            border-color: #cbd5e1;
        }

        /* Trust Rating stars */
        .hero-trust-badges-custom {
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .stars-gold {
            color: #f18d2d;
            font-size: 18px;
            letter-spacing: 1px;
            margin-right: 8px;
        }

        .rating-text {
            font-size: 14px;
            color: #475569;
        }

        .trust-icon {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 4px 12px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
        }

        /* Right side banner image alignment */
        .hero-banner-image-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .hero-banner-gif-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: contain;
        }

        @media (max-width: 991px) {
            .hero-section-four-custom {
                padding: 50px 0;
            }
            .banner-content-custom {
                padding-right: 0;
                margin-bottom: 40px;
                text-align: center;
            }
            .hero-title-main {
                font-size: 32px;
            }
            .search-section-custom {
                margin: 0 auto 25px auto;
            }
            .tags-container {
                justify-content: center;
            }
            .hero-trust-badges-custom .d-flex {
                justify-content: center;
            }
        }
    </style>

</head>

<body>

     

   
   <?php include "include/header.php";?> 

    <!-- Hero Section -->
    <section class="hero-section-four-custom">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column (60% width on large screens) -->
                <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="banner-content-custom">
                        <h1 class="hero-title-main">
                            Start, <span class="highlight-orange">Manage & Grow</span> Your Business With Confidence!
                            <!-- Empower Your Business <span class="highlight-orange">Compliance & Management</span> Made Easy With Us -->
                        </h1>
                        <p class="hero-subtitle-main">
                            Connecting you with top-rated experts to simplify your business registrations, tax filings, legal agreements, and corporate compliance.
                        </p>
                        
                        <div class="search-section-custom">
                            <div class="search-box-custom">
                                <input type="text" id="searchBox" placeholder="Search for services..." autocomplete="off" />
                                <button type="button" class="search-btn-custom">Search</button>
                                <div id="searchDropdown" class="search-dropdown" style="display: none;">
                                  <!-- Dynamic suggestions will be populated here -->
                                </div>
                            </div>
                        </div>

                        <div class="search-tags-custom">
                            <span class="tags-label">RECOMMENDED SERVICES:</span>
                            <div class="tags-container">
                               <?php
                               $ss="SELECT * from  extra_content where type='after_search_content'";
                               $re=mysqli_query($conn,$ss);
                               foreach($re as $key=> $socila){                              ?>
                                   <button class="tag-pill-btn" onclick="document.getElementById('searchBox').value = '<?php echo addslashes($socila['heading1']); ?>'; document.getElementById('searchBox').focus();"><?php echo htmlspecialchars($socila['heading1']);?></button>   
                               <?php } ?>
                            </div>
                        </div>

                        <!-- Trust / Review Badges -->
                        <div class="hero-trust-badges-custom">
                            <div class="d-flex align-items-center flex-wrap gap-3 mt-4">
                                <div class="rating-stars-custom">
                                    <span class="stars-gold">★★★★★</span>
                                    <span class="rating-text">Rated at <strong>4.9</strong> By <strong>42,800+</strong> Customers Globally</span>
                                </div>
                                <div class="trust-logos">
                                    <span class="trust-icon google-trust"><i class="fab fa-google text-primary me-1"></i>Google</span>
                                    <span class="trust-icon fb-trust"><i class="fab fa-facebook-f text-info me-1"></i>Facebook</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (40% width on large screens) -->
                <div class="col-lg-6 col-md-12 wow fadeInRight" data-wow-delay="0.3s">
                    <div class="hero-banner-image-container">
                        <img src="<?php echo $urlmain;?>assets/img/banner/aa.gif" alt="BizSetup Compliance Banner" class="hero-banner-gif-image">
                    </div>
                </div>
            </div>
        </div>
    </section>
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
   

   <section class="section">
        <div class="container">

            <div class="row justify-content-center g-4">

                <!-- Pick-Up & Drop-Off -->

                <?php 
$ss = "SELECT * FROM extra_content WHERE type='3_box_content'";
$re = mysqli_query($conn, $ss);

// Define background classes you want to rotate
$bg_classes = ['bg-secondary', 'bg-purple', 'bg-teal'];

foreach($re as $key => $socila) { 
    // Pick class based on index
    $bg_class = $bg_classes[$key % count($bg_classes)];
?> 
    <div class="col-lg-4 col-md-6 d-flex">
        <div class="card border-0 shadow-none pickup-card <?= $bg_class ?>-100 flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5><?= $socila['heading1']; ?></h5>
                    <span style="    padding: 8px;" class="avatar avatar-lg  <?= $bg_class ?> rounded-circle flex-shrink-0 ms-3">
                         <img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>" alt="Img">
                    </span>
                </div>
                <p>
                    <?= $socila['content']; ?>
                </p>
            </div>
        </div>
    </div>
<?php } ?>

                <!-- /Pick-Up & Drop-Off -->

                 
 

            </div>

         
        </div>
    </section>
    
    <?php
                                $ss="SELECT * from  extra_content where type='long_content' limit 1";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
   <section class="section adavantages-sec bg-light-200">
        <div class="container">
            <div class="row align-items-center">
              
                <div class="col-lg-12">
                    <div>
                        <div class="section-header-six mb-4 wow fadeInUp" data-wow-delay="1.5">
                            <span class="badge badge-soft-primary rounded-pill mb-1"><?php echo $socila['heading1'];?></span>
                            <h2 class="mb-2"><?php echo $socila['heading2'];?></h2>
                            <p><?php echo $socila['content'];?></p>
                        </div>
                        
                      
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?> 

     <section class="section offers-section">
        <div class="offer-sec-bg">
            <img src="assets/img/bg/hotel-bg-02.svg" class="bg-1" alt="Img">
            <img src="assets/img/bg/hotel-bg-04.svg" class="bg-2" alt="Img">
        </div>
        <div class="container">
            <div class="offer-sec">
                <?php
                $ss = "SELECT * from extra_content where type='banner' AND is_active = '1' AND image != '' AND image IS NOT NULL ORDER BY updated_date DESC LIMIT 1";
                $re = mysqli_query($conn, $ss);
                if ($re && mysqli_num_rows($re) > 0) {
                    $socila = mysqli_fetch_assoc($re);
                ?> 
                    <div class="offer-slider-img">
                        <img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>" class="img-fluid w-100" alt="Img">
                    </div>
                <?php } ?>
            </div>
             
            <div class="popular-hotels" style="padding-top: 15px;">
            <?php
                                $ss="SELECT * from  extra_content where type='heading' limit 1  ";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?> 
                <div class="section-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div>
                        <p class="mb-2 fw-medium d-flex align-items-center text-white"><span class="text-bar bg-white"></span><?php echo $socila['heading1'];?></p>
                        <h2 class="text-white"><?php echo $socila['heading2'];?><span class="text-primary">.</span></h2>
                    </div>
                  </div>
                  <?php } ?>
                <style>
                    .service-card-custom {
                        background: #ffffff;
                        border: 1px solid #f1f5f9;
                        border-radius: 16px;
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.025);
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        height: 100%;
                    }
                    .service-card-custom:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 8px 8px -5px rgba(0, 0, 0, 0.04);
                        border-color: rgba(28, 76, 130, 0.2);
                    }
                    .service-card-custom .card-title-custom {
                        color: #0f172a;
                        font-size: 20px;
                        font-weight: 700;
                        line-height: 1.4;
                        margin-bottom: 0;
                    }
                    .service-card-custom .card-text-custom {
                        color: #475569;
                        font-size: 17px;
                        line-height: 1.6;
                        margin-top: 12px;
                    }
                    .icon-container-custom {
                        width: 48px;
                        height: 48px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 20px;
                        flex-shrink: 0;
                    }
                </style>
                
                <?php
                $services = [
                    [
                        'title' => 'Company Registration',
                        'desc' => 'Private Limited Company, OPC & Section 8 Company Registration.',
                        'icon' => 'fas fa-building',
                        'bg' => 'rgba(241, 141, 45, 0.15)',
                        'color' => '#f18d2d',
                        'link' => 'service_detail.php?cat_url=Business-Setup&sub_url=Business-Registration&subsub_url=257'
                    ],
                    [
                        'title' => 'LLP Registration',
                        'desc' => 'Limited Liability Partnership Registration with complete documentation support.',
                        'icon' => 'fas fa-balance-scale',
                        'bg' => 'rgba(16, 185, 129, 0.15)',
                        'color' => '#10b981',
                        'link' => 'service_detail.php?cat_url=Business-Setup&sub_url=Business-Registration&subsub_url=258'
                    ],
                    [
                        'title' => 'GST Registration & Returns',
                        'desc' => 'GST Registration, Return Filing, Amendments & Compliance.',
                        'icon' => 'fas fa-file-invoice-dollar',
                        'bg' => 'rgba(59, 130, 246, 0.15)',
                        'color' => '#3b82f6',
                        'link' => 'service_detail.php?cat_url=Tax-and-Compliances&sub_url=GST&subsub_url=287'
                    ],
                    [
                        'title' => 'ROC Compliance',
                        'desc' => 'Annual Filing, DIR-3 KYC, AOC-4, MGT-7 and MCA Compliances.',
                        'icon' => 'fas fa-clipboard-check',
                        'bg' => 'rgba(139, 92, 246, 0.15)',
                        'color' => '#8b5cf6',
                        'link' => 'service_detail.php?cat_url=Tax-and-Compliances&sub_url=Corporate-Compliance&subsub_url=273'
                    ],
                    [
                        'title' => 'Accounting & Bookkeeping',
                        'desc' => 'Monthly Accounting, Payroll, Financial Statements & MIS Reports.',
                        'icon' => 'fas fa-calculator',
                        'bg' => 'rgba(236, 72, 153, 0.15)',
                        'color' => '#ec4899',
                        'link' => 'service_detail.php?cat_url=Tax-and-Compliances&sub_url=Accounting-and-Tax&subsub_url=276'
                    ],
                    [
                        'title' => 'Income Tax Services',
                        'desc' => 'ITR Filing, Tax Planning, Assessments and Notice Handling.',
                        'icon' => 'fas fa-wallet',
                        'bg' => 'rgba(20, 184, 166, 0.15)',
                        'color' => '#14b8a6',
                        'link' => 'service_detail.php?cat_url=Tax-and-Compliances&sub_url=Accounting-and-Tax&subsub_url=279'
                    ]
                ];
                ?>
                
                <div class="row g-4 justify-content-center mt-2">
                    <?php foreach ($services as $service) { ?>
                        <div class="col-lg-4 col-md-6 d-flex">
                            <a href="<?= $urlmain . $service['link']; ?>" class="d-flex flex-column w-100 text-decoration-none">
                                <div class="card border-0 service-card-custom flex-fill">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <h5 class="card-title-custom"><?= $service['title']; ?></h5>
                                            <span class="icon-container-custom ms-3" style="background-color: <?= $service['bg']; ?>; color: <?= $service['color']; ?>;">
                                                 <i class="<?= $service['icon']; ?>"></i>
                                            </span>
                                        </div>
                                        <p class="card-text-custom">
                                            <?= $service['desc']; ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
 
    <!-- About Section -->

    
    <section class="section about-section-four bg-light-200">
        <div class="container">
            <div class="row">

            <?php
                                $ss="SELECT * from  extra_content where type='heading' limit 1 OFFSET 1";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   


                <div class="col-lg-5 wow fadeInDown" data-wow-delay="0.2s">
                    <div class="section-header section-header-four mb-4">
                        <h2 class="mb-2"><?php echo $socila['heading1'];?> <span><?php echo $socila['heading2'];?></span></h2>
                        <p class="sub-title">At BizSetup, we understand that starting and running a business in India can be a complex journey filled with legal, regulatory, and administrative hurdles.  <br>
Here’s why thousands of entrepreneurs, startups, and businesses choose us over traditional consultants or other platforms:</p>
                    
                    <?php if($socila['link']!='')  { ?>
                    <div class="col-12  wow fadeInUp">
                            <a href="<?php echo $socila['link'];?>" class="btn btn-primary">Know More<i class="isax isax-arrow-right-3 ms-2"></i></a>
                        </div>
                        <?php } ?>
                        </div>
                  <?php } ?>
                    
                </div>
                <div class="col-lg-7 d-flex ps-lg-0 wow zoomIn" data-wow-delay="0.2s">
                    <div class="flight-about d-lg-flex align-items-center flex-fill">
                        <div class="row">
                        <?php
                                $ss="SELECT * from  extra_content where type='why_choose_us' limit 6";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
                        <div class="col-lg-6  mb-1 wow fadeInUp">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>" alt="Img">
                                        <div class="ms-2">
                                            <h6 class="fs-16 mb-2"><?php echo $socila['heading1'];?></h6>
                                            <p><?php echo $socila['heading2'];?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                       
                           
                      
                        
                       
                    </div>
                  
                   
                        <div class="flight-bg">
                            <img src="assets/img/bg/flight-bg.png" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flight-bg">
            <img src="assets/img/bg/flight-bg-01.png" alt="img" class="flight-bg-01">
            <img src="assets/img/bg/flight-bg-02.png" alt="img" class="flight-bg-02">
        </div>
    </section>
    <!-- /About Section -->
      <style>
        .feedback-banner-custom {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            padding: 40px 20px;
            position: relative;
            z-index: 10;
        }
        .feedback-item-custom {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 15px 10px;
        }
        .feedback-icon-container-custom {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 20px;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }
        .feedback-icon-blue {
            background: linear-gradient(135deg, #1c4c82 0%, #0b2545 100%);
            box-shadow: 0 8px 16px rgba(28, 76, 130, 0.15);
        }
        .feedback-icon-orange {
            background: linear-gradient(135deg, #f18d2d 0%, #d97706 100%);
            box-shadow: 0 8px 16px rgba(241, 141, 45, 0.15);
        }
        .feedback-number-custom {
            font-size: 34px;
            font-weight: 800;
            color: #0b2545; /* Dark blue */
            margin-bottom: 8px;
            line-height: 1.1;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.5px;
        }
        .feedback-label-custom {
            font-size: 14px;
            font-weight: 600;
            color: #64748b; /* Cool grey label */
            margin-bottom: 0;
            text-transform: capitalize;
        }
        /* Divider borders on desktop (992px and up) */
        @media (min-width: 992px) {
            .feedback-col-custom:not(:last-child) {
                border-right: 1px solid #e2e8f0;
            }
        }
        /* Responsive adjustments on smaller screens */
        @media (max-width: 991px) {
            .feedback-number-custom {
                font-size: 28px;
            }
            .feedback-icon-container-custom {
                margin-bottom: 15px;
            }
        }
     </style>
     
     <?php
     if (!function_exists('render_counter_value')) {
         function render_counter_value($val) {
             if (preg_match('/^([0-9\.,]+)(.*)$/', trim($val), $matches)) {
                 $num = $matches[1];
                 $suffix = $matches[2];
                 return '<span class="counter">' . $num . '</span>' . $suffix;
             }
             return '<span class="counter">' . htmlspecialchars($val) . '</span>';
         }
     }
     ?>

   <section class="feeback-section" style="background-color: #f8fafb; padding: 60px 0;">
        <div class="container">
            <div class="feedback-banner-custom wow zoomIn" data-wow-delay="0.2s">
                <div class="row g-4 align-items-center text-center">
                    <?php
                    $ss = "SELECT * FROM extra_content WHERE type='counter' LIMIT 4";
                    $re = mysqli_query($conn, $ss);
                    
                    // Predefined icons and styling rotating based on index
                    $counter_icons = [
                        ['icon' => 'fas fa-users', 'class' => 'feedback-icon-blue'],
                        ['icon' => 'fas fa-star', 'class' => 'feedback-icon-orange'],
                        ['icon' => 'fas fa-thumbs-up', 'class' => 'feedback-icon-blue'],
                        ['icon' => 'fas fa-trophy', 'class' => 'feedback-icon-orange']
                    ];
                    
                    foreach($re as $key => $socila) {
                        $icon_config = $counter_icons[$key % count($counter_icons)];
                    ?>
                        <div class="col-lg-3 col-6 feedback-col-custom">
                            <div class="feedback-item-custom">
                                <div class="feedback-icon-container-custom <?= $icon_config['class']; ?>">
                                    <i class="<?= $icon_config['icon']; ?>"></i>
                                </div>
                                <div class="feedback-number-custom">
                                    <?= render_counter_value($socila['heading2']); ?>
                                </div>
                                <p class="feedback-label-custom"><?= htmlspecialchars($socila['heading1']); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
      <section class="section benefit-section bg-light-300">
        <div class="container">
        <?php
                                $ss="SELECT * from  extra_content where type='heading' order by id asc limit 1 OFFSET 2  ";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>  
            <div class="row justify-content-center">
               
                <div class="col-lg-6 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <span class="badge badge-soft-primary rounded-pill mb-1">Empowering Entrepreneurs</span> 
                    <div class="section-header text-center">
                        <h2 class="mb-2"> <?php echo $socila['heading1'];?> <span class="text-primary  text-decoration-underline"><?php echo $socila['heading2'];?></span>   </h2>
                        <p class="sub-title">We are a technology-driven platform organising the professional services industry in India</p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row g-4">

            <?php
                                $ss="SELECT * from  extra_content where type='4_box_content' limit 4";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   

                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card benefit-card mb-0 flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body text-center"  style="    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.15); border: 1px dashed #cdc1c1;">
                            <div style="padding: 6px;" class="benefit-icon mb-2 bg-secondary text-gray-9 mx-auto">
                            <img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>" alt="Img"> 
                            </div>
                            <h5 class="mb-2"><?php echo $socila['heading1'];?></h5>
                            <p class="mb-0"><?php echo $socila['heading2'];?></p> 
                        </div>
                    </div>
                </div>
                <?php } ?>
             
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="section testimonial-section z-1 bg-light-200">
        <div class="container">
            <div class="row align-items-center">
            <?php
                                $ss="SELECT * from  extra_content where type='heading' limit 1  OFFSET 3";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   


                <div class="col-lg-5 wow fadeInDown" data-wow-delay="0.2s">
                    <div class="flex-fill position-relative">
                        <div class="success-icon">
                            <img src="assets/img/icons/icon-arrow.svg" alt="img">
                        </div>
                        <div class="mb-4 mb-lg-0 success-wrap">
                            <div class="section-header section-header-four">
                                <h2 class="mb-2"><span><?php echo $socila['heading1'];?></span> <?php echo $socila['heading2'];?></h2>
                                <p class="sub-title"> <?php echo $socila['content'];?></p>
                            </div>
                            
                        </div>
                    </div>
                </div>
                    <?php } ?>
                <div class="col-lg-7">
                    <style>
                    /* Testimonial Section Styles */
                    .single-testimonial-carousel.owl-carousel .owl-stage-outer {
                        padding: 15px 0; /* Add padding so card shadows aren't clipped */
                    }

                    .custom-review-card {
                        position: relative;
                        background: #ffffff;
                        border: 1px solid #eef2f6;
                        border-radius: 24px;
                        padding: 35px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
                        overflow: hidden;
                        margin: 5px 15px;
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                    }

                    .custom-review-card:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.05);
                    }

                    /* Beautiful color-gradient top accent border */
                    .custom-review-card::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        height: 6px;
                        background: linear-gradient(90deg, #1d4ed8 0%, #f97316 100%);
                        z-index: 10;
                    }

                    .card-badge-row {
                        margin-bottom: 24px;
                    }

                    /* Verified badge: Green background/text */
                    .verified-badge {
                        background-color: #f0fdf4;
                        border: 1px solid rgba(34, 197, 94, 0.3);
                        color: #15803d;
                        padding: 8px 16px;
                        border-radius: 30px;
                        font-size: 13px;
                        font-weight: 700;
                        display: inline-flex;
                        align-items: center;
                        letter-spacing: 0.2px;
                    }

                    .verified-icon {
                        color: #22c55e;
                        font-size: 14px;
                    }

                    /* Quote Icon: Blue border/background */
                    .quote-box {
                        width: 44px;
                        height: 44px;
                        border-radius: 12px;
                        background-color: #eff6ff;
                        border: 1px solid rgba(59, 130, 246, 0.1);
                        color: #1e40af;
                        font-size: 16px;
                    }

                    /* Rating Badge Pill: Amber background/text */
                    .rating-badge-pill {
                        background-color: #fffbeb;
                        border: 1px solid rgba(245, 158, 11, 0.3);
                        padding: 6px 14px;
                        border-radius: 20px;
                        font-size: 13px;
                        font-weight: 700;
                        color: #92400e;
                    }

                    .rating-stars {
                        color: #f59e0b;
                        margin-right: 8px;
                        display: inline-flex;
                        gap: 2px;
                    }

                    /* Review text styling */
                    .review-text {
                        font-size: 18px;
                        line-height: 1.7;
                        color: #334155;
                        font-weight: 500;
                        margin-bottom: 30px;
                        letter-spacing: -0.1px;
                    }

                    /* Footer Section separator and content */
                    .review-footer {
                        border-top: 1px solid #f1f5f9;
                    }

                    /* Avatar: Initials inside green outer circle */
                    .author-avatar {
                        width: 56px;
                        height: 56px;
                        border-radius: 50%;
                        border: 2px solid #22c55e;
                        padding: 3px;
                        background-color: #ffffff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .author-avatar-inner {
                        width: 100%;
                        height: 100%;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #ffffff;
                        font-weight: 700;
                        font-size: 16px;
                        text-transform: uppercase;
                    }

                    .author-name {
                        font-size: 17px;
                        font-weight: 700;
                        color: #0f172a;
                    }

                    .author-role {
                        font-size: 13px;
                        color: #64748b;
                        font-weight: 500;
                        margin-top: 2px;
                    }

                    /* Date Badge: Blue background/text */
                    .date-badge {
                        background-color: #eff6ff;
                        border: 1px solid rgba(59, 130, 246, 0.1);
                        color: #2563eb;
                        padding: 6px 16px;
                        border-radius: 20px;
                        font-size: 13px;
                        font-weight: 600;
                        display: inline-flex;
                        align-items: center;
                    }

                    .date-badge i {
                        font-size: 14px;
                        color: #2563eb;
                    }

                    /* Custom styles for Owl Carousel dots in single-testimonial */
                    .single-testimonial-carousel.owl-carousel .owl-dots {
                        margin-top: 20px !important;
                        text-align: center;
                    }

                    .single-testimonial-carousel.owl-carousel .owl-dots .owl-dot span {
                        width: 8px !important;
                        height: 8px !important;
                        margin: 5px 6px !important;
                        background: #cbd5e1 !important;
                        border-radius: 50% !important;
                        transition: all 0.3s ease !important;
                        display: block;
                    }

                    .single-testimonial-carousel.owl-carousel .owl-dots .owl-dot.active span {
                        width: 24px !important;
                        background: #1d4ed8 !important;
                        border-radius: 4px !important;
                    }

                    /* Mobile responsive adjustments */
                    @media (max-width: 767.98px) {
                        .custom-review-card {
                            padding: 24px 20px;
                            margin: 5px 5px;
                        }
                        .review-text {
                            font-size: 16px;
                            line-height: 1.6;
                            margin-bottom: 24px;
                        }
                        .card-badge-row {
                            margin-bottom: 16px;
                        }
                        .review-footer {
                            flex-direction: column;
                            align-items: flex-start !important;
                            gap: 16px;
                            padding-top: 20px !important;
                        }
                        .date-badge {
                            align-self: flex-start;
                        }
                    }
                    </style>

                    <div class="testimonial-success">
                        <div class="single-testimonial-carousel owl-carousel wow fadeInDown" data-wow-delay="0.2s">
                            <?php
                            $dummy_reviews = [
                                [
                                    'name' => 'Rahul Sharma',
                                    'role' => 'Founder',
                                    'content' => 'Starting a business felt complicated until I connected with BizSetup. Their team handled my company registration professionally and kept me informed throughout the process. Everything was completed smoothly, and their support was available whenever I needed guidance.',
                                    'initials' => 'RS',
                                    'avatar_bg' => '#3b82f6',
                                    'date' => '20 Jun'
                                ],
                                [
                                    'name' => 'Priya Verma',
                                    'role' => 'Co-Founder',
                                    'content' => 'BizSetup made our GST registration process incredibly simple. The team was responsive, knowledgeable, and ensured all documentation was completed correctly. I appreciate their professionalism and would gladly recommend them to anyone starting a new business.',
                                    'initials' => 'PV',
                                    'avatar_bg' => '#10b981',
                                    'date' => '18 Jun'
                                ],
                                [
                                    'name' => 'Amit Gupta',
                                    'role' => 'Director',
                                    'content' => 'We approached BizSetup for trademark registration and were impressed by their expertise. They explained every step clearly and handled the filing process efficiently. The experience was smooth, transparent, and completely hassle-free.',
                                    'initials' => 'AG',
                                    'avatar_bg' => '#f59e0b',
                                    'date' => '15 Jun'
                                ],
                                [
                                    'name' => 'Neha Singh',
                                    'role' => 'Entrepreneur',
                                    'content' => 'The team at BizSetup is highly professional and genuinely committed to helping entrepreneurs. They assisted us with company incorporation, compliance requirements, and regulatory filings. Their guidance saved us significant time and allowed us to focus on growing our business with confidence.',
                                    'initials' => 'NS',
                                    'avatar_bg' => '#ec4899',
                                    'date' => '12 Jun'
                                ],
                                [
                                    'name' => 'Rohit Agarwal',
                                    'role' => 'Proprietor',
                                    'content' => 'Excellent service and great customer support. Every question was answered promptly, and the registration process was completed within the promised timeline. A reliable partner for any business owner.',
                                    'initials' => 'RA',
                                    'avatar_bg' => '#8b5cf6',
                                    'date' => '10 Jun'
                                ],
                                [
                                    'name' => 'Kavita Mishra',
                                    'role' => 'Managing Director',
                                    'content' => 'BizSetup helped us with Startup India registration and ongoing compliance support. Their experts demonstrated deep knowledge of legal and regulatory requirements while maintaining clear communication throughout. I highly appreciate their dedication, transparency, and customer-focused approach.',
                                    'initials' => 'KM',
                                    'avatar_bg' => '#06b6d4',
                                    'date' => '08 Jun'
                                ],
                                [
                                    'name' => 'Sandeep Kumar',
                                    'role' => 'Founder',
                                    'content' => 'I had a wonderful experience working with BizSetup. From consultation to final documentation, everything was handled efficiently and professionally. Their team pays close attention to detail and ensures clients understand every step of the process.',
                                    'initials' => 'SK',
                                    'avatar_bg' => '#ef4444',
                                    'date' => '05 Jun'
                                ],
                                [
                                    'name' => 'Anjali Srivastava',
                                    'role' => 'Partner',
                                    'content' => 'Finding a trustworthy compliance partner can be difficult, but BizSetup exceeded our expectations. They provided accurate guidance, completed filings on time, and were always available whenever we needed assistance. Their professionalism and commitment to quality service truly stand out.',
                                    'initials' => 'AS',
                                    'avatar_bg' => '#14b8a6',
                                    'date' => '03 Jun'
                                ],
                                [
                                    'name' => 'Vivek Tiwari',
                                    'role' => 'CEO',
                                    'content' => 'We have been using BizSetup for business compliance and taxation services for several months. Their team consistently delivers quality work, meets deadlines, and provides practical solutions whenever challenges arise. A dependable and highly recommended service provider.',
                                    'initials' => 'VT',
                                    'avatar_bg' => '#6366f1',
                                    'date' => '30 May'
                                ],
                                [
                                    'name' => 'Deepak Jain',
                                    'role' => 'Director',
                                    'content' => 'BizSetup made the entire company registration process effortless. Their experts handled all formalities efficiently and kept us updated at every stage. The experience was smooth, transparent, and far better than we expected.',
                                    'initials' => 'DJ',
                                    'avatar_bg' => '#f43f5e',
                                    'date' => '28 May'
                                ],
                                [
                                    'name' => 'Shikhar Kakkar',
                                    'role' => 'Co-Founder',
                                    'content' => 'What impressed me most about BizSetup was their commitment to customer satisfaction. They don\'t just process applications; they take the time to understand your business requirements and provide the right guidance. Their expertise and professional approach make them a valuable partner for entrepreneurs.',
                                    'initials' => 'SK',
                                    'avatar_bg' => '#059669',
                                    'date' => '25 May'
                                ],
                                [
                                    'name' => 'Pooja Sharma',
                                    'role' => 'CEO',
                                    'content' => 'The team was friendly, knowledgeable, and extremely supportive throughout our engagement. Whether it was GST compliance, registrations, or general business queries, they provided prompt assistance and reliable solutions every time.',
                                    'initials' => 'PS',
                                    'avatar_bg' => '#d97706',
                                    'date' => '22 May'
                                ]
                            ];

                            foreach ($dummy_reviews as $review) {
                            ?>
                            <div class="custom-review-card">
                                <div class="card-badge-row d-flex justify-content-between align-items-center">
                                    <div class="verified-badge">
                                        <i class="fa-solid fa-circle-check verified-icon me-2"></i>Verified Customer
                                    </div>
                                    <div class="quote-box d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-quote-right quote-icon"></i>
                                    </div>
                                </div>
                                <div class="rating-badge-pill d-inline-flex align-items-center">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-score">5.0</span>
                                </div>
                                <p class="review-text mt-4">
                                    "<?php echo htmlspecialchars($review['content']); ?>"
                                </p>
                                <div class="review-footer d-flex justify-content-between align-items-center mt-4 pt-3">
                                    <div class="d-flex align-items-center">
                                        <div class="author-avatar me-3">
                                            <div class="author-avatar-inner" style="background-color: <?php echo $review['avatar_bg']; ?>;">
                                                <?php echo htmlspecialchars($review['initials']); ?>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="author-name mb-0"><?php echo htmlspecialchars($review['name']); ?></h6>
                                            <p class="author-role mb-0"><?php echo htmlspecialchars($review['role']); ?></p>
                                        </div>
                                    </div>
                                    <div class="date-badge">
                                        <i class="fa-regular fa-calendar me-2"></i><?php echo htmlspecialchars($review['date']); ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="testimonials-bg">
                            <img src="assets/img/bg/testimonial-bg-01.png" alt="img" class="testimonial-bg-03">
                        </div>
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const initTestimonialSlider = function() {
                            if (typeof window.jQuery === 'undefined' || typeof window.jQuery.fn.owlCarousel === 'undefined') {
                                setTimeout(initTestimonialSlider, 50);
                                return;
                            }
                            
                            jQuery('.single-testimonial-carousel').owlCarousel({
                                loop: true,
                                margin: 20,
                                nav: false,
                                dots: true,
                                autoplay: true,
                                autoplayTimeout: 5000,
                                autoplayHoverPause: true,
                                smartSpeed: 800,
                                items: 1,
                                responsive: {
                                    0: {
                                        items: 1
                                    }
                                }
                            });
                        };
                        initTestimonialSlider();
                    });
                    </script>
                </div>
            </div>
        </div>
        <div class="testimonials-bg">
            <img src="assets/img/bg/testimonial-bg-01.png" alt="img" class="testimonial-bg-01">
            <img src="assets/img/bg/testimonial-bg-02.png" alt="img" class="testimonial-bg-02">
        </div>
    </section>
    <!-- /Testimonial Section -->

    <!-- FAQ Section -->
    <section class="faq-section-four section">
        <div class="container">
        <?php
                                $ss="SELECT * from  extra_content where type='heading' limit 1  OFFSET 4";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
            <div class="row justify-content-center">
                <div class="col-xl-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header section-header-four text-center">
                        <h2 class="mb-2"><span><?php echo $socila['heading1'];?></span> <br><?php echo $socila['heading2'];?></h2>
                        <p class="sub-title"> <?php echo $socila['content'];?> </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="accordion accordion-flush faq-four" id="accordionFaq">
                    <?php
                    $c='1';
                                $ss="SELECT * from  extra_content where type='faq'  ";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
                        <div class="accordion-item   mb-2 wow fadeInUp" data-wow-delay="0.<?php echo $c;?></div>s">
                            <h2 class="accordion-header">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse<?php echo $c;?>" aria-expanded="false" aria-controls="faq-collapse<?php echo $c;?>">
									<?php echo $socila['heading1'];?>
								</button>
							</h2>
                            <div id="faq-collapse<?php echo $c;?>" class="accordion-collapse collapse  " data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="mb-0"> <?php echo $socila['content'];?> </p>
                                    
                                </div>
                            </div>
                        </div>
                        <?php $c++; } ?>
                         
                         
                    </div>
                </div>
                  <!-- Business-->
            <?php
            $ss="SELECT * from  extra_content where type='call_to_action' limit 1   ";
            $re=mysqli_query($conn,$ss);
            foreach($re as $key=> $socila){       ?>   
            
            <style>
                .custom-cta-section {
                    background: linear-gradient(135deg, #0b2545 0%, #1c4c82 100%);
                    position: relative;
                    overflow: hidden;
                    border-radius: 24px;
                    padding: 60px 50px;
                    margin-top: 65px;
                    box-shadow: 0 15px 35px rgba(11, 37, 69, 0.15);
                }
                
                .cta-orange-slash {
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 35%;
                    height: 120%;
                    background: #f18d2d;
                    transform: skewX(-20deg) translateX(40%);
                    z-index: 1;
                    pointer-events: none;
                    opacity: 0.95;
                    transition: all 0.5s ease;
                }
                
                .relative-content {
                    position: relative;
                    z-index: 2;
                }
                
                .cta-form-card {
                    background: #ffffff;
                    border-radius: 20px;
                    padding: 30px;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
                    border: 1px solid rgba(226, 232, 240, 0.8);
                }
                
                .form-control-custom {
                    width: 100%;
                    border: 1px solid #cbd5e1;
                    border-radius: 8px;
                    padding: 12px 16px;
                    font-size: 14px;
                    transition: all 0.3s ease;
                    background-color: #f8fafc;
                    color: #334155;
                    outline: none;
                    box-sizing: border-box;
                    height: 46px;
                }
                
                .form-control-custom:focus {
                    border-color: #f18d2d;
                    background-color: #ffffff;
                    box-shadow: 0 0 0 3px rgba(241, 141, 45, 0.15);
                }
                
                .form-select-custom {
                    appearance: none;
                    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: right 16px center;
                    background-size: 12px 12px;
                    padding-right: 40px;
                }
                
                .btn-cta-submit {
                    background-color: #f18d2d !important;
                    border-color: #f18d2d !important;
                    color: #ffffff !important;
                    font-weight: 700;
                    border-radius: 8px;
                    padding: 12px 20px;
                    font-size: 13px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    border: none;
                    height: 46px;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                }
                
                .btn-cta-submit:hover {
                    background-color: #d97706 !important;
                    border-color: #d97706 !important;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(241, 141, 45, 0.3);
                }
                
                @media (max-width: 991px) {
                    .custom-cta-section {
                        padding: 40px 30px;
                    }
                    .cta-orange-slash {
                        display: none;
                    }
                    .business-info {
                        text-align: center;
                    }
                }
            </style>

            <div class="custom-cta-section wow zoomIn">
                <div class="cta-orange-slash"></div>
                <div class="row align-items-center relative-content g-4">
                    <div class="col-xl-4 col-lg-5">
                        <div class="business-info p-0">
                            <h2 class="display-6 text-white mb-3" style="font-weight: 800; font-size: 32px; line-height: 1.3;">
                                <?php echo htmlspecialchars($socila['heading1']); ?>
                            </h2>
                            <div class="text-light opacity-90" style="font-size: 15px; line-height: 1.6;">
                                <?php echo str_replace('<p>', '<p class="mb-0" style="color: white">', $socila['content']); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-8 col-lg-7">
                        <div class="cta-form-card">
                            <form id="ctaConsultationForm" action="<?php echo $urlmain;?>inquiry-handler.php" method="POST">
                                <input type="hidden" name="source" value="cta_home_form">
                                <input type="hidden" name="message" value="Requested free consultation for service interest.">
                                <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="input-group-custom">
                                            <input type="text" name="first_name" class="form-control-custom" placeholder="Enter Your Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group-custom d-flex">
                                            <div class="phone-prefix-select" style="background: #e2e8f0; border: 1px solid #cbd5e1; border-right: none; border-radius: 8px 0 0 8px; padding: 10px 14px; font-size: 14px; font-weight: 600; color: #475569; display: flex; align-items: center;">
                                                +91
                                            </div>
                                            <input type="tel" name="phone" class="form-control-custom" placeholder="Enter your PhoneNo." style="border-radius: 0 8px 8px 0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group-custom">
                                            <input type="email" name="email" class="form-control-custom" placeholder="Enter your Email" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-8">
                                        <div class="input-group-custom">
                                            <select name="service_name" class="form-control-custom form-select-custom" required>
                                                <option value="" disabled selected>Select your service</option>
                                                <?php
                                                $cat_query = "SELECT * FROM category WHERE is_active = '1' ORDER BY position ASC";
                                                $cat_result = mysqli_query($conn, $cat_query);
                                                if ($cat_result && mysqli_num_rows($cat_result) > 0) {
                                                    while ($cat = mysqli_fetch_assoc($cat_result)) {
                                                        echo '<option value="' . htmlspecialchars($cat['category_name']) . '">' . htmlspecialchars($cat['category_name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" id="ctaSubmitBtn" class="btn btn-cta-submit">
                                            <span class="btn-text">Claim Your Free Consultation</span>
                                            <span class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div id="ctaFormMessage" class="mt-3" style="display:none; font-weight: 600; font-size: 14px; text-align: center;"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ensure jQuery is loaded before utilizing it
                const initCtaForm = function() {
                    if (typeof window.jQuery === 'undefined') {
                        setTimeout(initCtaForm, 50);
                        return;
                    }
                    
                    jQuery('#ctaConsultationForm').on('submit', function(e) {
                        e.preventDefault();
                        
                        const $form = jQuery(this);
                        const $submitBtn = jQuery('#ctaSubmitBtn');
                        const $btnText = $submitBtn.find('.btn-text');
                        const $spinner = $submitBtn.find('.spinner-border');
                        const $message = jQuery('#ctaFormMessage');
                        
                        // Validation
                        const name = $form.find('[name="first_name"]').val().trim();
                        const phone = $form.find('[name="phone"]').val().trim();
                        const email = $form.find('[name="email"]').val().trim();
                        const service = $form.find('[name="service_name"]').val();
                        
                        $message.hide().removeClass('text-success text-danger');
                        
                        if (!name) {
                            $message.addClass('text-danger').text('Please enter your name.').show();
                            return;
                        }
                        
                        if (!phone) {
                            $message.addClass('text-danger').text('Please enter your phone number.').show();
                            return;
                        }
                        
                        // Phone format check: 10 digits
                        const phoneRegex = /^[0-9]{10}$/;
                        if (!phoneRegex.test(phone.replace(/[\s\-\(\)\+]/g, ''))) {
                            $message.addClass('text-danger').text('Please enter a valid 10-digit phone number.').show();
                            return;
                        }
                        
                        if (!email) {
                            $message.addClass('text-danger').text('Please enter your email address.').show();
                            return;
                        }
                        
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(email)) {
                            $message.addClass('text-danger').text('Please enter a valid email address.').show();
                            return;
                        }
                        
                        if (!service) {
                            $message.addClass('text-danger').text('Please select a service.').show();
                            return;
                        }
                        
                        // Show loading state
                        $submitBtn.prop('disabled', true);
                        $btnText.text('Processing...');
                        $spinner.show();
                        
                        // Submit via AJAX
                        jQuery.ajax({
                            url: $form.attr('action'),
                            method: 'POST',
                            data: $form.serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $message.addClass('text-success').text(response.message).show();
                                    $form[0].reset();
                                } else {
                                    $message.addClass('text-danger').text(response.message).show();
                                }
                            },
                            error: function() {
                                $message.addClass('text-danger').text('An error occurred. Please try again.').show();
                            },
                            complete: function() {
                                $submitBtn.prop('disabled', false);
                                $btnText.text('Claim Your Free Consultation');
                                $spinner.hide();
                            }
                        });
                    });
                };
                initCtaForm();
            });
            </script>
            <?php } ?>
            <!-- /Business -->

        </div>
    </section>
    <!-- /FAQ Section -->

    <!-- Blog Section -->
    <section class="section blog-section blog-section-four pt-0">
        <div class="container">
            <?php
                                $ss="SELECT * from  extra_content where type='heading' limit 1  OFFSET 5";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
            <div class="row justify-content-center">
                <div class="col-xl-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header section-header-four  text-center">
                        <h2 class="mb-2"><span><?php echo $socila['heading1'];?></span> <br><?php echo $socila['heading2'];?></h2>
                        <p class="sub-title"> <?php echo $socila['content'];?> </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="blog-slider owl-carousel nav-center">

                                <?php
                // Fetch latest published blogs for homepage (limit 6 for slider)
                $blog_query = "SELECT b.*, bc.name as category_name, bc.slug as category_slug 
                              FROM blog b 
                              LEFT JOIN blog_categories bc ON b.category_id = bc.id 
                              WHERE b.status = 'published' 
                              ORDER BY b.published_date DESC, b.created_date DESC 
                              LIMIT 6";
                
                $blog_result = mysqli_query($conn, $blog_query);
                
                if ($blog_result && mysqli_num_rows($blog_result) > 0) {
                    $blog_index = 0;
                    while ($blog = mysqli_fetch_assoc($blog_result)) {
                        $blog_index++;
                        
                        // Format date for display
                        $blog_date = !empty($blog['published_date']) ? $blog['published_date'] : $blog['created_date'];
                        $day = date('d', strtotime($blog_date));
                        $month = date('M', strtotime($blog_date));
                        
                        // Default image if none provided
                        $default_images = [
                            'assets/img/blog/blog-01.jpg',
                            'assets/img/blog/blog-02.jpg',
                            'assets/img/blog/blog-03.jpg',
                            'assets/img/blog/blog-05.jpg',
                            'assets/img/blog/blog-06.jpg',
                            'assets/img/blog/blog-07.jpg'
                        ];
                        
                        $blog_image = !empty($blog['image']) ? $blog['image'] : $default_images[($blog_index - 1) % count($default_images)];
                        
                        // Set animation delay
                        $delay = 0.2 + (($blog_index - 1) % 3) * 0.1;
                        ?>
                        
                        <!-- Blog Item-->
                        <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                            <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>" class="blog-img">
                                <img src="<?php echo $urlmain;?>images/blog/<?php echo htmlspecialchars($blog_image); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            </a>
                            <div class="blog-date">
                                <h6><?php echo $day; ?><span class="d-block fs-14 fw-normal"><?php echo $month; ?></span></h6>
                            </div>
                            <div class="blog-info text-center"> 
                                <h5><a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h5>
                            </div>
                        </div>
                        <!-- /Blog Item-->
                        
                        <?php
                    }
                } else {
                    // Show default content if no blogs are available
                    ?>
                    <!-- Default Blog Item when no blogs available -->
                    <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="blog.php" class="blog-img">
                            <img src="assets/img/blog/blog-01.jpg" alt="Coming Soon">
                        </a>
                        <div class="blog-date">
                            <h6><?php echo date('d'); ?><span class="d-block fs-14 fw-normal"><?php echo date('M'); ?></span></h6>
                        </div>
                        <div class="blog-info text-center"> 
                            <h5><a href="blog.php">New Blog Posts Coming Soon</a></h5>
                        </div>
                    </div>
                    <!-- /Default Blog Item-->
                    
                    <!-- Additional default items for slider -->
                    <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="0.3s">
                        <a href="blog.php" class="blog-img">
                            <img src="assets/img/blog/blog-02.jpg" alt="Stay Tuned">
                        </a>
                        <div class="blog-date">
                            <h6><?php echo date('d'); ?><span class="d-block fs-14 fw-normal"><?php echo date('M'); ?></span></h6>
                        </div>
                        <div class="blog-info text-center"> 
                            <h5><a href="blog.php">Stay Tuned for Updates</a></h5>
                        </div>
                    </div>
                    
                    <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="0.4s">
                        <a href="blog.php" class="blog-img">
                            <img src="assets/img/blog/blog-03.jpg" alt="Subscribe">
                        </a>
                        <div class="blog-date">
                            <h6><?php echo date('d'); ?><span class="d-block fs-14 fw-normal"><?php echo date('M'); ?></span></h6>
                        </div>
                        <div class="blog-info text-center"> 
                            <h5><a href="blog.php">Subscribe for Latest News</a></h5>
                        </div>
                    </div>
                    <?php
                }
                ?>

                            
 

            </div>
            <div class="text-center view-all wow fadeInUp">
                <a href="blog.php" class="btn btn-dark">View All Blogs<i class="isax isax-arrow-right-3 ms-2"></i></a>
            </div>
        </div>
    </section>
    <!-- /Blog Section -->

 
   
   <?php include "include/footer.php";?> 

  



   <?php include "include/js.php";?> 
    <!-- Jquery JS -->
    

<style>
/* Make carousel items equal height and clickable */
.popular-hotel-slider.owl-carousel {
  z-index: 10 !important;
  position: relative !important;
  pointer-events: auto !important;
}

.popular-hotel-slider.owl-carousel .owl-stage {
  display: flex !important;
}

.popular-hotel-slider.owl-carousel .owl-item {
  display: flex !important;
  height: auto !important;
}

.popular-hotel-slider.owl-carousel .card {
  display: flex !important;
  flex-direction: column !important;
  width: 100% !important;
  height: 100% !important;
  margin-bottom: 0 !important;
  border: 1px solid #eef2f6 !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
  background-color: #fff !important;
}

.popular-hotel-slider.owl-carousel .card-body {
  display: flex !important;
  flex-direction: column !important;
  flex-grow: 1 !important;
  padding: 24px !important;
  height: 100% !important;
}

.popular-hotel-slider.owl-carousel .card-body > .d-flex {
  display: flex !important;
  flex-direction: column !important;
  align-items: stretch !important;
  flex-grow: 1 !important;
  height: 100% !important;
  margin-bottom: 0 !important;
  padding-bottom: 0 !important;
}

.popular-hotel-slider.owl-carousel .flex-grow-1 {
  display: flex !important;
  flex-direction: column !important;
  justify-content: space-between !important;
  flex-grow: 1 !important;
  height: 100% !important;
}

.popular-hotel-slider.owl-carousel .flex-grow-1 > h5,
.popular-hotel-slider.owl-carousel .flex-grow-1 > div {
  margin-bottom: 8px !important;
}

.popular-hotel-slider.owl-carousel .flex-grow-1 > small.text-muted {
  margin-top: auto !important;
  padding-top: 12px !important;
  border-top: 1px dashed #f0f2f5 !important;
}

	/* Container */
.search-section {
  
  padding: 10px 10px;
  text-align: center;
  font-family: 'Segoe UI', sans-serif;
}

/* Mobile responsive styles for popular hotel slider */
@media (max-width: 767px) {
  .popular-hotel-slider .card {
    margin-bottom: 15px;
  }
  
  .popular-hotel-slider .card-body {
    padding: 12px;
  }
  
  .popular-hotel-slider .card h5 {
    font-size: 14px;
    line-height: 1.3;
    margin-bottom: 8px;
  }
  
  .popular-hotel-slider .badge {
    font-size: 11px;
    padding: 3px 8px;
  }
  
  .popular-hotel-slider .text-muted {
    font-size: 10px;
  }
  
  .popular-hotel-slider .text-info {
    font-size: 10px;
  }
}

@media (max-width: 480px) {
  .popular-hotel-slider .card-body {
    padding: 10px;
  }
  
  .popular-hotel-slider .card h5 {
    font-size: 13px;
  }
  
  .popular-hotel-slider .badge {
    font-size: 10px;
    padding: 2px 6px;
  }
}

/* Search bar */
.search-box {
  position: relative;
  display: inline-block;
  width: 70%;
  max-width: 800px;
}

.search-box input {
  width: 100%;
  padding: 18px 60px 18px 20px;
  border: none;
  border-radius: 35px;
  font-size: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  outline: none;
}

/* Search icon */
.search-icon {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  color: #04294a;
  font-size: 18px;
  pointer-events: none;
}

/* Tags */
.search-tags {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
}

.search-tags button {
  /* background: transparent; */
  background: #303e5b;
  border: 1px solid #7a8ba3;
  color: #fff;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s ease;
}

.search-tags button:hover {
  background: #fff;
  color: #04294a;
}

</style>
 
  <script>
  const phrases = [
    "Private Limited Registration",
    "GST Registration",
    "Company Registration",
    "Trust Registration",
    "Startup Compliance"
  ];

  const input = document.getElementById("searchBox");

  let currentPhrase = 0;
  let currentChar = 0;
  let isDeleting = false;

  function typeEffect() {
    const currentText = phrases[currentPhrase];
    if (isDeleting) {
      currentChar--;
    } else {
      currentChar++;
    }

    input.setAttribute("placeholder", currentText.substring(0, currentChar));

    if (!isDeleting && currentChar === currentText.length) {
      setTimeout(() => isDeleting = true, 1000);
    } else if (isDeleting && currentChar === 0) {
      isDeleting = false;
      currentPhrase = (currentPhrase + 1) % phrases.length;
    }

    const speed = isDeleting ? 40 : 90;
    setTimeout(typeEffect, speed);
  }

  typeEffect();
</script>

<!-- Search Dropdown JavaScript -->
<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing search...');
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }
    
    console.log('jQuery available, version:', $.fn.jquery);
    
    // Check if search elements exist
    const searchBox = document.getElementById('searchBox');
    const searchDropdown = document.getElementById('searchDropdown');
    
    if (!searchBox) {
        console.error('Search box not found!');
        return;
    }
    
    if (!searchDropdown) {
        console.error('Search dropdown not found!');
        return;
    }
    
    console.log('Search elements found, setting up events...');
    
    let searchTimeout;
    
    // Function to perform immediate search on enter or button click
    function performSearch() {
        const query = $('#searchBox').val().trim();
        const dropdown = $('#searchDropdown');
        
        clearTimeout(searchTimeout);
        
        if (query.length < 1) {
            dropdown.hide().empty();
            return;
        }
        
        // If suggestions are already loaded and visible, navigate to the first one
        const firstSuggestion = dropdown.find('.search-suggestion-item:first');
        if (firstSuggestion.length && dropdown.is(':visible') && !firstSuggestion.hasClass('no-results')) {
            const url = firstSuggestion.data('url');
            if (url) {
                console.log('Navigating to suggestion URL:', url);
                window.location.href = url;
                return;
            }
        }
        
        // Otherwise, execute a direct immediate AJAX search and redirect to the first result if found
        dropdown.html('<div class="loading-indicator">Searching...</div>').show();
        
        $.ajax({
            url: 'search-api.php',
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            cache: false,
            success: function(data) {
                dropdown.empty();
                
                if (data && data.error) {
                    dropdown.html('<div class="no-results">Error: ' + data.error + '</div>').show();
                    return;
                }
                
                if (data && Array.isArray(data) && data.length > 0) {
                    console.log('Immediate match found, displaying and navigating...');
                    // Populate dropdown
                    data.forEach(function(item) {
                        const suggestionItem = $('<div class="search-suggestion-item" data-url="' + item.url + '">' +
                            '<div class="suggestion-title">' + item.name + '</div>' +
                            '<div class="suggestion-path">' + item.category + ' > ' + item.subcategory + '</div>' +
                            '</div>');
                        dropdown.append(suggestionItem);
                    });
                    dropdown.show();
                    
                    // Navigate to the first matching service
                    const url = data[0].url;
                    if (url) {
                        window.location.href = url;
                    }
                } else {
                    console.log('No results found for direct search');
                    dropdown.html('<div class="no-results"><i class="fas fa-exclamation-circle" style="color: #f18d2d; margin-right: 8px;"></i>No results found for "' + $('<div>').text(query).html() + '"</div>').show();
                }
            },
            error: function() {
                dropdown.html('<div class="no-results">Connection error. Please try again.</div>').show();
            }
        });
    }
    
    // Use both keyup and input events for typing suggestions
    $('#searchBox').on('keyup input', function(e) {
        // Don't trigger search on navigation keys for keyup
        if (e.type === 'keyup' && (e.which === 38 || e.which === 40 || e.which === 13)) {
            return;
        }
        
        const query = $(this).val().trim();
        const dropdown = $('#searchDropdown');
        
        clearTimeout(searchTimeout);
        
        console.log('Search triggered, query:', query);
        
        if (query.length < 1) {
            dropdown.hide().empty();
            return;
        }
        
        // Show loading indicator
        dropdown.html('<div class="loading-indicator">Searching...</div>').show();
        
        searchTimeout = setTimeout(function() {
            console.log('Making AJAX request for:', query);
            
            $.ajax({
                url: 'search-api.php',
                method: 'GET',
                data: { q: query },
                dataType: 'json',
                cache: false,
                timeout: 10000,
                success: function(data) {
                    console.log('Search API response:', data);
                    dropdown.empty();
                    
                    if (data && data.error) {
                        dropdown.html('<div class="no-results">Error: ' + data.error + '</div>').show();
                        return;
                    }
                    
                    if (data && Array.isArray(data) && data.length > 0) {
                        console.log('Displaying', data.length, 'results');
                        data.forEach(function(item) {
                            const suggestionItem = $('<div class="search-suggestion-item" data-url="' + item.url + '">' +
                                '<div class="suggestion-title">' + item.name + '</div>' +
                                '<div class="suggestion-path">' + item.category + ' > ' + item.subcategory + '</div>' +
                                '</div>');
                            dropdown.append(suggestionItem);
                        });
                        dropdown.show();
                    } else {
                        console.log('No results found');
                        dropdown.html('<div class="no-results"><i class="fas fa-exclamation-circle" style="color: #f18d2d; margin-right: 8px;"></i>No results found for "' + $('<div>').text(query).html() + '"</div>').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        readyState: xhr.readyState,
                        statusText: xhr.statusText
                    });
                    dropdown.html('<div class="no-results">Connection error. Please check your internet connection.</div>').show();
                }
            });
        }, 300);
    });
    
    // Handle suggestion click
    $(document).on('click', '.search-suggestion-item', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        console.log('Suggestion clicked, URL:', url);
        if (url) {
            window.location.href = url;
        }
    });
    
    // Handle Enter key press
    $('#searchBox').on('keydown', function(e) {
        if (e.key === 'Enter' || e.which === 13) {
            e.preventDefault();
            console.log('Enter pressed, executing search...');
            performSearch();
        }
    });
    
    // Handle Search Button Click
    $(document).on('click', '.search-btn-custom', function(e) {
        e.preventDefault();
        console.log('Search button clicked, executing search...');
        performSearch();
    });
    
    // Handle recommended tag pills click to trigger search suggestions immediately
    $(document).on('click', '.tag-pill-btn', function(e) {
        // Since inline onclick sets the value and focuses, we trigger input event to show suggestions
        setTimeout(function() {
            $('#searchBox').trigger('input');
        }, 50);
    });
    
    // Hide dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-box-custom, .search-box').length) {
            $('#searchDropdown').hide();
        }
    });
    
    // Show dropdown when focusing on search box if it has content
    $('#searchBox').on('focus', function() {
        const query = $(this).val().trim();
        if (query.length >= 1 && $('#searchDropdown').children().length > 0) {
            $('#searchDropdown').show();
        }
    });
    
    console.log('Search functionality initialized successfully');
});
</script>
 

</body>

</html>