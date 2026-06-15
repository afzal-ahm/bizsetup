<?php
error_reporting(0);
include_once'dbMysql.php';
include_once 'config.php'; include "userinfo.php";

 ?><!DOCTYPE html>
<html lang="en">
 
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Fosso</title>
        <link rel="stylesheet" type="text/css" href="assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
        <!-- Custom CSS -->
        <link href="dist/css/style.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="horizontal-nav skin-megna fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
          <?php include "header.php";?>                       <!-- ============================================================== -->
                                                
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Other saller</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Other saller</li>
            </ol>
            <a href="add-product.php"><button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>Other saller</button></a>
        </div>
    </div>
</div>
<!-- ============================================================== --> 

<style>
    .RZbAt {
    cursor: pointer;
    min-width: 90px;
    white-space: nowrap;
    color: rgb(255, 255, 255);
    background-color: rgb(71, 160, 251);
    height: 40px;
    padding-left: 15px;
    padding-right: 16px;
    text-transform: uppercase;
    border-radius: 2px;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(71, 160, 251);
    border-image: initial;
}


.loglGA {
    text-align: center;
    font-family: "Riona Sans Light", sans-serif;
    background-color: transparent;
    display: inline-block;
    width: 51%;
}.loglGA .product-search-input {
    width: 325px;
}.izvvGf {
    width: 100%;
    box-sizing: border-box;
    color: rgb(119, 119, 119);
    background-color: rgb(255, 255, 255);
    height: 40px;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(223, 223, 223);
    border-image: initial;
    padding: 0px 13px 2px;
    border-radius: 3px;
}.loglGA .addlistings-search-btn {
    top: 1px;
    width: 140px;
    height: 40px;
    position: relative;
    vertical-align: middle;
    margin: 0px 0px 0px -4px;
    border-radius: 0px 2px 2px 0px;
}

.vertical-card-footer {
    text-align: right;
    position: absolute;
    width: 100%;
    bottom: 0px;
    padding-top: 10px;
    font-size: 12px;
    border-top: 1px solid rgb(223, 223, 223);
}
.add-listings-search-container .vertical-card-footer a {
    width: 180px;
    color: rgb(71, 160, 251);
    text-align: center;
    height: 30px;
    line-height: 31px;
    display: inline-block;
    text-decoration: none;
}
</style>

 
    
    
        <div class="row el-element-overlay">
                    
                    <?php
                    $search=$_GET['type'];
                     $sss="SELECT DISTINCT category,subcategory,subsubcategory,brand,product_category,product_subcategory,sub_subcategory_id  from product where  (product_name LIKE '%$search%' OR category LIKE '%$search%' OR subcategory LIKE '%$search%' OR subsubcategory LIKE '%$search%' OR brand LIKE '%$search%') ";
                    
                    $run=mysqli_query($conn,$sss);
                    foreach($run as $key=> $pro){
					 
                    ?>
                     
                      <div class="col-lg-4 col-md-6">
                        <div class="card" style="    height: 141px;">
                            <div class="el-card-item">
                                
                                <div class="el-card-content" style="padding: 28px;">
                                    <h4 class="box-title"><?php echo $pro['subsubcategory'];?></h4>
                                    <small style="border-top: 1px solid rgb(223, 223, 223);"><p><?php echo $pro['category'];?> / <?php echo $pro['subcategory'];?> / <?php echo $pro['subsubcategory'];?></p></small>
                                    <br>
                                     <small style="border-top: 1px solid rgb(223, 223, 223); float: right;     text-align: right;
    width: 100%;">   <a   href="select-product.php?c=<?php echo $pro['product_category'];?>&s=<?php echo $pro['product_subcategory'];?>&ss=<?php echo $pro['sub_subcategory_id'];?>&b=<?php echo $pro['brand'];?>" >SELL IN THIS CATEGORY</a></small>
                                     
                                    
                                     </div>
                            </div>
                        </div>
                    </div>
                     <?php } ?>
                </div>
 </div>
 
<!-- ============================================================== -->
 
<!-- End Right sidebar -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
 <?php include "footer.php";?>
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/node_modules/popper/popper.min.js"></script>
<script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>
<!-- This is data table -->
<script src="assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="dist/js/dataTables.buttons.min.js"></script>
<script src="dist/js/buttons.flash.min.js"></script>
<script src="dist/js/jszip.min.js"></script>
<script src="dist/js/pdfmake.min.js"></script>
<script src="dist/js/vfs_fonts.js"></script>
<script src="dist/js/buttons.html5.min.js"></script>
<script src="dist/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->
<script>
$(function() {
$('#myTable').DataTable();
$(function() {
var table = $('#example').DataTable({
"columnDefs": [{
"visible": false,
"targets": 2
}],
"order": [
[2, 'asc']
],
"displayLength": 25,
"drawCallback": function(settings) {
var api = this.api();
var rows = api.rows({
page: 'current'
}).nodes();
var last = null;
api.column(2, {
page: 'current'
}).data().each(function(group, i) {
if (last !== group) {
$(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
last = group;
}
});
}
});
// Order by the grouping
$('#example tbody').on('click', 'tr.group', function() {
var currentOrder = table.order()[0];
if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
table.order([2, 'desc']).draw();
} else {
table.order([2, 'asc']).draw();
}
});
});
});
$('#example23').DataTable({
dom: 'Bfrtip',
buttons: [
'copy', 'csv', 'excel', 'pdf', 'print'
]
});
$('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
</script>
</body>
 
</html>