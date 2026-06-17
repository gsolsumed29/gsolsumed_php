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
if($tipo==1){    
   if($accion ==2){
        if($datos==1){

                // Conexión a tu base de datos
            // $db = new PDO(...);

            // Parámetros que DataTables envía
            $draw = $_POST['draw'];
            $start = $_POST['start'];
            $length = $_POST['length'];
            $searchValue = $_POST['search']['value'];

            // Lógica para consultar la base de datos
            // SELECT f.id, f.numero_factura, c.nombre as nombre_cliente, f.fecha_despacho, COUNT(a.id) as total_articulos
            // FROM facturas f
            // JOIN clientes c ON f.cliente_id = c.id
            // JOIN articulos_factura a ON f.id = a.factura_id
            // WHERE f.estado = 'Despachada'
            // GROUP BY f.id
            // ... (aplicar búsqueda y paginación con $start, $length, $searchValue)

            // Ejemplo de datos simulados
            $data = [
                [
                    'numero_factura' => 'F-0010',
                    'nombre_cliente' => 'Cliente A',
                    'fecha_despacho' => '2023-10-27',
                    'total_articulos' => 5,
                    'direccion_cliente' => 'Av. Principal, Caracas'
                ],
                [
                    'numero_factura' => 'F-0011',
                    'nombre_cliente' => 'Cliente B',
                    'fecha_despacho' => '2023-10-27',
                    'total_articulos' => 12,
                    'direccion_cliente' => 'Centro Comercial, Valencia'
                ]
            ];

            $totalRecords = count($data); // Total de registros sin filtrar
            $totalFiltered = count($data); // Total de registros después del filtro

            // Formatear la respuesta para DataTables
            $response = [
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalFiltered,
                "aaData" => $data
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        }
        if($datos==2){
            
            // Establecer cabecera para respuesta JSON
            header("Content-Type: application/json");
            
            try {
                // Verificar que se haya enviado el parámetro 'etiquetas'
                if(!isset($_POST['etiquetas'])) {
                    throw new Exception("No se recibieron los datos de las etiquetas");
                }
                
                // Decodificar el JSON recibido
                $etiquetasData = json_decode($_POST['etiquetas'], true);
                
                // Verificar si la decodificación fue exitosa
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Error al decodificar los datos JSON: " . json_last_error_msg());
                }
                
                // Extraer los datos del objeto
                $paquetes = $etiquetasData['paquetes'];
                
                // CAMBIO: Calcular el total de paquetes desde el array recibido
                $totalPaquetes = count($paquetes);
             
                $totalFacturas = $etiquetasData['total_facturas'];
                $fechaImpresion = $etiquetasData['fecha_impresion'];
                $usuario = $etiquetasData['usuario'];
                $loteId = $etiquetasData['lote_id'];
                // Ejecutar la inserción. No necesitamos un resultado de aquí.

              

                // Crear un registro principal para el lote de empaquetado
                $empaquetadoObj = new EmpaquetadoData();
                $empaquetadoObj->loteId = $loteId;
                $empaquetadoObj->total_paquetes = $totalPaquetes;
                $empaquetadoObj->total_facturas = $totalFacturas;
                $empaquetadoObj->fecha_impresion = $fechaImpresion;            
                // Guardar el empaquetado principal y obtener el ID
                $empaquetadoObj->add();
                
                // ELIMINADO: La línea de depuración que rompía el JSON
                // echo $empaquetadoId;
              
                
                // Procesar cada paquete
                foreach($paquetes as $paquete) {
                    $paqueteObj = new PaqueteData();
                    
                    // Establecer las propiedades del paquete (SOLO LAS QUE EXISTEN EN LA CLASE)
                    $paqueteObj->loteId = $loteId;
                    $paqueteObj->numero_paquete = $paquete['numero_paquete'];
                    $paqueteObj->facturas = json_encode($paquete['facturas']); // Guardar como JSON
                    $paqueteObj->codigo_cliente = $paquete['codigo_cliente'];
                    $paqueteObj->fecha_despacho = $paquete['fecha_despacho'];
                    $paqueteObj->qr_data = $paquete['qr_data'];       
                    // Guardar el paquete
                    $paqueteObj->add();
                }
                
                // Preparar respuesta exitosa
                $response = array(
                    'success' => true,
                    'message' => 'Paquetes guardados correctamente',
                    'id_empaquetado' => $loteId,
                    'total_paquetes' => $totalPaquetes,
                    'total_facturas' => $totalFacturas
                );
                
                // Devolver respuesta JSON
                echo json_encode($response);
                
            } catch(Exception $e) {
                // Preparar respuesta de error
                $response = array(
                    'success' => false,
                    'message' => $e->getMessage()
                );
                
                // Devolver respuesta JSON
                echo json_encode($response);
            }
        }

        if($datos==3){
            
            $clase =$_GET['c'];
            $tabla = $_GET['t'];
          $datos = new $clase(); 
          $result=[];
        
            switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosChoferes();
                break;
            }
        
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        }

        
        if($datos==4){
            
                    $clase =$_GET['c'];
                    $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result=[];
            
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getAllDatosZonas();
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        }


        if($datos==5){
            
                    $clase =$_GET['c'];
                    $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result=[];
            
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getAllDatosVehiculos();
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        }       

        if($datos==6){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $datos = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getAllDatosPaquetesChofer($filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);

        }

       
        // action-default.php - Endpoint datos=9 para historial
        if($datos=='9'){    
            header('Content-Type: application/json');
            
            // Activar logging para debug
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            error_log("=== HISTORIAL ENTREGAS - INICIO ===");
            
            try {
                // Obtener parámetros
                $userId = $_GET['user_id'] ?? $_POST['user_id'] ?? null;
                $fechaInicio = $_GET['fecha_inicio'] ?? $_POST['fecha_inicio'] ?? null;
                $fechaFin = $_GET['fecha_fin'] ?? $_POST['fecha_fin'] ?? null;
                $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
                $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
                $estatus = $_GET['estatus'] ?? $_POST['estatus'] ?? '2'; // Por defecto entregados
                
                error_log("Parámetros recibidos:");
                error_log("  user_id: $userId");
                error_log("  fecha_inicio: $fechaInicio");
                error_log("  fecha_fin: $fechaFin");
                error_log("  limit: $limit");
                error_log("  offset: $offset");
                error_log("  estatus: $estatus");
                
                // Validar usuario
                if (empty($userId)) {
                    throw new Exception('El ID de usuario es requerido.');
                }
                
                // Validar y sanitizar límites
                $limit = max(1, min(100, $limit)); // Entre 1 y 100
                $offset = max(0, $offset);
                
                // Construir WHERE clause
                $whereConditions = [];
                $whereConditions[] = "dc.chofer_id = '$userId'";
                
            
                // Filtrar por fecha
                if ($fechaInicio) {
                    $fechaInicioFormatted = date('Y-m-d', strtotime($fechaInicio));
                    $whereConditions[] = "CAST(p.dato_extra1 AS DATE) >= '$fechaInicioFormatted'";
                }
                
                if ($fechaFin) {
                    $fechaFinFormatted = date('Y-m-d', strtotime($fechaFin));
                    $whereConditions[] = "CAST(p.dato_extra1 AS DATE) <= '$fechaFinFormatted'";
                }
                
                $whereClause = "WHERE " . implode(" AND ", $whereConditions);
                
                // Construir consulta SQL
                $sql = "SELECT 
                        dl.loteID,
                        dl.cantidad_paquetes,
                        dc.vehiculo,
                        dc.fecha_carga,
                        MAX(p.dato_extra1) AS dato_extra1, -- o cualquier agregación que necesites
                        jmpr.co_cli,
                        c.cli_des
                    FROM jm_despacho_lotes dl
                    INNER JOIN jm_despacho_carga dc ON dc.codigo = dl.codigo
                    INNER JOIN jm_paquetes_reg jmpr ON jmpr.co_lote = dl.loteID
                    INNER JOIN clientes c ON jmpr.co_cli = c.co_cli
                    LEFT JOIN jm_paquetes p ON p.co_lote = dl.loteID
                                $whereClause
                                GROUP BY dl.loteID, dl.cantidad_paquetes, dc.vehiculo, dc.fecha_carga, 
                jmpr.co_cli, c.cli_des
        ORDER BY MAX(p.dato_extra1) DESC, MAX(p.id) DESC
                        OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
                
                error_log("SQL ejecutado: $sql");
               //echo $sql;
                // Ejecutar consulta
                $query = Executor::doitAr($sql);
                
                // Obtener total para paginación
                $sqlCount = "SELECT COUNT(DISTINCT dl.loteID) as total 
                FROM jm_despacho_lotes dl
                INNER JOIN jm_despacho_carga dc ON dc.codigo = dl.codigo
                INNER JOIN jm_paquetes p ON p.co_lote = dl.loteID
                $whereClause";
                
                $countResult = Executor::doit($sqlCount);
                $totalItems = $countResult[0]['total'] ?? 0;
                $entregas = [];
                foreach($query as $r) {
                    $entregas[] = [
                        'loteID' => $r['loteID'] ?? '',
                        'cantidad_paquetes' => $r['cantidad_paquetes'] ?? 0,
                        'vehiculo' => $r['vehiculo'] ?? '',
                        'fecha_carga' => $r['fecha_carga'] ?? '',
                        'dato_extra1' => $r['dato_extra1'] ?? '',
                        'user_id' => $userId,
                        'cli_des' => $r['cli_des'] ?? '',
                        'fecha_entrega' => $r['dato_extra1'] ?? '',
                        'estatus' => !empty($r['dato_extra1']) ? 'Entregado' : 'Pendiente',
                    ];
                }
                
                // Calcular metadatos de paginación
                $totalPages = ceil($totalItems / $limit);
                $currentPage = floor($offset / $limit) + 1;
                
                $response = [
                    'success' => true,
                    'message' => 'Historial obtenido exitosamente',
                    'data' => $entregas,
                    'total' => count($entregas),
                    'metadata' => [
                        'current_page' => $currentPage,
                        'items_per_page' => $limit,
                        'total_items' => $totalItems,
                        'total_pages' => $totalPages,
                        'has_next_page' => $currentPage < $totalPages,
                        'has_previous_page' => $currentPage > 1,
                        'filters_applied' => [
                            'user_id' => $userId,
                            'fecha_inicio' => $fechaInicio,
                            'fecha_fin' => $fechaFin,
                            'estatus' => $estatus
                        ]
                    ]
                ];
                
                error_log("Historial generado: " . count($entregas) . " registros");
                error_log("=== HISTORIAL ENTREGAS - FIN ===");
                
                echo json_encode($response);
                
            } catch (Exception $e) {
                error_log("ERROR en historial: " . $e->getMessage());
                
                http_response_code(400); 
                echo json_encode([
                    'success' => false,
                    'message' => 'Error obteniendo historial: ' . $e->getMessage(),
                    'error_code' => 'HISTORY_ERROR',
                    'data' => [],
                    'total' => 0
                ]);
            }
            exit;
        }


       
        
        
     
        }
      
   
}



?>