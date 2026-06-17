async function cargarPreguntasDinamicas(co_cli) {
    try {
        // 1. Obtener las preguntas desde la API
        const response = await $.get(`../admin/index.php?action=encuestas&c=EncuestaData&a=1&tabla=jm_visitas_preguntas&filtro`, { co_cli: co_cli });
        const preguntas = Array.isArray(response) ? response : [response];
      //  console.log('Preguntas recibidas:', preguntas);

        // 2. Limpiar el contenedor principal
        const $cardBody = $('.preguntasEncuesta').empty();
        
        // 3. Generar el campo oculto para el código de cliente
        $cardBody.append(
            $('<input>', {
                type: 'hidden',
                class: 'form-control co_cli',
                id: 'co_cli',
                name: 'co_cli',
                value: co_cli
            })
        );
        
        // 4. Agrupar preguntas por sección
        const preguntasPorSeccion = {};
        
        $.each(preguntas, function(_, pregunta) {
            const seccionId = pregunta.idSeccion || '1';
            const seccionNombre = pregunta.seccion || 'Sin sección';
            
            if (!preguntasPorSeccion[seccionId]) {
                preguntasPorSeccion[seccionId] = {
                    nombre: seccionNombre,
                    preguntas: []
                };
            }
            
            preguntasPorSeccion[seccionId].preguntas.push(pregunta);
        });
        
        // 5. Generar las secciones y sus preguntas
        Object.keys(preguntasPorSeccion).sort().forEach(seccionId => {
            const seccion = preguntasPorSeccion[seccionId];
            
            // Crear contenedor de sección
            const $seccionDiv = $('<div>', {
                class: 'seccion-preguntas mb-5',
                'data-seccion-id': seccionId
            });
            
            // Crear título de sección
            const $tituloSeccion = $('<h3>', {
                class: 'titulo-seccion mb-3 text-primary fw-bold border-bottom pb-2',
                text: seccion.nombre
            });
            
            $seccionDiv.append($tituloSeccion);
            
            // Generar preguntas de esta sección
            $.each(seccion.preguntas, function(_, pregunta) {
                const $preguntaDiv = $('<div>', {
                    class: 'mb-4 pregunta',
                    'data-pregunta-id': pregunta.id,
                    'data-tipo': pregunta.tipo_respuesta,
                    'data-co-pregunta': pregunta.co_pregunta.trim(),
                    'data-seccion-id': seccionId
                });
                
                // Crear label
                const $label = $('<label>', {
                    class: 'form-label',
                    for: `pregunta-${pregunta.id}`,
                    text: pregunta.pre_des
                });
                
                // Marcar como requerido si aplica
                if(pregunta.es_requerida === "1") {
                    $label.addClass('required-field')
                         .append($('<span>', { class: 'text-danger', text: ' ' }));
                }
                
                $preguntaDiv.append($label);
                
                // Generar campo de respuesta según el tipo
                switch(pregunta.tipo_respuesta) {
                    case '1': // Radio buttons
                        generarOpcionesRadio(pregunta, $preguntaDiv);
                        break;
                    case '2': // Select simple
                        generarSelect(pregunta, $preguntaDiv);
                        break;
                    case '3': // Select múltiple
                        generarSelectMultiple(pregunta, $preguntaDiv);
                        break;
                    case '4': // Textarea
                        generarTextarea(pregunta, $preguntaDiv);
                        break;
                    case '5': // Input text
                        generarInputText(pregunta, $preguntaDiv);
                        break;
                    case '6': // Fecha
                        generarInputFecha(pregunta, $preguntaDiv);
                        break;
                    default:
                        console.warn(`Tipo de respuesta no soportado: ${pregunta.tipo_respuesta}`);
                        generarInputText(pregunta, $preguntaDiv);
                }
               

                $seccionDiv.append($preguntaDiv);
            });
            
            $cardBody.append($seccionDiv);
        });
        
        // 6. Agregar botón de enviar
        // agregarBotonEnviar($cardBody);
        
        // 7. Inicializar componentes dinámicos
        inicializarComponentesDinamicos();

        
    } catch (error) {
        console.error('Error al cargar preguntas:', error);
        mostrarError('Ocurrió un error al cargar el formulario. Por favor recarga la página.');
    }
}

