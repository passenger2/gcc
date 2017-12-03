<?php
include("../../initialize.php");
includeCore();
$id = $_POST['itemID'];
$formID = getFormID($id);
$old = $_POST['oldItem'];
//$question = addslashes($_POST['textInput']);
$db_handle = new DBController();
$previous = $_SERVER['HTTP_REFERER'];
$question = "";

//get the concatenated string for the question
//question format in db should be => 'originalTranslation'['language2']'translation2'...['languageN']'translationN'
foreach($_POST as $key => $item) {
    if($key === "itemID" || $key === "oldItem") {
        //do nothing
    } else {
        if($key === "Original") {
            $question .= $item;
        } else {
            $question .= "[".$key."]".$item;
        }
    }
}
//sanitize string
$question = addslashes($question);
//echo($question);

if (empty($question)) {
     header("location: /pages/forms.edit.tool.php?form_id=".$formID."&status=questempty");
} else {
    $db_handle->prepareStatement("UPDATE `questions` SET `Question` = :quest WHERE `questions`.`QuestionsID` = :id");
    $db_handle->bindVar(':quest', $question, PDO::PARAM_STR, 0);
    $db_handle->bindVar(':id', $id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
    if($db_handle->getUpdateStatus()) {
        $db_handle->prepareStatement("INSERT INTO `edit_history`(`EditHistoryID`, `USER_UserID`, `LastEdit`, `FORM_FormID`, `QUESTIONS_QuestionsID`, `INTAKE_IntakeID`, `Remark`) VALUES (NULL, :usr, now(), NULL, :qid, NULL, 'edited this question')");
        $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
        $db_handle->bindVar(':qid', $id, PDO::PARAM_INT, 0);
        $db_handle->runUpdate();
        
        header("location: /pages/forms.edit.tool.php?form_id=".$formID."&status=questsuccess");
    } else {
        header("location: /pages/forms.edit.tool.php?form_id=".$formID."&status=questerror");
    }
}
?>