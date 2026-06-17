<?php
class MarcaData {
	public static $tablename = "colores";	
		public function __construct(){
		$this->co_col = 0;		
		$this->des_col ='';		
		

	}



	public static function getDataMarcas(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT co_col,des_col FROM ".self::$tablename." where campo1='*'	ORDER BY des_col ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new MarcaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_col = trim($r['co_col']);
			$array[$cnt]->des_col =  trim($r['des_col']);
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