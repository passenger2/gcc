<?php
#die(print_r($_POST));
include("../../initialize.php");
includeCore();

$db_handle = new DBController();
$assessmentToolAnswerID = $_GET['atid'];
$studentID = $_GET['sid'];
$post = $_POST;
$score = 0;
$query = "";
foreach($post as $key => $answer)
{
    $keys = explode("-", $key);
    #$keys[0] => assessment tool ID
    #$keys[1] => answer type
    #$keys[2] => question ID
    #$keys[3] => question item number
    #$keys[4] => answer ID
    
    $itemsString = getAutoAssessmentItems($keys[0]);
    $items = explode(",", $itemsString);
    
    if(!empty($keys[4]))
    {
        if($keys[1] == '1')
        {
            $query =
                "UPDATE `quantitativeanswers`
        SET `Answer` = :answer
        WHERE `quantitativeanswers`.`QuantitativeAnswerID` = :answerID";
        } else if($keys[1] == '2')
        {
            $query =
                "UPDATE `qualitativeanswers`
        SET `Answer` = :answer
        WHERE `qualitativeanswers`.`QualitativeAnswerID` = :answerID";
        }

        $db_handle->prepareStatement($query);
        if($keys[1] == '1')
        {
            $db_handle->bindVar(":answer", $answer, PDO::PARAM_INT, 0);
            if(in_array($keys[2], $items))
            {
                $score += $answer;
            }
        } else if($keys[1] == '2')
        {
            $db_handle->bindVar(":answer", $answer, PDO::PARAM_STR, 0);
        }
        $db_handle->bindVar(":answerID", $keys[4], PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    } else
    {
        insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);
        if(in_array($keys[2], $items))
        {
            $score += $answer;
        }
    }
}

$db_handle->prepareStatement(
    "UPDATE `scores`
    SET `Score` = :Score
    WHERE `scores`.`AssessmentToolAnswerID` = :AssessmentToolAnswerID");

$db_handle->bindVar(":AssessmentToolAnswerID", $assessmentToolAnswerID, PDO::PARAM_INT, 0);
$db_handle->bindVar(":Score", $score, PDO::PARAM_INT, 0);

$db_handle->runUpdate();

header("location: /pages/student.assessment.history.php?id=".$studentID."&status=updatetoolsuccess");
?>