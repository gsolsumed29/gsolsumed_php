// Variables para los gráficos
let progresoFacturasChart = null;
let progresoEnviosChart = null;

// Cache de datos
let cachedData = {};

// Inicializar el dashboard
 $(document).ready(function() {
    // Cargar datos iniciales
    if ($('.i_dashboard').length) {
        // Establecer mes actual por defecto
        const now = new Date();
        $('#monthSelect').val(now.getMonth() + 1);
        $('#yearSelect').val(now.getFullYear());
        
        // Ajustar gráficos al cambiar el tamaño de la ventana
        $(window).resize(debounce(function() {
            if (progresoFacturasChart) progresoFacturasChart.resize();
            if (progresoEnviosChart) progresoEnviosChart.resize();
        }, 250));
        
        // Manejar cambios en los filtros (ahora controla toda la actualización)
        $('#yearSelect, #monthSelect').change(debounce(function() {
            updateDashboard();
        }, 300));

        cargarDatosIniciales();
    } else {
        // console.log("No hay elementos con la clase 'i_dashboard' en el DOM.");
    }
});

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

// Función para cargar datos iniciales
async function cargarDatosIniciales() {
    try {
        updateDashboard(); // La primera carga se maneja aquí
    } catch (error) {
        console.error('Error al cargar datos iniciales:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos iniciales. Por favor, recargue la página.');
    }
}

// Función para obtener el nombre del mes
function getMonthName(monthNumber) {
    const months = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    return months[monthNumber - 1] || 'Mes inválido';
}

function updateDashboard() {
    const año = parseInt($('#yearSelect').val());
    const mes = $('#monthSelect').val();
    
    if (isNaN(año)) {
        showError('Año seleccionado inválido');
        return;
    }
    
    if (mes !== "all" && (isNaN(mes) || parseInt(mes) < 1 || parseInt(mes) > 12)) {
        showError('Mes seleccionado inválido');
        return;
    }
    
    const periodoTexto = mes === "all" ? 
        `Período: Acumulado ${año}` : 
        `Período: ${getMonthName(parseInt(mes))} ${año}`;
    
    // Actualizar todos los períodos en las tarjetas
    $('#periodoFacturasComparacion , #periodoDespachosInternos, #periodoDespachosExternos, #periodoFacturasPorDespachar, #periodoFacturasDespachadas, #periodoFacturasAnuladas, #periodoOrdenesDespacho, #periodoEnviosDespachados, #periodoEnviosPorDespachar, #periodoEnviosAnulados').text(periodoTexto);
    
    obtenerDatosDashboard(año, mes);
}

async function obtenerDatosDashboard(año, mes) {
    const cacheKey = `${año}-${mes}`;
    
    if (cachedData[cacheKey] && (Date.now() - cachedData[cacheKey].timestamp) < 120000) {
        procesarDatosDashboard(cachedData[cacheKey].data, año, mes);
        return;
    }
    
    $('#loadingIndicator').show();
    $('.error-message').remove();
    
    try {
        // URLs de las APIs para obtener los 10 indicadores + la comparación de facturas
        const urls = [
            '../admin/index.php?action=almacen&c=VehiculoData&a=3&t=factura&opcion=2',  // Cantidad Despachos por transporte interno
            '../admin/index.php?action=almacen&c=VehiculoData&a=3&t=factura&opcion=1',  // Cantidad Despachos por transporte externo
            '../admin/index.php?action=almacen&c=VehiculoData&a=4&t=factura&opcion=2',  // Facturas por contener
            '../admin/index.php?action=almacen&c=VehiculoData&a=4&t=factura&opcion=1',  // Facturas por despachar
            '../admin/index.php?action=almacen&c=VehiculoData&a=5&t=factura',  // Facturas despachadas
            '../admin/index.php?action=almacen&c=VehiculoData&a=6&t=factura',  // Facturas anuladas
            '../admin/index.php?action=almacen&c=VehiculoData&a=7&t=factura',  // Órdenes de despacho
            '../admin/index.php?action=almacen&c=VehiculoData&a=8&t=factura',  // Envíos despachados
            '../admin/index.php?action=almacen&c=VehiculoData&a=9&t=factura',  // Envíos por despachar
            '../admin/index.php?action=almacen&c=VehiculoData&a=10&t=factura', // Envíos anulados
            // NUEVO: Endpoint para la comparación de facturas
            '../admin/index.php?action=almacen&a=2&c=VehiculoData&t=jm_despacho_vehiculo'  
        ];
        
        const params = { ano: año, mes: mes };
        
        const requests = urls.map(url => 
            $.ajax({ url, method: 'GET', data: params, dataType: 'json', timeout: 20000 })
        );
        
        const responses = await Promise.all(requests);
        console.log(responses);
        const data = {
            despachosTrasnporteInterno: responses[0],
            despachosTrasnporteExterno: responses[1],
            despachosPorVehiculosInternos: responses[2],
            despachosPorVehiculosExternos: responses[3],
            facturasDespachadas: responses[4],
            facturasAnuladas: responses[5],
            ordenesDespacho: responses[6],
            enviosDespachados: responses[7],
            enviosPorDespachar: responses[8],
            enviosAnulados: responses[9],
            // NUEVO: Datos para la tarjeta de comparación
            comparacionFacturas: responses[10]
        };
        
        cachedData[cacheKey] = { data, timestamp: Date.now() };
        procesarDatosDashboard(data, año, mes);
        
    } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos. Por favor, intente nuevamente.');
    }
}

