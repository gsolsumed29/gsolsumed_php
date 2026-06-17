<?php
class VendedorData {
	public static $tablename = "snemple";	
	public function __construct(){
		$this->responsive_id = '';
		$this->co_emp = '0';
		$this->nombre_completo = "";
		
		$this->dato1 ='0';		

	}


	public static function getAllDatos(){

		$sql = "SELECT  v.cod_emp as co_ven, v.nombre_completo as ven_des FROM ".self::$tablename." v WHERE   v.status = 'A' 	ORDER BY v.cod_emp ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_ven = $r['co_ven'];			
			$array[$cnt]->ven_des = $r['ven_des'];		
				
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function getAllDatosFiltrados(){
		$co_ven = $_SESSION['identidad'];
		$sql = "SELECT  v.co_ven, v.ven_des,v.direc1,v.telefonos,v.comision,u.email,v.condic FROM ".self::$tablename." v 
		INNER JOIN jm_users u ON v.co_ven = u.co_ven
		WHERE  v.co_ven=".$co_ven." AND v.condic = 0 	ORDER BY v.co_ven ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_ven = $r['co_ven'];			
			$array[$cnt]->ven_des = $r['ven_des'];		
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->telefonos = $r['telefonos'];	
			$array[$cnt]->comision = $r['comision'];	
			$array[$cnt]->email = $r['email'];		
			$array[$cnt]->status = $r['condic'];		
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