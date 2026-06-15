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
    </style>

</head>

<body>

     

   
   <?php include "include/header.php";?> 

    <!-- Hero Section -->
    <section class="hero-section-four">
        <div class="container">
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-10 col-md-12 mx-auto wow fadeInUp" data-wow-delay="0.3s">
                        <div class="banner-content text-center mx-auto">
                            <h1 class="text-white display-4 mb-2">India's Top Rated  Professional Services Platform </h1>
                            <p class="text-white mx-auto">Connecting you with experts to simplify your legal, tax & compliance.</p>
                          <div class="search-section">
  <div class="search-box">
    <input type="text" id="searchBox" placeholder="Search for services..." autocomplete="off" />
    <span class="search-icon"><i class="fa fa-search"></i></span>
    <div id="searchDropdown" class="search-dropdown" style="display: none;">
      <!-- Dynamic suggestions will be populated here -->
    </div>
  </div>

  <div class="search-tags">
  
   <?php
                                $ss="SELECT * from  extra_content where type='after_search_content'";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){                              ?>
                                  
                                   <button><?php echo $socila['heading1'];?></button>   
                                    <?php } ?>
                                     
  </div>
</div>

                        </div>
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
                    Talk to lawyers, chartered accountants (CAs), and company secretaries (CSs) to meet your legal and
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
                <div class="offer-slider owl-carousel">
                <?php
                                $ss="SELECT * from  extra_content where type='banner'";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?> 
                    <div class="offer-slider-img">
                        <img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>" alt="Img">
                    </div>
                <?php } ?>
                      
                     
                </div>
                
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
                <div class="popular-hotel-slider owl-carousel">
                    
                    <?php
                    // Fetch popular sub subcategories with price information
                    $popular_services_query = "SELECT ssc.*, c.category_name, c.url as category_url, sc.subcategory_name, sc.url as subcategory_url 
                                             FROM sub_subcategory ssc 
                                             LEFT JOIN category c ON ssc.category_id = c.category_id 
                                             LEFT JOIN subcategory sc ON ssc.subcategory_id = sc.subcategory_id 
                                             WHERE ssc.status = '1' 
                                             ORDER BY RAND() 
                                             LIMIT 12";
                    
                    $popular_services_result = mysqli_query($conn, $popular_services_query);
                    
                    if ($popular_services_result && mysqli_num_rows($popular_services_result) > 0) {
                        while ($service = mysqli_fetch_assoc($popular_services_result)) {
                            // Clean price data
                            $display_price = '';
                            $offer_price = '';
                            
                            if (!empty($service['extra']) && trim($service['extra']) != '') {
                                $display_price = '₹' . number_format($service['extra']);
                            }
                            
                            if (!empty($service['price']) && trim($service['price']) != '') {
                                $offer_price = '₹' . number_format($service['price']);
                            }
                            
                            // Default image if none provided
                            $service_image = !empty($service['image']) ? $service['image'] : 'default-service.png';
                            
                            // Build service detail URL
                            $service_url = $urlmain . "service_detail.php?cat_url=" . urlencode($service['category_url']) . 
                                          "&sub_url=" . urlencode($service['subcategory_url']) . 
                                          "&subsub_url=" . urlencode($service['sub_subcategory_id']);
                    ?>
                    
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3 pb-3">
                                
                                <div class="flex-grow-1">
                                    <h5 class="mb-2">
                                        <a href="<?php echo $service_url; ?>" class="text-decoration-none">
                                            <?php echo htmlspecialchars($service['sub_subcategory_name']); ?>
                                        </a>
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($offer_price)) { ?>
                                            <span class="badge badge-success badge-xs text-white fs-13 fw-medium me-2">
                                                <?php echo $offer_price; ?>
                                            </span>
                                            <?php if (!empty($display_price)) { ?>
                                                <span class="text-muted text-decoration-line-through fs-12">
                                                    <?php echo $display_price; ?>
                                                </span>
                                            <?php } ?>
                                        <?php } elseif (!empty($display_price)) { ?>
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">
                                                <?php echo $display_price; ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge badge-info badge-xs text-white fs-13 fw-medium me-2">
                                                Contact for Price
                                            </span>
                                        <?php } ?>
                                        
                                        <?php if (!empty($service['meal']) && trim($service['meal']) != '') { ?>
                                            <small class="text-info d-block mt-1 fw-medium">
                                                <i class="fa fa-info-circle me-1"></i><?php echo htmlspecialchars($service['meal']); ?>
                                            </small>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($service['category_name']) && !empty($service['subcategory_name'])) { ?>
                                        <small class="text-muted d-block mt-1">
                                            <?php echo htmlspecialchars($service['category_name']); ?> > <?php echo htmlspecialchars($service['subcategory_name']); ?>
                                        </small>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                        }
                    } else {
                        // Fallback content if no services are available
                    ?>
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3 pb-3">
                                    <a href="#" class="flex-shrink-0 me-3">
                                        <img src="assets/img/icons/hotel-logo-01.svg" class="rounded-circle" alt="Img" style="width: 60px; height: 60px; object-fit: cover;">
                                    </a>
                                    <div>
                                        <h5 class="mb-2"><a href="#" class="text-decoration-none">Services Coming Soon</a></h5>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-info badge-xs text-white fs-13 fw-medium me-2">Contact Us</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <p class="sub-title">At Biz Setup Pvt. Ltd., we understand that starting and running a business in India can be a complex journey filled with legal, regulatory, and administrative hurdles.  <br>
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
        @media (max-width: 768px) {
  .countearli {
    width: 50% !important; /* 2 in a row on mobile */
    float: left; /* or use flex/grid */
  }
}
     </style>
   <section class="feeback-section" style="    background-color: #f8fafb;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="rating-feedback wow zoomIn">
                        <div class="bg-div">
                            <img src="assets/img/bg/bg-02.png" class="bg-2" alt="img">
                        </div>
                        <ul class="countear">

                        <?php
                                $ss="SELECT * from  extra_content where type='counter' limit 4";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
                            <li class="countearli">
                                <h6><img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>" alt="Img"> <br> <?php echo $socila['heading1'];?></h6>
                                <h4><span class="counter"><?php echo $socila['heading2'];?></span>+</h4>
                            </li>
                            <?php } ?>
                            
                        </ul>
                        <div class="bg-div">
                            <img src="assets/img/bg/bg-01.png" class="bg-1" alt="img">
                        </div>
                    </div>
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
            <div class="row justify-content-center">Empowering Entrepreneurs
                <div class="col-lg-6 text-center wow fadeInUp" data-wow-delay="0.2s">
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
                    <div class="testimonial-success">
                        <div class="row g-4">
                        <?php
                                $ss="SELECT * from  testimonial  ";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socilaa){       ?>   
                            <div class="col-md-6 d-flex">
                                <div class="card flex-fill mb-0 wow fadeInDown" data-wow-delay="0.2s">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="javascript:void(0);" class="avatar avatar-lg flex-shrink-0">
                                                <img src="<?php echo $urlmain;?>images/blog/<?php echo $socilaa['image'];?>" class="rounded-circle" alt="img">
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="fs-16 fw-medium"><a href="javascript:void(0);"> <?php echo $socilaa['name'];?> </a></h6>
                                                <p>– <?php echo $socilaa['position'];?> </p>
                                            </div>
                                        </div>
                                        <p class="mb-2">" <?php echo $socilaa['content'];?> "</p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                        </div>
                        <div class="testimonials-bg">
                            <img src="assets/img/bg/testimonial-bg-01.png" alt="img" class="testimonial-bg-03">
                        </div>
                    </div>
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
            </div>

            <!-- Business-->
                                <?php
                                $ss="SELECT * from  extra_content where type='call_to_action' limit 1   ";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?>   
            <div class="business-wrap bg-dark wow zoomIn">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="business-info">
                            <h2 class="display-6 text-white mb-3"> <?php echo $socila['heading1'];?>  

</h2>
                            <?php echo str_replace('<p>', '<p class="text-light mb-4">', $socila['content']); ?>

                           
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <?php if($socila['link']!='')  { ?>
                        <div class="business-img " style="padding: 77px 0 43px 0;">
                           <a href="<?php echo $socila['link'];?>" class="btn btn-dark d-inline-flex align-items-center"><i class="isax isax-add-circle me-2"></i>Contact Now</a>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
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
  background: transparent;
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
    "Search for Private Limited Registration",
    "Search for GST Registration",
    "Search for Company Registration",
    "Search for Trust Registration",
    "Search for Startup Compliance"
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
    
    // Use both keyup and input events
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
                        dropdown.html('<div class="no-results">No services found for "' + query + '"</div>').show();
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
            const firstSuggestion = $('.search-suggestion-item:first');
            if (firstSuggestion.length) {
                const url = firstSuggestion.data('url');
                console.log('Enter pressed, navigating to:', url);
                if (url) {
                    window.location.href = url;
                }
            }
        }
    });
    
    // Hide dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-box').length) {
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