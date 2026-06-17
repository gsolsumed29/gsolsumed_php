<?php
	class Users_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function login($email, $password, $status=0){
			$query = $this->db->get_where('usuarios', array('usuario'=>$email, 'pass'=>$password, 'status'=>$status));
			return $query->row_array();
		}

    public function validar_usu($usuario,$rif,$correo){
        $query = $this->db->query("SELECT u.idusuario FROM GMOBILE.dbo.usuarios u WHERE u.usuario='$usuario' AND u.correo='$correo' AND u.rif='$rif' ");
            return $query->row();
      }

    public function update_pass($idusuario,$pass){
      $data = array(
                    'pass' => $pass
                    );
      $this->db->where('idusuario', $idusuario);
      return $this->db->update('GMOBILE.dbo.usuarios', $data);
    }

    public function get_empresas($idusuario){
            $query = $this->db->query("SELECT idemp,inicial FROM GMOBILE.dbo.usu_emp WHERE idusuario='$idusuario' AND status=0 ");
            return $query->result();
        }

    public function get_empresa_inicial($idusuario){
            $query = $this->db->query("SELECT TOP 1 idemp,co_ven FROM GMOBILE.dbo.usu_emp WHERE idusuario='$idusuario' AND status=0 AND inicial=1");
            return $query->row();
        }

    public function get_co_ven($idusuario,$idemp){
            $query = $this->db->query("SELECT TOP 1 co_ven FROM GMOBILE.dbo.usu_emp WHERE idusuario='$idusuario' AND idemp='$idemp' AND status=0 ");
            return $query->row();
        }

		
      	public function get_menu($idusuario){
          $query = $this->db->query("SELECT m.id_menu,m.menu,m.url,m.icon,m.orden FROM GMOBILE.dbo.usu_menu u INNER JOIN GMOBILE.dbo.menu m ON m.id_menu=u.id_menu AND m.status=1 WHERE u.idusuario='$idusuario' AND u.status=1 ORDER BY m.orden ASC");
          return $query->result();
        }  

        public function get_submenu($idusuario,$idmenu){
          $query = $this->db->query("SELECT s.id_submenu,s.submenu,s.url,s.icon,s.orden FROM GMOBILE.dbo.usu_submenu u INNER JOIN GMOBILE.dbo.submenu s ON s.id_submenu=u.id_submenu AND s.status=1 WHERE u.idusuario='$idusuario' AND u.id_menu='$idmenu' AND u.status=1 ORDER BY s.orden ASC");
          return $query->result();
        }      	

		public function get_cliente_user($idusuario){
          $query = $this->db->query("SELECT codcliente FROM cliente_user where idusuario=$idusuario AND borrado=0 ");
          return $query->result();
        }

		public function grafica_fact_montos($co_ven){
      if($co_ven == '999'){
        $where=""; 
      }else{
        $where="AND co_ven='$co_ven' ";
      }
            $resultado = $this->db->query("SELECT
SUM(CASE WHEN MONTH(fec_emis)='01' THEN tot_neto ELSE 0 END) AS ene,
SUM(CASE WHEN MONTH(fec_emis)='02' THEN tot_neto ELSE 0 END) AS feb,
SUM(CASE WHEN MONTH(fec_emis)='03' THEN tot_neto ELSE 0 END) AS mar,
SUM(CASE WHEN MONTH(fec_emis)='04' THEN tot_neto ELSE 0 END) AS abr,
SUM(CASE WHEN MONTH(fec_emis)='05' THEN tot_neto ELSE 0 END) AS may,
SUM(CASE WHEN MONTH(fec_emis)='06' THEN tot_neto ELSE 0 END) AS jun,
SUM(CASE WHEN MONTH(fec_emis)='07' THEN tot_neto ELSE 0 END) AS jul,
SUM(CASE WHEN MONTH(fec_emis)='08' THEN tot_neto ELSE 0 END) AS ago,
SUM(CASE WHEN MONTH(fec_emis)='09' THEN tot_neto ELSE 0 END) AS sep,
SUM(CASE WHEN MONTH(fec_emis)='10' THEN tot_neto ELSE 0 END) AS oct,
SUM(CASE WHEN MONTH(fec_emis)='11' THEN tot_neto ELSE 0 END) AS nov,
SUM(CASE WHEN MONTH(fec_emis)='12' THEN tot_neto ELSE 0 END) AS dic
FROM factura WHERE YEAR(fec_emis)=YEAR(GETDATE()) AND anulada=0 $where");

            return $resultado->row();

      }

      public function grafica_art_ven($co_ven){
      if($co_ven == '999'){
        $where=""; 
      }else{
        $where="AND f.co_ven='$co_ven' ";
      }
      $query = $this->db->query("SELECT TOP 5 rtrim(r.co_art) AS co_art,rtrim(a.art_des) AS art_des,SUM(r.total_art) AS cant
FROM factura f INNER JOIN reng_fac r ON r.fact_num=f.fact_num AND r.anulado=0 INNER JOIN art a ON a.co_art=r.co_art
WHERE YEAR(f.fec_emis)=YEAR(GETDATE()) AND MONTH(f.fec_emis)=MONTH(GETDATE()) AND f.anulada=0 $where GROUP BY r.co_art,a.art_des ORDER BY cant DESC");
          return $query->result();

      }

      public function grafica_clientes_visitados($mes,$anio,$co_ven){
			$query = $this->db->query("SELECT 'Visitados' AS nombre,COUNT(distinct c.co_cli) AS cantidad  FROM _jm_visitados v 
INNER JOIN clientes c ON c.co_cli=v.co_cli
WHERE YEAR(v.fec_vis)='$anio' AND MONTH(v.fec_vis)='$mes' AND v.co_cli NOT IN ( SELECT distinct f.co_cli FROM factura f 
WHERE YEAR(f.fec_emis)='$anio' AND MONTH(f.fec_emis)='$mes' AND f.anulada = 0 AND f.co_ven=v.co_ven) 
AND v.co_ven='$co_ven' AND v.compro=0 AND v.status=0
UNION
SELECT 'No Visitados' AS nombre,COUNT(distinct c.co_cli) AS cantidad  FROM clientes c 
WHERE c.co_cli NOT IN ( SELECT distinct f.co_cli FROM factura f 
WHERE YEAR(f.fec_emis)='$anio' AND MONTH(f.fec_emis)='$mes' AND f.anulada = 0 AND f.co_ven='$co_ven')
AND c.co_cli NOT IN ( SELECT distinct f.co_cli FROM cotiz_c f 
WHERE YEAR(f.fec_emis)='$anio' AND MONTH(f.fec_emis)='$mes' AND f.anulada = 0 AND f.co_ven='$co_ven') 
AND c.co_cli NOT IN(SELECT distinct v.co_cli FROM _jm_visitados v 
WHERE YEAR(v.fec_vis)='$anio' AND MONTH(v.fec_vis)='$mes' AND v.co_cli NOT IN ( SELECT distinct f1.co_cli FROM factura f1 
WHERE YEAR(f1.fec_emis)='$anio' AND MONTH(f1.fec_emis)='$mes' AND f1.anulada = 0 AND f1.co_ven='$co_ven') 
AND v.co_ven='$co_ven' AND v.compro=0 AND v.status=0)
AND c.co_ven='$co_ven'
UNION
SELECT 'Facturados' AS nombre,COUNT(distinct c.co_cli) AS cantidad  FROM clientes c
WHERE c.co_cli  IN ( SELECT distinct f.co_cli FROM factura f 
WHERE YEAR(f.fec_emis)='$anio' AND MONTH(f.fec_emis)='$mes' AND f.anulada = 0 AND f.co_ven=c.co_ven) 
AND c.co_ven='$co_ven'
UNION
SELECT 'Ordenes' AS nombre,COUNT(distinct c.co_cli) AS cantidad FROM cotiz_c c 
WHERE year(c.fec_emis) ='$anio' AND month(c.fec_emis)='$mes' AND c.status=0 AND c.anulada=0 AND c.co_ven='$co_ven' AND
c.co_cli  NOT IN ( SELECT distinct f.co_cli FROM factura f 
WHERE YEAR(f.fec_emis)='$anio' AND MONTH(f.fec_emis)='$mes' AND f.anulada = 0 AND f.co_ven=c.co_ven)");
          return $query->result();

      }

	}
?>