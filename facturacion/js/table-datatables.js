


function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function cargarTablaFacturas(dataPedidos) {
    let dataTableFacturas = $('.dataTableFacturas');
    
    if (dataTableFacturas.length) {
        // Destruir tabla existente si la hay
        if ($.fn.DataTable.isDataTable(dataTableFacturas)) {
            dataTableFacturas.DataTable().destroy();
        }

        try {
            let arrayFacturas = JSON.parse(dataPedidos);

            
      // Agregar botón de actualización al header si no existe
            if ($('.btn-refresh-facturas').length === 0) {
                $('.card-header.border-bottom.p-1 .head-label').append(`
                    <button type="button" class="btn btn-relief-success btn-refresh-facturas ms-2" onclick="refreshFacturasTable()">
                        <i class="ri-refresh-line me-50"></i>Actualizar
                    </button>
                `);
            }
            
            var dt_basic = dataTableFacturas.DataTable({
                data: arrayFacturas,
                columns: [
                    { data: 'responsive_id' },  // 0 - Para responsive
                    { data: 'co_cli' },          // 1 - Código cliente
                    { data: 'fact_num' },        // 2 - Número factura
                    { data: 'cli_des' },           // 3 - Nombre cliente
                    { data: 'fec_emis' },         // 4 - Fecha emisión
                    { data: 'fec_venc' },         // 5 - Fecha vencimiento
                    { data: 'saldo_bs' },         // 6 - Saldo Bs
                    { data: 'saldo_usd' },        // 7 - Saldo USD
                    { data: 'tasa' },              // 8 - Tasa
                    { data: 'iva' },                // 9 - IVA
                    { data: 'status' },             // 10 - Status
                    { data: 'anulada' },            // 11 - Anulada
                    { data: 'fact_num' }                     // 12 - Acciones
                ],
                columnDefs: [
                    // Columna responsive
                    {
                        className: 'control',
                        orderable: false,
                        responsivePriority: 12,
                        targets: 0
                    },
                    
                    // Número de factura (visible)
                    {
                        targets: 2,
                        title: 'Nº Factura',
                        width: '10%',
                        render: function(data, type, full) {
                            // Formatear facturas que empiezan con 5
                            let facturaText = data;
                            if (data.toString().startsWith('5') && data.toString().length === 8) {
                                facturaText = 'NF' + data.toString().substring(2);
                            }
                            return `<strong>
                          
                            <a href="index.php?view=documento&fact_num=${facturaText}&s=${facturaText}">${facturaText}</a></strong><br>  ${full.tipo_doc}`;
                        }
                    },
                    
                    // Cliente
                    {
                        targets: 3,
                        title: 'Cliente',
                        width: '35%',
                        render: function(data, type, full) {
                            return `<div>
                                <small class="text-muted">${full.co_cli || ''}</small><br>
                                <span>${data || ''}</span>
                            </div>`;
                        }
                    },
                    
                    // Fecha emisión
                    {
                        targets: 4,
                        title: 'Emisión',
                        width: '10%',
                        render: function(data) {
                            return formatFechaGlobal(data);
                        }
                    },
                    
                    // Fecha vencimiento
                    {
                        targets: 5,
                        title: 'Vencimiento',
                        width: '10%',
                        render: function(data, type, full) {
                            const fecha = formatFechaGlobal(data);
                            const hoy = new Date();
                            const venc = new Date(data);
                            const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
                            
                            let clase = '';
                            if (diasDiff < 0) clase = 'text-danger fw-bold';
                            else if (diasDiff <= 5) clase = 'text-warning fw-bold';
                            
                            return `<span class="${clase}">${fecha}</span>`;
                        }
                    },
                    
                    // Saldo Bs
                    {
                        targets: 6,
                        title: 'Saldo Bs.',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            if (full.moneda !== 'USD' && data > 0) {
                                return formatoEuropeo(data);
                            }
                            return '-';
                        }
                    },
                    
                    // Saldo USD
                    {
                        targets: 7,
                        title: 'Saldo USD',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            let saldo_usd = full['saldo_usd'];
                        
                                return formatoEuropeo(saldo_usd);
                        
                        }
                    },
                    
                    // Tasa
                    {
                        targets: 8,
                        title: 'Tasa',
                        width: '8%',
                        render: function(data) {
                            return formatoEuropeo(data);
                        }
                    },
                    
                    // IVA / Retención
                    {
                        targets: 9,
                        title: 'IVA',
                        width: '7%',
                          visible : false,
                        render: function(data, type, full) {
                            if (full.contrib == 1 && full.iva > 0) {
                                return `<span class="badge bg-primary">Aplica Ret.</span>`;
                            }
                            return data > 0 ? formatoEuropeo(data) : 'N/A';
                        }
                    },
                    
                    // Status
                    {
                        targets: 10,
                        title: 'Estatus',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            let statusClass = '';
                            let statusText = '';
                            
                            if (full.anulada == 1) {
                                statusClass = 'badge bg-secondary';
                                statusText = 'Anulada';
                            } else if (full.saldo <= 0) {
                                statusClass = 'badge bg-success';
                                statusText = 'Pagada';
                            } else {
                                const hoy = new Date();
                                const venc = new Date(full.fec_venc);
                                const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
                                
                                if (diasDiff < 0) {
                                    statusClass = 'badge bg-danger';
                                    statusText = 'Vencida';
                                } else if (diasDiff <= 5) {
                                    statusClass = 'badge bg-warning';
                                    statusText = 'Por Vencer';
                                } else {
                                    statusClass = 'badge bg-info';
                                    statusText = 'Vigente';
                                }
                            }
                            
                            return `<span class="${statusClass}">${statusText}</span>`;
                        }
                    },
                    
                    // Anulada (oculto)
                    {
                        targets: 11,
                        visible: false
                    },
                        // Anulada (oculto)
                  
               
                    {
                        targets: 12,
                        title: 'Acciones',
                        width: '120px', // Un poco más de ancho para que luzcan los botones
                        orderable: false,
                        render: function(data, type, full, meta) {
                            let accionesHtml = '<div class="d-flex align-items-center justify-content-center col-actions">';
                            
                            const tipoDocumento = full.tipo_documento || full.tipo_factura || 0;
                            const esFiscal = tipoDocumento === '1' || tipoDocumento === 1;
                            const esNoFiscal = tipoDocumento === '6' || tipoDocumento === 6;
                            
                            if (full.anulada != 1) {
                                // BOTÓN VER (Azul/Info) - Común para ambos
                                let urlVer = esFiscal ? 
                                    `index.php?view=documento&fact_num=${full.fact_num}&s=${full.status}` : 
                                    `index.php?view=documento&fact_num=${full.fact_num}&s=${full.status}`;

                             

                                if (esFiscal) {
                                    // BOTÓN FISCALIZAR (Naranja/Warning) - Solo Fiscales
                                    accionesHtml += `
                                        <button class="btn btn-sm btn-icon btn-relief-warning me-50 btn-emitir-tfhka" data-id="${full.fact_num}" data-tipo="fiscal" data-bs-toggle="tooltip" title="Enviar a Fiscalización">
                                            ${feather.icons['printer'].toSvg({ class: 'font-medium-3' })}
                                        </button>
                                        
                                        <a href="../admin/index.php?action=reporte&tipo=11&fact_num=${full.fact_num}" target="_blank" class="btn btn-sm btn-icon btn-relief-danger me-50" data-bs-toggle="tooltip" title="Descargar PDF Fiscal">
                                            ${feather.icons['download'].toSvg({ class: 'font-medium-3' })}
                                        </a>`;   accionesHtml += `
                                    <a href="${urlVer}" class="btn btn-sm btn-icon btn-relief-info me-50" data-bs-toggle="tooltip" title="Visualizar Detalle">
                                        ${feather.icons['eye'].toSvg({ class: 'font-medium-3' })}
                                    </a>`;
                                } else if (esNoFiscal) {
                                    // BOTÓN PDF NORMAL (Rojo/Danger) - Solo No Fiscales
                                   
                                    accionesHtml += `
                                     <button class="btn btn-sm btn-icon btn-relief-primary  me-50 btn-enviar-factura-email-nota" 
                                                    data-fact-num="${full.fact_num}"
                                                    data-cliente="${escapeHtml(full.cli_des || '')}"
                                                    data-email="${escapeHtml(full.email_cli || '')}"
                                                    data-tipo ="6"
                                                    data-bs-toggle="tooltip" 
                                                    title="Enviar por Correo">
                                                ${feather.icons['send'].toSvg({ class: 'font-medium-2' })}
                                            </button>
                                        <a href="../admin/index.php?action=reporte&tipo=10&fact_num=${full.fact_num}" target="_blank" class="btn btn-sm btn-icon btn-relief-danger me-50" data-bs-toggle="tooltip" title="Generar PDF">
                                            ${feather.icons['download'].toSvg({ class: 'font-medium-3' })}
                                        </a>`;
                                           accionesHtml += `
                                    <a href="${urlVer}" class="btn btn-sm btn-icon btn-relief-info me-50" data-bs-toggle="tooltip" title="Visualizar Detalle">
                                        ${feather.icons['eye'].toSvg({ class: 'font-medium-3' })}
                                    </a>`;
                                } else {
                                    // BOTÓN GENÉRICO (Verde/Success)
                                    accionesHtml += `
                                        <button class="btn btn-sm btn-icon btn-relief-success btn-emitir-otro" data-id="${full.fact_num}" data-bs-toggle="tooltip" title="Emitir">
                                            ${feather.icons['plus-circle'].toSvg({ class: 'font-medium-3' })}
                                        </button>`;
                                }
                            } else {
                                // INDICADOR DE ANULADA
                                accionesHtml += `<span class="badge badge-light-secondary text-uppercase">Sin Acciones</span>`;
                            }
                            
                            accionesHtml += '</div>';
                            return accionesHtml;
                        }
                    },
                    
                    // Columnas ocultas (datos auxiliares)
                    {
                        targets: 1,
                        visible: false  // co_cli (ya se muestra en el cliente)
                    }
                ],
                
                //order: [[, 'desc']], // Ordenar por fecha emisión descendente
                
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>>' +
                     '<"d-flex justify-content-between align-items-center mx-0 row"' +
                     '<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     't' +
                     '<"d-flex justify-content-between mx-0 row"' +
                     '<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                
                displayLength: 75,
                lengthMenu: [10, 25, 50, 75, 100],
                
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: '<i class="ri-share-line me-50"></i>Exportar',
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="ri-file-excel-line me-50"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ri-file-pdf-line me-50"></i>Pdf',
                                className: 'dropdown-item',
                                orientation: 'landscape',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="ri-search-line me-50"></i>Actualizar',
                        className: 'btn btn-relief-info btn-floating-refresh',
                        action: function() {
                            refreshFacturasTable();
                        }
                    }
                     
                ],
                
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                return 'Detalles de Factura';
                            }
                        }),
                        renderer: function(api, rowIdx, columns) {
                            let data = $.map(columns, function(col) {
                                return col.title ? 
                                    '<tr><td><strong>' + col.title + ':</strong></td><td>' + col.data + '</td></tr>' : 
                                    '';
                            }).join('');
                            
                            return data ? $('<table class="table table-sm"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ resultados",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible",
                    "sInfo": "Mostrando _START_-_END_ de _TOTAL_",
                    "sInfoEmpty": "Mostrando 0-0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                }
            });
            
        } catch (error) {
            console.error('Error al cargar la tabla de facturas:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos de facturas'
            });
        }
    }
}

