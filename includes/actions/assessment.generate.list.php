<?php
include("../../initialize.php");
includeCore();
includeListFunctions();

$db_handle = new DBController();
$output = getList($_POST, 'Student', 0);

echo(json_encode($output));
?>