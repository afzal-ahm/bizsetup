<?php

include_once 'dbMysql.php';
$con = new DB_con();
if(isset($_POST['id'])) {
    $table = "productattribute";
    $id = $_POST['id'];
    $status =$_POST['status'];

    $sql = "UPDATE ".$table." SET status = '".$status."' where id = '".$id."' ";

    $res  = mysql_query($sql);

}

?>
