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
                <div class="input-group col-md-4 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="usuario" name="usuario" placeholder="Usuario" value="" data-toggle="tooltip" data-original-title="Usuario" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-4 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                    </div>
                        <input type="text" class="form-control form-control-sm" placeholder="Nombre" value="" id="nombre" name="nombre" data-toggle="tooltip" data-original-title="Nombre" onkeypress="validarenter_consulta(event)">
                </div>
                <div class="col-md-2 mb-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-list"></i></div>
                        </div>
                        <select class="form-control" id="status" name="status" data-toggle="tooltip" data-original-title="Estatus">
                            <option value="">Todos..</option>
                            <option value="0">Activos..</option>
                            <option value="1">Inactivos..</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 mb-1">
                    <div class=" btn-group-sm btnderecha">
                        <button type="button" class="btn btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                        <button type="button" class="btn btn-warning" data-toggle="tooltip" data-original-title="Limpiar Campos" onclick="limpiar()">&nbsp; <i class="fas fa-undo"></i> &nbsp;</button>
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-original-title="Agregar" onclick="add_user()">&nbsp; <i class="fas fa-plus"></i> &nbsp;</button>     
                    </div>
                </div>
                
                </div>
                
        <input id="codpaciente" name="codpaciente" value="" type="hidden">
              <input id="codcliente" name="codcliente" value="0" type="hidden">
                </form>
        <div class="card-body">
            <table id="table_det_admission" class="table table-hover" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>USUARIO</th>
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

    <div class="modal fade bd-example-modal" id="asig_empresas" tabindex="-1" role="dialog" aria-labelledby="modaltoma_muestra" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalasig_empresas">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!--<input type="hidden" id="btipo" name="btipo">-->
                <div class="modal-empresas">
                    <p>No hay datos para mostrar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="nuevocliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Usuario Nuevo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body4">
                    <div class="card-body">
<form id="formulario_cliente" name="formulario_cliente" method="post">
    <div class="form-row">
        <div class="col-md-3 mb-3">
            <label for="nidusuario">Codigo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nidusuario" name="nidusuario" placeholder="Codigo" required="yes" readonly="yes">
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="nusuario">Usuario</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nusuario" name="nusuario" placeholder="Usuario">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="nrif">RIF</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nrif" name="nrif" placeholder="RIF">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="nnombre">Nombre</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nnombre" name="nnombre" placeholder="Nombre">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="ncorreo">Correo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="ncorreo" name="ncorreo" placeholder="Correo">
            </div>
        </div>
        
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-3">
        <label for="nempini">Empresa Inicial</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control form-control-sm" id="nempini" name="nempini" onchange="emp_inicial($('#nidusuario').val(),this.value);">
                    <option value="0">Seleccione</option>
                    <?php
                    $empresas = $this->users_model->get_empresas($idusuario);
                    foreach($empresas as $row){
                        echo '<option value="'.trim($row->idemp).'" >'.$row->idemp.'</option>';
                    }           
                    ?>
                </select>
            </div>
        </div>
    </div>
<input type="hidden" id="naccion" name="naccion" value="add">
</form>
</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-morado" id="btnaddcli" onclick="add_cli();"><i class="fa fa-save"></i> Guardar</button>
    
            <div class="input-group" id="estatus_cli">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control form-control-sm" id="nstatus" name="nstatus" data-toggle="tooltip" title="" data-original-title="Estatus del usuario" onchange="delete_cli($('#nidusuario').val(),this.value)">
                        <option value="0">ACTIVO</option>
                        <option value="1">INACTIVO</option>
                    </select>
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
<script type="text/javascript" src="<?php echo base_url(); ?>sweetalert/sweetalert/sweetalert2.min.js" ></script>
    <script type="text/javascript">
$('#titlemodule').text('  -> Usuarios');

