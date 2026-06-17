<?php
class BancoData {
	public static $tablename = "bancos";	
		public function __construct(){	
		$this->co_ban ='';		
		$this->des_ban ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}



	public static function getAllDatos(){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT b.co_ban, b.des_ban FROM ".self::$tablename." b	ORDER BY b.co_ban ASC";	
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new BancoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_ban = $r['co_ban'];
			$array[$cnt]->des_ban = $r['des_ban'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}


	public static function getDataId($filtro){
		/// Metodo para consultar todos los datos para el
		// solo para adminsitrador
		$sql ="SELECT b.co_ban, b.des_ban,c.num_cta FROM ".self::$tablename." b 
		INNER JOIN cuentas c ON c.co_banco = b.co_ban
		 WHERE c.cod_cta = '$filtro'	ORDER BY b.co_ban,c.num_cta ASC";	
		 //echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new BancoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_ban = $r['co_ban'];
			$array[$cnt]->des_ban = $r['des_ban'];
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