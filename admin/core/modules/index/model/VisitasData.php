<?php
class VisitasData {
	public static $tablename = "jm_visitas";
	//c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo 
	public function __construct(){
		$this->responsive_id = '';
		$this->co_vis = "";
		$this->co_ven = '0';
		$this->co_cli = "";
		$this->fecha = "";	
		$this->des_vis = "";	
		$this->dato1 ='0';		

	}

	public function add(){
		date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
		$co_ven = $_SESSION['identidad'];
		$sql = "INSERT INTO ".self::$tablename." (co_ven,co_cli,fecha,des_vis,lat,lon,status) ";
		$sql .= "VALUES ('$co_ven','$this->co_cli',GETDATE(),'$this->des_vis','$this->lat','$this->lon','1')";
		//echo $sql;
		Executor::doitEx($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estatus=0 where id='$this->id'";
		Executor::doit($sql);
	}

	public function delF(){
		$sql = "DELETE FROM  ".self::$tablename." where co_vis='$this->id'";
		Executor::doitEx($sql);
	}
	


	public static function getAllDatos(){
		$co_ven = $_SESSION['identidad'];

		$sql = "SELECT  v.co_vis,v.co_cli,v.co_ven,v.fecha,v.des_vis,v.status,c.cli_des FROM ".self::$tablename." v
		INNER JOIN vendedor ven ON v.co_ven = ven.co_ven
		INNER JOIN clientes c ON v.co_cli = c.co_cli
		WHERE ven.co_ven = '$co_ven'
		ORDER BY v.co_vis ASC";	
		/*
		$sql = "SELECT  c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo FROM ".self::$tablename." c 
		INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
		WHERE   c.inactivo = 0 
		ORDER BY c.co_cli ASC";	*/
		//echo $sql;
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			//nombre cedula fechaNacimiento  telefono telefono2 correo
			$fecha =substr($r['fecha'], 0, 10);
			$array[$cnt] = new VisitasData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_vis = $r['co_vis'];	
			$array[$cnt]->dato1 = $r['cli_des'];
			$array[$cnt]->fecha = $fecha;
			$array[$cnt]->des_vis = $r['des_vis'];						
			$array[$cnt]->status = $r['status'];
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public  function getDataObjeto(){
		$co_ven = $_SESSION['identidad'];

		$data=$this->ultima();
		$this->co_vis=$data['co_vis'];

		$sql = "SELECT  v.co_vis,v.co_cli,v.co_ven,v.fecha,v.des_vis,v.status,c.cli_des FROM ".self::$tablename." v
		INNER JOIN vendedor ven ON v.co_ven = ven.co_ven
		INNER JOIN clientes c ON v.co_cli = c.co_cli
		WHERE v.co_vis = $this->co_vis AND ven.co_ven = '$co_ven'
		ORDER BY v.co_vis ASC";	
		
		//echo $sql;

		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){
		$array = array();
		$cnt = 0;
		foreach($query as $r) {
			$fecha =substr($r['fecha'], 0, 10);
			
			$array[$cnt] = new VisitasData();  
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->co_vis = $r['co_vis'];	
			$array[$cnt]->dato1 = $r['cli_des'];
			$array[$cnt]->fecha = $fecha;
			$array[$cnt]->des_vis = $r['des_vis'];						
			$array[$cnt]->status = $r['status'];
		
		$cnt++;
		}
		return $array;
		}else{

				$array = array();
				return $array;
		}
	}

	public static function ultima(){
		$sql = "select max(co_vis) as co_vis from ".self::$tablename;
		$fact_num=Executor::doit($sql);
		//echo $fact_num;
		return $fact_num;
}

public static function getDataFiltrada($filtro){

	$co_ven = $_SESSION['identidad'];

	$sql = "SELECT  v.co_vis,v.co_cli,v.co_ven,v.fecha,v.des_vis,v.status,c.cli_des FROM ".self::$tablename." v
	INNER JOIN vendedor ven ON v.co_ven = ven.co_ven
	INNER JOIN clientes c ON v.co_cli = c.co_cli
	WHERE ven.co_ven = '$co_ven' and v.co_cli = '$filtro' 
	ORDER BY v.co_vis ASC";	
	//echo $sql;
	$query = Executor::doitAr($sql);
	$e=count($query);
	if($e>=1){
	$array = array();
	$cnt = 0;
	foreach($query as $r) {
		//nombre cedula fechaNacimiento  telefono telefono2 correo
		$fecha =substr($r['fecha'], 0, 10);
		$array[$cnt] = new VisitasData();  
		$array[$cnt]->responsive_id = "";  
		$array[$cnt]->co_vis = $r['co_vis'];	
		$array[$cnt]->dato1 = $r['cli_des'];
		$array[$cnt]->fecha = $fecha;
		$array[$cnt]->des_vis = $r['des_vis'];						
		$array[$cnt]->status = $r['status'];
	
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