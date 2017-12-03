<?php
include("../../initialize.php");
includeCore();

$post = $_POST;
$formTitle = $post['formTitle'];
$instructions = $post['formInstructions'];
$itemStart = $post['itemStart'];
$formID = '';
$query = '';

$db_handle = new DBController();

$db_handle->prepareStatement("INSERT INTO `form` (`FormID`, `FormType`, `Instructions`, `AgeGroup`, `ItemStart`) VALUES (NULL, :formTitle, :instr, NULL, :itemStart)");
$db_handle->bindVar(':formTitle', $formTitle, PDO::PARAM_STR,0);
$db_handle->bindVar(':instr', nl2br($instructions), PDO::PARAM_STR,0);
$db_handle->bindVar(':itemStart', $itemStart, PDO::PARAM_INT,0);
$db_handle->runUpdate();

$formID = $db_handle->getLastInsertID();

foreach($post as $key => $result)
{
    if(substr($key,0,12) == 'question_add')
    {
        $query .= "INSERT INTO `questions` (`QuestionsID`, `Question`, `FORM_FormID`, `Category`, `AnswerType`, `HTML_FORM_HTML_FORM_ID`, `INTAKE_IntakeID`, `Dialect`) VALUES (NULL, :question".substr($key,12).", :formID".substr($key,12).", NULL, :at".substr($key,12).", NULL, NULL, NULL);";
    }
}
$db_handle->prepareStatement($query);

foreach($post as $key => $result)
{
    if(substr($key,0,12) == 'question_add')
    {
        $db_handle->bindVar(':formID'.substr($key,12), $formID, PDO::PARAM_INT, 0);
        $db_handle->bindVar(':question'.substr($key,12), $result, PDO::PARAM_STR,0);
    } else if(substr($key,0,10) == 'answerType')
    {
        $db_handle->bindVar(':at'.substr($key,10), $result, PDO::PARAM_INT, 0);
    }
}

$db_handle->runUpdate();

if($db_handle->getUpdateStatus()) {
    $db_handle->prepareStatement("INSERT INTO `edit_history`(`EditHistoryID`, `USER_UserID`, `LastEdit`, `FORM_FormID`, `QUESTIONS_QuestionsID`, `INTAKE_IntakeID`, `Remark`) VALUES (NULL, :usr, now(), :formID, NULL, NULL, :edit)");
    $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':formID', $formID, PDO::PARAM_INT, 0);
    $db_handle->bindVar(':edit', 'added assessment tool : '.$formTitle, PDO::PARAM_STR, 0);
    $db_handle->runUpdate();
    
    header("location: /pages/forms.manage.tools.php?status=formsuccess");
} else {
    header("location: /pages/forms.manage.tools.php?status=formerror");
}
?>