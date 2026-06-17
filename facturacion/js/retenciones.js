/**
 * ARCHIVO: gestion_fiscalizados_master.js
 * FUNCIÓN: Manejo integral de documentos con estatus 2 (Fiscalizados)
 * ESTADO: Independiente con todas las funciones de soporte integradas.
 */

var tablaMasterFiscalizados = null;
var cronometroFiscal = null;
var segundosFiscal = 0;

$(document).ready(function () {
    const STATUS_FISCALIZADO = 2; 

    if ($('.tabla-maestra-fiscalizados').length > 0) {
        ejecutarCargaFiscal(1, STATUS_FISCALIZADO);
    }

    $(document).on('shown.bs.tab', '.tab-fiscal-link', function (e) {
        const tabSeleccionada = $(e.target).attr('data-tipo-doc');
        if (tabSeleccionada) {
            ejecutarCargaFiscal(tabSeleccionada, STATUS_FISCALIZADO);
        }
    });

    $('#btn-update-fiscal').on('click', function() {
        const tipoActual = $('.tab-fiscal-link.active').data('tipo-doc') || 1;
        ejecutarCargaFiscal(tipoActual, STATUS_FISCALIZADO);
    });
});




// Función para ANULAR factura digital con motivo
function anularFacturaDigital(idPedido, motivoCodigo, motivoDetalle,tipo_documento) {
    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=3&accion=1&datos=1&c=FacturaData&t=factura',
        type: 'POST',
        data: {
            tipo: 3, // ANULACIÓN FACTURA TFHKA
            accion: 3,    // accion = 1 para anulación
            datos: 1,
            c: 'FacturaData',
            t: 'factura',
            tipo_documento: tipo_documento, // 1=Factura, 3=Nota Crédito Devolución
            fact_num: idPedido,
            tipo_doc: '01',      // 01 = Factura
            motivo_codigo: motivoCodigo,
            motivo: motivoDetalle
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Anulando...',
                html: 'Conectando con TFHKA para anular el documento...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            try {
                // Verificamos si el status general es success Y el codigo interno es 200
                if (response.status === 'success' && response.data.codigo === "200") {
                    
                    // Extraemos los datos importantes de la respuesta
                    var resultado = response.data.resultado || {};
                    var numDoc = resultado.numeroDocumento || idPedido;
                    var numControl = resultado.numeroControl || 'N/A';
                    var fechaAnulacion = resultado.fechaAsignacion || new Date().toLocaleDateString();
                    
                    // Mostramos el mensaje de éxito con los datos de anulación
                    Swal.fire({
                        icon: 'success',
                        title: '¡Documento Anulado!',
                        html: `
                            <div style="text-align: left; font-size: 14px;">
                                <p><b>Documento:</b> ${numDoc}</p>
                                <p><b>Nro. Control:</b> ${numControl}</p>
                                <p><b>Fecha Anulación:</b> ${fechaAnulacion}</p>
                                <hr>
                                <p style="color: green;">La factura ha sido anulada correctamente en el sistema de TFHKA.</p>
                                <p><b>Motivo:</b> ${motivoCodigo} - ${motivoDetalle || 'No especificado'}</p>
                                <p><small>Según la documentación técnica, la anulación es irreversible.</small></p>
                            </div>
                        `,
                        showCloseButton: true,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        // Opcional: Recargar la tabla de pedidos para ver cambios
                        if (typeof cargarDataPedidos === 'function') {
                            cargarDataPedidos();
                        }
                    });

                } else {
                    // Si la API respondió pero con error
                    var mensajeError = response.data.mensaje || response.message || 'Error al anular el documento';
                    var validaciones = response.data.validaciones || [];
                    
                    var listaErrores = [];
                    if (validaciones.length > 0) {
                        listaErrores = validaciones.map(e => `<li>${e}</li>`);
                    } else {
                        listaErrores = [`<li>${mensajeError}</li>`];
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Anular',
                        html: `<ul style="text-align:left; color:red;">${listaErrores.join('')}</ul>`
                    });
                }
            } catch (e) {
                Swal.fire('Error', 'Error inesperado procesando la respuesta', 'error');
                console.error(e);
            }
        },
        error: function(xhr, status, error) {
            let errorMsg = 'No se pudo contactar al servidor.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Swal.fire('Error de conexión', errorMsg, 'error');
            console.error('Error en anulación:', error);
        }
    });
}

