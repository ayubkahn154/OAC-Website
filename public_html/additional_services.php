<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/28/2018
 * Time: 7:25 PM
 */
$previous = "javascript:history.go(-1)";
include "resources/templates/header.php";
require_once("logic/logic_additional_services.php");

if($mode=="edit"){
?>
    <br>
<h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Edit Service</h1>

<?php } else{ ?>

<h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Add Service</h1>
<?php } ?>
<form method="post" action="additional_services.php" name="add_edit_non_ircc_services">
    <fieldset>
        <legend>Add Non-IRCC Service</legend>

        <label for="Service_Name">Service Name</label>
        <input type="text" name="Service_Name" value="<?= $service_name ?>" placeholder="Non_IRCC Service Name" required>

        <label for="Description">Description</label>
        <textarea name="Description" rows="8" cols="100" id="Description" placeholder="Write something about this service" required aria-required="true"><?=  $service_description ?></textarea>

        <input type="hidden" name="org_id" value="<?= $org_id ?>">
        <input type="hidden" name="service_id" value="<?= $service_id ?>">

        <?php if($mode=="edit"){ ?>
            <input type="submit" name="Edit_Service" value="Update Service"/>
        <?php } else{ ?>
            <input type="submit" name="Add_Service" value="Add Service"/>
            <input type="reset" name="Reset" value="Reset"/>
        <?php } ?>

    </fieldset>

</form>


    <?php include "resources/templates/footer.php"; ?>
<script src="scripts/manage_organization.js"></script>

