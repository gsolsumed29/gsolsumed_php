// =============================================
// DESPACHO.JS - SISTEMA DE DESPACHO DE FACTURAS
// =============================================

// Variables globales para el sistema de despacho
let currentInput = null;
let currentMode = null;
let focoBloqueado = false;
let tiempoEsperaFoco = 100;
let alertaExcesoActiva = false;
let escaneoEnProgreso = false;
let ultimoCodigoEscaneado = '';
let tiempoUltimoEscaneo = 0;
let scannerBuffer = '';
let scannerTimeout = null;
let touchTimer = null; // Temporizador para detectar mantenimiento pulsado
let touchStartTime = 0; // Tiempo de inicio del toque
let touchHoldThreshold = 300; // Tiempo en milisegundos para activar teclado (800ms)
let alertaExcesoUnitarioActiva = false; // <<< NUEVA VARIABLE
// ...
// =============================================
// SISTEMA DE TECLADO VIRTUAL
// =============================================

function initCustomKeyboard() {
   console.log('Inicializando teclado virtual...');
    
    // Campo de búsqueda - Modificado para permitir escaneo y entrada manual simultáneamente
    $('#buscarProductoInput')
        .prop('readonly', false) // Permitir entrada manual
        .attr('inputmode', 'none')
        .css('caret-color', 'transparent')
        .on('focus', function(e) {
            // No mostrar teclado automáticamente al hacer foco
            $(this).select();
        })
        .on('input', function() {
            if (escaneoEnProgreso) return;
            
            const codigo = $(this).val().trim();
            clearTimeout($(this).data('scanner-timeout'));
            
            // Esperar a que el usuario deje de teclear (500ms sin cambios)
            $(this).data('scanner-timeout', setTimeout(() => {
                if (codigo.length > 0 && !escaneoEnProgreso) {
                    console.log('Búsqueda automática:', codigo);
                    buscarProductoPorCodigo(codigo);
                }
            }, 500));
        })
        // Manejar eventos de teclado para lectores
        .on('keydown', function(e) {
            // Ignorar teclas de control excepto Enter
            if (e.key.length === 1 || e.key === 'Enter') {
                if (e.key === 'Enter') {
                    // Procesar el código acumulado
                    if (scannerBuffer.length >= 10) {
                        buscarProductoPorCodigo(scannerBuffer);
                        scannerBuffer = '';
                    }
                } else {
                    // Acumular caracteres en el buffer
                    scannerBuffer += e.key;
                    
                    // Limpiar el buffer después de un tiempo sin actividad
                    clearTimeout(scannerTimeout);
                    scannerTimeout = setTimeout(() => {
                        if (scannerBuffer.length >= 10) {
                            buscarProductoPorCodigo(scannerBuffer);
                        }
                        scannerBuffer = '';
                    }, 300);
                }
            }
        })
        // Eventos táctiles para detectar mantenimiento pulsado
        .on('touchstart', function(e) {
            e.preventDefault();
            touchStartTime = Date.now();
            
            // Mostrar indicador visual de que se está manteniendo pulsado
            $(this).addClass('touch-hold-indicator');
            
            // Configurar temporizador para activar teclado
            touchTimer = setTimeout(() => {
                // Activar vibración si está disponible
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
                
                // Mostrar teclado virtual
                mostrarTecladoManual($(this), 'search');
                
                // Quitar indicador visual
                $(this).removeClass('touch-hold-indicator');
            }, touchHoldThreshold);
        })
        .on('touchend', function(e) {
            e.preventDefault();
            
            // Quitar indicador visual
            $(this).removeClass('touch-hold-indicator');
            
            // Cancelar temporizador si el usuario suelta antes del tiempo necesario
            if (touchTimer) {
                clearTimeout(touchTimer);
                touchTimer = null;
            }
        })
        .on('touchcancel', function(e) {
            e.preventDefault();
            
            // Quitar indicador visual
            $(this).removeClass('touch-hold-indicator');
            
            // Cancelar temporizador si se cancela el toque
            if (touchTimer) {
                clearTimeout(touchTimer);
                touchTimer = null;
            }
        })
        // Soporte para mouse (para pruebas en escritorio)
        .on('mousedown', function(e) {
            e.preventDefault();
            touchStartTime = Date.now();
            
            // Mostrar indicador visual
            $(this).addClass('touch-hold-indicator');
            
            // Configurar temporizador
            touchTimer = setTimeout(() => {
                mostrarTecladoManual($(this), 'search');
                $(this).removeClass('touch-hold-indicator');
            }, touchHoldThreshold);
        })
        .on('mouseup', function(e) {
            e.preventDefault();
            
            // Quitar indicador visual
            $(this).removeClass('touch-hold-indicator');
            
            // Cancelar temporizador
            if (touchTimer) {
                clearTimeout(touchTimer);
                touchTimer = null;
            }
        })
        .on('mouseleave', function(e) {
            // Quitar indicador visual si el mouse sale del campo
            $(this).removeClass('touch-hold-indicator');
            
            // Cancelar temporizador
            if (touchTimer) {
                clearTimeout(touchTimer);
                touchTimer = null;
            }
        });

    // Inputs de cantidad - Modificados para no mostrar teclado automáticamente
    $('.cantidad-input').each(function() {
        $(this)
            .prop('readonly', true)
            .attr('inputmode', 'none')
            .css('caret-color', 'transparent');
    });
    
    // Eventos para inputs de cantidad - Solo mostrar teclado con botón explícito
    $(document).on('click', '.cantidad-input', function(e) {
        e.preventDefault();
        if ($(this).is(':disabled')) return;
        // No mostrar teclado automáticamente
    });

    // Teclas para búsqueda
    $('#keyboardSearch .keyboard-key[data-value]').on('click', function() {
        if (!currentInput || currentMode !== 'search') return;
        
        const value = $(this).data('value');
        const currentVal = currentInput.val() || '';
        currentInput.val(currentVal + value);
    });
    
    $('#keyBackspaceSearch').on('click', function() {
        if (!currentInput || currentMode !== 'search') return;
        
        const currentVal = currentInput.val() || '';
        if (currentVal.length > 0) {
            currentInput.val(currentVal.slice(0, -1));
        }
    });
    
    $('#keyClearSearch').on('click', function() {
        if (!currentInput || currentMode !== 'search') return;
        currentInput.val('');
    });
    
    $('#keySearchEnter').on('click', function() {
        if (!currentInput || currentMode !== 'search') return;
        
        const valor = currentInput.val().trim();
        if (valor) {
            buscarProducto();
        } else {
            mostrarError('Ingrese un código para buscar');
        }
        ocultarTeclado();
    });
    
    // Teclas para cantidades
    $('#keyboardQuantity .keyboard-key[data-value]').on('click', function() {
        if (!currentInput || currentMode !== 'quantity') return;
        
        const value = $(this).data('value');
        const currentVal = currentInput.val() || '0';
        
        if (currentVal === '0') {
            currentInput.val(value);
        } else {
            currentInput.val(currentVal + value);
        }
        triggerValidation(currentInput);
    });
    
    $('#keyBackspaceQuantity').on('click', function() {
        if (!currentInput || currentMode !== 'quantity') return;
        
        const currentVal = currentInput.val() || '';
        if (currentVal.length > 1) {
            currentInput.val(currentVal.slice(0, -1));
        } else {
            currentInput.val('0');
        }
        triggerValidation(currentInput);
    });
    
    $('#keyboardQuantity .quick-action').on('click', function() {
        if (!currentInput || currentMode !== 'quantity') return;
        
        const action = $(this).data('action');
        const max = parseInt(currentInput.data('cantidad-maxima')) || 0;
        
        switch(action) {
            case 'clear':
                currentInput.val('0');
                break;
            case 'max':
                currentInput.val(max);
                break;
            case 'half':
                currentInput.val(Math.floor(max / 2));
                break;
        }
        triggerValidation(currentInput);
    });
    
    $('#keyQuantityEnter').on('click', function() {
        if (!currentInput || currentMode !== 'quantity') return;
        
        const valor = currentInput.val() || '0';
        const cantidadMaxima = currentInput.data('cantidad-maxima');
        validarCantidad(currentInput, valor, cantidadMaxima);
        
        ocultarTeclado();
        setTimeout(() => {
            moverAlSiguienteInput(currentInput);
        }, 100);
    });
  
     
    // Cerrar teclado
    $(document).on('click', function(e) {
        // >>> INICIO DE LA MODIFICACIÓN <<<
        // Ignorar clics que ocurran sobre una alerta de error
        if ($(e.target).closest('.swf-alert-overlay').length) {
            return;
        }
        // >>> FIN DE LA MODIFICACIÓN <<<
        if (!$(e.target).closest('.custom-keyboard, .btn-teclado').length) {
            ocultarTeclado();
        }
    });
}