// NUEVA: Función para verificar si hay datos válidos
function tieneDatosValidos(data) {
    // Verificar si hay datos en al menos una de las fuentes principales
    const tieneDespachosInternos = data.despachosTrasnporteInterno && 
                                  data.despachosTrasnporteInterno.length > 0 && 
                                  data.despachosTrasnporteInterno[0].dato1 > 0;
    
    const tieneDespachosExternos = data.despachosTrasnporteExterno && 
                                  data.despachosTrasnporteExterno.length > 0 && 
                                  data.despachosTrasnporteExterno[0].dato1 > 0 && 
                                  data.despachosTrasnporteExterno[0].dato2 > 0;
    
    const tieneFacturasDespachadas = data.facturasDespachadas && 
                                    data.facturasDespachadas.length > 0 && 
                                    data.facturasDespachadas[0].dato1 > 0;
    
    const tieneOrdenesDespacho = data.ordenesDespacho && 
                                data.ordenesDespacho.length > 0 && 
                                data.ordenesDespacho[0].dato1 > 0;
    
    const tieneComparacion = data.comparacionFacturas && 
                            Array.isArray(data.comparacionFacturas) && 
                            data.comparacionFacturas.length > 0;
    
    const tieneDetallesVehiculos = data.despachosPorVehiculosInternos && 
                                  Array.isArray(data.despachosPorVehiculosInternos) && 
                                  data.despachosPorVehiculosInternos.length > 0;
    
    return tieneDespachosInternos || tieneDespachosExternos || 
           tieneFacturasDespachadas || tieneOrdenesDespacho || 
           tieneComparacion || tieneDetallesVehiculos;
}

// NUEVA: Función para mostrar mensaje de sin datos
function mostrarMensajeSinDatos(mostrar = true) {
    const dashboardContent = $('.content-body .row');
    
    if (mostrar) {
        // Ocultar todas las tarjetas y gráficos
        dashboardContent.find('.col-xl-4, .col-xl-12').hide();
        
        // Mostrar mensaje de sin datos si no existe
        if (!$('#noDatosMessage').length) {
            const noDatosHtml = `
                <div id="noDatosMessage" class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay datos disponibles</h4>
                            <p class="text-muted">No se encontraron registros para el período seleccionado.</p>
                            <button class="btn btn-primary mt-2" onclick="window.location.reload()">
                                <i class="fas fa-sync-alt me-2"></i>Recargar datos
                            </button>
                        </div>
                    </div>
                </div>
            `;
            dashboardContent.append(noDatosHtml);
        }
    } else {
        // Mostrar todas las tarjetas y gráficos
        dashboardContent.find('.col-xl-4, .col-xl-12').show();
        
        // Ocultar mensaje de sin datos si existe
        $('#noDatosMessage').remove();
    }
}

