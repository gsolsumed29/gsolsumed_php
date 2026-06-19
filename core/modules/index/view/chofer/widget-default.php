<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="JMobile - Sistema integral de confirmación de entrega de paquetes para optimizar la gestión logística de tu negocio.">
    <meta name="keywords" content="Confirmación de entrega Paquetes Logística Gestión de envíos">
    <meta name="author" content="Soluciones Jm">
    <title id="name2">Confirmación de Entrega - Grupo Solsumed, CA</title>
  
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logo_solo.png">
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
            background-image: url('../../../app-assets/images/pages/lobby_grupo_solsumed.webp');
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
        
        .delivery-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex: 1;
        }
        
        .delivery-container {
            width: 100%;
            max-width: 450px;
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
        
        .page-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2c2c2c;
            font-weight: 600;
        }
        
        .delivery-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .info-label {
            font-weight: 500;
            color: #5e5873;
        }
        
        .info-value {
            font-weight: 600;
            color: #2c2c2c;
        }
        
        /* Prevenir zoom en iOS al enfocar inputs */
        @media screen and (max-width: 768px) {
            input, select, textarea {
                font-size: 16px !important;
            }
            
            .delivery-wrapper {
                padding: 10px;
                align-items: center;
            }
            
            .delivery-container {
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
            .delivery-wrapper {
                height: auto;
                min-height: auto;
            }
        }
        
        /* Para dispositivos muy pequeños */
        @media (max-width: 360px) {
            .delivery-container {
                padding: 1.2rem;
            }
            
            .logo-container img {
                max-height: 100px;
            }
        }
        
        /* Para tablets en orientación vertical */
        @media (min-width: 769px) and (max-width: 1024px) and (orientation: portrait) {
            .delivery-container {
                max-width: 500px;
            }
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
  <?php 
        $loteID = isset($_GET['lot']) ? $_GET['lot'] : 'LOT-2023-0547';
  ?>
    <!-- BEGIN: Content-->
    <div class="delivery-wrapper">
        <div class="delivery-container">
            <div class="logo-container">
                <img src="../../../app-assets/images/pages/logo_texto_grupo_solsumed.webp" alt="Logo Grupo solsumed" class="img-fluid">
            </div>
            
            <h2 class="page-title">Confirmación de Entrega</h2>
            
            <div class="delivery-info">
                <div class="info-row">
                    <span class="info-label">Número de Lote:</span>
                    <span class="info-value" id="lote-number"><?php echo $loteID ?></span>
                    <input type="hidden" id="loteId" value="<?php echo $loteID ?>">
                </div>
                <div class="info-row">
                    <span class="info-label">Bultos:</span>
                    <span class="info-value" id="bulto-number"></span>
                </div>
                    <div class="info-row">
                    <span class="info-label">Código:</span>
                    <span class="info-value" id="co_cli"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cliente:</span>
                    <span class="info-value" id="cli_des"></span>
                </div>
                   <div class="info-row">
                    <span class="info-label">Facturas:</span>
                    <span class="info-value" id="facturas"></span>
                </div>
            </div>
            
            <form class="auth-delivery-form" id="deliveryform" action="#" method="POST">
                <div class="mb-1">
                    <label class="form-label" for="delivery-notes">Notas de Entrega (Opcional)</label>
                    <textarea class="form-control" id="delivery-notes" name="delivery-notes" rows="3" placeholder="Añadir notas sobre la entrega..." tabindex="1"></textarea>
                </div>
                
                <div class="mb-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirm-check" name="confirm-check" tabindex="2">
                        <label class="form-check-label" for="confirm-check">
                            Confirmo que he entregado el paquete en buen estado, sin daños ni faltantes.
                        </label>
                    </div>
                </div>
                
                <button class="btn btn-primary w-100" tabindex="3" id="confirm-button">
                    <i data-feather='check-circle'></i> &nbsp;&nbsp; <b>Confirmar Entrega</b>
                </button>
            </form>
        </div>
    </div>
    <!-- END: Content-->

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
    <script src="assets/js/page-auth-login.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- END: Page JS-->
    
    <script>
  $(document).ready(function() {
        // Inicializar feather icons
        if (typeof feather !== 'undefined') {
            feather.replace({
                width: 14,
                height: 14
            });
        }

        // Cargar datos de embarque al iniciar
        cargarDataEmbarque();
        
        // Prevenir que el teclado mueva los elementos en dispositivos móviles
        let visualViewport = window.visualViewport;
        if (visualViewport) {
            $(visualViewport).on('resize', function() {
                // Mantener el scroll en la posición actual
                $(window).scrollTop(0);
            });
        }
        
        // Enfocar suavemente sin cambiar la posición de la página
        $(document).on('focus', 'input, textarea, select', function(e) {
            // Verificar si es un dispositivo móvil
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                // Pequeño retraso para permitir que el teclado aparezca primero
                setTimeout(function() {
                    // Scroll suave al elemento
                    $(e.target)[0].scrollIntoView({behavior: 'smooth', block: 'center'});
                }, 300);
            }
        });
        
        // Función para confirmar la entrega
        $('#confirm-button').on('click', function(e) {
            e.preventDefault();
            
            // Verificar si el checkbox está marcado
            const confirmCheck = $('#confirm-check').is(':checked');
            
            if (!confirmCheck) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Confirmación requerida',
                    text: 'Por favor, marque la casilla para confirmar que ha  entregado el paquete en buen estado.',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#2c9aff'
                });
                return;
            }
            
            // Obtener datos del formulario
            const loteId = $('#loteId').val();
            const deliveryNotes = $('#delivery-notes').val();
            
            // Mostrar mensaje de carga
            Swal.fire({
                title: 'Procesando...',
                text: 'Registrando la confirmación de entrega',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar datos mediante AJAX
            $.ajax({
                type: "POST",
                url: 'admin/index.php?action=despacho&tipo=1&accion=1&datos=3&c=VehiculoData&a=1&t=jm_despacho_lotes',
                data: {
                    loteId: loteId,
                    notas: deliveryNotes,
                    confirmado: 1
                },
                dataType: 'json',
                success: function(response) {
                    // Ocultar mensaje de carga
                    Swal.close();
                    
                    if (response.success) {
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Entrega Confirmada!',
                            text: 'La entrega ha sido registrada exitosamente. Serás redirigido a la página principal.',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#2c9aff',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // --- INICIO DE LA MODIFICACIÓN ---
                                
                                // Redirigir al usuario a la página principal
                                window.location.href = 'https://gruposolsumed.com/';
                                
                                // --- FIN DE LA MODIFICACIÓN ---
                            }
                        });
                    } else {
                        // Mostrar mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al confirmar',
                            text: response.message || 'No se pudo procesar la confirmación. Intente nuevamente.',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#2c9aff'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Ocultar mensaje de carga
                    Swal.close();
                    
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor. Verifique su conexión e intente nuevamente.',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2c9aff'
                    });
                    
                    console.error("Error al confirmar entrega:", textStatus, errorThrown);
                }
            });
        });
    });

    function cargarDataEmbarque() { 
        if ($('#lote-number').length) {
            let loteId = $('#loteId').val();
            
            $.ajax({
                type: "GET",
                url: 'admin/index.php?action=empaquetado&tipo=1&accion=2&datos=6&c=VehiculoData&a=1&t=carga&filtro=' + loteId,
                dataType: 'json',
            }).done(function(response) {
                
                if (!response.success) {
                    
                    if (response.error_code === 'ALREADY_CONFIRMED') {
                        
                        // --- INICIO DE LOS CAMBIOS PARA OCULTAR LA PÁGINA ---
                        
                        // 1. Añadimos la clase al body para ocultar todo el contenido
                        $('body').addClass('hide-content');
                        
                        // 2. Mostramos la alerta que ahora será lo único visible
                        Swal.fire({
                            icon: 'info',
                            title: 'Lote ya confirmado',
                            html: 'Este lote de paquetes ya ha sido entregado.<br>Será redirigido a la página principal.',
                            confirmButtonText: 'Ir al Inicio',
                            confirmButtonColor: '#2c9aff',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            backdrop: `rgba(0, 0, 0, 1)`, // Fondo negro sólido
                            showCloseButton: false
                        }).then((result) => {
                            // 3. (Opcional pero recomendado) Quitamos la clase antes de redirigir
                            $('body').removeClass('hide-content');
                            
                            if (result.isConfirmed) {
                                // Redirige al usuario
                                window.location.href = 'https://gruposolsumed.com/';
                            }
                        });
                        // --- FIN DE LOS CAMBIOS ---

                    } else {
                        // Manejo de otros errores (ej: "no encontrado")
                        console.log(response.message);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sin Datos',
                            text: response.message,
                        });
                        // Limpiamos los campos visuales
                        $('#bulto-number').text('No encontrado');
                        $('#co_cli').text('No encontrado');
                        $('#facturas').text('No encontrado');
                        $('#cli_des').text('No encontrado');
                    }
                    return; 
                }

                // Resto de tu lógica para cuando la carga es exitosa...
                let embarques = response.data;

                if (embarques && embarques.length > 0) {
                    let totalBultos = 0;
                    let cli_des = '';
                    let facturas = '';
                    let co_cli = null;
                    let fechaEntrega = null;

                    $.each(embarques, function(index, embarque) {
                        totalBultos += parseInt(embarque.numero_paquete) || 0;
                        if (!co_cli) co_cli = embarque.co_cli;
                        if (!fechaEntrega) fechaEntrega = embarque.fecha_entrega;
                        if (!facturas) facturas = embarque.facturas;
                        if (!cli_des) cli_des = embarque.cli_des;
                    });

                    function formatearFecha(fechaString) {
                        if (!fechaString) return 'N/A';
                        const partes = fechaString.split('-');
                        return `${partes[2]}/${partes[1]}/${partes[0]}`;
                    }

                    $('#bulto-number').text(totalBultos);
                    $('#co_cli').text(co_cli);
                    $('#facturas').text(facturas);
                    $('#cli_des').text(cli_des);

                } else {
                    console.log("La respuesta fue exitosa pero no contiene datos.");
                    $('#bulto-number').text('Sin datos');
                    $('#co_cli').text('Sin datos');
                    $('#facturas').text('Sin datos');
                    $('#cli_des').text('Sin datos');
                }
                
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error al cargar los datos de embarques:", textStatus, errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Carga',
                    text: 'No se pudieron cargar los datos de los embarques. Por favor, intente de nuevo.',
                });
            });
        }
    }
    </script>
</body>
<!-- END: Body-->
</html>
