<?php
 $tipo = $_GET['tipo']; // 1 para lecciones
 $accion = $_GET['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_GET['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
      if($datos==1){          
        header('Content-Type: application/json');
        try {
            // Validar que se recibieron todos los datos necesarios
            $required_params = ['co_cli', 'fec_emis', 'monto_cob', 'cli_des', 'monto_cob_bs', 'ven_des', 
                               'forma_pag', 'co_ban', 'co_cuenta', 'co_caja', 'moneda', 'observacion',
                               'banco_des', 'cuenta_des', 'caja_des', 'moneda_des'];
            
            foreach ($required_params as $param) {
                if (!isset($_GET[$param])) {
                    throw new Exception("Parámetro requerido faltante: $param");
                }
            }
    
            // Validar archivo adjunto
            if (!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                throw new Exception("Debe adjuntar un comprobante de pago válido");
            }
    
            // Obtener datos del GET
            $ref_ban = $_GET['ref_ban'] ?? '0';        
            $caja_des = $_GET['caja_des'];
            $moneda_des = $_GET['moneda_des'];
            $banco_des = $_GET['banco_des'];
            $cuenta_des = $_GET['cuenta_des'];
            $co_cli = $_GET['co_cli'];
            $cli_des = $_GET['cli_des'];
            $fec_emis = $_GET['fec_emis'];
            $monto_cob = $_GET['monto_cob'];
            $monto_cob_bs = $_GET['monto_cob_bs'];
            $ven_des = $_GET['ven_des'];
            $forma_pag = $_GET['forma_pag'];            
            $co_ban = $_GET['co_ban'];
            $co_cuenta = $_GET['co_cuenta'];
            $co_caja = $_GET['co_caja'];            
            $tipo_moneda = $_GET['moneda'];      
            $observacion = $_GET['observacion'];
    
            // Validar referencia bancaria (excepto para efectivo con ref_ban = 0)
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
    
            // Registrar el pago
            $pago_objeto = new PagoData(); 
            $pago_objeto->co_cli = $co_cli;
            $pago_objeto->fec_emis = $fec_emis;
            $pago_objeto->datoExtra = $observacion;
            $pago_objeto->monto_cob = $monto_cob; 
             $pago_objeto->addAdelanto();
    
            // Registrar el pago en el sistema
            $pago_reg_data_objeto = New PagoRegData();	
            $pago_reg_data_objeto->dato1 = $co_cli;		
            $pago_reg_data_objeto->forma_pag = $forma_pag;
            $pago_reg_data_objeto->cod_ban = $co_ban;      
            $pago_reg_data_objeto->co_cuenta = $co_cuenta;              
            $pago_reg_data_objeto->ref_ban = $ref_ban;
            $pago_reg_data_objeto->fec_tran = $fec_emis;
            $pago_reg_data_objeto->cod_caja = $co_caja;                
            $pago_reg_data_objeto->monto = $monto_cob;
            $pago_reg_data_objeto->forma_pag = $forma_pag;
            $pago_reg_data_objeto->tipo_moneda = $tipo_moneda;	
             $pago_reg_data_objeto->addAdelanto();  
    
            // Construir mensaje de correo
            $Menssage = '<div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                <table style="background-color:#f6f6f6;width:100%">
                    <tbody><tr><td>&nbsp;</td><td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                        <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                        <table cellpadding="0" cellspacing="0" style="background:#fff;border:1px solid #e9e9e9;border-radius:3px" width="100%">
                            <tbody><tr><td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9"><img alt="Mostrar Logo" src="https://lh3.googleusercontent.com/d/1i3E3zi5X7FnSu743Ng13DZ5ctNfUq1-d" style="max-height:65px" class="CToWUd" data-bit="iit">
                                <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto"><span style="font-size:14px"><span style="color:#66cccc">COMPROBANTE DE PAGO</span></span></div>
                                </td></tr><tr><td style="vertical-align:top;padding:25px">
                                <table cellpadding="0" cellspacing="0" width="100%">
                                    <tbody><tr><td style="vertical-align:top;padding:0px">Estimado(a) &nbsp;<strong> '.$cli_des.',</strong></td></tr><tr><td style="vertical-align:top;padding:0 0 10px">
                                        <p><span style="font-size:12px">Por medio de la presente le enviamos un recibo de pago por concepto de ADELANTO &nbsp;<wbr>registrado&nbsp;el&nbsp;<strong>'.$fec_emis.'</strong></span></p>
                                        <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> $ '.number_format($monto_cob, 2, ',', '.').'.</span></p> 
                                        <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> BS.D '.number_format($monto_cob_bs, 2, ',', '.').'.</span></p>';  
                                                    
                                        if($caja_des=='no'){
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Banco:</strong>  '.$banco_des.'.</span></p>';
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Cuenta:</strong>  '.$cuenta_des.'.</span></p>';
                                        } else {
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Caja numero :</strong> '.$caja_des.'.</span></p>'; 
                                        }
                                        
                                        $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Comprobante de pago generado por: </strong> '.$ven_des.'.</span></p>';           
                                        $Menssage.='<p><span style="font-size:12px">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: 0416-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</span></p>';              
                                        $Menssage.='</td></tr><tr><td style="vertical-align:top;padding:0 0 20px;text-align:center">&nbsp;</td></tr>';
                                        $Menssage.='</tbody>';
                                        $Menssage.='</table>';
                                        $Menssage.='</td></tr>';
                                        $Menssage.='</tbody>';
                                        $Menssage.='</table>';
                                        $Menssage.='</div>';
                                        $Menssage.='</td><td>&nbsp;</td></tr>';
                                        $Menssage.='</tbody>';
                                        $Menssage.='</table>';
                                        $Menssage.='</div>';       
    
            // Guardar archivo adjunto
            $nombre = $co_cli.'-'.$co_cli.'-'.$fec_emis.'-'.$monto_cob;
            $directorioBase = '../admin/storage/archivos/cobros/';
            
            // Crear directorio si no existe
            if (!file_exists($directorioBase)) {
                if (!mkdir($directorioBase, 0777, true)) {
                    throw new Exception("Error al crear directorio: " . $directorioBase);
                }
                chmod($directorioBase, 0777);
            }
            
            $archivo = $directorioBase . $nombre . $_FILES['file']['name'];
            
            if (!move_uploaded_file($_FILES["file"]["tmp_name"], $archivo)) {
                throw new Exception("Error al guardar el archivo adjunto");
            }
            
            rename($archivo, $directorioBase . $co_cli . ".JPEG");
            $archivo = $directorioBase . $co_cli . ".JPEG";
    
            // Configurar y enviar correo
            $objeto_empresa = New EmpresaData();
            $data = $objeto_empresa->getAllDatosCorreo();
            
            if (empty($data)) {
                throw new Exception("No se encontraron configuraciones de correo");
            }
            
            $Username = $data[0]->email;
            $Password = $data[0]->password;
            $Port = $data[0]->port;
            $Host = $data[0]->host;
            $From = $data[0]->email;
            $FromName = $data[0]->email;
            $Subject = $data[0]->email; 
            $Text = $data[0]->text; 
            $email_cobros = $data[0]->email_cobros; 
            $AddAttachment = $archivo;
    
            $enviar_objeto = new EnviarData();
            $enviar_objeto->Host = $Host;
            $enviar_objeto->Port = $Port;
            $enviar_objeto->Username = $Username;
            $enviar_objeto->Password = $Password;
            $enviar_objeto->From = $From;
            $enviar_objeto->FromName = $FromName;
            $enviar_objeto->To = $email_cobros;
            $enviar_objeto->Text = $Menssage . $Text;
            $enviar_objeto->Subject = 'Referencia de adelanto';
            $enviar_objeto->AddAttachment = $AddAttachment;


            $enviar_objeto->procesarArchivosCorreoAdelantos($enviar_objeto);
        /*    if (!$enviar_objeto->sedEmailCobros()) {
                throw new Exception("Error al enviar el correo electrónico");
            }*/
            
            // Eliminar archivo temporal
            unlink($archivo);
            
            // Respuesta exitosa
           echo json_encode([
                'success' => true,
                'message' => 'Adelanto procesado correctamente y correo enviado'
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
    
    if($accion ==3){
      if($datos==1){
              // eliminar fisicamente al usaurio
              $id = $_GET['id']; // valor para sacar el id del usuario         
              $pago_objeto = new PagoData();           
              $pago_objeto->id =$id;
              $pago_objeto->delF();

              $pago_reg_data_objeto = New PagoRegData();
              $pago_reg_data_objeto->id=$id;
              $pago_reg_data_objeto->delF();

             echo "1";
          }          

      }
     
   
}
?>