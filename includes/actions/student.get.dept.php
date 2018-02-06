<?php
include("../../initialize.php");
includeCore();

$db_handle = new DBController();
$collegeID = $_POST["collegeID"];

if(!empty($collegeID)) {
	$db_handle->prepareStatement(
        'SELECT * FROM departments WHERE CollegeID = :CollegeID'
    );
    $db_handle->bindVar(":CollegeID", $collegeID, PDO::PARAM_INT, 0);
    $results = $db_handle->runFetch();
?>
    <option selected disabled>Department</option>
<?php
	foreach($results as $dept) {
?>
	<option value="<?php echo $dept["DepartmentID"]; ?>"><?php echo $dept["DepartmentName"]; ?></option>
<?php
	}
}
?>