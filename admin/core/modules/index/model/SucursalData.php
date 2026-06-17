<?php
class SucursalData {
	public static $tablename = "almacen";	
		public function __construct(){	
		$this->co_alma ='';		
		$this->alma_des ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT a.co_alma, a.alma_des FROM ".self::$tablename." a	ORDER BY a.co_alma ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new BancoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_alma = $r['co_alma'];
			$array[$cnt]->alma_des = $r['alma_des'];
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