<?php
#die(print_r($_POST));
include("../../initialize.php");
includeCore();
$db_handle = new DBController();
$formID = $_GET['id'];
$post_values = $_POST;
$db_handle->prepareStatement("SELECT * FROM `htmlforms`;");
$html_forms = $db_handle->runFetch();
$post =  array_values($_POST);  //$_POST assoc array to numeric array; contains form type, quantity alternately
$post_len = count($post);
$q_ids = array();               //array of question ids
//extract ids from $_POST
foreach($post_values as $key => $value) {
    //$key is in the form of 1-xx or 2-xx (1 = quanti question, 2 = quali question)
    //if key starts with 1 or 2, it is a key for a question
    //if key starts with 1 or 2, add 1 to length
    if(substr($key,0,1) == '1' || substr($key,0,1) == '2') {
       $q_ids[] = substr($key,2);
    }
}

$q_ids_len = count($q_ids);     //q_ids entry count/ array length
$q_html_form = array();         //array for html_form ids to be used in query
$query = "";                    //sql query
$outputArray = array();         //SPL** entry search output (contains form_id, form type, quantity from HTML_FORMS table)



//converting $post array to a 2d array that contains [form type, quantity] per entry
//last entry is the form id, thus, $post_len-1
for($i = 0; $i < $post_len-1; $i += 2) {
    $q_html_form[] = array($post[$i], $post[$i+1]);
}

//**SPL method for searching associative array by $key => $value. Not sure how it works but it works. lol------------------------
//method found here: https://stackoverflow.com/questions/1019076/how-to-search-by-key-value-in-a-multidimensional-array-in-php
$array_iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($html_forms));
for($j = 0; $j < $q_ids_len; $j++) {
    foreach ($array_iterator as $sub) {
        $subArray = $array_iterator->getSubIterator();
        if (($subArray['Type'] == $q_html_form[$j][0]) && ($subArray['Range'] == $q_html_form[$j][1] || $subArray['Range'] == null) ) {
            //$outputArray[] = iterator_to_array($subArray);
            $outputArray[] = array_values(iterator_to_array($subArray));
        }
    }
}
//----------------------------------------------------------------------------------------------------------------------------

for($k = 0; $k < $q_ids_len; $k++) {
    $query .= 
        "UPDATE `questions`
        SET `HtmlFormID` = :html".$outputArray[$k][0]."
        WHERE `QuestionID` = :qID".$q_ids[$k].";";
}
$db_handle->prepareStatement($query);
for($k = 0; $k < $q_ids_len; $k++) {
    $db_handle->bindVar(':html'.$outputArray[$k][0], $outputArray[$k][0], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':qID'.$q_ids[$k], $q_ids[$k], PDO::PARAM_INT, 0);
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
        VALUES (
            NULL,
            :usr,
            now(),
            'Assessment Tool Layout',
            :formID,
            :edit)");
    $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':formID', $formID, PDO::PARAM_INT, 0);
    $db_handle->bindVar(':edit', 'Edited this tool\'s layout.', PDO::PARAM_STR, 0);
    $db_handle->runUpdate();
    
    header("location: /pages/forms.edit.tool.php?id=".$formID."&status=layoutsuccess");
} else {
    header("location: /pages/forms.edit.tool.php?id=".$formID."&status=layouterror");
}
?>