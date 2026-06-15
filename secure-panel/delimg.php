<?php 

include_once 'config.php';

	$delete_id = $_GET['id'];
	
	$query = "delete from product_color where id ='".$delete_id."'";
	
	$me=mysqli_query($conn,$query);


header("Location: inventory.php");
?>