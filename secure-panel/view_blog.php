<?php
ob_start();
session_start();
error_reporting(0);
require('config.php');

// Handle delete operation
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Get image name before deletion
    $img_query = "SELECT image FROM blog WHERE id = '$delete_id'";
    $img_result = mysqli_query($conn, $img_query);
    $img_data = mysqli_fetch_assoc($img_result);
    
    // Delete from database
    $delete_query = "DELETE FROM blog WHERE id = '$delete_id'";
    $delete_result = mysqli_query($conn, $delete_query);
    
    if($delete_result) {
        // Delete image file if exists
        if($img_data['image'] && file_exists("../images/blog/".$img_data['image'])) {
            unlink("../images/blog/".$img_data['image']);
        }
        
        // Set success message
        $_SESSION['success_msg'] = "Blog post deleted successfully!";
    } else {
        $_SESSION['error_msg'] = "Error deleting blog post!";
    }
    
    // Redirect to refresh the page
    header("Location: view_blog.php");
    exit();
}

// Handle status toggle
if(isset($_GET['toggle_status'])) {
    $blog_id = $_GET['toggle_status'];
    $new_status = $_GET['new_status'];
    
    $update_query = "UPDATE blog SET status = '$new_status' WHERE id = '$blog_id'";
    $update_result = mysqli_query($conn, $update_query);
    
    if($update_result) {
        $_SESSION['success_msg'] = "Blog post status updated successfully!";
    } else {
        $_SESSION['error_msg'] = "Error updating blog post status!";
    }
    
    header("Location: view_blog.php");
    exit();
}

// Handle featured toggle
if(isset($_GET['toggle_featured'])) {
    $blog_id = $_GET['toggle_featured'];
    $new_featured = $_GET['new_featured'];
    
    $update_query = "UPDATE blog SET is_featured = '$new_featured' WHERE id = '$blog_id'";
    $update_result = mysqli_query($conn, $update_query);
    
    if($update_result) {
        $_SESSION['success_msg'] = "Blog post featured status updated successfully!";
    } else {
        $_SESSION['error_msg'] = "Error updating blog post featured status!";
    }
    
    header("Location: view_blog.php");
    exit();
}

// Fetch all blog posts with category information
$query = "SELECT b.*, bc.name as category_name 
          FROM blog b 
          LEFT JOIN blog_categories bc ON b.category_id = bc.id 
          ORDER BY b.created_date DESC";
$result = mysqli_query($conn, $query);
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
    <title>:: Admin ::</title>
     
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
	<link href="plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
	<link href="plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/theme.min.css" rel="stylesheet" type="text/css">
    <!--[if IE]> <link href="css/ie.css" rel="stylesheet" > <![endif]-->
    <link href="css/chrome.css" rel="stylesheet" type="text/chrome"> <!-- chrome only css -->

    <!-- Responsive CSS -->
        	<link href="css/theme-responsive.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="custom/custom.css" rel="stylesheet" type="text/css">

    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="js/modernizr.js"></script>
    <script type="text/javascript" src="js/mobile-detect.min.js"></script>
    <script type="text/javascript" src="js/mobile-detect-modernizr.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="js/html5shiv.js"></script>
      <script type="text/javascript" src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body id="tables" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix" data-active="tables "  data-smooth-scrolling="1">
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
                <li><a href="index-2.html">Home</a> </li>
                <li class="active">Blog Management</li>
              </ul>
              <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
      <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
      <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="fa fa-fullscreen"></i> </div>

