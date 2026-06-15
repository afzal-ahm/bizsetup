<?php
error_reporting(0);
ob_start();
session_start();
include_once 'config.php';

// Get content ID from URL
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: new_extra_content_view.php");
    exit();
}

$content_id = $_GET['id'];

// Fetch existing content
$fetch_query = "SELECT * FROM extra_content WHERE id = '$content_id'";
$fetch_result = mysqli_query($conn, $fetch_query);

if(mysqli_num_rows($fetch_result) == 0) {
    header("Location: new_extra_content_view.php");
    exit();
}

$content_data = mysqli_fetch_assoc($fetch_result);

// Handle form submission for update
if(isset($_POST['btn-update'])) {
    $heading1 = $_POST['heading1'];
    $heading2 = $_POST['heading2'];
    $content = $_POST['content'];
    $link = $_POST['link'];
    $type = $_POST['type'];
    $position = $_POST['position'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle image upload
    $image_name = $_FILES['image']['name'];
    $imagename = $content_data['image']; // Keep existing image by default
    
    if($image_name != "") {
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $random_digit = rand(0000,9999);
        $imagename = $random_digit.$image_name;
        
        // Delete old image if exists
        if($content_data['image'] && file_exists("../images/extra/".$content_data['image'])) {
            unlink("../images/extra/".$content_data['image']);
        }
        
        move_uploaded_file($image_tmp,"../images/extra/$imagename");
    }
    
    // Update the content
    $update_query = "UPDATE `extra_content` SET 
                     `heading1`='$heading1',
                     `heading2`='$heading2',
                     `content`='$content',
                     `link`='$link',
                     `type`='$type',
                     `image`='$imagename',
                     `position`='$position',
                     `is_active`='$is_active',
                     `updated_date`=NOW() 
                     WHERE id='$content_id'";
    
    $update_result = mysqli_query($conn, $update_query);
    
    if($update_result) {
        $_SESSION['success_msg'] = "Content updated successfully!";
        header("Location: new_extra_content_view.php");
        exit();
    } else {
        $_SESSION['error_msg'] = "Error updating content!";
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
    <title>Admin - Edit Extra Content</title>
  
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
                <li><a href="new_extra_content_view.php">Extra Content</a></li>
                <li class="active">Edit Content</li>
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
              <h1>Edit Extra Content Section</h1>
              <small class="subtitle">Update Content Section Details</small>
              <div class="vd_panel-menu  hidden-xs">
                <a href="new_extra_content_view.php" class="btn vd_btn vd_bg-blue vd_white">
                  <i class="fa fa-arrow-left"></i> Back to List
                </a>
              </div>
            </div>
            <!-- vd_panel-header --> 
          </div>
          <!-- vd_title-section -->
          
          <div class="row" id="advanced-input">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-edit"></i> </span> Edit Content Section: <?php echo htmlspecialchars($content_data['heading1']); ?></h3>
                  </div>
                  <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" action="" role="form" method="post">
                    
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Heading 1</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="heading1" placeholder="Enter Heading 1" value="<?php echo htmlspecialchars($content_data['heading1']); ?>" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Heading 2</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="heading2" placeholder="Enter Heading 2" value="<?php echo htmlspecialchars($content_data['heading2']); ?>">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Content Type</label>
                        <div class="col-sm-7 controls">
                          <select class="width-70" name="type" required>
                            <option value="">Select Content Type</option>
                            <option value="heading" <?php echo ($content_data['type'] == 'heading') ? 'selected' : ''; ?>>Heading</option>
                            <option value="3_box_content" <?php echo ($content_data['type'] == '3_box_content') ? 'selected' : ''; ?>>3 Box Content</option>
                            <option value="4_box_content" <?php echo ($content_data['type'] == '4_box_content') ? 'selected' : ''; ?>>4 Box Content</option>
                            <option value="about_us" <?php echo ($content_data['type'] == 'about_us') ? 'selected' : ''; ?>>About Us</option>
                            <option value="moving_line" <?php echo ($content_data['type'] == 'moving_line') ? 'selected' : ''; ?>>Moving Line Long Content</option>
                            <option value="banner" <?php echo ($content_data['type'] == 'banner') ? 'selected' : ''; ?>>Banner</option>
                            <option value="why_choose_us" <?php echo ($content_data['type'] == 'why_choose_us') ? 'selected' : ''; ?>>Why Choose Us</option>
                            <option value="counter" <?php echo ($content_data['type'] == 'counter') ? 'selected' : ''; ?>>Counter</option>
                            <option value="4_box_content_2" <?php echo ($content_data['type'] == '4_box_content_2') ? 'selected' : ''; ?>>4 Box Content 2</option>
                            <option value="testimonial" <?php echo ($content_data['type'] == 'testimonial') ? 'selected' : ''; ?>>Testimonial</option>
                            <option value="faq" <?php echo ($content_data['type'] == 'faq') ? 'selected' : ''; ?>>FAQ</option>
                            <option value="call_to_action" <?php echo ($content_data['type'] == 'call_to_action') ? 'selected' : ''; ?>>Call to Action</option>
                            <option value="social_link" <?php echo ($content_data['type'] == 'social_link') ? 'selected' : ''; ?>>Social Link</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="number" name="position" placeholder="Enter Position" min="0" value="<?php echo $content_data['position']; ?>">
                          <small class="help-block">Lower numbers appear first</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-7 controls">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="is_active" value="1" <?php echo ($content_data['is_active'] == 1) ? 'checked' : ''; ?>>
                              Active
                            </label>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Current Image</label>
                        <div class="col-sm-7 controls">
                          <?php if($content_data['image']): ?>
                            <img src="../images/extra/<?php echo $content_data['image']; ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                            <br><small class="text-muted">Current image</small>
                          <?php else: ?>
                            <span class="text-muted">No image currently set</span>
                          <?php endif; ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Update Image</label>
                        <div class="col-sm-7 controls">
                          <input type="file" name="image" accept="image/*">
                          <small class="help-block">Leave empty to keep current image</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Link</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="url" name="link" placeholder="Enter URL (optional)" value="<?php echo htmlspecialchars($content_data['link']); ?>">
                          <small class="help-block">Add a link if this content should be clickable</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-7 controls">
                          <textarea class="ckeditor" name="content" cols="70" rows="10" placeholder="Enter content here..."><?php echo htmlspecialchars($content_data['content']); ?></textarea>
                          <small class="help-block">Add the main content for this section</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-7">
                          <button class="btn vd_btn vd_bg-green vd_white" type="submit" name="btn-update">
                            <i class="icon-ok"></i> Update Content
                          </button>
                          <a href="new_extra_content_view.php" class="btn vd_btn vd_bg-grey vd_white">
                            <i class="icon-close"></i> Cancel
                          </a>
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
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>


 

<script language="javascript">
    $(document).ready(function () {
        $("#datetimepicker_darkto").datetimepicker({
            minDate: 0
        });
    });
</script>



</body>


</html>
