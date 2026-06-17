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
       
<div class="container mt-4">
    <!-- Encabezado -->
    <div class="header text-center">
        <div class="logo-container">
            <div>
                <h1 class="company-name">Solsumed, CA</h1>
                <p class="lead mb-0">Envío de Correos Masivos</p>
            </div>
        </div>
    </div>
    
    <!-- Barra de herramientas -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="searchClientes" placeholder="Buscar por empresa o email...">
            </div>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-success" id="btnEnviarSeleccionados" disabled>
                <i class="fas fa-paper-plane"></i> Enviar Seleccionados (<span id="countSeleccionados">0</span>)
            </button>
        </div>
    </div>
    
    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="summary-card">
                <h6>TOTAL CLIENTES</h6>
                <h5 id="totalClientes">0</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <h6>EMAILS VÁLIDOS</h6>
                <h5 id="emailsValidos">0</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <h6>ENVIADOS HOY</h6>
                <h5 id="enviadosHoy">0</h5>
            </div>
        </div>
    </div>
    
    <!-- Tabla de clientes -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Lista de Clientes</span>
            <div>
                <button class="btn btn-sm btn-outline-primary" id="btnSeleccionarTodos">
                    <i class="fas fa-check-square"></i> Seleccionar Todos
                </button>
                <button class="btn btn-sm btn-outline-secondary d-none" id="btnDeseleccionarTodos">
                    <i class="fas fa-square"></i> Deseleccionar Todos
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="clientesTable">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="checkTodos" class="form-check-input">
                            </th>
                            <th width="50">#</th>
                            <th>Empresa</th>
                            <th>Email</th>
                            <th width="100">Estado</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="clientesBody">
                        <!-- Los clientes se cargarán aquí -->
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <nav aria-label="Page navigation">
                <ul class="pagination" id="paginationClientes">
                    <!-- La paginación se generará aquí -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: PREVIEW Y ENVÍO DE CORREO -->
<!-- ========================================== -->
<div class="modal fade" id="previewCorreoModal" tabindex="-1" aria-labelledby="previewCorreoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="previewCorreoModalLabel">
                    <i class="fas fa-envelope"></i> Preview del Correo - <span id="modalEmpresa">-</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <h6 class="fw-bold mb-3">Vista Previa del Correo</h6>
                        <div id="previewCorreo" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                            <!-- Preview se cargará aquí -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h6 class="fw-bold mb-3">Configuración de Envío</h6>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>Asunto:</strong></label>
                            <input type="text" class="form-control" id="modalAsunto" 
                                   value="Comunicado - GRUPO SOLSUMED">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>Mensaje Personalizado:</strong></label>
                            <textarea class="form-control" id="modalMensaje" rows="8" 
                                      placeholder="Escribe un mensaje personalizado (opcional)..."></textarea>
                            <small class="text-muted">Si dejas este campo vacío, se usará el template por defecto.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>Información del Destinatario:</strong></label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>Empresa:</strong> <span id="modalEmpresaInfo">-</span></p>
                                    <p class="mb-0"><strong>Email:</strong> <span id="modalEmailInfo">-</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <button class="btn btn-success w-100" id="btnEnviarIndividual">
                            <i class="fas fa-paper-plane"></i> Enviar Correo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: PROGRESO DE ENVÍO MASIVO -->
<!-- ========================================== -->
<div class="modal fade" id="progresoEnvioModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-spinner fa-spin"></i> Enviando Correos Masivos
                </h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h4>Progreso de Envío</h4>
                    <div class="progress" style="height: 30px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             id="barraProgreso" role="progressbar" style="width: 0%">
                            0%
                        </div>
                    </div>
                    <p class="mt-2">
                        <span id="enviadosCount">0</span> de <span id="totalEnviar">0</span> enviados
                    </p>
                </div>
                
                <div id="logEnvios" style="max-height: 300px; overflow-y: auto;">
                    <!-- Log de envíos -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="btnCerrarProgreso" disabled>
                    <i class="fas fa-times"></i> Cerrar
                </button>
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
     // ==========================================
// VARIABLES GLOBALES PARA CORREOS MASIVOS
// ==========================================
let clientesData = []; // Todos los clientes cargados
let clientesFiltrados = []; // Clientes después del filtro
let currentPageClientes = 1;
const recordsPerPageClientes = 50;
let clientesSeleccionados = new Set(); // IDs de clientes seleccionados
let envioEnProgreso = false;
let envioDetenido = false;

