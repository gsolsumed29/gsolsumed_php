<?php
                $user = $this->session->userdata('user');
                extract($user);
                $co_ven = $this->session->userdata('co_ven');
$date_now = date('d-m-Y');
$date_past = strtotime('-15 day', strtotime($date_now));
$date_past = date('d-m-Y', $date_past);
            ?>
<div class="content p-4">
   <div class="card mb-4">
    <form id="formulario_lineas" name="formulario_lineas" method="post" >
        <div class="card-header bg-white font-weight-bold">
                <div class="form-row">
                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="rif" name="rif" placeholder="RIF" value="" data-toggle="tooltip" data-original-title="RIF" onkeyup="consultar();" onkeypress="validarenter_consulta(event);">
                </div>

                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                    </div>
                        <input type="text" class="form-control form-control-sm" placeholder="Nombre" value="" id="nombre" name="nombre" data-toggle="tooltip" data-original-title="Nombre" onkeyup="consultar();" onkeypress="validarenter_consulta(event);">
                </div>
                <div class="col-md-2 mb-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-list"></i></div>
                        </div>
                        <select class="form-control" id="co_ven" name="co_ven" data-toggle="tooltip" data-original-title="Vendedor" onchange="consultar();">
                            
                            <?php if (trim($co_ven) == '999') { echo '<option value="">Todos..</option>'; }
                                foreach($vendedores as $row){ 
                                if (trim($co_ven) == '999') {
                                    echo '<option value="'.$row->co_ven.'">'.$row->co_ven.' - '.$row->ven_des.'</option>';
                                }else{
                                    if(trim($co_ven) == trim($row->co_ven)){
                                        echo '<option value="'.$row->co_ven.'">'.$row->co_ven.' - '.$row->ven_des.'</option>';
                                    }
                                }
                                
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 mb-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-list"></i></div>
                        </div>
                        <select class="form-control" id="co_alma" name="co_alma" data-toggle="tooltip" data-original-title="Sucursal" onchange="consultar();">
                            <option value="">TODAS..</option>
                            <?php foreach($sucursales as $row){ 
                                echo '<option value="'.$row->co_alma.'">'.$row->co_alma.' - '.$row->alma_des.'</option>';
                                
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 mb-1">
                    <div class="btn-group-sm btnderecha">
                        <button type="button" class="btn btn-sm btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="Limpiar Campos" onclick="limpiar()">&nbsp; <i class="fas fa-undo"></i> &nbsp;</button>     
                    </div>
                </div>
                
                </div>
                
        <!--input id="co_ven" name="co_ven" value="<?php echo trim($co_ven);?>" type="hidden"-->
              <input id="codcliente" name="codcliente" value="0" type="hidden">
                </form>
        <div class="card-body">
            <table id="table_det_admission" class="table table-hover" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>CLIENTES</th>
                    <th>SALDO</th>
                    <!--<th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>RIF</th>-->
                    <!--<th>DIRECCION</th>
                    <th>TELEFONOS</th>
                    <th>EMAIL</th>
                    <th>ZONA</th>
                    <th>TIPO</th>-->
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
        <!--<div class="card-footer bg-white">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>-->
    </div>
    
 
    </div>


     <div class="modal fade bd-example-modal-lg" id="buscarclientes" tabindex="-1" role="dialog" aria-labelledby="modalbuscarclientes" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalbuscarclientes">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            <input type="hidden" id="btipo" name="btipo">
                <div class="modal-body3" style="height: 60vh; overflow-y: scroll;">
                    <p>No hay datos para mostrar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-morado" onclick="generar_cobro();"><i class="fas fa-hand-holding-usd"></i> Cobrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="cobrodirecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cobro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body2" style="height: 68vh; overflow-y: scroll;">
                     <div class="card-body" style="padding: 1.25rem;">
<form id="formulario_cobro" name="formulario_cobro" method="multipart/form-data">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="ccodfactura">Factura</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="ccodfactura" name="ccodfactura" placeholder="0" readonly="yes">
            </div>
        </div>
        <div class="col-md-8 mb-3">
            <label for="ccliente">Cliente</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="ccliente" name="ccliente" placeholder="Cliente" readonly="yes">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="ctotal">Total Facturado</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm precio" id="ctotal" name="ctotal" placeholder="0" readonly="yes">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="csaldo">Saldo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm precio" id="csaldo" name="csaldo" placeholder="0" readonly="yes">
            </div>
        </div>
    
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="cpagar">Monto a Cancelar</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control money" id="cpagar" name="cpagar" placeholder="0" >
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="cpendiente">Pendiente</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control money" id="cpendiente" name="cpendiente" placeholder="0" readonly="yes">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="cfpago">Forma de pago</label>
            <div class="input-group">
            <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-list"></i></div>
                    </div>
                    <select class="form-control form-control-sm" id="cfpago" name="cfpago">
                        <option value="">Seleccione..</option>
                        <?php 
                        foreach($fpago as $row){ 
                            echo '<option value="'.trim($row->codigo).'">'.$row->descripcion.'</option>';
                        }
                        ?>
                    </select>
                </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="cdocumento">Nº Documento</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="cdocumento" name="cdocumento" placeholder="Nº Documento">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="cfecha">Fecha</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm datepicker" id="cfecha" name="cfecha" value="<?php echo date('d-m-Y');?>" placeholder="dd-mm-yyyy">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="ccta">Cuenta</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control" id="ccta" name="ccta" onchange="cambio_cta();">
                        <option value="">Seleccione..</option>
                        <?php 
                        foreach($cuentas as $row){ 
                            echo '<option value="'.$row->cod_cta.'" data-id="'.$row->co_banco.'">'.$row->num_cta.' - '.$row->des_ban.'</option>';
                        }
                        ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="cbanco">Banco</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control" id="cbanco" name="cbanco" onchange="cambio_banco();">
                        <option value="">Seleccione..</option>
                        <?php 
                        foreach($bancos as $row){ 
                            echo '<option value="'.$row->co_ban.'">'.$row->des_ban.'</option>';
                        }
                        ?>
                        <option value="0">CAJA EFECTIVO</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="cobserva">Observaci&oacute;n</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="cobserva" name="cobserva" placeholder="Observaci&oacute;n" >
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <!--<input type="file" name="principal" id="principal">-->
            <label for="file-upload" class="subir"><i class="fas fa-cloud-upload-alt"></i> Subir Comprobante</label>
            <input id="file-upload" name="principal" onchange="cambiar();" type="file" style='display: none;'/>
        </div>
        <div class="col-md-8 mb-3">
        	<div id="info"></div>
        </div>
    </div>
    
    <input type="hidden" id="ccodcliente" name="ccodcliente" value="0">
    <input type="hidden" id="cco_ven" name="cco_ven" value="<?php echo $co_ven?>">
    <input type="hidden" id="cpagar2" name="cpagar2" value="0">
    <input type="hidden" id="csaldo2" name="csaldo2" value="0">
</form>
</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-morado" id="btncobro" onclick="save_cobro();"><i class="fa fa-save"></i> Guardar</button>
                    <img src="<?php echo base_url(); ?>images/ajax-loader.gif" style="display: none;" id="loaderimg">
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
$('#titlemodule').text('  -> CxC');
        $(document).ready(function() {
    table_det_admission=$('#table_det_admission').DataTable( {
        "language": {
            //processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:     "Mostrar _MENU_ registros",
            info:           "Mostrando  _START_  de  _END_ - <b>Total:</b> _TOTAL_ registros",
            infoEmpty:      "Mostrando del registro 0 al 0 de 0 registros",
            infoFiltered:   "(Filtrando _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "No se han encontrado registros",
            emptyTable:     "La tabla esta vacia",
            paginate: {
                first:      "Primera",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Ultima"
            },
            aria: {
                sortAscending:  ": Ordenar Ascendente",
                sortDescending: ": Ordenar Descendente"
            }
        },
   "searching": false,
   "lengthChange": false,
   //"paging": true,
   //deferRender:    true,
        scrollY:        '60vh',
        scrollCollapse: false,
        scroller:       true,
   "columnDefs": [
      { targets: [0], visible: false},
      { targets: [1], visible: true},
      { className: "dt-right", "targets": [2] },
      { targets: [3], visible: false}
    ],
   info: true,
   "order" : [],
   rowReorder: {
            selector: 'td:nth-child(2)'
        },

   ajax : {
    url:"<?php echo base_url(); ?>cxc/getclient",
    type:"POST",
    data:{
     rif: function() { return $('#rif').val() },
     nombre: function() { return $('#nombre').val() },
     co_ven: function() { return $('#co_ven').val() },
     co_alma: function() { return $('#co_alma').val() }
    }
   },

   "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            //4 Indica la columna que sera filtrada

            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                var cadena=new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(total);
 //console.log(cadena.slice(0, -2));
            // Update footer
            $( api.column( 2 ).header() ).html(
                'Saldo ('+ cadena.slice(0, -2) +')'
            );
        }



    } );


    $('#table_det_admission tbody').on('click', 'tr', function () {
        var data = table_det_admission.row( this ).data();
        btn_cliente(data[0],data[1]);
    } );


    $('#table_det_admission').on('preXhr.dt', function (e, settings, data) {
        //console.log('ajax start');
        $('<div class="spinner">Loading</div>').appendTo('body');
    });
 
    $('#table_det_admission').on('xhr.dt', function (e, settings, json, xhr) {
        //console.log('ajax end');
        $('div.spinner').remove();
    });

    


} );


function btn_cliente(codcliente,detalle){
    
    $('.modal-body3').load('<?php echo base_url(); ?>cxc/search_cli/'+codcliente,function(){
        $('#modalbuscarclientes').text(detalle);
        $("#btipo").val(codcliente); 
        $('#buscarclientes').modal({show:true});       
    });
    
};

function generar_cobro(){
	 var result = [];
  var i = 0;
  // para cada checkbox "chequeado"
  $("input[class=checkbox1]:checked").each(function(){
    
    // buscamos el td más cercano en el DOM hacia "arriba"
    // luego encontramos los td adyacentes a este
  
      result[i] = $(this).val();
      ++i;
   
  });
if(i >0){
  console.log(result.join('~'));
  cobrar(result.join('~'))
  $('#buscarclientes').modal('hide');
}else{
	error_msg("Seleccione al menos una factura.");
}
}

function cambiar_banco(valor){
    if(valor == 'EFEC'){
        alert('si');
    }else{
        alert('no');
    }
}
$(document).ready(function(){
        // Bloqueamos el SELECT de los cursos
        $("#ccta").prop('disabled', true);
        
        // Hacemos la lógica que cuando nuestro SELECT cambia de valor haga algo
        $("#cfpago").change(function(){
            // Guardamos el select de cursos
            var cursos = $("#ccta");
            
            // Guardamos el select de alumnos
            var alumnos = $(this);
            
            if($(this).val() != '')
            {
                $.ajax({
                    data: { id : alumnos.val() },
                    url:   "<?php echo base_url(); ?>cxc/ctachange",
                    type:  'POST',
                    dataType: 'json',
                    beforeSend: function () 
                    {
                        alumnos.prop('disabled', true);
                    },
                    success:  function (r) 
                    {
                        alumnos.prop('disabled', false);
                        
                        // Limpiamos el select
                        cursos.find('option').remove();
                        cursos.append('<option value="">Seleccione..</option>');
                        $(r).each(function(i, v){ // indice, valor
                            cursos.append('<option value="' + v.cod_cta + '" data-id="'+v.co_banco+'">'+v.num_cta+' - '+v.des_ban+'</option>');
                        })
                        
                        cursos.prop('disabled', false);
                        
                    },
                    error: function()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        alumnos.prop('disabled', false);
                    }
                });
            }
            else
            {
                cursos.find('option').remove();
                cursos.prop('disabled', true);
            }
        })
    })

