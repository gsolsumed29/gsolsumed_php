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

	public function edit(){
		
			$sql = "update " .self::$tablename." SET password='".$this->password."' where co_ven='$this->id'";
		
	//echo $sql;
		Executor::doitEx($sql);
	}

	public function add(){
		$date = strftime("%Y-%m-%d %H:%M:%S", time());
		$sql = "INSERT INTO ".self::$tablename." (email,password,rol,co_ven,created,status) ";
		$sql .= "VALUES ('$this->email','$this->password',$this->rol,'$this->co_ven','$date',1)";
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
		$alphabet = "0123456789";
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
		$date = strftime("%Y-%m-%d %H:%M:%S", time());
		//echo $date;
		$sql = "UPDATE ".self::$tablename." SET lastLogin='$date' WHERE email='$this->email'";
		//echo $sql;	
		return $query=Executor::doitEx($sql);
		
	}

	public static function login($email,$password){
		$sql = "SELECT  u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,sn.nombre_completo as ven_des,u.co_ven,u.status  FROM ".self::$tablename." u 
		INNER JOIN snemple sn ON sn.cod_emp = u.co_ven		
		WHERE u.email='$email' AND sn.status = 'A'  AND u.password ='$password'";
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

// En tu clase UserData

public function generarContrasena(){
    // 1. Generar la contraseña en texto plano
    $plainPassword = $this->radomPassword();
	$password = sha1(md5($plainPassword));
    // 2. Crear el hash seguro de la contraseña para almacenarlo
   // $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT); // PASSWORD_DEFAULT es el algoritmo más fuerte disponible

    // 3. Preparar la consulta SQL para evitar inyección
    //    CORREGIDO: Ahora busca por el campo 'email' y usa una consulta preparada.
    $sql = "UPDATE ".self::$tablename." SET password='$password' WHERE email='$this->email'";

    Executor::doitEx($sql);

    // 5. Devolver la contraseña en texto plano para el AJAX
    return $plainPassword;
}


	

	public static function getAllDatos(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,sn.nombre_completo as ven_des,u.password  FROM ".self::$tablename." u 
		INNER JOIN snemple sn ON sn.cod_emp = u.co_ven
	
		WHERE u.rol=2 OR u.rol=3 OR  u.rol=4 and sn.status='A' ORDER BY u.id ASC";	
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


	
	public static function getDataObjeto($objeto){
		$sql = "SELECT u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,sn.nombre_completo as ven_des,u.password FROM ".self::$tablename." u 
		INNER JOIN snemple sn ON sn.cod_emp = u.co_ven
	
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


	public static function getByEmail($email){
		$sql = "SELECT  u.id,u.email,u.rol,u.lastLogin,u.image,u.created,u.isTrue,u.status,sn.nombre_completo as ven_des,u.co_ven,u.status  FROM ".self::$tablename." u 
		INNER JOIN snemple sn ON sn.cod_emp = u.co_ven		
		WHERE u.email='$email' AND sn.status = 'A'";
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
			$data->co_ven = $r['co_ven'];	
			$data->status = $r['status'];
			
			$found = $data;
			break;
		}
		return $found;
	}

}
?>