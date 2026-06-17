<?php
class VendedorData {
	public static $tablename = "vendedor";	
	public function __construct(){
		$this->responsive_id = '';
		$this->co_ven = '0';
		$this->tipo = "";
		$this->ven_des = "";	
		$this->telefonos = "";
		$this->cedula ="";
		$this->direc1 ="0";
		$this->comisionv ="0";
		$this->dato1 ='0';		

	}


	public static function getAllDatos(){

		$sql = "SELECT  v.co_ven, v.ven_des,v.direc1,v.telefonos,v.comision,v.email,v.condic,v.campo8 FROM ".self::$tablename." v WHERE   v.condic = 0 	ORDER BY v.co_ven ASC";	
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
			$array[$cnt]->co_us = $r['campo8'];	
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

		public static function getVendedores_filtrados(){
		
		$sql = "SELECT * FROM ".self::$tablename." v WHERE v.campo5='*' and  v.condic = 0 ORDER BY v.co_ven ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_ven = trim($r['co_ven']);			
			$array[$cnt]->ven_des = trim($r['ven_des']);		
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}


	
		public static function getDataVerificadores(){
		
		$sql = "SELECT u.co_ven,jp.persona_des  FROM jm_users u inner join jm_personas jp on jp.co_ocupa = u.co_ven WHERE u.rol='4' and status = '1' ORDER BY u.id ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->dato1 = trim($r['co_ven']);			
			$array[$cnt]->dato2 = trim($r['persona_des']);		
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}


	public static function getVendedoresFichas_Analisis_visitas(){

		$hoy = getdate();
		$mes = $hoy['mon'];
		$anio = $hoy['year'];
		$mes2 = $mes-1;
	
		$sql = "
		SELECT 
		v.co_ven,
		v.ven_des,
		(SELECT COUNT(*) FROM jm_visitas_candidatos jvc  WHERE jvc.co_ven =v.co_ven and MONTH(jvc.fecha)=$mes) AS cantidad_visitas_candidatos,
		(SELECT COUNT(*) FROM jm_visitas_cliente_corta jvcl  WHERE jvcl.co_ven =v.co_ven and MONTH(jvcl.fecha)=$mes) AS cantidad_visitas_clientes_cortas,
		(SELECT COUNT(*) FROM jm_clientes_cand jrc  WHERE jrc.co_ven =v.co_ven and MONTH(jrc.fecha_reg)=$mes) AS cantidad_registro_candidatos,
		(SELECT COUNT(*) FROM jm_visitas_cliente jvlc  WHERE jvlc.co_ven = v.co_ven and MONTH(jvlc.fecha)=$mes) AS cantidad_visitas_cliente
		FROM vendedor v WHERE (v.campo1='*'  or v.campo6='*' ) and v.condic=0 ORDER BY v.co_ven ASC
		";    
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
			$array = array();
			$cnt = 0;
			foreach($query as $r) {	
	
				$objeto_datos_vendedor = VendedorData::getPlanificacionVendedores($r['co_ven']);
				
				$array[$cnt] = new VendedorData();
				
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_ven = trim($r['co_ven']);			
				$array[$cnt]->ven_des = trim($r['ven_des']);
	
				$array[$cnt]->cantidad_visitas_candidatos = trim($r['cantidad_visitas_candidatos']);		
				$array[$cnt]->cantidad_visitas_clientes_cortas = trim($r['cantidad_visitas_clientes_cortas']);		
				$array[$cnt]->cantidad_registro_candidatos = trim($r['cantidad_registro_candidatos']);		
				
				// NUEVA ASIGNACIÓN
				$array[$cnt]->cantidad_visitas_cliente = trim($r['cantidad_visitas_cliente']);		
	
				$array[$cnt]->data1 = $objeto_datos_vendedor[0]->visitas_cortas;
				$array[$cnt]->data2 = $objeto_datos_vendedor[0]->candidatos_visitados;
	
				$cnt++;
			}
			return $array;
		} else {
			$array = array();
			return $array;
		}
	}


	public static function getPlanificacionVendedores($co_ven){
    $hoy = getdate();
    $mes = $hoy['mon'];

    // Consulta SQL
    $sql = "SELECT jvp.co_ven, jvp.tipo, jvp.description 
            FROM jm_visitas_planificacion jvp 
            WHERE jvp.co_ven = '$co_ven' 
            AND MONTH(jvp.inicio) = $mes"; 

    $query = Executor::doitAr($sql);
    
    // Inicializamos contadores en 0
    $totalClientes = 0;
    $totalCandidatos = 0;
    
    if(count($query) >= 1){
        
        foreach($query as $r) { 
            // 1. EXTRAER SOLO EL NÚMERO de la descripción
            // Busca cualquier secuencia de dígitos (\d+)
            if (preg_match('/(\d+)/', $r['description'], $matches)) {
                $cantidad = intval($matches[1]);

                // 2. SUMAR SEGÚN EL CAMPO 'TIPO'
                if ($r['tipo'] == 1) {
                    // Tipo 1: CLIENTE
                    $totalClientes += $cantidad;
                } elseif ($r['tipo'] == 2) {
                    // Tipo 2: CANDIDATO
                    $totalCandidatos += $cantidad;
                }
            }
        }

        // 3. CREAR OBJETO DE RETORNO
        $vendedorData = new VendedorData();
        $vendedorData->co_ven = $co_ven;
        $vendedorData->visitas_cortas = $totalClientes;      // Acumulado Tipo 1
        $vendedorData->candidatos_visitados = $totalCandidatos; // Acumulado Tipo 2
        
        // (Opcional) Calculamos derivados
        $vendedorData->entrevistas = floor($totalCandidatos * 0.6);

        // Devolvemos array con el resumen
        return array($vendedorData);

    } else {
        // Si no hay datos, devolvemos ceros
        $vendedorData = new VendedorData();
        $vendedorData->co_ven = $co_ven;
        $vendedorData->visitas_cortas = 0;
        $vendedorData->candidatos_visitados = 0;
        $vendedorData->entrevistas = 0;
        return array($vendedorData);
    }
}


	
}
?>