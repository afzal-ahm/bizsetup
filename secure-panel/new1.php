 <?php
 session_start();
			include "secure-panel/config.php";
?>
<?php
    
  
     if($_SESSION['size']!="")
     {
	 	 
//	echo"<script>window.location.href='product-detail.php?category=$_GET['category']&sub=$_GET['subcategory']&sub_sub=$_GET['subsubcategory']&sku=$_GET['sku']'</script>";
}
else{
	 echo '<p style="color:red">Select Size *</p>';
}
?>
 