<?php
$clase =$_GET['c'];
$tabla = $_GET['t'];
if(isset($_GET['a'])){
    $a=$_GET['a'];
    }


if($a==1){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];



    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosFacturacion($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}


if($a==2){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];
    


    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosCobranzas($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}
if($a==3){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];
    


    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatoTopsArticulos($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}
if($a==4){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];
    

    // echo $vendedorId;
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosCobranzas($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}

if($a==5){
   
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];

    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosClientesActivos($ano,$mes,$vendedorId);          
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==6){
   
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];

    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosClientesNuevos($ano,$mes,$vendedorId);          
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==7){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];
    


    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatoTopsArticulosBialy($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}


if($a==8){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatoTopsArticulosBialy($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}



if($a==9){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];

    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDatoCalculoImplicito();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}

if($a==10){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
   $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosCuentasXPagar($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}
if($a==11){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];

       $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosCuentasXCobrar($ano,$mes,$vendedorId);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}

if($a==12){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];



    $ano = $_GET['fechaInicio'];
    $mes = $_GET['fechaFin'];
    $vendedorId = $_GET['vendedorId'];

    $filtroDias = $_GET['filtroDias']; 

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosSaldosFacturas($ano,$mes,$vendedorId,$filtroDias);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}


if($a==14){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];


    $filtroDias = $_GET['filtroDias']; 

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosTotalFacturas($filtroDias);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}


if($a==15){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosTotalFacturasEmitidas();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
    
}


?>