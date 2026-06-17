  <!-- BEGIN: Content-->
    <div class="app-content content i_despachos_consulta_rutas ">
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
                
                         <div class="row">
                                <div class="col-md-4">
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h4>Configuración de Ruta</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label>Latitud Inicio:</label>
                                                <input type="text" id="latInicio" class="form-control" value="-12.0464">
                                            </div>
                                            <div class="mb-3">
                                                <label>Longitud Inicio:</label>
                                                <input type="text" id="lonInicio" class="form-control" value="-77.0428">
                                            </div>
                                            <button id="btnOptimizar" class="btn btn-primary w-100">
                                                Optimizar Ruta
                                            </button>
                                            <div id="loading" class="text-center mt-2" style="display:none;">
                                                <div class="spinner-border"></div>
                                                <p>Optimizando ruta...</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="panelRuta" class="mt-3">
                                        <!-- Aquí se mostrará la información de la ruta -->
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div id="mapaRutas" style="height: 600px; margin-top: 20px;"></div>
                                </div>
                            </div>
                        
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
