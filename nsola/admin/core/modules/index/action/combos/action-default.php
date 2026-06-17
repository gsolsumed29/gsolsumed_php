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
   // $vendedores = $_GET['p'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataFiltrada($filtro,$almacen);            
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
    // COLEGIO
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

if($a==16){
    $datos = new $clase(); 
    $result=[];  
    $co_cli = $_GET['co_cli'];
    $filtro = $_GET['filtro'];
   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasCliente($co_cli,$filtro);
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
    $hoy = getdate();
    $mes = $hoy['mon'];
    $anio = $hoy['year'];
    $datos = new $clase(); 
    $result=[];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->estadisticasFacturaciones($mes,$anio);            
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
    $datos = new $clase(); 
    $result=[];
    $filtro = $_GET['filtro'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getDataTopVendidos($filtro);
            
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
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPorCobrarGerente($filtro,$co_ven);
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



if($a==51){
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

if($a==52){
    $datos = new $clase(); 
    $result=[];  
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllCuentasPorCobrarDetallesSecretaria();
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
} 

if($a==53){
    $datos = new $clase(); 
    $result=[];  
    $co_cli = $_GET['co_cli'];
    $filtro = $_GET['filtro'];
   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturasClienteSecretaria($co_cli,$filtro);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}

if($a==54){
    $datos = new $clase(); 
    $result=[];  
    $fact_num = $_GET['fact_num'];   
    $co_cli = $_GET['co_cli'];   
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getFacturaDetallesSecretaria($fact_num,$co_cli);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}



if($a==99){
    $datos = new $clase(); 
    $result=[];  
    $tipoSolicitud = $_GET['tipoSolicitud'];
    $estatus = $_GET['estatus'];
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = $datos->getAllDataSolicitudes($tipoSolicitud,$estatus);
            break;
    }    
    header("Content-Type: application/json");
    echo json_encode($result);
    //var_dump($result);
}


?>
