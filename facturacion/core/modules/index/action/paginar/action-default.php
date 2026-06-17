<?php
$html = '';
$page = $_GET['page'];
$almacen = $_GET['almacen'];
$rowsPerPage = NUM_ITEMS_BY_PAGE;
$offset = ($page - 1) * $rowsPerPage;
sleep(1);
$articulosPagina = ArticuloData::getDataPaginas($offset,$rowsPerPage,'1',$almacen);

header("Content-Type: application/json");
echo json_encode($articulosPagina);

?>
