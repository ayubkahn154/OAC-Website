<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/30/2018
 * Time: 6:56 PM
 */

if (!isset($_SESSION['Email'])) {
    header("location: index.php");
}

$email="";
$org_id="";
$result_org = "";
$email_admin = $_SESSION['Email'];
$sql_admin = "SELECT * FROM Users WHERE Email = '$email_admin'";
$result_admin = mysqli_query($conn, $sql_admin);
$row = mysqli_fetch_array($result_admin, MYSQLI_ASSOC);
$account = $row["IsAdmin"];
$session_org = $row["Organization_ID"];

if ($account == 1) {
    $org_sql = "SELECT DISTINCT ymca.organization, Users.Organization_ID FROM Users LEFT JOIN (ymca) ON (ymca.orga_id = Users.Organization_ID)";
    $result_org = mysqli_query($conn, $org_sql) or die("Can't get the organizations");
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    echo $status;
}

if (isset($_POST['filter'])) {
    $email = $_POST["email"];
    $email = htmlentities($email, ENT_QUOTES);
    $org_id = $_POST["Organization"];

    if($account==1 && $email==NULL && $org_id==NULL){
        header("location:manage_user.php?status=Filters can't be empty!");
    }
    if($account==0 && $email==NULL){
        header("location:manage_user.php?status=Filter can't be empty!");
    }




    if ($account == 1 && $email != NULL && $org_id != NULL) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
WHERE Users.Email = '$email' AND Users.Organization_ID = '$org_id'
ORDER BY ID";
    } elseif ($account == 1 && $email != NULL && $org_id == NULL) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
WHERE Users.Email = '$email'
ORDER BY ID";
    } elseif ($account == 1 && $email == NULL && $org_id != NULL) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
WHERE Users.Organization_ID = '$org_id'
ORDER BY ID";
    } elseif ($account == 0 && $email != NULL) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
WHERE Organization_ID = '$session_org' AND Users.Email = '$email'
ORDER BY ID";

    } elseif ($account == 0 && $email == NULL) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
WHERE Organization_ID = '$session_org'
ORDER BY ID";
    }
    $result_user = mysqli_query($conn, $sql_user) or die("Can't retrieve users");
} else {

    if ($account == 1) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
ORDER BY ID";
        $result_user = mysqli_query($conn, $sql_user) or die("Can't retrieve users");
    } elseif ($account == 0) {
        $sql_user = "SELECT Users.ID, Users.First_Name, Users.Last_Name, Users.Email, Users.IsAdmin, ymca.organization
FROM Users
LEFT JOIN (ymca)
ON (Users.Organization_ID = ymca.orga_id)
WHERE Organization_ID = '$session_org'
ORDER BY ID";
        $result_user = mysqli_query($conn, $sql_user) or die("Can't retrieve users");
    }
}


