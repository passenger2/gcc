<?php
include("../initialize.php");
includeCore();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php
        includeHead("Student Assessment");
        if($_SESSION['account_type'] == '77')
        {
            includeDataTables('advanced');
        } else
        {
            includeDataTables();
        }
        ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Students Enrolled&nbsp;<a href="student.enroll.php" type="button" class="btn btn-success btn-xs btn-fill">Enroll</a></h3>
                    </div>
                    <div class="col-lg-12">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <table width="100%" class="table table-bordered table-hover" id="table-student-list">
                                    <thead>
                                        <tr>
                                            <?php
                                            if($_SESSION["account_type"] == "77")
                                            {
                                            ?>
                                            <th align="left"><b>Name</b></th>
                                            <th align="left"><b>GCC Code</b></th>
                                            <th align="left"><b>Student ID</b></th>
                                            <th align="left"><b>College - Course</b></th>
                                            <th align="left"><b>Status</b></th>
                                            <th align="left"><b>Action</b></th>
                                            <?php
                                            } else
                                            {
                                            ?>
                                            <th align="left"><b>GCC Code</b></th>
                                            <th align="left"><b>College - Course</b></th>
                                            <th align="left"><b>Action</b></th>
                                            <?php
                                            }
                                            ?>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- page end-->
                        <button id="modalToggle" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none"></button>
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
            var dataTable = $('#table-student-list').DataTable( {
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order":[],
                "ajax":{
                    url :"<?php echo(ROOT); ?>includes/actions/assessment.generate.list.php",
                    method: "POST",
                },
                "columnDefs":[
                    {
                        <?php
                        if($_SESSION["account_type"] == "77")
                        {
                        ?>
                        "targets": [5],
                        "orderable":false
                        <?php
                        } else
                        {
                        ?>
                        "targets": [2],
                        "orderable":false
                        <?php
                        }
                        ?>
                    }
                ]
                <?php
                if($_SESSION['account_type'] == '77')
                {
                ?>
                    ,
                "dom": 'Blfrtip',
                "buttons": [
                    {
                        extend: 'print',
                        exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                        }
                    },
                ]
                <?php
                }
                ?>
            } );
        } );
        $('#table-student-list').on('click', 'tbody tr', function() {
            console.log('TD cell textContent : ', this.id);
        })
    </script>

</html>