// Variables para los gráficos (ahora solo tendremos los de cobranza)
let evolucionCobranzaChart = null;
let distribucionVencidoChart = null;

// Cache de datos
let cachedVendedores = null;
let cachedData = {};

// NUEVA: Variable global para el cálculo implícito
let cachedCalculoImplicito = null;

// NUEVO: Variables para las nuevas métricas
let cachedCuentasPorPagar = null;
let cachedCuentasPorCobrar = null;
let cachedFacturasPorVencer = null;
let cachedFacturasVencidas0a15 = null;
let cachedFacturasVencidas16a30 = null;
let cachedFacturasVencidas31mas = null;

// NUEVA: Variable para el conteo de facturas vencidas (sin filtros)
let cachedTotalFacturasVencidasGlobal = null;

// Inicializar el dashboard
$(document).ready(async function() {
    if ($('#badgeFacturasLink').length) {
    
        iniciarActualizacionPeriodicaBadge();
     
        
        // Eventos de resize
        $(window).resize(debounce(function() {
            if (evolucionCobranzaChart) evolucionCobranzaChart.resize();
            if (distribucionVencidoChart) distribucionVencidoChart.resize();
        }, 250));
      
    } else {
        console.log("No hay elementos con la clase 'i_dashboard' en el DOM.");
    }
});

// Función para recargar manualmente el badge
function recargarBadgeFacturas() {
    $('#alertFacturas').text('...').show();
    actualizarConteoGlobalFacturasVencidas().then(total => {
        console.log('Badge recargado manualmente:', total);
    });
}

// Exponer función global para debugging
window.recargarBadgeFacturas = recargarBadgeFacturas;

// Función auxiliar para formatear fecha a YYYY-MM-DD
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
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

