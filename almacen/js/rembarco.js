// =============================================
// SISTEMA DE DETALLES DE EMBARQUE
// =============================================

// Variables globales para el sistema de detalles de embarque
let embarqueActual = null;
let lotesEmbarque = [];
let facturasEmbarque = [];
let rutaEmbarque = [];

/**
 * Inicializa el sistema de detalles de embarque
 * Se llama cuando se carga la vista de detalles de un embarque
 */
function cargaInicializarDetallesEmbarque() {
    // Verificar si estamos en la vista de detalles de embarque
    if ($('#idEmbarque').length) {
        const idEmbarque = $('#idEmbarque').text().trim();
        
        if (idEmbarque) {
            // Cargar datos del embarque
            cargaDatosEmbarque(idEmbarque);
            
            // Configurar eventos de botones
            $('.btnActualizarEstado').on('click', function() {
                const nuevoEstado = $(this).data('estado');
                cargaActualizarEstadoEmbarque(idEmbarque, nuevoEstado);
            });
            
            // Configurar botones de acciones para lotes
            $(document).on('click', '.btnVerDetallesLote', function() {
                const idLote = $(this).data('id-lote');
                cargaVerDetallesLote(idLote);
            });
            
            // Configurar botones de acciones para facturas
            $(document).on('click', '.btnVerDetalleFactura_rembarco', function() {
                const idFactura = $(this).data('id-factura');
                cargaVerDetallesFactura_rembarco(idFactura);
            });
            
            $(document).on('click', '.btnGenerarPdfFactura', function() {
                const idFactura = $(this).data('id-factura');
                cargaGenerarPdfFactura(idFactura);
            });
        }
    }
}

/**
 * Carga todos los datos de un embarque específico
 * @param {string} idEmbarque - ID del embarque a cargar
 */
async function cargaDatosEmbarque(idEmbarque) {
    try {
        // Mostrar indicador de carga
        $('#loadingIndicator').show();
        
        // Cargar información general del embarque
        await cargaCargarInfoGeneralEmbarque(idEmbarque);
        
        // Cargar lotes del embarque
        await cargaCargarLotesEmbarque(idEmbarque);
        
        // Cargar facturas asociadas
        await cargaCargarFacturasEmbarque(idEmbarque);
        
        // Cargar estadísticas
        await cargaCargarEstadisticasEmbarque(idEmbarque);
        
        // Ocultar indicador de carga
        $('#loadingIndicator').hide();
        
    } catch (error) {
        console.error('Error al cargar datos del embarque:', error);
        $('#loadingIndicator').hide();
        cargaMostrarError('Error al cargar los datos del embarque: ' + error.message);
    }
}

/**
 * Muestra un mensaje de error en la interfaz
 * @param {string} mensaje - Mensaje de error a mostrar
 */
function cargaMostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje,
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#1750a7'
    });
}

/**
 * Carga las estadísticas del embarque
 * @param {string} idEmbarque - ID del embarque
 */
async function cargaCargarEstadisticasEmbarque(idEmbarque) {
    const params = new URLSearchParams({
        action: 'embarco',
        tipo: '1',
        accion: '2',
        datos: '6',
        c: 'VehiculoData',
        t: 'jm_despacho_carga',
        filtro: idEmbarque
    });
    
    const url = `../admin/index.php?${params.toString()}`;
    
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const estadisticas = await response.json();
        
        // Actualizar estadísticas en la vista
        $('#estadisticaTotalLotes').text(estadisticas.total_lotes || 0);
        $('#estadisticaTotalPaquetes').text(estadisticas.total_paquetes || 0);
        $('#estadisticaLotesEntregados').text(estadisticas.lotes_entregados || 0);
        
    } catch (error) {
        console.error('Error al cargar estadísticas del embarque:', error);
        $('#estadisticaTotalLotes').text('0');
        $('#estadisticaTotalPaquetes').text('0');
        $('#estadisticaLotesEntregados').text('0');
    }
}

/**
 * Carga la información general del embarque
 * @param {string} idEmbarque - ID del embarque
 */
