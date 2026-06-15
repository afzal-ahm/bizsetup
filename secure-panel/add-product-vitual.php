<?php
error_reporting(0);
include_once'dbMysql.php';
include_once 'config.php';
$table="category";
$con = new DB_con();
$res=$con->select($table);
//print_r($res);
if(isset($_POST['btn-save']))
{

$product_name = $_POST['product_name'];
 	$seotopic = strip_tags($product_name);
                  $hee=strtolower($seotopic);
                  $hee=strtolower($seotopic);
                  
                  $myTag = trim($seotopic); 
                  $string01 = str_replace("'", "$%", $myTag); 
                 
                  $string = str_replace("&", "and", $string01); 
                  $string1 = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
                  $string12 = preg_replace("/[ ]+/", " ", $string1);                
                  $hyphenTag1 = str_replace( ' ', '-', $string12 );
     

 $subcategory_name = $_POST['subcategory_name'];
 $subcategory_name1=$subcategory_name;
   $query="SELECT * from subcategory where subcategory_id='$subcategory_name1'";
 $run=mysqli_query($conn,$query);
 foreach($run as $key =>$subname)
 $sub_name=$subname['subcategory_name'];
 
 $category_name = $_POST['category_name'];
 $category_name1=$category_name;
   $query2="SELECT * from category where category_id='$category_name1'";
 $runx=mysqli_query($conn,$query2);
 foreach($runx as $key =>$subname1)
  $category_name=$subname1['category_name'];
 
 $sub_subcategory_name = $_POST['sub_subcategory_name'];
 $sub_subcategory_name1=$sub_subcategory_name;
  $query3="SELECT * from sub_subcategory where sub_subcategory_id='$sub_subcategory_name1'";
 $run=mysqli_query($conn,$query3);
 foreach($run as $key =>$subname2)
  $sub_sub_name=$subname2['sub_subcategory_name'];
  
$sub_subcategory_name  = $_POST['sub_subcategory_name'];

$delivery = $_POST['delivery'];$brand = $_POST['brand'];

$product_price = $_POST['product_price'];
$product_offer = $_POST['product_offer'];
$status = '0';
$brandactive = '0';
$number='100';
		 	$discounttoltal =$product_price*$product_offer/$number;
$offer_amount=$product_price-$discounttoltal;
$offer_amount=round($offer_amount);

 
 $id="SELECT * from product order by id desc limit 0,1";
	$run=mysqli_query($conn,$id);
	foreach($run as $key=> $sku_id)
	  $sku_id1=$sku_id['sku'];
	  $sku1 = intval(preg_replace('/[^0-9]+/', '', $sku_id1), 10);
      $sku2=$sku1+'1';
	 
	$p="Fosso"; 
	  $product_sku=$p.$sku2;
 if($product_offer=="")
 {
 	$product_offer='0';
 }
 	$productprice2=$_POST['product_offer'];
 if($productprice2!='')
{
$discounttoltal=$product_price-$productprice2;
$product_offer=         ($discounttoltal / $product_price) * 100;
//$//update1=$product_price1-$discounttoltal1;
$product_offer2=round($product_offer);
$product_offer2 = str_replace( '-', '', $product_offer2 ); 

$offer_amount=$productprice2;
$productprice21=$productprice2;
 
}
 
                
                  $hyphenTag1111 = str_replace( '-', '', $hyphenTag1 );
                  $hyphenTag1111 = str_replace( '(', '', $hyphenTag1111 );
                  $hyphenTag1111 = str_replace( ')', '', $hyphenTag1111 );
                  $hyphenTag1111 = str_replace( ',', '', $hyphenTag1111 );
                 $hyphenTag1x= strtolower($hyphenTag1111);
 
   //$hyphenTag1x= str_replace( ' ', '', $product_name );
 //  $hyphenTag1x= str_replace( '~!@#$%^&*()-=+_][{},', '', $hyphenTag1x );
 $dd=date('dm');
   $hyphenTag1x= strip_tags($hyphenTag1x);
   $random_digit=rand(000000,999999);
	   $codep = $hyphenTag1x.$random_digit.$dd;
  
  $theme = $_POST['theme'];
  $brand = $_POST['brand'];
  $type = $_POST['type'];
  $gender = $_POST['gender'];
  $design = $_POST['design'];
  $stock = $_POST['stock'];
  $new_exclusive = $_POST['new_exclusive'];
   $sleeves = $_POST['sleeves'];
     $material = $_POST['material'];
    $product_des = $_POST['content'];
$table = "product";$ac='';
 


  $up="UPDATE `product` SET  `sku`='$codep', `product_name`='$product_name',`description`='$product_des' ,`brand`='$brand',`url`='$hyphenTag1' WHERE sku='".$_POST['sku1']."'";
$res=mysqli_query($conn,$up);
  if($res)
  {
  	
	$zz='asd';
  	$ds='<meta http-equiv="Refresh" content="2;url=add-product-variation.php?sku='.$codep.'">' ;
 
 
 //echo'<script>location.assign("add-product-variation.php?sku='.$codep.'")</script>';
	}  }
