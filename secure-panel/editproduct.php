<?php
error_reporting(0);
include_once 'config.php';   
$sku = mysqli_real_escape_string($conn, $_GET['sku']);
 
$gt = "SELECT * from product where id='".$sku."'";
$res = mysqli_query($conn, $gt);
$value = mysqli_fetch_assoc($res);

$subsub_id = $value['sub_subcategory_id'];
$all_products = [];
if (!empty($subsub_id)) {
    $all_products_query = "SELECT * FROM product WHERE sub_subcategory_id = '".mysqli_real_escape_string($conn, $subsub_id)."' ORDER BY id ASC";
    $all_products_res = mysqli_query($conn, $all_products_query);
    while($p_row = mysqli_fetch_assoc($all_products_res)) {
        $all_products[] = $p_row;
    }
}

//data insert here
if(isset($_POST['btn-save']))
{
    $sub_subcategory_id = isset($_POST['sub_subcategory_id']) ? mysqli_real_escape_string($conn, $_POST['sub_subcategory_id']) : '';
    $show_pricing = isset($_POST['show_pricing']) ? 1 : 0;
    $price_card_amount = isset($_POST['price_card_amount']) ? mysqli_real_escape_string($conn, $_POST['price_card_amount']) : '';
    $price_card_standard = isset($_POST['price_card_standard']) ? mysqli_real_escape_string($conn, $_POST['price_card_standard']) : '';
    $price_card_premium = isset($_POST['price_card_premium']) ? mysqli_real_escape_string($conn, $_POST['price_card_premium']) : '';
    $price_card_note = isset($_POST['price_card_note']) ? mysqli_real_escape_string($conn, $_POST['price_card_note']) : '';
    $pricing_features_json = isset($_POST['pricing_features_json']) ? mysqli_real_escape_string($conn, $_POST['pricing_features_json']) : '[]';

    // Form headings arrays
    $heading_ids = isset($_POST['heading_ids']) ? $_POST['heading_ids'] : [];
    $headings = isset($_POST['headings']) ? $_POST['headings'] : [];
    $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : [];
    $deletes = isset($_POST['deletes']) ? $_POST['deletes'] : [];

    try {
        // 1. Update parent sub-subcategory pricing details
        if (!empty($sub_subcategory_id) && is_numeric($sub_subcategory_id) && intval($sub_subcategory_id) > 0) {
            $update_subsub = "UPDATE `sub_subcategory` 
                              SET `extra` = '$price_card_amount', 
                                  `price` = '$price_card_standard', 
                                  `day` = '$price_card_premium', 
                                  `meal` = '$price_card_note',
                                  `show_pricing` = '$show_pricing',
                                  `pricing_features` = '$pricing_features_json'
                              WHERE `sub_subcategory_id` = '$sub_subcategory_id'";
            $res_subsub = mysqli_query($conn, $update_subsub);
            if (!$res_subsub) {
                throw new Exception(mysqli_error($conn));
            }
        } else {
            throw new Exception("Invalid Sub-sub Category ID.");
        }

        // 2. Fetch category and sub-subcategory details to use when inserting new blocks
        $query_subsub = "SELECT ssc.*, c.category_name, sc.subcategory_name 
                         FROM sub_subcategory ssc
                         LEFT JOIN category c ON ssc.category_id = c.category_id
                         LEFT JOIN subcategory sc ON ssc.subcategory_id = sc.subcategory_id
                         WHERE ssc.sub_subcategory_id = '$sub_subcategory_id'";
        $run_subsub = mysqli_query($conn, $query_subsub);
        if ($run_subsub && $subsub_row = mysqli_fetch_assoc($run_subsub)) {
            $category_id = $subsub_row['category_id'];
            $subcategory_id = $subsub_row['subcategory_id'];
            $category_name = mysqli_real_escape_string($conn, $subsub_row['category_name']);
            $sub_name = mysqli_real_escape_string($conn, $subsub_row['subcategory_name']);
            $sub_sub_name = mysqli_real_escape_string($conn, $subsub_row['sub_subcategory_name']);
        } else {
            throw new Exception("Sub-subcategory details not found.");
        }

        // 3. Process each heading block in the submitted form
        $processed_count = 0;
        for ($i = 0; $i < count($headings); $i++) {
            $block_id = isset($heading_ids[$i]) ? $heading_ids[$i] : '';
            $product_name = mysqli_real_escape_string($conn, $headings[$i]);
            $product_des = mysqli_real_escape_string($conn, $descriptions[$i]);

            if (empty(trim($product_name))) {
                continue;
            }

            // Check if marked for delete
            if (!empty($block_id) && isset($deletes[$block_id]) && $deletes[$block_id] == '1') {
                $del_query = "DELETE FROM `product` WHERE `id` = '$block_id'";
                mysqli_query($conn, $del_query);
                continue;
            }

            // Safe URL generation
            $seotopic = strip_tags($product_name);
            $myTag = trim($seotopic); 
            $string01 = str_replace("'", "$%", $myTag); 
            $string = str_replace("&", "and", $string01); 
            $string1 = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
            $string12 = preg_replace("/[ ]+/", " ", $string1);                
            $hyphenTag1 = str_replace( ' ', '-', $string12 );
            $hyphenTag1 = mysqli_real_escape_string($conn, $hyphenTag1);

            if (!empty($block_id)) {
                // Update existing product block
                $up_query = "UPDATE `product` 
                             SET `product_name` = '$product_name', 
                                 `description` = '$product_des',
                                 `url` = '$hyphenTag1'
                             WHERE `id` = '$block_id'";
                $up_res = mysqli_query($conn, $up_query);
                if (!$up_res) {
                    throw new Exception(mysqli_error($conn));
                }
                $processed_count++;
            } else {
                // Insert new product block
                // SKU generation
                $sku_query = "SELECT sku from product order by id desc limit 0,1";
                $run_sku = mysqli_query($conn, $sku_query);
                $sku2 = 1;
                if ($run_sku && mysqli_num_rows($run_sku) > 0) {
                    $sku_row = mysqli_fetch_assoc($run_sku);
                    $sku_id1 = $sku_row['sku'];
                    $sku1 = intval(preg_replace('/[^0-9]+/', '', $sku_id1), 10);
                    $sku2 = $sku1 + 1;
                }
                $p = "Fosso"; 
                $product_sku = $p . $sku2;

                $hyphenTag1111 = str_replace( '-', '', $hyphenTag1 );
                $hyphenTag1111 = str_replace( '(', '', $hyphenTag1111 );
                $hyphenTag1111 = str_replace( ')', '', $hyphenTag1111 );
                $hyphenTag1111 = str_replace( ',', '', $hyphenTag1111 );
                $hyphenTag1x = strtolower($hyphenTag1111);
                $dd = date('dm');
                $hyphenTag1x = strip_tags($hyphenTag1x);
                $random_digit = rand(000000, 999999);
                $codep = $hyphenTag1x . $random_digit . $dd;

                $in_query = "INSERT INTO `product`( `sku`, `product_category`, `product_subcategory`, `sub_subcategory_id`, `product_name`, `description`, `mrp`, `offer`, `offer_amount`, `status`, `featured`, `brandactive`, `delivery`, `category`, `subcategory`, `subsubcategory`, `url`) 
                             VALUES ( '".$codep."','".$category_id."','".$subcategory_id."','".$sub_subcategory_id."','".$product_name."','".$product_des."','0','0','0','0','0','0','0','".$category_name."','".$sub_name."','".$sub_sub_name."','".$hyphenTag1."')";
                $in_res = mysqli_query($conn, $in_query);
                if (!$in_res) {
                    throw new Exception(mysqli_error($conn));
                }
                $processed_count++;
            }
        }

        ?>
        <script>
        alert("Service Details and Price Card Updated Successfully");
        window.location = 'inventory.php';
        </script>
        <?php
        exit;
    } catch (Exception $e) {
        $error_msg = mysqli_real_escape_string($conn, $e->getMessage());
        ?>
        <script>
        alert("Database Error: <?php echo htmlspecialchars($error_msg); ?>");
        window.history.back();
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
    <title>Admin</title>
    
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    
    
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

	     <script src="ckeditor/ckeditor.js"></script>
 
 
    <!-- for specific page in style css -->
        
    <!-- for specific page responsive in style css -->
        
    
    <!-- Custom CSS -->
    <link href="custom/custom.css" rel="stylesheet" type="text/css">



    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="js/modernizr.js"></script> 
    <script type="text/javascript" src="js/mobile-detect.min.js"></script> 
    <script type="text/javascript" src="js/mobile-detect-modernizr.js"></script> 
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>

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
              <h1>Admin Dashboard</h1>
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
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-bar-chart-o"></i> </span> Edit Product </h3>
                  </div>
                  <div class="panel-body">
                    <?php
                    $subsub_id = $value['sub_subcategory_id'];
                    $subsub_price = '';
                    $subsub_standard = '';
                    $subsub_premium = '';
                    $subsub_note = '';
                    $show_pricing = 1;
                    $pricing_features = '';
                    if (!empty($subsub_id)) {
                        $subsub_query = "SELECT * FROM sub_subcategory WHERE sub_subcategory_id = '".mysqli_real_escape_string($conn, $subsub_id)."'";
                        $subsub_run = mysqli_query($conn, $subsub_query);
                        if ($subsub_run && $subsub_row = mysqli_fetch_assoc($subsub_run)) {
                            $subsub_price = $subsub_row['extra'];
                            $subsub_standard = $subsub_row['price'];
                            $subsub_premium = $subsub_row['day'];
                            $subsub_note = $subsub_row['meal'];
                            $show_pricing = isset($subsub_row['show_pricing']) ? intval($subsub_row['show_pricing']) : 1;
                            $pricing_features = $subsub_row['pricing_features'];
                        }
                    }
                    ?>
                    <form class="form-horizontal" action="" role="form" method="post" onsubmit="serializeFeatures()">
                      <input type="hidden" name="sub_subcategory_id" value="<?php echo htmlspecialchars($subsub_id); ?>">
                      <input type="hidden" name="pricing_features_json" id="pricing_features_json" value="">
                      
                      <!-- Pricing Plan Details Section -->
                      <div class="row">
                        <div class="col-md-12">
                          <div style="margin-bottom: 25px; padding: 20px; border: 1px solid #ddd; background-color: #fcfcfc; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: bold; border-bottom: 2px solid #5d9cec; padding-bottom: 8px; color: #333;">
                              <i class="fa fa-money"></i> Pricing Plan Details
                            </h4>
                            
                            <div class="row" style="margin-bottom: 20px;">
                              <div class="col-md-12">
                                <label style="font-weight: bold; cursor: pointer; font-size: 14px;">
                                  <input type="checkbox" name="show_pricing" value="1" <?php echo $show_pricing == 1 ? 'checked' : ''; ?> style="transform: scale(1.2); margin-right: 8px; vertical-align: middle;"> 
                                  <span style="vertical-align: middle;">Active (Show Pricing Cards on Frontend)</span>
                                </label>
                                <p class="help-block" style="margin-top: 5px; margin-left: 23px;">Toggle this off if you don't want to display pricing cards on the service details page.</p>
                              </div>
                            </div>

                            <div class="row" style="margin-bottom: 20px;">
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Basic Plan Price (₹)</label>
                                  <input class="form-control" type="text" value="<?php echo htmlspecialchars($subsub_price); ?>" placeholder="e.g. 9999" name="price_card_amount">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Standard Plan Price (₹)</label>
                                  <input class="form-control" type="text" value="<?php echo htmlspecialchars($subsub_standard); ?>" placeholder="e.g. 12999" name="price_card_standard">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Premium Plan Price (₹)</label>
                                  <input class="form-control" type="text" value="<?php echo htmlspecialchars($subsub_premium); ?>" placeholder="e.g. 15999" name="price_card_premium">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Price Note / Subtext</label>
                                  <input class="form-control" type="text" value="<?php echo htmlspecialchars($subsub_note); ?>" placeholder="e.g. + Govt Fees Extra" name="price_card_note">
                                </div>
                              </div>
                            </div>

                            <div style="margin-top: 20px;">
                              <label style="font-weight: bold; margin-bottom: 12px; font-size: 14px;">What you'll get (Features Comparison Ticks/Crosses):</label>
                              <table class="table table-bordered table-striped" id="features_table" style="background-color: #fff;">
                                <thead>
                                  <tr style="background-color: #f1f1f1;">
                                    <th style="font-weight: bold;">Feature Description</th>
                                    <th style="width: 100px; text-align: center; font-weight: bold;">Basic</th>
                                    <th style="width: 100px; text-align: center; font-weight: bold;">Standard</th>
                                    <th style="width: 100px; text-align: center; font-weight: bold;">Premium</th>
                                    <th style="width: 60px; text-align: center; font-weight: bold;">Remove</th>
                                  </tr>
                                </thead>
                                <tbody id="features_tbody">
                                  <!-- Rows populated via JS -->
                                </tbody>
                              </table>
                              <button type="button" class="btn btn-sm btn-info" onclick="addFeatureRow('', false, false, false)">
                                <i class="fa fa-plus"></i> Add Feature Row
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Heading & Description Blocks Section -->
                      <div class="row">
                        <div class="col-md-12">
                          <div style="margin-bottom: 25px; padding: 20px; border: 1px solid #ddd; background-color: #fcfcfc; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: bold; border-bottom: 2px solid #8cc152; padding-bottom: 8px; color: #333;">
                              <i class="fa fa-list"></i> Heading Name & Description Blocks (Tabs)
                            </h4>
                            
                            <div id="headings_container">
                              <!-- Loop over existing product blocks -->
                              <?php foreach ($all_products as $index => $prod) { 
                                  $block_id = 'heading_block_existing_' . $prod['id'];
                                  $textarea_id = 'heading_content_existing_' . $prod['id'];
                              ?>
                              <div class="heading-block-item" id="<?php echo $block_id; ?>" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; background-color: #fff; border-radius: 4px; position: relative;">
                                  <input type="hidden" name="heading_ids[]" value="<?php echo $prod['id']; ?>">
                                  
                                  <div style="position: absolute; top: 10px; right: 10px; font-weight: bold; color: red;">
                                      <label style="cursor: pointer; color: #d9534f;">
                                          <input type="checkbox" name="deletes[<?php echo $prod['id']; ?>]" value="1" style="transform: scale(1.1); margin-right: 5px; vertical-align: middle;">
                                          <span style="vertical-align: middle;">Delete Block</span>
                                      </label>
                                  </div>
                                  
                                  <div class="form-group" style="margin-bottom: 15px;">
                                      <label style="font-weight: bold;">Heading Name</label>
                                      <input class="form-control heading-name-input" type="text" name="headings[]" value="<?php echo htmlspecialchars($prod['product_name']); ?>" required style="width: 100%; max-width: 100%;">
                                  </div>
                                  
                                  <div class="form-group" style="margin-bottom: 0;">
                                      <label style="font-weight: bold;">Heading Description/about</label>
                                      <textarea id="<?php echo $textarea_id; ?>" name="descriptions[]" rows="10" class="form-control heading-desc-input ckeditor" required><?php echo $prod['description']; ?></textarea>
                                  </div>
                              </div>
                              <?php } ?>
                              
                              <div id="new_headings_container"></div>
                            </div>
                            
                            <div style="margin-top: 15px;">
                              <button type="button" class="btn btn-success" id="add_heading_btn">
                                <i class="fa fa-plus"></i> Add New Heading Block
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12" style="margin-top: 15px; margin-bottom: 30px;">
                          <button class="btn vd_btn vd_bg-green vd_white btn-lg" type="submit" name="btn-save">
                            <i class="icon-ok"></i> Save Service Details
                          </button>
                        </div>
                      </div>
                    </form>m>
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
                  	Copyright &copy;2018 Admin Inc. All Rights Reserved 
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




<script type="text/javascript">
$(window).load(function() 
	{
	
		"use strict";
	
		$(window).on("resize", function(){
			plot.resize();
			plot.setupGrid();
			plot.draw();
		});
				

		$.fn.UseTooltip = function () {
			var previousPoint = null;
			 
			$(this).bind("plothover", function (event, pos, item) {        
					if (item) {
						if (previousPoint != item.dataIndex) {
		
							previousPoint = item.dataIndex;
		
							$("#tooltip").remove();
							var x = item.datapoint[0].toFixed(2),
							y = item.datapoint[1].toFixed(2);
		
							showTooltip(item.pageX, item.pageY,
								"<p class='vd_bg-green'><strong class='mgr-10 mgl-10'>" + Math.round(x)  + " NOV 2013 </strong></p>" +
								"<div style='padding: 0 10px 10px;'>" +
								"<div>" + item.series.label +": <strong>"+ Math.round(y)  +"</strong></div>" +
								"<div> Profit: <strong>$"+ Math.round(y)*7  +"</strong></div>" +
								"</div>"
							);
						}
					} else {
						$("#tooltip").remove();
						previousPoint = null;            
					}
			});
		};
		 
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css({
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 20,    
				size: '10',  
//				'border-top' : '3px solid #1FAE66',
				'background-color': '#111111',
				color: "#FFFFFF",
				opacity: 0.85
			}).appendTo("body").fadeIn(200);
		}


/* REVENUE LINE CHART */

	var d2 = [ [1, 250],
            [2, 150],
            [3, 50],
            [4, 200],
            [5,50],
            [6, 150],
            [7, 150],
            [8, 200],
            [9, 100],
            [10, 250],
            [11,250],
            [12, 200],
            [13, 300]			

];
	var d1 = [
			[1, 650],
            [2, 550],
            [3, 450],
            [4, 550],
            [5, 350],
            [6, 500],
            [7, 600],
            [8, 450],
            [9, 300],
            [10, 600],
            [11, 400],
            [12, 500],
            [13, 700]					
			
];
	var plot = $.plotAnimator($("#revenue-line-chart"), [
			{  	label: "Revenue",
				data: d2, 	
				lines: {				
					fill: 0.4,
					lineWidth: 0,				
				},
				color:['#f2be3e']
			},{ 
				data: d1, 
				animator: {steps: 60, duration: 1000, start:0}, 		
				lines: {lineWidth:2},	
				shadowSize:0,
				color: '#F85D2C'
			},{
				label: "Revenue",
				data: d1, 
				points: { show: true, fill: true, radius:6,fillColor:"#F85D2C",lineWidth:3 },	
				color: '#fff',				
				shadowSize:0
			},
			{	label: "Cost",
				data: d2, 
				points: { show: true, fill: true, radius:6,fillColor:"#f2be3e",lineWidth:3 },	
				color: '#fff',				
				shadowSize:0
			}
		],{	xaxis: {
		tickLength: 0,
		tickDecimals: 0,
		min:2,

				font :{
					lineHeight: 13,
					style: "normal",
					weight: "bold",
					family: "sans-serif",
					variant: "small-caps",
					color: "#6F7B8A"
				}
			},
			yaxis: {
				ticks: 3,
                tickDecimals: 0,
				tickColor: "#f0f0f0",
				font :{
					lineHeight: 13,
					style: "normal",
					weight: "bold",
					family: "sans-serif",
					variant: "small-caps",
					color: "#6F7B8A"
				}
			},
			grid: {
				backgroundColor: { colors: [ "#fff", "#fff" ] },
				borderWidth:1,borderColor:"#f0f0f0",
				margin:0,
				minBorderMargin:0,							
				labelMargin:20,
				hoverable: true,
				clickable: true,
				mouseActiveRadius:6
			},
			legend: { show: false}
		});

 		$("#revenue-line-chart").UseTooltip();		



/* REVENUE DONUT CHART */
	
		var data2 = [],
			series = 3;
		var data2 = [
			{ label: "Men",  data: 35},
			{ label: "Women",  data: 65}
		];
		var revenue_donut_chart = $("#revenue-donut-chart");
		
		$("#revenue-donut-chart").bind("plotclick", function (event, pos, item) {
			if (item) {
				$("#clickdata").text(" - click point " + item.dataIndex + " in " + item.series.label);
				plot.highlight(item.series, item.datapoint);
			}
		});
		$.plot(revenue_donut_chart, data2, {
			series: {
				pie: { 
					innerRadius: 0.4,
					show: true
				}
			},
			grid: {
				hoverable: true,
				clickable: true,
			},
			colors: ["#1FAE66", "#F85D2C "]				
		});
		
		
/* REVENUE BAR CHART */	
	
		var bar_chart_data = [ ["Jan", 10], ["Feb", 8], ["Mar", 4], ["Apr", 13], ["May", 17], ["Jun", 9], ["Jul", 10], ["Aug", 8], ["Sep", 4], ["Oct", 13], ["Nov", 17], ["Dec", 9] ];
		
        var bar_chart = $.plot(
        $("#revenue-bar-chart"), [{
            data: bar_chart_data,
 //           color: "rgba(31,174,102, 0.8)",
 			color: "#F85D2C" ,
            shadowSize: 0,
            bars: {
                show: true,
                lineWidth: 0,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 1
                    }, {
                        opacity: 1
                    }]
                }
            }
        }], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.9,
					align: "center"
                }
            },
            grid: {
                show: true,
                hoverable: true,
                borderWidth: 0
            },
            yaxis: {
                min: 0,
                max: 20,
				show: false
            },
			xaxis: {
				mode: "categories",
				tickLength: 0,
				color: "#FFFFFF",				
			}			
        });
		
	   var previousPoint2 = null;
       $("#revenue-bar-chart").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint2 != item.dataIndex) {
                    previousPoint2 = item.dataIndex;
                    $("#tooltip").remove();
                    var x = item.datapoint[0] + 1,
                        y = item.datapoint[1].toFixed(2);
                    showTooltip(item.pageX, item.pageY, 
								"<p class='vd_bg-green'><strong class='mgr-10 mgl-10'>" + x + " - 2013 </strong></p>" +
								"<div style='padding: 0 10px 10px;'>" +
								"<div> Sales: <strong>"+ Math.round(y)*17  +"</strong></div>" +
								"<div> Profit: <strong>$"+ Math.round(y)*280  +"</strong></div>" +
								"</div>"										
					);
                }
            }
        });

        $('#revenue-bar-chart').bind("mouseleave", function () {
            $("#tooltip").remove();
        });



