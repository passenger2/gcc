 <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Age
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut2-chart"></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Education
                            </div>
                            <div class="panel-body">

                             
                                        <div id="morris-Education"></div>
                                
                             
                                
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Marital Status
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-marital"></div>
                                
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
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> IDP Counts Per Assessment Takes
                            </div>
                            <div class="panel-body">
                                <div id="charts-form-takers-count"></div>
                            </div>
                        </div>
                    </div>
                 </div>
                <?php
                if($account_type = 77)
                 {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> PHQ9
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Select Month
                                            <span class="caret"></span>
                                        </button>
                                        <ul id = "sizelist1" class="dropdown-menu pull-right" role="menu">

                                            <?php
                                                        foreach ($takers_month as $taker_month) {
                                                        ?>
                                                        <li data-value = "<?php echo($taker_month['MONTH']); ?>"><a href="#"><?= $taker_month['MONTH']; ?></a>
                                                        </li>

                                                        
                                             <?php } ?>

                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>

                            <div><center> <?php echo $taker_month['MONTH']; ?> </center></div>
                            <div class="panel-body">

                                <?php
                               
                                if(getIDPCount(3, $month) !=NULL)
                                    {
                                ?>
                                        <canvas  id="PHQ9"></canvas >
                                
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
                
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> GAD [Degree of being bothered]
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Select Month
                                            <span class="caret"></span>
                                        </button>
                                        <ul id = "sizelist2" class="dropdown-menu pull-right" role="menu">

                                            <?php
                                                        foreach ($takers_month as $taker_month) {
                                                        ?>
                                                        <li data-value = "<?php echo($taker_month['MONTH']); ?>"><a href="#"><?= $taker_month['MONTH']; ?></a>
                                                        </li>

                                                        
                                             <?php } ?>

                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>

                            <div><center> <?php echo $month1; ?> </center></div>
                            <div class="panel-body">

                                <?php
                               
                                if(getIDPCount(12, $month1) !=NULL)
                                    {
                                ?>
                                        <div id="GAD1"></div>
                                
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

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> GAD [Frequency]
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Select Month
                                            <span class="caret"></span>
                                        </button>
                                        <ul id = "sizelist3" class="dropdown-menu pull-right" role="menu">

                                            <?php
                                                        foreach ($takers_month as $taker_month) {
                                                        ?>
                                                        <li data-value = "<?php echo($taker_month['MONTH']); ?>"><a href="#"><?= $taker_month['MONTH']; ?></a>
                                                        </li>

                                                        
                                             <?php } ?>

                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>

                            <div><center> <?php echo $month2 ; ?> </center></div>
                            <div class="panel-body">

                                <?php
                               
                                if(getIDPCount(13, $month2) !=NULL)
                                    {
                                ?>
                                        <div id="GAD2"></div>
                                
                                <?php 
                                    }  
                                else 
                                    { 
                                ?>      
                                        <div> No Answer Yet </div>
                                
                                <?php
                                    } 
                                ?>
                                
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                }
                ?>







                <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count per IDP'], 
          ['Male',     <?php echo $total_male; ?>],
          ['Female',      <?php echo $total_female; ?>]
        ]);

        var options = {
          title: 'My Daily Activities'
          ,legend : { position: 'left'}
          ,chartArea:{right:100,top:-10,width:"100%",height:"100%"}
          ,height: 350
           ,width: 300,
           is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechartz'));

        chart.draw(data, options);
      }
</script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Age Classification', 'Counts per IDP'], 
          ['Undefined', <?php echo $total_undefined; ?>],
          ['Children',     <?php echo $total_children; ?>],
          ['Adults',     <?php echo $total_adults; ?>],
          ['Senior',      <?php echo $total_senior; ?>]
        ]);

        var options = {
          title: 'Age Classfication'
          ,legend : { position: 'left'}
          ,chartArea:{right:100,top:-10,width:"150%",height:"100%"}
          ,height: 350
           ,width: 300,
           is3D: true,
           sliceVisibilityThreshold:0
        };

        var chart = new google.visualization.PieChart(document.getElementById('morris-donut2-chart'));

        chart.draw(data, options);
      }
</script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Marital Status', 'Counts per IDP'],
          ['Single',      <?php echo $total_single; ?>], 
          ['Married', <?php echo $total_married; ?>],
          ['Anulled',      <?php echo $total_Anulled; ?>],
          ['Widowed',      <?php echo $total_Widowed; ?>]
        ]);

        var options = {
          title: 'Marital Status'
          ,legend : { position: 'left'}
          ,chartArea:{right:100,top:-10,width:"150%",height:"100%"}
          ,height: 350
           ,width: 300,
           is3D: true,
           sliceVisibilityThreshold:0
        };

        var chart = new google.visualization.PieChart(document.getElementById('morris-donut-marital'));

        chart.draw(data, options);
      }
</script>


