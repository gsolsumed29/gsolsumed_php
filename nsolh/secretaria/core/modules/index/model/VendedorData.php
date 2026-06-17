<?php
class VendedorData {
	public static $tablename = "snemple";	
	public function __construct(){
		$this->responsive_id = '';
		$this->co_emp = '0';
		$this->nombre_completo = "";
		
		$this->dato1 ='0';		

	}


	public static function getDataEmpleadoSolicitud($cod_emp){
		
		$sql = "SELECT	e.cod_emp, e.nombre_completo,b.co_ban,b.des_ban,(case 	when e.nac = 2 then 'E-' else 'V-' 	end  + 
		e.ci)as ci,e.cta_banc1,	e.fecha_ing,ca.co_cargo,ca.des_cargo FROM snemple e	
		inner join dbo.sncargo as ca on(ca.co_cargo = e.co_cargo)
		left join dbo.snbanco as b on(e.co_ban1 = b.co_ban)
		WHERE  e.cod_emp='".$cod_emp."' AND e.status = 'A'";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cod_emp = trim($r['cod_emp']);			
			$array[$cnt]->nombre_completo = $r['nombre_completo'];		
			$array[$cnt]->ci = $r['ci'];	
			$array[$cnt]->des_ban = $r['des_ban'];	
			$array[$cnt]->cta_banc1 = $r['cta_banc1'];	
			$array[$cnt]->fecha_ing =substr($r['fecha_ing'], 0, 10);  // abcd ;		
		
			$array[$cnt]->co_cargo = $r['co_cargo'];	
			$array[$cnt]->des_cargo = $r['des_cargo'];	
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}



	public static function getDataEmpleado(){
		$cod_emp = $_SESSION['identidad'];
		$sql = "SELECT	e.cod_emp, e.nombre_completo,b.co_ban,b.des_ban,(case 	when e.nac = 2 then 'E-' else 'V-' 	end  + 
		e.ci)as ci,e.cta_banc1,	e.fecha_ing,ca.co_cargo,ca.des_cargo FROM ".self::$tablename." e	
		inner join dbo.sncargo as ca on(ca.co_cargo = e.co_cargo)
		left join dbo.snbanco as b on(e.co_ban1 = b.co_ban)
		WHERE  e.cod_emp='".$cod_emp."' AND e.status = 'A'";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cod_emp = trim($r['cod_emp']);			
			$array[$cnt]->nombre_completo = $r['nombre_completo'];		
			$array[$cnt]->ci = $r['ci'];	
			$array[$cnt]->des_ban = $r['des_ban'];	
			$array[$cnt]->cta_banc1 = $r['cta_banc1'];	
			$array[$cnt]->fecha_ing =substr($r['fecha_ing'], 0, 10);  // abcd ;		
		
			$array[$cnt]->co_cargo = $r['co_cargo'];	
			$array[$cnt]->des_cargo = $r['des_cargo'];	
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	


	
	public static function getDataEmpleadoID($id){
		
		$sql = "SELECT	e.cod_emp, e.nombre_completo,b.co_ban,b.des_ban,(case 	when e.nac = 2 then 'E-' else 'V-' 	end  + 
		e.ci)as ci,e.cta_banc1,	e.fecha_ing,ca.co_cargo,ca.des_cargo,js.fechaEmision,js.asunto FROM snemple e	
		inner join dbo.sncargo as ca on(ca.co_cargo = e.co_cargo)
		inner join jm_solicitudes_personal js on e.cod_emp = js.cod_emp
		left join dbo.snbanco as b on(e.co_ban1 = b.co_ban)
		WHERE  js.id = $id";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		$valor=0;
		$promedio="";
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();
			$objeto_funciones = New FuncionesData();
			$data = $objeto_funciones->promedio($r['cod_emp']);
	
			$valor=number_format($data[0]->prom, 2, ',', '.');
	
		

			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->cod_emp = trim($r['cod_emp']);			
			$array[$cnt]->nombre_completo = $r['nombre_completo'];		
			$array[$cnt]->ci = trim($r['ci']);	
			$array[$cnt]->des_ban = $r['des_ban'];	
			$array[$cnt]->cta_banc1 = $r['cta_banc1'];	
			$array[$cnt]->fecha_ing =substr($r['fecha_ing'], 0, 10);  // abcd ;		
			$array[$cnt]->fecha_emision =$r['fechaEmision'];
			$array[$cnt]->co_cargo = $r['co_cargo'];	
			$array[$cnt]->asunto = $r['asunto'];	
			$array[$cnt]->promedio =$valor;
			$array[$cnt]->des_cargo = $r['des_cargo'];	
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