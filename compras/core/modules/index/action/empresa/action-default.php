<?php

 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
   
    if($accion==2){
        if($datos==1){

            $user_objeto = new EmpresaData();
            //echo "Llegue";
            $name = $_POST['name'];              
            $email = $_POST['email'];
            $telefonos = $_POST['telefonos'];
            $rif = $_POST['rif'];
            $direccion = $_POST['direccion'];
         
            $user_objeto->name =$name;
            $user_objeto->email =$email;
            $user_objeto->telefonos =$telefonos;
            $user_objeto->rif =$rif;
            $user_objeto->dir =$direccion;
            $user_objeto->update();

            $result = $user_objeto->getAllDatos();
            header("Content-Type: application/json");
            echo json_encode($result);
          
        }
    }  
   
   
}
?>