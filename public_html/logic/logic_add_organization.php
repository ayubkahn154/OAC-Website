<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 10:02 PM
 */

$organization_edit = "";
$address_edit = "";
$city_edit = "";
$postal_code_edit = "";
$phone_edit = "";
$fax_edit = "";
$website_edit = "";
$row_edit_services = "";
$result_edit_services = "";
$services = array();
$orga_edit = "";

$status = "";
$mode = "";


//fetch for verifying if organization
$email_admin = $_SESSION['Email'];
$account =  $_SESSION['Account'];

if (!isset($_SESSION["Email"])) {
    header("location: index.php");
}



if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    //put an if condition to remove the error
    if ($mode == "edit" || $mode == "delete") {
        $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
        $hash_orga_id = $_GET['orga_id'];
        $orga_id = my_decrypt($hash_orga_id, $key);
    }
    if ($_GET['status']) $status = $_GET ['status'];
    if ($status != NULL) echo $status . "<br>";
//    if($orga_id!=NULL) echo $orga_id."<br>";
//    echo "Mode: " . $mode . "<br>";
}

$sql_city = "SELECT * FROM City";
$result_city = mysqli_query($conn, $sql_city) or die('Cannot get City');

$sql_services = "SELECT * FROM services";
$result_services = mysqli_query($conn, $sql_services) or die('Cannot get services');


if (isset($_POST['submit_add'])) {
    $status = "";
    $organization = $_POST["organization"];
    $organization = htmlentities($organization, ENT_QUOTES);

    $address = $_POST["address"];
    $address = htmlentities($address, ENT_QUOTES);

    $city = $_POST["City"];

    $postal_code = $_POST["postal_code"];
    $postal_code = htmlentities($postal_code, ENT_QUOTES);

    $phone = $_POST["tel"];
    $phone = htmlentities($phone, ENT_QUOTES);

    $fax = $_POST["fax"];
    $fax = htmlentities($fax, ENT_QUOTES);

    $website = $_POST["website"];
    $website = htmlentities($website, ENT_QUOTES);

    $services = $_POST["services"];
    //for add organization
    //check for duplicates
    $sql_ymca = "SELECT * FROM ymca WHERE address = '$address' AND city='$city'";
    $result_ymca = mysqli_query($conn, $sql_ymca) or die ("cannot retrieve data from ymca");
    $row = mysqli_fetch_array($result_ymca, MYSQLI_ASSOC);

    if ($row) {
        $status = "The organization already exists";
    } else {
        $sql_insert_org = "INSERT INTO ymca (organization, address, city, postal_code, phone, fax, website) VALUES ('$organization', '$address', '$city', '$postal_code', '$phone', '$fax', '$website')";
        $result_org = mysqli_query($conn, $sql_insert_org) or die ("Cannot insert data");
        //get the organization id so you can insert the services
        $sql_get_org_id = "SELECT orga_id FROM ymca WHERE organization = '$organization'";
        $result_org_id = mysqli_query($conn, $sql_get_org_id) or die("Error fetching the organization id");
        $row = mysqli_fetch_array($result_org_id, MYSQLI_ASSOC);
        $org_id = $row["orga_id"];
//            echo "Successfully inserted <br>";
        //Now insert the services

        //Building query for services
        $sql_insert_services = "INSERT INTO orga_serv (orga_id, serv_id) VALUES ";
        for ($i = 0; $i < count($services); $i++) {
            $sql_insert_services .= "(" . $org_id . ", " . $services[$i] . ")";
            // If inserted value set is not the last one, append a comma
            if ((count($services) - 1) != $i) {
                $sql_insert_services .= ",";
            }
        }
        //inserting all service values to the database
        if ($services) {
            $result_insert_services = mysqli_query($conn, $sql_insert_services) or die ("Can't insert services");
//            echo "Successfully inserted <br>";
        } else {
            $status .= "<br> Services were empty but the organization has been added";
        }
    }
    if ($status == NULL) $status = "Successfully inserted data";
    //so when the page refreshes on submit the mode would be stick around
    header("location: manage_organization.php?mode=add&status=" . $status);
}

//for edit organization
//received the orga_id from the javascript file