// Función para mostrar teclado manualmente
function mostrarTecladoManual(input, modo) {
    currentInput = input;
    currentMode = modo;
    mostrarTecladoModo(modo);
    
    if (modo === 'search') {
        input.addClass('input-search-mode');
    } else if (modo === 'quantity') {
        input.addClass('input-quantity-mode');
        input.closest('tr').addClass('fila-en-foco');
    }
}

function mostrarTecladoModo(modo) {
    $('.keyboard-mode').hide();
    
    if (modo === 'search') {
        $('#keyboardSearch').show();
        $('#keyboardTitle').text('Teclado de Búsqueda');
    } else if (modo === 'quantity') {
        $('#keyboardQuantity').show();
        $('#keyboardTitle').text('Teclado de Cantidades');
    }
    
      $('#customKeyboard').slideDown(300);
 //   $('#customKeyboard').slideDown(300);
    focoBloqueado = true;
}

function ocultarTeclado() {
    //$('#customKeyboard').fadeOut(300);

    $('#customKeyboard').slideUp(300);
    focoBloqueado = false;
    
    if (currentInput) {
        currentInput.removeClass('input-search-mode input-quantity-mode');
        currentInput = null;
    }
    currentMode = null;
}

// =============================================
// SISTEMA DE BÚSQUEDA Y ESCANEO
// =============================================

function buscarProductoPorCodigo(codigo) {
    // if (!codigo || escaneoEnProgreso) return;
    
    // Evitar procesar el mismo código repetidamente
    const ahora = Date.now();
    if (codigo === ultimoCodigoEscaneado && (ahora - tiempoUltimoEscaneo) < 1000) {
        console.log('Ignorando escaneo duplicado:', codigo);
        return;
    }
    
    console.log('Buscando producto con código:', codigo);
    escaneoEnProgreso = true;
    ultimoCodigoEscaneado = codigo;
    tiempoUltimoEscaneo = ahora;
    
    $('.fila-producto').removeClass('fila-seleccionada fila-en-foco');
    
    // Obtener los primeros 10 caracteres del código
    const codigo10 = String(codigo).substring(0, 10);
    
    // Buscar en múltiples atributos con los primeros 10 números
    const filaEncontrada = $(`tr[data-barcode="${codigo}"], 
                              tr[data-co-art="${codigo}"],
                              tr[data-barcode="${codigo10}"], 
                              tr[data-co-art="${codigo10}"]`).first();
    
    if (filaEncontrada.length > 0) {
        console.log('Producto encontrado:', filaEncontrada.data('co-art'));
        ocultarTeclado();
        procesarProductoEncontrado(filaEncontrada, true);
        
        setTimeout(() => {
            $('#buscarProductoInput').val('').focus();
            setTimeout(() => { escaneoEnProgreso = false; }, 500);
        }, 100);
    } else {
        console.log('Producto NO encontrado');
        manejarProductoNoEncontrado(codigo);
        $('#buscarProductoInput').focus().select();
        setTimeout(() => { escaneoEnProgreso = false; }, 300);
    }
}

