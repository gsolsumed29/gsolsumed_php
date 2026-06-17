<!-- BEGIN: Content-->
<div class="app-content content i_articulo_ficha">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0" id="product-title">Ficha</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="#">Articulos</a></li>
                                <li class="breadcrumb-item active">Ficha</li>
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
            <!-- Ficha del Producto -->
            <section id="product-detail">
                <div class="row">
                    <div class="mb-1">                      
                        <select class="form-select select2 co_art" id="select-articulo-ficha" required>
                            <option value="">Buscar artículo...</option>
                            <!-- Los artículos se cargarán dinámicamente -->
                        </select>
                     </div>

                    <!-- Columna izquierda: Imagen e información básica -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <!-- Espacio a la izquierda (puedes agregar elementos aquí si lo necesitas) -->
                                <div class="flex-grow-1"></div>
                                
                                <!-- Controles de Paginación centrados -->
                                <div class="pagination-controls">
                                    <button type="button" class="btn btn-icon btn-outline-secondary btn-sm" id="btn-prev" title="Artículo anterior">
                                        <i data-feather="chevron-left"></i>
                                    </button>
                                    <span class="mx-2 pagination-text" id="pagination-text"></span>
                                    <button type="button" class="btn btn-icon btn-outline-secondary btn-sm" id="btn-next" title="Siguiente artículo">
                                        <i data-feather="chevron-right"></i>
                                    </button>
                                </div>
                                
                                <!-- Espacio a la derecha (puedes agregar elementos aquí si lo necesitas) -->
                                <div class="flex-grow-1"></div>
                            </div>
                            <div class="card-body">
                                <div class="product-image-container">
                                    <img id="product-image" src="../app-assets/images/products/ART-001.jpg" alt="Imagen del producto" class="product-image">
                                    <div class="mt-2" style="position: relative; z-index: 2;">
                                     
                                    </div>
                                </div>
                                                                
                                <div class="mt-3">
                                    <h4 id="product-code" class="text-primary">Código: ART-001</h4>
                                    <h3 id="product-name" class="mb-1">Nombre del Producto</h3>
                                    <div class="mb-2">
                                        <span class="badge bg-light-primary" id="product-brand">Marca</span>
                                        <span class="badge bg-light-info" id="product-category">Categoría</span>
                                    </div>
                                    <p id="product-description" class="card-text">
                                        Descripción detallada del producto. Esta es una descripción de ejemplo que muestra las características principales del artículo.
                                    </p>
                                </div>
                                
                                <div class="stock-info mt-3">
                                    <h5>Stock Disponible</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span id="stock-quantity" class="stock-high">150 unidades</span>
                                        <div class="progress" style="width: 70%; height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Stock mínimo: <span id="stock-min">10</span> unidades</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Columna derecha: Precios y acciones -->
                    <div class="col-lg-8 col-md-12">
                        <!-- Precios del producto -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Precios del Producto</h4>
                                <div class="heading-elements">
                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                        <i data-feather="dollar-sign"></i> Actualizar Precios
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="price-comparison mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>Precio Venta 1:</span>
                                                <span class="price-badge badge bg-primary" id="price-1">$150.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>Precio Venta 2:</span>
                                                <span class="price-badge badge bg-info" id="price-2">$140.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="price-comparison mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>Precio Venta 3:</span>
                                                <span class="price-badge badge bg-warning" id="price-3">$130.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>Precio Venta 4:</span>
                                                <span class="price-badge badge bg-success" id="price-4">$120.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="alert alert-primary">
                                            <div class="alert-body">
                                                <div class="d-flex justify-content-between">
                                                    <span><strong>Precio de Compra:</strong> <span id="purchase-price"></span></span>
                                                    <span><strong>Margen de rentabilidad:</strong> <span id="average-margin"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Información de Almacén</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Almacén:</strong></td>
                                                <td id="warehouse">Principal</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ubicación:</strong></td>
                                                <td id="location">Estante A-15</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Proveedor Principal:</strong></td>
                                                <td id="main-supplier">Proveedor ABC</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Código de Barras:</strong></td>
                                                <td id="barcode">1234567890123</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Estadísticas de Ventas</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Ventas del Mes:</strong></td>
                                                <td id="month-sales"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ventas del Año:</strong></td>
                                                <td id="year-sales">520 unidades</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ventas del Mes anterior:</strong></td>
                                               <td id="month-sales-1"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tendencia:</strong></td>
                                                <td id="trend"><span class="text-success"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INICIO: Bloque movido desde la columna izquierda -->
                        <!-- Información de fechas importantes -->
                        <div class="card info-card mt-2">
                            <div class="card-header">
                                <h4 class="card-title">Fechas Importantes</h4>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <h6 class="mb-0">Última Compra</h6>
                                        <small class="text-muted" id="last-purchase-date"></small>
                                    </div>
                                    <div class="timeline-item">
                                        <h6 class="mb-0">Última Venta</h6>
                                        <small class="text-muted" id="last-sales-date"></small>
                                    </div>
                                    <div class="timeline-item">
                                        <h6 class="mb-0">Última Actualización</h6>
                                        <small class="text-muted" id="last-update"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN: Bloque movido -->

                    </div>
                </div>
            </section>

            <!-- Historial de movimientos
            <section id="movement-history" class="mt-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Historial de Movimientos Recientes</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="movement-table">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Tipo</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Total</th>
                                                <th>Referencia</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>20/03/2024</td>
                                                <td><span class="badge bg-light-success">Venta</span></td>
                                                <td>5</td>
                                                <td>$140.00</td>
                                                <td>$700.00</td>
                                                <td>FAC-001245</td>
                                                <td>Usuario A</td>
                                            </tr>
                                            <tr>
                                                <td>18/03/2024</td>
                                                <td><span class="badge bg-light-warning">Compra</span></td>
                                                <td>50</td>
                                                <td>$95.00</td>
                                                <td>$4,750.00</td>
                                                <td>ORD-00789</td>
                                                <td>Usuario B</td>
                                            </tr>
                                            <tr>
                                                <td>15/03/2024</td>
                                                <td><span class="badge bg-light-success">Venta</span></td>
                                                <td>3</td>
                                                <td>$140.00</td>
                                                <td>$420.00</td>
                                                <td>FAC-001238</td>
                                                <td>Usuario A</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
        </div>
    </div>
</div>
<!-- END: Content-->