function cargarTablaDocumentos(data) {
    let dataTableFacturas = $('.dataTableDocumentos');
    
    if (dataTableFacturas.length) {
        // Destruir tabla existente si la hay
        if ($.fn.DataTable.isDataTable(dataTableFacturas)) {
            dataTableFacturas.DataTable().destroy();
        }

        try {
            let arrayFacturas = JSON.parse(data);

            
      // Agregar botón de actualización al header si no existe
            if ($('.btn-refresh-facturas').length === 0) {
                $('.card-header.border-bottom.p-1 .head-label').append(`
                    <button type="button" class="btn btn-relief-success btn-refresh-facturas ms-2" onclick="refreshFacturasTable()">
                        <i class="ri-refresh-line me-50"></i>Actualizar
                    </button>
                `);
            }
            
            var dt_basic = dataTableFacturas.DataTable({
                data: arrayFacturas,
                columns: [
                    { data: 'responsive_id' },  // 0 - Para responsive
                    { data: 'co_cli' },          // 1 - Código cliente
                    { data: 'fact_num' },        // 2 - Número factura
                    { data: 'cli_des' },           // 3 - Nombre cliente
                    { data: 'fec_emis' },         // 4 - Fecha emisión
                    { data: 'fec_venc' },         // 5 - Fecha vencimiento
                    { data: 'saldo_bs' },         // 6 - Saldo Bs
                    { data: 'saldo_usd' },        // 7 - Saldo USD
                    { data: 'tasa' },              // 8 - Tasa
                    { data: 'iva' },                // 9 - IVA
                    { data: 'status' },             // 10 - Status
                    { data: 'anulada' },            // 11 - Anulada
                    { data: 'fact_num' }                     // 12 - Acciones
                ],
                columnDefs: [
                    // Columna responsive
                    {
                        className: 'control',
                        orderable: false,
                        responsivePriority: 12,
                        targets: 0
                    },
                    
                    // Número de factura (visible)
                    {
                        targets: 2,
                        title: 'Nº Factura',
                        width: '10%',
                        render: function(data, type, full) {
                            // Formatear facturas que empiezan con 5
                            let facturaText = data;
                            if (data.toString().startsWith('5') && data.toString().length === 8) {
                                facturaText = 'NF' + data.toString().substring(2);
                            }
                            return `<strong><a href="index.php?view=documento&fact_num=${facturaText}&s=${facturaText}">${facturaText}</a></strong>`;
                        }
                    },
                    
                    // Cliente
                    {
                        targets: 3,
                        title: 'Cliente',
                        width: '45%',
                        render: function(data, type, full) {
                            return `<div>
                                <small class="text-muted">${full.co_cli || ''}</small><br>
                                <span>${data || ''}</span>
                            </div>`;
                        }
                    },
                    
                    // Fecha emisión
                    {
                        targets: 4,
                        title: 'Emisión',
                        width: '10%',
                        render: function(data) {
                            return formatFechaGlobal(data);
                        }
                    },
                    
                    // Fecha vencimiento
                    {
                        targets: 5,
                        title: 'Vencimiento',
                        width: '10%',
                        render: function(data, type, full) {
                            const fecha = formatFechaGlobal(data);
                            const hoy = new Date();
                            const venc = new Date(data);
                            const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
                            
                            let clase = '';
                            if (diasDiff < 0) clase = 'text-danger fw-bold';
                            else if (diasDiff <= 5) clase = 'text-warning fw-bold';
                            
                            return `<span class="${clase}">${fecha}</span>`;
                        }
                    },
                    
                    // Saldo Bs
                    {
                        targets: 6,
                        title: 'Saldo Bs.',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            if (full.moneda !== 'USD' && data > 0) {
                                return formatoEuropeo(data);
                            }
                            return '-';
                        }
                    },
                    
                    // Saldo USD
                    {
                        targets: 7,
                        title: 'Saldo USD',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            let saldo_usd = full['saldo_usd'];
                        
                                return formatoEuropeo(saldo_usd);
                        
                        }
                    },
                    
                    // Tasa
                    {
                        targets: 8,
                        title: 'Tasa',
                        width: '8%',
                        render: function(data) {
                            return formatoEuropeo(data);
                        }
                    },
                    
                    // IVA / Retención
                    {
                        targets: 9,
                        title: 'IVA',
                        width: '7%',
                          visible : false,
                        render: function(data, type, full) {
                            if (full.contrib == 1 && full.iva > 0) {
                                return `<span class="badge bg-primary">Aplica Ret.</span>`;
                            }
                            return data > 0 ? formatoEuropeo(data) : 'N/A';
                        }
                    },
                    
                    // Status
                    {
                        targets: 10,
                        title: 'Estatus',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            let statusClass = '';
                            let statusText = '';
                            
                            if (full.anulada == 1) {
                                statusClass = 'badge bg-secondary';
                                statusText = 'Anulada';
                            } else if (full.saldo <= 0) {
                                statusClass = 'badge bg-success';
                                statusText = 'Pagada';
                            } else {
                                const hoy = new Date();
                                const venc = new Date(full.fec_venc);
                                const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
                                
                                if (diasDiff < 0) {
                                    statusClass = 'badge bg-danger';
                                    statusText = 'Vencida';
                                } else if (diasDiff <= 5) {
                                    statusClass = 'badge bg-warning';
                                    statusText = 'Por Vencer';
                                } else {
                                    statusClass = 'badge bg-info';
                                    statusText = 'Vigente';
                                }
                            }
                            
                            return `<span class="${statusClass}">${statusText}</span>`;
                        }
                    },
                    
                    // Anulada (oculto)
                    {
                        targets: 11,
                        visible: false
                    },
                        // Anulada (oculto)
                  
                    // Acciones
                        // Reemplazar el bloque de acciones completo con este:
                       // Acciones
                        {
                            targets: 12,
                            title: 'Acciones',
                            width: '180px', 
                            orderable: false,
                            render: function(data, type, full, meta) {
                                let accionesHtml = '<div class="d-flex align-items-center justify-content-center col-actions flex-nowrap">';
                                
                                // Obtenemos el tipo de documento (accion)
                                // Asegúrate de que tu JSON traiga el campo 'accion' o cámbialo por el nombre correcto
                                const tipoDoc = parseInt(full.tipo_doc || full.tipo_doc || 0);
                                const statusDoc = full.status || '';
                                const factNum = full.fact_num;
                                const factAfectada = full.fact_num || ''; // Asegúrate de tener este dato en el JSON

                                if (full.anulada != 1) {
                                    
                                    // 1. BOTÓN VER - Siempre presente
                                    accionesHtml += `
                                        <a href="index.php?view=documento&fact_num=${factNum}&s=${statusDoc}" 
                                        class="btn btn-sm btn-icon btn-relief-info me-25" 
                                        data-bs-toggle="tooltip" title="Ver Detalle">
                                            ${feather.icons['eye'].toSvg({ class: 'font-medium-2' })}
                                        </a>`;

                                    // 2. LÓGICA SEGÚN TIPO DE DOCUMENTO
                                    if (tipoDoc === 1) { // FACTURA FISCAL
                                        accionesHtml += `
                                          
                                            <a href="../admin/index.php?action=reporte&tipo=11&fact_num=${factNum}" target="_blank" class="btn btn-sm btn-icon btn-relief-danger me-25" data-bs-toggle="tooltip" title="PDF Fiscal">
                                                ${feather.icons['file-text'].toSvg({ class: 'font-medium-2' })}
                                            </a>`;
                                    } 
                                    else if (tipoDoc === 3) { // NOTA DE CRÉDITO
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-warning me-25 btn-nota-tfhka" 
                                                data-id="${factNum}" 
                                                data-factura-afectada="${factAfectada}" 
                                                data-bs-toggle="tooltip" title="Fiscalizar Nota de Crédito">
                                                ${feather.icons['minus-circle'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    } 
                                    else if (tipoDoc === 4) { // NOTA DE DÉBITO
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-warning me-25 btn-nota-db-tfhka" 
                                                data-id="${factNum}" 
                                                data-factura-afectada="${factAfectada}" 
                                                data-bs-toggle="tooltip" title="Fiscalizar Nota de Débito">
                                                ${feather.icons['plus-circle'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    }
                                    else if (tipoDoc === 6) { // NO FISCAL
                                        accionesHtml += `
                                            <a href="../admin/index.php?action=reporte&tipo=10&fact_num=${factNum}" target="_blank" class="btn btn-sm btn-icon btn-relief-danger me-25" data-bs-toggle="tooltip" title="Descargar PDF">
                                                ${feather.icons['download'].toSvg({ class: 'font-medium-2' })}
                                            </a>`;
                                    }

                                    // 3. BOTÓN EMAIL (Si aplica para estos tipos)
                                    if ([1, 3, 4, 6].includes(tipoDoc)) {
                                        const btnEmailClass = (tipoDoc === 6) ? 'btn-enviar-factura-email-nota' : 'btn-enviar-factura-email';
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-primary ${btnEmailClass}" 
                                                data-fact-num="${factNum}"
                                                data-cliente="${escapeHtml(full.cli_des || '')}"
                                                data-email="${escapeHtml(full.email_cli || '')}"
                                                data-tipo="${tipoDoc}"
                                                data-bs-toggle="tooltip" title="Enviar por Correo">
                                                ${feather.icons['send'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    }

                                } else {
                                    // DOCUMENTO ANULADO
                                    accionesHtml += `
                                        <span class="badge badge-light-secondary" data-bs-toggle="tooltip" title="Documento Anulado">
                                            ${feather.icons['shield-off'].toSvg({ class: 'font-medium-2 me-25' })} Anulada
                                        </span>`;
                                }
                                
                                accionesHtml += '</div>';
                                return accionesHtml;
                            }
                        },
                    
                    // Columnas ocultas (datos auxiliares)
                    {
                        targets: 1,
                        visible: false  // co_cli (ya se muestra en el cliente)
                    }
                ],
                
                order: [[2, 'desc']], // Ordenar por fecha emisión descendente
                
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>>' +
                     '<"d-flex justify-content-between align-items-center mx-0 row"' +
                     '<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     't' +
                     '<"d-flex justify-content-between mx-0 row"' +
                     '<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                
                displayLength: 75,
                lengthMenu: [10, 25, 50, 75, 100],
                
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: '<i class="ri-share-line me-50"></i>Exportar',
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="ri-file-excel-line me-50"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ri-file-pdf-line me-50"></i>Pdf',
                                className: 'dropdown-item',
                                orientation: 'landscape',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="ri-search-line me-50"></i>Actualizar',
                        className: 'btn btn-relief-info btn-floating-refresh',
                        action: function() {
                            refreshFacturasTable();
                        }
                    }
                     
                ],
                
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                return 'Detalles de Factura';
                            }
                        }),
                        renderer: function(api, rowIdx, columns) {
                            let data = $.map(columns, function(col) {
                                return col.title ? 
                                    '<tr><td><strong>' + col.title + ':</strong></td><td>' + col.data + '</td></tr>' : 
                                    '';
                            }).join('');
                            
                            return data ? $('<table class="table table-sm"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ resultados",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible",
                    "sInfo": "Mostrando _START_-_END_ de _TOTAL_",
                    "sInfoEmpty": "Mostrando 0-0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                }
            });
            
        } catch (error) {
            console.error('Error al cargar la tabla de facturas:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos de facturas'
            });
        }
    }
}

