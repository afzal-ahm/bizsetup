<?php
error_reporting(0);
ob_start();
session_start();
include_once 'config.php';
$table="category";  
//print_r($res);
?>
<?php 
//data insert here
if(isset($_POST['btn-save']))
{
    $category_id = isset($_POST['category_name']) ? $_POST['category_name'] : '';
    $subcategory_id = isset($_POST['subcategory_name']) ? $_POST['subcategory_name'] : '';
    $sub_subcategory_id = isset($_POST['sub_subcategory_name']) ? $_POST['sub_subcategory_name'] : '';
    
    // Validate inputs
    if (!is_numeric($category_id) || intval($category_id) <= 0) {
        ?>
        <script>
        alert("Please select a valid Category.");
        window.history.back();
        </script>
        <?php
        exit;
    }
    if (!is_numeric($subcategory_id) || intval($subcategory_id) <= 0) {
        ?>
        <script>
        alert("Please select a valid Sub Category.");
        window.history.back();
        </script>
        <?php
        exit;
    }
    if (!is_numeric($sub_subcategory_id) || intval($sub_subcategory_id) <= 0) {
        ?>
        <script>
        alert("Please select a valid Sub-sub Category.");
        window.history.back();
        </script>
        <?php
        exit;
    }

    // Look up category name
    $category_id_escaped = mysqli_real_escape_string($conn, $category_id);
    $query2 = "SELECT * from category where category_id='$category_id_escaped'";
    $runx = mysqli_query($conn, $query2);
    $category_name = '';
    if ($runx && $cat_row = mysqli_fetch_assoc($runx)) {
        $category_name = mysqli_real_escape_string($conn, $cat_row['category_name']);
    }
     
    // Look up subcategory name
    $subcategory_id_escaped = mysqli_real_escape_string($conn, $subcategory_id);
    $query = "SELECT * from subcategory where subcategory_id='$subcategory_id_escaped'";
    $run = mysqli_query($conn, $query);
    $sub_name = '';
    if ($run && $sub_row = mysqli_fetch_assoc($run)) {
        $sub_name = mysqli_real_escape_string($conn, $sub_row['subcategory_name']);
    }
     
    // Look up sub-subcategory name
    $sub_subcategory_id_escaped = mysqli_real_escape_string($conn, $sub_subcategory_id);
    $query3 = "SELECT * from sub_subcategory where sub_subcategory_id='$sub_subcategory_id_escaped'";
    $run_subsub = mysqli_query($conn, $query3);
    $sub_sub_name = '';
    if ($run_subsub && $subsub_row = mysqli_fetch_assoc($run_subsub)) {
        $sub_sub_name = mysqli_real_escape_string($conn, $subsub_row['sub_subcategory_name']);
    }

    $show_pricing = isset($_POST['show_pricing']) ? 1 : 0;
    $price_card_amount = isset($_POST['price_card_amount']) ? mysqli_real_escape_string($conn, $_POST['price_card_amount']) : '';
    $price_card_standard = isset($_POST['price_card_standard']) ? mysqli_real_escape_string($conn, $_POST['price_card_standard']) : '';
    $price_card_premium = isset($_POST['price_card_premium']) ? mysqli_real_escape_string($conn, $_POST['price_card_premium']) : '';
    $price_card_note = isset($_POST['price_card_note']) ? mysqli_real_escape_string($conn, $_POST['price_card_note']) : '';
    $pricing_features_json = isset($_POST['pricing_features_json']) ? mysqli_real_escape_string($conn, $_POST['pricing_features_json']) : '[]';

    $headings = isset($_POST['headings']) ? $_POST['headings'] : [];
    $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : [];

    try {
        // Update parent sub-subcategory pricing card details
        $update_subsub_query = "UPDATE `sub_subcategory` 
                                SET `extra` = '$price_card_amount', 
                                    `price` = '$price_card_standard', 
                                    `day` = '$price_card_premium', 
                                    `meal` = '$price_card_note',
                                    `show_pricing` = '$show_pricing',
                                    `pricing_features` = '$pricing_features_json'
                                WHERE `sub_subcategory_id` = '$sub_subcategory_id_escaped'";
        $res_subsub = mysqli_query($conn, $update_subsub_query);
        if (!$res_subsub) {
            throw new Exception(mysqli_error($conn));
        }

        $inserted_count = 0;
        for ($i = 0; $i < count($headings); $i++) {
            $product_name = mysqli_real_escape_string($conn, $headings[$i]);
            $product_des = mysqli_real_escape_string($conn, $descriptions[$i]);
            
            if (empty(trim($product_name))) {
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
            
            // Safe SKU Generation
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
            
            $in = "INSERT INTO `product`( `sku`, `product_category`, `product_subcategory`, `sub_subcategory_id`, `product_name`, `description`, `mrp`, `offer`, `offer_amount`, `status`, `featured`, `brandactive`, `delivery`, `category`, `subcategory`, `subsubcategory`, `url`) 
                   VALUES ( '".$codep."','".$category_id."','".$subcategory_id."','".$sub_subcategory_id."','".$product_name."','".$product_des."','0','0','0','0','0','0','0','".$category_name."','".$sub_name."','".$sub_sub_name."','".$hyphenTag1."')";
            
            if (mysqli_query($conn, $in)) {
                $inserted_count++;
            } else {
                throw new Exception(mysqli_error($conn));
            }
        }

        if ($inserted_count > 0) {
            ?>
            <script type="text/javascript">
            alert('Added Successfully');
            window.location.assign("addproduct.php");
            </script>
            <?php
            exit;
        } else {
            throw new Exception("Please add at least one valid Heading Block.");
        }
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
    <title>Admin </title>
  
       <script src="ckeditor/ckeditor.js"></script>
    <!-- Fav and touch icons -->
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

	  
 
 
    <!-- for specific page in style css -->
        
    <!-- for specific page responsive in style css -->
        
    
    <!-- Custom CSS -->
    <link href="custom/custom.css" rel="stylesheet" type="text/css">



    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="js/modernizr.js"></script> 
    <script type="text/javascript" src="js/mobile-detect.min.js"></script> 
    <script type="text/javascript" src="js/mobile-detect-modernizr.js"></script> 
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#myselect').on("change",function () {
        var categoryId = $(this).find('option:selected').val();
      // alert(categoryId);
	   if(categoryId){
	    $.ajax({
            url: "selectsubcategory.php",
            type: "POST",
            data: "categoryId="+categoryId,
            success: function (response) {
                console.log(response);
                $("#myselect1").html(response);
            },
        });
	   }else{
		    $("#myselect1").html('<option value="">Select Category First</option>');
		    $("#sub_subcategory").html('<option value="">Select Sub Category First</option>');
		   
		   }
    });
	$('#myselect1').on("change",function () {
        var sub_subcategory = $(this).find('option:selected').val();
       //alert(sub_subcategory);
	   if(sub_subcategory){
	    $.ajax({
            url: "selectsubcategory.php",
            type: "POST",
            data: "sub_subcategory="+sub_subcategory,
            success: function (response) {
                console.log(response);
                $("#sub_subcategory").html(response);
                //alert(html);
            },
        });
	   }else{
		   
		    $("#sub_subcategory").html('<option value="">Select Sub Category First</option>');
		   
		   }
	}); 

});