/* PIE CHART */

		var pie_placeholder = $("#pie-chart");

		var pie_data = [];
		
		pie_data[0] = {
			label: "IE",
			data: 10
		}
		pie_data[1] = {
			label: "Safari",
			data: 8
		}	
		pie_data[2] = {
			label: "Opera",
			data: 8
		}				
		pie_data[3] = {
			label: "Chrome",
			data: 13
		}	
		pie_data[4] = {
			label: "Firefox",
			data: 17
		}	
		pie_data[5] = {
			label: "Other",
			data: 3
		}					
		$.plot(pie_placeholder, pie_data, {
			series: {
				pie: { 
					show: true,
					label:{
						show: true,
						radius: .5,
						formatter: labelFormatter,
						background: {
							opacity: 0
						}
					},

				}
			},
			grid: {
				hoverable: true,
				clickable: true
			},
			colors: ["#FCB660", "#ce91db", "#56A2CF", "#52D793", "#FC8660", "#CCCCCC"]
		});

		pie_placeholder.bind("plothover", function(event, pos, obj) {
			if (!obj) {
				return;
			}
			var percent = parseFloat(obj.series.percent).toFixed(2);
			$("#hover").html("<span style='font-weight:bold; color:" + obj.series.color + "'>" + obj.series.label + " (" + percent + "%)</span>");
		});

		pie_placeholder.bind("plotclick", function(event, pos, obj) {
			if (!obj) {
				return;
			}
            var percent;
            percent = parseFloat(obj.series.percent).toFixed(2);
			alert(""  + obj.series.label + ": " + percent + "%");
		});

	function labelFormatter(label, series) {
		return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
	}
		



		
