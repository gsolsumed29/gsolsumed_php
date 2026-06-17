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
                                    <h5 class="card-title">Verificar</h5>
                                    <p class="card-text">Chequear los items de una factura</p>

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


                    <div class="col-xl-4 col-md-6 col-sm-12 indicadorResumenFacturacion">
                        <!-- Contenedor principal de la tarjeta de comparación -->
                           <div class="card">
                            <div class="card-body">
                                <!-- Título mejorado con icono -->
                                <h4 class="card-title-custom">                                 
                                    Resumen de Facturación
                                </h4>
                                
                                <!-- Contenedor para los dos montos principales -->
                                <div class="metrics-container">
                                    <!-- Monto 1 (Emitidas) -->
                                    <div class="metric">
                                        <p class="metric-label">Emitidas</p>
                                        <h3 class="metric-value" id="facturas-emitidas">0</h3>
                                    </div>
                                    
                                    <!-- Monto 2 (Verificadas) -->
                                    <div class="metric">
                                        <p class="metric-label">Verificadas</p>
                                        <h3 class="metric-value" id="facturas-verificadas">0</h3>
                                    </div>

                                </div>

                                <!-- Separador sutil -->
                                <div class="comparison-divider"></div>

                                <!-- Sección de resultados de la comparación -->
                                <div class="comparison-result text-center" id="resultado-comparacion">
                                    <div class="comparison-trend ">
                                        <span class="comparison-icon"></span>
                                        <span class="comparison-percentage">0%</span>
                                    </div>
                                    <p class="comparison-text">Calculando...</p>
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
    <input class="dataFacturasDespacho" type="hidden" id="dataFacturasDespacho" value="">
<div class="modal fade" id="modalBuscarFactura_seleccionada" tabindex="-1" aria-labelledby="pricingModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <h5 class="modal-title" id="pricingModalTitle">
                    
                </h5>
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
                                   