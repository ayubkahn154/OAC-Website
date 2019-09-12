<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 8/2/2018
 * Time: 5:42 AM
 */
$previous = "javascript:history.go(-1)";
include "resources/templates/header.php";
require "logic/logic_insert_activity.php";

?>
    <h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a>
        <? if ($mode === "add") {
            echo " Insert Activity";
        } else if ($mode === "edit") {
            echo " Edit Activity";
        } ?>
    </h1>
    <form name="Calendar" action="insert_activity.php" method="post" id="activityInsertForm" onsubmit="verifyInfo()">
        <fieldset>
            <legend>General Information</legend>

            <label for="activity">Activity Name</label>
            <input type="text" name="activity" id="activity"
                   list="activity-datalist" placeholder="Activity Name" value="<?= $activity_edit ?>" required>
            <? if ($result_distinct_activities) { ?>
                <datalist id="activity-datalist">
                    <? while ($row = mysqli_fetch_assoc($result_distinct_activities)) { ?>
                    <option value="<?= $row['Activity'] ?>">
                        <? } ?>
                </datalist>
            <? } ?>

            <label for="category">Category</label>
            <select name='category' id="category" required>
                <option value="">Choose one</option>
                <? while ($row = mysqli_fetch_assoc($result_category)) { ?>
                    <option value='<?= $row['ID'] ?>'<? if ($mode === "edit" && $category_edit === $row["ID"]) echo "selected" ?>><?= $row['Category'] ?></option>";
                <? } ?>
            </select>

            <label for="stream">Stream</label>
            <select name='stream' id="stream" required>
                <option value="">Choose one</option>
                <? while ($row = mysqli_fetch_assoc($result_stream)) { ?>
                    <option value='<?= $row["ID"] ?>'<? if ($mode === "edit" && $stream_edit === $row["ID"]) echo "selected" ?>><?= $row["Streams"] ?></option>
                <? } ?>
            </select>
        </fieldset>
        <fieldset>
            <legend>Date and Time</legend>
            <table>
                <thead>
                <tr>
                    <th style="visibility: hidden;"></th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                </thead>
                <tbody id="multiDate">
                <? if ($mode === "add") { ?>
                    <tr>
                        <td></td>
                        <td><input type="date" name="event_date[]" id="Date" min="<?= date("Y-m-d") ?>" required></td>
                        <td><input type="time" name="event_start_time[]" id="StartTime" min="08:00:00" max="22:00:00"
                                   required/></td>
                        <td><input type="time" name="event_end_time[]" id="EndTime" min="08:00:00" max="22:00:00"
                                   required/></td>
                    </tr>
                <? } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">
                        <button id="addDateBtn" onclick="addDate(null, null, null)" class="add">Add Date/Time</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </fieldset>
        <fieldset>
            <legend>Location</legend>

            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?= $user_address ?>"
                   placeholder="Address" required>

            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]" title="A1B 2C3"
                   value="<?= $user_postal ?>" id="postal_code"
                   placeholder="A1B 2C3" required/>

            <label for="City">City</label>
            <select name='city' id="City" required>
                <option value="">Choose one</option>
                <? while ($row = mysqli_fetch_assoc($result_city)) { ?>
                    <option value='<?= $row['ID'] ?>' <? if ($user_city === $row['ID']) echo "selected" ?>><?= $row['City'] ?></option>
                <? } ?>
            </select>
        </fieldset>
        <fieldset>
            <legend>Contact Information</legend>

            <label for="Name">Contact Name</label>
            <input type="text" name="name" id="Name" placeholder="Name" value="<?= $name_edit ?>" required/>

            <label for="Contact_Number">Contact Number</label>
            <input type="tel" name="contact_number" id="Contact_Number" placeholder="Contact Number"
                   value="<?= $contact_number_edit ?>" required/>

            <label for="Contact_Ext">Ext. (Optional)</label>
            <input type="text" name="ext" id="Contact_Ext" placeholder="ext." value="<?= $ext_edit ?>"/>

            <label for="event_description">Description (Optional)</label>
            <textarea rows="5" cols="50" name="description" id="event_description"
                      placeholder="Write something about the event"><?= $description_edit ?></textarea>

            <label for="Email">Email (optional):</label>
            <input type="email" name="email" id="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                   value="<?= $email_edit ?>">

            <label for="Fax">Fax (optional):</label>
            <input type="tel" name="fax" id="Fax" value="<?= $fax_edit ?>">

        </fieldset>
        <br>

        <?php if ($mode == "add") { ?>

            <h2>Support Services</h2>
            <div class="checkbox-group multi-column">
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result_support_services, MYSQLI_ASSOC)) {
                    $i++;
                    ?>
                    <div class="checkbox-item">
                        <input type="checkbox" name="services[]" id="service<?= $i ?>" value="<?= $row['ID']; ?>">
                        <label for="service<?= $i ?>"><?= $row['support_service']; ?></label>
                    </div>
                <? } ?>

            </div>
            <br> <br>

            <h2>Target</h2>

            <div class="checkbox-group multi-column">
                <?php
                $i = 0;
                while ($row_target = mysqli_fetch_assoc($result_target)) {
                    $i++;
                    ?>
                    <div class="checkbox-item">
                        <input type="checkbox" name="targets[]" id="target<?= $i ?>"
                               value="<?= $row_target['ID']; ?>">
                        <label for="target<?= $i ?>"><?= $row_target['Targets']; ?></label>
                    </div>
                <? } ?>

            </div>

        <?php } else if ($mode == "edit") { ?>

            <h2>Support Services</h2>
            <div class="checkbox-group multi-column">
                <?php
                $i = 0;
                while ($row_services = mysqli_fetch_array($result_support_services, MYSQLI_ASSOC)) {
                    $i++;
                    ?>
                    <div class="checkbox-item">
                        <input <? if (in_array($row_services['ID'], $services)) echo " checked=checked"; ?>
                                type="checkbox" name="services[]" id="service<?= $i ?>" value="<?= $row_services['ID'] ?>">
                        <label for="service<?= $i ?>"><?= $row_services['support_service'] ?></label>
                    </div>
                <? } ?>

            </div>
            <br> <br>

            <h2>Target</h2>

            <div class="checkbox-group multi-column">
                <?php
                $i = 0;
                while ($row_target = mysqli_fetch_assoc($result_target)) {
                    $i++;
                    ?>
                    <div class="checkbox-item">
                        <input <?php if (in_array($row_target['ID'], $targets)) echo " checked=checked"; ?>
                                type="checkbox" name="targets[]" id="target<?= $i ?>"
                                value="<?= $row_target['ID']; ?>">
                        <label for="target<?= $i ?>"><?= $row_target['Targets']; ?></label>
                    </div>
                <? } ?>

            </div>

        <?php } ?>
        <br><br>

        <?php if ($mode == "add") { ?>
            <input type="submit" id="submit" name="add" value="Submit">
            <input type="reset" id="reset" name="reset" value="Reset">
        <?php } elseif ($mode == "edit") { ?>
            <input type="hidden" id="submit" name="ID" value="<?= $ID ?>">
            <input type="submit" id="submit" name="edit" value="Update Activity">
        <?php
        } ?>
    </form>
    <script src="scripts/eventInsert.js"></script>
<? include "resources/templates/footer.php"; ?>