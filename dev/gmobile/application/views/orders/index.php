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
<style type="text/css">
    #layer {
  position:relative;
  width: 100%; height: 100%; top: 0%; left: 0%;
  background: rgba( 255, 255, 255, .8 );
  z-index: 10;
}

  .lds-dual-ring {
  display: inline-block;
  position: absolute;
    top: 30%;
    left: 40%;
  width: 128px;
  height: 128px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 138px;
  height: 138px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #01A9DB;
  border-color: #01A9DB transparent #01A9DB transparent;
  animation: lds-dual-ring 1.2s linear infinite;
  z-index: 10;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
      .cargandose_loader {
  display: inline-block;
  position: absolute;
    top: 30%;
    left: 40%;
  width: 64px;
  height: 64px;
}
.cargandose_loader:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #fff;
  border-color: #ccc transparent #ccc transparent;
  animation: cargandose_loader 1.2s linear infinite;
}
@keyframes cargandose_loader {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

    </style>
<div class="content p-4">


   <div class="card mb-4">
    <form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" >
        <div class="card-header bg-white font-weight-bold">

                <div class="form-row">
                <div class="input-group col-md-2 mb-1">
                <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                    </div>
                <input type="text" class="form-control form-control-sm" placeholder="J-" id="nif" name="nif" tabindex="1"  onkeypress="validarenter_consulta(event)">
                </div>
                <div class="col-md-2 mb-1">
                        <input type="text" class="form-control" placeholder="Cliente" value="" id="nombre" name="nombre" onkeypress="validarenter_consulta(event)">
                </div>
                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control" id="admision" name="admision" placeholder="Pedido" value="" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="fini" name="fini" placeholder="dd-mm-yyyy" title="Fecha Emisi&oacute;n Desde" value="<?php echo $date_past;?>" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="ffin" name="ffin" placeholder="dd-mm-yyyy" title="Fecha Emisi&oacute;n Hasta" value="<?php echo $date_now;?>" onkeypress="validarenter_consulta(event)">
                </div>
                

                

                <div class="col-md-1 mb-1">
                    <div class="btn-group btn-group-sm btnderecha">
                                <button type="button" class="btn btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                                <button type="button" class="btn btn-warning" data-toggle="tooltip" data-original-title="Limpiar Campos" onclick="limpiar()">&nbsp; <i class="fas fa-undo"></i> &nbsp;</button>
                                <button type="button" class="btn btn-success" data-toggle="tooltip" data-original-title="Agregar Orden" onclick="add_adm()">&nbsp; <i class="fas fa-plus"></i> &nbsp;</button>
                                
                            </div>
                </div>

                </div>
                
        <input id="codpaciente" name="codpaciente" value="" type="hidden">
              <input id="co_ven" name="co_ven" value="<?php echo trim($co_ven);?>" type="hidden">

                </form>
        <div class="card-body">
            <table id="table_det_admission" class="table table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <!--<th>ITEM</th>-->
                    
                    <th>Pedido</th>
                    <th>codigo</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                    <th></th>
                    <th></th>
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

                <div class="form-row">
                    &nbsp;&nbsp;&nbsp;
                <div class="input-group col-md-4 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-list"></i></div>
                    </div>
                    <select class="form-control" id="bempresa" name="bempresa">
                        <option value="0">TODOS</option>
                        <option value="1">CLIENTES</option>
                        <option value="2">EMPRESAS</option>
                    </select>
                </div>
                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="brif" name="brif" placeholder="V-" onkeypress="validarenter_cliente(event);">
                </div>
                <div class="input-group col-md-4 mb-1">
                    <!--<div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                    </div>-->
                    <input type="text" class="form-control form-control-sm" id="bnombre" name="bnombre" placeholder="Nombre" onkeypress="validarenter_cliente(event);">
                    <div class="input-group-append">
                         <button type="button" class="btn btn-primary" onclick="search_cli();"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="btipo" name="btipo">
                <div class="modal-body3">
                    <p>No hay datos para mostrar.</p>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Consultar</button>
                </div>-->
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
                    <div class="card-body">
                        <h5 class="modal-title" ><i class="fa fa-exclamation-triangle"></i> Estas Seguro?</h5>
                        <input type="hidden" id="ecodfactura" name="ecodfactura" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="delete_art2();"><i class="fa fa-trash"></i> Eliminar</button>
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
$('#titlemodule').text('  -> Pedidos');
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
   "columnDefs": [
      { className: "details-control2", "targets": [6] },
      { className: "details-control3", "targets": [7] },
      { targets: [1], visible: false},
      { targets: [8], visible: false},
      { targets: [9], visible: false},
      { targets: [10], visible: false},
      { className: "dt-right", "targets": [4,5] }
    ],
   info: true,
   "order" : [],
   rowReorder: {
            selector: 'td:nth-child(2)'
        },
   ajax : {
    url:"<?php echo base_url(); ?>orders/getinvoice",
    type:"POST",
    data:{
     admision: function() { return $('#admision').val() },
     fini: function() { return $('#fini').val() },
     ffin: function() { return $('#ffin').val() },
     nif: function() { return $('#nif').val() },
     nombre: function() { return $('#nombre').val() },
     co_ven: function() { return $('#co_ven').val() }
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
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total1 = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
                var cadena=new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(total);
                var cadena1=new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(total1);
 //console.log(cadena.slice(0, -2));
            // Update footer
            $( api.column( 4 ).header() ).html(
                'Monto ('+ cadena.slice(0, -2) +')'
            );
            $( api.column( 5 ).header() ).html(
                'Saldo ('+ cadena1.slice(0, -2) +')'
            );
        }


    } );

    $('#table_det_admission tbody').on('dblclick', 'tr', function () {
        var data = table_det_admission.row( this ).data();
        view(data[0]);
    } );

    $('#table_det_admission tbody').on('click', 'td.details-control2', function () {
        var data = table_det_admission.row( this ).data();
        edit(data[0],data[8]);
    } );

    $('#table_det_admission tbody').on('click', 'td.details-control3', function () {
        var data = table_det_admission.row( this ).data();
        delete_art(data[0],data[8]);
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

        /* Llamando al fichero CargarContenido.php */

function btn_cliente(){
    
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_cli/-/-/2/1',function(){
        $('#modalbuscarclientes').text('Buscar Clientes');
        $("#bempresa").val('2');
        $("#btipo").val('1');
        $('#bempresa option[value="2"]').attr("selected", true);
        $('#brif').focus(); 
        $('#buscarclientes').modal({show:true});       
    });
    
};

