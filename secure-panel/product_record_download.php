<?php
error_reporting(0);
session_start();

$today = date("d-M-Y");





?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title>Record</title>

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
					<div class="col-md-3"><img src="../images/logo.png"  height="80px;"></div>	
                    <div class="col-md-9"> <h1 style="padding-left: 10px;">PRODUCT RECORDS</h1> </div>  	
					</div>


					<div class="row">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                    <thead>
                      
                         <tr><td> <div class="col-sm-6 col-xs-12">
							<h6> DATE: <?php echo $today;?></h6>
						</div>
                        </td>
                        <td>
						<div class="col-sm-6 col-xs-12">
							
						</div>
                        </td></tr>
                          <tr><td> <div class="col-sm-6 col-xs-12">
							<h6></h6>
						</div>
                        </td>
                         <td>
						<div class="col-sm-6 col-xs-12">
							<h6></h6>
						</div>
                        </td>
                        </tr>
                         
                       
                       
                       <div class="table-responsive">
                       
				    <table class="table table-striped table-bordered">
				    <h6 style="text-align: center; color: #000;"><b>PRODUCT RECORD </b></h6>
				       <br> <thead>
				            <tr>
                            	<th >S.No</th>
				                <th>Product code</th>
				               	<th>Name</th>
				               	<th>Brand</th>
                                <th>offer</th>
                               
                                <th>Mrp</th>
				             
				            </tr>
				        </thead>
				        <tbody>
				        <?php
				     //   $table="product";
//$field = array('sku','product_name','brand_name','unit_price','discount','mrp');
//$field_value = array($cus_id);
//$res1=$con->selectcatprod($table,$field_value,$field);
include "../include/config.php";
$i=1;
$query="SELECT * from product";
$run=mysqli_query($conn,$query);
//print_r($res);die;

foreach($run as $key => $cus_details1){
	


				        ?>
				            <tr>
                            <td><?php echo $i++;?></td>
				                <td><?php echo $cus_details1['sku'];?></td>
				                <td style="font-size: 12px;">  <?php echo substr($cus_details1['product_name'] ,0,37);?>...</td>
				                <td><strong><?php echo ucfirst($cus_details1['brand_name']);?></strong></td>
                                <td>% <?php echo ucfirst($cus_details1['unit_price']);?></td>
                              
                                <td><?php echo ucfirst($cus_details1['mrp']);?></td>
                                 
				            </tr>
				            <?php } ?>
                             
				        </tbody>
                        
				    </table>
                    <div class="col-sm-12 col-xs-12">
							
							<table class="pull-right">
								<tbody>
									
									<tr>
										</tr>
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