<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 12:57 PM
 */

include "resources/templates/header.php";
require_once "logic/logic_user_dash.php";

//echo $_SESSION['Email'];
//echo "<br>";

?>
<h1>User Dashboard</h1>
<div class="sidebarView">
    <div class="sidebar">
        <h2>Information:</h2>
        <br>
        <div class="overflow-buffer">
            <table class="table-separators full-width">
                <tr>
                    <td style="font-weight: bold">Name</td>
                    <td><?= $fname . " " . $lname ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Organization</td>
                    <td><?= $org_name ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Privilege</td>
                    <td><?= ($account == 1 ? "Administrator" : "Organization") ?></td>
                </tr>
            </table>
        </div>
        <br>
        <h2>Controls:</h2>
        <br>
        <div>
            <div class="tooltip">
            <a class="button" href="manage_activity.php" style="text-align: center;">Manage Activities</a>
                <span class="tooltiptext">Insert, Delete or Edit your Activities</span>
            </div>
            <br><br>
            <div class="tooltip">
            <a class="button" href="manage_organization.php" style="text-align: center;">Manage Organization</a>
                <span class="tooltiptext">Insert, Delete or Edit your Non-IRCC Services and Manage your Organization</span>
            </div>
            <br> <br>
            <div class="tooltip">
            <a class="button" href="manage_user.php" style="text-align: center;">Manage Users</a>
                <span class="tooltiptext">Insert, Delete or Edit Users</span>
            </div>
            <br><br>
            <?php if ($account == 1) { ?>
            <div class="tooltip">
                <a class="button" href="update_database.php" style="text-align: center;">Update Database</a>
                <span class="tooltiptext">Insert or Delete Database Tools</span>
            </div>
                <br><br>
            <? } ?>
        </div>
    </div>
    <div class="content">
        <iframe width='100%' height='100%' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'
                src='http://maps.google.com/maps?&amp;q=<?= $address ?>&output=embed' id="userDashMap"></iframe>
    </div>
</div>

<?php include "resources/templates/footer.php"; ?>