/* Formatting function for row details - modify as you need */
function format ( d ) {
	var comilla="'";
    // `d` is the original data object for the row
    return '<b>RIF:</b> <font color="#6E6E6E">'+d[2]+'</font><br>'+
    '<br><b>NOMBRE:</b> <font color="#6E6E6E">'+d[3]+'</font><br>'+
    '<br><b>CORREO:</b> <font color="#6E6E6E">'+d[4]+'</font><br>'+
    '<br><b>ESTATUS:</b> <font color="#6E6E6E">'+d[5]+'</font><br>'+
    '<br><button type="button" class="btn btn-primary" onclick="asigemp('+comilla+d[0]+comilla+');" data-toggle="tooltip" data-original-title="Asignar Empresas">&nbsp;&nbsp;<i class="fa fa-building"></i>&nbsp;&nbsp;</button>&nbsp;<button type="button" class="btn btn-warning" onclick="edituser('+comilla+d[0]+comilla+');" data-toggle="tooltip" data-original-title="Modificar">&nbsp;&nbsp;<i class="fa fa-user-edit"></i>&nbsp;&nbsp;</button>&nbsp;<button type="button" class="btn btn-info" onclick="asigmenu('+comilla+d[0]+comilla+');" data-toggle="tooltip" data-original-title="Asignar Menu">&nbsp;&nbsp;<i class="fa fa-bars"></i>&nbsp;&nbsp;</button>&nbsp;<button type="button" class="btn btn-danger" onclick="delete_cli2('+comilla+d[0]+comilla+','+d[6]+');" data-toggle="tooltip" data-original-title="Cambiar Estatus">&nbsp;<i class="fa fa-user-tag"></i>&nbsp;</button>&nbsp;<button type="button" class="btn btn-morado" onclick="pass_reset('+comilla+d[0]+comilla+');" data-toggle="tooltip" data-original-title="Restablecer contraseña">&nbsp;<i class="fa fa-key"></i>&nbsp;</button><br>';
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
    url:"<?php echo base_url(); ?>usera/getusera",
    type:"POST",
    data:{
     usuario: function() { return $('#usuario').val() },
     nombre: function() { return $('#nombre').val() },
     status: function() { return $('#status').val() }
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

function add_user(){
    $('#nuevocliente').modal({show:true}); 
     document.getElementById("estatus_cli").style.display="none";  
    $('#exampleModalLabel').text('Nuevo Usuario');  
    document.getElementById('formulario_cliente').reset();
    document.getElementById('nidusuario').value='';
    document.getElementById('nnombre').value='';
    document.getElementById('nusuario').value='';
    document.getElementById('ncorreo').value='';
    document.getElementById('naccion').value='add';
    document.getElementById('nidusuario').readOnly=false;
    document.getElementById("btnaddcli").style.display="inherit";    
} 
function add_cli(){
    if(validaForm()){
            document.getElementById("btnaddcli").style.display="none";
            var url;
            var accion=$('#naccion').val();
            if(accion == 'add'){
                url = "<?php echo base_url(); ?>usera/adduser"; 
            }else{
                url = "<?php echo base_url(); ?>usera/updateuser";
            }
        var formElement = document.getElementById("formulario_cliente");
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        //data: $('#formulario_cliente').serialize(),
        data:new FormData(formElement),
             processData:false,
             contentType:false,
             cache:false,
             async:false,
             dataType: "JSON",
        //dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                $('#nuevocliente').modal('hide');
                exito_msg(data.message);
                consultar();
                //cliente_vali(data.type);
                    document.getElementById('formulario_cliente').reset();
                    $("#nidusuario").val('');
                    document.getElementById("estatus_cli").style.display="none";
                    document.getElementById("btnaddcli").style.display="inherit";
            }else{
                error_msg(data.message);
                document.getElementById("estatus_cli").style.display="none";
                document.getElementById("btnaddcli").style.display="inherit";
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
            document.getElementById("estatus_cli").style.display="none";
                document.getElementById("btnaddcli").style.display="inherit";
 
        }
    });
           } 
        }
