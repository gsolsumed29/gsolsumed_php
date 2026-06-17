<?php
$nombreUsuario =$_POST['nombreUsuario'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

$user = new UserData(); 
$t = $user->foundId($nombreUsuario);
$id = $t->cuenta;	
//echo $id;
if($id==1){  
  $user->nombre =  ucwords($nombre);
  $user->nombreUsuario = $nombreUsuario;
  //$user->password = $password; 
  $user->telefono =  $telefono; 
  $user->direccion = $direccion;  
  $user->update();
  if($_POST['confirmarPassword']!=''){
    $password = sha1(md5($_POST['confirmarPassword']));
      $user->password = $password; 
      $user->updatePassword();
  }
  echo "1";
}else{
   
  echo "0";
}
?>
