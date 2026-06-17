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
                $('#visita-kpiTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Error cargando datos</td></tr>');
            }
        });
    }

    // MAPEO Y CARGA DE DATOS
    function transformData(apiData) {
        return apiData.map(seller => {
            const baseVisitasCortas = parseInt(seller.cantidad_visitas_clientes_cortas || 0);
            const baseCandidatosVisitados = parseInt(seller.cantidad_visitas_candidatos || 0);
            const baseCandidatosRegistrados = parseInt(seller.cantidad_registro_candidatos || 0);
            const baseVisitasCliente = parseInt(seller.cantidad_visitas_cliente || 0);
            const baseCandidatosVisitas = parseInt(seller.data2 || 0);
            const baseClientesVisitas = parseInt(seller.data1 || 0);

            return {
                codigo: seller.co_ven,
                nombre: seller.ven_des,
                zona: seller.direc1 || "Sin Zona",
                visitasCortas: baseVisitasCortas,
                candidatosVisitados: baseCandidatosVisitados,
                candidatosRegistrados: baseCandidatosRegistrados,
                metaVisitas: baseCandidatosVisitas,
                metaVisitasClientes: baseClientesVisitas,
                visitasCliente: baseVisitasCliente,
            };
        });
    }

    // === SOLO UNA DEFINICIÓN DE setupDataTable() ===
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
            order: [[1, 'asc']], 
            language: { 
                "sZeroRecords": "No hay datos disponibles", 
                "oPaginate": { "sNext": ">", "sPrevious": "<" } 
            },
            drawCallback: function(settings) {
                // Lógica visual opcional
            }
        });

        // Configurar los manejadores de eventos para los enlaces
        setupStatLinks();
    }

    function setupStatLinks() {
        // Usar delegación de eventos porque la tabla se actualiza dinámicamente
        $(document).on('click', '.stat-link', function(e) {
            e.preventDefault();
            
            const stat = $(this).data('stat');
            const codigo = $(this).data('codigo');
            const nombre = $(this).data('nombre');
            const valor = $(this).text();
            
            console.log(`Click en estadística: ${stat}`, {codigo, nombre, valor});
            
            // Aquí puedes definir qué hacer según la estadística clickeada
            switch(stat) {
                case 'visitasCortas':
                    //console.log(`Ver visitas cortas de ${nombre} (${codigo}): ${valor}`);
                   // window.location.href = `index.php?view=rvisitas&tipo=1&co_ven=${codigo}`;
                    break;
                case 'visitasCliente':
                  // window.location.href = `index.php?view=rvisitas&tipo=2&co_ven=${codigo}`;
                    break;
                case 'entrevistas':
                  //   window.location.href = `index.php?view=rvisitas&tipo=3&co_ven=${codigo}`;
                    break;
                case 'registrados':
                  // window.location.href = `index.php?view=rvisitas&tipo=4&co_ven=${codigo}`;
                    break;
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

    function updateDashboard() {
        if (currentData.length === 0) return;

        const totalVisitasCortas = currentData.reduce((sum, s) => sum + s.visitasCortas, 0);
        const totalCandidatosVisitados = currentData.reduce((sum, s) => sum + s.candidatosVisitados, 0);
        const totalRegistrados = currentData.reduce((sum, s) => sum + s.candidatosRegistrados, 0);
        const totalVisitasCliente = currentData.reduce((sum, s) => sum + s.visitasCliente, 0);
        const totalEntrevistas = Math.floor(totalCandidatosVisitados * 0.6);

        const totalMeta = currentData.reduce((sum, s) => sum + s.metaVisitas, 0);
        const avgCumplimiento = totalMeta > 0 ? ((totalCandidatosVisitados / totalMeta) * 100).toFixed(1) : 0;

        const totalMetaClientes = currentData.reduce((sum, s) => sum + s.metaVisitasClientes, 0);
        const avgCumplimientoClientes = totalMetaClientes > 0 ? ((totalVisitasCortas / totalMetaClientes) * 100).toFixed(1) : 0;

        $('#kpi-visitasCortas').text(totalVisitasCortas);
        $('#kpi-entrevistas').text(totalCandidatosVisitados);
        $('#kpi-candidatosRegistrados').text(totalRegistrados);
        $('#kpi-nuevosCandidatos').text(totalCandidatosVisitados); 
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

            const visitasCortasLink = s.visitasCortas > 0 
                ? `<a href="#" class="stat-link" data-stat="visitasCortas" data-codigo="${s.codigo}" data-nombre="${s.nombre}">${s.visitasCortas}</a>` 
                : s.visitasCortas;
                
            const visitasClienteLink = s.visitasCliente > 0 
                ? `<a href="#" class="stat-link" data-stat="visitasCliente" data-codigo="${s.codigo}" data-nombre="${s.nombre}">${s.visitasCliente}</a>` 
                : s.visitasCliente;
                
            const entrevistasLink = entrevistasInd > 0 
                ? `<a href="#" class="stat-link" data-stat="entrevistas" data-codigo="${s.codigo}" data-nombre="${s.nombre}">${entrevistasInd}</a>` 
                : entrevistasInd;
                
            const registradosLink = s.candidatosRegistrados > 0 
                ? `<a href="#" class="stat-link" data-stat="registrados" data-codigo="${s.codigo}" data-nombre="${s.nombre}">${s.candidatosRegistrados}</a>` 
                : s.candidatosRegistrados;

            kpiTable.row.add([
                `<div>
                    <div class="fw-bold">${s.nombre}</div>
                    <small class="text-muted">${s.codigo}</small>
                 </div>`,
                visitasCortasLink,
                visitasClienteLink,
                entrevistasLink,
                registradosLink,
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