// Notification
	  setTimeout(function() { notification("topright","notify","fa fa-exclamation-triangle vd_yellow","Welcome to Vendroid","Click on <i class='fa fa-question-circle vd_red'></i> Question Mark beside filter to take a view layout tour guide"); },1500)	 ; 
	  

});
</script>
<!-- Specific Page Scripts END -->






<script type="text/javascript">
var defaultFeatures = [
    { text: "1 DSC (Digital Signature)", basic: 1, standard: 0, premium: 0 },
    { text: "2 DSC (Digital Signatures)", basic: 0, standard: 1, premium: 1 },
    { text: "1 DIN (Director Identification)", basic: 1, standard: 0, premium: 0 },
    { text: "2 DIN (Director Identifications)", basic: 0, standard: 1, premium: 1 },
    { text: "Name Reservation filing", basic: 1, standard: 1, premium: 1 },
    { text: "SPICe+ Form Preparation", basic: 1, standard: 1, premium: 1 },
    { text: "MOA & AOA Drafting", basic: 1, standard: 1, premium: 1 },
    { text: "PAN & TAN Allotment", basic: 1, standard: 1, premium: 1 },
    { text: "GST Registration", basic: 0, standard: 1, premium: 1 },
    { text: "MSME (Udyam) Certificate", basic: 0, standard: 1, premium: 1 },
    { text: "PF & ESIC Registration", basic: 0, standard: 0, premium: 1 }
];

