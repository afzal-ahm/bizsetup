<?php
 session_start();
 error_reporting(0);
			include_once"secure-panel/config.php";
?>
 <?php

//include('include/config.php');
//session_start();
if(isset($_POST['cregister'])){
   	$name=$_POST['name'];

   	$date=date('Y-m-d');
   $email=$_POST['email'];
	$mobile=$_POST['mobile'];$last=$_POST['last'];
	 $password=$_POST['password'];
	 	 $password1=$_POST['password1'];
    $point='200';
	 //$breed=$_POST['breed'];


	 if($password==$password1){
	  $sql="select Count(*) from registration where email='$email'";
$result=mysqli_query($conn,$sql);
$ml=mysqli_fetch_array($result);
   $ml= $ml[0];
 if($ml==0){

   $query = "INSERT into registration (name,email,mobile,password,address,city,pincode,date,last) VALUES('$name','$email','$mobile','$password','','','','$date','$last')";
	  $run = mysqli_query($conn,$query);

	  if ($run){
		$_SESSION['email']=$email;







  $message = '
 Dear '.$name.',

Thank you for your Registration with Rajan Admin

Your login details are :

Email :  '.$email.'
Password :  '.$password.'

Thank You
Rajan Admin

';
$from="From: teatrading.com<teatrading@gmail.com>\r\nReturn-path: teatrading@gmail.com";
        $subject="Battery";
        mail($email, $subject, $message, $from);

         $message1 = '
New Registraion on website (teatrading.com). Please see admin panel for more details.

';

        $subject1="Registration Enquiry alert";
        mail("teatrading@gmail.com", $subject1, $message1, $from);

      //  manish.kumar@starwebmaker.com"
 echo "<script type=\"text/javascript\">".
        "alert('Registration Successfully');".
        "</script>";

 echo'<script>location.assign("checkout.php")</script>';
	}
}
 else{
 	echo "<script type=\"text/javascript\">".
        "alert('Provided Email is already in use');".
        "</script>";
 }
 }
 else{
 	echo "<script type=\"text/javascript\">".
        "alert('Password does not match');".
        "</script>";
 }



}

?>
   <?php
//session_start();
//include'include/config.php';
if(isset($_POST['clogin']))
{
	 $email = $_POST['email'];
	 $password =$_POST['password'];

	$query = "select * from registration where email ='$email' AND password ='$password'";
	$run = mysqli_query($conn,$query);
	if(mysqli_num_rows($run)>0)
	{
	 $_SESSION['email'] = $email;

echo "<script>alert('login Successfully')</script>";

 echo"<script>location.assign('checkout.php?email=$email')</script>";

		}
else
          {

		echo "<script>alert('Email or password is incorrect')</script>";

		}

	}

?><!DOCTYPE html>
<html lang="en">

<!-- shopping_cart.html  52  -->
<head>
<!-- Basic page needs -->
<meta charset="utf-8">
<!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<?php include "secure-panel/config.php";
session_start();
//error_reporting(0);
include "datainfo.php";?><title>Rajan Admin </title>
<meta name="description" content="">
<meta name="keywords" content=""/>

<!-- Mobile specific metas  -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicon  -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.png">

<!-- Google Fonts -->
<link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<!-- CSS Style -->
<link rel="stylesheet" href="style.css">

<script>
function showUserfilterlogin(str) {
//alert(str);
//	alert(str);
	 
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
      //  xmlhttp.open("GET","propertyajax.php?like="+str,true);
          xmlhttp.open("GET","login_acess.php?p2=" +str,true);
        xmlhttp.send();
    }
}
</script>
</head>

<body class="shopping_cart_page">
<!--[if lt IE 8]>
      
  <![endif]--> 
  
<?php include"header.php";?>
  <!-- end nav -->  
  
  <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main container">
      <div class="col-main">
        <div class="cart">
          
          <div class="page-content page-order"><div class="page-title">
            <h2>Paymnet Process</h2>
          </div>
            
            
            <div class="order-detail-content">
               <div id="content" class="col-sm-12">
			 
		  <div class="so-onepagecheckout ">
			  <div class="col-left col-sm-4"></div>
				<div class="col-left col-sm-4">
				  <div class="panel panel-default" style="margin-top: 10px;">
					<div class="panel-heading">
					  <h4 class="panel-title"><i class="fa fa-sign-in"></i> Paymnet Process</h4>
					</div>
					  <div class="panel-body">
								<form method="post" enctype="" action="">
					  <div class="panel-body">
							<div class="radio">
							  <label>
								<input  type="radio" value="cashondelivery" required name="paymentmethod">
								Cash on delivery</label>
							</div>
							<div class="radio">
							  <label>
								<input  type="radio" checked="checked" value="onlinepayment" required name="paymentmethod">
								Online Payment</label>
							</div>
							 
					  </div>
					  <div class="col-md-12">
	
							<div class="buttons">
							  <div class="pull-right">
								<input type="submit" class="btn btn-primary" name="cheakout" id="button-confirm" value="Continue">
							  </div>
							</div>
