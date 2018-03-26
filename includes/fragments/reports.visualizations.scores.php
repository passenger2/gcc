<?php
include("../../initialize.php");
includeCore();
$toolsList = getAllAssessmentTools();
?>
<div>
    <select id="toolSelect">
        <?php
        foreach($toolsList as $tool)
        {
        ?>
        <option value="<?php echo($tool["AssessmentToolID"]); ?>"><?php echo($tool["Name"]); ?></option>
        <?php
        }
        ?>
    </select>
</div>
<div class="assessment-scores">
    <script type="text/javascript">
        function drawScatterScore(data) {
            "use strict";
            var margin = 75,
                width = 1400 - margin,
                height = 600 - margin;

            d3.select(".assessment-scores")
                .append('h2')
                .attr('class','clabel')
                .text('Score distribution per assessment tool');

            var svg = d3.select(".assessment-scores")
            .append("svg")
            .attr("width", width + margin)
            .attr("height", height + margin)
            .append('g')
            .attr('class','chart');

            var myChart = new dimple.chart(svg, data);
            myChart.setBounds(50, 20, 660, 360);
            var x = myChart.addMeasureAxis("x", "Number of Students"); 
            myChart.addMeasureAxis("y", "Score");
            //myChart.addSeries(null, dimple.plot.line);
            myChart.addSeries(["Assessment Tool", "Score", "Number of Students"], dimple.plot.scatter);
            myChart.draw();
        };

        function drawPiePF(data) {
            "use strict";
            var margin = 75,
                width = 1400 - margin,
                height = 600 - margin;

            d3.select(".assessment-scores")
                .append('h2')
                .attr('class','clabel')
                .text('Pass-Fail Percentage');

            var svg = d3.select(".assessment-scores")
            .append("svg")
            .attr("width", width + margin)
            .attr("height", height + margin)
            .append('g')
            .attr('class','chart');

            var myChart = new dimple.chart(svg, data);
            myChart.setBounds(20, 20, 460, 360);
            var x = myChart.addMeasureAxis("p", "Number of Students");
            x.tickFormat = "l";
            var ring = myChart.addSeries(["Passed"], dimple.plot.pie);
            ring.innerRadius = "50%";
            myChart.addLegend(500, 20, 90, 300, "left");
            myChart.draw();
        };

    </script>
    <script type="text/javascript">
        $("#toolSelect").change(function(){
            d3.select("svg").remove();
            d3.select("svg").remove();
            d3.select(".clabel").remove();
            d3.select(".clabel").remove();
            d3.json("/includes/actions/reports.data.scores.php?atid="+$(this).val(), drawScatterScore);
            d3.json("/includes/actions/reports.data.passfail.php?atid="+$(this).val(), drawPiePF);
        });
    </script>
</div>