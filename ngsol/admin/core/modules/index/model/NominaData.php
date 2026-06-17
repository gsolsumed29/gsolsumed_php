<?php
class NominaData {
	public static $tablename = "snrecibo";	

		public function __construct(){		
			$reci_num = 0;
			$fec_emis = 0;
			$des_gennomi = 0;
			$dato1 = 0;
			

	}

	public function aceptar(){
		$sql = "UPDATE jm_solicitudes_personal SET estatus=2 WHERE id=$this->id";
		
		Executor::doitEx($sql);
	}

	public function denegar(){
		$sql = "UPDATE jm_solicitudes_personal SET estatus=3 WHERE id=$this->id";
		
		Executor::doitEx($sql);
	}

	

	public static function getAllDatosFiltro($status,$rango){
		/// Metodo para consultar todos los datos y mostrar las tabla
		$cod_emp =$_SESSION['identidad'];
	

		if($rango=='NO'){
			$hoy = getdate();
			$mes = $hoy['mon'];
			$anio = $hoy['year'];
			
			$sql ="select r.reci_num, r.fec_emis, g.des_gennomi, 'NOMINA' from snrecibo r inner join sngennomi g on r.co_gennomi = g.co_gennomi
			where r.cod_emp = '".$cod_emp."' and r.co_cont in ('01') and g.estado = 2";
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
			$array[$cnt] = new NominaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->reci_num = $r['reci_num'];		
			$array[$cnt]->fec_emis =substr($r['fec_emis'], 0, 10);  // abcd ;		
			$array[$cnt]->des_gennomi = $r['des_gennomi'];
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}



	public static function estadisticas($id){
		$tabla ="";
		
		if($id==1)$tabla="jm_solicitudes_personal";
	
		$sql = "SELECT count(t.id) as numeros FROM $tabla t WHERE estatus = 1";	
			//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new NominaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->numeros = $r['numeros'];		
			
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}
	}



	public static function getAllDataSolicitudes($tipoSolicitud,$estatus){		
			
			
			$sql ="select s.nombre_completo,sp.fechaEmision,sp.tipo,sp.id,sp.estatus,sp.cod_emp from jm_solicitudes_personal sp 
			INNER JOIN snemple s ON sp.cod_emp = s.cod_emp 
			WHERE sp.tipo = $tipoSolicitud AND sp.estatus = $estatus";
			//echo $sql;


		
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			$array[$cnt] = new NominaData(); 
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id'];		
			$array[$cnt]->cod_emp = $r['cod_emp'];		
			$array[$cnt]->nombre_completo = $r['nombre_completo'];	
			$array[$cnt]->fechaEmision = $r['fechaEmision'];	
			$array[$cnt]->tipo = $r['tipo'];		
			$array[$cnt]->estatus = $r['estatus'];						
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