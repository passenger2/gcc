<?php
include("../initialize.php");
includeCore();

$ageGroup = $_GET['ag'];
$studentID = $_GET['id'];
$userID = $_SESSION['UserID'];
$formID = getIntakeID($ageGroup);

$questions = getAssessmentQuestions('Intake',$formID);
$formInfo = getIntakeInfo($formID);
$studentInfo = getStudentExtensiveDetails($studentID);
#die(print_r($studentInfo));
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Apply Intake"); ?>

    </head>

    <body>

        <div id="wrapper">
            <?php includeNav(); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
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
                        <form action="/includes/actions/assessment.process.answers.intake.php?id=<?php echo($studentID); ?>&ag=<?php echo($ageGroup); ?>" method="post">
                        <div class="col-md-12">
                            <button id="btn-submit-form" class="btn btn-primary btn-md" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>

    </body>
    <script type="text/javascript">
        //show first translation as default
        $('div[name*="Original"]').show().siblings().hide();
        //function for changing question display based on selected option
        function showDiv(elem, fID, arr){
            var languages = arr;
            for(var i = 0; i < languages.length; i++) {
                //if selected option value is the same as language[i]
                if(elem.value == languages[i])
                    //display <div> with a name languages[i]-fID. Hide others
                    $('div[name='+languages[i]+'-'+fID+']').show().siblings().hide();
            }
        }
    </script>

</html>