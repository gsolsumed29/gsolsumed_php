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
            $email_ventas = $_POST['email_ventas'];
            $email_cobros = $_POST['email_cobros'];
           

            $user_objeto->name =$name;
            $user_objeto->email =$email;
            $user_objeto->email_ventas =$email_ventas;
            $user_objeto->email_cobros =$email_cobros;
            $user_objeto->telefonos =$telefonos;
            $user_objeto->rif =$rif;
            $user_objeto->dir =$direccion;
            $user_objeto->update();

            $result = $user_objeto->getAllDatos();
            header("Content-Type: application/json");
            echo json_encode($result);
          
        }
    }  

    if($accion==3){
        if($datos==1){
           // data:{text:$text,smtp:$smtp,password:$password,host:$host,puerto:$puerto,tipo:tipo,accion:accion,datos:datos},
            $user_objeto = new EmpresaData();
           
            $text = $_POST['text'];              
            $smtp = $_POST['smtp'];
            $password = $_POST['password'];
            $host = $_POST['host'];
            $port = $_POST['port'];
         
            $user_objeto->text =$text;
            $user_objeto->smtp =$smtp;
            $user_objeto->password =$password;
            $user_objeto->host =$host;
            $user_objeto->port =$port;
            $user_objeto->updateCorreo();

            $result = $user_objeto->getAllDatosCorreo();
            header("Content-Type: application/json");
            echo json_encode($result);
          
        }
    }  
   
   
}
?>