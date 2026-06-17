<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queremos conocerte | BIALY</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bialy-cyan: #00bfbf; 
            --bialy-magenta: #e3006a;
            --bialy-dark: #1a1a1a;
            --bg-gradient: linear-gradient(135deg, #f8f9fc 0%, #e0f7f7 100%);
            --border-color: #dfe6e9;
        }

        /* Reset para asegurar que todos los navegadores midan igual los inputs */
        * { box-sizing: border-box; }

        body {
            background: var(--bg-gradient);
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .survey-card {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 191, 191, 0.1);
            border-top: 6px solid var(--bialy-cyan);
        }

        .header { text-align: center; margin-bottom: 25px; }
        
        .logo-container {
            margin-bottom: 15px;
            text-align: center;
        }

        .logo-container img {
            max-width: 160px;
            height: auto;
        }

        .header h1 {
            font-size: 24px;
            margin: 10px 0 8px 0;
            color: var(--bialy-dark);
            font-weight: 700;
        }
        .header h1 span { color: var(--bialy-magenta); }
        .header p { color: #636e72; font-size: 14px; margin: 0; line-height: 1.4; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: var(--bialy-dark); }

        /* UNIFICACIÓN DE TAMAÑOS: Altura fija y padding idéntico */
        input, select {
            width: 100%;
            height: 50px; /* Altura estricta para todos */
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 15px;
            padding: 0 16px;
            outline: none;
            transition: all 0.3s ease;
            color: var(--bialy-dark);
            background-color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        input:focus, select:focus { 
            border-color: var(--bialy-cyan); 
            box-shadow: 0 0 0 4px rgba(0, 191, 191, 0.1);
        }

        .phone-container {
            display: flex;
            gap: 10px;
        }

        .phone-container select {
            width: 110px;
            flex-shrink: 0;
        }

        .btn-submit {
            width: 100%;
            height: 55px;
            background: var(--bialy-cyan);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover { 
            background: #00a8a8; 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 191, 191, 0.3);
        }

        /* Estilo para los selects (flecha personalizada) */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2300bfbf' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 14px;
        }

        #status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 12px;
            display: none;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .msg-success { background: #e3fcef; color: #006644; border: 1px solid #abf5d1; }
        .msg-error { background: #ffebe8; color: #bf2600; border: 1px solid #ffbdad; }
    </style>
</head>
<body>

<div class="survey-card">
    <div class="header">
        <div class="logo-container">
            <img src="../app-assets/images/pages/logo_bialy.png" alt="Bialy Logo">
        </div>
        <h1>Queremos <span>conocerte</span></h1>
        <p>Valoramos la labor de los especialistas de la salud que nos acompañan.</p>
    </div>

    <form id="encuestaForm">
        <div class="form-group">
            <label>Nombre y apellido</label>
            <input type="text" name="nombre_completo" required placeholder="Ej. Juan Pérez">
        </div>


        <div class="form-group">
            <label>Número de contacto</label>
            <div class="phone-container">
                <select id="codigo_area" required>
                    <option value="412">0412</option>
                    <option value="422">0422</option>
                    <option value="424">0424</option>
                    <option value="414">0414</option>
                    <option value="416">0416</option>
                    <option value="426">0426</option>
                </select>
                <input type="text" id="telefono_num" required placeholder="7654321" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <input type="hidden" name="numero_contacto" id="numero_completo">
        </div>
        <div class="form-group" style="display:none; ">
            <label>Correo electrónico</label>
            <input type="email" name="email" required value ="bialy@gruposolsumed.com" placeholder="ejemplo@correo.com">
        </div>

        <div class="row" style="display:none ; ">
            <div class="form-group">
                <label>Estado</label>
                <select name="estado" id="estado" required>
                    <option value="" disabled selected>Seleccione</option>
                    <option value="Amazonas">Amazonas</option>
                    <option value="Anzoátegui">Anzoátegui</option>
                    <option value="Apure">Apure</option>
                    <option value="Aragua">Aragua</option>
                    <option value="Barinas">Barinas</option>
                    <option value="Bolívar">Bolívar</option>
                    <option value="Carabobo">Carabobo</option>
                    <option value="Cojedes">Cojedes</option>
                    <option value="Delta Amacuro">Delta Amacuro</option>
                    <option value="Distrito Capital" selected>Distrito Capital</option>
                    <option value="Falcón">Falcón</option>
                    <option value="Guárico">Guárico</option>
                    <option value="Lara">Lara</option>
                    <option value="Mérida">Mérida</option>
                    <option value="Miranda">Miranda</option>
                    <option value="Monagas">Monagas</option>
                    <option value="Nueva Esparta">Nueva Esparta</option>
                    <option value="Portuguesa">Portuguesa</option>
                    <option value="Sucre">Sucre</option>
                    <option value="Táchira">Táchira</option>
                    <option value="Trujillo">Trujillo</option>
                    <option value="La guarira">La guarira</option>
                    <option value="Yaracuy">Yaracuy</option>
                    <option value="Zulia">Zulia</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ciudad</label>
                <select name="ciudad" id="ciudad" required disabled>
                    <option value="Seleccione" disabled selected>Seleccione...</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Grupo | Casa | Hospital </label>
            <select name="especialidad" id="especialidad">
                <option value="" disabled selected>Seleccione....</option>
                <option value="CASA MEDICA">CASA MEDICA</option>
                <option value="DISTRIBUIDOR">DISTRIBUIDOR</option>
                <option value="FARMACIA">FARMACIA</option>
                <option value="LABORATORIO CLINICO">LABORATORIO CLINICO</option>
                <option value="GOBIERNO Y ENTIDAD DE SALUD PUBLICA">GOBIERNO Y ENTIDAD DE SALUD PUBLICA</option>
                <option value="HOSPITAL Y CLINICA">HOSPITAL Y CLINICA</option>
                <option value="CENTRO DE SALUD Y AMBULATORIO">CENTRO DE SALUD Y AMBULATORIO</option>
                <option value="PROFESIONAL SALUD INDEPENDIENTE">PROFESIONAL SALUD INDEPENDIENTE</option>
                <option value="DROGUERIA">DROGUERIA</option>            

            </select>
        </div>

        <div class="form-group">
            <label>¿Conoce la marca BIALY?</label>
            <select name="conoce_bialy" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="Sí">Sí, la conozco</option>
                <option value="No">No, aún no</option>
            </select>
        </div>

        <button type="submit" class="btn-submit" id="btnEnviar">Enviar respuestas</button>
    </form>

    <div id="status-message"></div>
</div>

<script>
const ciudadesPorEstado = {
    "Amazonas": ["Puerto Ayacucho", "San Fernando de Atabapo"],
    "Anzoátegui": ["Barcelona", "Puerto La Cruz", "Lechería", "El Tigre", "Anaco"],
    "Apure": ["San Fernando de Apure", "Guasdualito", "Elorza"],
    "Aragua": ["Maracay", "Turmero", "La Victoria", "Cagua", "El Limón"],
    "Barinas": ["Barinas", "Socopó", "Barinitas"],
    "Bolívar": ["Ciudad Guayana", "Ciudad Bolívar", "Upata", "Caicara del Orinoco"],
    "Carabobo": ["Valencia", "Puerto Cabello", "Guacara", "San Diego", "Naguanagua"],
    "Cojedes": ["San Carlos", "Tinaquillo"],
    "Delta Amacuro": ["Tucupita"],
    "Distrito Capital": ["Caracas"],
    "Falcón": ["Coro", "Punto Fijo", "Chichiriviche", "Dabajuro"],
    "Guárico": ["San Juan de los Morros", "Calabozo", "Valle de la Pascua"],
    "Lara": ["Barquisimeto", "Cabudare", "Carora", "El Tocuyo", "Quíbor"],
    "Mérida": ["Mérida", "El Vigía", "Ejido", "Tovar"],
    "Miranda": ["Los Teques", "Guarenas", "Guatire", "Charallave", "Santa Teresa del Tuy"],
    "Monagas": ["Maturín", "Punta de Mata", "Caripe"],
    "Nueva Esparta": ["La Asunción", "Porlamar", "Pampatar", "Juan Griego"],
    "Portuguesa": ["Guanare", "Acarigua", "Araure", "Turén"],
    "Sucre": ["Cumaná", "Carúpano", "Güiria"],
    "Táchira": ["San Cristóbal", "Táriba", "Rubio", "San Antonio del Táchira"],
    "Trujillo": ["Trujillo", "Valera", "Boconó"],
    "Vargas": ["La Guaira", "Catia La Mar", "Maiquetía"],
    "Yaracuy": ["San Felipe", "Yaritagua", "Nirgua"],
    "Zulia": ["Maracaibo", "Cabimas", "Ciudad Ojeda", "Machiques", "La Concepción"]
};
$(document).ready(function() {
    // Lógica de ciudades dependientes
  $('#estado').on('change', function() {
    const estado = $(this).val();
    const $ciudad = $('#ciudad');
    
    // Limpiar y habilitar
    $ciudad.empty().append('<option value="" disabled selected>Seleccione Ciudad</option>');
    
    if (ciudadesPorEstado[estado]) {
        ciudadesPorEstado[estado].forEach(c => {
            $ciudad.append(`<option value="${c}">${c}</option>`);
        });
        // Añadir opción general al final
        $ciudad.append('<option value="Otra">Otra ciudad...</option>');
        $ciudad.prop('disabled', false);
    }
});

    $('#encuestaForm').on('submit', function(e) {
        e.preventDefault();
        
        // Concatenar teléfono
        const codigo = $('#codigo_area').val();
        const num = $('#telefono_num').val();
        $('#numero_completo').val('+58' + codigo + num);

        const $btn = $('#btnEnviar');
        const $msg = $('#status-message');
        
        $btn.prop('disabled', true).text('Guardando...');

        $.ajax({
        type: 'POST',
        url: 'admin/encuestas.php?action=encuestas_eventos&accion=create',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                $msg.removeClass('msg-error').addClass('msg-success')
                    .html('¡Registro exitoso!<br>.').fadeIn();
                $('#encuestaForm')[0].reset();
                $('#ciudad').prop('disabled', true);
                
                // El mensaje se desvanece después de 3 segundos (3000 ms)
                $msg.delay(3000).fadeOut(500);
                
                // Si quieres redirigir después de que se desvanezca:
                setTimeout(function() {
                    // window.location.href = 'alguna-pagina.php';
                    // O recargar la página:
                    // location.reload();
                }, 3500); // 3000ms delay + 500ms fadeOut
                
            } else {
                $msg.removeClass('msg-success').addClass('msg-error')
                    .text('Error: ' + response.message).fadeIn();
                $btn.prop('disabled', false).text('Enviar respuestas');
                
                // El mensaje de error también se desvanece después de 5 segundos
                $msg.delay(5000).fadeOut(500);
            }
        },
        error: function() {
            $msg.removeClass('msg-success').addClass('msg-error')
                .text('Error de conexión.').fadeIn();
            $btn.prop('disabled', false).text('Enviar respuestas');
            
            // El mensaje de error se desvanece después de 5 segundos
            $msg.delay(5000).fadeOut(500);
        }
    });
});
});
</script>

</body>
</html>