function cobrar(facturas){
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>cxc/cobrar/"+facturas,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            document.getElementById('formulario_cobro').reset();
            if(data){
                    $('[name="ccodfactura"]').val(facturas);
                    $('[name="ccliente"]').val(data.cli_des);
                    $('[name="ccodcliente"]').val(data.co_cli);
                    $('[name="ctotal"]').val(data.monto);
                    $('[name="csaldo"]').val(data.saldo);
                    $('[name="cpendiente"]').val(data.saldo);
                    $('[name="csaldo2"]').val('0');
                    $('[name="cpagar2"]').val('0');
                    $('[name="cpagar"]').val('0');
                    document.getElementById('cpagar').focus();

            }else{
                    $('[name="ccodfactura"]').val('0');
                    $('[name="ccliente"]').val('');
                    $('[name="ccodcliente"]').val('0');
                    $('[name="ctotal"]').val('0');
                    $('[name="csaldo"]').val('0');
                    $('[name="cpendiente"]').val('0');
                    $('[name="csaldo2"]').val('0');
                    $('[name="cpagar2"]').val('0');
                    $('[name="cpagar"]').val('0');
                    document.getElementById('cpagar').focus();

            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
        $('#cobrodirecto').modal({show:true}); 

        document.getElementById('cpagar').focus();      
     
}

$("#cpagar").focusout(function(){
    var totalfactura=$('#ctotal').val();
    var saldo=$('#csaldo').val();
    var pagar=$('#cpagar').val();
    //var pendiente=$('#cpendiente').val();
    saldo = saldo.replace(/\./g,'');
    saldo = saldo.replace(/\,/g,'.');
    pagar = pagar.replace(/\./g,'');
    pagar = pagar.replace(/\,/g,'.');
    if(parseFloat(pagar) > parseFloat(saldo)){
        error_msg('Monto no puede ser mayor al saldo.');
        document.getElementById("btncobro").style.display="none";
        $(this).css("border","1px solid #ff0000");
        console.log(parseFloat(pagar));
        console.log(parseFloat(saldo));
        $('#cpendiente').val(0);
        document.getElementById("cpagar").focus();
        $(this).focus();
    }else{
    var pendiente=(saldo - pagar);
    var locale = 'de';
    var options = { minimumFractionDigits: 2, maximumFractionDigits: 2};
    var formatter = new Intl.NumberFormat(locale, options);
    $('#cpendiente').val(formatter.format(pendiente));
    document.getElementById("btncobro").style.display="inherit";
    $(this).css("border", "1px solid #ced4da");
    $('#cpagar2').val(pagar);
    $('#csaldo2').val(saldo);
}
  
});


function save_cobro(){
    if(validaForm()){
        document.getElementById("btncobro").style.display="none";
    document.getElementById("loaderimg").style.display="inherit";
            var url;
        url = "<?php echo base_url(); ?>cxc/save_cobro";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: new FormData(document.getElementById("formulario_cobro")),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                operacion(); 
                //consultar();
                //cobrar(data.codfactura)
                $('#cobrodirecto').modal('hide');
                document.getElementById("loaderimg").style.display="none";
                document.getElementById("btncobro").style.display="inherit";
                //location.reload();
                setTimeout('document.location.reload()',2000);
                 //location.href="<?php echo base_url(); ?>orders/view/"+data.invoice;     
            }else{
                
            if(data.refrescar == 1){
                exito_msg('Cobro Generado!'); 
                error_msg(data.message);
                document.getElementById("loaderimg").style.display="none";
                document.getElementById("btncobro").style.display="inherit";
                $('#cobrodirecto').modal('hide');
                setTimeout('document.location.reload()',2000); //hf

            }else{
                error_msg(data.message);
                document.getElementById("loaderimg").style.display="none";
                document.getElementById("btncobro").style.display="inherit";
            }
            }
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
            document.getElementById("loaderimg").style.display="none";
            document.getElementById("btncobro").style.display="inherit";
 
        }
    });
    }
            
        }


