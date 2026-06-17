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
		$this->tipo_doc = '0';

		$this->ene = '0';
		$this->feb = '0';
		$this->mar = '0';
		$this->abr = '0';
		$this->may = '0';
		$this->jun = '0';
		$this->jul = '0';
		$this->ago = '0';
		$this->sep = '0';
		$this->oct = '0';
		$this->nov = '0';
		$this->dic = '0';

	}


	
	public static function existeDespachoFactura($fact_num){
		$sql = "SELECT max(id) as desp_nun FROM jm_despacho WHERE fact_num='$fact_num'";
			//echo $sql;
			$desp_nun=Executor::doit($sql);
			return $desp_nun;
	}
		
	public static function tasa(){
		$sql = "select cambio as tasa from moneda where co_mone = 'US$'";

		//select cambio as tasa2 from moneda where co_mone = 'BCV'

		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}
		
	public static function getComparacionFacturasArticulos($co_art){
		 $sql = "SELECT 
            
            SUM(
                CASE 
                    WHEN f.fec_emis >= DATEFROMPARTS(YEAR(GETDATE()), 1, 1) 
                    AND f.fec_emis < DATEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), 1) 
                    THEN (r.total_art - r.total_dev) 
                    ELSE 0 
                END
            ) AS total_ano_sin_mes_actual,		
            SUM(
                CASE 
                    WHEN f.fec_emis >= DATEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), 1) -- Desde el 1 del mes actual
                    THEN (r.total_art - r.total_dev) 
                    ELSE 0 
                END
            ) AS total_mes_actual,
            -- NUEVA COLUMNA PARA EL MES ANTERIOR
            SUM(
                CASE 
                    WHEN f.fec_emis >= DATEADD(month, -1, DATEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), 1)) -- 1er día del mes anterior
                    AND f.fec_emis < DATEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), 1) -- Menor al 1er día del mes actual
                    THEN (r.total_art - r.total_dev) 
                    ELSE 0 
                END
            ) AS total_mes_anterior
        FROM 
            factura f
        INNER JOIN 
            reng_fac r ON f.fact_num = r.fact_num
        WHERE 
            f.anulada = 0 
            AND r.co_art IN ('$co_art');"; 

		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}	
	
	public  function getAllDatosVentasxDia($co_ven,$co_zona,$finicio,$ffinal){

			$data2 = $this->tasa();
			$tasa=$this->tasa=$data2['tasa'];
			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
			
				$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
				SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				where anulada = 0 and MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and len(c.campo8) = 0
				group by fec_emis
				order by 1 desc";


			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){
						
						
						$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
						SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona') and len(c.campo8) = 0
						group by fec_emis
						order by 1 desc";
					
					}else{

						$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
						SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and len(c.campo8) = 0
						group by fec_emis
						order by 1 desc";

						
					}
					
				}else{
					if($co_zona!="NO"){

						$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
						SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and c.co_zon in('$co_zona') and len(c.campo8) = 0
						group by fec_emis
						order by 1 desc";					
					
					}else{
						$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
						SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and len(c.campo8) = 0
						group by fec_emis
						order by 1 desc";
						
					}
				}
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
					$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10); 

					$array[$cnt]->tot_neto = (float)$r['tot_neto'];
					$array[$cnt]->dato2 =  number_format($r['costo'], 2, ',', '.');		
					$array[$cnt]->dato1 = (float)$r['kilos'];	
					$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');	
						
					$cnt++;
				}
				return $array;
				}else{
						$array = array();
						return $array;
				}

	}

	public  function getAllDatosCobrosMes($co_ven,$co_zona,$finicio,$ffinal){



					if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
						$hoy = getdate();
						$mes = $hoy['mon'];
						$anio = $hoy['year'];
						$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						inner join clientes cl on c.co_cli = cl.co_cli
						inner join zona z on cl.co_zon = z.co_zon
						where  MONTH(fec_cob)='$mes' and  YEAR(fec_cob)='$anio' and c.anulado = 0
						group by c.fec_cob
						order by 1 desc";
					}else{
						if($co_ven!="NO"){
							if($co_zona!="NO"){

								$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						inner join clientes cl on c.co_cli = cl.co_cli
						inner join zona z on cl.co_zon = z.co_zon
						where c.fec_cob between '".$finicio."' AND '".$ffinal."'  and c.co_ven in ('$co_ven')  and z.co_zon in('$co_zona') and c.anulado = 0
						group by c.fec_cob
						order by 1 desc";


								
							}else{
								$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
								from cobros c join reng_tip rt on c.cob_num = rt.cob_num
								inner join clientes cl on c.co_cli = cl.co_cli
								inner join zona z on cl.co_zon = z.co_zon
								where c.fec_cob between '".$finicio."' AND '".$ffinal."'  and c.co_ven in ('$co_ven') and c.anulado = 0
								group by c.fec_cob
								order by 1 desc";
			
							}
							
						}else{
							if($co_zona!="NO"){
								$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
								from cobros c join reng_tip rt on c.cob_num = rt.cob_num
								inner join clientes cl on c.co_cli = cl.co_cli
								inner join zona z on cl.co_zon = z.co_zon
								where c.fec_cob between '".$finicio."' AND '".$ffinal."' and z.co_zon in('$co_zona') and c.anulado = 0
								group by c.fec_cob
								order by 1 desc";
			
							}else{
								$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
								from cobros c join reng_tip rt on c.cob_num = rt.cob_num
								inner join clientes cl on c.co_cli = cl.co_cli
								inner join zona z on cl.co_zon = z.co_zon
								where c.fec_cob between '".$finicio."' AND '".$ffinal."'  and c.anulado = 0
								group by c.fec_cob
								order by 1 desc";
			
							}
						}
				}


		//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->fec_cob =substr($r['fec_cob'], 0, 10);  // abcd ;
				$array[$cnt]->tot_cobro = number_format($r['tot_cobro'], 2, ',', '.');	
					
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}

	}

	public  function getAllDatosCobrosMesVendedor($finicio,$ffinal){

		$co_ven =$_SESSION['identidad'];	

		if(($finicio=="NO") && ($ffinal=="NO")){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
			from cobros c join reng_tip rt on c.cob_num = rt.cob_num
			inner join clientes cl on c.co_cli = cl.co_cli
			inner join zona z on cl.co_zon = z.co_zon
			where  MONTH(fec_cob)='$mes' and  YEAR(fec_cob)='$anio' and c.co_ven in ('$co_ven') and c.anulado = 0
			group by c.fec_cob
			order by 1 desc";
		}else{

			$sql = "select c.fec_cob, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
								from cobros c join reng_tip rt on c.cob_num = rt.cob_num
								inner join clientes cl on c.co_cli = cl.co_cli
								inner join zona z on cl.co_zon = z.co_zon
								where c.fec_cob between '".$finicio."' AND '".$ffinal."'  and c.co_ven in ('$co_ven') and c.anulado = 0
								group by c.fec_cob
								order by 1 desc";
		}


			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->fec_cob =substr($r['fec_cob'], 0, 10);  // abcd ;
			$array[$cnt]->tot_cobro = number_format($r['tot_cobro'], 2, ',', '.');	
				
			$cnt++;
			}
			return $array;
			}else{
				$array = array();
				return $array;
			}

	}


	public  function getAllDatosArticulosFoco($co_ven,$co_zona,$finicio,$ffinal){

		

		if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
			SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
			SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
			from factura f join reng_fac r on f.fact_num = r.fact_num
			join art a on r.co_art = a.co_art
			join clientes cl on f.co_cli = cl.co_cli
			join zona z on cl.co_zon = z.co_zon
			where len(a.campo1) > 0 and  MONTH(f.fec_emis)='$mes' and  YEAR(f.fec_emis)='$anio'  and a.procedenci = '01'
			GROUP BY r.co_art, a.art_des";
		}else{
			if($co_ven!="NO"){
				if($co_zona!="NO"){


					$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
			SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
			SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
			from factura f join reng_fac r on f.fact_num = r.fact_num
			join art a on r.co_art = a.co_art
			join clientes cl on f.co_cli = cl.co_cli
			join zona z on cl.co_zon = z.co_zon
			where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and  cl.co_zon in ('$co_zona') and   cl.co_ven in ('$co_ven')  and a.procedenci = '01'
			GROUP BY r.co_art, a.art_des";

				


					
				}else{
					$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
					SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
					SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
					from factura f join reng_fac r on f.fact_num = r.fact_num
					join art a on r.co_art = a.co_art
					join clientes cl on f.co_cli = cl.co_cli
					join zona z on cl.co_zon = z.co_zon
					where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and   cl.co_ven in ('$co_ven')  and a.procedenci = '01'
					GROUP BY r.co_art, a.art_des";
				}
				
			}else{
				if($co_zona!="NO"){
					$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
					SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
					SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
					from factura f join reng_fac r on f.fact_num = r.fact_num
					join art a on r.co_art = a.co_art
					join clientes cl on f.co_cli = cl.co_cli
					join zona z on cl.co_zon = z.co_zon
					where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and  cl.co_zon in ('$co_zona')   and a.procedenci = '01'
					GROUP BY r.co_art, a.art_des";

				}else{

					$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
					SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
					SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
					from factura f join reng_fac r on f.fact_num = r.fact_num
					join art a on r.co_art = a.co_art
					join clientes cl on f.co_cli = cl.co_cli
					join zona z on cl.co_zon = z.co_zon
					where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'   and a.procedenci = '01'
					GROUP BY r.co_art, a.art_des";

				}
			}
		}

		/*art_des
		tot_meta
		total_art
		porc_alc*/
					//echo $sql;
					$query = Executor::doitAr($sql);	
					$e=count($query);		
					if($e>=1){
					$array = array();
					$cnt = 0;	
					foreach($query as $r) {
					$array[$cnt] = new FacturaData(); 
					$array[$cnt]->responsive_id = "";  
					$array[$cnt]->art_des =substr($r['art_des'], 0, 10);  // abcd ;
					$array[$cnt]->tot_meta = number_format($r['tot_meta'], 2, ',', '.');	
					$array[$cnt]->total_art = number_format($r['total_art'], 2, ',', '.');	
					$array[$cnt]->porc_alc =(float)$r['porc_alc'];	
					$cnt++;
					}
					return $array;
					}else{
						$array = array();
						return $array;
					}

	}

	public  function getAllDatosArticulosVolumen($co_ven,$co_zona,$finicio,$ffinal){
		if(($co_ven!="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){

			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			
			$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
			SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
			SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
			from factura f join reng_fac r on f.fact_num = r.fact_num
			join art a on r.co_art = a.co_art
			join clientes cl on f.co_cli = cl.co_cli
			join zona z on cl.co_zon = z.co_zon
			where len(a.campo1) > 0 and   MONTH(f.fec_emis)='$mes' and  YEAR(f.fec_emis)='$anio'  and   cl.co_ven in ('$co_ven') and a.procedenci = '02'
			GROUP BY r.co_art, a.art_des";



		}else{
			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
		
			
		
		
				$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
				SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
				from factura f join reng_fac r on f.fact_num = r.fact_num
				join art a on r.co_art = a.co_art
				join clientes cl on f.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where len(a.campo1) > 0 and  MONTH(f.fec_emis)='$mes' and  YEAR(f.fec_emis)='$anio' and a.procedenci = '02'
				GROUP BY r.co_art, a.art_des";
			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){
		
						$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
						SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
						from factura f join reng_fac r on f.fact_num = r.fact_num
						join art a on r.co_art = a.co_art
						join clientes cl on f.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and  cl.co_zon in ('$co_zona') and   cl.co_ven in ('$co_ven') and a.procedenci = '02'
						GROUP BY r.co_art, a.art_des";
		
					
					
		
		
						
					}else{
		
						$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
						SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
						from factura f join reng_fac r on f.fact_num = r.fact_num
						join art a on r.co_art = a.co_art
						join clientes cl on f.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'   and   cl.co_ven in ('$co_ven') and a.procedenci = '02'
						GROUP BY r.co_art, a.art_des";
		
		
					}
					
				}else{
					if($co_zona!="NO"){
		
						$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
						SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
						from factura f join reng_fac r on f.fact_num = r.fact_num
						join art a on r.co_art = a.co_art
						join clientes cl on f.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and  cl.co_zon in ('$co_zona')  and a.procedenci = '02'
						GROUP BY r.co_art, a.art_des";
		
					
		
					}else{
		
		
						$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
						SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
						from factura f join reng_fac r on f.fact_num = r.fact_num
						join art a on r.co_art = a.co_art
						join clientes cl on f.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and a.procedenci = '02'
						GROUP BY r.co_art, a.art_des";
		
		
						
					}
				}
			}

		}

		



					//echo $sql;
					$query = Executor::doitAr($sql);	
					$e=count($query);		
					if($e>=1){
					$array = array();
					$cnt = 0;	
					foreach($query as $r) {
					$array[$cnt] = new FacturaData(); 
					$array[$cnt]->responsive_id = "";  
					$array[$cnt]->art_des =trim($r['art_des']);	
					$array[$cnt]->tot_meta = number_format($r['tot_meta'], 2, ',', '.');	
					$array[$cnt]->total_art = number_format($r['total_art'], 2, ',', '.');	
					$array[$cnt]->porc_alc =(float)$r['porc_alc'];	
					$cnt++;
					}
					return $array;
					}else{
						$array = array();
						return $array;
					}

	}

	public  function getAllDatosArticulosFocoVendedor($finicio,$ffinal){

		$co_ven =$_SESSION['identidad'];	

		if(($finicio=="NO") && ($ffinal=="NO")){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
			SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
			SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
			from factura f join reng_fac r on f.fact_num = r.fact_num
			join art a on r.co_art = a.co_art
			join clientes cl on f.co_cli = cl.co_cli
			join zona z on cl.co_zon = z.co_zon
			where len(a.campo1) > 0 and  MONTH(f.fec_emis)='$mes' and  YEAR(f.fec_emis)='$anio' and   cl.co_ven in ('$co_ven')
			GROUP BY r.co_art, a.art_des";
		}else{
				$sql ="select r.co_art, a.art_des, Max(try_convert(decimal(18,2), a.campo1))tot_meta,
					SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
					SUM(case when total_uni = 1 then total_art else total_uni end) / Max(try_convert(decimal(18,2), a.campo1)) * 100 as porc_alc
					from factura f join reng_fac r on f.fact_num = r.fact_num
					join art a on r.co_art = a.co_art
					join clientes cl on f.co_cli = cl.co_cli
					join zona z on cl.co_zon = z.co_zon
					where len(a.campo1) > 0 and  f.fec_emis between '".$finicio."' AND '".$ffinal."'  and   cl.co_ven in ('$co_ven')
					GROUP BY r.co_art, a.art_des";
		}


					//echo $sql;
					$query = Executor::doitAr($sql);	
					$e=count($query);		
					if($e>=1){
					$array = array();
					$cnt = 0;	
					foreach($query as $r) {
					$array[$cnt] = new FacturaData(); 
					$array[$cnt]->responsive_id = "";  
					$array[$cnt]->art_des =trim($r['art_des']);	
					$array[$cnt]->tot_meta = number_format($r['tot_meta'], 2, ',', '.');	
					$array[$cnt]->total_art = number_format($r['total_art'], 2, ',', '.');	
					$array[$cnt]->porc_alc =(float)$r['porc_alc'];	
					$cnt++;
					}
					return $array;
					}else{
						$array = array();
						return $array;
					}

	}

	public  function getAllDatosVentasxDiaVendedor($finicio,$ffinal){
		$co_ven =$_SESSION['identidad'];	
		$data2 = $this->tasa();
		$tasa=$this->tasa=$data2['tasa'];
		if(($finicio=="NO") && ($ffinal=="NO")){

			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];

					$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
			SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
			SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
			from factura f inner join reng_fac r on f.fact_num = r.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			where anulada = 0 and MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.co_ven in ('$co_ven') and len(c.campo8) = 0
			group by fec_emis
			order by 1 desc";



		}else{
			$sql="select fec_emis,sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
			SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) costo,
			SUM(a.peso * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) kilos,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
			from factura f inner join reng_fac r on f.fact_num = r.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven') and len(c.campo8) = 0
			group by fec_emis
			order by 1 desc";

					
				
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
				$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;
				$array[$cnt]->tot_neto = number_format($r['tot_neto'], 2, ',', '.');
				$array[$cnt]->dato2 =  number_format($r['costo'], 2, ',', '.');		
				$array[$cnt]->dato1 = number_format($r['kilos'], 2, ',', '.');	
				$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');	
					
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}

	}

	public static function getDataTopVendidosVendedorUnidades($filtro){
			$co_ven =$_SESSION['identidad'];
			/// Metodo para consultar todos los datos y mostrar las tablas
			// top(5) para otro cliente
			if($filtro =='NO'){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
				$sql ="select top(10) r.co_art, a.art_des, sum(r.total_art) as tot_und
				from factura f inner join reng_fac r on f.fact_num = r.fact_num
				inner join art a on r.co_art = a.co_art
				where  MONTH(f.fec_emis)='$mes' and  YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven')  and a.co_cat  in ('03', '10')
				group by r.co_art, a.art_des order by 3 desc";  
			}else{
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 

				$sql ="select top(10) r.co_art, a.art_des, sum(r.total_art) as tot_und
				from factura f inner join reng_fac r on f.fact_num = r.fact_num
				inner join art a on r.co_art = a.co_art
				where  fec_emis between '".$fechaI."' AND '".$fechaF."'  and f.co_ven in ('$co_ven')  and a.co_cat  in ('03', '10')
				group by r.co_art, a.art_des order by 3 desc";  
			}
			

			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 				
				$array[$cnt]->dato1 = trim($r['art_des']);	
				$array[$cnt]->dato2 = $r['tot_und'];		
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
	}

	public static function getDataTopClientesMasYMenos($co_ven,$co_zona,$finicio,$ffinal,$estado){
		
		if($estado=='1'){
			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
			


				$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num 
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where anulada = 0 and MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.moneda = 'US$'--and c.co_zon in ('')
				and len(c.campo8) = 0
				group by f.co_cli, c.cli_des
				order by 3 desc";
			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){

						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona') and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 desc";
						
						
					}else{
						
						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven') and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 desc";

						
					}
					
				}else{
					if($co_zona!="NO"){

						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and c.co_zon in('$co_zona') and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 desc";
					
					
					}else{

						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."' and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 desc";
						
						
					}
				}
			}

		}else{

			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];		

				
				$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num 
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where anulada = 0 and  MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.moneda = 'US$'--and c.co_zon in ('')
				and len(c.campo8) = 0
				group by f.co_cli, c.cli_des
				order by 3 ASC";
			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){					
						
						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and  fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona') and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 ASC";

						
					}else{
						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and  fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 ASC";					
					}
					
				}else{
					if($co_zona!="NO"){

						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and  fec_emis between '".$finicio."' AND '".$ffinal."'  and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 ASC";	

						
					}else{
						$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from factura f inner join reng_fac r on f.fact_num = r.fact_num 
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where anulada = 0 and  fec_emis between '".$finicio."' AND '".$ffinal."'  and f.moneda = 'US$'--and c.co_zon in ('')
						and len(c.campo8) = 0
						group by f.co_cli, c.cli_des
						order by 3 ASC";	

						
					}
				}
			}

		}

		
		

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['cli_des']);	
			$array[$cnt]->dato2 = number_format($r['tot_neto'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopPagosMasYMenos($co_ven,$co_zona,$finicio,$ffinal,$estado){
		
		if($estado=='1'){
			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
			


				$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
				from cobros c join reng_tip rt on c.cob_num = rt.cob_num
				join clientes cl on c.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where MONTH(fec_cob)='$mes' and  YEAR(fec_cob)='$anio' and c.anulado = 0 and len(cl.campo8) = 0
				group by c.co_cli, cl.cli_des
				order by 3 desc";
			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){					

						$sql ="	select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'   and f.co_ven in ('$co_ven')  and c.anulado = 0 and len(cl.campo8) = 0 and cl.co_zon in ('$co_zona')
						group by c.co_cli, cl.cli_des
						order by 3 desc";
					}else{
						
						$sql ="	select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'   and f.co_ven in ('$co_ven')  and c.anulado = 0 and len(cl.campo8) = 0
						group by c.co_cli, cl.cli_des
						order by 3 desc";
					}
					
				}else{
					if($co_zona!="NO"){
					
						$sql ="	select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'    and c.anulado = 0 and len(cl.campo8) = 0 and cl.co_zon in ('$co_zona')
						group by c.co_cli, cl.cli_des
						order by 3 desc";
					}else{
						
						$sql ="	select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'   and c.anulado = 0 and len(cl.campo8) = 0 
						group by c.co_cli, cl.cli_des
						order by 3 desc";
					}
				}
			}

		}else{

			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
						
				$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
				from cobros c join reng_tip rt on c.cob_num = rt.cob_num
				join clientes cl on c.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where MONTH(fec_cob)='$mes' and  YEAR(fec_cob)='$anio' and c.anulado = 0 and len(cl.campo8) = 0 
				group by c.co_cli, cl.cli_des
				order by 3 asc";

			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){		
					
						$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'   and f.co_ven in ('$co_ven')    and c.anulado = 0 and len(cl.campo8) = 0 and cl.co_zon in ('$co_zona')
						group by c.co_cli, cl.cli_des
						order by 3 asc";
			
					}else{
						$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'   and f.co_ven in ('$co_ven')    and c.anulado = 0 and len(cl.campo8) = 0
						group by c.co_cli, cl.cli_des
						order by 3 asc";
			
					}
					
				}else{
					if($co_zona!="NO"){
						$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'    and c.anulado = 0 and len(cl.campo8) = 0 and cl.co_zon in ('$co_zona')
						group by c.co_cli, cl.cli_des
						order by 3 asc";
			
					}else{
						$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
						from cobros c join reng_tip rt on c.cob_num = rt.cob_num
						join clientes cl on c.co_cli = cl.co_cli
						join zona z on cl.co_zon = z.co_zon
						where fec_cob between '".$finicio."' AND '".$ffinal."'    and c.anulado = 0 and len(cl.campo8) = 0 
						group by c.co_cli, cl.cli_des
						order by 3 asc";
					}
				}
			}

		}

		
		

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['cli_des']);	
			$array[$cnt]->dato2 = number_format($r['tot_cobro'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['tot_cobro'], 2, ',', '.');		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopPagosMasYMenosVendedor($finicio,$ffinal,$estado){
		$co_ven =$_SESSION['identidad'];	
		if($estado=='1'){
			if(($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	


				$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
				from cobros c join reng_tip rt on c.cob_num = rt.cob_num
				join clientes cl on c.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where MONTH(fec_cob)='$mes' and  YEAR(fec_cob)='$anio' and c.anulado = 0 and len(cl.campo8) = 0  and c.co_ven in ('$co_ven')
				group by c.co_cli, cl.cli_des
				order by 3 desc";
			}else{

				$sql ="	select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
				from cobros c join reng_tip rt on c.cob_num = rt.cob_num
				join clientes cl on c.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where fec_cob between '".$finicio."' AND '".$ffinal."'   and c.co_ven in ('$co_ven')  and c.anulado = 0 and len(cl.campo8) = 0
				group by c.co_cli, cl.cli_des
				order by 3 desc";
			}

		}else{

			if(($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
						
				$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
				from cobros c join reng_tip rt on c.cob_num = rt.cob_num
				join clientes cl on c.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where MONTH(fec_cob)='$mes' and  YEAR(fec_cob)='$anio' and c.anulado = 0 and len(cl.campo8) = 0   and c.co_ven in ('$co_ven')
				group by c.co_cli, cl.cli_des
				order by 3 asc";

			}else{

				$sql = "select top 5 c.co_cli, cl.cli_des, ROUND(sum(rt.mont_doc/c.tasa),2) tot_cobro
				from cobros c join reng_tip rt on c.cob_num = rt.cob_num
				join clientes cl on c.co_cli = cl.co_cli
				join zona z on cl.co_zon = z.co_zon
				where fec_cob between '".$finicio."' AND '".$ffinal."'   and c.co_ven in ('$co_ven')    and c.anulado = 0 and len(cl.campo8) = 0
				group by c.co_cli, cl.cli_des
				order by 3 asc";
			}

		}

		
		

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['cli_des']);	
			$array[$cnt]->dato2 = number_format($r['tot_cobro'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['tot_cobro'], 2, ',', '.');		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopClientesMasYMenosVendedor($finicio,$ffinal,$estado){
		$co_ven =$_SESSION['identidad'];	
		if($estado=='1'){
			if(($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];		
			
				$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num 
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where anulada = 0 and MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.moneda = 'US$'--and c.co_zon in ('')
				and len(c.campo8) = 0
				group by f.co_cli, c.cli_des
				order by 3 desc";

			}else{

				$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num 
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven') and f.moneda = 'US$'--and c.co_zon in ('')
				and len(c.campo8) = 0
				group by f.co_cli, c.cli_des
				order by 3 desc";

				
			}

		}else{

			if(($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];			

				
				
				$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num 
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where anulada = 0 and MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.co_ven in ('$co_ven')  and f.moneda = 'US$'--and c.co_zon in ('')
				and len(c.campo8) = 0
				group by f.co_cli, c.cli_des
				order by 3 ASC";
			}else{
				$sql = "select top 5 f.co_cli, c.cli_des, sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) tot_neto,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from factura f inner join reng_fac r on f.fact_num = r.fact_num 
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where anulada = 0 and fec_emis between '".$finicio."' AND '".$ffinal."' and f.co_ven in ('$co_ven')  and f.moneda = 'US$'--and c.co_zon in ('')
				and len(c.campo8) = 0
				group by f.co_cli, c.cli_des
				order by 3 ASC";

				
			}

		}

		
		

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['cli_des']);	
			$array[$cnt]->dato2 = number_format($r['tot_neto'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopMenosVendidos($co_ven,$co_zona,$finicio,$ffinal){

		if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];

				$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
		((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
		SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
		from reng_fac r inner join factura f on r.fact_num = f.fact_num
		inner join art a on r.co_art = a.co_art
		inner join clientes c on f.co_cli = c.co_cli
		inner join zona z on c.co_zon = z.co_zon
		where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
		GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
		having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
		order by 3 asc";



		
		}else{
			if($co_ven!="NO"){
				if($co_zona!="NO"){

					$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."' and  f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona') and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
					GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 asc";



					
				
				}else{


									$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."' and  f.co_ven in ('$co_ven')  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
					GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 asc";



				
				}
				
			}else{
				if($co_zona!="NO"){
									$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."'   and c.co_zon in('$co_zona') and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
					GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 asc";




				}else{

									$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
					GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 asc";

					

				}
			}
		}
		

			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 				
				$array[$cnt]->dato1 = trim($r['art_des']);	
				$array[$cnt]->dato2 = number_format($r['total_art'], 2, ',', '.');
				$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');		
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
	}

	public static function getDataTopMayorMenorUtilidad($co_ven,$co_zona,$finicio,$ffinal,$estado){

		if($estado=='1'){
			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];

				
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";
			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){
						
						
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona') and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";

						
					}else{
						
									
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";

						
					}
					
				}else{
					if($co_zona!="NO"){
									
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."'   and c.co_zon in('$co_zona') and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";
					
					
					}else{
									
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."' and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";

					
					}
				}
			}

		}else{

			if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
				
				
				
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where  MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 ASC";
			}else{
				if($co_ven!="NO"){
					if($co_zona!="NO"){		
							
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona') and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 ASC";			

					
					}else{
						$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from reng_fac r inner join factura f on r.fact_num = f.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
						GROUP BY r.co_art, a.art_des
						order by 4 ASC";	

					
					}
					
				}else{
					if($co_zona!="NO"){
						$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from reng_fac r inner join factura f on r.fact_num = f.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where fec_emis between '".$finicio."' AND '".$ffinal."'   and c.co_zon in('$co_zona') and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
						GROUP BY r.co_art, a.art_des
						order by 4 ASC";		

						
					}else{
						$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
						((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
						SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
						from reng_fac r inner join factura f on r.fact_num = f.fact_num
						inner join art a on r.co_art = a.co_art
						inner join clientes c on f.co_cli = c.co_cli
						inner join zona z on c.co_zon = z.co_zon
						where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
						GROUP BY r.co_art, a.art_des
						order by 4 ASC";		

					
					}
				}
			}

		}


		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato2 = number_format($r['total_art'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopMayorMenorUtilidadVendedor($finicio,$ffinal,$estado){
		$co_ven =$_SESSION['identidad'];	
		if($estado=='1'){
			if(($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.co_ven in ('$co_ven')  and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";
			}else{


				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')  and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 DESC";

				
			}

		}else{

			if(($finicio=="NO") && ($ffinal=="NO")){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];			

				
				
				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'  and f.co_ven in ('$co_ven')   and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 ASC";
			}else{

				$sql = "select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then total_art else total_uni end) total_art,
				((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) / 
				SUM((r.ult_cos_om/r.total_uni)  * (case when r.total_uni = 1 then r.total_art else r.total_uni*r.total_art end)) ) -1)*100 as util
				from reng_fac r inner join factura f on r.fact_num = f.fact_num
				inner join art a on r.co_art = a.co_art
				inner join clientes c on f.co_cli = c.co_cli
				inner join zona z on c.co_zon = z.co_zon
				where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven')   and f.anulada = 0 and f.moneda = 'US$'--and c.co_zon in ('variable')
				GROUP BY r.co_art, a.art_des
				order by 4 ASC";

				
			}

		}


		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato2 = number_format($r['total_art'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopVendidosUnidades($filtro){
		// top(5) para otro cliente
			/// Metodo para consultar todos los datos y mostrar las tablas
			if($filtro =='NO'){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
				$sql ="select top(10) r.co_art, a.art_des, sum(r.total_art) as tot_und
				from factura f inner join reng_fac r on f.fact_num = r.fact_num
				inner join art a on r.co_art = a.co_art
				where  MONTH(f.fec_emis)='$mes' and  YEAR(f.fec_emis)='$anio'  and a.co_cat  in ('03', '10')
				group by r.co_art, a.art_des order by 3 desc";  
			}else{
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 

				$sql ="select top(10) r.co_art, a.art_des, sum(r.total_art) as tot_und
				from factura f inner join reng_fac r on f.fact_num = r.fact_num
				inner join art a on r.co_art = a.co_art
				where  fec_emis between '".$fechaI."' AND '".$fechaF."'   and a.co_cat  in ('03', '10')
				group by r.co_art, a.art_des order by 3 desc";  
			}
			

			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 				
				$array[$cnt]->dato1 = trim($r['art_des']);	
				$array[$cnt]->dato2 = $r['tot_und'];			
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
	}

	public static function getDataMasyMenosVendidosVendedor($finicio,$ffinal,$estado){
		//getDataMasyMenosVendidosVendedor
		$co_ven =$_SESSION['identidad'];
		/// Metodo para consultar todos los datos y mostrar las tablas
		// top(5) para otro cliente
		if($estado=='1'){
		if(($finicio=="NO") && ($ffinal=="NO")){

			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];

			$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
			from reng_fac r inner join factura f on r.fact_num = f.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			inner join zona z on c.co_zon = z.co_zon
			where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'  and f.co_ven in ('$co_ven') and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
			GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
			having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
			order by 3 desc";


		

			

		}else{
			$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
			from reng_fac r inner join factura f on r.fact_num = f.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			inner join zona z on c.co_zon = z.co_zon
			where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven') and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
			GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
			having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
			order by 3 desc";

		
			

		}
		}else{
		if(($finicio=="NO") && ($ffinal=="NO")){

			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];

			$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
			from reng_fac r inner join factura f on r.fact_num = f.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			inner join zona z on c.co_zon = z.co_zon
			where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
			GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
			having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
			order by 3 asc";
			

		}else{
			$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
			from reng_fac r inner join factura f on r.fact_num = f.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			inner join zona z on c.co_zon = z.co_zon
			where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.co_ven in ('$co_ven') and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
			GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
			having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
			order by 3 asc";
			

		}

		}

		

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato2 =(float)$r['total_art'];
			$array[$cnt]->dato3 = (float)$r['util'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getDataTopVendidos($co_ven,$co_zona,$finicio,$ffinal){


		if(($co_ven=="NO") && ($co_zona=="NO") && ($finicio=="NO") && ($ffinal=="NO")){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];


				$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
		((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
		SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
		from reng_fac r inner join factura f on r.fact_num = f.fact_num
		inner join art a on r.co_art = a.co_art
		inner join clientes c on f.co_cli = c.co_cli
		inner join zona z on c.co_zon = z.co_zon
		where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
		GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
		having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
		order by 3 desc";


		

		}else{
			if($co_ven!="NO"){
				if($co_zona!="NO"){

					
			$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
			((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
			SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
			from reng_fac r inner join factura f on r.fact_num = f.fact_num
			inner join art a on r.co_art = a.co_art
			inner join clientes c on f.co_cli = c.co_cli
			inner join zona z on c.co_zon = z.co_zon
			where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0 and f.co_ven in ('$co_ven')  and c.co_zon in('$co_zona')
			GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
			having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
			order by 3 desc";
			

					

				}else{

					$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0 and f.co_ven in ('$co_ven')  
									GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 desc";
					
				
					
					
				}
				
			}else{
				if($co_zona!="NO"){

					$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0  and c.co_zon in('$co_zona')
					GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 desc";

					
				}else{
					
					$sql="select top 5 r.co_art, a.art_des, SUM(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) total_art,
					((sum((r.reng_neto*(case when r.tipo_imp = 1 then 1.16 else 1 end))/f.tasa) /
					SUM((r.ult_cos_om/r.total_uni) * (case when r.total_uni = 1 then r.total_art else (r.total_uni*r.total_art) end)) ) -1)*100 as util--,c.co_zon, z.zon_des
					from reng_fac r inner join factura f on r.fact_num = f.fact_num
					inner join art a on r.co_art = a.co_art
					inner join clientes c on f.co_cli = c.co_cli
					inner join zona z on c.co_zon = z.co_zon
					where fec_emis between '".$finicio."' AND '".$ffinal."'  and f.anulada = 0 and f.moneda = 'US$' and len(c.campo8) = 0
					GROUP BY r.co_art, a.art_des--, c.co_zon, z.zon_des
					having sum(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) > 5
					order by 3 desc";

				
				}
			}
		}

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 	
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato2 = number_format($r['total_art'], 2, ',', '.');
			$array[$cnt]->dato3 = number_format($r['util'], 2, ',', '.');
		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
		
	}

	public static function getAllDatosFiltro($status,$rango){
			/// Metodo para consultar todos los datos y mostrar las tabla
			$co_ven =$_SESSION['identidad'];
			$co_sucu=$_SESSION['co_alma'];

			if($rango=='NO'){
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];

				$sql ="SELECT p.fact_num,  (p.saldo/p.tasa) as saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
				(p.tot_bruto/p.tasa) as tot_bruto, (p.tot_neto/p.tasa) as tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
				p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
				INNER JOIN almacen a on p.co_sucu = a.co_alma 
				INNER JOIN clientes c on p.co_cli = c.co_cli 			
				WHERE MONTH(p.fec_emis)='$mes' and  YEAR(p.fec_emis)='$anio' AND p.co_ven = '".$co_ven."' AND p.status='".$status."' ORDER BY p.fec_emis DESC";
			//echo $sql;
			}

			if($rango!='NO'){
			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql ="SELECT p.fact_num, (p.saldo/p.tasa) as saldo, p.fec_emis, p.fec_venc, p.co_cli, p.co_ven, p.co_tran, p.forma_pag,
			(p.tot_bruto/p.tasa) as tot_bruto, (p.tot_neto/p.tasa) as tot_neto, p.iva, p.co_us_in, p.fe_us_in, p.co_sucu,p.tasa,p.moneda,c.cli_des,
			p.tasag, p.tasag10, p.tasag20, p.status, p.contrib FROM ".self::$tablename." p 
			INNER JOIN almacen a on p.co_sucu = a.co_alma 
			INNER JOIN clientes c on p.co_cli = c.co_cli 
			
			WHERE p.fec_emis between '".$fechaI."' AND '".$fechaF."' AND p.co_ven = '".$co_ven."' AND p.status='".$status."'  ORDER BY p.fec_emis DESC";
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

	public static function GetFactura($fact_num,$status){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, (p.saldo/p.tasa) as saldo, p.fec_emis,p.fec_venc, p.co_tran, p.forma_pag,
		(p.tot_bruto/p.tasa) as tot_bruto, (p.tot_neto/p.tasa) as tot_neto, (p.iva/p.tasa) as iva, p.moneda, p.status, p.contrib,c.cli_des,c.email,c.telefonos,c.direc1,t.des_tran,v.ven_des FROM factura p 
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
			$array[$cnt]->tot_bruto = (float)number_format($r['tot_bruto'], 2, ',', '.');			
			$array[$cnt]->tot_neto = (float)number_format($r['tot_neto'], 2, ',', '.');	
			$array[$cnt]->iva = (float)number_format($r['iva'], 2, ',', '.');	
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
		INNER JOIN pedidos p on p.fact_num = pg.fact_num 
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
		//echo $sql;
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

	public static function getDataFiltradaVendedor($filtro){
		if($filtro=='NO'){

			$hoy = getdate();			
			$anio = $hoy['year'];
			$co_ven =$_SESSION['identidad'];
			$sql="SELECT a.co_cat,
			c.cat_des,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as ene,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as feb,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as mar,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as abr,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as may,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as jun,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as jul,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as ago,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as sep,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as oct,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as nov,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as dic FROM factura f inner join reng_fac r on f.fact_num=r.fact_num inner join art a on r.co_art=a.co_art inner join cat_art c on a.co_cat=c.co_cat WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada = 0  group by a.co_cat,
			c.cat_des";



		}else{
			$fechaI = substr($filtro, 0, 10); 	
			$fechaF = substr($filtro, 14, 10); 
			$co_ven =$_SESSION['identidad'];	


			
			$sql="SELECT a.co_cat,
			c.cat_des,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as ene,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as feb,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as mar,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as abr,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as may,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as jun,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as jul,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as ago,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as sep,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as oct,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as nov,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
			2)as dic FROM factura f inner join reng_fac r on f.fact_num=r.fact_num inner join art a on r.co_art=a.co_art inner join cat_art c on a.co_cat=c.co_cat WHERE  f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.co_ven in ('$co_ven') and f.anulada = 0  group by a.co_cat,
			c.cat_des";
			

		}
		
		//echo $sql;
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
				$array[$cnt]->responsive_id = ""; 		
				$array[$cnt]->dato1 = $r['co_cat'];
				$array[$cnt]->dato2 = $r['cat_des'];				
				$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
				$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
				$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
				$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
				$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
				$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
				$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
				$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
				$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
				$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
				$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
				$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	
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

	public static function getDataFiltradaVendedorGrafico($filtro){

		if($filtro =='NO'){
			$hoy = getdate();			
			$anio = $hoy['year'];
			$co_ven =$_SESSION['identidad'];	


			$sql="
					SELECT ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as ene,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
		2)as feb,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
		2)as mar,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
		2)as abr,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as may,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as jun,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as jul,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as ago,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as sep,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as oct,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as nov,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as dic FROM factura f inner join reng_fac r on f.fact_num=r.fact_num inner join art a on r.co_art=a.co_art inner join cat_art c on a.co_cat=c.co_cat WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada=0 and a.co_cat not in('03',
		'10')";
					

		
		}else{
			
			$fechaI = substr($filtro, 0, 10); 	
			$fechaF = substr($filtro, 14, 10); 
			$co_ven =$_SESSION['identidad'];	

			$sql="			
					SELECT ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as ene,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
		2)as feb,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
		2)as mar,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
		2)as abr,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as may,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as jun,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as jul,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as ago,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as sep,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as oct,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as nov,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
		2)as dic FROM factura f inner join reng_fac r on f.fact_num=r.fact_num inner join art a on r.co_art=a.co_art inner join cat_art c on a.co_cat=c.co_cat WHERE  f.fec_emis BETWEEN '$fechaI' AND '$fechaF'  and f.co_ven in ('$co_ven') and f.anulada=0 and a.co_cat not in('03',
		'10')";
					

		}
	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new GraficoData();			
				
		
				$array[$cnt]->ene = $r['ene'];
				$array[$cnt]->feb = $r['feb'];
				$array[$cnt]->mar = $r['mar'];
				$array[$cnt]->abr = $r['abr'];
				$array[$cnt]->may = $r['may'];
				$array[$cnt]->jun = $r['jun'];	
				$array[$cnt]->jul = $r['jul'];	
				$array[$cnt]->ago = $r['ago'];	
				$array[$cnt]->sep = $r['sep'];	
				$array[$cnt]->oct = $r['oct'];	
				$array[$cnt]->nov = $r['nov'];	
				$array[$cnt]->dic = $r['dic'];
				

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

	public static function getDataFiltradaVendedorLinea($filtro){

		if($filtro =='NO'){
			$hoy = getdate();			
			$anio = $hoy['year'];
			$co_ven =$_SESSION['identidad'];	

			$sql="SELECT a.co_lin,
			l.lin_des,
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada = 0
			group by a.co_lin, l.lin_des
			ORDER BY co_lin";
		}else{

			$fechaI = substr($filtro, 0, 10); 	
			$fechaF = substr($filtro, 14, 10); 
			$co_ven =$_SESSION['identidad'];	
			
				$sql="SELECT a.co_lin,
				l.lin_des,
				SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
				SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
				SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
				SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
				SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
				SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
				SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
				SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
				SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
				SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
				SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
				SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
				FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
				inner join art a on r.co_art=a.co_art 
				inner join lin_art l on a.co_lin=l.co_lin 
				WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.co_ven in ('$co_ven') and f.anulada = 0
				group by a.co_lin, l.lin_des
				ORDER BY co_lin";

		}
		
		//echo $sql;
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
				$array[$cnt]->responsive_id = ""; 		
				$array[$cnt]->dato1 = $r['co_lin'];
				$array[$cnt]->dato2 = $r['lin_des'];				
				$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
				$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
				$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
				$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
				$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
				$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
				$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
				$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
				$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
				$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
				$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
				$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	
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
	
	public static function getDataFiltradaVendedorGraficoLinea($filtro){

		if($filtro =='NO'){
			$hoy = getdate();			
			$anio = $hoy['year'];
			$co_ven =$_SESSION['identidad'];

			$sql="SELECT 
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada = 0 and l.co_lin not in ('027')";

		}else{


			$fechaI = substr($filtro, 0, 10); 	
			$fechaF = substr($filtro, 14, 10); 
			$co_ven =$_SESSION['identidad'];	
			
			$sql="SELECT 
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.co_ven in ('$co_ven') and f.anulada = 0 and l.co_lin not in ('027')";

		}
	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new GraficoData();
				$array[$cnt]->responsive_id = ""; 
				/*
				$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
				$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
				$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
				$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
				$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
				$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
				$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
				$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
				$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
				$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
				$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
				$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');			
					*/
				$array[$cnt]->ene = $r['ene'];
				$array[$cnt]->feb = $r['feb'];
				$array[$cnt]->mar = $r['mar'];
				$array[$cnt]->abr = $r['abr'];
				$array[$cnt]->may = $r['may'];
				$array[$cnt]->jun = $r['jun'];	
				$array[$cnt]->jul = $r['jul'];	
				$array[$cnt]->ago = $r['ago'];	
				$array[$cnt]->sep = $r['sep'];	
				$array[$cnt]->oct = $r['oct'];	
				$array[$cnt]->nov = $r['nov'];	
				$array[$cnt]->dic = $r['dic'];	
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
	
	public static function getDataFiltradaVendedoresGrafico_tablero_linea_vendedor(){	
			$co_ven =$_SESSION['identidad'];	
			$hoy = getdate();			
			$anio = $hoy['year'];

			$sql="select ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as ene,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as feb,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as mar,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as abr,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as may,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as jun,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as jul,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as ago,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as sep,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as oct,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as nov,
			ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(f.tot_bruto/f.tasa)ELSE 0 END),
			2)as dic FROM factura f WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven')";




		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
		//echo "Si tengo algo";
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {			
			
			$array[$cnt] = new GraficoData();


			$array[$cnt]->ene = $r['ene'];
			$array[$cnt]->feb = $r['feb'];
			$array[$cnt]->mar = $r['mar'];
			$array[$cnt]->abr = $r['abr'];
			$array[$cnt]->may = $r['may'];
			$array[$cnt]->jun = $r['jun'];	
			$array[$cnt]->jul = $r['jul'];	
			$array[$cnt]->ago = $r['ago'];	
			$array[$cnt]->sep = $r['sep'];	
			$array[$cnt]->oct = $r['oct'];	
			$array[$cnt]->nov = $r['nov'];	
			$array[$cnt]->dic = $r['dic'];	
			/*	
			$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
			$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
			$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
			$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
			$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
			$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
			$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
			$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
			$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
			$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
			$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
			$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	*/
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


	public  function getDataFiltradaVendedoresGrafico_tablero_arreglos(){	

			$arreglo = $this->getDataFiltradaVendedoresGrafico_tablero();
			$arreglo2 =$this->getDataFiltradaVendedoresGrafico_tablero_2();

			$array = array_merge($arreglo, $arreglo2);
		
			//var_dump($array);

			return $array;

		

	}

	public static function getDataFiltradaVendedoresGrafico_tablero(){	

				$hoy = getdate();			
				$anio = $hoy['year'];

				$sql="SELECT 
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as ene,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as feb,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as mar,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as abr,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as may,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as jun,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as jul,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as ago,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as sep,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as oct,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as nov,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as dic 
				FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
				inner join art a on r.co_art=a.co_art 
				WHERE YEAR(f.fec_emis)='$anio' and f.anulada = 0 ";

			

		
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				$ene = $r['ene'];
				$feb = $r['feb'];
				$mar = $r['mar'];
				$abr = $r['abr'];
				$may = $r['may'];
				$jun = $r['jun'];
				$jul = $r['jul'];
				$ago = $r['ago'];
				$sep = $r['sep'];
				$oct = $r['oct'];
				$nov = $r['nov'];
				$dic = $r['dic'];
		
				$array=array($anio,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);
			}
			
			
			//var_dump($array);
			return $array;
				

		}else{
			//echo "No tengo nada";
			$array = array();
			return $array;

		}
		
	}

	public static function getDataFiltradaVendedoresGrafico_tablero_2(){	

		$hoy = getdate();			
		$anio = $hoy['year'];
		$anio = $anio-1;
		$sql="SELECT 
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as ene,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as feb,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as mar,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as abr,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as may,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as jun,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as jul,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as ago,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as sep,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as oct,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as nov,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((r.total_art*(r.prec_vta/f.tasa))-(r.total_dev*(r.prec_vta/f.tasa)))ELSE 0 END),2)as dic 
		FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
		inner join art a on r.co_art=a.co_art 
		WHERE YEAR(f.fec_emis)='$anio' and f.anulada = 0 ";


		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
		//echo "Si tengo algo";
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {			

			$ene = $r['ene'];
			$feb = $r['feb'];
			$mar = $r['mar'];
			$abr = $r['abr'];
			$may = $r['may'];
			$jun = $r['jun'];
			$jul = $r['jul'];
			$ago = $r['ago'];
			$sep = $r['sep'];
			$oct = $r['oct'];
			$nov = $r['nov'];
			$dic = $r['dic'];

			$array=array($anio,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);
		

		}
		
		
			//var_dump($array);
			//$array =array($anio,$r['ene'],$r['feb'],$r['mar'],$r['abr'],$r['may'],$r['jun'],$r['jul'],$r['ago'],$r['sep'],$r['oct'],$r['nov'],$r['dic']):

		return $array;

		}else{
		//echo "No tengo nada";
		$array = array();
		return $array;

		}

	}


	public static function getDataFiltradaVendedoresGrafico_tablero_vendedor(){	
		$co_ven =$_SESSION['identidad'];	
		$hoy = getdate();			
		$anio = $hoy['year'];

		$sql="SELECT 
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 1 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as ene,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 2 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as feb,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 3 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as mar,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 4 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as abr,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 5 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as may,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 6 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as jun,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 7 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as jul,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 8 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as ago,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 9 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as sep,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 10 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as oct,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 11 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as nov,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 12 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as dic
		FROM factura f inner join reng_fac r on f.fact_num = r.fact_num
		inner join art a on r.co_art = a.co_art
		inner join cat_art c on a.co_cat = c.co_cat

		WHERE YEAR(f.fec_emis)='$anio' and f.anulada = 0 and f.co_ven in ('$co_ven') and r.co_art not in ('CTL002')";




		//echo $sql;
			$query = Executor::doitAr($sql);
			//print_r($query);
			//$data = json_decode($query);
			$e=count($query);
			if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new GraficoData();


				$array[$cnt]->ene = $r['ene'];
				$array[$cnt]->feb = $r['feb'];
				$array[$cnt]->mar = $r['mar'];
				$array[$cnt]->abr = $r['abr'];
				$array[$cnt]->may = $r['may'];
				$array[$cnt]->jun = $r['jun'];	
				$array[$cnt]->jul = $r['jul'];	
				$array[$cnt]->ago = $r['ago'];	
				$array[$cnt]->sep = $r['sep'];	
				$array[$cnt]->oct = $r['oct'];	
				$array[$cnt]->nov = $r['nov'];	
				$array[$cnt]->dic = $r['dic'];	
				/*	
				$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
				$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
				$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
				$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
				$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
				$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
				$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
				$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
				$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
				$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
				$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
				$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	*/
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

	public static function getDataFiltradaVendedoresGrafico_tablero_linea(){	

		$hoy = getdate();			
		$anio = $hoy['year'];

		$sql="SELECT 
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 1 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as ene,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 2 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as feb,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 3 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as mar,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 4 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as abr,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 5 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as may,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 6 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as jun,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 7 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as jul,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 8 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as ago,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 9 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as sep,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 10 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as oct,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 11 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as nov,
		ROUND(SUM(CASE WHEN MONTH(f.fec_emis) = 12 THEN ((r.total_art * a.peso)  - (r.total_dev * a.peso)) ELSE 0 END),2) as dic
		FROM factura f inner join reng_fac r on f.fact_num = r.fact_num
		inner join art a on r.co_art = a.co_art
		inner join cat_art c on a.co_cat = c.co_cat and f.anulada = 0 and a.co_cat not in ('03', '10')
		WHERE YEAR(f.fec_emis)='$anio'";



		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
		//echo "Si tengo algo";
		$array = array();
		$cnt = 0;	
		foreach($query as $r) {			
			
			$array[$cnt] = new GraficoData();


			$array[$cnt]->ene = $r['ene'];
			$array[$cnt]->feb = $r['feb'];
			$array[$cnt]->mar = $r['mar'];
			$array[$cnt]->abr = $r['abr'];
			$array[$cnt]->may = $r['may'];
			$array[$cnt]->jun = $r['jun'];	
			$array[$cnt]->jul = $r['jul'];	
			$array[$cnt]->ago = $r['ago'];	
			$array[$cnt]->sep = $r['sep'];	
			$array[$cnt]->oct = $r['oct'];	
			$array[$cnt]->nov = $r['nov'];	
			$array[$cnt]->dic = $r['dic'];	
		
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


	public static function getDataFiltradaVendedores($co_ven,$filtro){

			if($co_ven =='NO'){
				if($filtro == 'NO'){

					$hoy = getdate();			
					$anio = $hoy['year'];



					$sql="SELECT a.co_cat,
					c.cat_des,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ene,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as feb,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as mar,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as abr,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as may,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jun,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jul,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ago,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as sep,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as oct,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as nov,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as dic FROM factura f 
					inner join reng_fac r on f.fact_num=r.fact_num 
					inner join art a on r.co_art=a.co_art 
					inner join cat_art c on a.co_cat=c.co_cat 
					WHERE YEAR(f.fec_emis)='$anio' and f.anulada=0 group by a.co_cat,
					c.cat_des";

				}else{
					$fechaI = substr($filtro, 0, 10); 	
					$fechaF = substr($filtro, 14, 10); 	

					$sql="SELECT a.co_cat,
					c.cat_des,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ene,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as feb,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as mar,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as abr,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as may,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jun,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jul,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ago,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as sep,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as oct,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as nov,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as dic FROM factura f 
					inner join reng_fac r on f.fact_num=r.fact_num 
					inner join art a on r.co_art=a.co_art 
					inner join cat_art c on a.co_cat=c.co_cat 
					WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF'  and f.anulada=0 group by a.co_cat,
					c.cat_des";

					
					
				}
			}else{

				if($filtro == 'NO'){
					$hoy = getdate();			
					$anio = $hoy['year'];


					

					$sql="SELECT a.co_cat,
					c.cat_des,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ene,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as feb,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as mar,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as abr,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as may,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jun,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jul,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ago,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as sep,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as oct,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as nov,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as dic FROM factura f 
					inner join reng_fac r on f.fact_num=r.fact_num 
					inner join art a on r.co_art=a.co_art 
					inner join cat_art c on a.co_cat=c.co_cat 
					WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada=0 group by a.co_cat,
					c.cat_des";

		
					
				}else{


					$fechaI = substr($filtro, 0, 10); 	
					$fechaF = substr($filtro, 14, 10); 

					
					$sql="SELECT a.co_cat,
					c.cat_des,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ene,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as feb,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as mar,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as abr,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as may,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jun,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as jul,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as ago,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as sep,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as oct,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as nov,
					ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN((case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end))ELSE 0 END),
					2)as dic FROM factura f 
					inner join reng_fac r on f.fact_num=r.fact_num 
					inner join art a on r.co_art=a.co_art 
					inner join cat_art c on a.co_cat=c.co_cat 
					WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.co_ven in ('$co_ven')   and f.anulada=0 group by a.co_cat,
					c.cat_des";


				}
			}


			
			
			//echo $sql;
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
					$array[$cnt]->responsive_id = ""; 		
					$array[$cnt]->dato1 = $r['co_cat'];
					$array[$cnt]->dato2 = $r['cat_des'];				
					$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
					$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
					$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
					$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
					$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
					$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
					$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
					$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
					$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
					$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
					$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
					$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	
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

	public static function getDataFiltradaVendedoresGrafico($co_ven,$filtro){



		if($co_ven =='NO'){
			if($filtro == 'NO'){

				$hoy = getdate();			
				$anio = $hoy['year'];




				$sql="SELECT ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ene,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as feb,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as mar,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as abr,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as may,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jun,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jul,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ago,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as sep,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as oct,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as nov,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as dic FROM factura f
				 inner join reng_fac r on f.fact_num=r.fact_num 
				 inner join art a on r.co_art=a.co_art 
				 inner join cat_art c on a.co_cat=c.co_cat 
				 WHERE YEAR(f.fec_emis)='$anio' and f.anulada=0 and a.co_cat not in('03','10')";

			}else{

				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 

				$sql="SELECT ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ene,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as feb,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as mar,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as abr,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as may,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jun,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jul,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ago,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as sep,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as oct,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as nov,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as dic FROM factura f
				 inner join reng_fac r on f.fact_num=r.fact_num 
				 inner join art a on r.co_art=a.co_art 
				 inner join cat_art c on a.co_cat=c.co_cat 
				 WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF'  and f.anulada=0 and a.co_cat not in('03','10')"; 
				
				
			}

		}else{

			if($filtro == 'NO'){

				$hoy = getdate();			
				$anio = $hoy['year'];

				
				$sql="SELECT ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ene,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as feb,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as mar,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as abr,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as may,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jun,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jul,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ago,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as sep,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as oct,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as nov,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as dic FROM factura f
				 inner join reng_fac r on f.fact_num=r.fact_num 
				 inner join art a on r.co_art=a.co_art 
				 inner join cat_art c on a.co_cat=c.co_cat 
				 WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven')  and f.anulada=0 and a.co_cat not in('03','10')"; 
				


			
			

			}else{
				
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 

				$sql="SELECT ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ene,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as feb,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as mar,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN (case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end) ELSE 0 END),
				2)as abr,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as may,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jun,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as jul,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as ago,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as sep,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as oct,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as nov,
				ROUND(SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(case when total_uni = 1 then r.total_art*a.peso else (r.total_uni*r.total_art)*a.peso end)ELSE 0 END),
				2)as dic FROM factura f
				 inner join reng_fac r on f.fact_num=r.fact_num 
				 inner join art a on r.co_art=a.co_art 
				 inner join cat_art c on a.co_cat=c.co_cat 
				 WHERE  f.fec_emis BETWEEN '$fechaI' AND '$fechaF'  and f.co_ven in ('$co_ven')  and f.anulada=0 and a.co_cat not in('03','10')"; 
				

				
			
			}
		}
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new GraficoData();
			

				$array[$cnt]->ene = $r['ene'];
				$array[$cnt]->feb = $r['feb'];
				$array[$cnt]->mar = $r['mar'];
				$array[$cnt]->abr = $r['abr'];
				$array[$cnt]->may = $r['may'];
				$array[$cnt]->jun = $r['jun'];	
				$array[$cnt]->jul = $r['jul'];	
				$array[$cnt]->ago = $r['ago'];	
				$array[$cnt]->sep = $r['sep'];	
				$array[$cnt]->oct = $r['oct'];	
				$array[$cnt]->nov = $r['nov'];	
				$array[$cnt]->dic = $r['dic'];	
			
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

	public static function getDataFiltradaVendedoresLinea($co_ven,$filtro){

		if($co_ven =='NO'){
			if($filtro == 'NO'){

				$hoy = getdate();			
				$anio = $hoy['year'];

			

				$sql="SELECT a.co_lin,
				l.lin_des,
				SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
				SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
				SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
				SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
				SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
				SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
				SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
				SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
				SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
				SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
				SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
				SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
				FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
				inner join art a on r.co_art=a.co_art 
				inner join lin_art l on a.co_lin=l.co_lin 
				WHERE YEAR(f.fec_emis)='$anio'  and f.anulada = 0
				group by a.co_lin, l.lin_des
				ORDER BY co_lin";

			}else{
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 	
				$sql="SELECT a.co_lin,
				l.lin_des,
				SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
				SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
				SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
				SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
				SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
				SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
				SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
				SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
				SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
				SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
				SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
				SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
				FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
				inner join art a on r.co_art=a.co_art 
				inner join lin_art l on a.co_lin=l.co_lin 
				WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF'  and f.anulada = 0
				group by a.co_lin, l.lin_des
				ORDER BY co_lin";
			}
		}else{

			if($filtro == 'NO'){

				$hoy = getdate();			
				$anio = $hoy['year'];

				$sql="SELECT a.co_lin,
			l.lin_des,
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada = 0
			group by a.co_lin, l.lin_des
			ORDER BY co_lin";

			}else{
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 	
				$sql="SELECT a.co_lin,
				l.lin_des,
				SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
				SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
				SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
				SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
				SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
				SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
				SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
				SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
				SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
				SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
				SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
				SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
				FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
				inner join art a on r.co_art=a.co_art 
				inner join lin_art l on a.co_lin=l.co_lin 
				WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.co_ven in ('$co_ven') and f.anulada = 0
				group by a.co_lin, l.lin_des
				ORDER BY co_lin";
			}
		}
		
		//echo $sql;
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
				$array[$cnt]->responsive_id = ""; 		
				$array[$cnt]->dato1 = $r['co_lin'];
				$array[$cnt]->dato2 = $r['lin_des'];			
				$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
				$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
				$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
				$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
				$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
				$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
				$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
				$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
				$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
				$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
				$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
				$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	
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

	public static function getDataFiltradaVendedoresGraficoLinea($co_ven,$filtro){

		if($co_ven =='NO'){
			if($filtro == 'NO'){

				$hoy = getdate();			
				$anio = $hoy['year'];

				$sql="SELECT 
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE YEAR(f.fec_emis)='$anio'  and f.anulada = 0 and l.co_lin not in ('027')";
			}else{
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 	
				$sql="SELECT 
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.anulada = 0 and l.co_lin not in ('027')";
			}
		}else{

			if($filtro == 'NO'){

				$hoy = getdate();			
				$anio = $hoy['year'];
				$sql="SELECT 
				SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
				SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
				SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
				SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
				SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
				SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
				SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
				SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
				SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
				SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
				SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
				SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
				FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
				inner join art a on r.co_art=a.co_art 
				inner join lin_art l on a.co_lin=l.co_lin 
				WHERE YEAR(f.fec_emis)='$anio' and f.co_ven in ('$co_ven') and f.anulada = 0 and l.co_lin not in ('027')";

			}else{

				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 	
				$sql="SELECT 
			SUM(CASE WHEN MONTH(f.fec_emis)=1 THEN(r.total_art-r.total_dev)ELSE 0 END)as ene,
			SUM(CASE WHEN MONTH(f.fec_emis)=2 THEN(r.total_art-r.total_dev)ELSE 0 END)as feb,
			SUM(CASE WHEN MONTH(f.fec_emis)=3 THEN(r.total_art-r.total_dev)ELSE 0 END)as mar,
			SUM(CASE WHEN MONTH(f.fec_emis)=4 THEN(r.total_art-r.total_dev)ELSE 0 END)as abr,
			SUM(CASE WHEN MONTH(f.fec_emis)=5 THEN(r.total_art-r.total_dev)ELSE 0 END)as may,
			SUM(CASE WHEN MONTH(f.fec_emis)=6 THEN(r.total_art-r.total_dev)ELSE 0 END)as jun,
			SUM(CASE WHEN MONTH(f.fec_emis)=7 THEN(r.total_art-r.total_dev)ELSE 0 END)as jul,
			SUM(CASE WHEN MONTH(f.fec_emis)=8 THEN(r.total_art-r.total_dev)ELSE 0 END)as ago,
			SUM(CASE WHEN MONTH(f.fec_emis)=9 THEN(r.total_art-r.total_dev)ELSE 0 END)as sep,
			SUM(CASE WHEN MONTH(f.fec_emis)=10 THEN(r.total_art-r.total_dev)ELSE 0 END)as oct,
			SUM(CASE WHEN MONTH(f.fec_emis)=11 THEN(r.total_art-r.total_dev)ELSE 0 END)as nov,
			SUM(CASE WHEN MONTH(f.fec_emis)=12 THEN(r.total_art-r.total_dev)ELSE 0 END)as dic 
			FROM factura f inner join reng_fac r on f.fact_num=r.fact_num 
			inner join art a on r.co_art=a.co_art 
			inner join lin_art l on a.co_lin=l.co_lin 
			WHERE f.fec_emis BETWEEN '$fechaI' AND '$fechaF' and f.co_ven in ('$co_ven') and f.anulada = 0 and l.co_lin not in ('027')";
			}

		
			
		}
		
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		//$data = json_decode($query);
		$e=count($query);
		if($e>=1){
			//echo "Si tengo algo";
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new GraficoData();		
				/*	
				$array[$cnt]->ene = number_format($r['ene'], 2, ',', '.');
				$array[$cnt]->feb = number_format($r['feb'], 2, ',', '.');
				$array[$cnt]->mar = number_format($r['mar'], 2, ',', '.');
				$array[$cnt]->abr = number_format($r['abr'], 2, ',', '.');
				$array[$cnt]->may = number_format($r['may'], 2, ',', '.');
				$array[$cnt]->jun = number_format($r['jun'], 2, ',', '.');	
				$array[$cnt]->jul = number_format($r['jul'], 2, ',', '.');	
				$array[$cnt]->ago = number_format($r['ago'], 2, ',', '.');	
				$array[$cnt]->sep = number_format($r['sep'], 2, ',', '.');	
				$array[$cnt]->oct = number_format($r['oct'], 2, ',', '.');	
				$array[$cnt]->nov = number_format($r['nov'], 2, ',', '.');	
				$array[$cnt]->dic = number_format($r['dic'], 2, ',', '.');	*/

				$array[$cnt]->ene = $r['ene'];
				$array[$cnt]->feb = $r['feb'];
				$array[$cnt]->mar = $r['mar'];
				$array[$cnt]->abr = $r['abr'];
				$array[$cnt]->may = $r['may'];
				$array[$cnt]->jun = $r['jun'];	
				$array[$cnt]->jul = $r['jul'];	
				$array[$cnt]->ago = $r['ago'];	
				$array[$cnt]->sep = $r['sep'];	
				$array[$cnt]->oct = $r['oct'];	
				$array[$cnt]->nov = $r['nov'];	
				$array[$cnt]->dic = $r['dic'];	
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

		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
		
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->dato1 =  number_format($r['saldo'], 2, ',', '.');
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	

	public static function getSaldoPorCobrar($co_cli){ 
		$co_ven = $_SESSION['identidad'];
		$sql="SELECT SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo FROM docum_cc d 
		INNER JOIN clientes c ON c.co_cli=d.co_cli
		WHERE d.saldo > 0 AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') and c.co_ven = '$co_ven' and d.co_cli = '".$co_cli."'";
	  // echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
		
			$array[$cnt] = new FacturaData();        
			$array[$cnt]->saldo = number_format($r['saldo'], 2, ',', '.');
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				$array[0] = new FacturaData();  
				$array[0]->saldo=number_format(0, 2, ',', '.');
				return $array;
		}
	}
	
	
	public static function getUltimaFactura($co_cli){ 
		$co_ven = $_SESSION['identidad'];
		$sql="select MAX(fec_emis) as fecha,co_cli from factura where co_cli = '$co_cli' group by co_cli ";
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {  
			$array[$cnt] = new FacturaData();        
			$array[$cnt]->fecha = substr($r['fecha'],0,10);		
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				$array[0] = new FacturaData();        
				$array[0]->fecha=0;
				return $array;
		}
	}


	public static function getAllCuentasPorCobrarGerente($filtro, $co_ven, $estado) {
		/// Metodo para consultar el total de cuenas por cobrar
		
		// Preparamos el filtro por estado (días de vencimiento)
		$estadoFilter = "";
		if ($estado == 2) {
			// Facturas que vencen en 2 días (diferencia = 2)
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) IN (-2, -1) ";
		} elseif ($estado == 3) {
			// Facturas vencidas entre 1 y 3 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) BETWEEN 1 AND 3 ";
		} elseif ($estado == 4) {
			// Facturas vencidas entre 4 y 10 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) BETWEEN 4 AND 10 ";
		} elseif ($estado == 5) {
			// Facturas vencidas mayores a 11 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) >= 11 ";
		} elseif ($estado == 6) {
			// Facturas que vencen hoy
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) = 0 ";
		}
		// Si $estado == 0 o no coincide con ninguno, no aplicamos filtro adicional (mostrar todas)
		
		if($filtro == 'NO') {
			if($co_ven == 'NO') {
				$hoy = getdate();			
				$anio = $hoy['year'];
	
				$sql = "SELECT 
						SUM(
							CASE 
								WHEN d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
									THEN (d.saldo / d.tasa) * -1
								ELSE (d.saldo / d.tasa)
							END
						) AS saldo 
					FROM docum_cc d 
					INNER JOIN clientes c ON c.co_cli = d.co_cli 
					WHERE 
						d.saldo > 0 
						AND d.tipo_doc IN (
							'FACT', 'N/DB', 'AJPM', 'AJPA', 
							'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA'
						)
						AND c.co_ven NOT IN ('V1') -- Excluir vendedores específicos
						" . $estadoFilter; // Aplicamos filtro por estado
	
			} else {
				$hoy = getdate();			
				$anio = $hoy['year'];
	
				$sql = "SELECT 
						SUM(
							CASE 
								WHEN d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
									THEN (d.saldo / d.tasa) * -1
								ELSE (d.saldo / d.tasa)
							END
						) AS saldo 
					FROM docum_cc d 
					INNER JOIN clientes c ON c.co_cli = d.co_cli
					WHERE 
						d.saldo > 0 
						AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
						AND d.co_ven = '".$co_ven."'
						" . $estadoFilter; // Aplicamos filtro por estado
			}
			
		} else {
			if($co_ven == 'NO') {
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 	
	
				$sql = "SELECT 
						SUM(
							CASE 
								WHEN d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
									THEN (d.saldo / d.tasa) * -1
								ELSE (d.saldo / d.tasa)
							END
						) AS saldo
					FROM docum_cc d 
					INNER JOIN clientes c ON c.co_cli = d.co_cli
					WHERE 
						d.saldo > 0 
						AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
						AND d.fec_emis BETWEEN '$fechaI' AND '$fechaF' 
						AND c.co_ven NOT IN ('V1')
						" . $estadoFilter; // Aplicamos filtro por estado
	
			} else {
				$fechaI = substr($filtro, 0, 10); 	
				$fechaF = substr($filtro, 14, 10); 	
	
				$sql = "SELECT 
						SUM(
							CASE 
								WHEN d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
									THEN (d.saldo / d.tasa) * -1
								ELSE (d.saldo / d.tasa)
							END
						) AS saldo
					FROM docum_cc d 
					INNER JOIN clientes c ON c.co_cli = d.co_cli
					WHERE 
						d.saldo > 0 
						AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
						AND d.fec_emis BETWEEN '$fechaI' AND '$fechaF' 
						AND d.co_ven IN ('$co_ven')
						" . $estadoFilter; // Aplicamos filtro por estado
			}
		}
		
		//echo $sql; // Para depuración
		$query = Executor::doitAr($sql);	
		$e = count($query);		
		
		if($e >= 1) {
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 
				$array[$cnt]->responsive_id = ""; 		
				$array[$cnt]->dato1 = number_format($r['saldo'], 2, ',', '.');
				$cnt++;
			}
			return $array;
		} else {
			$array = array();
			return $array;
		}
	}

public static function getAllCuentasPorCobrarDetallesGerente($filtro, $co_ven,$estado) {
	$co_sucu = $_SESSION['co_alma'];
    
    // Preparamos el filtro de vendedor para la consulta principal
    $vendedorFilter = ($co_ven == 'NO') ? "" : " and d.co_ven in ('$co_ven')";
    
    // Preparamos el filtro por estado (días de vencimiento)
    $estadoFilter = "";
    if ($estado == 2) {
        // Facturas que vencen en 2 días (diferencia = 2)
        $estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) IN (-2,-1) ";
    } elseif ($estado == 3) {
        // Facturas vencidas entre 0 y 16 días
        $estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) BETWEEN 1 AND 3 ";
    }elseif ($estado == 4) {
        // Facturas vencidas entre 0 y 16 días
        $estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) BETWEEN 4 AND 10 ";
    } elseif ($estado == 5) {
        // Facturas vencidas mayores a 17 días
        $estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) >= 11 ";
    }  elseif ($estado == 6) {
			// Facturas vencidas mayores a 17 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) =0 ";
		} 
    // Si $estado == 0, no aplicamos filtro adicional (mostrar todas)

    if ($filtro == 'NO') {
        // Sin filtro de fecha
        $hoy = getdate();
        $anio = $hoy['year'];

        $sql = "SELECT d.co_cli, c.cli_des, c.rif, c.respons,tc.des_tipo,
                REPLACE(REPLACE(c.telefonos, ' ', ''), '-', '') as telefonos, 
                SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo, v.ven_des as des_ven
                FROM docum_cc d 
                INNER JOIN clientes c ON c.co_cli = d.co_cli 
                INNER JOIN vendedor v ON d.co_ven = v.co_ven
				INNER JOIN tipo_cli tc ON c.tipo = tc.tip_cli
                WHERE c.co_ven NOT IN ('V1')  
                AND d.saldo > 0 
                AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
                " . $vendedorFilter . " 
                " . $estadoFilter . " 
                GROUP BY d.co_cli, c.cli_des, c.rif, c.respons, c.telefonos, v.ven_des,tc.des_tipo
                ORDER BY c.cli_des ASC";

    } else {
        // Con filtro de fecha
        $fechaI = substr($filtro, 0, 10);
        $fechaF = substr($filtro, 14, 10);

        $sql = "SELECT d.co_cli, c.cli_des, c.rif, c.respons,,tc.des_tipo, 
                REPLACE(REPLACE(c.telefonos, ' ', ''), '-', '') as telefonos, 
                SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo, v.ven_des as des_ven
                FROM docum_cc d 
                INNER JOIN clientes c ON c.co_cli = d.co_cli 
                INNER JOIN vendedor v ON d.co_ven = v.co_ven
				INNER JOIN tipo_cli tc ON c.tipo = tc.tip_cli
                WHERE  c.co_ven NOT IN ('V1')  
                AND d.saldo > 0 
                AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
                AND d.fec_emis BETWEEN '$fechaI' AND '$fechaF' 
                " . $vendedorFilter . " 
                " . $estadoFilter . " 
                GROUP BY d.co_cli, c.cli_des, c.rif, c.respons, c.telefonos, v.ven_des ,tc.des_tipo
                ORDER BY c.cli_des ASC";
    }
	//echo $sql; // Para depuración, puedes eliminar esta línea en producción
    $query = Executor::doitAr($sql);
    $e = count($query);

    if ($e >= 1) {
        $array = array();
        $cnt = 0;
        foreach ($query as $r) {
            $array[$cnt] = new FacturaData();
            $array[$cnt]->responsive_id = "";
            $array[$cnt]->co_cli = trim($r['co_cli']);
            $array[$cnt]->cli_des = trim($r['cli_des']);
			$array[$cnt]->tipo_cliente = trim($r['des_tipo']);
            $array[$cnt]->responsable = trim($r['respons']);
            // Ya viene limpio desde SQL, solo lo asignamos
            $array[$cnt]->telefonos = trim($r['telefonos']);
            $array[$cnt]->rif = trim($r['rif']);
			$array[$cnt]->des_ven = trim($r['des_ven']);
            $array[$cnt]->saldo = number_format($r['saldo'], 2, ',', '.');
            
            // --- NUEVA LÓGICA ---
            // Obtenemos las facturas de este cliente.
            // Pasamos 0 como segundo parametro ($filtro de anulado) para traer facturas activas.
            $facturasCliente = self::getFacturasClienteGerente(trim($r['co_cli']), 0, $co_ven,$estado);
            
            // Convertimos el array de objetos de facturas a un string JSON para enviarlo al frontend
            $array[$cnt]->facturas_detalle = json_encode($facturasCliente);
            // ---------------------

            $cnt++;
        }
        return $array;
    } else {
        $array = array();
        return $array;
    }
}


	public static function getFacturasClienteGerente($co_cli, $filtro, $co_ven,$estado) {
		// Metodo para consultar el total de cuentas por cobrar
		$co_sucu = $_SESSION['co_alma'];
		
		// Ajuste en el SQL: Maneja el caso donde $co_ven es 'NO' para no filtrar por vendedor
		$vendedorFilter = ($co_ven == 'NO') ? "" : " AND d.co_ven = '" . $co_ven . "'";


		if ($estado == 2) {
			// Facturas que vencen en 2 días (diferencia = 2)
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) IN (-2,-1) ";
		} elseif ($estado == 3) {
			// Facturas vencidas entre 0 y 16 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) BETWEEN 1 AND 3 ";
		}elseif ($estado == 4) {
			// Facturas vencidas entre 0 y 16 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) BETWEEN 4 AND 10 ";
		} elseif ($estado == 5) {
			// Facturas vencidas mayores a 17 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) >= 11 ";
		}  elseif ($estado == 6) {
			// Facturas vencidas mayores a 17 días
			$estadoFilter = " AND DATEDIFF(day, d.fec_venc, GETDATE()) =0 ";
		} 
		// Si $estado == 0, no aplicamos filtro adicional (mostrar todas)


	
		$sql = "SELECT 	CAST(d.nro_doc AS VARCHAR) AS serie_fact_num,d.nro_doc as nro_doc ,(d.saldo/d.tasa) AS saldo,d.fec_emis,d.fec_venc,d.tipo_doc,(d.monto_net/d.tasa) AS monto_neto, datediff(d,fec_venc, getdate()) as dias
				FROM docum_cc d 
				INNER JOIN clientes c ON d.co_cli = c.co_cli 		
				WHERE  c.co_ven NOT IN ('V1')  $estadoFilter AND c.co_cli ='" . $co_cli . "'  
				AND d.saldo > 0 
				AND d.anulado = " . $filtro . " 
				" . $vendedorFilter . " 
				ORDER BY d.fec_emis DESC";
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e = count($query);
		
		if ($e >= 1) {
			$array = array();
			$cnt = 0;
			$status = 0;
			$nro=1;
			foreach ($query as $r) {
				$objeto_pago_reg = New PagoRegData();
				$data = $objeto_pago_reg->getData($r['nro_doc']);
				
				if (empty($data)) {
					$status = 0;
				} else {
					$status = $data[0]->status;

				}
		  // --- INICIO DE LA MODIFICACIÓN ---
            
            // 1. Guardamos el número original de la base de datos.
            $numeroOriginal = $r['serie_fact_num'];
            $numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

            // 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
            // Usamos substr para obtener el primer carácter.
            if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal) ==8) {
                // Obtenemos el resto del número a partir del tercer carácter (índice 2).
                $restoDelNumero = substr($numeroOriginal, 2);
                // Construimos el nuevo número.
                $numeroFormateado = 'NF' . $restoDelNumero;
            }
            
            // --- FIN DE LA MODIFICACIÓN ---



				$array[$cnt] = new FacturaData();
				$array[$cnt]->responsive_id = "";
				$array[$cnt]->nro = $nro;
				$array[$cnt]->nro_doc = $numeroFormateado;
				$array[$cnt]->saldo = number_format($r['saldo'], 2, ',', '.');
				$array[$cnt]->saldo2 = $r['saldo'];
				$array[$cnt]->fec_emis = substr($r['fec_emis'], 0, 10);
				$array[$cnt]->fec_venc = substr($r['fec_venc'], 0, 10);
				$array[$cnt]->tipo_doc = $r['tipo_doc'];
				
				$array[$cnt]->dato2 = number_format($r['monto_neto'], 2, ',', '.');
				$array[$cnt]->dato1 = $status;
				$array[$cnt]->dato3 = $r['dias'];
				$cnt++;
				$nro++;
			}
			return $array;
		} else {
			$array = array();
			return $array;
		}
	}
	
	public static function getAllCuentasPorCobrarDetalles(){
		
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql="SELECT d.co_cli, c.cli_des, c.rif, SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo
		FROM docum_cc d INNER JOIN clientes c ON c.co_cli=d.co_cli
		WHERE d.co_ven = '".$co_ven."'
		GROUP BY d.co_cli,c.cli_des,c.rif ORDER BY c.cli_des ASC";		
		//echo $sql;
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
			$array[$cnt]->saldo = number_format($r['saldo'], 2, ',', '.');
			$cnt++; 
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	
	public static function getAllClientesCobros(){
		
		$co_ven =$_SESSION['identidad'];	

		$sql="SELECT d.co_cli,
		c.cli_des,
		c.rif 
		FROM docum_cc d 
		INNER JOIN clientes c ON c.co_cli=d.co_cli WHERE d.co_ven='$co_ven' GROUP BY d.co_cli,
		c.cli_des,
		c.rif ORDER BY c.cli_des ASC";	

		//echo $sql;
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
		
			$cnt++; 
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	public static function getAdelantosCliente($co_cli,$filtro){
		/// Metodo para consultar el total de cuenas por cobrar	
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];
		$sql="Select rp.id,rp.fec_emis,rp.monto_cob,rpr.tipo_doc from jm_reportar_pago rp
		inner Join clientes c on rp.co_cli = c.co_cli 
		inner Join jm_reportar_pago_reg rpr on rp.id = rpr.cob_num		
		where c.co_cli ='".$co_cli."' and rp.co_ven = '".$co_ven."' and rpr.tipo_doc = 'ADEL' ORDER BY rp.fec_emis desc";
				
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {
				$objeto_pedido = New PedidoData();
				$data=$objeto_pedido->tasa();
				$tasa = $data['tasa'];			
			//echo "Estatus=".$status;
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->nro_doc = $r['id'];		
			$array[$cnt]->saldo = number_format($r['monto_cob']/$tasa, 2, ',', '.');			
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
					
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	
		public static function getFacturasCliente($co_cli, $filtro, $fecha_inicio, $fecha_final,$tipo_documento,$tipo_pago) {
			$numero_retencion = 0;
			// Filtro de anulado (0 para no anulado, 1 para anulado)
			if($filtro == 'NO') {
				$filtro = 0; // 0 es para no anulado
			} else {
				$filtro = 1; // 1 es para anulado
			}

			$co_ven = $_SESSION['identidad'];
			$co_sucu = $_SESSION['co_alma'];

			
			$sql = "SELECT 
					CAST(d.nro_doc AS VARCHAR) AS serie_fact_num,
					d.nro_doc,
					   CASE 
						WHEN d.tipo_doc IN ('N/CR', 'AJUSTE') THEN -(d.saldo/d.tasa)
						ELSE (d.saldo/d.tasa)
					END AS saldo,
					CASE 
						WHEN d.tipo_doc IN ('N/CR', 'AJUSTE') THEN -(d.saldo/d.tasa)
						ELSE (d.saldo/d.tasa)
					END AS saldoBs,
					d.fec_emis,
					d.tipo_doc,
					(d.monto_net) AS monto_neto,
					c.cli_des as cli_des,
					c.co_cli as co_cli,
					d.fec_venc,
					c.contribu_e,
					d.monto_imp,
					d.tipo,
					c.porc_esp,
					ISNULL(p.monto_total, 0) as monto_transito,
					DATEDIFF(d, d.fec_emis, GETDATE()) AS dias,
					DATEDIFF(d, d.fec_venc, GETDATE()) as dias_vencida, 
					CASE WHEN d.campo6 = '<$>' THEN 1 ELSE 0 END as forma 
				FROM docum_cc d     
					INNER JOIN clientes c ON d.co_cli = c.co_cli
					LEFT JOIN (
						SELECT nro_doc, SUM(monto) as monto_total
						FROM jm_reportar_pago_reg 
						WHERE status = 1
						AND tipo_doc !='ADEL'
						GROUP BY nro_doc
					) p ON d.nro_doc = p.nro_doc
				WHERE 
					d.saldo > 0 
					AND d.anulado = $filtro  
					AND d.co_ven = '$co_ven'";

				// Filtro por tipo de documento - si es 'no' muestra todos, sino filtra por los especificados
				if($tipo_documento == 'NO') {
					$sql .= " AND d.tipo_doc IN ('N/CR', 'N/DB', 'RET_IVA', 'FACT','ADEL')";

				}else{
					$sql .= " AND d.tipo_doc IN ('$tipo_documento')";
				}

				// Filtro por cliente si no es 'NO'
				if($co_cli != 'NO') {
					$sql .= " AND d.co_cli = '$co_cli'";
				}

				// Filtro por rango de fechas si están presentes
				if($fecha_inicio != 'NO' && $fecha_final != 'NO') {
					$sql .= " AND d.fec_emis BETWEEN '$fecha_inicio' AND '$fecha_final'";
				}

				$sql .= " ORDER BY d.fec_emis DESC";
			//echo $sql; // Para depuración, puedes comentar esta línea en producción 
			$query = Executor::doitAr($sql);    
			$e = count($query);        
			if($e >= 1) {
				$array = array();
				$cnt = 0;    
				$status = 0;
				foreach($query as $r) {

					
			  // --- INICIO DE LA MODIFICACIÓN ---
            
            // 1. Guardamos el número original de la base de datos.
            $numeroOriginal = $r['serie_fact_num'];
            $numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

            // 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
            // Usamos substr para obtener el primer carácter.
            if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal) ==8) {
                // Obtenemos el resto del número a partir del tercer carácter (índice 2).
                $restoDelNumero = substr($numeroOriginal, 2);
                // Construimos el nuevo número.
                $numeroFormateado = 'NF' . $restoDelNumero;
            }
            
            // --- FIN DE LA MODIFICACIÓN ---




					$objeto_pedido = New PedidoData();
				  	$objeto_funciones = New FuncionesData();
            		$data_retenciones = $objeto_funciones->getRetencionesFactura($r['nro_doc']);
					
					// MODIFICACIÓN AQUÍ: Manejar el caso cuando no hay retenciones
					if (!empty($data_retenciones) && isset($data_retenciones[0]->numero_retencion)) {
						$numero_retencion = $data_retenciones[0]->numero_retencion;
					} else {
						$numero_retencion = 0; // Valor por defecto cuando no hay retenciones
					}


					//echo $numero_retencion;
					$data = $objeto_pedido->tasa();
					$tasa = $data['tasa'];    
					$tasa = round((float)$tasa, 2); 
					//echo $tasa;
					$array[$cnt] = new FacturaData(); 
					$array[$cnt]->responsive_id = "";         
					$array[$cnt]->nro_doc = $r['nro_doc'];    
					$array[$cnt]->serie_fact_num = $numeroFormateado;    
					$array[$cnt]->saldo = round((float)$r['saldo'], 2);    
					$array[$cnt]->saldo2 = round((float)$r['saldo'], 2);    
					$array[$cnt]->saldo3 = round((float)($r['saldoBs'] * $tasa), 2);    
					$array[$cnt]->fec_emis = substr($r['fec_emis'], 0, 10);  // abcd ;    
					$array[$cnt]->fec_venc = substr($r['fec_venc'], 0, 10);  // abcd ;    
					$array[$cnt]->tipo_doc = $r['tipo_doc'];    
					$array[$cnt]->monto_transito = number_format($r['monto_transito'], 2, ',', '.');
					$array[$cnt]->dato2 = number_format(round((float)$r['monto_neto'], 2), 2, ',', '.');
					$array[$cnt]->dato1 = round((float)'0', 2);                
					$array[$cnt]->dato3 = $r['dias'];    
					$array[$cnt]->dato4 = $r['dias_vencida'];    
					$array[$cnt]->dato6 = $r['forma'];

					$array[$cnt]->dato7 = $r['contribu_e'];    
					$array[$cnt]->dato8 = $r['porc_esp'];  

					$array[$cnt]->dato9 = $r['tipo'];
					$array[$cnt]->dato10 = $r['monto_imp'];

						$array[$cnt]->dato11 = $numero_retencion;  

					$array[$cnt]->cli_des = trim($r['cli_des']);
					$array[$cnt]->co_cli = trim($r['co_cli']);
					$array[$cnt]->tasa = number_format($tasa, 2, ',', '.');        
					
					$cnt++;
				}
				return $array;
			} else {
				$array = array();
				return $array;
			}
		}
	public static function getFacturasClienteGerencial($co_cli,$filtro){
		/// Metodo para consultar el total de cuenas por cobrar	
	
		$co_sucu=$_SESSION['co_alma'];
		$sql="Select d.nro_doc,(d.saldo) AS saldo,d.fec_emis,d.tipo_doc,(d.monto_net) AS monto_neto,datediff(d, d.fec_emis, GETDATE()) AS dias from docum_cc d 
		inner Join clientes c on d.co_cli = c.co_cli 		
		where c.co_cli ='".$co_cli."'   AND d.saldo > 0 and d.anulado = ".$filtro." ORDER BY d.fec_emis desc";
		//
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {

				$objeto_pedido = New PedidoData();
				$data=$objeto_pedido->tasa();
				$tasa = $data['tasa'];	

				$objeto_pago_reg = New PagoRegData();				
				$data=$objeto_pago_reg->getData($r['nro_doc']);			
				if (empty($data)) {
    			$status=0;
				}else{
					//var_dump($data);
				$status=$data[0]->status;
				}
				
		
			//echo "Estatus=".$status;
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->nro_doc = $r['nro_doc'];		
			$array[$cnt]->saldo = number_format($r['saldo']/$tasa, 2, ',', '.');	
			$array[$cnt]->saldo2 = $r['saldo']/$tasa;	
			$array[$cnt]->saldo3= $r['saldoBs']/$tasa;	
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;	
			$array[$cnt]->tipo_doc = $r['tipo_doc'];	
			$array[$cnt]->dato2 = number_format($r['monto_neto'], 2, ',', '.');
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


	public static function getFacturaDetalles($fact_num,$co_cli){
		/// Metodo para consultar el total de cuenas por cobrar	
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql="Select f.fact_num,r.co_art,a.art_des,r.prec_vta/f.tasa as precio,r.total_art,r.reng_neto/f.tasa AS reng_neto from factura f 
		inner join reng_fac r on f.fact_num = r.fact_num
		Inner Join art a on r.co_art = a.co_art 
		where co_cli = '".$co_cli."' and f.anulada = 0 and f.saldo > 0 AND f.fact_num = '".$fact_num."'";
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
				

			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_art = $r['co_art'];	
			$array[$cnt]->art_des = $r['art_des'];			
			$array[$cnt]->precio = number_format($r['precio'], 2, ',', '.');	
			$array[$cnt]->total_art = number_format($r['total_art'], 2, ',', '.');	
			$array[$cnt]->reng_neto = number_format($r['reng_neto'], 2, ',', '.');				
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}

	}


	public static function clientesFacturados($co_ven,$finicio,$ffinal){
		if(($co_ven!='NO') && ($finicio=='NO') && ($ffinal=='NO')){

	

			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;

			$sql="SELECT c.co_cli, c.cli_des, c.fecha_reg, c.co_zon, z.zon_des
			FROM clientes c
			INNER JOIN zona z ON c.co_zon = z.co_zon
			WHERE 
				c.co_ven = '$co_ven'
				AND c.inactivo = 0
				AND YEAR(c.fecha_reg) <= $anio
				AND (YEAR(c.fecha_reg) < $anio OR MONTH(c.fecha_reg) <= $mes)
				AND EXISTS (
					SELECT 1
					FROM factura f
					WHERE 
						f.co_cli = c.co_cli
						AND YEAR(f.fec_emis) = $anio
						AND MONTH(f.fec_emis) = $mes1
						AND f.anulada = 0
				);";
		
		}

		// validaciones del pedido
	
	
		
	
		//echo $sql;	
		
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function clientesFacturadosGerente($co_ven,$co_zona,$finicio,$ffinal){

		if(($co_ven=='NO') && ($co_zona=='NO') && ($finicio=='NO') && ($ffinal=='NO')){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			$sql = "select distinct co_cli
				from factura f where MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'";

		}else{

			if($co_ven!='NO'){
				if($co_zona!='NO'){

					$sql = "select distinct f.co_cli
					from factura f 
					inner join clientes c on f.co_cli = c.co_cli 
					where fec_emis between '".$finicio."' AND '".$ffinal."' and f.co_ven in('$co_ven') and c.co_zon in('$co_zona') ";

				}else{
					$sql = "select distinct f.co_cli
					from factura f 
					inner join clientes c on f.co_cli = c.co_cli 
					where fec_emis between '".$finicio."' AND '".$ffinal."' and f.co_ven in('$co_ven')  ";
				}
			}else{

				if($co_zona!='NO'){

					$sql = "select distinct f.co_cli
					from factura f 
					inner join clientes c on f.co_cli = c.co_cli 
					where fec_emis between '".$finicio."' AND '".$ffinal."'  and c.co_zon in('$co_zona') ";

				}else{
					$sql = "select distinct f.co_cli
					from factura f 
					inner join clientes c on f.co_cli = c.co_cli 
					where fec_emis between '".$finicio."' AND '".$ffinal."'";
				}
			}
		}


	
	
		
		/*echo "<br>";
		echo $sql;	
		echo "<br>";*/
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public  function clientesNoFacturados($co_ven,$mes,$anio){
		

		if(($co_ven!='NO') && ($mes=='NO') && ($anio=='NO')){
			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="SELECT c.co_cli, c.fecha_reg
			FROM clientes c
			WHERE 
				c.co_ven = '$co_ven'
				AND c.inactivo = 0
				AND YEAR(c.fecha_reg) <= $anio
				AND (YEAR(c.fecha_reg) <= $anio OR MONTH(c.fecha_reg) <=$mes )
				AND NOT EXISTS (
					SELECT 1
					FROM factura f
					WHERE 
						f.co_cli = c.co_cli
						AND f.co_ven = '$co_ven'
						AND YEAR(f.fec_emis) = $anio
						AND MONTH(f.fec_emis) = $mes1
						AND f.anulada = 0
				);";
			
		}

		
		

	
		
	
		//echo $sql;	
		
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public  function clientesNoFacturadosGerente($co_ven,$co_zona,$finicio,$ffinal){

		if(($co_ven=='NO') && ($co_zona=='NO') && ($finicio=='NO') && ($ffinal=='NO')){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			$sql ="select co_cli from clientes where inactivo = 0 AND co_cli not in (select distinct co_cli
				from factura f where   MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio')";
		}else{

			if($co_ven!='NO'){
				if($co_zona!='NO'){

					$sql ="select co_cli from clientes where co_ven in ('$co_ven') and co_zon in('$co_zona') and inactivo = 0 AND co_cli not in (select distinct co_cli
					from factura f where  fec_emis between '".$finicio."' AND '".$ffinal."' and f.co_ven in('$co_ven'))";

				}else{
					$sql ="select co_cli from clientes where co_ven in ('$co_ven') and inactivo = 0 AND co_cli not in (select distinct co_cli
								from factura f where  fec_emis between '".$finicio."' AND '".$ffinal."' and f.co_ven in('$co_ven'))";
				}
			}else{

				if($co_zona!='NO'){

					$sql ="select co_cli from clientes where  co_zon in('$co_zona') and inactivo = 0 AND co_cli not in (select distinct co_cli
					from factura f where  fec_emis between '".$finicio."' AND '".$ffinal."' )";

				}else{
					$sql ="select co_cli from clientes where  inactivo = 0 AND co_cli not in (select distinct co_cli
					from factura f where  fec_emis between '".$finicio."' AND '".$ffinal."' )";
				}
			}
			
		}

		
		

		/*echo "<br>";
		echo $sql;	
		echo "<br>";*/
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public  function clientesNoFacturadosTabla($co_ven,$finicio,$ffinal){

		if(($co_ven !='NO') && ($finicio =='NO') && ($ffinal =='NO')){

			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
	
			$sql = "SELECT 
			MAX(f.fec_emis) AS fec_emis,
			f.co_cli,
			c.cli_des,
			DATEDIFF(day, MAX(f.fec_emis), GETDATE()) AS dias 
				FROM factura f
				INNER JOIN clientes c ON f.co_cli = c.co_cli 
				WHERE 
					c.inactivo = 0 
					AND c.co_ven = '$co_ven'  -- Filtro adicional para el vendedor V2
					AND NOT EXISTS (
						SELECT 1 
						FROM factura f2 
						WHERE 
							f2.co_cli = f.co_cli 
							AND MONTH(f2.fec_emis) = $mes 
							AND YEAR(f2.fec_emis) = $anio
							AND f2.co_ven = '$co_ven'  -- Consistencia con el filtro principal
					)    
				GROUP BY 
					f.co_cli,
					c.cli_des 
				ORDER BY 
					fec_emis;";

		}
		
		
	
	
		//codigo nombre fecha_ult_ve dias
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  
				$array[$cnt]->responsive_id = '';			
				$array[$cnt]->co_cli = $r['co_cli'];					
				$array[$cnt]->cli_des = $r['cli_des'];
				$array[$cnt]->dato1 =substr($r['fec_emis'], 0, 10);  // abcd ;	
				$array[$cnt]->dato2 = $r['dias'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public  function totalClientes($co_ven,$mes,$anio){
		
		
		$hoy = getdate();
		$mes1 = $hoy['mon'];
		$anio = $hoy['year'];
		$mes=$mes1-1;

		$fecha = new DateTime("$anio-$mes-01");
		$ultimoDia = $fecha->format('t');

		$sql ="	SELECT 
				c.co_cli, 
				c.fecha_reg
			FROM 
				clientes c
			WHERE 
				c.co_ven = '$co_ven'
				AND c.inactivo = 0
				AND (
					YEAR(c.fecha_reg) < $anio
					OR (
						YEAR(c.fecha_reg) = $anio 
						AND MONTH(c.fecha_reg) < $mes
					)
					OR (
						YEAR(c.fecha_reg) = $anio
						AND MONTH(c.fecha_reg) =  $mes 
						AND DAY(c.fecha_reg) <= $ultimoDia-1
					)
				);";


		// validaciones del pedido
		
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	
	public  function totalClientesGerente($co_ven,$co_zona,$finicio,$ffinal){
		if(($co_ven=='NO') && ($co_zona=='NO') && ($finicio=='NO') && ($ffinal=='NO')){
			
			$sql ="select co_cli from clientes where  inactivo = 0";


		}else{


			if($co_ven!='NO'){
				if($co_zona!='NO'){
					$sql ="select co_cli from clientes where co_ven in ('$co_ven') and co_zon in ('$co_zona')   and inactivo = 0";

					

				}else{
					$sql ="select co_cli from clientes where co_ven in ('$co_ven')    and inactivo = 0";
				}
			}else{

				if($co_zona!='NO'){

					$sql ="select co_cli from clientes where  co_zon in ('$co_zona')   and inactivo = 0";
				}else{
					$sql ="select co_cli from clientes where  inactivo = 0 AND co_cli not in (select distinct co_cli
					from factura f where  fec_emis between '".$finicio."' AND '".$ffinal."' )";
				}
			}



		}
		// validaciones del pedido
		
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public  function estadisticasFacturaciones($co_ven,$mes,$anio){
		// validaciones del pedido
		//$co_ven =$_SESSION['identidad'];	
		$data1=$this->clientesFacturados($co_ven,$mes,$anio);
		$data2=$this->clientesNoFacturados($co_ven,$mes,$anio);
		$data3=$this->totalClientes($co_ven,$mes,$anio);
		$totalFacturado = count($data1);
		$TotalNoFacturado = count($data2);
		$totalClientes =  count($data3);
	
			$array = array($totalFacturado,$TotalNoFacturado,$totalClientes);
			return $array;

		
		
	}


	public  function estadisticasFacturacionesGerente($co_ven,$co_zona,$fechaI,$fechaF){
		// validaciones del pedido
		//$co_ven =$_SESSION['identidad'];	
		$data1=$this->clientesFacturadosGerente($co_ven,$co_zona,$fechaI,$fechaF);
		$data2=$this->clientesNoFacturadosGerente($co_ven,$co_zona,$fechaI,$fechaF);
		$data3=$this->totalClientesGerente($co_ven,$co_zona,$fechaI,$fechaF);
		$totalFacturado = count($data1);
		$TotalNoFacturado = count($data2);
		$totalClientes =  count($data3);
	
			$array = array($totalFacturado,$TotalNoFacturado,$totalClientes);
			return $array;

		
			
	}


	public static function totalFacturacionesPeridodo($co_alma,$rango,$costo){
		// validaciones del pedido
		if($co_alma=='NO'){
			if($rango=='0'){
			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
	
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc		
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'
			AND tipo_doc = 'FACT' AND anulado = 0";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc
			inner join vendedor v on v.co_ven = docum_cc.co_ven
			inner join almacen a on a.co_alma = v.co_sucu
			WHERE fec_emis between '".$fechaI."' AND '".$fechaF."'
			AND tipo_doc = 'FACT' AND anulado = 0";
			//echo $sql;
	
			}
		
		}else{
			if($rango=='0'){
			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
	
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc
			inner join vendedor v on v.co_ven = docum_cc.co_ven
			inner join almacen a on a.co_alma = v.co_sucu		
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'
			AND tipo_doc = 'FACT' AND anulado = 0 AND a.co_alma='$co_alma'";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc
			inner join vendedor v on v.co_ven = docum_cc.co_ven
			inner join almacen a on a.co_alma = v.co_sucu
			WHERE fec_emis between '".$fechaI."' AND '".$fechaF."'
			AND tipo_doc = 'FACT' AND anulado = 0 AND a.co_alma='$co_alma'";
			//echo $sql;
	
			}
		}
		//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}
	
	public static function totalDevoluciones($rango,$costo){

		

		// validaciones del pedido
		
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc 
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio' AND tipo_doc = 'N/CR' AND anulado = 0 ";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc 
			inner join vendedor v on v.co_ven = docum_cc.co_ven
			inner join almacen a on a.co_alma = v.co_sucu
			WHERE fec_emis between '".$fechaI."' AND '".$fechaF."'
			AND tipo_doc = 'N/CR' AND anulado = 0";
			//echo $sql;
	
			}
		
		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function costoVentaMercancia($rango,$costo){
		$costo ="r.cos_pro_un";

		// validaciones del pedido
		
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT  SUM(r.total_art * ($costo/f.tasa)) AS monto 
			FROM factura f 
			INNER JOIN reng_fac r ON f.fact_num = r.fact_num 
			INNER JOIN art art ON r.co_art = art.co_art 
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'  AND f.anulada = 0 ";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT SUM(r.total_art * ($costo/f.tasa)) AS monto 
			FROM factura f 
			INNER JOIN reng_fac r ON f.fact_num = r.fact_num 
			INNER JOIN art art ON r.co_art = art.co_art 
			inner join vendedor v on v.co_ven = f.co_ven
			inner join almacen a on a.co_alma = v.co_sucu
			WHERE f.fec_emis between '".$fechaI."' AND '".$fechaF."'
			AND f.anulada = 0";
			//echo $sql;
	
			}
		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function costoVentaMercanciaDevoluciones($rango,$costo){
		$costo ="r.cos_pro_un";
		// validaciones del pedido
	
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT  sum(r.total_art * ($costo /f.tasa)) AS monto 
			FROM dev_cli f 
			INNER JOIN reng_dvc r ON f.fact_num = r.fact_num 
			INNER JOIN art art ON r.co_art = art.co_art 
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$anio'  AND f.anulada = 0 ";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT sum(r.total_art * ($costo /f.tasa)) AS monto 
			FROM dev_cli f 
			INNER JOIN reng_dvc r ON f.fact_num = r.fact_num 
			INNER JOIN art art ON r.co_art = art.co_art 
			inner join vendedor v on v.co_ven = f.co_ven
			inner join almacen a on a.co_alma = v.co_sucu
			WHERE f.fec_emis between '".$fechaI."' AND '".$fechaF."'
			AND f.anulada = 0";
			//echo $sql;
	
			}
		//	//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function gastos($rango){
				
		
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT SUM(monto) AS monto FROM ord_pago op		
			WHERE MONTH(op.fecha)='$mes' and  YEAR(op.fecha)='$anio'  AND op.anulada = 0 AND op.status = 'C' ";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT  SUM(monto) AS monto FROM ord_pago op 		
			WHERE op.fecha between '".$fechaI."' AND '".$fechaF."'
			AND  op.status = 'C'";
			//echo $sql;
	
			}
		
		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function ajustesPorFaltantesInventario($rango,$costo){
		$costo ="r.cos_pro_un";
		// validaciones del pedido
	
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT ISNULL(SUM(CASE WHEN t.tipo_trans = 'E' THEN (r.total_art * r.cost_unit) ELSE (r.total_art * r.cost_unit) *(-1) END),0) AS monto 
			FROM ajuste a 
			inner join reng_aju r ON a.ajue_num = r.ajue_num 
			inner join tipo_aju t ON r.tipo = t.co_tipo
			WHERE t.tipo_trans IN ('E', 'S') AND  MONTH(a.fecha )='$mes' and  YEAR(a.fecha )='$anio' AND r.co_alma not in ('10', '999') and a.motivo not like 'Ajuste por inventario físico.' ";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT ISNULL(SUM(CASE WHEN t.tipo_trans = 'E' THEN (r.total_art * r.cost_unit) ELSE (r.total_art * r.cost_unit) *(-1) END),0) AS monto 
			FROM ajuste a 
			inner join reng_aju r ON a.ajue_num = r.ajue_num 
			inner join tipo_aju t ON r.tipo = t.co_tipo
			WHERE t.tipo_trans IN ('E', 'S') AND  a.fecha between '".$fechaI."' AND '".$fechaF."' AND r.co_alma not in ('10', '999') and a.motivo not like 'Ajuste por inventario físico.' ";
		
			//echo $sql;
	
			}
		
		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function ajustesPorTomaDeInventario($rango,$costo){
		$costo ="r.cos_pro_un";
		// validaciones del pedido
		
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT ISNULL(SUM(CASE WHEN t.tipo_trans = 'E' THEN (r.total_art * r.cost_unit) ELSE (r.total_art * r.cost_unit) *(-1) END),0) AS monto 
			FROM ajuste a 
			inner join reng_aju r ON a.ajue_num = r.ajue_num 
			inner join tipo_aju t ON r.tipo = t.co_tipo
			WHERE t.tipo_trans IN ('E', 'S') AND  MONTH(a.fecha )='$mes' and  YEAR(a.fecha )='$anio'
			 AND r.co_alma not in ('10', '999') and a.motivo  like 'Ajuste por inventario físico.' ";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT ISNULL(SUM(CASE WHEN t.tipo_trans = 'E' THEN (r.total_art * r.cost_unit) ELSE (r.total_art * r.cost_unit) *(-1) END),0) AS monto 
			FROM ajuste a 
			inner join reng_aju r ON a.ajue_num = r.ajue_num 
			inner join tipo_aju t ON r.tipo = t.co_tipo
			WHERE t.tipo_trans IN ('E', 'S') AND  a.fecha between '".$fechaI."' AND '".$fechaF."'
			AND r.co_alma not in ('10', '999') and a.motivo  like 'Ajuste por inventario físico.' ";
		
			//echo $sql;
	
			}
		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function cajas(){
		
		
	
	
			$sql = "select sum(monto_h - monto_d) AS monto from mov_caj 
			where anulado = 0";
			//echo $sql;

			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function bancos(){			
		
			$sql = "select sum(monto_h - monto_d)  AS monto from mov_ban
			where anulado = 0";	

		//	echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function inventarios(){
		
		// validaciones del pedido
			
			$sql = "SELECT SUM(sa.stock_act * a.cos_pro_un) AS monto 
			FROM art a INNER JOIN st_almac sa ON a.co_art = sa.co_art
			WHERE sa.co_alma NOT IN ('10', '9999') and sa.stock_act>0";
			//echo $sql;


			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function cuentasXCobrar(){
		
		// validaciones del pedido
			
			$sql = "SELECT SUM(case when TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN saldo * (-1) ELSE saldo END) AS monto 
			FROM docum_cc WHERE saldo > 0 AND tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA')";
			//echo $sql;


			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function cuentasXPagar(){
		
		// validaciones del pedido
			
			$sql = "SELECT SUM(case when TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN saldo * (-1) ELSE saldo END) AS monto 
			FROM docum_cp WHERE saldo > 0 AND tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA')";
			//echo $sql;


			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	
	public static function gastosPorPagar($rango){
				
		
			if($rango=='0'){			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
			$sql = "SELECT ISNULL(SUM(monto),0) AS monto  FROM ord_pago  op	
			WHERE MONTH(op.fecha)='$mes' and  YEAR(op.fecha)='$anio' AND op.anulada = 0 AND op.status = 'P'";
			//echo $sql;

			}else{

			$fechaI = substr($rango, 0, 10); 	
			$fechaF = substr($rango, 14, 10); 
			$sql = "SELECT  ISNULL(SUM(monto),0) AS monto  FROM ord_pago  op	
			WHERE op.fecha between '".$fechaI."' AND '".$fechaF."'
			 AND op.anulada = 0 AND op.status = 'P'";
			//echo $sql;
	
			}
		
		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['monto'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}
	


	public  function getAllDatosGerenciales($co_alma,$rango,$costo){
	
		$data1=$this->totalFacturacionesPeridodo($co_alma,$rango,$costo);
		$data2=$this->totalDevoluciones($rango,$costo);
		$data3=$this->costoVentaMercancia($rango,$costo);
		$data4=$this->costoVentaMercanciaDevoluciones($rango,$costo);
		$data5=$this->gastos($rango);
		$data6=$this->ajustesPorFaltantesInventario($rango,$costo);
		$data7=$this->ajustesPorTomaDeInventario($rango,$costo);

		$data8=$this->cajas();
		$data9=$this->bancos();

		$data10=$this->inventarios();
		$data11=$this->cuentasXCobrar();
		$data12=$this->cuentasXPagar();


		$data13=$this->gastosPorPagar($rango);

		
		
		$totalFacturacionPeriodo = $data1[0]->dato1;
		$totalDevoluciones = $data2[0]->dato1;
		$costoVentaMercancia = $data3[0]->dato1;
		$costoVentaMercanciaDevoluciones = $data4[0]->dato1;
		$gastos = $data5[0]->dato1;
		$ajustesPorFaltantesInventario = $data6[0]->dato1;
		$ajustesPorTomaDeInventario = $data7[0]->dato1;

		$cajas = $data8[0]->dato1;
		$bancos = $data9[0]->dato1;

		$inventarios = $data10[0]->dato1;
		$cuentasXCobrar = $data11[0]->dato1;

		$cuentasXPagar = $data12[0]->dato1;

		$gastosPorPagar = $data13[0]->dato1;
		
		if(empty($totalFacturacionPeriodo) ){
			$totalFacturacionPeriodo=0.00;
		}
		if(empty($totalDevoluciones) ){
			$totalDevoluciones=0.00;
		}
		if(empty($costoVentaMercancia) ){
			$costoVentaMercancia=0.00;
		}
		if(empty($costoVentaMercanciaDevoluciones) ){
			$costoVentaMercanciaDevoluciones=0.00;
		}
		if(empty($gastos) ){
			$gastos=0.00;
		}
		if(empty($ajustesPorFaltantesInventario) ){
			$ajustesPorFaltantesInventario=0.00;
		}
		if(empty($ajustesPorTomaDeInventario) ){
			$ajustesPorTomaDeInventario=0.00;
		}
		if(empty($cajas) ){
			$cajas=0.00;
		}
		if(empty($bancos) ){
			$bancos=0.00;
		}
		
		if(empty($inventarios) ){
			$inventarios=0.00;
		}

		
		if(empty($cuentasXCobrar) ){
			$cuentasXCobrar=0.00;
		}

		if(empty($cuentasXPagar) ){
			$cuentasXPagar=0.00;
		}

		if(empty($gastosPorPagar) ){
			$gastosPorPagar=0.00;
		}
		

		$totalVentas=(float)$totalFacturacionPeriodo-(float)$totalDevoluciones;
		
		$array = array($totalFacturacionPeriodo,$totalDevoluciones,$totalVentas,$costoVentaMercancia,
		$costoVentaMercanciaDevoluciones,$gastos,$ajustesPorFaltantesInventario,
		$ajustesPorTomaDeInventario,$cajas,$bancos,$inventarios,$cuentasXCobrar,$cuentasXPagar,$gastosPorPagar);
		return $array;	
		
	}

	public static function analisis31_60($co_ven){
		$sql="Select d.co_ven,
		SUM(case when d.TIPO_DOC IN('N/CR',
		'ADEL',
		'ISLR',
		'AJNM',
		'AJNA')THEN(d.saldo/d.tasa)*(-1)ELSE(d.saldo/d.tasa)END) AS saldo
		from docum_cc d 
		inner join vendedor v on d.co_ven = v.co_ven
		inner Join clientes c on d.co_cli=c.co_cli
		where  d.saldo > 0 and d.anulado=0 AND d.co_ven in ('".$co_ven."') and datediff(d,d.fec_venc,GETDATE()) between 31 and 60
		group by d.co_ven, v.ven_des";		
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}

	public static function analisis61_90($co_ven){
		$sql="Select d.co_ven,
		SUM(case when d.TIPO_DOC IN('N/CR',
		'ADEL',
		'ISLR',
		'AJNM',
		'AJNA')THEN(d.saldo/d.tasa)*(-1)ELSE(d.saldo/d.tasa)END) AS saldo
		from docum_cc d 
		inner join vendedor v on d.co_ven = v.co_ven
		inner Join clientes c on d.co_cli=c.co_cli
		where  d.saldo > 0 and d.anulado=0 AND d.co_ven in ('".$co_ven."') and datediff(d,d.fec_venc,GETDATE()) between 61 and 90
		group by d.co_ven, v.ven_des";		

		//echo $sql;
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}

	public static function analisis91_120($co_ven){
		$sql="Select d.co_ven,
		SUM(case when d.TIPO_DOC IN('N/CR',
		'ADEL',
		'ISLR',
		'AJNM',
		'AJNA')THEN(d.saldo/d.tasa)*(-1)ELSE(d.saldo/d.tasa)END) AS saldo
		from docum_cc d 
		inner join vendedor v on d.co_ven = v.co_ven
		inner Join clientes c on d.co_cli=c.co_cli
		where  d.saldo > 0 and d.anulado=0 AND d.co_ven in ('".$co_ven."') and datediff(d,d.fec_venc,GETDATE()) between 91 and 120
		group by d.co_ven, v.ven_des";		
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}

	public static function analisis120($co_ven){
		$sql="Select d.co_ven,
		SUM(case when d.TIPO_DOC IN('N/CR',
		'ADEL',
		'ISLR',
		'AJNM',
		'AJNA')THEN(d.saldo/d.tasa)*(-1)ELSE(d.saldo/d.tasa)END) AS saldo
		from docum_cc d 
		inner join vendedor v on d.co_ven = v.co_ven
		inner Join clientes c on d.co_cli=c.co_cli
		where  d.saldo > 0 and d.anulado=0 AND d.co_ven in ('".$co_ven."') and datediff(d,d.fec_venc,GETDATE())  > 120
		group by d.co_ven, v.ven_des";		
		$tasa=Executor::doit($sql);
		//echo $fact_num;
		return $tasa;
	}

	public static function getAllAnalisisVCTO($co_ven){
		$co_sucu=$_SESSION['co_alma'];
		
			if($co_ven=='NO'){
				$hoy = getdate();			
				$anio = $hoy['year'];

				$sql="Select d.co_ven,v.ven_des,
				SUM(case when d.TIPO_DOC IN('N/CR',
				'ADEL',
				'ISLR',
				'AJNM',
				'AJNA')THEN(d.saldo/d.tasa)*(-1)ELSE(d.saldo/d.tasa)END) AS saldo
				from docum_cc d 
				inner join vendedor v on d.co_ven = v.co_ven
				inner Join clientes c on d.co_cli=c.co_cli
				where  d.saldo > 0 and d.anulado=0  and datediff(d,d.fec_venc,GETDATE()) between 0 and 30
				group by d.co_ven, v.ven_des";	

			}else{
				$hoy = getdate();			
				$anio = $hoy['year'];

				$sql="Select d.co_ven,v.ven_des,
				SUM(case when d.TIPO_DOC IN('N/CR',
				'ADEL',
				'ISLR',
				'AJNM',
				'AJNA')THEN(d.saldo/d.tasa)*(-1)ELSE(d.saldo/d.tasa)END) AS saldo
				from docum_cc d 
				inner join vendedor v on d.co_ven = v.co_ven
				inner Join clientes c on d.co_cli=c.co_cli
				where  d.saldo > 0 and d.anulado=0 AND d.co_ven in ('".$co_ven."') and datediff(d,d.fec_venc,GETDATE()) between 0 and 30
				group by d.co_ven, v.ven_des ORDER BY d.co_ven ASC";		
			}

		
		//$co_ven =$_SESSION['identidad'];
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
				$objeto_saldo_rango = New FacturaData();
				$data31_60=$objeto_saldo_rango->analisis31_60($r['co_ven']);
				if(empty($data31_60) ){
					$saldo31_60=0.00;
				}else{
					$saldo31_60=$data31_60['saldo'];
				}
				

				$data61_90=$objeto_saldo_rango->analisis61_90($r['co_ven']);
				//$saldo61_90=$data61_90['saldo'];

				if(empty($data61_90) ){
					$saldo61_90=0.00;
				}else{
					$saldo61_90=$data61_90['saldo'];
				}
				

				$data91_120=$objeto_saldo_rango->analisis91_120($r['co_ven']);

				if(empty($data91_120) ){
					$saldo91_120=0.00;
				}else{
					$saldo91_120=$data91_120['saldo'];
				}
				
		

				$data120=$objeto_saldo_rango->analisis120($r['co_ven']);
				//$saldo120=$data120['saldo'];

				if(empty($data120) ){
					$saldo120=0.00;
				}else{
					$saldo120=$data120['saldo'];
				}

				$objeto_pedido = New PedidoData();
				$data=$objeto_pedido->tasa();
				$tasa = $data['tasa'];
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_cli = $r['co_ven'];	
			$array[$cnt]->cli_des = $r['ven_des'];
			$array[$cnt]->dato1 =  number_format($r['saldo'], 2, ',', '.');
			$array[$cnt]->dato2 =  number_format($saldo31_60, 2, ',', '.'); // dejar este asi,  ya que el enmascaramiento lo debo hacer por js
			$array[$cnt]->dato3 =  number_format($saldo61_90, 2, ',', '.');
			$array[$cnt]->dato4 =  number_format($saldo91_120, 2, ',', '.');
			$array[$cnt]->dato5 =  number_format($saldo120, 2, ',', '.');
			$cnt++; 
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	
	public static function getAllClientes(){

		$sql="SELECT d.co_cli, c.cli_des, c.rif, SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN (d.saldo/d.tasa) * (-1) ELSE (d.saldo/d.tasa) END) as saldo
		FROM docum_cc d INNER JOIN clientes c ON c.co_cli=d.co_cli
		WHERE d.saldo > 0 AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') GROUP BY d.co_cli,c.cli_des,c.rif ORDER BY c.cli_des ASC";		
		//echo $sql;
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
			$array[$cnt]->saldo = number_format($r['saldo'], 2, ',', '.');
			$cnt++; 
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

		
	public static function getAllZonas(){

		$sql="select * from zona z ORDER BY z.co_zon desc";		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_zon = $r['co_zon'];	
			$array[$cnt]->zon_des = $r['zon_des'];
			
			$cnt++; 
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	
	
	public static function getFacturasInventario($co_cli,$filtro){
		if($filtro=='0') $filtro='';
		if($filtro=='2') $filtro='1';
		
		$sql ="select f.fact_num, f.fec_emis, c.cli_des, co.dias_cred from factura f inner join clientes c on f.co_cli = c.co_cli 
		join condicio co on f.forma_pag = co.co_cond where c.co_zon= '$co_cli' and len(f.campo1)='0'";

	
		//
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {				
				
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 =  	trim($r['fact_num']);		
			$array[$cnt]->dato2 =   substr($r['fec_emis'], 0, 10);
			$array[$cnt]->dato3 =   $r['cli_des'];
			$array[$cnt]->dato4 =	$r['dias_cred'];
						
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}

	}

	public static function getFacturasInventarioDespachos($filtro){
			$filtro='';
			$co_ven =$_SESSION['identidad'];	
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	

			$sql ="Select fec_emis,
			f.fact_num,
			d.campo1,
			c.cli_des,
			d.fecha,
			d.estatus
			FROM factura f 
			INNER JOIN clientes c On f.co_cli=c.co_cli 
			INNER JOIN jm_despacho d ON f.fact_num = d.fact_num
			WHERE (d.estatus =1 or d.estatus=2 or d.estatus = 3) 	AND  ( MONTH(d.fecha) = '$mes'  or   MONTH(d.fecha) = '$mes2'  )  and  d.co_ven = '$co_ven'".$filtro;
	


		//
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {				
				
			$array[$cnt] = new FacturaData(); 	
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->dato1 =  trim($r['fact_num']);		
			$array[$cnt]->dato2 =    substr($r['fecha'], 0, 10);
			$array[$cnt]->dato3 =   trim($r['campo1']);
			$array[$cnt]->dato4 = 	trim($r['cli_des']);	
			$array[$cnt]->dato5 = 	trim($r['estatus']);			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}

	}

	public static function getFacturasVerificadas($filtro,$filtro2,$verificador){
				
			
				
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	
				$mes2 = $mes-1;

				if($verificador!='NO'){
					$filtroPersona=" AND d.co_ven = '$verificador' ";

				}else{
					$filtroPersona='';
				}

				if($filtro!='NO'){
					$filtroFecha = "AND d.fecha between '".$filtro."' AND '".$filtro2."' ";

				}else{

					$filtroFecha ="AND  ( MONTH(d.fecha) = '$mes'  or   MONTH(d.fecha) = '$mes2'  ) AND YEAR(d.fecha) = '$anio' ";
				}

				$sql ="Select fec_emis,
				f.fact_num,
				CASE 
						WHEN LEFT(CAST(f.fact_num AS VARCHAR), 1) = '5' 
						THEN 'NF' + SUBSTRING(CAST(f.fact_num AS VARCHAR), 3, LEN(CAST(f.fact_num AS VARCHAR)))
						ELSE CAST(f.fact_num AS VARCHAR)
					END AS serie_fact_num,
				d.campo1,
				c.cli_des,
				p.persona_des,
				d.fecha,
				d.estatus
				FROM factura f 
				INNER JOIN clientes c On f.co_cli=c.co_cli 
				INNER JOIN jm_despacho d ON f.fact_num = d.fact_num
				INNER JOIN jm_personas p ON d.co_ven = p.co_ocupa 
				WHERE (d.estatus =1 or d.estatus=2 or d.estatus = 3)".$filtroFecha.$filtroPersona;



			//
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				$status=0;
				foreach($query as $r) {				
					
				$array[$cnt] = new FacturaData(); 	
				$array[$cnt]->responsive_id = ""; 		
				$array[$cnt]->dato1 =  trim($r['fact_num']);		
				$array[$cnt]->dato2 =    substr($r['fecha'], 0, 10);
				$array[$cnt]->dato3 =   trim($r['campo1']);
				$array[$cnt]->dato4 = 	trim($r['cli_des']);	
				$array[$cnt]->dato5 = 	trim($r['estatus']);	
				$array[$cnt]->dato7 = 	trim($r['serie_fact_num']);		
				$array[$cnt]->dato6 = 	trim($r['persona_des']);				
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}

	}
		
	public static function getFacturasInventarioDespachosAlmacen($filtro,$filtro2,$verificador) {
		$sql = ""; // Inicializamos la variable SQL

	
		if($verificador!='NO'){
				$filtroPersona=" AND d.co_ven = '$verificador' ";

			}else{
				$filtroPersona='';
			}

			if($filtro!='NO'){
				$filtroFecha = "AND d.fecha between '".$filtro."' AND '".$filtro2."' ";

			}else{
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];	

				$filtroFecha ="AND  ( MONTH(d.fecha) = '$mes' ) AND YEAR(d.fecha) = '$anio' ";
			}
$sql = "WITH FacturasConsulta AS (
    SELECT 
        f.fec_emis,
        f.fact_num,
        CAST(f.fact_num AS VARCHAR) AS serie_fact_num,
        d.campo1,
        c.cli_des,
        CASE 
            WHEN LEN(CAST(dir_ent AS VARCHAR(MAX))) > 0 THEN dir_ent 
            ELSE CASE 
                WHEN LEN(CAST(c.dir_ent2 AS VARCHAR(MAX))) > 0 THEN c.dir_ent2 
                ELSE c.direc1 
            END 
        END AS direc1,
        c.co_cli,
        c.ciudad,
        c.zip,
        c.telefonos,
        z.zon_des,
        t.des_tran,
        d.fecha,
        d.estatus,
        p.persona_des,
        v.ven_des, 
        v.co_ven,
        v.telefonos as telefono_vendedor
    FROM 
        factura f 
        INNER JOIN clientes c ON f.co_cli = c.co_cli 
        INNER JOIN jm_despacho d ON f.fact_num = d.fact_num 
        INNER JOIN jm_personas p ON d.co_ven = p.co_ocupa 
        INNER JOIN zona z ON z.co_zon = c.co_zon 
        INNER JOIN transpor t ON t.co_tran = f.co_tran 
        INNER JOIN vendedor v ON f.co_ven = v.co_ven
    WHERE 
        (d.estatus = 1 OR d.estatus = 2 OR d.estatus = 3) 
        AND f.campo5 <> '1'
        $filtroFecha  
        $filtroPersona
)
SELECT 
    f.*,
    CASE 
        WHEN EXISTS (
            SELECT 1 
            FROM jm_paquetes_reg p 
            WHERE p.facturas LIKE '%\"' + f.serie_fact_num + '\"%'
        ) THEN '1'
        -- Caso especial: si serie_fact_num tiene longitud 8, transformar y verificar
        WHEN LEN(f.serie_fact_num) = 8 AND EXISTS (
            SELECT 1 
            FROM jm_paquetes_reg p 
            WHERE p.facturas LIKE '%\"NF' + SUBSTRING(f.serie_fact_num, 3, LEN(f.serie_fact_num)) + '\"%'
        ) THEN '1'
        ELSE '0' 
    END AS EstadoRegistro
FROM 
    FacturasConsulta f;";
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e = count($query);		
		if ($e >= 1) {
			$array = array();
			$cnt = 0;	
			foreach ($query as $r) {				
				$array[$cnt] = new FacturaData(); 	
				
			  // --- INICIO DE LA MODIFICACIÓN ---
            
            // 1. Guardamos el número original de la base de datos.
            $numeroOriginal = $r['serie_fact_num'];
            $numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

            // 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
            // Usamos substr para obtener el primer carácter.
            if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal)== 8) {
                // Obtenemos el resto del número a partir del tercer carácter (índice 2).
                $restoDelNumero = substr($numeroOriginal, 2);
                // Construimos el nuevo número.
                $numeroFormateado = 'NF' . $restoDelNumero;
            }
            
            // --- FIN DE LA MODIFICACIÓN ---

				// Campos principales de la factura
				$array[$cnt]->factura_numero = trim($r['fact_num']);
				$array[$cnt]->factura_serie = $numeroFormateado;
				$array[$cnt]->factura_fecha_emision = substr($r['fec_emis'], 0, 10);
				$array[$cnt]->factura_fecha_despacho = substr($r['fecha'], 0, 10);
				$array[$cnt]->factura_estatus = trim($r['estatus']);
				
				// Datos del cliente
				$array[$cnt]->cliente_codigo = trim($r['co_cli']);
				$array[$cnt]->cliente_nombre = trim($r['cli_des']);
				$array[$cnt]->cliente_direccion = trim($r['direc1']);
				$array[$cnt]->cliente_ciudad = trim($r['ciudad']);
				$array[$cnt]->cliente_zip = trim($r['zip']);
				$array[$cnt]->cliente_telefonos = trim($r['telefonos']);
				$array[$cnt]->cliente_zona = trim($r['zon_des']);
				
				// Datos del despacho
				$array[$cnt]->despacho_preparado_por = trim($r['campo1']);
				$array[$cnt]->despacho_verificado_por = trim($r['persona_des']);
				$array[$cnt]->despacho_transporte = trim($r['des_tran']);
				
				$array[$cnt]->co_ven = trim($r['co_ven']);
				$array[$cnt]->telefono_vendedor = trim($r['telefono_vendedor']);
			

				// Para compatibilidad con el código existente
				$array[$cnt]->responsive_id = "";
				$array[$cnt]->dato1 = trim($r['fact_num']);
				$array[$cnt]->dato2 = substr($r['fecha'], 0, 10);
				$array[$cnt]->dato3 = trim($r['campo1']);
				$array[$cnt]->dato4 = trim($r['cli_des']);
				$array[$cnt]->dato5 = trim($r['estatus']);
				$array[$cnt]->dato6 = trim($r['persona_des']);
				$array[$cnt]->dato7 = trim($numeroFormateado);

				$array[$cnt]->EstadoRegistro = trim($r['EstadoRegistro']);
				
				$cnt++;
			}
			return $array;
		} else {
			$array = array();

			$cnt = 0;	
			$array[$cnt] = new FacturaData(); 	
			$array[$cnt]->responsive_id = "";
			return $array;
		}
	}

	public static function getFacturasDespacho($fact_num){
		/// Metodo para consultar el total de cuenas por cobrar	
		$sql ="Select r.co_art, a.art_des, r.total_art, c.cli_des from not_ent f inner join reng_nde r on f.fact_num = r.fact_num 
		Inner join art a on r.co_art = a.co_art
		Inner join clientes c
		On f.co_cli = c.co_cli
		Where f.fact_num ='".$fact_num."'";
	
		//
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {				
				
			$array[$cnt] = new FacturaData(); 	
			$inventario = FuncionesData::getBy3Id('jm_inventario','fact_nun',$fact_num,'co_art',$r['co_art'],'FacturaData','fec_fab','fec_ven','cantidad','tipo');
			$array[$cnt]->dato1 =  trim($r['co_art']);		
			$array[$cnt]->dato2 =  $r['art_des'];		
		
			$array[$cnt]->dato4 =  $r['cli_des'];		
			if(empty($inventario )){
				$array[$cnt]->dato5 =  "";			
				$array[$cnt]->dato6 = "";		
				$array[$cnt]->dato7 = "";		
				$array[$cnt]->dato3 =  intval($r['total_art']);		
			}else{
				$array[$cnt]->dato5 =  $inventario[0]->dato1;			
				$array[$cnt]->dato6 =  $inventario[0]->dato2;	
				$array[$cnt]->dato7 =  $inventario[0]->dato4;		
				$array[$cnt]->dato3 =  $inventario[0]->dato3;	
				$array[$cnt]->dato7 =  $inventario[0]->dato4;	
			}
						
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}

	}


			
	/**
 * Obtiene las facturas para despachar de un mes específico o del mes en curso.
 *
 * @param string $mesParametro El mes a consultar. Puede ser:
 *                             - Un número de mes (ej: "1", "01", "12").
 *                             - La palabra "no" para consultar el mes en curso.
 * @return array Un array de objetos FacturaData.
 */
public static function getDataFacturasParaDespachar($mesParametro){
	//echo $mesParametro;
	//$mesParametro = 9;
    // 1. Obtenemos el año actual, que se usará en ambos casos.
    $hoy = getdate();
    $anio = $hoy['year'];

    // 2. Determinamos qué mes vamos a consultar basándonos en el parámetro.
    $mes_a_consultar = '';
    if (strtolower($mesParametro) === 'no') {
        // Si el parámetro es "no", usamos el mes actual.
        $mes_a_consultar = $hoy['mon'];
    } else {
        // Si no, intentamos usar el valor del parámetro como el mes.
        // Convertimos a número para asegurar que sea un valor entre 1 y 12.
        $mes_num = intval($mesParametro);
        if ($mes_num >= 1 && $mes_num <= 12) {
            $mes_a_consultar = $mes_num;
        } else {
            // Si el parámetro no es válido, devolvemos un array vacío.
            // Esto previene errores y consultas SQL maliciosas.
            return array();
        }
    }

    // 3. Construimos la consulta SQL usando el mes y el año determinados.
    // Se usa intval() para asegurar que los valores son números y evitar inyección SQL básica.
    $sql="	SELECT
          c.fact_num  AS serie_fact_num,CONVERT(VARCHAR, fec_emis, 103) AS fecha_formateada  
         FROM factura c 
         WHERE campo7='' 
         and campo8='' 
         and MONTH(c.fec_emis)=".intval($mes_a_consultar)." 
         and YEAR(c.fec_emis)=".intval($anio)." 
         and c.anulada='0' ";		
    
  //  echo $sql;
    $query = Executor::doitAr($sql);	
    $e=count($query);		
    
    if($e>=1){
        $array = array();
        $cnt = 0;	
        foreach($query as $r) {

			  // --- INICIO DE LA MODIFICACIÓN ---
            
            // 1. Guardamos el número original de la base de datos.
            $numeroOriginal = $r['serie_fact_num'];
            $numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

            // 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
            // Usamos substr para obtener el primer carácter.
            if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal) ==8) {
                // Obtenemos el resto del número a partir del tercer carácter (índice 2).
                $restoDelNumero = substr($numeroOriginal, 2);
                // Construimos el nuevo número.
                $numeroFormateado = 'NF' . $restoDelNumero;
            }
            
            // --- FIN DE LA MODIFICACIÓN ---



            $array[$cnt] = new FacturaData(); 
            $array[$cnt]->responsive_id = ""; 		
            $array[$cnt]->fact_num = $numeroFormateado;	
            $array[$cnt]->dato1 = $r['fecha_formateada'];	
            $cnt++; 
        }
        return $array;
    }else{
        // Es una buena práctica devolver un array vacío en lugar de null o false.
        return array();
    }
}



	


                        




	public function registrarDespacho($fact_num,$preparador){
		$co_ven =$_SESSION['identidad'];
		$despach_des =$_SESSION['nombre'];

		$sql = "INSERT INTO jm_despacho (co_ven,fact_num,fecha,estatus,campo1) ";
		$sql .= "VALUES ('$co_ven','$fact_num',getdate(),1,'$preparador')";		
		//echo $sql;	
		//echo "<br>";
		Executor::doitEx($sql);	
		$data=$this->getUltimoDespacho();
		$desp_nun=$data['desp_nun'];
	
		$sql = "UPDATE ".self::$tablename." SET campo1 = '1' ,campo8 = '$despach_des',campo7='$desp_nun' WHERE fact_num ='$fact_num'";
		//echo $sql;
		//echo "<br>";
		Executor::doitEx($sql);

		//echo $sql;


		
	}


	public static function getUltimoDespacho(){
		$sql = "SELECT max(id) as desp_nun FROM jm_despacho";
			//echo $sql;
			$desp_nun=Executor::doit($sql);
			return $desp_nun;
	}
	        



	public function registrarDespachoReg($productos,$desp_nun){
		//    print_r($productos);
                            foreach ($productos as $producto) {
                                try {
                                    // Validar producto individual
                                    if (!isset($producto['co_art']) || empty($producto['co_art'])) {
                                        throw new Exception('Código de producto inválido');
                                    }
                                    
                                    if (!isset($producto['cantidad']) || $producto['cantidad'] <= 0) {
                                        throw new Exception('Cantidad inválida para producto: ' . $producto['co_art']);
                                    }
									

									$sql = "INSERT INTO jm_despacho_reg (despacho_nun, co_art, cantidad,estatus) ";
									$sql .= "VALUES ($desp_nun, '{$producto['co_art']}', {$producto['cantidad']},1)";
								//	echo $sql;	
									//echo "<br>";
									Executor::doitEx($sql);


                                
                              
                                    
                                } catch (Exception $e) {
                                    $errores[] = [
                                        'co_art' => $producto['co_art'] ?? 'Desconocido',
                                        'error' => $e->getMessage()
                                    ];
                                }
                            }
        
		
	}


public function devolverDespacho($fact_num, $motivo){
    try {
        // Primera actualización - con debugging
        $sql1 = "UPDATE ".self::$tablename." SET campo7 = '', campo8 = '' WHERE fact_num = '$fact_num'";
        $result1 = Executor::doitEx($sql1);
        
        // Debug: ver qué retorna doitEx()
        error_log("Result1 type: " . gettype($result1));
        error_log("Result1 value: " . print_r($result1, true));
        
        // Segunda actualización
        $sql2 = "UPDATE jm_despacho SET campo2 = '$motivo', estatus = '4' WHERE fact_num = '$fact_num'";
        $result2 = Executor::doitEx($sql2);
        
        // Debug: ver qué retorna doitEx()
        error_log("Result2 type: " . gettype($result2));
        error_log("Result2 value: " . print_r($result2, true));
        
        return [
            'success' => true,
            'message' => 'Despacho devuelto exitosamente',
            'fact_num' => $fact_num
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error al devolver el despacho: ' . $e->getMessage(),
            'error' => $e->getMessage(),
            'fact_num' => $fact_num
        ];
    }
}
	
	public function eliminarDespacho($fact_num, $motivo){
    	try {
        // CORRECCIÓN: La sentencia DELETE tiene sintaxis incorrecta
        // Debería ser: DELETE FROM jm_despacho WHERE fact_num = '$fact_num'
        // Pero parece que quieres actualizar en lugar de eliminar
        
        // Primera actualización
        $sql1 = "UPDATE ".self::$tablename." SET campo7 = '', campo8 = '' WHERE fact_num = '$fact_num'";
        $result1 = Executor::doitEx($sql1);       
		
			
			// OPCIÓN 1: Si quieres actualizar el estatus a 0 (eliminado lógico)
			$sql2 = "UPDATE jm_despacho SET campo2 = '$motivo', estatus = '0' WHERE fact_num = '$fact_num'";
			
			// OPCIÓN 2: Si quieres eliminar físicamente el registro
			// $sql2 = "DELETE FROM jm_despacho WHERE fact_num = '$fact_num'";
			
			$result2 = Executor::doitEx($sql2);
			
		  
				// Debug: ver qué retorna doitEx()
				error_log("Result2 type: " . gettype($result2));
				error_log("Result2 value: " . print_r($result2, true));
				
				return [
					'success' => true,
					'message' => 'Despacho eliminado exitosamente',
					'fact_num' => $fact_num
				];
				
			
		} catch (Exception $e) {
			    return [
            'success' => false,
            'message' => 'Error al eliminar el despacho: ' . $e->getMessage(),
            'error' => $e->getMessage(),
            'fact_num' => $fact_num
        ];
		}
	}

	public static function getAllDatosCobros($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5){
		//echo $filtro;
		$co_ven =$_SESSION['identidad'];	

		if($filtro=='NO'){

				  $hoy = getdate();
        $mes = $hoy['mon'];
        $anio = $hoy['year'];
        $mes2 = $mes-1;


			$sql = "select CAST(rpg.nro_doc AS VARCHAR)  AS serie_fact_num, 
					 c.co_cli,
					 c.cli_des,
					 rpg.id,
					 rpg.nro_doc,
					 rpg.forma_pag,
					 rpg.ref_ban,
					 rpg.monto,rpg.monto_bs,rpg.fec_tran,rpg.status as estatus,
			rpg.co_cuenta,rpg.cod_caja
			FROM jm_reportar_pago_reg rpg 
			INNER JOIN jm_reportar_pago rp ON rpg.cob_num = rp.cob_num 
			INNER JOIN clientes c ON rp.co_cli = c.co_cli
			WHERE rp.co_ven='$co_ven'  and rpg.status = '1'   and MONTH(rpg.fec_tran) = '$mes'
        AND YEAR(rpg.fec_tran) = '$anio'" ;

		}else{

		
			$sql = "select CAST(rpg.nro_doc AS VARCHAR) AS serie_fact_num, 
					 c.co_cli,
					 c.cli_des,
					 rpg.id,
					 rpg.nro_doc,
					 rpg.forma_pag,
					 rpg.ref_ban,
					 rpg.monto,rpg.monto_bs,rpg.fec_tran,rpg.status as estatus,
			rpg.co_cuenta,rpg.cod_caja
			FROM jm_reportar_pago_reg rpg 
			INNER JOIN jm_reportar_pago rp ON rpg.cob_num = rp.cob_num 
			INNER JOIN clientes c ON rp.co_cli = c.co_cli
			WHERE rp.co_ven='$co_ven'  and rpg.status = '1'   and MONTH(rpg.fec_tran) = '$mes'
        AND YEAR(rpg.fec_tran) = '$anio'" ;
		
		}

		
	
		//echo $sql;
		$query = Executor::doitAr($sql);	

		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {				

							
			  // --- INICIO DE LA MODIFICACIÓN ---
            
            // 1. Guardamos el número original de la base de datos.
            $numeroOriginal = trim($r['serie_fact_num']);
            $numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

            // 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
            // Usamos substr para obtener el primer carácter.
            if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal) ==8) {
                // Obtenemos el resto del número a partir del tercer carácter (índice 2).
                $restoDelNumero = substr($numeroOriginal, 2);
                // Construimos el nuevo número.
                $numeroFormateado = 'NF' . $restoDelNumero;
            }
            
            // --- FIN DE LA MODIFICACIÓN ---


			
			$array[$cnt] = new FacturaData(); 		
			$co_cuenta =  trim($r['co_cuenta']);

				if($co_cuenta !='NO'){

				$objeto_cuenta = New BancoData();
				$ban_des = $objeto_cuenta->getDataId($co_cuenta);
				$dato1 =$r['monto_bs'];	
				$dato2 = $ban_des[0]->des_ban;
				$dato3 =  $ban_des[0]->num_cta;
				$dato4 =  "1";
				$objeto_pago = New PagoData();
				$data = $objeto_pago->getDataReng($co_cuenta,$dato1);
				$data5 = $data[0]->cob_num;
			
			}else{
				$dato1 ="EFECTIVO";	
				$dato2 = $r['cod_caja'];
				$dato3 = $r['cod_caja'];
				$dato4 =  "2";

				$objeto_pago = New PagoData();
				$data = $objeto_pago->getDataReng($co_cuenta,'0');
				$data5 = $data[0]->cob_num;


			}
			


			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->id = $r['id'];	
			$array[$cnt]->serie_fact_num =$numeroFormateado;	
			$array[$cnt]->nro_doc = $r['nro_doc'];		
			$array[$cnt]->forma_pag = $r['forma_pag'];			
			$array[$cnt]->monto =number_format($r['monto'], 2, ',', '.');			
			$array[$cnt]->monto_bs = number_format($r['monto_bs'], 2, ',', '.');
			$array[$cnt]->fec_tran = $r['fec_tran'];	
			$array[$cnt]->estatus =$data5;	
			$array[$cnt]->dato1 = $dato1;	
			$array[$cnt]->dato2 = $dato2;	
			$array[$cnt]->dato3 = $dato3;	
			$array[$cnt]->dato4= $dato4;	
			$array[$cnt]->ref_ban = trim($r['ref_ban']);
			$array[$cnt]->dato5= $r['co_cli'];		
			$array[$cnt]->dato6= $r['cli_des'];		
			$cnt++;
			
		}
		return $array;
		}else{
				$array = array();
			
				return $array;
		}	

	}
	
	public static function getDataRenglonPagos($status,$filtro){
		//echo $filtro;
		$sql=" 
			SELECT jm_reportar_pago.cob_num,
			MIN(jm_reportar_pago_reg.nro_doc) AS nro_doc,
			MIN(jm_reportar_pago_reg.forma_pag) AS forma_pag,
			MIN(jm_reportar_pago_reg.ref_ban) AS ref_ban,
			MIN(jm_reportar_pago_reg.fec_tran) AS fec_tran, 
			MAX(jm_reportar_pago_reg.monto) AS monto,    
				MAX(jm_reportar_pago_reg.monto_bs) AS monto_bs_total,				
				MIN(jm_reportar_pago_reg.tipo_doc) AS tipo_doc
				FROM jm_reportar_pago_reg 
				inner join jm_reportar_pago
					on jm_reportar_pago.cob_num = jm_reportar_pago_reg.cob_num 
					WHERE jm_reportar_pago.nro_docs_grup LIKE '$filtro' GROUP BY jm_reportar_pago.cob_num;";

		//$sql = "SELECT id,forma_pag,monto,fec_tran ,tasa, monto, monto_bs FROM jm_reportar_pago_reg rp WHERE rp.nro_doc='$nun_doc'";
		//echo $sql;
		$query = Executor::doitAr($sql);	
		
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {				
			
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->id = $filtro;		
			$array[$cnt]->forma_pag = $r['forma_pag'];		
			$array[$cnt]->fec_tran = $r['fec_tran'];	
			$array[$cnt]->monto =$r['monto'];
			$array[$cnt]->ref_ban = $r['ref_ban'];			
			$array[$cnt]->monto_bs = $r['monto_bs_total'];
			$cnt++;
			
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}	

	}

	public static function getAllCuentasPagoRegistrados($filtro){
		/// Metodo para consultar el total de cuenas por cobrar	
		$co_ven =$_SESSION['identidad'];
		$co_sucu=$_SESSION['co_alma'];

		$sql=" 
			SELECT jm_reportar_pago.cob_num,
			MIN(jm_reportar_pago_reg.nro_doc) AS nro_doc,
			MIN(jm_reportar_pago_reg.forma_pag) AS forma_pag,
			MIN(jm_reportar_pago_reg.ref_ban) AS ref_ban,
			MIN(jm_reportar_pago_reg.fec_tran) AS fec_tran, 
			MAX(jm_reportar_pago_reg.monto) AS monto,    
			MAX(jm_reportar_pago_reg.monto_bs) AS monto_bs_total,				
			MIN(jm_reportar_pago_reg.tipo_doc) AS tipo_doc
			FROM jm_reportar_pago_reg 
			inner join jm_reportar_pago
			on jm_reportar_pago.cob_num = jm_reportar_pago_reg.cob_num 
			WHERE jm_reportar_pago.nro_docs_grup LIKE '$filtro' AND jm_reportar_pago.co_ven = '$co_ven' 
			GROUP BY jm_reportar_pago.cob_num;";
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		$total_acumulado  = 0.00;
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {			
			$total_acumulado = $total_acumulado+$r['monto'];			
		}
		
		$array[0]->total_acumulado= $total_acumulado;	
		return $array;
		}else{
				$array = array();
					$array[0]->total_acumulado= '0.00';	
				return $array;
		}
		
	}


		
public  function getDataIndicadorVentasxPeriodo($co_ven,$co_zona,$finicio,$ffinal,$indicador){

	if(($finicio=='NO') && ($ffinal=='NO')){
			$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];


			

				$sql ="SELECT
					ROUND(SUM(CASE WHEN src = 'factura' THEN tot_neto/tasa ELSE 0 END), 2) AS monto_facturado,
					ROUND(SUM(CASE WHEN src = 'devolucion' THEN tot_neto/tasa ELSE 0 END), 2) AS monto_devolucion,
					SUM(CASE WHEN src = 'factura' THEN 1 ELSE 0 END) AS tickets_factura,
					SUM(CASE WHEN src = 'devolucion' THEN 1 ELSE 0 END) AS tickets_devolucion,
					COUNT(DISTINCT CASE WHEN src = 'factura' THEN co_cli END) AS clientes_factura,
					COUNT(DISTINCT CASE WHEN src = 'devolucion' THEN co_cli END) AS clientes_devolucion
				FROM (
						SELECT 'factura' AS src, (tot_bruto - glob_desc) as tot_neto, tasa, co_cli
					FROM factura
					WHERE MONTH(fec_emis) =$mes  AND YEAR(fec_emis) = $anio 
						AND co_ven = '$co_ven' AND anulada = 0
					UNION ALL
						SELECT 'devolucion' AS src, (tot_bruto - glob_desc) as tot_neto, tasa, co_cli
					FROM dev_cli
					WHERE MONTH(fec_emis) = $mes AND YEAR(fec_emis) = $anio 
						AND co_ven = '$co_ven' AND anulada = 0
				) t;";

				

					
				$imes =$mes;
			$ianio=$anio;

	}
	if(($finicio=='SI') && ($ffinal=='NO')){

	
				$hoy = getdate();
				$mes1 = $hoy['mon'];
				$anio = $hoy['year'];
				$mes=$mes1-1;


					$sql ="SELECT
					ROUND(SUM(CASE WHEN src = 'factura' THEN tot_neto/tasa ELSE 0 END), 2) AS monto_facturado,
					ROUND(SUM(CASE WHEN src = 'devolucion' THEN tot_neto/tasa ELSE 0 END), 2) AS monto_devolucion,
					SUM(CASE WHEN src = 'factura' THEN 1 ELSE 0 END) AS tickets_factura,
					SUM(CASE WHEN src = 'devolucion' THEN 1 ELSE 0 END) AS tickets_devolucion,
					COUNT(DISTINCT CASE WHEN src = 'factura' THEN co_cli END) AS clientes_factura,
					COUNT(DISTINCT CASE WHEN src = 'devolucion' THEN co_cli END) AS clientes_devolucion
				FROM (
					SELECT 'factura' AS src, (tot_bruto - glob_desc) as tot_neto, tasa, co_cli
					FROM factura
					WHERE MONTH(fec_emis) =$mes  AND YEAR(fec_emis) = $anio 
						AND co_ven = '$co_ven' AND anulada = 0
					UNION ALL
				SELECT 'devolucion' AS src, (tot_bruto - glob_desc) as tot_neto, tasa, co_cli
					FROM dev_cli
					WHERE MONTH(fec_emis) = $mes AND YEAR(fec_emis) = $anio 
						AND co_ven = '$co_ven' AND anulada = 0
				) t;";

		/*
				$sql="SELECT 
						ROUND(SUM(f.tot_bruto/f.tasa), 2) AS monto_facturado, 
						COUNT(*) AS numero_tickets,
						COUNT(DISTINCT f.co_cli) AS numero_clientes
					FROM factura f				
					WHERE MONTH(f.fec_emis) = $mes 
					AND YEAR(f.fec_emis) = $anio 	
					AND f.co_ven = '$co_ven' 
					AND f.anulada = 0;";*/

												
			$imes =$mes;
			$ianio=$anio;
				

	}

	if(($finicio=='NO') && ($ffinal=='SI')){

	
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio1 = $hoy['year'];
				$anio=$anio1-1;

					$sql ="SELECT
					ROUND(SUM(CASE WHEN src = 'factura' THEN tot_neto/tasa ELSE 0 END), 2) AS monto_facturado,
					ROUND(SUM(CASE WHEN src = 'devolucion' THEN tot_neto/tasa ELSE 0 END), 2) AS monto_devolucion,
					SUM(CASE WHEN src = 'factura' THEN 1 ELSE 0 END) AS tickets_factura,
					SUM(CASE WHEN src = 'devolucion' THEN 1 ELSE 0 END) AS tickets_devolucion,
					COUNT(DISTINCT CASE WHEN src = 'factura' THEN co_cli END) AS clientes_factura,
					COUNT(DISTINCT CASE WHEN src = 'devolucion' THEN co_cli END) AS clientes_devolucion
				FROM (
					SELECT 'factura' AS src, tot_neto, tasa, co_cli
					FROM factura
					WHERE MONTH(fec_emis) =$mes  AND YEAR(fec_emis) = $anio 
						AND co_ven = '$co_ven' AND anulada = 0
					UNION ALL
					SELECT 'devolucion' AS src, tot_neto, tasa, co_cli
					FROM dev_cli
					WHERE MONTH(fec_emis) = $mes AND YEAR(fec_emis) = $anio 
						AND co_ven = '$co_ven' AND anulada = 0
				) t;";


				/*$sql="SELECT 
						ROUND(SUM(f.tot_bruto/f.tasa), 2) AS monto_facturado, 
						COUNT(*) AS numero_tickets,
						COUNT(DISTINCT f.co_cli) AS numero_clientes
					FROM factura f				
					WHERE MONTH(f.fec_emis) = $mes 
					AND YEAR(f.fec_emis) = $anio 	
					AND f.co_ven = '$co_ven' 
					AND f.anulada = 0;";*/

					
				$imes =$mes1;
			$ianio=$anio-1;
			
				

	}
					

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData();		
			$data1=$this->dataIndicadores($co_ven,$indicador,$imes,$ianio);
				

			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->dato1 = ((float)$r['monto_facturado'])-((float)$r['monto_devolucion']);
			//$array[$cnt]->dato2 = (float)$r['numero_tickets'];
			//$array[$cnt]->dato3 = (float)$r['numero_clientes'];
			$array[$cnt]->dato4 =  (float)$data1[0]->dato1;
			$array[$cnt]->dato5 = ((float)$r['monto_facturado'])-((float)$r['monto_devolucion']);
			
			$cnt++;
		}
		return $array;
		}else{	$cnt = 0;	
				$array = array();
				$array[$cnt] = new FacturaData();		
					$data1=$this->dataIndicadores($co_ven,$indicador,$imes,$ianio);
				
				$array[$cnt]->dato1 =0.00;
				$array[$cnt]->dato2 =0;
				$array[$cnt]->dato3 =0;
				$array[$cnt]->dato4 = (float)$data1[0]->dato1;
				return $array;
		}

}


