function obtenerColorPorPorcentaje(porcentaje) {
    // Convertir a número por si viene como string (por el toFixed)
    porcentaje = Number(porcentaje);
    
    if (porcentaje <= 33.33) {
        return window.colors.solid.danger;
    } else if (porcentaje <= 66.66) {
        return window.colors.solid.warning;
    } else if (porcentaje <= 90.00) {
        return window.colors.solid.info;
    } else {
        // Para porcentajes > 90.00
        return window.colors.solid.success;
    }
}

// Función segura para convertir a número
function safeParseFloat(value, defaultValue = 0) {
    if (value === null || value === undefined || value === '' || value === 'NaN') {
        return defaultValue;
    }
    
    const num = parseFloat(value);
    return isNaN(num) ? defaultValue : num;
}

// Función para formatear montos monetarios
function formatoMoneda(valor) {
    const num = safeParseFloat(valor);
    return '$ ' + num.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Función mejorada para validar respuestas del servidor
function validarRespuesta(data) {
    if (!data || !Array.isArray(data) || data.length === 0 || !data[0]) {
        console.error('Respuesta inválida del servidor');
        return false;
    }
    
    const respuesta = data[0];
    // Verificamos que al menos tenga alguna propiedad con datos
    const tieneDatos = Object.values(respuesta).some(val => 
        val !== null && val !== undefined && val !== '' && val !== 'NaN'
    );
    
    return tieneDatos;
}

/* CARGAR GRAFICOS DE TORTA */ 
function cargarIndicadorVentasxPeriodoGrafico(monto, meta) {
    // Validación adicional para evitar división por cero
    const montoNum = safeParseFloat(monto, 0);
    const metaNum = safeParseFloat(meta, 0);
    const porcentaje = metaNum > 0 ? ((montoNum / metaNum) * 100) : 0;
    const porcentajeFormateado = safeParseFloat(porcentaje.toFixed(2), 0);
    
    let color = obtenerColorPorPorcentaje(porcentajeFormateado);
    $('#porcentaje_alcanzado').html('% ' + porcentajeFormateado);
    renderRadialChart('#ventasxperiodo', porcentajeFormateado, color);
}

function cargarIndicadorClientesFacturadosGrafico(monto, meta) {
    const montoNum = safeParseFloat(monto, 0);
    const metaNum = safeParseFloat(meta, 0);
    const porcentaje = metaNum > 0 ? ((montoNum / metaNum) * 100) : 0;
    const porcentajeFormateado = safeParseFloat(porcentaje.toFixed(2), 0);
    
    let color = obtenerColorPorPorcentaje(porcentajeFormateado);
    $('#porcentaje_alcanzado_clientes').html('% ' + porcentajeFormateado);
    renderRadialChart('#clientesFacturadosGrafico', porcentajeFormateado, color);
}

function cargarIndicadorCobranzasMesGrafico(monto, meta) {
    const montoNum = safeParseFloat(monto, 0);
    const metaNum = safeParseFloat(meta, 0);
    const porcentaje = metaNum > 0 ? ((montoNum / metaNum) * 100) : 0;
    const porcentajeFormateado = safeParseFloat(porcentaje.toFixed(2), 0);
    
    let color = obtenerColorPorPorcentaje(porcentajeFormateado);
    $('#porcentaje_cobranzas_realizadas').html('% ' + porcentajeFormateado);
    renderRadialChart('#cobranzasMesGrafico', porcentajeFormateado, color);
}

function cargarIndicadorClientesNuevosGrafico(monto, meta) {
    const montoNum = safeParseFloat(monto, 0);
    const metaNum = safeParseFloat(meta, 0);
    const porcentaje = metaNum > 0 ? ((montoNum / metaNum) * 100) : 0;
    const porcentajeFormateado = safeParseFloat(porcentaje.toFixed(2), 0);
    
    let color = obtenerColorPorPorcentaje(porcentajeFormateado);
    $('#porcentaje_alcanzado_clientes_nuevos').html('% ' + porcentajeFormateado);
    renderRadialChart('#clientesNuevosGrafico', porcentajeFormateado, color);
}

// Función común para renderizar todos los gráficos radiales con la misma configuración
function renderRadialChart(selector, porcentaje, color) {
    const chartOptions = {
        chart: {
            height: 50,
            width: 50,
            type: 'radialBar'
        },
        grid: {
            show: false,
            padding: {
                left: -15,
                right: -10,
                top: -12,
                bottom: -15
            }
        },
        colors: [color],
        series: [porcentaje],
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '22%'
                },
                track: {
                    background: '#EBEBEB'
                },
                dataLabels: {
                    showOn: 'always',
                    name: {
                        show: false
                    },
                    value: {
                        show: false
                    }
                }
            }
        },
        stroke: {
            lineCap: 'round'
        }
    };

    const chartElement = document.querySelector(selector);
    if (chartElement) {
        // Si ya existe un gráfico, lo destruimos antes de crear uno nuevo
        if (chartElement._apexChart) {
            chartElement._apexChart.destroy();
        }
        const chart = new ApexCharts(chartElement, chartOptions);
        chart.render();
        // Guardamos una referencia al gráfico en el elemento DOM
        chartElement._apexChart = chart;
    }
}








