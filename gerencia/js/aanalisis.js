// Este IIFE (Immediately Invoked Function Expression) crea un ámbito privado
// para que ninguna variable o función entre en conflicto con otros scripts.
(function() {
    'use strict';

    // Variables globales DENTRO del ámbito privado
    let productsData = [];
    let currentData = [];
    let salesChart, distributionChart;
    let dataTable;
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

    // Inicialización
    $(document).ready(function() {
        // Solo se ejecuta si el contenedor principal existe en la página
        if ($('.i_articulo_ficha_analisis_ventas').length) {
            // Mostrar indicador de carga
            $('#analisis-loadingIndicator').show();
            
            // PASO 1: Inicializar el DataTable ANTES de cargar los datos
            setupDataTable();
            
            // PASO 2: Configurar los event listeners
            setupEventListeners();
            
            // PASO 3: Cargar los datos iniciales
            loadProductsData();
        }
    });

    function getTopProducts(products, limit = 5) {
        return [...products].sort((a, b) => b.total - a.total).slice(0, limit);
    }

    function loadProductsData() {
        const apiUrl = '../admin/index.php?action=articulos&tipo=1&accion=12&a=1&c=ArticuloData&t=art';

        $.ajax({
            url: apiUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    productsData = transformDataFromPHP(response);
                    currentData = [...productsData];
                    
                    populateProductFilter();
                    initializeCharts();
                    populateTable();
                    updateStats();
                } else {
                    console.log("La consulta no devolvió resultados.");
                    productsData = [];
                    currentData = [];
                    $('#analisis-tableBody').html('<tr><td colspan="9" class="text-center">No se encontraron datos para mostrar.</td></tr>');
                    if (salesChart) salesChart.destroy();
                    if (distributionChart) distributionChart.destroy();
                    updateStats();
                }
                
                $('#analisis-loadingIndicator').hide();
            },
            error: function(xhr, status, error) {
                $('#analisis-loadingIndicator').hide();
                showNotification('Error de conexión o del servidor: ' + error, 'error');
                console.error('Error al cargar datos:', xhr.responseText);
                $('#analisis-tableBody').html('<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos. Por favor, inténtelo de nuevo.</td></tr>');
            }
        });
    }

    function transformDataFromPHP(apiData) {
        const phpMonthKeys = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return apiData.map(product => {
            return {
                codigo: product.codigo,
                descripcion: product.descripcion,
                modelo: product.modelo,
                ultCompra: product.ultCompra,
                ultVenta: product.ultVenta,
                mesesAct: parseInt(product.mesesAct),
                total: parseFloat(product.total),
                promedio: parseFloat(product.promedio),
                ventas: phpMonthKeys.map(key => parseFloat(product[key] || 0))
            };
        });
    }

  function setupDataTable() {
    dataTable = $('#analisis-productsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-1',
                text: feather.icons['download'].toSvg({ class: 'font-small-4 me-1' }) + ' Exportar',
                buttons: [
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-1' }) + ' Copiar',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-1' }) + ' Excel',
                        className: 'dropdown-item',
                        filename: 'Reporte_Productos',
                        title: 'Reporte de Productos - Análisis de Ventas',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'all'
                            }
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c[r^="A"]', sheet).attr('s', '2'); // Estilo para la columna A
                        }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-1' }) + ' PDF',
                        className: 'dropdown-item',
                        filename: 'Reporte_Productos',
                        title: 'Reporte de Productos - Análisis de Ventas',
                        orientation: 'landscape',
                        pageSize: 'LETTER',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'all'
                            }
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.title.fontSize = 14;
                            doc.styles.title.alignment = 'center';
                            doc.styles.tableHeader.alignment = 'center';
                            doc.styles.tableHeader.fillColor = '#f8f9fa';
                            doc.styles.tableHeader.color = '#000';
                            
                            // Ajustar anchos de columnas
                            if (doc.content[1].table.body) {
                                doc.content[1].table.widths = 
                                    Array(doc.content[1].table.body[0].length).fill('*');
                                
                                // Agregar estilos a la primera fila (encabezados)
                                doc.content[1].table.body[0].forEach(function(cell) {
                                    cell.fillColor = '#005ee3ff'; // Color primario
                                    cell.color = '#ffffff';
                                    cell.bold = true;
                                });
                            }
                            
                            // Footer
                            doc.footer = function(page, pages) {
                                return {
                                    columns: [
                                        {
                                            alignment: 'left',
                                            text: 'Generado: ' + new Date().toLocaleDateString()
                                        },
                                        {
                                            alignment: 'right',
                                            text: 'Página ' + page.toString() + ' de ' + pages
                                        }
                                    ],
                                    margin: [10, 0]
                                };
                            };
                        }
                    },
                    {
                        extend: 'print',
                        text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-1' }) + ' Imprimir',
                        className: 'dropdown-item',
                        title: 'Reporte de Productos - Análisis de Ventas',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'all'
                            }
                        },
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend('<h2 style="text-align:center;color:#4f46e5;margin-top:20px;">Reporte de Productos</h2><h4 style="text-align:center;color:#6b7280;margin-bottom:20px;">Análisis de Ventas</h4>');
                            
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
            }
        ],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ resultados",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando resultados _START_-_END_ de  _TOTAL_",
            "sInfoEmpty": "Mostrando resultados del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "buttons": {
                "copy": "Copiar",
                "copyTitle": "Copiar al portapapeles",
                "copySuccess": {
                    "_": "Copiadas %d filas al portapapeles",
                    "1": "Copiada 1 fila al portapapeles"
                },
                "collection": "Exportar"
            }
        },
        initComplete: function() {
            feather.replace();
            
            // Asegurar que los íconos se rendericen correctamente
            setTimeout(() => {
                feather.replace();
                $('.dt-buttons .btn').each(function() {
                    $(this).addClass('me-1 mb-1');
                });
                
                // Asegurar que el dropdown funcione correctamente
                $('.dt-buttons .dropdown-toggle').dropdown();
            }, 300);
        },
        drawCallback: function() {
            feather.replace();
        }
    });
}

    function populateProductFilter() {
        const productFilter = $('#analisis-productFilter');
        productFilter.find('option:not(:first)').remove();
        productsData.forEach(product => {
            productFilter.append(`<option value="${product.codigo}">${product.descripcion}</option>`);
        });
    }

    function initializeCharts() {
        const topProducts = getTopProducts(currentData, 5);
        if (topProducts.length === 0) {
            console.log("No hay datos para mostrar en los gráficos.");
            return;
        }

        const maxValue = Math.max(...topProducts.flatMap(p => p.ventas));
        const yAxisMax = Math.ceil(maxValue * 1.1 / 100) * 100;

        if (salesChart) salesChart.destroy();
        if (distributionChart) distributionChart.destroy();

        const ctx1 = document.getElementById('analisis-salesChart').getContext('2d');
        salesChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: months,
                datasets: topProducts.map((product, index) => ({
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
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, padding: 15, font: { size: 11 } } },
                    tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, cornerRadius: 8, callbacks: { label: function(context) { return context.dataset.label + ': ' + context.parsed.y + ' unidades'; } } }
                },
                scales: {
                    y: { beginAtZero: true, max: yAxisMax, grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false }, ticks: { callback: function(value) { return value.toLocaleString(); }, font: { size: 11 }, color: '#6b7280' } },
                    x: { grid: { display: false, drawBorder: false }, ticks: { font: { size: 11 }, color: '#6b7280' } }
                },
                animation: { duration: 1000, easing: 'easeInOutQuart' }
            }
        });

        const ctx2 = document.getElementById('analisis-distributionChart').getContext('2d');
        distributionChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: topProducts.map(p => p.descripcion),
                datasets: [{ data: topProducts.map(p => p.total), backgroundColor: topProducts.map((_, index) => getColor(index)), borderWidth: 2, borderColor: '#fff', hoverOffset: 4 }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { padding: 15, usePointStyle: true, font: { size: 11 } } },
                    tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, cornerRadius: 8, callbacks: { label: function(context) { const total = context.dataset.data.reduce((a, b) => a + b, 0); const percentage = ((context.parsed / total) * 100).toFixed(1); return context.label + ': ' + context.parsed + ' (' + percentage + '%)'; } } }
                },
                animation: { animateRotate: true, animateScale: false, duration: 1000, easing: 'easeInOutQuart' }
            }
        });
    }

    function getColor(index, alpha = 1) {
        const colors = [`rgba(79, 70, 229, ${alpha})`, `rgba(124, 58, 237, ${alpha})`, `rgba(16, 185, 129, ${alpha})`, `rgba(245, 158, 11, ${alpha})`];
        return colors[index % colors.length];
    }

    function populateTable() {
        dataTable.clear();
        currentData.forEach(product => {
            const statusBadge = getStatusBadge(product);
            dataTable.row.add([
                product.codigo, product.descripcion, product.modelo,
                formatDate(product.ultCompra), formatDate(product.ultVenta),
                product.mesesAct, product.total.toLocaleString(),
                product.promedio.toFixed(2), statusBadge
            ]);
        });
        dataTable.draw();
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }

    function getStatusBadge(product) {
        if (product.promedio > 500) return '<span class="badge bg-success">Alto rendimiento</span>';
        if (product.promedio > 100) return '<span class="badge bg-warning">Rendimiento medio</span>';
        return '<span class="badge bg-danger">Bajo rendimiento</span>';
    }

    function updateStats() {
        if (currentData.length === 0) {
            $('#analisis-totalSales, #analisis-avgMonthly, #analisis-topProduct, #analisis-topProductName, #analisis-activeMonth, #analisis-activeMonthSales').text('-');
            return;
        }
        
        const totalSales = currentData.reduce((sum, p) => sum + p.total, 0);
        const avgMonthly = (totalSales / 12).toFixed(0);
        const topProduct = currentData.reduce((max, p) => p.total > max.total ? p : max, currentData[0]);
        
        const monthlyTotals = months.map((_, monthIndex) => currentData.reduce((sum, p) => sum + (p.ventas[monthIndex] || 0), 0));
        const maxMonthIndex = monthlyTotals.indexOf(Math.max(...monthlyTotals));
        const activeMonth = months[maxMonthIndex];
        const activeMonthSales = monthlyTotals[maxMonthIndex];

        $('#analisis-totalSales').text(totalSales.toLocaleString());
        $('#analisis-avgMonthly').text(parseInt(avgMonthly).toLocaleString());
        $('#analisis-topProduct').text(topProduct.codigo);
        $('#analisis-topProductName').text(topProduct.descripcion.length > 30 ? topProduct.descripcion.substring(0, 30) + '...' : topProduct.descripcion);
        $('#analisis-activeMonth').text(activeMonth);
        $('#analisis-activeMonthSales').text(activeMonthSales.toLocaleString() + ' unidades');
        $('#analisis-salesChange').text('+' + (Math.random() * 20).toFixed(1) + '%');
        $('#analisis-growthRate').text('+' + (Math.random() * 15).toFixed(1) + '%');
    }

    function setupEventListeners() {
        // Búsqueda en tiempo real
        $('#analisis-searchInput').on('input', function() {
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

        // Filtros de select
        $('#analisis-productFilter, #analisis-monthFilter').on('change', applyFilters);

        // Botones de filtros
        $('#analisis-applyFiltersBtn').on('click', applyFilters);
        $('#analisis-resetFiltersBtn').on('click', resetFilters);

        // Botones de tipo de gráfico
        $('.analisis-chart-type-btn').on('click', function() {
            changeChartType($(this).data('type'), this);
        });
        $('.analisis-pie-type-btn').on('click', function() {
            changePieType($(this).data('type'), this);
        });
    }

    function applyFilters() {
        const productFilter = $('#analisis-productFilter').val();
        const monthFilter = $('#analisis-monthFilter').val();
        const minSales = parseFloat($('#analisis-minSales').val()) || 0;
        const maxSales = parseFloat($('#analisis-maxSales').val()) || Infinity;

        let filtered = [...productsData];
        if (productFilter !== 'all') filtered = filtered.filter(p => p.codigo === productFilter);
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
        $('#analisis-productFilter, #analisis-monthFilter').val('all');
        $('#analisis-minSales, #analisis-maxSales, #analisis-searchInput').val('');
        currentData = [...productsData];
        populateTable();
        updateCharts();
        updateStats();
    }

    function updateCharts() {
        initializeCharts();
    }

    function changeChartType(type, button) {
        $('.analisis-chart-type-btn').removeClass('active');
        $(button).addClass('active');
        if (type === 'area') {
            salesChart.config.type = 'line';
            salesChart.data.datasets.forEach(dataset => { dataset.fill = true; });
        } else {
            salesChart.config.type = type;
            salesChart.data.datasets.forEach(dataset => { dataset.fill = false; });
        }
        salesChart.update();
    }

    function changePieType(type, button) {
        $('.analisis-pie-type-btn').removeClass('active');
        $(button).addClass('active');
        distributionChart.config.type = type;
        distributionChart.update();
    }

    function showNotification(message, type = 'success') {
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        const notification = $(`
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                <div class="toast show align-items-center text-white ${bgClass} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body"><i data-feather="${icon}" class="me-2"></i>${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `);
        $('body').append(notification);
        feather.replace();
        setTimeout(() => notification.fadeOut(300, function() { $(this).remove(); }), 3000);
    }

})();