public function getMetasIndicadoresZonas($co_ven, $co_zona, $finicio, $ffinal, $indicador) {
    
    if(($finicio=='NO') && ($ffinal=='NO')){
        // Período actual (mes actual)
        $hoy = getdate();
        $mes = $hoy['mon'];
        $anio = $hoy['year'];
        
        // Construir fechas para el BETWEEN
        $fecha_inicio = $anio . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-01';
        $fecha_fin = $anio . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . date('t', strtotime($fecha_inicio));
        
        $periodo_ref = $mes;
        $anio_ref = $anio;
    }
    
    if(($finicio=='SI') && ($ffinal=='NO')){
        // Período anterior (mes anterior)
        $hoy = getdate();
        $mes = $hoy['mon'] - 1;
        $anio = $hoy['year'];
        
        if($mes == 0) {
            $mes = 12;
            $anio = $anio - 1;
        }
        
        $fecha_inicio = $anio . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-01';
        $fecha_fin = $anio . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . date('t', strtotime($fecha_inicio));
        
        $periodo_ref = $mes;
        $anio_ref = $anio;
    }
    
    if(($finicio=='NO') && ($ffinal=='SI')){
        // Mismo mes del año anterior
        $hoy = getdate();
        $mes = $hoy['mon'];
        $anio = $hoy['year'] - 1;
        
        $fecha_inicio = $anio . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-01';
        $fecha_fin = $anio . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . date('t', strtotime($fecha_inicio));
        
        $periodo_ref = $mes;
        $anio_ref = $anio;
    }
    
    // Construir la consulta SQL
    $sql = "SELECT
                z.co_zon,
                z.zon_des,
                ROUND(SUM(CASE WHEN t.src = 'factura' THEN t.tot_neto/t.tasa ELSE 0 END), 2) AS monto_facturado,
                ROUND(SUM(CASE WHEN t.src = 'devolucion' THEN t.tot_neto/t.tasa ELSE 0 END), 2) AS monto_devolucion,
                SUM(CASE WHEN t.src = 'factura' THEN 1 ELSE 0 END) AS tickets_factura,
                SUM(CASE WHEN t.src = 'devolucion' THEN 1 ELSE 0 END) AS tickets_devolucion,
                COUNT(DISTINCT CASE WHEN t.src = 'factura' THEN t.co_cli END) AS clientes_factura,
                COUNT(DISTINCT CASE WHEN t.src = 'devolucion' THEN t.co_cli END) AS clientes_devolucion,
                (SELECT COUNT(DISTINCT co_cli) FROM factura 
                 WHERE MONTH(fec_emis) = $periodo_ref AND YEAR(fec_emis) = $anio_ref 
                 AND co_ven = '$co_ven' AND anulada = 0) AS total_clientes_periodo
            FROM (
                SELECT 'factura' AS src, (tot_bruto - glob_desc) as tot_neto, tasa, co_cli, co_ven
                FROM factura
                WHERE fec_emis BETWEEN '$fecha_inicio' AND '$fecha_fin'
                    AND anulada = 0";
    
    // Agregar filtro de vendedor si no es 'todos'
    if($co_ven != 'todos' && !empty($co_ven)) {
        $sql .= " AND co_ven = '$co_ven'";
    }
    
    $sql .= " UNION ALL
                SELECT 'devolucion' AS src, (tot_bruto - glob_desc) as tot_neto, tasa, co_cli, co_ven
                FROM dev_cli
                WHERE fec_emis BETWEEN '$fecha_inicio' AND '$fecha_fin'
                    AND anulada = 0";
    
    if($co_ven != 'todos' && !empty($co_ven)) {
        $sql .= " AND co_ven = '$co_ven'";
    }
    
    $sql .= ") t
            INNER JOIN clientes c ON c.co_cli = t.co_cli
            INNER JOIN zona z ON z.co_zon = c.co_zon
            WHERE z.co_zon IS NOT NULL ";
    
  /*  // Agregar filtro de zona si no es 'todos'
    if($co_zona != 'todos' && !empty($co_zona)) {
        $sql .= " AND z.co_zon = '$co_zona'";
    }
    */
    $sql .= " GROUP BY z.co_zon, z.zon_des 
              ORDER BY monto_facturado DESC";
    
    //echo $sql; // Para debugging
    $query = Executor::doitAr($sql);
    $e = count($query);
    
    if($e >= 1) {
        $array = array();
        $cnt = 0;
    
        foreach($query as $r) {
            $array[$cnt] = new FacturaData();
            
          
            
            $array[$cnt]->responsive_id = "";
            $array[$cnt]->co_zon = $r['co_zon'];
            $array[$cnt]->zon_des = $r['zon_des'];
            $array[$cnt]->monto_facturado = ((float)$r['monto_facturado']) - ((float)$r['monto_devolucion']);
            $array[$cnt]->tickets_factura = (int)$r['tickets_factura'];
            $array[$cnt]->tickets_devolucion = (int)$r['tickets_devolucion'];
            $array[$cnt]->clientes_factura = (int)$r['clientes_factura'];
            $array[$cnt]->clientes_devolucion = (int)$r['clientes_devolucion'];
            $array[$cnt]->total_clientes_periodo = (int)$r['total_clientes_periodo'];
          
            $cnt++;
        }
        return $array;
    } else {
        // Si no hay resultados, retornar array vacío pero con estructura
        return array();
    }
}



public  function totalClientesIndicadores($co_ven,$mes,$anio){		
		
		$hoy = getdate();
		$mes1 = $hoy['mon'];
		$anio = $hoy['year'];
		$mes=$mes1-1;

			$fecha = new DateTime("$anio-$mes-01");
		$ultimoDia = $fecha->format('t');

		$sql ="	SELECT COUNT(*) as total_clientes 
		FROM clientes  c
		WHERE inactivo = 0 
		and c.co_ven = '$co_ven'
		AND  YEAR(c.fecha_reg) <= $anio
		AND ( YEAR(c.fecha_reg) < $anio OR ( YEAR(c.fecha_reg) = $anio 	AND MONTH(c.fecha_reg) < $mes)
					OR (
						YEAR(c.fecha_reg) = $anio
						AND MONTH(c.fecha_reg) =  $mes 
						AND DAY(c.fecha_reg) <= $ultimoDia-1
					)) and c.tipo_adi in (1,2)";


		// validaciones del pedido
		
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->total_clientes = $r['total_clientes'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
				$cnt = 0;	
				$array[$cnt]->total_clientes =0;
			
			return $array;

		}
}





public  function dataIndicadores($co_ven,$indicador,$imes,$ianio){		
		
	
		

		$sql ="SELECT 
		valor as dato1 
		FROM jm_parametro 
		WHERE co_ven = '$co_ven' and co_type='$indicador' AND  MONTH(finicio) = $imes 
					AND YEAR(ffinal) = $ianio";


		// validaciones del pedido
		
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {		
				$array[$cnt] = new FacturaData();		
				$array[$cnt]->dato1 = $r['dato1'];		
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
				$cnt = 0;	
				$array[$cnt] = new FacturaData();		
				$array[$cnt]->total_clientes =0;
			
			return $array;

		}
}

public  function getDataIndicadorClientesFacturados($co_ven,$co_zona,$finicio,$ffinal,$indicador){



	if(($finicio=='NO') && ($ffinal=='NO')){
			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="WITH grupos AS (
					SELECT 
						c.co_cli,
						c.cli_des,
						c.tipo_adi,
						c.matriz,
						CASE 
							WHEN c.tipo_adi = 3 
								AND c.matriz IS NOT NULL 
								AND LTRIM(RTRIM(c.matriz)) <> '' 
								THEN LTRIM(RTRIM(c.matriz))
							ELSE c.co_cli
						END AS group_id
					FROM clientes c
				),
				facturacion AS (
					SELECT 
						g.group_id
					FROM factura f
					JOIN reng_fac r ON f.fact_num = r.fact_num
					JOIN grupos g   ON f.co_cli = g.co_cli
					WHERE f.anulada = 0
							AND YEAR(f.fec_emis) = $anio
										AND MONTH(f.fec_emis) = $mes1
					AND ('$co_ven' IS NULL OR f.co_ven = '$co_ven')
					GROUP BY g.group_id
				)

				SELECT COUNT(*) AS total_clientes_activados
				FROM facturacion;";

			
	}
	if(($finicio=='SI') && ($ffinal=='NO')){

	
					$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
				$sql="WITH grupos AS (
					SELECT 
						c.co_cli,
						c.cli_des,
						c.tipo_adi,
						c.matriz,
						CASE 
							WHEN c.tipo_adi = 3 
								AND c.matriz IS NOT NULL 
								AND LTRIM(RTRIM(c.matriz)) <> '' 
								THEN LTRIM(RTRIM(c.matriz))
							ELSE c.co_cli
						END AS group_id
					FROM clientes c
				),
				facturacion AS (
					SELECT 
						g.group_id
					FROM factura f
					JOIN reng_fac r ON f.fact_num = r.fact_num
					JOIN grupos g   ON f.co_cli = g.co_cli
					WHERE f.anulada = 0
							AND YEAR(f.fec_emis) = $anio
										AND MONTH(f.fec_emis) = $mes
					AND ('$co_ven' IS NULL OR f.co_ven = '$co_ven')
					GROUP BY g.group_id
				)

				SELECT COUNT(*) AS total_clientes_activados
				FROM facturacion;";
									
			$imes =$mes;
			$ianio=$anio;
			

	}

	if(($finicio=='NO') && ($ffinal=='SI')){

	
			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="SELECT COUNT(*) AS total_clientes_activados
			FROM clientes c
			INNER JOIN zona z ON c.co_zon = z.co_zon
			WHERE 
				c.co_ven = '$co_ven'
				AND c.inactivo = 0
				AND YEAR(c.fecha_reg) <= $anio
				AND (YEAR(c.fecha_reg) < $anio OR MONTH(c.fecha_reg) <= $mes)
				AND EXISTS (
					SELECT 1
					FROM factura f
					WHERE 
						f.co_cli = c.co_cli
						AND YEAR(f.fec_emis) = $anio-1
						AND MONTH(f.fec_emis) = $mes1
						AND f.anulada = 0
				);";

				$imes =$mes1;
			$ianio=$anio-1;
			
	}

	
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
				$array[$cnt] = new FacturaData();		
			$data1=$this->totalClientesIndicadores($co_ven,$indicador,'0');
				
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->dato1 = (float)$r['total_clientes_activados'];
			$array[$cnt]->dato2 = (float)$data1[0]->total_clientes;
		//	$array[$cnt]->dato3 = (float)$r['numero_clientes'];
			//$array[$cnt]->dato4 = (float)$r['meta'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				$cnt = 0;	
				$array[$cnt] = new FacturaData();		
			$data1=$this->totalClientesIndicadores($co_ven,$indicador,'0');
				
				$array[$cnt]->dato1 =0;
				$array[$cnt]->dato2 =(float)$data1[0]->total_clientes;
				return $array;
		}

}

