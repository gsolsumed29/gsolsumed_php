  <!-- BEGIN: Content-->
    <div class="app-content content  m_pagos">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Pagos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=cobros">Cobros</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Pagos realizados
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="content-body">             
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                     <!-- Developer Meetup Card -->
                     
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12" id="pagos" style="display:" >
                            <input class="dataPagos" type="hidden" id="dataPagos" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="dataTablesPagos table" id="dataTablesPagos">
                                                <thead>
                                                    <tr>
                                                        <th></th> <th></th>
                                                        <th></th>                                                       
                                                        <th></th> <th></th>  
                                                        <th></th>                                                     
                                                        <th></th>                                                    
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
                        </div>
                     
                    </div>   
                </section>

            </div>
        </div>
    </div>



                                <div class="modal modal-slide-in fade FiltroBuscarFacturas" id="FiltroBuscarFacturas">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">    
                                                
                                               <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Clientes</label>
                                                        <select class="select2 form-select comboClientesFactura" id="select2-basic-comboClientesFactura">
                                                            <option value="0" selected>Seleccione cliente</option>
                                                        </select>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                                </div>

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit btnConsultarClientesPagos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>