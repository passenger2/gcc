<?php
include("../../initialize.php");
includeCore();
#die(print_r($_POST));
$db_handle = new DBController();
$studentID = $_GET['id'];
$ageGroup = $_GET['ag'];
$intakeID = getIntakeID($ageGroup);
$post = $_POST; //$key for this array is in the format x-y where x = answertype & y = questionID
$tempAnswerType = "";
$tempQID = "";
$query = "";
$paramNum = 0;

$db_handle->prepareStatement(
    "INSERT INTO `intakeformanswers` (
        `IntakeFormAnswerID`,
        `IntakeFormID`,
        `StudentID`,
        `ActiveUserID`,
        `DateTaken`)
    VALUES (
        NULL,
        :intakeID,
        :studentID,
        :userID,
        CURRENT_TIMESTAMP)");

$db_handle->bindVar(':intakeID', $intakeID, PDO::PARAM_INT,0);
$db_handle->bindVar(':studentID', $studentID, PDO::PARAM_STR,0);
$db_handle->bindVar(':userID', $_SESSION['UserID'], PDO::PARAM_INT,0);
$db_handle->runUpdate();

/*
$intakeAnswersID = $db_handle->getLastInsertID();

foreach($post as $key => $answers)
{
    $tempKeys = explode('-', $key);
    $tempAnswerType = $tempKeys[0];
    $tempQID = $tempKeys[1];
    if($tempAnswerType == '1')
    {
        $paramNum++;
        $query .= 
            "INSERT INTO `quantitativeanswers` ( 
                    `QuantitativeAnswerID`, 
                    `Answer`, 
                    `QuestionID`, 
                    `AssessmentToolAnswerID`, 
                    `IntakeFormAnswerID`)
                VALUES (
                    NULL,
                    :answer".$paramNum.",
                    :qid".$paramNum.",
                    NULL,
                    :faid".$paramNum.");";

        $parameters[] = array('answer'.$paramNum => $answers, 'qid'.$paramNum => $tempQID, 'faid'.$paramNum => $intakeAnswersID, 'type'.$paramNum => 'quanti');
    } else if($tempAnswerType == '2')
    {
        $paramNum++;
        if($answers == '')
        {
            $query .=
                "INSERT INTO `qualitativeanswers` (
                        `QualitativeAnswerID`,
                        `Answer`,
                        `QuestionID`,
                        `AssessmentToolAnswerID`,
                        `IntakeFormAnswerID`)
                    VALUES (
                        NULL,
                        :answer".$paramNum.",
                        :qid".$paramNum.",
                        NULL,
                        :faid".$paramNum.");";

            $parameters[] = array('answer'.$paramNum => "(blank)", 'qid'.$paramNum => $tempQID, 'faid'.$paramNum => $intakeAnswersID, 'type'.$paramNum => 'quali');
        } else {
                $query .=
                    "INSERT INTO `qualitativeanswers` (
                        `QualitativeAnswerID`,
                        `Answer`,
                        `QuestionID`,
                        `AssessmentToolAnswerID`,
                        `IntakeFormAnswerID`)
                    VALUES (
                        NULL,
                        :answer".$paramNum.",
                        :qid".$paramNum.",
                        NULL,
                        :faid".$paramNum.");";
                
                $parameters[] = array('answer'.$paramNum => $answers, 'qid'.$paramNum => $tempQID, 'faid'.$paramNum => $intakeAnswersID, 'type'.$paramNum => 'quali');
            }
    }

    $tempAnswerType = "";
    $tempQID = "";
    $tempKeys = [];

}

$db_handle->prepareStatement($query);
$paramNum = 0;

foreach($parameters as $param)
{
    $paramNum++;

    if($param['type'.$paramNum] == 'quanti')
    {
        $db_handle->bindVar(':answer'.$paramNum, $param['answer'.$paramNum], PDO::PARAM_INT,0);
    } else
    {
        $db_handle->bindVar(':answer'.$paramNum, $param['answer'.$paramNum], PDO::PARAM_STR,0);
    }

    $db_handle->bindVar(':qid'.$paramNum, $param['qid'.$paramNum], PDO::PARAM_INT,0);
    $db_handle->bindVar(':faid'.$paramNum, $param['faid'.$paramNum], PDO::PARAM_INT,0);
}

$db_handle->runUpdate();
*/

if($db_handle->getUpdateStatus())
{
    header("location: /pages/student.assessment.history.php?id=".$studentID."&ag=".$ageGroup."&status=intakesuccess");
}
?>