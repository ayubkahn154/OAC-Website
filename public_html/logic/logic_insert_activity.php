<?php
/**
 * Created by PhpStorm.
 * User: SYSTEM
 * Date: 8/2/2018
 * Time: 5:11 AM
 */

// Redirect user if no login
if (!isset($_SESSION['Email'])) {
    header("location: index.php");
}

$mode = "";
$ID="";



//Getting the mode from javascript
if(isset($_GET['mode'])){
    $mode=$_GET['mode'];

    if(isset($_GET['status'])) {
        $status = $_GET['status'];
        echo $status;
    }

    if($mode=="delete" || $mode=="edit") {
        if (isset($_GET['ID'])){
            $encrypted_ID = $_GET['ID'];
            $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
            $ID = my_decrypt( $encrypted_ID, $key);
        }
    }
}

$user_address = "";
$user_postal = "";
$user_city = "";
$stream_edit = "";
$category_edit = "";
$activity_edit = "";
$address_edit = "";
$postal_code_edit = "";
$city_edit = "";
$name_edit = "";
$contact_number_edit = "";
$ext_edit = "";
$description_edit = "";
$fax_edit = "";
$email_edit = "";
$services = array();
$targets = array();

$calendar_id = null;
$user_id = $_SESSION['User_ID'];
$organization_id = $_SESSION['Organization'];
//echo "<pre>USR ID: " . print_r($user_id, true) . "<br>ORG ID: " . print_r($organization_id, true) . "</pre>";

$sql_distinct_activities = "SELECT DISTINCT Activity FROM Calendar WHERE Organization='$organization_id'";
$sql_category = "SELECT * FROM Categories";
$sql_target = "SELECT * FROM Target";
$sql_stream = "SELECT * FROM Streams";
$sql_services = "SELECT * FROM Support_Services";
$sql_city = "SELECT * FROM City";

$result_distinct_activities = mysqli_query($conn, $sql_distinct_activities) or die('Error getting calendar');
$result_category = mysqli_query($conn, $sql_category) or die('Error getting Categories');
$result_target = mysqli_query($conn, $sql_target) or die('Error getting Target');
$result_stream = mysqli_query($conn, $sql_stream) or die('Error getting Streams');
$result_support_services = mysqli_query($conn, $sql_services) or die('Error getting Support_Services');
$result_city = mysqli_query($conn, $sql_city) or die('Error getting City');

$sql_website = "SELECT * FROM ymca WHERE orga_id = '$organization_id'";
$result_sql_website = mysqli_query($conn, $sql_website) or die("Cannot get the website access");
$row_org_website = mysqli_fetch_array($result_sql_website, MYSQLI_ASSOC);
$user_website = $row_org_website["website"];

// If adding activity
if($mode=="add") {

    $user_address = $row_org_website["address"];
    $user_postal = $row_org_website["postal_code"];
    $user_city = $row_org_website["city"];
}