function cargarTablaNotascrdev(data) {
    let dataTableFacturas = $('.dataTableDocumentosNotasCreditoDev');
    
    if (dataTableFacturas.length) {
        // Destruir tabla existente si la hay
        if ($.fn.DataTable.isDataTable(dataTableFacturas)) {
            dataTableFacturas.DataTable().destroy();
        }

        try {
            let arrayFacturas = JSON.parse(data);

            
      // Agregar botón de actualización al header si no existe
            if ($('.btn-refresh-facturas').length === 0) {
                $('.card-header.border-bottom.p-1 .head-label').append(`
                    <button type="button" class="btn btn-relief-success btn-refresh-facturas ms-2" onclick="refreshFacturasTable()">
                        <i class="ri-refresh-line me-50"></i>Actualizar
                    </button>
                `);
            }
            
            var dt_basic = dataTableFacturas.DataTable({
                data: arrayFacturas,
                columns: [
                    { data: 'responsive_id' },  // 0 - Para responsive
                    { data: 'co_cli' },          // 1 - Código cliente
                    { data: 'fact_num' },        // 2 - Número factura
                    { data: 'cli_des' },           // 3 - Nombre cliente
                    { data: 'fec_emis' },         // 4 - Fecha emisión
                    { data: 'fec_venc' },         // 5 - Fecha vencimiento
                    { data: 'saldo_bs' },         // 6 - Saldo Bs
                    { data: 'saldo_usd' },        // 7 - Saldo USD
                    { data: 'tasa' },              // 8 - Tasa
                    { data: 'iva' },                // 9 - IVA
                    { data: 'status' },             // 10 - Status
                    { data: 'anulada' },            // 11 - Anulada
                    { data: 'fact_num' }                     // 12 - Acciones
                ],
                columnDefs: [
                    // Columna responsive
                    {
                        className: 'control',
                        orderable: false,
                        responsivePriority: 12,
                        targets: 0
                    },
                    
                    // Número de factura (visible)
                    {
                        targets: 2,
                        title: 'Nº Factura',
                        width: '10%',
                        render: function(data, type, full) {
                            // Formatear facturas que empiezan con 5
                            let facturaText = data;
                            if (data.toString().startsWith('5') && data.toString().length === 8) {
                                facturaText = 'NF' + data.toString().substring(2);
                            }
                            return `<strong><a href="index.php?view=documento&fact_num=${facturaText}&s=${facturaText}">${facturaText}</a></strong>`;
                        }
                    },
                    
                    // Cliente
                    {
                        targets: 3,
                        title: 'Cliente',
                        width: '45%',
                        render: function(data, type, full) {
                            return `<div>
                                <small class="text-muted">${full.co_cli || ''}</small><br>
                                <span>${data || ''}</span>
                            </div>`;
                        }
                    },
                    
                    // Fecha emisión
                    {
                        targets: 4,
                        title: 'Emisión',
                        width: '10%',
                        render: function(data) {
                            return formatFechaGlobal(data);
                        }
                    },
                    
                    // Fecha vencimiento
                    {
                        targets: 5,
                        title: 'Vencimiento',
                        width: '10%',
                        render: function(data, type, full) {
                            const fecha = formatFechaGlobal(data);
                            const hoy = new Date();
                            const venc = new Date(data);
                            const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
                            
                            let clase = '';
                            if (diasDiff < 0) clase = 'text-danger fw-bold';
                            else if (diasDiff <= 5) clase = 'text-warning fw-bold';
                            
                            return `<span class="${clase}">${fecha}</span>`;
                        }
                    },
                    
                    // Saldo Bs
                    {
                        targets: 6,
                        title: 'Saldo Bs.',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            if (full.moneda !== 'USD' && data > 0) {
                                return formatoEuropeo(data);
                            }
                            return '-';
                        }
                    },
                    
                    // Saldo USD
                    {
                        targets: 7,
                        title: 'Saldo USD',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            let saldo_usd = full['saldo_usd'];
                        
                                return formatoEuropeo(saldo_usd);
                        
                        }
                    },
                    
                    // Tasa
                    {
                        targets: 8,
                        title: 'Tasa',
                        width: '8%',
                        render: function(data) {
                            return formatoEuropeo(data);
                        }
                    },
                    
                    // IVA / Retención
                    {
                        targets: 9,
                        title: 'IVA',
                        width: '7%',
                          visible : false,
                        render: function(data, type, full) {
                            if (full.contrib == 1 && full.iva > 0) {
                                return `<span class="badge bg-primary">Aplica Ret.</span>`;
                            }
                            return data > 0 ? formatoEuropeo(data) : 'N/A';
                        }
                    },
                    
                    // Status
                    {
                        targets: 10,
                        title: 'Estatus',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            let statusClass = '';
                            let statusText = '';
                            
                            if (full.anulada == 1) {
                                statusClass = 'badge bg-secondary';
                                statusText = 'Anulada';
                            } else if (full.saldo <= 0) {
                                statusClass = 'badge bg-success';
                                statusText = 'Pagada';
                            } else {
                                const hoy = new Date();
                                const venc = new Date(full.fec_venc);
                                const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
                                
                                if (diasDiff < 0) {
                                    statusClass = 'badge bg-danger';
                                    statusText = 'Vencida';
                                } else if (diasDiff <= 5) {
                                    statusClass = 'badge bg-warning';
                                    statusText = 'Por Vencer';
                                } else {
                                    statusClass = 'badge bg-info';
                                    statusText = 'Vigente';
                                }
                            }
                            
                            return `<span class="${statusClass}">${statusText}</span>`;
                        }
                    },
                    
                    // Anulada (oculto)
                    {
                        targets: 11,
                        visible: false
                    },
                        // Anulada (oculto)
                  
                    // Acciones
                        // Reemplazar el bloque de acciones completo con este:
                       // Acciones
                        {
                            targets: 12,
                            title: 'Acciones',
                            width: '180px', 
                            orderable: false,
                            render: function(data, type, full, meta) {
                                let accionesHtml = '<div class="d-flex align-items-center justify-content-center col-actions flex-nowrap">';
                                
                                // Obtenemos el tipo de documento (accion)
                                // Asegúrate de que tu JSON traiga el campo 'accion' o cámbialo por el nombre correcto
                                const tipoDoc = parseInt(full.tipo_doc || full.tipo_doc || 0);
                                const statusDoc = full.status || '';
                                const factNum = full.fact_num;
                                const factAfectada = full.fact_num || ''; // Asegúrate de tener este dato en el JSON

                                if (full.anulada != 1) {
                                    
                                    // 1. BOTÓN VER - Siempre presente
                                    accionesHtml += `
                                        <a href="index.php?view=documento&fact_num=${factNum}&s=${statusDoc}" 
                                        class="btn btn-sm btn-icon btn-relief-info me-25" 
                                        data-bs-toggle="tooltip" title="Ver Detalle">
                                            ${feather.icons['eye'].toSvg({ class: 'font-medium-2' })}
                                        </a>`;

                                    // 2. LÓGICA SEGÚN TIPO DE DOCUMENTO
                                    if (tipoDoc === 1) { // FACTURA FISCAL
                                        accionesHtml += `
                                          
                                            <a href="../admin/index.php?action=reporte&tipo=11&fact_num=${factNum}" target="_blank" class="btn btn-sm btn-icon btn-relief-danger me-25" data-bs-toggle="tooltip" title="PDF Fiscal">
                                                ${feather.icons['file-text'].toSvg({ class: 'font-medium-2' })}
                                            </a>`;
                                    } 
                                    else if (tipoDoc === 3) { // NOTA DE CRÉDITO
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-warning me-25 btn-nota-tfhka" 
                                                data-id="${factNum}" 
                                                data-factura-afectada="${factAfectada}" 
                                                data-bs-toggle="tooltip" title="Fiscalizar Nota de Crédito">
                                                ${feather.icons['minus-circle'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    } 
                                    else if (tipoDoc === 4) { // NOTA DE DÉBITO
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-warning me-25 btn-nota-db-tfhka" 
                                                data-id="${factNum}" 
                                                data-factura-afectada="${factAfectada}" 
                                                data-bs-toggle="tooltip" title="Fiscalizar Nota de Débito">
                                                ${feather.icons['plus-circle'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    }
                                    else if (tipoDoc === 6) { // NO FISCAL
                                        accionesHtml += `
                                            <a href="../admin/index.php?action=reporte&tipo=10&fact_num=${factNum}" target="_blank" class="btn btn-sm btn-icon btn-relief-danger me-25" data-bs-toggle="tooltip" title="Descargar PDF">
                                                ${feather.icons['download'].toSvg({ class: 'font-medium-2' })}
                                            </a>`;
                                    }

                                    // 3. BOTÓN EMAIL (Si aplica para estos tipos)
                                    if ([1, 3, 4, 6].includes(tipoDoc)) {
                                        const btnEmailClass = (tipoDoc === 6) ? 'btn-enviar-factura-email-nota' : 'btn-enviar-factura-email';
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-primary ${btnEmailClass}" 
                                                data-fact-num="${factNum}"
                                                data-cliente="${escapeHtml(full.cli_des || '')}"
                                                data-email="${escapeHtml(full.email_cli || '')}"
                                                data-tipo="${tipoDoc}"
                                                data-bs-toggle="tooltip" title="Enviar por Correo">
                                                ${feather.icons['send'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    }

                                } else {
                                    // DOCUMENTO ANULADO
                                    accionesHtml += `
                                        <span class="badge badge-light-secondary" data-bs-toggle="tooltip" title="Documento Anulado">
                                            ${feather.icons['shield-off'].toSvg({ class: 'font-medium-2 me-25' })} Anulada
                                        </span>`;
                                }
                                
                                accionesHtml += '</div>';
                                return accionesHtml;
                            }
                        },
                    
                    // Columnas ocultas (datos auxiliares)
                    {
                        targets: 1,
                        visible: false  // co_cli (ya se muestra en el cliente)
                    }
                ],
                
                order: [[2, 'desc']], // Ordenar por fecha emisión descendente
                
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>>' +
                     '<"d-flex justify-content-between align-items-center mx-0 row"' +
                     '<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     't' +
                     '<"d-flex justify-content-between mx-0 row"' +
                     '<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                
                displayLength: 75,
                lengthMenu: [10, 25, 50, 75, 100],
                
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: '<i class="ri-share-line me-50"></i>Exportar',
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="ri-file-excel-line me-50"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ri-file-pdf-line me-50"></i>Pdf',
                                className: 'dropdown-item',
                                orientation: 'landscape',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="ri-search-line me-50"></i>Actualizar',
                        className: 'btn btn-relief-info btn-floating-refresh',
                        action: function() {
                            refreshFacturasTable();
                        }
                    }
                     
                ],
                
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                return 'Detalles de Factura';
                            }
                        }),
                        renderer: function(api, rowIdx, columns) {
                            let data = $.map(columns, function(col) {
                                return col.title ? 
                                    '<tr><td><strong>' + col.title + ':</strong></td><td>' + col.data + '</td></tr>' : 
                                    '';
                            }).join('');
                            
                            return data ? $('<table class="table table-sm"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ resultados",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible",
                    "sInfo": "Mostrando _START_-_END_ de _TOTAL_",
                    "sInfoEmpty": "Mostrando 0-0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                }
            });
            
        } catch (error) {
            console.error('Error al cargar la tabla de facturas:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos de facturas'
            });
        }
    }
}