function buscarProducto() {
    const codigoBuscado = $('#buscarProductoInput').val().trim();
    if (!codigoBuscado) {
        mostrarError('Por favor ingrese un código para buscar');
        return;
    }
    buscarProductoPorCodigo(codigoBuscado);
}

function procesarProductoEncontrado(fila, modoAutoIncremento) {
    if (fila.hasClass('procesando')) return;
    fila.addClass('procesando');
    
    // Retroalimentación visual
    fila.addClass('fila-seleccionada fila-en-foco');
    fila[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
    
    // Animación de resaltado
    fila.addClass('fila-escaneada');
    setTimeout(() => fila.removeClass('fila-escaneada'), 1000);
    
    const checkbox = fila.find('.checkbox-habilitar');
    if (!checkbox.is(':checked')) {
        checkbox.prop('checked', true).change();
    }
    
    const inputCantidad = fila.find('.cantidad-input');
    if (inputCantidad.length > 0) {
        if (modoAutoIncremento) {
            autoIncrementarCantidad(inputCantidad);
        }
        
        if (!modoAutoIncremento) {
            inputCantidad.focus().select();
        }
        
        let valor = inputCantidad.val();
        let cantidadMaxima = inputCantidad.data('cantidad-maxima');
        validarCantidad(inputCantidad, valor, cantidadMaxima);
    }
    
    limpiarCampoBusqueda();
    setTimeout(() => { fila.removeClass('procesando'); }, 1000);
}

function autoIncrementarCantidad(inputElement) {
    if (inputElement.hasClass('incrementando')) return;
    inputElement.addClass('incrementando');
    
    let valorActual = parseInt(inputElement.val()) || 0;
    let cantidadMaxima = parseInt(inputElement.data('cantidad-maxima')) || 0;
    
    if (valorActual < cantidadMaxima) {
        inputElement.val(valorActual + 1);
        triggerValidation(inputElement);
        
        const fila = inputElement.closest('tr');
        fila.addClass('fila-incrementada');
        setTimeout(() => fila.removeClass('fila-incrementada'), 300);
    } else {

        const fila = inputElement.closest('tr');
        const coArt = fila.data('co-art');
        const nombreArticulo = fila.find('.descripcion-texto').text().trim();

         // >>> INICIO DE LA MODIFICACIÓN <<<
        // LÓGICA PARA EXCESO UNITARIO POR ESCANEO
        const valorConIncremento = valorActual + 1;
        if (valorConIncremento === cantidadMaxima + 1) {
            // Caso específico: se excede por exactamente 1 al escanear
            const fila = inputElement.closest('tr');
            const coArt = fila.data('co-art');
            const nombreArticulo = fila.find('.descripcion-texto').text().trim();
            
            // Marcar que esta alerta especial está activa
            alertaExcesoUnitarioActiva = true;
            
            // Actualizamos el valor en el input para que el usuario vea el error
            inputElement.val(valorConIncremento);
            triggerValidation(inputElement);
            
            const mensajeError = `
                <div style="text-align: left;">
                    <strong>¡EXCESO POR ESCANEO DETECTADO!</strong><br>
                    Producto: <strong>${coArt}</strong><br>
                    ${nombreArticulo}<br>
                    Máximo permitido: <strong>${cantidadMaxima}</strong><br>
                    Intentó despachar: <strong style="color: #ffeb3b;">${valorConIncremento}</strong><br><br>
                    
                </div>
            `;
            
            // Llamar a mostrarError con el nuevo modo 'permanente'
            mostrarError(mensajeError, true, true, inputElement); // persistente=true, permanent=true
            
            setTimeout(() => { inputElement.removeClass('incrementando'); }, 500);
            return; // Detenemos la ejecución para no mostrar la alerta genérica
        }
        // >>> FIN DE LA MODIFICACIÓN <<<
        
        if (!alertaExcesoActiva) {
            alertaExcesoActiva = true;
            const mensajeError = `
                <div style="text-align: left;">
                    <strong>¡LÍMITE MÁXIMO ALCANZADO!</strong><br>
                    Producto: <strong>${coArt}</strong><br>
                    ${nombreArticulo}<br>
                    Ya tiene la cantidad máxima: <strong>${cantidadMaxima}</strong>
                </div>
            `;
            mostrarError(mensajeError, true);
        }
    }
    
    setTimeout(() => { inputElement.removeClass('incrementando'); }, 500);
}

function limpiarCampoBusqueda() {
    setTimeout(function() {
        $('#buscarProductoInput').val('').focus();
    }, 100);
}

function manejarProductoNoEncontrado(codigoBuscado) {
    mostrarError('No se encontró ningún producto con el código: ' + codigoBuscado);
    $('#buscarProductoInput').focus().select();
    limpiarCampoBusqueda();
}

// =============================================
// SISTEMA DE VALIDACIÓN DE CANTIDADES
// =============================================

function triggerValidation(inputElement) {
    const valor = inputElement.val() || '0';
    const cantidadMaxima = inputElement.data('cantidad-maxima');
    validarCantidad(inputElement, valor, cantidadMaxima);
}

function validarCantidad(inputElement, cantidadIngresada, cantidadMaxima) {
    cantidadIngresada = parseInt(cantidadIngresada) || 0;
    cantidadMaxima = parseInt(cantidadMaxima) || 0;
    
    const fila = inputElement.closest('tr');
    const coArt = fila.data('co-art');
    const nombreArticulo = fila.find('.descripcion-texto').text().trim();
    
    fila.removeClass('fila-excedida fila-faltante fila-correcta');
    inputElement.removeClass('input-excedido input-faltante input-correcto');
    
    if (cantidadIngresada > cantidadMaxima) {
        fila.addClass('fila-excedida');
        inputElement.addClass('input-excedido');
        
         // >>> INICIO DE LA MODIFICACIÓN <<<
        // Solo mostrar la alerta genérica si la alerta unitaria no está activa
        if (!alertaExcesoActiva && !alertaExcesoUnitarioActiva) {
        // >>> FIN DE LA MODIFICACIÓN <<<
            alertaExcesoActiva = true;
            const mensajeError = `
                <div style="text-align: left;">
                    <strong>¡CANTIDAD EXCEDIDA!</strong><br>
                    Producto: <strong>${coArt}</strong><br>
                    ${nombreArticulo}<br>
                    Máximo permitido: <strong>${cantidadMaxima}</strong><br>
                    Intentó despachar: <strong style="color: #ffeb3b;">${cantidadIngresada}</strong>
                </div>
            `;
            mostrarError(mensajeError, true);
            inputElement.focus().select();
        }
    } else if (cantidadIngresada === cantidadMaxima) {
        fila.addClass('fila-correcta');
        inputElement.addClass('input-correcto');
        if (alertaExcesoActiva) cerrarAlertaExceso();
        
        // NUEVO: Ocultar teclado automáticamente si la cantidad es correcta y estamos en modo cantidad
        if (currentMode === 'quantity' && currentInput && currentInput.is(inputElement)) {
            // Añadir una pequeña animación de éxito antes de ocultar
            inputElement.addClass('cantidad-correcta-animation');
            setTimeout(() => {
                inputElement.removeClass('cantidad-correcta-animation');
                ocultarTeclado();
                
                // Mover al siguiente input o enfocar el buscador
                setTimeout(() => {
                    moverAlSiguienteInput(inputElement);
                }, 300);
            }, 800);
        }
    } else if (cantidadMaxima - cantidadIngresada >= 1) {
        fila.addClass('fila-faltante');
        inputElement.addClass('input-faltante');
        if (alertaExcesoActiva) cerrarAlertaExceso();
    } else {
        if (alertaExcesoActiva) cerrarAlertaExceso();
    }
}

function cerrarAlertaExceso() {
    alertaExcesoActiva = false;
    $('.swf-alert-overlay').each(function() {
        $(this).css('animation', 'swfFadeOut 0.5s ease-out');
        setTimeout(() => $(this).remove(), 500);
    });
}

// =============================================
// SISTEMA DE GESTIÓN DE FOCO
// =============================================

function inicializarSistemaFoco() {
    $(document).on('click', function(e) {
           // >>> INICIO DE LA MODIFICACIÓN <<<
        // Ignorar clics que ocurran sobre una alerta de error
        if ($(e.target).closest('.swf-alert-overlay').length) {
            return;
        }
        // >>> FIN DE LA MODIFICACIÓN <<<
        if (!$(e.target).closest('.cantidad-input, .checkbox-habilitar, .btn, .modal').length) {
            if (!focoBloqueado) {
                setTimeout(restaurarFocoBuscador, 50);
            }
        }
    });
    
    $(document).on('hidden.bs.modal', function() {
        setTimeout(() => {
            if (!focoBloqueado) {
                restaurarFocoBuscador();
            }
        }, 300);
    });
    
    $('.btnEnviarDespacho').on('click', function() {
        if (!$(this).prop('disabled')) {
        }
    });
    
    setTimeout(() => { restaurarFocoBuscador(); }, 1000);
}

function gestionarFoco(bloquear) {
    focoBloqueado = bloquear;
    if (!bloquear) {
        setTimeout(() => {
            if (!focoBloqueado) {
                restaurarFocoBuscador();
            }
        }, tiempoEsperaFoco);
    }
}

function restaurarFocoBuscador() {
    if (focoBloqueado) return;
    const buscador = $('#buscarProductoInput');
    if (buscador.length && buscador.is(':visible')) {
        const inputActivo = $(':focus');
        if (!inputActivo.is('.cantidad-input') && !inputActivo.is('#buscarProductoInput')) {
            buscador.focus();
        }
    }
}

function forzarFocoBuscador() {
    focoBloqueado = false;
    $('#buscarProductoInput').focus().select();
}

function moverAlSiguienteInput(inputActual) {
    const inputs = $('.cantidad-input:not(:disabled)');
    const currentIndex = inputs.index(inputActual);
    
    if (currentIndex < inputs.length - 1) {
        const nextInput = inputs.eq(currentIndex + 1);
        nextInput.focus().select();
    } else {
        ocultarTeclado();
        setTimeout(() => { $('#buscarProductoInput').focus().select(); }, 300);
    }
}

// =============================================
// SISTEMA DE EVENT LISTENERS
// =============================================

function agregarEventListenersCheckboxes() {
    $('.checkbox-habilitar').on('change', function() {
        const estaSeleccionado = $(this).is(':checked');
        const inputId = $(this).data('input-id');
        const inputCantidad = $('#' + inputId);
        
        if (estaSeleccionado) {
            inputCantidad.prop('disabled', false);
            inputCantidad.focus().select();
            $(this).closest('tr').addClass('fila-habilitada');
        } else {
            inputCantidad.prop('disabled', true);
            inputCantidad.val(0);
            const fila = $(this).closest('tr');
            fila.removeClass('fila-habilitada');
            let cantidadMaxima = inputCantidad.data('cantidad-maxima');
            validarCantidad(inputCantidad, 0, cantidadMaxima);
        }
    });
    
    $('td:has(.checkbox-habilitar)').on('click', function(e) {
        if (!$(e.target).is('input[type="checkbox"]')) {
            const checkbox = $(this).find('.checkbox-habilitar');
            checkbox.prop('checked', !checkbox.is(':checked')).change();
        }
    });
}

function agregarEventListeners() {
    $('.cantidad-input').off();
    $('.fila-producto').off();

    $('.cantidad-input').on('focus', function() {
        $('.fila-producto').removeClass('fila-en-foco');
        const fila = $(this).closest('tr');
        fila.addClass('fila-en-foco');
        
        if (fila.hasClass('fila-excedida')) {
            fila.addClass('fila-en-foco fila-excedida');
        } else if (fila.hasClass('fila-faltante')) {
            fila.addClass('fila-en-foco fila-faltante');
        } else if (fila.hasClass('fila-correcta')) {
            fila.addClass('fila-en-foco fila-correcta');
        }
    });
    
    $('.cantidad-input').on('blur', function() {
        const fila = $(this).closest('tr');
        if (!$('#customKeyboard').is(':visible')) {
            fila.removeClass('fila-en-foco');
            $(this).removeClass('input-with-keyboard');
        }
        
        let valor = $(this).val();
        let cantidadMaxima = $(this).data('cantidad-maxima');
        validarCantidad($(this), valor, cantidadMaxima);
        
        setTimeout(() => {
            if (!focoBloqueado && !$('#customKeyboard').is(':visible')) {
                restaurarFocoBuscador();
            }
        }, 200);
    });
    
    $('.cantidad-input').on('input change', function(e) {
        if (e.type === 'change' && $(this).data('lastValue') === $(this).val()) return;
        $(this).data('lastValue', $(this).val());
        
        let valor = $(this).val();
        let cantidadMaxima = $(this).data('cantidad-maxima');
        
        if (valor < 0) { $(this).val(0); valor = 0; }
        if (valor === '') { $(this).val(0); valor = 0; }
        
        validarCantidad($(this), valor, cantidadMaxima);
    });
    
    $('.cantidad-input').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let valor = $(this).val();
            let cantidadMaxima = $(this).data('cantidad-maxima');
            validarCantidad($(this), valor, cantidadMaxima);
        }
    });
    
    $('.fila-producto').on('click', function(e) {
        if (!$(e.target).is('input')) {
            // No mostrar teclado automáticamente
            $(this).find('.cantidad-input').focus().select();
        }
    });
}

