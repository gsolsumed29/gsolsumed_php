<?php
class PaqueteData {
    public static $tablename = "jm_paquetes_reg";
    public $id_empaquetado;
    public $numero_paquete;
    public $facturas;
    public $codigo_cliente;
    public $fecha_despacho;
    public $qr_data;
    
    public function add() {

        // Obtener el ID del usuario de la sesión
        $co_ven = $_SESSION['identidad'];
        
        // Construir la consulta SQL
        $sql = "INSERT INTO ".self::$tablename." (co_lote, numero_paquete, facturas, co_cli, fecha_despacho, qr_data, co_ven,estatus,dato_extra1) ";
        $sql .= "VALUES ('$this->loteId','$this->numero_paquete','$this->facturas','$this->codigo_cliente','$this->fecha_despacho','$this->qr_data','$co_ven',1,'0')";
       // echo $sql;
        // Ejecutar la consulta
        Executor::doitEx($sql);
        
        return true;
    }

    	
	public static function getAllDatosPaquetes($filtro){
		/// Metodo para consultar todos los datos y mostrar las tablas
		


		$sql ="SELECT TOP 1 pr.id, pr.co_lote, pr.numero_paquete, pr.facturas, pr.co_cli, pr.fecha_despacho, pr.qr_data, pr.estatus, pr.co_ven, c.cli_des 
		FROM jm_paquetes_reg pr 
		INNER JOIN clientes c ON c.co_cli = pr.co_cli
		WHERE pr.estatus = 1 and pr.dato_extra1='0' AND pr.co_lote IN ('$filtro')  
		ORDER BY pr.id DESC;";		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PaqueteData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->co_lote = trim($r['co_lote']);
			$array[$cnt]->numero_paquete = trim($r['numero_paquete']);	
		    $array[$cnt]->facturas = trim($r['facturas']);	
		   $array[$cnt]->co_cli = trim($r['co_cli']);	
            $array[$cnt]->cli_des = trim($r['cli_des']);	
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	   	
	public  function getFacturasPaquetes($filtro){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		//echo $filtro;

		$sql ="SELECT
			MAX(jp.fecha_impresion) AS fecha_impresion,jp.co_lote -- Usamos MAX() para obtener la fecha más reciente
			FROM
				jm_paquetes_reg pr
			INNER JOIN
				jm_paquetes jp ON pr.co_lote = jp.co_lote
			WHERE
				-- Usamos la condición robusta que vimos antes para buscar la factura
				(pr.facturas LIKE '%,NF021661,%' OR pr.facturas LIKE '%".'"'.$filtro.'"'."%')
			GROUP BY
				jp.co_lote;";

	
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PaqueteData(); 
			$array[$cnt]->responsive_id = "";  
			
				$array[$cnt]->fecha_impresion = $r['fecha_impresion'];
				$array[$cnt]->id_lote = $r['co_lote'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}


	
	public static function getFacturasInventarioEntregasAlmacen($filtro) {
		$sql = ""; // Inicializamos la variable SQL

		if ($filtro == 'NO') {
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			$mes_anterior = $mes - 1;
			$sql = "select DISTINCT
			 jpr.co_lote,
			 c.co_cli,
			 c.cli_des,
			 jp.dato_extra1
			 ,jp.estatus,
			 j.persona_des,
			 jp.fecha_impresion as fecha_armado,
			jpr.facturas
			from jm_paquetes_reg jpr 
			join jm_paquetes jp on jp.co_lote = jpr.co_lote 
			join clientes c on jpr.co_cli = c.co_cli
			join jm_personas j on jp.co_ven = j.co_ocupa 
              inner join jm_despacho_lotes jdl on jpr.co_lote = jdl.loteID
            where  ((MONTH(jp.fecha_impresion) = '$mes' ) OR (MONTH(jp.fecha_impresion) = '$mes_anterior' ) )
          
			AND YEAR(jp.fecha_impresion ) = '$anio' group by  jpr.co_lote,jpr.id,c.co_cli,c.cli_des,jp.dato_extra1,jp.estatus,j.persona_des,jpr.facturas,jp.fecha_impresion ";
		} else {
			
		}
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e = count($query);		
		if ($e >= 1) {
			$array = array();
			$cnt = 0;	
			foreach ($query as $r) {				
				$array[$cnt] = new PaqueteData(); 	
				$objeto_lote  = new EmpaquetadoData();
			
				$array[$cnt]->responsive_id = "";  

				// Campos principales de la factura
				$array[$cnt]->co_lote = trim($r['co_lote']);
				$array[$cnt]->co_cli = trim($r['co_cli']);			
				$array[$cnt]->cli_des = trim($r['cli_des']);
				
				// Datos del cliente
				$array[$cnt]->dato_extra1 = trim($r['dato_extra1']);
				$array[$cnt]->estatus = trim($r['estatus']);

				 // --- NUEVO: Decodificar el JSON de facturas ---
   				$facturas_json = $r['facturas']; // El string original: "[\"24721\",\"24721\"]"
				$facturas_array = json_decode($facturas_json, true);
				$data = $objeto_lote->getLotePorFactura($facturas_array);
			//	$array[$cnt]->facturas_array = $facturas_array;
				//$array[$cnt]->transporte =trim($r['persona_des']);
				$array[$cnt]->transporte =$data[0]->des_tran;
				$array[$cnt]->fecha_armado = trim($r['fecha_armado']);
				
				$cnt++;
			}
			return $array;
		} else {
			$array = array();
			return $array;
		}
	}


	
	public static function getLotesPorCarga($carga_id){ 
		$sql ="select SUM(cantidad_paquetes) as cantidad from jm_despacho_lotes where estatus = '2' and carga_id ='$carga_id';";		
		
	 //echo $sql;
	$query = Executor::doitAr($sql);	
	$e = count($query);		
	
	if($e >= 1) {
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {
			$array[$cnt] = new VehiculoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cantidad = $r['cantidad'];
		
			$cnt++;
		}
		return $array;
	} else {
		 $cnt = 0;	
		$array = array();
		   $array[$cnt] = new VehiculoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cantidad = 0;
		return $array;
	}
}



public static function getLotesPorCLiente($carga_id){ 
		$sql ="		  
			SELECT 
				COUNT( jdl.loteID) AS cantidad,
				COUNT(CASE WHEN jdl.estatus = 2 THEN jdl.loteID END) AS lotes_verificados
			FROM 
				jm_despacho_carga jdc
			INNER JOIN 
				jm_despacho_lotes jdl ON jdc.codigo = jdl.codigo	
			WHERE 
				jdc.codigo = '$carga_id' 
				

		
			";		
		
	 //echo $sql;
	$query = Executor::doitAr($sql);	
	$e = count($query);		
	
	if($e >= 1) {
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {
			$array[$cnt] = new VehiculoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cantidad = $r['cantidad'];
			  $array[$cnt]->lotes_verificados = $r['lotes_verificados'];
			$cnt++;
		}
		return $array;
	} else {
		 $cnt = 0;	
		$array = array();
		   $array[$cnt] = new VehiculoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cantidad = 0;
			$array[$cnt]->lotes_verificados = 0;
		return $array;
	}
}

}
?>