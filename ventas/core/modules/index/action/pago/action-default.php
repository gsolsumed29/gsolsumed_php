<?php
 $tipo = $_POST['tipo']; // 1 para lecciones
 $accion = $_POST['accion']; // 1 para registrar 2 para actualizar 3 para eliminar
 $datos = $_POST['datos']; // 1 pagos 
 date_default_timezone_set('America/Caracas');
$fecha = date("Y-m-d H:i:s");	
if($tipo==1){    
    if($accion ==1){
        if($datos==1){          
                //idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura prima comision bono cuota 
            $f = new FuncionesData();
            $codigo = $f->radomCodigo();            
            $pago_objeto = new PagoData();
            $idContrato = $_POST['idContrato']; // valor para sacar el id del usuario
            $codigoContrato = $_POST['codigoContrato']; // valor para sacar el id del usuario
            $estado = $_POST['estado'];
            $numeroRecibo = $_POST['numeroRecibo'];           
            $fecha = $_POST['fecha'];
            $referencia = $_POST['referencia'];
            $fechaOperacion = $_POST['fechaOperacion']; 
            $factura = $_POST['factura']; 
            $fechaFactura = $_POST['fechaFactura']; 
            $prima = $_POST['prima']; 
            $comision = $_POST['comision']; 
            $bono = $_POST['bono']; 
            $cuota = $_POST['cuota']; 
            
                // id codigo idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura prima comision bono forma cuota estatus 

            $pago_objeto->codigo =$codigo;
            $pago_objeto->idContrato =$idContrato;
            $pago_objeto->estado =$estado;
            $pago_objeto->numeroRecibo =$numeroRecibo;
            $pago_objeto->fecha =$fecha;
            $pago_objeto->referencia =$referencia;
            $pago_objeto->fechaOperacion =$fechaOperacion;
            $pago_objeto->factura =$factura;
            $pago_objeto->fechaFactura =$fechaFactura;
            $pago_objeto->prima =$prima;
            $pago_objeto->comision =$comision;
            $pago_objeto->bono =$bono;
            // $pago_objeto->forma =$forma;
            $pago_objeto->cuota =$cuota;
            $pago_objeto->add();

            $cuota_objeto = new CuotaData();
            $cuota_objeto->fechaPago =$fecha;
            $cuota_objeto->numero =$cuota;
            $cuota_objeto->codigoContrato =$codigoContrato;          
            $cuota_objeto->pagar();
            $cuota_objeto->actualizar($prima);

            $contrato_objeto = new ContratoData();
            $contrato_objeto->actualizar($prima,$codigoContrato);

            $result = $pago_objeto->getDataObjeto($codigo);
            header("Content-Type: application/json");
            echo json_encode($result);
           // echo "1";
            
            
        }
        if($datos==2){          
            //idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura prima comision bono cuota 
        $f = new FuncionesData();
        $codigo = $f->radomCodigo();            
        $pago_objeto = new PagoData();
        $idContrato = $_POST['idContrato']; // valor para sacar el id del usuario
        $codigoContrato = $_POST['codigoContrato']; // valor para sacar el id del usuario
        $estado = $_POST['estado'];
        $numeroRecibo = $_POST['numeroRecibo'];           
        $fecha = $_POST['fecha'];
        $referencia = $_POST['referencia'];
        $fechaOperacion = $_POST['fechaOperacion']; 
        $factura = $_POST['factura']; 
        $fechaFactura = $_POST['fechaFactura']; 
        $prima = $_POST['prima']; 
        $comision = $_POST['comision']; 
        $bono = $_POST['bono']; 
        $cuota = $_POST['cuota']; 
        
            // id codigo idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura prima comision bono forma cuota estatus 

        $pago_objeto->codigo =$codigo;
        $pago_objeto->idContrato =$idContrato;
        $pago_objeto->estado =$estado;
        $pago_objeto->numeroRecibo =$numeroRecibo;
        $pago_objeto->fecha =$fecha;
        $pago_objeto->referencia =$referencia;
        $pago_objeto->fechaOperacion =$fechaOperacion;
        $pago_objeto->factura =$factura;
        $pago_objeto->fechaFactura =$fechaFactura;
        $pago_objeto->prima =$prima;
        $pago_objeto->comision =$comision;
        $pago_objeto->bono =$bono;
        // $pago_objeto->forma =$forma;
        $pago_objeto->cuota =$cuota;
        $pago_objeto->add();

        
        $contrato_objeto = new ContratoData();
        $contrato_objeto->actualizar($prima,$codigoContrato);

        $result = $pago_objeto->getDataObjeto($codigo);
        header("Content-Type: application/json");
        echo json_encode($result);
       // echo "1";
        
        
    
    }
    }
    if($accion ==2){
        if($datos==1){          
                //idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura prima comision bono cuota 
         
            $pago_objeto = new PagoData();
            $codigoContrato = $_POST['codigoContrato']; // valor para sacar el id del usuario
            $codigo = $_POST['codigoPago']; // valor para sacar el id del usuario
            $estado = $_POST['estado'];
            $numeroRecibo = $_POST['numeroRecibo'];           
            $fecha = $_POST['fecha'];
            $referencia = $_POST['referencia'];
            $fechaOperacion = $_POST['fechaOperacion']; 
            $factura = $_POST['factura']; 
            $fechaFactura = $_POST['fechaFactura']; 
            $prima = $_POST['prima']; 
            $comision = $_POST['comision']; 
            $bono = $_POST['bono']; 
           // $cuota = $_POST['cuota']; 
            
                // id codigo idContrato estado numeroRecibo fecha referencia fechaOperacion factura fechaFactura prima comision bono forma cuota estatus 

            $pago_objeto->codigo =$codigo;          
            $pago_objeto->estado =$estado;
            $pago_objeto->numeroRecibo =$numeroRecibo;
            $pago_objeto->fecha =$fecha;
            $pago_objeto->referencia =$referencia;
            $pago_objeto->fechaOperacion =$fechaOperacion;
            $pago_objeto->factura =$factura;
            $pago_objeto->fechaFactura =$fechaFactura;
            $pago_objeto->prima =$prima;
            $pago_objeto->comision =$comision;
            $pago_objeto->bono =$bono;           
            $pago_objeto->update();

            $cuota_objeto = new CuotaData();
            $cuota_objeto->codigoContrato =$codigoContrato;         
            $cuota_objeto->actualizar($prima);
            $contrato_objeto = new ContratoData();
            $contrato_objeto->actualizar($prima,$codigoContrato);
            echo "1";
            
            
        }
    }
    if($accion ==3){
        if($datos==1){
                $cuota = $_POST['cuota']; // valor para sacar el id del usuario     
                $codigo = $_POST['codigo']; // valor para sacar el id del usuario     
                $codigoContrato = $_POST['codigoContrato']; // valor para sac    
                $pago_objeto = new PagoData();            
                $pago_objeto->delP($codigo);

                $cuota_objeto = new CuotaData();            
                $cuota_objeto->actualizarPago($codigoContrato,$cuota);      
               echo "1";
            }

        
            
            
          

        }
    
   
   
}
?>