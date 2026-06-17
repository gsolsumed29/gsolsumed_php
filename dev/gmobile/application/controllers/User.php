<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
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
			redirect('home');
		}
		else{
			$this->load->helper('url');
			$this->load->view('head');
			$this->load->view('login');
			$this->load->view('footer');
		}
	}

	public function login(){
		//load session library
		$this->load->library('session');

		$email = $_POST['username'];
		$password = md5(md5($_POST['pass']));

		$data = $this->users_model->login($email, $password);

		if($data){
			$this->session->set_userdata('user', $data);
			$user = $this->session->userdata('user');
			extract($user);
			$emp = $this->users_model->get_empresa_inicial($idusuario);
			//$this->session->set_userdata('listbd', array($emp));
			$this->session->set_userdata('empbd', $emp->idemp);
			$this->session->set_userdata('co_ven', $emp->co_ven);
        
			redirect('home');
		}
		else{
			header('location:'.base_url().$this->index());
			$this->session->set_flashdata('error','Usuario o Contraseña invalida.');
		} 
	}

	public function home(){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){

			$co_ven = $this->session->userdata('co_ven');
			$this->load->view('head');
			$this->load->view('header');
			if(trim($co_ven) == '999'){
				$data['grafica_fact_montos'] = $this->users_model->grafica_fact_montos(trim($co_ven));
				$data['grafica_art_ven'] = $this->users_model->grafica_art_ven(trim($co_ven));
				$this->load->view('home_gerencial',$data);
			}else{ $this->load->view('home'); }
			//$this->load->view('footer');
		}
		else{
			redirect('/');
		}
		
	}

	public function cambiar_bd($empresa){
		$this->load->library('session');
		$user = $this->session->userdata('user');
			extract($user);
			$emp = $this->users_model->get_co_ven($idusuario,$empresa);
        	$this->session->set_userdata('empbd', $empresa);
        	$this->session->set_userdata('co_ven', $emp->co_ven);
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'La '.$empresa.' seleccionada.';
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        
    }

    public function updatepass(){
    	$rif = strtoupper($this->input->post('nrif'));
        $usuario = strtoupper($this->input->post('nusu'));
        $correo = strtoupper($this->input->post('nemail'));
        $pass1 = md5(md5(strtoupper($this->input->post('npass1'))));
        $pass2 = md5(md5(strtoupper($this->input->post('npass2'))));
        if($pass1 == $pass2){

        $datos_usu = $this->users_model->validar_usu($usuario,$rif,$correo);
        if ($datos_usu) {

            $datos_detalle = $this->users_model->update_pass($datos_usu->idusuario,$pass1);
        if ($datos_detalle) {
        	
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Contraseña Actualizada '.$usuario;
                $jsondata['type'] = 1;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar la Contraseña '.$usuario.'';
                $jsondata['type'] = 0;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error Datos del Usuario: '.$usuario.' no son validos.';
                $jsondata['type'] = 0;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
    }else{
    	$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error Contraseñas no concuerdan.'.$usuario;
                $jsondata['type'] = 0;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    }

    }

	public function logout(){
		//load session library
		$this->load->library('session');
		$this->session->unset_userdata('user');
		redirect('/');
	}

}
