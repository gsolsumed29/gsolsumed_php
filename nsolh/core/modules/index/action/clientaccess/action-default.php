<?php
//define('LBROOT',getcwd()); // LegoBox Root ... the server root
//include("core/controller/Database.php");

$user = $_POST['email'];
$pass = sha1(md5($_POST['password']));

$base = new Database();
$con = $base->connect();
// print_r($con);
 $sql = "select * from user where (nombreUsuario= \"".$user."\" or email= \"".$user."\" ) and password= \"".$pass."\" and estatus=1";
//print $sql;
$query = $con->query($sql);
$found = false;
$userid = null;
while($r = $query->fetch_array()){
	$found = true ;
	$userid = $r['id'];
	$date = strftime("%Y-%m-%d %H:%M:%S", time());
	$sql = "UPDATE user SET ultimoLogin='{$date}' WHERE id ='{$userid}' LIMIT 1";
	$query2 = $con->query($sql);
	//$r = $query->fetch_array();
}

if($found==true) {
	//session_start();
//	print $userid;
	$_SESSION['admin_id']=$userid ;
//	setcookie('userid',$userid);
//	print $_SESSION['userid'];
	print "Cargando ... $user";
	print "<script>window.location='./admin';</script>";
}else {
	print "<script>window.location='index.php?view=clientaccess&error';</script>";
}
?>
