/* =========================================================================
   Ficha de Artículo Dinámica - Versión sin Búsqueda en Tiempo Real
   ========================================================================= */

// --- VARIABLES GLOBALES DE ESTADO ---
let listaCodigos = []; // Contendrá la lista de trabajo (completa o filtrada)
let indiceCodigoActual = -1;
let esBusquedaActiva = false; // Para saber si estamos en una búsqueda
let terminoBusquedaActual = ''; // Guardar el término de búsqueda actual

// --- FUNCIONES AUXILIARES ---
function mostrarCarga() {
    $('#loadingIndicator').fadeIn(300);
}
function ocultarCarga() {
    $('#loadingIndicator').fadeOut(300);
}

// --- FUNCIÓN: Actualiza el estado visual de todos los botones ---
function actualizarEstadoBotones() {
    const $btnPrev = $('#btn-prev');
    const $btnNext = $('#btn-next');
    const $btnClear = $('#btn-clear-search');
    const $searchInput = $('#search-input');

    // Lógica para botones de paginación
    if (listaCodigos.length <= 1) {
        $btnPrev.prop('disabled', true);
        $btnNext.prop('disabled', true);
    } else {
        $btnPrev.prop('disabled', indiceCodigoActual <= 0);
        $btnNext.prop('disabled', indiceCodigoActual >= listaCodigos.length - 1);
    }
    
    // Lógica para el botón de limpiar (solo se muestra si hay una búsqueda activa)
    if (esBusquedaActiva) {
        $btnClear.show();
    } else {
        $btnClear.hide();
    }
}

// --- FUNCIONES AUXILIARES PARA MANEJO DE DATOS ---

/**
 * Formatea un valor de texto para mostrarlo.
 * Si el valor es nulo, indefinido o una cadena vacía, devuelve 'Sin Datos'.
 * @param {*} valor - El valor a formatear.
 * @returns {string} El valor formateado o 'Sin Datos'.
 */
function mostrarDato(valor) {
    // Comprueba si el valor es nulo, indefinido o una cadena vacía después de quitar espacios.
    if (valor === null || valor === undefined || (typeof valor === 'string' && valor.trim() === '')) {
        return 'Sin Datos';
    }
    return valor;
}

/**
 * Formatea un valor numérico para precios.
 * Si el valor no es un número válido, devuelve '$0.00'.
 * @param {*} valor - El valor a formatear.
 * @returns {string} El precio formateado.
 */
function formatearPrecio(valor) {
    const precio = parseFloat(valor);
    // isNaN comprueba si el valor no es un número (Not-a-Number)
    if (isNaN(precio)) {
        return '$0.00';
    }
    // toFixed(2) asegura que siempre haya dos decimales
    return `$${precio.toFixed(2)}`;
}

/**
 * Formatea un valor numérico para porcentajes.
 * Si el valor no es un número válido, devuelve '0.00%'.
 * @param {*} valor - El valor a formatear.
 * @returns {string} El porcentaje formateado.
 */
function formatearPorcentaje(valor) {
    const porcentaje = parseFloat(valor);
    if (isNaN(porcentaje)) {
        return '0.00%';
    }
    return `${porcentaje.toFixed(2)}%`;
}

