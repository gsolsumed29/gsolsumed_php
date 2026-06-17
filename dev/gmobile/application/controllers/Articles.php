<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('articles_model');
        $this->load->library('session');
        if($this->session->userdata('user')){
            $empbd=$this->session->userdata('empbd');
        $this->db = $this->load->database($empbd, TRUE);
        }
        else{
            //redirect('/');
        }
	}

	public function index(){
		//load session library
		$this->load->library('session');

		//restrict users to go back to login if session has been set
		if($this->session->userdata('user')){
            $data['sucursales'] = $this->articles_model->get_sucu();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('articles/index',$data);
		}
		else{
			redirect('/');
		}
	}


	public function add(){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['categorias'] = $this->articles_model->getcategorias();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('invoice/add',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

    public function edit($codfactura){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['invoice'] = $codfactura;
            $data['categorias'] = $this->articles_model->getcategorias();
            $this->load->view('head');
            $this->load->view('header');
            $this->load->view('invoice/edit',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

	public function search_art($codigo,$descripcion,$categorias,$cliente){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['cliente'] = $cliente;
			$data['articulos'] = $this->articles_model->getarticulos($codigo,$descripcion,$categorias);
			$this->load->view('invoice/search_art',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

	public function search_cli($rif,$nombre,$empresa,$tipo){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['tipo'] = $tipo;
			$data['clientes'] = $this->articles_model->getclientes($rif,$nombre,$empresa);
			$this->load->view('invoice/search_cli',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

	public function cliente_new($tipo,$rif){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['tipo'] = $tipo;
			$data['rif'] = $tipo;
			//$data['clientes'] = $this->articles_model->getclientes($rif,$nombre,$empresa);
			$this->load->view('invoice/cliente_new',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

	public function cliente_vali($rif)
    {
        $data = $this->articles_model->get_cliente_vali($rif);
        echo json_encode($data);
    }
    public function articulo_vali2($id)
    {
        $data = $this->articles_model->get_articulo_vali2($id);
        echo json_encode($data);
    }

    public function update_totales($admision)
    {
        $data = $this->articles_model->get_update_totales($admision);
        echo json_encode($data);
    }

    public function update_totales2($admision)
    {
        $data = $this->articles_model->get_update_totales2($admision);
        echo json_encode($data);
    }

	public function modif_art($admision,$numlinea,$articulo,$cliente){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['cliente'] = $cliente;
			$data['articulos'] = $this->articles_model->get_modif_art($admision,$numlinea,$articulo);
			$data['precios'] = $this->articles_model->getprecios($articulo,$cliente);
			$this->load->view('invoice/modif_art',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

	public function getdettmp()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $codfacturatmp = $this->input->post('codfacturatmp');
        $list = $this->articles_model->get_det_tmp($codfacturatmp);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
           $data[] = array(
                $item,
                $row->codigo,
                $row->Nom_exa,
                $row->excento,
                $row->cantidad,
                $row->precio,
                $row->dcto,
                $row->importe,
                //'<span class="'.$row->nivel_color.'">'.$row->nivel_msg.'</span>',
                //'<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
                //$row->status,
                '<div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" onclick="modif_art('."'".$row->codfactura."'".','."'".$row->numlinea."'".','."'".trim($row->codigo)."'".');" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
            </div>'
                
                
           );
           $item++;
      }
      $result = array(
               "draw" => $draw,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
            );
      echo json_encode($result);
      exit();
    }

    public function getdetadm()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $codfactura= $this->input->post('codfactura');
        $list = $this->articles_model->get_det_adm($codfactura);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
           $data[] = array(
                $item,
                $row->codigo,
                $row->Nom_exa,
                $row->excento,
                $row->cantidad,
                $row->precio,
                $row->dcto,
                $row->importe,
                //'<span class="'.$row->nivel_color.'">'.$row->nivel_msg.'</span>',
                //'<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
                //$row->status,
                '<div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-trash"></i></button>
            </div>'
                
                
           );
           $item++;
      }
      $result = array(
               "draw" => $draw,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
            );
      echo json_encode($result);
      exit();
    }

    public function addart(){
		$codarticulo = $this->input->post('codarticulo');
		$precio = $this->input->post('precio');
		$cantidad = $this->input->post('cantidad');
		$dcto = $this->input->post('dcto');
		$importe = $this->input->post('importe');
		$codfamilia = $this->input->post('codfamilia');
		$nuli = $this->input->post('nuli');
		$codfacturatmp = $this->input->post('codfacturatmp');
        $iva_art = $this->articles_model->iva_art($codarticulo);
        $ivaart=$iva_art->iva;
        $excento=$iva_art->excento;

		$no_repertir = $this->articles_model->no_repetir_art($codfacturatmp,$codarticulo);
        if($no_repertir->si > 0){
        	//validar si nuli es diferente de 0 
				if($nuli > 0 && $codfamilia == 0){
					$datos_detalle = $this->articles_model->update_det_tmp($codfacturatmp,$codarticulo,$codfamilia,$precio,$cantidad,$dcto,$importe,$nuli,$ivaart,$excento);
		if ($datos_detalle) {
			$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Modificado '.$codarticulo;
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}else{
			$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Modificar '.$codarticulo;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}

				}else{
				//si ya existe pero no es del form modificar linea
					$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$codarticulo;
                $jsondata['type'] = 'warning';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
				}
        }else{
        $datos_detalle = $this->articles_model->add_det_tmp($codfacturatmp,$codarticulo,$codfamilia,$precio,$cantidad,$dcto,$importe,$nuli,$excento,$ivaart);
		if ($datos_detalle) {
			$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$codarticulo;
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}else{
			$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$codarticulo;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}
                    } 
		
    
    }

    public function addcli(){
		$codigo = $this->input->post('ncodigo');
        $nombre = $this->input->post('nnombre');
        $id = $this->input->post('ncodarticulo');
        $cbarras = $this->input->post('ncbarras');
        $observa = $this->input->post('nobserva');
        $categoria = $this->input->post('ncategoria');
        $ubicacion = $this->input->post('nubicacion');
        $unidad = $this->input->post('nunidad');
        $inventario = $this->input->post('ninv');
        $stock = $this->input->post('nstock');
        $stock=str_replace(".", "", $stock);
        $stock=str_replace(",", ".", $stock);
        $formato = $this->input->post('nformato');
        $minimo = $this->input->post('nminimo');
        $minimo=str_replace(".", "", $minimo);
        $minimo=str_replace(",", ".", $minimo);
        $aviso = $this->input->post('naviso');
        $iva = $this->input->post('niva');
        $excento = $this->input->post('nexcento');
        $precio = $this->input->post('nprecio');
        $precio=str_replace(".", "", $precio);
        $precio=str_replace(",", ".", $precio);
		$tipo = $this->input->post('ntipo');
		$no_repertir = $this->articles_model->no_repetir_cli($codigo);
        if($no_repertir->si > 0){
				//si ya existe cliente
					$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$codigo;
                $jsondata['type'] = $codigo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->articles_model->add_cli($codigo,$nombre,$observa,$cbarras,$categoria,$ubicacion,$unidad,$inventario,$stock,$minimo,$aviso,$iva,$excento,$precio,$formato);
		if ($datos_detalle) {
            $datos_precio = $this->articles_model->add_precio($codigo,$precio);
			$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$codigo;
                $jsondata['type'] = $codigo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}else{
			$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$codigo;
                $jsondata['type'] = $codigo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}
                    } 
		
    
    }

    public function updatecli(){
        $codigo = $this->input->post('ncodigo');
        $nombre = $this->input->post('nnombre');
        $id = $this->input->post('ncodarticulo');
        $cbarras = $this->input->post('ncbarras');
        $observa = $this->input->post('nobserva');
        $categoria = $this->input->post('ncategoria');
        $ubicacion = $this->input->post('nubicacion');
        $unidad = $this->input->post('nunidad');
        $inventario = $this->input->post('ninv');
        $stock = $this->input->post('nstock');
        $stock=str_replace(".", "", $stock);
        $stock=str_replace(",", ".", $stock);
        $formato = $this->input->post('nformato');
        $minimo = $this->input->post('nminimo');
        $minimo=str_replace(".", "", $minimo);
        $minimo=str_replace(",", ".", $minimo);
        $aviso = $this->input->post('naviso');
        $iva = $this->input->post('niva');
        $excento = $this->input->post('nexcento');
        $precio = $this->input->post('nprecio');
        $precio=str_replace(".", "", $precio);
        $precio=str_replace(",", ".", $precio);
        $tipo = $this->input->post('ntipo');
        $no_repertir = $this->articles_model->no_repetir_cli2($codigo,$id);
        if($no_repertir->si > 0){
                //si ya existe cliente
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$codigo;
                $jsondata['type'] = $id;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->articles_model->update_cli($id,$codigo,$nombre,$observa,$cbarras,$categoria,$ubicacion,$unidad,$inventario,$stock,$minimo,$aviso,$iva,$excento,$precio,$formato);
        if ($datos_detalle) {
            $datos_precio = $this->articles_model->add_precio($codigo,$precio);
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Actualizado '.$codigo;
                $jsondata['type'] = $id;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.$codigo;
                $jsondata['type'] = $id;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
                    } 
        
    
    }

    public function deletecli($codcliente,$borrado){
        $datos_detalle = $this->articles_model->delete_cli($codcliente,$borrado);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Estatus del cliente '.$codcliente;
                $jsondata['type'] = $borrado;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.$codcliente;
                $jsondata['type'] = $borrado;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

    public function comprobarrif($nacionalidad,$cedula){
       
$url="http://www.cne.gob.ve/web/registro_civil/buscar_rep.php?nac=".$nacionalidad."&ced=".$cedula;
        $cUrl = curl_init();
        curl_setopt($cUrl,CURLOPT_URL,$url);
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);
        $result_41x = curl_exec($cUrl);
    if (curl_errno($cUrl)) {
    // this would be your first hint that something went wrong
    //die('Couldn\'t send request: ' . curl_error($cUrl));
    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'No se pudo resolver el host (por favor verifique su conexión a internet)';
                $jsondata['type'] = 'bg-red';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    } else {
    // check the HTTP status code of the request
    $resultStatus = curl_getinfo($cUrl, CURLINFO_HTTP_CODE);
    if ($resultStatus == 200) {
        // everything went better than expected
         $e = new Exception($result_41x);
         $texto = $e->getMessage();
         $valor=trim($texto);
		 //echo $texto;
		 $valor = str_replace("\n","",$valor);
		 $valor=strip_tags($valor);
		 $valor=trim($valor);
		 //echo "*".$valor."*";
	 	 $validar=substr($valor, 0, 4);
		 if($validar == 'La c'){ //La cédula de identidad V-114444764 no esta registrado en la base de datos
		 	$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = $valor;
                $jsondata['type'] = 'bg-red';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		 }else{ //La cédula de identidad V-114444764 si esta registrado en la base de datos
		 	$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = $valor;
                $jsondata['type'] = 'bg-green';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return true;
		 }
        
    } else {
        // the request did not complete as expected. common errors are 4xx
        // (not found, bad request, etc.) and 5xx (usually concerning
        // errors/exceptions in the remote script execution)
        //die('Request failed: HTTP status code: ' . $resultStatus);
        $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Request failed: HTTP status code: '. $resultStatus;
                $jsondata['type'] = 'bg-red';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    }
}

//close connection
    curl_close($cUrl);
        
    }


    public function save(){
		$codfacturatmp = $this->input->post('codfacturatmp');
		$codcliente = $this->input->post('codcliente');
		$condicion = $this->input->post('condicion');
		$observacion = $this->input->post('observacion');
		$parentesco = $this->input->post('parentesco');
		$fechita = $this->input->post('fecha');
		$fecha=date("Y-m-d", strtotime($fechita));
        $fechitav = $this->input->post('fechav');
        $fechav=date("Y-m-d", strtotime($fechitav));
		$iva = $this->input->post('iva');
		$totalalbaran = $this->input->post('preciototal');
		$estado=1;
		$borrado=0;
		$codfactura = $this->articles_model->add_invoice($fecha, $iva, $codcliente, $observacion, $estado, $totalalbaran, $fechav, $condicion, $borrado);
		//$codfactura = $this->articles_model->add_invoice($codfactura, $fecha, $iva, $codcliente, $codpaciente, $parentesco, $codtitular, $observacion, $clave, $patologia, $diagnostico, $especialidad, $medico_tratante, $tipo_personal, $estado, $totalalbaran, $borrado);

		$list = $this->articles_model->get_det_tmp2($codfacturatmp);
        $item=1;
        foreach($list->result() as $row) {
            $det_invoice = $this->articles_model->add_det_invoice($codfactura,$row->codigo,$row->codfamilia,$row->precio,$row->cantidad,$row->dcto,$row->importe,$row->iva,$row->excento,$row->status);
            $item++;
        }

        if ($codfactura) {
			$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Factura: '.$codfactura;
                $jsondata['invoice'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}else{
			$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar Factura';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}

		
	}

    public function save2(){
        $codfacturatmp = $this->input->post('codfacturatmp');
        $codcliente = $this->input->post('codcliente');
        $condicion = $this->input->post('condicion');
        $observacion = $this->input->post('observacion');
        $parentesco = $this->input->post('parentesco');
        $fechita = $this->input->post('fecha');
        $fecha=date("Y-m-d", strtotime($fechita));
        $fechitav = $this->input->post('fechav');
        $fechav=date("Y-m-d", strtotime($fechitav));
        $iva = $this->input->post('iva');
        $totalalbaran = $this->input->post('preciototal');
        $invoice = $this->input->post('invoice');
        $estado=1;
        $borrado=0;
        $codfactura = $this->articles_model->update_invoice($invoice,$fecha, $iva, $codcliente, $observacion, $estado, $totalalbaran, $fechav, $condicion, $borrado);
        $delete = $this->articles_model->delete_invoice_detalle($invoice);

        $list = $this->articles_model->get_det_tmp2($codfacturatmp);
        $item=1;
        foreach($list->result() as $row) {
            $det_invoice = $this->articles_model->add_det_invoice($invoice,$row->codigo,$row->codfamilia,$row->precio,$row->cantidad,$row->dcto,$row->importe,$row->iva,$row->excento,$row->status);
            $item++;
        }
        

        if ($codfactura) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Factura: '.$invoice;
                $jsondata['invoice'] = $invoice;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar Factura';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

        
    }

	public function view($admision){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['invoice'] = $admision;
			//$data['articulos'] = $this->articles_model->get_modif_art($admision,$numlinea,$articulo);
			//$data['precios'] = $this->articles_model->getprecios($articulo,$cliente);
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('invoice/view',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

    public function formato($formato){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
        
            $data['idfor'] = $formato;
            $this->load->view('articles/formato',$data);
            
        }
        else{
            redirect('/');
        }
        
    }

	public function getarticles()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $codigo = $this->input->post('codigo');
        $nombre = $this->input->post('nombre');
        $sucu = $this->input->post('sucu');
        
        $list = $this->articles_model->get_articles($codigo,$nombre,$sucu);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(//a.co_art, a.art_des, a.tipo, a.stock_act, a.prec_vta1, a.prec_vta2,a.prec_vta3, a.prec_vta4, a.prec_vta5, a.prec_agr1, a.tipo_imp
                $item,
                trim($row->co_art).' - '.trim($row->art_des).' - '.trim($row->alma_des),
                $row->art_des,
                number_format($row->prec_vta1,2,',','.'),
                number_format($row->stock_act,2,',','.'),
                $row->tipo,
                $row->tipo_imp,
                number_format($row->prec_vta2,2,',','.'),
                number_format($row->prec_vta3,2,',','.'),
                number_format($row->prec_vta4,2,',','.'),
                number_format($row->prec_vta5,2,',','.'),
                number_format($row->stock_com,2,',','.'),
                number_format(($row->stock_act - $row->stock_com),2,',','.')    

           );
           $item++;
      }
      $result = array(
               "draw" => $draw,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
            );
      echo json_encode($result);
      exit();
    }


}
