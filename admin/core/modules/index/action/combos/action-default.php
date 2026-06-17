<?php
$clase =$_GET['c'];
$tabla = $_GET['t'];
if(isset($_GET['a'])){
    $a=$_GET['a'];
    }
if($a==1){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatos();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 
if($a==111){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosSimples();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==1112){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosSimplesCandidatos();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==1109){
    $datos = new $clase(); 
    $result=[];
    $fecha = $_GET['fecha'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTasaDia($fecha);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==112){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosCLientesLocalizacion($filtro);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==1123){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltrada($filtro);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==1111){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosSimplesTodos();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}
if($a==999){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosPrincipales();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==2){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltrada($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==3){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    $vendedores = $_GET['p'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltrada($filtro,$vendedores);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==4){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    $almacen = $_GET['almacen'];

    $tipo_precio = $_GET['tipo_precio'];
    $facturacion = $_GET['facturacion'];
    $pago = $_GET['pago'];
    
   // $vendedores = $_GET['p'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltrada($filtro,$almacen,$tipo_precio,$facturacion,$pago);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==5){
    $datos = new $clase(); 
    $result=[];   
    $almacen = $_GET['almacen'];
   // $vendedores = $_GET['p'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->contarArticulos($almacen);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==6){
    
    $datos = new $clase(); 
    $result=[];
    $array = array();
    $cnt =0;
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->contents();
            break;
    }
   // var_dump($result);
    foreach($result as $item){

        $array[$cnt] = new ArticuloData();    
        $array[$cnt]->art_des = $item["art_des"];
        $array[$cnt]->prec_vta1 = number_format($item['prec_vta1'], 2, ',', '.');
        $array[$cnt]->rowid = $item["rowid"];
        $array[$cnt]->qty = $item['qty'];
        $array[$cnt]->subtotal = number_format($item['subtotal'], 2, ',', '.');
        $array[$cnt]->co_art = $item['co_art'];
        $array[$cnt]->impuesto = $item['iva'];
        $array[$cnt]->suni_venta = $item['uni'];
        $array[$cnt]->tipo_imp = $item['tiva'];
        $array[$cnt]->marca = $item['marca'];
    $cnt++;
    }
  
    header("Content-Type: application/json");
    echo json_encode($array);
   // var_dump($array);
}   


if($a==7){
    
    $datos = new $clase(); 
    $result=[];
    $array = array();
    $cnt =0;
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->total_items();
            break;
    }
  
    //var_dump($result);
    echo $result;
    //header("Content-Type: application/json");
    //echo json_encode($array);
   // var_dump($array);
}   


if($a==8){
    
    $datos = new $clase(); 
    $result=[];
    $result2=[];
    $result3=[];
    $array = array();
    $cnt =0;
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->total_items();
            $result2 = $datos->total();
          //  $result3 = $datos->total_impuesto();
            break;
    }
  
   // echo $result.'-'.$result2.'-'.$result3;
    echo $result.'-'.$result2;
} 

if($a==9){
    
    $datos = new $clase(); 
    $result=[];
    $array = array();
    $cnt =0;
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->contents();
            break;
    }
  
    foreach($result as $item){
        $array[$cnt] = new ArticuloData();    
        $array[$cnt]->art_des = $item["art_des"];
       
    $cnt++;
    }
    header("Content-Type: application/json");
    echo json_encode($array);
   // var_dump($array);
}   

if($a==10){
    
    $datos = new $clase(); 
    $result=[];
    $array = array();
    $cnt =0;
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->contents_total();
            break;
    }
  
    foreach($result as $item){
        $array[$cnt] = new ArticuloData();    
        $array[$cnt]->art_des = $item["art_des"];
       
    $cnt++;
    }
    header("Content-Type: application/json");
    echo json_encode($array);
   // var_dump($array);
}  

if($a==11){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getTopVendidos();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}  

if($a==12){
    //traemos lso datos del vendedor buscando por su codigo
   
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosFiltrados();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);

    
}

if($a==13){
    // filtro implementado por el usuario vendedor para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
    $status = $_GET['status'];
    $rango = $_GET['rango'];
    if($rango=="NO"){
        $rango='NO';
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosFiltro($status,$rango);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
  
    }else{

        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosFiltro($status,$rango);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
    }
   

}  

