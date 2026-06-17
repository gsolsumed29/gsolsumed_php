<?php
  class Rg_model extends CI_Model {
    function __construct(){
      parent::__construct();
      $this->load->database();
    }

    public function get_vendedores(){
          $query = $this->db->query("SELECT co_ven,ven_des FROM vendedor ORDER BY co_ven ASC");
          return $query->result();
    }

    public function get_sucu(){
          $query = $this->db->query("SELECT co_alma,alma_des FROM almacen ORDER BY co_alma ASC");
          return $query->result();
        }

    public function get_facturado($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(monto_bru) AS monto FROM docum_cc WHERE fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND tipo_doc = 'FACT' AND anulado = 0 $where");
          return $query->row();
    }

    public function get_ncr($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(monto_bru) AS monto FROM docum_cc WHERE fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND tipo_doc = 'N/CR' AND anulado = 0 $where ");
          return $query->row();
    }

    public function get_cos_mer($fini,$ffin,$fcosto,$co_sucu){//FILTRO
    	if ($fcosto == 1) { $costo="r.cos_pro_un"; }
    	if ($fcosto == 2) { $costo="r.ult_cos_un"; }
    	if ($fcosto == 3) { $costo="a.pie"; }
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND f.co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(r.total_art * $costo) AS monto FROM factura f INNER JOIN reng_fac r ON f.fact_num = r.fact_num INNER JOIN art a ON r.co_art = a.co_art WHERE f.fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND f.anulada = 0 $where ");
          return $query->row();
    }

    public function get_cos_mer_dev($fini,$ffin,$fcosto,$co_sucu){//FILTRO
    	if ($fcosto == 1) { $costo="r.cos_pro_un"; }
    	if ($fcosto == 2) { $costo="r.ult_cos_un"; }
    	if ($fcosto == 3) { $costo="a.pie"; }
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND f.co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT sum(r.total_art * $costo) AS monto FROM dev_cli f INNER JOIN reng_dvc r ON f.fact_num = r.fact_num INNER JOIN art a ON r.co_art = a.co_art WHERE fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND anulada = 0  $where ");
          return $query->row();
    }

    public function get_gastos($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(monto) AS monto FROM ord_pago WHERE fecha between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND anulada = 0 AND status = 'C' $where ");
          return $query->row();
    }

    public function get_aju_inv_fal($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND a.co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(CASE WHEN r.tipo = 'ENTRAD' THEN (r.total_art * r.cost_unit) ELSE (r.total_art * r.cost_unit) *(-1) END) AS monto 
FROM ajuste a inner join reng_aju r ON a.ajue_num = r.ajue_num 
WHERE r.tipo IN ('ENTRAD', 'SALIDA') AND a.fecha between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND 
CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND r.co_alma not in ('10', '999') and a.motivo not like 'Ajuste por inventario físico.' $where ");
          return $query->row();
    }

    public function get_aju_inv_fis($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND a.co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(CASE WHEN r.tipo = 'ENTRAD' THEN (r.total_art * r.cost_unit) ELSE (r.total_art * r.cost_unit) *(-1) END) AS monto 
FROM ajuste a inner join reng_aju r ON a.ajue_num = r.ajue_num 
WHERE r.tipo IN ('ENTRAD', 'SALIDA') AND a.fecha between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND 
CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND r.co_alma not in ('10', '999') and a.motivo like 'Ajuste por inventario físico.' $where ");
          return $query->row();
    }

    public function get_cajas($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(saldo_a) AS monto FROM cajas WHERE inactivo = 0 $where ");
          return $query->row();
    }

    public function get_bancos($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(saldo_a) AS monto  FROM cuentas WHERE inactivo = 0 $where ");
          return $query->row();
    }

    public function get_inventarios($fini,$ffin,$fcosto,$co_sucu){ //FIltro 
    	if ($fcosto == 1) { $costo="a.cos_pro_un"; }
    	if ($fcosto == 2) { $costo="a.ult_cos_un"; }
    	if ($fcosto == 3) { $costo="a.pie"; }
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND sa.co_alma IN (SELECT co_sub FROM sub_alma WHERE co_alma='$co_sucu') "; }
          $query = $this->db->query("SELECT SUM(sa.stock_act * a.cos_pro_un) AS monto FROM art a INNER JOIN st_almac sa ON a.co_art = sa.co_art $where WHERE sa.co_alma NOT IN ('10', '9999') ");
          return $query->row();
    }

    public function get_cxc($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          //$query = $this->db->query("SELECT ((SELECT SUM(d.saldo) FROM docum_cc d WHERE d.tipo_doc = 'FACT' AND d.saldo > 0) - (SELECT SUM(a.saldo) FROM docum_cc a WHERE a.tipo_doc='ADEL' AND a.saldo > 0)) AS monto ");
          $query = $this->db->query("SELECT SUM(case when TIPO_DOC IN ('N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') THEN saldo * (-1) ELSE saldo END) AS monto FROM docum_cc WHERE saldo > 0 AND tipo_doc IN ('FACT', 'N/DB', 'AJPM', 'AJPA', 'N/CR', 'ADEL', 'ISLR', 'AJNM', 'AJNA') $where ");
          return $query->row();
    }

    public function get_cxp($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT sum(saldo) AS monto FROM docum_cp WHERE fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND saldo > 0 AND anulado = 0 AND tipo_doc = 'FACT' $where ");
          return $query->row();
    }

    public function get_gxp($fini,$ffin,$co_sucu){
      $where=" ";
        if ($co_sucu <> "0") { $where.=" AND co_sucu='$co_sucu' "; }
          $query = $this->db->query("SELECT SUM(monto) AS monto FROM ord_pago WHERE fecha between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110) AND anulada = 0 AND status = 'P' $where ");
          return $query->row();
    }
    public function get_client($nombre,$co_ven,$fini,$ffin){
      $bus   = array("", "+");
      $where1="";
        $where="1=1";
        $groupby="";
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
SUM(r.reng_neto) AS tot_ven
FROM pedidos f INNER JOIN reng_ped r ON f.fact_num=r.fact_num
INNER JOIN art a ON r.co_art=a.co_art $where1
INNER JOIN vendedor v ON f.co_ven=v.co_ven
WHERE $where
GROUP BY r.co_art,a.art_des");

        return $resultado;
      }

  }
?>
