<?php
class FuncionesData {
	public static $tablename = "users";
	
	public function __construct(){
		$this->id = '0';
		$this->cuenta = "";
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


	
}
?>