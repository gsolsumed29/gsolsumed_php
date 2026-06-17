<?php
if(count($_SESSION["cart"])==1){
	unset($_SESSION["cart"]);
}else{	
	$products = $_SESSION["cart"];
	$news = array();
	foreach ($products as $product) {
		if($product["q"]!=$_GET["op"]){
			array_push($news, $product);
		}
	}
	$_SESSION["cart"]=$news;
}
$planId = $_GET['plan_id'];
$numeroPlatos = $_GET['pl'];
$suma = $numeroPlatos +1;
$op = $_GET["op"];
if($_GET["href"]=="cart"){
Core::redir("index.php?view=time&plan_id=$planId&pl=$suma&op=$op");
}
?>

