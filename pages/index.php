<?php
include("../initialize.php");
includeCore();
includeDashboardFunctions();
includeDashboardModal();
$evac_centers = getEvacuationCenters();
if(!isset($_GET['evac_id']))
{
        $evac_id = 1;

}
else
{
    $evac_id = $_GET['evac_id'];

}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Dashboard"); ?>

    </head>

    <body class="hold-transition skin-blue sidebar-mini fixed">

        <div class="wrapper">
            
           <?php includeNav(); ?>

              <div id="page-wrapper">
               
               <div class="row">
                    <br>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                
                <div class="row">
                   
                   <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo get_total("idp");?></div>
                                        <div>IDP</div>
                                    </div>
                                </div>
                            </div>
                            <a href="idp.list.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-home  fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo get_total("evacuation_centers");?></div>
                                        <div>Evacuation Centers</div>
                                    </div>
                                </div>
                            </div>
                            <a href="evac.manage.centers.php">
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
                                        <i class="fa fa-user  fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo get_total("account");?></div>
                                        <div>User Registered</div>
                                    </div>
                                </div>
                            </div>
                            <a href="user.enroll.php">
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
                                        <div class="huge"><?php echo get_total("form");?></div>
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
                    
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Gender
                            </div>
                            <div class="panel-body">
                                 <div id="morrisdetails-item" class="morris-hover morris-default-style" style="display: none">
                                <div class="morris-hover-row-label"></div>
                              <div class="morris-hover-point"></div>
                                   </div>
                                <div id="morris-donut-chart"></div>
                                
                            </div>

                        </div>
                    </div>


                   <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> IDP
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Evacuation Centers
                                            <span class="caret"></span>
                                        </button>
                                        <ul id = "sizelist" class="dropdown-menu pull-right" role="menu">

                                            <?php
                                                        foreach ($evac_centers as $result) {
                                                        ?>
                                                        <li data-value = "<?php echo($result['EvacuationCentersID']); ?>"><a href="#"><?= $result['EvacName']; ?></a>
                                                        </li>

                                                        
                                             <?php } ?>

                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>

                            <div><center> <?php echo $evac_centers[$evac_id-1]['EvacName']; ?> </center></div>
                            <div class="panel-body">

                                <?php
                               
                                if(getDistinctDate($evac_id) !=NULL)
                                    {
                                ?>
                                        <div id="evac1"></div>
                                
                                <?php 
                                    }  
                                else 
                                    { 
                                ?>      
                                        <div> No IDPs in these evacaution </div>
                                
                                <?php
                                    } 
                                ?>
                                
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Age
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut2-chart"></div>
                                <a href="#" class="btn btn-default btn-block">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Education
                            </div>
                            <div class="panel-body">

                             
                                        <div id="morris-Education"></div>
                                
                             
                                
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Marital Status
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-marital"></div>
                                <a href="#" class="btn btn-default btn-block">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                  <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Religion
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-religion"></div>
                            </div>
                        </div>
                    </div>
                </div>

                

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->


        <?php 
        includeCommonJS(); 
        includeMorrisData();
        ?>

    </body>
      <script type="text/javascript">
    
    $("#sizelist").on("click", "a", function(e)
    {
         e.preventDefault();
         var $this = $(this).parent();
         $this.addClass("select").siblings().removeClass("select");
         $('#evac' + $this.data("value")).show();
         window.location.href = "index.php?evac_id=" + $this.data("value"); 
    })
    
    </script>
</html>