  <!-- BEGIN: Content-->
  <div class="app-content content documentos" id ="documentos">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Facturas </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Facturas Pendientes
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
                 <ul class="nav nav-tabs nav-tabs-custom" id="mainTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="facturas-tab" data-bs-toggle="tab" data-bs-target="#facturas" type="button">
                            <i data-feather="file-text"></i> Facturas
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="notas-tab" data-bs-toggle="tab" data-bs-target="#notas" type="button">
                            <i data-feather="truck"></i> Notas de entrega
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="devoluciones-tab" data-bs-toggle="tab" data-bs-target="#devoluciones" type="button">
                            <i data-feather="rotate-ccw"></i> Devoluciones
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="ncr-tab" data-bs-toggle="tab" data-bs-target="#ncr" type="button">
                            <i data-feather="minus-circle"></i> N/CR
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="ndb-tab" data-bs-toggle="tab" data-bs-target="#ndb" type="button">
                            <i data-feather="plus-circle"></i> N/DB
                        </button>
                    </li>
                </ul>

<div class="card mt-2">
    <div class="card-body">
        <div class="table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div>
                    </div>
                <div class="d-flex align-items-center">
                    <small class=" me-2">Sincronizado hace: <span id="timer-count">0s</span></small>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn-refresh-data">
                        <i data-feather="refresh-cw" class="me-25"></i>
                        Actualizar ahora
                    </button>
                </div>
            </div>
            <table class="table table-hover dataTableFacturas w-100">
                <thead>
                    <tr>
                        <th></th> 
                        <th>N° Documento</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Monto (USD)</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
    </div>
</div>
        
                </div>
             

            </div>
        </div>
    </div>
    <!-- END: Content-->