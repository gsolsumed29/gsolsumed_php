<?php
class CiudadData {
	public static $tablename = "municipios";
	
	public function __construct(){
		$this->id = '0';
		$this->municipio = "";	

	}	

	public static function getAll(){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY municipio ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CiudadData();    
			$array[$cnt]->id = $r['municipio'];
			$array[$cnt]->municipio = $r['municipio'];		
		$cnt++;
		}
		return $array;
	}

	public static function getData($id){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY municipio ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CiudadData();    
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->municipio = $r['municipio'];		
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