<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Aquí debes incluir tus archivos de conexión y Executor
// include "../autoload.php"; 

$action = isset($_GET['accion']) ? $_GET['accion'] : '';

try {
    switch ($action) {
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $enc = new EncuestaEventosData();
                
                $enc->nombre_completo = $_POST['nombre_completo'];
                $enc->numero_contacto = $_POST['numero_contacto'];
                $enc->especialidad = $_POST['especialidad'];
                $enc->conoce_bialy = $_POST['conoce_bialy'];
                // --- NUEVOS CAMPOS ---
        $enc->email = $_POST['email'];
        $enc->estado = $_POST['estado'];
        $enc->ciudad = $_POST['ciudad'];
        $enc->observacion = isset($_POST['observacion']) ? $_POST['observacion'] : "";
        // ---------------------
                if ($enc->add()) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Encuesta enviada correctamente'
                    ]);
                } else {
                    throw new Exception("No se pudo guardar el registro.");
                }
            }
            break;

        case 'read':
            $result = EncuestaEventosData::getAll();
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>