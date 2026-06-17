<!-- BEGIN: Content-->
<div class="app-content content generadorEtiquetas">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Generador de Etiquetas</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Despacho</a></li>
                                <li class="breadcrumb-item active">Generador de Etiquetas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
           <div class="row">
                  
                </div>
               <input type="hidden" id="dataDespachosEmpaquetar" class="dataDespachosEmpaquetar" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-facturas table">
                                    <thead>
                                        <tr> <th></th>        
                                           
                                            <th></th>                                           
                                            <th></th> 
                                            <th></th>                   
                                            <th></th>
                                            <th></th>                                        
                                            <th></th>  
                                            <th></th>                                          
                                            <th></th>   
                                            <th></th>                 
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->
            </section>

            <!-- Modal 1: Configurar Paquetes -->
            <div class="modal fade" id="modalConfigurarPaquete" tabindex="-1" aria-labelledby="modalConfigurarPaqueteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalConfigurarPaqueteLabel">Configurar Paquetes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="infoFactura" class="form-label">Factura Seleccionada:</label>
                                <p id="infoFactura" class="fw-bold"></p>
                            </div>
                            <div class="mb-3">
                                <label for="numPaquetes" class="form-label">Número de Paquetes</label>
                                <input type="number" class="form-control" id="numPaquetes" min="1" value="1">
                                <small class="text-muted">Especifique en cuántos paquetes se distribuyó la mercancía de esta factura.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="btnGenerarPreview"> Vista Previa</button>
                        </div>
                    </div>
                </div>
            </div>



            
  <!-- Modal 2: Vista Previa de Notas de Entrega -->
<div class="modal fade" id="modalPreviewEtiqueta" tabindex="-1" aria-labelledby="modalPreviewEtiquetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-papel modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content papel-contenido">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPreviewEtiquetaLabel">Vista Previa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contenedorEtiquetas">
                <!-- Las notas de entrega se generarán aquí dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnImprimirEtiquetasPrint">
                    <i data-feather="printer"></i> Imprimir(s)
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="loteIdActual" value="">

    </div>
</div>
<!-- END: Content-->

<!-- Modal Ficha Factura -->
<div class="modal fade" id="modalFichaFactura" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Información de la Factura</h6>
                        <p><strong>Número:</strong> <span id="ficha-numero-factura"></span></p>
                        <p><strong>Fecha de Chequeo:</strong> <span id="ficha-fecha-chequeo"></span></p>
                        <p><strong>Estatus:</strong> <span id="ficha-estatus"></span></p>
                        <p><strong>Preparado por:</strong> <span id="ficha-preparado-por"></span></p>
                        <p><strong>Verificado por:</strong> <span id="ficha-verificado-por"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Información del Cliente</h6>
                        <p><strong>Nombre:</strong> <span id="ficha-nombre-cliente"></span></p>
                        <p><strong>Código:</strong> <span id="ficha-codigo-cliente"></span></p>
                        <p><strong>Dirección:</strong> <span id="ficha-direccion"></span></p>
                        <p><strong>Ciudad:</strong> <span id="ficha-ciudad"></span></p>
                        <p><strong>Zona:</strong> <span id="ficha-zona"></span></p>
                        <p><strong>Código Postal:</strong> <span id="ficha-zip"></span></p>
                        <p><strong>Teléfonos:</strong> <span id="ficha-telefonos"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="ficha-boton-generar">
                    <i class="fas fa-print me-1"></i> Generar Etiqueta
                </button>
            </div>
        </div>
    </div>
</div>