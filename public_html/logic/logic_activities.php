<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 8/20/2018
 * Time: 12:25 AM
 */

// Create queries that will be used to fetch data

// Get all information from Calendar
// Bind with streams, categories and organizations to get values from IDs

$sql_city       = "SELECT DISTINCT City FROM City";
$sql_stream     = "SELECT DISTINCT Streams FROM Streams";
$sql_services   = "SELECT DISTINCT support_service FROM Support_Services";
$sql_category   = "SELECT DISTINCT Category FROM Categories";

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

// Get all services for a calendar ID
// Binding with support services to get service names instead of IDs
$sql_calendar_services = "SELECT Support_Services.support_service 
        FROM Support_Services, Calendar_Services 
        WHERE Support_Services.ID=Calendar_Services.Services_ID 
        AND Calendar_Services.Calendar_ID=";

// Get all targets for a calendar ID
// Binding with targets table to get target names instead of IDs
$sql_calendar_targets = "SELECT Target.Targets 
        FROM Target, Calendar_Targets 
        WHERE Target.ID=Calendar_Targets.Target_ID 
        AND Calendar_Targets.Calendar_ID=";

//$sql_user_details = "SELECT * FROM Users WHERE ID=";

$result_calendar = mysqli_query($conn, $sql_calendar) or die ("Couldn't get calendar items");

$items = array();

while ($calendar = mysqli_fetch_assoc($result_calendar)) {

    // Assign ID to a variable to use in concatenation with SQL Select queries
    $id = $calendar["ID"];
    // Assign values to item from calendar table
    $item["ID"] = $id;
    $item["organization"] = $calendar["organization"];
    $item["activity"] = html_entity_decode($calendar["Activity"], ENT_QUOTES);
    $item["stream"] = $calendar["Streams"];
    $item["category"] = $calendar["Category"];
    $item["description"] = html_entity_decode($calendar["Description"], ENT_QUOTES);
    $item["address"] = html_entity_decode($calendar["Address"], ENT_QUOTES);
    $item["postal_code"] = $calendar["Postal_Code"];
    $item["city"] = $calendar["City"];
    $item["contact_name"] = $calendar["Name"];
    $item["contact_number"] = $calendar["Contact_Num"];
    $item["ext"] = $calendar["EXT"];
    $item["fax"] = $calendar["Fax"];
    $item["email"] = $calendar["Email"];
    $item["website"] = $calendar["Website"];
    $item["user"] = $calendar["User"];
    $item["dates"] = array();
    $item["start_time"] = array();
    $item["end_time"] = array();
    $item["support_services"] = array();
    $item["targets"] = array();

    // Fetch data
    $result_dates = mysqli_query($conn, $sql_calendar_dates.$id) or die("Unable to get dates");
    $result_services = mysqli_query($conn, $sql_calendar_services.$id) or die("Unable to get services");
    $result_targets = mysqli_query($conn, $sql_calendar_targets.$id) or die("Unable to get targets");

    // If there are no dates in the future,
    // there will be no rows in the result.
    // In that case, just skip to next calendar item.
    if(mysqli_num_rows($result_dates)==0) continue;

    // Fetch dates, start times and end times and add them to their respective arrays
    while($calendar_dates = mysqli_fetch_assoc($result_dates)) {
        array_push($item["dates"], $calendar_dates["date"]);
        array_push($item["start_time"], $calendar_dates["stime"]);
        array_push($item["end_time"], $calendar_dates["etime"]);
    }

    // Fetch services data and assign that to services array
    while($calendar_services = mysqli_fetch_assoc($result_services)) {
        array_push($item["support_services"], html_entity_decode($calendar_services["support_service"], ENT_QUOTES));
    }

    // Fetch target data and assign that to date array

    while($calendar_targets = mysqli_fetch_assoc($result_targets)) {
        array_push($item["targets"], html_entity_decode($calendar_targets["Targets"], ENT_QUOTES));
    }

    // Assign created item to items array
    array_push($items, $item);

    // Close result sets
    mysqli_free_result($result_dates);
    mysqli_free_result($result_targets);
    mysqli_free_result($result_services);
}

?>
