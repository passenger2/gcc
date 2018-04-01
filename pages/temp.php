<?php
include("../initialize.php");
includeCore();

$db_handle = new DBController();

$db_handle->prepareStatement("SELECT StudentID FROM `students`;");
$students = $db_handle->runFetch();

$num = 0;
foreach($students as $student)
{
    $db_handle->prepareStatement(
        "UPDATE `students`
        SET
            `Lname` = 'Test',
            `Fname` = 'Student',
            `Mname` = :num,
            `Nickname` = NULL,
            `PhoneNum` = NULL,
            `Email` = NULL,
            `FathersName` = NULL,
            `FathersStatus` = NULL,
            `MothersName` = NULL,
            `MothersStatus` = NULL
        WHERE
            `students`.`StudentID` = :studentID;"
    );
    $db_handle->bindVar(":num", $num++, PDO::PARAM_INT, 0);
    $db_handle->bindVar(":studentID", $student['StudentID'], PDO::PARAM_STR, 0);
    $db_handle->runUpdate();
}
?>