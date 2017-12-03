<?php
include("../initialize.php");
includeCore();
$Barangays = getBarangays();
$Cities = getCities();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php
        includeHead("PSRMS - Evacuation Centers");
        includeDataTables();
        ?>

    </head>

    <body>

        <div id="wrapper">
            <?php includeNav(); ?>
            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Evacuation Centers</li>
                    </ol>
                </div>
                <?php
                if(isset($_GET['status']) && $_GET['status'] == 'error2')
                {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Barangay should be set!
                </div>
                <?php
                } else if(isset($_GET['status']) && $_GET['status'] == 'enrollsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    New Evacuation Center Enrolled!
                </div>
                <?php
                } else if(isset($_GET['status']) && $_GET['status'] == 'editsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Changes saved!
                </div>
                <?php
                }
                ?>
                <!-- /.row -->
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Evacuation Centers <a href="/pages/evac.enroll.php" class="btn btn-success btn-xs">Add Evacuation Center</a></h3>
                    
                    </div>
                    <div class="panel-body">
                        
                    </div>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table width="100%" class="table table-bordered table-hover" id="table-evac-list">
                                    <thead>
                                        <tr>
                                            <th>Evacuation Center Name</th>
                                            <th>Evacuation Center Address</th>
                                            <th>Evacuation Center Manager</th>
                                            <th>Evacuation Center Contact</th>
                                            <th>Evacuation Center Specific Address</th>
                                            <?php
                                            if($_SESSION['account_type'] == '77')
                                            {
                                            ?>
                                            <th>Action</th>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <?php includeCommonJS(); ?>

    </body>
    <script>
        $(document).ready(function() {
            var dataTable = $('#table-evac-list').DataTable( {
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order":[],
                "ajax":{
                    url :"/includes/actions/evac.generate.list.php",
                    method: "POST",
                },
                "columnDefs":[
                    {
                        "targets": [],
                        "orderable":false
                    },
                ]
            } );
        } );
    </script>

</html>