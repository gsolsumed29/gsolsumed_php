<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advancement extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('advancement_model');
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
            $data['fpago'] = $this->advancement_model->get_fpago();
            $data['bancos'] = $this->advancement_model->get_bancos();
            $data['cuentas'] = $this->advancement_model->get_cuentas();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('advancement/index', $data);
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
			//$data['clientes'] = $this->advancement_model->get_cliente($co_cli);
            $data['cxc'] = $this->advancement_model->get_cxc($co_cli);
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
            $this->load->view('advancement/imagen',$data);
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
                    $codcobro = $this->advancement_model->add_comprobante($co_cob,$newName0);

/*$this->load->library('email');
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
        $data = $this->advancement_model->get_cxc_monto($facturas);
        echo json_encode($data);
    }

    public function save_cobro(){
        $codcliente = $this->input->post('ncodcliente');
        $pagar = $this->input->post('npagar');
        $pagar=str_replace(".", "", $pagar);
        $pagar=str_replace(",", ".", $pagar);
        $observacion = $this->input->post('nobserva');
        $codformapago = $this->input->post('nfpago');
        $fechita = $this->input->post('nfecha');
        $fecha=date("Y-m-d", strtotime($fechita));
        $ndocumento = $this->input->post('ndocumento');
        $banco = $this->input->post('nbanco');
        $cta = $this->input->post('ncta');
        $co_ven = $this->input->post('nco_ven');
        $tipo='ADE';
        $codentidad=1;
        $fact_ultimo = $this->advancement_model->obtener_co_cob_tmp();
        $co_cob=$fact_ultimo->ultimo;
        //aqui va upload img principal
                if(!empty($_FILES['principal']['name'])){
                $config['upload_path']="./images/cobros";
                $config['file_name'] = trim($co_cob);
                $config['overwrite']=true;
                $config['allowed_types']='jpg|jpeg|png';
                //$config['max_size'] = '5120';
                //$config['max_width']  = '350';
                //$config['max_height']  = '150';      
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('principal')){
                    $fileData = $this->upload->data();
                    $path = $fileData['file_name'];
                    $newName0 = $co_cob.".".pathinfo($path, PATHINFO_EXTENSION);

        $codcobro = $this->advancement_model->add_cobro($co_cob,$co_ven,$codcliente,$pagar,$codformapago,$ndocumento,$fecha,$observacion,$tipo,$banco,$cta);
        if ($codcobro) {
            $codcobro1 = $this->advancement_model->add_comprobante($co_cob,$newName0);
            $cliente = $this->advancement_model->obtener_cli($codcliente);
            $vendedor = $this->advancement_model->obtener_ven($co_ven);
            $fpago = $this->advancement_model->obtener_fpago($codformapago);
            $banco = $this->advancement_model->obtener_banco($banco);
            $cuenta = $this->advancement_model->obtener_cta($cta);
            require "phpmailer/class.phpmailer.php";
            require "phpmailer/class.smtp.php";
      $email_user = "notificacion@grupo-amanecer.com";
      $email_password = "notificacionesamanecer";
      $the_subject = "Notificacion de pago.";
      $address_to = "gaop03@gmail.com";
      $from_name = "GMobile";
      $template = file_get_contents("phpmailer/mail-pago.html");
        $subject = "Notificacion de pago.";

        $template = str_replace(array("<!-- #{Subject} -->", "<!-- #{Cobro} -->", "<!-- #{Fecha} -->", "<!-- #{Monto} -->", "<!-- #{NDocu} -->", "<!-- #{CoVen} -->", "<!-- #{CoCli} -->", "<!-- #{Cliente} -->", "<!-- #{Vendedor} -->", "<!-- #{Observa} -->", "<!-- #{FPago} -->", "<!-- #{Banco} -->", "<!-- #{Cta} -->"),array($the_subject, $co_cob, $fecha, $pagar, $ndocumento, $co_ven, $codcliente, $cliente->cli_des, $vendedor->ven_des, $observacion, $fpago->descripcion, $banco->des_ban, $cuenta->num_cta),$template);

      $phpmailer = new PHPMailer();
      // ---------- datos de la cuenta de Gmail -------------------------------
      $phpmailer->Username = $email_user;
      $phpmailer->Password = $email_password; 
      //-----------------------------------------------------------------------
      $phpmailer->SMTPDebug = 0;
      $phpmailer->SMTPSecure = 'ssl';
      //$phpmailer->SMTPSecure = 'tls';
      $phpmailer->Host = "smtp.gmail.com"; // GMail
      //$phpmailer->Host = "mail.grupo-amanecer.com"; // GMail
      $phpmailer->Port = 465;
      //$phpmailer->Port = 587;
      $phpmailer->IsSMTP(); // use SMTP
      $phpmailer->SMTPAuth = true;
      $phpmailer->setFrom($email_user,$from_name);
      $phpmailer->AddAddress($address_to); // recipients email
      //$phpmailer->AddReplyTo($email_user); // recipients email
      $phpmailer->CharSet = 'utf-8';
        $phpmailer->Subject = $the_subject;
        $phpmailer->MsgHTML($template);
        $phpmailer->addAttachment('images/cobros/'.$newName0);
      $phpmailer->IsHTML(true);//$phpmailer->Send();
      if(!$phpmailer->Send()) {
          //echo "Error: " . $phpmailer->ErrorInfo;
                $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Cobro: '.$codcobro.' - Error al enviar correo: '.$phpmailer->ErrorInfo;
                $jsondata['codfactura'] = $codcliente;
                $jsondata['refrescar'] = 1;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
      } else {
          //echo "Mensaje enviado correctamente";
                $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Cobro: '.$codcobro;
                $jsondata['codfactura'] = $codcliente;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
      }

        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar Cobro';
                $jsondata['codfactura'] = $codcliente;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
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
        }else{ // no agrego la img del comprobante
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error debe agregar el Comprobante de pago.';
                //$jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

	public function anular($codigo){
        $datos_detalle = $this->advancement_model->anular($codigo);
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
        $list = $this->advancement_model->get_client($rif,$nombre,$co_ven,$fini,$ffin);
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
                $row->monto,
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
