<?php
class ArticuloData {
	public static $tablename = "art";	

		public function __construct(){
		 $this->co_art = 0;
		$this->art_des = "";
		$this->stock_act = "";
		$this->suni_venta = "";
		$this->prec_vta1 = "";
		$this->prec_vta2 = "";
		$this->tipo_imp = "";
		$this->impuesto = "";
		$this->movil ='';	
		
		$this->impuesto ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}

	public static function contarArticulos($almacen){
		$co_sub = $_SESSION['almacen'];
		$sql ="SELECT count(a.co_art) AS cuenta FROM ".self::$tablename." a 	
		INNER JOIN st_almac st on a.co_art = st.co_art  
		WHERE a.anulado = 0 AND (st.stock_act - st.stock_com)>0 AND  st.co_alma = '".$co_sub."'";
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		//echo $e;
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art = $r['cuenta'];
		
			$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function getAllDatos(){
		// por defecto precio 3
		$co_sub = $_SESSION['almacen'];

		$tipo_precio = $_SESSION['tipo'];

		if($tipo_precio==3){
			 $sql = "SELECT case when a.tipo = '6'  then  a.prec_vta3/1.16 else a.prec_vta3 as precio ,  case when campo1 = '<*>' then 'NOTA' ELSE 'FACTURA' END as tipo_art,
		a.ult_cos_om,a.ult_cos_un,a.cos_pro_un, a.co_art, a.art_des, (st.stock_act - st.stock_com) stock_act,uni_venta as suni_venta,
		case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp, a.co_lin
		FROM ".self::$tablename." a 
		INNER JOIN st_almac st on a.co_art = st.co_art  
		INNER join tabulado t on a.tipo_imp = t.tipo
		WHERE a.tipo='V' AND a.anulado = 0 AND st.co_alma = '".$co_sub."'   and st.stock_act > 0
		ORDER BY a.co_art ASC";
		}
			
	

		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			
			
			
			
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);					
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =number_format($r['precio'], 2, ',', '.');
			$array[$cnt]->prec_vta2 =number_format(($r['precio']), 2, ',', '.');
			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getAllDataFiltrada($filtro){


		/// Metodo para consultar todos los datos y mostrar las tablas
		// solo para adminsitrador
	
		//echo $tipo;
		$co_sub = $_SESSION['almacen'];

		if($filtro =='NO'){

			$sql ="SELECT case when a.co_lin = '01' then (case when a.tipo_imp = '1' then (a.prec_vta1/1.16) else a.prec_vta1 end)
			else (case when a.tipo_imp = '1' then (a.prec_vta2/1.16) else a.prec_vta2 end) end as prec_vta,  
			a.co_art,a.uni_venta,a.ult_cos_om, a.ult_cos_un, a.cos_pro_un, a.prec_vta4, a.co_art,
			a.art_des, (st.stock_act - st.stock_com) stock_act,uni_venta as suni_venta,
			case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp
			FROM art a
			INNER JOIN st_almac st on a.co_art = st.co_art  
			INNER join tabulado t on a.tipo_imp = t.tipo
			WHERE a.tipo='V' AND a.anulado = 0 AND st.co_alma = '$co_sub' and st.stock_act > 0
			ORDER BY a.co_art ASC";	

		}else{

			$sql ="SELECT case when a.co_lin = '01' then (case when a.tipo_imp = '1' then (a.prec_vta1/1.16) else a.prec_vta1 end)
			else (case when a.tipo_imp = '1' then (a.prec_vta2/1.16) else a.prec_vta2 end) end as prec_vta,  
			a.co_art,a.uni_venta,a.ult_cos_om, a.ult_cos_un, a.cos_pro_un, a.prec_vta4, a.co_art,
			a.art_des, (st.stock_act - st.stock_com) stock_act,uni_venta as suni_venta,
			case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp
			FROM art a
			INNER JOIN st_almac st on a.co_art = st.co_art  
			INNER join tabulado t on a.tipo_imp = t.tipo
			WHERE a.co_cat ='$filtro' and a.tipo='V' AND a.anulado = 0 AND st.co_alma = '$co_sub' and st.stock_act > 0
			ORDER BY a.co_art ASC";	

		}
		
		$ObjetoPedido = New PedidoData();
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 	
			

				//
				$data= $ObjetoPedido->tasa(); // usd -> dolares
				$tasa=$data['tasa'];
				//echo "Tasa2";
			
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);					
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =$r['prec_vta'];
			$array[$cnt]->prec_vta2 =$r['prec_vta']*$tasa;
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getAllDataFiltradaListaPrecios($filtro){


		/// Metodo para consultar todos los datos y mostrar las tablas
		// solo para adminsitrador
	
		//echo $tipo;
		$co_sub = $_SESSION['almacen'];

		if($filtro =='NO'){

			$sql = "SELECT 
			a.prec_vta1,
			a.prec_vta2, 
			a.prec_vta3,
			a.prec_vta4,
			cl.des_col,
			CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta1/1.16) ELSE a.prec_vta1 END as prec_vta1_sin_iva,
			CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta2/1.16) ELSE a.prec_vta2 END as prec_vta2_sin_iva,
			CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta3/1.16) ELSE a.prec_vta3 END as prec_vta3_sin_iva,
			CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta4/1.16) ELSE a.prec_vta4 END as prec_vta4_sin_iva,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om, 
			a.ult_cos_un, 
			a.cos_pro_un,
			l.lin_des,
				ca.cat_des,
			a.art_des, 
			(st.stock_act - st.stock_com) as stock_act,
			a.uni_venta,
			CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END as impuesto, 
			a.tipo_imp,
			CASE WHEN a.tipo_imp = 1 THEN 'G' ELSE 'E' END as tipo_impuesto_desc
		FROM art a
		INNER JOIN st_almac st ON a.co_art = st.co_art  
		INNER JOIN tabulado t ON a.tipo_imp = t.tipo
		INNER JOIN colores cl ON a.co_color = cl.co_col
		INNER JOIN lin_art l ON a.co_lin =l.co_lin  
				INNER JOIN cat_art ca ON a.co_cat = ca.co_cat
		WHERE a.tipo = 'V' 
		  AND a.anulado = 0 
		  AND st.co_alma = $co_sub
		  AND st.stock_act > 0
		ORDER BY a.co_art ASC";

		}else{


			$sql ="SELECT a.prec_vta1,
			a.prec_vta2,
			a.prec_vta3,
			a.prec_vta4,
			cl.des_col,
			CASE WHEN a.tipo_imp='1'THEN(a.prec_vta1/1.16)ELSE a.prec_vta1 END as prec_vta1_sin_iva,
			CASE WHEN a.tipo_imp='1'THEN(a.prec_vta2/1.16)ELSE a.prec_vta2 END as prec_vta2_sin_iva,
			CASE WHEN a.tipo_imp='1'THEN(a.prec_vta3/1.16)ELSE a.prec_vta3 END as prec_vta3_sin_iva,
			CASE WHEN a.tipo_imp='1'THEN(a.prec_vta4/1.16)ELSE a.prec_vta4 END as prec_vta4_sin_iva,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om,
			a.ult_cos_un,
			a.cos_pro_un,
			l.lin_des,
			ca.cat_des,
			a.art_des,
			(st.stock_act-st.stock_com)as stock_act,
			a.uni_venta,
			CASE WHEN a.tipo_imp=1 THEN t.porc_vent ELSE t.porc_cxs END as impuesto,
			a.tipo_imp,
			CASE WHEN a.tipo_imp=1 THEN 'G'ELSE 'E'END as tipo_impuesto_desc FROM art a 
			INNER JOIN st_almac st ON a.co_art=st.co_art 
			INNER JOIN tabulado t ON a.tipo_imp=t.tipo 
			INNER JOIN colores cl ON a.co_color=cl.co_col 
			INNER JOIN lin_art l ON a.co_lin=l.co_lin
			INNER JOIN cat_art ca ON a.co_cat = ca.co_cat
			WHERE a.tipo='V'AND a.anulado=0 AND st.co_alma=$co_sub AND st.stock_act>0 ORDER BY a.co_art ASC";

		

		}
		
	
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 		

		
				//echo "Tasa2";			
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->tipo_impuesto_desc = $r['tipo_impuesto_desc'];	
			$array[$cnt]->des_col = $r['des_col'];	
			$array[$cnt]->lin_des = $r['cat_des'];	
			$array[$cnt]->stock_act = (float)$r['stock_act'];			
			$array[$cnt]->prec_vta1 =(float)$r['prec_vta1'];
			$array[$cnt]->prec_vta2 =(float)$r['prec_vta2'];
			$array[$cnt]->prec_vta3 =(float)$r['prec_vta3'];
			$array[$cnt]->prec_vta4 =(float)$r['prec_vta4'];
			$array[$cnt]->imagen ='../admin/storage/items/'.trim($r['co_art']).'.webp';
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getAllDataFiltradaArticulos($filtro){
	
		$co_sub = $_SESSION['almacen'];

		if($filtro =='NO'){	

			$sql="SELECT case when co_lin = '01' then (prec_vta1) else prec_vta2 end precio,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om,
			a.ult_cos_un,
			a.cos_pro_un,
			a.prec_vta4,
			a.art_des,
			(st.stock_act-st.stock_com)stock_act,
			uni_venta as suni_venta,	c.des_col AS color ,
			case when a.tipo_imp=1 then t.porc_vent else t.porc_cxs end as impuesto,
			a.tipo_imp, a.co_lin FROM art a INNER JOIN st_almac st on a.co_art=st.co_art
			INNER join tabulado t on a.tipo_imp=t.tipo
			INNER JOIN colores c ON a.co_color = c.co_col 
			WHERE a.tipo='V' AND st.co_alma='$co_sub' AND a.anulado=0  and st.stock_act>0 ORDER BY 2 ASC";

			

		}else{

			$sql="SELECT case when co_lin = '01' then (prec_vta1) else prec_vta2 end precio,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om,
			a.ult_cos_un,
			a.cos_pro_un,
			a.prec_vta4,
			a.art_des,	c.des_col AS color ,
			(st.stock_act-st.stock_com)stock_act,
			uni_venta as suni_venta,
			case when a.tipo_imp=1 then t.porc_vent else t.porc_cxs end as impuesto,
			a.tipo_imp, a.co_cat FROM art a 
			INNER JOIN st_almac st on a.co_art=st.co_art
			INNER join tabulado t on a.tipo_imp=t.tipo		
			INNER JOIN colores c ON a.co_color = c.co_col 
			WHERE a.tipo='V' AND a.co_cat in('$filtro') AND st.co_alma='$co_sub' AND a.anulado=0 AND st.co_alma='01'and st.stock_act>0 ORDER BY 2 ASC";

			

			
		}					
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			
		
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);					
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =$r['precio'];
			$array[$cnt]->lin_des =$r['color'];

			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getAllDataFiltradaArticulos_gerente($filtro,$tipo){


		/// Metodo para consultar todos los datos y mostrar las tablas
		// solo para adminsitrador
		//$tipo =  $_SESSION['tipo'];
		//echo $tipo;
		$co_sub = $_SESSION['almacen'];

		if($filtro =='NO'){
			$sql="SELECT case when co_lin = '01' then (prec_vta1) else prec_vta2 end precio,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om,
			a.ult_cos_un,
			a.cos_pro_un,
			a.prec_vta4,
			a.art_des,
			(st.stock_act-st.stock_com)stock_act,
			uni_venta as suni_venta,
			case when a.tipo_imp=1 then t.porc_vent else t.porc_cxs end as impuesto,
			a.tipo_imp, a.co_lin FROM art a INNER JOIN st_almac st on a.co_art=st.co_art
			INNER join tabulado t on a.tipo_imp=t.tipo
			WHERE a.tipo='V' AND st.co_alma='$co_sub' AND a.anulado=0 and st.stock_act>0 ORDER BY 2 ASC";


		}else{

			$sql="SELECT case when co_lin = '01' then (prec_vta1) else prec_vta2 end precio,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om,
			a.ult_cos_un,
			a.cos_pro_un,
			a.prec_vta4,
			a.art_des,
			(st.stock_act-st.stock_com)stock_act,
			uni_venta as suni_venta,
			case when a.tipo_imp=1 then t.porc_vent else t.porc_cxs end as impuesto,
			a.tipo_imp, a.co_lin FROM art a INNER JOIN st_almac st on a.co_art=st.co_art
			INNER join tabulado t on a.tipo_imp=t.tipo
			WHERE a.tipo='V' AND a.co_lin in('$filtro') AND st.co_alma='$co_sub' AND a.anulado=0 AND st.co_alma='01'and st.stock_act>0 ORDER BY 2 ASC";
			
			
			
		}
				
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
		
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);					
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =$r['precio'];
			$array[$cnt]->prec_vta2 =$r['precio'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataFiltrada($filtro,$almacen,$tipo_precio,$facturacion,$pago){
		$co_sub = $_SESSION['almacen'];
		
	
		/*
		echo "Tipo de precio: ".$tipo_precio;
		echo "Facturacion: ".$facturacion;
		echo "Pago: ".$pago;
		*/
		
		

		if($tipo_precio=='01'){
			  $precio_buscar = "prec_vta1";
		}else{
			  $precio_buscar = "prec_vta2";
		}
		
		
		if($facturacion==1){
				if($pago==1){	
					//	echo "FACTURACION FISCAL EN BOLIVARES";				
					$objeto_tasa = new PagoRegData();
					$monto_tasa_2 = $objeto_tasa->getDataTasa('USD');
					$monto_2 = $monto_tasa_2['tasa'];
					$monto_tasa_1 = $objeto_tasa->getDataTasa('US$');
					$monto_1 = $monto_tasa_1['tasa'];
					 
						$sql="SELECT  TOP ".NUM_ITEMS_BY_PAGE." CASE WHEN a.pie ='3' THEN ((a.$precio_buscar*$monto_2)/$monto_1) 
						 ELSE  ((a.$precio_buscar)) END AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0
						AND (( a.art_des LIKE '%".$filtro."%' )  OR (a.co_art LIKE '%".$filtro."%' )) 
					ORDER BY 
						a.co_art ASC ";
				}else{
						//echo "FACTURACION FISCAL EN DOLARES";		
					$sql="SELECT  TOP ".NUM_ITEMS_BY_PAGE."  ((a.$precio_buscar)) AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0
						AND (( a.art_des LIKE '%".$filtro."%' )  OR (a.co_art LIKE '%".$filtro."%' )) 
					ORDER BY 
						a.co_art ASC ";
				}
			}else{
				if($pago==1){			
						//echo "FACTURACION NOTA EN BOLIVARES";			
					$objeto_tasa = new PagoRegData();
					$monto_tasa_2 = $objeto_tasa->getDataTasa('USD');
					$monto_2 = $monto_tasa_2['tasa'];
					$monto_tasa_1 = $objeto_tasa->getDataTasa('US$');
					$monto_1 = $monto_tasa_1['tasa'];
					 
						$sql="SELECT  TOP ".NUM_ITEMS_BY_PAGE."  CASE WHEN a.pie ='3' THEN ((a.$precio_buscar*$monto_2)/$monto_1) 
						 ELSE  ((a.$precio_buscar)) END AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0
						AND (( a.art_des LIKE '%".$filtro."%' )  OR (a.co_art LIKE '%".$filtro."%' )) 
					ORDER BY 
						a.co_art ASC ";
				}else{
						//echo "FACTURACION NOTA EN DOLARES";			
					$sql="SELECT  TOP ".NUM_ITEMS_BY_PAGE."  ((a.$precio_buscar)) AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0
						AND (( a.art_des LIKE '%".$filtro."%' )  OR (a.co_art LIKE '%".$filtro."%' )) 
					ORDER BY 
						a.co_art ASC ";
				}

			}
				
		
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		//echo $e;
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$objeto_funciones = new FuncionesData();
			$data = $objeto_funciones->getMedia(trim($r['co_art']));
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art = trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);							
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =number_format($r['precio'], 2, ',', '.');
			$array[$cnt]->tipo_art =trim($r['tipo_art']);
			$array[$cnt]->marca =trim($r['color']);
			$array[$cnt]->media = $data;		
			$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function getDataPaginas($offset,$rowsPerPage,$id,$almacen,$precio_buscar,$facturacion,$pago){
		
		$co_sub = $_SESSION['almacen'];

		// Metodo para paginar los resultado
		$precio_buscar = "prec_vta2";

  				

		
		if($precio_buscar=='01'){
			  $precio_buscar = "prec_vta1";
		}else{
			  $precio_buscar = "prec_vta2";
		}
		
		if($facturacion==1){
				if($pago==1){			

					$objeto_tasa = new PagoRegData();
					$monto_tasa_2 = $objeto_tasa->getDataTasa('USD');
					$monto_2 = $monto_tasa_2['tasa'];
					$monto_tasa_1 = $objeto_tasa->getDataTasa('US$');
					$monto_1 = $monto_tasa_1['tasa'];
					
						$sql="SELECT CASE WHEN a.pie ='3' THEN ((a.$precio_buscar*$monto_2)/$monto_1) 
						 ELSE  ((a.$precio_buscar)) END AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
					ORDER BY 
						a.co_art ASC 
					OFFSET ".$offset." ROWS
					FETCH NEXT ".$rowsPerPage." ROWS ONLY;";

				}else{					
					
						$sql="SELECT ((a.$precio_buscar)) AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
					ORDER BY 
						a.co_art ASC 
					OFFSET ".$offset." ROWS
					FETCH NEXT ".$rowsPerPage." ROWS ONLY;";

				}

		}else{
				if($pago==1){

						$objeto_tasa = new PagoRegData();
						$monto_tasa_2 = $objeto_tasa->getDataTasa('USD');
						$monto_2 = $monto_tasa_2['tasa'];
						$monto_tasa_1 = $objeto_tasa->getDataTasa('US$');
						$monto_1 = $monto_tasa_1['tasa'];

					$sql="SELECT CASE WHEN a.pie ='3' THEN ((a.$precio_buscar*$monto_2)/$monto_1) 
						 ELSE  ((a.$precio_buscar)) END AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
					ORDER BY 
						a.co_art ASC 
					OFFSET ".$offset." ROWS
					FETCH NEXT ".$rowsPerPage." ROWS ONLY;";

				}else{
						
						$sql="SELECT ((a.$precio_buscar)) AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
					ORDER BY 
						a.co_art ASC 
					OFFSET ".$offset." ROWS
					FETCH NEXT ".$rowsPerPage." ROWS ONLY;";

				}

		}		
	

		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
	
		if($e>=1){
			$array = array();
			$cnt = 0;	
		foreach($query as $r) {

			$objeto_funciones = new FuncionesData();
			$data = $objeto_funciones->getMedia(trim($r['co_art']));

			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);								
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =number_format($r['precio'], 2, ',', '.');
			$array[$cnt]->tipo_art =trim($r['tipo_art']);
			$array[$cnt]->marca =trim($r['color']);
			$array[$cnt]->media = $data;		
			//tipo_art
			$cnt++;
		}
		return $array;
		}else{

			$array = array();
			return $array;
		}
	}

	public static function getDataID($co_art,$almacen,$tipo_precio,$facturacion,$pago){
		
		
			$co_sub = $_SESSION['almacen'];

		// Metodo para paginar los resultado
		$precio_buscar = "prec_vta2";

	
		if($tipo_precio=='01'){
			  $precio_buscar = "prec_vta1";
		}else{
			  $precio_buscar = "prec_vta2";
		}
		
		if($facturacion==1){
				if($pago==1){
					
					$objeto_tasa = new PagoRegData();
					$monto_tasa_2 = $objeto_tasa->getDataTasa('USD');
					$monto_2 = $monto_tasa_2['tasa'];
					$monto_tasa_1 = $objeto_tasa->getDataTasa('US$');
					$monto_1 = $monto_tasa_1['tasa'];
					
						$sql="SELECT CASE WHEN a.pie ='3' THEN ((a.$precio_buscar*$monto_2)/$monto_1) 
						 ELSE  ((a.$precio_buscar)) END AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
						WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
						AND a.co_art='$co_art'
					ORDER BY 
						a.co_art ASC 
				";  
				}else{
					
					
						$sql="SELECT ((a.$precio_buscar)) AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END AS impuesto,
						a.tipo_imp,
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
						AND a.co_art='$co_art'
					ORDER BY 
						a.co_art ASC 
				";
				}

		}else{
				if($pago==1){

						$objeto_tasa = new PagoRegData();
						$monto_tasa_2 = $objeto_tasa->getDataTasa('USD');
						$monto_2 = $monto_tasa_2['tasa'];
						$monto_tasa_1 = $objeto_tasa->getDataTasa('US$');
						$monto_1 = $monto_tasa_1['tasa'];

					$sql="SELECT CASE WHEN a.pie ='3' THEN ((a.$precio_buscar*$monto_2)/$monto_1) 
						 ELSE  ((a.$precio_buscar)) END AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_cxs ELSE t.porc_cxs END AS impuesto,
						CASE WHEN a.tipo_imp = 1 THEN 6 ELSE 6  END AS tipo_imp,
					
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
						WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
						AND a.co_art='$co_art'
					ORDER BY 
						a.co_art ASC 
				";


				}else{
						
						$sql="SELECT ((a.$precio_buscar)) AS precio,
						CASE WHEN a.campo1 = '<*>' THEN 'NOTA' ELSE 'FACTURA' END AS tipo_art,
						a.ult_cos_om,
						a.ult_cos_un,
						a.cos_pro_un,
						a.co_art,
						a.art_des,
						(st.stock_act - st.stock_com) AS stock_act,
						a.uni_venta AS suni_venta,
						CASE WHEN a.tipo_imp = 1 THEN t.porc_cxs ELSE t.porc_cxs END AS impuesto,
						CASE WHEN a.tipo_imp = 1 THEN 6 ELSE 6  END AS tipo_imp,
					
						a.co_lin,
						c.des_col AS color 
					FROM 
						".self::$tablename." a 
						INNER JOIN st_almac st ON a.co_art = st.co_art AND st.co_alma = '$co_sub' AND st.stock_act > 0
						INNER JOIN tabulado t ON a.tipo_imp = t.tipo 
						INNER JOIN colores c ON a.co_color = c.co_col 
					WHERE 
						a.tipo = 'V' 
						AND a.anulado = 0 
						AND a.co_art='$co_art'
					ORDER BY 
						a.co_art ASC 
				";
				}

		}		


		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		//echo $e;
		if($e>=1){
			$array = array();
			$cnt = 0;	
		foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->stock_act =(float)$r['stock_act'];			
			$array[$cnt]->prec_vta1 =number_format((float)$r['precio'], 2, '.', '');

			
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->tipo_imp = $r['tipo_imp'];
			$array[$cnt]->mont_comi = 0;
			$array[$cnt]->ult_cos_om = (float)$r['ult_cos_om'];	
			$array[$cnt]->ult_cos_un = (float)$r['ult_cos_un'];	
			$array[$cnt]->cos_pro_un = (float)$r['cos_pro_un'];	
			$array[$cnt]->marca =trim($r['color']);
			$array[$cnt]->suni_venta = trim($r['suni_venta']);					
			$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}
	
	public static function getTopVendidos(){
		$co_sub = $_SESSION['almacen'];		
		$sql ="SELECT top(10) sum(r.total_art - r.total_dev) AS tot_art, r.co_art, a.art_des FROM factura f 
		INNER join reng_fac r ON f.fact_num = r.fact_num
		INNER join art a ON r.co_art = a.co_art
		WHERE f.anulada = 0
		GROUP BY r.co_art, a.art_des
		ORDER BY 1 DESC;";
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		//echo $e;
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art = trim($r['co_art']);
			$array[$cnt]->dato1 = number_format($r['tot_art'], 2, ',', '.');			
			$array[$cnt]->art_des =$r['art_des'];		
		
			$cnt++;
		}
		return $array;
		}else{

			$array = array();
			return $array;
		}
	}

