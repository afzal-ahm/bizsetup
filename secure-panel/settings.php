<?php
error_reporting(0);
ob_start();
session_start();
include_once 'config.php';

// Check if user is logged in
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

// Create locations table if it doesn't exist
$create_locations_table = "CREATE TABLE IF NOT EXISTS company_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_name VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    address TEXT,
    email VARCHAR(255),
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_locations_table);

// Handle form submissions
if(isset($_POST['save_company'])) {
    $website_name = mysqli_real_escape_string($conn, $_POST['website_name']);
    $whatsapp_no = mysqli_real_escape_string($conn, $_POST['whatsapp_no']);
    $enquiry_email = mysqli_real_escape_string($conn, $_POST['enquiry_email']);
    $copyright = mysqli_real_escape_string($conn, $_POST['copyright']);
    
    // Handle logo upload
    if(isset($_FILES['logo']) && $_FILES['logo']['name'] != '') {
        $logo_name = $_FILES['logo']['name'];
        $logo_tmp = $_FILES['logo']['tmp_name'];
        $logo_ext = pathinfo($logo_name, PATHINFO_EXTENSION);
        $logo_new_name = 'logo_' . time() . '.' . $logo_ext;
        move_uploaded_file($logo_tmp, "../images/" . $logo_new_name);
        
        $query = "UPDATE settings SET value = '$logo_new_name' WHERE setting_key = 'company_logo'";
        mysqli_query($conn, $query);
    }
    
    // Handle favicon upload
    if(isset($_FILES['favicon']) && $_FILES['favicon']['name'] != '') {
        $favicon_name = $_FILES['favicon']['name'];
        $favicon_tmp = $_FILES['favicon']['tmp_name'];
        $favicon_ext = pathinfo($favicon_name, PATHINFO_EXTENSION);
        $favicon_new_name = 'favicon_' . time() . '.' . $favicon_ext;
        move_uploaded_file($favicon_tmp, "../images/" . $favicon_new_name);
        
        $query = "UPDATE settings SET value = '$favicon_new_name' WHERE setting_key = 'company_favicon'";
        mysqli_query($conn, $query);
    }
    
    // Update other company settings
    $settings = [
        'website_name' => $website_name,
        'whatsapp_no' => $whatsapp_no,
        'enquiry_email' => $enquiry_email,
        'copyright' => $copyright
    ];
    
    foreach($settings as $key => $value) {
        $query = "UPDATE settings SET value = '$value' WHERE setting_key = 'company_$key'";
        mysqli_query($conn, $query);
    }
    
    $success_msg = "Company settings updated successfully!";
}

if(isset($_POST['save_contact'])) {
    $contact_heading = mysqli_real_escape_string($conn, $_POST['contact_heading']);
    
    // Update contact heading
    $query = "UPDATE settings SET value = '$contact_heading' WHERE setting_key = 'contact_heading'";
    mysqli_query($conn, $query);
    
    $success_msg = "Contact settings updated successfully!";
}