// =============================================
// SISTEMA DE DESPACHO COMPLETO
// =============================================

function obtenerTodosLosItems() {
    let todosLosItems = [];
    $('.fila-producto').each(function() {
        const co_art = $(this).data('co-art');
        const inputCantidad = $(this).find('.cantidad-input');
        const cantidadMaxima = parseInt(inputCantidad.data('cantidad-maxima')) || 0;
        const checkbox = $(this).find('.checkbox-habilitar');
        const cantidad = parseInt(inputCantidad.val()) || 0;
        
        todosLosItems.push({
            co_art: co_art,
            cantidad: cantidad,
            cantidad_maxima: cantidadMaxima,
            seleccionado: checkbox.is(':checked'),
            habilitado: !inputCantidad.prop('disabled')
        });
    });
    return todosLosItems;
}

function validarDespachoCompleto() {
    let errors = [];
    const todosLosItems = obtenerTodosLosItems();
    let itemsPendientes = 0;
    let itemsCorrectos = 0;
    let itemsConProblemas = 0;

    todosLosItems.forEach(item => {
        if (item.habilitado) {
            if (item.cantidad <= 0) {
                errors.push(`❌ ${item.co_art}: DEBE TENER CANTIDAD MAYOR A 0`);
                itemsConProblemas++;
            } else if (item.cantidad > item.cantidad_maxima) {
                errors.push(`❌ ${item.co_art}: EXCEDE EL LÍMITE (${item.cantidad} > ${item.cantidad_maxima})`);
                itemsConProblemas++;
            } else if (item.cantidad < item.cantidad_maxima) {
                errors.push(`❌ ${item.co_art}: DESPACHO INCOMPLETO (${item.cantidad} < ${item.cantidad_maxima})`);
                itemsConProblemas++;
            } else {
                itemsCorrectos++;
            }
        } else {
            itemsPendientes++;
        }
    });

    if (itemsPendientes > 0) errors.push(`❌ HAY ${itemsPendientes} ITEM(S) PENDIENTES POR DESPACHAR`);
    const totalItems = todosLosItems.length;
    if (itemsCorrectos !== totalItems) errors.push(`❌ DESPACHO INCOMPLETO: ${itemsCorrectos}/${totalItems} ITEMS CORRECTOS`);

    return { errors: errors, estadisticas: { total: totalItems, correctos: itemsCorrectos, pendientes: itemsPendientes, conProblemas: itemsConProblemas } };
}

