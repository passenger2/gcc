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
                
                <div class="well" id="accordion" style="margin-top: 20px;">
                    <?php
                    foreach($studentInfo as $result)
                    {
                    ?>
                    <h4 class="panel-title">
                        <?php echo($result['StudentName']); ?>
                        <sup><a class="float-right" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-info-circle fa-fw"></i></a></sup>
                    </h4>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <hr>
                        <div id="idp-info">
                            <p class="field-label"><b>Student ID Number: </b><?php echo($result['StudentID']); ?></p>
                            <p class="field-label"><b>Date of Intake: </b><?php echo(date("l").'; '.translateDate(date("d-m-Y"))); ?></p>
                            <p class="field-label"><b>Age: </b>
                                <?php
                        if(isset($result['Bdate']))
                            echo(calculateAge($result['Bdate']));
                        else if(isset($result['Age']))
                            echo($result['Age']);
                        else
                            echo("<i>information unavailable</i>");
                                ?></p>
                            <p class="field-label"><b>Sex: </b><?php echo($result['Gender']); ?></p>
                            <p class="field-label"><b>Course/Year: </b>
                                <?php echo($result['CourseYear']); ?>
                            <p class="field-label"><b>Contact info: </b><?php echo(($result['PhoneNum'] != '' ? $result['PhoneNum'] : 'unspecified' )); ?></p>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>
                                    <?php if(!empty($formInfo)) echo($formInfo[0]['IntakeFormName']); ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <form id="form-layout" action="/includes/actions/assessment.process.answers.intake.php?id=<?php echo($studentID); ?>&ag=<?php echo($ageGroup); ?>" method="post">
                                        <?php
                                        if(!empty($questions)) {
                                            foreach ($questions as $question) {
                                        ?>
                                        <div class="col-md-12 question-container" name="qcontainer<?php echo($question['QuestionID']); ?>">
                                            <hr>
                                            <div name="question">
                                                <div name="Original">
                                                    <?php echo(nl2br($question['Question'])); ?>
                                                </div>
                                                <?php
                                                if(!empty($translations))
                                                {
                                                    foreach($translations[$question['QuestionID']] as $dialect => $translation)
                                                    {
                                                ?>
                                                <div name="<?php echo($dialect); ?>">
                                                    <?php echo(nl2br($translation)); ?>
                                                </div>    
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-10 answer-field" name="acontainer<?php echo($question['QuestionID']); ?>">
                                            <?php
                                            if($question['AnswerType'] == "1")
                                            {
                                                for($i = $itemStart; $i <= $question['Range']; $i++)
                                                {
                                            ?>
                                            <label class="<?php echo($question['Type']); ?>-inline"><input type="<?php echo($question['Type']); ?>" name="1-<?php echo($question["QuestionID"]); ?>" value="<?php echo($i); ?>"><?php echo($i); ?></label>
                                            <?php
                                                }
                                            } else
                                            {
                                                if($question['Type'] == 'text')
                                                {
                                            ?>
                                            <input class="form-control" id="inputdefault" type="text" name="2-<?php echo($question["QuestionID"]); ?>">
                                            <?php
                                                } else if ($question['Type'] == 'textarea')
                                                {
                                            ?>
                                            <textarea class="form-control" rows="5" id="comment" name="2-<?php echo($question["QuestionID"]); ?>"></textarea>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php
                                            }
                                        }
                                        else
                                        {
                                        ?>
                                        <h4>No questions for this form yet!</h4>
                                        <?php
                                        }
                                        ?>
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