public  function getDataIndicadorCobranzasMes($co_ven,$co_zona,$finicio,$ffinal,$indicador){



	if(($finicio=='NO') && ($ffinal=='NO')){
				$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="
			select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cob)=$mes1  and YEAR(fec_cob) = $anio and anulado = 0 and c.co_ven = '$co_ven'";

			$imes =$mes1;
			$ianio=$anio;



	}
	if(($finicio=='SI') && ($ffinal=='NO')){

	
				$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="
			select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cob)=$mes  and YEAR(fec_cob) = $anio and anulado = 0 and c.co_ven = '$co_ven'";

						
			$imes =$mes;
			$ianio=$anio;

	}

	if(($finicio=='NO') && ($ffinal=='SI')){

			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="
			select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cob)=$mes  and YEAR(fec_cob) = $anio-1 and anulado = 0 and c.co_ven = '$co_ven'";

			$imes =$mes1;
			$ianio=$anio-1;
	}

	

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
				$array[$cnt] = new FacturaData();		
			$data1=$this->dataIndicadores($co_ven,$indicador,$imes,$ianio);
				
			$array[$cnt]->dato1 = (float)$r['cobranza_mes'];
			$array[$cnt]->dato2 = (float)$data1[0]->dato1;
			$array[$cnt]->dato3 =  (float)$r['cobranza_mes'];
			$cnt++;
		}
		return $array;

		}else{	$cnt = 0;	
				$array = array();
				$array[$cnt] = new FacturaData();		
			$data1=$this->dataIndicadores($co_ven,$indicador,$imes,$ianio);
				
				$array[$cnt]->dato1 =0.00;			
				$array[$cnt]->dato2 =(float)$data1[0]->dato1;
		return $array;
		}

}


