<?php
error_reporting(0);
session_start();
include_once"dbMysql.php";    include_once"config.php";
$con = new DB_con();
$OrderId = $_GET['Orderid'];
$data=$con->selectinvoicedetails($OrderId);
$today = date("d-M-Y");
foreach($data as $datakey => $datavalue)
 $order_id=$datavalue['order_id'];
  $query4= "SELECT * from order_details where order_id='$order_id' LIMIT 1";

	$run4 = mysqli_query($conn,$query4);
	while ($row4=mysqli_fetch_array($run4)) 
	$role=	$row4['role'];
		
   $query4x= "SELECT * from prescription_order where email='$role' LIMIT 1";

	$run4x = mysqli_query($conn,$query4x);
	foreach( $run4x as $key=>  $row4x)
	$rolexs=	$row4x['email'];	$name=	$row4x['name'];	$address=	$row4x['address'];	$phone=	$row4x['phone'];$city=	$row4x['city'];$pincode=	$row4x['pincode'];
		
  $select="SELECT * from tbl_tax order by tax_id desc LIMIT 1";
                  $run=mysqli_query($conn,$select);
                  foreach($run as $key=> $tax)
                     
                  $taxn=$tax['vat'];
                    $query4xl= "SELECT * from extraamountdeduct where order_id='$order_id' LIMIT 1";

	$run4xx = mysqli_query($conn,$query4xl);
	foreach($run4xx as $key=>  $row4tax)
	
 	
   $query4xlin= "SELECT * from contact_info   where id='1'";

	$run4xxin = mysqli_query($conn,$query4xlin);
	foreach($run4xxin as $key=>  $row4taxin)
?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>  invoice</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>

<body>




