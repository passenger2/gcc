<?php
include("../initialize.php");
includeCore();

$db_handle = new DBController();
$ageGroup = $_GET['ag'];
$studentID = $_GET['id'];
$userID = $_SESSION['UserID'];
$formID = getIntakeID($ageGroup);
$questions = getAssessmentQuestions('Intake',$formID);
$formInfo = getIntakeInfo($formID);
$studentInfo = getStudentExtensiveDetails($studentID);
if(isset($formInfo[0]["ItemsStartAt"]))
{
    $itemStart = $formInfo[0]["ItemsStartAt"];
} else
{
    $itemStart = 0;
}
$qCount = count($questions);
$qFormless = false;

#die(print_r($formInfo));
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Apply Intake"); ?>

        <style>
            .question-container  {
                margin-bottom: 20px;
                margin-top: 20px;
            }
        </style>

    </head>

    <body>

        <div id="wrapper">
            <?php includeNav(); ?>
            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/student.list.php">Students</a></li>
                        <li class="breadcrumb-item"><a href="/pages/student.assessment.history.php?id=<?php echo($studentID); ?>">Student Assessment History</a></li>
                        <li class="breadcrumb-item active">Apply Intake</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>
                                    Please click submit...
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <form id="form-layout" action="/includes/actions/assessment.process.answers.intake.php?id=<?php echo($studentID); ?>&ag=<?php echo($ageGroup); ?>" method="post">
                                        <div class="col-md-12">
                                            <hr>
                                            <button type="submit" onClick="ChangeTarget('sme')" class="btn btn-primary btn-fill btn-md" style="float: right;"><i class="fa fa-upload"></i>&nbsp;Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php includeCommonJS(); ?>

    </body>

</html>