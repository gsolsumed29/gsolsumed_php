// =============================================
// CARGA_VEHICULO.JS - SISTEMA DE CARGA DE VEHÍCULOS
// =============================================

// Variables globales únicas para el sistema de carga
let cargaCurrentInput = null;
let cargaCurrentMode = null;
let cargaFocoBloqueado = false;
let cargaTiempoEsperaFoco = 100;
let cargaEscaneoEnProgreso = false;
let cargaUltimoCodigoEscaneado = '';
let cargaTiempoUltimoEscaneo = 0;
let cargaScannerBuffer = '';
let cargaScannerTimeout = null;
let cargaTouchTimer = null;
let cargaTouchStartTime = 0;
let cargaTouchHoldThreshold = 300;
let cargaPaquetesCargados = [];
let cargaFacturasAsociadas = [];
// Variables globales para cachear datos
let cachedChoferes = null;
let cachedZonas = null;
let cachedVehiculos = null;

// NUEVA FUNCIONALIDAD: Variable para controlar la pausa manual del foco
let cargaFocoPausadoManualmente = false;

// =============================================
// SISTEMA DE TECLADO VIRTUAL PARA CARGA
// =============================================

function cargaInitCustomKeyboard() {
    console.log('Inicializando teclado virtual para carga...');
    
    // Campo de búsqueda - Modificado para permitir escaneo y entrada manual simultáneamente
    $('#buscarPaqueteInput')
        .prop('readonly', false)
        .attr('inputmode', 'none')
        .css('caret-color', 'transparent')
        // CORRECCIÓN: Simplificamos el evento focus. La lógica de reanudación se mueve al botón.
        .on('focus', function(e) {
            $(this).select();
        })
        .on('input', function() {
            if (cargaEscaneoEnProgreso) return;
            
            const codigo = $(this).val().trim();
            clearTimeout($(this).data('scanner-timeout'));
            
            $(this).data('scanner-timeout', setTimeout(() => {
                if (codigo.length > 0 && !cargaEscaneoEnProgreso) {
                    console.log('Búsqueda automática:', codigo);
                    cargaBuscarPaquetePorCodigo(codigo);
                }
            }, 500));
        })
        .on('keydown', function(e) {
            if (e.key.length === 1 || e.key === 'Enter') {
                if (e.key === 'Enter') {
                    if (cargaScannerBuffer.length >= 10) {
                        cargaBuscarPaquetePorCodigo(cargaScannerBuffer);
                        cargaScannerBuffer = '';
                    }
                } else {
                    cargaScannerBuffer += e.key;
                    clearTimeout(cargaScannerTimeout);
                    cargaScannerTimeout = setTimeout(() => {
                        if (cargaScannerBuffer.length >= 10) {
                            cargaBuscarPaquetePorCodigo(cargaScannerBuffer);
                        }
                        cargaScannerBuffer = '';
                    }, 300);
                }
            }
        })
        .on('touchstart', function(e) {
            e.preventDefault();
            cargaTouchStartTime = Date.now();
            $(this).addClass('carga-touch-hold-indicator');
            cargaTouchTimer = setTimeout(() => {
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
                cargaMostrarTecladoManual($(this), 'search');
                $(this).removeClass('carga-touch-hold-indicator');
            }, cargaTouchHoldThreshold);
        })
        .on('touchend', function(e) {
            e.preventDefault();
            $(this).removeClass('carga-touch-hold-indicator');
            if (cargaTouchTimer) {
                clearTimeout(cargaTouchTimer);
                cargaTouchTimer = null;
            }
        })
        .on('touchcancel', function(e) {
            e.preventDefault();
            $(this).removeClass('carga-touch-hold-indicator');
            if (cargaTouchTimer) {
                clearTimeout(cargaTouchTimer);
                cargaTouchTimer = null;
            }
        })
        .on('mousedown', function(e) {
            e.preventDefault();
            cargaTouchStartTime = Date.now();
            $(this).addClass('carga-touch-hold-indicator');
            cargaTouchTimer = setTimeout(() => {
                cargaMostrarTecladoManual($(this), 'search');
                $(this).removeClass('carga-touch-hold-indicator');
            }, cargaTouchHoldThreshold);
        })
        .on('mouseup', function(e) {
            e.preventDefault();
            $(this).removeClass('carga-touch-hold-indicator');
            if (cargaTouchTimer) {
                clearTimeout(cargaTouchTimer);
                cargaTouchTimer = null;
            }
        })
        .on('mouseleave', function(e) {
            $(this).removeClass('carga-touch-hold-indicator');
            if (cargaTouchTimer) {
                clearTimeout(cargaTouchTimer);
                cargaTouchTimer = null;
            }
        });
    
    // Teclas para búsqueda
    $('#cargaKeyboardSearch .carga-keyboard-key[data-value]').on('click', function() {
        if (!cargaCurrentInput || cargaCurrentMode !== 'search') return;
        
        const value = $(this).data('value');
        const currentVal = cargaCurrentInput.val() || '';
        cargaCurrentInput.val(currentVal + value);
    });
    
    $('#cargaKeyClearSearch').on('click', function() {
        if (!cargaCurrentInput || cargaCurrentMode !== 'search') return;
        cargaCurrentInput.val('');
    });
    
    $('#cargaKeySearchEnter').on('click', function() {
        if (!cargaCurrentInput || cargaCurrentMode !== 'search') return;
        
        const valor = cargaCurrentInput.val().trim();
        if (valor) {
            cargaBuscarPaquete();
        } else {
            cargaMostrarError('Ingrese un código para buscar');
        }
        cargaOcultarTeclado();
    });
    
    // Cerrar teclado
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.carga-custom-keyboard, .carga-btn-teclado').length) {
            cargaOcultarTeclado();
        }
    });
}