if ($mode == "edit") {
    //storing the orga_id through a hidden input because the global orga_id gets overwritten with NULL value by $_submit
    $orga_edit = $orga_id;
    $sql_org = "SELECT * FROM ymca WHERE orga_id = '$orga_edit'";
    $result_org = mysqli_query($conn, $sql_org) or die("cannot get the organization id in edit");
    while ($row_org = mysqli_fetch_array($result_org, MYSQLI_ASSOC)) {
        $organization_edit = $row_org['organization'];
        $address_edit = $row_org['address'];
        $city_edit = $row_org['city'];
        $postal_code_edit = $row_org['postal_code'];
        $phone_edit = $row_org['phone'];
        $fax_edit = $row_org['fax'];
        $website_edit = $row_org['website'];

    }

    //now get the services for edit
    $sql_edit_services = "SELECT * FROM orga_serv WHERE orga_id='$orga_edit'";
    $result_edit_services = mysqli_query($conn, $sql_edit_services) or die("problem loading services");
    while ($row_edit_services = mysqli_fetch_array($result_edit_services, MYSQLI_ASSOC)) {
        array_push($services, $row_edit_services['serv_id']);
    }
    //now catch the values and run the update query
}
if (isset($_POST['submit_edit'])) {
    $organization = $_POST["organization"];
    //For Sql Injection
    $organization = htmlentities($organization, ENT_QUOTES);

    $address = $_POST["address"];
    $address = htmlentities($address, ENT_QUOTES);

    $city = $_POST["City"];
    $postal_code = $_POST["postal_code"];
    $postal_code = htmlentities($postal_code, ENT_QUOTES);

    $phone = $_POST["tel"];
    $phone = htmlentities($phone, ENT_QUOTES);

    $fax = $_POST["fax"];
    $fax = htmlentities($fax, ENT_QUOTES);

    $website = $_POST["website"];
    $website = htmlentities($website, ENT_QUOTES);

    //storing the orga_id through a hidden input because the global orga_id gets overwritten with NULL value by $_submit
    $orga_edit = $_POST["orga_edit"];
    $services = $_POST["services"];
    //check for duplicates where the organization id does not match the current record.
    $sql_ymca = "SELECT * FROM ymca WHERE address = '$address' AND city='$city' AND NOT orga_id ='$orga_edit'";
    $result_ymca = mysqli_query($conn, $sql_ymca) or die ("cannot retrieve data from ymca");
    $row = mysqli_fetch_array($result_ymca, MYSQLI_ASSOC);

    if ($row) $status .= "<br> The organization already exists";
    else {
        $sql_edit_org = "UPDATE ymca SET organization = '$organization', address='$address', city='$city', postal_code = '$postal_code', phone='$phone', fax = '$fax', website='$website' WHERE orga_id='$orga_edit'";
        $result_edit = mysqli_query($conn, $sql_edit_org) or die("Cannot update organization");
        /*I am deleting the services and then adding them again as it will be a faster process rather than counting that how many rows are in the
        database for the organization and then comparing if the update is less then the rows then delete the ones which don't match the update.*/
        $sql_edit_service = "DELETE FROM orga_serv WHERE orga_id='$orga_edit'";
        $result_edit_service = mysqli_query($conn, $sql_edit_service) or die("Cannot delete Services");
        $sql_insert_services = "INSERT INTO orga_serv (orga_id, serv_id) VALUES ";
        for ($i = 0; $i < count($services); $i++) {
            $sql_insert_services .= "(" . $orga_edit . ", " . $services[$i] . ")";
            // If inserted value set is not the last one, append a comma
            if ((count($services) - 1) != $i) {
                $sql_insert_services .= ",";
            }
        }
        if ($services) {
            $result_insert_services = mysqli_query($conn, $sql_insert_services) or die ("Can't insert services for update");
        } else {
            $status .= "<br> Services were empty so all have been deleted but the organization has been updated";
        }
    }
    if ($status == NULL) $status = "The record has been updated.";
    header("location: manage_organization.php?mode=edit&status=" . $status);
}
//now time for the delete operation
if ($mode == "delete") {

    //First Delete everything from the calendar for that organization.

    $sql_select_calendar_id = "SELECT ID FROM Calendar WHERE Organization='$orga_id'";
    $result_calendar_id = mysqli_query($conn, $sql_select_calendar_id);
//    $status = $sql_select_calendar_id . "<br>";
    while($ids = mysqli_fetch_array($result_calendar_id, MYSQLI_ASSOC)) {
        $id = $ids['ID'];

        $sql_delete_date = "DELETE FROM Calendar_Dates WHERE Calendar_ID='$id'";
//        $status .= $sql_delete_date . "<br>";
            $result_delete_date = mysqli_query($conn, $sql_delete_date) or die("Can't delete the date's");

        $sql_delete_targets = "DELETE FROM Calendar_Targets WHERE Calendar_ID='$id'";
//       $status .= $sql_delete_targets . "<br>";
        $result_delete_targets = mysqli_query($conn, $sql_delete_targets) or die("Can't delete targets");

        $sql_delete_services = "DELETE FROM Calendar_Services WHERE Calendar_ID='$id'";
//        $status .= $sql_delete_services . "<br>";
        $result_delete_services = mysqli_query($conn, $sql_delete_services);

//        Due to foreign key rule this sql query below will be run in the end as it is a unique key
        $sql_delete_Calendar = "DELETE FROM Calendar WHERE ID='$id'";
//        $status .= $sql_delete_Calendar . "<br>";
        $result_delete_Calendar = mysqli_query($conn, $sql_delete_Calendar);
    }
//    Now delete the users of that organization
    $sql_delete_user = "DELETE FROM Users WHERE Organization_ID = '$orga_id'";
//    $status .= $sql_delete_user . "<br>";
    $result_delete_user = mysqli_query($conn, $sql_delete_user) or die("Can't Delete User");

    $sql_del_services = "DELETE FROM orga_serv WHERE orga_id='$orga_id'";
//    $status .= $sql_del_services . "<br>";
    $result_del_services = mysqli_query($conn, $sql_del_services) or die("Can't delete the services");

    $sql_delete_additonal_serv = "DELETE FROM additonal_services WHERE orga_id='$orga_id'";
    $result_delete_additonal_serv = mysqli_query($conn, $sql_delete_additonal_serv) or die("Can't Delete Additional Services");
//    $status .= $sql_delete_additonal_serv . "<br>";

    $sql_del_org = "DELETE FROM ymca WHERE orga_id='$orga_id'";
//    $status .= $sql_del_org . "<br>";
    $result_del_org = mysqli_query($conn, $sql_del_org) or die("Can't delete organization");


    $status = "Successfully deleted";

    header("location: manage_organization.php?mode=delete&status=" . $status);
}