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

        if($accion==1){
            if($datos==1){       
                $tipo_precio = $_GET['precio'];
                $cliente_des = $_GET['cli_des'];         
                $facturacion = $_GET['facturacion'];
                $pago = $_GET['pago'];
                $_SESSION['tipo_precio'] =  trim($tipo_precio);
                $_SESSION['cliente_des']=   trim($cliente_des);
                $_SESSION['cliente_facturacion']=  trim($facturacion);
                $_SESSION['cliente_forma']=   trim($pago);         
                echo $_SESSION['cliente_des'];        
            }
        }  

        if($accion==2){
            if($datos==1){    
                if (is_array($_FILES)){
                    $f = new FuncionesData();
                    $llave = $f->radomCodigo();     
                    
                    
                    $co_cli =strtoupper($_GET['co_cli']);
                    $localizacion =$_GET['localizacion'];
                
                    $nombre=$co_cli.'-'.$llave;
                
                
                
                    if (($_FILES["file1"]["type"] == "image/png") || ($_FILES["file1"]["type"] == "image/jpeg") || ($_FILES["file1"]["type"] == "image/jpg")) {
                        if (move_uploaded_file($_FILES["file1"]["tmp_name"], "../admin/storage/perfil/local/".$nombre.$_FILES['file1']['name'])) {      

                            $archivo = "../admin/storage/perfil/local/".$nombre.$_FILES['file1']['name'];
                            $llave = $f->radomCodigo();     
                            rename($archivo, "../admin/storage/perfil/local/".$nombre.$llave.".jpg");  
                            $objeto = new ClienteData();                     
                            $objeto->co_cli =  $co_cli;
                            $objeto->localizacion =  $localizacion; 
                            $objeto->foto =  "../admin/storage/perfil/local/".$nombre.$llave.".jpg";                       
                            $objeto ->addLocalizacion();
                            echo "1";

                        
                        } else {
                            echo 0;  
                        }
                    } else {
                        echo 2;
                    }                
                

                } else {
                    echo 3;
                }
            }
        
            if($datos==2){         
                $user_objeto = new ClienteData();                
                $co_cli = $_POST['co_cli'];  
                $result = $user_objeto->getDataFiltrada($co_cli);
    
                if(count($result)==0){
                    
                    $cli_telefono = $_POST['cli_telefono'];              
                    $cli_parroquia = $_POST['cli_parroquia'];
                    $cli_sector = $_POST['cli_sector'];
                    $cli_email = $_POST['cli_email'];          
                
                    $user_objeto->telefonos =$cli_telefono;
                    $user_objeto->cli_parroquia =$cli_parroquia;
                    $user_objeto->cli_sector =$cli_sector;
                    $user_objeto->cli_email =$cli_email;
                    $user_objeto->co_cli =$co_cli;

                    $user_objeto->add_cliente();
                    echo "1";
                
                }else{

                    $cli_telefono = $_POST['cli_telefono'];              
                    $cli_parroquia = $_POST['cli_parroquia'];
                    $cli_sector = $_POST['cli_sector'];
                    $cli_email = $_POST['cli_email'];          
                
                    $user_objeto->telefonos =$cli_telefono;
                    $user_objeto->cli_parroquia =$cli_parroquia;
                    $user_objeto->cli_sector =$cli_sector;
                    $user_objeto->cli_email =$cli_email;
                    $user_objeto->co_cli =$co_cli;

                    $user_objeto->update_cliente();
                    echo "1";
                }        
            
            }

        }

        if($accion==3){      
            if($datos==1){   
                header('Content-Type: application/json'); 
                    // Inicializar respuesta
                $response = [
                    'success' => false,
                    'message' => '',
                    'errors' => []
                ];     
                try {
                    // Verificar método HTTP
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        throw new Exception('Método no permitido', 405);
                    }
                        $co_cli=$_POST['co_cli'];              
                        $cli_email=$_POST['cli_email']; 
                        $cli_telefono=$_POST['cli_telefono'];               
                        $cli_direccion_despacho=$_POST['cli_direccion_despacho'];               
                        $cli_parroquia=$_POST['cli_parroquia']; 
                        $cli_ciudad=$_POST['cli_ciudad']; 
                        $cli_responsable=$_POST['cli_responsable']; 
                        $cli_responsable_fecha=$_POST['cli_responsable_fecha']; 
                        $cli_aniversario_fecha=$_POST['cli_aniversario_fecha']; 
                        $cli_propietario_fecha=$_POST['cli_propietario_fecha']; 
                        $cli_responable_compras=$_POST['cli_responable_compras']; 
                        $cli_responsable_compras_fecha=$_POST['cli_responsable_compras_fecha']; 

                        $user_objeto = new ClienteData();
                        $user_objeto->co_cli =$co_cli;
                        $user_objeto->telefonos =$cli_telefono;
                        $user_objeto->email =$cli_email;
                        $user_objeto->dir_ent2 =$cli_direccion_despacho;
                        $user_objeto->respons =$cli_responsable;

                        $user_objeto->update_cliente();
                     //   $ref_ban=$pago['ref_ban'];
                        $objeto_funciones = new FuncionesData();
                        $data = $objeto_funciones->foundValor('jm_clientes','co_cli',$co_cli,'FuncionesData');
                        $bandera = $data[0]->id;
                        if($bandera>=1){
                            $co_ven =$_SESSION['identidad'];
                            $user_objeto->co_us_in =$co_ven; 
                            $user_objeto->id_parroquia =$cli_parroquia; 
                            $user_objeto->id_ciudad =$cli_ciudad; 
                            $user_objeto->responsable =$cli_responsable; 
                            $user_objeto->fechaNacimientoResponsable =$cli_responsable_fecha;
                            $user_objeto->empresaAniversario =$cli_aniversario_fecha;
                            $user_objeto->fechaNacimientoPropietario =$cli_propietario_fecha;
                            $user_objeto->responsableCompras =$cli_responable_compras;
                            $user_objeto->fechaNacimientoResponsableCompras =$cli_responsable_compras_fecha;
                            $user_objeto->update_cliente_jm_clientes();
                        }else{
                            $co_ven =$_SESSION['identidad'];
                            $user_objeto->co_us_in =$co_ven; 
                            $user_objeto->id_parroquia =$cli_parroquia; 
                            $user_objeto->id_ciudad =$cli_ciudad; 
                            $user_objeto->responsable =$cli_responsable; 
                            $user_objeto->fechaNacimientoResponsable =$cli_responsable_fecha;
                            $user_objeto->empresaAniversario =$cli_aniversario_fecha;
                            $user_objeto->fechaNacimientoPropietario =$cli_propietario_fecha;
                            $user_objeto->responsableCompras =$cli_responable_compras;
                            $user_objeto->fechaNacimientoResponsableCompras =$cli_responsable_compras_fecha;
                            $user_objeto->add_jm_cliente();

                        }


                        $response['success'] = true;
                        $response['message'] = 'Datos del cliente actualizados correctamente';
                    
                    } catch (Exception $e) {
                        http_response_code($e->getCode() ?: 500);
                        $response['message'] = $e->getMessage();
                        }
                        // Devolver respuesta JSON
                        echo json_encode($response);
                
                    
                }
        }

        if($accion==4){
            if($datos==1){ 
                    header('Content-Type: application/json'); 
                    
                    // Inicializar respuesta
                    $response = [
                        'success' => false,
                        'message' => '',
                        'errors' => []
                    ];
                    
                    try {
                                    // Verificar que sea una solicitud POST
                        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                            throw new Exception('Método no permitido');
                        }

                        // Obtener el código del cliente
                        $co_cli = $_POST['co_cli'] ?? '';
                        if (empty($co_cli)) {
                            throw new Exception('Código de cliente no proporcionado');
                        }

                        // Recopilar todos los datos de las preguntas
                        $respuestas = [];
                        
                        // Filtrar solo las claves que corresponden a preguntas (co_pregunta)
                        foreach ($_POST as $key => $value) {
                            // Ignorar campos que no son preguntas
                            if (in_array($key, ['co_cli', 'latitude', 'longitude', 'accuracy', 'timestamp'])) {
                                continue;
                            }
                            
                            // Las preguntas tienen códigos como P001, P002, etc.
                            if (preg_match('/^[A-Z]\d+$/', $key)) {
                                $respuestas[$key] = $value;
                            }
                        }
                            $ubicacion = [];
                            $ubicacion = [
                                    'latitude' => $_POST['latitude'] ?? '',
                                    'longitude' => $_POST['longitude'] ?? '',
                                    'accuracy' => $_POST['accuracy'] ?? '',
                                    'timestamp' => $_POST['timestamp'] ?? ''
                                ];

                                    
                            $encuestaObjeto = new EncuestaData();
                            $encuestaObjeto->co_cli = $co_cli;              
                            $fotoInfo = null;
                                if (isset($_FILES['fotoPuntoVenta']) && $_FILES['fotoPuntoVenta']['error'] === UPLOAD_ERR_OK) {
                                    $fotoInfo = $encuestaObjeto->procesarFoto($_FILES['fotoPuntoVenta'],$co_cli);

                                }

               // var_dump($respuestas);
                            $result = $encuestaObjeto->guardarVisitaCompleta($ubicacion,$fotoInfo,$respuestas);
                    
                echo json_encode([
                        'success' => true,
                        'message' => 'Encuesta procesada correctamente'
                    ]);
                        
                    } catch (Exception $e) {
                    // Respuesta de error
                    echo json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                        
                        // Si hay un error y se subió una imagen, intentar eliminarla
                        if (!empty($fotoNombre) && file_exists($uploadDir . $fotoNombre)) {
                            @unlink($uploadDir . $fotoNombre);
                        }
                    }
                    
    
            }

        }

        if($accion==5){      
            if($datos == 1){   
                header('Content-Type: application/json'); 
                
                // Inicializar respuesta
                $response = [
                    'success' => false,
                    'message' => '',
                    'errors' => []
                ];     
                
                try {
                    // Verificar método HTTP
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        throw new Exception('Método no permitido', 405);
                    }

                    // Validaciones básicas de campos obligatorios
                    $camposObligatorios = [
                        'cli_des' => 'Razón social',
                        'cli_rif' => 'RIF',
                        'contacto_des' => 'Persona de contacto',
                        'contacto_telefono' => 'Teléfono de contacto',
                        'contacto_des_recibe' => 'Quien lo recibió'
                    ];

                    $errors = [];
                    foreach ($camposObligatorios as $campo => $nombre) {
                        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                            $errors[] = "El campo {$nombre} es obligatorio";
                        }
                    }

                    if (!empty($errors)) {
                        $response['errors'] = $errors;
                        $response['message'] = 'Errores de validación en los datos enviados';
                        echo json_encode($response);
                        exit;
                    }

                    $co_cli = trim($_POST['cli_rif']);   
                    $objeto_funciones = new FuncionesData();
                    
                    // Verificar si el RIF existe en clientes
                    $data = $objeto_funciones->foundValor('clientes', 'rif', $co_cli, 'FuncionesData');
                    $bandera = $data[0]->id ?? 0;
                    
                    if($bandera >= 1){  
                        $response['error'] = true;
                        $response['message'] = 'El RIF del candidato que intenta registrar, se encuentra asignado a otro cliente, verifique e intente nuevamente.';
                    } else {
                        // Verificar si el RIF existe en candidatos
                        $data2 = $objeto_funciones->foundValor('jm_clientes_cand', 'rif', $co_cli, 'FuncionesData');
                        $bandera2 = $data2[0]->id ?? 0;
                        
                        if($bandera2 >= 1){  
                            $response['error'] = true;
                            $response['message'] = 'El RIF del candidato que intenta registrar, se encuentra asignado a otro candidato, verifique e intente nuevamente.';
                        } else {
                            // Obtener y sanitizar datos del formulario
                            $cli_des = isset($_POST['cli_des']) ? trim($_POST['cli_des']) : 'N/A';
                            $cli_rif = isset($_POST['cli_rif']) ? trim($_POST['cli_rif']) : 'N/A';
                            $cli_email = isset($_POST['cli_email']) ? trim($_POST['cli_email']) : 'N/A';
                            $cli_telefono = isset($_POST['cli_telefono']) ? trim($_POST['cli_telefono']) : 'N/A';
                            $contacto_des = isset($_POST['contacto_des']) ? trim($_POST['contacto_des']) : 'N/A';
                            $contacto_telefono = isset($_POST['contacto_telefono']) ? trim($_POST['contacto_telefono']) : 'N/A';
                            $cli_direccion = isset($_POST['cli_direccion']) ? trim($_POST['cli_direccion']) : 'N/A';
                            $cli_direccion_despacho = isset($_POST['cli_direccion_despacho']) ? trim($_POST['cli_direccion_despacho']) : 'N/A';
                            $cli_estado = isset($_POST['cli_estado']) ? trim($_POST['cli_estado']) : 'N/A';
                            $cli_municipio = isset($_POST['cli_municipio']) ? trim($_POST['cli_municipio']) : 'N/A';
                            $cli_parroquia = isset($_POST['cli_parroquia']) ? trim($_POST['cli_parroquia']) : 'N/A';
                            $cli_ciudad = isset($_POST['cli_ciudad']) ? trim($_POST['cli_ciudad']) : 'N/A';

                            
                            $cli_grupo = isset($_POST['cli_grupo']) ? trim($_POST['cli_grupo']) : 'N/A';
                            $cli_grupo_cantidad = isset($_POST['cli_grupo_cantidad']) ? trim($_POST['cli_grupo_cantidad']) : 'N/A';
                            $cli_estado_sucrusales = isset($_POST['cli_estado_sucrusales']) ? trim($_POST['cli_estado_sucrusales']) : 'N/A';
                            $cli_observacion = isset($_POST['cli_observacion']) ? trim($_POST['cli_observacion']) : 'N/A';

                            $contacto_des_recibe = isset($_POST['contacto_des_recibe']) ? trim($_POST['contacto_des_recibe']) : 'N/A';

                            
                            
                            
                            
                            

                            $lat = isset($_POST['lat']) && !empty(trim($_POST['lat'])) ? $_POST['lat'] : null;
                            $lon = isset($_POST['lon']) && !empty(trim($_POST['lon'])) ? $_POST['lon'] : null;
                            $acc = isset($_POST['acc']) && !empty(trim($_POST['acc'])) ? $_POST['acc'] : null;
                            $fecha = isset($_POST['fecha']) && !empty(trim($_POST['fecha'])) ? $_POST['fecha'] : null;

                            // Manejo de la foto del punto de venta
                            $foto_nombre = null;
                            $foto_ruta = null;
                                          

                                 
                            $encuestaObjeto = new EncuestaData();
                            $encuestaObjeto->co_cli = $cli_rif;              
                            $fotoInfo = null;
                                if (isset($_FILES['fotoPuntoVenta']) && $_FILES['fotoPuntoVenta']['error'] === UPLOAD_ERR_OK) {
                                    $fotoInfo = $encuestaObjeto->procesarFoto($_FILES['fotoPuntoVenta'],$cli_rif);
                                      $foto_nombre = $fotoInfo['nombre'];
                                    $foto_ruta = $fotoInfo['ruta'];

                                }

                        
                  

                   

                            // Crear objeto y asignar propiedades
                            $user_objeto = new ClienteData();
                            
                            // Información empresarial
                            $user_objeto->co_cli = strtoupper($cli_rif);
                            $user_objeto->tipo = '3';
                            $user_objeto->cli_des = strtoupper($cli_des);
                            $user_objeto->rif = strtoupper($cli_rif);
                            
                            // Información de contacto
                            $user_objeto->email = strtoupper($cli_email);
                            $user_objeto->telefonos = strtoupper($cli_telefono);
                            $user_objeto->contacto_des = strtoupper($contacto_des);
                            $user_objeto->contacto_telefono = strtoupper($contacto_telefono);


                            $user_objeto->cli_grupo = strtoupper($cli_grupo);
                            $user_objeto->cli_grupo_cantidad = strtoupper($cli_grupo_cantidad);
                            $user_objeto->cli_estado_sucrusales = strtoupper($cli_estado_sucrusales);
                            $user_objeto->cli_observacion = strtoupper($cli_observacion);

                            $user_objeto->contacto_des_recibe = strtoupper($contacto_des_recibe);

                            
                            // Direcciones
                            $user_objeto->direc1 = strtoupper($cli_direccion);
                            $user_objeto->direc2 = strtoupper($cli_direccion);
                            $user_objeto->dir_ent2 = strtoupper($cli_direccion_despacho);
                       
                            // Ubicación geográfica                         
                            $user_objeto->id_parroquia = $cli_parroquia;
                            $user_objeto->id_ciudad = $cli_ciudad;
                            
                            // Datos GPS
                            $user_objeto->lat = $lat;
                            $user_objeto->lon = $lon;
                          $user_objeto->fecha =$fecha;
                            
                            // Foto del punto de venta
                            $user_objeto->foto = $foto_ruta;
                          
                            // Guardar en la base de datos
                           $user_objeto->add_jm_cliente_cand();
         


                        $response['success'] = true;
                        $response['message'] = 'Datos del candidato guardados correctamente';


                        }
                    }
                } catch (Exception $e) {
                    http_response_code($e->getCode() ?: 500);
                    $response['message'] = $e->getMessage();
                    $response['error'] = true;
                }
                
                // Devolver respuesta JSON
                echo json_encode($response);
            }

             if($datos == 2){   
                header('Content-Type: application/json'); 
                
                // Inicializar respuesta
                $response = [
                    'success' => false,
                    'message' => '',
                    'errors' => []
                ];     
                
                try {
                    // Verificar método HTTP
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        throw new Exception('Método no permitido', 405);
                    }

                    // Validaciones básicas de campos obligatorios
                    $camposObligatorios = [                       
                        'contacto_des' => 'Persona de contacto',
                        'contacto_telefono' => 'Teléfono de contacto',
                        'cli_direccion' => 'Apreciación general de la visita',
                    ];

                    $errors = [];
                    foreach ($camposObligatorios as $campo => $nombre) {
                        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                            $errors[] = "El campo {$nombre} es obligatorio";
                        }
                    }

                    if (!empty($errors)) {
                        $response['errors'] = $errors;
                        $response['message'] = 'Errores de validación en los datos enviados';
                        echo json_encode($response);
                        exit;
                    }

                            $co_cli = trim($_POST['cli_rif']);   
              
                            $contacto_des = isset($_POST['contacto_des']) ? trim($_POST['contacto_des']) : 'N/A';
                            $contacto_telefono = isset($_POST['contacto_telefono']) ? trim($_POST['contacto_telefono']) : 'N/A';
                            $cli_direccion = isset($_POST['cli_direccion']) ? trim($_POST['cli_direccion']) : 'N/A';
                    
                            $lat = isset($_POST['lat']) && !empty(trim($_POST['lat'])) ? $_POST['lat'] : null;
                            $lon = isset($_POST['lon']) && !empty(trim($_POST['lon'])) ? $_POST['lon'] : null;
                            $acc = isset($_POST['acc']) && !empty(trim($_POST['acc'])) ? $_POST['acc'] : null;
                            $fecha = isset($_POST['fecha']) && !empty(trim($_POST['fecha'])) ? $_POST['fecha'] : null;

                            // Manejo de la foto del punto de venta
                            $foto_nombre = null;
                            $foto_ruta = null;
                                          
                                
                            $encuestaObjeto = new EncuestaData();
                            $encuestaObjeto->co_cli = $co_cli;              
                            $fotoInfo = null;
                                if (isset($_FILES['fotoPuntoVenta']) && $_FILES['fotoPuntoVenta']['error'] === UPLOAD_ERR_OK) {
                                    $fotoInfo = $encuestaObjeto->procesarFoto($_FILES['fotoPuntoVenta'],$co_cli);
                                      $foto_nombre = $fotoInfo['nombre'];
                                    $foto_ruta = $fotoInfo['ruta'];

                                }              
                                   

                            // Crear objeto y asignar propiedades
                            $user_objeto = new ClienteData();                            
                            // Información empresarial
                            $user_objeto->co_cli = strtoupper($co_cli);                           
                            $user_objeto->contacto_des = strtoupper($contacto_des);
                            $user_objeto->contacto_telefono = strtoupper($contacto_telefono);                            
                            // Direcciones
                            $user_objeto->observacion = strtoupper($cli_direccion);      
                            
                            // Datos GPS
                            $user_objeto->lat = $lat;
                            $user_objeto->lon = $lon;
                            $user_objeto->acc = $acc;
                            $user_objeto->fecha =$fecha;
                            
                            // Foto del punto de venta
                            $user_objeto->foto = $foto_ruta;
                          
                            // Guardar en la base de datos
                           $user_objeto->add_jm_cliente_cand_visita();
         


                        $response['success'] = true;
                        $response['message'] = 'Datos del candidato guardados correctamente';


                        
                    
                } catch (Exception $e) {
                    http_response_code($e->getCode() ?: 500);
                    $response['message'] = $e->getMessage();
                    $response['error'] = true;
                }
                
                // Devolver respuesta JSON
                echo json_encode($response);
            }
        }   




        if($accion==6){      
          
             if($datos == 2){   
                header('Content-Type: application/json'); 
                
                // Inicializar respuesta
                $response = [
                    'success' => false,
                    'message' => '',
                    'errors' => []
                ];     
                
                try {
                    // Verificar método HTTP
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        throw new Exception('Método no permitido', 405);
                    }

                    // Validaciones básicas de campos obligatorios
                    $camposObligatorios = [                       
                        'cli_recibe_visita' => 'Persona de contacto',
                        'cli_telefono_visita' => 'Teléfono de contacto',
                        'cli_observacion_visita' => 'Apreciación general de la visita',                   


                    ];

                    $errors = [];
                    foreach ($camposObligatorios as $campo => $nombre) {
                        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                            $errors[] = "El campo {$nombre} es obligatorio";
                        }
                    }

                    if (!empty($errors)) {
                        $response['errors'] = $errors;
                        $response['message'] = 'Errores de validación en los datos enviados';
                        echo json_encode($response);
                        exit;
                    }




                            $co_cli = trim($_POST['co_cli']);                
                            $cli_recibe_visita = isset($_POST['cli_recibe_visita']) ? trim($_POST['cli_recibe_visita']) : 'N/A';
                            $cli_telefono_visita = isset($_POST['cli_telefono_visita']) ? trim($_POST['cli_telefono_visita']) : 'N/A';
                            $cli_observacion_visita = isset($_POST['cli_observacion_visita']) ? trim($_POST['cli_observacion_visita']) : 'N/A';

                            
                    
                            $lat = isset($_POST['lat']) && !empty(trim($_POST['lat'])) ? $_POST['lat'] : null;
                            $lon = isset($_POST['lon']) && !empty(trim($_POST['lon'])) ? $_POST['lon'] : null;
                            $acc = isset($_POST['acc']) && !empty(trim($_POST['acc'])) ? $_POST['acc'] : null;
                            $fecha = isset($_POST['fecha']) && !empty(trim($_POST['fecha'])) ? $_POST['fecha'] : null;

                            // Manejo de la foto del punto de venta
                            $foto_nombre = null;
                            $foto_ruta = null;
                                          
                                
                            $encuestaObjeto = new EncuestaData();
                            $encuestaObjeto->co_cli = $co_cli;              
                            $fotoInfo = null;
                                if (isset($_FILES['fotoPuntoVenta']) && $_FILES['fotoPuntoVenta']['error'] === UPLOAD_ERR_OK) {
                                    $fotoInfo = $encuestaObjeto->procesarFoto($_FILES['fotoPuntoVenta'],$co_cli);
                                      $foto_nombre = $fotoInfo['nombre'];
                                    $foto_ruta = $fotoInfo['ruta'];

                                }              
                                   

                            // Crear objeto y asignar propiedades
                            $user_objeto = new ClienteData();                            
                            // Información empresarial


                            


                            $user_objeto->co_cli = strtoupper($co_cli);                           
                            $user_objeto->cli_recibe_visita = strtoupper($cli_recibe_visita);
                            $user_objeto->cli_telefono_visita = strtoupper($cli_telefono_visita);                            
                            // Direcciones
                            $user_objeto->cli_observacion_visita = strtoupper($cli_observacion_visita);      
                            
                            // Datos GPS
                            $user_objeto->lat = $lat;
                            $user_objeto->lon = $lon;
                            $user_objeto->acc = $acc;
                            $user_objeto->fecha =$fecha;
                            
                            // Foto del punto de venta
                            $user_objeto->foto = $foto_ruta;
                          
                            // Guardar en la base de datos
                           $user_objeto->add_jm_cliente_visita();
         


                        $response['success'] = true;
                        $response['message'] = 'Datos del candidato guardados correctamente';


                        
                    
                } catch (Exception $e) {
                    http_response_code($e->getCode() ?: 500);
                    $response['message'] = $e->getMessage();
                    $response['error'] = true;
                }
                
                // Devolver respuesta JSON
                echo json_encode($response);
            }
        }   



        if($accion==9){
            if($datos==1){       
          
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $filtro=  $_GET['filtro'];
                $datos = new $clase(); 
                $result=[];
                
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getDatosClientes($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
             
            }
          

         
        }  

        if($accion==10){
            if($datos==1){       
          
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $filtro='co_ven';
                $result=[];
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getAllDatosSimplesCandidatos($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
             
            }

             if($datos==2){       
          
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $result=[];
                $filtro =$_GET['filtro'];
                ///$filtro= '10';
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getAllDatosSimplesCandidatos($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
             
            }
          

         
        } 

        if($accion==11){
            if($datos==1){       
          
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $filtro='co_ven';
                $result=[];
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getAllDatosSimplesClientes($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
             
            }

             if($datos==2){       
          
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $result=[];
                $filtro =$_GET['filtro'];
                ///$filtro= '10';
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getAllDatosSimplesClientes($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
             
            }
          

         
        } 



        
        if($accion==99){
            if($datos==1){       
                //echo "entro";
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                    $calendars=$_GET['calendars'];
                $result=[];
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getDataVisitasPlanificacion($calendars);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
             
            }

       
          

         
        } 


        if($accion==98){          
            if($datos == 1){   
                header('Content-Type: application/json'); 
                
                // Inicializar respuesta
                $response = [
                    'success' => false,
                    'message' => '',
                    'id' => null 
                ];     
                
                try {
                    // Verificar método HTTP
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        throw new Exception('Método no permitido', 405);
                    }

                    // --- NUEVA VALIDACIÓN: Validar los datos dinámicos según el tipo ---
                    $tipo = isset($_POST['tipo_v']) ? trim($_POST['tipo_v']) : null;

                    if ($tipo == '1') { // Validación para Clientes
                        if (!isset($_POST['clientes']) || !is_array($_POST['clientes']) || empty($_POST['clientes'])) {
                            $errors[] = "Debe seleccionar al menos un cliente.";
                        }
                    } elseif ($tipo == '2') { // Validación para Candidatos
                        if (!isset($_POST['candidatos']) || !is_array($_POST['candidatos']) || 
                            !isset($_POST['candidatos'][0]['cantidad']) || empty(trim($_POST['candidatos'][0]['cantidad']))) {
                            $errors[] = "Debe ingresar una cantidad válida de candidatos.";
                        }
                    } else {
                        $errors[] = "El tipo de evento seleccionado no es válido.";
                    }

                    if (!empty($errors)) {
                        $response['message'] = 'Errores de validación: ' . implode(', ', $errors);
                        echo json_encode($response);
                        exit;
                    }

                    // --- CAMBIO: Recibir y procesar los datos dinámicos ---
                    $inicio = trim($_POST['inicio']);
                    $descripcion_larga = trim($_POST['descripcion']);
                    
                    $fin = isset($_POST['fin']) ? trim($_POST['fin']) : $inicio; 
                    $estatus = '1'; // Valor por defecto
                    
                    // Variable para almacenar la información extra (clientes o cantidad)
                    $dato_extra1 = ''; 
                    $dato_extra2 = ''; // <-- NUEVA VARIABLE para los códigos
                    $descripcion = '';
                    if ($tipo == '1') { // Procesar Clientes
                        // El array de clientes viene en $_POST['clientes']
                        // Ejemplo: [ ["id" => "CLI-001"], ["id" => "USER-456"] ]
                        $clientes_array = $_POST['clientes'];
                        
                        // Extraer solo los IDs, tratándolos como texto y limpiándolos
                        $clientes_ids = array_map(function($c) {
                            if (isset($c['id'])) {
                                // Elimina espacios en blanco al inicio y al final del ID
                                $id = trim($c['id']);
                                // Devuelve el ID si no está vacío, de lo contrario devuelve null
                                return ($id !== '') ? $id : null;
                            }
                            // Si no existe la clave 'id', devuelve null
                            return null;
                        }, $clientes_array);
                        
                        // Filtra los valores nulos o vacíos que pudieron generarse.
                        // array_filter() sin una función de callback elimina automáticamente
                        // los valores considerados "falsos" (como null, '', 0, false).
                        $clientes_ids = array_filter($clientes_ids);

                        // Verificar si después de filtrar aún quedan IDs válidos
                        if (!empty($clientes_ids)) {
                            // Concatenar los IDs con un asterisco (*)
                            $dato_extra1 = implode('/', $clientes_ids);
                            
                            // Generar la descripción
                            $descripcion = 'Visita a: ' . count($clientes_ids) . ' cliente(s).';
                        } else {
                            // Si no hay IDs válidos después del filtrado, es un error.
                            throw new Exception('No se proporcionaron IDs de clientes válidos.');
                        }
                    } elseif ($tipo == '2') { // Procesar Candidatos
                        // La cantidad viene en $_POST['candidatos'][0]['cantidad']
                        $cantidad = trim($_POST['candidatos'][0]['cantidad']);
                        
                        if (is_numeric($cantidad) && $cantidad > 0) {
                            $dato_extra1 = $cantidad;
                            // Generar la descripción
                            $descripcion = 'Visita a: ' . $cantidad . ' candidato(s).';
                        } else {
                            throw new Exception('La cantidad de candidatos debe ser un número mayor a cero.');
                        }
                    }

                    // --- Usar el objeto y método correctos para guardar un evento ---
                    $evento_objeto = new ClienteData();

                    // Asignar propiedades al objeto
                    $evento_objeto->descripcion = strtoupper($descripcion);
                    $evento_objeto->inicio = $inicio;
                    $evento_objeto->fin = $fin;
                    $evento_objeto->tipo = $tipo;
                    $evento_objeto->estatus = $estatus;
                    $evento_objeto->dato_extra1 = $dato_extra1;
                    $evento_objeto->dato_extra2 = $dato_extra2;
                    $evento_objeto->dato_extra3 = $descripcion_larga; // <-- NUEVA ASIGNACIÓN
                    
                    // Guardar en la base de datos y obtener el ID
                    $new_event_id = $evento_objeto->add_evento_calendario();

                    if ($new_event_id) {
                        $response['success'] = true;
                        $response['message'] = 'Evento guardado correctamente';
                        $response['id'] = $new_event_id;
                    } else {
                        $response['message'] = 'Error al guardar el evento en la base de datos.';
                    }

                } catch (Exception $e) {
                    http_response_code($e->getCode() ?: 500);
                    $response['message'] = $e->getMessage();
                    $response['error'] = true;
                }
                
                // Devolver respuesta JSON
                echo json_encode($response);
            }
        }


        // ========================================
        // ENDPOINT PARA CARGAR ESTADOS DE VISITA
        // ========================================
        if($accion==102){
            if($datos==1){       
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $result=[];
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getEstadosVisita();
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
            }
        }

            // ========================================
        // ENDPOINT PARA OBTENER VISITAS POR DÍA
        // ========================================
        if($accion==103){
            if($datos==1){       
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $datos = new $clase(); 
                $result=[];
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $fecha = $_GET['fecha'];
                        $co_ven = $_GET['co_ven'];
                        $result = $datos->getVisitasPorDia($fecha, $co_ven);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
            }
        }

         if($accion=='getSaldosClientes'){
            if($datos==1){       
                $clase =$_GET['c'];
                $tabla = $_GET['t'];
                $sucursales = $_GET['ss'];
                $rifs = $_GET['rifs'];
                $datos = new $clase(); 
                $result=[];
                
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                     
                        $result = $datos->getSaldosClientes($sucursales,$rifs);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
            }
        }

           
        if($accion=='getFacturasCliente'){
            
            $clase =$_GET['c'];
            $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result=[];  
            $co_cli = $_GET['co_cli']; // CLIENTE
            $filtro = $_GET['filtro']; // ANULADAS O NO ANULADAS       
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->geDatatFacturasCliente($co_cli,$filtro);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        }
}
?>