// Variables para los gráficos
let facturacionCobranzasChart = null;
let topProductosChart = null;
let topProductosChartBialy = null;

// Cache de datos
let cachedVendedores = null;
let cachedData = {};

// NUEVA: Variable global para el cálculo implícito
let cachedCalculoImplicito = null;

// Inicializar el dashboard
 $(document).ready(function() {
    // Cargar datos iniciales
    if ($('.i_dashboard').length) {
        cargarDatosIniciales();
    } else {
        console.log("No hay elementos con la clase 'i_dashboard' en el DOM.");
    }
    
    // Establecer mes actual por defecto
    const now = new Date();
    $('#monthSelect').val(now.getMonth() + 1);
    $('#yearSelect').val(now.getFullYear());
    
    // Ajustar gráficos al cambiar el tamaño de la ventana
    $(window).resize(debounce(function() {
        if (facturacionCobranzasChart) facturacionCobranzasChart.resize();
        if (topProductosChart) topProductosChart.resize();
        if (topProductosChartBialy) topProductosChartBialy.resize();
    }, 250));
    
    // Manejar cambios en los filtros
    $('#yearSelect, #monthSelect, #vendedorSelect').change(debounce(function() {
        updateDashboard();
    }, 300));
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

// Función para cargar datos iniciales desde la base de datos
async function cargarDatosIniciales() {
    try {
        // Preparamos las dos llamadas AJAX: una para vendedores y otra para el cálculo implícito.
        // Usamos Promise.all para ejecutarlas en paralelo y esperar a que ambas terminen.
        
        // 1. Llamada para los vendedores (solo si no están en cache)
        const vendedoresPromise = !cachedVendedores ? 
            $.ajax({
                url: '../admin/index.php?action=vendedores&tipo=1&accion=1&datos=1&c=VendedorData&a=1&t=vendedor', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }) : 
            Promise.resolve(cachedVendedores); // Si ya están en cache, resolvemos la promesa inmediatamente

        // 2. Llamada para el cálculo implícito (solo si no está en cache)
        const calculoPromise = cachedCalculoImplicito === null ? 
            $.ajax({
                // IMPORTANTE: Verifica que esta URL sea la correcta para tu endpoint global
                url: '../admin/index.php?action=gerenciales&tipo=1&accion=1&datos=1&c=GerenciaData&a=9&t=jm_gerencia_data', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }) :
            Promise.resolve([{ dato1: cachedCalculoImplicito }]); // Resolvemos con el valor cacheado

        // Esperamos a que ambas llamadas se completen
        const [vendedores, calculoData] = await Promise.all([vendedoresPromise, calculoPromise]);

        // --- Procesamos la respuesta de VENDEDORES ---
        if (!cachedVendedores) {
            cachedVendedores = vendedores;
            const $vendedorSelect = $('#vendedorSelect');
            $vendedorSelect.empty();
            $vendedorSelect.append('<option value="all">TODOS</option>');
            $vendedorSelect.append('<option value="gventas">GRUPO VENTAS</option>');
           // $vendedorSelect.append('<option value="aventas">ASESORES DE VENTAS</option>');
            $.each(vendedores, function(index, vendedor) {
                $vendedorSelect.append($('<option>', {
                    value: vendedor.co_ven,
                    text: vendedor.ven_des
                }));
            });
        }

        // --- Procesamos la respuesta del CÁLCULO IMPLÍCITO ---
      if (cachedCalculoImplicito === null) {
                const valor = calculoData && calculoData[0] ? calculoData[0].dato1 : 0;
                cachedCalculoImplicito = valor;
                
                // Versión compacta que realiza la misma operación en una sola línea.
                $('#calculoImplicito').text((valor.toString().split('.')[1] || '00') + '%');
            }
        
        // Una vez cargados los datos iniciales, actualizamos el dashboard por primera vez
        updateDashboard();
        
    } catch (error) {
        console.error('Error al cargar datos iniciales:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos iniciales. Por favor, recargue la página.');
    }
}

// Función para formatear currency
function formatCurrency(amount) {
    if (amount === null || amount === undefined) {
        return '$0.00';
    }
    
    const num = typeof amount === 'number' ? amount : parseFloat(amount) || 0;
    
    return new Intl.NumberFormat('en-US', { 
        style: 'currency', 
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2 
    }).format(num);
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
    const mes = parseInt($('#monthSelect').val());
    const vendedorId = $('#vendedorSelect').val();
    
    // Validar inputs
    if (isNaN(año) || isNaN(mes) || mes < 1 || mes > 12) {
        showError('Período seleccionado inválido');
        return;
    }
    
    // Actualizar textos de período
    $('#periodoFacturado').text(`Período: ${getMonthName(mes)} ${año}`);
    $('#periodoCobranzas').text(`Período: ${getMonthName(mes)} ${año}`);
    $('#periodoClientes').text(`Período: ${getMonthName(mes)} ${año}`);
    $('#periodoClientesNuevos').text(`Período: ${getMonthName(mes)} ${año}`);
    
    // Obtener datos desde la base de datos
    obtenerDatosDashboard(año, mes, vendedorId);
}

async function obtenerDatosDashboard(año, mes, vendedorId) {
    const cacheKey = `${año}-${mes}-${vendedorId}`;
    
    // Verificar si los datos están en cache (válido por 2 minutos)
    if (cachedData[cacheKey] && (Date.now() - cachedData[cacheKey].timestamp) < 120000) {
        procesarDatosDashboard(cachedData[cacheKey].data, año, mes, vendedorId);
        return;
    }
    
    $('#loadingIndicator').show();
    $('.error-message').remove();
    
    try {
        // URLs de las APIs
        const urls = [
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=1&t=factura',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=2&t=factura',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=3&t=factura',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=5&t=factura',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=6&t=factura',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=7&t=factura'
        ];
        
        // Parámetros comunes
        const params = { ano: año, mes: mes, vendedorId: vendedorId };
        
        // Realizar llamadas en paralelo con Promise.all
        const requests = urls.map(url => 
            $.ajax({
                url: url,
                method: 'GET',
                data: params,
                dataType: 'json',
                timeout: 20000 // 20 segundos timeout
            })
        );
        
        const responses = await Promise.all(requests);
        
        const data = {
            facturacion: responses[0],
            cobranzas: responses[1],
            productos: responses[2],
            clientesActivos: responses[3],
            clientesNuevos: responses[4],
            productosBialy: responses[5]
        };
        
        // Guardar en cache con timestamp
        cachedData[cacheKey] = {
            data: data,
            timestamp: Date.now()
        };
        
        // Procesar datos
        procesarDatosDashboard(data, año, mes, vendedorId);
        
    } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos. Por favor, intente nuevamente.');
    }
}

// =======================================================================
// REFACTORING CLAVE 1: Lógica de procesamiento de datos simplificada
// =======================================================================
function procesarDatosDashboard(data, año, mes, vendedorId) {
    console.log(data);
    $('#loadingIndicator').hide();
    
    // Validación mejorada de los datos
    if (!data.facturacion || !data.cobranzas ||
        !data.clientesActivos || !data.clientesActivos[0] ||
        !data.clientesNuevos || !data.clientesNuevos[0]) {
        showError('Datos incompletos recibidos del servidor');
        return;
    }
    
    try {
        let totalFacturacion = 0;
        let totalCobranzas = 0;

        if (vendedorId === 'all') {
            // Caso: "TODOS". Sumamos los totales de todos los vendedores.
            totalFacturacion = data.facturacion.reduce((sum, item) => sum + item.dato1, 0);
            totalCobranzas = data.cobranzas.reduce((sum, item) => sum + item.dato1, 0);
        } else if (vendedorId === 'gventas' || vendedorId === 'aventas') {
            // Caso: GRUPO VENTAS o ASESORES DE VENTAS
            // Sumamos todos los registros que vienen para este grupo
            totalFacturacion = data.facturacion.reduce((sum, item) => sum + item.dato1, 0);
            totalCobranzas = data.cobranzas.reduce((sum, item) => sum + item.dato1, 0);
        } else {
            // Caso: Vendedor específico
            const factRecord = data.facturacion[0] || {};
            const cobRecord = data.cobranzas[0] || {};
            
            totalFacturacion = factRecord.dato1 || 0;
            totalCobranzas = cobRecord.dato1 || 0;
        }
        
        // Actualizar tarjetas de resumen con los valores calculados
        $('#montoFacturado').text(formatCurrency(totalFacturacion));
        $('#cobranzasMes').text(formatCurrency(totalCobranzas));
        $('#clientesActivos').text(data.clientesActivos[0].dato1 || '0');
        $('#clientesNuevos').text(data.clientesNuevos[0].dato1 || '0');
        
        // Actualizar tabla de vendedores
        actualizarTablaVendedores(data, vendedorId, año, mes);
        
        // Actualizar gráficos
        updateCharts(data, año, mes);
    } catch (error) {
        console.error('Error al procesar datos:', error);
        showError('Error al procesar los datos recibidos');
    }
}

// =======================================================================
// REFACTORING CLAVE 2: Función de tabla de vendedores simplificada
// =======================================================================
async function actualizarTablaVendedores(data, vendedorId, año, mes) {
    let tablaHTML = '';
    const tablaVendedoresElement = $('#tablaVendedores');
    tablaVendedoresElement.html('<tr><td colspan="4">Cargando...</td></tr>');

    try {
        if (vendedorId === 'all') {
            // Caso: "TODOS". Usamos directamente los datos que vienen del endpoint principal
            data.facturacion.forEach(vendedor => {
                const datosFila = obtenerDatosFilaVendedor(
                    { ven_des: vendedor.dato3 },
                    vendedor.dato1,
                    vendedor.dato4
                );
                tablaHTML += crearFilaHTML(datosFila);
            });
        } else if (vendedorId === 'gventas' || vendedorId === 'aventas') {
            // Caso: GRUPO VENTAS o ASESORES DE VENTAS
            // Sumamos todos los registros para este grupo
            const totalFacturacion = data.facturacion.reduce((sum, item) => sum + item.dato1, 0);
            const totalCobranzas = data.cobranzas.reduce((sum, item) => sum + item.dato1, 0);
            
            const vendedorName = vendedorId === 'gventas' ? 'GRUPO VENTAS' : 'ASESORES DE VENTAS';
            const datosFila = obtenerDatosFilaVendedor(
                { ven_des: vendedorName },
                totalFacturacion,
                totalCobranzas
            );
            tablaHTML += crearFilaHTML(datosFila);
        } else {
            // Caso: Vendedor específico
            const factRecord = data.facturacion[0] || {};
            const cobRecord = data.cobranzas[0] || {};
            
            const vendedor = cachedVendedores ? cachedVendedores.find(v => v.co_ven == vendedorId) : null;
            const vendedorName = vendedor ? vendedor.ven_des : 'Vendedor Desconocido';
            
            const datosFila = obtenerDatosFilaVendedor(
                { ven_des: vendedorName },
                factRecord.dato1,
                cobRecord.dato1
            );
            tablaHTML += crearFilaHTML(datosFila);
        }
    } catch (error) {
        console.error('Error al actualizar la tabla de vendedores:', error);
        tablaHTML = '<tr><td colspan="4">Error al cargar los datos. Intente de nuevo.</td></tr>';
    }

    tablaVendedoresElement.html(tablaHTML);
}

// =======================================================================
// FUNCIONES ELIMINADAS (Ya no son necesarias)
// =======================================================================
// Las funciones `obtenerDatosGventas` y `obtenerDatosAventas` se han eliminado
// porque su lógica estaba contenida en el `switch` de `actualizarTablaVendedores`,
// el cual ha sido simplificado. Ahora, el backend se encarga de proveer los datos
// correctos para 'gventas' y 'aventas' a través de la misma API principal.

// =======================================================================
// FUNCIONES AUXILIARES (Sin cambios, pero incluidas para completitud)
// =======================================================================

/**
 * Crea el HTML para una fila de la tabla de vendedores.
 * @param {object} datosFila - Objeto con los datos ya formateados para la fila.
 * @returns {string} El HTML de la fila <tr>.
 */
function crearFilaHTML(datosFila) {
    return `
        <tr>
            <td>${datosFila.nombre}</td>
            <td>${formatCurrency(datosFila.facturacion)}</td>
            <td>${formatCurrency(datosFila.cobranza)}</td>
            <td>${datosFila.porcentaje}%</td>
        </tr>
    `;
}

function obtenerDatosFilaVendedor(vendedor, facturacion, cobranza) {
    const factVendedor = parseFloat(facturacion) || 0;
    const cobrVendedor = parseFloat(cobranza) || 0;
    
    const porcentajeCobranza = factVendedor > 0 ? 
        (cobrVendedor / factVendedor * 100).toFixed(2) : '0.00';
    
    return {
        nombre: vendedor.ven_des,
        facturacion: factVendedor,
        cobranza: cobrVendedor,
        porcentaje: porcentajeCobranza
    };
}

// Nueva función para obtener datos por vendedor (necesaria solo para el caso "all")
async function obtenerDatosPorVendedor(año, mes) {
    const cacheKey = `vendedores-detalle-${año}-${mes}`;
    
    if (cachedData[cacheKey]) {
        return cachedData[cacheKey];
    }
    
    try {
        const response = await $.ajax({
            url: '../admin/index.php?action=gerenciales&c=GerenciaData&a=8&t=factura',
            method: 'GET',
            data: { ano: año, mes: mes },
            dataType: 'json',
            timeout: 15000
        });
        
        cachedData[cacheKey] = response;
        return response;
        
    } catch (error) {
        console.error('Error al obtener datos por vendedor:', error);
        return [];
    }
}

// Función para actualizar los gráficos
function updateCharts(data, año, mes) {
    // Procesar datos para gráficos de productos
    if (data.productos && data.productos.length > 0) {
        const topProductos = procesarDatosProductos(data.productos);
        if (topProductos.length > 0) {
            crearGraficoProductos(topProductos, 'topProductosChart', 'Top 5 Productos por Unidades Vendidas');
            // Ocultar mensaje de no datos si estaba visible
            $('#noDatosProductos').hide();
        } else {
            // Mostrar mensaje de no datos
            mostrarMensajeNoDatos('topProductosChart', 'noDatosProductos');
        }
    } else {
        // Mostrar mensaje de no datos
        mostrarMensajeNoDatos('topProductosChart', 'noDatosProductos');
    }
    
    if (data.productosBialy && data.productosBialy.length > 0) {
        const topProductosBialy = procesarDatosProductos(data.productosBialy);
        if (topProductosBialy.length > 0) {
            crearGraficoProductos(topProductosBialy, 'topProductosChartBialy', 'Top 5 Productos Bialy - Unidades Vendidas');
            // Ocultar mensaje de no datos si estaba visible
            $('#noDatosProductosBialy').hide();
        } else {
            // Mostrar mensaje de no datos
            mostrarMensajeNoDatos('topProductosChartBialy', 'noDatosProductosBialy');
        }
    } else {
        // Mostrar mensaje de no datos
        mostrarMensajeNoDatos('topProductosChartBialy', 'noDatosProductosBialy');
    }
}
function mostrarMensajeNoDatos(chartId, messageId) {
    // Destruir el gráfico existente si hay uno
    const existingChart = window[chartId];
    if (existingChart && typeof existingChart.destroy === 'function') {
        existingChart.destroy();
    }
    
    // Ocultar elementos relacionados con el gráfico
    if (chartId === 'topProductosChart') {
        $('#totalUnidades').text('0');
        $('#topProduct').text('-');
        $('#leyendaProductos tbody').empty();
    } else {
        $('#totalUnidadesBialy').text('0');
        $('#topProductBialy').text('-');
        $('#leyendaProductosBialy tbody').empty();
    }
    
    // Crear o mostrar el mensaje de no datos
    if (!$('#' + messageId).length) {
        const messageHtml = `
            <div id="${messageId}" class="alert alert-info mt-3" role="alert">
                <i class="fas fa-info-circle"></i> El vendedor seleccionado no posee movimientos en este periodo.
            </div>
        `;
        $('#' + chartId).parent().append(messageHtml);
    } else {
        $('#' + messageId).show();
    }
}


function procesarDatosProductos(productosData) {
    return productosData
        .map(producto => {
            const unidades = parseFloat(
                producto.dato2.replace(/\./g, '').replace(',', '.')
            ) || 0;
            return {
                nombre: producto.dato1 || 'Producto sin nombre',
                unidades: unidades,
                marca: producto.dato3 || 'Producto sin marca',
            };
        })
        .sort((a, b) => b.unidades - a.unidades)
        .slice(0, 5);
}

function crearGraficoProductos(topProductos, chartId, titulo) {
    if (topProductos.length === 0) return;
    
    // Ocultar mensaje de no datos si existe
    if (chartId === 'topProductosChart' && $('#noDatosProductos').length) {
        $('#noDatosProductos').hide();
    } else if (chartId === 'topProductosChartBialy' && $('#noDatosProductosBialy').length) {
        $('#noDatosProductosBialy').hide();
    }
    
    const letras = ['A', 'B', 'C', 'D', 'E'];
    const labels = topProductos.map((p, index) => letras[index] || String.fromCharCode(65 + index));
    const data = topProductos.map(p => p.unidades);
    
    const totalUnidades = topProductos.reduce((sum, producto) => sum + producto.unidades, 0);
    
    if (chartId === 'topProductosChart') {
        $('#totalUnidades').text(totalUnidades.toLocaleString());
        $('#topProduct').text(topProductos[0]?.nombre || '-');
        crearLeyendaProductos(topProductos, letras, 'leyendaProductos');
    } else {
        $('#totalUnidadesBialy').text(totalUnidades.toLocaleString());
        $('#topProductBialy').text(topProductos[0]?.nombre || '-');
        crearLeyendaProductos(topProductos, letras, 'leyendaProductosBialy');
    }
    
    const ctx = document.getElementById(chartId);
    const existingChart = window[chartId];
    if (existingChart && typeof existingChart.destroy === 'function') {
        existingChart.destroy();
    }
    
    const colores = [
        'rgba(54, 162, 235, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 99, 132, 0.7)'
    ];
    
    window[chartId] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Unidades Vendidas',
                data: data,
                backgroundColor: colores.slice(0, topProductos.length),
                borderColor: colores.map(color => color.replace('0.7', '1')).slice(0, topProductos.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: titulo },
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            const index = tooltipItems[0].dataIndex;
                            return topProductos[index].nombre;
                        },
                        label: function(context) {
                            return 'Unidades vendidas: ' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Unidades Vendidas' },
                    ticks: { callback: value => value.toLocaleString() }
                },
                x: {
                    title: { display: true, text: 'Productos (ver leyenda)' }
                }
            }
        }
    });
}

function crearLeyendaProductos(productos, letras, leyendaId) {
    const tbody = document.querySelector(`#${leyendaId} tbody`);
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    const colores = ['#36a2eb', '#4bc0c0', '#ff9f40', '#9966ff', '#ff6384'];
    
    productos.forEach((producto, index) => {
        const fila = document.createElement('tr');
        
        fila.innerHTML = `
            <td class="fw-bold align-middle">${letras[index]}</td>
            <td class="align-middle">
                <span style="display:inline-block;width:15px;height:15px;background-color:${colores[index]};border-radius:3px;"></span>
            </td>
            <td class="align-middle" title="${producto.nombre}">
                ${producto.nombre.length > 30 ? producto.nombre.substring(0, 30) + '...' : producto.nombre}
            </td>
            <td class="align-middle" title="${producto.marca}">
              ${producto.marca}
            </td>
            <td class="text-end fw-bold align-middle">${producto.unidades.toLocaleString()}</td>
        `;
        
        tbody.appendChild(fila);
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

// Exponer funciones globalmente para debugging
window.clearDashboardCache = clearCache;
window.getDashboardCache = () => cachedData;