<?php
include("../initialize.php");
includeCore();

$_SESSION['loc'] = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Add Assessment Tool"); ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/forms.manage.tools.php">Assessment Tools</a></li>
                        <li class="breadcrumb-item active">Add Assessment Tool</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="title">&nbsp;Add Assessment Tool</h4>  
                            </div>
                            <div class="panel-body">
                                <form action="/includes/actions/forms.process.add.tool.php" method="post" onsubmit="return check_empty()">
                                    <div class="form-group">
                                        <input type="text" name="formTitle" placeholder="Assessment tool name*" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="formInstructions" placeholder="Instructions" class="form-control"></textarea>
                                    </div>
                                    <div class="tooltipped form-group">
                                        Choices start at:
                                        <label class="radio-inline"><input type="radio" name="itemStart" value='0' checked="checked">0</label>
                                        <label class="radio-inline"><input type="radio" name="itemStart" value='1'>1</label>
                                        <button type="button" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="Choices by default starts at zero (i.e. 0-choice1, 1-choice2,...) You can change this to 1 so that choices will be: 1-choice1, 2-choice2,...">
                                            <i class="fa fa-question-circle fa-fw"></i>
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <div id="question-field-container-0">
                                            <div class="form-group">
                                                <label><br>Question:</label>
                                                <textarea class="form-control" rows="5" name="question_add0"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="radio-inline"><input type="radio" name="answerType0" value="1">Quantitative</label>
                                                <label class="radio-inline"><input type="radio" name="answerType0" value="2">Qualitative</label>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success" onclick="add_more_questions()">Add more question</button>
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                    </div>
                                </form>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>

    </body>
    <script type="text/javascript">
        var i = 0;
        function add_more_questions() {
            var $div = $('div[id^="question-field-container-"]:last');

            var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

            var $klon = $div.clone().prop('id', 'question-field-container-'+num );

            $($klon.find("[name='question_add"+(num-1)+"']")).attr("name","question_add"+num);
            $($klon.find("[name='answerType"+(num-1)+"']")[0]).attr("name","answerType"+num);
            $($klon.find("[name='answerType"+(num-1)+"']")[0]).attr("name","answerType"+num);
            $div.after( $klon );
        }

        function check_empty() {
            var flag_radio = true;
            var flag_textarea = true;

            //check if a radio button is unticked
            $('input:radio').each(function () {
                name = $(this).attr('name');
                if (flag_radio && !$(':radio[name="' + name + '"]:checked').length) {
                    flag_radio = false;
                }
            });

            //check if a textarea is empty
            $('textarea').each(function() {
                if (!$.trim($(this).val())) {
                    flag_textarea = false; 
                }
            });

            //if nothing is empty
            if(flag_radio && flag_textarea) {
                return true;
            } else {
                alert("Please do not leave any empty field before submitting.");
                return false;
            }
        }
        $('.tooltipped').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        })
    </script>

</html>