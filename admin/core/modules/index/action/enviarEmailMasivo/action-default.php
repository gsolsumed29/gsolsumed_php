<?php
// ==========================================
// ARCHIVO: admin/ajax/enviar_correo_masivo.php
// ==========================================
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
$empresa = isset($_POST['empresa']) ? trim($_POST['empresa']) : '';
$email_destino = isset($_POST['email_destino']) ? trim($_POST['email_destino']) : '';
$asunto = isset($_POST['asunto']) ? trim($_POST['asunto']) : 'Comunicado - GRUPO SOLSUMED';
$mensaje_personalizado = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

if (empty($empresa) || empty($email_destino)) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos (empresa y/o correo)'
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

// ==========================================
// RUTA DEL POSTER (IMAGEN A ENVIAR)
// ==========================================
// Opción 1: Ruta fija (siempre el mismo poster)
$ruta_poster = '../admin/storage/posters/1_11052026.jpg';

try {
    // ==========================================
    // ENVIAR CORREO
    // ==========================================
    $resultado_email = enviarCorreoMasivo(
        $email_destino,
        $empresa,
        $asunto,
        $mensaje_personalizado, $ruta_poster
    );
    
    // ==========================================
    // RESPUESTA
    // ==========================================
    if ($resultado_email) {
        echo json_encode([
            'success' => true,
            'message' => "Correo enviado correctamente a {$empresa} ({$email_destino})"
        ]);
    } else {
        throw new Exception('El servidor de correo rechazó el envío');
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

// ==========================================
// FUNCIONES AUXILIARES
// ==========================================

/**
 * Enviar correo masivo (sin PDF adjunto)
 */
function enviarCorreoMasivo($email_destino, $empresa, $asunto, $mensaje_personalizado = '', $ruta_poster) {
    $mail = new PHPMailer(true);
    
    try {
        // ==========================================
        // CONFIGURACIÓN SMTP
        // ==========================================
        $mail->isSMTP();
        $mail->Host       = 'smtp.titan.email';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@gruposolsumed.com';
        $mail->Password   = '#Grup0solsumed.2025#';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';
        $mail->Encoding   = 'base64';
        
        // ==========================================
        // REMITENTE Y DESTINATARIO
        // ==========================================
        $mail->setFrom('info@gruposolsumed.com', 'Bialy - Grupo Solsumed');
        $mail->addAddress($email_destino, $empresa);
        
        // ==========================================
        // INCRUSTAR PÓSTER EN EL CUERPO (NO ADJUNTO)
        // ==========================================
        $posterHTML = '';
        if (!empty($ruta_poster) && file_exists($ruta_poster)) {
            $cid_imagen = 'poster_' . md5($ruta_poster);
            
            // INCORPORA la imagen al cuerpo (NO como adjunto)
            $mail->addEmbeddedImage($ruta_poster, $cid_imagen, basename($ruta_poster));
            
            // HTML que muestra la imagen DENTRO del correo
            $posterHTML = '
            <div style="text-align: center;">
                <img src="cid:' . $cid_imagen . '" 
                     alt="Poster Bialy" 
                     style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
            </div>';
        }
        
        // ==========================================
        // CONTENIDO DEL CORREO
        // ==========================================
        $mail->isHTML(true);
        $asunto = 'Invitación ';
        $mail->Subject ='Invitación';
        
        if (!empty($mensaje_personalizado)) {
            $cuerpo = nl2br(htmlspecialchars($mensaje_personalizado));
            
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px; }
                    .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                    .header { background: linear-gradient(135deg, #0f418c, #1a5bb5); color: white; padding: 30px; text-align: center; }
                    .header h1 { margin: 0; font-size: 26px; letter-spacing: 2px; }
                    .header p { margin: 10px 0 0; opacity: 0.9; font-size: 14px; }
                    .content { padding: 30px; }
                    .message-box { background: #f8f9fa; border-left: 4px solid #0f418c; padding: 20px; margin: 20px 0; border-radius: 0 5px 5px 0; }
                    .footer { background: #f8f9fa; padding: 20px 30px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; }
                    .footer a { color: #0f418c; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class="container">
                 
                    <div class="content">
                        <p style="display:true">Estimado(a) <strong>' . htmlspecialchars($empresa) . '</strong>,</p>
                        
                        ' . $posterHTML . '
                   
                        
                      
                    </div>
                   
                </div>
            </body>
            </html>';
            
        } else {
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px; }
                    .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                    .header { background: linear-gradient(135deg, #0f418c, #1a5bb5); color: white; padding: 30px; text-align: center; }
                    .header h1 { margin: 0; font-size: 26px; letter-spacing: 2px; }
                    .header p { margin: 10px 0 0; opacity: 0.9; font-size: 14px; }
                    .content { padding: 30px; }
                    .empresa-info { background: #f8f9fa; border-left: 4px solid #0f418c; padding: 15px 20px; margin: 20px 0; border-radius: 0 5px 5px 0; }
                    .empresa-info p { margin: 5px 0; color: #333; }
                    .empresa-nombre { font-size: 18px; font-weight: bold; color: #0f418c; }
                    .footer { background: #f8f9fa; padding: 20px 30px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; }
                    .footer a { color: #0f418c; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class="container">
                 
                    <div class="content">
                         <p style="display:true">Estimado(a) <strong>' . htmlspecialchars($empresa) . '</strong>,</p>
                        
                        ' . $posterHTML . '
                        
                      
                      
                    </div>
                   
                </div>
            </body>
            </html>';
        }
        
        // Versión texto plano
        $mail->AltBody = "Estimado(a) {$empresa},\n\n" .
                         ($mensaje_personalizado ? 
                             strip_tags($mensaje_personalizado) . "\n\n" :
                             "Reciba un cordial saludo de parte de Bialy - Grupo Solsumed.\n\n" .
                             "Nos complace presentarle nuestra más reciente promoción.\n\n" .
                             "Para ver el póster promocional, abra este correo en un cliente que soporte HTML.\n\n"
                         ) .
                         "Atentamente,\n" .
                         "Bialy - GRUPO SOLSUMED\n" .
                         "Tel: 0424-588.55.91\n" .
                         "Email: ventas@gruposolsumed.com\n" .
                         "Web: www.gruposolsumed.com";
        
        // ==========================================
        // ENVIAR
        // ==========================================
        $mail->send();
        
        return true;
        
    } catch (Exception $e) {
        throw new Exception('Error al enviar correo: ' . $mail->ErrorInfo);
    }
}