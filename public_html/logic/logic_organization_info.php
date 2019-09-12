<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/19/2018
 * Time: 12:24 PM
 */

$orga_id = null;

if (isset($_GET['orga_id'])) {
    $orga_id = $_GET['orga_id'];
}

$sql_orga_id = "SELECT * FROM ymca WHERE orga_id= '$orga_id'";
$result_orga_id = mysqli_query($conn, $sql_orga_id) or die("Can't get the organization id");
$row = mysqli_fetch_array($result_orga_id, MYSQLI_ASSOC);

$sql_city = "SELECT * from City WHERE ID=" . $row['city'];
$result_city = mysqli_query($conn, $sql_city) or die("Can't get the city");
$city = mysqli_fetch_assoc($result_city);
//$row['city_id'] = $city['ID'];
$row['city'] = $city['City'];

$sql_orga_serv = "SELECT * FROM orga_serv WHERE orga_id=" . $orga_id;
$result_orga_serv = mysqli_query($conn, $sql_orga_serv) or die("Can't retrieve the services");
$services = array();

$sql_services = "SELECT * FROM services";
$result_services = mysqli_query($conn, $sql_services) or die("Can't get the services");

$sql_additonal_services = "SELECT * FROM additonal_services WHERE orga_id=" . $orga_id;
$result_additonal_services = mysqli_query($conn, $sql_additonal_services) or die("Can't fetch the services");