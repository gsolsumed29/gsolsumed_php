<?php

	use PHPMailer\PHPMailer\PHPMailer;
	
	$email= $_POST["email"];
	$telefono = $_POST["telefono"];
	$codigoOrden = $_POST["codigoOrden"];
	$codigoFactura = $_POST["codigoFactura"];
	$planId = $_POST["plan_id"];
	$plan = new PlanData();
	$costo = $plan->getById($planId);
	$user =  new UserData();
	$t = $user->foundEmail($email);
	$hoy = date("Y-m-d H:i:s");	
	//$id =$t->id;
	$id =0;	
		
if($id == 0){
	
			$nombres = $_POST["nombres"].' '.$_POST["apellidos"];			
			$usuario = new UserData();
			$password = $usuario->radomPassword();
			$usuario->name= $nombres;
			$usuario->nombreUsuario=$_POST["email"];		
			$usuario->password= sha1(md5($password));	
			$usuario->userLevel=3;
			$usuario->idReferido=1;
			//$usuario->idReferido=$_POST["idReferido"];
			$usuario->confirmacion=0;
			$usuario->email=$_POST["email"];			
			$usuario->created="NOW()";
			$usuario->add();	
			
			$client =  new ClientData();			
			$client->email = $_POST["email"];
			$client->apellidos = ucwords($_POST["apellidos"]);
			$client->nombres = ucwords($_POST["nombres"]);			
			$client->identificacion = $_POST["identificacion"];
			$client->numeroIdentificacion = $_POST["numeroIdentificacion"];	
			$client->telefono = $_POST["telefono"];	
			$client->direccion = $_POST["direccion"];	
			$client->numeroCasa = $_POST["numeroCasa"];				
			$client->numeroApartamento = $_POST["numeroApartamento"];
			$client->distrito = $_POST["distrito"];
			$client->ciudad = $_POST["ciudad"];		
		    $client->add();
		    
			$t = $usuario->foundEmail($email);
			$id =$t->id;	
			$pago = new PagoData();
			$pago->idUser = $id;
			$pago->idForma ="1";
			$pago->idOrden = $codigoOrden;
			$pago->codigoFacturacion = $codigoFactura;		
			$pago->costoTotal = $costo->costo;	
			$pago->fechaPago = $hoy;
			$pago->add();	
			
			$orden = new OrdenData();
			foreach($_SESSION["products"] as $s){
				$orden->codigoOrden = $codigoOrden;
				$orden->idPlan = $planId;
				$orden->idPlato = $s["product_code"];
				$orden->fecha=$hoy;
				$orden->estatus =1;
			$orden->add();
				//echo "<br>";								
			}	
			
			$text_message    = "Hola..!! , $nombres <br /><br /> 
			 Freshco te da la bienvenida  su selecta cartera de clientes, ";
           //HTML email starts her
           $message  = "<html><body>";
           $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
           $message .= "<tr><td>";
           $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
           $message .= "<thead>
                                <tr height='80'>
                                <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#333; font-size:34px;' >Freshco.com</th>
                                </tr>
                                </thead>";
            $message .= "<tbody>
                      <tr>
                       <td colspan='4' style='padding:15px;'>
                        <p style='font-size:20px;'>Hola..!!'  $nombres  <br> Freshco te da la bienvenida  su selecta cartera de clientes</p>
                        <hr />
                        <p style='font-size:20px;'>Estos son tu datos de acceso</p>
                		<p style='font-size:15px;'>Usuario : $email </p>
                		<p style='font-size:15px;'>Password : $password </p>
                        <img src='https://mosquedacordova.com/FRESHCO/site/img/envio.png' alt='Freshco.com' title='Freshco.com' style='height:auto; width:100%; max-width:100%;' />
                        <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'>Somos el sistema Weekly Order (Pedidos semanales) de suscripción que te lleva comidas frescas (Nunca congeladas!) a casa cada semana. Todas tus comidas son preparadas por nuestro equipo de chefs y nutricionistas, enfocadas en darte siempre comidas balanceadas, deliciosas y variadas. Están completamente cocinadas, así que lo único que tendrás que hacer es guardarlas en tu refrigerador y calentarlas siguiendo las instrucciones impresas en la parte trasera de cada empaque cada vez que quieras comer.
                		Olvídate de los “Qué vamos a comer?” - “Qué vamos a cenar?”. No más idas al supermercado, picar cebolla, ajo y tomate, no más ingredientes artificiales, preservantes o cualquier otro insumo procesado en exceso!
                		.</p>
                       </td>
                      </tr>
                        </tbody>";
            $message .= "</table>";
            $message .= "</td></tr>";
            $message .= "</table>";
            $message .= "</body></html>";
			$mail = new PHPMailer;
			try {
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Host = 'mail.mosquedacordova.com';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPAuth = true;
			$mail->Username = 'supportfreshco@mosquedacordova.com';
			$mail->Password = 'r6v+wxc3&GJ=';
			$mail->setFrom('supportfreshco@mosquedacordova.com', 'Support Freshco. inc');
		//	$mail->addReplyTo('supportfreshco@mosquedacordova.com', 'SERVIDOR DE PRUEBA');
			$mail->addAddress($email, $nombres);
			$mail->Subject = 'Support Freshco. inc';
			//$mail->msgHTML(file_get_contents('mail.html'));
			$mail->Body = $message;
			$mail->AltBody    = $message;
			//$mail->addAttachment('test.txt');
			}catch (Exception $e) {
			//echo "prueba aqui";
			Core::redir("index.php?view=check&plan_id=$planId&email=$email&telefono=$telefono");

			}
			//echo "prueba alla";
			Core::redir("index.php?view=pago&plan_id=$planId&email=$email&codigoOrden=$codigoOrden");	
}else{
	//echo "prueba";
		  	Core::redir("index.php?view=login");
}

?>