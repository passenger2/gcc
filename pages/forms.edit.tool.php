<?php
#   -------------Notes--------------
#       Note 1:
#       this button is a workaround for triggering the edit modal
#       without this workaround, button needs to be clicked twice before modal shows
#   ------------Note end------------

include("../initialize.php");
includeCore();

$id = $_GET['id'];

$db_handle = new DBController();

$questions = getEditToolQuestions($id);
$translations = getTranslationsArray('EditAssessmentQuestions', $id);
$languages = getLanguages('EditAssessmentQuestions', $translations);
$formInfo = getAssessmentTool($id);
$qCount = count($questions);
$qFormless = false;
/*$nullCount = 0;

if(!empty($questions)) {
    foreach($questions as $question) {
        if(array_key_exists('HtmlFormID', $question) && is_null($question['HtmlFormID'])) {
            $qFormless = true;
            $nullCount++;
        }
    }
}*/
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Edit Tool"); ?>

        <style>
            .question-container  {
                margin-bottom: 20px;
                margin-top: 20px;
            }
        </style>

    </head>

    <body>

        <div id="wrapper">
            <?php includeNav(); ?>
            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/forms.manage.tools.php">Assessment Tools</a></li>
                        <li class="breadcrumb-item active">Edit Assessment Tool</li>
                    </ol>
                </div>
                <?php
                if(isset($_GET['status']) && $_GET['status'] == 'transsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    Translations added successfully!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'instrsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    New Instructions saved!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'questsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    Question edited succesfully!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'titlesuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    New Title saved!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'layoutsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    New Layout saved!
                </div>
                <?php
                }
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>
                                    <?php if(!empty($formInfo)) echo($formInfo[0]['Name']); ?>
                                    <button type="button" class="btn btn-info btn-fill btn-xs" onClick ="load_modal('title<?php echo($id); ?>')">
                                        <span class="fa fa-pencil"></span>Edit Title
                                    </button>
                                    <!-- Note 1 -->
                                    <button class="btn btn-primary btn-lg" id="titleTrigger<?php echo($id); ?>" data-toggle="modal" data-target="#myModaltitle<?php echo($id); ?>" style="display:none">
                                    </button>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h5>Instructions:
                                        <?php if(!empty($formInfo)) echo($formInfo[0]['Instructions']); ?>
                                    </h5>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-info btn-fill btn-xs" onClick ="load_modal('instr<?php echo($id); ?>')">
                                        <span class="fa fa-pencil"></span>Edit Instructions
                                    </button>
                                    <!-- Note 1 -->
                                    <button class="btn btn-primary btn-lg" id="instrTrigger<?php echo($id); ?>" data-toggle="modal" data-target="#myModalinstr<?php echo($id); ?>" style="display:none"></button>
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
                                    <button type="button" class="btn btn-warning btn-fill btn-xs" onClick ="load_modal('trans<?php echo($id); ?>')">
                                        <i class="fa fa-plus-circle "></i>&nbsp;Add Translations
                                    </button>
                                    <!-- Note 1 -->
                                    <button type="button" class="btn btn-primary btn-lg" id="transTrigger<?php echo($id); ?>" data-toggle="modal" data-target="#myModaltrans<?php echo($id); ?>" style="display:none">
                                    </button>
                                    <?php
                                    }

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

                                                    <button type="button" class="btn btn-info btn-fill btn-xs" onClick ="load_modal('quest<?php echo($question['QuestionID']); ?>')"><span class="fa fa-pencil"></span>Edit Question</button>
                                                    <!-- this button is for a workaround in triggering the edit modal -->
                                                    <!-- without this workaround, button needs to be clicked twice before modal shows -->
                                                    <button type="button" class="btn btn-primary btn-lg" id="questTrigger<?php echo($question['QuestionID']); ?>" data-toggle="modal" data-target="#myModalquest<?php echo($question['QuestionID']); ?>" style="display:none"></button>
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
                                        <div class="col-md-6 answer-field" name="acontainer<?php echo($question['QuestionID']); ?>">
                                            <?php
                                                if($question['AnswerType'] == "1") {
                                            ?>
                                            <div class="col-md-8">
                                                <label for="formType">Input Type:</label>
                                                <?php
                                                    //the name of the select form below starts with 1 (1-qid)
                                                    //1 denotes the selection value is for a quantitative question
                                                ?>
                                                <select class="form-control" id="formType" name="1-<?php echo($question['QuestionID']); ?>">
                                                    <option value="radio"<?php echo($question['Type'] == "radio") ? " selected='selected'":""; ?>>Radio Buttons</option>
                                                    <option value="checkbox"<?php echo($question['Type'] == "checkbox") ? " selected='selected'":""; ?>>Checkboxes</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="formRange">Max Range:</label>
                                                <select class="form-control" id="formRange" name="range-<?php echo($question['QuestionID']); ?>">
                                                    <?php
                                                    for($i = 1; $i < 10; ++$i) {
                                                        echo("<option value='".$i."'");
                                                        if($i == $question['Range']) {
                                                            echo(" selected='selected'");
                                                        }
                                                        echo(">".$i."</option>");
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                                } else {
                                            ?>
                                            <div class="col-md-6">
                                                <label for="formType">Input Type:</label>
                                                <?php
                                                    //the name of the select form below starts with 2 (2-qid)
                                                    //2 denotes the selection value is for a qualitative question
                                                ?>
                                                <select class="form-control" id="formType" name="2-<?php echo($question['QuestionID']); ?>">
                                                    <option value="text"<?php echo($question['Type'] == "text") ? " selected='selected'":""; ?>>Text (Single Line)</option>
                                                    <option value="textarea"<?php echo($question['Type'] == "textarea") ? " selected='selected'":""; ?>>Textbox (Multiple Lines)</option>
                                                    <input type="hidden" name="range-<?php echo($question['QuestionID']); ?>" value="null">
                                                </select>
                                            </div>
                                            <?php
                                                }
                                            ?>
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
                                        <div class="col-md-12">
                                            <hr>
                                            <button type="submit" onClick="ChangeTarget('sme')" class="btn btn-primary btn-fill btn-md" style="float: right;"><i class="fa fa-floppy-o"></i>&nbsp;Save Layout</button>
                                            <button type="submit" onClick="ChangeTarget('new')" class="btn btn-secondary btn-fill btn-md" style="float: right; margin-right:5px;"><i class="fa fa-eye"></i>&nbsp;Preview</button>
                                        </div>
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
        <script>
            $("div[name='Original']").show().siblings().hide();

            <?php echo("var languages = ".json_encode($languages). ";\n"); ?>
            function showTranslation(elem){
                for(var i = 0; i < languages.length; i++) {
                    if(elem.value == languages[i])
                        $('div[name='+languages[i]+']').show().siblings().hide();
                }
            }

            window.load_modal = function(clicked_id) {
                $("#modal-container").load("/includes/fragments/forms.modal.edit.php?editing="+clicked_id.substring(0,5)+"&id="+clicked_id.substring(5), function() {
                    if(clicked_id.substring(0,5) === "title") {
                        $('#titleTrigger'+clicked_id.substring(5)).click();
                    } else if(clicked_id.substring(0,5) === "instr") {
                        $('#instrTrigger'+clicked_id.substring(5)).click();
                    } else if(clicked_id.substring(0,5) === "quest") {
                        $('#questTrigger'+clicked_id.substring(5)).click();
                    } else if(clicked_id.substring(0,5) === "trans") {
                        $('#transTrigger'+clicked_id.substring(5)).click();
                    }
                });
            }

            function ChangeTarget(loc) {
                if(loc=="new") {
                    document.getElementById('form-layout').target="_blank";
                    document.getElementById('form-layout').action="forms.preview.layout.php";
                } else {
                    document.getElementById('form-layout').target="";
                    document.getElementById('form-layout').action="/includes/actions/forms.process.layout.php";
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

    </body>

</html>