public static function getDataLineas(){
	
	//$sql ="SELECT co_lin,lin_des FROM lin_art";
	$sql = "SELECT co_cat, cat_des FROM cat_art 
        WHERE cat_des NOT LIKE '%POR UTILIZAR%' 
          AND cat_des NOT LIKE '%por utilizar%' 
          AND cat_des NOT LIKE '%Por utilizar%'";

	//echo $sql;
	$query = Executor::doitAr($sql);
	//print_r($query);
	$e=count($query);
	//echo $e;
	if($e>=1){
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {
		$array[$cnt] = new ArticuloData();

		$array[$cnt]->dato2 = trim($r['co_cat']);
		$array[$cnt]->dato3 = strtoupper(trim($r['cat_des']));		
		
	
		$cnt++;
	}
	return $array;
	}else{

		$array = array();
		return $array;
	}
}


public static function getDataTipoPrecios(){
	
	//$sql ="SELECT co_lin,lin_des FROM lin_art";
	$sql ="SELECT co_lin,lin_des FROM lin_art";

	//echo $sql;
	$query = Executor::doitAr($sql);
	//print_r($query);
	$e=count($query);
	//echo $e;
	if($e>=1){
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {
		$array[$cnt] = new ArticuloData();

		$array[$cnt]->dato2 = trim($r['co_lin']);
		$array[$cnt]->dato3 = strtoupper(trim($r['lin_des']));		
		
	
		$cnt++;
	}
	return $array;
	}else{

		$array = array();
		return $array;
	}
}

