<?php
include("../initialize.php");
includeCore();

$idpID = $_GET['id'];
$userID = $_SESSION['UserID'];

$idp = getStudentDetails($idpID);
$toolsList = getAllAssessmentTools();
$toolsSize = sizeof($toolsList);
#die();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Apply Assessment Tool"); ?>

    </head>

    <body>

        <div id="wrapper">
            <?php includeNav(); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Available Tools</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Current IDP: 
                                <?php
                                if(!empty($idp)) {
                                ?>
                                <b>
                                    <?php
                                    $studentName = $idp[0]['Lname'].', '.$idp[0]['Fname'].' '.$idp[0]['Mname'];
                                    if($_SESSION['account_type'] == '77')
                                    {
                                        echo($studentName);
                                    } else
                                    {
                                        echo($idp[0]['GccCode']);
                                    }
                                    ?>
                                </b>
                                <?php
                                    if($idp[0]['Age'] < 18) {
                                        $idp_age_group = 2;
                                    } else {
                                        $idp_age_group = 1;
                                    }
                                }
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <button id="selectAll" class="btn btn-fill btn-xs">Select all tools</button>
                            </div>
                            <form action="assessment.informed.consent.php?from=tools" method="post">
                                <div class="form-group">
                                    <div class="col-md-12"><p>Select Tool(s):</p></div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <?php
                                            if(!empty($toolsList)) {
                                                $x = 0;
                                                foreach ($toolsList as $form) {
                                                    $x++;
                                                    if($x <= $toolsSize/2)
                                                    {
                                            ?>
                                            <div class="col-md-12">
                                                <label>
                                                    <input id="<?php echo($form["AssessmentToolID"]); ?>" type="checkbox" name="form-<?php echo($form["AssessmentToolID"]); ?>" value="<?php echo($form["AssessmentToolID"]); ?>">&nbsp;
                                                    <?php echo($form["Name"]) ?></label>
                                            </div>
                                            <?php
                                                    } else
                                                    {
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if(!empty($toolsList)) {
                                                $x = 0;
                                                foreach ($toolsList as $form) {
                                                    $x++;
                                                    if($x > $toolsSize/2)
                                                    {
                                            ?>
                                            <div class="col-md-12">
                                                <label>
                                                    <input id="<?php echo($form["AssessmentToolID"]); ?>" type="checkbox" name="form-<?php echo($form["AssessmentToolID"]); ?>" value="<?php echo($form["AssessmentToolID"]); ?>">&nbsp;
                                                    <?php echo($form["Name"]) ?></label>
                                            </div>
                                            <?php
                                                    } else
                                                    {
                                                        continue;
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <input type="hidden" name="idpID" value="<?php echo($idpID); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <br>
                                        <button class="btn btn-info btn-fill form-control" type="submit">Proceed&nbsp;<i class="fa fa-arrow-right fa-fw"></i></button> 
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>
        <script>
            $(document).ready(function () {
                $('body').on('click', '#selectAll', function () {
                    if ($(this).hasClass('allChecked')) {
                        $('input[type="checkbox"]').prop('checked', false);
                    } else {
                        $('input[type="checkbox"]').prop('checked', true);
                    }
                    $(this).toggleClass('allChecked');
                })
            });
        </script>

    </body>

</html>