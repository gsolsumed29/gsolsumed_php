
        // Datos de productos
        const productsData = [
            {
                codigo: '000706',
                descripcion: 'ADHrESIVO MICROPORE 2" 10 YDS COLOR BLANCO',
                modelo: '3M',
                ultCompra: '2025-11-20',
                ultVenta: '2025-12-18',
                mesesAct: 8,
                ventas: [0, 0, 12, 1164, 1119, 105, 0, 0, 984, 1176, 8, 1017],
                total: 5585,
                promedio: 698.13
            },
              {
                codigo: '000086',
                descripcion: 'ADHESIVO MICR77878OPORE 2" 10 YDS COLOR BLANCO',
                modelo: '3M',
                ultCompra: '2025-11-20',
                ultVenta: '2025-12-18',
                mesesAct: 8,
                ventas: [0, 0, 12, 1164, 1119, 105, 0, 0, 984, 1176, 8, 1017],
                total: 5585,
                promedio: 698.13
            },
              {
                codigo: '00889978006',
                descripcion: 'ADHESIVO MICRO878787PORE 2" 10 YDS COLOR BLANCO',
                modelo: '3M',
                ultCompra: '2025-11-20',
                ultVenta: '2025-12-18',
                mesesAct: 8,
                ventas: [0, 0, 12, 1164, 1119, 105, 0, 0, 984, 1176, 8, 1017],
                total: 5585,
                promedio: 698.13
            },
              {
                codigo: '00009987806',
                descripcion: 'ADHESIVO MICR876867OPORE 2" 10 YDS COLOR BLANCO',
                modelo: '3M',
                ultCompra: '2025-11-20',
                ultVenta: '2025-12-18',
                mesesAct: 8,
                ventas: [0, 0, 12, 1164, 1119, 105, 0, 0, 984, 1176, 8, 1017],
                total: 5585,
                promedio: 698.13
            },
            {
                codigo: '00008',
                descripcion: 'ADHESIVO MICROPORE 3" 10 YDS COLOR BLANCO',
                modelo: '3M',
                ultCompra: '2025-11-20',
                ultVenta: '2025-12-17',
                mesesAct: 8,
                ventas: [265, 0, 0, 138, 162, 184, 415, 455, 246, 0, 0, 280],
                total: 2145,
                promedio: 268.13
            },
            {
                codigo: '00010',
                descripcion: 'ADHESIVO TRANSPORE 3" 10 YDS COLOR BLANCO',
                modelo: '3M',
                ultCompra: '2025-03-28',
                ultVenta: '2025-12-03',
                mesesAct: 12,
                ventas: [24, 28, 3, 5, 53, 12, 24, 17, 12, 92, 16, 10],
                total: 296,
                promedio: 24.67
            },
            {
                codigo: '00014',
                descripcion: 'AGUA OXIGENADA GALON 3.75 L',
                modelo: 'ALNA',
                ultCompra: '2025-09-15',
                ultVenta: '2025-12-17',
                mesesAct: 12,
                ventas: [30, 40, 5, 21, 25, 38, 33, 26, 16, 19, 26, 24],
                total: 303,
                promedio: 25.25
            }
        ];

        const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        
        let salesChart, distributionChart;
        let currentData = [...productsData];

        // Inicialización
        $(document).ready(function() {
            initializeCharts();
            populateTable();
            updateStats();
            setupEventListeners();
        });

        function initializeCharts() {
            // Calcular el valor máximo para el escalado del eje Y
            const maxValue = Math.max(...currentData.flatMap(p => p.ventas));
            const yAxisMax = Math.ceil(maxValue * 1.1 / 100) * 100; // Redondear al siguiente centena

            // Gráfico de líneas de ventas mensuales
            const ctx1 = document.getElementById('salesChart').getContext('2d');
            salesChart = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: currentData.map((product, index) => ({
                        label: product.descripcion,
                        data: product.ventas,
                        borderColor: getColor(index),
                        backgroundColor: getColor(index, 0.1),
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' unidades';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: yAxisMax,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                },
                                font: {
                                    size: 11
                                },
                                color: '#6b7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#6b7280'
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            // Gráfico de distribución
            const ctx2 = document.getElementById('distributionChart').getContext('2d');
            distributionChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: currentData.map(p => p.descripcion),
                    datasets: [{
                        data: currentData.map(p => p.total),
                        backgroundColor: currentData.map((_, index) => getColor(index)),
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: false,
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        function getColor(index, alpha = 1) {
            const colors = [
                `rgba(79, 70, 229, ${alpha})`,
                `rgba(124, 58, 237, ${alpha})`,
                `rgba(16, 185, 129, ${alpha})`,
                `rgba(245, 158, 11, ${alpha})`
            ];
            return colors[index % colors.length];
        }

        function populateTable() {
            const tbody = $('#tableBody');
            tbody.empty();

            currentData.forEach(product => {
                const row = `
                    <tr>
                        <td class="product-code">${product.codigo}</td>
                        <td class="product-name" title="${product.descripcion}">${product.descripcion}</td>
                        <td>${product.modelo}</td>
                        <td>${formatDate(product.ultCompra)}</td>
                        <td>${formatDate(product.ultVenta)}</td>
                        <td>${product.mesesAct}</td>
                        <td><strong>${product.total.toLocaleString()}</strong></td>
                        <td>${product.promedio.toFixed(2)}</td>
                        <td>${getStatusBadge(product)}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }

        function getStatusBadge(product) {
            if (product.promedio > 500) {
                return '<span class="badge badge-success">Alto rendimiento</span>';
            } else if (product.promedio > 100) {
                return '<span class="badge badge-warning">Rendimiento medio</span>';
            } else {
                return '<span class="badge badge-warning">Bajo rendimiento</span>';
            }
        }

        function updateStats() {
            const totalSales = currentData.reduce((sum, p) => sum + p.total, 0);
            const avgMonthly = (totalSales / 12).toFixed(0);
            const topProduct = currentData.reduce((max, p) => p.total > max.total ? p : max, currentData[0]);
            
            // Encontrar el mes más activo
            const monthlyTotals = months.map((_, monthIndex) => 
                currentData.reduce((sum, p) => sum + (p.ventas[monthIndex] || 0), 0)
            );
            const maxMonthIndex = monthlyTotals.indexOf(Math.max(...monthlyTotals));
            const activeMonth = months[maxMonthIndex];
            const activeMonthSales = monthlyTotals[maxMonthIndex];

            $('#totalSales').text(totalSales.toLocaleString());
            $('#avgMonthly').text(parseInt(avgMonthly).toLocaleString());
            $('#topProduct').text(topProduct.codigo);
            $('#topProductName').text(topProduct.descripcion.substring(0, 30) + '...');
            $('#activeMonth').text(activeMonth);
            $('#activeMonthSales').text(activeMonthSales.toLocaleString() + ' unidades');
        }

        function setupEventListeners() {
            // Búsqueda en tiempo real
            $('#searchInput').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                const filtered = productsData.filter(p => 
                    p.codigo.toLowerCase().includes(searchTerm) ||
                    p.descripcion.toLowerCase().includes(searchTerm) ||
                    p.modelo.toLowerCase().includes(searchTerm)
                );
                currentData = filtered;
                populateTable();
                updateCharts();
                updateStats();
            });

            // Filtros
            $('#productFilter, #monthFilter').on('change', function() {
                applyFilters();
            });
        }

        function applyFilters() {
            const productFilter = $('#productFilter').val();
            const monthFilter = $('#monthFilter').val();
            const minSales = $('#minSales').val() || 0;
            const maxSales = $('#maxSales').val() || Infinity;

            let filtered = [...productsData];

            if (productFilter !== 'all') {
                filtered = filtered.filter(p => p.codigo === productFilter);
            }

            if (monthFilter !== 'all') {
                const monthIndex = parseInt(monthFilter) - 1;
                filtered = filtered.filter(p => p.ventas[monthIndex] > 0);
            }

            filtered = filtered.filter(p => p.total >= minSales && p.total <= maxSales);

            currentData = filtered;
            populateTable();
            updateCharts();
            updateStats();
        }

        function resetFilters() {
            $('#productFilter').val('all');
            $('#monthFilter').val('all');
            $('#minSales').val('');
            $('#maxSales').val('');
            $('#searchInput').val('');
            
            currentData = [...productsData];
            populateTable();
            updateCharts();
            updateStats();
        }

        function updateCharts() {
            // Destruir gráficos existentes
            if (salesChart) {
                salesChart.destroy();
            }
            if (distributionChart) {
                distributionChart.destroy();
            }
            
            // Recrear gráficos con nuevos datos
            initializeCharts();
        }

        function changeChartType(type, button) {
            $('.chart-option').removeClass('active');
            $(button).addClass('active');

            if (type === 'area') {
                salesChart.config.type = 'line';
                salesChart.data.datasets.forEach(dataset => {
                    dataset.fill = true;
                });
            } else {
                salesChart.config.type = type;
                salesChart.data.datasets.forEach(dataset => {
                    dataset.fill = false;
                });
            }
            salesChart.update();
        }

        function changePieType(type, button) {
            $('.chart-option').removeClass('active');
            $(button).addClass('active');
            distributionChart.config.type = type;
            distributionChart.update();
        }

        function sortTable(columnIndex) {
            const sortKeys = ['codigo', 'descripcion', 'modelo', 'ultCompra', 'ultVenta', 'mesesAct', 'total', 'promedio'];
            const sortKey = sortKeys[columnIndex];
            
            currentData.sort((a, b) => {
                if (typeof a[sortKey] === 'string') {
                    return a[sortKey].localeCompare(b[sortKey]);
                }
                return a[sortKey] - b[sortKey];
            });
            
            populateTable();
        }

        function exportData() {
            $('.loading').show();
            
            setTimeout(() => {
                let csv = 'Código,Descripción,Modelo,Última Compra,Última Venta,Meses Activos,' +
                         months.join(',') + ',Total,Promedio\n';
                
                currentData.forEach(product => {
                    csv += `${product.codigo},"${product.descripcion}",${product.modelo},${product.ultCompra},` +
                           `${product.ultVenta},${product.mesesAct},${product.ventas.join(',')},` +
                           `${product.total},${product.promedio}\n`;
                });
                
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `reporte_ventas_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                
                $('.loading').hide();
                
                // Mostrar notificación de éxito
                showNotification('Reporte exportado exitosamente');
            }, 1000);
        }

        function showNotification(message) {
            const notification = $(`
                <div style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: var(--success-color);
                    color: white;
                    padding: 15px 20px;
                    border-radius: 8px;
                    box-shadow: var(--shadow);
                    z-index: 10000;
                    animation: slideInRight 0.3s ease;
                ">
                    <i class="fas fa-check-circle"></i> ${message}
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(() => {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
