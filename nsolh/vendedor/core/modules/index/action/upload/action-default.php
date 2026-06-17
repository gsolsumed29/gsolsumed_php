<?php
$accion =$_GET['accion'];
$idPoliza =$_GET['idPoliza'];
$tipo =$_GET['tipo'];
$codigo =$_GET['codigo'];
$fecha=$_GET['ano'];  // bcd
$ano=substr($_GET['ano'],0, 4);  // bcd

$nombre=$codigo.'-'.$idPoliza.'-'.$tipo.'-'.$ano.'-';
$f = new FuncionesData();
$llave = $f->radomCodigo();

if($accion==1){
    if (is_array($_FILES) && count($_FILES) > 0) {
        if (($_FILES["file"]["type"] == "application/pdf")) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "../admin/storage/archivos/perfiles/".$nombre.$_FILES['file']['name'])) {      
                $archivo = "../admin/storage/archivos/perfiles/".$nombre.$_FILES['file']['name'];
                rename($archivo, "../admin/storage/archivos/perfiles/".$nombre.$llave.".pdf");
                $archivo = new PortafolioData();
                $archivo->llave =  $llave;
                $archivo->idPoliza =  $idPoliza;
                $archivo->codigo =  $codigo;
                $archivo->tipo =  $tipo;
                $archivo->ano =  $ano;
                $archivo->media = "../admin/storage/archivos/perfiles/".$nombre.$llave.".pdf";
                $archivo ->add();

                $result = $archivo->getDataObjeto($llave);
                header("Content-Type: application/json");
                echo json_encode($result);
               // echo "1";
                
                
               // $valor ="../admin/storage/archivos/perfiles/".$nombre.$_FILES['file']['name'];
                //echo "../admin/storage/archivos/perfiles/".$_FILES['file']['name'];
               // echo $valor;
               
            } else {
                echo 0;  
            }
        } else {
            echo 2;
        }
    } else {
        echo 3;
    }

}
if($accion==2){
    $idSiniestro =$idPoliza;
    $titulo =$_GET['titulo'];
    $descripcion =$_GET['descripcion'];
    
    if (is_array($_FILES) && count($_FILES) > 0) {
        if (($_FILES["file"]["type"] == "application/pdf")) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "../admin/storage/archivos/siniestros/".$nombre.$_FILES['file']['name'])) {      
                $archivo = "../admin/storage/archivos/siniestros/".$nombre.$_FILES['file']['name'];
                rename($archivo, "../admin/storage/archivos/siniestros/".$nombre.$llave.".pdf");
                /*
                $archivo = new PortafolioData();
                $archivo->llave =  $llave;
                $archivo->idPoliza =  $idPoliza;
                $archivo->codigo =  $codigo;
                $archivo->tipo =  $tipo;
                $archivo->ano =  $ano;
                $archivo->media = "../admin/storage/archivos/perfiles/".$nombre.$llave.".pdf";
                $archivo ->add();
*/
               
                
                $evento = new EventoData();
                $evento->idSiniestro =  $idPoliza;
                $evento->codigo =  $llave;
                $evento->fecha =  $fecha;
                $evento->titulo =  $titulo;
                $evento->descripcion =  $descripcion;
                $evento->media =  "../admin/storage/archivos/siniestros/".$nombre.$llave.".pdf";
                $evento ->add();

                $result = $evento->getDataObjeto($llave);
                header("Content-Type: application/json");
                echo json_encode($result);
               // echo "1";
                
                
               // $valor ="../admin/storage/archivos/perfiles/".$nombre.$_FILES['file']['name'];
                //echo "../admin/storage/archivos/perfiles/".$_FILES['file']['name'];
               // echo $valor;
               
            } else {
                echo 0;  
            }
        } else {
            echo 2;
        }
    } else {
        echo 3;
    }

}

if($accion==3){
    $idSiniestro =$idPoliza;
    $titulo =$_GET['titulo'];
    $descripcion =$_GET['descripcion'];
    
    
                
                $evento = new EventoData();
                $evento->idSiniestro =  $idPoliza;
                $evento->codigo =  $llave;
                $evento->fecha =  $fecha;
                $evento->titulo =  $titulo;
                $evento->descripcion =  $descripcion;
                $evento->media =  "2";
                $evento ->add();

                $result = $evento->getDataObjeto($llave);
                header("Content-Type: application/json");
                echo json_encode($result);
        
     
    

}

   


