<?php
// Procesar credenciales
$nombreUsuario = $_POST['email'];
$password = sha1(md5($_POST['password']));
$user = new UserData(); 

$userData = $user->login($nombreUsuario, $password);
$id = isset($userData) ? $userData->id : 0; 

if ($userData && isset($userData->rol)) {
    $rol = $userData->rol;
    $status = $userData->status;
     $co_user = $userData->co_ven;


    // Verificar si el usuario está activo
    if ($status != 1) {
        echo "99"; // Usuario desactivado
        exit;
    }



    
     switch ($rol) {
        case 1: // Administrador
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "1";
            break;
            
        case 2: // Vendedor

            $tipo ='2';
            $userData = $user->login_vendedor($co_user);
            $tipo_vendedor =  trim($userData->tipo_ven);           
            if($tipo_vendedor=='*'){
                $tipo = '18';}

            setCommonSessionData($userData);
            setVendedorSessionData($userData);

            echo $tipo;
            break;
            
        case 3: // Gerente
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            
            echo "3";
            break;
            
        case 4: // despacho - inventario
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "4";
            break;
             // Agente de despacho
        case 5: // despacho - chofer
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "5";
            break;
            
        case 6: // chofer
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "6";
            break;

        case 10: // Cliente
        $userData = $user->login_jmPersona_cliente($co_user);
        $matrizData = $user->login_jmPersona_matriz($co_user);
        
        // Filtrar y mapear los datos
        $sucursalesFiltradas = array_map(function($item) {
            return [
                'co_cli_matriz' => $item->co_cli_matriz ?? '',
                'matriz' => trim($item->matriz ?? ''),
                'rif_matriz' => $item->rif_matriz ?? '',
                'co_cli_sucursal' => $item->co_cli_sucursal ?? '',
                'sucursal' => trim($item->sucursal ?? ''),
                'rif_sucursal' => $item->rif_sucursal ?? ''
            ];
        }, is_array($matrizData) ? $matrizData : []);
        
    
            $lastLogin = $user->loginTime($nombreUsuario);
            setCommonSessionDataClientes($userData);
            setClienteSessionData($userData,$sucursalesFiltradas);
             echo "10";
        break;

        case 11: // compras
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "11";
            break;

        case 12: // ventas
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "12";
            break;

        case 13: // Administracion - cobranzas
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "13";
            break;            
        case 14: // Gerencia
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 

            echo "14";

            break;   
        case 15: // Gerencia
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "15";
            break;  

        case 16: // Almacen 
            $userData = $user->login_jmPersona($co_user);
            setCommonSessionDataPersonas($userData); 
            echo "16";
            break;  
      
        case 17: // CONTABILIDAD
                $userData = $user->login_jmPersona($co_user);
                setCommonSessionDataPersonas($userData); 
                echo "17";
                break;  
        case 19: // MERCADEO
                $userData = $user->login_jmPersona($co_user);
                setCommonSessionDataPersonas($userData); 
                echo "19";
                break;  
            
        default:
            echo "98"; // Rol no reconocido
            break;
    }
    

} else {
    echo "0"; // Credenciales inválidas
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


function setCommonSessionDataClientes($userData) {
    // Datos de la empresa
    $empresa = (new EmpresaData())->getAllDatos()[0];
    

    
    $_SESSION['logged_in'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['estado'] = $userData->status;
    $_SESSION['nombre'] = $userData->name;
    $_SESSION['nombreUsuario'] = $userData->co_ven;
    $_SESSION['nivel'] = $userData->rol;
    $_SESSION['tipo_precio'] = $userData->bio;
    $_SESSION['almacen'] = $userData->co_sub;
    $_SESSION['identidad'] = $userData->co_ven;
    $_SESSION['co_alma'] = $userData->co_alma;
    $_SESSION['image'] = $userData->image;
    $_SESSION['co_us'] = $userData->co_us;
    $_SESSION['bio'] = $userData->bio; 
    $_SESSION['tipo_ven'] = $userData->tipo_ven; // Tipo de vendedor
    $_SESSION['tasa'] = $userData->tasa ?? 0.00;
           // Guardar en sesión
     
        
    
}




function setVendedorSessionData($userData) {
    $_SESSION['cliente_des'] = "0";
    $_SESSION['tipo_precio'] = "0";
    $_SESSION['cliente_facturacion'] = "0";
    $_SESSION['cliente_forma'] = "0";
}

function setClienteSessionData($userData,$sucursalesFiltradas) {
    // Configuraciones específicas para clientes
    $_SESSION['es_cliente'] = true;
    $_SESSION['cliente_id'] = $userData->id;
    $_SESSION['sucursales_cliente'] = $sucursalesFiltradas;
        // Guardar en sesión
    $_SESSION['cantidad_sucursales'] = count($sucursalesFiltradas);
    // Puedes agregar más datos específicos del cliente aquí
}

function setEmpresaGerenteSessionData($userData) {
    $_SESSION['cliente_des'] = "0";
    $_SESSION['tipo_precio'] = "0";
    $_SESSION['cliente_facturacion'] = "0";
    $_SESSION['cliente_forma'] = "0";
}

?>