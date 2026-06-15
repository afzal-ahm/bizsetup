<?php
error_reporting(0);
include_once'dbMysql.php';
include_once 'config.php';
  
//print_r($res);

$table="category";
$con = new DB_con();
$res=$con->select($table);
?>
<?php
include_once 'dbMysql.php';
$con = new DB_con();
//data insert here
 

$keyword = $_GET['keyword'];
  

 $category_name = $_GET['category_name'];$category_nameid = $_GET['category_name'];
 $category_name1=$category_name;
   $query2="SELECT * from category where category_id='$category_name1'";
 $runx=mysqli_query($conn,$query2);
 foreach($runx as $key =>$subname1)
  $category_name=$subname1['category_name'];
  $category_url=$subname1['url'];
 
 
   

$date=date('d-M-Y'); 
 $v="INSERT INTO `keyword`(  `keyword`, `date`, `category_id`, `category_name`) VALUES ('$keyword','$date','$category_nameid','$category_name' )";
 	
  	 
 	 $runc=mysqli_query($conn,$v);
  	 
	?>
	
	<?php
	$s="SELECT * from keyword order by id DESC LIMIT 15";
	$run=mysqli_query($conn,$s);
	foreach($run as $key=> $keyw)
	{
	echo '<p>'.$keyw['keyword'].' -  '.$keyw['category_name'].'</p>';
	}
	
	 ?>