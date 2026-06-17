<?php
   header('Access-Control-Allow-Origin: *');

defined('BASEPATH') OR exit('No direct script access allowed');

class Rg extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('users_model');
    $this->load->model('rg_model');
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
      $data['vendedores'] = $this->rg_model->get_vendedores();
      $data['sucursales'] = $this->rg_model->get_sucu();
      $this->load->view('head');
      $this->load->view('header');
      $this->load->view('rg/index',$data);
    }
    else{
      redirect('/');
    }
  }

  public function report($fini,$ffin,$fcosto,$co_sucu){
    $facturado = $this->rg_model->get_facturado($fini,$ffin,$co_sucu);
    $ncr = $this->rg_model->get_ncr($fini,$ffin,$co_sucu);

    $cos_mer = $this->rg_model->get_cos_mer($fini,$ffin,$fcosto,$co_sucu);
    $cos_mer_dev = $this->rg_model->get_cos_mer_dev($fini,$ffin,$fcosto,$co_sucu);

    $gastos = $this->rg_model->get_gastos($fini,$ffin,$co_sucu);
    $aju_inv_fal = $this->rg_model->get_aju_inv_fal($fini,$ffin,$co_sucu);
    $aju_inv_fis = $this->rg_model->get_aju_inv_fis($fini,$ffin,$co_sucu);

    $cajas = $this->rg_model->get_cajas($fini,$ffin,$co_sucu);
    $bancos = $this->rg_model->get_bancos($fini,$ffin,$co_sucu);
    $inventarios = $this->rg_model->get_inventarios($fini,$ffin,$fcosto,$co_sucu);
    $cxc = $this->rg_model->get_cxc($fini,$ffin,$co_sucu);

    $cxp = $this->rg_model->get_cxp($fini,$ffin,$co_sucu);
    $gxp = $this->rg_model->get_gxp($fini,$ffin,$co_sucu);
    
    $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'mensaje.';
                $jsondata['facturado'] = number_format($facturado->monto,2,',','.');
                $jsondata['ncr'] = number_format($ncr->monto,2,',','.');
                $jsondata['tventas'] = number_format(($facturado->monto - $ncr->monto),2,',','.');

                $jsondata['cosmer'] = number_format($cos_mer->monto,2,',','.');
                $jsondata['cosdev'] = number_format($cos_mer_dev->monto,2,',','.');
                $jsondata['tcostos'] = number_format(($cos_mer->monto - $cos_mer_dev->monto),2,',','.');

                $tutibruvta = (($facturado->monto - $ncr->monto) - ($cos_mer->monto - $cos_mer_dev->monto));
                $jsondata['tutibruvta'] = number_format($tutibruvta,2,',','.');;

                $jsondata['tgastos'] = number_format($gastos->monto,2,',','.');
                $jsondata['ajustfaltinv'] = number_format($aju_inv_fal->monto,2,',','.');
                $jsondata['ajustfaltinvfis'] = number_format($aju_inv_fis->monto,2,',','.');
                $jsondata['tutineta'] = number_format($tutibruvta - ($gastos->monto + $aju_inv_fal->monto + $aju_inv_fis->monto),2,',','.');

                $jsondata['tcajas'] = number_format($cajas->monto,2,',','.');
                $jsondata['tbancos'] = number_format($bancos->monto,2,',','.');
                $jsondata['tinventarios'] = number_format($inventarios->monto,2,',','.');
                $jsondata['tcxc'] = number_format($cxc->monto,2,',','.');
                $jsondata['tactivos'] = number_format(($cajas->monto + $bancos->monto + $inventarios->monto + $cxc->monto),2,',','.');

                $jsondata['tcxp'] = number_format($cxp->monto,2,',','.');
                $jsondata['tgxp'] = number_format($gxp->monto,2,',','.');
                $jsondata['tpmonetaria'] = number_format((($cajas->monto + $bancos->monto + $inventarios->monto + $cxc->monto) - ($cxp->monto + $gxp->monto)),2,',','.');
                
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();

  }


}
