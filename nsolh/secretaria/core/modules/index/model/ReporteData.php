<?php
class ReporteData {
	public static $tablename = "reporte";	
		public function __construct(){
		$this->dato = 0;		$this->dato5 = "";				
		$this->dato1 ='';		
		$this->dato2 ='';		
		$this->dato3 ='';		
		$this->dato4 ='';	

	}

		public  function generarKey(){
			$alphabet = "0123456789ABCDEFGHIJKLMNOPQSTUWXYZabcdefghijqlmnopqrstuvwxyz";
			$pass = array(); //recuerde que debe declarar $pass como un array
			$alphaLength = strlen($alphabet) - 1; //poner la longitud -1 en caché
			for ($i = 0; $i < 8; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass); //convertir el array en una cadena
		}				
		

		public static function generarReportePedido($reci_num,$status){	
			
			     
			$objeto_empleado = New VendedorData();    
			$result2 = $objeto_empleado->GetDataEmpleado();  
			$reci_num=$_GET['reci_num'];
			$objeto_nomina = New NominaData();          
			$result = $objeto_nomina->GetNomina($reci_num);
			//
			$pdf = new PDF($orientation='L',$unit='mm');
			$pdf->AddPage();
			
			$textypos = 5;
		
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(10);
			$pdf->setX(40);	
			$pdf->Cell(279,45,"A.C Colegio San Pedro",0,0,"L");
			$pdf->SetFont('Arial','B',15);    
			$pdf->setX(10);	
			$pdf->Cell(279,30,"RECIBO DE PAGO NOMINA",1,0,"C");			
			$pdf->Image('../app-assets/images/logo/logo_recibo.jpg' , 15 ,12, 25 , 25,'JPG');
			$pdf->SetFont('Arial','B',12);    
			$pdf->setY(22);
			$pdf->setX(235);
			$pdf->Cell(5,$textypos,utf8_decode("N° RECIBO:").$reci_num);
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(42);
			$pdf->setX(10);
			$pdf->Cell(5,$textypos,"FECHA:".$result[0]->fec_emis);
			$pdf->setX(120);
			$pdf->Cell(5,$textypos,"PERIODO DESDE:".$result[0]->fec_ini);
			$pdf->setX(257);
			$pdf->Cell(5,$textypos,"HASTA:".$result[0]->fec_ini);
			$pdf->setY(47);
			$pdf->setX(10);
			$pdf->Line(10, 48, 288,48);
			$pdf->setY(49);
			$pdf->setX(10);
			$pdf->Cell(279,20,"",1,0,"C");
			$pdf->setX(10);
			$pdf->setY(50);
			$pdf->SetFont('Arial','',10);    
			$pdf->Cell(5,$textypos,"TRABAJADOR: ".$result2[0]->cod_emp."-".$result2[0]->nombre_completo);

			$pdf->setY(55);
			$pdf->Cell(5,$textypos,"DEPARTAMENTO: ".$result[0]->des_depart);
			$pdf->setY(60);
			$pdf->Cell(5,$textypos,"CATEGORIA: 0");
			
			$pdf->setY(50);$pdf->setX(135);
			$pdf->Cell(5,$textypos,utf8_decode("CÉDULA: ").$result2[0]->ci);
			
			$pdf->setY(55);$pdf->setX(135);
			$pdf->Cell(5,$textypos,utf8_decode("CARGO: ").$result2[0]->des_cargo);

			$pdf->setY(60);$pdf->setX(135);
			$pdf->Cell(5,$textypos,utf8_decode("SUELDO MENSUAL: ").number_format($result[0]->SueldoMensVar, 2, ',', '.')." BsD");

			$pdf->setY(50);$pdf->setX(230);
			$pdf->Cell(5,$textypos,utf8_decode("FECHA DE INGRESO: ").$result2[0]->fecha_ing);

			$pdf->setY(60);$pdf->setX(230);
			$pdf->Cell(5,$textypos,utf8_decode("SUELDO DIARIO: ").number_format($result[0]->Sueldo_diario, 2, ',', '.')." BsD");

			$pdf->SetFont('Arial','B',10);    
			$pdf->Ln();
			$pdf->setY(70);
			$pdf->setX(10);
			$header = array(utf8_decode("CODIGO"), utf8_decode("DESCRIPCION"),"VALOR AUXILIAR","ASIGNACIONES","DEDUCCIONES","NETO A COBRAR");
	
		
			// Column widths
			$w = array(20, 115, 45, 33, 33,33);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			$totalAsignaciones=0;
			$totalDeducciones=0;
		  	$totalArticulos = 0;
			  $pdf->SetFont('Arial','',10);    
			foreach($result as $dato)

			{   
			
				$co_conce = $dato->co_conce;
				$des_conce = $dato->des_conce;                                           
				$valor_auxiliar=  $dato->auxi_num.''.$dato->auxi_cha;
				$tipo =  $dato->tipo;    
			
  			
				$pdf->Cell($w[0],6,$co_conce,0);
				$pdf->Cell($w[1],6, utf8_decode($des_conce),0,0,'L');
				$pdf->Cell($w[2],6,utf8_decode($valor_auxiliar),0,0,'C');
				if($tipo ==3) {
					$monto =   $dato->monto*-1; 
					$totalDeducciones =  $totalDeducciones+$monto;
					$pdf->Cell($w[4],6,' ','0',0,'R');
					$pdf->Cell($w[4],6,number_format($monto, 2, ',', '.').' BsD','0',0,'R');
				
				}else{
					$monto =  $dato->monto;
					$totalAsignaciones = $totalAsignaciones+$monto;
					$pdf->Cell($w[3],6,number_format($monto, 2, ',', '.').' BsD','0',0,'R');
					$pdf->Cell($w[4],6,' ','0',0,'R');
				
				}
				
				
				$pdf->Cell($w[4],6,' ','0',0,'R');
				$pdf->Ln();
				//$total+= $precio*$cantidad;


  		  }

		  //// Apartir de aqui esta la tabla con los subtotales y totales
		  $yposdinamic =  40 + (count($result)*10);
		
		 $totalLetras = $totalAsignaciones+$totalDeducciones;
		 $letrasTexto = $objeto_nomina->number_words($totalLetras,"bolivares","y","centimos");
		  $pdf->setY($yposdinamic);
		  //$pdf->setX(235);
		  $pdf->Ln();
		  //$pdf->Line(10, $yposdinamic+10, 200, $yposdinamic+10);
		 $pdf->Line(10, $yposdinamic+20, 288, $yposdinamic+20);
		 $pdf->Ln();
		 $pdf->setY($yposdinamic+20);
		 $pdf->Cell(135,25,utf8_decode("He recibido conforme : _________________________________________"),1,0,"C");
		 $pdf->setX(145);
		 $pdf->Cell(145,25,utf8_decode(""),1,0,"C");
 		 $pdf->setX(145);
		 $pdf->Cell(145,12,utf8_decode(""),1,0,"C");
		 $pdf->setX(145);
		 $pdf->Cell(45,12,'Total trabajador:',1,0,'C');
		 $pdf->SetFont('Arial','B',10);    
		 $pdf->Cell(33,12,number_format($totalAsignaciones, 2, ',', '.').' BsD',1,0,'C');
		 $pdf->Cell(33,12,number_format($totalDeducciones, 2, ',', '.').' BsD',1,0,'C');
		 $pdf->Cell(34,12,number_format($totalAsignaciones+$totalDeducciones, 2, ',', '.').' BsD',1,0,'C');
		 $pdf->SetFont('Arial','',10);    
		 $pdf->setY($yposdinamic+35);
			$pdf->setX(145);
			$pdf->Cell(5,$textypos,"BANCO:".$result[0]->des_ban);
			$pdf->setY($yposdinamic+40);
			$pdf->setX(145);
			$pdf->Cell(5,$textypos,"CUENTA:".$result[0]->cta_banc1);
				 $pdf->SetFont('Arial','',10);    
				 $pdf->setX(10);
				 
			//$pdf->Cell(5,25,utf8_decode("He recibido conforme ".$letrasTexto.""),0,0,"R");
			$pdf->Cell(150,50,utf8_decode('He recibido conforme: '.$letrasTexto.''),0,1,'FJ',0);
			$pdf->setY($yposdinamic+45);
			$pdf->setX(10);
			$pdf->Cell(130,50,utf8_decode('de manera conforme a lo establecido en este comprobante de pago'),0,1,'FJ',0);
			//$pdf->Cell(5,25,utf8_decode("de manera conforme a lo establecido en este comprobante de pago"),0,0,"R");
			
			$pdf->setY($yposdinamic+60);
			$pdf->setX(100);
			$pdf->Cell(210,25,utf8_decode("__________________________ "),0,0,"C");
				$pdf->setY($yposdinamic+64);
				$pdf->setX(102);
			$pdf->Cell(210,25,utf8_decode("Autorizado por "),0,0,"C");

			$pdf->Image('../app-assets/images/logo/firma.jpg' , 195 ,$yposdinamic+47, 25 , 25,'JPG');
			
					$pdf->Output("I","Recibo_pago".$reci_num.".pdf",true);
			

		}