// If editing activity
    if ($mode=="edit") {
    $sql_calendar = "SELECT * FROM Calendar WHERE ID='$ID'";
    $result_calendar = mysqli_query($conn, $sql_calendar) or die ("Can't get Calendar details");

    $sql_calendar_dates = "SELECT * FROM Calendar_Dates WHERE Calendar_ID='$ID'";
    $result_calendar_dates = mysqli_query($conn, $sql_calendar_dates) or die("Can't get dates");

    $sql_calendar_services = "SELECT * FROM Calendar_Services WHERE Calendar_ID='$ID'";
    $result_calendar_services = mysqli_query($conn, $sql_calendar_services) or die("Can't get services");

    $sql_calendar_targets = "SELECT * FROM Calendar_Targets WHERE Calendar_ID='$ID'";
    $result_calendar_targets = mysqli_query($conn, $sql_calendar_targets) or die("Can't get targets");

    $row_edit_calendar = mysqli_fetch_assoc($result_calendar);

    $stream_edit = $row_edit_calendar["Stream_ID"];
    $category_edit = $row_edit_calendar["Category_ID"];
    $activity_edit = $row_edit_calendar["Activity"];

    $user_address = $row_edit_calendar["Address"];
    $user_postal = $row_edit_calendar["Postal_Code"];
    $user_city = $row_edit_calendar["City_ID"];

    $name_edit = $row_edit_calendar["Name"];
    $contact_number_edit = $row_edit_calendar["Contact_Num"];
    $ext_edit = $row_edit_calendar["EXT"];
    $description_edit = $row_edit_calendar["Description"];
    $fax_edit = $row_edit_calendar["Fax"];
    $email_edit = $row_edit_calendar["Email"];

    while ($row_edit_services = mysqli_fetch_assoc($result_calendar_services)) {
        array_push($services, $row_edit_services['Services_ID']);
    }

    while ($row_edit_targets = mysqli_fetch_assoc($result_calendar_targets)) {
        array_push($targets, $row_edit_targets['Target_ID']);
    }

    $datetimes = array();
    while ($row = mysqli_fetch_assoc($result_calendar_dates)) {
        $datetime = array();
        array_push($datetime, $row["date"]);
        array_push($datetime, $row["stime"]);
        array_push($datetime, $row["etime"]);
        array_push($datetimes, $datetime);
    }

    echo "<script> let editData = " . json_encode($datetimes) . ";</script>";
}
    if(isset($_POST['edit'])){

        $ID = $_POST['ID'];
        $stream_edit = $_POST['stream'];
        $category_edit = $_POST['category'];
        $activity_edit = $_POST['activity'];
        $activity_edit = htmlentities($activity_edit, ENT_QUOTES);

        $address_edit = $_POST['address'];
        $address_edit = htmlentities($address_edit, ENT_QUOTES);

        $postal_code_edit = $_POST['postal_code'];
        $city_edit = $_POST['city'];
        $name_edit = $_POST['name'];
        $contact_number_edit = $_POST['contact_number'];
        $ext_edit = $_POST['ext'];
        $description_edit = $_POST['description'];
        $description_edit = htmlentities($description_edit, ENT_QUOTES);

        $fax_edit = $_POST['fax'];
        $email_edit = $_POST['email'];
        $website = $user_website;
        $user_id = $_SESSION['User_ID'];


        echo $ID . "<br>";
        $sql_update_calendar="UPDATE Calendar SET Stream_ID='$stream_edit', Category_ID='$category_edit', Activity='$activity_edit', Address='$address_edit', Postal_Code='$postal_code_edit', City_ID='$city_edit', Name='$name_edit', Contact_Num='$contact_number_edit', EXT='$ext_edit', Description='$description_edit', Fax='$fax_edit', Email='$email_edit', Website='$website', User='$user_id' WHERE ID='$ID'";
        echo $sql_update_calendar;
        $result_update_calendar = mysqli_query($conn, $sql_update_calendar) or die("Can't Update Calendar");

        $sql_calendar_services = "DELETE FROM Calendar_Services WHERE Calendar_ID = '$ID'";
        $result_calendar_services = mysqli_query($conn, $sql_calendar_services) or die("Can't delete services");

        $sql_calendar_targets = "DELETE FROM Calendar_Targets WHERE Calendar_ID = '$ID'";
        $result_calendar_targets=mysqli_query($conn, $sql_calendar_targets) or die("Can't delete targets");

        $sql_calendar_dates = "DELETE FROM Calendar_Dates WHERE Calendar_ID='$ID'";
        $result_calendar_dates = mysqli_query($conn, $sql_calendar_dates) or die("Can't delete date");

        // Add data to Calendar_Dates
        $sql_insert = "INSERT INTO Calendar_Dates(Calendar_ID, date, stime, etime) VALUES ";
        $dates = $_POST['event_date'];
        $start_times = $_POST['event_start_time'];
        $end_times = $_POST['event_end_time'];
        $datetime_array = array();
        for ($i = 0; $i < count($dates); $i++) {
            $str = "('" . $ID . "','" . $dates[$i] . "','" . $start_times[$i] . "','" . $end_times[$i] . "')";
            array_push($datetime_array, $str);
        }
        $sql_insert .= implode(",", $datetime_array);
        mysqli_query($conn, "LOCK TABLE Calendar_Dates WRITE") or die("Unable to lock Calendar_Dates");
        echo "<pre> SQL Query for inserting to calendar_dates:<br>" . $sql_insert . "</pre>";
        $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert into Calendar_Dates");
        mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar_Dates");

        // Add data to Calendar_Targets
        $sql_insert = "INSERT INTO Calendar_Targets(Calendar_ID, Target_ID) VALUES ";
        $targets = $_POST['targets'];
        $target_array = array();
        for ($i = 0; $i < count($targets); $i++) {
            $target_str = "('" . $ID . "','" . $targets[$i] . "')";
            array_push($target_array, $target_str);
        }
        $sql_insert .= implode(",", $target_array);
        mysqli_query($conn, "LOCK TABLE Calendar_Targets WRITE") or die("Unable to lock Calendar_Targets");
        echo "<pre> SQL Query for inserting to calendar_targets:<br>" . $sql_insert . "</pre>";
        $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert into Calendar_Targets");
        mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar_Targets");

        // Add data to Calendar_Services
        $sql_insert = "INSERT INTO Calendar_Services(Calendar_ID, Services_ID) VALUES ";
        $services = $_POST['services'];
        $services_array = array();
        for ($i = 0; $i < count($services); $i++) {
            $service_str = "('" . $ID . "','" . $services[$i] . "')";
            array_push($services_array, $service_str);
        }
        $sql_insert .= implode(",", $services_array);
        mysqli_query($conn, "LOCK TABLE Calendar_Services WRITE") or die("Unable to lock Calendar_Services");
        echo "<pre> SQL Query for inserting to calendar_services:<br>" . $sql_insert . "</pre>";
        $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert Calendar_Services");
        mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar_Services");
        $status="Update Successful";
        header("location: manage_activity.php?status=".$status);
    }
