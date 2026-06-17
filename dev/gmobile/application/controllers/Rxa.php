<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rxa extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('users_model');
    $this->load->model('rxa_model');
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
      $this->load->view('rxa/index');
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
        
        $list = $this->rxa_model->get_articles($codigo,$nombre);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        
           $data[] = array(//a.co_art, a.art_des, a.tipo, a.stock_act, a.prec_vta1, a.prec_vta2,a.prec_vta3, a.prec_vta4, a.prec_vta5, a.prec_agr1, a.tipo_imp
                //$item,
                $row->co_art.' - '.$row->art_des,
                //$row->art_des,
                number_format($row->stock_act,2,',','.'),
                number_format($row->prec_vta1,2,',','.'),
                //$row->tipo,
                //$row->tipo_imp,
                number_format($row->prec_vta2,2,',','.'),
                number_format($row->prec_vta3,2,',','.'),
                number_format($row->prec_vta4,2,',','.'),
                number_format($row->prec_vta5,2,',','.'),
                number_format($row->ult_cos_un,2,',','.'),
                number_format($row->cos_pro_un,2,',','.')    

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
