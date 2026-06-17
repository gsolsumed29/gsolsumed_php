<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción - Ayúdanos a conocerte mejor</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* --- Estilos Generales --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* --- Contenedor Principal (Tarjeta) --- */
        .survey-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            box-sizing: border-box; /* Importante para padding */
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        p.description {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        /* --- Estilos de Formulario --- */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #444;
            margin-bottom: 10px;
            font-size: 15px;
        }

        /* Campos de texto y select */
        input[type="text"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box; /* Asegura que padding no sume al ancho */
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #4c5bb7; /* Color de foco */
            box-shadow: 0 0 5px rgba(76, 91, 183, 0.2);
        }

        /* Estilos específicos para el Select */
        select {
            appearance: none; /* Quitar estilo por defecto del navegador */
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.3c0%204.9%201.8%209.2%205.4%2012.8l128.1%20128.1c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 15px top 50%;
            background-size: 12px auto;
            padding-right: 40px; /* Espacio para la flecha */
        }

        /* Botón de Enviar */
        .btn-enviar {
            background-color: #4c5bb7; /* Color exacto del botón en la imagen */
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
        }

        .btn-enviar:hover {
            background-color: #3f4a9b;
        }

        .btn-enviar:active {
            transform: translateY(1px);
        }

        /* --- Mensajes de Feedback --- */
        #status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
            display: none; /* Oculto por defecto */
            font-weight: 500;
        }

        #status-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        #status-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* --- Media Queries para Responsiveness --- */
        /* Para dispositivos móviles pequeños (hasta 480px) */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            .survey-container {
                padding: 25px 20px;
            }
            h1 {
                font-size: 24px;
            }
            p.description {
                font-size: 14px;
            }
            label {
                font-size: 14px;
                margin-bottom: 8px;
            }
            input[type="text"],
            select {
                padding: 10px;
                font-size: 15px;
            }
            .btn-enviar {
                width: 100%; /* Botón de ancho completo en móvil */
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="survey-container">
        <h1>Ayúdanos a conocerte mejor</h1>
        <p class="description">Tu opinión es fundamental para nosotros. Por favor, tómate unos minutos para responder a estas breves preguntas y ayudarnos a mejorar nuestros servicios.</p>
        
        <form id="encuestaForm">
            <div class="form-group">
                <label for="nombre_completo">Nombre y apellido *</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required placeholder="Ej: Juan Pérez">
            </div>

            <div class="form-group">
                <label for="numero_contacto">Número de contacto *</label>
                <input type="text" id="numero_contacto" name="numero_contacto" required placeholder="Ej: +58 412 123 45 67">
            </div>

            <div class="form-group">
                <label for="especialidad">Especialidad</label>
                <input type="text" id="especialidad" name="especialidad" placeholder="Ej: Cardiología">
            </div>

            <div class="form-group">
                <label for="conoce_bialy">¿Conoce la marca BIALY? *</label>
                <select id="conoce_bialy" name="conoce_bialy" required>
                    <option value="" disabled selected hidden>Selecciona una opción</option>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                </select>
            </div>

            <button type="submit" class="btn-enviar">Enviar</button>
        </form>

        <div id="status-message"></div>
    </div>

    <script>
        $(document).ready(function() {
            // Manejar el envío del formulario
            $('#encuestaForm').on('submit', function(event) {
                // Prevenir el envío por defecto (que recargaría la página)
                event.preventDefault();

                // Ocultar mensajes anteriores
                $('#status-message').hide().removeClass('success error').text('');

                // Obtener los datos del formulario de manera estructurada
                var formData = $(this).serialize();

                // Enviar datos mediante AJAX
          


              $.ajax({
                  type: 'POST',
                  url: 'admin/encuestas.php?action=encuestas_eventos&accion=create', // URL con la acción
                  data: formData,
                  dataType: 'json',
                  success: function(response) {
                      // Si el PHP llega hasta el final, success será true
                      if (response.success) {
                          // Aquí mostramos el mensaje que necesitas
                          $('#status-message')
                              .removeClass('error')
                              .addClass('success')
                              .text('¡Su respuesta fue guardada exitosamente!') 
                              .fadeIn();
                          
                          // Limpiamos el formulario
                          $('#encuestaForm')[0].reset();
                      }
                  },
                  error: function() {
                      $('#status-message')
                          .addClass('error')
                          .text('Error al procesar la solicitud.')
                          .fadeIn();
                  }
              });
            });
        });
    </script>

</body>
</html>