function cargarTablaDocumentosNotas(data) {
    let dataTableFacturas = $('.dataTableDocumentosNotas');
    
    if (dataTableFacturas.length) {
        // Destruir tabla existente si la hay
        if ($.fn.DataTable.isDataTable(dataTableFacturas)) {
            dataTableFacturas.DataTable().destroy();
        }

        try {
            let arrayFacturas = JSON.parse(data);

            
      // Agregar botón de actualización al header si no existe
            if ($('.btn-refresh-facturas').length === 0) {
                $('.card-header.border-bottom.p-1 .head-label').append(`
                    <button type="button" class="btn btn-relief-success btn-refresh-facturas ms-2" onclick="refreshFacturasTable()">
                        <i class="ri-refresh-line me-50"></i>Actualizar
                    </button>
                `);
            }
            
            var dt_basic = dataTableFacturas.DataTable({
                data: arrayFacturas,
                columns: [
                    { data: 'responsive_id' },      // 0 - Para responsive
                    { data: 'co_cli' },             // 1 - Código cliente
                    { data: 'fact_num' },           // 2 - Número factura
                    { data: 'tipo_doc' },
                    { data: 'cli_des' },            // 4 - Nombre cliente
                    { data: 'fec_emis' },           // 5 - Fecha emisión
                    { data: 'saldo_bs' },           // 6 - Saldo Bs
                    { data: 'tasa' },               // 7 - Tasa
                    { data: 'iva' },                // 8 - IVA
                    { data: 'fact_num' }            // 9 - Acciones
                ],
                columnDefs: [
                    // Columna responsive
                    {
                        className: 'control',
                        orderable: false,
                        responsivePriority: 12,
                        targets: 0
                    },
                    
                    // Número de factura (visible)
                    {
                        targets: 2,
                        title: 'Nº Factura',
                        width: '10%',
                        render: function(data, type, full) {
                            // Formatear facturas que empiezan con 5
                            let facturaText = data;
                            if (data.toString().startsWith('5') && data.toString().length === 8) {
                                facturaText = 'NF' + data.toString().substring(2);
                            }
                            return `<strong>  <a href="#">${facturaText}</a></strong>`;
                        }
                    },
                    {
                        targets: 3,
                        title: 'Tipo Documento',
                        width: '10%',
                        render: function(data, type, full) {
                         
                            return `<strong>  <a href="#">${full.tipo_doc || ''}</a></strong>`;
                        }
                    },
                    // Cliente
                    {
                        targets: 4,
                        title: 'Cliente',
                        width: '45%',
                        render: function(data, type, full) {
                            return `<div>
                                <small class="text-muted">${full.co_cli || ''}</small><br>
                                <span>${data || ''}</span>
                            </div>`;
                        }
                    },
                    
                    // Fecha emisión
                    {
                        targets: 5,
                        title: 'Emisión',
                        width: '10%',
                        visible : true,
                        render: function(data) {
                            return formatFechaGlobal(data);
                        }
                    },
                    
                    // Fecha vencimiento
                   
                    
                    // Saldo Bs
                    {
                        targets: 6,
                        title: 'Saldo Bs.',
                        width: '10%',
                        visible : false,
                        render: function(data, type, full) {
                            if (full.moneda !== 'USD' && data > 0) {
                                return formatoEuropeo(data);
                            }
                            return '-';
                        }
                    },
                
                    // Tasa
                    {
                        targets: 7,
                        title: 'Tasa',
                        width: '8%',
                        render: function(data) {
                            return formatoEuropeo(data);
                        }
                    },
                    
                    // IVA / Retención
                    {
                        targets: 8,
                        title: 'IVA',
                        width: '7%',
                          visible : false,
                        render: function(data, type, full) {
                            if (full.contrib == 1 && full.iva > 0) {
                                return `<span class="badge bg-primary">Aplica Ret.</span>`;
                            }
                            return data > 0 ? formatoEuropeo(data) : 'N/A';
                        }
                    },
                    
                 
                  
                    // Acciones
                        // Reemplazar el bloque de acciones completo con este:
                       // Acciones
                        {
                            targets: 9,
                            title: 'Acciones',
                            width: '180px', 
                            orderable: false,
                            render: function(data, type, full, meta) {
                                let accionesHtml = '<div class="d-flex align-items-center justify-content-center col-actions flex-nowrap">';
                                
                                // Obtenemos el tipo de documento (accion)
                                // Asegúrate de que tu JSON traiga el campo 'accion' o cámbialo por el nombre correcto
                                const tipoDoc = parseInt(full.tipo_doc_n || full.tipo_doc_n || 0);                            
                                const factNum = full.fact_num;
                                const factAfectada = full.nro_orig || ''; // Asegúrate de tener este dato en el JSON

                                    if (tipoDoc === 3) { // NOTA DE CRÉDITO
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-warning me-25 btn-nota-credito-tfhka" 
                                                data-id="${factNum}" 
                                                data-factura-afectada="${factAfectada}" 
                                                data-bs-toggle="tooltip" title="Fiscalizar Nota de Crédito">
                                                ${feather.icons['minus-circle'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    }else if (tipoDoc === 4) { // NOTA DE DÉBITO
                                        accionesHtml += `
                                            <button class="btn btn-sm btn-icon btn-relief-warning me-25 btn-nota-debito-tfhka" 
                                                data-id="${factNum}" 
                                                data-factura-afectada="${factAfectada}" 
                                                data-bs-toggle="tooltip" title="Fiscalizar Nota de Débito">
                                                ${feather.icons['plus-circle'].toSvg({ class: 'font-medium-2' })}
                                            </button>`;
                                    }
                                    
                               
                                accionesHtml += '</div>';
                                return accionesHtml;
                            }
                        },
                    
                    // Columnas ocultas (datos auxiliares)
                    {
                        targets: 1,
                        visible: false  // co_cli (ya se muestra en el cliente)
                    }
                ],
                
              
                
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>>' +
                     '<"d-flex justify-content-between align-items-center mx-0 row"' +
                     '<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     't' +
                     '<"d-flex justify-content-between mx-0 row"' +
                     '<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                
                displayLength: 75,
                lengthMenu: [10, 25, 50, 75, 100],
                
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: '<i class="ri-share-line me-50"></i>Exportar',
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="ri-file-excel-line me-50"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ri-file-pdf-line me-50"></i>Pdf',
                                className: 'dropdown-item',
                                orientation: 'landscape',
                                exportOptions: { 
                                    columns: [2, 3, 4, 5, 6, 7, 8, 9] 
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="ri-search-line me-50"></i>Actualizar',
                        className: 'btn btn-relief-info btn-floating-refresh',
                        action: function() {
                            refreshFacturasTable();
                        }
                    }
                     
                ],
                
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                return 'Detalles de Factura';
                            }
                        }),
                        renderer: function(api, rowIdx, columns) {
                            let data = $.map(columns, function(col) {
                                return col.title ? 
                                    '<tr><td><strong>' + col.title + ':</strong></td><td>' + col.data + '</td></tr>' : 
                                    '';
                            }).join('');
                            
                            return data ? $('<table class="table table-sm"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ resultados",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible",
                    "sInfo": "Mostrando _START_-_END_ de _TOTAL_",
                    "sInfoEmpty": "Mostrando 0-0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                }
            });
            
        } catch (error) {
            console.error('Error al cargar la tabla de facturas:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos de facturas'
            });
        }
    }
}

