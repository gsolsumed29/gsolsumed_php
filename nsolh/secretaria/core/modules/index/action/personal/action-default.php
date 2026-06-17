<?php
if((isset($_GET['tipo']))  || (isset($_GET['accion'])) || (isset($_GET['datos']))){
 
    $tipo = $_GET['tipo'];
    $accion = $_GET['accion'];
    $datos = $_GET['datos']; 
  
  }else{
  
    $tipo = $_POST['tipo'];
    $accion = $_POST['accion'];
    $datos = $_POST['datos']; 
  }


if($tipo==1){    
    if($accion ==1){
        if($datos==1){    

    $asunto = $_POST['asunto'];
    $tipo="1"; // para solicitud de constancias

    $objeto_constancia = New ReporteData();          
    $objeto_constancia->addSolicitudConstancia($asunto,$tipo);
    echo "1";
        }
    }
    if($accion==2){
        if($datos==1){       
            $clase =$_GET['c'];
            $tabla = $_GET['t'];
            if(isset($_GET['a'])){
                $a=$_GET['a'];
                }
            if($a==1){
                $objeto = new ReporteData();         
                $result=[];    
                    switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $objeto->getAllSolicitudes();
                        break;
                    }    
                header("Content-Type: application/json");
                echo json_encode($result);
    
                }
        }       
    }
}




?>

