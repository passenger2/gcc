<?php
include("../../initialize.php");
includeCore();

$post = $_POST;
$formTitle = $post['formTitle'];
$instructions = $post['formInstructions'];
$itemStart = $post['itemStart'];
$formID = '';
$query = '';
$itemNo = 1;

$db_handle = new DBController();

$db_handle->prepareStatement(
    "INSERT INTO `assessmenttools`(
        `AssessmentToolID`,
        `Name`,
        `Instructions`,
        `AgeGroup`,
        `ItemsStartAt`)
     VALUES (
        NULL,
        :formTitle,
        :instr,
        NULL,
        :itemStart)");
$db_handle->bindVar(':formTitle', $formTitle, PDO::PARAM_STR,0);
$db_handle->bindVar(':instr', nl2br($instructions), PDO::PARAM_STR,0);
$db_handle->bindVar(':itemStart', $itemStart, PDO::PARAM_INT,0);
$db_handle->runUpdate();

$formID = $db_handle->getLastInsertID();

foreach($post as $key => $result)
{
    if(substr($key,0,12) == 'question_add')
    {
        $query .=
            "INSERT INTO `questions`(
                `QuestionID`,
                `Question`,
                `AssessmentToolID`,
                `Category`,
                `AnswerType`,
                `HtmlFormID`,
                `IntakeFormID`,
                `ItemNumber`)
             VALUES (
                NULL,
                :question".substr($key,12).",
                :formID".substr($key,12).",
                NULL,
                :at".substr($key,12).",
                NULL,
                NULL,
                :itemNo".substr($key,12).");";
    }
}

$db_handle->prepareStatement($query);

foreach($post as $key => $result)
{
    if(substr($key,0,12) == 'question_add')
    {
        $itemNumber = $itemNo++;
        $db_handle->bindVar(':formID'.substr($key,12), $formID, PDO::PARAM_INT, 0);
        $db_handle->bindVar(':question'.substr($key,12), $result, PDO::PARAM_STR,0);
        $db_handle->bindVar(':itemNo'.substr($key,12), $itemNumber, PDO::PARAM_INT,0);
    } else if(substr($key,0,10) == 'answerType')
    {
        $db_handle->bindVar(':at'.substr($key,10), $result, PDO::PARAM_INT, 0);
    }
}

$db_handle->runUpdate();

if($db_handle->getUpdateStatus()) {
    $db_handle->prepareStatement(
        "INSERT INTO `edithistories`(
            `EditHistoryID`,
            `ActiveUserID`,
            `EditDate`,
            `EditType`,
            `EditItemID`,
            `EditDescription`)
         VALUES(
            NULL,
            :usr,
            NOW(),
            :editType,
            :formID,
            :edit)");
    $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':formID', $formID, PDO::PARAM_INT, 0);
    $db_handle->bindVar(':editType', 'AssessmentTool', PDO::PARAM_STR, 0);
    $db_handle->bindVar(':edit', 'added assessment tool : '.$formTitle, PDO::PARAM_STR, 0);
    $db_handle->runUpdate();
    
    header("location: /pages/forms.manage.tools.php?status=formsuccess");
} else {
    header("location: /pages/forms.manage.tools.php?status=formerror");
}
?>