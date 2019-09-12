<?php

require_once("logic/db_connection.php");
session_start();
$timeout = 120; // Set timeout minutes, 2 hours of inactivity
$logout_redirect_url = "login.php"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        header("Location: $logout_redirect_url");
    }
}
$_SESSION['start_time'] = time();
$previous = "javascript:history.go(-1)";

function my_encrypt($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // Generate an initialization vector
//    encode all of it to base 64 because the cipher expects an IV of precisely 16 bytes
    $iv = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_encode($encrypted . '::' . $iv);
}

function my_decrypt($data, $key)
{
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    $flag = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    if ($flag == false) {
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
    } else {
        return $flag;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="rgba(163, 11, 11, 1)" >
    <!-- Including font awesome for various icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/solid.css" integrity="sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css" integrity="sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/theme.css">
    <title>OAC Home</title>
</head>
<body>
<header>
    <div class="logo" align="center">
        <a href="index.php">
        The Orientation Advisory Committee<br>
        Windsor, Essex and Chatham-Kent
        </a>
    </div>
    <nav>
        <ul>
            <a href="index.php">Home</a>
            <a href="activities.php">Activities</a>
            <a href="organizations.php">Organizations</a>
            <a href="contact.php">Contact Us</a>
            <?php if(!isset($_SESSION['Email'])){?>
                <a href="login.php">Login</a>
                <?php
            }else{?>
                <a href="user_dash.php">Dashboard</a>
                <a href="logout.php">Logout</a>
                <?php
            }
            ?>

        </ul>
    </nav>
  
</header>
<noscript>Sorry, you need to use a browser that supports JavaScript to use this website.</noscript>
<main>