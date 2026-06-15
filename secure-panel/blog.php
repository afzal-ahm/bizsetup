<?php
error_reporting(0);
ob_start();
session_start();
include_once 'config.php';

// Function to generate slug from title
function generateSlug($title) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $slug = trim($slug, '-');
    return $slug;
}

// Function to calculate reading time
function calculateReadingTime($content) {
    $wordCount = str_word_count(strip_tags($content));
    $readingTime = ceil($wordCount / 200); // Average reading speed: 200 words per minute
    return $readingTime;
}

// Handle form submission
if(isset($_POST['btn-save'])) {
$title = $_POST['title'];
    $content = $_POST['content'];
    $excerpt = $_POST['excerpt'];
    $author = $_POST['author'];
    $category_id = $_POST['category_id'];
    $tags = $_POST['tags'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = $_POST['status'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $published_date = $_POST['published_date'] ? $_POST['published_date'] : NULL;
    
    // Generate slug
    $slug = generateSlug($title);
    
    // Calculate reading time
    $reading_time = calculateReadingTime($content);
    
    // Handle image upload
$image_name = $_FILES['image']['name'];
    $imagename = '';
    if($image_name != "") {
	 $image_type = $_FILES['image']['type'];
	 $image_size = $_FILES['image']['size'];
	 $image_tmp = $_FILES['image']['tmp_name'];
        $random_digit = rand(0000,9999);
	   $imagename = $random_digit.$image_name;
        
        // Create directory if it doesn't exist
        $upload_dir = "../images/blog/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        move_uploaded_file($image_tmp, $upload_dir . $imagename);
    }
    
    // Insert into blog table
    $insert_query = "INSERT INTO `blog`(`title`, `slug`, `content`, `excerpt`, `author`, `image`, `category_id`, `tags`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `is_featured`, `allow_comments`, `reading_time`, `published_date`, `created_date`) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $insert_query);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssssssiiis", $title, $slug, $content, $excerpt, $author, $imagename, $category_id, $tags, $meta_title, $meta_description, $meta_keywords, $status, $is_featured, $allow_comments, $reading_time, $published_date);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        if($result) {
            $_SESSION['success_msg'] = "Blog post created successfully!";
            header("Location: blog.php");
            exit();
        } else {
            $_SESSION['error_msg'] = "Error creating blog post: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_msg'] = "Error preparing statement: " . mysqli_error($conn);
    }
}

// Fetch blog categories for dropdown
$categories_query = "SELECT * FROM blog_categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC";
$categories_result = mysqli_query($conn, $categories_query);
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
    <title>Admin - Add Blog Post</title>
  
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
        
        // Initialize date picker
        $('#published_date').datetimepicker({
            format: 'Y-m-d H:i:s',
            step: 15
        });
        
        // Auto-generate slug from title
        $('#title').on('keyup blur', function() {
            var title = $(this).val();
            var slug = title.toLowerCase()
                .replace(/[^a-z0-9-]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            $('#slug').val(slug);
        });
        
        // Auto-generate meta title from title
        $('#title').on('keyup blur', function() {
            var title = $(this).val();
            if (!$('#meta_title').val()) {
                $('#meta_title').val(title);
            }
        });
        
        // Auto-generate excerpt from content
        $('#content').on('keyup blur', function() {
            var content = $(this).val();
            if (!$('#excerpt').val()) {
                var excerpt = content.replace(/<[^>]*>/g, '').substring(0, 160);
                $('#excerpt').val(excerpt);
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
                <li class="active">Blog Management</li>
              </ul>
              <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle"  class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
      <div data-action="remove-header" data-original-title="Remove Top Menu Toggle"  class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
      <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle"  class="fullscreen-button menu"> <i class="fa fa-fullscreen"></i> </div>

</div>

            </div>
          </div>
          <!-- vd_head-section -->

          <div class="vd_title-section clearfix">
            <div class="vd_panel-header">
              <h1>Add New Blog Post</h1>
              <small class="subtitle">Create and manage your blog content</small>
              <div class="vd_panel-menu  hidden-xs">
                <a href="view_blog.php" class="btn vd_btn vd_bg-blue vd_white">
                  <i class="fa fa-list"></i> View All Posts
                </a>
</div>
            </div>
          </div>

          <div class="row" id="advanced-input">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-plus-circle"></i> </span> Create New Blog Post </h3>
                  </div>
                  <div class="panel-body">
                    <!-- Toastr notifications will be displayed here -->
                    
                    <form class="form-horizontal" enctype="multipart/form-data" action="" role="form" method="post">
                    
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Blog Title <span class="text-danger">*</span></label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="title" id="title" placeholder="Enter blog title" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">URL Slug</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="slug" id="slug" placeholder="Auto-generated from title">
                          <small class="help-block">Leave empty to auto-generate from title</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-7 controls">
                          <select class="width-70" name="category_id">
                            <option value="">Select Category</option>
                            <?php while($category = mysqli_fetch_assoc($categories_result)): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endwhile; ?>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Author</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="author" placeholder="Enter author name" value="Admin User">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Featured Image</label>
                        <div class="col-sm-7 controls">
                          <input type="file" name="image" accept="image/*">
                          <small class="help-block">Upload a featured image for this blog post</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Tags</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="tags" placeholder="Enter tags separated by commas">
                          <small class="help-block">Example: web development, technology, programming</small>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-7 controls">
                          <select class="width-70" name="status">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                          </select>
                        </div>
                      </div>

                <div class="form-group">
                        <label class="col-sm-2 control-label">Published Date</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="published_date" id="published_date" placeholder="Leave empty for current date">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Options</label>
                        <div class="col-sm-7 controls">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="is_featured" value="1">
                              Mark as Featured Post
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="allow_comments" value="1" checked>
                              Allow Comments
                            </label>
                          </div>
                        </div>
                      </div>
                   
                        <div class="form-group">
                        <label class="col-sm-2 control-label">Excerpt</label>
                        <div class="col-sm-7 controls">
                          <textarea class="width-70" name="excerpt" id="excerpt" rows="3" placeholder="Brief summary of the blog post (auto-generated from content)"></textarea>
                          <small class="help-block">Leave empty to auto-generate from content</small>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Blog Content <span class="text-danger">*</span></label>
                        <div class="col-sm-7 controls">
                          <textarea class="ckeditor" name="content" id="content" cols="70" rows="15" placeholder="Write your blog content here..."></textarea>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">SEO Meta Title</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="meta_title" id="meta_title" placeholder="SEO meta title (auto-generated from title)">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">SEO Meta Description</label>
                        <div class="col-sm-7 controls">
                          <textarea class="width-70" name="meta_description" rows="2" placeholder="SEO meta description"></textarea>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">SEO Meta Keywords</label>
                        <div class="col-sm-7 controls">
                          <input class="width-70" type="text" name="meta_keywords" placeholder="SEO meta keywords separated by commas">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-7">
                          <button class="btn vd_btn vd_bg-green vd_white" type="submit" name="btn-save">
                            <i class="icon-ok"></i> Publish Blog Post
                          </button>
                          <button class="btn vd_btn vd_bg-grey vd_white" type="submit" name="btn-save-draft">
                            <i class="icon-save"></i> Save as Draft
                          </button>
                          <a href="view_blog.php" class="btn vd_btn vd_bg-blue vd_white">
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

<!-- jQuery UI Datepicker -->
<script type="text/javascript" src="plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="plugins/daterangepicker/daterangepicker.js"></script>

<!-- Specific Page Scripts END -->

</body>
</html>
