<?php
#   -------------Notes--------------
#       Note 1:
#       this button is a workaround for triggering the edit modal
#       without this workaround, button needs to be clicked twice before modal shows
#   ------------Note end------------

include("../initialize.php");
includeCore();

$id = $_GET['form_id'];

$db_handle = new DBController();

$questions = getEditToolQuestions($id);
$translations = getTranslationsArray($id);
$formInfo = getAssessmentTool($id);
$qFormless = false;
$nullCount = 0;
$qCount = count($questions);

if(!empty($questions)) {
    foreach($questions as $question) {
        if(array_key_exists('HtmlFormID', $question) && is_null($question['HtmlFormID'])) {
            $qFormless = true;
            $nullCount++;
        }
    }
}
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
                                            <div name="original">
                                                <?php echo($question['Question']); ?>
                                            </div>
                                            <?php
                                                foreach($translations[$question['QuestionID']] as $dialect => $translation)
                                                {
                                            ?>
                                            <div name="<?php echo($dialect); ?>">
                                                <?php echo($translation); ?>
                                            </div>    
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="col-md-4 answer-field" name="acontainer<?php echo($question['QuestionID']); ?>">
                                            
                                        </div>
                                        <?php
                                            }
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

</html>