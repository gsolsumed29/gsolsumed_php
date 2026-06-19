<?php
// ==========================================
// ARCHIVO: ajax/enviar_factura_email.php
// =========================================
header('Content-Type: application/json');

// Solo aceptar peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

// Validar campos requeridos
 $fact_num = isset($_POST['fact_num']) ? trim($_POST['fact_num']) : '';
 $email_destino = isset($_POST['email_destino']) ? trim($_POST['email_destino']) : '';
 $cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';
 $tipoDoc = isset($_POST['tipoDoc']) ? trim($_POST['tipoDoc']) : '';
 $tipoFuncion = isset($_POST['tipoFuncion']) ? trim($_POST['tipoFuncion']) : '0';
 $email_vendedor = isset($_POST['emailVendedor']) ? trim($_POST['emailVendedor']) : '0';
if (empty($fact_num) || empty($email_destino)) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos (factura y/o correo)'
    ]);
    exit;
}

// Validar formato de email
if (!filter_var($email_destino, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'El correo electrónico no tiene un formato válido'
    ]);
    exit;
}

try {
  
    $directorio_temp = '../storage/temp_facturas/';
    
    // Crear directorio si no existe
    if (!is_dir($directorio_temp)) {
        mkdir($directorio_temp, 0755, true);
    }
    
 
    
if($tipoDoc=='1'){

   // Nombre único para el archivo
    $nombre_archivo = 'factura_' . sanitizeFilename($fact_num) . '_' . time() . '.pdf';
    $ruta_archivo = $directorio_temp . $nombre_archivo;
        // Generar el PDF y guardarlo en archivo
    $objeto_archivo  = New ReporteData();
    $archivo =  $objeto_archivo->generarFacturaPdfFiscal($fact_num, $ruta_archivo);
    $factura_convertida=$fact_num;
}else{
    $objeto_funciones = New FuncionesData();            
    $factura_convertida = $objeto_funciones -> convertirANF($fact_num);

       // Nombre único para el archivo
    $nombre_archivo = 'nota_' . sanitizeFilename($factura_convertida) . '_' . time() . '.pdf';
    $ruta_archivo = $directorio_temp . $nombre_archivo;

       // Generar el PDF y guardarlo en archivo
    $objeto_archivo  = New ReporteData();
    error_log("[DEBUG enviarDocumentos NOTA] fact_num='".$fact_num."' | tipoDoc='".$tipoDoc."' | co_alma=".($_SESSION['co_alma'] ?? 'NULL')." | logged_in=".($_SESSION['logged_in'] ?? 'NULL')." | session_id=".session_id());
    $archivo =  $objeto_archivo->generarFacturaPdfNota($fact_num, $ruta_archivo);

}
 
   
    
    // Verificar que el archivo se creó correctamente
    if (!file_exists($ruta_archivo)) {
        throw new Exception('No se pudo generar el archivo PDF');
    }
    
    // ==========================================
    // 3. ENVIAR CORREO
    // ==========================================
     $resultado_email = enviarCorreoFactura(
        $email_destino,
        $cliente,
        $factura_convertida,
        $ruta_archivo,
        $nombre_archivo,
        $email_vendedor
    );

     $resultado_email = true;
    // ==========================================
    // 4. ELIMINAR ARCHIVO (SIEMPRE)
    // ==========================================
    eliminarArchivoTemporal($ruta_archivo);
    
    // ==========================================
    // 5. RESPUESTA
    // ==========================================
    if ($resultado_email) {
          

         
            $objeto_nota = new DocumentosData();
            $respuesta = $objeto_nota->setFacturaDocum($fact_num,$fact_num,'FACT');
         

        echo json_encode([
            'success' => true,
            'message' => "Documento N° {$factura_convertida} enviado correctamente a {$email_destino}"
        ]);
    } else {
        throw new Exception('El servidor de correo rechazó el envío');
    }
    
    } catch (Exception $e) {
    // Intentar eliminar archivo si existiera (por si falló el envío)
    if (isset($ruta_archivo) && file_exists($ruta_archivo)) {
        @unlink($ruta_archivo);
    }
    
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

// ==========================================
// FUNCIONES AUXILIARES
// ==========================================

/**
 * Sanitizar nombre de archivo
 */
function sanitizeFilename($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $filename);
    return preg_replace('/_+/', '_', $filename);
}

/**
 * Eliminar archivo temporal
 */
function eliminarArchivoTemporal($ruta) {
    if (file_exists($ruta)) {
        @unlink($ruta);
        
        // Opcional: Limpiar archivos temporales viejos (más de 1 hora)
        $directorio = dirname($ruta);
        $archivos = glob($directorio . '*.pdf');
        $hora_limite = time() - 3600; // 1 hora atrás
        
        foreach ($archivos as $archivo) {
            if (filemtime($archivo) < $hora_limite) {
                @unlink($archivo);
            }
        }
    }
}

