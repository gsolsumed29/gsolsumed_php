<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Detalles del Embarque</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item"><a href="index.php?view=embarcos">Embarques</a></li>
                                <li class="breadcrumb-item active">Detalles</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-3 col-12 mb-2">
                <div class="dropdown me-1">
                  
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Vista Detallada del Embarque</h5>
                                <div>
                                    <!-- Botones para cambiar el estado del embarque -->
                                    <a class="btn btn-sm btn-success "  href ="../admin/index.php?action=reporte&tipo=7&embarque_id=<?php echo $id =$_GET['id'];?>" target="_blank">imprimir</a>
                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- ID del Embarque (oculto pero accesible para JavaScript) -->
                                <small id="idEmbarque" style="display: none;"><?php echo $id =$_GET['id'];?></small>
                                
                                <!-- Información General del Embarque -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-section">
                                            <h6 class="text-primary mb-3">Información del Embarque</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>ID del Embarque:</strong></p>
                                                    <p class="mb-1"><strong>Fecha de Carga:</strong></p>
                                                    <p class="mb-1"><strong>Estatus:</strong></p>
                                                    <p class="mb-1"><strong>Zona:</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1" id="embarqueId">EMB-2023-001</p>
                                                    <p class="mb-1" id="embarqueFecha">15/06/2023 08:30 AM</p>
                                                    <p class="mb-1" id="embarqueEstatus">
                                                        <span class="badge bg-success status-badge">En Ruta</span>
                                                    </p>
                                                    <p class="mb-1" id="embarqueZona">Centro</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-section">
                                            <h6 class="text-primary mb-3">Vehículo y Personal</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Vehículo:</strong></p>
                                                    <p class="mb-1"><strong>Chofer:</strong></p>
                                                    <p class="mb-1"><strong>Ayudante:</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1" id="embarqueVehiculo">0</p>
                                                    <p class="mb-1" id="embarqueChofer">0</p>
                                                    <p class="mb-1" id="embarqueAyudante">0</p>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Estadísticas del Embarque -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="info-section">
                                            <h6 class="text-primary mb-3">Estadísticas del Embarque</h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card bg-light">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title" id="estadisticaTotalLotes">0</h5>
                                                            <p class="card-text">Total de Lotes</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card bg-light">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title" id="estadisticaTotalPaquetes">0</h5>
                                                            <p class="card-text">Total de Paquetes</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card bg-light">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title" id="estadisticaLotesEntregados">0</h5>
                                                            <p class="card-text">Lotes Entregados</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         

                                <!-- Lista de Lotes -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="info-section">
                                            <h6 class="text-primary mb-3">Lista de Lotes</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="tablaLotesEmbarque">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Lote</th>
                                                            <th>Descripción</th>
                                                            <th>Cantidad de Bultos</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
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

                             
                                <!-- Lista de Facturas Asociadas -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="info-section">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-primary mb-0">Facturas Asociadas</h6>
                                                <h6 class="mb-0">
                                                    Total General: <span id="totalFacturasEmbarque" class="text-success fw-bold">$0.00</span>
                                                </h6>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="tablaFacturasEmbarque">
                                                    <thead>
                                                        <tr>
                                                            <th>N° Factura</th>
                                                            <th>Cliente</th>
                                                            <th class="text-end">Total Neto</th>
                                                            <th>Fecha Emisión</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="6" class="text-center">
                                                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                                    <span class="visually-hidden">Cargando...</span>
                                                                </div>
                                                                Cargando facturas...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>