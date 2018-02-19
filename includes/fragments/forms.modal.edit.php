<?php
include("../../initialize.php");
includeCore();

$db_handle = new DBController();
$editing = $_GET['editing'];
$id = $_GET['id'];
?>