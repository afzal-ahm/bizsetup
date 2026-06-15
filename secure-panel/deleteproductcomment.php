
<?php
include_once"dbMysql.php";

$con = new DB_con();
$table = "product_comment";
$sku = $_GET['sku'];
$delete_product=$con->delete1($table,$sku);
if($delete_product)
{
?>
<script>
alert("  Successfully Deleted");
window.location ='viewreview.php'
</script>
<?php
}
?>