<?php
class EncuestaData {
    
    public static $tablename = "jm_visitas_cliente";
    
    public function __construct(){
        $this->id = '';
        $this->co_ven = '';
        $this->co_cli = '';
        $this->r1 = '';
        $this->r2 = '';
        $this->r3 = '';
        $this->r4 = '';
        $this->r5 = '';
        $this->r6 = '';
        $this->r7 = '';
        $this->r8 = '';
        $this->r9 = '';
        $this->r10 = '';
        $this->r11 = '';
        $this->r12 = '';
        $this->r13 = '';
        $this->r14 = '';
        $this->r15 = '';
        $this->r16 = '';
        $this->r17 = '';
        $this->r18 = '';
        $this->r19 = '';
        $this->r20 = '';
        $this->r21 = '';
        $this->r22 = '';
        $this->r23 = '';
        $this->r24 = '';
        $this->r25 = '';
        $this->estatus = 1; // Por defecto activo
    }

            // Función para insertar una nueva encuesta
            public function add_jm_visitas_cliente($ubicacion,$fotoInfo){

                $co_ven =$_SESSION['identidad'];	

                    /*
                        [id] [int] IDENTITY(1,1) NOT NULL,
                        [co_cli] [nchar](10) NULL,
                        [co_ven] [nchar](10) NULL,
                        [fecha] [datetime] NULL,
                        [lat] [text] NULL,
                        [lon] [text] NULL,
                        [descripcion] [text] NULL,
                        [dato_extra] [text] NULL,
                        [estatus] [int] NULL,*/



                
                $sql = "INSERT INTO jm_visitas_cliente (
                    co_cli, co_ven, fecha, lat, lon, descripcion, dato_extra, estatus
                ) VALUES (
                    '$this->co_cli', '$co_ven',getdate(), '".$ubicacion['latitude']."',
                    '".$ubicacion['longitude']."', '".$ubicacion['accuracy']."','".$fotoInfo['ruta']."','1')";
                //echo $sql;
                $query = Executor::doitEx($sql);

