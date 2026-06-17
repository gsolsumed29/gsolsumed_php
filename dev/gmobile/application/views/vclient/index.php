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
                    <input type="text" class="form-control form-control-sm datepicker" id="ffin" name="ffin" placeholder="dd-mm-yyyy" title="Fecha Emisi&oacute;n Hasta" value="<?php echo $date_now;?>" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="col-md-2 mb-1">
                    <div class=" btn-group-sm btnderecha">
                        <button type="button" class="btn btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                        <button type="button" class="btn btn-warning" data-toggle="tooltip" data-original-title="Limpiar Campos" onclick="limpiar()">&nbsp; <i class="fas fa-undo"></i> &nbsp;</button>
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-original-title="Agregar Visita" onclick="add_cli();">&nbsp; <i class="fas fa-plus"></i> &nbsp;</button>     
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

    <div class="modal fade bd-example-modal" id="nuevocliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Visita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body4">
                    <div class="card-body" style="padding: 1.25rem;">
<form id="formulario_cliente" name="formulario_cliente" method="post">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="nrif">RIF/CI</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nrif" name="nrif" placeholder="V" onkeypress="validar_cliente(event,'1');" style="text-transform: uppercase;">
                <div class="input-group-append">
                         <button type="button" class="btn btn-morado" data-toggle="tooltip" onclick="cliente_vali('1');" data-original-title="Validar Cliente"><i class="fas fa-play-circle"></i></button>
                    </div>
            </div>
        </div>
        
    </div>

    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="nnombre">Nombre</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nnombre" name="nnombre" placeholder="Nombre" style="text-transform: uppercase;">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="ndireccion">Fecha</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <input type="text" class="form-control datepicker" placeholder="0" id="nfecha" name="nfecha" tabindex="2" data-toggle="tooltip" data-original-title="Fecha de la Visita" readonly="yes" value="<?php echo date('Y-m-d');;?>">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="ntipo">Compro</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control" id="ncompro" name="ncompro">
                        <option value="">Seleccione..</option>
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                </select>
            </div>
        </div>
    </div>

    <!--<div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="ndireccion">Observaci&oacute;n</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-map"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nobservacion" name="nobservacion" placeholder="Observacion" style="text-transform: uppercase;">
            </div>
        </div>
    </div>-->
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="nobservacion">Motivo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control" id="nobservacion" name="nobservacion">
                        <option value="">Seleccione..</option>
                        <?php 
                        foreach($motivos as $row){ 
                            echo '<option value="'.$row->co_motivo.'">'.$row->des_motivo.'</option>';
                        }
                        ?>
                </select>
            </div>
        </div>
    </div>
    
<input type="hidden" id="nco_ven" name="nco_ven" value="<?php echo trim($co_ven);?>">
<input type="hidden" id="ncodcliente" name="ncodcliente" value="0">
<input type="hidden" id="nvisita" name="nvisita" value="0">
<input type="hidden" id="naccion" name="naccion" value="add">
</form>
</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-morado" id="btnaddcli" onclick="save_cli();"><i class="fa fa-save"></i> Guardar</button>
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
    <script src="<?php echo base_url(); ?>bootadmin-master/js/jquery-1.12.4.js"></script>
  <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
  <script src="<?php echo base_url(); ?>jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/dataTables.scrollingPagination.js"></script>
<script src="<?php echo base_url(); ?>DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>DataTables/Scroller-2.0.1/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootadmin.min.js"></script>
   
<script type="text/javascript" src="<?php echo base_url(); ?>sweetalert/sweetalert/sweetalert2.min.js" ></script>
    <script type="text/javascript">
