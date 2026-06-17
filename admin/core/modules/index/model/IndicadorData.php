<?php
class IndicadorData {
	public static $tablename = "jm_type";	
		public function __construct(){
		$this->co_sub = 0;		$this->des_sub = "";				
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT t.id as dato1,t.tipo as dato2 FROM ".self::$tablename." t	ORDER BY t.id ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new IndicadorData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->dato1 = $r['dato1'];
			$array[$cnt]->dato2 = $r['dato2'];
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