<?php

session_start();

//header("location: login.php");

session_destroy();
header("Location: login.php?logout=" . urlencode("You Successfully logout!"));
exit;
?>