// --- FUNCIÓN PRINCIPAL: Carga los datos de UN artículo ---
function cargarArticulo(codigo) {
    mostrarCarga();
    
    $.ajax({
        url: '../admin/index.php?action=articulos&tipo=1&accion=6&a=1&c=ArticuloData&t=art', 
        method: 'GET',
        data: { codigo: codigo }, 
        dataType: 'json',
        
        success: function(articulo) {
            if (!articulo || articulo.length === 0) {
                // Limpia la vista si no se encuentra el artículo
                $('#product-name').text('Artículo no encontrado.');
                $('#product-code').text('');
                $('#pagination-text').text('N/A');
                $('#product-brand').text('');
                $('#product-category').text('');
                $('#product-description').text('');
                $('#product-image').attr('src', '');
                return;
            }
            const datos = articulo[0];
            
            // --- ACTUALIZACIÓN DE DATOS ESTÁTICOS ---
            $('#product-code').text(`Código: ${mostrarDato(datos.co_art)}`);
            $('#product-name').text(mostrarDato(datos.art_des));
            $('#product-brand').text(mostrarDato(datos.des_col));
            $('#product-category').text(mostrarDato(datos.cat_des));
            $('#product-description').text(mostrarDato(datos.descripcion));
            
            const imagenSrc = mostrarDato(datos.media) !== 'Sin Datos' ? datos.media : '../app-assets/images/products/placeholder.png';
            $('#product-image').attr('src', imagenSrc);
            
            // --- ACTUALIZACIÓN DE PRECIOS ---
            $('#price-1').text((datos.prec_vta1));
            $('#price-2').text((datos.prec_vta2));
            $('#price-3').text((datos.prec_vta3));
            $('#price-4').text((datos.prec_vta4));
            $('#purchase-price').text((datos.ult_cos_om));
            $('#average-margin').text(formatearPorcentaje(datos.rentabilidad));    
 
            // --- ACTUALIZACIÓN DE PAGINACIÓN ---
            if (esBusquedaActiva) {
                $('#pagination-text').text(`${indiceCodigoActual + 1} de ${listaCodigos.length} (Búsqueda: "${terminoBusquedaActual}")`);
            } else {
                $('#pagination-text').text(`${indiceCodigoActual + 1} de ${listaCodigos.length}`);
            }
        
            // --- ACTUALIZACIÓN DE INFORMACIÓN ADICIONAL ---
            $('#location').text(mostrarDato(datos.ubicacion));
            $('#main-supplier').text(mostrarDato(datos.proveedor));
            $('#barcode').text(mostrarDato(datos.codigoBarras));

            // --- ACTUALIZACIÓN DE FECHAS ---
            $('#last-purchase-date').text(mostrarDato(datos.ultima_compra));
            $('#last-sales-date').text(mostrarDato(datos.ultima_venta));
            $('#expiration-date').text(mostrarDato(datos.fecha_vencimiento));
            $('#last-update').text(mostrarDato(datos.ultima_modificacion));

            // --- ACTUALIZACIÓN DE VENTAS Y TENDENCIA ---
            $('#month-sales').text(mostrarDato(datos.ventas_mes));
            $('#year-sales').text(mostrarDato(datos.ventas_anio));
            $('#month-sales-1').text(mostrarDato(datos.ventas_mes_anterior));

            // Obtenemos los valores numéricos para los cálculos
            const ventasMes = parseFloat(datos.ventas_mes_int) || 0;
            const ventasMesAnterior = parseFloat(datos.ventas_mes_anterior_int) || 0;
            
            let total_crecimiento = 0;
            // Evitamos división por cero si el mes anterior no tuvo ventas
            if (ventasMesAnterior > 0) {
                total_crecimiento = ((ventasMes - ventasMesAnterior) / ventasMesAnterior) * 100;
            } else if (ventasMes > 0) {
                // Si el mes anterior fue 0 y este mes no, el crecimiento es "infinito", lo representamos como 100%
                total_crecimiento = 100;
            } else {
                // Si ambos meses son 0, el crecimiento es 0
                total_crecimiento = 0;
            }

            // --- NUEVA LÓGICA: PINTAR LA TENDENCIA ---
            let textoTendencia = '';
            let claseColor = '';
            let iconoTendencia = '';

            // Caso 1: Sin rotación (ventas en 0)
            if (ventasMes <= 0) {
                textoTendencia = 'Sin Rotación';
                claseColor = 'text-danger'; // Rojo
                iconoTendencia = 'fas fa-times-circle'; // Icono de X
            }
            // Caso 2: Rotación Baja (crecimiento negativo)
            else if (total_crecimiento < 0) {
                textoTendencia = 'Rotación Baja';
                claseColor = 'text-warning'; // Naranja
                iconoTendencia = 'fas fa-arrow-down'; // Flecha abajo
            }
            // Caso 3: Rotación Normal (crecimiento 0)
            else if (total_crecimiento == 0) {
                textoTendencia = 'Rotación Normal';
                claseColor = 'text-secondary'; // Gris
                iconoTendencia = 'fas fa-minus-circle'; // Icono de menos
            }
            // Caso 4: Rotación Media (crecimiento hasta 50%)
            else if (total_crecimiento > 0 && total_crecimiento <= 50) {
                textoTendencia = 'Rotación Media';
                claseColor = 'text-info'; // Azul
                iconoTendencia = 'fas fa-arrow-up'; // Flecha arriba
            }
            // Caso 5: Rotación Alta (crecimiento mayor a 50%)
            else if (total_crecimiento > 50) {
                textoTendencia = 'Rotación Alta';
                claseColor = 'text-success'; // Verde
                iconoTendencia = 'fas fa-rocket'; // Icono de cohete
            }

            // Actualizamos el HTML de la celda de tendencia con el icono y el texto
            $('#trend').html(`<span class="${claseColor}"><i class="${iconoTendencia}"></i> ${textoTendencia}</span>`);

            // --- LÓGICA DE LA BARRA DE PROGRESO DE STOCK ---
            let stockActual = parseFloat(datos.stock_act) || 0;
            let stockMinimo = parseFloat(datos.stock_min) || 1;
            $('#stock-quantity').text(`${stockActual} unidades`);
            $('#stock-min').text(`Mínimo: ${stockMinimo}`);
            
            let colorBarra = stockActual < stockMinimo ? 'bg-danger' : 'bg-success';
            let colorTexto = stockActual < stockMinimo ? 'text-danger' : '';
            let porcentajeVisual = stockMinimo > 0 ? Math.min((stockActual / stockMinimo) * 100, 100) : 0;
            
            $('.progress-bar')
                .css('width', `${porcentajeVisual}%`)
                .attr('aria-valuenow', porcentajeVisual)
                .removeClass('bg-success bg-warning bg-danger')
                .addClass(colorBarra);
                
            $('#stock-quantity, #stock-min')
                .removeClass('text-danger text-success')
                .addClass(colorTexto);
        },
        
        error: function() {
            console.error("Error al cargar el artículo.");
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar',
                text: 'No se pudo cargar la información del artículo. Inténtelo de nuevo.'
            });
        },
        
        complete: function() {
            ocultarCarga();
            actualizarEstadoBotones();
        }
    });
}

