<?php
error_reporting(0);
include_once'dbMysql.php';
$con = new DB_con();
  $cus_id = $_GET['sku'];
$table="product";
$field = array('sku','product_name','mrp','offer','category','theme','brand','type','gender','design','stock');
$field_value = array($cus_id);
$res=$con->selectcatprod($table,$field_value,$field);
//print_r($res);die;
foreach($res as $key => $cus_details)
?>
<?php
error_reporting(0);
include_once'dbMysql.php';include_once'config.php';
$table="product_color";
$con = new DB_con();
$res=$con->select($table);
//print_r($res);
?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->
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
              <h1>Product Details</h1>
            </div>
          </div>
          <div class="vd_content-section clearfix">
            <div class="row">
             
              <div class="col-sm-12">
                <div class="tabs widget">
  <ul class="nav nav-tabs widget">
    <li class="active"> <a data-toggle="tab" href="#profile-tab"> User <span class="menu-active"><i class="fa fa-caret-up"></i></span> </a></li>
    <li> <a data-toggle="tab" href="#projects-tab"><span class="menu-active"><i class="fa fa-caret-up"></i></span> </a></li>
    <li> <a data-toggle="tab" href="#photos-tab"><span class="menu-active"><i class="fa fa-caret-up"></i></span> </a></li>
  </ul>

 <div class="tab-content">
    <div id="profile-tab" class="tab-pane active">
      <div class="pd-20">
      

        <h3 class="mgbt-xs-15 mgtp-10 font-semibold"><i class="icon-user mgr-10 profile-icon"></i>About Product</h3>
        <div class="row">


          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Product Name :</label>
              <div class="col-xs-7 controls">'.$cus_details['product_name'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">mrp :</label>
              <div class="col-xs-7 controls">'.$cus_details['mrp'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">offer  :</label>
              <div class="col-xs-7 controls">'.$cus_details['offer'].' %</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">category :</label>
              <div class="col-xs-7 controls">'.$cus_details['category'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">theme :</label>
              <div class="col-xs-7 controls">'.$cus_details['theme'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
           
           <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">brand :</label>
              <div class="col-xs-7 controls">'.$cus_details['brand'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
         
           <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">type :</label>
              <div class="col-xs-7 controls">'.$cus_details['type'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
         
           <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">gender :</label>
              <div class="col-xs-7 controls">'.$cus_details['gender'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div> 
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">gender :</label>
              <div class="col-xs-7 controls">'.$cus_details['gender'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
           <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">stock :</label>
              <div class="col-xs-7 controls">'.$cus_details['stock'].'</div>
              <!-- col-sm-10 -->
            </div>
          </div>
         
         
          
          

         

        </div>
      

    
 
        </div>
        <!-- row -->
      </div>
      <!-- pd-20 -->
    </div>';?>
                        <!-- home-tab -->


                        <!-- tab-content -->
                    </div>
                    
                    <div>
                    <br>
                    <div class="vd_content-section clearfix">
                     <div class="row" style="background-color: #fff;">
                    	 <h3 class="mgbt-xs-15 mgtp-10 font-semibold"> Product  Color Images </h3>
       

<form method="post" action="" enctype="multipart/form-data">
          <div class="col-sm-4">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label"> Color Image :</label>
              <div class="col-xs-7 controls">
              
              	<input type="file" name="image"/>
               </div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-4">
            <div class="row mgbt-xs-0">
             
              <div class="col-xs-12 controls">
              
              	<input type="input" placeholder="color name of pic" name="color"/>
               </div>
              <!-- col-sm-10 -->
            </div>
          </div>
          <div class="col-sm-4">
            <div class="row mgbt-xs-0">
               <button name="newimage" type="submit">Submit</button>
              <!-- col-sm-10 -->
            </div>
          </div>
         </form>
            
          
          

         </div>

        </div>
        
        
         <div class="vd_content-section clearfix">
      
        <div class="row" style="background-color: #fff;">
  <?php      $select="SELECT * from image_manager where p_sku='".$cus_details['sku']."'";
$run=mysqli_query($conn,$select);
foreach($run as $key=> $img1)
?>
         <h3 class="mgbt-xs-15 mgtp-10 font-semibold"> Product    Images </h3>
       
         <div class="col-md-6" style="padding-bottom: 20px;">
           <form method="post" enctype="multipart/form-data" action=""> 
         	<img src="../images/product/<?php echo $img1['image'];?>" style="height:50px">
         	<br>
         	<p>Upload New image</p>
         	  <div class="col-md-6">
         	<input  type="file" name="image"/>
         	</div>
         	  <div class="col-md-6">
         	  <input type="hidden" value="<?php echo $img1['id'];?>" name="id">
         	  <button name="uploadimage" type="submit">Upload</button>
         	  </div>
         	  <br>
         	    </form>
         	    
         	    <?php

