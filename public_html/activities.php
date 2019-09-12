<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/3/2018
 * Time: 8:33 AM
 */

include 'resources/templates/header.php';
require_once("logic/logic_activities.php");


?>
    <h1>Activities</h1>
    <div class="sidebarView">
        <div class="sidebar">
            <h2>Filters</h2>
            <p><b>Search by location and type of service you are looking for, to get help.</b></p>
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
                <br></fieldset>
            <a class="button" onclick="clearFilters()">Clear Filters</a>
            
        </div>
        <div class="content">
            <h2>Events</h2>
            <div id="eventsTable"></div>
        </div>
    </div>
    <div id="modal">
        <div id="modalBox">
            <div id="modalTitleBar">
                <div id="topBar">
                    <span id="streamTitle">Stream...</span>
                    <span id="modalCloseButton">&times;</span>
                </div>
                <div id="modalTitle">Activity</div>
            </div>
            <div id="modalContent" class="grid-container-modal"></div>
        </div>
    </div>
    <script>

        let data = <?= json_encode($items) ?>;
        // Convert PHP dates to JS dates
        for (let i = 0; i < data.length; i++) {
            let item = data[i];
            for (let j = 0; j < item.dates.length; j++) {
                item.dates[j] = new Date(item.dates[j]);
            }
        }
    </script>
    <script src="scripts/eventManager.js"></script>

<?php include 'resources/templates/footer.php'; ?>