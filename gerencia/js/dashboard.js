// Variables para los gráficos
let facturacionCobranzasChart = null;
let topProductosChart = null;
let topProductosChartBialy = null;

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

// Inicializar el dashboard
 $(document).ready(async function() { // <-- NUEVO: Añadimos 'async' aquí
    if ($('.i_dashboard').length) {
        // --- PASO 1: Establecer fechas por defecto (mes actual) ---
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        
        $('#startDateSelect').val(formatDate(firstDay));
        $('#endDateSelect').val(formatDate(lastDay));
        
        // --- PASO 2: Cargar datos iniciales (vendedores, etc.) y ESPERAR a que termine ---
        // Usamos 'await' para pausar esta función hasta que cargarDatosIniciales() se complete
        await cargarDatosIniciales();
        
        // --- PASO 3: Ahora que todo está listo, actualizamos el dashboard ---
        // En este punto, los campos de fecha ya tienen el valor correcto del mes actual
        updateDashboard();
        
        // El resto de tu código se mantiene igual
        $(window).resize(debounce(function() {
            if (facturacionCobranzasChart) facturacionCobranzasChart.resize();
            if (topProductosChart) topProductosChart.resize();
            if (topProductosChartBialy) topProductosChartBialy.resize();
        }, 250));
        
        $('#startDateSelect, #endDateSelect, #vendedorSelect').change(debounce(function() {
            updateDashboard();
        }, 300));
    } else {
        console.log("No hay elementos con la clase 'i_dashboard' en el DOM.");
    }
});

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

// Función para cargar datos iniciales desde la base de datos
async function cargarDatosIniciales() {
    try {
        // Preparamos las llamadas AJAX: vendedores, cálculo implícito, y las nuevas métricas
        const promises = [];
        
        // 1. Llamada para los vendedores (solo si no están en cache)
        if (!cachedVendedores) {
            promises.push($.ajax({
                url: '../admin/index.php?action=vendedores&tipo=1&accion=1&datos=1&c=VendedorData&a=1&t=vendedor', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }));
        }
        
        // 2. Llamada para el cálculo implícito (solo si no está en cache)
        if (cachedCalculoImplicito === null) {
            promises.push($.ajax({
                url: '../admin/index.php?action=gerenciales&tipo=1&accion=1&datos=1&c=GerenciaData&a=9&t=jm_gerencia_data', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }));
        }
        
        // 3. Llamadas para las nuevas métricas (solo si no están en cache)
        if (cachedFacturasPorVencer === null || cachedFacturasVencidas0a15 === null || cachedFacturasVencidas16a30 === null  || cachedFacturasVencidas31mas === null) {
            promises.push($.ajax({
                url: '../admin/index.php?action=gerenciales&tipo=1&accion=1&datos=1&c=GerenciaData&a=12&t=jm_gerencia_data', 
                method: 'GET',
                dataType: 'json',
                timeout: 15000
            }));
        }
        
        // Esperamos a que todas las llamadas se completen
        const responses = await Promise.all(promises);
        
        // Procesamos las respuestas
        let index = 0;
        
        // Procesamos la respuesta de VENDEDORES
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
        
        // Procesamos la respuesta del CÁLCULO IMPLÍCITO
        if (cachedCalculoImplicito === null) {
            const calculoData = responses[index++];
            const valor = calculoData && calculoData[0] ? calculoData[0].dato1 : 0;
            cachedCalculoImplicito = valor;
            $('#calculoImplicito').text((valor.toString().split('.')[1] || '00') + '%');
        }
        
        // Procesamos la respuesta de FACTURAS POR VENCER
        if (cachedFacturasPorVencer === null) {
            const facturasPorVencerData = responses[index++];
            const valor = facturasPorVencerData && facturasPorVencerData[0] ? facturasPorVencerData[0].dato1 : 0;
            cachedFacturasPorVencer = valor;
        }
        
        // Procesamos la respuesta de FACTURAS VENCIDAS 0-15 DÍAS
        if (cachedFacturasVencidas0a15 === null) {
            const facturasVencidas0a15Data = responses[index++];
            const valor = facturasVencidas0a15Data && facturasVencidas0a15Data[0] ? facturasVencidas0a15Data[0].dato1 : 0;
            cachedFacturasVencidas0a15 = valor;
        }
        
        // Procesamos la respuesta de FACTURAS VENCIDAS 16-30 DÍAS
        if (cachedFacturasVencidas16a30 === null) {
            const facturasVencidas16a30Data = responses[index++];
            const valor = facturasVencidas16a30Data && facturasVencidas16a30Data[0] ? facturasVencidas16a30Data[0].dato1 : 0;
            cachedFacturasVencidas16a30 = valor;
        }

           
        // Procesamos la respuesta de FACTURAS VENCIDAS 16-30 DÍAS
        if (cachedFacturasVencidas31mas === null) {
            const facturasVencidas31masData = responses[index++];
            const valor = facturasVencidas31masData && facturasVencidas31masData[0] ? facturasVencidas31masData[0].dato1 : 0;
            cachedFacturasVencidas31mas = valor;
        }
        
        
        // Una vez cargados los datos iniciales, actualizamos el dashboard por primera vez
     //   updateDashboard();
        
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
    return months[monthNumber] || 'Mes inválido';
}
function updateDashboard() {
    // Leemos los valores de los inputs como strings
    const startDateString = $('#startDateSelect').val();
    const endDateString = $('#endDateSelect').val();
    const vendedorId = $('#vendedorSelect').val();
    
    // Validar que los campos no estén vacíos
    if (!startDateString || !endDateString) {
        showError('Debe seleccionar ambas fechas para filtrar.');
        return;
    }
    
    // --- INICIO DE LA VALIDACIÓN MEJORADA ---
    // Usamos nuestra función auxiliar para crear objetos Date seguros y sin ambigüedades.
    const startDate = parseDateFromString(startDateString);
    const endDate = parseDateFromString(endDateString);

    // Comparamos los objetos Date directamente.
    if (startDate > endDate) {
        // Creamos un mensaje de error dinámico y claro
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const startFormatted = startDate.toLocaleDateString('es-ES', options);
        const endFormatted = endDate.toLocaleDateString('es-ES', options);
        
        showError(`La fecha de inicio (${startFormatted}) no puede ser posterior a la fecha de fin (${endFormatted}).`);
        return;
    }
    // --- FIN DE LA VALIDACIÓN MEJORADA ---
    
    // El resto de tu función para formatear y mostrar el período se mantiene igual
    const options_display = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const startFormatted_display = startDate.toLocaleDateString('es-ES', options_display);
    const endFormatted_display = endDate.toLocaleDateString('es-ES', options_display);
    const periodoTexto = `Período: ${startFormatted_display} - ${endFormatted_display}`;
    
    // Actualizar todos los elementos de período en el HTML
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
    
    // Obtener datos desde la base de datos
    obtenerDatosDashboard(startDateString, endDateString, vendedorId);
}

// Función auxiliar para formatear fecha para display
function formatDateForDisplay(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-VE', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function parseDateFromString(dateString) {
    const parts = dateString.split('-');
    const year = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10) - 1; // Los meses en JS son 0-11
    const day = parseInt(parts[2], 10);
    return new Date(year, month, day);
}


