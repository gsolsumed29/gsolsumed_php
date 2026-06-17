const DashboardAlmacen = {
    // Variables para los gráficos (ahora propiedades del objeto)
    charts: {
        facturas: null,
        envios: null
    },

    // Cache de datos (ahora dentro del objeto para no confundirse con el otro dashboard)
    cache: {},

    // Función de inicialización principal
    init: function() {
        // Verificamos si existe el elemento HTML específico de este dashboard
        if ($('.i_dashboard_almacen').length) {
            // Establecer mes actual por defecto
            const now = new Date();
            $('#monthSelect').val(now.getMonth() + 1);
            $('#yearSelect').val(now.getFullYear());
            
            // Guardamos referencia al contexto actual (this) para usarlo dentro de los callbacks
            const self = this;

            // Ajustar gráficos al cambiar el tamaño de la ventana
            $(window).resize(this.debounce(function() {
                if (self.charts.facturas) self.charts.facturas.resize();
                if (self.charts.envios) self.charts.envios.resize();
            }, 250));
            
            // Manejar cambios en los filtros
            $('#yearSelect, #monthSelect').change(this.debounce(function() {
                self.updateDashboard();
            }, 300));

            this.cargarDatosIniciales();
        }
    },

    // Función debounce (ahora es un método del objeto)
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Función para cargar datos iniciales
    cargarDatosIniciales: async function() {
        try {
            this.updateDashboard();
        } catch (error) {
            console.error('Error al cargar datos iniciales:', error);
            $('#loadingIndicator').hide();
            this.showError('Error al cargar datos iniciales. Por favor, recargue la página.');
        }
    },

    // Función para obtener el nombre del mes
    getMonthName: function(monthNumber) {
        const months = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        return months[monthNumber - 1] || 'Mes inválido';
    },

    updateDashboard: function() {
        const año = parseInt($('#yearSelect').val());
        const mes = $('#monthSelect').val();
        
        if (isNaN(año)) {
            this.showError('Año seleccionado inválido');
            return;
        }
        
        if (mes !== "all" && (isNaN(mes) || parseInt(mes) < 1 || parseInt(mes) > 12)) {
            this.showError('Mes seleccionado inválido');
            return;
        }
        
        const periodoTexto = mes === "all" ? 
            `Período: Acumulado ${año}` : 
            `Período: ${this.getMonthName(parseInt(mes))} ${año}`;
        
        // Actualizar todos los períodos en las tarjetas
        $('#periodoFacturasComparacion , #periodoDespachosInternos, #periodoDespachosExternos, #periodoFacturasPorDespachar, #periodoFacturasDespachadas, #periodoFacturasAnuladas, #periodoOrdenesDespacho, #periodoEnviosDespachados, #periodoEnviosPorDespachar, #periodoEnviosAnulados').text(periodoTexto);
        
        this.obtenerDatosDashboard(año, mes);
    },

    obtenerDatosDashboard: async function(año, mes) {
        const cacheKey = `${año}-${mes}`;
        
        if (this.cache[cacheKey] && (Date.now() - this.cache[cacheKey].timestamp) < 120000) {
            this.procesarDatosDashboard(this.cache[cacheKey].data, año, mes);
            return;
        }
        
        $('#loadingIndicator').show();
        $('.error-message').remove();
        
        try {
            // URLs de las APIs
            const urls = [
                '../admin/index.php?action=almacen&c=VehiculoData&a=3&t=factura&opcion=2',
                '../admin/index.php?action=almacen&c=VehiculoData&a=3&t=factura&opcion=1',
                '../admin/index.php?action=almacen&c=VehiculoData&a=4&t=factura&opcion=2',
                '../admin/index.php?action=almacen&c=VehiculoData&a=4&t=factura&opcion=1',
                '../admin/index.php?action=almacen&c=VehiculoData&a=5&t=factura',
                '../admin/index.php?action=almacen&c=VehiculoData&a=6&t=factura',
                '../admin/index.php?action=almacen&c=VehiculoData&a=7&t=factura',
                '../admin/index.php?action=almacen&c=VehiculoData&a=8&t=factura',
                '../admin/index.php?action=almacen&c=VehiculoData&a=9&t=factura',
                '../admin/index.php?action=almacen&c=VehiculoData&a=10&t=factura',
                '../admin/index.php?action=almacen&a=2&c=VehiculoData&t=jm_despacho_vehiculo'  
            ];
            
            const params = { ano: año, mes: mes };
            
            const requests = urls.map(url => 
                $.ajax({ url, method: 'GET', data: params, dataType: 'json', timeout: 20000 })
            );
            
            const responses = await Promise.all(requests);
            // console.log(responses); // Debugging descomentado si es necesario
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
                comparacionFacturas: responses[10]
            };
            
            this.cache[cacheKey] = { data, timestamp: Date.now() };
            this.procesarDatosDashboard(data, año, mes);
            
        } catch (error) {
            console.error('Error al cargar datos del dashboard:', error);
            $('#loadingIndicator').hide();
            this.showError('Error al cargar datos. Por favor, intente nuevamente.');
        }
    },

    tieneDatosValidos: function(data) {
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
    },

    mostrarMensajeSinDatos: function(mostrar = true) {
        const dashboardContent = $('.content-body .row');
        
        if (mostrar) {
            dashboardContent.find('.col-xl-4, .col-xl-12').hide();
            
            if (!$('#noDatosMessageAlmacen').length) { // ID único añadido aquí
                const noDatosHtml = `
                    <div id="noDatosMessageAlmacen" class="col-12">
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
            dashboardContent.find('.col-xl-4, .col-xl-12').show();
            $('#noDatosMessageAlmacen').remove();
        }
    },

    procesarDatosDashboard: function(data, año, mes) {
        console.log(data);
        $('#loadingIndicator').hide();
        
        try {
            if (!this.tieneDatosValidos(data)) {
                this.mostrarMensajeSinDatos(true);
                return;
            } else {
                this.mostrarMensajeSinDatos(false);
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

            // --- Procesar y actualizar la tarjeta de comparación de facturas ---
            if (data.comparacionFacturas && Array.isArray(data.comparacionFacturas) && data.comparacionFacturas.length > 0) {
                const comparacionData = data.comparacionFacturas[0];
                if (comparacionData.hasOwnProperty('emitidas') && comparacionData.hasOwnProperty('verificadas')) {
                    const emitidas = parseInt(comparacionData.emitidas, 10) || 0;
                    const verificadas = parseInt(comparacionData.verificadas, 10) || 0;
                    this.actualizarTarjetaComparacionFacturas(emitidas, verificadas);
                } else {
                    console.error("Propiedades 'emitidas' o 'verificadas' faltantes en los datos de comparación.");
                    this.actualizarTarjetaComparacionFacturas(0, 0);
                }
            } else {
                console.error("La respuesta de comparación de facturas no tiene el formato esperado.");
                this.actualizarTarjetaComparacionFacturas(0, 0);
            }
            
            // --- Actualizar tabla y gráficos ---
            this.actualizarTablaDetalles(data.despachosPorVehiculosInternos);
            this.actualizarTablaDetallesExterno(data.despachosPorVehiculosExternos);
            this.updateCharts(data);
        } catch (error) {
            console.error('Error al procesar datos:', error);
            this.showError('Error al procesar los datos recibidos');
        }
    },

    actualizarTarjetaComparacionFacturas: function(emitidas, verificadas) {
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
    },

    actualizarTablaDetalles: function(data) {
        console.log(data);
        let tablaHTML = '';
        const tablaDetallesElement = $('#tablaDetalles');
        const cardContainer = $('#cardTablaInterna');
        
        try {
            const noHayDatosValidos = !data || 
                                      !Array.isArray(data) || 
                                      data.length === 0 || 
                                      data.every(item => 
                                          parseInt(item.dato1) === 0 && 
                                          parseInt(item.dato2) === 0 && 
                                          parseInt(item.dato3) === 0
                                      );

            if (noHayDatosValidos) {
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
            cardContainer.show();
            
            const totalVehiculos = data.length;
            const totalViajes = data.reduce((sum, item) => sum + (parseInt(item.dato2) || 0), 0);
            const totalBultos = data.reduce((sum, item) => sum + (parseInt(item.dato3) || 0), 0);
            
            data.forEach((item, index) => {
                const vehiculoInfo = item.dato1 || 'Vehículo sin identificar';
                const viajes = parseInt(item.dato2) || 0;
                const bultos = parseInt(item.dato3) || 0;
                
                const porcentajeViajes = totalViajes > 0 ? (viajes / totalViajes * 100) : 0;
                const porcentajeBultos = totalBultos > 0 ? (bultos / totalBultos * 100) : 0;
                const contribucion = ((porcentajeViajes + porcentajeBultos) / 2).toFixed(2);
                
                let badgeClass = 'bg-secondary';
                if (contribucion > 15) badgeClass = 'bg-success';
                else if (contribucion > 7) badgeClass = 'bg-warning';
                
                tablaHTML += `
                    <tr>
                        <td>${vehiculoInfo}</td>
                        <td>${viajes.toLocaleString()} <span class="text-muted">(${porcentajeViajes.toFixed(2)}%)</span></td>
                        <td>${bultos.toLocaleString()} <span class="text-muted">(${porcentajeBultos.toFixed(2)}%)</span></td>
                        <td><span class="badge ${badgeClass}">${contribucion}%</span></td>
                    </tr>
                `;
            });
            
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
            cardContainer.hide(); 
            tablaDetallesElement.html('<tr><td colspan="4">Error al cargar los datos. Intente de nuevo.</td></tr>');
        }

        tablaDetallesElement.html(tablaHTML);
    },

    actualizarTablaDetallesExterno: function(data) {
        console.log("Datos para transporte externo:", data);
        let tablaHTML = '';
        const tablaDetallesElement = $('#tablaDetallesExterno');
        const cardContainer = $('#cardTablaExterna');

        try {
            const noHayDatosValidos = !data || 
                                      !Array.isArray(data) || 
                                      data.length === 0 || 
                                      data.every(item => 
                                          parseInt(item.dato1) === 0 && 
                                          parseInt(item.dato2) === 0 && 
                                          parseInt(item.dato3) === 0
                                      );
            if (noHayDatosValidos) {
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
            cardContainer.show();

            const totalVehiculos = data.length;
            const totalViajes = data.reduce((sum, item) => sum + (parseInt(item.dato2) || 0), 0);
            const totalBultos = data.reduce((sum, item) => sum + (parseInt(item.dato3) || 0), 0);
            
            data.forEach((item, index) => {
                const vehiculoInfo = item.dato1 || 'Vehículo sin identificar';
                const viajes = parseInt(item.dato2) || 0;
                const bultos = parseInt(item.dato3) || 0;
                
                const porcentajeViajes = totalViajes > 0 ? (viajes / totalViajes * 100) : 0;
                const porcentajeBultos = totalBultos > 0 ? (bultos / totalBultos * 100) : 0;
                const contribucion = ((porcentajeViajes + porcentajeBultos) / 2).toFixed(2);
                
                let badgeClass = 'bg-secondary';
                if (contribucion > 15) badgeClass = 'bg-success';
                else if (contribucion > 7) badgeClass = 'bg-warning';
                
                tablaHTML += `
                    <tr>
                        <td>${vehiculoInfo}</td>
                        <td>${viajes.toLocaleString()} <span class="text-muted">(${porcentajeViajes.toFixed(2)}%)</span></td>
                        <td>${bultos.toLocaleString()} <span class="text-muted">(${porcentajeBultos.toFixed(2)}%)</span></td>
                        <td><span class="badge ${badgeClass}">${contribucion}%</span></td>
                    </tr>
                `;
            });
            
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
    },

    updateCharts: function(data) {
        // NOTA: El código original hacía referencia a data.facturasRecibidas y data.facturasChequeadas
        // los cuales NO parecen estar en el objeto 'data' construido en 'obtenerDatosDashboard'.
        // He ajustado para usar los datos que sí están disponibles en 'data' o pongo 0 como fallback.
        
        const facturasData = {
            recibidas: 0, // No proviene de las URLs actuales, se asume 0 o se debe agregar la URL
            chequeadas: 0, // No proviene de las URLs actuales
            porContener: data.despachosPorVehiculosInternos && data.despachosPorVehiculosInternos[0] ? (parseInt(data.despachosPorVehiculosInternos[0].dato2) || 0) : 0, // Usando dato2 como ejemplo
            porDespachar: data.despachosPorVehiculosExternos && data.despachosPorVehiculosExternos[0] ? (parseInt(data.despachosPorVehiculosExternos[0].dato2) || 0) : 0, // Usando dato2 como ejemplo
            despachadas: data.facturasDespachadas[0] ? data.facturasDespachadas[0].dato1 || 0 : 0,
            anuladas: data.facturasAnuladas[0] ? data.facturasAnuladas[0].dato1 || 0 : 0
        };
        
        const enviosData = {
            ordenes: data.ordenesDespacho[0] ? data.ordenesDespacho[0].dato1 || 0 : 0,
            despachados: data.enviosDespachados[0] ? data.enviosDespachados[0].dato1 || 0 : 0,
            porDespachar: data.enviosPorDespachar[0] ? data.enviosPorDespachar[0].dato1 || 0 : 0,
            anulados: data.enviosAnulados[0] ? data.enviosAnulados[0].dato1 || 0 : 0
        };
        
        this.crearGraficoProgresoFacturas(facturasData);
        this.crearGraficoProgresoEnvios(enviosData);
    },

    crearGraficoProgresoFacturas: function(data) {
        const ctx = document.getElementById('progresoFacturasChart');
        
        if (this.charts.facturas) {
            this.charts.facturas.destroy();
        }
        
        this.charts.facturas = new Chart(ctx, {
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
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(23, 162, 184, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(23, 162, 184, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
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
                    legend: { position: 'bottom' },
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
    },

    crearGraficoProgresoEnvios: function(data) {
        const ctx = document.getElementById('progresoEnviosChart');
        
        if (this.charts.envios) {
            this.charts.envios.destroy();
        }
        
        this.charts.envios = new Chart(ctx, {
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
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
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
                    legend: { position: 'bottom' },
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
    },

    showError: function(message) {
        $('.error-message').remove();
        const errorHtml = `
            <div class="alert alert-danger error-message" role="alert">
                <i class="fas fa-exclamation-triangle"></i> ${message}
            </div>
        `;
        $('#dashboardContent').prepend(errorHtml);
    },

    clearCache: function() {
        this.cache = {};
        console.log('Cache limpiado (Almacén)');
    }
};

// Inicializar el dashboard cuando el documento esté listo
 $(document).ready(function() {
    DashboardAlmacen.init();
});

// Exponer funciones globales únicas para debugging si es necesario
window.clearDashboardCacheAlmacen = function() { DashboardAlmacen.clearCache(); };
window.getDashboardCacheAlmacen = function() { return DashboardAlmacen.cache; };