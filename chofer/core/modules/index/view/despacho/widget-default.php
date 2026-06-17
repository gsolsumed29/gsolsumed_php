  <!-- BEGIN: Content-->
    <div class="app-content content m_adelantos ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Despachos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>                                   
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Despacho
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                <div class="row match-height">
                     <!-- Developer Meetup Card -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                                </div>
                                <div class="card-body">
                                  
                                          <div class="row">
                                            <div class="col-8 col-lg-8">
                                            <input type="number" class="form-control fact_nun"   id="fact_nun" aria-label="fact_nun" required  autofocus>
                                            </div>
                                            <div class="col-4 col-lg-4">
                                            <button type="button" class="btn btn-relief-primary data-submit buscarFact me-1"><i data-feather='search'></i> Buscar</button>
                                            </div>
                                          </div>
                                           
                                                
                                    
                                </div>
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-6 col-12 d-none " id="facturaDespacho">
                    
                       
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title cli_des" id="cli_des"></h5>
                                    <h5 class="card-title">Relacion de facturaciòn</h5>
                                    <label class="d-none" id="facturaNumero"></label>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal">
                                    <div class="row">
                                            <div class="col-12">
                                                    <div class="mb-1 row ">
                                                        <div class="col-sm-6">
                                                            <label class="col-form-label" for="first-name">Articulo</label>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Cantidad</label>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <label class="col-form-label" for="first-name">Fecha de caducidad</label>
                                                        </div>
                                                    
                                                    </div>
                                            </div>                                              
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                    <div class="mb-1 row filasFactura" id="filaFacturas">
                                                   
                                                    
                                                    </div>
                                            </div>
                                            
                                           
                                            <div class="col-sm-3 offset-sm-9">
                                                <button type="button" class="btn btn-relief-success me-1 AgregarInventario ">Guardar</button>    
                                                                                      
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    

                       
                     
              

                    </div>

                
                   
                </section>
              
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->