async function cargaCargarInfoGeneralEmbarque(idEmbarque) {
    const params = new URLSearchParams({
        action: 'embarco',
        tipo: '1',
        accion: '2',
        datos: '4',
        c: 'VehiculoData',
        t: 'jm_despacho_carga',
        filtro: idEmbarque
    });
    
    const url = `../admin/index.php?${params.toString()}`;
    
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const embarque = await response.json();
        
        if (embarque && Object.keys(embarque).length > 0) {
            embarqueActual = embarque;
            
            // Actualizar información general en la vista
            $('#embarqueId').text(embarque.codigo || 'N/A');
            $('#embarqueFecha').text(embarque.fecha_carga || 'N/A');
            $('#embarqueEstatus').html(cargaFormatearEstado(embarque.estatus || 'desconocido'));
            $('#embarqueZona').text(embarque.zona_nombre || 'N/A');
            $('#embarqueVehiculo').text(embarque.vehiculo_nombre || 'N/A');
            $('#embarqueChofer').text(embarque.chofer_nombre || 'N/A');
            $('#embarqueAyudante').text(embarque.ayudante_nombre || 'N/A');
            
            // Actualizar botones de estado según el estado actual
            cargaActualizarBotonesEstado(embarque.estatus || 'desconocido');
            
        } else {
            throw new Error('No se encontró información del embarque');
        }
        
    } catch (error) {
        console.error('Error al cargar información general del embarque:', error);
        throw error;
    }
}

/**
 * Carga los lotes asociados a un embarque
 * @param {string} idEmbarque - ID del embarque
 */
async function cargaCargarLotesEmbarque(idEmbarque) {
    const params = new URLSearchParams({
        action: 'embarco',
        tipo: '1',
        accion: '2',
        datos: '5',
        c: 'VehiculoData',
        t: 'jm_despacho_lotes',
        filtro: idEmbarque
    });
    
    const url = `../admin/index.php?${params.toString()}`;
    
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const lotes = await response.json();
        
        // Limpiar tabla de lotes
        $('#tablaLotesEmbarque tbody').empty();
        
        if (Array.isArray(lotes) && lotes.length > 0) {
            lotesEmbarque = lotes;
            
            // Agregar cada lote a la tabla
            lotes.forEach(lote => {
                // Determinar si el lote está entregado
                const esEntregado = lote.estatus == '2';
                const filaClass = esEntregado ? 'table-success' : '';
                
                // Determinar qué botón mostrar según el estado
                let botonAccion = '';
                if (esEntregado) {
                    botonAccion = `
                        <button class="btn btn-sm btn-outline-primary btnVerDetallesLote" data-id-lote="${lote.id}">
                            <i data-feather="eye"></i>
                        </button>
                    `;
                } else {
                    botonAccion = `
                        <button class="btn btn-sm btn-outline-primary btnVerDetallesLote" data-id-lote="${lote.id}">
                            <i data-feather="eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning btnEntregarLote" data-id-lote="${lote.id}" data-lote-id="${lote.loteID}">
                            <i data-feather="truck"></i>
                        </button>
                    `;
                }
                
                const fila = `
                    <tr class="${filaClass}">
                        <td>${lote.id || 'N/A'}</td>
                        <td>${lote.loteID || 'N/A'}</td>
                        <td>${lote.descripcion || 'Sin descripción'}</td>
                        <td>${lote.cantidad_paquetes || 0}</td>
                        <td>${cargaFormatearEstado(lote.estatus || 'desconocido', lote.fecha_entrega)}</td>
                        <td>
                            ${botonAccion}
                        </td>
                    </tr>
                `;
                $('#tablaLotesEmbarque tbody').append(fila);
            });

            // Configurar evento para botones de entregar lote
            $('.btnEntregarLote').on('click', function() {
                const idLote = $(this).data('id-lote');
                const loteID = $(this).data('lote-id');
                cargaEntregarLote(idLote, loteID);
            });
            
            // Reemplazar iconos de feather
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
        } else {
            console.warn('No se encontraron lotes para el embarque');
            $('#tablaLotesEmbarque tbody').append('<tr><td colspan="6" class="text-center">No se encontraron lotes para este embarque</td></tr>');
        }
        
    } catch (error) {
        console.error('Error al cargar lotes del embarque:', error);
        $('#tablaLotesEmbarque tbody').append('<tr><td colspan="6" class="text-center text-danger">Error al cargar los lotes</td></tr>');
        throw error;
    }
}