function delete_art(fact_num,status){
  if(status == '0'){
    $('#delete_art').modal({show:true});
        $('#exampleModalLabel2').text('Se eliminara el pedido -> '+fact_num);
        $('#ecodfactura').val(fact_num);  
      }else{
        alert_msg('El pedido ya esta procesado.');
        
    }
      }

function delete_art2(){
    var codfactura=$("#ecodfactura").val();
    var url;
        url = "<?php echo base_url(); ?>orders/anular2/"+codfactura;
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

function btn_paciente(){
    
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_cli/-/-/1/2',function(){
        $('#modalbuscarclientes').text('Buscar Pacientes');
        $("#bempresa").val('1');
        $("#btipo").val('2');
        $('#bempresa option[value="1"]').attr("selected", true);
        $('#brif').focus(); 
        $('#buscarclientes').modal({show:true});     
    });
    
};

function btn_titular(){
    
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_cli/-/-/1/3',function(){
        $('#modalbuscarclientes').text('Buscar Titular');
        $("#bempresa").val('1');
        $("#btipo").val('3');
        $('#bempresa option[value="1"]').attr("selected", true);
        $('#brif').focus(); 
        $('#buscarclientes').modal({show:true});      
    });
    
};

 function cobros_report(){
     var admision = $('#admision').val();
     var fini = $('#fini').val();
     var ffin = $('#ffin').val();
     var estado = $('#estado').val();
     var condicion = $('#condicion').val();
     var nif = $('#nif').val();
     var nombre = $('#nombre').val();
     var nif2 = $('#nif2').val();
     var nombre2 = $('#nombre2').val();

     if(admision==""){ admision='-';}
     if(condicion==""){ condicion='-';}
     if(nif==""){ nif='-';}
     if(nombre==""){ nombre='-';}
     if(nif2==""){ nif2='-';}
     if(nombre2==""){ nombre2='-';}
    
    var url='<?php echo base_url(); ?>orders/report2/'+admision+'/'+fini+'/'+ffin+'/'+estado+'/'+condicion+'/'+nif+'/'+nif2+'/'+nombre+'/'+nombre2;
    $('.modal-body7').attr('src', url);
    $('#modalprocesar_muestra2').text('Ver listado de ordenes');
    $('#procesar_muestra2').modal({show:true}); 
    document.getElementById("modal-body7").style.display="none";
    document.getElementById("cargandose").style.display="inherit";


    $('.modal-body7').on('load', function() {
        document.getElementById("modal-body7").style.display="inherit";
    document.getElementById("cargandose").style.display="none"; 
    });
    

}

