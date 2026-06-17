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
          $saldo = $_GET['saldo'];              
              $co_cli = $_GET['co_cli'];
              $cli_des = $_GET['cli_des'];
              $co_ven = $_GET['co_ven'];
              $co_alma = $_GET['co_alma'];
              $co_almaa = $_GET['co_almaa'];// sub almacen
              $co_tran = $_GET['co_tran'];
          
              $forma_pag = $_GET['forma_pag'];
              $total_bruto = $_GET['total_bruto'];          
              $total_neto = $_GET['total_neto'];         
              $iva = $_GET['iva'];
              $fiscal = $_GET['tipoFactura'];
              $total_art = $_GET['total_art'];
              
              
             
            $funciones_objeto = new FuncionesData();
            $data1=$funciones_objeto->validarFacturas($co_cli);
            $data2=$funciones_objeto->validarDiasFacturas($co_cli);

             if((empty($data1)) && (empty($data2))){

              $pedido_objeto = new PedidoData();                
               
              $pedido_objeto->saldo =$saldo;
              $pedido_objeto->co_cli =$co_cli;
              $pedido_objeto->co_ven =$co_ven;
              $pedido_objeto->co_sucu =$co_alma;///// almacen 
              $pedido_objeto->co_alma =$co_almaa;/////  sub almacen
              $pedido_objeto->co_tran =$co_tran;
              $pedido_objeto->forma_pag =$forma_pag;
              $pedido_objeto->total_bruto =$total_bruto;
              $pedido_objeto->total_neto =$total_neto;
              $pedido_objeto->iva =$iva;
              $pedido_objeto->fiscal =$fiscal;
              $pedido_objeto->total_art =$total_art;
              $pedido_objeto->add();

              $carrito_objeto = new CarritoData();
              $carrito_objeto->destroy();
    
              $data=$pedido_objeto->ultimoPedido($co_cli);
              $fact_num=$data['fact_num'];              
              $status = "0";
    
              $objeto_pedido = New ReporteData();          
              $archivo=$objeto_pedido->generarReporteEnviar($fact_num,$status);

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
              $email_ventas=$data[0]->email_ventas; 
              $AddAttachment=$archivo;

             // email_cobros  Host Port Username Password From FromName To Subject AddAttachment
             $Menssage ="<p>Nombre del cliente: <b> ".$cli_des." </b></p>";
             $Menssage.="<p>Nº Pedido :<b> ".$fact_num."</b> </p>";             
             $Menssage.="<p>Total neto $ :<b> ".$total_neto."</b> </p>";
             $Menssage.="<hr>";
              $Subject ='Nro Pedido : '.$fact_num.'| Codigo cliente: '.$co_cli;
              $enviar_objeto = new EnviarData();
              $enviar_objeto->Host= $Host;
              $enviar_objeto->Port= $Port;
              $enviar_objeto->Username= $Username;
              $enviar_objeto->Password= $Password;
              $enviar_objeto->From= $From;
              $enviar_objeto->FromName= $FromName;
              $enviar_objeto->To= $email_ventas;
              $enviar_objeto->Text=  $Menssage.$Text;
              $enviar_objeto->Subject=$Subject;
              $enviar_objeto->AddAttachment=$AddAttachment;
              $enviar_objeto->sedEmailVentas();
              unlink($archivo);
              
              echo "1";

             }else{
              $cotizacion_objeto = new CotizacionData();                
               
              $cotizacion_objeto->saldo =$saldo;
              $cotizacion_objeto->co_cli =$co_cli;
              $cotizacion_objeto->co_ven =$co_ven;
              $cotizacion_objeto->co_sucu =$co_alma;///// almacen 
              $cotizacion_objeto->co_alma =$co_almaa;/////  sub almacen
              $cotizacion_objeto->co_tran =$co_tran;
              $cotizacion_objeto->forma_pag =$forma_pag;
              $cotizacion_objeto->total_bruto =$total_bruto;
              $cotizacion_objeto->total_neto =$total_neto;
              $cotizacion_objeto->iva =$iva;
              $cotizacion_objeto->fiscal =$fiscal;
              $cotizacion_objeto->total_art =$total_art;
              $cotizacion_objeto->add();

              $carrito_objeto = new CarritoData();
              $carrito_objeto->destroy();
    
              $data=$cotizacion_objeto->ultimoPedido($co_cli);
              $fact_num=$data['fact_num'];              
              $status = "0";
    
              $objeto_pedido = New ReporteData();          
              $archivo=$objeto_pedido->generarReporteEnviarCotizacion($fact_num,$status);

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
              $email_ventas=$data[0]->email_ventas; 
              $AddAttachment=$archivo;

             $Menssage ="<p>Nombre del cliente: <b> ".$cli_des." </b></p>";
             $Menssage.="<p>Nº Pedido :<b> ".$fact_num."</b> </p>";             
             $Menssage.="<p>Total neto $ :<b> ".$total_neto."</b> </p>";
             $Menssage.="<hr>";
              $Subject ='Nro Cotizacion : '.$fact_num.'| Codigo cliente: '.$co_cli;
              $enviar_objeto = new EnviarData();
              $enviar_objeto->Host= $Host;
              $enviar_objeto->Port= $Port;
              $enviar_objeto->Username= $Username;
              $enviar_objeto->Password= $Password;
              $enviar_objeto->From= $From;
              $enviar_objeto->FromName= $FromName;
              $enviar_objeto->To= $email_ventas;
              $enviar_objeto->Text=  $Menssage.$Text;
              $enviar_objeto->Subject=$Subject;
              $enviar_objeto->AddAttachment=$AddAttachment;
              $enviar_objeto->sedEmailVentas();
              
              unlink($archivo);

             echo "4";
            }
            
            
        
        
            
            
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

?>