/**
 * Marca un lote como entregado
 * @param {string} idLote - ID del lote
 * @param {string} loteID - Código del lote
 */
async function cargaEntregarLote(idLote, loteID) {
    try {
        // Mostrar confirmación
        const result = await Swal.fire({
            title: '¿Confirmar entrega?',
            html: `¿Está seguro de que desea marcar el lote <strong>${loteID}</strong> como entregado?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#033c71ff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, entregar',
            cancelButtonText: 'Cancelar'
        });
        
        if (result.isConfirmed) {
            // Mostrar indicador de carga
            Swal.fire({
                title: 'Procesando...',
                html: 'Marcando el lote como entregado',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
             
            // Enviar solicitud para marcar el lote como entregado
            const response = await fetch('../admin/index.php?action=despacho&tipo=1&accion=1&datos=4&c=VehiculoData&a=1&t=jm_despacho_lotes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    loteId: loteID + '-1',
                    notas: 'Entregado desde el sistema de embarques',
                    confirmado: 1
                })
            });
            
            if (!response.ok) {
                throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                // Cerrar el modal de carga
                Swal.close();
                
                // Mostrar notificación de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Lote entregado',
                    text: `El lote ${loteID} ha sido marcado como entregado correctamente`,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Recargar los datos del embarque para actualizar la vista
                const idEmbarque = $('#idEmbarque').text().trim();
                await cargaDatosEmbarque(idEmbarque);
                
            } else {
                throw new Error(result.message || 'Error al marcar el lote como entregado');
            }
        }
        
    } catch (error) {
        console.error('Error al entregar lote:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo marcar el lote como entregado: ' + error.message,
            confirmButtonText: 'Entendido'
        });
    }
}

/**
 * Carga las facturas asociadas a un embarque con sus totales
 * @param {string} idEmbarque - ID del embarque
 */

async function cargaCargarFacturasEmbarque(idEmbarque) {
    const params = new URLSearchParams({
        action: 'embarco',
        tipo: '1',
        accion: '2',
        datos: '9',
        c: 'VehiculoData',
        t: 'jm_despacho_facturas',
        filtro: idEmbarque
    });
    
    const url = `../admin/index.php?${params.toString()}`;
    
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const facturas = await response.json();
        
        // Limpiar tabla de facturas
        $('#tablaFacturasEmbarque tbody').empty();
        
        if (Array.isArray(facturas) && facturas.length > 0) {
            facturasEmbarque = facturas;
            
            // Variable para acumular el total general
            let totalGeneral = 0;
            
            // Agregar cada factura a la tabla
            facturas.forEach(factura => {
                const totalNeto = parseFloat(factura.total_neto) || 0;
                totalGeneral += totalNeto;
                
                const totalFormateado = '$' + totalNeto.toLocaleString('es-VE', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                
                const fila = `
                    <tr>
                        <td>${factura.numero_factura || 'N/A'}</td>
                        <td>${factura.cliente || 'N/A'}</td>
                        <td class="text-end">${totalFormateado}</td>
                        <td>${factura.fecha_emision || 'N/A'}</td>
                        <td>${cargaFormatearEstadoFactura(factura.estado || '0')}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary btnVerDetalleFactura_rembarco" 
                                    data-id-factura="${factura.numero_factura}">
                                <i data-feather="eye"></i> Ver Detalle
                            </button>
                        </td>
                    </tr>
                `;
                $('#tablaFacturasEmbarque tbody').append(fila);
            });
            
            // Actualizar total general
            const totalFormateadoGeneral = '$' + totalGeneral.toLocaleString('es-VE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('#totalFacturasEmbarque').text(totalFormateadoGeneral);
            
            // Reemplazar iconos de feather
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
        } else {
            $('#tablaFacturasEmbarque tbody').append(
                '<tr><td colspan="6" class="text-center">No se encontraron facturas para este embarque</td></tr>'
            );
            $('#totalFacturasEmbarque').text('$0.00');
        }
        
    } catch (error) {
        console.error('Error al cargar facturas del embarque:', error);
        $('#tablaFacturasEmbarque tbody').append(
            '<tr><td colspan="6" class="text-center text-danger">Error al cargar las facturas</td></tr>'
        );
        $('#totalFacturasEmbarque').text('$0.00');
    }
}

/**
 * Muestra los detalles de una factura
 * @param {string} idFactura - ID/Número de factura
 */

async function cargaVerDetallesFactura_rembarco(idFactura) {
    try {
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Cargando...',
            html: 'Obteniendo detalles de la factura <strong>' + idFactura + '</strong>',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Consultar los renglones de la factura
        const params = new URLSearchParams({
            action: 'embarco',
            tipo: '1',
            accion: '2',
            datos: '10',  // Nuevo código para renglones de factura
            c: 'VehiculoData',
            t: 'reng_fac',
            filtro: idFactura
        });
        
        const url = `../admin/index.php?${params.toString()}`;
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const renglones = await response.json();
        
        // Construir tabla de artículos
        let tablaHTML = '';
        
        if (Array.isArray(renglones) && renglones.length > 0) {
            let totalFactura = 0;
            
            tablaHTML = `
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th class="text-end">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Neto</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            renglones.forEach(renglon => {
                const precio = parseFloat(renglon.prec_vta) || 0;
                const cantidad = parseFloat(renglon.total_art) || 0;
                const neto = parseFloat(renglon.reng_neto) || (precio * cantidad);
                totalFactura += neto;
                
                tablaHTML += `
                    <tr>
                        <td>${renglon.co_art || 'N/A'}</td>
                        <td>${renglon.art_des || renglon.des_art || 'Sin descripción'}</td>
                        <td class="text-end">${cantidad.toFixed(2)}</td>
                        <td class="text-end">${precio.toLocaleString('es-VE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td class="text-end">${neto.toLocaleString('es-VE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    </tr>
                `;
            });
            
            tablaHTML += `
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th class="text-end">${totalFactura.toLocaleString('es-VE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;
        } else {
            tablaHTML = '<p class="text-center">No se encontraron artículos para esta factura.</p>';
        }
        
        // Mostrar modal con los detalles
        Swal.fire({
            title: 'Factura: ' + idFactura,
            html: tablaHTML,
            width: '1200px',
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'swal-wide'
            }
        });
        
    } catch (error) {
        console.error('Error al cargar detalles de la factura:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los detalles de la factura: ' + error.message,
            confirmButtonText: 'Cerrar'
        });
    }
}

/**
 * Carga la ruta asociada a un embarque
 * @param {string} idEmbarque - ID del embarque
 */
async function cargaCargarRutaEmbarque(idEmbarque) {
    const params = new URLSearchParams({
        action: 'embarco',
        tipo: '2',
        accion: '4',
        datos: '1',
        c: 'EmbarqueData',
        t: 'jm_despacho_ruta',
        filtro: idEmbarque
    });
    
    const url = `../admin/index.php?${params.toString()}`;
    
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const ruta = await response.json();
        
        if (Array.isArray(ruta) && ruta.length > 0) {
            rutaEmbarque = ruta;
            
            // Limpiar lista de ruta
            $('#listaRutaEmbarque').empty();
            
            // Agregar cada punto de la ruta
            ruta.forEach((punto, index) => {
                const esPrimero = index === 0;
                const esUltimo = index === ruta.length - 1;
                
                let badgeClass = 'bg-info';
                let badgeText = 'Entrega';
                
                if (esPrimero) {
                    badgeClass = 'bg-primary';
                    badgeText = 'Salida';
                } else if (esUltimo) {
                    badgeClass = 'bg-success';
                    badgeText = 'Regreso';
                }
                
                const item = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${punto.nombre || 'Punto ' + (index + 1)}:</strong> ${punto.direccion || 'N/A'}<br>
                            <small class="text-muted">${punto.descripcion || ''}</small>
                        </div>
                        <span class="badge ${badgeClass} rounded-pill">${badgeText}</span>
                    </li>
                `;
                $('#listaRutaEmbarque').append(item);
            });
            
        } else {
            console.warn('No se encontró ruta para el embarque');
            $('#listaRutaEmbarque').append('<li class="list-group-item text-center">No se encontró ruta para este embarque</li>');
        }
        
    } catch (error) {
        console.error('Error al cargar ruta del embarque:', error);
        $('#listaRutaEmbarque').append('<li class="list-group-item text-center text-danger">Error al cargar la ruta</li>');
        throw error;
    }
}