<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Religion', 'Counts per IDP'], 
          <?php  foreach($religion_data as $row) {
             $religion = $row['Religion'];
             if($religion == NULL)
             {
              $religion = "Unspecified";
             }
             $idp_count = $row['TOTAL'];
             
        ?>
          ['<?php echo $religion; ?>', <?php echo $idp_count; ?>], <?php } ?>
          
        ]);

        var options = {
          title: 'Marital Status'
          ,legend : { position: 'left'}
          ,chartArea:{right:100,top:-10,width:"150%",height:"100%"}
          ,height: 350
           ,width: 300,
           is3D: true,
           sliceVisibilityThreshold:0
        };

        var chart = new google.visualization.PieChart(document.getElementById('morris-donut-religion'));

        chart.draw(data, options);
      }

</script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Educational Attainment', 'Counts per IDP'],             
          ['Grade School', <?php echo $idp_count_gradeschool; ?>],
          ['Highschool', <?php echo $idp_count_hs; ?>],
          ['College', <?php echo $idp_count_col; ?>],
          ['Unspecified', <?php echo $idp_count_unspecified; ?>]]);

        var options = {
          title: 'Marital Status'
          ,legend : { position: 'left'}
          ,chartArea:{right:100,top:-10,width:"150%",height:"100%"}
          ,height: 350
           ,width: 300,
           is3D: true,
           sliceVisibilityThreshold:0
        };

        var chart = new google.visualization.PieChart(document.getElementById('morris-Education'));

        chart.draw(data, options);
      }

</script>



<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        
        var data = google.visualization.arrayToDataTable([
         ['Month', 

                 <?php

                        foreach ($form_names as $form_name) 
                        {
                            
                            $form_type= $form_name['FormType'];
                            echo "'".$form_type."',";
                        }
                ?>

        ],
        
        <?php 

            foreach ($takers_dates as $takers_date) {
                
                echo "['". $takers_date['MONTH']. "',";

                    foreach ($form_names2 as $form_name1) {
                         $form_id= $form_name1['FormID'];
                         $values = getIDPCount($form_id, $takers_date['MONTH']);
                            
                            foreach ($values as $value) {
                                $str = $value['TOTAL'];
                                echo $str;
                            }
                            echo ",";

                     }

                    echo "],";
            }
        ?>

      


        ]);

    var options = {
      title : 'Monthly Takers  by Assessment Tools',
      vAxis: {title: 'IDP Takers'},
      hAxis: {title: 'Month'},
      seriesType: 'bars',
      height: 400,
      width: 600,
    };

    var chart = new google.visualization.ComboChart(document.getElementById('charts-form-takers-count'));
    chart.draw(data, options);

    google.visualization.events.addListener(chart, 'select', selectHandler);

    function selectHandler() {
    var selectedItem = chart.getSelection()[0];
    if (selectedItem) {
      var value = data.getValue(selectedItem.row, selectedItem.column);
      alert('The user selected ' + value + "asdsa" + data.getColumnLabel(selectedItem.column) + selectedItem.row);
    }
  }

  }


    </script>

   

  
   <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
         <?php
            

                foreach ($Gad_data1 as $datum) {
                    if($datum['Score'] >= 10)
                    {
                    echo "['" . getIDPName($datum['IDP_IDP_ID']). "'," . $datum['Score']. ", 'red'],";
                    }
                    else
                    {
                        echo "['" . getIDPName($datum['IDP_IDP_ID']). "'," . $datum['Score']. ", 'green'],";
                    }
                }
            ?>
      ]);

     

      var options = {
        title: "GAD [Frequency]",
        width: 1000,
        height: 400,
        bar: {groupWidth: "100%"},
        legend: {position:"none",}


      };
      var chart = new google.visualization.Histogram(document.getElementById("GAD1"));
      chart.draw(data, options);
  }
  </script>

  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
         <?php
            

                foreach ($phq_data as $datum) {
                    if($datum['Score'] >= 10)
                    {
                    echo "['" . getIDPName($datum['IDP_IDP_ID']). "'," . $datum['Score']. ", 'red'],";
                    }
                    else
                    {
                        echo "['" . getIDPName($datum['IDP_IDP_ID']). "'," . $datum['Score']. ", 'green'],";
                    }
                }
            ?>
      ]);

     

      var options = {
        title: "GAD [Frequency]",
        width: 1000,
        height: 400,
        bar: {groupWidth: "100%"},
        legend: {position:"none",}


      };
      var chart = new google.visualization.Histogram(document.getElementById("GAD2"));
      chart.draw(data, options);
  }
  </script>
   <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['IDP NAME', 'SCORE'],
             <?php
            

                foreach ($phq_data as $datum) {
                    if($datum['Score'] >= 10)
                    {
                    echo "['" . getIDPName($datum['IDP_IDP_ID']). "'," . $datum['Score']. "],";
                    }
                    else
                    {
                        echo "['" . getIDPName($datum['IDP_IDP_ID']). "'," . $datum['Score']. "],";
                    }
                }
            ?>
            ]);

        var options = {
          title: 'PHQ9',
          legend: { position: 'none' },
        };

        var chart = new google.visualization.Histogram(document.getElementById('PHQ91'));
        chart.draw(data, options);
      }
    </script>