// Función para ANULAR factura digital con motivo
function anularNotaCreditoDevDigital(idPedido, motivoCodigo, motivoDetalle,tipo_documento) {
    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=3&accion=3&datos=1&c=FacturaData&t=factura',
        type: 'POST',
        data: {
            tipo: 3, // ANULACIÓN FACTURA TFHKA
            accion: 3,    // accion = 1 para anulación
            datos: 1,
            c: 'FacturaData',
            t: 'factura',
            tipo_documento: tipo_documento, // 1=Factura, 3=Nota Crédito Devolución
            fact_num: idPedido,
            tipo_doc: '01',      // 01 = Factura
            motivo_codigo: motivoCodigo,
            motivo: motivoDetalle
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Anulando...',
                html: 'Conectando con TFHKA para anular el documento...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function(response) {
            try {
                // Verificamos si el status general es success Y el codigo interno es 200
                if (response.status === 'success' && response.data.codigo === "200") {
                    
                    // Extraemos los datos importantes de la respuesta
                    var resultado = response.data.resultado || {};
                    var numDoc = resultado.numeroDocumento || idPedido;
                    var numControl = resultado.numeroControl || 'N/A';
                    var fechaAnulacion = resultado.fechaAsignacion || new Date().toLocaleDateString();
                    
                    // Mostramos el mensaje de éxito con los datos de anulación
                    Swal.fire({
                        icon: 'success',
                        title: '¡Documento Anulado!',
                        html: `
                            <div style="text-align: left; font-size: 14px;">
                                <p><b>Documento:</b> ${numDoc}</p>
                                <p><b>Nro. Control:</b> ${numControl}</p>
                                <p><b>Fecha Anulación:</b> ${fechaAnulacion}</p>
                                <hr>
                                <p style="color: green;">La factura ha sido anulada correctamente en el sistema de TFHKA.</p>
                                <p><b>Motivo:</b> ${motivoCodigo} - ${motivoDetalle || 'No especificado'}</p>
                                <p><small>Según la documentación técnica, la anulación es irreversible.</small></p>
                            </div>
                        `,
                        showCloseButton: true,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        // Opcional: Recargar la tabla de pedidos para ver cambios
                        if (typeof cargarDataPedidos === 'function') {
                            cargarDataPedidos();
                        }
                    });

                } else {
                    // Si la API respondió pero con error
                    var mensajeError = response.data.mensaje || response.message || 'Error al anular el documento';
                    var validaciones = response.data.validaciones || [];
                    
                    var listaErrores = [];
                    if (validaciones.length > 0) {
                        listaErrores = validaciones.map(e => `<li>${e}</li>`);
                    } else {
                        listaErrores = [`<li>${mensajeError}</li>`];
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Anular',
                        html: `<ul style="text-align:left; color:red;">${listaErrores.join('')}</ul>`
                    });
                }
            } catch (e) {
                Swal.fire('Error', 'Error inesperado procesando la respuesta', 'error');
                console.error(e);
            }
        },
        error: function(xhr, status, error) {
            let errorMsg = 'No se pudo contactar al servidor.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Swal.fire('Error de conexión', errorMsg, 'error');
            console.error('Error en anulación:', error);
        }
    });
}



/**
 * 1. MOTOR DE CARGA AJAX
 */