// Función para mostrar teclado manualmente
function cargaMostrarTecladoManual(input, modo) {
    cargaCurrentInput = input;
    cargaCurrentMode = modo;
    cargaMostrarTecladoModo(modo);
    
    if (modo === 'search') {
        input.addClass('carga-input-search-mode');
    }
}

function cargaMostrarTecladoModo(modo) {
    $('.carga-keyboard-mode').hide();
    
    if (modo === 'search') {
        $('#cargaKeyboardSearch').show();
        $('#cargaKeyboardTitle').text('Teclado de Búsqueda');
    }
    
    $('#cargaCustomKeyboard').slideDown(300);
    cargaFocoBloqueado = true;
}

function cargaOcultarTeclado() {
    $('#cargaCustomKeyboard').slideUp(300);
    cargaFocoBloqueado = false;
    
    if (cargaCurrentInput) {
        cargaCurrentInput.removeClass('carga-input-search-mode');
        cargaCurrentInput = null;
    }
    cargaCurrentMode = null;
}

// =============================================
// SISTEMA DE BÚSQUEDA Y ESCANEO DE PAQUETES
// =============================================

// --- Constantes para evitar "números mágicos" ---
const DUPLICATE_SCAN_THRESHOLD_MS = 1000; // 1 segundo para ignorar duplicados
const RESET_FOCUS_DELAY_MS = 100;       // Tiempo para limpiar el input y darle foco
const UNLOCK_DELAY_MS = 500;            // Tiempo para desbloquear el siguiente escaneo

/**
 * Busca un paquete por su código de lote usando la API Fetch.
 * Es asíncrona y maneja correctamente la respuesta del backend (un array).
 * @param {string} codigo - El código del paquete a buscar.
 */
