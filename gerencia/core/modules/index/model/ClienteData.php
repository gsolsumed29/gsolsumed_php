<?php
class ClienteData {
	public static $tablename = "clientes";
	//c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo 
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

	}

	public function add(){
		$sql = "insert into ".self::$tablename." (nombre,cedula,fechaNacimiento,telefono,telefono2,correo,estatus) ";
		$sql .= "value (\"$this->nombre\",\"$this->cedula\",\"$this->fechaNacimiento\",\"$this->telefono\",\"$this->telefono2\",\"$this->correo\",'1')";
		//echo $sql;
		Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET nombre=\"$this->nombre\",cedula=\"$this->cedula\",fechaNacimiento=\"$this->fechaNacimiento\",telefono=\"$this->telefono\",telefono2=\"$this->telefono2\",correo=\"$this->correo\"  where id=$this->id";
		//echo $sql;
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estatus=0 where id='$this->id'";
		Executor::doit($sql);
	}

	public function delF(){
		$sql = "DELETE FROM  ".self::$tablename." where id='$this->id'";
		Executor::doit($sql);
	}
	


	public static function getAllDatos(){
		$co_ven = $_SESSION['identidad'];
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 AND c.co_ven = '$co_ven'
		ORDER BY c.co_cli ASC";	
		echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$array[$cnt] = new ClienteData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function getDataFiltrada($filtro){

		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE c.co_cli = '".$filtro."' AND c.inactivo = 0 
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
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}
	
}
?>