<?php
include("../initialize.php");
includeCore();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <script src="/assets/vendor/d3/d3.min.js"></script>
        <script src="/assets/vendor/dimple/lib/d3.v4.3.0.min.js"></script>

        <?php
        includeHead("PSRMS - Reports");
        includeDataTables();
        ?>

    </head>

    <body>

        <div class="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Reports</h3>
                    </div>
                    <div class="col-lg-12">
                        <a href="reports.tables.php"><h4>Tables</h4></a>
                        <a href="reports.visualizations.php"><h4>Visualizations</h4></a>
                    </div>
                </div>
            </div>
            <!-- /#wrapper -->

        </div>

        <?php includeCommonJS(); ?>

    </body>

</html>