async function cargaBuscarPaquetePorCodigo(codigo) {
    // 1. Cláusulas de guarda: Salir si no hay código o si ya hay una búsqueda en curso.
    if (!codigo || cargaEscaneoEnProgreso) {
        return;
    }

    // 2. Prevención de escaneos duplicados (Debouncing).
    const ahora = Date.now();
    if (codigo === cargaUltimoCodigoEscaneado && (ahora - cargaTiempoUltimoEscaneo) < DUPLICATE_SCAN_THRESHOLD_MS) {
        console.log('Ignorando escaneo duplicado:', codigo);
        return;
    }

    // 3. Actualizar estado y preparar para la búsqueda.
    console.log('Buscando paquete con código:', codigo);
    cargaEscaneoEnProgreso = true;
    cargaUltimoCodigoEscaneado = codigo;
    cargaTiempoUltimoEscaneo = ahora;

    // 4. Construcción de la URL de forma segura con URLSearchParams.
    const params = new URLSearchParams({
        action: 'embarco',
        tipo: '1',
        accion: '1',
        datos: '1',
        c: 'PaqueteData',
        t: 'jm_paquetes_reg',
        filtro: codigo
    });
    const url = `../admin/index.php?${params.toString()}`;

    try {
        // 5. Realizar la llamada asíncrona con Fetch.
        const response = await fetch(url);

        // Verificar si la respuesta del servidor fue exitosa (status 200-299).
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }

        // 6. Procesar la respuesta JSON.
        // El backend devuelve un array de paquetes o un array vacío.
        const paquetesEncontrados = await response.json();

        // 7. Manejar el resultado basado en si el array tiene elementos.
        if (Array.isArray(paquetesEncontrados) && paquetesEncontrados.length > 0) {
            // --- CASO DE ÉXITO: Se encontró al menos un paquete ---
            console.log('Paquete(s) encontrado(s):', paquetesEncontrados);
            cargaOcultarTeclado();

            // Procesar todos los paquetes encontrados
            let paquetesProcesados = 0;
            paquetesEncontrados.forEach(paquete => {
                // Mapear las propiedades de la nueva estructura a las que el sistema espera
                const paqueteMapeado = {
                    id: paquete.id || paquete.co_cli, // Usar co_cli como identificador si no hay id
                    codigo: paquete.co_lote || paquete.co_lote, // Usar fact_num como código si no hay código                   
                    facturas: paquete.facturas || paquete.co_lote, // Usar fact_num como código si no hay código                   
                    items_count: paquete.numero_paquete || 1, // Valor por defecto si no existe
                    saldo: paquete.saldo,
                    fec_emis: paquete.fec_emis,
                    fec_venc: paquete.fec_venc
                };
                
                // Verificar si el paquete ya está cargado
                if (!cargaPaquetesCargados.some(p => p.id === paqueteMapeado.id)) {
                    // Agregar paquete a la lista de cargados
                    cargaPaquetesCargados.push(paqueteMapeado);
                    
                    // Agregar fila a la tabla
                    cargaAgregarFilaPaquete(paqueteMapeado);
                    
                    // Verificar si la factura ya está en la lista de asociadas
                    if (!cargaFacturasAsociadas.some(f => f.id === paqueteMapeado.factura_id)) {
                        // Obtener detalles de la factura
                        $.ajax({
                            type: "GET",
                            url: '../admin/index.php?action=facturas&a=detalles&id=' + paqueteMapeado.factura_id,
                            dataType: 'json'
                        }).done(function(data) {
                            if (data.success) {
                                cargaFacturasAsociadas.push(data.factura);
                                cargaMostrarNotificacionFacturaNueva(data.factura);
                            }
                        });
                    }
                }
                paquetesProcesados++;
            });

            // Actualizar resumen
            cargaActualizarResumenCarga();

            // Preparar la UI para el siguiente escaneo.
            setTimeout(() => {
                const inputElement = document.getElementById('buscarPaqueteInput');
                if (inputElement) {
                    inputElement.value = '';
                    inputElement.focus();
                }
                setTimeout(() => { cargaEscaneoEnProgreso = false; }, UNLOCK_DELAY_MS);
            }, RESET_FOCUS_DELAY_MS);

        } else {
            // --- CASO DE FALLO LÓGICO: No se encontró el paquete (array vacío) ---
            console.log('Paquete NO encontrado para el código:', codigo);
            cargaManejarPaqueteNoEncontrado(codigo);
            const inputElement = document.getElementById('buscarPaqueteInput');
            if (inputElement) {
                inputElement.focus();
                inputElement.select();
            }
            setTimeout(() => { cargaEscaneoEnProgreso = false; }, 300);
        }

    } catch (error) {
        // 8. Manejar errores de red o del servidor.
        console.error('Error en la búsqueda de paquete:', error);
        cargaMostrarError('Error al comunicarse con el servidor');
        setTimeout(() => { cargaEscaneoEnProgreso = false; }, 300);
    }
}

function cargaBuscarPaquete() {
    const codigoBuscado = $('#buscarPaqueteInput').val().trim();
    if (!codigoBuscado) {
        cargaMostrarError('Por favor ingrese un código para buscar');
        return;
    }
    cargaBuscarPaquetePorCodigo(codigoBuscado);
}

function cargaProcesarPaqueteEncontrado(paquete) {
    console.log('Procesando paquete encontrado:', paquete);
    // MODIFICADO: Estructura del objeto para que coincida con lo que se necesita enviar.
    // Se asume que el backend ahora proporciona los campos 'id', 'co_lote' y 'numero_paquete'.
    const paqueteMapeado = {
        id: paquete.id, // ID único del registro del paquete/lote
        loteID: paquete.co_lote, // ID del lote al que pertenece
        cantidad_paquetes: paquete.numero_paquete || 1, // Cantidad de paquetes en este lote/registro
        
        // Se mantienen los demás campos para la UI y otras lógicas
        codigo: paquete.co_lote,
        facturas: paquete.facturas,
        items_count: paquete.numero_paquete || 1, // Mantenemos por compatibilidad con la UI
        saldo: paquete.saldo,
        fec_emis: paquete.fec_emis,
        fec_venc: paquete.fec_venc
    };
    
    // Verificar si el paquete ya está cargado
    if (cargaPaquetesCargados.some(p => p.id === paqueteMapeado.id)) {
        cargaMostrarError('Este paquete ya ha sido cargado en el vehículo');
        return;
    }
    
    // Agregar paquete a la lista de cargados
    cargaPaquetesCargados.push(paqueteMapeado);
    
    // Agregar fila a la tabla
    cargaAgregarFilaPaquete(paqueteMapeado);
    
    // Actualizar resumen
    cargaActualizarResumenCarga();
    
    // Verificar si la factura ya está en la lista de asociadas
    if (!cargaFacturasAsociadas.some(f => f.id === paqueteMapeado.factura_id)) {
        // Obtener detalles de la factura
        $.ajax({
            type: "GET",
            url: '../admin/index.php?action=facturas&a=detalles&id=' + paqueteMapeado.factura_id,
            dataType: 'json'
        }).done(function(data) {
            if (data.success) {
                cargaFacturasAsociadas.push(data.factura);
                cargaMostrarNotificacionFacturaNueva(data.factura);
            }
        });
    }
    
    cargaLimpiarCampoBusqueda();
}

