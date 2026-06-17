<?php
	class Advancement_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

        public function obtener_cli($co_cli){
        $query = $this->db->query("SELECT cli_des FROM clientes WHERE co_cli='$co_cli'");
        return $query->row();
    }
    public function obtener_ven($co_ven){
        $query = $this->db->query("SELECT ven_des FROM vendedor WHERE co_ven='$co_ven'");
        return $query->row();
    }

    public function obtener_fpago($codigo){
        $query = $this->db->query("SELECT codigo,descripcion FROM _jm_tip_cob WHERE codigo='$codigo'");
        return $query->row();
    }

    public function obtener_banco($co_ban){
        $query = $this->db->query("SELECT co_ban,des_ban FROM bancos WHERE co_ban='$co_ban'");
        return $query->row();
    }

    public function obtener_cta($cod_cta){
        $query = $this->db->query("SELECT cod_cta,num_cta FROM cuentas c WHERE cod_cta='$cod_cta'");
        return $query->row();
    }

        public function get_cliente($co_cli){
            $query = $this->db->query("SELECT cli_des,rif FROM clientes WHERE co_cli='$co_cli'");
            return $query->row();
        }
        public function get_cxc_monto($facturas){
            $facturas=str_replace("~", ",", $facturas);
            $query = $this->db->query("SELECT FORMAT(SUM(f.tot_neto), 'N', 'de-de') AS monto, FORMAT(SUM(f.saldo), 'N', 'de-de') AS saldo,
f.co_cli,c.cli_des FROM factura f INNER JOIN clientes c ON c.co_cli=f.co_cli 
WHERE f.fact_num IN($facturas) GROUP BY f.co_cli,c.cli_des");
            return $query->row();
        }

        public function get_fpago(){
            $query = $this->db->query("SELECT codigo,descripcion FROM _jm_tip_cob ORDER BY codigo ASC");
            return $query->result();
        }

        public function get_bancos(){
            $query = $this->db->query("SELECT co_ban,des_ban FROM bancos ORDER BY des_ban ASC");
            return $query->result();
        }

        public function get_cuentas(){
            $query = $this->db->query("SELECT c.co_banco,c.cod_cta,c.num_cta,b.des_ban FROM cuentas c INNER JOIN bancos b ON b.co_ban=c.co_banco  ORDER BY b.des_ban ASC");
            return $query->result();
        }

        public function get_cxc($co_cli){
            $query = $this->db->query("SELECT d.tipo_doc, d.nro_doc, convert(varchar, d.fec_emis, 101) AS fec_emis, d.monto_net, d.saldo FROM docum_cc d INNER JOIN clientes c ON d.co_cli = c.co_cli WHERE d.co_cli='$co_cli' AND d.tipo_doc = 'FACT' AND d.saldo > 0 ORDER BY d.fec_emis ASC");
            return $query->result();
        }

        public function obtener_co_cob_tmp(){
        $query = $this->db->query("SELECT (isnull(max(co_cob),0) + 1) AS ultimo FROM _jm_cobros_tmp");
        return $query->row();
      }
    public function obtener_reng_num($co_cob){
        $query = $this->db->query("SELECT (isnull(max(reng_num),0) + 1) AS ultimo FROM _jm_reng_cobros_tmp WHERE co_cob='$co_cob'");
        return $query->row();
    }


        public function add_cobro($co_cob,$co_ven,$codcliente,$pagar,$codformapago,$ndocumento,$fecha,$observacion,$tipo,$banco,$cta){
            $hoy=date('Y-m-d');
      $data = array(
                    'co_cob' => $co_cob,
                    'co_ven' => $co_ven,
                    'co_cli' => $codcliente,
                    'monto' => $pagar,
                    'fec_emis' => $hoy,
                    'fec_pago' => $fecha,
                    'tipo_pago' => $codformapago,
                    'status' => 0,
                    'ndocumento' => $ndocumento,
                    'observacion' => $observacion,
                    'anulada' => 0,
                    'comprobante' => '',
                    'tipo' => $tipo,
                    'co_ban' => $banco,
                    'cod_cta' => $cta
                    );
      $this->db->insert('_jm_cobros_tmp',$data);
      return $this->db->affected_rows();
    }

    public function add_reng_cobro($co_cob,$reng,$factura){
            $hoy=date('Y-m-d');
      $data = array(
                    'co_cob' => $co_cob,
                    'reng_num' => $reng,
                    'fact_num' => $factura
                    );
      $this->db->insert('_jm_reng_cobros_tmp',$data);
      return $this->db->affected_rows();
    }

		
    public function anular($co_cob,$borrado=1){
      $data = array(
                    'anulada' => $borrado
                    );
      $this->db->where('co_cob', $co_cob);
      return $this->db->update('_jm_cobros_tmp', $data);
    }

    public function add_comprobante($co_cob,$comprobante){
      $data = array(
                    'comprobante' => $comprobante
                    );
      $this->db->where('co_cob', $co_cob);
      return $this->db->update('_jm_cobros_tmp', $data);
    }

    public function ver_comprobante($co_cob){
        $query = $this->db->query("SELECT isnull(comprobante,'no.png') AS comprobante FROM _jm_cobros_tmp WHERE co_cob='$co_cob'");
        return $query->row();
      }

    
   	public function get_client($rif,$nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
   		$where=" ";
      $where1=" ";
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where.=" AND c.rif like '%".$rif."%'"; }
        if (($fini<>"") and ($ffin<>"")) {
        //$fini = date('Y-m-d', strtotime($fini));
            //$ffin = date('Y-m-d', strtotime($ffin));
            $where1.=" AND d.fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
        } else {
            if ($fini<>"") {
                $fini = date('Y-m-d', strtotime($fini));
                $where.=" and   d.fec_emis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
            } else {
                if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and d.fec_emis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
                }
            }
        }
			
        	$resultado = $this->db->query("SELECT d.co_cob,d.co_cli, c.cli_des, c.rif,d.monto AS saldo,d.monto, convert(nvarchar, d.fec_emis, 101) AS fec_emis,convert(varchar, d.fec_pago, 101) AS fec_pago,p.descripcion,d.observacion,d.status,b.des_ban FROM _jm_cobros_tmp d INNER JOIN clientes c ON c.co_cli=d.co_cli $where INNER JOIN _jm_tip_cob p ON p.codigo=d.tipo_pago INNER JOIN bancos b ON b.co_ban=d.co_ban WHERE d.co_ven='$co_ven' AND d.anulada = 0 AND d.tipo='ADE' $where1 ORDER BY d.co_cob DESC ");

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
