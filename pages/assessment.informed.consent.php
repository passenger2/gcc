<?php
include("../initialize.php");
includeCore();
#die(print_r($_POST));
if($_GET['from'] == 'intake')
{
    $id = $_GET['id'];
    $ag = $_GET['ag'];
} else
{
    $idpID = $_POST['idpID'];

    foreach($_POST as $key => $value) {
        if(substr($key,0,5) === "form-") {
            $ids[] = intval($value);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Informed Consent"); ?>

    </head>

    <body>

        <div id="wrapper">
            <?php includeNav(); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="well" style="margin-top: 20px;">
                            <form id="formInput"
                                  <?php
                                  if($_GET['from'] == 'intake')
                                  {
                                      echo('action="assessment.apply.intake.php?id='.$id.'&ag='.$ag.'"');
                                  } else {
                                      echo('action="assessment.apply.tool.php"');
                                  }
                                  ?> 
                                  method="post">
                                <?php
                                if($_GET['from'] == 'tools')
                                {
                                ?>
                                <input type="hidden" name="idpID" value="<?php echo($idpID); ?>">
                                <input type="hidden" name="toolID" value='<?php echo(json_encode($ids)); ?>'>
                                <?php
                                }
                                ?>
                                <p>Dear <b>MSU-IIT Students</b>,</p>
                                <p>The Guidance and Counseling Center envisions to nurture and develop students into a totally integrated person by providing a guidance program that assist students' endeavor in developing positive behavior, academic achievement, career readiness and resiliency.</p>
                                <p>In this regard, we would like to ask for your participation in assessing the well-being of MSU-IIT students. You will be answering a battery of test for about 1 hour and 30 minutes. On our end, it is our goal and responsibility to use the information that you have shared honestly for intervention. We would like to assure you the protection and utmost confidentiality of your identity.</p>
                                <hr>
                                <ul class="list-unstyled">
                                    <li>
                                        <p><b>Informed Consent</b></p>
                                    </li>
                                    <li>
                                        <p>I have read and understood the background information that you have provided about the program. I recognize the possible demands it requires and thus, I volunteer to take part in the assessment. My participation is subject to the following conditions:</p>
                                        <ol>
                                            <li>That adequate safeguard will be provided to maintain the privacy and confidentiality of my responses.</li>
                                            <li>That my test results become part of the Guidance and Counseling Center, MSU-IIT. Release of such information may be obtained only with prior approval from the Acting Head.</li>
                                            <li>I have the right to withdraw my participation for personal reasons.</li>
                                        </ol>
                                    </li>
                                    <br>
                                    <li>
                                        <input type="checkbox" id="consent">&nbsp;<label for="consent">&nbsp;I hereby agree to take the assessment.</label>
                                        <br>
                                    </li>
                                    <button class="btn btn-success btn-fill btn-sm" type="submit" id="submitButton" style="display:none">Continue</button>
                                    <a href="javascript:history.go(-1)" class="btn btn-success btn-fill btn-sm" id="returnButton">Back</a>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>
        <script type="text/javascript">
            $('#consent').click(function(){
                if($(this).is(':checked')){
                    $('#submitButton').show();
                    $('#returnButton').hide();
                } else {
                    $('#submitButton').hide();
                    $('#returnButton').show();
                }
            });
        </script>

    </body>
</html>