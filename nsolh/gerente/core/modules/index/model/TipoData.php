<?php
class TipoData {
	public static $tablename = "tipo";
	
	public function __construct(){
		$this->id = '0';
		$this->tipo = "";	
		$this->estatus = "0";	
		$this->marca = "";	
		$this->idTipo = "";	
		$this->idMarca = "";	
		$this->modelo = "";	


	}	
	public static function getAllDatos(){	

		$sql = "SELECT * FROM ".self::$tablename." WHERE estatus = 1 ";
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TipoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->tipo = $r['tipo'];			
			$cnt++;		}
		return $array;
	}


	public static function getAllDatosFiltrados($id){	

		$sql = "SELECT * FROM marca m WHERE m.idTipo = $id ";
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TipoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->marca = $r['marca'];			
			$cnt++;		}
		return $array;
	} 
	

	public static function getAllDatosFiltrados2($id){	

		$sql = "SELECT * FROM modelo m WHERE m.idMarca = $id ";
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TipoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->modelo = $r['modelo'];			
			$cnt++;		}
		return $array;
	} 

	public static function getData($id){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY tipo ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TipoData();    
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->tipo = $r['tipo'];		
		$cnt++;
		}
		return $array;
	}

	
	public static function getAllDatos2(){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY estado ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EstadoData();    
			$array[$cnt]->id = $r['estado'];
			$array[$cnt]->estado = $r['estado'];		
		$cnt++;
		}
		return $array;
	}
	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE Codigo='$id'";
		//echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new PaisData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['Codigo'];
			$data->pais = $r['Pais'];			
			$found = $data;
			break;
		}
		return $found;
	}

	
}
?>