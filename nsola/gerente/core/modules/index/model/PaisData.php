<?php
class PaisData {
	public static $tablename = "paises";
	
	public function __construct(){
		$this->codigo = '0';
		$this->pais = "";	

	}	

	public static function getAll(){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY Pais ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PaisData();    
			$array[$cnt]->codigo = $r['Codigo'];
			$array[$cnt]->pais = $r['Pais'];		
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