// Función para obtener color según el porcentaje (adaptada para zonas)
function obtenerColorPorcentajeZona(porcentaje) {
    porcentaje = Number(porcentaje);
    
    if (porcentaje <= 33.33) {
        return 'danger';
    } else if (porcentaje <= 66.66) {
        return 'warning';
    } else if (porcentaje <= 90.00) {
        return 'info';
    } else {
        return 'success';
    }
}

// Función para obtener color según el porcentaje (adaptada para zonas)
function obtenerColorPorcentajeRotacion(porcentaje) {
    porcentaje = Number(porcentaje);
    
    if (porcentaje <= 33.33) {
        return 'danger';
    } else if (porcentaje <= 66.66) {
        return 'warning';
    } else if (porcentaje <= 90.00) {
        return 'info';
    } else {
        return 'success';
    }
}

// Función para cargar el rendimiento por zonas
function cargarIndicadorRendimientoZonas($co_ven, $co_zona, $finicio, $ffinal) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php',
        data: {
            action: 'indicadores',
            c: 'FacturaData',
            a: 5, // Nuevo método para rendimiento por zonas
            co_ven: $co_ven,
            co_zona: $co_zona,
            finicio: $finicio,
            ffinal: $ffinal
        }
    })
    .done(function(data) {
        console.log('Datos rendimiento por zonas:', data);
        
        if (!data || !Array.isArray(data) || data.length === 0) {
            mostrarMensajeSinDatosZonas();
            return;
        }

        let html = '';
        let totalVentas = data.reduce((sum, zona) => sum + safeParseFloat(zona.monto_facturado, 0), 0);
        
        data.forEach((zona, index) => {
            const montoFacturado = safeParseFloat(zona.monto_facturado, 0);
            const ticketsFactura = zona.tickets_factura || 0;
            const ticketsDevolucion = zona.tickets_devolucion || 0;
            const clientesFactura = zona.clientes_factura || 0;
            
            // Calcular porcentaje respecto al total
            const porcentaje = totalVentas > 0 ? ((montoFacturado / totalVentas) * 100) : 0;
            const porcentajeFormateado = porcentaje.toFixed(1);
            const colorClass = obtenerColorPorcentajeZona(porcentaje);
            
            // Generar iniciales para el ícono
            const iniciales = zona.zon_des 
                ? zona.zon_des.split(' ').map(p => p[0]).join('').substring(0, 2).toUpperCase()
                : 'ZN';
            
            html += `
                <div class="browser-states mb-2">
                    <div class="d-flex flex-row">
                        <div class="rounded me-1 bg-${colorClass} d-flex align-items-center justify-content-center" style="width:30px; height:30px; min-width:30px;">
                            <span class="text-white fw-bold small">${iniciales}</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${zona.zon_des || 'Zona ' + zona.co_zon}</h6>
                            <small class="text-muted">
                                ${formatoMoneda(montoFacturado)} | 
                                <i data-feather="file-text" class="font-small-2"></i> ${ticketsFactura} 
                                ${ticketsDevolucion > 0 ? `<span class="text-danger">(-${ticketsDevolucion} devoluciones)</span>` : ''}
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-1">
                        <div class="fw-bold text-body-heading me-2" style="min-width: 50px;">${porcentajeFormateado}%</div>
                        <div class="progress flex-grow-1" style="height: 8px;">
                            <div class="progress-bar bg-${colorClass}" 
                                 role="progressbar" 
                                 style="width: ${porcentajeFormateado}%;" 
                                 aria-valuenow="${porcentajeFormateado}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#zonas-rendimiento-container').html(html);
        
        // Reinicializar Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al cargar rendimiento por zonas:', textStatus, errorThrown);
        mostrarMensajeSinDatosZonas();
    });
}


function cargarIndicadorRendimientoRotacion($co_ven, $co_zona, $finicio, $ffinal) {
    // Definimos los LÍMITES MÁXIMOS permitidos por cada rotación
    const LIMITES_MAXIMOS = {
        'ALTA': 20,      // Máximo 20%
        'NORMAL': 30,    // Máximo 30%
        'PREMIUM': 50    // Máximo 50%
    };

    $.ajax({
        type: "GET",
        url: '../admin/index.php',
        data: {
            action: 'indicadores',
            c: 'FacturaData',
            a: 6,
            co_ven: $co_ven,
            co_zona: $co_zona,
            finicio: $finicio,
            ffinal: $ffinal
        }
    })
    .done(function(data) {
        if (!data || !Array.isArray(data) || data.length === 0) {
            mostrarMensajeSinDatosRotacion();
            return;
        }

        let html = '';
        let totalVentas = data.reduce((sum, item) => sum + safeParseFloat(item.total_art, 0), 0);
        
       data.forEach((item) => {
            const totalArt = safeParseFloat(item.total_art, 0);
            const desProc = (item.des_proc || 'SIN CATEGORIA').trim().toUpperCase();
            
            const porcentaje = totalVentas > 0 ? ((totalArt / totalVentas) * 100) : 0;
            const porcentajeFormateado = porcentaje.toFixed(1);

            // DETERMINAR EL LÍMITE SEGÚN LA CATEGORÍA (Búsqueda robusta)
            let limiteMax = 0;
            if (desProc.includes('ALTA')) limiteMax = LIMITES_MAXIMOS['ALTA'];
            else if (desProc.includes('NORMAL')) limiteMax = LIMITES_MAXIMOS['NORMAL'];
            else if (desProc.includes('PREMIU')) limiteMax = LIMITES_MAXIMOS['PREMIUM'];

            const seExcedio = porcentaje > limiteMax;
            const colorClass = seExcedio ? 'danger' : 'success'; 
            const iconoMeta = seExcedio ? 'alert-circle' : 'check-circle';
            const badgeText = seExcedio ? `Exceso (+${(porcentaje - limiteMax).toFixed(1)}%)` : 'Dentro del límite';

            const iniciales = desProc.split(' ').filter(w => w.length > 0).map(w => w[0]).join('').substring(0, 2);
            
            html += `
                <div class="browser-states mb-2 p-1 ${seExcedio ? 'bg-light-danger rounded' : ''}" style="transition: all 0.3s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-50">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-${colorClass} p-50 me-1">
                                <span class="avatar-content fw-bold text-white">${iniciales}</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bolder">${desProc}</h6>
                                <small class="text-primary fw-bold">${totalArt} Unds.</small> 
                                <span class="text-muted mx-25">|</span>
                                <small class="text-muted">Límite: ${limiteMax}%</small>
                            </div>
                        </div>
                        <div class="text-end" style="min-width: 100px;">
                            <div class="h5 mb-0 fw-bolder text-${colorClass}">${porcentajeFormateado}%</div>
                            <small class="fw-bold text-${colorClass} d-flex align-items-center justify-content-end">
                                <i data-feather="${iconoMeta}" class="me-25" style="width:14px; height:14px;"></i>
                                ${badgeText}
                            </small>
                        </div>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar progress-bar-striped ${seExcedio ? 'progress-bar-animated' : ''} bg-${colorClass}" 
                                role="progressbar" 
                                style="width: ${porcentaje > 100 ? 100 : porcentaje}%;" 
                                aria-valuenow="${porcentaje}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            `;
});
        
        $('#rotacion-rendimiento-container').html(html);
        if (typeof feather !== 'undefined') feather.replace();
    })
    .fail(function() {
        mostrarMensajeSinDatosRotacion();
    });
}
function mostrarMensajeSinDatosZonas() {
    $('#zonas-rendimiento-container').html(`
        <div class="text-center text-muted py-3">
            <i data-feather="info" class="mb-1"></i>
            <p class="mb-0">No hay datos disponibles para el período seleccionado</p>
        </div>
    `);
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function mostrarMensajeSinDatosRotacion() {
    $('#rotacion-rendimiento-container').html(`
        <div class="text-center text-muted py-3">
            <i data-feather="info" class="mb-1"></i>
            <p class="mb-0">No hay datos disponibles para el período seleccionado</p>
        </div>
    `);
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

// Integrar con tu sistema existente
$(document).ready(function() {
    // Escuchar cambios en el selector de período
    $('#selectorPeriodoZonas').on('change', function() {
        actualizarIndicadorZonas();
    });
     $('#selectorPeriodoRotacion').on('change', function() {
        actualizarIndicadorZonas();
    });
});

function actualizarIndicadorZonas() {
    // Obtener valores actuales (ajusta según tu sistema)
    const co_ven = $('#co_ven').val() || '';
    const co_zona = $('#co_zona').val() || '';
    const finicio = $('#finicio').val() || obtenerFechaInicioMes();
    const ffinal = $('#ffinal').val() || obtenerFechaFinMes();
    
    // Mostrar loading
    $('#zonas-rendimiento-container').html(`
        <div class="text-center text-muted py-3">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            Actualizando datos...
        </div>
    `);
    
    cargarIndicadorRendimientoZonas(co_ven, co_zona, finicio, ffinal);
}

// Funciones auxiliares para fechas
function obtenerFechaInicioMes() {
    const fecha = new Date();
    return `${fecha.getFullYear()}-${String(fecha.getMonth() + 1).padStart(2, '0')}-01`;
}

function obtenerFechaFinMes() {
    const fecha = new Date();
    const ultimoDia = new Date(fecha.getFullYear(), fecha.getMonth() + 1, 0).getDate();
    return `${fecha.getFullYear()}-${String(fecha.getMonth() + 1).padStart(2, '0')}-${ultimoDia}`;
}












/* FUNCIONES PARA CARGAR LOS INDICADORES */  
function cargarIndicadorVentasxPeriodo($co_ven, $co_zona, $finicio, $ffinal, $indicador) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php',
        data: {
            action: 'indicadores',
            c: 'FacturaData',
            a: 1,
            indicador: $indicador,
            co_ven: $co_ven,
            co_zona: $co_zona,
            t: 'factura',
            finicio: $finicio,
            ffinal: $ffinal
        }
    })
    .done(function(data) {
        //console.log('Datos ventas por periodo:', data);
        
        // Validar la respuesta del servidor
        if (!validarRespuesta(data)) {
            console.error('La respuesta del servidor no es válida');
            mostrarValoresPorDefectoVentas();
            return;
        }

        const respuesta = data[0];
        
        // Usar encadenamiento opcional y valores por defecto
        const montoFacturado = safeParseFloat(respuesta?.dato1, 0);
        const numTickets = respuesta?.dato2 || '0';
        const numClientes = respuesta?.dato3 || '0';
        const meta = safeParseFloat(respuesta?.dato4, 0);
        const montoFacturadoText = formatoMoneda(respuesta?.dato1 || 0);
//console.log(respuesta?.dato1);
        // Actualizar la UI
        $('.monto_facturado').html(montoFacturadoText);
        $('#numero_tickets').html(' ' + numTickets);
        $('#numero_clientes').html(' ' + numClientes);
        
        cargarIndicadorVentasxPeriodoGrafico(montoFacturado, meta);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al cargar ventas por periodo:', textStatus, errorThrown);
        mostrarValoresPorDefectoVentas();
    });
}

