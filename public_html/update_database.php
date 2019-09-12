<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/31/2018
 * Time: 12:24 AM
 */
$previous = "javascript:history.go(-1)";
include "resources/templates/header.php";
include "logic/logic_update_database.php";

?>
<h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Update Database</h1>
<div class="adminPanel">
    <div class="sidebarView">
        <div class="sidebar">
            <ul>
                <li id="ServicesTab" onclick="revealContent('Services')">Service</li>
                <li id="Support_ServicesTab" onclick="revealContent('Support_Services')">Support Service</li>
                <li id="TargetTab" onclick="revealContent('Target')">Target</li>
                <li id="CitiesTab" onclick="revealContent('Cities')">City</li>
                <li id="StreamsTab" onclick="revealContent('Streams')">Stream</li>
                <li id="CategoriesTab" onclick="revealContent('Categories')">Category</li>
            </ul>
        </div>
        <div class="main">
            <?= $status; ?>
            <section id="ServicesSection">
                <h2>Services</h2>
                <a class="button" onclick="addNewService()"><i class="fas fa-plus-circle"></i> Add Services</a><br><br>
                <table class="table-separators red-header">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $i = 1;
                    while ($row = mysqli_fetch_array($result_services, MYSQLI_ASSOC)) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row["service_name"] ?></td>
                        <td style="text-align: center">
                            <div class="tooltip">
                                <a class="button" onclick="RemoveService(<?= $row["serv_id"] ?>)"><i class="fas fa-trash"></i></span></a>
                                <span class="tooltiptext">Delete this Service</span>
                            </div>
                        </td>
                    </tr>
                        <? $i++;
                        } ?>
                    </tbody>
                </table>
            </section>
            <section id="Support_ServicesSection">
                <h2>Services</h2>
                <a class="button" onclick="addNewSupport_Service()"><i class="fas fa-plus-circle"></i> Add Support Service</a><br><br>
                <table class="table-separators red-header">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Support Service</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $i = 1;
                    while ($row = mysqli_fetch_array($result_support_services, MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row["support_service"] ?></td>
                            <td style="text-align: center">
                                <div class="tooltip">
                                <a class="button" onclick="RemoveSupport_Service(<?= $row["ID"] ?>)"><i class="fas fa-trash"></i></a>
                                    <span class="tooltiptext">Delete this Support Service</span>
                                </div>
                            </td>
                        </tr>
                        <? $i++;
                    } ?>
                    </tbody>
                </table>
            </section>
            <section id="TargetSection">
                <h2>Targets</h2>
                <a class="button" onclick="addNewTarget()"><i class="fas fa-plus-circle"></i> Add Support Service</a><br><br>
                <table class="table-separators red-header">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Targets</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $i = 1;
                    while ($row = mysqli_fetch_array($result_target, MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row["Targets"] ?></td>
                            <td style="text-align: center">
                                <div class="tooltip">
                                <a class="button" onclick="RemoveTarget(<?= $row["ID"] ?>)"><i class="fas fa-trash"></i></a>
                                    <span class="tooltiptext">Delete this Target</span>
                                </div>
                            </td>

                        </tr>
                        <? $i++;
                    } ?>
                    </tbody>
                </table>
            </section>
            <section id="CitiesSection">
                <h2>Cities</h2>
                <a class="button" onclick="addNewCity()"><i class="fas fa-plus-circle"></i> Add City</a><br><br>
                <table class="table-separators red-header">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>City</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $i = 1;
                    while ($row = mysqli_fetch_array($result_city, MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row["City"] ?></td>
                            <td style="text-align: center">
                                <div class="tooltip">
                                <a class="button" onclick="RemoveCity(<?= $row["ID"] ?>)"><i class="fas fa-trash"></i></a>
                                    <span class="tooltiptext">Delete this City</span>
                                </div>
                            </td>
                        </tr>
                        <? $i++;
                    } ?>
                    </tbody>
                </table>
            </section>
            <section id="StreamsSection">
                <h2>Streams</h2>
                <a class="button" onclick="addNewStream()"><i class="fas fa-plus-circle"></i> Add Stream</a><br><br>
                <table class="table-separators red-header">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Stream</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $i = 1;
                    while ($row = mysqli_fetch_array($result_stream, MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row["Streams"] ?></td>
                            <td style="text-align: center">
                                <div class="tooltip">
                                <a class="button" onclick="RemoveStream(<?= $row["ID"] ?>)"><i class="fas fa-trash"></i></a>
                                    <span class="tooltiptext">Delete this Stream</span>
                                </div>
                            </td>
                        </tr>
                        <? $i++;
                    } ?>
                    </tbody>
                </table>
            </section>
            <section id="CategoriesSection">
                <h2>Categories</h2>
                <a class="button" onclick="addNewCategory()"><i class="fas fa-plus-circle"></i> Add Category</a><br><br>
                <table class="table-separators red-header">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $i = 1;
                    while ($row = mysqli_fetch_array($result_category, MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row["Category"] ?></td>
                            <td style="text-align: center">
                                <div class="tooltip">
                                <a class="button" onclick="RemoveCategory(<?= $row["ID"] ?>)"><i class="fas fa-trash"></i></a>
                                    <span class="tooltiptext">Delete this Category</span>
                                </div>
                            </td>
                        </tr>
                        <? $i++;
                    } ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>
<script src="scripts/update_databaseManager.js"></script>
<script src="scripts/scroll_button.js"></script>

<? include "resources/templates/footer.php" ?>
