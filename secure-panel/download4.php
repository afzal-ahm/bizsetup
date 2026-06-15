<?php
include "../include/config.php";
//include_once"../adminpanel/include/connect.php";
/* $queryexport = "SELECT name,email,phone,city,website,category,company,country FROM exhibit";

$row = mysqli_fetch_assoc($conn,$queryexport);

$result = mysql_query($queryexport);
$header = '';

for ($i = 0; $i < $count; $i++){
   $header .= mysql_field_name($result, $i)."\t";
   }

while($row = mysql_fetch_row($result)){
   $line = '';
   foreach($row as $value){
          if(!isset($value) || $value == ""){
                 $value = "\t";
          }else{
                 $value = str_replace('"', '""', $value);
                 $value = '"' . $value . '"' . "\t";
                 }
          $line .= $value;
          }
   $data .= trim($line)."\n";
   $data = str_replace("\r", "", $data);

if ($data == "") {
   $data = "\nno matching records found\n";
   }
}
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=exportfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

// output data
echo $header."\n".$data;

mysql_close($conn);
*/


// Connection 


$filename = "order_record.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
$user_query = "SELECT order_id,total_amount,order_date,email_id,mobile_no,payment_type FROM order_summary  ORDER by id DESC ";
$run = mysqli_query($conn,$user_query);
// Write data to file
$flag = false;
while ($row = mysqli_fetch_assoc($run)) {
    if (!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($row)) . "\r\n";
        $flag = true;
    }
    echo implode("\t", array_values($row)) . "\r\n";
}
?>
