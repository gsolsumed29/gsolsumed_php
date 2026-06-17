<?php
class FormaPagoData {
	public static $tablename = "condicio";	
		public function __construct(){
		$this->co_cond = 0;		$this->cond_des = "";				
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT f.co_cond, f.cond_des FROM ".self::$tablename." f	ORDER BY f.co_cond ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new SubData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cond = $r['co_cond'];
			$array[$cnt]->cond_des = $r['cond_des'];
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