<?php 
include("../initialize.php");
includeCore();

$formAnswersID = $_GET['id'];

$resultInfo = getAnswerInfo($formAnswersID, 'intake');
$resultItems = getAnswers($formAnswersID, 'intake');
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - View Intake Answers"); ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/idp.list.php">IDPs</a></li>
                        <li class="breadcrumb-item"><a href="/pages/idp.assessment.history.php?id=<?php echo($_SESSION['idpID']); ?>">IDP Assessment History</a></li>
                        <li class="breadcrumb-item active">View Intake Answers</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="panel-heading"><h4>Intake form</h4></div>
                        <div class="panel-body" style="padding: 20px; 50px;">
                            <p style="margin: 10px 40px;">
                                Current IDP: <b><?php echo ($resultInfo[0]['IDPName']); ?></b><br>
                            </p>
                            <div style="margin: 30px 40px;" class="header"><p><b>Questions:</b></p></div>
                            <form action="update_answers.php?id=<?php echo($form_answersID); ?>" method="post">
                                <?php
                                if(!empty($resultItems)) {
                                    foreach ($resultItems as $result) {
                                ?>
                                <table align="center" cellspacing="3" cellpadding="3" width="90%" class=" table-responsive">
                                    <?php
                                        if(isset($result['Answer'])) {
                                            echo '<tr>';
                                        } else {
                                            echo '<tr class="bg-warning">';
                                        }
                                    ?>
                                    <td align="left" style="width:90%" name="no">
                                        <p>
                                            <?php echo(nl2br($result['Question'])); ?>
                                        </p>
                                    </td>   
                                    <?php echo '</tr>' ?>
                                    <?php
                                        if(isset($result['Answer'])) {
                                            echo '<tr name="preview-wrapper" style="margin-bottom: 30px;">';
                                        } else {
                                            echo '<tr name="preview-wrapper" style="margin-bottom: 30px;" class="bg-warning">';
                                        }
                                    ?>
                                    <td id="preview-wrapper<?php echo($result['QuestionsID']); ?>" >
                                        <?php 
                                        //if $result['HTML_FORM_HTML_FORM_ID'] exists, create these elements
                                        if(isset($result['FormType'])) {
                                            echo '<fieldset id="q-a-'.$result['QuestionsID'].'">';
                                            echo '<input type="hidden" name="q-'.$result['QuestionsID'].'" value="'.$result['QuestionsID'].'">';
                                            if(isset($result['AnswerRange'])) { //if AnswerRange is not null. It means html form is either checkbox or radio
                                                if(isset($result['Answer'])) {
                                                    for($i = 0; $i < $result['AnswerRange']; $i++) {
                                                        if($i == $result['Answer']) {
                                                            echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'" checked="checked">'.$i.'</label>';
                                                        } else {
                                                            echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'">'.$i.'</label>';
                                                        }
                                                    }

                                                } else {
                                                    //html_form inline echo loop
                                                    for($i = 0; $i < $result['AnswerRange']; $i++) {
                                                        echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'">'.$i.'</label>';
                                                    }
                                                }
                                            } else {
                                                if($result['FormType'] === "textarea") {
                                                    if(isset($result['Answer'])) {
                                                        echo '<textarea class="form-control" rows="5" id="comment" name="2-'.$result['QuestionsID'].'">'.$result['Answer'].'</textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" rows="5" id="comment" name="2-'.$result['QuestionsID'].'"></textarea>';
                                                    }
                                                } else if($result['FormType'] == "text") {
                                                    if(isset($result['Answer'])) {
                                                        echo '<input class="form-control" id="inputdefault" type="'.$result['FormType'].'" name="2-'.$result['QuestionsID'].'" value="'.$result['Answer'].'">';
                                                    } else {
                                                        echo '<input class="form-control" id="inputdefault" type="'.$result['FormType'].'" name="2-'.$result['QuestionsID'].'">';
                                                    }
                                                }
                                            }
                                            echo '</fieldset>';
                                        }
                                        ?>
                                    </td>
                                    <?php echo '</tr>' ?>
                                </table>
                                <?php
                                    }
                                } else { ?>
                                <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
                                    <tr>

                                        <td align="left">
                                            <h4>No questions for this form yet!</h4>
                                        </td>

                                    </tr>
                                </table>
                                <?php
                                }
                                ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button id="btn-submit-form" class="btn btn-primary btn-sm" type="submit" style="float:right" disabled><i class="fa fa-check"></i>&nbsp;Update</button>
                                    </div>   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /#wrapper -->

        <?php includeCommonJS(); ?>

    </body>

    <script type='text/javascript'>
        $(document).ready(function(){
            $('#Agency').change(function(){
                if ($(this).val() == 'specify') {
                    $('#specifyAgency').show();       
                } else {
                    $('#specifyAgency').hide(); 
                }
            });
        });
    </script>

</html>