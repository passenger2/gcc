<?php

function get_total($str = '', $category = '') 
{
    
    $db_handle = new DBController();
    
    if($str == 'age' && $category != '')
    {
        if($category == 'children')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE CurrentAge < 18");
        } else if($category == 'adults')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE CurrentAge >= 18 AND CurrentAge < 60");
        } else if($category == 'senior')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE CurrentAge >= 60");
        } else if($category == 'undefined')
        {
            $db_handle->prepareStatement("SELECT COUNT(AgeTable.IDP_ID) AS total FROM (SELECT idp.IDP_ID, idp.Bdate, CURRENT_DATE(), TIMESTAMPDIFF(YEAR, idp.Bdate, CURRENT_DATE) AS CurrentAge FROM idp) AgeTable WHERE CurrentAge IS NULL");
        }
    } else
    {
        $db_handle->prepareStatement("SELECT COUNT(*) as total FROM ".$str);
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
    $db_handle->prepareStatement("SELECT DATE_FORMAT(DATE(`DateTaken`), '%Y-%m-%d') AS dates, count(*) AS total FROM IDP WHERE `EvacuationCenters_EvacuationCentersID` = $str GROUP BY dates");
    $result = $db_handle->runFetch();


    return $result;   
}

function getDistinctEducation()
# author: Cali, Mohammad G.
# Date Created : Oct. 24, 2017

{

    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT education, COUNT(*) AS TOTAL from IDP GROUP BY Education");
    $result = $db_handle->runFetch();
     return $result;   
}

function getDistinctReligion()
# author: Cali, Mohammad G.
# Date Created : Oct. 24, 2017

{

    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT `Religion`, COUNT(*) AS TOTAL from IDP GROUP BY `Religion`");
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
?>