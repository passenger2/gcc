<?php
include("../../initialize.php");
includeCore();

$searchString = $_GET['term'];
$data = [];

$db_handle = new DBController();
$db_handle->prepareStatement(
    "SELECT
        BarangayID,
        CONCAT(barangays.BarangayName,', ', cities.CityName, ', ', province.ProvinceName) AS Address
        FROM `barangays`
        LEFT JOIN cities
            ON cities.CityCode = barangays.CityCode
        LEFT JOIN province
            ON province.ProvinceCode = cities.ProvinceCode
        WHERE CONCAT(barangays.BarangayName,', ', cities.CityName, ', ', province.ProvinceName) LIKE :searchString
        ORDER BY barangays.BarangayName
        LIMIT 10;");

$db_handle->bindVar(":searchString", $searchString."%", PDO::PARAM_STR,0);
$results = $db_handle->runFetch();
#die(print_r($results));

foreach($results as $key => $result)
{   
    $tempArray = [];
    
    $tempArray['value'] = $result['BarangayID'];
    $tempArray['label'] = $result['Address'];
    array_push($data,$tempArray);
}

#die(print_r($data));
echo(json_encode($data));
?>