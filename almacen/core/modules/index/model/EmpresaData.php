<?php
class EmpresaData {
	public static $tablename = "jm_empresa";
	//id	direccion	valor	estatus
	public function __construct(){
		$this->responsive_id = '';
		$this->co_emp = '0';
		$this->name = "";
		$this->email = "";	
		$this->email_ventas = "";	
		$this->email_cobros = "";	
		$this->dir = "";	
		$this->telefonos = "";	
		$this->rif = "";	
		$this->image = "no_image.png";	
		$this->status ='0';
		
	
		$this->co_emp_mail ='0';
		$this->text ='0';
		$this->smtp ='0';
		$this->password ='0';
		$this->host ='0';
		$this->port ='0';
	}

	
	public function update(){
		$sql = "UPDATE ".self::$tablename." SET name='$this->name', email='$this->email',email_ventas='$this->email_ventas',email_cobros='$this->email_cobros', dir='$this->dir', telefonos='$this->telefonos',rif='$this->rif'  WHERE co_emp='001';";
		//echo $sql;
		$query = Executor::doitEx($sql);
	}

	public function updateCorreo(){
		$sql = "UPDATE jm_empresa_email SET text='$this->text', smtp='$this->smtp', password='$this->password', host='$this->host',port='$this->port'  WHERE co_emp='001';";
		//echo $sql;
		$query = Executor::doitEx($sql);
	}
	
	public static function getAllDatos(){
		$sql = "SELECT *  FROM ".self::$tablename." e WHERE e.co_emp='01' ORDER BY e.co_emp ASC";	
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
				$array[$cnt]->email_ventas = $r['email_ventas'];	
				$array[$cnt]->email_cobros = $r['email_cobros'];	
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

	
	public static function getAllDatosCorreo(){
		$sql = "SELECT ee.text,ee.smtp,ee.password,ee.host,ee.port,e.email,e.email_ventas,e.email_cobros  FROM jm_empresa_email ee 
		INNER JOIN jm_empresa e ON ee.co_emp = e.co_emp WHERE ee.co_emp='01' ORDER BY ee.co_emp ASC";	
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
			
				$array[$cnt]->text = $r['text'];				
				$array[$cnt]->smtp = $r['smtp'];	
				$array[$cnt]->password = $r['password'];		
				$array[$cnt]->host = $r['host'];	
				$array[$cnt]->port = $r['port'];	
				$array[$cnt]->email = $r['email'];
				$array[$cnt]->email_ventas = $r['email_ventas'];
				$array[$cnt]->email_cobros = $r['email_cobros'];
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