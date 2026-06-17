<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
           /*
            $numero = $_POST['numero']; // valor para sacar el id del usuario
            $f = new FuncionesData();
            $t = $f->foundValor("banco","numero",$numero,"BancoData");
            $id = $t->cuenta;
            if($id==1){
                echo "2";
            }else{
                $banco_objeto = new BancoData();
                $banco = $_POST['banco'];           
                $tipoCuenta = $_POST['tipoCuenta'];
                $numero = $_POST['numero'];
                $codigo = $_POST['codigo'];
                $banco_objeto->banco =$banco;
                $banco_objeto->tipo =$tipoCuenta;
                $banco_objeto->numero =$numero;
                $banco_objeto->codigo =$codigo;
                $banco_objeto->add();
                echo "1";
            }
    */
        }
      
    }
    if($accion ==3){
        if($datos==1){
                $media =  $_POST['media'];
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $media_objeto = new PortafolioData();
               
                $media_objeto->id =$id;                
                $media_objeto->delf($id);   
                unlink($media);
         
               echo "1";
            }
            
            
          

        }
    
   
   
}
?>