function procesarDatosDashboard(data, año, mes) {
    console.log(data);
    $('#loadingIndicator').hide();
    
    try {
        // NUEVO: Verificar si hay datos válidos
        if (!tieneDatosValidos(data)) {
            mostrarMensajeSinDatos(true);
            return;
        } else {
            mostrarMensajeSinDatos(false);
        }
        
        const despachosTrasnporteInterno = data.despachosTrasnporteInterno[0];
        const despachosTrasnporteExterno = data.despachosTrasnporteExterno[0];
        
        // --- Actualizar las 10 tarjetas principales ---
        $('#despachos-transporte-interno').text('N° de viajes: '+despachosTrasnporteInterno.dato1.toLocaleString() || '0');
        $('#despachos-bulto-interno').text('N° de bultos: '+despachosTrasnporteInterno.dato2.toLocaleString() || '0');  
        $('#despachos-transporte-externo').text('N° de viajes: '+despachosTrasnporteExterno.dato1.toLocaleString() || '0'); 
        $('#despachos-bulto-externo').text('N° de bultos: '+despachosTrasnporteExterno.dato2.toLocaleString() || '0'); 

        $('#facturas-anuladas').text(data.facturasAnuladas[0]?.dato1?.toLocaleString() || '0');
        $('#ordenes-despacho').text(data.ordenesDespacho[0]?.dato1?.toLocaleString() || '0');
        $('#envios-despachados').text(data.enviosDespachados[0]?.dato1?.toLocaleString() || '0');
        $('#envios-por-despachar').text(data.enviosPorDespachar[0]?.dato1?.toLocaleString() || '0');
        $('#envios-anulados').text(data.enviosAnulados[0]?.dato1?.toLocaleString() || '0');

        // --- NUEVO: Procesar y actualizar la tarjeta de comparación de facturas ---
        if (data.comparacionFacturas && Array.isArray(data.comparacionFacturas) && data.comparacionFacturas.length > 0) {
            const comparacionData = data.comparacionFacturas[0];
            if (comparacionData.hasOwnProperty('emitidas') && comparacionData.hasOwnProperty('verificadas')) {
                const emitidas = parseInt(comparacionData.emitidas, 10) || 0;
                const verificadas = parseInt(comparacionData.verificadas, 10) || 0;
                actualizarTarjetaComparacionFacturas(emitidas, verificadas);
            } else {
                console.error("Propiedades 'emitidas' o 'verificadas' faltantes en los datos de comparación.");
                actualizarTarjetaComparacionFacturas(0, 0); // Valores por defecto
            }
        } else {
            console.error("La respuesta de comparación de facturas no tiene el formato esperado.");
            actualizarTarjetaComparacionFacturas(0, 0); // Valores por defecto
        }
        
        // --- Actualizar tabla y gráficos ---
        actualizarTablaDetalles(data.despachosPorVehiculosInternos);
         // NUEVA: Llamada para actualizar la tabla de transporte externo
        actualizarTablaDetallesExterno(data.despachosPorVehiculosExternos);
        updateCharts(data);
    } catch (error) {
        console.error('Error al procesar datos:', error);
        showError('Error al procesar los datos recibidos');
    }
}

// ===================================================================
// FUNCIÓN PARA ACTUALIZAR LA TARJETA DE COMPARACIÓN (sin cambios)
// ===================================================================
function actualizarTarjetaComparacionFacturas(emitidas, verificadas) {
    const config = {
        thresholds: { positive: 80, neutral: 50 },
        estado: {
            positive: { class: 'positive', icono: 'check-circle', texto: 'Excelente' },
            neutral: { class: 'neutral', icono: 'alert-circle', texto: 'Aceptable' },
            negative: { class: 'negative', icono: 'x-circle', texto: 'Baja' },
            perfect: { class: 'positive', icono: 'award', texto: '¡Completa!' },
            empty: { class: 'neutral', icono: 'minus', texto: 'No hay facturas' }
        }
    };

    const $elements = {
        emitidas: $('#facturas-emitidas'),
        verificadas: $('#facturas-verificadas'),
        resultado: $('#resultado-comparacion'),
        icono: $('#resultado-comparacion .comparison-icon'),
        porcentaje: $('#resultado-comparacion .comparison-percentage'),
        texto: $('#resultado-comparacion .comparison-text')
    };

    $elements.emitidas.text(emitidas);
    $elements.verificadas.text(verificadas);

    let estadoActual = 'empty';
    let porcentaje = 0;

    if (emitidas > 0) {
        porcentaje = ((verificadas * 100) / emitidas);
        if (porcentaje === 100) estadoActual = 'perfect';
        else if (porcentaje >= config.thresholds.positive) estadoActual = 'positive';
        else if (porcentaje >= config.thresholds.neutral) estadoActual = 'neutral';
        else estadoActual = 'negative';
    }

    const estadoInfo = config.estado[estadoActual];
    $elements.resultado.removeClass('positive negative neutral').addClass(estadoInfo.class);
    
    // Usar Font Awesome como fallback
    if (typeof feather !== 'undefined') {
        $elements.icono.html(feather.icons[estadoInfo.icono].toSvg());
    } else {
        const iconos = {
            'check-circle': 'fas fa-check-circle', 'alert-circle': 'fas fa-exclamation-circle',
            'x-circle': 'fas fa-times-circle', 'award': 'fas fa-award', 'minus': 'fas fa-minus'
        };
        $elements.icono.html(`<i class="${iconos[estadoInfo.icono]}"></i>`);
    }
    
    $elements.porcentaje.text(`${porcentaje.toFixed(2)}%`);
    $elements.texto.text(estadoInfo.texto);
}

