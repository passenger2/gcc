<?php
#die(print_r($_POST));
include("../../initialize.php");
includeCore();

$idpID = $_GET['id'];
$editing = $_GET['editing'];

$post = $_POST;
$db_handle = new DBController();

if($editing == 'homeAddress')
{
    if($post['SpecificAddress'] != '')
    {
        $db_handle->prepareStatement("UPDATE `idp` SET `Origin_Barangay` = :barangayID, `SpecificAddress` = :specAdd WHERE `idp`.`IDP_ID` = :idpID");
        $db_handle->bindVar(':barangayID', $post['barangay1'], PDO::PARAM_INT, 0);
        $db_handle->bindVar(':specAdd', $post['SpecificAddress'], PDO::PARAM_STR, 0);
        $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);
    } else
    {
        $db_handle->prepareStatement("UPDATE `idp` SET `Origin_Barangay` = :barangayID WHERE `idp`.`IDP_ID` = :idpID");
        $db_handle->bindVar(':barangayID', $post['barangay1'], PDO::PARAM_INT, 0);
        $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);
    }
    
    $db_handle->runUpdate();
} else if($editing == 'gender')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `Gender` = :gender WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':gender', $post['Gender'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);
    
    $db_handle->runUpdate();
} else if($editing == 'bdate')
{
    if($post['Bdate'] != '')
    {
        $db_handle->prepareStatement("UPDATE `idp` SET `Bdate` = :bdate WHERE `idp`.`IDP_ID` = :idpID");
        if(isset($post['Bdate']) && $post['Bdate'] != '') $db_handle->bindVar(':bdate', $post['Bdate'], PDO::PARAM_STR,0);
        $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    }
} else if($editing == 'ethnicity')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `Ethnicity` = :ethnicity WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':ethnicity', $post['Ethnicity'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'religion')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `Religion` = :religion WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':religion', $post['Religion'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'educAttain')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `Education` = :educAttain WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':educAttain', $post['education'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'maritalStat')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `MaritalStatus` = :maritalStat WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':maritalStat', $post['MaritalStatus'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'phoneNum')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `PhoneNum` = :phoneNum WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':phoneNum', $post['PhoneNum'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'email')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `Email` = :email WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':email', $post['Email'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'occupation')
{
    $db_handle->prepareStatement("UPDATE `idp` SET `Occupation` = :occupation WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':occupation', $post['Occupation'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
} else if($editing == 'evacuation')
{
    if($post['EvacType'] == '1')
    {
        $db_handle->prepareStatement("UPDATE `idp` SET `EvacuationCenters_EvacuationCentersID` = :evacuation WHERE `idp`.`IDP_ID` = :idpID");
        $db_handle->bindVar(':evacuation', $post['EvacName'], PDO::PARAM_STR, 0);
        $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);
    } else
    {
        $db_handle->prepareStatement("UPDATE `idp` SET `EvacuationCenters_EvacuationCentersID` = :evacuation WHERE `idp`.`IDP_ID` = :idpID");
        $db_handle->bindNull(':evacuation');
        $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);
        
        //need to modify db to store info for home based address
    }

    $db_handle->runUpdate();
} else if($editing == 'name')
{

    $db_handle->prepareStatement("UPDATE `idp` SET `Lname` = :Lname, `Fname` = :Fname, `Mname` = :Mname WHERE `idp`.`IDP_ID` = :idpID");
    $db_handle->bindVar(':Lname', $post['Lname'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':Fname', $post['Fname'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':Mname', $post['Mname'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT, 0);

    $db_handle->runUpdate();
}

header("location: /pages/idp.details.php?id=".$idpID."&status=success");
?>