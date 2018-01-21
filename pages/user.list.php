<?php
die("Under Construction <a href='".$_SERVER["HTTP_REFERER"]."'>back</a>");
include("../initialize.php");
includeCore();

$_SESSION['loc'] = $_SERVER['PHP_SELF'];

$agencies = getAgencies();
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php
        includeHead("PSRMS - Account Management");
        includeDataTables();
        ?>

    </head>

    <body>

        <div id="wrapper">
            
            <?php includeNav(); ?>
            
            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Account Management</li>
                    </ol>
                </div>
                <?php
                if(isset($_GET['status']) && $_GET['status'] == 'enrollsuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Account creation successful!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'updatesuccess')
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Account edited successfully!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'matcherror')
                {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    New passwords does not match!
                </div>
                <?php
                } else if (isset($_GET['status']) && $_GET['status'] == 'passerror')
                {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Email and password combination not found in the database!
                </div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Account Management&nbsp;<a href="user.enroll.php" type="button" class="btn btn-success btn-xs btn-fill">Register new user</a></h3>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table width="100%" class="table table-bordered table-hover" id="table-user-list">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Phone No.</th>
                                            <th>Agency</th>
                                            <th>Date Enrolled</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>

        </div>
        <!-- /#wrapper -->

        <?php includeCommonJS(); ?>

    </body>
    
    <script type='text/javascript'>
        $(document).ready(function() {
            var dataTable = $('#table-user-list').DataTable( {
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order":[],
                "ajax":{
                    url :"<?php echo(ROOT); ?>includes/actions/user.generate.list.php",
                    method: "POST",
                },
                "columnDefs":[
                    {
                        "targets": [4],
                        "orderable":false
                    },
                ]
            } );
        } );
    </script>
    
</html>