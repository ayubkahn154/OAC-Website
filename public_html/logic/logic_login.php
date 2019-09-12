<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/21/2018
 * Time: 6:11 PM
 */

require_once ("logic/db_connection.php");
session_start();
if(isset($_SESSION['Email'])){
    header("location: index.php");
}


$sql = "SELECT * FROM Users";
$sql_result = mysqli_query($conn, $sql) or die("Cannot connect to db");

if(isset($_POST['submit']))
{

    $email = $_POST['email'];
    $password = $_POST['password'];

    $password = md5($password); // to encrypt the password so it can match the password in db

    $sql_login = "SELECT * from Users WHERE Email = '$email' AND Password = '$password'";
    $result_login = mysqli_query($conn, $sql_login) or die("Cannot match query");
    $result_session= mysqli_fetch_array($result_login, MYSQLI_ASSOC);
    $account = $result_session['IsAdmin'];
    $fname = $result_session['First_Name'];
    $lname = $result_session['Last_Name'];
    $org_id= $result_session['Organization_ID'];
    $user_id = $result_session['ID'];

    if($row = mysqli_num_rows($result_login)==1)//checking for a match
    {
        //account exists, save session as email
        $_SESSION['Email'] = $email;
        $_SESSION['Account'] = $account;
        $_SESSION['Organization'] = $org_id;
        $_SESSION['First_Name'] = $fname;
        $_SESSION['Last_Name'] = $lname;
        $_SESSION['User_ID'] = $user_id;
            header("location: user_dash.php?");
        }
    else{
        echo "Username/Password is incorrect";
    }

}
?>