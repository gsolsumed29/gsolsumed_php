<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usera extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('usera_model');
	}

	public function index(){
		//load session library
		$this->load->library('session');

		//restrict users to go back to login if session has been set
		if($this->session->userdata('user')){
            //$data['niveles'] = $this->usera_model->getnivel();
            //$data['empresas'] = $this->usera_model->getempresas();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('usera/index');
		}
		else{
			redirect('/');
		}
	}

    public function user_vali2($idusuario)
    {
        $data = $this->usera_model->get_user_vali2($idusuario);
        echo json_encode($data);
    }

    public function viewimg($idusuario){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['idusuario'] = $idusuario;
            //$data['firma'] = $this->usera_model->getfirma($idusuario);
            $this->load->view('usera/view_img',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function adduser(){
		$idusuario = $this->input->post('nidusuario');
		$nombre = $this->input->post('nnombre');
        $usuario = $this->input->post('nusuario');
        $correo = $this->input->post('ncorreo');
        $rif = $this->input->post('nrif');
		$no_repertir = $this->usera_model->no_repetir_user($idusuario,$usuario);
        if($no_repertir->si > 0){
				//si ya existe cliente
					$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$usuario;
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->usera_model->add_user($idusuario,$usuario,$nombre,$correo,$rif);
		if ($datos_detalle) {
			$jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$usuario;
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}else{
			$jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$usuario;
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
		}
                    } 
		
    
    }

    public function updateuser(){
        $idusuario = $this->input->post('nidusuario');
        $nombre = $this->input->post('nnombre');
        $usuario = $this->input->post('nusuario');
        $correo = $this->input->post('ncorreo');
        $rif = $this->input->post('nrif');
       
        $no_repertir = $this->usera_model->no_repetir_user2($idusuario,$usuario);
        if($no_repertir->si > 0){
                //si ya existe cliente
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$usuario;
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->usera_model->update_user($idusuario,$usuario,$nombre,$correo,$rif);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$usuario;
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$usuario;
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
                    } 
        
    
    }

    public function deleteuser($idusuario,$borrado){
        $datos_detalle = $this->usera_model->delete_user(rawurldecode($idusuario),$borrado);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Estatus del usuario '.rawurldecode($idusuario);
                $jsondata['type'] = $borrado;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.rawurldecode($idusuario);
                $jsondata['type'] = $borrado;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

    public function empini($idusuario,$emp){
        $no_repertir = $this->usera_model->verificar_emp(rawurldecode($idusuario),rawurldecode($emp));
        if($no_repertir->si > 0){
            $datos_del = $this->usera_model->del_emp_inicial(rawurldecode($idusuario),0);
        $datos_detalle = $this->usera_model->emp_inicial(rawurldecode($idusuario),rawurldecode($emp),1);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Estatus del usuario '.rawurldecode($idusuario);
                $jsondata['type'] = $emp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.rawurldecode($idusuario);
                $jsondata['type'] = $emp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
    }else{
        $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error la empresa no esta asociada al usuario '.rawurldecode($idusuario);
                $jsondata['type'] = $emp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    }

    }

    public function restablecer($idusuario){
        $datos_detalle = $this->usera_model->restablecer(rawurldecode($idusuario));
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Contraseña actualizada '.rawurldecode($idusuario);
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.rawurldecode($idusuario);
                $jsondata['type'] = $idusuario;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

	public function getusera()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        //$codigo = $this->input->post('codigo');
        $usuario = $this->input->post('usuario');
        $nombre = $this->input->post('nombre');
        $status = $this->input->post('status');

        $list = $this->usera_model->get_usera($usuario,$nombre,$status);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
           $data[] = array(
                //$item,
                trim($row->idusuario),
                $row->usuario.' - '.$row->nombre,
                $row->rif,
                $row->nombre,
                $row->correo,
                '<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
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

    public function asigemp($idusuario){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['idusuario'] = $idusuario;
            $data['empresas'] = $this->usera_model->get_empresas($idusuario);
            $this->load->view('usera/view_empresas',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function asigemp2($idusuario,$idemp,$marcado){
        $no_repertir = $this->usera_model->no_repetir_empsup($idusuario,$idemp);
        if($no_repertir->si > 0){
        $datos_detalle = $this->usera_model->empsup($idusuario,$idemp,$marcado);
        }else{
        $datos_detalle = $this->usera_model->empsup2($idusuario,$idemp,$marcado);
        }
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Empresa Actualizado '.rawurldecode($idusuario);
                $jsondata['type'] = $idemp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.rawurldecode($idusuario);
                $jsondata['type'] = $idemp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

    public function asigemp3($idusuario,$idemp,$co_ven){
        if($co_ven == '-'){
            $co_ven='';
        }
        $no_repertir = $this->usera_model->no_repetir_empsup($idusuario,$idemp);
        if($no_repertir->si > 0){
        $datos_detalle = $this->usera_model->empsup3($idusuario,$idemp,$co_ven);
        }else{
        //$datos_detalle = $this->usera_model->empsup2($idusuario,$idemp,$marcado);
        }
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Empresa Actualizado '.$idusuario;
                $jsondata['type'] = $idemp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.$idusuario;
                $jsondata['type'] = $idemp;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

    public function asigmenu($idusuario){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['idusuario'] = $idusuario;
            $data['menu'] = $this->usera_model->get_menu();
            $this->load->view('usera/view_menu',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function levelsup($idusuario,$idmenu,$marcado){
        $no_repertir = $this->usera_model->no_repetir_levelsup($idusuario,$idmenu);
        if($no_repertir->si > 0){
        $datos_detalle = $this->usera_model->levelsup($idusuario,$idmenu,$marcado);
        }else{
        $datos_detalle = $this->usera_model->levelsup2($idusuario,$idmenu,$marcado);
        }
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Menu Actualizado '.$idusuario;
                $jsondata['type'] = $idmenu;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.$idusuario;
                $jsondata['type'] = $idmenu;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }

    public function levelsdown($idusuario,$idmenu,$idsubmenu,$marcado){
        $no_repertir = $this->usera_model->no_repetir_levelsdown($idusuario,$idmenu,$idsubmenu);
        if($no_repertir->si > 0){
        $datos_detalle = $this->usera_model->levelsdown($idusuario,$idmenu,$idsubmenu,$marcado);
        }else{
        $datos_detalle = $this->usera_model->levelsdown2($idusuario,$idmenu,$idsubmenu,$marcado);
        }
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Menu Actualizado '.$idusuario;
                $jsondata['type'] = $idsubmenu;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar '.$idusuario;
                $jsondata['type'] = $idsubmenu;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

    }


}