function agregarLogicaCondicional(pregunta, $contenedor) {
    const logica = pregunta.logica_condicional;
    
    if(logica.tipo === 'mostrar_si') {
        $(document).on('change', `[name="${logica.pregunta_observada}"]`, function() {
            const mostrar = $(this).val() === logica.valor_esperado;
            $contenedor.toggle(mostrar);
            
            const $requiredField = $contenedor.find('[required]');
            if($requiredField.length) {
                $requiredField.prop('required', mostrar);
            }
        });
    }
}

// Funciones auxiliares refactorizadas

function generarOpcionesRadio(pregunta, $contenedor) {
    const opciones = pregunta.opciones_respuesta.split(',');
    const $opcionesDiv = $('<div>');
    
    opciones.forEach((opcion, index) => {
        const valor = opcion.trim().toLowerCase().replace(/\s+/g, '_');
        const idUnico = `pregunta-${pregunta.id}-opcion-${index}`;
        
        $opcionesDiv.append(
            $('<div>', { class: 'form-check' }).append(
                $('<input>', {
                    class: 'form-check-input',
                    type: 'radio',
                    name: `pregunta-${pregunta.co_pregunta.trim()}`,
                    id: idUnico,
                    value: valor,
                    required: pregunta.es_requerida === "1"
                }),
                $('<label>', {
                    class: 'form-check-label',
                    for: idUnico,
                    text: opcion.trim()
                })
            )
        );
    });
    
    $contenedor.append($opcionesDiv);
}

function generarSelect(pregunta, $contenedor) {
    const opciones = pregunta.opciones_respuesta.split(',');
    const $select = $('<select>', {
        class: 'form-select',
        id: `pregunta-${pregunta.id}`,
        name: `pregunta-${pregunta.co_pregunta.trim()}`,
        required: pregunta.es_requerida === "1"
    }).append(
        $('<option>', {
            selected: true,
            disabled: true,
            text: 'Seleccione una opción'
        })
    );
    
    opciones.forEach(opcion => {
        const valor = opcion.trim().toLowerCase().replace(/\s+/g, '_');
        $select.append(
            $('<option>', { value: valor, text: opcion.trim() })
        );
    });
    
    $contenedor.append($select);
}

function generarSelectMultiple(pregunta, $contenedor) {

    
    const opciones = pregunta.opciones_respuesta.split(',');
    const $select = $('<select>', {
        class: 'select2 form-select',
        id: `pregunta-${pregunta.id}`,
        name: `pregunta-${pregunta.co_pregunta.trim()}[]`,
        multiple: true,
        required: pregunta.es_requerida === "1"
    });
    
    opciones.forEach(opcion => {
        const valor = opcion.trim().toLowerCase().replace(/\s+/g, '_');
        $select.append($('<option>', { value: valor, text: opcion.trim() }));
    });
    
    $contenedor.append($select);
}

function generarTextarea(pregunta, $contenedor) {
    $contenedor.append(
        $('<textarea>', {
            class: 'form-control',
            id: `pregunta-${pregunta.id}`,
            name: `pregunta-${pregunta.co_pregunta.trim()}`,
            rows: 3,
            required: pregunta.es_requerida === "1"
        })
    );
}

function generarInputText(pregunta, $contenedor) {
    $contenedor.append(
        $('<input>', {
            type: 'text',
            class: 'form-control',
            id: `pregunta-${pregunta.id}`,
            name: `pregunta-${pregunta.co_pregunta.trim()}`,
            required: pregunta.es_requerida === "1"
        })
    );
}