function verificarEstadoDespachoCompleto() {
    const validacion = validarDespachoCompleto();
    const btnEnviar = $('.btnEnviarDespacho');
    
    if (validacion.errors.length === 0 && validacion.estadisticas.correctos === validacion.estadisticas.total) {
        btnEnviar.prop('disabled', false)
                 .removeClass('btn-secondary')
                 .addClass('btn-success')
                 .html('<i data-feather="truck"></i> &nbsp;  COMPLETO');
        gestionarFoco(true);
    } else {
        btnEnviar.prop('disabled', true)
                 .removeClass('btn-success')
                 .addClass('btn-secondary')
                 .html('<i data-feather="slash"></i>  &nbsp;  INCOMPLETO');
        gestionarFoco(false);
    }
    feather.replace();
}

function procesarDespachoCompleto() {
    const validacion = validarDespachoCompleto();
    
    if (validacion.errors.length > 0) {
        resaltarProductosConProblemas(validacion.errors);
        Swal.fire({
            icon: 'error',
            title: 'DESPACHO INCOMPLETO',
            html: `
                <div style="text-align: left; max-height: 300px; overflow-y: auto;">
                    <strong>Errores encontrados:</strong><br>
                    ${validacion.errors.join('<br>')}
                </div>
                <br>
                <small>Complete todos los items de la factura antes de continuar</small>
            `,
            confirmButtonText: 'Entendido',
            customClass: { popup: 'swal-wide' }
        });
        return;
    }
    
    const productosDespacho = obtenerTodosLosItems()
        .filter(item => item.habilitado)
        .map(item => ({
            co_art: item.co_art,
            cantidad: item.cantidad,
            cantidad_maxima: item.cantidad_maxima
        }));
    
    confirmarYEnviarDespachoCompleto(productosDespacho, validacion.estadisticas);
}

