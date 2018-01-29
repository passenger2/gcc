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
    $answers = explode(",", $answer);
    $answerIDs = explode(",", $keys[4]);
    if(!empty($keys[4]))
    {
        if(sizeof($answers) < sizeof($answerIDs))
        {
            for($i = 0; $i < sizeof($answerIDs); $i++)
            {
                if($keys[1] == '1' && $i < sizeof($answers))
                {
                    #updateAnswers($answerType = '1', $answer = '', $answerID = '0')
                    updateAnswers('1', $answer, $answerIDs[$i]);
                    if(in_array($keys[2], $items))
                    {
                        $score += $answer;
                    }
                } else if($keys[1] == '2' && $i < sizeof($answers))
                {
                    #updateAnswers($answerType = '1', $answer = '', $answerID = '0')
                    updateAnswers('2', $answer, $answerIDs[$i]);
                } else
                {
                    #function deleteAnswers($answerType = '1', $answerID = '0')
                    deleteAnswers('1', $answerIDs[$i]);
                }
            }
            
        } else if(sizeof($answers) > sizeof($answerIDs))
        {
            for($i = 0; $i < sizeof($answers); $i++)
            {
                if($keys[1] == '1' && $i < sizeof($answerIDs))
                {
                    #updateAnswers($answerType = '1', $answer = '', $answerID = '0')
                    updateAnswers('1', $answer, $answerIDs[$i]);
                    if(in_array($keys[2], $items))
                    {
                        $score += $answer;
                    }
                } else if($keys[1] == '2' && $i < sizeof($answerIDs))
                {
                    #updateAnswers($answerType = '1', $answer = '', $answerID = '0')
                    updateAnswers('2', $answer, $answerIDs[$i]);
                } else
                {
                    #insertAnswer($type = 'intake', $answerType = '1', $answer = '', $questionID = '0', $formAnswerID = '0')
                    insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);
                    if(in_array($keys[2], $items) && $keys[1] == '1')
                    {
                        $score += $answer;
                    }
                }
            }
        } else 
        {
            for($i = 0; $i < sizeof($answers); $i++)
            {
                if($keys[1] == '1')
                {
                    #updateAnswers($answerType = '1', $answer = '', $answerID = '0')
                    updateAnswers(1, $answer, $keys[$i]);
                    if(in_array($keys[2], $items))
                    {
                        $score += $answer;
                    }
                } else if($keys[1] == '2')
                {
                    #updateAnswers($answerType = '1', $answer = '', $answerID = '0')
                    updateAnswers(2, $answer, $keys[$i]);
                }
            }
        }
    } else
    {
        insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);
        if(in_array($keys[2], $items) && $keys[1] == '1')
        {
            $score += $answer;
        }
    }
    /*
    Note:
    deleted tanan lol.
    */
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