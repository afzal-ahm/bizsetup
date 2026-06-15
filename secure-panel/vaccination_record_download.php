<?php
error_reporting(0);
session_start();

$today = date("d-M-Y");


include_once'dbMysql.php';
$con = new DB_con();
  $cus_id = $_GET['id'];
$table="registration";
$field = array('id','name','email','password','pet_name','breed','mobile','address','dsex','datebirth','color','chip','reg_no','breeder','vaccination','date');
$field_value = array($cus_id);
$res=$con->selectcatprod($table,$field_value,$field);
//print_r($res);die;
foreach($res as $key => $cus_details)



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
                    <div class="col-md-9"> <h1 style="padding-left: 10px;">VACCINATION RECORD</h1> </div>  	
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
							<h6>OWNER INFORMATION</h6>
						</div>
                        </td>
                         <td>
						<div class="col-sm-6 col-xs-12">
							<h6>DOG INFORMATION</h6>
						</div>
                        </td>
                        </tr>
                         <tr><td> <div class="col-sm-12 col-xs-12">
							Name <span style="padding-left: 20px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['name']);?></b></span><br>
                            Email <span style="padding-left: 22px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['email']);?></b></span><br>
                            Phone <span style="padding-left: 16px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['mobile']);?></b></span><br>
                            Address <span style="padding-left: 7px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['address']);?></b></span> <br>
                               
                              
						</div>
                        </td>
                        <td>  <div class="col-sm-12 col-xs-12">
					Dog Name <span style="padding-left: 20px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['pet_name']);?></b></span><br>
                    Dog Breed <span style="padding-left: 22px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['breed']);?></b></span><br>
                    Dog Sex <span style="padding-left: 36px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['dsex']);?></b></span><br>
                    Dog Color <span style="padding-left: 26px;"><b>:</b></span><span style="padding-left: 20px;"><b><?php echo ucfirst($cus_details['color']);?></b></span> <br>
                               
                              
						</div>
                        </td>
                       </tr>
                       
                       
                       <div class="table-responsive">
                       
				    <table class="table table-striped table-bordered">
				    <h6 style="text-align: center; color: #000;"><b>VACCINATION RECORDS DHL PP / FELINE DISTEMPER CCV & RABIES</b></h6>
				       <br> <thead>
				            <tr>
                            	<th width="50px">S.No</th>
				                <th>Date</th>
				               	<th width="200px">Vaccine Used/Batch No</th>
                                <th>Next Due On</th>
                                <th>Sign. and Stamp Of Veterinarian</th>
				             
				            </tr>
				        </thead>
				        <tbody>
				        <?php
				        $table="vaccination";
$field = array('user_id','email','batch_image','v_date','signature','next_date');
$field_value = array($cus_id);
$res1=$con->selectcatprod($table,$field_value,$field);
//print_r($res);die;
$i=1;
foreach($res1 as $key => $cus_details1){
	


				        ?>
				            <tr>
                            <td><?php echo $i++;?></td>
				                <td><?php echo ucfirst($cus_details1['v_date']);?></td>
				                <td><img src="../vacination/vaction/<?php echo $cus_details1['batch_image'];?>"height="50px"></td>
				                <td><strong><?php echo ucfirst($cus_details1['v_date']);?></strong></td>
                                <td><img src="../vacination/vaction/<?php echo $cus_details1['signature'];?>"height="50px"></td>
                                 
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