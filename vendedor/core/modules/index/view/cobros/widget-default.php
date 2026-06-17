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
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"></span> Cobranzas
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="content-body">             
                <section id="">
                    <div class="row match-height">
                    
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12" id="cobros">
                            <input class="dataFacturas" type="hidden" id="dataFacturas" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="dataTablesFacturas table" id="dataTablesFacturas">
                                                <thead class="table-bialy">
                                                    <tr> 
                                                        <th></th>     
                                                        <th></th>
                                                        <th></th>                                                       
                                                        <th></th>
                                                        <th></th>                                                     
                                                        <th></th>                                                    
                                                        <th></th>   
                                                        <th></th> 
                                                        <th></th> 
                                                        <th></th>                                      
                                                        <th></th>   
                                                        <th></th>     
                                                        <th></th>   
                                                        <th></th>    
                                                        <th></th> 
                                                        <th></th> 
                                                        <th></th>       
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                               
                            </section>
                            <!--/ Basic table -->
                        </div>
                    
                    </div>   
                </section>

            </div>
        </div>
    </div>

                                <div class="modal modal-slide-in fade FiltroBuscarFacturas" id="FiltroBuscarFacturas">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">    
                                                
                                               <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Cliente </label>
                                                        <select class="select2 form-select comboClientesFactura" id="co_clients">
                                                            <option value="0" selected>Seleccione cliente</option>
                                                        </select>
                                                </div>

                                                <div class="mb-1">
                                                <!--
                                                    ('N/CR', 'N/DB', 'RET_IVA', 'FACT')

                                                    04122025
                                                --> 
                                                    <label class="form-label" for="basic-icon-default-date">Tipo de documento</label>
                                                        <select class="select2 form-select tipo_documento" id="tipo_documento">
                                                            <option value="NO" selected disabled>Seleccione documento</option>
                                                            <option value="NO">TODOS</option>
                                                            <option value="N/CR" >N/CR</option>
                                                            <option value="ADEL" >ADEL</option>
                                                            <option value="N/DB" >N/DB</option>
                                                            <option value="RET_IVA" >RET_IVA</option>
                                                            <option value="FACT" >FACT</option>
                                                        </select>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                                </div>

                              
                                                <button type="button" class="btn btn-relief-primary btnConsultarClientes me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                <div class="modal fade modalPagoAdelantos" id="modalPagoAdelantos" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                           
                            <div class="modal-body pb-5 px-sm-4 mx-50">
                                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Reportar adelanto</h1>
                                 <p class="address-subtitle text-center mb-2 pb-75 facturas_cliente_adelantos"   id="facturas_cliente_adelantos" ></p>

                                <form id="addNewAddressForm" class="row gy-1 gx-2" >                                   
                                 
                                   <div class="col-12 col-md-6">
                                     <label class="form-label" for="modalAddressFirstName">Cliente *</label>
                                        <select class="select2 form-select comboClientesFacturaAdelantar" id="select2-basic-comboClientesFacturaAdelantar">
                                            <option value="" selected>Seleccione cliente</option>
                                        </select>
                                    </div> 
                                      
                                     <div class="col-12 col-md-6 fecha" id="fecha" >
                                        <label class="form-label" for="basic-icon-default-date">Fecha de pago *</label>                                               
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                   
                                    </div>          
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
                                            <select class="select2 form-select facturas_caja" id="facturas_caja"  name = "facturas_caja" aria-hidden="true">
                                                <option value="NO">Seleccionar</option>                                                                                                     
                                            </select>                                                   
                                    </div>


                                     <div class="col-12 col-md-6 monto montoAbonoBs" id="monto" style="display:none" >
                                        <label class="form-label" for="pesos">Monto abono Bolívares (BS.D) *</label>
                                        <input class="form-control facturas_monto_bs money-bs" type="text" id="pesos" placeholder="Ingrese cantidad en BS.D">
                                    </div>
                                     <div class="col-12 col-md-6 monto montoAbonoUSD" id="monto" style="display:none" >
                                        <label class="form-label" for="dollars">Monto abono Dólares (USD) *</label>
                                        <input class="form-control facturas_monto money-usd" type="text" id="dollars" placeholder="Ingrese cantidad en $">
                                    </div>


                                       <div class="col-12 col-md-6 monto d-none" id="monto">
                                        <label class="form-label" for="basic-icon-default-date">Deuda en BS.D *</label>       
                                        <input class="form-control monto_calculado_bs" id="monto_calculado_bs" type="text" value="" disabled>            
                                    </div>
                                    
                                    <div class="col-12 col-md-6 monto d-none" id="monto">
                                        <label class="form-label" for="basic-icon-default-date">Deuda en USD *</label>       
                                        <input class="form-control monto_calculado" id="monto_calculado" data-saldo="" type="text" value="" disabled>            
                                    </div>              

                                    <div class="col-12 col-md-12 fecha" id="fecha">

                                        <div class="upload-container" id="drop-zone">
                                                <p>Arrastra una o más imágenes aquí o haz clic para seleccionar</p>
                                                <label for="file-input" class="upload-btn">Seleccionar imágenes</label>
                                                <input type="file" id="file-input" class="facturas_documento" name="facturas_documento" accept="image/*" multiple>
                                            </div>
                                            
                                            <div class="selected-images" id="selected-images-container">
                                                <!-- Las imágenes seleccionadas aparecerán aquí -->
                                            </div>
                                        
                                            
                                    </div>
                                     <div class="col-12 col-md-12 fecha" id="fecha" >
                                        <label class="form-label" for="basic-icon-default-date">Observación *</label>                                               
                                          <textarea class="form-control facturas_observacion" rows="2" id="facturas_observacion" name="facturas_observacion"></textarea>   
                                                   
                                    </div>
                                    <div class="col-12 text-center">
                                         

                                        <button type="button" class="btn btn-primary me-1  mt-2  btnPagarAdelanto"><i data-feather='save'></i> Guardar</button>
                                        <button type="reset" class="btn btn-outline-secondary  mt-2  " data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather='x-circle'></i>  Cerrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                 <div class="modal fade modalAgenteRetencion" id="modalAgenteRetencion" tabindex="-1" aria-labelledby="addNewCardTitle" data-bs-backdrop="false" aria-hidden="true" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <h4 class="text-center mb-1" id="addNewCardTitle">Retención</h4>                            

                                <!-- form -->
                                <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                                    <div class="col-12">                                              
                                        <div class="table-responsive ">
                                            <table class="table table-bordered table-hover tablaRetenciones">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Documento</th>
                                                        <th>N° de Retencion</th>                                                        
                                                        <th>Monto Retención (BS.D)</th>
                                                        <th>Fecha Retención</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tablaRetencion" id="tablaRetencion">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-primary me-1 mt-1" id='procesarRetencionesBtn'>Siguiente</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalRetencionSinDeposito" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered  modal-lg">
                    <div class="modal-content">
                    <div class="modal-header" style="padding: 0.8rem 0.8rem;">
                        <h5 class="modal-title">Registrar Retención sin Depósito</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="contenidoRetencionSinDeposito"></div>
                            <div class="col-12 col-md-12 fecha" id="fecha">
                                 <input type="file" class="form-control facturas_documento_sd" accept=".pdf,.jpg,.jpeg,.png">
                               <!-- <input type="file" id="file-input-sd" class="file-input-sd facturas_documento_sd"  accept=".jpg,.jpeg,.png,.gif,.pdf" multiple> -->
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Cerrar
                        </button>
                        <button type="button" class="btn btn-primary" id="procesarRetencionSinDepositoBtn">
                        Procesar Retención
                        </button>
                    </div>
                    </div>
                </div>
                </div>