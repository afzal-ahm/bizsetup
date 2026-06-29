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
mysqli_set_charset($conn, "utf8mb4");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);

// Clean zero-width/invisible characters from request data to prevent copy-paste pollution
if (!function_exists('sanitize_invisible_characters')) {
    function sanitize_invisible_characters(&$value) {
        if (is_array($value)) {
            foreach ($value as &$val) {
                sanitize_invisible_characters($val);
            }
        } else if (is_string($value)) {
            // Strip U+2060 (Word Joiner), U+200B (Zero Width Space), U+FEFF (Byte Order Mark)
            $value = preg_replace('/[\x{2060}\x{200B}\x{FEFF}]/u', '', $value);
        }
    }
}
sanitize_invisible_characters($_POST);
sanitize_invisible_characters($_GET);
?>