<?php
// api/registros.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Para solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Obtener la acción solicitada
 $action = isset($_GET['accion']) ? $_GET['accion'] : '';

try {
    switch ($action) {
        case 'read':
            // Leer registros
            if (isset($_GET['id'])) {
                // Leer un registro específico
                $id = $_GET['id'];
                $result = CajasData::getById($id);
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'data' => [$result]
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Registro no encontrado'
                    ]);
                }
            } else {
                // Leer todos los registros (con búsqueda opcional)
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $result = CajasData::getAll($search);
                
                echo json_encode([
                    'success' => true,
                    'data' => $result
                ]);
            }
            break;
        case 'getVendedores':
            // Leer registros
            if (isset($_GET['id'])) {
                // Leer un registro específico
                $id = $_GET['id'];
                $result = CajasData::getDataVendedores($id);
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'data' => [$result]
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Registro no encontrado'
                    ]);
                }
            } else {
                // Leer todos los registros (con búsqueda opcional)
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $result = CajasData::getDataVendedores();
                
                echo json_encode([
                    'success' => true,
                    'data' => $result
                ]);
            }
            break;    
        case 'create':
            // Crear un nuevo registro
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $caja = new CajasData();
                $caja->co_ven = $_POST['co_ven'];
                $caja->fecha = $_POST['fecha'];
                $caja->turno = $_POST['turno'];
                $caja->estatus = $_POST['estatus'];
                $caja->monto_bs_efectivo = $_POST['monto_bs_efectivo'];
                $caja->monto_bs_transf = $_POST['monto_bs_transf'];
                $caja->monto_bs_bio = $_POST['monto_bs_bio'];
                $caja->monto_bs_pago_movil = $_POST['monto_bs_pago_movil'];
                $caja->monto_usd_efectivo = $_POST['monto_usd_efectivo'];
                $caja->monto_usd_zeller = $_POST['monto_usd_zeller'];
                $caja->campo1 = isset($_POST['campo1']) ? $_POST['campo1'] : '';
                $caja->campo2 = isset($_POST['campo2']) ? $_POST['campo2'] : '';
                $caja->campo3 = isset($_POST['campo3']) ? $_POST['campo3'] : '';
                
                $result = $caja->add();
                
                 echo json_encode([
                        'success' => true,
                        'message' => 'Registro actualizado correctamente'
                    ]);
               
            }
            break;
            
        case 'update':
            // Actualizar un registro existente
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $caja = new CajasData();
                $caja->id = $_POST['id'];
                $caja->co_ven = $_POST['co_ven'];
                $caja->fecha = $_POST['fecha'];
                $caja->turno = $_POST['turno'];
                $caja->estatus = $_POST['estatus'];
                $caja->monto_bs_efectivo = $_POST['monto_bs_efectivo'];
                $caja->monto_bs_transf = $_POST['monto_bs_transf'];
                $caja->monto_bs_bio = $_POST['monto_bs_bio'];
                $caja->monto_bs_pago_movil = $_POST['monto_bs_pago_movil'];
                $caja->monto_usd_efectivo = $_POST['monto_usd_efectivo'];
                $caja->monto_usd_zeller = $_POST['monto_usd_zeller'];
                $caja->campo1 = isset($_POST['campo1']) ? $_POST['campo1'] : '';
                $caja->campo2 = isset($_POST['campo2']) ? $_POST['campo2'] : '';
                $caja->campo3 = isset($_POST['campo3']) ? $_POST['campo3'] : '';
                
                $result = $caja->update();
               // echo $result;
               
                    echo json_encode([
                        'success' => true,
                        'message' => 'Registro actualizado correctamente'
                    ]);
               
            }
            break;
            
        case 'delete':
            // Eliminar un registro
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $result = CajasData::deleteById($id);
                
                 echo json_encode([
                        'success' => true,
                        'message' => 'Registro actualizado correctamente'
                    ]);
               
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
            break;
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>