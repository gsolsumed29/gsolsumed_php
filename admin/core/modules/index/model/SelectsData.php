<?php
class SelectsData {
	public static $tablename = "municipios";
	
	public function __construct(){
		$this->id = '0';
		$this->data = '0';
		$this->responsive_id = "";	

	}	


	public static function getAllEstados(){
		$sql = "SELECT *  FROM jm_estados ORDER BY estado ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new SelectsData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id_estado'];
			$array[$cnt]->data = $r['estado'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	
	public static function getByCampoEstados($tabla,$campo,$valor){
		$sql = "SELECT m.id_municipio,m.municipio,e.id_estado  FROM ".$tabla." m INNER JOIN jm_estados e ON m.id_estado = e.id_estado WHERE $campo='$valor'  ORDER BY m.municipio ASC";
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new SelectsData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id_municipio'];
			$array[$cnt]->data = $r['municipio'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		};
	}

		
	public static function getByCampoEstadosCiudades($tabla,$campo,$valor){
		$sql = "SELECT m.id_ciudad,m.ciudad,e.id_estado  FROM ".$tabla." m INNER JOIN jm_estados e ON m.id_estado = e.id_estado WHERE $campo='$valor'  ORDER BY m.ciudad ASC";
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new SelectsData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id_ciudad'];
			$array[$cnt]->data = $r['ciudad'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		};
	}



	public static function getByCampoMunicipios($tabla,$campo,$valor){
		$sql = "SELECT m.id_parroquia,m.parroquia,e.id_municipio  FROM ".$tabla." m INNER JOIN jm_municipios e ON m.id_municipio = e.id_municipio WHERE $campo='$valor'  ORDER BY m.parroquia ASC";
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new SelectsData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id_parroquia'];
			$array[$cnt]->data = $r['parroquia'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		};
	}


	
}
?>