/**
 * Formatea el estado de un embarque o lote en un badge HTML
 * @param {string} estado - Estado a formatear
 * @param {string} fechaEntrega - Fecha de entrega (opcional)
 * @returns {string} HTML con el badge formateado
 */
function cargaFormatearEstado(estado, fechaEntrega) {
    let badgeClass = 'bg-secondary';
    let estadoText = estado || 'Desconocido';
    
    switch (estado.toLowerCase()) {
        case '00':
        case 'preparado':
            badgeClass = 'bg-info';
            estadoText = 'Preparado';
            break;
        case '1':
        case 'en_ruta':
        case 'en tránsito':
            badgeClass = 'bg-warning';
            estadoText = 'En Ruta';
            break;
        case '2':
        case 'entregado':
        case 'completado':
            badgeClass = 'bg-success';
            estadoText = 'Entregado' + (fechaEntrega && fechaEntrega != '0' ? '<br><small>Fecha: ' + fechaEntrega + '</small>' : '');
            break;
        case '3':
        case 'cancelado':
            badgeClass = 'bg-danger';
            estadoText = 'Cancelado';
            break;
    }
    
    return `<span class="badge ${badgeClass} status-badge">${estadoText}</span>`;
}

/**
 * Formatea el estado de una factura en un badge HTML
 * @param {string} estado - Estado a formatear
 * @returns {string} HTML con el badge formateado
 */
