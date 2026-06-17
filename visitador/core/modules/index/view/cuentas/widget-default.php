  <!-- BEGIN: Content-->
  <div class="app-content content cuentasPorCobrar m_cuentas">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Cuentas </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=pedido">Pedir</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Cuentas por cobrar
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12  ">
                   
                    <div class="mb-1 breadcrumb-right">
                      
                    <a  class="btn btn-success waves-effect waves-float waves-light cuentasPorCobrar" id="cuentasPorCobrar">cuentas por cobrar</a>
                          
                      
                    </div>
                    
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                  
                </div>
               <input type="hidden" id="dataCuentasPorCobrar" class="dataCuentasPorCobrar" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-cuentas table">
                                    <thead>
                                        <tr>
                                           
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

  <!-- Modal --><!-- Modal Principal para Facturas -->
<div class="modal fade" id="modalFacturas" tabindex="-1" aria-labelledby="modalFacturasLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalFacturasLabel">
          <span id="titulo-modal">Facturas del Cliente</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Vista 1: Lista de Facturas en Tarjetas -->
        <div id="vista-lista-facturas">
          <div class="row" id="contenedor-facturas">
            <!-- Las tarjetas de facturas se inyectarán aquí con JavaScript -->
          </div>
        </div>

        <!-- Vista 2: Detalles de una Factura Específica (inicialmente oculta) -->
        <div id="vista-detalles-factura" style="display: none;">
          <button id="btn-volver" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver a la lista</button>
          
          <div class="card mb-3">
            <div class="card-header bg-light">
              <h5 class="mb-0" id="resumen-factura-detalle">
                <!-- Resumen de la factura (N°, Saldo, Neto) se inyectará aquí -->
              </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="table-dark">
                    <tr>
                      <th>Código Artículo</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <th>Precio Unit.</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody id="tabla-detalles-cuerpo">
                    <!-- Los detalles de la factura se inyectarán aquí -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
         

        

            </div>
        </div>
    </div>
    <!-- END: Content-->