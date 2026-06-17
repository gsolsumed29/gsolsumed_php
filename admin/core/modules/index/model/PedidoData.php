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
		$this->fiscal ='';		
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	
		$this->dato5 ='';	
		$this->co_alma ='0';
		$this->total_art='0';
		$this->tipo_precio = '';
		$this->facturacion = '';
		$this->pago = '';
		$this->dato6 = '';

	}


	public function add(){
		// Agregar un pedido en la tabla pedidos 
		date_default_timezone_set('America/Caracas');
		$date = strftime("%Y-%m-%d %H:%M:%S", time());	
		$hora = strftime("%H:%M:%S", time());	
		
		$data=$this->ultima();
		$this->fact_num=$data['fact_num'];

		$data2 = $this->tasa();
		$this->tasa=$data2['tasa'];

		$data3 = $this->moneda();
		$this->co_mone=$data3['co_mone'];

		$saldo = $this->saldo*$this->tasa;
		$total_bruto = $this->total_bruto*$this->tasa;
		$total_neto = $this->total_neto*$this->tasa;
		$iva= $this->iva*$this->tasa;
		
		$descripcion ='';
		$aux02 ='';
		$saldo_base=0.00;
		$saldo_base =$this->saldo;
		$fiscal_base=$this->fiscal;
		$saldo_descuesto=0.00;		
		$saldo_factura=0.00;
		if($fiscal_base=='1'){
            $aux02 ="";
			$descripcion="<FISCAL>";
			$text_hora= "<".$hora.">";

        }else{
            $aux02  ="<*>";
			$descripcion = "<NOTA DE DESPACHO>";
			$text_hora= "<".$hora.">";
        }

		 //echo $descripcion;
		$saldo_factura=number_format((float)$saldo, 2, '.', '');
		//echo $this->saldo;
		$sql = "INSERT INTO ".self::$tablename."
    (fact_num, descrip, saldo, fec_emis, fec_venc, feccom, co_cli, co_ven, co_tran, forma_pag, tot_bruto,
    tot_neto, iva, co_us_in, co_us_mo, fe_us_in, co_sucu, tasa, moneda, tasag, tasag10, tasag20, status, contrib, aux02) ";
	$sql .= "VALUES 
    ('$this->fact_num','".$descripcion.$text_hora."',$saldo,cast(getdate() as date),cast(getdate() as date),CONVERT(datetime, getdate(), 121),'$this->co_cli','$this->co_ven','$this->co_tran',
    '$this->forma_pag',$total_bruto,$total_neto,$iva,'$this->co_us','$this->co_us',CONVERT(datetime, getdate(), 121),'$this->co_sucu','$this->tasa',
    '$this->co_mone',16.00,8.00,31.00,'0',1,'".$aux02."')";
	//echo $sql;
		//echo "Tipo de pago".$this->total_bruto;
		Executor::doitEx($sql);
		
		$renglon_objeto = New RenglonData();	
		$renglon_objeto->fact_num=$this->fact_num;		
		$renglon_objeto->co_alma=$this->co_alma;	
		$renglon_objeto->tasa=$this->tasa;		
		$renglon_objeto->dato1=$this->dato1;	
		$renglon_objeto->tipo_precio=$this->tipo_precio;
		$renglon_objeto->facturacion=$this->facturacion;
		$renglon_objeto->pago=$this->pago;		
		$renglon_objeto->add();

		
	}


	public  function getAllDatosFiltro($status,$rango){
		/// Metodo para consultar todos los datos y mostrar las tabla
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$data2 = $this->tasa();
		$tasa=$this->tasa=$data2['tasa'];

		if($rango=='NO'){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];

			$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
			p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
			p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
			INNER JOIN almacen a on p.co_sucu = a.co_alma 
			INNER JOIN clientes c on p.co_cli = c.co_cli 			
			WHERE MONTH(p.fec_emis)='$mes' and  YEAR(p.fec_emis)='$anio' AND p.co_ven = '".$co_ven."' AND p.status='".$status."' and p.anulada=0 ORDER BY p.fec_emis DESC";
		//echo $sql;
		}

		if($rango!='NO'){
		$fechaI = substr($rango, 0, 10); 	
		$fechaF = substr($rango, 14, 10); 
		$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
		p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
		p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		
		WHERE p.fec_emis between '".$fechaI."' AND '".$fechaF."' AND p.co_ven = '".$co_ven."' AND p.status='".$status."'  and p.anulada=0  ORDER BY p.fec_emis DESC";
		//echo $sql;
		}
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
			$array[$cnt]->dato1 =$r['cli_des'];			
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = number_format($r['tot_bruto']/$tasa, 2, ',', '.');			
			$array[$cnt]->tot_neto = number_format($r['tot_neto']/$tasa, 2, ',', '.');	
			$array[$cnt]->iva = number_format($r['iva']/$tasa, 2, ',', '.');	
			$array[$cnt]->status = $r['status'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}


	public  function getAllDatosFiltroGerente($status,$rango,$co_ven){
				/// Metodo para consultar todos los datos y mostrar las tabla
	
				$data2 = $this->tasa();
				$tasa=$this->tasa=$data2['tasa'];
		
		if($rango=='NO'){
			if($co_ven=='NO'){

				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];

				$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
				p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
				p.tasag, p.tasag10, p.tasag20, p.status, p.contrib,p.co_ven FROM ".self::$tablename." p 
				INNER JOIN almacen a on p.co_sucu = a.co_alma 
				INNER JOIN clientes c on p.co_cli = c.co_cli 			
				WHERE MONTH(p.fec_emis)='$mes' and  YEAR(p.fec_emis)='$anio' AND p.status='".$status."'  and p.anulada=0 ORDER BY p.fec_emis DESC";
				// p.fec_emis = MOUNT()  MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'
				
			}else{
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];

				$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
				p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
				p.tasag, p.tasag10, p.tasag20, p.status, p.contrib,p.co_ven FROM ".self::$tablename." p 
				INNER JOIN almacen a on p.co_sucu = a.co_alma 
				INNER JOIN clientes c on p.co_cli = c.co_cli 				
				WHERE MONTH(p.fec_emis)='$mes' and  YEAR(p.fec_emis)='$anio' AND p.co_ven = '".$co_ven."' AND p.status='".$status."'  and p.anulada=0 ORDER BY p.fec_emis DESC";
				// MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'
			}
		
		}

		if($rango!='NO'){
			if($co_ven!=='NO'){
			

				$fechaI = substr($rango, 0, 10); 	
				$fechaF = substr($rango, 14, 10); 
				$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
				p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
				p.tasag, p.tasag10, p.tasag20, p.status, p.contrib,p.co_ven FROM ".self::$tablename." p 
				INNER JOIN almacen a on p.co_sucu = a.co_alma 
				INNER JOIN clientes c on p.co_cli = c.co_cli				
				WHERE p.fec_emis between '".$fechaI."' AND '".$fechaF."' AND p.co_ven = '".$co_ven."' AND p.status='".$status."'   and p.anulada=0 ORDER BY p.fec_emis DESC";

			

			}else{
			
				$fechaI = substr($rango, 0, 10); 	
				$fechaF = substr($rango, 14, 10); 
				$sql ="SELECT p.fact_num, p.saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
				p.tot_bruto, p.tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
				p.tasag, p.tasag10, p.tasag20, p.status, p.contrib,p.co_ven FROM ".self::$tablename." p 
				INNER JOIN almacen a on p.co_sucu = a.co_alma 
				INNER JOIN clientes c on p.co_cli = c.co_cli 		
				WHERE p.fec_emis between '".$fechaI."' AND '".$fechaF."'  AND p.status='".$status."'  and p.anulada=0  ORDER BY p.fec_emis DESC";

			
			}
	
	
		}
		
		
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new PedidoData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->fact_num = $r['fact_num'];
			$array[$cnt]->dato1 =$r['cli_des'];			
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = number_format($r['tot_bruto']/$tasa, 2, ',', '.');			
			$array[$cnt]->tot_neto = number_format($r['tot_neto']/$tasa, 2, ',', '.');	
			$array[$cnt]->iva = number_format($r['iva']/$tasa, 2, ',', '.');	
			$array[$cnt]->status = $r['status'];
			$array[$cnt]->dato2 = $r['co_ven'];
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

		$data2 = $this->tasa();
		$tasa=$this->tasa=$data2['tasa'];

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
			$array[$cnt]->dato1 =$r['cli_des'];			
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tot_bruto = number_format($r['tot_bruto']/$tasa, 2, ',', '.');			
			$array[$cnt]->tot_neto = number_format($r['tot_neto']/$tasa, 2, ',', '.');	
			$array[$cnt]->iva = number_format($r['iva']/$tasa, 2, ',', '.');	
			$array[$cnt]->status = $r['status'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}


	public static function ultimoPedido($co_cli){
		$co_alma=$_SESSION['co_alma'];
		$sql = "SELECT max(fact_num) as fact_num FROM pedidos WHERE co_cli='".$co_cli."' AND co_sucu='".$co_alma."'";
		//echo $sql;
		$fact_num=Executor::doit($sql);
		//echo $fact_num;
		return $fact_num;

	
}


	public static function ultima(){
			$co_alma=$_SESSION['co_alma'];

			$sql = "SELECT max(fact_num)+1 as fact_num FROM pedidos WHERE co_sucu='".$co_alma."'";
			//echo $sql;
			$fact_num=Executor::doit($sql);
			//echo $fact_num;
			return $fact_num;

		
	}

	
	public static function tasa(){
		$sql = "select cambio as tasa from moneda where co_mone = 'US$'";

		//select cambio as tasa2 from moneda where co_mone = 'BCV'

		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}
		
	public static function tasa2(){
		$sql = "select cambio as tasa from moneda where co_mone = 'BCV'";
		//select cambio as tasa2 from moneda where co_mone = 'BCV'
		
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

	public function eliminar(){
		$sql = "DELETE FROM ".self::$tablename." WHERE fact_num='$this->fact_num'";
		//echo $sql;
		//echo "<br>";
		Executor::doitEx($sql);
	}

	public function eliminarPedidoRenglon(){
		$sql = "DELETE FROM reng_ped WHERE fact_num='$this->fact_num'";
		//echo $sql;
		//echo "<br>";
		Executor::doitEx($sql);
	}

	public function anular(){
		$sql = "UPDATE ".self::$tablename." SET anulada=1 WHERE fact_num='$this->fact_num'";
		//echo $sql;
		//echo "<br>";
		Executor::doitEx($sql);
	}

	public function anularPedidoRenglon($co_art,$cantidad){
		$co_alma=$_SESSION['almacen'];
		$sql= "UPDATE st_almac SET stock_com = stock_com - ".$cantidad." WHERE co_art ='".$co_art."' AND co_alma = '".$co_alma."'";
		//echo $sql;
		//echo "<br>";
		Executor::doitEx($sql);
	}

	public function anularArt($co_art,$cantidad){
		$co_alma=$_SESSION['almacen'];
		$sql= "UPDATE art SET stock_com = stock_com - ".$cantidad." WHERE co_art ='".$co_art."'";
		//echo $sql;
		//echo "<br>";
		Executor::doitEx($sql);
	}


	
	
	
}
?>