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
        $array[$cnt]->prec_vta1 = $item['prec_vta1'];
        $array[$cnt]->rowid = $item["rowid"];
        $array[$cnt]->qty = $item['qty'];
        $array[$cnt]->subtotal = $item['subtotal'];
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

?>
