<?php
include("../../initialize.php");
includeCore();

$db_handle = new DBController();
$formID = $_GET['id'];
$faID = $_GET['faid'];
$post = $_POST;
$keys = [];
$tempScore = 0;
$query = '';
#die(print_r($_POST));
foreach($post as $key => $value)
{
    $keys = explode('-', $key);
    
    if($keys[0] != 'q' && $keys[1] == '1')
    {
        if($keys[3] != 'new')
        {
            $query .= "UPDATE `answers_quanti` SET `Answer` = :answer".$keys[2]." WHERE `answers_quanti`.`ANSWERS_QUANTI_ID` = :ansID".$keys[2].";";
        } else
        {
            $query .= "INSERT INTO `answers_quanti` (`ANSWERS_QUANTI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES (NULL, :answer".$keys[2].", :qid".$keys[2].", :faID".$keys[2].", NULL);";
        }
    } else if($keys[0] != 'q' && $keys[1] == '2')
    {
        if($keys[3] != 'new')
        {
            $query .= "UPDATE `answers_quali` SET `Answer` = :answer".$keys[2]." WHERE `answers_quali`.`ANSWERS_QUALI_ID` = :ansID".$keys[2].";";
        } else
        {
            $query .= "INSERT INTO `answers_quali` (`ANSWERS_QUALI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES (NULL, :answer".$keys[2].", :qid".$keys[2].", :faID".$keys[2].", NULL);";
        }
    }
}

#die($query);
$db_handle->prepareStatement($query);

foreach($post as $key => $value)
{

    $keys = explode('-', $key);
    
    if(($keys[0] != 'q' && $keys[1] == '1') || ($keys[0] != 'q' && $keys[1] == '2'))
    {
        if($keys[1] == '1')
        {
            if($keys[3] != 'new')
            {
                $db_handle->bindVar(":answer".$keys[2], $value, PDO::PARAM_INT,0);
                $db_handle->bindVar(":ansID".$keys[2], $keys[3], PDO::PARAM_INT,0);
            } else
            {
                $db_handle->bindVar(":answer".$keys[2], $value, PDO::PARAM_INT,0);
                $db_handle->bindVar(":qid".$keys[2], $keys[2], PDO::PARAM_INT,0);
                $db_handle->bindVar(":faID".$keys[2], $faID, PDO::PARAM_INT,0);
            }
            
            $tempScore += $value;
        } else if($keys[1] == '2')
        {
            if($keys[3] != 'new')
            {
                $db_handle->bindVar(":answer".$keys[2], $value, PDO::PARAM_STR,0);
                $db_handle->bindVar(":ansID".$keys[2], $keys[3], PDO::PARAM_INT,0);
            } else
            {
                $db_handle->bindVar(":answer".$keys[2], $value, PDO::PARAM_STR,0);
                $db_handle->bindVar(":qid".$keys[2], $keys[2], PDO::PARAM_INT,0);
                $db_handle->bindVar(":faID".$keys[2], $faID, PDO::PARAM_INT,0);
            }
        }
    }
}
if($query != '')
{
    $db_handle->runUpdate();
}

if($db_handle->getUpdateStatus()) {
    $db_handle->prepareStatement("UPDATE `form_answers` SET `Score` = :score WHERE `form_answers`.`FORM_ANSWERS_ID` = :faID");
    $db_handle->bindVar(':score', $tempScore, PDO::PARAM_INT,0);
    $db_handle->bindVar(':faID', $faID, PDO::PARAM_INT,0);
    $db_handle->runUpdate();
    
    header("location: /pages/assessment.view.answers.tool.php?id=".$faID."&status=updatetoolsuccess");
} else
{
    header("location: /pages/assessment.view.answers.tool.php?id=".$faID."&status=updatetoolempty");
}
?>