// Función auxiliar para pagar factura
function pagarFactura(factNum) {
    // Aquí puedes implementar la lógica para pagar
    window.location.href = `index.php?view=pago&fact_num=${factNum}`;
}

function refreshFacturasTable() {
    // Mostrar spinner en el botón
    const btn = $('.btn-floating-refresh');
    const originalIcon = btn.html();
    btn.html('<i data-feather="rotate-cw"></i> Actualizando...');
    btn.prop('disabled', true);
    
    // Agregar animación de giro
    if (!$('#spin-animation').length) {
        $('head').append(`
            <style id="spin-animation">
                .spin-icon {
                    animation: spin 1s linear infinite;
                }
                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
            </style>
        `);
    }
    
    // Actualizar datos
    Promise.all([
     
        new Promise((resolve) => {
            cargarDataFacturas('NO', 'NO', 'NO', resolve);
        })
    ]).then(() => {
        // Restaurar botón
        setTimeout(() => {
            btn.html(originalIcon);
            btn.prop('disabled', false);
            
            // Mostrar notificación de éxito
            toastr.success('Datos actualizados correctamente', 'Actualización');
        }, 500);
    }).catch((error) => {
        btn.html(originalIcon);
        btn.prop('disabled', false);
        toastr.error('Error al actualizar datos', 'Error');
    });
}
// Formato de fecha
function formatFechaGlobal(fecha) {
    if (!fecha) return '';
    try {
        const fechaObj = new Date(fecha);
        if (isNaN(fechaObj.getTime())) return fecha;
        
        const dia = String(fechaObj.getDate()).padStart(2, '0');
        const mes = String(fechaObj.getMonth() + 1).padStart(2, '0');
        const año = fechaObj.getFullYear();
        
        return `${dia}/${mes}/${año}`;
    } catch(e) {
        return fecha;
    }
}

