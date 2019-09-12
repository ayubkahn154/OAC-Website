<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 7:12 PM
 */
$previous = "javascript:history.go(-1)";
include "resources/templates/header.php";
require_once("logic/logic_manage_user.php");
?>
<br>
<h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Manage User</h1>
<div class="sidebarView">
    <div class="sidebar">
        <a class="button" id="add_user"><i class="fas fa-plus-circle"></i> Add User</a><br><br>
        <form name="user_filter" action="manage_user.php" method="post" id="filter">
            <fieldset>
                <legend>Filter</legend>
                <input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                       title="johndoe@email.com" placeholder="Email" value="<?= $email ?>">
                <?php if ($account == 1){ ?>

                <label for="Organization">Select an Organization</label>
                <select name="Organization" id="Organization">
                    <option value="">--</option>
                    <? while ($row = mysqli_fetch_array($result_org, MYSQLI_ASSOC)) { ?>
                        <option <?php if ($org_id == $row['Organization_ID']) {
                            echo "selected=selected";
                        } ?>
                        <option value='<?= $row["Organization_ID"] ?>'><?= $row["organization"] ?></option>
                    <? }
                    } ?>
                </select>
                <?php ?>
                <input type="submit" name="filter" value="Filter">
            </fieldset>
        </form>
    </div>
    <div class="content overflow-buffer">
        <table class="table-separators red-header full-width">
            <tr>
                <?php if($_SESSION['Account'] == 1) { ?>
                <th>Remove User</th>
                <?php } ?>
                <th>Edit User</th>
                <th>First_Name</th>
                <th>Last_Name</th>
                <th>Email</th>
                <th>Account</th>
                <th>Organization</th>
            </tr>
            <?php

            while ($row = mysqli_fetch_array($result_user, MYSQLI_ASSOC)) {
                $data = $row["ID"];
                $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
                $ID_encrypted = my_encrypt($data, $key);

                ?>
                <tr>
                <?php if($_SESSION['Account'] == 1)
                    {
                        ?>
                    <td style="text-align: center">
                        <div class="tooltip">
                            <a class="button" onclick="removeUser('<?= $ID_encrypted ?>', '<?= $key ?>')"><i class="fas fa-trash"></i></a>
                            <span class="tooltiptext">Delete this User</span>
                        </div>
                    </td>
                    <?php } ?>

                    <td style="text-align: center">
                        <div class="tooltip">
                            <a class="button" onclick="editUser('<?= $ID_encrypted ?>', '<?= $key ?>')"><i class="fas fa-edit"></i></a>
                            <span class="tooltiptext">Edit this User</span>
                        </div>
                    </td>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Email"] ?></td>
                    <?php if ($row["IsAdmin"] == 1) { ?>
                        <td>Administrator</td>
                    <?php } else { ?>
                        <td>Organization</td>
                    <?php } ?>
                    <td><?= $row["organization"] ?></td>

                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>

<script src="scripts/user_manager.js"></script>
<?php


include "resources/templates/footer.php"; ?>
