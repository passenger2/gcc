<?php

$total_male = get_total('idp where gender =1');
$total_female = get_total('idp where gender =2');

$total_married =  get_total('idp WHERE MaritalStatus = 2');
$total_single =  get_total('idp WHERE MaritalStatus = 1');
$total_Anulled =  get_total('idp WHERE MaritalStatus = 3');
$total_Widowed =  get_total('idp WHERE MaritalStatus = 4');
$education_data = getDistinctEducation();
$religion_data = getDistinctReligion();

$total_children = get_total('age', 'children');
$total_adults = get_total('age', 'adults');
$total_senior = get_total('age', 'senior');
$total_undefined = get_total('age', 'undefined');
$form_names = getForms();
$form_names2 = getForms();
$assessment_takers = getAssessmentTakerCount();

$takers_dates = getFormAnswersDistinctDate();

$idp_count_evac_data = getIDPCountPerEvac();

if(!isset($_GET['evac_id']))
    {
        $evac_id = 1;
         $evac1_data = getDistinctDate($evac_id);
    }
else
    {
        $evac_id = $_GET['evac_id'];
         $evac1_data = getDistinctDate($evac_id);
    } 


if(!isset($_GET['month']))
    {
        $month = $takers_dates[0]["MONTH"];
        $phq_data = getScores(3, $month);
       
    }
else
    {
        $month = $_GET['month'];
         $phq_data = getScores(3, $month);
       
    } 

if(!isset($_GET['month1']))
    {
        $month = $takers_dates[0]["MONTH"];
        $Gad_data1 = getScores(12, $month);
       
    }
else
    {
        $month =$takers_dates[0]["MONTH"];
         $Gad_data1 = getScores(12, $month);

    } 
if(!isset($_GET['month2']))
    {
        $month = $takers_dates[0]["MONTH"];
        $Gad_data2 = getScores(13, $month);
       
    }
else
    {
        $month = $_GET['month2'];
         $Gad_data2 = getScores(13, $month);

    } 


$idp_count_gradeschool =0;
$idp_count_hs =0;
$idp_count_col =0;
$idp_count_unspecified =0;
            foreach($education_data as $row) {
             $education = $row['education'];
              
             $idp_count = $row['TOTAL'];
             if($education == NULL)
             {
              $education = "Unspecified ";
              $idp_count_unspecified += $idp_count;
             
            
             }

             if($education <=6 && $education >=1)
             {
              $education = "Grade School" ;
              $idp_count_gradeschool += $idp_count;
               
             }
             if($education >=7 && $education <= 10)
             {
              $education = "Highschool" ;
                $idp_count_hs +=$idp_count;
             }
             if($education >= 11)
             {
              $education = "College ";
              $idp_count_col += $idp_count;
             
            
             }
             
         }


             
?>







<script>

