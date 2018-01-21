<?php
include("../initialize.php");
includeCore();
#die(print_r($_POST));

$toolIDs = json_decode($_POST["toolID"]);
$idpName = $_POST['idpName'];
$idpID = $_POST['idpID'];
$formInfo = getMultipleAssessmentTools($toolIDs);
$questions = getAssessmentQuestions('Tool',$toolIDs);
$translations = getTranslationsArray('Tool', $toolIDs);
$languages = getLanguages('Tool', $translations);
#die(print_r($languages));
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
                <div id="exam-wrapper">
                    <form action="/includes/actions/assessment.process.answers.tool.php?id=<?php echo($idpID); ?>" method="post">

                        <div class="row">
                            <?php
                            foreach($formInfo as $assessmentTool)
                            {
                            ?>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3>
                                            <?php
                                if(!empty($assessmentTool))
                                {
                                    echo($assessmentTool['Name']);
                                }
                                            ?>
                                            <div class="pull-right" id="languageSelect">
                                                <select class="form-control" onchange="showTranslation(<?php echo("this,".$assessmentTool['AssessmentToolID'].",".json_encode($languages[$assessmentTool['AssessmentToolID']])); ?>)">
                                                    <option disabled selected>Translations</option>
                                                    <option value="Original">Original</option>
                                                    <?php
                                foreach($languages[$assessmentTool['AssessmentToolID']] as $language)
                                {
                                                    ?>
                                                    <option value="<?php echo($language); ?>"><?php echo($language); ?></option>
                                                    <?php
                                }
                                                    ?>
                                                </select>
                                            </div>
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <h5>
                                                <?php if(!empty($assessmentTool)) echo($assessmentTool['Instructions']); ?>
                                            </h5>
                                        </div>
                                        <div class="col-md-12">
                                            <h4>
                                                Questions
                                            </h4>
                                        </div>
                                        <?php
                                if(!empty($questions))
                                {
                                    foreach ($questions as $question)
                                    {

                                        if($question['AssessmentToolID'] == $assessmentTool['AssessmentToolID'])
                                        {
                                        ?>
                                        <div class="col-md-12" name="qcontainer<?php echo($question['QuestionID']); ?>">
                                            <hr>
                                            <div name="question">
                                                <div name="<?php echo($assessmentTool['AssessmentToolID']); ?>-Original">
                                                    <?php echo(nl2br($question['Question'])); ?>
                                                </div>
                                                <?php
                                            if(isset($translations[$assessmentTool['AssessmentToolID']."-".$question['QuestionID']]))
                                            {
                                                foreach($translations[$assessmentTool['AssessmentToolID']."-".$question['QuestionID']] as $dialect => $translation)
                                                {
                                                ?>
                                                <div name="<?php echo($assessmentTool['AssessmentToolID']."-".$dialect); ?>">
                                                    <?php echo(nl2br($translation)); ?>
                                                </div>    
                                                <?php
                                                }
                                            }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12" name="acontainer<?php echo($question['QuestionID']); ?>">
                                            <div name="answerField">
                                                <?php
                                            $itemStart = (!isset($assessmentTool['ItemsStartAt']) ? 0 : $assessmentTool['ItemsStartAt']);
                                            if($question['AnswerType'] == '1')
                                            {
                                                for($i = $itemStart; $i <= $question['Range']; $i++)
                                                {
                                                ?>
                                                <label class="<?php echo($question['Type']); ?>-inline">
                                                    <input name="<?php echo($question['AssessmentToolID']."-1-".$question['QuestionID']."-".$question['ItemNumber']); ?>" type="<?php echo($question['Type']); ?>" value="<?php echo($i); ?>"><?php echo($i); ?>
                                                </label>
                                                <?php
                                                }
                                            } else if($question['AnswerType'] == '2')
                                            {
                                                if($question['Type'] == 'text')
                                                {
                                                ?>
                                                <input type="text" class="form-control" name="<?php echo($question['AssessmentToolID']."-2-".$question['QuestionID']."-".$question['ItemNumber']); ?>">
                                                <?php
                                                } else if($question['Type'] == 'textarea')
                                                {
                                                ?>
                                                <textarea name="<?php echo($question['AssessmentToolID']."-2-".$question['QuestionID']."-".$question['ItemNumber']); ?>" class="form-control"></textarea>
                                                <?php
                                                }
                                            }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                }
                                        ?>
                                    </div>
                                </div>
                                <input type="hidden" name="end-<?php echo($assessmentTool['AssessmentToolID']); ?>" value="END">
                            </div>
                            <?php
                            }
                            ?>


                            <div class="col-md-12">
                                <button id="btn-submit-form" class="btn btn-primary btn-md" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>

    </body>

    <script>
        $("div[name*='Original']").show().siblings().hide();

        function showTranslation(element, toolID, languagesArray){
            var languages = languagesArray;
            console.log(languages);

            for(var i = 0; i < languages.length; i++) {
                //if selected option value is the same as language[i]
                console.log(element.value);
                if(element.value == languages[i])
                    //display <div> with a name languages[i]-fID. Hide others
                    $('div[name='+toolID+'-'+languages[i]+']').show().siblings().hide();
            }
        }
    </script>

</html>