// ==========================================
// DATOS DE EJEMPLO (REEMPLAZAR CON TU JSON)
// ==========================================
const clientesJSON = 
  [
    {
        "empresa": "Jesus Blanco",
        "email": "jesusblanco@gruposolsumed.com"
    },
    {
        "empresa": "Mario Velazco",
        "email": "jesusblanco@gruposolsumed.com"
    },
    {
        "empresa": "Publicidad Solsumed",
        "email": "mercadeo@gruposolsumed.com"
    },
    {
        "empresa": "U.M. Descartables, C.A",
        "email": "mandrade@grupopolytex.com"
    },
    {
        "empresa": "R&R Equipos Medicos, CA",
        "email": "Ventas@r-requiposmedicos.com"
    },
    {
        "empresa": "IPS DE VENEZUELA C.A",
        "email": "INFO1BRIMEDC@GMAIL.COM"
    },
    {
        "empresa": "Dynaven International group.c.a",
        "email": "dynavenccs@gmail.com"
    },
    {
        "empresa": "Grupo LatinCardve CA",
        "email": "Lsalas@grupolatincard.com , grupolatincard20@gmail.com "
    },
    {
        "empresa": "Casa de Representación ROIPHARMA",
        "email": "Casaroipharmaca@gmail.com"
    },
    {
        "empresa": "Grupo Giraud",
        "email": "Ventas@grupogiraud.com"
    },
    {
        "empresa": "EVCONSULTIM",
        "email": "EVCONSULTIM@GMAIL.COM"
    },
    {
        "empresa": "Consorcio Beauty VE, C.A.",
        "email": "4220121615"
    },
    {
        "empresa": "Acua-e / Inv. Nelaka 1703 CA",
        "email": "comercialización.acuae@gmail.com"
    },
    {
        "empresa": "Mc Energy ",
        "email": "Mcenergycorp@gmail.com"
    },
    {
        "empresa": "Asistencia Medica Inmediata",
        "email": "Atencionamivenezuela@gmail.com"
    },
    {
        "empresa": "Farmacia SAAS",
        "email": "cmoran@cobeca.com"
    },
    {
        "empresa": "Hipermedical ",
        "email": "Hipermedial.rrhh@gmail.com"
    },
    {
        "empresa": "Ditamed Equipos Medicos ",
        "email": "ventasditamed@gmail.com"
    },
    {
        "empresa": "Agencia de Marketing D21, C.A.",
        "email": "Info@agencia-d21.com"
    },
    {
        "empresa": "PACHECO MATA Y ASOCIADOS SC (PI 360 LEGAL)",
        "email": "info@pi360.legal "
    },
    {
        "empresa": "GRUPO SOLSUMED OCCIDENTE, C.A",
        "email": "ventas@gruposolsumed.com"
    },
    {
        "empresa": "Cesar González 15 (ARCAS DISEÑOS)",
        "email": "arcasdisenos@gmail.com"
    },
    {
        "empresa": "TU MEDICO C.A",
        "email": "Ventas.tumedico@gmail.com"
    },
    {
        "empresa": "Biohlab pharmaceutica / Dromebar ",
        "email": "biohlab.ceo@gmail.com"
    },
    {
        "empresa": "NOVAC MEDICAL",
        "email": "Gruponovacmedical@gmail.com"
    },
    {
        "empresa": "Droguería El Viñedo, C.A. DROVICA",
        "email": "drovica.almacen@gmail.com"
    },
    {
        "empresa": "Tadmass Medical C.A",
        "email": "tadmassventas2025@gmail.com"
    },
    {
        "empresa": "SUMINISTROS MEDICARE C.A",
        "email": "GERENCIAVENTAS@MEDICARE.COM.VE"
    },
    {
        "empresa": "Seguros Mirana, C.A.",
        "email": "gestioncomunicacionalsm@gmail.com"
    },
    {
        "empresa": "Bensamedic Soluciones Medicas C.A.",
        "email": "info@bensamedic.com"
    },
    {
        "empresa": "Mardufre C.A. Agentes Aduaneros",
        "email": "ventas@mardufre.com"
    },
    {
        "empresa": "ITW CONSULTING AGENCY ",
        "email": "Ideas@itwconsulting.agency"
    },
    {
        "empresa": "LOBLACON ",
        "email": "Loblaconteatros@gmail.com"
    },
    {
        "empresa": "Buenaventura Senior Club",
        "email": "Buenaventurasenior24@gmail.com"
    },
    {
        "empresa": "Grupo Showven/ Showven Radio 92.9 FM ",
        "email": "direccion92.9@showvenoficial.com "
    },
    {
        "empresa": "Valpiamed, soluciones médicas. ",
        "email": "valpiamedsolucionesmedicas@gmail.com"
    },
    {
        "empresa": "El King Producciones C.A",
        "email": "ventascorporativas@grupoelking.com"
    },
    {
        "empresa": "HDJImport, C.A.",
        "email": "Info@hdjimport.com"
    },
    {
        "empresa": "Ditamed Equipos Medicos",
        "email": "ventasditamed@gmail.com"
    },
    {
        "empresa": "Grupo Far MÁS",
        "email": "farmaciabarinasIII@gmail.com "
    },
    {
        "empresa": "Inversiones Victoria 1212 C.A ",
        "email": "gerenciadeventas.coolfresh@gmail.com"
    },
    {
        "empresa": "Pi360 Legal",
        "email": "Info@pi360.legal"
    },
    {
        "empresa": "GRUPO LATINCARDVE  CA",
        "email": "Grupolatincard20@gmail.com y Lsalas@grupolatincard.com "
    },
    {
        "empresa": "Bio de Venezuela C,A.",
        "email": "analista@biodevenezuela.com"
    },
    {
        "empresa": "Lam corredor de la actividad aseguradora",
        "email": "coordinacionlam1@gmail.com"
    },
    {
        "empresa": "LOBLACON CA ",
        "email": "loblaconteatros@gmail.com"
    },
    {
        "empresa": "Mc Energy",
        "email": "mcenergycorp@gmail.com"
    },
    {
        "empresa": "VALENTINA RIOS CORREDO DE SEGUROS ",
        "email": "vasegurisimo@gmail.com"
    },
    {
        "empresa": "Ocean Drive Venezuela",
        "email": "rgutierrez@oceandrive.com.ve"
    },
    {
        "empresa": "Valpiamed, soluciones médicas, CA",
        "email": "Valpiamed@gmail.com/valpiamedsolucionesmedicas@gmail.com"
    },
    {
        "empresa": "Larrey, C.A",
        "email": "Mmartinez.grupoelteide@gmail.com"
    },
    {
        "empresa": "Alfa Y Omega salud farma",
        "email": "alfayomegabienestar@gmail.com"
    },
    {
        "empresa": "BIOMASCOTAS C.A.",
        "email": "biomascotasad18@gmail.com"
    },
    {
        "empresa": "Laboratorio Fine Chemicals C.F.C., C.A.",
        "email": "n.machado@labfc.com"
    },
    {
        "empresa": "Yavalva Venezuela ",
        "email": "Dianampedraza21@gmail.com "
    },
    {
        "empresa": "Optica Caroní, C. A. ",
        "email": "drojas@opticacaroni.com"
    },
    {
        "empresa": "SAFE CARE 24/7 VZLA CA",
        "email": "Safe.care247@gmail.com"
    },
    {
        "empresa": "BioSmedical C.A ",
        "email": "BIOSMedical.ca@gmail.com"
    },
    {
        "empresa": "Farmasi",
        "email": "Gigli66@yahoo.es"
    },
    {
        "empresa": "Promotora Luminar C.A",
        "email": "Lumunarvzla@gmail.com"
    },
    {
        "empresa": "Distribuidora Rapid Pop ",
        "email": "distribuidorarapidgo2122@gmail.com"
    },
    {
        "empresa": "Banco de Venezuela ",
        "email": "Willbely_guzman@banvenez.com"
    },
    {
        "empresa": "H. Giraud M & Cia, C. A.",
        "email": "mercadeo@grupogiraud.com"
    },
    {
        "empresa": "Vene-Embarques, C.A.",
        "email": "mercadeo@grupogiraud.com"
    },
    {
        "empresa": "TODO PETS, CA",
        "email": "todopetsca@gmail.com"
    },
    {
        "empresa": "Casa de representación promedica ",
        "email": "Crpromedica@gmail.com"
    },
    {
        "empresa": "Premier Servicios Médicos C.A",
        "email": "premierserviciosmedicos01@gmail.com"
    },
    {
        "empresa": "Ciudad Maderas ",
        "email": "ismaciudadmaderas@gmail.com"
    },
    {
        "empresa": "Inversiones Medictx C.A.",
        "email": "inv.medictx@gmail.com"
    },
    {
        "empresa": "3mit ",
        "email": "hola@3mit.net"
    },
    {
        "empresa": "C.N.A. de Seguros La Previsora ",
        "email": "comunicacioneslaprevisora@gmail.com"
    },
    {
        "empresa": "VitalMove.ccs",
        "email": "VitalMove.ve@gmail.com"
    },
    {
        "empresa": "DENTAL NET, C.A.",
        "email": "jpena@oftalnet.net"
    },
    {
        "empresa": " OFTAL NET, SERVICIOS DE OFTALMOLOGIA C.A.",
        "email": "jpena@oftalnet.net"
    },
    {
        "empresa": "Pasacalles Group C.A.",
        "email": "PasacallesPro@gmail.com"
    },
    {
        "empresa": "Evconsultim ",
        "email": "Ysnaru.milano@clubevpet.com "
    },
    {
        "empresa": "Salud Activa Medical Center ",
        "email": "Saludactivamedicalcenter@gmail.com"
    },
    {
        "empresa": "Cesar González 15(ARCA DISEÑOS)",
        "email": "arca_disenos@gmail.com"
    },
    {
        "empresa": "UM DESCARTABLES",
        "email": "mandrade@grupopolytex.com"
    },
    {
        "empresa": "Droguería americana del centro C.a",
        "email": "Droamecenca@gmail.com"
    },
    {
        "empresa": "Casa Representaciones PHARMAPEOPLE ca",
        "email": "Casadrepharmapeopleca@gmail.com"
    },
    {
        "empresa": "inversiones Victoria 1212 C. A - CoolFresh",
        "email": "gerenciadeventas.coolfresh@gmail.com"
    },
    {
        "empresa": "FARMA ONCOLOGICA ",
        "email": "FARMACITY.MEDICAMENTOS07@GMAIL.COM"
    },
    {
        "empresa": "SAFE CARE 24/7",
        "email": "Safe.care247vzla@gmail.com"
    },
    {
        "empresa": "Renacer salud C.A. ",
        "email": "Renacersaludca@gmail.com"
    },
    {
        "empresa": "DROMEBAR S.A",
        "email": "DROMEBAR@GMAIL.COM"
    },
    {
        "empresa": "Corporación Internacional de Protección Integral CORINPROINCA, C.A",
        "email": "ventas@corinproinca.com"
    },
    {
        "empresa": "Vasegurisimo Asesores ",
        "email": "coordinacion@vasegurisimo.com"
    },
    {
        "empresa": "SINO PRODUCTS PAN AMERICAN SUPPLY C.A",
        "email": "sino.vzla@gmail.com "
    },
    {
        "empresa": "Laboratorio Clínico Zenit Group",
        "email": "contacto@zenitgroups.com"
    },
    {
        "empresa": "Distribuidora para Hospitales y Clinicas Diphosyc, C,A.",
        "email": "diphosycventas@gmail.com"
    },
    {
        "empresa": "Di Geronimo Real Estate",
        "email": "Digeronimore@gmail.com"
    },
    {
        "empresa": "textiles samdres c.a",
        "email": "koikouniformes@gmail .com"
    },
    {
        "empresa": "CRU-MAR,C.A",
        "email": "Info@cru-mar.com"
    },
    {
        "empresa": "Grupo Solsumed C.A",
        "email": "gruposolsumedonline@gmail.com"
    },
    {
        "empresa": "SBC Performance",
        "email": "gabriela@agenciasbc.com"
    },
    {
        "empresa": "Casa de Representaciones PHARMAPEOPLE ca",
        "email": "Casadrepharmapeopleca@gmail.com"
    },
    {
        "empresa": "ZUKATI Casa de Representación, C.A",
        "email": "zukaticasarep@gmail.com"
    },
    {
        "empresa": "AKERMED, C.A",
        "email": "dilo.marketing3@gmail.com"
    },
    {
        "empresa": "salufarmaexpres programa Alfa y Omega",
        "email": "alfayomegabienestar@gmail.com"
    },
    {
        "empresa": "Ditamed Equipos Medicos, C.A",
        "email": "ventasditamed@gmail.com"
    },
    {
        "empresa": "Inversiones Linoflax C.A. ",
        "email": "Equipocomercial.linoflax@gmail.com "
    },
    {
        "empresa": "Heartuniformemedicos",
        "email": "Heartuniformemedicos@gmail.com "
    },
    {
        "empresa": "Ciudad Maderas",
        "email": "Jesus.garcia@ciudadmaderas.com"
    },
    {
        "empresa": "Acua-e / Inversiones Nelaka 1703 CA",
        "email": "Comercializacion.acuae@gmail.com"
    },
    {
        "empresa": "PACHECO MATA Y ASOCIADOS",
        "email": "exportapma@gmail.com"
    },
    {
        "empresa": "Dynaven International Group C.A",
        "email": "dynavenccs@gmail.com"
    },
    {
        "empresa": "J&J technology",
        "email": "Ceoappmedizin.com"
    },
    {
        "empresa": "D21 AI Marketing Agency",
        "email": "info@agencia-d21.com"
    },
    {
        "empresa": "Corporacion Vedicart C.A",
        "email": "corporacionvedicart.ca@gmail.com"
    },
    {
        "empresa": "Bersachem Andina, S.A.",
        "email": "andinabersachem@gmail.com"
    },
    {
        "empresa": "Kompii",
        "email": "info.ve@kompii.com"
    },
    {
        "empresa": "Banco del tesoro",
        "email": "hector.martinez@bt.com.ve"
    },
    {
        "empresa": "Punto rosa salud integral ",
        "email": "maibelysjg01@gmail.com"
    },
    {
        "empresa": "Bienestarum ca",
        "email": "Bienestarum7@gmail.com"
    },
    {
        "empresa": "MDC Medical Solutions, C.A.",
        "email": "medicals.mdc@gmail.com"
    },
    {
        "empresa": "Fabrica de Porductos de Latex Faprotex, C.A.",
        "email": "ventas@faprotex.com"
    },
    {
        "empresa": "Corporación Amodio ",
        "email": "iyolanda69@gmail.com"
    },
    {
        "empresa": "ElMa Editora",
        "email": "elmaeditservicioseditoriales@gmail.com"
    },
    {
        "empresa": "Nestlé Venezuela S.A.",
        "email": "Rosangel.gomez@ve.nestle.com"
    },
    {
        "empresa": "Especialidades médicas 701",
        "email": "medicas701@gmail.com"
    }

];