var savedFeatures = <?php echo !empty($pricing_features) ? $pricing_features : '[]'; ?>;

function addFeatureRow(text, basic, standard, premium) {
    var rowId = 'feature_row_' + Math.random().toString(36).substr(2, 9);
    var html = `
        <tr id="${rowId}">
            <td>
                <input type="text" class="form-control feature-text" value="${text || ''}" placeholder="Feature Description" style="width: 100%;">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <input type="checkbox" class="feature-basic" ${basic ? 'checked' : ''} style="transform: scale(1.2);">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <input type="checkbox" class="feature-standard" ${standard ? 'checked' : ''} style="transform: scale(1.2);">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <input type="checkbox" class="feature-premium" ${premium ? 'checked' : ''} style="transform: scale(1.2);">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <button type="button" class="btn btn-xs btn-danger" onclick="$('#${rowId}').remove()"><i class="fa fa-times"></i></button>
            </td>
        </tr>
    `;
    $('#features_tbody').append(html);
}

function serializeFeatures() {
    // Force CKEditor to update the underlying textarea values before submitting
    for (var instanceName in CKEDITOR.instances) {
        if (CKEDITOR.instances[instanceName]) {
            CKEDITOR.instances[instanceName].updateElement();
        }
    }

    var features = [];
    $('#features_tbody tr').each(function() {
        var text = $(this).find('.feature-text').val();
        if (text && text.trim() !== '') {
            var basic = $(this).find('.feature-basic').is(':checked') ? 1 : 0;
            var standard = $(this).find('.feature-standard').is(':checked') ? 1 : 0;
            var premium = $(this).find('.feature-premium').is(':checked') ? 1 : 0;
            features.push({
                text: text.trim(),
                basic: basic,
                standard: standard,
                premium: premium
            });
        }
    });
    $('#pricing_features_json').val(JSON.stringify(features));
}

