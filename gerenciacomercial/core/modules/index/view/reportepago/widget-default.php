
 
    <div class="app-content content " id="PagosRealizados">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
               
            </div>
             <input class="dataPagosRealizados" data-cliente="<?php echo $_GET['facturas_cliente_2'] ?>" type="hidden" id="dataPagosRealizados" value="">
            <div class="content-body pagosRealizados">
                <section class="invoice-edit-wrapper">
                    <div class="row invoice-edit">
                        <!-- Invoice Edit Left starts -->
                        <div class="col-xl-12 col-md-12 col-12">
                         <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                                
                                            <table class="dataTablesPagosRealizados table" id="dataTablesPagosRealizados">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>                                                       
                                                        <th></th>
                                                        <th></th>                                                     
                                                        <th></th>                                                    
                                                        <th></th>  <th></th> 
                                                        <th></th>   
                                                        <th></th>                                                                                   
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                               
                            </section>                 
                        </div>
                        <!-- Invoice Edit Left ends -->

                        <!-- Invoice Edit Right starts -->
                        <div class="content-header-right col-xl-12 col-md-12 col-12">
                            <div class="card">
                                <div class="card-body d-flex flex-wrap justify-content-center justify-content-md-end gap-2 align-items-center">
                                    <p class="totalAcumulado d-none mb-0" data-facturas="<?php echo $_GET['facturas_cancelar'] ?>" id="totalAcumulado"></p>
                                    
                                    <button class="btn btn-warning flex-grow-0 px-3" id="btnModalAgregarPagos" data-bs-toggle="modal" data-bs-target="#modalPagoFacturas">
                                        <i data-feather='dollar-sign'></i> Agregar pago
                                    </button>
                                    
                                    <button class="btn btn-success btnConfirmarPago flex-grow-0 px-3" id="btnConfirmarPago">
                                        <i data-feather='check-circle'></i> Confirmar pago
                                    </button>
                                    
                                    <a href="index.php?view=cobros" class="btn btn-danger flex-grow-0 px-3">
                                        <i data-feather='chevron-left'></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                                                <!-- Invoice Edit Right ends -->
                    </div>

                 
                 
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade modalPagoFacturas modalPagoFacturas_reporte" id="modalPagoFacturas" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Detalles del pago</h1>
                
                <div class="table-responsive ">
                  <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Documentos</th>
                                <th>Total USD</th>
                                <th class="">Total BS.D</th>
                                <th>Tasa BCV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold" id="facturas_cancelar_text" data-facturas="<?php echo $_GET['facturas_cancelar'] ?>"></td>
                                <td class="text-success fw-bold" id="facturas_saldo_text" data-facturasu ="<?php echo $_GET['facturas_saldo'] ?>" ><?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?></td>
                                <td class="text-primary fw-bold" id="facturas_saldo_text_bsd" data-facturasb="<?php echo $_GET['facturas_saldo']*$_SESSION['tasa'] ?>" ></td>
                                <td class="text-info fw-bold" id ="tasa_cambio" data-tasa="<?php echo $_SESSION['tasa']?>"><?php echo number_format($_SESSION['tasa'], 2, '.', '') ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-hover d-none" id="tablaRetenciones">
                        <thead class="table-primary">
                            <tr>
                                <th>Documentos</th>
                                <th>Numero Retención</th>
                                <th class="">Total BS.D</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Las filas se generarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
                
                <form id="addNewAddressForm" class="row gy-1 gx-2">
                    <input type="hidden" class="form-control facturas_cancelar" id="facturas_cancelar" value="<?php echo $_GET['facturas_cancelar'] ?>" />
                    <input type="hidden" id="facturas_cliente_codigo" class="form-control facturas_cliente_codigo" value="<?php echo $_GET['facturas_cliente_codigo'] ?>"/>
                    <input type="hidden" class="form-control facturas_cliente" id="facturas_cliente" value="<?php echo htmlspecialchars($_GET['facturas_cliente_2'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" class="form-control facturas_saldo" id="facturas_saldo" value="<?php echo $_GET['facturas_saldo'] ?>">
                    <input type="hidden" class="form-control facturas_saldo_bs" id="facturas_saldo_bs" value="<?php echo $_GET['facturas_saldo_bs'] ?>">
                    
                    
                    <div class="col-12 col-md-6 fecha" id="fecha">
                        <label class="form-label" for="basic-icon-default-date">Fecha de pago *</label>                                               
                        <input type="text" id="fp-default" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">                                                   
                    </div>

                    
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalAddressFirstName">Método de pago *</label>
                        <select class="select2 form-select facturas_metodo" id="select2-basic-1" aria-hidden="true">
                            <option value="NO">Seleccionar</option>
                            <option value="EF">EFECTIVO</option>
                            <option value="DEP">DEPOSITO</option>                                                           
                                                                   
                        </select>
                    </div>
                    
                    <div class="col-12 col-md-6 banco" id="banco" style="display:none">
                        <label class="form-label" for="modalAddressLastName">Banco *</label>
                        <select class="select2 form-select facturas_banco" id="facturas_banco" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                               
                        </select>
                    </div>
                    
                    <div class="col-12 col-md-6 cuenta" id="cuenta" style="display:none">
                        <label class="form-label" for="modalAddressCountry">Cuenta *</label>
                        <select class="select2 form-select facturas_cuenta" id="facturas_cuenta" name="facturas_cuenta" disabled aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                              
                        </select>
                    </div>

              
                    <div class="col-12 col-md-12 referencia" id="referencia" style="display:none">                    
                     
                    
                    <label class="form-label" for="modalAddressAddress1">Referencia * </label>
                     <p class="fw-bolder">Para separar las referencias, se debe separar con comas(,).</p>
            
                       <!-- <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_referencia" id="facturas_referencia" name ="facturas_referencia" aria-label="$12000" />-->
                     <div class="input-group input-group-aligned">
                                <input type="text" class="form-control facturas_referencia" id="facturas_referencia" name ="facturas_referencia"  aria-describedby="REF: 123456798">
                                <button class="btn btn-outline-primary btnBuscarReferencia" id="btnBuscarReferencia" type="button">
                                    <i data-feather="search"></i>
                                </button>
                            </div>
                    </div>
                    
                    <div class="col-12 col-md-6 caja" id="caja" style="display:none">
                        <label class="form-label" for="basic-icon-default-date">Caja *</label>                                               
                        <select class="select2 form-select facturas_caja" id="facturas_caja" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                                     
                        </select>                                                   
                    </div>                      
                  

                    <div class="col-12 col-md-6 monto montoAbonoBs" id="monto" style="display:none">
                        <label class="form-label" for="pesos">Monto abono Bolívares (BS.D) *</label>
                        <input class="form-control facturas_monto_bs money-bs" type="text" id="pesos" disabled placeholder="Ingrese cantidad en BS.D">
                    </div>
                    
                    <div class="col-12 col-md-6 monto montoAbonoUSD" id="monto" style="display:none">
                        <label class="form-label" for="dollars">Monto abono Dólares (USD) *</label>
                        <input class="form-control facturas_monto money-usd" type="text" id="dollars" disabled placeholder="Ingrese cantidad en $">
                    </div>
                                    
                    <div class="col-12 col-md-6 monto d-none" id="monto">
                        <label class="form-label" for="basic-icon-default-date">Deuda en BS.D *</label>       
                        <input class="form-control monto_calculado_bs" id="monto_calculado_bs" type="text" value="" disabled>            
                    </div>
                    
                    <div class="col-12 col-md-6 monto d-none" id="monto">
                        <label class="form-label" for="basic-icon-default-date">Deuda en USD *</label>       
                        <input class="form-control monto_calculado" id="monto_calculado" data-saldo="<?php echo $_GET['facturas_saldo'] ?>" type="text" value="<?php echo $_GET['facturas_saldo'] ?>" disabled>  
                       
                    </div>                                
                    <input class="form-control monto_calculado_retenciones d-none" id="monto_calculado_retenciones" data-saldor="" type="text">                              
                   
                    <div class="col-12 col-md-12 fecha" id="fecha">
                        <div class="upload-section">
                            <div class="drop-zone" id="drop-zone">                             
                                <p id="drop-zone-text">Arrastra tus archivos aquí o haz clic para seleccionar</p>
                                <div class="browse-btn">Seleccionar archivos</div>
                            </div>                            
                            <input type="file" id="file-input" class="file-input facturas_documento"  accept=".jpg,.jpeg,.png,.gif,.pdf" multiple>    
                        </div>                        
                        <div id="preview-section" class="preview-section hidden">                          
                            <div id="selected-files" class="selected-files"></div>
                        </div>                        
                    </div>

                    <div class="col-12 col-md-12 fecha" id="fecha">
                        <label class="form-label" for="basic-icon-default-date">Observación *</label>                                               
                        <textarea class="form-control facturas_observacion" rows="2" id="facturas_observacion" name="facturas_observacion"></textarea>   
                    </div>
                    
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-1 mt-2 btnPagarFacturas"> <i data-feather='save'></i>  Guardar</button>
                        <button type="reset" class="btn btn-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather='x-circle'></i>   Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>