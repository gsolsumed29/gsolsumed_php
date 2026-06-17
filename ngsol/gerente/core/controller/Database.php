<?php
class Database {
	public static $db;
	public static $con;

	public function __construct(){

		$this->driver = "sqlsrv";	
		$this->serverName="DESKTOP-J6LJ35I\SQLEXPRESS";
		$this->port="1433";
		$this->dbName="MOR_PRUE";
		$this->charset="utf8";
		$this->user="jmobile";
		$this->pass="123456789";	
/*
		$this->driver = "sqlsrv";	
		$this->serverName="192.168.168.1";
		$this->port="1433";
		//$this->dbName="MOR_PRUE";
		$this->dbName="MOR_PRUE";
		$this->charset="utf8";
		$this->user="profit";
		$this->pass="profit";		
	
	*/
		
	}

	function connect(){

		try {
			$con=new PDO("{$this->driver}:server={$this->serverName};Database={$this->dbName};encrypt = false", $this->user, $this->pass);
			//con = new PDO("sqlsrv:server=$this->serverName;database=$this->database","encrypt= FALSE", $this->user, $this->password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $con;
		} catch (Exception $e) {
			die("Ocurrió un error con la base de datos: " . $e->getMessage());
		}
				
	}

	static function closeConnection($conn) {
		//echo "Cerrando la conexion";
		$conn=null;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}
	
}
?>
