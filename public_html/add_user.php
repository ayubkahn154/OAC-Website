<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/21/2018
 * Time: 1:37 PM
 */
$previous = "javascript:history.go(-1)";
include "resources/templates/header.php";
require_once("logic/logic_add_user.php");

if ($mode == "edit") {

?>
    <br>
    <br>
    <h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Edit User</h1>
    <p>*** You will need to create a new password to update this user ***</p>
<?php } else { ?>
    <br>
    <h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Add User</h1>
<?php } ?>
    <form name="Calendar" action="add_user.php" method="post" id="add_user_Form">

        <fieldset>
            <legend>USER INFORMATION</legend>

            <label for="First Name">First Name</label>
            <input type="text" name="Fname" id="Fname" pattern="[A-Za-z]{1,32}" title="Name can only have alphabets A-Z" placeholder="John" value="<?= $fname ?>" required>

            <label for="Last Name">Last Name</label>
            <input type="text" name="Lname" id="Lname" pattern="[A-Za-z]{1,32}" title="Name can only have alphabets A-Z" placeholder="Doe" value="<?= $lname ?>" required>

            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" placeholder="johndoe@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="johndoe@email.com" value="<?= $email ?>" required>

            <?php if ($mode == "edit" && $user_account==0) { ?>

                <label for="pass">Old Password</label>
                <input type="password" name="pass" id=pass" placeholder="Old Password" required>

            <? } ?>


            <label for="Password">Password</label>
            <input type="password" name="Password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Password" required>

            <label for="Verify Password">Verify Password</label>
            <input type="password" name="Verify_Password" id="verify_password" placeholder="Verify Password" required>

            <? if ($user_account == 1){ ?>

            <label for="Account">Account</label>
            <select name="Account" id="Account" required>
                <option value="" selected>Please Select One</option>
                <option value="0"<? if ($account == 0) echo "selected" ?>>Organization</option>
                <option value="1" <? if ($account == 1) echo "selected" ?>>Admin</option>
            </select>

            <label for="Organization">Organization</label>
            <select name="Organization" id="Organization" required>
                <option value="">Please Select One</option>
                <? while ($row = mysqli_fetch_array($result_Organization, MYSQLI_ASSOC)) { ?>
                    <option value='<?= $row["orga_id"] ?>'<? if ($organization === $row["orga_id"]) echo "selected" ?>><?= $row["organization"] ?></option>
                <? }
                } ?>
            </select>

            <?php if ($mode == "edit") { ?>
                <input type="hidden" id="ID" name="ID" value="<?= $ID ?>">
                <input type="submit" name="update_submit" id="submit" value="Update">
            <?php } else { ?>
                <input type="submit" name="add_submit" id="submit" value="Submit">
            <?php } ?>
        </fieldset>

    </form>
          

<?php
include "resources/templates/footer.php";
?>