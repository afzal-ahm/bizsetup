<?php
error_reporting(0);
include_once'dbMysql.php';
include_once 'config.php'; include "userinfo.php";

 ?><!DOCTYPE html>
<html lang="en">
 
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Fosso</title>
        <link rel="stylesheet" type="text/css" href="assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
        <!-- Custom CSS -->
        <link href="dist/css/style.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="horizontal-nav skin-megna fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
          <?php include "header.php";?>                       <!-- ============================================================== -->
                                                
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Select Product</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Select Product</li>
            </ol>
            <a href="add-product.php"><button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>Select Product</button></a>
        </div>
    </div>
</div>
<!-- ============================================================== --> 

<style>
    .RZbAt {
    cursor: pointer;
    min-width: 90px;
    white-space: nowrap;
    color: rgb(255, 255, 255);
    background-color: rgb(71, 160, 251);
    height: 40px;
    padding-left: 15px;
    padding-right: 16px;
    text-transform: uppercase;
    border-radius: 2px;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(71, 160, 251);
    border-image: initial;
}


.loglGA {
    text-align: center;
    font-family: "Riona Sans Light", sans-serif;
    background-color: transparent;
    display: inline-block;
    width: 51%;
}.loglGA .product-search-input {
    width: 325px;
}.izvvGf {
    width: 100%;
    box-sizing: border-box;
    color: rgb(119, 119, 119);
    background-color: rgb(255, 255, 255);
    height: 40px;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(223, 223, 223);
    border-image: initial;
    padding: 0px 13px 2px;
    border-radius: 3px;
}.loglGA .addlistings-search-btn {
    top: 1px;
    width: 140px;
    height: 40px;
    position: relative;
    vertical-align: middle;
    margin: 0px 0px 0px -4px;
    border-radius: 0px 2px 2px 0px;
}