function ejecutarCargaFiscal(tipoDocumento, status) {
    const btn = $('#btn-update-fiscal');
    const icono = btn.find('i');

    Swal.fire({
        title: 'Sincronizando Historial',
        text: 'Consultando documentos fiscales...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    btn.prop('disabled', true);
    icono.addClass('fa-spin');

    $.ajax({
        type: "GET",
        url: `../admin/index.php?action=facturacion&c=FacturaData&tipo=4&accion=${tipoDocumento}&datos=1&t=factura&s=${status}`,
        dataType: 'json'
    }).done(function(data) {
        Swal.close();
        renderizarTablaUnicaFiscal(data, tipoDocumento);
        iniciarTimerFiscal();
    }).always(function() {
        btn.prop('disabled', false);
        icono.removeClass('fa-spin');
    }).fail(function() {
        Swal.fire('Error', 'No se pudo obtener el historial fiscal', 'error');
    });
}

/**
 * 2. RENDERIZADO DE DATATABLE
 */
function renderizarTablaUnicaFiscal(datos, tipoTab) {
    let el = $('.tabla-maestra-fiscalizados');
    
    if ($.fn.DataTable.isDataTable(el)) {
        el.DataTable().destroy();
        el.empty();
    }

    tablaMasterFiscalizados = el.DataTable({
        data: datos,
        columns: [
            { data: 'fact_num', title: 'Nro. Doc' },
            { data: 'cli_des', title: 'Cliente' },
            { data: 'fec_emis', title: 'Emisión' }, // Índice 2
            { data: 'num_control', title: 'Nro. Control' },
            { data: 'saldo_usd', title: 'Monto USD' },
            { data: null, title: 'Acciones Fiscales' }
        ],
        columnDefs: [
            {
                targets: 0,
                type: 'num',
                render: function(data, type, full) {
                    if (type === 'sort' || type === 'type') return parseFloat(data);

                    let display = data;
                    if (data.toString().startsWith('5') && data.toString().length === 8) {
                        display = 'NF' + data.toString().substring(2);
                    }
                    return `<strong><a href="#">${display}</a></strong>`;
                }
            },
            {
                targets: 2, // Columna de Fecha (Emisión)
                render: function(data, type, row) {
                    if (!data) return type === 'sort' ? 0 : '';

                    // Si DataTables está ordenando, transformamos la fecha a YYYYMMDD
                    if (type === 'sort' || type === 'type') {
                        // Maneja formato DD/MM/YYYY o YYYY-MM-DD
                        let d = data.includes('/') ? data.split('/') : data.split('-');
                        if (d.length === 3) {
                            // Si es DD/MM/YYYY -> d[2]d[1]d[0] | Si es YYYY-MM-DD -> d[0]d[1]d[2]
                            return d[0].length === 4 ? d[0] + d[1] + d[2] : d[2] + d[1] + d[0];
                        }
                        return data;
                    }
                    // Para mostrar en pantalla, mantenemos el formato original
                    return data;
                }
            },
            {
                targets: 4,
                className: 'text-end',
                render: (data) => `<strong>$ ${formatoMonedaFiscal(data)}</strong>`
            },
            {
                targets: 5,
                className: 'text-center',
                orderable: false,
                render: (data, type, full) => generarBotonesAccionFiscales(full, tipoTab)
            }
        ],
        drawCallback: () => { 
            if (typeof feather !== 'undefined') feather.replace(); 
        },
        // ORDEN: Columna índice 2 (Emisión), 'desc' (Más reciente primero)
        order: [[2, 'desc']], 
        responsive: true,
        displayLength: 25,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json' }
    });
}

function generarBotonesAccionFiscales(full, tipoTab) {
    let html = '<div class="d-flex flex-column align-items-center gap-1">';
    
    // Si el documento está anulado, agregamos la leyenda/badge primero
    if (full.anulada == 1) {
        html += '<span class="badge badge-light-danger text-uppercase mb-1" style="font-size: 0.7rem;"> Documento Anulado </span>';
    }

    html += '<div class="d-flex justify-content-center gap-1">';
    
    // Variable para manejar el estado de los botones de anulación
    // Si anulada es 1, devolverá el atributo 'disabled', de lo contrario vacío.
    let disabledAttr = (full.anulada == 1) ? '' : 'disabled';

    /**
     * 1. BOTÓN DE VER (Este se mantiene siempre activo si existe URL)
     */
    if ([1, 3, 4, 5].includes(parseInt(tipoTab)) && full.url_fiscal) {
        html += `<button class="btn btn-sm btn-icon btn-relief-success btn-ver-documento-tfhka" 
                    data-url="${full.url_fiscal}" 
                    title="Ver Documento Fiscal">
                    <i data-feather="eye"></i>
                </button>`;
    }

    /**
     * 2. ACCIONES SEGÚN EL TIPO DE TAB
     */
    if (tipoTab == 1) {
        // Botón ANULAR FACTURA (Se bloquea si ya está anulada)
        html += `<button class="btn btn-sm btn-icon btn-relief-danger btn-factura-anular-tfhka" 
                    data-id="${full.fact_num}" 
                    title="Anular fiscalmente"
                    ${disabledAttr}>
                    <i data-feather="shield-off"></i>
                </button>`;
    } 
    else if (tipoTab == 2) {
        // Notas de Entrega (No tienen botón de anular en este bloque, así que no se ven afectadas)
        html += `<button class="btn btn-sm btn-icon btn-relief-primary btn-enviar-factura-email-nota" 
                    data-fact-num="${full.fact_num}"
                    data-cliente="${full.cli_des}"
                    data-email="${full.email || ''}"
                    data-tipo="${tipoTab}"
                    title="Enviar por Correo">
                    <i data-feather="send"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-relief-warning btn-descargar-factura-nota" 
                    data-id="${full.fact_num}"
                    title="Descargar PDF Nota de Entrega">
                    <i data-feather="download"></i>
                </button>`;
    }
    else if (tipoTab == 3) {
        html += `<button class="btn btn-sm btn-icon btn-relief-danger btn-anular-nota-credito-dev-tfhka" 
                    data-id="${full.fact_num}" 
                    data-factura-afectada="${full.fact_afectada}" 
                    data-tipo="${tipoTab}"
                    title="Anular Fiscalmente N/CR Devolución"
                    ${disabledAttr}>
                    <i data-feather="shield-off"></i>
                </button>`;
    } 
    else if (tipoTab == 4) {
        html += `<button class="btn btn-sm btn-icon btn-relief-danger btn-anular-nota-credito-tfhka" 
                    data-id="${full.fact_num}" 
                    data-factura-afectada="${full.fact_afectada}" 
                    data-tipo="${tipoTab}"
                    title="Anular Fiscalmente N/CR Administrativa"
                    ${disabledAttr}>
                    <i data-feather="shield-off"></i>
                </button>`;
    } 
    else if (tipoTab == 5) {
        html += `<button class="btn btn-sm btn-icon btn-relief-danger btn-anular-nota-debito-tfhka" 
                    data-id="${full.fact_num}" 
                    data-factura-afectada="${full.fact_afectada}" 
                    data-tipo="${tipoTab}"
                    title="Anular Fiscalmente N/DB"
                    ${disabledAttr}>
                    <i data-feather="shield-off"></i>
                </button>`;
    }

    html += '</div></div>'; 
    return html;
}


// Delegación de eventos para el botón de DESCARGA (Sin confirmación)
$(document).on('click', '.btn-descargar-factura-nota', function(e) {
    // Prevenimos cualquier comportamiento por defecto del navegador
    e.preventDefault();

    // Obtenemos el número de factura/documento del atributo data-id
    let fact_num = $(this).attr('data-id');

    if (fact_num) {
        // Construimos la URL del endpoint tipo=10
        const urlReporte = `../admin/index.php?action=reporte&tipo=10&fact_num=${fact_num}`;
        
        // Abrimos en una nueva pestaña directamente
        window.open(urlReporte, '_blank');
    } else {
        console.error("No se encontró el número de documento (data-id) para la descarga.");
    }
});

// Delegación de eventos para botones dinámicos en la tabla - ANULAR
$(document).on('click', '.btn-factura-anular-tfhka', function() {
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
            anularFacturaDigital(fac_nunm, result.value.motivoCodigo, result.value.motivoDetalle,'01');
        }
    });
});

