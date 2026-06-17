<?php
$clase =$_GET['c'];
$tabla = $_GET['t'];
if(isset($_GET['a'])){
    $a=$_GET['a'];
}


if($a==1){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
        $filtro = '1';
        $filtro2 ='2';
        $filtro3 ='3';
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getDataIndicadorFacturasVerificacion($filtro,$filtro2,$filtro3);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);


}

if($a==2){
 
    
    $datos = new $clase(); 
    $result=[];
        $ano = $_GET['ano'];
        $mes = $_GET['mes'];   // otro 
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getDataIndicadorVerificaciones($ano,$mes);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);


}

if($a==3){
     
    
    $datos = new $clase(); 
    $result=[];
        $ano = $_GET['ano'];
        $mes = $_GET['mes'];   // otro 
        $opcion = $_GET['opcion'];   // otro 
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getDataIndicadorDespachosInternos($ano,$mes,$opcion);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);
}


if($a==4){
     $datos = new $clase(); 
    $result=[];
        $ano = $_GET['ano'];
        $mes = $_GET['mes'];   // otro 
        $opcion = $_GET['opcion'];   // otro 
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getDataIndicadorcantidadViajesVehiculos($ano,$mes,$opcion);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);
}


if($a==5){
  $result=[];
  header("Content-Type: application/json");
        echo json_encode($result);
}

if($a==6){
  $result=[];
  header("Content-Type: application/json");
        echo json_encode($result);
}

if($a==7){
  $result=[];
  header("Content-Type: application/json");
        echo json_encode($result);
}

if($a==8){
  $result=[];
  header("Content-Type: application/json");
        echo json_encode($result);
}

if($a==9){
  $result=[];
  header("Content-Type: application/json");
        echo json_encode($result);
}

if($a==10){
  $result=[];
  header("Content-Type: application/json");
        echo json_encode($result);
}


?>