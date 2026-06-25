 <div class="main-header main-header-four" style="box-shadow: -2px 3px 43px  -20px rgba(0, 0, 0, 0.25);">
        <!-- Header Topbar-->
        
        <!-- /Header Topbar-->

        <!-- Header -->
        <header class="header-four">
            <div class="container ">
                <div class="offcanvas-info">
                    <div class="offcanvas-wrap">
                        <div class="offcanvas-detail">
                            <div class="offcanvas-head">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <a href="<?php echo $urlmain;?>" class="black-logo-responsive">
                                        <img src="<?php echo $urlmain;?>images/<?php echo $company_logo;?>"  style="    max-width: 150px;" alt="logo-img">
                                    </a>
                                    <a href="<?php echo $urlmain;?>" class="white-logo-responsive">
                                        <img src="<?php echo $urlmain;?>images/<?php echo $company_logo;?>"  style="    max-width: 150px;" alt="logo-img">
                                    </a>
                                    <div class="offcanvas-close">
                                        <i class="ti ti-x"></i>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="mobile-menu fix mb-3"></div>
                            <div class="offcanvas__contact">
                                <div class="mt-4">
                                    <div class="header-dropdown d-flex flex-fill">
                                       
                                    </div>
                                    <div class="mb-3">
                                        <a href="tel:<?php echo $company_whatsapp_no; ?>" class="btn btn-talk-expert-custom w-100 d-inline-flex align-items-center justify-content-center">
                                            <span class="talk-expert-content-wrapper">
                                                <span class="talk-expert-inner">
                                                    <span class="talk-expert-default">
                                                        <i class="isax isax-call-calling5 me-2"></i>Talk to Experts
                                                    </span>
                                                    <span class="talk-expert-hover">
                                                        <i class="isax isax-call-calling5 me-2"></i><?php 
                                                            $formatted_phone = $company_whatsapp_no;
                                                            if (strlen($formatted_phone) == 10) {
                                                                $formatted_phone = '+91 ' . substr($formatted_phone, 0, 5) . ' ' . substr($formatted_phone, 5);
                                                            }
                                                            echo htmlspecialchars($formatted_phone); 
                                                        ?>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="btn btn-contact-custom w-100 mb-3">  <a href="javascript:void(0);" class="text-white" data-bs-toggle="modal" data-bs-target="#register-modal">Contact Us</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offcanvas-overlay"></div>
                <div class="header-nav">
                    <div class="main-menu-wrapper">
                        <div class="navbar-logo">
                            <a class="logo-white header-logo" href="<?php echo $urlmain;?>">
                                <img src="<?php echo $urlmain;?>images/<?php echo $company_logo;?>" style="    max-width: 150px;" class="logo" alt="Logo">
                            </a>
                            <a class="logo-dark header-logo" href="<?php echo $urlmain;?>">
                                <img src="<?php echo $urlmain;?>images/<?php echo $company_logo;?>"  style="    max-width: 150px;" class="logo" alt="Logo">
                            </a>
                        </div>
                        <nav id="mobile-menu">
                            <ul class="main-nav">

                            <?php $c='1';
                           $ss="SELECT * from category where is_active='1' and  show_in_header='1' order by position asc";
                           $re=mysqli_query($conn,$ss);
                           foreach($re as $key=> $cate){
                            ?>
                                <li class="has-submenu megamenu <?php if($c=='1') { echo 'active';}?>">
                                    <a href="javascript:void(0);"><?php echo $cate['category_name'];?><i class="fa-solid fa-angle-down"></i></a>
                                    <?php
                                   $sql="select count(*) as total from subcategory where category_id='".$cate['category_id']."'";
$result=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($result);
$subt =$data['total'];
if($subt > 0) {
?>
                                    <ul class="submenu mega-submenu">
                                        <li>
                                            <div class="megamenu-wrapper">
                                                <?php   
                                                // Get all subcategories for this category
                                                $subcategories_query = "SELECT * FROM subcategory WHERE category_id='".$cate['category_id']."' ORDER BY subcategory_id ASC";
                                                $subcategories_result = mysqli_query($conn, $subcategories_query);
                                                $total_subcategories = mysqli_num_rows($subcategories_result);
                                                
                                                // Auto-adjust columns based on content and optimal space usage
                                                $column_class = 'auto-column';
                                                ?>
                                                <div class="auto-grid">
                                                    <?php
                                                    foreach($subcategories_result as $scate) {
                                                        // Get sub-subcategories for this subcategory
                                                        $sub_subcategories_query = "SELECT * FROM sub_subcategory WHERE category_id='".$cate['category_id']."' AND subcategory_id='".$scate['subcategory_id']."' AND status = 1 ORDER BY sub_subcategory_id ASC";
                                                        $sub_subcategories_result = mysqli_query($conn, $sub_subcategories_query);
                                                        
                                                        if(mysqli_num_rows($sub_subcategories_result) > 0) {
                                                    ?>
                                                    <div class="auto-column">
                                                        <div class="subcategory-section">
                                                            <h6 class="subcategory-title mb-3"><?php echo $scate['subcategory_name'];?></h6>
                                                            <div class="sub-subcategory-list">
                                                                <?php
                                                                foreach($sub_subcategories_result as $subcategory1) {
                                                                ?>
                                                                <div class="sub-subcategory-item">
                                                                    <a href="<?php echo $urlmain;?>service_detail.php?cat_url=<?php echo $cate['url'];?>&sub_url=<?php echo $scate['url'];?>&subsub_url=<?php echo $subcategory1['sub_subcategory_id'];?>" class="sub-subcategory-link"><?php echo $subcategory1['sub_subcategory_name'];?></a>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                        }
                                                    } 
                                                    ?>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php } ?>
                                </li>
                               <?php $c++;} ?>
                                 
                               
                            </ul>
                        </nav>
                        <div class="header-btn d-flex align-items-center">
                            
                                                        <a href="tel:<?php echo $company_whatsapp_no; ?>" class="btn btn-talk-expert-custom d-inline-flex align-items-center me-3">
                                 <span class="talk-expert-content-wrapper">
                                     <span class="talk-expert-inner">
                                         <span class="talk-expert-default">
                                             <i class="isax isax-call-calling5 me-2"></i>Talk to Experts
                                         </span>
                                         <span class="talk-expert-hover">
                                             <i class="isax isax-call-calling5 me-2"></i><?php 
                                                 $formatted_phone = $company_whatsapp_no;
                                                 if (strlen($formatted_phone) == 10) {
                                                     $formatted_phone = '+91 ' . substr($formatted_phone, 0, 5) . ' ' . substr($formatted_phone, 5);
                                                 }
                                                 echo htmlspecialchars($formatted_phone); 
                                             ?>
                                         </span>
                                     </span>
                                 </span>
                             </a>
                             <a href="<?php echo $urlmain;?>contact.php" class="btn btn-contact-custom d-inline-flex align-items-center me-3"><i class="isax isax-lock me-2"></i>Contact Us</a>
                          
                            <div class="header__hamburger d-xl-none my-auto">
                                <div class="sidebar-menu">
                                    <i class="isax isax-menu5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- /Header -->
        
        <style>
        .btn-contact-custom {
            background-color: #f18d2d !important;
            border-color: #f18d2d !important;
            color: #ffffff !important;
            height: 42px !important;
            padding: 0 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-sizing: border-box !important;
        }
        .btn-contact-custom:hover,
        .btn-contact-custom:focus,
        .btn-contact-custom:active,
        .btn-contact-custom.active {
            background-color: #d97706 !important;
            border-color: #d97706 !important;
            color: #ffffff !important;
        }
        .btn-talk-expert-custom {
            background-color: #f18d2d !important;
            border-color: #f18d2d !important;
            color: #ffffff !important;
            position: relative;
            overflow: hidden;
            border-radius: 40px;
            font-weight: 500;
            padding: 0 20px !important;
            height: 42px !important;
            box-sizing: border-box !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: background-color 0.3s ease, border-color 0.3s ease !important;
        }
        .btn-talk-expert-custom:hover,
        .btn-talk-expert-custom:focus,
        .btn-talk-expert-custom:active,
        .btn-talk-expert-custom.active {
            background-color: #d97706 !important;
            border-color: #d97706 !important;
            color: #ffffff !important;
        }
        .talk-expert-content-wrapper {
            position: relative;
            display: block;
            height: 24px;
            overflow: hidden;
        }
        .talk-expert-inner {
            display: flex;
            flex-direction: column;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .talk-expert-default,
        .talk-expert-hover {
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }
        .btn-talk-expert-custom:hover .talk-expert-inner {
            transform: translateY(-24px);
        }
        /* Responsive Megamenu Styling - Yellow Theme */
        .mega-submenu {
            width: 100vw !important;
            max-width: 1200px !important;
            min-width: 320px !important;
            padding: 15px 20px;
            box-shadow: 0 8px 25px rgba(255,193,7,0.15);
            border-radius: 0 0 12px 12px;
            border: none;
            border-top: 3px solid #ffc107;
            left: 50% !important;
            transform: translateX(-50%) !important;
            right: auto !important;
            background: #ffffff;
            z-index: 9999;
        }
        
        .megamenu-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Responsive auto-grid system */
        .auto-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            width: 100%;
            align-items: start;
            justify-content: start;
        }
        
        .auto-column {
            width: 100%;
            min-width: 0;
        }
        
        .subcategory-section {
            padding: 12px 15px;
            border: 1px solid #f0f0f0;
            height: fit-content;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            background: #fafbfc;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .subcategory-section:hover {
            background-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,193,7,0.2);
            border-color: #ffc107;
        }
        
        .subcategory-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 6px;
            margin-bottom: 8px;
            position: relative;
        }
        
        .subcategory-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 20px;
            height: 2px;
            background: #ff9800;
        }
        
        .sub-subcategory-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex-grow: 1;
        }
        
        .sub-subcategory-item {
            margin: 0;
        }
        
        .sub-subcategory-link {
            color: #555;
            text-decoration: none;
            font-size: 11px;
            font-weight: 400;
            padding: 3px 6px;
            display: block;
            transition: all 0.2s ease;
            border-radius: 4px;
            border-left: 2px solid transparent;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
        }
        
        .sub-subcategory-link:hover {
            color: #f57c00;
            background-color: #fff8e1;
            border-left-color: #ffc107;
            transform: translateX(2px);
        }
        
        /* Responsive breakpoints */
        @media (min-width: 1200px) {
            .auto-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 18px;
            }
            .mega-submenu {
                padding: 20px 25px;
            }
        }
        
        @media (max-width: 1199px) and (min-width: 992px) {
            .auto-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)) !important;
                gap: 12px !important;
            }
            .mega-submenu {
                width: 940px !important;
                max-width: 95vw !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                right: auto !important;
            }
        }
        
        @media (max-width: 991px) {
            .mega-submenu {
                width: 100vw !important;
                max-width: none !important;
                left: 0 !important;
                transform: none !important;
                border-radius: 0;
                padding: 15px;
            }
            
            .auto-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 12px;
            }
            
            .subcategory-section {
                min-height: 70px;
                padding: 10px 12px;
            }
        }
        
        @media (max-width: 768px) {
            .auto-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            
            .subcategory-section {
                min-height: 60px;
                padding: 8px 10px;
            }
            
            .subcategory-title {
                font-size: 11px;
                margin-bottom: 6px;
            }
            
            .sub-subcategory-link {
                font-size: 10px;
                padding: 2px 4px;
            }
        }
        
        @media (max-width: 576px) {
            .auto-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .mega-submenu {
                padding: 10px;
            }
            
            .subcategory-section {
                min-height: 50px;
                padding: 6px 8px;
            }
        }
        
        /* Animation for menu appearance */
        .mega-submenu {
            animation: slideDown 0.3s ease-out;
            opacity: 1;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
        
        /* Mobile menu animation override */
        @media (max-width: 991px) {
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
        
        /* Ensure proper positioning and prevent overflow */
        .has-submenu.megamenu {
            position: static !important;
        }
        
        .has-submenu.megamenu .submenu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
        }
        
        /* Improve visual hierarchy - Yellow Theme */
        .subcategory-title {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Enhanced hover states - Yellow Theme */
        .subcategory-section:hover .subcategory-title {
            -webkit-text-fill-color: #f57c00;
        }
        
        .subcategory-section:hover .sub-subcategory-link {
            color: #666;
        }
        
        .subcategory-section:hover .sub-subcategory-link:hover {
            color: #f57c00;
        }
        </style>
        
        <script>
        // Responsive megamenu optimization
        document.addEventListener('DOMContentLoaded', function() {
            const megamenus = document.querySelectorAll('.mega-submenu');
            
            function optimizeMegamenu() {
                megamenus.forEach(menu => {
                    const grid = menu.querySelector('.auto-grid');
                    if (grid) {
                        const columns = grid.querySelectorAll('.auto-column');
                        const viewportWidth = window.innerWidth;
                        
                        // Responsive grid optimization based on viewport
                        if (viewportWidth >= 1200) {
                            // Desktop - optimal space usage
                            const totalColumns = columns.length;
                            if (totalColumns <= 4) {
                                grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(220px, 1fr))';
                            } else if (totalColumns <= 6) {
                                grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(200px, 1fr))';
                            } else {
                                grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(180px, 1fr))';
                            }
                        } else if (viewportWidth >= 992) {
                            // Tablet landscape
                            grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(170px, 1fr))';
                        } else if (viewportWidth >= 768) {
                            // Tablet portrait
                            grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(150px, 1fr))';
                        } else if (viewportWidth >= 576) {
                            // Mobile landscape
                            grid.style.gridTemplateColumns = 'repeat(2, 1fr)';
                        } else {
                            // Mobile portrait
                            grid.style.gridTemplateColumns = '1fr';
                        }
                        
                        // Optimize column content distribution
                        columns.forEach((column) => {
                            const section = column.querySelector('.subcategory-section');
                            const items = column.querySelectorAll('.sub-subcategory-item');
                            
                            // Adjust section height based on content
                            if (items.length <= 3) {
                                section.style.minHeight = viewportWidth >= 768 ? '80px' : '60px';
                            } else if (items.length <= 6) {
                                section.style.minHeight = viewportWidth >= 768 ? '120px' : '90px';
                            } else {
                                section.style.minHeight = viewportWidth >= 768 ? '160px' : '120px';
                            }
                        });
                    }
                });
            }
            
            // Initial optimization
            optimizeMegamenu();
            
            // Re-optimize on window resize with debounce
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(optimizeMegamenu, 250);
            });
            
            // Enhanced hover effects for better UX
            megamenus.forEach(menu => {
                const sections = menu.querySelectorAll('.subcategory-section');
                sections.forEach(section => {
                    section.addEventListener('mouseenter', function() {
                        this.style.zIndex = '10';
                    });
                    
                    section.addEventListener('mouseleave', function() {
                        this.style.zIndex = '1';
                    });
                });
            });
        });
        </script>
    </div>