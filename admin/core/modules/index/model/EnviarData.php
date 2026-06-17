<?php
class EnviarData {
	public static $tablename = "enviar";

	public function __construct(){
		$this->Username = "";
		$this->Password = "";
		$this->Port = "";	
		$this->Host = "1";	
		$this->From = "";
		$this->FromName = "";	
		$this->Subject = "1";	
		$this->Text = "1";
		$this->To = "1";
        $this->To_2 = "1";
        $this->To_3 = "1";
		$this->AddAttachment= "1";
		
	}

    
    function procesarArchivosCorreo($archivosAdjuntos, $directorioBase, $enviar_objeto) {
        try {
         

            $mail = new PHPMailer();     
            // Configuración del servidor
            $mail->isSMTP();

       

            
           // $mail->Host = 'smtp.titan.email';
            $mail->SMTPAuth = true;
            $mail->Username = $this->Username; // Tu dirección de correo Titan
            $mail->Password =  $this->Password; // Tu contraseña de Titan Mail
            $mail->SMTPSecure = 'ssl'; // o ENCRYPTION_SMTPS para SSL
           // $mail->Port = 465; // 465 para SSL
           $mail->Host =  $this->Host;//Sets the SMTP hosts of your Email hosting
           $mail->Port =  $this->Port;//the default SMTP server port
           
            $mail->CharSet = 'UTF-8'; // Asegura que el correo use UTF-8
            $mail->Encoding = 'base64'; // Opcional: mejora compatibilidad con caracteres especiales
            
            // Remitente y destinatario
            $mail->setFrom($this->From, 'Info Grupo Solsumed');
            $mail->addAddress($this->To);
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $this->Subject;
            // Adjuntar todos los archivos
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    $mail->addAttachment($archivo, basename($archivo));
                }
            }
    
            $mail->Body = '<p>'.$this->Text.'</p> <p><em>Este mensaje es solo informativo. Por favor, no responder a este correo.
            Para cualquier consulta, comuniquese con el vendedor..</em></p><hr style="border: 0; border-top: 1px solid #eaeaea; margin: 10px 0;">  ';	
            $mail->AltBody = 'Este es solo un correo informativo';