.vertical-card-footer {
    text-align: right;
    position: absolute;
    width: 100%;
    bottom: 0px;
    padding-top: 10px;
    font-size: 12px;
    border-top: 1px solid rgb(223, 223, 223);
}
.add-listings-search-container .vertical-card-footer a {
    width: 180px;
    color: rgb(71, 160, 251);
    text-align: center;
    height: 30px;
    line-height: 31px;
    display: inline-block;
    text-decoration: none;
}.listingsMPSModal-default #listingSellingDetailsForm {
    font-size: 13px;
}
</style>

 
    
    
        <div class="row el-element-overlay">
                    
                    <?php
                    $c=$_GET['c'];
                    $s=$_GET['s'];
                    $ss=$_GET['ss'];
                    $b=$_GET['b'];
                    
                      $sss="SELECT DISTINCT product_name,sku,category,subcategory,subsubcategory,brand,product_category,product_subcategory,sub_subcategory_id  from product where product_category='$c' AND  product_subcategory='$s' AND  sub_subcategory_id='$ss' AND  brand='$b'    limit 18";
                    
                    $run=mysqli_query($conn,$sss);
                    foreach($run as $key=> $pro) 
                    ?>
                    
                    <?php if(isset($_POST['copy_product']))
                    {
                    	  
						$stock=$_POST['stock'];
						$charge=$_POST['charge'];
						$zone=$_POST['zone'];
						$nationl=$_POST['nationl'];
						$length1=$_POST['length1'];
						$breadth1=$_POST['breadth1'];
						$height1=$_POST['height1'];
						$weight1=$_POST['weight1'];
						$gst=$_POST['gst'];
						$sku_id=$_POST['sku_id'];
						$sku=$_POST['sku'];$status=$_POST['status'];
						
					$product_price = $_POST['product_price'];
$product_offer = $_POST['product_offer'];
$status = '0';
$brandactive = '0';
$number='100';
		 	$discounttoltal =$product_price*$product_offer/$number;
$offer_amount=$product_price-$discounttoltal;
$offer_amount=round($offer_amount);	
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
						
						
						
						
						 $sqlcat="select Count(*) AS 'tt' from product where  sku='$sku_id'  "; 
									$resultcat=mysqli_query($conn,$sqlcat);
									 $mlcat=mysqli_fetch_array($resultcat); 
									  $coucat= $mlcat[0];
									  if($coucat>0){
   $zzx='asd';
   
	}
	else{
		$ss="SELECT * from product where sku='$sku'";
		$run=mysqli_query($conn,$ss);
		foreach($run as $key=> $product)
		
		
		if($status=='')
		{
			$status=$product['status'];
		}
		else{
			
			$status=$status;
		}
		 $date = date("d M Y");
 $date1 =  date("H:i a");
 $datex=' ';
 $posting_date=$date.$datex.$date1;
		$svendor=$user_data['code'];
	  	$in="INSERT INTO `product`(  `sku`,`product_category`, `product_subcategory`, `sub_subcategory_id`, `product_name`, `description`, `mrp`, `offer`, `offer_amount`, `status`, `featured`, `brandactive`, `delivery`, `category`, `subcategory`, `subsubcategory`, `theme`, `brand`, `type`, `gender`, `design`, `stock`, `new_exclusive`, `sleeves`, `material`, `demo1`, `demo2`, `url`, `vendor_sku`, `date`, `producttype`, `payment`, `charge`, `zone`, `nationl`, `weight`, `tax`, `p_color`, `p_size`, `p_star`, `seo_title`, `seo_keyword`, `seo_metatag`, `seo_discription`, `sponserd`, `length1`, `breadth1`, `height1`, `weight1`) VALUES ( '".$sku_id."', '".$product['product_category']."','".$product['product_subcategory']."','".$product['sub_subcategory_id']."','".$product['product_name']."','".$product['description']."','".$product_price."','".$product_offer2."','".$productprice2."','".$status."','".$product['featured']."','".$product['brandactive']."','".$product['delivery']."','".$product['category']."','".$product['subcategory']."','".$product['subsubcategory']."','".$product['theme']."','".$product['brand']."','".$product['type']."','".$product['gender']."','".$product['design']."','".$stock."','".$product['new_exclusive']."','".$product['sleeves']."','".$product['material']."','".$product['demo1']."','".$product['demo2']."','".$product['url']."','".$svendor."','".$posting_date."','".$product['producttype']."','".$product['payment']."','".$charge."','".$zone."','".$nationl."','".$product['weight']."','".$gst."','".$product['p_color']."','".$product['p_size']."','".$product['p_star']."','".$product['seo_title']."','".$product['seo_keyword']."','".$product['seo_metatag']."','".$product['seo_discription']."','".$product['sponserd']."','".$length1."','".$breadth1."','".$height1."','".$weight1."')";
	$run=mysqli_query($conn,$in);
	
	$ss="SELECT * from image_manager where p_sku='$sku'";
		$run=mysqli_query($conn,$ss);
		foreach($run as $key=> $product1)
		{
			$image=$product1['image'];
			
			$inn="INSERT INTO `image_manager`(  `image`, `p_sku`) VALUES ('".$image."','".$sku_id."')";
			$run=mysqli_query($conn,$inn);
			
		}
	
	
	$ssa="SELECT * from attributemanager_2 where sku='$sku'";
		$runa=mysqli_query($conn,$ssa);
		foreach($runa as $key=> $product1a)
		{
			 
			
			$innx="INSERT INTO `attributemanager_2`( `sku`, `type`, `attribute_name`, `code`, `price`, `image`) VALUES ('".$sku_id."','".$innx['type']."','".$innx['attribute_name']."','".$innx['code']."','".$innx['price']."','".$innx['image']."')";
			$runx=mysqli_query($conn,$innx);
			
		}
	
	
	
	$ssac="SELECT * from product_comment where product_code='$sku'";
		$runac=mysqli_query($conn,$ssac);
		foreach($runac as $key=> $product1ac)
		{
			 
			
			$innxx="INSERT INTO `product_comment`(  `product_code`, `name`, `email`, `comment`, `star`, `date`, `status`) VALUES ('".$sku_id."', '".$product1ac['name']."', '".$product1ac['email']."', '".$product1ac['comment']."', '".$product1ac['star']."', '".$product1ac['date']."', '".$product1ac['status']."' )";
			$runxx=mysqli_query($conn,$innxx);
			
		}
		
		 $zz='asd';
	}
					}
					?>
                    
                    
                    
                     
                      <div class="col-lg-12 col-md-12">
                        <div class="card" >
                            <div class="el-card-item">
                                
                                <div class="el-card-content" style="padding: 28px;">
                                 
                                <div class="row"> 
                                <div class="col-md-4"></div>
                                
                                <div class="col-md-4">
                                	
                                	
                                	  <section id="modalbox-body" style="max-height:px;height: px" class="modalbox-body">
   <section id="modal-popup-content" class="modal-popup-content">
      <div id="blinx-wrapper-73" class="listingsMPSModal-default play-arena">
         <div>
            <?php if($zz!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-12">
	<div class="alert alert-success"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done !</strong> Product Listed Sucessfully  </div>
	</div>
 
</div>
  <?php } ?>
         <?php if($zzx!='')
                           { ?>
						   	
						  
<div class="col-md-12">
	<div class="col-md-12">
	<div class="alert alert-danger"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Oops !</strong> Sku code Already Generated .Please try new one   </div>
	</div>
 
</div>
  <?php } ?>
            <div id="listingSellingDetailsForm">
               <form  method="post"enctype="multipart/form-data" action="">
                  <div class="entity-form-group" data-group-no="0">
                     <div class="group-info clearfix">
                     <input type="hidden" name="sku" value="<?php echo $_GET['sku'];?>"  >
                     <hr>
                        <div class="group-name col-xs-5">Listing information</div>
                        <br>
                     </div>
                     <div class="entity-container clearfix sku_id" data-entity-name="sku_id">
                        <div class="entity-info col-xs-5">
                           <div>
                              Seller SKU ID
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Unique identifier for the listings" alt="Unique identifier for the listings"></i>
                           </div>
                        </div>
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="text" value="" name="sku_id" required placeholder="" class="form-control ">
                           </div>
                        </div>
                     </div>  
                  </div>
                  <div class="entity-form-group" data-group-no="1">
                     <div class="group-info clearfix"> <hr>
                        <div class="group-name col-xs-5">Status Details</div>
                           <br>
                     </div>
                     <div class="entity-container clearfix listing_status" data-entity-name="listing_status">
                        <div class="entity-info col-xs-5">
                           <div>
                              Listing Status
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Inactive listings are not available for buyers on fosso" alt="Inactive listings are not available for buyers on fosso"></i>
                           </div>
                        </div>
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <select name="status" class="form-control " value="">
                                 <option value="">Select One</option>
                                 <option value="1">Active</option>
                                 <option value="0">Inactive</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="entity-form-group" data-group-no="2">
                     <div class="group-info clearfix"><hr>
                        <div class="group-name col-xs-5">Price details</div>
                         <br>
                     </div>
                     <div class="entity-container clearfix mrp" data-entity-name="mrp">
                         <div class="entity-info col-xs-5">
                           <div>
                              Mrp
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Inactive listings are not available for buyers on fosso" alt="Inactive listings are not available for buyers on fosso"></i>
                           </div>
                        </div> 
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="number" value="" name="product_price" placeholder="" class="form-control ">
                              
                           </div>
                        </div>
                     </div>
                     <div class="entity-container clearfix fosso_selling_price" data-entity-name="fosso_selling_price">
                        <div class="entity-info col-xs-5">
                           <div>
                              Your selling price
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Inactive listings are not available for buyers on fosso" alt="Inactive listings are not available for buyers on fosso"></i>
                           </div>
                        </div>
                       
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="number" value="" name="product_offer" placeholder="" class="form-control ">
                              
                           </div>
                           
                        </div>
                     </div>
                  </div>
                  <div class="entity-form-group" data-group-no="3">
                     <div class="group-info clearfix"> <hr>
                        <div class="group-name col-xs-5">Inventory details</div> <br>
                     </div>
                     
                     <div class="entity-container clearfix stock_size" data-entity-name="stock_size">
                         
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="number" value="" name="stock" placeholder="" class="form-control ">
                           </div>
                        </div>
                     </div>
                  </div>
                 
                  <div class="entity-form-group" data-group-no="5">
                     <div class="group-info clearfix"> <hr>
                        <div class="group-name col-xs-5">Delivery charge to customer</div> <br>
                     </div>
                     <div class="entity-container clearfix local_shipping_fee_from_buyer" data-entity-name="local_shipping_fee_from_buyer">
                        <div class="entity-info col-xs-5">
                           <div>   
                              Local delivery charge
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Delivery charge you want charge a buyer in the same city for listings which are not fosso Assured" alt="Delivery charge you want charge a buyer in the same city for listings which are not fosso Assured"></i>
                           </div>
                        </div>
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="charge" value="" name="charge" placeholder="" class="form-control ">
                              
                           </div>
                        </div>
                     </div>
                     <div class="entity-container clearfix zonal_shipping_fee_from_buyer" data-entity-name="zonal_shipping_fee_from_buyer">
                        <div class="entity-info col-xs-5">
                           <div>
                              Zonal delivery charge
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Delivery charge you want charge a buyer outside your zone for listings which are not fosso Assured" alt="Delivery charge you want charge a buyer outside your zone for listings which are not fosso Assured"></i>
                           </div>
                        </div>
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="number" value="" name="zone" placeholder="" class="form-control ">
                              
                           </div>
                        </div>
                     </div>
                     <div class="entity-container clearfix national_shipping_fee_from_buyer" data-entity-name="national_shipping_fee_from_buyer">
                        <div class="entity-info col-xs-5">
                           <div>
                              National delivery charge
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Delivery charge you want charge a buyer outside your zone for listings which are not fosso Assured" alt="Delivery charge you want charge a buyer outside your zone for listings which are not fosso Assured"></i>
                           </div>
                        </div>
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                              <input type="number" value="" name="nationl" placeholder="" class="form-control ">
                           
                           </div>
                        </div>
                     </div>
                      
                  </div>
                  <div class="entity-form-group" data-group-no="6">
                     <div class="group-info clearfix">
                      <hr>
                        <div class="group-name col-xs-5">Package details</div>
                        <br>  
                     </div>
                     <div class="packages-container package-packages" data-package-name="packages">
                        <div class="package-container" data-package-id="packages-0">
                           <div class="entity-group entity-group-packages-0 " data-package-id="packages-0">
                              <div class="entity-container clearfix length" data-entity-name="length">
                                 <div class="entity-info col-xs-5">
                                    <div>
                                       Length
                                       <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Length of the package in cms" alt="Length of the package in cms"></i>
                                    </div>
                                 </div>
                                 <div class="entity-field col-xs-7">
                                    <div class="entity-field-values" data-value-index="0">
                                       <input type="number" value="" name="length1" placeholder="" class="form-control ">
                                       <span data-qualifier-for="length" class="single-qualifier">cms</span>
                                    </div>
                                 </div>
                              </div>
                              <div class="entity-container clearfix breadth" data-entity-name="breadth">
                                 <div class="entity-info col-xs-5">
                                    <div>
                                       Breadth
                                       <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Breadth of the package in cms" alt="Breadth of the package in cms"></i>
                                    </div>
                                 </div>
                                 <div class="entity-field col-xs-7">
                                    <div class="entity-field-values" data-value-index="0">
                                       <input type="number" value="" name="breadth1" placeholder="" class="form-control ">
                                       <span data-qualifier-for="breadth" class="single-qualifier">cms</span>
                                    </div>
                                 </div>
                              </div>   
                              <div class="entity-container clearfix height" data-entity-name="height">
                                 <div class="entity-info col-xs-5">
                                    <div>
                                       Height
                                       <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Height of the package in cms" alt="Height of the package in cms"></i>
                                    </div>
                                 </div>
                                 <div class="entity-field col-xs-7">
                                    <div class="entity-field-values" data-value-index="0">
                                       <input type="number" value="" name="height1" placeholder="" class="form-control ">
                                       <span data-qualifier-for="height" class="single-qualifier">cms</span>
                                    </div>
                                 </div>
                              </div>
                              <div class="entity-container clearfix weight" data-entity-name="weight">
                                 <div class="entity-info col-xs-5">
                                    <div>
                                       Weight
                                       <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="Weight of the final package in kgs" alt="Weight of the final package in kgs"></i>
                                    </div>
                                 </div> 
                                 <div class="entity-field col-xs-7">
                                    <div class="entity-field-values" data-value-index="0">
                                       <input type="number" value="" name="weight1" placeholder="" class="form-control ">
                                       <span data-qualifier-for="weight" class="single-qualifier">Kgs</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="entity-form-group" data-group-no="7">
                     <div class="group-info clearfix"> <hr>
                        <div class="group-name col-xs-5">Tax details</div> <br>
                     </div>
                    
                    
                     <div class="entity-container clearfix tax_code" data-entity-name="tax_code">
                        <div class="entity-info col-xs-5">
                           <div>
                              GST
                              <i class="create-product-help-icon" data-toggle="tooltip" data-placement="top" title="fosso’s tax code which decides the goods and services tax for the listing" alt="fosso’s tax code which decides the goods and services tax for the listing"></i>
                           </div>
                        </div>    
                        <div class="entity-field col-xs-7">
                           <div class="entity-field-values" data-value-index="0">
                                 <input type="number" value="" name="gst" placeholder="" class="form-control ">
                           </div>
                           
                        </div>
                     </div>
                  </div>
                  <button  type="submit" name="copy_product" class="btn btn-danger btn-xs" style="    width: 100%;
    margin-top: 16px;
    height: 40px;">Submit</button>
               </form>
            </div>
            
            
         </div>
      </div>
   </section>