var ctx = document.getElementById("piechart");
var myChart = new Chart(ctx, {
    type: 'pie',
    data:{
    datasets: [{
        data: [<?php echo $total_male; ?>, <?php echo $total_female; ?>],
        backgroundColor: ["#3e95cd", "#8e5ea2"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Male',
        'Female'
    ],},
    options:{
          responsive: true,
          maintainAspectRatio: false,
          pieceLabel: {
            render: 'percentage',
            fontColor: 'white',
            precision: 2
          }}
});


</script>

<script>

var ctx = document.getElementById("morris-donut-evac");
var myChart = new Chart(ctx, {
    type: 'pie',
    data:{
    datasets: [{
        data: [

        <?php
            foreach ($idp_count_evac_data as $result) {
               echo $result['TOTAL']. ",";
             } 
        ?>],
        backgroundColor: ["#3e95cd", "#8e5ea2","#ff6384", "#ffce56"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
   <?php
            foreach ($idp_count_evac_data as $result) {
               echo "'" .getEvacName($result['EvacuationCenters_EvacuationCentersID']). "',";
             } 
        ?>],},
    options:{
          responsive: true,
          maintainAspectRatio: false,
          pieceLabel: {
            render: 'value',
            fontColor: 'white',
            precision: 2
          }}
});


</script>

<script type="text/javascript">
  



     var ctx1 = document.getElementById("evac1");
var myChart1 =  new Chart(ctx1, {
    type: 'line',
    data: {
  labels: [
            <?php 
            foreach($evac1_data as $row) {
             $date = $row['dates'];
            
             $idp_count = $row['total'];
             echo "'". $date ."',";} ?>
          ],
  datasets: [{
    label: "Students Enrolled Per Month",
    data: [
            <?php 
            foreach($evac1_data as $row) {
             
             $idp_count = $row['total'];
             echo $idp_count .","; 
           }?>
          ],
    lineTension: 0,
    fill: false,
    borderColor: 'orange',
    backgroundColor: 'transparent',
    borderDash: [5, 5],
    pointBorderColor: 'orange',
    pointBackgroundColor: 'rgba(255,150,0,0.5)',
    pointRadius: 5,
    pointHoverRadius: 10,
    pointHitRadius: 30,
    pointBorderWidth: 2,
    pointStyle: 'rectRounded'
  }]
},
    options: {
        elements: {
            line: {
                tension: 0, // disables bezier curves
            }
        }
    }
});

</script>

<script>

var ctx = document.getElementById("morris-donut2-chart");
var myChart = new Chart(ctx, {
    type: 'pie',
    data:{
    datasets: [{
        data: [<?php echo $total_undefined ."," . $total_children ."," . $total_adults ."," . $total_senior?>],
        backgroundColor: ["#3e95cd", "#8e5ea2", "#ff6384", "#ffce56"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Undefined',
        'Children',
        'Adults', 
        'Senior'
    ],},
    options:{
          responsive: true,
          maintainAspectRatio: false,
          pieceLabel: {
            render: 'percentage',
            fontColor: 'white',
            precision: 2
          }}
});


</script>

<script type="text/javascript">
      
      var ctx = document.getElementById("morris-donut-marital");
var myChart = new Chart(ctx, {
    type: 'pie',
    data:{
    datasets: [{
        data: [<?php echo $total_single ."," . $total_married ."," . $total_Anulled ."," . $total_Widowed?>],
        backgroundColor: ["#3e95cd", "#8e5ea2", "#ff6384", "#ffce56"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Single',
        'Married',
        'Anulled', 
        'Widowed'
    ],},
    options:{
          responsive: true,
          maintainAspectRatio: false,
          pieceLabel: {
            render: 'percentage',
            fontColor: 'white',
            precision: 0
          }}
});
</script>

<script type="text/javascript">
     
      var ctx = document.getElementById("morris-Education");
var myChart = new Chart(ctx, {
    type: 'pie',
    data:{
    datasets: [{
        data: [<?php echo $idp_count_gradeschool ."," . $idp_count_hs ."," . $idp_count_col ."," . $idp_count_unspecified?>],
        backgroundColor: ["#3e95cd", "#8e5ea2", "#ff6384", "#ffce56"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Grade School',
        'Highschool',
        'College', 
        'Unspecified'
    ],},
    options:{
          responsive: true,
          maintainAspectRatio: false,
          pieceLabel: {
            render: 'percentage',
            fontColor: 'white',
            precision: 0
          }}
});
</script>
<script type="text/javascript">

        var ctx = document.getElementById("morris-donut-religion");
var myChart = new Chart(ctx, {
    type: 'pie',
    data:{
    datasets: [{
        data: [
         <?php  foreach($religion_data as $row) {
             $religion = $row['Religion'];
             if($religion == NULL)
             {
              $religion = "Unspecified";
             }
             $idp_count = $row['TOTAL'];
             echo $idp_count . ",";
             }
        ?>
       
        ],
        backgroundColor: ["#3e95cd", "#8e5ea2", "#ff6384", "#ffce56"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        <?php  foreach($religion_data as $row) {
             $religion = $row['Religion'];
             if($religion == NULL)
             {
              $religion = "Unspecified";
             }
             $idp_count = $row['TOTAL'];
             echo "'". $religion . "',";
             }
        ?>
    ],},
    options:{
          responsive: true,
          maintainAspectRatio: false,
          pieceLabel: {
            render: 'percentage',
            fontColor: 'white',
            precision: 2
          }}
});
      
          
          
      


</script>


        
       

      




    <script>
        
        var horizontalBarChartData = {
           

            datasets: [

                            
                {
                label: [],
                borderWidth: 1,
                backgroundColor: ["#3e95cd", "#8e5ea2", "#ff6384", "#ffce56"],
                showLine:false,
                pointHoverRadius:15,
                fill: false,
                pointRadius: 10,

                data: [
                              <?php 

                                foreach ($phq_data as $value) {
                                        $str = $value['Score'];
                                
                                  echo $str.",";
                               } ?>            
                    ]
            },
           
            ]

        };

            var ctx = document.getElementById("charts-form-takers-count");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: horizontalBarChartData,
                options: {
                    responsive: true,
                    title:{
                        display:true,
                        
                    },
                    legend: {
                        display: false
                    },
                    elements: {
                        point: {
                            pointStyle: 'Circle'
                        }
                    },
                       scales: {
        xAxes: [{
            ticks: {
                max: 150,
                min: 0,
                stepSize: 10
            }
        }]
    }
                }
            });

       

        
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

