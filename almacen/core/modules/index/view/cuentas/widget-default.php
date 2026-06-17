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
                                            <th>Código</th>
                                           
                                            <th>Cliente</th>
                                            <th>Rif</th>                                        
                                            <th>Saldo</th>  
                                          
                                            <th></th>  
                                           
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->

  <!-- Modal -->
                                              <!-- Modal -->
                                              <div class="modal fade facturas" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Cuentas por cobrar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" id="table-hover-row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                     
                                                                        <div class="card-body">
                                                                           
                                                                        </div>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>N° Documento</th>
                                                                                        <th>Tipo Doc</th>
                                                                                        <th>Saldo</th>
                                                                                        <th>Fecha Emisión</th>
                                                                                        <th>Dias vencidos</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="filaFactura">
                                                                                  
                                                                              
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-relief-primary" data-bs-dismiss="modal"><i data-feather='x-circle'></i> Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade facturasDetalles" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title facturaNumero" id="exampleModalCenterTitle"> </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" id="table-hover-row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                     
                                                                        <div class="card-body">
                                                                           
                                                                        </div>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Codigo</th>
                                                                                        <th>Articulo</th>
                                                                                        <th>Cantidad</th>
                                                                                        <th>Precio</th>
                                                                                        <th>Neto</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="filaFacturaDetalles">
                                                                                  
                                                                              
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-relief-primary" data-bs-dismiss="modal"><i data-feather='x-circle'></i> Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
         
         

        

            </div>
        </div>
    </div>
    <!-- END: Content-->