function mostrarValoresPorDefectoVentas() {
    $('.monto_facturado').html('$ 0.00');
    $('#numero_tickets').html(' 0');
    $('#numero_clientes').html(' 0');
    cargarIndicadorVentasxPeriodoGrafico(0, 0);
}


function cargarIndicadorClientesFacturados($co_ven, $co_zona, $finicio, $ffinal, $indicador) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php',
        data: {
            action: 'indicadores',
            c: 'FacturaData',
            a: 2,
            indicador: $indicador,
            co_ven: $co_ven,
            co_zona: $co_zona,
            t: 'factura',
            finicio: $finicio,
            ffinal: $ffinal
        }
    })
    .done(function(data) {
        //console.log('Datos clientes facturados:', data);
        
        if (!validarRespuesta(data)) {
            mostrarValoresPorDefectoClientes();
            return;
        }

        const respuesta = data[0];
        const clientesActivados = safeParseFloat(respuesta?.dato1, 0);
        const meta = safeParseFloat(respuesta?.dato2, 0);

        $('#clientes_facturados').html(clientesActivados);
        cargarIndicadorClientesFacturadosGrafico(clientesActivados, meta);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al cargar clientes facturados:', textStatus, errorThrown);
        mostrarValoresPorDefectoClientes();
    });
}

