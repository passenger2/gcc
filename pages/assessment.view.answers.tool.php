<?php
include("../initialize.php");
includeCore();
includeLayoutGenerator();

$assessmentToolAnswersID = $_GET['id'];

$answersInfo = getAnswerInfo($assessmentToolAnswersID, 'tool');
#die(print_r($answersInfo));
$answersItems = getAnswers($assessmentToolAnswersID, 'tool');
#die(print_r($answersItems));

#die(print_r($answersItems));
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - View Assessment Tool Answers"); ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/student.list.php">Students</a></li>
                        <li class="breadcrumb-item"><a href="/pages/student.assessment.history.php?id=<?php echo($_SESSION['idpID']); ?>">Student Assessment History</a></li>
                        <li class="breadcrumb-item active">View Assessment Tool Answers</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="panel-heading"><h4><?php echo ($answersInfo[0]['Name']); ?></h4></div>
                        <div class="panel-body" style="padding: 20px; 50px;">
                            <p style="margin: 10px 40px;">
                                Current IDP: <b><?php echo ($answersInfo[0]['StudentName']); ?></b><br>
                            </p>
                            <p style="margin: 10px 40px;">
                                Date taken: <b><?php echo(date('M d, Y', strtotime($answersInfo[0]['DateTaken']))); ?></b><br>
                            </p>
                            <p style="margin: 10px 40px;">
                                Agent: <b><?php echo($answersInfo[0]['ActiveUser']); ?></b><br>
                            </p>
                            <div style="margin: 30px 40px;" class="header"><p><b>Questions:</b></p></div>
                            <form action="/includes/actions/assessment.process.update.answers.tool.php?atid=<?php echo($answersInfo[0]['AssessmentToolAnswerID']); ?>&sid=<?php echo($answersInfo[0]['StudentID']); ?>" method="post">
                                <?php
                                if(!empty($answersItems)) {
                                    foreach ($answersItems as $result) {
                                ?>
                                <table align="center" cellspacing="3" cellpadding="3" width="90%" class=" table-responsive">
                                    <?php
                                        if(!isset($result['Answer']) || $result['Answer'] == "(blank)") {
                                            echo '<tr class="bg-warning">';
                                        } else {
                                            echo '<tr>';
                                        }
                                    ?>
                                    <td align="left" style="width:90%" name="no">
                                        <p>
                                            <?php echo($result['ItemNumber']." .) ".nl2br($result['Question'])); ?>
                                        </p>
                                    </td>   
                                    <?php echo '</tr>' ?>
                                    <?php
                                        if(!isset($result['Answer']) || $result['Answer'] == "(blank)") {
                                            echo '<tr name="preview-wrapper" style="margin-bottom: 30px;" class="bg-warning">';
                                        } else {
                                            echo '<tr name="preview-wrapper" style="margin-bottom: 30px;">';
                                        }
                                    ?>
                                    <td id="preview-wrapper<?php echo($result['QuestionID']); ?>" >
                                        <div class="col-md-12" name="acontainer<?php echo($result['QuestionID']); ?>">
                                            <div name="answerField">
                                                <?php
                                        $itemStart = (!isset($assessmentTool['ItemsStartAt']) ? 0 : $assessmentTool['ItemsStartAt']);
                                        if($result['AnswerType'] == '1')
                                        {
                                            for($i = $itemStart; $i <= $result['Range']; $i++)
                                            {
                                                ?>
                                                <label class="<?php echo($result['Type']); ?>-inline">
                                                    <input name="<?php echo($result['AssessmentToolID']."-1-".$result['QuestionID']."-".$result['ItemNumber']."-".$result['AnswerID']); ?>" type="<?php echo($result['Type']); ?>" value="<?php echo($i); ?>" <?php if(isset($result['Answer']) && $result['Answer'] == $i) echo('checked="checked"');?>><?php echo($i); ?>
                                                </label>
                                                <?php
                                            }
                                        } else if($result['AnswerType'] == '2')
                                        {
                                            if($result['Type'] == 'text')
                                            {
                                                ?>
                                                <input type="text" class="form-control" name="<?php echo($result['AssessmentToolID']."-2-".$result['QuestionID']."-".$result['ItemNumber']."-".$result['AnswerID']); ?>" <?php if(isset($result['Answer'])) echo('value="'.$result['Answer'].'"');?>>
                                                <?php
                                            } else if($result['Type'] == 'textarea')
                                            {
                                                ?>
                                                <textarea name="<?php echo($result['AssessmentToolID']."-2-".$result['QuestionID']."-".$result['ItemNumber']."-".$result['AnswerID']); ?>" class="form-control"><?php if(isset($result['Answer'])) echo($result['Answer']);?></textarea>
                                                <?php
                                            }
                                        }
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                    <?php echo '</tr>' ?>
                                </table>
                                <?php
                                    }
                                } else { ?>
                                <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
                                    <tr>

                                        <td align="left">
                                            <h4>No results for this form yet!</h4>
                                        </td>

                                    </tr>
                                </table>
                                <?php
                                }
                                ?>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button id="btn-submit-form" class="btn btn-primary btn-sm" type="submit" style="float:right"><i class="fa fa-check"></i>&nbsp;Update</button>
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

</html>