<?php  
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "mysqlDB..";
$dbname = "bizsetup_biz";
/*
$dbhost = "localhost";
$dbuser = "tea";
$dbpass = "computer@123";
$dbname = "bvm";*/
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die(mysqli_error ("Error database could not connect"));

session_start();
error_reporting(0);
?>