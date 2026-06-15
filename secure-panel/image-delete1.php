<?php 
include"config.php";

$id=$_GET['id'];
$sku=$_GET['sku'];  
 
   $in="DELETE FROM `image_manager` WHERE id='".$id."'";
 $run=mysqli_query($conn,$in);
 if($run)
 {  
 
	 	 echo "<script type=\"text/javascript\">".
        "alert('Image Added successfully');".
      "</script>";
	 echo'<script>location.assign("product-profile.php?sku='.$sku.'")</script>'; 
		
  }      
?>

 