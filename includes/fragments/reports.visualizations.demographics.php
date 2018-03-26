<div id="tabs-1" class="college-pop">
    <script type="text/javascript">
        function draw(data) {
            "use strict";
            var margin = 75,
                width = 1400 - margin,
                height = 600 - margin;

            var svg = d3.select(".college-pop")
            .append("svg")
            .attr("width", width + margin)
            .attr("height", height + margin)
            .append('g')
            .attr('class','chart');

            var myChart = new dimple.chart(svg, data);
            myChart.setBounds(20, 20, 460, 360);
            var x = myChart.addMeasureAxis("p", "Enrolled Population");
            x.title = "Enrolled population";
            x.tickFormat = "l";
            var ring = myChart.addSeries(["College Code", "College Name"], dimple.plot.pie);
            ring.innerRadius = "50%";
            myChart.addLegend(500, 20, 90, 300, "left");
            myChart.draw();
        };
    </script>
    <div>
        <h4>Population per College</h4>
    </div>
    <script type="text/javascript">
        d3.json("/includes/actions/reports.data.demographics.php", draw);
    </script>
                            </div>