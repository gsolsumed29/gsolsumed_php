function cargarTablaFacturas(data) {
    let dataTableFacturas = $('.dataTableFacturas');
    
    if (dataTableFacturas.length) {
        // Destruir tabla existente si la hay
        if ($.fn.DataTable.isDataTable(dataTableFacturas)) {
            dataTableFacturas.DataTable().destroy();       }

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

function cargarDataFiscales($s){
    if ($('#dataFacturas').length) {  
    $.ajax({
    type: "GET",
    url: '../admin/index.php?action=facturacion&c=FacturaData&t=0&tipo=1&accion=6&datos=1&s='+$s,
    }).done(function(data) { 
    let cadena = JSON.stringify(data);
    cargarTablaFacturas(cadena);

    });
    }
}

$(window,document,$).ready(function(){
'use strict';


        const hoy = new Date();
        const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
        $('#fechaActual').text(hoy.toLocaleDateString('es-ES', opciones));
        
        // Pequeñas interacciones jQuery: alertas simuladas para acciones rápidas
        $('#btnNuevaFactura').on('click', function() {
            alert('📄 Abrir formulario para nueva factura (simulación). Podrías agregar un modal aquí.');
        });
        
        // Ejemplo: para cada botón "ver" de facturas se puede agregar interacción
        $('#tablaFacturas').on('click', '.btn-outline-orange', function() {
            const facturaTexto = $(this).closest('tr').find('td:first').text();
            alert(`Visualizando detalles de la factura ${facturaTexto}. Módulo en construcción.`);
        });
        
        // Al hacer clic en cualquier botón "Nueva Nota" o acciones de otras pestañas (simulación)
        $('.action-bar .btn-primary').on('click', function() {
            if($(this).text().includes('Nueva Nota')) {
                alert('📦 Crear nueva nota de entrega - funcionalidad integrable');
            }
        });
        
        $('.action-bar .btn-outline-success').on('click', function() {
            alert('🧾 Generar nueva Nota de Crédito Administrativa');
        });
        
        // Interacción adicional: resaltar al cambiar de pestaña usando eventos de Bootstrap (opcional)
        $('#mainTabs button').on('shown.bs.tab', function (e) {
            const targetId = $(e.target).attr('data-bs-target');
            console.log(`Pestaña activada: ${targetId}`);
            // Pequeño feedback visual (sin exagerar)
            $(targetId).find('.action-bar').addClass('border-start border-warning border-3').delay(300).queue(function(next){
                $(this).removeClass('border-start border-warning border-3');
                next();
            });
        });
        
        // También podríamos añadir simulación de reportes
        $('.btn-outline-info').on('click', function() {
            alert('📊 Generando reporte de facturación (demo)');
        });
        
        // Pequeño helper: mostrar el total de registros por pestaña (solo para demostrar dinamismo)
        function actualizarContadores() {
            // No es obligatorio, pero da sensación de dinamismo jQuery
            const facturasCount = $('#tablaFacturas tr').length;
            const notasCount = $('#notas tbody tr').length;
            const devolucionesCount = $('#devoluciones tbody tr').length;
            const ncrCount = $('#ncr tbody tr').length;
            const ndbCount = $('#ndb tbody tr').length;
            const anulacionesCount = $('#anulaciones tbody tr').length;
            
            // Agregar badges sutiles en los tabs (opcional, sin romper diseño)
            // Se puede usar para indicar cantidad de registros dinámicamente (esto es un extra)
            if($('#facturas-tab .badge-cant').length === 0) {
                $('#facturas-tab').append(` <span class="badge bg-secondary rounded-pill ms-1 badge-cant">${facturasCount}</span>`);
                $('#notas-tab').append(` <span class="badge bg-secondary rounded-pill ms-1 badge-cant">${notasCount}</span>`);
                $('#devoluciones-tab').append(` <span class="badge bg-secondary rounded-pill ms-1 badge-cant">${devolucionesCount}</span>`);
                $('#ncr-tab').append(` <span class="badge bg-secondary rounded-pill ms-1 badge-cant">${ncrCount}</span>`);
                $('#ndb-tab').append(` <span class="badge bg-secondary rounded-pill ms-1 badge-cant">${ndbCount}</span>`);
                $('#anulaciones-tab').append(` <span class="badge bg-secondary rounded-pill ms-1 badge-cant">${anulacionesCount}</span>`);
            } else {
                $('.badge-cant').eq(0).text(facturasCount);
                $('.badge-cant').eq(1).text(notasCount);
                $('.badge-cant').eq(2).text(devolucionesCount);
                $('.badge-cant').eq(3).text(ncrCount);
                $('.badge-cant').eq(4).text(ndbCount);
                $('.badge-cant').eq(5).text(anulacionesCount);
            }
        }
        actualizarContadores();


if ($('#badgeFacturasLink').length) {
    let $s = 2;    
    cargarDataFiscales($s);
    } else {
    console.log("...");
}

// Delegación de eventos para botones dinámicos en la tabla
$(document).on('click', '.btn-emitir-tfhka', function() {
        let fac_nunm = $(this).attr('data-id'); // Obtenemos el ID del pedido

        Swal.fire({
            title: '¿Emitir Documento?',
            text: "Se emitirá un documento  #" + fac_nunm + ".",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, emitir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Llamamos a la función que procesa el AJAX
                emitirFacturaDigital(fac_nunm);
            }
        });
});
// Delegación de eventos para botones dinámicos en la tabla - ANULAR
$(document).on('click', '.btn-anular-tfhka', function() {
    let fac_nunm = $(this).attr('data-id'); // Obtenemos el ID del pedido
    
    Swal.fire({
        title: 'Anular Factura Digital',
        html: `
            <div style="text-align: left; width: 100%;">
                <p style="margin-bottom: 15px;">Se anulará el documento <strong>#${fac_nunm}</strong> en TFHKA.</p>
                <p style="margin-bottom: 20px; color: #d33;">⚠️ Esta acción no se puede deshacer.</p>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; text-align: left;">
                        Motivo de Anulación <span style="color: red;">*</span>
                    </label>
                    <select id="motivo-anulacion" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                        <option value="">-- Seleccione un motivo --</option>
                        <option value="01">Error en datos del cliente</option>
                        <option value="02">Error en productos/servicios</option>
                        <option value="03">Error en montos o precios</option>
                        <option value="04">Error en tasa de cambio</option>
                        <option value="05">Documento duplicado</option>
                        <option value="06">Cancelación de operación</option>
                        <option value="07">Devolución de mercancía</option>
                        <option value="08">Error en identificación fiscal</option>
                        <option value="99">Otros (especifique)</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; text-align: left;">
                        Detalle del Motivo <span style="color: red;">*</span>
                    </label>
                    <textarea id="motivo-detalle" rows="3" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical;" placeholder="Describa detalladamente el motivo de la anulación..."></textarea>
                    <small style="color: #6c757d; font-size: 11px;">Mínimo 10 caracteres</small>
                </div>
                
                <p style="font-size: 12px; color: #dc3545; margin-top: 10px; text-align: left;">
                    <i class="fa fa-exclamation-triangle"></i> <strong>Importante:</strong> El motivo es obligatorio para proceder con la anulación.
                </p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, anular',
        cancelButtonText: 'Cancelar',
        width: '500px',
        focusConfirm: false,
        allowOutsideClick: false, // Evita cerrar haciendo clic fuera
        allowEscapeKey: false,     // Evita cerrar con ESC
        preConfirm: () => {
            // Obtener elementos del DOM
            const motivoSelect = document.getElementById('motivo-anulacion');
            const motivoDetalle = document.getElementById('motivo-detalle');
            
            // Validar que existan los elementos
            if (!motivoSelect || !motivoDetalle) {
                Swal.showValidationMessage('Error al cargar el formulario');
                return false;
            }
            
            const motivoCodigo = motivoSelect.value;
            const motivoTexto = motivoDetalle.value.trim();
            
            // Validar que se haya seleccionado un motivo
            if (!motivoCodigo) {
                // Marcar el campo como error visual
                motivoSelect.style.borderColor = '#dc3545';
                motivoSelect.style.backgroundColor = '#fff8f8';
                Swal.showValidationMessage('⚠️ Debe seleccionar un motivo de anulación');
                return false;
            } else {
                motivoSelect.style.borderColor = '#d1d5db';
                motivoSelect.style.backgroundColor = '';
            }
            
            // Validar que el detalle no esté vacío
            if (!motivoTexto) {
                motivoDetalle.style.borderColor = '#dc3545';
                motivoDetalle.style.backgroundColor = '#fff8f8';
                Swal.showValidationMessage('⚠️ Debe escribir el detalle del motivo de anulación');
                return false;
            }
            
            // Validar longitud mínima del detalle (10 caracteres)
            if (motivoTexto.length < 10) {
                motivoDetalle.style.borderColor = '#dc3545';
                motivoDetalle.style.backgroundColor = '#fff8f8';
                Swal.showValidationMessage('⚠️ El detalle debe tener al menos 10 caracteres');
                return false;
            }
            
            // Validación específica para "Otros"
            if (motivoCodigo === '99' && motivoTexto.length < 15) {
                motivoDetalle.style.borderColor = '#dc3545';
                motivoDetalle.style.backgroundColor = '#fff8f8';
                Swal.showValidationMessage('⚠️ Para el motivo "Otros", debe especificar detalladamente (mínimo 15 caracteres)');
                return false;
            }
            
            // Restaurar estilos si todo está correcto
            motivoDetalle.style.borderColor = '#d1d5db';
            motivoDetalle.style.backgroundColor = '';
            
            // Obtener el texto del motivo seleccionado
            const motivoTextoSelect = motivoSelect.options[motivoSelect.selectedIndex].text;
            
            return {
                motivoCodigo: motivoCodigo,
                motivoDetalle: motivoTexto,
                motivoTexto: motivoTextoSelect
            };
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            // Llamamos a la función que procesa el AJAX de anulación con el motivo
            anularFacturaDigital(fac_nunm, result.value.motivoCodigo, result.value.motivoDetalle);
        }
    });
});


});