function delete_cli2(idusuario,borrado){
    if(borrado == 0){
        delete_cli(idusuario,1);
    }else{
        delete_cli(idusuario,0);
    }
}
function delete_cli(idusuario,borrado){
    
    var url;
    url = '<?php echo base_url(); ?>usera/deleteuser/'+idusuario+'/'+borrado;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        consultar();
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

function emp_inicial(idusuario,emp){
    
    var url;
    url = '<?php echo base_url(); ?>usera/empini/'+idusuario+'/'+emp;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        //consultar();
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
function validaForm(){
    // Campos de texto
    if($("#nidusuario").val() == ""){
        error_msg("El campo Codigo no puede estar vacío.");
        $("#nidusuario").focus();
        return false;
    }
    if($("#nnombre").val() == ""){
        error_msg("El campo Nombre no puede estar vacío.");
        $("#nnombre").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#nusuario").val() == ""){
        error_msg("El campo Usuario no puede estar vacío.");
        $("#nusuario").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#ncorreo").val() == ""){
        error_msg("El campo Correo no puede estar vacío.");
        $("#ncorreo").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    return true; // Si todo está correcto
}
function edituser(idusuario){
    $.ajax({
        url : "<?php echo base_url(); ?>usera/user_vali2/"+idusuario,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="nidusuario"]').val(data.idusuario);
                    $('[name="nnombre"]').val(data.nombre);
                    $('[name="nusuario"]').val(data.usuario);
                    $('[name="nrif"]').val(data.rif);
                    $('[name="ncorreo"]').val(data.correo);
                    $('[name="nstatus"]').val(data.status);
                    $('[name="nempini"]').val(data.inicial);
                    $('[name="naccion"]').val('edit');
                    document.getElementById('nidusuario').readOnly=true;
                    document.getElementById("estatus_cli").style.display="none";
                document.getElementById("btnaddcli").style.display="inherit";
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
    $('#exampleModalLabel').text('Modificar Usuario'); 
     
}   

function pass_reset(idusuario){

  Swal.fire({
  title: 'Desea Restablecer la contrase&ntilde;a?',
  text: 'Al Aceptar se cambiara la contraseña por "12345".',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, Restablecer!'
}).then((result) => {
  if (result.value) {
    restablecer(idusuario);
  }
})
          
}

function restablecer(idusuario){
            var url;
        url = "<?php echo base_url(); ?>usera/restablecer/"+idusuario;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        //consultar();
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


function asigemp(idusuario){
    
    $('.modal-empresas').load('<?php echo base_url(); ?>usera/asigemp/'+idusuario,function(){
        $('#modalasig_empresas').text('Asignar Empresas: '+idusuario);
        $('#asig_empresas').modal({show:true});       
    });
    
}

function asigemp2(emp,usuario,event){
            if(event.checked) { var marcado=0;}else{ var marcado=1;}
            //alert(emp+'-'+usuario+'d');
            var url;
    url = "<?php echo base_url(); ?>usera/asigemp2/"+usuario+"/"+emp+'/'+marcado;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        //consultar();
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

function cambiar_vendedor(idusuario,idemp){
    var co_ven=$("#cvendedor").val();
    //alert(co_ven+'*'+idusuario+'*'+idemp);
    if(co_ven == ''){ co_ven='-'; }
    var url;
    url = "<?php echo base_url(); ?>usera/asigemp3/"+idusuario+"/"+idemp+'/'+co_ven;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        //consultar();
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

function asigmenu(idusuario){
    
    $('.modal-empresas').load('<?php echo base_url(); ?>usera/asigmenu/'+idusuario,function(){
        $('#modalasig_empresas').text('Asignar Menu: '+idusuario);
        $('#asig_empresas').modal({show:true});       
    });
    
}

function cambiarmenu(menu,idusuario,event){
            if(event.checked) { var marcado=1;}else{ var marcado=0;}
            //alert(menu+'-'+nivel+'d');
            var url;
    url = "<?php echo base_url(); ?>usera/levelsup/"+idusuario+"/"+menu+'/'+marcado;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        //consultar();
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

        function cambiarsubmenu(submenu,idusuario,menu,event){
            if(event.checked) { var marcado=1;}else{ var marcado=0;}
            //alert(menu+'-'+nivel+'d');
            var url;
    url = "<?php echo base_url(); ?>usera/levelsdown/"+idusuario+"/"+menu+"/"+submenu+'/'+marcado;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        operacion();
        //consultar();
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
    $('#codigo').val('');
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