public static function getDataZonas(){
	
	//$sql ="SELECT co_lin,lin_des FROM lin_art";
	$sql ="SELECT co_zon, zon_des FROM zona";
	//echo $sql;
	$query = Executor::doitAr($sql);
	//print_r($query);
	$e=count($query);
	//echo $e;
	if($e>=1){
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {
		$array[$cnt] = new ArticuloData();
		$array[$cnt]->dato2 = trim($r['co_zon']);
		$array[$cnt]->dato3 = strtoupper(trim($r['zon_des']));		
		
	
		$cnt++;
	}
	return $array;
	}else{

		$array = array();
		return $array;
	}
}

public static function tasa(){
		$sql = "select cambio as tasa from moneda where co_mone = 'USD'";
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
}




	public static function getPreciosProveedores($filtro, $filtro2){
		// $co_sub = $_SESSION['almacen']; // Esta variable no se usa en la consulta actual

		// Si no hay filtros, ejecuta la consulta general
		if (($filtro == 'NO') && ($filtro2 == 'NO')) {

			$sql = "SELECT a.co_art, a.art_des, pv.prov_des, a.prec_vta1, a.prec_vta2, a.prec_vta3, a.prec_vta4,
						p.prec_vta1 as prec_vta1_pv ,p.prec_vta2 as prec_vta2_pv ,p.prec_vta3 as prec_vta3_pv,
						p.prec_vta4 as prec_vta4_pv, p.fecha, p.co_art_prov
					FROM jm_precios_prov p
					INNER JOIN art a ON a.co_art = p.co_art
					INNER JOIN prov pv ON p.co_prov = pv.co_prov
					ORDER BY id ASC";
			
		

		}
		if (($filtro != 'NO') && ($filtro2 == 'NO')) {

		
			// 4. Construimos la consulta SQL concatenando la variable (INSEGURO)
			$sql = "SELECT 
						a.co_art, 
						a.art_des,
						 pv.prov_des, 
						 a.prec_vta1, 
						 a.prec_vta2, 
						 a.prec_vta3,
						  a.prec_vta4,
						p.prec_vta1 as prec_vta1_pv, p.prec_vta2 as prec_vta2_pv, p.prec_vta3 as prec_vta3_pv,
						p.prec_vta4 as prec_vta4_pv, p.fecha, p.co_art_prov
					FROM jm_precios_prov p
					INNER JOIN art a ON a.co_art = p.co_art
					INNER JOIN prov pv ON p.co_prov = pv.co_prov
					WHERE a.co_art = '$filtro'
					ORDER BY id ASC";

			
			
		}

		if (($filtro != 'NO') && ($filtro2 != 'NO')) {

			// --- INICIO DE LA CORRECCIÓN (SIN PARÁMETROS) ---

			// 1. Asegurarnos de que $filtro2 sea un arreglo
			$proveedores = $filtro2;
			if (is_string($filtro2)) {
				// Si es una cadena como "J404404325,0000000084", la convertimos a un arreglo
				$proveedores = explode(',', $filtro2);
				// Limpiamos espacios en blanco de cada elemento
				$proveedores = array_map('trim', $proveedores);
			}

			// 2. Verificamos que tengamos proveedores para buscar
			if (empty($proveedores) || !is_array($proveedores)) {
				// Si no hay proveedores válidos, devolvemos un arreglo vacío
				return [];
			}

			// 3. Construimos la cadena para la cláusula IN, envolviendo cada valor en comillas simples
			// Ejemplo: ['J404404325', '0000000084'] se convierte en "'J404404325','0000000084'"
			$proveedores_para_in = "'" . implode("','", $proveedores) . "'";

			// 4. Construimos la consulta SQL concatenando la variable (INSEGURO)
			$sql = "SELECT 
						a.co_art, a.art_des, pv.prov_des, a.prec_vta1, a.prec_vta2, a.prec_vta3, a.prec_vta4,
						p.prec_vta1 as prec_vta1_pv, p.prec_vta2 as prec_vta2_pv, p.prec_vta3 as prec_vta3_pv,
						p.prec_vta4 as prec_vta4_pv, p.fecha, p.co_art_prov
					FROM jm_precios_prov p
					INNER JOIN art a ON a.co_art = p.co_art
					INNER JOIN prov pv ON p.co_prov = pv.co_prov
					WHERE a.co_art = '$filtro' AND p.co_prov IN ($proveedores_para_in)
					ORDER BY id ASC";

			
			
		}
		//echo $sql;
		$query = Executor::doitAr($sql);			
		
		$e = count($query);
		if ($e >= 1) {
			$array = array();
			$cnt = 0;
			foreach ($query as $r) {
				$array[$cnt] = new ArticuloData();

				$array[$cnt]->responsive_id = "";
				$array[$cnt]->co_art = trim($r['co_art']);
				$array[$cnt]->art_des = rtrim($r['art_des']);
				$array[$cnt]->prov_des = rtrim($r['prov_des']);
				$array[$cnt]->fecha = $r['fecha'];
				$array[$cnt]->co_art_prov = $r['co_art_prov'];

				$array[$cnt]->prec_vta1 = (float)$r['prec_vta1'];
				$array[$cnt]->prec_vta2 = (float)$r['prec_vta2'];
				$array[$cnt]->prec_vta3 = (float)$r['prec_vta3'];
				$array[$cnt]->prec_vta4 = (float)$r['prec_vta4'];

				$array[$cnt]->prec_vta1_pv = (float)$r['prec_vta1_pv'];
				$array[$cnt]->prec_vta2_pv = (float)$r['prec_vta2_pv'];
				$array[$cnt]->prec_vta3_pv = (float)$r['prec_vta3_pv'];
				$array[$cnt]->prec_vta4_pv = (float)$r['prec_vta4_pv'];

				$cnt++;
			}
			return $array;
		} else {
			return [];
		}
	}

	
	public function add_articulo_proveedor(){
		try {
			$co_ven = $_SESSION['identidad'];	
			$sql = "INSERT INTO jm_precios_prov(co_art,co_art_prov,co_prov,prec_vta1,prec_vta2,prec_vta3,prec_vta4,fecha,estatus,fecha_actualizacion,usuario_registro)";
			$sql .= "VALUES ('$this->co_art','$this->co_art_prov','$this->co_prov',$this->prec_vta1,$this->prec_vta2,$this->prec_vta3,$this->prec_vta4,getdate(),1,getdate(),'$co_ven')";		
			
			error_log("SQL: " . $sql); // Para debug
			//echo $sql;
			$result  = Executor::doitEx($sql);
			
			if($result) {
				return true;
			} else {
				error_log("Error en Executor::doitEx");
				return false;
			}
			
		} catch (Exception $e) {
			error_log("Error en add_articulo_proveedor: " . $e->getMessage());
			return false;
		}
	}

	public static function getAllDatosCombo($filtro){
			$co_sub = $_SESSION['almacen'];
		
			$sql = "SELECT			
			a.co_art,			
			a.art_des,
			c.des_col
		FROM art a
		INNER JOIN st_almac st ON a.co_art = st.co_art  	
		INNER JOIN colores c on a.co_color = c.co_col
		WHERE a.tipo = 'V' 
		  AND a.anulado = 0 
		  AND st.co_alma = $co_sub	
		AND a.co_color ='05'
		  AND ISNULL(art_des, '') + ' ' + ISNULL(des_col, '') LIKE '$filtro'
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
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des =trim($r['co_art']).' - '.rtrim($r['art_des']);
			$array[$cnt]->des_col =trim($r['des_col']);		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	

	public static function getAllDatosComboFicha($filtro){
			$co_sub = $_SESSION['almacen'];
		
			$sql = "SELECT			
			a.co_art,			
			a.art_des,
			c.des_col
		FROM art a
		INNER JOIN st_almac st ON a.co_art = st.co_art  	
		INNER JOIN colores c on a.co_color = c.co_col
		WHERE a.tipo = 'V' 
		  AND a.anulado = 0 
		  AND st.co_alma = $co_sub	
		
		  AND ISNULL(art_des, '') + ' ' + ISNULL(des_col, '') LIKE '$filtro'
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
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des =trim($r['co_art']).' - '.rtrim($r['art_des']);
			$array[$cnt]->des_col =trim($r['des_col']);		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	
	public static function getAllDatosComboProv($filtro){
			$co_sub = $_SESSION['almacen'];		
			$sql = "SELECT	
			co_prov,prov_des FROM prov	
			WHERE inactivo='false' 
			AND ISNULL(prov_des, '') + ' ' + ISNULL(co_prov, '') LIKE '$filtro'
			
			ORDER BY prov_des ASC";
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_prov =trim($r['co_prov']);
			$array[$cnt]->prov_des = rtrim($r['prov_des']);		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}




public static function getArticulosFichas($codigo){

 

    $sql = "SELECT 	top(1)		
            cl.des_col,
            a.prec_vta1,
            a.prec_vta2,
            a.prec_vta3,
            a.prec_vta4,
            a.co_art,
            a.uni_venta,
            a.ult_cos_om, 
            a.ult_cos_un, 
            a.cos_pro_un,
            a.ult_cos_om,
            l.lin_des,
            ca.cat_des,
            a.cos_prov,
            a.art_des, 
        
            a.ref as codigoBarras,
            a.item as ubicacion,
            a.campo2 as ultima_compra,
            a.campo3 as proveedor,
            a.campo4 as ultima_venta,
            CONVERT(varchar(10), a.fec_ult_om, 103) AS ultima_modificacion,
            
            a.stock_act as stock_act,
            a.uni_venta,
            CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END as impuesto, 
            a.tipo_imp,
            CASE WHEN a.tipo_imp = 1 THEN 'G' ELSE 'E' END as tipo_impuesto_desc
        FROM art a
        INNER JOIN st_almac st ON a.co_art = st.co_art  
        INNER JOIN tabulado t ON a.tipo_imp = t.tipo
        INNER JOIN colores cl ON a.co_color = cl.co_col
        INNER JOIN lin_art l ON a.co_lin =l.co_lin  
        INNER JOIN cat_art ca ON a.co_cat = ca.co_cat
        WHERE a.tipo = 'V' 
          AND a.co_art='$codigo'
          AND a.anulado = 0
        ORDER BY a.co_art ASC";

    //echo $sql;
    $query = Executor::doitAr($sql);
    $e=count($query);
    
    if($e>=1){
        $array = array();
        $cnt = 0;	
        foreach($query as $r) {
            $objeto_funciones = new FuncionesData();
            $data = $objeto_funciones->getMedia(trim($r['co_art']));
            $objeto_factura = new FacturaData();
            $data2 = $objeto_factura->getComparacionFacturasArticulos(trim($r['co_art']));

            $array[$cnt] = new ArticuloData(); 
            $array[$cnt]->responsive_id = "";  
            $array[$cnt]->co_art = trim($r['co_art']);
            $array[$cnt]->art_des = rtrim($r['art_des']);
            $array[$cnt]->impuesto = $r['impuesto'];	
            $array[$cnt]->tipo_imp = $r['tipo_imp'];	

            $array[$cnt]->stock_act = $r['stock_act'];			
            $array[$cnt]->prec_vta1 =number_format($r['prec_vta1'], 2, ',', '.');
            $array[$cnt]->prec_vta2 =number_format($r['prec_vta2'], 2, ',', '.');
            $array[$cnt]->prec_vta3 =number_format($r['prec_vta3'], 2, ',', '.');
            $array[$cnt]->prec_vta4 =number_format($r['prec_vta4'], 2, ',', '.');
            $array[$cnt]->ult_cos_om =number_format($r['ult_cos_om'], 4, ',', '.');

            // Corregido un espacio en el nombre del campo 'cos_prov '
            $array[$cnt]->cos_prov  =number_format($r['cos_prov'], 2, ',', '.');
            $array[$cnt]->des_col = trim($r['des_col']);
            $array[$cnt]->cat_des = trim($r['cat_des']);
            
            $rentabilidad =(($r['ult_cos_om']/$r['prec_vta2'])-1)*100;
            $array[$cnt]->rentabilidad = number_format($rentabilidad*-1, 4, ',', '.');

            $array[$cnt]->codigoBarras = trim($r['codigoBarras']);
            $array[$cnt]->ubicacion = rtrim($r['ubicacion']);
            $array[$cnt]->ultima_compra = trim($r['ultima_compra']);
            $array[$cnt]->proveedor = trim($r['proveedor']);
            $array[$cnt]->ultima_venta = trim($r['ultima_venta']);
            $array[$cnt]->ultima_modificacion = trim($r['ultima_modificacion']);

            // --- INICIO: CAMBIOS AQUÍ ---
            // Usamos nuestra nueva función auxiliar para formatear los valores de venta.
            $array[$cnt]->ventas_mes = self::formatearValorVentas($data2['total_mes_actual'] ?? 0);
            $array[$cnt]->ventas_anio = self::formatearValorVentas($data2['total_ano_sin_mes_actual'] ?? 0);
			$array[$cnt]->ventas_mes_int =$data2['total_mes_actual'] ?? 0;
			$array[$cnt]->ventas_mes_anterior_int = $data2['total_mes_anterior'] ?? 0;
			$array[$cnt]->ventas_mes_anterior = self::formatearValorVentas($data2['total_mes_anterior'] ?? 0);
			
            // --- FIN: CAMBIOS ---

            $array[$cnt]->media = $data;		
            $cnt++;
        }
        return $array;
    } else {
        $array = array();
        return $array;
    }
}

  	
    private static function formatearValorVentas($valor) {
        // Convertimos a un valor numérico para asegurar las comparaciones.
        $valorNumerico = floatval($valor);

        // 1. Si el valor es cero, devolvemos el texto "Sin movimientos".
        if ($valorNumerico == 0) {
            return "Sin movimientos";
        }

        // 2. Si no es cero, comprobamos si es un número entero.
        // floor() redondea hacia abajo. Si el número es igual a su versión redondeada, es entero.
        if ($valorNumerico == floor($valorNumerico)) {
            // Es un entero, lo formateamos sin decimales.
            return number_format($valorNumerico, 0, ',', '.');
        } else {
            // No es un entero, lo formateamos con 2 decimales.
            return number_format($valorNumerico, 2, ',', '.');
        }
    }
   


	public static function getListaArticulosFichas(){

				$sql = "SELECT a.co_art FROM art a	WHERE a.tipo = 'V' AND a.anulado = 0 ORDER BY a.co_art ASC";


		
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		//echo $e;
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {		
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art = trim($r['co_art']);
			
			$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}


	
	public static function getArticulosFichasPor($codigo){

				$sql = "SELECT 	top(1)		
			a.prec_vta2, 
			a.prec_vta3,
			a.prec_vta4,
			cl.des_col,
			a.prec_vta1,
			a.prec_vta2,
			a.prec_vta3,
			a.prec_vta4,
			a.co_art,
			a.uni_venta,
			a.ult_cos_om, 
			a.ult_cos_un, 
			a.cos_pro_un,
			a.ult_cos_om,
			l.lin_des,
				ca.cat_des,
				a.cos_prov,
			a.art_des, 
		
			(st.stock_act - st.stock_com) as stock_act,
			a.uni_venta,
			CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END as impuesto, 
			a.tipo_imp,
			CASE WHEN a.tipo_imp = 1 THEN 'G' ELSE 'E' END as tipo_impuesto_desc
		FROM art a
		INNER JOIN st_almac st ON a.co_art = st.co_art  
		INNER JOIN tabulado t ON a.tipo_imp = t.tipo
		INNER JOIN colores cl ON a.co_color = cl.co_col
		INNER JOIN lin_art l ON a.co_lin =l.co_lin  
		
				INNER JOIN cat_art ca ON a.co_cat = ca.co_cat
		WHERE a.tipo = 'V' 
		 AND (a.co_art LIKE '%$codigo%' OR a.art_des LIKE '%$codigo%')
		 
		ORDER BY a.co_art ASC";


		
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		//echo $e;
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$objeto_funciones = new FuncionesData();
			$data = $objeto_funciones->getMedia(trim($r['co_art']));
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art = trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	



			$array[$cnt]->stock_act = $r['stock_act'];			
			$array[$cnt]->prec_vta1 =number_format($r['prec_vta1'], 2, ',', '.');
			$array[$cnt]->prec_vta2 =number_format($r['prec_vta2'], 2, ',', '.');
			$array[$cnt]->prec_vta3 =number_format($r['prec_vta3'], 2, ',', '.');
			$array[$cnt]->prec_vta4 =number_format($r['prec_vta4'], 2, ',', '.');
		$array[$cnt]->ult_cos_om =number_format($r['ult_cos_om'], 4, ',', '.');

				$array[$cnt]->cos_prov  =number_format($r['cos_prov '], 2, ',', '.');
				$array[$cnt]->des_col = trim($r['des_col']);
				$array[$cnt]->cat_des = trim($r['cat_des']);
			
			$rentabilidad =(($r['ult_cos_om']/$r['prec_vta2'])-1)*100;

			$array[$cnt]->rentabilidad = number_format($rentabilidad*-1, 4, ',', '.');


			$array[$cnt]->media = $data;		
			$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}



	

public static function getArticulosFichas_Analisis_ventas(){

 		$hoy = getdate();
        $mes = $hoy['mon'];
        $anio = $hoy['year'];

    $sql = "WITH UltimaCompra AS(SELECT r.co_art,
		MAX(c.fec_emis)AS Fecha_Ult_Compra FROM compras c INNER JOIN reng_com r ON c.fact_num=r.fact_num WHERE c.anulada=0 GROUP BY r.co_art),
		VentasMensuales AS(SELECT r.co_art,
		a.art_des,
		a.modelo,
		MAX(MAX(T.fec_emis))OVER(PARTITION BY r.co_art)AS Fecha_Ult_Venta,
		CASE MONTH(T.fec_emis)WHEN 1 THEN 'Enero'WHEN 2 THEN 'Febrero'WHEN 3 THEN 'Marzo'WHEN 4 THEN 'Abril'WHEN 5 THEN 'Mayo'WHEN 6 THEN 'Junio'WHEN 7 THEN 'Julio'WHEN 8 THEN 'Agosto'WHEN 9 THEN 'Septiembre'WHEN 10 THEN 'Octubre'WHEN 11 THEN 'Noviembre'WHEN 12 THEN 'Diciembre'END AS Nombre_Mes,
		FORMAT(T.fec_emis,
		'yyyyMM')AS Periodo_Clave,
		SUM(CAST(ISNULL(r.total_art,
		0)AS DECIMAL(18,
		2))-CAST(ISNULL(r.total_dev,
		0)AS DECIMAL(18,
		2)))AS Unidades_Vendidas FROM factura T INNER JOIN reng_fac r ON t.fact_num=r.fact_num INNER JOIN art a ON r.co_art=a.co_art WHERE						
		YEAR(T.fec_emis)='$anio'AND t.anulada=0 GROUP BY r.co_art,
		a.art_des,
		a.modelo,
		MONTH(T.fec_emis),
		FORMAT(T.fec_emis,
		'yyyyMM')),
		DatosParaReporte AS(SELECT v.co_art,
		v.art_des,
		v.modelo,
		v.Fecha_Ult_Venta,
		uc.Fecha_Ult_Compra,
		v.Nombre_Mes,
		v.Unidades_Vendidas,
		SUM(v.Unidades_Vendidas)OVER(PARTITION BY v.co_art)AS Total_Periodo,
		COUNT(*)OVER(PARTITION BY v.co_art)AS Meses_Activos,
		CAST(SUM(v.Unidades_Vendidas)OVER(PARTITION BY v.co_art)/CAST(NULLIF(COUNT(*)OVER(PARTITION BY v.co_art),
		0)AS DECIMAL(18,
		2))AS DECIMAL(18,
		2))AS Promedio_Real FROM VentasMensuales v LEFT JOIN UltimaCompra uc ON v.co_art=uc.co_art)SELECT co_art AS Codigo,
		art_des AS Descripcion,
		modelo as Modelo,[Fecha_Ult_Compra]AS[Ult.Compra],[Fecha_Ult_Venta]AS[Ult.Venta],Meses_Activos AS[Meses_Act],
		ISNULL(Enero,
		0)AS Ene,
		ISNULL(Febrero,
		0)AS Feb,
		ISNULL(Marzo,
		0)AS Mar,
		ISNULL(Abril,
		0)AS Abr,
		ISNULL(Mayo,
		0)AS May,
		ISNULL(Junio,
		0)AS Jun,
		ISNULL(Julio,
		0)AS Jul,
		ISNULL(Agosto,
		0)AS Ago,
		ISNULL(Septiembre,
		0)AS Sep,
		ISNULL(Octubre,
		0)AS Oct,
		ISNULL(Noviembre,
		0)AS Nov,
		ISNULL(Diciembre,
		0)AS Dic,
		Total_Periodo,
		Promedio_Real FROM DatosParaReporte PIVOT(SUM(Unidades_Vendidas)FOR Nombre_Mes IN(Enero,
		Febrero,
		Marzo,
		Abril,
		Mayo,
		Junio,
		Julio,
		Agosto,
		Septiembre,
		Octubre,
		Noviembre,
		Diciembre))AS TablaPivotada ORDER BY co_art;
		";

	//echo $sql;
    $query = Executor::doitAr($sql);
    $e=count($query);
    
    if($e>=1){
        $array = array();
        $cnt = 0;	
        foreach($query as $r) {
        
            $array[$cnt] = new ArticuloData(); 
         
            $array[$cnt]->codigo = trim($r['Codigo']);
            $array[$cnt]->descripcion = rtrim($r['Descripcion']);
    		$array[$cnt]->modelo = rtrim($r['Modelo']);

			$array[$cnt]->ultVenta = rtrim($r['Ult.Venta']);
			$array[$cnt]->ultCompra = rtrim($r['Ult.Compra']);
			$array[$cnt]->mesesAct = rtrim($r['Meses_Act']);
			$array[$cnt]->total = (float)($r['Total_Periodo']);
			$array[$cnt]->promedio = (float)($r['Promedio_Real']);

				$array[$cnt]->Ene = $r['Ene'];
				$array[$cnt]->Feb = $r['Feb'];
				$array[$cnt]->Mar = $r['Mar'];
				$array[$cnt]->Abr = $r['Abr'];
				$array[$cnt]->May = $r['May'];
				$array[$cnt]->Jun = $r['Jun'];	
				$array[$cnt]->Jul = $r['Jul'];	
				$array[$cnt]->Ago = $r['Ago'];	
				$array[$cnt]->Sep = $r['Sep'];	
				$array[$cnt]->Oct = $r['Oct'];	
				$array[$cnt]->Nov = $r['Nov'];	
				$array[$cnt]->Dic = $r['Dic'];	
	
            // --- FIN: CAMBIOS ---

           
            $cnt++;
        }
        return $array;
    } else {
       return array(); 
    }
}


public static function getArticulosDashboard($filtro,$marca,$limite,$ff){


	/// Metodo para consultar todos los datos y mostrar las tablas
	// solo para adminsitrador

	//echo $tipo;
	$co_sub = $_SESSION['almacen'];

	if($filtro =='NO'){

		$sql = "SELECT 
		a.prec_vta1,
		a.prec_vta2, 
		a.prec_vta3,
		a.prec_vta4,
		cl.des_col,
		CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta1/1.16) ELSE a.prec_vta1 END as prec_vta1_sin_iva,
		CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta2/1.16) ELSE a.prec_vta2 END as prec_vta2_sin_iva,
		CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta3/1.16) ELSE a.prec_vta3 END as prec_vta3_sin_iva,
		CASE WHEN a.tipo_imp = '1' THEN (a.prec_vta4/1.16) ELSE a.prec_vta4 END as prec_vta4_sin_iva,
		a.co_art,
		a.uni_venta,
		a.ult_cos_om, 
		a.ult_cos_un, 
		a.cos_pro_un,
		l.lin_des,
			ca.cat_des,
		a.art_des, 
		(st.stock_act - st.stock_com) as stock_act,
		a.uni_venta,
		CASE WHEN a.tipo_imp = 1 THEN t.porc_vent ELSE t.porc_cxs END as impuesto, 
		a.tipo_imp,
		CASE WHEN a.tipo_imp = 1 THEN 'G' ELSE 'E' END as tipo_impuesto_desc
	FROM art a
	INNER JOIN st_almac st ON a.co_art = st.co_art  
	INNER JOIN tabulado t ON a.tipo_imp = t.tipo
	INNER JOIN colores cl ON a.co_color = cl.co_col
	INNER JOIN lin_art l ON a.co_lin =l.co_lin  
			INNER JOIN cat_art ca ON a.co_cat = ca.co_cat
	WHERE a.tipo = 'V' 
	  AND a.anulado = 0 
	  AND st.co_alma = $co_sub
	  AND st.stock_act > 0
	  AND cl.co_col = '$marca'
	ORDER BY a.co_art ASC
	OFFSET 0 ROWS
    FETCH NEXT $limite ROWS ONLY";

	}else{


		$sql ="SELECT a.prec_vta1,
		a.prec_vta2,
		a.prec_vta3,
		a.prec_vta4,
		cl.des_col,
		CASE WHEN a.tipo_imp='1'THEN(a.prec_vta1/1.16)ELSE a.prec_vta1 END as prec_vta1_sin_iva,
		CASE WHEN a.tipo_imp='1'THEN(a.prec_vta2/1.16)ELSE a.prec_vta2 END as prec_vta2_sin_iva,
		CASE WHEN a.tipo_imp='1'THEN(a.prec_vta3/1.16)ELSE a.prec_vta3 END as prec_vta3_sin_iva,
		CASE WHEN a.tipo_imp='1'THEN(a.prec_vta4/1.16)ELSE a.prec_vta4 END as prec_vta4_sin_iva,
		a.co_art,
		a.uni_venta,
		a.ult_cos_om,
		a.ult_cos_un,
		a.cos_pro_un,
		l.lin_des,
		ca.cat_des,
		a.art_des,
		(st.stock_act-st.stock_com)as stock_act,
		a.uni_venta,
		CASE WHEN a.tipo_imp=1 THEN t.porc_vent ELSE t.porc_cxs END as impuesto,
		a.tipo_imp,
		CASE WHEN a.tipo_imp=1 THEN 'G'ELSE 'E'END as tipo_impuesto_desc FROM art a 
		INNER JOIN st_almac st ON a.co_art=st.co_art 
		INNER JOIN tabulado t ON a.tipo_imp=t.tipo 
		INNER JOIN colores cl ON a.co_color=cl.co_col 
		INNER JOIN lin_art l ON a.co_lin=l.co_lin
		INNER JOIN cat_art ca ON a.co_cat = ca.co_cat
		WHERE a.tipo='V'
		AND a.anulado=0 
		AND st.co_alma=$co_sub
		AND st.stock_act>0 
		ORDER BY a.co_art ASC
		OFFSET 0 ROWS
    	FETCH NEXT $limite ROWS ONLY";

	

	}
	

	//echo $sql;
	$query = Executor::doitAr($sql);	
	$e=count($query);		
	if($e>=1){
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {
		$array[$cnt] = new ArticuloData(); 		

	
			//echo "Tasa2";			
		$array[$cnt]->responsive_id = "";  
		$array[$cnt]->co_art =trim($r['co_art']);
		$array[$cnt]->art_des = rtrim($r['art_des']);
		$array[$cnt]->tipo_imp = $r['tipo_imp'];	
		$array[$cnt]->tipo_impuesto_desc = $r['tipo_impuesto_desc'];	
		$array[$cnt]->des_col = $r['des_col'];	
		$array[$cnt]->lin_des = $r['cat_des'];	
		$array[$cnt]->stock_act = (float)$r['stock_act'];			
		$array[$cnt]->prec_vta1 =(float)$r['prec_vta1'];
		$array[$cnt]->prec_vta2 =(float)$r['prec_vta2'];
		$array[$cnt]->prec_vta3 =(float)$r['prec_vta3'];
		$array[$cnt]->prec_vta4 =(float)$r['prec_vta4'];
		$array[$cnt]->imagen ='../admin/storage/items/'.trim($r['co_art']).'.png';
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