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
                    $result = $objeto->getVendedores_filtrados();
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }

    if($datos==2){          
   
        $clase =$_GET['c'];
        $tabla = $_GET['t'];
      
            $objeto = new  $clase();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getDataVerificadores();
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            
    }


       if($datos==3){          
   
        $clase =$_GET['c'];
        $tabla = $_GET['t'];
      
            $objeto = new  $clase();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getVendedoresFichas_Analisis_visitas();
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            
    }


  }     


?>