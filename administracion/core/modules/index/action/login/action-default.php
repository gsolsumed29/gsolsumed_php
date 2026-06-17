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
	$_SESSION['estado'] = $t->status;
  $_SESSION['nombre'] = $t->name;
  $_SESSION['nombreUsuario'] = $t->email;
  $_SESSION['nivel'] = $t->rol;
  $_SESSION['almacen'] = $t->co_sub;
  $_SESSION['identidad'] = $t->co_ven;
  $_SESSION['co_alma'] = $t->co_alma;
  $_SESSION['image'] = $t->image;
  $user->email =$t->email;
  $user->loginTime();
  echo "1";
    }
if($rol==2){
  $confirmacion=$t->confirmacion; 
  if($confirmacion==1){
  $_SESSION['logged_in'] = true; 
	$_SESSION['estado'] = $t->estatus;
  $_SESSION['nombre'] = $t->nombre;
  $_SESSION['nombreUsuario'] = $t->nombreUsuario;
  $_SESSION['nivel'] = $t->userLevel;
  $_SESSION['almacen'] = $t->co_sub;
  $_SESSION['co_alma'] = $t->co_alma;
  $_SESSION['identidad'] = $t->co_ven;
  $_SESSION['image'] = $t->image;
  $user->nombreUsuario =$t->nombreUsuario;
  $user->loginTime();
 
  echo "2";
  }else{
    echo "4";
  }
}
if($rol==3){
  $confirmacion=$t->confirmacion; 
  if($confirmacion==1){
  $_SESSION['logged_in'] = true; 
	$_SESSION['estado'] = $t->estatus;
  $_SESSION['nombre'] = $t->nombre;
  $_SESSION['nombreUsuario'] = $t->nombreUsuario;
  $_SESSION['nivel'] = $t->userLevel;
  $_SESSION['image'] = $t->image;
  $user->nombreUsuario =$t->nombreUsuario;
  $user->loginTime();
  /*$geoplugin = new geoPlugin();
  $geoplugin->locate();
  $ip = new IpData();
    $ip->user_id =$t->nombreUsuario;
    $ip->realip =$geoplugin->ip;
    $ip->city =$geoplugin->city;
    $ip->region =$geoplugin->region;
    $ip->dmaCode =$geoplugin->dmaCode;
    $ip->countryName =$geoplugin->countryName;
    $ip->countryCode =$geoplugin->countryCode;
    $ip->inEU =$geoplugin->inEU;
    $ip->euVATrate =$geoplugin->euVATrate;
    $ip->latitude =$geoplugin->latitude;
    $ip->longitude =$geoplugin->longitude;
    $ip->locationAccuracyRadius =$geoplugin->locationAccuracyRadius;
    $ip ->add();
    */
    echo "3";
  }else{
    echo "4";
  }
}
}else{
  echo "0";
}
?>
