<?php
// Ruta: /var/www/html/admin/core/modules/index/action/sms/action-default.php

header('Content-Type: application/json');

// 1. Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

// 2. Credenciales de la API (Mover a un archivo de configuración seguro en producción)
 $api_user = "administracion@gruposolsumed.com"; // Tu usuario real
 $api_pass = "Sol@Oci369*";                 // Tu clave real

// 3. Recibir y limpiar datos del Frontend
 $input_telefonos = isset($_POST['telefonos']) ? $_POST['telefonos'] : '';
 $input_texto     = isset($_POST['texto']) ? $_POST['texto'] : '';

if (empty($input_telefonos) || empty($input_texto)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Teléfonos y texto son obligatorios']);
    exit;
}

// 4. Validación de Caracteres Prohibidos (Según el manual)
// Prohibidos: ' ¡ ¿ \ º | { } [ ] ` ^ Ü € ? $ # á é í ó ú ñ
// Usamos una expresión regular para detectarlos o eliminarlos.
// Por seguridad, los eliminaremos o reemplazaremos para evitar errores de la API.
 $patron_prohibidos = '/[\'¡¿\\º|{}\[\]`^Ü€?$#áéíóúñ]/i';
 $texto_limpio = preg_replace($patron_prohibidos, '', $input_texto); // Elimina prohibidos

// 5. Procesar lista de teléfonos
// Convertimos la entrada en un array, limpiamos espacios y vacíos
 $lista_telefonos = array_filter(array_map('trim', explode(';', $input_telefonos)));

// 6. Dividir en bloques de 50 (Recomendación de la API)
 $bloques_telefonos = array_chunk($lista_telefonos, 50);

 $resultados_finales = [];
 $total_enviados = 0;
 $errores = [];

foreach ($bloques_telefonos as $bloque) {
    // Unir teléfonos del bloque con punto y coma
    $telefonos_string = implode(';', $bloque);

    // 7. Construir parámetros (Usamos http_build_query para manejar caracteres especiales)
    $params = [
        'usuario'   => $api_user,
        'clave'     => $api_pass,
        'telefonos' => $telefonos_string,
        'texto'     => $texto_limpio,
        'api'       => 'json' // IMPORTANTE: Pedir respuesta en JSON
    ];
    
    $queryString = http_build_query($params);

    // 8. Configurar cURL (Usando HTTPS como recomiendan)
    $url = "https://sistema.massivamovil.com/webservices/SendSms";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Descomentar las siguientes líneas si el servidor tiene problemas con certificados SSL (no recomendado en producción, mejor arreglar el cacert.pem)
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $errores[] = 'Error cURL: ' . curl_error($ch);
    } else {
        $json_resp = json_decode($response, true);
        
        // Si status > 0, es la cantidad de mensajes enviados exitosamente en este bloque
        if (isset($json_resp['status']) && $json_resp['status'] > 0) {
            $total_enviados += (int)$json_resp['status'];
        } else {
            // Guardar el mensaje de error específico de la API
            $errorMsg = isset($json_resp['mensaje']) ? $json_resp['mensaje'] : 'Error desconocido';
            $errores[] = "Bloque con error: " . $errorMsg;
        }
    }
    curl_close($ch);
}

// 9. Preparar respuesta para el Frontend
if (count($errores) > 0 && $total_enviados === 0) {
    echo json_encode([
        'status' => 'error', 
        'mensaje' => implode(', ', $errores),
        'detalles' => 'Hubo errores en el envío.'
    ]);
} elseif ($total_enviados > 0) {
    echo json_encode([
        'status' => 'success',
        'mensaje' => "Se procesaron $total_enviados mensajes exitosamente.",
        'alertas' => $errores // Muestra si algunos bloques fallaron pero otros no
    ]);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo procesar la solicitud.']);
}