function cargaFormatearEstadoFactura(estado) {
    let badgeClass = 'bg-secondary';
    let estadoText = estado || 'Desconocido';
    
    // Convertir a string para comparación
    const estadoStr = String(estado).toLowerCase();
    
    switch (estadoStr) {
        case '1':
        case 'pagada':
            badgeClass = 'bg-success';
            estadoText = 'Pagada';
            break;
        case '0':
        case 'pendiente':
            badgeClass = 'bg-warning';
            estadoText = 'Pendiente';
            break;
        case '2':
        case 'en proceso':
        case 'procesando':
            badgeClass = 'bg-info';
            estadoText = 'En Proceso';
            break;
        case '3':
        case 'vencida':
            badgeClass = 'bg-danger';
            estadoText = 'Vencida';
            break;
    }
    
    return `<span class="badge ${badgeClass} status-badge">${estadoText}</span>`;
}

/**
 * Actualiza los botones de estado según el estado actual del embarque
 * @param {string} estadoActual - Estado actual del embarque
 */
function cargaActualizarBotonesEstado(estadoActual) {
    // Ocultar todos los botones de estado
    $('.btnActualizarEstado').hide();
    
    // Mostrar solo los botones relevantes según el estado actual
    switch (estadoActual) {
        case '1':
        case 'preparado':
            $('.btnActualizarEstado[data-estado="2"]').show();
            break;
        case '2':
        case 'en_ruta':
        case 'en tránsito':
            $('.btnActualizarEstado[data-estado="3"]').show();
            break;
    }
}

/**
 * Actualiza el estado de un embarque
 * @param {string} idEmbarque - ID del embarque
 * @param {string} nuevoEstado - Nuevo estado a establecer
 */
async function cargaActualizarEstadoEmbarque(idEmbarque, nuevoEstado) {
    try {
        const response = await fetch('../admin/index.php?action=embarco&tipo=2&accion=5&datos=1', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: idEmbarque,
                estado: nuevoEstado
            })
        });
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Actualizar estado en la vista
            $('#embarqueEstatus').html(cargaFormatearEstado(nuevoEstado));
            
            // Actualizar botones de estado
            cargaActualizarBotonesEstado(nuevoEstado);
            
            // Mostrar notificación de éxito
            Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                text: `El estado del embarque ha sido actualizado correctamente`,
                timer: 2000,
                showConfirmButton: false
            });
            
            // Actualizar el estado en el objeto del embarque
            if (embarqueActual) {
                embarqueActual.estatus = nuevoEstado;
            }
            
        } else {
            throw new Error(result.message || 'Error al actualizar el estado');
        }
        
    } catch (error) {
        console.error('Error al actualizar estado del embarque:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar el estado del embarque: ' + error.message,
            confirmButtonText: 'Entendido'
        });
    }
}

