  <!-- BEGIN: Content-->
  <div class="app-content content m_articulos ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Precios </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Articulos</a>
                                    </li>
                                    <li class="breadcrumb-item active">Precios
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block ">
                   
                   
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                  
                </div>
               <input type="hidden" id="dataArticulos" class="dataArticulos" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-articulos table">
                                    <thead>
                                       <tr>
                                        <th></th> <!-- Responsive -->
                                        <th></th>  <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th> 
                                        <th></th> 
                                        
                                        <th></th> <!-- Responsive -->
                                        <!-- Columna unificada para precios -->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->


         
        
        



        

            </div>
        </div>
    </div>
    <!-- END: Content-->
<!-- Modal para agregar artículo -->
<div class="modal fade" id="modalAddPrecios" tabindex="-1" aria-labelledby="modalAgregarArticuloLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarArticuloLabel">
                    <i data-feather="plus"></i> Agregar Artículo con Precios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-agregar-articulo">
                    <!-- Select de Artículos -->
                    <div class="mb-1">
                        <label for="select-articulo-modal" class="form-label">
                          Seleccionar Artículo *
                        </label>
                        <select class="form-select select2 co_art" id="select-articulo-modal" required>
                            <option value="">Buscar artículo...</option>
                            <!-- Los artículos se cargarán dinámicamente -->
                        </select>
                        
                    </div>

                    <!-- Select de Proveedores -->
                    <div class="mb-1">
                        <label for="select-proveedor-modal" class="form-label">
                          Seleccionar Proveedor *
                        </label>
                        <select class="form-select select2 co_prov" id="select-proveedor-modal" required>
                            <option value="">Seleccionar proveedor...</option>
                            <!-- Los proveedores se cargarán dinámicamente -->
                        </select>
                    </div>

                    <!-- Código del artículo del proveedor -->
                    <div class="mb-1">
                        <label for="input-codigo-proveedor" class="form-label">
                            <i data-feather="hash"></i> Código del Artículo (Proveedor)
                        </label>
                        <input type="text" class="form-control" id="input-codigo-proveedor" 
                               placeholder="Código que identifica el proveedor para este artículo">
                        <div class="form-text">Código específico que usa el proveedor para este artículo</div>
                    </div>

                    <!-- Precios -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="input-precio1" class="form-label">
                                <span class="badge bg-primary">prec_vta1</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="input-precio1" 
                                       step="0.01" min="0" required placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-precio2" class="form-label">
                                <span class="badge bg-success">prec_vta2</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="input-precio2" 
                                       step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-precio3" class="form-label">
                                <span class="badge bg-warning">prec_vta3</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="input-precio3" 
                                       step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-precio4" class="form-label">
                                <span class="badge bg-danger">prec_vta4</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="input-precio4" 
                                       step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <!-- Información del artículo seleccionado -->
                    <div class="alert alert-info" id="info-articulo" style="display: none;">
                        <h6 class="alert-heading">Información del Artículo</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small><strong>Código:</strong> <span id="info-codigo">-</span></small>
                            </div>
                            <div class="col-md-6">
                                <small><strong>Categoría:</strong> <span id="info-categoria">-</span></small>
                            </div>
                            <div class="col-md-12 mt-1">
                                <small><strong>Descripción:</strong> <span id="info-descripcion">-</span></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
           <div class="modal-footer">
                 <button type="button" class="btn btn-outline-secondary btn-cancel-filtro me-1" data-bs-dismiss="modal">
                            <i data-feather='x-circle'></i> Cancelar
                        </button>
                <button type="button" class="btn btn-primary" id="btnAddPrecio">
                    <i data-feather="plus" class="me-1"></i> Registro
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Filtro de Comparación -->
<div class="modal modal-slide-in event-sidebar fade modalComparar" id="modalComparar" tabindex="-1" aria-labelledby="modalCompararLabel" aria-hidden="true">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="modalCompararLabel">Filtrar Comparación de Precios</h5>
            </div>
            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                <form class="form-filtro-comparacion needs-validation" novalidate>
                    <!-- 1. SELECT DE PRODUCTO -->
                    <div class="mb-3">
                        <label for="select-producto" class="form-label">Seleccionar Producto</label>
                        <select class="select2 form-select co_art_comparacion" id="co_art_comparacion" name="co_art_comparacion" data-placeholder="Seleccione un producto...">
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>

                    <!-- 2. SELECT MÚLTIPLE DE PROVEEDORES -->
                    <div class="mb-3">
                        <label for="select-proveedores" class="form-label">Seleccionar Proveedores a Comparar</label>
                       
                        
                        <select class="select2 form-select co_prov_comparacion" id="co_prov_comparacion" name="co_prov_comparacion" data-placeholder="Seleccione uno o más proveedores..." multiple>
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>
                    
                    <!-- Campos ocultos que no usaremos en esta lógica -->
                    <div class="d-none">
                        <div class="mb-1 position-relative">
                            <label for="start-date" class="form-label">Día</label>
                            <input type="text" class="form-control" id="start-date" name="start-date" placeholder="" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Description</label>
                            <textarea name="event-description-editor" id="event-description-editor" class="form-control"></textarea>
                        </div>
                    </div>
          
                    <div class="mb-1 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-cancel-filtro me-1" data-bs-dismiss="modal">
                            <i data-feather='x-circle'></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-success btn-aplicar-filtro btnFiltroComparacion">
                            <i data-feather='search'></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mejorado -->
    <div class="modal fade" id="modalAddPreciosLotes" tabindex="-1" aria-labelledby="batchProcessTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- Usamos modal-xl para más espacio -->
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold" id="batchProcessTitle">Procesar Comparación por Lotes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- PASO 1: SUBIDA DE ARCHIVO -->
                    <div id="uploadStep">
                        <p class="text-muted text-center mb-4">
                            Esta acción procesará un archivo CSV para comparar precios. El tiempo de procesamiento puede variar según la cantidad de proveedores.
                        </p>
                        <div class="upload-area" id="uploadArea">
                            <i data-feather="upload-cloud" class="icon" style="width: 48px; height: 48px;"></i>
                            <h6>Arrastra tu archivo CSV aquí o haz clic para seleccionarlo</h6>
                            <p class="text-muted small mb-0">Solo se permiten archivos .csv</p>
                            <div class="file-info" id="fileInfo"></div>
                        </div>
                        <input type="file" id="formFile" accept=".csv" style="display: none;">
                        <div class="alert alert-info mt-4" role="alert">
                            <h6 class="alert-heading"><i data-feather="info" style="width:18px; height:18px;"></i> Formato del CSV Requerido</h6>
                            <p class="mb-2">Asegúrate de que tu archivo incluya las siguientes columnas en este orden:</p>
                            <ul class="mb-0">
                                <li><code>Codigo del articulo segun proveedor</code></li>
                                <li><code>Precio 1</code></li>
                                <li><code>Precio 2</code></li>
                                <li><code>Precio 3</code></li>
                                <li><code>Precio 4</code></li>
                            </ul>
                        </div>
                    </div>

                    <!-- PASO 2: VISTA PREVIA -->
                    <div id="previewStep">
                        <p class="text-center mb-3">Por favor, revisa los datos extraídos del archivo antes de procesarlos.</p>
                        <div class="table-container">
                            <table class="table table-striped table-hover" id="previewTable">
                                <!-- La tabla se generará dinámicamente con JavaScript -->
                            </table>
                        </div>
                    </div>

                    <div id="resultsStep" style="display: yes;">
                        <h4>Resultados del Proceso</h4>
                        <div id="processSummary"></div>
                        <div id="errorDetails"></div>
                        
                       <!-- Agregar esto en tu HTML donde se muestra el resumen de resultados -->
                    <div id="successDetails" class="mt-3"></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0" id="modalFooter">
                    <!-- Los botones se cambiarán dinámicamente -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="processBatchBtn" class="btn btn-primary" disabled>
                        <span class="me-50">Procesar Lote</span>
                        <i data-feather="chevron-right" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>



