<?php
/**
 * Script para manejo de operaciones CRUD relacionadas con artículos, precios y proveedores
 * Soporta tanto GET como POST para diferentes tipos de operaciones
 */

// =============================================================================
// CAPTURA DE PARÁMETROS DE ENTRADA
// =============================================================================

// Verificar si los parámetros vienen por GET
if ((isset($_GET['tipo'])) || (isset($_GET['accion'])) || (isset($_GET['datos']))) {
    // Obtener parámetros via GET
    $tipo = $_GET['tipo'];
    $accion = $_GET['accion'];
    $datos = $_GET['datos'];
    $clase =$_GET['c'];
$tabla = $_GET['t'];
} else {
    // Obtener parámetros via POST
    $tipo = $_POST['tipo'];
    $accion = $_POST['accion'];
    $datos = $_POST['datos'];
    $clase =$_POST['c'];
    $tabla = $_POST['t'];
}

// =============================================================================
// MANEJO DE OPERACIONES SEGÚN TIPO Y ACCIÓN
// =============================================================================

// TIPO 1: Operaciones relacionadas con artículos y precios
if ($tipo == 1) {

    // ACCIÓN 1: Obtener datos para combobox
    if ($accion == 1) {
        $terminoBusqueda = isset($_GET['search']) ? $_GET['search'] : '';
        if (!empty($terminoBusqueda)) {
        $sqlTermino = str_replace('*', '%', $terminoBusqueda);
         $sqlTermino = '%' . $sqlTermino . '%';


        $clase = $_GET['c'];  // Clase a instanciar
        $tabla = $_GET['t'];  // Tabla de referencia
        
        $datos = new $clase(); // Crear instancia de la clase
        $result = [];          // Inicializar array de resultados
        
        // Manejar según método HTTP
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosCombo($sqlTermino); // Obtener datos para combo
                break;
        }
        
        // Devolver respuesta JSON
        header("Content-Type: application/json");
        echo json_encode($result);
        }else{
            header('Content-Type: application/json');
                echo json_encode([]);
        }
    }

       // ACCIÓN 1: Obtener datos para combobox
    if ($accion == 11) {
        $terminoBusqueda = isset($_GET['search']) ? $_GET['search'] : '';
        if (!empty($terminoBusqueda)) {
        $sqlTermino = str_replace('*', '%', $terminoBusqueda);
         $sqlTermino = '%' . $sqlTermino . '%';


        $clase = $_GET['c'];  // Clase a instanciar
        $tabla = $_GET['t'];  // Tabla de referencia
        
        $datos = new $clase(); // Crear instancia de la clase
        $result = [];          // Inicializar array de resultados
        
        // Manejar según método HTTP
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosComboFicha($sqlTermino); // Obtener datos para combo
                break;
        }
        
        // Devolver respuesta JSON
        header("Content-Type: application/json");
        echo json_encode($result);
        }else{
            header('Content-Type: application/json');
                echo json_encode([]);
        }
    }


    // ACCIÓN 2: Obtener datos filtrados para lista de precios
    if ($accion == 2) {
        $clase = $_GET['c'];    // Clase a instanciar
        $tabla = $_GET['t'];    // Tabla de referencia
        $filtro = $_GET['filtro']; // Filtro para la consulta
        $marca = $_GET['marca']; // Filtro para la consulta
        $ff = $_GET['forma']; // Filtro para la consulta
        $datos = new $clase(); // Crear instancia
        $result = [];          // Inicializar resultados
        
        // Manejar según método HTTP
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                // Obtener datos filtrados
                $result = $datos->getArticulosDashboard($filtro,$marca,NUM_ITEMS_BY_PAGE,$ff);
                break;
        }
        
        // Devolver respuesta JSON
        header("Content-Type: application/json");
        echo json_encode($result);
    }

    // ACCIÓN 3: Obtener precios según proveedores
    if ($accion == 3) {
        $clase = $_GET['c'];    // Clase a instanciar
        $tabla = $_GET['t'];    // Tabla de referencia
        $filtro = $_GET['filtro']; // Filtro para la consulta
        $filtro2 = $_GET['filtro2']; // Filtro para la consulta
        $datos = new $clase(); // Crear instancia
        $result = []; 
                 // Inicializar resultados
      //  echo $filtro2;
       // echo $filtro;

        // Manejar según método HTTP
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                // Obtener precios por proveedor
                $result = $datos->getPreciosProveedores($filtro,$filtro2);
                break;
        }
        
        // Devolver respuesta JSON
        header("Content-Type: application/json");
        echo json_encode($result);
    }

    // ACCIÓN 4: Obtener datos para combobox de proveedores
    if ($accion == 4) {

        $terminoBusqueda = isset($_GET['search']) ? $_GET['search'] : '';
        if (!empty($terminoBusqueda)) {
        $sqlTermino = str_replace('*', '%', $terminoBusqueda);
         $sqlTermino = '%' . $sqlTermino . '%';


        $clase = $_GET['c'];  // Clase a instanciar
        $tabla = $_GET['t'];  // Tabla de referencia
        
        $datos = new $clase(); // Crear instancia de la clase
        $result = [];          // Inicializar array de resultados
        
        // Manejar según método HTTP
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosComboProv($sqlTermino); // Obtener datos para combo
                break;
        }
        
        // Devolver respuesta JSON
        header("Content-Type: application/json");
        echo json_encode($result);
        }else{
            header('Content-Type: application/json');
                echo json_encode([]);
        }
   
    }

    // ACCIÓN 5: Guardar precios de artículo-proveedor
    if ($accion == '5') {
        // Verificar que el parámetro datos sea 1 (habilitado)
        if ($datos == 1) {
            // Configurar cabecera para respuesta JSON
            header('Content-Type: application/json');
            
            // Estructura de respuesta inicial
            $response = [
                'success' => false,
                'message' => '',
                'errors' => []
            ];
            
            try {
                // =================================================================
                // VALIDACIÓN DEL MÉTODO HTTP
                // =================================================================
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido', 405);
                }
                
                // =================================================================
                // CAPTURA Y VALIDACIÓN DE DATOS DEL FORMULARIO
                // =================================================================
                $co_art = isset($_POST['co_art']) ? trim($_POST['co_art']) : '';
                $co_prov = isset($_POST['co_prov']) ? trim($_POST['co_prov']) : '';
                $codigo_proveedor = isset($_POST['codigo_proveedor']) ? trim($_POST['codigo_proveedor']) : '';
                $prec_vta1 = isset($_POST['prec_vta1']) ? floatval($_POST['prec_vta1']) : 0;
                $prec_vta2 = isset($_POST['prec_vta2']) ? floatval($_POST['prec_vta2']) : 0;
                $prec_vta3 = isset($_POST['prec_vta3']) ? floatval($_POST['prec_vta3']) : 0;
                $prec_vta4 = isset($_POST['prec_vta4']) ? floatval($_POST['prec_vta4']) : 0;
                $fecha_registro = isset($_POST['fecha_registro']) ? trim($_POST['fecha_registro']) : date('Y-m-d');

                // =================================================================
                // VALIDACIONES DE DATOS OBLIGATORIOS
                // =================================================================
                if (empty($co_art)) {
                    throw new Exception('El código del artículo es obligatorio', 400);
                }
                
                if (empty($co_prov)) {
                    throw new Exception('El código del proveedor es obligatorio', 400);
                }
                
                // Validar que los precios no sean negativos
                if ($prec_vta1 < 0) {
                    throw new Exception('El precio 1 no puede ser negativo', 400);
                }
                
                if ($prec_vta2 < 0 || $prec_vta3 < 0 || $prec_vta4 < 0) {
                    throw new Exception('Los precios no pueden ser negativos', 400);
                }

                // =================================================================
                // VERIFICAR EXISTENCIA DE ARTÍCULO Y PROVEEDOR
                // =================================================================
                $objeto_funciones = new FuncionesData();
                
                // Verificar si el artículo existe en la base de datos
                $articulo_existe = $objeto_funciones->foundValor('art', 'co_art', $co_art, 'FuncionesData');
                if (empty($articulo_existe) || !isset($articulo_existe[0]->id)) {
                    throw new Exception('El artículo no existe en la base de datos', 400);
                }

                // Verificar si el proveedor existe en la base de datos
                $proveedor_existe = $objeto_funciones->foundValor('prov', 'co_prov', $co_prov, 'FuncionesData');
                if (empty($proveedor_existe) || !isset($proveedor_existe[0]->id)) {
                    throw new Exception('El proveedor no existe en la base de datos', 400);
                }

                // =================================================================
                // VERIFICAR DUPLICADOS (relación artículo-proveedor existente)
                // =================================================================
                $relacion_existe = $objeto_funciones->foundValor('jm_precios_prov', 'co_art', $co_art, 'FuncionesData');
                $duplicado = false;

                if (empty($relacion_existe) || !isset($relacion_existe[0]->id)) {
                    $duplicado = true;
                }

      
                
                // =================================================================
                // MANEJO DE DUPLICADOS O INSERCIÓN NUEVA
                // =================================================================
                if ($duplicado) {
                    // Si ya existe la relación, informar al usuario
                    $response['success'] = false;
                    $response['message'] = 'Ya existe una relación entre este artículo y proveedor. Use la función de edición para modificar los precios.';
                } else {
                    // Crear nueva relación artículo-proveedor
                    $precio_objeto = new ArticuloData();

                    // Asignar valores al objeto
                    $precio_objeto->co_art = $co_art;
                    $precio_objeto->co_prov = $co_prov;
                    $precio_objeto->co_art_prov = !empty($codigo_proveedor) ? strtoupper($codigo_proveedor) : '';
                    $precio_objeto->prec_vta1 = $prec_vta1;
                    $precio_objeto->prec_vta2 = $prec_vta2;
                    $precio_objeto->prec_vta3 = $prec_vta3;
                    $precio_objeto->prec_vta4 = $prec_vta4;
                    $precio_objeto->fecha_registro = $fecha_registro;
                    $precio_objeto->fecha_actualizacion = date('Y-m-d H:i:s');
                    $precio_objeto->usuario_registro = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
                    
                    // Intentar guardar en base de datos
                    $resultado = $precio_objeto->add_articulo_proveedor();
                    
                 
                        // Éxito en la operación
                        $response['success'] = true;
                        $response['message'] = 'Precios del artículo guardados correctamente';
                        $response['data'] = [
                            'co_art' => $co_art,
                            'co_prov' => $co_prov,
                            'precios' => [
                                'prec_vta1' => $prec_vta1,
                                'prec_vta2' => $prec_vta2,
                                'prec_vta3' => $prec_vta3,
                                'prec_vta4' => $prec_vta4
                            ]
                        ];
                   
                }
                
            } catch (Exception $e) {
                // Manejo de errores
                http_response_code($e->getCode() ?: 500);
                $response['message'] = $e->getMessage();
            }
            
            // Devolver respuesta JSON final
            echo json_encode($response);
        }
    }

    
            
    if ($accion == '6') {
          $clase = $_GET['c'];    // Clase a instanciar
        $tabla = $_GET['t'];    // Tabla de referencia
            $datos = new $clase(); 
            $result=[];
            $codigo = $_GET['codigo'];
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getArticulosFichas($codigo);
                    
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
    } 
    

    if ($accion == '7') {
          $clase = $_GET['c'];    // Clase a instanciar
        $tabla = $_GET['t'];    // Tabla de referencia
            $datos = new $clase(); 
            $result=[];
           
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getListaArticulosFichas();
                    
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
    } 

    if ($accion == '8') {
          $clase = $_GET['c'];    // Clase a instanciar
        $tabla = $_GET['t'];    // Tabla de referencia
            $datos = new $clase(); 
            $result=[];
            $codigo = $_GET['search'];
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getArticulosFichasPor($codigo);
                    
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
    } 

    // ACCIÓN 10: Guardar precios de artículo-proveedor en LOTE
    if ($accion == '10') {
        // Configurar cabecera para respuesta JSON
        header('Content-Type: application/json');
        
        // Estructura de respuesta inicial para el lote
        $response = [
            'success' => true,
            'message' => '',
            'processed_count' => 0,
            'error_count' => 0,
            'results' => []
        ];
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido', 405);
            }
            
            $json_payload = file_get_contents('php://input');
            $lote_datos = json_decode($json_payload, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('JSON inválido recibido: ' . json_last_error_msg(), 400);
            }
            if (!is_array($lote_datos) || empty($lote_datos)) {
                throw new Exception('No se recibieron datos para procesar.', 400);
            }

            $objeto_funciones = new FuncionesData();
            
            foreach ($lote_datos as $index => $row_data) {
                $row_result = [
                    'row_number' => $index + 2, // +2 porque la fila 1 es el encabezado
                    'data' => $row_data,
                    'success' => false,
                    'message' => ''
                ];

                try {
                    // --- 1. Extracción de datos usando los NOMBRES DE CAMPO CORRECTOS ---           
                    $co_art_prov = isset($row_data['co_art_prov']) ? trim($row_data['co_art_prov']) : '';
                    $prec_vta1 = isset($row_data['prec_vta1']) ? floatval(str_replace(',', '.', $row_data['prec_vta1'])) : 0;
                    $prec_vta2 = isset($row_data['prec_vta2']) ? floatval(str_replace(',', '.', $row_data['prec_vta2'])) : 0;
                    $prec_vta3 = isset($row_data['prec_vta3']) ? floatval(str_replace(',', '.', $row_data['prec_vta3'])) : 0;
                    $prec_vta4 = isset($row_data['prec_vta4']) ? floatval(str_replace(',', '.', $row_data['prec_vta4'])) : 0;
                    
                    // Nota: str_replace(',', '.', ...) ayuda a procesar números con formato europeo (ej: 10,50)
                    
                        
                    if (empty($co_art_prov)) {
                        throw new Exception('El código del proveedor (co_prov) está vacío.');
                    }
                    if ($prec_vta1 < 0 || $prec_vta2 < 0 || $prec_vta3 < 0 || $prec_vta4 < 0) {
                        throw new Exception('Los precios no pueden ser negativos.');
                    }

                    // --- 3. VERIFICACIÓN DE EXISTENCIA (¡La parte que pediste!) ---
                    // Verificar si el artículo existe
                    if (!$data = $objeto_funciones->foundValorComparacion($co_art_prov)) {
                        throw new Exception("El artículo '{$co_art_prov}' no existe en la base de datos.");
                    }else{
                    $data_co_art = $data[0]->co_art;
                        $data_co_prov = $data[0]->co_prov;
                    // echo $data_co_art;
                    
                    $precio_objeto = new ArticuloData();
                    $precio_objeto->co_art = $data_co_art;  
                    $precio_objeto->co_prov = $data_co_prov;               
                    $precio_objeto->co_art_prov = isset($row_data['co_art_prov']) ? trim($row_data['co_art_prov']) : '';
                    $precio_objeto->prec_vta1 = $prec_vta1;
                    $precio_objeto->prec_vta2 = $prec_vta2;
                    $precio_objeto->prec_vta3 = $prec_vta3;
                    $precio_objeto->prec_vta4 = $prec_vta4;
                
                
                    
                    $resultado = $precio_objeto->add_articulo_proveedor();

                        $row_result['success'] = true;
                        $row_result['message'] = 'Registro guardado correctamente.';
                        $response['processed_count']++;
                
                    }

                

                    /*
                    $relacion_existe = $objeto_funciones->foundValor('jm_precios_prov', ['co_art' => $co_art, 'co_prov' => $co_prov], 'FuncionesData');

                    if ($relacion_existe) {
                        throw new Exception("Ya existe una relación de precios para el artículo '{$co_art}' con el proveedor '{$co_prov}'.");
                    }

                
                    $precio_objeto = new ArticuloData();
                    $precio_objeto->co_art = $co_art;
                    $precio_objeto->co_prov = $co_prov;
                
                    $precio_objeto->co_art_prov = isset($row_data['co_art_prov']) ? trim($row_data['co_art_prov']) : '';
                    $precio_objeto->prec_vta1 = $prec_vta1;
                    $precio_objeto->prec_vta2 = $prec_vta2;
                    $precio_objeto->prec_vta3 = $prec_vta3;
                    $precio_objeto->prec_vta4 = $prec_vta4;
                    $precio_objeto->fecha_registro = date('Y-m-d');
                    $precio_objeto->fecha_actualizacion = date('Y-m-d H:i:s');
                    $precio_objeto->usuario_registro = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
                    
                    $resultado = $precio_objeto->add_articulo_proveedor();
                    
                    if ($resultado) {
                        $row_result['success'] = true;
                        $row_result['message'] = 'Registro guardado correctamente.';
                        $response['processed_count']++;
                    } else {
                        throw new Exception('Error al intentar guardar el registro en la base de datos.');
                    }*/

                } catch (Exception $e) {
                    $row_result['message'] = $e->getMessage();
                    $response['error_count']++;
                    $response['success'] = false; // Si hay cualquier error, el éxito general es falso.
                }
                
                $response['results'][] = $row_result;
            }

            
            
            // Construir mensaje final
            if ($response['error_count'] > 0) {
                $response['message'] = "Proceso completado con {$response['error_count']} errores. {$response['processed_count']} de " . count($lote_datos) . " registros guardados.";
            } else {
                $response['message'] = "¡Proceso completado exitosamente! Se guardaron {$response['processed_count']} registros.";
            }
            
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            $response['success'] = false;
            $response['message'] = 'Error general del proceso: ' . $e->getMessage();
        }
        
        echo json_encode($response);
    }


              
    if ($accion == '12') {
            $clase = $_GET['c'];    // Clase a instanciar
             $tabla = $_GET['t'];    // Tabla de referencia
            $datos = new $clase(); 
            $result=[];
          
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getArticulosFichas_Analisis_ventas();
                    
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
    } 


    
    if($accion==99){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDataFiltradaArticulos($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

    } 

}

function getBatchProcessingSummary($results) {
    $summary = [
        'total_records' => count($results),
        'processed_successfully' => 0,
        'processed_with_errors' => 0,
        'details' => [
            'successful' => [],
            'failed' => []
        ]
    ];

    foreach ($results as $result) {
        if ($result['success']) {
            $summary['processed_successfully']++;
            $summary['details']['successful'][] = [
                'row_number' => $result['row_number'],
                'data' => $result['data'],
                'message' => $result['message']
            ];
        } else {
            $summary['processed_with_errors']++;
            $summary['details']['failed'][] = [
                'row_number' => $result['row_number'],
                'data' => $result['data'],
                'error_message' => $result['message']
            ];
        }
    }

    return $summary;
}
// Fin del script
?>