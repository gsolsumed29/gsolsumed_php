// Datos de ejemplo para la demostración
const datosEjemplo = [
    {
        codigo: "ART001",
        descripcion: "Producto A",
        categoria: "Electrónicos",
        preciosSistema: {1: 150.00, 2: 140.00, 3: 130.00, 4: 120.00},
        proveedores: [
            {nombre: "Proveedor A", precio: 145.00, mejorPrecio: false},
            {nombre: "Proveedor B", precio: 135.00, mejorPrecio: true},
            {nombre: "Proveedor C", precio: 155.00, mejorPrecio: false}
        ]
    },
    {
        codigo: "ART002",
        descripcion: "Producto B",
        categoria: "Hogar",
        preciosSistema: {1: 85.50, 2: 80.00, 3: 75.00, 4: 70.00},
        proveedores: [
            {nombre: "Proveedor A", precio: 82.00, mejorPrecio: true},
            {nombre: "Proveedor C", precio: 90.00, mejorPrecio: false}
        ]
    },
    {
        codigo: "ART003",
        descripcion: "Producto C",
        categoria: "Oficina",
        preciosSistema: {1: 220.00, 2: 210.00, 3: 200.00, 4: 190.00},
        proveedores: [
            {nombre: "Proveedor B", precio: 215.00, mejorPrecio: false},
            {nombre: "Proveedor D", precio: 195.00, mejorPrecio: true}
        ]
    }
];

// Variable global para el gráfico
let comparisonChart = null;

// Inicialización cuando el DOM esté listo
$(document).ready(function() {

   if ($('.topVendidos').length) {  
    // Inicializar selects
    $('.form-select').select2();
    
    // Inicializar DataTable
    const table = $('#table-comparacion').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        ordering: true,
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
            '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
            '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: '<i data-feather="share"></i> Exportar',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i data-feather="printer"></i> Imprimir'
                    },
                    {
                        extend: 'csv',
                        text: '<i data-feather="file-text"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        text: '<i data-feather="file"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '<i data-feather="archive"></i> PDF'
                    },
                    {
                        extend: 'copy',
                        text: '<i data-feather="copy"></i> Copiar'
                    }
                ]
            }
        ]
    });
    
    // Cargar datos de ejemplo
    cargarDatosEjemplo();
    
    // Configurar eventos
    $('#btn-buscar').on('click', function() {
        filtrarDatos();
    });
    
    $('#btn-limpiar').on('click', function() {
        limpiarFiltros();
    });
    
    // Inicializar gráfico después de un pequeño delay para asegurar que el DOM esté listo
    setTimeout(function() {
        inicializarGrafico();
    }, 100);
    
    // Inicializar feather icons
    if (window.feather) {
        feather.replace({ width: 14, height: 14 });
    }
    
    // Eventos adicionales
    configurarEventosAdicionales();
      
    }

});

function cargarDatosEjemplo() {
    const tbody = $('#table-comparacion tbody');
    tbody.empty();
    
    let mejoresPrecios = 0;
    let preciosSimilares = 0;
    let preciosAltos = 0;
    
    $.each(datosEjemplo, function(index, articulo) {
        const precioSeleccionado = parseInt($('#select-precio').val().replace('prec_vta', ''));
        const precioSistema = articulo.preciosSistema[precioSeleccionado];
        
        $.each(articulo.proveedores, function(provIndex, proveedor) {
            const diferencia = proveedor.precio - precioSistema;
            const porcentajeDiferencia = ((diferencia / precioSistema) * 100).toFixed(2);
            
            let estadoClase = '';
            let estadoTexto = '';
            
            if (diferencia < -5) {
                estadoClase = 'price-better';
                estadoTexto = 'Mejor';
                mejoresPrecios++;
            } else if (diferencia > 5) {
                estadoClase = 'price-worse';
                estadoTexto = 'Más Alto';
                preciosAltos++;
            } else {
                estadoClase = 'price-equal';
                estadoTexto = 'Similar';
                preciosSimilares++;
            }
            
            const row = $('<tr>').html(`
                <td>${articulo.codigo}</td>
                <td>${articulo.descripcion}</td>
                <td class="text-end">$${precioSistema.toFixed(2)}</td>
                <td class="text-end">$${proveedor.precio.toFixed(2)}</td>
                <td class="text-end ${estadoClase}">$${diferencia.toFixed(2)}</td>
                <td class="text-end ${estadoClase}">${porcentajeDiferencia}%</td>
                <td><span class="badge rounded-pill bg-light-${estadoClase.replace('price-', '')}">${estadoTexto}</span></td>
                <td>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary ver-detalle" data-codigo="${articulo.codigo}">
                        <i data-feather="eye"></i>
                    </button>
                </td>
            `);
            
            tbody.append(row);
        });
    });
    
    // Actualizar resumen
    $('#total-articulos').text(datosEjemplo.length);
    $('#mejores-precios').text(mejoresPrecios);
    $('#precios-similares').text(preciosSimilares);
    $('#precios-altos').text(preciosAltos);
    
    // Actualizar gráfico
    actualizarGrafico(mejoresPrecios, preciosSimilares, preciosAltos);
    
    // Reinicializar feather icons para los nuevos botones
    if (window.feather) {
        feather.replace({ width: 14, height: 14 });
    }
    
    // Configurar eventos de los botones de detalle
    $('.ver-detalle').off('click').on('click', function() {
        const codigo = $(this).data('codigo');
        mostrarDetalleArticulo(codigo);
    });
}

