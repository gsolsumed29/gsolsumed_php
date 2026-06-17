<?php
include('../conectar.php');
if (isset($_GET['term'])){    
$buscar=$_GET['term'];	
$clienteactual=$_GET['extraParams'];
$return_arr = array();

	setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
					date_default_timezone_set('America/Caracas');
					$hoyes=date('Y-m-d');
					$dian=date('w', strtotime($hoyes)); 
					$m=date('m');
					$d=date('d');
	$query_feriado="SELECT count(*) as feriado FROM feriados WHERE dia='$d' AND mes='$m' AND borrado=0 ";
	$rs_feriado=mysql_query($query_feriado);
	$feriado=mysql_result($rs_feriado,0,"feriado");
					if($dian == 0 or $dian == 6 or $feriado > 0){
						$ff=" AND ff IN(0,1) ";
						$ff2=" ff DESC, ";
					}else{ $ff=""; $ff2=""; }
	$query_nocturno="SELECT noc_ini,diu_ini FROM config WHERE id=1 ";
	$rs_nocturno=mysql_query($query_nocturno);
	$noc_ini=mysql_result($rs_nocturno,0,"noc_ini");
	$diu_ini=mysql_result($rs_nocturno,0,"diu_ini");
					$hora=date('H');
					if($hora > $noc_ini or $hora < $diu_ini){
						$noct=" AND nocturno IN(0,1) ";
						$noct2=" nocturno DESC, ";
					}else{ $noct=""; $noct2=""; }

	$fetch = mysql_query("SELECT * FROM examenes where Nom_exa like '%$buscar%' LIMIT 0 ,50"); 
	
	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	while ($row = mysql_fetch_array($fetch)) {
		$id_producto=$row['IDExa'];

		$query_precio="SELECT * FROM listas_precio WHERE IDExa='$id_producto' AND codcliente IN('0','$clienteactual') AND borrado=0 $noct $ff ORDER BY $ff2 $noct2 codcliente DESC, idlista_precio ASC";
		$res_precio=mysql_query($query_precio);
		$precio=mysql_result($res_precio,0,"valor");

		//$precio=number_format($row['precio1'],2,".","");
		$row_array['value'] = $row['IDExa']." | ".$row['Nom_exa'];
		$row_array['codarticulo']=$row['IDExa'];
		$row_array['codigo']=$row['IDExa'];
		$row_array['descripcion']=$row['Nom_exa'];
		$row_array['precio']=$precio;
		$row_array['codfamilia']=$row['codfamilia'];
		array_push($return_arr,$row_array);
    }



/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);

}
?>