public  function getDataIndicadorClientesNuevos($co_ven,$co_zona,$finicio,$ffinal,$indicador){

		if(($finicio=='NO') && ($ffinal=='NO')){
			$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;



			$sql=";WITH grupos_que_compran AS (
				SELECT DISTINCT
					group_id,
					fecha_reg_grupo
				FROM vw_clientes_grupo_fact_total
				WHERE YEAR( fec_emis) = $anio
				AND  MONTH( fec_emis) = $mes1   
				AND ( '$co_ven' IS NULL OR co_ven = '$co_ven')
			)
			SELECT COUNT(*) AS total_clientes_nuevos
			FROM grupos_que_compran 
			WHERE YEAR( fecha_reg_grupo ) = $anio	
			AND  MONTH( fecha_reg_grupo ) = $mes1";	

			
		
					
					
			$imes =$mes1;
			$ianio=$anio;


	}
	if(($finicio=='SI') && ($ffinal=='NO')){

	
				$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql=";WITH grupos_que_compran AS (
				SELECT DISTINCT
					group_id,
					fecha_reg_grupo
				FROM vw_clientes_grupo_fact_total
				WHERE YEAR( fec_emis) = $anio
				AND  MONTH( fec_emis) = $mes   
				AND ( '$co_ven' IS NULL OR co_ven = '$co_ven')
			)
			SELECT COUNT(*) AS total_clientes_nuevos
			FROM grupos_que_compran 
			WHERE YEAR( fecha_reg_grupo ) = $anio	
			AND  MONTH( fecha_reg_grupo ) = $mes";	

			
					
			$imes =$mes;
			$ianio=$anio;

	}

	if(($finicio=='NO') && ($ffinal=='SI')){
			
		$hoy = getdate();
			$mes1 = $hoy['mon'];
			$anio = $hoy['year'];
			$mes=$mes1-1;
			
			$sql="
			SELECT count(DISTINCT c.co_cli) as total_clientes_nuevos
				FROM factura f
				INNER JOIN clientes c ON f.co_cli = c.co_cli
				INNER JOIN zona z ON c.co_zon = z.co_zon			
				WHERE
					YEAR( f.fec_emis) = $anio-1
					AND  MONTH( f.fec_emis) = $mes1   
					AND f.anulada = 0
					AND c.co_ven = '$co_ven'
					AND c.inactivo = 0
					AND YEAR( c.fecha_reg ) = $anio-1
					AND  MONTH( c.fecha_reg ) = $mes1";
					
			$imes =$mes1;
			$ianio=$anio-1;

	}

	

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData();		
			$data1=$this->dataIndicadores($co_ven,$indicador,$imes,$ianio);
				
			$array[$cnt]->dato1 = (float)$r['total_clientes_nuevos'];
			$array[$cnt]->dato2 = (float)$data1[0]->dato1;
			$cnt++;
		}
		return $array;
		}else{	$cnt = 0;	
					
			
				$array = array();
					$array[$cnt] = new FacturaData();		
					$data1=$this->dataIndicadores($co_ven,$indicador,$imes,$ianio);
				$array[$cnt]->dato1 =0;
					$array[$cnt]->dato2 = (float)$data1[0]->dato1;
				return $array;
		}

}


