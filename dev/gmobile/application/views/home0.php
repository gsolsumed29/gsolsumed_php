<?php
$user = $this->session->userdata('user');
extract($user);


?>

     <div class="content p-4">
                            <div class="text-center mb-4">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Responsive -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-4097235499795154"
                         data-ad-slot="5211442851"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            
                <h2 class="mb-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-primary text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-cog"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Usage</p>
                    <h3 class="font-weight-bold mb-0">10%</h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-success text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-comments"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Tickets</p>
                    <h3 class="font-weight-bold mb-0">374</h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-danger text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Sales</p>
                    <h3 class="font-weight-bold mb-0">73,829</h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-info text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-users"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Customers</p>
                    <h3 class="font-weight-bold mb-0">1,683</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Sales vs. Expenses
                </div>
                <div class="card-body">
                    <div id="chart_div_3" style="width: 100%; height: 322px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Goals Completed
                </div>
                <div class="card-body">
                    <p class="mb-2">Inventory Stocked</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">75%</div>
                    </div>
                    <p class="mb-2">Products Browsed</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">90%</div>
                    </div>
                    <p class="mb-2">Products Sold</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 35%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">35%</div>
                    </div>
                    <p class="mb-2">Product Back Order</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 15%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">15%</div>
                    </div>
                    <p class="mb-2">Payments Succeeded</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                    <p class="mb-2">Payments Failed</p>
                    <div class="progress">
                        <div class="progress-bar text-dark" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Location Coverage
                </div>
                <div class="card-body">
                    <div id="chart_div_4" style="width: 100%; height: 323px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <div class="card bg-success text-light text-uppercase">
                <div class="card-body py-5">
                    <i class="fa fa-3x fa-chart-pie"></i>
                    <h5 class="mt-2 mb-0">10,342</h5>
                    <p class="mb-4">Visits</p>

                    <i class="fa fa-3x fa-handshake"></i>
                    <h5 class="mt-2 mb-0">70%</h5>
                    <p class="mb-4">Referrals</p>

                    <i class="fa fa-3x fa-leaf"></i>
                    <h5 class="mt-2 mb-0">30%</h5>
                    <p class="mb-0">Organic</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white font-weight-bold">
            Recent Orders
        </div>
        <div class="card-body">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Item</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#">00000077</a></td>
                    <td>Praesent eu viverra leo</td>
                    <td>Kevin Dion</td>
                    <td><span class="badge badge-success">Shipped</span></td>
                </tr>
                <tr>
                    <td><a href="#">00000078</a></td>
                    <td>Lorem ipsum dolor</td>
                    <td>Mark Otto</td>
                    <td><span class="badge badge-success">Shipped</span></td>
                </tr>
                <tr>
                    <td><a href="#">00000079</a></td>
                    <td>Etiam eleifend elit</td>
                    <td>Jacob Thornton</td>
                    <td><span class="badge badge-info">Packaging</span></td>
                </tr>
                <tr>
                    <td><a href="#">00000080</a></td>
                    <td>Donec vitae ante egestas</td>
                    <td>Larry the Bird</td>
                    <td><span class="badge badge-secondary">Back Ordered</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>
<script src="<?php echo base_url(); ?>bootadmin-master/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootadmin.min.js"></script>


<!-- Resources -->
<script src="<?php echo base_url(); ?>amcharts4/core.js"></script>
<script src="<?php echo base_url(); ?>amcharts4/charts.js"></script>
<script src="<?php echo base_url(); ?>amcharts4/themes/material.js"></script>
<script src="<?php echo base_url(); ?>amcharts4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chart_div_3", am4charts.XYChart3D);
// Add data
chart.data = [{
  "country": "ENE",
  "visits": <?php echo $grafica_ordenes->ene;?>
}, {
  "country": "FEB",
  "visits": <?php echo $grafica_ordenes->feb;?>
}, {
  "country": "MAR",
  "visits": <?php echo $grafica_ordenes->mar;?>
}, {
  "country": "ABR",
  "visits": <?php echo $grafica_ordenes->abr;?>
}, {
  "country": "MAY",
  "visits": <?php echo $grafica_ordenes->may;?>
}, {
  "country": "JUN",
  "visits": <?php echo $grafica_ordenes->jun;?>
}, {
  "country": "JUL",
  "visits": <?php echo $grafica_ordenes->jul;?>
}, {
  "country": "AGO",
  "visits": <?php echo $grafica_ordenes->ago;?>
}, {
  "country": "SEP",
  "visits": <?php echo $grafica_ordenes->sep;?>
}, {
  "country": "OCT",
  "visits": <?php echo $grafica_ordenes->oct;?>
}, {
  "country": "NOV",
  "visits": <?php echo $grafica_ordenes->nov;?>
}, {
  "country": "DIC",
  "visits": <?php echo $grafica_ordenes->dic;?>
}];

// Create axes
let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.hideOversized = false;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.tooltip.label.rotation = 270;
categoryAxis.tooltip.label.horizontalCenter = "right";
categoryAxis.tooltip.label.verticalCenter = "middle";

let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Ordenes";
valueAxis.title.fontWeight = "bold";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.name = "Visits";
series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;
columnTemplate.stroke = am4core.color("#FFFFFF");

columnTemplate.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

columnTemplate.adapter.add("stroke", function(stroke, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.strokeOpacity = 0;
chart.cursor.lineY.strokeOpacity = 0;

}); // end am4core.ready()
</script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart
var chart = am4core.create("chart_div_4", am4charts.PieChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.data = [
<?php 
    $grafica_estudios = $this->users_model->grafica_estudios($cimprir);
     foreach ($grafica_estudios as $row) {
?>
  {
    country: "<?php echo $row->codigo.' - '.$row->Nom_exa; ?>",
    value: <?php echo $row->cant; ?>
  },
 <?php } ?> 
];

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "value";
series.dataFields.radiusValue = "value";
series.dataFields.category = "country";
series.slices.template.cornerRadius = 6;
series.colors.step = 3;
series.slices.template.tooltipText = "{category}: {value.value}";
series.labels.template.text = "{value.percent.formatNumber('#.0')}%";

series.hiddenState.properties.endAngle = -90;

chart.legend = new am4charts.Legend();

}); // end am4core.ready()
</script>


    
</body>
</html>


