<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/21/2018
 * Time: 1:35 PM
 */

$fname="";
$lname="";
$account="";
$user_account="";
$mode="";
$ID="";
$edit_account="";
$organization="";
$edit_password="";
$status="";

$sql_Organization = "Select * From ymca";
$result_Organization = mysqli_query($conn, $sql_Organization) or die('Error getting data from sql_Organization');

//check if not admin don't let any unauthorized session land on this page
if(!isset($_SESSION['Email'])){
    header("location: index.php");
}



if(isset($_GET['mode'])){
    $mode=$_GET['mode'];

    if(isset($_GET['status'])) {
        $status = $_GET['status'];
            echo $status . "<br>";
    }

    if($mode=="delete" || $mode=="edit") {
        if (isset($_GET['ID'])) {
            $hash_ID = $_GET['ID'];
            $Key = $_GET['K'];
            $ID = my_decrypt($hash_ID, $Key);
        }
    }

}

//process to check if the user is admin
$email_admin = $_SESSION['Email'];
$sql_admin = "SELECT * FROM Users WHERE Email = '$email_admin'";
$result_admin = mysqli_query($conn, $sql_admin);
$row = mysqli_fetch_array($result_admin, MYSQLI_ASSOC);
$user_account = $row["IsAdmin"];
$session_org = $row["Organization_ID"];

//echo $account; uncomment only to check if the user is 1 (admin) or 0 (organization)
//check if not admin, then don't allow anyone to access this page


