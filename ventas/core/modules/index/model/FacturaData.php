<?php
class FacturaData {
	public static $tablename = "factura";
	//co_cli cli_des rif saldo
	public function __construct(){
		$this->responsive_id = '';
		$this->id = '0';
		$this->dato1 = '0';
		$this->dato2 = '0';
		$this->dato3 = '0';

		$this->co_cli = '0';
		$this->cli_des = '0';
		$this->rif = '0';
		$this->saldo = '0';
		$this->nro_doc = '0';
		$this->fec_emis = '0';
		//fec_emis
	}

	

	public static function getDataFiltrada($filtro,$vendedores){
		$fechaI = substr($filtro, 0, 10); 	
		$fechaF = substr($filtro, 14, 10); 
	
		if($vendedores==0){
			$sql="SELECT sum(f.tot_neto/f.tasa) AS totalMes, DATENAME(MONTH,f.fec_emis) AS mes_char, MONTH(f.fec_emis) AS mes_number  FROM factura f 
			WHERE fec_emis between '".$fechaI."' AND '".$fechaF."' AND anulada = 0
			GROUP BY MONTH(f.fec_emis), DATENAME(MONTH,f.fec_emis)
			ORDER BY 3 ASC";
		}else{
			$sql="SELECT sum(f.tot_neto/f.tasa) AS totalMes, DATENAME(MONTH,f.fec_emis) AS mes_char, MONTH(f.fec_emis) AS mes_number  FROM factura f 
			WHERE fec_emis between '".$fechaI."' AND '".$fechaF."' AND anulada = 0 AND f.co_ven = ".$vendedores."
			GROUP BY MONTH(f.fec_emis), DATENAME(MONTH,f.fec_emis)
			ORDER BY 3 ASC";
		}
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new FacturaData(); 			
				$array[$cnt]->dato1 = $r['totalMes'];
				$array[$cnt]->dato2 = $r['mes_char'];
				$array[$cnt]->dato3 = $r['mes_number'];	
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{
			//echo "No tengo nada";
			$array = array();
			return $array;

		}
		
	}

	public static function getAllCuentasPorCobrar(){
		/// Metodo para consultar el total de cuenas por cobrar	
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];
		$sql="SELECT SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN d.saldo * (-1) ELSE d.saldo END) as saldo FROM docum_cc d 
		INNER JOIN clientes c ON c.co_cli=d.co_cli
		WHERE d.saldo > 0 AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') and d.co_ven = '".$co_ven."'";
		
		/*
		$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
		p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
		p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		WHERE p.co_ven = '".$co_ven."'  AND p.anulada = 0 AND p.co_sucu = '".$co_sucu."' 
		ORDER BY p.fec_emis DESC";*/
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->dato1 = $r['saldo'];		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}


	
	
	public static function getAllCuentasPorCobrarDetalles(){
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql="SELECT d.co_cli, c.cli_des, c.rif, SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN d.saldo * (-1) ELSE d.saldo END) as saldo
		FROM docum_cc d INNER JOIN clientes c ON c.co_cli=d.co_cli
		WHERE d.saldo > 0 AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') and d.co_ven = '".$co_ven."'
		GROUP BY d.co_cli,c.cli_des,c.rif ORDER BY c.cli_des ASC";
		
		//echo $sql
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_cli = $r['co_cli'];	
			$array[$cnt]->cli_des = $r['cli_des'];
			$array[$cnt]->rif = $r['rif'];
			$array[$cnt]->saldo = $r['saldo'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getFacturasCliente($co_cli,$filtro){
		/// Metodo para consultar el total de cuenas por cobrar	
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];
		$sql="Select d.nro_doc,d.saldo,d.fec_emis from docum_cc d 
		inner Join clientes c on d.co_cli = c.co_cli 
		where c.co_cli ='".$co_cli."' AND  d.tipo_doc = 'FACT' AND d.saldo > 0 and d.anulado = ".$filtro." and d.co_ven = '".$co_ven."' ORDER BY d.fec_emis asc";
				
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->nro_doc = $r['nro_doc'];		
			$array[$cnt]->saldo = $r['saldo'];	
			$array[$cnt]->fec_emis = $r['fec_emis'];			
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