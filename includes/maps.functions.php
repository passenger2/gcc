<?php

function getDistinctBarangay()
# author: Cali, Mohammad G.
# Date Created : Oct. 24, 2017

{

     $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM barangay WHERE 1");
    $result = $db_handle->runFetch();
   	foreach ($result as $barangay  => &$val) {
             
          $counts = get_total($val['BarangayID']);
          foreach ($counts as $total) {
          		    $val['count'] = $total['TOTAL'];
          }
         
              
              }

      return $result;   
}

function getLong($barangay_id)
{
 	$db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM barangay WHERE BarangayID = $barangay_id");
    $result = $db_handle->runFetch();
     

      return $result;   
}
function getLat($barangay_id)
{
 	$db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM barangay WHERE BarangayID = $barangay_id");
    $result = $db_handle->runFetch();
     

      return $result;   
}

function get_total($str) 
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT COUNT(*) as TOTAL FROM `idp` LEFT JOIN evacuation_centers on idp.EvacuationCenters_EvacuationCentersID = evacuation_centers.EvacuationCentersID LEFT JOIN barangay ON barangay.BarangayID = evacuation_centers.EvacAddress WHERE evacuation_centers.EvacAddress = $str");
    $result = $db_handle->runFetch();
    
      

      return $result;
}
?>