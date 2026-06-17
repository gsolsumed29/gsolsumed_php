/**
 * Gestión de Facturación y Documentos - Sistema Master
 * Incluye: Tabs dinámicos, DataTables, Control de Anulaciones y Timer de Sincronización.
 */

var dt_documentos = null;
var segundosTranscurridos = 0;
var intervaloTimer = null;

$(document).ready(function () {
    
    // 1. Filtro inicial (1 = Pendientes, según tu lógica PHP)
    const filtro_s = 1; 
  // 2. Carga inicial automática (Tab Facturas - Tipo 1)
    if($('#documentos').length > 0){
        console.log("Cargando datos para Tab Facturas con filtro_s =", filtro_s);
        iniciarFlujoCarga(1, filtro_s);
    }
    

    // 3. Evento: Botón de Actualizar Manual
    $('#btn-refresh-data').on('click', function() {

        const activeTabTarget = $('#mainTabs button.active').attr('data-bs-target');
        const mapaTipos = {
            '#facturas': 1,
            '#notas': 2,
            '#devoluciones': 3,
            '#ncr': 4,
            '#ndb': 5
        };
        let filtro_s = 1; // Valor por defecto para el filtro (Pendientes)
        let tipoId = mapaTipos[activeTabTarget];
        iniciarFlujoCarga(tipoId, filtro_s);
    });

    // 4. Evento: Cambio de Pestañas (Tabs)
   // 4. Evento: Cambio de Pestañas (Tabs)
        $(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"]', function (e) {
            const target = $(e.target).attr('data-bs-target');
            const mapaTipos = { 
                '#facturas': 1, 
                '#notas': 2, 
                '#devoluciones': 3, 
                '#ncr': 4, 
                '#ndb': 5 
            };
            
            let tipoId = mapaTipos[target];
            
            if (tipoId) {
                // Usamos filtro_s para todas. 
                // Si filtro_s no tiene valor, enviamos "1" por defecto (Pendientes)
                let estadoABuscar = (filtro_s && filtro_s !== "") ? filtro_s : "1";
                
                iniciarFlujoCarga(tipoId, estadoABuscar);
            }
        });
});

/**
 * Orquestador: Dispara la petición y reinicia el reloj
 */
function iniciarFlujoCarga(tipoId, conciliacion) {
    fetchDataPorTipo(tipoId, conciliacion);
    resetearTimer();
}

/**
 * Control del Cronómetro de Sincronización
 */
function resetearTimer() {
    if (intervaloTimer) clearInterval(intervaloTimer);
    
    segundosTranscurridos = 0;
    const timerDisplay = $('#timer-count');
    timerDisplay.text('0s').removeClass('text-danger fw-bold');

    intervaloTimer = setInterval(function() {
        segundosTranscurridos++;
        
        let visual = "";
        if (segundosTranscurridos < 60) {
            visual = segundosTranscurridos + "s";
        } else {
            let min = Math.floor(segundosTranscurridos / 60);
            let seg = segundosTranscurridos % 60;
            visual = min + "m " + seg + "s";
        }

        // Alerta visual a los 5 minutos (300 segundos)
        if (segundosTranscurridos >= 300) {
            timerDisplay.addClass('text-danger fw-bold');
        }

        timerDisplay.text(visual);
    }, 1000);
}

/**
 * Petición AJAX al Backend
 */
