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
		$this->status ='0';
		$this->isTrue ='0';
	}

	public function add(){
		date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
		$sql = "INSERT INTO ".self::$tablename." (email,password,rol,co_ven,co_sub,co_alma,created,status) ";
		$sql .= "VALUES ('$this->email','$this->password',$this->rol,'$this->co_ven','$this->co_sub','$this->co_alma','$date',1)";
		//echo $sql;
		Executor::doitEx($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estatus=0 where id='$this->id'";
		Executor::doit($sql);
	}
	
	public function delF(){
		$sql = "DELETE FROM  ".self::$tablename." where id='$this->id'";
		Executor::doit($sql);
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
	public  function loginTime(){
		date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
		//echo $date;
		$sql = "UPDATE ".self::$tablename." SET lastLogin='$date' WHERE email='$this->email'";
		//echo $sql;	
		return $query=Executor::doitEx($sql);
		
	}

	public static function login($email,$password){
		$sql = "SELECT  u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,v.ven_des,v.co_ven,s.co_sub,u.co_ven,u.co_alma  FROM ".self::$tablename." u 
		INNER JOIN vendedor v ON v.co_ven = u.co_ven
		INNER JOIN sub_alma s ON s.co_sub = u.co_sub
		WHERE u.email='$email' AND u.password ='$password' AND status = 1";
		//echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query){
			$data->id = $r['id'];
			$data->name = $r['ven_des'];
			$data->email = $r['email'];	
			$data->image = $r['image'];	
			$data->created = $r['created'];	
			$data->codVendedor = $r['co_ven'];			
			$data->rol = $r['rol'];
			$data->co_sub = $r['co_sub'];
			$data->co_ven = $r['co_ven'];
			$data->co_alma = $r['co_alma'];
			$data->status = $r['status'];
			$found = $data;
			break;
		}
		return $found;
	}
	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",telefono=\"$this->telefono\",direccion=\"$this->direccion\"  where nombreUsuario='$this->nombreUsuario'";
		Executor::doit($sql);
	}
	
	public function updatePassword(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where nombreUsuario='$this->nombreUsuario'";
		//echo $sql;
		Executor::doit($sql);
	}

	

	public static function getAllDatos(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,v.ven_des,u.password,s.des_sub  FROM ".self::$tablename." u 
		INNER JOIN vendedor v ON v.co_ven = u.co_ven
		INNER JOIN sub_alma s ON s.co_sub = u.co_sub
		WHERE u.rol=2 ORDER BY u.id ASC";	
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


	
	public static function getDataObjeto($objeto){
		$sql = "SELECT u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,v.ven_des,u.password  FROM ".self::$tablename." u INNER JOIN vendedor v ON v.co_ven = u.co_ven WHERE u.email = '".$objeto."' AND u.rol=2 ORDER BY u.id ASC";	
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
				$array[$cnt]->lastLogin = $r['lastLogin'];	
				$array[$cnt]->created = $r['created'];	
				$array[$cnt]->image = $r['image'];		
				$array[$cnt]->password = $r['password'];
			
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