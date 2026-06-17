<?php
class ClienteData {
	public static $tablename = "clientes";

	public function __construct(){

		$this->responsive_id = '';
		$this->co_cli = '0';
		$this->rif = "";
		$this->cli_des = "";	
		$this->telefonos = "";
		$this->email ="";
		$this->direc1 ="0";
		$this->dir_ent2 ="0";
		$this->dato1 ='0';	

		$this->mont_cre ='0';	
		$this->plaz_pag ='0';	
		$this->saldo ='0';	
		$this->ultima ='0';

		$this->campo5 ='0';	
		$this->campo6 ='0';	
		$this->campo7 ='0';	
		
		$this->campo8 ='0';	
		$this->campo9 ='0';	
		$this->campo10 ='0';	
		
	}

	public function add_jm_cliente(){
		$sql = "INSERT INTO  jm_clientes(co_cli,lat,lon,media,co_us_in,id_parroquia,responsable,fechaNacimientoResponsable,empresaAniversario,
		fechaNacimientoPropietario,responsableCompras,fechaNacimientoResponsableCompras,estatus,id_ciudad)";
		$sql .= "VALUES ('$this->co_cli','0','0','no_media.webp','$this->co_us_in',$this->id_parroquia,'$this->responsable',
		'$this->fechaNacimientoResponsable','$this->empresaAniversario','$this->fechaNacimientoPropietario','$this->responsableCompras',
		'$this->fechaNacimientoResponsableCompras',1,$this->id_ciudad)";		
		//echo $sql;
		Executor::doitEx($sql);
	}

	public function add_jm_cliente_cand(){

		$co_ven =$_SESSION['identidad'];	
		$sql = "INSERT INTO  jm_clientes_cand(co_cli,tipo,cli_des,direc1,direc2,telefonos,fecha_reg,co_ven,dir_ent2,
		rif,email,id_parroquia,id_ciudad,estatus,lat,lon,fecha,dato_extra,contacto_cliente,contacto_telefono,foto,datoextra2,datoextra3,datoextra4,datoextra5,datoextra6)";
		$sql .= "VALUES ('$this->co_cli','3','$this->cli_des','$this->direc1','$this->direc2','$this->telefonos',getdate(),
		'$co_ven','$this->dir_ent2','$this->rif','$this->email','$this->id_parroquia','$this->id_ciudad',1,'$this->lat','$this->lon','$this->fecha','','$this->contacto_des','$this->contacto_telefono','$this->foto',
		'$this->cli_grupo','$this->cli_grupo_cantidad','$this->cli_estado_sucrusales','$this->cli_observacion','$this->contacto_des_recibe')";		
		//echo $sql;
		Executor::doitEx($sql);

	}

	public function add_jm_cliente_cand_visita(){

		$co_ven =$_SESSION['identidad'];	
		$sql = "INSERT INTO  jm_visitas_candidatos(co_ven,co_cand,fecha,lat,lon,acc,observacion,contacto_des,contacto_telefono,foto,dato_extra,estatus)";
		$sql .= "VALUES ('$co_ven','$this->co_cli',getdate(),'$this->lat','$this->lon','$this->acc','$this->observacion','$this->contacto_des','$this->contacto_telefono','$this->foto','',1)";		
		//echo $sql;
		Executor::doitEx($sql);

	}
				/**
			 * Añade un nuevo evento a la tabla de calendario.
			 * Utiliza sentencias preparadas para mayor seguridad.
			 * @return int|false El ID del nuevo evento insertado, o false en caso de error.
			 */
			public function add_evento_calendario() {
				// Obtenemos el ID del vendedor/usuario desde la sesión
				$co_ven = isset($_SESSION['identidad']) ? $_SESSION['identidad'] : null;

				// Preparamos la consulta SQL con marcadores de posición (?) para prevenir inyección SQL
				$sql = "INSERT INTO jm_visitas_planificacion (co_ven,tipo, inicio, fin,description,dato_extra1,dato_extra2,dato_extra3,estatus) ";
				$sql .= "VALUES ('$co_ven','$this->tipo','$this->inicio','$this->fin','$this->descripcion','$this->dato_extra1','$this->dato_extra2','$this->dato_extra3',1)";

				//echo $sql;
				// Ejecutamos la consulta usando tu clase Executor
				// Asumimos que Executor::doitEx puede manejar sentencias preparadas
				// o que tienes un método para ello.
				// Si no, tendrías que adaptar esta parte.
				$last_id = Executor::doitEx($sql); // ¡Importante! doitEx debe devolver el ID

				// Devolvemos el ID del nuevo registro
				return $last_id=1;
			}


	
	public function add_jm_cliente_visita(){

		$co_ven =$_SESSION['identidad'];	
		$sql = "INSERT INTO  jm_visitas_cliente_corta(co_ven,co_cli,fecha,lat,lon,acc,observacion,contacto_des,contacto_telefono,foto,dato_extra,estatus)";
		$sql .= "VALUES ('$co_ven','$this->co_cli',getdate(),'$this->lat','$this->lon','$this->acc','$this->cli_observacion_visita','$this->cli_recibe_visita','$this->cli_telefono_visita','$this->foto','',1)";		
		//echo $sql;
		Executor::doitEx($sql);

	}



	public function update_cliente(){
		$sql="UPDATE clientes SET telefonos = '$this->telefonos', email='$this->email', respons='$this->respons', dir_ent2='$this->dir_ent2' WHERE co_cli = '$this->co_cli'";
		//	echo $sql;
		Executor::doitEx($sql);
	}
	
	
	public function update_cliente_jm_clientes(){
		/* id_parroquiav responsable fechaNacimientoResponsable empresaAniversario fechaNacimientoPropietario
		responsableCompras fechaNacimientoResponsableCompras */
		$sql="UPDATE jm_clientes SET id_parroquia = $this->id_parroquia,id_ciudad = $this->id_ciudad, responsable='$this->responsable', fechaNacimientoResponsable='$this->fechaNacimientoResponsable', 
		empresaAniversario='$this->empresaAniversario',fechaNacimientoPropietario='$this->fechaNacimientoPropietario',responsableCompras='$this->responsableCompras',
		fechaNacimientoResponsableCompras='$this->fechaNacimientoResponsableCompras' WHERE co_cli = '$this->co_cli'";
		//echo $sql;
		Executor::doitEx($sql);
	}
	
	public static function getDataFiltrada($filtro){
				$sql = "SELECT TOP 1 t.des_tipo,c.*	 FROM clientes c  INNER JOIN tipo_cli t ON c.tipo = t.tip_cli	WHERE c.co_cli = '$filtro'";
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$objeto_funciones = New FuncionesData();
			$data = $objeto_funciones->GetSubConsulta($r['co_cli']);
			$array[$cnt] = new ClienteData();  

			
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->co_cli =trim($r['co_cli']);			
			$array[$cnt]->rif = trim($r['rif']);	
			$array[$cnt]->cli_des = trim($r['cli_des']);	
			$array[$cnt]->telefonos =trim($r['telefonos']);
			$array[$cnt]->email =trim($r['email']);	
			$array[$cnt]->direc1 = trim($r['direc1']);	
			$array[$cnt]->dir_ent2 = trim($r['dir_ent2']);			
			$array[$cnt]->des_tipo = trim($r['des_tipo']);

			$array[$cnt]->dato1 =  trim($r['respons']);
			
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];

			
			if(count($data)==1){

			$array[$cnt]->id_estado = $data[0]->id_estado;	
			$array[$cnt]->estado = $data[0]->estado;			
			$array[$cnt]->id_municipio = $data[0]->id_municipio;		
			$array[$cnt]->municipio = $data[0]->municipio;		
			$array[$cnt]->id_parroquia = $data[0]->id_parroquia;				
			$array[$cnt]->parroquia = $data[0]->parroquia;	

			$array[$cnt]->id_ciudad = $data[0]->id_ciudad;		
			$array[$cnt]->ciudad = $data[0]->ciudad;	

			$array[$cnt]->lat = $data[0]->lat;		
			$array[$cnt]->lon = $data[0]->lon;		
			$array[$cnt]->media = $data[0]->media;		
			$array[$cnt]->responsable = $data[0]->responsable;		
			$array[$cnt]->fechaNacimientoResponsable = $data[0]->fechaNacimientoResponsable;		
			$array[$cnt]->empresaAniversario = $data[0]->empresaAniversario;		
			$array[$cnt]->fechaNacimientoPropietario = $data[0]->fechaNacimientoPropietario;		
			$array[$cnt]->responsableCompras = $data[0]->responsableCompras;	
			$array[$cnt]->fechaNacimientoResponsableCompras = $data[0]->fechaNacimientoResponsableCompras;	

			}

		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
}
	


	public static function getAllDatosGerencia(){		
		
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 
		ORDER BY c.co_cli ASC";	
		
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$array[$cnt] = new ClienteData();  
			$objeto_funciones = New FacturaData();
			$data =$objeto_funciones->getSaldoPorCobrar($r['co_cli']);
			$data2 =$objeto_funciones->getUltimaFactura($r['co_cli']);
			
			$saldo=$data[0]->saldo;
			$ultima=$data2[0]->fecha;
			
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];
			$array[$cnt]->saldo_p =  (float)$saldo;
			$array[$cnt]->ultima_f = substr($ultima, 0, 10);  // abcd ;;
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}


	public static function getAllDatos(){		
		$co_ven = $_SESSION['identidad'];
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 AND (c.website = '$co_ven' OR c.co_ven = '$co_ven')
		ORDER BY c.co_cli ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$array[$cnt] = new ClienteData();  
			$objeto_funciones = New FacturaData();
			$data =$objeto_funciones->getSaldoPorCobrar($r['co_cli']);
			$data2 =$objeto_funciones->getUltimaFactura($r['co_cli']);
			
			$saldo=$data[0]->saldo;
			$ultima=$data2[0]->fecha;
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];
			$array[$cnt]->saldo_p = $saldo;
			$array[$cnt]->ultima_f = $ultima;
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}


	public static function getAllDatosSimplesTodos(){		
		
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 
		ORDER BY c.co_cli ASC";	
		
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefoo telefono2 correo
			$array[$cnt] = new ClienteData();  			
		
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			

		
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}
	/**/ 
	public static function getAllDatosSimples(){		
		$co_ven = $_SESSION['identidad'];
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 AND (c.website = '$co_ven' OR c.co_ven = '$co_ven')
		ORDER BY c.co_cli ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefoo telefono2 correo
			$array[$cnt] = new ClienteData();  			
		
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
		
		
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}
	/**/

