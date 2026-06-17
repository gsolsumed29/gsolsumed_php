  // ==========================================
        // 1. UTILIDADES (PROVISTAS EN TU CÓDIGO)
        // ==========================================
        
        /**
         * Formatea una fecha de YYYY-MM-DD a DD/MM/YYYY
         */
        function formatFechaGlobal(fecha) {
          if (!fecha) return '';
          
          // Si ya tiene formato DD/MM/YYYY, devolverla tal cual
          if (fecha.includes('/')) return fecha;

          // Esperamos formato YYYY-MM-DD
          const partes = fecha.split('-');
          if (partes.length === 3) {
            // Devolvemos DD/MM/YYYY
            return `${partes[2]}/${partes[1]}/${partes[0]}`;
          }
          
          return fecha; // Fallback
        }

        function formatoEuropeo(numero) {
            return new Intl.NumberFormat('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(numero);
        }

        // ==========================================
        // 2. DATOS SIMULADOS (MOCK DATA)
        // ==========================================
        
        /* 
           En tu sistema real, esta información proviene de tu función 
           'cargarTablaFacturasCliente' o del AJAX response.
        */
        const dataFacturasDemo = [
            {
                nro_doc: "F001-0000154",
                cli_des: "NUVI SHOP C.A",
                fec_emis: "2023-10-01",
                monto: 1500.00,
                // 0: Pendiente, 1: Facturación, 2: Embalaje, 3: Embarco, 4: Entregado
                status_tracking: 1, 
                tracking_dates: {
                    pedido: "2023-09-28",
                    facturacion: "2023-10-01",
                    embalaje: null,
                    embarco: null,
                    entrega: null
                }
            },
            {
                nro_doc: "F001-0000155",
                cli_des: "NUVI SHOP C.A",
                fec_emis: "2023-10-05",
                monto: 320.50,
                status_tracking: 3, 
                tracking_dates: {
                    pedido: "2023-10-02",
                    facturacion: "2023-10-05",
                    embalaje: "2023-10-06",
                    embarco: "2023-10-08",
                    entrega: null
                }
            },
            {
                nro_doc: "F001-0000158",
                cli_des: "NUVI SHOP C.A",
                fec_emis: "2023-10-10",
                monto: 5420.00,
                status_tracking: 4, 
                tracking_dates: {
                    pedido: "2023-10-09",
                    facturacion: "2023-10-10",
                    embalaje: "2023-10-11",
                    embarco: "2023-10-12",
                    entrega: "2023-10-14"
                }
            }
        ];

        // Definición de los pasos del timeline
        const timelineSteps = [
            { key: 'pedido', label: 'Pedido' },
            { key: 'facturacion', label: 'Facturación' },
            { key: 'embalaje', label: 'Embalaje' },
            { key: 'embarco', label: 'Embarco' },
            { key: 'entrega', label: 'Entrega' }
        ];

        // Estado actual
        let currentInvoiceIndex = 0;

        // ==========================================
        // 3. LÓGICA DE FUNCIONALIDAD
        // ==========================================

        $(document).ready(function() {
            
            // Cargar la primera factura por defecto
            renderDashboard(currentInvoiceIndex);

            // Evento: Botón "Refresh" / Siguiente Factura
            $('.btn-refresh-facturas').on('click', function() {
                currentInvoiceIndex = (currentInvoiceIndex + 1) % dataFacturasDemo.length;
                renderDashboard(currentInvoiceIndex);
                
                // Animación visual simple de feedback
                const icon = $(this).find('svg');
                icon.css('transform', 'rotate(360deg)');
                setTimeout(() => icon.css('transform', 'rotate(0deg)', 500));
            });

            // Evento: Botón Editar / Ver Detalles
            $('.btn-editar-factura').on('click', function() {
                const factura = dataFacturasDemo[currentInvoiceIndex];
                
                // Usamos console para el feedback, ya que no se usan alerts nativos
                console.log("Modo edición activado para:", factura.nro_doc);
                
                // Efecto visual en el botón
                $(this).addClass('btn-success').removeClass('btn-primary');
                const originalText = $(this).html();
                $(this).html('<span>Guardado!</span>');
                
                setTimeout(() => {
                    $(this).removeClass('btn-success').addClass('btn-primary');
                    $(this).html(originalText);
                }, 1000);
            });
        });

        /**
         * Función principal que renderiza toda la vista (Izquierda y Derecha)
         */
        function renderDashboard(index) {
            const factura = dataFacturasDemo[index];
            
            // 1. Renderizar Tarjeta Izquierda (Resumen)
            renderSummaryCard(factura);
            
            // 2. Renderizar Tarjeta Derecha (Timeline)
            renderTimeline(factura);
        }

        /**
         * Renderiza los datos de la factura en la tarjeta izquierda
         */
        function renderSummaryCard(factura) {
            $('#lbl-nro-factura').text(factura.nro_doc).addClass('text-primary');
            $('#lbl-cliente').text(factura.cli_des);
            $('#lbl-fecha').text('Emisión: ' + formatFechaGlobal(factura.fec_emis));
            $('#lbl-monto').text('$' + formatoEuropeo(factura.monto));

            // Lógica para el Badge de estado
            const statusBadge = $('#lbl-estado-badge');
            const statusMap = {
                0: { text: 'Pedido Iniciado', class: 'status-pending' },
                1: { text: 'Facturado', class: 'status-pending' },
                2: { text: 'En Proceso', class: 'status-pending' },
                3: { text: 'En Ruta', class: 'status-pending' },
                4: { text: 'Entregado', class: 'status-completed' }
            };
            
            const statusInfo = statusMap[factura.status_tracking] || statusMap[0];
            statusBadge.text(statusInfo.text).removeClass('status-pending status-completed').addClass(statusInfo.class);
        }

        /**
         * Renderiza el Timeline vertical en la tarjeta derecha
         */
        function renderTimeline(factura) {
            const $container = $('#timeline-container');
            $container.empty(); // Limpiar contenido previo

            const currentStatusLevel = factura.status_tracking; // 0 a 4

            timelineSteps.forEach((step, index) => {
                const stepDate = factura.tracking_dates[step.key] || '';
                const formattedDate = formatFechaGlobal(stepDate);

                // Determinar el estado visual del paso
                let dotClass = 'pending';
                let opacityClass = 'opacity-50'; // Por defecto tenue si no pasó
                
                // Icono SVG base (Checkmark)
                const svgIcon = `<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M8.43994 12.0002L10.8139 14.3732L15.5599 9.6272" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>`;

                if (index < currentStatusLevel) {
                    // Pasos completados
                    dotClass = 'completed';
                    opacityClass = '';
                } else if (index === currentStatusLevel) {
                    // Paso actual
                    dotClass = 'active';
                    opacityClass = '';
                } else {
                    // Pasos futuros
                    dotClass = 'pending';
                    opacityClass = 'opacity-50';
                }

                // Construir el HTML del item
                const liHTML = `
                    <li class="${opacityClass} transition-all">
                        <div class="timeline-dots1 border-primary text-primary ${dotClass}">
                            ${svgIcon}
                        </div>
                        <h6 class="float-left mb-1">${step.label}</h6>
                        <small class="float-right mt-1">${formattedDate}</small>
                        <div class="d-inline-block w-100">                         
                        </div>
                    </li>
                `;

                $container.append(liHTML);
            });
        }