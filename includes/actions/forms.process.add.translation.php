<?php
include("../../initialize.php");
includeCore();
$id = $_GET['id'];
$db_handle = new DBController();
$post = $_POST;
$lang = $_POST['transLang'];
$query = "";
foreach($post as $key => $value) {
    if(($key !== "transLang" && substr($key,0,11) !== "oldQuestion") && $value !== '') {
        $query.="UPDATE `questions` SET `Question` = :newQuestion".substr($key,9)." WHERE `questions`.`QuestionsID` = :qid".substr($key,9).";";
    }
}
$db_handle->prepareStatement($query);
foreach($post as $key => $value) {
    if(($key !== "transLang" && substr($key,0,11) !== "oldQuestion") && $value !== '') {
        $qid = (substr($key,9));
        $transParam = (":newQuestion".$qid);
        $qidParam = (":qid".$qid);
        $translation = htmlspecialchars($post["oldQuestion-".$qid]."[".$lang."]".$value);
        
        $db_handle->bindVar($transParam, $translation, PDO::PARAM_STR, 0);
        $db_handle->bindVar($qidParam, $qid, PDO::PARAM_INT, 0);
    }
}

$db_handle->runUpdate();

if($db_handle->getUpdateStatus()) {
    $db_handle->prepareStatement("INSERT INTO `edit_history`(`EditHistoryID`, `USER_UserID`, `LastEdit`, `FORM_FormID`, `QUESTIONS_QuestionsID`, `INTAKE_IntakeID`, `Remark`) VALUES (NULL, :usr, now(), :formID, NULL, NULL, :edit)");
    $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':formID', $id, PDO::PARAM_INT, 0);
    $db_handle->bindVar(':edit', 'added translations : '.$lang, PDO::PARAM_STR, 0);
    $db_handle->runUpdate();
    
    header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=transsuccess");
} else {
    header("location: /pages/forms.edit.tool.php?form_id=".$id."&status=error");
}
?>