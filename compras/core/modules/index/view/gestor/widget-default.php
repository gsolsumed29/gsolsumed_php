  <!-- BEGIN: Content-->
    <div class="app-content content m_gestor_precios">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Comparación de Precios</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="#">Artículos</a></li>
                                    <li class="breadcrumb-item active">Comparación</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-body">
                <!-- Filtros de búsqueda -->
                <section id="basic-search">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="search-articulo">Artículo</label>
                                                <input type="text" id="search-articulo" class="form-control" placeholder="Código o descripción">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="select-proveedor">Proveedor</label>
                                                <select class="form-select" id="select-proveedor">
                                                    <option value="">Todos los proveedores</option>
                                                    <option value="1">Proveedor A</option>
                                                    <option value="2">Proveedor B</option>
                                                    <option value="3">Proveedor C</option>
                                                    <option value="4">Proveedor D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="select-categoria">Categoría</label>
                                                <select class="form-select" id="select-categoria">
                                                    <option value="">Todas las categorías</option>
                                                    <option value="1">Electrónicos</option>
                                                    <option value="2">Hogar</option>
                                                    <option value="3">Oficina</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="select-precio">Tipo de Precio</label>
                                                <select class="form-select" id="select-precio">
                                                    <option value="prec_vta1">Precio Venta 1</option>
                                                    <option value="prec_vta2">Precio Venta 2</option>
                                                    <option value="prec_vta3">Precio Venta 3</option>
                                                    <option value="prec_vta4">Precio Venta 4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary me-1" id="btn-buscar">
                                                <i data-feather="search"></i> Buscar
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" id="btn-limpiar">
                                                <i data-feather="refresh-cw"></i> Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Resultados de comparación -->
                <section id="comparison-results">
                    <div class="row match-height">
                        <!-- Resumen de comparación -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card price-comparison-card">
                                <div class="card-header">
                                    <h4 class="card-title">Resumen de Comparación</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Artículos encontrados:</span>
                                        <span class="fw-bolder" id="total-articulos">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Mejores precios:</span>
                                        <span class="fw-bolder text-success" id="mejores-precios">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Precios similares:</span>
                                        <span class="fw-bolder text-warning" id="precios-similares">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Precios más altos:</span>
                                        <span class="fw-bolder text-danger" id="precios-altos">0</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Gráfico de Comparación</h4>
                                </div>
                                <div class="card-body">
                                    <div id="price-comparison-chart" class="price-comparison-chart"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabla de comparación -->
                        <div class="col-lg-8 col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Detalle de Comparación</h4>
                                    <div class="heading-elements">
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-exportar">
                                            <i data-feather="download"></i> Exportar
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table-comparacion">
                                            <thead>
                                                <tr>
                                                    <th>Artículo</th>
                                                    <th>Descripción</th>
                                                    <th>Precio Sistema</th>
                                                    <th>Precio Proveedor</th>
                                                    <th>Diferencia</th>
                                                    <th>% Diferencia</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Los datos se cargarán dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
 <!-- Modal para detalles de artículo -->
    <div class="modal fade" id="modal-detalle" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetalleLabel">Detalle de Precios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Información del Artículo</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Código:</strong></td>
                                    <td id="modal-codigo">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Descripción:</strong></td>
                                    <td id="modal-descripcion">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Categoría:</strong></td>
                                    <td id="modal-categoria">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Precios del Sistema</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>Precio Venta 1:</td>
                                    <td id="modal-precio1" class="text-end">-</td>
                                </tr>
                                <tr>
                                    <td>Precio Venta 2:</td>
                                    <td id="modal-precio2" class="text-end">-</td>
                                </tr>
                                <tr>
                                    <td>Precio Venta 3:</td>
                                    <td id="modal-precio3" class="text-end">-</td>
                                </tr>
                                <tr>
                                    <td>Precio Venta 4:</td>
                                    <td id="modal-precio4" class="text-end">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6>Comparación con Proveedores</h6>
                            <div id="modal-comparacion-proveedores">
                                <!-- Contenido dinámico -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>