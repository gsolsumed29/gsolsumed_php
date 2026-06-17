<?php
  class Usera_model extends CI_Model {
    function __construct(){
      parent::__construct();
      $this->load->database();
    }

    public function obtener_config($id=1){
        $this->db->select('iva, moneda');
        $this->db->from('config');
        $this->db->where('id', $id);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }

    public function obtener_firma($idusuario){
        $this->db->select('imagen, tipo_imagen');
        $this->db->from('usuario');
        $this->db->where('idusuario', $idusuario);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
      }

        public function getnivel(){
          $query = $this->db->query('SELECT idnivel,nivel FROM nivel where borrado=0 ORDER BY idnivel ASC');
          return $query->result();
        }

        public function getempresas(){
          $query = $this->db->query('SELECT codcliente,nombre FROM clientes where borrado=0 AND empresa=1 ORDER BY codcliente ASC');
          return $query->result();
        }

        
        public function getclientes($rif,$nombre,$empresa){
          if($rif == '-' && $nombre == '-'){
            $rif='******';
            $nombre='*******';
          }
          $where="1=1";
          if ($empresa<>0) {
            if($empresa == 2){ $where.=" AND empresa='1' "; }else{ $where.=" AND empresa='0'";}
          }
          if ($rif<>"-") { $where.=" AND nif like '%$rif%'"; }
          if ($nombre<>"-") { $where.=" AND nombre like '%$nombre%'"; }
          $query = $this->db->query("SELECT * FROM clientes WHERE $where AND borrado=0  ORDER BY nombre ASC");
          return $query->result();
        }

    public function add_user($idusuario,$usuario,$nombre,$correo,$rif,$borrado=0){
      $provicional=12345;
      $pass= md5(md5($provicional));
      $date=date('Y-m-d');
      $img_sin_fondo='0x89504e470d0a1a0a0000000d49484452000000a00000006308060000001cb30b370000000473424954080808087c08648800000009704859730000044b0000044b016f31f60a0000001974455874536f667477617265007777772e696e6b73636170652e6f72679bee3c1a0000005349444154789cedc101010000008220ffaf6e484001000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000706af7e300014a302d4f0000000049454e44ae426082';
      $tipo_img='image/png';
      $data = array(
                    'idusuario' => $idusuario,
                    'usuario' => $usuario,
                    'pass' => $pass,                    
                    'rif' => $rif,
                    'nombre' => $nombre,                    
                    'fec_cre' => $date,
                    'status' => $borrado,
                    'correo' => $correo
                    );
      return $this->db->insert('GMOBILE.dbo.usuarios',$data);
      //return $this->db->insert_id();
    }

    public function update_user($idusuario,$usuario,$nombre,$correo,$rif,$borrado=0){
      $pass=md5(md5(12345));
      $data = array(
                    'usuario' => $usuario,
                    'nombre' => $nombre,
                    'rif' => $rif,
                    'correo' => $correo,
                    'status' => $borrado
                    );
      $this->db->where('idusuario', $idusuario);
      return $this->db->update('GMOBILE.dbo.usuarios', $data);
    }

    public function restablecer($idusuario){
      $pass=md5(md5(12345));
      $data = array(
                    'pass' => $pass
                    );
      $this->db->where('idusuario', $idusuario);
      return $this->db->update('GMOBILE.dbo.usuarios', $data);
    }

    public function add_img($idusuario,$data){
      $this->db->where('idusuario', $idusuario);
      return $this->db->update('usuario', $data);
    }

    public function delete_user($idusuario,$borrado){
      $data = array(
                    'status' => $borrado
                    );
      $this->db->where('idusuario', $idusuario);
      return $this->db->update('GMOBILE.dbo.usuarios', $data);
    }

    public function del_emp_inicial($idusuario,$borrado){
      $data = array(
                    'inicial' => $borrado
                    );
      $this->db->where('idusuario', $idusuario);
      return $this->db->update('GMOBILE.dbo.usu_emp', $data);
    }

    public function emp_inicial($idusuario,$emp,$borrado){
      $data = array(
                    'inicial' => $borrado
                    );
      $this->db->where('idusuario', $idusuario);
      $this->db->where('idemp', $emp);
      return $this->db->update('GMOBILE.dbo.usu_emp', $data);
    }

     public function no_repetir_user($idusuario,$usuario,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usuarios');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('usuario', $usuario);
        $this->db->where('status', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function no_repetir_user2($idusuario,$usuario,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usuarios');
        $this->db->where('usuario', $usuario);
        $this->db->where('idusuario <>', $idusuario);
        $this->db->where('status', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

    public function verificar_emp($idusuario,$emp,$borrado=0){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_emp');
        $this->db->where('idemp', $emp);
        $this->db->where('idusuario', $idusuario);
        $this->db->where('status', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }


    public function get_cliente_vali($rif)
    {
        $this->db->from('clientes');
        $this->db->where('nif',$rif);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_user_vali2($idusuario)
    {
      $query = $this->db->query("SELECT u.idusuario,u.usuario,u.nombre,u.rif,u.correo,u.status,isnull((SELECT e.idemp FROM usu_emp e WHERE e.idusuario=u.idusuario AND e.inicial=1 AND e.status=0),0) AS inicial FROM GMOBILE.dbo.usuarios u WHERE u.idusuario='$idusuario' ");
        return $query->row();
    }

    public function get_usera($usuario,$nombre,$status){
      $bus   = array("", "+");
      $where="1=1";
        //if ($codigo <> "") { $where.=" AND idusuario='$codigo'"; }
        if ($usuario <> "") { $usuario=str_replace($bus, "%", $usuario); $where.=" AND usuario like '%".$usuario."%'"; }
        if ($nombre <> "") { $nombre=str_replace($bus, "%", $nombre); $where.=" AND nombre like '%".$nombre."%'"; }
        if ($status <> "") { $where.=" AND status='$status'"; }
      
          $resultado = $this->db->query("SELECT idusuario,usuario,isnull(rif,'') AS rif,nombre,isnull(correo,'') AS correo,status,(CASE WHEN status = 0 THEN 'ACTIVO'
  WHEN status = 1 THEN 'INACTIVO'
  ELSE 'Error'
END) AS status_msg,(CASE
  WHEN status = 0 THEN 'badge badge-success'
  WHEN status = 1 THEN 'badge badge-warning'
  ELSE 'badge badge-danger'
END) AS status_color FROM GMOBILE.dbo.usuarios WHERE $where  ORDER BY idusuario DESC");

        return $resultado;
      }

      public function get_empresas($idusuario){
        $query = $this->db->query("SELECT e.idemp,e.empresa,u.idusuario,u.co_ven,u.status,u.inicial FROM GMOBILE.dbo.empresas e LEFT JOIN GMOBILE.dbo.usu_emp u ON u.idemp=e.idemp AND u.idusuario='$idusuario' WHERE e.status=0 ");
        return $query->result();
      }

      public function validar_empresa($idusuario,$idemp,$status=0){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_emp');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('idemp', $idemp);
        $this->db->where('status', $status);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

      public function no_repetir_empsup($idusuario,$idemp){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_emp');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('idemp', $idemp);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

      public function empsup($idusuario,$idemp,$marcado){
        $data = array(
                    'status' => $marcado
                    );
        $this->db->where('idusuario', $idusuario);
        $this->db->where('idemp', $idemp);
        return $this->db->update('GMOBILE.dbo.usu_emp', $data);
      }

      public function empsup2($idusuario,$idemp,$marcado){
        return $query = $this->db->query("INSERT INTO GMOBILE.dbo.usu_emp (idusuario,idemp,co_ven,status,inicial) VALUES ('$idusuario','$idemp','','0','0');");
            //return $query->result();
      }

      public function empsup3($idusuario,$idemp,$co_ven){
        $data = array(
                    'co_ven' => $co_ven
                    );
        $this->db->where('idusuario', $idusuario);
        $this->db->where('idemp', $idemp);
        return $this->db->update('GMOBILE.dbo.usu_emp', $data);
      }

      public function get_menu(){
          $query = $this->db->query("SELECT m.id_menu,m.menu,m.url FROM GMOBILE.dbo.menu m WHERE m.status=1 ORDER BY m.orden ASC");
          return $query->result();
        }  

        public function get_submenu($idmenu){
          $query = $this->db->query("SELECT s.id_submenu,s.url,s.submenu FROM GMOBILE.dbo.submenu s WHERE s.id_menu='$idmenu' AND s.status=1  ORDER BY s.orden ASC");
          return $query->result();
        }

     public function validar_menu($idusuario,$idmenu,$borrado=1){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_menu');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('id_menu', $idmenu);
        $this->db->where('status', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

      public function validar_submenu($idusuario,$idmenu,$idsubmenu,$borrado=1){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_submenu');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('id_menu', $idmenu);
        $this->db->where('id_submenu', $idsubmenu);
        $this->db->where('status', $borrado);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

      public function no_repetir_levelsup($idusuario,$idmenu){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_menu');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('id_menu', $idmenu);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

      public function levelsup($idusuario,$idmenu,$marcado){
      $data = array(
                    'status' => $marcado
                    );
      $this->db->where('idusuario', $idusuario);
      $this->db->where('id_menu', $idmenu);
      return $this->db->update('GMOBILE.dbo.usu_menu', $data);
    }


      public function levelsup2($idusuario,$idmenu,$marcado){
           return $query = $this->db->query("INSERT INTO GMOBILE.dbo.usu_menu (idusuario,id_menu,status) VALUES ('$idusuario',$idmenu,$marcado);");
            //return $query->result();
        }

      public function no_repetir_levelsdown($idusuario,$idmenu,$idsubmenu){

        $this->db->select('count(*) AS si');
        $this->db->from('GMOBILE.dbo.usu_submenu');
        $this->db->where('idusuario', $idusuario);
        $this->db->where('id_menu', $idmenu);
        $this->db->where('id_submenu', $idsubmenu);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

      }

      public function levelsdown($idusuario,$idmenu,$idsubmenu,$marcado){
      $data = array(
                    'status' => $marcado
                    );
      $this->db->where('idusuario', $idusuario);
      $this->db->where('id_menu', $idmenu);
      $this->db->where('id_submenu', $idsubmenu);
      return $this->db->update('GMOBILE.dbo.usu_submenu', $data);
    }


      public function levelsdown2($idusuario,$idmenu,$idsubmenu,$marcado){
           return $query = $this->db->query("INSERT INTO GMOBILE.dbo.usu_submenu (idusuario,id_menu,id_submenu,status) VALUES ('$idusuario',$idmenu,$idsubmenu,$marcado);");
            //return $query->result();
        }


  }
?>
