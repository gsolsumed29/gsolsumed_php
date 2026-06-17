<?php
	class Cxc_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

        public function get_cliente($co_cli){
            $query = $this->db->query("SELECT cli_des,rif FROM clientes WHERE co_cli='$co_cli'");
            return $query->row();
        }

        public function get_vendedores(){
          $query = $this->db->query("SELECT co_ven,ven_des FROM vendedor ORDER BY co_ven ASC");
          return $query->result();
        }

        public function get_sucu(){
          $query = $this->db->query("SELECT co_alma,alma_des FROM almacen ORDER BY co_alma ASC");
          return $query->result();
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

        public function get_cajas(){
            $query = $this->db->query("SELECT cod_caja AS cod_cta,descrip AS des_ban, '' AS num_cta,'0' AS co_banco FROM cajas ORDER BY descrip ASC");
            return $query->result();
        }

        public function get_cuentas(){
            $query = $this->db->query("SELECT c.co_banco,c.cod_cta,c.num_cta,b.des_ban FROM cuentas c INNER JOIN bancos b ON b.co_ban=c.co_banco  ORDER BY b.des_ban ASC");
            return $query->result();
        }

        public function add_comprobante($co_cob,$comprobante){
      $data = array(
                    'comprobante' => $comprobante
                    );
      $this->db->where('co_cob', $co_cob);
      return $this->db->update('_jm_cobros_tmp', $data);
    }

        public function get_cxc($co_cli){
            $query = $this->db->query("SELECT d.tipo_doc, d.nro_doc, convert(varchar, d.fec_emis, 101) AS fec_emis, d.monto_net, d.saldo, f.co_sucu,
 CASE
WHEN d.nro_doc >0 AND d.nro_doc <(SELECT s.fact_f1 FROM Sucursales s WHERE s.co_alma=f.co_sucu) THEN (SELECT s.fact_s1 FROM Sucursales s WHERE s.co_alma=f.co_sucu)
WHEN d.nro_doc >=(SELECT s.fact_f1 FROM Sucursales s WHERE s.co_alma=f.co_sucu) AND d.nro_doc <(SELECT s.fact_f2 FROM Sucursales s WHERE s.co_alma=f.co_sucu) THEN (SELECT s.fact_s2 FROM Sucursales s WHERE s.co_alma=f.co_sucu)
WHEN d.nro_doc >=(SELECT s.fact_f2 FROM Sucursales s WHERE s.co_alma=f.co_sucu) AND d.nro_doc <(SELECT s.fact_f3 FROM Sucursales s WHERE s.co_alma=f.co_sucu) THEN (SELECT s.fact_s3 FROM Sucursales s WHERE s.co_alma=f.co_sucu)
WHEN d.nro_doc >=(SELECT s.fact_f3 FROM Sucursales s WHERE s.co_alma=f.co_sucu) AND d.nro_doc <(SELECT s.fact_f4 FROM Sucursales s WHERE s.co_alma=f.co_sucu) THEN (SELECT s.fact_s4 FROM Sucursales s WHERE s.co_alma=f.co_sucu)
Else ''
END AS serie,
RIGHT(d.nro_doc, 5) AS fact FROM docum_cc d INNER JOIN clientes c ON d.co_cli = c.co_cli INNER JOIN factura f ON f.fact_num = d.nro_doc WHERE d.co_cli='$co_cli' AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') AND d.saldo > 0 ORDER BY d.fec_emis ASC");
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

    public function obtener_caja($cod_caja){
        $query = $this->db->query("SELECT cod_caja AS cod_cta,'' AS num_cta FROM cajas WHERE cod_caja='$cod_caja'");
        return $query->row();
    }

    public function obtener_banco2($co_ban){
        $query = $this->db->query("SELECT '' AS co_ban,'CAJA EFECTIVO' AS des_ban ");
        return $query->row();
    }

    public function obtener_cta($cod_cta){
        $query = $this->db->query("SELECT cod_cta,num_cta FROM cuentas c WHERE cod_cta='$cod_cta'");
        return $query->row();
    }

    public function obtener_config_email($id=1){
        $query = $this->db->query("SELECT c.email,c.password,c.host,c.port,c.smtpsecure,c.debug FROM GMOBILE.dbo.config_email c WHERE c.id='$id' ");
        return $query->row();
    }


        public function add_cobro($co_cob,$co_ven,$codcliente,$pagar,$codformapago,$ndocumento,$fecha,$observacion,$banco,$tipo,$cta){
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

		
    public function delete_cli($codcliente,$borrado){
      $data = array(
                    'borrado' => $borrado
                    );
      $this->db->where('codcliente', $codcliente);
      return $this->db->update('clientes', $data);
    }

    
    public function delete_invoice_detalle($codfactura){
           return $query = $this->db->delete('factulinea', array('codfactura' => $codfactura));
            //return $query->result();
        }

    
   	public function get_client($rif,$nombre,$co_ven,$co_sucu){
      $bus   = array("", "+");
   		$where=" ";
        $where1=" ";
        if ($co_sucu <> "") { $where1.=" AND d.co_sucu='$co_sucu' "; }
        if($co_ven == '999'){
        }else{
          $where.=" AND c.co_ven='$co_ven' ";
        }
		    if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND c.cli_des like '%".$nombre."%'"; }
        if ($rif <> "") { $direccion=str_replace($bus, "%", $rif); $where.=" AND c.rif like '%".$rif."%'"; }
			
        /*	$resultado = $this->db->query("SELECT d.co_cli, c.cli_des, c.rif, SUM(d.saldo) AS saldo1,
ISNULL((SELECT SUM(a.saldo) FROM docum_cc a WHERE a.co_cli=d.co_cli AND a.tipo_doc='ADEL' AND a.saldo > 0),0) AS adelanto,
(ISNULL((SELECT SUM(a.saldo) FROM docum_cc a WHERE a.co_cli=d.co_cli AND a.tipo_doc='ADEL' AND a.saldo > 0),0) -  SUM(d.saldo)) AS saldo
FROM docum_cc d INNER JOIN clientes c ON c.co_cli=d.co_cli  $where
WHERE d.tipo_doc = 'FACT' AND d.saldo > 0 GROUP BY d.co_cli,c.cli_des,c.rif ORDER BY c.cli_des ASC ");*/

        	$resultado = $this->db->query("SELECT d.co_cli, c.cli_des, c.rif, SUM(case when d.TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN d.saldo * (-1) ELSE d.saldo END) as saldo
FROM docum_cc d INNER JOIN clientes c ON c.co_cli=d.co_cli $where
WHERE d.saldo > 0 AND d.tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') $where1
GROUP BY d.co_cli,c.cli_des,c.rif ORDER BY c.cli_des ASC ");

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
