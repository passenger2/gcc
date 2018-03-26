<?php
include("../../initialize.php");
includeCore();
includeVisualizationFunctions();

$db_handle = new DBController();
$output = getPassFail($_GET['atid'], $_SESSION["CollegeID"]);

echo(json_encode($output));
?>