<?php
error_reporting(0);
session_start();
include_once'config.php';
//print_r($_POST);
 
if(isset($_POST['categoryId'])){
$table="subcategory";
$subcat = $_POST['categoryId'];
	 
//print_r($res);

?>
<?php 
session_start();
echo "<option>Select Category</option>";
   $g="SELECT * from  subcategory where category_id='".$subcat."' ";
                             $gf=mysqli_query($conn,$g);
							 foreach($gf as $key)
									  
								  // echo $key;
										echo'<option value="'.$key['subcategory_id'].'">'.$key['subcategory_name'].'</option>';
									
}

if(isset($_POST['sub_subcategory'])){
$table="sub_subcategory";
$subcat = $_POST['sub_subcategory'];

//print_r($res);
?>
<?php 

echo "<option>Select Sub category</option>";
  $g="SELECT * from  sub_subcategory where subcategory_id='".$subcat."' ";
                             $gf=mysqli_query($conn,$g);
							 foreach($gf as $key)

										echo'<option value="'.$key['sub_subcategory_id'].'">'.$key['sub_subcategory_name'].'</option>';
									
}

 


?>