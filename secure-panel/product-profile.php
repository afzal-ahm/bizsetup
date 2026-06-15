<?php 
session_start(); 
error_reporting(0);
include_once'dbMysql.php';
include_once 'config.php';
$table="category";
$con = new DB_con();
$res=$con->select($table);
if(isset($_GET['sku']))
{
	$sku=$_GET['sku'];
	 $string = str_replace("#", "", $sku); 
	  $select="SELECT * from product where id='".$string."'";
	 $run=mysqli_query($conn,$select);
	 foreach($run as $key=> $product);
}

if(isset($_POST['categorysubmit']))
{
	
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
 
 if($_POST['sub_subcategory_name']!='' OR  $_POST['subcategory_name']!='')
 {
 	
 	  $upc="UPDATE `product` SET    `product_category`='$category_name1',`product_subcategory`='$subcategory_name' ,`sub_subcategory_id`='$sub_subcategory_name',`category`='$category_name',`subcategory`='$sub_name',`subsubcategory`='$sub_sub_name' WHERE sku='".$product['sku']."'";
$res=mysqli_query($conn,$upc);
  if($res)
  {
  	
	$cats='asd';
 
 //echo'<script>location.assign("add-product-variation.php?sku='.$codep.'")</script>';
	} 
 }
 else{
 	$cats1='asd';
 	
 }
	
	 
}

if(isset($_POST['information']))
{
	$name=$_POST['productname'];
	$dis=$_POST['dis'];
	$brand=$_POST['brand'];
	
	             $seotopic = strip_tags($name);
                  $hee=strtolower($seotopic);
                  $hee=strtolower($seotopic);
                  
                  $myTag = trim($seotopic); 
                  $string01 = str_replace("'", "$%", $myTag); 
                 
                  $string = str_replace("&", "and", $string01); 
                  $string1 = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
                  $string12 = preg_replace("/[ ]+/", " ", $string1);                
                  $hyphenTag1 = str_replace( ' ', '-', $string12 );
                  
                  
$image_name = $_FILES['image']['name'];
if($image_name !="" ){
	 $image_type = $_FILES['image']['type'];
	 $image_size = $_FILES['image']['size'];
	 $image_tmp = $_FILES['image']['tmp_name'];
	 $random_digit=rand(0000,9999);
	   $imagename = $random_digit.$image_name;
	  move_uploaded_file($image_tmp,"../images/product/$imagename");
    $query="update product set image='$imagename' where sku='".$product['sku']."'";
    $run=mysqli_query($conn,$query);
}


	  $up="UPDATE `product` SET    `product_name`='$name',`description`='$dis' ,`brand`='$brand',`url`='$hyphenTag1' WHERE sku='".$product['sku']."'";
$res=mysqli_query($conn,$up);
  if($res)
  {
  	
	$zz='asd';
   
 
 //echo'<script>location.assign("add-product-variation.php?sku='.$codep.'")</script>';
	} 
}

if(isset($_POST['priceproduct']))
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
 


    $upz="UPDATE `product` SET  `mrp`='$product_price', `offer_amount`='$productprice2',`offer`='$product_offer2' ,`stock`='$stock'  WHERE sku='".$product['sku']."'";
$resz=mysqli_query($conn,$upz);            
 
	  
  if($resz)
  {
  	
	$zzp='asd';
   
 
 //echo'<script>location.assign("add-product-variation.php?sku='.$codep.'")</script>';
	} 
}


