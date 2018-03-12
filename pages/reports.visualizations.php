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
                        <!--content-->
                    </div>
                </div>
            </div>
            <!-- /#wrapper -->

        </div>

        <?php includeCommonJS(); ?>

    </body>

</html>