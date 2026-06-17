  <!-- BEGIN: Content-->
  <div class="app-content content m_embarcos_consulta">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Embarcos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=embarco">Generar</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Embarcos Consulta
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
               <input type="hidden" id="dataEmbarques" class="dataEmbarques" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                               <table class="datatables-basic-embarques table">
                                <thead>
                                    <tr>
                                        <th></th>                                            <!-- Para la columna # (índice 0) -->                   
                                        <th></th>                                            <!-- Para responsive_id (índice 1) -->                   
                                        <th></th>                                            <!-- Para carga_id (índice 2) -->                   
                                        <th></th>                                            <!-- Para vehiculo_nombre (índice 3) -->
                                        <th></th>                                            <!-- Para chofer_nombre (índice 4) -->                                      
                                        <th></th>                                            <!-- Para ayudante_nombre (índice 5) -->  
                                        <th></th>                                            <!-- Para zona_nombre (índice 6) -->                                          
                                        <th></th>                                            <!-- Para total_paquetes (índice 7) -->   
                                        <th></th>                                            <!-- Para fecha_carga (índice 8) -->    
                                        <th></th>                                            <!-- Para estatus (índice 9) -->              
                                        <th></th>                                            <!-- ¡ESTE ES EL <th> QUE FALTABA! Para la columna de Acciones (índice 10) -->
                                    </tr>
                                </thead>
                                <!-- DataTables creará el <tbody> por ti con los datos -->
                            </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->



         
                                 <!-- Modal to add new record -->
                                <div class="modal modal-slide-in fade" id="modalBuscarDespacho">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                                  
                                            
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Verificador</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                    <select class="select2  form-select border-0 shadow-none bg-transparent pe-0 comboVerificadores" id="comboVerificadores">   
                                                        <option value="NO">Todos</option>                                        
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                                   
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                                <button type="button" class="btn btn-relief-primary data-submit cargarDespachos me-1"> <i data-feather='search'></i> Consultar</button>


                                            </div>
                                        </form>
                                    </div>
                                </div>



                                    <!-- Modal de detalles del embarque -->
                    <div class="modal fade" id="modalDetallesEmbarque" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles del Embarque</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Vehículo:</strong> <span id="detalleVehiculo"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Chofer:</strong> <span id="detalleChofer"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Ayudante:</strong> <span id="detalleAyudante"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Zona:</strong> <span id="detalleZona"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Total Paquetes:</strong> <span id="detalleTotalPaquetes"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Fecha de Carga:</strong> <span id="detalleFechaCarga"></span>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Modal de lotes del embarque -->
                    <div class="modal fade" id="modalLotesEmbarque" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lotes del Embarque</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                            <table class="table" id="tablaLotes">
                                <thead>
                                <tr>
                                    <th>Lote ID</th>
                                    <th>Cantidad</th>
                                    <th>Facturas</th>
                                    <th>Cliente</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Los lotes se cargarán dinámicamente -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Modal de cancelación del embarque -->
                    <div class="modal fade" id="modalCancelacionEmbarque" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cancelar Embarque</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro de que desea cancelar el embarque #<span id="cancelacionEmbarqueId"></span>?</p>
                            <div class="mb-3">
                            <label for="motivoCancelacion" class="form-label">Motivo de la cancelación:</label>
                            <textarea class="form-control" id="motivoCancelacion" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmarCancelacion">Confirmar Cancelación</button>
                        </div>
                        </div>
                    </div>
                    </div>
        

            </div>
        </div>
    </div>
    <!-- END: Content-->