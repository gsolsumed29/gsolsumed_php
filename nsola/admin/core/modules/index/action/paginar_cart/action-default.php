<?php
$html = '';
$page = $_GET['page'];
$almacen = $_GET['almacen'];
$rowsPerPage = NUM_ITEMS_BY_PAGE_CART;
$offset = ($page - 1) * $rowsPerPage;
sleep(1);
$objeto_cart = New CarritoData();
$articulosCart= $objeto_cart->contents_filtrado($offset);

$array = array();
$cnt = 0;	

foreach($articulosCart as $r) {
$array[$cnt] = new ArticuloData(); 
$array[$cnt]->art_des = $r['art_des'];
$array[$cnt]->prec_vta1 = $r['prec_vta1'];			
$array[$cnt]->rowid = $r['rowid'];		
$array[$cnt]->qty =$r['qty'];		
$array[$cnt]->subtotal =$r['subtotal'];		
$cnt++;
}
header("Content-Type: application/json");
echo json_encode($array);

?>
