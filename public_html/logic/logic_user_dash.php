<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 6:33 PM
 */

if(!isset($_SESSION['Email'])){
    header("location: index.php");
}
else{
    $User = $_SESSION['Email'];
    $account = $_SESSION['Account'];
    $fname =   $_SESSION['First_Name'];
//    $fname =   $_SESSION['First_Name'];
    $lname = $_SESSION['Last_Name'];
    $org_id= $_SESSION['Organization'];
    $sql_org_name = "SELECT * FROM ymca WHERE orga_id='$org_id'";
    $result_org_name = mysqli_query($conn, $sql_org_name) or die ("Can't get organization name");
    $org_name_fetch = mysqli_fetch_array($result_org_name, MYSQLI_ASSOC);
    $org_name = $org_name_fetch['organization'];

    $org_address = $org_name_fetch['address'];
    $org_postal_code = $org_name_fetch['postal_code'];

    $address = $org_address . "," . $org_postal_code . "," . "ON";

    //    if($account != 1) {
//        // Disable functions only admins can access
//    }
}
