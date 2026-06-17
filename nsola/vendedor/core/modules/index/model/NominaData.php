<?php
class NominaData {
	public static $tablename = "snrecibo";	

		public function __construct(){		
			$reci_num = 0;
			$fec_emis = 0;
			$des_gennomi = 0;
			$dato1 = 0;
			$cod_emp = 0;
			$nombre_completo = 0;
			$ci = 0;
			$co_novedad_dia = 0;
			$co_novedad_hora = 0;
			$num_pres = 0;
			$num_contpres = 0;
			$num_vac = 0;
			$fec_emis = 0;
			$reci_num = 0;
			$comentario = 0;
			$monto = 0;
			$auxi_cha = 0;
			$auxi_num = 0;
			$tipo = 0;
			$SueldoMensVar = 0;
			$nivel = 0;
			$Sueldo_diario = 0;
			$co_conce = 0;
			$des_conce = 0;
			$co_ban = 0;
			$des_ban = 0;
			$cta_banc1 = 0;
			$fecha_ing = 0;
			$des_depart = 0;
			$co_depart = 0;
			$co_cont = 0;
			$des_cont = 0;
			$fec_ini = 0;
			$fec_fin = 0;
			$co_cargo = 0;
			$des_cargo = 0;
			$NetoPagar = 0;

	}


	

	function number_words($valor,$desc_moneda, $sep, $desc_decimal) {
		$arr = explode(".", $valor);
		$entero = $arr[0];
		if (isset($arr[1])) {
		$decimos = strlen($arr[1]) == 1 ? $arr[1] . '0' : $arr[1];
		}
		
		$fmt = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
		if (is_array($arr)) {
		$num_word = ($arr[0]>=1000000) ? "{$fmt->format($entero)} de $desc_moneda" : "{$fmt->format($entero)} $desc_moneda";
		if (isset($decimos) && $decimos > 0) {
		$num_word .= " $sep {$fmt->format($decimos)} $desc_decimal";
		}
		}
		return $num_word;
		}

	public static function GetNomina($reci_num){
		/// Metodo para consultar todos los datos y mostrar las tablas
		
		//$reci_num = 94;

		$sql ="SELECT  
		e.cod_emp,
		e.nombre_completo,
		(case 
		when e.nac = 2 then 'E-'
		else 'V-'  						
		end  + 
		e.ci)as ci,
		n.co_novedad_dia,n.co_novedad_hora,n.num_pres,n.num_contpres,n.num_vac,
		[dbo].[ObtenerFechaCadena] (r.fec_emis)as fec_emis,
		r.reci_num,

		n.comentario,
		isnull(n.monto,0)as monto,
		n.auxi_cha,
		n.auxi_num,
		n.tipo,
		dbo.GetMontoConceptoRecibo('Q024', r.reci_num) as SueldoMensVar,
		isnull(dbo.GetMontoConceptoRecibo('Q040', r.reci_num),0) as nivel,
		dbo.GetMontoConceptoRecibo('Q001', r.reci_num) as Sueldo_diario,
		c.co_conce,
		c.des_conce,

		b.co_ban,
		b.des_ban,
		e.cta_banc1,
		e.fecha_ing,

		d.des_depart,
		d.co_depart,

		co.co_cont,
		co.des_cont,

		gn.fec_ini,
		gn.fec_fin,
		ca.co_cargo,	
		ca.des_cargo,
		dbo.GetMontoNetoPagarRecibo(r.reci_num) as NetoPagar
		FROM 
				dbo.snrecibo as r

		inner join dbo.snnomi as n
				on(r.reci_num = n.reci_num)

		inner join dbo.snconcep as c
				on(c.co_conce = n.co_conce)

		inner join dbo.snemple as e
				on(n.cod_emp = e.cod_emp)

		inner join dbo.sncont as co
				on(co.co_cont = r.co_cont)

		left join dbo.snbanco as b
				on(e.co_ban1 = b.co_ban)

		inner join dbo.sndepart as d
				on(d.co_depart = r.co_depart)

		inner join dbo.sngennomi as gn
				on(gn.co_cont = r.co_cont)AND(gn.fec_emis = r.fec_emis)

		inner join dbo.sncargo as ca
				on(ca.co_cargo = e.co_cargo)

		WHERE	
		(co.tip_cont in (1,2,3))AND
		(n.tipo in (1,2,3))AND
		
		r.reci_num = ".$reci_num."

GROUP BY e.cod_emp,	c.co_conce, e.nombre_completo, e.nac, e.ci, n.co_novedad_dia,n.co_novedad_hora,n.num_pres,n.num_contpres,n.num_vac,
r.fec_emis,		r.reci_num,	n.comentario, n.monto,	n.auxi_cha,		n.auxi_num,		n.tipo,e.cod_emp,
			c.des_conce,		b.co_ban,		b.des_ban,		e.cta_banc1,		e.fecha_ing,    
			d.des_depart,		d.co_depart,		co.co_cont,		co.des_cont,		gn.fec_ini,		
			gn.fec_fin,		ca.co_cargo,			ca.des_cargo,		r.reci_num

";  

		
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new NominaData(); 

			$array[$cnt]->cod_emp = $r['cod_emp'];
			$array[$cnt]->nombre_completo = $r['nombre_completo'];
			$array[$cnt]->ci = $r['ci'];
			$array[$cnt]->co_novedad_dia = $r['co_novedad_dia'];
			$array[$cnt]->co_novedad_hora = $r['co_novedad_hora'];
			$array[$cnt]->num_pres = $r['num_pres'];
			$array[$cnt]->num_contpres = $r['num_contpres'];
			$array[$cnt]->num_vac = $r['num_vac'];
			$array[$cnt]->fec_emis = $r['fec_emis'];
			$array[$cnt]->reci_num = $r['reci_num'];
			$array[$cnt]->comentario = $r['comentario'];
			$array[$cnt]->monto = $r['monto']; 
			$array[$cnt]->auxi_cha = $r['auxi_cha'];
			$array[$cnt]->auxi_num =  number_format($r['auxi_num'], 2, ',', '.');
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->SueldoMensVar = $r['SueldoMensVar'];
			$array[$cnt]->nivel = $r['nivel'];
			$array[$cnt]->Sueldo_diario = $r['Sueldo_diario'];
			$array[$cnt]->co_conce = $r['co_conce'];
			$array[$cnt]->des_conce = $r['des_conce'];
			$array[$cnt]->co_ban = $r['co_ban'];
			$array[$cnt]->des_ban = $r['des_ban'];
			$array[$cnt]->cta_banc1 = $r['cta_banc1'];
			$array[$cnt]->fecha_ing = $r['fecha_ing'];
			$array[$cnt]->des_depart = $r['des_depart'];
			$array[$cnt]->co_depart = $r['co_depart'];
			$array[$cnt]->co_cont = $r['co_cont'];
			$array[$cnt]->des_cont = $r['des_cont'];
			$array[$cnt]->fec_ini = substr($r['fec_ini'], 0, 10);  // abcd ;		$r['fec_ini'];
			$array[$cnt]->fec_fin = substr($r['fec_fin'], 0, 10);  // abcd ;		$r['fec_ini'];$r['fec_fin'];
			$array[$cnt]->co_cargo = $r['co_cargo'];
			$array[$cnt]->des_cargo = $r['des_cargo'];
			$array[$cnt]->NetoPagar = $r['NetoPagar'];


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