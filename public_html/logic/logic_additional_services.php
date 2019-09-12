<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/28/2018
 * Time: 11:38 PM
 */

$mode="";
$org_id="";
$service_id="";
$service_name="";
$service_description="";

if(!isset($_SESSION['Email'])){
    header("location: index.php");
}



if(isset($_GET['mode'])) {
    $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
    $mode = $_GET['mode'];
    if($_GET['status']!=NULL) echo $status = $_GET['status'];
    if($_GET['service_id']!=NULL){
        $hash_service_id = $_GET['service_id'];
        $service_id = my_decrypt($hash_service_id, $key);

    }
    if($_GET['org_id']!=NULL){
        $hash_org_id = $_GET['org_id'];
        $org_id = my_decrypt($hash_org_id, $key);
    }
}

$sql_target = "SELECT * FROM Target";
$result_target = mysqli_query($conn, $sql_target) or die('Error getting data');

if(isset($_POST['Add_Service']))
{
    $service_name=$_POST["Service_Name"];
    //For sql injection
    $service_name=htmlentities($service_name, ENT_QUOTES);
    $service_description=$_POST["Description"];
    $service_description=htmlentities($service_description, ENT_QUOTES);
    $service_org_id = $_POST["org_id"];


    $sql_org_name = "SELECT * FROM ymca WHERE orga_id='$service_org_id'";
    $result_org_name = mysqli_query($conn, $sql_org_name) or die("Can't get organization name");
    $row_org_name=mysqli_fetch_array($result_org_name, MYSQLI_ASSOC);
    $org_name=$row_org_name['organization'];

    $sql_insert = "INSERT INTO additonal_services(orga_id, organization, service_name, description) VALUES ('$service_org_id', '$org_name', '$service_name', '$service_description')";
    $result_insert = mysqli_query($conn, $sql_insert) or die("Can't insert the service");
    $status="Successfully inserted the service";

    header("location: manage_organization.php?status=".$status);
}

if($mode=="edit")
{
    $sql_edit = "SELECT * FROM additonal_services WHERE id=$service_id";
    $result_edit = mysqli_query($conn, $sql_edit) or die("Can't retrieve data from additional services.");
    while($row_edit = mysqli_fetch_array($result_edit, MYSQLI_ASSOC)) {
        $service_name = html_entity_decode($row_edit['service_name'], ENT_QUOTES);
        $service_description = html_entity_decode($row_edit['description'], ENT_QUOTES);
    }
}
if(isset($_POST['Edit_Service']))
{

    $service_name=$_POST["Service_Name"];
    $service_name = htmlentities($_POST["Service_Name"],  ENT_QUOTES);
    $service_description = $_POST["Description"];
    $service_description = htmlentities($service_description,  ENT_QUOTES);
    $service_org_id = $_POST["org_id"];

    $sql_org_name = "SELECT * FROM ymca WHERE orga_id='$service_org_id'";
    $result_org_name = mysqli_query($conn, $sql_org_name) or die("Can't get organization name");
    $row_org_name=mysqli_fetch_array($result_org_name, MYSQLI_ASSOC);
    $org_name=$row_org_name['organization'];

    $service_id = $_POST["service_id"];
//    $status = $service_name . "<br>" . $service_description . "<br>" . $service_org_id . "<br>" . $service_id;
    $sql_update = "UPDATE additonal_services SET orga_id='$service_org_id', organization='$org_name', service_name='$service_name', description='$service_description' WHERE id='$service_id'";
    $result_update=mysqli_query($conn, $sql_update) or die("Can't update this service");
    $status="Successfully updated the service";
    header("location: manage_organization.php?status=".$status);
}

if($mode=="delete")
{
//    $service_id;
    $sql_delete = "DELETE FROM additonal_services WHERE id='$service_id'";
    $result_delete= mysqli_query($conn, $sql_delete) or die("Can't delete this service");
    $status="Successfully deleted the Service";
    header("location: manage_organization.php?status=".$status);
}