<?php
// api-rutas.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


// Obtener ubicaciones desde JSON o base de datos
function obtenerUbicaciones() {
    // Desde base de datos (ejemplo con MySQLi)
    /*  
    $conexion = new mysqli("localhost", "usuario", "password", "despachos");
    $resultado = $conexion->query("SELECT * FROM ubicaciones_despacho");
    $ubicaciones = [];
    
    while ($fila = $resultado->fetch_assoc()) {
        $ubicaciones[] = $fila;
    }
    return $ubicaciones;
    */
    
    // Datos de ejemplo corregidos (sintaxis PHP válida)
    $ubicaciones = [
        [
            "id" => 1,
            "direccion" => "Av. Javier Prado 123, Lima",
            "latitud" => -12.0670,
            "longitud" => -77.0335,
            "prioridad" => "alta",
            "tiempo_estimado" => 30
        ],
        [
            "id" => 2,
            "direccion" => "Av. Arequipa 456, Miraflores",
            "latitud" => -12.1220,
            "longitud" => -77.0300,
            "prioridad" => "media",
            "tiempo_estimado" => 25
        ],
        [
            "id" => 3,
            "direccion" => "Calle Los Olivos 789, San Isidro",
            "latitud" => -12.0980,
            "longitud" => -77.0360,
            "prioridad" => "alta",
            "tiempo_estimado" => 20
        ],
        [
            "id" => 4,
            "direccion" => "Av. La Marina 321, Pueblo Libre",
            "latitud" => -12.0710,
            "longitud" => -77.0640,
            "prioridad" => "baja",
            "tiempo_estimado" => 35
        ]
    ];
    
    return $ubicaciones;
}

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] == 'optimizar_ruta') {
        $ubicaciones = obtenerUbicaciones();
        
        // Punto de inicio (puede venir del formulario o ser fijo)
        $puntoInicio = [
            'id' => 0,
            'direccion' => 'Oficina Central',
            'latitud' => isset($_POST['lat_inicio']) ? floatval($_POST['lat_inicio']) : -12.0464,
            'longitud' => isset($_POST['lon_inicio']) ? floatval($_POST['lon_inicio']) : -77.0428,
            'prioridad' => 'inicio',
            'tiempo_estimado' => 0
        ];
        
        // Punto final opcional
        $puntoFin = null;
        if (isset($_POST['lat_fin']) && isset($_POST['lon_fin'])) {
            $puntoFin = [
                'id' => 999,
                'direccion' => 'Punto Final',
                'latitud' => floatval($_POST['lat_fin']),
                'longitud' => floatval($_POST['lon_fin']),
                'prioridad' => 'fin',
                'tiempo_estimado' => 0
            ];
        }
        
        try {
            $optimizador = new OptimizadorRutasData($ubicaciones);
            $rutaOptimizada = $optimizador->generarRutaOptimizada($puntoInicio, $puntoFin);
            $metricas = $optimizador->calcularMetricas($rutaOptimizada);
            
            echo json_encode([
                'success' => true,
                'ruta' => $rutaOptimizada,
                'metricas' => $metricas,
                'total_entregas' => count($ubicaciones)
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Para pruebas: devolver las ubicaciones disponibles
    if (isset($_GET['action']) && $_GET['action'] == 'get_ubicaciones') {
        $ubicaciones = obtenerUbicaciones();
        echo json_encode([
            'success' => true,
            'ubicaciones' => $ubicaciones,
            'total' => count($ubicaciones)
        ]);
    }
}
?>