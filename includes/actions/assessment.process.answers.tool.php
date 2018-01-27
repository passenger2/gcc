<?php
#die(print_r($_POST));
include("../../initialize.php");
includeCore();
$studentID = $_GET['id'];
$db_handle = new DBController();
$post = $_POST;
$assessmentToolIDs = [];
#die(print_r($assessmentToolIDs));
$assessmentToolAnswerID = '';
$tempScore = 0;

foreach($post as $key => $answer)
{
    $keys = explode("-", $key);
    #$keys[0] => assessment tool ID
    #$keys[1] => answer type
    #$keys[2] => question ID
    #$keys[3] => question item number
    if($keys[0] != 'end' && $keys[0] != 9)
    {
        if(!in_array($keys[0], $assessmentToolIDs))
        {
            $query =
                "INSERT INTO `assessmenttoolanswers` (
                `AssessmentToolAnswerID`,
                `ActiveUserID`,
                `AssessmentToolID`,
                `DateTaken`,
                `StudentID`)
            VALUES (
                NULL,
                :ActiveUserID,
                :AssessmentToolID,
                CURRENT_TIMESTAMP,
                :StudentID)";

            $db_handle->prepareStatement($query);
            $db_handle->bindVar(":ActiveUserID", $_SESSION['UserID'], PDO::PARAM_INT, 0);
            $db_handle->bindVar(":AssessmentToolID", $keys[0], PDO::PARAM_INT, 0);
            $db_handle->bindVar(":StudentID", $studentID, PDO::PARAM_STR, 0);

            $db_handle->runUpdate();
            $assessmentToolAnswerID = $db_handle->getLastInsertID();

            #get 'autoAssessments' Items for score calculation check
            $itemsString = getAutoAssessmentItems($keys[0]);
            $items = explode(",", $itemsString);

            #if questionID is in Items list, increment score by answer
            if(in_array($keys[2], $items) && $keys[1] == '1')
            {
                $tempScore += $answer;
            }
            
            insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);

            $assessmentToolIDs[] = $keys[0];
        } else
        {
            #if questionID is in Items list, increment score by answer
            if(in_array($keys[2], $items) && $keys[1] == '1')
            {
                $tempScore += $answer;
            }
            
            insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);
        }
    } else if ($keys[0] == 9)
    {
        if(!in_array($keys[0], $assessmentToolIDs))
        {
            $query =
                "INSERT INTO `assessmenttoolanswers` (
                `AssessmentToolAnswerID`,
                `ActiveUserID`,
                `AssessmentToolID`,
                `DateTaken`,
                `StudentID`)
            VALUES (
                NULL,
                :ActiveUserID,
                :AssessmentToolID,
                CURRENT_TIMESTAMP,
                :StudentID)";

            $db_handle->prepareStatement($query);
            $db_handle->bindVar(":ActiveUserID", $_SESSION['UserID'], PDO::PARAM_INT, 0);
            $db_handle->bindVar(":AssessmentToolID", $keys[0], PDO::PARAM_INT, 0);
            $db_handle->bindVar(":StudentID", $studentID, PDO::PARAM_STR, 0);

            $db_handle->runUpdate();
            $assessmentToolAnswerID = $db_handle->getLastInsertID();

            #get 'autoAssessments' Items for score calculation check
            $itemsString = getAutoAssessmentItems($keys[0]);
            $itemGroup = explode("-", $itemsString);

            $nonReverseItems = explode(",", $itemGroup[0]);
            $reverseItems = explode(",", $itemGroup[1]);
            
            #if questionID is in $nonReverseItems list, increment score by answer
            if(in_array($keys[2], $nonReverseItems) && $keys[1] == '1')
            {
                $tempScore += $answer;
            #else if questionID is in $reverseItems list, increment score by reverse of item answer
            } else if (in_array($keys[2], $reverseItems) && $keys[1] == '1')
            {
                $tempScore += abs($answer-3);
            }
            
            insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);
            $assessmentToolIDs[] = $keys[0];
        } else
        {
            #if questionID is in $nonReverseItems list, increment score by answer
            if(in_array($keys[2], $nonReverseItems) && $keys[1] == '1')
            {
                $tempScore += $answer;
            #else if questionID is in $reverseItems list, increment score by reverse of item answer
            } else if (in_array($keys[2], $reverseItems) && $keys[1] == '1')
            {
                $tempScore += abs($answer-3);
            }
            
            insertAnswer('tool', $keys[1], $answer, $keys[2], $assessmentToolAnswerID);
        }
    }
    else {
        if(!empty($assessmentToolAnswerID))
        {
            $db_handle->prepareStatement(
                "INSERT INTO `scores` (
                    `ScoreID`,
                    `AssessmentToolAnswerID`,
                    `Score`,
                    `Category`)
                VALUES (
                    NULL,
                    :AssessmentToolAnswerID,
                    :Score,
                    NULL)");
            
            $db_handle->bindVar(":AssessmentToolAnswerID", $assessmentToolAnswerID, PDO::PARAM_INT, 0);
            $db_handle->bindVar(":Score", $tempScore, PDO::PARAM_INT, 0);
            
            $db_handle->runUpdate();
            
            $assessmentToolAnswerID = '';
            $tempScore = 0;
        }
        
        #$keys[0] = end
        #$keys[1] = assessment tool ID
        if(!in_array($keys[1], $assessmentToolIDs))
        {
            $query =
                "INSERT INTO `assessmenttoolanswers` (
                `AssessmentToolAnswerID`,
                `ActiveUserID`,
                `AssessmentToolID`,
                `DateTaken`,
                `StudentID`)
            VALUES (
                NULL,
                :ActiveUserID,
                :AssessmentToolID,
                CURRENT_TIMESTAMP,
                :StudentID)";

            $db_handle->prepareStatement($query);
            $db_handle->bindVar(":ActiveUserID", $_SESSION['UserID'], PDO::PARAM_INT, 0);
            $db_handle->bindVar(":AssessmentToolID", $keys[1], PDO::PARAM_INT, 0);
            $db_handle->bindVar(":StudentID", $studentID, PDO::PARAM_STR, 0);

            $db_handle->runUpdate();
            $assessmentToolAnswerID = $db_handle->getLastInsertID();
            
            $assessmentToolIDs[] = $keys[1];
            
            $db_handle->prepareStatement(
                "INSERT INTO `scores` (
                    `ScoreID`,
                    `AssessmentToolAnswerID`,
                    `Score`,
                    `Category`)
                VALUES (
                    NULL,
                    :AssessmentToolAnswerID,
                    :Score,
                    NULL)");
            
            $db_handle->bindVar(":AssessmentToolAnswerID", $assessmentToolAnswerID, PDO::PARAM_INT, 0);
            $db_handle->bindVar(":Score", $tempScore, PDO::PARAM_INT, 0);
            
            $db_handle->runUpdate();
            
            $assessmentToolAnswerID = '';
            $tempScore = 0;
        }
    }
}

header("location: /pages/student.assessment.history.php?id=".$studentID."&status=toolsuccess");
?>