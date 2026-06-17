  <!-- BEGIN: Content-->

  <div class="app-content content ecommerce-application m_pedido">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Pedido</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=pedidos">Pedidos</a>
                                    </li>
                                    <li class="breadcrumb-item active">Listado
                                    </li>
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
            <div class="content-detached ">
                <div class="content-body">
                    <!-- E-commerce Content Section Starts -->
                    <section id="ecommerce-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="ecommerce-header-items">
                                    <div class="result-toggler d-none">
                                        <button class="navbar-toggler shop-sidebar-toggler" type="button" data-bs-toggle="collapse">
                                            <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
                                        </button>
                                      
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- E-commerce Content Section Starts -->

                    <!-- background Overlay when sidebar is shown  starts-->
                    <div class="body-content-overlay"></div>
                    <!-- background Overlay when sidebar is shown  ends-->

                    <!-- E-commerce Search Bar Starts -->
                    <section id="ecommerce-searchbar" class="ecommerce-searchbar">
                        <div class="row mt-1">
                            <div class="col-sm-12">
                                <div>Cliente: <label id ="cliente_status"  class="cliente_des" for="a"></label></div>
                                <div>Articulos en existencia: <label class="search-results" for="a"></label></div>
                                <label class="NUM_ITEMS_BY_PAGE " style="display:none" for="a"><?php echo NUM_ITEMS_BY_PAGE; ?></label>                          
                                <div class="input-group">                                              
                                    <input type="text" class="form-control search-product" id="shop-search" placeholder="Nombre o Código" aria-label="Buscando..." aria-describedby="shop-search" disabled>
                                    <button class="btn  btn-icon btn-primary waves-effect search-code "   id="search-code"  type="button" ><i data-feather="search" ></i></button> &nbsp;
                                    <button class="btn  btn-icon btn-danger   waves-effect btnModalClientes"  type="button"  id="btnModalClientes" ><i data-feather="user"></i></button>                                     
                                </div>                                                          
                             </div>
                           <!--
                            <div class="col-sm-6">    
                                <div ><label class="" for="a"></label></div>                            
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control search-product search-name" id="shop-search" placeholder="Buscar por còdigo " aria-label="Buscando..." aria-describedby="shop-search" />
                                        <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                                    </div>                                    
                            </div>
                            -->
                        </div>
                    </section>
                    <!-- E-commerce Search Bar Ends -->

                    <!-- E-commerce Products Starts -->
                    <section  class="grid-view ">
                            <div id="ecommerce-products" class="row ecommerceProducts">
                                
                            </div>
                    </section>
                    <!-- E-commerce Products Ends -->

                    <!-- E-commerce Pagination Starts -->
                    <section id="ecommerce-pagination-pedido">
                        <div class="row">
                            <div class="col-sm-12 d-none" id="paginationStatus">
                                <nav aria-label="Page navigation example">
                                    
                                <ul class="pagination page1-links justify-content-center mt-2"></ul>
                                    <ul class="pagination pagination-pedido">                                       
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>
                    <!-- E-commerce Pagination Ends -->

                </div>
            </div>
           
        </div>
    </div>
    <!-- END: Content-->


                                         

  
<div class="modal fade text-start modal-danger modalClientes" id="modalClientes" tabindex="-1" aria-labelledby="myModalLabel140"  data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
          
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body flex-grow-1">
           
            <input type="hidden" class="form-control  id" name="id" id="id" />
       
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-email">Cliente *</label>
                <select class="select2 form-select comboClientesFiltros" name="comboClientesFiltros" id="select2-basic-comboClientesFiltros">
                
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