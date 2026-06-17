  <!-- BEGIN: Content-->
  <div class="app-content content reportexva m_reportexva">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                   

                    <div class="row match-height">
                    <input type="hidden" id="dataMeses" class="dataMeses" value=''>
                        <!-- Revenue Report Card -->

                     

                    
        

                         <!--Bar Chart Start -->
                         <div class="col-xl-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                                    <div class="header-center">
                                    <h4 class="card-title">Ventas por Kilogramos (KG)</h4>
                                       
                                    </div>
                                   
                                    <div class="header-right d-flex align-items-center mt-sm-0 mt-1">
                                        
                                    <i data-feather="calendar"></i>
                                       
                                        <input type="text" id="fp-range" class="form-control flatpickr-range border-0 shadow-none bg-transparent pe-0 filtrarMeses" placeholder="Seleccione Rango" />
                                      
                                    </div>
                                </div>
                                <div class="card-body">
                                <div class="chartdiv_report" id="chartdiv"></div>
                                <div id="chart"></div>
                                </div>
                            </div>
                        </div>

                    
                      
                      
                    </div>
                    
                    <div class="row match-height">
                       
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                <input type="hidden" id="dataVentasxArticulo" class="dataVentasxArticulo" value=''>
                                <table class="datatables-basic-ventas-articulos table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                                                               
                                            <th>Codigo</th>
                                            <th>Descripción</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>                                                                          
                                            <th>Marzo</th>  
                                            <th>Abril</th>                                                
                                            <th>Mayo</th>                                                                                                                                         
                                            <th>Junio</th>               
                                            <th>Julio</th>  
                                            <th>Agosto</th> 
                                            <th>Septiembre</th>   
                                            <th>Octubre</th>              
                                            <th>Noviembre</th>   
                                            <th>Diciembre</th>   
                                        </tr>
                                    </thead>
                                </table>
                                </div>
                            </div>
                        </div>
                     

                      

                    
                    </div>
                 
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->