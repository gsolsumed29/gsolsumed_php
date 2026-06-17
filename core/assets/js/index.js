 $(document).ready(function() {
    
    // --- 1. VERIFICACIÓN Y CARGA DINÁMICA DE LIBRERÍA ---
    
    function inicializarSistemaLogin() {
        //console.log("Sistema inicializado. jQuery Validate disponible.");

        // --- 2. VALIDACIÓN VISUAL EN TIEMPO REAL (ESTILOS) ---
        
        // Validación para el campo de email
        $('#login-email').on('input', function() {
            const $this = $(this);
            if ($this.val().trim().length >= 3) {
                $this.removeClass('is-invalid').addClass('is-valid');
            } else {
                $this.removeClass('is-valid').addClass('is-invalid');
            }
        });
    
        // Validación para el campo de contraseña
        $('#login-password').on('input', function() {
            const $this = $(this);
            if ($this.val().trim().length >= 5) {
                $this.removeClass('is-invalid').addClass('is-valid');
            } else {
                $this.removeClass('is-valid').addClass('is-invalid');
            }
        });
    
        // --- 3. INICIALIZACIÓN DEL FORMULARIO DE LOGIN CON JQUERY VALIDATE ---
        
        // Verificamos que la función validate exista (doble seguridad)
        if ($.fn.validate) {
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
                        minlength: "La contraseña debe tener al menos 5 caracteres" 
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.mb-1, .form-group').append(error);
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
        } else {
          //  console.error("Error Crítico: jQuery Validate no se pudo cargar.");
            alert("Error de configuración: No se puede cargar el módulo de validación. Verifica tu conexión a internet.");
        }

        // --- 4. FUNCIONES DE APOYO ---

        // Función para realizar el login
        function performLogin(email, password) {
            $.ajax({
                url: 'admin/index.php?action=login', // Asegúrate que esta ruta sea correcta
                type: 'POST',
                data: { email: email, password: password },
                dataType: 'json', // Especificar que esperas JSON es buena práctica
                beforeSend: function() {
                    showLoginSpinner();
                },
                success: function(response) {
                    // Ocultar spinner
                    hideLoginSpinner();
                    
                    // Manejar respuesta
                    handleLoginResponse(response);
                },
                error: function(xhr, status, error) {
                    // Ocultar spinner
                    hideLoginSpinner();
                    
                    console.error("Error AJAX:", error);
                    // Mostrar notificación de error
                    showLoginMessage(
                        'No se pudo conectar con el servidor. (' + status + ' ' + error + ')',
                        'error',
                        'Error de conexión',
                        true 
                    );
                }
            });
        }

        // Mostrar spinner de carga
        function showLoginSpinner() {
            const $button = $('#login-button');
            // Crear el spinner si no existe para que el CSS funcione
            if ($button.find('.login-spinner').length === 0) {
                $button.html('<span class="login-spinner"></span> Cargando...');
            }
            $button.prop('disabled', true);
            $('.login-spinner').addClass('active');
        }

        // Ocultar spinner de carga
        function hideLoginSpinner() {
            const $button = $('#login-button');
            $button.prop('disabled', false);
            // Restaurar texto original si no hay mensaje de error mostrándose
            if (!$('#login-message-container').is(':visible')) {
                 $button.html('Iniciar Sesión');
            }
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
            // Convertir response a string si viene como número o mixto
            const resKey = String(response);

            const responseHandlers = {
                '1': () => {
                    showLoginMessage('Redirigiendo al panel de administrador...', 'success', '¡Bienvenido Administrador!', true);
                    setTimeout(() => redirectTo('admin/'), 2000);
                },
                '2': () => {
                    showLoginMessage('Redirigiendo al panel de vendedor...', 'success', '¡Bienvenido Vendedor!', true);
                    handleVendedorLogin();
                },
                '3': () => {
                    showLoginMessage('Redirigiendo al panel de gerente...', 'success', '¡Bienvenido Gerente!', true);
                    setTimeout(() => redirectTo('gerente/'), 2000);
                },
                '4': () => {
                    showLoginMessage('Redirigiendo al panel de inventario...', 'success', '¡Bienvenido al Sistema de Inventario!', true);
                    setTimeout(() => redirectTo('inventario/'), 2000);
                },
                '5': () => {
                    showLoginMessage('Redirigiendo al panel de secretaría...', 'success', '¡Bienvenido Secretaria!', true);
                    setTimeout(() => redirectTo('secretaria/'), 2000);
                },
                '6': () => {
                    showLoginMessage('Redirigiendo al panel de conductor...', 'success', '¡Bienvenido Conductor!', true);
                    setTimeout(() => redirectTo('chofer/'), 2000);
                },
                '10': () => {
                    showLoginMessage('Redirigiendo al panel de cliente...', 'success', '¡Bienvenido Cliente!', true);
                    setTimeout(() => redirectTo('cliente/'), 2000);
                },
                '11': () => {
                    showLoginMessage('Redirigiendo al panel de compras...', 'success', '¡Bienvenido al Departamento de Compras!', true);
                    setTimeout(() => redirectTo('compras/'), 2000);
                },
                '12': () => {
                    showLoginMessage('Redirigiendo al panel de ventas...', 'success', '¡Bienvenido al Departamento de Ventas!', true);
                    setTimeout(() => redirectTo('ventas/'), 2000);
                },
                '13': () => {
                    showLoginMessage('Redirigiendo al panel de administración...', 'success', '¡Bienvenido al Departamento de Credito y Cobranzas!', true);
                    setTimeout(() => redirectTo('administracion/'), 2000);
                },
                '14': () => {
                    showLoginMessage('Redirigiendo al panel de gerencia...', 'success', '¡Bienvenido al Departamento de Gerencia!', true);
                    setTimeout(() => redirectTo('gerencia/'), 2000);
                },
                '15': () => {
                    showLoginMessage('Redirigiendo al panel de gerencia comercial...', 'success', '¡Bienvenido al Departamento de Gerencia Comercial!', true);
                    setTimeout(() => redirectTo('gerenciacomercial/'), 2000);
                },
                '16': () => {
                    showLoginMessage('Redirigiendo al panel de almacén...', 'success', '¡Bienvenido al Departamento de Almacén!', true);
                    setTimeout(() => redirectTo('almacen/'), 2000);
                },
                '17': () => {
                    showLoginMessage('Redirigiendo al panel de administracion...', 'success', '¡Bienvenido al Departamento de Facturación!', true);
                    setTimeout(() => redirectTo('facturacion/'), 2000);
                },  
                '18': () => {
                    showLoginMessage('Redirigiendo al panel de Asesores de ventas...', 'success', '¡Bienvenido al Departamento de Ventas!', true);
                    setTimeout(() => redirectTo('visitador/'), 2000);
                },
                '19': () => {
                    showLoginMessage('Redirigiendo al panel  de Marketing...', 'success', '¡Bienvenido al Departamento de Mercadeo!', true);
                    setTimeout(() => redirectTo('mercadeo/'), 2000);
                },
                '0': () => {
                    showLoginMessage('El nombre de usuario o la contraseña que has introducido son incorrectos. Por favor, verifica e inténtalo de nuevo.', 'error', 'Credenciales incorrectas', true);
                    resetLoginButton(); // Importante: reactivar botón si falla el login
                },
                '98': () => {
                    showLoginMessage('Tu cuenta no tiene un rol válido en el sistema. Por favor, contacta al administrador.', 'error', 'Rol no válido', true);
                    resetLoginButton();
                },
                '99': () => {
                    showLoginMessage('Tu cuenta ha sido desactivada temporalmente. Por favor, comunícate con el administrador del sistema para obtener más información.', 'warning', 'Cuenta desactivada', true);
                    resetLoginButton();
                }
            };

            const handler = responseHandlers[resKey] || (() => {
                console.warn('Respuesta no manejada:', response);
                showLoginMessage('El servidor ha devuelto una respuesta inesperada. Por favor, inténtalo de nuevo más tarde.', 'error', 'Error inesperado', true);
                resetLoginButton();
            });
        
            handler();
        }

        // Función para redireccionar directamente
        function redirectTo(url) {
            window.location.href = url;
        }

        // Función para mostrar mensajes dentro del card de login
        function showLoginMessage(message, type = 'error', title = '', disableButton = false) {
            const $container = $('#login-message-container');
            
            // Si el contenedor no existe en el HTML, no hacer nada para evitar errores
            if ($container.length === 0) return;

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
                case 'success': iconHtml = '<i data-feather="check-circle"></i>'; break;
                case 'error':   iconHtml = '<i data-feather="x-circle"></i>'; break;
                case 'warning': iconHtml = '<i data-feather="alert-triangle"></i>'; break;
                case 'info':    iconHtml = '<i data-feather="info"></i>'; break;
                default:        iconHtml = '<i data-feather="info"></i>';
            }
            
            // Actualizar contenido
            $icon.html(iconHtml);
            $title.text(title);
            $text.text(message);
            
            // Mostrar contenedor
            $container.show();
            
            // Reemplazar iconos de feather
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Auto cerrar después de 5 segundos para todos los tipos de mensajes
            setTimeout(() => {
                $container.fadeOut(150, function() {
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
            setSessionData('datosCliente', {
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
            try {
                localStorage.setItem(key, JSON.stringify(value));
            } catch (e) {
                console.error("Error guardando en localStorage:", e);
            }
        }
    }

    // --- BLOQUE PRINCIPAL DE CARGA ---
    // Verificamos si $.fn.validate existe. Si no, cargamos el script de CDN.
    if (typeof $.fn.validate === 'undefined') {
        //console.warn("jQuery Validate no detectado. Intentando cargar desde CDN...");
        
        // Usamos getScript de jQuery para cargar el validador dinámicamente
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js')
            .done(function() {
                //console.log("jQuery Validate cargado exitosamente.");
                inicializarSistemaLogin(); // Una vez cargado, ejecutamos toda la lógica
            })
            .fail(function() {
               // console.error("CRÍTICO: No se pudo cargar jQuery Validate. Verifica tu conexión a internet.");
                alert("Error de conexión: No se pudo cargar el módulo de validación. Por favor revisa tu conexión.");
            });
    } else {
        // Si ya está cargado (quizá lo pusiste en el HTML), ejecutamos directo
        inicializarSistemaLogin();
    }
});