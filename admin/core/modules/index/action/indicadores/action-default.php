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
  
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
    $co_ven = $_GET['co_ven'];     
    $co_zona = $_GET['co_zona']; 
    $indicador = $_GET['indicador']; 
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getDataIndicadorVentasxPeriodo($co_ven,$co_zona,$finicio,$ffinal,$indicador);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);


}

if($a==2){
   
    $co_ven = $_GET['co_ven'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
     $indicador = $_GET['indicador']; 
         $co_zona = $_GET['co_zona']; 
    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataIndicadorClientesFacturados($co_ven,$co_zona,$finicio,$ffinal,$indicador);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==3){
   
    $co_ven = $_GET['co_ven'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
     $indicador = $_GET['indicador']; 
         $co_zona = $_GET['co_zona']; 
    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataIndicadorCobranzasMes($co_ven,$co_zona,$finicio,$ffinal,$indicador);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==4){
   
    $co_ven = $_GET['co_ven'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
     $indicador = $_GET['indicador']; 
         $co_zona = $_GET['co_zona']; 
    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataIndicadorClientesNuevos($co_ven,$co_zona,$finicio,$ffinal,$indicador);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 



if($a==5){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
  
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
    $co_ven = $_GET['co_ven'];     
    $co_zona = $_GET['co_zona']; 
    $indicador = "0"; 
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getMetasIndicadoresZonas($co_ven,$co_zona,$finicio,$ffinal,$indicador);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);


}



if($a==6){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
  
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
    $co_ven = $_GET['co_ven'];     
    $co_zona = $_GET['co_zona']; 
    $indicador = "0"; 
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getMetasIndicadoresRotacion($co_ven,$co_zona,$finicio,$ffinal,$indicador);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);


}






?>