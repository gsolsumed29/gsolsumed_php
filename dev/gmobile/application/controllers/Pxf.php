<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pxf extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		$this->load->model('pxf_model');
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
			$this->load->view('pxf/index');
		}
		else{
			redirect('/');
		}
	}

	public function search_cli($fact_num){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['fact_num'] = $fact_num;
            $data['detallado'] = $this->pxf_model->get_detallado($fact_num);
			$this->load->view('pxf/search_cli',$data);
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
        $fini = $this->input->post('fini');
        $ffin = $this->input->post('ffin');
        $facturados = $this->input->post('facturados');
        $co_ven = $this->input->post('co_ven');
        $list = $this->pxf_model->get_client($co_ven,$fini,$ffin,$facturados);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(
                $row->fact_num,
                $row->fact_num,
                trim($row->co_cli.' - '.$row->cli_des),
                number_format($row->tot_bruto,2,',','.'),
                $row->cli_des,
                $row->rif,
                $row->fec_emis,
                number_format($row->saldo,2,',','.'),
                number_format($row->tot_neto,2,',','.'),
                $row->factura
                     
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
