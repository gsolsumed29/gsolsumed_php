<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
 $output = '';
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
            $path = $_POST['media'];
            $correo = $_POST['correo']; //echo $correo;
            $mail = new PHPMailer;
            $mail->IsSMTP();//Mailer to send message using SMTP
            $mail->Host = "smtp.gmail.com";//Sets the SMTP hosts of your Email hosting
            $mail->Port = 587;//the default SMTP server port
            $mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
            $mail->Username = "soporte.seguexpress.mario.pilieri@gmail.com";//SMTP username
            $mail->Password = "Asd159753";//SMTP password
            $mail->SMTPSecure = 'tls';//Connection prefix. Options are "", "ssl" or "tls"
            $mail->From = 'soporte.seguexpress.mario.pilieri@gmail.com';//the From email address for the message
            $mail->FromName = 'Seguexpress - Mario pilieri';//Sets the From name of the message
            $mail->AddAddress($correo,$correo);	//Adds a "To" address
            $mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
            $mail->IsHTML(true);							//Sets message type to HTML
            $mail->Subject = 'soporte.seguexpress.mario.pilieri@gmail.com'; // Asunto del mensaje
            //An HTML or plain text message body
            $mail->AddAttachment($path);
            $mail->Body = '
            <p>Saludos estimado cliente, estamos enviando el archivo que has solicidado, Gracias por preferirnos.</p>
            <p>Para garantizar la seguridad y confidencialidad de sus datos, la dirección de e-mail será utilizada únicamente para enviar la información solicitada, de conformidad con los términos y condiciones del servicio aceptados por usted. Por lo tanto, le agradecemos no responder los correos enviados, ni utilizar esta vía de comunicación para realizar consultas personales.</p>';
    
            $mail->AltBody = '';
        
            //Enviar un correo electrónico. Devuelve verdadero en caso de éxito o falso en caso de error
            $result = $mail->Send();

          
		    echo '1';
	    
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