</section>
                                	
                                	
                                	
                                	
                                </div>
                                </div> 
                               
                                 
                                 
                                 </div>
                            </div>
                        </div>
                    </div>
                     
                </div>
 </div>
 
<!-- ============================================================== -->
 
<!-- End Right sidebar -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
 <?php include "footer.php";?>
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/node_modules/popper/popper.min.js"></script>
<script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>
<!-- This is data table -->
<script src="assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="dist/js/dataTables.buttons.min.js"></script>
<script src="dist/js/buttons.flash.min.js"></script>
<script src="dist/js/jszip.min.js"></script>
<script src="dist/js/pdfmake.min.js"></script>
<script src="dist/js/vfs_fonts.js"></script>
<script src="dist/js/buttons.html5.min.js"></script>
<script src="dist/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->
<script>
$(function() {
$('#myTable').DataTable();
$(function() {
var table = $('#example').DataTable({
"columnDefs": [{
"visible": false,
"targets": 2
}],
"order": [
[2, 'asc']
],
"displayLength": 25,
"drawCallback": function(settings) {
var api = this.api();
var rows = api.rows({
page: 'current'
}).nodes();
var last = null;
api.column(2, {
page: 'current'
}).data().each(function(group, i) {
if (last !== group) {
$(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
last = group;
}
});
}
});
// Order by the grouping
$('#example tbody').on('click', 'tr.group', function() {
var currentOrder = table.order()[0];
if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
table.order([2, 'desc']).draw();
} else {
table.order([2, 'asc']).draw();
}
});
});
});
$('#example23').DataTable({
dom: 'Bfrtip',
buttons: [
'copy', 'csv', 'excel', 'pdf', 'print'
]
});
$('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
</script>
</body>
 
</html>