<?php
if((isset($_GET['tipo']))  || (isset($_GET['accion'])) || (isset($_GET['datos']))){
 
  $tipo = $_GET['tipo'];
  $accion = $_GET['accion'];
  $datos = $_GET['datos']; 

}else{

  $tipo = $_POST['tipo'];
  $accion = $_POST['accion'];
  $datos = $_POST['datos']; 
}

if($tipo=='1'){    
    if($accion =='1'){
        if($datos=='1'){

                // --- INICIO: Limpieza del buffer de salida ---
                // Captura cualquier salida que se haya generado hasta ahora (errores, espacios, etc.)
                if (ob_get_length()) ob_clean(); 
                // --- FIN: Limpieza ---

                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $result=[];
                $filtro = $_GET['filtro'];
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getAllDatosPaquetes($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                // Ahora, solo se enviará el JSON limpio
                echo json_encode($result);
        }        
        if($datos=='2'){    
                try {
                    // Obtener los datos JSON del cuerpo de la solicitud
                    $jsonData = file_get_contents('php://input');
                    $data = json_decode($jsonData, true);
                    $objeto_funciones = New FuncionesData();
                    $codigo = $objeto_funciones->numeroEtiqueta();
                
                    // Validar la estructura de datos
                    if (!isset($data['emcabezado']) || !is_array($data['emcabezado'])) {
                        throw new Exception('El encabezado de la carga es requerido y debe ser un array.');
                    }
                
                    if (!isset($data['lotes']) || !is_array($data['lotes']) || empty($data['lotes'])) {
                        throw new Exception('No hay lotes para cargar. El array de lotes está vacío o no fue enviado.');
                    }
                    
                    // Validar campos clave dentro del encabezado
                    if (empty($data['emcabezado']['vehiculo']) || empty($data['emcabezado']['chofer_id'])) {
                        throw new Exception('El vehículo y el chofer son campos obligatorios en el encabezado.');
                    }
                    
                    // Extraer datos de la estructura
                    $emcabezado = $data['emcabezado'];
                    $lotes = $data['lotes'];
                    $fecha_carga = $data['fecha_carga'] ?? date('Y-m-d H:i:s');
                
                    // Extraer variables del encabezado para mayor claridad
                    $vehiculo = $emcabezado['vehiculo'];
                    $chofer_id = $emcabezado['chofer_id'];
                    $ayudante_id = $emcabezado['ayudante_id'] ?? null;
                    $zona_id = $emcabezado['zona_id'];
                    $total_paquetes = $emcabezado['total_paquetes'];
                    $zona_descripcion = $emcabezado['zona_descripcion'];

                    // Validar la estructura de cada lote
                    foreach ($lotes as $lote) {
                        if (!isset($lote['id']) || !isset($lote['loteID']) || !isset($lote['cantidad_paquetes'])) {
                            throw new Exception('Cada lote debe tener los campos: id, loteID y cantidad_paquetes');
                        }
                    }
                
                    // Lógica de negocio para registrar la carga
                    $objeto_carga = new VehiculoData();
                
                    // Registrar el encabezado de la carga
                    $resultado_carga = $objeto_carga->registrarCarga($emcabezado, $fecha_carga, $codigo);
                
                    // Registrar cada lote, vinculándolo con el ID de la carga
                    $resultado_lotes = $objeto_carga->registrarLotesEnCarga($lotes, $codigo);
                
                    // Respuesta exitosa
                    echo json_encode([
                        'success' => true,
                        'message' => 'Carga del vehículo registrada exitosamente.',
                        'carga_id' => '01'
                    ]);
                
                } catch (Exception $e) {
                    // Respuesta de error
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
        }
        
        // NUEVO: Confirmar entrega de lote
        if($datos=='4'){
            try {
                // Obtener los datos JSON del cuerpo de la solicitud
                $jsonData = file_get_contents('php://input');
                $data = json_decode($jsonData, true);
                
                $objeto_carga = new VehiculoData();
                
                if (!isset($data['loteId']) || !isset($data['confirmado'])) {
                    throw new Exception('Faltan datos requeridos: loteId y confirmado');
                }
                
                $loteId = $data['loteId'];
                $notas = $data['notas'] ?? '';
                $confirmado = $data['confirmado'];
                
                if ($confirmado == 1) {
                    $resultado = $objeto_carga->confirmarEntrega($loteId, $notas);
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Lote marcado como entregado correctamente'
                    ]);
                } else {
                    throw new Exception('La confirmación debe ser igual a 1');
                }
                
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    if($accion =='2'){
        if($datos=='1'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getFacturasInventarioEmbarcos($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }
        if($datos=='2'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            $filtro2 = $_GET['filtro2'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getEmbarquesInventarioAlmacen($filtro,$filtro2);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }       
        if($datos=='3'){
            $clase =$_GET['c'];
            $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getFacturasPaquetes($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }

        if($datos=='4'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getDetallesEmbarque($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }

        if($datos=='5'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getDetallesLotesEmbarque($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }

        if($datos=='6'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getEstadisticasEmbarque($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }

        if($datos=='7'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getDetallesLoteID($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);

        }
        
        if($datos=='8'){
            $clase = $_GET['c'];
            $tabla = $_GET['t'];
            $datos = new $clase(); 
            $co_chofer = $_GET['co_chofer'];   
            
            $response = [
                'status' => 'error',
                'message' => 'Error desconocido',
                'data' => []
            ];
            
            try {
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getEmbarquesPorChofer($co_chofer);
                        
                        // Convertir objetos a arrays para json_encode
                        $dataArray = [];
                        foreach ($result as $obj) {
                            if (is_object($obj)) {
                                $dataArray[] = [
                                    'id' => $obj->carga_id ?? null,
                                    'embarco' => 'Embarque ' . ($obj->carga_id ?? ''),
                                    'cliente' => $obj->zona_nombre ?? 'Sin zona',
                                    'fecha' => $obj->fecha_carga ?? '',
                                    'estado' => $obj->estatus ?? 'Pendiente',
                                    'vehiculo' => $obj->vehiculo_nombre ?? '',
                                    'chofer' => $obj->chofer_nombre ?? '',
                                    'total_paquetes' => $obj->total_paquetes ?? 0,
                                    'paquetes_entregados' => $obj->paquetes_entregados ?? 0,
                                ];
                            } else {
                                $dataArray[] = $obj;
                            }
                        }
                        
                        $response = [
                            'status' => 'success',
                            'message' => count($dataArray) . ' embarques encontrados',
                            'data' => $dataArray
                        ];
                        break;
                    default:
                        $response['message'] = 'Método no permitido';
                }
            } catch (Exception $e) {
                $response['message'] = 'Error: ' . $e->getMessage();
            }
            
            header("Content-Type: application/json");
            echo json_encode($response);
        }

        // =============================================
        // NUEVO: Obtener facturas del embarque con totales
        // =============================================
        if($datos=='9'){
            $clase = $_GET['c'];
            $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result = []; 
            $filtro = $_GET['filtro'];   
            
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    // Usar el nuevo método getFacturasByEmbarqueId
                    $result = $datos->getFacturasByEmbarqueId($filtro);
                    break;
            }    
            
            header("Content-Type: application/json");
            echo json_encode($result);
        }

        if($datos=='10'){
            $clase = $_GET['c'];
            $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result = []; 
            $filtro = $_GET['filtro'];   
            
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getRenglonesFactura($filtro);
                    break;
            }    
            
            header("Content-Type: application/json");
            echo json_encode($result);
        }
    }
}
?>