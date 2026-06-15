<?php 
include "config.php";
	$r="DELETE FROM product";
	$ru=mysqli_query($conn,$r);
	 if($ru)
	 {
	 		 echo "<script type=\"text/javascript\">".
        "alert(' Deleted successfully');".
         "</script>";
         
         	echo'<script>location.assign("inventory.php")</script>';
	 }
?>