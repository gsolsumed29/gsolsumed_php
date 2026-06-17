<?php
                $user = $this->session->userdata('user');
                extract($user);
                $co_ven = $this->session->userdata('co_ven');
$date_now = date('Y-m-d');
$date_past = strtotime('-15 day', strtotime($date_now));
$date_past = date('Y-m-d', $date_past);
            ?>
<div class="content p-4">
   <div class="card mb-4">
    <form id="formulario_lineas" name="formulario_lineas" method="post" >
        <div class="card-header bg-white font-weight-bold">
                <div class="form-row">
                    <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="rif" name="rif" placeholder="RIF" value="" data-toggle="tooltip" data-original-title="RIF" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-4 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                    </div>
                        <input type="text" class="form-control form-control-sm" placeholder="Nombre" value="" id="nombre" name="nombre" data-toggle="tooltip" data-original-title="Nombre" onkeypress="validarenter_consulta(event)">
                    </div>
                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="fini" name="fini" placeholder="dd/mm/yyyy" title="Fecha Emisi&oacute;n Desde" value="<?php echo $date_past;?>" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="ffin" name="ffin" placeholder="dd-mm-yyyy" title="Fecha Emisi&oacute;n Hasta" value="<?php echo date('Y-m-d');?>" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="col-md-2 mb-1">
                    <div class="btn-group-sm btnderecha">
                                <button type="button" class="btn btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                                <button type="button" class="btn btn-warning" data-toggle="tooltip" data-original-title="Limpiar Campos" onclick="limpiar()">&nbsp; <i class="fas fa-undo"></i> &nbsp;</button>
                                
                                
                            </div>
                </div>
                
                </div>
                
        <input id="co_ven" name="co_ven" value="<?php echo trim($co_ven);?>" type="hidden">
              <input id="codcliente" name="codcliente" value="0" type="hidden">
                </form>
        <div class="card-body">
            <table id="table_det_admission" class="table table-hover" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>CLIENTES</th>
                    <th>SALDO</th>
                    <th></th>
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
<form id="formulario_cobro" name="formulario_cobro" method="post">
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
                        <?php 
                        foreach($fpago as $row){ 
                            echo '<option value="'.$row->codigo.'">'.$row->descripcion.'</option>';
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
        <div class="col-md-12 mb-3">
            <label for="cbanco">Banco</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control" id="cbanco" name="cbanco">
                        <option value="">Seleccione..</option>
                        <?php 
                        foreach($bancos as $row){ 
                            echo '<option value="'.$row->co_ban.'">'.$row->des_ban.'</option>';
                        }
                        ?>
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
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="delete_art" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Alerta de Eliminaci&oacute;n.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body4">
                    <div class="card-body" style="padding: 1.25rem;">
                        <h5 class="modal-title" ><i class="fa fa-exclamation-triangle"></i> Estas Seguro?</h5>
                        <input type="hidden" id="ecodigo" name="ecodigo" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="anular2();"><i class="fa fa-trash"></i> Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal" id="subir_comprobante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Subir comprobante de pago.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body6" style="width: 100%; height: 300px; overflow-y: scroll;">
                    <p>No hay datos para mostrar.</p>
                </div>
                <form id="formPublicar" name="formPublicar" method="multipart/form-data">
                        <input type="hidden" id="ecodigo1" name="ecodigo1">
                        <!--<input accept="image/*" id="principal" name="principal[]" type="file">-->
                <div class="form-row">
        <div class="col-md-4 mb-3">
            <!--<input type="file" name="principal" id="principal">-->
            <label for="file-upload0" class="subir"><i class="fas fa-cloud-upload-alt"></i> Subir Comprobante</label>
            <input id="file-upload0" name="principal0" onchange="cambiar0();" type="file" style='display: none;'/>
        </div>
        <div class="col-md-8 mb-3">
            <div id="info0"></div>
        </div>
    </div>
    </form>
                <div class="modal-footer">
                        <img style="display: none;" id="img_loader" src="<?php echo base_url(); ?>images/ajax-loader.gif">
                        <button type="button" class="btn btn-morado" id="guardarImagen" onclick="save_img();"><i class="fa fa-upload"></i>Subir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
$('#titlemodule').text('  -> Cobros');

function format ( d ) {
    // `d` is the original data object for the row
    var retornar= '<b>FECHA DE EMISION:</b> <font color="#6E6E6E">'+d[4]+'</font>'+
    '<br><br><b>FECHA DE PAGO:</b> <font color="#6E6E6E">'+d[5]+'</font>'+
    '<br><br><b>TIPO DE PAGO:</b> <font color="#6E6E6E">'+d[6]+'</font>'+
    '<br><br><b>OBSERVACION:</b> <font color="#6E6E6E">'+d[7]+'</font>'+
    '<br><br><b>BANCO:</b> <font color="#6E6E6E">'+d[8]+'</font>';
    if(d[9] > 0){
    	retornar+= '<br><br><b>ESTATUS:</b> <font color="#6E6E6E">Procesado</font>';
    }else{
    	retornar+= '<br><br><b>ESTATUS:</b> <font color="#6E6E6E">Pendiente</font><br><br><button type="button" class="btn btn-primary" onclick="subir('+d[3]+');" data-toggle="tooltip" data-original-title="Subir comprobante de pago">&nbsp;<i class="fa fa-upload"></i> Subir &nbsp;</button><button type="button" class="btn btn-danger" onclick="anular('+d[3]+');" data-toggle="tooltip" data-original-title="Eliminar Cobro">&nbsp;<i class="fa fa-trash"></i> Eliminar &nbsp;</button>';
    }
    

    return retornar;
}

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
    url:"<?php echo base_url(); ?>charges/getclient",
    type:"POST",
    data:{
     rif: function() { return $('#rif').val() },
     nombre: function() { return $('#nombre').val() },
     fini: function() { return $('#fini').val() },
     ffin: function() { return $('#ffin').val() },
     co_ven: function() { return $('#co_ven').val() }
    }
   }
    } );

    // Add event listener for opening and closing details
    $('#table_det_admission tbody').on('click', 'tr', function () {
        var tr = $(this).closest('tr');
        var row = table_det_admission.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
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


function btn_cliente(codcliente,detalle){
    
    $('.modal-body3').load('<?php echo base_url(); ?>cxc/search_cli/'+codcliente,function(){
        $('#modalbuscarclientes').text(detalle);
        $("#btipo").val(codcliente); 
        $('#buscarclientes').modal({show:true});       
    });
    
};

function subir(co_cob){
	$('.modal-body6').load('<?php echo base_url(); ?>charges/imagen/'+co_cob,function(){
        $('#subir_comprobante').modal({show:true});
        $('#exampleModalLabel3').text('Subir comprobante de pago Cobro -> '+co_cob);
        $('#ecodigo1').val(co_cob);
    });
        
    }

function save_img(){
	document.getElementById('img_loader').style.display='inherit';
	document.getElementById('guardarImagen').style.display='none';
    var id=$('#ecodigo1').val();
    var url;
    url = "<?php echo base_url(); ?>charges/imagensave";
    //var formData = new FormData($('#formPublicar').serialize());
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: new FormData(document.getElementById("formPublicar")),
        processData:false,
             contentType:false,
             cache:false,
             async:false,
             dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                $('#subir_comprobante').modal('hide');
                operacion();
                document.getElementById('img_loader').style.display='none';
				document.getElementById('guardarImagen').style.display='inherit';
                //location.reload();
            }else{
                error_msg(data.message);
                document.getElementById('img_loader').style.display='none';
				document.getElementById('guardarImagen').style.display='inherit';
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
            document.getElementById('img_loader').style.display='none';
			document.getElementById('guardarImagen').style.display='inherit';
 
        }
    });
    }

 function anular(co_cob){
        $('#delete_art').modal({show:true});
        $('#exampleModalLabel2').text('Se Eliminara -> '+co_cob);
        $('#ecodigo').val(co_cob);
    }
function anular2(){
    var codigo=$("#ecodigo").val();
    var url;
        url = "<?php echo base_url(); ?>charges/anular/"+codigo;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.success) //if success close modal and reload ajax table
            {
                operacion();
                consultar();
                //update_totales();
                $('#delete_art').modal('hide');
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

function cobrar(facturas){
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>cxc/cobrar/"+facturas,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
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
            var url;
        url = "<?php echo base_url(); ?>cxc/save_cobro";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formulario_cobro').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                operacion(); 
                //consultar();
                //cobrar(data.codfactura)
                $('#cobrodirecto').modal('hide');
                gdd
                 //location.href="<?php echo base_url(); ?>orders/view/"+data.invoice;     
            }else{
                error_msg(data.message);
                if(data.refrescar == 1){
                $('#cobrodirecto').modal('hide');
                setTimeout('document.location.reload()',2000); //hf
            }
            }
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
 
        }
    });
            
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

    function cambiar0(){
    var pdrs = document.getElementById('file-upload0').files[0].name;
    document.getElementById('info0').innerHTML = pdrs;
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
    $('#cdocumento').focus();
}) 
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$("#cobrodirecto").on("shown.bs.modal", function() {
 $(document).off('focusin.bs.modal');
});
</script>
</body>
</html>
