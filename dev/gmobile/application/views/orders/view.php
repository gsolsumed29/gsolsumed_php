<?php
                $user = $this->session->userdata('user');
                extract($user);
                $co_ven = $this->session->userdata('co_ven');
                $condiciones = $this->orders_model->getcondicion();
            ?>
<?php $datos_invoice = $this->orders_model->obtener_invoice($invoice);
$datos_invoicetmp=$datos_invoice->fact_num;?>

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
        <div class="card-header bg-white font-weight-bold">
            Visualizar Pedido
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pedido</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Renglon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Resumen</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form id="formulario" name="formulario" method="post">
                        <div class="form-row">
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-barcode"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="0" id="orden" name="orden" tabindex="2" data-toggle="tooltip" data-original-title="Pedido" readonly="yes" value="<?php echo $datos_invoice->fact_num;?>">
                            </div>
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="0" id="fecha" name="fecha" tabindex="2" data-toggle="tooltip" data-original-title="Fecha Emisi&oacute;n" readonly="yes" value="<?php echo $datos_invoice->fec_emis;?>">
                            </div>
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="0" id="fechav" name="fechav" tabindex="2" data-toggle="tooltip" data-original-title="Fecha Vencimiento" readonly="yes" value="<?php echo $datos_invoice->fec_venc;?>">
                            </div>
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                                </div>
                                <select class="form-control" id="condicion" name="condicion"  data-toggle="tooltip" data-original-title="Condici&oacute;n de Pago" required="yes">
                                    <!--<option value="CON" <?php if(trim($datos_invoice->forma_pag) == 'CON'){ echo 'selected';}  ?>>Por Anticipado</option>
                                    <option value="CON1" <?php if(trim($datos_invoice->forma_pag) == 'CON1'){ echo 'selected';}  ?>> Contado</option>
                                    <option value="CONT5"  <?php if(trim($datos_invoice->forma_pag) == 'CONT5'){ echo 'selected';}  ?>>07 Dias</option>
                                    <option value="CRE15" <?php if(trim($datos_invoice->forma_pag) == 'CRE15'){ echo 'selected';}  ?>>15 Dias</option>
                                    <option value="CRE30" <?php if(trim($datos_invoice->forma_pag) == 'CRE30'){ echo 'selected';}  ?>>30 Dias</option>-->
                        <?php 
                        foreach($condiciones as $row){ 
                            if(trim($row->co_cond) == trim($datos_invoice->forma_pag)){
                                echo '<option value="'.trim($row->co_cond).'" selected>'.$row->cond_des.'</option>';
                            }else{
                                echo '<option value="'.trim($row->co_cond).'">'.$row->cond_des.'</option>';
                            }
                            
                        }?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-secondary" id="btncliente" data-toggle="tooltip" data-original-title="Buscar Cliente"><i class="fa fa-user"></i></button>
                                </div>
                                <input type="text" class="form-control" placeholder="V-" id="nif" name="nif" tabindex="2" data-toggle="tooltip" data-original-title="RIF" readonly="yes" value="<?php echo $datos_invoice->rif;?>" >
                            </div>
                            <div class="input-group col-md-9 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="Cliente" value="<?php echo $datos_invoice->cli_des;?>" id="nombre" name="nombre" data-toggle="tooltip" data-original-title="Raz&oacute;n Social" required="yes" readonly="yes">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-12 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="Observaci&oacute;n" value="<?php echo $datos_invoice->descrip;?>" id="observacion" name="observacion" data-toggle="tooltip" data-original-title="Observaci&oacute;n" >
                            </div>
                        </div>
              <input id="codcliente" name="codcliente" value="<?php echo $datos_invoice->co_cli;?>" type="hidden">
              <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $datos_invoicetmp;?>" type="hidden">
              <input id="co_ven" name="co_ven" value="<?php echo trim($datos_invoice->co_ven);?>" type="hidden">
              <input id="baseimpuestos2" name="baseimpuestos2" value="" type="hidden">
              <input id="baseimponible2" name="baseimponible2" value="" type="hidden">
              <input id="preciototal" name="preciototal" value="" type="hidden">
              <input id="accion" name="accion" value="alta" type="hidden">
            </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card mb-4" style="height: 375px;overflow-y: auto;">
    <form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" >
        <div class="card-header bg-white font-weight-bold">
            <!--<div class="form-row">
                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                         <button type="button" class="btn btn-primary" id="btnart" onclick="btn_art();" data-toggle="tooltip" data-original-title="Buscar Articulos"><i class="fa fa-search"></i></button>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="referencia" name="referencia" placeholder="Codigo">
                    <div class="input-group-append">
                         <button type="button" class="btn btn-warning" data-toggle="tooltip" onclick="btn_plan();" data-original-title="Cargar Plantilla"><i class="fa fa-file-alt"></i></button>
                    </div>
                </div>
                <div class="input-group col-md-4 mb-1">
                    <input type="text" class="form-control form-control-sm" id="descripcion" name="descripcion" placeholder="Descripcion" tabindex="3">
                    <div class="input-group-append">
                         <button type="button" class="btn btn-success" onclick="validar();" data-toggle="tooltip" data-original-title="Agregar Articulo"><i class="fa fa-plus"></i></button>
                    </div>
                </div>

            </div>-->
        </div>
        <input name="codarticulo" value="" type="hidden" id="codarticulo">
        <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $datos_invoicetmp?>" type="hidden">  
        <input id="preciototal2" name="preciototal2" value="0" type="hidden">

                </form>
        <div class="card-body">
            <button id="btn-show-all-children"> open</button>
            <table id="table_det_invoice" class="table table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>IMPORTE</th>
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
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="form-row">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Base Imp: &nbsp;</div>
                    </div>
                    <input type="text" class="form-control money" id="subtotal" name="subtotal" placeholder="0,00" style="text-align: right;" readonly="yes">
                </div>
            </div>
                <div class="form-row">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Imp (16,00%)&nbsp;</div>
                    </div>
                    <input type="text" class="form-control money" id="impuesto" name="impuesto" placeholder="0,00" style="text-align: right;" readonly="yes">
                </div>
                </div>
                <div class="form-row">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Excento; &nbsp;</div>
                    </div>
                    <input type="text" class="form-control money" id="excento" name="excento" placeholder="0,00" style="text-align: right;" readonly="yes">
                </div>
                </div>
                <div class="form-row">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">TOTA:L &nbsp;</div>
                    </div>
                    <input type="text" class="form-control money" id="total" name="total" placeholder="0,00" style="text-align: right;" readonly="yes">
                </div>
                </div>
                <div class="form-row">
                    <div class="input-group col-md-4 mb-2">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <!--<button type="button" class="btn btn-morado" onclick="imprimir();" data-toggle="tooltip" data-original-title="Imprimir">&nbsp;<i class="fa fa-save"></i>&nbsp; Imprimir &nbsp;</button>-->
                            <button type="button" class="btn btn-danger" onclick="cancel();" data-toggle="tooltip" data-original-title="Cancelar">&nbsp;<i class="fa fa-ban"></i>&nbsp;Cerrar&nbsp;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    </div>

    <div class="modal fade bd-example-modal" id="buscarclientes" tabindex="-1" role="dialog" aria-labelledby="modalbuscarclientes" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalbuscarclientes">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            <input type="hidden" id="btipo" name="btipo">
                <div class="modal-body3">
                    <p>No hay datos para mostrar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="save_tmuestra();"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="procesar_muestra" tabindex="-1" role="dialog" aria-labelledby="modalprocesar_muestra" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalprocesar_muestra">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            <input type="hidden" id="btipo" name="btipo">
                <div class="modal-body4" style="width: 780px; height: 400px;">
                    <p>No hay datos para mostrar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="validar_resultados();"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="cobrodirecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cobro Directo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body2">
                     <div class="card-body">
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
                <input type="text" style="text-align: right;" class="form-control form-control-sm precio" id="cpagar" name="cpagar" placeholder="0" >
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="cpendiente">Pendiente</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm" id="cpendiente" name="cpendiente" placeholder="0" readonly="yes">
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
                            echo '<option value="'.$row->codformapago.'">'.$row->nombrefp.'</option>';
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
    <input type="hidden" id="cpagar2" name="cpagar2" value="0">
    <input type="hidden" id="csaldo2" name="csaldo2" value="0">
