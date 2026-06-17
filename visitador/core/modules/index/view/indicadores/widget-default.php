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
                <input type="hidden" id="dataVentasxDia" class="dataVentasxDia" value=''>
                <!-- Basic table -->
              
                <section id="indicadores">
                    <div class="row match-height">
                
                                <div class="modal modal-slide-in fade" id="filtroVentasMes">
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

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataVentasPorDia me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade" id="filtroMasVendidos">
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

                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataMasVendidos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade" id="filtroMenosVendidos">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                             

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioMenosVendidos" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalMenosVendidos" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataMenosVendidos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade" id="filtroMayorUtilidad">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                            
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioMayorUtilidad" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalMayorUtilidad" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataMayorUtilidad me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade" id="filtroMenorUtilidad">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                            
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioMenorUtilidad" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalMenorUtilidad" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataMenorUtilidad me-1"> <i data-feather='search'></i> Consultar</button>
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

                                <div class="modal modal-slide-in fade" id="filtroClientesFacturados">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                         

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Zona</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                    <select class="select2  form-select border-0 shadow-none bg-transparent pe-0 comboZonaClientesFacturados">   
                                                    <option value="NO">Todas</option>                                        
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicioClientesFacturados" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinalClientesFacturados" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                             

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDataClientesFacturados me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        <!-- Goal Overview Card -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Activaciones del Mes</h4>
                                    <!--<button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroClientesFacturados"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>-->
                                    <input type="hidden" id="dataNoFacturados" class="dataNoFacturados" value=''>
                                </div>
                                <div class="card-body p-0">
                                    <div id="goal-overview-radial-bar-chart" class="my-2"></div>
                                    <div class="row border-top text-center mx-0">
                                        <div class="col-6 border-end py-1">
                                            <p class="card-text text-info mb-0">Total Clientes</p>
                                            <h3 class="fw-bolder mb-0 text-info totalClientes"></h3>
                                        </div>
                                        <div class="col-6 py-1">
                                            <p class="card-text text-success mb-0">Clientes Facturados</p>
                                            <h3 class="fw-bolder mb-0 text-success clientesFacturados"></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 noFacturadosTable">
                            <div class="card">
                                <table class="datatables-basic-clientes table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>   
                                            <th>Codigo</th>                                        
                                            <th>Nombre</th>
                                            <th>Fecha ultima</th>                                                                                                                                 
                                            <th>Dias</th>       
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <section id="basic-datatable">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <table class="datatablesVentasDia table">
                                            <thead>
                                                <tr>
                                                
                                                    <th></th>
                                                    <th>Fecha</th>
                                                    <th>Total Neto</th>                                           
                                                    <th>Costo</th>
                                                    <th>Kilos</th>                                        
                                                    <th>Utilidad(%)</th>  
                                                
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>                  
                        </section>
                        <div class="row match-height">
                            <input type="hidden" id="dataMeses" class="dataMeses" value=''>
                                    <!-- mas vendido -->
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">MÁS VENDIDOS (TOP 5) </h4>
                                            
                                            </div>
                                            <div class="card-body tablaTopVendidos">
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                                           
                                    <div class="col-lg-9 col-md-8 col-12 ">
                                        <div class="card card-browser-states">
                                            <div class="card-header">
                                                <div>
                                                    <h4 class="card-title">TOP 5 PRODUCTOS MAS VENDIDOS</h4>
                                                    <p class="card-text font-small-2">Top 5 en el perÍodo</p>
                                                </div>
                                                <div class="dropdown chart-dropdown">
                                                
                                            
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroMasVendidos"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                            <!--<input type="text" id="fp-range" class="form-control flatpickr-range border-0 shadow-none 
                                            bg-transparent pe-0 filtrarTopVendidos" placeholder="Seleccione rango" />-->
                                                </div>
                                            </div>
                                            <div class="card-body topMeses">
                                                <div class="topMes">
                                                    
                                                </div>
                                            <div class="chartdiv_top" id="chartdiv_Top"></div>
                                            </div>
                                        </div>
                     
                                    </div>
                                    <!-- mas vendido -->
                                    <!-- MENOS VENDIDO -->
                                    <div class="col-lg-3 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">MENOS VENDIDOS (TOP 5) </h4>
                                            
                                            </div>
                                            <div class="card-body tablaTopMenosVendidos">                                           
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-md-12 col-12 ">
                                        <div class="card card-browser-states">
                                            <div class="card-header">
                                                <div>
                                                    <h4 class="card-title">TOP 5 PRODUCTOS MENOS VENDIDOS</h4>
                                                    <p class="card-text font-small-2">Top 5 en el perÍodo</p>
                                                </div>
                                                <div class="dropdown chart-dropdown">
                                                
                                                
                                        
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroMenosVendidos"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                                </div>
                                            </div>
                                            <div class="card-body topMenosMeses">
                                                <div class="topMesUnidadesMenos">
                                                    
                                                </div>
                                            <div class="chartdiv_Top_Menos_unidades" id="chartdiv_Top_Menos_unidades"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- MENOS VENDIDO -->
                                    <!-- MAYOR UTILIDAD  -->                          
                                    <div class="col-lg-3 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">MAYOR UTILIDAD (TOP 5) </h4>
                                            
                                            </div>
                                            <div class="card-body tablaTopMayorUtil">
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-9 col-md-12 col-12 ">
                                        <div class="card card-browser-states">
                                            <div class="card-header">
                                                <div>
                                                    <h4 class="card-title">TOP 5 PRODUCTOS CON MAYOR UTILIDAD </h4>
                                                    <p class="card-text font-small-2">Top 5 en el perÍodo</p>
                                                </div>
                                                <div class="dropdown chart-dropdown">
                                                
                                            
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroMayorUtilidad"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                           
                                                </div>
                                            </div>
                                            <div class="card-body topMayorUtil">
                                                <div class="topMayorUtilidad">
                                                    
                                                </div>
                                            <div class="chartdiv_Top_Mayor_Util" id="chartdiv_Top_Mayor_Util"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- MAYOR UTILIDAD  -->    
                                     <!-- MENOR UTILIDAD  -->                          
                                    <div class="col-lg-3 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">MENOR UTILIDAD (TOP 5) </h4>
                                            
                                            </div>
                                            <div class="card-body tablaTopMenorUtil">
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-9 col-md-12 col-12 ">
                                        <div class="card card-browser-states">
                                            <div class="card-header">
                                                <div>
                                                    <h4 class="card-title">TOP 5 PRODUCTOS CON MENOR UTILIDAD </h4>
                                                    <p class="card-text font-small-2">Top 5 en el perÍodo</p>
                                                </div>
                                                <div class="dropdown chart-dropdown">
                                                
                                            
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroMenorUtilidad"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                           
                                                </div>
                                            </div>
                                            <div class="card-body topMenorUtil">
                                                <div class="topMenorUtilidad">
                                                    
                                                </div>
                                            <div class="chartdiv_Top_Menor_Util" id="chartdiv_Top_Menor_Util"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">TOP 5 CLIENTES CON MAYOR RENTABILIDAD </h4>
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroClientesAltos"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                            </div>
                                            <div class="card-body tablaTopMasClientes">
                                            
                                            
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="card card-transaction">
                                            <div class="card-header">
                                                <h4 class="card-title">TOP 5 CLIENTES CON MENOR RENTABILIDAD </h4>
                                                <button class="dt-button  btn btn-relief-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#filtroClientesBajos"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-50 font-small-4"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Buscar</span></button>
                                            </div>
                                            <div class="card-body tablaTopMenosClientes">
                                            
                                            
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