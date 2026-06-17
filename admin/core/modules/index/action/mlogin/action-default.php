<?php
// api/login_app.php

header('Content-Type: application/json; charset=UTF-8');
session_start();

// 1. IMPORTAR TUS CLASES ACTUALES
// Ajusta la ruta según dónde estén tus clases UserData y EmpresaData en tu proyecto actual
// Ejemplo: require_once '../core/Database.php'; 
// require_once '../models/UserData.php';


// 2. RECIBIR DATOS EN JSON Y PASARLOS A $_POST
// Tu lógica actual lee $_POST['email'] y $_POST['password'], por lo que simulamos esto:
 $json = file_get_contents("php://input");
 $data = json_decode($json);

if (isset($data->email) && isset($data->password)) {
    $_POST['email'] = $data->email;
    $_POST['password'] = $data->password; // El PHP hará el sha1(md5(...))

    // 3. CAPTURAR LA SALIDA DE TU LÓGICA ACTUAL
    // Usamos Output Buffering para evitar que el código haga "echo" y corte el JSON
    ob_start();

    // --- AQUÍ PEGAS TU LÓGICA ORIGINAL (O LA INCLUYES) ---
    $nombreUsuario = $_POST['email'];
    $password = sha1(md5($_POST['password']));
    $user = new UserData(); 
    $userData = $user->login($nombreUsuario, $password);
    $id = isset($userData) ? $userData->id : 0;

    if ($userData && isset($userData->rol)) {
        $rol = $userData->rol;
        $status = $userData->status;
        $co_user = $userData->co_ven;

        if ($status != 1) {
            echo "99"; 
            exit;
        }

                        // Funciones auxiliares para configurar sesión
            function setCommonSessionData($userData) {
                // Datos de la empresa
                $empresa = (new EmpresaData())->getAllDatos()[0];
                
                $_SESSION['name'] = $empresa->name;
                $_SESSION['email'] = $empresa->email;
                $_SESSION['telefonos'] = $empresa->telefonos;
                $_SESSION['rif'] = $empresa->rif;
                $_SESSION['direccion'] = $empresa->dir;
                $_SESSION['src'] = $empresa->image;
                
                // Datos básicos del usuario
                $_SESSION['logged_in'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['estado'] = $userData->status;
                $_SESSION['nombre'] = $userData->name;
                $_SESSION['nombreUsuario'] = $userData->email;
                $_SESSION['nivel'] = $userData->rol;
                $_SESSION['tipo_precio'] = $userData->bio;
                $_SESSION['almacen'] = $userData->co_sub;
                $_SESSION['identidad'] = $userData->co_ven;
                $_SESSION['co_alma'] = $userData->co_alma;
                $_SESSION['image'] = $userData->image;
                $_SESSION['co_us'] = $userData->co_us;
                $_SESSION['bio'] = $userData->bio;
                $_SESSION['tasa'] = $userData->tasa ?? null;
                $_SESSION['tipo_ven'] = $userData->tipo_ven; // Tipo de vendedor
            }


            function setCommonSessionDataPersonas($userData) {
                // Datos de la empresa
                $empresa = (new EmpresaData())->getAllDatos()[0];
                
                $_SESSION['name'] = $empresa->name;
                $_SESSION['email'] = $empresa->email;
                $_SESSION['telefonos'] = $empresa->telefonos;
                $_SESSION['rif'] = $empresa->rif;
                $_SESSION['direccion'] = $empresa->dir;
                $_SESSION['src'] = $empresa->image;
                
                $_SESSION['logged_in'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['estado'] = $userData->status;
                $_SESSION['nombre'] = $userData->name;
                $_SESSION['nombreUsuario'] = $userData->email;
                $_SESSION['nivel'] = $userData->rol;
                $_SESSION['tipo_precio'] = $userData->bio;
                $_SESSION['almacen'] = $userData->co_sub;
                $_SESSION['identidad'] = $userData->co_ven;
                $_SESSION['co_alma'] = $userData->co_alma;
                $_SESSION['image'] = $userData->image;
                $_SESSION['co_us'] = $userData->co_us;
                $_SESSION['bio'] = $userData->bio; 
                $_SESSION['tipo_ven'] = $userData->tipo_ven; // Tipo de vendedor
                
            }



            function setVendedorSessionData($userData) {
                $_SESSION['cliente_des'] = "0";
                $_SESSION['tipo_precio'] = "0";
                $_SESSION['cliente_facturacion'] = "0";
                $_SESSION['cliente_forma'] = "0";
            }

            function setClienteSessionData($userData) {
                // Configuraciones específicas para clientes
                $_SESSION['es_cliente'] = true;
                $_SESSION['cliente_id'] = $userData->id;
                // Puedes agregar más datos específicos del cliente aquí
            }
     switch ($rol) {
        case 1: // Administrador
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "1";
            break;
            
        case 2: // Vendedor
            $userData = $user->login_vendedor($co_user);
            setCommonSessionData($userData);
            setVendedorSessionData($userData);
            echo "2";
            break;    
            
        case 6: // chofer
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "5";
            break;

        case 10: // Cliente
            setClienteSessionData($userData);
            echo "4";
            break;
     
                      
        case 14: // Gerencia
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "3";
            break;   
    
        case 16: // Almacen 
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "6";
            break;  
              
            
        default:
            echo "98"; // Rol no reconocido
            break;
    }
    } else {
        echo "0"; 
    }
    


    // --- FIN DE TU LÓGICA ORIGINAL ---

    // 4. INTERPRETAR EL RESULTADO Y DAR FORMATO JSON
    $response_code = ob_get_clean(); // Obtenemos lo que "echo" tu lógica (ej. "1", "0")

    // Limpiamos espacios en blanco por si acaso
    $response_code = trim($response_code);

    if ($response_code == "0") {
        // Login fallido
        echo json_encode(["status" => "error", "message" => "Usuario o contraseña incorrectos"]);

    } elseif ($response_code == "99") {
        // Usuario desactivado
        echo json_encode(["status" => "error", "message" => "El usuario está desactivado"]);

    } else {
        // Login Exitoso
        // Devolvemos los datos de sesión que acabamos de guardar para que la app los use
        echo json_encode([
            "status" => "success",
            "message" => "Login correcto",
            "data" => [
                "rol" => $response_code, // El numero del rol (1, 2, 10...)
                "nombre" => $_SESSION['nombre'] ?? 'Usuario',
                "email" => $_SESSION['nombreUsuario'] ?? '',
                "id" => $_SESSION['identidad'] ?? '',
                "foto" => $_SESSION['image'] ?? '',
                "empresa" => [
                    "name" => $_SESSION['name'] ?? '',
                    "rif" => $_SESSION['rif'] ?? ''
                ]
            ]
        ]);
    }

} else {
    // Datos incompletos
    echo json_encode(["status" => "error", "message" => "Faltan datos (email/password)"]);
}
?>