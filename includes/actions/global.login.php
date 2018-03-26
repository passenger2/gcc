<?php
include("../../initialize.php");
include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/global.dbcontrollerPDO.php");

$db_handle = new DBController();

if(isset($_SESSION["UserID"])) {
    session_unset(); 
    session_destroy();
    header("location: /pages/login.php?err=3");
} else {
    $db_handle->prepareStatement(
        "SELECT
            accounts.AccountID,
            accounts.UserID,
            accounts.Username,
            accounts.Password,
            CONCAT(COALESCE(users.Lname, ''),', ', COALESCE(users.Fname, ''), ' ', COALESCE(users.Mname, '')) AS UsersName,
            accounts.CollegeID,
            accounts.Type,
            accounts.Status AS AccountStatus,
            users.AgencyID,
            users.Status AS UserStatus
        FROM `accounts`
        LEFT JOIN users
            ON users.UserID = accounts.UserID
        WHERE accounts.Username = :uName");
    
    $db_handle->bindVar(':uName', $_POST['email'], PDO::PARAM_STR,0);
    $result = $db_handle->runFetch();

    if (password_verify($_POST['pwd'], $result[0]['Password'])) {
        $_SESSION["UserID"] = $result[0]['UserID'];
        $_SESSION["account_type"] = $result[0]['Type'];
        $_SESSION["CollegeID"] = $result[0]['CollegeID'];
        $_SESSION["AgencyID"] = $result[0]['AgencyID'];
        $_SESSION["UserName"] = $result[0]['UsersName'];
        if($_SESSION["account_type"] == '77')
        {
            header("Location: /pages/index.php");
        } else
        {
            header("Location: /pages/student.list.php");
        }
    } else {
        header("location: /pages/login.php?err=2");
    }
}
?>