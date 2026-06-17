<?php
class UserData {
	public static $tablename = "jm_users";
	
	public function __construct(){
		$this->responsive_id = '';
		$this->id = '0';
		$this->name = "";
		$this->email = "";	
		$this->password = "";
		$this->bio ="";
		$this->image ="no_image.jpg";
		$this->rol ="0";
		$this->created = "";	
		$this->lastLogin = "";	
		$this->co_ven = "";	
		$this->co_sub = "";
		$this->co_alma = "";
		$this->data1 = "";
		$this->data2 = "";
		$this->status ='0';
		$this->isTrue ='0';
	}

	public function add(){
		date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
		$sql = "INSERT INTO ".self::$tablename." (email,password,rol,bio,co_ven,co_sub,co_alma,created,status) ";
		$sql .= "VALUES ('$this->email','$this->password',$this->rol,'$this->bio','$this->co_ven','$this->co_sub','$this->co_alma','$date',1)";
		//echo $sql;
		Executor::doitEx($sql);
	}

	public function delL(){
		$sql = "UPDATE ".self::$tablename." SET status=0 WHERE id=$this->id";
		Executor::doitEx($sql);
	}

	public function activar(){
		$sql = "UPDATE ".self::$tablename." SET status=1 WHERE id=$this->id";
		Executor::doitEx($sql);
	}

	public function cambiarClave(){
		$sql = "UPDATE ".self::$tablename." SET password='".$this->password."' WHERE id=$this->id";
		Executor::doitEx($sql);
	}
	
	public function delF(){
		$sql = "DELETE FROM  ".self::$tablename." WHERE id=$this->id";
		Executor::doitEx($sql);
	}
	
	public  function radomPassword(){
		$alphabet = "0123456789ABCDEFGHIJKLMNOPQSTUWXYZabcdefghijqlmnopqrstuvwxyz";
		$pass = array(); //recuerde que debe declarar $pass como un array
		$alphaLength = strlen($alphabet) - 1; //poner la longitud -1 en caché
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //convertir el array en una cadena
	}				
	
	
	public static function foundId($email){
		$sql = "select count(id) as cuenta from ".self::$tablename." where nombreUsuario='$email'";
		//echo $sql;	
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}

	public static function foundMail($email){
		$sql = "select id from ".self::$tablename." where nombreUsuario='$email'";
		//echo $sql;	
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}

	// partiendo de que ya tenemos creado un objecto StatusData previamente utilizamos el contexto
	public  function loginTime($email){
		date_default_timezone_set('America/Caracas');
		$date = strftime("%Y-%m-%d %H:%M:%S", time());
		//echo $date;
		$sql = "UPDATE ".self::$tablename." SET lastLogin='$date' WHERE email='$email'";
		//echo $sql;	
		return $query=Executor::doitEx($sql);
		
	}

