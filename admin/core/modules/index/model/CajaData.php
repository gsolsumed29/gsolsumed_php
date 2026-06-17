<?php
class CajaData {
	public static $tablename = "cajas";	


		public function __construct(){	
		$this->cod_caja ='';		
		$this->descrip ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para administrador
		$sql ="SELECT c.cod_caja, c.descrip FROM ".self::$tablename." c	WHERE c.campo1='*'   ORDER BY c.cod_caja ASC";	
		echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new CajaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cod_caja = $r['cod_caja'];
			$array[$cnt]->descrip = $r['descrip'];
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