if(isset($_POST['uploadimage'])){
	     
	  $sku=$_POST['sku'];  
	   
  
$valid_formats = array("jpg", "png", "gif", "zip", "bmp","jpeg","JPEG","PNG","JPG");
  $max_file_size = 999999*999999; //100 kb
  $random_digit=rand(0000,9999);
    
  $path = "../images/product/"; // Upload directory
  $count = 0;
foreach ($_FILES['upload_file']['name'] as $f => $name) { 
         
      if ($_FILES['upload_file']['error'][$f] == 4) {
          continue; 
      }        
      if ($_FILES['upload_file']['error'][$f] == 0) {            
          if ($_FILES['upload_file']['size'][$f] > $max_file_size) {
              $message[] = "$name is too large!.";
              continue; 
          }
      elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
        $message[] = "$name is not a valid format";
        continue; 
      }
          else{ 
         $name=   $random_digit.$name;
              if(move_uploaded_file($_FILES["upload_file"]["tmp_name"][$f], "../images/product/$name")) 
              {
               	  $quer1="insert into image_manager set p_sku='".$sku."',image='$name' ";
              	$un=mysqli_query($conn,$quer1);
	 
             
				
			  }
          }

 	
}
  }
  
   
		 
		// echo "<script type=\"text/javascript\">".
      //  "alert('Image Added successfully');".
        // "</script>";
	 
 // echo "<script>window.location.href='complete.php?sku='</script>";
		
		
	}

?>

<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->

<!-- Specific Page Data -->
<!-- End of Data -->

<head>
    <meta charset="utf-8" />
   
    <title>:: Admin ::</title>
      
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    
    
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">
    
    
       <script src="ckeditor/ckeditor.js"></script>
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
	<link href="plugins/dataTables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"><link href="plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"><link href="plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css"><link href="plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css">    
     
    <!-- Theme CSS -->
    <link href="css/theme.min.css" rel="stylesheet" type="text/css">
    <!--[if IE]> <link href="css/ie.css" rel="stylesheet" > <![endif]-->
    <link href="css/chrome.css" rel="stylesheet" type="text/chrome"> <!-- chrome only css -->    


        
    <!-- Responsive CSS -->
        	<link href="css/theme-responsive.min.css" rel="stylesheet" type="text/css"> 

	  
 
 
    <!-- for specific page in style css -->
    		<style>
	
						.form-wizard .nav > li > a{padding: 10px; margin-right:0; text-align: left; color:#888888;}
                        .tab-right{margin-left:-30px; margin-top:-1px; }
						.tab-right .panel {margin-right:-30px;}
						.tab-right .vd_panel-menu {right: 28px; top: -15px;}	
						.tab-right h3{border-bottom:1px solid #EEEEEE;}	
						table .vd_radio label:after{top:0;}		 
	 
	 	
		</style>
	    
    <!-- for specific page responsive in style css -->
    		<style>
	
						@media (max-width: 767px) {
							.tab-right{margin-left:0; margin-top:0;}
							.tab-right .panel{margin-right: 0;}

						}	
		
		</style>
	    
    
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

</script><script>
 
function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<img   src='"+URL.createObjectURL(event.target.files[i])+"'> ");
 }
}
</script><style>
	#image_preview img
	{
		width: 150px !important;
		height: 150px  !important;
		padding-left: 10px;
	}
</style>
    <script type="text/javascript" src="jscolor.js"></script>
</head>    

