<?php
if((isset($_GET['tipo']))  || (isset($_GET['accion'])) || (isset($_GET['datos']))){
 //29012026
  $tipo = $_GET['tipo'];
  $accion = $_GET['accion'];
  $datos = $_GET['datos']; 

}else{

  $tipo = $_POST['tipo'];
  $accion = $_POST['accion'];
  $datos = $_POST['datos']; 
}
if($tipo==1){    
    if($accion ==1){
        if($datos==1){         
            header('Content-Type: application/json');
  
            try {
                // Validar que se recibieron datos
                if (!isset($_POST['pagos'])) {
                    throw new Exception('No se recibieron datos de pagos');
                }
  
                // Decodificar los datos JSON
                $pagos = json_decode($_POST['pagos'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar los datos: ' . json_last_error_msg());
                }
  
                // Validar que hay pagos
                if (empty($pagos)) {
                    throw new Exception('No hay pagos para procesar');
                }
  
            
                // Procesar cada pago
                foreach ($pagos as $pago) {
  
                      $ref_ban=$pago['ref_ban'];
                  $objeto_funciones = new FuncionesData();
                    $data = $objeto_funciones->foundValor('jm_reportar_pago_reg','ref_ban',$ref_ban,'FuncionesData');
                    $bandera = $data[0]->id;
                    if($bandera>=1){
                        throw new Exception('La referencia bancaria '.$ref_ban.' ya fue cargada para su revisión anteriormente.');
                    }else{
                        $data = $objeto_funciones->foundValor('reng_tip','num_doc',$ref_ban,'FuncionesData');
                      $bandera2 = $data[0]->id;
                      if($bandera2>=1){
                        throw new Exception('La referencia bancaria '.$ref_ban.' ya fue conciliada y registrada en profit anteriormente.');
                      }else{
  
  
                      
                        $id=$pago['id'];
                        $co_cli=$pago['co_cli'];
                        $fec_emis=$pago['fec_emis'];
                        $cli_des=$pago['cli_des'];
                        $monto_cob=$pago['monto_cob'];
                        $monto_cob_bs=$pago['monto_cob_bs'];
                        $facturas=$pago['facturas'];
                        $forma_pag=$pago['forma_pag'];
                        $co_ban=$pago['co_ban'];
                        $co_cuenta=$pago['co_cuenta'];
                        $co_caja=$pago['co_caja'];
                       
                        $ven_des=$pago['ven_des'];
                        $facturas_saldo=$pago['facturas_saldo'];
                        $facturas_saldo_bs=$pago['facturas_saldo_bs'];
                        $moneda=$pago['moneda'];
                        $observacion=$pago['observacion'];
                        $banco_des=$pago['banco_des'];
                        $cuenta_des=$pago['cuenta_des'];
                        $caja_des=$pago['caja_des'];
                        $moneda_des=$pago['moneda_des'];
                        $fecha_registro=$pago['fecha_registro'];
                          $tipo_moneda=0;
  
          
  
                    $pago_objeto = new PagoData();                
                    $pago_objeto->co_cli =$co_cli;
                    $pago_objeto->fec_emis =$fec_emis;
                    $pago_objeto->monto_cob =$monto_cob;
                    $pago_objeto->nro_docs_grup =$facturas;
                    $pago_objeto->observacion =$facturas;
                  $pago_objeto->add();
  
                    $pago_reg_data_objeto = New PagoRegData();
  
                    $pago_reg_data_objeto->dato1= $facturas;		
                    $pago_reg_data_objeto->forma_pag =$forma_pag;
                    $pago_reg_data_objeto->cod_ban =$co_ban;   
                    $pago_reg_data_objeto->co_cuenta =$co_cuenta;              
                    $pago_reg_data_objeto->ref_ban =$ref_ban;
                    $pago_reg_data_objeto->fec_tran =$fec_emis;
                    $pago_reg_data_objeto->cod_caja =$co_caja;                
                    $pago_reg_data_objeto->monto =$monto_cob;
                    $pago_reg_data_objeto->monto_bs =$monto_cob_bs;
                    $pago_reg_data_objeto->forma_pag =$forma_pag;
                    $pago_reg_data_objeto->tipo_moneda= $tipo_moneda;	
                    $pago_reg_data_objeto->add();
                     
                      }
                    }
                  
                    // 2. Guardar archivo adjunto (si existe)
             
                    // 3. Enviar correo electrónico
                   // $this->enviarCorreoPago(=$pago);
                }
  
                 
                            $cliente = $pagos[0]['cli_des']; // Asumimos que todos los pagos son del mismo cliente
                $html = '
              <div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                  <table style="background-color:#f6f6f6;width:100%">
                      <tbody>
                          <tr>
                              <td>&nbsp;</td>
                              <td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                                  <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                                      <table cellpadding="0" cellspacing="0" style="background:#fff;border:0px solid #e9e9e9;border-radius:3px" width="100%">
                                          <tbody>
                                              <tr>
                                                  <td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9">
                                                      <img alt="Mostrar Logo" src="https://lh3.googleusercontent.com/d/1i3E3zi5X7FnSu743Ng13DZ5ctNfUq1-d" style="max-height:65px" class="CToWUd" data-bit="iit">
                                                      <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto">
                                                          <span style="font-size:14px"><span style="color:#66cccc">Reporte de pago(s)</span></span>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td style="vertical-align:top;padding:25px">
                                                      <table cellpadding="0" cellspacing="0" width="100%">
                                                          <tbody>
                                                              <tr>
                                                                  <td style="vertical-align:top;padding:0px">
                                                                      Estimado(a) <strong>'.$cliente.',</strong>
                                                                  </td>
                                                              </tr>
                                                              <tr>
                                                                  <td style="vertical-align:top;padding:0 0 10px">
                                                                      <p><span style="font-size:12px">Se han registrado los siguientes pagos:</span></p>
                                                                      
                                                                      <table style="width:100%;border-collapse:collapse;margin:15px 0;font-size:12px">
                                                                          <thead>
                                                                              <tr style="background-color:#f2f2f2">
                                                                                  <th style="padding:8px;border:1px solid #ddd;text-align:left">Factura</th>
                                                                                  <th style="padding:8px;border:1px solid #ddd;text-align:left">Fecha</th>
                                                                                  <th style="padding:8px;border:1px solid #ddd;text-align:right">Monto $</th>
                                                                                     <th style="padding:8px;border:1px solid #ddd;text-align:right">Monto BS.D</th>
                                                                                  <th style="padding:8px;border:1px solid #ddd;text-align:left">Método</th>
                                                                                  <th style="padding:8px;border:1px solid #ddd;text-align:left">Registrado por</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody>';
  
              $total = 0;
              foreach ($pagos as $pago) {
                  $html .= '
                                                                              <tr>
                                                                                  <td style="padding:8px;border:1px solid #ddd">'.$pago['facturas'].'</td>
                                                                                  <td style="padding:8px;border:1px solid #ddd">'.$pago['fec_emis'].'</td>
                                                                                  <td style="padding:8px;border:1px solid #ddd;text-align:right">USD $ '.number_format($pago['monto_cob'], 2, ',', '.').'</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd;text-align:right">BS.D '.number_format($pago['monto_cob_bs'], 2, ',', '.').'</td>
                                                                                  <td style="padding:8px;border:1px solid #ddd">'.$pago['forma_pag'].'</td>
                                                                                  <td style="padding:8px;border:1px solid #ddd">'.$pago['ven_des'].'</td>
                                                                              </tr>';
                  
                  // Detalles del método de pago
                  $html .= '
                                                                              <tr>
                                                                                  <td colspan="6" style="padding:8px;border:1px solid #ddd;background-color:#f9f9f9">';
                  
                  if ($pago['forma_pag'] == 'DEP' || $pago['forma_pag'] == 'CH') {
                      $html .= '
                                                                                      <strong>Detalles bancarios:</strong>&nbsp;
                                                                                      Banco: '.$pago['banco_des'].'&nbsp;
                                                                                      Cuenta: '.$pago['cuenta_des'].'&nbsp;
                                                                                      Referencia: '.$pago['ref_ban'].'&nbsp;
                                                                                      Fecha: '.$pago['fec_emis'];
                  } elseif ($pago['forma_pag'] == 'EF') {
                      $html .= '
                                                                                      <strong>Detalles de pago en efectivo:</strong>&nbsp;
                                                                                      Caja: '.$pago['caja_des'];
                  }
                  
                  $html .= '
                                                                                  </td>
                                                                              </tr>';
                  
                  
                  $total += $pago['monto_cob'];
              }
  
              $html .= '
                                                                              <tr style="font-weight:bold">
                                                                                  <td colspan="2" style="padding:8px;border:1px solid #ddd;text-align:right">Total:</td>
                                                                                  <td style="padding:8px;border:1px solid #ddd;text-align:right">$ '.number_format($total, 2, ',', '.').'</td>
                                                                                  <td colspan="2" style="padding:8px;border:1px solid #ddd"></td>
                                                                              </tr>
                                                                          </tbody>
                                                                      </table>
                                                                      
                                                                      <p><span style="font-size:12px">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: (0251)-7170029 (0416)-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</span></p>
                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
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
                      // email_cobros  Host Port Username Password From FromName To Subject AddAttachment   
                               
                      $nivel_vendedor = $_SESSION['nivel'];
                      $co_ven =  $_SESSION['identidad'];                    
                      $correo_cliente = $_SESSION['bio'];
                //   echo  $correo_cliente;
                     // $Password = 'dfoovmfbmqcwuryp';
                      $enviar_objeto = new EnviarData();
                      $enviar_objeto->Host= $Host;
                      $enviar_objeto->Port= $Port;
                      $enviar_objeto->Username= $Username;
                      $enviar_objeto->Password= $Password;
                      $enviar_objeto->From= $Username;
                      $enviar_objeto->FromName= $Username;
                      $enviar_objeto->To= $email_cobros;
                      $enviar_objeto->To_2= $correo_cliente;
                    $enviar_objeto->Text=   $html ;
                    $enviar_objeto->Subject='Referencia de pago';
  
                    $archivosAdjuntos = [];
                    $directorioBase = '../admin/storage/archivos/cobros/';
                    
                    foreach ($pagos as $pago) {
                        // Validar que existan los datos del archivo
                        if (empty($pago['archivo']) || empty($pago['archivo']['datos']) || empty($pago['archivo']['nombre'])) {
                            error_log("Archivo incompleto en el pago");
                            continue;
                        }
                    
                        // Crear directorio si no existe
                        if (!file_exists($directorioBase)) {
                            if (!mkdir($directorioBase, 0777, true)) {
                                error_log("Error al crear directorio: " . $directorioBase);
                                continue;
                            }
                            chmod($directorioBase, 0777);
                        }
                    
                        // Limpiar y verificar Base64
                        $datosBase64 = trim($pago['archivo']['datos']);
                        
                        // Remover prefijo "data:..." si existe
                        if (strpos($datosBase64, 'data:') === 0) {
                            $datosBase64 = substr($datosBase64, strpos($datosBase64, ',') + 1);
                        }
                    
                        // Decodificar
                        $datosDecodificados = base64_decode($datosBase64, true);
                        if ($datosDecodificados === false) {
                            error_log("Base64 inválido para: " . $pago['archivo']['nombre']);
                            continue;
                        }
                    
                        // Generar nombre único con extensión
                        $extension = pathinfo($pago['archivo']['nombre'], PATHINFO_EXTENSION);
                        $nombreArchivo = uniqid() . ($extension ? '.' . $extension : '');
                        $rutaCompleta = $directorioBase . $nombreArchivo;
                    
                        // Guardar archivo
                        if (file_put_contents($rutaCompleta, $datosDecodificados)) {
                            $archivosAdjuntos[] = $rutaCompleta;
                        } else {
                            error_log("Error al guardar: " . $rutaCompleta);
                        }
                    }
                    
                  
                 // 2. Procesar archivos adjuntos (adjuntar, enviar y eliminar)
                      $enviar_objeto->procesarArchivosCorreoClientes($archivosAdjuntos, $directorioBase, $enviar_objeto);
                  
                    
                // Respuesta exitosa
               echo json_encode([
                    'success' => true,
                    'message' => 'Pagos procesados correctamente',
                    'total' => count($pagos)
                ]);
  
            } catch (Exception $e) {
                // Respuesta de error
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
        if($datos==2){         
           header('Content-Type: application/json');
              try {
                  // Validar que se recibieron datos
                  if (!isset($_POST['pagos'])) {
                      throw new Exception('No se recibieron datos de pagos');
                  }
  
                  // Decodificar los datos JSON
                  $pagos = json_decode($_POST['pagos'], true);
                  if (json_last_error() !== JSON_ERROR_NONE) {
                      throw new Exception('Error al decodificar los datos: ' . json_last_error_msg());
                  }
  
                  // Validar que hay pagos
                  if (empty($pagos)) {
                      throw new Exception('No hay pagos para procesar');
                  }
  
                  // Decodificar retenciones si existen
                  $retenciones = [];
                  if (isset($_POST['retenciones'])) {
                      $retenciones = json_decode($_POST['retenciones'], true);
                      if (json_last_error() !== JSON_ERROR_NONE) {
                          throw new Exception('Error al decodificar las retenciones: ' . json_last_error_msg());
                      }
                  }
                  
                  $ven_des = '';
                  
                  // Función helper para codificar HTML
                  function safeHtml($value) {
                          // Primero decodificar entidades HTML, luego aplicar htmlspecialchars
                          $decoded = html_entity_decode($value ?? '', ENT_QUOTES, 'UTF-8');
                          return htmlspecialchars($decoded, ENT_QUOTES, 'UTF-8');
                      }
  
                  // Procesar cada pago
                  foreach ($pagos as $pago) {
                      $ref_ban = $pago['ref_ban']; 
                      $forma_pag = $pago['forma_pag'];      
                      
                      // Omitir validaciones de referencia para pagos en efectivo con ref_ban = 0
                      if (!($forma_pag == 'EF' && $ref_ban == '0')) {
                          $objeto_funciones = new FuncionesData();
                          $data = $objeto_funciones->foundValor('jm_reportar_pago_reg','ref_ban',$ref_ban,'FuncionesData');
                          $bandera = $data[0]->id;
                          
                          if($bandera>=1){
                              throw new Exception('La referencia bancaria '.$ref_ban.' ya fue cargada para su revisión anteriormente.');
                          } else {
                              $data = $objeto_funciones->foundValor('reng_tip','num_doc',$ref_ban,'FuncionesData');
                              $bandera2 = $data[0]->id;
                              
                              if($bandera2>=1){
                                  throw new Exception('La referencia bancaria '.$ref_ban.' ya fue conciliada y registrada en profit anteriormente.');
                              }
                          }
                      }
  
                      $id = $pago['id'];
                      $co_cli = $pago['co_cli'];
                      $fec_emis = $pago['fec_emis'];
                      $cli_des = safeHtml($pago['cli_des']); // CODIFICADO
                      $monto_cob = $pago['monto_cob'];
                      $monto_cob_bs = $pago['monto_cob_bs'];
                      $facturas = $pago['facturas'];
                      $forma_pag = $pago['forma_pag'];
                      $co_ban = $pago['co_ban'];
                      $co_cuenta = $pago['co_cuenta'];
                      $co_caja = $pago['co_caja'];
                      $ven_des = safeHtml($pago['ven_des']); // CODIFICADO
                      $facturas_saldo = $pago['facturas_saldo'];
                      $facturas_saldo_bs = $pago['facturas_saldo_bs'];
                      $moneda = $pago['moneda'];
                      $observacion = safeHtml($pago['observacion']); // CODIFICADO
                      $banco_des = safeHtml($pago['banco_des']); // CODIFICADO
                      $cuenta_des = safeHtml($pago['cuenta_des']); // CODIFICADO
                      $caja_des = safeHtml($pago['caja_des']); // CODIFICADO
                      $moneda_des = $pago['moneda_des'];
                      $fecha_registro = $pago['fecha_registro'];
                      $tipo_moneda = 0;
  
                      $objeto_cliente = New ClienteData();
                      $data = $objeto_cliente ->getAllDatosGrupos($co_cli);
  
                      $pago_objeto = new PagoData();                
                      $pago_objeto->co_cli = $co_cli;
                      $pago_objeto->fec_emis = $fec_emis;
                      $pago_objeto->monto_cob = $monto_cob;
                      $pago_objeto->nro_docs_grup = $facturas;
                      $pago_objeto->observacion = $facturas;
                      $pago_objeto->datoExtra = $observacion;
                      $pago_objeto->add();
  
                      $pago_reg_data_objeto = new PagoRegData();
                      $pago_reg_data_objeto->dato1 = $facturas;		
                      $pago_reg_data_objeto->forma_pag = $forma_pag;
                      $pago_reg_data_objeto->cod_ban = $co_ban;   
                      $pago_reg_data_objeto->co_cuenta = $co_cuenta;              
                      $pago_reg_data_objeto->ref_ban = $ref_ban;
                      $pago_reg_data_objeto->fec_tran = $fec_emis;
                      $pago_reg_data_objeto->cod_caja = $co_caja;                
                      $pago_reg_data_objeto->monto = $monto_cob;
                      $pago_reg_data_objeto->monto_bs = $monto_cob_bs;
                      $pago_reg_data_objeto->forma_pag = $forma_pag;
                      $pago_reg_data_objeto->tipo_moneda = $tipo_moneda;	
                      $pago_reg_data_objeto->add();
                  }
  
                  // Generar HTML para el correo
                  $grupo = safeHtml($data[0]->nombre_matriz); // CODIFICADO
                  $cliente = safeHtml($pagos[0]['cli_des']); // CODIFICADO
  
                  // Preparar información del grupo si existe
                  $infoGrupo = '';
                  if (!$grupo=='*') {
                      $infoGrupo = '
                          <tr>
                              <td style="vertical-align:top;padding:5px 0">
                                  Grupo: <strong>'.$grupo.'</strong>
                              </td>
                          </tr>';
                  }
  
                  // Inicio de la tabla de retenciones (solo si hay retenciones)
                  $tablaRetenciones = '';
                  if (!empty($retenciones['retenciones'])) {
                      $tablaRetenciones = '
                      <tr>
                          <td colspan="6" style="padding:15px 0 5px;border-bottom:1px solid #ddd">
                              <h4 style="margin:0;color:#0343a5">Retenciones Aplicadas</h4>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="6">
                              <table style="width:100%;border-collapse:collapse;margin:10px 0;font-size:11px;background-color:#f9f9f9">
                                  <thead>
                                      <tr style="background-color:#e6e6e6">
                                          <th style="padding:6px;border:1px solid #ddd;text-align:left">Factura</th>
                                          <th style="padding:6px;border:1px solid #ddd;text-align:right">Monto BS</th>
                                          <th style="padding:6px;border:1px solid #ddd;text-align:left">Comprobante</th>
                                          <th style="padding:6px;border:1px solid #ddd;text-align:left">Fecha</th>
                                      </tr>
                                  </thead>
                                  <tbody>';
  
                      $totalRetenciones = 0;
                      foreach ($retenciones['retenciones'] as $retencion) {
                          $tablaRetenciones .= '
                                      <tr>
                                          <td style="padding:6px;border:1px solid #ddd">'.safeHtml($retencion['factura']).'</td>
                                          <td style="padding:6px;border:1px solid #ddd;text-align:right">'.number_format($retencion['montoBs'], 2, ',', '.').'</td>
                                          <td style="padding:6px;border:1px solid #ddd">'.safeHtml($retencion['numRetencion']).'</td>
                                          <td style="padding:6px;border:1px solid #ddd">'.safeHtml($retencion['fechaRetencion']).'</td>
                                      </tr>';
                          $totalRetenciones += $retencion['montoBs'];
                      }
  
                      $tablaRetenciones .= '
                                      <tr style="font-weight:bold">
                                          <td style="padding:6px;border:1px solid #ddd;text-align:right" colspan="3">Total Retenciones:</td>
                                          <td style="padding:6px;border:1px solid #ddd;text-align:right">'.number_format($totalRetenciones, 2, ',', '.').' BS</td>
                                      </tr>
                                  </tbody>
                              </table>
                          </td>
                      </tr>';
                  }
  
                  $html = '
                  <div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                      <table style="background-color:#F5F7FF;width:100%">
                          <tbody>
                              <tr>
                                  <td>&nbsp;</td>
                                  <td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                                      <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                                          <table cellpadding="0" cellspacing="0" style="background:#fff;border:0px solid #e9e9e9;border-radius:3px" width="100%">
                                              <tbody>
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
                                                                          Estimado(a) <strong>'.$cliente.',</strong> <br> Código : <strong>'.$co_cli .'</strong>
                                                                      </td>
                                                                  </tr>
                                                                  '.$infoGrupo.'
                                                                  <tr>
                                                                      <td style="vertical-align:top;padding:0 0 10px">
                                                                          <p><span style="font-size:12px">Notificación de Pago Pendiente de Procesar:</span></p>
                                                                          
                                                                          <table style="width:100%;border-collapse:collapse;margin:15px 0;font-size:12px">
                                                                              <thead>
                                                                                  <tr style="background-color:#f2f2f2">
                                                                                      <th style="padding:8px;border:1px solid #ddd;text-align:left">Factura(as)</th>
                                                                                      <th style="padding:8px;border:1px solid #ddd;text-align:left">Fecha</th>
                                                                                      <th style="padding:8px;border:1px solid #ddd;text-align:right">Monto $</th>
                                                                                      <th style="padding:8px;border:1px solid #ddd;text-align:right">Monto BS.D</th>
                                                                                      <th style="padding:8px;border:1px solid #ddd;text-align:left">Método</th>
                                                                                      <th style="padding:8px;border:1px solid #ddd;text-align:left">Registrado por</th>
                                                                                  </tr>
                                                                              </thead>
                                                                              <tbody>';
  
                  $total = 0;
                  foreach ($pagos as $pago) {
                      $html .= '
                                                                                  <tr>
                                                                                      <td style="padding:8px;border:1px solid #ddd">'.safeHtml($pago['facturas']).'</td>
                                                                                      <td style="padding:8px;border:1px solid #ddd">'.safeHtml($pago['fec_emis']).'</td>
                                                                                      <td style="padding:8px;border:1px solid #ddd;text-align:right">USD $ '.number_format($pago['monto_cob'], 2, ',', '.').'</td>
                                                                                      <td style="padding:8px;border:1px solid #ddd;text-align:right">BS.D '.number_format($pago['monto_cob_bs'], 2, ',', '.').'</td>
                                                                                      <td style="padding:8px;border:1px solid #ddd">'.safeHtml($pago['forma_pag']).'</td>
                                                                                      <td style="padding:8px;border:1px solid #ddd">'.safeHtml($pago['ven_des']).'</td>
                                                                                  </tr>';
                      
                      // Detalles del método de pago
                      $html .= '
                                                                                  <tr>
                                                                                      <td colspan="6" style="padding:8px;border:1px solid #ddd;background-color:#f9f9f9">';
                      
                      if ($pago['forma_pag'] == 'DEP' || $pago['forma_pag'] == 'CH') {
                          $html .= '
                                                                                              <strong>Detalles bancarios:</strong>&nbsp;
                                                                                              Banco: '.safeHtml($pago['banco_des']).'&nbsp;
                                                                                              Cuenta: '.safeHtml($pago['cuenta_des']).'&nbsp;
                                                                                              Referencia: '.safeHtml($pago['ref_ban']).'&nbsp;
                                                                                              Fecha: '.safeHtml($pago['fec_emis']);
                      } elseif ($pago['forma_pag'] == 'EF') {
                          $html .= '
                                                                                              <strong>Detalles de pago en efectivo:</strong>&nbsp;
                                                                                              Caja: '.safeHtml($pago['caja_des']);
                      }
                      
                      $html .= '
                                                                                      </td>
                                                                                  </tr>';
                      
                      $total += $pago['monto_cob'];
                  }
  
                  $html .= '
                                                                                  <tr style="font-weight:bold">
                                                                                      <td colspan="2" style="padding:8px;border:1px solid #ddd;text-align:right">Total:</td>
                                                                                      <td colspan="4" style="padding:8px;border:1px solid #ddd;text-align:right">$ '.number_format($total, 2, ',', '.').'</td>
                                                                                  </tr>';
  
                  // Agregar tabla de retenciones si existe
                  $html .= $tablaRetenciones;
  
                  $html .= '
                                                                                  <tr>
                                                                                      <td colspan="2" style="padding:8px;border:1px solid #ddd;text-align:right">Observaciones:</td>                                                                                   
                                                                                      <td colspan="4" style="padding:8px;border:1px solid #ddd">'.$observacion.'</td>
                                                                                  </tr>
                                                                              </tbody>
                                                                          </table>
                                                                          
                                                                          <p><span style="font-size:12px">Si tiene alguna duda o requiere información adicional sobre el estatus de su cuenta, le invitamos a contactar directamente a nuestro Dpto. de Crédito y Cobranza.Estamos a su disposición para asistirle y agilizar su trámite</span></p> 
                                                                          <p><span style="font-size:12px"> <b> 0424-5029821 - 0412-0782402 </b> </span></p> 
                                                                          <p><span style="font-size:12px"> <b> credito.cobranza@gruposolsumed.com  <></span></p> 
                                                                      </td>
                                                                  </tr>
                                                                 
                                                                 
                                                              </tbody>
                                                          </table>
                                                      </td>

                                                  </tr>
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
              
                  // Configurar envío de correo
                  $objeto_empresa = new EmpresaData();
                  $data = $objeto_empresa->getAllDatosCorreo();
                  $Username = $data[0]->email;
                  $Password = $data[0]->password;
                  $Port = $data[0]->port;
                  $Host = $data[0]->host;
                  $From = $data[0]->email;
                  $FromName = $data[0]->email;
                  $Subject = $data[0]->email; 
                  $Text = $data[0]->text; 
                  $email_cobros = $data[0]->email_cobros;               
                  
                  // CODIFICAR también el subject del email
               $Subject = html_entity_decode($ven_des, ENT_QUOTES, 'UTF-8') . '-' . 
                  $co_cli . '-' . 
                  html_entity_decode($cli_des, ENT_QUOTES, 'UTF-8') . '-' . 
                  $fecha_registro;
  
                               
                  $nivel_vendedor = $_SESSION['nivel'];
                  $co_ven =  $_SESSION['identidad'];                    
                  $correo_cliente = $_SESSION['bio'];
                    //   echo  $correo_cliente;
                 // $Password = 'dfoovmfbmqcwuryp';
                  $enviar_objeto = new EnviarData();
                  $enviar_objeto->Host= $Host;
                  $enviar_objeto->Port= $Port;
                  $enviar_objeto->Username= $Username;
                  $enviar_objeto->Password= $Password;
                  $enviar_objeto->From= $Username;
                  $enviar_objeto->FromName= $Username;
                  $enviar_objeto->To= $email_cobros;
                  $enviar_objeto->To_2= $correo_cliente;
                $enviar_objeto->Text=   $html ;
                $enviar_objeto->Subject='Informacion sobre tu pago';


                  // Procesar múltiples archivos adjuntos
                  $archivosAdjuntos = [];
                  $directorioBase = '../admin/storage/archivos/cobros/';
                  
                  // Crear directorio si no existe
                  if (!file_exists($directorioBase)) {
                      if (!mkdir($directorioBase, 0777, true)) {
                          throw new Exception("Error al crear directorio: " . $directorioBase);
                      }
                      chmod($directorioBase, 0777);
                  }
                  
                  // Procesar archivos de todos los pagos
                  foreach ($pagos as $pago) {
                      // Validar que existan archivos en el pago
                      if (empty($pago['archivos']) || !is_array($pago['archivos'])) {
                          error_log("No hay archivos en el pago o no es un array");
                          continue;
                      }
                      
                      // Procesar cada archivo del pago
                      foreach ($pago['archivos'] as $archivo) {
                          // Validar que existan los datos del archivo
                          if (empty($archivo['datos']) || empty($archivo['nombre'])) {
                              error_log("Archivo incompleto en el pago");
                              continue;
                          }
                      
                          // Limpiar y verificar Base64
                          $datosBase64 = trim($archivo['datos']);
                          
                          // Remover prefijo "data:..." si existe
                          if (strpos($datosBase64, 'data:') === 0) {
                              $datosBase64 = substr($datosBase64, strpos($datosBase64, ',') + 1);
                          }
                      
                          // Decodificar
                          $datosDecodificados = base64_decode($datosBase64, true);
                          if ($datosDecodificados === false) {
                              error_log("Base64 inválido para: " . $archivo['nombre']);
                              continue;
                          }
                      
                          // Generar nombre único con extensión
                          $extension = pathinfo($archivo['nombre'], PATHINFO_EXTENSION);
                          $nombreArchivo = uniqid() . ($extension ? '.' . $extension : '');
                          $rutaCompleta = $directorioBase . $nombreArchivo;
                      
                          // Guardar archivo
                          if (file_put_contents($rutaCompleta, $datosDecodificados)) {
                              $archivosAdjuntos[] = $rutaCompleta;
                          } else {
                              error_log("Error al guardar: " . $rutaCompleta);
                          }
                      }
                  }
                  
                  // Enviar correo con archivos adjuntos
                  $enviar_objeto->procesarArchivosCorreoClientes($archivosAdjuntos, $directorioBase, $enviar_objeto);
              /*    
                  // Respuesta exitosa
                  echo json_encode([
                      'success' => true,
                      'message' => 'Pagos procesados correctamente',
                      'total_pagos' => count($pagos),
                      'total_retenciones' => count($retenciones),
                      'total_archivos' => count($archivosAdjuntos)
                  ]);*/
  
              } catch (Exception $e) {
                  // Respuesta de error
              /*    echo json_encode([
                      'success' => false,
                      'message' => $e->getMessage()
                  ]);*/
              }
        }
        if ($datos==4) { // Nuevo código para retenciones sin depósito
            header('Content-Type: application/json');
            try {
                // Validar que se recibieron datos de retenciones
                if (!isset($_POST['retenciones'])) {
                    throw new Exception('No se recibieron datos de retenciones');
                }

                // Decodificar los datos JSON de retenciones
                $retenciones = json_decode($_POST['retenciones'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar las retenciones: ' . json_last_error_msg());
                }

                // Validar que hay retenciones
                if (empty($retenciones)) {
                    throw new Exception('No hay retenciones para procesar');
                }

                // Función helper para codificar HTML
                function safeHtml($value) {
                    $decoded = html_entity_decode($value ?? '', ENT_QUOTES, 'UTF-8');
                    return htmlspecialchars($decoded, ENT_QUOTES, 'UTF-8');
                }

                // Procesar cada retención
                foreach ($retenciones as $retencion) {
                    $factura_id = $retencion['factura_id'];
                    $numRetencion = $retencion['numRetencion'];
                    $montoBs = $retencion['montoBs'];
                    $tasaRetencion = $retencion['tasaRetencion'];
                    $fechaRetencion = $retencion['fechaRetencion'];
                    $co_cli = $retencion['co_cli'];
                    $cli_des = safeHtml($retencion['cli_des']);
                    $tipo_fiscal = $retencion['tipo_fiscal'];
                    $tasa_configurada = $retencion['tasa_configurada'];
                    $monto_base = $retencion['monto_base'];
                    $monto_maximo = $retencion['monto_maximo'];

                    // Validar datos básicos
                    if (empty($numRetencion) || empty($fechaRetencion) || $montoBs <= 0) {
                        throw new Exception('Datos incompletos en la retención para la factura: ' . $factura_id);
                    }

                /* // Verificar si ya existe una retención con el mismo número
                    $objeto_funciones = new FuncionesData();
                    $data = $objeto_funciones->foundValor('jm_retenciones_sin_deposito', 'num_retencion', $numRetencion, 'FuncionesData');
                    
                    if (!empty($data) && $data[0]->id >= 1) {
                        throw new Exception('El número de retención ' . $numRetencion . ' ya existe en el sistema.');
                    }*/

                    // Insertar la retención en la base de datos
                /* $retencion_objeto = new RetencionSinDepositoData();
                    $retencion_objeto->factura_id = $factura_id;
                    $retencion_objeto->num_retencion = $numRetencion;
                    $retencion_objeto->monto_bs = $montoBs;
                    $retencion_objeto->tasa_retencion = $tasaRetencion;
                    $retencion_objeto->fecha_retencion = $fechaRetencion;
                    $retencion_objeto->co_cli = $co_cli;
                    $retencion_objeto->cli_des = $cli_des;
                    $retencion_objeto->tipo_fiscal = $tipo_fiscal;
                    $retencion_objeto->tasa_configurada = $tasa_configurada;
                    $retencion_objeto->monto_base = $monto_base;
                    $retencion_objeto->monto_maximo = $monto_maximo;
                    $retencion_objeto->estatus = 'pendiente'; // pendiente, aprobada, rechazada
                    $retencion_objeto->fecha_registro = date('Y-m-d H:i:s');
                    $retencion_objeto->add();*/

                    // Aquí podrías agregar lógica adicional como:
                    // - Actualizar el saldo de la factura
                    // - Registrar en bitácora
                    // - Notificar al departamento contable
                }

                // Generar HTML para el correo de notificación
                $cliente = safeHtml($retenciones[0]['cli_des']);
                $co_cli = $retenciones[0]['co_cli'];
                $html = '
                <div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                    <table style="background-color:#F5F7FF;width:100%">
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                                    <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                                        <table cellpadding="0" cellspacing="0" style="background:#fff;border:0px solid #e9e9e9;border-radius:3px" width="100%">
                                            <tbody>
                                                
                                                <!-- ENCABEZADO (Tomado del ejemplo) -->
                                                <tr>
                                                    <td style="vertical-align:middle; padding:0; border-bottom:none; border-radius:0 0 3px 3px; text-align:center; background-color:#fff;">
                                                        <img alt="Mostrar Logo" src="https://drive.usercontent.google.com/download?id=12qJIWaFeyNvWSyNo8UdcoEivFhVNvjLa&authuser=0" style="width:100%; height:auto; max-width:100%; display:block; margin:0 auto;" class="CToWUd" data-bit="iit">
                                                    </td>
                                                </tr>

                                                <!-- CUERPO (Contenido original de Retenciones) -->
                                                <tr>
                                                    <td style="vertical-align:top;padding:25px">
                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px">
                                                                        Estimado(a) Departamento de Contabilidad, <br> 
                                                                        Se han registrado las siguientes retenciones sin depósito asociado:
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0 0 10px">
                                                                        <p><span style="font-size:12px">Cliente: <strong>' . $cliente . '</strong> (Código: ' . $co_cli . ')</span></p>
                                                                        
                                                                        <table style="width:100%;border-collapse:collapse;margin:15px 0;font-size:12px">
                                                                            <thead>
                                                                                <tr style="background-color:#f2f2f2">
                                                                                    <th style="padding:8px;border:1px solid #ddd;text-align:left">Factura</th>
                                                                                    <th style="padding:8px;border:1px solid #ddd;text-align:left">N° Retención</th>
                                                                                    <th style="padding:8px;border:1px solid #ddd;text-align:right">Monto BS</th>
                                                                                    <th style="padding:8px;border:1px solid #ddd;text-align:right">Tasa %</th>
                                                                                    <th style="padding:8px;border:1px solid #ddd;text-align:left">Fecha</th>
                                                                                    <th style="padding:8px;border:1px solid #ddd;text-align:left">Base Imponible</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>';

                $totalRetenciones = 0;
                foreach ($retenciones as $retencion) {
                    $html .= '
                                                                                <tr>
                                                                                    <td style="padding:8px;border:1px solid #ddd">' . safeHtml($retencion['factura']) . '</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd">' . safeHtml($retencion['numRetencion']) . '</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd;text-align:right">BS.D ' . number_format($retencion['montoBs'], 2, ',', '.') . '</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd;text-align:right">' . number_format($retencion['tasaRetencion'], 2, ',', '.') . '%</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd">' . safeHtml($retencion['fechaRetencion']) . '</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd;text-align:right">BS.D ' . number_format($retencion['monto_base'], 2, ',', '.') . '</td>
                                                                                </tr>';
                    $totalRetenciones += $retencion['montoBs'];
                }

                $html .= '
                                                                                <tr style="font-weight:bold">
                                                                                    <td colspan="2" style="padding:8px;border:1px solid #ddd;text-align:right">Total Retenciones:</td>
                                                                                    <td style="padding:8px;border:1px solid #ddd;text-align:right">BS.D ' . number_format($totalRetenciones, 2, ',', '.') . '</td>
                                                                                    <td colspan="3" style="padding:8px;border:1px solid #ddd"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        <p><span style="font-size:12px">Estas retenciones han sido registradas sin depósito asociado y requieren revisión del departamento contable.</span></p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <!-- PIE DE PÁGINA (Tomado del ejemplo) -->
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

                    


                // Configurar envío de correo
                $objeto_empresa = new EmpresaData();
                $data = $objeto_empresa->getAllDatosCorreo();
                $Username = $data[0]->email;
                $Password = $data[0]->password;
                $Port = $data[0]->port;
                $Host = $data[0]->host;
                $From = $data[0]->email;
                $FromName = $data[0]->email;
                $email_cobros = $data[0]->email_cobros;    

                $Subject = 'Retenciones sin Depósito - ' . $co_cli . ' - ' . $cliente . ' - ' . date('Y-m-d H:i:s');
              

                $nivel_vendedor = $_SESSION['nivel'];
                    
                if($nivel_vendedor==2){
                    $correo_vendedor = $_SESSION['bio'];
                    $Username = $correo_vendedor;
                    $Password = '#Grup0solsumed.2025#';
                }
                $enviar_objeto = new EnviarData();
                  $enviar_objeto->Host = $Host;
                  $enviar_objeto->Port = $Port;
                  $enviar_objeto->Username = $Username;
                  $enviar_objeto->Password = $Password;
                  $enviar_objeto->From = $Username;
                  $enviar_objeto->FromName = $Username;
                  $enviar_objeto->To = $email_cobros;
                  $enviar_objeto->Text = $html;
                  $enviar_objeto->Subject = $Subject;
  
                // Procesar archivos adjuntos de retenciones
                $archivosAdjuntos = [];
                $directorioBase = '../admin/storage/archivos/retenciones/';
                
                // Crear directorio si no existe
                if (!file_exists($directorioBase)) {
                    if (!mkdir($directorioBase, 0777, true)) {
                        throw new Exception("Error al crear directorio: " . $directorioBase);
                    }
                    chmod($directorioBase, 0777);
                }
               // print_r($_FILES['documento']);
                // Procesar archivos de retenciones
                if (isset($_FILES['documento'])) {
                    foreach ($_FILES['documento']['tmp_name'] as $index => $tmpName) {
                        if ($_FILES['documento']['error'][$index] === UPLOAD_ERR_OK) {
                            $nombreOriginal = $_FILES['documento']['name'][$index];
                            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                            $nombreArchivo = uniqid() . '_retencion.' . ($extension ?: 'pdf');
                            $rutaCompleta = $directorioBase . $nombreArchivo;
                            
                            if (move_uploaded_file($tmpName, $rutaCompleta)) {
                                $archivosAdjuntos[] = $rutaCompleta;
                                
                                // Opcional: Registrar la relación archivo-retención en BD
                            
                            /* $archivo_objeto = new ArchivoRetencionData();
                                $archivo_objeto->retencion_id = $retenciones[$index]['id'] ?? null;
                                $archivo_objeto->nombre_archivo = $nombreArchivo;
                                $archivo_objeto->ruta_archivo = $rutaCompleta;
                                $archivo_objeto->tipo_archivo = $_FILES['archivos_retenciones']['type'][$index];
                                $archivo_objeto->tamano_archivo = $_FILES['archivos_retenciones']['size'][$index];
                                $archivo_objeto->fecha_registro = date('Y-m-d H:i:s');
                                $archivo_objeto->add();*/
                            }
                        }
                    }
                }
                
                // Enviar correo con archivos adjuntos
              $enviar_objeto->procesarArchivosCorreo($archivosAdjuntos, $directorioBase, $enviar_objeto);

                // Respuesta exitosa
               echo json_encode([
                    'success' => true,
                    'message' => 'Retenciones procesadas correctamente',
                    'total_retenciones' => count($retenciones),
                    'total_archivos' => count($archivosAdjuntos)
                ]);

            } catch (Exception $e) {
                // Respuesta de error
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
      
      
}
          
            

      
     
    
    if($accion ==2){
        if($datos==1){
          
        }

     
    }
  
    if($accion ==3){
      if($datos==1){
         
              $fact_num = $_POST['fact_num']; // valor para sacar el id del usuario         
              $pedido_objeto = new PedidoData();
             
              $result2 = $pedido_objeto->GetRenglonPedido($fact_num);
              foreach($result2 as $dato){
                $co_art = $dato->co_art;               
                $cantidad=  $dato->dato2;

                $pedido_objeto->anularPedidoRenglon($co_art,$cantidad);
                $pedido_objeto->anularArt($co_art,$cantidad);
                
              }
              $pedido_objeto->fact_num =$fact_num;             
              $pedido_objeto->eliminarPedidoRenglon();  
              $pedido_objeto->eliminar();      
            
             echo "1";
          }

      if($datos==2){
         
            $id = $_POST['id']; 
             $monto = $_POST['monto'];// valor para sacar el id del usuario   
            //echo $id; 
            $pago_reg_data_objeto = New PagoRegData();
            $pago_reg_data_objeto->dato1= $id;	     
            $pago_reg_data_objeto->dato2= $monto;	           
            $pago_reg_data_objeto->delPagoRegF();       

           echo "1";
        }
          
          
        

    }


    if($accion ==4){
          if($datos==1){
             
                  $fact_num = $_POST['fact_num']; // valor para sacar el id del usuario         
                  $pedido_objeto = new PedidoData();
                
                  $result2 = $pedido_objeto->GetRenglonPedido($fact_num);
                  foreach($result2 as $dato){
                    $co_art = $dato->co_art;               
                    $cantidad=  $dato->dato2;

                    $pedido_objeto->anularPedidoRenglon($co_art,$cantidad);
                    $pedido_objeto->anularArt($co_art,$cantidad);
                    
                  }       
                  $pedido_objeto->fact_num =$fact_num;          
                  $pedido_objeto->anular();      
              echo "1";
              }
              
              
            
  
          }
    
   
   
    

    if($accion ==5){
      if($datos==1){
         
              $fact_num = $_POST['fact_num']; // valor para sacar el id del usuario         
              $pedido_objeto = new PedidoData();
             
              $result2 = $pedido_objeto->GetRenglonPedido($fact_num);
              foreach($result2 as $dato){
                $co_art = $dato->co_art;               
                $cantidad=  $dato->dato2;

                $pedido_objeto->anularPedidoRenglon($co_art,$cantidad);
                $pedido_objeto->anularArt($co_art,$cantidad);
                
              }
              $pedido_objeto->fact_num =$fact_num;             
              $pedido_objeto->eliminarPedidoRenglon();  
              $pedido_objeto->eliminar();      
            
             echo "1";
          }

          
          
        

    }


    

}


?>