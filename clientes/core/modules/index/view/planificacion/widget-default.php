    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Full calendar start -->
                <section>
                    <div class="app-calendar overflow-hidden border">
                        <div class="row g-0">
                            <!-- Sidebar -->
                            <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                                <div class="sidebar-wrapper">
                                    <div class="card-body d-flex justify-content-center">
                                        <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal" data-bs-target="#add-new-sidebar">
                                            <span class="align-middle">Agregar visita</span>
                                        </button>
                                    </div>
                                 
                                </div>
                                <div class="mt-auto">
                                    <img src="../app-assets/images/pages/calendar-illustration.png" alt="Calendar illustration" class="img-fluid" />
                                </div>
                            </div>
                            <!-- /Sidebar -->

                            <!-- Calendar -->
                            <div class="col position-relative">
                                <div class="card shadow-none border-0 mb-0 rounded-0">
                                    <div class="card-body pb-0">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar -->
                            <div class="body-content-overlay"></div>
                        </div>
                    </div>
                <!-- Calendar Add/Update/Delete event modal-->
<div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">Datos de la visita</h5>
            </div>
            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                <form class="event-form needs-validation" data-ajax="false" novalidate>
                    <div class="mb-1 d-none ">
                        <label for="title" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Event Title" value="N/A" required />
                    </div>
                    <div class="mb-1">
                        <label for="select-label" class="form-label">Dirijido a </label>
                        <select class="select2 select-label form-select w-100" id="select-label" name="select-label">
                            <option data-label="primary" value="0" selected>Seleccione...</option>
                            <option data-label="primary" value="1" >Clientes</option>
                            <option data-label="danger" value="2">Candidatos</option>
                        </select>
                    </div>

                    <!-- Contenedor para los campos que aparecerán dinámicamente -->
                    <div id="dynamic-fields-container" class="mb-1">
                        <!-- Campo para CANDIDATOS (inicialmente oculto) -->
                        <div id="cantidad-container" class="d-none">
                            <label for="cantidad" class="form-label">Número de Candidatos</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ej: 5" />
                        </div>

                        <!-- Campo para CLIENTES (inicialmente oculto) -->
                        <div id="cliente-container" class="d-none">
                            <label for="select-cliente" class="form-label">Seleccionar Cliente</label>
                            <select class="select2 form-select" id="select-cliente" name="select-cliente" data-placeholder="Seleccione...." multiple="multiple">
                                <!-- Las opciones se cargarán aquí con AJAX -->
                            </select>
                        </div>
                    </div>

                    <div class="mb-1 position-relative">
                        <label for="start-date" class="form-label">Día</label>
                        <input type="text" class="form-control" id="start-date" name="start-date" placeholder="" />
                    </div>
                    <div class="mb-1 position-relative d-none">
                        <label for="end-date" class="form-label">Fin</label>
                        <input type="text" class="form-control" id="end-date" name="end-date" placeholder="End Date" />
                    </div>
          
                    <div class="mb-1">
                        <label class="form-label">Description</label>
                        <textarea name="event-description-editor" id="event-description-editor" class="form-control"></textarea>
                    </div>
                    <div class="mb-1 d-flex">
                        <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancel</button>
                        <button type="submit" class="btn btn-primary add-event-btn me-1"> <i data-feather='save'></i>  Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Calendar Add/Update/Delete event modal-->
                </section>
                <!-- Full calendar end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- Modal para mostrar detalles del evento -->
<div class="modal fade" id="viewEventModal" tabindex="-1" role="dialog" aria-labelledby="viewEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewEventModalLabel">Detalles del Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="viewTitle">Título:</label>
              <p id="viewTitle" class="form-control-plaintext"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="viewType">Tipo:</label>
              <p id="viewType" class="form-control-plaintext"></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="viewStartDate">Fecha :</label>
              <p id="viewStartDate" class="form-control-plaintext"></p>
            </div>
          </div>
          <div class="col-md-6 d-none">
            <div class="form-group">
              <label for="viewEndDate">Fecha de fin:</label>
              <p id="viewEndDate" class="form-control-plaintext"></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 d-none">
            <div class="form-group">
              <label for="viewLocation">Ubicación:</label>
              <p id="viewLocation" class="form-control-plaintext"></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="viewDescription">Descripción:</label>
              <p id="viewDescription" class="form-control-plaintext"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i data-feather='x-circle'></i> Cerrar</button>
        <button type="button" class="btn btn-success" id="shareWhatsAppBtn">
          <i data-feather='send'></i> Compartir
        </button>
    
      </div>
    </div>
  </div>
</div>