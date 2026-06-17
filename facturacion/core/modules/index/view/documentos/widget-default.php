<div class="app-content content" id="fiscales_enviados">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Historial Fiscal</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item active">Documentos Enviados / Fiscalizados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <div class="row">
                <ul class="nav nav-tabs nav-tabs-custom" id="fiscalTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active tab-fiscal-link" data-tipo-doc="1" id="f-tab" data-bs-toggle="tab" data-bs-target="#tab-area" type="button">
                            <i data-feather="check-circle"></i> Facturas Fiscales
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link tab-fiscal-link" data-tipo-doc="2" id="n-tab" data-bs-toggle="tab" data-bs-target="#tab-area" type="button">
                            <i data-feather="package"></i> Notas Enviadas
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link tab-fiscal-link" data-tipo-doc="3" id="d-tab" data-bs-toggle="tab" data-bs-target="#tab-area" type="button">
                            <i data-feather="rotate-cw"></i> Devoluciones Proc.
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link tab-fiscal-link" data-tipo-doc="4" id="c-tab" data-bs-toggle="tab" data-bs-target="#tab-area" type="button">
                            <i data-feather="file-minus"></i> N/CR Emitidas
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link tab-fiscal-link" data-tipo-doc="5" id="db-tab" data-bs-toggle="tab" data-bs-target="#tab-area" type="button">
                            <i data-feather="file-plus"></i> N/DB Emitidas
                        </button>
                    </li>
                </ul>

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="table-responsive">

                        
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <h4 class="card-title mb-0">Listado de Documentos Procesados</h4>
                                </div>
                                <div class="d-flex align-items-center">
                                    <small class="me-2 text-muted">Ult. Consulta: <span id="timer-fiscal-info" class="fw-bold">0s</span></small>
                                    <button type="button" class="btn btn-primary btn-sm  bg-light-primary rounded-pill" id="btn-update-fiscal">
                                        <i data-feather="refresh-ccw" class="me-25"></i>
                                        Sincronizar Historial
                                    </button>
                                </div>
                            </div>

                            <table class="table table-hover tabla-maestra-fiscalizados w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>N° Doc</th>
                                        <th>Cliente / Razón Social</th>
                                        <th>Fecha Emisión</th>
                                        <th>N° Control Fiscal</th>
                                        <th class="text-end">Monto (USD)</th>
                                        <th class="text-center">Gestión Fiscal</th>
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