<?php
class ClienteData {
	public static $tablename = "clientes";
	//c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo 
	public function __construct(){
		$this->responsive_id = '';
		$this->co_cli = '0';
		$this->rif = "";
		$this->cli_des = "";	
		$this->telefonos = "";
		$this->email ="";
		$this->direc1 ="0";
		$this->dir_ent2 ="0";
		$this->dato1 ='0';	

		$this->mont_cre ='0';	
		$this->plaz_pag ='0';	
		$this->saldo ='0';	
		$this->ultima ='0';	

	}

	public function add(){
		$sql = "insert into ".self::$tablename." (nombre,cedula,fechaNacimiento,telefono,telefono2,correo,estatus) ";
		$sql .= "value (\"$this->nombre\",\"$this->cedula\",\"$this->fechaNacimiento\",\"$this->telefono\",\"$this->telefono2\",\"$this->correo\",'1')";
		//echo $sql;
		Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET nombre=\"$this->nombre\",cedula=\"$this->cedula\",fechaNacimiento=\"$this->fechaNacimiento\",telefono=\"$this->telefono\",telefono2=\"$this->telefono2\",correo=\"$this->correo\"  where id=$this->id";
		//echo $sql;
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estatus=0 where id='$this->id'";
		Executor::doit($sql);
	}

	public function delF(){
		$sql = "DELETE FROM  ".self::$tablename." where id='$this->id'";
		Executor::doit($sql);
	}
	
	public static function getAllDatosGerencia(){		
		
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 
		ORDER BY c.co_cli ASC";	
		
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$array[$cnt] = new ClienteData();  
			$objeto_funciones = New FacturaData();
			$data =$objeto_funciones->getSaldoPorCobrar($r['co_cli']);
			$data2 =$objeto_funciones->getUltimaFactura($r['co_cli']);
			
			$saldo=$data[0]->saldo;
			$ultima=$data2[0]->fecha;
			
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];
			$array[$cnt]->saldo_p =  (float)$saldo;
			$array[$cnt]->ultima_f = substr($ultima, 0, 10);  // abcd ;;
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function getAllDatos(){		
		$co_ven = $_SESSION['identidad'];
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email,c.mont_cre,c.plaz_pag, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 AND c.co_ven = '$co_ven'
		ORDER BY c.co_cli ASC";	
		
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$array[$cnt] = new ClienteData();  
			$objeto_funciones = New FacturaData();
			$data =$objeto_funciones->getSaldoPorCobrar($r['co_cli']);
			$data2 =$objeto_funciones->getUltimaFactura($r['co_cli']);
			
			$saldo=$data[0]->saldo;
			$ultima=$data2[0]->fecha;
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];
			$array[$cnt]->saldo_p = $saldo;
			$array[$cnt]->ultima_f = $ultima;
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}
	

	public static function getDataFiltrada($filtro){

		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1,c.mont_cre,c.plaz_pag, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE c.co_cli = '".$filtro."' AND c.inactivo = 0 
		ORDER BY c.co_cli ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			
			$array[$cnt] = new ClienteData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->co_cli = $r['co_cli'];			
			$array[$cnt]->rif = $r['rif'];	
			$array[$cnt]->cli_des = $r['cli_des'];	
			$array[$cnt]->telefonos = $r['telefonos'];		
			$array[$cnt]->email = $r['email'];	
			$array[$cnt]->direc1 = $r['direc1'];	
			$array[$cnt]->dir_ent2 = $r['dir_ent2'];			
			$array[$cnt]->des_tipo = $r['des_tipo'];
			
			$array[$cnt]->mont_cre = (float)$r['mont_cre'];
			$array[$cnt]->plaz_pag = $r['plaz_pag'];
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}


	
	public static function getAllDatosFiltrados($id){	

		/// Metodo para consultar todos los datos para el
			// solo para adminsitrador
			$sql ="SELECT c.co_cli, c.cli_des FROM ".self::$tablename." c WHERE c.co_ven='$id' and c.inactivo = 0 ORDER BY c.co_cli ASC";	
			//echo $sql;
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				
				foreach($query as $r) {
				$array[$cnt] = new ClienteData(); 
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_cli = $r['co_cli'];
				$array[$cnt]->cli_des = $r['cli_des'];
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