?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->

<!-- Specific Page Data -->
<!-- End of Data -->

<head>
    <meta charset="utf-8" />
    <title>Admin</title>
   <?php if($zz!='')
  { echo $ds;
  } ?>
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    
    
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
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
       <script src="ckeditor/ckeditor.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="js/html5shiv.js"></script>
      <script type="text/javascript" src="js/respond.min.js"></script>     
    <![endif]-->
    
    <script type="text/javascript" src="jscolor.js"></script>
</head>    

<body id="forms" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix" data-active="forms "  data-smooth-scrolling="1">     
<div class="vd_body">
<!-- Header Start -->
   <?php include"header.php"; ?>
  <!-- Header Ends --> 
<div class="content">
  <div class="container">
    <?php include"adminleftmenu.php";?>   
    
    <!-- Middle Content Start -->
    
    <div class="vd_content-wrapper">
      <div class="vd_container">
        <div class="vd_content clearfix">
          <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
              <ul class="breadcrumb">
                <li><a href="index.php">Home</a> </li>
                <li><a href="forms-elements.php">Forms</a> </li>
                <li class="active">Add PRoducts</li>
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
              <h1>Add Product</h1>
          </div>
          </div>
          <div class="vd_content-section clearfix">
            
        <style>
        	.ccs
        	{
				
				width:40% !important;
			}
        </style>
            <div class="row">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-magic"></i> </span> Add product Detail </h3>
                  </div>
                  <div class="panel-body">
                    <form class="form-horizontal" action="" method="post" role="form">
                      <div id="wizard-2" class="form-wizard">
                        <ul>
                          <li><a href="#tab21" data-toggle="tab"> <div class="menu-icon"> 1 </div>  Select Category </a></li>
                          <li class="active"><a href="#tab22" data-toggle="tab"> <div class="menu-icon"> 2 </div>  Vitual Info </a></li>
                          <li><a href="#tab23" data-toggle="tab"> <div class="menu-icon"> 3 </div>  Variations </a></li>
                          <li><a href="#tab24" data-toggle="tab">  <div class="menu-icon"> 4 </div> Price/Offer </a></li>
                          <li><a href="#tab25" data-toggle="tab">  <div class="menu-icon"> 5 </div> Images </a></li>
                        </ul>
                        <div class="progress progress-striped active">
                          <div class="progress-bar progress-bar-info ccs" style=""> </div>
                        </div>
                        <div class="tab-content no-bd pd-25">
                         
                          <div class="tab-pane active" id="tab22">
                              <div class="form-group">
                        <label class="col-sm-2 control-label"> </label>
                        <div class="col-sm-7 controls">
                           <?php if($zz!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-8">
	<div class="alert alert-success"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong> You successfully Added Information   </div>
	</div>
	<div class="col-md-3">
	 </div>
</div>
  <?php } ?>
                        </div>
                      </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Product Name</label>
                              <div class="col-sm-7 controls">
                                <input type="text" name="product_name" required  class="input-border-btm">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Product Brand</label>
                              <div class="col-sm-7 controls">
                                <input type="text" class="input-border-btm"  name="brand" required>
                              </div>
                            </div>
                             <div class="form-group">
                        <label class="col-sm-2 control-label">Add Product Description/about</label>
                        <div class="col-sm-7 controls">
                          <textarea class="ckeditor"  id="" cols="70" name="content"    rows="20"  ></textarea>
                        </div>
                      </div> 
                          </div>
                        <input type="hidden" name="sku1" value="<?php echo $_GET['sku'];?>"> 
                          <div class="form-actions-condensed wizard">
                            <div class="row mgbt-xs-0">
                              <div class="col-sm-9 col-sm-offset-2">   <button class="btn vd_btn next" type="submit" name="btn-save">Next <span class="menu-icon"><i class="fa fa-fw fa-chevron-circle-right"></i></span></button>   </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- Panel Widget --> 
              </div>
              <!-- col-md-12 --> 
            </div>
            <!-- row -->
            
         
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
                  	Copyright &copy;2018 Admin  Inc. All Rights Reserved 
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

