<?php
$clase =$_GET['c'];
$tabla = $_GET['t'];
if(isset($_GET['a'])){
    $a=$_GET['a'];
    }


if($a==1){
    
    $datos = new $clase(); 
    $result=[];
    $co_cli = $_GET['co_cli'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDataPreguntas($co_cli);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 
/*
if($a==2){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltrada($filtro);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} */
