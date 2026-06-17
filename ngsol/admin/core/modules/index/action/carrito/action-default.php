<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para crear orden 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 auto 2 estructura 3 otro 4 patrimonial 5-personal
 date_default_timezone_set('America/Caracas');
$fecha = date("Y-m-d H:i:s");	
if($tipo==1){    
    if($accion ==1){
        if($datos==1){

            $qty =  $_REQUEST['qty'];
           // $qty = 1;
            $co_art = $_REQUEST['co_art'];
            $almacen = $_REQUEST['almacen'];
            $user_objeto = new ArticuloData();

            $result = $user_objeto->getDataID($co_art,$almacen);
           // var_dump($result);
            $stock_act = $result[0]->stock_act;
            if($qty<=$stock_act){
                $datoIva = $result[0]->impuesto;
                $datoDes =  $result[0]->art_des;
                $datoPrecio = $result[0]->prec_vta1;
                $uni = $result[0]->suni_venta;
                $tiva = $result[0]->tipo_imp;
                $iva = (($datoPrecio*1)*($datoIva/100));
                $itemData = array(
                    'co_art' =>   $co_art,
                    'art_des' =>  $datoDes,
                    'prec_vta1' =>$datoPrecio,
                    'qty' => $qty,
                    'iva' => $iva,
                    'uni' => $uni,
                    'tiva' => $tiva,
                );
                //print_r($itemData);
                $carrito_objeto = new CarritoData();
                $insertItem = $carrito_objeto->insert($itemData);
                echo "1";
            }else{
                echo "3";
            }
            
            //var_dump($_SESSION['cart_contents']);
           //unset($_SESSION['cart_contents']);
        }
     
    }
    if($accion ==2){
        if($datos==1){
            $co_art =  $_REQUEST['co_art'];
            $qty =  $_REQUEST['qty'];
            $almacen=0;
            $articulo_objeto = new ArticuloData();
            $result = $articulo_objeto->getDataID($co_art,$almacen);
            $stock_act = $result[0]->stock_act;
            if($qty<=$stock_act){
            $rowId =  $_REQUEST['rowId'];
            $itemData = array(
                'rowid' => $rowId,
                'qty' => $qty
            );
            $carrito_objeto = new CarritoData();
            $updateItem = $carrito_objeto->update($itemData);
            echo "1";
            //echo $updateItem?'ok':'err';die;
            }else{
            echo $stock_act;

            }
        }
      
    }
    if($accion ==3){
        if($datos==1){
            $carrito_objeto = new CarritoData();
            $deleteItem = $carrito_objeto->remove($_REQUEST['id']);
           // echo "3";
        }
     

    }

    if($accion ==4){
        if($datos==1){
            $carrito_objeto = new CarritoData();
            $carrito_objeto->destroy();  
            echo "1";
        }
     

    }


    
   
   
}
?>