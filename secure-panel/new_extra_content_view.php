<?php
ob_start();
session_start();
error_reporting(0);
require('config.php');

// Handle delete operation
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Get image name before deletion
    $img_query = "SELECT image FROM extra_content WHERE id = '$delete_id'";
    $img_result = mysqli_query($conn, $img_query);
    $img_data = mysqli_fetch_assoc($img_result);
    
    // Delete from database
    $delete_query = "DELETE FROM extra_content WHERE id = '$delete_id'";
    $delete_result = mysqli_query($conn, $delete_query);
    
    if($delete_result) {
        // Delete image file if exists
        if($img_data['image'] && file_exists("../images/extra/".$img_data['image'])) {
            unlink("../images/extra/".$img_data['image']);
        }
        
        // Set success message
        $_SESSION['success_msg'] = "Content deleted successfully!";
    } else {
        $_SESSION['error_msg'] = "Error deleting content!";
    }
    
    // Redirect to refresh the page
    header("Location: new_extra_content_view.php");
    exit();
}

// Fetch all extra content
$query = "SELECT * FROM extra_content ORDER BY position ASC, created_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->

<!-- Specific Page Data -->
<!-- End of Data -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
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
	<link href="plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">    
     
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
   <?php include"adminleftmenu.php";?>  <div class="vd_navbar vd_nav-width vd_navbar-chat vd_bg-black-80 vd_navbar-right   ">
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
                <li><a href="index-2.html">Home</a> </li>
               
                <li class="active">View Extra Content</li>
              </ul>
              <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
      <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
      <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>
      
</div>
 
            </div>
          </div>
          <div class="vd_title-section clearfix">
            <div class="vd_panel-header">
              <h1>View Extra Content</h1>
              <div class="vd_panel-menu  hidden-xs">
                <a href="new_extra.php" class="btn vd_btn vd_bg-green vd_white">
                  <i class="fa fa-plus"></i> Add New Content
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
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-list"></i> </span> Extra Content Sections</h3>
                  </div>
                  <div class="panel-body table-responsive">
                    <table class="table table-striped" id="data-tables">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Heading 1</th>
                          <th>Heading 2</th>
                          <th>Type</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Image</th>
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
                          <td><?php echo htmlspecialchars($row['heading1']); ?></td>
                          <td><?php echo htmlspecialchars($row['heading2'] ?: '-'); ?></td>
                          <td>
                            <span class="label label-info"><?php echo ucwords(str_replace('_', ' ', $row['type'])); ?></span>
                          </td>
                          <td><?php echo $row['position']; ?></td>
                          <td>
                            <?php if($row['is_active'] == 1): ?>
                              <span class="label label-success">Active</span>
                            <?php else: ?>
                              <span class="label label-danger">Inactive</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if($row['image']): ?>
                              <img src="../images/extra/<?php echo $row['image']; ?>" alt="Content Image" style="max-width: 50px; max-height: 50px;" class="img-thumbnail">
                            <?php else: ?>
                              <span class="text-muted">No Image</span>
                            <?php endif; ?>
                          </td>
                          <td><?php echo date('d M Y', strtotime($row['created_date'])); ?></td>
                          <td>
                            <a href="edit_extra_content.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-primary" title="Edit">
                              <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-xs btn-danger delete-btn" 
                                    data-id="<?php echo $row['id']; ?>" 
                                    data-heading="<?php echo htmlspecialchars($row['heading1']); ?>"
                                    title="Delete">
                              <i class="fa fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                          <td colspan="9" class="text-center text-muted">
                            <i class="fa fa-info-circle"></i> No content sections found. 
                            <a href="new_extra.php">Add your first content section</a>
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
					"order": [[4, "asc"], [7, "desc"]], // Sort by position first, then by created date
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
					var heading = $(this).data('heading');
					
					Swal.fire({
						title: 'Are you sure?',
						text: "You want to delete '" + heading + "'? This action cannot be undone!",
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
								text: 'Please wait while we delete the content.',
								allowOutsideClick: false,
								didOpen: () => {
									Swal.showLoading();
								}
							});
							
							// Redirect to delete
							window.location.href = 'new_extra_content_view.php?delete_id=' + id;
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