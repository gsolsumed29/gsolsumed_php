<?php
class TransporteData {
	public static $tablename = "transpor";	
		public function __construct(){
		$this->co_tran = 0;		$this->des_tran = "";				
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el combo de transporte
	
		$sql ="SELECT t.co_tran, t.des_tran FROM ".self::$tablename." t	ORDER BY t.co_tran ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new TransporteData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_tran = $r['co_tran'];
			$array[$cnt]->des_tran = $r['des_tran'];
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