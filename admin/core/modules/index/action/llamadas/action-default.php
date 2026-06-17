<?php
// api/llamadas.php
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
                $result = LlamadasData::getById($id);
                
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
                $result = LlamadasData::getAll($search);
                
                echo json_encode([
                    'success' => true,
                    'data' => $result
                ]);
            }
            break;
            
        case 'getVendedores':
            // Obtener lista de vendedores
            $result = LlamadasData::getDataVendedores();
            
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;
            
        case 'getClientes':
            // Buscar clientes
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $result = LlamadasData::getClientes($search);
            
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;
            
        case 'create':
            // Crear un nuevo registro (desde el modal de reporte de llamadas)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                // Recibir datos del formulario (puede venir como POST o JSON)
                $inputData = $_POST;
                
                // Si no hay datos POST, intentar leer JSON
                if (empty($inputData)) {
                    $json = file_get_contents('php://input');
                    $inputData = json_decode($json, true);
                }
                
                // Validar datos requeridos
                if (empty($inputData['co_cli'])) {
                    throw new Exception('El código de cliente es requerido');
                }
                
                if (empty($inputData['numero_contactado'])) {
                    throw new Exception('El número contactado es requerido');
                }
                
                // Crear objeto LlamadasData
                $llamada = new LlamadasData();
                
                // Mapear campos del formulario a los campos de la BD
                $llamada->co_cli = $inputData['co_cli'];
                $llamada->des_cli = $inputData['cli_des'] ?? '';
                $llamada->responsable = $inputData['responsable'] ?? '';
                
                // Fecha y hora de la llamada (usar fecha actual si no se proporciona)
                $llamada->fecha_hora_llamada = date('Y-m-d H:i:s');
                
                // Tipo de requerimiento (mapear desde tipo_llamada)
                $llamada->tipo_requerimiento = mapTipoLlamada($inputData['tipo_llamada'] ?? 'OTRO');
                
                // Observaciones
                $llamada->observacion = $inputData['observaciones'] ?? '';
                
                // Datos extras para almacenar información específica
                $llamada->numero_contactado = $inputData['numero_contactado'] ?? ''; // Número contactado
                $llamada->estado_llamada = $inputData['estado_llamada'] ?? '';    // Estado de la llamada
                $llamada->compromiso_monto = $inputData['compromiso_monto'] ?? '';  // Monto comprometido


                     $llamada->dato_extra1 = $inputData['dato_extra1'] ?? ''; // Número contactado

                     $llamada->dato_extra2 = $inputData['dato_extra2'] ?? ''; // Número contactado

                
                // Fecha posible respuesta (compromiso de pago)
                $llamada->fecha_posible_respuesta = !empty($inputData['fecha_posible_respuesta']) ? 
                                                    $inputData['fecha_posible_respuesta'] : null;
                
                // Fecha de seguimiento
                $llamada->fecha_seguimiento = !empty($inputData['fecha_seguimiento']) && 
                                             !empty($inputData['requiere_seguimiento']) ? 
                                             $inputData['fecha_seguimiento'] : null;
                
                $llamada->requiere_seguimiento = $inputData['requiere_seguimiento'] ?? '';
                

                // Estatus (1 = activo, 0 = inactivo)
                $llamada->estatus = 1;
                
                // Vendedor (si está disponible)
                $llamada->co_ven = $inputData['co_ven'] ?? obtenerVendedorPorCliente($inputData['co_cli']);
                
                // Guardar en BD
                $result = $llamada->add();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Llamada registrada correctamente',
                    'data' => [
                        'id' => $result,
                        'co_cli' => $llamada->co_cli
                    ]
                ]);
            }
            break;
            
        case 'update':
            // Actualizar un registro existente
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                // Recibir datos
                $inputData = $_POST;
                if (empty($inputData)) {
                    $json = file_get_contents('php://input');
                    $inputData = json_decode($json, true);
                }
                
                // Validar ID
                if (empty($inputData['id'])) {
                    throw new Exception('ID de registro no proporcionado');
                }
                
                $llamada = new LlamadasData();
                $llamada->id = $inputData['id'];
                $llamada->co_cli = $inputData['co_cli'];
                $llamada->des_cli = $inputData['cli_des'] ?? '';
                $llamada->responsable = $inputData['responsable'] ?? '';
                $llamada->fecha_hora_llamada = $inputData['fecha_hora_llamada'] ?? date('Y-m-d H:i:s');
                $llamada->tipo_requerimiento = $this->mapTipoLlamada($inputData['tipo_llamada'] ?? 'OTRO');
                $llamada->observacion = $inputData['observaciones'] ?? '';
                $llamada->dato_extra1 = $inputData['numero_contactado'] ?? '';
                $llamada->dato_extra2 = $inputData['estado_llamada'] ?? '';
                $llamada->dato_extra3 = $inputData['compromiso_monto'] ?? '';
                $llamada->fecha_posible_respuesta = !empty($inputData['compromiso_fecha']) ? 
                                                    $inputData['compromiso_fecha'] : null;
                $llamada->fecha_seguimiento = !empty($inputData['fecha_seguimiento']) && 
                                             !empty($inputData['requiere_seguimiento']) ? 
                                             $inputData['fecha_seguimiento'] : null;
                $llamada->estatus = $inputData['estatus'] ?? 1;
                $llamada->co_ven = $inputData['co_ven'] ?? '';
                
                $result = $llamada->update();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Llamada actualizada correctamente'
                ]);
            }
            break;
            
        case 'delete':
            // Eliminar un registro
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? $_GET['id'] ?? null;
                
                if (!$id) {
                    throw new Exception('ID no proporcionado');
                }
                
                $result = LlamadasData::deleteById($id);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Llamada eliminada correctamente'
                ]);
            }
            break;
            
        case 'getLlamadasCliente':
            // Obtener llamadas de un cliente específico
            if (isset($_GET['co_cli'])) {
                $co_cli = $_GET['co_cli'];
                $result = LlamadasData::getLlamadasByCliente($co_cli);
                
                echo json_encode([
                    'success' => true,
                    'data' => $result
                ]);
            } else {
                throw new Exception('Código de cliente no proporcionado');
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

/**
 * Funciones auxiliares
 */
function mapTipoLlamada($tipo) {
    $map = [
        'GESTION_COBRO' => 'GESTION_COBRO',
        'RECORDATORIO' => 'RECORDATORIO',
        'NEGOCIACION' => 'NEGOCIACION',
        'CONFIRMACION' => 'CONFIRMACION',
        'OTRO' => 'OTRO'
    ];
    
    return $map[$tipo] ?? 'OTRO';
}

function obtenerVendedorPorCliente($co_cli) {
    // Implementar lógica para obtener el vendedor del cliente
    // Esto depende de tu estructura de BD
    try {
        return LlamadasData::getVendedorByCliente($co_cli);
    } catch (Exception $e) {
        return '';
    }
}
?>