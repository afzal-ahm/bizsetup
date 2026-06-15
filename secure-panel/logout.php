<?php

session_start();

//header("location: login.php");

session_destroy();

echo "<script>window.open('login.php?logout=You Successfully logout!','_self')</script>";

?>