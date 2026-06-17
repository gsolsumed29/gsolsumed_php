<?php
if((isset($_GET['tipo']))  || (isset($_GET['accion'])) || (isset($_GET['datos']))){
 
    $tipo = $_GET['tipo'];
    $accion = $_GET['accion'];
    $datos = $_GET['datos']; 
  
  }else{
  
    $tipo = $_POST['tipo'];
    $accion = $_POST['accion'];
    $datos = $_POST['datos']; 
  }
// 1 para registrar 2 para buscar ( datos1 para global / datos2 para especifico ) 3 para actualizar 4 para eliminar

if($accion ==1){
    if($datos==1){
       
        $marca = strtoupper($_POST['marca']); 
        $idTipo = strtoupper($_POST['idTipo']);
       
            $objeto = new ParametroData();           
            $objeto->marca =$marca;     
            $objeto->idTipo =$idTipo;              
            $objeto->add();     

            echo '1';      

    }

    if($datos == 2){
            // Recibir los parámetros del formulario
            $vendedor = $_POST['vendedor'];
            $indicador = $_POST['indicador'];
            $valor = $_POST['valor'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinal = $_POST['fechaFinal'];
            
            // Convertir fechas de formato dd/mm/yyyy a yyyy-mm-dd para la base de datos
            $fechaInicioDB = DateTime::createFromFormat('d/m/Y', $fechaInicio)->format('Y-m-d');
            $fechaFinalDB = DateTime::createFromFormat('d/m/Y', $fechaFinal)->format('Y-m-d');
            
            // Validaciones adicionales (opcional)
            if(empty($vendedor) || empty($indicador) || empty($valor) || empty($fechaInicio) || empty($fechaFinal)) {
                echo '3'; // Campos vacíos
                exit;
            }
            
            if($valor <= 0) {
                echo '3'; // Valor inválido
                exit;
            }
            
           
            // Crear el objeto y guardar en la base de datos
            $objeto = new ParametroData();
            $objeto->co_ven = $vendedor;
            $objeto->co_type = $indicador;
            $objeto->valor = $valor;
            $objeto->finicio = $fechaInicioDB;
            $objeto->ffinal = $fechaFinalDB;
            $objeto->add();
            
            echo '1'; // Éxito
        }
}
if($accion ==2){
    if($datos==1){       
        $clase =$_GET['c'];
        $tabla = $_GET['t'];
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new ParametroData();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getAll();
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }   
    
    if($datos==2){       
        $clase =$_GET['c'];
        $tabla = $_GET['t'];
        $dato = $_GET['d'];
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new MarcaData();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getById($dato);
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }  

    if($datos==3){       
        $clase =$_GET['c'];  // clase
        $tabla = $_GET['t'];  // tabla
        $dato = $_GET['d']; // dato
        $campo = $_GET['cp']; // campo
        
        if(isset($_GET['a'])){
            $a=$_GET['a'];
            }
        if($a==1){
            $objeto = new MarcaData();         
            $result=[];    
                switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto->getByCampo($campo,$dato);
                    break;
                }    
            header("Content-Type: application/json");
            echo json_encode($result);

            }
    }
}
if($accion ==3){
    if($datos==1){
       
        $marca = strtoupper($_POST['marca']); 
        $idTipo = strtoupper($_POST['idTipo']);
        $id = $_POST['id']; // valor para sacar el id de la REDI
        $f = new FuncionesData();
        $t = $f->foundValorxValor("marca","marca",$marca,"id",$id,"MarcaData");
        $token = $t->cuenta;
        if($token==1){          
            echo "1";         
        }else{
            $t = $f->foundValor("marca","marca",$marca,"MarcaData");
            $token2 = $t->cuenta;
            if($token2==1){
               
                echo "2";         
            }else{
                $objeto = new MarcaData();     
                $objeto->id =$id;                
                $objeto->marca =$marca;        
                $objeto->idTipo =$idTipo;    
                        
                $objeto->edit();            
                echo "1";         
            }
            
        }
    }
}
if($accion ==4){
    if($datos==1){
       
            $id = $_POST['id']; // valor para sacar el id del usuario         
            $banco_objeto = new TipoData();
           
            $banco_objeto->id =$id;                
            $banco_objeto->del();
           echo "1";
        }    
}
if($accion ==5){
    if($datos==1){       
            $id = $_POST['id']; // valor para sacar el id del usuario         
            $banco_objeto = new TipoData();
           
            $banco_objeto->id =$id;                
            $banco_objeto->act();
           echo "1";
        }    
}
?>