 $(function () {
    // Validación en tiempo real para el campo de email
    $('#login-email').on('input', function() {
        const $this = $(this);
        if ($this.val().trim().length >= 3) {
            $this.removeClass('is-invalid').addClass('is-valid');
        } else {
            $this.removeClass('is-valid').addClass('is-invalid');
        }
    });
    
    // Validación en tiempo real para el campo de contraseña
    $('#login-password').on('input', function() {
        const $this = $(this);
        if ($this.val().trim().length >= 5) {
            $this.removeClass('is-invalid').addClass('is-valid');
        } else {
            $this.removeClass('is-valid').addClass('is-invalid');
        }
    });
    
    // Inicialización del formulario de login con validación
    $('#loginform').validate({
        rules: {
            'login-email': { 
                required: true,
                minlength: 3
            },
            'login-password': { 
                required: true, 
                minlength: 5 
            }
        },
        messages: {
            'login-email': { 
                required: "Por favor, ingresa tu nombre de usuario",
                minlength: "El usuario debe tener al menos 3 caracteres"
            },
            'login-password': { 
                required: "Por favor, ingresa tu contraseña",
                minlength: "La contraseña debe tener al menos 6 caracteres" 
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-1').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            const email = $("#login-email").val().trim();
            const password = $("#login-password").val().trim();
            
            if (email && password) {
                // Mostrar spinner de carga
                showLoginSpinner();
                
                // Realizar login
                performLogin(email, password);
            }
        }
    });

    // Función para realizar el login
    function performLogin(email, password) {
        $.ajax({
            url: 'admin/index.php?action=login',
            type: 'post',
            data: { email, password },
            beforeSend: function() {
                showLoginSpinner();
            },
            success: function(response) {
                // Ocultar spinner
                hideLoginSpinner();
                
                // Manejar respuesta
                handleLoginResponse(response);
            },
            error: function() {
                // Ocultar spinner
                hideLoginSpinner();
                
                // Mostrar notificación de error con botón deshabilitado
                showLoginMessage(
                    'No se pudo conectar con el servidor. Por favor, verifica tu conexión a internet e inténtalo de nuevo.',
                    'error',
                    'Error de conexión',
                    true  // Mantener el botón deshabilitado mientras se muestra el mensaje
                );
            }
        });
    }

    // Mostrar spinner de carga
    function showLoginSpinner() {
        $('#login-button').prop('disabled', true);
        $('.login-spinner').addClass('active');
    }

    // Ocultar spinner de carga
    function hideLoginSpinner() {
        $('#login-button').prop('disabled', false);
        $('.login-spinner').removeClass('active');
    }

    // Restablecer el botón de login
    function resetLoginButton() {
        let $button = $('#login-button');
        $button.html('Iniciar Sesión');
        $button.prop('disabled', false);
    }

    // Manejar la respuesta del servidor
    function handleLoginResponse(response) {
        const responseHandlers = {
            '1': () => {
                showLoginMessage(
                    'Redirigiendo al panel de administrador...',
                    'success',
                    '¡Bienvenido Administrador!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('admin/'), 2000);
            },
            '2': () => {
                showLoginMessage(
                    'Redirigiendo al panel de vendedor...',
                    'success',
                    '¡Bienvenido Vendedor!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                handleVendedorLogin();
            },
            '3': () => {
                showLoginMessage(
                    'Redirigiendo al panel de gerente...',
                    'success',
                    '¡Bienvenido Gerente!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('gerente/'), 2000);
            },
            '4': () => {
                showLoginMessage(
                    'Redirigiendo al panel de inventario...',
                    'success',
                    '¡Bienvenido al Sistema de Inventario!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('inventario/'), 2000);
            },
            '5': () => {
                showLoginMessage(
                    'Redirigiendo al panel de secretaría...',
                    'success',
                    '¡Bienvenido Secretaria!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('secretaria/'), 2000);
            },
            '6': () => {
                showLoginMessage(
                    'Redirigiendo al panel de conductor...',
                    'success',
                    '¡Bienvenido Conductor!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('chofer/'), 2000);
            },
            '10': () => {
                showLoginMessage(
                    'Redirigiendo al panel de cliente...',
                    'success',
                    '¡Bienvenido Cliente!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('cliente/'), 2000);
            },
            '11': () => {
                showLoginMessage(
                    'Redirigiendo al panel de compras...',
                    'success',
                    '¡Bienvenido al Departamento de Compras!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('compras/'), 2000);
            },
            '12': () => {
                showLoginMessage(
                    'Redirigiendo al panel de ventas...',
                    'success',
                    '¡Bienvenido al Departamento de Ventas!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('ventas/'), 2000);
            },
            '13': () => {
                showLoginMessage(
                    'Redirigiendo al panel de administración...',
                    'success',
                    '¡Bienvenido al Departamento de Cobranzas!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('administracion/'), 2000);
            },
            '14': () => {
                showLoginMessage(
                    'Redirigiendo al panel de gerencia...',
                    'success',
                    '¡Bienvenido al Departamento de Gerencia!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('gerencia/'), 2000);
            },
            '15': () => {
                showLoginMessage(
                    'Redirigiendo al panel de gerencia comercial...',
                    'success',
                    '¡Bienvenido al Departamento de Gerencia Comercial!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('gerenciacomercial/'), 2000);
            },
            '16': () => {
                showLoginMessage(
                    'Redirigiendo al panel de almacén...',
                    'success',
                    '¡Bienvenido al Departamento de Almacén!',
                    true  // Mantener botón deshabilitado durante la redirección
                );
                setTimeout(() => redirectTo('almacen/'), 2000);
            },
            '0': () => {
                showLoginMessage(
                    'El nombre de usuario o la contraseña que has introducido son incorrectos. Por favor, verifica e inténtalo de nuevo.',
                    'error',
                    'Credenciales incorrectas',
                    true  // Mantener botón deshabilitado mientras se muestra el mensaje
                );
            },
            '98': () => {
                showLoginMessage(
                    'Tu cuenta no tiene un rol válido en el sistema. Por favor, contacta al administrador.',
                    'error',
                    'Rol no válido',
                    true  // Mantener botón deshabilitado mientras se muestra el mensaje
                );
            },
            '99': () => {
                showLoginMessage(
                    'Tu cuenta ha sido desactivada temporalmente. Por favor, comunícate con el administrador del sistema para obtener más información.',
                    'warning',
                    'Cuenta desactivada',
                    true  // Mantener botón deshabilitado mientras se muestra el mensaje
                );
            }
        };

        const handler = responseHandlers[response] || (() => {
            console.warn('Respuesta no manejada:', response);
            showLoginMessage(
                'El servidor ha devuelto una respuesta inesperada. Por favor, inténtalo de nuevo más tarde.',
                'error',
                'Error inesperado',
                true  // Mantener botón deshabilitado mientras se muestra el mensaje
            );
        });
        
        handler();
    }

    // Función para redireccionar directamente
    function redirectTo(url) {
        window.location = url;
    }

    // Función para mostrar mensajes dentro del card de login
    function showLoginMessage(message, type = 'error', title = '', disableButton = false) {
        const $container = $('#login-message-container');
        const $icon = $container.find('.login-message-icon');
        const $title = $container.find('.login-message-title-text');
        const $text = $container.find('.login-message-text');
        
        // Deshabilitar el botón si se solicita
        if (disableButton) {
            $('#login-button').prop('disabled', true);
        }
        
        // Limpiar clases anteriores
        $container.removeClass('error success warning info');
        
        // Añadir clase según tipo
        $container.addClass(type);
        
        // Determinar icono según tipo
        let iconHtml = '';
        switch(type) {
            case 'success':
                iconHtml = '<i data-feather="check-circle"></i>';
                break;
            case 'error':
                iconHtml = '<i data-feather="x-circle"></i>';
                break;
            case 'warning':
                iconHtml = '<i data-feather="alert-triangle"></i>';
                break;
            case 'info':
                iconHtml = '<i data-feather="info"></i>';
                break;
            default:
                iconHtml = '<i data-feather="info"></i>';
        }
        
        // Actualizar contenido
        $icon.html(iconHtml);
        $title.text(title);
        $text.text(message);
        
        // Mostrar contenedor
        $container.show();
        
        // Reemplazar iconos de feather
        if (feather) {
            feather.replace();
        }
        
        // Auto cerrar después de 5 segundos para todos los tipos de mensajes
        setTimeout(() => {
            $container.fadeOut(300, function() {
                // Rehabilitar el botón solo si estaba deshabilitado por el mensaje
                if (disableButton) {
                    $('#login-button').prop('disabled', false);
                }
            });
        }, 5000);
    }

    // Función para ocultar el mensaje
    function hideLoginMessage() {
        $('#login-message-container').fadeOut(300, function() {
            // Rehabilitar el botón
            $('#login-button').prop('disabled', false);
        });
    }

    // Manejador específico para login de vendedor
    function handleVendedorLogin() {
        setSessionData('datosCLiente', {
            cliente_des: '0',
            co_cli: '0',
            tipo_precio: '0',
            cliente_facturacion: 0,
            cliente_forma: 0,
            cliente_status: 0
        });
        setTimeout(() => redirectTo('vendedor/'), 2000);
    }

    // Función para guardar datos en localStorage
    function setSessionData(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }
});