function mostrarValoresPorDefectoClientes() {
    $('#clientes_facturados').html('0');
    cargarIndicadorClientesFacturadosGrafico(0, 0);
}


function cargarIndicadorCobranzasMes($co_ven, $co_zona, $finicio, $ffinal, $indicador) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php',
        data: {
            action: 'indicadores',
            c: 'FacturaData',
            a: 3,
            indicador: $indicador,
            co_ven: $co_ven,
            co_zona: $co_zona,
            t: 'factura',
            finicio: $finicio,
            ffinal: $ffinal
        }
    })
    .done(function(data) {
        //console.log('Datos cobranzas mes:', data);
        
        if (!validarRespuesta(data)) {
            mostrarValoresPorDefectoCobranzas();
            return;
        }

        const respuesta = data[0];
        const cobranzasMes = safeParseFloat(respuesta?.dato1, 0);
        const cobranzasMesText = formatoMoneda(respuesta?.dato3 || 0);
        const meta = safeParseFloat(respuesta?.dato2, 0);

        $('#cobranzas_mes').html(cobranzasMesText);
        cargarIndicadorCobranzasMesGrafico(cobranzasMes, meta);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al cargar cobranzas:', textStatus, errorThrown);
        mostrarValoresPorDefectoCobranzas();
    });
}

