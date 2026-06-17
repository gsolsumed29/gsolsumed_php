  <!-- BEGIN: Content-->
    <div class="app-content content m_dashboard ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard">
                    <div class="row match-height">
                
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                      <i data-feather="package" class="font-large-2 mb-1"></i>
                                    <h5 class="card-title">Despachar</h5>
                                    <p class="card-text">Dar salida a una factura con sus items</p>

                                    <!-- modal trigger button -->
                                    <button type="button" class="btn btn-primary waves-effect waves-float waves-light" id="btnBuscarFactura_seleccionada">
                                       <i data-feather='search'></i>  Seleccionar
                                    </button>
                                </div>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                       <i data-feather="printer" class="font-large-2 mb-1"></i>
                                         <h5 class="card-title">Etiquetar</h5>
                                    <p class="card-text">Imprimir etiquetas con codigo QR</p>
                                    <!-- modal trigger button -->
                                    <a type="button" class="btn btn-primary waves-effect waves-float waves-light" id="linkEmpaquetado" href="index.php?view=empaquetado">
                                       <i data-feather='search'></i>  Seleccionar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                       <i data-feather="truck" class="font-large-2 mb-1"></i>
                                         <h5 class="card-title">Embarcar</h5>
                                    <p class="card-text">Asignar vehiculo al lote</p>
                                    <!-- modal trigger button -->
                                    <a type="button" class="btn btn-primary waves-effect waves-float waves-light" id="linkEmpaquetado" href="index.php?view=embarco">
                                       <i data-feather='search'></i>  Seleccionar
                                    </a>
                                </div>
                            </div>
                        </div>
                     
                        
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    <input class="dataFacturasDespacho" type="hidden" id="dataFacturasDespacho" value="">
         <div class="modal fade" id="modalBuscarFactura_seleccionada" tabindex="-1" aria-labelledby="pricingModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                               
                      
                            <!-- Basic table -->
                        
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="datatables-basic-caducidad table dataTablesFacturasDespachar" id="dataTablesFacturasDespachar">
                                                <thead>
                                                    <tr>
                                                        <th></th>          <th></th>                       <th></th>                                                  
                                                                                   
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal to add new record -->
                              
                      
                            </div>
                        </div>
                    </div>
                </div>

                                    <!--        <div class="modal text-start"  id="modalBuscarFactura" tabindex="-1" aria-labelledby="myModalLabel6" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="padding: 0.8rem 0.8rem;">
                                                            <h4 class="modal-title" id="myModalLabel6">Datos de la factura</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">                                                          

                                                                <label>Numero de control: </label>
                                                                <div class="mb-1">
                                                                    <input type="text" id="inputCodigoFactura" placeholder="0022790" class="form-control inputCodigoFactura"  />
                                                                </div>
                                                           
                                                        </div>
                                                        <div class="modal-footer"> 
                                                            <button type="button" class="btn btn-primary btnBuscarFactura" id ="btnBuscarFactura">  <i data-feather='search'></i>  Buscar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> ->