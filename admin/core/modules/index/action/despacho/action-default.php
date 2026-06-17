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
    if($accion ==1){

        if($datos==2){    
            
          
                try {
                   // Obtener los datos JSON del cuerpo de la solicitud
                    $jsonData = file_get_contents('php://input');
                    $data = json_decode($jsonData, true);
                  // var_dump($data);
                    // Validar datos básicos
                    if (!isset($data['fact_num']) || empty($data['fact_num'])) {
                        throw new Exception('Número de factura requerido');
                    }
                    
                    if (!isset($data['productos']) || !is_array($data['productos']) || empty($data['productos'])) {
                        throw new Exception('No hay productos para despachar');
                    }
                    
                    $fact_num = $data['fact_num'];
                    $preparador = $data['preparador'] ?? 'Desconocido';
                     $productos = $data['productos'];

                    $fecha_despacho = $data['fecha_despacho'] ?? date('Y-m-d H:i:s');

                    // Procesar cada producto
                            $productos_procesados = [];
                            $errores = [];
                          
                            $objeto_despacho = new FacturaData();
                            $resultadoBandera=$objeto_despacho->existeDespachoFactura($fact_num);
                            $bandera = $resultadoBandera['desp_nun'];
                         //   echo "Bandera: " . $bandera; // Depuración
                            if ($bandera!=null) {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Ya existe un despacho registrado para la factura ' . $fact_num
                                ]);
                                exit; // Terminar la ejecución
                            }

                            $resultado = $objeto_despacho->registrarDespacho($fact_num,$preparador);
                            $resultado2 = $objeto_despacho->getUltimoDespacho();                            	
                            $desp_nun = $resultado2['desp_nun'];
                        
                            $resultado2 = $objeto_despacho->registrarDespachoReg($productos,$desp_nun);
                                    
                       
                           
                    // Respuesta exitosa
                    echo json_encode([
                        'success' => true,
                        'message' => 'Despacho registrado exitosamente'
                     
                    ]);
                    
           
                

         

                } catch (Exception $e) {
                    // Respuesta de error
                    echo json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
        }
     
        if($datos==3){    
            
            // Establecemos el encabezado para devolver JSON
            header('Content-Type: application/json');

            try {
                // 1. Obtener los datos del POST request (enviados por jQuery AJAX)
                $loteId = $_POST['loteId'] ?? null;
                $notas = $_POST['notas'] ?? '';
                $confirmado = $_POST['confirmado'] ?? 0;

                // 2. Validar datos básicos
                if (empty($loteId)) {
                    throw new Exception('El ID del lote es requerido.');
                }

                if ($confirmado != 1) {
                    throw new Exception('Debe marcar la casilla de confirmación para continuar.');
                }

                // 3. Procesar la confirmación en la base de datos
                // Asegúrate de que la clase VehiculoData esté incluida
                // require_once 'models/VehiculoData.php'; // Ajusta la ruta si es necesario
                $objetoVehiculo = new VehiculoData();

                // Llamamos a un nuevo método para actualizar el estado de la entrega
                // ¡Este método debes crearlo en tu clase VehiculoData!
                $resultado = $objetoVehiculo->confirmarEntrega($loteId, $notas);
                $resultado = $objetoVehiculo->getFacturas($loteId);          
                $facturas =$resultado[0]->facturas;
                $resultado = $objetoVehiculo->updateFacturas($facturas);
              if ($resultado) {
                    // 4. Respuesta exitosa
                    echo json_encode([
                        'success' => true,
                        'message' => 'Entrega confirmada y registrada exitosamente.'
                    ]);
                } else {
                    // Si el método devuelve false, algo salió mal en la BD
                    throw new Exception('No se pudo actualizar el estado del lote en la base de datos.');
                }

            } catch (Exception $e) {
                // 5. Respuesta de error
                // Opcional: puedes enviar un código de estado HTTP de error
                // http_response_code(400); 
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            exit; // Terminamos la ejecución del script para no enviar más salida
        }

        
        if($datos==4){    
            
            // Establecemos el encabezado para devolver JSON
            header('Content-Type: application/json');

            try {
                // 1. Leer el cuerpo crudo de la solicitud (request body)
                $json_data = file_get_contents('php://input');

                // 2. Decodificar el string JSON a un array asociativo de PHP
                // El segundo parámetro `true` es importante para obtener un array en lugar de un objeto
                $data = json_decode($json_data, true);

                // 3. Verificar si la decodificación fue exitosa
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar el JSON: ' . json_last_error_msg());
                }

                // 4. Ahora puedes acceder a los datos que enviaste desde JavaScript
                $loteId = $data['loteId'] ?? null;
                $notas = $data['notas'] ?? '';
                $confirmado = $data['confirmado'] ?? 0;

                
                // 2. Validar datos básicos
                if (empty($loteId)) {
                    throw new Exception('El ID del lote es requerido.');
                }

                if ($confirmado != 1) {
                    throw new Exception('Debe marcar la casilla de confirmación para continuar.');
                }

                // 3. Procesar la confirmación en la base de datos
                // Asegúrate de que la clase VehiculoData esté incluida
                // require_once 'models/VehiculoData.php'; // Ajusta la ruta si es necesario
                $objetoVehiculo = new VehiculoData();

                // Llamamos a un nuevo método para actualizar el estado de la entrega
                // ¡Este método debes crearlo en tu clase VehiculoData!
                $resultado = $objetoVehiculo->confirmarEntrega($loteId, $notas);
                $resultado = $objetoVehiculo->getFacturas($loteId);          
                $facturas =$resultado[0]->facturas;
                $resultado = $objetoVehiculo->updateFacturas($facturas);
                if ($resultado) {
                    // 4. Respuesta exitosa
                    echo json_encode([
                        'success' => true,
                        'message' => 'Entrega confirmada y registrada exitosamente.'
                    ]);
                } else {
                    // Si el método devuelve false, algo salió mal en la BD
                    throw new Exception('No se pudo actualizar el estado del lote en la base de datos.');
                }

            } catch (Exception $e) {
                // 5. Respuesta de error
                // Opcional: puedes enviar un código de estado HTTP de error
                // http_response_code(400); 
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            exit; // Terminamos la ejecución del script para no enviar más salida
        }


        if($datos=='5'){    
            // Establecemos el encabezado para devolver JSON
            header('Content-Type: application/json');
        
            try {
                // 1. Obtener los datos del POST request
                $loteId = $_POST['loteId'] ?? null;
                $notas = $_POST['notas'] ?? '';
                $confirmado = $_POST['confirmado'] ?? 0;
                $loteId = $loteId.'-1';
                // 2. Validar datos básicos
                if (empty($loteId)) {
                    throw new Exception('El ID del lote es requerido.');
                }
        
                if ($confirmado != 1) {
                    throw new Exception('Debe marcar la casilla de confirmación para continuar.');
                }
        
                // 3. Procesar la confirmación en la base de datos
                $objetoVehiculo = new VehiculoData();
                $resultado = $objetoVehiculo->confirmarEntrega($loteId, $notas);
                $resultado = $objetoVehiculo->getFacturas($loteId);          
                $facturas = $resultado[0]->facturas;
                $resultado = $objetoVehiculo->updateFacturas($facturas);
                
                if ($resultado) {
                    // 4. Respuesta exitosa
                    echo json_encode([
                        'success' => true,
                        'message' => 'Entrega confirmada y registrada exitosamente.'
                    ]);
                } else {
                    // Si el método devuelve false, algo salió mal en la BD
                    throw new Exception('No se pudo actualizar el estado del lote en la base de datos.');
                }
        
            } catch (Exception $e) {
                // 5. Respuesta de error
                http_response_code(400); 
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            exit;
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
                $result = $datos->getFacturasInventarioDespachos($filtro);
                break;
        }    
        header("Content-Type: application/json");
        echo json_encode($result);
        //var_dump($result);

        }


        if($datos=='2'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];

            $data = new $clase(); 
            $result=[]; 
            $filtro = $_GET['filtro'];   
            $filtro2 = $_GET['filtro2'];   
            $co_verificador = $_GET['co_verificador'];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $data->getFacturasInventarioDespachosAlmacen($filtro,$filtro2,$co_verificador);
                    break;        }    
            header("Content-Type: application/json");
            echo json_encode($result);       
        }        
            if($datos=='3'){

                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $verificador = $_GET['verificador'];          
                $data = new $clase(); 
                $result=[]; 
                $filtro = $_GET['filtro']; 
                $filtro2 = $_GET['filtro2'];     
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getFacturasVerificadas($filtro,$filtro2,$verificador);
                        break;
                }    
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
        
                }

        
        }
  
      if($accion == '3'){
        if($datos == '1'){
            $fact_num = $_POST['fact_num'];
            $motivo = $_POST['motivo'];
            
            $objeto_despacho = new FacturaData();
            $result = $objeto_despacho->devolverDespacho($fact_num, $motivo);
            
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }

    if($accion == 4){
        if($datos == 1){
            $fact_num = $_POST['fact_num'];
            $motivo = $_POST['motivo'];
            
            $objeto_despacho = new FacturaData();
            $result = $objeto_despacho->eliminarDespacho($fact_num, $motivo);
            
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }
      
   
}



?>