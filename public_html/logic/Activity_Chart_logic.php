<?php
/**
 * Created by PhpStorm.
 * User: ayubk
 * Date: 7/4/2018
 * Time: 6:25 AM
 */

$months["0"] = "January";
$months["1"] = "February";
$months["2"] = "March";
$months["3"] = "April";
$months["4"] = "May";
$months["5"] = "June";
$months["6"] = "July";
$months["7"] = "August";
$months["8"] = "September";
$months["9"] = "October";
$months["10"] = "November";
$months["11"] = "December";

echo "<script>";
    echo "const months = Object.freeze(" . json_encode($months) .");";
echo "</script>";


$sql = "SELECT
Calendar.ID, ymca.organization, Calendar.Activity, Streams.Streams, Categories.Category, Calendar.Date,
Calendar.Support_Services, Calendar.start_time, Calendar.end_time, Calendar.Room_Num, Calendar.Street_Num, Calendar.Street_Name, Calendar.Postal_Code,
City.City, Calendar.Name, Calendar.Contact_Num, Calendar.EXT, Calendar.Description, Calendar.Fax, Calendar.Email, Calendar.Website, Calendar.User, Calendar.Target
FROM Calendar
LEFT JOIN (ymca, Categories, Streams, City)
ON (Calendar.Organization = ymca.orga_id
    AND Calendar.Category_ID = Categories.ID
    AND Calendar.Stream_ID = Streams.ID
   	AND Calendar.City_ID = City.ID)
WHERE Date >= CURRENT_DATE()
ORDER BY ymca.organization, Activity, Date";
$result = mysqli_query($conn, $sql) or die('Error getting data');

// Initialize items array
$items = array();

// Initialize temporary variables
$item = array();
$item["organization"] ="";
$item["activity"]="";
$item["ids"] = array();
$item["dateTimes"] = array();

// Reorganize information for display and filtering
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $dt = array();

        // to make sure first empty item is not inserted in items array
        if(!($item["organization"] == "") and !(($item["organization"] == $row["organization"]) and ($item["activity"] == $row["Activity"]))) {
            // Push finished item into items array
            array_push($items, $item);

            // Clear/reinitialize temporary variables
            $item = array();
            $item["organization"] ="";
            $item["activity"]="";
            $item["ids"] = array();
            $item["dateTimes"] = array();

        }

        // Remove microseconds from time and make it 12-hour
        $dt["start_time"] = date("h:i A", strtotime($row["start_time"]));
        $dt["end_time"] = date("h:i A", strtotime($row["end_time"]));

        // Format date in a way that JS is able to access it (YYYY-MM-DD -> DD MMM YYYY)
        $dt["date"] = date("d M Y", strtotime($row["Date"]));

        // Add date and time to date/time array
        array_push($item["dateTimes"], $dt);

        // Add support services as array after removing leading and trailing spaces
        $item["support_services"] = explode(",", $row["Support_Services"]);

        // Add IDs to array after converting to integer
        array_push($item["ids"], intval($row["ID"]));

        $item["organization"] = $row["organization"];
        $item["activity"] = $row["Activity"];
        $item["stream"] = $row["Streams"];
        $item["category"] = $row["Category"];
        $item["room_num"] = $row["Room_Num"];
        $item["street_num"] = $row["Street_Num"];
        $item["street_name"] = $row["Street_Name"];
        $item["postal_code"] = $row["Postal_Code"];
        $item["city"] = $row["City"];
        $item["name"] = $row["Name"];
        $item["contact_num"] = $row["Contact_Num"];
        $item["ext"] = $row["EXT"];
        $item["description"] = $row["Description"];
        $item["fax"] = $row["Fax"];
        $item["email"] = $row["Email"];
        $item["website"] = $row["Website"];
        $item["user"] = $row["User"];
    }
    array_push($items, $item);
}

?>
<!--Send data into a JS script-->
<script>
    let data = <?= json_encode($items) ?>;
    data.forEach(item => {
        item.dateTimes.forEach(date => {
            date.date = new Date(date.date);
        });
    });

</script>

<?
// uncomment following line to see php output on html
//print("<pre>".print_r($items, true)."</pre>");
?>