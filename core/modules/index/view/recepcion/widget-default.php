<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solsumed, CA - Gestión de Llamadas</title>
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
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
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
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1750a7 0%, #2b5da6 100%);
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
        
        .requerimiento-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .requerimiento-consulta { background-color: #cfe2ff; color: #084298; }
        .requerimiento-reclamo { background-color: #f8d7da; color: #842029; }
        .requerimiento-soporte { background-color: #d1e7dd; color: #0f5132; }
        .requerimiento-venta { background-color: #fff3cd; color: #856404; }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .status-1 { background-color: #d4edda; color: #155724; }
        .status-0 { background-color: #f8d7da; color: #721c24; }
        
        .company-name {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #a8c6ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .resultados-clientes {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            display: none;
        }
        
        .resultados-clientes .list-group-item {
            cursor: pointer;
        }
        
        .resultados-clientes .list-group-item:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header text-center">
            <div>
                <h1 class="company-name">Solsumed, CA</h1>
                <p class="lead mb-0">Gestión de Llamadas a Clientes</p>
            </div>
        </div>
        
       <!-- Barra de herramientas con menú desplegable -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por cliente, requerimiento...">
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="exportarExcel()">
                            <i class="fas fa-file-excel text-success"></i> Excel Básico
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportarExcelFormateado()">
                            <i class="fas fa-file-excel text-success"></i> Excel Detallado
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="exportarPDF()">
                            <i class="fas fa-file-pdf text-danger"></i> PDF Básico
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportarPDFDetallado()">
                            <i class="fas fa-file-pdf text-danger"></i> PDF Detallado
                        </a></li>
                    </ul>
                </div>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#nuevoLlamadaModal">
                    <i class="fas fa-phone-alt"></i> Nueva Llamada
                </button>
            </div>
        </div>
        
        <!-- Tabla de llamadas -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-phone-alt"></i> Registro de Llamadas
                <span class="badge bg-primary float-end" id="totalRegistrosBadge">0</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha/Hora</th>
                                <th>Tipo</th>
                                <th>Observación</th>
                                <th>Fecha Respuesta</th>
                                <th>Vendedor</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="llamadasBody"></tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <nav>
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
        
        <!-- Botón flotante -->
        <button class="floating-btn" data-bs-toggle="modal" data-bs-target="#nuevoLlamadaModal">
            <i class="fas fa-phone-alt"></i>
        </button>
    </div>
    
    <!-- Modal nueva llamada -->
    <div class="modal fade" id="nuevoLlamadaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-phone-alt"></i> Nueva Llamada</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                    
                </div>

                
                <form id="nuevoLlamadaForm">
                    <div class="modal-body">
                        <div class="row">
                            <!-- Buscador de clientes -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Buscar Cliente *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="buscarCliente" placeholder="Código o nombre">
                                    <button class="btn btn-outline-primary" type="button" id="btnBuscarCliente">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="resultados-clientes mt-2" id="resultadosClientes"></div>
                            </div>
                            
                            <!-- Datos cliente seleccionado -->
                            <input type="hidden" id="co_cli" name="co_cli">
                            <div class="col-md-12 mb-3" id="clienteSeleccionadoInfo" style="display:none;">
                                <div class="alert alert-info">
                                    <strong>Cliente:</strong> <span id="des_cli_text"></span>
                                    <input type="hidden" id="des_cli" name="des_cli">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha y Hora *</label>
                                <input type="datetime-local" class="form-control" id="fecha_hora_llamada" name="fecha_hora_llamada" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Posible Respuesta</label>
                                <input type="date" class="form-control" id="fecha_posible_respuesta" name="fecha_posible_respuesta">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo Requerimiento *</label>
                                <select class="form-select" id="tipo_requerimiento" name="tipo_requerimiento" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="CONSULTA">CONSULTA</option>
                                    <option value="RECLAMO">RECLAMO</option>
                                    <option value="SOPORTE">SOPORTE</option>
                                    <option value="VENTA">VENTA</option>
                                    <option value="SEGUIMIENTO">SEGUIMIENTO</option>
                                    <option value="COTIZACION">COTIZACIÓN</option>
                                    <option value="FACTURACION">FACTURACIÓN</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vendedor *</label>
                                <select class="form-select" id="co_ven" name="co_ven" required>
                                    <option value="">Cargando vendedores...</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Observación</label>
                                <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dato Extra 1</label>
                                <input type="text" class="form-control" id="dato_extra1" name="dato_extra1">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dato Extra 2</label>
                                <input type="text" class="form-control" id="dato_extra2" name="dato_extra2">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dato Extra 3</label>
                                <input type="text" class="form-control" id="dato_extra3" name="dato_extra3">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal editar llamada -->
    <div class="modal fade" id="editarLlamadaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Llamada</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editarLlamadaForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body" id="editarLlamadaBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Agregar después de SweetAlert2 CSS -->
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- jsPDF Autotable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <!-- SheetJS (para Excel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- FileSaver.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


    <script>
        let currentPage = 1;
        const recordsPerPage = 10;
        let totalRecords = 0;
        let allRecords = [];
        let vendedoresList = [];
        
        $(document).ready(function() {
            cargarLlamadas();
            cargarVendedores();
            configurarFechaActual();
            
            $('#btnBuscarCliente').on('click', buscarClientes);
            $('#buscarCliente').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    buscarClientes();
                }
            });
            
            $('#searchInput').on('keyup', function() {
                currentPage = 1;
                cargarLlamadas();
            });
            
            $('#nuevoLlamadaForm').on('submit', function(e) {
                e.preventDefault();
                crearLlamada();
            });
        });
        
        function configurarFechaActual() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            $('#fecha_hora_llamada').val(`${year}-${month}-${day}T${hours}:${minutes}`);
        }
        
        function cargarVendedores() {
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=getVendedores',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        vendedoresList = response.data;
                        let options = '<option value="">Seleccione un vendedor...</option>';
                        vendedoresList.sort((a, b) => (a.ven_des || '').localeCompare(b.ven_des || ''));
                        vendedoresList.forEach(v => {
                            options += `<option value="${v.co_ven}" data-clave="${v.clave || ''}">${v.ven_des}</option>`;
                        });
                        $('#co_ven').html(options);
                    }
                }
            });
        }

        // Función para exportar a Excel
        function exportarExcel() {
            if (allRecords.length === 0) {
                Swal.fire('Aviso', 'No hay datos para exportar', 'info');
                return;
            }

            // Preparar los datos para Excel
            const datos = allRecords.map(r => ({
                'ID': r.id,
                'Código Cliente': r.co_cli,
                'Nombre Cliente': r.des_cli,
                'Fecha/Hora Llamada': r.fecha_hora_llamada ? new Date(r.fecha_hora_llamada).toLocaleString() : '',
                'Tipo Requerimiento': r.tipo_requerimiento,
                'Observación': r.observacion || '',
                'Fecha Respuesta': r.fecha_posible_respuesta ? new Date(r.fecha_posible_respuesta).toLocaleDateString() : '',
                'Vendedor': r.ven_des || r.co_ven,
                'Estatus': r.estatus == 1 ? 'Activo' : 'Inactivo',
                'Dato Extra 1': r.dato_extra1 || '',
                'Dato Extra 2': r.dato_extra2 || '',
                'Dato Extra 3': r.dato_extra3 || ''
            }));

            // Crear libro de Excel
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(datos);

            // Ajustar ancho de columnas
            const colWidths = [
                { wch: 8 },   // ID
                { wch: 15 },  // Código Cliente
                { wch: 40 },  // Nombre Cliente
                { wch: 20 },  // Fecha/Hora
                { wch: 20 },  // Tipo
                { wch: 50 },  // Observación
                { wch: 15 },  // Fecha Respuesta
                { wch: 25 },  // Vendedor
                { wch: 10 },  // Estatus
                { wch: 20 },  // Dato Extra 1
                { wch: 20 },  // Dato Extra 2
                { wch: 20 }   // Dato Extra 3
            ];
            ws['!cols'] = colWidths;

            // Agregar hoja al libro
            XLSX.utils.book_append_sheet(wb, ws, 'Llamadas');

            // Generar nombre de archivo con fecha
            const fecha = new Date().toISOString().slice(0, 10);
            const nombreArchivo = `Llamadas_Clientes_${fecha}.xlsx`;

            // Guardar archivo
            XLSX.writeFile(wb, nombreArchivo);
        }

        // Función para exportar a PDF
        function exportarPDF() {
            if (allRecords.length === 0) {
                Swal.fire('Aviso', 'No hay datos para exportar', 'info');
                return;
            }

            // Mostrar loading
            Swal.fire({
                title: 'Generando PDF...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Crear nuevo documento PDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('landscape', 'mm', 'a4');

            // Configurar título
            const fechaActual = new Date().toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Título del reporte
            doc.setFontSize(18);
            doc.setTextColor(23, 80, 167); // Color #1750a7
            doc.text('Solsumed, CA', 14, 15);
            
            doc.setFontSize(14);
            doc.setTextColor(0, 0, 0);
            doc.text('Reporte de Llamadas a Clientes', 14, 25);
            
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text(`Fecha de generación: ${fechaActual}`, 14, 32);
            doc.text(`Total de registros: ${allRecords.length}`, 14, 38);

            // Preparar datos para la tabla
            const headers = [
                ['ID', 'Cliente', 'Fecha/Hora', 'Tipo', 'Observación', 'Vendedor', 'Estatus']
            ];

            const data = allRecords.map(r => [
                r.id,
                `${r.co_cli}\n${r.des_cli.substring(0, 30)}`,
                r.fecha_hora_llamada ? new Date(r.fecha_hora_llamada).toLocaleString() : '',
                r.tipo_requerimiento,
                r.observacion ? r.observacion.substring(0, 40) + (r.observacion.length > 40 ? '...' : '') : '',
                r.ven_des || r.co_ven,
                r.estatus == 1 ? 'Activo' : 'Inactivo'
            ]);

            // Configurar estilos de la tabla
            doc.autoTable({
                head: headers,
                body: data,
                startY: 45,
                theme: 'grid',
                styles: {
                    fontSize: 8,
                    cellPadding: 2,
                    lineColor: [200, 200, 200],
                    lineWidth: 0.1
                },
                headStyles: {
                    fillColor: [23, 80, 167],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    halign: 'center'
                },
                columnStyles: {
                    0: { cellWidth: 10 },  // ID
                    1: { cellWidth: 50 },  // Cliente
                    2: { cellWidth: 35 },  // Fecha/Hora
                    3: { cellWidth: 25 },  // Tipo
                    4: { cellWidth: 60 },  // Observación
                    5: { cellWidth: 30 },  // Vendedor
                    6: { cellWidth: 15 }   // Estatus
                },
                alternateRowStyles: {
                    fillColor: [245, 245, 245]
                },
                didDrawPage: function(data) {
                    // Número de página
                    doc.setFontSize(8);
                    doc.setTextColor(150);
                    doc.text(
                        'Página ' + doc.internal.getNumberOfPages(),
                        data.settings.margin.left,
                        doc.internal.pageSize.height - 10
                    );
                }
            });

            // Cerrar loading
            Swal.close();

            // Guardar PDF
            const fecha = new Date().toISOString().slice(0, 10);
            doc.save(`Llamadas_Clientes_${fecha}.pdf`);
        }

        // Función para exportar PDF detallado (con todos los campos)
        function exportarPDFDetallado() {
            if (allRecords.length === 0) {
                Swal.fire('Aviso', 'No hay datos para exportar', 'info');
                return;
            }

            Swal.fire({
                title: 'Generando PDF Detallado...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('landscape', 'mm', 'a4');

            const fechaActual = new Date().toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Título
            doc.setFontSize(18);
            doc.setTextColor(23, 80, 167);
            doc.text('Solsumed, CA', 14, 15);
            
            doc.setFontSize(14);
            doc.setTextColor(0, 0, 0);
            doc.text('Reporte Detallado de Llamadas a Clientes', 14, 25);
            
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text(`Fecha de generación: ${fechaActual}`, 14, 32);
            doc.text(`Total de registros: ${allRecords.length}`, 14, 38);

            // Headers más detallados
            const headers = [
                ['ID', 'Cliente', 'Fecha/Hora', 'Tipo', 'Observación', 'Fecha Respuesta', 'Vendedor', 'Estatus', 'Datos Extra']
            ];

            const data = allRecords.map(r => {
                // Combinar datos extra
                const datosExtra = [
                    r.dato_extra1 ? `1:${r.dato_extra1}` : '',
                    r.dato_extra2 ? `2:${r.dato_extra2}` : '',
                    r.dato_extra3 ? `3:${r.dato_extra3}` : ''
                ].filter(d => d).join(' | ');

                return [
                    r.id,
                    `${r.co_cli}\n${r.des_cli.substring(0, 25)}`,
                    r.fecha_hora_llamada ? new Date(r.fecha_hora_llamada).toLocaleString() : '',
                    r.tipo_requerimiento,
                    r.observacion ? r.observacion.substring(0, 35) + (r.observacion.length > 35 ? '...' : '') : '',
                    r.fecha_posible_respuesta ? new Date(r.fecha_posible_respuesta).toLocaleDateString() : '',
                    r.ven_des || r.co_ven,
                    r.estatus == 1 ? 'Activo' : 'Inactivo',
                    datosExtra || '-'
                ];
            });

            doc.autoTable({
                head: headers,
                body: data,
                startY: 45,
                theme: 'grid',
                styles: {
                    fontSize: 7,
                    cellPadding: 1.5,
                    lineColor: [200, 200, 200],
                    lineWidth: 0.1
                },
                headStyles: {
                    fillColor: [23, 80, 167],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    halign: 'center'
                },
                columnStyles: {
                    0: { cellWidth: 8 },   // ID
                    1: { cellWidth: 45 },  // Cliente
                    2: { cellWidth: 30 },  // Fecha/Hora
                    3: { cellWidth: 20 },  // Tipo
                    4: { cellWidth: 45 },  // Observación
                    5: { cellWidth: 20 },  // Fecha Respuesta
                    6: { cellWidth: 25 },  // Vendedor
                    7: { cellWidth: 12 },  // Estatus
                    8: { cellWidth: 50 }   // Datos Extra
                },
                alternateRowStyles: {
                    fillColor: [245, 245, 245]
                }
            });

            Swal.close();
            const fecha = new Date().toISOString().slice(0, 10);
            doc.save(`Llamadas_Detallado_${fecha}.pdf`);
        }

        // Función para exportar a Excel con formato mejorado
        function exportarExcelFormateado() {
            if (allRecords.length === 0) {
                Swal.fire('Aviso', 'No hay datos para exportar', 'info');
                return;
            }

            // Preparar datos con formato mejorado
            const datos = allRecords.map(r => ({
                'ID': r.id,
                'Código': r.co_cli,
                'Cliente': r.des_cli,
                'Fecha Llamada': r.fecha_hora_llamada ? new Date(r.fecha_hora_llamada).toLocaleString() : '',
                'Tipo': r.tipo_requerimiento,
                'Observación': r.observacion || '',
                'Fecha Respuesta': r.fecha_posible_respuesta ? new Date(r.fecha_posible_respuesta).toLocaleDateString() : '',
                'Vendedor': r.ven_des || r.co_ven,
                'Estado': r.estatus == 1 ? 'Activo' : 'Inactivo',
                'Dato 1': r.dato_extra1 || '',
                'Dato 2': r.dato_extra2 || '',
                'Dato 3': r.dato_extra3 || '',
                'Fecha Registro': r.fecha_registro ? new Date(r.fecha_registro).toLocaleString() : ''
            }));

            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(datos);

            // Ajustar ancho de columnas
            ws['!cols'] = [
                { wch: 8 },   // ID
                { wch: 15 },  // Código
                { wch: 50 },  // Cliente
                { wch: 20 },  // Fecha Llamada
                { wch: 15 },  // Tipo
                { wch: 60 },  // Observación
                { wch: 15 },  // Fecha Respuesta
                { wch: 25 },  // Vendedor
                { wch: 10 },  // Estado
                { wch: 20 },  // Dato 1
                { wch: 20 },  // Dato 2
                { wch: 20 },  // Dato 3
                { wch: 20 }   // Fecha Registro
            ];

            XLSX.utils.book_append_sheet(wb, ws, 'Llamadas');

            const fecha = new Date().toISOString().slice(0, 10);
            XLSX.writeFile(wb, `Llamadas_Completo_${fecha}.xlsx`);
        }
        
        function buscarClientes() {
            const search = $('#buscarCliente').val().trim();
            if (!search) {
                Swal.fire('Aviso', 'Ingrese un término de búsqueda', 'info');
                return;
            }
            
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=getClientes&search=' + encodeURIComponent(search),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const resultados = $('#resultadosClientes');
                    resultados.empty().show();
                    
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(cliente => {
                            resultados.append(`
                                <a href="#" class="list-group-item list-group-item-action" 
                                   onclick="seleccionarCliente('${cliente.co_cli}', '${cliente.des_cli.replace(/'/g, "\\'")}')">
                                    <strong>${cliente.co_cli}</strong> - ${cliente.des_cli}
                                </a>
                            `);
                        });
                    } else {
                        resultados.append('<div class="list-group-item">No se encontraron clientes</div>');
                    }
                }
            });
        }
        
        function seleccionarCliente(co_cli, des_cli) {
            $('#co_cli').val(co_cli);
            $('#des_cli').val(des_cli);
            $('#des_cli_text').text(`${co_cli} - ${des_cli}`);
            $('#clienteSeleccionadoInfo').show();
            $('#resultadosClientes').hide();
            $('#buscarCliente').val('');
        }
        
        function cargarLlamadas() {
            const search = $('#searchInput').val();
            
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=read&search=' + encodeURIComponent(search),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        allRecords = response.data;
                        totalRecords = allRecords.length;
                        mostrarLlamadasPagina(currentPage);
                        actualizarPaginacion();
                        $('#totalRegistrosBadge').text(totalRecords);
                    }
                }
            });
        }
        
        function mostrarLlamadasPagina(page) {
            const start = (page - 1) * recordsPerPage;
            const end = start + recordsPerPage;
            const pageRecords = allRecords.slice(start, end);
            
            const tbody = $('#llamadasBody');
            tbody.empty();
            
            if (pageRecords.length === 0) {
                tbody.html('<tr><td colspan="9" class="text-center py-4">No hay llamadas registradas</td></tr>');
                return;
            }
            
            pageRecords.forEach(r => {
                const fecha = r.fecha_hora_llamada ? new Date(r.fecha_hora_llamada).toLocaleString() : '';
                const fechaRespuesta = r.fecha_posible_respuesta ? new Date(r.fecha_posible_respuesta).toLocaleDateString() : '';
                const tipoClass = getTipoClass(r.tipo_requerimiento);
                
                tbody.append(`
                    <tr>
                        <td>${r.id}</td>
                        <td><strong>${r.co_cli}</strong><br><small>${r.des_cli.substring(0, 30)}...</small></td>
                        <td>${fecha}</td>
                        <td><span class="requerimiento-badge ${tipoClass}">${r.tipo_requerimiento}</span></td>
                        <td>${r.observacion ? r.observacion.substring(0, 30) + '...' : ''}</td>
                        <td>${fechaRespuesta}</td>
                        <td>${r.ven_des || r.co_ven}</td>
                        <td><span class="status-badge status-${r.estatus}">${r.estatus == 1 ? 'Activo' : 'Inactivo'}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" onclick="verDetalle(${r.id})"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-outline-warning" onclick="editarLlamada(${r.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger" onclick="eliminarLlamada(${r.id})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `);
            });
        }
        
        function getTipoClass(tipo) {
            const classes = {
                'CONSULTA': 'requerimiento-consulta',
                'RECLAMO': 'requerimiento-reclamo',
                'SOPORTE': 'requerimiento-soporte',
                'VENTA': 'requerimiento-venta'
            };
            return classes[tipo] || 'requerimiento-consulta';
        }
        
        function actualizarPaginacion() {
            const totalPages = Math.ceil(totalRecords / recordsPerPage);
            const pagination = $('#pagination');
            pagination.empty();
            
            if (totalPages <= 1) return;
            
            pagination.append(`<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="cambiarPagina(${currentPage - 1})">&laquo;</a>
            </li>`);
            
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    pagination.append(`<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
                    </li>`);
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    pagination.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
                }
            }
            
            pagination.append(`<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="cambiarPagina(${currentPage + 1})">&raquo;</a>
            </li>`);
        }
        
        function cambiarPagina(page) {
            currentPage = page;
            mostrarLlamadasPagina(page);
            actualizarPaginacion();
        }
        
        function crearLlamada() {
            if (!validarFormulario()) return;
            
            const formData = $('#nuevoLlamadaForm').serialize();
            
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=create',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Éxito', 'Llamada registrada', 'success');
                        $('#nuevoLlamadaModal').modal('hide');
                        $('#nuevoLlamadaForm')[0].reset();
                        configurarFechaActual();
                        cargarLlamadas();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }
            });
        }
        
        function validarFormulario() {
            if (!$('#co_cli').val()) {
                Swal.fire('Error', 'Debe seleccionar un cliente', 'error');
                return false;
            }
            if (!$('#fecha_hora_llamada').val()) {
                Swal.fire('Error', 'Debe ingresar fecha y hora', 'error');
                return false;
            }
            if (!$('#tipo_requerimiento').val()) {
                Swal.fire('Error', 'Debe seleccionar tipo de requerimiento', 'error');
                return false;
            }
            if (!$('#co_ven').val()) {
                Swal.fire('Error', 'Debe seleccionar un vendedor', 'error');
                return false;
            }
            return true;
        }
        
        function editarLlamada(id) {
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=read&id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        const r = response.data[0];
                        const fechaHora = r.fecha_hora_llamada ? r.fecha_hora_llamada.slice(0, 16) : '';
                        
                        const html = `
                            <input type="hidden" id="edit_co_cli" name="co_cli" value="${r.co_cli}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Cliente</label>
                                    <div class="alert alert-info">${r.co_cli} - ${r.des_cli}</div>
                                    <input type="hidden" name="des_cli" value="${r.des_cli}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha y Hora *</label>
                                    <input type="datetime-local" class="form-control" id="edit_fecha_hora" name="fecha_hora_llamada" value="${fechaHora}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha Respuesta</label>
                                    <input type="date" class="form-control" id="edit_fecha_respuesta" name="fecha_posible_respuesta" value="${r.fecha_posible_respuesta || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo *</label>
                                    <select class="form-select" id="edit_tipo" name="tipo_requerimiento" required>
                                        ${generarOpcionesTipo(r.tipo_requerimiento)}
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Vendedor *</label>
                                    <select class="form-select" id="edit_co_ven" name="co_ven" required>
                                        ${generarOpcionesVendedores(r.co_ven)}
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Observación</label>
                                    <textarea class="form-control" id="edit_observacion" name="observacion" rows="3">${r.observacion || ''}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Dato Extra 1</label>
                                    <input type="text" class="form-control" id="edit_dato1" name="dato_extra1" value="${r.dato_extra1 || ''}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Dato Extra 2</label>
                                    <input type="text" class="form-control" id="edit_dato2" name="dato_extra2" value="${r.dato_extra2 || ''}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Dato Extra 3</label>
                                    <input type="text" class="form-control" id="edit_dato3" name="dato_extra3" value="${r.dato_extra3 || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estatus</label>
                                    <select class="form-select" id="edit_estatus" name="estatus">
                                        <option value="1" ${r.estatus == 1 ? 'selected' : ''}>Activo</option>
                                        <option value="0" ${r.estatus == 0 ? 'selected' : ''}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        `;
                        
                        $('#edit_id').val(id);
                        $('#editarLlamadaBody').html(html);
                        $('#editarLlamadaModal').modal('show');
                        
                        $('#editarLlamadaForm').off('submit').on('submit', function(e) {
                            e.preventDefault();
                            actualizarLlamada();
                        });
                    }
                }
            });
        }
        
        function generarOpcionesTipo(seleccionado) {
            const tipos = ['CONSULTA', 'RECLAMO', 'SOPORTE', 'VENTA', 'SEGUIMIENTO', 'COTIZACION', 'FACTURACION', 'OTRO'];
            return tipos.map(t => `<option value="${t}" ${t === seleccionado ? 'selected' : ''}>${t}</option>`).join('');
        }
        
        function generarOpcionesVendedores(seleccionado) {
            let options = '<option value="">Seleccionar...</option>';
            vendedoresList.forEach(v => {
                options += `<option value="${v.co_ven}" ${v.co_ven === seleccionado ? 'selected' : ''}>${v.ven_des}</option>`;
            });
            return options;
        }
        
        function actualizarLlamada() {
            const formData = $('#editarLlamadaForm').serialize();
            
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=update',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Éxito', 'Llamada actualizada', 'success');
                        $('#editarLlamadaModal').modal('hide');
                        cargarLlamadas();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }
            });
        }
        
        function eliminarLlamada(id) {
            Swal.fire({
                title: '¿Eliminar?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'admin/index.php?action=llamadas&accion=delete',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Eliminado', 'Llamada eliminada', 'success');
                                cargarLlamadas();
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        }
                    });
                }
            });
        }
        
        function verDetalle(id) {
            $.ajax({
                url: 'admin/index.php?action=llamadas&accion=read&id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        const r = response.data[0];
                        const fecha = new Date(r.fecha_hora_llamada).toLocaleString();
                        const fechaRespuesta = r.fecha_posible_respuesta ? new Date(r.fecha_posible_respuesta).toLocaleDateString() : 'No definida';
                        
                        Swal.fire({
                            title: 'Detalles de la Llamada',
                            html: `
                                <div style="text-align: left;">
                                    <p><strong>ID:</strong> ${r.id}</p>
                                    <p><strong>Cliente:</strong> ${r.co_cli} - ${r.des_cli}</p>
                                    <p><strong>Fecha:</strong> ${fecha}</p>
                                    <p><strong>Fecha Respuesta:</strong> ${fechaRespuesta}</p>
                                    <p><strong>Tipo:</strong> ${r.tipo_requerimiento}</p>
                                    <p><strong>Vendedor:</strong> ${r.ven_des || r.co_ven}</p>
                                    <p><strong>Observación:</strong> ${r.observacion || 'Sin observación'}</p>
                                    ${r.dato_extra1 ? `<p><strong>Dato 1:</strong> ${r.dato_extra1}</p>` : ''}
                                    ${r.dato_extra2 ? `<p><strong>Dato 2:</strong> ${r.dato_extra2}</p>` : ''}
                                    ${r.dato_extra3 ? `<p><strong>Dato 3:</strong> ${r.dato_extra3}</p>` : ''}
                                </div>
                            `,
                            confirmButtonText: 'Cerrar',
                            width: '600px'
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>