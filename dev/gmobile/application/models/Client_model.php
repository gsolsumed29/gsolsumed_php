<?php
	class Client_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

    public function get_vendedores(){
          $query = $this->db->query("SELECT co_ven,ven_des FROM vendedor ORDER BY co_ven ASC");
          return $query->result();
        }

   	public function get_client_ant($rif,$nombre,$co_ven){
      $bus   = array("", "+");
   		$where=" ";
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where.=" AND c.rif like '%".$rif."%'"; }
			
        	$resultado = $this->db->query("SELECT c.co_cli, c.cli_des, c.rif, c.direc1, c.telefonos, c.email,c.fec_ult_ve , c.fac_ult_ve,
c.co_zon, z.zon_des, t.des_tipo, c.dir_ent2 FROM _jm_ven_zon v 
INNER JOIN clientes c ON c.co_zon=v.co_zon $where
INNER JOIN zona z ON c.co_zon = z.co_zon
INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
 WHERE v.co_ven='$co_ven' ");

   			return $resultado;
   		}

   		public function get_client($rif,$nombre,$co_ven){
        $where=" ";
        if($co_ven == '999'){
        }else{
          $where.=" AND c.co_ven='$co_ven' ";
        }
      $bus   = array("", "+");
   		
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where.=" AND c.rif like '%".$rif."%'"; }
			
        	$resultado = $this->db->query("SELECT c.co_cli, c.cli_des, c.rif, c.direc1, c.telefonos, c.email,c.fec_ult_ve , c.fac_ult_ve,
c.co_zon, z.zon_des, t.des_tipo, c.dir_ent2 FROM clientes c 
INNER JOIN zona z ON c.co_zon = z.co_zon
INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
 WHERE c.inactivo=0 $where ");

   			return $resultado;
   		}

	}
?>
