<?php
include("../initialize.php");
includeCore();
#die(print_r($_POST));
$db_handle = new DBController();
$post = $_POST;
$id = $_GET['id'];
$questions = getEditToolQuestions($id);
$translations = getTranslationsArray('Questions', $id);
$languages = getLanguages($translations);
$formInfo = getAssessmentTool($id);
if(isset($formInfo[0]["ItemsStartAt"]))
{
    $itemStart = $formInfo[0]["ItemsStartAt"];
} else
{
    $itemStart = 0;
}
$qCount = count($questions);
$previewAnswerField = [];

foreach($post as $key => $htmlForm)
{
    $temp[] = explode('-', $key);
    if($temp[0][0] != "range")
    {
        $previewAnswerField[$temp[0][1]] = [$temp[0][0], $htmlForm];
    } else
    {
        array_push($previewAnswerField[$temp[0][1]], $htmlForm);
    }
    $temp = [];
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Preview Tool"); ?>

        <style>
            .question-container  {
                margin-bottom: 20px;
                margin-top: 20px;
            }
        </style>

    </head>

    <body>

        <div id="wrapper">
            <div id="preview-wrapper">
                <div class="row">
                    <p class="lead text-center">This is a preview</p>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>
                                    <?php if(!empty($formInfo)) echo($formInfo[0]['Name']); ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h5>Instructions:
                                        <?php if(!empty($formInfo)) echo($formInfo[0]['Instructions']); ?>
                                    </h5>
                                </div>  
                            </div>    
                        </div>
                    </div>
                </div><!-- row end -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3> 
                                    <?php echo($qCount === 1 ? "Question" : "Questions"); ?>
                                    <?php
                                    if(!empty($questions)) {
                                    ?>
                                    <div class="pull-right" id="languageSelect">
                                        <select class="form-control" onchange="showTranslation(this)">
                                            <option disabled selected>Translations</option>
                                            <?php
                                        foreach($languages as $language)
                                        {
                                            ?>
                                            <option value="<?php echo($language); ?>"><?php echo($language); ?></option>
                                            <?php
                                        }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <form id="form-layout" target="" action="" onsubmit="return validate_forms()" method="post">
                                        <?php
                                        if(!empty($questions)) {
                                            foreach ($questions as $question) {
                                        ?>
                                        <div class="col-md-12 question-container" name="qcontainer<?php echo($question['QuestionID']); ?>">
                                            <hr>
                                            <div name="question">
                                                <div name="Original">
                                                    <?php echo($question['Question']); ?>
                                                </div>
                                                <?php
                                                if(!empty($translations))
                                                {
                                                    foreach($translations[$question['QuestionID']] as $dialect => $translation)
                                                    {
                                                ?>
                                                <div name="<?php echo($dialect); ?>">
                                                    <?php echo($translation); ?>
                                                </div>    
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 answer-field" name="acontainer<?php echo($question['QuestionID']); ?>">
                                            <div>
                                                <?php
                                                if($previewAnswerField[$question["QuestionID"]][0] == "1")
                                                {
                                                    for($i = $itemStart; $i <= $previewAnswerField[$question["QuestionID"]][2]; $i++)
                                                    {
                                                ?>
                                                <label class="<?php echo($previewAnswerField[$question["QuestionID"]][1]); ?>-inline"><input type="<?php echo($previewAnswerField[$question["QuestionID"]][1]); ?>" name="1-<?php echo($question["QuestionID"]); ?>"><?php echo($i); ?></label>
                                                <?php
                                                    }
                                                } else
                                                {
                                                    if($previewAnswerField[$question["QuestionID"]][1] == 'text')
                                                    {
                                                ?>
                                                <input class="form-control" id="inputdefault" type="text" name="2-<?php echo($question["QuestionID"]); ?>">
                                                <?php
                                                    } else if ($previewAnswerField[$question["QuestionID"]][1] == 'textarea')
                                                    {
                                                ?>
                                                <textarea class="form-control" rows="5" id="comment" name="2-<?php echo($question["QuestionID"]); ?>"></textarea>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-wrapper -->

            <div id="modal-container">
            </div>
        </div>

        <?php includeCommonJS(); ?>

    </body>

    <script>
        $("div[name='Original']").show().siblings().hide();

        <?php echo("var languages = ".json_encode($languages). ";\n"); ?>
        function showTranslation(elem){
            for(var i = 0; i < languages.length; i++) {
                if(elem.value == languages[i])
                    $('div[name='+languages[i]+']').show().siblings().hide();
            }
        }

        function ChangeTarget(loc) {
            if(loc=="new") {
                document.getElementById('form-layout').target="_blank";
                document.getElementById('form-layout').action="forms.preview.layout.php?id=<?php echo($id); ?>&type=tool";
            } else {
                document.getElementById('form-layout').target="";
                document.getElementById('form-layout').action="/includes/actions/forms.process.layout.php?id=<?php echo($id); ?>";
            }
        }
    </script>

</html>