<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charges extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('charges_model');
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
            $data['fpago'] = $this->charges_model->get_fpago();
            $data['bancos'] = $this->charges_model->get_bancos();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('charges/index', $data);
		}
		else{
			redirect('/');
		}
	}


	public function search_cli($co_cli){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['co_cli'] = $co_cli;
			//$data['clientes'] = $this->charges_model->get_cliente($co_cli);
            $data['cxc'] = $this->charges_model->get_cxc($co_cli);
			$this->load->view('cxc/search_cli',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

    public function imagen($co_cob){
        //load session library
        $this->load->library('session');
        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['co_cob'] = $co_cob;
            $this->load->view('charges/imagen',$data);
        }
        else{
            redirect('/');
        }
    }

    public function imagensave()
    {

        $co_cob=$this->input->post('ecodigo1');
 
                //aqui va upload img principal
                if(!empty($_FILES['principal0']['name'])){
                $config['upload_path']="./images/cobros";
                $config['file_name'] = trim($co_cob);
                $config['overwrite']=true;
                $config['allowed_types']='jpg|jpeg|png';
                //$config['max_size'] = '5120';
                //$config['max_width']  = '350';
                //$config['max_height']  = '150';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('principal0')){
                    $fileData = $this->upload->data();
                    $path = $fileData['file_name'];
                    $newName0 = $co_cob.".".pathinfo($path, PATHINFO_EXTENSION);
                    $codcobro = $this->charges_model->add_comprobante($co_cob,$newName0);
/*
$this->load->library('email');
$htmlContent = '<h1>Notificaci&oacute;n de pago Cobro '.$co_cob.'</h1>';
$htmlContent .= '<p>Adjunto el Comprobante de pago.</p>';
//Indicamos el protocolo a utilizar
        $config['protocol'] = 'smtp';
       //El servidor de correo que utilizaremos
        $config["smtp_host"] = 'mail.adsystemsolution.com.ve';
       //Nuestro usuario
        $config["smtp_user"] = 'soporte@adsystemsolution.com.ve';
       //Nuestra contraseña
        $config["smtp_pass"] = 'S0p0rt3ads';   
       //El puerto que utilizará el servidor smtp
        $config["smtp_port"] = '587';
       //El juego de caracteres a utilizar
        $config['charset'] = 'utf-8';
       //Permitimos que se puedan cortar palabras
        $config['wordwrap'] = TRUE;
        //SMTPSecure
        $config['smtp_crypto'] = 'tls'; 
       //El email debe ser valido 
       $config['validate'] = true;
       $config['mailtype'] = 'html';
$this->email->initialize($config);
$this->email->to('notificacion@grupo-amanecer.com');
$this->email->from('soporte@adsystemsolution.com.ve','GMobile');
$this->email->subject('Comprobante de pago ('.$co_cob.')');
$this->email->message($htmlContent);
$this->email->attach('./images/cobros/'.$newName0);
$this->email->send();*/

                    $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Publicacion Satisfactoriamente.';
                //$jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
                }else{
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar el Comprobante.';
                //$jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
                }
            }

    }


     public function enviar($co_cob){
      /*
       * Cuando cargamos una librería
       * es similar a hacer en PHP puro esto:
       * require_once("libreria.php");
       * $lib=new Libreria();
       */
        
       //Cargamos la librería email
       $this->load->library('email');
        
       /*
        * Configuramos los parámetros para enviar el email,
        * las siguientes configuraciones es recomendable
        * hacerlas en el fichero email.php dentro del directorio config,
        * en este caso para hacer un ejemplo rápido lo hacemos
        * en el propio controlador
        */
        
       //Indicamos el protocolo a utilizar
        $config['protocol'] = 'smtp';
         
       //El servidor de correo que utilizaremos
        $config["smtp_host"] = 'smtp.gmail.com';
         
       //Nuestro usuario
        $config["smtp_user"] = 'correo@gmail.com';
         
       //Nuestra contraseña
        $config["smtp_pass"] = 'contraseña';   
         
       //El puerto que utilizará el servidor smtp
        $config["smtp_port"] = '587';
        
       //El juego de caracteres a utilizar
        $config['charset'] = 'utf-8';
 
       //Permitimos que se puedan cortar palabras
        $config['wordwrap'] = TRUE;
         
       //El email debe ser valido 
       $config['validate'] = true;
       
        
      //Establecemos esta configuración
        $this->email->initialize($config);
 
      //Ponemos la dirección de correo que enviará el email y un nombre
        $this->email->from('gaop03@gmail.com', 'Notificacion');
         
      /*
       * Ponemos el o los destinatarios para los que va el email
       * en este caso al ser un formulario de contacto te lo enviarás a ti
       * mismo
       */
        $this->email->to('gaop03@gmail.com', 'Gabriel Ochoa');
         
      //Definimos el asunto del mensaje
        $this->email->subject($this->input->post("asunto"));
         
      //Definimos el mensaje a enviar
        $this->email->message(
                "Email: ".$this->input->post("email").
                " Mensaje: ".$this->input->post("mensaje")
                );
         
        //Enviamos el email y si se produce bien o mal que avise con una flasdata
        if($this->email->send()){
            $this->session->set_flashdata('envio', 'Email enviado correctamente');
        }else{
            $this->session->set_flashdata('envio', 'No se a enviado el email');
        }
         
        redirect(base_url("contacto"));
   }    

    public function cobrar($facturas)
    {
        $data = $this->charges_model->get_cxc_monto($facturas);
        echo json_encode($data);
    }

    public function save_cobro(){
        $codfactura = $this->input->post('ccodfactura');
        $facturas=explode("~", $codfactura);
        $codcliente = $this->input->post('ccodcliente');
        $pagar = $this->input->post('cpagar2');
        $saldo = $this->input->post('csaldo2');
        $observacion = $this->input->post('cobserva');
        $codformapago = $this->input->post('cfpago');
        $fechita = $this->input->post('cfecha');
        $fecha=date("Y-m-d", strtotime($fechita));
        $ndocumento = $this->input->post('cdocumento');
        $co_ven = $this->input->post('cco_ven');
        if($pagar > $saldo){ // error monto es mayor al saldo 
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error el monto es mayor al saldo.';
                $jsondata['codfactura'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{ //todo bien
        
        $codentidad=1;
        $fact_ultimo = $this->charges_model->obtener_co_cob_tmp();
        $co_cob=$fact_ultimo->ultimo;
        $codcobro = $this->charges_model->add_cobro($co_cob,$co_ven,$codcliente,$pagar,$codformapago,$ndocumento,$fecha,$observacion);
        if ($codcobro) {

            $i=0;
            foreach ($facturas as $factura) {
                $reng_ultimo = $this->charges_model->obtener_reng_num($co_cob);
                $reng_num=$reng_ultimo->ultimo;
                $add_reng = $this->charges_model->add_reng_cobro($co_cob,$reng_num,$facturas[$i]);
                $i++;
            }

            

            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Cobro: '.$codcobro;
                $jsondata['codfactura'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar Cobro';
                $jsondata['codfactura'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

        }

    }

	public function anular($codigo){
        $datos_detalle = $this->charges_model->anular($codigo);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Registro '.$codigo.' Eliminado';
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Eliminar '.$codigo;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
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
        $list = $this->charges_model->get_client($rif,$nombre,$co_ven,$fini,$ffin);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(
                //$item,
                trim($row->co_cli),
                trim($row->co_cob).' / '.trim($row->co_cli).' - '.trim($row->cli_des),
                number_format($row->saldo,2,',','.'),
                trim($row->co_cob),
                $row->fec_emis,
                $row->fec_pago,
                $row->descripcion,
                $row->observacion,
                $row->des_ban,
                $row->status
                     
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