// --- El resto de las funciones (actualizarTablaDetalles, updateCharts, etc.) permanecen igual ---
// ... (aquí irían las funciones updateCharts, actualizarTablaDetalles, showError, etc. del código anterior)

function actualizarTablaDetalles(data) {
    console.log(data);
    let tablaHTML = '';
    const tablaDetallesElement = $('#tablaDetalles');

       // NUEVO: Seleccionar la tarjeta completa que contiene la tabla
    const cardContainer = $('#cardTablaInterna');
    
    try {
        // NUEVO: Condición mejorada para verificar si hay datos VÁLIDOS
        // Comprueba si el array está vacío O si TODOS los elementos tienen valores en cero.
        const noHayDatosValidos = !data || 
                                  !Array.isArray(data) || 
                                  data.length === 0 || 
                                  data.every(item => 
                                      parseInt(item.dato1) === 0 && 
                                      parseInt(item.dato2) === 0 && 
                                      parseInt(item.dato3) === 0
                                  );

     if (noHayDatosValidos) {
            // CAMBIO: En lugar de ocultar, mostramos un mensaje en la tabla
            tablaHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-2"></i>
                        No existen viajes realizados en este período.
                    </td>
                </tr>
            `;
            tablaDetallesElement.html(tablaHTML);
            return; // Salimos de la función
        }
        // NUEVO: Si hay datos, nos aseguramos de que la tarjeta sea visible
        cardContainer.show();
        
        // --- El resto de tu lógica para calcular y mostrar la tabla permanece igual ---
        // Calcular totales
        const totalVehiculos = data.length;
        const totalViajes = data.reduce((sum, item) => sum + (parseInt(item.dato2) || 0), 0);
        const totalBultos = data.reduce((sum, item) => sum + (parseInt(item.dato3) || 0), 0);
        
        // Generar filas de la tabla
        data.forEach((item, index) => {
            const vehiculoInfo = item.dato1 || 'Vehículo sin identificar';
            const viajes = parseInt(item.dato2) || 0;
            const bultos = parseInt(item.dato3) || 0;
            
            // Calcular porcentajes individuales
            const porcentajeViajes = totalViajes > 0 ? (viajes / totalViajes * 100) : 0;
            const porcentajeBultos = totalBultos > 0 ? (bultos / totalBultos * 100) : 0;
            
            // Calcular el porcentaje de contribución (promedio de ambos porcentajes)
            const contribucion = ((porcentajeViajes + porcentajeBultos) / 2).toFixed(2);
            
            // Determinar el color de la insignia según la contribución
            let badgeClass = 'bg-secondary';
            if (contribucion > 15) {
                badgeClass = 'bg-success';
            } else if (contribucion > 7) {
                badgeClass = 'bg-warning';
            }
            
            tablaHTML += `
                <tr>
                    <td>${vehiculoInfo}</td>
                    <td>${viajes.toLocaleString()} <span class="text-muted">(${porcentajeViajes.toFixed(2)}%)</span></td>
                    <td>${bultos.toLocaleString()} <span class="text-muted">(${porcentajeBultos.toFixed(2)}%)</span></td>
                    <td><span class="badge ${badgeClass}">${contribucion}%</span></td>
                </tr>
            `;
        });
        
        // Añadir fila de totales
        tablaHTML += `
            <tr class="table-active fw-bold">
                <td>TOTAL (${totalVehiculos} vehículos)</td>
                <td>${totalViajes.toLocaleString()} <span class="text-muted">(100.00%)</span></td>
                <td>${totalBultos.toLocaleString()} <span class="text-muted">(100.00%)</span></td>
                <td><span class="badge bg-primary">100.00%</span></td>
            </tr>
        `;
    } catch (error) {
        console.error('Error al actualizar la tabla de detalles:', error);
       // También ocultamos la tarjeta si hay un error al procesar
        cardContainer.hide(); 
        tablaDetallesElement.html('<tr><td colspan="4">Error al cargar los datos. Intente de nuevo.</td></tr>');
    }

    tablaDetallesElement.html(tablaHTML);
}

// ===================================================================
// FUNCIÓN PARA ACTUALIZAR LA TABLA DE DETALLES (TRANSPORTE EXTERNO)
// ===================================================================
function actualizarTablaDetallesExterno(data) {
    console.log("Datos para transporte externo:", data);
    let tablaHTML = '';
    const tablaDetallesElement = $('#tablaDetallesExterno'); // Apuntamos al nuevo ID

       // NUEVO: Seleccionar la tarjeta completa
    const cardContainer = $('#cardTablaExterna');

    
    try {
       // NUEVO: Misma condición de validación
        const noHayDatosValidos = !data || 
                                  !Array.isArray(data) || 
                                  data.length === 0 || 
                                  data.every(item => 
                                      parseInt(item.dato1) === 0 && 
                                      parseInt(item.dato2) === 0 && 
                                      parseInt(item.dato3) === 0
                                  );
        if (noHayDatosValidos) {
            // CAMBIO: Mostramos el mensaje de "sin datos"
            tablaHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-2"></i>
                        No existen viajes realizados en este período.
                    </td>
                </tr>
            `;
            tablaDetallesElement.html(tablaHTML);
            return;
        }
        // NUEVO: Asegurarse de que la tarjeta sea visible
        cardContainer.show();

        // --- El resto de tu lógica para calcular y mostrar la tabla ---
        
        // Calcular totales
        const totalVehiculos = data.length;
        const totalViajes = data.reduce((sum, item) => sum + (parseInt(item.dato2) || 0), 0);
        const totalBultos = data.reduce((sum, item) => sum + (parseInt(item.dato3) || 0), 0);
        
        // Generar filas de la tabla
        data.forEach((item, index) => {
            const vehiculoInfo = item.dato1 || 'Vehículo sin identificar';
            const viajes = parseInt(item.dato2) || 0;
            const bultos = parseInt(item.dato3) || 0;
            
            // Calcular porcentajes individuales
            const porcentajeViajes = totalViajes > 0 ? (viajes / totalViajes * 100) : 0;
            const porcentajeBultos = totalBultos > 0 ? (bultos / totalBultos * 100) : 0;
            
            // Calcular el porcentaje de contribución (promedio de ambos porcentajes)
            const contribucion = ((porcentajeViajes + porcentajeBultos) / 2).toFixed(2);
            
            // Determinar el color de la insignia según la contribución
            let badgeClass = 'bg-secondary';
            if (contribucion > 15) {
                badgeClass = 'bg-success';
            } else if (contribucion > 7) {
                badgeClass = 'bg-warning';
            }
            
            tablaHTML += `
                <tr>
                    <td>${vehiculoInfo}</td>
                    <td>${viajes.toLocaleString()} <span class="text-muted">(${porcentajeViajes.toFixed(2)}%)</span></td>
                    <td>${bultos.toLocaleString()} <span class="text-muted">(${porcentajeBultos.toFixed(2)}%)</span></td>
                    <td><span class="badge ${badgeClass}">${contribucion}%</span></td>
                </tr>
            `;
        });
        
        // Añadir fila de totales
        tablaHTML += `
            <tr class="table-active fw-bold">
                <td>TOTAL (${totalVehiculos} vehículos)</td>
                <td>${totalViajes.toLocaleString()} <span class="text-muted">(100.00%)</span></td>
                <td>${totalBultos.toLocaleString()} <span class="text-muted">(100.00%)</span></td>
                <td><span class="badge bg-primary">100.00%</span></td>
            </tr>
        `;
    } catch (error) {
        console.error('Error al actualizar la tabla de detalles (externo):', error);
        cardContainer.hide();
        tablaDetallesElement.html('<tr><td colspan="4">Error al cargar los datos. Intente de nuevo.</td></tr>');
    }

    tablaDetallesElement.html(tablaHTML);
}