$('#titlemodule').text('  -> Visitados');
        $(document).ready(function(){
            $("#nnombre").autocomplete({
                source: function(request, response) {
            $.getJSON(
                "<?php echo base_url(); ?>vclient/cliente",
                { term:request.term, extraParams:$('#nco_ven').val() }, 
                response
            );
        },
        minLength: 1,
                select: function(event, ui) {
                    event.preventDefault();
                    $('#ncodcliente').val(ui.item.ncodcliente);
                    $('#nrif').val(ui.item.nrif);
                    $('#nnombre').val(ui.item.nnombre);
                 }
            });
        });
  </script>
    <script type="text/javascript">      
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<b>RIF:</b> <font color="#6E6E6E">'+d[3]+'</font><br>'+
    '<br><b>F. VISITA:</b> <font color="#6E6E6E">'+d[4]+'</font><br>'+
    '<br><b>COMPRO:</b> <font color="#6E6E6E">'+d[6]+'</font><br>'+
    '<br><b>OBSERVACION:</b> <font color="#6E6E6E">'+d[5]+'</font><br>'+
    '<br><b>ZONA:</b> <font color="#6E6E6E">'+d[7]+'</font><br>'+
    '<br><b>TIPO:</b> <font color="#6E6E6E">'+d[8]+'</font><br>'+
    '<br><button type="button" class="btn btn-primary" onclick="edit('+d[9]+');" data-toggle="tooltip" data-original-title="Modificar">&nbsp;<i class="fa fa-edit"></i> Modificar &nbsp;</button><button type="button" class="btn btn-danger" onclick="anular('+d[9]+');" data-toggle="tooltip" data-original-title="Eliminar">&nbsp;<i class="fa fa-trash"></i> Eliminar &nbsp;</button>';
    
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
        scrollY:        '40vh',
        scrollCollapse: false,
        scroller:       true,
   
   info: true,
   "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": [1] }
        ],
   "order" : [],
   rowReorder: {
            selector: 'td:nth-child(2)'
        },

   ajax : {
    url:"<?php echo base_url(); ?>vclient/getclient",
    type:"POST",
    data:{
        fini: function() { return $('#fini').val() },
     ffin: function() { return $('#ffin').val() },
     rif: function() { return $('#rif').val() },
     nombre: function() { return $('#nombre').val() },
     co_ven: function() { return $('#co_ven').val() }
    }
   }
    } );


    // Add event listener for opening and closing details
    $('#table_det_admission tbody').on('click', 'td.details-control', function () {
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

    // Add event listener for opening and closing details
    $('#table_det_admission tbody').on('dblclick', 'tr', function () {
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



function add_cli(){
    $('#nuevocliente').modal({show:true});
    $('[name="naccion"]').val('add');
}

function validar_cliente(e,tipo) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) cliente_vali(tipo);
        }
function cliente_vali(tipo)
{
var rif=$('#nrif').val();
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>vclient/cliente_vali/"+rif,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="ncodcliente"]').val(data.co_cli);
                    $('[name="nrif"]').val(data.rif);
                    $('[name="nnombre"]').val(data.cli_des);
                    //$('#nif2').focus();
            }else{
                    //cliente_new(tipo,rif);
                    noexiste('Cliente');
                    $('[name="ncodcliente"]').val(0);
                    $('[name="nrif"]').val('');
                    $('[name="nnombre"]').val(''); 
                    $('#nrif').focus();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
}

function edit(co_visita){
    $.ajax({
        url : "<?php echo base_url(); ?>vclient/cliente_vali2/"+co_visita,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="nvisita"]').val(data.co_visita);
                    $('[name="ncodcliente"]').val(data.co_cli);
                    $('[name="nrif"]').val(data.rif);
                    $('[name="nnombre"]').val(data.cli_des);
                    $('[name="nobservacion"]').val(data.observacion);
                    $('[name="ncompro"]').val(data.compro);
                    $('[name="nfecha"]').val(data.fec_vis);
                    $('[name="naccion"]').val('edit');
                    //document.getElementById("estatus_cli").style.display="none";
                //document.getElementById("btnaddcli").style.display="inherit";
                
            }else{
                
                    error_msg('Error al Cargar los datos');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
    $('#nuevocliente').modal({show:true});
    $('#exampleModalLabel').text('Modificar Visita'); 
     
}

function anular(co_visita){
        $('#delete_art').modal({show:true});
        $('#exampleModalLabel2').text('Se Eliminara la Visita -> '+co_visita);
        $('#ecodigo').val(co_visita);
    }
function anular2(){
    var codigo=$("#ecodigo").val();
    var url;
        url = "<?php echo base_url(); ?>vclient/deletecli/"+codigo;
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

    function validaForm(){
    // Campos de texto
    if($("#nrif").val() == ""){
        error_msg("El campo RIF no puede estar vacío.");
        $("#nrif").focus();
        return false;
    }
    if($("#nnombre").val() == ""){
        error_msg("El campo Nombre no puede estar vacío.");
        $("#nnombre").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#nobservacion").val() == ""){
        error_msg("El campo Observación no puede estar vacío.");
        $("#nobservacion").focus();
        return false;
    }
    if($("#ncompro").val() == ""){
        error_msg("El campo Compro no puede estar vacío.");
        $("#ncompro").focus();
        return false;
    }
    if($("#nfecha").val() == ""){
        error_msg("El campo Fecha no puede estar vacío.");
        $("#nfecha").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
  
        return true; // Si todo está correcto
}



    function save_cli(){
            if(validaForm()){
            document.getElementById("btnaddcli").style.display="none";
            var url;
            var accion=$('#naccion').val();
            if(accion == 'add'){
                url = "<?php echo base_url(); ?>vclient/addcli"; 
            }else{
                url = "<?php echo base_url(); ?>vclient/updatecli";
            }
        //url = "<?php echo base_url(); ?>vclient/addcli";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formulario_cliente').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                $('#nuevocliente').modal('hide');
                operacion();
                consultar();
                //cliente_vali(data.type);
                    $("#nrif").val('');
                    $("#nnombre").val('');
                    $("#nobservacion").val('');
                    $("#ncompro").val('');
                    $("#ncodcliente").val('0');
                    $("#nfecha").val('');
                    document.getElementById("btnaddcli").style.display="inherit";
            }else{
                error_msg(data.message);
                document.getElementById("btnaddcli").style.display="inherit";
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
            document.getElementById("btnaddcli").style.display="inherit";
 
        }
    });

        }    
        }


    function validarEmail(valor) {
  if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(valor)){
   //alert("La dirección de email " + valor + " es correcta.");
   document.getElementById('nemail').style.borderColor="#ced4da";
  } else {
   //alert("La dirección de email es incorrecta.");
   error_msg('El email NO es correcto');
    document.getElementById('nemail').style.borderColor="#FF0000";
    document.getElementById('nemail').focus();
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
                'C': {pattern: /V|v|E|e|M|m|J|j|G|g|P|p|C|c/, fallback: 'V'}
            }
        };
        $('.money').mask('#.##0,00', {reverse: true});
        $('#rif').mask('C-99999999-9', options);
        $('#nrif').mask('C-99999999-9', options);
        
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
