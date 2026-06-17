// Variables para los gráficos
let facturacionCobranzasChart = null;
let topProductosChart = null;
let topProductosChartBialy = null;

// Cache de datos
let cachedVendedores = null;
let cachedData = {};

// Inicializar el dashboard
$(document).ready(function() {
    // Cargar datos iniciales
    cargarDatosIniciales();
    
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
        // Cargar vendedores desde la base de datos (con cache)
        if (!cachedVendedores) {
            const vendedores = await $.ajax({
                            url: '../admin/index.php?action=vendedores&tipo=1&accion=1&datos=1&c=VendedorData&a=1&t=vendedor', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            });
            
            cachedVendedores = vendedores;
            const $vendedorSelect = $('#vendedorSelect');
            $vendedorSelect.empty();
            $vendedorSelect.append('<option value="all">Todos los vendedores</option>');
            
            $.each(vendedores, function(index, vendedor) {
                $vendedorSelect.append($('<option>', {
                    value: vendedor.co_ven,
                    text: vendedor.ven_des
                }));
            });
        }
        
        // Una vez cargados los vendedores, actualizar el dashboard
        updateDashboard();
    } catch (error) {
        console.error('Error al cargar vendedores:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos de vendedores');
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

// Función principal para actualizar el dashboard
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

// Función optimizada para obtener datos del dashboard
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

function procesarDatosDashboard(data, año, mes, vendedorId) {
    $('#loadingIndicator').hide();
    
    // Validar que los datos llegaron correctamente
    if (!data.facturacion || !data.facturacion[0] || 
        !data.cobranzas || !data.cobranzas[0] ||
        !data.clientesActivos || !data.clientesActivos[0] ||
        !data.clientesNuevos || !data.clientesNuevos[0]) {
        showError('Datos incompletos recibidos del servidor');
        return;
    }
    
    try {
        // Actualizar tarjetas de resumen
        $('#montoFacturado').text(formatCurrency(data.facturacion[0].dato1 - data.facturacion[0].dato2));
        $('#cobranzasMes').text(formatCurrency(data.cobranzas[0].dato1));
        $('#clientesActivos').text(data.clientesActivos[0].dato1 || '0');
        $('#clientesNuevos').text(data.clientesNuevos[0].dato1 || '0');
        
        // Actualizar tabla de vendedores
        actualizarTablaVendedores(data, vendedorId);
        
        // Actualizar gráficos
        updateCharts(data, año, mes);
    } catch (error) {
        console.error('Error al procesar datos:', error);
        showError('Error al procesar los datos recibidos');
    }
}

    // Función para actualizar tabla de vendedores con datos reales
async function actualizarTablaVendedores(data, vendedorId, año, mes) {
    let tablaHTML = '';
    
    if (vendedorId === 'all' && cachedVendedores) {
        // Para todos los vendedores, necesitamos obtener datos individuales
        try {
            // Obtener datos detallados por vendedor
            const datosPorVendedor = await obtenerDatosPorVendedor(año, mes);
            
            cachedVendedores.forEach(vendedor => {
                const datosVendedor = datosPorVendedor.find(d => d.co_ven == vendedor.co_ven) || {};
                const factVendedor = parseFloat(datosVendedor.facturacion) || 0;
                const cobrVendedor = parseFloat(datosVendedor.cobranza) || 0;
                const porcentajeCobranza = factVendedor > 0 ? 
                    (cobrVendedor / factVendedor * 100).toFixed(2) : '0.00';
                
                tablaHTML += `
                    <tr>
                        <td>${vendedor.ven_des}</td>
                        <td>${formatCurrency(factVendedor)}</td>
                        <td>${formatCurrency(cobrVendedor)}</td>
                        <td>${porcentajeCobranza}%</td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Error al obtener datos por vendedor:', error);
            tablaHTML = '<tr><td colspan="4">Error al cargar datos por vendedor</td></tr>';
        }
    } else {
        // Datos para un vendedor específico
        const vendedor = cachedVendedores ? cachedVendedores.find(v => v.co_ven == vendedorId) : null;
        if (vendedor) {
            const facturacionTotal = data.facturacion[0].dato1 - data.facturacion[0].dato2;
            const cobranzasTotal = data.cobranzas[0].dato1;
            const porcentajeCobranza = facturacionTotal > 0 ? 
                (cobranzasTotal / facturacionTotal * 100).toFixed(2) : '0.00';
            
            tablaHTML = `
                <tr>
                    <td>${vendedor.ven_des}</td>
                    <td>${formatCurrency(facturacionTotal)}</td>
                    <td>${formatCurrency(cobranzasTotal)}</td>
                    <td>${porcentajeCobranza}%</td>
                </tr>
            `;
        } else {
            tablaHTML = '<tr><td colspan="4">No se encontraron datos</td></tr>';
        }
    }
    
    $('#tablaVendedores').html(tablaHTML);
}

// Nueva función para obtener datos por vendedor
async function obtenerDatosPorVendedor(año, mes) {
    const cacheKey = `vendedores-detalle-${año}-${mes}`;
    
    // Verificar cache
    if (cachedData[cacheKey]) {
        return cachedData[cacheKey];
    }
    
    try {
        // Llamar a API específica para datos por vendedor
        const response = await $.ajax({
            url: '../admin/index.php?action=gerenciales&c=GerenciaData&a=8&t=factura',
            method: 'GET',
            data: { ano: año, mes: mes },
            dataType: 'json',
            timeout: 15000
        });
        
        // Guardar en cache
        cachedData[cacheKey] = response;
        return response;
        
    } catch (error) {
        console.error('Error al obtener datos por vendedor:', error);
        return [];
    }
}

// También necesitamos modificar la llamada en procesarDatosDashboard:
function procesarDatosDashboard(data, año, mes, vendedorId) {
    $('#loadingIndicator').hide();
    
    // Validar que los datos llegaron correctamente
    if (!data.facturacion || !data.facturacion[0] || 
        !data.cobranzas || !data.cobranzas[0] ||
        !data.clientesActivos || !data.clientesActivos[0] ||
        !data.clientesNuevos || !data.clientesNuevos[0]) {
        showError('Datos incompletos recibidos del servidor');
        return;
    }
    
    try {
        // Actualizar tarjetas de resumen
        $('#montoFacturado').text(formatCurrency(data.facturacion[0].dato1 - data.facturacion[0].dato2));
        $('#cobranzasMes').text(formatCurrency(data.cobranzas[0].dato1));
        $('#clientesActivos').text(data.clientesActivos[0].dato1 || '0');
        $('#clientesNuevos').text(data.clientesNuevos[0].dato1 || '0');
        
        // Actualizar tabla de vendedores (PASAMOS año y mes)
        actualizarTablaVendedores(data, vendedorId, año, mes);
        
        // Actualizar gráficos
        updateCharts(data, año, mes);
    } catch (error) {
        console.error('Error al procesar datos:', error);
        showError('Error al procesar los datos recibidos');
    }
}

// Función para actualizar los gráficos
function updateCharts(data, año, mes) {
    // Procesar datos para gráficos de productos
    if (data.productos && data.productos.length > 0) {
        const topProductos = procesarDatosProductos(data.productos);
        crearGraficoProductos(topProductos, 'topProductosChart', 'Top 5 Productos por Unidades Vendidas');
    }
    
    if (data.productosBialy && data.productosBialy.length > 0) {
        const topProductosBialy = procesarDatosProductos(data.productosBialy);
        crearGraficoProductos(topProductosBialy, 'topProductosChartBialy', 'Top 5 Productos Bialy - Unidades Vendidas');
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
                unidades: unidades
            };
        })
        .sort((a, b) => b.unidades - a.unidades)
        .slice(0, 5);
}

function crearGraficoProductos(topProductos, chartId, titulo) {
    if (topProductos.length === 0) return;
    
    const letras = ['A', 'B', 'C', 'D', 'E'];
    const labels = topProductos.map((p, index) => letras[index] || String.fromCharCode(65 + index));
    const data = topProductos.map(p => p.unidades);
    
    // Calcular total de unidades
    const totalUnidades = topProductos.reduce((sum, producto) => sum + producto.unidades, 0);
    
    // Actualizar resumen según el tipo de gráfico
    if (chartId === 'topProductosChart') {
        $('#totalUnidades').text(totalUnidades.toLocaleString());
        $('#topProduct').text(topProductos[0]?.nombre || '-');
        crearLeyendaProductos(topProductos, letras, 'leyendaProductos');
    } else {
        $('#totalUnidadesBialy').text(totalUnidades.toLocaleString());
        $('#topProductBialy').text(topProductos[0]?.nombre || '-');
        crearLeyendaProductos(topProductos, letras, 'leyendaProductosBialy');
    }
    
    // Destruir gráfico existente
    const ctx = document.getElementById(chartId);
    const existingChart = window[chartId];
    if (existingChart && typeof existingChart.destroy === 'function') {
        existingChart.destroy();
    }
    
    // Colores para las barras
    const colores = [
        'rgba(54, 162, 235, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 99, 132, 0.7)'
    ];
    
    // Crear nuevo gráfico
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