<?php
class PagoRegData {
	public static $tablename = "jm_reportar_pago_reg";	

		public function __construct(){	
	
		$this->id= '0';	
		$this->nro_doc ='';	
		$this->cob_num= '0';		
		$this->reng_num= '0';	
		$this->forma_pag= '0';	
		$this->fec_tran= '0';	
		$this->cod_ban= '0';	
		$this->co_cuenta= '0';	
		$this->ref_ban= '0';
		$this->rec_tran= '0';		
		$this->cod_caja= '0';		
		$this->monto ='';
		$this->monto_bs ='';

		$this->tipo_doc ='';
		$this->tipo_moneda ='';	
		$this->tasa ='';
		$this->status ='';
		$this->dato1 ='';	
		$this->dato2 ='';	
		$this->dato3 ='';	



	}

	public function add(){
		$facturas = $this->dato1;
		$separador = ",";
		$separada = explode($separador, $facturas);
		//var_dump($separada);
		$this->tipo_doc='FACT';
		$data=$this->ultima();
		$this->cob_num=$data['co_pago'];

		
		$data2 = $this->tasa();
		$this->tasa=$data2['tasa'];

		$item='1';	
		$i=0;			
		foreach($separada as $carrito){		
		$this->nro_doc=$separada[$i];
		$sql ="INSERT INTO ".self::$tablename."(nro_doc,cob_num, reng_num, forma_pag, cod_ban, ref_ban, fec_tran, cod_caja, monto,monto_bs,tasa,tipo_moneda,tipo_doc,status,co_cuenta) ";
		$sql.=" VALUES('$this->nro_doc','$this->cob_num','$item','$this->forma_pag','$this->cod_ban','$this->ref_ban','$this->fec_tran','$this->cod_caja',$this->monto,$this->monto_bs,$this->tasa,'$this->tipo_moneda','$this->tipo_doc',1,'$this->co_cuenta')";
		//echo "<br>";
		//echo $sql;
			Executor::doitEx($sql);		
			$item++;
			$i++;
		}
	}



	public function delPagoRegF(){
		$facturas = $this->dato1;
			$monto = $this->dato2;
		$separador = ",";
		$separada = explode($separador, $facturas);
	
	
	$i=0;			
	foreach($separada as $carrito){		
	$this->nro_doc=$separada[$i];
	$sql = "DELETE FROM jm_reportar_pago_reg WHERE monto = $monto AND nro_doc='$this->nro_doc'";
	//echo "<br>";
	//echo $sql;
		Executor::doitEx($sql);
		$i++;
	}
	}
	
	public function addAdelanto(){
		
		//var_dump($separada);
		$this->tipo_doc='ADEL';
		$data=$this->ultima();
		$this->cob_num=$data['co_pago'];

		$data2 = $this->tasa();
		$this->tasa=$data2['tasa'];
		$this->monto_bs=$this->monto*$this->tasa;
	$item='1';	
	$this->nro_doc=$this->dato1;
	$sql ="INSERT INTO ".self::$tablename."(nro_doc,cob_num, reng_num, forma_pag, cod_ban, ref_ban, fec_tran, cod_caja, monto,monto_bs,tasa,tipo_moneda,tipo_doc,status,co_cuenta) ";
		$sql.=" VALUES('$this->nro_doc','$this->cob_num','$item','$this->forma_pag','$this->cod_ban','$this->ref_ban','$this->fec_tran','$this->cod_caja',$this->monto,$this->monto_bs,$this->tasa,'$this->tipo_moneda','$this->tipo_doc',1,'$this->co_cuenta')";
	//echo "<br>";
	//echo $sql;
		Executor::doitEx($sql);		
	
	
	}	

	public function delF(){
		$sql = "DELETE FROM  jm_reportar_pago_reg where cob_num='$this->id' AND tipo_doc='ADEL'";
		//echo $sql;
		Executor::doitEx($sql);
	}
	

		public static function getData($nro_doc){		
			$sql="SELECT r.status FROM jm_reportar_pago_reg r WHERE r.nro_doc ='".$nro_doc."'";			
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new PagoRegData(); 	
				$array[$cnt]->status = $r['status'];			
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
		}
	
	public static function getAllDatosFiltro($status){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
		p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
		p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		WHERE p.co_ven = '".$co_ven."' AND p.status='".$status."' AND p.anulada = 0 AND p.co_sucu = '".$co_sucu."' 
		ORDER BY p.fec_emis DESC";
		
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
			$array[$cnt]->dato1 = $r['co_cli'].'-'.$r['cli_des'];			
			$array[$cnt]->fec_emis = $r['fec_emis'];			
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


	public static function getAllDatos(){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
		p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
		p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		WHERE p.co_ven = '".$co_ven."'  AND p.anulada = 0 AND p.co_sucu = '".$co_sucu."' 
		ORDER BY p.fec_emis DESC";
		
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
			$array[$cnt]->dato1 = $r['co_cli'].'-'.$r['cli_des'];			
			$array[$cnt]->fec_emis = $r['fec_emis'];			
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
	


	public static function ultima(){		
			
		$sql = "SELECT  MAX(id) as co_pago FROM jm_reportar_pago";
		//echo $sql;
		$co_pago=Executor::doit($sql);
		//echo $fact_num;
		return $co_pago;
}
	
	public static function tasa(){
		$sql = "select cambio as tasa from moneda where co_mone = 'US$'";
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}

	public static function moneda(){
		$sql = "select co_mone from moneda where co_mone = 'US$'";
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}


	public static function getDataTasa($filtro){
		$sql = "select cambio as tasa from moneda where co_mone = '$filtro'";
	//	echo $sql;
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}
	
	
}
?>