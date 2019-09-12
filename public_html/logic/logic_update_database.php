<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/31/2018
 * Time: 12:22 AM
 */

$account = $_SESSION['Account'];
if(!isset($_SESSION['Email']) || $account==0){
    header("location: index.php");
}
else{
    $User = $_SESSION['Email'];
    $fname = $_SESSION['First_Name'];
    $lname = $_SESSION['Last_Name'];
    $mode = "";
    $add = "";
    $table = "";
    $ID = "";
    $status = "";

}

// --- BEGIN TESTING CODE ---

$sql_city = "SELECT * FROM City";
$result_city = mysqli_query($conn, $sql_city) or die('Cannot get City');

$sql_support_services = "SELECT * FROM Support_Services";
$result_support_services = mysqli_query($conn, $sql_support_services) or die('Cannot get support services');

$sql_stream = "SELECT * FROM Streams";
$result_stream = mysqli_query($conn, $sql_stream) or die('Cannot get streams');

$sql_category = "SELECT * FROM Categories";
$result_category = mysqli_query($conn, $sql_category) or die('Cannot get categories');

$sql_services = "SELECT * FROM services";
$result_services = mysqli_query($conn, $sql_services) or die('Error getting data');

$sql_target = "SELECT * FROM Target";
$result_target = mysqli_query($conn, $sql_target) or die ("Can't load targets");
if (isset($_GET['status'])) $status  = $_GET['status'];

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    if ($_GET['add']) $add = $_GET['add'];
    if ($_GET['table']) $table  = $_GET['table'];
    if ($_GET['ID']) $ID  = $_GET['ID'];
}

if($mode == "add" && $add!=NULL){
    $add = htmlentities($add, ENT_QUOTES);

    if($table == "services"){
        $sql_insert_services = "INSERT INTO services(service_name) VALUES ('$add')";
        $result_insert_services = mysqli_query($conn, $sql_insert_services) or die("Can't insert Service");
        $status = "Successfully inserted the Service";
        header("location: update_database.php?status=".$status);
    }

    if($table == "target"){
        $sql_insert_target = "INSERT INTO Target(Targets) VALUES ('$add')";
        $result_insert_target = mysqli_query($conn, $sql_insert_target) or die("Can't insert Target");
        $status = "Successfully inserted the Target";
        header("location: update_database.php?status=".$status);
    }

    if($table == "support_service"){
        $sql_insert_support_service = "INSERT INTO Support_Services(support_service) VALUES ('$add')";
        $result_insert_support_service = mysqli_query($conn, $sql_insert_support_service) or die("Can't insert Support Service");
        $status = "Successfully inserted the Support Service";
        header("location: update_database.php?status=".$status);
    }

    if($table == "city"){
        $sql_insert_city = "INSERT INTO City(City) VALUES ('$add')";
        $result_insert_city = mysqli_query($conn, $sql_insert_city) or die("Can't insert City");
        $status = "Successfully inserted the City";
        header("location: update_database.php?status=".$status);
    }
    if($table == "stream"){
        $sql_insert_stream = "INSERT INTO Streams(Streams) VALUES ('$add')";
        $result_insert_stream = mysqli_query($conn, $sql_insert_stream) or die("Can't insert Stream");
        $status = "Successfully inserted the Stream";
        header("location: update_database.php?status=".$status);
    }
    if($table == "category"){
        $sql_insert_category = "INSERT INTO Categories(Category) VALUES ('$add')";
        $result_insert_category = mysqli_query($conn, $sql_insert_category) or die("Can't insert Category");
        $status = "Successfully inserted the Category";
        header("location: update_database.php?status=".$status);
    }
}
if($mode == "delete" && $ID!=NULL){

    if($table == "services"){
        $sql_delete_services = "DELETE FROM services WHERE serv_id='$ID'";
        $result_delete_services = mysqli_query($conn, $sql_delete_services) or die("Can't insert Service");
        $status = "Successfully deleted the Service";
        header("location: update_database.php?status=".$status);
    }

    if($table == "target"){
        $sql_delete_target = "DELETE FROM Target WHERE ID='$ID'";
        $result_delete_target = mysqli_query($conn, $sql_delete_target) or die("Can't delete Target");
        $status = "Successfully deleted the Target";
        header("location: update_database.php?status=".$status);
    }

    if($table == "support_service"){
        $sql_delete_support_service = "DELETE FROM Support_Services WHERE ID ='$ID'";
        $result_delete_support_service = mysqli_query($conn, $sql_delete_support_service) or die("Can't delete Support Service");
        $status = "Successfully deleted the Support Service";
        header("location: update_database.php?status=".$status);
    }
//
    if($table == "city"){
        $sql_delete_city = "DELETE FROM City WHERE ID = '$ID'";
        $result_delete_city = mysqli_query($conn, $sql_delete_city) or die("Can't delete City");
        $status = "Successfully deleted the City";
        header("location: update_database.php?status=".$status);
    }
    if($table == "stream"){
        $sql_delete_stream = "DELETE FROM Streams WHERE ID='$ID'";
        $result_delete_stream = mysqli_query($conn, $sql_delete_stream) or die("Can't delete Stream");
        $status = "Successfully deleted the Stream";
        header("location: update_database.php?status=".$status);
    }
    if($table == "category"){
        $sql_delete_category = "DELETE FROM Categories WHERE ID='$ID'";
        $result_delete_category = mysqli_query($conn, $sql_delete_category) or die("Can't delete Category");
        $status = "Successfully inserted the Category";
        header("location: update_database.php?status=".$status);
    }
}