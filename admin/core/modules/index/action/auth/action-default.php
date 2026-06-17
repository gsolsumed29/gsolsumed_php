<?php

header('Content-Type: application/json');

// Obtener método y ruta
$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? $_GET['path'] : '';

// Router simple
switch ($path) {
    case 'login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $result = Auth::login($data['username'] ?? '', $data['password'] ?? '');
            echo json_encode($result);
        }
        break;
        
    case 'profile':
        if ($method === 'GET') {
            $user = Auth::requireAuth();
            echo json_encode([
                'success' => true,
                'user' => $user
            ]);
        }
        break;
        
    case 'admin':
        if ($method === 'GET') {
            $user = Auth::requireRole('admin');
            echo json_encode([
                'success' => true,
                'message' => 'Bienvenido admin',
                'data' => ['users' => ['admin', 'user']]
            ]);
        }
        break;
        
    case 'refresh':
        if ($method === 'POST') {
            $user = Auth::requireAuth();
            // Generar nuevo token
            $new_token = JWT::generate($user, 86400);
            echo json_encode([
                'success' => true,
                'token' => $new_token
            ]);
        }
        break;
        
    default:
        echo json_encode([
            'error' => 'Ruta no encontrada',
            'available_endpoints' => [
                'POST /login',
                'GET /profile',
                'GET /admin',
                'POST /refresh'
            ]
        ]);
        break;
}
?>