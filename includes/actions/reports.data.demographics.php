<?php
include("../../initialize.php");
includeCore();
includeVisualizationFunctions();

$db_handle = new DBController();
$output = getData('CollegePopulation', $_SESSION["CollegeID"]);

echo(json_encode($output));
?>