</script>

  
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
                <li class="active">  Dashboard</li>
              </ul>
              <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle"  class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
      <div data-action="remove-header" data-original-title="Remove Top Menu Toggle"  class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
      <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle"  class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>
      
</div>
 
            </div>
          </div>
          <!-- vd_head-section -->
          
          <div class="vd_title-section clearfix">
            <div class="vd_panel-header">
              <h1>Add Product Panel</h1>
              <small class="subtitle">Admin  Dashboard</small>
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
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-bar-chart-o"></i> </span> Add Product Categories & Sub Categories </h3>
                  </div>
                  <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" action="" role="form" method="post" onsubmit="serializeFeatures()">
                      <input type="hidden" name="pricing_features_json" id="pricing_features_json" value="">
                      
                      <div class="row">
                        <div class="col-md-4">
                           <div class="form-group">
                            <label class="control-label">Select Category</label>
                            <div class="controls">
                              <select class="form-control" name="category_name" id="myselect" style="width: 90%;"> 
                                <option>----All------</option>
                                 <?php
                                   $g="SELECT * from category ";
                                   $gf=mysqli_query($conn,$g);
                                   foreach($gf as $key) {
                                       echo'<option value="'.$key['category_id'].'">'.$key['category_name'].'</option>';
                                   }
                                  ?> 
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Sub Category</label>
                            <div class="controls">
                              <select class="form-control" name="subcategory_name" id="myselect1" style="width: 90%;">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Sub SubCategory</label>
                            <div class="controls">
                              <select class="form-control" name="sub_subcategory_name" id="sub_subcategory" style="width: 90%;">
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr style="margin-top: 10px; margin-bottom: 20px; border-color: #ddd;">

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
                                  <input type="checkbox" name="show_pricing" value="1" checked style="transform: scale(1.2); margin-right: 8px; vertical-align: middle;"> 
                                  <span style="vertical-align: middle;">Active (Show Pricing Cards on Frontend)</span>
                                </label>
                                <p class="help-block" style="margin-top: 5px; margin-left: 23px;">Toggle this off if you don't want to display pricing cards on the service details page.</p>
                              </div>
                            </div>

                            <div class="row" style="margin-bottom: 20px;">
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Basic Plan Price (₹)</label>
                                  <input class="form-control" type="text" placeholder="e.g. 9999" name="price_card_amount">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Standard Plan Price (₹)</label>
                                  <input class="form-control" type="text" placeholder="e.g. 12999" name="price_card_standard">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Premium Plan Price (₹)</label>
                                  <input class="form-control" type="text" placeholder="e.g. 15999" name="price_card_premium">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group" style="padding: 0 10px;">
                                  <label style="font-weight: bold;">Price Note / Subtext</label>
                                  <input class="form-control" type="text" placeholder="e.g. + Govt Fees Extra" name="price_card_note">
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
                              <!-- Dynamic heading blocks will be added here -->
                            </div>
                            
                            <div style="margin-top: 15px;">
                              <button type="button" class="btn btn-success" id="add_heading_btn">
                                <i class="fa fa-plus"></i> Add Another Heading Block
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
                  	Copyright &copy;2018 Admin  Inc. All Rights Reserved 
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
function addHeadingBlock(name, content) {
    headingIndex++;
    var blockId = 'heading_block_' + headingIndex;
    var textareaId = 'heading_content_' + headingIndex;
    
    var html = `
        <div class="heading-block-item" id="${blockId}" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; background-color: #fff; border-radius: 4px; position: relative;">
            <button type="button" class="btn btn-xs btn-danger remove-heading-btn" onclick="removeHeadingBlock('${blockId}')" style="position: absolute; top: 10px; right: 10px;"><i class="fa fa-times"></i> Remove</button>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Heading Name</label>
                <input class="form-control heading-name-input" type="text" name="headings[]" value="${name || ''}" placeholder="e.g. Overview" required style="width: 100%; max-width: 100%;">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-weight: bold;">Heading Description/about</label>
                <textarea id="${textareaId}" name="descriptions[]" rows="10" class="form-control heading-desc-input" required>${content || ''}</textarea>
            </div>
        </div>
    `;
    
    $('#headings_container').append(html);
    
    // Initialize CKEditor on the new textarea
    CKEDITOR.replace(textareaId);
}

function removeHeadingBlock(blockId) {
    if ($('.heading-block-item').length <= 1) {
        alert('You must have at least one Heading Block.');
        return;
    }
    if (confirm('Are you sure you want to remove this Heading Block?')) {
        var textareaId = $('#' + blockId).find('textarea').attr('id');
        if (CKEDITOR.instances[textareaId]) {
            CKEDITOR.instances[textareaId].destroy();
        }
        $('#' + blockId).remove();
    }
}

$(document).ready(function() {
    // Populate default features
    if ($('#features_tbody tr').length === 0) {
        defaultFeatures.forEach(function(f) {
            addFeatureRow(f.text, f.basic, f.standard, f.premium);
        });
    }

    // Add first heading block automatically
    addHeadingBlock('Overview', '');

    // Add heading block button click handler
    $('#add_heading_btn').click(function() {
        addHeadingBlock('', '');
    });
});
</script>

</body>


</html>
