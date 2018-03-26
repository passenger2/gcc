<?php
include("../initialize.php");
includeCore();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        
        <?php
        includeHead("PSRMS - Tables");
        includeDataTables('advanced');
        ?>

    </head>

    <body>

        <div class="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/reports.php">Reports</a></li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Tables</h3>
                    </div>
                    <div class="col-lg-12">
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1">Scores Overview</a></li>
                                <!--<li><a href="ajax/content1.html">Set 1</a></li>
                                <li><a href="ajax/content2.html">Set 2</a></li>-->
                            </ul>
                            <div id="tabs-1">
                                <table width="100%" class="table table-bordered table-hover" id="table-report-overview">
                                    <thead>
                                        <tr>
                                            <th align="left"><b>Student Name</b></th>
                                            <th align="left"><b>ID no.</b></th>
                                            <th align="left"><b>GCC Code</b></th>
                                            <th align="left"><b>Tool</b></th>
                                            <th align="left"><b>Score</b></th>
                                            <th align="left"><b>Date Taken</b></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- page end-->
                        <div id="modal-container">
                        </div>
                        <button id="modalToggle" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none"></button>
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
                                "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                                "If this wouldn't be a demo." );
                        });
                    }
                });
            } );
        </script>

        <script>
            $(document).ready(function() {
                var dataTable = $('#table-report-overview').DataTable( {
                    "responsive": true,
                    "processing": true,
                    "serverSide": true,
                    "order":[],
                    "ajax":{
                        url :"/includes/actions/reports.generate.overview.php",
                        method: "POST",
                    },
                    "dom": 'Blfrtip',
                    "buttons": [
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 5 ]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 5 ]
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 5 ]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 5 ]
                            }
                        },
                    ]/*,
                    "columnDefs":[
                        {
                            "targets": [1],
                            "orderable":false
                        },
                    ]*/
                } );
            } );
        </script>

    </body>

</html>