<!-- BEGIN: Content -->
<div class="app-content content i_vendedor_ficha_analisis_visitas">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0" id="visita-title">Gestión de Vendedores</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
                                <li class="breadcrumb-item active">Analisís de desempeño</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-body">
            <!-- Filtros Superiores -->
            <div class="row mb-2 d-none">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Seleccionar Vendedor</label>
                                    <select class="form-select" id="visita-vendedorFilter">
                                      
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mes</label>
                                    <select class="form-select" id="visita-monthFilter">
                                        <option value="all">Todo el año</option>
                                        <option value="1" selected>Enero</option>
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
                                <div class="col-md-4">
                                    <button class="btn btn-primary w-100" id="visita-applyFiltersBtn">
                                        <i data-feather="filter"></i> Filtrar Datos
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de los 4 KPIs (Actualizado) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Indicadores clave de Desempeño</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <!-- 1. Visitas Cortas -->
                                    <!-- Cambiado a col-md-3 para ajustar a 4 columnas -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <div class="card bg-primary text-white h-100">
                                            <div class="card-body">
                                                <h6 class="card-title text-white">Vis. Cortas (Ruta)</h6>
                                                <div class="d-flex align-items-end justify-content-between">
                                                    <h2 class=" text-white fw-bold mb-0" id="kpi-visitasCortas">0</h2>
                                                    <div class="badge bg-light text-dark"><i data-feather="clock"></i> Mes actual</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 2. Entrevistas (Candidatos) -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <div class="card bg-primary text-white h-100">
                                            <div class="card-body">
                                                <h6 class="card-title text-white">Visitas Candidatos</h6>
                                                <div class="d-flex align-items-end justify-content-between">
                                                    <h2 class=" text-white fw-bold mb-0" id="kpi-entrevistas">0</h2>
                                                    <div class="badge bg-light text-dark"><i data-feather="message-square"></i> Mes actual</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 3. Candidatos Registrados -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <div class="card bg-primary text-white h-100">
                                            <div class="card-body">
                                                <h6 class="card-title text-white">Cand. Registrados</h6>
                                                <div class="d-flex align-items-end justify-content-between">
                                                    <h2 class=" text-white fw-bold mb-0" id="kpi-candidatosRegistrados">0</h2>
                                                    <div class="badge bg-light text-dark"><i data-feather="user-plus"></i> Mes actual</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 4. NUEVO: Visitas a Clientes (jm_visitas_cliente) -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <div class="card bg-info text-white h-100">
                                            <div class="card-body">
                                                <h6 class="card-title text-white">Visitas Clientes</h6>
                                                <div class="d-flex align-items-end justify-content-between">
                                                    <h2 class=" text-white fw-bold mb-0" id="kpi-visitasCliente">0</h2>
                                                    <div class="badge bg-light text-dark"><i data-feather="briefcase"></i> Mes actual</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Planificación y Detalles -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Planificación visitas Candidatos</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Meta Mensual de Visitas</span>
                                    <span class="fw-bold" id="plan-metaVisitas">0</span>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" id="plan-progresoVisitas" role="progressbar" style="width: 0%"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Cumplimiento de Plan</span>
                                    <span class="fw-bold" id="plan-cumplimiento">0%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" id="plan-barraCumplimiento" role="progressbar" style="width: 0%"></div>
                                </div>
                                
                                <div class="mt-3">
                                    <h6 class="text-uppercase text-muted fw-bold ls-1">Observaciones de Planificación</h6>
                                    <p class="card-text" id="plan-observaciones">
                                        Sin observaciones. El vendedor se encuentra dentro de los parámetros normales.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PLANIFICACIÓN VISITAS CORTAS -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Planificación Visitas Cortas (Clientes)</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Meta Mensual Clientes</span>
                                    <span class="fw-bold" id="cortas-metaVisitas">0</span>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-info" id="cortas-progresoVisitas" role="progressbar" style="width: 0%"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Cumplimiento Clientes</span>
                                    <span class="fw-bold" id="cortas-cumplimiento">0%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-secondary" id="cortas-barraCumplimiento" role="progressbar" style="width: 0%"></div>
                                </div>
                                
                                <div class="mt-3">
                                    <h6 class="text-uppercase text-muted fw-bold ls-1">Observaciones Clientes</h6>
                                    <p class="card-text" id="cortas-observaciones">
                                        Sin observaciones.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detalle por Vendedor</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" id="visita-kpiTable">
                                        <thead>
                                            <tr>
                                                <!-- 6 Columnas para coincidir con el JS -->
                                                <th>Vendedor</th>
                                                <th >Vis. Cortas</th>
                                                <th >Vis. Clientes</th>
                                                <th >Visit. Cand.</th>
                                                <th >Reg. Cand.</th>
                                                <th >Nuevos Cand.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- JS Rellenará esto -->
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
</div>
<!-- END: Content-->