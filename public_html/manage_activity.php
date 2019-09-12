<?php
/**
 * Created by PhpStorm.
 * User: ranim
 * Date: 7/31/2018
 * Time: 8:03 AM
 */

include "resources/templates/header.php";
require_once("logic/logic_manage_activity.php");

?>
<br>
<h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Manage Activity</h1>
<div class="sidebarView">
    <div class="sidebar">

        <a class="button" id="insert_activity"><i class="fas fa-plus-circle"></i> Add New Activity</a>
        <br>
        <br>
        <fieldset>
            <legend>Filter</legend>
            <table>
                <tr>
                    <td>
                        <label for="monthSelector">Month:</label>
                    </td>
                    <td>
                        <select id="monthSelector" onchange="filterData(this, this.value)">
                            <option value="" selected></option>
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5">June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="categorySelector">Category:</label>
                    </td>
                    <td>
                        <select id="categorySelector" onchange="filterData(this, this.value)">
                            <option value="" selected></option>
                            <? while ($row = mysqli_fetch_assoc($result_category)) { ?>
                                <option value='<?= $row['Category'] ?>'><?= $row['Category'] ?></option>";
                            <? } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="streamSelector">Stream:</label>
                    </td>
                    <td>
                        <select id="streamSelector" onchange="filterData(this, this.value)">
                            <option value="" selected></option>
                            <? while ($row = mysqli_fetch_assoc($result_stream)) { ?>
                                <option value='<?= $row["Streams"] ?>'><?= $row["Streams"] ?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="citySelector">City:</label>
                    </td>
                    <td>
                        <select id="citySelector" onchange="filterData(this, this.value)">
                            <option value="" selected></option>
                            <? while ($row = mysqli_fetch_assoc($result_city)) { ?>
                                <option value='<?= $row['City'] ?>'><?= $row['City'] ?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr>
            </table>

        </fieldset>
        <a class="button" onclick="clearFilters()">Clear Filters</a>
    </div>


    <div class="overflow-buffer">
        <table class="table-separators red-header full-width" id="MyTable">
            <thead>
            <tr>
                <th>Remove</th>
                <th>Edit</th>
                <th>Organization</th>
                <th>Activity</th>
                <th>Stream</th>
                <th>Category</th>
                <!--        Next 3 values are coming from Users Table-->
                <th>Name</th>
                <th>Email</th>
                <th>Timings</th>
            </tr>
            </thead>
            <?php
            for ($i = 0; $i < count($items); $i++) {
                $row = $items[$i];
                    ?>

                    <tr>
                        <td><a class="button" onclick="removeActivity('<?= $row["ID_encrypt"] ?>')"><i
                                        class="fas fa-trash"></i></a></td>
                        <td><a class="button" onclick="editActivity('<?= $row["ID_encrypt"] ?>')"><i
                                        class="fas fa-edit"></i></a></td>
                        <td align="center"><?= $row["organization"] ?></td>
                        <td align="center"><?= $row["activity"] ?></td>
                        <td align="center"><?= $row["stream"] ?></td>
                        <td align="center"><?= $row["category"] ?></td>
                        <td align="center"><?= $row["user_name"] ?> </td>
                        <td align="center"><?= $row["user_email"] ?></td>
                        <td style="font-family: monospace; font-size: 1.25rem; white-space: nowrap;">
                            <? for ($j = 0; $j < count($row["dates"]); $j++) {
                                echo $row["dates"][$j] . " | " . $row["start_time"][$j] . " - " . $row["end_time"][$j] . "<br>";
                            } ?>
                        </td>
                    </tr>
                    <?php
                if (count($items) < 0) {
                    echo "No Activities Found!";
                    break;
                }
            }
            ?>
        </table>
    </div>
    <script id="data" type="application/json"><?= json_encode($items) ?></script>
    <script src="scripts/manage_activity.js"></script>
    <?php include "resources/templates/footer.php"; ?>
