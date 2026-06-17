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
// 1 para registrar 2 para buscar ( datos1 para global / datos2 para especifico ) 3 para actualizar 4 para eliminar

if($accion==2){   
    
   

    if($datos==99){       
        $clase =$_GET['c'];
        $tabla = $_GET['t'];
        $dato = $_GET['d'];
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new NominaData();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->estadisticas($dato);
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }
  
}

if($accion==3){

    if($datos==1){
        // para activar logicamente al usuario
            $idSolicitud = $_POST['idSolicitud']; // valor para sacar el id del usuario         
            $user_objeto = new NominaData();
           
            $user_objeto->id =$idSolicitud;                
            $user_objeto->aceptar();
            echo "1";
        }     
        
        if($datos==2){
            // para activar logicamente al usuario
                $idSolicitud = $_POST['idSolicitud']; // valor para sacar el id del usuario         
                $user_objeto = new NominaData();
               
                $user_objeto->id =$idSolicitud;                
                $user_objeto->denegar();
                echo "1";
            }  


}

?>