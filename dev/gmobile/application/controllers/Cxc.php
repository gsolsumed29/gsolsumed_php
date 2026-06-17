<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cxc extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('cxc_model');
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
            $data['fpago'] = $this->cxc_model->get_fpago();
            $data['bancos'] = $this->cxc_model->get_bancos();
            $data['cuentas'] = $this->cxc_model->get_cuentas();
            $data['vendedores'] = $this->cxc_model->get_vendedores();
            $data['sucursales'] = $this->cxc_model->get_sucu();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('cxc/index', $data);
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
			//$data['clientes'] = $this->cxc_model->get_cliente($co_cli);
            $data['cxc'] = $this->cxc_model->get_cxc($co_cli);
			$this->load->view('cxc/search_cli',$data);
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

    public function cobrar($facturas)
    {
        $data = $this->cxc_model->get_cxc_monto($facturas);
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
        $banco = $this->input->post('cbanco');
        $cta = $this->input->post('ccta');
        $co_ven = $this->input->post('cco_ven');
        $tipo='COB';
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
        $fact_ultimo = $this->cxc_model->obtener_co_cob_tmp();
        $co_cob=$fact_ultimo->ultimo;

        $data = array();
                //aqui va upload img principal
                if(!empty($_FILES['principal']['name'])){ // si agrego la img del comprobante

                $config['upload_path']="./images/cobros";
                $config['file_name'] = trim($co_cob);
                $config['overwrite']=true;
                $config['allowed_types']='jpg|jpeg|png';
                //$config['max_size'] = '5120';
                //$config['max_width']  = '350';
                //$config['max_height']  = '150';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('principal')){ //si guardo la img del comprobante
                    $fileData = $this->upload->data();
                    $path = $fileData['file_name'];
                    $newName0 = $co_cob.".".pathinfo($path, PATHINFO_EXTENSION);
        $codcobro = $this->cxc_model->add_cobro($co_cob,$co_ven,$codcliente,$pagar,$codformapago,$ndocumento,$fecha,$observacion,$banco,$tipo,$cta);
        if ($codcobro) { // si inserto el cobro
            $i=0;
            foreach ($facturas as $factura) {
                $reng_ultimo = $this->cxc_model->obtener_reng_num($co_cob);
                $reng_num=$reng_ultimo->ultimo;
                $add_reng = $this->cxc_model->add_reng_cobro($co_cob,$reng_num,$facturas[$i]);
                $i++;
            }
            $codcobro = $this->cxc_model->add_comprobante($co_cob,$newName0);
            $cliente = $this->cxc_model->obtener_cli($codcliente);
            $vendedor = $this->cxc_model->obtener_ven($co_ven);
            $fpago = $this->cxc_model->obtener_fpago($codformapago);
            if($banco == '0'){
                $banco = $this->cxc_model->obtener_banco2($banco);
                $cuenta = $this->cxc_model->obtener_caja($cta);
            }else{
                $banco = $this->cxc_model->obtener_banco($banco);
                $cuenta = $this->cxc_model->obtener_cta($cta);
            }
            
            $cmail = $this->cxc_model->obtener_config_email(1);
            $dmail = $this->cxc_model->obtener_config_email(3);
            $empbd=$this->session->userdata('empbd');
            require "phpmailer/class.phpmailer.php";
            require "phpmailer/class.smtp.php";
			$email_user = $cmail->email;//"gmobileapi@gmail.com"
			$email_password = $cmail->password;//"GM0bil3*#"
			$the_subject = "Notificacion de pago.";
			$address_to = $dmail->email;//"gaop03@gmail.com"
			$from_name = "GMobile";
			$template = file_get_contents("phpmailer/mail-pago.html");
    		$subject = "Notificacion de pago.";
    		$the_subject2 = 'Notificacion de Cobro: '.$co_cob.' - Vendedor: '.trim($vendedor->ven_des);

    		$template = str_replace(array("<!-- #{Subject} -->", "<!-- #{Cobro} -->", "<!-- #{Fecha} -->", "<!-- #{Monto} -->", "<!-- #{NDocu} -->", "<!-- #{CoVen} -->", "<!-- #{CoCli} -->", "<!-- #{Cliente} -->", "<!-- #{Vendedor} -->", "<!-- #{Observa} -->", "<!-- #{FPago} -->", "<!-- #{Banco} -->", "<!-- #{Cta} -->"),array($the_subject, $co_cob.' - Empresa: '.$empbd, $fecha, $pagar, $ndocumento, $co_ven, $codcliente, trim($cliente->cli_des), trim($vendedor->ven_des), $observacion, trim($fpago->descripcion), $banco->des_ban, $cuenta->num_cta),$template);

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
			$phpmailer->addBCC($email_user);
			$phpmailer->CharSet = 'utf-8';
    		$phpmailer->Subject = $the_subject2;
    		$phpmailer->MsgHTML($template);
    		$phpmailer->addAttachment('images/cobros/'.$newName0);
			$phpmailer->IsHTML(true);//$phpmailer->Send();
			if(!$phpmailer->Send()) {
  				//echo "Error: " . $phpmailer->ErrorInfo;
                $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Cobro: '.$codcobro.' - Error al enviar correo: '.$phpmailer->ErrorInfo;
                $jsondata['codfactura'] = $codfactura;
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
                $jsondata['codfactura'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
			}   
        }else{  //else de si inserto el cobro
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar Cobro';
                $jsondata['codfactura'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
                }else{ // else si no guardo la img del comprobante
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar el Comprobante.';
                //$jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
                }
            //} for img
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

        } // fin de todo bien

    }

    public function ctachange()
    {
        header('Content-Type: application/json');
        $fpago = $this->input->post('id');
        if(trim($fpago) == 'EFEC'){
            $list = $this->cxc_model->get_cajas();
        }else{
            $list = $this->cxc_model->get_cuentas();
        }
        print_r( json_encode ( $list ) );
    }

	

	public function getclient()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $rif = $this->input->post('rif');
        $nombre = $this->input->post('nombre');
        $co_ven = $this->input->post('co_ven');
        $co_sucu = $this->input->post('co_alma');
        if(trim($co_ven) == ''){ $co_ven='999';}
        $list = $this->cxc_model->get_client($rif,$nombre,$co_ven,$co_sucu);
        $data = array();
        $item=1;
        $saldo_total=0;
      foreach($list->result() as $row) {
        $opciones='';
        $saldo_total=($saldo_total + $row->saldo);
        
           $data[] = array(
                //$item,
                trim($row->co_cli),
                trim($row->co_cli).' - '.trim($row->cli_des),
                ($row->saldo < 0) ? '<span class="badge badge-success">'.number_format($row->saldo,2,',','.').'</span>' : '<span class="badge badge-danger">'.number_format($row->saldo,2,',','.').'</span>', 
                //number_format($row->saldo,2,',','.'),
                $row->saldo
                     
           );
           $item++;
      }
      /*$data[] = array(
                //$item,
                'GGGGGGGG',
                'NOMBREEE',
                $saldo_total,
                '0'
                     
           );*/
      $result = array(
               "draw" => $draw,
                 //"recordsTotal" => $saldo_total,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
            );
      echo json_encode($result);
      exit();
    }


}
