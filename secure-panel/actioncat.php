<?php
include('config.php');
if(isset($_GET['status']))
{
   $status1=$_GET['status'];
  $select="select * from category where category_id='$status1'";
$select1=mysqli_query($conn,$select);
while($row=mysqli_fetch_object($select1))
{
$status_var=$row->design;
if($status_var=='0')
{
$status_state=1;
}
else
{
$status_state=0;
}
   $update=mysqli_query($conn,"update category set design='$status_state' where category_id='$status1' ");
if($update)
{
header("Location: viewcategories.php");
}
else
{
echo mysqli_error();
}
}
?>
<?php
}
?>