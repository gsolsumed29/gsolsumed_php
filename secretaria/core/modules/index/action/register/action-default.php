<?php
$nombre = $_POST['nombre'];
$nombreUsuario = $_POST['nombreUsuario'];
$password = sha1(md5($_POST['confirmarPassword']));
$fechaNacimiento = $_POST['fechaNacimiento'];
$genero = $_POST['genero'];

$user = new UserData(); 
$t = $user->foundId($nombreUsuario);
$id = $t->cuenta;	
//echo $id;
if($id==1){   
  echo "0";
}else{
 
    $nombre =$nombre;
    $user->nombre =  ucwords($nombre);
    $user->nombreUsuario = $nombreUsuario;
    $user->password = $password;
    $user->fechaNacimiento = $fechaNacimiento;
    $user->genero = $genero;
    $user->userLevel = 2;
    $user->idReferido = 1;
    $user->confirmacion = 0;
    $user->created = "NOW()";
    $user->image = "no_image.jpg";
    $user->estatus = 1;
    $user->add();
    echo "1";  
}
?>