function generarInputFecha(pregunta, $contenedor) {
    const $inputGroup = $('<div>', { class: 'input-group date' }).append(
        $('<input>', {
            type: 'text',
            class: 'form-control flatpickr-basic',
            id: `pregunta-${pregunta.id}`,
            name: `pregunta-${pregunta.co_pregunta.trim()}`,
            placeholder: 'YYYY-MM-DD',
            readonly: true,
            required: pregunta.es_requerida === "1"
        }),
        $('<span>', { class: 'input-group-text' }).append(
            $('<i>', { class: 'fas fa-calendar-alt' })
        )
    );
    
    $contenedor.append($inputGroup);
}
// Variable global para el manejo de cámara
let camara = null;

function inicializarComponentesDinamicos() {
    // Inicializar select2
    if($.fn.select2) {
        $('.select2').select2();
    }
    
    // Inicializar flatpickr para fechas
    if(window.flatpickr) {
        $('.flatpickr-basic').flatpickr({
            dateFormat: 'Y-m-d'
        });
    }
    
    // Inicializar feather icons
    if(window.feather) {
        feather.replace();
    }
 // Inicializar carga de foto
    inicializarCargaFoto();
}




function mostrarError(mensaje) {
    $('.card-body').prepend(
        $('<div>', {
            class: 'alert alert-danger',
            text: mensaje
        })
    );
}


function agregarLogicaCondicional(pregunta, $contenedor) {
    const logica = pregunta.logica_condicional;
    
    if (!logica) return;
    
    // Ocultar la pregunta inicialmente si tiene lógica condicional
    $contenedor.hide();
    
    switch(logica.tipo) {
        case 'mostrar_si':
            manejarMostrarSi(logica, $contenedor);
            break;
        case 'ocultar_si':
            manejarOcultarSi(logica, $contenedor);
            break;
        case 'requerir_si':
            manejarRequerirSi(logica, $contenedor);
            break;
        default:
            console.warn('Tipo de lógica condicional no soportado:', logica.tipo);
    }
}

function manejarMostrarSi(logica, $contenedor) {
    const observador = `[name="${logica.pregunta_observada}"]`;
    
    // Verificar el estado inicial
    verificarEstadoInicial(observador, logica.valor_esperado, $contenedor, true);
    
    // Escuchar cambios en la pregunta observada
    $(document).on('change', observador, function() {
        const mostrar = obtenerValorComparado($(this), logica.valor_esperado);
        $contenedor.toggle(mostrar);
        
        // Manejar requeridos
        manejarRequeridos($contenedor, mostrar);
        
        console.log(`Mostrando pregunta: ${mostrar} por cambio en ${logica.pregunta_observada}`);
    });
}

function manejarOcultarSi(logica, $contenedor) {
    const observador = `[name="${logica.pregunta_observada}"]`;
    
    // Verificar el estado inicial
    verificarEstadoInicial(observador, logica.valor_esperado, $contenedor, false);
    
    // Escuchar cambios en la pregunta observada
    $(document).on('change', observador, function() {
        const ocultar = obtenerValorComparado($(this), logica.valor_esperado);
        $contenedor.toggle(!ocultar);
        
        // Manejar requeridos
        manejarRequeridos($contenedor, !ocultar);
        
        console.log(`Ocultando pregunta: ${ocultar} por cambio en ${logica.pregunta_observada}`);
    });
}

function manejarRequerirSi(logica, $contenedor) {
    const observador = `[name="${logica.pregunta_observada}"]`;
    
    // Escuchar cambios en la pregunta observada
    $(document).on('change', observador, function() {
        const requerir = obtenerValorComparado($(this), logica.valor_esperado);
        
        // Encontrar todos los campos requeridos dentro del contenedor
        const $camposRequeridos = $contenedor.find('[required]');
        
        if ($camposRequeridos.length) {
            $camposRequeridos.prop('required', requerir);
            console.log(`Requerido cambiado a: ${requerir} para pregunta dependiente`);
        }
    });
}

