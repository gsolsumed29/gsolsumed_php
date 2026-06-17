<?php
	class Sclient_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

        public function get_zonas_ant($co_ven){
        	$query = $this->db->query("SELECT z.co_zon,z.zon_des,z.campo4 FROM _jm_ven_zon v INNER JOIN zona z ON z.co_zon=v.co_zon WHERE v.co_ven='$co_ven' GROUP BY z.co_zon,z.zon_des,z.campo4  ORDER BY z.campo4 ASC");
        	return $query->result();
        }

        public function get_zonas($co_ven){
            $query = $this->db->query("SELECT z.co_zon,z.zon_des,z.campo4 FROM zona z GROUP BY z.co_zon,z.zon_des,z.campo4  ORDER BY z.campo4 ASC");
            return $query->result();
        }

        public function get_tipos(){
            $query = $this->db->query('SELECT tip_cli,des_tipo FROM tipo_cli ORDER BY precio_a ASC');
            return $query->result();
        }

    public function add_cli($rif,$nombre,$direccion,$direccionent,$telefono,$email,$co_ven,$zona,$tipo,$respons,$fecha_reg,$sada,$status=0,$borrado=0){
      $data = array(
      				'co_cli' => $rif,
                    'tipo' => $tipo,
                    'cli_des' => $nombre,
                    'direc1' => $direccion,
                    'telefonos' => $telefono,
                    'respons' => $respons,
                    'co_zon' => $zona,
                    'co_ven' => $co_ven,
                    'email' => $email,
                    'rif' => $rif,
                    'fec_reg' => $fecha_reg,
                    'direc_ent' => $direccionent,
                    'sada' => $sada,
                    'status' => $status,
                    'borrado' => $borrado
                    );
      $this->db->insert('_jm_Clientes',$data);
      return $this->db->affected_rows();
    }

    public function update_cli($codcliente,$rif,$nombre,$direccion,$direccionent,$telefono,$email,$zona,$tipo,$sada){
      $data = array(
                    'tipo' => $tipo,
                    'cli_des' => $nombre,
                    'direc1' => $direccion,
                    'telefonos' => $telefono,
                    'co_zon' => $zona,
                    'email' => $email,
                    'rif' => $rif,
                    'direc_ent' => $direccionent,
                    'sada' => $sada
                    );
      $this->db->where('co_cli', $codcliente);
      return $this->db->update('_jm_Clientes', $data);
    }

     public function no_repetir_cli($rif,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('_jm_Clientes');
        $this->db->where('rif', $rif);
        $this->db->where('borrado', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function no_repetir_cli2($rif,$codcliente,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('_jm_Clientes');
        $this->db->where('rif', $rif);
        $this->db->where('co_cli <>', $codcliente);
        $this->db->where('borrado', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function get_cliente_vali($rif)
    {
        $this->db->from('clientes');
        $this->db->where('nif',$rif);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_cliente_vali2($co_cli)
    {
        $this->db->from('_jm_Clientes');
        $this->db->where('co_cli',$co_cli);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function delete_cli($co_cli,$borrado=1){
      $data = array(
                    'borrado' => $borrado
                    );
      $this->db->where('co_cli', $co_cli);
      return $this->db->update('_jm_Clientes', $data);
    }


   	public function get_client($rif,$nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
   		$where=" ";
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where.=" AND c.rif like '%".$rif."%'"; }

        if (($fini<>"") and ($ffin<>"")) {
        //$fini = date('Y-m-d', strtotime($fini));
            //$ffin = date('Y-m-d', strtotime($ffin));
            $where.=" AND c.fec_reg between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
        } else {
            if ($fini<>"") {
                $fini = date('Y-m-d', strtotime($fini));
                $where.=" and   c.fec_reg>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
            } else {
                if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and c.fec_reg<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                }
            }
        }
			
        	$resultado = $this->db->query("SELECT c.co_cli, c.cli_des, c.rif, c.direc1, c.direc_ent, c.telefonos, c.email,
c.co_zon, z.zon_des, t.des_tipo, c.sada, c.status,(CASE WHEN c.status = 0 THEN 'Pendiente'
                ELSE 'Procesado'
                END) AS status_msg,(CASE
  WHEN c.status = 0 THEN 'badge badge-primary'
  ELSE 'badge badge-success'
END) AS status_color FROM _jm_Clientes c INNER JOIN zona z ON c.co_zon = z.co_zon
INNER JOIN tipo_cli t ON c.tipo = t.tip_cli
 WHERE c.borrado=0 AND c.co_ven='$co_ven' $where ");

   			return $resultado;
   		}

      public function cargar_invoicetmp($codfactura,$codfacturatmp){
           return $query = $this->db->query("INSERT INTO factulineatmp (codfactura,codfamilia,codigo,cantidad,precio,importe,dcto,iva,excento,status) 
SELECT $codfacturatmp AS codfactura,codfamilia,codigo,cantidad,precio,importe,dcto,iva,excento,status
FROM factulinea WHERE codfactura='$codfactura'");
            //return $query->result();
        }

	}
?>