function confirmarYEnviarDespachoCompleto(productosDespacho, estadisticas) {
    const fact_num = $('#fact_num').val();
    const preparador = $('#co_preparador').val();
    const $comboPreparador = $('#co_preparador');
    
    if (!preparador) {
        Swal.fire({
            title: 'Error',
            text: 'Debe seleccionar un preparador antes de confirmar el despacho',
            icon: 'error',
            confirmButtonColor: '#0343a5'
        }).then(() => {
            $comboPreparador.select2('open');
            $comboPreparador.addClass('campo-error');
            setTimeout(() => { $comboPreparador.removeClass('campo-error'); }, 3000);
        });
        return;
    }
    
    Swal.fire({
        title: '¿CONFIRMAR DESPACHO COMPLETO?',
        html: `
            <div style="text-align: center;">
                <strong>${estadisticas.total} PRODUCTOS COMPLETOS</strong><br>
                <span style="color: green; font-size: 1.2em;">✓ Todos los items de la factura están despachados correctamente</span>
                <br><br>
                <strong>Preparador:</strong> ${preparador}
            </div>
        `,
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#0343a5',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, enviar despacho completo',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = {
                action: 'procesar_despacho_completo',
                fact_num: fact_num,
                status: '1',
                preparador: preparador,
                productos: productosDespacho,
                fecha_despacho: new Date().toISOString()
            };
            enviarDespacho(formData);
        }
    });
}

// =============================================
// FUNCIONES DE COMUNICACIÓN CON SERVIDOR
// =============================================

async function enviarDespacho(formData) {
    try {
        const jsonData = JSON.stringify(formData);
        const response = await $.ajax({
            url: '../admin/index.php?action=despacho&tipo=1&accion=1&datos=2',
            type: 'POST',
            data: jsonData,
            processData: false,
            contentType: 'application/json'
        });
        
        const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
        
        if (jsonResponse.success) {
            await Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: jsonResponse.message || 'Despacho registrado exitosamente',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
            });
            window.location.href = './dashboard';
        } else {
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jsonResponse.message || 'Error en el despacho',
                confirmButtonText: 'Entendido'
            });
        }
        return jsonResponse;
    } catch (error) {
        console.error('Error en enviarDespacho:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Ocurrió un error al procesar la solicitud: ' + error.message,
            confirmButtonText: 'Entendido'
        });
        throw error;
    }
}

