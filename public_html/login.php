<?php


$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
require_once "logic/logic_login.php";
//include "resources/templates/header.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/solid.css" integrity="sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css" integrity="sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6" crossorigin="anonymous">
    <title>YMCA Login</title>
</head>
<body>

    <main>
        <div id="loginBox">
            <a href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i> Go Back</a>
            <h1>OAC Login</h1>
            <form action="login.php" method="post" id="loginForm">
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email"><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br>
                <div id="actionButtons">
                    <input type="submit" name="submit" value="Login">


<!--                    <input type="button" value="Sign Up">-->
                </div>
            </form>
        </div>
    </main>
</body>
</html>
