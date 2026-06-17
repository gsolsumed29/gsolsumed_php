  <!-- BEGIN: Content-->
    <div class="app-content content  m_cobros">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Despacho | Modificaciones </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>                                  
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Resumen de facturaciones
                                    </li>
                                </ol>
                            </div>
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
                                  
                                          <span class="status">1</span> <!-- facturas que ya han sido despachadas -->
                                            <select class="select2 form-select comboClientesFactura" id="select2-basic-comboClientesFactura">
                                                        <option value="0">Seleccione cliente</option>
                                                </select>
                                                
                                    
                                </div>
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-8 col-12">
                        <input class="dataFacturas" type="hidden" id="dataFacturas" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="datatables-basic-facturas table" id="facturas">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>                                                       
                                                        <th>Nº Documento</th>                                                 
                                                        <th>Fecha Emisiòn</th>                                                                                                                                        
                                                        <th>Estatus</th>          
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                     
                            </section>
                            <!--/ Basic table -->
                        </div>
                        <!--/ Company Table Card -->

                       
                     
              

                    </div>

                
                   
                </section>
              
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

                               