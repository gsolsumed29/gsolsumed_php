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
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="fini" name="fini" placeholder="dd/mm/yyyy" title="Fecha Emisi&oacute;n Desde" value="<?php echo date('Y-m-d');?>" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm datepicker" id="ffin" name="ffin" placeholder="dd-mm-yyyy" title="Fecha Emisi&oacute;n Hasta" value="<?php echo date('Y-m-d');?>" onkeypress="validarenter_consulta(event)">
                </div>

                <div class="input-group col-md-4 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-list"></i></div>
                    </div>
                    <select class="form-control" id="facturados" name="facturados">
                        <option value="0">Todos</option>
                        <option value="1">Facturados</option>
                        <option value="2">Sin Facturar</option>
                    </select>
                    <div class="input-group-append">
                         <button type="button" class="btn btn-morado" data-toggle="tooltip" data-original-title="Consultar" onclick="consultar()">&nbsp; <i class="fas fa-search"></i> &nbsp;</button>
                    </div>
                </div>

                
                </div>
                
        <input id="co_ven" name="co_ven" value="<?php echo trim($co_ven);?>" type="hidden">
              <input id="codcliente" name="codcliente" value="0" type="hidden">
                </form>
        <div class="card-body" style="padding: 0">
            <table id="table_det_admission" class="table table-hover" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>PEDIDO</th>
                    <th>CLIENTE</th>
                    <th>MONTO</th>
                    <!--<th>RIF</th>-->
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
$('#titlemodule').text('  -> Reportes');

/* Formatting function for row details - modify as you need */
function format ( table_id ) {
    // `d` is the original data object for the row
    return '<div class="modal-body-'+table_id+'" style="position:relative; margin-left: -10px; margin-top: -10px; width: calc(100% + 20px); margin-bottom:-10px;"><center><p>Cargando...</p><br><img src="images/ajax-loader.gif"></center></div><br><br>';
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
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
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
   "processing": true,
   "serverSide": true,
   //"paging": true,
   //deferRender:    true,
        scrollY:        '50vh',
        scrollCollapse: false,
        scroller:       true,
   
   info: true,
   "columnDefs": [

             { className: "details-control", "targets": [0], "orderable": false,"data": null,"defaultContent": '' },
            { className: "dt-right", "targets": [3] },
            { "data": [1] },
            { "data": [2] },
            { "data": [3] }

        ],
   "order" : [],
   scroller: {
                  loadingIndicator: true
              },
   rowReorder: {
            selector: 'td:nth-child(2)'
        },

   ajax : {
    url:"<?php echo base_url(); ?>pxf/getclient",
    type:"POST",
    data:{
     fini: function() { return $('#fini').val() },
     ffin: function() { return $('#ffin').val() },
     facturados: function() { return $('#facturados').val() },
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
                var cadena=new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(total);
 //console.log(cadena.slice(0, -2));
            // Update footer
            $( api.column( 4 ).header() ).html(
                'Monto ('+ cadena.slice(0, -2) +')'
            );

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
            var virtual_task_id = row.data()[0];
            //alert(virtual_task_id);
            var subtable_id = "subtable-"+virtual_task_id;
            row.child(format(subtable_id)).show(); /* HERE I format the new table */
            tr.addClass('shown');
            sub_DataTable(virtual_task_id, subtable_id); /*HERE I was expecting to load data*/
            // Open this row
            //row.child( format(row.data()) ).show();
            //tr.addClass('shown');
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
            var virtual_task_id = row.data()[0];
            //alert(virtual_task_id);
            var subtable_id = "subtable-"+virtual_task_id;
            row.child(format(subtable_id)).show(); /* HERE I format the new table */
            tr.addClass('shown');
            sub_DataTable(virtual_task_id, subtable_id); /*HERE I was expecting to load data*/
            // Open this row
            //row.child( format(row.data()) ).show();
            //tr.addClass('shown');
        }
    } );

    function sub_DataTable(fact_num,table_id){
    $('.modal-body-'+table_id).load('<?php echo base_url(); ?>pxf/search_cli/'+fact_num,function(){     
    });
};


    $('#table_det_admission').on('preXhr.dt', function (e, settings, data) {
        //console.log('ajax start');
        $('<div class="spinner">Loading</div>').appendTo('body');
    });
 
    $('#table_det_admission').on('xhr.dt', function (e, settings, json, xhr) {
        //console.log('ajax end');
        $('div.spinner').remove();
    });

} );


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
function consultar() {
      table_det_admission.ajax.reload(); //reload datatable ajax
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
