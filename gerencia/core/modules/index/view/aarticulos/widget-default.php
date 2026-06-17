<!-- BEGIN: Content-->
<div class="app-content content i_articulo_ficha_analisis_ventas">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0" id="product-title">Analisis de activación</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="#">Articulos</a></li>
                                <li class="breadcrumb-item active">Activaciones</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>
        
        <div class="content-body">
            <!-- Dashboard de Análisis de Ventas -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Análisis de Ventas por Producto</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                               
                                <section class="filters-section mb-3">
                                    <div class="row">
                                        <div class="col-md-3 mb-1">
                                            <div class="form-group">
                                                <label for="analisis-productFilter" class="form-label">Producto</label>
                                                <select class="form-select" id="analisis-productFilter">
                                                    <option value="all">Todos los productos</option>
                                                    <!-- Las opciones se cargarán dinámicamente -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-1">
                                            <div class="form-group">
                                                <label for="analisis-monthFilter" class="form-label">Mes</label>
                                                <select class="form-select" id="analisis-monthFilter">
                                                    <option value="all">Todos los meses</option>
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
                                            </div> <!-- ¡ESTE ERA EL DIV QUE FALTABA! -->
                                        </div> <!-- También cierro este div -->
                                        <div class="col-md-3 mb-1">
                                            <div class="form-group">
                                                <label for="analisis-minSales" class="form-label">Rango de Ventas (Mínimo)</label>
                                                <input type="number" class="form-control" id="analisis-minSales" placeholder="Mínimo" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-1">
                                            <div class="form-group">
                                                <label for="analisis-maxSales" class="form-label">Rango de Ventas (Máximo)</label>
                                                <input type="number" class="form-control" id="analisis-maxSales" placeholder="Máximo" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <div class="d-flex gap-1">
                                                <!-- Se eliminan los onclick y se añaden IDs -->
                                                <button class="btn btn-primary" id="analisis-applyFiltersBtn">
                                                    <i data-feather="filter"></i> Aplicar Filtros
                                                </button>
                                                <button class="btn btn-secondary" id="analisis-resetFiltersBtn">
                                                    <i data-feather="refresh-cw"></i> Restablecer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Sección de Estadísticas -->
                                <section class="stats-grid mb-3">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title  text-white">Total de Ventas</h6>
                                                            <h3 class="text-white" id="analisis-totalSales">0</h3>
                                                            <div class="text-white-50">
                                                                <i data-feather="trending-up"></i> <span id="analisis-salesChange">0%</span> vs período anterior
                                                            </div>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i data-feather="shopping-cart" class="font-large-2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title  text-white">Promedio Mensual</h6>
                                                            <h3 class="text-white" id="analisis-avgMonthly">0</h3>
                                                            <div class="text-white-50">
                                                                <i data-feather="trending-up"></i> <span id="analisis-growthRate">0%</span> crecimiento
                                                            </div>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i data-feather="bar-chart-2" class="font-large-2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title  text-white">Producto Top</h6>
                                                            <h3 class="text-white" id="analisis-topProduct">-</h3>
                                                            <div class="text-white-50">
                                                                <span id="analisis-topProductName">-</span>
                                                            </div>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i data-feather="award" class="font-large-2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title  text-white">Mes Más Activo</h6>
                                                            <h3 class="text-white" id="analisis-activeMonth">-</h3>
                                                            <div class="text-white-50">
                                                                <span id="analisis-activeMonthSales">0 unidades</span>
                                                            </div>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i data-feather="calendar" class="font-large-2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Sección de Gráficos -->
                                <section class="charts-container mb-3">
                                    <div class="row">
                                        <div class="col-md-8 mb-2">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title  text-white">Ventas Mensuales por Producto</h4>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-outline-primary analisis-chart-type-btn active" data-type="line">Línea</button>
                                                        <button type="button" class="btn btn-outline-primary analisis-chart-type-btn" data-type="bar">Barras</button>
                                                        <button type="button" class="btn btn-outline-primary analisis-chart-type-btn" data-type="area">Área</button>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="chart-wrapper" style="height: 300px;">
                                                            <canvas id="analisis-salesChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title">Distribución de Ventas</h4>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-outline-primary analisis-pie-type-btn active" data-type="pie">Circular</button>
                                                        <button type="button" class="btn btn-outline-primary analisis-pie-type-btn" data-type="doughnut">Donut</button>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="chart-wrapper" style="height: 300px;">
                                                            <canvas id="analisis-distributionChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Sección de Tabla -->
                                <section class="table-container">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                           
                                          
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="analisis-productsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Código <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Descripción <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Modelo <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Últ. Compra <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Últ. Venta <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Meses Act. <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Total Unid. <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Promedio Vta <i data-feather="chevron-down" class="ms-1"></i></th>
                                                                <th>Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="analisis-tableBody">
                                                            <!-- Table content will be populated by JavaScript -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->