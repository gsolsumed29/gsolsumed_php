<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sclient extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('sclient_model');
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
            $co_ven = $this->session->userdata('co_ven');
            $data['tipos'] = $this->sclient_model->get_tipos();
            $data['zonas'] = $this->sclient_model->get_zonas($co_ven);
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('sclient/index',$data);
		}
		else{
			redirect('/');
		}
	}

	public function cliente_vali($rif)
    {
        $data = $this->sclient_model->get_cliente_vali($rif);
        echo json_encode($data);
    }

    public function cliente_vali2($co_cli)
    {
        $data = $this->sclient_model->get_cliente_vali2($co_cli);
        echo json_encode($data);
    }

    public function addcli(){
		$rif = strtoupper($this->input->post('nrif'));
		$nombre = strtoupper($this->input->post('nnombre'));
		$direccion = strtoupper($this->input->post('ndireccion'));
        $direccionent = strtoupper($this->input->post('ndireccionent'));
		$telefono = strtoupper($this->input->post('ntelefono'));
		$email = strtoupper($this->input->post('nemail'));
		$co_ven = $this->input->post('nco_ven');
        $zona = $this->input->post('nzona');
        $tipo = $this->input->post('ntipo');
        $sada = $this->input->post('nsada');
        $respons="";
        $fecha_reg=date('Y-m-d');
		$no_repertir = $this->sclient_model->no_repetir_cli($rif);
        if($no_repertir->si > 0){
				//si ya existe cliente
					$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->sclient_model->add_cli($rif,$nombre,$direccion,$direccionent,$telefono,$email,$co_ven,$zona,$tipo,$respons,$fecha_reg,$sada);
		if ($datos_detalle) {
			$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}else{
			$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}
                    } 
		
    
    }

    public function updatecli(){
        $rif = strtoupper($this->input->post('nrif'));
        $nombre = strtoupper($this->input->post('nnombre'));
        $direccion = strtoupper($this->input->post('ndireccion'));
        $direccionent = strtoupper($this->input->post('ndireccionent'));
        $telefono = strtoupper($this->input->post('ntelefono'));
        $email = strtoupper($this->input->post('nemail'));
        $co_ven = $this->input->post('nco_ven');
        $zona = $this->input->post('nzona');
        $tipo = $this->input->post('ntipo');
        $sada = $this->input->post('nsada');
        $codcliente = $this->input->post('ncodcliente');
        $no_repertir = $this->sclient_model->no_repetir_cli2($rif,$codcliente);
        if($no_repertir->si > 0){
                //si ya existe cliente
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->sclient_model->update_cli($codcliente,$rif,$nombre,$direccion,$direccionent,$telefono,$email,$zona,$tipo,$sada);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
                    } 
        
    
    }

    public function deletecli($codcliente){
        $datos_detalle = $this->sclient_model->delete_cli($codcliente);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Estatus del cliente '.$codcliente;
                $jsondata['type'] = 1;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.$codcliente;
                $jsondata['type'] = 0;
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
		$codfactura = $this->sclient_model->add_invoice($fecha, $iva, $codcliente, $observacion, $estado, $totalalbaran, $fechav, $condicion, $borrado);
		//$codfactura = $this->sclient_model->add_invoice($codfactura, $fecha, $iva, $codcliente, $codpaciente, $parentesco, $codtitular, $observacion, $clave, $patologia, $diagnostico, $especialidad, $medico_tratante, $tipo_personal, $estado, $totalalbaran, $borrado);

		$list = $this->sclient_model->get_det_tmp2($codfacturatmp);
        $item=1;
        foreach($list->result() as $row) {
            $det_invoice = $this->sclient_model->add_det_invoice($codfactura,$row->codigo,$row->codfamilia,$row->precio,$row->cantidad,$row->dcto,$row->importe,$row->iva,$row->excento,$row->status);
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
        $codfactura = $this->sclient_model->update_invoice($invoice,$fecha, $iva, $codcliente, $observacion, $estado, $totalalbaran, $fechav, $condicion, $borrado);
        $delete = $this->sclient_model->delete_invoice_detalle($invoice);

        $list = $this->sclient_model->get_det_tmp2($codfacturatmp);
        $item=1;
        foreach($list->result() as $row) {
            $det_invoice = $this->sclient_model->add_det_invoice($invoice,$row->codigo,$row->codfamilia,$row->precio,$row->cantidad,$row->dcto,$row->importe,$row->iva,$row->excento,$row->status);
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
			//$data['articulos'] = $this->sclient_model->get_modif_art($admision,$numlinea,$articulo);
			//$data['precios'] = $this->sclient_model->getprecios($articulo,$cliente);
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('invoice/view',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

	public function getclient()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $rif = $this->input->post('rif');
        $nombre = $this->input->post('nombre');
        $fini = $this->input->post('fini');
        //$fini=date("Y-m-d", strtotime($fini));
        $ffin = $this->input->post('ffin');
        //$ffin=date("Y-m-d", strtotime($ffin));
        $co_ven = $this->input->post('co_ven');
        $list = $this->sclient_model->get_client($rif,$nombre,$co_ven,$fini,$ffin);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(
                $item,
                $row->co_cli.' - '.$row->cli_des,
                $row->cli_des,
                $row->rif,
                $row->direc1,
                $row->telefonos,
                $row->email,
                $row->zon_des,
                $row->des_tipo,
                $row->sada,
                //'<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
                $row->status,
                $row->co_cli,
                $row->direc_ent
                     
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
