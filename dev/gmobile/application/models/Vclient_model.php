<?php
	class Vclient_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

        public function get_zonas(){
        	$query = $this->db->query('SELECT co_zon,zon_des FROM zona ORDER BY campo4 ASC');
        	return $query->result();
        }

        public function get_motivos(){
            $query = $this->db->query('SELECT co_motivo,des_motivo FROM _jm_motivo ORDER BY des_motivo ASC');
            return $query->result();
        }

        public function get_tipos(){
            $query = $this->db->query('SELECT tip_cli,des_tipo FROM tipo_cli ORDER BY precio_a ASC');
            return $query->result();
        }

        public function get_clientes($nombre,$co_ven){
            $bus   = array("", "+");
            $nombre=str_replace($bus, "%", $nombre);
            $query = $this->db->query("SELECT TOP 50 c.co_cli,c.cli_des,c.rif FROM clientes c WHERE c.co_ven='$co_ven' AND c.cli_des LIKE '%$nombre%' ORDER BY c.cli_des ASC");
            return $query->result();
        }

    public function add_cli($co_visita,$co_cli,$fec_vis,$compro,$co_ven,$observacion){
      $data = array(
      				'co_visita' => $co_visita,
                    'co_ven' => $co_ven,
                    'co_cli' => $co_cli,
                    'fec_vis' => $fec_vis,
                    'compro' => $compro,
                    'observacion' => $observacion,
                    'status' => 0
                    );
      $this->db->insert('_jm_visitados',$data);
      return $this->db->affected_rows();
    }

    public function update_cli($co_visita,$co_cli,$fec_vis,$compro,$co_ven,$observacion){
      $data = array(
                    'co_cli' => $co_cli,
                    'fec_vis' => $fec_vis,
                    'compro' => $compro,
                    'observacion' => $observacion
                    );
      $this->db->where('co_visita', $co_visita);
      return $this->db->update('_jm_visitados', $data);
    }
    public function delete_cli($co_visita,$borrado=1){
      $data = array(
                    'status' => $borrado
                    );
      $this->db->where('co_visita', $co_visita);
      return $this->db->update('_jm_visitados', $data);
    }

    public function obtener_co_visita(){
        $query = $this->db->query("SELECT (isnull(max(co_visita),0) + 1) AS ultimo FROM _jm_visitados");
        return $query->row();
      }

     public function no_repetir_cli($co_cli,$fecha,$compro,$co_ven){

        $this->db->select('count(*) AS si');
        $this->db->from('_jm_visitados');
        $this->db->where('co_cli', $co_cli);
        $this->db->where('co_ven', $co_ven);
        $this->db->where('fec_vis', $fecha);
        $this->db->where('compro', $compro);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function no_repetir_cli2($co_cli,$fecha,$compro,$co_ven){

        $this->db->select('count(*) AS si');
        $this->db->from('_jm_visitados');
        $this->db->where('co_cli', $co_cli);
        $this->db->where('co_ven <>', $co_ven);
        $this->db->where('fec_vis', $fecha);
        $this->db->where('compro', $compro);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function get_cliente_vali($rif)
    {
        $query = $this->db->query("SELECT RTRIM(c.co_cli) AS co_cli,RTRIM(c.cli_des) AS cli_des,RTRIM(c.rif) AS rif FROM clientes c WHERE c.rif='$rif'");
        return $query->row();
    }

    public function get_cliente_vali2($co_visita)
    {
        $query = $this->db->query("SELECT v.co_visita,v.co_ven,v.co_cli,c.rif,c.cli_des,v.fec_vis,v.compro,v.observacion FROM _jm_visitados v INNER JOIN clientes c ON c.co_cli=v.co_cli WHERE v.co_visita='$co_visita'");
        return $query->row();
    }


   	public function get_client($rif,$nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
   		$where=" ";
      $where1=" ";
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where.=" AND c.rif like '%".$rif."%'"; }

        if (($fini<>"") and ($ffin<>"")) {
                $where1.=" AND fec_vis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
            } else {
                if ($fini<>"") {
                    $fini = date('Y-m-d', strtotime($fini));
                    $where1.=" and   fec_vis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
                } else {
                    if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where1.=" and fec_vis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                    }
                }
            }
			
        	$resultado = $this->db->query("SELECT v.co_visita,c.co_cli, c.cli_des, c.rif, c.direc1, c.telefonos, c.email,c.co_zon, z.zon_des, t.des_tipo,(CASE
    WHEN v.compro=1 THEN 'SI'
    WHEN v.compro=0 THEN 'NO'
    ELSE ''
END) AS compro,m.des_motivo AS observacion,convert(varchar, v.fec_vis, 101) AS fec_vis FROM _jm_visitados v INNER JOIN clientes c ON c.co_cli=v.co_cli $where INNER JOIN zona z ON c.co_zon = z.co_zon INNER JOIN tipo_cli t ON t.tip_cli=c.tipo INNER JOIN _jm_motivo m ON m.co_motivo=v.observacion WHERE v.status=0 AND v.co_ven='$co_ven' $where1  ");

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
