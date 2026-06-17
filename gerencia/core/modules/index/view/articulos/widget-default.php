  <!-- BEGIN: Content-->
  <div class="app-content content ">
 
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
                        
                        <div class="mb-1 breadcrumb-right">
                        <button type="button" class="btn btn-relief-primary data-submit  me-1"   data-bs-toggle="modal"
                data-bs-target ="#modals-slide-in"> <i data-feather='search'></i> Filtrar articulos</button>
                        </div>
                       
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
                                           <th>Codigo</th>
                                           <th>Nombre Articulo</th>
                                           <th>Cantidad Stock</th>                                        
                                           <th>Precio $</th>    
                                           <th>Precio BS.D</th>
                                       </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->

                <div class="modal modal-slide-in fade" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                          
                                        

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Tipo de precio</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select comboCategorias" id="comboCategorias"  aria-hidden="true">
                                                            <option value="NO">Todas</option>
                                                                                         
                                                        </select>
                                                    </div>
                                                </div>                                          
                                              
                                              
                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarArticulos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        
        

         

        

            </div>
        </div>
    </div>
    <!-- END: Content-->