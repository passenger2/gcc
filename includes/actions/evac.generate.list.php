<?php
include("../../initialize.php");
includeCore();
includeListFunctions();

$db_handle = new DBController();
$output = getList($_POST, 'Evac', 0);

echo(json_encode($output));
?>