async function obtenerDatosDashboard(startDate, endDate, vendedorId) {
    const cacheKey = `${startDate}-${endDate}-${vendedorId}`;
    
    // Verificar si los datos están en cache (válido por 2 minutos)
    if (cachedData[cacheKey] && (Date.now() - cachedData[cacheKey].timestamp) < 120000) {
        procesarDatosDashboard(cachedData[cacheKey].data, startDate, endDate, vendedorId);
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
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=7&t=factura',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=10&t=factura', // Cuentas por Pagar
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=11&t=factura&', // Cuentas por Cobrar
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=1', // Facturas por Vencer
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=2', // Facturas Vencidas 0-15 días
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=3',
            '../admin/index.php?action=gerenciales&c=GerenciaData&a=12&t=factura&filtroDias=4'  // Facturas Vencidas 31 o mas días
        ];
        
        // Parámetros comunes con fechas
        const params = { 
            fechaInicio: startDate,
            fechaFin: endDate,
            vendedorId: vendedorId 
        };
        
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
            productosBialy: responses[5],
            cuentasPorPagar: responses[6],
            cuentasPorCobrar: responses[7],
            facturasPorVencer: responses[8],
            facturasVencidas0a15: responses[9],
            facturasVencidas16a30: responses[10],
            facturasVencidas31mas: responses[11]
        };
        
        // Guardar en cache con timestamp
        cachedData[cacheKey] = {
            data: data,
            timestamp: Date.now()
        };
        
        // Procesar datos
        procesarDatosDashboard(data, startDate, endDate, vendedorId);
        
    } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
        $('#loadingIndicator').hide();
        showError('Error al cargar datos. Por favor, intente nuevamente.');
    }
}

