<?php
class CategoriaData {
	public static $tablename = "cat_art";
	
	public function __construct(){
		$this->id = '0';
		$this->categoria = "";
		$this->comentario = "";	
		$this->estatus ='0';
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (categoria,comentario,estatus) ";
		$sql .= "value (\"$this->categoria\",\"$this->comentario\",'1')";
		//echo $sql;
		Executor::doit($sql);
	}



	
	
	public static function getAll($estatus){
		$sql = "select *  from ".self::$tablename;	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoriaData();    
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->categoria = $r['categoria'];
			$array[$cnt]->comentario = $r['comentario'];
			$array[$cnt]->estatus = $r['estatus'];
		$cnt++;
		}
		return $array;
	}

	public static function getData($valor){
		$sql = "select *  from ".self::$tablename. " WHERE estatus = $valor";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoriaData();    
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->categoria = $r['categoria'];
			$array[$cnt]->comentario = $r['comentario'];
			$array[$cnt]->estatus = $r['estatus'];
		$cnt++;
		}
		return $array;
	}

	public static function foundId($id){		
		$sql = "SELECT
		COUNT(a.id) AS cuenta
	FROM
		articulo a
	JOIN ".self::$tablename. " c ON
		c.id = a.idCategoria
	WHERE
		a.estatus = 1 AND a.id = $id";
		echo $sql;	
		$query = Executor::doit($sql);
		return Model::one($query[0],new CategoriaData());
	}
	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->nombre = $r['nombre'];
			$data->nombreUsuario = $r['nombreUsuario'];
			$data->userLevel = $r['userLevel'];
			$data->estatus = $r['estatus'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllDatos(){
	

		$sql = "SELECT * FROM ".self::$tablename." WHERE estatus = 1 ";
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoriaData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->categoria = $r['categoria'];			
			$cnt++;		}
		return $array;
	}

	
}
?>