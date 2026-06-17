  <!-- BEGIN: Content-->
    <div class="app-content content  m_cobros">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-start mb-0">Despacho </h2>
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
        
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                <div class="row match-height">
                    
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
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
                                                        <th>Nº</th>                                                 
                                                        <th class="d-none">Fecha Emisiòn</th>    
                                                        <th>Cliente</th>     
                                                        <th class="d-none">Dias Credito</th>                                                                                                                                                   
                                                        <th></th>  
                                                       
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

    
                                 <!-- Modal to add new record -->
                                <div class="modal modal-slide-in fade" id="modalBuscarFactura">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                          
                                        
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Por Zona</label>
                                                     <select class="select2 form-select comboDespachoZonas" id="comboDespachoZonas">
                                                        <option value="0" selected disabled>Seleccione la Zona</option>
                                                    </select>
                                                </div>

                                               <!-- <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Por cliente</label>
                                                     <select class="select2 form-select comboClientesFactura" id="comboClientesFactura">
                                                        <option value="0" selected disabled>Seleccione el cliente</option>
                                                    </select>
                                                </div> -->

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                              
                                               
                                               
                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDespachos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        
                                    
                       