<?php
	class Nvxf_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

   	public function get_client($rif,$nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
   		$where1="";
        $where="1=1";
        $where2="";
        $where3="";
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where1.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where1.=" AND c.rif like '%".$rif."%'"; }
        if (($fini<>"") and ($ffin<>"")) {
        //$fini = date('Y-m-d', strtotime($fini));
            //$ffin = date('Y-m-d', strtotime($ffin));
            $where.=" AND f.fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
            $where2.=" c.fecha_reg between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
            $where3.=" v.fec_vis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
        } else {
            if ($fini<>"") {
                //$fini = date('Y-m-d', strtotime($fini));
                $where.=" and   f.fec_emis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
                $where2.=" c.fecha_reg>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
            } else {
                if ($ffin<>"") {
                    //$ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and f.fec_emis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                    $where2.=" c.fecha_reg<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                }
            }
        }
			
        	$resultado = $this->db->query("SELECT c.co_cli, c.cli_des, c.rif, c.direc1, c.telefonos, convert(varchar, c.fec_ult_ve, 101) AS fec_ult_ve, t.des_tipo,c.co_ven, c.co_zon, z.zon_des,
CASE WHEN $where2 THEN 1 ELSE 0 END Nuevo, 
convert(varchar, c.fecha_reg, 101) AS fecha_reg  FROM clientes c 
INNER JOIN tipo_cli t ON t.tip_cli = c.tipo 
INNER JOIN zona z ON z.co_zon = c.co_zon 
WHERE c.co_ven='$co_ven' 
AND c.co_cli NOT IN ( SELECT f.co_cli FROM factura f WHERE $where AND f.anulada = 0 AND f.co_ven='$co_ven')
AND c.co_cli NOT IN (SELECT distinct v.co_cli FROM _jm_visitados v 
WHERE $where3 
AND v.co_cli NOT IN ( SELECT distinct f.co_cli FROM factura f WHERE $where AND f.anulada = 0 AND f.co_ven='$co_ven') 
AND v.co_ven='$co_ven' AND v.compro=0 AND v.status=0)
 ORDER BY c.fec_ult_ve DESC ");

   			return $resultado;
   		}

	}
?>
