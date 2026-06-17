
    <!-- BEGIN: Content-->
    <div class="app-content content i_dashboard">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard content -->
                <div class="row match-height">
                
                    <div class="col-12 mb-2">
                        <div class="card dashboard-responsive-card">
                            <div class="card-body">
                                <h5 class="card-title">Filtros</h5>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label for="startDateSelect" class="form-label">Fecha Inicio:</label>
                                        <input type="date" class="form-control flatpickr-basic" id="startDateSelect" value="<?php echo date('Y-m-01'); ?>">
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label for="endDateSelect" class="form-label">Fecha Fin:</label>
                                        <input type="date" class="form-control flatpickr-basic" id="endDateSelect" value="<?php echo date('Y-m-t'); ?>">
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label for="vendedorSelect" class="form-label">Vendedor:</label>
                                        <select class="form-select" id="vendedorSelect">
                                            <option value="all" selected>Todos los vendedores</option>
                                            <!-- Los vendedores se cargarán dinámicamente -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Versión con mismo color para todas -->
                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/1.webp" class="rounded" height="40" alt="facturación" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Monto Facturado</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="montoFacturado">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturado">Período: </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/3.webp" class="rounded" height="40" alt="cobranza" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Cobranzas del Mes</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="cobranzasMes">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoCobranzas">Período: </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/2.webp" class="rounded" height="40" alt="clientes atendidos" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Clientes activos</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="clientesActivos">0</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoClientes">Período: </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/4.webp" class="rounded" height="40" alt="clientes nuevos" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Clientes nuevos</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="clientesNuevos">0</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoClientesNuevos">Período: </p>
                            </div>
                        </div>
                    </div>
                    <!-- Gráficos -->
                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/1.webp" class="rounded" height="40" alt="facturación" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Cálculo implícito</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="calculoImplicito">0.00</p>
                               
                            </div>
                        </div>
                    </div>

                    <!-- Agregar estos dos cards después de los existentes, antes de los gráficos -->

                   

                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/4.webp" class="rounded" height="40" alt="cuentas por cobrar" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Cuentas por Cobrar</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="cuentasPorCobrar">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoCuentasPorCobrar">Período: </p>
                            </div>
                        </div>
                    </div>

                                        <!-- Agregar estos 3 cards después de los existentes -->
                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/4.webp" class="rounded" height="40" alt="facturas por vencer" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Facturas por Vencer</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="facturasPorVencer">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasPorVencer">Período: </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/4.webp" class="rounded" height="40" alt="facturas vencidas 0-15 dias" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Vencidas 0-15 días</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="facturasVencidas0a15">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasVencidas0a15">Período: </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/4.webp" class="rounded" height="40" alt="facturas vencidas 16-30 dias" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Vencidas 16-30 días</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="facturasVencidas16a30">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasVencidas16a30">Período: </p>
                            </div>
                        </div>
                    </div>
                     <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                        <div class="card dashboard-stat-card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="../../../app-assets/images/icons/4.webp" class="rounded" height="40" alt="facturas vencidas 31 mas" />
                                    </div>
                                    <h5 class="card-title text-white mb-0">Vencidas 31 o más</h5>
                                </div>
                                <p class="dashboard-stat-number text-white mb-1" id="facturasVencidas31mas">$0.00</p>
                                <p class="dashboard-stat-title text-white-50 mb-0" id="periodoFacturasVencidas31mas">Período: </p>
                            </div>
                        </div>
                    </div>
             
                    <div class="col-xl-12 col-lg-12">
                        <div class="card dashboard-responsive-card">
                            <div class="card-body">
                                <h5 class="card-title">Top 5 Productos Más Facturados (Otras marcas)</h5>
                                <div class="dashboard-chart-container">
                                    <canvas id="topProductosChart"></canvas>
                                </div>
                                 <div class="table-responsive">
                                    <table class="table table-sm" id="leyendaProductos">
                                       
                                        <tbody>
                                            <!-- La leyenda se llenará dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12">
                        <div class="card dashboard-responsive-card">
                            <div class="card-body">
                                <h5 class="card-title">Top 5 Productos Más Facturados (Bialy)</h5>
                                <div class="dashboard-chart-container">
                                    <canvas id="topProductosChartBialy"></canvas>
                                </div>
                                    <table class="table table-sm" id="leyendaProductosBialy">
                       
                                    <tbody>
                                        <!-- La leyenda se llenará dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de detalles -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card dashboard-responsive-card">
                            <div class="card-body">
                                <h5 class="card-title">Detalles por Vendedor</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Vendedor</th>
                                                <th>Monto Facturado</th>
                                                <th>Cobranzas del Mes</th>
                                                <th>Porcentaje de Cobranza</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaVendedores">
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


    <!-- En tu HTML, agrega esto -->
<div id="loadingIndicator" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.3);">
    <div class="text-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
        <p class="mt-2">Cargando datos...</p>
    </div>
</div>