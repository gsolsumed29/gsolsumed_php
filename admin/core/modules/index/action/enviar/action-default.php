<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
 $output = '';
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
            $objeto_empresa = New EmpresaData();
            $data = $objeto_empresa->getAllDatosCorreo();
            $Username=$data[0]->email;
            $Password=$data[0]->password;
            $Port=$data[0]->port;
            $Host=$data[0]->host;
            $From=$data[0]->email;
            $FromName=$data[0]->email;
            $Subject=$data[0]->email; 
            $Text=$data[0]->text; 
            
            //$path = $_POST['media'];
            //$correo = $_POST['correo']; //echo $correo;
            $correo =$From;  // debemos cambiarlo

            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = $Host;//Sets the SMTP hosts of your Email hosting
                $mail->Port = $Port;//the default SMTP server port
                $mail->SMTPAuth = true;
                $mail->Username = $Username; // Tu dirección de correo Titan
                $mail->Password = $Password; // Tu contraseña de Titan Mail
                $mail->SMTPSecure = 'ssl'; // o ENCRYPTION_SMTPS para SSL
               // $mail->Port = 465; // 465 para SSL

                // Remitente y destinatario
                $mail->setFrom($Username, 'INFO');
                $mail->addAddress($correo, '');
                
                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = $Subject;
                  $mail->Body = '<p>'.$Text.'</p>';
                $mail->AltBody = 'Este es el cuerpo en texto plano para clientes de correo no HTML';

                $mail->send();
                 echo '1';
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
            }

          /*  try {


                $mail = new PHPMailer();               
                $mail->IsSMTP();//Mailer to send message using SMTP
                $mail->Host = $Host;//Sets the SMTP hosts of your Email hosting
                $mail->Port = $Port;//the default SMTP server port
                $mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
                $mail->Username = $Username;//SMTP username
                $mail->Password = $Password;//SMTP password
                $mail->SMTPSecure = 'tls';//Connection prefix. Options are "", "" or "tls"
                $mail->From = $From;//the From email address for the message
                $mail->FromName = $FromName;//Sets the From name of the message
                $mail->AddAddress($correo,$correo);	//Adds a "To" address
                $mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
                $mail->IsHTML(true);							//Sets message type to HTML
                $mail->Subject = $Username; // Asunto del mensaje
                //An HTML or plain text message body
               // $mail->AddAttachment($path);
                $mail->Body = '               
                <p>'.$Text.'</p>';
        
                $mail->AltBody = '';
                $result = $mail->Send();
                if(!$result==true){

                    echo $mail->ErrorInfo;
                }else{
                    echo '1';
                }
              
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;

        }*/        
		  
            
	    
        }
      
    }
    if($accion ==3){
        if($datos==1){
                $media =  $_POST['media'];
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $siniestro_objeto = new SiniestroData();
               
                $siniestro_objeto->id =$id;                
                $siniestro_objeto->delf($id);   
                unlink($media);
         
               echo "1";
            }
            
            
          

        }
    
   
   
}
?>

