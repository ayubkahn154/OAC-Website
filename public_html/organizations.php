<?php

include "resources/templates/header.php";
require_once "logic/logic_organizations.php";
?>


<h1>Organizations</h1>
<form action="organizations.php" method="get">
    <h2>Filters</h2>
    <p><b>Search by location and type of service you are looking for, to get help.</b></p>
    <br>
    <table>
        <tr>
            <td>
                <div class="checkbox-group multi-column">
                    <?
                    $i = 0; //i is being used for labels to have unique id's
                    while ($row = mysqli_fetch_array($result_services, MYSQLI_ASSOC)) {
                        $i++;
                        ?>
                        <div class="checkbox-item">
                            <input
                                <? if (in_array($row['serv_id'], $services)) echo " checked=checked"; ?>
                                    type="checkbox" name="services[]" id="checkbox<?= $i ?>"
                                    value="<?= $row['serv_id']; ?>">
                            <label for="checkbox<?= $i ?>"><?= $row['service_name']; ?></label>
                        </div>
                    <? } ?>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <label for="city">Filter by City</label>
    <select name="city" id="city">
        <option value="">Choose City</option>
        <?php
        while ($row = mysqli_fetch_array($result_city, MYSQLI_ASSOC)) { ?>

            <option <? if ($city == $row['ID']) echo "selected=selected"; ?>
                    value="<?php echo $row['ID'] ?>"><?php echo $row['City'] ?></option>
        <?php } ?>
    </select>

    <br>
    <br>
    <input type="submit" value="Search">

    <?php if ((!empty($_GET)) && empty($_GET['services']) && empty($_GET['city']))
        echo "<div style=\"color:red;\"><strong>Please select a search option </strong></div>"; ?>
    <br>
    <br>
</form>
<div class="overflow-buffer">
    <?
    if (mysqli_num_rows($result) > 0) { ?>
    <table class="table-separators red-header full-width">
        <thead>
        <tr>
            <th>ORGANIZATION</th>
            <th>ADDRESS</th>
            <th>CITY</th>
            <th>POSTAL CODE</th>
            <th>WEBSITE</th>
        </tr>
        </thead>
        <tbody>
        <? while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
            <tr>
                <td>
                    <a href="organization_info.php?orga_id=<?= $row['orga_id'] ?>"> <?= $row['organization'] ?> </a>
                </td>
                <td><?= $row['address'] ?></td>
                <td><?= $row['City'] ?></td>
                <td><?= $row['postal_code'] ?></td>
                <td><a href="<?= $row['website'] ?>" target="_blank"><?= $row['website'] ?></a></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
</div>

<? } else { ?>
    <span style='color:red; width: 100%; align=center'>No Records found!</span>
<? }

include "resources/templates/footer.php"; ?>

