<?php
class ParametroData {
	public static $tablename = "jm_parametro";

		public $responsive_id;
		public $id;
		public $tipo;
		public $ven_des;
		public $co_ven;
		public $valor;
		public $finicio;
		public $ffinal;
		public $estatus;

	public function __construct(){
	
		$this->responsive_id='0';
		$this->id='0';
		$this->tipo='0';
		$this->ven_des='0';
		$this->co_ven='0';
		$this->valor='0';
		$this->finicio='0';
		$this->ffinal='0';
		$this->estatus='0';


	}	

	
	public function add(){
		
		$sql = "insert into ".self::$tablename." (co_type,co_ven,valor,finicio,ffinal,status) ";
		$sql .= "values ($this->co_type,'$this->co_ven',$this->valor,'$this->finicio','$this->ffinal',1)";
		//echo $sql;
		Executor::doitEx($sql);
		
		//echo "guarde";
	}
	
	public function edit(){
		
		$sql = "update ".self::$tablename." set marca=\"$this->marca\",idTipo=$this->idTipo where id='$this->id'";
		//echo $sql;
		Executor::doit($sql);
	}

	public static function getAll(){	

		$sql = "SELECT p.id,t.tipo,v.ven_des,v.co_ven,p.valor,p.finicio,p.ffinal,p.status FROM ".self::$tablename." p 
		INNER JOIN jm_type t ON p.co_type = t.id
		INNER JOIN vendedor v ON p.co_ven = v.co_ven";
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){
			$array = array();
			$cnt = 0;	

		foreach($query as $r) {
			$array[$cnt] = new ParametroData();
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->ven_des = $r['ven_des'];
			$array[$cnt]->co_ven = $r['co_ven'];
			$array[$cnt]->valor = $r['valor'];
			$array[$cnt]->finicio = $r['finicio'];
			$array[$cnt]->ffinal = $r['ffinal'];
			$array[$cnt]->estatus = $r['status'];
			$cnt++;		
		}
		return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function getById($id){
		$sql = "SELECT m.id,t.tipo,m.idTipo,t.condicion,m.estatus,m.marca FROM ".self::$tablename." m INNER JOIN tipo t ON m.idTipo = t.id  WHERE m.id='$id'";
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){	
			$array[$cnt] = new MarcaData();
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idTipo = $r['idTipo'];
			$array[$cnt]->marca = $r['marca'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->condicion = $r['condicion'];
			$array[$cnt]->estatus = $r['estatus'];
				
		$cnt++;
		}
		return $array;
	}

	public static function getByCampo($campo,$valor){
$sql = "SELECT m.id,t.tipo,m.idTipo,t.condicion,m.estatus,m.marca FROM ".self::$tablename." m INNER JOIN tipo t ON m.idTipo = t.id     WHERE $campo='$valor'  ORDER BY t.id ASC";
		
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
		
			$array[$cnt] = new MarcaData();
			$array[$cnt]->responsive_id = "";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idTipo = $r['idTipo'];
			$array[$cnt]->marca = $r['marca'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->condicion = $r['condicion'];
			$array[$cnt]->estatus = $r['estatus'];
				
		$cnt++;
		}
		return $array;
	}

	
}
?>