                return $query;
                
                }

            // Función para insertar las respuestas de la encuesta
            public function add_jm_visitas_respuestas($id_visita, $respuestas) {
               // var_dump($respuestas);
                
                $sql = "";
                $count = 0;
                
                foreach ($respuestas as $co_pregunta => $respuesta) {
                    // Limpiar y validar los datos
                    $co_pregunta_clean = trim($co_pregunta);
                    $respuesta_clean = trim($respuesta);
                    
                    if (!empty($co_pregunta_clean) && !empty($respuesta_clean)) {
                        $sql .= "INSERT INTO jm_visitas_respuesta (
                                    co_visita, co_pregunta, respuesta, respuesta_opcional, estatus
                                ) VALUES (
                                    '$id_visita', '$co_pregunta_clean', '$respuesta_clean', NULL, 1
                                );";
                    
                        $count++;
                    }
                }
                
                if (!empty($sql)) {
                    $query = Executor::doitEx($sql);
                    return array('success' => true, 'respuestas_guardadas' => $count);
                }
                
                return array('success' => false, 'message' => 'No hay respuestas válidas para guardar');
            }

        // Función combinada para guardar visita y respuestas
        public function guardarVisitaCompleta($ubicacion, $fotoInfo, $respuestas) {
           // var_dump($respuestas);     
            // 1. Primero guardar la visita principal
          
             $resultVisita = $this->add_jm_visitas_cliente($ubicacion, $fotoInfo);
             $data=$this->obtenerUltimoIdVisita();
             $id_visita = $data['ultimo_id'];
             $resultRespuestas = $this->add_jm_visitas_respuestas($id_visita, $respuestas);
       
            
            if (!$resultVisita) {
                return array('success' => false, 'message' => 'Error al guardar la visita principal');
            }
            
      
            // 3. Guardar las respuestas
       
            
            return array(
                'success' => true,
                'id_visita' => $id_visita,
                'respuestas' => $resultRespuestas
            );
        }

    // Función para obtener todas las encuestas
    public static function getAllEncuestas(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY id DESC";
        $query = Executor::doitAr($sql);        
        $array = array();
        $cnt = 0;
        
        foreach($query as $r){
            $array[$cnt] = new EncuestaData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->co_ven = $r['co_ven'];
            $array[$cnt]->co_cli = $r['co_cli'];
            $array[$cnt]->r1 = $r['r1'];
            $array[$cnt]->r2 = $r['r2'];
            // ... asignar el resto de los campos r3 a r25 ...
            $array[$cnt]->estatus = $r['estatus'];
            $cnt++;
        }
        
        return $array;
    }


    public static function getAllDataPreguntas($co_cli){
        $co_cli = 1; // esto por ahora mientras 
        // Construir la condición WHERE según el valor de co_cli
        $where_condition = "";
        
        if (is_numeric($co_cli)) {
            $co_cli_num = (int)$co_cli;
            if ($co_cli_num >= 1 && $co_cli_num <= 100) {
                // Es un número entre 1-100 (grupo de clientes)
                $where_condition = "jvp.estatus = 1 AND jvsp.estatus = 1 AND jvp.cliente = '$co_cli'";
            } else {
                // Es un código de cliente específico (número fuera del rango 1-100)
                $where_condition = "jvp.estatus = 1 AND jvsp.estatus = 1 AND jvp.cliente = '$co_cli'";
            }
        } else {
            // Es un código de cliente alfanumérico
            $where_condition = "jvp.estatus = 1 AND jvsp.estatus = 1 AND jvp.cliente = '$co_cli'";
        }
        
        $sql = "SELECT 
            jvp.id as id, 
            jvp.co_pregunta,
            jvp.pre_des,
            jvp.estatus,
            jvp.tipo_respuesta,
            jvp.es_requerida,
            jvp.tipo_opciones,
            jvp.opciones_respuesta,
            jvp.cliente,
            jvsp.seccion,
            jvsp.id as idSeccion      
            FROM jm_visitas_preguntas jvp 
            INNER JOIN jm_visitas_seccion_preguntas jvsp ON jvp.seccion = jvsp.id
            WHERE $where_condition";
        // echo $sql;
        $query = Executor::doitAr($sql);        
        
        $e = count($query);
        if($e >= 1){
            $array = array();
            $cnt = 0;	
            foreach($query as $r) {		
                $array[$cnt] = New EncuestaData();  
                $array[$cnt]->responsive_id = ""; 
                $array[$cnt]->id = $r['id'];				
                $array[$cnt]->co_pregunta = $r['co_pregunta'];	
                $array[$cnt]->pre_des = $r['pre_des'];		
                $array[$cnt]->estatus = $r['estatus'];	
                $array[$cnt]->tipo_respuesta = $r['tipo_respuesta'];	
                $array[$cnt]->es_requerida = $r['es_requerida'];
                $array[$cnt]->tipo_opciones = $r['tipo_opciones'];
                $array[$cnt]->seccion = $r['seccion'];	
                $array[$cnt]->idSeccion = $r['idSeccion'];	
                $objeto_condicional = New FuncionesData();
                $data_condicional =   $objeto_condicional->getAllLogica_condicional($r['id'],'0');

                if($r['tipo_opciones'] == '2'){
                    $objeto_select = new ArticuloData();
                    $data = $objeto_select->getDataLineas();

                    $values = [];
                    foreach ($data as $item) {
                        if (isset($item->dato3)) {
                            $values[] = $item->dato3;
                        }
                    }

                    $data_opciones = implode(',', $values);
                } else {
                    $data_opciones = $r['opciones_respuesta'];
                }

                $array[$cnt]->opciones_respuesta = $data_opciones;
                $array[$cnt]->cliente = $r['cliente'];
                $array[$cnt]->logica_condicional = $data_condicional;


                $cnt++;
            }
            
            return $array;
        } else {
            $array = array();
            return $array;
        }
    }
    
    function procesarFoto($archivoFoto,$co_cli) {
            $directorio = '../admin/storage/perfil/visita/';
         

            // Validar tipo de archivo
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($archivoFoto['name'], PATHINFO_EXTENSION));
            
            if (!in_array($extension, $extensionesPermitidas)) {
                throw new Exception('Tipo de archivo no permitido');
            }

            // Generar nombre único
            $nombreArchivo = $co_cli . '_' . uniqid() . '.' . strtolower($extension);
           // $nombreArchivo = uniqid('encuesta_', true) . '.' . $extension;
            $rutaCompleta = $directorio . $nombreArchivo;

            // Mover archivo
            if (!move_uploaded_file($archivoFoto['tmp_name'], $rutaCompleta)) {
                throw new Exception('Error al guardar la imagen');
            }

            return [
                'nombre' => $archivoFoto['name'],
                'ruta' => $rutaCompleta,
                'tipo' => $archivoFoto['type'],
                'tamaño' => $archivoFoto['size']
            ];
        }


                    /**
             * Función para procesar la foto del punto de venta
             */
            private function procesarFotoCandidato($archivoFoto) {
                $directorioFotos = '../uploads/candidatos/fotos/';
                
                // Crear directorio si no existe
                if (!file_exists($directorioFotos)) {
                    mkdir($directorioFotos, 0755, true);
                }
                
                // Validar tipo de archivo
                $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $tipoArchivo = mime_content_type($archivoFoto['tmp_name']);
                
                if (!in_array($tipoArchivo, $tiposPermitidos)) {
                    throw new Exception('Tipo de archivo no permitido. Solo se aceptan imágenes JPEG, PNG, GIF o WebP.');
                }
                
                // Validar tamaño (máximo 5MB)
                $tamañoMaximo = 5 * 1024 * 1024; // 5MB
                if ($archivoFoto['size'] > $tamañoMaximo) {
                    throw new Exception('La imagen no debe superar los 5MB de tamaño.');
                }
                
                // Generar nombre único para el archivo
                $extension = pathinfo($archivoFoto['name'], PATHINFO_EXTENSION);
                $nombreArchivo = 'candidato_' . date('Ymd_His') . '_' . uniqid() . '.' . $extension;
                $rutaCompleta = $directorioFotos . $nombreArchivo;
                
                // Mover archivo al directorio de destino
                if (!move_uploaded_file($archivoFoto['tmp_name'], $rutaCompleta)) {
                    throw new Exception('Error al guardar la imagen en el servidor.');
                }
                
                // Opcional: Redimensionar imagen si es muy grande
                $this->redimensionarImagen($rutaCompleta, 1200, 1200);
                
                return [
                    'nombre' => $nombreArchivo,
                    'ruta' => $rutaCompleta,
                    'tipo' => $tipoArchivo,
                    'tamaño' => filesize($rutaCompleta)
                ];
            }


        private  static function obtenerUltimoIdVisita() {
                $sql = "SELECT MAX(id) as ultimo_id FROM jm_visitas_cliente";
                $query = Executor::doit($sql);              
            
                return $query;
             
                
               
            }
}
?>