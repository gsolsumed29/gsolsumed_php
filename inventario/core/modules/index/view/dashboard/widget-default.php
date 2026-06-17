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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package font-large-2 mb-1"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    <h5 class="card-title">Verificar</h5>
                                    <p class="card-text">Chequear los items de una factura</p>

                                    <!-- modal trigger button -->
                                    <button type="button" class="btn btn-primary waves-effect waves-float waves-light" id="btnBuscarFactura_seleccionada">
                                       <i data-feather='search'></i>  Seleccionar
                                    </button>
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
              <!-- Modal para buscar y seleccionar facturas -->
<div class="modal fade" id="modalBuscarFactura_seleccionada" tabindex="-1" aria-labelledby="pricingModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <h5 class="modal-title" id="pricingModalTitle">Buscar Facturas para Despachar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">

                <!-- =================================== -->
                <!-- SECCIÓN DE FILTRO AÑADIDA -->
                <!-- =================================== -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label for="mesFiltro" class="form-label">Seleccionar Mes:</label>
                                <select class="form-select" id="mesFiltro">
                                    <option value="no" selected>Mes Actual</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary w-100" id="btnBuscarPorMes">
                                    <i class="bi bi-search"></i> Buscar Facturas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- =================================== -->
                <!-- FIN DE LA SECCIÓN DE FILTRO -->
                <!-- =================================== -->

                <!-- Tabla de resultados -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="datatables-basic-caducidad table dataTablesFacturasDespachar" id="dataTablesFacturasDespachar">
                                <thead>
                                    <tr>
                                        <th>N° Factura</th>
                                        <th>Fecha Emisión</th>
                                        <th>Acciones</th> <!-- Asumí que querrás una columna de acciones -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas se cargarán aquí con JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>