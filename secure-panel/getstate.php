<?php
/**
 * Created by PhpStorm.
 * User: Deep
 * Date: 3/15/2016
 * Time: 3:44 PM
 */
include_once('config.php');
if(isset($_POST['countryId'])) {
    $countryId =  $_POST['countryId'];
    $sqlgetstate = "select  * from states where country_id = ".$countryId." ";
    $numgetstate = mysqli_query($conn,$sqlgetstate);
    $numrows = mysqli_num_rows($numgetstate);
    //print_r($numgetstate);
    if($numrows > 0) {
        $option = '<option>Select </option>';
        while ($fetchstate = mysqli_fetch_assoc($numgetstate)) {
           // print_r($fetchstate['name']);
            $option.='<option value="'.$fetchstate['id'].' ">'.$fetchstate['name'].'</option>';
        }
        echo $option;
    }
}
