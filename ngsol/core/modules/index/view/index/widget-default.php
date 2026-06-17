<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Aurora descripción">
    <meta name="keywords" content="admin, dashboard , responsive, web app">
    <meta name="author" content="Soluciones Jm">
    <title id="name2">Grupo solsumed, CA</title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/logo.png">
   <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logo.png">
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
        }
        
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('../../../app-assets/images/pages/lobby.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
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
            transform: translateZ(0); /* Aceleración por hardware */
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            max-height: 120px;
            width: auto;
            max-width: 100%;
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
                /* Flexbox centrado que se mantiene incluso con teclado visible */
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                height: auto;
            }
            
            /* Asegurar que el contenedor permanezca centrado */
            .login-wrapper {
                height: auto;
                min-height: auto;
            }
        }
        
        /* Para dispositivos muy pequeños */
        @media (max-width: 360px) {
            .login-container {
                padding: 1.2rem;
            }
            
            .logo-container img {
                max-height: 100px;
            }
        }
        
        /* Para tablets en orientación vertical */
        @media (min-width: 769px) and (max-width: 1024px) and (orientation: portrait) {
            .login-container {
                max-width: 450px;
            }
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
  
       <!-- BEGIN: Content-->
       <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <!-- Login v1 -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./" class="brand-logo ">
                                    <img src="app-assets/images/ico/logo.png" class="mx-auto d-block logo_aurora" alt="">
                                   
                                </a>
                                <h2 class="brand-text text-primary ms-1 name text-center d-none" id="name"></h2>
                                <br>     <br>
                                <p class="card-text mb-2">Por favor ingrese su usuario y contraseña para iniciar</p>
                               
                                <form class="auth-login-form mt-2"  id ="loginform" action="#" method="POST">
                                    <div class="mb-1">
                                        <label class="form-label" for="login-email"> <h4>Usuario</h4> </label>
                                        <input class="form-control" id="login-email" type="text" name="login-email" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password"> <h4>Password</h4> </label>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                                <small>Olvidé la contraseña?</small>
                                            </a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="login-password" type="password" name="login-password" placeholder="············" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer" aria-label="Mostrar/Ocultar Contraseña"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                       
                                    </div>
                                    <button class="btn btn-primary w-100" tabindex="4"> <b>Ingresar</b> </button>
                                </form>            
                               
                             
                               
                            </div>
                        </div>
                     
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
 <!-- Modal de Recuperación de Contraseña -->
 <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Por favor, introduce tu usaurio, para restablecer tu contraseña.</p>
                    <form id="forgotPasswordForm" novalidate>
                        <div class="mb-1">
                            <label class="form-label" for="forgot-email">Usuario/Cedula</label>
                            <input type="text" class="form-control" id="forgot-email" name="forgot-email" placeholder="123456789" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="sendRecoveryLink">Restablecer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN Modal de Recuperación de Contraseña -->

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

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

   <!-- <script src="assets/js/page-auth-login.js"></script>-->
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
        })
    </script>

   


</body>
<!-- END: Body-->


</html>