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

	public static function GetFactura($fact_num,$status){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];

		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, (p.saldo/p.tasa) as saldo, p.fec_emis,p.fec_venc, p.co_tran, p.forma_pag,
		(p.tot_bruto/p.tasa) as tot_bruto, (p.tot_neto/p.tasa) as tot_neto , (p.iva/p.tasa) as iva, p.moneda, p.status, p.contrib,c.cli_des,c.email,c.telefonos,c.direc1,t.des_tran,v.ven_des FROM factura p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		INNER JOIN transpor t ON p.co_tran = t.co_tran
		WHERE p.fact_num='".$fact_num."' AND p.status='".$status."' AND p.co_ven = '".$co_ven."'  AND p.status = 0 AND p.co_sucu = '".$co_sucu."' 
		ORDER BY p.fact_num ASC ";  

		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PedidoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->fact_num = $r['fact_num'];
			$array[$cnt]->saldo = $r['saldo'];			
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->fec_venc =substr($r['fec_venc'], 0, 10);  // abcd ;	
			//$array[$cnt]->fec_venc = $r['fec_venc'];	
			$array[$cnt]->dato1 = $r['cli_des'];	
			$array[$cnt]->dato2 = $r['email'];		
			$array[$cnt]->dato3 = $r['telefonos'];	
			$array[$cnt]->dato4 = $r['direc1'];		
			$array[$cnt]->dato5 = $r['ven_des'];				
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = number_format($r['tot_bruto'], 2, ',', '.');			
			$array[$cnt]->tot_neto = number_format($r['tot_neto'], 2, ',', '.');	
			$array[$cnt]->iva = number_format($r['iva'], 2, ',', '.');	
			$array[$cnt]->status = $r['status'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function GetFacturaDespacho($fact_num,$status){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];
		
		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, (p.saldo/p.tasa) as saldo, p.fec_emis,p.fec_venc, p.co_tran, p.forma_pag,
		(p.tot_bruto/p.tasa) as tot_bruto, (p.tot_neto/p.tasa) as tot_neto , (p.iva/p.tasa) as iva, p.moneda, p.status, p.contrib,c.cli_des,c.email,c.telefonos,c.direc1,t.des_tran,v.ven_des FROM factura p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		INNER JOIN transpor t ON p.co_tran = t.co_tran
		WHERE p.fact_num='".$fact_num."'  AND p.status = 0 AND p.co_sucu = '".$co_sucu."' 
		ORDER BY p.fact_num ASC ";  

		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PedidoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->fact_num = $r['fact_num'];
			$array[$cnt]->saldo = $r['saldo'];			
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->fec_venc =substr($r['fec_venc'], 0, 10);  // abcd ;	
			//$array[$cnt]->fec_venc = $r['fec_venc'];	
			$array[$cnt]->dato1 = $r['cli_des'];	
			$array[$cnt]->dato2 = $r['email'];		
			$array[$cnt]->dato3 = $r['telefonos'];	
			$array[$cnt]->dato4 = $r['direc1'];		
			$array[$cnt]->dato5 = $r['ven_des'];				
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = number_format($r['tot_bruto'], 2, ',', '.');			
			$array[$cnt]->tot_neto = number_format($r['tot_neto'], 2, ',', '.');	
			$array[$cnt]->iva = number_format($r['iva'], 2, ',', '.');	
			$array[$cnt]->status = $r['status'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function GetRenglonFactura($fact_num){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];
		$sql ="SELECT  a.co_art AS co_art, pg.total_art AS cantidad,a.art_des,a.prec_vta1 from reng_fac pg
		INNER JOIN factura p on p.fact_num = pg.fact_num 
		INNER JOIN almacen ar on p.co_sucu = ar.co_alma 
		INNER JOIN art a ON pg.co_art = a.co_art 
		INNER JOIN vendedor v on p.co_ven = v.co_ven
		WHERE pg.fact_num='".$fact_num."' AND p.co_ven = '".$co_ven."'   AND p.co_sucu = '".$co_sucu."' 
		GROUP BY a.co_art,a.prec_vta1,a.art_des,pg.total_art";  

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PedidoData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_art = trim($r['co_art']);			
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato2 = (float)number_format($r['cantidad'], 2, ',', '.');
			$array[$cnt]->dato3 = (float)$r['prec_vta1'];			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function GetRenglonFacturaDespacho($fact_num){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_sucu=$_SESSION['co_alma'];
		$sql ="SELECT  a.co_art AS co_art,c.des_col AS marca, pg.total_art AS cantidad,a.art_des,a.prec_vta1 from reng_fac pg
		INNER JOIN factura p on p.fact_num = pg.fact_num 
		INNER JOIN almacen ar on p.co_sucu = ar.co_alma 
		INNER JOIN art a ON pg.co_art = a.co_art 
		INNER JOIN colores c ON a.co_color = c.co_col 
		INNER JOIN vendedor v on p.co_ven = v.co_ven
		WHERE pg.fact_num='".$fact_num."' AND p.co_sucu = '".$co_sucu."' 
		GROUP BY a.co_art,a.prec_vta1,a.art_des,pg.total_art,c.des_col";  

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PedidoData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_art = trim($r['co_art']);			
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato4 = trim($r['marca']);	
			$array[$cnt]->dato2 = (float)number_format($r['cantidad'], 2, ',', '.');
			$array[$cnt]->dato3 = (float)$r['prec_vta1'];			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
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
		$sql="SELECT SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo FROM docum_cc d 
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

		$sql="SELECT d.co_cli, c.cli_des, c.rif, SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo
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
			$array[$cnt]->saldo =  (float)number_format($r['saldo'], 2, ',', '.');	
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
		$sql="Select d.nro_doc,(d.saldo/d.tasa) as saldo,d.fec_emis,d.tipo_doc,(d.monto_net/d.tasa) as monto_net,datediff(d, d.fec_emis, GETDATE()) AS dias from docum_cc d 
		inner Join clientes c on d.co_cli = c.co_cli 		
		where c.co_cli ='".$co_cli."'  AND d.saldo > 0 and d.anulado = ".$filtro." and d.co_ven = '".$co_ven."' ORDER BY d.fec_emis desc";
		//
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {
				
				$objeto_pago_reg = New PagoRegData();				
				$data=$objeto_pago_reg->getData($r['nro_doc']);			
				if (empty($data)) {
    			$status=0;
				}else{
					//var_dump($data);
				$status=$data[0]->status;
				}
				
				if(($r['tipo_doc']=='ADEL')|| ($r['tipo_doc']=='N/CR') || ($r['tipo_doc']=='AJNM') ){
					$saldo2 =$r['saldo'] * -1;
				}else{
					$saldo2 =$r['saldo'];
				}
		
			//echo "Estatus=".$status;
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->nro_doc = $r['nro_doc'];		
			$array[$cnt]->saldo = number_format($r['saldo'], 2, ',', '.');	
			$array[$cnt]->saldo2 = $saldo2;	
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->tipo_doc = $r['tipo_doc'];	
			$array[$cnt]->dato2 = number_format($r['monto_net'],2, ',', '.');
			$array[$cnt]->dato1 = $status;				
			$array[$cnt]->dato3 =  $r['dias'];					
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