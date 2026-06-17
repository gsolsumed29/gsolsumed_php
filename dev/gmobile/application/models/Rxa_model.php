<?php
  class Rxa_model extends CI_Model {
    function __construct(){
      parent::__construct();
      $this->load->database();
    }

    public function get_articles($codigo,$nombre){
      $bus   = array("", "+");
      $where="1=1";
        if ($codigo <> "") { $codigo=str_replace($bus, "%", $codigo); $where.=" AND a.co_art like '%".$codigo."%'"; }
        if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND a.art_des like '%".$nombre."%'"; }
        
          $resultado = $this->db->query("SELECT a.co_art, a.art_des, a.tipo, t.stock_act, a.prec_vta1, a.prec_vta2,a.prec_vta3, a.prec_vta4, a.prec_vta5, a.prec_agr1, a.tipo_imp, a.stock_com,a.ult_cos_un,a.cos_pro_un FROM art a INNER JOIN st_almac t ON t.co_art=a.co_art AND t.co_alma='01' WHERE $where AND a.tipo = 'V' ORDER BY a.co_art ASC");

        return $resultado;
      }

  }
?>
