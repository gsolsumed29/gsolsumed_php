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
		

		
		public static function generarReportePedido($fact_num, $status) {
			$objeto_pedido = new PedidoData();          
			$result = $objeto_pedido->GetPedido($fact_num, $status);
		
	 
			$pdf = new PDF($orientation = 'P', $unit = 'mm');
			$pdf->AddPage();
			$pdf->SetFont('Arial', 'B', 12);    
			$textypos = 5;
			$pdf->setY(12);
			$pdf->setX(10);
		
			// Datos de la empresa
		
		 // 1. AGREGAR EL LOGO (NUEVO)
		 	$logoPath = '../admin/storage/logo/logo_reporte_pedido.png'; // Ajusta esta ruta según tu estructura
		 	if(file_exists($logoPath)) {
		 	$pdf->Image($logoPath, 5, 5, 90); // Posición X,Y y ancho (la altura se calcula automáticamente)
		 	}
		
			
			// Agregamos los datos del cliente
			
			$pdf->SetFont('Arial', '', 10);    
			
			// Función para manejar texto largo con autoajuste
			function writeLabelAndData($pdf, $x, $y, $width, $label, $data) {
				$pdf->setXY($x, $y);
				
				// Primero escribimos la etiqueta en normal
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(30, 5, $label, 0, 0, 'L');
				
				// Luego escribimos los datos en negrita
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->MultiCell($width - 30, 5, $data, 0, 'L');
				
				return $pdf->GetY();
			}
		
			// Dibujar el cuadro alrededor de los datos del cliente
			$boxX = 10; // Posición X del cuadro
			$boxY = 50; // Posición Y inicial del cuadro
			$boxWidth = 190; // Ancho del cuadro
			$boxHeight = 35; // Altura estimada del cuadro (ajustar según necesidad)
		
			// Dibujar el cuadro
			$pdf->Rect($boxX, $boxY, $boxWidth, $boxHeight);
		
			// Título del cuadro
			$pdf->SetFont('Arial', '', 12);
			$pdf->SetXY($boxX + 5, $boxY - 5);
			$pdf->Cell(50, 5, '', 0, 0, 'L');
		
			$currentY = $boxY + 5; // Empezar 5mm dentro del cuadro
			$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'RAZON SOCIAL:', $result[0]->dato1);
			$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'RIF:', $result[0]->dato6);
			$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'DIRECCION:', $result[0]->dato4);
			$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'TELEFONOS:', $result[0]->dato3);
		
			// Datos del pedido
			$pdf->SetFont('Arial', '', 10);    
			$pdf->setY(12); $pdf->setX(145);
			$pdf->Cell(5, $textypos, "Nro de control " );
			$pdf->setY(17); $pdf->setX(145);
			$pdf->SetFont('Arial', 'B', 12);    
			$pdf->Cell(5, $textypos,'00 - '.$fact_num);
			$pdf->setY(22); $pdf->setX(145);
			$pdf->SetFont('Arial', 'B', 12);    
			$pdf->Cell(5, $textypos,'NOTA DE ENTREGA');

			$pdf->SetFont('Arial', 'B', 12);    
			$pdf->setY(30); $pdf->setX(145);
			$pdf->Cell(5, $textypos, "NF".$fact_num);
			$pdf->setY(35); $pdf->setX(145);
			$pdf->Cell(5, $textypos, "TIPO PAGO");
			$pdf->setY(40); $pdf->setX(145);
			$pdf->Cell(5, $textypos, "EMISION: " . substr($result[0]->fec_emis, 0, 10));
			$pdf->setY(45); $pdf->setX(145);
			$pdf->Cell(5, $textypos, "VENCIMIENTO:" . substr($result[0]->fec_emis, 0, 10));
			$pdf->setY(60); $pdf->setX(135);
			$pdf->Ln();
			$pdf->setY(85);
			$pdf->SetFont('Arial', '', 10);    
			$header = array("Codigo", "Descripcion", "Marca", "Cantidad", "UNIT.USD", "UNIT.BS", "Total Bs");
			$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
			
						// Column widths (ajustadas para mejor distribución)
			$w = array(15, 70, 30, 15, 20, 20, 20);

			// Header - Solo borde inferior
			for ($i = 0; $i < count($header); $i++) {
				// Para la última celda, dibujamos el borde derecho también para cerrar la tabla
				$pdf->Cell($w[$i], 7, $header[$i], 'B', 0, 'C');
			}
			$pdf->Ln();
			
			// Data con autoajuste para descripción larga
			$total = 0;
			$rowHeight = 6;
			$startY = $pdf->GetY();
			
			foreach ($result2 as $dato) {
				$co_art = $dato->co_art;
				$nombre = $dato->dato1;
				$cantidad = $dato->dato2;
				$precio = $dato->dato3;
				$preciobs = $dato->dato4;
				$rowTotal = $cantidad * $preciobs;
				
				// Guardar posición Y inicial
				$y = $pdf->GetY();
				
				// Código del producto
				$pdf->Cell($w[0], $rowHeight, $co_art, '0', 0, 'L');
				
				// Descripción (con MultiCell para autoajuste)
				$x = $pdf->GetX();
				$pdf->MultiCell($w[1], $rowHeight, $nombre, '0', 'L');
				
				// Ajustar posición Y para las demás celdas de la fila
				$newY = $pdf->GetY();
				$pdf->SetXY($x + $w[1], $y);
				
				// Resto de las celdas
				$pdf->Cell($w[2], $rowHeight, $dato->marca ?? '', '0', 0, 'L');
				$pdf->Cell($w[3], $rowHeight, number_format($cantidad, 2, ',', '.'), '0', 0, 'R');
				$pdf->Cell($w[4], $rowHeight, number_format($precio  * $cantidad, 2, ',', '.'), '0', 0, 'R');
				$pdf->Cell($w[5], $rowHeight, number_format($preciobs * $cantidad, 2, ',', '.'), '0', 0, 'R');
				$pdf->Cell($w[6], $rowHeight, number_format($rowTotal, 2, ',', '.'), '0', 0, 'R');
				
				// Ajustar nueva posición Y si MultiCell aumentó la altura
				if ($newY > $y + $rowHeight) {
					$pdf->SetY($newY);
				} else {
					$pdf->Ln();
				}
				
				$total += $rowTotal;
			}
			
			// Totales
			$yposdinamic = $pdf->GetY() + 10;
			$total_bruto = $result[0]->tot_bruto;
			$iva = $result[0]->iva;
			$total_neto = $result[0]->tot_neto;
			
			$pdf->setY($yposdinamic);
			$pdf->setX(235);
			$pdf->Ln();
			
			$header = array("", "");
			$data2 = array(
				array("Total Bs:", number_format($total_neto, 2, ',', '.')),
				array("Total Bs:", number_format($total_neto, 2, ',', '.')),
			);
			
			$w2 = array(10, 30);
			$pdf->Ln();
			$pdf->Line(10, $yposdinamic + 10, 200, $yposdinamic + 10);
			
			// Data
			$pdf->SetFont('Arial', 'B', 12);    
			foreach ($data2 as $row) {
				$pdf->setX(150);
				$pdf->Cell($w2[0], 6, $row[0], 0);
				$pdf->Cell($w2[1], 6, $row[1], '0', 0, 'R');
				$pdf->Ln();
			}
			
			$pdf->Output("I", "Pedido_Nro_" . $fact_num . ".pdf", true);
		}

		public  function generarReporteEnviar($fact_num,$status){	
					$arhivo=$this->generarKey();		
					$objeto_pedido = new PedidoData();          
					$result = $objeto_pedido->GetPedido($fact_num, $status);
				
			
					$pdf = new PDF($orientation = 'P', $unit = 'mm');
					$pdf->AddPage();
					$pdf->SetFont('Arial', 'B', 12);    
					$textypos = 5;
					$pdf->setY(12);
					$pdf->setX(10);
				
					// Datos de la empresa
				
				// 1. AGREGAR EL LOGO (NUEVO)
					$logoPath = '../admin/storage/logo/logo_reporte_pedido.png'; // Ajusta esta ruta según tu estructura
					if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 5, 5, 100); // Posición X,Y y ancho (la altura se calcula automáticamente)
					}
				
					
					// Agregamos los datos del cliente
					
					$pdf->SetFont('Arial', '', 10);    
					
					// Función para manejar texto largo con autoajuste
					function writeLabelAndData($pdf, $x, $y, $width, $label, $data) {
						$pdf->setXY($x, $y);
						
						// Primero escribimos la etiqueta en normal
						$pdf->SetFont('Arial', '', 10);
						$pdf->Cell(30, 5, $label, 0, 0, 'L');
						
						// Luego escribimos los datos en negrita
						$pdf->SetFont('Arial', 'B', 10);
						$pdf->MultiCell($width - 30, 5, $data, 0, 'L');
						
						return $pdf->GetY();
					}
				
					// Dibujar el cuadro alrededor de los datos del cliente
					$boxX = 10; // Posición X del cuadro
					$boxY = 50; // Posición Y inicial del cuadro
					$boxWidth = 190; // Ancho del cuadro
					$boxHeight = 35; // Altura estimada del cuadro (ajustar según necesidad)
				
					// Dibujar el cuadro
					$pdf->Rect($boxX, $boxY, $boxWidth, $boxHeight);
				
					// Título del cuadro
					$pdf->SetFont('Arial', '', 12);
					$pdf->SetXY($boxX + 5, $boxY - 5);
					$pdf->Cell(50, 5, '', 0, 0, 'L');
				
					$currentY = $boxY + 5; // Empezar 5mm dentro del cuadro
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'RAZON SOCIAL:', $result[0]->dato1);
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'RIF:', $result[0]->dato6);
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'DIRECCION:', $result[0]->dato4);
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'TELEFONOS:', $result[0]->dato3);
				
					// Datos del pedido
					$pdf->SetFont('Arial', '', 10);    
					$pdf->setY(12); $pdf->setX(140);
					$pdf->Cell(5, $textypos, "Nro de control " );
					$pdf->setY(17); $pdf->setX(140);
					$pdf->SetFont('Arial', 'B', 12);    
					$pdf->Cell(5, $textypos,'00 - '.$fact_num);
					$pdf->setY(22); $pdf->setX(140);
					$pdf->SetFont('Arial', 'B', 12);    
					$pdf->Cell(5, $textypos,'NOTA DE ENTREGA');

					$pdf->SetFont('Arial', 'B', 12);    
					$pdf->setY(30); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "NF".$fact_num);
					$pdf->setY(35); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "TIPO PAGO");
					$pdf->setY(40); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "EMISION: " . substr($result[0]->fec_emis, 0, 10));
					$pdf->setY(45); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "VENCIMIENTO:" . substr($result[0]->fec_emis, 0, 10));
					$pdf->setY(60); $pdf->setX(135);
					$pdf->Ln();
					$pdf->setY(85);
					$pdf->SetFont('Arial', '', 10);    
					$header = array("Codigo", "Descripcion", "Marca", "Cantidad", "UNIT.USD","TOTAL.USD");
					$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
					
								// Column widths (ajustadas para mejor distribución)
					$w = array(15, 90, 20, 25, 20, 20);

					// Header - Solo borde inferior
					for ($i = 0; $i < count($header); $i++) {
						// Para la última celda, dibujamos el borde derecho también para cerrar la tabla
						$pdf->Cell($w[$i], 7, $header[$i], 'B', 0, 'C');
					}
					$pdf->Ln();
					
					// Data con autoajuste para descripción larga
					$total = 0;
					$rowHeight = 6;
					$startY = $pdf->GetY();
					
					foreach ($result2 as $dato) {
						$co_art = $dato->co_art;
						$nombre = $dato->dato1;
						$cantidad = $dato->dato2;
						$precio = $dato->dato3;
						$marca = $dato->dato4;
						$rowTotal = $cantidad * $precio;
						
						// Guardar posición Y inicial
						$y = $pdf->GetY();
						
						// Código del producto
						$pdf->Cell($w[0], $rowHeight, $co_art, '0', 0, 'L');
						
						// Descripción (con MultiCell para autoajuste)
						$x = $pdf->GetX();
						$pdf->MultiCell($w[1], $rowHeight, $nombre, '0', 'L');
						
						// Ajustar posición Y para las demás celdas de la fila
						$newY = $pdf->GetY();
						$pdf->SetXY($x + $w[1], $y);
						
						// Resto de las celdas
						$pdf->Cell($w[2], $rowHeight, $marca ?? 'GENERICO', '0', 0, 'L');
						$pdf->Cell($w[3], $rowHeight, number_format($cantidad, 2, ',', '.'), '0', 0, 'R');
						$pdf->Cell($w[4], $rowHeight, number_format($precio, 2, ',', '.'), '0', 0, 'R');	
						$pdf->Cell($w[4], $rowHeight, number_format($precio  * $cantidad, 2, ',', '.'), '0', 0, 'R');								
						// Ajustar nueva posición Y si MultiCell aumentó la altura
						if ($newY > $y + $rowHeight) {
							$pdf->SetY($newY);
						} else {
							$pdf->Ln();
						}
						
						$total += $rowTotal;
					}
					
					// Totales
					$yposdinamic = $pdf->GetY() + 10;
					$total_bruto = $result[0]->tot_bruto;
					$iva = $result[0]->iva;
					$total_neto = $result[0]->tot_neto;
					
					$pdf->setY($yposdinamic);
					$pdf->setX(235);
					$pdf->Ln();
					
					$header = array("", "");
					$data2 = array(
						array("Total :", number_format($total_neto, 2, ',', '.')),
						
					);
					
					$w2 = array(10, 30);
					$pdf->Ln();
					$pdf->Line(10, $yposdinamic + 10, 200, $yposdinamic + 10);
					
					// Data
					$pdf->SetFont('Arial', 'B', 12);    
					foreach ($data2 as $row) {
						$pdf->setX(160);
						$pdf->Cell($w2[0], 6, $row[0], 0);
						$pdf->Cell($w2[1], 6, $row[1], '0', 0, 'R');
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
				
			
					$pdf = new PDF($orientation = 'P', $unit = 'mm');
					$pdf->AddPage();
					$pdf->SetFont('Arial', 'B', 12);    
					$textypos = 5;
					$pdf->setY(12);
					$pdf->setX(10);
				
					// Datos de la empresa
				
				// 1. AGREGAR EL LOGO (NUEVO)
					$logoPath = '../admin/storage/logo/logo_reporte_pedido.png'; // Ajusta esta ruta según tu estructura
					if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 5, 5, 100); // Posición X,Y y ancho (la altura se calcula automáticamente)
					}
				
					
					// Agregamos los datos del cliente
					
					$pdf->SetFont('Arial', '', 10);    
					
					// Función para manejar texto largo con autoajuste
					function writeLabelAndData($pdf, $x, $y, $width, $label, $data) {
						$pdf->setXY($x, $y);
						
						// Primero escribimos la etiqueta en normal
						$pdf->SetFont('Arial', '', 10);
						$pdf->Cell(30, 5, $label, 0, 0, 'L');
						
						// Luego escribimos los datos en negrita
						$pdf->SetFont('Arial', 'B', 10);
						$pdf->MultiCell($width - 30, 5, $data, 0, 'L');
						
						return $pdf->GetY();
					}
				
					// Dibujar el cuadro alrededor de los datos del cliente
					$boxX = 10; // Posición X del cuadro
					$boxY = 50; // Posición Y inicial del cuadro
					$boxWidth = 190; // Ancho del cuadro
					$boxHeight = 35; // Altura estimada del cuadro (ajustar según necesidad)
				
					// Dibujar el cuadro
					$pdf->Rect($boxX, $boxY, $boxWidth, $boxHeight);
				
					// Título del cuadro
					$pdf->SetFont('Arial', '', 12);
					$pdf->SetXY($boxX + 5, $boxY - 5);
					$pdf->Cell(50, 5, '', 0, 0, 'L');
				
					$currentY = $boxY + 5; // Empezar 5mm dentro del cuadro
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'RAZON SOCIAL:', $result[0]->dato1);
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'RIF:', $result[0]->dato6);
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'DIRECCION:', $result[0]->dato4);
					$currentY = writeLabelAndData($pdf, $boxX + 5, $currentY, $boxWidth - 10, 'TELEFONOS:', $result[0]->dato3);
				
					// Datos del pedido
					$pdf->SetFont('Arial', '', 10);    
					$pdf->setY(12); $pdf->setX(140);
					$pdf->Cell(5, $textypos, "Nro de control " );
					$pdf->setY(17); $pdf->setX(140);
					$pdf->SetFont('Arial', 'B', 12);    
					$pdf->Cell(5, $textypos,'00 - '.$fact_num);
					$pdf->setY(22); $pdf->setX(140);
					$pdf->SetFont('Arial', 'B', 12);    
					$pdf->Cell(5, $textypos,'NOTA DE ENTREGA');

					$pdf->SetFont('Arial', 'B', 12);    
					$pdf->setY(30); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "NF".$fact_num);
					$pdf->setY(35); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "TIPO PAGO");
					$pdf->setY(40); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "EMISION: " . substr($result[0]->fec_emis, 0, 10));
					$pdf->setY(45); $pdf->setX(145);
					$pdf->Cell(5, $textypos, "VENCIMIENTO:" . substr($result[0]->fec_emis, 0, 10));
					$pdf->setY(60); $pdf->setX(135);
					$pdf->Ln();
					$pdf->setY(85);
					$pdf->SetFont('Arial', '', 10);    
					$header = array("Codigo", "Descripcion", "Marca", "Cantidad", "UNIT.USD","TOTAL.USD");
					$result2 = $objeto_pedido->GetRenglonPedido($fact_num);
					
								// Column widths (ajustadas para mejor distribución)
					$w = array(15, 90, 20, 25, 20, 20);

					// Header - Solo borde inferior
					for ($i = 0; $i < count($header); $i++) {
						// Para la última celda, dibujamos el borde derecho también para cerrar la tabla
						$pdf->Cell($w[$i], 7, $header[$i], 'B', 0, 'C');
					}
					$pdf->Ln();
					
					// Data con autoajuste para descripción larga
					$total = 0;
					$rowHeight = 6;
					$startY = $pdf->GetY();
					
					foreach ($result2 as $dato) {
						$co_art = $dato->co_art;
						$nombre = $dato->dato1;
						$cantidad = $dato->dato2;
						$precio = $dato->dato3;
						$marca = $dato->dato4;
						$rowTotal = $cantidad * $precio;
						
						// Guardar posición Y inicial
						$y = $pdf->GetY();
						
						// Código del producto
						$pdf->Cell($w[0], $rowHeight, $co_art, '0', 0, 'L');
						
						// Descripción (con MultiCell para autoajuste)
						$x = $pdf->GetX();
						$pdf->MultiCell($w[1], $rowHeight, $nombre, '0', 'L');
						
						// Ajustar posición Y para las demás celdas de la fila
						$newY = $pdf->GetY();
						$pdf->SetXY($x + $w[1], $y);
						
						// Resto de las celdas
						$pdf->Cell($w[2], $rowHeight, $marca ?? 'GENERICO', '0', 0, 'L');
						$pdf->Cell($w[3], $rowHeight, number_format($cantidad, 2, ',', '.'), '0', 0, 'R');
						$pdf->Cell($w[4], $rowHeight, number_format($precio, 2, ',', '.'), '0', 0, 'R');	
						$pdf->Cell($w[4], $rowHeight, number_format($precio  * $cantidad, 2, ',', '.'), '0', 0, 'R');								
						// Ajustar nueva posición Y si MultiCell aumentó la altura
						if ($newY > $y + $rowHeight) {
							$pdf->SetY($newY);
						} else {
							$pdf->Ln();
						}
						
						$total += $rowTotal;
					}
					
					// Totales
					$yposdinamic = $pdf->GetY() + 10;
					$total_bruto = $result[0]->tot_bruto;
					$iva = $result[0]->iva;
					$total_neto = $result[0]->tot_neto;
					
					$pdf->setY($yposdinamic);
					$pdf->setX(235);
					$pdf->Ln();
					
					$header = array("", "");
					$data2 = array(
						array("Total :", number_format($total_neto, 2, ',', '.')),
						
					);
					
					$w2 = array(10, 30);
					$pdf->Ln();
					$pdf->Line(10, $yposdinamic + 10, 200, $yposdinamic + 10);
					
					// Data
					$pdf->SetFont('Arial', 'B', 12);    
					foreach ($data2 as $row) {
						$pdf->setX(150);
						$pdf->Cell($w2[0], 6, $row[0], 0);
						$pdf->Cell($w2[1], 6, $row[1], '0', 0, 'R');
						$pdf->Ln();
					}
			
					$file="storage/archivos/ventas/".$arhivo.".pdf";
					$yposdinamic += (count($data2)*10);
					$pdf->Output($file, 'F');
					
					return $file;
		}
		public static function generarReporteLista($data, $moneda, $fecha) {
			try {
				// Validar datos recibidos
				if (empty($data)) {
					throw new Exception('No se recibieron datos para generar el reporte');
				}
		
				// Decodificar los datos si vienen como JSON string
				if (is_string($data)) {
					$data = json_decode($data, true);
					if (json_last_error() !== JSON_ERROR_NONE) {
						throw new Exception('Error al decodificar los datos JSON: ' . json_last_error_msg());
					}
				}
		
				$pdf = new PDF($orientation = 'P', $unit = 'mm');
				$pdf->AddPage();
				$pdf->SetFont('Arial', 'B', 12);    
				
				// Datos de la empresa - AGREGAR EL LOGO
				$logoPath = '../admin/storage/logo/encabezado_lista_precios.png';
				if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 10, 5, 190);
				}
		
				// AGREGAR INFORMACIÓN DE LA MONEDA Y FECHA
				$pdf->SetY(50); // Posición después del logo
			
		
				// AGREGAR TABLA CON LOS DATOS
				$pdf->SetFont('Arial', 'B', 8);
				
				// Encabezados de la tabla
				$pdf->SetFillColor(200, 200, 200);
				$pdf->Cell(15, 8,  utf8_decode('CÓDIGO'), 1, 0, 'C', true);
				$pdf->Cell(60, 8,  utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', true);
				$pdf->Cell(25, 8,  utf8_decode('MARCA'), 1, 0, 'C', true);
				$pdf->Cell(20, 8,  utf8_decode('STOCK'), 1, 0, 'C', true);
				
				if ($moneda === 'USD') {
					$pdf->Cell(25, 8,  utf8_decode('CRÉDITO'), 1, 0, 'C', true);
					$pdf->Cell(25, 8,  utf8_decode('CONTADO'), 1, 0, 'C', true);
				} else {
					$pdf->Cell(25, 8,  utf8_decode('CRÉDITO'), 1, 0, 'C', true);
					$pdf->Cell(25, 8,  utf8_decode('CONTADO'), 1, 0, 'C', true);
				}
				
				$pdf->Cell(20, 8, 'IVA', 1, 1, 'C', true);
		
				// Datos de la tabla
				$pdf->SetFont('Arial', '', 8);
				$fill = false;
				$lineHeight = 8;
				
					foreach ($data as $articulo) {
						$startY = $pdf->GetY();
						$startX = 10;
						
						// Obtener y decodificar datos
						$co_art = utf8_decode(trim($articulo['co_art']) ?? '0');
						$descripcion = utf8_decode(trim($articulo['art_des']) ?? '');
						$marca = utf8_decode(trim($articulo['des_col']) ?? 'N/A');
						$stock = $articulo['stock_act'] ?? 0;
						$tipoImpuesto = utf8_decode($articulo['tipo_impuesto_desc'] ?? 'N/A');
						
						// Calcular altura máxima basada solo en la descripción (la más larga)
						$lineHeight = 8;
						$anchoDesc = 60;
						
						// Calcular cuántas líneas necesita la descripción
						$lineasNecesarias = ceil($pdf->GetStringWidth($descripcion) / $anchoDesc);
						//echo $lineasNecesarias;
						$lineasNecesarias = min($lineasNecesarias, 3); // Máximo 3 líneas
						
						$alturaFila = $lineasNecesarias * $lineHeight;
						$alturaFila = max($alturaFila, 8); // Mínimo 8mm
						
						$pdf->SetFillColor($fill ? 240 : 255, 240, 240);
						
						// **MÉTODO CORRECTO: Usar Cell para todo y solo MultiCell para descripción**
						
						// 1. Código (centrado verticalmente)
						$pdf->SetXY($startX, $startY);
						$pdf->Cell(15, $alturaFila, $co_art, 1, 0, 'C', $fill);
						
						// 2. Descripción (única que usa MultiCell)
						$pdf->SetXY($startX + 15, $startY);
						$pdf->MultiCell(60, $lineHeight, $descripcion, 1, 'L', $fill);
						
						// 3. Marca (centrada verticalmente)
						$pdf->SetXY($startX + 75, $startY);
						$pdf->Cell(25, $alturaFila, $marca, 1, 0, 'C', $fill);
						
						// 4. Stock (derecha)
						$pdf->SetXY($startX + 100, $startY);
						$pdf->Cell(20, $alturaFila, number_format($stock, 2, ',', '.'), 1, 0, 'R', $fill);
						
						// 5. Precios según moneda
						if ($moneda === 'USD') {
							$precio1 = $articulo['prec_vta1'] ?? 0;
							$precio2 = $articulo['prec_vta2'] ?? 0;
							
							$pdf->SetXY($startX + 120, $startY);
							$pdf->Cell(25, $alturaFila, number_format($precio1, 2, ',', '.'), 1, 0, 'R', $fill);
							
							$pdf->SetXY($startX + 145, $startY);
							$pdf->Cell(25, $alturaFila, number_format($precio2, 2, ',', '.'), 1, 0, 'R', $fill);
						} else {
							$precio3 = $articulo['prec_vta3'] ?? 0;
							$precio4 = $articulo['prec_vta4'] ?? 0;
							
							$pdf->SetXY($startX + 120, $startY);
							$pdf->Cell(25, $alturaFila, number_format($precio3, 2, ',', '.'), 1, 0, 'R', $fill);
							
							$pdf->SetXY($startX + 145, $startY);
							$pdf->Cell(25, $alturaFila, number_format($precio4, 2, ',', '.'), 1, 0, 'R', $fill);
						}
						
						// 6. Impuesto (centrado)
						$pdf->SetXY($startX + 170, $startY);
						$pdf->Cell(20, $alturaFila, $tipoImpuesto, 1, 1, 'C', $fill);
						
						// **ACTUALIZAR LA POSICIÓN Y CORRECTAMENTE**
						// Después de MultiCell, la posición Y puede haber cambiado
						// Nos aseguramos de usar la altura calculada
						$nuevaY = $startY + $alturaFila;
						$pdf->SetY($nuevaY);
						
						$fill = !$fill;
						
						// Salto de página si es necesario
						if ($pdf->GetY() > 250) {
							$pdf->AddPage();
							// Volver a poner encabezados en nueva página
							$pdf->SetFont('Arial', 'B', 8);
							$pdf->SetFillColor(20, 69, 162);
							$pdf->Cell(15, 8, utf8_decode('CÓDIGO'), 1, 0, 'C', true);
							$pdf->Cell(60, 8, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', true);
							$pdf->Cell(25, 8, utf8_decode('MARCA'), 1, 0, 'C', true);
							$pdf->Cell(20, 8, utf8_decode('STOCK'), 1, 0, 'C', true);
							
							if ($moneda === 'USD') {
								$pdf->Cell(25, 8, utf8_decode('CRÉDITO'), 1, 0, 'C', true);
								$pdf->Cell(25, 8, utf8_decode('CONTADO'), 1, 0, 'C', true);
							} else {
								$pdf->Cell(25, 8, utf8_decode('CRÉDITO'), 1, 0, 'C', true);
								$pdf->Cell(25, 8, utf8_decode('CONTADO'), 1, 0, 'C', true);
							}
							
							$pdf->Cell(20, 8, utf8_decode('IVA'), 1, 1, 'C', true);
							
							$pdf->SetFont('Arial', '', 8);
						}
					}
					
				// PIE DE PÁGINA
				$pdf->SetY(-20);
				$pdf->SetFont('Arial', 'I', 8);
				$pdf->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i:s'), 0, 0, 'C');
				$pdf->Ln(5);
				$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo(), 0, 0, 'C');
		
				// Guardar el PDF en un directorio temporal
				$nombreArchivo = "lista_precios_" . $moneda . "_" . date('Ymd_His') . ".pdf";
				$directorioTemp = '../admin/storage/archivos/';
				
				// Crear directorio si no existe
				if (!file_exists($directorioTemp)) {
					mkdir($directorioTemp, 0777, true);
				}
				
				$rutaCompleta = $directorioTemp . $nombreArchivo;
				$pdf->Output('F', $rutaCompleta);
		
				// Verificar que el archivo se creó correctamente
				if (!file_exists($rutaCompleta)) {
					throw new Exception('Error al crear el archivo PDF');
				}
		
				 // Limpiar archivos viejos automáticamente
				 self::limpiarArchivosTemporales($directorioTemp, 30);
				// Devolver información del archivo generado
				return [
					'success' => true,
					'pdfUrl' => $rutaCompleta,
					'fileName' => $nombreArchivo,
					'fileSize' => filesize($rutaCompleta),
					'generatedAt' => date('Y-m-d H:i:s')
				];
		
			} catch (Exception $e) {
				// Registrar error
				error_log('Error en generarReporteLista: ' . $e->getMessage());
				
				return [
					'success' => false,
					'message' => $e->getMessage(),
					'errorCode' => $e->getCode()
				];
			}
		}
	

		// Función para limpiar archivos temporales viejos
		private static function limpiarArchivosTemporales($directorio, $tiempoMaximo = 10) {
			if (!file_exists($directorio) || !is_dir($directorio)) {
				return;
			}
			
			$archivos = scandir($directorio);
			$tiempoActual = time();
			
			foreach ($archivos as $archivo) {
				if ($archivo === '.' || $archivo === '..') continue;
				
				$rutaCompleta = $directorio . $archivo;
				$tiempoModificacion = filemtime($rutaCompleta);
				
				if (($tiempoActual - $tiempoModificacion) > $tiempoMaximo) {
					@unlink($rutaCompleta);
				}
			}
		}
		public function generarReporteEstatusEmbarque($embarque_id) {
			try {
				// Validar ID del embarque
				if (!$embarque_id) {
					throw new Exception('ID de embarque no especificado');
				}
				
				// Obtener datos del embarque
				$embarque = VehiculoData::getDetallesEmbarque($embarque_id);
				$lotes = VehiculoData::getDetallesLotesEmbarque($embarque_id);
				
				// Crear el PDF con orientación vertical
				$pdf = new PDF($orientation = 'P', $unit = 'mm');
				$pdf->SetMargins(15, 15, 15); // Márgenes más ajustados
				$pdf->SetAutoPageBreak(true, 25); // Margen inferior de 25mm para el pie de página
				$pdf->AddPage();
				
				$logoPath = '../admin/storage/logo/1_encabezado.jpg'; // Ajusta esta ruta según tu estructura
				if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 25, 4, 150); // Posición X,Y y ancho (la altura se calcula automáticamente)
				}
				
				// Fecha de generación en la esquina superior derecha
				$pdf->SetFont('Arial', '', 9);
				//$pdf->Text(175, 20, utf8_decode(date('d/m/Y')));
				
				// Espacio después del encabezado
				$pdf->Ln(25);
				// ===== FIN DEL ENCABEZADO =====
				
				// Configurar fuentes
				$pdf->SetFont('Arial', 'B', 16);
				$pdf->SetTextColor(0, 51, 102); // Azul marino
				
				// Título principal con borde inferior
				$pdf->Cell(0, 12, utf8_decode('RELACION DE CARGA'), 0, 1, 'C');
				$pdf->SetDrawColor(0, 51, 102);
				$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
				$pdf->Ln(8);
				
				// Información General del Embarque - Diseño compacto
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->SetFillColor(230, 240, 250); // Fondo azul claro
				$pdf->Cell(0, 8, utf8_decode('Información'), 0, 1, 'L', true);
				$pdf->Ln(3);
				
				// Tabla compacta de información general (2 columnas)
				$pdf->SetFont('Arial', '', 10);
				$pdf->SetTextColor(0, 0, 0);
				
				// Primera fila
				$pdf->Cell(35, 6, utf8_decode('ID:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(55, 6, utf8_decode($embarque->codigo), 0, 0, 'L');
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode('Vehículo:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(60, 6, utf8_decode($embarque->vehiculo_nombre), 0, 1, 'L');
				
				// Segunda fila
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode('Chofer:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(55, 6, utf8_decode($embarque->chofer_nombre), 0, 0, 'L');
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode('Ayudante:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(60, 6, utf8_decode($embarque->ayudante_nombre), 0, 1, 'L');
				
				// Tercera fila
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode('Zona:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(55, 6, utf8_decode($embarque->zona_nombre), 0, 0, 'L');
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode('Total Bultos:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(60, 6, $embarque->total_paquetes, 0, 1, 'L');
				
				// Cuarta fila
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode('Fecha Carga:'), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(55, 6, $embarque->fecha_carga, 0, 0, 'L');
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetTextColor(0, 128, 0); // Verde para estado
				$pdf->Cell(60, 6, utf8_decode(), 0, 1, 'L');
				$pdf->SetTextColor(0, 0, 0);
				
				// Línea separadora
				$pdf->SetDrawColor(200, 200, 200);
				$pdf->Line(15, $pdf->GetY() + 2, 195, $pdf->GetY() + 2);
				$pdf->Ln(6);
				
				// Listado de Lotes
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->SetFillColor(230, 240, 250);
				$pdf->SetTextColor(0, 51, 102); // Azul marino
				$pdf->Cell(0, 8, utf8_decode('Lista de Lotes'), 0, 1, 'L', true);
				$pdf->Ln(3);
				$pdf->SetTextColor(0, 0, 0); // Azul marino
				
				// Encabezados de tabla con colores - MODIFICADO: Se agregó columna Fecha Entrega
				$pdf->SetFont('Arial', 'B', 8); // Reducido tamaño de fuente para acomodar más columnas
				$pdf->SetFillColor(240, 248, 255);
				$pdf->SetDrawColor(180, 200, 220);
				
				// NUEVAS DIMENSIONES: Ajuste de anchos para incluir fecha de entrega
				$pdf->Cell(40, 7, utf8_decode('N° Lote'), 1, 0, 'C', true);
				$pdf->Cell(85, 7, utf8_decode('Cliente'), 1, 0, 'C', true);
				$pdf->Cell(15, 7, utf8_decode('Bultos'), 1, 0, 'C', true);
				$pdf->Cell(25, 7, utf8_decode('Fecha Entrega'), 1, 0, 'C', true); // NUEVA COLUMNA
				$pdf->Cell(15, 7, utf8_decode('Estatus'), 1, 1, 'C', true);
				
				// Datos de lotes con colores alternados - MODIFICADO: Incluir fecha de entrega
				$pdf->SetFont('Arial', '', 8); // Reducido tamaño de fuente
				$fill = false;
				
				foreach ($lotes as $lote) {
					// Truncar descripción si es muy larga
					$descripcion = utf8_decode($lote->cli_des);
					if (strlen($descripcion) > 40) { // Reducido el límite por la nueva columna
						$descripcion = substr($descripcion, 0, 40) . '...';
					}
					
					if($lote->estatus==2){
						$estatus ='E';
					}else{
						$estatus ='N/E';
					}
					
					// Obtener fecha de entrega formateada (si existe)
					$fecha_entrega = isset($lote->fecha_entrega) && $lote->fecha_entrega ? $lote->fecha_entrega : '---';
					
					$pdf->SetFillColor($fill ? 245 : 255);
					$pdf->Cell(40, 6, utf8_decode($lote->loteID), 1, 0, 'C', $fill);
					$pdf->Cell(85, 6, $descripcion, 1, 0, 'L', $fill);
					$pdf->Cell(15, 6, $lote->cantidad_paquetes, 1, 0, 'C', $fill);
					$pdf->Cell(25, 6, utf8_decode($fecha_entrega), 1, 0, 'C', $fill); // NUEVA COLUMNA
					$pdf->Cell(15, 6, utf8_decode($estatus), 1, 1, 'C', $fill);
					$fill = !$fill;
				}

				// ===== NUEVA SECCIÓN: FIRMAS =====
				$pdf->Ln(10); // Espacio antes de las firmas
				
				// Posicionar las tres columnas para firmas
				$startX = 15; // Posición X inicial
				$colWidth = 60; // Ancho de cada columna
				$yPos = $pdf->GetY(); // Posición Y actual
				
				// Fila 1: Etiquetas de las firmas
				$pdf->SetXY($startX, $yPos);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell($colWidth, 6, utf8_decode('EMITE:'), 0, 0, 'C');
				
				$pdf->SetX($startX + $colWidth);
				$pdf->Cell($colWidth, 6, utf8_decode('REVISA:'), 0, 0, 'C');
				
				$pdf->SetX($startX + ($colWidth * 2));
				$pdf->Cell($colWidth, 6, utf8_decode('RECIBE:'), 0, 1, 'C');
				
				// Fila 2: Espacio para firmas (líneas)
				$pdf->Ln(5);
				$yPos = $pdf->GetY();
				
				$pdf->SetXY($startX, $yPos);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell($colWidth, 10, '', 'B', 0, 'C'); // Línea inferior para firma
				
				$pdf->SetX($startX + $colWidth);
				$pdf->Cell($colWidth, 10, '', 'B', 0, 'C'); // Línea inferior para firma
				
				$pdf->SetX($startX + ($colWidth * 2));
				$pdf->Cell($colWidth, 10, '', 'B', 0, 'C'); // Línea inferior para firma
				$pdf->Ln(12);
				
				// Fila 3: Texto "Firma" debajo de las líneas
				$yPos = $pdf->GetY();
				
				$pdf->SetXY($startX, $yPos);
				$pdf->SetFont('Arial', 'I', 8);
				$pdf->SetTextColor(100, 100, 100);
				$pdf->Cell($colWidth, 4, utf8_decode('Firma'), 0, 0, 'C');
				
				$pdf->SetX($startX + $colWidth);
				$pdf->Cell($colWidth, 4, utf8_decode('Firma'), 0, 0, 'C');
				
				$pdf->SetX($startX + ($colWidth * 2));
				$pdf->Cell($colWidth, 4, utf8_decode('Firma'), 0, 1, 'C');
				
				// Fila 4: Nombres (opcional - puedes obtenerlos de los datos)
				$pdf->Ln(4);
				$yPos = $pdf->GetY();
				
				$pdf->SetXY($startX, $yPos);
				$pdf->SetFont('Arial', '', 9);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->Cell($colWidth, 4, utf8_decode('Nombre: ________________'), 0, 0, 'C');
				
				$pdf->SetX($startX + $colWidth);
				$pdf->Cell($colWidth, 4, utf8_decode('Nombre: ________________'), 0, 0, 'C');
				
				$pdf->SetX($startX + ($colWidth * 2));
				$pdf->Cell($colWidth, 4, utf8_decode('Nombre: ________________'), 0, 1, 'C');
				
				// Fila 5: Fechas
				$pdf->Ln(4);
				$yPos = $pdf->GetY();
				
				$pdf->SetXY($startX, $yPos);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell($colWidth, 4, utf8_decode('Fecha: _______________'), 0, 0, 'C');
				
				$pdf->SetX($startX + $colWidth);
				$pdf->Cell($colWidth, 4, utf8_decode('Fecha: _______________'), 0, 0, 'C');
				
				$pdf->SetX($startX + ($colWidth * 2));
				$pdf->Cell($colWidth, 4, utf8_decode('Fecha: _______________'), 0, 1, 'C');
				
				// ===== FIN DE LA SECCIÓN DE FIRMAS =====
				
				// Pie de página - Posicionado al final del contenido
				$pdf->Ln(10); // Espacio antes del pie de página
				
				// Dibujar línea separadora para el pie de página
				$pdf->SetDrawColor(200, 200, 200);
				$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
				$pdf->Ln(3);
				
				// Contenido del pie de página
				$pdf->SetFont('Arial', 'I', 8);
				$pdf->SetTextColor(100, 100, 100);
				$pdf->Cell(0, 5, utf8_decode('Generado el: ') . date('d/m/Y H:i'), 0, 0, 'L');        
				// Salida del PDF para visualización previa
				$pdf->Output('I', 'embarque_' . $embarque->codigo . '_' . date('Ymd') . '.pdf');
				
			} catch (Exception $e) {
				die('Error al generar el PDF: ' . $e->getMessage());
			}
		}


		public function generarFacturaPDF($factura_id) {
						try {
							// ==========================================
							// 1. DATOS DE LA FACTURA
							// ==========================================
							$empresa = [
								'nombre' => 'GRUPO SOLSUMED OCCIDENTE, C.A',
								'rif' => 'J-50784504-4',
								'direccion_fiscal' => 'CR 27 ENTRE CALLES 19 Y 20 LOCAL NRO 19-73 ZONA CENTRO BARQUISIMETO LARA ZONA POSTAL 3001',
								'telefono' => '0424-588.55.91 / 0251-273.28.66',
								'correo' => 'VENTAS@GRUPOSOLSUMED.COM',
								'web' => 'WWW.GRUPOSOLSUMED.COM'
							];
					
							$documento = [
								'tipo' => 'FACTURA',
								'numero' => '510301030',
								'fecha_emision' => '19-03-2026',
								'hora_emision' => '10:03:45 pm',
								'control' => '00-00000039',
								'fecha_asignacion' => '19-03-2026'
							];
					
							$cliente = [
								'nombre' => 'INVERSIONES MEDICA E.J,C.A',
								'direccion' => 'CTRA NACIONAL MARIARA MARACAY LOCAL NRO 4-1 SECTOR MARISCAL SUCRE, MARIARA CARABOBO',
								'rif' => 'J-501741999',
								'telefono' => '',
								'transporte' => '',
								'vendedor' => '',
								'zona' => '',
								'condicion_pago' => 'CONTADO',
								'direccion_entrega' => ''
							];
					
							// Productos
							$productos = [
								['codigo' => 'MQD-0213', 'desc' => 'APLICADOR DE MADERA C/ALGODÓN PAQ 100 UNDS', 'marca' => '', 'cant' => 10.00, 'precio' => 1.40, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 14.00],
								['codigo' => 'CH-0032', 'desc' => 'APOSITO ALGINATO DE CALCIO 10 CM X 10 CM SOBRE 1 UND', 'marca' => '', 'cant' => 10.00, 'precio' => 1.76, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 17.60],
								['codigo' => 'LEN-0030', 'desc' => 'CUBRE BOTAS 40G PAQ 50 PARES', 'marca' => '', 'cant' => 3.00, 'precio' => 6.12, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 18.36],
								['codigo' => 'MQD-0433', 'desc' => 'JERINGA 3 CC 21G 1 1/2" CAJA 100 UNDS', 'marca' => '', 'cant' => 5.00, 'precio' => 5.58, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 27.90],
								['codigo' => 'MQD-0440', 'desc' => 'JERINGA 5 CC 21G 1 1/2" CAJA 100 UNDS', 'marca' => '', 'cant' => 4.00, 'precio' => 5.87, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 23.48],
								['codigo' => 'MQD-0084', 'desc' => 'TUBO DE EXTENSION K50 X UDS', 'marca' => '', 'cant' => 20.00, 'precio' => 0.33, 'descuento' => 0.00, 'iva' => '(E)', 'total' => 6.60],
								['codigo' => 'SUT-0135', 'desc' => 'VICRYL 0 J340 70CM 1/2 36MM AC NO CORTANTE CAJA 12 UNDS', 'marca' => '', 'cant' => 2.00, 'precio' => 27.69, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 55.38],
								['codigo' => 'SUT-0136', 'desc' => 'VICRYL 1 J341 70CM 1/2 36MM AC NO CORTANTE CAJA 12 UNDS', 'marca' => '', 'cant' => 3.00, 'precio' => 28.76, 'descuento' => 0.00, 'iva' => '(G)', 'total' => 86.28]
							];
					
							$totales = [
								'tasa_bcv' => 419.9900,
								// USD
								'subtotal_usd' => 200.60, 
								'descuento_usd' => 0.00, 
								'exento_usd' => 5.30,
								'base_usd' => 195.30, 
								'iva_usd' => 31.25, 
								'igtf_base_usd' => 0.00, 
								'igtf_usd' => 0.00, 
								'total_usd' => 231.85,
								// BS
								'subtotal_bs' => 84249.99, 
								'descuento_bs' => 0.00, 
								'exento_bs' => 2225.95,
								'base_bs' => 82024.05, 
								'iva_bs' => 13124.69, 
								'igtf_base_bs' => 0.00, 
								'igtf_bs' => 0.00, 
								'total_bs' => 97374.68
							];
							
							$metodos_pago = "N° de Cuenta:\nBDV 01020422470001577053 A nombre de: GRUPO SOLSUMED OCCIDENTE, C.A\nBANESCO 0134-0218-38-2181029961 RIF.: J-50784504-4\nBANPLUS 01740139401394347197";
					
							// ==========================================
							// 2. CONFIGURACIÓN PDF - TAMAÑO LETTER
							// ==========================================
							$pdf = new PDF('P', 'mm', 'Letter');
							// Márgenes: izquierdo=2mm, derecho=2mm, superior=2mm
							$pdf->SetMargins(2, 2, 2);
							$pdf->SetAutoPageBreak(true, 15);
							$pdf->AddPage();
							
							// ==========================================
							// 3. ENCABEZADO - ESTRUCTURA CORREGIDA
							// ==========================================
							// El PDF original tiene:
							// - Logo a la izquierda (x=2mm, ancho ~58mm)
							// - Datos de empresa a la derecha del logo (x=68mm)
							// - Cuadro FACTURA en la extrema derecha (x=161mm)
							
							$logoPath = '../admin/storage/logo/encabezado.jpg';
							$logo_width = 150;  // mm
							$logo_height = 14; // mm
							
							// --- Fila 1: Logo + Nombre de empresa ---
							$y_empresa = 5;
							
							// Insertar logo si existe
							if(file_exists($logoPath)) {
								$pdf->Image($logoPath, 2, 2, $logo_width);
							}
							
							
							$cuadro_x = 161;
							$cuadro_width = 53;
							
							// Encabezado "FACTURA" - SIN borde, solo texto grande
							$pdf->SetXY($cuadro_x, 12);
							$pdf->SetFont('Arial', 'B', 10);
							$pdf->Cell($cuadro_width, 5, utf8_decode("NOTA"), 0, 1, 'C');
							
							// Filas de datos del documento
							$doc_start_y = 17;
							$row_height = 3.5;
							
							// N° DE DOCUMENTO
							$pdf->SetXY($cuadro_x, $doc_start_y);
							$pdf->SetFont('Arial', '', 7);
							$pdf->Cell(27, $row_height, utf8_decode('N° DE DOCUMENTO:'), 0, 0, 'L');
							$pdf->SetFont('Arial', 'B', 7);
							$pdf->Cell(26, $row_height, utf8_decode($documento['numero']), 0, 1, 'R');
							
							// FECHA DE EMISIÓN
							$pdf->SetXY($cuadro_x, $doc_start_y + $row_height);
							$pdf->SetFont('Arial', '', 7);
							$pdf->Cell(27, $row_height, utf8_decode('FECHA DE EMISIÓN:'), 0, 0, 'L');
							$pdf->SetFont('Arial', 'B', 7);
							$pdf->Cell(26, $row_height, utf8_decode($documento['fecha_emision']), 0, 1, 'R');
							
							// HORA DE EMISIÓN
							$pdf->SetXY($cuadro_x, $doc_start_y + ($row_height * 2));
							$pdf->SetFont('Arial', '', 7);
							$pdf->Cell(27, $row_height, utf8_decode('HORA DE EMISIÓN:'), 0, 0, 'L');
							$pdf->SetFont('Arial', 'B', 7);
							$pdf->Cell(26, $row_height, utf8_decode($documento['hora_emision']), 0, 1, 'R');
							
							// N° DE CONTROL
							$pdf->SetXY($cuadro_x, $doc_start_y + ($row_height * 3));
							$pdf->SetFont('Arial', '', 7);
							$pdf->Cell(27, $row_height, utf8_decode('N° DE CONTROL:'), 0, 0, 'L');
							$pdf->SetFont('Arial', 'B', 7);
							$pdf->Cell(26, $row_height, utf8_decode($documento['control']), 0, 1, 'R');
							
							// FECHA DE ASIGNACIÓN
							$pdf->SetXY($cuadro_x, $doc_start_y + ($row_height * 4));
							$pdf->SetFont('Arial', '', 7);
							$pdf->Cell(30, $row_height, utf8_decode('FECHA DE ASIGNACIÓN:'), 0, 0, 'L');
							$pdf->SetFont('Arial', 'B', 7);
							$pdf->Cell(23, $row_height, utf8_decode($documento['fecha_asignacion']), 0, 1, 'R');
				
					
						// ==========================================
								// ==========================================
								// 4. DATOS DEL CLIENTE (Formato imagen)
								// ==========================================

								// Calcular posición Y después del encabezado
								$y_cliente = $pdf->GetY() + 2;

								// Fila 1 - NOMBRE O RAZÓN SOCIAL: [valor]
								$pdf->SetY($y_cliente);
								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(35, 4, utf8_decode('NOMBRE O RAZÓN SOCIAL:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(150, 4, utf8_decode($cliente['nombre']), 0, 1, 'L');

								// Fila 2 - DIRECCIÓN: [valor]
								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(18, 4, utf8_decode('DIRECCIÓN:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(150, 4, utf8_decode($cliente['direccion']), 0, 1, 'L');

								// Fila 3 - RIF / C.I.: [valor]  TELÉFONO: [valor]  TRANSPORTE: [valor]
								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(15, 4, utf8_decode('RIF / C.I.:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(40, 4, utf8_decode($cliente['rif']), 0, 0, 'L');

								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(18, 4, utf8_decode('TELÉFONO:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(45, 4, utf8_decode($cliente['telefono']), 0, 0, 'L');

								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(20, 4, utf8_decode('TRANSPORTE:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(40, 4, utf8_decode($cliente['transporte']), 0, 1, 'L');

								// Fila 4 - VENDEDOR: [valor]  ZONA: [valor]  CONDICIÓN DE PAGO: [valor]
								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(18, 4, utf8_decode('VENDEDOR:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(45, 4, utf8_decode($cliente['vendedor']), 0, 0, 'L');

								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(12, 4, utf8_decode('ZONA:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(35, 4, utf8_decode($cliente['zona']), 0, 0, 'L');

								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(28, 4, utf8_decode('CONDICIÓN DE PAGO:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(40, 4, utf8_decode($cliente['condicion_pago']), 0, 1, 'L');

								// Fila 5 - DIRECCIÓN DE ENTREGA: [valor]
								$pdf->SetFont('Arial', 'B', 7);
								$pdf->Cell(35, 4, utf8_decode('DIRECCIÓN DE ENTREGA:'), 0, 0, 'L');
								$pdf->SetFont('Arial', '', 7);
								$pdf->Cell(150, 4, utf8_decode($cliente['direccion_entrega']), 0, 1, 'L');

								$pdf->Ln(4);
					
						// ==========================================
						// ==========================================
						// 5. TABLA DE PRODUCTOS - EXACTAMENTE COMO LA IMAGEN
						// ==========================================

						// Configurar estilo
						$pdf->SetDrawColor(0, 0, 0);
						$pdf->SetLineWidth(0.2);
						$pdf->SetFillColor(200, 200, 200);
						$pdf->SetFont('Arial', 'B', 7);
						$pdf->SetTextColor(0, 0, 0);

						$y_header = $pdf->GetY();
						$x_start = 2;

						// Anchos de columnas (mm)
						$ancho_codigo = 22;
						$ancho_desc = 78;
						$ancho_marca = 15;
						$ancho_cant = 15;
						$ancho_precio = 25;
						$ancho_desc2 = 13;
						$ancho_iva = 17;
						$ancho_total = 25;

						// Posiciones X
						$x_codigo = $x_start;
						$x_desc = $x_codigo + $ancho_codigo;
						$x_marca = $x_desc + $ancho_desc;
						$x_cant = $x_marca + $ancho_marca;
						$x_precio = $x_cant + $ancho_cant;
						$x_desc2 = $x_precio + $ancho_precio;
						$x_iva = $x_desc2 + $ancho_desc2;
						$x_total = $x_iva + $ancho_iva;

						// ========== ENCABEZADOS ==========
						// CÓDIGO
						$pdf->SetXY($x_codigo, $y_header);
						$pdf->Cell($ancho_codigo, 8, utf8_decode('CÓDIGO'), 1, 0, 'C', true);

						// DESCRIPCIÓN
						$pdf->SetXY($x_desc, $y_header);
						$pdf->Cell($ancho_desc, 8, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', true);

						// MARCA
						$pdf->SetXY($x_marca, $y_header);
						$pdf->Cell($ancho_marca, 8, utf8_decode('MARCA'), 1, 0, 'C', true);

						// CANT
						$pdf->SetXY($x_cant, $y_header);
						$pdf->Cell($ancho_cant, 8, utf8_decode('CANT'), 1, 0, 'C', true);

						// PRECIO UNITARIO USD
						$pdf->SetXY($x_precio, $y_header);
						$pdf->MultiCell($ancho_precio, 4, utf8_decode('PRECIO UNITARIO USD'), 1, 'C', true);

						// DESC
						$pdf->SetXY($x_desc2, $y_header);
						$pdf->Cell($ancho_desc2, 8, utf8_decode('DESC'), 1, 0, 'C', true);

						// ALÍCUOTA I.V.A
						$pdf->SetXY($x_iva, $y_header);
						$pdf->MultiCell($ancho_iva, 4, utf8_decode('ALÍCUOTA I.V.A'), 1, 'C', true);

						// MONTO TOTAL USD
						$pdf->SetXY($x_total, $y_header);
						$pdf->MultiCell($ancho_total, 8, utf8_decode('MONTO TOTAL USD'), 1, 'C', true);

						$pdf->Ln(2);

						// ========== FILAS DE PRODUCTOS ==========
						$pdf->SetFont('Arial', '', 7);
						$pdf->SetFillColor(255, 255, 255);
						$row_height = 5;

						foreach ($productos as $prod) {
							$y_row = $pdf->GetY();
							
							// CÓDIGO
							$pdf->SetXY($x_codigo, $y_row);
							$pdf->Cell($ancho_codigo, $row_height, utf8_decode($prod['codigo']), 1, 0, 'L');
							
							// DESCRIPCIÓN
							$pdf->SetXY($x_desc, $y_row);
							$pdf->Cell($ancho_desc, $row_height, utf8_decode($prod['desc']), 1, 0, 'L');
							
							// MARCA (vacía como en la imagen)
							$pdf->SetXY($x_marca, $y_row);
							$pdf->Cell($ancho_marca, $row_height, '', 1, 0, 'C');
							
							// CANTIDAD
							$pdf->SetXY($x_cant, $y_row);
							$pdf->Cell($ancho_cant, $row_height, number_format($prod['cant'], 2, ',', '.'), 1, 0, 'C');
							
							// PRECIO UNITARIO
							$pdf->SetXY($x_precio, $y_row);
							$pdf->Cell($ancho_precio, $row_height, number_format($prod['precio'], 2, ',', '.'), 1, 0, 'R');
							
							// DESCUENTO
							$pdf->SetXY($x_desc2, $y_row);
							$pdf->Cell($ancho_desc2, $row_height, number_format($prod['descuento'], 2, ',', '.'), 1, 0, 'R');
							
							// IVA
							$pdf->SetXY($x_iva, $y_row);
							$pdf->Cell($ancho_iva, $row_height, utf8_decode($prod['iva']), 1, 0, 'C');
							
							// TOTAL
							$pdf->SetXY($x_total, $y_row);
							$pdf->Cell($ancho_total, $row_height, number_format($prod['total'], 2, ',', '.'), 1, 1, 'R');
						}

			$pdf->Ln(4);
							// ==========================================
							// 6. TOTALES
							// ==========================================
							
							// Tasa BCV (izquierda)
							$pdf->SetFont('Arial', 'B', 8);
							$pdf->Cell(100, 5, utf8_decode('TASA B.C.V A LA FECHA DE EMISIÓN: BS. ' . number_format($totales['tasa_bcv'], 4, ',', '.')), 0, 0, 'L');
							
							// Tabla de totales (derecha) - Posición X corregida
							// En el PDF original está alrededor de x=109mm desde la izquierda
							$totales_x = 109;
							$col_label_width = 45;
							$col_bs_width = 28;
							$col_usd_width = 28;
							
							$totales_rows = [
								['label' => 'SUBTOTAL', 'bs' => $totales['subtotal_bs'], 'usd' => $totales['subtotal_usd']],
								['label' => 'DESCUENTO', 'bs' => $totales['descuento_bs'], 'usd' => $totales['descuento_usd']],
								['label' => 'EXENTO', 'bs' => $totales['exento_bs'], 'usd' => $totales['exento_usd']],
								['label' => 'BASE IMPONIBLE (G)', 'bs' => $totales['base_bs'], 'usd' => $totales['base_usd']],
								['label' => 'ALÍCUOTA I.V.A. (16.00%)', 'bs' => $totales['iva_bs'], 'usd' => $totales['iva_usd']],
								['label' => 'BASE IMPONIBLE (IGTF)', 'bs' => $totales['igtf_base_bs'], 'usd' => $totales['igtf_base_usd']],
								['label' => 'ALÍCUOTA IGTF (3.00%)', 'bs' => $totales['igtf_bs'], 'usd' => $totales['igtf_usd']],
								['label' => 'TOTAL A PAGAR', 'bs' => $totales['total_bs'], 'usd' => $totales['total_usd'], 'bold' => true]
							];
							
							foreach ($totales_rows as $row) {
								$pdf->SetX($totales_x);
								$font_style = isset($row['bold']) && $row['bold'] ? 'B' : '';
								$pdf->SetFont('Arial', $font_style, 7);
								
								// Label
								$pdf->Cell($col_label_width, 4.5, utf8_decode($row['label']), 0, 0, 'R');
								// Valor BS
								$pdf->Cell($col_bs_width, 4.5, number_format($row['bs'], 2, ',', '.'), 1, 0, 'R');
								// Valor USD
								$pdf->Cell($col_usd_width, 4.5, number_format($row['usd'], 2, ',', '.'), 1, 1, 'R');
							}
					
							$pdf->Ln(6);
					
							// ==========================================
							// 7. MÉTODOS DE PAGO Y LEYENDAS
							// ==========================================
							
							// Línea separadora
							$pdf->Line(2, $pdf->GetY(), 214, $pdf->GetY());
							$pdf->Ln(3);
					
							$logoPath = '../admin/storage/logo/footer.jpg';
							$logo_width = 210;  // mm
							$logo_height = 14; // mm
							
					
							
							// Insertar logo si existe
							if(file_exists($logoPath)) {
								$pdf->Image($logoPath, 2, 232, $logo_width);
							}
							
							
								
							// Salida
							$pdf->Output('I', 'factura_' . $documento['numero'] . '.pdf');
					
						} catch (Exception $e) {
							die('Error al generar el PDF: ' . $e->getMessage());
						}
		}




		public function generarFactura_NOTA($factura_id) {


			try {
				// ==========================================
				// 1. OBTENER DATOS DE LA FACTURA
				// ==========================================

				$objeto_f = new FuncionesData();
				$factura= $objeto_f->reconvertirNumeroFactura($factura_id);
				$factura_NF =  $objeto_f->convertirANF($factura_id);
				$pedido_obj = new FacturaData();
				$pedido = $pedido_obj->GetFacturaCliente($factura);
				$items = $pedido_obj->GetRenglonFacturaCliente($factura);

				error_log("[DEBUG generarFactura_NOTA PAGINA] factura_id='".$factura_id."' factura='".$factura."' pedido_rows=".count($pedido)." items=".count($items)." co_alma=".($_SESSION['co_alma'] ?? 'NULL'));
				if (!empty($pedido)) {
					error_log("[DEBUG generarFactura_NOTA PAGINA] pedido[0] dump: ".json_encode($pedido[0]));
				}

				$pedido_obj_fecha = new FuncionesData();
				$fecha_normal =  $pedido_obj_fecha->convertirFechaSimple($pedido[0]->fec_emis);
				$fecha_normal_vencimiento =  $pedido_obj_fecha->convertirFechaSimple($pedido[0]->fec_venc);


				
				// ==========================================
				// 2. REALIZAR LOS CÁLCULOS (basado en tu lógica)
				// ==========================================
				
				// Tasa de cambio (desde la base de datos)
				$tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 0.00;
				
				// Descuento global (ya viene en USD desde la base de datos)
				$descuento_global_usd = isset($pedido[0]->descuento_global) ? floatval($pedido[0]->descuento_global) : 0.00;
				
				// Fecha y hora para el documento
				$fecha_actual = date('d/m/Y');
				$hora_actual = date('h:i:s a');
				
				// =====================================================
				// ACUMULADORES (en USD)
				// =====================================================
				$total_gravado_usd = 0.00;
				$total_exento_usd = 0.00;
				$total_iva_usd = 0.00;
				$subtotal_usd = 0.00;
				$tasa_iva_general = 16.00;
				
				// Array para productos
				$productos = [];
				
				// --- ITERAR ITEMS ---
				foreach ($items as $it) {
					$precio_usd = floatval($it->prec_vta);
					$cantidad = floatval($it->cant_desp);
					
					// Base imponible del item (sin descuentos)
					$base_item_usd = $cantidad * $precio_usd;
					
					// IVA (se calcula sobre la base completa)
					$iva_item_usd = 0.00;
					$tasa_item = 0.00;
					$cod_imp = "E";
					
					// Determinar si el item está gravado o exento
					if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
						$tasa_item = $tasa_iva_general;
						$iva_item_usd = $base_item_usd * ($tasa_item / 100);
						$cod_imp = "G";
						$total_gravado_usd += $base_item_usd;
					} else {
						$total_exento_usd += $base_item_usd;
					}
					
					$total_iva_usd += $iva_item_usd;
					$subtotal_usd += $base_item_usd;
					
					// Agregar producto al array para la tabla
					$productos[] = [
						'codigo' => $it->co_art,
						'desc' => $it->art_des,
						'marca' => isset($it->marca) ? $it->marca : 'INVERSIONES',
						'cant' => $cantidad,
						'precio' => $precio_usd,
						'descuento' => 0.00, // Descuento por artículo (si aplica)
						'iva' => $cod_imp == 'G' ? '(G)' : '(E)',
						'total' => $base_item_usd + $iva_item_usd
					];
				}
				
				// =====================================================
				// APLICAR DESCUENTO GLOBAL (monto fijo en USD)
				// =====================================================
				$factor_descuento = 1;
				if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
					$factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
				}
				
				// Aplicar descuento a las bases imponibles (gravado y exento)
				$total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
				$total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
				
				// Recalcular IVA sobre la nueva base gravada
				$total_iva_con_descuento_usd = $total_gravado_con_descuento_usd * ($tasa_iva_general / 100);
				
				// Subtotal después del descuento
				$subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;
				
				// Total a pagar = subtotal con descuento + IVA recalculado
				$total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;
				
				// =====================================================
				// TOTALES EN BOLÍVARES (USD × TASA_CAMBIO)
				// =====================================================
				$total_gravado_bs = $total_gravado_con_descuento_usd * $tasa_cambio;
				$total_exento_bs = $total_exento_con_descuento_usd * $tasa_cambio;
				$total_iva_bs = $total_iva_con_descuento_usd * $tasa_cambio;
				$subtotal_bs = $subtotal_usd * $tasa_cambio;
				$total_pagar_bs = $total_pagar_usd * $tasa_cambio;
				$monto_descuento_bs = $descuento_global_usd * $tasa_cambio;
				$subtotal_antes_descuento_bs = ($subtotal_usd * $tasa_cambio);
				
				// ==========================================
				// 3. DATOS DEL DOCUMENTO
				// ==========================================
				$documento = [
					'tipo' => 'NOTA',
					'numero' => isset($factura_NF ) ? $factura_NF  : 'NF-00000001',
					'fecha_emision' =>$fecha_normal,
					'fecha_vencimiento' =>$fecha_normal_vencimiento
				];
				
				// ==========================================
				// 4. DATOS DEL CLIENTE
				// ==========================================

			

				$cliente = [
					'nombre' => isset($pedido[0]->cli_des) ? $pedido[0]->cli_des : 'SIN VALOR / PRUEBA',
					'direccion' => isset($pedido[0]->direc1) ? $pedido[0]->direc1 : 'SIN VALOR / PRUEBA',
					'rif' => isset($pedido[0]->rif) ? $pedido[0]->rif : 'SIN VALOR / PRUEBA',
					'telefono' => isset($pedido[0]->telefonos) ? $pedido[0]->telefonos : 'SIN VALOR / PRUEBA',
					'transporte' => isset($pedido[0]->des_tran) ? $pedido[0]->des_tran : 'SIN VALOR / PRUEBA',
					'vendedor' => isset($pedido[0]->ven_des) ? $pedido[0]->ven_des : 'SIN VALOR / PRUEBA',
					'zona' => isset($pedido[0]->zon_des) ? $pedido[0]->zon_des : 'SIN VALOR / PRUEBA',
					'condicion_pago' => isset($pedido[0]->forma_pag) ? $pedido[0]->forma_pag : 'SIN VALOR / PRUEBA',
					'direccion_entrega' => isset($pedido[0]->ent_fact) ? $pedido[0]->ent_fact : 'SIN VALOR / PRUEBA'
				];
				
				// ==========================================
				// 5. TOTALES PARA MOSTRAR EN EL PDF
				// ==========================================
				$totales = [
					'tasa_bcv' => $tasa_cambio,
					// USD
					'subtotal_usd' => $subtotal_usd,
					'descuento_usd' => $descuento_global_usd,
					'exento_usd' => $total_exento_con_descuento_usd,
					'base_usd' => $total_gravado_con_descuento_usd,
					'iva_usd' => $total_iva_con_descuento_usd,
					'igtf_base_usd' => 0.00,
					'igtf_usd' => 0.00,
					'total_usd' => $total_pagar_usd,
					// BS
					'subtotal_bs' => $subtotal_bs,
					'descuento_bs' => $monto_descuento_bs,
					'exento_bs' => $total_exento_bs,
					'base_bs' => $total_gravado_bs,
					'iva_bs' => $total_iva_bs,
					'igtf_base_bs' => 0.00,
					'igtf_bs' => 0.00,
					'total_bs' => $total_pagar_bs
				];
				
				// ==========================================
				// 6. CONFIGURACIÓN PDF - TAMAÑO LETTER
				// ==========================================
				$pdf = new PDF('P', 'mm', 'Letter');
				$pdf->SetMargins(2, 5, 5);
				$pdf->SetAutoPageBreak(true, 5);
				$pdf->AddPage();
				
				$y_inicial = 5;
				$logoPath = '../admin/storage/logo/logo_solsumed_01.jpg';
				
				// --- COLUMNA 1: LOGO ---
				if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 5, 10, 60);
				}

				// --- COLUMNA 2: DATOS DE LA EMPRESA (CENTRO) ---
				$x_empresa = 70; 
				$pdf->SetXY($x_empresa, $y_inicial);

				// Línea vertical separadora
				$pdf->SetDrawColor(0, 0, 0); 
				$pdf->SetLineWidth(0.6); 
				$pdf->Line($x_empresa, $y_inicial, $x_empresa, $y_inicial + 28); 
				$pdf->SetLineWidth(0.2);

				$x_texto_empresa = $x_empresa + 3;
				$pdf->SetXY($x_texto_empresa, $y_inicial);

				// Nombre de la empresa
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(70, 5, utf8_decode('GRUPO SOLSUMED OCCIDENTE, C.A'), 0, 1);

				// R.I.F.
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(70, 4, utf8_decode('R.I.F.: J-50784504-4'), 0, 1);

				// Dirección Fiscal
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(23, 4, utf8_decode('Dirección Fiscal: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('CR 27 ENTRE CALLES 19 Y 20 LOCAL NRO'), 0, 1);
				$pdf->SetX($x_texto_empresa);
				$pdf->Cell(70, 4, utf8_decode('19-73 ZONA CENTRO BARQUISIMETO LARA ZONA POSTAL 3001'), 0, 1);

				// Teléfono
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(24, 4, utf8_decode('N° DE TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, 4, utf8_decode('0424-588.55.91 / 0251-273.28.66'), 0, 1);

				// Correo
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, 4, utf8_decode('CORREO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(55, 4, utf8_decode('VENTAS@GRUPOSOLSUMED.COM'), 0, 1);

				// Página Web
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(20, 4, utf8_decode('PÁGINA WEB: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('WWW.GRUPOSOLSUMED.COM'), 0, 1);

				// --- COLUMNA 3: RECUADRO DE FACTURA (DERECHA) ---
				$x_factura = 162; 
				$pdf->SetXY($x_factura, $y_inicial);

				// Título NOTA
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->SetTextColor(15, 65, 140);
				$pdf->Cell(60, 6, 'NOTA', 0, 1, 'L');

				// Fondo gris para los datos
				$y_datos = $pdf->GetY();
				$pdf->SetFillColor(245, 246, 248);
				$pdf->Rect($x_factura - 1, $y_datos, 53, 18, 'F'); 

				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetY($y_datos + 1);

				// Matriz de datos de la factura con valores dinámicos
				$datos_factura = [
					['N° DE DOCUMENTO: ', $documento['numero'], '', 'B', ''],
					['FECHA DE EMISIÓN: ', $documento['fecha_emision'], 'B', '', ''],
					['FECHA DE VENCIMIENTO: ', $documento['fecha_vencimiento'], 'B', '', '']
				
				];

				foreach ($datos_factura as $dato) {
					$pdf->SetX($x_factura);
					
					$pdf->SetFont('Arial', $dato[2], 8);
					$w_etiqueta = $pdf->GetStringWidth(utf8_decode($dato[0]));
					$pdf->Cell($w_etiqueta, 4.5, utf8_decode($dato[0]), 0, 0);
					
					if ($dato[4] == 'R') {
						$pdf->SetTextColor(255, 0, 0);
					}
					
					$pdf->SetFont('Arial', $dato[3], 8);
					$pdf->Cell(0, 4.5, utf8_decode($dato[1]), 0, 1, 'L');
					
					$pdf->SetTextColor(0, 0, 0);
				}
				$pdf->Ln(5);
				
				// ==========================================
				// 7. DATOS DEL CLIENTE (con valores dinámicos)
				// ==========================================
				$x_col1 = 2;
				$x_col2 = 65;
				$x_col3 = 120;

				$pdf->SetFont('Arial', 'B', 8);
				$line_height = 5;

				// NOMBRE O RAZÓN SOCIAL
				$pdf->SetXY($x_col1, $pdf->GetY() + 8);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('NOMBRE O RAZÓN SOCIAL: ')) + 2, $line_height, utf8_decode('NOMBRE O RAZÓN SOCIAL: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, utf8_decode($cliente['nombre']), 0, 1);

				// DIRECCIÓN
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('DIRECCIÓN: ')) + 2, $line_height, utf8_decode('DIRECCIÓN: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion']), 0, 'L');

				// RIF / TELÉFONO / TRANSPORTE
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, $line_height, 'RIF / C.I.: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(45, $line_height, utf8_decode($cliente['rif']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, utf8_decode('TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, $line_height, $cliente['telefono'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(25, $line_height, 'TRANSPORTE: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, $cliente['transporte'], 0, 1);

				// VENDEDOR / ZONA / CONDICIÓN DE PAGO
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, 'VENDEDOR: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(42, $line_height, utf8_decode($cliente['vendedor']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(12, $line_height, 'ZONA: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, $line_height, $cliente['zona'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(35, $line_height, utf8_decode('CONDICIÓN DE PAGO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, substr($cliente['condicion_pago'], 0, 20), 0, 1);

				// DIRECCIÓN DE ENTREGA
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth('DIRECCIÓN DE ENTREGA: ') + 2, $line_height, utf8_decode('DIRECCIÓN DE ENTREGA: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion_entrega']), 0, 'L');
				$pdf->Ln(6);
				
				// ==========================================
				// 8. TABLA DE PRODUCTOS
				// ==========================================
				$pdf->SetDrawColor(0, 0, 0);
				$pdf->SetLineWidth(0.2);
				$pdf->SetFillColor(200, 200, 200);
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetTextColor(0, 0, 0);

				$y_header = $pdf->GetY();
				$x_start = 2;

				$ancho_codigo = 22;
				$ancho_desc = 83;
				$ancho_marca = 25;
				$ancho_cant = 10;
				$ancho_precio = 25;
				$ancho_desc2 = 13;
				$ancho_iva = 12;
				$ancho_total = 22;

				$x_codigo = $x_start;
				$x_desc = $x_codigo + $ancho_codigo;
				$x_marca = $x_desc + $ancho_desc;
				$x_cant = $x_marca + $ancho_marca;
				$x_precio = $x_cant + $ancho_cant;
				$x_desc2 = $x_precio + $ancho_precio;
				$x_iva = $x_desc2 + $ancho_desc2;
				$x_total = $x_iva + $ancho_iva;
				
				$pdf->SetFillColor(200, 220, 240);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetDrawColor(0, 70, 140);
				$pdf->SetLineWidth(0.3);
				$pdf->SetFont('Arial', 'B', 7);

				$x_start = $pdf->GetX();
				$y_start = $pdf->GetY();
				$header_height = 5;

				$total_ancho = $ancho_codigo + $ancho_desc + $ancho_marca + $ancho_cant + $ancho_precio + $ancho_desc2 + $ancho_iva + $ancho_total;
				$pdf->Cell($total_ancho, $header_height, '', 0, 0, '', true);
				$pdf->SetY($y_start);

				// Cabeceras de la tabla
				$pdf->SetXY($x_codigo, $y_start);
				$pdf->Cell($ancho_codigo, $header_height, utf8_decode('CÓDIGO'), 'R', 0, 'C');

				$pdf->SetXY($x_desc, $y_start);
				$pdf->Cell($ancho_desc, $header_height, utf8_decode('DESCRIPCIÓN'), 'R', 0, 'C');

				$pdf->SetXY($x_marca, $y_start);
				$pdf->Cell($ancho_marca, $header_height, utf8_decode('MARCA'), 'R', 0, 'C');

				$pdf->SetXY($x_cant, $y_start);
				$pdf->Cell($ancho_cant, $header_height, utf8_decode('CANT'), 'R', 0, 'C');

				$pdf->SetXY($x_precio, $y_start + 1);
				$pdf->MultiCell($ancho_precio, 4, "PRECIO UND", 'R', 'C');

				$pdf->SetXY($x_desc2, $y_start);
				$pdf->Cell($ancho_desc2, $header_height, 'DESC', 'R', 0, 'C');

				$pdf->SetXY($x_iva, $y_start + 1);
				$pdf->MultiCell($ancho_iva, 4, utf8_decode("I.V.A"), 'R', 'C');

				$pdf->SetXY($x_total, $y_start + 1);
				$pdf->MultiCell($ancho_total, 4, "MONTO USD", 0, 'C');

				$pdf->SetY($y_start + $header_height);
				$pdf->Ln(4);

				// ========== FILAS DE PRODUCTOS (con valores dinámicos) ==========
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetFillColor(255, 255, 255);
				$row_height = 5;

				foreach ($productos as $prod) {
					$y_antes = $pdf->GetY();
					
					// Renderizar DESCRIPCIÓN para medir
					$pdf->SetXY($x_desc, $y_antes);
					$pdf->MultiCell($ancho_desc, 5, utf8_decode($prod['desc']), 0, 'L');
					$y_despues_desc = $pdf->GetY();
					
					// Renderizar MARCA para medir
					$pdf->SetXY($x_marca, $y_antes);
					$marca_texto = !empty($prod['marca']) ? $prod['marca'] : '';
					$pdf->MultiCell($ancho_marca, 5, utf8_decode($marca_texto), 0, 'C');
					$y_despues_marca = $pdf->GetY();
					
					// Altura real de la fila
					$y_final = max($y_despues_desc, $y_despues_marca);
					$row_height_dinamico = $y_final - $y_antes;

					// Dibujar las demás celdas
					$pdf->SetXY($x_codigo, $y_antes);
					$pdf->Cell($ancho_codigo, $row_height_dinamico, utf8_decode($prod['codigo']), 0, 0, 'C');

					$pdf->SetXY($x_desc, $y_antes);
					$pdf->Cell($ancho_desc, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_marca, $y_antes);
					$pdf->Cell($ancho_marca, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_cant, $y_antes);
					$pdf->Cell($ancho_cant, $row_height_dinamico, number_format($prod['cant'], 2, ',', '.'), 0, 0, 'C');

					$pdf->SetXY($x_precio, $y_antes);
					$pdf->Cell($ancho_precio, $row_height_dinamico, number_format($prod['precio'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_desc2, $y_antes);
					$pdf->Cell($ancho_desc2, $row_height_dinamico, number_format($prod['descuento'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_iva, $y_antes);
					$pdf->Cell($ancho_iva, $row_height_dinamico, utf8_decode($prod['iva']), 0, 0, 'C');

					$pdf->SetXY($x_total, $y_antes);
					$pdf->Cell($ancho_total, $row_height_dinamico, number_format($prod['total'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetY($y_final);

					if($pdf->GetY() > 260) { 
						$pdf->AddPage();
					}
				}
				
				// ==========================================
				// 9. SECCIÓN DE TOTALES (con valores dinámicos)
				// ==========================================
				$pdf->Ln(5);
				$y_totales = 215;
				$pdf->SetY($y_totales);
				$pdf->SetFont('Arial', 'B', 8);

				// TASA BCV
				$pdf->Cell(0, 5, utf8_decode("TASA B.C.V A LA FECHA DE EMISIÓN: BS. " . number_format($totales['tasa_bcv'], 2, ',', '.')), 0, 1, 'L');
				$pdf->Ln(2);

				$y_inicio_bloque = $pdf->GetY();
				
				$labels = [
					'SUBTOTAL', 'DESCUENTO', 'EXENTO', 'BASE IMPONIBLE (G)', 
					'ALÍCUOTA I.V.A. (16.00%)', 'BASE IMPONIBLE (IGTF)', 'ALÍCUOTA IGTF (3.00%)'
				];
				
				$valores_bs = [
					$totales['subtotal_bs'],
					$totales['descuento_bs'],
					$totales['exento_bs'],
					$totales['base_bs'],
					$totales['iva_bs'],
					0.00,
					0.00
				];
				
				$valores_usd = [
					$totales['subtotal_usd'],
					$totales['descuento_usd'],
					$totales['exento_usd'],
					$totales['base_usd'],
					$totales['iva_usd'],
					0.00,
					0.00
				];

				// COLUMNA IZQUIERDA (BOLÍVARES)
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(10);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'Bs.', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_bs[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR BS
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'Bs.', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_bs'], 2, ',', '.'), 0, 1, 'R');

				// LÍNEA DIVISORIA CENTRAL
				$pdf->Line(108, $y_inicio_bloque, 108, $pdf->GetY());

				// COLUMNA DERECHA (USD)
				$pdf->SetY($y_inicio_bloque);
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(112);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'USD', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_usd[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR USD
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->SetX(112);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'USD', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_usd'], 2, ',', '.'), 0, 1, 'R');
				
				// ==========================================
				// 10. SECCIÓN: MÉTODOS DE PAGO
				// ==========================================
			

			
				// ==========================================
				// 13. GENERAR PDF
				// ==========================================
				$pdf->Output('I', 'nota_' . $documento['numero'] . '.pdf');
				
			} catch (Exception $e) {
				die('Error al generar el PDF: ' . $e->getMessage());
			}
		}


		
		public function generarFactura_FISCAL($factura_id) {


			try {
				// ==========================================
				// 1. OBTENER DATOS DE LA FACTURA
				// ==========================================

				$objeto_f = new FuncionesData();
				$factura= $objeto_f->reconvertirNumeroFactura($factura_id);
				$factura_NF =  $objeto_f->convertirANF($factura_id);
				$pedido_obj = new FacturaData();
				$pedido = $pedido_obj->GetFacturaCliente($factura);
				$items = $pedido_obj->GetRenglonFacturaCliente($factura);

				$pedido_obj_fecha = new FuncionesData();
				$fecha_normal =  $pedido_obj_fecha->convertirFechaSimple($pedido[0]->fec_emis);
				
				// ==========================================
				// 2. REALIZAR LOS CÁLCULOS (basado en tu lógica)
				// ==========================================
				
				// Tasa de cambio (desde la base de datos)
				$tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 0.00;
				
				// Descuento global (ya viene en USD desde la base de datos)
				$descuento_global_usd = isset($pedido[0]->descuento_global) ? floatval($pedido[0]->descuento_global) : 0.00;
				
				// Fecha y hora para el documento
				$fecha_actual = date('d/m/Y');
				$hora_actual = date('h:i:s a');
				
				// =====================================================
				// ACUMULADORES (en USD)
				// =====================================================
				$total_gravado_usd = 0.00;
				$total_exento_usd = 0.00;
				$total_iva_usd = 0.00;
				$subtotal_usd = 0.00;
				$tasa_iva_general = 16.00;
				
				// Array para productos
				$productos = [];
				
				// --- ITERAR ITEMS ---
				foreach ($items as $it) {
					$precio_usd = floatval($it->prec_vta);
					$cantidad = floatval($it->cant_desp);
					
					// Base imponible del item (sin descuentos)
					$base_item_usd = $cantidad * $precio_usd;
					
					// IVA (se calcula sobre la base completa)
					$iva_item_usd = 0.00;
					$tasa_item = 0.00;
					$cod_imp = "E";
					
					// Determinar si el item está gravado o exento
					if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
						$tasa_item = $tasa_iva_general;
						$iva_item_usd = $base_item_usd * ($tasa_item / 100);
						$cod_imp = "G";
						$total_gravado_usd += $base_item_usd;
					} else {
						$total_exento_usd += $base_item_usd;
					}
					
					$total_iva_usd += $iva_item_usd;
					$subtotal_usd += $base_item_usd;
					
					// Agregar producto al array para la tabla
					$productos[] = [
						'codigo' => $it->co_art,
						'desc' => $it->art_des,
						'marca' => isset($it->marca) ? $it->marca : 'INVERSIONES',
						'cant' => $cantidad,
						'precio' => $precio_usd,
						'descuento' => 0.00, // Descuento por artículo (si aplica)
						'iva' => $cod_imp == 'G' ? '(G)' : '(E)',
						'total' => $base_item_usd
					];
				}
				
				// =====================================================
				// APLICAR DESCUENTO GLOBAL (monto fijo en USD)
				// =====================================================
				$factor_descuento = 1;
				if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
					$factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
				}
				
				// Aplicar descuento a las bases imponibles (gravado y exento)
				$total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
				$total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
				
				// Recalcular IVA sobre la nueva base gravada
				$total_iva_con_descuento_usd = $total_gravado_con_descuento_usd * ($tasa_iva_general / 100);
				
				// Subtotal después del descuento
				$subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;
				
				// Total a pagar = subtotal con descuento + IVA recalculado
				$total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;
				
				// =====================================================
				// TOTALES EN BOLÍVARES (USD × TASA_CAMBIO)
				// =====================================================
				$total_gravado_bs = $total_gravado_con_descuento_usd * $tasa_cambio;
				$total_exento_bs = $total_exento_con_descuento_usd * $tasa_cambio;
				$total_iva_bs = $total_iva_con_descuento_usd * $tasa_cambio;
				$subtotal_bs = $subtotal_con_descuento_usd * $tasa_cambio;
				$total_pagar_bs = $total_pagar_usd * $tasa_cambio;
				$monto_descuento_bs = $descuento_global_usd * $tasa_cambio;
				$subtotal_antes_descuento_bs = ($subtotal_usd * $tasa_cambio);
				
				// ==========================================
				// 3. DATOS DEL DOCUMENTO
				// ==========================================
				$documento = [
					'tipo' => 'NOTA',
					'numero' => isset($factura_NF ) ? $factura_NF  : 'NF-00000001',
					'fecha_emision' =>$fecha_normal,
					'hora_emision' => $hora_actual,
					'control' =>  isset($pedido[0]->numcon ) ? $pedido[0]->numcon  : 'S/N ',
					'fecha_asignacion' =>$fecha_normal
				];
				
				// ==========================================
				// 4. DATOS DEL CLIENTE
				// ==========================================
				$cliente = [
					'nombre' => isset($pedido[0]->cli_des) ? $pedido[0]->cli_des : 'CLIENTE POR DEFECTO',
					'direccion' => isset($pedido[0]->direc1) ? $pedido[0]->direc1 : 'DIRECCION FISCAL DEL CLIENTE',
					'rif' => isset($pedido[0]->rif) ? $pedido[0]->rif : 'J-12345678',
					'telefono' => isset($pedido[0]->telefonos) ? $pedido[0]->telefonos : '58123454545',
					'transporte' => isset($pedido[0]->des_tran) ? $pedido[0]->des_tran : 'INTERNO',
					'vendedor' => isset($pedido[0]->ven_des) ? $pedido[0]->ven_des : '05 - VENDEDOR',
					'zona' => isset($pedido[0]->zon_des) ? $pedido[0]->zon_des : 'ESTADO',
					'condicion_pago' => isset($pedido[0]->forma_pag) ? $pedido[0]->forma_pag : 'CONTADO',
					'direccion_entrega' => isset($pedido[0]->ent_fact) ? $pedido[0]->ent_fact : 'ENTREGA'
				];
				
				// ==========================================
				// 5. TOTALES PARA MOSTRAR EN EL PDF
				// ==========================================
				$totales = [
					'tasa_bcv' => $tasa_cambio,
					// USD
					'subtotal_usd' => $subtotal_usd,
					'descuento_usd' => $descuento_global_usd,
					'exento_usd' => $total_exento_con_descuento_usd,
					'base_usd' => $total_gravado_con_descuento_usd,
					'iva_usd' => $total_iva_con_descuento_usd,
					'igtf_base_usd' => 0.00,
					'igtf_usd' => 0.00,
					'total_usd' => $total_pagar_usd,
					// BS
					'subtotal_bs' => $subtotal_bs,
					'descuento_bs' => $monto_descuento_bs,
					'exento_bs' => $total_exento_bs,
					'base_bs' => $total_gravado_bs,
					'iva_bs' => $total_iva_bs,
					'igtf_base_bs' => 0.00,
					'igtf_bs' => 0.00,
					'total_bs' => $total_pagar_bs
				];
				
				// ==========================================
				// 6. CONFIGURACIÓN PDF - TAMAÑO LETTER
				// ==========================================
				$pdf = new PDF('P', 'mm', 'Letter');
				$pdf->SetMargins(2, 5, 5);
				$pdf->SetAutoPageBreak(true, 5);
				$pdf->AddPage();
				
				$y_inicial = 5;
				$logoPath = '../admin/storage/logo/logo_solsumed_01.jpg';
				
				// --- COLUMNA 1: LOGO ---
				if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 5, 15, 60);
				}

				// --- COLUMNA 2: DATOS DE LA EMPRESA (CENTRO) ---
				$x_empresa = 70; 
				$pdf->SetXY($x_empresa, $y_inicial);

				// Línea vertical separadora
				$pdf->SetDrawColor(0, 0, 0); 
				$pdf->SetLineWidth(0.6); 
				$pdf->Line($x_empresa, $y_inicial, $x_empresa, $y_inicial + 32); 
				$pdf->SetLineWidth(0.2);

				$x_texto_empresa = $x_empresa + 3;
				$pdf->SetXY($x_texto_empresa, $y_inicial);

				// Nombre de la empresa
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(70, 5, utf8_decode('GRUPO SOLSUMED OCCIDENTE, C.A'), 0, 1);

				// R.I.F.
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(70, 4, utf8_decode('R.I.F.: J-50784504-4'), 0, 1);

				// Dirección Fiscal
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(23, 4, utf8_decode('Dirección Fiscal: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('CR 27 ENTRE CALLES 19 Y 20 LOCAL NRO'), 0, 1);
				$pdf->SetX($x_texto_empresa);
				$pdf->Cell(70, 4, utf8_decode('19-73 ZONA CENTRO BARQUISIMETO LARA ZONA POSTAL 3001'), 0, 1);

				// Teléfono
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(24, 4, utf8_decode('N° DE TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, 4, utf8_decode('0424-588.55.91 / 0251-273.28.66'), 0, 1);

				// Correo
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, 4, utf8_decode('CORREO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(55, 4, utf8_decode('VENTAS@GRUPOSOLSUMED.COM'), 0, 1);

				// Página Web
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(20, 4, utf8_decode('PÁGINA WEB: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('WWW.GRUPOSOLSUMED.COM'), 0, 1);

				// Código de Operación
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(70, 4, utf8_decode('CÓDIGO DE OPERACIÓN:'), 0, 1);

				// --- COLUMNA 3: RECUADRO DE FACTURA (DERECHA) ---
				$x_factura = 162; 
				$pdf->SetXY($x_factura, $y_inicial);

				// Título NOTA
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->SetTextColor(15, 65, 140);
				$pdf->Cell(60, 6, 'FACTURA', 0, 1, 'L');

				// Fondo gris para los datos
				$y_datos = $pdf->GetY();
				$pdf->SetFillColor(245, 246, 248);
				$pdf->Rect($x_factura - 1, $y_datos, 53, 24, 'F'); 

				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetY($y_datos + 1);

				// Matriz de datos de la factura con valores dinámicos
				$datos_factura = [
					['N° DE DOCUMENTO: ', $documento['numero'], '', 'B', ''],
					['FECHA DE EMISIÓN: ', $documento['fecha_emision'], 'B', '', ''],
					['HORA DE EMISIÓN: ', $documento['hora_emision'], 'B', '', ''],
					['N° DE CONTROL: ', $documento['control'], '', 'B', 'R'],
					['FECHA DE ASIGNACIÓN: ', $documento['fecha_asignacion'], 'B', '', '']
				];

				foreach ($datos_factura as $dato) {
					$pdf->SetX($x_factura);
					
					$pdf->SetFont('Arial', $dato[2], 8);
					$w_etiqueta = $pdf->GetStringWidth(utf8_decode($dato[0]));
					$pdf->Cell($w_etiqueta, 4.5, utf8_decode($dato[0]), 0, 0);
					
					if ($dato[4] == 'R') {
						$pdf->SetTextColor(255, 0, 0);
					}
					
					$pdf->SetFont('Arial', $dato[3], 8);
					$pdf->Cell(0, 4.5, utf8_decode($dato[1]), 0, 1, 'L');
					
					$pdf->SetTextColor(0, 0, 0);
				}
				$pdf->Ln(6);
				
				// ==========================================
				// 7. DATOS DEL CLIENTE (con valores dinámicos)
				// ==========================================
				$x_col1 = 2;
				$x_col2 = 65;
				$x_col3 = 120;

				$pdf->SetFont('Arial', 'B', 8);
				$line_height = 5;

				// NOMBRE O RAZÓN SOCIAL
				$pdf->SetXY($x_col1, $pdf->GetY() + 2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('NOMBRE O RAZÓN SOCIAL: ')) + 2, $line_height, utf8_decode('NOMBRE O RAZÓN SOCIAL: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, utf8_decode($cliente['nombre']), 0, 1);

				// DIRECCIÓN
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('DIRECCIÓN: ')) + 2, $line_height, utf8_decode('DIRECCIÓN: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion']), 0, 'L');

				// RIF / TELÉFONO / TRANSPORTE
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, $line_height, 'RIF / C.I.: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(45, $line_height, utf8_decode($cliente['rif']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, utf8_decode('TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, $line_height, $cliente['telefono'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(25, $line_height, 'TRANSPORTE: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, $cliente['transporte'], 0, 1);

				// VENDEDOR / ZONA / CONDICIÓN DE PAGO
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, 'VENDEDOR: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(42, $line_height, utf8_decode($cliente['vendedor']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(12, $line_height, 'ZONA: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, $line_height, $cliente['zona'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(35, $line_height, utf8_decode('CONDICIÓN DE PAGO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, substr($cliente['condicion_pago'], 0, 16), 0, 1);

				// DIRECCIÓN DE ENTREGA
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth('DIRECCIÓN DE ENTREGA: ') + 2, $line_height, utf8_decode('DIRECCIÓN DE ENTREGA: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion_entrega']), 0, 'L');
				$pdf->Ln(6);
				
				// ==========================================
				// 8. TABLA DE PRODUCTOS
				// ==========================================
				$pdf->SetDrawColor(0, 0, 0);
				$pdf->SetLineWidth(0.2);
				$pdf->SetFillColor(200, 200, 200);
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetTextColor(0, 0, 0);

				$y_header = $pdf->GetY();
				$x_start = 2;

				$ancho_codigo = 22;
				$ancho_desc = 78;
				$ancho_marca = 25;
				$ancho_cant = 10;
				$ancho_precio = 25;
				$ancho_desc2 = 13;
				$ancho_iva = 17;
				$ancho_total = 22;

				$x_codigo = $x_start;
				$x_desc = $x_codigo + $ancho_codigo;
				$x_marca = $x_desc + $ancho_desc;
				$x_cant = $x_marca + $ancho_marca;
				$x_precio = $x_cant + $ancho_cant;
				$x_desc2 = $x_precio + $ancho_precio;
				$x_iva = $x_desc2 + $ancho_desc2;
				$x_total = $x_iva + $ancho_iva;
				
				$pdf->SetFillColor(200, 220, 240);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetDrawColor(0, 70, 140);
				$pdf->SetLineWidth(0.3);
				$pdf->SetFont('Arial', 'B', 7);

				$x_start = $pdf->GetX();
				$y_start = $pdf->GetY();
				$header_height = 10;

				$total_ancho = $ancho_codigo + $ancho_desc + $ancho_marca + $ancho_cant + $ancho_precio + $ancho_desc2 + $ancho_iva + $ancho_total;
				$pdf->Cell($total_ancho, $header_height, '', 0, 0, '', true);
				$pdf->SetY($y_start);

				// Cabeceras de la tabla
				$pdf->SetXY($x_codigo, $y_start);
				$pdf->Cell($ancho_codigo, $header_height, utf8_decode('CÓDIGO'), 'R', 0, 'C');

				$pdf->SetXY($x_desc, $y_start);
				$pdf->Cell($ancho_desc, $header_height, utf8_decode('DESCRIPCIÓN'), 'R', 0, 'C');

				$pdf->SetXY($x_marca, $y_start);
				$pdf->Cell($ancho_marca, $header_height, utf8_decode('MARCA'), 'R', 0, 'C');

				$pdf->SetXY($x_cant, $y_start);
				$pdf->Cell($ancho_cant, $header_height, utf8_decode('CANT'), 'R', 0, 'C');

				$pdf->SetXY($x_precio, $y_start + 1);
				$pdf->MultiCell($ancho_precio, 4, "PRECIO\nUNITARIO USD", 'R', 'C');

				$pdf->SetXY($x_desc2, $y_start);
				$pdf->Cell($ancho_desc2, $header_height, 'DESC', 'R', 0, 'C');

				$pdf->SetXY($x_iva, $y_start + 1);
				$pdf->MultiCell($ancho_iva, 4, utf8_decode("ALÍCUOTA\nI.V.A"), 'R', 'C');

				$pdf->SetXY($x_total, $y_start + 1);
				$pdf->MultiCell($ancho_total, 4, "MONTO\nTotal USD", 0, 'C');

				$pdf->SetY($y_start + $header_height);
				$pdf->Ln(4);

				// ========== FILAS DE PRODUCTOS (con valores dinámicos) ==========
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetFillColor(255, 255, 255);
				$row_height = 5;

				foreach ($productos as $prod) {
					$y_antes = $pdf->GetY();
					
					// Renderizar DESCRIPCIÓN para medir
					$pdf->SetXY($x_desc, $y_antes);
					$pdf->MultiCell($ancho_desc, 5, utf8_decode($prod['desc']), 0, 'L');
					$y_despues_desc = $pdf->GetY();
					
					// Renderizar MARCA para medir
					$pdf->SetXY($x_marca, $y_antes);
					$marca_texto = !empty($prod['marca']) ? $prod['marca'] : '';
					$pdf->MultiCell($ancho_marca, 5, utf8_decode($marca_texto), 0, 'C');
					$y_despues_marca = $pdf->GetY();
					
					// Altura real de la fila
					$y_final = max($y_despues_desc, $y_despues_marca);
					$row_height_dinamico = $y_final - $y_antes;

					// Dibujar las demás celdas
					$pdf->SetXY($x_codigo, $y_antes);
					$pdf->Cell($ancho_codigo, $row_height_dinamico, utf8_decode($prod['codigo']), 0, 0, 'C');

					$pdf->SetXY($x_desc, $y_antes);
					$pdf->Cell($ancho_desc, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_marca, $y_antes);
					$pdf->Cell($ancho_marca, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_cant, $y_antes);
					$pdf->Cell($ancho_cant, $row_height_dinamico, number_format($prod['cant'], 2, ',', '.'), 0, 0, 'C');

					$pdf->SetXY($x_precio, $y_antes);
					$pdf->Cell($ancho_precio, $row_height_dinamico, number_format($prod['precio'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_desc2, $y_antes);
					$pdf->Cell($ancho_desc2, $row_height_dinamico, number_format($prod['descuento'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_iva, $y_antes);
					$pdf->Cell($ancho_iva, $row_height_dinamico, utf8_decode($prod['iva']), 0, 0, 'C');

					$pdf->SetXY($x_total, $y_antes);
					$pdf->Cell($ancho_total, $row_height_dinamico, number_format($prod['total'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetY($y_final);

					if($pdf->GetY() > 260) { 
						$pdf->AddPage();
					}
				}
				
				// ==========================================
				// 9. SECCIÓN DE TOTALES (con valores dinámicos)
				// ==========================================
				$pdf->Ln(5);
				$y_totales = 175;
				$pdf->SetY($y_totales);
				$pdf->SetFont('Arial', 'B', 8);

				// TASA BCV
				$pdf->Cell(0, 5, utf8_decode("TASA B.C.V A LA FECHA DE EMISIÓN: BS. " . number_format($totales['tasa_bcv'], 2, ',', '.')), 0, 1, 'L');
				$pdf->Ln(2);

				$y_inicio_bloque = $pdf->GetY();
				
				$labels = [
					'SUBTOTAL', 'DESCUENTO', 'EXENTO', 'BASE IMPONIBLE (G)', 
					'ALÍCUOTA I.V.A. (16.00%)', 'BASE IMPONIBLE (IGTF)', 'ALÍCUOTA IGTF (3.00%)'
				];
				
				$valores_bs = [
					$totales['subtotal_bs'],
					$totales['descuento_bs'],
					$totales['exento_bs'],
					$totales['base_bs'],
					$totales['iva_bs'],
					0.00,
					0.00
				];
				
				$valores_usd = [
					$totales['subtotal_usd'],
					$totales['descuento_usd'],
					$totales['exento_usd'],
					$totales['base_usd'],
					$totales['iva_usd'],
					0.00,
					0.00
				];

				// COLUMNA IZQUIERDA (BOLÍVARES)
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(10);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'Bs.', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_bs[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR BS
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'Bs.', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_bs'], 2, ',', '.'), 0, 1, 'R');

				// LÍNEA DIVISORIA CENTRAL
				$pdf->Line(108, $y_inicio_bloque, 108, $pdf->GetY());

				// COLUMNA DERECHA (USD)
				$pdf->SetY($y_inicio_bloque);
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(112);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'USD', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_usd[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR USD
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->SetX(112);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'USD', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_usd'], 2, ',', '.'), 0, 1, 'R');
				
				// ==========================================
				// 10. SECCIÓN: MÉTODOS DE PAGO
				// ==========================================
				$pdf->Ln(3);
				$pdf->SetFont('Arial', 'B', 8);
				$y_metodos = $pdf->GetY();

				$pdf->Rect(2, $y_metodos, 212, 15); 

				$pdf->SetXY(12, $y_metodos + 2);
				$pdf->Cell(35, 5, utf8_decode('MÉTODOS DE PAGO:'), 0, 0);

				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(25, 5, utf8_decode('N° de Cuenta:'), 0, 0);

				$pdf->SetFont('Arial', 'B', 8);
				$pdf->SetXY(72, $y_metodos + 2);
				$pdf->MultiCell(25, 4, "BDV\nBANESCO\nBANPLUS", 0, 'L');

				$pdf->SetFont('Arial', '', 8);
				$pdf->SetXY(97, $y_metodos + 2);
				$pdf->MultiCell(50, 4, "01020422470001577053\n0134-0218-38-2181029961\n01740139401394347197", 0, 'L');

				$pdf->SetXY(135, $y_metodos + 2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(20, 4, 'A nombre de: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, 4, 'GRUPO SOLSUMED OCCIDENTE, C.A', 0, 1);

				$pdf->SetXY(135, $y_metodos + 6);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(10, 4, 'RIF.: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, 4, 'J-50784504-4', 0, 1);

				// ==========================================
				// 11. SECCIÓN: CONDICIONES (RECUADRO AZUL)
				// ==========================================
				$pdf->Ln(6);
				$y_condiciones = $pdf->GetY();

				$pdf->SetFillColor(235, 245, 255); 
				$pdf->Rect(2, $y_condiciones, 212, 25, 'F'); 

				$pdf->SetXY(3, $y_condiciones + 2);
				$pdf->SetFont('Arial', '', 6.5);

				$texto_legal = "(*) CONDICIONES. Las partes convienen y aceptan que la obligación de pago de esta factura ha sido pactada utilizando una moneda extranjera como moneda de cuenta, según lo establecido en el articulo 8 del convenio cambiario Nro.1 de fecha 07/09/2018 Gaceta Oficial Nro. 6.405 Extraordinaria, por la cual su pago podrá realizarse en moneda extranjera o en bolívares a la tasa de cambio promedio ponderada emitida y publicada por el BCV, que corresponda a la condición de pago de la misma. Este pago estará sujeto al cobro adicional del 3.00% del Impuesto a las Grandes Transacciones Financieras (IGTF), de conformidad con la Providencia Administrativa SNAT/2022/000013 publicada en la G.O.N 42.339 del 17-03-2022, en caso de ser cancelado en divisas. No aplica en pago en Bs. Este documento se expresa en Dólares Americanos con su equivalente en Bolívares al tipo de cambio corriente del mercado a la fecha de su emisión, según lo establecido en el articulo 13 numeral 14 de la Providencia Administrativa SNAT /2011/0071 (..) en concordancia con el artículo 128 de la Ley del Banco Central de Venezuela (BCV); artículo 25 de la Ley que establece el Impuesto al Valor Agregado (IVA) y 38 del Reglamento General de la Ley que establece el Impuesto al Valor Agregado (RLIVA).";

				$pdf->MultiCell(210, 3, utf8_decode($texto_legal), 0, 'J');

				// ==========================================
				// 12. CÓDIGO QR
				// ==========================================
				$pdf->SetY(258);
				$y_footer = $pdf->GetY();

				$logoPath = '../admin/storage/logo/QRGS.jpg';
				$pdf->Image($logoPath, 185, $y_footer + 3, 15, 15);
				
				// ==========================================
				// 13. GENERAR PDF
				// ==========================================
				$pdf->Output('I', 'factura_' . $documento['numero'] . '.pdf');
				
			} catch (Exception $e) {
				die('Error al generar el PDF: ' . $e->getMessage());
			}
		}


		public function generarFacturaPdfNota($factura_id,$ruta_archivo) {


			try {
				// ==========================================
				// 1. OBTENER DATOS DE LA FACTURA
				// ==========================================

				$objeto_f = new FuncionesData();
				$factura= $objeto_f->reconvertirNumeroFactura($factura_id);
				$factura_NF =  $objeto_f->convertirANF($factura_id);
				$pedido_obj = new FacturaData();
				$pedido = $pedido_obj->GetFacturaCliente($factura);
				$items = $pedido_obj->GetRenglonFacturaCliente($factura);

				error_log("[DEBUG generarFacturaPdfNota] factura_id='".$factura_id."' factura='".$factura."' pedido_rows=".count($pedido)." items=".count($items)." co_alma=".($_SESSION['co_alma'] ?? 'NULL'));
				if (!empty($pedido)) {
					error_log("[DEBUG generarFacturaPdfNota] pedido[0] dump: ".json_encode($pedido[0]));
				}

				$pedido_obj_fecha = new FuncionesData();
				$fecha_normal =  $pedido_obj_fecha->convertirFechaSimple($pedido[0]->fec_emis);
				$fecha_normal_vencimiento =  $pedido_obj_fecha->convertirFechaSimple($pedido[0]->fec_venc);


				
				// ==========================================
				// 2. REALIZAR LOS CÁLCULOS (basado en tu lógica)
				// ==========================================
				
				// Tasa de cambio (desde la base de datos)
				$tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 0.00;
				
				// Descuento global (ya viene en USD desde la base de datos)
				$descuento_global_usd = isset($pedido[0]->descuento_global) ? floatval($pedido[0]->descuento_global) : 0.00;
				
				// Fecha y hora para el documento
				$fecha_actual = date('d/m/Y');
				$hora_actual = date('h:i:s a');
				
				// =====================================================
				// ACUMULADORES (en USD)
				// =====================================================
				$total_gravado_usd = 0.00;
				$total_exento_usd = 0.00;
				$total_iva_usd = 0.00;
				$subtotal_usd = 0.00;
				$tasa_iva_general = 16.00;
				
				// Array para productos
				$productos = [];
				
				// --- ITERAR ITEMS ---
				foreach ($items as $it) {
					$precio_usd = floatval($it->prec_vta);
					$cantidad = floatval($it->cant_desp);
					
					// Base imponible del item (sin descuentos)
					$base_item_usd = $cantidad * $precio_usd;
					
					// IVA (se calcula sobre la base completa)
					$iva_item_usd = 0.00;
					$tasa_item = 0.00;
					$cod_imp = "E";
					
					// Determinar si el item está gravado o exento
					if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
						$tasa_item = $tasa_iva_general;
						$iva_item_usd = $base_item_usd * ($tasa_item / 100);
						$cod_imp = "G";
						$total_gravado_usd += $base_item_usd;
					} else {
						$total_exento_usd += $base_item_usd;
					}
					
					$total_iva_usd += $iva_item_usd;
					$subtotal_usd += $base_item_usd;
					
					// Agregar producto al array para la tabla
					$productos[] = [
						'codigo' => $it->co_art,
						'desc' => $it->art_des,
						'marca' => isset($it->marca) ? $it->marca : 'INVERSIONES',
						'cant' => $cantidad,
						'precio' => $precio_usd,
						'descuento' => 0.00, // Descuento por artículo (si aplica)
						'iva' => $cod_imp == 'G' ? '(G)' : '(E)',
						'total' => $base_item_usd + $iva_item_usd
					];
				}
				
				// =====================================================
				// APLICAR DESCUENTO GLOBAL (monto fijo en USD)
				// =====================================================
				$factor_descuento = 1;
				if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
					$factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
				}
				
				// Aplicar descuento a las bases imponibles (gravado y exento)
				$total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
				$total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
				
				// Recalcular IVA sobre la nueva base gravada
				$total_iva_con_descuento_usd = $total_gravado_con_descuento_usd * ($tasa_iva_general / 100);
				
				// Subtotal después del descuento
				$subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;
				
				// Total a pagar = subtotal con descuento + IVA recalculado
				$total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;
				
				// =====================================================
				// TOTALES EN BOLÍVARES (USD × TASA_CAMBIO)
				// =====================================================
				$total_gravado_bs = $total_gravado_con_descuento_usd * $tasa_cambio;
				$total_exento_bs = $total_exento_con_descuento_usd * $tasa_cambio;
				$total_iva_bs = $total_iva_con_descuento_usd * $tasa_cambio;
				$subtotal_bs = $subtotal_usd * $tasa_cambio;
				$total_pagar_bs = $total_pagar_usd * $tasa_cambio;
				$monto_descuento_bs = $descuento_global_usd * $tasa_cambio;
				$subtotal_antes_descuento_bs = ($subtotal_usd * $tasa_cambio);
				
				// ==========================================
				// 3. DATOS DEL DOCUMENTO
				// ==========================================
				$documento = [
					'tipo' => 'NOTA',
					'numero' => isset($factura_NF ) ? $factura_NF  : 'NF-00000001',
					'fecha_emision' =>$fecha_normal,
					'fecha_vencimiento' =>$fecha_normal_vencimiento
				];

				

				
				// ==========================================
				// 4. DATOS DEL CLIENTE
				// ==========================================
				$cliente = [
					'nombre' => isset($pedido[0]->cli_des) ? $pedido[0]->cli_des : 'SIN VALOR / PRUEBA',
					'direccion' => isset($pedido[0]->direc1) ? $pedido[0]->direc1 : 'SIN VALOR / PRUEBA',
					'rif' => isset($pedido[0]->rif) ? $pedido[0]->rif : 'SIN VALOR / PRUEBA',
					'telefono' => isset($pedido[0]->telefonos) ? $pedido[0]->telefonos : 'SIN VALOR / PRUEBA',
					'transporte' => isset($pedido[0]->des_tran) ? $pedido[0]->des_tran : 'SIN VALOR / PRUEBA',
					'vendedor' => isset($pedido[0]->ven_des) ? $pedido[0]->ven_des : 'SIN VALOR / PRUEBA',
					'zona' => isset($pedido[0]->zon_des) ? $pedido[0]->zon_des : 'SIN VALOR / PRUEBA',
					'condicion_pago' => isset($pedido[0]->forma_pag) ? $pedido[0]->forma_pag : 'SIN VALOR / PRUEBA',
					'direccion_entrega' => isset($pedido[0]->ent_fact) ? $pedido[0]->ent_fact : 'SIN VALOR / PRUEBA'
				];
				
				// ==========================================
				// 5. TOTALES PARA MOSTRAR EN EL PDF
				// ==========================================
				$totales = [
					'tasa_bcv' => $tasa_cambio,
					// USD
					'subtotal_usd' => $subtotal_usd,
					'descuento_usd' => $descuento_global_usd,
					'exento_usd' => $total_exento_con_descuento_usd,
					'base_usd' => $total_gravado_con_descuento_usd,
					'iva_usd' => $total_iva_con_descuento_usd,
					'igtf_base_usd' => 0.00,
					'igtf_usd' => 0.00,
					'total_usd' => $total_pagar_usd,
					// BS
					'subtotal_bs' => $subtotal_bs,
					'descuento_bs' => $monto_descuento_bs,
					'exento_bs' => $total_exento_bs,
					'base_bs' => $total_gravado_bs,
					'iva_bs' => $total_iva_bs,
					'igtf_base_bs' => 0.00,
					'igtf_bs' => 0.00,
					'total_bs' => $total_pagar_bs
				];
				
				// ==========================================
				// 6. CONFIGURACIÓN PDF - TAMAÑO LETTER
				// ==========================================
				$pdf = new PDF('P', 'mm', 'Letter');
				$pdf->SetMargins(2, 5, 5);
				$pdf->SetAutoPageBreak(true, 5);
				$pdf->AddPage();
				
				$y_inicial = 5;
				$logoPath = '../admin/storage/logo/logo_solsumed_01.jpg';
				
				// --- COLUMNA 1: LOGO ---
				if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 5, 10, 60);
				}

				// --- COLUMNA 2: DATOS DE LA EMPRESA (CENTRO) ---
				$x_empresa = 70; 
				$pdf->SetXY($x_empresa, $y_inicial);

				// Línea vertical separadora
				$pdf->SetDrawColor(0, 0, 0); 
				$pdf->SetLineWidth(0.6); 
				$pdf->Line($x_empresa, $y_inicial, $x_empresa, $y_inicial + 28); 
				$pdf->SetLineWidth(0.2);

				$x_texto_empresa = $x_empresa + 3;
				$pdf->SetXY($x_texto_empresa, $y_inicial);

				// Nombre de la empresa
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(70, 5, utf8_decode('GRUPO SOLSUMED OCCIDENTE, C.A'), 0, 1);

				// R.I.F.
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(70, 4, utf8_decode('R.I.F.: J-50784504-4'), 0, 1);

				// Dirección Fiscal
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(23, 4, utf8_decode('Dirección Fiscal: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('CR 27 ENTRE CALLES 19 Y 20 LOCAL NRO'), 0, 1);
				$pdf->SetX($x_texto_empresa);
				$pdf->Cell(70, 4, utf8_decode('19-73 ZONA CENTRO BARQUISIMETO LARA ZONA POSTAL 3001'), 0, 1);

				// Teléfono
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(24, 4, utf8_decode('N° DE TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, 4, utf8_decode('0424-588.55.91 / 0251-273.28.66'), 0, 1);

				// Correo
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, 4, utf8_decode('CORREO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(55, 4, utf8_decode('VENTAS@GRUPOSOLSUMED.COM'), 0, 1);

				// Página Web
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(20, 4, utf8_decode('PÁGINA WEB: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('WWW.GRUPOSOLSUMED.COM'), 0, 1);

				// --- COLUMNA 3: RECUADRO DE FACTURA (DERECHA) ---
				$x_factura = 162; 
				$pdf->SetXY($x_factura, $y_inicial);

				// Título NOTA
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->SetTextColor(15, 65, 140);
				$pdf->Cell(60, 6, 'NOTA', 0, 1, 'L');

				// Fondo gris para los datos
				$y_datos = $pdf->GetY();
				$pdf->SetFillColor(245, 246, 248);
				$pdf->Rect($x_factura - 1, $y_datos, 53, 18, 'F'); 

				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetY($y_datos + 1);

				// Matriz de datos de la factura con valores dinámicos
				$datos_factura = [
					['N° DE DOCUMENTO: ', $documento['numero'], '', 'B', ''],
					['FECHA DE EMISIÓN: ', $documento['fecha_emision'], 'B', '', '']
				
				
				];

				foreach ($datos_factura as $dato) {
					$pdf->SetX($x_factura);
					
					$pdf->SetFont('Arial', $dato[2], 8);
					$w_etiqueta = $pdf->GetStringWidth(utf8_decode($dato[0]));
					$pdf->Cell($w_etiqueta, 4.5, utf8_decode($dato[0]), 0, 0);
					
					if ($dato[4] == 'R') {
						$pdf->SetTextColor(255, 0, 0);
					}
					
					$pdf->SetFont('Arial', $dato[3], 8);
					$pdf->Cell(0, 4.5, utf8_decode($dato[1]), 0, 1, 'L');
					
					$pdf->SetTextColor(0, 0, 0);
				}
				$pdf->Ln(5);
				
				// ==========================================
				// 7. DATOS DEL CLIENTE (con valores dinámicos)
				// ==========================================
				$x_col1 = 2;
				$x_col2 = 65;
				$x_col3 = 120;

				$pdf->SetFont('Arial', 'B', 8);
				$line_height = 5;

				// NOMBRE O RAZÓN SOCIAL
				$pdf->SetXY($x_col1, $pdf->GetY() + 8);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('NOMBRE O RAZÓN SOCIAL: ')) + 2, $line_height, utf8_decode('NOMBRE O RAZÓN SOCIAL: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, utf8_decode($cliente['nombre']), 0, 1);

				// DIRECCIÓN
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('DIRECCIÓN: ')) + 2, $line_height, utf8_decode('DIRECCIÓN: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion']), 0, 'L');

				// RIF / TELÉFONO / TRANSPORTE
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, $line_height, 'RIF / C.I.: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(45, $line_height, utf8_decode($cliente['rif']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, utf8_decode('TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, $line_height, $cliente['telefono'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(25, $line_height, 'TRANSPORTE: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, $cliente['transporte'], 0, 1);

				// VENDEDOR / ZONA / CONDICIÓN DE PAGO
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, 'VENDEDOR: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(42, $line_height, utf8_decode($cliente['vendedor']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(12, $line_height, 'ZONA: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, $line_height, $cliente['zona'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(35, $line_height, utf8_decode('CONDICIÓN DE PAGO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, substr($cliente['condicion_pago'], 0, 20), 0, 1);

				// DIRECCIÓN DE ENTREGA
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth('DIRECCIÓN DE ENTREGA: ') + 2, $line_height, utf8_decode('DIRECCIÓN DE ENTREGA: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion_entrega']), 0, 'L');
				$pdf->Ln(6);
				
				// ==========================================
				// 8. TABLA DE PRODUCTOS
				// ==========================================
				$pdf->SetDrawColor(0, 0, 0);
				$pdf->SetLineWidth(0.2);
				$pdf->SetFillColor(200, 200, 200);
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetTextColor(0, 0, 0);

				$y_header = $pdf->GetY();
				$x_start = 2;

				$ancho_codigo = 22;
				$ancho_desc = 83;
				$ancho_marca = 25;
				$ancho_cant = 10;
				$ancho_precio = 25;
				$ancho_desc2 = 13;
				$ancho_iva = 12;
				$ancho_total = 22;

				$x_codigo = $x_start;
				$x_desc = $x_codigo + $ancho_codigo;
				$x_marca = $x_desc + $ancho_desc;
				$x_cant = $x_marca + $ancho_marca;
				$x_precio = $x_cant + $ancho_cant;
				$x_desc2 = $x_precio + $ancho_precio;
				$x_iva = $x_desc2 + $ancho_desc2;
				$x_total = $x_iva + $ancho_iva;
				
				$pdf->SetFillColor(200, 220, 240);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetDrawColor(0, 70, 140);
				$pdf->SetLineWidth(0.3);
				$pdf->SetFont('Arial', 'B', 7);

				$x_start = $pdf->GetX();
				$y_start = $pdf->GetY();
				$header_height = 5;

				$total_ancho = $ancho_codigo + $ancho_desc + $ancho_marca + $ancho_cant + $ancho_precio + $ancho_desc2 + $ancho_iva + $ancho_total;
				$pdf->Cell($total_ancho, $header_height, '', 0, 0, '', true);
				$pdf->SetY($y_start);

				// Cabeceras de la tabla
				$pdf->SetXY($x_codigo, $y_start);
				$pdf->Cell($ancho_codigo, $header_height, utf8_decode('CÓDIGO'), 'R', 0, 'C');

				$pdf->SetXY($x_desc, $y_start);
				$pdf->Cell($ancho_desc, $header_height, utf8_decode('DESCRIPCIÓN'), 'R', 0, 'C');

				$pdf->SetXY($x_marca, $y_start);
				$pdf->Cell($ancho_marca, $header_height, utf8_decode('MARCA'), 'R', 0, 'C');

				$pdf->SetXY($x_cant, $y_start);
				$pdf->Cell($ancho_cant, $header_height, utf8_decode('CANT'), 'R', 0, 'C');

				$pdf->SetXY($x_precio, $y_start + 1);
				$pdf->MultiCell($ancho_precio, 4, "PRECIO UND", 'R', 'C');

				$pdf->SetXY($x_desc2, $y_start);
				$pdf->Cell($ancho_desc2, $header_height, 'DESC', 'R', 0, 'C');

				$pdf->SetXY($x_iva, $y_start + 1);
				$pdf->MultiCell($ancho_iva, 4, utf8_decode("I.V.A"), 'R', 'C');

				$pdf->SetXY($x_total, $y_start + 1);
				$pdf->MultiCell($ancho_total, 4, "MONTO USD", 0, 'C');

				$pdf->SetY($y_start + $header_height);
				$pdf->Ln(4);

				// ========== FILAS DE PRODUCTOS (con valores dinámicos) ==========
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetFillColor(255, 255, 255);
				$row_height = 5;

				foreach ($productos as $prod) {
					$y_antes = $pdf->GetY();
					
					// Renderizar DESCRIPCIÓN para medir
					$pdf->SetXY($x_desc, $y_antes);
					$pdf->MultiCell($ancho_desc, 5, utf8_decode($prod['desc']), 0, 'L');
					$y_despues_desc = $pdf->GetY();
					
					// Renderizar MARCA para medir
					$pdf->SetXY($x_marca, $y_antes);
					$marca_texto = !empty($prod['marca']) ? $prod['marca'] : '';
					$pdf->MultiCell($ancho_marca, 5, utf8_decode($marca_texto), 0, 'C');
					$y_despues_marca = $pdf->GetY();
					
					// Altura real de la fila
					$y_final = max($y_despues_desc, $y_despues_marca);
					$row_height_dinamico = $y_final - $y_antes;

					// Dibujar las demás celdas
					$pdf->SetXY($x_codigo, $y_antes);
					$pdf->Cell($ancho_codigo, $row_height_dinamico, utf8_decode($prod['codigo']), 0, 0, 'C');

					$pdf->SetXY($x_desc, $y_antes);
					$pdf->Cell($ancho_desc, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_marca, $y_antes);
					$pdf->Cell($ancho_marca, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_cant, $y_antes);
					$pdf->Cell($ancho_cant, $row_height_dinamico, number_format($prod['cant'], 2, ',', '.'), 0, 0, 'C');

					$pdf->SetXY($x_precio, $y_antes);
					$pdf->Cell($ancho_precio, $row_height_dinamico, number_format($prod['precio'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_desc2, $y_antes);
					$pdf->Cell($ancho_desc2, $row_height_dinamico, number_format($prod['descuento'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_iva, $y_antes);
					$pdf->Cell($ancho_iva, $row_height_dinamico, utf8_decode($prod['iva']), 0, 0, 'C');

					$pdf->SetXY($x_total, $y_antes);
					$pdf->Cell($ancho_total, $row_height_dinamico, number_format($prod['total'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetY($y_final);

					if($pdf->GetY() > 260) { 
						$pdf->AddPage();
					}
				}
				
				// ==========================================
				// 9. SECCIÓN DE TOTALES (con valores dinámicos)
				// ==========================================
				$pdf->Ln(5);
				$y_totales = 215;
				$pdf->SetY($y_totales);
				$pdf->SetFont('Arial', 'B', 8);

				// TASA BCV
				$pdf->Cell(0, 5, utf8_decode("TASA B.C.V A LA FECHA DE EMISIÓN: BS. " . number_format($totales['tasa_bcv'], 2, ',', '.')), 0, 1, 'L');
				$pdf->Ln(2);

				$y_inicio_bloque = $pdf->GetY();
				
				$labels = [
					'SUBTOTAL', 'DESCUENTO', 'EXENTO', 'BASE IMPONIBLE (G)', 
					'ALÍCUOTA I.V.A. (16.00%)', 'BASE IMPONIBLE (IGTF)', 'ALÍCUOTA IGTF (3.00%)'
				];
				
				$valores_bs = [
					$totales['subtotal_bs'],
					$totales['descuento_bs'],
					$totales['exento_bs'],
					$totales['base_bs'],
					$totales['iva_bs'],
					0.00,
					0.00
				];
				
				$valores_usd = [
					$totales['subtotal_usd'],
					$totales['descuento_usd'],
					$totales['exento_usd'],
					$totales['base_usd'],
					$totales['iva_usd'],
					0.00,
					0.00
				];

				// COLUMNA IZQUIERDA (BOLÍVARES)
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(10);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'Bs.', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_bs[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR BS
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'Bs.', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_bs'], 2, ',', '.'), 0, 1, 'R');

				// LÍNEA DIVISORIA CENTRAL
				$pdf->Line(108, $y_inicio_bloque, 108, $pdf->GetY());

				// COLUMNA DERECHA (USD)
				$pdf->SetY($y_inicio_bloque);
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(112);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'USD', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_usd[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR USD
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->SetX(112);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'USD', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_usd'], 2, ',', '.'), 0, 1, 'R');
				
				// ==========================================
				// 10. SECCIÓN: MÉTODOS DE PAGO
				// ==========================================
				

							

			
				$pdf->Output($ruta_archivo, 'F');  // 'F' = Guardar en archivo local
				
			} catch (Exception $e) {
				throw new Exception('Error al generar PDF para archivo: ' . $e->getMessage());
			}
		}


		public function generarFacturaPdfFiscal($factura_id,$ruta_archivo) {


			try {
				// ==========================================
				// 1. OBTENER DATOS DE LA FACTURA
				// ==========================================

				$objeto_f = new FuncionesData();
				$factura= $objeto_f->reconvertirNumeroFactura($factura_id);
				$factura_NF =  $objeto_f->convertirANF($factura_id);
				$pedido_obj = new FacturaData();
				$pedido = $pedido_obj->GetFacturaCliente($factura);
				$items = $pedido_obj->GetRenglonFacturaCliente($factura);

				$pedido_obj_fecha = new FuncionesData();
				$fecha_normal =  $pedido_obj_fecha->convertirFechaSimple($pedido[0]->fec_emis);
				
				// ==========================================
				// 2. REALIZAR LOS CÁLCULOS (basado en tu lógica)
				// ==========================================
				
				// Tasa de cambio (desde la base de datos)
				$tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 0.00;
				
				// Descuento global (ya viene en USD desde la base de datos)
				$descuento_global_usd = isset($pedido[0]->descuento_global) ? floatval($pedido[0]->descuento_global) : 0.00;
				
				// Fecha y hora para el documento
				$fecha_actual = date('d/m/Y');
				$hora_actual = date('h:i:s a');
				
				// =====================================================
				// ACUMULADORES (en USD)
				// =====================================================
				$total_gravado_usd = 0.00;
				$total_exento_usd = 0.00;
				$total_iva_usd = 0.00;
				$subtotal_usd = 0.00;
				$tasa_iva_general = 16.00;
				
				// Array para productos
				$productos = [];
				
				// --- ITERAR ITEMS ---
				foreach ($items as $it) {
					$precio_usd = floatval($it->prec_vta);
					$cantidad = floatval($it->cant_desp);
					
					// Base imponible del item (sin descuentos)
					$base_item_usd = $cantidad * $precio_usd;
					
					// IVA (se calcula sobre la base completa)
					$iva_item_usd = 0.00;
					$tasa_item = 0.00;
					$cod_imp = "E";
					
					// Determinar si el item está gravado o exento
					if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
						$tasa_item = $tasa_iva_general;
						$iva_item_usd = $base_item_usd * ($tasa_item / 100);
						$cod_imp = "G";
						$total_gravado_usd += $base_item_usd;
					} else {
						$total_exento_usd += $base_item_usd;
					}
					
					$total_iva_usd += $iva_item_usd;
					$subtotal_usd += $base_item_usd;
					
					// Agregar producto al array para la tabla
					$productos[] = [
						'codigo' => $it->co_art,
						'desc' => $it->art_des,
						'marca' => isset($it->marca) ? $it->marca : 'INVERSIONES',
						'cant' => $cantidad,
						'precio' => $precio_usd,
						'descuento' => 0.00, // Descuento por artículo (si aplica)
						'iva' => $cod_imp == 'G' ? '(G)' : '(E)',
						'total' => $base_item_usd
					];
				}
				
				// =====================================================
				// APLICAR DESCUENTO GLOBAL (monto fijo en USD)
				// =====================================================
				$factor_descuento = 1;
				if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
					$factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
				}
				
				// Aplicar descuento a las bases imponibles (gravado y exento)
				$total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
				$total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
				
				// Recalcular IVA sobre la nueva base gravada
				$total_iva_con_descuento_usd = $total_gravado_con_descuento_usd * ($tasa_iva_general / 100);
				
				// Subtotal después del descuento
				$subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;
				
				// Total a pagar = subtotal con descuento + IVA recalculado
				$total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;
				
				// =====================================================
				// TOTALES EN BOLÍVARES (USD × TASA_CAMBIO)
				// =====================================================
				$total_gravado_bs = $total_gravado_con_descuento_usd * $tasa_cambio;
				$total_exento_bs = $total_exento_con_descuento_usd * $tasa_cambio;
				$total_iva_bs = $total_iva_con_descuento_usd * $tasa_cambio;
				$subtotal_bs = $subtotal_con_descuento_usd * $tasa_cambio;
				$total_pagar_bs = $total_pagar_usd * $tasa_cambio;
				$monto_descuento_bs = $descuento_global_usd * $tasa_cambio;
				$subtotal_antes_descuento_bs = ($subtotal_usd * $tasa_cambio);
				
				// ==========================================
				// 3. DATOS DEL DOCUMENTO
				// ==========================================
				$documento = [
					'tipo' => 'NOTA',
					'numero' => isset($factura_NF ) ? $factura_NF  : 'NF-00000001',
					'fecha_emision' =>$fecha_normal,
					'hora_emision' => $hora_actual,
					'control' =>  isset($pedido[0]->numcon ) ? $pedido[0]->numcon  : 'S/N ',
					'fecha_asignacion' =>$fecha_normal
				];
				
				// ==========================================
				// 4. DATOS DEL CLIENTE
				// ==========================================
				$cliente = [
					'nombre' => isset($pedido[0]->cli_des) ? $pedido[0]->cli_des : 'CLIENTE POR DEFECTO',
					'direccion' => isset($pedido[0]->direc1) ? $pedido[0]->direc1 : 'DIRECCION FISCAL DEL CLIENTE',
					'rif' => isset($pedido[0]->rif) ? $pedido[0]->rif : 'J-12345678',
					'telefono' => isset($pedido[0]->telefonos) ? $pedido[0]->telefonos : '58123454545',
					'transporte' => isset($pedido[0]->des_tran) ? $pedido[0]->des_tran : 'INTERNO',
					'vendedor' => isset($pedido[0]->ven_des) ? $pedido[0]->ven_des : '05 - VENDEDOR',
					'zona' => isset($pedido[0]->zon_des) ? $pedido[0]->zon_des : 'ESTADO',
					'condicion_pago' => isset($pedido[0]->forma_pag) ? $pedido[0]->forma_pag : 'CONTADO',
					'direccion_entrega' => isset($pedido[0]->ent_fact) ? $pedido[0]->ent_fact : 'ENTREGA'
				];
				
				// ==========================================
				// 5. TOTALES PARA MOSTRAR EN EL PDF
				// ==========================================
				$totales = [
					'tasa_bcv' => $tasa_cambio,
					// USD
					'subtotal_usd' => $subtotal_usd,
					'descuento_usd' => $descuento_global_usd,
					'exento_usd' => $total_exento_con_descuento_usd,
					'base_usd' => $total_gravado_con_descuento_usd,
					'iva_usd' => $total_iva_con_descuento_usd,
					'igtf_base_usd' => 0.00,
					'igtf_usd' => 0.00,
					'total_usd' => $total_pagar_usd,
					// BS
					'subtotal_bs' => $subtotal_bs,
					'descuento_bs' => $monto_descuento_bs,
					'exento_bs' => $total_exento_bs,
					'base_bs' => $total_gravado_bs,
					'iva_bs' => $total_iva_bs,
					'igtf_base_bs' => 0.00,
					'igtf_bs' => 0.00,
					'total_bs' => $total_pagar_bs
				];
				
				// ==========================================
				// 6. CONFIGURACIÓN PDF - TAMAÑO LETTER
				// ==========================================
				$pdf = new PDF('P', 'mm', 'Letter');
				$pdf->SetMargins(2, 5, 5);
				$pdf->SetAutoPageBreak(true, 5);
				$pdf->AddPage();
				
				$y_inicial = 5;
				$logoPath = '../admin/storage/logo/logo_solsumed_01.jpg';
				
				// --- COLUMNA 1: LOGO ---
				if(file_exists($logoPath)) {
					$pdf->Image($logoPath, 5, 15, 60);
				}

				// --- COLUMNA 2: DATOS DE LA EMPRESA (CENTRO) ---
				$x_empresa = 70; 
				$pdf->SetXY($x_empresa, $y_inicial);

				// Línea vertical separadora
				$pdf->SetDrawColor(0, 0, 0); 
				$pdf->SetLineWidth(0.6); 
				$pdf->Line($x_empresa, $y_inicial, $x_empresa, $y_inicial + 32); 
				$pdf->SetLineWidth(0.2);

				$x_texto_empresa = $x_empresa + 3;
				$pdf->SetXY($x_texto_empresa, $y_inicial);

				// Nombre de la empresa
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(70, 5, utf8_decode('GRUPO SOLSUMED OCCIDENTE, C.A'), 0, 1);

				// R.I.F.
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(70, 4, utf8_decode('R.I.F.: J-50784504-4'), 0, 1);

				// Dirección Fiscal
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(23, 4, utf8_decode('Dirección Fiscal: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('CR 27 ENTRE CALLES 19 Y 20 LOCAL NRO'), 0, 1);
				$pdf->SetX($x_texto_empresa);
				$pdf->Cell(70, 4, utf8_decode('19-73 ZONA CENTRO BARQUISIMETO LARA ZONA POSTAL 3001'), 0, 1);

				// Teléfono
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(24, 4, utf8_decode('N° DE TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, 4, utf8_decode('0424-588.55.91 / 0251-273.28.66'), 0, 1);

				// Correo
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, 4, utf8_decode('CORREO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(55, 4, utf8_decode('VENTAS@GRUPOSOLSUMED.COM'), 0, 1);

				// Página Web
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(20, 4, utf8_decode('PÁGINA WEB: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(50, 4, utf8_decode('WWW.GRUPOSOLSUMED.COM'), 0, 1);

				// Código de Operación
				$pdf->SetX($x_texto_empresa);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(70, 4, utf8_decode('CÓDIGO DE OPERACIÓN:'), 0, 1);

				// --- COLUMNA 3: RECUADRO DE FACTURA (DERECHA) ---
				$x_factura = 162; 
				$pdf->SetXY($x_factura, $y_inicial);

				// Título NOTA
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->SetTextColor(15, 65, 140);
				$pdf->Cell(60, 6, 'FACTURA', 0, 1, 'L');

				// Fondo gris para los datos
				$y_datos = $pdf->GetY();
				$pdf->SetFillColor(245, 246, 248);
				$pdf->Rect($x_factura - 1, $y_datos, 53, 24, 'F'); 

				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetY($y_datos + 1);

				// Matriz de datos de la factura con valores dinámicos
				$datos_factura = [
					['N° DE DOCUMENTO: ', $documento['numero'], '', 'B', ''],
					['FECHA DE EMISIÓN: ', $documento['fecha_emision'], 'B', '', ''],
					['HORA DE EMISIÓN: ', $documento['hora_emision'], 'B', '', ''],
					['N° DE CONTROL: ', $documento['control'], '', 'B', 'R'],
					['FECHA DE ASIGNACIÓN: ', $documento['fecha_asignacion'], 'B', '', '']
				];

				foreach ($datos_factura as $dato) {
					$pdf->SetX($x_factura);
					
					$pdf->SetFont('Arial', $dato[2], 8);
					$w_etiqueta = $pdf->GetStringWidth(utf8_decode($dato[0]));
					$pdf->Cell($w_etiqueta, 4.5, utf8_decode($dato[0]), 0, 0);
					
					if ($dato[4] == 'R') {
						$pdf->SetTextColor(255, 0, 0);
					}
					
					$pdf->SetFont('Arial', $dato[3], 8);
					$pdf->Cell(0, 4.5, utf8_decode($dato[1]), 0, 1, 'L');
					
					$pdf->SetTextColor(0, 0, 0);
				}
				$pdf->Ln(6);
				
				// ==========================================
				// 7. DATOS DEL CLIENTE (con valores dinámicos)
				// ==========================================
				$x_col1 = 2;
				$x_col2 = 65;
				$x_col3 = 120;

				$pdf->SetFont('Arial', 'B', 8);
				$line_height = 5;

				// NOMBRE O RAZÓN SOCIAL
				$pdf->SetXY($x_col1, $pdf->GetY() + 2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('NOMBRE O RAZÓN SOCIAL: ')) + 2, $line_height, utf8_decode('NOMBRE O RAZÓN SOCIAL: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, utf8_decode($cliente['nombre']), 0, 1);

				// DIRECCIÓN
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth(utf8_decode('DIRECCIÓN: ')) + 2, $line_height, utf8_decode('DIRECCIÓN: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion']), 0, 'L');

				// RIF / TELÉFONO / TRANSPORTE
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(15, $line_height, 'RIF / C.I.: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(45, $line_height, utf8_decode($cliente['rif']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, utf8_decode('TELÉFONO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, $line_height, $cliente['telefono'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(25, $line_height, 'TRANSPORTE: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, $cliente['transporte'], 0, 1);

				// VENDEDOR / ZONA / CONDICIÓN DE PAGO
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(18, $line_height, 'VENDEDOR: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(42, $line_height, utf8_decode($cliente['vendedor']), 0, 0);

				$pdf->SetX($x_col2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(12, $line_height, 'ZONA: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(46, $line_height, $cliente['zona'], 0, 0);

				$pdf->SetX($x_col3);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(35, $line_height, utf8_decode('CONDICIÓN DE PAGO: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, $line_height, substr($cliente['condicion_pago'], 0, 16), 0, 1);

				// DIRECCIÓN DE ENTREGA
				$pdf->SetX($x_col1);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell($pdf->GetStringWidth('DIRECCIÓN DE ENTREGA: ') + 2, $line_height, utf8_decode('DIRECCIÓN DE ENTREGA: '), 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(0, $line_height, utf8_decode($cliente['direccion_entrega']), 0, 'L');
				$pdf->Ln(6);
				
				// ==========================================
				// 8. TABLA DE PRODUCTOS
				// ==========================================
				$pdf->SetDrawColor(0, 0, 0);
				$pdf->SetLineWidth(0.2);
				$pdf->SetFillColor(200, 200, 200);
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetTextColor(0, 0, 0);

				$y_header = $pdf->GetY();
				$x_start = 2;

				$ancho_codigo = 22;
				$ancho_desc = 78;
				$ancho_marca = 25;
				$ancho_cant = 10;
				$ancho_precio = 25;
				$ancho_desc2 = 13;
				$ancho_iva = 17;
				$ancho_total = 22;

				$x_codigo = $x_start;
				$x_desc = $x_codigo + $ancho_codigo;
				$x_marca = $x_desc + $ancho_desc;
				$x_cant = $x_marca + $ancho_marca;
				$x_precio = $x_cant + $ancho_cant;
				$x_desc2 = $x_precio + $ancho_precio;
				$x_iva = $x_desc2 + $ancho_desc2;
				$x_total = $x_iva + $ancho_iva;
				
				$pdf->SetFillColor(200, 220, 240);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetDrawColor(0, 70, 140);
				$pdf->SetLineWidth(0.3);
				$pdf->SetFont('Arial', 'B', 7);

				$x_start = $pdf->GetX();
				$y_start = $pdf->GetY();
				$header_height = 10;

				$total_ancho = $ancho_codigo + $ancho_desc + $ancho_marca + $ancho_cant + $ancho_precio + $ancho_desc2 + $ancho_iva + $ancho_total;
				$pdf->Cell($total_ancho, $header_height, '', 0, 0, '', true);
				$pdf->SetY($y_start);

				// Cabeceras de la tabla
				$pdf->SetXY($x_codigo, $y_start);
				$pdf->Cell($ancho_codigo, $header_height, utf8_decode('CÓDIGO'), 'R', 0, 'C');

				$pdf->SetXY($x_desc, $y_start);
				$pdf->Cell($ancho_desc, $header_height, utf8_decode('DESCRIPCIÓN'), 'R', 0, 'C');

				$pdf->SetXY($x_marca, $y_start);
				$pdf->Cell($ancho_marca, $header_height, utf8_decode('MARCA'), 'R', 0, 'C');

				$pdf->SetXY($x_cant, $y_start);
				$pdf->Cell($ancho_cant, $header_height, utf8_decode('CANT'), 'R', 0, 'C');

				$pdf->SetXY($x_precio, $y_start + 1);
				$pdf->MultiCell($ancho_precio, 4, "PRECIO\nUNITARIO USD", 'R', 'C');

				$pdf->SetXY($x_desc2, $y_start);
				$pdf->Cell($ancho_desc2, $header_height, 'DESC', 'R', 0, 'C');

				$pdf->SetXY($x_iva, $y_start + 1);
				$pdf->MultiCell($ancho_iva, 4, utf8_decode("ALÍCUOTA\nI.V.A"), 'R', 'C');

				$pdf->SetXY($x_total, $y_start + 1);
				$pdf->MultiCell($ancho_total, 4, "MONTO\nTotal USD", 0, 'C');

				$pdf->SetY($y_start + $header_height);
				$pdf->Ln(4);

				// ========== FILAS DE PRODUCTOS (con valores dinámicos) ==========
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetFillColor(255, 255, 255);
				$row_height = 5;

				foreach ($productos as $prod) {
					$y_antes = $pdf->GetY();
					
					// Renderizar DESCRIPCIÓN para medir
					$pdf->SetXY($x_desc, $y_antes);
					$pdf->MultiCell($ancho_desc, 5, utf8_decode($prod['desc']), 0, 'L');
					$y_despues_desc = $pdf->GetY();
					
					// Renderizar MARCA para medir
					$pdf->SetXY($x_marca, $y_antes);
					$marca_texto = !empty($prod['marca']) ? $prod['marca'] : '';
					$pdf->MultiCell($ancho_marca, 5, utf8_decode($marca_texto), 0, 'C');
					$y_despues_marca = $pdf->GetY();
					
					// Altura real de la fila
					$y_final = max($y_despues_desc, $y_despues_marca);
					$row_height_dinamico = $y_final - $y_antes;

					// Dibujar las demás celdas
					$pdf->SetXY($x_codigo, $y_antes);
					$pdf->Cell($ancho_codigo, $row_height_dinamico, utf8_decode($prod['codigo']), 0, 0, 'C');

					$pdf->SetXY($x_desc, $y_antes);
					$pdf->Cell($ancho_desc, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_marca, $y_antes);
					$pdf->Cell($ancho_marca, $row_height_dinamico, '', 0, 0);

					$pdf->SetXY($x_cant, $y_antes);
					$pdf->Cell($ancho_cant, $row_height_dinamico, number_format($prod['cant'], 2, ',', '.'), 0, 0, 'C');

					$pdf->SetXY($x_precio, $y_antes);
					$pdf->Cell($ancho_precio, $row_height_dinamico, number_format($prod['precio'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_desc2, $y_antes);
					$pdf->Cell($ancho_desc2, $row_height_dinamico, number_format($prod['descuento'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetXY($x_iva, $y_antes);
					$pdf->Cell($ancho_iva, $row_height_dinamico, utf8_decode($prod['iva']), 0, 0, 'C');

					$pdf->SetXY($x_total, $y_antes);
					$pdf->Cell($ancho_total, $row_height_dinamico, number_format($prod['total'], 2, ',', '.'), 0, 0, 'R');

					$pdf->SetY($y_final);

					if($pdf->GetY() > 260) { 
						$pdf->AddPage();
					}
				}
				
				// ==========================================
				// 9. SECCIÓN DE TOTALES (con valores dinámicos)
				// ==========================================
				$pdf->Ln(5);
				$y_totales = 175;
				$pdf->SetY($y_totales);
				$pdf->SetFont('Arial', 'B', 8);

				// TASA BCV
				$pdf->Cell(0, 5, utf8_decode("TASA B.C.V A LA FECHA DE EMISIÓN: BS. " . number_format($totales['tasa_bcv'], 2, ',', '.')), 0, 1, 'L');
				$pdf->Ln(2);

				$y_inicio_bloque = $pdf->GetY();
				
				$labels = [
					'SUBTOTAL', 'DESCUENTO', 'EXENTO', 'BASE IMPONIBLE (G)', 
					'ALÍCUOTA I.V.A. (16.00%)', 'BASE IMPONIBLE (IGTF)', 'ALÍCUOTA IGTF (3.00%)'
				];
				
				$valores_bs = [
					$totales['subtotal_bs'],
					$totales['descuento_bs'],
					$totales['exento_bs'],
					$totales['base_bs'],
					$totales['iva_bs'],
					0.00,
					0.00
				];
				
				$valores_usd = [
					$totales['subtotal_usd'],
					$totales['descuento_usd'],
					$totales['exento_usd'],
					$totales['base_usd'],
					$totales['iva_usd'],
					0.00,
					0.00
				];

				// COLUMNA IZQUIERDA (BOLÍVARES)
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(10);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'Bs.', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_bs[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR BS
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'Bs.', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_bs'], 2, ',', '.'), 0, 1, 'R');

				// LÍNEA DIVISORIA CENTRAL
				$pdf->Line(108, $y_inicio_bloque, 108, $pdf->GetY());

				// COLUMNA DERECHA (USD)
				$pdf->SetY($y_inicio_bloque);
				$pdf->SetFont('Arial', '', 8);
				for($i = 0; $i < count($labels); $i++) {
					$pdf->SetX(112);
					$pdf->Cell(50, 4, utf8_decode($labels[$i]), 0, 0, 'L');
					$pdf->Cell(10, 4, 'USD', 0, 0, 'L');
					$pdf->Cell(35, 4, number_format($valores_usd[$i], 2, ',', '.'), 0, 1, 'R');
				}
				
				// TOTAL A PAGAR USD
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->SetX(112);
				$pdf->Cell(50, 6, 'TOTAL A PAGAR', 0, 0, 'L');
				$pdf->Cell(10, 6, 'USD', 0, 0, 'L');
				$pdf->Cell(35, 6, number_format($totales['total_usd'], 2, ',', '.'), 0, 1, 'R');
				
				// ==========================================
				// 10. SECCIÓN: MÉTODOS DE PAGO
				// ==========================================
				$pdf->Ln(3);
				$pdf->SetFont('Arial', 'B', 8);
				$y_metodos = $pdf->GetY();

				$pdf->Rect(2, $y_metodos, 212, 15); 

				$pdf->SetXY(12, $y_metodos + 2);
				$pdf->Cell(35, 5, utf8_decode('MÉTODOS DE PAGO:'), 0, 0);

				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(25, 5, utf8_decode('N° de Cuenta:'), 0, 0);

				$pdf->SetFont('Arial', 'B', 8);
				$pdf->SetXY(72, $y_metodos + 2);
				$pdf->MultiCell(25, 4, "BDV\nBANESCO\nBANPLUS", 0, 'L');

				$pdf->SetFont('Arial', '', 8);
				$pdf->SetXY(97, $y_metodos + 2);
				$pdf->MultiCell(50, 4, "01020422470001577053\n0134-0218-38-2181029961\n01740139401394347197", 0, 'L');

				$pdf->SetXY(135, $y_metodos + 2);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(20, 4, 'A nombre de: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, 4, 'GRUPO SOLSUMED OCCIDENTE, C.A', 0, 1);

				$pdf->SetXY(135, $y_metodos + 6);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(10, 4, 'RIF.: ', 0, 0);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(40, 4, 'J-50784504-4', 0, 1);

				// ==========================================
				// 11. SECCIÓN: CONDICIONES (RECUADRO AZUL)
				// ==========================================
				$pdf->Ln(6);
				$y_condiciones = $pdf->GetY();

				$pdf->SetFillColor(235, 245, 255); 
				$pdf->Rect(2, $y_condiciones, 212, 25, 'F'); 

				$pdf->SetXY(3, $y_condiciones + 2);
				$pdf->SetFont('Arial', '', 6.5);

				$texto_legal = "(*) CONDICIONES. Las partes convienen y aceptan que la obligación de pago de esta factura ha sido pactada utilizando una moneda extranjera como moneda de cuenta, según lo establecido en el articulo 8 del convenio cambiario Nro.1 de fecha 07/09/2018 Gaceta Oficial Nro. 6.405 Extraordinaria, por la cual su pago podrá realizarse en moneda extranjera o en bolívares a la tasa de cambio promedio ponderada emitida y publicada por el BCV, que corresponda a la condición de pago de la misma. Este pago estará sujeto al cobro adicional del 3.00% del Impuesto a las Grandes Transacciones Financieras (IGTF), de conformidad con la Providencia Administrativa SNAT/2022/000013 publicada en la G.O.N 42.339 del 17-03-2022, en caso de ser cancelado en divisas. No aplica en pago en Bs. Este documento se expresa en Dólares Americanos con su equivalente en Bolívares al tipo de cambio corriente del mercado a la fecha de su emisión, según lo establecido en el articulo 13 numeral 14 de la Providencia Administrativa SNAT /2011/0071 (..) en concordancia con el artículo 128 de la Ley del Banco Central de Venezuela (BCV); artículo 25 de la Ley que establece el Impuesto al Valor Agregado (IVA) y 38 del Reglamento General de la Ley que establece el Impuesto al Valor Agregado (RLIVA).";

				$pdf->MultiCell(210, 3, utf8_decode($texto_legal), 0, 'J');

				// ==========================================
				// 12. CÓDIGO QR
				// ==========================================
				$pdf->SetY(258);
				$y_footer = $pdf->GetY();

				$logoPath = '../admin/storage/logo/QRGS.jpg';
				$pdf->Image($logoPath, 185, $y_footer + 3, 15, 15);
				
				// ==========================================
				// 13. GENERAR PDF
				// ==========================================
				$pdf->Output($ruta_archivo, 'F');  // 'F' = Guardar en archivo local
				
			} catch (Exception $e) {
				die('Error al generar el PDF: ' . $e->getMessage());
			}
		}



	



	}
?>