// Función para actualizar los gráficos
function updateCharts(data) {
    // Datos para gráfico de progreso de facturas
    const facturasData = {
        recibidas: data.facturasRecibidas[0] ? data.facturasRecibidas[0].dato1 || 0 : 0,
        chequeadas: data.facturasChequeadas[0] ? data.facturasChequeadas[0].dato1 || 0 : 0,
        porContener: data.facturasPorContener[0] ? data.facturasPorContener[0].dato1 || 0 : 0,
        porDespachar: data.facturasPorDespachar[0] ? data.facturasPorDespachar[0].dato1 || 0 : 0,
        despachadas: data.facturasDespachadas[0] ? data.facturasDespachadas[0].dato1 || 0 : 0,
        anuladas: data.facturasAnuladas[0] ? data.facturasAnuladas[0].dato1 || 0 : 0
    };
    
    // Datos para gráfico de progreso de envíos
    const enviosData = {
        ordenes: data.ordenesDespacho[0] ? data.ordenesDespacho[0].dato1 || 0 : 0,
        despachados: data.enviosDespachados[0] ? data.enviosDespachados[0].dato1 || 0 : 0,
        porDespachar: data.enviosPorDespachar[0] ? data.enviosPorDespachar[0].dato1 || 0 : 0,
        anulados: data.enviosAnulados[0] ? data.enviosAnulados[0].dato1 || 0 : 0
    };
    
    // Crear gráfico de progreso de facturas
    crearGraficoProgresoFacturas(facturasData);
    
    // Crear gráfico de progreso de envíos
    crearGraficoProgresoEnvios(enviosData);
}

