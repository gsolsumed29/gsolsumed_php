<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nvxf extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('nvxf_model');
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
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('nvxf/index');
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
        $list = $this->nvxf_model->get_client($rif,$nombre,$co_ven,$fini,$ffin);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(
                $item,
                $row->co_cli.' - '.$row->cli_des,
                $row->cli_des,
                $row->rif,
                $row->fec_ult_ve,
                $row->des_tipo,
                $row->fecha_reg,
                $row->zon_des,
                $row->Nuevo
                     
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