function facturaDetalles($fact_nun){
    $.ajax({
        type: "GET",
        url: '../admin/index.php?action=combos&a=998877&c=FacturaData&t=factura&fact_num='+$fact_nun, 
    }).done(function(data) {  
        var i = 0;
        var tope = data.length;
        var contenido = "";
        
        if(tope >= 1){   
            for (var i = 0; i < tope; i++) { 
                let co_art = data[i].co_art;
                let nombre = data[i].dato1;
                let cantidad = data[i].dato2;
                let precio = data[i].dato3;
                let marca = data[i].dato4;
                let barcode=data[i].barcode;

                let inputId = 'cantidad_' + i;
                let checkboxId = 'checkbox_' + i;
                contenido = `<tr class="fila-producto" data-co-art="${co_art}" data-barcode="${barcode}" data-cantidad-maxima="${cantidad}">
                    <td class="py-1 align-middle text-center" data-label="Sel">
                        <input type="checkbox" 
                              id="${checkboxId}" 
                              class="checkbox-habilitar" 
                              data-co-art="${co_art}"
                              data-input-id="${inputId}"
                              style="transform: scale(1.1); cursor: pointer;">
                    </td>
                    <td class="py-1 align-middle text-center" data-label="Código">
                        <span class="small">${co_art}</span>
                    </td>
                    <td class="py-1 align-middle descripcion" data-label="Descripción">
                        <span class="small descripcion-texto">${nombre}</span>
                    </td>
                    <td class="py-1 align-middle text-center" data-label="Marca">
                        <span class="small">${marca}</span>
                    </td>
                    <td class="py-1 align-middle text-center" data-label="Fact">
                        <span class="cantidad-maxima small fw-bold">${cantidad}</span>
                    </td>
                    <td class="py-1 align-middle" data-label="Desp">
                        <div class="d-flex align-items-center justify-content-center">
                            <input type="number" 
                                  id="${inputId}" 
                                  class="form-control form-control-sm cantidad-input" 
                                  value="0" 
                                  data-co-art="${co_art}"
                                  data-cantidad-maxima="${cantidad}"
                                  disabled
                                  style="width: 60px; max-width: 100%; height: 32px; font-size: 14px;">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-teclado-cantidad ml-1" 
                                    data-input-id="${inputId}" title="Usar teclado virtual">
                                <i class="fas fa-keyboard"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
                $('#filaFacturaDetalles').append(contenido);   
            }  
            agregarEventListeners();
            agregarEventListenersCheckboxes();
            
            // Agregar eventos para los nuevos botones de teclado
            $('.btn-teclado-cantidad').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const inputId = $(this).data('input-id');
                const inputElement = $('#' + inputId);
                
                if (!inputElement.prop('disabled')) {
                    mostrarTecladoManual(inputElement, 'quantity');
                }
            });
        }
    });
}

// =============================================
// FUNCIONES DE UTILIDAD
// =============================================

function mostrarError(mensaje, persistente = false) {
    if (!$('#swf-alert-styles').length) {
        const alertStyles = `
        .swf-alert-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center; animation: swfFadeIn 0.3s ease-out; }
        .swf-alert { background: linear-gradient(to bottom, #ff7c7c, #d32f2f); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.4); max-width: 400px; width: 80%; font-family: Arial, sans-serif; font-size: 16px; text-align: center; border: 2px solid #ff4c4c; position: relative; }
        .swf-alert-persistente { padding: 20px 50px 20px 25px; text-align: left; }
        .swf-alert::before { content: '⚠️'; font-size: 32px; display: block; margin-bottom: 15px; }
        .swf-alert-persistente::before { display: inline; margin-right: 15px; margin-bottom: 0; vertical-align: middle; }
        .btn-cerrar-alerta { position: absolute; top: 10px; right: 15px; background: rgba(255,255,255,0.3); border: none; color: white; font-size: 20px; font-weight: bold; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.3s; }
        .btn-cerrar-alerta:hover { background: rgba(255,255,255,0.5); }
        @keyframes swfFadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes swfFadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-20px); } }`;
        $('head').append(`<style id="swf-alert-styles">${alertStyles}</style>`);
    }
    
    const overlay = $('<div class="swf-alert-overlay"></div>');
    
    if (persistente) {
        const alert = $(`<div class="swf-alert swf-alert-persistente"><button class="btn-cerrar-alerta">&times;</button>${mensaje}</div>`);
        overlay.append(alert);
        alert.find('.btn-cerrar-alerta').on('click', function() {
            overlay.css('animation', 'swfFadeOut 0.5s ease-out');
            setTimeout(() => overlay.remove(), 500);
        });
    } else {
        const alert = $(`<div class="swf-alert">${mensaje}</div>`);
        overlay.append(alert);
        setTimeout(() => {
            overlay.css('animation', 'swfFadeOut 0.5s ease-out');
            setTimeout(() => overlay.remove(), 500);
        }, 2000);
    }
    
    $('body').append(overlay);
    playSound('../assets/media/e2.mp3');
}

function playSound(url) {
    const audio = new Audio(url);
    audio.play().catch(e => console.log("Reproducción de audio prevenida por el navegador: ", e));
}

// =============================================
// INICIALIZACIÓN
// =============================================

 $(document).ready(function() {

     
    if ($('#datosFacturaChequear').length) {
        inicializarSistemaFoco();
        setTimeout(() => { initCustomKeyboard(); }, 1000);
      }


   


    // >>> INICIO DE LA MODIFICACIÓN <<<
    // Listener para corregir el exceso unitario al cerrar la alerta
    $(document).on('alertaExcesoUnitarioCerrada', function(event, inputElement) {
        if (inputElement && inputElement.length) {
            const valorActual = parseInt(inputElement.val()) || 0;
            const nuevoValor = valorActual - 1;
            
            if (nuevoValor >= 0) {
                inputElement.val(nuevoValor);
                triggerValidation(inputElement);
            }
        }
        // Resetear la bandera global
        alertaExcesoUnitarioActiva = false;
    });
    // >>> FIN DE LA MODIFICACIÓN <<<
    
    // Verificar estado del despacho
    setInterval(verificarEstadoDespachoCompleto, 1000);
    $(document).on('change input', '.cantidad-input, .checkbox-habilitar', verificarEstadoDespachoCompleto);
    
    // Evento del botón de enviar despacho
    $('.btnEnviarDespacho').off('click').on('click', function() {
        if (!$(this).prop('disabled')) procesarDespachoCompleto();
    });
    
    // Cargar factura si existe
    if ($('#datosFacturaChequear').length) {
        let fact_num = $('#fact_num').val();
        facturaDetalles(fact_num);
    }
});

// =============================================
// ESTILOS CSS PARA EL SISTEMA DE DESPACHO
// =============================================
// Agregar estilos para la funcionalidad de auto-incremento
const estilosAutoIncremento = `
    <style>
    .fila-incrementada {
        animation: highlightIncrement 0.5s ease;
        background-color: rgba(40, 167, 69, 0.1) !important;
    }
    
    .fila-limite-alcanzado {
        animation: highlightLimit 1s ease;
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    
    @keyframes highlightIncrement {
        0% { background-color: transparent; }
        50% { background-color: rgba(40, 167, 69, 0.3); }
        100% { background-color: rgba(40, 167, 69, 0.1); }
    }
    
    @keyframes highlightLimit {
        0% { background-color: transparent; }
        25% { background-color: rgba(220, 53, 69, 0.5); }
        50% { background-color: rgba(220, 53, 69, 0.3); }
        75% { background-color: rgba(220, 53, 69, 0.5); }
        100% { background-color: rgba(220, 53, 69, 0.1); }
    }
    
    /* NUEVO: Animación para cantidad correcta */
    .cantidad-correcta-animation {
        animation: cantidadCorrectaPulse 0.8s ease;
    }
    
    @keyframes cantidadCorrectaPulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        50% { transform: scale(1.05); box-shadow: 0 0 10px 5px rgba(40, 167, 69, 0.3); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }
    </style>
`;

// Mejora: Estilos optimizados para tablet y lector de códigos
const estilosTablet = `
    <style>
    /* Estilos para tablets */
    @media (max-width: 1024px) {
        .custom-keyboard {
            transform: scale(1.1);
            transform-origin: bottom center;
        }
        
        .keyboard-key {
            min-height: 50px !important;
            font-size: 18px !important;
        }
        
        .cantidad-input {
            height: 40px !important;
            font-size: 16px !important;
        }
        
        .checkbox-habilitar {
            transform: scale(1.5) !important;
        }
        
        .btn {
            min-height: 44px !important;
            font-size: 16px !important;
        }
        
        .fila-producto td {
            padding: 12px 8px !important;
        }
        
        .btn-teclado-cantidad {
            height: 40px !important;
            width: 40px !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    }
    
    /* Mejora: Animación para escaneo exitoso */
    .fila-escaneada {
        animation: scanSuccess 1s ease;
    }
    
    @keyframes scanSuccess {
        0% { background-color: transparent; }
        20% { background-color: rgba(40, 167, 69, 0.5); }
        80% { background-color: rgba(40, 167, 69, 0.2); }
        100% { background-color: transparent; }
    }
    
    /* Mejora: Indicador visual para campo de escaneo */
    #buscarProductoInput {
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 12px;
        font-size: 18px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    #buscarProductoInput:focus {
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }
    
    /* Nuevo: Indicador visual para mantenimiento pulsado */
    .touch-hold-indicator {
        background-color: rgba(0, 123, 255, 0.1) !important;
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3) !important;
        transform: scale(1.02);
    }
    
    /* Nuevo: Animación de progreso para mantenimiento pulsado */
    .touch-hold-indicator::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #0056b3);
        animation: progressAnimation ${touchHoldThreshold}ms linear;
        border-radius: 0 0 8px 8px;
    }
    
    @keyframes progressAnimation {
        from { width: 0%; }
        to { width: 100%; }
    }
    
    /* Mejora: Botón grande para enfocar campo de escaneo */
    #focusButton {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        z-index: 1000;
        cursor: pointer;
    }
    
    #focusButton:active {
        transform: scale(0.95);
    }
    
    /* Estilos para botones de teclado de cantidad */
    .btn-teclado-cantidad {
        background-color: rgba(0,123,255,0.1);
        border: 1px solid rgba(0,123,255,0.3);
        color: #007bff;
        border-radius: 4px;
        padding: 4px 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-teclado-cantidad:hover {
        background-color: rgba(0,123,255,0.2);
        transform: scale(1.05);
    }
    
    .btn-teclado-cantidad:active {
        transform: scale(0.95);
    }
    
    /* Estilos para inputs de cantidad con botón alineado */
    .cantidad-input-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    
    .cantidad-input-container .cantidad-input {
        flex: 0 0 auto;
    }
    
    .cantidad-input-container .btn-teclado-cantidad {
        flex: 0 0 auto;
    }
    
    /* Nuevo: Indicador de ayuda para mantenimiento pulsado */
    .help-indicator {
        position: absolute;
        top: -30px;
        right: 0;
        background-color: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
        z-index: 1000;
    }
    
    .search-container:hover .help-indicator {
        opacity: 1;
    }
    
    /* NUEVO: Estilo para inputs de cantidad correcta */
    .input-correcto {
        border-color: #28a745 !important;
        background-color: rgba(40, 167, 69, 0.1) !important;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.3) !important;
    }
    </style>
`;

// Agregar estilos adicionales para tablet
 $('head').append(estilosTablet);
 $('head').append(estilosAutoIncremento);

// Agregar botón para enfocar campo de escaneo
if (!$('#focusButton').length) {
    $('body').append('<button id="focusButton" title="Enfocar campo de escaneo"><i data-feather="hash"></i></button>');
}

// Agregar contenedor para campo de búsqueda con indicador de ayuda
if ($('#buscarProductoInput').length && !$('#buscarProductoInput').parent().hasClass('search-container')) {
    $('#buscarProductoInput').wrap('<div class="search-container position-relative"></div>');
    $('#buscarProductoInput').parent().append('<div class="help-indicator">Mantén presionado para mostrar teclado</div>');
}

// Evento para el botón de enfoque
 $('#focusButton').on('click', function() {
    $('#buscarProductoInput').focus();
    // Vibración si está disponible (para tablets)
    if (navigator.vibrate) {
        navigator.vibrate(100);
    }
});