if (isset($_POST['add'])) {
    // Add data to calendar

    $sql_insert = "INSERT INTO Calendar(
            Organization, Stream_ID, Category_ID, 
            Activity, Address, Postal_Code, 
            City_ID, Name, Contact_Num, 
            EXT, Description, Fax, 
            Email, Website, User) VALUES ";
    // Add data to Calendar
    $stream = "'" . $_POST['stream'] . "'";
    $category = "'" . $_POST['category'] . "'";
    $activity = "'" . $_POST['activity'] . "'";
    $address = "'" . htmlentities($_POST['address'], ENT_QUOTES) . "'";
    $postal_code = "'" . htmlentities($_POST['postal_code'], ENT_QUOTES) . "'";
    $city = "'" . htmlentities($_POST['city'], ENT_QUOTES) . "'";
    $name = "'" . htmlentities($_POST['name'], ENT_QUOTES) . "'";
    $contact_number = "'" . htmlentities($_POST['contact_number'], ENT_QUOTES) . "'";

    // If $_POST exists, then use values. Otherwise, insert NULL
    $ext = $_POST['ext'] ? "'" . htmlentities($_POST['ext'], ENT_QUOTES) . "'" : "NULL";
    $description = $_POST['description'] ? "'" . htmlentities($_POST['description'], ENT_QUOTES) . "'" : "NULL";
    $fax = $_POST['fax'] ? "'" . htmlentities($_POST['fax'], ENT_QUOTES) . "'" : "NULL";
    $email = $_POST['email'] ? "'" . htmlentities($_POST['email'], ENT_QUOTES) . "'" : "NULL";
    $user_id = $_SESSION['User_ID'];

    $query = array(
        "'" . $organization_id . "'",
        $stream,
        $category,
        $activity,
        $address,
        $postal_code,
        $city,
        $name,
        $contact_number,
        $ext,
        $description,
        $fax,
        $email,
        "'" . $user_website . "'",
        "'" . $user_id . "'"
    );

    $sql_insert .= "(" . implode(",", $query) . ")";
    echo $sql_insert;
    mysqli_query($conn, "LOCK TABLE Calendar WRITE") or die("Unable to lock Calendar");
    echo "<pre> SQL Query for inserting to calendar:<br>" . $sql_insert . "</pre>";
    $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert into Calendar");
    $calendar_id = mysqli_insert_id($conn);
    mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar");
    echo "<pre> Calendar ID returned: " . $calendar_id . "</pre>";

    // Add data to Calendar_Dates
    $sql_insert = "INSERT INTO Calendar_Dates(Calendar_ID, date, stime, etime) VALUES ";
    $dates = $_POST['event_date'];
    $start_times = $_POST['event_start_time'];
    $end_times = $_POST['event_end_time'];
    $datetime_array = array();
    for ($i = 0; $i < count($dates); $i++) {
        $str = "('" . $calendar_id . "','" . $dates[$i] . "','" . $start_times[$i] . "','" . $end_times[$i] . "')";
        array_push($datetime_array, $str);
    }
    $sql_insert .= implode(",", $datetime_array);
    mysqli_query($conn, "LOCK TABLE Calendar_Dates WRITE") or die("Unable to lock Calendar_Dates");
    echo "<pre> SQL Query for inserting to calendar_dates:<br>" . $sql_insert . "</pre>";
    $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert into Calendar_Dates");
    mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar_Dates");

    // Add data to Calendar_Targets
    $sql_insert = "INSERT INTO Calendar_Targets(Calendar_ID, Target_ID) VALUES ";
    $targets = $_POST['targets'];
    $target_array = array();
    for ($i = 0; $i < count($targets); $i++) {
        $target_str = "('" . $calendar_id . "','" . $targets[$i] . "')";
        array_push($target_array, $target_str);
    }
    $sql_insert .= implode(",", $target_array);
    mysqli_query($conn, "LOCK TABLE Calendar_Targets WRITE") or die("Unable to lock Calendar_Targets");
    echo "<pre> SQL Query for inserting to calendar_targets:<br>" . $sql_insert . "</pre>";
    $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert into Calendar_Targets");
    mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar_Targets");

    // Add data to Calendar_Services
    $sql_insert = "INSERT INTO Calendar_Services(Calendar_ID, Services_ID) VALUES ";
    $services = $_POST['services'];
    $services_array = array();
    for ($i = 0; $i < count($services); $i++) {
        $service_str = "('" . $calendar_id . "','" . $services[$i] . "')";
        array_push($services_array, $service_str);
    }
    $sql_insert .= implode(",", $services_array);
    mysqli_query($conn, "LOCK TABLE Calendar_Services WRITE") or die("Unable to lock Calendar_Services");
    echo "<pre> SQL Query for inserting to calendar_services:<br>" . $sql_insert . "</pre>";
    $result_insert = mysqli_query($conn, $sql_insert) or die("Failed to insert Calendar_Services");
    mysqli_query($conn, "UNLOCK TABLES") or die("Unable to unlock Calendar_Services");
    $status="Insertion Successful";
    header("location: manage_activity.php?status=".$status);
}

 // If deleting activity
else if($mode=="delete") {

    $sql_calendar_dates = "DELETE FROM Calendar_Dates WHERE Calendar_ID='$ID'";
    $result_calendar_dates = mysqli_query($conn, $sql_calendar_dates) or die("Can't delete date's");

    $sql_calendar_services = "DELETE FROM Calendar_Services WHERE Calendar_ID = '$ID'";
    $result_calendar_services = mysqli_query($conn, $sql_calendar_services) or die("Can't delete services");

    $sql_calendar_targets = "DELETE FROM Calendar_Targets WHERE Calendar_ID = '$ID'";
    $result_calendar_targets=mysqli_query($conn, $sql_calendar_targets) or die("Can't delete targets");

    $sql_calendar = "DELETE FROM Calendar WHERE ID = '$ID'";
    $result_calendar = mysqli_query($conn,$sql_calendar) or die ("Can't delete Calendar details");

    header("location: manage_activity.php?status=Successfully deleted");

//} else{
//    header("location: activities.php");
}// If none of the above, display activities

