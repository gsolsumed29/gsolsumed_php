<?php
$nombreUsuario = $_POST['email'];
$user = new UserData(); 
$t = $user->foundId($nombreUsuario);
$id = $t->cuenta;	
//echo $id;
if($id==1){  

  $user->nombreUsuario = $nombreUsuario;
  $newpass=$user->radomPassword();
  $password = sha1(md5($newpass));
  $user->password = $password;
  $user->updatePassword();
/*
  $message  = "<html><body>";
  $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
  $message .= "<tr><td>";
  $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
  $message .= "<thead>
                       <tr height='80'>
                       <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#333; font-size:34px;' >Freshco.pe</th>
                       </tr>
                       </thead>";
   $message .= "<tbody>
             <tr>
              <td colspan='4' style='padding:15px;'>
               <p style='font-size:20px;'>Hola..!!'  $nombreUsuario  <br> Freshco te da la bienvenida  su selecta cartera de clientes</p>
               <hr />
               <p style='font-size:20px;'>Estos son tu datos de acceso</p>
           <p style='font-size:15px;'>Usuario : $nombreUsuario </p>
           <p style='font-size:15px;'>Password : $newpass </p>
               <img src='https://mosquedacordova.com/FRESHCO/site/img/envio.png' alt='centroderentas.com' title='centroderentas.com' style='height:auto; width:100%; max-width:100%;' />
               <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'> En centro de rentas encontraras todos los articulos que buscas al mejor precio de renta.</p>
              </td>
             </tr>
               </tbody>";
   $message .= "</table>";
   $message .= "</td></tr>";
   $message .= "</table>";
   $message .= "</body></html>";

$mail_to = $nombreUsuario;
$subject ="centroderentas.com";


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$success = mail($mail_to, $subject, $message, $headers);

if ($success) {

http_response_code(200);
echo "1";
} else {
http_response_code(500);
echo "1";
}  
*/
echo "1";
}else{
 
   
    echo "0";  
}
?>
