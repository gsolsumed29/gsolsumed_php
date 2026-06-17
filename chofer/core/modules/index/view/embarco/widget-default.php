<!-- BEGIN: Content-->
<?php         
 
?> 
<div class="app-content content " id="datosCargaVehiculo">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Carga de Vehículo </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item"><a href="./vehiculos">Vehículos</a></li>
                                <li class="breadcrumb-item active">Carga</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <!-- Información del Vehículo -->
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                   
                                    
                                    <div class="invoice-number-date mt-md-0 mt-2 d-flex justify-content-end">
                                        <div class="search-container">
                                        <input type="text" class="form-control form-control-lg" id="buscarPaqueteInput" placeholder="Escanee o ingrese el código del lote..." autocomplete="off">
                                        <!-- NUEVO BOTÓN PARA PAUSAR/REANUDAR EL FOCO -->
                                        <button class="btn btn-warning" type="button" id="btnPausarFoco" title="Pausar para seleccionar Chofer/Zona">
                                            <i data-feather="pause"></i> Pausar
                                        </button>

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Asignación de Personal -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="chofer" class="form-label">Chofer</label>
                                            <select class="form-select" id="chofer">
                                                <option value="" disabled selected>Seleccionar chofer</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="vehiculo" class="form-label">Vehiculo</label>
                                            <select class="form-select vehiculo" id="vehiculo">
                                                <option value="" disabled selected>Seleccionar chofer</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="ayudante" class="form-label">Ayudante</label>
                                            <select class="form-select ayudante" id="ayudante"> 
                                                <option value="" disabled selected>Seleccionar preparador</option>
                                                <option value="">-- Todos los preparadores --</option>
                                                <option value="CARLOS CORDERO - 14.335.022">CARLOS CORDERO - 14.335.022</option>
                                                <option value="DAVID LINARES - 25.894.766">DAVID LINARES - 25.894.766</option>
                                                <option value="FRANCISCO DELGADO - 19.105.405">FRANCISCO DELGADO - 19.105.405</option>
                                                <option value="FRANCISCO NIETO - 19.106.048">FRANCISCO NIETO - 19.106.048</option>
                                                <option value="GABRIEL DUGARTE - 28.204.975">GABRIEL DUGARTE - 28.204.975</option>
                                                <option value="GUSTAVO SARMIENTO - 18.950.566">GUSTAVO SARMIENTO - 18.950.566</option>
                                                <option value="IVAN TIMAURE - 25.570.502">IVAN TIMAURE - 25.570.502</option>
                                                <option value="JESUS OCANTO - 26.904.745">JESUS OCANTO - 26.904.745</option>
                                                <option value="JOHAN JIMENEZ - 18.862.591">JOHAN JIMENEZ - 18.862.591</option>
                                                <option value="JOSE MENDOZA - 30.196.147">JOSE MENDOZA - 30.196.147</option>
                                                <option value="LUIS HERNANDEZ - 22.186.961">LUIS HERNANDEZ - 22.186.961</option>
                                                <option value="MANUEL BLANCO - 32.260.208">MANUEL BLANCO - 32.260.208</option>
                                                <option value="OMAR LEON - 12.025.986">OMAR LEON - 12.025.986</option>  
                                                
                                                <option value="EMERSON CARRILLO - 25.149.669">EMERSON CARRILLO - 25.149.669</option>
                                                <option value="GERARDO CORDERO - 9.612.869">GERARDO CORDERO - 9.612.869</option>  

                                                <option value="DARWIN ESCALONA- 17.227.687">DARWIN ESCALONA- 17.227.687</option>
                                                <option value="RANDARD PINTO - 16.001.234">RANDARD PINTO - 16.001.234</option>  

                                                <option value="JEAN SUAREZ- 15.004.889">JEAN SUAREZ- 15.004.889</option>
                                                <option value="DANYER VARGAS - 20.923.215">DANYER VARGAS - 20.923.215</option>                                 
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="zona" class="form-label">Zona a despachar</label>
                                              <label for="zona" class="form-label">Zona de Despacho</label>
                                            <select class="form-select" id="zona">
                                                <option value="" disabled selected>Seleccionar zona</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Tabla de Paquetes/Facturas -->
                            <div class="table-responsive px-3">
                                <table class="table mb-2" id="tablaPaquetes">
                                    <thead>
                                        <tr> 
                                            <th class="py-2 align-middle">#</th>
                                            <th class="py-2 align-middle">Lote</th>
                                            <th class="py-2 align-middle">Facturas</th>                                       
                                            <th class="py-2 align-middle text-center">Bultos</th>
                                            <th class="py-2 align-middle text-center">Estado</th>
                                            <th class="py-2 align-middle text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="filaPaquetes">
                                        <!-- Los paquetes se cargarán aquí mediante AJAX -->
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Resumen de Carga -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="fw-bold">Total Bultos: </span>
                                                <span id="totalPaquetes">0</span>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones de Acción -->
                    <div class="content-header-right col-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-3">
                                <div class="row align-items-center g-3">
                                    <!-- Botón de volver -->
                                    <div class="col-xl-2 col-lg-3 col-md-6 col-6">
                                        <div class="d-grid gap-2">
                                            <a href="./vehiculos" class="btn btn-danger d-flex align-items-center justify-content-center">
                                                <i data-feather='chevron-left'></i> Volver
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Botón de confirmación de carga -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-success d-flex align-items-center btnConfirmarCarga justify-content-center" id="btnConfirmarCarga" disabled>
                                                <i data-feather='check-circle'></i> Confirmar Carga
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Modal de Detalles de Factura -->
<div class="modal fade" id="modalDetallesFactura" tabindex="-1" aria-labelledby="modalDetallesFacturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetallesFacturaLabel">Detalles de Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="tablaDetallesFactura">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los detalles se cargarán aquí mediante AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Teclado Virtual Personalizado para Carga -->
<div id="cargaCustomKeyboard" class="carga-custom-keyboard" style="display: none;">
    <div class="carga-keyboard-container">
        <div class="carga-keyboard-header">
            <span class="carga-keyboard-title" id="cargaKeyboardTitle">Teclado de Búsqueda</span>
            <button class="btn btn-sm btn-outline-secondary" onclick="cargaOcultarTeclado()">
                X
            </button>
        </div>
        
        <!-- Teclado para Búsqueda -->
        <div id="cargaKeyboardSearch" class="carga-keyboard-mode">
            <div class="carga-keyboard-row">
                <button class="carga-keyboard-key" data-value="1">1</button>
                <button class="carga-keyboard-key" data-value="2">2</button>
                <button class="carga-keyboard-key" data-value="3">3</button>
            </div>
            <div class="carga-keyboard-row">
                <button class="carga-keyboard-key" data-value="4">4</button>
                <button class="carga-keyboard-key" data-value="5">5</button>
                <button class="carga-keyboard-key" data-value="6">6</button>
            </div>
            <div class="carga-keyboard-row">
                <button class="carga-keyboard-key" data-value="7">7</button>
                <button class="carga-keyboard-key" data-value="8">8</button>
                <button class="carga-keyboard-key" data-value="9">9</button>
            </div>
            <div class="carga-keyboard-row">
                <button class="carga-keyboard-key" id="cargaKeyClearSearch">C</button>
                <button class="carga-keyboard-key" data-value="0">0</button>
                <button class="carga-keyboard-key btn-success" id="cargaKeySearchEnter">BUSCAR</button>
            </div>
        </div>
    </div>
</div>