  <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <input type="hidden" id="dataCobrosMes" class="dataCobrosMes" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            <div class="card-header border-bottom">
                                    <h4 class="card-title">Cobros del Mes</h4>
                                </div>
                                <table class="datatables-basic-cobros-mes table">
                                    <thead>
                                        <tr>
                                           
                                            <th></th> 
                                            <th>Fecha</th>
                                            <th>Total Neto</th>                                           
                                           
                                          
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                            <!-- Modal to add new record    -->
                                <div class="modal modal-slide-in fade" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                             

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataCobrosMes me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade" id="filtroArticulosFoco">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                               
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioMasVendidos" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalMasVendidos" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataArticuloFoco me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade" id="filtroArticulosVolumen">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                               
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioMasVolumen" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalMasVolumen" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataArticuloVolumen me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                             

                                <div class="modal modal-slide-in fade" id="filtroClientesAltos">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                           

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioClientesAltos" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalClientesAltos" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataClientesAltos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        
                                <div class="modal modal-slide-in fade" id="filtroClientesBajos">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                            
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioClientesBajos" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalClientesBajos" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataClientesBajos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        
        
        
                <section id="dashboard-ecommerce">
                   
                    <div class="row match-height">
                            <input type="hidden" id="dataMeses" class="dataMeses" value=''>
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">Top 5 Clientes mas pagos </h4>
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroClientesAltos"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                            </div>
                                            <div class="card-body tablaTopMasPagos">
                                            
                                            
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">Top 5 Clientes con menos pagos</h4>
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroClientesBajos"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                            </div>
                                            <div class="card-body tablaTopMenosPagos">
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                           
                                  
                    </div>
                </section>

                 <!-- Dashboard Ecommerce Starts -->
                 <input type="hidden" id="dataArticulosFoco" class="dataArticulosFoco" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            <div class="card-header border-bottom">
                                    <h4 class="card-title">Articulos en Foco</h4>
                                    <div class="d-flex align-items-center">
                                    <h4 class="card-title">Total :</4>
                                    <h4 class="card-title totalFoco"></4>
                                    </div>
                                </div>
                                <table class="datatables-basic-articulo-foco table">
                                    <thead>
                                        <tr>
                                           
                                            <th></th> 
                                            <th>Producto</th>
                                            <th>Meta</th>                                           
                                            <th>Total Vendido</th>           
                                            <th>Alcanzado (%)</th>         
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!-- Dashboard Ecommerce ends -->

                   <!-- Dashboard Ecommerce Starts -->
                   <input type="hidden" id="dataArticulosVolumen" class="dataArticulosVolumen" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            <div class="card-header border-bottom">
                                    <h4 class="card-title">Articulos en Volumen</h4>
                                    <div class="d-flex align-items-center">
                                    <h4 class="card-title">Total :</4>
                                    <h4 class="card-title totalVolumen"></4>
                                    </div>
                                </div>
                                <table class="datatables-basic-articulo-volumen table">
                                    <thead>
                                        <tr>
                                           
                                            <th></th> 
                                            <th>Producto</th>
                                            <th>Meta</th>                                           
                                            <th>Total Vendido</th>           
                                            <th>Alcanzado (%)</th>         
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!-- Dashboard Ecommerce ends -->


            </div>
        </div>
    </div>
    <!-- END: Content-->