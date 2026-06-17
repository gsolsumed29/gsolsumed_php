<?php
	class Articles_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function obtener_config($id=1){
   			$this->db->select('iva, moneda');
   			$this->db->from('config');
   			$this->db->where('id', $id);
  			$consulta = $this->db->get();
   			$resultado = $consulta->row();
   			return $resultado;
   		}

   		public function obtener_invoicetmp($idusuario){
			$fecha = date('Y-m-d');
			$data = array(
                    'fecha' => $fecha,
                    'idusuario' => $idusuario
                    );
			$this->db->insert('facturastmp',$data);
			return $this->db->insert_id();

		}

		public function get_det_tmp($codfacturatmp){
            $this->db->select("al.codfactura,al.numlinea,al.codfamilia,al.codigo,e.Nom_exa,al.excento,FORMAT(al.cantidad,2,'de_DE') AS cantidad,FORMAT(al.precio,2,'de_DE') AS precio,FORMAT(al.importe,2,'de_DE') AS importe,FORMAT(al.dcto,2,'de_DE') AS dcto,al.status");
        $this->db->from('factulineatmp al');
        $this->db->join('examenes e', 'e.IDExa=al.codigo');
            $this->db->where('al.codfactura', $codfacturatmp);
            //$this->db->where('status', '1');
            $this->db->order_by('al.numlinea', 'asc');
            //$this->db->limit(5, 0);
            return $this->db->get();
        }

        public function get_det_adm($codfactura){
            $this->db->select("al.codfactura,al.numlinea,al.codfamilia,al.codigo,e.Nom_exa,al.excento,FORMAT(al.cantidad,2,'de_DE') AS cantidad,FORMAT(al.precio,2,'de_DE') AS precio,FORMAT(al.importe,2,'de_DE') AS importe,FORMAT(al.dcto,2,'de_DE') AS dcto,al.status");
        $this->db->from('factulinea al');
        $this->db->join('examenes e', 'e.IDExa=al.codigo');
            $this->db->where('al.codfactura', $codfactura);
            //$this->db->where('status', '1');
            $this->db->order_by('al.numlinea', 'asc');
            //$this->db->limit(5, 0);
            return $this->db->get();
        }

        public function get_det_tmp2($codfacturatmp){
            $this->db->select("al.codfactura,al.numlinea,al.codfamilia,al.codigo,e.Nom_exa,al.cantidad,al.precio,al.importe,al.dcto,al.status,al.iva,al.excento");
        $this->db->from('factulineatmp al');
        $this->db->join('examenes e', 'e.IDExa=al.codigo');
            $this->db->where('al.codfactura', $codfacturatmp);
            //$this->db->where('status', '1');
            $this->db->order_by('al.numlinea', 'asc');
            //$this->db->limit(5, 0);
            return $this->db->get();
        }

        public function getcategorias(){
        	$query = $this->db->query('SELECT codfamilia,nombre FROM familias where borrado=0 ORDER BY nombre ASC');
        	return $query->result();
        }

        public function getubicaciones(){
          $query = $this->db->query('SELECT codubicacion,nombre FROM ubicaciones where borrado=0 ORDER BY nombre ASC');
          return $query->result();
        }

        public function getembalajes(){
          $query = $this->db->query('SELECT codembalaje,nombre FROM embalajes where borrado=0 ORDER BY nombre ASC');
          return $query->result();
        }
        public function getexcentos(){
          $query = $this->db->query('SELECT codexcento,nombre FROM excentos where borrado=0 ORDER BY nombre ASC');
          return $query->result();
        }
        public function getimpuestos(){
          $query = $this->db->query('SELECT codimpuesto,nombre,valor FROM impuestos where borrado=0 ORDER BY nombre ASC');
          return $query->result();
        }
        public function getformatos(){
          $query = $this->db->query('SELECT IDFor,Des_For FROM formatos where borrado=0 ORDER BY IDFor ASC');
          return $query->result();
        }

        public function getarticulos($codigo,$descripcion,$categorias){
        	if($codigo == '-' && $descripcion == '-'){
        		$codigo='******';
        		$descripcion='*******';
        	}
        	$where="1=1";
        	if ($categorias<>0) { $where.=" AND codfamilia='$categorias'"; }
        	if ($codigo<>"-") { $where.=" AND IDExa like '%$codigo%'"; }
        	if ($descripcion<>"-") { $where.=" AND Nom_exa like '%$descripcion%'"; }
        	$query = $this->db->query("SELECT * FROM vista_articulos WHERE $where AND venta=1  ORDER BY codfamilia ASC, Nom_exa ASC");
        	return $query->result();
        }
        public function getclientes($rif,$nombre,$empresa){
        	if($rif == '-' && $nombre == '-'){
        		$rif='******';
        		$nombre='*******';
        	}
        	$where="1=1";
        	if ($empresa<>0) {
        		if($empresa == 2){ $where.=" AND empresa='1' "; }else{ $where.=" AND empresa='0'";}
        	}
        	if ($rif<>"-") { $where.=" AND nif like '%$rif%'"; }
        	if ($nombre<>"-") { $where.=" AND nombre like '%$nombre%'"; }
        	$query = $this->db->query("SELECT * FROM clientes WHERE $where AND borrado=0  ORDER BY nombre ASC");
        	return $query->result();
        }

        public function getprecios($idexa,$cliente){
        	$query = $this->db->query("SELECT * FROM listas_precio WHERE IDExa='$idexa' AND codcliente IN('0','$cliente') AND borrado=0 ORDER BY idlista_precio ASC");
        	return $query->result();
        }

        public function get_modif_art($admision,$numlinea,$articulo){
        	$query = $this->db->query("SELECT al.codfactura,al.codigo,e.nom_exa,al.numlinea,al.precio,al.cantidad,al.dcto,al.importe FROM factulineatmp al INNER JOIN examenes e ON e.IDExa=al.codigo WHERE al.codfactura='$admision' AND al.codigo='$articulo' ");
        	return $query->result();
        }

        public function add_det_tmp($codfacturatmp,$codarticulo,$codfamilia,$precio,$cantidad,$dcto,$importe,$nuli,$excento,$ivaart,$status=0){
      $data = array(
                    'codfactura' => $codfacturatmp,
                    'codigo' => $codarticulo,
                    'codfamilia' => $codfamilia,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'importe' => $importe,
                    'dcto' => $dcto,
                    'iva' => $ivaart,
                    'excento' => $excento,
                    'status' => $status
                    );
      $this->db->insert('factulineatmp',$data);
      return $this->db->insert_id();
    }

    public function add_cli($codigo,$nombre,$observa,$cbarras,$categoria,$ubicacion,$unidad,$inventario,$stock,$minimo,$aviso,$iva,$excento,$precio,$formato,$borrado=0){
      $data = array(
      				      'IDExa' => $codigo,
                    'Nom_exa' => $nombre,
                    'observa' => $observa,
                    'precio1' => $precio,
                    'IDFor' => $formato,
                    'codfamilia' => $categoria,
                    'codimpuesto' => $iva,
                    'excento' => $excento,
                    'codubicacion' => $codubicacion,
                    'inventario' => $inventario,
                    'stock' => $stock,
                    'stock_minimo' => $minimo,
                    'aviso_minimo' => $aviso,
                    'codembalaje' => $unidad,
                    'codigobarras' => $cbarras,
                    'borrado' => $borrado
                    );
      $this->db->insert('examenes',$data);
      return $this->db->insert_id();
    }

    public function update_cli($id,$codigo,$nombre,$observa,$cbarras,$categoria,$ubicacion,$unidad,$inventario,$stock,$minimo,$aviso,$iva,$excento,$precio,$formato,$borrado=0){
      $data = array(
                    'Nom_exa' => $nombre,
                    'observa' => $observa,
                    'precio1' => $precio,
                    'IDFor' => $formato,
                    'codfamilia' => $categoria,
                    'codimpuesto' => $iva,
                    'excento' => $excento,
                    'codubicacion' => $ubicacion,
                    'inventario' => $inventario,
                    'stock' => $stock,
                    'stock_minimo' => $minimo,
                    'aviso_minimo' => $aviso,
                    'codembalaje' => $unidad,
                    'codigobarras' => $cbarras
                    );
      $this->db->where('id', $id);
      return $this->db->update('examenes', $data);
    }

    public function delete_cli($id,$borrado){
      $data = array(
                    'borrado' => $borrado
                    );
      $this->db->where('id', $id);
      return $this->db->update('examenes', $data);
    }

    public function update_det_tmp($codfacturatmp,$codarticulo,$codfamilia,$precio,$cantidad,$dcto,$importe,$nuli,$ivaart,$excento,$status=0){
      $data = array(
                    'codfamilia' => $codfamilia,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'importe' => $importe,
                    'dcto' => $dcto,
                    'iva' => $ivaart,
                    'excento' => $excento
                    );
      $this->db->where('codfactura', $codfacturatmp);
      $this->db->where('codigo', $codarticulo);
      return $this->db->update('factulineatmp', $data);
    }


    public function iva_art($codarticulo){

        $this->db->select('e.excento,i.valor AS iva');
        $this->db->from('examenes e');
        $this->db->join('impuestos i', 'i.codimpuesto=e.codimpuesto');
        $this->db->where('IDExa', $codarticulo);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function no_repetir_art($codfacturatmp,$codarticulo){

        $this->db->select('count(*) AS si');
        $this->db->from('factulineatmp');
        $this->db->where('codfactura', $codfacturatmp);
        $this->db->where('codigo', $codarticulo);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

     public function no_repetir_cli($codigo,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('examenes');
        $this->db->where('IDExa', $codigo);
        $this->db->where('borrado', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function no_repetir_cli2($codigo,$id,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('examenes');
        $this->db->where('IDExa', $codigo);
        $this->db->where('id <>', $id);
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

    public function get_articulo_vali2($id)
    {
        $this->db->select("id,IDExa,Nom_exa,observa,codfamilia,codubicacion,codembalaje,inventario,IDFor,FORMAT(stock,2,'de_DE') AS stock,FORMAT(stock_minimo,2,'de_DE') AS stock_minimo,aviso_minimo,codimpuesto,excento,FORMAT(precio1,2,'de_DE') AS precio1,borrado");
        $this->db->from('examenes');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_update_totales($admision)
    {
    	$this->db->select("FORMAT(cstotal('factulineatmp',codfactura),2,'de_DE') AS subtotal,
FORMAT(cdcto('factulineatmp',codfactura),2,'de_DE') AS dcto,
FORMAT(cimpuesto('factulineatmp',codfactura),2,'de_DE') AS impuesto,
FORMAT( (cstotal('factulineatmp',codfactura) -  cdcto('factulineatmp',codfactura)) + cimpuesto('factulineatmp',codfactura) ,2,'de_DE') AS totalfactura,
 (cstotal('factulineatmp',codfactura) -  cdcto('factulineatmp',codfactura)) + cimpuesto('factulineatmp',codfactura) AS total");
        $this->db->from('factulineatmp');
        $this->db->where('codfactura',$admision);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_update_totales2($admision)
    {
      $this->db->select("FORMAT(cstotal('factulinea',codfactura),2,'de_DE') AS subtotal,
FORMAT(cdcto('factulinea',codfactura),2,'de_DE') AS dcto,
FORMAT(cimpuesto('factulinea',codfactura),2,'de_DE') AS impuesto,
FORMAT( (cstotal('factulinea',codfactura) -  cdcto('factulinea',codfactura)) + cimpuesto('factulinea',codfactura) ,2,'de_DE') AS totalfactura,
(cstotal('factulinea',codfactura) -  cdcto('factulinea',codfactura)) + cimpuesto('factulinea',codfactura) AS total");
        $this->db->from('facturas');
        $this->db->where('codfactura',$admision);
        $query = $this->db->get();
        return $query->row();
    }

    public function add_det_invoice($codfactura,$codarticulo,$codfamilia,$precio,$cantidad,$dcto,$importe,$iva,$excento,$status){
      $data = array(
                    'codfactura' => $codfactura,
                    'codigo' => $codarticulo,
                    'codfamilia' => $codfamilia,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'importe' => $importe,
                    'dcto' => $dcto,
                    'iva' => $iva,
                    'excento' => $excento,
                    'status' => $status
                    );
      $this->db->insert('factulinea',$data);
      return $this->db->insert_id();
    }

    public function add_invoice($fecha, $iva, $codcliente, $observacion, $estado, $totalalbaran, $fechav, $condicion, $borrado){
      $data = array(
                    'fecha' => $fecha,
                    'iva' => $iva,
                    'codcliente' => $codcliente,
                    'observacion' => $observacion,
                    'estado' => $estado,
                    'totalfactura' => $totalalbaran,
                    'fechavencimiento' => $fechav,
                    'condicion' => $condicion,
                    'n_control' => '',
                    'saldo' => $totalalbaran,
                    'imp' => 0,
                    'borrado' => $borrado
                    );
      $this->db->insert('facturas',$data);
      return $this->db->insert_id();
    }

    public function update_invoice($invoice,$fecha, $iva, $codcliente, $observacion, $estado, $totalalbaran, $fechav, $condicion, $borrado){
      $data = array(
                    'fecha' => $fecha,
                    'iva' => $iva,
                    'codcliente' => $codcliente,
                    'observacion' => $observacion,
                    'totalfactura' => $totalalbaran,
                    'fechavencimiento' => $fechav,
                    'condicion' => $condicion,
                    'saldo' => $totalalbaran
                    );
      $this->db->where('codfactura', $invoice);
      return $this->db->update('facturas', $data);
    }

    public function delete_invoice_detalle($codfactura){
           return $query = $this->db->delete('factulinea', array('codfactura' => $codfactura));
            //return $query->result();
        }

    public function etiquetas($idfor){
            $query = $this->db->query("SELECT Nom_eti,PosX,PosY,Ancho_eti,Alto_eti,TamFue_eti,NegFue_eti FROM etiquetas where IDFor='$idfor' AND printer='True' ");
            return $query->result();
        }

        public function campos($idfor){
            $query = $this->db->query("SELECT IDCam FROM campos where IDFor='$idfor' AND printer='True' ");
            return $query->result();
        }

        public function get_sucu(){
          $query = $this->db->query("SELECT co_alma,alma_des FROM almacen ORDER BY co_alma ASC");
          return $query->result();
        }

        public function listas($idfor){
            $query = $this->db->query("SELECT Idlis FROM listas where IDFor='$idfor' AND printer='True' ");
            return $query->result();
        }

        public function vista_for($idfor){
            $query = $this->db->query("SELECT IDFor,id,tipo,tab,nombre,PosX,PosY,Alto,Ancho,type,tam,neg,valor,formato FROM vista_formatos where IDFor='$idfor' ORDER BY tab ASC ");
            return $query->result();
        }

    public function obtener_invoice($admision){
   			$this->db->select('a.codfactura,a.fecha,a.iva,a.codcliente,c.nif,c.nombre,a.observacion,a.condicion,a.fechavencimiento,a.totalfactura');
   			$this->db->from('facturas a');
   			$this->db->join('clientes c', 'c.codcliente= a.codcliente');
   			$this->db->where('a.codfactura', $admision);
  			$consulta = $this->db->get();
   			$resultado = $consulta->row();
   			return $resultado;
   		}

   	public function get_articles($codigo,$nombre,$sucu){
      $bus   = array("", "+");
   		$where="1=1";
        $where1=" ";
        if($sucu <> '0'){ $where1.=" AND s.co_alma='$sucu' "; }

		    if ($codigo <> "") { $codigo=str_replace($bus, "%", $codigo); $where.=" AND a.co_art like '%".$codigo."%'"; }
        if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND a.art_des like '%".$nombre."%'"; }
		    
        	$resultado = $this->db->query("SELECT a.co_art, a.art_des, a.tipo, t.stock_act, a.prec_vta1, 0 as prec_vta2, 0 as prec_vta3, 0 as prec_vta4, 0 as prec_vta5, a.prec_agr1, a.tipo_imp, a.stock_com,t.co_alma,b.alma_des FROM art a INNER JOIN st_almac t ON t.co_art=a.co_art INNER JOIN sub_alma s ON s.co_sub=t.co_alma $where1 INNER JOIN almacen b ON b.co_alma=s.co_alma WHERE $where AND a.tipo = 'V' and t.co_alma = '01' ORDER BY a.co_art ASC");

   			return $resultado;
   		}

      public function cargar_invoicetmp($codfactura,$codfacturatmp){
           return $query = $this->db->query("INSERT INTO factulineatmp (codfactura,codfamilia,codigo,cantidad,precio,importe,dcto,iva,excento,status) 
SELECT $codfacturatmp AS codfactura,codfamilia,codigo,cantidad,precio,importe,dcto,iva,excento,status
FROM factulinea WHERE codfactura='$codfactura'");
            //return $query->result();
        }

    public function add_precio($codigo,$precio,$codcliente=0){
           return $query = $this->db->query("INSERT INTO listas_precio (idexa,detalle,valor,codcliente,nocturno,ff,borrado) SELECT a.IDExa as idexa,'Contado' AS detalle, a.precio1 AS valor, '0' AS codcliente, '0' AS nocturno, '0' AS ff, '0' AS borrado  FROM examenes a WHERE a.IDExa='$codigo' ON DUPLICATE KEY UPDATE valor = values(valor)");
            //return $query->result();
        }

	}
?>