//This file will have logic for adding a new user and declaring that user as an admin or an organization

    if ($mode == "delete") {

            $sql_delete = "DELETE FROM Users WHERE ID='$ID'";
            $result_delete = mysqli_query($conn, $sql_delete) or die("Can't delete user");
        $status = "Successfully deleted user";
        header("location: manage_user.php?status=".$status);

    }

    if ($mode == "edit") {

            $sql_edit = "SELECT * FROM Users WHERE ID='$ID'";
            $result_edit = mysqli_query($conn, $sql_edit) or die("Can't fetch data for edit");
            $row_edit = mysqli_fetch_array($result_edit, MYSQLI_ASSOC);

            $fname = $row_edit['First_Name'];
            //For sql injection
            $fname = htmlentities($fname, ENT_QUOTES);

            $lname = $row_edit['Last_Name'];
            $lname = htmlentities($lname, ENT_QUOTES);

            $email = $row_edit['Email'];
            $email = htmlentities($email, ENT_QUOTES);

            $account = $row_edit['IsAdmin'];
            $organization = $row_edit['Organization_ID'];


    }
    if (isset($_POST['update_submit'])) {

            $fname = $_POST["Fname"];
        //For sql injection
            $fname = htmlentities($fname, ENT_QUOTES);

            $lname = $_POST["Lname"];
            $lname = htmlentities($lname, ENT_QUOTES);

            $ID = $_POST["ID"];

            $old_password = $_POST['pass'];
            $old_password = htmlentities($old_password, ENT_QUOTES);
            //check if the email already exists before adding it to db
            $email = $_POST["Email"];
            $email = htmlentities($email, ENT_QUOTES);

            $sql_User = "Select * From Users WHERE Email = '$email' AND NOT ID='$ID'";
            $result_User = mysqli_query($conn, $sql_User) or die('Error matching records');

            if ($row = mysqli_num_rows($result_User) == 1) {
                $status = "The email already exists. Try again with another email";
                header("location: add_user.php?mode=edit&status=".$status."&ID=".$ID);
            } else {
                $account = $_POST["Account"];
                $organization = $_POST["Organization"];
                $password = $_POST["Password"];
                //For sql injection
                $password = htmlentities($password, ENT_QUOTES);
                $verify_password = $_POST["Verify_Password"];

                //to catch the old password
                $sql_admin = "SELECT * FROM Users WHERE ID= '$ID'";
                $result_pass = mysqli_query($conn, $sql_admin);
                $row_old = mysqli_fetch_array($result_pass, MYSQLI_ASSOC);
                $old_password_verify = $row_old['Password'];
                $old_password = md5($old_password);

                if($user_account==1){
//                   So if it is admin the admin could reset any users password.
                    $old_password = "";
                    $old_password_verify = "";
                }

                if ($password === $verify_password && $old_password==$old_password_verify) {
                    $password = md5($password); //encrypting the password
                    //updating user
                    if($user_account==0) {
                        $sql_update = "UPDATE Users SET First_Name='$fname', Last_Name='$lname', Email='$email', Password='$password' WHERE ID='$ID'";
                        $result_update = mysqli_query($conn, $sql_update) or die("User could not be updated");
                        //update the session if the user updates themselves
                        if($_SESSION['User_ID']==$ID){
                            $_SESSION['Email'] = $email;
                            $_SESSION['Account'] = $account;
                            $_SESSION['Organization'] = $organization;
                            $_SESSION['First_Name'] = $fname;
                            $_SESSION['Last_Name'] = $lname;
                            $_SESSION['User_ID'] = $user_id;
                        }
                        $status = "Successfully updated user";
                        header("location: manage_user.php?status=".$status);
                    }
                    elseif ($user_account==1){
                        $sql_update = "UPDATE Users SET First_Name='$fname', Last_Name='$lname', Email='$email', Password='$password', IsAdmin='$account', Organization_ID='$organization' WHERE ID='$ID'";
                        $result_update = mysqli_query($conn, $sql_update) or die("User could not be updated");
                        //update the session if the user updates themselves
                        if($_SESSION['User_ID']==$ID){
                            $_SESSION['Email'] = $email;
                            $_SESSION['Account'] = $account;
                            $_SESSION['Organization'] = $organization;
                            $_SESSION['First_Name'] = $fname;
                            $_SESSION['Last_Name'] = $lname;
                            $_SESSION['User_ID'] = $user_id;
                        }
                        $status = "Successfully updated user";
                        header("location: manage_user.php?status=".$status);
                    }
                }
                else {
                    $status = "Password's did not match";
                    header("location: add_user.php?mode=edit&status=".$status."&ID=".$ID);
                }

            }

    }

    if (isset($_POST['add_submit'])) {

            $fname = $_POST["Fname"];
            $fname = htmlentities($fname, ENT_QUOTES);

            $lname = $_POST["Lname"];
            $lname = htmlentities($lname, ENT_QUOTES);

            //check if the email already exists before adding it to db
            $email = $_POST["Email"];
            $email = htmlentities($email, ENT_QUOTES);
            $sql_User = "Select * From Users WHERE Email = '$email'";
            $result_User = mysqli_query($conn, $sql_User) or die('Error matching records');

            if ($row = mysqli_num_rows($result_User) == 1) {
                echo "The email already exists. Try again with another email";

            } else {
                $account = $_POST["Account"];
                $organization = $_POST["Organization"];
                $password = $_POST["Password"];
                $password = htmlentities($password, ENT_QUOTES);
                $verify_password = $_POST["Verify_Password"];

                if ($password === $verify_password) {
                    $password = md5($password); //encrypting the password
                    //inserting user
                    if($user_account == 1) {
                        $sql_insert = "INSERT INTO Users(First_Name, Last_Name, Email, Password, IsAdmin, Organization_ID)
                        VALUES ('$fname', '$lname', '$email', '$password', '$account', '$organization')";
                        $result_insert = mysqli_query($conn, $sql_insert) or die("User could not be added");
                        $status = "User has been created";
                        header("location: manage_user.php?status=".$status);
                    }
                    elseif($user_account == 0){
                        //The account will take 0 as organization and the organization will be the same as the session user
                        $sql_insert = "INSERT INTO Users(First_Name, Last_Name, Email, Password, IsAdmin, Organization_ID)
                        VALUES ('$fname', '$lname', '$email', '$password', '$user_account', '$session_org')";
                        $result_insert = mysqli_query($conn, $sql_insert) or die("User could not be added");
                        $status = "User has been created";
                        header("location: manage_user.php?status=".$status);
                    }
                } else {
                    $status = "Password did not match";
                    echo $status . "<br>";
//                    header("location: add_user.php?mode=add&status=".$status);
                }
            }
//        $status = "Successfully added user";
//        header("location: add_user.php?mode=add&status=".$status);

    }


?>