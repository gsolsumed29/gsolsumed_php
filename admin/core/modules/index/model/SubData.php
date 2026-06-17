<?php
class SubData {
	public static $tablename = "sub_alma";	
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
		$sql ="SELECT s.co_sub, s.des_sub FROM ".self::$tablename." s	ORDER BY s.co_sub ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new SubData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_sub = $r['co_sub'];
			$array[$cnt]->des_sub = $r['des_sub'];
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