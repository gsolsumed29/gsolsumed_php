<?php
class Database {
	public static $db;
	public static $con;

	public function __construct(){
	
		
		$this->driver = "sqlsrv";	
		$this->serverName=SERVERNAME;
		$this->port="1433";
		$this->dbName=DBNAME;
		$this->charset="utf8";
		$this->user=USERNAME;
		$this->pass=PASSWORD;	
		
	}

	function connect(){

		try {
			$con=new PDO("{$this->driver}:server={$this->serverName};Database={$this->dbName};encrypt=false;TrustServerCertificate=true", $this->user, $this->pass);
			//con = new PDO("sqlsrv:server=$this->serverName;database=$this->database","encrypt= FALSE", $this->user, $this->password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $con;
		} catch (Exception $e) {
			error_log("DB connection failed: " . $e->getMessage());
			header('Content-Type: application/json', true, 500);
			die(json_encode(["error" => "DB connection failed"]));
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
