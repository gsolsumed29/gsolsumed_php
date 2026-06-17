<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solsumed, CA</title>
        <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logo_solo.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
            padding-bottom: 50px;
        }
        
        .header {
            background: linear-gradient(135deg, #1750a7 0%, #2b5da6 100%);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border: none;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #1750a7 0%, #2b5da6 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: white;
        }
        
        .btn-action {
            margin: 0 3px;
            padding: 5px 10px;
            font-size: 0.85rem;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            border-top: none;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-1 {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-0 {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box .form-control {
            padding-left: 40px;
            border-radius: 25px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        
        .page-link {
            border: none;
            color: #667eea;
            margin: 0 3px;
            border-radius: 5px;
        }
        
        .page-item.active .page-link {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .summary-card {
            background: linear-gradient(135deg, #1750a7 0%, #4c6fa2 100%);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .summary-card h6 {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .summary-card h5 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #1750a7 0%, #4c6fa2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .floating-btn:hover {
            transform: scale(1.1);
            color: white;
        }
        
        /* ESTILOS NUEVOS PARA REMOVER SPINNERS DE INPUTS NUMÉRICOS */
        
        /* Para Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        /* Para Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
        
        /* Para todos los navegadores - solución universal */
        .no-spinner {
            -moz-appearance: textfield;
        }
        
        .no-spinner::-webkit-outer-spin-button,
        .no-spinner::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        /* Mejorar la apariencia de los campos sin spinners */
        .monto-input {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: 500;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        
        .monto-input:focus {
            background-color: #fff;
            border-color: #1750a7;
            box-shadow: 0 0 0 0.2rem rgba(23, 80, 167, 0.25);
        }
        
        /* Estilo para los campos de monto en la tabla */
        .monto-cell {
            font-family: 'Courier New', monospace;
            font-weight: 500;
            color: #2c3e50;
        }
        
        /* Estilo para resaltar los montos importantes */
        .monto-total {
            font-weight: 600;
            color: #1750a7;
            font-size: 1.1em;
        }
        
        /* Estilo para los campos de monto en los modales */
        .monto-group {
            position: relative;
        }
        
        .monto-group .currency-symbol {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #495057;
            pointer-events: none;
            z-index: 5;
        }
        
        .monto-group .form-control {
            padding-left: 30px;
        }
        
        /* Para campos de dólares */
        .usd-group .currency-symbol {
            color: #28a745;
        }
        
        /* Para campos de bolívares */
        .bs-group .currency-symbol {
            color: #1750a7;
        }

        /* Agregar al final de tu CSS existente */
@media print {
    body * {
        visibility: hidden;
    }
    
    #detalleRegistroModal,
    #detalleRegistroModal * {
        visibility: visible;
    }
    
    #detalleRegistroModal {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 100%;
    }
    
    .modal-footer,
    .btn-close {
        display: none !important;
    }
    
    .modal-header {
        border-bottom: 2px solid #1750a7 !important;
    }
    
    .modal-body {
        padding: 20px !important;
    }
    
    .table {
        border: 1px solid #dee2e6 !important;
    }
    
    .table th,
    .table td {
        border: 1px solid #dee2e6 !important;
    }
}

/* Estilo para el botón de imprimir */
.btn-print {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 5px;
    transition: all 0.3s;
    margin-right: 10px;
}

.btn-print:hover {
    background: linear-gradient(135deg, #218838 0%, #1ba87e 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Agrega estos estilos al CSS existente */

/* Logo en el encabezado */
.logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 10px;
}

.company-logo {
    height: 60px;
    width: auto;
    object-fit: contain;
}

.company-name {
    font-size: 2.2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #ffffff 0%, #a8c6ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

/* Logo más pequeño para impresión */
.logo-print {
    height: 50px;
    width: auto;
    margin-bottom: 5px;
}

/* Logo en modal de detalles */
.logo-modal {
    height: 40px;
    width: auto;
    margin-right: 10px;
}
    </style>
</head>
<body>
    <div class="container">
            <!-- Reemplaza el encabezado actual con este -->
        <div class="header text-center">
            <div class="logo-container">
                <!-- Agrega tu logo aquí - reemplaza 'logo.png' con la ruta de tu imagen -->
               
                <div>
                    <h1 class="company-name">Solsumed, CA</h1>
                    <p class="lead mb-0">Gestión de registros de cajas</p>
                </div>
            </div>
        </div>
        
        <!-- Barra de herramientas -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por código de vendedor, turno...">
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                    <i class="fas fa-plus-circle"></i> Nuevo Registro
                </button>
            </div>
        </div>
        
        <!-- Resumen -->
        <div class="row mb-4 d-none">
            <div class="col-md-3">
                <div class="summary-card">
                    <h6>TOTAL Bs. EFECTIVO</h6>
                    <h5 id="totalEfectivo">0.00</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card">
                    <h6>TOTAL Bs. TRANSFERENCIAS</h6>
                    <h5 id="totalTransfer">0.00</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card">
                    <h6>TOTAL USD EFECTIVO</h6>
                    <h5 id="totalUsdEfectivo">0.00</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card">
                    <h6>REGISTROS ACTIVOS</h6>
                    <h5 id="totalRegistros">0</h5>
                </div>
            </div>
        </div>
        
        <!-- Tabla de registros -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Registros de Cajas
                <span class="badge bg-primary float-end" id="totalRegistrosBadge">0</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="registrosTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                                <th>Turno</th>
                                <th>Bs. Efectivo</th>
                                <th class="d-none">Bs. Transfer</th>
                                <th>Bs. Punto de venta</th>
                                <th>Bs. Biopago</th>
                                <th>USD Efectivo</th>
                                <th>USD Zelle</th>

                                <th>Cachea</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="registrosBody">
                            <!-- Los registros se cargarán aquí -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <nav aria-label="Page navigation">
                    <ul class="pagination" id="pagination">
                        <!-- La paginación se generará aquí -->
                    </ul>
                </nav>
            </div>
        </div>
        
        <!-- Botón flotante -->
        <button class="floating-btn" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    
    <!-- Modal para nuevo registro -->
    <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoRegistroModalLabel">
                        <i class="fas fa-plus-circle"></i> Nuevo Registro de Caja
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="nuevoRegistroForm">
                    <div class="modal-body">
                        <div class="row">
                            <!-- Agrega este campo para la clave -->
                        <div class="col-md-6 mb-3 d-none">
                            <label for="clave_vendedor" class="form-label">Clave del Vendedor</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="clave_vendedor" name="clave_vendedor" 
                                    placeholder="Clave se autocompletará" readonly>
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <div class="form-text">
                                <small>Clave del vendedor seleccionado (solo lectura)</small>
                            </div>
                        </div>
                           <div class="col-md-6 mb-3">
                                    <label for="co_ven" class="form-label">Código de Vendedor *</label>
                                       

                                    <div class="vendedor-select">
                                        <select class="form-select" id="co_ven" name="co_ven" required>
                                            <option value="">Cargando vendedores...</option>
                                        </select>
                                        <div class="loading-spinner d-none">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    <div class="form-text">
                                        <small>Seleccione un vendedor de la lista</small>
                                    </div>
                                </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha *</label>
                                <input type="datetime-local" class="form-control" id="fecha" name="fecha" required disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="turno" class="form-label">Turno *</label>
                                <select class="form-select" id="turno" name="turno" required>
                                    <option value="">Seleccionar turno</option>
                                    <option value="MAÑANA">MAÑANA</option>
                                    <option value="TARDE">TARDE</option>
                                    <option value="NOCHE">NOCHE</option>
                                    <option value="COMPLETO">COMPLETO</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-none">
                                <label for="estatus" class="form-label">Estado *</label>
                                <select class="form-select" id="estatus" name="estatus" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <h6 class="mb-3"><i class="fas fa-money-bill-wave"></i> Montos en Bolívares</h6>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="monto-group bs-group">
                                    <span class="currency-symbol">Bs</span>
                                    <label for="monto_bs_efectivo" class="form-label">Efectivo</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="monto_bs_efectivo" name="monto_bs_efectivo" value="0.00" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="monto-group bs-group">
                                    <span class="currency-symbol">Bs</span>
                                    <label for="monto_bs_transf" class="form-label">Transferencia</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="monto_bs_transf" name="monto_bs_transf" value="0.00" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="monto-group bs-group">
                                    <span class="currency-symbol">Bs</span>
                                    <label for="monto_bs_bio" class="form-label">Punto de venta</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="monto_bs_bio" name="monto_bs_bio" value="0.00" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="monto-group bs-group">
                                    <span class="currency-symbol">Bs</span>
                                    <label for="monto_bs_pago_movil" class="form-label">Biopago</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="monto_bs_pago_movil" name="monto_bs_pago_movil" value="0.00" placeholder="0.00">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <h6 class="mb-3"><i class="fas fa-dollar-sign"></i> Montos en Dólares</h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="monto-group usd-group">
                                    <span class="currency-symbol">$</span>
                                    <label for="monto_usd_efectivo" class="form-label">Efectivo</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="monto_usd_efectivo" name="monto_usd_efectivo" value="0.00" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="monto-group usd-group">
                                    <span class="currency-symbol">$</span>
                                    <label for="monto_usd_zeller" class="form-label">Zelle</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="monto_usd_zeller" name="monto_usd_zeller" value="0.00" placeholder="0.00">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <h6 class="mb-3"><i class="fas fa-sticky-note"></i> Campos Adicionales</h6>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="campo1" class="form-label">Egresos de caja</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner"  id="campo1" name="campo1" value="0.00" placeholder="0.00">
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="monto-group usd-group">
                                    <span class="currency-symbol">$</span>
                                    <label for="monto_usd_zeller" class="form-label">Cashea</label>
                                    <input type="number" step="0.01" class="form-control monto-input no-spinner" id="campo2" name="campo2" value="0.00" placeholder="0.00">
                                </div>
                               
                            </div>
                            <div class="col-md-4 mb-3 d-none">
                                <label for="campo3" class="form-label">Campo 3</label>
                                <input type="text" class="form-control" id="campo3" name="campo3">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">
                            <i class="fas fa-save"></i> Guardar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para verificar identidad del vendedor -->
<div class="modal fade" id="verificarVendedorModal" tabindex="-1" aria-labelledby="verificarVendedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="verificarVendedorModalLabel">
                    <i class="fas fa-user-shield"></i> Verificar Identidad del Vendedor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-lock fa-3x text-warning mb-3"></i>
                    <h5>Verificación de Identidad Requerida</h5>
                    <p class="text-muted">Ingrese la clave del vendedor para continuar</p>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Se requiere confirmar la identidad del vendedor antes de guardar los datos.
                </div>
                
                <div class="mb-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Vendedor a Verificar:</h6>
                            <p class="mb-1"><strong id="vendedorNombreVerificar">-</strong></p>
                            <p class="mb-0"><small>Código: <span id="vendedorCodigoVerificar">-</span></small></p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="claveVerificacion" class="form-label">
                        <i class="fas fa-key"></i> Clave del Vendedor *
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="claveVerificacion" 
                               placeholder="Ingrese la clave del vendedor" autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="toggleClave">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">
                        <small>Ingrese la clave asignada al vendedor seleccionado</small>
                    </div>
                </div>
                
                <div id="errorVerificacion" class="alert alert-danger d-none">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <span id="errorVerificacionTexto">La clave ingresada es incorrecta.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning" id="btnVerificarVendedor">
                    <i class="fas fa-check"></i> Verificar y Continuar
                </button>
            </div>
        </div>
    </div>
</div>
    
    <!-- Modal para editar registro -->
    <div class="modal fade" id="editarRegistroModal" tabindex="-1" aria-labelledby="editarRegistroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarRegistroModalLabel">
                        <i class="fas fa-edit"></i> Editar Registro de Caja
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editarRegistroForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <!-- Los campos se llenarán con JavaScript -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">
                            <i class="fas fa-save"></i> Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal para ver detalles -->
    <div class="modal fade" id="detalleRegistroModal" tabindex="-1" aria-labelledby="detalleRegistroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleRegistroModalLabel">
                        <i class="fas fa-eye"></i> Detalles del Registro
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detalleRegistroBody">
                    <!-- Los detalles se cargarán aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
                  // Variables globales
    let currentPage = 1;
    const recordsPerPage = 10;
    let totalRecords = 0;
    let allRecords = [];

    // Agrega estas variables al inicio de tu script
let vendedorSeleccionado = null;
let accionPendiente = null; // 'crear' o 'editar'
let registroIdPendiente = null; // para edición


    $(document).ready(function() {

    
        // Cargar registros al iniciar
        cargarRegistros();

        cargarVendedores();
        

 // Modificar el evento submit del formulario de nuevo registro
    $('#nuevoRegistroForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        verificarIdentidadVendedor('crear');
    });
    
    // Configurar evento para el botón de verificación
    $('#btnVerificarVendedor').off('click').on('click', function() {
        const claveIngresada = $('#claveVerificacion').val().trim();
        
        if (!claveIngresada) {
            $('#errorVerificacionTexto').text('Debe ingresar la clave del vendedor.');
            $('#errorVerificacion').removeClass('d-none');
            return;
        }
        
        if (validarClaveIngresada(claveIngresada)) {
            // Verificación exitosa
            $('#errorVerificacion').addClass('d-none');
            $('#verificarVendedorModal').modal('hide');
            
            // Ejecutar acción pendiente
            ejecutarAccionPendiente(accionPendiente, registroIdPendiente);
        } else {
            // Verificación fallida
            $('#errorVerificacionTexto').text('La clave ingresada no corresponde al vendedor seleccionado.');
            $('#errorVerificacion').removeClass('d-none');
            $('#claveVerificacion').val('').focus();
            
            // Animación de error
            $('#claveVerificacion').addClass('is-invalid');
            setTimeout(() => {
                $('#claveVerificacion').removeClass('is-invalid');
            }, 2000);
        }
    });
    
    // Toggle para mostrar/ocultar clave
    $('#toggleClave').off('click').on('click', function() {
        const input = $('#claveVerificacion');
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    // Permitir Enter en el campo de clave
    $('#claveVerificacion').off('keypress').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#btnVerificarVendedor').click();
        }
    });
    
    // Limpiar errores al cambiar el valor
    $('#claveVerificacion').off('input').on('input', function() {
        $('#errorVerificacion').addClass('d-none');
    });
 
    
        // Llamar a la función para configurar la fecha
        configurarFechaActual();
        
        // También puedes agregar un botón para restablecer la fecha actual
        $(document).on('click', '.btn-fecha-actual', function() {
            configurarFechaActual();
        });
        
        // Buscar registros
        $('#searchInput').on('keyup', function() {
            currentPage = 1;
            cargarRegistros();
        });
        
          // MODIFICAR ESTE EVENTO:
    $('#nuevoRegistroForm').on('submit', function(e) {
        e.preventDefault(); // Prevenir envío automático
        crearRegistro(); // Llamar a nuestra función de validación y verificación
    });
        
        // Cuando se cierra el modal, restablecer la fecha actual
        $('#nuevoRegistroModal').on('hidden.bs.modal', function() {
            configurarFechaActual();
        });
        
            
        
            
            // Mejorar la experiencia de usuario en los campos de monto
            $('body').on('focus', '.monto-input', function() {
                $(this).select();
            });
            
            // Formatear montos al salir del campo
            $('body').on('blur', '.monto-input', function() {
                let value = $(this).val();
                if (value && !isNaN(value)) {
                    value = parseFloat(value).toFixed(2);
                    $(this).val(value);
                }
            });
    });


    
     //// Función para cargar lista de vendedores desde la base de datos
function cargarVendedores() {
    const $select = $('#co_ven');
    const $claveField = $('#clave_vendedor'); // Campo para la clave
    const $loading = $('.vendedor-select .loading-spinner');
    
    // Mostrar indicador de carga
    $loading.removeClass('d-none');
    $select.prop('disabled', true);
    
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=getVendedores',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $loading.addClass('d-none');
            $select.prop('disabled', false);
            
            if (response.success && response.data && response.data.length > 0) {
                vendedoresList = response.data;
                
                // Limpiar y llenar el select
                $select.empty();
                $select.append('<option value="">Seleccione un vendedor...</option>');
                
                // Ordenar alfabéticamente por nombre (ven_des)
                vendedoresList.sort((a, b) => {
                    const nombreA = (a.ven_des || '').toUpperCase();
                    const nombreB = (b.ven_des || '').toUpperCase();
                    if (nombreA < nombreB) return -1;
                    if (nombreA > nombreB) return 1;
                    return 0;
                });
                
                // Agregar opciones con data-clave
                vendedoresList.forEach(function(vendedor) {
                    $select.append(`<option value="${vendedor.co_ven}" data-clave="${vendedor.clave || ''}">${vendedor.ven_des}</option>`);
                });
                
                // Configurar evento para cuando cambie la selección
                $select.off('change').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const clave = selectedOption.data('clave') || '';
                    
                    // Actualizar campo de clave
                    if (clave) {
                        $claveField.val(clave);
                        $claveField.removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $claveField.val('Sin clave');
                        $claveField.removeClass('is-valid is-invalid');
                    }
                });
                
            } else {
                $select.empty();
                $select.append('<option value="">No hay vendedores disponibles</option>');
                console.error('No se pudieron cargar los vendedores:', response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $loading.addClass('d-none');
            $select.prop('disabled', false);
            $select.empty();
            $select.append('<option value="">Error al cargar vendedores</option>');
            console.error('Error al cargar vendedores:', textStatus, errorThrown);
        }
    });
}
       // Configurar fecha actual - FORMATO CORREGIDO
    function configurarFechaActual() {
        const now = new Date();
        
        // Obtener la fecha y hora en formato local para Venezuela
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        // Formato: YYYY-MM-DDTHH:MM (requerido por datetime-local)
        const localDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        
        // Establecer la fecha en el campo de fecha
        $('#fecha').val(localDateTime);
        
        // También establecer la fecha en el modal de edición cuando se abra
        $(document).on('show.bs.modal', '#editarRegistroModal', function() {
            // Solo si el modal está vacío (para nuevo registro)
            if (!$('#edit_fecha').val()) {
                $('#edit_fecha').val(localDateTime);
            }
        });
    }
    // Funciones globales
    function cambiarPagina(page) {
        currentPage = page;
        mostrarRegistrosPagina(page);
        actualizarPaginacion();
    }

     // Función para cargar registros (versión adaptativa)
        function cargarRegistros() {
            const searchTerm = $('#searchInput').val();
            
            $.ajax({
                url: 'admin/index.php?action=cajas&accion=read&search=' + encodeURIComponent(searchTerm),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let records = [];
                    let isSuccess = false;

                    // Comprueba si la respuesta tiene la estructura esperada {success: true, data: [...]}
                    if (response && typeof response === 'object' && response.hasOwnProperty('success')) {
                        if (response.success) {
                            records = response.data || [];
                            isSuccess = true;
                        } else {
                            // El servidor devolvió un error explícito
                            Swal.fire('Error', response.message || 'Error del servidor', 'error');
                        }
                    } 
                    // Si no, asume que la respuesta es directamente el array de datos
                    else if (Array.isArray(response)) {
                        records = response;
                        isSuccess = true;
                    }
                    else {
                        console.error("Respuesta inesperada del servidor:", response);
                        Swal.fire('Error', 'La respuesta del servidor no es válida.', 'error');
                    }

                    if (isSuccess) {
                        allRecords = records;
                        totalRecords = allRecords.length;
                        
                        actualizarResumen(allRecords);
                        mostrarRegistrosPagina(currentPage);
                        actualizarPaginacion();
                        
                        $('#totalRegistrosBadge').text(totalRecords);
                        $('#totalRegistros').text(totalRecords);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    Swal.fire('Error', 'Error al conectar con el servidor: ' + textStatus, 'error');
                }
            });
        }
        
        // Función para mostrar registros de una página específica
        function mostrarRegistrosPagina(page) {
            const startIndex = (page - 1) * recordsPerPage;
            const endIndex = startIndex + recordsPerPage;
            const pageRecords = allRecords.slice(startIndex, endIndex);
            
            const tbody = $('#registrosBody');
            tbody.empty();
            
            if (pageRecords.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="12" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                            <p class="text-muted">No se encontraron registros</p>
                        </td>
                    </tr>
                `);
                return;
            }
            
            pageRecords.forEach(registro => {
                const fechaFormateada = registro.fecha ? new Date(registro.fecha).toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '';
                
                const row = `
                    <tr>
                        <td>${registro.id}</td>
                        <td><strong>${registro.co_ven || ''} ${registro.ven_des || ''}</strong></td>
                        <td>${fechaFormateada}</td>
                        <td><span class="badge bg-info">${registro.turno || ''}</span></td>
                        <td class="text-end monto-cell">${formatCurrency(registro.monto_bs_efectivo)}</td>
                        <td class="text-end monto-cell ">${formatCurrency(registro.monto_bs_transf)}</td>
                        <td class="text-end monto-cell">${formatCurrency(registro.monto_bs_bio)}</td>
                        <td class="text-end monto-cell">${formatCurrency(registro.monto_bs_pago_movil)}</td>
                        <td class="text-end monto-cell">${formatCurrency(registro.monto_usd_efectivo, 'USD')}</td>
                        <td class="text-end monto-cell">${formatCurrency(registro.monto_usd_zeller, 'USD')}</td>
                        <td class="text-end monto-cell">${formatCurrency(registro.campo2, 'USD')}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info btn-action" onclick="verDetalle(${registro.id})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editarRegistro(${registro.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                           
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion() {
            const totalPages = Math.ceil(totalRecords / recordsPerPage);
            const pagination = $('#pagination');
            pagination.empty();
            
            if (totalPages <= 1) return;
            
            // Botón anterior
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            pagination.append(`
                <li class="page-item ${prevDisabled}">
                    <a class="page-link" href="#" onclick="cambiarPagina(${currentPage - 1})" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Números de página
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const active = i === currentPage ? 'active' : '';
                pagination.append(`
                    <li class="page-item ${active}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
                    </li>
                `);
            }
            
            // Botón siguiente
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            pagination.append(`
                <li class="page-item ${nextDisabled}">
                    <a class="page-link" href="#" onclick="cambiarPagina(${currentPage + 1})" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);
        }
        
        // Función para actualizar resumen
        function actualizarResumen(registros) {
            let totalEfectivo = 0;
            let totalTransfer = 0;
            let totalUsdEfectivo = 0;
            
            registros.forEach(registro => {
                totalEfectivo += parseFloat(registro.monto_bs_efectivo) || 0;
                totalTransfer += parseFloat(registro.monto_bs_transf) || 0;
                totalUsdEfectivo += parseFloat(registro.monto_usd_efectivo) || 0;
            });
            
            $('#totalEfectivo').text(formatCurrency(totalEfectivo));
            $('#totalTransfer').text(formatCurrency(totalTransfer));
            $('#totalUsdEfectivo').text(formatCurrency(totalUsdEfectivo, 'USD'));
        }

        
      // Reemplaza la función crearRegistro existente con esta:
function crearRegistro() {
    // Validar formulario primero
    if (!validarFormularioNuevo()) {
        return;
    }
    
    // Obtener datos del vendedor seleccionado
    const selectedOption = $('#co_ven option:selected');
    const vendedorId = selectedOption.val();
    const vendedorNombre = selectedOption.text();
    const vendedorCodigo = selectedOption.val();
    const claveCorrecta = selectedOption.data('clave') || '';
    const cedulaCorrecta = selectedOption.data('cedula') || '';
    
    // Validar que se haya seleccionado un vendedor
    if (!vendedorId) {
        Swal.fire('Error', 'Debe seleccionar un vendedor primero', 'error');
        return;
    }
    
    // Verificar si el vendedor requiere autenticación
    if (!claveCorrecta && !cedulaCorrecta) {
        // No tiene clave configurada, guardar directamente
        guardarRegistroDirecto();
        return;
    }
    
    // Guardar información para la verificación
    vendedorSeleccionado = {
        id: vendedorId,
        nombre: vendedorNombre,
        codigo: vendedorCodigo,
        claveCorrecta: claveCorrecta,
        cedulaCorrecta: cedulaCorrecta
    };
    
    accionPendiente = 'crear';
    
    // Configurar el modal de verificación
    $('#vendedorNombreVerificar').text(vendedorNombre);
    $('#vendedorCodigoVerificar').text(vendedorCodigo);
    $('#claveVerificacion').val('');
    $('#errorVerificacion').addClass('d-none');
    
    // Mostrar modal de verificación
    $('#verificarVendedorModal').modal('show');
}


// Función para guardar registro después de verificación exitosa
function guardarRegistroDirecto() {
    const formData = $('#nuevoRegistroForm').serialize();
    
    // Mostrar loading
    Swal.fire({
        title: 'Guardando registro...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=create',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            Swal.close();
            
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Registro creado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                $('#nuevoRegistroModal').modal('hide');
                $('#nuevoRegistroForm')[0].reset();
                configurarFechaActual(); // Restablecer fecha
                cargarRegistros();
            } else {
                Swal.fire('Error', response.message || 'Error al crear registro', 'error');
            }
        },
        error: function() {
            Swal.close();
            Swal.fire('Error', 'Error al conectar con el servidor', 'error');
        }
    });
}

// Nueva función para validar formulario
function validarFormularioNuevo() {
    // Validar campos requeridos
    const camposRequeridos = [
        { id: '#co_ven', nombre: 'Código de Vendedor' },
        { id: '#turno', nombre: 'Turno' },
        { id: '#fecha', nombre: 'Fecha' }
    ];
    
    for (const campo of camposRequeridos) {
        const valor = $(campo.id).val();
        if (!valor || valor.trim() === '') {
            Swal.fire('Error', `El campo "${campo.nombre}" es requerido`, 'error');
            $(campo.id).focus();
            return false;
        }
    }
    
    return true;
}
        
       
    
function verDetalle(id) {
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=read&id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                const registro = response.data[0];
                const fechaFormateada = registro.fecha ? new Date(registro.fecha).toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '';
                
                const fechaCorta = registro.fecha ? new Date(registro.fecha).toLocaleDateString('es-ES') : '';
                
                // Obtener el nombre del vendedor si está disponible en la lista
                let nombreVendedor = 'N/A';
                if (window.vendedoresList && window.vendedoresList.length > 0) {
                    const vendedor = window.vendedoresList.find(v => 
                        (v.co_ven || v.codigo || v) === registro.co_ven
                    );
                    if (vendedor) {
                        nombreVendedor = vendedor.ven_des || vendedor.nombre || vendedor;
                    }
                }
                
                // Calcular totales
                const totalBs = (parseFloat(registro.monto_bs_efectivo) || 0) +
                              (parseFloat(registro.monto_bs_transf) || 0) +
                              (parseFloat(registro.monto_bs_bio) || 0) +
                              (parseFloat(registro.monto_bs_pago_movil) || 0);
                
                const totalUsd = (parseFloat(registro.monto_usd_efectivo) || 0) +
                               (parseFloat(registro.monto_usd_zeller) || 0);
                
                // Preparar contenido para campos adicionales
                let camposAdicionalesHTML = '';
                let camposAdicionalesPrintHTML = '';
                
                // Verificar cada campo adicional
                const campos = [
                    { nombre: 'Egresos de caja', valor: registro.campo1, esMoneda: true },
                    { nombre: 'Cashea', valor: registro.campo2, esMoneda: true },
                    { nombre: 'Campo 3', valor: registro.campo3, esMoneda: false }
                ];
                
                // Filtrar solo campos que tienen valor
                const camposConValor = campos.filter(campo => campo.valor && campo.valor.toString().trim() !== '');
                
                if (camposConValor.length > 0) {
                    // HTML para modal normal
                    camposAdicionalesHTML = `
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-bold">Campos Adicionales:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                    `;
                    
                    // HTML para impresión
                    camposAdicionalesPrintHTML = `
                        <div style="margin-bottom: 20px;">
                            <h4 style="color: #1750a7; border-bottom: 2px solid #1750a7; padding-bottom: 5px;">
                                Campos Adicionales
                            </h4>
                            <table style="width: 100%; border-collapse: collapse;">
                    `;
                    
                    camposConValor.forEach(campo => {
                        const valorFormateado = campo.esMoneda ? 
                            formatCurrency(campo.valor, 'Bs') : 
                            campo.valor;
                        
                        camposAdicionalesHTML += `
                            <tr>
                                <td>${campo.nombre}:</td>
                                <td class="text-end ${campo.esMoneda ? 'fw-bold monto-total' : ''}">
                                    ${valorFormateado}
                                </td>
                            </tr>
                        `;
                        
                        camposAdicionalesPrintHTML += `
                            <tr>
                                <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                                    ${campo.nombre}:
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; ${campo.esMoneda ? 'font-weight: bold;' : ''}">
                                    ${valorFormateado}
                                </td>
                            </tr>
                        `;
                    });
                    
                    camposAdicionalesHTML += `
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    camposAdicionalesPrintHTML += `
                            </table>
                        </div>
                    `;
                }
                
                const contenido = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ID:</label>
                                <p>${registro.id}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Código de Vendedor:</label>
                                <p>${registro.co_ven || 'N/A'} - ${nombreVendedor}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha:</label>
                                <p>${fechaFormateada}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Turno:</label>
                                <p><span class="badge bg-info">${registro.turno || 'N/A'}</span></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado:</label>
                                <p><span class="status-badge status-${registro.estatus}">
                                    ${registro.estatus == 1 ? 'Activo' : 'Inactivo'}
                                </span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montos en Bolívares:</label>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Efectivo:</td>
                                            <td class="text-end fw-bold monto-total">${formatCurrency(registro.monto_bs_efectivo)}</td>
                                        </tr>
                                        <tr class="">
                                            <td>Transferencia:</td>
                                            <td class="text-end fw-bold monto-total">${formatCurrency(registro.monto_bs_transf)}</td>
                                        </tr>
                                        <tr>
                                            <td>Punto de venta:</td>
                                            <td class="text-end fw-bold monto-total">${formatCurrency(registro.monto_bs_bio)}</td>
                                        </tr>
                                        <tr>
                                            <td>Biopago:</td>
                                            <td class="text-end fw-bold monto-total">${formatCurrency(registro.monto_bs_pago_movil)}</td>
                                        </tr>
                                        <tr style="border-top: 2px solid #1750a7;">
                                            <td><strong>TOTAL Bs:</strong></td>
                                            <td class="text-end fw-bold" style="color: #1750a7; font-size: 1.1em;">
                                                ${formatCurrency(totalBs)}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montos en Dólares:</label>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Efectivo:</td>
                                            <td class="text-end fw-bold monto-total">${formatCurrency(registro.monto_usd_efectivo, 'USD')}</td>
                                        </tr>
                                        <tr>
                                            <td>Zelle:</td>
                                            <td class="text-end fw-bold monto-total">${formatCurrency(registro.monto_usd_zeller, 'USD')}</td>
                                        </tr>
                                        <tr style="border-top: 2px solid #28a745;">
                                            <td><strong>TOTAL USD:</strong></td>
                                            <td class="text-end fw-bold" style="color: #28a745; font-size: 1.1em;">
                                                ${formatCurrency(totalUsd, 'USD')}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mostrar campos adicionales si existen -->
                    ${camposAdicionalesHTML}
                    
                    <!-- Contenido oculto para impresión -->
                    <div id="print-content" class="d-none">
                        <div style="padding: 20px; font-family: Arial, sans-serif;">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <!-- Logo en impresión -->
                                    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                                       
                                        <div style="text-align: left;">
                                            <h2 style="color: #1750a7; margin: 0; font-size: 24px;">Solsumed, CA</h2>
                                            <h3 style="color: #333; margin: 0; font-size: 18px;">Comprobante de Relación de Caja</h3>
                                        </div>
                                    </div>
                                <hr style="border-color: #1750a7;">
                            </div>
                            
                            <div style="margin-bottom: 20px;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 50%; padding: 5px;">
                                            <strong>ID:</strong> ${registro.id}
                                        </td>
                                        <td style="width: 50%; padding: 5px; text-align: right;">
                                            <strong>Fecha:</strong> ${fechaCorta}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <strong>Vendedor:</strong> ${registro.co_ven || 'N/A'} - ${nombreVendedor}
                                        </td>
                                        <td style="padding: 5px; text-align: right;">
                                            <strong>Turno:</strong> ${registro.turno || 'N/A'}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <strong>Estado:</strong> ${registro.estatus == 1 ? 'Activo' : 'Inactivo'}
                                        </td>
                                        <td style="padding: 5px; text-align: right;">
                                            <strong>Generado:</strong> ${new Date().toLocaleDateString('es-ES', {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric'
                                            })}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div style="margin-bottom: 20px;">
                                <h4 style="color: #1750a7; border-bottom: 2px solid #1750a7; padding-bottom: 5px;">
                                    Montos en Bolívares
                                </h4>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Efectivo:</td>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; font-weight: bold;">
                                            ${formatCurrency(registro.monto_bs_efectivo)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Transferencia:</td>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; font-weight: bold;">
                                            ${formatCurrency(registro.monto_bs_transf)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Punto de venta:</td>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; font-weight: bold;">
                                            ${formatCurrency(registro.monto_bs_bio)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Biopago:</td>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; font-weight: bold;">
                                            ${formatCurrency(registro.monto_bs_pago_movil)}
                                        </td>
                                    </tr>
                                    <tr style="border-top: 2px solid #1750a7;">
                                        <td style="padding: 8px; font-weight: bold; color: #1750a7;">TOTAL Bs:</td>
                                        <td style="padding: 8px; text-align: right; font-weight: bold; color: #1750a7;">
                                            ${formatCurrency(totalBs)}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div style="margin-bottom: 20px;">
                                <h4 style="color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 5px;">
                                    Montos en Dólares
                                </h4>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Efectivo:</td>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; font-weight: bold;">
                                            ${formatCurrency(registro.monto_usd_efectivo, 'USD')}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Zelle:</td>
                                        <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right; font-weight: bold;">
                                            ${formatCurrency(registro.monto_usd_zeller, 'USD')}
                                        </td>
                                    </tr>
                                    <tr style="border-top: 2px solid #28a745;">
                                        <td style="padding: 8px; font-weight: bold; color: #28a745;">TOTAL USD:</td>
                                        <td style="padding: 8px; text-align: right; font-weight: bold; color: #28a745;">
                                            ${formatCurrency(totalUsd, 'USD')}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- Mostrar campos adicionales en impresión si existen -->
                            ${camposAdicionalesPrintHTML}
                            
                            <div style="margin-top: 30px; padding-top: 20px; border-top: 2px dashed #ccc;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="padding: 10px; text-align: center;">
                                            <p>___________________________________</p>
                                            <p><strong>Responsable</strong></p>
                                        </td>
                                        <td style="padding: 10px; text-align: center;">
                                            <p>___________________________________</p>
                                            <p><strong>Revisado por</strong></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div style="margin-top: 20px; text-align: center; font-size: 12px; color: #666;">
                                <p>Comprobante generado el: ${new Date().toLocaleDateString('es-ES', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</p>
                                <p>Solsumed, CA</p>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#detalleRegistroBody').html(contenido);
                $('#detalleRegistroModal').modal('show');
                
                // Configurar botón de impresión en el modal
                setupPrintButton();
            }
        }
    });
}

// Función para configurar el botón de impresión
function setupPrintButton() {
    // Remover botón anterior si existe
    $('.btn-print').remove();
    
    // Crear botón de impresión
    const printButton = `
        <button type="button" class="btn btn-success btn-print" onclick="imprimirComprobante()">
            <i class="fas fa-print"></i> Imprimir Comprobante
        </button>
    `;
    
    // Agregar botón al modal
    $('#detalleRegistroModal .modal-footer').prepend(printButton);
}

// Función para imprimir el comprobante
function imprimirComprobante() {
    // Obtener el contenido para impresión
    const printContent = $('#print-content').html();
    
    // Crear una ventana de impresión
    const printWindow = window.open('', '_blank');
    
    // Escribir el contenido en la ventana
    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comprobante Relación de Caja</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    color: #333;
                }
                
                @media print {
                    body {
                        padding: 10px;
                    }
                    
                    .no-print {
                        display: none !important;
                    }
                    
                    @page {
                        margin: 0.5cm;
                        size: A4 portrait;
                    }
                }
                
                .print-header {
                    text-align: center;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                    border-bottom: 2px solid #1750a7;
                }
                
                .print-title {
                    color: #1750a7;
                    margin: 10px 0;
                }
                
                .print-section {
                    margin-bottom: 20px;
                    page-break-inside: avoid;
                }
                
                .print-section h4 {
                    color: #1750a7;
                    border-bottom: 1px solid #1750a7;
                    padding-bottom: 5px;
                    margin-bottom: 10px;
                }
                
                .print-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }
                
                .print-table td {
                    padding: 8px;
                    border-bottom: 1px solid #ddd;
                }
                
                .print-table td:last-child {
                    text-align: right;
                    font-weight: bold;
                }
                
                .print-totals {
                    margin-top: 20px;
                    padding-top: 10px;
                    border-top: 2px dashed #ccc;
                }
                
                .signature-area {
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 1px dashed #999;
                }
                
                .signature-line {
                    text-align: center;
                    margin-top: 40px;
                }
                
                .footer {
                    margin-top: 30px;
                    font-size: 11px;
                    color: #666;
                    text-align: center;
                }
                
                .btn-print-page {
                    display: none;
                }
            </style>
        </head>
        <body>
            <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                <button onclick="window.print()" class="btn-print-page" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <button onclick="window.close()" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
            
            ${printContent}
            
            <script>
                // Mostrar botón de impresión en la ventana
                document.querySelector('.btn-print-page').style.display = 'block';
                
                // Auto-imprimir si se desea (opcional)
                // setTimeout(() => { window.print(); }, 500);
            <\/script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
    
    // Enfocar la ventana para que el usuario pueda imprimir
    printWindow.focus();
}

// Versión alternativa más simple (imprimir solo el contenido del modal)
function imprimirModalSimple() {
    // Ocultar botones y elementos no deseados
    const modalContent = $('#detalleRegistroModal .modal-content').clone();
    modalContent.find('.modal-footer, .btn-close').remove();
    
    // Abrir ventana de impresión
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Detalles del Registro - Relación de Cajas</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                h2 { color: #1750a7; }
                .badge { background: #17a2b8; color: white; padding: 3px 8px; border-radius: 10px; }
                .monto-total { font-weight: bold; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 8px; border-bottom: 1px solid #ddd; }
                @media print {
                    @page { margin: 0.5cm; }
                }
            </style>
        </head>
        <body>
            ${modalContent.html()}
            <script>
                window.onload = function() {
                    window.print();
                    // Cerrar automáticamente después de imprimir
                    // setTimeout(() => window.close(), 1000);
                };
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
    
// Función global para generar opciones de vendedores
function generarOpcionesVendedores(vendedorSeleccionado = '') {
    if (typeof window.vendedoresList === 'undefined') {
        return '<option value="">Cargando vendedores...</option>';
    }
    
    let opciones = '<option value="">Seleccione un vendedor...</option>';
    
    if (window.vendedoresList && window.vendedoresList.length > 0) {
        // Ordenar por nombre
        const vendedoresOrdenados = [...window.vendedoresList].sort((a, b) => {
            const nombreA = (a.ven_des || '').toUpperCase();
            const nombreB = (b.ven_des || '').toUpperCase();
            return nombreA.localeCompare(nombreB);
        });
        
        vendedoresOrdenados.forEach(function(vendedor) {
            const codigo = vendedor.co_ven;
            const nombre = vendedor.ven_des || '';
            const clave = vendedor.clave || '';
            const selected = (codigo === vendedorSeleccionado) ? 'selected' : '';
            
            opciones += `<option value="${codigo}" data-clave="${clave}" ${selected}>${nombre}</option>`;
        });
    } else {
        opciones = '<option value="">No hay vendedores disponibles</option>';
    }
    
    return opciones;
}

function editarRegistro(id) {
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=read&id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                const registro = response.data[0];
                
                // Formatear fecha para input datetime-local
                let fechaInput = '';
                if (registro.fecha) {
                    const fecha = new Date(registro.fecha);
                    fechaInput = fecha.toISOString().slice(0, 16);
                }
                
                // Generar opciones de vendedores usando el registro actual
                const opcionesVendedores = generarOpcionesVendedores(registro.co_ven);
                
                const formHTML = `
                    <div class="row">
                           <div class="col-md-6 mb-3">
                            <label for="edit_co_ven" class="form-label">Código de Vendedor *</label>
                            <div class="vendedor-select">
                                <select class="form-select" id="edit_co_ven" name="co_ven" required>
                                    ${generarOpcionesVendedores(registro.co_ven)}
                                </select>
                                <div class="loading-spinner d-none">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="edit_clave_vendedor" class="form-label">Clave del Vendedor</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="edit_clave_vendedor" 
                                       name="clave_vendedor" placeholder="Clave del vendedor" readonly>
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_fecha" class="form-label">Fecha *</label>
                            <input type="datetime-local" class="form-control" id="edit_fecha" name="fecha" value="${registro.fecha}" required disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_turno" class="form-label">Turno *</label>
                            <select class="form-select" id="edit_turno" name="turno" required>
                                <option value="MAÑANA" ${registro.turno === 'MAÑANA' ? 'selected' : ''}>MAÑANA</option>
                                <option value="TARDE" ${registro.turno === 'TARDE' ? 'selected' : ''}>TARDE</option>
                                <option value="NOCHE" ${registro.turno === 'NOCHE' ? 'selected' : ''}>NOCHE</option>
                                <option value="COMPLETO" ${registro.turno === 'COMPLETO' ? 'selected' : ''}>COMPLETO</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_estatus" class="form-label">Estado *</label>
                            <select class="form-select" id="edit_estatus" name="estatus" required>
                                <option value="1" ${registro.estatus == 1 ? 'selected' : ''}>Activo</option>
                                <option value="0" ${registro.estatus == 0 ? 'selected' : ''}>Inactivo</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <h6 class="mb-3"><i class="fas fa-money-bill-wave"></i> Montos en Bolívares</h6>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="monto-group bs-group">
                                <span class="currency-symbol">Bs</span>
                                <label for="edit_monto_bs_efectivo" class="form-label">Efectivo</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_monto_bs_efectivo" name="monto_bs_efectivo" value="${registro.monto_bs_efectivo || '0.00'}" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="monto-group bs-group">
                                <span class="currency-symbol">Bs</span>
                                <label for="edit_monto_bs_transf" class="form-label">Transferencia</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_monto_bs_transf" name="monto_bs_transf" value="${registro.monto_bs_transf || '0.00'}" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="monto-group bs-group">
                                <span class="currency-symbol">Bs</span>
                                <label for="edit_monto_bs_bio" class="form-label">Punto de venta</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_monto_bs_bio" name="monto_bs_bio" value="${registro.monto_bs_bio || '0.00'}" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="monto-group bs-group">
                                <span class="currency-symbol">Bs</span>
                                <label for="edit_monto_bs_pago_movil" class="form-label">Biopago</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_monto_bs_pago_movil" name="monto_bs_pago_movil" value="${registro.monto_bs_pago_movil || '0.00'}" placeholder="0.00">
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <h6 class="mb-3"><i class="fas fa-dollar-sign"></i> Montos en Dólares</h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="monto-group usd-group">
                                <span class="currency-symbol">$</span>
                                <label for="edit_monto_usd_efectivo" class="form-label">Efectivo</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_monto_usd_efectivo" name="monto_usd_efectivo" value="${registro.monto_usd_efectivo || '0.00'}" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="monto-group usd-group">
                                <span class="currency-symbol">$</span>
                                <label for="edit_monto_usd_zeller" class="form-label">Zelle</label>
                                <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_monto_usd_zeller" name="monto_usd_zeller" value="${registro.monto_usd_zeller || '0.00'}" placeholder="0.00">
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <h6 class="mb-3"><i class="fas fa-sticky-note"></i> Campos Adicionales</h6>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="edit_campo1" class="form-label">Egresos de caja</label>
                            <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_campo1" name="campo1" value="${registro.campo1 || '0.00'}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_campo2" class="form-label">Cashea</label>
                            <input type="number" step="0.01" class="form-control monto-input no-spinner" id="edit_campo2" name="campo2" value="${registro.campo2 || ''}">
                        </div>
                        <div class="col-md-4 mb-3 d-none">
                            <label for="edit_campo3" class="form-label">Campo 3</label>
                                <input type="text" class="form-control" id="edit_campo3" name="campo3" value="${registro.campo3 || ''}">
                        </div>
                    </div>
                `;
                
                $('#edit_id').val(id);
                $('#editarRegistroModal .modal-body').html(formHTML);
                $('#editarRegistroModal').modal('show');
                
                // Configurar evento para el select de edición
                $('#edit_co_ven').off('change').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const clave = selectedOption.data('clave') || '';
                    $('#edit_clave_vendedor').val(clave || 'Sin clave');
                });
                
                // Establecer clave inicial
                if (registro.co_ven) {
                    setTimeout(() => {
                        const selectedOption = $('#edit_co_ven option:selected');
                        const clave = selectedOption.data('clave') || '';
                        $('#edit_clave_vendedor').val(clave || 'Sin clave');
                    }, 100);
                }
                
                // MODIFICAR EL SUBMIT PARA USAR LA NUEVA FUNCIÓN DE VERIFICACIÓN
                $('#editarRegistroForm').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    
                    // Validar formulario de edición primero
                    if (!validarFormularioEdicion()) {
                        return;
                    }
                    
                    // Verificar identidad
                    verificarIdentidadVendedorEdicion('editar', id);
                });
            }
        }
    });
}
    
    function actualizarRegistro(id) {
        const formData = $('#editarRegistroForm').serialize();
        
        $.ajax({
            url: 'admin/index.php?action=cajas&accion=update',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Éxito', 'Registro actualizado correctamente', 'success');
                    $('#editarRegistroModal').modal('hide');
                    cargarRegistros();
                } else {
                    Swal.fire('Error', response.message || 'Error al actualizar registro', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al conectar con el servidor', 'error');
            }
        });
    }
    
    function eliminarRegistro(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará permanentemente el registro",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'admin/index.php?action=cajas&accion=delete',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Eliminado', 'Registro eliminado correctamente', 'success');
                            cargarRegistros();
                        } else {
                            Swal.fire('Error', response.message || 'Error al eliminar registro', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al conectar con el servidor', 'error');
                    }
                });
            }
        });
    }
    
    // Función para formatear moneda (global)
    function formatCurrency(amount, currency = 'Bs') {
        if (!amount || isNaN(amount)) amount = 0;
        const formatter = new Intl.NumberFormat('es-VE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        return `${formatter.format(amount)} ${currency}`;
    }


    // Función para verificar identidad del vendedor
function verificarIdentidadVendedor(accion, registroId = null) {
    const selectedOption = $('#co_ven option:selected');
    const vendedorId = selectedOption.val();
    const vendedorNombre = selectedOption.text();
    const vendedorCodigo = selectedOption.val();
    const claveCorrecta = selectedOption.data('clave') || '';
    const cedulaCorrecta = selectedOption.data('cedula') || '';
    
    // Validar que se haya seleccionado un vendedor
    if (!vendedorId) {
        Swal.fire('Error', 'Debe seleccionar un vendedor primero', 'error');
        return false;
    }
    
    // Validar que el vendedor tenga clave
    if (!claveCorrecta && !cedulaCorrecta) {
        Swal.fire('Advertencia', 'Este vendedor no tiene clave configurada. No se requiere verificación.', 'warning');
        return ejecutarAccionPendiente(accion, registroId);
    }
    
    // Guardar información para la verificación
    vendedorSeleccionado = {
        id: vendedorId,
        nombre: vendedorNombre,
        codigo: vendedorCodigo,
        claveCorrecta: claveCorrecta,
        cedulaCorrecta: cedulaCorrecta
    };
    
    accionPendiente = accion;
    registroIdPendiente = registroId;
    
    // Configurar el modal de verificación
    $('#vendedorNombreVerificar').text(vendedorNombre);
    $('#vendedorCodigoVerificar').text(vendedorCodigo);
    $('#claveVerificacion').val('');
    $('#errorVerificacion').addClass('d-none');
    
    // Mostrar modal
    $('#verificarVendedorModal').modal('show');
    
    return false;
}

// Función para verificar identidad del vendedor en EDICIÓN (MODIFICADA)
function verificarIdentidadVendedorEdicion(accion, registroId = null) {
    const selectedOption = $('#edit_co_ven option:selected');
    const vendedorId = selectedOption.val();
    const vendedorNombre = selectedOption.text();
    const vendedorCodigo = selectedOption.val();
    const claveCorrecta = selectedOption.data('clave') || '';
    const cedulaCorrecta = selectedOption.data('cedula') || '';
    
    // Validar que se haya seleccionado un vendedor
    if (!vendedorId) {
        Swal.fire('Error', 'Debe seleccionar un vendedor primero', 'error');
        return false;
    }
    
    // Validar que el vendedor tenga clave
    if (!claveCorrecta && !cedulaCorrecta) {
        Swal.fire('Advertencia', 'Este vendedor no tiene clave configurada. No se requiere verificación.', 'warning');
        return ejecutarAccionPendiente(accion, registroId);
    }
    
    // Guardar información para la verificación
    vendedorSeleccionado = {
        id: vendedorId,
        nombre: vendedorNombre,
        codigo: vendedorCodigo,
        claveCorrecta: claveCorrecta,
        cedulaCorrecta: cedulaCorrecta
    };
    
    accionPendiente = accion;
    registroIdPendiente = registroId;
    
    // Configurar el modal de verificación
    $('#vendedorNombreVerificar').text(vendedorNombre);
    $('#vendedorCodigoVerificar').text(vendedorCodigo);
    $('#claveVerificacion').val('');
    $('#errorVerificacion').addClass('d-none');
    
    // IMPORTANTE: Cerrar el modal de edición primero
    $('#editarRegistroModal').modal('hide');
    
    // Mostrar modal de verificación después de un pequeño delay
    setTimeout(() => {
        $('#verificarVendedorModal').modal('show');
    }, 300); // Pequeño delay para asegurar que se cierre primero
    
    return false;
}

// Modificar la función ejecutarAccionPendiente para reabrir el modal de edición
function ejecutarAccionPendiente(accion, registroId = null) {
    if (accion === 'crear') {
        crearRegistroDirecto();
    } else if (accion === 'editar' && registroId) {
        // Guardar el ID del registro antes de continuar
        registroIdPendiente = registroId;
        actualizarRegistroDirecto(registroId);
    }
}

// Función para actualizar registro después de verificación (MODIFICADA)
function actualizarRegistroDirecto(id) {
    const formData = $('#editarRegistroForm').serialize();
    
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $('#verificarVendedorModal').modal('hide');
            
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Registro actualizado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    cargarRegistros();
                });
            } else {
                Swal.fire('Error', response.message || 'Error al actualizar registro', 'error');
                // Reabrir modal de edición en caso de error
                setTimeout(() => {
                    editarRegistro(id);
                }, 500);
            }
        },
        error: function() {
            $('#verificarVendedorModal').modal('hide');
            Swal.fire('Error', 'Error al conectar con el servidor', 'error');
            // Reabrir modal de edición en caso de error
            setTimeout(() => {
                editarRegistro(id);
            }, 500);
        }
    });
}

// Función para ejecutar la acción después de verificación exitosa
function ejecutarAccionPendiente(accion, registroId = null) {
    if (accion === 'crear') {
        crearRegistroDirecto();
    } else if (accion === 'editar' && registroId) {
        actualizarRegistroDirecto(registroId);
    }
}


// Función para crear registro después de verificación
function crearRegistroDirecto() {
    const formData = $('#nuevoRegistroForm').serialize();
    
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=create',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $('#verificarVendedorModal').modal('hide');
            
            if (response.success) {
                Swal.fire('Éxito', 'Registro creado correctamente', 'success');
                $('#nuevoRegistroModal').modal('hide');
                $('#nuevoRegistroForm')[0].reset();
                cargarRegistros();
            } else {
                Swal.fire('Error', response.message || 'Error al crear registro', 'error');
            }
        },
        error: function() {
            $('#verificarVendedorModal').modal('hide');
            Swal.fire('Error', 'Error al conectar con el servidor', 'error');
        }
    });
}

// Función para validar formulario de edición
function validarFormularioEdicion() {
    // Validar campos requeridos
    const camposRequeridos = [
        { id: '#edit_co_ven', nombre: 'Código de Vendedor' },
        { id: '#edit_turno', nombre: 'Turno' },
        { id: '#edit_fecha', nombre: 'Fecha' }
    ];
    
    for (const campo of camposRequeridos) {
        const valor = $(campo.id).val();
        if (!valor || valor.trim() === '') {
            Swal.fire('Error', `El campo "${campo.nombre}" es requerido`, 'error');
            $(campo.id).focus();
            return false;
        }
    }
    
    return true;
}

// Función para actualizar registro después de verificación
function actualizarRegistroDirecto(id) {
    const formData = $('#editarRegistroForm').serialize();
    
    $.ajax({
        url: 'admin/index.php?action=cajas&accion=update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $('#verificarVendedorModal').modal('hide');
            
            if (response.success) {
                Swal.fire('Éxito', 'Registro actualizado correctamente', 'success');
                $('#editarRegistroModal').modal('hide');
                cargarRegistros();
            } else {
                Swal.fire('Error', response.message || 'Error al actualizar registro', 'error');
            }
        },
        error: function() {
            $('#verificarVendedorModal').modal('hide');
            Swal.fire('Error', 'Error al conectar con el servidor', 'error');
        }
    });
}

// Reemplaza la función validarClaveIngresada con esta versión corregida:
function validarClaveIngresada(claveIngresada) {
    if (!vendedorSeleccionado) {
        console.error('vendedorSeleccionado no está definido');
        return false;
    }
    
    // Asegurar que claveIngresada sea string
    const claveIngresadaStr = String(claveIngresada || '').toLowerCase().trim();
    
    // Verificar contra clave (si existe)
    if (vendedorSeleccionado.claveCorrecta) {
        const claveCorrectaStr = String(vendedorSeleccionado.claveCorrecta || '').toLowerCase().trim();
        if (claveCorrectaStr && claveIngresadaStr === claveCorrectaStr) {
            return true;
        }
    }
    
    // Verificar contra cédula (si existe)
    if (vendedorSeleccionado.cedulaCorrecta) {
        const cedulaCorrectaStr = String(vendedorSeleccionado.cedulaCorrecta || '').toLowerCase().trim();
        if (cedulaCorrectaStr && claveIngresadaStr === cedulaCorrectaStr) {
            return true;
        }
    }
    
    return false;
}

    </script>
</body>
</html>