function cargaAgregarFilaPaquete(paquete) {
    console.log('Agregando fila para el paquete:', paquete);
    const fila = `
        <tr class="carga-fila-paquete" data-paquete-id="${paquete.id}">
            <td class="py-1 align-middle text-center">${paquete.id}</td>
            <td class="py-1 align-middle">${paquete.codigo}</td>
            <td class="py-1 align-middle">
                <a href="#" class="carga-factura-link" data-factura-id="${paquete.facturas}">${paquete.facturas}</a>
            </td>
            <td class="py-1 align-middle text-center">${paquete.items_count}</td>
            <td class="py-1 align-middle text-center">
                <span class="badge bg-success">Cargado</span>
            </td>
            <td class="py-1 align-middle text-center">
                <button type="button" class="btn btn-sm btn-outline-danger carga-btn-eliminar-paquete" data-paquete-id="${paquete.id}">
                    <i data-feather="trash-2"></i>
                </button>
            </td>
        </tr>
    `;
    
    $('#filaPaquetes').append(fila);
    feather.replace();
    
    // Agregar evento para eliminar paquete
    $(`.carga-btn-eliminar-paquete[data-paquete-id="${paquete.id}"]`).on('click', function() {
        cargaEliminarPaquete(paquete.id);
    });
    
    // Agregar evento para ver detalles de factura
    $(`.carga-factura-link[data-factura-id="${paquete.factura_id}"]`).on('click', function(e) {
        e.preventDefault();
        cargaVerDetallesFactura(paquete.factura_id);
    });
}

function cargaEliminarPaquete(paqueteId) {
    // Confirmar eliminación
    Swal.fire({
        title: '¿Eliminar paquete?',
        text: "¿Está seguro de que desea eliminar este paquete de la carga?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Eliminar de la lista
            cargaPaquetesCargados = cargaPaquetesCargados.filter(p => p.id !== paqueteId);
            
            // Eliminar fila
            $(`.carga-fila-paquete[data-paquete-id="${paqueteId}"]`).remove();
            
            // Actualizar numeración
            cargaActualizarNumeracionFilas();
            
            // Actualizar resumen
            cargaActualizarResumenCarga();
            
            // Verificar si hay que eliminar factura de asociadas
            cargaVerificarFacturasAsociadas();
            
            Swal.fire(
                'Eliminado',
                'El paquete ha sido eliminado de la carga.',
                'success'
            );
        }
    });
}

function cargaActualizarNumeracionFilas() {
    $('#filaPaquetes .carga-fila-paquete').each(function(index) {
        $(this).find('td:first-child').text(index + 1);
    });
}

function cargaVerificarFacturasAsociadas() {
    // Obtener IDs de facturas de los paquetes cargados
    const facturasIds = [...new Set(cargaPaquetesCargados.map(p => p.factura_id))];
    
    // Filtrar facturas asociadas para mantener solo las que tienen paquetes
    cargaFacturasAsociadas = cargaFacturasAsociadas.filter(f => facturasIds.includes(f.id));
}

function cargaLimpiarCampoBusqueda() {
    setTimeout(function() {
        $('#buscarPaqueteInput').val('').focus();
    }, 100);
}

function cargaManejarPaqueteNoEncontrado(codigoBuscado) {
    cargaMostrarError('No se encontró ningún paquete con el código: ' + codigoBuscado);
    $('#buscarPaqueteInput').focus().select();
    cargaLimpiarCampoBusqueda();
}

// =============================================
// SISTEMA DE DETALLES DE FACTURA
// =============================================

function cargaVerDetallesFactura(facturaId) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php?action=facturas&a=detalles_completos&id=' + facturaId,
        dataType: 'json'
    }).done(function(data) {
        if (data.success) {
            // Limpiar tabla de detalles
            $('#tablaDetallesFactura tbody').empty();
            
            // Agregar detalles
            data.detalles.forEach(function(detalle) {
                const fila = `
                    <tr>
                        <td>${detalle.co_art}</td>
                        <td>${detalle.descripcion}</td>
                        <td>${detalle.cantidad}</td>
                    </tr>
                `;
                $('#tablaDetallesFactura tbody').append(fila);
            });
            
            // Mostrar modal
            $('#modalDetallesFactura').modal('show');
        } else {
            // Si no se encuentran detalles, mostrar información básica de la factura
            const factura = cargaFacturasAsociadas.find(f => f.id === facturaId);
            if (factura) {
                $('#tablaDetallesFactura tbody').empty();
                const fila = `
                    <tr>
                        <td colspan="3" class="text-center">
                            <p><strong>Número de Factura:</strong> ${factura.fact_num}</p>
                            <p><strong>Cliente:</strong> ${factura.co_cli}</p>
                            <p><strong>Saldo:</strong> ${factura.saldo}</p>
                            <p><strong>Fecha de Emisión:</strong> ${factura.fec_emis}</p>
                            <p><strong>Fecha de Vencimiento:</strong> ${factura.fec_venc}</p>
                        </td>
                    </tr>
                `;
                $('#tablaDetallesFactura tbody').append(fila);
                $('#modalDetallesFactura').modal('show');
            } else {
                cargaMostrarError('Error al cargar los detalles de la factura');
            }
        }
    }).fail(function() {
        cargaMostrarError('Error al comunicarse con el servidor');
    });
}