// Función específica para actualizar el conteo GLOBAL de facturas vencidas
async function actualizarConteoGlobalFacturasVencidas() {
    try {
        const response = await $.ajax({
            url: '../admin/index.php?action=gerenciales&c=GerenciaData&a=14&t=factura',
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

// Función para inicializar la actualización periódica del badge
function iniciarActualizacionPeriodicaBadge() {
    const INTERVALO_ACTUALIZACION = 300000; // 5 minutos
    
    actualizarConteoGlobalFacturasVencidas();
    
    setInterval(() => {
        console.log('Actualizando conteo global de facturas vencidas...');
        actualizarConteoGlobalFacturasVencidas();
    }, INTERVALO_ACTUALIZACION);
}

// Función para cargar datos iniciales desde la base de datos
async function cargarDatosIniciales() {
    try {
        const promises = [];
        
        if (!cachedVendedores) {
            promises.push($.ajax({
                url: '../admin/index.php?action=vendedores&tipo=1&accion=1&datos=1&c=VendedorData&a=1&t=vendedor', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }));
        }
        
        if (cachedCalculoImplicito === null) {
            promises.push($.ajax({
                url: '../admin/index.php?action=gerenciales&tipo=1&accion=1&datos=1&c=GerenciaData&a=9&t=jm_gerencia_data', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }));
        }
        
        if (cachedFacturasPorVencer === null || cachedFacturasVencidas0a15 === null || 
            cachedFacturasVencidas16a30 === null || cachedFacturasVencidas31mas === null) {
            promises.push($.ajax({
                url: '../admin/index.php?action=gerenciales&tipo=1&accion=1&datos=1&c=GerenciaData&a=12&t=jm_gerencia_data', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }));
        }
        
        const responses = await Promise.all(promises);
        let index = 0;
        
        if (!cachedVendedores) {
            cachedVendedores = responses[index++];
            const $vendedorSelect = $('#vendedorSelect');
            $vendedorSelect.empty();
            $vendedorSelect.append('<option value="all">TODOS</option>');
            $vendedorSelect.append('<option value="gventas">GRUPO VENTAS</option>');
            $.each(cachedVendedores, function(index, vendedor) {
                $vendedorSelect.append($('<option>', {
                    value: vendedor.co_ven,
                    text: vendedor.ven_des
                }));
            });
        }
        
        if (cachedCalculoImplicito === null) {
            const calculoData = responses[index++];
            const valor = calculoData && calculoData[0] ? calculoData[0].dato1 : 0;
            cachedCalculoImplicito = valor;
            $('#calculoImplicito').text((valor.toString().split('.')[1] || '00') + '%');
        }
        
        const facturasVencidasData = responses[index++];
        cachedTotalFacturasVencidasGlobal = facturasVencidasData && facturasVencidasData[0] ? 
                                           parseInt(facturasVencidasData[0].total) || 0 : 0;
        
        actualizarBadgeFacturas(cachedTotalFacturasVencidasGlobal);
        
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

function updateDashboard() {
    const startDateString = $('#startDateSelect').val();
    const endDateString = $('#endDateSelect').val();
    const vendedorId = $('#vendedorSelect').val();
    
    if (!startDateString || !endDateString) {
        showError('Debe seleccionar ambas fechas para filtrar.');
        return;
    }
    
    const startDate = parseDateFromString(startDateString);
    const endDate = parseDateFromString(endDateString);

    if (startDate > endDate) {
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const startFormatted = startDate.toLocaleDateString('es-ES', options);
        const endFormatted = endDate.toLocaleDateString('es-ES', options);
        
        showError(`La fecha de inicio (${startFormatted}) no puede ser posterior a la fecha de fin (${endFormatted}).`);
        return;
    }
    
    const options_display = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const startFormatted_display = startDate.toLocaleDateString('es-ES', options_display);
    const endFormatted_display = endDate.toLocaleDateString('es-ES', options_display);
    const periodoTexto = `Período: ${startFormatted_display} - ${endFormatted_display}`;
    
    $('#periodoFacturado').text(periodoTexto);
    $('#periodoCobranzas').text(periodoTexto);
    $('#periodoClientes').text(periodoTexto);
    $('#periodoClientesNuevos').text(periodoTexto);
    $('#periodoCuentasPorPagar').text(periodoTexto);
    $('#periodoCuentasPorCobrar').text(periodoTexto);
    $('#periodoFacturasPorVencer').text(periodoTexto);
    $('#periodoFacturasVencidas0a15').text(periodoTexto);
    $('#periodoFacturasVencidas16a30').text(periodoTexto);
    $('#periodoFacturasVencidas31mas').text(periodoTexto);
    
    obtenerDatosDashboard(startDateString, endDateString, vendedorId);
}

function parseDateFromString(dateString) {
    const parts = dateString.split('-');
    const year = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10) - 1;
    const day = parseInt(parts[2], 10);
    return new Date(year, month, day);
}

async function obtenerDatosDashboard(startDate, endDate, vendedorId) {
    const cacheKey = `${startDate}-${endDate}-${vendedorId}`;
    
    if (cachedData[cacheKey] && (Date.now() - cachedData[cacheKey].timestamp) < 120000) {
        procesarDatosDashboard(cachedData[cacheKey].data, startDate, endDate, vendedorId);
        return;
    }
    
    $('#loadingIndicator').show();
    $('.error-message').remove();
    
    try {
        // URLs de las APIs (eliminadas las de productos)
        const urls = [
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=1&t=factura', // Facturación
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=2&t=factura', // Cobranzas
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=5&t=factura', // Clientes Activos
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=6&t=factura', // Clientes Nuevos
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=10&t=factura', // Cuentas por Pagar
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=11&t=factura', // Cuentas por Cobrar
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=1', // Facturas por Vencer
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=2', // Facturas Vencidas 0-15 días
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=3', // Facturas Vencidas 16-30 días
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=4'  // Facturas Vencidas 31+ días
        ];
        
        const params = { 
            fechaInicio: startDate,
            fechaFin: endDate,
            vendedorId: vendedorId 
        };
        
        const requests = urls.map(url => 
            $.ajax({
                url: url,
                method: 'GET',
                data: params,
                dataType: 'json',
                timeout: 20000
            })
        );
        
        const responses = await Promise.all(requests);
        
        const data = {
            facturacion: responses[0],
            cobranzas: responses[1],
            clientesActivos: responses[2],
            clientesNuevos: responses[3],
            cuentasPorPagar: responses[4],
            cuentasPorCobrar: responses[5],
            facturasPorVencer: responses[6],
            facturasVencidas0a15: responses[7],
            facturasVencidas16a30: responses[8],
            facturasVencidas31mas: responses[9]
        };
        
        cachedData[cacheKey] = {
            data: data,
            timestamp: Date.now()
        };
        
        procesarDatosDashboard(data, startDate, endDate, vendedorId);
        
    } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos. Por favor, intente nuevamente.');
    }
}

function procesarDatosDashboard(data, startDate, endDate, vendedorId) {
    console.log(data);
    $('#loadingIndicator').hide();
    
    if (!data.facturacion || !data.cobranzas ||
        !data.clientesActivos || !data.clientesActivos[0] ||
        !data.clientesNuevos || !data.clientesNuevos[0] ||
        !data.cuentasPorPagar || !data.cuentasPorCobrar ||
        !data.facturasPorVencer || !data.facturasVencidas0a15 || !data.facturasVencidas16a30 || !data.facturasVencidas31mas) {
        showError('Datos incompletos recibidos del servidor');
        return;
    }
    
    try {
        let totalFacturacion = 0;
        let totalCobranzas = 0;
        let totalCuentasPorPagar = 0;
        let totalCuentasPorCobrar = 0;
        let totalFacturasPorVencer = 0;
        let totalFacturasVencidas0a15 = 0;
        let totalFacturasVencidas16a30 = 0;
        let totalFacturasVencidas31mas = 0;

        if (vendedorId === 'all' || vendedorId === 'gventas' || vendedorId === 'aventas') {
            totalFacturacion = data.facturacion.reduce((sum, item) => sum + item.dato1, 0);
            totalCobranzas = data.cobranzas.reduce((sum, item) => sum + item.dato1, 0);
            totalCuentasPorPagar = data.cuentasPorPagar.reduce((sum, item) => sum + item.dato1, 0);
            totalCuentasPorCobrar = data.cuentasPorCobrar.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasPorVencer = data.facturasPorVencer.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas0a15 = data.facturasVencidas0a15.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas16a30 = data.facturasVencidas16a30.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas31mas = data.facturasVencidas31mas.reduce((sum, item) => sum + item.dato1, 0);
        } else {
            totalFacturacion = data.facturacion[0]?.dato1 || 0;
            totalCobranzas = data.cobranzas[0]?.dato1 || 0;
            totalCuentasPorPagar = data.cuentasPorPagar[0]?.dato1 || 0;
            totalCuentasPorCobrar = data.cuentasPorCobrar[0]?.dato1 || 0;
            totalFacturasPorVencer = data.facturasPorVencer[0]?.dato1 || 0;
            totalFacturasVencidas0a15 = data.facturasVencidas0a15[0]?.dato1 || 0;
            totalFacturasVencidas16a30 = data.facturasVencidas16a30[0]?.dato1 || 0;
            totalFacturasVencidas31mas = data.facturasVencidas31mas[0]?.dato1 || 0;
        }
        
        // Calcular total vencido y eficiencia
        const totalVencido = totalFacturasVencidas0a15 + totalFacturasVencidas16a30 + totalFacturasVencidas31mas;
        const eficienciaCobro = totalFacturacion > 0 ? ((totalCobranzas / totalFacturacion) * 100).toFixed(2) : 0;
        
        // Actualizar tarjetas
        $('#montoFacturado').text(formatCurrency(totalFacturacion));
        $('#cobranzasMes').text(formatCurrency(totalCobranzas));
        $('#clientesActivos').text(data.clientesActivos[0]?.dato1 || '0');
        $('#clientesNuevos').text(data.clientesNuevos[0]?.dato1 || '0');
        $('#cuentasPorPagar').text(formatCurrency(totalCuentasPorPagar));
        $('#cuentasPorCobrar').text(formatCurrency(totalCuentasPorCobrar));
        $('#facturasPorVencer').text(formatCurrency(totalFacturasPorVencer));
        $('#facturasVencidas0a15').text(formatCurrency(totalFacturasVencidas0a15));
        $('#facturasVencidas16a30').text(formatCurrency(totalFacturasVencidas16a30));
        $('#facturasVencidas31mas').text(formatCurrency(totalFacturasVencidas31mas));
        
        // Actualizar nuevas tarjetas de cobranza
        $('#totalVencido').text(formatCurrency(totalVencido));
        $('#eficienciaCobro').text(`${eficienciaCobro}%`);
        
        // Actualizar tabla de vendedores
        actualizarTablaVendedores(data, vendedorId, startDate, endDate);
        
        // Crear gráficos de cobranza
        crearGraficosCobranza(data, totalFacturacion, totalCobranzas, totalVencido);
        
    } catch (error) {
        console.error('Error al procesar datos:', error);
        showError('Error al procesar los datos recibidos');
    }
}

// Función para crear gráficos de cobranza
function crearGraficosCobranza(data, totalFacturacion, totalCobranzas, totalVencido) {
    // Destruir gráficos existentes
    if (evolucionCobranzaChart) evolucionCobranzaChart.destroy();
    if (distribucionVencidoChart) distribucionVencidoChart.destroy();
    
    // Gráfico de evolución (simulado con datos de ejemplo - aquí deberías tener datos reales por período)
    const ctxEvolucion = document.getElementById('evolucionCobranzaChart');
    if (ctxEvolucion) {
        evolucionCobranzaChart = new Chart(ctxEvolucion, {
            type: 'line',
            data: {
                labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                datasets: [
                    {
                        label: 'Cobranza',
                        data: [totalCobranzas * 0.2, totalCobranzas * 0.3, totalCobranzas * 0.25, totalCobranzas * 0.25],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    },
                    {
                        label: 'Vencido',
                        data: [totalVencido * 0.25, totalVencido * 0.25, totalVencido * 0.25, totalVencido * 0.25],
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Evolución de Cobranza vs Vencido'
                    }
                }
            }
        });
    }
    
    // Gráfico de distribución de cartera vencida
    const ctxDistribucion = document.getElementById('distribucionVencidoChart');
    if (ctxDistribucion) {
        const vencidas0a15 = data.facturasVencidas0a15.reduce((sum, item) => sum + item.dato1, 0);
        const vencidas16a30 = data.facturasVencidas16a30.reduce((sum, item) => sum + item.dato1, 0);
        const vencidas31mas = data.facturasVencidas31mas.reduce((sum, item) => sum + item.dato1, 0);
        
        distribucionVencidoChart = new Chart(ctxDistribucion, {
            type: 'doughnut',
            data: {
                labels: ['0-15 días', '16-30 días', '31+ días'],
                datasets: [{
                    data: [vencidas0a15, vencidas16a30, vencidas31mas],
                    backgroundColor: [
                        'rgba(255, 205, 86, 0.8)',  // Amarillo
                        'rgba(255, 159, 64, 0.8)',  // Naranja
                        'rgba(255, 99, 132, 0.8)'   // Rojo
                    ],
                    borderColor: [
                        'rgb(255, 205, 86)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 99, 132)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribución de Cartera Vencida'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}

async function actualizarTablaVendedores(data, vendedorId, startDate, endDate) {
    let tablaHTML = '';
    const tablaVendedoresElement = $('#tablaVendedores');
    tablaVendedoresElement.html('<tr><td colspan="4">Cargando...</td></tr>');

    try {
        if (vendedorId === 'all') {
            data.facturacion.forEach(vendedor => {
                const datosFila = obtenerDatosFilaVendedor(
                    { ven_des: vendedor.dato3 },
                    vendedor.dato1,
                    vendedor.dato4
                );
                tablaHTML += crearFilaHTML(datosFila);
            });
        } else if (vendedorId === 'gventas' || vendedorId === 'aventas') {
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

function showError(message) {
    $('.error-message').remove();
    const errorHtml = `
        <div class="alert alert-danger error-message" role="alert">
            <i class="fas fa-exclamation-triangle"></i> ${message}
        </div>
    `;
    $('#dashboardContent').prepend(errorHtml);
}

function clearCache() {
    cachedData = {};
    console.log('Cache limpiado');
}

window.clearDashboardCache = clearCache;
window.getDashboardCache = () => cachedData;