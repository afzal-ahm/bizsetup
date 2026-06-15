<?php 

include_once '../include/config.php';

	$delete_id = $_GET['del'];
	
	$query = "delete from  top_heading where id ='".$delete_id."'";
	
	$me=mysqli_query($conn,$query);


header("Location: headlineshow.php");
?>