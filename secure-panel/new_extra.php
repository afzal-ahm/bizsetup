<?php
error_reporting(0);
ini_set('display_errors', 1);
ob_start();
session_start();
include_once 'config.php';

// Debug: Check database connection
if(!isset($conn) || !$conn) {
    echo "<script type=\"text/javascript\">".
         "alert('Database connection failed!');".
         "</script>";
    exit();
}

// Debug: Test database connection
$test_query = "SELECT 1";
$test_result = mysqli_query($conn, $test_query);
if(!$test_result) {
    echo "<script type=\"text/javascript\">".
         "alert('Database connection test failed: " . mysqli_error($conn) . "');".
         "</script>";
    exit();
}

//data insert here
if(isset($_POST['btn-save']))
{
    $heading1 = $_POST['heading1'];
    $heading2 = $_POST['heading2'];
    $content = $_POST['content'];
    $link = $_POST['link'];
    $type = $_POST['type'];
    $position = $_POST['position'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Debug: Log the values being inserted
    error_log("Inserting: heading1=$heading1, heading2=$heading2, type=$type, position=$position, is_active=$is_active");
    
    // Handle image upload
$image_name = $_FILES['image']['name'];
    $imagename = '';
    if($image_name != ""){
	 $image_type = $_FILES['image']['type'];
	 $image_size = $_FILES['image']['size'];
	 $image_tmp = $_FILES['image']['tmp_name'];
        $random_digit = rand(0000,9999);
	   $imagename = $random_digit.$image_name;
        
        // Create directory if it doesn't exist
        $upload_dir = "../images/extra/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        move_uploaded_file($image_tmp, $upload_dir . $imagename);
    }
    
    // Insert into extra_content table
    $table = "extra_content";
    
    // Check if table exists, if not create it
    $check_table = "SHOW TABLES LIKE 'extra_content'";
    $table_exists = mysqli_query($conn, $check_table);
    
    if(mysqli_num_rows($table_exists) == 0) {
        // Create table if it doesn't exist
        $create_table = "CREATE TABLE IF NOT EXISTS `extra_content` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `heading1` varchar(255) NOT NULL,
            `heading2` varchar(255) DEFAULT NULL,
            `content` longtext,
            `link` varchar(500) DEFAULT NULL,
            `type` varchar(100) NOT NULL,
            `image` varchar(255) DEFAULT NULL,
            `position` int(11) DEFAULT 0,
            `is_active` tinyint(1) DEFAULT 1,
            `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
            `updated_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        $create_result = mysqli_query($conn, $create_table);
        if(!$create_result) {
            $_SESSION['error_msg'] = "Error creating table: " . mysqli_error($conn);
            header("Location: new_extra.php");
            exit();
        }
    }
    
    // Prepare the insert query
    $in = "INSERT INTO `extra_content`(`heading1`, `heading2`, `content`, `link`, `type`, `image`, `position`, `is_active`, `created_date`) 
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, $in);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssii", $heading1, $heading2, $content, $link, $type, $imagename, $position, $is_active);
        $f = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        if($f) {
            $_SESSION['success_msg'] = "Content added successfully!";
            header("Location: new_extra.php");
            exit();
        } else {
            $_SESSION['error_msg'] = "Error occurred while adding: " . mysqli_error($conn);
            header("Location: new_extra.php");
            exit();
        }
    } else {
        $_SESSION['error_msg'] = "Error preparing statement: " . mysqli_error($conn);
        header("Location: new_extra.php");
        exit();
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

    <!-- Toastr CSS for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr CSS for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="js/modernizr.js"></script> 
    <script type="text/javascript" src="js/mobile-detect.min.js"></script> 
    <script type="text/javascript" src="js/mobile-detect-modernizr.js"></script> 
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
    
    // Show session messages as toasts
    <?php if(isset($_SESSION['success_msg'])): ?>
    toastr.success('<?php echo addslashes($_SESSION['success_msg']); ?>', 'Success!');
    <?php unset($_SESSION['success_msg']); endif; ?>
    
    <?php if(isset($_SESSION['error_msg'])): ?>
    toastr.error('<?php echo addslashes($_SESSION['error_msg']); ?>', 'Error!');
    <?php unset($_SESSION['error_msg']); endif; ?>
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
              <h1>Add Extra Content Section</h1>
              <small class="subtitle">Manage Website Content Sections</small>
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
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-plus-circle"></i> </span> Add New Content Section </h3>
                  </div>
                  <div class="panel-body">
                    <!-- Toastr notifications will be displayed here -->
                    
                    <form class="form-horizontal" enctype="multipart/form-data" action="" role="form" method="post">
                    
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Heading 1</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="heading1" placeholder="Enter Heading 1" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Heading 2</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="heading2" placeholder="Enter Heading 2">
                      </div>
                      	</div>
                       
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Content Type</label>
                        <div class="col-sm-7 controls">
                          <select class="width-70" name="type" required>
                            <option value="">Select Content Type</option>
                            <option value="heading">Heading</option>
                            <option value="3_box_content">3 Box Content</option>
                            <option value="4_box_content">4 Box Content</option>
                            <option value="about_us">About Us</option>
                            <option value="long_content">Long Content</option>
                            <option value="banner">Banner</option>
                            <option value="why_choose_us">Why Choose Us</option>
                            <option value="counter">Counter</option>
                            <option value="4_box_content_2">4 Box Content 2</option>
                            <option value="testimonial">Testimonial</option>
                            <option value="faq">FAQ</option>
                            <option value="call_to_action">Call to Action</option>
                            <option value="social_link">Social Link</option>
                            <option value="banner_heading">Banner heading</option>
                            <option value="after_search_content">After Search content</option>
                            
                            <option value="moving_line">Moving line</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="number" name="position" placeholder="Enter Position" min="0" value="0">
                          <small class="help-block">Lower numbers appear first</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-7 controls">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="is_active" value="1" checked>
                              Active
                            </label>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-7 controls">
                          <input type="file" name="image" accept="image/*">
                          <small class="help-block">Upload image for this content section</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Link</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="url" name="link" placeholder="Enter URL (optional)">
                          <small class="help-block">Add a link if this content should be clickable</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-7 controls">
                          <textarea class="ckeditor" name="content" cols="70" rows="10" placeholder="Enter content here..."></textarea>
                          <small class="help-block">Add the main content for this section</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-7">
                          <button class="btn vd_btn vd_bg-green vd_white" type="submit" name="btn-save">
                            <i class="icon-ok"></i> Save Content
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

<!-- Toastr JS for notifications -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 
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
