<?php
include("../../initialize.php");
includeCore();

$assessmentAnswerID = $_GET['id'];

$db_handle = new DBController();

$db_handle->prepareStatement(
    "DELETE FROM `quantitativeanswers`
    WHERE AssessmentToolAnswerID = :assessmentAnswerID1;
    DELETE FROM `qualitativeanswers`
    WHERE AssessmentToolAnswerID = :assessmentAnswerID2;"
);

$db_handle->bindVar(":assessmentAnswerID1", $assessmentAnswerID, PDO::PARAM_INT, 0);
$db_handle->bindVar(":assessmentAnswerID2", $assessmentAnswerID, PDO::PARAM_INT, 0);
$db_handle->runUpdate();



if($db_handle->getUpdateStatus())
{
    $db_handle->prepareStatement("UPDATE `scores` SET `Score` = '0' WHERE `scores`.`AssessmentToolAnswerID` = :assessmentAnswerID");
    $db_handle->bindVar(':assessmentAnswerID', $assessmentAnswerID, PDO::PARAM_INT,0);
    $db_handle->runUpdate();
    
    header("location: /pages/assessment.view.answers.tool.php?id=".$assessmentAnswerID."&status=deleteanswerssuccess");
} else
{
    header("location: /pages/assessment.view.answers.tool.php?id=".$assessmentAnswerID."&status=deleteanswerserror");
}
?>