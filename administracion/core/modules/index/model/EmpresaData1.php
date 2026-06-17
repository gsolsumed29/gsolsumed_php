<?php
class EmpresaData {
	public static $tablename = "empresa";
	//id	direccion	valor	estatus
	public function __construct(){
		$this->responsive_id = '';
		$this->co_emp = '0';
		$this->name = "";
		$this->email = "";	
		$this->dir = "";	
		$this->telefonos = "";	
		$this->rif = "";	
		$this->image = "no_image.png";	
		$this->status ='0';
	}

	
	public function update(){
		$sql = "UPDATE ".self::$tablename." SET name='$this->name', email='$this->email', dir='$this->dir', telefonos='$this->telefonos',rif='$this->rif'  WHERE co_emp='001';";
		//echo $sql;
		$query = Executor::doitEx($sql);
	}
	
	
	public static function getAllDatos(){
		$sql = "SELECT *  FROM ".self::$tablename." e WHERE e.co_emp='001' ORDER BY e.co_emp ASC";	
		//echo $sql;
		$query = Executor::doitAr($sql);
		//print_r($query);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				$array[$cnt] = new EmpresaData();  
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->co_emp = $r['co_emp'];
				$array[$cnt]->name = $r['name'];				
				$array[$cnt]->email = $r['email'];	
				$array[$cnt]->dir = $r['dir'];		
				$array[$cnt]->telefonos = $r['telefonos'];	
				$array[$cnt]->rif = $r['rif'];	
				$array[$cnt]->image = $r['image'];		
				$array[$cnt]->status = $r['status'];			
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
		
	}

	
}
?>