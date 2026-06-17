<?php
class VehiculoData {
    public static $tablename = "jm_despacho_vehiculo";
    public static $tablename_carga = "jm_despacho_carga"; // Tabla para el encabezado de la carga
    public static $tablename_lotes = "jm_despacho_lotes"; // Tabla para los lotes de la carga
    public static $tablename_ruta = "jm_despacho_ruta"; // Tabla para la ruta
    
    // Atributos existentes
    public $id_empaquetado;
    public $numero_paquete;
    public $facturas;
    public $codigo_cliente;
    public $fecha_despacho;
    public $qr_data;
    public $id;
    
    // Nuevos atributos para el sistema de carga
    public $carga_id;
    public $vehiculo;
    public $chofer_id;
    public $ayudante_id;
    public $zona_id;
    public $total_paquetes;
    public $fecha_carga;
    public $lote_id;
    public $loteID;
    public $cantidad_paquetes;
    
    // Atributos para información general
    public $codigo;
    public $vehiculo_nombre;
    public $chofer_nombre;
    public $ayudante_nombre;
    public $zona_nombre;
    public $zona_descripcion;
    public $estatus;
    public $co_cli;
    public $cli_des;
    public $descripcion;
    public $fecha_entrega;
    public $observaciones;
    public $responsive_id;
    
    // Atributos para indicadores
    public $dato1;
    public $dato2;
    public $dato3;
    public $dato4;
    public $emitidas;
    public $verificadas;
    public $tipo_transporte;
    public $paquetes_entregados;
    public $lotes_entregados;
    public $lotes_totales;
    public $renglones;
    
    public function add() {
        // Obtener el ID del usuario de la sesión
        $co_ven = $_SESSION['identidad'];
        
        // Construir la consulta SQL
        $sql = "INSERT INTO ".self::$tablename." (co_lote, numero_paquete, facturas, co_cli, fecha_despacho, qr_data, co_ven,estatus) ";
        $sql .= "VALUES ('$this->loteId','$this->numero_paquete','$this->facturas','$this->codigo_cliente','$this->fecha_despacho','$this->qr_data','$co_ven',1)";
       
        // Ejecutar la consulta
        Executor::doitEx($sql);
        
        return true;
    }

    public function registrarCarga($encabezado, $fecha_carga,$codigo) {
        try {
            // Obtener el ID del usuario de la sesión
            $co_ven = $_SESSION['identidad'];
            
            // Preparar los datos para la inserción
            $vehiculo = $encabezado['vehiculo'];
            $chofer_id = $encabezado['chofer_id'];
            $ayudante_id = $encabezado['ayudante_id'] ?? null;
            $zona_id = $encabezado['zona_id'];
            $total_paquetes = $encabezado['total_paquetes'];
            $zona_descripcion = $encabezado['zona_descripcion'];
            
            // Construir la consulta SQL
            $sql = "INSERT INTO ".self::$tablename_carga." (vehiculo, chofer_id, ayudante_id, zona_id, total_paquetes, fecha_carga, co_ven, estatus,codigo,dato_extra1) ";
            $sql .= "VALUES ('$vehiculo','$chofer_id','$ayudante_id','$zona_id','$total_paquetes','$fecha_carga','$co_ven',1,'$codigo','$zona_descripcion')";
            
            // Ejecutar la consulta
            Executor::doitEx($sql);
            
            return ['success' => true, 'message' => 'Encabezado de carga registrado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al registrar encabezado: ' . $e->getMessage()];
        }
    }
    
    public function registrarLotesEnCarga($lotes, $codigo) {
        try {
            $errores = [];
            $i = 1;
            foreach ($lotes as $lote) {
                $lote_id = $lote['id'];
                $loteID = $lote['loteID'];
                $cantidad_paquetes = $lote['cantidad_paquetes'];
                
                // Construir la consulta SQL para cada lote
                $sql = "INSERT INTO ".self::$tablename_lotes." (carga_id, lote_id, loteID, cantidad_paquetes,codigo) ";
                $sql .= "VALUES ('$codigo','$lote_id','$loteID','$cantidad_paquetes','$codigo')";
                $result = Executor::doitEx($sql);

                // Actualizar paquetes
                $sql = "UPDATE jm_paquetes_reg SET dato_extra1 = '1' WHERE co_lote = '$loteID'";
                $result = Executor::doitEx($sql);
                
                $i++;
            }
           
        } catch (Exception $e) {
            // Manejo de errores
        }
    }
  
    public static function getAllDatosPaquetes($filtro) {
        $sql ="SELECT TOP 1 pr.id, pr.co_lote, pr.numero_paquete, pr.facturas, pr.co_cli, pr.fecha_despacho, pr.qr_data, pr.estatus, pr.co_ven, c.cli_des 
        FROM jm_paquetes_reg pr 
        INNER JOIN clientes c ON c.co_cli = pr.co_cli
        WHERE pr.estatus = 1 AND pr.co_lote IN ('$filtro')  
        ORDER BY pr.id DESC;";		
            
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->responsive_id = "";  
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_lote = trim($r['co_lote']);
                $array[$cnt]->numero_paquete = trim($r['numero_paquete']);	
                $array[$cnt]->facturas = trim($r['facturas']);	
                $array[$cnt]->co_cli = trim($r['co_cli']);	
                $array[$cnt]->cli_des = trim($r['cli_des']);	
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    public static function getAllDatosPaquetesChofer($filtro) {
        // Procesar el filtro
        $filtro_limpio = str_replace("'", "", $filtro);
        $lotes_array = explode(',', $filtro_limpio);
        
        $lotes_procesados = [];
        foreach ($lotes_array as $lote) {
            $last_dash_pos = strrpos($lote, '-');
            if ($last_dash_pos !== false) {
                $lotes_procesados[] = substr($lote, 0, $last_dash_pos);
            } else {
                $lotes_procesados[] = $lote;
            }
        }
        
        $filtro_final = "'" . implode("','", $lotes_procesados) . "'";
        
        // Verificar si el lote ya fue confirmado
        $estatus_confirmado = 2; 
        
        $sql_check = "SELECT COUNT(*) as confirmed_count 
                      FROM jm_paquetes 
                      WHERE estatus = {$estatus_confirmado} AND co_lote IN ({$filtro_final})";
                                
        $query_check = Executor::doitAr($sql_check);
        $is_confirmed = isset($query_check[0]) && $query_check[0]['confirmed_count'] > 0;
    
        if ($is_confirmed) {
            return [
                'success' => false,
                'error_code' => 'ALREADY_CONFIRMED',
                'message' => 'Este lote ya fue confirmado para entrega.',
                'data' => []
            ];
        }
    
        // Consultar paquetes activos
        $sql = "SELECT TOP 1 pr.id, pr.co_lote, pr.numero_paquete, pr.facturas, pr.co_cli, pr.fecha_despacho, pr.qr_data, pr.estatus, pr.co_ven, c.cli_des 
                FROM jm_paquetes_reg pr 
                INNER JOIN clientes c ON c.co_cli = pr.co_cli
                WHERE pr.estatus = 1 AND pr.co_lote IN ({$filtro_final})  
                ORDER BY pr.id DESC;";		
                                
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->responsive_id = "";  
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_lote = trim($r['co_lote']);
                $array[$cnt]->numero_paquete = trim($r['numero_paquete']);
                    
                // Procesar facturas
                $facturas_raw = trim($r['facturas']);
                $facturas_procesadas = '';
                if (!empty($facturas_raw)) {
                    $facturas_array = json_decode($facturas_raw);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($facturas_array)) {
                        $facturas_procesadas = implode(', ', $facturas_array);
                    } else {
                        $facturas_procesadas = $facturas_raw;
                    }
                }
                $array[$cnt]->facturas = $facturas_procesadas;
    
                $array[$cnt]->co_cli = trim($r['co_cli']);	
                $array[$cnt]->cli_des = trim($r['cli_des']);	
                $cnt++;
            }
            
