<?php
class ArticuloData {
	public static $tablename = "art";	

		public function __construct(){
		$this->co_art = 0;		$this->art_des = "";	$this->fecha_reg = "";	$this->manj_ser = "";	$this->co_lin = "";	
		$this->co_cat ='';		$this->co_subl ='';		$this->co_color ='';	$this->item ='';		$this->ref ='';			$this->modelo ='';		
		$this->procedenci ='';	$this->comentario ='';	$this->co_prov ='';		$this->ubicacion ='';	$this->uni_venta ='';	$this->uni_compra ='';		
		$this->uni_relac ='';	$this->relac_aut ='';	$this->stock_act ='';	$this->stock_com ='';	$this->sstock_com ='';	$this->stock_lle ='';	
		$this->sstock_lle ='';	$this->stock_des ='';	$this->sstock_des ='';	$this->suni_venta ='';	$this->suni_compr ='';	$this->suni_relac ='';	
		$this->sstock_act ='';	$this->relac_comp ='';	$this->relac_vent ='';	$this->pto_pedido ='';	$this->stock_max ='';	$this->stock_min ='';	$this->prec_om ='';
		$this->prec_vta1 ='';	$this->fec_prec_v ='';	$this->fec_prec_2 ='';	$this->prec_vta2 ='';	$this->fec_prec_3 ='';	$this->prec_vta3 ='';		
		$this->fec_prec_4 ='';	$this->prec_vta4 ='';	$this->fec_prec_5 ='';	$this->fec_has_p5 ='';	$this->co_imp ='';		$this->margen_max ='';	$this->ult_cos_un ='';	
		$this->fec_ult_co ='';	$this->cos_pro_un ='';	$this->fec_cos_pr ='';	$this->cos_merc ='';	$this->fec_cos_me ='';	$this->cos_prov ='';	
		$this->fec_cos_p2 ='';	$this->ult_cos_do ='';	$this->cos_un_an ='';	$this->fec_cos_an ='';	$this->ult_cos_om ='';			
		$this->fec_ult_om ='';	$this->cos_pro_om ='';	$this->fec_pro_om ='';	$this->tipo_cos ='';	$this->mont_comi ='';	$this->porc_cos ='';	
		$this->mont_cos ='';	$this->porc_gas ='';	$this->mont_gas ='';	$this->f_cost ='';		$this->fisico ='';		$this->punt_cli ='';
		$this->punt_pro ='';	$this->dias_repos ='';	$this->tipo ='';		$this->alm_prin ='';	$this->anulado ='';		$this->tipo_imp ='';	
		$this->dis_cen ='';		$this->mon_ilc ='';		$this->capacidad ='';	$this->grado_al ='';	$this->tipo_licor ='';	$this->compuesto ='';			
		$this->picture ='';		$this->campo1 ='';		$this->campo2 ='';		$this->campo3 ='';		$this->campo4 ='';		$this->campo5 ='';		
		$this->campo6 ='';		$this->campo7 ='';		$this->campo8 ='';		$this->co_us_in ='';	$this->fe_us_in ='';	$this->co_us_mo ='';	
		$this->fe_us_mo ='';	$this->co_us_el ='';	$this->fe_us_el ='';	$this->revisado ='';	$this->trasnfe ='';		$this->co_sucu ='';		
		$this->rowguid ='';		$this->tuni_venta ='';	$this->equi_uni1 ='';	$this->equi_uni2 ='';	$this->equi_uni3 ='';	$this->lote ='';	
		$this->serialp ='';		$this->valido ='';		$this->atributo1 ='';	$this->vatributo1 ='';	$this->atributo2 ='';	$this->vatributo2 ='';	$this->atributo3 ='';	
		$this->vatributo3 ='';	$this->atributo4 ='';	$this->vatributo4 ='';	$this->atributo5 ='';	$this->vatributo5 ='';	$this->atributo6 ='';	$this->vatributo6 ='';
		$this->garantia ='';	$this->peso ='';		$this->pie ='';			$this->margen1 ='';		$this->margen2 ='';		$this->margen3 ='';		$this->margen4 ='';		
		$this->margen5 ='';		$this->row_id ='';		$this->imagen1 ='';		$this->imagen2 ='';		$this->i_art_des ='';	$this->uni_emp ='';		$this->rel_emp ='';	
		$this->movil ='';	
		
		$this->impuesto ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}

	public static function contarArticulos($almacen){
		$co_sub = $_SESSION['almacen'];
		$sql ="SELECT count(a.co_art) AS cuenta FROM ".self::$tablename." a 	INNER JOIN st_almac st on a.co_art = st.co_art  
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
		/// Metodo para consultar todos los datos y mostrar las tablas
		// solo para adminsitrador
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
		echo $sql;
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
			$array[$cnt]->prec_vta1 =number_format($r['prec_vta1'], 2, ',', '.');
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}


