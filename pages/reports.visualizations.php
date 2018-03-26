<?php
include("../initialize.php");
includeCore();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <script src="/assets/vendor/dimple/lib/d3.v4.3.0.js"></script>
        <script src="/assets/vendor/dimple/dist/dimple.latest.js"></script>

        <?php
        includeHead("PSRMS - Visualizations");
        ?>
    </head>

    <body>

        <div class="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/reports.php">Reports</a></li>
                        <li class="breadcrumb-item active">Visualizations</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Visualizations</h3>
                    </div>
                    <div class="col-lg-12">

                        <div id="tabs">
                            <ul>
                                <li><a href="/includes/fragments/reports.visualizations.demographics.php">Demographics</a></li>
                                <li><a href="/includes/fragments/reports.visualizations.scores.php">Assessment Scores</a></li>
                                <li><a href="ajax/content2.html">Set 2</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#wrapper -->

        </div>

        <?php includeCommonJS(); ?>

        <script>
            $( function() {
                $( "#tabs" ).tabs({
                    beforeLoad: function( event, ui ) {
                        ui.jqXHR.fail(function() {
                            ui.panel.html(
                                "Under construction.");
                        });
                    }
                });
            } );
        </script>

    </body>

</html>