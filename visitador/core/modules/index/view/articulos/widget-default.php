  <!-- BEGIN: Content-->
  <div class="app-content content m_articulos ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Articulos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=articulos">Articulos</a>
                                    </li>
                                    <li class="breadcrumb-item active">Listado
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
                                            <th></th>                                         
                                            <th></th>
                                            <th></th>
                                            <th></th>                                        
                                            <th></th>    
                                            <th></th>
                                            <th></th>  <th></th> <th></th>
                                            <th></th><th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->


<!-- Modal para la ficha del artículo -->
<div class="modal fade" id="modalFichaArticulo" tabindex="-1" aria-labelledby="modalFichaArticuloLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFichaArticuloLabel">Ficha del Artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted">Código</h6>
                        <p id="ficha-codigo" class="fw-bold"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted">Marca</h6>
                        <p id="ficha-marca" class="fw-bold"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">Descripción</h6>
                        <p id="ficha-descripcion" class="fw-bold"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted">Stock Actual</h6>
                        <p id="ficha-stock" class="fw-bold"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted">Precio Crédito  (<span id="ficha-moneda"></span>)</h6>
                        <p id="ficha-precio-contado" class="fw-bold"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted">Precio Contado  (<span id="ficha-moneda_2"></span>)</h6>
                        <p id="ficha-precio-credito" class="fw-bold"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted">Tipo de Impuesto</h6>
                        <p id="ficha-impuesto" class="fw-bold"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- NUEVO BOTÓN DE WHATSAPP -->
                <button type="button" class="btn btn-success" id="ficha-boton-compartir-ws">
                     <i data-feather="send"></i>  Compartir por WhatsApp
                </button>
                <button type="button" class="btn btn-primary" id="ficha-boton-ver-mas">Ver más detalles</button>
            </div>
        </div>
    </div>
</div>


        

            </div>
        </div>
    </div>
    <!-- END: Content-->