</div></form>
<?php
                    if(isset($_POST['cheakout'])){
$email=$_SESSION['email'];
						$paymentmethod=$_POST['paymentmethod'];




						$num0 = (rand(10, 100));
 						$num1 = date("dmY");
 						$currentId = $num1 . $num0;
 						$Orderid = 'teatrending' . $currentId;

 						  $Orderdate = date('Y-m-d');

 						  $unique_id = session_id();
 						     $query_customer="SELECT * from customer_detail where email='$email'  ";
							 $customer_run= mysqli_query($conn,$query_customer);

foreach($customer_run as $key=>$cust1)
{
	

							  $customer_user_id=$cust1['customer_user_id'];
							   $mobile_no=$cust1['mobile_no'];

}

 			
//
						if($paymentmethod=="onlinepayment"){
							
						  $num0 = (rand(10, 100));
 						$num1 = date("dmY");
 						$currentId = $num1 . $num0;
 						$Orderid = 'teatrending' . $currentId;

 						  $Orderdate = date('Y-m-d');

 							$item_total='';
   $queryc="SELECT DISTINCT product_id, session_id, size,color,price from cart  where session_id='".session_id()."'";

	$runc = mysqli_query($conn,$queryc);

		while ($rowc=mysqli_fetch_array($runc))

   {
    $id=$rowc['product_id'];
  $sid=$rowc['session_id'];$color=$rowc['color'];$size=$rowc['size'];$price=$rowc['price'];
   $sqlv="select Count(*) AS product_id from cart where product_id='$id' AND session_id='$sid' AND  color='$color' AND  size='$size' AND  price='$price'";
 $resultv=mysqli_query($conn,$sqlv);
 $mlv=mysqli_fetch_array($resultv); 
 $couz= $mlv[0];
   $query1v= "SELECT * from product where id=$id";
 $run1v = mysqli_query($conn,$query1v);
 while ($row1v=mysqli_fetch_array($run1v)){ 
									 
			$p_image="SELECT * from image_manager where p_sku='".$row1v['sku']."' order by id ASC LIMIT 0,1";
	$result1=mysqli_query($conn,$p_image);
$ml=mysqli_fetch_array($result1);
												 
					$subto=$couz*	$rowc['price'];	

			$sqlx="select Count(*) AS coupen_code from use_code where   session_id ='".session_id()."'";
 $resultx=mysqli_query($conn,$sqlx);
									 $mlx=mysqli_fetch_array($resultx); 
									  $coux= $mlx[0];
									  if($coux>0)
									  {
									  	$select="SELECT * from use_code where     session_id ='".session_id()."'";
									  	$vv=mysqli_query($conn,$select);
									  	foreach($vv as $key=> $code)
									  	$coupen_code=$code['coupen_code'];
									  	
									  	$selectx="SELECT * from tbl_promo where     promo_code ='".$coupen_code."'";
									  	$vvx=mysqli_query($conn,$selectx);
									  	foreach($vvx as $key=> $codex)
									  $discount=	$codex['discount'];
									  $ss=$subto;
							$number='100';		  
		 	$discounttoltal =$ss*$discount/$number;
$offer_amount=$ss-$discounttoltal;
					 $_SESSION['total']=$offer_amount;	 $subto=$offer_amount;				  
				}
				else{
					 $_SESSION['total']=$subto;
				}
				
					$select="SELECT * from tbl_tax order by tax_id desc LIMIT 1";
                  $run=mysqli_query($conn,$select);
                  foreach($run as $key=> $tax)
                  $number='100'; ='30';
                  $taxn=$tax['vat'];
		 	$discounttoltal =$subto*$taxn/$number;
		 	$select="SELECT * from delivery order by id desc LIMIT 1";
                  $rund=mysqli_query($conn,$selectd);
                  foreach($rund as $key=> $delivery)
 $number1=$delivery['delivery'];
		 	
$offer=$subto+$discounttoltal+$number1;
				
				
				
				
			$_SESSION['total']=$offer;
 echo '<script>window.location.assign("pay.php?order_id='.$Orderid.'&extra='.$subto.'&city='.$_GET['city'].'")</script>'; 
						}
	}

}}

 
                    ?>
							 
					  </div>
				  </div>
				
				  
				</div>
				 
			  </div>
			</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
   <!-- service section -->
  <?php include "footer.php";?>
  <a href="#" class="totop"><i class="fa fa-arrow-up"></i></a>  </div>

<!-- End Footer --> 
<!-- JS --> 

<!-- jquery js --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 

<!-- bootstrap js --> 
<script type="text/javascript" src="js/bootstrap.min.js"></script> 

<!-- owl.carousel.min js --> 
<script type="text/javascript" src="js/owl.carousel.min.js"></script> 

<!-- bxslider js --> 
<script type="text/javascript" src="js/jquery.bxslider.js"></script> 

<!--jquery-slider js --> 
<script type="text/javascript" src="js/slider.js"></script> 

<!-- megamenu js --> 
<script type="text/javascript" src="js/megamenu.js"></script> 
<script type="text/javascript">
        /* <![CDATA[ */   
        var mega_menu = '0';
        
        /* ]]> */
        </script> 

<!-- jquery.mobile-menu js --> 
<script type="text/javascript" src="js/mobile-menu.js"></script> 

 

<!--jquery-ui.min js --> 
<script type="text/javascript" src="js/jquery-ui.js"></script> 

<!-- main js --> 
<script type="text/javascript" src="js/main.js"></script> 

 
</body>

<!-- shopping_cart.html  52  -->
</html>