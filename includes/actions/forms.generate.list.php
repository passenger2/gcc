<?php
include("../../initialize.php");
includeCore();
includeListFunctions();

$db_handle = new DBController();
$output = getList($_POST, 'Tool', 0);

echo(json_encode($output));
?>