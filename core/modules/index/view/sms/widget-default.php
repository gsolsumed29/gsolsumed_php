<!doctype html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Envío de SMS Masivo | Grupo Solsumed, CA</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="../core/assets/images/favicon.ico">
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="../core/assets/css/core/libs.min.css">
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="../core/assets/css/hope-ui.min.css?v=4.0.0">
    <!-- Custom Css -->
    <link rel="stylesheet" href="../core/assets/css/custom.min.css?v=4.0.0">
    
    <style>
        /* Estilos para textareas */
        .form-control {
            resize: vertical;
        }
        
        /* Contador de caracteres */
        .char-counter {
            font-size: 0.8rem;
            text-align: right;
            color: #6c757d;
            transition: color 0.3s;
        }
        .char-counter.danger {
            color: #dc3545;
            font-weight: bold;
        }

        /* Mensaje de ayuda para caracteres prohibidos */
        .prohibited-warning {
            display: none;
            font-size: 0.75rem;
            color: #dc3545;
            margin-top: 0.25rem;
        }
        .prohibited-warning.show {
            display: block;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* Spinner del botón */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }
    </style>
  </head>
  <body class="sidebar-mini sidebar-default">

    <div class="wrapper">
        <section class="login-content" style="background-color: #f8f9fa;"> <!-- Fondo suave -->
            <div class="row m-0 justify-content-center align-items-center vh-100">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            
                            <!-- Logo y Título -->
                            <div class="text-center mb-4">
                                <img src="../../../app-assets/images/pages/logo_texto_grupo_solsumed.webp" alt="Logo" class="img-fluid mb-3" style="max-width: 250px;">
                                <h2 class="h4 text-dark">Envío de SMS Masivo</h2>
                                <p class="text-muted small">Complete los campos para enviar mensajes a múltiples destinatarios.</p>
                            </div>

                            <!-- Formulario SMS -->
                            <form id="sms-form" novalidate>
                                
                                <!-- Campo Teléfonos -->
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">Destinatarios</label>
                                    <textarea class="form-control" id="telefonos" name="telefonos" rows="3" placeholder="Ej: 584141234567; 584241234567" required></textarea>
                                    <small class="text-muted d-block mt-1">Separados por punto y coma (;). Ejemplo: 58414...;58412...</small>
                                </div>

                                <!-- Campo Mensaje -->
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">Mensaje</label>
                                    <textarea class="form-control" id="texto" name="texto" rows="3" placeholder="Escriba su mensaje aquí..." maxlength="160" required></textarea>
                                    
                                    <!-- Indicadores -->
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <div id="prohibited-warning" class="prohibited-warning">
                                            ⚠️ Caracter no permitido eliminado
                                        </div>
                                        <div id="charCounter" class="char-counter">
                                            0 / 160
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-warning py-2 px-3 mt-2 small">
                                        <strong>Nota:</strong> No se permiten: tildes (á,é...), ñ, ni símbolos como: ' ¡ ¿ \ º | { } [ ] ` ^ € $ #
                                    </div>
                                </div>

                                <!-- Botón de Envío -->
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg" id="btn-enviar">
                                        <span class="btn-text">Enviar Mensajes</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                    
                    <!-- Footer de la tarjeta -->
                    <div class="text-center mt-3">
                        <a href="./" class="text-muted small">← Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            
            // --- Configuración de Caracteres Prohibidos (Regex) ---
            // Basado en la documentación: ' ¡ ¿ \ º | { } [ ] ` ^ Ü € ? $ # á é í ó ú ñ
            // Añadimos las vocales mayúsculas acentuadas por seguridad
            const regexProhibidos = /['¡¿\\º|{}\[\]`^Ü€?$#áéíóúüÁÉÍÓÚÜñÑ]/g;

            // --- Función para limpiar texto ---
            function limpiarTexto(texto) {
                return texto.replace(regexProhibidos, '');
            }

            // --- Evento: Escribir Mensaje (Validación y Limpieza) ---
            $('#texto').on('input', function() {
                let valor = $(this).val();
                let limpio = limpiarTexto(valor);
                let longitud = limpio.length;

                // Si hubo cambio (se eliminó un carácter prohibido)
                if (valor !== limpio) {
                    $(this).val(limpio);
                    // Mostrar advertencia visual
                    $('#prohibited-warning').addClass('show');
                    setTimeout(() => { $('#prohibited-warning').removeClass('show'); }, 2000);
                }

                // Actualizar contador
                $('#charCounter').text(longitud + ' / 160');
                
                // Cambiar color si pasa el límite (visual feedback, aunque maxlength lo limita)
                if (longitud >= 150) {
                    $('#charCounter').addClass('danger');
                } else {
                    $('#charCounter').removeClass('danger');
                }
            });

            // --- Envío del Formulario ---
            $('#sms-form').on('submit', function(e) {
                e.preventDefault();

                // Obtener valores
                const telefonos = $('#telefonos').val().trim();
                const texto = $('#texto').val().trim();
                const $btn = $('#btn-enviar');

                // Validación simple
                if (!telefonos || !texto) {
                    Swal.fire('Error', 'Por favor complete todos los campos.', 'error');
                    return;
                }

                // Estado de carga del botón
                $btn.prop('disabled', true);
                $btn.find('.btn-text').text('Enviando...');
                $btn.find('.spinner-border').removeClass('d-none');

                // --- PETICIÓN AJAX AL BACKEND ---
                // Asegúrate que la URL apunte a tu archivo PHP (action-default.php)
                $.ajax({
                  url: 'admin/index.php?action=sms',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        telefonos: telefonos,
                        texto: texto
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                html: `<strong>${response.mensaje}</strong><br><small>Los mensajes están siendo procesados.</small>`,
                            });
                            // Limpiar formulario si fue exitoso
                            $('#sms-form')[0].reset();
                            $('#charCounter').text('0 / 160');
                        } else {
                            // Mostrar errores devueltos por el backend
                            let errorMsg = response.mensaje || 'Ocurrió un error desconocido.';
                            if (response.alertas) {
                                errorMsg += `<br><small>${response.alertas.join('<br>')}</small>`;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en el Envío',
                                html: errorMsg
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire('Error Crítico', 'No se pudo conectar con el servidor. Revise la consola para más detalles.', 'error');
                    },
                    complete: function() {
                        // Restaurar botón
                        $btn.prop('disabled', false);
                        $btn.find('.btn-text').text('Enviar Mensajes');
                        $btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });

        });
    </script>
  </body>
</html>