<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
        if($datos==1){
           
            $email = $_POST['email']; // valor para sacar el id del usuario
            $f = new FuncionesData();
            $t = $f->foundValor("jm_users","email",$email,"UserData");
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
                $bio = $_POST['bio'];
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
                $user_objeto->bio =$bio;
                $user_objeto->add();

                $result = $user_objeto->getDataObjeto($email);
                header("Content-Type: application/json");
                echo json_encode($result);
               // echo "1";
            }          
        }
    }

    if($accion ==3){
        if($datos==1){
                // eliminar fisicamente al usaurio
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $user_objeto = new UserData();
               
                $user_objeto->id =$id;                
                $user_objeto->delF();
               echo "1";
            }          

    }

    if($accion ==4){
            if($datos==1){
                // para eliminar logicamente al usuario
                    $id = $_POST['id']; // valor para sacar el id del usuario         
                    $user_objeto = new UserData();
                   
                    $user_objeto->id =$id;                
                    $user_objeto->delL();
                   echo "1";
                }          
    
    }

    if($accion ==5){
                if($datos==1){
                    // para activar logicamente al usuario
                        $id = $_POST['id']; // valor para sacar el id del usuario         
                        $user_objeto = new UserData();
                       
                        $user_objeto->id =$id;                
                        $user_objeto->activar();
                       echo "1";
                    }          
        
    }

    if($accion ==6){
            if($datos==1){
                // para activar logicamente al usuario
                    $id = $_POST['id']; // valor para sacar el id del usuario  
                    $password = sha1(md5($_POST['confirmContrasena']));       
                    $user_objeto = new UserData();
                   
                    $user_objeto->id =$id;           
                    $user_objeto->password =$password;
                    $user_objeto->cambiarClave();
                 echo "1";
                }          
    
    }  


  if ($accion == '7') {
    if ($datos == '1') {
        
        // Establecer cabecera JSON para que jQuery lo entienda correctamente
        header("Content-Type: application/json");

        // 1. Verificar si el email fue enviado
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            echo "0"; // Error genérico
            exit;
        }

        $email = $_POST['email'];

        // 2. Buscar el usuario en la base de datos
        $f = new FuncionesData();
        // Usamos tu función existente para buscar por email
        $t = $f->foundMailCliente($email);

        // 3. Validar si se encontró el usuario
        // Verificamos que $t no sea false/empty y que tenga el ID
        if ($t && isset($t[0]) && isset($t[0]->id)) {
            
            $id = $t[0]->id;

           // echo $id; // Usuario encontrado, procedemos con la lógica de recuperación

                $p = $f->radomPassword();
            $user_objeto = new UserData();
            $user_objeto->id = $id;
            $user_objeto->password = sha1(md5($p));
            $user_objeto->cambiarClave();

            $cliente ="Nombre del Cliente"; // Aquí deberías obtener el nombre del cliente desde tu base de datos usando el ID o el email
                // Asegúrate de definir esta variable con la URL de recuperación (ej: http://tuweb.com/reset.php?token=xyz)
               

                    $enlace = "https://app.grupo-solsumed.com"; 

                    $html = '
                    <div style="background-color:#F5F7FF;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                        <table style="background-color:#F5F7FF;width:100%">
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                                        <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                                            <table cellpadding="0" cellspacing="0" style="background:#fff;border:0px solid #e9e9e9;border-radius:3px" width="100%">
                                                <tbody>
                                                <!-- HEADER: Logo Superior -->
                                                <tr>
                                                        <td style="vertical-align:middle; padding:0; border-bottom:none; border-radius:0 0 3px 3px; text-align:center; background-color:#fff;">
                                                        <img alt="Mostrar Logo" src="https://drive.usercontent.google.com/download?id=12qJIWaFeyNvWSyNo8UdcoEivFhVNvjLa&authuser=0" style="width:100%; height:auto; max-width:100%; display:block; margin:0 auto;" class="CToWUd" data-bit="iit">
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="vertical-align:top;padding:25px">
                                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="vertical-align:top;padding:0px">
                                                                            Estimado(a) <strong>'.$email.',</strong>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td style="vertical-align:top;padding:15px 0">
                                                                            <p style="font-size:14px;margin:0 0 15px 0;color:#444">
                                                                                Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Si fuiste tú quien solicitó este cambio, haz clic en el siguiente botón para crear ingresar con sus nuevas credenciales.:
                                                                            </p>

                                                                               <br>   <br>
                                                                            
                                                                            <!-- Botón de Acción -->
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 20px 0;">
                                                                                <tr>
                                                                                    <td align="center">
                                                                                       Su nueva contraseña es
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="center">
                                                                                      <strong>'. $p .'</strong>
                                                                                    </td>
                                                                                </tr>
                                                                                   <tr>
                                                                                    <td align="center">
                                                                                      <br>   <br>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="center">
                                                                                        <a href="'.$enlace.'" target="_blank" style="background-color:#348eda;border-radius:5px;color:#ffffff;display:inline-block;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:240px;-webkit-text-size-adjust:none">Acceder a Grupo solsumed, CA</a>
                                                                                    </td>
                                                                                </tr>
                                                                             
                                                                            </table>
                                                                            
                                                                          
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <!-- Información de contacto (Mantenido de tu original) -->
                                                                    <tr>
                                                                        <td style="vertical-align:top;padding:20px 0 0;border-top:1px solid #eee;margin-top:20px">
                                                                            <p style="font-size:12px;color:#666;margin:0">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: (0251)-7170029 (0416)-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <!-- FOOTER: Logo Inferior -->
                                                    <tr>
                                                        <td style="vertical-align:middle; padding:0; border-bottom:none; border-radius:0 0 3px 3px; text-align:center; background-color:#fff;">
                                                        <img alt="Mostrar Logo" src="https://drive.usercontent.google.com/download?id=1Tscz9W90QGhPoQVouO058Y-G_cwHN9lp&authuser=0" style="width:100%; height:auto; max-width:100%; display:block; margin:0 auto;" class="CToWUd" data-bit="iit">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';

                      $objeto_empresa = New EmpresaData();
                      $data = $objeto_empresa->getAllDatosCorreo();
                      $Username=$data[0]->email;
                      $Password=$data[0]->password;
                      $Port=$data[0]->port;
                      $Host=$data[0]->host;
                      $From=$data[0]->email;
                      $FromName=$data[0]->email;
                      $Subject=$data[0]->email; 
                      $Text=$data[0]->text; 
                      $email_cobros=$data[0]->email_cobros;               
    
                      $enviar_objeto = new EnviarData();
                      $enviar_objeto->Host= 'smtp.gmail.com';
                      $enviar_objeto->Port= '587';
                      $enviar_objeto->Username='pruebas.envios2025@gmail.com';
                      $enviar_objeto->Password= 'smfrdumngyelgfah';
                      $enviar_objeto->From= 'pruebas.envios2025@gmail.com';
                      $enviar_objeto->FromName= 'pruebas.envios2025@gmail.com';
                      $enviar_objeto->To=$email;
                    
                    $enviar_objeto->Text=$html ;
                    $enviar_objeto->Subject='Restablecimiento de Contraseña';

                        $enviar_objeto->enviarCorreoRestablecimiento();
  
           
            
          echo "1"; 
            
        } else {
            // ERROR: El correo no está registrado
            // El JS espera "0" para mostrar el mensaje de "Correo no registrado"
            echo "0";
        }
    }
}
   
   
}
?>