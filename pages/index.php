<?php
include("../initialize.php");
includeCore();
includeDashboardFunctions();
includeDashboardModal();
$evac_centers = getEvacuationCenters();
$takers_month= getFormAnswersDistinctDate();
$account_type = $_SESSION["account_type"];
if(!isset($_GET['evac_id']))
{
        $evac_id = 1;

}
else
{
    $evac_id = $_GET['evac_id'];

}
if(!isset($_GET['month']))
{
        $month = "August";

}
else
{
    $month = $_GET['month'];

}

if(!isset($_GET['month1']))
{
        $month1 = "August";

}
else
{
    $month1 = $_GET['month1'];

}
if(!isset($_GET['month2']))
{
        $month2 = "August";

}
else
{
    $month2 = $_GET['month2'];

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
                                        <div>Students</div>
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
                                <i class="fa fa-bar-chart-o fa-fw"></i> Students Per College/School
                            </div>
                            <div class="panel-body">
                                <canvas width="400" height="350" id="morris-donut-evac"></canvas>
                            </div>
                        </div>
                    </div>

                    

                   <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Student
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            College/School
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
                                        <canvas id="evac1"></canvas>
                                
                                <?php 
                                    }  
                                else 
                                    { 
                                ?>      
                                        <div> No Students in this college/school </div>
                                
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
                                <i class="fa fa-bar-chart-o fa-fw"></i> Gender
                            </div>
                            <div class="panel-body">
                                 <div id="morrisdetails-item" class="morris-hover morris-default-style" style="display: none">
                                <div class="morris-hover-row-label"></div>
                              <div class="morris-hover-point"></div>
                                   </div>
                                <canvas id="piechart" width="400" height="350"></canvas> 
                                
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Age
                            </div>
                            <div class="panel-body">
                                <canvas width="400" height="350" id="morris-donut2-chart"></canvas> 
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Education
                            </div>
                            <div class="panel-body">

                             
                                         <canvas width="400" height="350" id="morris-Education"></canvas>
                                
                             
                                
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Marital Status
                            </div>
                            <div class="panel-body">
                                 <canvas width="400" height="350" id="morris-donut-marital"></canvas>
                                
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Religion
                            </div>
                            <div class="panel-body">
                                <canvas width="400" height="350" id="morris-donut-religion"></canvas>
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
    $("#sizelist1").on("click", "a", function(e)
    {
         e.preventDefault();
         var $this = $(this).parent();
         $this.addClass("select").siblings().removeClass("select");
         $('#evac' + $this.data("value")).show();
         window.location.href = "index.php?month=" + $this.data("value"); 
    })
     $("#sizelist2").on("click", "a", function(e)
    {
         e.preventDefault();
         var $this = $(this).parent();
         $this.addClass("select").siblings().removeClass("select");
         $('#evac' + $this.data("value")).show();
         window.location.href = "index.php?month1=" + $this.data("value"); 
    })
    $("#sizelist3").on("click", "a", function(e)
    {
         e.preventDefault();
         var $this = $(this).parent();
         $this.addClass("select").siblings().removeClass("select");
         $('#evac' + $this.data("value")).show();
         window.location.href = "index.php?month=" + $this.data("value"); 
    })
    
    </script>
</html>