include_once"config.php";
 
//data insert here
if(isset($_POST['uploadimage']))

{
	 $id=$_POST['id'];
	$image_name = $_FILES['image']['name'];
	if($image_name!="")
	{
		
	
	 $image_type = $_FILES['image']['type'];
	 $image_size = $_FILES['image']['size'];
	 $image_tmp = $_FILES['image']['tmp_name'];
	 $random_digit=rand(0000,9999);
	   $imagename = $random_digit.$image_name;
	  move_uploaded_file($image_tmp,"../images/product/$imagename");
	   $up="UPDATE `image_manager` SET  `image`='$imagename'  WHERE id='$id'";
	  $r=mysqli_query($conn,$up);
	 echo "<script>window.location.href=''</script>";
	}
	}
if(isset($_POST['uploadimagelogo']))

{
	 $id=$_POST['id'];
	$image_name = $_FILES['image']['name'];
	if($image_name!="")
	{
		
	
	 $image_type = $_FILES['image']['type'];
	 $image_size = $_FILES['image']['size'];
	 $image_tmp = $_FILES['image']['tmp_name'];
	 $random_digit=rand(0000,9999);
	   $imagename = $random_digit.$image_name;
	  move_uploaded_file($image_tmp,"../images/product/$imagename");
	   $up="UPDATE `product_logo_image` SET  `image`='$imagename'  WHERE id='$id'";
	  $r=mysqli_query($conn,$up);
	   echo "<script>window.location.href=''</script>";
	}
	}
	?>
         </div>
    <?php      $select="SELECT * from product_logo_image where sku='".$cus_details['sku']."'";
$run=mysqli_query($conn,$select);
foreach($run as $key=> $img12)
?>
    
      <div class="col-md-6" style="padding-bottom: 20px;">
           <form method="post" enctype="multipart/form-data" action=""> 
         	<img src="../images/product/<?php echo $img12['image'];?>" style="height:50px">
         	<br>
         	<p>Upload Product logo image</p>
         	  <div class="col-md-6">
         	<input  type="file" name="image"/>
         	</div>
         	  <div class="col-md-6">
         	   <input type="hidden" value="<?php echo $img12['id'];?>" name="id">
         	  <button name="uploadimagelogo" type="submit">Upload</button>
         	  </div>
         	  <br>
         	    </form>
         </div>
      
        </div>
      </div>
        
      
      <div class="vd_content-section clearfix">
      
        <div class="row" style="background-color: #fff;">
         <h3 class="mgbt-xs-15 mgtp-10 font-semibold"> All  Images </h3>
         
         <table class="table">
    <thead>
      <tr>
       
        <th>Image</th> 
      
         <th>color</th>
           <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
    
    <?php 
  $select="SELECT * from product_color where sku='".$cus_details['sku']."'";
$run=mysqli_query($conn,$select);
foreach($run as $key=> $img)
{
	
  
    ?>
      <tr>
        <td><img src="../images/product/<?php echo $img['image'];?>" style="height: 100px;"></td>
        <td><?php echo $img['color'];?></td>
        
          <td><a href="delimg.php?id=<?php echo $img['id'];?>"><button>Delete</button></a></td>
        
        
      </tr>
     <?php }?> 
    </tbody>
  </table>
        </div>
      </div>
      

<?php

include_once"config.php";
 
//data insert here
if(isset($_POST['newimage']))
{

//$title = $_POST['title'];
$content = $_POST['color'];

$image_name = $_FILES['image']['name'];
	 $image_type = $_FILES['image']['type'];
	 $image_size = $_FILES['image']['size'];
	 $image_tmp = $_FILES['image']['tmp_name'];
	 $random_digit=rand(0000,9999);
	   $imagename = $random_digit.$image_name;
	  move_uploaded_file($image_tmp,"../images/product/$imagename");

$sel="INSERT INTO `product_color`(  `sku`, `color`, `image`) VALUES ('".$_GET['sku']."','$content','$imagename')";

//echo $sel;

$me=mysqli_query($conn,$sel);



if($me)
{
?>
<script>
alert("image Added");
window.location =''
</script>
<?php
}
else{
	?>
    
	<script>
alert("image Not Updateed");
window.location =''
</script>
<?php
}
	}
	?>
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