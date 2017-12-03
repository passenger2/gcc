<?php
include("../../initialize.php");
includeCore();
$id = $_POST['itemID'];
$old = $_POST['oldItem'];
$title = addslashes($_POST['textInput']);
$db_handle = new DBController();
$previous = $_SERVER['HTTP_REFERER'];
if (empty($title)) {
     header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=titleempty");
} else {
    $db_handle->prepareStatement("UPDATE `form` SET `FormType` = :title WHERE `form`.`FormID` = :id");
    $db_handle->bindVar(':title', $title, PDO::PARAM_STR, 0);
    $db_handle->bindVar(':id', $id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
    
    if($db_handle->getUpdateStatus()) {
        $db_handle->prepareStatement("INSERT INTO `edit_history`(`EditHistoryID`, `USER_UserID`, `LastEdit`, `FORM_FormID`, `QUESTIONS_QuestionsID`, `INTAKE_IntakeID`, `Remark`) VALUES (NULL, :usr, now(), :formID, NULL, NULL, 'edited the title')");
        $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
        $db_handle->bindVar(':formID', $id, PDO::PARAM_INT, 0);
        $db_handle->runUpdate();
        
        header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=titlesuccess");
    } else {
        header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=titleerror");
    }
}
?>