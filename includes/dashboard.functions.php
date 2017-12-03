<?php

function get_total($str = '', $category = '') 
{
    
    $db_handle = new DBController();
    
    if($str == 'age' && $category != '')
    {
        if($category == 'children')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, idp.Age, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE ( CurrentAge <18) OR (AgeTable.Age <18)");
        } else if($category == 'adults')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, idp.Age, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE (CurrentAge >= 18 AND CurrentAge < 60) OR (AgeTable.Age >= 18 AND AgeTable.Age < 60)");
        } else if($category == 'senior')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, idp.Age, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE ( CurrentAge > 60) OR (AgeTable.Age > 60)");
        } else if($category == 'undefined')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, idp.Age, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE (CurrentAge IS NULL) AND ( AgeTable.Age IS NULL)");
        }
    } else
    {
        $query = "SELECT COUNT(*) as total FROM ".$str;
        $db_handle->prepareStatement($query);
    }
    
    $result = $db_handle->runFetch();
    foreach($result as $row) {
        $data = $row['total'];
    }

    return $data;
}

function includeMorrisData()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/morris-data.php");

}
function includeDashboardModal()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/fragments/dashboard.modal.php");

}

function getDistinctDate($str)
    # author: Cali, Mohammad G.
    # Date Created : Oct. 24, 2017

{

    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT MONTHNAME(`DateTaken`) AS dates, count(*) AS total FROM idp WHERE `EvacuationCenters_EvacuationCentersID` = :str GROUP BY dates");
    $db_handle -> bindvar(":str", $str, PDO::PARAM_STR,0);
    $result = $db_handle->runFetch();


    return $result;   
}

function getDistinctEducation()
# author: Cali, Mohammad G.
# Date Created : Oct. 24, 2017

{

    $db_handle = new DBController();

    $db_handle->prepareStatement("SELECT COUNT(idp.IDP_ID) AS TOTAL, idp.Education as education from idp GROUP BY idp.Education");

    $result = $db_handle->runFetch();
  
    return $result;   
}

function getDistinctReligion()
# author: Cali, Mohammad G.
# Date Created : Oct. 24, 2017

{

    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT idp.Religion, COUNT(idp.IDP_ID) AS TOTAL from idp GROUP BY idp.Religion");
    $result = $db_handle->runFetch();
   return $result;   
}


function getIDPList($str)
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM `idp` WHERE `Gender` = $str");
    $array = $db_handle->runFetch();
    $result ="";
    foreach ($array as $idp) {
        $result .=  $idp['Fname']." " . $idp['Mname']. " " . $idp['Lname']. "<br>"; 

    }
    return $result; 
}

function getScores($form_id, $month ="")
{
   $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM form_answers WHERE MONTHNAME(DateTaken) = :month AND FORM_FormID = :form_id");
    $db_handle -> bindvar(":month", $month, PDO::PARAM_STR,0);
    $db_handle -> bindvar(":form_id", $form_id, PDO::PARAM_INT,0);
    
    $result = $db_handle->runFetch();
    return $result;
}

function getAssessmentTakerCount()
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT COUNT(*) AS TOTAL,`FORM_FormID` AS FORM, MONTH(DateTaken) AS DATES FROM `form_answers` GROUP BY FORM_FormID, MONTH(`DateTaken`)");
    $result = $db_handle->runFetch();
    return $result;
}

function getForms()
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM `form` WHERE 1");
    $result = $db_handle->runFetch();
    return $result;
}
function getIDPCount($form_id, $month ="")
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT COUNT(*) AS TOTAL FROM form_answers WHERE MONTHNAME(DateTaken) = :month AND FORM_FormID = :form_id");
    $db_handle -> bindvar(":month", $month, PDO::PARAM_STR,0);
    $db_handle -> bindvar(":form_id", $form_id, PDO::PARAM_INT,0);
    
    $result = $db_handle->runFetch();
    return $result;
}

function getFormAnswersDistinctDate()
{

  $db_handle = new DBController();
    $db_handle->prepareStatement("
SELECT DISTINCT MONTHNAME(`DateTaken`) AS MONTH FROM form_answers where 1");
    $result = $db_handle->runFetch();
    return $result;   
}

function getIDPCountPerEvac()
{

  $db_handle = new DBController();
    $db_handle->prepareStatement("
SELECT COUNT(*) AS TOTAL, EvacuationCenters_EvacuationCentersID FROM `idp` GROUP BY `EvacuationCenters_EvacuationCentersID`");
    $result = $db_handle->runFetch();
    return $result;   
}

function getIDPName($id)
{
      $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM IDP WHERE IDP_ID = :id ");
    $db_handle -> bindvar(":id", $id, PDO::PARAM_STR,0);
    $array = $db_handle->runFetch();
    $result ="";
    foreach ($array as $idp) {
        $result .=  $idp['Fname']." " . $idp['Mname']. " " . $idp['Lname']; 

    }
    return $result; 
}
function getEvacName($id)
{
      $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM evacuation_centers WHERE EvacuationCentersID = :id ");
    $db_handle -> bindvar(":id", $id, PDO::PARAM_STR,0);
    $array = $db_handle->runFetch();
    $result ="";
    foreach ($array as $idp) {
        $result .=  $idp['EvacName']; 

    }
    return $result; 
}
?>