/**
 * Muestra los detalles de un lote específico
 * @param {string} idLote - ID del lote a mostrar
 */
async function cargaVerDetallesLote(idLote) {
    console.log('Cargando detalles del lote ID:', idLote);
    try {
        const response = await fetch(`../admin/index.php?action=embarco&tipo=1&accion=2&datos=7&c=VehiculoData&t=jm_despacho_lotes&filtro=${idLote}`);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        const lote = await response.json();
        
        if (lote && Object.keys(lote).length > 0) {
            // Mostrar detalles en un modal
            Swal.fire({
                title: 'Detalles del Lote',
                html: `
                    <div class="text-left">
                        <p><strong>ID:</strong> ${lote.id || 'N/A'}</p>
                        <p><strong>Código:</strong> ${lote.loteID || 'N/A'}</p>
                        <p><strong>Descripción:</strong> ${lote.descripcion || 'N/A'}</p>
                        <p><strong>Cantidad de Paquetes:</strong> ${lote.cantidad_paquetes || 0}</p>
                        <p><strong>Estado:</strong> ${cargaFormatearEstado(lote.estatus || 'desconocido')}</p>
                        <p><strong>Fecha de embarque:</strong> ${lote.fecha_carga || 'N/A'}</p>
                        <p><strong>Facturas:</strong> ${lote.observaciones || 'N/A'}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#1750a7'
            });
        } else {
            throw new Error('No se encontraron detalles del lote');
        }
        
    } catch (error) {
        console.error('Error al cargar detalles del lote:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los detalles del lote: ' + error.message,
            confirmButtonText: 'Entendido'
        });
    }
}

/**
 * Genera un PDF para una factura específica
 * @param {string} idFactura - ID/Número de la factura
 */
function cargaGenerarPdfFactura(idFactura) {
    // Abrir el PDF en una nueva ventana
    window.open(`../admin/index.php?action=facturas&a=pdf&id=${idFactura}`, '_blank');
}

/**
 * Exporta los datos del embarque a un archivo Excel
 */
function cargaExportarEmbarque() {
    if (!embarqueActual) {
        cargaMostrarError('No hay datos de embarque para exportar');
        return;
    }
    
    try {
        // Crear un objeto con todos los datos del embarque
        const datosExportacion = {
            embarque: embarqueActual,
            lotes: lotesEmbarque,
            facturas: facturasEmbarque,
            ruta: rutaEmbarque
        };
        
        // Enviar solicitud de exportación al servidor
        fetch('../admin/index.php?action=embarco&tipo=2&accion=7&datos=1', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosExportacion)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
            }
            return response.blob();
        })
        .then(blob => {
            // Crear una URL para el blob
            const url = window.URL.createObjectURL(blob);
            
            // Crear un enlace temporal para descargar el archivo
            const a = document.createElement('a');
            a.href = url;
            a.download = `embarque_${embarqueActual.codigo}_${new Date().toISOString().slice(0,10)}.xlsx`;
            document.body.appendChild(a);
            a.click();
            
            // Limpiar
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            // Mostrar notificación de éxito
            Swal.fire({
                icon: 'success',
                title: 'Exportación completada',
                text: 'El embarque ha sido exportado a Excel correctamente',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error('Error al exportar embarque:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de exportación',
                text: 'No se pudo exportar el embarque: ' + error.message,
                confirmButtonText: 'Entendido'
            });
        });
        
    } catch (error) {
        console.error('Error al preparar exportación:', error);
        cargaMostrarError('Error al preparar la exportación');
    }
}

// =============================================
// INICIALIZACIÓN AL CARGAR EL DOCUMENTO
// =============================================

$(document).ready(function() {
    // Inicializar sistema de detalles de embarque si estamos en esa vista
    cargaInicializarDetallesEmbarque();
    
    // Botón para imprimir detalles del embarque
    $('#imprimirDetallesEmbarco').on('click', function() {
        const embarqueId = $(this).data('embarque-id');
        window.location.href = '../admin/index.php?view=reporte&tipo=7&id=' + embarqueId;
    });

    // Configurar botones de acciones para facturas
    $(document).on('click', '.btnVerDetalleFactura_rembarco', function() {
        const idFactura = $(this).data('id-factura');
        cargaVerDetallesFactura_rembarco(idFactura);
    });
});