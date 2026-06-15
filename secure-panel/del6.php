<?php 

include_once 'config.php';

	$delete_id = $_GET['del'];
	
	$query = "delete from testimonial where id ='".$delete_id."'";
	
	$me=mysqli_query($conn,$query);


header("Location: showtestimonial.php");
?>