public static function getDataTasaDia($fecha) {
    // Ajustar la fecha si es fin de semana
    $fechaAjustada = self::ajustarFechaFinDeSemana($fecha);
    
    $sql = "SELECT tasa_v FROM tasas WHERE CAST(fecha AS DATE)='$fechaAjustada' AND co_mone='US$'";
    
    $query = Executor::doitAr($sql);
    $e = count($query);
    
    if($e >= 1) {
        $array = array();
        $cnt = 0;    
        foreach($query as $r) {        
            $array[$cnt] = new FacturaData();        
            $array[$cnt]->tasa_v = number_format($r['tasa_v'], 2, ',', '.');
			$array[$cnt]->tasa_r = $r['tasa_v'];
            $cnt++;
        }
        return $array;
    } else {
        $array = array();
        $cnt = 0;    
        $array[$cnt] = new FacturaData();        
        $array[$cnt]->tasa_v = 0;
        return $array;
    }
}

public static function ajustarFechaFinDeSemana($fecha) {
    // Convertir la fecha a un objeto DateTime
    $fechaObj = new DateTime($fecha);
    
    // Obtener el día de la semana (0 para domingo, 6 para sábado)
    $diaSemana = $fechaObj->format('w');
    
    // Ajustar la fecha si es fin de semana
    if ($diaSemana == 0) { // Domingo
        $fechaObj->modify('-2 days');
    } elseif ($diaSemana == 6) { // Sábado
        $fechaObj->modify('-1 day');
    }
    
    // Devolver la fecha ajustada en formato Y-m-d
    return $fechaObj->format('Y-m-d');
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

	
	public static function GetRenglonFacturaDespacho($fact_num){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		
		$co_sucu=$_SESSION['co_alma'];
		$sql = "SELECT a.co_art AS co_art,
		a.modelo AS marca,
		sum(pg.total_art) AS cantidad,
		a.art_des,
		a.prec_vta1,
		a.ref from reng_fac pg 
		INNER JOIN factura p on p.fact_num=pg.fact_num 
		INNER JOIN art a ON pg.co_art=a.co_art 
		INNER JOIN vendedor v on p.co_ven=v.co_ven 
		WHERE pg.fact_num='".$fact_num."'
		GROUP BY a.co_art,
		a.prec_vta1,
		a.art_des,
		pg.total_art,
		a.ref, a.modelo ORDER BY a.art_des ASC";

			/*	$sql ="SELECT  a.co_art AS co_art,c.des_col AS marca, pg.total_art AS cantidad,a.art_des,a.prec_vta1,a.ref from reng_fac pg
		INNER JOIN factura p on p.fact_num = pg.fact_num 
		INNER JOIN almacen ar on p.co_sucu = ar.co_alma 
		INNER JOIN art a ON pg.co_art = a.co_art 
		INNER JOIN colores c ON a.co_color = c.co_col 
		INNER JOIN vendedor v on p.co_ven = v.co_ven
		WHERE pg.fact_num='".$fact_num."' AND p.co_sucu = '".$co_sucu."' 
		GROUP BY a.co_art,a.prec_vta1,a.art_des,pg.total_art,c.des_col,a.ref 
		ORDER BY a.art_des ASC";*/

		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_art = trim($r['co_art']);				
			$array[$cnt]->barcode = trim($r['ref']);
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato4 = trim($r['marca']);	
			$array[$cnt]->dato2 = (float)$r['cantidad'];
			$array[$cnt]->dato3 = (float)$r['prec_vta1'];			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}

	
	public static function getInformacionFacturaRenglones($fact_num){
		/// Metodo para consultar todos los datos y mostrar las tablas    
		
	   
		$sql = "SELECT a.co_art AS co_art,
		a.modelo AS marca,
		sum(pg.total_art) AS cantidad,
		a.art_des,
		a.prec_vta1,
		a.ref from reng_fac pg 
		INNER JOIN factura p on p.fact_num=pg.fact_num 
		INNER JOIN art a ON pg.co_art=a.co_art 
		INNER JOIN vendedor v on p.co_ven=v.co_ven 
		WHERE pg.fact_num='".$fact_num."'
		GROUP BY a.co_art,
		a.prec_vta1,
		a.art_des,
		pg.total_art,
		a.ref, a.modelo ORDER BY a.art_des ASC";
	
		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = ""; 		
			$array[$cnt]->co_art = trim($r['co_art']);				
			$array[$cnt]->barcode = trim($r['ref']);
			$array[$cnt]->dato1 = trim($r['art_des']);	
			$array[$cnt]->dato4 = trim($r['marca']);	
			$array[$cnt]->dato2 = (float)$r['cantidad'];
			$array[$cnt]->dato3 = (float)$r['prec_vta1'];			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}



		public static function getAllDatosFacturacion($ano,$mes,$co_ven){
			// validaciones del pedido
	
			
				$hoy = getdate();
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
	
			$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc		
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$ano'
			AND tipo_doc = 'FACT' AND anulado = 0";
			//echo $sql;

		
			//echo "<br>";	
			//echo $sql;	
				$query = Executor::doitAr($sql);
				$e=count($query);
				if($e>=1){

					$array = array();
					$cnt = 0;	
					foreach($query as $r) {			
						
						$array[$cnt] = new FacturaData();  				
						$array[$cnt]->dato1 = (float)$r['monto'];
					$cnt++;
					}
					//var_dump($array);
					
					return $array;

				}else{

					$array = array();
					return $array;

				}
		}

		public static function getByNumFactura($fact_num){
			/// Metodo para consultar todos los datos y mostrar las tablas	
			$sql = "select f.forma_pag, c.dias_cred from factura  f inner join condicio c on c.co_cond = f.forma_pag  where f. fact_num = '$fact_num'";
			
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->forma_pag = trim($r['forma_pag']);	
				$array[$cnt]->dias_cred = (int)$r['dias_cred'];
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
		}


		
	public static function getDataFacturasCliente($co_cli, $filtro) {
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
			$array[$cnt]->dato2 = number_format($r['monto_net'], 2, ',', '.');
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


	

	public static function geDatatFacturasCliente($co_cli, $filtro) {
			$numero_retencion = 0;
			// Filtro de anulado (0 para no anulado, 1 para anulado)
			if($filtro == 'NO') {
				$filtro = 0; // 0 es para no anulado
			} else {
				$filtro = 1; // 1 es para anulado
			}
			$co_cli = $_SESSION['identidad'];		

			
			$sql = "SELECT 
					CAST(d.nro_doc AS VARCHAR) AS serie_fact_num,
					d.nro_doc,
					   CASE 
						WHEN d.tipo_doc IN ('N/CR', 'AJUSTE') THEN -(d.saldo/d.tasa)
						ELSE (d.saldo/d.tasa)
					END AS saldo,
					CASE 
						WHEN d.tipo_doc IN ('N/CR', 'AJUSTE') THEN -(d.saldo/d.tasa)
						ELSE (d.saldo/d.tasa)
					END AS saldoBs,
					d.fec_emis,
					d.tipo_doc,
					(d.monto_net) AS monto_neto,
					c.cli_des as cli_des,
					c.co_cli as co_cli,
					d.fec_venc,
					c.contribu_e,
					d.monto_imp,
					d.tipo,
					c.porc_esp,
					
					ISNULL(p.monto_total, 0) as monto_transito,
					DATEDIFF(d, d.fec_emis, GETDATE()) AS dias,
					DATEDIFF(d, d.fec_venc, GETDATE()) as dias_vencida, 
					CASE WHEN d.campo6 = '<$>' THEN 1 ELSE 0 END as forma 
				FROM docum_cc d     
					INNER JOIN clientes c ON d.co_cli = c.co_cli
					LEFT JOIN (
						SELECT nro_doc, SUM(monto) as monto_total
						FROM jm_reportar_pago_reg 
						WHERE status = 1
						AND tipo_doc !='ADEL'
						GROUP BY nro_doc
					) p ON d.nro_doc = p.nro_doc
				WHERE 
					d.saldo > 0 
					AND d.anulado = $filtro  
					AND d.co_cli = '$co_cli'";

			

				$sql .= " ORDER BY d.fec_emis DESC";
			//echo $sql; // Para depuración, puedes comentar esta línea en producción 
			$query = Executor::doitAr($sql);    
			$e = count($query);        
			if($e >= 1) {
				$array = array();
				$cnt = 0;    
				$status = 0;
				foreach($query as $r) {

					
			  // --- INICIO DE LA MODIFICACIÓN ---
            
            // 1. Guardamos el número original de la base de datos.
            $numeroOriginal = $r['serie_fact_num'];
            $numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

            // 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
            // Usamos substr para obtener el primer carácter.
            if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal) ==8) {
                // Obtenemos el resto del número a partir del tercer carácter (índice 2).
                $restoDelNumero = substr($numeroOriginal, 2);
                // Construimos el nuevo número.
                $numeroFormateado = 'NF' . $restoDelNumero;
            }
            
            // --- FIN DE LA MODIFICACIÓN ---




					$objeto_pedido = New PedidoData();
				  	$objeto_funciones = New FuncionesData();
            		$data_retenciones = $objeto_funciones->getRetencionesFactura($r['nro_doc']);
					
					// MODIFICACIÓN AQUÍ: Manejar el caso cuando no hay retenciones
					if (!empty($data_retenciones) && isset($data_retenciones[0]->numero_retencion)) {
						$numero_retencion = $data_retenciones[0]->numero_retencion;
					} else {
						$numero_retencion = 0; // Valor por defecto cuando no hay retenciones
					}


					//echo $numero_retencion;
					$data = $objeto_pedido->tasa();
					$tasa = $data['tasa'];    
					$tasa = round((float)$tasa, 2); 
					//echo $tasa;

					$array[$cnt] = new FacturaData(); 
					$array[$cnt]->responsive_id = "";         
					$array[$cnt]->nro_doc = $r['nro_doc'];    
					$array[$cnt]->serie_fact_num = $numeroFormateado;    
					$array[$cnt]->saldo = round((float)$r['saldo'], 2);    
					
					$array[$cnt]->saldo2 = round((float)$r['saldo'], 2);    
					$array[$cnt]->saldo3 = round((float)($r['saldoBs'] * $tasa), 2);    
					$array[$cnt]->fec_emis = substr($r['fec_emis'], 0, 10);  // abcd ;    
					$array[$cnt]->fec_venc = substr($r['fec_venc'], 0, 10);  // abcd ;    
					$array[$cnt]->tipo_doc = $r['tipo_doc'];    
					$array[$cnt]->monto_transito =round((float)$r['monto_transito'], 2);   
					$array[$cnt]->dato2 = number_format(round((float)$r['monto_neto'], 2), 2, '.', ',+');
					$array[$cnt]->dato1 = round((float)'0', 2);                
					$array[$cnt]->dato3 = $r['dias'];    
					$array[$cnt]->dato4 = $r['dias_vencida'];    
					$array[$cnt]->dato6 = $r['forma'];
					$array[$cnt]->dato7 = $r['contribu_e'];    
					$array[$cnt]->dato8 = $r['porc_esp']; 
					$array[$cnt]->dato9 = $r['tipo'];
					$array[$cnt]->dato10 = $r['monto_imp'];
					$array[$cnt]->dato11 = $numero_retencion; 


					$array[$cnt]->cli_des = trim($r['cli_des']);
					$array[$cnt]->co_cli = trim($r['co_cli']);
					$array[$cnt]->tasa = number_format($tasa, 2, ',', '.');        
					
					$cnt++;
				}
				return $array;
			} else {
				$array = array();
				return $array;
			}
	}



