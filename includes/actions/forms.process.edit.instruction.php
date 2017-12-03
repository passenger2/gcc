<?php
include("../../initialize.php");
includeCore();
$id = $_POST['itemID'];
$old = $_POST['oldItem'];
$instructions = nl2br($_POST['textInput']);
$db_handle = new DBController();
if (empty($instructions)) {
     header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=instrempty");
} else {
    $db_handle->prepareStatement("UPDATE `form` SET `Instructions` = :instr WHERE `form`.`FormID` = :id");
    $db_handle->bindVar(':instr', $instructions, PDO::PARAM_STR, 0);
    $db_handle->bindVar(':id', $id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
    
    if($db_handle->getUpdateStatus()) {
        $db_handle->prepareStatement("INSERT INTO `edit_history`(`EditHistoryID`, `USER_UserID`, `LastEdit`, `FORM_FormID`, `QUESTIONS_QuestionsID`, `INTAKE_IntakeID`, `Remark`) VALUES (NULL, :usr, now(), :formID, NULL, NULL, 'edited the instructions')");
        $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
        $db_handle->bindVar(':formID', $id, PDO::PARAM_INT, 0);
        $db_handle->runUpdate();
        
        header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=instrsuccess");
    } else {
        header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=instrerror");
    }
}
?>