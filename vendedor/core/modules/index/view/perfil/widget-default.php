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
                                    <li class="breadcrumb-item"><a href="index.php?view=visitas">Clientes</a>
                                    </li>
                                    <li class="breadcrumb-item active">Perfil
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
                <div id="user-profile">
                    <!-- profile header -->
                    <div class="row">
                        <div class="col-12">
                                <div class="card profile-header mb-2">
                                    <div class="image custom-image-container">
                                        <img class="card-img-top" src="../app-assets/images/pages/timeline.webp" alt="User Profile Image" />
                                    </div>
                                    <div class="position-relative">
                                        <!-- profile picture -->
                                        <div class="profile-img-container d-flex align-items-center">
                                            <div class="profile-img">
                                                <img src="../app-assets/images/portrait/small/admin.png" class="rounded img-fluid fotoLocal" alt="Card image" />
                                            </div>
                                            <!-- profile title -->
                                            <div class="profile-title ms-3">
                                                <h2 class="text-white perfilCliente" id=" "><?php  echo $_GET['co_cli']?></h2>
                                                <input type="hidden" id="co_cli" value="<?php  echo $_GET['co_cli']?>">
                                                <p class="text-white">Código del cliente</p>
                                            </div>
                                        </div>
                                </div>
                  <!-- tabs pill -->
                                <div class="profile-header-nav">
                                    <!-- navbar -->
                                    <nav class="navbar navbar-expand-md navbar-light justify-content-end  w-100">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#fullscreenModal">
                                            <i data-feather="map-pin" class="font-medium-5"></i>
                                        </button>
                                            <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-fullscreen" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalFullTitle">Ubicación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <div class="map-responsive">
                                                          <div  class ="localizacionData" id ="localizacionData">
                                                         <div class="leaflet-map" id="user-location"></div>
                                                        </div>
                                                        </div> 
                                                         </div>
                                                        <div class="modal-footer">
                                                        
                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                     
                                    </nav>
                                    <!--/ navbar -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ profile header -->

                    <!-- profile info section -->
                    <section id="profile-info">
                        <div class="row">
                            <!-- left profile info section -->
                            <div class="col-lg-3 col-12 order-1 order-lg-1">
                                <!-- about -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-75">Cliente</h5>
                                        <p class="card-text">
                                            <h5 class="mb-75">Razón social:</h5>
                                            <p class="card-text cli_des" ></p>
                                        </p>
                                        <div class="mt-2">
                                            <h5 class="mb-75">Rif:</h5>
                                            <p class="card-text cli_rif"></p>
                                        </div>
                                      
                                        <div class="mt-2">
                                            <h5 class="mb-75">Telefono:</h5>
                                            <p class="card-text cli_telefono"></p>
                                        </div>
                                       
                                    </div>
                                </div>
                             
                            </div>
                         
                            <div class="col-lg-9 col-12 order-2 order-lg-2">
                            <input type="hidden" id="dataVisitas" class="dataVisitas" value=''>
                           
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="datatables-basic-visitas table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>                                           
                                                        <th>Cliente</th>
                                                        <th>Fecha</th>
                                                        <th>Descripción</th>
                                                        <th>Action</th>      
                                                    
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            

                                <!-- Modal to add new record -->
                                <div class="modal modal-slide-in fade" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record-visita modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Datos de la visita</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">
                                                
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-email">Cliente</label>
                                                        <p class="card-text cli_des_2" ></p>
                                                </div>   
                                            
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-email">Motivo</label>
                                                    <select class="form-select des_vis" id="des_vis" name="des_vis">    
                                                    <option value="NO">Seleccione</option>                                           
                                                        <option value="1">Si compro</option>    
                                                        <option value="2">No compro</option>   
                                                        <option value="3">Ya fue visitado</option> 
                                                        <option value="4">Tiene suficiente inventario</option>   
                                                        <option value="5">Existen otras ofertas</option>                                                
                                                    </select>
                                                </div>     
                                            
                                                
                                            
                                            
                                            
                                                <button type="button" class="btn btn-relief-primary data-submit-visita me-1"> <i data-feather='save'></i> Guardar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>  Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                            </div>
                         

                           
              </div>
            </div>                                     
                                            </div>
                                        </div>
                                        <!--/ polls card -->
                                    </div>
                                    <!--/ right profile info section -->
                                </div>

                              
                    </section>
                    <!--/ profile info section -->
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->