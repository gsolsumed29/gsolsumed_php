<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
if($tipo==1){    
    if($accion ==1){
        if($datos==1){          
          
          //   data:{saldo:$saldo,co_cli:$co_cli,co_ven:$co_ven,co_tran:$co_tran,forma_pag:$forma_pag,total_bruto:$total_bruto,
            //total_neto:$total_neto,fiscal:$fiscal,tipo:tipo,accion:accion,datos:datos},
               
                $pedido_objeto = new PedidoData();
                  
                $saldo = $_POST['saldo'];              
                $co_cli = $_POST['co_cli'];
                $co_ven = $_POST['co_ven'];
                $co_alma = $_POST['co_alma'];
                $co_almaa = $_POST['co_almaa'];// sub almacen
                $co_tran = $_POST['co_tran'];
            
                $forma_pag = $_POST['forma_pag'];
                $total_bruto = $_POST['total_bruto'];
              //  echo $total_bruto;
                $total_neto = $_POST['total_neto'];
               // echo $total_neto;
                $iva = $_POST['iva'];
                $fiscal = $_POST['tipoFactura'];
                $total_art = $_POST['total_art'];
             
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
       
              
             echo "1";
            
            
            
            
            
            
        }
    }
    if($accion ==3){
        if($datos==1){
           
                $id = $_POST['id']; // valor para sacar el id del usuario         
                $pedido_objeto = new UserData();
               
                $pedido_objeto->id =$id;                
                $pedido_objeto->delF();
               echo "1";
            }
            
            
          

        }
    
   
   
}
?>