<?php
if((isset($_GET['tipo']))  || (isset($_GET['accion'])) || (isset($_GET['datos']))){
 
  $tipo = $_GET['tipo'];
  $accion = $_GET['accion'];
  $datos = $_GET['datos']; 
  $clase =$_GET['c'];
    $tabla = $_GET['t'];

}else{

  $tipo = $_POST['tipo'];
  $accion = $_POST['accion'];
  $datos = $_POST['datos']; 
  $clase =$_POST['c'];
    $tabla = $_POST['t'];
}

if($tipo==1){    
 
  
        if($accion ==2){
            if($datos==1){
                // para despachar buscar la factura
                    $fact_nun = $_POST['fact_nun'];            
                    $funciones_objeto = new FuncionesData();

                    $data = $funciones_objeto->foundValorDespacho('factura','fact_num',$fact_nun,"FuncionesData");
                         $bandera2 = $data[0]->id;
                        if($bandera2>=1){
                            echo "1";  
                            exit;
                        }else{
                            echo "0"; // no existe la factura
                            exit;
      
                }          
    
            }
        }
        if($accion==3){
             if($datos==1){ 
                $clase = $_GET['c'];
                $filtro =$_GET['filtro'];
                $datos = new $clase(); 
                $result=[];
                //echo $filtro;
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $datos->getDataFacturasParaDespachar($filtro);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
            } 
        }
        if($accion ==4){
            if($datos==1){
                // para despachar la factura
                    $id = $_POST['id'];
                    $dias = $_POST['dias'];  // valor para sacar el id del usuario         
                    $factura_objeto = new FacturaData();
                   
                    $factura_objeto->id =$id;     
                    $factura_objeto->dias =$dias;                
                    $factura_objeto->despachar();
                  //  $factura_objeto->despachar();
                    echo "1";
                }          
    
            }
        
            if($accion ==5){
            if($datos==1){
                // para despachar la factura
                    $id = $_POST['id']; // valor para sacar el id del usuario         
                    $user_objeto = new FacturaData();
                   
                    $user_objeto->id =$id;                
                    $user_objeto->devolver();
                     echo "1";
                }  
        
        }

        if($accion==6){
             if($datos==1){ 
                $clase = $_GET['c'];     
                $mes =$_GET['filtro'];      
                $fecha1 =$_GET['fecha1'];  
                $fecha2 =$_GET['fecha2'];               
                $data = new $clase(); 
                $result=[];
                //echo $filtro;
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataFacturas($mes,$fecha1,$fecha2);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
            } 
        }

        
        if($accion==7){
                    $objeto_datos = new $clase(); 
                    $result=[];  
                    $co_cli = $_GET['co_cli']; // CLIENTE
                    $filtro = $_GET['filtro']; // ANULADAS O NO ANULADAS
                    $filtro2 = $_GET['filtro2']; // FECHA DE INICIO 
                    $filtro3 = $_GET['filtro3']; // FECHA FINAL
                    $filtro4 = $_GET['filtro4']; // TIPO DE DOCUMENTO
                    $filtro5 = $_GET['filtro5']; // TIPO DE PAGO

            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $objeto_datos->getFacturasClienteCobranzas($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5);
                    break;
            }    
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
        }

            if($accion==8){
                    $datos = new $clase(); 
                    $result=[];  
                    $filtro = $_GET['filtro'];
                    $co_ven = $_GET['co_ven'];
                    $estado = $_GET['estado'];
                    switch($_SERVER["REQUEST_METHOD"]) {
                        case "GET":
                            $result = $datos->getAllCuentasPorCobrarDetallesGerente($filtro,$co_ven,$estado);
                            break;
                    }    
                    header("Content-Type: application/json");
                    echo json_encode($result);
                
                    //var_dump($result);      

        }

        
        if($accion==9){
             if($datos==1){ 
                $clase = $_GET['c'];     
                $tipo_doc =$_GET['tipo_doc'];      
                 
                $data = new $clase(); 
                $result=[];
                //echo $filtro;
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataFacturasDocumentos($tipo_doc2);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
            } 
        }
    }

  
    



