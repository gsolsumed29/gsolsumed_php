<?php
$nombreUsuario = $_POST['email'];
$password = sha1(md5($_POST['password']));
$user = new UserData(); 
$t = $user->login($nombreUsuario,$password);
if(!isset($t)){
$id=0;
}else{
  $id = $t->id;	
}

if($id>=1){   
  $rol=$t->rol;
 
  if($rol==1){
    
  $_SESSION['logged_in'] = true; 
  $_SESSION['timeout'] = time();
	$_SESSION['estado'] = $t->status;
  $_SESSION['nombre'] = $t->name;
  $_SESSION['nombreUsuario'] = $t->email;
  $_SESSION['nivel'] = $t->rol;
 // $_SESSION['almacen'] = $t->co_sub;
  $_SESSION['identidad'] = $t->co_ven;
 // $_SESSION['co_alma'] = $t->co_alma;
  $_SESSION['image'] = $t->image;
  $user->email =$t->email;
  $user->loginTime();
  echo "1";
    }
if($rol==2){
  $status=$t->status;
  if($status==1){
  $_SESSION['logged_in'] = true; 
  $_SESSION['timeout'] =  time();
	$_SESSION['estado'] = $t->status;
  $_SESSION['nombre'] = $t->name;
  $_SESSION['nombreUsuario'] = $t->email;
  $_SESSION['nivel'] = $t->rol;

  $_SESSION['identidad'] = $t->co_ven;

  $_SESSION['image'] = $t->image;
  $user->email =$t->email;
  $user->loginTime();
  echo "2";
  }else{
  echo "4";
  }
}
if($rol==3){
  $status=$t->status;
  if($status==1){
  $_SESSION['logged_in'] = true; 
  $_SESSION['timeout'] = time();
	$_SESSION['estado'] = $t->status;
  $_SESSION['nombre'] = $t->name;
  $_SESSION['nombreUsuario'] = $t->email;
  $_SESSION['nivel'] = $t->rol;
  //$_SESSION['almacen'] = $t->co_sub;
  $_SESSION['identidad'] = $t->co_ven;
  //$_SESSION['co_alma'] = $t->co_alma;
  $_SESSION['image'] = $t->image;
  $user->email =$t->email;
  $user->loginTime(); 
  echo "3";
  }else{
    echo "4";
  }
}

if($rol==4){
  $status=$t->status;
  if($status==1){
  $_SESSION['logged_in'] = true; 
  $_SESSION['timeout'] =  time();
	$_SESSION['estado'] = $t->status;
  $_SESSION['nombre'] = $t->name;
  $_SESSION['nombreUsuario'] = $t->email;
  $_SESSION['nivel'] = $t->rol;
 // $_SESSION['almacen'] = $t->co_sub;
  $_SESSION['identidad'] = $t->co_ven;
 // $_SESSION['co_alma'] = $t->co_alma;
  $_SESSION['image'] = $t->image;
  $user->email =$t->email;
  $user->loginTime();
  echo "4";
  }else{
  echo "4";
  }
}
}else{
  echo "0";
}
?>
