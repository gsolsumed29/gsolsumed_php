<?php
class IpData {
	public static $tablename = "iplog";


	public function __construct(){
		$this->id = '0';
		$this->user_id = "";	
		$this->realip = '0';
		$this->region = '0';
		$this->regionCode = '0';
		$this->regionName = '0';
		$this->dmaCode = '0';
		$this->countryName = '0';
		$this->countryCode = '0';
		$this->inEU = '0';
		$this->euVATrate = '0';
		$this->latitude = '0';
		$this->longitude = '0';
		$this->timezone = '0';
		$this->locationAccuracyRadius = '0';
		$this->created_at = "NOW()";		
		$this->estatus = "";	
	

	}	

	//user_id,realip,city,region,regionCode,regionName,dmaCode,countryName,countryCode,inEU,euVATrate,latitude,longitude,timezone,locationAccuracyRadius,created_at
		public function add(){
		$sql = "insert into ".self::$tablename." (user_id,realip,city,region,regionCode,regionName,dmaCode,countryName,countryCode,inEU,euVATrate,latitude,longitude,timezone,locationAccuracyRadius,created_at,estatus) ";
		$sql .= "value (\"$this->user_id\",\"$this->realip\",\"$this->city\",\"$this->region\",\"$this->regionCode\",\"$this->regionName\",\"$this->dmaCode\",\"$this->countryName\",\"$this->countryCode\",\"$this->inEU\",\"$this->euVATrate\",\"$this->latitude\",\"$this->longitude\",\"$this->timezone\",\"$this->locationAccuracyRadius\",$this->created_at,'1')";
		//echo $sql;
		Executor::doit($sql);
	}
	

	public static function getAll(){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY Pais ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PaisData();    
			$array[$cnt]->codigo = $r['Codigo'];
			$array[$cnt]->pais = $r['Pais'];		
		$cnt++;
		}
		return $array;
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE Codigo='$id'";
		//echo $sql;
		$query = Executor::doit($sql);
		$found = null;
		$data = new PaisData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['Codigo'];
			$data->pais = $r['Pais'];			
			$found = $data;
			break;
		}
		return $found;
	}

	
}
?>