function cargaMostrarNotificacionFacturaNueva(factura) {
    Swal.fire({
        title: 'Nueva Factura Asociada',
        html: `
            <div>
                <p>Se ha agregado una nueva factura a la carga:</p>
                <p><strong>Número:</strong> ${factura.fact_num}</p>
                <p><strong>Cliente:</strong> ${factura.co_cli}</p>
                <p><strong>Saldo:</strong> ${factura.saldo}</p>
                <p><strong>Fecha de Emisión:</strong> ${factura.fec_emis}</p>
                <p><strong>Fecha de Vencimiento:</strong> ${factura.fec_venc}</p>
            </div>
        `,
        icon: 'info',
        timer: 3000,
        showConfirmButton: false
    });
}

// =============================================
// SISTEMA DE GESTIÓN DE FOCO
// =============================================

function cargaInicializarSistemaFoco() {
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#buscarPaqueteInput, .btn, .modal').length) {
            if (!cargaFocoBloqueado) {
                setTimeout(cargaRestaurarFocoBuscador, 50);
            }
        }
    });
    
    $(document).on('hidden.bs.modal', function() {
        setTimeout(() => {
            if (!cargaFocoBloqueado) {
                cargaRestaurarFocoBuscador();
            }
        }, 300);
    });
    
    $('.btnConfirmarCarga').on('click', function() {
        if (!$(this).prop('disabled')) {
            cargaConfirmarCarga();
        }
    });
    
    setTimeout(() => { cargaRestaurarFocoBuscador(); }, 1000);
}

function cargaGestionarFoco(bloquear) {
    cargaFocoBloqueado = bloquear;
    if (!bloquear) {
        setTimeout(() => {
            if (!cargaFocoBloqueado) {
                cargaRestaurarFocoBuscador();
            }
        }, cargaTiempoEsperaFoco);
    }
}

function cargaRestaurarFocoBuscador() {
    // NUEVA FUNCIONALIDAD: Añadimos la condición para no restaurar el foco si está pausado manualmente
    if (cargaFocoBloqueado || cargaFocoPausadoManualmente) return;
    
    const buscador = $('#buscarPaqueteInput');
    if (buscador.length && buscador.is(':visible')) {
        const inputActivo = $(':focus');
        if (!inputActivo.is('#buscarPaqueteInput')) {
            buscador.focus();
        }
    }
}

// =============================================
// SISTEMA DE CARGA COMPLETA
// =============================================

function cargaActualizarResumenCarga() {
    // MODIFICADO: Calcular el total de paquetes sumando la nueva propiedad 'cantidad_paquetes'.
    const totalPaquetes = cargaPaquetesCargados.reduce((total, paquete) => total + parseInt(paquete.items_count || 0), 0);
    $('#totalPaquetes').text(totalPaquetes);
    
    // Calcular peso total
    /*const pesoTotal = cargaPaquetesCargados.reduce((total, paquete) => total + parseFloat(paquete.peso || 0), 0);
    $('#pesoTotal').text(pesoTotal.toFixed(2) + ' kg');*/
    
    // Calcular espacio utilizado (simulado)
   /* const capacidadTotal = parseFloat($('#vehiculo').data('capacidad') || 100);
    const espacioUtilizado = Math.min(100, (cargaPaquetesCargados.length / capacidadTotal) * 100);
    $('#espacioUtilizado').text(espacioUtilizado.toFixed(1) + '%');*/
    
    // Verificar estado del botón de confirmación
    cargaVerificarEstadoConfirmacion();
}