function search_cli(){
    var brif=$('#brif').val();
    var bnombre=$('#bnombre').val();
    if(brif == ''){ brif='-'; }
    if(bnombre == ''){ bnombre='-'; }
    var bnombre2 = bnombre.replace(" ", "%20");
    var bempresa=$('#bempresa').val();
    var btipo=$('#btipo').val();
    
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_cli/'+brif+'/'+bnombre2+'/'+bempresa+'/'+btipo,function(){
        $('#buscarclientes').modal({show:true});
    });
}

function validaForm(){
    // Campos de texto
    if($("#cpagar").val() == ""){
        error_msg("El campo Monto a Cancelar no puede estar vacío.");
        $("#cpagar").focus();
        return false;
    }
    if($("#cpagar").val() == 0){
        error_msg("El campo Monto a Cancelar no puede estar vacío.");
        $("#cpagar").focus();
        return false;
    }
    if($("#cbanco").val() == ""){
        error_msg("El campo Banco no puede estar vacío.");
        $("#cbanco").focus();
        return false;
    }
    // Checkbox
    /*if(!$("#mayor").is(":checked")){
        alert("Debe confirmar que es mayor de 18 años.");
        return false;
    }*/
    return true; // Si todo está correcto
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

    function cambio_cta(){
    	var banco=$("#ccta option:selected").attr("data-id");
    	$('[name="cbanco"]').val(banco);
    }
    function cambio_banco(){
    	$('[name="ccta"]').val('');
    }

    function cambiar(){
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
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
function consultar() {
      table_det_admission.ajax.reload(null,false); //reload datatable ajax
}
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
        $('.money').mask('#.##0,00', {reverse: true,selectOnFocus: true});
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

$('#cobrodirecto').on('shown.bs.modal', function () {
    $('#cpagar').focus();
}) 
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$("#cobrodirecto").on("shown.bs.modal", function() {
 $(document).off('focusin.bs.modal');
});
</script>
</body>
</html>
