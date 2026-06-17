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
if($tipo==1){    
    if($accion ==1){
        if($datos==1){          
          
          /*data:{co_cli:$co_cli,fec_emis:$fec_emis,monto_cob:$monto_cob,facturas:$facturas,forma_pag:$forma_pag,
            co_ban:$co_ban,co_caja:$co_caja,tipo:tipo,accion:accion,datos:datos},*/
                $ref_ban = $_GET['ref_ban'];        
                if($ref_ban !='0'){
                    $objeto_funciones = new FuncionesData();
                    $data = $objeto_funciones->foundValor('jm_reportar_pago_reg','ref_ban',$ref_ban,'FuncionesData');
                    $bandera = $data[0]->id;
                    if($bandera>=1){
                       echo "3";
                    }else{
                    $data = $objeto_funciones->foundValor('reng_tip','num_doc',$ref_ban,'FuncionesData');
                    $bandera2 = $data[0]->id;
                    if($bandera2>=1){
                       echo "3";
                    }else{
                  $caja_des =$_GET['caja_des'];
                  $moneda_des =$_GET['moneda_des'];
                  $banco_des =$_GET['banco_des'];
                  $cuenta_des =$_GET['cuenta_des'];
                  $ven_des= $_GET['ven_des'];
                  $co_cli = $_GET['co_cli'];
                  $cli_des = $_GET['cli_des'];
                  $fec_emis = $_GET['fec_emis'];
                  $monto_cob = $_GET['monto_cob'];
                  $monto_cob_bs = $_GET['monto_cob_bs'];
                  $facturas = $_GET['facturas'];                
                  $forma_pag = $_GET['forma_pag'];            
                  $co_ban = $_GET['co_ban'];
                  $co_cuenta = $_GET['co_cuenta'];
                  $co_caja = $_GET['co_caja'];            
                  $ref_ban = $_GET['ref_ban'];             
                  $tipo_moneda = $_GET['moneda'];   

                  $pago_objeto = new PagoData();                
                  $pago_objeto->co_cli =$co_cli;
                  $pago_objeto->fec_emis =$fec_emis;
                  $pago_objeto->monto_cob =$monto_cob;
                  $pago_objeto->nro_docs_grup =$facturas;
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

              

              
                  $Menssage  = '<div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                  <table style="background-color:#f6f6f6;width:100%">
                      <tbody><tr><td>&nbsp;</td><td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                          <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                          <table cellpadding="0" cellspacing="0" style="background:#fff;border:1px solid #e9e9e9;border-radius:3px" width="100%">
                              <tbody><tr><td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9"><img alt="Mostrar Logo" src="https://lh3.googleusercontent.com/d/1i3E3zi5X7FnSu743Ng13DZ5ctNfUq1-d" style="max-height:65px" class="CToWUd" data-bit="iit">
                                  <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto"><span style="font-size:14px"><span style="color:#66cccc">COMPROBANTE DE PAGO</span></span></div>
                                  </td></tr><tr><td style="vertical-align:top;padding:25px">
                                  <table cellpadding="0" cellspacing="0" width="100%">
                                      <tbody><tr><td style="vertical-align:top;padding:0px">Estimado(a)&nbsp;<strong>'.$cli_des.',</strong></td></tr><tr><td style="vertical-align:top;padding:0 0 10px">
                                          <p><span style="font-size:12px">Por medio de la presente le enviamos un recibo de pago de la(s)&nbsp;factura(s)&nbsp;<strong>('.$facturas.')</strong>&nbsp;<wbr>registrado&nbsp;el&nbsp;<strong>'.$fec_emis.'</strong></span></p>
                  
                                          <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> $ '.$monto_cob.'.</span></p> ';                                   
                                          $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Comprobante de pago generado por: </strong> '.$ven_des.'.</span></p>';
                                          if($caja_des=='no'){
                                            
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Banco:</strong>  '.$banco_des.'.</span></p>';
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Cuenta:</strong>  '.$cuenta_des.'.</span></p>';
                                                
                                          }else{
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Caja numero :</strong> '.$caja_des.'.</span></p>'; 
                                                                                  
                                          }
                                          $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Total pagado:</strong> $ '.$monto_cob.'.</span></p>';                
                                          $Menssage.=' <p><span style="font-size:12px">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: (0251)-7170029 (0416)-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</span></p>';
                  
                                          $Menssage.='';
                                          $Menssage.='</td></tr><tr><td style="vertical-align:top;padding:0 0 20px;text-align:center">&nbsp;</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.='</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.=' </div>';
                                          $Menssage.='</td><td>&nbsp;</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.='</div>';       

                $co_cli = $_GET['co_cli'];
                $fec_emis = $_GET['fec_emis'];
                $monto_cob = $_GET['monto_cob'];
                $nombre =  $co_cli.'-'. $co_cli.'-'.$fec_emis.'-'.$monto_cob ;

                if( empty($_FILES)){              
                  
                /*  $objeto_empresa = New EmpresaData();
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
                  $enviar_objeto->Host= $Host;
                  $enviar_objeto->Port= $Port;
                  $enviar_objeto->Username= $Username;
                  $enviar_objeto->Password= $Password;
                  $enviar_objeto->From= $From;
                  $enviar_objeto->FromName= $FromName;
                  $enviar_objeto->To= $email_cobros;
                  $enviar_objeto->Text=  $Menssage;
                  $enviar_objeto->Subject='Referencia de pago';            
                  $enviar_objeto->sedEmailCobros();*/
              
                  echo "1";
                }else{
                  $objeto_funciones = new FuncionesData();
                  $numero = $objeto_funciones->radomCodigo();
                  $bandera = $data[0]->id;
                  move_uploaded_file($_FILES["file"]["tmp_name"], "../admin/storage/archivos/cobros/".$nombre.$_FILES['file']['name']);
                  $archivo = "../admin/storage/archivos/cobros/".$nombre.$_FILES['file']['name'];
                  rename($archivo, "../admin/storage/archivos/cobros/".$co_cli."-".$numero.".jpeg");
                  $archivo ="../admin/storage/archivos/cobros/".$co_cli."-".$numero.".jpeg";
                  

                  /*$objeto_empresa = New EmpresaData();
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
                  $AddAttachment=$archivo;
                // email_cobros  Host Port Username Password From FromName To Subject AddAttachment
    
                  $enviar_objeto = new EnviarData();
                  $enviar_objeto->Host= $Host;
                  $enviar_objeto->Port= $Port;
                  $enviar_objeto->Username= $Username;
                  $enviar_objeto->Password= $Password;
                  $enviar_objeto->From= $From;
                  $enviar_objeto->FromName= $FromName;
                  $enviar_objeto->To= $email_cobros;
                  $enviar_objeto->Text=  $Menssage;
                  $enviar_objeto->Subject='Referencia de pago';
                  $enviar_objeto->AddAttachment=$AddAttachment;
                  $enviar_objeto->sedEmailCobros();*/
                //  unlink($archivo);
                  echo "1";
                }
                 }
                    }

               
      
                                     
                }else{
                  $caja_des =$_GET['caja_des'];
                  $moneda_des =$_GET['moneda_des'];
                  $banco_des =$_GET['banco_des'];
                  $cuenta_des =$_GET['cuenta_des'];
                  $ven_des= $_GET['ven_des'];
                  $co_cli = $_GET['co_cli'];
                  $cli_des = $_GET['cli_des'];
                  $fec_emis = $_GET['fec_emis'];
                  $monto_cob = $_GET['monto_cob'];
                  $monto_cob_bs = $_GET['monto_cob_bs'];
                  $facturas = $_GET['facturas'];                
                  $forma_pag = $_GET['forma_pag'];            
                  $co_ban = $_GET['co_ban'];
                  $co_cuenta = $_GET['co_cuenta'];
                  $co_caja = $_GET['co_caja'];            
                  $ref_ban = $_GET['ref_ban'];             
                  $tipo_moneda = $_GET['moneda'];   

                  $pago_objeto = new PagoData();                
                  $pago_objeto->co_cli =$co_cli;
                  $pago_objeto->fec_emis =$fec_emis;
                  $pago_objeto->monto_cob =$monto_cob;
                  $pago_objeto->nro_docs_grup =$facturas;
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

              

              
                  $Menssage  = '<div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                  <table style="background-color:#f6f6f6;width:100%">
                      <tbody><tr><td>&nbsp;</td><td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                          <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                          <table cellpadding="0" cellspacing="0" style="background:#fff;border:1px solid #e9e9e9;border-radius:3px" width="100%">
                              <tbody><tr><td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9"><img alt="Mostrar Logo" src="https://lh3.googleusercontent.com/d/1i3E3zi5X7FnSu743Ng13DZ5ctNfUq1-d" style="max-height:65px" class="CToWUd" data-bit="iit">
                                  <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto"><span style="font-size:14px"><span style="color:#66cccc">COMPROBANTE DE PAGO</span></span></div>
                                  </td></tr><tr><td style="vertical-align:top;padding:25px">
                                  <table cellpadding="0" cellspacing="0" width="100%">
                                      <tbody><tr><td style="vertical-align:top;padding:0px">Estimado(a)&nbsp;<strong>'.$cli_des.',</strong></td></tr><tr><td style="vertical-align:top;padding:0 0 10px">
                                          <p><span style="font-size:12px">Por medio de la presente le enviamos un recibo de pago de la(s)&nbsp;factura(s)&nbsp;<strong>('.$facturas.')</strong>&nbsp;<wbr>registrado&nbsp;el&nbsp;<strong>'.$fec_emis.'</strong></span></p>
                  
                                          <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> $ '.$monto_cob.'.</span></p> ';                                   
                                          $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Comprobante de pago generado por: </strong> '.$ven_des.'.</span></p>';
                                          if($caja_des=='no'){
                                            
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Banco:</strong>  '.$banco_des.'.</span></p>';
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Cuenta:</strong>  '.$cuenta_des.'.</span></p>';
                                                
                                          }else{
                                            $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Caja numero :</strong> '.$caja_des.'.</span></p>'; 
                                                                                  
                                          }
                                          $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Total pagado:</strong> $ '.$monto_cob.'.</span></p>';                
                                          $Menssage.=' <p><span style="font-size:12px">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: (0251)-7170029 (0416)-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</span></p>';
                  
                                          $Menssage.='';
                                          $Menssage.='</td></tr><tr><td style="vertical-align:top;padding:0 0 20px;text-align:center">&nbsp;</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.='</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.=' </div>';
                                          $Menssage.='</td><td>&nbsp;</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.='</div>';       

                $co_cli = $_GET['co_cli'];
                $fec_emis = $_GET['fec_emis'];
                $monto_cob = $_GET['monto_cob'];
                $nombre =  $co_cli.'-'. $co_cli.'-'.$fec_emis.'-'.$monto_cob ;

                if( empty($_FILES) ){              
                  
                /*  $objeto_empresa = New EmpresaData();
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
                  $enviar_objeto->Host= $Host;
                  $enviar_objeto->Port= $Port;
                  $enviar_objeto->Username= $Username;
                  $enviar_objeto->Password= $Password;
                  $enviar_objeto->From= $From;
                  $enviar_objeto->FromName= $FromName;
                  $enviar_objeto->To= $email_cobros;
                  $enviar_objeto->Text=  $Menssage;
                  $enviar_objeto->Subject='Referencia de pago';            
                  $enviar_objeto->sedEmailCobros();*/
              
                  echo "1";
                }else{
                  move_uploaded_file($_FILES["file"]["tmp_name"], "../admin/storage/archivos/cobros/".$nombre.$_FILES['file']['name']);
                  $archivo = "../admin/storage/archivos/cobros/".$nombre.$_FILES['file']['name'];
                  rename($archivo, "../admin/storage/archivos/cobros/".$co_cli.".jpeg");
                  $archivo ="../admin/storage/archivos/cobros/".$co_cli.".jpeg";

                  /*$objeto_empresa = New EmpresaData();
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
                  $AddAttachment=$archivo;
                // email_cobros  Host Port Username Password From FromName To Subject AddAttachment
    
                  $enviar_objeto = new EnviarData();
                  $enviar_objeto->Host= $Host;
                  $enviar_objeto->Port= $Port;
                  $enviar_objeto->Username= $Username;
                  $enviar_objeto->Password= $Password;
                  $enviar_objeto->From= $From;
                  $enviar_objeto->FromName= $FromName;
                  $enviar_objeto->To= $email_cobros;
                  $enviar_objeto->Text=  $Menssage;
                  $enviar_objeto->Subject='Referencia de pago';
                  $enviar_objeto->AddAttachment=$AddAttachment;
                  $enviar_objeto->sedEmailCobros();*/
                //  unlink($archivo);
                  echo "1";
                }


                }
      
        }

        if($datos==2){  
          
                  
                  $co_cli = $_POST['co_cli'];
                  $facturas = $_POST['fact_num'];           
                  $cli_des = $_POST['cli_des'];         
                  $monto_cob = $_POST['monto_cob']; 
                  $ven_des= $_POST['ven_des'];                  
                  

                /*  $Menssage  = '<div style="background-color:#f6f6f6;width:100%!important;height:100%;line-height:1.6;margin:0;padding:0;font-family:"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px">
                  <table style="background-color:#f6f6f6;width:100%">
                      <tbody><tr><td>&nbsp;</td><td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important" width="600">
                          <div style="max-width:600px;margin:0 auto;display:block;padding:20px">
                          <table cellpadding="0" cellspacing="0" style="background:#fff;border:1px solid #e9e9e9;border-radius:3px" width="100%">
                              <tbody><tr><td style="vertical-align:middle;font-size:16px;color:#fff;font-weight:500;padding:15px;border-radius:3px 3px 0 0;border-bottom:1px solid #e9e9e9"><img alt="Mostrar Logo" src="https://lh3.googleusercontent.com/d/1i3E3zi5X7FnSu743Ng13DZ5ctNfUq1-d" style="max-height:65px" class="CToWUd" data-bit="iit">
                                  <div style="width:auto;color:#348eda;font-weight:600;float:right;margin:10px auto"><span style="font-size:14px"><span style="color:#66cccc">Reporte de pago</span></span></div>
                                  </td></tr><tr><td style="vertical-align:top;padding:25px">
                                  <table cellpadding="0" cellspacing="0" width="100%">
                                      <tbody><tr><td style="vertical-align:top;padding:0px">Estimado(a)&nbsp;<strong>'.$cli_des.',</strong></td></tr><tr><td style="vertical-align:top;padding:0 0 10px">
                                          <p><span style="font-size:12px">Por medio de la presente le enviamos un recibo de pago de la(s)&nbsp;factura(s)&nbsp;<strong>'.$facturas.'</strong>&nbsp;<wbr>registrado&nbsp;el&nbsp;<strong>'.$fec_emis.'</strong></span></p>                  
                                          <p style="line-height:8px"><span style="font-size:12px"><strong>Cantidad:</strong> $ '.$monto_cob.'.</span></p> ';                                   
                                          $Menssage.='<p style="line-height:8px"><span style="font-size:12px"><strong>Comprobante de pago generado por: </strong> '.$ven_des.'.</span></p>';
                                          $Menssage.=' <p><span style="font-size:12px">Si posee alguna duda por favor contactar a nuestro número de servicio al cliente: (0251)-7170029 (0416)-9596537, de Lunes a Sábado de 8:00am a 9:00pm y domingos de 9:30am a 5:30pm.</span></p>';
                                          $Menssage.='';
                                          $Menssage.='</td></tr><tr><td style="vertical-align:top;padding:0 0 20px;text-align:center">&nbsp;</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.='</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.=' </div>';
                                          $Menssage.='</td><td>&nbsp;</td></tr>';
                                          $Menssage.='</tbody>';
                                          $Menssage.='</table>';
                                          $Menssage.='</div>';     
                                         // echo $Menssage;                    
                  
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
                  $enviar_objeto->Host= $Host;
                  $enviar_objeto->Port= $Port;
                  $enviar_objeto->Username= $Username;
                  $enviar_objeto->Password= $Password;
                  $enviar_objeto->From= $From;
                  $enviar_objeto->FromName= $FromName;
                  $enviar_objeto->To= $email_cobros;
                  $enviar_objeto->Text=  $Menssage;
                  $enviar_objeto->Subject='Reporte de Pago';            
                  $enviar_objeto->sedEmailCobros();    */           
              
                  //echo "1";
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
?>