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


/*
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 lecciones
*/
if($tipo==1){    
 
  
    if($accion ==3){
      if($datos==1){
         
              $fact_num = $_POST['fact_num']; // valor para sacar el id del usuario         
              $pedido_objeto = new CotizacionData();
             
            
              $pedido_objeto->fact_num =$fact_num;             
              $pedido_objeto->eliminarPedidoRenglon();  
              $pedido_objeto->eliminar();      
            
          echo "1";
          }
          
          
        

      }


    
   
   
}

?>