function anular(codfactura){
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/anular/"+codfactura,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                if(data.si > 0){
                    alert_msg('No se puede anular (Tiene cobros asociados).');
                }else{
                    anular1(codfactura);
                    /*$('#anular_fact').modal({show:true});
                    $('#exampleModalLabel2').text('Se Anulara la Factura -> '+codfactura);
                    $('#ecodfactura').val(codfactura);*/
                }

            }else{
                error_msg('Error al cargar datos.');

            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });      
     
}

function anular1(codfactura){
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/anular1/"+codfactura,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                if(data.si > 0){
                    alert_msg('No se puede anular (Tiene articulos con stock menor a la cantidad facturada).');
                }else{
                    $('#anular_fact').modal({show:true});
                    $('#exampleModalLabel2').text('Se Anulara la Factura -> '+codfactura);
                    $('#ecodfactura').val(codfactura);
                }

            }else{
                error_msg('Error al cargar datos.');

            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });      
     
}

function anular2(){
    var codfactura=$("#ecodfactura").val();
    var url;
        url = "<?php echo base_url(); ?>orders/anular2/"+codfactura;
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
                $('#anular_fact').modal('hide');
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

function view(codfactura){
    location.href="<?php echo base_url(); ?>orders/view/"+codfactura;
}
function edit(codfactura,status){
  if(status = '0'){
    location.href="<?php echo base_url(); ?>orders/edit/"+codfactura;
  }else{
    alert_msg('El pedido ya esta procesado.');
  }
}

function validarenter_consulta(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) consultar();
        }
function validarenter(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) search_art();
        }
function validarenter_cliente(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) search_cli();
        }
function validar_cliente(e,tipo) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) cliente_vali(tipo);
        }
