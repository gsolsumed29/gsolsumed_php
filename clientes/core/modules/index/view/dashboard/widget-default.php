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


                    
                    </div>
                    

                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->