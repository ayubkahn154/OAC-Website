<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 8:30 PM
 */
$org_name = "";
$user_organization = "";
if (!isset($_SESSION["Email"])) {
    header("location: index.php");
}
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status != NULL) echo $status . "<br><br>";
}


//Getting user information
$User = $_SESSION['Email'];


$user_organization = $_SESSION['Organization'];
$account = $_SESSION['Account'];

$sql_Organization = "Select * From ymca";
$result_Organization = mysqli_query($conn, $sql_Organization) or die('Error getting data from sql_Organization');

$sql_Additional_Services = "SELECT * FROM additonal_services WHERE orga_id='$user_organization'";
$result_Additional_Services = mysqli_query($conn, $sql_Additional_Services) or die ("Can't get the additional_services");

$sql_org_name = "SELECT * FROM ymca WHERE orga_id='$user_organization'";
$result_org_name = mysqli_query($conn, $sql_org_name) or die ("Can't retrieve name");
$row_org_name = mysqli_fetch_array($result_org_name, MYSQLI_ASSOC);
$org_name = $row_org_name["organization"];

