<?php

// For accessing database:
require_once "../private_html/creds.php";


// To establish the connection on each page

$conn = mysqli_connect("$host","$username", "$password", "$database");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>