public static function getDataFacturas($mesParametro) {
   		 // 1. Obtenemos el año actual
    $hoy = getdate();
    $anio = $hoy['year'];

    // 2. Determinamos qué mes consultar
    $mes_a_consultar = '';
    if (strtolower($mesParametro) === 'no') {
        $mes_a_consultar = $hoy['mon'];
    } else {
        $mes_num = intval($mesParametro);
        if ($mes_num >= 1 && $mes_num <= 12) {
            $mes_a_consultar = $mes_num;
        } else {
            return array();
        }
    }

    // 3. Construimos la consulta SQL con todos los campos necesarios
    $sql = "
        SELECT
            -- Identificadores
            c.fact_num AS factura_id,
            
            -- Número de factura formateado (para mostrar con NF si es necesario)
            CAST(c.fact_num AS VARCHAR) AS fact_num_original,
            CASE 
                WHEN LEFT(CAST(c.fact_num AS VARCHAR), 1) = '5' 
                    AND c.fact_num != 5 
                    AND LEN(CAST(c.fact_num AS VARCHAR)) = 8 
                THEN 'NF' + SUBSTRING(CAST(c.fact_num AS VARCHAR), 3, LEN(CAST(c.fact_num AS VARCHAR)) - 2)
                ELSE CAST(c.fact_num AS VARCHAR)
            END AS serie_fact_num,
            
            -- Datos del cliente
            c.co_cli,
            cl.cli_des AS cli_des,
            cl.rif,
            c.contrib AS contribuyente_especial,
            
            -- Fechas
            c.fec_emis,
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_emis_format,
            c.fec_venc,
            CONVERT(VARCHAR, c.fec_venc, 103) AS fec_venc_format,
            DATEDIFF(day, GETDATE(), c.fec_venc) AS dias_vencimiento,
            
            -- Montos y saldos
            c.saldo,
            c.moneda,
            CASE 
                WHEN c.moneda = 'USD' THEN c.saldo
                ELSE 0
            END AS saldo_usd,
            CASE 
                WHEN c.moneda != 'USD' OR c.moneda IS NULL THEN c.saldo
                ELSE 0
            END AS saldo_bs,
            
            -- Totales
            c.tot_bruto,
            c.tot_neto,
            c.iva,
            c.tasa,
            
            -- Estados y flags
            c.anulada,
            c.status,
            c.campo1,
            c.campo2,
            c.campo3,
            c.campo4,
            c.campo5,
            c.campo6,
            
            -- Información de retenciones
            c.num_control,
            c.total_uc,
            c.total_cp,
            
            -- Indicadores calculados
            CASE 
                WHEN c.anulada = 1 THEN 'Anulada'
                WHEN c.saldo <= 0 THEN 'Pagada'
                WHEN c.fec_venc < GETDATE() THEN 'Vencida'
                WHEN DATEDIFF(day, GETDATE(), c.fec_venc) <= 5 THEN 'Por Vencer'
                ELSE 'Vigente'
            END AS estatus_texto,
            
            -- Para saber si aplica retención (contribuyente especial + IVA > 0 + saldo > 0 + no anulada)
            CASE 
                WHEN c.contrib = 1 AND c.iva > 0 AND c.saldo > 0 AND c.anulada = 0 THEN 1
                ELSE 0
            END AS aplica_retencion,
            
            -- Monto en tránsito (asumo que está en algún campo, si no, dejar en 0)
            0 AS monto_transito,
            
           
            -- Campos adicionales que puedan ser útiles
            c.forma_pag,
            c.co_ven,
            c.co_tran,
            c.num_control AS nro_control
            
        FROM 
            factura c 
			inner join clientes cl on c.co_cli = cl.co_cli
        WHERE 
            
            
             YEAR(c.fec_emis) = " . intval($anio) . " 
            AND c.anulada = '0'
		
        ORDER BY 
            c.fec_emis DESC
    ";

    //echo $sql; //Ejecutar consulta
    $query = Executor::doitAr($sql);

    if (count($query) >= 1) {
        $array = array();
        $cnt = 0;

        foreach ($query as $r) {
            $array[$cnt] = new FacturaData();

            // Mapear todos los campos de la consulta al objeto
            $array[$cnt]->responsive_id = "";
            
            // Número de factura (formateado para mostrar)
            $array[$cnt]->fact_num = $r['serie_fact_num'];
            $array[$cnt]->fact_num_original = $r['fact_num_original'];
            
            // Datos del cliente
            $array[$cnt]->co_cli = $r['co_cli'];
            $array[$cnt]->cli_des = $r['cli_des'];
            $array[$cnt]->rif = $r['rif'];
            $array[$cnt]->contribuyente_especial = $r['contribuyente_especial'];
            
            // Fechas
            $array[$cnt]->fec_emis = $r['fec_emis'];
            $array[$cnt]->fec_emis_format = $r['fec_emis_format'];
            $array[$cnt]->fec_venc = $r['fec_venc'];
            $array[$cnt]->fec_venc_format = $r['fec_venc_format'];
            $array[$cnt]->dias_vencimiento = $r['dias_vencimiento'];
            
            // Saldos
            $array[$cnt]->saldo = $r['saldo'];
            $array[$cnt]->moneda = $r['moneda'];
            $array[$cnt]->saldo_usd = (float)$r['saldo_bs']/$r['tasa'];;
            $array[$cnt]->saldo_bs = $r['saldo_bs'];
            
            // Totales
            $array[$cnt]->tot_bruto = $r['tot_bruto'];
            $array[$cnt]->tot_neto = $r['tot_neto'];
            $array[$cnt]->iva = $r['iva'];
            $array[$cnt]->tasa = $r['tasa'];
            
            // Estados
            $array[$cnt]->anulada = $r['anulada'];
            $array[$cnt]->status = $r['status'];
            $array[$cnt]->estatus_texto = $r['estatus_texto'];
            
            // Campos auxiliares (para compatibilidad con código existente)
            $array[$cnt]->dato1 = $r['campo1'] ?? '';
            $array[$cnt]->dato2 = $r['campo2'] ?? '';
            $array[$cnt]->dato3 = $r['campo3'] ?? '';
            $array[$cnt]->dato4 = $r['campo4'] ?? '';
            $array[$cnt]->dato5 = $r['campo5'] ?? '';
            $array[$cnt]->dato6 = $r['campo6'] ?? '';
            $array[$cnt]->dato7 = ''; // Si necesitas más campos
            $array[$cnt]->dato8 = '';
            $array[$cnt]->dato9 = '';
            $array[$cnt]->dato10 = '';
            $array[$cnt]->dato11 = '';
            
            // Información de retenciones
            $array[$cnt]->aplica_retencion = $r['aplica_retencion'];
            $array[$cnt]->num_control = $r['num_control'];
            $array[$cnt]->monto_transito = $r['monto_transito'];
            
            // Datos adicionales
            $array[$cnt]->forma_pag = $r['forma_pag'];
            $array[$cnt]->co_ven = $r['co_ven'];
            $array[$cnt]->co_tran = $r['co_tran'];
            $array[$cnt]->nro_control = $r['nro_control'];

            $cnt++;
        }

        return $array;
    } else {
        return array();
    }
}


	public static function GetFacturaCliente($fact_num){
		/// Metodo para consultar todos los datos y mostrar las tablas		
		
		$co_sucu=$_SESSION['co_alma'];

		$sql ="SELECT p.fact_num, (p.saldo) as saldo, p.fec_emis,p.fec_venc, p.co_tran, p.forma_pag,
		(p.tot_bruto) as tot_bruto, (p.tot_neto) as tot_neto , (p.iva) as iva,
		 p.moneda, p.status, p.contrib,
		 c.cli_des,
		 c.email,
		 c.telefonos,
		 c.direc1,
		 c.rif,
		 t.des_tran,
		 v.ven_des,
		 v.co_ven,
		 p.tasa,
		 z.zon_des,
		 c.campo3,
		(p.glob_desc/p.tasa) as glob_desc
		 FROM factura p 
		INNER JOIN almacen a on p.co_sucu = a.co_alma 
		INNER JOIN clientes c on p.co_cli = c.co_cli 
		INNER JOIN vendedor v on p.co_ven = v.co_ven 
		INNER JOIN zona z on c.co_zon = z.co_zon
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
			$array[$cnt] = new FacturaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->fact_num = $r['fact_num'];
			$array[$cnt]->saldo = $r['saldo'];			
			$array[$cnt]->descuento_global = floatval($r['glob_desc'] ?? 0);
			$array[$cnt]->fec_emis =$r['fec_emis'];  // abcd ;	
			$array[$cnt]->fec_venc =$r['fec_venc'];  // abcd ;				
			$array[$cnt]->cli_des = trim($r['cli_des']);			
			$array[$cnt]->rif = trim($r['rif']);	
			$array[$cnt]->email = trim($r['campo3']);	
			$array[$cnt]->zon_des = trim($r['zon_des']);

			$array[$cnt]->des_tran = trim($r['des_tran']);	

			$array[$cnt]->telefonos = trim($r['telefonos']);	
			$array[$cnt]->direc1 = trim($r['direc1']);		
			$array[$cnt]->ven_des = trim($r['ven_des']);		
			$array[$cnt]->co_ven = trim($r['co_ven']);				
			$array[$cnt]->forma_pag = trim($r['forma_pag']);	
			$array[$cnt]->tasa = trim($r['tasa']);	
			$array[$cnt]->tot_bruto = floatval($r['tot_bruto']);			
			$array[$cnt]->tot_neto = floatval($r['tot_neto']);	
			$array[$cnt]->iva = floatval($r['iva']);	
			$array[$cnt]->status = $r['status'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}
	
	public static function GetRenglonFacturaCliente($fact_num){
		$co_sucu = $_SESSION['co_alma'];
		
		// Ajusté la query: 
		// 1. Agregué a.tipo_imp al SELECT
		// 2. Corregí el GROUP BY para que sea por artículo, sumando las cantidades correctamente.
		$sql = "SELECT 
					a.co_art AS co_art,
					a.modelo AS marca,
					SUM(pg.total_art) AS cantidad,
					a.art_des,
					pg.prec_vta2 as prec_vta1,
					pg.tipo_imp, 
					a.ref ,c.des_col,
					pg.porc_desc as descuento
				FROM reng_fac pg 
				INNER JOIN factura p on p.fact_num=pg.fact_num 
				INNER JOIN art a ON pg.co_art=a.co_art 
				INNER JOIN vendedor v on p.co_ven=v.co_ven 
				INNER JOIN colores c on c.co_col = a.co_color
				WHERE pg.fact_num='".$fact_num."'
				GROUP BY 
					a.co_art,
					pg.prec_vta2,
					a.art_des,
					a.ref, 
					a.modelo,
					pg.tipo_imp,
					pg.porc_desc,c.des_col
				ORDER BY a.art_des ASC";
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e = count($query);		
		
		if($e >= 1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
				$array[$cnt] = new FacturaData(); 
				$array[$cnt]->responsive_id = ""; 		
				$array[$cnt]->co_art = trim($r['co_art']);				
				$array[$cnt]->barcode = trim($r['ref']);
				$array[$cnt]->art_des = trim($r['art_des']);	
				$array[$cnt]->marca = trim($r['marca']);	
				$array[$cnt]->cant_desp = floatval($r['cantidad']);
				$array[$cnt]->prec_vta = floatval($r['prec_vta1']);	
				$array[$cnt]->descuento = floatval($r['descuento'] ?? 0);
				// <--- ASIGNACIÓN FALTANTE
				$array[$cnt]->tipo_imp = trim($r['tipo_imp']); 
				
				$cnt++;
			}
			return $array;
		} else {
			$array = array();
			return $array;
		}
	}


	public static function getFacturasClienteCobranzas($co_cli, $filtro, $fecha_inicio, $fecha_final,$tipo_documento,$tipo_pago) {
		$numero_retencion = 0;
		// Filtro de anulado (0 para no anulado, 1 para anulado)
		if($filtro == 'NO') {
			$filtro = 0; // 0 es para no anulado
		} else {
			$filtro = 1; // 1 es para anulado
		}

		$co_ven = $_SESSION['identidad'];
		$co_sucu = $_SESSION['co_alma'];

		
		$sql = "SELECT 
				CAST(d.nro_doc AS VARCHAR) AS serie_fact_num,
				d.nro_doc,
				   CASE 
					WHEN d.tipo_doc IN ('N/CR', 'AJUSTE') THEN -(d.saldo/d.tasa)
					ELSE (d.saldo/d.tasa)
				END AS saldo,
				CASE 
					WHEN d.tipo_doc IN ('N/CR', 'AJUSTE') THEN -(d.saldo/d.tasa)
					ELSE (d.saldo/d.tasa)
				END AS saldoBs,
				d.fec_emis,
				d.tipo_doc,
				(d.monto_net) AS monto_neto,
				c.cli_des as cli_des,
				c.co_cli as co_cli,
				d.fec_venc,
				c.contribu_e,
				d.monto_imp,
				d.tipo,
				c.porc_esp,
				ISNULL(p.monto_total, 0) as monto_transito,
				DATEDIFF(d, d.fec_emis, GETDATE()) AS dias,
				DATEDIFF(d, d.fec_venc, GETDATE()) as dias_vencida, 
				CASE WHEN d.campo6 = '<$>' THEN 1 ELSE 0 END as forma 
			FROM docum_cc d     
				INNER JOIN clientes c ON d.co_cli = c.co_cli
				LEFT JOIN (
					SELECT nro_doc, SUM(monto) as monto_total
					FROM jm_reportar_pago_reg 
					WHERE status = 1
					AND tipo_doc !='ADEL'
					GROUP BY nro_doc
				) p ON d.nro_doc = p.nro_doc
			WHERE 
				d.saldo > 0 
				AND d.anulado = $filtro ";

			// Filtro por tipo de documento - si es 'no' muestra todos, sino filtra por los especificados
			if($tipo_documento == 'NO') {
				$sql .= " AND d.tipo_doc IN ('N/CR', 'N/DB', 'RET_IVA', 'FACT','ADEL')";

			}else{
				$sql .= " AND d.tipo_doc IN ('$tipo_documento')";
			}

			// Filtro por cliente si no es 'NO'
			if($co_cli != 'NO') {
				$sql .= " AND d.co_cli = '$co_cli'";
			}

			// Filtro por rango de fechas si están presentes
			if($fecha_inicio != 'NO' && $fecha_final != 'NO') {
				$sql .= " AND d.fec_emis BETWEEN '$fecha_inicio' AND '$fecha_final'";
			}

			$sql .= " ORDER BY d.fec_emis DESC";
		//echo $sql; // Para depuración, puedes comentar esta línea en producción 
		$query = Executor::doitAr($sql);    
		$e = count($query);        
		if($e >= 1) {
			$array = array();
			$cnt = 0;    
			$status = 0;
			foreach($query as $r) {

				
		  // --- INICIO DE LA MODIFICACIÓN ---
		
		// 1. Guardamos el número original de la base de datos.
		$numeroOriginal = $r['serie_fact_num'];
		$numeroFormateado = $numeroOriginal; // Por defecto, el número no cambia.

		// 2. Aplicamos la regla: si empieza con "5" PERO no es exactamente "5".
		// Usamos substr para obtener el primer carácter.
		if (substr($numeroOriginal, 0, 1) === '5' && $numeroOriginal !== '5' && strlen($numeroOriginal) ==8) {
			// Obtenemos el resto del número a partir del tercer carácter (índice 2).
			$restoDelNumero = substr($numeroOriginal, 2);
			// Construimos el nuevo número.
			$numeroFormateado = 'NF' . $restoDelNumero;
		}
		
		// --- FIN DE LA MODIFICACIÓN ---




				$objeto_pedido = New PedidoData();
				  $objeto_funciones = New FuncionesData();
				$data_retenciones = $objeto_funciones->getRetencionesFactura($r['nro_doc']);
				
				// MODIFICACIÓN AQUÍ: Manejar el caso cuando no hay retenciones
				if (!empty($data_retenciones) && isset($data_retenciones[0]->numero_retencion)) {
					$numero_retencion = $data_retenciones[0]->numero_retencion;
				} else {
					$numero_retencion = 0; // Valor por defecto cuando no hay retenciones
				}


				//echo $numero_retencion;
				$data = $objeto_pedido->tasa();
				$tasa = $data['tasa'];    
				$tasa = round((float)$tasa, 2); 
				//echo $tasa;
				$array[$cnt] = new FacturaData(); 
				$array[$cnt]->responsive_id = "";         
				$array[$cnt]->nro_doc = $r['nro_doc'];    
				$array[$cnt]->serie_fact_num = $numeroFormateado;    
				$array[$cnt]->saldo = round((float)$r['saldo'], 2);    
				$array[$cnt]->saldo2 = round((float)$r['saldo'], 2);    
				$array[$cnt]->saldo3 = round((float)($r['saldoBs'] * $tasa), 2);    
				$array[$cnt]->fec_emis = substr($r['fec_emis'], 0, 10);  // abcd ;    
				$array[$cnt]->fec_venc = substr($r['fec_venc'], 0, 10);  // abcd ;    
				$array[$cnt]->tipo_doc = $r['tipo_doc'];    
				$array[$cnt]->monto_transito = number_format($r['monto_transito'], 2, ',', '.');
				$array[$cnt]->dato2 = number_format(round((float)$r['monto_neto'], 2), 2, ',', '.');
				$array[$cnt]->dato1 = round((float)'0', 2);                
				$array[$cnt]->dato3 = $r['dias'];    
				$array[$cnt]->dato4 = $r['dias_vencida'];    
				$array[$cnt]->dato6 = $r['forma'];

				$array[$cnt]->dato7 = $r['contribu_e'];    
				$array[$cnt]->dato8 = $r['porc_esp'];  

				$array[$cnt]->dato9 = $r['tipo'];
				$array[$cnt]->dato10 = $r['monto_imp'];

					$array[$cnt]->dato11 = $numero_retencion;  

				$array[$cnt]->cli_des = trim($r['cli_des']);
				$array[$cnt]->co_cli = trim($r['co_cli']);
				$array[$cnt]->tasa = number_format($tasa, 2, ',', '.');        
				
				$cnt++;
			}
			return $array;
		} else {
			$array = array();
			return $array;
		}
	}