<body id="pages" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix" data-active="pages "  data-smooth-scrolling="1">     
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
                <li><a href="pages-custom-product.php">Pages</a> </li>
                <li class="active">Ecommerce Add Product</li>
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
              <h1>Add Product <span style="float: right;"><a class="btn btn-danger" href="product-profile.php?sku=<?php echo $_GET['sku'];;?>">Refresh page</a></span></h1>
              <small class="subtitle">Ecommerce Pages: Add Product</small>
             
              <div class="vd_panel-menu visible-xs">
                <div class="menu">
                  <div data-action="click-trigger"> <span class="menu-icon mgr-10"><i class="fa fa-bars"></i></span>Menu <i class="fa fa-angle-down"></i> </div>
                  <div data-action="click-target" class="vd_mega-menu-content width-xs-2 left-xs" style="display: none;">
                    <div class="child-menu">
                      <div class="content-list content-menu">
                     
                      </div>
                    </div>
                  </div>
                </div>
                <!-- menu --> 
              </div>
            </div>
          </div>
          

          <div class="vd_content-section clearfix" id="ecommerce-product-add">
            <div class="row">
              <div class="col-sm-3 col-md-4 col-lg-3">
                <div class="form-wizard condensed mgbt-xs-20">
                  <ul class="nav nav-tabs nav-stacked">
                    <li class="active"><a href="#tabinfo" data-toggle="tab"> <i class="fa fa-info-circle append-icon"></i> Information </a></li>  
                  </ul>
                </div>
              </div>
              <div class="col-sm-9 col-md-8 col-lg-9 tab-right">
                <div class="panel widget panel-bd-left light-widget">
                  <div class="panel-heading no-title"> </div>
                  <div  class="panel-body">
                    <div class="tab-content no-bd mgbt-xs-20">
                      <div id="tabinfo" class="tab-pane active">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="">
                          <div class="vd_panel-menu">
                            <div> <button class="btn vd_btn vd_bg-blue btn-sm save-btn" type="submit" name="information"><i class="fa fa-save append-icon"></i> Save Changes</button>   </div>
                          </div>
                          <h3 class="mgtp-15 mgbt-xs-20"> Product Information</h3>
                        
                          <!-- form-group -->
                          
                          <div class="form-group">
                            
                            <div class="col-lg-12">
                               <?php if($zz!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-8">
	<div class="alert alert-success"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong> You successfully Updated Information   </div>
	</div>
	<div class="col-md-3">
	 </div>
</div>
  <?php } ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">Product Name </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <input type="text" required value="<?php echo $product['product_name'];?>" name="productname" class="  updateCurrentText " id="name_1" >
                                </div>
                                 
                              </div>
                            </div>
                          </div>
                            <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">OLD image </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <img src="../images/product/<?php echo $product['image'];?>">
                                </div>
                                 
                              </div>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">Product Name </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <input type="file"    name="image" class="  updateCurrentText " id="name_1" >
                                </div>
                                 
                              </div>
                            </div>
                          </div>
                            
                          <!-- form-group -->
                        
                          
                          <div class="form-group">
                            <label for="description_1" class="control-label col-lg-3"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Appears in the body of product detail."> Description </span> </label>
                            <div class="col-lg-9 mgbt-xs-10 mgbt-lg-0">
                              <textarea name="dis" id="description_1" value="" data-rel="ckeditor" rows="1" ><?php echo $product['description'];?></textarea>
                            </div>
                            
                          </div>
                          <!-- form-group -->
                          
                          
                        </form>
                      </div>
                      <!-- #tabinfo -->
                      <div id="tabprice" class="tab-pane">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="">
                        
                        <div class="vd_panel-menu">
                          <div> <button name="priceproduct" type="submit" class="btn vd_btn vd_bg-blue btn-sm save-btn"><i class="fa fa-save append-icon"></i> Save Changes</button> </div>
                        </div>
                        <h3 class="mgtp-15 mgbt-xs-20"> Product Price</h3>
                      
                          
                          <div class="form-group">
                            
                            <div class="col-lg-12">
                               <?php if($zzp!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-8">
	<div class="alert alert-success"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong> You successfully Updated Information   </div>
	</div>
	<div class="col-md-3">
	 </div>
</div>
  <?php } ?>
                            </div>
                          </div>
                        <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">Product Price </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <input type="text" required value="<?php echo $product['mrp'];?>" name="product_price" class="  updateCurrentText " id="name_1" >
                                </div>
                                 
                              </div>
                            </div>
                          </div>
                          
                           <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">Product Price after Offer </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <input type="text" required value="<?php echo $product['offer_amount'];?>" name="product_offer" class="  updateCurrentText " id="name_1" >
                                </div>
                                 
                              </div>
                            </div>
                          </div>
                          
                           <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">Product Offer </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <input type="text"  disabled="" value="<?php echo $product['offer'];?>" name="pr " class="  updateCurrentText " id="name_1" >
                                </div>
                                 
                              </div>
                            </div>
                          </div>

 <div class="form-group">
                            <label for="name_1" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="The public name for this product. Invalid characters &lt;&gt;;=#{}">Product Stock </span> </label>
                            <div class="col-lg-5">
                              <div class="row mgbt-xs-0">
                                <div class="col-sm-9">
                                  <input type="text" required value="<?php echo $product['stock'];?>" name="stock" class="  updateCurrentText " id="name_1" >
                                </div>
                                 
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- #tab-price -->
                      <div id="tabseo" class="tab-pane">
                        <h3 class="mgtp-15 mgbt-xs-20"> Search Engine Optimization</h3>
                        <form class="form-horizontal">
                          <div class="vd_panel-menu">
                            
                          </div>
                         
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="alert alert-warning translatable-field lang-1" style="display: block;"> <i class="fa fa-link"></i> The product link will look like this<br>								<?php  $cate= $product['category'];
                              
                                   $myTag = trim($cate); 
                                  $string01 = str_replace("'", "$%", $myTag); 
                                   $string = str_replace("&", "and", $string01); 
                  					$string1 = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
                  					$string12 = preg_replace("/[ ]+/", " ", $string1);                
                 					 $hyphenTag1c = str_replace( ' ', '-', $string12 );
                 					 
                 					 
                 					  $scate = $product['subcategory'];
                              
                                   $myTag1 = trim($scate); 
                                  $string011 = str_replace("'", "$%", $myTag1); 
                                   $string1 = str_replace("&", "and", $string011); 
                  					$string11 = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string1);
                  					$string121 = preg_replace("/[ ]+/", " ", $string11);                
                 					 $hyphenTag1cs = str_replace( ' ', '-', $string121 ); 
                 					 
                 				 	 $sscate = $product['subsubcategory'];
                              
                                   $myTag2 = trim($sscate); 
                                  $string012 = str_replace("'", "$%", $myTag2); 
                                   $string2 = str_replace("&", "and", $string012); 
                  					$string12 = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string2);
                  					$string122 = preg_replace("/[ ]+/", " ", $string12);                
                 					 $hyphenTag1css = str_replace( ' ', '-', $string122 );?>
                               
                                <strong>http:/fosso.in/<?php echo $hyphenTag1c;?>/<?php echo $$hyphenTag1cs;?>/<?php echo $$$hyphenTag1css;?>/<span id="friendly-url_1"><?php echo $product['url'];?>/<?php echo $product['sku'];?>/</span></strong> </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- tabseo -->
                      
                 
                      <div id="tabasso" class="tab-pane">
                       
                        <h3 class="mgtp-15 mgbt-xs-20" > Associations</h3>
                        <form class="form-horizontal"  method="post" enctype="multipart/form-data" action="">
                         <div class="vd_panel-menu">
                          <div> <button name="categorysubmit" type="submit" class="btn vd_btn vd_bg-blue btn-sm save-btn"><i class="fa fa-save append-icon"></i> Save Changes</button> </div>
                        </div>
                          <div class="vd_panel-menu">
                            <div>  </div>
                          </div>
                           <div class="form-group">
                        <label class="col-sm-12 control-label"> </label>
                        <p><?php echo $product['category'];?> ->  <?php echo $product['subcategory'];?> -> <?php echo $product['subsubcategory'];?></p>
                        </div>
                           
                        <div class="col-sm-12 controls">
                        
                           <h3 class="mgtp-15 mgbt-xs-20" > Change Category</h3>
                           <?php if($cats!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-8">
	<div class="alert alert-success"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong> You successfully Added Information   </div>
	</div>
	<div class="col-md-3">
	 </div>
</div>
  <?php } ?>
  <?php if($cats1!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-8">
	<div class="alert alert-danger"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Opps !</strong> Something went Wrong please select subcategory and sub subcategory  </div>
	</div>
	<div class="col-md-3">
	 </div>
</div>
  <?php } ?>


                        </div>
                      
                            <div class="form-group">
                        <label class="col-sm-2 control-label">Select Category</label>
                        <div class="col-sm-7 controls">
                          <select class="width-40" name="category_name" id="myselect" > 
                            <option>----All------</option>
                             <?php
							 foreach($res as $key)
									  
								  // echo $key;
										echo'<option value="'.$key['category_id'].'">'.$key['category_name'].'</option>';
										
                                      ?> 
                          </select>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="col-sm-2 control-label">Select Sub Category</label>
                        <div class="col-sm-7 controls">
                          <select class="width-40" name="subcategory_name" id = "myselect1" >
                            
                          </select>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="col-sm-2 control-label">Select Sub SubCategory</label>
                        <div class="col-sm-7 controls">
                          <select class="width-40" name="sub_subcategory_name" id = "sub_subcategory" >
                            
                          </select>
                        </div>
                      </div>
                      
                        </form>
                      </div>
                      <!-- tab-pane -->
                      <div id="tabimage" class="tab-pane">
                        <h3 class="mgtp-15 mgbt-xs-20"> Images</h3>
                        <form action="" enctype="multipart/form-data" method="post"  class="form-horizontal">
                          <div class="vd_panel-menu">
                            
                          </div>
                          <?php
                            $sku=$_GET['sku'];
	 $string = str_replace("#", "", $sku); 
	  ?>
                          
                          
                          <div class="form-group">
                              <label class="col-sm-2 control-label">Choose Image</label>
                              <div class="col-sm-5 controls">
                              <input type="file"  id="upload_file" name="upload_file[]" onchange="preview_image();"   required class="  input-border-btm">
                                 <input type="hidden" name="sku" value="<?php echo $string;?>"> 
                              </div>
                            </div>
                            <br>
  <div id="image_preview"></div>
                          <br>
                            <div class="form-group">
                              <label class="col-sm-7 control-label">Upload Image</label>
                              <div class="col-sm-5 controls">
                               <button class="btn vd_btn  "   style="background-color: #2A728D ;"  name="uploadimage" type="submit" >Upload Image <span class="menu-icon"><i class="fa fa-fw fa-chevron-circle-right"></i></span></button> 
                              </div>
                            </div>
                          
                          <table id="imageTable" class="table table-dragable">
                            <thead>
                              <tr class="nodrag nodrop">
                                <th style="width:20px"></th>
                                <th class="fixed-width-lg" style="width:80px"><span class="title_box">Image</span></th>
                              
                                <th>Action</th>
                                <!-- action --> 
                              </tr>
                            </thead>
                            <tbody id="imageList">
                            
                             <?php  
                        $select="SELECT * from   image_manager where p_sku='".$string."'";
                      $ff=mysqli_query($conn,$select);
                      foreach ($ff as $key=> $data) 
                      {
					  	
					
                      ?>
                              <tr id="1">
                                <td><i class="fa fa-arrows vd_soft-grey"></i></td>
                                <td><a data-rel="prettyPhoto" href="../images/product/<?php echo $data['image'];?>"> <img style="width: 70px;" src="../images/product/<?php echo $data['image'];?>"> </a></td>
                               
                                
                                <td><a class="delete_product_image pull-right btn vd_btn vd_bg-yellow btn-sm" href="image-delete1.php?sku=<?php echo $sku;?>&id=<?php echo $data['id'];?>"> <i class="icon-trash append-icon"></i> Delete this image </a></td>
                              </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                        </form>
                      </div> 

   <div id="tabattri" class="tab-pane">
                        <h3 class="mgtp-15 mgbt-xs-20"> Attributes</h3>
                        <form action="" enctype="multipart/form-data" method="post"  class="form-horizontal">
                          <div class="col-md-8">
                        <div class="tab-content no-bd pd-25">
                          
                          <div class="tab-pane active" id="tab23">
                             <div class="form-group">
                              <label class="col-md-2 control-label">Variation Type <small style="color: Red">(Color/Size)</small></label>
                              <div class="col-md-9 controls">
                                <input type="text" id="variation_type" name="variation_type" required  class="input-border-btm">
                              </div>
                            </div>
                            
                             
                            <div class="form-group">
                              <label class="col-md-2 control-label">Variation Name <small style="color: Red">(Size- M/S/L Color - red/blue etc)</small></label>
                              <div class="col-md-9 controls">
                                <input type="text" id="variation_name" name="variation_name" required  class="input-border-btm">
                              </div>
                            </div>
                            
                                  <div class="form-group">
                                                <label class="col-md-2 control-label"><small style="color: Red">Color Code only for color Variation</small> </label>
                                                <div class="col-md-9 controls">
                                                   <button class="jscolor {valueElement:'chosen-value', onFineChange:'setTextColor(this)'}"> Pick text color </button>
                                                 HEX value: <input id="chosen-value" name="color_code" value="">
                                                </div>
                                            </div> 
                          </div>
                            <input type="hidden" id="sku1" value="<?php echo $product['sku'];?>"> 
                           
                        </div>
                      </div>
                      <div class="col-md-4">    <div id="txtHint"> </div>
                      
                       
                 
                       </div>
                          <div class="col-md-12 col-sm-offset-2">
                              <br>
                               <span onclick="showUserfilter(this.value)" style="background-color: #2A728D" value="1" class="btn vd_btn next" href="javascript:void(0);">Add More Variation <span class="menu-icon"><i class="fa fa-fw fa-chevron-circle-right"></i></span></span>
                             
                              
                                 </div>
                                 
                                 <br>
                                  <table id="imageTable" class="table table-dragable">
                            <thead>
                              <tr class="nodrag nodrop">
                                <th style="width:20px"></th>
                                <th class="fixed-width-lg" style="width:80px"><span class="title_box">Image</span></th>
                              
                                <th>Action</th>
                                <!-- action --> 
                              </tr>
                            </thead>
                            <tbody id="imageList">
                            
                             <?php  
                       $select1="SELECT * from   attributemanager_2 where sku='".$product['sku']."'";  
                      $ff1=mysqli_query($conn,$select1);
                      foreach ($ff1 as $key=> $data1) 
                      {
					   	$type=$data1['type'];   $code=$data1['code'];
					
                      ?>
                              <tr id="1">
                                <td><i class="fa fa-arrows vd_soft-grey"></i></td>
                                <td><?php echo $data1['type'];?></td><td><?php echo $data1['attribute_name'];?>  <?php if($type=='color'){echo '<button style="background-color: #'.$code.'">'.$type.'</button>'; } ?></td>
                               
                                
                                <td><a class="delete_product_image pull-right btn vd_btn vd_bg-yellow btn-sm" href="attribute-delete1.php?sku=<?php echo $sku;?>&id=<?php echo $data1['id'];?>"> <i class="icon-trash append-icon"></i> Delete  </a></td>
                              </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                        </form>
                      </div>
                      <!-- tab-pane -->
          <script>
function showUserfilter(str) {
	//alert(str);
	 var variation_type=$("#variation_type").val();
//	alert(id);
	var color_code=$("#chosen-value").val();
	var sku1=$("#sku1").val();
	var variation_name=$("#variation_name").val();
	//alert(variation_type);alert(color_code);alert(sku1);alert(variation_name);
    if (str == "") {
    	
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
            xmlhttp.open("GET","add-product-varitionajex.php?variation_type=" +variation_type+ "&variation_name=" +variation_name+ "&sku=" +sku1+ "&color_code=" +color_code,true);
      
        xmlhttp.send();
    }
}
</script>             
                  
                    
                    </div>
                    <!-- tab-content --> 
                    
                  </div>
                  <!-- panel-body --> 
                  
                  <!-- form-horizontal --> 
                </div>
                <!-- Panel Widget --> 
              </div>
              <!-- col-sm-12--> 
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
 
<!-- /.modal -->
  
<!-- /.modal -->

<!-- Footer Start -->
  <footer class="footer-1"  id="footer">      
    <div class="vd_bottom ">
        <div class="container">
            <div class="row">
              <div class=" col-xs-12">
                <div class="copyright">
                  	Copyright &copy;2019   Inc. All Rights Reserved 
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
<script type="text/javascript" src='plugins/tagsInput/jquery.tagsinput.min.js'></script>
<script type="text/javascript" src='plugins/bootstrap-timepicker/bootstrap-timepicker.min.js'></script>
<script type="text/javascript" src='plugins/daterangepicker/moment.min.js'></script>
<script type="text/javascript" src='plugins/daterangepicker/daterangepicker.js'></script>
<script type="text/javascript" src='plugins/colorpicker/colorpicker.js'></script>
<script type="text/javascript" src='plugins/ckeditor/ckeditor.js'></script>
<script type="text/javascript" src='plugins/ckeditor/adapters/jquery.js'></script>
<script type="text/javascript" src="plugins/bootstrap-wysiwyg/js/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="plugins/bootstrap-wysiwyg/js/bootstrap-wysihtml5-0.0.2.js"></script>
<script type="text/javascript">
$(window).load(function() 
{
	"use strict";



	//CKEDITOR.replace( $('[data-rel^="ckeditor"]') );
	$( '[data-rel^="ckeditor"]' ).ckeditor();


	$( '#imageTable tbody' ).sortable({
		placeholder: "warning",
		helper: function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
				$(this).css('background','rgba(255,255,255,.6)');
			});
			return ui;
		},				
		stop: function(e, ui) {
			$( '#imageTable tbody' ).children().each(function() {
				var object=$(this);
				object.children('.pointer').html(object.index()+1);
			});

		}
		}).disableSelection();
		

	
	$('.save-btn').click(function(e) {
		var object= $(this);
		object.addClass('disabled');
        object.prepend('<i id="save-spinner" class="fa fa-spinner fa-spin append-icon"></i>');	
		object.children('.fa-save').remove();
		setTimeout(function(){
			object.children('.fa-spinner').remove();
			object.removeClass('disabled');
			object.prepend('<i class="fa fa-save append-icon"></i>');
			notification('topright', 'success', 'fa fa-check-circle vd_green', 'Save Successfully', 'Your has setting is saved successfully')			
			},2000)	 
		; 
    });
	
	$('#add-price-btn').click(function(e) {
		var option_value = $("#addPriceModal #option-combination").val();
		var price_value = $("#addPriceModal #price-combination").val();		
		var check_value = $('#addPriceModal #enable-combination').bootstrapSwitch('state') ? '<i class="fa fa-check vd_green"></i>' : '<i class="fa fa-times vd_grey"></i>';	
		var menu_value = $('#addPriceModal #enable-combination').bootstrapSwitch('state') ? 	'<a data-original-title="Disabled" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_green"> <i class="fa fa-power-off"></i> </a>' : '<a data-original-title="Enabled" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_grey"> <i class="fa fa-power-off"></i> </a>'
		$('#specific_price_table tbody').append('<tr>' + '<td>' + option_value +'</td>\
                                <td>$' + price_value + '</td>\
                                <td class="text-center">' + check_value + '</td>\
                                <td class="menu-action">' + menu_value + ' <a data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_yellow"> <i class="fa fa-pencil"></i> </a> <a data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_red"> <i class="fa fa-times"></i> </a></td>\
                              </tr>' + '</tr>');
		$('[data-toggle^="tooltip"]').tooltip();							  
							  
		$('#addPriceModal').modal('hide');							  
		
	});
	
	// count down on meta keyword/description text size
	
	function countDown($source, $target) {
		var max = $source.attr("data-maxchar");
		$target.html(max-$source.val().length);
	
		$source.keyup(function(){
			$target.html(max-$source.val().length);
		});
	}
	

	
		countDown($("#meta_title_1"), $("#meta_title_1_counter"));
		countDown($("#meta_description_1"), $("#meta_description_1_counter"));

})
</script>

<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */

$(function () {
    'use strict';

    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'plugins/jquery-file-upload/server/php/',
        uploadButton = $('<button/>')
            .addClass('btn vd_btn vd_bg-blue')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            }); 
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index, file) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		

});
</script>
<script type="text/javascript">

</script>
<!-- Specific Page Scripts END -->


 

</body>
</html>