</form>
</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btncobro" onclick="save_cobro();"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>


   <div class="modal fade bd-example-modal" id="nuevocliente" tabindex="-1" role="dialog" aria-labelledby="modalimprimir_orden" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalimprimir_orden">Tipo de Imp.</h5>
                
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body5">
                    <div class="card-body">
    
    <iframe id="modal-body6" class="modal-body6" style="position: relative; width: 100%; height: 390px; display: none;" src="load.html"></iframe>
            <div id="cargandose" style="position: relative; width: 100%; height: 390px;"><div class="cargandose_loader"></div></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="imprimir('<?php echo $datos_invoice->codfactura;?>');"><i class="fa fa-print"></i> Imprimir</button>
                    <table>
                        <tr><td><h5 class="modal-title">Tipo de Imp.</h5></td><td>
                            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control form-control-sm" id="timpresion" name="timpresion" title="Tipo de Impresion">
                    <option value="0" selected>Orden Detallada</option>
                    <option value="1">Tickera</option>
                    <option value="2">Tickera</option>
                </select>
            </div>
                        </td></tr>
                    </table>

                </div>
            </div>
        </div>
    </div>


    
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
$('#titlemodule').text('  -> Pedidos');
document.getElementById('btn-show-all-children').style.display = 'none';

function format ( d ) {
    return '<table style="width:100%;"><tr><td style="border-top:0px;"><b>Cantidad:</b> <font color="#6E6E6E">'+d[3]+'</font></td><td style="border-top:0px;"><b>Precio:</b> <font color="#6E6E6E">'+d[4]+'</font></td><td style="border-top:0px;"><b>Importe:</b> <font color="#6E6E6E">'+d[5]+'</font></td></tr></table>';
}
        $(document).ready(function() {
    table_det_invoice=$('#table_det_invoice').DataTable( {
        "language": {
            processing:     "Procesando...",
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
   "paging": false,
   //deferRender:    true,

   
   info: true,
   "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            //{ className: "dt-right", "targets": [3] },
            { "data": [1] },
            { "data": [2] },
            { "data": [5] }
        ],
    "order" : [],
   rowReorder: {
            selector: 'td:nth-child(2)'
        },
   ajax : {
    url:"<?php echo base_url(); ?>orders/getdetadm",
    type:"POST",
    data:{
     codfacturatmp:<?php echo $datos_invoicetmp;?>
    }
   }
    } );

    // Add event listener for opening and closing details
    $('#table_det_invoice tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_det_invoice.row( tr );
 
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
    $('#table_det_invoice tbody').on('dblclick', 'tr', function () {
        var tr = $(this).closest('tr');
        var row = table_det_invoice.row( tr );
 
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

    $('#table_det_invoice').on('xhr.dt', function (e, settings, json, xhr) {
        console.log('ajax end');
        setTimeout(clickButton, 1000); 
    });

  // Handle click on "Expand All" button
    $('#btn-show-all-children').on('click', function(){
        // Enumerate all rows
        table_det_invoice.rows().every(function(){
            // If row has details collapsed
            if(!this.child.isShown()){
                // Open this row
                this.child(format(this.data())).show();
                $(this.node()).addClass('shown');
            }
        });
    });


} );

                // Simulate click function 
        function clickButton() { 
            click_event = new CustomEvent('click'); 
            btn_element = document.querySelector('#btn-show-all-children'); 
            btn_element.dispatchEvent(click_event); 
        } 

        // Simulate a click every second 
        //setInterval(clickButton, 1000); 
        // Handle click on "Expand All" button

function cancel(){
        location.href="../";
    }
    
function update_totales()
{
    var codfacturatmp=$('#codfacturatmp').val();
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/update_totales2/"+codfacturatmp,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="subtotal"]').val(data.subtotal);
                    $('[name="excento"]').val(data.excento);
                    $('[name="impuesto"]').val(data.impuesto);
                    $('[name="total"]').val(data.total);
                    $('[name="preciototal"]').val(data.totales);
                    $('[name="baseimponible2"]').val(data.subtotales);
                    $('[name="baseimpuestos2"]').val(data.impuestos);
            }else{
                    $('[name="subtotal"]').val('0.00');
                    $('[name="excento"]').val('0.00');
                    $('[name="impuesto"]').val('0.00');
                    $('[name="total"]').val('0.00');
                    $('[name="preciototal"]').val('0.00');
                    $('[name="baseimponible2"]').val('0.00');
                    $('[name="baseimpuestos2"]').val('0.00');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
}
update_totales();
    </script> 
    <script type="text/javascript">
        function print_adm(codfactura){
            var url='<?php echo base_url(); ?>orders/report/'+codfactura;
            $('.modal-body6').attr('src', url);
            $('#modalimprimir_orden').text('Orden: '+codfactura);
            $('#nuevocliente').modal({show:true}); 
            document.getElementById("modal-body6").style.display="none";
            document.getElementById("cargandose").style.display="inherit";

            $('.modal-body6').on('load', function() {
                document.getElementById("modal-body6").style.display="inherit";
                document.getElementById("cargandose").style.display="none"; 
            });
        //$('#nuevocliente').modal({show:true});
        }

    

    function toma_muestra(ccodfactura){
    
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_muestras/'+ccodfactura,function(){
        $('#modalbuscarclientes').text('Tomar Muestras');
        $('#buscarclientes').modal({show:true});       
    });
    
};
    function procesar(ccodfactura,codexamen,linea){
    
    $('.modal-body4').load('<?php echo base_url(); ?>orders/procesar_orden/'+ccodfactura+'/'+codexamen+'/'+linea,function(){
        $('#modalprocesar_muestra').text('Procesar Orden N: '+ccodfactura);
        $('#procesar_muestra').modal({show:true}); 
    });

};

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

function cobrar0(){
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/cobrar/<?php echo $datos_invoice->codfactura;?>",
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
                    $('[name="cpendiente"]').val('0');
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
                    $('[name="cpendiente"]').val('0');

            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
        //$('#cobrodirecto').modal({show:true});       
     
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
            alerta_msg('Debes salir del modulo actual<br> para realizar el cambio de empresa!');
        }

        function alerta_msg(msg){
            var audio = new Audio('<?php echo base_url(); ?>audio/windows_exclamacion.mp3');
            audio.play();
            reset();
            alertify.alertas = alertify.extend("alertas");
            alertify.alertas('<center>'+msg+'<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
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
            $('#procesar_muestra').remove();
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
        $('#nif2').mask('C-99999999-9', options);
        $('#nif2').on('input', function (e) {
            var nif2 = $(this).val();
            if (nif2.length > 9) {
                var cedula2 = nif.substring(2);
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
                    cancel : "Cancelar"
                },
                delay : 5000,
                buttonReverse : true,
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


