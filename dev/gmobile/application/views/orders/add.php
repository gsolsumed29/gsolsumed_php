<?php
    $user = $this->session->userdata('user');
    extract($user);
    $co_ven = $this->session->userdata('co_ven');
    $tmp = $this->orders_model->obtener_fact_num();
    $ultimo=$tmp->ultimo;
    $datos_invoicetmp = $this->orders_model->obtener_invoicetmp($ultimo,$co_ven);
    //$datos_config = $this->orders_model->obtener_config();
    //$mesas = $this->orders_model->getmesas();
    $vendedores = $this->orders_model->getvendedores();
    $condiciones = $this->orders_model->getcondicion();
    $categorias = $this->orders_model->getcat_art();
    $datos_invoicetmp=$ultimo;
    $cliente_generico='';
    $condicion='CON';
    $hoy=date("Y-m-d");
?>

<div class="content p-4">
    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Agregar Pedido 
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
                                <input type="text" class="form-control" placeholder="0" id="orden" name="orden" tabindex="2" data-toggle="tooltip" data-original-title="Pedido" readonly="yes" value="0">
                            </div>
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="0" id="fecha" name="fecha" tabindex="2" data-toggle="tooltip" data-original-title="Fecha Emisi&oacute;n" readonly="yes" value="<?php echo $hoy;?>">
                            </div>
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="0" id="fechav" name="fechav" tabindex="2" data-toggle="tooltip" data-original-title="Fecha Vencimiento" readonly="yes" value="<?php echo $hoy;?>">
                            </div>
                            <div class="input-group col-md-3 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                                </div>
                                <select class="form-control" id="condicion" name="condicion"  data-toggle="tooltip" data-original-title="Condici&oacute;n de Pago" required="yes">
                                    <!--<option value="CON">Por Anticipado</option>
                                    <option value="CON1"> Contado</option>
                                    <option value="CONT5">07 Dias</option>
                                    <option value="CRE15">15 Dias</option>
                                    <option value="CRE30">30 Dias</option>-->
                        <?php 
                        foreach($condiciones as $row){ 
                            if(trim($row->co_cond) == $condicion){
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
                                    <button type="button" class="btn btn-morado" id="btncliente" onclick="btn_cliente();" data-toggle="tooltip" data-original-title="Buscar Cliente"><i class="fa fa-user"></i></button>
                                </div>
                                <input type="text" class="form-control" placeholder="V-" id="nif" name="nif" tabindex="2" data-toggle="tooltip" data-original-title="RIF" required="yes" value="" onkeypress="validar_cliente(event,'1');">
                            </div>
                            <div class="input-group col-md-9 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="Cliente" value="" id="nombre" name="nombre" data-toggle="tooltip" data-original-title="Raz&oacute;n Social" required="yes" readonly="yes">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-12 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="Observaci&oacute;n" value="" id="observacion" name="observacion" data-toggle="tooltip" data-original-title="Observaci&oacute;n" >
                            </div>
                        </div>
              <input id="codcliente" name="codcliente" value="0" type="hidden">
              <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $datos_invoicetmp;?>" type="hidden">
              <input id="co_ven" name="co_ven" value="<?php echo trim($co_ven);?>" type="hidden">
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
            <div class="form-row">
                <div class="input-group col-md-2 mb-1">
                    <div class="input-group-prepend">
                         <button type="button" class="btn btn-morado" id="btnart" onclick="btn_art();" data-toggle="tooltip" data-original-title="Agregar Articulos"><i class="fa fa-plus"></i> Agregar</button>
                    </div>
                    <input type="hidden" class="form-control form-control-sm" id="referencia" name="referencia" placeholder="Codigo">
                    <!--<div class="input-group-append">
                         <button type="button" class="btn btn-warning" data-toggle="tooltip" onclick="btn_plan();" data-original-title="Cargar Plantilla"><i class="fa fa-file-alt"></i></button>
                    </div>-->
                </div>
                <!--<div class="input-group col-md-4 mb-1">
                    <input type="text" class="form-control form-control-sm" id="descripcion" name="descripcion" placeholder="Descripcion" tabindex="3">
                    <div class="input-group-append">
                         <button type="button" class="btn btn-success" onclick="validar();" data-toggle="tooltip" data-original-title="Agregar Articulo"><i class="fa fa-plus"></i></button>
                    </div>
                </div>-->

            </div>
        </div>
        <input name="codarticulo" value="" type="hidden" id="codarticulo">
        <input name="cantidad" value="1" type="hidden" id="cantidad">
        <input name="aumentar" value="1" type="hidden" id="aumentar">
        <input name="nuli" value="0" type="hidden" id="nuli">
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
                        <div class="btn-group-sm btnderecha" role="group" aria-label="Basic example">
                        	<img src="<?php echo base_url(); ?>images/ajax-loader.gif" style="display: none;" id="loaderimg">
                            <button type="button" class="btn btn-morado" id="btn-save" onclick="save_adm();" data-toggle="tooltip" data-original-title="Guardar">&nbsp;<i class="fa fa-save"></i>&nbsp; Guardar &nbsp;</button>
                            <button type="button" class="btn btn-danger" id="btn-can" onclick="cancel();" data-toggle="tooltip" data-original-title="Cancelar">&nbsp;<i class="fa fa-ban"></i>&nbsp;Cancelar&nbsp;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    </div>

 <div class="modal fade bd-example-modal-lg" id="buscararticulos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Articulos</h5>
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
                    <select class="form-control" id="bcategoria" name="bcategoria" onchange="search_art();">
                        <option value="0">Todas las Lineas</option>
                        <?php 
                        foreach($categorias2 as $row){ 
                            echo '<option value="'.trim($row->co_subl).'">'.trim($row->subl_des).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="bcodigo" name="bcodigo" placeholder="Codigo" onkeypress="validarenter(event);" onkeyup="search_art();">
                </div>
                <div class="input-group col-md-4 mb-1">
                    <!--<div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                    </div>-->
                    <input type="text" class="form-control form-control-sm" id="bdescripcion" name="bdescripcion" placeholder="Descripcion" onkeypress="validarenter(event);" onkeyup="search_art();">
                    <div class="input-group-append">
                         <button type="button" class="btn btn-success" onclick="search_art();"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <br>
                <div class="modal-body" style="height: 60vh; overflow-y: scroll;">
                    <p>No hay datos para mostrar.</p>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Consultar</button>
                </div>-->
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="modificararticulos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar Articulos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                
                <div class="modal-body2">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-morado" onclick="save_modif_art();"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
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
                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="brif" name="brif" placeholder="V-" onkeypress="validarenter_cliente(event);" onkeyup="search_cli();">
                </div>
                <div class="input-group col-md-4 mb-1">
                    <!--<div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                    </div>-->
                    <input type="text" class="form-control form-control-sm" id="bnombre" name="bnombre" placeholder="Nombre" onkeypress="validarenter_cliente(event);" onkeyup="search_cli();">
                    <div class="input-group-append">
                         <button type="button" class="btn btn-morado" onclick="search_cli();"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="btipo" name="btipo">
                <div class="modal-body3" style="height: 70vh; overflow-y: scroll;">
                    <p>No hay datos para mostrar.</p>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Consultar</button>
                </div>-->
            </div>
        </div>
    </div>

<div class="modal fade bd-example-modal-lg" id="buscarmesas" tabindex="-1" role="dialog" aria-labelledby="modalbuscarmesas" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalbuscarmesas">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            
                <div class="modal-bodymesas">
                    <p>No hay datos para mostrar.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal" id="nuevocliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cliente Nuevo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body4">
                    <div class="card-body">
<form id="formulario_cliente" name="formulario_cliente" method="post">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="nrif">RIF/CI</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nrif" name="nrif" placeholder="V-">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="nsexo">Sexo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-venus-mars"></i></div>
                </div>
                <select class="form-control form-control-sm" id="nsexo" name="nsexo">
                    <option value="">Seleccione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="nfn">F/N</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm datepicker" id="nfn" name="nfn" placeholder="dd-mm-yyyy">
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
                <input type="text" class="form-control form-control-sm" id="nnombre" name="nnombre" placeholder="Nombre">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="ndireccion">Direcci&oacute;n</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-map"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="ndireccion" name="ndireccion" placeholder="Direccion">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="nmovil">Telefono Movil</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm movil" id="nmovil" name="nmovil" placeholder="04120000000">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="ntelefono">Telefono Habitacion</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-phone"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm telefono" id="ntelefono" name="ntelefono" placeholder="02540000000">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="nemail">Correo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-at"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="nemail" name="nemail" placeholder="name@example.com" onblur="validarEmail(this.value);">
            </div>
        </div>
    </div>
<input type="hidden" id="ntipo" name="ntipo" value="0">
</form>
</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-morado" id="btnaddcli" onclick="add_cli();"><i class="fa fa-save"></i> Guardar</button>
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
                    <div class="card-body">
                        <h5 class="modal-title" ><i class="fa fa-exclamation-triangle"></i> Estas Seguro?</h5>
                        <input type="hidden" id="ecodigo" name="ecodigo" value="0">
                        <input type="hidden" id="ecodfactura" name="ecodfactura" value="0">
                        <input type="hidden" id="emod" name="emod" value="0">
                        <input type="hidden" id="ecantidad" name="ecantidad" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="delete_art2();"><i class="fa fa-trash"></i> Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inicio de cambio de cantidad-->
          <div class="modal fade bd-example-modal-sm" id="cambiar_cant" tabindex="-1" role="dialog" aria-labelledby="modalcambiar_cant" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcambiar_cant">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="form-row">
                    &nbsp;&nbsp;&nbsp;
                <div class="col-md-11 mb-3">
            <label for="nsexo">Cantidad</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calculator"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm number" id="ccantidad" name="ccantidad" value="0" style="text-align: right;">
            </div>
        </div>
</div>
<input type="hidden" id="ccodarticulo" name="ccodarticulo" value="">
                <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button-->
                    <button type="button" class="btn btn-morado" onclick="cambiar_cant();"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de cambio de cantidad-->


    <script src="<?php echo base_url(); ?>bootadmin-master/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>bootadmin-master/js/jquery-1.12.4.js"></script>
  <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
  <script src="<?php echo base_url(); ?>jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/dataTables.scrollingPagination.js"></script>
<script src="<?php echo base_url(); ?>DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>DataTables/Scroller-2.0.1/js/dataTables.scroller.min.js"></script>
    <!--<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>-->
<script src="<?php echo base_url(); ?>bootadmin-master/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootadmin.min.js"></script>
   
<script type="text/javascript">
    $('#titlemodule').text('  -> Pedidos');
    $('#nif').focus();
    document.getElementById('btn-show-all-children').style.display = 'none';
    //$('.sidebar').toggleClass('toggled');

</script>
    <script type="text/javascript">
function format ( d ) {
    var comi="'";
    return '<table style="width:100%;"><tr><td style="border-top:0px;"><b>Cantidad:</b> <font color="#6E6E6E">'+d[3]+'</font></td><td style="border-top:0px;"><b>Precio:</b> <font color="#6E6E6E">'+d[4]+'</font></td><td style="border-top:0px;"><b>Importe:</b> <font color="#6E6E6E">'+d[5]+'</font></td><td style="border-top:0px;">'+
    '<div class="btn-group" role="group" aria-label="Basic example">'+
        
        '<button type="button" class="btn btn-danger" onclick="delete_art('+d[0]+','+comi+d[1]+comi+','+comi+d[2]+comi+','+comi+d[3]+comi+');" data-toggle="tooltip" data-original-title="Eliminar">&nbsp;<i class="fa fa-trash"></i> &nbsp;</button>'+
    '</div></td></tr>';
}
//'<button type="button" class="btn btn-primary" onclick="modif_art('+d[0]+','+d[6]+');" data-toggle="tooltip" data-original-title="Editar">&nbsp;<i class="fa fa-edit"></i> &nbsp;</button>'+
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
    url:"<?php echo base_url(); ?>orders/getdettmp",
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


function refrescar_detalle() {
      table_det_invoice.ajax.reload(null,false); //reload datatable ajax

}

        /* Llamando al fichero CargarContenido.php */
function btn_art(){
    var codfacturatmp=$('#codfacturatmp').val();
    var codcliente=$('#codcliente').val();
    if(codcliente != "0"){
    /*$('.modal-body').load('<?php echo base_url(); ?>orders/search_art/-/-/0/0/'+codfacturatmp,function(){
        $('#buscararticulos').modal({show:true}); 
        document.getElementById('bdescripcion').focus();     
    });*/
    $('#buscararticulos').modal({show:true}); 
    document.getElementById('bdescripcion').focus();
    search_art();
}else{
    error_msg('Debe Seleccionar un Cliente.');
}
};

function btn_plan(){
    
    $('.modal-bodyp').load('<?php echo base_url(); ?>orders/search_plan/-/-/0',function(){
        $('#buscarplantilla').modal({show:true}); 
        document.getElementById('bdescripcionp').focus();     
    });
    search_plan();
};

function btn_categoria(categoria){
    
    $('.modal-bodycat').load('<?php echo base_url(); ?>orders/search_cat/'+categoria,function(){
        //$('#buscarplantilla').modal({show:true}); 
        //document.getElementById('bdescripcionp').focus();     
    });
    //search_plan();
};


function btn_cliente(){
    var co_ven=$('#co_ven').val();
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_cli/-/-/'+co_ven,function(){
        $('#modalbuscarclientes').text('Buscar Clientes');
        $('#brif').focus(); 
        $('#buscarclientes').modal({show:true}); 
        //search_cli();      
    });
    
};

function btn_mesas(){
    
    $('.modal-bodymesas').load('<?php echo base_url(); ?>orders/search_mesas/0',function(){
        $('#modalbuscarmesas').text('Cambiar Mesa');
        $('#buscarmesas').modal({show:true});     
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


function modif_art(admision,numlinea){
    var codcliente=$('#codcliente').val();
    $('.modal-body2').load('<?php echo base_url(); ?>orders/modif_art/'+admision+'/'+numlinea+'/'+codcliente,function(){
        $('#modificararticulos').modal({show:true});       
    });      
}

        function delete_art(codfactura,codigo,nom_exa,$cantidad){
        $('#delete_art').modal({show:true});
        $('#exampleModalLabel2').text('Se Eliminara ->'+nom_exa);
        $('#ecodigo').val(codigo);
        $('#ecodfactura').val(codfactura); 
        $('#emod').val(0);
        $('#ecantidad').val($cantidad);  
    }

    function fecha_edad(){
        var edad=$('#nedad').val();
        var tedad=$('#ntedad').val();
        //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/fechaedad/"+edad+"/"+tedad,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="nfn"]').val(data.fecha);
                    document.getElementById('ndireccion').focus();

            }else{
                    $('[name="nfn"]').val("<?php echo date('Y-m-d');?>");
                    document.getElementById('ndireccion').focus();

            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
    }

function cliente_new(tipo,rif){
    var rifarray = rif.split("-");
    var nac = rifarray[0];
    var cedula = rifarray[1];
    $("#ntipo").val(tipo);
    var url;
        url = "<?php echo base_url(); ?>orders/comprobarrif/"+nac+"/"+cedula;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.success) //if success close modal and reload ajax table
            {
                //alert('siiiii');
                //$('#nuevocliente').modal({show:true});
                    $("#nrif").val(rif);
                    $("#nnombre").val(data.message);
                    //document.getElementById('nedad').focus();
            }else{

                error_msg(data.message);
                $("#nrif").val(rif);
                $("#nnombre").val('');
                //document.getElementById('nedad').focus();
            }

            $('#nuevocliente').on('shown.bs.modal', function () {
                //$('#nedad').focus();
            })
            $.fn.modal.Constructor.prototype.enforceFocus = $.noop;
            $("#nuevocliente").on("shown.bs.modal", function() {
                $(document).off('focusin.bs.modal');
            });
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
 
        }
    });

    $('#nuevocliente').modal({show:true});
    /*$('.modal-body4').load('<?php echo base_url(); ?>orders/cliente_new/'+tipo+'/'+rif,function(){
        $('#nuevocliente').modal({show:true});       
    });*/      
}


