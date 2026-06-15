<?php  
$dbhost = "localhost";
$dbuser = "bizsetup_biz";
$dbpass = "Laptop@12345#";
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