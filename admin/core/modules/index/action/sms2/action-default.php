<?php
// Ruta: /var/www/html/admin/core/modules/index/action/sms/action-default.php

header('Content-Type: application/json');

// 1. Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

// 2. Credenciales de la API
$api_user = "administracion@gruposolsumed.com";
$api_pass = "Sol@Oci369*";

// 3. Obtener datos de clientes
$objeto_clientes = new FacturaData();
$data = $objeto_clientes->getAllCuentasPorCobrarDetallesGerente('NO', 'NO', 2);
$input_json = json_encode($data);
//GRUPO SOLSUMED OCCIDENTE: No pierda su DESCUENTO. Posee un saldo por vencer de $978,22. Pague hoy y disfrute su beneficio de pronto pago. Ahorre y evite recargos.
$input_texto = 'GRUPO SOLSUMED OCCIDENTE INFORMA: No pierda su DESCUENTO. Posee un saldo por vencer de {saldo} USD Pague hoy y disfrute su beneficio de pronto pago. Ahorre y evite recargos.';

// 4. Decodificar el JSON
$clientes = json_decode($input_json);

if ($clientes === null) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al decodificar JSON de clientes']);
    exit;
}

// 5. Extraer teléfonos y preparar mensajes personalizados
$mensajes_para_enviar = [];
$clientes_sin_telefono = [];
$total_saldo_general = 0;

foreach ($clientes as $cliente) {
    // Verificar que tenga teléfono
    if (empty($cliente->telefonos)) {
        $clientes_sin_telefono[] = $cliente->cli_des;
        continue;
    }
    
    // Limpiar el teléfono (eliminar espacios y caracteres no numéricos)
    $telefono = preg_replace('/[^0-9]/', '', $cliente->telefonos);
    
    // Normalizar al formato internacional 58
    if (substr($telefono, 0, 1) == '0') {
        // Si empieza con 0, reemplazar el 0 por 58
        $telefono = '58' . substr($telefono, 1);
    } else {
        // Si no empieza con 0, solo agregar 58 al inicio
        $telefono = '58' . $telefono;
    }
    
    // Validar que el teléfono tenga la longitud correcta
    if (strlen($telefono) != 12) {
        error_log("Teléfono con formato inusual: " . $cliente->telefonos . " -> " . $telefono);
    }
    
    // Calcular saldo numérico para estadísticas
    $saldo_numerico = floatval(str_replace(['.', ','], ['', '.'], $cliente->saldo));
    $total_saldo_general += $saldo_numerico;
    
    // Personalizar el mensaje (reemplazar variables)
    $texto_personalizado = $input_texto;
    $texto_personalizado = str_replace('{cliente}', $cliente->cli_des, $texto_personalizado);
    $texto_personalizado = str_replace('{saldo}', $cliente->saldo, $texto_personalizado);
    
    // Validación de Caracteres Prohibidos
    $patron_prohibidos = '/[\'¡¿\\º|{}\[\]`^Ü€?$#áéíóúñ]/i';
    $texto_personalizado = preg_replace($patron_prohibidos, '', $texto_personalizado);
    
    // Limitar longitud del SMS (160 caracteres)
    if (strlen($texto_personalizado) > 160) {
        $texto_personalizado = substr($texto_personalizado, 0, 157) . '...';
    }
    
   // $telefono = '584121693382';
    
    // Agregar a la lista para enviar
    $mensajes_para_enviar[] = [
        'telefono' => $telefono,
        'texto' => $texto_personalizado,
        'cliente' => $cliente->cli_des,
        'saldo' => $cliente->saldo,
        'telefono_original' => $cliente->telefonos
    ];
}

// Estadísticas
$stats = [
    'total_clientes' => count($clientes),
    'con_telefono' => count($mensajes_para_enviar),
    'sin_telefono' => count($clientes_sin_telefono),
    'saldo_total_general' => number_format($total_saldo_general, 2, ',', '.') . ' USD'
];

if (empty($mensajes_para_enviar)) {
    echo json_encode([
        'status' => 'error', 
        'mensaje' => 'No hay clientes con teléfonos válidos',
        'estadisticas' => $stats,
        'clientes_sin_telefono' => $clientes_sin_telefono
    ]);
    exit;
}

// 6. Agrupar por mensaje (para optimizar envíos)
$mensajes_agrupados = [];
foreach ($mensajes_para_enviar as $item) {
    $clave = md5($item['texto']);
    if (!isset($mensajes_agrupados[$clave])) {
        $mensajes_agrupados[$clave] = [
            'texto' => $item['texto'],
            'telefonos' => [],
            'clientes' => []
        ];
    }
    $mensajes_agrupados[$clave]['telefonos'][] = $item['telefono'];
    $mensajes_agrupados[$clave]['clientes'][] = $item['cliente'];
}