function add_pedido(codarticulo){
        var mesa=$('#mesa').val();
        var codcliente=$('#codcliente').val();
        var condicion=$('#condicion').val();
        var vendedor=$('#vendedor').val();
        //alert(mesa+'-'+vendedor+'-'+condicion+'-'+codcliente+'-'+codarticulo);
        //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/addpedido/"+mesa+"/"+vendedor+"/"+condicion+"/"+codcliente+"/"+codarticulo,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data.success){
                //alert('ggg');
                location.href="/"+mesa;
            }else{
                error_msg('Error al Guardar pedido');

            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
    }


function delete_art2(){
    var codigo=$("#ecodigo").val();
    var codfactura=$("#ecodfactura").val();
    var mod=$("#emod").val();
    var cantidad=$("#ecantidad").val();
    var url;
        url = "<?php echo base_url(); ?>orders/delete_art/"+codigo+"/"+codfactura;
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
                refrescar_detalle();
                update_totales();
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

function validarenter(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) search_art();
        }
function validarenterp(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) search_plan();
        }
function validarenter_cliente(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) search_cli();
        }
function validar_cliente(e,tipo) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) cliente_vali(tipo);
        }
function validar_mesa(e,tipo) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13) mesa_vali(tipo);
        }
function cliente_vali(tipo)
{
var rif=$('#nif').val();
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/cliente_vali/"+rif,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="codcliente"]').val(data.co_cli);
                    $('[name="nif"]').val(data.rif);
                    $('[name="nombre"]').val(data.cli_des);
                    if(data.pedido > 0){
                        alerta_msg('El cliente posee pedidos sin procesar.');
                    }
                    //$('#nif2').focus();
            }else{
                    //cliente_new(tipo,rif);
                    noexiste('Cliente');
                    $('[name="codcliente"]').val(0);
                    $('[name="nif"]').val('');
                    $('[name="nombre"]').val(''); 
                    $('#nif').focus();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
}
//cliente_vali('1');
function mesa_vali()
{
    var mesa=$('#mesa').val();
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/mesa_vali/"+mesa,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data){
                    $('[name="codcliente"]').val(data.codigo);
                    $('[name="mesa"]').val(data.codigo);
                    $('[name="nombre"]').val(data.nombre);
                    $('#nif2').focus();   
            }else{
                    //cliente_new(tipo,rif);
                    noexiste('Cliente'); 
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error get data from ajax');
        }
    });
}

