<!-- BEGIN: Content-->
<div class="app-content content m_entregas_consulta">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Entregas</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item"><a href="./">Generar</a></li>
                                <li class="breadcrumb-item active">
                                    <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Entregas
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
                <!-- Contenedor para los botones de exportación -->
                <div class="col-12" id="export-container-facturas" style="display: flex; justify-content: flex-end; margin-bottom: 10px;"></div>
            </div>
            
            <input type="hidden" id="dataEntregas" class="dataEntregas" value=''>
            <!-- Basic table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="datatables-basic-entregas table">
                                <thead>
                                      <tr>
                                        <!-- Debe haber 6 <th>, igual que en el array 'columns' de JS -->
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
</div>
<!-- END: Content-->

<!-- Modal de búsqueda -->
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
                        <select class="select2 form-select border-0 shadow-none bg-transparent pe-0 comboVerificadores" id="comboVerificadores">   
                            <option value="NO">Todos</option>                                        
                        </select>
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input finicio" placeholder="Seleccione" readonly="readonly"/>
                </div>

                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input ffinal" placeholder="Seleccione" readonly="readonly" />
                </div>
                   
                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                <button type="button" class="btn btn-relief-primary data-submit cargarEntregas me-1"> <i data-feather='search'></i> Consultar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de devolución -->
<div class="modal fade" id="modalDevolucion" tabindex="-1" aria-labelledby="modalDevolucionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDevolucionLabel">Devolución de Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="devolucionFactNum" class="form-label">Número de Factura:</label>
                    <div class="form-control-plaintext" id="devolucionFactNum"></div>
                </div>
                <div class="mb-3">
                    <label for="motivoDevolucion" class="form-label">Motivo de la devolución:</label>
                    <textarea class="form-control" id="motivoDevolucion" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="confirmarDevolucion">Confirmar Devolución</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminación -->
<div class="modal fade" id="modalEliminacion" tabindex="-1" aria-labelledby="modalEliminacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminacionLabel">Eliminación de Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="eliminacionFactNum" class="form-label">Número de Factura:</label>
                    <div class="form-control-plaintext" id="eliminacionFactNum"></div>
                </div>
                <div class="mb-3">
                    <label for="motivoEliminacion" class="form-label">Motivo de la eliminación:</label>
                    <textarea class="form-control" id="motivoEliminacion" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminacion">Confirmar Eliminación</button>
            </div>
        </div>
    </div>
</div>

<!-- Los modales de exportación y ficha se añadirán dinámicamente desde JavaScript -->