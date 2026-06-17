<?php
class TipoData {
	public static $tablename = "jm_type";
	
	public $responsive_id;
	public $id;
	public $tipo;
	public $status;

	public function __construct(){
		$this->id = '0';
		$this->tipo = "";	
		$this->status = "0";
	}	

	
	public function add(){
	
		$sql = "INSERT INTO ".self::$tablename." (tipo,status) ";
		$sql .= "VALUES ('$this->tipo',1)";
		//echo $sql;
		Executor::doitEx($sql);
	}
	


	public static function getAll(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT *  FROM ".self::$tablename." t ";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new TipoData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->id = $r['id'];
				$array[$cnt]->tipo = $r['tipo'];			
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


	public function edit(){
		
		$sql = "update ".self::$tablename." set tipo='$this->tipo' where id='$this->id'";
	//	echo $sql;
		Executor::doitEx($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estatus=0 where id=$this->id";
		Executor::doit($sql);
	}
	public function act(){
		$sql = "update ".self::$tablename." set estatus=1 where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id='$id'";
		//echo $sql;
		$query = Executor::doitAr($sql);
		$array = array();
		$cnt = 0;
		$e=count($query);
		if($e>=1){

		$array = array();
			$cnt = 0;	
			foreach($query as $r) {

			$array[$cnt] = new TipoData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->tipo = $r['tipo'];	
			
			$array[$cnt]->estatus = $r['estatus'];	
				
		$cnt++;
		}
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