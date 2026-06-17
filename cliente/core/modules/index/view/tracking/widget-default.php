 <div class="conatiner-fluid content-inner mt-n5 py-0">
     <div class="row">     
            <!-- COLUMNA IZQUIERDA: Últimas Facturaciones -->
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white">
                        <div class="header-title">
                            <h4 class="card-title mb-0">Últimas facturaciones</h4>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm btn-refresh-facturas" title="Cargar siguiente factura">
                            <span class="btn-inner">
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="card-body" id="tracking">
                        <!-- Contenido dinámico vía JS -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                            <div>
                                <h5 class="fw-bold mb-1" id="lbl-nro-factura"># ---</h5>
                                <p class="mb-0 text-muted" id="lbl-cliente">Selecciona una factura</p>
                                <p class="mb-0 text-muted small" id="lbl-fecha"></p>
                            </div>
                        
                            <button type="button" class="btn btn-primary btn-sm btn-editar-factura">
                                <span class="btn-inner d-flex align-items-center">
                                    <svg class="icon-20 me-1" xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Ver Detalles
                                </span>
                            </button>
                        </div>
                        
                        <!-- Resumen rápido -->
                        <div class="mt-3 p-3 bg-light rounded border">                           
                            <div class="d-flex justify-content-between mt-1">
                                <span>Estado Actual:</span>
                                <span id="lbl-estado-badge" class="status-badge status-pending">Pendiente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Tracking -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between bg-white">
                        <div class="header-title">
                            <h4 class="card-title mb-0">Tracking</h4>
                        </div>
                    </div>
                    <div class="card-body" id="tracking_detalles" >
                        <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                            <!-- Lista UL generada dinámicamente -->
                            <ul class="list-inline p-0 m-0 w-100" id="timeline-container">
                                <!-- Los items del timeline se inyectarán aquí con JS -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>