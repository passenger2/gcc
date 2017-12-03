<?php
include("../initialize.php");
includeCore();

includeLayoutGenerator();

$ageGroup = $_GET['ag'];
$idpID = $_GET['id'];
$userID = $_SESSION['UserID'];
$formID = getIntakeID($idpID, $ageGroup);

$questions = getAssessmentQuestions('Intake',$formID);
$formInfo = getIntakeInfo($formID);
$idpInfo = getIDPExtensiveDetails($idpID);
$evacDetails = getEvacDetails($idpInfo[0]['EvacID'])
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
                            foreach($idpInfo as $result)
                            {
                            ?>
                            <h4 class="panel-title">
                                <?php echo($result['IDPName']); ?>
                                <sup><a class="float-right" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-info-circle fa-fw"></i></a></sup>
                            </h4>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <hr>
                                <div id="idp-info">
                                    <p class="field-label"><b>Date of Intake: </b><?php echo(date("l").', '.translateDate(date("m-d-Y"))); ?></p>
                                    <p class="field-label"><b>Age: </b><?php echo(calculateAge($result['Bdate'])); ?></p>
                                    <p class="field-label"><b>Sex: </b><?php echo(getGender($result['Gender'])); ?></p>
                                    <p class="field-label"><b>Marital status: </b><?php echo(getMaritalStatus($result['MaritalStatus'])); ?></p>
                                    <?php
                                if(isset($result['Occupation'])) {
                                    echo '<p class="field-label"><b>Employment/ Occupation: </b>'.$result['Occupation'].'</p>';
                                }
                                    ?>
                                    <p class="field-label"><b>Address/Name of Evacuation Center: </b>
                                        <?php echo(($result['EvacID'] != '' ? getEvacDetails($result['EvacID']) : 'unspecified' )); ?>
                                    <p class="field-label"><b>Address prior to evacuation: </b>
                                        <?php echo(getFullAddress($idpInfo[0]['Origin_Barangay'], $idpID)); ?>
                                    </p>
                                    <p class="field-label"><b>Contact info: </b><?php echo(($result['PhoneNum'] != '' ? $result['PhoneNum'] : 'unspecified' )); ?></p>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <form action="/includes/actions/assessment.process.answers.intake.php?id=<?php echo($idpID); ?>&ag=<?php echo($ageGroup); ?>" method="post">
                            <?php echo(displayQuestions($questions, $formInfo, '')); ?>
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