function verificarEstadoInicial(observador, valorEsperado, $contenedor, estadoMostrar) {
    // Verificar el estado actual del campo observado
    const $campoObservado = $(observador);
    
    if ($campoObservado.length) {
        const valorActual = obtenerValorCampo($campoObservado);
        const coincide = compararValores(valorActual, valorEsperado);
        
        // Aplicar estado inicial
        $contenedor.toggle(estadoMostrar ? coincide : !coincide);
        manejarRequeridos($contenedor, estadoMostrar ? coincide : !coincide);
        
        console.log(`Estado inicial: ${coincide ? 'visible' : 'oculto'}`);
    }
}

function obtenerValorCampo($campo) {
    const tipo = $campo.attr('type');
    
    if (tipo === 'checkbox' || tipo === 'radio') {
        return $campo.filter(':checked').val() || '';
    }
    
    if ($campo.is('select')) {
        return $campo.is('[multiple]') ? $campo.val() || [] : $campo.val() || '';
    }
    
    return $campo.val() || '';
}

function obtenerValorComparado($campo, valorEsperado) {
    const valorActual = obtenerValorCampo($campo);
    return compararValores(valorActual, valorEsperado);
}

function compararValores(valorActual, valorEsperado) {
    // Manejar arrays (select múltiple)
    if (Array.isArray(valorActual)) {
        return valorActual.includes(valorEsperado);
    }
    
    // Manejar strings
    return valorActual.toString() === valorEsperado.toString();
}

function manejarRequeridos($contenedor, esVisible) {
    const $camposRequeridos = $contenedor.find('[required]');
    
    if ($camposRequeridos.length) {
        $camposRequeridos.prop('required', esVisible);
        
        // Si se oculta, limpiar validación
        if (!esVisible) {
            $camposRequeridos.removeClass('is-invalid');
        }
    }
}

