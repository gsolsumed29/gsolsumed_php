<div class="app-content content" id="seccion_retenciones_iva">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Gestión de Retenciones</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item active">Comprobantes de Retención</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="retenciones-list">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Listado de Comprobantes</h4>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-primary btn-sm me-1" id="btn-export-ret">
                                <i data-feather="share"></i> Exportar
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" id="btn-sync-retenciones">
                                <i data-feather="refresh-cw"></i> Sincronizar DB
                            </button>
                        </div>
                    </div>

                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped w-100" id="tabla-maestra-retenciones">
                                <thead class="table-light">
                                    <tr>
                                        <th># Comprobante</th>
                                        <th>Fecha Doc.</th>
                                        <th>Razón Social</th>
                                        <th>RIF / ID</th>
                                        <th class="text-end">Monto Factura</th>
                                        <th class="text-end">Retención (USD)</th>
                                        <th class="text-center">Estado DB</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>