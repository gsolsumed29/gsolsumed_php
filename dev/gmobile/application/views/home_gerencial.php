<?php
$user = $this->session->userdata('user');
extract($user);
$co_ven = $this->session->userdata('co_ven');
?>

     <div class="content p-4">
<br>
    <div class="row mb-4" style="margin-left: 0px;margin-right: 0px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Montos facturados en <?php echo date('Y');?>
                </div>
                <div class="card-body">
                    <div id="chart_div_3" style="width: 100%; height: 322px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4" style="margin-left: 0px;margin-right: 0px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Articulos mas vendidos del mes actual
                </div>
                <div class="card-body">
                    <div id="chart_div_4" style="width: 100%; height: 460px;"></div>
                </div>
            </div>
        </div>
    </div>

          </div>

<!-- Inicio de cambio de empresa-->
          <div class="modal fade bd-example-modal-sm" id="cambiar_bd" tabindex="-1" role="dialog" aria-labelledby="modalcambiar_bd" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcambiar_bd">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="form-row">
                    &nbsp;&nbsp;&nbsp;
                <div class="col-md-11 mb-3">
            <label for="nsexo">Empresas</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control form-control-sm" id="bemp_bd" name="bemp_bd">
                    <option value="">Seleccione</option>
                    <?php
                    $empresas = $this->users_model->get_empresas($idusuario);
                    foreach($empresas as $row){
                        echo '<option value="'.trim($row->idemp).'">'.$row->idemp.'</option>';
                    }           
                    ?>
                </select>
            </div>
        </div>
</div>

                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>-->
                    <button type="button" class="btn btn-primary" onclick="cambiar_bd();"><i class="fa fa-save"></i> Cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de cambio de empresa-->


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
  "visits": <?php echo $grafica_fact_montos->ene;?>
}, {
  "country": "FEB",
  "visits": <?php echo $grafica_fact_montos->feb;?>
}, {
  "country": "MAR",
  "visits": <?php echo $grafica_fact_montos->mar;?>
}, {
  "country": "ABR",
  "visits": <?php echo $grafica_fact_montos->abr;?>
}, {
  "country": "MAY",
  "visits": <?php echo $grafica_fact_montos->may;?>
}, {
  "country": "JUN",
  "visits": <?php echo $grafica_fact_montos->jun;?>
}, {
  "country": "JUL",
  "visits": <?php echo $grafica_fact_montos->jul;?>
}, {
  "country": "AGO",
  "visits": <?php echo $grafica_fact_montos->ago;?>
}, {
  "country": "SEP",
  "visits": <?php echo $grafica_fact_montos->sep;?>
}, {
  "country": "OCT",
  "visits": <?php echo $grafica_fact_montos->oct;?>
}, {
  "country": "NOV",
  "visits": <?php echo $grafica_fact_montos->nov;?>
}, {
  "country": "DIC",
  "visits": <?php echo $grafica_fact_montos->dic;?>
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
valueAxis.title.text = "Montos facturados";
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
    
     foreach ($grafica_art_ven as $row) {
?>
  {
    country: "<?php echo $row->co_art.' - '.$row->art_des; ?>",
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

<script type="text/javascript">
function btn_cambiarbd(){
    
        $('#modalcambiar_bd').text('Cambiar Empresa');
        $('#bemp_bd').focus(); 
        $('#cambiar_bd').modal({show:true});       
    
}

function cambiar_bd(){
    var emp=$("#bemp_bd").val();
    if(emp == ""){
        error_msg('Debes seleccionar una empresa.');
        $("#bemp_bd").focus();
    }else{
    var url;
        url = "<?php echo base_url(); ?>user/cambiar_bd/"+emp;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                exito_msg(data.message);
                $('#cambiar_bd').modal('hide');
                location.reload();
                
            }else{
                error_msg(data.message);
            }
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
 
        }
    });
}
    }

     function operacion(){
            reset();
            alertify.success('<center>Operación Realizada con Exito!<br> <i class="fa fa-check-circle"></i></center>');
            return false;
        }

        function noexiste(cliente){
            reset();
            alertify.alertas = alertify.extend("alertas");
            alertify.alertas('<center>No existe ningun '+cliente+' con ese RIF.<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }
        function yaexiste(art){
            reset();
            alertify.error('<center>Ya Existe '+art+'.<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        } 
        function exito_msg(msg){
            reset();
            alertify.success(''+msg+'<br><center><i class="fa fa-check-circle"></i></center>');
            return false;
        }
        function error_msg(msg){
            reset();
            alertify.error(''+msg+'<br><center><i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }  
</script>
    <!--<script src="../alert/lib/jquery-1.9.1.js"></script>-->
    <script src="<?php echo base_url(); ?>alert/lib/alertify.min.js" type="text/javascript"></script>
    <script>
        function reset () {
            $("#toggleCSS").attr("href", "../alert/themes/alertify.default.css");
            alertify.set({
                labels : {
                    ok     : "OK",
                    cancel : "Cancel"
                },
                delay : 5000,
                buttonReverse : false,
                buttonFocus   : "ok"
            });
        }

        // ==============================
        
    </script>

</body>
</html>


