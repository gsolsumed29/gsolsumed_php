<?php
	class Orders_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

    public function obtener_fact_num(){
        $query = $this->db->query("SELECT (isnull(max(fact_num),0) + 1) AS ultimo FROM cotiz_c_tmp");
        return $query->row();
      }
    public function obtener_fact_num2(){
        $query = $this->db->query("SELECT (isnull(max(fact_num),0) + 1) AS ultimo FROM pedidos");
        return $query->row();
      }
    public function obtener_fact_num3(){
        $query = $this->db->query("SELECT (isnull(max(fact_num),0) + 1) AS ultimo FROM pedidos");
        return $query->row();
      }
    public function obtener_stock_com($co_art){
        $query = $this->db->query("SELECT stock_com FROM art WHERE co_art='$co_art' ");
        return $query->row();
      }
    public function obtener_stock_com_st($co_art,$co_alma){
        $query = $this->db->query("SELECT stock_com FROM st_almac WHERE co_alma='$co_alma' AND co_art='$co_art' ");
        return $query->row();
      }
    public function update_stock_com($co_art,$stock_com){
      $data = array(
                    'stock_com' => $stock_com
                    );
      $this->db->where('co_art', $co_art);
      return $this->db->update('art', $data);
    }
    public function update_stock_com_st($co_art,$stock_com,$co_alma){
      $data = array(
                    'stock_com' => $stock_com
                    );
      $this->db->where('co_alma', $co_alma);
      $this->db->where('co_art', $co_art);
      return $this->db->update('st_almac', $data);
    }
    public function obtener_reng_num($fact_num){
        $query = $this->db->query("SELECT (isnull(max(reng_num),0) + 1) AS ultimo FROM reng_cac_tmp WHERE fact_num='$fact_num'");
        return $query->row();
    }
    public function obtener_reng_num2($fact_num){
        $query = $this->db->query("SELECT (isnull(max(reng_num),0) + 1) AS ultimo FROM reng_ped WHERE fact_num='$fact_num'");
        return $query->row();
    }
    public function obtener_art($co_art){
        $query = $this->db->query("SELECT a.co_art,a.co_sucu,a.uni_venta,a.prec_vta1,a.tipo_imp,a.cos_pro_un,a.ult_cos_un,ISNULL((s.stock_act),0) AS stock_act FROM art a INNER JOIN st_almac s ON s.co_art=a.co_art AND s.co_alma='01' WHERE a.co_art='$co_art'");
        return $query->row();
    }
    public function no_repetir_art($fact_num,$co_art){
        $query = $this->db->query("SELECT COUNT(*) AS si FROM reng_cac_tmp WHERE fact_num='$fact_num' AND co_art='$co_art'");
        return $query->row();
    }
    public function cantidad_art($fact_num,$co_art){
        $query = $this->db->query("SELECT CAST(ROUND(isnull(total_art,0),2)AS NUMERIC(12,2)) AS cantidad FROM reng_cac_tmp WHERE fact_num='$fact_num' AND co_art='$co_art'");
        return $query->row();
    }
    public function obtener_reng_num_cantidad($fact_num,$co_art){
        $query = $this->db->query("SELECT CAST(ROUND((isnull(total_art,0) + 1),2)AS NUMERIC(12,2)) AS ultimo,CAST(ROUND((prec_vta * (isnull(total_art,0) + 1)),2)AS NUMERIC(12,2)) AS neto FROM reng_cac_tmp WHERE fact_num='$fact_num' AND co_art='$co_art'");
        return $query->row();
    }
    public function obtener_reng_num_cantidad_restar($fact_num,$co_art){
        $query = $this->db->query("SELECT CAST(ROUND((isnull(total_art,0) - 1),2)AS NUMERIC(12,2)) AS ultimo,CAST(ROUND((prec_vta * (isnull(total_art,0) - 1)),2)AS NUMERIC(12,2)) AS neto FROM reng_cac_tmp WHERE fact_num='$fact_num' AND co_art='$co_art'");
        return $query->row();
    }
    public function obtener_reng_num_cantidad2($fact_num,$co_art,$cantidad){
        $query = $this->db->query("SELECT CAST(ROUND(($cantidad),2)AS NUMERIC(12,2)) AS ultimo,CAST(ROUND((prec_vta * $cantidad),2)AS NUMERIC(12,2)) AS neto FROM reng_cac_tmp WHERE fact_num='$fact_num' AND co_art='$co_art'");
        return $query->row();
    }

    public function obtener_invoice($fact_num){
        $comilla='"';
        $query = $this->db->query("SELECT f.fact_num,convert(varchar, f.fec_emis, 101) AS fec_emis,convert(varchar, f.fec_venc, 101) AS fec_venc,f.co_cli,f.co_ven,f.forma_pag,c.rif,REPLACE(c.cli_des, '$comilla','') AS cli_des,f.descrip,f.forma_pag,f.status FROM pedidos f INNER JOIN clientes c ON c.co_cli=f.co_cli WHERE f.fact_num='$fact_num'");
        return $query->row();
        }

    public function getmesas(){
        $query = $this->db->query('SELECT codigo,nombre,numero FROM _jm_mesa ORDER BY codigo ASC');
        return $query->result();
    }
    public function getmesasdispo(){
        $query = $this->db->query('SELECT codigo,nombre,numero FROM _jm_mesa ORDER BY codigo ASC');
        return $query->result();
    }
    public function getvendedores(){
        $query = $this->db->query('SELECT co_ven,ven_des FROM vendedor ORDER BY co_ven ASC');
        return $query->result();
    }
    public function getcondicion(){
        $query = $this->db->query('SELECT co_cond,cond_des,dias_cred FROM condicio ORDER BY cond_des ASC');
        return $query->result();
    }

    public function getcat_art(){
        $query = $this->db->query("SELECT co_lin AS co_subl, lin_des AS subl_des FROM lin_art WHERE co_lin IN (SELECT DISTINCT co_lin FROM art WHERE co_cat LIKE '01') ORDER BY lin_des ASC");
        return $query->result();
    }
	
    public function getultimopedido(){
        $query = $this->db->query("SELECT (max(fact_num) + 1) AS ultimo FROM pedidos");
        return $query->row();
      }

    public function get_cliente($co_cli){
        $query = $this->db->query("SELECT cli_des FROM clientes WHERE co_cli='$co_cli'");
        return $query->row();
      }

    public function get_art($co_art){
        $query = $this->db->query("SELECT co_art,'01' AS co_alma,'1' AS cantidad,uni_venta,prec_vta1 FROM art WHERE co_art='$co_art'");
        return $query->row();
      }

    public function add_pedido($ultimo,$mesa,$vendedor,$condicion,$codcliente,$cli_des){
        $fechita=date('y-m-d');
      $data = array(
                    'fact_num' => $ultimo,
                    'status' => 0,
                    'descrip' => $cli_des,
                    'saldo' => 0,
                    'fec_emis' => $fechita,
                    'fec_venc' => $fechita,
                    'co_cli' => $codcliente,
                    'co_ven' => $vendedor,
                    'co_tran' => $mesa,
                    'forma_pag' => $condicion
                    );
      $this->db->insert('pedidos',$data);
      return $this->db->insert_id();
    }

    public function add_reng_ped($ultimo,$reng_num,$co_art,$co_alma,$uni_venta,$prec_vta1,$cantidad){
        $fechita=date('Y-m-d H:i:s');
      $data = array(
                    'fact_num' => $ultimo,
                    'reng_num' => $reng_num,
                    'reng_doc' => 0,
                    'num_doc' => 0,
                    'co_art' => $co_art,
                    'co_alma' => $co_alma,
                    'total_art' => $cantidad,
                    'uni_venta' => $uni_venta,
                    'prec_vta' => $prec_vta1,
                    'reng_neto' => $prec_vta1
                    );
      $this->db->insert('reng_ped',$data);
      return $this->db->insert_id();
    }

    public function get_anular($codfactura){
        $query = $this->db->query("SELECT COUNT(*) AS si FROM cobros WHERE codfactura=$codfactura");
        return $query->row();
      }
    public function get_anular2($codfactura){
        $query = $this->db->query("SELECT COUNT(*) AS si FROM vista_revertir WHERE codfactura=$codfactura AND procesar > 0");
        return $query->row();
      }

    public function tipo_precio($codcliente){
        $query = $this->db->query("SELECT SUBSTRING(t.precio_a, 8, 1) AS tipo FROM clientes c INNER JOIN tipo_cli t ON t.tip_cli=c.tipo WHERE c.co_cli='$codcliente' ");
        return $query->row();
      }

      public function anular_fact($codfactura,$borrado=1){
      $data = array(
                    'anulada' => $borrado
                    );
      $this->db->where('fact_num', $codfactura);
      return $this->db->update('pedidos', $data);
    }
   		public function obtener_invoicetmp($tmp,$co_ven){
			$fecha = date('Y-m-d');
			$data = array(
                    'fact_num' => $tmp,
                    'fecha' => $fecha,
                    'co_ven' => $co_ven
                    );
			$this->db->insert('cotiz_c_tmp',$data);
			//return $this->db->insert_id();
            return $this->db->affected_rows();
		}
		public function get_det_tmp($codfacturatmp){
            $this->db->select("r.fact_num,r.reng_num,r.co_art,a.art_des,FORMAT(r.prec_vta, 'N', 'de-de') AS prec_vta,FORMAT(r.total_art, 'N', 'de-de') AS total_art,FORMAT(r.reng_neto, 'N', 'de-de') AS reng_neto");
        $this->db->from('reng_cac_tmp r');
        $this->db->join('art a', 'a.co_art=r.co_art');
            $this->db->where('r.fact_num', $codfacturatmp);
            //$this->db->where('status', '1');
            $this->db->order_by('r.reng_num', 'asc');
            //$this->db->limit(5, 0);
            return $this->db->get();
        }
        public function get_det_adm2($codfactura){
            $query = $this->db->query("SELECT al.codfactura,al.numlinea,al.codfamilia,al.codigo,e.Nom_exa,al.excento,FORMAT(al.cantidad,2,'de_DE') AS cantidad,FORMAT(al.precio,2,'de_DE') AS precio,FORMAT(al.importe,2,'de_DE') AS importe,FORMAT(al.dcto,2,'de_DE') AS dcto,al.status FROM factulinea al INNER JOIN examenes e ON e.IDExa=al.codigo WHERE al.codfactura='$codfactura' ORDER BY al.numlinea ASC");
            return $query->result();
        }
        public function get_det_adm($codfacturatmp){
            $this->db->select("r.fact_num,r.reng_num,r.co_art,a.art_des,FORMAT(r.prec_vta, 'N', 'de-de') AS prec_vta,FORMAT(r.total_art, 'N', 'de-de') AS total_art,FORMAT(r.reng_neto, 'N', 'de-de') AS reng_neto");
        $this->db->from('reng_ped r');
        $this->db->join('art a', 'a.co_art=r.co_art');
            $this->db->where('r.fact_num', $codfacturatmp);
            //$this->db->where('status', '1');
            $this->db->order_by('r.reng_num', 'asc');
            //$this->db->limit(5, 0);
            return $this->db->get();
        }
        public function get_det_tmp2($codfacturatmp){
            $query = $this->db->query("SELECT fact_num,reng_num,co_art,co_alma,total_art,pendiente,uni_venta,prec_vta,tipo_imp,reng_neto,cos_pro_un,ult_cos_un,fec_lote FROM reng_cac_tmp WHERE fact_num='$codfacturatmp' ORDER BY reng_num ASC");
            return $query->result();
        }
        public function get_det_ped($codfacturatmp){
            $query = $this->db->query("SELECT fact_num,reng_num,co_art,co_alma,total_art,pendiente FROM reng_ped WHERE fact_num='$codfacturatmp' ORDER BY reng_num ASC");
            return $query->result();
        }
        public function get_delete_det_factura($codfacturatmp){
            $this->db->select("e.id,d.cantidad,e.stock");
            $this->db->from('delete_det_factura d');
            $this->db->join('examenes e', 'e.IDExa=d.codigo');
            $this->db->where('d.codfacturatmp', $codfacturatmp);
            return $this->db->get();
        }
        public function getcategorias(){
        	$query = $this->db->query("SELECT co_art,art_des,co_lin as co_subl,prec_vta1,prec_vta2,prec_vta3,prec_vta4,prec_vta5,modelo,stock_act,campo1,uni_venta, ubicacion FROM art WHERE co_cat in('01')  ORDER BY co_art ASC");
        	return $query->result();
        }
        public function getcategorias2(){
            $query = $this->db->query("SELECT l.co_subl,l.subl_des FROM art a INNER JOIN sub_lin l ON l.co_subl=a.co_lin GROUP BY l.co_subl,l.subl_des");
            return $query->result();
        }
       
        //SELECT stock_act FROM st_almac WHERE co_art='0740'  and co_alma in (select co_sub from sub_alma where campo1='*') 
        public function getarticulos($codigo,$descripcion,$categorias){
        	if($codigo == '-' && $descripcion == '-'){
        		$codigo='';
        		$descripcion='';
        	}
        	$where="1=1";
        	if ($categorias<>0) { $where.=" AND a.co_lin='$categorias'"; }
        	if ($codigo<>"-") { $where.=" AND a.co_art like '%$codigo%'"; }
        	if ($descripcion<>"-") { $where.=" AND a.art_des like '%$descripcion%'"; }
        	$query = $this->db->query("SELECT a.co_art, a.art_des, a.tipo,ISNULL(t.stock_act,0) AS stock_act, a.prec_vta1, a.prec_vta2, a.prec_vta3, a.prec_vta4, a.prec_vta5, a.prec_agr1, a.tipo_imp,a.modelo,a.campo1,a.uni_venta,a.ubicacion,a.co_subl FROM art a LEFT JOIN st_almac t ON t.co_art=a.co_art AND t.co_alma='01' WHERE $where AND a.tipo = 'V' ORDER BY a.co_lin ASC, a.art_des ASC");
        	return $query->result();
        }
        public function getarticuloscat($categoria){
            $query = $this->db->query("SELECT co_art,art_des,co_lin as co_subl,prec_vta1,prec_vta2,prec_vta3,prec_vta4,prec_vta5,modelo,stock_act,campo1,uni_venta, ubicacion FROM art WHERE co_cat in('001') AND co_lin='$categoria'  ORDER BY co_art ASC");
            return $query->result();
        }
        public function getclientes($rif,$nombre,$co_ven){
        	if($rif == '-'){
        		$rif="";
        	}
            if($nombre == '-'){
                $nombre="";
            }
            $nombre=str_replace("%20", "%", $nombre);
        	$where="";
            $comilla='"';
        	if ($rif<>"") { $where.=" AND c.rif like '%$rif%'"; }
        	if ($nombre<>"") { $where.=" AND c.cli_des like '%$nombre%'"; }
        	$query = $this->db->query("SELECT c.co_cli,c.cli_des,c.rif FROM clientes c WHERE c.inactivo=0 AND c.co_ven='$co_ven' $where  ORDER BY c.cli_des ASC");
        	return $query->result();
        }
        public function get_modif_art($fact_num,$reng_num){
        	$query = $this->db->query("SELECT r.fact_num,r.reng_num,r.co_art,a.art_des,r.prec_vta,r.total_art FROM reng_cac_tmp r INNER JOIN art a ON a.co_art=r.co_art WHERE  r.fact_num='$fact_num' AND r.reng_num='$reng_num' ");
        	return $query->result();
        }
        public function add_det_tmp($codfacturatmp,$reng_num,$codarticulo,$co_alma,$cantidad,$pendiente,$uni_venta,$prec_vta1,$tipo_imp,$reng_neto,$cos_pro_un,$ult_cos_un,$fecha){

        	$query = $this->db->query("INSERT INTO reng_cac_tmp (fact_num,reng_num,co_art,co_alma,total_art,pendiente,uni_venta,prec_vta,tipo_imp,reng_neto,cos_pro_un,ult_cos_un, fec_lote) VALUES($codfacturatmp,'$reng_num','$codarticulo','$co_alma','$cantidad','$pendiente','$uni_venta','$prec_vta1','$tipo_imp','$reng_neto','$cos_pro_un','$ult_cos_un',CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fecha',110),110))");
        return $this->db->affected_rows();
      /*$data = array(
                    'fact_num' => $codfacturatmp,
                    'reng_num' => $reng_num,
                    'co_art' => $codarticulo,
                    'co_alma' => $co_alma,
                    'total_art' => $cantidad,
                    'pendiente' => $pendiente,
                    'uni_venta' => $uni_venta,
                    'prec_vta' => $prec_vta1,
                    'tipo_imp' => $tipo_imp,
                    'reng_neto' => $reng_neto,
                    'cos_pro_un' => $cos_pro_un,
                    'ult_cos_un' => $ult_cos_un,
                    'fec_lote' => 'CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '.$fecha.',110),110)'
                    );
      $this->db->insert('reng_cac_tmp',$data);
      //return $this->db->insert_id();
      //$data['lastid'] = $this->db->insert_id();
    return $this->db->affected_rows();*/
    }
    public function delete_art($codigo,$codfacturatmp){
      $this->db->where('fact_num', $codfacturatmp);
      $this->db->where('co_art', $codigo);
      return $this->db->delete('reng_cac_tmp');
    }
    public function delete_art_fact($codigo,$codfacturatmp,$codfactura,$cantidad){
      $data = array(
                    'codfacturatmp' => $codfacturatmp,
                    'codigo' => $codigo,
                    'codfactura' => $codfactura,
                    'cantidad' => $cantidad
                    );
      $this->db->insert('delete_det_factura',$data);
      return $this->db->insert_id();
    }
    public function add_cli($rif,$nombre,$sexo,$fn,$direccion,$movil,$telefono,$email,$borrado=0){
      $data = array(
      				'nombre' => $nombre,
                    'nif' => $rif,
                    'direccion' => $direccion,
                    'sexo' => $sexo,
                    'fn' => $fn,
                    'codprovincia' => 0,
                    'localidad' => '',
                    'codformapago' => 0,
                    'codentidad' => 0,
                    'cuentabancaria' => '',
                    'codpostal' => 0,
                    'telefono' => $telefono,
                    'movil' => $movil,
                    'email' => $email,
                    'web' => '',
                    'empresa' => 0,
                    'condicion' => 0,
                    'borrado' => $borrado,
                    'saldo' => 0
                    );
      $this->db->insert('clientes',$data);
      return $this->db->insert_id();
    }
    public function update_det_tmp($codfacturatmp,$codarticulo,$cantidad,$reng_neto){
      $data = array(
                    'total_art' => $cantidad,
                    'pendiente' => $cantidad,
                    'reng_neto' => $reng_neto
                    );
      $this->db->where('fact_num', $codfacturatmp);
      $this->db->where('co_art', $codarticulo);
      $this->db->update('reng_cac_tmp', $data);
      return $this->db->affected_rows();
    }
    public function update_stock($id,$cantidad,$stock){
      $stock_new=($stock - $cantidad);
      $data = array(
                    'stock' => $stock_new
                    );
      $this->db->where('id', $id);
      return $this->db->update('examenes', $data);
    }
    public function revertir_stock($id,$cantidad,$stock){
      $stock_new=($stock + $cantidad);
      $data = array(
                    'stock' => $stock_new
                    );
      $this->db->where('id', $id);
      return $this->db->update('examenes', $data);
    }
    public function iva_art($codarticulo){
        $this->db->select('e.inventario,e.stock,e.excento,i.valor AS iva');
        $this->db->from('examenes e');
        $this->db->join('impuestos i', 'i.codimpuesto=e.codimpuesto');
        $this->db->where('IDExa', $codarticulo);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }
    public function datos_examenes($codfactura){
        $this->db->select('fl.codfactura,fl.numlinea,fl.codigo,e.nom_exa');
        $this->db->from('factulinea fl');
        $this->db->join('examenes e', 'e.idexa=fl.codigo');
        $this->db->where('fl.codfactura', $codfactura);
        $this->db->where('fl.status', '1');
        $this->db->order_by('e.idcenpro', 'asc');
        $this->db->order_by('e.ord_imp', 'asc');
        $this->db->limit(1, 0);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }
    public function cantidad_examen($codfactura){
        $this->db->select('count(*) AS si');
        $this->db->from('factulinea fl');
        $this->db->join('examenes e', 'e.idexa=fl.codigo');
        $this->db->where('fl.codfactura', $codfactura);
        $this->db->where('fl.status', '1');
        $this->db->order_by('e.idcenpro', 'asc');
        $this->db->order_by('e.ord_imp', 'asc');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }
      public function formato_examen($codexamen){
        $this->db->select('e.IDFor,v.nombre,f.calculo');
        $this->db->from('examenes e');
        $this->db->join('vista_formatos v', 'v.IDFor=e.IDFor');
        $this->db->join('formatos f', 'f.IDFor=e.IDFor');
        $this->db->where('e.IDExa', $codexamen);
        $this->db->order_by('v.tab', 'asc');
        $this->db->limit(1, 0);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }

     public function no_repetir_cli($rif,$borrado=0){
        $this->db->select('count(*) AS si');
        $this->db->from('clientes');
        $this->db->where('nif', $rif);
        $this->db->where('borrado', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }
    public function feriados($dia,$mes,$borrado=0){
        $this->db->select('count(*) AS si');
        $this->db->from('feriados');
        $this->db->where('dia', $dia);
        $this->db->where('mes', $mes);
        $this->db->where('borrado', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }
    public function get_cliente_vali($rif)
    {
        $query = $this->db->query("SELECT RTRIM(c.co_cli) AS co_cli,RTRIM(c.cli_des) AS cli_des,RTRIM(c.rif) AS rif,(SELECT COUNT(*) FROM pedidos WHERE co_cli=c.co_cli AND anulada=0 AND status=0) AS pedido FROM clientes c WHERE c.rif='$rif'");
        return $query->row();
    }
    public function get_update_totales($fact_num)
    {
        $query = $this->db->query("SELECT FORMAT(SUM(reng_neto), 'N', 'de-de') AS subtotal,FORMAT(CAST(ROUND(SUM(iva),2)AS NUMERIC(12,2)), 'N', 'de-de') AS impuesto,FORMAT((SUM(reng_neto) - SUM(excento)), 'N', 'de-de') AS excento,FORMAT((CAST(ROUND(SUM(iva),2)AS NUMERIC(12,2)) + (SUM(reng_neto) - (SUM(reng_neto) - SUM(excento)))), 'N', 'de-de') AS total,(CAST(ROUND(SUM(iva),2)AS NUMERIC(12,2)) + (SUM(reng_neto) - (SUM(reng_neto) - SUM(excento)))) AS totales,CAST(SUM(iva) AS NUMERIC(12,2)) AS impuestos,SUM(reng_neto) AS subtotales FROM View_reng_cac_tmp WHERE fact_num='$fact_num' GROUP BY fact_num");
        return $query->row();
    	
    }
    public function get_update_totales2($fact_num)
    {
      $query = $this->db->query("SELECT FORMAT(SUM(reng_neto), 'N', 'de-de') AS subtotal,FORMAT(CAST(ROUND(SUM(iva),2)AS NUMERIC(12,2)), 'N', 'de-de') AS impuesto,FORMAT((SUM(reng_neto) - SUM(excento)), 'N', 'de-de') AS excento,FORMAT((CAST(ROUND(SUM(iva),2)AS NUMERIC(12,2)) + (SUM(reng_neto) - (SUM(reng_neto) - SUM(excento)))), 'N', 'de-de') AS total,(CAST(ROUND(SUM(iva),2)AS NUMERIC(12,2)) + (SUM(reng_neto) - (SUM(reng_neto) - SUM(excento)))) AS totales,CAST(SUM(iva) AS NUMERIC(12,2)) AS impuestos,SUM(reng_neto) AS subtotales FROM View_reng_ped WHERE fact_num='$fact_num' GROUP BY fact_num");
        return $query->row();
    }
    public function add_det_invoice($fact_num,$reng_num,$co_art,$co_alma,$total_art,$pendiente,$uni_venta,$prec_vta,$tipo_imp,$reng_neto,$cos_pro_un,$ult_cos_un,$fec_lote){
        /*$query = $this->db->query("INSERT INTO reng_cac (fact_num,reng_num,co_art,co_alma,total_art,pendiente,uni_venta,prec_vta,tipo_imp,reng_neto,cos_pro_un,ult_cos_un, fec_lote) VALUES($fact_num,'$reng_num','$co_art','01','$total_art','$pendiente','$uni_venta','$prec_vta','$tipo_imp','$reng_neto','$cos_pro_un','$ult_cos_un',CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fec_lote',110),110))");*/
    	$query = $this->db->query("INSERT INTO reng_ped (fact_num,reng_num,co_art,co_alma,total_art,pendiente,uni_venta,prec_vta,tipo_imp,reng_neto,cos_pro_un,ult_cos_un,anulado, fec_lote) VALUES($fact_num,'$reng_num','$co_art','01','$total_art','$pendiente','$uni_venta','$prec_vta','$tipo_imp','$reng_neto','$cos_pro_un','$ult_cos_un',0,CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fec_lote',110),110))");
        return $this->db->affected_rows();
    }
    public function add_invoice($fact_num,$observacion,$saldo,$fec_emis,$fec_venc,$co_cli,$co_ven,$co_tran,$forma_pag,$tot_bruto, $tot_neto, $iva,$co_us_in,$fe_us_in,$co_sucu,$tasa,$moneda,$tasag,$tasag10,$tasag20,$status,$contrib){
        /*$query = $this->db->query("INSERT INTO cotiz_c (fact_num,comentario,saldo,fec_emis,fec_venc,co_cli,co_ven,co_tran,forma_pag,tot_bruto, tot_neto, iva,co_us_in,fe_us_in,co_sucu,tasa,moneda,tasag,tasag10,tasag20,status,contrib) VALUES($fact_num,'$observacion',$saldo,CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fec_emis',110),110),CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fec_venc',110),110),'$co_cli','$co_ven','$co_tran','$forma_pag',$tot_bruto, $tot_neto, $iva,'$co_us_in',$fe_us_in,'$co_sucu',$tasa,'$moneda',$tasag,$tasag10,$tasag20,$status,$contrib)");*/
        $query = $this->db->query("INSERT INTO pedidos (fact_num, contrib, status, saldo, fec_emis, fec_venc, co_cli, co_ven, co_tran, forma_pag, tot_bruto, tot_neto, anulada, iva, tasa, moneda, co_sucu, descrip, glob_desc, porc_gdesc) VALUES($fact_num,$contrib,$status,$saldo,CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fec_emis',110),110),CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fec_venc',110),110),'$co_cli','$co_ven','$co_tran','$forma_pag',$tot_bruto, $tot_neto,0, $iva,$tasa,'$moneda','$co_sucu','$observacion',0,0)");
        return $this->db->affected_rows();
    }
    public function add_cobro($codfactura,$codcliente,$pagar,$codformapago,$codentidad,$ndocumento,$fecha,$observacion){
      $data = array(
                    'codfactura' => $codfactura,
                    'codcliente' => $codcliente,
                    'importe' => $pagar,
                    'codformapago' => $codformapago,
                    'codentidad' => $codentidad,
                    'numdocumento' => $ndocumento,
                    'fechacobro' => $fecha,
                    'observaciones' => $observacion
                    );
      $this->db->insert('cobros',$data);
      return $this->db->insert_id();
    }
    public function update_invoice0($fact_num,$pendiente, $estado){
      $data = array(
                    'saldo' => $pendiente,
                    'estado' => $estado
                    );
      $this->db->where('codfactura', $invoice);
      return $this->db->update('facturas', $data);
    }
    public function update_invoice($fact_num,$fechita,$fechitav,$co_cli,$observacion,$preciototal,$baseimponible, $baseimpuestos,$condicion){
        $query = $this->db->query("UPDATE pedidos SET saldo=$preciototal, fec_emis=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fechita',110),110), fec_venc=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fechitav',110),110), co_cli='$co_cli', forma_pag='$condicion', tot_bruto=$baseimponible, tot_neto=$preciototal, iva=$baseimpuestos, descrip='$observacion' WHERE fact_num='$fact_num'");
        return $this->db->affected_rows();
    }
    public function delete_invoice_detalle($codfactura){
           return $query = $this->db->delete('reng_ped', array('fact_num' => $codfactura));
            //return $query->result();
        }
    public function datos_cobros_report($admision,$fini,$ffin,$estado,$condicion,$nif,$nif2,$nombre,$nombre2){
        $where="1=1";
        $where1="";
        $where2="";
        if ($nif <> "-") { $where1.=" AND c.nif='$nif'"; }
        if ($nombre <> "-") { $where1.=" AND c.nombre like '%".$nombre."%'"; }
        if ($nif2 <> "-") { $where2.=" AND p.nif='$nif2'"; }
        if ($nombre2 <> "-") { $where2.=" AND p.nombre like '%".$nombre2."%'"; }
        if ($condicion <> "-") { $where.=" AND a.condicion='$condicion'"; }
        if ($admision <> "-") { $where.=" AND a.codfactura='$admision'"; }
        if ($estado > "0") { $where.=" AND a.estado='$estado'"; }
        if (($fini<>"") and ($ffin<>"")) {
            $fini = date('Y-m-d', strtotime($fini));
            $ffin = date('Y-m-d', strtotime($ffin));
            $where.=" AND a.fecha between '".$fini."' AND '".$ffin."'";
        } else {
            if ($fini<>"") {
                $fini = date('Y-m-d', strtotime($fini));
                $where.=" and   a.fecha>='".$fini."'";
            } else {
                if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and a.fecha<='".$ffin."'";
                }
            }
        }
$query = $this->db->query("SELECT a.codfactura,a.fecha,a.codcliente,c.nif,c.nombre,p.nif AS ci,p.nombre AS paciente,a.condicion,a.fechavencimiento,FORMAT(a.saldo,2,'de_DE') AS saldo,FORMAT(a.totalfactura,2,'de_DE') AS totalfactura,a.totalfactura AS total,a.saldo AS pendiente,a.estado,a.borrado,a.observacion,(CASE WHEN a.estado = 0 THEN 'En Espera'
  WHEN a.estado = 1 THEN 'Sin Pagar'
  WHEN a.estado = 2 THEN 'Pagada'
  WHEN a.estado = 3 THEN 'Pausado'
  WHEN a.estado = 4 THEN 'Anulada'
  ELSE 'Error'
END) AS status_msg,(CASE
  WHEN a.estado = 0 THEN 'badge badge-primary'
  WHEN a.estado = 1 THEN 'badge badge-warning'
  WHEN a.estado = 2 THEN 'badge badge-success'
  WHEN a.estado = 3 THEN 'badge badge-light'
  WHEN a.estado = 4 THEN 'badge badge-danger'
  ELSE 'badge badge-danger'
END) AS status_color FROM facturas a INNER JOIN clientes c ON c.codcliente= a.codcliente $where1 INNER JOIN clientes p ON p.codcliente= a.codpaciente $where2 WHERE $where  ORDER BY a.codfactura DESC");
            return $query->result();
      }
    public function get_encabezado($id=1){
        $query = $this->db->query("SELECT encabezado FROM config WHERE id=1 limit 1");
        return $query->row();
      }
    
   	public function get_invoice($admision,$fini,$ffin,$nif,$nombre,$co_ven){
   		$where="1=1";
   		$where1="";
        $where2="";
            if ($nif <> "") { $where1.=" AND c.rif='$nif'"; }
		    if ($nombre <> "") { $where1.=" AND c.cli_des like '%".$nombre."%'"; }
		    if ($admision <> "") { $where.=" AND a.fact_num='$admision'"; }
		    if (($fini<>"") and ($ffin<>"")) {
			$fini = date('Y-m-d', strtotime($fini));
			$ffin = date('Y-m-d', strtotime($ffin));
			$where.=" AND a.fec_emis between CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110) AND CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
		} else {
			if ($fini<>"") {
				$fini = date('Y-m-d', strtotime($fini));
				$where.=" and 	a.fec_emis>=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$fini',110),110)";
			} else {
				if ($ffin<>"") {
					$ffin = date('Y-m-d', strtotime($ffin));
					$where.=" and a.fec_emis<=CONVERT(SMALLDATETIME,CONVERT(VARCHAR, '$ffin',110),110)";
				}
			}
		}

        	$resultado = $this->db->query("SELECT a.fact_num,a.co_cli,c.cli_des,a.tot_neto,a.saldo,convert(varchar, a.fec_emis, 101) AS fec_emis,a.status,(CASE WHEN a.status = 0 THEN 'Pendiente'
                ELSE 'Procesado'
                END) AS status_msg,(CASE
  WHEN a.status = 0 THEN 'badge badge-primary'
  ELSE 'badge badge-success'
END) AS status_color FROM pedidos a INNER JOIN clientes c ON c.co_cli=a.co_cli $where1 WHERE $where AND  a.co_ven='$co_ven' AND a.anulada=0 ORDER BY a.fact_num DESC");
   			return $resultado;
   		}
    public function get_ordenes_pendientes($admision,$fini,$ffin,$nombre,$empresa){
        $where="1=1";
            if ($admision <> "") { $where.=" AND codfactura='$admision'"; }
            if ($nombre <> "") { $where1.=" AND nombre like '%".$nombre."%'"; }
            if ($empresa == "ALL") {  }elseif ($empresa == "SIN") { $where.=" AND empresa='0' "; }else{ $where.=" AND codcliente='$empresa' "; }
            
            if (($fini<>"") and ($ffin<>"")) {
            $fini = date('Y-m-d', strtotime($fini));
            $ffin = date('Y-m-d', strtotime($ffin));
            $where.=" AND fecha between '".$fini."' AND '".$ffin."'";
        } else {
            if ($fini<>"") {
                $fini = date('Y-m-d', strtotime($fini));
                $where.=" and   fecha>='".$fini."'";
            } else {
                if ($ffin<>"") {
                    $ffin = date('Y-m-d', strtotime($ffin));
                    $where.=" and fecha<='".$ffin."'";
                }
            }
        }
            $resultado = $this->db->query("SELECT codfactura,nombre,sexo,IF(ifnull(anios,0) > 0,concat(ifnull(anios,0),' A'),concat(ifnull(meses,0),' M')) AS edad FROM vista_ordenes_procesar WHERE $where  ORDER BY codfactura ASC");
            return $resultado;
        }
      public function cargar_invoicetmp($codfactura,$codfacturatmp){
           return $query = $this->db->query("INSERT INTO reng_cac_tmp (fact_num, reng_num, co_art, co_alma, total_art, pendiente, uni_venta, prec_vta, tipo_imp, reng_neto, cos_pro_un, ult_cos_un, fec_lote) 
SELECT $codfacturatmp AS fact_num,reng_num, co_art, co_alma, total_art, pendiente, uni_venta, prec_vta, tipo_imp, reng_neto, cos_pro_un, ult_cos_un, fec_lote
FROM reng_ped WHERE fact_num='$codfactura'");
            //return $query->result();
        }
      public function add_saime($origen,$cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$fecha_nacimiento,$nacionalidad,$pais_origen,$sexo,$naturalizado,$id,$fecha_registro){
           return $query = $this->db->query("INSERT INTO saime (origen,cedula,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,fecha_nacimiento,nacionalidad,pais_origen,sexo,naturalizado,id,fecha_registro) values ('$origen','$cedula','$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$fecha_nacimiento','$nacionalidad','$pais_origen','$sexo','$naturalizado','$id','$fecha_registro') ");
            //return $query->result();
        }
  public function get_articulos($nombre){
    $bus   = array("", "+");
    $nombre=str_replace($bus, "%", $nombre);
            $this->db->select("*");
            $this->db->from('examenes');
            $this->db->like('Nom_exa', $nombre);
            $this->db->where('borrado', '0');
            $this->db->order_by('Nom_exa', 'asc');
            $this->db->limit(50, 0);
            return $this->db->get();
        }
  public function get_cantidad($codarticulo,$codfacturatmp){
      
          $query = $this->db->query("SELECT isnull(SUM(total_art),0) AS total_art FROM reng_cac_tmp WHERE fact_num='$codfacturatmp' AND co_art='$codarticulo' ");
        return $query->row();
      }
    public function update_fl($codfactura,$codexamen,$status=1){
        $data = array(
            'status' => $status
        );
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codigo', $codexamen);
        return $this->db->update('factulinea', $data);
    }
    public function date_factura($codfactura){
            $this->db->select('fecha');
            $this->db->from('facturas');
            $this->db->where('codfactura', $codfactura);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
    public function numlinea_factura($codfactura,$codexamen){
            $this->db->select('numlinea');
            $this->db->from('factulinea');
            $this->db->where('codfactura', $codfactura);
            $this->db->where('codigo', $codexamen);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
    public function no_repetir_lista_estudios($codfactura,$codexamen){
        $this->db->select('count(*) AS si');
        $this->db->from('lista_estudios');
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codexamen', $codexamen);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }
      public function update_ls($codfactura,$codexamen,$idusuario,$hoy){
        $data = array(
            'f_toma' => $hoy,
            'usu_toma' => $idusuario
        );
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codexamen', $codexamen);
        return $this->db->update('lista_estudios', $data);
    }
    public function add_ls($codfactura,$numlinea,$codexamen,$fec_emis,$hoy,$idusuario,$status=1,$borrado=0){
      $data = array(
                    'codfactura' => $codfactura,
                    'numlinea' => $numlinea,
                    'codexamen' => $codexamen,
                    'co_sucu' => '',
                    'status' => $status,
                    'f_fact' => $fec_emis,
                    'f_toma' => $hoy,
                    'usu_toma' => $idusuario,
                    'f_procesa' => $fec_emis,
                    'usu_procesa' => 0,
                    'f_valida' => $fec_emis,
                    'usu_valida' => 0,
                    'f_entrega' => $fec_emis,
                    'usu_entrega' => 0,
                    'borrado' => $borrado
                    );
      $this->db->insert('lista_estudios',$data);
      return $this->db->insert_id();
    }
    public function update_factura_status($codfactura,$status=1){
        $data = array(
            'status' => $status
        );
        $this->db->where('codfactura', $codfactura);
        return $this->db->update('facturas', $data);
    }
    public function delete_result_campos($codfactura,$codexamen){
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codexamen', $codexamen);
        return $this->db->delete('result_campos');
    }
    public function delete_result_listas($codfactura,$codexamen){
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codexamen', $codexamen);
        return $this->db->delete('result_listas');
    }
    public function add_result_campos($codfactura,$codexamen,$id_cam,$valorC,$idfor,$idusuario,$modulo){
      $data = array(
                    'codfactura' => $codfactura,
                    'codexamen' => $codexamen,
                    'idcam' => $id_cam,
                    'valor' => $valorC,
                    'idfor' => $idfor,
                    'idusuario' => $idusuario,
                    'modulo' => $modulo
                    );
      $this->db->insert('result_campos',$data);
      return $this->db->insert_id();
    }
    public function add_result_listas($codfactura,$codexamen,$id_lis,$valorL,$idfor,$idusuario,$modulo){
      $data = array(
                    'codfactura' => $codfactura,
                    'codexamen' => $codexamen,
                    'idlis' => $id_lis,
                    'valor' => $valorL,
                    'idfor' => $idfor,
                    'idusuario' => $idusuario,
                    'modulo' => $modulo
                    );
      $this->db->insert('result_listas',$data);
      return $this->db->insert_id();
    }
    public function update_factulinea($codfactura,$codexamen,$numlinea,$sta){
        $data = array(
            'status' => $sta
        );
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codigo', $codexamen);
        $this->db->where('numlinea', $numlinea);
        return $this->db->update('factulinea', $data);
    }
    public function update_lista_estudios($codfactura,$codexamen,$numlinea,$sta,$fechas,$idusuario){
        $data = array(
            'status' => $sta,
            'f_procesa' => $fechas,
            'usu_procesa' => $idusuario
        );
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codexamen', $codexamen);
        $this->db->where('numlinea', $numlinea);
        return $this->db->update('lista_estudios', $data);
    }
    public function update_lista_estudios2($codfactura,$codexamen,$numlinea,$sta,$fechas,$idusuario){
        $data = array(
            'status' => $sta,
            'f_valida' => $fechas,
            'usu_valida' => $idusuario
        );
        $this->db->where('codfactura', $codfactura);
        $this->db->where('codexamen', $codexamen);
        $this->db->where('numlinea', $numlinea);
        return $this->db->update('lista_estudios', $data);
    }
    public function update_facturas_imp($codfactura,$imp=1,$imp_result=0){
        $data = array(
            'imp' => $imp,
            'imp_result' => $imp_result
        );
        $this->db->where('codfactura', $codfactura);
        return $this->db->update('facturas', $data);
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
        $query = $this->db->query("SELECT co_cond,cond_des,dias_cred FROM condicio WHERE co_cond='$codigo' ");
        return $query->row();
    }

    public function obtener_config_email($id=1){
        $query = $this->db->query("SELECT c.email,c.password,c.host,c.port,c.smtpsecure,c.debug FROM GMOBILE.dbo.config_email c WHERE c.id='$id' ");
        return $query->row();
    }

	}
?>
