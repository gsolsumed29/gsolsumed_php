<?php
class PagoData {
	public static $tablename = "jm_reportar_pago";	

		public function __construct(){	
	
		$this->id= '0';	
		$this->co_pago= '0';		
		$this->co_cli= '0';	
		$this->co_ven= '0';	
		$this->fec_emis= '0';	
		$this->monto_cob= '0';
		$this->cob_num= '0';		
		$this->status= '0';	
		
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	
		$this->dato5 ='';	
		
	}


	public function add(){		

		$data=$this->ultima();
		$this->co_pago=$data;
		$co_ven =$_SESSION['identidad'];
		//var_dump($this->dato1);
		$sql = "INSERT INTO ".self::$tablename." (co_cli, co_ven, fec_emis, monto_cob, cob_num,status,nro_docs_grup,observacion,datoExtra) ";
		$sql .= "VALUES ('$this->co_cli','$co_ven','$this->fec_emis',$this->monto_cob,'$this->co_pago',1,'$this->nro_docs_grup','$this->observacion','$this->datoExtra')";		
		//echo $sql;	
		Executor::doitEx($sql);
				
	}

	public function addAdelanto(){	

		$data=$this->ultima();
		$this->co_pago=$data;
		$co_ven =$_SESSION['identidad'];
		//var_dump($this->dato1);
		$sql = "INSERT INTO ".self::$tablename." (co_cli, co_ven, fec_emis, monto_cob, cob_num,status,nro_docs_grup,datoExtra) ";
		$sql .= "VALUES ('$this->co_cli','$co_ven','$this->fec_emis',$this->monto_cob,'$this->co_pago',1,'00000000000','$this->datoExtra')";		
		//echo $sql;	
		Executor::doitEx($sql);	

	}

	public function delF(){
		$sql = "DELETE FROM  ".self::$tablename." where co_pago='$this->id'";
		//echo $sql;
		Executor::doitEx($sql);
	}

	  
    private function validarReferenciaBanco($ref_ban) {
		$objeto_funciones = new FuncionesData();
        $data = $objeto_funciones->foundValor('jm_reportar_pago_reg', 'ref_ban', $ref_ban, 'FuncionesData');
        if (!empty($data[0]->id)) {
            throw new Exception('La referencia de banco ya existe');        }
        
        $data = $this->objeto_funciones->foundValor('reng_tip', 'num_doc', $ref_ban, 'FuncionesData');
        if (!empty($data[0]->id)) {
            throw new Exception('La referencia de banco ya existe en reng_tip');
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



			public static function ultima() {
			$sql = "SELECT MAX(id) as max_id FROM " . self::$tablename;
			$result = Executor::doit($sql);
			
			// Initialize to 1 if no records exist or query fails
			$next_id = 1;
			
			if ($result && isset($result['max_id'])) {
				$next_id = (int)$result['max_id'] + 1;
			}
			
			return $next_id;
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

	
	public static function getAllDatosCobros($status,$rango){
		
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



	
	

	
	public static function getDataReng($co_cuenta,$nun_doc){

		  $hoy = getdate();
        $mes = $hoy['mon'];
        $anio = $hoy['year'];
        $mes2 = $mes-1;


		/// Metodo para consultar todos los datos y mostrar las tablas
		if($co_cuenta == '0'){
			$sql ="select rt.cob_num from reng_tip rt

		 WHERE  rt.cod_caja  = '$co_cuenta' AND rt.cod_caja  = '$co_cuenta' and  ( MONTH(rt.fec_cheq) = '$mes2' or MONTH(rt.fec_cheq) = '$mes')
        AND YEAR(rt.fec_cheq) = '$anio'
		 ORDER BY rt.cob_num";
		}else{

		$sql ="select rt.cob_num from reng_tip rt

		 WHERE rt.mont_doc = '$nun_doc' AND rt.cod_caja  = '$co_cuenta' and  ( MONTH(rt.fec_cheq) = '$mes2' or MONTH(rt.fec_cheq) = '$mes')
        AND YEAR(rt.fec_cheq) = '$anio'
		 ORDER BY rt.cob_num";
		
		}

		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {		
			$array[$cnt] = new PagoData(); 
			$array[$cnt]->cob_num = $r['cob_num'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				$array[0] = new PagoData(); 
				$array[0]->cob_num = '1';
				return $array;
		}
	}

	
	
}
?>