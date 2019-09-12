<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 9:11 PM
 */
$previous = "javascript:history.go(-1)";
include "resources/templates/header.php";
require_once("logic/logic_add_organization.php");

if ($mode == "edit") {
    ?>
    <br>

    <h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Edit Organization</h1>
    <?php
} elseif($account==1 && $mode=="add") {
    ?>
     <br>
    <h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Insert Organization</h1>
<?php } ?>

    <form method="post" action="add_organization.php" name="add_user" id="add_user">
        <fieldset>
            <legend>Organization Information</legend>

            <label for="organization">Organization Name:</label>
            <input type="text" name="organization" id="organization" value="<?= $organization_edit ?>"
                   placeholder="Organization" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="Address" value="<?= $address_edit ?>" placeholder="123 Street Name"
                   required>

            <label for="City">City:</label>
            <select name='City' id="City" required>
                <option value="">Select One</option>
                <? while ($row = mysqli_fetch_array($result_city, MYSQLI_ASSOC)) { ?>
                    <option value='<?= $row['ID'] ?>' <? if ($mode === "edit" && $city_edit === $row['ID']) echo "selected" ?> ><?= $row['City'] ?></option>
                <? } ?>
            </select>

            <label for="postal_code">Postal Code:</label>
            <input type="text" name="postal_code" id="postal_code" pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]" title="A1B 2C3" value="<?= $postal_code_edit ?>"
                   placeholder="A1B 2C3" required>

            <label for="phone">Contact Number:</label>
            <input type="tel" name="tel" id="tel" value="<?= $phone_edit ?>" placeholder="519 xxx xxxx" required>

            <label for="fax">Fax (Optional:</label>
            <input type="tel" name="fax" id="fax" value="<?= $fax_edit ?>" placeholder="519 xxx xxxx">

            <label for="website">Website:</label>
            <input type="text" name="website" id="website" value="<?= $website_edit ?>" placeholder="URL" required>

        </fieldset>


        <h2>Services</h2>
        <?php if ($mode == "add") { ?>
        <div class="checkbox-group multi-column">
            <?php
            $i = 0;
            //This will make the labels to be able to get clicked.
            while ($row = mysqli_fetch_array($result_services, MYSQLI_ASSOC)) {
                $i++;
                ?>
                <div class="checkbox-item">
                    <input type="checkbox" name="services[]" id="checkbox<?= $i ?>" value="<?= $row['serv_id']; ?>">
                    <label for="checkbox<?= $i ?>"><?= $row['service_name']; ?></label>
                </div>
            <?php } ?>
        </div>
        <?php } else{?>

        <div class="checkbox-group multi-column">
            <?php
            $i = 0;
            //This will make the labels to be able to get clicked.
            while ($row = mysqli_fetch_array($result_services, MYSQLI_ASSOC)) {
                $i++;
                ?>
                <div class="checkbox-item">
                    <input
                        <?php if (in_array($row['serv_id'], $services)) echo " checked=checked"; ?>
                            type="checkbox" name="services[]" id="checkbox<?= $i ?>" value="<?= $row['serv_id']; ?>">
                    <label for="checkbox<?= $i ?>"><?= $row['service_name']; ?></label>
                </div>
            <? } ?>
        </div>

    <?php
        }
        ?>

        <br>
        <br>

        <?php if ($mode == "edit") { ?>
            <input type="hidden" name="orga_edit" id="orga_edit" value="<?= $orga_edit ?>">
            <br>
            <input type="submit" name="submit_edit" value="Update Organization"/>
        <?php } elseif($account==1 && $mode=="add")  { ?>
            <input type="submit" name="submit_add" value="Add Organization"/>
            <input type="reset" name="reset" value="Reset">
        <?php } ?>


    </form>


<?php include "resources/templates/footer.php"; ?>