// Delegación de eventos para botones dinámicos en la tabla - ANULAR
$(document).on('click', '.btn-anular-nota-credito-dev-tfhka', function() {
    let fac_nunm = $(this).attr('data-id'); // Obtenemos el ID del pedido
    
    Swal.fire({
        title: 'Anular Nota de crédito por Devolución Digital',
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
            anularNotaCreditoDevDigital(fac_nunm, result.value.motivoCodigo, result.value.motivoDetalle,'02');
        }
    });
});

// Delegación de eventos para botones dinámicos en la tabla - ANULAR
$(document).on('click', '.btn-anular-nota-credito-tfhka', function() {
    let fac_nunm = $(this).attr('data-id'); // Obtenemos el ID del pedido
    
    Swal.fire({
        title: 'Anular Nota de crédito  administrativa Digital',
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
            anularNotaCreditoDevDigital(fac_nunm, result.value.motivoCodigo, result.value.motivoDetalle,'02');
        }
    });
});
// Delegación de eventos para botones dinámicos en la tabla - ANULAR
$(document).on('click', '.btn-anular-nota-debito-tfhka', function() {
    let fac_nunm = $(this).attr('data-id'); // Obtenemos el ID del pedido
    
    Swal.fire({
        title: 'Anular Nota de débito administrativa Digital',
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
            anularNotaCreditoDevDigital(fac_nunm, result.value.motivoCodigo, result.value.motivoDetalle,'03');
        }
    });
});