		public function addSolicitudConstancia($asunto,$tipo){
			$cod_emp =$_SESSION['identidad'];

			$date = strftime("%Y-%m-%d %H:%M:%S", time());
			$sql = "INSERT INTO jm_solicitudes_personal (cod_emp,tipo,asunto,fechaEmision,estatus)";
			$sql .= "VALUES ('$cod_emp',$tipo,'$asunto','$date',1)";
			//echo $sql;
			Executor::doitEx($sql);
		}


		public static function getAllSolicitudes(){
			/// Metodo para consultar todos los datos y mostrar las tabla
			$cod_emp =$_SESSION['identidad'];
				
				$sql ="select id,asunto,fechaEmision,estatus,tipo from jm_solicitudes_personal where cod_emp = '".$cod_emp."';";
				//echo $sql;
			
			$query = Executor::doitAr($sql);	
			$e=count($query);		
			if($e>=1){
				$array = array();
				$cnt = 0;	
				foreach($query as $r) {
				$array[$cnt] = new ReporteData(); 
				$array[$cnt]->responsive_id = "";  
				$array[$cnt]->id = $r['id'];		
				$array[$cnt]->tipo = $r['tipo'];		
				$array[$cnt]->asunto =$r['asunto'];
				$array[$cnt]->fechaEmision = $r['fechaEmision'];
				$array[$cnt]->estatus = $r['estatus'];
				$cnt++;
			}
			return $array;
			}else{
					$array = array();
					return $array;
			}
		}


