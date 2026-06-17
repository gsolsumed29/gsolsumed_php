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
		

		public static function generarReportePedido($fact_num,$status){			
			$objeto_pedido = New PedidoData();          
			$result = $objeto_pedido->GetPedido($fact_num,$status);

			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			//
			// Agregamos los datos de la empresa
			$pdf->Cell(5,$textypos,$APP_NOMBRE);
			$pdf->setY(17);
			$pdf->setX(10);
			$pdf->Cell(5,$textypos,$APP_RIF);
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
		
			// Agregamos los datos del cliente

			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
			$pdf->Cell(20,$textypos,"Cliente:");
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(35);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato1,0,'L',false);
			$pdf->setY(40);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato4,0,'L',false);
			$pdf->setY(50);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato3,0,'L',false);
			$pdf->setY(55);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato2,0,'L',false);

			// Agregamos los datos del cliente
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(12);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Pedido #".$fact_num);
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(17);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha emision:        ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(22);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha vencimiento: ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(60);$pdf->setX(135);
				$pdf->Ln();
			$header = array("Codigo", "Descripcion","Cantidad","Precio","Total");
	
			$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
			// Column widths
			$w = array(20, 115, 20, 15, 15);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			foreach($result2 as $dato)

			{   $co_art = $dato->co_art;
				$nombre = $dato->dato1;
				$cantidad=  $dato->dato2;
				$precio=  $dato->dato3;
				$total = $cantidad * $precio;

				$pdf->Cell($w[0],6,$co_art,0);
				$pdf->Cell($w[1],6, $nombre,0);
				$pdf->Cell($w[2],6,number_format($cantidad, 2, ',', '.'),'0',0,'R');
				$pdf->Cell($w[3],6,number_format($precio, 2, ',', '.'),'0',0,'R');
				$pdf->Cell($w[4],6,number_format($total, 2, ',', '.'),'0',0,'R');

				$pdf->Ln();
				$total+= $precio*$cantidad;

  		  }    
		 
		
				/////////////////////////////
				//// Apartir de aqui esta la tabla con los subtotales y totales
				$yposdinamic = 60 + (count($result2 )*10);
			
				$total_bruto=$result[0]->tot_bruto;
				$iva=$result[0]->iva;
				$total_neto = $result[0]->tot_neto;
			
				$pdf->setY($yposdinamic);
			
				$pdf->setX(235);
					$pdf->Ln();
					
				$header = array("", "");
				$data2 = array(
				
					array("Total :", number_format($total_neto, 2, ',', '.')),
				);
					// Column widths
					$w2 = array(10, 30);
					// Header

					$pdf->Ln();
					$pdf->Line(10, $yposdinamic+10, 200, $yposdinamic+10);
					// Data
					$pdf->SetFont('Arial','B',12);    
					foreach($data2 as $row)
					{$pdf->setX(150);
						$pdf->Cell($w2[0],6,$row[0],0);
						$pdf->Cell($w2[1],6,$row[1],'0',0,'R');

						$pdf->Ln();
					}
					$yposdinamic += (count($data2)*10);
					
					$pdf->Output("I","Pedido_Nro_".$fact_num.".pdf",true);

		}

		public  function generarReporteEnviar($fact_num,$status){	
			$arhivo=$this->generarKey();		
			$objeto_pedido = New PedidoData();          
			$result = $objeto_pedido->GetPedido($fact_num,$status);

			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			//
			// Agregamos los datos de la empresa
			$pdf->Cell(5,$textypos,$APP_NOMBRE);
			$pdf->setY(17);
			$pdf->setX(10);
			$pdf->Cell(5,$textypos,$APP_RIF);
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
		
			// Agregamos los datos del cliente

			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
			$pdf->Cell(20,$textypos,"Cliente:");
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(35);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato1,0,'L',false);
			$pdf->setY(40);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato4,0,'L',false);
			$pdf->setY(50);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato3,0,'L',false);
			$pdf->setY(55);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato2,0,'L',false);


			// Agregamos los datos del cliente
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(12);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Pedido #".$fact_num);
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(17);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha emision:        ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(22);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha vencimiento: ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(60);$pdf->setX(135);
				$pdf->Ln();
			$header = array("Codigo.", "Descripcion","Cantidad.","Precio","Total");
	
			$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
			// Column widths
			$w = array(20, 95, 20, 25, 25);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			foreach($result2 as $dato)

			{   $co_art = $dato->co_art;
				$nombre = $dato->dato1;
				$cantidad=  $dato->dato2;
				$precio=  $dato->dato3;
				$total = $cantidad * $precio;

				$pdf->Cell($w[0],6,$co_art,1);
				$pdf->Cell($w[1],6, $nombre,1);
				$pdf->Cell($w[2],6,(float)number_format($cantidad, 2, ',', '.'),'1',0,'R');
				$pdf->Cell($w[3],6,(float)number_format($precio, 2, ',', '.'),'1',0,'R');
				$pdf->Cell($w[4],6,(float)number_format($total, 2, ',', '.'),'1',0,'R');

				$pdf->Ln();
				$total+= $precio*$cantidad;

  		  }
				/////////////////////////////
				//// Apartir de aqui esta la tabla con los subtotales y totales
				$yposdinamic = 60 + (count($result2 )*10);
				$total_bruto=$result[0]->tot_bruto;
				$iva=$result[0]->iva;
				$total_neto = $result[0]->tot_neto;

				$pdf->setY($yposdinamic);
				$pdf->setX(235);
					$pdf->Ln();
				/////////////////////////////
				$header = array("", "");
				$data2 = array(
					array("Subtotal",$total_bruto),
					array("Descuento", 0),
					array("Impuesto", $iva),
					array("Total", $total_neto),
				);
					// Column widths
					$w2 = array(40, 40);
					// Header

					$pdf->Ln();
					// Data
					foreach($data2 as $row)
					{$pdf->setX(115);
						$pdf->Cell($w2[0],6,$row[0],1);
						$pdf->Cell($w2[1],6,$row[1],'1',0,'R');

						$pdf->Ln();
					}
					$file="storage/archivos/ventas/".$arhivo.".pdf";
					$yposdinamic += (count($data2)*10);
					$pdf->Output($file, 'F');
					
					return $file;

		}

		public  function generarReporteEnviarCotizacion($fact_num,$status){	
			$arhivo=$this->generarKey();		
			$objeto_pedido = New CotizacionData();          
			$result = $objeto_pedido->GetPedido($fact_num,$status);

			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			//
				// Agregamos los datos de la empresa
				$pdf->Cell(5,$textypos,$APP_NOMBRE);
				$pdf->setY(17);
				$pdf->setX(10);
				$pdf->Cell(5,$textypos,$APP_RIF);
				$pdf->SetFont('Arial','B',10);    
				$pdf->setY(30);$pdf->setX(10);
			
				// Agregamos los datos del cliente
	
				$pdf->SetFont('Arial','B',10);    
				$pdf->setY(30);$pdf->setX(10);
				$pdf->Cell(20,$textypos,"Cliente:");
				$pdf->SetFont('Arial','',10);    
				$pdf->setY(35);$pdf->setX(10);
				$pdf->Multicell(130,5,$result[0]->dato1,0,'L',false);
				$pdf->setY(40);$pdf->setX(10);
				$pdf->Multicell(130,5,$result[0]->dato4,0,'L',false);
				$pdf->setY(50);$pdf->setX(10);
				$pdf->Multicell(120,$textypos,$result[0]->dato3,0,'L',false);
				$pdf->setY(55);$pdf->setX(10);
				$pdf->Multicell(120,$textypos,$result[0]->dato2,0,'L',false);
	

			// Agregamos los datos del cliente
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(12);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Cotizacion #".$fact_num);
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(17);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha emision:        ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(22);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha vencimiento: ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(60);$pdf->setX(135);
				$pdf->Ln();
			$header = array("Codigo.", "Descripcion","Cantidad.","Precio","Total");
	
			$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
			// Column widths
			$w = array(20, 95, 20, 25, 25);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			foreach($result2 as $dato)

			{   $co_art = $dato->co_art;
				$nombre = $dato->dato1;
				$cantidad=  $dato->dato2;
				$precio=  $dato->dato3;
				$total = $cantidad * $precio;

				$pdf->Cell($w[0],6,$co_art,1);
				$pdf->Cell($w[1],6, $nombre,1);
				$pdf->Cell($w[2],6,(float)number_format($cantidad, 2, ',', '.'),'1',0,'R');
				$pdf->Cell($w[3],6,(float)number_format($precio, 2, ',', '.'),'1',0,'R');
				$pdf->Cell($w[4],6,(float)number_format($total, 2, ',', '.'),'1',0,'R');

				$pdf->Ln();
				$total+= $precio*$cantidad;

  		  }
				/////////////////////////////
				//// Apartir de aqui esta la tabla con los subtotales y totales
				$yposdinamic = 60 + (count($result2 )*10);
				$total_bruto=$result[0]->tot_bruto;
				$iva=$result[0]->iva;
				$total_neto = $result[0]->tot_neto;

				$pdf->setY($yposdinamic);
				$pdf->setX(235);
					$pdf->Ln();
				/////////////////////////////
				$header = array("", "");
				$data2 = array(
					array("Subtotal",$total_bruto),
					array("Descuento", 0),
					array("Impuesto", $iva),
					array("Total", $total_neto),
				);
					// Column widths
					$w2 = array(40, 40);
					// Header

					$pdf->Ln();
					// Data
					foreach($data2 as $row)
					{$pdf->setX(115);
						$pdf->Cell($w2[0],6,$row[0],1);
						$pdf->Cell($w2[1],6,$row[1],'1',0,'R');

						$pdf->Ln();
					}
					$file="storage/archivos/ventas/".$arhivo.".pdf";
					$yposdinamic += (count($data2)*10);
					$pdf->Output($file, 'F');
					
					return $file;

		}

		public  function generarReporteCuentasxCobrar($co_cli){	
			$arhivo=$this->generarKey();		
			$objeto_cliente = New ClienteData();          
			$result = $objeto_cliente->getDataFiltrada($co_cli);

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
			$pdf = new PDF($orientation='L',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(10);
			$pdf->setX(10);	
			$pdf->Cell(279,60,$APP_NOMBRE,0,0,"L");
			$pdf->setX(220);	
			$pdf->Cell(60,60,"Fecha de emision: ".$date,0,0,"L");
			$pdf->SetFont('Arial','B',15);    
			$pdf->setX(10);	
			$pdf->Cell(279,35,"RELACION FACTURAS PENDIENTES POR COBRAR",1,0,"C");
			$pdf->Image('../app-assets/images/logo/logo_recibo.png' , 15 ,12, 35 , 30,'PNG');
			//	


			$pdf->setX(10);
			$pdf->setY(50);
			$pdf->SetFont('Arial','',10);    
			$pdf->Cell(5,$textypos,"Cliente: ".$result[0]->cli_des);
			$pdf->setX(120);
			$pdf->Multicell(172,$textypos,$result[0]->direc1,0,'L',false);
			$pdf->setY(55);
			$pdf->Cell(5,$textypos,"Rif: ".$result[0]->rif);
			$pdf->setY(60);
			$pdf->Cell(5,$textypos,utf8_decode("Teléfonos: ").$result[0]->telefonos);					
			$pdf->setY(65);			
		

		
			$pdf->SetFont('Arial','B',10);   			 
			$pdf->Ln();
			$header = array("Nro.", "Tipo","Saldo","Fecha Emision","Dias Vencidos");
			$objeto_factura = New FacturaData();          
			$result2 = $objeto_factura->getFacturasCliente($co_cli,0);
			// Column widths
			$w = array(20, 170, 30, 30, 30);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			
			$pdf->SetFont('Arial','',10);   
			foreach($result2 as $dato)

			{   $nro_doc = $dato->nro_doc;
				$tipo_doc = $dato->tipo_doc;
				$saldo2=  $dato->saldo2;
				$fec_emis=  $dato->fec_emis;
				$dato3=  $dato->dato3;

				$pdf->Cell($w[0],6,$nro_doc,0);
				$pdf->Cell($w[1],6, $tipo_doc,0);
				$pdf->Cell($w[2],6,number_format($saldo2, 2, ',', '.').'$','0',0,'R');
				$pdf->Cell($w[3],6,$fec_emis,'0',0,'R');
				$pdf->Cell($w[4],6,$dato3,'0',0,'R');

				$pdf->Ln();
				$total = $total +((float)$saldo2);

  		  }
		  //// Apartir de aqui esta la tabla con los subtotales y totales
		  $yposdinamic = 60 + (count($result2 )*10);
			
		
	  
		  $pdf->setY($yposdinamic);
	  
		  $pdf->setX(235);
			  $pdf->Ln();
			  
		  $header = array("", "");
		  $data2 = array(
		  
			  array("Total ($):", $total),
		  );
			  // Column widths
			  $w2 = array(10, 30);
			  // Header

			  $pdf->Ln();
			  $pdf->Line(10, $yposdinamic+10, 290, $yposdinamic+10);
			  // Data
			  $pdf->SetFont('Arial','B',12);    
			  foreach($data2 as $row)
			  {$pdf->setX(250);
				  $pdf->Cell($w2[0],6,$row[0],0);
				  $pdf->Cell($w2[1],6,number_format($row[1], 2, ',', '.').'$','0',0,'R');

				  $pdf->Ln();
			  }
			  $yposdinamic += (count($data2)*10);
					$file=$arhivo.".pdf";
				
					$pdf->Output($file, 'I');
					
					return $file;

		}
		

		public static function generarReporteFacturacion($fact_num,$status){			
			$objeto_pedido = New FacturaData();          
			$result = $objeto_pedido->GetFactura($fact_num,$status);

			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			//
			// Agregamos los datos de la empresa
			$pdf->Cell(5,$textypos,$APP_NOMBRE);
			$pdf->setY(17);
			$pdf->setX(10);
			$pdf->Cell(5,$textypos,$APP_RIF);
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
		
			// Agregamos los datos del cliente

			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
			$pdf->Cell(20,$textypos,"Cliente:");
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(35);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato1,0,'L',false);
			$pdf->setY(40);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato4,0,'L',false);
			$pdf->setY(50);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato3,0,'L',false);
			$pdf->setY(55);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato2,0,'L',false);

			// Agregamos los datos del cliente
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(12);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Factura #".$fact_num);
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(17);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha emision:        ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(22);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha vencimiento: ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(60);$pdf->setX(135);
				$pdf->Ln();
			$header = array("Codigo.", "Descripcion","Cantidad.","Precio","Total");
	
			$result2 = $objeto_pedido->GetRenglonFactura($fact_num);
			// Column widths
			$w = array(20, 115, 20, 15, 15);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			foreach($result2 as $dato)

			{   $co_art = $dato->co_art;
				$nombre = $dato->dato1;
				$cantidad=  $dato->dato2;
				$precio=  $dato->dato3;
				$total = $cantidad * $precio;

				$pdf->Cell($w[0],6,$co_art,0);
				$pdf->Cell($w[1],6, $nombre,0);
				$pdf->Cell($w[2],6,number_format($cantidad, 2, ',', '.'),'0',0,'R');
				$pdf->Cell($w[3],6,number_format($precio, 2, ',', '.'),'0',0,'R');
				$pdf->Cell($w[4],6,number_format($total, 2, ',', '.'),'0',0,'R');

				$pdf->Ln();
				$total+= $precio*$cantidad;

  		  }/////////////////////////////
				//// Apartir de aqui esta la tabla con los subtotales y totales
				$yposdinamic = 60 + (count($result2 )*10);
			
				$total_bruto=$result[0]->tot_bruto;
				$iva=$result[0]->iva;
				$total_neto = $result[0]->tot_neto;
			
				$pdf->setY($yposdinamic);
			
				$pdf->setX(235);
					$pdf->Ln();
					
				$header = array("", "");
				$data2 = array(
				
					array("Total ($):", $total_neto),
				);
					// Column widths
					$w2 = array(10, 30);
					// Header

					$pdf->Ln();
					$pdf->Line(10, $yposdinamic+10, 200, $yposdinamic+10);
					// Data
					$pdf->SetFont('Arial','B',12);    
					foreach($data2 as $row)
					{$pdf->setX(150);
						$pdf->Cell($w2[0],6,$row[0],0);
						$pdf->Cell($w2[1],6,$row[1],'0',0,'R');

						$pdf->Ln();
					}
					$yposdinamic += (count($data2)*10);
					
					$pdf->Output("I","Pedido_Nro_".$fact_num.".pdf",true);

		}

		
		public static function generarReporteAprobacion($fact_num,$status){			
			$objeto_pedido = New CotizacionData();          
			$result = $objeto_pedido->GetPedido($fact_num,$status);

			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			//
			// Agregamos los datos de la empresa
			$pdf->Cell(5,$textypos,$APP_NOMBRE);
			$pdf->setY(17);
			$pdf->setX(10);
			$pdf->Cell(5,$textypos,$APP_RIF);
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
		
			// Agregamos los datos del cliente

			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(30);$pdf->setX(10);
			$pdf->Cell(20,$textypos,"Cliente:");
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(35);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato1,0,'L',false);
			$pdf->setY(40);$pdf->setX(10);
			$pdf->Multicell(130,5,$result[0]->dato4,0,'L',false);
			$pdf->setY(50);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato3,0,'L',false);
			$pdf->setY(55);$pdf->setX(10);
			$pdf->Multicell(120,$textypos,$result[0]->dato2,0,'L',false);

			// Agregamos los datos del cliente
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(12);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Factura #".$fact_num);
			$pdf->SetFont('Arial','',10);    
			$pdf->setY(17);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha emision:        ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(22);$pdf->setX(155);
			$pdf->Cell(5,$textypos,"Fecha vencimiento: ".substr($result[0]->fec_emis,0,10));
			$pdf->setY(60);$pdf->setX(135);
				$pdf->Ln();
			$header = array("Codigo.", "Descripcion","Cantidad.","Precio","Total");
	
			$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
			// Column widths
			$w = array(20, 115, 20, 15, 15);
			// Header
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Data
			$total = 0;
			foreach($result2 as $dato)

			{   $co_art = $dato->co_art;
				$nombre = $dato->dato1;
				$cantidad=  $dato->dato2;
				$precio=  $dato->dato3;
				$total = $cantidad * $precio;

				$pdf->Cell($w[0],6,$co_art,0);
				$pdf->Cell($w[1],6, $nombre,0);
				$pdf->Cell($w[2],6,number_format($cantidad, 2, ',', '.'),'0',0,'R');
				$pdf->Cell($w[3],6,number_format($precio, 2, ',', '.'),'0',0,'R');
				$pdf->Cell($w[4],6,number_format($total, 2, ',', '.'),'0',0,'R');

				$pdf->Ln();
				$total+= $precio*$cantidad;

  		  }
				/////////////////////////////
				//// Apartir de aqui esta la tabla con los subtotales y totales
				$yposdinamic = 60 + (count($result2 )*10);
			
				$total_bruto=$result[0]->tot_bruto;
				$iva=$result[0]->iva;
				$total_neto = $result[0]->tot_neto;
			
				$pdf->setY($yposdinamic);
			
				$pdf->setX(235);
					$pdf->Ln();
					
				$header = array("", "");
				$data2 = array(
				
					array("Total ($):", $total_neto),
				);
					// Column widths
					$w2 = array(10, 30);
					// Header

					$pdf->Ln();
					$pdf->Line(10, $yposdinamic+10, 200, $yposdinamic+10);
					// Data
					$pdf->SetFont('Arial','B',12);    
					foreach($data2 as $row)
					{$pdf->setX(150);
						$pdf->Cell($w2[0],6,$row[0],0);
						$pdf->Cell($w2[1],6,$row[1],'0',0,'R');

						$pdf->Ln();
					}
					$yposdinamic += (count($data2)*10);
					
					$pdf->Output("I","Aprobacion_Nro_".$fact_num.".pdf",true);
		}


		public  function generarReporteArticulos($filtro){	
			$arhivo=$this->generarKey();		
		

			$objeto_empresa = New EmpresaData();
			$data = $objeto_empresa->getAllDatos();
			$APP_NOMBRE=$data[0]->name;
			$APP_DIRECCION=$data[0]->dir;
			$APP_TELEFONO=$data[0]->telefonos;
			$APP_CORREO=$data[0]->email;
			$APP_RIF=$data[0]->rif;
			date_default_timezone_set('America/Caracas');
$date = strftime("%Y-%m-%d %H:%M:%S", time());
			$pdf = new PDF($orientation='P',$unit='mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);
			$pdf->SetFont('Arial','B',10);    
			$pdf->setY(10);		
			$pdf->Image('../app-assets/images/logo/1.jpg' ,10 ,12, 190 , 40,'JPG');
			$pdf->setY(60);	
			
			$pdf->SetFont('Arial','B',10);   			 
			$pdf->Ln();
			$header = array("Codigo", "Producto","Stock Actual","Precio ($)");
			$objeto_articulo = New ArticuloData();          
			$result2 = $objeto_articulo->getAllDataFiltradaArticulos($filtro);
			// Column widths
			$w = array(20, 110, 30, 30);
			// Header$pdf->SetFillColor(150,50,0);
			$pdf->SetFillColor(235, 235, 236 );
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(128,0,0);
			$pdf->SetLineWidth(.3);
			$pdf->SetFont('','B');
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],0,0,'C',true);
			$pdf->Ln();
			// Data
			$total = 0;
			$pdf->SetFillColor(224,235,255);
    		$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','',10);   
			foreach($result2 as $dato)		




			{   $co_art = $dato->co_art;
				$art_des = $dato->art_des;
				$stock_act=  $dato->stock_act;
				$prec_vta1=  $dato->prec_vta1;
			

				$pdf->Cell($w[0],6,$co_art,'0',0,'C');
				$pdf->Cell($w[1],6, utf8_decode($art_des),'0',0,'C');
				$pdf->Cell($w[2],6,$stock_act,'0',0,'C');
				$pdf->Cell($w[2],6,number_format($prec_vta1, 4, ',', '.').'$','0',0,'C');
			

				$pdf->Ln();
			

  		  }
		  //// Apartir de aqui esta la tabla con los subtotales y totales
		  $yposdinamic = 60 + (count($result2 )*10);
			
		
	  
		  $pdf->setY($yposdinamic);
	  
		  $pdf->setX(235);
	
			  $pdf->Ln();
			  $pdf->Image('../app-assets/images/logo/2.jpg' ,10 ,$yposdinamic+10, 190 , 40,'JPG');
			  //$pdf->Line(10, $yposdinamic+10, 290, $yposdinamic+10);
		

			
					$file=$arhivo.".pdf";
				
					$pdf->Output($file, 'I');
					
					return $file;

		}

}
?>