// Formato europeo para números
function formatoEuropeo(numero) {
    if (numero === null || numero === undefined || isNaN(numero)) {
        return '0,00';
    }
    
    const num = parseFloat(numero);
    return num.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}


$(window,document,$).ready(function(){
'use strict';






// Delegación de eventos para botones dinámicos - EMITIR NOTA DE DÉBITO
$(document).on('click', '.btn-nota-db-tfhka', function() {
    let nc_num = $(this).attr('data-id'); // ID de la nota de débito
    let factura_afectada = $(this).attr('data-factura-afectada'); // ID de la factura original
    
    // Solo pedimos confirmación de seguridad
    Swal.fire({
        title: '¿Emitir Nota de Débito?',
        text: `Se enviará la nota #${nc_num} (afecta a #${factura_afectada}) a fiscalización.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, emitir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviamos el comentario vacío porque el PHP lo buscará en la BD usando nota_motivo
            emitirNotaDebitoDigital(nc_num, factura_afectada, "");
        }
    });
});

$(document).on('click', '.btn-enviar-factura-email', function(e) {
    e.preventDefault();
    
    const btn = $(this);
    const factNum = btn.data('fact-num');
    const cliente = btn.data('cliente');
    const emailCliente = btn.data('email');
    const tipoDoc = btn.data('tipo');
    
    // Deshabilitar botón durante el proceso
    btn.prop('disabled', true)
       .html('<i data-feather="refresh-cw"></i>');
   
    // Si no hay email del cliente, pedirlo manualmente
    if (!emailCliente || emailCliente === '') {
        Swal.fire({
            title: 'Enviar Documento por Correo',
            html: `
                <div class="text-start">
                    <p class="mb-2"><strong>Documento:</strong> ${factNum}</p>
                    <p class="mb-2"><strong>Cliente:</strong> ${cliente}</p>
                    <label class="form-label mt-3">Correo electrónico del destinatario:</label>
                    <input type="email" id="swal-email-input" class="form-control" 
                           placeholder="ejemplo@correo.com" required>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="ri-send-plane-fill me-1"></i> Enviar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#ff9f43',
            focusConfirm: false,
            preConfirm: () => {
                const email = document.getElementById('swal-email-input').value;
                if (!email || !isValidEmail(email)) {
                    Swal.showValidationMessage('Por favor ingrese un correo válido');
                    return false;
                }
                return { email: email };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                enviarFacturaEmail(factNum, result.value.email, cliente, btn,1);
            } else {
                restaurarBoton(btn);
            }
        });
    } else {
        // Confirmar con el email que ya tenemos
        Swal.fire({
            title: '¿Enviar documento por correo?',
            html: `
                <div class="text-start">
                    <p><strong>Documento:</strong> ${factNum}</p>
                    <p><strong>Cliente:</strong> ${cliente}</p>
                    <p><strong>Correo:</strong> <span class="text-primary">${emailCliente}</span></p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="ri-send-plane-fill me-1"></i> Sí, Enviar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#ff9f43'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarFacturaEmail(factNum, emailCliente, cliente, btn,tipoDoc);
            } else {
                restaurarBoton(btn);
            }
        });
    }
});









if ($('.dataEmpresa').length) {
cargarDataEmpresa();

}




});

// Función para inicializar la actualización periódica del badge
function iniciarActualizacionPeriodicaBadge() {
    const INTERVALO_ACTUALIZACION = 115200; //
  
    function mostrarToast(mensaje, tipo = 'info') {
        const toast = document.createElement('div');
        toast.textContent = mensaje;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${tipo === 'error' ? '#f44336' : '#4CAF50'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 9999;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease-out;
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Agregar animaciones CSS
    if (!document.querySelector('#toastStyles')) {
        const style = document.createElement('style');
        style.id = 'toastStyles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
    
    async function actualizar() {
           Swal.fire({
                icon: 'info',
                title: 'Acualizando Facturas',
                text: 'Actualizacion de lista de facturas .',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        
        try {
            await Promise.all([
                actualizarConteoGlobalFacturasVencidas(),
                cargarDataFacturas('NO','NO','NO')
            ]);
             Swal.fire({
                icon: 'info',
                title: 'Acualizando Facturas',
                text: 'Actualizacion de lista de facturas .',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        } catch (error) {
            console.error('Error:', error);
             Swal.fire({
                icon: 'error',
                title: 'Acualizando Facturas',
                text: 'Falló la actualización de la lista .',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
    }
    
    // Iniciar
    actualizar();
    setInterval(actualizar, INTERVALO_ACTUALIZACION);
}

// Función específica para actualizar el conteo GLOBAL de facturas vencidas
async function actualizarConteoGlobalFacturasVencidas() {
    try {
        const response = await $.ajax({
            url: '../admin/index.php?action=gerenciales&c=GerenciaData&a=15&t=factura',
            method: 'GET',
            dataType: 'json',
            timeout: 10000,
            cache: false
        });
        
        console.log('Respuesta del conteo global de facturas vencidas:', response);
        const totalVencidas = response && response[0] ? parseInt(response[0].total_facturas) || 0 : 0;
        
        cachedTotalFacturasVencidasGlobal = totalVencidas;
        actualizarBadgeFacturas(totalVencidas);
        
        //console.log('Conteo global de facturas vencidas actualizado:', totalVencidas);
        return totalVencidas;
        
    } catch (error) {
        console.error('Error al obtener conteo global de facturas vencidas:', error);
        return cachedTotalFacturasVencidasGlobal || 0;
    }
}
// Función debounce para optimizar eventos
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Función para actualizar el badge de notificaciones
function actualizarBadgeFacturas(totalVencidas) {
    const $badge = $('#alertFacturas');
    
    if (totalVencidas > 0) {
        $badge.text(totalVencidas).show();
        
        if (totalVencidas > 100) {
            $badge.removeClass('bg-warning bg-info bg-success').addClass('bg-danger');
        } else if (totalVencidas > 50) {
            $badge.removeClass('bg-danger bg-info bg-success').addClass('bg-warning');
        } else if (totalVencidas > 20) {
            $badge.removeClass('bg-danger bg-warning bg-success').addClass('bg-info');
        } else {
            $badge.removeClass('bg-danger bg-warning bg-info').addClass('bg-success');
        }
        
        $badge.attr('title', `${totalVencidas} facturas vencidas en total`);
    } else {
        $badge.text('0').hide();
    }
}



function cargarDataDocumentos(){        
let $tipo_doc = $('#tipo_doc').val();
    if ($('#dataDocumentos').length) {  
    $.ajax({
    type: "GET",
    url: '../admin/index.php?action=facturacion&c=FacturaData&tipo=1&accion=9&datos=1&tipo_doc='+$tipo_doc,
    }).done(function(data) { 
    let cadena = JSON.stringify(data);
    cargarTablaDocumentos(cadena);

    });
    }
}

function notascrdev(){        
    let $tipo_doc = $('#tipo_doc').val();
        if ($('#dataDocumentosNotasCreditoDev').length) {  
        $.ajax({
        type: "GET",
        url: '../admin/index.php?action=facturacion&c=FacturaData&tipo=1&accion=10&datos=1&tipo_doc='+$tipo_doc,
        }).done(function(data) { 
        let cadena = JSON.stringify(data);
        cargarTablaNotascrdev(cadena);
    
        });
        }
}


function cargarDataDocumentosNotas(){        
        let $tipo_doc = $('#tipo_doc').val();
            if ($('#dataDocumentosNotas').length) {  
            $.ajax({
            type: "GET",
            url: '../admin/index.php?action=facturacion&c=FacturaData&tipo=1&accion=11&datos=1&tipo_doc='+$tipo_doc,
            }).done(function(data) { 
            let cadena = JSON.stringify(data);
            cargarTablaDocumentosNotas(cadena);
        
            });
            }
}


function cargarDataEmpresa(){

$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&a=1&c=EmpresaData&t=empresa', 
}).done(function(empresa) {  
var i = 0;
var tope =empresa.length;
var src='';
if(tope>=1){   
  for (var i = 0; i < tope; i++) { 
  $('#name').val(empresa[i].name);
  $('#email').val(empresa[i].email);
  $('#telefonos').val(empresa[i].telefonos);
  $('#rif').val(empresa[i].rif);
  $('#direccion').html(empresa[i].dir);
  src= " ../admin/storage/logo/"+empresa[i].image;
  //console.log(src);
  $('#empresa-img').attr("src",src); 
  
  }  
}else{
}
//alert(tope);
});
}






function emitirNotaDebitoDigital(idNotaDebito, idFacturaAfectada, comentario) {
    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=2&accion=4&datos=1',
        type: 'POST',
        data: {
            tipo: 2,
            accion: 4, 
            datos: 1,
            fact_num: idNotaDebito,
            factura_afectada: idFacturaAfectada,
            comentario: comentario, // El PHP usará nota_motivo de la BD si esto va vacío
            tipo_doc: '03'           // 03 = Nota de Débito
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Procesando...',
                html: 'Conectando con TFHKA para emitir <b>Nota de Débito</b>...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            try {
                if (response.status === 'success' && response.data && response.data.codigo === "200") {
                    
                    var resultado = response.data.resultado || {};
                    var urlPDF = resultado.urlConsulta;
                    var numControl = resultado.numeroControl;
                    var numDoc = resultado.numeroDocumento || idNotaDebito;

                    if(urlPDF){
                        window.open(urlPDF, '_blank');
                    }

                    Swal.fire({
                        icon: 'success',
                        title: '¡Nota de Débito Emitida!',
                        html: `
                            <div style="text-align: left; font-size: 14px;">
                                <p><b>Documento:</b> ${numDoc}</p>
                                <p><b>Nro. Control:</b> ${numControl}</p>
                                <p><b>Factura Afectada:</b> ${idFacturaAfectada}</p>
                                <hr>
                                <p>El PDF se ha generado correctamente.</p>
                            </div>
                        `,
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: '<i class="ri-file-pdf-line"></i> Abrir PDF',
                        cancelButtonText: 'Cerrar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(urlPDF, '_blank');
                        }
                        // Recargar tabla si la función existe
                        if (typeof refreshFacturasTable === 'function') {
                            refreshFacturasTable();
                        }
                    });

                } else {
                    var mensajeError = (response.data && response.data.mensaje) || response.message || 'Error al emitir Nota de Débito';
                    var validaciones = (response.data && response.data.validaciones) || [];
                    
                    var listaErrores = validaciones.length > 0 
                        ? validaciones.map(e => `<li style="margin-bottom: 5px;">${e}</li>`) 
                        : [`<li>${mensajeError}</li>`];
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Nota de Débito',
                        html: `<ul style="text-align:left; color:#d33; margin:0; padding-left:20px;">${listaErrores.join('')}</ul>`
                    });
                }
            } catch (e) {
                Swal.fire('Error', 'Error inesperado procesando la respuesta', 'error');
                console.error(e);
            }
        },
        error: function(xhr) {
            let errorMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'No se pudo contactar al servidor.';
            Swal.fire('Error de conexión', errorMsg, 'error');
        }
    });
}



// ==========================================
// FUNCIÓN: Validar Email
// ==========================================
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// ==========================================
// FUNCIÓN: Restaurar Botón
// ==========================================
function restaurarBoton(btn) {
    btn.prop('disabled', false)
       .html(feather.icons['mail'].toSvg({ class: 'font-medium-2' }));
}

