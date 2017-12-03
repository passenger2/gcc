<?php
include("../initialize.php");
includeCore();

$id = $_GET['id'];
$idpDetails = getIDPExtensiveDetails($id);
#die(print_r($idpDetails));
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php
        includeHead("Student Details");
        ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="student.list.php">Students</a></li>
                        <li class="breadcrumb-item active"><a href="student.assessment.history.php?id=<?php echo($id); ?>">Student Assessment History</a></li>
                        <li class="breadcrumb-item active">Student Details</li>
                    </ol>
                </div>
                <?php
                if(isset($_GET['status']) && $_GET['status'] == 'success')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Save successful!
                </div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="header">
                        <h3 class="title"><?php echo($idpDetails[0]['IDPName']); ?>&nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'name')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="nameTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </h3>
                    </div>
                    <hr>
                    <div class="col-md-6">
                        <p>
                            <b>Home Address:&nbsp;</b><u><?php echo(getFullAddress($idpDetails[0]['Origin_Barangay'], $id)); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'homeAddress')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="homeTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Gender:&nbsp;</b>
                            <u><?php echo(getGender($idpDetails[0]['Gender'])); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'gender')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="genderTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Birth Date:&nbsp;</b>
                            <u><?php
                                echo(translateDate($idpDetails[0]['Bdate']));
                            ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'bdate')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="bdateTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Age:&nbsp;</b>
                            <?php
                                $age = calculateAge($idpDetails[0]['Bdate']);
                                if($age == 'N/A')
                                {
                                    if(isset($idpDetails[0]['Age']))
                                    {
                                        echo($idpDetails[0]['Age']);
                                    }
                                    else
                                    {
                                        echo('<abbr title="no birthdate or age specified">N/A</abbr>');
                                    }
                                } else
                                {
                                    echo('<abbr title="automatically generated">'.$age.'</abbr>');
                                }
                            ?>
                        </p>
                        <p>
                            <b>Ethnicity:&nbsp;</b><u><?php echo(($idpDetails[0]['Ethnicity'] != '' ? $idpDetails[0]['Ethnicity'] : 'unspecified' )); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'ethnicity')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="ethnicityTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Religion:&nbsp;</b><u><?php echo(($idpDetails[0]['Religion'] != '' ? $idpDetails[0]['Religion'] : 'unspecified' )); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'religion')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="religionTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <p>
                            <b>Educational Attainment:&nbsp;</b>
                            <u><?php
                                echo(getEducationalAttainment($idpDetails[0]['Education']));
                            ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'educAttain')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="educAttainTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Marital Status:&nbsp;</b><u><?php echo(getMaritalStatus($idpDetails[0]['MaritalStatus'])); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'maritalStat')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="maritalStatTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Phone Number:&nbsp;</b><u><?php echo(($idpDetails[0]['PhoneNum'] != '' ? $idpDetails[0]['PhoneNum'] : 'unspecified' )); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'phoneNum')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="phoneNumTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Email:&nbsp;</b><u><?php echo(($idpDetails[0]['Email'] != '' ? $idpDetails[0]['Email'] : 'unspecified' )); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'email')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="emailTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Occupation:&nbsp;</b><u><?php echo(($idpDetails[0]['Occupation'] != '' ? $idpDetails[0]['Occupation'] : 'unspecified' )); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'occupation')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="occupationTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                        <p>
                            <b>Evacuation Center:&nbsp;</b><u><?php echo(($idpDetails[0]['EvacID'] != '' ? getEvacDetails($idpDetails[0]['EvacID']) : 'unspecified' )); ?></u>
                            &nbsp;
                            <a onClick="load_modal(<?php echo($id); ?>, 'evacuation')"><i class="fa fa-edit"></i></a>
                            <button type="button" id="evacuationTrigger" data-toggle="modal" data-target="#myModal" style="display:none"></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modal-container">
        </div>

        <?php includeCommonJS(); ?>

    </body>
    <script>
        window.load_modal = function(clicked_id, target) {
            $("#modal-container").load("/includes/fragments/idp.modal.edit.php?editing="+target+"&id="+clicked_id, function() {
                if(target === "homeAddress") {
                    $('#homeTrigger').click();
                } else if(target === "gender") {
                    $('#genderTrigger').click();
                } else if(target === "bdate") {
                    $('#bdateTrigger').click();
                } else if(target === "ethnicity") {
                    $('#ethnicityTrigger').click();
                } else if(target === "religion") {
                    $('#religionTrigger').click();
                } else if(target === "educAttain") {
                    $('#educAttainTrigger').click();
                } else if(target === "maritalStat") {
                    $('#maritalStatTrigger').click();
                } else if(target === "phoneNum") {
                    $('#phoneNumTrigger').click();
                } else if(target === "email") {
                    $('#emailTrigger').click();
                } else if(target === "occupation") {
                    $('#occupationTrigger').click();
                } else if(target === "evacuation") {
                    $('#evacuationTrigger').click();
                } else if(target === "name") {
                    $('#nameTrigger').click();
                }
            });
        }
    </script>

</html>