if ($tipo == 2) { // FACTURACIÓN ELECTRÓNICA TFHKA

    if ($accion == 1) { // EMITIR FACTURA

        // 1. Obtener el ID
        $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;

        if ($fact_num == 0) {
            echo json_encode(array('status' => 'error', 'message' => 'ID de factura no proporcionado'));
            exit;
        }

        // 2. Consultar Datos
        $pedido_obj = new FacturaData();
        $pedido = $pedido_obj->GetFacturaCliente($fact_num);
        $items = $pedido_obj->GetRenglonFacturaCliente($fact_num);

        // 3. Credenciales
        $api_user = "gpugkujuiwqm_tfhka";
        $api_pass = 'Cjj,w++@XP$i';

        // Tasa de cambio: VES por 1 USD
        $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 419.99;
        
        // Descuento global (ya viene en USD desde la base de datos)
        $descuento_global_usd = isset($pedido[0]->descuento_global) ? floatval($pedido[0]->descuento_global) : 0;
        
        // 4. Fecha y hora
        $fecha_actual = date('d/m/Y');
        $hora_actual = date('h:i:s a');

        // Limpieza RIF
        $rif_limpio = str_replace(["-", "_"], "", $pedido[0]->rif);
        $tipo_id_cli = substr($rif_limpio, 0, 1);
        $num_id_cli = substr($rif_limpio, 1);

        // Función para convertir número a formato con punto decimal
        function formatearNumero($numero, $decimales = 2) {
            return number_format($numero, $decimales, '.', '');
        }

        // =====================================================
        // ACUMULADORES
        // =====================================================
        $total_gravado_usd = 0.00;
        $total_exento_usd = 0.00;
        $total_iva_usd = 0.00;
        $subtotal_usd = 0.00;

        $arr_items = [];
        $arr_impuestos_usd = [];
        $nro_linea = 1;
        $tasa_iva_general = 16.00;

        // --- ITERAR ITEMS (SIN DESCUENTOS POR ARTÍCULO) ---
        foreach ($items as $it) {
            $precio_usd = floatval($it->prec_vta);
            $cantidad = floatval($it->cant_desp);
            
            // Base imponible del item (sin descuentos)
            $base_item_usd = $cantidad * $precio_usd;
            
            // IVA (se calcula sobre la base completa)
            $iva_item_usd = 0.00;
            $tasa_item = 0.00;
            $cod_imp = "E";

            // Determinar si el item está gravado o exento
            if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
                $tasa_item = $tasa_iva_general;
                $iva_item_usd = $base_item_usd * ($tasa_item / 100);
                $cod_imp = "G";
                $total_gravado_usd += $base_item_usd;
            } else {
                $total_exento_usd += $base_item_usd;
            }

            $total_iva_usd += $iva_item_usd;
            $subtotal_usd += $base_item_usd;

            // Agrupar impuestos en USD
            $key_tasa = (string)$tasa_item;
            if (!isset($arr_impuestos_usd[$key_tasa])) {
                $arr_impuestos_usd[$key_tasa] = [
                    "CodigoTotalImp" => $cod_imp,
                    "AlicuotaImp" => $tasa_item,
                    "BaseImponibleImp" => 0.00,
                    "ValorTotalImp" => 0.00
                ];
            }
            $arr_impuestos_usd[$key_tasa]["BaseImponibleImp"] += $base_item_usd;
            $arr_impuestos_usd[$key_tasa]["ValorTotalImp"] += $iva_item_usd;

            // Construir Item
            $arr_items[] = [
                "NumeroLinea" => (string)$nro_linea,
                "CodigoCIIU" => "0198",
                "CodigoPLU" => $it->co_art,
                "IndicadorBienoServicio" => "1",
                "Descripcion" => $it->art_des,
                "Cantidad" => formatearNumero($cantidad, 2),
                "UnidadMedida" => "UNI",
                "PrecioUnitario" => formatearNumero($precio_usd, 2),
                "PrecioItem" => formatearNumero($base_item_usd, 2),
                "CodigoImpuesto" => $cod_imp,
                "TasaIVA" => formatearNumero($tasa_item, 2),
                "ValorIVA" => formatearNumero($iva_item_usd, 2),
                "ValorTotalItem" => formatearNumero($base_item_usd + $iva_item_usd, 2),
                "InfoAdicionalItem" => [
                    ["campo" => "Marca", "valor" => $it->marca]
                ]
            ];

            $nro_linea++;
        }

        // =====================================================
        // APLICAR DESCUENTO GLOBAL (monto fijo en USD)
        // =====================================================
        // Calcular factor de descuento para distribuir proporcionalmente
        $factor_descuento = 1;
        if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
            $factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
        }
        
        // Aplicar descuento a las bases imponibles (gravado y exento)
        $total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
        $total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
        
        // Recalcular IVA sobre la nueva base gravada
        $total_iva_con_descuento_usd = $total_gravado_con_descuento_usd * ($tasa_iva_general / 100);
        
        // Subtotal después del descuento
        $subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;
        
        // Total a pagar = subtotal con descuento + IVA recalculado
        $total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;

        // =====================================================
        // ACTUALIZAR IMPUESTOS CON DESCUENTO APLICADO
        // =====================================================
        $impuestos_usd = [];
        foreach ($arr_impuestos_usd as $imp) {
            $base_impuesto_con_descuento = $imp["BaseImponibleImp"] * $factor_descuento;
            $valor_impuesto_con_descuento = $base_impuesto_con_descuento * ($imp["AlicuotaImp"] / 100);
            
            $impuestos_usd[] = [
                "CodigoTotalImp" => $imp["CodigoTotalImp"],
                "AlicuotaImp" => formatearNumero($imp["AlicuotaImp"], 2),
                "BaseImponibleImp" => formatearNumero($base_impuesto_con_descuento, 2),
                "ValorTotalImp" => formatearNumero($valor_impuesto_con_descuento, 2)
            ];
        }

        // =====================================================
        // TOTALES EN VES (USD × TASA_CAMBIO)
        // =====================================================
        $total_gravado_ves = $total_gravado_con_descuento_usd * $tasa_cambio;
        $total_exento_ves = $total_exento_con_descuento_usd * $tasa_cambio;
        $total_iva_ves = $total_iva_con_descuento_usd * $tasa_cambio;
        $subtotal_ves = $subtotal_con_descuento_usd * $tasa_cambio;
        $total_pagar_ves = $total_pagar_usd * $tasa_cambio;
        $monto_descuento_ves = $descuento_global_usd * $tasa_cambio;
        $subtotal_antes_descuento_ves = ($subtotal_usd * $tasa_cambio);

        // =====================================================
        // IMPUESTOS EN VES
        // =====================================================
        $impuestos_ves = [];
        foreach ($impuestos_usd as $imp) {
            $base_valor = floatval(str_replace(',', '.', $imp["BaseImponibleImp"]));
            $impuesto_valor = floatval(str_replace(',', '.', $imp["ValorTotalImp"]));
            
            $impuestos_ves[] = [
                "CodigoTotalImp" => $imp["CodigoTotalImp"],
                "AlicuotaImp" => $imp["AlicuotaImp"],
                "BaseImponibleImp" => formatearNumero($base_valor * $tasa_cambio, 2),
                "ValorTotalImp" => formatearNumero($impuesto_valor * $tasa_cambio, 2)
            ];
        }

        // =====================================================
        // ESTRUCTURA FINAL CON DESCUENTO GLOBAL
        // =====================================================
        $documento = [
            "documentoElectronico" => [
                "Encabezado" => [
                    "IdentificacionDocumento" => [
                        "TipoDocumento" => "01",
                        "NumeroDocumento" => $pedido[0]->fact_num,
                        "TipoProveedor" => null,
                        "TipoTransaccion" => null,
                        "NumeroPlanillaImportacion" => null,
                        "NumeroExpedienteImportacion" => null,
                        "SerieFacturaAfectada" => null,
                        "NumeroFacturaAfectada" => null,
                        "FechaFacturaAfectada" => null,
                        "MontoFacturaAfectada" => null,
                        "ComentarioFacturaAfectada" => null,
                        "RegimenEspTributacion" => null,
                        "FechaEmision" => $fecha_actual,
                        "FechaVencimiento" => $fecha_actual,
                        "HoraEmision" => $hora_actual,
                        "Anulado" => false,
                        "TipoDePago" => "CONTADO",
                        "Serie" => "",
                        "Sucursal" => "",
                        "TipoDeVenta" => "Interna",
                        "Moneda" => "USD"
                    ],
                    "Vendedor" => [
                        "Codigo" => $pedido[0]->co_ven,
                        "Nombre" => $pedido[0]->ven_des,
                        "NumCajero" => $pedido[0]->co_ven,
                    ],
                    "Comprador" => [
                        "TipoIdentificacion" => $tipo_id_cli,
                        "NumeroIdentificacion" => $num_id_cli,
                        "RazonSocial" => $pedido[0]->cli_des,
                        "Direccion" => $pedido[0]->direc1,
                        "Ubigeo" => null,
                        "Pais" => "VE",
                        "Notificar" => null,
                        "Telefono" => [$pedido[0]->telefonos],
                        "Correo" => [$pedido[0]->email],
                        "OtrosEnvios" => null,
                
                    ],
                    "SujetoRetenido" => null,
                    "Tercero" => null,
                    "Totales" => [
                        "NroItems" => (string)count($items),
                        "MontoGravadoTotal" => formatearNumero($total_gravado_ves, 2),
                        "MontoExentoTotal" => formatearNumero($total_exento_ves, 2),
                        "Subtotal" => formatearNumero($subtotal_ves, 2),
                        "TotalIVA" => formatearNumero($total_iva_ves, 2),
                        "MontoTotalConIVA" => formatearNumero($total_pagar_ves, 2),
                        "TotalAPagar" => formatearNumero($total_pagar_ves, 2),
                        "TotalDescuento" => formatearNumero($monto_descuento_ves, 2),
                        "SubtotalAntesDescuento" => formatearNumero($subtotal_antes_descuento_ves, 2),
                        "MontoEnLetras" => "",
                        "ListaDescBonificacion" => [
                            [
                                "descDescuento" => "Descuento global",
                                "montoDescuento" => formatearNumero($monto_descuento_ves, 2)
                            ]
                        ],
                        "ImpuestosSubtotal" => $impuestos_ves,
                        "FormasPago" => [
                            [
                                "Descripcion" => "TRANSFERENCIA BANCARIA",
                                "Fecha" => $fecha_actual,
                                "Forma" => "03",
                                "Monto" => formatearNumero($total_pagar_ves, 2),
                                "Moneda" => "VES",
                                "TipoCambio" => "1.0000"
                            ]
                        ]
                    ],
                    "TotalesOtraMoneda" => [
                        "Moneda" => "USD",
                        "TipoCambio" => formatearNumero($tasa_cambio, 4),
                        "MontoGravadoTotal" => formatearNumero($total_gravado_con_descuento_usd, 2),
                        "MontoExentoTotal" => formatearNumero($total_exento_con_descuento_usd, 2),
                        "Subtotal" => formatearNumero($subtotal_con_descuento_usd, 2),
                        "TotalAPagar" => formatearNumero($total_pagar_usd, 2),
                        "TotalIVA" => formatearNumero($total_iva_con_descuento_usd, 2),
                        "MontoTotalConIVA" => formatearNumero($total_pagar_usd, 2),
                        "TotalDescuento" => formatearNumero($descuento_global_usd, 2),
                        "SubtotalAntesDescuento" => formatearNumero($subtotal_usd, 2),
                        "MontoEnLetras" => "",
                        "ListaDescBonificacion" => [
                            [
                                "descDescuento" => "Descuento global",
                                "montoDescuento" => formatearNumero($descuento_global_usd, 2)
                            ]
                        ],
                        "ImpuestosSubtotal" => $impuestos_usd,
                        "FormasPago" => [
                            [
                                "Descripcion" => "TRANSFERENCIA BANCARIA",
                                "Fecha" => $fecha_actual,
                                "Forma" => "03",
                                "Monto" => formatearNumero($total_pagar_usd, 2),
                                "Moneda" => "USD",
                                "TipoCambio" => "1.0000"
                            ]
                        ]
                    ]
                ],
                "DetallesItems" => $arr_items,
                "DetallesRetencion" => null,
                "Viajes" => null,
                "InfoAdicional" => [
                        [
                            "campo" => "TransporteCliente", 
                            "valor" => $pedido[0]->des_tran,
                        ],
                        [
                            "campo" => "ZonaCliente", 
                            "valor" => $pedido[0]->zon_des,
                        ],
                        [
                            "campo" => "DireccionEntregaCliente", 
                            "valor" => $pedido[0]->direc1,
                        ]


                ],
                "GuiaDespacho" => null,
                "Transporte" => null,
                "EsLote" => null,
                "EsMinimo" => null
            ]
        ];

        // =====================================================
        // ENVÍO A LA API
        // =====================================================
        // Debug para verificar cálculos
        $debug_data = [
            'subtotal_original_usd' => $subtotal_usd,
            'descuento_global_usd' => $descuento_global_usd,
            'factor_descuento' => $factor_descuento,
            'total_gravado_original_usd' => $total_gravado_usd,
            'total_gravado_con_descuento_usd' => $total_gravado_con_descuento_usd,
            'total_exento_original_usd' => $total_exento_usd,
            'total_exento_con_descuento_usd' => $total_exento_con_descuento_usd,
            'total_iva_original_usd' => $total_iva_usd,
            'total_iva_con_descuento_usd' => $total_iva_con_descuento_usd,
            'subtotal_con_descuento_usd' => $subtotal_con_descuento_usd,
            'total_pagar_usd' => $total_pagar_usd,
            'tasa_cambio' => $tasa_cambio,
            'total_pagar_ves' => $total_pagar_ves
        ];
        file_put_contents('debug_con_descuento_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT));
        file_put_contents('factura_con_descuento_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT));
        
        try {
            $api = new TfhkaApiData($api_user, $api_pass);
            $token = $api->obtenerToken();
            $response = $api->emitirFactura($token, $documento);

            $result = [
                'status' => 'success',
                'message' => 'Documento procesado correctamente.',
                'data' => $response
            ];
        } catch (Exception $e) {
            $result = [
                'status' => 'error',
                'message' => 'Error crítico: ' . $e->getMessage()
            ];
        }

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    if ($accion == 2) { // ANULAR FACTURA

            // 1. Obtener el ID de la factura a anular
            $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
            $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : "Sin motivo especificado";

            if ($fact_num == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'ID de factura no proporcionado'));
                exit;
            }

            // 2. Consultar datos de la factura para obtener la información necesaria
            $pedido_obj = new FacturaData();
            $pedido = $pedido_obj->GetFacturaCliente($fact_num);

            if (!$pedido || count($pedido) == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'Factura no encontrada'));
                exit;
            }

            // 3. Credenciales
            $api_user = "gpugkujuiwqm_tfhka";
            $api_pass = 'Cjj,w++@XP$i';

            // 4. Datos para la anulación
            $serie = ""; // Si no usas series, enviar cadena vacía
            $tipo_documento = "01"; // 01 = Factura
            $numero_documento = $pedido[0]->fact_num;

                    
            // 4. Fecha y hora
            $fecha_actual = date('d/m/Y');
            $hora_actual = date('h:i:s a');


            // =====================================================
            // ESTRUCTURA PARA ANULACIÓN
            // =====================================================
            $anulacion_data = [
                "serie" => $serie,
                "tipoDocumento" => $tipo_documento,
                "numeroDocumento" => $numero_documento,
                "motivoAnulacion" => $motivo,
                "fechaAnulacion" =>  $fecha_actual,
                "horaAnulacion" =>  $hora_actual

            ];

            // =====================================================
            // ENVÍO A LA API DE ANULACIÓN
            // =====================================================
            
            // Debug
            file_put_contents('anulacion_' . $fact_num . '.json', json_encode($anulacion_data, JSON_PRETTY_PRINT));
            
            try {
                $api = new TfhkaApiData($api_user, $api_pass);
                $token = $api->obtenerToken();
                //echo "Token obtenido: " . $token . "\n"; // Debug token
                // Llamar al endpoint de anulación
                $response = $api->anularFactura($token, $anulacion_data);

                $result = [
                    'status' => 'success',
                    'message' => 'Factura anulada correctamente.',
                    'data' => $response
                ];
            } catch (Exception $e) {
                $result = [
                    'status' => 'error',
                    'message' => 'Error al anular factura: ' . $e->getMessage()
                ];
            }

            header("Content-Type: application/json");
            echo json_encode($result);
    }      

   if ($accion == 3) { // EMITIR NOTA DE CRÉDITO

    // 1. Obtener el ID
    $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
    $factura_afectada_num = isset($_POST['factura_afectada']) ? $_POST['factura_afectada'] : 0;
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : 'Nota de Crédito';

    if ($fact_num == 0) {
        echo json_encode(array('status' => 'error', 'message' => 'ID de nota de crédito no proporcionado'));
        exit;
    }

    // 2. Consultar Datos de la Nota de Crédito
    $pedido_obj = new FacturaData();
    $pedido = $pedido_obj->GetFacturaCliente($fact_num);
    $items = $pedido_obj->GetRenglonFacturaCliente($fact_num);
    
    // 3. Consultar datos de la factura afectada (original)
    $factura_afectada = $pedido_obj->GetFacturaCliente($factura_afectada_num);
    
    if (!$factura_afectada || count($factura_afectada) == 0) {
        echo json_encode(array('status' => 'error', 'message' => 'Factura afectada no encontrada'));
        exit;
    }

    // 4. Credenciales
    $api_user = "gpugkujuiwqm_tfhka";
    $api_pass = 'Cjj,w++@XP$i';

    // Tasa de cambio
    $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 419.99;
    
    // Descuento global (si aplica)
    $descuento_global_usd = isset($pedido[0]->descuento_global) ? floatval($pedido[0]->descuento_global) : 0;
    
    // 5. Fecha y hora
    $fecha_actual = date('d/m/Y');
    $hora_actual = date('h:i:s a');
    
    // Fecha de la factura afectada en formato correcto (dd/mm/aaaa)
    $fecha_factura_afectada = date('d/m/Y', strtotime($factura_afectada[0]->fec_emis));

    // Limpieza RIF
    $rif_limpio = str_replace(["-", "_"], "", $pedido[0]->rif);
    $tipo_id_cli = substr($rif_limpio, 0, 1);
    $num_id_cli = substr($rif_limpio, 1);

    // Función para formatear números
    function formatearNumero($numero, $decimales = 2) {
        return number_format($numero, $decimales, '.', '');
    }

    // =====================================================
    // ACUMULADORES - NOTA DE CRÉDITO (VALORES POSITIVOS)
    // =====================================================
    $total_gravado_usd = 0.00;
    $total_exento_usd = 0.00;
    $total_iva_usd = 0.00;
    $subtotal_usd = 0.00;

    $arr_items = [];
    $arr_impuestos_usd = [];
    $nro_linea = 1;
    $tasa_iva_general = 16.00;

    // --- ITERAR ITEMS (usando valores absolutos/positivos) ---
    foreach ($items as $it) {
        $precio_usd = floatval($it->prec_vta);
        $cantidad = floatval($it->cant_desp);
        
        // Base imponible del item (VALOR POSITIVO)
        $base_item_usd = abs($cantidad * $precio_usd);
        
        // IVA (VALOR POSITIVO)
        $iva_item_usd = 0.00;
        $tasa_item = 0.00;
        $cod_imp = "E";

        if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
            $tasa_item = $tasa_iva_general;
            $iva_item_usd = $base_item_usd * ($tasa_item / 100);
            $cod_imp = "G";
            $total_gravado_usd += $base_item_usd;
        } else {
            $total_exento_usd += $base_item_usd;
        }

        $total_iva_usd += $iva_item_usd;
        $subtotal_usd += $base_item_usd;

        // Agrupar impuestos
        $key_tasa = (string)$tasa_item;
        if (!isset($arr_impuestos_usd[$key_tasa])) {
            $arr_impuestos_usd[$key_tasa] = [
                "CodigoTotalImp" => $cod_imp,
                "AlicuotaImp" => $tasa_item,
                "BaseImponibleImp" => 0.00,
                "ValorTotalImp" => 0.00
            ];
        }
        $arr_impuestos_usd[$key_tasa]["BaseImponibleImp"] += $base_item_usd;
        $arr_impuestos_usd[$key_tasa]["ValorTotalImp"] += $iva_item_usd;

        // Construir Item (VALORES POSITIVOS)
        $arr_items[] = [
            "NumeroLinea" => (string)$nro_linea,
            "CodigoCIIU" => "0198",
            "CodigoPLU" => $it->co_art,
            "IndicadorBienoServicio" => "1",
            "Descripcion" => $it->art_des,
            "Cantidad" => formatearNumero($cantidad, 2),
            "UnidadMedida" => "UNI",
            "PrecioUnitario" => formatearNumero($precio_usd, 2),
            "PrecioItem" => formatearNumero($base_item_usd, 2),
            "CodigoImpuesto" => $cod_imp,
            "TasaIVA" => formatearNumero($tasa_item, 2),
            "ValorIVA" => formatearNumero($iva_item_usd, 2),
            "ValorTotalItem" => formatearNumero($base_item_usd + $iva_item_usd, 2),
            "InfoAdicionalItem" => [
                ["campo" => "Marca", "valor" => $it->marca]
            ]
        ];

        $nro_linea++;
    }

    // Aplicar descuento global (si existe)
    $factor_descuento = 1;
    if ($subtotal_usd != 0 && $descuento_global_usd != 0) {
        $factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
    }
    
    $total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
    $total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
    $total_iva_con_descuento_usd = $total_gravado_con_descuento_usd * ($tasa_iva_general / 100);
    $subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;
    $total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;

    // =====================================================
    // TOTALES EN VES (VALORES POSITIVOS)
    // =====================================================
    $total_gravado_ves = $total_gravado_con_descuento_usd * $tasa_cambio;
    $total_exento_ves = $total_exento_con_descuento_usd * $tasa_cambio;
    $total_iva_ves = $total_iva_con_descuento_usd * $tasa_cambio;
    $subtotal_ves = $subtotal_con_descuento_usd * $tasa_cambio;
    $total_pagar_ves = $total_pagar_usd * $tasa_cambio;
    
    // Monto de la factura afectada (original) - VALOR POSITIVO
    $monto_factura_afectada_usd = abs(isset($factura_afectada[0]->tot_neto) ? floatval($factura_afectada[0]->tot_neto) : 0);
    
    // =====================================================
    // FUNCIONES PARA CALCULAR IMPUESTOS (VALORES POSITIVOS)
    // =====================================================
    
    // Función para calcular impuestos en USD
    function calcularImpuestosUsd($arr_impuestos_usd, $factor_descuento) {
        $result = [];
        foreach ($arr_impuestos_usd as $imp) {
            $base_ajustada = abs($imp["BaseImponibleImp"] * $factor_descuento);
            $valor_ajustado = $base_ajustada * ($imp["AlicuotaImp"] / 100);
            
            $result[] = [
                "CodigoTotalImp" => $imp["CodigoTotalImp"],
                "AlicuotaImp" => formatearNumero($imp["AlicuotaImp"], 2),
                "BaseImponibleImp" => formatearNumero($base_ajustada, 2),
                "ValorTotalImp" => formatearNumero($valor_ajustado, 2)
            ];
        }
        return $result;
    }
    
    // Función para calcular impuestos en VES
    function calcularImpuestosVes($arr_impuestos_usd, $tasa_cambio, $factor_descuento) {
        $result = [];
        foreach ($arr_impuestos_usd as $imp) {
            $base_ajustada = abs($imp["BaseImponibleImp"] * $factor_descuento);
            $valor_ajustado = $base_ajustada * ($imp["AlicuotaImp"] / 100);
            
            $result[] = [
                "CodigoTotalImp" => $imp["CodigoTotalImp"],
                "AlicuotaImp" => formatearNumero($imp["AlicuotaImp"], 2),
                "BaseImponibleImp" => formatearNumero($base_ajustada * $tasa_cambio, 2),
                "ValorTotalImp" => formatearNumero($valor_ajustado * $tasa_cambio, 2)
            ];
        }
        return $result;
    }
    
    // Calcular impuestos
    $impuestos_usd = calcularImpuestosUsd($arr_impuestos_usd, $factor_descuento);
    $impuestos_ves = calcularImpuestosVes($arr_impuestos_usd, $tasa_cambio, $factor_descuento);
    
    // =====================================================
    // ESTRUCTURA PARA NOTA DE CRÉDITO (VALORES POSITIVOS)
    // =====================================================
    $documento = [
        "documentoElectronico" => [
            "Encabezado" => [
                "IdentificacionDocumento" => [
                    "TipoDocumento" => "02", // Nota de Crédito
                    "NumeroDocumento" => $pedido[0]->fact_num,
                    "TipoProveedor" => null,
                    "TipoTransaccion" => "02", // Complemento
                    "NumeroPlanillaImportacion" => null,
                    "NumeroExpedienteImportacion" => null,
                    // Campos de la factura afectada (obligatorios para NC/ND)
                    "SerieFacturaAfectada" => "",
                    "NumeroFacturaAfectada" => $factura_afectada[0]->fact_num,
                    "FechaFacturaAfectada" => $fecha_factura_afectada, // Formato dd/mm/aaaa
                    "MontoFacturaAfectada" => formatearNumero($monto_factura_afectada_usd, 2),
                    "ComentarioFacturaAfectada" => $comentario,
                    "RegimenEspTributacion" => null,
                    "FechaEmision" => $fecha_actual,
                    "FechaVencimiento" => $fecha_actual,
                    "HoraEmision" => $hora_actual,
                    "Anulado" => false,
                    "TipoDePago" => "INMEDIATO",
                    "Serie" => "",
                    "Sucursal" => "",
                    "TipoDeVenta" => "Interna",
                    "Moneda" => "USD"
                ],
                "Vendedor" => [
                    "Codigo" => $pedido[0]->co_ven,
                    "Nombre" => $pedido[0]->ven_des,
                    "NumCajero" => $pedido[0]->co_ven,
                ],
                "Comprador" => [
                    "TipoIdentificacion" => $tipo_id_cli,
                    "NumeroIdentificacion" => $num_id_cli,
                    "RazonSocial" => $pedido[0]->cli_des,
                    "Direccion" => $pedido[0]->direc1,
                    "Ubigeo" => null,
                    "Pais" => "VE",
                    "Notificar" => null,
                    "Telefono" => [$pedido[0]->telefonos],
                    "Correo" => [$pedido[0]->email],
                    "OtrosEnvios" => null
                ],
                "SujetoRetenido" => null,
                "Tercero" => null,
                "Totales" => [
                    "NroItems" => (string)count($items),
                    "MontoGravadoTotal" => formatearNumero($total_gravado_ves, 2),
                    "MontoExentoTotal" => formatearNumero($total_exento_ves, 2),
                    "Subtotal" => formatearNumero($subtotal_ves, 2),
                    "TotalIVA" => formatearNumero($total_iva_ves, 2),
                    "MontoTotalConIVA" => formatearNumero($total_pagar_ves, 2),
                    "TotalAPagar" => formatearNumero($total_pagar_ves, 2),
                    "TotalDescuento" => $descuento_global_usd != 0 ? formatearNumero($descuento_global_usd * $tasa_cambio, 2) : null,
                    "SubtotalAntesDescuento" => formatearNumero($subtotal_ves + ($descuento_global_usd * $tasa_cambio), 2),
                    "MontoEnLetras" => "",
                    "ImpuestosSubtotal" => $impuestos_ves,
                    "FormasPago" => [
                        [
                            "Descripcion" => "TRANSFERENCIA BANCARIA",
                            "Fecha" => $fecha_actual,
                            "Forma" => "03",
                            "Monto" => formatearNumero($total_pagar_ves, 2),
                            "Moneda" => "VES",
                            "TipoCambio" => "1.0000"
                        ]
                    ]
                ],
                "TotalesOtraMoneda" => [
                    "Moneda" => "USD",
                    "TipoCambio" => formatearNumero($tasa_cambio, 4),
                    "MontoGravadoTotal" => formatearNumero($total_gravado_con_descuento_usd, 2),
                    "MontoExentoTotal" => formatearNumero($total_exento_con_descuento_usd, 2),
                    "Subtotal" => formatearNumero($subtotal_con_descuento_usd, 2),
                    "TotalAPagar" => formatearNumero($total_pagar_usd, 2),
                    "TotalIVA" => formatearNumero($total_iva_con_descuento_usd, 2),
                    "MontoTotalConIVA" => formatearNumero($total_pagar_usd, 2),
                    "TotalDescuento" => $descuento_global_usd != 0 ? formatearNumero($descuento_global_usd, 2) : null,
                    "SubtotalAntesDescuento" => formatearNumero($subtotal_usd + $descuento_global_usd, 2),
                    "MontoEnLetras" => "",
                    "ImpuestosSubtotal" => $impuestos_usd,
                    "FormasPago" => [
                        [
                            "Descripcion" => "TRANSFERENCIA BANCARIA",
                            "Fecha" => $fecha_actual,
                            "Forma" => "03",
                            "Monto" => formatearNumero($total_pagar_usd, 2),
                            "Moneda" => "USD",
                            "TipoCambio" => "1.0000"
                        ]
                    ]
                ]
            ],
            "DetallesItems" => $arr_items,
            "DetallesRetencion" => null,
            "Viajes" => null,
            "InfoAdicional" => [],
            "GuiaDespacho" => null,
            "Transporte" => null,
            "EsLote" => null,
            "EsMinimo" => null
        ]
    ];

    // Debug data
    $debug_data = [
        'tipo' => 'NOTA_CREDITO',
        'nota_credito_id' => $fact_num,
        'factura_afectada_id' => $factura_afectada_num,
        'factura_afectada_numero' => $factura_afectada[0]->fact_num ?? 'N/A',
        'factura_afectada_fecha' => $fecha_factura_afectada,
        'factura_afectada_monto_usd' => $monto_factura_afectada_usd,
        'comentario' => $comentario,
        
        // Totales en USD (valores positivos)
        'subtotal_original_usd' => $subtotal_usd,
        'descuento_global_usd' => $descuento_global_usd,
        'subtotal_con_descuento_usd' => $subtotal_con_descuento_usd,
        'total_gravado_usd' => $total_gravado_con_descuento_usd,
        'total_exento_usd' => $total_exento_con_descuento_usd,
        'total_iva_usd' => $total_iva_con_descuento_usd,
        'total_pagar_usd' => $total_pagar_usd,
        
        // Totales en VES (valores positivos)
        'tasa_cambio' => $tasa_cambio,
        'subtotal_ves' => $subtotal_ves,
        'total_gravado_ves' => $total_gravado_ves,
        'total_exento_ves' => $total_exento_ves,
        'total_iva_ves' => $total_iva_ves,
        'total_pagar_ves' => $total_pagar_ves,
        
        // Items
        'cantidad_items' => count($arr_items),
        
        // Impuestos
        'impuestos_usd' => $impuestos_usd,
        'impuestos_ves' => $impuestos_ves
    ];

    file_put_contents('debug_nota_credito_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    file_put_contents('nota_credito_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    // Envío a la API
    try {
        $api = new TfhkaApiData($api_user, $api_pass);
        $token = $api->obtenerToken();
        $response = $api->emitirFactura($token, $documento);

        $result = [
            'status' => 'success',
            'message' => 'Nota de Crédito emitida correctamente.',
            'data' => $response
        ];
    } catch (Exception $e) {
        $result = [
            'status' => 'error',
            'message' => 'Error crítico: ' . $e->getMessage()
        ];
    }

    header("Content-Type: application/json");
    echo json_encode($result);
}
    

    
}
?>