<?php
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 

header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 

header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 

header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 


    $user = $this->session->userdata('user');
    extract($user);

    $imagen_cobro = $this->advancement_model->ver_comprobante($co_cob);

    //$nombre_fichero = 'images/cobros/'.trim($co_cob).'.png';
    $nombre_fichero = 'images/cobros/'.trim($imagen_cobro->comprobante);
    if (file_exists($nombre_fichero)) {
        $img_art='cobros/'.trim($co_cob).'.png';
    } else {
        $img_art='350x150.png';
    }
?>

<style type="text/css">
<!--
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}

input:focus {
    border-width: 0.001cm;
        background-color:#FAFD28;
        }
select:focus {
    border-width: 0.001cm;
        background-color:#FAFD28;
        }        
-->
</style>
<style type="text/css">
      .cargandose_loader {
  display: inline-block;
  position: absolute;
    top: 30%;
    left: 40%;
  width: 64px;
  height: 64px;
}
.cargandose_loader:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #fff;
  border-color: #ccc transparent #ccc transparent;
  animation: cargandose_loader 1.2s linear infinite;
}
@keyframes cargandose_loader {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

    </style>
<div class="card-body">
      
<img class="card-img-top" style="width: 100%;" src="<?php echo base_url(); ?>images/<?php echo $img_art;?>" alt="Card image cap">

          </div>

    