<!-- BEGIN: Content-->
<div class="app-content content i_dashboard_almacen">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard content -->
            <div class="row match-height">
                <!-- Filtros responsivos -->
                <div class="col-12 mb-2">
                    <div class="card dashboard-responsive-card">
                        <div class="card-body">
                            <h5 class="card-title">Filtros</h5>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 mb-1">
                                    <label for="yearSelect" class="form-label">Año:</label>
                                    <select class="form-select" id="yearSelect">                                 
                                        <option value="2026" selected>2026</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 mb-1">
                                    <label for="monthSelect" class="form-label">Mes:</label>
                                    <select class="form-select" id="monthSelect">
                                     
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Tarjeta 1: Cantidad de facturas recibidas -->
              <!-- Tarjeta 1: Cantidad de facturas recibidas -->
            <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                <div class="card dashboard-stat-card bg-primary indicadorResumenFacturacion_analisis">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-file-invoice text-primary" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h5 class="card-title text-white mb-0">Verificaciones</h5>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasComparacion">Período: </p>
                            </div>
                        
                            <div id="resultado-comparacion" class="comparison-result  rounded text-center">
                                <div class="comparison-icon mb-1 d-none"></div>
                                <div class="comparison-percentage fw-bold">0%</div>
                            <div class="comparison-text small">Sin datos</div>
                        </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-white">Facturas Emitidas: <span class="fw-bold" id="facturas-emitidas">0</span></span>
                            <span class="text-white">Facturas Verificadas: <span class="fw-bold" id="facturas-verificadas">0</span></span>
                        </div>
                        
                        <!-- Movido al final de la tarjeta -->
                     
                    </div>
                </div>
            </div>

              
                <!-- Tarjeta 3: Cantidad de facturas por contener -->
                <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-box text-warning" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-white mb-0">Despachos por interno</h5>
                                    <p class="dashboard-stat-number text-white mb-1" id="despachos-bulto-interno">0</p>  
                                </div>
                            </div>
                             
                            <p class="dashboard-stat-number text-white mb-1" id="despachos-transporte-interno">0</p>  
                              <p class="dashboard-stat-title text-white-50 mb-0" id="periodoDespachosInternos">Período: </p>                         
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 4: Cantidad de facturas por despachar -->
                <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-truck-loading text-info" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-white mb-0">Despachos por externo</h5>
                                    <p class="dashboard-stat-number text-white mb-1" id="despachos-bulto-externo">0</p>  
                                
                                </div>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="despachos-transporte-externo">0</p>
                              <p class="dashboard-stat-title text-white-50 mb-0" id="periodoDespachosExternos">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 5: Cantidad de facturas despachadas -->
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-shipping-fast text-success" style="font-size: 24px;"></i>
                                </div>
                                <h5 class="card-title text-white mb-0">Facturas Despachadas</h5>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="facturas-despachadas">0</p>
                            <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasDespachadas">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 6: Cantidad de facturas anuladas -->
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3 d-none">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-times-circle text-danger" style="font-size: 24px;"></i>
                                </div>
                                <h5 class="card-title text-white mb-0">Facturas Anuladas</h5>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="facturas-anuladas">0</p>
                            <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasAnuladas">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 7: Cantidad de envíos/órdenes de despacho -->
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3 d-none">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-clipboard-list text-primary" style="font-size: 24px;"></i>
                                </div>
                                <h5 class="card-title text-white mb-0">Órdenes de Despacho</h5>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="ordenes-despacho">0</p>
                            <p class="dashboard-stat-title text-white-50 mb-0" id="periodoOrdenesDespacho">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 8: Cantidad de envíos despachados -->
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3 d-none">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-check-circle text-success" style="font-size: 24px;"></i>
                                </div>
                                <h5 class="card-title text-white mb-0">Envíos Despachados</h5>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="envios-despachados">0</p>
                            <p class="dashboard-stat-title text-white-50 mb-0" id="periodoEnviosDespachados">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 9: Cantidad de envíos por despachar -->
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3 d-none">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock text-warning" style="font-size: 24px;"></i>
                                </div>
                                <h5 class="card-title text-white mb-0">Envíos por Despachar</h5>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="envios-por-despachar">0</p>
                            <p class="dashboard-stat-title text-white-50 mb-0" id="periodoEnviosPorDespachar">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 10: Cantidad de envíos anulados -->
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3 d-none">
                    <div class="card dashboard-stat-card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-ban text-danger" style="font-size: 24px;"></i>
                                </div>
                                <h5 class="card-title text-white mb-0">Envíos Anulados</h5>
                            </div>
                            <p class="dashboard-stat-number text-white mb-1" id="envios-anulados">0</p>
                            <p class="dashboard-stat-title text-white-50 mb-0" id="periodoEnviosAnulados">Período: </p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Progreso de Facturas -->
                <div class="col-xl-6 col-lg-12 d-none">
                    <div class="card dashboard-responsive-card" id="cardTablaInterna">
                        <div class="card-body">
                            <h5 class="card-title">Viajes por vehiculo</h5>
                            <div class="dashboard-chart-container">
                                <canvas id="progresoFacturasChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- Tabla de Detalles -->
                <div class="col-xl-12 col-lg-12 ">
                    <div class="card dashboard-responsive-card">
                        <div class="card-body">
                            <h5 class="card-title">Viajes por Vehiculo (Transporte interno)</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Vehiculo</th>
                                            <th>Cantidad de viajes</th>
                                            <th>Cantidad bultos</th>
                                            <th>Contribución %</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaDetalles">
                                        <!-- Los datos se cargarán dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ================================================================= -->
                <!-- NUEVA TABLA: Viajes por Vehiculo (Transporte externo) -->
                <!-- ================================================================= -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card dashboard-responsive-card" id="cardTablaExterna">
                        <div class="card-body">
                            <h5 class="card-title">Viajes por Vehiculo (Transporte externo)</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Vehiculo</th>
                                            <th>Cantidad de viajes</th>
                                            <th>Cantidad bultos</th>
                                            <th>Contribución %</th>
                                        </tr>
                                    </thead>
                                    <!-- IMPORTANTE: Usamos un ID diferente -->
                                    <tbody id="tablaDetallesExterno">
                                        <!-- Los datos se cargarán dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<!-- Indicador de carga -->
<div id="loadingIndicator" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.3);">
    <div class="text-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
        <p class="mt-2">Cargando datos...</p>
    </div>
</div>