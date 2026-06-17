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
if($tipo=='1'){    
        
    
    if($accion =='2'){
        if($datos=='1'){

            $clase =$_GET['c'];
            $tabla = $_GET['t'];
            $datos = new $clase(); 
            $result=[]; 
          
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                      $result = $datos->getDataMarcas();
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);

        }     
    }    
   
}

?>