var headingIndex = 0;
function addNewHeadingBlock(name, content) {
    headingIndex++;
    var blockId = 'heading_block_new_' + headingIndex;
    var textareaId = 'heading_content_new_' + headingIndex;
    
    var html = `
        <div class="heading-block-item" id="${blockId}" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; background-color: #fff; border-radius: 4px; position: relative;">
            <input type="hidden" name="heading_ids[]" value="">
            <button type="button" class="btn btn-xs btn-danger remove-heading-btn" onclick="removeHeadingBlock('${blockId}')" style="position: absolute; top: 10px; right: 10px;"><i class="fa fa-times"></i> Remove</button>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Heading Name (New Block)</label>
                <input class="form-control heading-name-input" type="text" name="headings[]" value="${name || ''}" placeholder="e.g. Benefits" required style="width: 100%; max-width: 100%;">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-weight: bold;">Heading Description/about</label>
                <textarea id="${textareaId}" name="descriptions[]" rows="10" class="form-control heading-desc-input" required>${content || ''}</textarea>
            </div>
        </div>
    `;
    
    $('#new_headings_container').append(html);
    
    // Initialize CKEditor on the new textarea
    CKEDITOR.replace(textareaId);
}

function removeHeadingBlock(blockId) {
    if (confirm('Are you sure you want to remove this Heading Block?')) {
        var textareaId = $('#' + blockId).find('textarea').attr('id');
        if (CKEDITOR.instances[textareaId]) {
            CKEDITOR.instances[textareaId].destroy();
        }
        $('#' + blockId).remove();
    }
}

$(document).ready(function() {
    // Populate features
    if (savedFeatures && savedFeatures.length > 0) {
        savedFeatures.forEach(function(f) {
            addFeatureRow(f.text, f.basic, f.standard, f.premium);
        });
    } else {
        defaultFeatures.forEach(function(f) {
            addFeatureRow(f.text, f.basic, f.standard, f.premium);
        });
    }

    // Add heading block button click handler
    $('#add_heading_btn').click(function() {
        addNewHeadingBlock('', '');
    });

    // Dim block on delete checkbox toggle
    $(document).on('change', 'input[name^="deletes"]', function() {
        var block = $(this).closest('.heading-block-item');
        if ($(this).is(':checked')) {
            block.css('opacity', '0.5');
            block.css('background-color', '#f8d7da');
        } else {
            block.css('opacity', '1.0');
            block.css('background-color', '#fff');
        }
    });
});
</script>

</body>


</html>