// --- FUNCIÓN: Carga la lista completa desde el servidor ---
function cargarYMostrarListaCompleta() {
    mostrarCarga();
    $.ajax({
        url: '../admin/index.php?action=articulos&tipo=1&accion=7&a=1&c=ArticuloData&t=art', 
        method: 'GET',
        dataType: 'json',
        success: function(articulos) {
            listaCodigos = articulos.map(a => a.co_art);
            esBusquedaActiva = false;
            terminoBusquedaActual = '';
            
            if (listaCodigos.length > 0) {
                indiceCodigoActual = 0; 
                cargarArticulo(listaCodigos[indiceCodigoActual]);
            } else {
                $('#product-name').text('No se encontraron artículos en el sistema.');
                $('#product-code').text('');
                $('#pagination-text').text('N/A');
                actualizarEstadoBotones();
                ocultarCarga();
            }
        },
        error: function() {
            console.error("Error al cargar la lista completa.");
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar',
                text: 'Error al cargar la lista de artículos. Contacte al administrador.'
            });
            actualizarEstadoBotones();
            ocultarCarga();
        }
    });
}

// --- FUNCIÓN: Realiza una búsqueda y muestra los resultados ---
function buscarYMostrarResultados(termino) {
    // Guardar el término de búsqueda actual
    terminoBusquedaActual = termino;
    
    // Si el término está vacío, cargar la lista completa
    if (!termino || termino.trim() === '') {
        restablecerListaCompleta();
        return;
    }
    
    mostrarCarga();
    
    $.ajax({
        url: '../admin/index.php?action=articulos&tipo=1&accion=8&a=1&c=ArticuloData&t=art', 
        method: 'GET',
        data: { 
            search: termino,
            // Parámetros adicionales para búsqueda inteligente
            searchType: 'contains', // Indica que queremos búsqueda por contenido (substring)
            searchFields: 'co_art,art_des,des_col,cat_des' // Campos en los que buscar
        }, 
        dataType: 'json',
        success: function(resultados) {
            if (resultados && resultados.length > 0) {
                listaCodigos = resultados.map(a => a.co_art);
                esBusquedaActiva = true;
                indiceCodigoActual = 0;
                
                // Mostrar información sobre los resultados
                Swal.fire({
                    icon: 'success',
                    title: 'Resultados encontrados',
                    text: `Se encontraron ${resultados.length} productos que coinciden con "${termino}"`,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                cargarArticulo(listaCodigos[indiceCodigoActual]);
            } else {
                // Informar que no hay resultados
                Swal.fire({
                    icon: 'info',
                    title: 'Búsqueda sin resultados',
                    text: `No se encontraron artículos para: "${termino}"`
                });
                
                // Si no hay resultados, limpiamos la vista y el estado
                listaCodigos = [];
                indiceCodigoActual = -1;
                esBusquedaActiva = true;
                $('#product-name').text('Realice una nueva búsqueda.');
                $('#product-code').text('');
                $('#pagination-text').text('N/A');
                actualizarEstadoBotones();
                ocultarCarga();
            }
        },
        error: function() {
            console.error("Error en la búsqueda.");
            Swal.fire({
                icon: 'error',
                title: 'Error de búsqueda',
                text: 'Error al realizar la búsqueda. Contacte al administrador.'
            });
            actualizarEstadoBotones();
            ocultarCarga();
        }
    });
}

// --- FUNCIÓN: Restablece la vista a la lista completa ---
function restablecerListaCompleta() {
    $('#search-input').val(''); // Limpiar el campo de búsqueda
    terminoBusquedaActual = '';
    cargarYMostrarListaCompleta(); // Volver a cargar todo
}

// --- INICIALIZACIÓN Y EVENTOS ---
 $(document).ready(function() {
    // 1. Carga inicial: se carga la lista completa al empezar
    if ($('.i_articulo_ficha').length) {
        cargarYMostrarListaCompleta();
    } else {
        console.log("No hay elementos con la clase 'ficha' en el DOM.");
    }

    // 2. Eventos de navegación
    $('#btn-prev').on('click', function() {
        if (indiceCodigoActual > 0) {
            indiceCodigoActual--;
            cargarArticulo(listaCodigos[indiceCodigoActual]);
        }
    });

    $('#btn-next').on('click', function() {
        if (indiceCodigoActual < listaCodigos.length - 1) {
            indiceCodigoActual++;
            cargarArticulo(listaCodigos[indiceCodigoActual]);
        }
    });


    // 4. Evento para limpiar la búsqueda
    $('#btn-clear-search').on('click', function() {
        restablecerListaCompleta();
    });
});