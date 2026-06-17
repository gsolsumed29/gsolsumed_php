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
if($accion == 3){
  // Recuperar el email del POST
  $email = $_POST['email'];

  // Validar que el email no esté vacío
  if (!empty($email)) {
      
      // 1. PRIMERO VERIFICAMOS SI EL USUARIO EXISTE
      $usuario_encontrado = UserData::getByEmail($email);

      if ($usuario_encontrado != null) {
          // El usuario SÍ existe, así que procedemos a generar la contraseña
          
          $user_objeto = new UserData();
          $user_objeto->email = $email;

          // Generar la nueva contraseña y obtenerla en texto plano
          $nuevaContrasena = $user_objeto->generarContrasena();

          // Preparar la respuesta de éxito
          $response = array(
              'status' => 'success',
              'message' => 'Contraseña reestablecida con éxito.',
              'new_password' => $nuevaContrasena
          );

      } else {
          // El usuario NO existe, preparamos una respuesta de error específica
          $response = array(
              'status' => 'error',
              'message' => 'El usuario proporcionado, no está registrado en nuestro sistema.'
          );
      }

  } else {
      // Respuesta de error si el email está vacío
      $response = array(
          'status' => 'error',
          'message' => 'El no puede estar vacio no puede estar vacío.'
      );
  }

  // Establecer la cabecera y devolver la respuesta JSON
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}
?>