function mostrarValoresPorDefectoCobranzas() {
    $('#cobranzas_mes').html('$ 0.00');
    cargarIndicadorCobranzasMesGrafico(0, 0);
}


function cargarIndicadorClientesNuevos($co_ven, $co_zona, $finicio, $ffinal, $indicador) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php',
        data: {
            action: 'indicadores',
            c: 'FacturaData',
            a: 4,
            indicador: $indicador,
            co_ven: $co_ven,
            co_zona: $co_zona,
            t: 'factura',
            finicio: $finicio,
            ffinal: $ffinal
        }
    })
    .done(function(data) {
        //console.log('Datos clientes nuevos:', data);
        
        if (!validarRespuesta(data)) {
            mostrarValoresPorDefectoClientesNuevos();
            return;
        }

        const respuesta = data[0];
        const clientesNuevos = safeParseFloat(respuesta?.dato1, 0);
        const meta = safeParseFloat(respuesta?.dato2, 0);

        $('#clientes_nuevos').html(clientesNuevos);
        cargarIndicadorClientesNuevosGrafico(clientesNuevos, meta);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al cargar clientes nuevos:', textStatus, errorThrown);
        mostrarValoresPorDefectoClientesNuevos();
    });
}

function mostrarValoresPorDefectoClientesNuevos() {
    $('#clientes_nuevos').html('0');
    cargarIndicadorClientesNuevosGrafico(0, 0);
}