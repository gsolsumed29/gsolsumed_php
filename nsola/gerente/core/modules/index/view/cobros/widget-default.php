  <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                <div class="row match-height">
                     <!-- Developer Meetup Card -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                                </div>
                                <div class="card-body">                              
                                    <select class="select2 form-select comboVendedoresFactura" id="comboVendedoresFactura">
                                        <option value="0">Seleccione Vendedor</option>
                                    </select>
                                    <br>
                                    <select class="select2 form-select comboClientesFactura" id="comboClientesFactura" disabled>
                                        <option value="0">Seleccione cliente</option>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-8 col-12">
                        <input class="dataFacturas" type="hidden" id="dataFacturas" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="datatables-basic-facturas table" id="facturas">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                       
                                                        <th>Nº Documento</th>
                                                        <th>Saldo</th>
                                                     
                                                        <th>Fecha Emisiòn</th>
                                                    
                                                        <th>Tipo Documento</th>   
                                                        <th></th>                                      
                                                        <th>Estatus</th>          
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal to add new record -->
                                <div class="modal modal-slide-in fade modalPagoFacturas" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Datos del pago</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-fullname" >Facturas a cancelar</label>
                                                    <input type="text" class="form-control facturas_cancelar" id="facturas_cancelar" aria-label="facturas_cancelar" disabled />
                                                </div>
                                                <div class="mb-1 d-none">
                                                    <label class="form-label" for="basic-icon-default-post">Codigo cliente</label>
                                                    <input type="text" id="facturas_cliente_codigo" class="form-control facturas_cliente_codigo"  aria-label="facturas_cliente_codigo" disabled/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Cliente</label>
                                                    <input type="text" id="facturas_cliente" class="form-control facturas_cliente"  aria-label="facturas_cliente" disabled/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Saldo</label>
                                                    <div class="input-group input-group-merge mb-2">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control facturas_saldo" id="facturas_saldo" aria-label="facturas_saldo" disabled>
                                                       
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Monto a cancelar</label>
                                                    <div class="input-group input-group-merge mb-2">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control facturas_monto"   id="facturas_monto" aria-label="facturas_monto" >
                                                      
                                                    </div>
                                                </div>
                                          
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Mètodo de pago</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select facturas_metodo" id="select2-basic-1"  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                            <option value="EF">EFECTIVO</option>
                                                            <option value="DEP">DEPOSITO</option>                                                           
                                                            <option value="CH">CHEQUE</option>                                          
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Tipo de moneda</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select facturas_moneda" id="select2-basic-1"  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                            <option value="$">Divisa Americana</option>
                                                            <option value="BS.D">Bolivares</option>                                                           
                                                                                                  
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1 banco" id="banco" style="display:none">
                                                    <label class="form-label" for="basic-icon-default-date">Banco</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select facturas_banco" id="facturas_banco"  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                                                               
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1 cuenta" id="cuenta" style="display:none">
                                                    <label class="form-label" for="basic-icon-default-date">Cuenta</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select facturas_cuenta" id="facturas_cuenta" disabled  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                                                              
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1 referencia" id="referencia" style="display:none">
                                                    <label class="form-label" for="basic-icon-default-salary">Referencia</label>
                                                    <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_referencia"  aria-label="$12000" />
                                                </div>

                                                <div class="mb-1 caja" id="caja" style="display:none">
                                                    <label class="form-label" for="basic-icon-default-date">Caja</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select facturas_caja" id="select2-basic-4"  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                                                                     
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Pago</label>
                                                    <input type="text" id="fp-default" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                </div>
                                                <div class="mb-1 documento-siniestro">
                                                    <label class="form-label" for="basic-icon-default-email">Documento *</label>
                                                    <input type="file"accept="image/png,image/jpeg" class="form-control facturas_documento" name="facturas_documento" id="facturas_documento">        
                                                </div>    
                                                <div class="mb-4">
                                                    <label class="form-label" for="basic-icon-default-salary">Observaciòn</label>
                                                    <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_observacion"  aria-label="$12000" />
                                                </div>

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit PagarFacturas me-1"> <i data-feather='save'></i> Guardar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                            <!--/ Basic table -->
                        </div>
                        <!--/ Company Table Card -->

                       
                     
              

                    </div>

                
                   
                </section>
              
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->