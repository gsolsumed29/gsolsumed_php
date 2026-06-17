<?php
$html = '';
$page = $_GET['page'];
$almacen = $_GET['almacen'];

$tipo_precio = $_GET['tipo_precio'];
$facturacion = $_GET['facturacion'];
$pago = $_GET['pago'];




$rowsPerPage = NUM_ITEMS_BY_PAGE;
$offset = ($page - 1) * $rowsPerPage;
sleep(1);
$articulosPagina = ArticuloData::getDataPaginas($offset,$rowsPerPage,'1',$almacen,$tipo_precio,$facturacion,$pago);
header("Content-Type: application/json");
echo json_encode($articulosPagina);

?>
