<?php
class MonedaData {
	public static $tablename = "moneda";	
		public function __construct(){
		$this->co_mone = 0;		$this->mone_des = "";				
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT m.co_mone, m.mone_des FROM ".self::$tablename." m	ORDER BY m.co_mone ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new MonedaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_mone = $r['co_mone'];
			$array[$cnt]->mone_des = $r['mone_des'];
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