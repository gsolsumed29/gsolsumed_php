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
		$this->To_client = "";
		$this->AddAttachment= "1";
		
	}
	
	public  function sedEmailCobros(){


		try {
			$mail = new PHPMailer();               
			$mail->IsSMTP();//Mailer to send message using SMTP
			$mail->Host = $this->Host;//Sets the SMTP hosts of your Email hosting
			$mail->Port = $this->Port;//the default SMTP server port
			$mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
			$mail->Username = $this->Username;//SMTP username
			$mail->Password = $this->Password;//SMTP password
			$mail->SMTPSecure = 'tls';//Connection prefix. Options are "", "ssl" or "tls"
			$mail->From = $this->From;//the From email address for the message
			$mail->FromName = $this->FromName;//Sets the From name of the message
			$mail->AddAddress($this->To);
			$mail->AddAddress($this->To_client);	
			$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
			$mail->IsHTML(true);							//Sets message type to HTML
			$mail->Subject = $this->Subject; // Asunto del mensaje
			//An HTML or plain text message body
		    $mail->AddAttachment($this->AddAttachment);
			$mail->Body = '               
			<p>'.$this->Text.'</p>';	
			$mail->AltBody = '';
			$result = $mail->Send();
			if(!$result==true){

				echo $mail->ErrorInfo;
			}else{
				//echo '1';
			}
		  
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;

	}
	}

		
	public  function sedEmailVentas(){


		try {
			$mail = new PHPMailer();               
			$mail->IsSMTP();//Mailer to send message using SMTP
			$mail->Host = $this->Host;//Sets the SMTP hosts of your Email hosting
			$mail->Port = $this->Port;//the default SMTP server port
			$mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
			$mail->Username = $this->Username;//SMTP username
			$mail->Password = $this->Password;//SMTP password
			$mail->SMTPSecure = 'tls';//Connection prefix. Options are "", "ssl" or "tls"
			$mail->From = $this->From;//the From email address for the message
			$mail->FromName = $this->FromName;//Sets the From name of the message
			$mail->AddAddress($this->To);
			$mail->AddAddress($this->To_client);		//Adds a "To" address
			$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
			$mail->IsHTML(true);							//Sets message type to HTML
			$mail->Subject = $this->Subject; // Asunto del mensaje
			//An HTML or plain text message body
		    $mail->AddAttachment($this->AddAttachment);
			$mail->Body = '               
			<p>'.$this->Text.'</p>';	
			$mail->AltBody = '';
			$result = $mail->Send();
			if(!$result==true){

				echo $mail->ErrorInfo;
			}else{
				//echo '1';
			}
		  
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;

	}
	   

	}
	   

	


}

?>