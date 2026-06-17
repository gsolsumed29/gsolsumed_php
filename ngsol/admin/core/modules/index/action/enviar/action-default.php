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

            try {
                $mail = new PHPMailer();               
                $mail->IsSMTP();//Mailer to send message using SMTP
                $mail->Host = $Host;//Sets the SMTP hosts of your Email hosting
                $mail->Port = $Port;//the default SMTP server port
                $mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
                $mail->Username = $Username;//SMTP username
                $mail->Password = $Password;//SMTP password
                $mail->SMTPSecure = 'tls';//Connection prefix. Options are "", "ssl" or "tls"
                $mail->From = $From;//the From email address for the message
                $mail->FromName = $FromName;//Sets the From name of the message
                $mail->AddAddress($correo,$correo);	//Adds a "To" address
                $mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
                $mail->IsHTML(true);							//Sets message type to HTML
                $mail->Subject = $Username; // Asunto del mensaje
                //An HTML or plain text message body
               // $mail->AddAttachment($path);

               $message  = '<div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
               <table style="background-color:#f6f6f6;width:100%">
                   <tbody><tr><td>&nbsp;</td><td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                       <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                       <table cellpadding="0" cellspacing="0" style="background:#fff;border:1px solid #e9e9e9;border-radius:3px" width="100%">
                           <tbody><tr><td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9"><img alt="Mostrar Logo" src="https://drive.google.com/uc?export=view&id=1o7WWA81LdQnxKK3FjMMHClqJX2IjrCTe" style="max-height:65px" class="CToWUd" data-bit="iit">
                               <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto"><span style="font-size:14px"><span style="color:#66cccc">RECIBO DE PAGO</span></span></div>
                               </td></tr><tr><td style="vertical-align:top;padding:25px">
                               <table cellpadding="0" cellspacing="0" width="100%">
                                   <tbody><tr><td style="vertical-align:top;padding:0px">Estimado(a) &nbsp;<strong> (Nombre del cliente),</strong></td></tr><tr><td style="vertical-align:top;padding:0 0 10px">
                                       <p><span style="font-size:12px">Por medio de la presente le enviamos un recibo de pago de la&nbsp;factura&nbsp;<strong>(Numero de factura)</strong>&nbsp;<wbr>registrado&nbsp;el&nbsp;<strong>(fecha del pago)</strong></span></p>
               
                                       <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> $ (cantidad en $).</span></p>
               
                                       <p style="line-height:8px"><span style="font-size:12px"><strong>Transacción #:</strong> (Refeerncia).</span></p>
               
                                       <p style="line-height:8px"><span style="font-size:12px"><strong>Total pagado:</strong> $ (Total en $).</span></p>
               
                                       <p><span style="font-size:12px">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: 0416-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</span></p>
               
                                       <p><span style="font-size:12px"><strong>Nota:</strong> Este correo electrónico servirá como un recibo oficial para este pago.</span></p>
                                       </td></tr><tr><td style="vertical-align:top;padding:0 0 20px;text-align:center">&nbsp;</td></tr>
                                   </tbody>
                               </table>
                               </td></tr>
                           </tbody>
                       </table>
                       </div>
                       </td><td>&nbsp;</td></tr>
                   </tbody>
               </table>
               </div>';
              
                $mail->Body = $message;
        
                $mail->AltBody = '';
                $result = $mail->Send();
                if(!$result==true){

                    echo $mail->ErrorInfo;
                }else{
                    echo '1';
                }
              
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;

        }
           
		  
            
	    
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

