<?php
class VendedorData {
	public static $tablename = "vendedor";	
	public function __construct(){
		$this->responsive_id = '';
		$this->co_ven = '0';
		$this->tipo = "";
		$this->ven_des = "";	
		$this->telefonos = "";
		$this->cedula ="";
		$this->direc1 ="0";
		$this->comisionv ="0";
		$this->dato1 ='0';		

	}


	public static function getAllDatos(){

		$sql = "SELECT  v.co_ven, v.ven_des,v.direc1,v.telefonos,v.comision,v.email,v.condic FROM ".self::$tablename." v WHERE   v.condic = 0 	ORDER BY v.co_ven ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {	
			$array[$cnt] = new VendedorData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_ven = $r['co_ven'];			
			$array[$cnt]->ven_des = $r['ven_des'];		
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->telefonos = $r['telefonos'];	
			$array[$cnt]->comision = $r['comision'];	
			$array[$cnt]->email = $r['email'];		
			$array[$cnt]->status = $r['condic'];		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function getDataId($id){
		$sql = "SELECT *  FROM ".self::$tablename." WHERE id=$id ORDER BY id ASC";	
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){		
			$array[$cnt] = new ClienteData();    
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->nombre = $r['nombre'];	
			$array[$cnt]->cedula = $r['cedula'];	
			$array[$cnt]->fechaNacimiento = $r['fechaNacimiento'];		
			$array[$cnt]->telefono = $r['telefono'];	
			$array[$cnt]->telefono2 = $r['telefono2'];	
			$array[$cnt]->correo = $r['correo'];			
			$array[$cnt]->estatus = $r['estatus'];		
		$cnt++;
		}
		return $array;
	}

	public static function getDataCedula($documento){
		$sql = "SELECT *  FROM ".self::$tablename." WHERE cedula='$documento' ORDER BY id ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new ClienteData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$found = $data;
			break;
		}
		return $found;
	}


	
}
?>