function crearGraficoProgresoFacturas(data) {
    const ctx = document.getElementById('progresoFacturasChart');
    
    // Destruir gráfico existente si hay uno
    if (progresoFacturasChart) {
        progresoFacturasChart.destroy();
    }
    
    progresoFacturasChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Chequeadas', 'Despachadas', 'Por Contener', 'Por Despachar', 'Anuladas'],
            datasets: [{
                data: [
                    data.chequeadas,
                    data.despachadas,
                    data.porContener,
                    data.porDespachar,
                    data.anuladas
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',  // Verde para chequeadas
                    'rgba(23, 162, 184, 0.7)', // Azul para despachadas
                    'rgba(255, 193, 7, 0.7)',  // Amarillo para por contener
                    'rgba(23, 162, 184, 0.7)', // Azul para por despachar
                    'rgba(220, 53, 69, 0.7)'   // Rojo para anuladas
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(23, 162, 184, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(23, 162, 184, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: `Total de Facturas Recibidas: ${data.recibidas.toLocaleString()}`
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(2) : 0;
                            return `${context.label}: ${context.raw.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

function crearGraficoProgresoEnvios(data) {
    const ctx = document.getElementById('progresoEnviosChart');
    
    // Destruir gráfico existente si hay uno
    if (progresoEnviosChart) {
        progresoEnviosChart.destroy();
    }
    
    progresoEnviosChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Despachados', 'Por Despachar', 'Anulados'],
            datasets: [{
                data: [
                    data.despachados,
                    data.porDespachar,
                    data.anulados
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',  // Verde para despachados
                    'rgba(255, 193, 7, 0.7)',  // Amarillo para por despachar
                    'rgba(220, 53, 69, 0.7)'   // Rojo para anulados
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: `Total de Órdenes de Despacho: ${data.ordenes.toLocaleString()}`
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(2) : 0;
                            return `${context.label}: ${context.raw.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Función para mostrar errores
function showError(message) {
    $('.error-message').remove();
    const errorHtml = `
        <div class="alert alert-danger error-message" role="alert">
            <i class="fas fa-exclamation-triangle"></i> ${message}
        </div>
    `;
    $('#dashboardContent').prepend(errorHtml);
}

// Función para limpiar cache
function clearCache() {
    cachedData = {};
    console.log('Cache limpiado');
}
window.clearDashboardCache = clearCache;
window.getDashboardCache = () => cachedData;