            $mail->send();
           
       
            // 2. Enviar el correo con los adjuntos
       
            
            // 3. Eliminar archivos después del envío
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    unlink($archivo);
                }
            }
            
            // 4. Intentar eliminar el directorio si está vacío
            if (is_dir($directorioBase)) {
                @rmdir($directorioBase);
            }
            
            return true;
        } catch (Exception $e) {
            // Limpiar archivos incluso si falla el envío
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    unlink($archivo);
                }
            }
            
            throw new Exception("Error al procesar archivos adjuntos: " . $e->getMessage());
        }
    }
	    
    function procesarArchivosCorreoAdelantos($enviar_objeto) {
        try {
         

            $mail = new PHPMailer();     
            // Configuración del servidor
            $mail->isSMTP();

       

            
           // $mail->Host = 'smtp.titan.email';
            $mail->SMTPAuth = true;
            $mail->Username = $this->Username; // Tu dirección de correo Titan
            $mail->Password =  $this->Password; // Tu contraseña de Titan Mail
            $mail->SMTPSecure = 'ssl'; // o ENCRYPTION_SMTPS para SSL
           // $mail->Port = 465; // 465 para SSL
           $mail->Host =  $this->Host;//Sets the SMTP hosts of your Email hosting
           $mail->Port =  $this->Port;//the default SMTP server port
           
            $mail->CharSet = 'UTF-8'; // Asegura que el correo use UTF-8
            $mail->Encoding = 'base64'; // Opcional: mejora compatibilidad con caracteres especiales
            
            // Remitente y destinatario
            $mail->setFrom($this->From, 'Info Grupo Solsumed');
            $mail->addAddress($this->To);
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $this->Subject;
        	$mail->addAttachment($this->AddAttachment, 'Comprobante de pago');
           // $mail->addAttachment= $this->AddAttachment;
        
    
            $mail->Body = '<p>'.$this->Text.'</p> <p><em>Este mensaje es solo informativo. Por favor, no responder a este correo.
            Para cualquier consulta, comuniquese con el vendedor..</em></p><hr style="border: 0; border-top: 1px solid #eaeaea; margin: 10px 0;">  ';	
            $mail->AltBody = 'Este es solo un correo informativo';

            $mail->send();
           
       
    
            
            return true;
        } catch (Exception $e) {
            // Limpiar archivos incluso si falla el envío
        
            
            throw new Exception("Error al procesar archivos adjuntos: " . $e->getMessage());
        }
    }

	public  function sedEmailCobros($archivosAdjuntos){


            try {
				
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
            }
	}

		
	public  function sedEmailVentas(){
		
            try {
					$mail = new PHPMailer();     
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'smtp.titan.email';
                $mail->SMTPAuth = true;
                $mail->Username = $this->Username; // Tu dirección de correo Titan
                $mail->Password =  $this->Password; // Tu contraseña de Titan Mail
                $mail->SMTPSecure = 'ssl'; // o ENCRYPTION_SMTPS para SSL
                $mail->Port = 465; // 465 para SSL
            // Configuración de codificación
                $mail->CharSet = 'UTF-8';
                // Remitente y destinatario
                $mail->setFrom($this->From, 'INFO');
                $mail->addAddress($this->To, $this->To);
                
                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = mb_encode_mimeheader($this->Subject, 'UTF-8');
			  	$mail->addAttachment($this->AddAttachment, 'NOTA DE ENTREGA');
                $mail->Body = '<p>'.$this->Text.'</p> <p><em>Este mensaje es solo informativo. Por favor, no responder a este correo.
                Para cualquier consulta, comuniquese con el vendedor..</em></p><hr style="border: 0; border-top: 1px solid #eaeaea; margin: 10px 0;">  ';	
                $mail->AltBody = 'Este es solo un correo informativo';

                $mail->send();
               
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
            }
	   

	}
	   
       
    function procesarArchivosCorreoClientes($archivosAdjuntos, $directorioBase, $enviar_objeto) {
        try {
            $mail = new PHPMailer();     
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Username = $this->Username; 
            $mail->Password = $this->Password; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = $this->Host;
            $mail->Port = $this->Port;
            $mail->CharSet = 'UTF-8'; 
            $mail->Encoding = 'base64'; 
            
            // Remitente
            $mail->setFrom($this->From, 'Info Grupo Solsumed');
            
            // --- MODIFICACIÓN AQUÍ: Enviar a dos personas ---
            
            // Agregar el primer destinatario
            if (!empty($this->To)) {
                $mail->addAddress($this->To);
            }
    
            // Agregar el segundo destinatario
            if (!empty($this->To_2)) {
                $mail->addAddress($this->To_2);
            }
            
            // -----------------------------------------------
                
            $mail->isHTML(true);
            $mail->Subject = $this->Subject;
            
            // Adjuntar archivos
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    $mail->addAttachment($archivo, basename($archivo));
                }
            }
        
            $mail->Body = '<p>'.$this->Text.'</p> <p><em>Este mensaje es solo informativo. Por favor, no responder a este correo.
            Para cualquier consulta, comuniquese con el vendedor..</em></p><hr style="border: 0; border-top: 1px solid #eaeaea; margin: 10px 0;">';	
            $mail->AltBody = 'Este es solo un correo informativo';
    
            $mail->send();
               
            // Eliminar archivos después del envío
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    unlink($archivo);
                }
            }
            
            // Eliminar directorio si está vacío
            if (is_dir($directorioBase)) {
                @rmdir($directorioBase);
            }
                
            return true;
        } catch (Exception $e) {
            // Limpiar archivos incluso si falla
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    unlink($archivo);
                }
            }
            
            throw new Exception("Error al procesar archivos adjuntos: " . $e->getMessage());
        }
    }
	

           
    function enviarCorreoRestablecimiento() {
        try {

                    $mail = new PHPMailer();     
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'pruebas.envios2025@gmail.com';
                    $mail->Password = 'smfrdumngyelgfah';
                    $mail->SMTPSecure = 'tls';  // ← IMPORTANTE
                    $mail->Port = 587;

                    // Para debugging, añade esto ANTES de send():
                  //  $mail->SMTPDebug = 2;  // Muestra errores detallados
                   // $mail->Debugoutput = 'html';

                    // Configura timeout y opciones SSL
                    $mail->Timeout = 60;
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $texto =  'Restablecimiento de Contraseña';
                    $Subject = html_entity_decode($texto, ENT_QUOTES, 'UTF-8');
                    $mail->setFrom('pruebas.envios2025@gmail.com', 'Grupo solsumed,CA');
                    $mail->addAddress($this->To);
                    $mail->Subject =$Subject;
                   $mail->Body = '<p>'.$this->Text.'</p> <p><em>Este mensaje es solo informativo. Por favor, no responder a este correo.
                    Para cualquier consulta, comuniquese con el vendedor..</em></p><hr style="border: 0; border-top: 1px solid #eaeaea; margin: 10px 0;">';	
                    $mail->AltBody = 'Este es solo un correo informativo';

                    $mail->send();
                
                            
           
       
            // 2. Enviar el correo con los adjuntos
       
                
            return true;
        } catch (Exception $e) {
          
            throw new Exception("Error enviar el correo: " . $e->getMessage());
        }
    }
	


}

?>