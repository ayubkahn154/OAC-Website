<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/22/2018
 * Time: 7:09 PM
 */

//add/edit/remove organization
//additional services
//add/remove services
include "resources/templates/header.php";
require_once("logic/logic_manage_organization.php");
$key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
?>
<br>
<h1><a class="icon-button" href="<?= $previous ?>"><i class="fas fa-arrow-circle-left"></i></a> Manage Organization</h1>
<fieldset>
    <legend>Manage Additional Services</legend>
    <!--the user can add services for their organization only.-->
    <label for="organization_name">Organization</label>
    <input type="text" name="organization_name" id="organization_name"
           value="<?= $org_name ?>"
           readonly>
    <?php
            $data_one=$user_organization;
            $orgid_encrypted=my_encrypt($data_one, $key);
    ?>
    <input type="hidden" name="org_id" id="org_id" value="<?= $orgid_encrypted ?>">
    <!--    This if statement will check if the organization have services only then give them options for selecting a service for edit/delete-->
    <?php if (mysqli_num_rows($result_Additional_Services) > 0) { ?>
    <label for="organization_services">Services</label>
    <select name="organization_services" id="organization_services">
            <option value="">Select Service</option>
            <?php while ($row_service = mysqli_fetch_array($result_Additional_Services, MYSQLI_ASSOC)) {
                $data_two = $row_service["id"];
                $ID_encrypted = my_encrypt($data_two, $key);?>
                <option value='<?= $ID_encrypted ?>'><?= $row_service["service_name"] ?></option>
            <?php }?>
    </select>
    <?php }?>

    <input type="button" id="add_non_ircc" value="Add a NON IRCC Service"/>
<!--    This if statement will check if the organization have services only then give them options for edit or delete-->
    <?php if (mysqli_num_rows($result_Additional_Services) > 0) { ?>
    <input type="button" id="edit_non_ircc" value="Edit NON IRCC Service"/>
    <input type="button" id="remove_non_ircc" value="Delete Non IRCC Service"/><br><br>
    <?php } ?>
</fieldset>

<fieldset>

    <legend>Manage Organization</legend>

    <label for="Organization">Organization</label>

    <select name="organization" id="Organization" required>
        <?php if($account==1) { ?>
            <option value="">Select Organization</option>
            <? while ($row = mysqli_fetch_array($result_Organization, MYSQLI_ASSOC)) {
                $data_three =$row["orga_id"];
                $org_id_encrypted = my_encrypt($data_three, $key);
                ?>
                <option value='<?= $org_id_encrypted ?>'><?= $row["organization"] ?></option>
            <? }
        } else{
//            Else it will just pass the session organization id because the account privileges are set to Organization
            ?>
             <option value='<?= $orgid_encrypted ?>'><?= $org_name ?></option>
        <? } ?>
    </select>



    <?php if($account==1){ ?>
    <input type="button" id="add_org" value="Add Organization"/>
    <? } ?>
    <input type="button" id="edit_org" value="Edit Organization"/>
    <?php if($account==1){ ?>
    <input type="button" id="delete_org" value="Remove Organization"/>
    <? } ?>

</fieldset>


<script src="scripts/manage_organization.js"></script>

<?php include "resources/templates/footer.php"; ?>
