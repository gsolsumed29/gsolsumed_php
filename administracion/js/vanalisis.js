(function() {
    'use strict';

    let sellersData = [];
    let currentData = [];
    let kpiTable;
    
    // Endpoint actualizado (ya incluye el nuevo dato desde el PHP)
    const apiUrl = '../admin/index.php?action=vendedores&tipo=1&accion=1&datos=3&c=VendedorData&a=1&t=vendedor';

    $(document).ready(function() {
        if ($('.i_vendedor_ficha_analisis_visitas').length) {
            setupDataTable();
           // setupEventListeners();
            loadSellersData();
        }
    });

    function loadSellersData() {
        $.ajax({
            url: apiUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    sellersData = transformData(response);
                    currentData = [...sellersData];
                    
                    populateSellerFilter();
                    updateDashboard();
                    populateTable();
                } else {
                    console.log("La respuesta no contiene array de vendedores.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $('#visita-kpiTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Error cargando datos</td></tr>'); // Aumenté colspan a 6
            }
        });
    }

    // MAPEO Y CARGA DE DATOS
    function transformData(apiData) {
        return apiData.map(seller => {
            // Datos base (Reales del JSON actual)
            const baseVisitasCortas = parseInt(seller.cantidad_visitas_clientes_cortas || 0);
            const baseCandidatosVisitados = parseInt(seller.cantidad_visitas_candidatos || 0);
            const baseCandidatosRegistrados = parseInt(seller.cantidad_registro_candidatos || 0);
            
            // NUEVO: Agregamos la lectura del dato de visitas cliente
            const baseVisitasCliente = parseInt(seller.cantidad_visitas_cliente || 0);
            
            const baseCandidatosVisitas = parseInt(seller.data2 || 0);
            const baseClientesVisitas = parseInt(seller.data1 || 0);

            return {
                codigo: seller.co_ven,
                nombre: seller.ven_des,
                zona: seller.direc1 || "Sin Zona",
                
                // Guardamos los valores base
                visitasCortas: baseVisitasCortas,
                candidatosVisitados: baseCandidatosVisitados,
                candidatosRegistrados: baseCandidatosRegistrados,
                metaVisitas: baseCandidatosVisitas,
                metaVisitasClientes: baseClientesVisitas,
                
                // NUEVO: Guardamos en el objeto temporal
                visitasCliente: baseVisitasCliente,
               
            };
        });
    }

    function setupDataTable() {
        kpiTable = $('#visita-kpiTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            columnDefs: [
                {
                    targets: 5,
                    visible: false
                  },
            ],
            order: [[1, 'desc']], 
            language: { 
                "sZeroRecords": "No hay datos disponibles", 
                "oPaginate": { "sNext": ">", "sPrevious": "<" } 
            },
            drawCallback: function(settings) {
                // Lógica visual opcional
            }
        });
    }

    function populateSellerFilter() {
        const filter = $('#visita-vendedorFilter');
        filter.find('option:not(:first)').remove();
        sellersData.forEach(s => {
            filter.append(`<option value="${s.codigo}">${s.nombre}</option>`);
        });
    }

    // FUNCIÓN CENTRAL DE ACTUALIZACIÓN
    function updateDashboard() {
        if (currentData.length === 0) return;

        // 1. Calcular Totales
        const totalVisitasCortas = currentData.reduce((sum, s) => sum + s.visitasCortas, 0);
        const totalCandidatosVisitados = currentData.reduce((sum, s) => sum + s.candidatosVisitados, 0);
        const totalRegistrados = currentData.reduce((sum, s) => sum + s.candidatosRegistrados, 0);
        
        // NUEVO: Calcular total de visitas cliente
        const totalVisitasCliente = currentData.reduce((sum, s) => sum + s.visitasCliente, 0);

        const totalEntrevistas = Math.floor(totalCandidatosVisitados * 0.6);

        // Planificación
        const totalMeta = currentData.reduce((sum, s) => sum + s.metaVisitas, 0);
        const avgCumplimiento = totalMeta > 0 ? ((totalCandidatosVisitados / totalMeta) * 100).toFixed(1) : 0;

        const totalMetaClientes = currentData.reduce((sum, s) => sum + s.metaVisitasClientes, 0);
        const avgCumplimientoClientes = totalMetaClientes > 0 ? ((totalVisitasCortas / totalMetaClientes) * 100).toFixed(1) : 0;

        // 2. Actualizar DOM (Tarjetas Superiores)
        $('#kpi-visitasCortas').text(totalVisitasCortas);
        $('#kpi-entrevistas').text(totalCandidatosVisitados);
        $('#kpi-candidatosRegistrados').text(totalRegistrados);
        $('#kpi-nuevosCandidatos').text(totalCandidatosVisitados); 

        // NUEVO: Descomenta la línea de abajo si tienes un elemento con id="kpi-visitasCliente" en tu HTML
        // $('#kpi-visitasCliente').text(totalVisitasCliente);

        $('#plan-metaVisitas').text(totalMeta);
        $('#plan-cumplimiento').text(avgCumplimiento + '%');

        
        $('#cortas-metaVisitas').text(totalMetaClientes);
        $('#cortas-cumplimiento').text(avgCumplimientoClientes + '%');
        
        const barWidth = Math.min(Math.max(avgCumplimiento, 0), 100);
        $('#plan-progresoVisitas').css('width', barWidth + '%');
        $('#plan-barraCumplimiento').css('width', barWidth + '%');

        const barWidthClientes = Math.min(Math.max(avgCumplimientoClientes, 0), 100);
        $('#cortas-progresoVisitas').css('width', barWidthClientes + '%');
        $('#cortas-barraCumplimiento').css('width', barWidthClientes + '%');

        // Texto dinámico (Sin cambios)
        let obsText = "";
        if (avgCumplimiento > 90) obsText = "Excelente cumplimiento. El equipo está superando las expectativas.";
        else if (avgCumplimiento > 75) obsText = "Buen cumplimiento. Mantener el ritmo de visitas.";
        else if (avgCumplimiento > 50) obsText = "Cumplimiento moderado. Se sugiere revisar la asignación de rutas.";
        else obsText = "Bajo cumplimiento. Requerida intervención inmediata en la planificación.";
        $('#plan-observaciones').text(obsText);

        let obsTextClientes = "";
        if (avgCumplimientoClientes > 90) obsTextClientes = "Excelente cumplimiento. El equipo está superando las expectativas.";
        else if (avgCumplimientoClientes > 75) obsTextClientes = "Buen cumplimiento. Mantener el ritmo de visitas.";
        else if (avgCumplimiento > 50) obsTextClientes = "Cumplimiento moderado. Se sugiere revisar la asignación de rutas.";
        else obsTextClientes = "Bajo cumplimiento. Requerida intervención inmediata en la planificación.";
        $('#cortas-observaciones').text(obsTextClientes);
    }

    function populateTable() {
        kpiTable.clear();
        currentData.forEach(s => {
            const entrevistasInd = s.candidatosVisitados;

            // NUEVO: Agregamos s.visitasCliente en el array. 
            // OJO: Esto requiere que hayas agregado un <th> en el HTML de la tabla.
            kpiTable.row.add([
                `<div>
                    <div class="fw-bold">${s.nombre}</div>
                    <small class="text-muted">${s.codigo}</small>
                 </div>`,
                s.visitasCortas,
                s.visitasCliente, // NUEVA COLUMNA
                entrevistasInd,
                s.candidatosRegistrados,
                s.candidatosVisitados
            ]);
        });
        kpiTable.draw();
    }

    function setupEventListeners() {
        $('#visita-vendedorFilter').on('change', function() {
            applyFilters();
        });

        $('#visita-monthFilter').on('change', function() {
            applyFilters();
        });

        $('#visita-applyFiltersBtn').on('click', function() {
            applyFilters();
            const btn = $(this);
            const originalText = btn.html();
            btn.html('<i data-feather="check"></i> Filtrado');
            feather.replace();
            setTimeout(() => {
                btn.html(originalText);
                feather.replace();
            }, 1000);
        });
    }

    function applyFilters() {
        const vendedorCode = $('#visita-vendedorFilter').val();
        const mesValue = $('#visita-monthFilter').val(); 

        let filtered = sellersData;
        if (vendedorCode !== 'all') {
            filtered = sellersData.filter(s => s.codigo === vendedorCode);
        }

        // Simulación por mes
        if (mesValue !== 'all') {
            const monthIndex = parseInt(mesValue); 
            filtered = filtered.map(seller => {
                let factor = 1.0;

                if ([1, 2, 8].includes(monthIndex)) factor = 0.7; 
                else if ([11, 12].includes(monthIndex)) factor = 1.3;
                else factor = 1.0;

                return {
                    ...seller,
                    visitasCortas: Math.floor(seller.visitasCortas * factor),
                    // NUEVO: Aplicar factor a visitas cliente también
                    visitasCliente: Math.floor(seller.visitasCliente * factor),
                    candidatosVisitados: Math.floor(seller.candidatosVisitados * factor),
                    candidatosRegistrados: Math.floor(seller.candidatosRegistrados * factor)
                };
            });
        }

        currentData = filtered;
        updateDashboard();
        populateTable();
    }

})();