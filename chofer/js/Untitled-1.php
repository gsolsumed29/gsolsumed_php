	
	public static function getFacturasInventario($co_cli,$filtro){
		if($filtro=='0') $filtro='';
		if($filtro=='2') $filtro='1';
		
		$sql ="select f.fact_num, f.fec_emis, c.cli_des, co.dias_cred from factura f inner join clientes c on f.co_cli = c.co_cli 
		join condicio co on f.forma_pag = co.co_cond where c.co_zon= $co_cli and len(f.campo1)='".$filtro."'";

	
		//
		//echo $sql;
		$query = Executor::doitAr($sql);	
		$e=count($query);		
		if($e>=1){
			$array = array();
			$cnt = 0;	
			$status=0;
			foreach($query as $r) {				
				
			$array[$cnt] = new FacturaData(); 				
			$array[$cnt]->dato1 =  	trim($r['fact_num']);		
			$array[$cnt]->dato2 =   substr($r['fec_emis'], 0, 10);
			$array[$cnt]->dato3 =   $r['cli_des'];
			$array[$cnt]->dato4 =	$r['dias_cred'];
						
			$cnt++;
		}
		return $array;
		}else{
				$array = array();
				return $array;
		}

	}




	public function despachar(){
		$co_ven =$_SESSION['identidad'];	
		date_default_timezone_set('America/Caracas');
		$date = strftime("%Y-%m-%d 00:00:00", time());

	 	$dias = $this->dias;

		 $mod_date = strtotime($date."+ ".$dias." days");
		$datemasdias = date("Y-m-d 00:00:00",$mod_date);
	
		$sql = "UPDATE ".self::$tablename." SET campo1 = '1' ,campo2 = '$date',campo3='$co_ven' WHERE fact_num ='$this->id'";
		Executor::doitEx($sql);

		echo $sql;

		$sql="Update factura set fec_venc ='$datemasdias' where fact_num ='$this->id'";
		
		Executor::doitEx($sql);

		$sql="Update docum_cc set fec_venc ='$datemasdias' where tipo_doc='fact' and nro_doc = '$this->id'";	
		
		Executor::doitEx($sql);

		
	}