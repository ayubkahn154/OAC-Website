<?
//building $sql depending on the data entry on the UI
$city = "";
$sql = "SELECT orga_id, organization, address, City.City, postal_code, phone, fax, website FROM ymca LEFT JOIN (City) ON(City.ID=ymca.city)";
$services = array();
$sql_city = "SELECT * FROM City";
$result_city = mysqli_query($conn, $sql_city) or die("Can't get cities");

if (isset($_GET['services'])) {
    $sql .= " WHERE ";
    if (isset($_GET['services'])) {
        $services = $_GET['services'];
        $sql .= " (ymca.orga_id IN (
        SELECT orga_id 
        FROM orga_serv
        WHERE orga_id=ymca.orga_id 
        AND serv_id IN(" . implode(',', $services) . ") ))";
    }

    if (isset($_GET['city'])) {

        $city = $_GET['city'];
        if ($city != "") {
            $sql .= " and (City.ID='$city') ";
        }
    }
}

if (isset($_GET['city']) && !isset($_GET['services'])) {
    $city = $_GET['city'];
    if ($city != "") {
        $sql .= " WHERE (City.ID='$city') ";
    }
}

$sql .= " ORDER BY organization ASC";
$result = mysqli_query($conn, $sql) or die("Can't run this query");

$sql_services = "SELECT * FROM services";
$result_services = mysqli_query($conn, $sql_services) or die("Can't get services");


//$row['city'] = $city['City'];
?>
