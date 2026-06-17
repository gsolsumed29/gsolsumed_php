  <!-- BEGIN: Content-->
    <div class="app-content content  m_cobros">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Cobros </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=pedido">Pedido</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Cobranzas
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="content-body">             
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                     <!-- Developer Meetup Card -->
                        <div class="col-lg-6 col-md-6 col-12" id="busqueda" style="display:"  >
                            <div class="card card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                                </div>
                                <div class="card-body">                                 
                                                         
                                            <select class=" form-select cmbTipoDocumento" id="cmbTipoDocumento">
                                                        <option value="0" selected>Tipo de documento</option>
                                                        <option value="2">Adelantos</option>
                                                        <option value="1">Cobros</option>
                                            </select> 

                                            <br>   

                                            <select class="select2 form-select comboClientesFactura" id="select2-basic-comboClientesFactura">
                                                        <option value="0" selected>Seleccione cliente</option>
                                            </select>
                                    
                                </div>
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-8 col-12" id="cobros" style="display:none" >
                            <input class="dataFacturas" type="hidden" id="dataFacturas" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="dataTablesFacturas table" id="dataTablesFacturas">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>                                                       
                                                        <th>Nº Documento</th>
                                                        <th>Saldo</th>                                                     
                                                        <th>Fecha Emisiòn</th>                                                    
                                                        <th>Tipo Documento</th>   
                                                        <th></th> 
                                                        <th></th> 
                                                        <th>Dias de retraso</th>                                      
                                                        <th>Estatus</th>          
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                               
                            </section>
                            <!--/ Basic table -->
                        </div>
                        <div class="col-lg-8 col-12" id="adelantos" style="display:none">
                            <input class="dataAdelantos" type="hidden" id="dataAdelantos" value="">
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="dataTablesAdelantos table" id="dataTablesAdelantos">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>                                                       
                                                        <th>Nº Adelanto</th>
                                                        <th>Saldo</th>                                                     
                                                        <th>Fecha Emisiòn</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                              
                            </section>
                        </div>
                        <!--/ Company Table Card -->
                    </div>   
                </section>

            </div>
        </div>
    </div>


                <div class="modal fade modalPagoFacturas" id="addNewAddressModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-4 mx-50">
                                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Reportar pago</h1>
                                <p class="address-subtitle text-center mb-2 pb-75 facturas_cliente"   id="facturas_cliente" ></p>
                                <form id="addNewAddressForm" class="row gy-1 gx-2" onsubmit="return false">
                                    <div class="col-12">
                                        <div class="row custom-options-checkable">
                                            <div class="col-md-12 mb-md-0 mb-2">
                                                <input class="custom-option-item-check" id="homeAddressRadio" type="radio" name="newAddress" value="HomeAddress" checked />
                                                <label for="homeAddressRadio" class="custom-option-item px-2 py-1">
                                                    <span class="d-flex align-items-center mb-50">
                                                        <i data-feather="file-text" class="font-medium-4 me-50"></i>
                                                        <span class="custom-option-item-title h4 fw-bolder mb-0 facturas_cancelar_text" id="facturas_cancelar_text" ></span>
                                                    </span>
                                                    <span class="d-block ">Documentos a procesar *</span>
                                                  <input type="hidden"  name="facturas_cancelar" id="facturas_cancelar" class="form-control facturas_cancelar" disabled />
                                                
                                                </label>
                                                <input type="text" class="form-control facturas_cancelar" id="facturas_cancelar" aria-label="facturas_cancelar" disabled />
                                                <input type="text" id="facturas_cliente_codigo" class="form-control facturas_cliente_codigo"  aria-label="facturas_cliente_codigo" disabled/>
                                                <input type="text" id="facturas_cliente_2" class="form-control facturas_cliente_2"  aria-label="facturas_cliente_2" disabled/>
                                                <input type="text" class="form-control facturas_saldo" id="facturas_saldo" aria-label="facturas_saldo" disabled>
                                                <input type="text" class="form-control facturas_saldo_bs" id="facturas_saldo_bs" aria-label="facturas_saldo_bs" disabled>
                                            </div>                                           
                                        </div>
                                    </div>                                   
                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-primary me-1 mt-2 gestionPagos">Gestionar pagos</button>                                        
                                    </div>                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade modalPagoAdelantos" id="modalPagoAdelantos" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-4 mx-50">
                                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Reportar adelanto</h1>
                                 <p class="address-subtitle text-center mb-2 pb-75 facturas_cliente_adelantos"   id="facturas_cliente_adelantos" ></p>

                                <form id="addNewAddressForm" class="row gy-1 gx-2" >                                   
                                    <input type="hidden" id="facturas_cliente_codigo" class="form-control facturas_cliente_codigo" />
                                    <input type="hidden" class="form-control facturas_cliente_adelantos2" id="facturas_cliente_adelantos2">              
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="modalAddressFirstName">Método de pago *</label>
                                            <select class="select2 form-select facturas_metodo" id="select2-basic-1"  aria-hidden="true">
                                                                <option value="NO">Seleccionar</option>
                                                                <option value="EF">EFECTIVO</option>
                                                                <option value="DEP">DEPOSITO</option>                                                           
                                                                <option value="CH">CHEQUE</option>                                          
                                            </select>
                                    </div>
                                    <div class="col-12 col-md-6 banco" id="banco" style="display:none">
                                        <label class="form-label" for="modalAddressLastName">Banco *</label>
                                       <select class="select2 form-select facturas_banco" id="facturas_banco"  aria-hidden="true">
                                            <option value="NO">Seleccionar</option>                                                                                               
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 cuenta" id="cuenta" style="display:none">
                                        <label class="form-label" for="modalAddressCountry">Cuenta *</label>
                                         <select class="select2 form-select facturas_cuenta" id="facturas_cuenta" disabled  aria-hidden="true">
                                            <option value="NO">Seleccionar</option>                                                                                              
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 referencia" id="referencia" style="display:none">
                                        <label class="form-label" for="modalAddressAddress1">Referencia *</label>
                                        <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_referencia"  aria-label="$12000" />
                                    </div>
                                    <div class="col-12 col-md-6 caja" id="caja" style="display:none">
                                        <label class="form-label" for="basic-icon-default-date">Caja *</label>                                               
                                            <select class="select2 form-select facturas_caja" id="facturas_caja"  aria-hidden="true">
                                                <option value="NO">Seleccionar</option>                                                                                                     
                                            </select>
                                                   
                                    </div>

                                     <div class="col-12 col-md-6 monto" id="monto" >
                                        <label class="form-label" for="basic-icon-default-date">Monto a cancelar *</label>                                               
                                        <input type="number" class="form-control facturas_monto"   id="facturas_monto" aria-label="facturas_monto" >
                                                   
                                    </div>

                                     <div class="col-12 col-md-6 fecha" id="fecha" >
                                        <label class="form-label" for="basic-icon-default-date">Fecha de pago *</label>                                               
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                   
                                    </div>
                                    <div class="col-12 col-md-6 fecha" id="fecha" >
                                        <label class="form-label" for="basic-icon-default-date">Foto *</label>                                               
                                        <input type="file"accept="image/png,image/jpeg" class="form-control facturas_documento" name="facturas_documento" id="facturas_documento">        
                                                   
                                    </div>

                                     <div class="col-12 col-md-6 fecha" id="fecha" >
                                        <label class="form-label" for="basic-icon-default-date">Observación *</label>                                               
                                          <textarea class="form-control facturas_observacion" rows="2" id="facturas_observacion" name="facturas_observacion"></textarea>   
                                                   
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-primary me-1 mt-2 btnPagarAdelanto">Guardar</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                            Cerrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>