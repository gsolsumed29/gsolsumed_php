<?php
	$client =  new ClientData();
	$password = $client->radomPassword();
	$p = $_POST["p"];
	$email= $_POST["email"];
	$telefono = $_POST["telefono"];
	$t = $client->foundEmail($email);						
if($t->cuenta == 0){

		if($p ==1){		
		
			
			$client->email = $_POST["email"];
			$client->telefono = $_POST["telefono"];	
			$client->addNoticia();
			$client->add();
			Core::redir("index.php?view=plans&p=2&email=$email&telefono=$telefono");
		}	
}else{

			Core::redir("index.php?view=login");
}
?>