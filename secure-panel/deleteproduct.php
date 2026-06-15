
 

<?php 

include_once 'config.php';

$sku = $_GET['sku'];
	
	$query = "delete from product where id ='".$sku."'";
	
	$me=mysqli_query($conn,$query);

   echo'<script>location.assign("inventory.php")</script>'; 
?>