public static function getDataFacturasDocumentos($tipo_documento){
   		 // 1. Obtenemos el año actual
    $hoy = getdate();
    $anio = $hoy['year'];

    // 2. Determinamos qué mes consultar
    $mes_a_consultar = '';
  
    // 3. Construimos la consulta SQL con todos los campos necesarios
    $sql = "
        SELECT
            -- Identificadores
            c.fact_num AS factura_id,
            
            -- Número de factura formateado (para mostrar con NF si es necesario)
            CAST(c.fact_num AS VARCHAR) AS fact_num_original,
            CASE 
                WHEN LEFT(CAST(c.fact_num AS VARCHAR), 1) = '5' 
                    AND c.fact_num != 5 
                    AND LEN(CAST(c.fact_num AS VARCHAR)) = 8 
                THEN 'NF' + SUBSTRING(CAST(c.fact_num AS VARCHAR), 3, LEN(CAST(c.fact_num AS VARCHAR)) - 2)
                ELSE CAST(c.fact_num AS VARCHAR)
            END AS serie_fact_num,
            
            -- Datos del cliente
            c.co_cli,
            cl.cli_des AS cli_des,
            cl.rif,
            c.contrib AS contribuyente_especial,
            
            -- Fechas
            c.fec_emis,
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_emis_format,
            c.fec_venc,
            CONVERT(VARCHAR, c.fec_venc, 103) AS fec_venc_format,
            DATEDIFF(day, GETDATE(), c.fec_venc) AS dias_vencimiento,
            
            -- Montos y saldos
            c.saldo,
            c.moneda,
            CASE 
                WHEN c.moneda = 'USD' THEN c.saldo
                ELSE 0
            END AS saldo_usd,
            CASE 
                WHEN c.moneda != 'USD' OR c.moneda IS NULL THEN c.saldo
                ELSE 0
            END AS saldo_bs,
            
            -- Totales
            c.tot_bruto,
            c.tot_neto,
            c.iva,
            c.tasa,
            
            -- Estados y flags
            c.anulada,
            c.status,
            c.campo1,
            c.campo2,
            c.campo3,
            c.campo4,
            c.campo5,
            c.campo6,
            
            -- Información de retenciones
            c.num_control,
            c.total_uc,
            c.total_cp,
            
            -- Indicadores calculados
            CASE 
                WHEN c.anulada = 1 THEN 'Anulada'
                WHEN c.saldo <= 0 THEN 'Pagada'
                WHEN c.fec_venc < GETDATE() THEN 'Vencida'
                WHEN DATEDIFF(day, GETDATE(), c.fec_venc) <= 5 THEN 'Por Vencer'
                ELSE 'Vigente'
            END AS estatus_texto,
            
            -- Para saber si aplica retención (contribuyente especial + IVA > 0 + saldo > 0 + no anulada)
            CASE 
                WHEN c.contrib = 1 AND c.iva > 0 AND c.saldo > 0 AND c.anulada = 0 THEN 1
                ELSE 0
            END AS aplica_retencion,
            
            -- Monto en tránsito (asumo que está en algún campo, si no, dejar en 0)
            0 AS monto_transito,
            
           
            -- Campos adicionales que puedan ser útiles
            c.forma_pag,
            c.co_ven,
            c.co_tran,
            c.num_control AS nro_control
            
        FROM 
            factura c 
			inner join clientes cl on c.co_cli = cl.co_cli
        WHERE 
            
            
             YEAR(c.fec_emis) = " . intval($anio) . " 
            AND c.anulada = '0'
		
		
        ORDER BY 
            c.fec_emis DESC
    ";

    //echo $sql; //Ejecutar consulta
    $query = Executor::doitAr($sql);

    if (count($query) >= 1) {
        $array = array();
        $cnt = 0;

        foreach ($query as $r) {
            $array[$cnt] = new FacturaData();

            // Mapear todos los campos de la consulta al objeto
            $array[$cnt]->responsive_id = "";
            
            // Número de factura (formateado para mostrar)
            $array[$cnt]->fact_num = $r['serie_fact_num'];
            $array[$cnt]->fact_num_original = $r['fact_num_original'];
            
            // Datos del cliente
            $array[$cnt]->co_cli = $r['co_cli'];
            $array[$cnt]->cli_des = $r['cli_des'];
            $array[$cnt]->rif = $r['rif'];
            $array[$cnt]->contribuyente_especial = $r['contribuyente_especial'];
            
            // Fechas
            $array[$cnt]->fec_emis = $r['fec_emis'];
            $array[$cnt]->fec_emis_format = $r['fec_emis_format'];
            $array[$cnt]->fec_venc = $r['fec_venc'];
            $array[$cnt]->fec_venc_format = $r['fec_venc_format'];
            $array[$cnt]->dias_vencimiento = $r['dias_vencimiento'];
            
            // Saldos
            $array[$cnt]->saldo = $r['saldo'];
            $array[$cnt]->moneda = $r['moneda'];
            $array[$cnt]->saldo_usd = (float)$r['saldo_bs']/$r['tasa'];;
            $array[$cnt]->saldo_bs = $r['saldo_bs'];
            
            // Totales
            $array[$cnt]->tot_bruto = $r['tot_bruto'];
            $array[$cnt]->tot_neto = $r['tot_neto'];
            $array[$cnt]->iva = $r['iva'];
            $array[$cnt]->tasa = $r['tasa'];
            
            // Estados
            $array[$cnt]->anulada = $r['anulada'];
            $array[$cnt]->status = $r['status'];
            $array[$cnt]->estatus_texto = $r['estatus_texto'];
            
            // Campos auxiliares (para compatibilidad con código existente)
            $array[$cnt]->dato1 = $r['campo1'] ?? '';
            $array[$cnt]->dato2 = $r['campo2'] ?? '';
            $array[$cnt]->dato3 = $r['campo3'] ?? '';
            $array[$cnt]->dato4 = $r['campo4'] ?? '';
            $array[$cnt]->dato5 = $r['campo5'] ?? '';
            $array[$cnt]->dato6 = $r['campo6'] ?? '';
            $array[$cnt]->dato7 = ''; // Si necesitas más campos
            $array[$cnt]->dato8 = '';
            $array[$cnt]->dato9 = '';
            $array[$cnt]->dato10 = '';
            $array[$cnt]->dato11 = '';
            
            // Información de retenciones
            $array[$cnt]->aplica_retencion = $r['aplica_retencion'];
            $array[$cnt]->num_control = $r['num_control'];
            $array[$cnt]->monto_transito = $r['monto_transito'];
            
            // Datos adicionales
            $array[$cnt]->forma_pag = $r['forma_pag'];
            $array[$cnt]->co_ven = $r['co_ven'];
            $array[$cnt]->co_tran = $r['co_tran'];
            $array[$cnt]->nro_control = $r['nro_control'];

            $cnt++;
        }

        return $array;
    } else {
        return array();
    }
}

}



?>