function filtrarDatos() {
    // Simular filtrado - en producción sería una llamada AJAX
    const filtroArticulo = $('#search-articulo').val().toLowerCase();
    const filtroProveedor = $('#select-proveedor').val();
    const filtroCategoria = $('#select-categoria').val();
    
    $('#table-comparacion tbody tr').each(function() {
        const $fila = $(this);
        const descripcion = $fila.find('td:eq(1)').text().toLowerCase();
        const categoria = $fila.find('td:eq(0)').data('categoria') || '';
        const proveedor = $fila.find('td:eq(3)').data('proveedor') || '';
        
        let mostrar = true;
        
        if (filtroArticulo && !descripcion.includes(filtroArticulo)) {
            mostrar = false;
        }
        
        if (filtroCategoria && categoria !== filtroCategoria) {
            mostrar = false;
        }
        
        if (filtroProveedor && proveedor !== filtroProveedor) {
            mostrar = false;
        }
        
        mostrar ? $fila.show() : $fila.hide();
    });
}

function limpiarFiltros() {
    $('#search-articulo').val('');
    $('#select-proveedor').val('').trigger('change');
    $('#select-categoria').val('').trigger('change');
    $('#select-precio').val('prec_vta1').trigger('change');
    cargarDatosEjemplo();
}

function inicializarGrafico() {
    // Verificar que ApexCharts esté disponible
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts no está disponible');
        return;
    }
    
    // Verificar que el elemento exista
    const chartElement = $('#price-comparison-chart')[0];
    if (!chartElement) {
        console.error('Elemento del gráfico no encontrado');
        return;
    }
    
    try {
        // Destruir gráfico existente si hay uno
        if (comparisonChart) {
            comparisonChart.destroy();
        }
        
        comparisonChart = new ApexCharts(chartElement, {
            series: [0, 0, 0],
            chart: {
                type: 'donut',
                height: 300,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            labels: ['Mejores Precios', 'Precios Similares', 'Precios Más Altos'],
            colors: ['#28c76f', '#ff9f43', '#ea5455'],
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                color: '#6e6b7b'
                            }
                        }
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 250
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        });
        
        comparisonChart.render();
        
    } catch (error) {
        console.error('Error al inicializar el gráfico:', error);
        // Fallback: mostrar datos en formato simple
        $('#price-comparison-chart').html(`
            <div class="text-center p-4">
                <h4>Resumen de Precios</h4>
                <div class="mt-3">
                    <span class="badge bg-success me-2">Mejores: 0</span>
                    <span class="badge bg-warning me-2">Similares: 0</span>
                    <span class="badge bg-danger me-2">Altos: 0</span>
                </div>
            </div>
        `);
    }
}

function actualizarGrafico(mejores, similares, altos) {
    if (comparisonChart) {
        try {
            comparisonChart.updateSeries([mejores, similares, altos]);
        } catch (error) {
            console.error('Error al actualizar el gráfico:', error);
            // Fallback: actualizar la versión simple
            $('#price-comparison-chart').html(`
                <div class="text-center p-4">
                    <h4>Resumen de Precios</h4>
                    <div class="mt-3">
                        <span class="badge bg-success me-2">Mejores: ${mejores}</span>
                        <span class="badge bg-warning me-2">Similares: ${similares}</span>
                        <span class="badge bg-danger me-2">Altos: ${altos}</span>
                    </div>
                </div>
            `);
        }
    }
}

function mostrarDetalleArticulo(codigo) {
    const articulo = $.grep(datosEjemplo, function(item) {
        return item.codigo === codigo;
    })[0];
    
    if (articulo) {
        $('#modal-codigo').text(articulo.codigo);
        $('#modal-descripcion').text(articulo.descripcion);
        $('#modal-categoria').text(articulo.categoria);
        $('#modal-precio1').text('$' + articulo.preciosSistema[1].toFixed(2));
        $('#modal-precio2').text('$' + articulo.preciosSistema[2].toFixed(2));
        $('#modal-precio3').text('$' + articulo.preciosSistema[3].toFixed(2));
        $('#modal-precio4').text('$' + articulo.preciosSistema[4].toFixed(2));
        
        let comparacionHTML = '';
        $.each(articulo.proveedores, function(index, proveedor) {
            comparacionHTML += `
                <div class="provider-price mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-medium">${proveedor.nombre}</span>
                        <span class="badge bg-${proveedor.mejorPrecio ? 'success' : 'secondary'}">
                            $${proveedor.precio.toFixed(2)}
                        </span>
                    </div>
                </div>
            `;
        });
        
        $('#modal-comparacion-proveedores').html(comparacionHTML);
        
        // Mostrar el modal usando Bootstrap con jQuery
        $('#modal-detalle').modal('show');
    }
}

function configurarEventosAdicionales() {
    // Enter en el buscador ejecuta la búsqueda
    $('#search-articulo').on('keypress', function(e) {
        if (e.which === 13) {
            filtrarDatos();
        }
    });
    
    // Actualizar datos cuando cambie el select de precio
    $('#select-precio').on('change', function() {
        cargarDatosEjemplo();
    });
    
    // Tooltips para botones
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Responsive del gráfico
    $(window).on('resize', function() {
        if (comparisonChart) {
            setTimeout(function() {
                comparisonChart.updateOptions({
                    chart: {
                        height: $(window).width() < 768 ? 250 : 300
                    }
                });
            }, 150);
        }
    });
}

// Función para reinicializar el gráfico si es necesario
function reinicializarGrafico() {
    if (comparisonChart) {
        comparisonChart.destroy();
        comparisonChart = null;
    }
    setTimeout(inicializarGrafico, 100);
}