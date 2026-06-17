<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
          
            //nombre cedula fechaNacimiento  telefono telefono2 correo

            $cedula = $_POST['cedula']; // valor para sacar el id del usuario
            $f = new FuncionesData();
            $t = $f->foundValor("cliente","cedula",$cedula,"ClienteData");
            $id = $t->cuenta;
            if($id==1){
                echo "2";
            }else{
            $cliente_objeto = new ClienteData();
            $nombre = $_POST['nombre'];           
            $cedula = $_POST['cedula'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $telefono = $_POST['telefono'];           
            $telefono2 = $_POST['telefono2'];
            $correo = $_POST['correo'];
      
            
            $cliente_objeto->nombre =$nombre;
            $cliente_objeto->cedula =$cedula;
            $cliente_objeto->fechaNacimiento =$fechaNacimiento;
            $cliente_objeto->telefono =$telefono;
            $cliente_objeto->telefono2 =$telefono2;
            $cliente_objeto->correo =$correo;
            $cliente_objeto->add();
            echo "1";
            }
        }
    }

    if($accion ==2){
        if($datos==1){
          
            //nombre cedula fechaNacimiento  telefono telefono2 correo
            $id = $_POST['idCliente'];        
            $cedula = $_POST['cedula']; // valor para sacar el id del usuario           
            $f = new FuncionesData();
            $t = $f->foundValor2("cliente","cedula",$cedula,"id",$id,"ClienteData");
            $id2 = $t->cuenta;
            if($id2==0){
                $t = $f->foundValor("cliente","cedula",$cedula,"ClienteData");
                $id = $t->cuenta;
                if($id==1){
                    echo "2";
                }else{

                $cliente_objeto = new ClienteData();
                $id = $_POST['idCliente'];          
                $nombre = $_POST['nombre'];           
                $cedula = $_POST['cedula'];
                $fechaNacimiento = $_POST['fechaNacimiento'];
                $telefono = $_POST['telefono'];           
                $telefono2 = $_POST['telefono2'];
                $correo = $_POST['correo'];
        
                $cliente_objeto->id =$id;
                $cliente_objeto->nombre =$nombre;
                $cliente_objeto->cedula =$cedula;
                $cliente_objeto->fechaNacimiento =$fechaNacimiento;
                $cliente_objeto->telefono =$telefono;
                $cliente_objeto->telefono2 =$telefono2;
                $cliente_objeto->correo =$correo;
                $cliente_objeto->update();
                echo "1";
                }
            }else{
                $cliente_objeto = new ClienteData();
                $id = $_POST['idCliente'];          
                $nombre = $_POST['nombre'];           
                $cedula = $_POST['cedula'];
                $fechaNacimiento = $_POST['fechaNacimiento'];
                $telefono = $_POST['telefono'];           
                $telefono2 = $_POST['telefono2'];
                $correo = $_POST['correo'];
        
                $cliente_objeto->id =$id;
                $cliente_objeto->nombre =$nombre;
                $cliente_objeto->cedula =$cedula;
                $cliente_objeto->fechaNacimiento =$fechaNacimiento;
                $cliente_objeto->telefono =$telefono;
                $cliente_objeto->telefono2 =$telefono2;
                $cliente_objeto->correo =$correo;
                $cliente_objeto->update();
                echo "1";
            }

        }
    }
    if($accion ==3){
        if($datos==1){
           
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $cliente_objeto = new ClienteData();
                $id2=0;
                $f = new FuncionesData();
                $t = $f->foundId("poliza","idCliente",$id,"PolizaData");
                $id2 = $t->cuenta;
                //echo $id2;
                if($id2!=0){
                    echo "2";
                }else{
                    $cliente_objeto->id =$id;
                    $cliente_objeto->delF();
                   echo "1";
                }
            }         
    }
         

        if($accion ==4){
            if($datos==1){
              
                //nombre cedula fechaNacimiento  telefono telefono2 correo
    
                $cedula = $_POST['documento']; // valor para sacar el id del usuario
                $f = new FuncionesData();
                $t = $f->foundValor("cliente","cedula",$cedula,"ClienteData");
                $id = $t->cuenta;
                if($id==1){
                  
                    $idC = $f->foundValorCedula("cliente","cedula",$cedula,"ClienteData");
                    $idCedula = $idC->idc;
                    $p = new PolizaData();
                    //echo $idCedula;
                    $result= $p->getDataClientes($idCedula);
                    if(!empty($result)){
                        header("Content-Type: application/json");
                        echo json_encode($result);
    
                    }else{
                        $result = array(['id'=>'no'],['id'=>'no']);
             
                        header("Content-Type: application/json");
                        echo json_encode($result);
                    }
                   
                }else{
                   // $result = array();
                   // header("Content-Type: application/json");
                   // echo json_encode($result);
                  
                }
            }
        }

    
   
   
}
?>