	public static function generarReporteConstanciaTrabajo($idConstancia,$status){	
			
			     
		 

			$id=$_GET["id"]; 
		  //  echo $id;
		  $objeto_empleado = New VendedorData();    
		  $result2 = $objeto_empleado->getDataEmpleadoID($_GET['id']);  
		  //$content = RAIZ."/index.php?view=rptCTrabajo&fechaEmision=2024-05-31&id=8";
		  $content =$result2[0]->nombre_completo."-".$result2[0]->ci."-".$result2[0]->des_cargo."-".$result2[0]->fecha_ing;
		  $image=QRcode::png($content,"../admin/storage/archivos/qr/".$_GET['id'].".png",QR_ECLEVEL_L,5,1);
		   // print_r($result);
		   function fechaCastellano ($fecha) {
			$fecha = substr($fecha, 0, 10);
			$numeroDia = date('d', strtotime($fecha));
			$dia = date('l', strtotime($fecha));
			$mes = date('F', strtotime($fecha));
			$anio = date('Y', strtotime($fecha));
			$dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
			$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			$nombredia = str_replace($dias_EN, $dias_ES, $dia);
		  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
			return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
		  }

			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
	
			$hoy = getdate();
			
				$dia = $hoy['mday'];
				$mes = $hoy['mon'];
				$anio = $hoy['year'];
				$fecha =  $dia .'/'.$mes.'/'.$anio;
				$textypos = 5;
				$pdf->setY(12);
				$pdf->setX(10);
				// Agregamos los datos de la empresa 
				$pdf->SetFont('Arial','B',10);  
				$pdf->setY(30);$pdf->setX(10);
				$pdf->Cell(3,$textypos,utf8_decode('U.E. Colegio "San Pedro"'));  
				$pdf->SetFont('Arial','',8);  
				$pdf->setY(35);$pdf->setX(10);
				$pdf->Cell(3,$textypos,utf8_decode('Inscrito en el Ministerio del Poder Popular para la Educación'));
				$pdf->setY(40);$pdf->setX(10);
				$pdf->Cell(3,$textypos,utf8_decode('Código 50786D1303'));
				$pdf->setY(45);$pdf->setX(10);
				$pdf->Cell(3,$textypos,utf8_decode('Carrera 19 entre calle 56 y 57. N° 56-26 - Teléfono 0251- 4426301'));       
				$pdf->setY(50);$pdf->setX(10);
				$pdf->Cell(3,$textypos,utf8_decode('Barquisimeto - Estado Lara'));
			
				$pdf->SetFont('Arial','',12);  
				$pdf->setY(70);$pdf->setX(85);
				$pdf->Cell(5,$textypos,utf8_decode('CONSTANCIA'));
				//$pdf->Image('../app-assets/images/logo/logo_recibo_2.jpg' , 175 ,8, 25 , 25,'JPG');
				if($result2[0]->asunto!=0){
	
					$pdf->setY(60);$pdf->setX(10);
					$pdf->Cell(5,$textypos,utf8_decode('Sres:'));
					$pdf->setY(65);$pdf->setX(10);
					$pdf->Cell(5,$textypos,utf8_decode($result2[0]->asunto));
				}
			
				$pdf->Ln();
			
				//$pdf->Image('../app-assets/images/logo/logo_recibo.jpg' , 15 ,30, 20 , 20,'JPG');
				$pdf->Image('../app-assets/images/logo/top.png' , 10 ,1, 195 , 20,'PNG');
			   
			$filtro=$result2[0]->fecha_ing;
			$anio = substr($filtro, 0, 4); 	
			$mes = substr($filtro, 5, 2); 
			$dia = substr($filtro, 8, 2); 
		// 1988-06-07
			$fecha = $dia.'/'.$mes.'/'.$anio;
			$pdf->setY(80);
				$pdf->Cell(195,5,utf8_decode('   La suscrita ADMINISTRADORA de la U.E. Colegio "San Pedro" '.ADMINISTRADORA.', '),0,1,'FJ',0);
				$pdf->setY(85);
				$pdf->Cell(195,5,utf8_decode('por medio de la presente hace constar que el(la) ciudadano(a): '.$result2[0]->nombre_completo),0,1,'FJ',0);
				$pdf->setY(90);
				$pdf->Cell(195,5,utf8_decode('titular de la Cédula de Identidad Nª: '.$result2[0]->ci.' presta sus servicios en este'),0,1,'FJ',0);
				$pdf->setY(95);
				$pdf->Cell(195,5,utf8_decode('plantel como: '.$result2[0]->des_cargo.' desde el '.fechaCastellano($result2[0]->fecha_ing).'('.$fecha.')'),0,1,'FJ',0);
				$pdf->setY(100);
				$pdf->Cell(130,5,utf8_decode('y devenga ingresos promedios mensuales de BS.: '.$result2[0]->promedio.'.'),0,1,'FJ',0);
		   // $pdf->MultiCell(5,$textypos,);
		
		
		   $pdf->setY(110);
		   $pdf->Cell(195,5,utf8_decode(' Constancia que se expide a petición de la parte interesada en Barquisimeto,'),0,1,'FJ',0);
		   $pdf->setY(115);
		   $pdf->Cell(75,5,utf8_decode('el '. fechaCastellano($result2[0]->fecha_emision).'.'),0,1,'FJ',0);	
					   
					   $pdf->setY(160);$pdf->setX(10);
					 
					   $pdf->setX(65);
					   $pdf->Cell(5,$textypos,utf8_decode('_________________________________'));					
	
					   $pdf->setY(165); 	
	
					   $pdf->setX(75);
					   $pdf->Cell(5,$textypos,utf8_decode(ADMINISTRADORA));  
	
					
					   $pdf->Image('../app-assets/images/logo/firma.jpg' , 82 ,120, 40 , 40,'JPG');
					  $pdf->Image('../admin/storage/archivos/qr/'.$id.'.png' , 15 ,255, 20 , 20,'PNG');
	
					  $pdf->setY(270);
					  $pdf->setX(45);
					  $pdf->Cell(130,5,utf8_decode('Bicentenario de la batalla Naval del Lago de Maracaibo'),0,1,'FJ',0);
					
					  
					   $pdf->Output("I","constancia_trabajo-".$id.".pdf",true);
		  
	}





}
?>