            return [
                'success' => true,
                'data' => $array
            ];
    
        } else {
            return [
                'success' => false,
                'error_code' => 'NOT_FOUND',
                'message' => 'No se encontraron paquetes activos para este lote.',
                'data' => []
            ];
        }
    }

    public static function getAllDatosPaquetesChoferApp($filtro, $user_id, $lat, $lng) {
        // Inicializar respuesta estándar
        $response = [
            'success' => false,
            'message' => '',
            'data' => [],
            'metadata' => [
                'user_id' => $user_id,
                'filtro_original' => $filtro,
                'timestamp' => date('Y-m-d H:i:s'),
                'location' => $lat && $lng ? ['lat' => $lat, 'lng' => $lng] : null
            ]
        ];
        
        try {
            // Validación inicial
            if (empty($filtro) || empty($user_id) || $user_id == '0') {
                $response['message'] = 'Parámetros incompletos';
                return $response;
            }
            
            // Procesar filtro
            $filtro_limpio = preg_replace('/[^a-zA-Z0-9,\-]/', '', $filtro);
            
            if (empty($filtro_limpio)) {
                $response['message'] = 'Filtro inválido';
                return $response;
            }
            
            // Convertir a array y procesar
            $lotes_array = explode(',', $filtro_limpio);
            $lotes_procesados = [];
            
            foreach ($lotes_array as $lote) {
                $lote = trim($lote);
                if (!empty($lote)) {
                    $last_dash_pos = strrpos($lote, '-');
                    $lotes_procesados[] = $last_dash_pos !== false 
                        ? substr($lote, 0, $last_dash_pos)
                        : $lote;
                }
            }
            
            if (empty($lotes_procesados)) {
                $response['message'] = 'No se encontraron lotes válidos en el filtro';
                return $response;
            }
            
            // Verificar si el lote ya fue confirmado
            $estatus_confirmado = 2;
            
            $lotes_escaped = [];
            foreach ($lotes_procesados as $lote) {
                $lotes_escaped[] = "'" . addslashes($lote) . "'";
            }
            $filtro_sql = implode(',', $lotes_escaped);
            
            $sql_check = "SELECT COUNT(*) as confirmed_count 
                          FROM jm_paquetes 
                          WHERE estatus = {$estatus_confirmado} 
                          AND co_lote IN ({$filtro_sql})";
            
            $query_check = Executor::doitAr($sql_check);
            
            if ($query_check && isset($query_check[0]['confirmed_count']) 
                && $query_check[0]['confirmed_count'] > 0) {
                
                $response['success'] = false;
                $response['error_code'] = 'ALREADY_CONFIRMED';
                $response['message'] = 'Uno o más lotes ya fueron confirmados para entrega';
                return $response;
            }
            
            // Consultar paquetes activos
            $user_id_clean = addslashes(trim($user_id));
         
            $sql = "SELECT TOP 1 
                        pr.id, 
                        pr.co_lote, 
                        pr.numero_paquete, 
                        pr.facturas, 
                        pr.co_cli, 
                        pr.fecha_despacho, 
                        pr.qr_data, 
                        pr.estatus, 
                        pr.co_ven, 
                        c.cli_des 
                    FROM jm_paquetes_reg pr 
                    INNER JOIN jm_despacho_lotes dl on dl.loteID = pr.co_lote
                    INNER JOIN jm_despacho_carga dc on dc.codigo = dl.carga_id
                    INNER JOIN clientes c ON c.co_cli = pr.co_cli
                    WHERE pr.estatus = 1 
                        AND dc.chofer_id ='{$user_id_clean}'
                        AND pr.co_lote IN ({$filtro_sql})
                    ORDER BY pr.id DESC";
            
            $query = Executor::doitAr($sql);
            
            if ($query && count($query) >= 1) {
                $paquetes = [];
                
                foreach ($query as $r) {
                    $paquete = [
                        'id' => $r['id'],
                        'co_lote' => $r['co_lote'],
                        'numero_paquete' => $r['numero_paquete'],
                        'co_cli' => $r['co_cli'],
                        'cli_des' => $r['cli_des'],
                        'fecha_despacho' => $r['fecha_despacho'],
                        'qr_data' => $r['qr_data'],
                        'estatus' => $r['estatus'],
                        'co_ven' => $r['co_ven']
                    ];
                    
                    // Procesar facturas (JSON o texto)
                    $facturas_raw = trim($r['facturas']);
                    if (!empty($facturas_raw)) {
                        $facturas_array = json_decode($facturas_raw, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($facturas_array)) {
                            $paquete['facturas'] = $facturas_array;
                            $paquete['facturas_texto'] = implode(', ', $facturas_array);
                        } else {
                            $paquete['facturas'] = [$facturas_raw];
                            $paquete['facturas_texto'] = $facturas_raw;
                        }
                    } else {
                        $paquete['facturas'] = [];
                        $paquete['facturas_texto'] = '';
                    }
                    
                    $paquetes[] = $paquete;
                }
                
                $response['success'] = true;
                $response['message'] = 'Paquetes encontrados';
                $response['data'] = [
                    'paquetes' => $paquetes,
                    'total' => count($paquetes),
                    'lotes_buscados' => $lotes_procesados
                ];
                
            } else {
                $response['success'] = false;
                $response['error_code'] = 'NO_ACTIVE_PACKAGES';
                $response['message'] = 'No se encontraron paquetes activos para los lotes especificados';
            }
            
        } catch (Exception $e) {
            $response['message'] = 'Error interno al procesar la solicitud';
            error_log("Error en getAllDatosPaquetesChoferApp: " . $e->getMessage());
        }
        
        return $response;
    }

    public static function getAllCargas() {
        $sql = "SELECT TOP 100 PERCENT c.id as carga_id, c.vehiculo, c.chofer_id, c.ayudante_id, c.zona_id, c.total_paquetes, c.fecha_carga, c.estatus,
                v.vehiculo_des as vehiculo_nombre, ch.persona_des as chofer_nombre, ay.persona_des as ayudante_nombre, c.dato_extra1 as zona_nombre
                FROM ".self::$tablename_carga." c
                LEFT JOIN vehiculos v ON c.vehiculo = v.co_vehiculo
                LEFT JOIN choferes ch ON c.chofer_id = ch.co_ven
                LEFT JOIN choferes ay ON c.ayudante_id = ay.co_ven
                ORDER BY c.id DESC";
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->carga_id = $r['carga_id'];
                $array[$cnt]->vehiculo = $r['vehiculo'];
                $array[$cnt]->vehiculo_nombre = $r['vehiculo_nombre'];
                $array[$cnt]->chofer_id = $r['chofer_id'];
                $array[$cnt]->chofer_nombre = $r['chofer_nombre'];
                $array[$cnt]->ayudante_id = $r['ayudante_id'];
                $array[$cnt]->ayudante_nombre = $r['ayudante_nombre'];
                $array[$cnt]->zona_id = $r['zona_id'];
                $array[$cnt]->zona_nombre = $r['zona_nombre'];
                $array[$cnt]->total_paquetes = $r['total_paquetes'];
                $array[$cnt]->fecha_carga = $r['fecha_carga'];
                $array[$cnt]->estatus = $r['estatus'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    public static function getLotesByCargaId($carga_id) {
        $sql = "SELECT l.id, l.carga_id, l.lote_id, l.loteID, l.cantidad_paquetes,
                pr.facturas, pr.co_cli, c.cli_des
                FROM ".self::$tablename_lotes." l
                LEFT JOIN jm_paquetes_reg pr ON l.lote_id = pr.id
                LEFT JOIN clientes c ON pr.co_cli = c.co_cli
                WHERE l.carga_id = '$carga_id'";
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->carga_id = $r['carga_id'];
                $array[$cnt]->lote_id = $r['lote_id'];
                $array[$cnt]->loteID = $r['loteID'];
                $array[$cnt]->cantidad_paquetes = $r['cantidad_paquetes'];
                $array[$cnt]->facturas = $r['facturas'];
                $array[$cnt]->co_cli = $r['co_cli'];
                $array[$cnt]->cli_des = $r['cli_des'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    public static function getEmbarquesInventarioAlmacen($filtro,$filtro2) {
        $sql = "";

        if ($filtro == 'NO') {
            $hoy = getdate();
            $mes = $hoy['mon'];
            $anio = $hoy['year'];
            $mes2 = $mes-1;
            $sql = "SELECT c.codigo as codigo,
                c.id,
                c.id as carga_id,
                c.vehiculo,
                v.placa as vehiculo_nombre,
                c.chofer_id,
                p.persona_des as chofer_nombre,
                c.ayudante_id as ayudante_nombre,
                ch.rol,
                c.zona_id,
                c.dato_extra1 as zona_nombre,
                c.total_paquetes,
                c.fecha_carga,
                c.estatus,
                v.dato_extra3 as tipo_transporte
            FROM jm_despacho_carga c
            INNER JOIN jm_vehiculos v ON c.vehiculo = v.placa
            INNER JOIN jm_users ch ON c.chofer_id = ch.co_ven
            INNER JOIN jm_personas p ON ch.co_ven = p.co_ocupa     
            WHERE (MONTH(c.fecha_carga) = '$mes2'  or MONTH(c.fecha_carga) = '$mes')
            AND YEAR(c.fecha_carga) = '$anio'
            AND ch.rol = '6'      
            ORDER BY c.fecha_carga DESC";    
        }else{
            $sql = "SELECT c.codigo as codigo,
                c.id,
                c.id as carga_id,
                c.vehiculo,
                v.placa as vehiculo_nombre,
                c.chofer_id,
                p.persona_des as chofer_nombre,
                c.ayudante_id as ayudante_nombre,
                ch.rol,
                c.zona_id,
                c.dato_extra1 as zona_nombre,
                c.total_paquetes,
                c.fecha_carga,
                c.estatus,
                v.dato_extra3 as tipo_transporte
            FROM jm_despacho_carga c
            INNER JOIN jm_vehiculos v ON c.vehiculo = v.placa
            INNER JOIN jm_users ch ON c.chofer_id = ch.co_ven
            INNER JOIN jm_personas p ON ch.co_ven = p.co_ocupa     
            WHERE c.fecha_carga BETWEEN '$filtro 00:00:00' AND '$filtro2 23:59:59'
            AND ch.rol = '6'      
            ORDER BY c.fecha_carga DESC";    
        }
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		

        if ($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach ($query as $r) {				
                $array[$cnt] = new VehiculoData(); 
                $objeto_entregas = new PaqueteData();
                $data_entregas = $objeto_entregas->getLotesPorCarga($r['codigo']);
                $data_entregasxcliente = $objeto_entregas->getLotesPorCLiente($r['codigo']);
                
                $array[$cnt]->responsive_id = "";
                $array[$cnt]->carga_id = trim($r['carga_id']);
                $array[$cnt]->vehiculo = trim($r['vehiculo']);
                $array[$cnt]->tipo_transporte = trim($r['tipo_transporte']);
                $array[$cnt]->vehiculo_nombre = trim($r['vehiculo_nombre']);
                $array[$cnt]->chofer_id = trim($r['chofer_id']);
                $array[$cnt]->chofer_nombre = trim($r['chofer_nombre']);
                $array[$cnt]->ayudante_id = trim($r['ayudante_nombre']);
                $array[$cnt]->ayudante_nombre = trim($r['ayudante_nombre']); 
                $array[$cnt]->zona_id = trim($r['zona_id']);
                $array[$cnt]->zona_nombre = trim($r['zona_nombre']); 
                $array[$cnt]->total_paquetes = trim($r['total_paquetes']);
                $array[$cnt]->paquetes_entregados =  $data_entregas[0]->cantidad;
                $array[$cnt]->lotes_entregados =  $data_entregasxcliente[0]->lotes_verificados;
                $array[$cnt]->lotes_totales =  $data_entregasxcliente[0]->cantidad;
                $array[$cnt]->fecha_carga = trim($r['fecha_carga']);
                $array[$cnt]->estatus = trim($r['estatus']);
                
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    public static function getEmbarquesPorChofer($co_chofer) {
        $sql = "SELECT c.codigo as codigo,
            c.id,
            c.id as carga_id,
            c.vehiculo,
            v.placa as vehiculo_nombre,
            c.chofer_id,
            p.persona_des as chofer_nombre,
            c.ayudante_id as ayudante_nombre,
            ch.rol,
            c.zona_id,
            c.dato_extra1 as zona_nombre,
            c.total_paquetes,
            c.fecha_carga,
            c.estatus,
            v.dato_extra3 as tipo_transporte
        FROM jm_despacho_carga c
        INNER JOIN jm_vehiculos v ON c.vehiculo = v.placa
        INNER JOIN jm_users ch ON c.chofer_id = ch.co_ven
        INNER JOIN jm_personas p ON ch.co_ven = p.co_ocupa     
        WHERE c.chofer_id = '$co_chofer'
        AND ch.rol = '6'      
        ORDER BY c.fecha_carga DESC";    
     
        $query = Executor::doitAr($sql);	
        $e = count($query);		

        if ($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach ($query as $r) {				
                $array[$cnt] = new VehiculoData(); 
                $objeto_entregas = new PaqueteData();
                $data_entregas = $objeto_entregas->getLotesPorCarga($r['codigo']);
                $data_entregasxcliente = $objeto_entregas->getLotesPorCLiente($r['codigo']);
                
                $array[$cnt]->responsive_id = "";
                $array[$cnt]->carga_id = trim($r['carga_id']);
                $array[$cnt]->vehiculo = trim($r['vehiculo']);
                $array[$cnt]->tipo_transporte = trim($r['tipo_transporte']);
                $array[$cnt]->vehiculo_nombre = trim($r['vehiculo_nombre']);
                $array[$cnt]->chofer_id = trim($r['chofer_id']);
                $array[$cnt]->chofer_nombre = trim($r['chofer_nombre']);
                $array[$cnt]->ayudante_id = trim($r['ayudante_nombre']);
                $array[$cnt]->ayudante_nombre = trim($r['ayudante_nombre']); 
                $array[$cnt]->zona_id = trim($r['zona_id']);
                $array[$cnt]->zona_nombre = trim($r['zona_nombre']); 
                $array[$cnt]->total_paquetes = trim($r['total_paquetes']);
                $array[$cnt]->paquetes_entregados =  $data_entregas[0]->cantidad;
                $array[$cnt]->lotes_entregados =  $data_entregasxcliente[0]->lotes_verificados;
                $array[$cnt]->lotes_totales =  $data_entregasxcliente[0]->cantidad;
                $array[$cnt]->fecha_carga = trim($r['fecha_carga']);
                $array[$cnt]->estatus = trim($r['estatus']);
                
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    public static function getLotes($filtro,$codigo) {
        $sql = "";

        if ($filtro == 'NO') {
            $hoy = getdate();
            $mes = $hoy['mon'];
            $anio = $hoy['year'];

            $sql = "SELECT c.codigo as codigo,
                c.id,
                c.id as carga_id,
                c.vehiculo,
                v.placa as vehiculo_nombre,
                c.chofer_id,
                p.persona_des as chofer_nombre,
                c.ayudante_id as ayudante_nombre,
                ch.rol,
                c.zona_id,
                z.zon_des as zona_nombre,
                c.total_paquetes,
                c.fecha_carga,
                c.estatus
            FROM jm_despacho_carga c
            INNER JOIN jm_vehiculos v ON c.vehiculo = v.placa
            INNER JOIN jm_users ch ON c.chofer_id = ch.co_ven
            INNER JOIN jm_personas p ON ch.co_ven = p.co_ocupa
            INNER JOIN zona z ON c.zona_id = z.co_zon
            WHERE MONTH(c.fecha_carga) = '$mes' 
            AND YEAR(c.fecha_carga) = '$anio'
            AND ch.rol = '6'
            AND z.zon_des <> 'NO APLICA'
            AND c.codigo = '$codigo'
            ORDER BY c.fecha_carga DESC";
        } else {
            $partes = explode('/', $filtro);
            $fecha_inicio = $partes[0];
            $fecha_fin = $partes[1];
            $co_chofer = isset($partes[2]) ? $partes[2] : 'NO';

            $chofer_filter = "";
            if ($co_chofer !== 'NO' && !empty($co_chofer)) {
                $chofer_filter = " AND c.chofer_id = '$co_chofer' ";
            }

            $sql = "SELECT 
                    c.id as carga_id,
                    c.vehiculo,
                    v.placa as vehiculo_nombre,
                    c.chofer_id,
                    p.persona_des as chofer_nombre,
                    c.ayudante_id,
                    ISNULL(c.ayudante_id, 'N/A') as ayudante_nombre,
                    c.zona_id,
                    ISNULL(z.zon_des, 'N/A') as zona_nombre,
                    c.total_paquetes,
                    c.fecha_carga,
                    c.estatus
                FROM jm_despacho_carga c
                INNER JOIN jm_vehiculos v ON c.vehiculo = v.placa
                INNER JOIN jm_users ch ON c.chofer_id = ch.co_ven
                INNER JOIN jm_personas p ON ch.co_ven = p.co_ocupa
                LEFT JOIN zona z ON c.zona_id = z.co_zon
                WHERE CAST(c.fecha_carga AS DATE) BETWEEN '$fecha_inicio' AND '$fecha_fin' 
                AND CAST(ch.rol AS VARCHAR) = '6'
                AND (z.zon_des IS NULL OR z.zon_des <> 'NO APLICA')
                $chofer_filter
                ORDER BY c.fecha_carga DESC";
        }

        $query = Executor::doitAr($sql);	
        $e = count($query);		

        if ($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach ($query as $r) {				
                $array[$cnt] = new VehiculoData(); 
                
                $array[$cnt]->carga_id = trim($r['carga_id']);
                $array[$cnt]->vehiculo = trim($r['vehiculo']);
                $array[$cnt]->vehiculo_nombre = trim($r['vehiculo_nombre']);
                $array[$cnt]->chofer_id = trim($r['chofer_id']);
                $array[$cnt]->chofer_nombre = trim($r['chofer_nombre']);
                $array[$cnt]->ayudante_id = trim($r['ayudante_id']);
                $array[$cnt]->ayudante_nombre = trim($r['ayudante_nombre']); 
                $array[$cnt]->zona_id = trim($r['zona_id']);
                $array[$cnt]->zona_nombre = trim($r['zona_nombre']); 
                $array[$cnt]->total_paquetes = trim($r['total_paquetes']);
                $array[$cnt]->fecha_carga = trim($r['fecha_carga']);
                $array[$cnt]->estatus = trim($r['estatus']);
                
                $array[$cnt]->responsive_id = "";
                
                $cnt++;
            }
            return $array;
        } else {
            return array();
        }
    }

    public function confirmarEntrega($filtro, $notas) {
        try {
            $errores = [];
            $i = 1;
    
            // Procesar el filtro
            $filtro_limpio = str_replace("'", "", $filtro);
            $lotes_array = explode(',', $filtro_limpio);
            
            $lotes_procesados = [];
            foreach ($lotes_array as $lote) {
                $last_dash_pos = strrpos($lote, '-');
                
                if ($last_dash_pos !== false) {
                    $lotes_procesados[] = substr($lote, 0, $last_dash_pos);
                } else {
                    $lotes_procesados[] = $lote;
                }
            }
            
            $filtro_final = "'" . implode("','", $lotes_procesados) . "'";

            // Actualizar lotes
            $sql = "UPDATE jm_despacho_lotes SET estatus = '2' WHERE loteID = $filtro_final";
            $result = Executor::doitEx($sql);  
            
            // Actualizar paquetes
            $sql = "UPDATE jm_paquetes SET dato_extra1 = CAST(GETDATE() AS DATE), estatus = 2 WHERE co_lote = $filtro_final ";
            $result = Executor::doitEx($sql);  
            
        } catch (Exception $e) {
            // Manejo de errores
        }
    }

    public static function getFacturas($filtro) {
        // Procesar el filtro
        $filtro_limpio = str_replace("'", "", $filtro);
        $lotes_array = explode(',', $filtro_limpio);
        
        $lotes_procesados = [];
        foreach ($lotes_array as $lote) {
            $last_dash_pos = strrpos($lote, '-');
            
            if ($last_dash_pos !== false) {
                $lotes_procesados[] = substr($lote, 0, $last_dash_pos);
            } else {
                $lotes_procesados[] = $lote;
            }
        }
        
        $filtro_final = "'" . implode("','", $lotes_procesados) . "'";

        $sql = "select top 1 facturas from jm_paquetes_reg where co_lote=$filtro_final";
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->facturas = $r['facturas'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    public function updateFacturas($facturas) {
        try {
            $facturas_array = json_decode($facturas, true);

            if ($facturas_array === null || !is_array($facturas_array)) {
                throw new Exception('El formato de las facturas es inválido. Se esperaba un JSON array.');
            }

            $errores = [];
            $sql='';
            
            foreach ($facturas_array as $factura_codigo) {            
                if (strpos($factura_codigo, 'NF') === 0) {            
                    $factura_transformada = substr_replace($factura_codigo, '50', 0, 2);
                    $factura_a_procesar = $factura_transformada;
                } else {           
                    $factura_a_procesar = $factura_codigo;
                }

                $resultado = FacturaData::getByNumFactura($factura_a_procesar);   
                $dias = $resultado[0]->dias_cred;
                
                $sql = "update factura set campo5='1', fec_venc = DATEADD(day, $dias, CAST(GETDATE() AS DATE)) WHERE fact_num ='$factura_a_procesar';";
                Executor::doitEx($sql);
                
                $sql = "update docum_cc set fec_venc = DATEADD(day, $dias, CAST(GETDATE() AS DATE)) where tipo_doc = 'FACT' AND nro_doc='$factura_a_procesar';";
                Executor::doitEx($sql);
            }
        
            return ['success' => true, 'message' => 'Facturas procesadas correctamente.'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al procesar facturas: ' . $e->getMessage()];
        }
    }

    public static function getDataIndicadorFacturasVerificacion($filtro,$filtro2,$filtro3) {
        $hoy = getdate();
        $anio = $hoy['year'];
        $mes_a_consultar = $hoy['mon'];

        $sql = "SELECT 
        COUNT( fact_num ) as facturas_emitidas,
        COUNT(CASE WHEN campo7 <> '' THEN fact_num END) AS facturas_verificadas
        FROM factura c
        WHERE MONTH(c.fec_emis)=' $mes_a_consultar' and YEAR(c.fec_emis)='$anio' and c.anulada='0'";
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData();        
                $array[$cnt]->emitidas = $r['facturas_emitidas'];
                $array[$cnt]->verificadas = $r['facturas_verificadas'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            $cnt = 0;	
            $array[$cnt] = new VehiculoData();        
            $array[$cnt]->emitidas = 0;
            $array[$cnt]->verificadas = 0;
            return $array;
        }
    }

    public static function getInformacionFacturaRenglones($fact_num){
        $sql = "SELECT a.co_art AS co_art,
        a.modelo AS marca,
        sum(pg.total_art) AS cantidad,
        a.art_des,
        a.prec_vta1,
        a.ref from reng_fac pg 
        INNER JOIN factura p on p.fact_num=pg.fact_num 
        INNER JOIN art a ON pg.co_art=a.co_art 
        INNER JOIN vendedor v on p.co_ven=v.co_ven 
        WHERE pg.fact_num='".$fact_num."'
        GROUP BY a.co_art,
        a.prec_vta1,
        a.art_des,
        pg.total_art,
        a.ref, a.modelo ORDER BY a.art_des ASC";
        
        $query = Executor::doitAr($sql);	
        $e=count($query);		
        if($e>=1){
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new FacturaData(); 
                $array[$cnt]->responsive_id = ""; 		
                $array[$cnt]->co_art = trim($r['co_art']);				
                $array[$cnt]->barcode = trim($r['ref']);
                $array[$cnt]->dato1 = trim($r['art_des']);	
                $array[$cnt]->dato4 = trim($r['marca']);	
                $array[$cnt]->dato2 = (float)$r['cantidad'];
                $array[$cnt]->dato3 = (float)$r['prec_vta1'];			
                $cnt++;
            }
            return $array;
        }else{
            $array = array();
            return $array;
        }
    }

    public static function getInformacionFactura($fact_num){
        $formatted_fact_num = self::reverseFacturaNumber($fact_num);
    
        $sql = "SELECT DISTINCT
        jp.co_lote,
        jp.total_paquetes,
        jp.total_facturas,
        jpr.facturas,
        jp.dato_extra1 AS fecha_despacho,
        jp.estatus,
        jp.fecha_impresion AS fecha_impresion_etiqueta
        FROM jm_paquetes jp 
        INNER JOIN jm_paquetes_reg jpr ON jpr.co_lote = jp.co_lote
        INNER JOIN jm_despacho_lotes jdl ON jdl.loteID = jp.co_lote
        WHERE(
                jpr.facturas LIKE '%\"$formatted_fact_num\",%'
                OR jpr.facturas LIKE '\"$formatted_fact_num\",%'
                OR jpr.facturas LIKE '%,\"$formatted_fact_num\]%'
                OR jpr.facturas = '[\"$formatted_fact_num\"]'
            );";
        
        $query = Executor::doitAr($sql);	
        $e=count($query);		
        if($e>=1){
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $objeto_factura = new FacturaData();
                $data = $objeto_factura->getInformacionFacturaRenglones($fact_num);
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->responsive_id = ""; 		
                $array[$cnt]->co_lote = trim($r['co_lote']);				
                $array[$cnt]->fecha_despacho = trim($r['fecha_despacho']);
                $array[$cnt]->fecha_impresion_etiqueta = trim($r['fecha_impresion_etiqueta']);	
                $array[$cnt]->renglones = $data;	
                $cnt++;
            }
            return $array;
        }else{
            $cnt = 0;	
            $objeto_factura = new FacturaData();
            $data = $objeto_factura->getInformacionFacturaRenglones($fact_num);
            $array[$cnt] = new VehiculoData(); 
            $array[$cnt]->co_lote = "SIN LOTE ASIGNADO";
            $array[$cnt]->fecha_despacho = "SIN FECHA DE DESPACHO";	
            $array[$cnt]->fecha_impresion_etiqueta = "NO SE HA IMPRESO ETIQUETA";	
            $array[$cnt]->renglones = $data;	
            return $array;
        }
    }

    private static function formatFacturaNumber($fact_num) {
        if (strpos($fact_num, 'NF') === 0) {
            $numeric_part = substr($fact_num, 2);
            return (int)$numeric_part + 50;
        }
        return $fact_num;
    }

    private static function reverseFacturaNumber($fact_num) {
        $fact_num_str = (string)$fact_num;

        if (strpos($fact_num_str, '50') === 0) {
            return substr_replace($fact_num_str, 'NF', 0, 2);
        }

        return $fact_num;
    }

    public static function getDataInfoGeneral($carga_id) {
        $sql = "SELECT l.id, l.carga_id, l.lote_id, l.loteID, l.cantidad_paquetes,
                pr.facturas, pr.co_cli, c.cli_des
                FROM ".self::$tablename_lotes." l
                LEFT JOIN jm_paquetes_reg pr ON l.lote_id = pr.id
                LEFT JOIN clientes c ON pr.co_cli = c.co_cli
                WHERE l.carga_id = '$carga_id'";
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		
        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData(); 
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->carga_id = $r['carga_id'];
                $array[$cnt]->lote_id = $r['lote_id'];
                $array[$cnt]->loteID = $r['loteID'];
                $array[$cnt]->cantidad_paquetes = $r['cantidad_paquetes'];
                $array[$cnt]->facturas = $r['facturas'];
                $array[$cnt]->co_cli = $r['co_cli'];
                $array[$cnt]->cli_des = $r['cli_des'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }

    /**
     * Obtiene los detalles de un embarque específico
     */
    public static function getDetallesEmbarque($carga_id) {
        $sql = "SELECT 
                c.codigo,
                c.id as carga_id,
                c.vehiculo,
                v.placa as vehiculo_nombre,
                c.chofer_id,
                p.persona_des as chofer_nombre,
                c.ayudante_id,
                ISNULL(p2.persona_des, 'N/A') as ayudante_nombre,
                c.zona_id,
                ISNULL(z.zon_des, 'N/A') as zona_nombre,
                c.total_paquetes,
                c.fecha_carga,
                c.estatus,
                c.dato_extra1 as zona_descripcion
            FROM ".self::$tablename_carga." c
            INNER JOIN jm_vehiculos v ON c.vehiculo = v.placa
            INNER JOIN jm_users u ON c.chofer_id = u.co_ven
            INNER JOIN jm_personas p ON u.co_ven = p.co_ocupa
            LEFT JOIN jm_users u2 ON c.ayudante_id = u2.co_ven
            LEFT JOIN jm_personas p2 ON u2.co_ven = p2.co_ocupa
            LEFT JOIN zona z ON c.zona_id = z.co_zon
            WHERE c.id = '$carga_id'";
        
        $query = Executor::doitAr($sql);
        
        if (count($query) >= 1) {
            $embarque = new VehiculoData();
            $embarque->codigo = $query[0]['codigo'];
            $embarque->carga_id = $query[0]['carga_id'];
            $embarque->vehiculo = $query[0]['vehiculo'];
            $embarque->vehiculo_nombre = $query[0]['vehiculo_nombre'];
            $embarque->chofer_id = $query[0]['chofer_id'];
            $embarque->chofer_nombre = $query[0]['chofer_nombre'];
            $embarque->ayudante_nombre = $query[0]['ayudante_id'];
            $embarque->zona_id = $query[0]['zona_id'];
            $embarque->zona_nombre = $query[0]['zona_nombre'];
            $embarque->zona_descripcion = $query[0]['zona_descripcion'];
            $embarque->total_paquetes = $query[0]['total_paquetes'];
            $embarque->fecha_carga = $query[0]['fecha_carga'];
            $embarque->estatus = $query[0]['estatus'];
            
            return $embarque;
        } else {
            return null;
        }
    }
    
    /**
     * Obtiene las facturas asociadas a un embarque
     */
   /**
 * Obtiene las facturas asociadas a un embarque (método original corregido)
 */
public static function getFacturasByCargaId($carga_id) {
    $sql = "SELECT DISTINCT
            f.fact_num,
            f.co_cli,
            c.cli_des as cliente,
            f.tot_neto,  -- CORREGIDO: total_neto -> tot_neto
            f.fec_emis,
            f.fec_venc,
            f.anulada,
            f.campo5 as estatus
        FROM jm_despacho_lotes l
        INNER JOIN jm_paquetes_reg pr ON l.lote_id = pr.id
        CROSS APPLY (
            SELECT value AS fact_num
            FROM STRING_SPLIT(pr.facturas, ',')
        ) AS facturas
        INNER JOIN factura f ON facturas.fact_num = f.fact_num
        INNER JOIN clientes c ON f.co_cli = c.co_cli
        WHERE l.carga_id = '$carga_id'";
    
    $query = Executor::doitAr($sql);
    $e = count($query);
    
    if ($e >= 1) {
        $array = array();
        $cnt = 0;
        
        foreach ($query as $r) {
            $array[$cnt] = new VehiculoData();
            $array[$cnt]->id = $r['fact_num'];
            $array[$cnt]->fact_num = $r['fact_num'];
            $array[$cnt]->cliente = $r['cliente'];
            $array[$cnt]->total = $r['tot_neto'];  // CORREGIDO: total_neto -> tot_neto
            $array[$cnt]->fec_emis = $r['fec_emis'];
            $array[$cnt]->fec_venc = $r['fec_venc'];
            $array[$cnt]->anulada = $r['anulada'];
            $array[$cnt]->estado = $r['estatus'];
            
            $cnt++;
        }
        return $array;
    } else {
        return array();
    }
}
    
    /**
     * NUEVO MÉTODO: Obtiene las facturas asociadas a un embarque con sus totales
     * Procesa el JSON de facturas en jm_paquetes_reg.facturas
     */
   /**
 * Obtiene las facturas asociadas a un embarque con sus totales desde la tabla factura
 * @param string $embarque_id ID del embarque
 * @return array Array de facturas con totales
 */
public static function getFacturasByEmbarqueId($embarque_id) {
    // Primero obtenemos todos los lotes del embarque
    $sql_lotes = "SELECT l.id, l.loteID, l.cantidad_paquetes, 
                  pr.facturas, pr.co_cli, c.cli_des
                  FROM jm_despacho_lotes l
                  INNER JOIN jm_despacho_carga dc ON dc.codigo = l.codigo
                  LEFT JOIN jm_paquetes_reg pr ON l.lote_id = pr.id
                  LEFT JOIN clientes c ON pr.co_cli = c.co_cli
                  WHERE dc.id = $embarque_id";
    
    $lotes = Executor::doitAr($sql_lotes);
    
    $facturas_procesadas = [];
    $facturas_unicas = [];
    
    foreach ($lotes as $lote) {
        if (!empty($lote['facturas'])) {
            // Decodificar el JSON de facturas
            $facturas_json = trim($lote['facturas']);
            $facturas_array = json_decode($facturas_json, true);
            
            // Si no es JSON válido, intentar como texto simple
            if (!is_array($facturas_array)) {
                // Limpiar corchetes y comillas
                $facturas_limpias = str_replace(['[', ']', '"'], '', $facturas_json);
                $facturas_array = explode(',', $facturas_limpias);
            }
            
            foreach ($facturas_array as $num_factura) {
                $num_factura = trim($num_factura);
                
                if (!empty($num_factura) && !in_array($num_factura, $facturas_procesadas)) {
                    $facturas_procesadas[] = $num_factura;
                    
                    // Consultar el total neto de la factura
                    $factura_info = self::getInfoFactura($num_factura);
                    
                    if ($factura_info) {
                        $facturas_unicas[] = [
                            'id' => $factura_info['fact_num_original'],
                            'numero_factura' => $num_factura, // Mantener formato original (NF004234)
                            'cliente' => $lote['cli_des'] ?? 'N/A',
                            'total_neto' => $factura_info['tot_neto'] ?? 0,
                            'fecha_emision' => $factura_info['fec_emis'] ?? 'N/A',
                            'estado' => $factura_info['anulada'] == '0' ? '1' : '3', // 1=Activa, 3=Anulada
                            'lote_asociado' => $lote['loteID'],
                            'fact_num_db' => $factura_info['fact_num'] // Número real en la BD
                        ];
                    } else {
                        // Factura no encontrada en la BD, agregar igual pero sin total
                        $facturas_unicas[] = [
                            'id' => $num_factura,
                            'numero_factura' => $num_factura,
                            'cliente' => $lote['cli_des'] ?? 'N/A',
                            'total_neto' => 0,
                            'fecha_emision' => 'No encontrada',
                            'estado' => '0',
                            'lote_asociado' => $lote['loteID'],
                            'fact_num_db' => 'No encontrada'
                        ];
                    }
                }
            }
        }
    }
    
    return $facturas_unicas;
}

/**
 * Obtiene la información de una factura específica desde la tabla factura
 * @param string $num_factura Número de factura (puede venir como "NF004234" o "4234")
 * @return array|null Datos de la factura o null si no se encuentra
 */
private static function getInfoFactura($num_factura) {
    // Determinar el número a buscar en la BD
    $factura_buscar = $num_factura;
    $factura_original = $num_factura;
    
    // Si la factura empieza con "NF", convertir a formato numérico
    // Ejemplo: NF004234 -> 50004234 (reemplaza "NF" por "50")
    if (strpos($num_factura, 'NF') === 0) {
        $factura_buscar = substr_replace($num_factura, '50', 0, 2);
    }
    
    // Asegurar que sea un valor numérico para la consulta
    $factura_buscar = intval($factura_buscar);
    
    // Consultar la factura en la BD
    $sql = "SELECT TOP 1 
                fact_num, 
                tot_neto/tasa AS tot_neto, 
                fec_emis, 
                anulada,
                co_cli,
                campo5 as estatus,
                nombre
            FROM factura 
            WHERE fact_num = $factura_buscar";
    
    $query = Executor::doitAr($sql);
    
    if (count($query) >= 1) {
        return [
            'fact_num' => $query[0]['fact_num'],
            'fact_num_original' => $factura_original,
            'tot_neto' => $query[0]['tot_neto'],
            'fec_emis' => $query[0]['fec_emis'],
            'anulada' => $query[0]['anulada'],
            'co_cli' => $query[0]['co_cli'],
            'estatus' => $query[0]['estatus'],
            'nombre' => $query[0]['nombre']
        ];
    }
    
    // Si no se encuentra con el prefijo "50", intentar sin él
    if (strpos($num_factura, 'NF') === 0) {
        $factura_buscar_sin_prefijo = intval(substr($num_factura, 2));
        
        $sql2 = "SELECT TOP 1 
                    fact_num, 
                    tot_neto, 
                    fec_emis, 
                    anulada,
                    co_cli,
                    campo5 as estatus,
                    nombre
                FROM factura 
                WHERE fact_num = $factura_buscar_sin_prefijo";
        
        $query2 = Executor::doitAr($sql2);
        
        if (count($query2) >= 1) {
            return [
                'fact_num' => $query2[0]['fact_num'],
                'fact_num_original' => $factura_original,
                'tot_neto' => $query2[0]['tot_neto'],
                'fec_emis' => $query2[0]['fec_emis'],
                'anulada' => $query2[0]['anulada'],
                'co_cli' => $query2[0]['co_cli'],
                'estatus' => $query2[0]['estatus'],
                'nombre' => $query2[0]['nombre']
            ];
        }
    }
    
    return null;
}


/**
 * Obtiene los renglones (artículos) de una factura específica
 * @param string $num_factura Número de factura
 * @return array Array de renglones con detalles de artículos
 */
public static function getRenglonesFactura($num_factura) {
    // Convertir número de factura si es necesario
    $factura_buscar = $num_factura;
    if (strpos($num_factura, 'NF') === 0) {
        $factura_buscar = substr_replace($num_factura, '50', 0, 2);
    }
    $factura_buscar = intval($factura_buscar);
    
    $sql = "SELECT 
                rf.fact_num,
                rf.reng_num,
                rf.co_art,
                a.art_des,
                rf.total_art,
                rf.prec_vta/f.tasa AS prec_vta,
                rf.reng_neto/f.tasa AS reng_neto,
                rf.uni_venta,
                rf.des_art,
                rf.anulado
            FROM reng_fac rf
            INNER JOIN factura f ON rf.fact_num = f.fact_num
            LEFT JOIN art a ON rf.co_art = a.co_art
            WHERE rf.fact_num = $factura_buscar
            ORDER BY rf.reng_num ASC";
    
    $query = Executor::doitAr($sql);
    
    if (count($query) >= 1) {
        $array = array();
        $cnt = 0;
        
        foreach ($query as $r) {
            $array[$cnt] = [
                'fact_num' => $r['fact_num'],
                'reng_num' => $r['reng_num'],
                'co_art' => trim($r['co_art']),
                'art_des' => trim($r['art_des'] ?? $r['des_art'] ?? ''),
                'total_art' => $r['total_art'],
                'prec_vta' => $r['prec_vta'],
                'reng_neto' => $r['reng_neto'],
                'uni_venta' => trim($r['uni_venta'] ?? ''),
                'des_art' => trim($r['des_art'] ?? ''),
                'anulado' => $r['anulado']
            ];
            $cnt++;
        }
        return $array;
    } else {
        return array();
    }
}
    
    /**
     * Obtiene la ruta asociada a un embarque
     */
    public static function getRutaByCargaId($carga_id) {
        $sql = "SELECT 
                r.id,
                r.carga_id,
                r.nombre,
                r.direccion,
                r.descripcion,
                r.orden,
                r.tipo_punto
            FROM ".self::$tablename_ruta." r
            WHERE r.carga_id = '$carga_id'
            ORDER BY r.orden ASC";
        
        $query = Executor::doitAr($sql);
        $e = count($query);
        
        if ($e >= 1) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new VehiculoData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->carga_id = $r['carga_id'];
                $array[$cnt]->nombre = $r['nombre'];
                $array[$cnt]->direccion = $r['direccion'];
                $array[$cnt]->descripcion = $r['descripcion'];
                $array[$cnt]->orden = $r['orden'];
                $array[$cnt]->tipo_punto = $r['tipo_punto'];
                
                $cnt++;
            }
            return $array;
        } else {
            // Si no hay ruta en la tabla, creamos una ruta por defecto
            $embarque = self::getDetallesEmbarque($carga_id);
            
            if ($embarque) {
                $array = array();
                
                // Punto de partida (Bodega Central)
                $array[0] = new VehiculoData();
                $array[0]->id = 0;
                $array[0]->carga_id = $carga_id;
                $array[0]->nombre = "Punto de Partida";
                $array[0]->direccion = "Bodega Central";
                $array[0]->descripcion = "Av. Principal 123, Ciudad Industrial";
                $array[0]->orden = 1;
                $array[0]->tipo_punto = "salida";
                
                // Destinos basados en los lotes del embarque
                $lotes = self::getLotesByCargaId($carga_id);
                $clientes_procesados = array();
                $orden = 2;
                
                foreach ($lotes as $lote) {
                    if (!in_array($lote->co_cli, $clientes_procesados)) {
                        $array[$orden-1] = new VehiculoData();
                        $array[$orden-1]->id = 0;
                        $array[$orden-1]->carga_id = $carga_id;
                        $array[$orden-1]->nombre = "Destino " . ($orden-1);
                        $array[$orden-1]->direccion = $lote->cli_des;
                        $array[$orden-1]->descripcion = "Entrega de lote " . $lote->loteID;
                        $array[$orden-1]->orden = $orden;
                        $array[$orden-1]->tipo_punto = "entrega";
                        
                        $clientes_procesados[] = $lote->co_cli;
                        $orden++;
                    }
                }
                
                // Punto de retorno (Bodega Central)
                $array[$orden-1] = new VehiculoData();
                $array[$orden-1]->id = 0;
                $array[$orden-1]->carga_id = $carga_id;
                $array[$orden-1]->nombre = "Punto de Retorno";
                $array[$orden-1]->direccion = "Bodega Central";
                $array[$orden-1]->descripcion = "Av. Principal 123, Ciudad Industrial";
                $array[$orden-1]->orden = $orden;
                $array[$orden-1]->tipo_punto = "regreso";
                
                return $array;
            } else {
                return array();
            }
        }
    }
    
    /**
     * Actualiza el estado de un embarque
     */
    public static function actualizarEstadoEmbarque($carga_id, $nuevo_estado) {
        try {
            $sql = "UPDATE ".self::$tablename_carga." SET estatus = '$nuevo_estado' WHERE codigo = '$carga_id'";
            Executor::doitEx($sql);
            
            return ['success' => true, 'message' => 'Estado del embarque actualizado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar estado del embarque: ' . $e->getMessage()];
        }
    }
    
    /**
     * Obtiene todos los lotes asociados a un embarque
     */
    public static function getDetallesLotesEmbarque($embarque_id) {
        $sql = "SELECT 
                l.id,
                l.carga_id,
                l.lote_id,
                l.loteID,
                l.cantidad_paquetes,
                l.estatus,
                pr.facturas,
                pr.co_cli,
                c.cli_des,
                pr.numero_paquete,
                pr.fecha_despacho,
                pr.qr_data,
                MAX(pq.dato_extra1) as fecha_entrega
            FROM jm_despacho_lotes l
            INNER JOIN jm_despacho_carga dc ON dc.codigo = l.codigo
            INNER JOIN jm_paquetes_reg pr ON l.lote_id = pr.id
            LEFT JOIN jm_paquetes pq ON pq.co_lote = pr.co_lote
            INNER JOIN clientes c ON pr.co_cli = c.co_cli
            WHERE dc.id = $embarque_id
            GROUP BY 
                l.id, l.carga_id, l.lote_id, l.loteID, l.cantidad_paquetes, 
                l.estatus, pr.facturas, pr.co_cli, c.cli_des, 
                pr.numero_paquete, pr.fecha_despacho, pr.qr_data";

        $query = Executor::doitAr($sql);
        $e = count($query);
        
        if ($e >= 1) {
            $array = array();
            $cnt = 0;
            $cantidad = 1;
            
            foreach ($query as $r) {
                $array[$cnt] = new VehiculoData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->carga_id = $r['carga_id'];
                $array[$cnt]->lote_id = $r['lote_id'];
                $array[$cnt]->loteID = $r['loteID'];
                $array[$cnt]->cantidad_paquetes = $r['cantidad_paquetes'];
                $array[$cnt]->estatus = $r['estatus'];
                $array[$cnt]->facturas = $r['facturas'];
                $array[$cnt]->co_cli = $r['co_cli'];
                $array[$cnt]->cli_des = $r['cli_des'];
                $array[$cnt]->numero_paquete = $r['numero_paquete'];
                $array[$cnt]->fecha_despacho = $r['fecha_despacho'];
                $array[$cnt]->qr_data = $r['qr_data'];
                $array[$cnt]->descripcion = $r['cli_des'];
                $array[$cnt]->fecha_entrega = $r['fecha_entrega'];
                $array[$cnt]->observaciones = "Facturas asociadas: " . $r['facturas'];
                
                $cnt++;
                $cantidad++;
            }
            return $array;
        } else {
            return array();
        }
    }
  
    public static function exportarEmbarqueExcel($datos) {
        try {
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getProperties()->setCreator("Sistema de Embarques")
                                     ->setLastModifiedBy("Sistema de Embarques")
                                     ->setTitle("Detalles del Embarque " . $datos['embarque']['codigo'])
                                     ->setSubject("Detalles del Embarque")
                                     ->setDescription("Detalles completos del embarque " . $datos['embarque']['codigo']);
            
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle("Información General");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID del Embarque');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', $datos['embarque']['codigo']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Vehículo');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $datos['embarque']['vehiculo_nombre']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Chofer');
            $objPHPExcel->getActiveSheet()->setCellValue('B3', $datos['embarque']['chofer_nombre']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Ayudante');
            $objPHPExcel->getActiveSheet()->setCellValue('B4', $datos['embarque']['ayudante_nombre']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Zona');
            $objPHPExcel->getActiveSheet()->setCellValue('B5', $datos['embarque']['zona_nombre']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Total de Paquetes');
            $objPHPExcel->getActiveSheet()->setCellValue('B6', $datos['embarque']['total_paquetes']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Fecha de Carga');
            $objPHPExcel->getActiveSheet()->setCellValue('B7', $datos['embarque']['fecha_carga']);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Estado');
            $objPHPExcel->getActiveSheet()->setCellValue('B8', $datos['embarque']['estatus']);
            
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex(1);
            $objPHPExcel->getActiveSheet()->setTitle("Lotes");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Código');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Descripción');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Cantidad de Paquetes');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Estado');
            
            $row = 2;
            foreach ($datos['lotes'] as $lote) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $lote['id']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $lote['loteID']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $lote['descripcion']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $lote['cantidad_paquetes']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $lote['estatus']);
                $row++;
            }
            
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex(2);
            $objPHPExcel->getActiveSheet()->setTitle("Facturas");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Número');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Cliente');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Total');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Fecha');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Estado');
            
            $row = 2;
            foreach ($datos['facturas'] as $factura) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $factura['fact_num']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $factura['cliente']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $factura['total']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $factura['fec_emis']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $factura['estado']);
                $row++;
            }
            
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex(3);
            $objPHPExcel->getActiveSheet()->setTitle("Ruta");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nombre');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Dirección');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Descripción');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tipo');
            
            $row = 2;
            foreach ($datos['ruta'] as $punto) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $punto['nombre']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $punto['direccion']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $punto['descripcion']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $punto['tipo_punto']);
                $row++;
            }
            
            $filename = "embarque_" . $datos['embarque']['codigo'] . "_" . date('Y-m-d') . ".xlsx";
            $filepath = "../temp/" . $filename;
            
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($filepath);
            
            return $filepath;
            
        } catch (Exception $e) {
            throw new Exception('Error al generar el archivo Excel: ' . $e->getMessage());
        }
    }

    public static function getDetallesLoteID($lote_id) {
        $sql = "SELECT 
                l.id,
                l.carga_id,
                l.lote_id,
                l.loteID,
                l.cantidad_paquetes,
                l.estatus,
                pr.facturas,
                pr.co_cli,
                c.cli_des,
                pr.numero_paquete,
                pr.fecha_despacho,
                pr.qr_data,
                dc.fecha_carga
            FROM ".self::$tablename_lotes." l
            LEFT JOIN jm_paquetes_reg pr ON l.lote_id = pr.id
            INNER JOIN jm_despacho_carga dc ON dc.codigo = l.codigo
            LEFT JOIN clientes c ON pr.co_cli = c.co_cli
            WHERE l.id = '$lote_id'";
        
        $query = Executor::doitAr($sql);
        
        if (count($query) >= 1) {
            $lote = new VehiculoData();
            $lote->id = $query[0]['id'];
            $lote->carga_id = $query[0]['carga_id'];
            $lote->lote_id = $query[0]['lote_id'];
            $lote->loteID = $query[0]['loteID'];
            $lote->cantidad_paquetes = $query[0]['cantidad_paquetes'];
            $lote->estatus = $query[0]['estatus'];
            $lote->facturas = $query[0]['facturas'];
            $lote->co_cli = $query[0]['co_cli'];
            $lote->cli_des = $query[0]['cli_des'];
            $lote->numero_paquete = $query[0]['numero_paquete'];
            $lote->fecha_despacho = $query[0]['fecha_despacho'];
            $lote->fecha_carga = $query[0]['fecha_carga'];
            $lote->qr_data = $query[0]['qr_data'];
            $lote->descripcion = $query[0]['cli_des'];
            $lote->observaciones = "Facturas asociadas: " . $query[0]['facturas'];
            
            return $lote;
        } else {
            return null;
        }
    }

    public static function getEstadisticasEmbarque($embarque_id) {
        $sql = "SELECT 
                COUNT(DISTINCT l.id) as total_lotes,
                SUM(l.cantidad_paquetes) as total_paquetes,
                COUNT(DISTINCT CASE WHEN l.estatus = '2' THEN l.id END) as lotes_entregados
            FROM jm_despacho_lotes l
            INNER JOIN jm_despacho_carga dc ON dc.codigo = l.codigo
            WHERE dc.id = $embarque_id";
                
        $query = Executor::doitAr($sql);
                
        if (count($query) >= 1) {
            return [
                'total_lotes' => $query[0]['total_lotes'],
                'total_paquetes' => $query[0]['total_paquetes'],
                'lotes_entregados' => $query[0]['lotes_entregados']
            ];
        } else {
            return [
                'total_lotes' => 0,
                'total_paquetes' => 0,
                'lotes_entregados' => 0
            ];
        }
    }

    public static function getDataIndicadorVerificaciones($anio,$mes) {
        $sql = "SELECT 
        COUNT( fact_num ) as facturas_emitidas,
        COUNT(CASE WHEN campo7 <> '' THEN fact_num END) AS facturas_verificadas
        FROM factura c        
        WHERE MONTH(c.fec_emis)=' $mes' and YEAR(c.fec_emis)='$anio' and c.anulada='0'";
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		        
        if($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {
                $array[$cnt] = new VehiculoData();        
                $array[$cnt]->emitidas = $r['facturas_emitidas'];
                $array[$cnt]->verificadas = $r['facturas_verificadas'];               
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            $cnt = 0;	
            $array[$cnt] = new VehiculoData();        
            $array[$cnt]->emitidas = 0;
            $array[$cnt]->verificadas = 0;
            return $array;
        }
    }

    public static function getDataIndicadorDespachosInternos($anio,$mes,$opcional) {
        $sql = "SELECT COUNT(*) as cantidad_viajes,ISNULL(SUM(c.total_paquetes), 0) total_bultos 
                FROM jm_despacho_carga c 
                INNER JOIN jm_vehiculos v ON c.vehiculo=v.placa 
                WHERE MONTH(c.fecha_carga)='$mes' 
                AND YEAR(c.fecha_carga)='$anio' 
                AND v.dato_extra3 =$opcional";    
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		

        if ($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach ($query as $r) {				
                $array[$cnt] = new VehiculoData();
                $array[$cnt]->dato1 = $r['cantidad_viajes'];
                $array[$cnt]->dato2 = $r['total_bultos'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            $cnt = 0;	
            $array[$cnt] = new VehiculoData();
            $array[$cnt]->dato1 = 0;
            $array[$cnt]->dato2 = 0;
            return $array;
        }
    }

    public static function getDataIndicadorcantidadViajesVehiculos($anio,$mes,$opcional) {
        $sql = "
            SELECT
                v.placa, v.marca, v.modelo, v.anio,
                COUNT(dc.vehiculo) AS total_viajes,
                sum(dc.total_paquetes) as total_bultos
            FROM
                jm_vehiculos v
            INNER JOIN
                jm_despacho_carga dc ON v.placa = dc.vehiculo
            WHERE MONTH(dc.fecha_carga)='$mes' 
            AND YEAR(dc.fecha_carga)='$anio' 
            AND v.dato_extra3 =$opcional
            GROUP BY
                v.placa, v.marca, v.modelo, v.anio
            ORDER BY
                v.placa; ";
        
        $query = Executor::doitAr($sql);	
        $e = count($query);		

        if ($e >= 1) {
            $array = array();
            $cnt = 0;	
            foreach ($query as $r) {				
                $array[$cnt] = new VehiculoData();
                $array[$cnt]->dato1 = $r['placa']." - ".$r['marca']." ".$r['modelo']." ".$r['anio'];
                $array[$cnt]->dato2 = $r['total_viajes'];
                $array[$cnt]->dato3 = $r['total_bultos'];
                $cnt++;
            }
            return $array;
        } else {
            $array = array();
            $cnt = 0;	
            $array[$cnt] = new VehiculoData();
            $array[$cnt]->dato1 = 0;
            $array[$cnt]->dato2 = 0;
            $array[$cnt]->dato3 = 0;
            return $array;
        }
    }
}
?>