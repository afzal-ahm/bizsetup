

<?php
include "../include/config.php";
?><!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title>GoDogee</title>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">



</head>

<body>

	


	<!-- Page container -->
 	<div class="container">


		<!-- New invoice template -->
	        <div class="panel panel-default">
		        

				<div class="panel-body">

					<div class="row invoice-header">
						
                     <h1>PRODUCT RECORD</h1>   	
					</div>


					<div class="row">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                    <thead>
                      
                         
                          
                        
                       <tr>
                    <?php    $today = date("d-M-Y"); ?>
                             <td><?php echo  $today;?></td>
                              <td> All product records(in stock)</td>
                       </tr>
                       <div class="table-responsive">
				    <table class="table table-striped table-bordered">
				        <thead>
				            <tr>
                            	<th width="50px">S.No</th>
				                <th>SKU</th>
				               	<th >Name</th>
				               	 	<th>Image</th>
				               	 	<th>Sub Category</th>
                                <th>Brand</th>
                               
				                <th>MRP</th>
				                 <th>Offer %</th>
				                  <th>Offer(Rs.)</th>
				                   <th>Quantity</th>
				                    <th>Quantity (update)</th>
				            </tr>
				        </thead>
				        <tbody>
				        <?php
				        $i='1';
				        $user_query = "SELECT * FROM product where quantity !='0' ORDER BY id desc ";
$run = mysqli_query($conn,$user_query);
foreach($run as $key=>$product){
	

?>
				            <tr>
                            <td><?php echo $i++;?></td>
				               <td><?php echo $product['sku'];?></td>
				               
				                <td><?php echo $product['product_name'];?></td>
				                <td><img src="../images/product/<?php echo $product['image'];?>" width="50px"></td>
				               <td><?php echo $product['sub_category'];?></td>
				               <td><?php echo $product['brand_name'];?></td>
				              
				               <td><?php echo $product['mrp'];?></td>
				                <td><strong>Rs.<?php echo $product['unit_price'];?></strong></td>
                                <td><?php echo $product['discount'];?></td>
                                 <td><?php echo $product['total_quantity'];?></td>
                                  <td><?php echo $product['quantity'];?></td>
				            </tr>
                             <?php } ?>
				        </tbody>
                        
				    </table>
                    <div class="col-sm-12 col-xs-12">
							
							<table class="pull-right">
								<tbody>
									
									
								</tbody>
							</table>
							
						</div>
				</div>
                         </thead>
                         </table>
                    </div>
						
					</div>

				</div>


				

			  
			<!-- /new invoice template -->
	</div>
	<!-- /page container -->

</body>

</html>