// Función unificada para confirmar carga (eliminando la duplicación)
function cargaConfirmarCarga() {
    const vehiculoId = $('#vehiculo').val();
    const chofer = $('#chofer').val();
    const ayudante = $('#ayudante').val();
    const zona = $('#zona').val();
    
    // Validar que se hayan seleccionado todos los campos necesarios
    if (!vehiculoId || !chofer || !ayudante || !zona) {
        let mensajeError = 'Por favor complete los siguientes campos:';
        if (!vehiculoId) mensajeError += '<br>- Vehículo';
        if (!chofer) mensajeError += '<br>- Chofer';
        if (!ayudante) mensajeError += '<br>- Ayudante';
        if (!zona) mensajeError += '<br>- Zona de despacho';
        
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            html: mensajeError,
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    // NUEVO: Obtener datos del vehículo seleccionado
    const vehiculoSeleccionado = cachedVehiculos.find(v => v.co_vehiculo == vehiculoId);
    const placaVehiculo = vehiculoSeleccionado ? vehiculoSeleccionado.vehiculo_des : 'Desconocido';
    
    Swal.fire({
        title: '¿CONFIRMAR CARGA DEL VEHÍCULO?',
        html: `
            <div style="text-align: left;">
                <p><strong>Vehículo:</strong> ${placaVehiculo}</p>
                <p><strong>Chofer:</strong> ${$('#chofer option:selected').text()}</p>
                <p><strong>Ayudante:</strong> ${$('#ayudante option:selected').text()}</p>
                <p><strong>Zona de Despacho:</strong> ${$('#zona option:selected').text()}</p>
                <p><strong>Total Paquetes:</strong> ${$('#totalPaquetes').text()}</p>
               
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, confirmar carga',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log(cargaPaquetesCargados);
            // NUEVO: Preparar los datos con la nueva estructura
            // 1. Calcular el total de paquetes para el encabezado
            const totalPaquetes = cargaPaquetesCargados.reduce((total, paquete) => total + parseInt(paquete.items_count || 0), 0);

            // 2. Crear el array de lotes con la estructura requerida
            const datosLotees = cargaPaquetesCargados.map(p => ({
                id: p.id,
                loteID: p.codigo,
                cantidad_paquetes: p.items_count
            }));

            // 3. Construir el objeto final con encabezado y lotes
            const datosCarga = {
                action: 'confirmar_carga',
                emcabezado: { // NUEVO: Estructura de encabezado
                    vehiculo: vehiculoId,
                    chofer_id: chofer,
                    ayudante_id: ayudante,
                    zona_id: zona,
                    total_paquetes: totalPaquetes // NUEVO: Campo añadido al encabezado
                },
                lotes: datosLotees, // MODIFICADO: Estructura de lotes
              
                fecha_carga: new Date().toISOString()
            };
            
            // Enviar datos al servidor
            cargaEnviarCarga(datosCarga);
        }
    });
}

// =============================================
// FUNCIONES DE COMUNICACIÓN CON SERVIDOR
// =============================================

async function cargaEnviarCarga(datosCarga) {
    try {
        const jsonData = JSON.stringify(datosCarga);
        const response = await $.ajax({
            url: '../admin/index.php?action=embarco&tipo=1&accion=1&datos=2',
            type: 'POST',
            data: jsonData,
            processData: false,
            contentType: 'application/json'
        });
        
        const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
        
        if (jsonResponse.success) {
            await Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: jsonResponse.message || 'Carga registrada exitosamente',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
            });
            window.location.href = 'index.php?view=embarcos';
        } else {
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jsonResponse.message || 'Error en la carga',
                confirmButtonText: 'Entendido'
            });
        }
        return jsonResponse;
    } catch (error) {
        console.error('Error en cargaEnviarCarga:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Ocurrió un error al procesar la solicitud: ' + error.message,
            confirmButtonText: 'Entendido'
        });
        throw error;
    }
}

// =============================================
// FUNCIONES DE UTILIDAD
// =============================================

function cargaMostrarError(mensaje) {
    if (!$('#carga-swf-alert-styles').length) {
        const alertStyles = `
        .carga-swf-alert-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center; animation: cargaSwfFadeIn 0.3s ease-out; }
        .carga-swf-alert { background: linear-gradient(to bottom, #ff7c7c, #d32f2f); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.4); max-width: 400px; width: 80%; font-family: Arial, sans-serif; font-size: 16px; text-align: center; border: 2px solid #ff4c4c; position: relative; }
        .carga-swf-alert::before { content: '⚠️'; font-size: 32px; display: block; margin-bottom: 15px; }
        @keyframes cargaSwfFadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes cargaSwfFadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-20px); } }`;
        $('head').append(`<style id="carga-swf-alert-styles">${alertStyles}</style>`);
    }
    
    const overlay = $('<div class="carga-swf-alert-overlay"></div>');
    const alert = $(`<div class="carga-swf-alert">${mensaje}</div>`);
    overlay.append(alert);
    
    setTimeout(() => {
        overlay.css('animation', 'cargaSwfFadeOut 0.5s ease-out');
        setTimeout(() => overlay.remove(), 500);
    }, 2000);
    
    $('body').append(overlay);
    cargaPlaySound('../assets/media/e2.mp3');
}

function cargaPlaySound(url) {
    const audio = new Audio(url);
    audio.play().catch(e => console.log("Reproducción de audio prevenida por el navegador: ", e));
}

// =============================================
// INICIALIZACIÓN
// =============================================

// Función para cargar datos iniciales desde la base de datos
async function cargaDatosIniciales() {
    try {
        // Mostrar indicador de carga
        $('#loadingIndicator').show();
        
        // Cargar choferes desde la base de datos (con cache)
        if (!cachedChoferes) {
            const choferes = await $.ajax({
                url: '../admin/index.php?action=empaquetado&tipo=1&accion=2&datos=3&c=EmpaquetadoData&a=1&t=chofer', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            });
            
            cachedChoferes = choferes;
            const $choferSelect = $('#chofer');
            $choferSelect.empty();
            $choferSelect.append('<option value="" disabled selected>Seleccionar chofer</option>');
            $.each(choferes, function(index, chofer) {
                $choferSelect.append($('<option>', {
                    value: chofer.co_ven,
                    text: chofer.persona_des
                }));
            });
        }
        
        // Cargar zonas desde la base de datos (con cache)
        if (!cachedZonas) {
            const zonas = await $.ajax({
                url: '../admin/index.php?action=empaquetado&tipo=1&accion=2&datos=4&c=EmpaquetadoData&a=1&t=zona', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            });
            
            cachedZonas = zonas;
            const $zonaSelect = $('#zona');
            $zonaSelect.empty();
            $zonaSelect.append('<option value="" disabled selected>Seleccionar zona</option>');
            $.each(zonas, function(index, zona) {
                $zonaSelect.append($('<option>', {
                    value: zona.co_zon,
                    text: zona.zon_des
                }));
            });
        }

        // NUEVO: Cargar vehículos desde la base de datos (con cache)
        if (!cachedVehiculos) {
            const vehiculos = await $.ajax({
                url: '../admin/index.php?action=empaquetado&tipo=1&accion=2&datos=5&c=EmpaquetadoData&a=1&t=vehiculos', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            });
            
            cachedVehiculos = vehiculos;
            const $vehiculoSelect = $('#vehiculo'); // CORRECCIÓN: Usar el ID correcto
            $vehiculoSelect.empty();
            $vehiculoSelect.append('<option value="" disabled selected>Seleccionar vehículo</option>'); // CORRECCIÓN: Texto más apropiado
            $.each(vehiculos, function(index, vehiculo) { // CORRECCIÓN: Iterar sobre 'vehiculo' en lugar de 'zona'
                $vehiculoSelect.append($('<option>', {
                    value: vehiculo.co_vehiculo,
                    text: vehiculo.vehiculo_des,
                    // NUEVO: Almacenar datos adicionales en el option
                    'data-capacidad': vehiculo.capacidad || 100,
                    'data-placa': vehiculo.vehiculo_des
                }));
            });
        }
        
        // Una vez cargados los datos, verificar estado de confirmación
        cargaVerificarEstadoConfirmacion();
        
        // Ocultar indicador de carga
        $('#loadingIndicator').hide();
    } catch (error) {
        console.error('Error al cargar datos iniciales:', error);
        $('#loadingIndicator').hide();
        cargaMostrarError('Error al cargar datos iniciales');
    }
}

function cargaVerificarEstadoConfirmacion() {
    const vehiculo = $('#vehiculo').val(); // NUEVO: Añadir validación de vehículo
    const chofer = $('#chofer').val();
    const ayudante = $('#ayudante').val();
    const zona = $('#zona').val();
    const btnConfirmar = $('.btnConfirmarCarga');
    
    // Modificación: habilitar el botón solo si hay paquetes y todos los campos están completos
    if (cargaPaquetesCargados.length > 0 && vehiculo && chofer && ayudante && zona) {
        btnConfirmar.prop('disabled', false)
                 .removeClass('btn-secondary')
                 .addClass('btn-success')
                 .html('<i data-feather="check-circle"></i> Confirmar Carga');
        cargaGestionarFoco(true);
    } else {
        let mensajeBoton = 'Sin paquetes';
        if (cargaPaquetesCargados.length > 0) {
            if (!vehiculo || !chofer || !ayudante || !zona) {
                mensajeBoton = 'Datos incompletos';
            }
        }
        
        btnConfirmar.prop('disabled', true)
                 .removeClass('btn-success')
                 .addClass('btn-secondary')
                 .html(`<i data-feather="slash"></i> ${mensajeBoton}`);
        cargaGestionarFoco(false);
    }
    feather.replace();
}

 $(document).ready(function() {
    // NUEVA FUNCIONALIDAD: Deshabilitar selects al inicio
    $('#chofer, #ayudante, #zona, #vehiculo').prop('disabled', true); // NUEVO: Añadir vehículo

    cargaInicializarSistemaFoco();
    setTimeout(() => { cargaInitCustomKeyboard(); }, 1000);
    
    // Cargar datos iniciales
    cargaDatosIniciales();
    
    // Verificar estado de la carga
    $('#chofer, #ayudante, #zona, #vehiculo').on('change', cargaVerificarEstadoConfirmacion); // NUEVO: Añadir vehículo
    
    // CORRECCIÓN: El botón ahora maneja ambos estados (pausar y reanudar)
    $('#btnPausarFoco').on('click', function() {
        const $btn = $(this);
        
        // Si no está pausado, lo pausamos
        if (!cargaFocoPausadoManualmente) {
            cargaFocoPausadoManualmente = true;
            cargaFocoBloqueado = true; // Bloqueamos el sistema de restauración de foco
            
            // Habilitar selects
            $('#chofer, #ayudante, #zona, #vehiculo').prop('disabled', false); // NUEVO: Añadir vehículo
            
            // Cambiar apariencia del botón
            $btn
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i data-feather="play"></i> Reanudar');
            feather.replace();
            
            // Mostrar mensaje informativo
            Swal.fire({
                icon: 'info',
                title: 'Modo Edición Activado',
                text: 'Ahora puede seleccionar el vehículo, chofer, ayudante y zona. Haga clic en "Reanudar" para volver al modo de escaneo.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true
            });
        } 
        // Si ya está pausado, lo reanudamos
        else {
            cargaFocoPausadoManualmente = false;
            cargaFocoBloqueado = false; // Desbloqueamos el sistema de restauración de foco
            
            // Bloquear selects nuevamente
            $('#chofer, #ayudante, #zona, #vehiculo').prop('disabled', true); // NUEVO: Añadir vehículo
            
            // Resetear el botón a su estado inicial
            $btn
                .removeClass('btn-success')
                .addClass('btn-warning')
                .html('<i data-feather="pause"></i> Pausar');
            feather.replace();
            
            // Mostrar notificación de reanudación
            Swal.fire({
                icon: 'success',
                title: 'Escaneo Reanudado',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            // CORRECCIÓN: Damos foco al campo de escaneo para reactivar el autofocus inmediatamente
            $('#buscarPaqueteInput').focus();
        }
    });
    
    // Evento del botón de confirmar carga
    $('.btnConfirmarCarga').off('click').on('click', function() {
        if (!$(this).prop('disabled')) cargaConfirmarCarga();
    });
    
    // Inicializar resumen
    cargaActualizarResumenCarga();
});

// =============================================
// ESTILOS CSS PARA EL SISTEMA DE CARGA
// =============================================
const cargaEstilosCarga = `
    <style>
    /* Estilos para tablets */
    @media (max-width: 1024px) {
        .carga-custom-keyboard {
            transform: scale(1.1);
            transform-origin: bottom center;
        }
        
        .carga-keyboard-key {
            min-height: 50px !important;
            font-size: 18px !important;
        }
        
        .btn {
            min-height: 44px !important;
            font-size: 16px !important;
        }
        
        .carga-fila-paquete td {
            padding: 12px 8px !important;
        }
    }
    
    /* Indicador visual para campo de escaneo */
    #buscarPaqueteInput {
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 12px;
        font-size: 18px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    #buscarPaqueteInput:focus {
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }
    
    /* Indicador visual para mantenimiento pulsado */
    .carga-touch-hold-indicator {
        background-color: rgba(0, 123, 255, 0.1) !important;
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3) !important;
        transform: scale(1.02);
    }
    
    /* Animación de progreso para mantenimiento pulsado */
    .carga-touch-hold-indicator::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #0056b3);
        animation: cargaProgressAnimation ${cargaTouchHoldThreshold}ms linear;
        border-radius: 0 0 8px 8px;
    }
    
    @keyframes cargaProgressAnimation {
        from { width: 0%; }
        to { width: 100%; }
    }
    
    /* Estilos para enlaces de facturas */
    .carga-factura-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }
    
    .carga-factura-link:hover {
        text-decoration: underline;
    }
    
    /* Indicador de ayuda para mantenimiento pulsado */
    .carga-help-indicator {
        position: absolute;
        top: -30px;
        right: 0;
        background-color: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
        z-index: 1000;
    }
    
    .carga-search-container:hover .carga-help-indicator {
        opacity: 1;
    }
    
    /* Estilos para indicador de carga */
    #loadingIndicator {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
`;

// Agregar estilos adicionales
 $('head').append(cargaEstilosCarga);

// Agregar contenedor para campo de búsqueda con indicador de ayuda
if ($('#buscarPaqueteInput').length && !$('#buscarPaqueteInput').parent().hasClass('carga-search-container')) {
    $('#buscarPaqueteInput').wrap('<div class="carga-search-container position-relative"></div>');
    $('#buscarPaqueteInput').parent().append('<div class="carga-help-indicator">Mantén presionado para mostrar teclado</div>');
}

// Agregar indicador de carga si no existe
if (!$('#loadingIndicator').length) {
    $('body').append(`
        <div id="loadingIndicator" style="display: none;">
            <div class="spinner"></div>
        </div>
    `);
}