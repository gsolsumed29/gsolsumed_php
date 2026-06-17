<?php
if((isset($_GET['tipo'])) ){ 
    $tipo = $_GET['tipo'];  
  }else{ 
    $tipo = $_POST['tipo'];   
 }

if($tipo=='1'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReportePedido($fact_num,$status);

}

if($tipo=='0'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteEnviar($fact_num,$status);

}

if($tipo=='3'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReportePedido($fact_num,$status);

}

if($tipo=='4'){

    $co_cli = $_GET['co_cli'];  
    $status =0;
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteCuentasxCobrar($co_cli,$status);

}

if($tipo=='5'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteFacturacion($fact_num,$status);

}

if($tipo=='6'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteAprobacion($fact_num,$status);

}



if($tipo=='7'){
  // reporte estatus embarco
    $embarque_id = $_GET['embarque_id'];    
    $objeto_reporte = New ReporteData();          
    $objeto_reporte->generarReporteEstatusEmbarque($embarque_id);

    
}


if($tipo=='8'){
    // reporte estatus embarco
      $factura_id = $_GET['fact_num'];    
      $objeto_reporte = New ReporteData();          
      $objeto_reporte->generarFacturaPDF($factura_id);
  
  }

  
  if($tipo=='10'){
    // reporte estatus embarco
      $factura_id = $_GET['fact_num'];    
      $objeto_reporte = New ReporteData();          
      $objeto_reporte->generarFactura_NOTA($factura_id);
  
  }

    if($tipo=='11'){
    // reporte estatus embarco
      $factura_id = $_GET['fact_num'];    
      $objeto_reporte = New ReporteData();          
      $objeto_reporte->generarFactura_FISCAL($factura_id);
  
    }


if($tipo=='100'){  
    // generar_lista_pdf.php
    header('Content-Type: application/json');

    try {
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Método no permitido', 405);
        }

        // Recibir y validar datos
        $moneda = $_POST['moneda'] ?? 'USD';
        $datosJson = $_POST['datos'] ?? '[]';
        $fecha = $_POST['fecha'] ?? date('c');

        // Validar moneda
        if (!in_array($moneda, ['USD', 'VES'])) {
            throw new Exception('Moneda no válida: ' . $moneda);
        }

        // Llamar a la función para generar el reporte
        $resultado = ReporteData::generarReporteLista($datosJson, $moneda, $fecha);

        if ($resultado['success']) {
            // Respuesta exitosa
            echo json_encode([
                'success' => true,
                'pdfUrl' => $resultado['pdfUrl'],
                'fileName' => $resultado['fileName'],
                'fileSize' => $resultado['fileSize'],
                'message' => 'PDF generado correctamente'
            ]);
        } else {
            // Error en la generación
            throw new Exception($resultado['message'] ?? 'Error al generar el PDF');
        }

    } catch (Exception $e) {
        // Respuesta de error
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'errorCode' => $e->getCode()
        ]);
    }

}

if($tipo=='101'){
    $estatus="2";
    $objeto_reporte = New ReporteData();          
    $objeto_reporte->generarReporteLista($estatus);

}


if($tipo=='102'){  
    // generar_lista_pdf.php
    header('Content-Type: application/json');

    try {
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Método no permitido', 405);
        }

        // Recibir y validar datos
        $moneda = $_POST['moneda'] ?? 'USD';
        $datosJson = $_POST['datos'] ?? '[]';
        $fecha = $_POST['fecha'] ?? date('c');

        // Validar moneda
        if (!in_array($moneda, ['USD', 'VES'])) {
            throw new Exception('Moneda no válida: ' . $moneda);
        }

        // Llamar a la función para generar el reporte
        $resultado = ReporteData::generarReporteListaXLS($datosJson, $moneda, $fecha);

        if ($resultado['success']) {
            // Respuesta exitosa
            echo json_encode([
                'success' => true,
                'pdfUrl' => $resultado['pdfUrl'],
                'fileName' => $resultado['fileName'],
                'fileSize' => $resultado['fileSize'],
                'message' => 'XLS generado correctamente'
            ]);
        } else {
            // Error en la generación
            throw new Exception($resultado['message'] ?? 'Error al generar el XLS');
        }

    } catch (Exception $e) {
        // Respuesta de error
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'errorCode' => $e->getCode()
        ]);
    }

}


?>