/**
 * Manejador para visualizar el documento fiscal de TFHKA
 */
$(document).on('click', '.btn-ver-documento-tfhka', function(e) {
    e.preventDefault();
    
    // Obtenemos la URL desde el atributo data
    const urlFiscal = $(this).attr('data-url');

    if (urlFiscal && urlFiscal !== "null" && urlFiscal !== "") {
        // Abrimos en una pestaña nueva
        const nuevaVentana = window.open(urlFiscal, '_blank');
        
        // Verificación de seguridad por si el navegador bloquea la apertura
        if (!nuevaVentana || nuevaVentana.closed || typeof nuevaVentana.closed == 'undefined') { 
            Swal.fire({
                icon: 'warning',
                title: 'Navegador bloqueado',
                text: 'Por favor, permite los pop-ups para visualizar el documento fiscal.',
                confirmButtonColor: '#28c76f'
            });
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se encontró una URL válida para este documento.',
            confirmButtonColor: '#ea5455'
        });
    }
});

/**
 * 3. LÓGICA DE EMAIL COMPLETA
 */
function prepararEmailFiscal(elemento) {
    const btn = $(elemento);
    const d = btn.data();
    
    if (!d.email || d.email === '') {
        Swal.fire('Atención', 'El cliente no tiene un correo configurado.', 'warning');
        return;
    }

    // Cambiamos estado del botón
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
    
    enviarEmailFiscalizado(d.id, d.email, d.cliente, btn, d.tipo);
}

function enviarEmailFiscalizado(factNum, email, cliente, btn, tipoDoc) {
    Swal.fire({
        title: 'Reenviando Documento',
        html: `Generando copia fiscal y enviando a <b>${email}</b>`,
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    $.ajax({
        url: '../admin/index.php?action=enviarDocumentos',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'enviar_factura_email',
            fact_num: factNum,
            email_destino: email,
            cliente: cliente,
            tipoDoc: tipoDoc,
            tipoFuncion: 'reenvio_fiscalizado'
        },
        success: function(res) {
            Swal.close();
            if (res.success === true || res.success === "true") {
                Swal.fire('¡Éxito!', 'El documento ha sido reenviado al cliente.', 'success');
            } else {
                Swal.fire('Error', res.message || 'Error al enviar', 'error');
            }
        },
        error: function() {
            Swal.fire('Error Crítico', 'No se pudo comunicar con el servidor de correo.', 'error');
        },
        complete: function() {
            // Restaurar botón con el icono mail de feather
            btn.prop('disabled', false).html(feather.icons['mail'].toSvg({ class: 'font-medium-2' }));
        }
    });
}

/**
 * 4. ANULACIÓN Y DESCARGA
 */
function procesoAnulacionMaster(id, control, tipo) {
    Swal.fire({
        title: '¿Confirmar Anulación?',
        text: `Se enviará la orden de anulación para el documento ${id} (Control: ${control}).`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Sí, anular fiscalmente',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ea5455'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Procesando', 'Comunicando con el API Fiscal...', 'info');
            // Aquí conectarás tu AJAX de anulación
        }
    });
}

function descargarCopiaFiscal(id) {
    window.open(`../admin/index.php?action=generarPDF&id=${id}&fiscal=true`, '_blank');
}

/**
 * 5. UTILIDADES Y TIMER
 */
function formatoMonedaFiscal(valor) {
    return new Intl.NumberFormat('de-DE', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
    }).format(valor);
}

function iniciarTimerFiscal() {
    if (cronometroFiscal) clearInterval(cronometroFiscal);
    segundosFiscal = 0;
    const display = $('#timer-fiscal-info');
    display.text('0s').removeClass('text-danger fw-bold');

    cronometroFiscal = setInterval(() => {
        segundosFiscal++;
        let visual = segundosFiscal < 60 ? segundosFiscal + "s" : Math.floor(segundosFiscal / 60) + "m " + (segundosFiscal % 60) + "s";
        display.text(visual);
        if (segundosFiscal >= 300) display.addClass('text-danger fw-bold');
    }, 1000);
}