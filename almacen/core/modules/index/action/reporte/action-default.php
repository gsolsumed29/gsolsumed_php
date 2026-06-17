<?php
if(!isset($_GET['tipo'])){
    $tipo='0';
}else{
    $tipo=$_GET['tipo'];
}


if($tipo=='1'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReportePedido($fact_num,$status);

}

if($tipo=='0'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteEnviar($fact_num,$status);

}

if($tipo=='3'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReportePedido($fact_num,$status);

}

if($tipo=='4'){

    $co_cli = $_GET['co_cli'];  
    $status =0;
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteCuentasxCobrar($co_cli,$status);

}

if($tipo=='5'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteFacturacion($fact_num,$status);

}

if($tipo=='6'){

    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteAprobacion($fact_num,$status);

}


if($tipo=='7'){

    $filtro = $_GET['filtro'];
    //$status = $_GET['status'];
    $filtro ='NO';
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReporteArticulos($filtro);

}




?>