<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 8/29/2018
 * Time: 3:12 AM
 */

// TODO: Filters to manage activity
// TODO: Mobile view for the header
// TODO: Fix 1 date bug
// TODO: Make DB 3NF
// TODO: Secure DB credentials

if(isset($_GET['status'])) {
    $status = $_GET['status'];
    echo $status . "<br>";
}
if (!isset($_SESSION['Email'])) {
    header("location: index.php");
}

$key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
$account = $_SESSION['Account'];
$org_id = $_SESSION['Organization'];
$sql_org = "SELECT * FROM ymca WHERE orga_id='$org_id'";
$result_org = mysqli_query($conn, $sql_org) or die("Can't get the organization");
$org_result = mysqli_fetch_array($result_org, MYSQLI_ASSOC);
$org_name = $org_result['organization'];

//For filters
$sql_city       = "SELECT DISTINCT City FROM City";
$sql_stream     = "SELECT DISTINCT Streams FROM Streams";
$sql_category   = "SELECT DISTINCT Category FROM Categories";
$sql_services   = "SELECT DISTINCT support_service FROM Support_Services";

$result_city        = mysqli_query($conn, $sql_city) or die('Error getting distinct city');
$result_stream      = mysqli_query($conn, $sql_stream) or die('Error getting distinct streams');
$result_services    = mysqli_query($conn, $sql_services) or die('Error getting distinct services');
$result_category    = mysqli_query($conn, $sql_category) or die('Error getting distinct categories');

$sql_calendar = "SELECT Calendar.*, ymca.organization, Streams.Streams, Categories.Category, City.City 
        FROM Calendar, Streams, Categories, ymca, City
        WHERE Streams.ID=Calendar.Stream_ID 
        AND Categories.ID=Calendar.Category_ID 
        AND ymca.orga_id=Calendar.Organization
        AND City.ID=Calendar.City_ID";

if($account==0){
    $sql_calendar .= " AND Calendar.Organization='$org_id'";
}

$sql_calendar .= " ORDER BY Calendar.ID DESC";
// Get dates, start times and end times for a calendar entry,
// but fetch only those that start on the current date or later
// Format date in a way that javascript can parse
$sql_calendar_dates = "SELECT 
          DATE_FORMAT(`date`, '%d %b %Y') AS `date`, 
          DATE_FORMAT(stime, '%h:%i %p') AS stime,
          DATE_FORMAT(etime, '%h:%i %p') AS etime 
        FROM Calendar_Dates 
        WHERE `date` >= CURRENT_DATE() 
        AND Calendar_ID=";

// Get user information to display it along with activity info
$sql_user_details = "SELECT * FROM Users WHERE ID=";


// Fetch all calendar items to create $items array, which will be
// converted to JSON to display data make JS filters work
    $result_calendar = mysqli_query($conn, $sql_calendar) or die ("Couldn't get calendar items");

// Initialize $items array
    $items = array();

    while ($calendar = mysqli_fetch_assoc($result_calendar)) {

        // Assign ID to a variable to use in concatenation with SQL Select queries
        $activity_id = $calendar["ID"];
        $user_id = $calendar["User"];
        $cal_id_encrypted = my_encrypt($activity_id, $key);

        // Assign values to item from current activity entry
        $item["ID"] = $activity_id;
        $item["ID_encrypt"] = $cal_id_encrypted;
        $item["organization"] = $calendar["organization"];
        $item["activity"] = $calendar["Activity"];
        $item["stream"] = $calendar["Streams"];
        $item["category"] = $calendar["Category"];
        $item["description"] = $calendar["Description"];
        $item["address"] = $calendar["Address"];
        $item["postal_code"] = $calendar["Postal_Code"];
        $item["city"] = $calendar["City"];
        $item["contact_name"] = $calendar["Name"];
        $item["contact_number"] = $calendar["Contact_Num"];
        $item["ext"] = $calendar["EXT"];
        $item["fax"] = $calendar["Fax"];
        $item["email"] = $calendar["Email"];
        $item["website"] = $calendar["Website"];
        $item["dates"] = array();
        $item["start_time"] = array();
        $item["end_time"] = array();

        $result_dates = mysqli_query($conn, $sql_calendar_dates . $activity_id) or die("Unable to get dates");

        // If there are no dates in the future,
        // there will be no rows in the result.
        // In that case, just skip to next calendar item.
        if (mysqli_num_rows($result_dates) == 0) {
            mysqli_free_result($result_dates);
            continue;
        }

        // Fetch dates, start times and end times and add them to their respective arrays
        while ($calendar_dates = mysqli_fetch_assoc($result_dates)) {
            array_push($item["dates"], $calendar_dates["date"]);
            array_push($item["start_time"], $calendar_dates["stime"]);
            array_push($item["end_time"], $calendar_dates["etime"]);
        }

        // Add user data to item
        $result_user = mysqli_query($conn, $sql_user_details . $user_id) or die("Unable to get user info");
        $user_info = mysqli_fetch_assoc($result_user);
        $item["user_name"] = $user_info["First_Name"] . " " . $user_info["Last_Name"];
        $item["user_email"] = $user_info["Email"];

        // Push finished item to $items
        array_push($items, $item);

        // Close result sets
        mysqli_free_result($result_dates);
        mysqli_free_result($result_user);
    }
