// ===================================================================
// FUNCIÓN PARA ACTUALIZAR LA TARJETA (La misma de antes)
// ===================================================================
function actualizarTarjetaComparacionFacturas(emitidas, verificadas) {
    const config = {
        // --- UMBRALES CORREGIDOS ---
        thresholds: { positive: 80, neutral: 50 }, // Ahora 80 y 50
        
        // --- ESTADOS MEJORADOS CON TEXTO E ICONO ESPECÍFICO ---
        estado: {
            positive: { class: 'positive', icono: 'check-circle', texto: 'Excelente tasa de verificación' },
            neutral: { class: 'neutral', icono: 'alert-circle', texto: 'Tasa de verificación aceptable' },
            negative: { class: 'negative', icono: 'x-circle', texto: 'Tasa de verificación baja' },
            perfect: { class: 'positive', icono: 'award', texto: '¡Verificación completa!' }, // Nuevo estado para 100%
            empty: { class: 'neutral', icono: 'minus', texto: 'No hay facturas emitidas' }
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
       // console.log(`Porcentaje calculado: ${porcentaje}%`);
        // --- LÓGICA CORREGIDA Y MEJORADA ---
        if (porcentaje === 100) {
            estadoActual = 'perfect'; // Caso especial para 100%
        } else if (porcentaje >= config.thresholds.positive) { // 80 - 99
            estadoActual = 'positive';
        } else if (porcentaje >= config.thresholds.neutral) { // 50 - 79
            estadoActual = 'neutral';
        } else { // 0 - 49
            estadoActual = 'negative';
        }
    }

    const estadoInfo = config.estado[estadoActual];
    
    $elements.resultado.removeClass('positive negative neutral').addClass(estadoInfo.class);
    $elements.icono.html(feather.icons[estadoInfo.icono].toSvg());
    $elements.porcentaje.text(`${porcentaje.toFixed(2)}%`);
    
    // --- TEXTO MÁS DESCRIPTIVO TOMADO DESDE LA CONFIGURACIÓN ---
    $elements.texto.text(estadoInfo.texto);
}
// ===================================================================
// NUEVA FUNCIÓN PARA OBTENER DATOS MEDIANTE AJAX
// ===================================================================
/**
 * Realiza una llamada AJAX para obtener las estadísticas de facturas
 * y actualiza la tarjeta con los datos recibidos.
 */
function cargarYActualizarTarjetaFacturas() {
    // Muestra un indicador de carga
    $('#facturas-emitidas').html('<i class="fas fa-spinner fa-spin"></i>');
    $('#facturas-verificadas').html('<i class="fas fa-spinner fa-spin"></i>');

    $.ajax({
        url: '../admin/index.php?action=almacen&a=1&c=VehiculoData&t=jm_despacho_vehiculo', 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
         //   console.log("Datos de facturas recibidos:", response);

            // Validamos la estructura del JSON recibido
            if (Array.isArray(response) && response.length > 0) {
                const data = response[0]; // Tomamos el primer elemento del array
                
                // Validamos que las propiedades existan y sean numéricas
                if (data.hasOwnProperty('emitidas') && data.hasOwnProperty('verificadas')) {
                    const emitidas = parseInt(data.emitidas, 10);
                    const verificadas = parseInt(data.verificadas, 10);
                    
                    // Validamos que las conversiones sean números válidos
                    if (!isNaN(emitidas) && !isNaN(verificadas)) {
                        actualizarTarjetaComparacionFacturas(emitidas, verificadas);
                    } else {
                        console.error("Los valores recibidos no son numéricos válidos:", data);
                        toastr.error('Los datos de facturas no son numéricos.');
                        actualizarTarjetaComparacionFacturas(0, 0);
                    }
                } else {
                    console.error("Las propiedades requeridas no existen en el JSON:", data);
                    toastr.error('El formato de los datos de facturas es incorrecto.');
                    actualizarTarjetaComparacionFacturas(0, 0);
                }
            } else {
                console.error("La respuesta de la API no tiene el formato esperado:", response);
                toastr.error('No se recibieron datos de facturas válidos.');
                actualizarTarjetaComparacionFacturas(0, 0);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener los datos de las facturas:", {
                status: status,
                error: error,
                responseText: xhr.responseText
            });
            
            toastr.error('No se pudieron cargar las estadísticas de facturas.');
            actualizarTarjetaComparacionFacturas(0, 0);
        },
  
    });
}

// ===================================================================
// EJECUCIÓN CUANDO EL DOCUMENTO ESTÁ LISTO
// ===================================================================
 $(document).ready(function() {
    // 1. Cargar los datos por primera vez al cargar la página
   
if ($('.indicadorResumenFacturacion').length) {
    cargarYActualizarTarjetaFacturas();
       // 2. (Opcional) Configurar una actualización automática cada 5 minutos
    setInterval(cargarYActualizarTarjetaFacturas, 150000); // 300000 ms = 5 minutos
  }
   

});