<?php
if(!isset($_GET['tipo'])){
    $tipo='0';
}else{
    $tipo=$_GET['tipo'];
}


if($tipo=='1'){
    $co_ven = $_GET['co_ven'];
    $fact_num = $_GET['fact_num'];
    $status = $_GET['status'];
    
    $objeto_pedido = New ReporteData();          
    $objeto_pedido->generarReportePedido($fact_num,$status,$co_ven);

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


?>