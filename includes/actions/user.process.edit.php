<?php
#die($_POST['PhoneNum']);
include("../../initialize.php");
includeCore();

$id = $_GET['id'];
$query = '';
$newAgencyID = '';
$result = [];

$passReady = false;
$newSpecAgency = false;
$newAgency = false;
$newLname = false;
$newMname = false;
$newFname = false;
$newBdate = false;
$newGender = false;
$newPhone = false;
$newEmail = false;

$db_handle = new DBController();
$db_handle->prepareStatement("SELECT * FROM `account` WHERE `USER_UserID` = :userID;");
$db_handle->bindVar(':userID', $id, PDO::PARAM_INT,0);
$result = $db_handle->runFetch();

if($_POST["pwd1"] != '' && $_POST["pwd2"] != ''){
    if($_POST["pwd2"] != $_POST["pwd3"]) {
        header("location: /pages/user.enroll.php?status=matcherror");
    } else
    {
        
        if (password_verify($_POST['pwd1'], $result[0]['Password'])) {
            $db_handle->prepareStatement('UPDATE `account` SET `Password` = :pass WHERE `account`.`AccountID` = :accID;');
            $db_handle->bindVar(':pass',password_hash($_POST['pwd2'],PASSWORD_DEFAULT), PDO::PARAM_STR, 0);
            $db_handle->bindVar(':accID',$result[0]['AccountID'], PDO::PARAM_INT, 0);
            $db_handle->runUpdate();
        } else {
            header("location: /pages/user.enroll.php?status=passerror");
        }
    }
}

if($_POST["Agency"] == "specify" && $_POST["specAgency"] != '' ) {
    //Register specified agency
    $query = "INSERT INTO `agency` (`AgencyID`, `AgencyName`) VALUES (NULL, :agency)";
    $db_handle->prepareStatement($query);
    $db_handle->bindVar(':agency', $_POST['specAgency'], PDO::PARAM_STR,0);
    $db_handle->runUpdate();
    $newAgencyID = $db_handle->getLastInsertID();
    $newSpecAgency = true;
}

if(isset($_POST['Agency']) || $newSpecAgency)
{
    $db_handle->prepareStatement("UPDATE `user` SET `AGENCY_AgencyID` = :agency WHERE `user`.`UserID` = :userID;");

    if($_POST['Agency'] != 'specify')
    {
        $newAgency = true;
    }
    
    if($newSpecAgency || $newAgency)
    {
        if($newSpecAgency)
        {
            $db_handle->bindVar(':agency',$newAgencyID, PDO::PARAM_INT, 0);
            $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
            $db_handle->runUpdate();
        } else if($newAgency)
        {
            $db_handle->bindVar(':agency',$_POST['Agency'], PDO::PARAM_INT, 0);
            $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
            $db_handle->runUpdate();
        }
    }
}

if(isset($_POST['Lname']))
{
    $db_handle->prepareStatement("UPDATE `user` SET `Lname` = :Lname WHERE `user`.`UserID` = :userID;");
    $db_handle->bindVar(':Lname',$_POST['Lname'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}

if(isset($_POST['Mname']))
{
    $db_handle->prepareStatement("UPDATE `user` SET `Mname` = :Mname WHERE `user`.`UserID` = :userID;");
    $db_handle->bindVar(':Mname',$_POST['Mname'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}

if(isset($_POST['Fname']))
{
    $db_handle->prepareStatement("UPDATE `user` SET `Fname` = :Fname WHERE `user`.`UserID` = :userID;");
    $db_handle->bindVar(':Fname',$_POST['Fname'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}

if(isset($_POST['Bdate']) && $_POST['Bdate'] != '')
{
    $db_handle->prepareStatement("UPDATE `user` SET `DateAdded` = :Bdate WHERE `user`.`UserID` = :userID;");
    $db_handle->bindVar(':Bdate',$_POST['Bdate'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}



if(isset($_POST['Gender']))
{
    $db_handle->prepareStatement("UPDATE `user` SET `Sex` = :gender WHERE `user`.`UserID` = :userID;");
    $db_handle->bindVar(':gender',$_POST['Gender'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}

if(isset($_POST['PhoneNum']))
{
    $db_handle->prepareStatement("UPDATE `user` SET `PhoneNum` = :phoneNum WHERE `user`.`UserID` = :userID;");
    $db_handle->bindVar(':phoneNum',$_POST['PhoneNum'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':userID',$id, PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}

if(isset($_POST['Email']))
{
    $db_handle->prepareStatement("UPDATE `account` SET `Username` = :email WHERE `account`.`AccountID` = :accID;");
    $db_handle->bindVar(':email',$_POST['Email'], PDO::PARAM_STR, 0);
    $db_handle->bindVar(':accID',$result[0]['AccountID'], PDO::PARAM_INT, 0);
    $db_handle->runUpdate();
}
    

header("location: /pages/user.list.php?status=updatesuccess");
?>