// Función para inicializar toda la lógica condicional después de cargar las preguntas
function inicializarLogicaCondicional() {
    $('.pregunta').each(function() {
        const $pregunta = $(this);
        const preguntaId = $pregunta.data('pregunta-id');
        const tieneLogica = $pregunta.data('tiene-logica');
        
        if (tieneLogica) {
            // Aquí podrías cargar la lógica condicional desde un atributo data
            const logica = $pregunta.data('logica-condicional');
            if (logica) {
                agregarLogicaCondicional({ logica_condicional: logica }, $pregunta);
            }
        }
    });
}

    // Función para manejar la carga y previsualización de la foto
    function inicializarCargaFoto() {
    const $fotoInput = $('#fotoPuntoVenta');
    const $previewContainer = $('#previewContainer');
    const $previewImage = $('#previewImage');
    const $removeButton = $('#removePhoto');
    const $photoStatus = $('#photoStatus');
    const $photoSection = $('.photo-section');
    
    // Evento para seleccionar archivo
    $fotoInput.on('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar tipo de archivo
            if (!file.type.match('image.*')) {
                mostrarEstadoFoto('Por favor selecciona una imagen válida (JPEG, PNG, GIF)', 'error');
                resetearFoto();
                return;
            }
            
            // Validar tamaño (máximo 5MB)
            if (file.size > 5 * 1024 * 1024) {
                mostrarEstadoFoto('La imagen debe ser menor a 5MB', 'error');
                resetearFoto();
                return;
            }
            
            // Crear previsualización
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $previewImage.attr('src', e.target.result);
                $previewContainer.show();
                mostrarEstadoFoto('Foto cargada correctamente', 'success');
            };
            
            reader.onerror = function() {
                mostrarEstadoFoto('Error al cargar la imagen', 'error');
                resetearFoto();
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // Evento para el botón de eliminar
    $removeButton.on('click', function() {
        resetearFoto();
        mostrarEstadoFoto('Foto eliminada', 'info');
    });
    
  
    
    function resetearFoto() {
        $fotoInput.val(''); // Limpiar input
        $previewContainer.hide();
        $previewImage.attr('src', '#');
        $photoStatus.hide();
    }
    
    function mostrarEstadoFoto(mensaje, tipo) {
        $photoStatus.removeClass('alert-info alert-success alert-danger')
                   .addClass('alert-' + tipo)
                   .text(mensaje)
                   .show();
        
        // Ocultar después de 3 segundos para mensajes de éxito/info
        if (tipo !== 'error') {
            setTimeout(() => {
                $photoStatus.fadeOut();
            }, 3000);
        }
    }
}

    
function validarFoto() {
            const $fotoInput = $('#fotoPuntoVenta');
            const file = $fotoInput[0].files[0];
            
            if (!file) {
                return {
                    valida: false,
                    mensaje: 'Debe seleccionar una foto del punto de venta'
                };
            }
            
            // Validaciones adicionales
            if (!file.type.match('image.*')) {
                return {
                    valida: false,
                    mensaje: 'El archivo debe ser una imagen válida (JPEG, PNG, GIF)'
                };
            }
            
            if (file.size > 5 * 1024 * 1024) {
                return {
                    valida: false,
                    mensaje: 'La imagen no debe exceder 5MB'
                };
            }
            
            return {
                valida: true,
                archivo: file
            };
}

// Inicialización al cargar la página
$(document).ready(function() {

         


    $('body').on('click', '#btnRegistrarEncuesta', function() {
    (async () => {
        try {
            // 1. Confirmación inicial
            const { isConfirmed } = await Swal.fire({
                title: '¿Desea enviar la encuesta?',
                text: "Tenga en cuenta que la información enviada no podrá ser modificada posteriormente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0343a5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            });

            if (!isConfirmed) return;

            // 2. Validación de campos requeridos
            let formIsValid = true;
            const formData = new FormData();
            formData.append('co_cli', $('#co_cli').val());
            
            let $firstInvalidField = null;
            let firstInvalidMessage = '';

            // Recorrer todas las preguntas dinámicas
            $('.pregunta').each(function() {
                const $pregunta = $(this);
                const preguntaId = $pregunta.data('pregunta-id');
                const coPregunta = $pregunta.data('co-pregunta').trim();
                const tipoRespuesta = $pregunta.data('tipo');
                const esRequerida = $pregunta.find('.required-field').length > 0;
                
                let $input;
                let valor = '';
                let isValid = true;
            
                // Buscar elementos usando el contenedor de la pregunta
                switch(tipoRespuesta) {
                    case 1: // Radio buttons
                        $input = $pregunta.find('input[type="radio"]:checked');
                        valor = $input.length ? $input.val() : '';
                        break;
            
                    case 2: // Select simple
                        $input = $pregunta.find('select');
                        valor = $input.length ? $input.val() : '';
                        break;
                        
                    case 3: // Select múltiple
                        $input = $pregunta.find('select');
                        const selectedOptions = $input.length ? $input.val() || [] : [];
                        valor = selectedOptions.join(', ');
                        isValid = selectedOptions.length > 0;
                        break;                            
                    
                    case 4: // Textarea
                        $input = $pregunta.find('textarea');
                        valor = $input.length ? $input.val().trim() : '';
                        break;
                        
                    case 5: // Input text
                    case 6: // Fecha
                        $input = $pregunta.find('input');
                        valor = $input.length ? $input.val().trim() : '';
                        break;
                }
            
                // Para campos NO requeridos que estén vacíos, asignar "N/A"
                if (!esRequerida && (!valor || valor === '')) {
                    valor = "N/A";
                }
            
                // Validar campo requerido
                if (esRequerida && (!isValid || !valor || valor === '')) {
                    // Obtener solo el texto de la pregunta, no de las opciones
                    const $label = $pregunta.find('label').first();
                    let preguntaTexto = $label.contents().filter(function() {
                        // Filtrar solo el texto directo (no el de los hijos)
                        return this.nodeType === 3; // Node.TEXT_NODE
                    }).text().trim();
                    
                    // Limpiar el texto (remover asterisco y espacios extras)
                    preguntaTexto = preguntaTexto.replace(/\s*\*$/, '').trim();
                    
                    if (formIsValid) {
                        firstInvalidMessage = `El campo "${preguntaTexto}" es obligatorio`;
                        formIsValid = false;
                    }
                    
                    if (!$firstInvalidField && $input && $input.length) {
                        $firstInvalidField = $input;
                    }
                }
            
                formData.append(coPregunta, valor);
            });
            // Mostrar error si hay campos inválidos
              if (!formIsValid) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Campo requerido',
                        text: firstInvalidMessage,
                        confirmButtonText: 'Entendido'
                    });

                    if ($firstInvalidField) {
                        $firstInvalidField.focus();
                    }
                    return;
                }

                                
              // 3. Validación de ubicación GPS (opcional)
                if ($('#latitude').text() === 'No disponible') {
                    const { isConfirmed: confirmLocation } = await Swal.fire({
                        title: 'Ubicación requerida',
                        text: "No se ha capturado la ubicación GPS. ¿Desea intentarlo ahora?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0343a5',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Obtener ubicación',
                        cancelButtonText: 'Continuar sin ubicación'
                    });

                    if (confirmLocation) {
                        $('#getLocation').click();
                        return;
                    }
                }

                // 3.1 Validación de la foto
                const validacionFoto = validarFoto();
                if (!validacionFoto.valida) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Foto requerida',
                        text: validacionFoto.mensaje,
                        confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Entendido'
                    });
                    
                    // Hacer scroll a la sección de foto
                    $('html, body').animate({
                        scrollTop: $('.photo-section').offset().top - 100
                    }, 500);
                    
                    // Enfocar el input de foto
                    $('#fotoPuntoVenta').click();
                    return;
                }else{
                        var fotoInput = $('#fotoPuntoVenta')[0];
                     formData.append('fotoPuntoVenta', fotoInput.files[0]);
                }

                                
             
                // Agregar datos de ubicación
                formData.append('latitude', $('#latitude').text());
                formData.append('longitude', $('#longitude').text());
                formData.append('accuracy', $('#accuracy').text());
                formData.append('timestamp', $('#timestamp').text());

                // 4. Mostrar carga
                Swal.fire({
                    title: 'Enviando encuesta',
                    html: 'Por favor espere mientras procesamos su información...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                            // Antes del AJAX, verifica que la foto esté en el FormData
                console.log('Archivos en FormData:', fotoInput.files);
                if (fotoInput.files.length > 0) {
                    console.log('Nombre archivo:', fotoInput.files[0].name);
                    console.log('Tamaño archivo:', fotoInput.files[0].size);
                    formData.append('fotoPuntoVenta', fotoInput.files[0]);
                }

                // 5. Enviar datos por AJAX
                console.log(formData);
                const response = await $.ajax({
                    url: '../admin/index.php?action=cliente&tipo=1&accion=4&datos=1',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false
                });

                // 6. Manejar respuesta
                let data;
                try {
                    data = typeof response === 'string' ? JSON.parse(response) : response;
                } catch (e) {
                    data = { success: false, message: 'Respuesta no válida del servidor' };
                }

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Encuesta enviada',
                        text: data.message || 'La encuesta se ha enviado correctamente',
                        confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Aceptar'
                    });
                  
                    // Limpiar formulario
                    $('.preguntasEncuesta').empty();
                    
                    // Resetear ubicación
                    $('#latitude, #longitude, #accuracy, #timestamp').text('No disponible');
                    
                    // Recargar datos si es necesario
                    if (typeof recargarDatos === 'function') {
                        recargarDatos();
                    }
                      window.location.href = `index.php?view=visitas`;
                } else {
                    throw new Error(data.message || 'Error al procesar la encuesta');
                }

        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error al enviar el formulario',
                confirmButtonColor: '#0343a5',
                confirmButtonText: 'Entendido'
            });
        }
    })();
    });


    if($('.m_visitas_cantidato').length){

        //console.log('Cargar para adjuntar foto');
         inicializarComponentesDinamicos() 
    }

    
    if($('.m_clientes_c2').length){

        //console.log('Cargar para adjuntar foto');
         inicializarComponentesDinamicos() 
    }

    
});


