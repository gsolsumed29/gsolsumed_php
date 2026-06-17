<?php
header('Content-Type: application/json');

class PagosData {
    private $objeto_funciones;
    private $pago_objeto;
    private $pago_reg_data_objeto;
    
    public function __construct() {
        // Inicializar objetos necesarios
        $this->objeto_funciones = new FuncionesData();
        $this->pago_objeto = new PagoData();
        $this->pago_reg_data_objeto = new PagoRegData();
    }
    
    public function procesarPago($pagoData) {
        try {
            // Validar referencia de banco si aplica
            if ($pagoData['ref_ban'] != '0') {
                $this->validarReferenciaBanco($pagoData['ref_ban']);
            }
            
            // Registrar el pago principal
            $this->registrarPagoPrincipal($pagoData);
            
            // Registrar los datos adicionales del pago
            $this->registrarDatosPago($pagoData);
            
            // Enviar correo electrónico
            $this->enviarCorreoConfirmacion($pagoData);
            
            // Manejar archivo adjunto si existe
            if (!empty($pagoData['archivo'])) {
                $this->guardarArchivoAdjunto($pagoData);
            }
            
            return ['success' => true, 'message' => 'Pago procesado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    private function validarReferenciaBanco($ref_ban) {
        $data = $this->objeto_funciones->foundValor('jm_reportar_pago_reg', 'ref_ban', $ref_ban, 'FuncionesData');
        if (!empty($data[0]->id)) {
            throw new Exception('La referencia de banco ya existe');
        }
        
        $data = $this->objeto_funciones->foundValor('reng_tip', 'num_doc', $ref_ban, 'FuncionesData');
        if (!empty($data[0]->id)) {
            throw new Exception('La referencia de banco ya existe en reng_tip');
        }
    }
    
    private function registrarPagoPrincipal($pagoData) {
        $this->pago_objeto->co_cli = $pagoData['co_cli'];
        $this->pago_objeto->fec_emis = $pagoData['fec_emis'];
        $this->pago_objeto->monto_cob = $pagoData['monto_cob'];
        $this->pago_objeto->nro_docs_grup = $pagoData['facturas'];
        $this->pago_objeto->add();
    }
    
    private function registrarDatosPago($pagoData) {
        $this->pago_reg_data_objeto->dato1 = $pagoData['facturas'];
        $this->pago_reg_data_objeto->forma_pag = $pagoData['forma_pag'];
        $this->pago_reg_data_objeto->cod_ban = $pagoData['co_ban'];
        $this->pago_reg_data_objeto->co_cuenta = $pagoData['co_cuenta'];
        $this->pago_reg_data_objeto->ref_ban = $pagoData['ref_ban'];
        $this->pago_reg_data_objeto->fec_tran = $pagoData['fec_emis'];
        $this->pago_reg_data_objeto->cod_caja = $pagoData['co_caja'];
        $this->pago_reg_data_objeto->monto = $pagoData['monto_cob'];
        $this->pago_reg_data_objeto->monto_bs = $pagoData['monto_cob_bs'];
        $this->pago_reg_data_objeto->forma_pag = $pagoData['forma_pag'];
        $this->pago_reg_data_objeto->tipo_moneda = $pagoData['moneda'];
        
        $this->pago_reg_data_objeto->add();
    }
    
    private function enviarCorreoConfirmacion($pagoData) {
        $mensaje = $this->construirMensajeCorreo($pagoData);
        
        // Descomentar cuando esté listo el sistema de correo
        /*
        $objeto_empresa = new EmpresaData();
        $data = $objeto_empresa->getAllDatosCorreo();
        
        $enviar_objeto = new EnviarData();
        $enviar_objeto->Host = $data[0]->host;
        $enviar_objeto->Port = $data[0]->port;
        $enviar_objeto->Username = $data[0]->email;
        $enviar_objeto->Password = $data[0]->password;
        $enviar_objeto->From = $data[0]->email;
        $enviar_objeto->FromName = $data[0]->email;
        $enviar_objeto->To = $data[0]->email_cobros;
        $enviar_objeto->Text = $mensaje;
        $enviar_objeto->Subject = 'Referencia de pago';
        
        if (!empty($pagoData['archivo'])) {
            $enviar_objeto->AddAttachment = $this->getRutaArchivo($pagoData);
        }
        
        $enviar_objeto->sedEmailCobros();
        */
    }
    
    private function construirMensajeCorreo($pagoData) {
        $mensaje = '<div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
        <table style="background-color:#f6f6f6;width:100%">
            <tbody><tr><td>&nbsp;</td><td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                <table cellpadding="0" cellspacing="0" style="background:#fff;border:1px solid #e9e9e9;border-radius:3px" width="100%">
                    <tbody><tr><td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9"><img alt="Mostrar Logo" src="https://lh3.googleusercontent.com/d/1i3E3zi5X7FnSu743Ng13DZ5ctNfUq1-d" style="max-height:65px" class="CToWUd" data-bit="iit">
                        <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto"><span style="font-size:14px"><span style="color:#66cccc">COMPROBANTE DE PAGO</span></span></div>
                        </td></tr><tr><td style="vertical-align:top;padding:25px">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr><td style="vertical-align:top;padding:0px">Estimado(a)&nbsp;<strong>'.$pagoData['cli_des'].',</strong></td></tr><tr><td style="vertical-align:top;padding:0 0 10px">
                                <p><span style="font-size:12px">Por medio de la presente le enviamos un recibo de pago de la(s)&nbsp;factura(s)&nbsp;<strong>('.$pagoData['facturas'].')</strong>&nbsp;<wbr>registrado&nbsp;el&nbsp;<strong>'.$pagoData['fec_emis'].'</strong></span></p>
        
                                <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> $ '.$pagoData['monto_cob'].'.</span></p>';
        
        $mensaje .= '<p style="line-height:8px"><span style="font-size:12px"><strong>Comprobante de pago generado por: </strong> '.$pagoData['ven_des'].'.</span></p>';
        
        if ($pagoData['caja_des'] == 'no') {
            $mensaje .= '<p style="line-height:8px"><span style="font-size:12px"><strong>Banco:</strong>  '.$pagoData['banco_des'].'.</span></p>';
            $mensaje .= '<p style="line-height:8px"><span style="font-size:12px"><strong>Cuenta:</strong>  '.$pagoData['cuenta_des'].'.</span></p>';
        } else {
            $mensaje .= '<p style="line-height:8px"><span style="font-size:12px"><strong>Caja numero :</strong> '.$pagoData['caja_des'].'.</span></p>'; 
        }
        
        $mensaje .= '<p style="line-height:8px"><span style="font-size:12px"><strong>Total pagado:</strong> $ '.$pagoData['monto_cob'].'.</span></p>';                
        $mensaje .= '<p><span style="font-size:12px"></span></p>';
        
        // Cierre del HTML
        $mensaje .= '</td></tr><tr><td style="vertical-align:top;padding:0 0 20px;text-align:center">&nbsp;</td></tr>';
        $mensaje .= '</tbody></table></td></tr></tbody></table></div></td><td>&nbsp;</td></tr></tbody></table></div>';
        
        return $mensaje;
    }
    
    private function guardarArchivoAdjunto($pagoData) {
        $nombreArchivo = $pagoData['co_cli'].'-'.uniqid().'.jpeg';
        $rutaArchivo = "../admin/storage/archivos/cobros/".$nombreArchivo;
        
        // Guardar el archivo desde los datos base64
        file_put_contents($rutaArchivo, base64_decode($pagoData['archivo']['datos']));
        
        return $rutaArchivo;
    }
}

// Procesamiento principal
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

    $procesador = new PagoProcessor();
    $resultados = [];
    
    foreach ($pagos as $pago) {
        $resultados[] = $procesador->procesarPago($pago);
    }

    // Verificar si hubo errores
    $errores = array_filter($resultados, function($r) { return !$r['success']; });
    
    if (!empty($errores)) {
        $mensajesError = array_map(function($e) { return $e['message']; }, $errores);
        throw new Exception("Algunos pagos no se procesaron: " . implode(", ", $mensajesError));
    }

    echo json_encode([
        'success' => true,
        'message' => 'Todos los pagos se procesaron correctamente',
        'total' => count($pagos)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>