// 7. Enviar SMS por grupos
$total_enviados = 0;
$errores = [];
$detalle_envios = [];
$tiempo_inicio = microtime(true);

foreach ($mensajes_agrupados as $indice_grupo => $grupo) {
    $telefonos_grupo = $grupo['telefonos'];
    $texto_grupo = $grupo['texto'];
    
    // Dividir en bloques de 50 (límite de la API)
    $bloques_telefonos = array_chunk($telefonos_grupo, 50);
    
    foreach ($bloques_telefonos as $indice_bloque => $bloque) {
        $telefonos_string = implode(';', $bloque);
        
        // Construir parámetros
        $params = [
            'usuario'   => $api_user,
            'clave'     => $api_pass,
            'telefonos' => $telefonos_string,
            'texto'     => $texto_grupo,
            'api'       => 'json'
        ];
        
        $queryString = http_build_query($params);
        $url = "https://sistema.massivamovil.com/webservices/SendSms";
        
        // Configurar cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Solo si hay problemas con SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Solo si hay problemas con SSL
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $errores[] = 'Error cURL: ' . curl_error($ch) . ' (HTTP: ' . $http_code . ')';
        } else {
            $json_resp = json_decode($response, true);
            
            if (isset($json_resp['status']) && $json_resp['status'] > 0) {
                $cantidad = (int)$json_resp['status'];
                $total_enviados += $cantidad;
                
                // Tomar muestra de clientes para el detalle
                $clientes_muestra = array_slice($grupo['clientes'], 0, 3);
                
                $detalle_envios[] = [
                    'grupo' => $indice_grupo + 1,
                    'bloque' => $indice_bloque + 1,
                    'telefonos_procesados' => count($bloque),
                    'enviados_exitosos' => $cantidad,
                    'texto_resumen' => substr($texto_grupo, 0, 50) . '...',
                    'ejemplos' => $clientes_muestra
                ];
            } else {
                $errorMsg = isset($json_resp['mensaje']) ? $json_resp['mensaje'] : 'Error desconocido';
                $errores[] = "Error API: $errorMsg - Código HTTP: $http_code - Teléfonos: " . implode(', ', array_slice($bloque, 0, 3));
            }
        }
        curl_close($ch);
        
        // Pausa para no saturar la API
        usleep(300000); // 0.3 segundos
    }
}

$tiempo_ejecucion = round(microtime(true) - $tiempo_inicio, 2);

// 8. Preparar respuesta final
$respuesta = [
    'status' => $total_enviados > 0 ? 'success' : 'error',
    'fecha_envio' => date('Y-m-d H:i:s'),
    'tiempo_ejecucion' => $tiempo_ejecucion . ' segundos',
    'estadisticas' => $stats,
    'resumen_envio' => [
        'clientes_procesados' => count($mensajes_para_enviar),
        'mensajes_enviados' => $total_enviados,
        'grupos_mensajes' => count($mensajes_agrupados),
        'bloques_enviados' => count($detalle_envios)
    ]
];

// Agregar advertencias si hay clientes excluidos
if ($stats['sin_telefono'] > 0) {
    $respuesta['advertencias'][] = "⚠️ $stats[sin_telefono] clientes no tienen teléfono";
    $respuesta['clientes_sin_telefono'] = array_slice($clientes_sin_telefono, 0, 20); // Mostrar primeros 20
}

// Resultado final
if ($total_enviados > 0) {
    $respuesta['mensaje_principal'] = "✅ ÉXITO: Se enviaron $total_enviados mensajes a " . count($mensajes_para_enviar) . " clientes.";
    
    if (!empty($errores)) {
        $respuesta['mensaje_principal'] .= " Con " . count($errores) . " errores parciales.";
        $respuesta['errores'] = $errores;
    }
    
    // Calcular efectividad
    $efectividad = round(($total_enviados / count($mensajes_para_enviar)) * 100, 2);
    $respuesta['efectividad'] = $efectividad . '%';
    
} else {
    $respuesta['mensaje_principal'] = "❌ ERROR: No se pudo enviar ningún mensaje.";
    $respuesta['errores'] = $errores;
}

// Agregar detalle de envíos
if (!empty($detalle_envios)) {
    $respuesta['detalle_envios'] = $detalle_envios;
}

echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);