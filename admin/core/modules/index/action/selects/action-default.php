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


if($accion ==1){
    if($datos==1){       
        $clase =$_GET['c'];
        $tabla = $_GET['t'];
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new  $clase();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getAllEstados();
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }
     if($datos==2){       
        $clase =$_GET['c'];  // clase
        $tabla = $_GET['t'];  // tabla
        $dato = $_GET['d']; // dato
        $campo = $_GET['cp']; // campo
        
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new  $clase();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getByCampoEstados($tabla,$campo,$dato);
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }

     if($datos==3){       
        $clase =$_GET['c'];  // clase
        $tabla = $_GET['t'];  // tabla
        $dato = $_GET['d']; // dato
        $campo = $_GET['cp']; // campo
        
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new  $clase();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getByCampoMunicipios($tabla,$campo,$dato);
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }

         if($datos==4){       
        $clase =$_GET['c'];  // clase
        $tabla = $_GET['t'];  // tabla
        $dato = $_GET['d']; // dato
        $campo = $_GET['cp']; // campo
        
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new  $clase();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getByCampoEstadosCiudades($tabla,$campo,$dato);
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }

  }     


?>