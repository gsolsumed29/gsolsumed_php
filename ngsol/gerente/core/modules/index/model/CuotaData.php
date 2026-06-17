<?php
class CuotaData {
	public static $tablename = "cuota";
		
		//id codigoContrato fecha  fechaPago estado numero estatus
	public function __construct(){		
		$this->id = '0';
		$this->codigoContrato = "";
		$this->fecha = "";
		$this->fechaPago = "";
		$this->estado = "0";
		$this->numero = "0";	
		$this->valor = "0";	
		$this->estatus = "0";	

	}	
	public function pagar(){
		
		$sql = "UPDATE ".self::$tablename." set fechaPago=\"$this->fechaPago\",estado=1  where codigoContrato='$this->codigoContrato' AND numero=$this->numero";
		Executor::doit($sql);
	}

	public function actualizar($valor){
		
		$sql = "UPDATE ".self::$tablename." set valor=$valor  where codigoContrato='$this->codigoContrato' AND estado=0";
		Executor::doit($sql);
	}

	public function actualizarPago($codigoContrato,$cuota){
		
		$sql = "UPDATE ".self::$tablename." set estado=0  where codigoContrato='$codigoContrato' AND numero=$cuota";
		//echo $sql;
		Executor::doit($sql);
	}


	public function del(){
		$sql = "update ".self::$tablename." set estatus=0 where id='$this->id'";
		Executor::doit($sql);
	}

