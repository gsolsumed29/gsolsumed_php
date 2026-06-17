  <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
               
                      <div class="modal modal-slide-in fade" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">     

                                            <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Vendedor</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                    <select class="select2  form-select border-0 shadow-none bg-transparent pe-0 comboVendedores" id="select2-basic">   
                                                    <option value="NO">Todos</option>                                        
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Estatus del documento</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select status" id="status"  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                            <option value="0">Sin procesar</option>
                                                            <option value="1">Parcialmente Procesado</option>                                                           
                                                            <option value="2">Procesado</option>                                          
                                                        </select>
                                                    </div>
                                                </div>
                                               
                                              
                                                <div class="mb-4">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Pago</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-range rango" placeholder="Seleccione Rango" />
                                                </div>
                                               
                                               
                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarPedidos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        
                <section id="dashboard-ecommerce">
                   
                    <div class="row match-height">
                            <input type="hidden" id="dataMeses" class="dataMeses" value=''>
                          

                          
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                                                <div class="header-center">
                                                    <h4 class="card-title">TOTAL VENTAS USD($) EN EL PERIODO</h4>
                                                
                                                </div>
                                            
                                                <div class="header-right d-flex align-items-center mt-sm-0 mt-1">
                                            
                                                
                                                </div>
                                            </div>
                                            <div class="card-body">
                                            <div class="chartdiv_dashboard chartdiv_dashboard_1" id="graficoXA"></div>
                                        
                                            </div>
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