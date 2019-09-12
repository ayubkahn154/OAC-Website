<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/18/2018
 * Time: 9:56 PM
 */
include "resources/templates/header.php";
require_once "logic/logic_organization_info.php"

?>
    <h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> <?= $row['organization'] ?></h1>
    <div class="grid-container-organization">
        <div class="orgInfo overflow-buffer">
            <table class="table-separators full-width">
                <tr>
                    <td><b>Address</b></td>
                    <td><?= $row['address'] ?></td>
                </tr>
                <tr>
                    <td><b>City</b></td>
                    <td><?= $row['city'] ?></td>
                </tr>
                <tr>
                <tr>
                    <td><b>Postal Code</b></td>
                    <td><?= $row['postal_code'] ?></td>
                </tr>
                <tr>
                    <td><b>Website</b></td>
                    <td><a href="<?= $row['website'] ?>" target="_blank"><?= $row['website'] ?></a></td>
                </tr>
            </table>
        </div>

    <div class="orgMap">
        <? $address = $row['address'] . "," . $row['city'] . "," . "ON" ?>
        <iframe width='100%' height='100%' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'
                src='http://maps.google.com/maps?&amp;q=<?= $address ?>&output=embed'></iframe>
    </div>
    <div class="irccServices overflow-buffer">

        <? while ($row = mysqli_fetch_array($result_orga_serv, MYSQLI_ASSOC)) {
            array_push($services, $row['serv_id']);
        } ?>
        <br>
        <h3 style="text-align: center"><b>Services Provided</b></h3>
        <br>
        <div class="checkbox-group multi-column">
            <?
            $i = 0; //i is being used for labels to have unique id's
            while ($row = mysqli_fetch_array($result_services, MYSQLI_ASSOC)) {
                $i++;
                ?>
                <div class="checkbox-item">
                    <input
                        <? if (in_array($row['serv_id'], $services)) echo " checked=checked"; ?>
                            type="checkbox" name="services[]" id="checkbox<?= $i ?>" value="<?= $row['serv_id']; ?>"
                            disabled readonly>
                    <label for="checkbox<?= $i ?>"><?= $row['service_name']; ?></label>
                </div>
            <? } ?>
        </div>
    </div>
    <div class="nonIrccServices overflow-buffer">
        <? if (mysqli_num_rows($result_additonal_services) > 0) { ?>

            <h3>Non-IRCC funded Programs:</h3>
            <h4 style="font-size:10px"> ** IRCC = (Immigration, Refugees and Citizenship Canada) **</h4>
            <br/>
            <table class="table-separators red-header full-width">

                <th>#</th>
                <th>Service Name</th>
                <th>Description</th>

                <? $b = 1;
                while ($row = mysqli_fetch_array($result_additonal_services, MYSQLI_ASSOC)) { ?>
                    <tr>
                        <td> <?= $b++; ?> </td>
                        <td> <?= $row['service_name'] ?> </td>
                        <td> <?= $row['description'] ?></td>
                    </tr>
                <? } ?>
            </table>

        <?php } else { ?>
            <br/>
            <div align="center"> No Additional Services</div>
        <?php } ?>
    </div>
    </div>

<?php include "resources/templates/footer.php"; ?>