function update_totales()
{
    var codfacturatmp=$('#codfacturatmp').val();
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url(); ?>orders/update_totales/"+codfacturatmp,
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

function search_art(){
    var codcliente=$('#codcliente').val();
    var bdescripcion=$('#bdescripcion').val();
    var bcodigo=$('#bcodigo').val();
    var bcategoria=$('#bcategoria').val();
    var codfacturatmp=$('#codfacturatmp').val();
    if(bcodigo == ''){ bcodigo='-'; }
    if(bdescripcion == ''){ bdescripcion='-'; }
    $('.modal-body').load('<?php echo base_url(); ?>orders/search_art/'+bcodigo+'/'+bdescripcion+'/'+bcategoria+'/'+codcliente+'/'+codfacturatmp,function(){
        $('#buscararticulos').modal({show:true});
    });
}

function search_plan(){
    var codcliente=$('#codcliente').val();
    var bdescripcion=$('#bdescripcionp').val();
    var bcodigo=$('#bcodigop').val();
    if(bcodigo == ''){ bcodigo='-'; }
    if(bdescripcion == ''){ bdescripcion='-'; }
    $('.modal-bodyp').load('<?php echo base_url(); ?>orders/search_plan/'+bcodigo+'/'+bdescripcion+'/'+codcliente,function(){
        $('#buscarplantilla').modal({show:true});
    });
}

function search_cli(){
    var brif=$('#brif').val();
    var bnombre=$('#bnombre').val();
    if(brif == ''){ brif='-'; }
    if(bnombre == ''){ bnombre='-'; }
    var co_ven=$('#co_ven').val();
    $('.modal-body3').load('<?php echo base_url(); ?>orders/search_cli/'+brif+'/'+bnombre+'/'+co_ven,function(){
        $('#buscarclientes').modal({show:true});
    });
}

function seleccionar_art3(codarticulo){
    var mesa=$('#mesa').val();
    var vendedor=$('#vendedor').val();
    var orden=$('#codfacturatmp').val();
    if(mesa == ''){
        error_msg('Debe seleccionar una Mesa.');
        document.getElementById('mesa').focus();
    }else{
        if(vendedor == ''){
            error_msg('Debe seleccionar un Mesonero.');
        document.getElementById('vendedor').focus();
        }else{
            if(orden == 0 || orden == ''){
                //insertar encabezado de pedidos
                alert('N orden en blanco o 0 -'+codarticulo);
                add_pedido(codarticulo);
            }else{
                //insertar detallado de pedidos
                alert(mesa+'*'+orden+'*'+codarticulo);
            }
        }
    }
    
}
var zoomSelectorCount = 0;
function seleccionar_art(codarticulo,action){
    $('#referencia').val(codarticulo);
    $('#descripcion').val(nombre);
    $('#codarticulo').val(codarticulo);
    $('#cantidad').val('1');
    $('#nuli').val('0');
    zoomSelectorCount =document.getElementById('conteo-'+codarticulo).innerText;
//actualizar_importe();
if (action == "zoomIn" && zoomSelectorCount <999999999) {
      zoomSelectorCount++;
      document.getElementById('conteo-'+codarticulo).innerText =''+zoomSelectorCount;
      $('#aumentar').val('1');
      console.log(zoomSelectorCount);
    }else if (action == "zoomOut" && zoomSelectorCount > 0) {
      zoomSelectorCount--;
      document.getElementById('conteo-'+codarticulo).innerText =''+zoomSelectorCount;
      $('#aumentar').val('0');
      console.log(zoomSelectorCount);
    }else{
        $('#aumentar').val('0');
    }
    //$('#conteo').innerText ="hola";
    validar();

    //parent.validar();
    $('#bcodigo').val('');
    $('#bdescripcion').val('');
    //$('#bdescripcion').focus();
    //alert('precio: '+precio);
}

function mod_art_cant(codarticulo){
    zoomSelectorCount =document.getElementById('conteo-'+codarticulo).innerText;
    //alert(zoomSelectorCount);
    $('#modalcambiar_cant').text('Codigo: '+codarticulo);
    $('#ccantidad').val(zoomSelectorCount);
    $('#ccodarticulo').val(codarticulo);
    $('#cambiar_cant').modal({show:true});
    $('#ccantidad').focus();
    if(zoomSelectorCount == '0'){
    	$('#ccantidad').val('1');
    	$('#ccantidad').focus();
    }else{
    	$('#ccantidad').val(zoomSelectorCount);
    	$('#ccantidad').focus();
    }
    document.getElementById('ccantidad').focus();
}

function cambiar_cant(){
    var codarticulo= $('#ccodarticulo').val();
    var cantidad= $('#ccantidad').val();
    //alert(cantidad);
    $('#referencia').val(codarticulo);
    $('#codarticulo').val(codarticulo);
   	$('#cantidad').val(cantidad);
    
    $('#nuli').val('1');

    //document.getElementById('conteo-'+codarticulo).innerText =''+cantidad;
    validar();
    //$('#cambiar_cant').modal('hide');
    //parent.validar();
    $('#bcodigo').val('');
    $('#bdescripcion').val('');
}

$('#cambiar_cant').on('shown.bs.modal', function () {
    $('#ccantidad').focus();
}) 
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$("#cambiar_cant").on("shown.bs.modal", function() {
 $(document).off('focusin.bs.modal');
});

function seleccionar_art2(codfamilia,pref,nombre,codarticulo,precio,cantidad,dcto){
    //alert(codfamilia+'-'+pref+'-'+nombre+'-'+codarticulo+'-'+precio+'-'+cantidad+'-'+dcto);
                    $("#referencia").val('');
                    $("#descripcion").val('');
                    $("#precio").val('');
                    $("#cantidad").val('1');
                    $("#importe").val('');
                    $("#dcto").val('0');
                    $("#nuli").val('0');
                    $("#codfamilia").val('0');
    $('#codfamilia').val(codfamilia);
    $('#referencia').val(pref);
    $('#descripcion').val(nombre);
    $('#codarticulo').val(codarticulo);

    //precio=document.getElementById("cboPrecio-"+codarticulo).value;
    $('#precio').val(precio);
    //cantidad=document.getElementById("cantidad-"+codarticulo).value;
    $('#cantidad').val(cantidad);
    //descuento=document.getElementById("descuento-"+codarticulo).value;
    $('#dcto').val(dcto);

    actualizar_importe();
    validar();
    
    //parent.validar();
    //$('#bcodigo').val('');
    //$('#bdescripcion').val('');
    //$('#bdescripcion').focus();
    //alert('precio: '+precio);
}

function seleccionar_plan(codplantillas,cliente){
    $('.modal-bodyp').load('<?php echo base_url(); ?>orders/add_plantillas/'+codplantillas+'/'+cliente,function(){
        $('#buscarplantilla').modal({show:true});
    });
}

function seleccionar_cli(rif){
    $('#nif').val(rif);
    cliente_vali(1);
    $('#buscarclientes').modal('hide');
    
}

function save_modif_art(){
    var pref=$('#mcodigo').val();
    var nombre=$('#mdescripcion').val();
    $('#referencia').val(pref);
    $('#descripcion').val(nombre);
    $('#codarticulo').val(pref);
    var precio=$('#mprecio').val();
    var cantidad=$('#mcantidad').val();
    var nuli=$('#mnuli').val();
    $('#cantidad').val(cantidad);
    $('#nuli').val(nuli);

    //actualizar_importe();
    validar();
    $('#modificararticulos').modal('hide');
}

function actualizar_importe()
            {
                var precio=document.getElementById("precio").value;
                var cantidad=document.getElementById("cantidad").value;
                var descuento=document.getElementById("dcto").value;
                descuento=descuento/100;
                total=precio*cantidad;
                descuento=total*descuento;
                total=total-descuento;
                var original=parseFloat(total);
                var result=Math.round(original*100)/100 ;
                document.getElementById("importe").value=result;
            }
function validar() 
            {
                var mensaje="";
                var entero=0;
                var enteroo=0;
        
                if (document.getElementById("referencia").value==""){ 
                    mensaje="  - Codigo<br>"; 
                    $('#referencia').addClass('is-invalid');
                }else{
                    $('#referencia').removeClass('is-invalid');
                }

                if (document.getElementById("cantidad").value=="") 
                        { 
                        mensaje+="  - Falta la cantidad<br>";
                        $('#cantidad').addClass('is-invalid');
                        } else {
                            enteroo=parseInt(document.getElementById("cantidad").value);
                            if (isNaN(enteroo)==true) {
                                mensaje+="  - La cantidad debe ser numerica<br>";
                                $('#cantidad').addClass('is-invalid');
                            } else {
                                    document.getElementById("cantidad").value=enteroo;
                                    $('#cantidad').removeClass('is-invalid');
                                }
                        }
              
                
                if (mensaje!="") {
                    error_msg("Atencion, se han detectado las siguientes incorrecciones:<br>"+mensaje);
                } else {
                    add_art_det();
                }
            }
            
        function cambio_iva() {
            var original=parseFloat(document.getElementById("baseimponible2").value);
            var result=Math.round(original*100)/100 ;
            document.getElementById("baseimponible").value=result;
    
            document.getElementById("baseimpuestos").value=parseFloat(result * parseFloat(document.getElementById("iva").value / 100));
            var original1=parseFloat(document.getElementById("baseimpuestos").value);
            var result1=Math.round(original1*100)/100 ;
            document.getElementById("baseimpuestos").value=result1;
            var original2=parseFloat(result + result1);
            var result2=Math.round(original2*100)/100 ;
            document.getElementById("preciototal").value=result2;
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

        
        function add_art_det(){
            var url;
        url = "<?php echo base_url(); ?>orders/addart";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formulario_lineas').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.success) //if success close modal and reload ajax table
            {
                //$('#modal_form2').modal('hide');
                table_det_invoice.ajax.reload(); 
                operacion();
                update_totales();
                    $("#referencia").val('');
                    $("#descripcion").val('');
                    $("#codarticulo").val('');
                    $('#cambiar_cant').modal('hide');
                    document.getElementById('conteo-'+data.codarticulo).innerText =''+data.cantidad;
            }else{
                error_msg(data.message);
                if(data.type == '1'){
                	$('#ccantidad').focus();
                	$('#ccantidad').select();
                	//document.getElementById('conteo-'+data.codarticulo).innerText ='0';
                    //alert('si');
                    if(data.cantidad == 1){
                        document.getElementById('conteo-'+data.codarticulo).innerText ='0';
                    }
                }
                if(data.type == '2'){
                    document.getElementById('conteo-'+data.codarticulo).innerText =''+data.cantidad;
                }
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
    if($("#nrif").val() == ""){
        error_msg("El campo RIF no puede estar vacío.");
        $("#nrif").focus();
        return false;
    }
    if($("#nsexo").val() == ""){
        error_msg("El campo Sexo no puede estar vacío.");
        $("#nsexo").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#nfn").val() == ""){
        error_msg("El campo Fecha de Nacimiento no puede estar vacío.");
        $("#nfn").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#nnombre").val() == ""){
        error_msg("El campo Nombre no puede estar vacío.");
        $("#nnombre").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#ndireccion").val() == ""){
        error_msg("El campo Dirección no puede estar vacío.");
        $("#ndireccion").focus();
        return false;
    }
    if($("#ntelefono").val() == ""){
        error_msg("El campo Telefono no puede estar vacío.");
        $("#ntelefono").focus();
        return false;
    }
    if($("#nmovil").val() == ""){
        error_msg("El campo Movil no puede estar vacío.");
        $("#nmovil").focus();
        return false;
    }
    if($("#nemail").val() == ""){
        error_msg("El campo Email no puede estar vacío.");
        $("#nemail").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
  
        return true; // Si todo está correcto
}


function validaFormAdm(){
    // Campos de texto
    if($("#nif").val() == ""){
        error_msg("El campo RIF del cliente no puede estar vacío.");
        $('#myTab a[href="#home"]').tab('show');
        $("#nif").focus();
        return false;
    }
    if($("#nombre").val() == ""){
        error_msg("El campo Nombre del cliente no puede estar vacío.");
        $('#myTab a[href="#home"]').tab('show');
        $("#nombre").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#codcliente").val() == ""){
        error_msg("Datos del cliente no pueden estar vacío.");
        $('#myTab a[href="#home"]').tab('show');
        $("#nif").focus();
        return false;
    }
  
        return true; // Si todo está correcto
}

        function add_cli(){
            if(validaForm()){
            document.getElementById("btnaddcli").style.display="none";
            var url;
        url = "<?php echo base_url(); ?>orders/addcli";
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
                cliente_vali(data.type);
                    $("#nrif").val('');
                    $("#nnombre").val('');
                    $("#nfn").val('');
                    $("#ndireccion").val('');
                    $("#nemail").val('');
                    $("#nsexo").val('0');
                    $("#nmovil").val('0');
                    $("#ntelefono").val('');
                    $("#ntipo").val('0');
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


        function save_adm(){
            if(validaFormAdm()){
            	document.getElementById("btn-save").style.display="none";
            	document.getElementById("btn-can").style.display="none";
    			document.getElementById("loaderimg").style.display="inherit";
            var url;
        url = "<?php echo base_url(); ?>orders/save";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formulario').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                operacion(); 
                 location.href="<?php echo base_url(); ?>orders/view/"+data.invoice;
                 //document.getElementById("btn-save").style.display="inherit";
                 document.getElementById("btn-can").style.display="inherit";
    			document.getElementById("loaderimg").style.display="none";     
            }else{
                error_msg(data.message);
                document.getElementById("btn-save").style.display="inherit";
                document.getElementById("btn-can").style.display="inherit";
    			document.getElementById("loaderimg").style.display="none";
            }
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
            document.getElementById("btn-save").style.display="inherit";
            document.getElementById("btn-can").style.display="inherit";
    		document.getElementById("loaderimg").style.display="none";
 
        }
    });
          }  
        }

        function cancel(){
            location.href="<?php echo base_url(); ?>orders";
        }
    </script>

 <script type="text/javascript" src="<?php echo base_url(); ?>jQuery-Mask/src/jquery.mask.js"></script>
 <script type="text/javascript">
    
    $(function () {
        var options = {
            translation: {
                '0': {pattern: /\d/},
                'Z': {pattern: /[0-0]/},
                '4': {pattern: /[4-4]/},
                '1': {pattern: /[1-2]/},
                '9': {pattern: /\d/, optional: true},
                '#': {pattern: /\d/, recursive: true},
                '*': {pattern: /-|#/, fallback: '-'},
                'C': {pattern: /V|v|E|e|M|m|J|j|G|g|P|p|C|c/, fallback: 'V'}
            }
        };
        $('.money').mask('#.##0,00', {reverse: true});
        $('.movil').mask('Z4199999999', options);
        $('.telefono').mask('Z9999999999', options);
        $('#nif').mask('C-99999999-9', options);
        $('.number').mask('999999999999', options);
        
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