	public static function login_vendedor($co_ven){
		$sql = "SELECT v.campo1 as tipoVendedor ,u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.bio,u.isTrue,u.status,v.ven_des,v.co_ven,s.co_sub,u.co_ven,u.co_alma,v.campo8 as co_us FROM ".self::$tablename." u 
		INNER JOIN vendedor v ON v.co_ven = u.co_ven
		INNER JOIN sub_alma s ON s.co_sub = u.co_sub
		WHERE v.co_ven='$co_ven'";
	//	echo  $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query){
			$objeto_tasa = New PagoData();
			$data2 = $objeto_tasa->tasa();

			$data->id = $r['id'];
			$data->name = $r['ven_des'];
			$data->email = $r['email'];	
			$data->image = $r['image'];	
			$data->created = $r['created'];	
			$data->codVendedor = $r['co_ven'];		
			$data->co_us = $r['co_us'];	
			$data->rol = $r['rol'];
			$data->bio = $r['bio'];		
			$data->tipo_ven = $r['tipoVendedor'];	 // Tipo de vendedor	
			$data->co_sub = $r['co_sub']; 	
			$data->co_ven = $r['co_ven'];
			$data->co_alma = $r['co_alma'];
			$data->status = $r['status'];
			$data->tasa = $data2 ['tasa'];
			$found = $data;
			break;
		}
		return $found;
	}

		public static function login_jmPersona_cliente($co_ocupa){
		$sql = "SELECT ju.bio,jp.id,c.cli_des,c.email,ju.image,ju.created,ju.co_ven,ju.rol,ju.co_sub,ju.co_alma,ju.status FROM jm_personas jp
		 INNER JOIN jm_users ju ON jp.co_ocupa = ju.co_ven 
		INNER JOIN clientes c ON jp.co_ocupa = c.co_cli
		WHERE jp.co_ocupa='$co_ocupa'";
		//	echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query){		
		$objeto_tasa = New PagoData();
			$data2 = $objeto_tasa->tasa();

			$data->id = $r['id'];
			$data->name = $r['cli_des'];
			$data->email = $r['email'];	
			$data->image = $r['image'];	
			$data->created = $r['created'];	
			$data->codVendedor = $r['co_ven'];		
			$data->co_us = 0;	
			$data->rol = $r['rol'];
			$data->bio = $r['bio'];		
			$data->tipo_ven = $r['rol'];	 // Tipo de vendedor	
			$data->co_sub = $r['co_sub']; 	
			$data->co_ven = $r['co_ven'];
			$data->co_alma = $r['co_alma'];
			$data->status = $r['status'];
			$data->tasa = $data2 ['tasa'];
			$found = $data;
			break;
		}
		return $found;
	}


	
	

	public static function login_jmPersona_matriz($co_user){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT
				m.co_cli      AS co_cli_matriz,
				m.cli_des     AS matriz,
				LTRIM(RTRIM(m.rif)) AS rif_matriz,

				s.co_cli      AS co_cli_sucursal,
				s.cli_des     AS sucursal,
				LTRIM(RTRIM(s.rif)) AS rif_sucursal
			FROM clientes m
			LEFT JOIN clientes s
				ON LTRIM(RTRIM(s.matriz)) = LTRIM(RTRIM(m.rif))
			AND s.tipo_adi = 3
			WHERE m.tipo_adi = 2 and m.co_cli in ('$co_user')
			ORDER BY m.cli_des, s.cli_des;";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new UserData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_cli_matriz = $r['co_cli_matriz'];
				$array[$cnt]->matriz = $r['matriz'];
				
				$array[$cnt]->rif_matriz = $r['rif_matriz'];	
				$array[$cnt]->co_cli_sucursal = $r['co_cli_sucursal'];		
				$array[$cnt]->sucursal = $r['sucursal'];		
				$array[$cnt]->rif_sucursal = $r['rif_sucursal'];	
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}

	public static function login_jmPersona($co_ocupa){
		$sql = "SELECT * FROM jm_personas jp INNER JOIN jm_users ju ON jp.co_ocupa = ju.co_ven WHERE jp.co_ocupa='$co_ocupa'";
	//	echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query){		

			$data->id = $r['id'];
			$data->name = $r['persona_des'];
			$data->email = $r['email'];	
			$data->image = $r['image'];	
			$data->created = $r['created'];	
			$data->codVendedor = $r['co_ven'];		
			$data->co_us = 0;	
			$data->rol = $r['rol'];
			$data->bio = $r['bio'];		
			$data->tipo_ven = $r['rol'];	 // Tipo de vendedor	
			$data->co_sub = $r['co_sub']; 	
			$data->co_ven = $r['co_ven'];
			$data->co_alma = $r['co_alma'];
		
			$data->status = $r['status'];
		
			$found = $data;
			break;
		}
		return $found;
	}

	public static function login($email,$password){
		
		$sql = "SELECT  id,rol,co_ven,status FROM ".self::$tablename." u  WHERE u.email='$email' AND u.password ='$password'";
	//	echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query){
			$data->rol = $r['rol'];
			$data->id = $r['id'];
			$data->co_ven = $r['co_ven'];	
			$data->status = $r['status'];
			$found = $data;
			break;
		}
		return $found;
	}

	
	public function updatePassword(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where nombreUsuario='$this->nombreUsuario'";
		//echo $sql;
		Executor::doit($sql);
	}




	

	public static function getAllDatos(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.bio,u.status,v.ven_des,u.password,s.des_sub,a.alma_des  FROM ".self::$tablename." u 
		INNER JOIN vendedor v ON v.co_ven = u.co_ven
		INNER JOIN sub_alma s ON s.co_sub = u.co_sub
		INNER JOIN almacen a ON s.co_alma = a.co_alma
		WHERE u.rol=2 OR u.rol=3 or u.rol=4 or u.rol = 5 ORDER BY u.id ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new UserData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->name = $r['ven_des'];
				
				$array[$cnt]->email = $r['email'];	
				$array[$cnt]->rol = $r['rol'];		
				$array[$cnt]->bio = $r['bio'];		
				$array[$cnt]->lastLogin = $r['lastLogin'];	
				$array[$cnt]->created = $r['created'];	
				$array[$cnt]->image = $r['image'];		
				$array[$cnt]->password = $r['password'];
				$array[$cnt]->data1 = $r['des_sub'];
				$array[$cnt]->data2 = $r['alma_des'];
				$array[$cnt]->isTrue = $r['isTrue'];		
				$array[$cnt]->status = $r['status'];			
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}


	
	public static function getDataObjeto($objeto){
		$sql = "SELECT u.id,u.email,u.rol,u.lastLogin,u.bio,u.image,u.created,u.isTrue,u.status,v.ven_des,u.password,s.des_sub  FROM ".self::$tablename." u 
		INNER JOIN vendedor v ON v.co_ven = u.co_ven
		INNER JOIN sub_alma s ON s.co_sub = u.co_sub		
		WHERE u.email = '".$objeto."'  ORDER BY u.id ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new UserData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->name = $r['ven_des'];
				
				$array[$cnt]->email = $r['email'];	
				$array[$cnt]->rol = $r['rol'];	
				$array[$cnt]->bio = $r['bio'];			
				$array[$cnt]->lastLogin = $r['lastLogin'];	
				$array[$cnt]->created = $r['created'];	
				$array[$cnt]->image = $r['image'];		
				$array[$cnt]->password = $r['password'];
				$array[$cnt]->data1 = $r['des_sub'];
				$array[$cnt]->isTrue = $r['isTrue'];		
				$array[$cnt]->status = $r['status'];			
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}

}
?>