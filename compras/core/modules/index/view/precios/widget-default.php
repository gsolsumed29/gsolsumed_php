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
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Stock</th>
                                        <th>Proveedor</th>
                                        <th>Precios</th> <!-- Columna unificada para precios -->
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
                            <i data-feather="package"></i> Seleccionar Artículo *
                        </label>
                        <select class="form-select co_art" id="select-articulo-modal" required>
                            <option value="">Buscar artículo...</option>
                            <!-- Los artículos se cargarán dinámicamente -->
                        </select>
                        <div class="form-text">Seleccione un artículo de la base de datos</div>
                    </div>

                    <!-- Select de Proveedores -->
                    <div class="mb-1">
                        <label for="select-proveedor-modal" class="form-label">
                            <i data-feather="truck"></i> Seleccionar Proveedor *
                        </label>
                        <select class="form-select co_prov" id="select-proveedor-modal" required>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i data-feather="x"></i> Cancelar
                </button>
             <button type="button" class="btn btn-primary" id="btnAddPrecio">
                    <i data-feather="plus"></i> Agregar Artículo
            </button>
            </div>
        </div>
    </div>
</div>