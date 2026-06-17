<?php
	class Pxf_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

        public function get_detallado($fact_num){
            $query = $this->db->query("SELECT r.reng_num,r.co_art,a.art_des,r.total_art,r.uni_venta,r.prec_vta,r.reng_neto FROM reng_cac r INNER JOIN art a ON a.co_art=r.co_art WHERE r.fact_num='$fact_num' ORDER BY r.reng_num ASC");
            return $query->result();
        }

        public function get_client($co_ven,$fini,$ffin,$facturados){
            $where="";
            $where1="";
            if($facturados > 0){
                if($facturados == 1){
                    $where1.=" AND status > 0 AND factura > 0 ";
                }else{
                    $where1.=" AND status=0 ";
                }
            }

            if (($fini<>"") and ($ffin<>"")) {
                $where.=" AND fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
            } else {
                if ($fini<>"") {
                    $fini = date('Y-m-d', strtotime($fini));
                    $where.=" and   fec_emis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
                } else {
                    if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and fec_emis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                    }
                }
            }
			
        	$resultado = $this->db->query("SELECT fact_num,convert(varchar, fec_emis, 101) AS fec_emis,saldo,tot_bruto,tot_neto,co_cli,cli_des,rif,co_ven,status,factura FROM View_cotiz_fact WHERE co_ven='$co_ven' $where1 $where ORDER BY fact_num DESC");

   			return $resultado;
   		}

	}
?>