public static function getAllDatosSimplesCandidatos($filtro) {
    // 1. Obtenemos el vendedor de la sesión
    $co_ven = $_SESSION['identidad'];

    // 2. Preparamos la consulta SQL base y un array para los parámetros
    $sql = "SELECT 
                c.co_cli,
                c.rif,
                c.cli_des,
                c.telefonos,
                c.email,
                c.direc1,
                c.direc2,
				e.estado,
				c.contacto_cliente,
				c.contacto_telefono,
				c.foto,
				v.ven_des,

                (SELECT COUNT(*) 
                 FROM jm_visitas_candidatos v 

                 WHERE v.co_cand = c.co_cli) AS cantidad_visitas
            FROM jm_clientes_cand c 
			inner join vendedor v ON c.co_ven = v.co_ven
			inner join jm_parroquias p on c.id_parroquia = p.id_parroquia inner join jm_municipios m on p.id_municipio = m. id_municipio inner join jm_estados e on m.id_estado = e.id_estado
			
            WHERE c.estatus = 1 ";
    
    // Array que contendrá los valores para los marcadores de posición '?'
  

	
  if ($filtro == 'co_ven') {
	  $params = array($co_ven);
        // IMPORTANTE: Asumo que la columna de zona en tu tabla se llama 'co_zona'.
        // Debes cambiar 'co_zona' por el nombre real de tu columna si es diferente.
        $sql .= " AND c.co_ven = ?";
        // Añadimos el valor del filtro al array de parámetros
       
    }
    // 3. Lógica del filtro: Añadimos la condición de ZONA solo si $filtro es diferente de 0
    if ($filtro =='NO') {
        // IMPORTANTE: Asumo que la columna de zona en tu tabla se llama 'co_zona'.
        // Debes cambiar 'co_zona' por el nombre real de tu columna si es diferente.
    //    $sql .= " AND c.co_zona = ?";
        // Añadimos el valor del filtro al array de parámetros
       // $params[] = $filtro;
    }

	 if (($filtro !='NO') && ($filtro !='co_ven')) {
        // IMPORTANTE: Asumo que la columna de zona en tu tabla se llama 'co_zona'.
        // Debes cambiar 'co_zona' por el nombre real de tu columna si es diferente.
        $sql .= " AND c.co_zona = ?";
        // Añadimos el valor del filtro al array de parámetros
        $params[] = $filtro;
    }


    // 4. Añadimos la ordenación final
    $sql .= " ORDER BY c.co_cli ASC";

    // 5. Ejecutamos la consulta usando el método doittArr que soporta parámetros
    $query = Executor::doitArr($sql, $params);
	//echo $sql;
    // 6. El resto de tu código permanece igual
    $e = count($query);
    if ($e >= 1) {
        $array = array();
        $cnt = 0;
		$numero = 1;
        foreach ($query as $r) {
		
            $array[$cnt] = new ClienteData();  			
            $array[$cnt]->responsive_id = "";  
            $array[$cnt]->co_cli = $r['co_cli'];			
            $array[$cnt]->rif = $r['rif'];	
            $array[$cnt]->cli_des = $r['cli_des'];	
            $array[$cnt]->telefonos = $r['telefonos'];		
            $array[$cnt]->email = $r['email'];	
            $array[$cnt]->direc1 = $r['direc1'];	
            $array[$cnt]->direc2 = $r['direc2'];			
            $array[$cnt]->dato1 = $r['cantidad_visitas'];		
    $array[$cnt]->dato2 = $r['estado'];	
	 $array[$cnt]->foto = $r['foto'];	

	$array[$cnt]->dato4 = $r['contacto_cliente'];	
	$array[$cnt]->dato5 = $r['contacto_telefono'];	
	
	    $array[$cnt]->dato3 = $numero;	
		$array[$cnt]->dato6 = $r['ven_des'].' '. $r['estado'];		
			$numero++;	
            $cnt++;
        }
        return $array;
    } else {
        // Es una buena práctica devolver un array vacío en lugar de null o false
        return array();
    }
}
	
	public static function getAllDatosFiltrados($id){	

		/// Metodo para consultar todos los datos para el
			// solo para adminsitrador

			
			$sql ="SELECT c.co_cli, c.cli_des FROM ".self::$tablename." c WHERE  (c.website = '$id' OR c.co_ven = '$id') and c.inactivo = 0 ORDER BY c.co_cli ASC";	
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				
				foreach($query as $r) {
				$array[$cnt] = new ClienteData(); 
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_cli = $r['co_cli'];
				$array[$cnt]->cli_des = $r['cli_des'];
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
	} 

	
	public static function getAllDatosPrincipales(){	

			$co_ven = $_SESSION['identidad'];
			$tipo_ven = trim($_SESSION['tipo_ven']);
			/// Metodo para consultar todos los datos para el
				// solo para adminsitrador
				// Filtro por rango de fechas si están presentes

			
			//echo "Tipo de vendedor: $tipo_ven";
			$sql = "SELECT co_cli,cli_des,tipo,co_ven FROM ".self::$tablename." c 	WHERE   c.inactivo = 0 ";
			if($tipo_ven!='*') {
				$sql .= " AND c.co_ven = '$co_ven'";
			}else{
				$sql .= " AND (c.website = '$co_ven' OR c.co_ven = '$co_ven')";
			}
			
			$sql .= " ORDER BY c.co_cli ASC";
				
			//echo $sql;
			$query = Executor::doitAr($sql);
			$e=count($query);
			if($e>=1){
			$array = array();
			$cnt = 0;
			foreach($query as $r) {
				//nombre cedula fechaNacimiento  telefono telefono2 correo
				$array[$cnt] = new ClienteData();  			
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_cli = trim($r['co_cli']);			
				$array[$cnt]->cli_des = trim($r['cli_des']);	
				$array[$cnt]->tipo_precio = trim($r['tipo']);	
			
			
			
			$cnt++;
			}
			return $array;
			}else{
	
					$array = array();
					return $array;
			}
	}

	public function addLocalizacion(){
			
			$sql = "INSERT INTO jm_cliente_localizacion (co_cli,foto,localizacion,estatus) ";
			$sql .= "VALUES ('$this->co_cli','$this->foto','$this->localizacion','1')";
			//echo $sql;
			Executor::doitEx($sql);
	}

	public static function getAllDatosCLientesLocalizacion($filtro){	

			/// Metodo para consultar todos los datos para el
				// solo para adminsitrador
				$sql ="SELECT id,foto,localizacion FROM jm_cliente_localizacion cl WHERE cl.co_cli='$filtro'  ORDER BY cl.id ASC";	
				//echo $sql;
				$query = Executor::doitAr($sql);	
				$e=count($query);		
				if($e>=1){
					$array = array();
					$cnt = 0;	
					
					foreach($query as $r) {
					$array[$cnt] = new ClienteData(); 
					$array[$cnt]->responsive_id = "";  
					$array[$cnt]->id = $r['id'];
					$array[$cnt]->foto = $r['foto'];
					$array[$cnt]->localizacion = $r['localizacion'];
					$cnt++;
				}
				return $array;
				}else{
						$array = array();
						return $array;
				}
	} 
	


	public static function getAllDatosGrupos($co_cli){	

			$co_ven = $_SESSION['identidad'];
			$tipo_ven = trim($_SESSION['tipo_ven']);
			/// Metodo para consultar todos los datos para el
				// solo para adminsitrador
				// Filtro por rango de fechas si están presentes

			
			//echo "Tipo de vendedor: $tipo_ven";
			$sql = "SELECT 
			c.co_cli,
			c.cli_des,
			ISNULL(m.cli_des, 'UNICA') AS nombre_matriz,
			c.matriz 
			FROM clientes c 
			LEFT JOIN clientes m ON c.matriz = m.co_cli 
			WHERE c.inactivo = 0 AND c.co_cli = '$co_cli'";
			
			//echo $sql;
			$query = Executor::doitAr($sql);
			$e=count($query);
			if($e>=1){
			$array = array();
			$cnt = 0;
			foreach($query as $r) {
				//nombre cedula fechaNacimiento  telefono telefono2 correo
				$array[$cnt] = new ClienteData();  			
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->nombre_matriz = trim($r['nombre_matriz']);			
			
			$cnt++;
			}
			return $array;
			}else{
	
					$array = array();
					return $array;
			}
	}


	public static function getDatosClientes($filtro){	

		if($filtro==1){
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 
		ORDER BY c.co_cli ASC";	

		}else{

		$co_ven = $_SESSION['identidad'];
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 AND (c.website = '$co_ven' OR c.co_ven = '$co_ven')
		ORDER BY c.co_cli ASC";	

		}

		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$array[$cnt] = new ClienteData();  	
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = trim($r['co_cli']);			
			$array[$cnt]->rif = trim($r['rif']);	
			$array[$cnt]->cli_des = trim($r['cli_des']);	
			$array[$cnt]->telefonos = trim($r['telefonos']);		
			$array[$cnt]->email = trim($r['email']);	
			$array[$cnt]->direc1 = trim($r['direc1']);	
			$array[$cnt]->dir_ent2 = trim($r['dir_ent2']);			
			$array[$cnt]->des_tipo = trim($r['des_tipo']);
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}



public static function getAllDatosSimplesClientes($filtro) {
    // 1. Obtenemos el vendedor de la sesión
    $co_ven = $_SESSION['identidad'];

    // 2. Preparamos la consulta SQL base y un array para los parámetros
    $sql = " select 
	c.cli_des,
	c.co_cli,
	c.rif,
	c.respons,
	c.telefonos,
	v.ven_des,
	vc.fecha 
	from jm_visitas_cliente vc
	inner join clientes c on c.co_cli = vc.co_cli
	inner join vendedor v on vc.co_ven = v.co_ven
	inner join jm_clientes jc on jc.co_cli = c.co_cli
	 ";
    


    // 4. Añadimos la ordenación final
    $sql .= " ORDER BY c.co_cli ASC";

    // 5. Ejecutamos la consulta usando el método doittArr que soporta parámetros
    $query = Executor::doitArr($sql);
	//	echo $sql;
    // 6. El resto de tu código permanece igual
    $e = count($query);
    if ($e >= 1) {
        $array = array();
        $cnt = 0;
		$numero = 1;
        foreach ($query as $r) {
		
            $array[$cnt] = new ClienteData();  			
            $array[$cnt]->responsive_id = "";  
            $array[$cnt]->co_cli = $r['co_cli'];			
            $array[$cnt]->rif = $r['rif'];	
            $array[$cnt]->cli_des = $r['cli_des'];	
            $array[$cnt]->telefonos = $r['telefonos'];		
            $array[$cnt]->email = $r['email'];	
            $array[$cnt]->direc1 = $r['direc1'];	
            $array[$cnt]->direc2 = $r['direc2'];			
            $array[$cnt]->dato1 = $r['cantidad_visitas'];		
    $array[$cnt]->dato2 = $r['email'];	

	$array[$cnt]->dato4 = $r['email'];	
	$array[$cnt]->dato5 = $r['email'];	
	
	    $array[$cnt]->dato3 =$r['email'];	
		$array[$cnt]->dato6 = $r['ven_des'];		
			
            $cnt++;
        }
        return $array;
    } else {
        // Es una buena práctica devolver un array vacío en lugar de null o false
        return array();
    }
}
	
public static function getDataVisitasPlanificacion($filtro) {
    // 1. Obtenemos el vendedor de la sesión
    $co_ven = $_SESSION['identidad'];

    // 2. Preparamos la consulta SQL base
    $sql = " select * from jm_visitas_planificacion where co_ven ='$co_ven ' ";
    
    // 5. Ejecutamos la consulta
    $query = Executor::doitArr($sql);

    // 6. Procesamiento de resultados
    $e = count($query);
    if ($e >= 1) {
        $array = array();
        $cnt = 0;
        $numero = 1;
        $tipo = '';
        $detalles = '';
        
        foreach ($query as $r) {
            $tipo = $r['tipo'];

            if ($tipo == '1') {
                $cadena_codigos = $r['dato_extra1'];
                
                // Verificamos si la cadena contiene el separador '/'
                if (strpos($cadena_codigos, '/') !== false) {
                    // 1. Separamos los códigos
                    $codigos = explode('/', $cadena_codigos);
                    
                    // Limpiamos el array (quitamos espacios vacíos)
                    $codigos_limpios = array_filter(array_map('trim', $codigos));

                    if (!empty($codigos_limpios)) {
                        // 2. Preparamos los códigos para la consulta SQL (ponemos comillas simples)
                        $codigos_sql = "'" . implode("','", $codigos_limpios) . "'";

                        // 3. Consultamos los nombres (AJUSTA 'jm_clientes', 'co_cli' y 'nombre' según tu BD)
                        $sql_clientes = "SELECT cli_des FROM clientes WHERE co_cli IN ($codigos_sql)";
                        $query_clientes = Executor::doitArr($sql_clientes);

                        // 4. Construimos la lista de nombres
                        $nombres_encontrados = array();
                        if ($query_clientes && count($query_clientes) > 0) {
                            foreach ($query_clientes as $cli) {
                                $nombres_encontrados[] = trim($cli['cli_des']);
                            }
                        }
                        
                        // Si encontramos nombres, los mostramos separados por coma. Si no, mostramos el original.
                        $detalles = !empty($nombres_encontrados) ? implode('/ ', $nombres_encontrados) : $cadena_codigos;
                    } else {
                        $detalles = $cadena_codigos;
                    }
                } else {
                    // Si no tiene '/', es un solo código o algo diferente, lo dejamos igual
                    $detalles = $cadena_codigos;
                }

            } else {
                $detalles = 'Numero de candidatos : ' . $r['dato_extra1'];
            }

            $array[$cnt] = new ClienteData();  			
            $array[$cnt]->responsive_id = "";  
            $array[$cnt]->id = $r['id'];			
            $array[$cnt]->tipo = $r['tipo'];	
            $array[$cnt]->inicio = $r['inicio'];	
            $array[$cnt]->fin = $r['fin'];		
            $array[$cnt]->descripcion = $r['description'];	
            $array[$cnt]->dato_extra1 = $r['dato_extra1']; 
            $array[$cnt]->dato_extra2 = $r['dato_extra2'];			
            $array[$cnt]->dato_extra3 = $r['dato_extra3'];	
            $array[$cnt]->detalles = $detalles; // Aquí va la lista de nombres procesada
            $array[$cnt]->estatus = $r['estatus'];		
            
            $cnt++;
        }
        // CORRECCIÓN AQUÍ: Se quitaron los paréntesis
        return $array; 
    } else {
        return array();
    }
}


public static function getVisitasPorDia($fecha, $co_ven) {
    // Si no se pasó co_ven, usar el de la sesión
    if (empty($co_ven)) {
        $co_ven = $_SESSION['identidad'];
    }
    
    // Validar que la fecha tenga formato correcto
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
        return array(
            'success' => false,
            'message' => 'Formato de fecha inválido',
            'data' => []
        );
    }
    
    $array = array();
    $cnt = 0;
    
    // ========================================
    // 1. CONSULTA DE VISITAS A CLIENTES (EXISTENTE)
    // ========================================
    $sql_visitas_clientes = "SELECT 
                id,
                co_ven,
                co_cli,
                fecha,
                lat,
                lon,
                acc,
                observacion,
                contacto_des,
                contacto_telefono,
                foto,
                dato_extra,
                estatus
            FROM jm_visitas_cliente_corta 
            WHERE co_ven = '$co_ven' 
            AND CAST(fecha AS DATE) = '$fecha'
            ORDER BY fecha ASC";
    
    $query_visitas_clientes = Executor::doitArr($sql_visitas_clientes);
    
    if ($query_visitas_clientes && count($query_visitas_clientes) >= 1) {
        foreach ($query_visitas_clientes as $r) {
            // Buscar nombre del cliente
            $cliente_nombre = '';
            $co_cli = $r['co_cli'] ?? '';
            
            if (!empty($co_cli)) {
                $sql_cliente = "SELECT cli_des FROM clientes WHERE co_cli = '$co_cli'";
                $query_cliente = Executor::doitArr($sql_cliente);
                if ($query_cliente && count($query_cliente) > 0) {
                    $cliente_nombre = $query_cliente[0]['cli_des'];
                }
            }
            
            // Determinar si tiene ubicación
            $tiene_ubicacion = (!empty($r['lat']) && !empty($r['lon'])) ? true : false;
            
            // Determinar si tiene foto
            $tiene_foto = !empty($r['foto']) ? true : false;
            
            $array[$cnt] = array(
                'id' => $r['id'],
                'event_id' => $r['id'],
                'co_ven' => $r['co_ven'],
                'co_cli' => $co_cli,
                'cliente_nombre' => $cliente_nombre ?: 'Cliente no encontrado',
                'cliente_codigo' => $co_cli ?: '-',
                'fecha' => $r['fecha'],
                'hora' => date('H:i', strtotime($r['fecha'])),
                'fecha_completa' => $r['fecha'],
                'lat' => $r['lat'] ?? '',
                'lon' => $r['lon'] ?? '',
                'tiene_ubicacion' => $tiene_ubicacion,
                'acc' => $r['acc'] ?? '',
                'observacion' => $r['observacion'] ?? '',
                'observations' => $r['observacion'] ?? '', // Para compatibilidad
                'contacto_des' => $r['contacto_des'] ?? '',
                'contacto_telefono' => $r['contacto_telefono'] ?? '',
                'tiene_foto' => $tiene_foto,
                'foto' => $r['foto'] ?? '',
                'dato_extra' => $r['dato_extra'] ?? '',
                'estatus' => $r['estatus'] ?? 1,
                'visit_status' => 'visitado',
                'visitado_por' => $r['co_ven'] ?? $co_ven,
                'fecha_visita' => $r['fecha'],
                'tipo' => '1', // Tipo cliente
                'tipo_texto' => 'Cliente',
                'titulo' => 'Visita a cliente: ' . ($cliente_nombre ?: $co_cli),
                'descripcion' => 'Visita a cliente: ' . ($cliente_nombre ?: $co_cli),
                'origen' => 'visitas_clientes'
            );
            
            $cnt++;
        }
    }
    
    // ========================================
    // 2. CONSULTA DE VISITAS A CANDIDATOS
    // ========================================
    $sql_visitas_candidatos = "SELECT 
                id,
                co_ven,
                co_cand,
                fecha,
                lat,
                lon,
                acc,
                observacion,
                contacto_des,
                contacto_telefono,
                foto,
                dato_extra,
                estatus
            FROM jm_visitas_candidatos 
            WHERE co_ven = '$co_ven' 
            AND CAST(fecha AS DATE) = '$fecha'
            ORDER BY fecha ASC";
    
    $query_visitas_candidatos = Executor::doitArr($sql_visitas_candidatos);
    
    if ($query_visitas_candidatos && count($query_visitas_candidatos) >= 1) {
        foreach ($query_visitas_candidatos as $r) {
            // Buscar nombre del candidato
            $candidato_nombre = '';
            $co_cand = $r['co_cand'] ?? '';
            
            if (!empty($co_cand)) {
                $sql_candidato = "SELECT cli_des, contacto_cliente, contacto_telefono 
                                 FROM jm_clientes_cand 
                                 WHERE co_cli = '$co_cand'";
                $query_candidato = Executor::doitArr($sql_candidato);
                if ($query_candidato && count($query_candidato) > 0) {
                    $candidato_nombre = $query_candidato[0]['cli_des'];
                }
            }
            
            // Determinar si tiene ubicación
            $tiene_ubicacion = (!empty($r['lat']) && !empty($r['lon'])) ? true : false;
            
            // Determinar si tiene foto
            $tiene_foto = !empty($r['foto']) ? true : false;
            
            $array[$cnt] = array(
                'id' => $r['id'],
                'event_id' => $r['id'],
                'co_ven' => $r['co_ven'],
                'co_cand' => $co_cand,
                'cliente_nombre' => $candidato_nombre ?: 'Candidato no encontrado',
                'cliente_codigo' => $co_cand ?: '-',
                'fecha' => $r['fecha'],
                'hora' => date('H:i', strtotime($r['fecha'])),
                'fecha_completa' => $r['fecha'],
                'lat' => $r['lat'] ?? '',
                'lon' => $r['lon'] ?? '',
                'tiene_ubicacion' => $tiene_ubicacion,
                'acc' => $r['acc'] ?? '',
                'observacion' => $r['observacion'] ?? '',
                'observations' => $r['observacion'] ?? '',
                'contacto_des' => $r['contacto_des'] ?? '',
                'contacto_telefono' => $r['contacto_telefono'] ?? '',
                'tiene_foto' => $tiene_foto,
                'foto' => $r['foto'] ?? '',
                'dato_extra' => $r['dato_extra'] ?? '',
                'estatus' => $r['estatus'] ?? 1,
                'visit_status' => 'visitado',
                'visitado_por' => $r['co_ven'] ?? $co_ven,
                'fecha_visita' => $r['fecha'],
                'tipo' => '2', // Tipo candidato
                'tipo_texto' => 'Candidato',
                'titulo' => 'Visita a candidato: ' . ($candidato_nombre ?: $co_cand),
                'descripcion' => 'Visita a candidato: ' . ($candidato_nombre ?: $co_cand),
                'origen' => 'visitas_candidatos'
            );
            
            $cnt++;
        }
    }
    
    // ========================================
    // 3. CONSULTA DE REGISTROS DE CANDIDATOS (jm_clientes_cand)
    // ========================================
    $sql_registro_candidatos = "SELECT 
                co_cli as id,
                co_ven,
                cli_des,
                telefonos,
                direc1,
                direc2,
                rif,
                email,
                fecha_reg as fecha,
                lat,
                lon,
                contacto_cliente as contacto_des,
                contacto_telefono,
                foto,
                dato_extra,
                datoextra2,
                datoextra3,
                datoextra4,
                datoextra5,
                datoextra6,
                estatus
            FROM jm_clientes_cand 
            WHERE co_ven = '$co_ven' 
            AND CAST(fecha_reg AS DATE) = '$fecha'
            ORDER BY fecha_reg ASC";
    
    $query_registro_candidatos = Executor::doitArr($sql_registro_candidatos);
    
    if ($query_registro_candidatos && count($query_registro_candidatos) >= 1) {
        foreach ($query_registro_candidatos as $r) {
            // Determinar si tiene ubicación
            $tiene_ubicacion = (!empty($r['lat']) && !empty($r['lon'])) ? true : false;
            
            // Determinar si tiene foto
            $tiene_foto = !empty($r['foto']) ? true : false;
            
            $array[$cnt] = array(
                'id' => $r['id'],
                'event_id' => $r['id'],
                'co_ven' => $r['co_ven'],
                'co_cli' => $r['id'],
                'cliente_nombre' => $r['cli_des'] ?? 'Sin nombre',
                'cliente_codigo' => $r['id'] ?? '-',
                'fecha' => $r['fecha'],
                'hora' => $r['fecha'] ? date('H:i', strtotime($r['fecha'])) : '00:00',
                'fecha_completa' => $r['fecha'],
                'lat' => $r['lat'] ?? '',
                'lon' => $r['lon'] ?? '',
                'tiene_ubicacion' => $tiene_ubicacion,
                'acc' => 'REGISTRO_CANDIDATO',
                'observacion' => 'Registro de nuevo candidato',
                'observations' => 'Registro de nuevo candidato',
                'contacto_des' => $r['contacto_des'] ?? '',
                'contacto_telefono' => $r['contacto_telefono'] ?? '',
                'telefonos' => $r['telefonos'] ?? '',
                'direc1' => $r['direc1'] ?? '',
                'direc2' => $r['direc2'] ?? '',
                'rif' => $r['rif'] ?? '',
                'email' => $r['email'] ?? '',
                'dato_extra' => $r['dato_extra'] ?? '',
                'datoextra2' => $r['datoextra2'] ?? '',
                'datoextra3' => $r['datoextra3'] ?? '',
                'datoextra4' => $r['datoextra4'] ?? '',
                'datoextra5' => $r['datoextra5'] ?? '',
                'datoextra6' => $r['datoextra6'] ?? '',
                'tiene_foto' => $tiene_foto,
                'foto' => $r['foto'] ?? '',
                'estatus' => $r['estatus'] ?? 1,
                'visit_status' => 'registrado',
                'visitado_por' => $r['co_ven'] ?? $co_ven,
                'fecha_visita' => $r['fecha'],
                'tipo' => '3', // Tipo registro candidato
                'tipo_texto' => 'Registro Candidato',
                'titulo' => 'Registro de candidato: ' . ($r['cli_des'] ?? $r['id']),
                'descripcion' => 'Nuevo candidato registrado',
                'origen' => 'registro_candidatos'
            );
            
            $cnt++;
        }
    }
    
    // ========================================
    // 4. CONSULTA DE ENCUESTAS (jm_visitas_cliente)
    // ========================================
    $sql_encuestas = "SELECT 
                id,
                co_cli,
                co_ven,
                fecha,
                lat,
                lon,
                descripcion,
                dato_extra,
                estatus
            FROM jm_visitas_cliente 
            WHERE co_ven = '$co_ven' 
            AND CAST(fecha AS DATE) = '$fecha'
            ORDER BY fecha ASC";
    
    $query_encuestas = Executor::doitArr($sql_encuestas);
    
    if ($query_encuestas && count($query_encuestas) >= 1) {
        foreach ($query_encuestas as $r) {
            // Buscar nombre del cliente
            $cliente_nombre = '';
            $co_cli = trim($r['co_cli'] ?? '');
            
            if (!empty($co_cli)) {
                $sql_cliente = "SELECT cli_des FROM clientes WHERE co_cli = '$co_cli'";
                $query_cliente = Executor::doitArr($sql_cliente);
                if ($query_cliente && count($query_cliente) > 0) {
                    $cliente_nombre = $query_cliente[0]['cli_des'];
                }
            }
            
            // Determinar si tiene ubicación
            $tiene_ubicacion = (!empty($r['lat']) && !empty($r['lon'])) ? true : false;
            
            $array[$cnt] = array(
                'id' => $r['id'],
                'event_id' => $r['id'],
                'co_ven' => trim($r['co_ven'] ?? ''),
                'co_cli' => $co_cli,
                'cliente_nombre' => $cliente_nombre ?: 'Cliente no encontrado',
                'cliente_codigo' => $co_cli ?: '-',
                'fecha' => $r['fecha'],
                'hora' => $r['fecha'] ? date('H:i', strtotime($r['fecha'])) : '00:00',
                'fecha_completa' => $r['fecha'],
                'lat' => $r['lat'] ?? '',
                'lon' => $r['lon'] ?? '',
                'tiene_ubicacion' => $tiene_ubicacion,
                'acc' => 'ENCUESTA',
                'observacion' => $r['descripcion'] ?? 'Encuesta realizada',
                'observations' => $r['descripcion'] ?? 'Encuesta realizada',
                'descripcion' => $r['descripcion'] ?? '',
                'contacto_des' => '',
                'contacto_telefono' => '',
                'dato_extra' => $r['dato_extra'] ?? '',
                'tiene_foto' => false,
                'foto' => '',
                'estatus' => $r['estatus'] ?? 1,
                'visit_status' => 'encuesta',
                'visitado_por' => trim($r['co_ven'] ?? $co_ven),
                'fecha_visita' => $r['fecha'],
                'tipo' => '4', // Tipo encuesta
                'tipo_texto' => 'Encuesta',
                'titulo' => 'Encuesta a cliente: ' . ($cliente_nombre ?: $co_cli),
                'descripcion' => $r['descripcion'] ?? 'Encuesta realizada',
                'origen' => 'encuestas'
            );
            
            $cnt++;
        }
    }
    
    // Ordenar el array combinado por fecha/hora
    usort($array, function($a, $b) {
        return strtotime($a['fecha']) - strtotime($b['fecha']);
    });
    
    return array(
        'success' => true,
        'data' => $array,
        'fecha' => $fecha,
        'total' => count($array),
        'totales_por_tipo' => array(
            'visitas_clientes' => count(array_filter($array, function($item) { return $item['origen'] == 'visitas_clientes'; })),
            'visitas_candidatos' => count(array_filter($array, function($item) { return $item['origen'] == 'visitas_candidatos'; })),
            'registro_candidatos' => count(array_filter($array, function($item) { return $item['origen'] == 'registro_candidatos'; })),
            'encuestas' => count(array_filter($array, function($item) { return $item['origen'] == 'encuestas'; }))
        ),
        'mensaje' => count($array) > 0 ? 'Registros encontrados' : 'No hay registros para esta fecha'
    );
}
// ========================================
// FUNCIÓN PARA OBTENER ESTADOS DE VISITA
// ========================================
public static function getEstadosVisita() {
    // 1. Obtenemos el vendedor de la sesión
    $co_ven = $_SESSION['identidad'];

    // 2. Preparamos la consulta SQL para obtener los estados de visita
     $sql = " select id as event_id, 
                estatus as visit_status,
                estatus as  observaciones,
                fecha as visit_date,
                fecha as fecha_registro  from jm_visitas_cliente where co_ven ='$co_ven ' ";
	
   // echo $sql;
    // 3. Ejecutamos la consulta
    $query = Executor::doitArr($sql);
    
    // 4. Procesamos los resultados
    $e = count($query);
    if ($e >= 1) {
        $array = array();
        $cnt = 0;
        
        foreach ($query as $r) {
            $array[$cnt] = array(
                'event_id' => $r['event_id'],
                'visit_status' => $r['visit_status'],
                'observations' => $r['observaciones'] ?? '',
                'visit_date' => $r['visit_date'],
                'registered_at' => $r['fecha_registro']
            );
            $cnt++;
        }
        
        return array(
            'success' => true,
            'data' => $array,
            'message' => 'Estados de visita cargados correctamente'
        );
    } else {
        return array(
            'success' => true,
            'data' => [],
            'message' => 'No hay estados de visita registrados'
        );
    }
}


	
	// ========================================
	// FUNCIÓN PARA SALDOS CORRESPONDIENTES AL CLIENTE
	// ========================================
	public static function getSaldosClientes($sucursales,$rifs) {
		$buscar_total ="";
		//var_dump($rifs);
		// 1. Obtenemos el vendedor de la sesión
		$co_ven = $_SESSION['identidad'];
		//echo $sucursales;
		// 2. Preparamos la consulta SQL para obtener los estados de visita
		if($sucursales=='TODAS'){
		if (!empty($rifs)) {
				// Si se proporcionó una lista de sucursales, filtramos por ellas
				$sucursales_sql = "'" . implode("','", array_map('trim', explode(',', $rifs))) . "'";
				$buscar_total = "d.co_cli IN ($sucursales_sql,'$co_ven')";
			}

		}
		if($sucursales!='UNICA'){
		$co_cli = $co_ven = $_SESSION['identidad'];
		$buscar_total = "d.co_cli IN ('$co_cli')";
		
		}
	
		$sql = " 
			SELECT 
				d.co_cli,
				MAX(c.cli_des) as cliente,
				MAX(15) as dias_credito,
				
				-- ============ SALDOS POR ESTADO ============
				
				-- SALDOS POR VENCER (dentro del plazo de crédito)
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) <= ISNULL(15, 0)
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as saldos_por_vencer,
				
				-- SALDOS VENCIDOS (fuera del plazo de crédito)
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) > ISNULL(15, 0)
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as saldos_vencidos,
				
				-- ============ CANTIDAD DE DOCUMENTOS POR ESTADO ============
				
				-- CANTIDAD DE DOCUMENTOS POR VENCER
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) <= ISNULL(15, 0)
						THEN 1 
						ELSE 0 
					END) as docs_por_vencer,
				
				-- CANTIDAD DE DOCUMENTOS VENCIDOS
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) > ISNULL(15, 0)
						THEN 1 
						ELSE 0 
					END) as docs_vencidos,
				
				-- ============ RANGOS DETALLADOS ============
				
				-- Rango 0-3 días
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) BETWEEN 0 AND 3 
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as rango_0_3,
				
				-- Rango 4-7 días
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) BETWEEN 4 AND 7 
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as rango_4_7,
				
				-- Rango 8-15 días
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) BETWEEN 8 AND 15 
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as rango_8_15,
				
				-- Rango 16-30 días
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) BETWEEN 16 AND 30 
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as rango_16_30,
				
				-- Rango +30 días
				SUM(CASE 
						WHEN DATEDIFF(day, d.fec_emis, GETDATE()) > 30 
						THEN CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
								ELSE d.saldo/d.tasa END 
						ELSE 0 
					END) as rango_mas_30,
				
				-- TOTAL
				SUM(CASE WHEN ISNULL(d.tasa, 0) = 0 THEN 0 
						ELSE d.saldo/d.tasa END) as total_saldo,
				
				-- Cantidad total de documentos
				COUNT(d.nro_doc) as total_docs

			FROM docum_cc d
			INNER JOIN clientes c ON d.co_cli = c.co_cli
			WHERE $buscar_total  
			AND d.saldo > 0 
			AND d.anulado = 0
			GROUP BY d.co_cli";
		
		//echo $sql;
		// 3. Ejecutamos la consulta
		$query = Executor::doitArr($sql);
		
		// 4. Procesamos los resultados
		$e = count($query);
		if ($e >= 1) {
			$array = array();
			$cnt = 0;
			
			foreach ($query as $r) {
				$array[$cnt] = array(
					'rango03' => $r['rango_0_3']?? '',
					'rango47' => $r['rango_4_7']?? '',
					'rango815' => $r['rango_8_15'] ?? '',
					'rango1630' => $r['rango_16_30']?? '',
					'rango31' => $r['rango_mas_30']?? '',
					'total_saldo' => $r['total_saldo']?? '',
					'total_docs' => $r['total_docs']?? '',
					'dias_credito' => $r['dias_credito']?? '',
					'saldos_por_vencer' => $r['saldos_por_vencer']?? '',
					'saldos_vencidos' => $r['saldos_vencidos']?? '',
					'docs_por_vencer' => $r['docs_por_vencer']?? '',
					'docs_vencidos' => $r['docs_vencidos']?? ''
				);
				$cnt++;
			}
			
			return array(
				'success' => true,
				'data' => $array,
				'message' => 'Saldos correspondientes al cliente cargados correctamente'
			);
		} else {
			return array(
				'success' => true,
				'data' => [],
				'message' => 'No hay saldos registrados para este cliente'
			);
		}
	}


   
	

}
?>