function fetchDataPorTipo(tipoId, conciliacion ) {
    const btnRef = $('#btn-refresh-data');
    const iconRef = btnRef.find('i');
    Swal.fire({
        title: 'Sincronizando...',
        text: 'Obteniendo datos actualizados',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
// Iniciar rotación y deshabilitar botón
    iconRef.addClass('fa-spin'); // Si usas FontAwesome, o define una clase CSS de rotación
    btnRef.prop('disabled', true);
    $.ajax({
        type: "GET",
        // Ajustado a tu estructura de URL: accion = ID del Tab
        url: `../admin/index.php?action=facturacion&c=FacturaData&tipo=4&accion=${tipoId}&datos=1&t=factura&s=${conciliacion}`,
        dataType: 'json'
    }).done(function(response) {
        Swal.close();
        cargarTablaGenerica(response, tipoId);
    }).always(function() {
        // Detener rotación y rehabilitar botón al finalizar (éxito o error)
        iconRef.removeClass('fa-spin');
        btnRef.prop('disabled', false);
    }).fail(function() {
        Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
    });
}

/**
 * Renderizado de DataTable
 */
function cargarTablaGenerica(data, tipoTab) {
    let tabla = $('.dataTableFacturas');
    if (!tabla.length) return;

    if ($.fn.DataTable.isDataTable(tabla)) {
        tabla.DataTable().destroy();
        tabla.empty(); 
    }

    dt_documentos = tabla.DataTable({
        data: data,
        columns: [
            { data: null, defaultContent: '', className: 'control', orderable: false },
            { data: 'fact_num' },  
            { data: 'cli_des' },   
            { data: 'fec_emis' },  
            { data: 'fec_venc' },  
            { data: 'saldo_usd' }, 
            { data: 'fact_num' }   
        ],
        columnDefs: [
            {
                targets: 1, 
                type: 'num', // Prioridad numérica
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
                targets: 5,
                className: 'text-end',
                render: data => `<strong>$ ${formatoMoneda(data)}</strong>`
            },
            {
                targets: 6,
                orderable: false,
                className: 'text-center',
                render: (data, type, full) => generarBotonesAccion(full, tipoTab)
            }
        ],
        responsive: true,
        displayLength: 100,
        lengthMenu: [10, 25, 50, 100],
        order: [[1, 'asc']], // Menor a Mayor
        language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json' },
        drawCallback: function() {
            if (typeof feather !== 'undefined') feather.replace();
        }
    });
}


function generarBotonesAccion(full, tipoTab) {
    // Si el documento ya está anulado, bloqueamos todas las acciones
    if (full.anulada == 1) {
        return '<div class="d-flex justify-content-center"><span class="badge badge-light-secondary text-uppercase">Anulada</span></div>';
    }

    let html = '<div class="d-flex justify-content-center gap-1">';
    
    /**
     * 1. ACCIÓN PRINCIPAL (Fiscalizar o Enviar)
     * Se aplica Fiscalizar a: Facturas (1), Devoluciones (3), NCR (4), NDB (5)
     */
    if (tipoTab == 1 ) {
        // Botón FISCALIZAR (TFHKA) - Primero en el orden
        html += `<button class="btn btn-sm btn-icon btn-flat-warning btn-emitir-tfhka" 
                    data-id="${full.fact_num}" 
                    title="Enviar a Fiscalización">
                    <i data-feather="printer"></i>
                </button>`;
    } 
    else if (tipoTab == 2) {
        // Botón ENVIAR POR CORREO - Primero para Notas de Entrega
        html += `<button class="btn btn-sm btn-icon btn-flat-primary btn-enviar-factura-email-nota" 
                    data-fact-num="${full.fact_num}"
                    data-cliente="${full.cli_des}"
                    data-email="${full.email || ''}"
                    data-tipo="${tipoTab}"
                    data-emailV="${full.email_vendedor || ''}"
                    title="Enviar por Correo">
                    <i data-feather="send"></i>
                </button>`;
    }
       else if (tipoTab == 3 ) {
        // Botón FISCALIZAR NOTA CREDITO DEVOLUCION - Primero para Notas de Entrega
        html += `<button class="btn btn-sm btn-icon btn-flat-primary btn-nota-credito-dev-tfhka" 
                    data-id="${full.fact_num}" 
                     data-idnc="${full.fact_num_nc}"
                    data-factura-afectada="${full.fact_afectada}" 
                    data-tipo="${tipoTab}"
                     title="Enviar a Fiscalización">
                    <i data-feather="printer"></i> 
                </button>`;
    }
    else if (tipoTab == 4 ) {
        // Botón FISCALIZAR NOTA CREDITO ADMINISTRATIVA- 
        html += `<button class="btn btn-sm btn-icon btn-flat-primary btn-nota-credito-admin-tfhka" 
                    data-id="${full.fact_num}" 
                    data-factura-afectada="${full.fact_afectada}" 
                    data-tipo="${tipoTab}"
                     title="Enviar a Fiscalización N/CR TFHKA">
                    <i data-feather="printer"></i>
                </button>`;
    } 
    else if (tipoTab == 5 ) {
        // Botón FISCALIZAR NOTA DEBITO ADMINISTRATIVA - 
        html += `<button class="btn btn-sm btn-icon btn-flat-primary btn-nota-debito-admin-tfhka" 
                    data-id="${full.fact_num}" 
                    data-factura-afectada="${full.fact_afectada}" 
                    data-tipo="${tipoTab}"
                     title="Enviar a Fiscalización N/DB TFHKA">
                    <i data-feather="printer"></i>
                </button>`;
    }

  

    return html;
}
/**
 * Funciones de Utilidad
 */
function formatoMoneda(valor) {
    return new Intl.NumberFormat('de-DE', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
    }).format(valor);
}

function verDetalle(num) {
    window.location.href = `index.php?view=documento&num=${num}`;
}

function confirmarAnulacion(num) {
    Swal.fire({
        title: '¿Anular documento?',
        text: `Se anulará la transacción N° ${num}. Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ea5455',
        cancelButtonColor: '#82868b',
        confirmButtonText: 'Sí, anular',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí llamarías a tu proceso de anulación vía AJAX
            console.log("Anulando documento: " + num);
        }
    });
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
/**
 * Evento para enviar Nota de Entrega por Correo
 * Prioriza el email del cliente en la tabla, si no existe, lo solicita.
 */
$(document).on('click', '.btn-enviar-factura-email-nota', function(e) {
    e.preventDefault();
    
    const btn = $(this);
    const factNum = btn.attr('data-fact-num');
    const cliente = btn.attr('data-cliente');
    const emailCliente = btn.attr('data-email');
    const emailVendedor = btn.attr('data-emailV');
  //  console.log("Email del vendedor:", emailVendedor); // Debug: Verificar valor del email
    const tipoDoc = btn.attr('data-tipo'); // Normalmente 2 o 6 para Notas de Entrega
 //   console.log("Email del cliente:", emailCliente); // Debug: Verificar valor del email

    // 1. Si no hay email del cliente en la base de datos, abrir modal para pedirlo
    if (!emailCliente || emailCliente === '' || emailCliente === 'null') {
        Swal.fire({
            title: 'Enviar Nota por Correo',
            icon: 'info',
            html: `
                <div class="text-start mt-1">
                    <p class="mb-1"><strong>Nota #:</strong> ${factNum}</p>
                    <p class="mb-2"><strong>Cliente:</strong> ${cliente}</p>
                    <label class="form-label mt-2 fw-bold text-danger">El cliente no tiene correo registrado:</label>
                    <input type="email" id="swal-email-input" class="form-control" 
                           placeholder="nombre@ejemplo.com" required>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar ahora',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#ff9f43',
            allowOutsideClick: false,
            allowEscapeKey: false,
            preConfirm: () => {
                const email = document.getElementById('swal-email-input').value;
                // Función simple de validación de regex para email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email || !emailRegex.test(email)) {
                    Swal.showValidationMessage('Por favor ingrese un correo válido');
                    return false;
                }
                return { email: email };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                enviarFacturaEmail(factNum, result.value.email, cliente, btn, tipoDoc,0,emailVendedor);
            }
        });
    } 
    // 2. Si ya tenemos el email, solo pedir confirmación
    else {
        Swal.fire({
            title: '¿Confirmar Envío?',
            html: `
                <div class="text-start mt-1">
                    <p class="mb-1"><strong>Documento:</strong> ${factNum}</p>
                    <p class="mb-1"><strong>Cliente:</strong> ${cliente}</p>
                    <p class="mb-0"><strong>Destino:</strong> <span class="text-primary fw-bold">${emailCliente}</span></p>
                    <p class="mb-0"><strong>Vendedor:</strong> <span class="text-primary fw-bold">${emailVendedor}</span></p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, enviar nota',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#ff9f43',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviamos tipoDoc y el origen (usaremos el 2 como indicaste en el original)
                enviarFacturaEmail(factNum, emailCliente, cliente, btn, tipoDoc, 2,emailVendedor);
            }
        });
    }
});


// Delegación de eventos para botones dinámicos en la tabla - EMITIR NOTA DE CRÉDITO
// Delegación de eventos para botones dinámicos en la tabla - EMITIR NOTA DE CRÉDITO
$(document).on('click', '.btn-nota-credito-dev-tfhka', function() {
    let nc_num = $(this).attr('data-id'); // ID de la nota de crédito
    let factura_afectada = $(this).attr('data-factura-afectada'); // ID de la factura original
    let ncr_num_cr = $(this).attr('data-idnc'); // ID de la factura original
    Swal.fire({
        title: 'Emitir Nota de Crédito',
        html: `
            <div style="text-align: left; width: 100%;">
                <p style="margin-bottom: 15px;">Se emitirá una Nota de Crédito <strong>#${ncr_num_cr}</strong> para la factura <strong>#${factura_afectada}</strong> en TFHKA.</p>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; text-align: left;">
                        Motivo / Comentario <span style="color: red;">*</span>
                    </label>
                    <textarea id="comentario-nc" rows="3" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical;" placeholder="Ej: Devolución de mercancía, Corrección de factura, Descuento comercial...">Devolución de mercancía</textarea>
                    <small style="color: #6c757d; font-size: 11px;">Mínimo 10 caracteres</small>
                </div>
                
              
            </div>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, emitir Nota de Crédito',
        cancelButtonText: 'Cancelar',
        width: '500px',
        focusConfirm: false,
        preConfirm: () => {
            const comentario = document.getElementById('comentario-nc');
            const comentarioValue = comentario ? comentario.value.trim() : 'Devolución de mercancía';
            
            if (!comentarioValue) {
                if (comentario) comentario.style.borderColor = '#dc3545';
                Swal.showValidationMessage('⚠️ Debe ingresar el motivo de la Nota de Crédito');
                return false;
            }
            
            if (comentarioValue.length < 10) {
                if (comentario) comentario.style.borderColor = '#dc3545';
                Swal.showValidationMessage('⚠️ El motivo debe tener al menos 10 caracteres');
                return false;
            }
            
            if (comentario) comentario.style.borderColor = '#d1d5db';
            
            return {
                comentario: comentarioValue
            };
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            // Llamamos a la función que procesa el AJAX de Nota de Crédito
            emitirNotaCreditoDigital(nc_num, factura_afectada, result.value.comentario,ncr_num_cr);
        }
    });
});


