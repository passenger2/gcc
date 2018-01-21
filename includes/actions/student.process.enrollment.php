<?php
#die(print_r($_POST));
include("../../initialize.php");
includeCore();

$db_handle = new DBController();
$query = "";
$query .=
    "INSERT INTO `students` (
        `StudentID`,
        `Lname`,
        `Fname`,
        `Mname`,
        `Nickname`,
        `Bdate`,
        `Age`,
        `Gender`,
        `PhoneNum`,
        `Email`,
        `PlaceOfBirth`,
        `Citizenship`,
        `DepartmentID`,
        `CourseYear`,
        `Religion`,
        `DateEnrolled`,
        `ActiveUserID`,
        `PrevGPA`,
        `OrdinalPosition`,
        `FathersName`,
        `FathersStatus`,
        `FathersOccupation`,
        `MothersName`,
        `MothersStatus`,
        `MothersOccupation`,
        `ParentsMaritalStatus`,
        `ParentsContactNo`,
        `CurrentlyLivingWith`,
        `CurrentAddress`,
        `CurrentSpecificAddress`,
        `ScholarshipStatus`,
        `ScholarshipType`,
        `FamilyMonthlyNetIncome`,
        `SchoolLastAttended`,
        `SchoolLastAttendedAddress`)
    VALUES (
        :StudentID,
        :Lname,
        :Fname,
        :Mname,
        :Nickname,
        :Bdate,
        :Age,
        :Gender,
        :PhoneNum,
        :Email,
        :PlaceOfBirth,
        :Citizenship,
        :DepartmentID,
        :CourseYear,
        :Religion,
        CURRENT_TIMESTAMP(),
        :ActiveUserID,
        :PrevGPA,
        :OrdinalPosition,
        :FathersName,
        :FathersStatus,
        :FathersOccupation,
        :MothersName,
        :MothersStatus,
        :MothersOccupation,
        :ParentsMaritalStatus,
        :ParentsContactNo,
        :CurrentlyLivingWith,
        :CurrentAddress,
        :CurrentSpecificAddress,
        :ScholarshipStatus,
        :ScholarshipType,
        :FamilyMonthlyNetIncome,
        :SchoolLastAttended,
        :SchoolLastAttendedAddress
    )";

$db_handle->prepareStatement($query);

#StudentID
if(isset($_POST['IDNo'])) 
    $db_handle->bindVar(':StudentID', $_POST['IDNo'], PDO::PARAM_STR,0);
else
    header("location: ".$_SESSION['loc']."?status=emptyID");

