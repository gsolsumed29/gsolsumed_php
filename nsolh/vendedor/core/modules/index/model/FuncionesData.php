<?php
class FuncionesData {
	public static $tablename = "users";
	
	public function __construct(){
		$this->id = '0';
		$this->cuenta = "";
	}




	public static function validarFacturas($co_cli){
		// validaciones del pedido
	
		$sql = "select d.co_cli, sum(d.saldo/d.tasa) as saldo, 
		max(c.mont_cre) as mont_cre
		from docum_cc d inner join clientes c on d.co_cli = c.co_cli
		where d.tipo_doc = 'FACT' AND d.saldo > 0 and d.co_cli in ('$co_cli')
		group by d.co_cli
		";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['saldo'];
				$array[$cnt]->dato2 = (float)$r['mont_cre'];	

			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function validarDiasFacturas($co_cli){
		// validaciones del pedido
	
		$sql = "select d.co_cli, CASE WHEN  max(datediff(day, fec_emis, GETDATE())) >  MAX(c.plaz_pag) THEN 0 ELSE 1 END resp,
		MAX(c.plaz_pag) plaz_pag , max(datediff(day, fec_emis, GETDATE())) dias_moro
		from docum_cc d inner join clientes c on d.co_cli = c.co_cli
		where d.tipo_doc = 'FACT' AND d.saldo > 0 and d.co_cli in ('$co_cli')
		group by d.co_cli";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['resp'];	
				$array[$cnt]->dato2 = $r['plaz_pag'];		
				$array[$cnt]->dato3 = $r['dias_moro'];			

			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	
	

	public static function foundValor($tabla,$key,$valor,$clase){
	
		$sql = "SELECT COUNT(c.".$key.") cuenta FROM ".$tabla." c WHERE c.".$key."='".$valor."'";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new $clase();  				
				$array[$cnt]->id = $r['cuenta'];
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public  function radomCodigo(){
		$alphabet = "0123456789ABCDEFGHIJKLMNOPQSTUWXYZabcdefghijqlmnopqrstuvwxyz";
		$pass = array(); //recuerde que debe declarar $pass como un array
		$alphaLength = strlen($alphabet) - 1; //poner la longitud -1 en caché
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //convertir el array en una cadena
	}	

	
	public static function promedio($cod_emp){
		$hoy = getdate();			
		$anio = $hoy['year'];
		
		$sql = "select SUM(monto) as promedio 
		from snnomi 
		where cod_emp = '$cod_emp' AND co_conce = 'A001' and month(fec_emis) = MONTH(getdate())-1";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new NominaData();  				
				$array[$cnt]->prom = $r['promedio'];
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
				
			$array[0]->prom = $r['promedio'];
			return $array;

		}
	}

}
?>