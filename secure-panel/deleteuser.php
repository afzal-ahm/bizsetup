<?php
error_reporting(0);
include_once"dbMysql.php";
$con = new DB_con();
$table = "customer_deatails";
$cusid = $_GET['cusid'];
$field = array('id');
$field_value = array($cusid);
$delete_product=$con->delete_user($table,$field,$field_value);
if($delete_product)
{
    ?>
    <script>
        alert("User Successfully Deleted");
        window.location ='showuser.php'
    </script>
    <?php
}
?>