#Lname
if(isset($_POST['Lname'])) 
    $db_handle->bindVar(':Lname', $_POST['Lname'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Lname');

#Fname
if(isset($_POST['Fname'])) 
    $db_handle->bindVar(':Fname', $_POST['Fname'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Fname');

#Mname
if(isset($_POST['Mname'])) 
    $db_handle->bindVar(':Mname', $_POST['Mname'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Mname');

#Nickname
if(isset($_POST['Nickname'])) 
    $db_handle->bindVar(':Nickname', $_POST['Nickname'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Nickname');

#Bdate
if(isset($_POST['Bdate']) && $_POST['Bdate'] != '') 
    $db_handle->bindVar(':Bdate', $_POST['Bdate'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Bdate');

#Age
if(isset($_POST['Age']) && $_POST['Age'] != '') 
    $db_handle->bindVar(':Age', $_POST['Age'], PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':Age');

#Gender
if(isset($_POST['Gender'])) 
    $db_handle->bindVar(':Gender', $_POST['Gender'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Gender');

#PhoneNum
if(isset($_POST['PhoneNum'])) 
    $db_handle->bindVar(':PhoneNum', $_POST['PhoneNum'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':PhoneNum');

#Email
if(isset($_POST['Email'])) 
    $db_handle->bindVar(':Email', $_POST['Email'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Email');

#PlaceOfBirth
if(isset($_POST['PlaceOfBirth']) && $_POST['PlaceOfBirth'] != '') 
    $db_handle->bindVar(':PlaceOfBirth', intval($_POST['PlaceOfBirth']), PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':PlaceOfBirth');

#Citizenship
if(isset($_POST['Citizenship'])) 
    $db_handle->bindVar(':Citizenship', $_POST['Citizenship'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Citizenship');

#DepartmentID
if(isset($_POST["Departtment"])) 
    $db_handle->bindVar(':DepartmentID', $_POST['Departtment'], PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':DepartmentID');

#CourseYear
if(isset($_POST["Course"]) && isset($_POST["YearLevel"])) 
    $db_handle->bindVar(':CourseYear', $_POST['Course'].' '.$_POST['YearLevel'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':CourseYear');

#Religion
if(isset($_POST["Religion"])) 
    $db_handle->bindVar(':Religion', $_POST['Religion'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':Religion');

#ActiveUserID
    $db_handle->bindVar(':ActiveUserID', $_SESSION['UserID'], PDO::PARAM_INT,0);

#PrevGPA
if(isset($_POST['PrevGPA']) && $_POST['PrevGPA'] != '') 
    $db_handle->bindVar(':PrevGPA', $_POST['PrevGPA'], PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':PrevGPA');

#OrdinalPosition
if(isset($_POST['OrdinalPosition']) && $_POST['OrdinalPosition'] != '') 
    $db_handle->bindVar(':OrdinalPosition', $_POST['OrdinalPosition'], PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':OrdinalPosition');

#FathersName
if(isset($_POST['FathersName'])) 
    $db_handle->bindVar(':FathersName', $_POST['FathersName'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':FathersName');

#FathersStatus
if(isset($_POST['FathersStatus'])) 
    $db_handle->bindVar(':FathersStatus', $_POST['FathersStatus'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':FathersStatus');

#FathersOccupation
if(isset($_POST['FathersOccupation'])) 
    $db_handle->bindVar(':FathersOccupation', $_POST['FathersOccupation'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':FathersOccupation');

#MothersName
if(isset($_POST['MothersName'])) 
    $db_handle->bindVar(':MothersName', $_POST['MothersName'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':MothersName');

#MothersStatus
if(isset($_POST['MothersStatus'])) 
    $db_handle->bindVar(':MothersStatus', $_POST['MothersStatus'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':MothersStatus');

#MothersOccupation
if(isset($_POST['MothersOccupation'])) 
    $db_handle->bindVar(':MothersOccupation', $_POST['MothersOccupation'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':MothersOccupation');

#ParentsMaritalStatus
if(isset($_POST['SpecMaritalStatus']) && $_POST['SpecMaritalStatus'] != '') 
    $db_handle->bindVar(':ParentsMaritalStatus', $_POST['SpecMaritalStatus'], PDO::PARAM_STR,0);
else if(isset($_POST['MaritalStatus'])) 
    $db_handle->bindVar(':ParentsMaritalStatus', $_POST['MaritalStatus'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':ParentsMaritalStatus');

#ParentsContactNo
if(isset($_POST['ParentsContact'])) 
    $db_handle->bindVar(':ParentsContactNo', $_POST['ParentsContact'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':ParentsContactNo');

#CurrentlyLivingWith
if(isset($_POST['SpecLivingWith'])  && $_POST['SpecLivingWith'] != '') 
    $db_handle->bindVar(':CurrentlyLivingWith', $_POST['SpecLivingWith'], PDO::PARAM_STR,0);
else if(isset($_POST['LivingWith'])) 
    $db_handle->bindVar(':CurrentlyLivingWith', $_POST['LivingWith'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':CurrentlyLivingWith');

#CurrentAddress
if(isset($_POST['Address']) && $_POST['Address'] != '') 
    $db_handle->bindVar(':CurrentAddress', $_POST['Address'], PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':CurrentAddress');

#CurrentSpecificAddress
if(isset($_POST['SpecAddress'])) 
    $db_handle->bindVar(':CurrentSpecificAddress', $_POST['SpecAddress'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':CurrentSpecificAddress');

#ScholarshipStatus
if(isset($_POST['ScholarshipType']) && $_POST['ScholarshipType'] == 'Regular Paying Student') 
    $db_handle->bindVar(':ScholarshipStatus', '0', PDO::PARAM_INT,0);
else if(!isset($_POST['ScholarshipType']) || $_POST['ScholarshipType'] == '')
    $db_handle->bindNull(':ScholarshipStatus');
else
    $db_handle->bindVar(':ScholarshipStatus', '1', PDO::PARAM_INT,0);

#ScholarshipType
if(isset($_POST['SpecScholarshipType'])  && $_POST['SpecScholarshipType'] != '') 
    $db_handle->bindVar(':ScholarshipType', $_POST['SpecScholarshipType'], PDO::PARAM_STR,0);
else if(isset($_POST['ScholarshipType'])) 
    $db_handle->bindVar(':ScholarshipType', $_POST['ScholarshipType'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':ScholarshipType');

#FamilyMonthlyNetIncome
if(isset($_POST['NetIncome'])) 
    $db_handle->bindVar(':FamilyMonthlyNetIncome', $_POST['NetIncome'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':FamilyMonthlyNetIncome');

#SchoolLastAttended
if(isset($_POST['SchoolLastAttended'])) 
    $db_handle->bindVar(':SchoolLastAttended', $_POST['SchoolLastAttended'], PDO::PARAM_STR,0);
else
    $db_handle->bindNull(':SchoolLastAttended');

#SchoolLastAttendedAddress
if(isset($_POST['SchoolLastAttendedAddress']) && $_POST['SchoolLastAttendedAddress'] != '') 
    $db_handle->bindVar(':SchoolLastAttendedAddress', $_POST['SchoolLastAttendedAddress'], PDO::PARAM_INT,0);
else
    $db_handle->bindNull(':SchoolLastAttendedAddress');

#die($query);
try {
    $db_handle->runUpdate();
} catch (Exception $e) {
    #die('Caught exception: '.  $e->getMessage(). "\n");
    #error handling here
}

if($db_handle->getUpdateStatus())
{
    header("location: ".$_SESSION['loc']."?status=success");
} else {
    header("location: ".$_SESSION['loc']."?status=err1");
}
?>