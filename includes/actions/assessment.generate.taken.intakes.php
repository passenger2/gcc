<?php
include("../../initialize.php");
includeCore();
includeListFunctions();

$db_handle = new DBController();
$output = getList($_POST, 'Intake', $_GET['id']);

echo(json_encode($output));
?>