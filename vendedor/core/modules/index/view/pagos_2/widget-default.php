  <!-- BEGIN: Content-->
  <div class="app-content content m_pedidos">
 
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
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Pedidos
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <!--
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i class="me-1" data-feather="check-square"></i><span class="align-middle">Todo</span></a><a class="dropdown-item" href="app-chat.html"><i class="me-1" data-feather="message-square"></i><span class="align-middle">Chat</span></a><a class="dropdown-item" href="app-email.html"><i class="me-1" data-feather="mail"></i><span class="align-middle">Email</span></a><a class="dropdown-item" href="app-calendar.html"><i class="me-1" data-feather="calendar"></i><span class="align-middle">Calendar</span></a></div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                  
                </div>
               <input type="hidden" id="dataCobros" class="dataCobros" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="dataTablesCobros table">
                                    <thead>
                                        <tr>
                                           
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                           
                                            <th>Nº</th>
                                            <th>Cliente</th>                                        
                                            <th>Fecha Emisión</th>  
                                            <th></th>
                                            <th></th>                                        
                                            <th>Total Neto</th>
                                            <th></th>            
                                            <th>Estatus</th>  
                                            <th></th>  
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->


         
                                 <!-- Modal to add new record -->
                                <div class="modal modal-slide-in fade" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                          
                                        

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Estatus del pedido</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                        <select class="select2 form-select status" id="status"  aria-hidden="true">
                                                            <option value="NO">Seleccionar</option>
                                                            <option value="0">Sin procesar</option>
                                                            <option value="1">Parcialmente Procesado</option>                                                           
                                                            <option value="2">Procesado</option>                                          
                                                        </select>
                                                    </div>
                                                </div>
                                               
                                              
                                                <div class="mb-4">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha de solicitud</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-range rango" placeholder="Seleccione Rango" />
                                                </div>
                                               
                                               
                                              
                                                <button type="button" class="btn btn-relief-primary data-submit cargarPedidos me-1"> <i data-feather='search'></i> Consultar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        

            </div>
        </div>
    </div>
    <!-- END: Content-->