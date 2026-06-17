<?php
class CuentaData {
	public static $tablename = "cuentas";	
		public function __construct(){	
		$this->cod_cta ='';		
		$this->co_banco ='';		
		$this->num_cta ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT c.cod_cta, c.num_cta FROM ".self::$tablename." c	ORDER BY c.cod_cta ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new CuentaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cod_cta = $r['cod_cta'];
			$array[$cnt]->num_cta = $r['num_cta'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getAllDatosFiltrados($id){	

	/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT c.cod_cta, c.num_cta FROM ".self::$tablename." c WHERE c.co_banco='$id' ORDER BY c.cod_cta ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new CuentaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cod_cta = $r['cod_cta'];
			$array[$cnt]->num_cta = $r['num_cta'];
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