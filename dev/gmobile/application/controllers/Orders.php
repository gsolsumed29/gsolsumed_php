<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    function __construct(){

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('users_model');
        $this->load->model('orders_model');
        $this->load->library('session');
        if($this->session->userdata('user')){
            $empbd=$this->session->userdata('empbd');
        $this->db = $this->load->database($empbd, TRUE);
        }
        else{
            //redirect('/');
        }
        
    }


    public function mesa_vali($mesa)
    {
        $data = $this->orders_model->get_mesa_vali($mesa);
        echo json_encode($data);
    }
    

    public function index(){
        //load session library
        $this->load->library('session');

        //restrict users to go back to login if session has been set
        if($this->session->userdata('user')){
            //$data['fpago'] = $this->orders_model->getfpago();
            $this->load->view('head');
            $this->load->view('header');
            $this->load->view('orders/index');
        }
        else{
            redirect('/');
        }
    }

    public function add($mesa=''){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['mesa']=$mesa;
            $data['categorias2'] = $this->orders_model->getcategorias2();
            $this->load->view('head');
            $this->load->view('header');
            $this->load->view('orders/add',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function addpedido($mesa,$vendedor,$condicion,$codcliente,$codarticulo){
        $fact_ultimo = $this->orders_model->getultimopedido();
        $ultimo=$fact_ultimo->ultimo;
        $cliente = $this->orders_model->get_cliente($codcliente);
        $cli_des=trim($cliente->cli_des);
        $articulo = $this->orders_model->get_art($codarticulo);
        $prec_vta1=$articulo->prec_vta1;
        $uni_venta=$articulo->uni_venta;
        $co_alma=$articulo->co_alma;
        $cantidad=1;
        $reng_num=1;

        $datos_detalle = $this->orders_model->add_pedido($ultimo,$mesa,$vendedor,$condicion,$codcliente,$cli_des);
        if ($datos_detalle) {
            $datos_detallado = $this->orders_model->add_reng_ped($ultimo,$reng_num,$co_art,$co_alma,$uni_venta,$prec_vta1,$cantidad);
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Factura '.$codfactura.' Anulada.';
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Anular '.$codfactura;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
    }

    public function edit($codfactura){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['invoice'] = $codfactura;
            $this->load->view('head');
            $this->load->view('header');
            $this->load->view('orders/edit',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function search_art($codigo,$descripcion,$categorias,$cliente,$codfacturatmp){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['cliente'] = $cliente;
            $data['codfacturatmp'] = $codfacturatmp;
            $data['articulos'] = $this->orders_model->getarticulos($codigo,$descripcion,$categorias);
            $this->load->view('orders/search_art',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function search_cat($categoria){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['articulos'] = $this->orders_model->getarticuloscat($categoria);
            $this->load->view('orders/search_cat',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function search_plan($codigo,$descripcion,$cliente){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['cliente'] = $cliente;
            $data['plantillas'] = $this->orders_model->getplantillas($codigo,$descripcion);
            $this->load->view('orders/search_plan',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function add_plantillas($codigo,$cliente){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['cliente'] = $cliente;
            $data['plantillas'] = $this->orders_model->getplantillas2($codigo,$cliente);
            $this->load->view('orders/search_plan2',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function cobrar($codfactura)
    {
        $data = $this->orders_model->get_factura($codfactura);
        echo json_encode($data);
    }

    public function fechaedad($edad,$tedad)
    {
        $fecha_actual = date("d-m-Y");
        if($tedad == 'D'){
            $data['fecha'] = date("d-m-Y",strtotime($fecha_actual."- $edad days"));
        }elseif($tedad == 'M'){
            $data['fecha'] = date("d-m-Y",strtotime($fecha_actual."- $edad month"));
        }else{
            $data['fecha'] = date("d-m-Y",strtotime($fecha_actual."- $edad year"));
        }
        echo json_encode($data);
    }

    public function anular($codfactura)
    {
        $data = $this->orders_model->get_anular($codfactura);
        echo json_encode($data);
    }

    public function anular1($codfactura)
    {
        $data = $this->orders_model->get_anular2($codfactura);
        echo json_encode($data);
    }

    public function anular2($codfactura){
        //------------------- inicio descontar stock comprometido ---------------
        $list_ped = $this->orders_model->get_det_ped($codfactura);
        foreach($list_ped as $row){
            //------------------ inicio de stock comprometido ---------------
            $comprometido = $this->orders_model->obtener_stock_com($row->co_art);
            $stock_com=$comprometido->stock_com;
            if($row->pendiente > $stock_com){
                $new_stock_com=0;
            }else{
                $new_stock_com=($stock_com - $row->pendiente);
            }  
            //$new_stock_com=($stock_com - $row->pendiente);          
            $update_comprometido = $this->orders_model->update_stock_com($row->co_art,$new_stock_com);

            $comprometido_st = $this->orders_model->obtener_stock_com_st($row->co_art,'01');
            $stock_com_st=$comprometido_st->stock_com;
            if($row->pendiente > $stock_com_st){
                $new_stock_com_st=0;
            }else{
                $new_stock_com_st=($stock_com_st - $row->pendiente);
            }
            //$new_stock_com_st=($stock_com_st - $row->pendiente);
            $update_comprometido_st = $this->orders_model->update_stock_com_st($row->co_art,$new_stock_com_st,'01');
            //------------------ fin de stock comprometido ---------------
        }
        //------------------- fin descontar stock comprometido ---------------
        
        $datos_detalle = $this->orders_model->anular_fact($codfactura);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Factura '.$codfactura.' Anulada.';
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Anular '.$codfactura;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
    }

    public function search_cli($rif,$nombre,$co_ven){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['clientes'] = $this->orders_model->getclientes($rif,$nombre,$co_ven);
            $this->load->view('orders/search_cli',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function search_mesas($tipo){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['tipo'] = $tipo;
            $data['mesas'] = $this->orders_model->getmesasdispo();
            $this->load->view('orders/search_mesas',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function search_muestras($codfactura){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['codfactura'] = $codfactura;
            $data['muestras'] = $this->orders_model->getmuestras($codfactura);
            $this->load->view('orders/search_muestras',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function procesar_orden($codfactura,$codexamen,$linea){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $cantidad_examen=$this->orders_model->cantidad_examen($codfactura);
                if($cantidad_examen->si > 0){
            if($codexamen == '0'){
                $datos_examen=$this->orders_model->datos_examenes($codfactura);
                $data['cod_art'] = $datos_examen->codigo;
                $data['numlinea'] = $datos_examen->numlinea;
            }else{
                $data['cod_art'] = $codexamen;
                $data['numlinea'] = $linea;
            }
            $data['codfactura'] = $codfactura;
            $data['examenes'] = $this->orders_model->get_examenes($codfactura);
            $data['paciente'] = $this->orders_model->get_paciente($codfactura);
            $this->load->view('orders/procesar_orden',$data);
            }else{
                echo '<center><i class="fa fa-exclamation-triangle"></i> No existe ningun estudios por procesar para la orden selecciona!</center>';
                echo '<script type="text/javascript">noexiste2("estudios por procesar.");</script>';
            }
            
        }
        else{
            redirect('/');
        }
        
    }

    public function save_resultados(){
        $idusuario = $this->input->post('idusuario');
        $codfactura = $this->input->post('codfactura');
        $codexamen = $this->input->post('codexamen');
        $numlinea = $this->input->post('numlinea');
        $validame = $this->input->post('validame');
        $modulo = $this->input->post('modulo');
        $formato_examen=$this->orders_model->formato_examen($codexamen);
        $idfor = $formato_examen->IDFor;

        $delete_result_campos = $this->orders_model->delete_result_campos($codfactura,$codexamen);
        $delete_result_listas = $this->orders_model->delete_result_listas($codfactura,$codexamen);

        $campos_for=$this->orders_model->campos($idfor);
        foreach($campos_for as $campos){
            $id_cam=$campos->IDCam;
            $Nom_campo='campo-'.$id_cam;
            $valorC = $this->input->post($Nom_campo);
            $add_result_campos = $this->orders_model->add_result_campos($codfactura,$codexamen,$id_cam,$valorC,$idfor,$idusuario,$modulo);
        }

        $listas_for=$this->orders_model->listas($idfor);
        foreach($listas_for as $listas){
            $id_lis=$listas->Idlis;
            $Nom_select='select-'.$id_lis;
            $valorL = $this->input->post($Nom_select);
            $add_result_listas = $this->orders_model->add_result_listas($codfactura,$codexamen,$id_lis,$valorL,$idfor,$idusuario,$modulo);
        }

        $fechas=date("Y-m-d H:i:s");
        $sta=2;
        $sta2=3;
        $idusuario2=1;

        $update_factulinea = $this->orders_model->update_factulinea($codfactura,$codexamen,$numlinea,$sta);
        $delete_result_listas = $this->orders_model->update_lista_estudios($codfactura,$codexamen,$numlinea,$sta,$fechas,$idusuario);

        if($validame > 0){
            $update_factulinea = $this->orders_model->update_factulinea($codfactura,$codexamen,$numlinea,$sta2);
            $delete_result_listas = $this->orders_model->update_lista_estudios2($codfactura,$codexamen,$numlinea,$sta2,$fechas,$idusuario2);
            $update_facturas_imp = $this->orders_model->update_facturas_imp($codfactura);
        }

            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Resultados '.$codfactura.' - '.$codexamen.' Guardados.';
                $jsondata['type'] = 'success';
                $jsondata['codfactura'] = $codfactura;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    }

    public function cliente_new($tipo,$rif){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['tipo'] = $tipo;
            $data['rif'] = $tipo;
            //$data['clientes'] = $this->orders_model->getclientes($rif,$nombre,$empresa);
            $this->load->view('orders/cliente_new',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function cliente_vali($rif)
    {
        $data = $this->orders_model->get_cliente_vali($rif);
        echo json_encode($data);
    }

    public function update_totales($admision)
    {
        $data = $this->orders_model->get_update_totales($admision);
        echo json_encode($data);
    }

    public function update_totales2($admision)
    {
        $data = $this->orders_model->get_update_totales2($admision);
        echo json_encode($data);
    }

    public function modif_art($admision,$numlinea,$cliente){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['cliente'] = $cliente;
            $data['articulos'] = $this->orders_model->get_modif_art($admision,$numlinea);
            //$data['precios'] = $this->orders_model->getprecios($articulo,$cliente);
            $this->load->view('orders/modif_art',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function getdettmp()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $codfacturatmp = $this->input->post('codfacturatmp');
        $list = $this->orders_model->get_det_tmp($codfacturatmp);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
           $data[] = array(
                $row->fact_num,
                trim($row->co_art),
                trim($row->art_des),
                $row->total_art,
                $row->prec_vta,
                $row->reng_neto,
                $row->reng_num,
                //'<span class="'.$row->nivel_color.'">'.$row->nivel_msg.'</span>',
                //'<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
                //$row->status,
                
                
                
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

    public function getdetadm()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $codfacturatmp = $this->input->post('codfacturatmp');
        $list = $this->orders_model->get_det_adm($codfacturatmp);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
           $data[] = array(
                $item,
                $row->co_art,
                $row->art_des,
                $row->total_art,
                $row->prec_vta,
                $row->reng_neto,
                //'<span class="'.$row->nivel_color.'">'.$row->nivel_msg.'</span>',
                //'<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
                //$row->status,
                
                
                
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

    public function add_saime($origen,$cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$fecha_nacimiento,$nacionalidad,$pais_origen,$sexo,$naturalizado,$id,$fecha_registro){
        
        $datos_detalle = $this->orders_model->add_saime($origen,$cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$fecha_nacimiento,$nacionalidad,$pais_origen,$sexo,$naturalizado,$id,$fecha_registro);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'add '.$origen.'-'.$cedula;
                $jsondata['type'] = 'success';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al add '.$origen.'-'.$cedula;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
    }

    public function delete_art($codigo,$codfactura){
        $datos_detalle = $this->orders_model->delete_art($codigo,$codfactura);
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

    public function addart(){
        $codarticulo = $this->input->post('codarticulo');
        $cantidad = $this->input->post('cantidad');
        $nuli = $this->input->post('nuli');
        $aumentar = $this->input->post('aumentar');
        $codfacturatmp = $this->input->post('codfacturatmp');
        $datos_art = $this->orders_model->obtener_art($codarticulo);
        $co_alma=$datos_art->co_sucu;
        $stock_actual=number_format($datos_art->stock_act,0,'','');
        $uni_venta=$datos_art->uni_venta;
        $prec_vta1=$datos_art->prec_vta1;
        $tipo_imp=$datos_art->tipo_imp;
        $cos_pro_un=$datos_art->cos_pro_un;
        $ult_cos_un=$datos_art->ult_cos_un;
        $datos_reng_num = $this->orders_model->obtener_reng_num($codfacturatmp);
        $reng_num=$datos_reng_num->ultimo;
        
        if($cantidad > $stock_actual){
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error: Cantidad es mayor a la existencia. '.$codarticulo;
                $jsondata['type'] = '1';
                $jsondata['codarticulo'] = $codarticulo;
                $jsondata['cantidad'] = $cantidad;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{

        $no_repertir = $this->orders_model->no_repetir_art($codfacturatmp,$codarticulo);
        if($no_repertir->si > 0){
            //sumarle 1 a la cantidad
            if($nuli > 0){
                $datos_cantidad = $this->orders_model->obtener_reng_num_cantidad2($codfacturatmp,$codarticulo,$cantidad);
                $cant=$datos_cantidad->ultimo;
                $neto=$datos_cantidad->neto;
            }else{
                if($aumentar > 0){ // si aumentar 1
                    $datos_cantidad = $this->orders_model->obtener_reng_num_cantidad($codfacturatmp,$codarticulo);
                    $cant=$datos_cantidad->ultimo;
                    $neto=$datos_cantidad->neto;
                }else{ // restarle 1 a la cantidad
                    $cantidad_art = $this->orders_model->cantidad_art($codfacturatmp,$codarticulo);
                    if ($cantidad_art->cantidad > 0) {
                        $datos_cantidad = $this->orders_model->obtener_reng_num_cantidad_restar($codfacturatmp,$codarticulo);
                         $cant=$datos_cantidad->ultimo;
                         $neto=$datos_cantidad->neto;
                    }else{
                         $cant=0;
                         $neto=0;
                    }
                    
                }
                
            }
            //$datos_cantidad = $this->orders_model->obtener_reng_num_cantidad($codfacturatmp,$codarticulo);
           if($cant > 0){
            if($cant > $stock_actual){
                $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error: Cantidad es mayor a la existencia. '.$codarticulo;
                $jsondata['type'] = '2';
                $jsondata['codarticulo'] = $codarticulo;
                $jsondata['cantidad'] = number_format(($cant - 1),0,'','');
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
            }else{
                $datos_detalle = $this->orders_model->update_det_tmp($codfacturatmp,$codarticulo,$cant,$neto);
                if ($datos_detalle) {
                    $jsondata = array();
                    $jsondata['success'] = true;
                    $jsondata['message'] = 'Modificado '.$codarticulo;
                    $jsondata['type'] = 'success';
                    $jsondata['codarticulo'] = $codarticulo;
                    $jsondata['cantidad'] = number_format($cant,0,'','');
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);
                    exit();
                    return false;
                }else{
                    $jsondata = array();
                    $jsondata['success'] = false;
                    $jsondata['message'] = 'Error al Modificar '.$codarticulo;
                    $jsondata['type'] = 'danger';
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);
                    exit();
                    return false;
                }
            }
    }else{
        $datos_detalle = $this->orders_model->delete_art($codarticulo,$codfacturatmp);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Registro '.$codarticulo.' Eliminado';
                $jsondata['type'] = 'success';
                $jsondata['codarticulo'] = $codarticulo;
                $jsondata['cantidad'] = number_format($cant,0,'','');
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Eliminar '.$codarticulo;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
    }

        }else{
        if($aumentar > 0){ 
            //$cantidad=1;
            $pendiente=$cantidad;
            $fecha=date("Y-m-d");
            $prec_vta1_new=($prec_vta1 * $cantidad);
        $datos_detalle = $this->orders_model->add_det_tmp($codfacturatmp,$reng_num,$codarticulo,$co_alma,$cantidad,$pendiente,$uni_venta,$prec_vta1,$tipo_imp,$prec_vta1_new,$cos_pro_un,$ult_cos_un,$fecha);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$codarticulo;
                $jsondata['type'] = 'success';
                $jsondata['codarticulo'] = $codarticulo;
                $jsondata['cantidad'] =number_format($cantidad,0,'','');
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$codarticulo;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
                     
                }else{
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error debe agregar el articulo '.$codarticulo;
                $jsondata['type'] = 'danger';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
                }
                }
        //stock actual validate
        }
    }

    public function addcli(){
        $rif = $this->input->post('nrif');
        $nombre = $this->input->post('nnombre');
        $sexo = $this->input->post('nsexo');
        $fechita = $this->input->post('nfn');
        $fn=date("Y-m-d", strtotime($fechita));
        $direccion = $this->input->post('ndireccion');
        $movil = $this->input->post('nmovil');
        $telefono = $this->input->post('ntelefono');
        $email = $this->input->post('nemail');
        $tipo = $this->input->post('ntipo');
        $no_repertir = $this->orders_model->no_repetir_cli($rif);
        if($no_repertir->si > 0){
                //si ya existe cliente
                    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Ya Existe '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
        $datos_detalle = $this->orders_model->add_cli($rif,$nombre,$sexo,$fn,$direccion,$movil,$telefono,$email);
        if ($datos_detalle) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Agregado '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar '.$rif;
                $jsondata['type'] = $tipo;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }
                    } 
        
    
    }

    public function comprobarrif($nacionalidad,$cedula){
       
$url="http://www.cne.gob.ve/web/registro_civil/buscar_rep.php?nac=".$nacionalidad."&ced=".$cedula;
        $cUrl = curl_init();
        curl_setopt($cUrl,CURLOPT_URL,$url);
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);
        $result_41x = curl_exec($cUrl);
    if (curl_errno($cUrl)) {
    // this would be your first hint that something went wrong
    //die('Couldn\'t send request: ' . curl_error($cUrl));
    $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'No se pudo resolver el host (por favor verifique su conexión a internet)';
                $jsondata['type'] = 'bg-red';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    } else {
    // check the HTTP status code of the request
    $resultStatus = curl_getinfo($cUrl, CURLINFO_HTTP_CODE);
    if ($resultStatus == 200) {
        // everything went better than expected
         $e = new Exception($result_41x);
         $texto = $e->getMessage();
         $valor=trim($texto);
         //echo $texto;
         $valor = str_replace("\n","",$valor);
         $valor=strip_tags($valor);
         $valor=trim($valor);
         //echo "*".$valor."*";
         $validar=substr($valor, 0, 4);
         if($validar == 'La c'){ //La cédula de identidad V-114444764 no esta registrado en la base de datos
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = $valor;
                $jsondata['type'] = 'bg-red';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
         }else{ //La cédula de identidad V-114444764 si esta registrado en la base de datos
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = $valor;
                $jsondata['type'] = 'bg-green';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return true;
         }
        
    } else {
        // the request did not complete as expected. common errors are 4xx
        // (not found, bad request, etc.) and 5xx (usually concerning
        // errors/exceptions in the remote script execution)
        //die('Request failed: HTTP status code: ' . $resultStatus);
        $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Request failed: HTTP status code: '. $resultStatus;
                $jsondata['type'] = 'bg-red';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
    }
}

//close connection
    curl_close($cUrl);
        
    }

    public function productos(){
        
        if (isset($_GET['term'])){    
        $buscar = $_GET['term'];
        $clienteactual = $_GET['extraParams'];
        $return_arr = array();

    setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
                    date_default_timezone_set('America/Caracas');
                    $hoyes=date('Y-m-d');
                    $dian=date('w', strtotime($hoyes)); 
                    $m=date('m');
                    $d=date('d');
                    $feriado = $this->orders_model->feriados($d,$m);
                    if($dian == 0 or $dian == 6 or $feriado->si > 0){
                        $ff=" AND ff IN(0,1) ";
                        $ff2=" ff DESC, ";
                    }else{ $ff=""; $ff2=""; }
                    $config_data = $this->orders_model->obtener_config();
                    $noc_ini=$config_data->noc_ini;
                    $diu_ini=$config_data->diu_ini;
                    $hora=date('H');
                    if($hora > $noc_ini or $hora < $diu_ini){
                        $noct=" AND nocturno IN(0,1) ";
                        $noct2=" nocturno DESC, ";
                    }else{ $noct=""; $noct2=""; }
                    $list = $this->orders_model->get_articulos($buscar);
        $item=1;
        foreach($list->result() as $row) {

            $id_producto=$row->IDExa;
            $precios = $this->orders_model->get_precio($id_producto,$clienteactual,$noct,$ff,$noct2,$ff2);
            foreach ($precios->result() as $row2)
                {
                    $precio=$row2->valor;
                }
            //$precio=number_format($row['precio1'],2,".","");
            $row_array['value'] = $row->IDExa." | ".$row->Nom_exa;
            $row_array['codarticulo']=$row->IDExa;
            $row_array['codigo']=$row->IDExa;
            $row_array['descripcion']=$row->Nom_exa;
            $row_array['precio']=$precio;
            $row_array['codfamilia']=$row->codfamilia;
            array_push($return_arr,$row_array);
            $item++;
        }

/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);

}
    }


    public function save(){
        $codfacturatmp = $this->input->post('codfacturatmp');
        $co_cli = $this->input->post('codcliente');
        $co_ven = $this->input->post('co_ven');
        $condicion = $this->input->post('condicion');
        
        $fechita = $this->input->post('fecha');
        //$fecha=date("Y-m-d", strtotime($fechita.' 00:00:00'));
        //$fecha =date_format($fechita,"Y-m-d");
        $fechitav = $this->input->post('fechav');
        //$fechav =date_format($fechitav,"Y-m-d");
        //$fechav=date("Y-m-d", strtotime($fechitav.' 00:00:00'));
        $observacion = $this->input->post('observacion');
        $preciototal= $this->input->post('preciototal');
        $baseimpuestos= $this->input->post('baseimpuestos2');
        if($baseimpuestos == '.00'){ $baseimpuestos=0.00; }
        $baseimponible= $this->input->post('baseimponible2');
        $co_tran='001';
        $forma_pag=$condicion;
        $fe_us_in=date("Y-m-d");
        $co_us_in='999';
        $co_sucu='INSTAL';
        $tasa=1.00;
        $moneda='BS';
        $tasag=16.00;
        $tasag10=8.00;
        $tasag20=31.00;
        $status=0;
        $contrib=1;
        //$tmp = $this->orders_model->obtener_fact_num2();
        $tmp = $this->orders_model->obtener_fact_num3();
        $fact_num=$tmp->ultimo;
        $codfactura = $this->orders_model->add_invoice($fact_num,$observacion,$preciototal,$fechita,$fechitav,$co_cli,$co_ven,$co_tran,$forma_pag,$baseimponible, $preciototal, $baseimpuestos,$co_us_in,$fe_us_in,$co_sucu,$tasa,$moneda,$tasag,$tasag10,$tasag20,$status,$contrib);

        $list = $this->orders_model->get_det_tmp2($codfacturatmp);
        $item=1;
        foreach($list as $row) {
            $fec_lote1=date("Y-m-d", strtotime($row->fec_lote));
            $det_invoice = $this->orders_model->add_det_invoice($fact_num,$item,$row->co_art,$row->co_alma,$row->total_art,$row->pendiente,$row->uni_venta,$row->prec_vta,$row->tipo_imp,$row->reng_neto,$row->cos_pro_un,$row->ult_cos_un,$fec_lote1);
            //------------------ inicio de stock comprometido ---------------
            $comprometido = $this->orders_model->obtener_stock_com($row->co_art);
            $stock_com=$comprometido->stock_com;
            $new_stock_com=($stock_com + $row->pendiente);
            $update_comprometido = $this->orders_model->update_stock_com($row->co_art,$new_stock_com);

            $comprometido_st = $this->orders_model->obtener_stock_com_st($row->co_art,'01');
            $stock_com_st=$comprometido_st->stock_com;
            $new_stock_com_st=($stock_com_st + $row->pendiente);
            $update_comprometido_st = $this->orders_model->update_stock_com_st($row->co_art,$new_stock_com_st,'01');
            //------------------ fin de stock comprometido ---------------
            $item++;
        }

        if ($codfactura) {
            $cliente = $this->orders_model->obtener_cli($co_cli);
            $vendedor = $this->orders_model->obtener_ven($co_ven);
            $fpago = $this->orders_model->obtener_fpago(trim($forma_pag));
            $cmail = $this->orders_model->obtener_config_email(1);
            $dmail = $this->orders_model->obtener_config_email(2);
            $empbd=$this->session->userdata('empbd');
            require "phpmailer/class.phpmailer.php";
            require "phpmailer/class.smtp.php";
            $email_user = $cmail->email;//"gmobileapi@gmail.com"
            $email_password = $cmail->password;//"GM0bil3*#"
            $the_subject = "Notificacion de nuevo pedido.";
            $the_subject2 = 'Pedido: '.$fact_num.' - Vendedor: '.trim($cliente->cli_des);
            $address_to = $dmail->email;//"gaop03@gmail.com"
            $from_name = "GMobile";
            $template = file_get_contents("phpmailer/mail-pedido.html");
            $subject = "Notificacion de nuevo pedido.";

            $template = str_replace(array("<!-- #{Subject} -->", "<!-- #{Pedido} -->", "<!-- #{Fecha} -->", "<!-- #{Monto} -->", "<!-- #{FPago} -->", "<!-- #{CoVen} -->", "<!-- #{CoCli} -->", "<!-- #{Cliente} -->", "<!-- #{Vendedor} -->", "<!-- #{Observa} -->"),array($the_subject, $fact_num.' - Empresa: '.$empbd, $fechita, number_format($preciototal,2,',','.'), trim($fpago->cond_des), $co_ven, trim($co_cli), trim($cliente->cli_des), trim($vendedor->ven_des), $observacion),$template);

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
            //$phpmailer->addAttachment('images/cobros/'.$newName0);
            $phpmailer->IsHTML(true);//$phpmailer->Send();
            if(!$phpmailer->Send()) {
                //echo "Error: " . $phpmailer->ErrorInfo;
                $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Pedido Generado!. Email: '.$phpmailer->ErrorInfo;
                $jsondata['invoice'] = $fact_num;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
            } else {
                //echo "Mensaje enviado correctamente";
                $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Pedido Generado!. #'.$fact_num;
                $jsondata['invoice'] = $fact_num;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
            }   

        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Agregar Factura';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

        
    }

    public function save_cobro(){
        $codfactura = $this->input->post('ccodfactura');
        $codcliente = $this->input->post('ccodcliente');
        $pagar = $this->input->post('cpagar2');
        $saldo = $this->input->post('csaldo2');
        $observacion = $this->input->post('cobserva');
        $codformapago = $this->input->post('cfpago');
        $fechita = $this->input->post('cfecha');
        $fecha=date("Y-m-d", strtotime($fechita));
        $ndocumento = $this->input->post('cdocumento');
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
        $codcobro = $this->orders_model->add_cobro($codfactura,$codcliente,$pagar,$codformapago,$codentidad,$ndocumento,$fecha,$observacion);
        if ($codcobro) {

            if($pagar == $saldo){
                $estado=2;
                $pendiente=($saldo - $pagar);
                $update_invoice0 = $this->orders_model->update_invoice0($codfactura,$pendiente,$estado);
            }else{
                $estado=1;
                $pendiente=($saldo - $pagar);
                $update_invoice0 = $this->orders_model->update_invoice0($codfactura,$pendiente,$estado);
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

    public function save2(){
        $codfacturatmp = $this->input->post('codfacturatmp');
        $fact_num = $this->input->post('orden');
        $co_cli = $this->input->post('codcliente');
        $co_ven = $this->input->post('co_ven');
        $condicion = $this->input->post('condicion');
        $fechita = $this->input->post('fecha');
        $fechitav = $this->input->post('fechav');
        $observacion = $this->input->post('observacion');
        $preciototal= $this->input->post('preciototal');
        $baseimpuestos= $this->input->post('baseimpuestos2');
        if($baseimpuestos == '.00'){ $baseimpuestos=0.00; }
        $baseimponible= $this->input->post('baseimponible2');
        $co_tran='001';
        $forma_pag='CON';
        $fe_us_in=date("Y-m-d");
        $co_us_in='999';
        $co_sucu='INSTAL';
        $tasa=1.00;
        $moneda='BS';
        $tasag=16.00;
        $tasag10=8.00;
        $tasag20=31.00;
        $status=0;
        $contrib=1;
        $codfactura = $this->orders_model->update_invoice($fact_num,$fechita,$fechitav,$co_cli,$observacion,$preciototal,$baseimponible, $baseimpuestos,$condicion);
        //------------------- inicio descontar stock comprometido ---------------
        $list_ped = $this->orders_model->get_det_ped($fact_num);
        foreach($list_ped as $row){
            //------------------ inicio de stock comprometido ---------------
            $comprometido = $this->orders_model->obtener_stock_com($row->co_art);
            $stock_com=$comprometido->stock_com;
            if($row->pendiente > $stock_com){
                $new_stock_com=0;
            }else{
                $new_stock_com=($stock_com - $row->pendiente);
            }  
            //$new_stock_com=($stock_com - $row->pendiente);          
            $update_comprometido = $this->orders_model->update_stock_com($row->co_art,$new_stock_com);

            $comprometido_st = $this->orders_model->obtener_stock_com_st($row->co_art,'01');
            $stock_com_st=$comprometido_st->stock_com;
            if($row->pendiente > $stock_com_st){
                $new_stock_com_st=0;
            }else{
                $new_stock_com_st=($stock_com_st - $row->pendiente);
            }
            //$new_stock_com_st=($stock_com_st - $row->pendiente);
            $update_comprometido_st = $this->orders_model->update_stock_com_st($row->co_art,$new_stock_com_st,'01');
            //------------------ fin de stock comprometido ---------------
        }
        //------------------- fin descontar stock comprometido ---------------
        $delete = $this->orders_model->delete_invoice_detalle($fact_num);

        $list = $this->orders_model->get_det_tmp2($codfacturatmp);
        $item=1;
        foreach($list as $row) {
            $fec_lote1=date("Y-m-d", strtotime($row->fec_lote));
            $det_invoice = $this->orders_model->add_det_invoice($fact_num,$item,$row->co_art,$row->co_alma,$row->total_art,$row->pendiente,$row->uni_venta,$row->prec_vta,$row->tipo_imp,$row->reng_neto,$row->cos_pro_un,$row->ult_cos_un,$fec_lote1);
            //------------------ inicio de stock comprometido ---------------
            $comprometido = $this->orders_model->obtener_stock_com($row->co_art);
            $stock_com=$comprometido->stock_com;
            $new_stock_com=($stock_com + $row->pendiente);
            $update_comprometido = $this->orders_model->update_stock_com($row->co_art,$new_stock_com);

            $comprometido_st = $this->orders_model->obtener_stock_com_st($row->co_art,'01');
            $stock_com_st=$comprometido_st->stock_com;
            $new_stock_com_st=($stock_com_st + $row->pendiente);
            $update_comprometido_st = $this->orders_model->update_stock_com_st($row->co_art,$new_stock_com_st,'01');
            //------------------ fin de stock comprometido ---------------
            $item++;
        }

        if ($codfactura) {
            $jsondata = array();
                $jsondata['success'] = true;
                $jsondata['message'] = 'Factura: '.$fact_num;
                $jsondata['invoice'] = $fact_num;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }else{
            $jsondata = array();
                $jsondata['success'] = false;
                $jsondata['message'] = 'Error al Actualizar Factura';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                exit();
                return false;
        }

        
    }

    public function view($admision){
        //load session library
        $this->load->library('session');

        //restrict users to go to home if not logged in
        if($this->session->userdata('user')){
            $data['invoice'] = $admision;
            //$data['articulos'] = $this->orders_model->get_modif_art($admision,$numlinea,$articulo);
            //$data['precios'] = $this->orders_model->getprecios($articulo,$cliente);
            //$data['fpago'] = $this->orders_model->getfpago();
            $this->load->view('head');
            $this->load->view('header');
            $this->load->view('orders/view',$data);
            //$this->load->view('footer');
        }
        else{
            redirect('/');
        }
        
    }

    public function report2($admision,$fini,$ffin,$estado,$condicion,$nif,$nif2,$nombre,$nombre2){
        //load session library
        $this->load->library('session');

        //restrict users to go back to login if session has been set
        if($this->session->userdata('user')){
            $data['admision'] =$admision;
            $data['fini'] =$fini;
            $data['ffin'] =$ffin;
            $data['estado'] =$estado;
            $data['condicion'] =$condicion;
            $data['datosreport'] = $this->orders_model->datos_cobros_report($admision,$fini,$ffin,$estado,$condicion,$nif,$nif2,$nombre,$nombre2);
            $this->load->view('report/pdf/cobros_report',$data);
        }
        else{
            redirect('/');
        }
    }

    public function report($codfactura){
        //load session library
        $this->load->library('session');

        //restrict users to go back to login if session has been set
        if($this->session->userdata('user')){
            //$encabezado=$this->rp_model->get_rp_encabezado($reci_num);

            $this->load->view('report/pdf/orden',array('codfactura' => $codfactura));
        }
        else{
            redirect('/');
        }
    }

    public function getinvoice()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $admision = $this->input->post('admision');
        $fini = $this->input->post('fini');
        $ffin = $this->input->post('ffin');
        $nif = $this->input->post('nif');
        $nombre = $this->input->post('nombre');
        $co_ven = $this->input->post('co_ven');

        $list = $this->orders_model->get_invoice($admision,$fini,$ffin,$nif,$nombre,$co_ven);
        $data = array();
        $item=1;
      foreach($list->result() as $row) {
        $opciones='';
        $opciones.='<button type="button" class="btn btn-warning" title="Modificar" onclick="edit('.$row->fact_num.');"><i class="fa fa-edit"></i></button>';
        //if($row->status >0){}else{
            $opciones.='<button type="button" class="btn btn-primary" title="Visualizar" onclick="view('.$row->fact_num.');"><i class="fa fa-search"></i></button>';
           // }
            //$opciones.='<button type="button" class="btn btn-danger" title="Inactivar" onclick="delete_cli('.$row->fact_num.',1);"><i class="fa fa-trash"></i></button>';
            
           $data[] = array(
                //$item,
                $row->fact_num,
                trim($row->co_cli),
                '<center>'.$row->fec_emis.'<br><span class="'.$row->status_color.'">'.$row->status_msg.'</span></center>',
                trim($row->co_cli).' - '.trim($row->cli_des),
                //'<span class="'.$row->status_color.'">'.$row->status_msg.'</span>',
                number_format($row->tot_neto,2,',','.'),
                number_format($row->saldo,2,',','.'),
                '',
                '',
                $row->status,
                $row->tot_neto,
                $row->saldo
                //'<div class="btn-group btn-group-sm">'.$opciones.'</div>'
                
                
               
                
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
