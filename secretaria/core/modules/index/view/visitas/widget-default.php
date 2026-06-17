  <!-- BEGIN: Content-->
  <div class="app-content content m_clientes ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Clientes</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=clientes">Clientes</a>
                                    </li>
                                    <li class="breadcrumb-item active">Listado
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">                 
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                    <div class="col-12 data">
                    
                     
                        
                    </div>
                </div>
               <input type="hidden" id="dataClientesVisitas" class="dataClientesVisitas" value=''>

                    <!-- Advanced Search -->
                <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                              
                                <div class="card-body mt-2">
                                    <form class="dt_adv_search" method="POST">
                                        <div class="row g-1 mb-md-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Razon social:</label>
                                                <input type="text" class="form-control dt-input dt-full-name" data-column="3" placeholder="jmobile ver 1.0" data-column-index="3" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Rif:</label>
                                                <input type="text" class="form-control dt-input" data-column="4" placeholder="J-112346658" data-column-index="4" />
                                            </div>                                          
                                        </div>
                                    
                                    </form>
                                </div>
                                <hr class="my-0" />
                                <div class="card-datatable">
                                    <table class="dt-advanced-search datatables-basic-clientes-visitas table">
                                        <thead>
                                            <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>   
                                            <th>Razòn Social</th>                                        
                                            <th>Rif</th>                                                                       
                                            <th>Teléfonos</th>                                                           
                                            <th>Acciones</th>                                                                                   
                                                                                                                                                                 
       
                                            </tr>
                                        </thead>
                                  
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Advanced Search -->
                                            <div class="modal fade text-start modal-warning cliente_localizacion" id="warning" tabindex="-1" aria-labelledby="myModalLabel140" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel140">Establecer Localización e Imagén</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body flex-grow-1">
                                                       
                                                          <input type="hidden" class="form-control  co_cli" name="co_cli" id="co_cli" />
                                                     
                                                        <div class="mb-1">
                                                            <label class="form-label" for="basic-icon-default-email">Ubicacion GPS | Google Maps</label>
                                                            <textarea class="form-control localizacion" id="localizacion" name ="localizacion" rows="3" placeholder="Localidad "></textarea>
                                                        </div>      
                                                        <div class="mb-1">
                                                            <label class="form-label" for="basic-icon-default-email">Fotografia del Lugar</label>
                                                            <input type="file" accept="image/png,image/jpeg,image/jpg" class="form-control foto" name="foto" id="foto"><br>
                                                                                <p>Solo se permiten (2) archivos en formato .PNG , .JPEG, .JPG </p>
                                                        </div> 
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-relief-warning guardarLocalizacion" data-bs-dismiss="modal"><i data-feather='save'></i> Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
              
                                            

            </div>
        </div>
    </div>
    <!-- END: Content-->