function cliente_vali(tipo)
{
    if(tipo == 1){ var rif=$('#nif').val(); }
    if(tipo == 2){ var rif=$('#nif2').val(); }
    if(tipo == 3){ var rif=$('#nif3').val(); }
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/cliente_vali/"+rif,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                if (tipo == 1) {
                    $('[name="codcliente"]').val(data.codcliente);
                    $('[name="nif"]').val(data.nif);
                    $('[name="nombre"]').val(data.nombre);
                    $('#nif2').focus();
                }
                if (tipo == 2) {
                    $('[name="codpaciente"]').val(data.codcliente);
                    $('[name="nif2"]').val(data.nif);
                    $('[name="nombre2"]').val(data.nombre);
                    $('#nif3').focus();
                }
                if (tipo == 3) {
                    $('[name="codtitular"]').val(data.codcliente);
                    $('[name="nif3"]').val(data.nif);
                    $('[name="nombre3"]').val(data.nombre);
                    $('#descripcion').focus();
                }
                
            }else{
                if(tipo == 1){
                    //cliente_new(tipo,rif);
                    noexiste('Cliente'); 
                }
                if(tipo == 2){
                    //cliente_new(tipo,rif);
                    noexiste('Paciente');
                }
                if(tipo == 3){
                    //cliente_new(tipo,rif);
                    noexiste('Titular');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
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

function seleccionar_cli(codcliente,rif,nombre,tipo){
    if(tipo == 1){
        $('#codcliente').val(codcliente);
        $('#nombre').val(nombre);
        $('#nif').val(rif);
    }
    if(tipo == 2){
        $('#codpaciente').val(codcliente);
        $('#nombre2').val(nombre);
        $('#nif2').val(rif);
    }
    if(tipo == 3){
        $('#codtitular').val(codcliente);
        $('#nombre3').val(nombre);
        $('#nif3').val(rif);
    }
    $('#buscarclientes').modal('hide');
    
}

function toma_muestra(ccodfactura){
    
    $('.modal-body1').load('<?php echo base_url(); ?>orders/search_muestras/'+ccodfactura,function(){
        $('#modaltoma_muestra').text('Tomar Muestras');
        $('#toma_muestra').modal({show:true});       
    });
    
}

function sms(codfactura){
    error_msg('Modulo no disponible.');
}

function procesar(ccodfactura,codexamen,linea){
    
    $('.modal-body6').load('<?php echo base_url(); ?>orders/procesar_orden/'+ccodfactura+'/'+codexamen+'/'+linea,function(){
        $('#modalprocesar_muestra').text('Procesar Orden N: '+ccodfactura);
        $('#procesar_muestra').modal({show:true}); 
    });

}


function cambiar_examen(){
    //activarCarga();
    //alert('bb');
    var exa=document.getElementById('cboExamen').value;
    var porciones = exa.split('~');
    var o=porciones[0];
    var e=porciones[1];
    var l=porciones[2];
    //location.href="procesar_orden.php?o="+o+"&e="+e+"&l="+l;
    procesar(o,e,l);
  }

function validar_resultados(){

  Swal.fire({
  title: 'Desea Validar Resultado?',
  text: "Al Aceptar el resultado estara listo para Imprimir!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, Validar!'
}).then((result) => {
  if (result.value) {
    document.getElementById('validame').value=1;
    document.getElementById("formulario_new1").style.display="none";
    document.getElementById("cargandose").style.display="inherit";
    save_resultados();
  }else{
    document.getElementById('validame').value=0;
    document.getElementById("formulario_new1").style.display="none";
    document.getElementById("cargandose").style.display="inherit";
    save_resultados();
  }
})
          
}

function save_resultados(){
            var url;
        url = "<?php echo base_url(); ?>orders/save_resultados";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_procesar').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                exito_msg(data.message); 
                procesar(data.codfactura,'0','0');
                //$('#cobrodirecto').modal('hide');    
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

    function cobrar(codfactura){
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/cobrar/"+codfactura,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="ccodfactura"]').val(data.codfactura);
                    $('[name="ccliente"]').val(data.nombre);
                    $('[name="ccodcliente"]').val(data.codcliente);
                    $('[name="ctotal"]').val(data.totalfactura);
                    $('[name="csaldo"]').val(data.saldo);
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

function save_cobro(){
            var url;
        url = "<?php echo base_url(); ?>orders/save_cobro";
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
                cobrar(data.codfactura)
                //$('#cobrodirecto').modal('hide');
                 //location.href="<?php echo base_url(); ?>orders/view/"+data.invoice;     
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

function save_tmuestra(){
            var url;
        url = "<?php echo base_url(); ?>orders/save_tmuestra";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formulario_muestra').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                exito_msg(data.message); 
                //consultar();
                //cobrar0()
                $('#buscarclientes').modal('hide');
                 //location.href="<?php echo base_url(); ?>orders/view/"+data.invoice;     
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

    function imprimir(codfactura){
        var timpresion=$('#timpresion').val();

        if(timpresion == 0){
            window.open('<?php echo base_url(); ?>orders/report/'+codfactura, '_blank');
        }else{
            if(timpresion == 1){
                var url='http://192.168.0.104/ticket/index.php';
            }else{
                var url='http://192.168.0.107/ticket/index.php';
            }
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {codfactura:codfactura},
        dataType: "JSON",
        beforeSend:function(){
                //parent.document.getElementById("layer").style.display="inherit";
            },
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                operacion();     
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

        function exito_msg(msg){
            reset();
            alertify.success('<center>'+msg+'<br> <i class="fa fa-check-circle"></i></center>');
            return false;
        }

        function noexiste(cliente){
            reset();
            alertify.alertas = alertify.extend("alertas");
            alertify.alertas('<center>No existe ningun '+cliente+' con ese RIF.<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }
        function noexiste2(msg){
            $('#procesar_muestra').modal('hide');
            //$('#procesar_muestra').remove();
            reset();
            alertify.alertas = alertify.extend("alertas");
            alertify.alertas('<center>No existe ningun '+msg+'<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }
        function alert_msg(msg){
            reset();
            alertify.alertas = alertify.extend("alertas");
            alertify.alertas('<center>'+msg+'<br> <i class="fa fa-exclamation-triangle"></i></center>');
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


function add_adm(){
    location.href="<?php echo base_url(); ?>orders/add";
}

function limpiar(){
    $('#nif').val('');
    $('#nif2').val('');
    $('#nombre').val('');
    $('#nombre2').val('');
    $('#admision').val('');
    $('#estado').val('0');
    $('#fini').val('<?php echo $date_past;?>');
    $('#ffin').val("<?php echo date('d-m-Y');?>");
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
                'C': {pattern: /V|v|E|e|M|m|J|j|G|g/, fallback: 'V'}
            }
        };
        $('.money').mask('#.##0,00', {reverse: true});
        $('#nif1').mask('C999999999', options);
        $('#nif1').on('input', function (e) {
            var nif = $(this).val();
            if (nif.length > 9) {
                var cedula = nif.substring(2);
                if (cedula > 80000000) {
                    $(this).val('E-' + cedula);
                }
            }
        });
        $('#nif2').mask('C999999999', options);
        $('#nif2').on('input', function (e) {
            var nif2 = $(this).val();
            if (nif2.length > 9) {
                var cedula2 = nif.substring(2);
                if (cedula2 > 80000000) {
                    $(this).val('E-' + cedula2);
                }
            }
        });
        $('#brif').mask('C999999999', options);
        $('#brif').on('input', function (e) {
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
<script type="text/javascript">
    
   $(document).ready(function(){
  /*$('.date').mask('00/00/0000');
  $('.time').mask('00:00:00');
  $('.date_time').mask('00/00/0000 00:00:00');
  $('.cep').mask('00000-000');
  $('.phone').mask('0000-0000');
  $('.phone_with_ddd').mask('(00) 0000-0000');
  $('.phone_us').mask('(000) 000-0000');
  $('.mixed').mask('AAA 000-S0S');
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
  $('.money').mask('000.000.000.000.000,00', {reverse: true});
  $('.money2').mask("#.##0,00", {reverse: true});*/
  $('#cantidad').mask("#.##0,00", {reverse: true,selectOnFocus: true});
  $('#stock0').mask("#.##0,00", {reverse: true,selectOnFocus: true});
  $('#conteo0').mask("#.##0,00", {reverse: true,selectOnFocus: true});
  $('#ppp0').mask("#.##0,00", {reverse: true,selectOnFocus: true});
  $('#stocka').mask("#.##0,00", {reverse: true,selectOnFocus: true});
  $('.precio').mask("#.##0,00", {reverse: true,selectOnFocus: true});
  /*$('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
    translation: {
      'Z': {
        pattern: /[0-9]/, optional: true
      }
    }
  });
  $('.ip_address').mask('099.099.099.099');
  $('.percent').mask('##0,00%', {reverse: true});
  $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});*/
  $('#fi_mov').mask("00-00-0000", {placeholder: "__-__-____"});
  $('#ff_mov').mask("00-00-0000", {placeholder: "__-__-____"});
  $('#fi_inv').mask("00-00-0000", {placeholder: "__-__-____"});
  $('#ff_inv').mask("00-00-0000", {placeholder: "__-__-____"});
  /*$('.fallback').mask("00r00r0000", {
      translation: {
        'r': {
          pattern: /[\/]/,
          fallback: '/'
        },
        placeholder: "__/__/____"
      }
    });
  $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});*/
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
        format: 'DD-MM-Y',
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


