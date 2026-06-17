$(document).ready(function() {
    
    // Esperar un poco más antes de ocultar el loading
    setTimeout(function() {
        $('#loading').fadeOut(500);
    }, 1000);
    
    // Función segura para inicializar componentes
    function safeInitialize() {
        try {
            // Solo inicializar componentes si existen
            const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            if (tooltips.length > 0) {
                tooltips.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
            
            const popovers = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            if (popovers.length > 0) {
                popovers.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl);
                });
            }
            
            // Tu lógica actual aquí
            initializeForgotPassword();
            
        } catch (error) {
            console.warn('Error durante inicialización:', error);
            // Inicializar de todos modos
            initializeForgotPassword();
        }
    }
    
    // Función principal de inicialización del formulario
    function initializeForgotPassword() {
        // --- 1. VALIDACIÓN VISUAL EN TIEMPO REAL ---
        
        $('#email').on('input', function() {
            const $this = $(this);
            if ($this.val().trim().length >= 3) {
                $this.removeClass('is-invalid').addClass('is-valid');
                $this.next('.invalid-feedback').hide();
            } else {
                $this.removeClass('is-valid').addClass('is-invalid');
            }
        });
        
        // --- 2. INICIALIZACIÓN DEL FORMULARIO ---
        
        if ($.fn.validate) {
            $('#forgot-form').validate({
                rules: {
                    'email': { 
                        required: true,
                        email: true,
                        minlength: 3
                    }
                },
                messages: {
                    'email': { 
                        required: "Por favor, ingresa tu correo electrónico",
                        email: "Por favor, ingresa un correo válido",
                        minlength: "El correo debe tener al menos 3 caracteres"
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function(form) {
                    const email = $("#email").val().trim();
                    
                    if (email) {
                        // Mostrar spinner
                        showSpinner();
                        
                        // Realizar petición de recuperación
                        performPasswordReset(email);
                    }
                }
            });
        } else {
            showLoginMessage("Error: No se pudo cargar el módulo de validación.", "error", "Error de Sistema", false);
        }
    }
    
    // Inicializar de manera segura
    setTimeout(safeInitialize, 500);
    
    // --- 3. LÓGICA DE NEGOCIO (AJAX) ---

    function performPasswordReset(email) {
        // URL del backend para recuperación
        //const url = 'admin/index.php?action=recuperar_password'; 

        $.ajax({
           url: 'admin/index.php?action=user', // Asegúrate que esta ruta sea correcta
            type: 'POST',
            data: { email: email, tipo: '1' , accion: '7', datos : '1' }, // Enviar el tipo para diferenciar en el backend
            dataType: 'json',
            beforeSend: function() {
                showSpinner();
            },
            success: function(response) {
                hideSpinner();
                handleResetResponse(response);
            },
            error: function(xhr, status, error) {
                hideSpinner();
                console.error("Error AJAX:", error);
                showLoginMessage(
                    'No se pudo conectar con el servidor. Verifica tu conexión.',
                    'error',
                    'Error de conexión',
                    true 
                );
            }
        });
    }

    // --- 4. MANEJO DE RESPUESTAS ---
    
    function handleResetResponse(response) {
        // Convertir a string
        const resKey = String(response);

        const responseHandlers = {
            '1': () => {
                // Éxito: Correo enviado
                showLoginMessage(
                    'Se han enviado las instrucciones a tu correo electrónico. Por favor revisa tu bandeja de entrada.', 
                    'success', 
                    '¡Correo Enviado!', 
                    true
                );
                
                // Redirigir al login después de 4 segundos
                setTimeout(() => {
                    window.location.href = './';
                }, 4000);
            },
            '0': () => {
                // Error: Usuario no encontrado o genérico
                showLoginMessage(
                    'El correo electrónico no está registrado en nuestro sistema o ocurrió un error al procesar la solicitud.', 
                    'error', 
                    'Error de Recuperación', 
                    true
                );
                resetButton();
            },
            '99': () => {
                // Error genérico
                showLoginMessage(
                    'Hubo un problema interno. Intenta más tarde.', 
                    'warning', 
                    'Error del Servidor', 
                    true
                );
                resetButton();
            }
        };

        const handler = responseHandlers[resKey] || (() => {
            console.warn('Respuesta no manejada:', response);
            showLoginMessage(
                'El servidor devolvió una respuesta inesperada.', 
                'warning', 
                'Atención', 
                true
            );
            resetButton();
        });
    
        handler();
    }

    // --- 5. FUNCIONES UI ---

    function showSpinner() {
        const $spinner = $('#loginSpinner');
        const $button = $('#btn-enviar');
        $button.prop('disabled', true);
        $button.find('.btn-text').text('Enviando...');
        $spinner.addClass('active');
    }

    function hideSpinner() {
        const $spinner = $('#loginSpinner');
        const $button = $('#btn-enviar');
        $button.prop('disabled', false);
        $button.find('.btn-text').text('Enviar Instrucciones');
        $spinner.removeClass('active');
    }

    function resetButton() {
        const $button = $('#btn-enviar');
        $button.prop('disabled', false);
        $button.find('.btn-text').text('Enviar Instrucciones');
    }

    function showLoginMessage(message, type = 'error', title = '', disableButton = false) {
        const $container = $('#login-message-container');
        const $icon = $container.find('.login-message-icon');
        const $title = $container.find('.login-message-title-text');
        const $text = $container.find('.login-message-text');
        
        if (disableButton) {
            $('#btn-enviar').prop('disabled', true);
        }
        
        $container.removeClass('error success warning info');
        $container.addClass(type);
        
        let iconHtml = '';
        switch(type) {
            case 'success': 
                iconHtml = '<i class="fas fa-check-circle"></i>'; 
                break;
            case 'error':   
                iconHtml = '<i class="fas fa-exclamation-circle"></i>'; 
                break;
            case 'warning': 
                iconHtml = '<i class="fas fa-exclamation-triangle"></i>'; 
                break;
            default:        
                iconHtml = '<i class="fas fa-info-circle"></i>';
        }
        
        $icon.html(iconHtml);
        $title.text(title);
        $text.text(message);
        
        $container.show();
        
        // Auto ocultar después de 5 segundos
        setTimeout(() => {
            $container.fadeOut(150, function() {
                if (disableButton) {
                    $('#btn-enviar').prop('disabled', false);
                }
            });
        }, 5000);
    }
});