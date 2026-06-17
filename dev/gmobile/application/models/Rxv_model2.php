<?php
	class Rxv_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

    public function get_vendedores(){
          $query = $this->db->query("SELECT co_ven,ven_des FROM vendedor ORDER BY co_ven ASC");
          return $query->result();
        }

   	public function get_client($nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
   		$where1="";
        $where="1=1";
		    //if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where1.=" AND a.art_des like '%".$nombre."%'"; }
        if ($nombre <> "") { $where.=" AND a.co_art= '$nombre'"; }
        if ($co_ven <> "") { $where.=" AND f.co_ven= '$co_ven'"; }
        if (($fini<>"") and ($ffin<>"")) {
        //$fini = date('Y-m-d', strtotime($fini));
            //$ffin = date('Y-m-d', strtotime($ffin));
            $where.=" AND f.fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
        } else {
            if ($fini<>"") {
                $fini = date('Y-m-d', strtotime($fini));
                $where.=" and   f.fec_emis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
            } else {
                if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and f.fec_emis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                }
            }
        }
			
        	$resultado = $this->db->query("SELECT r.co_art,a.art_des,SUM(r.total_art) AS uni_vta,SUM(r.total_dev) AS uni_dev,
SUM(r.reng_neto) AS tot_ven,f.co_ven,v.ven_des
FROM factura f INNER JOIN reng_fac r ON f.fact_num=r.fact_num
INNER JOIN art a ON r.co_art=a.co_art $where1
INNER JOIN vendedor v ON f.co_ven=v.co_ven
WHERE $where
GROUP BY r.co_art,a.art_des,f.co_ven,v.ven_des");

   			return $resultado;
   		}

	}
?>
