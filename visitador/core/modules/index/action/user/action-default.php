<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
           
            $email = $_POST['email']; // valor para sacar el id del usuario
            $f = new FuncionesData();
            $t = $f->foundValor("users","email",$email,"UserData");
          // print_r($t);
            $id = $t[0]->id;
            if($id==1){
                $result = array(['id'=>'0'],['id'=>'1']);
             
                header("Content-Type: application/json");
                echo json_encode($result);

            }else{

             
                $user_objeto = new UserData();
                  
                $email = $_POST['email'];              
                $rol = $_POST['rol'];
                $co_ven = $_POST['co_ven'];
                $co_sub = $_POST['co_sub'];
                $co_alma = $_POST['co_alma'];
                $password = sha1(md5($_POST['confirmContrasena']));

             
                $user_objeto->email =$email;
                $user_objeto->password =$password;
                $user_objeto->co_ven =$co_ven;
                $user_objeto->co_sub =$co_sub;
                $user_objeto->co_alma =$co_alma;
                $user_objeto->rol =$rol;
                $user_objeto->add();

                $result = $user_objeto->getDataObjeto($email);
                header("Content-Type: application/json");
                echo json_encode($result);
               // echo "1";
            }
            
            
            
            
            /*
         
            $profesor = new ProfesorData();
           
         
           
            $titulo = $_POST['titulo'];
            $universidad = $_POST['universidad'];
            $apellidos = $_POST['apellidos'];
            $nombres = $_POST['nombres'];

            $pais = $_POST['pais'];
            $nacionalidad = $_POST['nacionalidad'];

            $fechaNacimiento = $_POST['fechaNacimiento'];
            $especialidad = $_POST['especialidad'];
            $experiencia = $_POST['experiencia'];
            $biografia = $_POST['biografia'];
            $profesor->idUser =$id;
            $profesor->dni =$dni;

            $profesor->ingles =$ingles;
          
            $profesor->titulo =$titulo;
            $profesor->universidad =$universidad;
            $profesor->apellidos =$apellidos;
            $profesor->nombres =$nombres;
            $profesor->pais =$pais;
            $profesor->nacionalidad =$nacionalidad;

            $profesor->especialidad =$especialidad;
            $profesor->experiencia =$experiencia;
            $profesor->fechaNacimiento =$fechaNacimiento;
            $profesor->biografia =$biografia;
            $profesor->update();
            echo "1";
*/   
        }
    }
    if($accion ==3){
        if($datos==1){
           
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $user_objeto = new UserData();
               
                $user_objeto->id =$id;                
                $user_objeto->delF();
               echo "1";
            }
            
            
          

        }
    
   
   
}
?>