// =======================================================================
// REFACTORING CLAVE 1: Lógica de procesamiento de datos simplificada
// =======================================================================
function procesarDatosDashboard(data, startDate, endDate, vendedorId) {
    console.log(data);
    $('#loadingIndicator').hide();
    
    // Validación mejorada de los datos
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

        if (vendedorId === 'all') {

            // Caso: "TODOS". Sumamos los totales de todos los vendedores.
            totalFacturacion = data.facturacion.reduce((sum, item) => sum + item.dato1, 0);
            totalCobranzas = data.cobranzas.reduce((sum, item) => sum + item.dato1, 0);
            totalCuentasPorPagar = data.cuentasPorPagar.reduce((sum, item) => sum + item.dato1, 0);
            totalCuentasPorCobrar = data.cuentasPorCobrar.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasPorVencer = data.facturasPorVencer.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas0a15 = data.facturasVencidas0a15.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas16a30 = data.facturasVencidas16a30.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas31mas = data.facturasVencidas31mas.reduce((sum, item) => sum + item.dato1, 0);

        } else if (vendedorId === 'gventas' || vendedorId === 'aventas') {

            // Caso: GRUPO VENTAS o ASESORES DE VENTAS
            // Sumamos todos los registros que vienen para este grupo
            totalFacturacion = data.facturacion.reduce((sum, item) => sum + item.dato1, 0);
            totalCobranzas = data.cobranzas.reduce((sum, item) => sum + item.dato1, 0);
            totalCuentasPorPagar = data.cuentasPorPagar.reduce((sum, item) => sum + item.dato1, 0);
            totalCuentasPorCobrar = data.cuentasPorCobrar.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasPorVencer = data.facturasPorVencer.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas0a15 = data.facturasVencidas0a15.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas16a30 = data.facturasVencidas16a30.reduce((sum, item) => sum + item.dato1, 0);
            totalFacturasVencidas31mas = data.facturasVencidas31mas.reduce((sum, item) => sum + item.dato1, 0);

        } else {

            // Caso: Vendedor específico
            const factRecord = data.facturacion[0] || {};
            const cobRecord = data.cobranzas[0] || {};
            const pagarRecord = data.cuentasPorPagar[0] || {};
            const cobrarRecord = data.cuentasPorCobrar[0] || {};
            const vencerRecord = data.facturasPorVencer[0] || {};
            const vencidas0a15Record = data.facturasVencidas0a15[0] || {};
            const vencidas16a30Record = data.facturasVencidas16a30[0] || {};
            const vencidas31masRecord = data.facturasVencidas31mas[0] || {};
            
            totalFacturacion = factRecord.dato1 || 0;
            totalCobranzas = cobRecord.dato1 || 0;
            totalCuentasPorPagar = pagarRecord.dato1 || 0;
            totalCuentasPorCobrar = cobrarRecord.dato1 || 0;
            totalFacturasPorVencer = vencerRecord.dato1 || 0;
            totalFacturasVencidas0a15 = vencidas0a15Record.dato1 || 0;
            totalFacturasVencidas16a30 = vencidas16a30Record.dato1 || 0;
            totalFacturasVencidas31mas = vencidas31masRecord.dato1 || 0;    
        }
        
        // Actualizar tarjetas de resumen con los valores calculados
        $('#montoFacturado').text(formatCurrency(totalFacturacion));
        $('#cobranzasMes').text(formatCurrency(totalCobranzas));
        $('#clientesActivos').text(data.clientesActivos[0].dato1 || '0');
        $('#clientesNuevos').text(data.clientesNuevos[0].dato1 || '0');
        $('#cuentasPorPagar').text(formatCurrency(totalCuentasPorPagar));
        $('#cuentasPorCobrar').text(formatCurrency(totalCuentasPorCobrar));
        $('#facturasPorVencer').text(formatCurrency(totalFacturasPorVencer));
        $('#facturasVencidas0a15').text(formatCurrency(totalFacturasVencidas0a15));
        $('#facturasVencidas16a30').text(formatCurrency(totalFacturasVencidas16a30));
        $('#facturasVencidas31mas').text(formatCurrency(totalFacturasVencidas31mas));
        
        // Actualizar tabla de vendedores
        actualizarTablaVendedores(data, vendedorId, startDate, endDate);
        
        // Actualizar gráficos
        updateCharts(data, startDate, endDate);
    } catch (error) {
        console.error('Error al procesar datos:', error);
        showError('Error al procesar los datos recibidos');
    }
}

// =======================================================================
// REFACTORING CLAVE 2: Función de tabla de vendedores simplificada
// =======================================================================
async function actualizarTablaVendedores(data, vendedorId, startDate, endDate) {
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

// Modificar la función obtenerDatosPorVendedor
async function obtenerDatosPorVendedor(startDate, endDate) {
    const cacheKey = `vendedores-detalle-${startDate}-${endDate}`;
    
    if (cachedData[cacheKey]) {
        return cachedData[cacheKey];
    }
    
    try {
        const response = await $.ajax({
            url: '../admin/index.php?action=gerenciales&c=GerenciaData&a=8&t=factura',
            method: 'GET',
            data: { 
                fechaInicio: startDate,
                fechaFin: endDate
            },
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