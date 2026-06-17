<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="JMobile - Sistema integral de ventas, inventario y facturación diseñado para optimizar la gestión comercial de tu negocio. Control de stock, reportes en tiempo real y facturación electrónica en una plataforma eficiente y fácil de usar.">
    <meta name="keywords" content="Sistema de ventas Software de inventario Facturación electrónica Gestión comercial Control de stock">
    <meta name="author" content="Soluciones Jm">
    <title id="name2">Grupo Solsumed, CA</title>
  
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logo_solo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/extensions/ext-component-sweet-alerts.css">
    <!-- END: Custom CSS-->
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('../../../app-assets/images/pages/lobby_grupo_solsumed.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
        }
        
        .login-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex: 1;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            transform: translateZ(0);
            transition: all 0.3s ease;
        }
        
        .login-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            max-height: 120px;
            width: auto;
            max-width: 100%;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover img {
            transform: scale(1.20);
        }
        
        /* Prevenir zoom en iOS al enfocar inputs */
        @media screen and (max-width: 768px) {
            input, select, textarea {
                font-size: 16px !important;
            }
            
            .login-wrapper {
                padding: 10px;
                align-items: center;
            }
            
            .login-container {
                margin: 0;
                padding: 1.5rem;
                max-width: 90%;
            }
            
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                height: auto;
            }
            
            .login-wrapper {
                height: auto;
                min-height: auto;
            }
        }
        
        @media (max-width: 360px) {
            .login-container {
                padding: 1.2rem;
            }
            
            .logo-container img {
                max-height: 100px;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) and (orientation: portrait) {
            .login-container {
                max-width: 450px;
            }
        }

        /* Estilos para el contenedor de mensajes */
        .login-message-container {
            margin-bottom: 1rem;
            border-radius: 0.357rem;
            padding: 0.8rem 1rem;
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .login-message-container.error {
            background-color: rgba(248, 215, 218, 0.9);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .login-message-container.success {
            background-color: rgba(212, 237, 218, 0.9);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .login-message-container.warning {
            background-color: rgba(255, 243, 205, 0.9);
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .login-message-container.info {
            background-color: rgba(209, 236, 241, 0.9);
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .login-message-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        .login-message-icon {
            margin-right: 0.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos para el spinner de carga */
        .login-spinner {
            display: none;
            text-align: center;
            margin-top: 1rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .login-spinner.active {
            display: block;
            opacity: 1;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3rem;
            border-top-color: #667eea;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Estilos para campos de formulario mejorados */
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
            transform: translateY(-1px);
            outline: none;
        }
        
        .form-control::placeholder {
            color: #a0aec0;
            font-family: 'Inter', sans-serif;
        }
        
        /* Estilos para el botón de login mejorado */
        .btn-primary {
           
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102,126,234,0.4);
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary i {
            margin-right: 8px;
        }
        
        /* Campo de contraseña modificado - toggle fuera del input */
        .password-container {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #6b7280;
            transition: color 0.3s ease;
            z-index: 10;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .password-input {
            padding-right: 48px;
        }
        
        /* Animación de entrada */
        .login-container {
            opacity: 0;
            transform: translateY(50px);
        }
        
        .login-container.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
  
    <!-- BEGIN: Content-->
    <div class="login-wrapper">
        <div class="login-container" id="loginContainer">
            <div class="logo-container">
                <img src="../../../app-assets/images/pages/logo_texto_grupo_solsumed.webp" alt="Logo Grupo solsumed" class="img-fluid">
            </div>
            
            <!-- Contenedor para mensajes -->
            <div id="login-message-container" class="login-message-container">
                <div class="login-message-title">
                    <span class="login-message-icon"></span>
                    <span class="login-message-title-text"></span>
                </div>
                <div class="login-message-text"></div>
            </div>
            
            <form class="auth-login-form" id="loginform" action="#" method="POST">
                <div class="mb-1">
                    <label class="form-label" for="login-email">Usuario</label>
                    <input class="form-control" id="login-email" type="text" name="login-email" placeholder="Usuario" aria-describedby="login-email" autofocus tabindex="1">
                </div>
                <div class="mb-1">
                    <label class="form-label" for="login-password">Contraseña</label>
                    <div class="password-container">
                        <input class="form-control password-input" id="login-password" type="password" name="login-password" placeholder="············" aria-describedby="login-password" tabindex="2">
                      
                    </div>
                </div>
                <button class="btn btn-primary w-100" tabindex="4" id="login-button">
                    <i data-feather='log-in'></i> &nbsp;&nbsp; <b>Ingresar</b>
                </button>
                
                <!-- Spinner de carga -->
                <div class="login-spinner" id="loginSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Verificando credenciales...</p>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- END Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="assets/js/page-auth-login.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
            
            // Animación de entrada suave
            setTimeout(() => {
                $('#loginContainer').addClass('visible');
            }, 100);
            
            // Toggle de contraseña fuera del input
            $('#passwordToggle').on('click', function() {
                const passwordInput = $('#login-password');
                const icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('eye').addClass('eye-off');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('eye-off').addClass('eye');
                }
                
                // Actualizar feather icons
                feather.replace();
            });
            
            // Prevenir que el teclado mueva los elementos en dispositivos móviles
            let visualViewport = window.visualViewport;
            if (visualViewport) {
                visualViewport.addEventListener('resize', function() {
                    window.scrollTo(0, 0);
                });
            }
            
            // Enfocar suavemente sin cambiar la posición de la página
            document.addEventListener('focus', function(e) {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
                    setTimeout(function() {
                        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            e.target.scrollIntoView({behavior: 'smooth', block: 'center'});
                        }
                    }, 300);
                }
            }, true);
        });
    </script>
</body>
</html>