// Función para Fiscalizar Nota de CRÉDITO (Tipo 3)
$(document).on('click', '.btn-nota-credito-admin-tfhka', function() {
    const factNum = $(this).data('id');
    const facturaAfectada = $(this).data('factura-afectada');

    Swal.fire({
        title: '¿Fiscalizar Nota de Crédito?',
        text: `Se enviará la nota N° ${factNum} (Afecta a: ${facturaAfectada}) a la impresora fiscal.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, fiscalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamada a tu proceso de fiscalización de Crédito
            fiscalizarNotaCreditoAdministrativa(factNum, facturaAfectada);
        }
    });
});

// Función para Fiscalizar Nota de DÉBITO (Tipo 4)
$(document).on('click', '.btn-nota-debito-admin-tfhka', function() {
    const factNum = $(this).data('id');
    const facturaAfectada = $(this).data('factura-afectada');

    Swal.fire({
        title: '¿Fiscalizar Nota de Débito?',
        text: `Se enviará la nota N° ${factNum} (Afecta a: ${facturaAfectada}) a la impresora fiscal.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffa800',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, fiscalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamada a tu proceso de fiscalización de Débito
            fiscalizarNotaDebitoAdministrativa(factNum, facturaAfectada);
        }
    });
});




function emitirFacturaDigital(fact_num) {
    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=2&c=FacturaData&t=factura&accion=1&datos=1',
        type: 'POST',
        data: {
            tipo: 2,
            accion: 1,
            datos: 1,
            fact_num: fact_num,
            tipo_doc: '01',
            c: 'FacturaData',
            t: 'factura'
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Procesando...',
                html: 'Comunicando con el servicio de Facturación...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
        },
        success: function(response) {
            const status = response.status;
            const apiData = response.data || {};
            const mensajeAPI = apiData.mensaje || response.message || "Sin mensaje del servidor";
            const resultado = apiData.resultado || null;
            const validaciones = apiData.validaciones || [];

            if (status === 'success') {
                const icono = apiData.codigo === "201" ? 'warning' : 'success';
                const titulo = apiData.codigo === "201" ? 'Documento Duplicado' : 'Procesado con Éxito';

                let htmlDetalle = `<div class="text-start mt-1" style="font-size: 0.9rem;">
                                    <p class="mb-0"><b>Estado:</b> ${mensajeAPI}</p>`;
                
                if (resultado) {
                    htmlDetalle += `
                        <hr class="my-50">
                        <p class="mb-0"><b>Nro. Documento:</b> ${resultado.numeroDocumento || 'N/A'}</p>
                        <p class="mb-0"><b>Nro. Control:</b> ${resultado.numeroControl || 'N/A'}</p>
                        <p class="mb-0"><b>Fecha:</b> ${resultado.fechaAsignacion || 'N/A'}</p>
                    `;
                }
                htmlDetalle += `</div>`;

                Swal.fire({
                    icon: icono,
                    title: titulo,
                    html: htmlDetalle,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false, // Obliga a interactuar
                    allowEscapeKey: false     // Bloquea teclado
                }).then((result) => {
                    // EL REFRESCO OCURRE AQUÍ: Solo cuando hacen clic en "Aceptar"
                    if (result.isConfirmed) {
                        if (typeof dt_documentos !== 'undefined') {
                            $('#btn-refresh-data').trigger('click');
                        }
                    }
                });

            } else {
                let htmlErrores = `<p class="text-danger fw-bold">${mensajeAPI}</p>`;

                if (validaciones.length > 0) {
                    htmlErrores += `<div class="alert alert-danger mt-1 text-start" style="font-size: 0.8rem;">
                        <ul class="mb-0 ps-1">
                            ${validaciones.map(err => `<li>${err}</li>`).join('')}
                        </ul>
                    </div>`;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'No se pudo procesar',
                    html: htmlErrores,
                    confirmButtonText: 'Revisar Datos',
                    confirmButtonColor: '#ea5455',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Fallo de Comunicación',
                text: 'Hubo un error al conectar con el servidor.',
                confirmButtonColor: '#ea5455',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    });
}
// ==========================================
// FUNCIÓN: Emitir Nota de Crédito Digital
// ==========================================
function emitirNotaCreditoDigital(idNotaCredito, idFacturaAfectada, comentario,ncr_num) {
    
    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=2&accion=3&c=FacturaData&t=factura&datos=1',
        type: 'POST',
        data: {
            tipo: 2,
            accion: 3,                    // accion=3 para Nota de Crédito
            datos: 1,
            c: 'FacturaData',
            t: 'factura',
            ncr_num: ncr_num,
            fact_num: idNotaCredito,      
            factura_afectada: idFacturaAfectada, 
            comentario: comentario,       
            tipo_doc: '02'                // 02 = Nota de Crédito
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Procesando...',
                html: 'Comunicando con TFHKA para emitir Nota de Crédito...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
        },
        success: function(response) {
            const status = response.status;
            const apiData = response.data || {};
            const mensajeAPI = apiData.mensaje || response.message || "Sin mensaje del servidor";
            const resultado = apiData.resultado || null;
            const validaciones = apiData.validaciones || [];

            if (status === 'success') {
                // Manejo de iconos y títulos según código de retorno (201 es advertencia por duplicado)
                const icono = apiData.codigo === "201" ? 'warning' : 'success';
                const titulo = apiData.codigo === "201" ? 'Documento Duplicado' : 'Nota de Crédito Emitida';

                let htmlDetalle = `<div class="text-start mt-1" style="font-size: 0.9rem;">
                                    <p class="mb-0"><b>Estado:</b> ${mensajeAPI}</p>`;
                
                if (resultado) {
                    htmlDetalle += `
                        <hr class="my-50">
                        <p class="mb-0"><b>Nro. NC:</b> ${resultado.numeroDocumento || 'N/A'}</p>
                        <p class="mb-0"><b>Nro. Control:</b> ${resultado.numeroControl || 'N/A'}</p>
                        <p class="mb-0"><b>Factura Afectada:</b> ${idFacturaAfectada}</p>
                        <p class="mb-0"><b>Fecha:</b> ${resultado.fechaAsignacion || 'N/A'}</p>
                    `;
                }
                htmlDetalle += `</div>`;

                Swal.fire({
                    icon: icono,
                    title: titulo,
                    html: htmlDetalle,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false, // OBLIGAR INTERACCIÓN
                    allowEscapeKey: false      // BLOQUEAR TECLADO
                }).then((result) => {
                    // EL REFRESCO OCURRE AQUÍ: Solo cuando hacen clic en "Aceptar"
                    // SOLO AQUÍ ACTUALIZAMOS
                    if (result.isConfirmed) {
                        console.log("Usuario hizo clic en OK. Refrescando Notas...");
                        
                        // Forzamos el refresco de la pestaña 2 (Notas) con filtro 1 (Pendientes)
                        if (typeof iniciarFlujoCarga === 'function') {
                            iniciarFlujoCarga(3, 1); 
                        } else {
                            // Si prefieres usar el disparador del botón:
                            $('#btn-refresh-data').trigger('click');
                        }
                    }
                });

            } else {
                // Manejo de errores de validación o fallos de la API
                let htmlErrores = `<p class="text-danger fw-bold">${mensajeAPI}</p>`;

                if (validaciones.length > 0) {
                    htmlErrores += `<div class="alert alert-danger mt-1 text-start" style="font-size: 0.8rem;">
                        <ul class="mb-0 ps-1">
                            ${validaciones.map(err => `<li>${err}</li>`).join('')}
                        </ul>
                    </div>`;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'No se pudo procesar la NC',
                    html: htmlErrores,
                    confirmButtonText: 'Revisar Datos',
                    confirmButtonColor: '#ea5455',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }
        },
        error: function(xhr) {
            console.error('Error Crítico:', xhr);
            Swal.fire({
                icon: 'error',
                title: 'Fallo de Comunicación',
                text: 'Hubo un error al conectar con el servidor de notas de crédito.',
                confirmButtonColor: '#ea5455',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    });
}
// ============================================================
// FUNCIÓN: Emitir Nota de Crédito Administrativa (Fiscalizar)
// ============================================================
function fiscalizarNotaCreditoAdministrativa(idNotaCredito, idFacturaAfectada, comentario = 'NOTA DE CREDITO') {

    // VALIDACIÓN PREVIA
    if (!idFacturaAfectada || idFacturaAfectada === "" || idFacturaAfectada == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Dato Faltante',
            text: 'Para emitir una Nota de Crédito es obligatorio indicar el número de la factura afectada.',
            confirmButtonColor: '#f8bb86'
        });
        return; // Detenemos la ejecución aquí
    }

    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=2&c=FacturaData&t=factura&accion=5&datos=1',
        type: 'POST',
        data: {
            tipo: 2,
            accion: 5,
            datos: 1,
            c: 'FacturaData',
            t: 'factura',
            fact_num: idNotaCredito,
            factura_afectada: idFacturaAfectada,
            comentario: comentario,
            tipo_doc: '02'
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Procesando...',
                html: 'Conectando con TFHKA para emitir Nota de Crédito Administrativa...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            const status = response.status;
            const apiData = response.data || {};
            const mensajeAPI = apiData.mensaje || response.message || "Sin mensaje del servidor";
            const resultado = apiData.resultado || null;
            const validaciones = apiData.validaciones || [];

            if (status === 'success') {
                // Si el código es 201 (Duplicado) usamos icono de advertencia, si es 200 éxito
                const icono = apiData.codigo === "201" ? 'warning' : 'success';
                const titulo = apiData.codigo === "201" ? 'Documento Duplicado' : '¡Nota de Crédito Emitida!';

                let htmlDetalle = `<div class="text-start mt-1" style="font-size: 0.9rem;">
                                    <p class="mb-0"><b>Estado:</b> ${mensajeAPI}</p>`;
                
                if (resultado) {
                    htmlDetalle += `
                        <hr class="my-50">
                        <p class="mb-0"><b>Documento Fiscal:</b> ${resultado.numeroDocumento || 'N/A'}</p>
                        <p class="mb-0"><b>Nro. Control:</b> ${resultado.numeroControl || 'N/A'}</p>
                        <p class="mb-0"><b>Fecha Fiscal:</b> ${resultado.fechaAsignacionNumeroControl || resultado.fechaAsignacion || 'N/A'}</p>
                        <p class="mb-0"><b>Factura Afectada:</b> ${idFacturaAfectada}</p>
                    `;
                }
                htmlDetalle += `</div>`;

                Swal.fire({
                    icon: icono,
                    title: titulo,
                    html: htmlDetalle,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false, // BLOQUEO TOTAL
                    allowEscapeKey: false,    // BLOQUEO TOTAL
                    stopKeydownPropagation: true
                }).then((result) => {
                    // EL REFRESCO OCURRE ÚNICAMENTE AQUÍ
                    if (result.isConfirmed) {
                      

                        console.log("Fiscalización completada. Refrescando tabla...");
                        
                        // Prioridad 1: Refresco de Pestaña 3 (Administrativas)
                        if (typeof iniciarFlujoCarga === 'function') {
                            iniciarFlujoCarga(4, 1); 
                        } 
                        // Prioridad 2: Botón de refresco global
                        else if ($('#btn-refresh-data').length) {
                            $('#btn-refresh-data').trigger('click');
                        }
                       
                    }
                });

            } else {
                // Manejo de errores de validación (Lista roja)
                let htmlErrores = `<p class="text-danger fw-bold">${mensajeAPI}</p>`;

                if (validaciones.length > 0) {
                    htmlErrores += `<div class="alert alert-danger mt-1 text-start" style="font-size: 0.8rem;">
                        <ul class="mb-0 ps-1">
                            ${validaciones.map(err => `<li>${err}</li>`).join('')}
                        </ul>
                    </div>`;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error de Validación Fiscal',
                    html: htmlErrores,
                    confirmButtonText: 'Revisar Datos',
                    confirmButtonColor: '#ea5455',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Fallo de Comunicación',
                text: 'No se pudo comunicar con el servidor de facturación.',
                confirmButtonColor: '#ea5455',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    });
}
// ============================================================
// FUNCIÓN: Emitir Nota de Débito Administrativa (Fiscalizar)
// ============================================================
function fiscalizarNotaDebitoAdministrativa(idNotaDebito, idFacturaAfectada, comentario = 'NOTA DE DEBITO') {
    // VALIDACIÓN PREVIA
    if (!idFacturaAfectada || idFacturaAfectada === "" || idFacturaAfectada == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Dato Faltante',
            text: 'Para emitir una Nota de Crédito es obligatorio indicar el número de la factura afectada.',
            confirmButtonColor: '#f8bb86'
        });
        return; // Detenemos la ejecución aquí
    }
    $.ajax({
        url: '../admin/index.php?action=facturacion&tipo=2&accion=6&c=FacturaData&t=factura&datos=1',
        type: 'POST',
        data: {
            tipo: 2,
            accion: 6,                    // Manteniendo tu acción original de ND
            datos: 1,
            c: 'FacturaData',
            t: 'factura',
            fact_num: idNotaDebito,
            factura_afectada: idFacturaAfectada,
            comentario: comentario,
            tipo_doc: '03'                // 03 suele ser Nota de Débito
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Procesando...',
                html: 'Conectando con TFHKA para emitir Nota de Débito...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            const status = response.status;
            const apiData = response.data || {};
            const mensajeAPI = apiData.mensaje || response.message || "Sin mensaje del servidor";
            const resultado = apiData.resultado || null;
            const validaciones = apiData.validaciones || [];

            if (status === 'success') {
                // Manejo de duplicados (201) o éxito normal (200)
                const icono = apiData.codigo === "201" ? 'warning' : 'success';
                const titulo = apiData.codigo === "201" ? 'Documento Duplicado' : '¡Nota de Débito Emitida!';

                let htmlDetalle = `<div class="text-start mt-1" style="font-size: 0.9rem;">
                                    <p class="mb-0"><b>Estado:</b> ${mensajeAPI}</p>`;
                
                if (resultado) {
                    htmlDetalle += `
                        <hr class="my-50">
                        <p class="mb-0"><b>Documento Fiscal:</b> ${resultado.numeroDocumento || 'N/A'}</p>
                        <p class="mb-0"><b>Nro. Control:</b> ${resultado.numeroControl || 'N/A'}</p>
                        <p class="mb-0"><b>Fecha Fiscal:</b> ${resultado.fechaAsignacionNumeroControl || resultado.fechaAsignacion || 'N/A'}</p>
                        <p class="mb-0"><b>Factura Afectada:</b> ${idFacturaAfectada}</p>
                    `;
                }
                htmlDetalle += `</div>`;

                Swal.fire({
                    icon: icono,
                    title: titulo,
                    html: htmlDetalle,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    // EL REFRESCO OCURRE AQUÍ: Al hacer clic en Aceptar
                    if (result.isConfirmed) {
                       

                        console.log("Nota de Débito procesada. Refrescando...");
                        
                        // Refresco de pestaña de Administrativas (asumiendo flujo 3, pestaña 1)
                        if (typeof iniciarFlujoCarga === 'function') {
                            iniciarFlujoCarga(5, 1); 
                        } 
                        else if ($('#btn-refresh-data').length) {
                            $('#btn-refresh-data').trigger('click');
                        }
                      
                    }
                });

            } else {
                // Manejo de errores de validación
                let htmlErrores = `<p class="text-danger fw-bold">${mensajeAPI}</p>`;

                if (validaciones.length > 0) {
                    htmlErrores += `<div class="alert alert-danger mt-1 text-start" style="font-size: 0.8rem;">
                        <ul class="mb-0 ps-1">
                            ${validaciones.map(err => `<li>${err}</li>`).join('')}
                        </ul>
                    </div>`;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error en Nota de Débito',
                    html: htmlErrores,
                    confirmButtonText: 'Revisar Datos',
                    confirmButtonColor: '#ea5455',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error de Red',
                text: 'No se pudo comunicar con el servidor para la Nota de Débito.',
                confirmButtonColor: '#ea5455',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    });
}



// ==========================================
// FUNCIÓN: Restaurar Botón
// ==========================================
function restaurarBoton(btn) {
    btn.prop('disabled', false)
       .html(feather.icons['mail'].toSvg({ class: 'font-medium-2' }));
}

// ==========================================
// FUNCIÓN: Enviar Factura por Email (AJAX)
// ==========================================
function enviarFacturaEmail(factNum, emailDestino, cliente, btn, tipoDoc, tipoFuncion,emailVendedor) {
    
    // 1. Loading Bloqueante Estricto
    Swal.fire({
        title: 'Procesando...',
        html: 'Generando PDF y enviando correo...',
        allowOutsideClick: false, // Bloqueo de clic externo
        allowEscapeKey: false,    // Bloqueo de tecla Esc
        allowEnterKey: false,     // Bloqueo de tecla Enter
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: '../admin/index.php?action=enviarDocumentos',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'enviar_factura_email',
            fact_num: factNum,
            email_destino: emailDestino,
            cliente: cliente,
            tipoDoc: tipoDoc,
            tipoFuncion: tipoFuncion,
            emailVendedor: emailVendedor
        },
       success: function(response) {
    // Cerramos cualquier rastro del loading anterior
            Swal.close();

            // Validamos el éxito (asegurando que trate "true" o true como éxito)
            const esExitoso = (response.success === true || response.success === "true");

            if (esExitoso) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo Enviado!',
                    text: response.message, // El texto que vemos en tu imagen
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#006af5', // El morado de tu botón en la imagen
                    
                    // --- BLOQUEO TOTAL CRÍTICO ---
                    allowOutsideClick: false,  // No cierra al hacer clic fuera
                    allowEscapeKey: false,     // No cierra con ESC
                    allowEnterKey: true,       // Solo permite Enter para aceptar
                    showConfirmButton: true,
                    showCloseButton: false,    // Oculta la "X" si existiera
                    
                    // Detiene cualquier otro evento del teclado
                    stopKeydownPropagation: true 
                }).then((result) => {
                    // SOLO AQUÍ ACTUALIZAMOS
                    if (result.isConfirmed) {
                        console.log("Usuario hizo clic en OK. Refrescando Notas...");
                        
                        // Forzamos el refresco de la pestaña 2 (Notas) con filtro 1 (Pendientes)
                        if (typeof iniciarFlujoCarga === 'function') {
                            iniciarFlujoCarga(2, 1); 
                        } else {
                            // Si prefieres usar el disparador del botón:
                            $('#btn-refresh-data').trigger('click');
                        }
                    }
                });
            } else {
                // Manejo de error si response.success no es true
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'No se pudo enviar el correo',
                    confirmButtonColor: '#ea5455',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error Crítico AJAX:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de Conexión',
                text: 'No se pudo comunicar con el servidor.',
                confirmButtonColor: '#dc3545',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        },
        complete: function() {
            if (typeof restaurarBoton === 'function') {
                restaurarBoton(btn);
            }
        }
    });
}
