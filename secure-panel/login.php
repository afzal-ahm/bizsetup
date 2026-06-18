<?php
session_start();
include'config.php';
if(isset($_POST['login']))
{
	$email = mysqli_real_escape_string($conn,$_POST['email']);
	$password = mysqli_real_escape_string($conn,$_POST['password']);
	
	$query = "select * from admin_account where admin_account_email ='$email' AND admin_account_password ='$password'";
	$run = mysqli_query($conn,"$query");
	if(mysqli_num_rows($run)>0)
	{
		$_SESSION['email'] = $email;
		header("Location: index.php?view=" . urlencode($email));
		exit;
		}
else    
          {
		
		echo "<script>alert('Email or password is incorrect')</script>";
		
		}

	}

?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">

<link rel="shortcut icon" href="img/ico/favicon.png">
    <title>Admin</title>
    
    
   <link rel="stylesheet" href="css/style_login.css">

  </head>

  <body>

    <div class="wrapper">
	<div class="container">
		<h1>Welcome</h1>
		
		<form class="form" action="login.php" method="post" enctype="multipart/form-data" name="myForm" id="form">
			<input type="email" placeholder="Email-Id" name="email" required>
			<input type="password" placeholder="Password" name="password" required>
			<button type="submit" id="" name="login">Log in </button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>
