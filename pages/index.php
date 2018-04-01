<?php
include("../initialize.php");
includeCore();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Dashboard"); ?>

    </head>

    <body>

        <div class="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="header">
                        <h3 class="title">&nbsp;Dashboard</h3>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo(getTotalRecords("Student", 0)); ?></div>
                                        <div>Students Enrolled</div>
                                    </div>
                                </div>
                            </div>
                            <a href="reports.visualizations.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-plus fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo(getTotalRecords("StudentsAssessed", 0)); ?></div>
                                        <div>Students Assessed</div>
                                    </div>
                                </div>
                            </div>
                            <a href="student.list.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-md fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo(getTotalRecords("Users", 0)); ?></div>
                                        <div>Users Registered</div>
                                    </div>
                                </div>
                            </div>
                            <a href="user.list.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa  fa-pencil-square-o  fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo(getTotalRecords("Tool", 0)); ?></div>
                                        <div>Assessment Tools</div>
                                    </div>
                                </div>
                            </div>
                            <a href="forms.manage.tools.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>
        <script>
            $( function() {
                $( "#birds" ).autocomplete({
                    source: "/includes/actions/student.autocomplete.address.php",
                    minLength: 2,
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#birds").val(ui.item.label);
                    }
                });
            } );
        </script>

    </body>

</html>