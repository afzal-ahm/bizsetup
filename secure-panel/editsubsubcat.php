<?php
/**
 * Created by PhpStorm.
 * User: Deep
 * Date: 3/28/2016
 * Time: 10:27 AM
 */
error_reporting(0);
include_once 'config.php'; 
//data insert here
if(isset($_GET['subcatid'])){
    $subcatid = mysqli_real_escape_string($conn, $_GET['subcatid']);
     $table = "sub_subcategory";
    $field_value=array($subcatid);
    
    $tty="SELECT * from sub_subcategory  where sub_subcategory_id='".$subcatid."'";
    $res=mysqli_query($conn,$tty);
   
}


if(isset($_POST['btn-save']))
{
    $table = "sub_subcategory";
    
    $subcatid = isset($_POST['subcatid']) ? mysqli_real_escape_string($conn, $_POST['subcatid']) : (isset($_GET['subcatid']) ? mysqli_real_escape_string($conn, $_GET['subcatid']) : 0);
    if (!is_numeric($subcatid) || intval($subcatid) <= 0) {
        ?>
        <script>
            alert("Invalid Sub-sub Category ID");
            window.location ='viewsub-subcat.php';
        </script>
        <?php
        exit;
    }
   
    $catname = mysqli_real_escape_string($conn, $_POST['sub_subcategory_name']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // SEO Fields
    $seo_title = mysqli_real_escape_string($conn, $_POST['seo_title']);
    $seo_keywords = mysqli_real_escape_string($conn, $_POST['seo_keywords']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    
    // Updated timestamp
    $updated_at = date('Y-m-d H:i:s');
    
    $meal = mysqli_real_escape_string($conn, $_POST['meal']);
    $extra = mysqli_real_escape_string($conn, $_POST['extra']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $hero_features_raw = isset($_POST['hero_features']) ? $_POST['hero_features'] : '';
    if (is_array($hero_features_raw)) {
        $hero_features_raw = array_filter(array_map('trim', $hero_features_raw));
        $hero_features = implode("\n", $hero_features_raw);
    } else {
        $hero_features = trim($hero_features_raw);
    }
    $hero_features = mysqli_real_escape_string($conn, $hero_features);
    
    try {
        $image_name = $_FILES['image']['name'];
        if($image_name !="" ){
            $image_type = $_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $random_digit=rand(0000,9999);
            $imagename = $random_digit.$image_name;
            move_uploaded_file($image_tmp,"../images/category/$imagename");
            $imagename = mysqli_real_escape_string($conn, $imagename);
            
            $ttu="UPDATE `sub_subcategory` SET  `image`='".$imagename."'  WHERE sub_subcategory_id='".$subcatid."'";
            mysqli_query($conn,$ttu);
        }  
        
        $ttu="UPDATE `sub_subcategory` SET  `sub_subcategory_name`='".$catname."',`meal`='".$meal."',`content`='".$content."', `extra`='".$extra."',`price`='".$price."',`seo_title`='".$seo_title."',`seo_keywords`='".$seo_keywords."',`meta_description`='".$meta_description."',`hero_features`='".$hero_features."',`updated_at`='".$updated_at."' WHERE sub_subcategory_id='".$subcatid."'";
        $res1=mysqli_query($conn,$ttu);
        
        if($res1)
        {
            ?>
            <script>
                alert("Edit Successfully");
                window.location ='viewsub-subcat.php';
            </script>
            <?php
        }
        else {
            throw new Exception("Update query failed.");
        }
    } catch (Exception $e) {
        $error_msg = mysqli_real_escape_string($conn, $e->getMessage());
        ?>
        <script>
            alert("Error updating database: <?php echo htmlspecialchars($error_msg); ?>");
            window.location ='viewsub-subcat.php';
        </script>
        <?php
        exit;
    }
}
?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->

<!-- Specific Page Data -->

<!-- End of Data -->


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8" />
    <title>admin</title>
    <meta name="keywords" content="HTML5 Template, CSS3, All Purpose Admin Template, " />
    <meta name="description" content="Responsive Admin Template for e-commerce dashboard">
    <meta name="author" content="Venmond">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


	  <script src="ckeditor/ckeditor.js"></script>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">


    <!-- CSS -->

    <!-- Bootstrap & FontAwesome & Entypo CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if IE 7]><link type="text/css" rel="stylesheet" href="css/font-awesome-ie7.min.css"><![endif]-->
    <link href="css/font-entypo.css" rel="stylesheet" type="text/css">

    <!-- Fonts CSS -->
    <link href="css/fonts.css"  rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="plugins/jquery-ui/jquery-ui.custom.min.css" rel="stylesheet" type="text/css">
    <link href="plugins/prettyPhoto-plugin/css/prettyPhoto.css" rel="stylesheet" type="text/css">
    <link href="plugins/isotope/css/isotope.css" rel="stylesheet" type="text/css">
    <link href="plugins/pnotify/css/jquery.pnotify.css" media="screen" rel="stylesheet" type="text/css">
    <link href="plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">


    <link href="plugins/mCustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
    <link href="plugins/tagsInput/jquery.tagsinput.css" rel="stylesheet" type="text/css">
    <link href="plugins/bootstrap-switch/bootstrap-switch.css" rel="stylesheet" type="text/css">
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css">
    <link href="plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
    <link href="plugins/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">

    <!-- Specific CSS -->
    <link href="plugins/introjs/css/introjs.min.css" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/theme.min.css" rel="stylesheet" type="text/css">
    <!--[if IE]> <link href="css/ie.css" rel="stylesheet" > <![endif]-->
    <link href="css/chrome.css" rel="stylesheet" type="text/chrome"> <!-- chrome only css -->



    <!-- Responsive CSS -->
    <link href="css/theme-responsive.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>


    <!-- for specific page in style css -->

    <!-- for specific page responsive in style css -->


    <!-- Custom CSS -->
    <link href="custom/custom.css" rel="stylesheet" type="text/css">
    
    <!-- Admin Form Styling -->
    <style>
        .form-section-header {
            color: #2c3e50 !important;
            border-bottom: 2px solid #ffc107 !important;
            padding-bottom: 8px !important;
            margin-bottom: 20px !important;
            margin-top: 30px !important;
            font-weight: 600 !important;
        }
        
        .form-section-header:first-child {
            margin-top: 0 !important;
        }
        
        .help-block {
            color: #666 !important;
            font-size: 11px !important;
            margin-top: 5px !important;
        }
        
        .char-counter {
            float: right;
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }
        
        .char-counter.warning {
            color: #f39c12;
        }
        
        .char-counter.danger {
            color: #e74c3c;
        }
        
        .form-group {
            margin-bottom: 20px !important;
        }
        
        .controls input[type="text"], .controls textarea {
            border: 1px solid #ddd !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
        }
        
        .controls input[type="text"]:focus, .controls textarea:focus {
            border-color: #ffc107 !important;
            box-shadow: 0 0 5px rgba(255, 193, 7, 0.3) !important;
        }
        
        .existing-data {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            border-left: 3px solid #ffc107;
            margin-bottom: 10px;
            font-size: 12px;
            color: #666;
        }
    </style>



    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="js/modernizr.js"></script>
    <script type="text/javascript" src="js/mobile-detect.min.js"></script>
    <script type="text/javascript" src="js/mobile-detect-modernizr.js"></script>



</head>

<body id="dashboard" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix" data-active="dashboard "  data-smooth-scrolling="1">
<div class="vd_body">
    <!-- Header Start -->
    <?php include"header.php"; ?>
    <!-- Header Ends -->
    <div class="content">
        <div class="container">
            <?php include"adminleftmenu.php";?>

            <div class="vd_navbar vd_nav-width vd_navbar-chat vd_bg-black-80 vd_navbar-right   ">
                <div class="navbar-tabs-menu clearfix">
			<span class="expand-menu" data-action="expand-navbar-tabs-menu">
            	<span class="menu-icon menu-icon-left">
            		<i class="fa fa-ellipsis-h"></i>
                    <span class="badge vd_bg-red">
                        20
                    </span>
                </span>
            	<span class="menu-icon menu-icon-right">
            		<i class="fa fa-ellipsis-h"></i>
                    <span class="badge vd_bg-red">
                        20
                    </span>
                </span>
            </span>
                    <div class="menu-container">
                        <div class="navbar-search-wrapper">
                            <div class="navbar-search vd_bg-black-30">
                                <span class="append-icon"><i class="fa fa-search"></i></span>
                                <input type="text" placeholder="Search" class="vd_menu-search-text no-bg no-bd vd_white width-70" name="search">
                                <div class="pull-right search-config">
                                    <a  data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle" ><span class="prepend-icon vd_grey"><i class="fa fa-cog"></i></span></a>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="navbar-menu clearfix">
                    <div class="content-list content-image content-chat">
                        <ul class="list-wrapper no-bd-btm pd-lr-10">
                            <li class="group-heading vd_bg-black-20">FAVORITE</li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar.jpg" alt="example image"></div>
                                    <div class="menu-text">Jessylin
                                        <div class="menu-info">
                                            <span class="menu-date">Administrator </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="badge status vd_bg-green">&nbsp;</span></div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-2.jpg" alt="example image"></div>
                                    <div class="menu-text">Rodney Mc.Cardo
                                        <div class="menu-info">
                                            <span class="menu-date">Designer </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="badge status vd_bg-grey">&nbsp;</span></div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-3.jpg" alt="example image"></div>
                                    <div class="menu-text">Theresia Minoque
                                        <div class="menu-info">
                                            <span class="menu-date">Engineering </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="badge status vd_bg-green">&nbsp;</span></div>
                                </a>
                            </li>
                            <li class="group-heading vd_bg-black-20">FRIENDS</li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-4.jpg" alt="example image"></div>
                                    <div class="menu-text">Greg Grog
                                        <div class="menu-info">
                                            <span class="menu-date">Developer </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="badge status vd_bg-grey">&nbsp;</span></div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-5.jpg" alt="example image"></div>
                                    <div class="menu-text">Stefanie Imburgh
                                        <div class="menu-info">
                                            <span class="menu-date">Dancer</span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="vd_grey font-sm"><i class="fa fa-mobile"></i></span></div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-6.jpg" alt="example image"></div>
                                    <div class="menu-text">Matt Demon
                                        <div class="menu-info">
                                            <span class="menu-date">Musician </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="vd_grey font-sm"><i class="fa fa-mobile"></i></span></div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-7.jpg" alt="example image"></div>
                                    <div class="menu-text">Jeniffer Anastasia
                                        <div class="menu-info">
                                            <span class="menu-date">Senior Developer </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="badge status vd_bg-green">&nbsp;</span></div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="menu-icon"><img src="img/avatar/avatar-8.jpg" alt="example image"></div>
                                    <div class="menu-text">Daniel Dreamon
                                        <div class="menu-info">
                                            <span class="menu-date">Sales Executive </span>
                                        </div>
                                    </div>
                                    <div class="menu-badge"><span class="badge status vd_bg-green">&nbsp;</span></div>
                                </a>
                            </li>

                        </ul>
                    </div>


                </div>
                <div class="navbar-spacing clearfix">
                </div>
            </div>
            <!-- Middle Content Start -->

            <div class="vd_content-wrapper">
                <div class="vd_container">
                    <div class="vd_content clearfix">
                        <div class="vd_head-section clearfix">
                            <div class="vd_panel-header">
                                <ul class="breadcrumb">
                                    <li><a href="">Home</a> </li>
                                    <li class="active">E-Commerce Dashboard</li>
                                </ul>
                                <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
                                    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
                                    <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
                                    <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>

                                </div>

                            </div>
                        </div>
                        <!-- vd_head-section -->

                        <div class="vd_title-section clearfix">
                            <div class="vd_panel-header">
                                <h1>Edit Sub-sub Category Panel</h1>
                                <small class="subtitle">Admin Dashboard</small>
                                <div class="vd_panel-menu  hidden-xs">
                                    <div class="menu no-bg vd_red" data-original-title="Start Layout Tour Guide" data-toggle="tooltip" data-placement="bottom" onClick="javascript:introJs().setOption('showBullets', false).start();"> <span class="menu-icon font-md"><i class="fa fa-question-circle"></i></span> </div>
                                    <!-- menu -->


                                    <!-- menu -->
                                </div>
                                <!-- vd_panel-menu -->
                            </div>
                            <!-- vd_panel-header -->
                        </div>
                        <!-- vd_title-section -->

                        <div class="row" id="advanced-input">
                            <div class="col-md-12">
                                <div class="panel widget">
                                    <div class="panel-heading vd_bg-grey">
                                        <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-bar-chart-o"></i> </span> Edit Sub-sub Category </h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                         $catid = 0;
                                         $subcatid = 0;
                                         $dataval = [];
                                         if (isset($res) && $res && mysqli_num_rows($res) > 0) {
                                             $dataval = mysqli_fetch_assoc($res);
                                             $catid = $dataval['category_id']; 
                                             $subcatid = $dataval['subcategory_id'];
                                         }
                                        ?>
                                        <form class="form-horizontal" action="" method="post" role="form" enctype="multipart/form-data">
                                          <div class="form-group">
                                                <label class="col-sm-2 control-label">Category Name</label>
                                                <div class="col-sm-7 controls">
                                               <?php 
                                               if ($catid > 0) {
                                                   $query = "SELECT * from category where category_id='$catid'";
														$run = mysqli_query($conn, $query);
														if ($run && $val_cat1 = mysqli_fetch_assoc($run)) {
														    echo htmlspecialchars($val_cat1['category_name']); 
                                                        }
                                               }
                                                ?>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Sub Category Name</label>
                                                <div class="col-sm-7 controls">
                                                   <?php 
                                                   if ($subcatid > 0) {
                                                        $query = "SELECT * from subcategory where subcategory_id='$subcatid'";
														$run = mysqli_query($conn, $query);
														if ($run && $val_cat2 = mysqli_fetch_assoc($run)) {
															echo htmlspecialchars($val_cat2['subcategory_name']); 
                                                        }
                                                   }
                                                ?>
                                                </div>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Sub Sub_Category Name</label>
                                                <div class="col-sm-7 controls">
                                                    <input class="width-70" type="text" value="<?php echo $dataval['sub_subcategory_name']; ?>" data-toggle="tooltip" data-placement="top" name="sub_subcategory_name">
                                                </div>
                                            </div>
                                            
                                            <!-- SEO Section -->
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h4 class="form-section-header">
                                                        <i class="fa fa-search"></i> SEO Settings
                                                    </h4>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">SEO Title</label>
                                                <div class="col-sm-7 controls">
                                                    <?php if(isset($dataval['seo_title']) && !empty($dataval['seo_title'])): ?>
                                                        <div class="existing-data">Current: <?php echo htmlspecialchars($dataval['seo_title']); ?></div>
                                                    <?php endif; ?>
                                                    <input class="width-70" type="text" placeholder="SEO friendly title for search engines" 
                                                           value="<?php echo isset($dataval['seo_title']) ? htmlspecialchars($dataval['seo_title']) : ''; ?>" 
                                                           name="seo_title" maxlength="60" id="seo_title">
                                                    <small class="help-block">Recommended: 50-60 characters</small>
                                                    <span class="char-counter" id="seo_title_counter">0/60</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Meta Description</label>
                                                <div class="col-sm-7 controls">
                                                    <?php if(isset($dataval['meta_description']) && !empty($dataval['meta_description'])): ?>
                                                        <div class="existing-data">Current: <?php echo htmlspecialchars($dataval['meta_description']); ?></div>
                                                    <?php endif; ?>
                                                    <textarea class="width-70" rows="3" placeholder="Brief description for search engine results" 
                                                              name="meta_description" maxlength="160" id="meta_description"><?php echo isset($dataval['meta_description']) ? htmlspecialchars($dataval['meta_description']) : ''; ?></textarea>
                                                    <small class="help-block">Recommended: 150-160 characters</small>
                                                    <span class="char-counter" id="meta_description_counter">0/160</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">SEO Keywords</label>
                                                <div class="col-sm-7 controls">
                                                    <?php if(isset($dataval['seo_keywords']) && !empty($dataval['seo_keywords'])): ?>
                                                        <div class="existing-data">Current: <?php echo htmlspecialchars($dataval['seo_keywords']); ?></div>
                                                    <?php endif; ?>
                                                    <input class="width-70" type="text" placeholder="keyword1, keyword2, keyword3" 
                                                           value="<?php echo isset($dataval['seo_keywords']) ? htmlspecialchars($dataval['seo_keywords']) : ''; ?>" 
                                                           name="seo_keywords">
                                                    <small class="help-block">Separate keywords with commas</small>
                                                </div>
                                            </div>
                                            
                                            <!-- Media Section -->
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h4 class="form-section-header">
                                                        <i class="fa fa-image"></i> Media Files
                                                    </h4>
                                                </div>
                                            </div>
  
                        <div class="form-group">
                        <label class="col-sm-2 control-label">Update Image</label>
                        <div class="col-sm-7 controls">
                          
                          <input type="file" name="image" accept="image/*">
                          <small class="help-block">Upload new image</small>
                        </div>
                      </div> 
                  
                   <div class="form-group">
                        <label class="col-sm-2 control-label">Previous Images</label>
                        <div class="col-sm-7 controls">
                          <img src="../images/category/<?php echo $dataval['image']; ?>" height="60" width="60">
                        </div>
                      
                      </div>  
                                            <!-- Pricing Section -->
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h4 class="form-section-header">
                                                        <i class="fa fa-money"></i> Pricing Information
                                                    </h4>
                                                </div>
                                            </div>
  
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">New Price</label>
                                                <div class="col-sm-7 controls">
                                                    <input class="width-70" type="text" value="<?php echo $dataval['extra']; ?>" data-toggle="tooltip" data-placement="top" name="extra">
                                                </div>
                                            </div>
  
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Old Price</label>
                                                <div class="col-sm-7 controls">
                                                    <input class="width-70" type="text" value="<?php echo $dataval['price']; ?>" data-toggle="tooltip" data-placement="top" name="price">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Extra content after price Like Inclusive</label>
                                                <div class="col-sm-7 controls">
                                                    <input class="width-70" type="text" value="<?php echo $dataval['meal']; ?>" data-toggle="tooltip" data-placement="top" name="meal">
                                                </div>
                                            </div>
                                            
                                            <!-- Content Section -->
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h4 class="form-section-header">
                                                        <i class="fa fa-edit"></i> Content
                                                    </h4>
                                                </div>
                                            </div>
  
                                             <div class="form-group">
                                                 <label class="col-sm-2 control-label">Edit Description/about</label>
                                                 <div class="col-sm-7 controls">
                                                     <textarea class="ckeditor" id="" cols="70" name="content" rows="20"><?php echo $dataval['content']; ?></textarea>
                                                 </div>
                                             </div> 
                                             
                                             <div class="form-group">
                                                 <label class="col-sm-2 control-label">Key Features</label>
                                                 <div class="col-sm-7 controls">
                                                     <div id="features-container">
                                                         <?php 
                                                         $features = [];
                                                         if (!empty($dataval['hero_features'])) {
                                                             $features = array_filter(array_map('trim', explode("\n", $dataval['hero_features'])));
                                                         }
                                                         if (empty($features)) {
                                                             $features = [''];
                                                         }
                                                         foreach ($features as $feature) {
                                                         ?>
                                                             <div class="feature-row" style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                                                                 <input class="width-70 form-control" type="text" name="hero_features[]" value="<?php echo htmlspecialchars($feature); ?>" placeholder="Enter feature point" style="display: inline-block; vertical-align: middle;">
                                                                 <button type="button" class="btn vd_btn vd_bg-red vd_white remove-feature-btn" style="padding: 6px 12px; margin-left: 5px; vertical-align: middle;"><i class="fa fa-trash"></i></button>
                                                             </div>
                                                         <?php } ?>
                                                     </div>
                                                     <button type="button" id="add-feature-btn" class="btn vd_btn vd_bg-blue vd_white" style="margin-top: 5px;"><i class="fa fa-plus"></i> Add Point</button>
                                                     <small class="help-block" style="margin-top: 10px; display: block;">Add key features that will be shown at the top of the service page.</small>
                                                 </div>
                                             </div>
                    

 							

                                            <input type="hidden" name="subcatid" value="<?php echo $_GET['subcatid'] ;?>">
                                            <button class="btn vd_btn vd_bg-green vd_white" type="submit" name="btn-save"><i class="icon-ok"></i> Save</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Panel Widget -->
                            </div>
                            <!-- col-md-12 -->
                        </div>
                        <!-- .vd_content-section -->

                    </div>
                    <!-- .vd_content -->
                </div>
                <!-- .vd_container -->
            </div>
            <!-- .vd_content-wrapper -->

            <!-- Middle Content End -->

        </div>
    </div>
    <!-- Footer Start -->
    <footer class="footer-1"  id="footer">
        <div class="vd_bottom ">
            <div class="container">
                <div class="row">
                    <div class=" col-xs-12">
                        <div class="copyright">
                            Copyright &copy;2015 admin Inc. All Rights Reserved
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- container -->
        </div>
    </footer>
    <!-- Footer END -->
    <div class="vd_chat-menu hidden-xs">
        <div class="vd_mega-menu-wrapper">

        </div>
    </div>

</div>

<!-- .vd_body END  -->
<a id="back-top" href="#" data-action="backtop" class="vd_back-top visible"> <i class="fa  fa-angle-up"> </i> </a>

<!--
<a class="back-top" href="#" id="back-top"> <i class="icon-chevron-up icon-white"> </i> </a> -->

<!-- Javascript =============================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="js/jquery.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src='plugins/jquery-ui/jquery-ui.custom.min.js'></script>
<script type="text/javascript" src="plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<script type="text/javascript" src="js/caroufredsel.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>

<script type="text/javascript" src="plugins/breakpoints/breakpoints.js"></script>
<script type="text/javascript" src="plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>

<script type="text/javascript" src="plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="plugins/tagsInput/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="plugins/blockUI/jquery.blockUI.js"></script>
<script type="text/javascript" src="plugins/pnotify/js/jquery.pnotify.min.js"></script>

<script type="text/javascript" src="js/theme.js"></script>
<script type="text/javascript" src="custom/custom.js"></script>

<!-- Specific Page Scripts Put Here -->
<!-- Flot Chart  -->
<script type="text/javascript" src="plugins/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="plugins/flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="plugins/flot/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="plugins/flot/jquery.flot.categories.min.js"></script>
<script type="text/javascript" src="plugins/flot/jquery.flot.animator.min.js"></script>

<!-- Vector Map -->
<script type="text/javascript" src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script type="text/javascript" src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Calendar -->
<script type="text/javascript" src='plugins/jquery-ui/jquery-ui.custom.min.js'></script>
<script type="text/javascript" src='plugins/fullcalendar/fullcalendar.min.js'></script>

<!-- Intro JS (Tour) -->
<script type="text/javascript" src='plugins/introjs/js/intro.min.js'></script>
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>

 

<script src="js/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    // SEO Character Counters
    function updateCharCounter(inputId, counterId, maxLength) {
        var input = document.getElementById(inputId);
        var counter = document.getElementById(counterId);
        
        if (input && counter) {
            var currentLength = input.value.length;
            counter.textContent = currentLength + '/' + maxLength;
            
            // Remove existing classes
            counter.classList.remove('warning', 'danger');
            
            // Add warning/danger classes based on length
            if (currentLength > maxLength * 0.8) {
                counter.classList.add('warning');
            }
            if (currentLength > maxLength * 0.95) {
                counter.classList.add('danger');
            }
        }
    }
    
    // SEO Title counter
    $('#seo_title').on('input', function() {
        updateCharCounter('seo_title', 'seo_title_counter', 60);
    });
    
    // Meta Description counter
    $('#meta_description').on('input', function() {
        updateCharCounter('meta_description', 'meta_description_counter', 160);
    });
    
    // Initialize counters on page load
    updateCharCounter('seo_title', 'seo_title_counter', 60);
    updateCharCounter('meta_description', 'meta_description_counter', 160);

    // Dynamic Key Features List
    $('#add-feature-btn').click(function() {
        var rowHtml = '<div class="feature-row" style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">' +
                      '<input class="width-70 form-control" type="text" name="hero_features[]" placeholder="Enter feature point" style="display: inline-block; vertical-align: middle;">' +
                      '<button type="button" class="btn vd_btn vd_bg-red vd_white remove-feature-btn" style="padding: 6px 12px; margin-left: 5px; vertical-align: middle;"><i class="fa fa-trash"></i></button>' +
                      '</div>';
        $('#features-container').append(rowHtml);
    });

    $(document).on('click', '.remove-feature-btn', function() {
        $(this).closest('.feature-row').remove();
    });
});
</script>

</body>


</html>