/**
 * Enviar correo con factura adjunta
 */
function enviarCorreoFactura($email_destino, $cliente, $fact_num, $ruta_pdf, $nombre_pdf, $email_vendedor) {
    if (!class_exists('PHPMailer', false) && class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        class_alias('PHPMailer\\PHPMailer\\PHPMailer', 'PHPMailer');
    }
    $mail = new PHPMailer(true);
    
    try {
        // ==========================================
        // CONFIGURACIÓN SMTP
        // ==========================================
        $mail->isSMTP();
        $mail->Host       = 'smtp.titan.email';        // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username   = 'info@gruposolsumed.com';   // Tu correo
        $mail->Password   = '#Grup0solsumed.2025#';        // App Password de Gmail
        $mail->SMTPSecure = 'ssl'; // o ENCRYPTION_SMTPS para SSL
        $mail->Port       = 465;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
                'crypto_method'     => STREAM_CRYPTO_METHOD_TLS_CLIENT
                                      | STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            ],
        ];
        $mail->CharSet    = 'UTF-8';
        $mail->Encoding = 'base64'; // Opcional: mejora compatibilidad con caracteres especiales
        
        // ==========================================
        // REMITENTE Y DESTINATARIO
        // ==========================================
        $mail->setFrom('info@gruposolsumed.com', 'GRUPO SOLSUMED ');
        $mail->addAddress($email_destino, $cliente);
        $mail->addAddress($email_vendedor, 'Vendedor');  // El vendedor también como destinatario
        
      
        // ==========================================
        // CONTENIDO DEL CORREO
        // ==========================================
        $mail->isHTML(true);
        $mail->Subject = 'Documento N° ' . $fact_num . ' - GRUPO SOLSUMED';
        
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px; }
                .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #0f418c, #1a5bb5); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 22px; }
                .header p { margin: 10px 0 0; opacity: 0.9; font-size: 14px; }
                .content { padding: 30px; }
                .factura-info { background: #f8f9fa; border-left: 4px solid #0f418c; padding: 15px 20px; margin: 20px 0; border-radius: 0 5px 5px 0; }
                .factura-info p { margin: 5px 0; color: #333; }
                .factura-num { font-size: 18px; font-weight: bold; color: #0f418c; }
                .footer { background: #f8f9fa; padding: 20px 30px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; }
                .footer a { color: #0f418c; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>GRUPO SOLSUMED</h1>
                    <p>R.I.F.: J-50784504-4</p>
                </div>
                <div class="content">
                    <p>Estimado(a) <strong>' . htmlspecialchars($cliente) . '</strong>,</p>
                    <p>Adjunto a este correo encontrará la factura correspondiente a su compra:</p>
                    
                    <div class="factura-info">
                        <p class="factura-num">Documento: ' . htmlspecialchars($fact_num) . '</p>
                        <p><strong>Fecha:</strong> ' . date('d/m/Y') . '</p>
                    </div>
                    
                    <p>Le agradecemos su preferencia. Si tiene alguna consulta sobre esta factura, no dude en contactarnos.</p>
                    
                    <p>Atentamente,<br>
                    <strong>Departamento de Ventas</strong><br>
                    GRUPO SOLSUMED</p>
                </div>
                <div class="footer">
                    <p>Teléfono: 0424-588.55.91 / 0251-273.28.66</p>
                    <p>Email: <a href="mailto:ventas@gruposolsumed.com">ventas@gruposolsumed.com</a></p>
                    <p>Web: <a href="https://www.gruposolsumed.com">www.gruposolsumed.com</a></p>
                </div>
            </div>
        </body>
        </html>';
        
        // Versión texto plano (para clientes que no soportan HTML)
        $mail->AltBody = "Estimado(a) {$cliente},\n\n" .
                         "Adjunto encontrará el Documento N° {$fact_num}.\n\n" .
                         "Gracias por su preferencia.\n\n" .
                         "Atentamente,\n" .
                         "GRUPO SOLSUMED \n" .
                         "Tel: 0424-588.55.91";
        
        // ==========================================
        // ADJUNTAR PDF
        // ==========================================
        $mail->addAttachment($ruta_pdf, $nombre_pdf);
        
        // ==========================================
        // ENVIAR
        // ==========================================
        $mail->send();

        
        return true;
        
    } catch (Exception $e) {
        throw new Exception('Error al enviar correo: ' . $mail->ErrorInfo);
    }
}