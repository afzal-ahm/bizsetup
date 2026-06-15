<?php
include('config.php');
if(isset($_GET['status']))
{
   $status1=$_GET['status'];
  $select="select * from registration where id='$status1'";
$select1=mysqli_query($conn,$select);
while($row=mysqli_fetch_object($select1))
{
$status_var=$row->status;
if($status_var=='0')
{
$status_state=1;
}
else
{
$status_state=0;
}
   $update=mysqli_query($conn,"update registration set status='$status_state' where id='$status1' ");
if($update)
{
header("Location: vaccination_registration.php");
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