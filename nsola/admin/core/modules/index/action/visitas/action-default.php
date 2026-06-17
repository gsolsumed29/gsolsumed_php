<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
           
         
             
                $visitas_objeto = new VisitasData();
                  
                $co_cli = $_POST['co_cli'];              
                $des_vis = $_POST['des_vis'];
                $lat = $_POST['lat'];       
                $lon = $_POST['lon'];       
             
                $visitas_objeto->co_cli =$co_cli;
                $visitas_objeto->lat =$lat;
                $visitas_objeto->lon =$lon;
                $visitas_objeto->des_vis =$des_vis;
                $visitas_objeto->add();

                $result = $visitas_objeto->getDataObjeto();
                header("Content-Type: application/json");
                echo json_encode($result);
               // echo "1";
    
            
            
            
         
        }
    }

    if($accion ==3){
        if($datos==1){
                // eliminar fisicamente al usaurio
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $user_objeto = new VisitasData();
               
                $user_objeto->id =$id;                
                $user_objeto->delF();
               echo "1";
            }          

        }
   
   
}
?>