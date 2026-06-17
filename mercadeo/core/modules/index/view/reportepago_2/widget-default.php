
 
    <div class="app-content content " id="PagosRealizados">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
               
            </div>
             <input class="dataPagosRealizados" type="hidden" id="dataPagosRealizados" value="">
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
                        <div class="content-header-right text-md-end  col-xl-12 col-md-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <p class="totalAcumulado d-none"  data-facturas="<?php echo $_GET['facturas_cancelar'] ?>" id ="totalAcumulado"></p>
                                  <button class="btn btn-warning " id="btnModalAgregarPagos" data-bs-toggle="modal" data-bs-target="#modalPagoFacturas">
                                     <i data-feather='dollar-sign'></i> Agregar pago
                                    </button>
                                  
                                    <button class="btn btn-success btnConfirmarPago" id="btnConfirmarPago" > <i data-feather='check-circle'>                                        
                                        </i> Confirmar pago 
                                    </button>
                                    <a href ="index.php?view=cobros" class="btn btn-danger " >
                                        <i data-feather='chevron-left'></i> volver
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
                                <th class="d-none">Total BS.D</th>
                                <th>Tasa BCV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold" id="facturas_cancelar_text" data-facturas="<?php echo $_GET['facturas_cancelar'] ?>"></td>
                                <td class="text-success fw-bold" id="facturas_saldo_text">$<?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?></td>
                                <td class="text-primary fw-bold d-none">BS.D <?php echo number_format(($_GET['facturas_saldo']*$_SESSION['tasa']), 2, ',', '.') ?></td>
                                <td class="text-info fw-bold" id ="tasa_cambio" data-tasa="<?php echo $_SESSION['tasa']?>"><?php echo number_format($_SESSION['tasa'], 2, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <form id="addNewAddressForm" class="row gy-1 gx-2">
                    <input type="hidden" class="form-control facturas_cancelar" id="facturas_cancelar" value="<?php echo $_GET['facturas_cancelar'] ?>" />
                    <input type="hidden" id="facturas_cliente_codigo" class="form-control facturas_cliente_codigo" value="<?php echo $_GET['facturas_cliente_codigo'] ?>"/>
                    <input type="hidden" class="form-control facturas_cliente" id="facturas_cliente" value="<?php echo $_GET['facturas_cliente_2'] ?>">
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
                            <option value="CH">CHEQUE</option>                                          
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
                    
                    <div class="col-12 col-md-6 referencia" id="referencia" style="display:none">
                        <label class="form-label" for="modalAddressAddress1">Referencia *</label>
                        <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_referencia" id="facturas_referencia" name ="facturas_referencia" aria-label="$12000" />
                    </div>
                    
                    <div class="col-12 col-md-6 caja" id="caja" style="display:none">
                        <label class="form-label" for="basic-icon-default-date">Caja *</label>                                               
                        <select class="select2 form-select facturas_caja" id="facturas_caja" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                                     
                        </select>                                                   
                    </div>  
                    
                  

                    <div class="col-12 col-md-6 monto" id="monto">
                        <label class="form-label" for="pesos">Monto abono Bolívares (BS.D) *</label>
                        <input class="form-control facturas_monto_bs money-bs" type="text" id="pesos" placeholder="Ingrese cantidad en BS.D">
                    </div>
                    
                    <div class="col-12 col-md-6 monto" id="monto">
                        <label class="form-label" for="dollars">Monto abono Dólares (USD) *</label>
                        <input class="form-control facturas_monto money-usd" type="text" id="dollars" placeholder="Ingrese cantidad en $">
                    </div>
                                    
                    <div class="col-12 col-md-6 monto d-none" id="monto">
                        <label class="form-label" for="basic-icon-default-date">Deuda en BS.D *</label>       
                        <input class="form-control monto_calculado_bs" id="monto_calculado_bs" type="text" value="" disabled>            
                    </div>
                    
                    <div class="col-12 col-md-6 monto d-none" id="monto">
                        <label class="form-label" for="basic-icon-default-date">Deuda en $ *</label>       
                        <input class="form-control monto_calculado" id="monto_calculado" data-saldo="<?php echo $_GET['facturas_saldo'] ?>" type="text" value="<?php echo $_GET['facturas_saldo'] ?>" disabled>            
                    </div>                                
                                     
                    <div class="col-12 col-md-12 fecha" id="fecha">
                        <label class="form-label" for="basic-icon-default-date">Foto *</label>                                               
                        <input type="file" accept="image/png,image/jpeg" class="form-control facturas_documento" name="facturas_documento" id="facturas_documento">        
                    </div>

                    <div class="col-12 col-md-12 fecha" id="fecha">
                        <label class="form-label" for="basic-icon-default-date">Observación *</label>                                               
                        <textarea class="form-control facturas_observacion" rows="2" id="facturas_observacion" name="facturas_observacion"></textarea>   
                    </div>
                    
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-1 mt-2 btnPagarFacturas">Guardar</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>