$(document).ready(function() {
    // Cargar datos al iniciar
    cargarClientes(clientesJSON);
    
    // Eventos
    $('#searchClientes').on('keyup', function() {
        filtrarClientes($(this).val());
    });
    
    $('#checkTodos').on('change', function() {
        seleccionarTodosClientes($(this).is(':checked'));
    });
    
    $('#btnSeleccionarTodos').on('click', function() {
        $('#checkTodos').prop('checked', true).trigger('change');
    });
    
    $('#btnDeseleccionarTodos').on('click', function() {
        $('#checkTodos').prop('checked', false).trigger('change');
    });
    
    $('#btnEnviarSeleccionados').on('click', function() {
        iniciarEnvioMasivo();
    });
    
    $('#btnCerrarProgreso').on('click', function() {
        $('#progresoEnvioModal').modal('hide');
    });
    
    $('#btnEnviarIndividual').on('click', function() {
        enviarCorreoIndividual();
    });
});

// ==========================================
// FUNCIÓN: CARGAR CLIENTES DESDE JSON
// ==========================================
function cargarClientes(data) {
    // Agregar ID único a cada cliente
    clientesData = data.map((cliente, index) => {
        return {
            id: index + 1,
            empresa: cliente.empresa.trim(),
            email: cliente.email.trim(),
            emailValido: validarEmail(cliente.email.trim()),
            estado: 'pendiente' // pendiente, enviado, error
        };
    });
    
    clientesFiltrados = [...clientesData];
    
    // Actualizar resumen
    actualizarResumenClientes();
    
    // Mostrar primera página
    mostrarClientesPagina(1);
    actualizarPaginacionClientes();
}

