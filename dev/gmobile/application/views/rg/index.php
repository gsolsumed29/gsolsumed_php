<?php
                $user = $this->session->userdata('user');
                extract($user);
                $co_ven = $this->session->userdata('co_ven');
$date_now = date('Y-m-d');
$date_past = strtotime('-15 day', strtotime($date_now));
$date_past = date('Y-m-d', $date_past);
$fecha = new DateTime();
$fecha->modify('first day of this month');
$date_past=$fecha->format('Y-m-d'); // imprime por ejemplo: 01/12/2012
$date = date('Y-m-d');
$date_now=date("Y-m-t", strtotime($date));
            ?>
<div class="content p-4">
   <div class="card mb-4">
    <form id="formulario_lineas" name="formulario_lineas" method="post" >
        <div class="card-header bg-white font-weight-bold">
                <div class="form-row">

                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="fini" name="fini" placeholder="dd/mm/yyyy" title="Fecha Emisi&oacute;n Desde" value="<?php echo $date_past;?>" onkeypress="validarenter_consulta(event)" onchange="consultar();">
                </div>

                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="ffin" name="ffin" placeholder="dd-mm-yyyy" title="Fecha Emisi&oacute;n Hasta" value="<?php echo $date_now;?>" onkeypress="validarenter_consulta(event)" onchange="consultar();">
                </div>

                <div class="col-md-2 mb-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-list"></i></div>
                        </div>
                        <select class="form-control" id="fcosto" name="fcosto" data-toggle="tooltip" data-original-title="Costo" onchange="consultar();">
                            <option value="1">COSTO PROMEDIO</option>
                            <option value="2">ULTIMO COSTO</option>
                            <option value="3">COSTO PIE</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 mb-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-list"></i></div>
                        </div>
                        <select class="form-control" id="co_alma" name="co_alma" data-toggle="tooltip" data-original-title="Sucursal" onchange="consultar();">
                            <option value="0">TODAS..</option>
                            <?php foreach($sucursales as $row){ 
                                echo '<option value="'.$row->co_alma.'">'.$row->co_alma.' - '.$row->alma_des.'</option>';
                                
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 mb-1">
                    <div class=" btn-group-sm btnderecha">
                                <button type="button" class="btn btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                                <button type="button" class="btn btn-warning" data-toggle="tooltip" data-original-title="Limpiar Campos" onclick="limpiar()">&nbsp; <i class="fas fa-undo"></i> &nbsp;</button>
                                
                                
                            </div>
                </div>
                
                </div>
                
        <!--input id="co_ven" name="co_ven" value="<?php echo trim($co_ven);?>" type="hidden"-->
              <input id="codcliente" name="codcliente" value="0" type="hidden">
                </form>
        <div class="card-body">
            <button id="btn-show-all-children" style="display: none"> open</button>
            <table id="table_det_admission" class="table table-hover" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">REPORTE DIARIO DE VENTAS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>TOTAL FACTURACION DEL PERIODO:</th>
                    <td id="tfacturado" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>TOTAL DE DEVOLUCIONES-N/CR O DXPP:</th>
                    <td id="tncr" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>TOTAL DE VENTAS:</th>
                    <td id="tventas" style="text-align: right;">0.000,00</td>
                </tr>
                <!--tr>
                    <th colspan="2" style="text-align: center;">COSTO DE VENTA DE MERCANCIA</th>
                </tr-->
                <tr>
                    <th>COSTO DE VENTA DE MERCANCIA:</th>
                    <td id="tcosmer" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>COSTO DE VENTA DE MERCANCIA EN DEVOLUCIONES:</th>
                    <td id="tcosdev" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>TOTAL COSTO DE VENTA:</th>
                    <td id="tcostos" style="text-align: right;">0.000,00</td>
                </tr>
                <!--tr>
                    <th colspan="2" style="text-align: center;">UTILIDAD BRUTA EN VENTA</th>
                </tr-->
                <!--tr>
                    <th>UTILIDAD BRUTA EN VENTA:</th>
                    <td id="tutibruvta" style="text-align: right;">0.000,00</td>
                </tr-->

                <!--tr>
                    <th colspan="2" style="text-align: center;">UTILIDAD BRUTA NETA</th>
                </tr-->
                <tr>
                    <th>UTILIDAD BRUTA EN VENTA:</th>
                    <td id="tutibruvta2" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>GASTOS:</th>
                    <td id="tgastos" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>AJUSTES POR FALTANTES INVENTARIO:</th>
                    <td id="ajustfaltinv" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>AJUSTE POR TOMA DE INVENTARIO:</th>
                    <td id="ajustfaltinvfis" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>TOTAL UTILIDAD NETA:</th>
                    <td id="tutineta" style="text-align: right;">0.000,00</td>
                </tr>

                <tr>
                    <th colspan="2" style="text-align: center;">TOTAL ACTIVOS</th>
                </tr>
                <tr>
                    <th>CAJAS:</th>
                    <td id="tcajas" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>BANCOS:</th>
                    <td id="tbancos" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>INVENTARIOS:</th>
                    <td id="tinventarios" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>CUENTAS POR COBRAR:</th>
                    <td id="tcxc" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>TOTAL ACTIVOS:</th>
                    <td id="tactivos" style="text-align: right;">0.000,00</td>
                </tr>

                <tr>
                    <th colspan="2" style="text-align: center;">POSICION MONETARIA REAL</th>
                </tr>
                <tr>
                    <th>TOTAL ACTIVOS:</th>
                    <td id="tactivos2" class="text-success" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>CUENTAS POR PAGAR:</th>
                    <td id="tcxp" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>GASTOS POR PAGAR:</th>
                    <td id="tgxp" class="text-danger" style="text-align: right;">0.000,00</td>
                </tr>
                <tr>
                    <th>TOTAL POSICION MONETARIA REAL:</th>
                    <td id="tpmonetaria" style="text-align: right;">0.000,00</td>
                </tr>

            </tbody>
        </table>
        </div>
        <!--<div class="card-footer bg-white">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>-->
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
                    <button type="button" class="btn btn-morado" onclick="cambiar_bd();"><i class="fa fa-save"></i> Cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de cambio de empresa-->

    <script src="<?php echo base_url(); ?>bootadmin-master/js/jquery.min.js"></script>
    <script src='<?php echo base_url(); ?>bootadmin-master/js/jquery-1.12.4.min.js'></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/dataTables.scrollingPagination.js"></script>

    <script src="<?php echo base_url(); ?>DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>DataTables/Scroller-2.0.1/js/dataTables.scroller.min.js"></script>

<script src="<?php echo base_url(); ?>bootadmin-master/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootadmin.min.js"></script>
    <script type="text/javascript">
$('#titlemodule').text('  -> Report Gerencial');

function consultar(){
    var fini=$("#fini").val();
    var ffin=$("#ffin").val();
    var fcosto=$("#fcosto").val();
    var sucu=$("#co_alma").val();

    $.ajax({
        url : "<?php echo base_url(); ?>rg/report/"+fini+"/"+ffin+"/"+fcosto+"/"+sucu,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('#tfacturado').text(data.facturado);
                    $('#tncr').text(data.ncr);
                    $('#tventas').text(data.tventas);
                    $('#tcosmer').text(data.cosmer);
                    $('#tcosdev').text(data.cosdev);
                    //$('#tutibruvta').text(data.tutibruvta);
                    $('#tutibruvta2').text(data.tutibruvta);
                    $('#tcostos').text(data.tcostos);
                    $('#tgastos').text(data.tgastos);
                    $('#ajustfaltinv').text(data.ajustfaltinv);
                    $('#ajustfaltinvfis').text(data.ajustfaltinvfis);
                    $('#tutineta').text(data.tutineta);
                    $('#tcajas').text(data.tcajas);
                    $('#tbancos').text(data.tbancos);
                    $('#tinventarios').text(data.tinventarios);
                    $('#tcxc').text(data.tcxc);
                    $('#tactivos').text(data.tactivos);
                    $('#tactivos2').text(data.tactivos);
                    $('#tcxp').text(data.tcxp);
                    $('#tgxp').text(data.tgxp);
                    $('#tpmonetaria').text(data.tpmonetaria);
            }else{
                $('#tfacturado').text('0,00');
                $('#tncr').text('0,00');
                $('#tventas').text('0,00');
                $('#tcosmer').text('0,00');
                $('#tcosdev').text('0,00');
                //$('#tutibruvta').text('0,00');
                $('#tutibruvta2').text('0,00');
                $('#tcostos').text('0,00');
                $('#tgastos').text('0,00');
                $('#ajustfaltinv').text('0,00');
                $('#ajustfaltinvfis').text('0,00');
                $('#tutineta').text('0,00');
                $('#tcajas').text('0,00');
                $('#tbancos').text('0,00');
                $('#tinventarios').text('0,00');
                $('#tcxc').text('0,00');
                $('#tactivos').text('0,00');
                $('#tactivos2').text('0,00');
                $('#tcxp').text('0,00');
                $('#tgxp').text('0,00');
                $('#tpmonetaria').text('0,00');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });     
     
}

function validarenter_consulta(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) consultar();
        }

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

    function exito_msg(msg){
            reset();
            alertify.success(''+msg+'<br><center><i class="fa fa-check-circle"></i></center>');
            return false;
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
        function error_msg(msg){
            reset();
            alertify.error(''+msg+'<br><center><i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }  
function limpiar(){
    $('#rif').val('');
    //$('#codigo').val('');
    $('#nombre').val("");
}
consultar();
</script>
 
 <script type="text/javascript" src="<?php echo base_url(); ?>jQuery-Mask/src/jquery.mask.js"></script>
 <script type="text/javascript">
    
    $(function () {
        var options = {
            translation: {
                '0': {pattern: /\d/},
                '1': {pattern: /[1-9]/},
                '9': {pattern: /\d/, optional: true},
                '#': {pattern: /\d/, recursive: true},
                '*': {pattern: /-|#/, fallback: '-'},
                'C': {pattern: /V|v|E|e|M|m/, fallback: 'V'}
            }
        };
        $('.money').mask('#.##0,00', {reverse: true});
        $('#nif').mask('C-99999999*9', options);
        $('#nif').on('input', function (e) {
            var nif = $(this).val();
            if (nif.length > 9) {
                var cedula = nif.substring(2);
                if (cedula > 80000000) {
                    $(this).val('E-' + cedula);
                }
            }
        });
        $('#nrif').mask('C-99999999*9', options);
        $('#nrif').on('input', function (e) {
            var nrif = $(this).val();
            if (nrif.length > 9) {
                var cedula2 = nrif.substring(2);
                if (cedula2 > 80000000) {
                    $(this).val('E-' + cedula2);
                }
            }
        });
        $('#nif3').mask('C-99999999-9', options);
        $('#nif3').on('input', function (e) {
            var nif3 = $(this).val();
            if (nif3.length > 9) {
                var cedula3 = nif3.substring(2);
                if (cedula3 > 80000000) {
                    $(this).val('E-' + cedula3);
                }
            }
        });
    });
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
<!-- Moment Plugin Js -->
    <script src="<?php echo base_url(); ?>momentjs/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>Material-DateTimePicker-master/dist/js/materialDateTimePicker.js"></script>
  <script type="text/javascript">
$(function () {
    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        clearButton: true,
        weekStart: 1
    });
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'Y-MM-DD',
        clearButton: true,
        lang : 'es', 
        weekStart : 1, 
        cancelText : 'Cancelar',
        clearText : 'Limpiar',
        maxDate : new Date(),
        time: false
    });
    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: true,
        date: false
    });
});
</script>
</body>
</html>
