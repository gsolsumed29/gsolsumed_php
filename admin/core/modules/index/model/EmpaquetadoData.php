<?php 

class EmpaquetadoData {
    public static $tablename = "jm_paquetes";
    public $total_paquetes;
    public $total_facturas;
    public $fecha_impresion;
    public $usuario;
    
    
    public function add() {
    // Obtener el ID del usuario de la sesión
    $co_ven = $_SESSION['identidad'];
    
    // 1. Construir y ejecutar SOLO la consulta de inserción
    $sql_insert = "INSERT INTO ".self::$tablename." (co_lote,total_paquetes, total_facturas, fecha_impresion, co_ven,dato_extra1) ";
    $sql_insert .= "VALUES ('$this->loteId','$this->total_paquetes','$this->total_facturas','$this->fecha_impresion','$co_ven','0')";
    
    // Ejecutar la inserción. No necesitamos un resultado de aquí.
    Executor::doitEx($sql_insert);
 
   // return 'true';
    
    
}


	public static function getAllDatosChoferes(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT jp.co_ocupa,jp.persona_des from jm_users ju INNER JOIN jm_personas jp ON jp.co_ocupa=ju.co_ven where ju.rol=6 ORDER BY ju.id ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new EmpaquetadoData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_ven = $r['co_ocupa'];
				$array[$cnt]->persona_des = $r['persona_des'];
				
					
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}


    public static function getAllDatosZonas(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT co_zon,zon_des from zona jz ORDER BY jz.zon_des ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new EmpaquetadoData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_zon = $r['co_zon'];
				$array[$cnt]->zon_des = $r['zon_des'];
							
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}


    public static function getAllDatosVehiculos(){
		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "SELECT placa,marca,modelo,anio from jm_vehiculos v ORDER BY v.marca ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new EmpaquetadoData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_vehiculo = $r['placa'];
				$array[$cnt]->vehiculo_des =$r['placa']." ".$r['marca']." ".$r['modelo']." ".$r['anio'];
							
			$cnt++; 
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}


	public static function getLotePorFactura($facturas){

		// Si la factura empieza con "NF", lo reemplazamos por "50"
			if (strpos($facturas[0], 'NF') === 0) {
				$facturaParaQuery = str_replace('NF', '50',$facturas[0]);
			}else{
				$facturaParaQuery=$facturas[0];
			}

		// Metodo para traer datos y mostrar en tabla usuarios
		$sql = "select top(1) t.co_tran,t.des_tran from factura  f inner join transpor t on  f.co_tran = t.co_tran where  f.fact_num  = '".$facturaParaQuery."'";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new EmpaquetadoData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_tran = $r['co_tran'];
				$array[$cnt]->des_tran = $r['des_tran'];
							
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}

}

?>