if(isset($_POST['add_location'])) {
    $location_name = mysqli_real_escape_string($conn, $_POST['location_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Handle image upload
    $image_name = '';
    if(isset($_FILES['location_image']) && $_FILES['location_image']['name'] != '') {
        $img_name = $_FILES['location_image']['name'];
        $img_tmp = $_FILES['location_image']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $image_name = 'location_' . time() . '.' . $img_ext;
        move_uploaded_file($img_tmp, "../images/" . $image_name);
    }
    
    $query = "INSERT INTO company_locations (location_name, phone, address, email, image) VALUES ('$location_name', '$phone', '$address', '$email', '$image_name')";
    if(mysqli_query($conn, $query)) {
        $success_msg = "Location added successfully!";
    } else {
        $error_msg = "Error adding location: " . mysqli_error($conn);
    }
}

if(isset($_POST['update_location'])) {
    $location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
    $location_name = mysqli_real_escape_string($conn, $_POST['location_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Handle image upload
    if(isset($_FILES['location_image']) && $_FILES['location_image']['name'] != '') {
        $img_name = $_FILES['location_image']['name'];
        $img_tmp = $_FILES['location_image']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $image_name = 'location_' . time() . '.' . $img_ext;
        move_uploaded_file($img_tmp, "../images/" . $image_name);
        
        $query = "UPDATE company_locations SET location_name='$location_name', phone='$phone', address='$address', email='$email', image='$image_name' WHERE id='$location_id'";
    } else {
        $query = "UPDATE company_locations SET location_name='$location_name', phone='$phone', address='$address', email='$email' WHERE id='$location_id'";
    }
    
    if(mysqli_query($conn, $query)) {
        $success_msg = "Location updated successfully!";
    } else {
        $error_msg = "Error updating location: " . mysqli_error($conn);
    }
}

if(isset($_GET['delete_location'])) {
    $location_id = mysqli_real_escape_string($conn, $_GET['delete_location']);
    $query = "DELETE FROM company_locations WHERE id='$location_id'";
    if(mysqli_query($conn, $query)) {
        $success_msg = "Location deleted successfully!";
    } else {
        $error_msg = "Error deleting location: " . mysqli_error($conn);
    }
}

if(isset($_POST['save_seo'])) {
    $seo_title = mysqli_real_escape_string($conn, $_POST['seo_title']);
    $seo_keywords = mysqli_real_escape_string($conn, $_POST['seo_keywords']);
    $seo_description = mysqli_real_escape_string($conn, $_POST['seo_description']);
    
    $seo_settings = [
        'title' => $seo_title,
        'keywords' => $seo_keywords,
        'description' => $seo_description
    ];
    
    foreach($seo_settings as $key => $value) {
        $query = "UPDATE settings SET value = '$value' WHERE setting_key = 'seo_$key'";
        mysqli_query($conn, $query);
    }
    
    $success_msg = "SEO settings updated successfully!";
}

if(isset($_POST['save_code'])) {
    $google_analytics = mysqli_real_escape_string($conn, $_POST['google_analytics']);
    $chat_code = mysqli_real_escape_string($conn, $_POST['chat_code']);
    $header_code = mysqli_real_escape_string($conn, $_POST['header_code']);
    
    $code_settings = [
        'google_analytics' => $google_analytics,
        'chat_code' => $chat_code,
        'header_code' => $header_code
    ];
    
    foreach($code_settings as $key => $value) {
        $query = "UPDATE settings SET value = '$value' WHERE setting_key = 'code_$key'";
        mysqli_query($conn, $query);
    }
    
    $success_msg = "Code injection settings updated successfully!";
}

// Get current settings
function getSetting($conn, $key) {
    $query = "SELECT value FROM settings WHERE setting_key = '$key'";
    $result = mysqli_query($conn, $query);
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return '';
}

// Get all locations
function getLocations($conn) {
    $locations = [];
    $query = "SELECT * FROM company_locations ORDER BY sort_order, location_name";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $locations[] = $row;
        }
    }
    
    return $locations;
}

// Initialize settings table if it doesn't exist
$create_table = "CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_table);

// Insert default settings if they don't exist
$default_settings = [
    'company_logo', 'company_favicon', 'company_website_name', 'company_whatsapp_no', 
    'company_enquiry_email', 'company_copyright', 'contact_heading', 'contact_phone', 
    'contact_address', 'contact_email', 'contact_location', 'contact_image', 
    'seo_title', 'seo_keywords', 'seo_description', 'code_google_analytics', 
    'code_chat_code', 'code_header_code'
];

foreach($default_settings as $setting) {
    $check = "SELECT id FROM settings WHERE setting_key = '$setting'";
    $result = mysqli_query($conn, $check);
    if(mysqli_num_rows($result) == 0) {
        $insert = "INSERT INTO settings (setting_key, value) VALUES ('$setting', '')";
        mysqli_query($conn, $insert);
    }
}

$locations = getLocations($conn);
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
     
     <!-- SweetAlert CSS -->
     <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">



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

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .settings-container { padding: 20px; }
        .nav-tabs > li > a { font-family: 'Poppins', sans-serif; font-weight: 500; }
        .form-group label { font-weight: 500; color: #333; }
        .btn-primary { background-color: #008e93; border-color: #008e93; }
        .btn-primary:hover { background-color: #007a7e; border-color: #007a7e; }
        .alert { border-radius: 8px; }
        .card { border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #008e93, #00a8ae); color: white; border-radius: 12px 12px 0 0; }
        .upload-preview { max-width: 200px; max-height: 200px; border-radius: 8px; }
        .location-item { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e9ecef; }
        
        /* Fix tab spacing and styling */
        .nav-tabs {
            border-bottom: 2px solid #008e93;
            margin-bottom: 0;
        }
        
        .nav-tabs > li > a {
            color: #666;
            border: none;
            border-radius: 0;
            padding: 12px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .nav-tabs > li > a:hover {
            background-color: #f8f9fa;
            border: none;
            color: #008e93;
            text-decoration: none;
        }
        
        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:focus,
        .nav-tabs > li.active > a:hover {
            background-color: #008e93;
            border: none;
            color: white;
            font-weight: 600;
            text-decoration: none;
        }
        
        .tab-content {
            padding: 0 !important;
            margin: 0 !important;
            border: none;
        }
        
        .tab-pane {
            display: none;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .tab-pane.active {
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        /* Card styling improvements */
        .card {
            margin: 0 !important;
            border: none;
            box-shadow: none;
        }
        
        .card-header {
            padding: 15px 20px;
            margin: 0;
        }
        
        .card-body {
            padding: 20px;
            margin: 0;
        }
        
        /* Ensure proper spacing */
        .panel-body {
            padding: 20px;
        }
        
        /* Remove any extra spacing from tab content */
        .tab-content > .tab-pane {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Fix any Bootstrap 3 compatibility issues */
        .d-flex {
            display: flex !important;
        }
        
        .justify-content-between {
            justify-content: space-between !important;
        }
        
        .align-items-center {
            align-items: center !important;
        }
        
        .mb-3 {
            margin-bottom: 15px !important;
        }
        
        .mt-3 {
            margin-top: 15px !important;
        }
        
        .ml-3 {
            margin-left: 15px !important;
        }
        
        /* Additional spacing fixes */
        .tab-pane .card {
            margin: 0 !important;
        }
        
        .tab-pane .card:first-child {
            margin-top: 0 !important;
        }
        
        .tab-pane .card:last-child {
            margin-bottom: 0 !important;
        }
        
        /* Ensure tab content container has no extra space */
        #settingsTabContent {
            margin: 0 !important;
            padding: 0 !important;
            border: none;
        }
        
        /* Remove any default Bootstrap spacing */
        .tab-content > .tab-pane {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Ensure smooth tab transitions without spacing issues */
        .tab-pane {
            transition: none;
        }
        
        /* Fix for any remaining spacing issues */
        .panel-body .tab-content {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Force remove all spacing */
        .tab-content,
        .tab-pane,
        .tab-pane.active,
        .tab-pane .card {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Only allow padding in card content */
        .card-body {
            padding: 20px !important;
        }
        
                 .card-header {
             padding: 15px 20px !important;
         }
         
         /* Toast animations */
         @keyframes slideInRight {
             from {
                 transform: translateX(100%);
                 opacity: 0;
             }
             to {
                 transform: translateX(0);
                 opacity: 1;
             }
         }
         
         @keyframes slideOutRight {
             from {
                 transform: translateX(0);
                 opacity: 1;
             }
             to {
                 transform: translateX(100%);
                 opacity: 0;
             }
         }
         
         /* SweetAlert customization */
         .swal2-popup-small {
             font-size: 14px !important;
         }
         
         .swal2-popup-small .swal2-title {
             font-size: 18px !important;
         }
         
         .swal2-popup-small .swal2-content {
             font-size: 14px !important;
         }
    </style>
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
                                                                                         <!-- Toast Container -->
                                             <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
                                             
                                             <?php if(isset($success_msg)): ?>
                                                 <div class="alert alert-success alert-dismissible" role="alert">
                                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                         <span aria-hidden="true">&times;</span>
                                                     </button>
                                                     <i class="fa fa-check-circle"></i> <?php echo $success_msg; ?>
                                                 </div>
                                             <?php endif; ?>
                                             
                                             <?php if(isset($error_msg)): ?>
                                                 <div class="alert alert-danger alert-dismissible" role="alert">
                                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                         <span aria-hidden="true">&times;</span>
                                                     </button>
                                                     <i class="fa fa-exclamation-circle"></i> <?php echo $error_msg; ?>
                                                 </div>
                                             <?php endif; ?>
                                            
                                                                                         <!-- Settings Tabs -->
                                             <ul class="nav nav-tabs" id="settingsTabs">
                                                 <li class="active">
                                                     <a href="#company">
                                                         <i class="fa fa-building"></i> Company
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a href="#contact">
                                                         <i class="fa fa-phone"></i> Contact & Locations
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a href="#seo">
                                                         <i class="fa fa-search"></i> SEO
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a href="#code">
                                                         <i class="fa fa-code"></i> Code Injection
                                                     </a>
                                                 </li>
                                             </ul>
                                            
                                            <div class="tab-content" id="settingsTabContent" >
                                                                                                 <!-- Company Tab -->
                                                 <div class="tab-pane active" id="company" style="    margin-top: 10px !important;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-building"></i> Company Information</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Website Name</label>
                                                                            <input type="text" class="form-control" name="website_name" value="<?php echo getSetting($conn, 'company_website_name'); ?>" required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>WhatsApp Number</label>
                                                                            <input type="text" class="form-control" name="whatsapp_no" value="<?php echo getSetting($conn, 'company_whatsapp_no'); ?>" placeholder="+91 98765 43210">
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Enquiry Email</label>
                                                                            <input type="email" class="form-control" name="enquiry_email" value="<?php echo getSetting($conn, 'company_enquiry_email'); ?>" required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Copyright Text</label>
                                                                            <input type="text" class="form-control" name="copyright" value="<?php echo getSetting($conn, 'company_copyright'); ?>" placeholder="© 2024 Company Name. All rights reserved.">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Company Logo</label>
                                                                            <input type="file" class="form-control" name="logo" accept="image/*">
                                                                            <?php 
                                                                            $current_logo = getSetting($conn, 'company_logo');
                                                                            if($current_logo): ?>
                                                                                <div class="mt-2">
                                                                                    <img src="../images/<?php echo $current_logo; ?>" class="upload-preview" alt="Current Logo">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Favicon</label>
                                                                            <input type="file" class="form-control" name="favicon" accept="image/*">
                                                                            <?php 
                                                                            $current_favicon = getSetting($conn, 'company_favicon');
                                                                            if($current_favicon): ?>
                                                                                <div class="mt-2">
                                                                                    <img src="../images/<?php echo $current_favicon; ?>" class="upload-preview" alt="Current Favicon">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="text-right">
                                                                    <button type="submit" name="save_company" class="btn btn-primary">
                                                                        <i class="fa fa-save"></i> Save Company Settings
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                                                                 <!-- Contact Tab -->
                                                 <div class="tab-pane" id="contact" style="    margin-top: 10px !important;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-phone"></i> Contact Information & Locations</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <!-- Contact Heading -->
                                                            <form method="POST" class="mb-4">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Contact Section Heading</label>
                                                                            <input type="text" class="form-control" name="contact_heading" value="<?php echo getSetting($conn, 'contact_heading'); ?>" placeholder="Get In Touch">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="text-right" style="margin-top: 25px;">
                                                                            <button type="submit" name="save_contact" class="btn btn-success">
                                                                                <i class="fa fa-save"></i> Save Heading
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            
                                                            <hr>
                                                            
                                                            <!-- Locations Management -->
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                                        <h5><i class="fa fa-map-marker"></i> Company Locations</h5>
                                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLocationModal">
                                                                            <i class="fa fa-plus"></i> Add New Location
                                                                        </button>
                                                                    </div>
                                                                    
                                                                    <?php if(empty($locations)): ?>
                                                                        <div class="alert alert-info">
                                                                            <i class="fa fa-info-circle"></i> No locations added yet. Click "Add New Location" to get started.
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="row">
                                                                            <?php foreach($locations as $location): ?>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <div class="location-item">
                                                                                        <div class="d-flex justify-content-between align-items-start">
                                                                                            <div class="flex-grow-1">
                                                                                                <h6 class="mb-2">
                                                                                                    <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($location['location_name']); ?>
                                                                                                </h6>
                                                                                                <?php if($location['phone']): ?>
                                                                                                    <p class="mb-1"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($location['phone']); ?></p>
                                                                                                <?php endif; ?>
                                                                                                <?php if($location['email']): ?>
                                                                                                    <p class="mb-1"><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($location['email']); ?></p>
                                                                                                <?php endif; ?>
                                                                                                <?php if($location['address']): ?>
                                                                                                    <p class="mb-1"><i class="fa fa-map"></i> <?php echo htmlspecialchars($location['address']); ?></p>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                            <div class="ml-3">
                                                                                                <?php if($location['image']): ?>
                                                                                                    <img src="../images/<?php echo $location['image']; ?>" class="location-image" alt="Location Image">
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="mt-3">
                                                                                            <button type="button" class="btn btn-warning btn-sm" onclick="editLocation(<?php echo htmlspecialchars(json_encode($location)); ?>)">
                                                                                                <i class="fa fa-edit"></i> Edit
                                                                                            </button>
                                                                                                                                                                                         <button type="button" class="btn btn-danger btn-sm" onclick="deleteLocation(<?php echo $location['id']; ?>, '<?php echo htmlspecialchars($location['location_name']); ?>')">
                                                                                                 <i class="fa fa-trash"></i> Delete
                                                                                             </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                                                                 <!-- SEO Tab -->
                                                 <div class="tab-pane" id="seo" style="    margin-top: 10px !important;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-search"></i> SEO Settings</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST">
                                                                <div class="form-group">
                                                                    <label>Default SEO Title</label>
                                                                    <input type="text" class="form-control" name="seo_title" value="<?php echo getSetting($conn, 'seo_title'); ?>" placeholder="Default page title for your website">
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Default Meta Keywords</label>
                                                                    <textarea class="form-control" name="seo_keywords" rows="3" placeholder="Enter keywords separated by commas"><?php echo getSetting($conn, 'seo_keywords'); ?></textarea>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Default Meta Description</label>
                                                                    <textarea class="form-control" name="seo_description" rows="4" placeholder="Enter a compelling description of your website (150-160 characters recommended)"><?php echo getSetting($conn, 'seo_description'); ?></textarea>
                                                                    <small class="form-text text-muted">This description will appear in search engine results.</small>
                                                                </div>
                                                                
                                                                <div class="text-right">
                                                                    <button type="submit" name="save_seo" class="btn btn-primary">
                                                                        <i class="fa fa-save"></i> Save SEO Settings
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                                                                 <!-- Code Injection Tab -->
                                                 <div class="tab-pane" id="code" style="    margin-top: 10px !important;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-code"></i> Code Injection</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST">
                                                                <div class="form-group">
                                                                    <label>Google Analytics Code</label>
                                                                    <textarea class="form-control" name="google_analytics" rows="6" placeholder="Paste your Google Analytics tracking code here (e.g., gtag.js or ga.js)"><?php echo getSetting($conn, 'code_google_analytics'); ?></textarea>
                                                                    <small class="form-text text-muted">This code will be added to the &lt;head&gt; section of all pages.</small>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Chat Widget Code</label>
                                                                    <textarea class="form-control" name="chat_code" rows="6" placeholder="Paste your chat widget code here (e.g., LiveChat, Tawk.to, etc.)"><?php echo getSetting($conn, 'code_chat_code'); ?></textarea>
                                                                    <small class="form-text text-muted">This code will be added to the &lt;head&gt; section of all pages.</small>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Custom Header Code</label>
                                                                    <textarea class="form-control" name="header_code" rows="6" placeholder="Paste any additional code you want to add to the &lt;head&gt; section"><?php echo getSetting($conn, 'code_header_code'); ?></textarea>
                                                                    <small class="form-text text-muted">This code will be added after the existing head tags on all pages.</small>
                                                                </div>
                                                                
                                                                <div class="text-right">
                                                                    <button type="submit" name="save_code" class="btn btn-primary">
                                                                        <i class="fa fa-save"></i> Save Code Settings
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
 <!-- Add Location Modal -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Add New Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Location Name</label>
                            <input type="text" class="form-control" name="location_name" placeholder="e.g., Delhi Office" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" placeholder="+91 98765 43210">
                        </div>
                        
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Enter complete address"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="delhi@company.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Location Image (Optional)</label>
                            <input type="file" class="form-control" name="location_image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_location" class="btn btn-primary">Add Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Location Modal -->
    <div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="location_id" id="edit_location_id">
                        
                        <div class="form-group">
                            <label>Location Name</label>
                            <input type="text" class="form-control" name="location_name" id="edit_location_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="edit_phone" placeholder="+91 98765 43210">
                        </div>
                        
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" id="edit_address" rows="3" placeholder="Enter complete address"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" placeholder="delhi@company.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Location Image (Optional)</label>
                            <input type="file" class="form-control" name="location_image" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_location" class="btn btn-primary">Update Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- .vd_body END  -->

       <!-- SweetAlert JS -->
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
       
       <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.style.cssText = `
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                margin-bottom: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                min-width: 300px;
                position: relative;
                animation: slideInRight 0.3s ease;
            `;
            
            const icon = type === 'success' ? '✓' : '✗';
            toast.innerHTML = `<span style="margin-right: 10px; font-size: 18px;">${icon}</span>${message}`;
            
            document.getElementById('toast-container').appendChild(toast);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 4000);
        }
        
        // Delete location with SweetAlert confirmation
        function deleteLocation(locationId, locationName) {
            Swal.fire({
                title: 'Delete Location?',
                text: `Are you sure you want to delete "${locationName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                width: '400px',
                customClass: {
                    popup: 'swal2-popup-small'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the location.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Perform delete
                    window.location.href = `?delete_location=${locationId}`;
                }
            });
        }
        
        function editLocation(location) {
            document.getElementById('edit_location_id').value = location.id;
            document.getElementById('edit_location_name').value = location.location_name;
            document.getElementById('edit_phone').value = location.phone;
            document.getElementById('edit_address').value = location.address;
            document.getElementById('edit_email').value = location.email;
            
            $('#editLocationModal').modal('show');
        }
        
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Initialize tabs properly for Bootstrap 3
            $('#settingsTabs a').click(function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                
                // Remove active class from all tabs and content
                $('#settingsTabs li').removeClass('active');
                $('.tab-pane').removeClass('active').hide();
                
                // Add active class to clicked tab
                $(this).parent().addClass('active');
                
                // Show corresponding content
                $(target).addClass('active').show();
                
                // Force remove all spacing
                $('.tab-content, .tab-pane, .tab-pane.active').css({
                    'margin': '0',
                    'padding': '0'
                });
            });
            
            // Show first tab by default and ensure it's visible
            $('#company').addClass('active').show();
            $('#settingsTabs li:first-child').addClass('active');
            
            // File upload preview
            $('input[type="file"]').change(function() {
                var file = this.files[0];
                var reader = new FileReader();
                var preview = $(this).siblings('.mt-2').find('img');
                
                if (file) {
                    reader.onload = function(e) {
                        if (preview.length > 0) {
                            preview.attr('src', e.target.result);
                        } else {
                            var img = $('<img class="upload-preview mt-2" alt="Preview">');
                            img.attr('src', e.target.result);
                            $(this).parent().append(img);
                        }
                    }.bind(this);
                    reader.readAsDataURL(file);
                }
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Show success toast for form submissions
            $('form').on('submit', function() {
                const formName = $(this).find('button[type="submit"]').attr('name');
                if (formName) {
                    // Store form name for toast display
                    sessionStorage.setItem('pendingToast', formName);
                }
            });
            
            // Check for pending toast messages
            const pendingToast = sessionStorage.getItem('pendingToast');
            if (pendingToast) {
                let message = '';
                switch(pendingToast) {
                    case 'save_company':
                        message = 'Company settings updated successfully!';
                        break;
                    case 'save_contact':
                        message = 'Contact settings updated successfully!';
                        break;
                    case 'add_location':
                        message = 'Location added successfully!';
                        break;
                    case 'update_location':
                        message = 'Location updated successfully!';
                        break;
                    case 'save_seo':
                        message = 'SEO settings updated successfully!';
                        break;
                    case 'save_code':
                        message = 'Code injection settings updated successfully!';
                        break;
                }
                if (message) {
                    showToast(message, 'success');
                }
                sessionStorage.removeItem('pendingToast');
            }
            
            // Check for delete success
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('delete_location')) {
                showToast('Location deleted successfully!', 'success');
                // Clean up URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>

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






</body>


</html>
