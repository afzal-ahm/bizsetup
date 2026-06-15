<?php
error_reporting(0);
include_once'dbMysql.php';
$con = new DB_con();
$cus_id = $_GET['cusid'];
$table="customer_detail";
$field = array('customer_user_id','fname','mobile_no','pincode','city','address','email','city');
$field_value = array($cus_id);
$res=$con->selectcatprod($table,$field_value,$field);
//print_r($res);die;
foreach($res as $key => $cus_details)
?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8" />
    <title>Admin</title>
    <meta name="keywords" content="HTML5 Template, CSS3, All Purpose Admin Template, Vendroid" />
    <meta name="description" content="User Profile Pages - Responsive Admin HTML Template">
    <meta name="author" content="Venmond">

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

<body id="pages" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix" data-active="pages "  data-smooth-scrolling="1">
<div class="vd_body">
    <!-- Header Start -->
    <?php include"header.php"; ?>
    <!-- Header Ends -->
    <div class="content">
        <div class="container">
            <?php include"adminleftmenu.php"; ?>
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
                                    <li><a href="">Pages</a> </li>
                                    <li class="active">User  Details</li>
                                </ul>
                                <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
                                    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
                                    <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
                                    <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>

                                </div>

                            </div>
                        </div>
                        <?php
                        echo' <div class="vd_title-section clearfix">
            <div class="vd_panel-header no-subtitle">
              <h1>User Profile Details</h1>
            </div>
          </div>
          <div class="vd_content-section clearfix">
            <div class="row">
              <div class="col-sm-3">
                <div class="panel widget light-widget panel-bd-top">
                  <div class="panel-heading no-title"> </div>
                  <div class="panel-body">
                    <div class="text-center vd_info-parent">  </div>

                    <h2 class="font-semibold mgbt-xs-5">'.$cus_details['fname'].'</h2>

                    <div class="mgtp-20">

                    </div>
                  </div>
                </div>
                <!-- panel widget -->


                <!-- panel widget -->
              </div>
              <div class="col-sm-9">
                <div class="tabs widget">
  <ul class="nav nav-tabs widget">
    <li class="active"> <a data-toggle="tab" href="#profile-tab"> User <span class="menu-active"><i class="fa fa-caret-up"></i></span> </a></li>
    <li> <a data-toggle="tab" href="#projects-tab"><span class="menu-active"><i class="fa fa-caret-up"></i></span> </a></li>
    <li> <a data-toggle="tab" href="#photos-tab"><span class="menu-active"><i class="fa fa-caret-up"></i></span> </a></li>
  </ul>

 <div class="tab-content">
    <div id="profile-tab" class="tab-pane active">
      <div class="pd-20">
<div class="vd_info tr"> <a href="edituser.php?cusid='.$cus_details['customer_user_id'].'" class="btn vd_btn btn-xs vd_bg-yellow"> <i class="fa fa-pencil append-icon"></i> Edit </a> </div>
        <h3 class="mgbt-xs-15 mgtp-10 font-semibold"><i class="icon-user mgr-10 profile-icon"></i>About User</h3>
        <div class="row">


          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">User Name :</label>
              <div class="col-xs-7 controls">'.$cus_details['fname'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Mobile No :</label>
              <div class="col-xs-7 controls">'.$cus_details['mobile_no'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Email ID :</label>
              <div class="col-xs-7 controls">'.$cus_details['email'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Landmark :</label>
              <div class="col-xs-7 controls">'.$cus_details['city'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Address :</label>
              <div class="col-xs-7 controls">'.$cus_details['address'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">City :</label>
              <div class="col-xs-7 controls">'.$cus_details['city'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>

          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Pincode :</label>
              <div class="col-xs-7 controls">'.$cus_details['pincode'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>

        </div>
        <hr class="pd-10"  />

        <!-- row -->
        <hr class="pd-10"  />

        <!-- row -->
      </div>
      <!-- pd-20 -->
    </div>';?>
                        <!-- home-tab -->


                        <!-- tab-content -->
                    </div>
                    <!-- tabs-widget -->              </div>
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
<?php include"footer.php"; ?>
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
<script type="text/javascript" src="plugins/isotope/isotope.pkgd.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        "use strict";

        // init Isotope
        var $container = $('.isotope').isotope({
            itemSelector: '.gallery-item',
            layoutMode: 'fitRows'
        });


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $container.isotope('layout');
        });

        // bind filter button click
        $('#filters').on( 'click', 'a', function() {
            var filterValue = $( this ).attr('data-filter');
            $('#filters li').removeClass('active');
            $(this).parent().addClass('active');
            $container.isotope({ filter: filterValue });
        });


    });
</script>


</body>

</html>