<?php
class PedidoData {
	public static $tablename = "pedidos";	

		public function __construct(){		
		$this->fact_num= '0';	
		$this->saldo= '0';		
		$this->fec_emis= '0';	
		$this->fec_venc= '0';	
		$this->co_cli= '0';	
		$this->co_ven= '0';
		$this->co_tran= '0';		
		$this->forma_pag= '0';	
		$this->total_bruto= '0';	
		$this->total_neto= '0';	
		$this->iva= '0';
		$this->co_us_in= '0';
		$this->fe_us_in= '0';	
		$this->co_sucu= '0';		
		$this->tasa= '0';		
		$this->co_mone= '0';
		$this->tasag= '0';		
		$this->tasag10= '0';		
		$this->tasag20= '0';		
		$this->status= '0';		
		$this->contrib= '0';
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	
		$this->dato5 ='';	
		$this->co_alma ='0';
		$this->total_art='0';

	}


	public function add(){
		// Agregar un pedido en la tabla pedidos 
		date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
	
		$data=$this->ultima();
		$this->fact_num=$data['fact_num'];
		$data2 = $this->tasa();
		$this->tasa=$data2['tasa'];
		$data3 = $this->moneda();
		$this->co_mone=$data3['co_mone'];

		
		
		$sql = "INSERT INTO ".self::$tablename." (fact_num, saldo, fec_emis, fec_venc, co_cli, co_ven, co_tran, forma_pag, tot_bruto,
		tot_neto, iva, co_us_in, fe_us_in, co_sucu,tasa, moneda, tasag, tasag10, tasag20, status, contrib) ";
		$sql .= "VALUES ('$this->fact_num',$this->saldo,'$date','$date','$this->co_cli','$this->co_ven','$this->co_tran',
		'$this->forma_pag',$this->total_bruto,$this->total_neto,$this->iva,'$this->co_us_in','$date','$this->co_sucu','$this->tasa',
		'$this->co_mone',16.00,8.00,31.00,'0',1)";		
		//echo $sql;
		
		Executor::doitEx($sql);
		$renglon_objeto = New RenglonData();	
		$renglon_objeto->fact_num=$this->fact_num;		
		$renglon_objeto->co_alma=$this->co_alma;		
		$renglon_objeto->add();

		
	}

	public static function getAllDatos(){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
		p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa, p.moneda,
		p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		WHERE p.co_ven = '".$co_ven."'  AND p.status = 0 AND p.co_sucu = '".$co_sucu."' 
		ORDER BY p.fact_num ASC";
		
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
			$array[$cnt]->fec_emis = $r['fec_emis'];			
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = (float)number_format($r['tot_bruto'], 2, ',', '.');			
			$array[$cnt]->tot_neto =(float)number_format($r['tot_neto'], 2, ',', '.');	
			$array[$cnt]->iva =(float)number_format($r['iva'], 2, ',', '.');	
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function ultima(){
			$sql = "select max(fact_num)+1 as fact_num from pedidos";
			$fact_num=Executor::doit($sql);
			//echo $fact_num;
			return $fact_num;
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


	public  function GetPedido($fact_num,$status){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$data2 = $this->tasa();
		$tasa=$this->tasa=$data2['tasa'];

		$sql ="SELECT p.fact_num, p.saldo, p.fec_emis,p.fec_venc, p.co_tran, p.forma_pag,
		p.tot_bruto, p.tot_neto, p.iva, p.moneda, p.status, p.contrib,c.cli_des,c.email,c.telefonos,c.direc1,t.des_tran,v.ven_des,c.co_cli FROM pedidos p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		INNER JOIN transpor t ON p.co_tran = t.co_tran
		WHERE p.fact_num='".$fact_num."' AND p.co_ven = '".$co_ven."'  AND p.status = ".$status." AND p.co_sucu = '".$co_sucu."' 
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
			$array[$cnt]->fec_emis = $r['fec_emis'];
			$array[$cnt]->fec_venc = $r['fec_venc'];	
			$array[$cnt]->dato1 = $r['cli_des'];	
			$array[$cnt]->dato2 = $r['email'];		
			$array[$cnt]->dato3 = $r['telefonos'];	
			$array[$cnt]->dato4= $r['direc1'];		
			$array[$cnt]->dato5 = $r['ven_des'];	
			$array[$cnt]->dato6 = $r['co_cli'];				
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = $r['tot_bruto']/$tasa;			
			$array[$cnt]->tot_neto = $r['tot_neto']/$tasa;	
			$array[$cnt]->iva = $r['iva'];	
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function GetRenglonPedido($fact_num){
		/// Metodo para consultar todos los datos y mostrar las tablas		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];
		$sql ="SELECT  a.co_art AS co_art, pg.total_art AS cantidad,a.art_des,pg.prec_vta2 as precio,pg.prec_vta as preciobs,c.des_col from reng_ped pg
		INNER JOIN pedidos p on p.fact_num = pg.fact_num 
		INNER JOIN almacen ar on p.co_sucu = ar.co_alma 
		INNER JOIN art a ON pg.co_art = a.co_art 
		INNER JOIN vendedor v on p.co_ven = v.co_ven
		INNER JOIN colores c ON c.co_col = a.co_color
		WHERE pg.fact_num='".$fact_num."' AND p.co_ven = '".$co_ven."'   AND p.co_sucu = '".$co_sucu."' 
		GROUP BY a.co_art,pg.prec_vta2,a.art_des,pg.total_art,pg.prec_vta,c.des_col";  


		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			//	echo $r['prec_vta1'];
			$array[$cnt] = new PedidoData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_art = trim($r['co_art']);	
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato2 = (float)number_format($r['cantidad'], 2, ',', '.');
			$array[$cnt]->dato3 = $r['precio']; 
			$array[$cnt]->dato4 = $r['des_col']; 
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