</div>

            </div>
          </div>
          <div class="vd_title-section clearfix">
            <div class="vd_panel-header">
              <h1>Blog Management</h1>
              <div class="vd_panel-menu  hidden-xs">
                <a href="blog.php" class="btn vd_btn vd_bg-green vd_white">
                  <i class="fa fa-plus"></i> Add New Post
                </a>
              </div>
              </div>
          </div>
          
          <!-- Toastr notifications will be displayed here -->
          
          <div class="vd_content-section clearfix">
            <div class="row">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-list"></i> </span> All Blog Posts</h3>
                  </div>
                  <div class="panel-body table-responsive">
                    <table class="table table-striped" id="data-tables">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Featured Image</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Author</th>
                          <th>Status</th>
                          <th>Featured</th>
                          <th>Views</th>
                          <th>Reading Time</th>
                          <th>Created Date</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(mysqli_num_rows($result) > 0) {
                            $sno = 1;
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                          <td><?php echo $sno++; ?></td>
                          <td>
                            <?php if($row['image']): ?>
                              <img src="../images/blog/<?php echo $row['image']; ?>" alt="Blog Image" style="max-width: 60px; max-height: 60px;" class="img-thumbnail">
                            <?php else: ?>
                              <span class="text-muted">No Image</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                            <?php if($row['excerpt']): ?>
                              <br><small class="text-muted"><?php echo htmlspecialchars(substr($row['excerpt'], 0, 100)) . '...'; ?></small>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if($row['category_name']): ?>
                              <span class="label label-info"><?php echo htmlspecialchars($row['category_name']); ?></span>
                            <?php else: ?>
                              <span class="text-muted">Uncategorized</span>
                            <?php endif; ?>
                          </td>
                          <td><?php echo htmlspecialchars($row['author']); ?></td>
                          <td>
                            <?php 
                            $status_class = '';
                            $status_text = '';
                            switch($row['status']) {
                                case 'published':
                                    $status_class = 'label-success';
                                    $status_text = 'Published';
                                    break;
                                case 'draft':
                                    $status_class = 'label-warning';
                                    $status_text = 'Draft';
                                    break;
                                case 'archived':
                                    $status_class = 'label-danger';
                                    $status_text = 'Archived';
                                    break;
                            }
                            ?>
                            <span class="label <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                          </td>
                          <td>
                            <?php if($row['is_featured'] == 1): ?>
                              <span class="label label-primary">Featured</span>
                            <?php else: ?>
                              <span class="text-muted">-</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <span class="badge"><?php echo $row['view_count']; ?></span>
                          </td>
                          <td>
                            <?php if($row['reading_time'] > 0): ?>
                              <span class="badge"><?php echo $row['reading_time']; ?> min</span>
                            <?php else: ?>
                              <span class="text-muted">-</span>
                            <?php endif; ?>
                          </td>
                          <td><?php echo date('d M Y', strtotime($row['created_date'])); ?></td>
                          <td>
                            <div class="btn-group">
                              <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-primary" title="Edit">
                                <i class="fa fa-edit"></i>
                              </a>
                              
                              <!-- Status Toggle -->
                              <?php if($row['status'] == 'published'): ?>
                                <a href="view_blog.php?toggle_status=<?php echo $row['id']; ?>&new_status=draft" class="btn btn-xs btn-warning" title="Mark as Draft">
                                  <i class="fa fa-eye-slash"></i>
                                </a>
                              <?php else: ?>
                                <a href="view_blog.php?toggle_status=<?php echo $row['id']; ?>&new_status=published" class="btn btn-xs btn-success" title="Publish">
                                  <i class="fa fa-eye"></i>
                                </a>
                              <?php endif; ?>
                              
                              <!-- Featured Toggle -->
                              <?php if($row['is_featured'] == 1): ?>
                                <a href="view_blog.php?toggle_featured=<?php echo $row['id']; ?>&new_featured=0" class="btn btn-xs btn-info" title="Remove Featured">
                                  <i class="fa fa-star-o"></i>
                                </a>
                              <?php else: ?>
                                <a href="view_blog.php?toggle_featured=<?php echo $row['id']; ?>&new_featured=1" class="btn btn-xs btn-default" title="Mark as Featured">
                                  <i class="fa fa-star"></i>
                                </a>
                              <?php endif; ?>
                              
                              <button type="button" class="btn btn-xs btn-danger delete-btn" 
                                      data-id="<?php echo $row['id']; ?>" 
                                      data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                      title="Delete">
                                <i class="fa fa-trash"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                       <?php
                            }
                        } else {
                        ?>
                        <tr>
                          <td colspan="11" class="text-center text-muted">
                            <i class="fa fa-info-circle"></i> No blog posts found. 
                            <a href="blog.php">Create your first blog post</a>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- Panel Widget -->
              </div>
              <!-- col-md-12 -->
            </div>
            
            <!-- row -->

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
  <!-- .container -->
</div>
<!-- .content -->

<!-- Footer Start -->
  <footer class="footer-1"  id="footer">
    <div class="vd_bottom ">
        <div class="container">
            <div class="row">
              <div class=" col-xs-12">
                <div class="copyright">
                  	Copyright &copy;2018 Admin. All Rights Reserved
                </div>
              </div>
            </div><!-- row -->
        </div><!-- container -->
    </div>
  </footer>
<!-- Footer END -->


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

<script type="text/javascript" src="plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- SweetAlert2 for confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Toastr for notifications -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
				"use strict";

				// Initialize DataTable
				$('#data-tables').dataTable({
					"order": [[9, "desc"]], // Sort by created date
					"pageLength": 25,
					"responsive": true
				});
				
				// Configure toastr
				toastr.options = {
					"closeButton": true,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"timeOut": "3000"
				};
				
				// Handle delete button clicks
				$('.delete-btn').on('click', function() {
					var id = $(this).data('id');
					var title = $(this).data('title');
					
					Swal.fire({
						title: 'Are you sure?',
						text: "You want to delete '" + title + "'? This action cannot be undone!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#d33',
						cancelButtonColor: '#3085d6',
						confirmButtonText: 'Yes, delete it!',
						cancelButtonText: 'Cancel'
					}).then((result) => {
						if (result.isConfirmed) {
							// Show loading state
							Swal.fire({
								title: 'Deleting...',
								text: 'Please wait while we delete the blog post.',
								allowOutsideClick: false,
								didOpen: () => {
									Swal.showLoading();
								}
							});
							
							// Redirect to delete
							window.location.href = 'view_blog.php?delete_id=' + id;
						}
					});
				});
				
				// Show success/error messages as toasts
				<?php if(isset($_SESSION['success_msg'])): ?>
				toastr.success('<?php echo addslashes($_SESSION['success_msg']); ?>', 'Success!');
				<?php unset($_SESSION['success_msg']); endif; ?>
				
				<?php if(isset($_SESSION['error_msg'])): ?>
				toastr.error('<?php echo addslashes($_SESSION['error_msg']); ?>', 'Error!');
				<?php unset($_SESSION['error_msg']); endif; ?>
		});
</script>

<!-- Specific Page Scripts END -->

<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information. -->

<script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-43329142-3']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>


</body>

<!-- Mirrored from vendroid.venmond.com/listtables-data-tables.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 22 Jul 2014 12:09:05 GMT -->
</html>