<!-- Page container -->
<div class="container">


    <!-- New invoice template -->
    <div class="panel panel-default">


        <div class="panel-body">

           	<div class="row invoice-header" style=" background-color: #303e4f;">
						<img src="../image/demo/logos/logo.png" style="    height: 100px;">  	
					</div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>

                        <tr><td> <div class="col-sm-6 col-xs-12">
                                    <h6>INVOICE NUMBER: <?php echo $datavalue['invoiceno'];?></h6>
                                </div>
                            </td>
                            <td>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>INVOICE DATE:<?php echo $today ;?></h6>
                                </div>
                            </td></tr>
                        <tr><td> <div class="col-sm-6 col-xs-12">
                                    <h6>SELLER</h6>
                                </div>
                            </td>
                            <td>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>BUYER</h6>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> <div class="col-sm-6 col-xs-12">
                                    	 <?php echo $row4taxin['invoice'];?>
                                </div>
                            </td>

                            <td> <div class="col-sm-6 col-xs-12">
                                 
                                    
                                    <?php echo $name ;  ?><br>
								<?php echo $address; ?>,<br>
								<?php echo $pincode; ?>,<br>
								<?php echo $city; ?>,<br>
								<?php echo $datavalue['company']; ?><br>
								Mobile No : <?php echo $phone;?> <br>
								Email :  <?php echo $rolexs;?> <br>
                                   

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> DISPATCHED VIA  </td>
                            <td> DISPATCH DOC. NO. (AWB)</td>
                        </tr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="50px">S.No</th>
                                    <th>Description</th>
                                    <th width="155px">Rate</th>
                                    <!--   <th>TAX(<?php
                                    include_once"dbMysql.php";
                                    $con = new DB_con();
                                    $table = "tbl_tax";
                                    $state = $datavalue['state'];
                                    $Country = $datavalue['country'];
                                    $query =mysql_query ("SELECT * FROM $table WHERE state =$state AND country = $Country");
                                    if(mysql_num_rows($query)){
                                        $rows = mysql_fetch_assoc($query);
                                        //print_r($rows);
                                    }
                                    if(isset($Country) == 101 && isset($state) == 10 ){
                                        echo'CST';
                                    }else{
                                        echo'VAT';
                                    }
                                    ?>)-->

                                    </th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sr = 0;
                                foreach($data as $datakey => $datavalue){
                                    //print_r($datavalue);
                                    $sr++;
                                    echo'<tr>
                            <td>'.$sr.'</td>
				                <td>'.$datavalue['product_name'].'<br>
                                 ITEM CODE : '.$datavalue['sku'].'
                                 <br> ORDER NO: '.$datavalue['order_id'].'<br>
                                 </td>
				                <td><i class="fa fa-inr"></i>'.$datavalue['unit_cost'].'</td>

                                <td> '.$datavalue['quantity'].'</td>
                                  <td><strong><i class="fa fa-inr"></i>'.$datavalue['amount'].'</strong></td>
						</tr>';}
                                ?>

                                </tbody>

                            </table><?php include "total.php";?>
                              <div class="col-sm-12 col-xs-12">
							
						<table class="pull-right">
								<tbody>
								<tr>
									<th width="200px" class="pull-right " >Sub Total: </th>
									<td width="" class="text-right  text-danger"><h6 class="pull-right"> <i class="fa fa-inr"></i> <?php echo $datavalue['subtotal'];?></h6></td>
								</tr>
								
								<tr>
									<th width="200px" class="pull-right " >Tax  <?php echo $taxn;?> %:  </th>
									<td width="" class="text-right  text-danger"><h6 class="pull-right"> <i class="fa fa-inr"></i> <?php
									 $number='100'; 
  $discounttoltalx =$datavalue['subtotal']*$taxn/$number;
									
									
									
									 echo round($discounttoltalx);?></h6></td>
								</tr>
								 
								 <tr>
									<th width="200px" class="pull-right " >Coupon Discount  <?php echo $row4tax['coupencode'];?> % : </th>
									<td width="" class="text-right  text-danger"><h6 class="pull-right"> <i class="fa fa-inr"></i> -
									<?php
									
								 	$gf=$discounttoltalx+$datavalue['subtotal'];
									 $number='100'; 
  $discof =$gf*$row4tax['coupencode']/$number;
									
									
									
									 echo $ff= round($discof);?></h6></td>
								</tr>
								<tr>

										<th width="200px" class="pull-right " >Delivery Charge: </th>
										<td width="" class="text-right  text-danger"><h6 class="pull-right"> <i class="fa fa-inr"></i> + <?php echo  $row4tax['delivery_charge'];?></h6></td>
									</tr>
									<tr>

										<th width="200px" class="pull-right " >Wallet Amount: </th>
										<td width="" class="text-right  text-danger"><h6 class="pull-right"> <i class="fa fa-inr"></i> - <?php echo  $row4tax['walletamount'];?></h6></td>
									</tr>
								
									<tr>

										<th width="200px" class="pull-right " >G.Total: </th>
										<td width="" class="text-right  text-danger"><h6 class="pull-right"> <i class="fa fa-inr"></i> <?php echo  $datavalue['total_amount'];?></h6></td>
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




        <div class="panel-body">
            <div class="row invoice-payment">
                <div class="col-sm-12 col-xs-12">
                    <?php
                    $number = $datavalue['subtotal'];
                    $ones = array(
                        "",
                        " One",
                        " Two",
                        " Three",
                        " Four",
                        " Five",
                        " Six",
                        " Seven",
                        " Eight",
                        " Nine",
                        " Ten",
                        " Eleven",
                        " Twelve",
                        " Thirteen",
                        " Fourteen",
                        " Fifteen",
                        " Sixteen",
                        " Seventeen",
                        " Eighteen",
                        " Nineteen"
                    );

                    $tens = array(
                        "",
                        "",
                        " twenty",
                        " thirty",
                        " forty",
                        " fifty",
                        " sixty",
                        " seventy",
                        " eighty",
                        " ninety"
                    );

                    $triplets = array(
                        "",
                        " thousand",
                        " million",
                        " billion",
                        " trillion",
                        " quadrillion",
                        " quintillion",
                        " sextillion",
                        " septillion",
                        " octillion",
                        " nonillion"
                    );

                    // recursive fn, converts three digits per pass
                    function convertTri($num, $tri) {
                        global $ones, $tens, $triplets;

                        // chunk the number, ...rxyy
                        $r = (int) ($num / 1000);
                        $x = ($num / 100) % 10;
                        $y = $num % 100;

                        // init the output string
                        $str = "";

                        // do hundreds
                        if ($x > 0)
                            $str = $ones[$x] . " hundred";

                        // do ones and tens
                        if ($y < 20)
                            $str .= $ones[$y];
                        else
                            $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];

                        // add triplet modifier only if there
                        // is some output to be modified...
                        if ($str != "")
                            $str .= $triplets[$tri];

                        // continue recursing?
                        if ($r > 0)
                            return convertTri($r, $tri+1).$str;
                        else
                            return $str;
                    }

                    // returns the number as an anglicized string
                    function convertNum($num) {
                        $num = (int) $num;    // make sure it's an integer

                        if ($num < 0)
                            return "negative".convertTri(-$num, 0);

                        if ($num == 0)
                            return "zero";

                        return convertTri($num, 0);
                    }

                    // Returns an integer in -10^9 .. 10^9
                    // with log distribution
                    function makeLogRand() {
                        $sign = mt_rand(0,1)*2 - 1;
                        $val = randThousand() * 1000000
                            + randThousand() * 1000
                            + randThousand();
                        $scale = mt_rand(-9,0);

                        return $sign * (int) ($val * pow(10.0, $scale));
                    }
                    ?>
                    <h6>Amount in words : Indian Rupees <?php  echo convertNum($number);?> Only </h6>

                    <h6> DECLARATION</h6>
                    <p> We declare that this invoice shows actual price of the goods and that all particulars are true and correct. </p>
                    <h6>CUSTOMER ACKNOWLEDGEMENT-</h6>
                    <p> I <?php echo $datavalue['fname'] . '&nbsp;'. $datavalue['mname'] .'&nbsp;'. $datavalue['lname']  ?> hereby confirm that the above said product/s are being purchased for my internal / personal consumption and not for re-sale</p>
                </div>




            </div>







        </div>
        <!-- /new invoice template -->
    </div>
    <!-- /page container -->

</body>

</html>