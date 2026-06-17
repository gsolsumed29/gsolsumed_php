<?php
// Siempre al inicio del archivo
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Validar parámetro de acción
if (!isset($_GET['datos'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Parámetro "datos" requerido'
    ]);
    exit();
}

// Lógica para el endpoint 7 (consulta de lotes)
if ($_GET['datos'] == '7') {
    try {
        // Validar parámetros requeridos
        $requiredParams = ['c', 't', 'user_id', 'filtro'];
        foreach ($requiredParams as $param) {
            if (!isset($_GET[$param]) || empty($_GET[$param])) {
                echo json_encode([
                    'success' => false,
                    'error' => "Parámetro '$param' requerido"
                ]);
                exit();
            }
        }
        
        // Sanitizar inputs
        $clase = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
        $tabla = htmlspecialchars($_GET['t'], ENT_QUOTES, 'UTF-8');
        $userId = htmlspecialchars($_GET['user_id']); // Convertir a entero
        $filtro = $_GET['filtro']; // Necesita sanitización especial
        $lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
        $lng = isset($_GET['lng']) ? floatval($_GET['lng']) : null;
        
        // Sanitizar filtro (lista de lotes separados por comas)
        $filtroSanitizado = preg_replace('/[^a-zA-Z0-9,\-]/', '', $filtro);
        
        // Instanciar clase
        if (!class_exists($clase)) {
            throw new Exception("Clase '$clase' no existe");
        }
        
        $instancia = new $clase();
        
        // Verificar que el método existe
        if (!method_exists($instancia, 'getAllDatosPaquetesChoferApp')) {
            throw new Exception("Método no disponible en la clase");
        }
        
        // Llamar al método con parámetros sanitizados
        $result = $instancia->getAllDatosPaquetesChoferApp(
            $filtroSanitizado,
            $userId,
            $lat,
            $lng
        );
        
        // Asegurar que la respuesta sea JSON
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Error interno del servidor',
            'debug' => $e->getMessage() // Solo en desarrollo
        ]);
    }
    exit();
}

?>