	public static function getAllDatos(){
		$sql = "SELECT *  FROM ".self::$tablename." ORDER BY id ASC";	
		//echo $sql;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ContratoData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->codigo = $r['codigo'];	
			$array[$cnt]->idPoliza = $r['idPoliza'];	
			$array[$cnt]->fechaInicio = $r['fechaInicio'];		
			$array[$cnt]->fechaFinal = $r['fechaFinal'];	
			$array[$cnt]->frecuencia = $r['frecuencia'];	
			$array[$cnt]->numero = $r['numero'];
			$array[$cnt]->valor = $r['valor'];				
			$array[$cnt]->estatus = $r['estatus'];			
		$cnt++;
		}
		return $array;
	}

	public static function getAllDatosInner(){
		$sql = "SELECT 
		c.id as cid,c.codigo as codigo,p.id as pid,p.numero as pnumero,cl.nombre as cnombre,p.tipo as ptipo,a.aseguradora as aseguradora,
		c.frecuencia as frecuencia,c.numero as cnumero,c.fechaInicio as fi,c.fechaFinal as fn,c.estatus as estatus  FROM ".self::$tablename." c
		INNER JOIN poliza p ON c.idPoliza = p.id
		INNER JOIN cliente cl ON p.idCliente = cl.id 
		INNER JOIN aseguradora a ON p.idAseguradora = a.id ORDER BY c.id ASC";	
		//$sql = "SELECT *  FROM ".self::$tablename." ORDER BY id ASC";	
	//	echo $sql;
		//id	idSucursal	idAseguradora	idAsegurado	numero	idCliente	tipo 1-autos 2-estructura 3-otros 4-personal	estatus

		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){

			//$cliente = ClienteData::getById($r['idc']);
			//$aseguradora = AseguradoraData::getById($r['idas']);
			//$sucursal = SucursalData::getById($r['ids']);

			$array[$cnt] = new ContratoData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['cid'];
			$array[$cnt]->otro3 = $r['pnumero'];	
			$array[$cnt]->otro4 = $r['pid'];	
			$array[$cnt]->otro = $r['cnombre'];			
			$array[$cnt]->idPoliza = $r['ptipo'];	
			$array[$cnt]->otro2 = $r['aseguradora'];				
			$array[$cnt]->fechaInicio = $r['fi'];		
			$array[$cnt]->fechaFinal = $r['fn'];	
			$array[$cnt]->frecuencia = $r['frecuencia'];	
			$array[$cnt]->numero = $r['cnumero'];	
			$array[$cnt]->estatus = $r['estatus'];				
		$cnt++;
		}
		return $array;
	}

	public static function getDataCodigo($codigo){
		$sql = "SELECT *  FROM ".self::$tablename." WHERE codigoContrato ='$codigo' ORDER BY id ASC";
		
			//echo $sql;
	

		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){

		//id codigoContrato fecha fechaPago estado numero valor estatus

			$array[$cnt] = new CuotaData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['id'];		
			$array[$cnt]->codigoContrato = $r['codigoContrato'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->fechaPago =$r['fechaPago'];
			$array[$cnt]->estado = $r['estado'];			
			$array[$cnt]->estatus = $r['estatus'];				
		$cnt++;
		}
		return $array;
	}

	public static function getDataObjeto($codigo){
		$sql = "SELECT *  FROM ".self::$tablename." WHERE codigo ='$codigo' ORDER BY id ASC";
		
			//echo $sql;
	

		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){

		
			$array[$cnt] = new PagoData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['id'];		
			$array[$cnt]->codigo = $r['codigo'];
			$array[$cnt]->idContrato = $r['idContrato'];
			$array[$cnt]->estado =$r['estado'];
			$array[$cnt]->numeroRecibo = $r['numeroRecibo'];
			$array[$cnt]->fecha = $r['fecha'];	
			$array[$cnt]->referencia = $r['referencia'];		
			$array[$cnt]->fechaOperacion = $r['fechaOperacion'];	
			$array[$cnt]->factura = $r['factura'];	
			$array[$cnt]->fechaFactura = $r['fechaFactura'];	
			$array[$cnt]->prima = $r['prima'];	
			$array[$cnt]->comision = $r['comision'];	
			$array[$cnt]->bono = $r['bono'];	
			$array[$cnt]->cuota = $r['cuota'];			
			$array[$cnt]->estatus = $r['estatus'];				
		$cnt++;
		}
		return $array;
	}

	public static function getDataId($id){
		// id codigo idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura
		// prima comision bono forma cuota estatus
		$sql = "SELECT *  FROM ".self::$tablename." WHERE idContrato =$id ORDER BY id ASC";
		//echo $sql;	
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){			
			$array[$cnt] = new PagoData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['id'];		
			$array[$cnt]->codigo = $r['codigo'];
			$array[$cnt]->idContrato = $r['idContrato'];
			$array[$cnt]->estado =$r['estado'];
			$array[$cnt]->numeroRecibo = $r['numeroRecibo'];
			$array[$cnt]->fecha = $r['fecha'];	
			$array[$cnt]->referencia = $r['referencia'];		
			$array[$cnt]->fechaOperacion = $r['fechaOperacion'];	
			$array[$cnt]->factura = $r['factura'];	
			$array[$cnt]->fechaFactura = $r['fechaFactura'];	
			$array[$cnt]->prima = $r['prima'];	
			$array[$cnt]->comision = $r['comision'];	
			$array[$cnt]->bono = $r['bono'];	
			$array[$cnt]->cuota = $r['cuota'];			
			$array[$cnt]->estatus = $r['estatus'];			
		$cnt++;
		}
		return $array;
	}
	public static function getDataKeyId($key,$idPoliza){
		$sql = "SELECT *  FROM ".self::$tablename." WHERE ".$key." =$idPoliza ORDER BY id ASC";	
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){			
			$array[$cnt] = new PagoData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idPoliza = $r['idPoliza'];
			$array[$cnt]->codigo = $r['codigo'];
			$array[$cnt]->fechaInicio =$r['fechaInicio'];
			$array[$cnt]->fechaFinal = $r['fechaFinal'];
			$array[$cnt]->frecuencia = $r['frecuencia'];	
			$array[$cnt]->plazo = $r['plazo'];		
			$array[$cnt]->numero = $r['numero'];			
			$array[$cnt]->estatus = $r['estatus'];				
		$cnt++;
		}
		return $array;
	}
	
	public static function getCuotasReporte($tipo,$aseguradora,$sucursal,$desde,$hasta){
		if($aseguradora==999999999){
			if($sucursal==999999999){
				$sql = "SELECT 
				c.id as cid,p.numero as pnumero,cl.nombre as cnombre,cl.cedula as clcedula,a.aseguradora as aseguradora,
				cc.fechaInicio as fi,cc.fechaFinal as fn,s.sucursal as sucursal,c.fechaPago as cfecha  FROM ".self::$tablename." c
				INNER JOIN contrato cc ON cc.codigo = c.codigoContrato
				INNER JOIN poliza p ON cc.idPoliza = p.id
			
				INNER JOIN cliente cl ON p.idCliente = cl.id 
				INNER JOIN aseguradora a ON p.idAseguradora = a.id 
				INNER JOIN sucursal s ON p.idSucursal = s.id 
		
				WHERE c.estado =$tipo AND c.fecha BETWEEN '$desde' AND '$hasta' ORDER BY c.id ASC";	

			}else{

				$sql = "SELECT 
				c.id as cid,p.numero as pnumero,cl.nombre as cnombre,cl.cedula as clcedula,a.aseguradora as aseguradora,
				cc.fechaInicio as fi,cc.fechaFinal as fn,s.sucursal as sucursal,c.fechaPago as cfecha  FROM ".self::$tablename." c
				INNER JOIN contrato cc ON cc.codigo = c.codigoContrato
				INNER JOIN poliza p ON cc.idPoliza = p.id
			
				INNER JOIN cliente cl ON p.idCliente = cl.id 
				INNER JOIN aseguradora a ON p.idAseguradora = a.id 
				INNER JOIN sucursal s ON p.idSucursal = s.id 

				WHERE s.id=$sucursal AND c.estado =$tipo AND c.fecha BETWEEN '$desde' AND '$hasta' ORDER BY c.id ASC";	
			}
		
			
		}else{
			$sql = "SELECT 
			c.id as cid,p.numero as pnumero,cl.nombre as cnombre,cl.cedula as clcedula,a.aseguradora as aseguradora,
			cc.fechaInicio as fi,cc.fechaFinal as fn,s.sucursal as sucursal,c.fechaPago as cfecha  FROM ".self::$tablename." c
			INNER JOIN contrato cc ON cc.codigo = c.codigoContrato
			INNER JOIN poliza p ON cc.idPoliza = p.id
		
			INNER JOIN cliente cl ON p.idCliente = cl.id 
			INNER JOIN aseguradora a ON p.idAseguradora = a.id 
			INNER JOIN sucursal s ON p.idSucursal = s.id 

			WHERE A.id=$aseguradora AND c.estado =$tipo AND c.fecha BETWEEN '$desde' AND '$hasta' ORDER BY c.id ASC";	
		}
		
		//$sql = "SELECT *  FROM ".self::$tablename." ORDER BY id ASC";	
		//echo $sql;
		//id	idSucursal	idAseguradora	idAsegurado	numero	idCliente	tipo 1-autos 2-estructura 3-otros 4-personal	estatus

		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){

			//$cliente = ClienteData::getById($r['idc']);
			//$aseguradora = AseguradoraData::getById($r['idas']);
			//$sucursal = SucursalData::getById($r['ids']);

			$array[$cnt] = new ContratoData();  
			$array[$cnt]->responsive_id = "0";  
			$array[$cnt]->id = $r['cid'];
			$array[$cnt]->otro1 = $r['pnumero'];				
			$array[$cnt]->otro2 = $r['fi'];	
			$array[$cnt]->otro3 = $r['fn'];		
			$array[$cnt]->otro4 = $r['cnombre'];
			$array[$cnt]->otro5 = $r['clcedula'];
			$array[$cnt]->otro6 = $r['aseguradora'];
			$array[$cnt]->otro7 = $r['sucursal'];
			$array[$cnt]->otro8 = $r['cfecha'];
		$cnt++;
		}
		return $array;
	}
}
?>