// ==========================================
// FUNCIÓN: VALIDAR EMAIL
// ==========================================
function validarEmail(email) {
    if (!email || email === '') return false;
    
    // Si contiene comas o "y", puede tener múltiples emails
    if (email.includes(',') || email.toLowerCase().includes(' y ')) {
        // Tomar el primer email
        const primerEmail = email.split(/[,y]/i)[0].trim();
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(primerEmail);
    }
    
    // Si contiene /, no es un email válido
    if (email.includes('/')) return false;
    
    // Validar formato de email
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// ==========================================
// FUNCIÓN: OBTENER EMAIL PRINCIPAL
// ==========================================
function obtenerEmailPrincipal(email) {
    if (!email) return '';
    
    // Si tiene comas, tomar el primero
    if (email.includes(',')) {
        return email.split(',')[0].trim();
    }
    
    // Si tiene "y", tomar el primero
    if (email.toLowerCase().includes(' y ')) {
        return email.split(/ y /i)[0].trim();
    }
    
    // Si tiene /, no es email (es teléfono u otro)
    if (email.includes('/')) return '';
    
    return email.trim();
}

// ==========================================
// FUNCIÓN: FILTRAR CLIENTES
// ==========================================
function filtrarClientes(searchTerm) {
    if (!searchTerm || searchTerm.trim() === '') {
        clientesFiltrados = [...clientesData];
    } else {
        const term = searchTerm.toLowerCase().trim();
        clientesFiltrados = clientesData.filter(cliente => 
            cliente.empresa.toLowerCase().includes(term) ||
            cliente.email.toLowerCase().includes(term)
        );
    }
    
    currentPageClientes = 1;
    mostrarClientesPagina(1);
    actualizarPaginacionClientes();
}

// ==========================================
// FUNCIÓN: MOSTRAR CLIENTES POR PÁGINA
// ==========================================
function mostrarClientesPagina(page) {
    const startIndex = (page - 1) * recordsPerPageClientes;
    const endIndex = startIndex + recordsPerPageClientes;
    const pageClientes = clientesFiltrados.slice(startIndex, endIndex);
    
    const tbody = $('#clientesBody');
    tbody.empty();
    
    if (pageClientes.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="6" class="text-center py-4">
                    <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                    <p class="text-muted">No se encontraron clientes</p>
                </td>
            </tr>
        `);
        return;
    }
    
    pageClientes.forEach(cliente => {
        const isSelected = clientesSeleccionados.has(cliente.id);
        const emailPrincipal = obtenerEmailPrincipal(cliente.email);
        const estadoClass = cliente.estado === 'enviado' ? 'bg-success' : 
                           cliente.estado === 'error' ? 'bg-danger' : 'bg-secondary';
        const estadoText = cliente.estado === 'enviado' ? 'Enviado' : 
                          cliente.estado === 'error' ? 'Error' : 'Pendiente';
        
        const row = `
            <tr class="${isSelected ? 'table-primary' : ''}" id="fila-${cliente.id}">
                <td>
                    <input type="checkbox" class="form-check-input check-cliente" 
                           data-id="${cliente.id}" ${isSelected ? 'checked' : ''}
                           ${!cliente.emailValido ? 'disabled' : ''}>
                </td>
                <td>${cliente.id}</td>
                <td><strong>${cliente.empresa}</strong></td>
                <td>
                    ${cliente.emailValido ? 
                        `<span class="text-success"><i class="fas fa-check-circle"></i> ${emailPrincipal}</span>` :
                        `<span class="text-danger"><i class="fas fa-times-circle"></i> ${cliente.email}</span>`
                    }
                </td>
                <td><span class="badge ${estadoClass}">${estadoText}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-info btn-action preview-btn" 
                            data-id="${cliente.id}" title="Preview">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success btn-action send-btn" 
                            data-id="${cliente.id}" title="Enviar"
                            ${!cliente.emailValido || envioEnProgreso ? 'disabled' : ''}>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
    
    // Eventos de checkboxes
    $('.check-cliente').off('change').on('change', function() {
        const id = parseInt($(this).data('id'));
        if ($(this).is(':checked')) {
            clientesSeleccionados.add(id);
            $(`#fila-${id}`).addClass('table-primary');
        } else {
            clientesSeleccionados.delete(id);
            $(`#fila-${id}`).removeClass('table-primary');
        }
        actualizarBotonEnvio();
    });
    
    // Eventos de botones preview
    $('.preview-btn').off('click').on('click', function() {
        const id = parseInt($(this).data('id'));
        abrirPreviewCliente(id);
    });
    
    // Eventos de botones enviar individual
    $('.send-btn').off('click').on('click', function() {
        const id = parseInt($(this).data('id'));
        abrirPreviewCliente(id);
    });
}

// ==========================================
// FUNCIÓN: ACTUALIZAR PAGINACIÓN
// ==========================================
function actualizarPaginacionClientes() {
    const totalPages = Math.ceil(clientesFiltrados.length / recordsPerPageClientes);
    const pagination = $('#paginationClientes');
    pagination.empty();
    
    if (totalPages <= 1) return;
    
    // Botón anterior
    const prevDisabled = currentPageClientes === 1 ? 'disabled' : '';
    pagination.append(`
        <li class="page-item ${prevDisabled}">
            <a class="page-link" href="#" onclick="cambiarPaginaClientes(${currentPageClientes - 1})">&laquo;</a>
        </li>
    `);
    
    // Páginas
    for (let i = 1; i <= totalPages; i++) {
        const active = i === currentPageClientes ? 'active' : '';
        pagination.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="#" onclick="cambiarPaginaClientes(${i})">${i}</a>
            </li>
        `);
    }
    
    // Botón siguiente
    const nextDisabled = currentPageClientes === totalPages ? 'disabled' : '';
    pagination.append(`
        <li class="page-item ${nextDisabled}">
            <a class="page-link" href="#" onclick="cambiarPaginaClientes(${currentPageClientes + 1})">&raquo;</a>
        </li>
    `);
}

function cambiarPaginaClientes(page) {
    currentPageClientes = page;
    mostrarClientesPagina(page);
    actualizarPaginacionClientes();
}

// ==========================================
// FUNCIÓN: SELECCIONAR TODOS
// ==========================================
function seleccionarTodosClientes(seleccionar) {
    clientesSeleccionados.clear();
    
    if (seleccionar) {
        clientesFiltrados.forEach(cliente => {
            if (cliente.emailValido) {
                clientesSeleccionados.add(cliente.id);
            }
        });
        $('#btnSeleccionarTodos').addClass('d-none');
        $('#btnDeseleccionarTodos').removeClass('d-none');
    } else {
        $('#btnSeleccionarTodos').removeClass('d-none');
        $('#btnDeseleccionarTodos').addClass('d-none');
    }
    
    mostrarClientesPagina(currentPageClientes);
    actualizarBotonEnvio();
}

// ==========================================
// FUNCIÓN: ACTUALIZAR BOTÓN DE ENVÍO
// ==========================================
function actualizarBotonEnvio() {
    const count = clientesSeleccionados.size;
    $('#countSeleccionados').text(count);
    
    if (count > 0 && !envioEnProgreso) {
        $('#btnEnviarSeleccionados').prop('disabled', false);
    } else {
        $('#btnEnviarSeleccionados').prop('disabled', true);
    }
}

// ==========================================
// FUNCIÓN: ACTUALIZAR RESUMEN
// ==========================================
function actualizarResumenClientes() {
    const total = clientesData.length;
    const validos = clientesData.filter(c => c.emailValido).length;
    const enviados = clientesData.filter(c => c.estado === 'enviado').length;
    
    $('#totalClientes').text(total);
    $('#emailsValidos').text(validos);
    $('#enviadosHoy').text(enviados);
}

// ==========================================
// FUNCIÓN: ABRIR PREVIEW DEL CLIENTE
// ==========================================
function abrirPreviewCliente(id) {
    const cliente = clientesData.find(c => c.id === id);
    if (!cliente) return;
    
    if (!cliente.emailValido) {
        Swal.fire('Error', 'El correo no es válido para este cliente', 'error');
        return;
    }
    
    const emailPrincipal = obtenerEmailPrincipal(cliente.email);
    
    $('#modalEmpresa').text(cliente.empresa);
    $('#modalEmpresaInfo').text(cliente.empresa);
    $('#modalEmailInfo').text(emailPrincipal);
    $('#modalAsunto').val(`Comunicado - GRUPO SOLSUMED`);
    $('#modalMensaje').val('');
    
    // Guardar ID actual para envío
    $('#previewCorreoModal').data('clienteId', id);
    
    // Generar preview
    actualizarPreviewCorreo(cliente.empresa, $('#modalAsunto').val());
    
    // Mostrar modal
    $('#previewCorreoModal').modal('show');
}

// ==========================================
// FUNCIÓN: ACTUALIZAR PREVIEW DEL CORREO
// ==========================================
function actualizarPreviewCorreo(empresa, asunto) {
    const mensaje = $('#modalMensaje').val();
    const fecha = new Date().toLocaleDateString('es-ES');
    
    let cuerpo;
    if (mensaje && mensaje.trim() !== '') {
        cuerpo = mensaje.replace(/\n/g, '<br>');
    } else {
        cuerpo = `
           
            
            <div class="empresa-info" style="background: #f8f9fa; border-left: 4px solid #0f418c; padding: 15px 20px; margin: 20px 0; border-radius: 0 5px 5px 0;">
                <p>Estimado(a) <strong>${empresa}</strong>,</p>
                <p>Reciba un cordial saludo de parte del equipo de <strong>Bialy</strong>.</p>
            </div>                
            
            <p>Atentamente,<br>
            <strong>Departamento de mercado y publicidad</strong><br>
            Bialy y Grupo Solsumed</p>
        `;
    }
    
    const previewHTML = `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <div style="background: linear-gradient(135deg, #0f418c, #1a5bb5); color: white; padding: 30px; text-align: center;">
                <h1 style="margin: 0; font-size: 22px;">Bialy</h1>                
            </div>
            <div style="padding: 30px; background: white;">
                ${cuerpo}
            </div>
            <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #666;">
                <p>Teléfono: 0424-588.55.91 / 0251-273.28.66</p>               
                <p>Email: ventas@gruposolsumed.com</p>
                <p>Web: www.gruposolsumed.com</p>
            </div>
        </div>
    `;
    
    $('#previewCorreo').html(previewHTML);
}

// Evento para actualizar preview en tiempo real
$('#modalMensaje, #modalAsunto').on('input', function() {
    const empresa = $('#modalEmpresaInfo').text();
    const asunto = $('#modalAsunto').val();
    actualizarPreviewCorreo(empresa, asunto);
});

// ==========================================
// FUNCIÓN: ENVIAR CORREO INDIVIDUAL
// ==========================================
function enviarCorreoIndividual() {
    const id = $('#previewCorreoModal').data('clienteId');
    const cliente = clientesData.find(c => c.id === id);
    if (!cliente) return;
    
    const emailPrincipal = obtenerEmailPrincipal(cliente.email);
    const asunto = $('#modalAsunto').val();
    const mensaje = $('#modalMensaje').val();
    
    // Cerrar modal de preview
    $('#previewCorreoModal').modal('hide');
    
    // Enviar
    enviarCorreoCliente(cliente, emailPrincipal, asunto, mensaje);
}

// ==========================================
// FUNCIÓN: ENVIAR CORREO A CLIENTE (USANDO TU FORMATO)
// ==========================================
function enviarCorreoCliente(cliente, emailDestino, asunto, mensaje) {
    // Loading
    Swal.fire({
        title: 'Enviando correo...',
        html: `Enviando a <strong>${cliente.empresa}</strong><br>${emailDestino}`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
         url: 'admin/index.php?action=enviarEmailMasivo',           
        type: 'POST',
        dataType: 'json',
        data: {
            empresa: cliente.empresa,
            email_destino: emailDestino,
            asunto: asunto,
            mensaje: mensaje
        },
        success: function(response) {
            Swal.close();
            
            if (response.success) {
                // Marcar como enviado
                cliente.estado = 'enviado';
                actualizarResumenClientes();
                mostrarClientesPagina(currentPageClientes);
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo Enviado!',
                    text: response.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#006af5',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            } else {
                // Marcar como error
                cliente.estado = 'error';
                mostrarClientesPagina(currentPageClientes);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    confirmButtonColor: '#ea5455',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.close();
            
            cliente.estado = 'error';
            mostrarClientesPagina(currentPageClientes);
            
            Swal.fire({
                icon: 'error',
                title: 'Error de Conexión',
                text: 'No se pudo comunicar con el servidor.',
                confirmButtonColor: '#dc3545',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    });
}

// ==========================================
// FUNCIÓN: INICIAR ENVÍO MASIVO
// ==========================================
function iniciarEnvioMasivo() {
    if (clientesSeleccionados.size === 0) {
        Swal.fire('Atención', 'No hay clientes seleccionados', 'warning');
        return;
    }
    
    Swal.fire({
        title: '¿Confirmar Envío Masivo?',
        html: `Se enviarán correos a <strong>${clientesSeleccionados.size}</strong> clientes seleccionados.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, Enviar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            ejecutarEnvioMasivo();
        }
    });
}

