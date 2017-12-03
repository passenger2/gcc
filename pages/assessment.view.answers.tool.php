<?php
include("../initialize.php");
includeCore();
includeLayoutGenerator();

$formAnswersID = $_GET['id'];

$resultInfo = getAnswerInfo($formAnswersID, 'tool');
$resultItems = getAnswers($formAnswersID, 'tool');

#die(print_r($resultItems));
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - View Assessment Answers"); ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/idp.list.php">IDPs</a></li>
                        <li class="breadcrumb-item"><a href="/pages/idp.assessment.history.php?id=<?php echo($_SESSION['idpID']); ?>">IDP Assessment History</a></li>
                        <li class="breadcrumb-item active">View Assessment Tool Answers</li>
                    </ol>
                </div>
                <?php
                if(isset($_GET['status']) && $_GET['status'] == 'updatetoolsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Answers updated!
                </div>
                <?php
                } else if(isset($_GET['status']) && $_GET['status'] == 'updatetoolempty')
                {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Error!
                </div>
                <?php
                }
                ?>
                <div class="row">
                    <?php echo(displayAnswers($resultItems, $resultInfo, $formAnswersID)); ?>
                </div>

            </div>

        </div>
        <!-- /#wrapper -->

        <?php includeCommonJS(); ?>

    </body>
    <script type="text/javascript">
        //show first translation as default
        $('div[name*="Original"]').show().siblings().hide();
        //function for changing question display based on selected option
        function showDiv(elem, fID, arr){
            var languages = arr;
            for(var i = 0; i < languages.length; i++) {
                //if selected option value is the same as language[i]
                if(elem.value == languages[i])
                    //display <div> with a name languages[i]-fID. Hide others
                    $('div[name='+languages[i]+'-'+fID+']').show().siblings().hide();
            }
        }
    </script>

</html>