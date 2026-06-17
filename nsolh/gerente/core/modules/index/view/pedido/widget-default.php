  <!-- BEGIN: Content-->

  <div class="app-content content ecommerce-application">
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
            <div class="content-detached content-right">
                <div class="content-body">
                    <!-- E-commerce Content Section Starts -->
                    <section id="ecommerce-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="ecommerce-header-items">
                                    <div class="result-toggler">
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
                            <div >Articulos en existencia: <label class="search-results" for="a"></label></div>
                            <label class="NUM_ITEMS_BY_PAGE " style="display:none" for="a"><?php echo NUM_ITEMS_BY_PAGE; ?></label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control search-product" id="shop-search" placeholder="Buscar Producto" aria-label="Buscando..." aria-describedby="shop-search" />
                                    <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                                </div>
                                
                            </div>
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
                            <div class="col-sm-12">
                                <nav aria-label="Page navigation example">
                                    
                                <ul class="pagination page1-links justify-content-center mt-2"></ul>
                                    <ul class="pagination pagination-pedido ">
                                       
                          
                                       
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>
                    <!-- E-commerce Pagination Ends -->

                </div>
            </div>
            <div class="sidebar-detached sidebar-left">
                <div class="sidebar">
                    <!-- Ecommerce Sidebar Starts -->
                    <div class="sidebar-shop">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="filter-heading d-none d-lg-block">Filtros de búsqueda</h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                                         

                                <!-- Categories Starts -->
                                <div id="product-categories">
                                    <h6 class="filter-title">Categorias</h6>
                                    <ul class="list-unstyled categories-list">
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="category1" name="category-filter" class="form-check-input" checked />
                                                <label class="form-check-label" for="category1">Costales</label>
                                            </div>
                                        </li>
                                       
                                    </ul>
                                </div>
                                <!-- Categories Ends -->

                              

                              

                                <!-- Clear Filters Starts -->
                                <div id="clear-filters">
                                    <button type="button" class="btn w-100 btn-primary">Limpiar filtros</button>
                                </div>
                                <!-- Clear Filters Ends -->
                            </div>
                        </div>
                    </div>
                    <!-- Ecommerce Sidebar Ends -->

                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->