// ==========================================
// FUNCIÓN: EJECUTAR ENVÍO MASIVO
// ==========================================
async function ejecutarEnvioMasivo() {
    envioEnProgreso = true;
    envioDetenido = false;
    
    // Obtener clientes seleccionados que tengan email válido
    const seleccionados = clientesData.filter(c => 
        clientesSeleccionados.has(c.id) && c.emailValido
    );
    
    if (seleccionados.length === 0) {
        Swal.fire('Error', 'Ningún cliente seleccionado tiene email válido', 'error');
        envioEnProgreso = false;
        return;
    }
    
    // Mostrar modal de progreso
    $('#progresoEnvioModal').modal('show');
    $('#barraProgreso').css('width', '0%').text('0%');
    $('#enviadosCount').text('0');
    $('#totalEnviar').text(seleccionados.length);
    $('#logEnvios').empty();
    $('#btnCerrarProgreso').prop('disabled', true);
    
    const asunto = 'Comunicado - GRUPO SOLSUMED';
    let enviados = 0;
    let errores = 0;
    
    for (let i = 0; i < seleccionados.length; i++) {
        if (envioDetenido) break;
        
        const cliente = seleccionados[i];
        const emailPrincipal = obtenerEmailPrincipal(cliente.email);
        
        // Actualizar log
        agregarLogEnvio(`<span class="text-info"><i class="fas fa-spinner fa-spin"></i> Enviando a: ${cliente.empresa} (${emailPrincipal})...</span>`);
        
        try {
            await enviarCorreoAsync(cliente, emailPrincipal, asunto, '');
            
            cliente.estado = 'enviado';
            enviados++;
            
            // Actualizar log
            $('#logEnvios').find('span.text-info').last().replaceWith(
                `<span class="text-success"><i class="fas fa-check-circle"></i> ✓ Enviado: ${cliente.empresa}</span>`
            );
            
        } catch (error) {
            cliente.estado = 'error';
            errores++;
            
            $('#logEnvios').find('span.text-info').last().replaceWith(
                `<span class="text-danger"><i class="fas fa-times-circle"></i> ✗ Error: ${cliente.empresa} - ${error}</span>`
            );
        }
        
        // Actualizar progreso
        const porcentaje = Math.round(((i + 1) / seleccionados.length) * 100);
        $('#barraProgreso').css('width', porcentaje + '%').text(porcentaje + '%');
        $('#enviadosCount').text(i + 1);
        
        // Scroll al final del log
        $('#logEnvios').scrollTop($('#logEnvios')[0].scrollHeight);
        
        // Pequeña pausa para no saturar el servidor
        await sleep(500);
    }
    
    // Finalizar
    envioEnProgreso = false;
    $('#btnCerrarProgreso').prop('disabled', false);
    actualizarResumenClientes();
    mostrarClientesPagina(currentPageClientes);
    actualizarBotonEnvio();
    
    // Mostrar resultado
    Swal.fire({
        icon: 'success',
        title: 'Envío Masivo Completado',
        html: `
            <p><strong>Total:</strong> ${seleccionados.length}</p>
            <p class="text-success"><strong>Enviados:</strong> ${enviados}</p>
            <p class="text-danger"><strong>Errores:</strong> ${errores}</p>
        `,
        confirmButtonColor: '#28a745'
    });
}

// ==========================================
// FUNCIÓN: ENVIAR CORREO ASYNC (PROMESA)
// ==========================================
function enviarCorreoAsync(cliente, emailDestino, asunto, mensaje) {
    return new Promise((resolve, reject) => {
        $.ajax({
           // url: 'admin/ajax/enviar_correo_masivo.php',
            url: 'admin/index.php?action=enviarEmailMasivo',           
            type: 'POST',
            dataType: 'json',
            data: {
                empresa: cliente.empresa,
                email_destino: emailDestino,
                asunto: asunto,
                mensaje: mensaje
            },
            success: function(response) {
                if (response.success) {
                    resolve(response);
                } else {
                    reject(response.message || 'Error desconocido');
                }
            },
            error: function() {
                reject('Error de conexión');
            }
        });
    });
}

// ==========================================
// FUNCIONES AUXILIARES
// ==========================================
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function agregarLogEnvio(mensaje) {
    $('#logEnvios').append(`<div class="mb-1">${mensaje}</div>`);
}

    </script>
</body>
</html>