<script type="text/javascript" src='plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js'></script>


<script type="text/javascript">
$(document).ready(function() {
	"use strict";
	
	$('#wizard-1').bootstrapWizard({
		'tabClass': 'nav nav-pills nav-justified',
		'nextSelector': '.wizard .next',
		'previousSelector': '.wizard .prev',
		'onTabShow' : function(){
			$('#wizard-1 .finish').hide();
			$('#wizard-1 .next').show();
			if ($('#wizard-1 .nav li:last-child').hasClass('active')){
				$('#wizard-1 .next').hide();
				$('#wizard-1 .finish').show();
			}
		},
		'onNext': function(){
			scrollTo('#wizard-1',-100);
		},
		'onPrevious': function(){
			scrollTo('#wizard-1',-100);
		}	
	});
	$('#wizard-2').bootstrapWizard({
		'tabClass': 'nav nav-pills nav-justified',
		'nextSelector': '.wizard .next',
		'previousSelector': '.wizard .prev',
		'onTabShow' :  function(tab, navigation, index){
			$('#wizard-2 .finish').hide();
			$('#wizard-2 .next').show();
			if ($('#wizard-2 .nav li:last-child').hasClass('active')){
				$('#wizard-2 .next').hide();
				$('#wizard-2 .finish').show();
			}
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('#wizard-2').find('.progress-bar').css({width:$percent+'%'});			
		},
		'onTabClick': function(tab, navigation, index) {
			return false;		
		},
		'onNext': function(){
			scrollTo('#wizard-2',-100);
		},
		'onPrevious': function(){
			scrollTo('#wizard-2',-100);
		}		
	});	
	$('#wizard-3').bootstrapWizard({
		'tabClass': 'nav nav-pills nav-justified',
		'nextSelector': '.wizard .next',
		'previousSelector': '.wizard .prev',
		'onTabShow' : function(){
			$('#wizard-3 .finish').hide();
			$('#wizard-3 .next').show();
			if ($('#wizard-3 .nav li:last-child').hasClass('active')){
				$('#wizard-3 .next').hide();
				$('#wizard-3 .finish').show();
			}
		},
		'onNext': function(){
			scrollTo('#wizard-3',-100);
		},
		'onPrevious': function(){
			scrollTo('#wizard-3',-100);
		}		
	});	
	$('#wizard-4').bootstrapWizard({
		'tabClass': 'nav nav-tabs nav-stacked',
		'nextSelector': '.wizard .next',
		'previousSelector': '.wizard .prev',
		'onTabShow' : function(){
			$('#wizard-4 .finish').hide();
			$('#wizard-4 .next').show();
			if ($('#wizard-4 .nav li:last-child').hasClass('active')){
				$('#wizard-4 .next').hide();
				$('#wizard-4 .finish').show();
			}
		},
		'onNext': function(){
			scrollTo('#wizard-4',-100);
		},
		'onPrevious': function(){
			scrollTo('#wizard-4',-100);
		}		
	});		
	$('#wizard-5').bootstrapWizard({
		'tabClass': 'nav nav-tabs nav-stacked',
		'nextSelector': '.wizard .next',
		'previousSelector': '.wizard .prev',
		'onTabShow' : function(){
			$('#wizard-5 .finish').hide();
			$('#wizard-5 .next').show();
			if ($('#wizard-5 .nav li:last-child').hasClass('active')){
				$('#wizard-5 .next').hide();
				$('#wizard-5 .finish').show();
			}
		},
		'onNext': function(){
			scrollTo('#wizard-5',-100);
		},
		'onPrevious': function(){
			scrollTo('#wizard-5',-100);
		}		
	});		
});
</script>
<!-- Specific Page Scripts END -->
 

</body>
</html>