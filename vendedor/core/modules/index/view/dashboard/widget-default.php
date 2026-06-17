  <!-- BEGIN: Content-->
    <div class="app-content content m_dashboard ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
          <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                

                    <div class="row match-height">
                 
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-browser-states">
                                <div class="card-header">
                                    <div>
                                        <h4 class="card-title">Indicadores</h4>
                                        <p class="card-text font-small-2" id="estatusIndicadores"></p>
                                    </div>
                                    <div class="dropdown chart-dropdown">
                                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                        <div class="dropdown-menu dropdown-menu-end">  
                                            <a class="dropdown-item filtrarIndicadoresMes" id="filtrarIndicadoresActual" href="#">Mes en curso</a>                                          
                                            <a class="dropdown-item filtrarIndicadoresMes" id="filtrarIndicadoresMes" href="#">Més anterior</a>
                                       <!--     <a class="dropdown-item filtrarIndicadoresAnio" id="filtrarIndicadoresAnio" href="#">Año anterior</a> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="browser-states" id ="IndicadorVentasxPeriodo">
                                      <div class="d-flex">
                                            <img src="../../../app-assets/images/icons/1.webp" class="rounded me-1" height="55px" alt="facturacion" />
                                            <div class="d-flex flex-column">
                                                <p class="mb-0" id="clientestext">Monto facturado:</p>           
                                                <p class="mb-0 monto_facturado" id="monto_facturado" style="font-weight: bold;"></p>                         
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                        
                                            <div class="fw-bold text-body-heading me-1 porcentaje_alcanzado" id="porcentaje_alcanzado"></div>
                                                <div class="ventasxperiodo" id="ventasxperiodo"></div>
                                        </div>
                                    </div>
                                    <div class="browser-states" id="IndicadorClientesFacturados">
                                        <div class="d-flex">
                                            <img src="../../../app-assets/images/icons/2.webp" class="rounded me-1" height="50px" alt="clientesatendidos" />
                                            <div class="d-flex flex-column">
                                                <p class="mb-0" id="clientestext">Clientes activos:</p>           
                                                <p class="mb-0 clientes_facturados" id="clientes_facturados" style="font-weight: bold;"></p>                         
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                         
                                            <div class="fw-bold text-body-heading me-1 porcentaje_alcanzado_clientes" id="porcentaje_alcanzado_clientes"></div>
                                               <div class="clientesFacturadosGrafico" id="clientesFacturadosGrafico"></div>
                                        </div>
                                    </div>
                                    <div class="browser-states" id="IndicadorCobranzasMes">
                                       <div class="d-flex">
                                            <img src="../../../app-assets/images/icons/3.webp" class="rounded me-1" height="50px" alt="cobranza" />
                                            <div class="d-flex flex-column">
                                                <p class="mb-0" id="clientestext">Cobranzas del més:</p>           
                                                <p class="mb-0 cobranzas_mes" id="cobranzas_mes" style="font-weight: bold;">0.00</p>                         
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                    
                                            <div class="fw-bold text-body-heading me-1 porcentaje_cobranzas_realizadas" id="porcentaje_cobranzas_realizadas"></div>
                                                    <div class="cobranzasMesGrafico" id="cobranzasMesGrafico"></div>
                                        </div>
                                    </div>
                                    <div class="browser-states" id="IndicadorClientesNuevos">
                                         <div class="d-flex">
                                            <img src="../../../app-assets/images/icons/4.webp" class="rounded me-1" height="50px" alt="clientesnuevos" />
                                            <div class="d-flex flex-column">
                                                <p class="mb-0" id="clientestext">Clientes nuevos:</p>           
                                                <p class="mb-0 clientes_nuevos" id="clientes_nuevos" style="font-weight: bold;">0</p>                         
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                       
                                            <div class="fw-bold text-body-heading me-1 porcentaje_alcanzado_clientes_nuevos" id="porcentaje_alcanzado_clientes_nuevos"></div>
                                                 <div class="clientesNuevosGrafico" id="clientesNuevosGrafico"></div>
                                        </div>
                                    </div>
                                    <!--<div class="browser-states">
                                        <div class="d-flex">
                                            <img src="../../../app-assets/images/icons/3.png" class="rounded me-1" height="40" alt="Mozila Firefox" />
                                            <div class="d-flex flex-column">
                                                <p class="mb-0" id="clientestext">Clientes facturados:</p>           
                                                <p class="mb-0 clientes_facturados" id="clientes_facturados"></p>                         
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="clientesFacturadosGrafico" id="clientesFacturadosGrafico"></div>
                                            <div class="fw-bold text-body-heading me-1 porcentaje_alcanzado_clientes" id="porcentaje_alcanzado_clientes"></div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <!--/ Browser States Card -->

                            <!-- Browser States Card Modificado para Zonas/Vendedores -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-browser-states">
                            <div class="card-header">
                                    <div>
                                        <h4 class="card-title">Rendimiento por zona</h4>
                                        <p class="card-text font-small-2" id="estatusIndicadoress"> En el período </p>
                                    </div>
                            
                                </div>
                            <div class="card-body">
                                <!-- Selector de período (opcional) -->
                             

                                <!-- Aquí se cargarán dinámicamente las zonas -->
                                <div id="zonas-rendimiento-container">
                                    <!-- Ejemplo de estructura que se generará dinámicamente -->
                                    <!--
                                    <div class="browser-states">
                                        <div class="d-flex flex-row">
                                            <div class="rounded me-1 bg-primary d-flex align-items-center justify-content-center" style="width:30px; height:30px;">
                                                <span class="text-white fw-bold">ZN</span>
                                            </div>
                                            <h6 class="align-self-center mb-0">Zona Norte</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-bold text-body-heading me-1">75.4%</div>
                                            <div class="state-chart-success"></div>
                                        </div>
                                    </div>
                                    -->
                                    <div class="text-center text-muted py-3" id="cargando-zonas">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        Cargando zonas...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Browser States Card Modificado -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-browser-states h-100">
                            <div class="card-header pb-0">
                                <div>
                                    <h4 class="card-title mb-1">Rotación de Productos</h4>
                                  
                                </div>
                                <div class="dropdown chart-dropdown">
                                    </div>
                            </div>

                            <div class="card-body">
                                <div id="rotacion-rendimiento-container" class="my-2">
                                    <div class="text-center py-4" id="cargando-zonas">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        <p class="mt-1 text-muted small">Calculando rotación...</p>
                                    </div>
                                    
                                    </div>

                                <hr class="my-2">
                                <div class="mt-2">
                                    <h6 class="text-uppercase font-small-3 fw-bold text-muted mb-1">Metas de Rendimiento</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="d-flex align-items-center me-1">
                                            <span class="badge badge-dot bg-success me-50"></span>
                                            <span class="font-small-4">Alta: <strong>20%</strong></span>
                                        </div>
                                        <div class="d-flex align-items-center me-1">
                                            <span class="badge badge-dot bg-warning me-50"></span>
                                            <span class="font-small-4">Normal: <strong>30%</strong></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-50"></span>
                                            <span class="font-small-4">Premium: <strong>50%</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">Banco de Imágenes - Productos Bialy</h4>
                                        <small class="text-muted">Referencia visual de productos</small>
                                    </div>
                                    <a href="https://drive.google.com/drive/folders/1BE2S5OhoL-6w-g_fCx9cDyZIOc7MIUEQ?usp=sharing" 
                                    target="_blank" 
                                    class="btn btn-danger">
                                        <i data-feather="external-link" class="me-50"></i> Abrir Google Drive
                                    </a>
                                </div>
                                <div class="card-body">
                                    <!-- Galería de imágenes de referencia -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-12 mb-1">
                                            <div class="card shadow-none border">
                                                <img src="../../../app-assets/images/icons/1_P.webp" 
                                                    class="img-fluid rounded-top" 
                                                    alt="Producto Bialy 1"
                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                <div class="card-body text-center py-50">
                                                    <small class="fw-bold">Producto Bialy</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-1">
                                            <div class="card shadow-none border">
                                                <img src="../../../app-assets/images/icons/2_P.webp" 
                                                    class="img-fluid rounded-top" 
                                                    alt="Producto Bialy 2"
                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                <div class="card-body text-center py-50">
                                                    <small class="fw-bold">Producto Bialy</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-1">
                                            <div class="card shadow-none border">
                                                <img src="../../../app-assets/images/icons/3_P.webp" 
                                                    class="img-fluid rounded-top" 
                                                    alt="Producto Bialy 3"
                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                <div class="card-body text-center py-50">
                                                    <small class="fw-bold">Producto Bialy</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-1">
                                            <div class="card shadow-none border">
                                                <img src="../../../app-assets/images/icons/4_P.webp" 
                                                    class="img-fluid rounded-top" 
                                                    alt="Producto Bialy 4"
                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                <div class="card-body text-center py-50">
                                                    <small class="fw-bold">Producto Bialy</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Información adicional del repositorio -->
                                    <div class="d-flex align-items-center justify-content-between mt-1 flex-wrap">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-light-danger rounded p-50 me-1">
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ea5455" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Carpetas disponibles:</small>
                                                <small class="fw-bold">📁 Productos Bialy &nbsp;|&nbsp; 📁 Productos varios</small>
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1 mt-md-0">
                                            <i data-feather="image" class="me-25" style="width: 14px; height: 14px;"></i> 
                                            Repositorio completo en Google Drive
                                        </small>
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