	public static function getDataFiltrada($filtro,$almacen){
		$co_sub = $_SESSION['almacen'];
	/// Metodo para consultar registros para paginacion  y filtrado por nombre
		
		if($filtro ==0){
			$sql ="SELECT TOP ".NUM_ITEMS_BY_PAGE." a.prec_vta1, a.co_art, a.art_des, (st.stock_act - st.stock_com) stock_act,suni_venta,
			case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp	FROM ".self::$tablename." a 
			INNER JOIN st_almac st on a.co_art = st.co_art  
			inner join tabulado t on a.tipo_imp = t.tipo
			WHERE a.tipo='V' AND a.anulado = 0 AND st.co_alma = '".$co_sub."' AND (st.stock_act - st.stock_com)>0
			ORDER BY a.co_art ASC";
			//echo $sql;
		}else{

			$sql ="SELECT TOP ".NUM_ITEMS_BY_PAGE." a.prec_vta1, a.prec_vta2, a.prec_vta3, a.prec_vta4, a.co_art, a.art_des, (st.stock_act - st.stock_com) stock_act,suni_venta,
			case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp
			FROM ".self::$tablename." a 
			INNER JOIN st_almac st on a.co_art = st.co_art  
			inner join tabulado t on a.tipo_imp = t.tipo
			WHERE a.anulado = 0 AND a.co_art LIKE '%".$filtro."%'  AND st.co_alma = '".$co_sub."' AND (st.stock_act - st.stock_com)>0
			ORDER BY a.co_art ASC";
			//echo $sql;
		}
		
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
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);							
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =number_format($r['prec_vta1'], 2, ',', '.');
			$cnt++;
		}
		return $array;
	}else{

			$array = array();
			return $array;
	}
	}


	public static function getDataPaginas($offset,$rowsPerPage,$id,$almacen){
		$co_sub = $_SESSION['almacen'];
		// Metodo para paginar los resultados
		$sql ="SELECT  a.prec_vta1, a.co_art, a.art_des, (st.stock_act - st.stock_com) stock_act,suni_venta,case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp	FROM ".self::$tablename." a 
			INNER JOIN st_almac st on a.co_art = st.co_art  
			inner join tabulado t on a.tipo_imp = t.tipo
			WHERE a.anulado = 0 AND st.co_alma = '".$co_sub."' AND (st.stock_act - st.stock_com)>0
			ORDER BY a.co_art ASC
			OFFSET ".$offset." ROWS
			FETCH NEXT ".$rowsPerPage." ROWS ONLY;
			";
					
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
			$array[$cnt]->impuesto = $r['impuesto'];
			$array[$cnt]->tipo_imp = $r['tipo_imp'];	
			$array[$cnt]->suni_venta = trim($r['suni_venta']);								
			$array[$cnt]->stock_act = number_format($r['stock_act'], 2, ',', '.');			
			$array[$cnt]->prec_vta1 =number_format($r['prec_vta1'], 2, ',', '.');
			$cnt++;
		}
		return $array;
		}else{

			$array = array();
			return $array;
		}
	}

	public static function getDataID($co_art,$almacen){
		
		
		$co_sub = $_SESSION['almacen'];
		$sql ="SELECT a.prec_vta1, a.prec_vta2,a.ult_cos_om,a.ult_cos_un,a.cos_pro_un,a.prec_vta3, a.prec_vta4, a.co_art, a.art_des, (st.stock_act - st.stock_com) stock_act,suni_venta,
		case when a.tipo_imp = 1 then t.porc_vent else t.porc_cxs end as impuesto, a.tipo_imp
		FROM ".self::$tablename." a 
		INNER JOIN st_almac st on a.co_art = st.co_art  
		inner join tabulado t on a.tipo_imp = t.tipo
		WHERE a.anulado = 0 AND a.co_art = '".$co_art."' AND st.co_alma = '".$co_sub."' 
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
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_art =trim($r['co_art']);
			$array[$cnt]->art_des = rtrim($r['art_des']);
			$array[$cnt]->stock_act =(float)$r['stock_act'];			
			$array[$cnt]->prec_vta1 =(float)$r['prec_vta1'];
			$array[$cnt]->impuesto = $r['impuesto'];	
			$array[$cnt]->tipo_imp = $r['tipo_imp'];

			$array[$cnt]->ult_cos_om = $r['ult_cos_om'];	
			$array[$cnt]->ult_cos_un = $r['ult_cos_un'];	
			$array[$cnt]->cos_pro_un = $r['cos_pro_un'];	

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



	
}
?>