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
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->


         
        
                    <div class="modal fade text-start modal-danger modalSeleccionarLista" id="modalSeleccionarLista" tabindex="-1" aria-labelledby="myModalLabel140"  data-bs-backdrop="false" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex-grow-1">
                            
                                <input type="hidden" class="form-control  id" name="id" id="id" />
                        
                                <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-email">Tipo de precio *</label>
                                    <select class="select2 form-select comboTipoPrecios" name="comboTipoPrecios" id="comboTipoPrecios">
                                    
                                    </select>
                                </div>  
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-email">Facturación *</label>
                                    <select class="form-select comboFacturacionFiltros" name="comboFacturacionFiltros" id="select2-basic-comboFacturacionFiltros">                                                           
                                            <option value="0">Seleccionar</option>    
                                            <option value="1">FISCAL</option>     
                                            <option value="2">NOTA</option>                                                                              
                                    </select>
                                </div>  
                                
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-email">Forma  de pago *</label>
                                    <select class="form-select comboFormaPagoFiltros" name="comboFormaPagoFiltros" id="select2-basic-comboFormaPagoFiltros">                                                           
                                            <option value="0">Seleccionar</option>    
                                            <option value="1">BS.D</option>     
                                            <option value="2">DIVISAS</option>                                                                             
                                    
                                    </select>
                                </div>      
                            
                            </div>     
                            <div class="modal-footer">
                                <button type="button" class="btn btn-relief-info btnSeleccionarCliente" >Ok</button>
                            </div>
                        </div>
                        </div>
                    </div>



        

            </div>
        </div>
    </div>
    <!-- END: Content-->