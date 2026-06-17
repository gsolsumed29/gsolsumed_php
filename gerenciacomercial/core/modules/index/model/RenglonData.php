<?php
class RenglonData {
	public static $tablename = "reng_ped";	
//  (fact_num, reng_num, co_art, co_alma, total_art, pendiente, uni_venta, prec_vta, tipo_imp, reng_neto,
// cos_pro_un, ult_cos_un, fec_lote, ult_cos_om)


/*
fact_num = numero del pedido
reng_num = numero del renglon debe ser la variable del ciclo
co_art = codigo del articulo
co_alma = codigo del almacen a usar ($_session['co_alma']);
total_art = total de articulos		(carrito)
pendiente = total de articulos
uni_venta = unidad de venta del articulo
prec_vta = precio1
prec_vta2 = precio1/tasa
tipo_imp = impue
reng_neto = total_art * prec_vta
cos_pro_un = cos_pro_un del articulo
ult_cos_un =  ult_cos_un del articulos
fec_lote = fecha del dia
ult_cos_om = ult_cos_om del articulo*/

		public function __construct(){		
		$this->fact_num= '0';	//peiddo
		$this->reng_num= '0';	//carrito		
		$this->co_art= '0';		//carrito
		$this->co_alma= '0';	//pedido
		$this->total_art= '0';	//carrito
		$this->pendiente= '0';	//pedido
		$this->uni_venta= '0';	// carrito	
		$this->prec_vta= '0';	//carrito
		$this->tipo_imp= '0';	////no lo estoy llevando
		$this->reng_neto= '0';	
		$this->cos_pro_un= '0';
		$this->ult_cos_un= '0';
		$this->fec_lote= '0';	//pedido
		$this->ult_cos_om= '0';		
		
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}


	public function add(){
			// Agregar un pedido en la tabla pedidos 
			date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
		$articulo_objeto = New ArticuloData();
		$carrito_objeto = new CarritoData();
		$data = $carrito_objeto->contents_total();
		$item = 1;
		$acu =1;
		foreach($data as $carrito){
			for($i=1;$i<=$carrito['qty'];$i++){
				$data_articulo=$articulo_objeto->getDataID($carrito['co_art'],1);
				$co_art = $carrito['co_art'];	
				$total_art = $carrito['qty'];		
				$uni_venta = $data_articulo[0]->suni_venta;
				$prec_vta1 = $data_articulo[0]->prec_vta1;
				$tipo_imp = $data_articulo[0]->tipo_imp;				

				$ult_cos_om = $data_articulo[0]->ult_cos_om;
				$ult_cos_un = $data_articulo[0]->ult_cos_un;
				$cos_pro_un = $data_articulo[0]->cos_pro_un;

				$ren_neto = $total_art*$prec_vta1;

		$sql ="INSERT INTO ".self::$tablename."(fact_num, reng_num, co_art, co_alma, total_art, pendiente, uni_venta, prec_vta, tipo_imp, reng_neto,
		cos_pro_un, ult_cos_un, fec_lote, ult_cos_om) ";
		$sql.=" VALUES('$this->fact_num',$acu,'$co_art','$this->co_alma',$total_art,$total_art,'$uni_venta',$prec_vta1,$tipo_imp,$ren_neto,$cos_pro_un,$ult_cos_un,'$date','$ult_cos_om')";
		//echo "<br>";
		//echo $sql;

		Executor::doitEx($sql);
				$acu=$acu+1;
			
			}
			
			$item++;
		}
		//echo $acu;
		
		
	}

	public static function getAllDatos(){
		/// Metodo para consultar todos los datos y mostrar las tablas
		// solo para adminsitrador
		$co_sub = $_SESSION['almacen'];
		$sql ="SELECT a.prec_vta1, a.prec_vta2, a.prec_vta3,a.co_art,a.uni_venta,a.ult_cos_om, a.ult_cos_un, a.cos_pro_un, a.prec_vta4, a.co_art, a.art_des, (st.stock_act - st.stock_com) stock_act,
		case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp
		FROM ".self::$tablename." a 
		INNER JOIN st_almac st on a.co_art = st.co_art  
		inner join tabulado t on a.tipo_imp = t.tipo
		WHERE a.tipo='V' AND a.anulado = 0 AND st.co_alma = '".$co_sub."' 
		ORDER BY a.co_art ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art = $r['co_art'];
			$array[$cnt]->art_des = $r['art_des'];			
			$array[$cnt]->stock_act = (float)number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =(float)number_format($r['prec_vta1'], 2, ',', '.');
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
	
}
?>