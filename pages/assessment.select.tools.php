<?php
include("../initialize.php");
includeCore();

$idpID = $_GET['id'];
$userID = $_SESSION['UserID'];

$idp = getStudentDetails($idpID);
$toolsList = getAllAssessmentTools();
#die(print_r($toolsList));
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
                                    foreach ($idp as $result) {
                                ?>
                                <b><?php echo($result['Lname'].', '.$result['Fname'].' '.$result['Mname']); ?></b>
                                <?php
                                        $idp_name = $result['Lname'].', '.$result['Fname'].' '.$result['Mname'];
                                        if($result['Age'] < 18) {
                                            $idp_age_group = 2;
                                        } else {
                                            $idp_age_group = 1;
                                        }

                                    }
                                }
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="assessment.informed.consent.php?from=tools" method="post">
                                <div class="form-group">
                                    <div class="col-md-12"><p>Select Tool(s):</p></div>
                                    <div class="col-md-12">
                                        <?php
                                        if(!empty($toolsList)) {
                                            foreach ($toolsList as $form) {
                                        ?>
                                        <div class="col-md-6">
                                            <label>
                                            <input id="<?php echo($form["AssessmentToolID"]); ?>" type="checkbox" name="form-<?php echo($form["AssessmentToolID"]); ?>" value="<?php echo($form["AssessmentToolID"]); ?>">&nbsp;
                                            <?php echo($form["Name"]) ?></label>
                                        </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="idpID" value="<?php echo($idpID); ?>">
                                        <input type="hidden" name="idp_name" value="<?php echo($idp_name); ?>">
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

    </body>

</html>