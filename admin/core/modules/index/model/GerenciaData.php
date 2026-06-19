<?php
class GerenciaData {
	public static $tablename = "factura";
	//co_cli cli_des rif saldo
	public function __construct(){
		
		$this->dato1 = '0';


	}

	public  function getAllDatosFacturacion($ano,$mes,$co_ven){


		



			$filtroMes ="	f.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
			$filtroMes2= "	d.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";



		  switch ($co_ven) {
				case 'all':
					$filtrado = "where v.campo5 = '*'";
					$ven="";
					$ven2="";
					break;

				case 'gventas':
					$filtrado = "where v.campo5 = '*' and v.campo6='*'";
					$ven="";
					$ven2="";
					break;

				case 'aventas':
					
					$ven="";
					$ven2="";
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
					$filtrado = "where v.campo5 = '*'";
					$ven=" and f.co_ven='$co_ven' ";
					$ven2=" and d.co_ven='$co_ven' ";
					break;
			}


		

			$sql= "WITH TransaccionesPorVendedor AS (
				-- 1. Obtenemos el neto de las ventas por vendedor (Bruto - Descuento)
				SELECT
					f.co_ven,
					SUM(ROUND(f.tot_bruto / f.tasa, 2) - ROUND(f.glob_desc / f.tasa, 2)) AS neto_transaccion
				FROM factura f
				WHERE   $filtroMes
				AND f.anulada = 0 $ven
				-- Puedes descomentar la siguiente línea para filtrar por un vendedor específico
				-- AND f.co_ven IN ('V2')
				GROUP BY f.co_ven

				UNION ALL

				-- 2. Obtenemos el neto de las devoluciones por vendedor y lo tratamos como un valor negativo
				SELECT
					d.co_ven,
					-COALESCE(SUM(ROUND((d.tot_bruto - d.glob_desc) / d.tasa, 2)), 0) AS neto_transaccion
				FROM dev_cli d
				WHERE  $filtroMes2
				AND d.anulada = 0  $ven2
				-- Si filtras por vendedor en facturas, hazlo también aquí
				-- AND d.co_ven IN ('V2')
				GROUP BY d.co_ven
			)
			-- 3. Sumamos todas las transacciones por vendedor y obtenemos el nombre del vendedor
				SELECT 
					v.co_ven,
					v.ven_des,
					-- 4. Usamos COALESCE para convertir los montos NULL (de vendedores sin actividad) en 0
					COALESCE(SUM(t.neto_transaccion), 0) AS monto
				FROM vendedor v
				-- 5. Usamos LEFT JOIN para mantener todos los vendedores, incluso si no tienen transacciones
				LEFT JOIN TransaccionesPorVendedor t ON v.co_ven = t.co_ven
					$filtrado
				GROUP BY v.co_ven, v.ven_des
				ORDER BY monto DESC;";

		
		/*	$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc		
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$ano'
			AND tipo_doc = 'FACT' AND anulado = 0" .$ven;*/
			//echo $sql;

		
			//echo "<br>";	
		//	echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				$co_ven = trim($r['co_ven']);
				$array[$cnt] = new GerenciaData();  	
				$data2=$this->getAllDatosDevoluciones($ano,$mes,$co_ven);
				$data3=$this->getAllDatosCobranzas($ano,$mes,$co_ven);
				$totalDevoluciones = $data2[0]->dato1;		
				$totalCobranzas = $data3[0]->dato1;				
				$array[$cnt]->dato1 = (float)$r['monto'];
				$array[$cnt]->dato2 = (float)$totalDevoluciones;
				$array[$cnt]->dato3 =trim($r['ven_des']);
				$array[$cnt]->dato4 =(float)$totalCobranzas;
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}



	public static function getAllDatosDevoluciones($ano,$mes,$co_ven){

			

			$filtroMes =" fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";

			if($co_ven!='all'){
				$ven=" and co_ven='$co_ven' ";
			}else{
				$ven="";
			}

			$sql = "Select sum(tot_neto/tasa) as monto from dev_cli where  $filtroMes AND anulada = 0".$ven;
			//echo $sql;

		
			//echo "<br>";	
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {						
				$array[$cnt] = new GerenciaData();  				
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


	
	public  function getAllDatosCobranzas($ano,$mes,$co_ven){


		  switch ($co_ven) {
				case 'all':
				
					$ven="  and v.campo5='*'";
				
					break;

				case 'gventas':
				
					$ven="and v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";
					
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
				
					$ven=" and v.co_ven='$co_ven'  and v.campo5='*'";
					
					break;
			}



		$filtroMes = " r.fec_cheq BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
			
			
		
			$sql = " SELECT 
					v.ven_des,v.co_ven,
					ROUND(SUM(r.mont_doc / c.tasa), 2) AS cobranza_mes
				FROM 
					cobros c 
				JOIN 
					reng_tip r ON c.cob_num = r.cob_num
				INNER JOIN
				vendedor AS v ON c.co_ven = v.co_ven
				WHERE  $filtroMes
					AND c.anulado = 0 " .$ven. "
				GROUP BY 
					v.ven_des,v.co_ven 
				ORDER BY 
					cobranza_mes DESC;
			";


		/*	$sql = "select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cheq)='$mes'  and YEAR(fec_cheq) = '$ano' and anulado = 0" .$ven;
			*/
		//	echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
			
				$array[$cnt] = new GerenciaData();	
				$array[$cnt]->dato1 = (float)$r['cobranza_mes'];
				$array[$cnt]->dato2 = trim($r['co_ven']);
				
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
		

		
	}




	
	public static function getAllDatoTopsArticulos($ano,$mes,$co_ven){

		 	 switch ($co_ven) {
				case 'all':
				
					$ven="";
				
					break;

				case 'gventas':
				
					$ven="and v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";
					
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
				
					$ven="and v.co_ven in ('$co_ven')  ";
					
					break;
			}

		

			$mesCond = " f.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
			


				$sql ="			
			select TOP 5 a.art_des, SUM(r.total_art - r.total_dev) total_art, a.modelo
							from factura f
							inner join reng_fac r on f.fact_num = r.fact_num
							inner join art a on r.co_art = a.co_art
							inner join vendedor v on v.co_ven  = f.co_ven
							WHERE  $mesCond
								".$ven."
								AND f.anulada = 0
								AND f.moneda  = 'US$'
								AND a.co_color <> '05'
							group by a.art_des, a.modelo
				ORDER by 2 desc";

			

				//echo $sql;
				$query = Executor::doitAr($sql);	
				$e=count($query);		
				if($e>=1){
					$array = array();
					$cnt = 0;	
					foreach($query as $r) {
					$array[$cnt] = new GerenciaData(); 						
					$array[$cnt]->dato1 = trim($r['art_des']);	
					$array[$cnt]->dato2 = number_format($r['total_art'], 2, ',', '.');
					$array[$cnt]->dato3 = trim($r['modelo']);	
					$array[$cnt]->dato4 = 0;
				
					$cnt++;
				}
				return $array;
				}else{
						$array = array();
						return $array;
				}
				
	}


	
	public  function getAllDatosClientesActivos($ano,$mes,$co_ven){

		

		
		switch ($co_ven) {
				case 'all':
					$filtrado = "INNER JOIN  vendedor v on v.co_ven = f.co_ven";
					
					$ven= "AND v.campo5 = '*'";
				
					break;

				case 'gventas':
					
					$filtrado = "INNER JOIN  vendedor v on v.co_ven = f.co_ven";
				
					$ven= "AND v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";
					
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
					$filtradoGrupos = "";
					$filtrado ="";
					$ven="AND ('$co_ven' IS NULL OR f.co_ven = '$co_ven')";
					
					break;
			}

		

			$mesCond = " and 	f.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
			
		

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
					$filtrado 
					JOIN grupos g   ON f.co_cli = g.co_cli
					WHERE f.anulada = 0
						
							$mesCond
						$ven
					GROUP BY g.group_id
				)

				SELECT COUNT(*) AS total_clientes_activados
				FROM facturacion;";



	
	
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new GerenciaData();		
			
				$array[$cnt]->dato1 = (float)$r['total_clientes_activados'];
			
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					$cnt = 0;	
					$array[$cnt] = new GerenciaData();		
					
					$array[$cnt]->dato1 =0;
			
				return $array;
			}

	}


	public  function getAllDatosClientesNuevos($ano,$mes,$co_ven){

			if($co_ven!='all'){
				$ven="AND c.co_ven = '$co_ven'";
			}else{
				$ven="";
			}

			
								
			$mesCond = "f.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
			$mesCond2 = "and c.fecha_reg BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
			
				$sql="
				SELECT count(DISTINCT c.co_cli) as total_clientes_nuevos
					FROM factura f
					INNER JOIN clientes c ON f.co_cli = c.co_cli
					INNER JOIN zona z ON c.co_zon = z.co_zon			
					WHERE						
						$mesCond
						AND f.anulada = 0". $ven ."						
						AND c.inactivo = 0					
						$mesCond2;";	
						
						
		
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new GerenciaData();	
				$array[$cnt]->dato1 = (float)$r['total_clientes_nuevos'];
				$cnt++;
			}
			return $array;
			}else{	$cnt = 0;	
						
				
					$array = array();
						$array[$cnt] = new GerenciaData();						
						$array[$cnt]->dato1 =0;
					
					return $array;
			}
	}

	
	public static function getAllDatoTopsArticulosBialy($ano,$mes,$co_ven){


				 switch ($co_ven) {
				case 'all':
				
					$ven="";
				
					break;

				case 'gventas':
				
					$ven="and v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";
					
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
				
					$ven="and v.co_ven in ('$co_ven')  ";
					
					break;
			}


								
			$mesCond = "f.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";

				$sql ="			
			select TOP 5 a.art_des, SUM(r.total_art - r.total_dev) total_art, a.modelo
							from factura f
							inner join reng_fac r on f.fact_num = r.fact_num
							inner join art a on r.co_art = a.co_art
							inner join vendedor v on v.co_ven  = f.co_ven
							WHERE $mesCond
								".$ven."
								AND f.anulada = 0
								AND f.moneda  = 'US$'
								AND a.co_color = '05'
							group by a.art_des, a.modelo
				ORDER by 2 desc";

			

				//echo $sql;
				$query = Executor::doitAr($sql);	
				$e=count($query);		
				if($e>=1){
					$array = array();
					$cnt = 0;	
					foreach($query as $r) {
					$array[$cnt] = new GerenciaData(); 						
					$array[$cnt]->dato1 = trim($r['art_des']);	
					$array[$cnt]->dato2 = number_format($r['total_art'], 2, ',', '.');
					$array[$cnt]->dato3 = trim($r['modelo']);	
				
					$cnt++;
				}
				return $array;
				}else{
						$array = array();
						return $array;
				}
				
	}


	public  function getDatoCalculoImplicito(){
		

			$sql = "select temp_char8 as tasa_implicita from par_emp";
		
		//	echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				//$co_ven = $r['co_ven'];
				$array[$cnt] = new GerenciaData();  	
			
				$array[$cnt]->dato1 = $r['tasa_implicita'];
	
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}





	
	public  function getAllDatosCuentasXPagar($ano,$mes,$co_ven){


		  switch ($co_ven) {
				case 'all':
				
					$ven="  and v.campo5='*'";
				
					break;

				case 'gventas':
				
					$ven="and v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";
					
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
				
					$ven=" and v.co_ven='$co_ven'  and v.campo5='*'";
					
					break;
			}


	
			
			$filtroMes = "d.fec_venc BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
		
			
		
			$sql = "SELECT 
					v.ven_des, v.co_ven,
					ROUND(SUM(CASE 
						WHEN d.TIPO_DOC IN('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
						THEN (d.saldo/d.tasa)*(-1) 
						ELSE (d.saldo/d.tasa) 
					END), 2) AS saldo_calculado
				FROM 
					docum_cp d
				INNER JOIN 
					clientes c ON c.co_cli = d.co_cli
				INNER JOIN 
					vendedor v ON d.co_ven = v.co_ven
				WHERE 
					d.saldo > 0 
					AND d.tipo_doc IN('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA')
					AND $filtroMes
				
				GROUP BY 
					v.ven_des, v.co_ven
				ORDER BY 
					saldo_calculado DESC;
				";


		/*	$sql = "select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cheq)='$mes'  and YEAR(fec_cheq) = '$ano' and anulado = 0" .$ven;
			*/
		//	echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
			
				$array[$cnt] = new GerenciaData();	
				$array[$cnt]->dato1 = (float)$r['saldo_calculado'];
				$array[$cnt]->dato2 = trim($r['co_ven']);
				
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
		

		
	}


	
	
	public  function getAllDatosCuentasXCobrar($ano,$mes,$co_ven){


		  switch ($co_ven) {
				case 'all':
				
					$ven="  and v.campo5='*'";
				
					break;

				case 'gventas':
				
					$ven="and v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";
					
				
					break;

				default:
					// Asumimos que es un código de vendedor específico (ej: 'v1')
				
					$ven=" and v.co_ven='$co_ven'  and v.campo5='*'";
					
					break;
			}


		
		
			
		$sql = "SELECT 
					v.ven_des, v.co_ven,
					ROUND(SUM(CASE 
						WHEN d.TIPO_DOC IN('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
						THEN (d.saldo/d.tasa)*(-1) 
						ELSE (d.saldo/d.tasa) 
					END), 2) AS saldo_calculado
				FROM 
					docum_cc d
				INNER JOIN 
					clientes c ON c.co_cli = d.co_cli
				INNER JOIN 
					vendedor v ON d.co_ven = v.co_ven
				WHERE 
					d.saldo > 0 
					AND d.tipo_doc IN('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA')				
					". $ven ."
				GROUP BY 
					v.ven_des, v.co_ven
				ORDER BY 
					saldo_calculado DESC;
				";




		/*	$sql = "select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cheq)='$mes'  and YEAR(fec_cheq) = '$ano' and anulado = 0" .$ven;
			*/
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
			if($e>=1){

				$array = array();
				$cnt = 0;    
				foreach($query as $r) {            
					
					$array[$cnt] = new GerenciaData();    
					$array[$cnt]->dato1 = max(0, (float)$r['saldo_calculado']); // Usando max() para asegurar valor no negativo
					$array[$cnt]->dato2 = trim($r['co_ven']);
					$array[$cnt]->dato3 = trim($r['ven_des']);
					
					$cnt++;
				}
				
				return $array;

			}else{

				$array = array();
				return $array;

			}
		

		
	}



	public  function getAllDatosSaldosFacturas($ano,$mes,$co_ven,$d){

			$filtroMes='';

			switch ($co_ven) {

				case 'all':
				
					$ven="  and v.campo5='*'";
				
					break;

				case 'gventas':
				
					$ven="and v.campo5 = '*' and v.campo6='*'";
				
					break;

				case 'aventas':
					
					$ven="";					
				
					break;

				default:
									
					$ven=" and v.co_ven='$co_ven'  and v.campo5='*'";
					
					break;
			}

				switch ($d) {

				case 1:
				
					$filtroMes='AND DATEDIFF(d, d.fec_venc, GETDATE())<0';
				
					break;

				case 2:
				
					$filtroMes="AND DATEDIFF(d, d.fec_venc, GETDATE())  BETWEEN 0 AND 15";
				
					break;

				case 3:
					
					$filtroMes="AND DATEDIFF(d, d.fec_venc, GETDATE())  BETWEEN 16 AND 30";

					break;

				case 4:
					
					$filtroMes="AND DATEDIFF(d, d.fec_venc, GETDATE())  >31";

					break;
				default:
									
					$filtroMes='AND DATEDIFF(d, d.fec_venc, GETDATE())<0';
					
					break;
			}



	
			
		$sql = "SELECT 
				v.ven_des, 
				v.co_ven,
				SUM(CASE 
					WHEN d.TIPO_DOC IN('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
					THEN (d.saldo/d.tasa)*(-1) 
					ELSE (d.saldo/d.tasa) 
				END) AS saldo_total
			FROM 
				docum_cc d
			INNER JOIN 
				clientes c ON c.co_cli = d.co_cli
			INNER JOIN 
				vendedor v ON d.co_ven = v.co_ven
			WHERE 
				d.saldo > 0 
					". $ven ."
				AND d.tipo_doc IN('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA')	
				". $filtroMes ."
				
				
			GROUP BY 
				v.ven_des, 
				v.co_ven
				
			ORDER BY 
				saldo_total DESC;";




		/*	$sql = "select  ROUND(SUM(r.mont_doc/c.tasa),2) as cobranza_mes
			from cobros c 
			JOIN reng_tip r on c.cob_num = r.cob_num 			
			where MONTH(fec_cheq)='$mes'  and YEAR(fec_cheq) = '$ano' and anulado = 0" .$ven;
			*/

		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
			
				$array[$cnt] = new GerenciaData();	
						$array[$cnt]->dato1 = max(0, (float)$r['saldo_total']); // Usando max() para asegurar valor no negativo
				$array[$cnt]->dato2 = trim($r['co_ven']);
				$array[$cnt]->dato3 =trim($r['ven_des']);
				
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
		

		
	}


	public  function mgetAllDatosFacturacion($ano,$mes,$day){


	

		$ven='';

		$filtroMes = "f.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";
		$filtroMes = "d.fec_emis BETWEEN '$ano 00:00:00' AND '$mes 23:59:59'";


		

			$sql= "WITH TransaccionesPorVendedor AS (
				-- 1. Obtenemos el neto de las ventas por vendedor (Bruto - Descuento)
				SELECT
					f.co_ven,
					SUM(ROUND(f.tot_bruto / f.tasa, 2) - ROUND(f.glob_desc / f.tasa, 2)) AS neto_transaccion
				FROM factura f
				WHERE  $filtroMes
				AND f.anulada = 0 $ven
				-- Puedes descomentar la siguiente línea para filtrar por un vendedor específico
				-- AND f.co_ven IN ('V2')
				GROUP BY f.co_ven

				UNION ALL

				-- 2. Obtenemos el neto de las devoluciones por vendedor y lo tratamos como un valor negativo
				SELECT
					d.co_ven,
					-COALESCE(SUM(ROUND((d.tot_bruto - d.glob_desc) / d.tasa, 2)), 0) AS neto_transaccion
				FROM dev_cli d
				WHERE $filtroMes2
				AND d.anulada = 0  $ven2
				-- Si filtras por vendedor en facturas, hazlo también aquí
				-- AND d.co_ven IN ('V2')
				GROUP BY d.co_ven
			)
			-- 3. Sumamos todas las transacciones por vendedor y obtenemos el nombre del vendedor
				SELECT 
					v.co_ven,
					v.ven_des,
					-- 4. Usamos COALESCE para convertir los montos NULL (de vendedores sin actividad) en 0
					COALESCE(SUM(t.neto_transaccion), 0) AS monto
				FROM vendedor v
				-- 5. Usamos LEFT JOIN para mantener todos los vendedores, incluso si no tienen transacciones
				LEFT JOIN TransaccionesPorVendedor t ON v.co_ven = t.co_ven
					$filtrado
				GROUP BY v.co_ven, v.ven_des
				ORDER BY monto DESC;";

		
		/*	$sql = "SELECT SUM(monto_bru/tasa) AS monto FROM docum_cc		
			WHERE MONTH(fec_emis)='$mes' and  YEAR(fec_emis)='$ano'
			AND tipo_doc = 'FACT' AND anulado = 0" .$ven;*/
			//echo $sql;

		
			//echo "<br>";	
		//	echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new GerenciaData();			
				$array[$cnt]->dato1 = (float)$r['monto'];		
				$array[$cnt]->dato3 =trim($r['ven_des']);
				

			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public function getAllDatosTotalFacturas() {
    
		$sql = "SELECT 
					COUNT(*) as total_facturas,
					SUM(CASE 
						WHEN d.tipo_doc IN('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') 
						THEN (d.saldo/d.tasa)*(-1) 
						ELSE (d.saldo/d.tasa) 
					END) AS monto_total_vencido
				FROM 
					docum_cc d
				INNER JOIN 
					clientes c ON c.co_cli = d.co_cli
				INNER JOIN 
					vendedor v ON d.co_ven = v.co_ven
				WHERE 
					d.saldo > 0 
					AND d.anulado = 0
					AND d.tipo_doc IN('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA')
					AND d.fec_venc < GETDATE()";
			//echo $sql;
    	$query = Executor::doitAr($sql);
    
		$e=count($query);
			if($e>=1){

				$array = array();
				$cnt = 0;    
				foreach($query as $r) {            
					
					$array[$cnt] = new GerenciaData();    
					$array[$cnt]->total_facturas = (int)$r['total_facturas'];
					$array[$cnt]->monto_total =(float)$r['monto_total_vencido'];
				//	$array[$cnt]->dato3 = trim($r['ven_des']);
					
					$cnt++;
				}
				
				return $array;

			
		}else{
					$array = array();
				return $array;

		}
    
	
	}


	public function getAllDatosTotalFacturasEmitidas() {
    
		$sql = "SELECT COUNT(*) as total_facturas FROM factura f WHERE f.anulada = 0 and f.num_control <> ' '";
			//echo $sql;
    	$query = Executor::doitAr($sql);
    
		$e=count($query);
			if($e>=1){

				$array = array();
				$cnt = 0;    
				foreach($query as $r) {            
					
					$array[$cnt] = new GerenciaData();    
					$array[$cnt]->total_facturas = (int)$r['total_facturas'];
					$array[$cnt]->monto_total =(int)$r['total_facturas'];
				//	$array[$cnt]->dato3 = trim($r['ven_des']);
					
					$cnt++;
				}
				
				return $array;

			
		}else{
					$array = array();
				return $array;

		}
    
	
	}

}