if($a==14){
    $datos = new $clase(); 
    $result=[];  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPorCobrar();
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==15){
    $datos = new $clase(); 
    $result=[];  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPorCobrarDetalles();
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==155){
    $datos = new $clase(); 
    $result=[];  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllClientesCobros();
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==16){
    $datos = new $clase(); 
    $result=[];  
    $co_cli = $_GET['co_cli']; // CLIENTE
    $filtro = $_GET['filtro']; // ANULADAS O NO ANULADAS
    $filtro2 = $_GET['filtro2']; // FECHA DE INICIO 
    $filtro3 = $_GET['filtro3']; // FECHA FINAL
    $filtro4 = $_GET['filtro4']; // TIPO DE DOCUMENTO
    $filtro5 = $_GET['filtro5']; // TIPO DE PAGO

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasCliente($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}

if($a==17){
    $datos = new $clase(); 
    $result=[];  
    $fact_num = $_GET['fact_num'];   
    $co_cli = $_GET['co_cli'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturaDetalles($fact_num,$co_cli);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}

if($a==18){
    $id =$_GET['id'];
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosFiltrados($id);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);

    
}

if($a==19){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosCorreo();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}

if($a==20){
    $datos = new $clase(); 
    $result=[];  
    $co_cli = $_GET['co_cli'];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAdelantosCliente($co_cli,$filtro);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}

/// para cargar tados linea
if($a==25){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataLineas();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


/// para cargar datos de gerencia
if($a==21){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosGerencia();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

/// Pagar cargar reportes vendedor


if($a==22){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedor($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==23){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['rango'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedor($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==26){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedorGrafico($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==27){
    // reporte de ventas por linea
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['rango'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedorLinea($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 
if($a==28){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedorGraficoLinea($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

///// Para cargar reportes gerente

if($a==24){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['rango'];
    $co_ven = $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedores($co_ven,$filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==29){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    $vendedores = $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGrafico($vendedores,$filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==30){
    // reporte de ventas por linea
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['rango'];   
    $vendedores = $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresLinea($vendedores,$filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 
if($a==31){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];   
    $vendedores = $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGraficoLinea($vendedores,$filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==32){
   
    $co_ven = $_GET['co_ven'];
    $fechaI = $_GET['fechaI'];
    $fechaF = $_GET['fechaF'];
    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->estadisticasFacturaciones($co_ven,$fechaI,$fechaF);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==33){
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
    $status = $_GET['status'];
    $rango = $_GET['rango'];
    $co_ven = $_GET['co_ven'];
    if($rango=="NO"){
        if($co_ven=="NO"){
       
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosFiltroGerente($status,$rango,$co_ven);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
         }else{

        $rango='NO';

        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosFiltroGerente($status,$rango,$co_ven);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
    }
    }else{

        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosFiltroGerente($status,$rango,$co_ven);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
    }
   

}  



if($a==40){
    // filtro implementado por el usuario vendedor para obtener las aprobaciones
    $datos = new $clase(); 
    $result=[];
    $co_alma = $_GET['co_alma'];
    $rango = $_GET['rango'];
    $costo = $_GET['costo'];
    


    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDatosGerenciales($co_alma,$rango,$costo);
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    /*
    if($rango=="NO"){
        $rango='0';
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosGerenciales($status,$rango,$co_sucu);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
  
    }else{

        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosGerenciales($status,$rango,$co_sucu);
                break;
        }
        
        header("Content-Type: application/json");
        echo json_encode($result);
    }
   */

}


if($a==41){
    $datos = new $clase(); 
    $result=[];  
    $co_cli = $_GET['co_cli'];
    $filtro = $_GET['filtro'];
    $co_ven= $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasClienteGerente($co_cli,$filtro,$co_ven);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}

/// para los graficos de afuera (tablero)
if($a==42){
    $datos = new $clase(); 
    $result=[];
  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGrafico_tablero();
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==43){
    //$co_ven,$co_zona,$finicio,$ffinal
    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $co_zona = $_GET['co_zona'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopVendidos($co_ven,$co_zona,$finicio,$ffinal);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==44){
    $datos = new $clase(); 
    $result=[];
  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGrafico_tablero_linea();
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==45){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopVendidosVendedor($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==46){
    $datos = new $clase(); 
    $result=[];
  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGrafico_tablero_linea_vendedor();
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==47){
    $datos = new $clase(); 
    $result=[];
  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGrafico_tablero_vendedor();
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==48){
    $datos = new $clase(); 
    $result=[];  
    $filtro = $_GET['filtro'];
    $co_ven = $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPorCobrarDetallesGerente($filtro,$co_ven);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
   
    //var_dump($result);
}
if($a==49){
    $datos = new $clase(); 
    $result=[];  
    $filtro = $_GET['filtro'];
    $co_ven = $_GET['co_ven'];
    $estatus = $_GET['estatus'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPorCobrarGerente($filtro,$co_ven,$estatus);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}  

if($a==50){
    $hoy = getdate();
    $mes = $hoy['mon'];
    $anio = $hoy['year'];
    $datos = new $clase(); 
    $co_ven =$_SESSION['identidad'];	
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->clientesNoFacturadosTabla($co_ven,$mes,$anio);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==55){
    $datos = new $clase(); 
    $result=[];  
    $co_cli = $_GET['co_cli'];
    $filtro = $_GET['filtro'];
   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasClienteGerencial($co_cli,$filtro);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}


if($a==56){
    /// top 10 cajas vendidas en el mes(gerente)
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopVendidosUnidades($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==57){
    $datos = new $clase(); 
    $result=[];  
    $co_ven = $_GET['co_ven'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllAnalisisVCTO($co_ven);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
   
    //var_dump($result);
}

if($a==58){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDataFiltrada($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

} 


if($a==59){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDataFiltradaArticulos($filtro);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

} 

if($a==60){
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    $filtro2 = $_GET['filtro2'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDataFiltradaArticulos_gerente($filtro,$filtro2);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

} 


if($a==61){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $co_zona = $_GET['co_zona'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
       
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosVentasxDia($co_ven,$co_zona,$finicio,$ffinal);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);
  
   
   

}  

if($a==62){ 

    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $co_zona = $_GET['co_zona'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopMenosVendidos($co_ven,$co_zona,$finicio,$ffinal);            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==63){
    /// top 10 cajas vendidas en el mes(gerente)
    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $co_zona = $_GET['co_zona'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    $estado = $_GET['estado'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopMayorMenorUtilidad($co_ven,$co_zona,$finicio,$ffinal,$estado);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==64){

    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $co_zona = $_GET['co_zona'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    $estado = $_GET['estado'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopClientesMasYMenos($co_ven,$co_zona,$finicio,$ffinal,$estado);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

} 

if($a==65){


    $datos = new $clase(); 
    $result=[];  
    $busqueda = $_GET['busqueda'];
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];
      $co_zona = $_GET['co_zona'];
        $co_cli = $_GET['co_cli'];
   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasInventario($busqueda,$fechaInicio,$fechaFin,$co_zona,$co_cli);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}



/// para cargar tados linea
if($a==66){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataZonas();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 



if($a==67){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
    
    
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
       
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosVentasxDiaVendedor($finicio,$ffinal);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);  

}  


if($a==68){
    $datos = new $clase(); 
    $result=[];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
    $estado = $_GET['estado'];     
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataMasyMenosVendidosVendedor($finicio,$ffinal,$estado);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==69){
    /// top 10 cajas vendidas en el mes(gerente)
    $datos = new $clase(); 
    $result=[];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    $estado = $_GET['estado'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopMayorMenorUtilidadVendedor($finicio,$ffinal,$estado);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==70){

    $datos = new $clase(); 
    $result=[];


    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    $estado = $_GET['estado'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopClientesMasYMenosVendedor($finicio,$ffinal,$estado);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

} 


if($a==71){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
    $co_zona = $_GET['co_zona'];
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosCobrosMes($co_ven,$co_zona,$finicio,$ffinal);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);
  
   
   


        
}  
if($a==72){

    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $co_zona = $_GET['co_zona'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];
    $estado = $_GET['estado'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopPagosMasYMenos($co_ven,$co_zona,$finicio,$ffinal,$estado);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);

} 

if($a==73){
    //$co_ven,$co_zona,$finicio,$ffinal
    // filtro implementado por el usuario gerente para obtener los pedidos
    $datos = new $clase(); 
    $result=[];
    $co_ven = $_GET['co_ven'];
    $finicio = $_GET['finicio'];
    $ffinal = $_GET['ffinal'];      
    $co_zona = $_GET['co_zona'];
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosArticulosFoco($co_ven,$co_zona,$finicio,$ffinal);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);


    }
   

    if($a==74){
        //$co_ven,$co_zona,$finicio,$ffinal
        // filtro implementado por el usuario gerente para obtener los pedidos
        $datos = new $clase(); 
        $result=[];
       
        $finicio = $_GET['finicio'];
        $ffinal = $_GET['ffinal'];      
      
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getAllDatosCobrosMesVendedor($finicio,$ffinal);
                    break;
            }        
            header("Content-Type: application/json");
            echo json_encode($result);
      
       
       
    
    
            
    }  

    if($a==75){
        //$co_ven,$co_zona,$finicio,$ffinal
        // filtro implementado por el usuario gerente para obtener los pedidos
        $datos = new $clase(); 
        $result=[];
      
        $finicio = $_GET['finicio'];
        $ffinal = $_GET['ffinal'];      
      
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getAllDatosArticulosFocoVendedor($finicio,$ffinal);
                    break;
            }        
            header("Content-Type: application/json");
            echo json_encode($result);
    
    
        }


        
    if($a==755){
        // INDICADOR 1 , VENTAS POR PERIODO
        $datos = new $clase(); 
        $result=[];
      
        $finicio = $_GET['finicio'];
        $ffinal = $_GET['ffinal'];      
      
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getAllDatosArticulosFocoVendedor($finicio,$ffinal);
                    break;
            }        
            header("Content-Type: application/json");
            echo json_encode($result);
    
    
        }

        if($a==76){

            $datos = new $clase(); 
            $result=[];
         
            $estado = $_GET['estado'];
            $finicio = $_GET['finicio'];
            $ffinal = $_GET['ffinal'];
         
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->getDataTopPagosMasYMenosVendedor($finicio,$ffinal,$estado);
                    
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        
        } 

        if($a==77){
       
          
            $co_ven = $_GET['co_ven'];
            $fechaI = $_GET['fechaI'];
            $fechaF = $_GET['fechaF'];
            $co_zona = $_GET['co_zona'];
            $datos = new $clase(); 
            $result=[];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->estadisticasFacturacionesGerente($co_ven,$co_zona,$fechaI,$fechaF);           
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        } 
       
        if($a==78){
           
            $datos = new $clase(); 
            $co_ven = $_GET['co_ven'];
            $fechaI = $_GET['fechaI'];
            $fechaF = $_GET['fechaF'];
            $result=[];   
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $datos->clientesNoFacturadosTabla($co_ven,$fechaI,$fechaF);            
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        } 

        if($a==79){
            //$co_ven,$co_zona,$finicio,$ffinal
            // filtro implementado por el usuario gerente para obtener los pedidos
            $datos = new $clase(); 
            $result=[];
            $co_ven = $_GET['co_ven'];
            $finicio = $_GET['finicio'];
            $ffinal = $_GET['ffinal'];      
            $co_zona = $_GET['co_zona'];
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getAllDatosArticulosVolumen($co_ven,$co_zona,$finicio,$ffinal);
                        break;
                }        
                header("Content-Type: application/json");
                echo json_encode($result);
        
        
            }

/// para los graficos de afuera (tablero)

if($a==95){
    $datos = new $clase(); 
    $result=[];  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllZonas();
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==96){
    $datos = new $clase(); 
    $result=[]; 
    $filtro = $_GET['filtro'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasInventarioDespachos($filtro);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}
if($a==97){
    $datos = new $clase(); 
    $result=[];  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllClientes();
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 




if($a==98){
    $datos = new $clase(); 
    $result=[];
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTipoPrecios();
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 
if($a==99){
    $datos = new $clase(); 
    $result=[];
  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltradaVendedoresGrafico_tablero_arreglos();
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 




if($a==99999){
    // filtro implementado por el usuario vendedor para obtener los pedidos

    $datos = new $clase(); 
    $result=[];  

    $co_cli = $_GET['co_cli'];
    $filtro = $_GET['filtro'];      // status
    $filtro2 = $_GET['filtro2'];    // zona 
    $filtro3 = $_GET['filtro3'];    // fecha inicio
    $filtro4 = $_GET['filtro4'];    // fecha final
    $filtro5 = $_GET['filtro5'];    // otro 
         
    if($co_cli=="NO"){
        $filtro='NO';
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosCobros($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);  
    }else{
        switch($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $result = $datos->getAllDatosCobros($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5);
                break;
        }        
        header("Content-Type: application/json");
        echo json_encode($result);
    }
   

}  


if($a==99998){
    $datos = new $clase(); 
    $result=[];
    $status = $_GET['filtro'];
    $rango = $_GET['rango'];

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataRenglonPagos($status,$rango);
            
            break;
    }
    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


if($a==99997){
    $datos = new $clase(); 
    $result=[]; 
      $status = $_GET['filtro'];
    $rango = $_GET['rango']; 
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPagoRegistrados($rango);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 


// para funcioes de chequeo y baderas
if($a==10000009){
    $datos = new $clase(); 
    $result=[]; 

    $dato = $_GET['dato'];  
    $tabla = $_GET['tabla'];
    $campo = $_GET['campo'];

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->foundValorArray($tabla,$campo,$dato,$datos);
            break;
    }
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==998877){


    $datos = new $clase(); 
    $result=[];  
    $filtro = $_GET['fact_num'];
   
   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->GetRenglonFacturaDespacho($filtro);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}


// para funcioes de chequeo y baderas
if($a==10011){
    $datos = new $clase(); 
    $result=[]; 

    $dato = $_GET['dato'];  
    $tabla = $_GET['tabla'];
    $campo = $_GET['campo'];

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->foundValorArrayCliente($tabla,$campo,$dato,$datos);
            break;
    }
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 



?>