<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rxv extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('rxv_model');
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
      $data['vendedores'] = $this->rxv_model->get_vendedores();
			$this->load->view('head');
			$this->load->view('header');
			$this->load->view('rxv/index',$data);
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
        //$rif = $this->input->post('rif');
        $nombre = $this->input->post('nombre');
        $fini = $this->input->post('fini');
        //$fini=date("Y-m-d", strtotime($fini));
        $ffin = $this->input->post('ffin');
        //$ffin=date("Y-m-d", strtotime($ffin));
        $co_ven = $this->input->post('co_ven');
        $list = $this->rxv_model->get_client($nombre,$co_ven,$fini,$ffin);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(
                //$item,
                $row->co_ven.' - '.$row->ven_des,
                $row->co_art.' - '.$row->art_des,
                number_format($row->uni_vta,2,',','.'),
                number_format($row->uni_dev,2,',','.'),
                number_format($row->tot_ven,2,',','.'),
                $row->uni_vta,
                $row->uni_dev,
                $row->tot_ven
                     
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
