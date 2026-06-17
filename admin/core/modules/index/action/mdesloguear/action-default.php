<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido. Use POST.'
    ]);
    exit();
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? null;

// Opcional: Verificar que el user_id coincide con la sesión actual
if (isset($_SESSION['id']) && $user_id == $_SESSION['id']) {
    // Limpiar datos específicos de sesión
    unset($_SESSION['id']);
    unset($_SESSION['user_role']);
    unset($_SESSION['user_name']);
    // Agrega aquí otras variables de sesión que uses
}

// Destruir la sesión completamente
session_destroy();

// También podrías registrar el logout en la base de datos aquí
// Ej: INSERT INTO user_logs (user_id, action, timestamp) VALUES (?, 'logout', NOW())

echo json_encode([
    'status' => 'success',
    'message' => 'Sesión cerrada exitosamente',
    'timestamp' => date('Y-m-d H:i:s')
]);
?>