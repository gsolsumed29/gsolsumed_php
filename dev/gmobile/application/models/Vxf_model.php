<?php
	class Vxf_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

   	public function get_client($rif,$nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
   		$where1="";
      $where2="";
        $where="1=1";
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where1.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where1.=" AND c.rif like '%".$rif."%'"; }
        if (($fini<>"") and ($ffin<>"")) {
        //$fini = date('Y-m-d', strtotime($fini));
            //$ffin = date('Y-m-d', strtotime($ffin));
            $where.=" AND f.fec_vis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
            $where2.=" f1.fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
        } else {
            if ($fini<>"") {
                $fini = date('Y-m-d', strtotime($fini));
                $where.=" and   f.fec_vis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
                $where2.=" f1.fec_emis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
            } else {
                if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and f.fec_vis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                    $where2.=" f1.fec_emis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                }
            }
        }
			
        	$resultado = $this->db->query("SELECT distinct f.co_cli, c.rif, c.cli_des, convert(varchar, c.fec_ult_ve, 101) AS fec_ult_ve, c.fac_ult_ve, c.net_ult_ve, f.co_ven, z.zon_des, t.des_tipo FROM _jm_visitados f INNER JOIN clientes c ON c.co_cli=f.co_cli AND c.co_ven=f.co_ven $where1 INNER JOIN zona z ON c.co_zon = z.co_zon INNER JOIN tipo_cli t ON c.tipo = t.tip_cli WHERE $where AND f.co_ven='$co_ven' AND f.compro=0 AND f.status=0 AND f.co_cli NOT IN ( SELECT distinct f1.co_cli FROM factura f1 WHERE $where2 AND f1.anulada = 0 AND f1.co_ven=f.co_ven) ");

   			return $resultado;
   		}

	}
?>
