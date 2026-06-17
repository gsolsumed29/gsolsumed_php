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

        if ($accion == 23042026) { // EMITIR FACTURA

            // 1. Obtener el ID
            $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;

            if ($fact_num == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'ID de factura no proporcionado'));
                exit;
            }

            // 2. Consultar Datos (DATOS DE PRUEBA)
            $pedido_obj = new FacturaData();
            $pedido = $pedido_obj->GetFacturaCliente($fact_num);
            $items  = $pedido_obj->GetRenglonFacturaCliente($fact_num);

            // 3. Credenciales
            $api_user = 'uolltyfnwhqn_tfhka';
            $api_pass = '4S+W4@@G.JNW';


            // Tasa de cambio: VES por 1 USD
            $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0)
                ? floatval($pedido[0]->tasa)
                : 0.00;

            // Descuento global (ya viene en USD desde la base de datos: glob_desc / tasa)
            $descuento_global_usd = isset($pedido[0]->descuento_global)
                ? floatval($pedido[0]->descuento_global)
                : 0.00;

            // 4. Fecha y hora
            $fecha_actual = date('d/m/Y');
            $hora_actual  = date('h:i:s a');

            // Limpieza RIF
            $rif_limpio  = str_replace(["-", "_"], "", $pedido[0]->rif);
            $tipo_id_cli = substr($rif_limpio, 0, 1);
            $num_id_cli  = substr($rif_limpio, 1);

            // Función de formateo
            function formatearNumero($numero, $decimales = 2) {
                return number_format($numero, $decimales, '.', '');
            }
            function formatearNumero2($numero, $decimales = 2) {
                return number_format($numero, $decimales, '.', '');
            }

            // =====================================================
            // ACUMULADORES
            // =====================================================
            $total_gravado_usd = 0.00;
            $total_exento_usd  = 0.00;
            $subtotal_usd      = 0.00;

            $arr_items         = [];
            $arr_impuestos_usd = [];
            $nro_linea         = 1;
            $tasa_iva_general  = 16.00;

            // =====================================================
            // ITERAR ITEMS
            // =====================================================
            foreach ($items as $it) {
                $precio_usd    = floatval($it->prec_vta);
                $cantidad      = floatval($it->cant_desp);
                $base_item_usd = $cantidad * $precio_usd;

                $iva_item_usd = 0.00;
                $tasa_item    = 0.00;
                $cod_imp      = "E";

                if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
                    $tasa_item    = $tasa_iva_general;
                    // round() para que el IVA de cada ítem sea consistente
                    $iva_item_usd = round($base_item_usd * ($tasa_item / 100), 2);
                    $cod_imp      = "G";
                    $total_gravado_usd += $base_item_usd;
                } else {
                    $total_exento_usd += $base_item_usd;
                }

                $subtotal_usd += $base_item_usd;

                // Agrupar impuestos en USD
                $key_tasa = (string)$tasa_item;
                if (!isset($arr_impuestos_usd[$key_tasa])) {
                    $arr_impuestos_usd[$key_tasa] = [
                        "CodigoTotalImp"   => $cod_imp,
                        "AlicuotaImp"      => $tasa_item,
                        "BaseImponibleImp" => 0.00,
                        "ValorTotalImp"    => 0.00
                    ];
                }
                $arr_impuestos_usd[$key_tasa]["BaseImponibleImp"] += $base_item_usd;
                $arr_impuestos_usd[$key_tasa]["ValorTotalImp"]    += $iva_item_usd;

                // Construir ítem
                $arr_items[] = [
                    "NumeroLinea"            => (string)$nro_linea,
                    "CodigoCIIU"             => "0198",
                    "CodigoPLU"              => $it->co_art,
                    "IndicadorBienoServicio" => "1",
                    "Descripcion"            => $it->art_des,
                    "Cantidad"               => formatearNumero($cantidad, 2),
                    "UnidadMedida"           => "UNI",
                    "PrecioUnitario"         => formatearNumero($precio_usd, 2),
                    "PrecioItem"             => formatearNumero($base_item_usd, 2),
                    "CodigoImpuesto"         => $cod_imp,
                    "TasaIVA"                => formatearNumero($tasa_item, 2),
                    "ValorIVA"               => formatearNumero($iva_item_usd, 2),
                    "ValorTotalItem"         => formatearNumero($base_item_usd + $iva_item_usd, 2),
                    "InfoAdicionalItem"      => [
                        ["campo" => "Marca", "valor" => $it->marca]
                    ]
                ];

                $nro_linea++;
            }

            // =====================================================
            // APLICAR DESCUENTO GLOBAL (monto fijo en USD)
            // =====================================================
            $factor_descuento = 1;
            if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
                $factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
            }

            $total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
            $total_exento_con_descuento_usd  = $total_exento_usd  * $factor_descuento;
            $subtotal_con_descuento_usd      = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;

            // =====================================================
            // IMPUESTOS USD CON DESCUENTO APLICADO
            // =====================================================
            $impuestos_usd = [];
            foreach ($arr_impuestos_usd as $imp) {
                $base_con_desc  = $imp["BaseImponibleImp"] * $factor_descuento;
                // round() para que ValorTotalImp USD sea exacto a 2 decimales
                $valor_con_desc = round($base_con_desc * ($imp["AlicuotaImp"] / 100), 2);

                $impuestos_usd[] = [
                    "CodigoTotalImp"   => $imp["CodigoTotalImp"],
                    "AlicuotaImp"      => formatearNumero($imp["AlicuotaImp"], 2),
                    "BaseImponibleImp" => formatearNumero($base_con_desc, 2),
                    "ValorTotalImp"    => formatearNumero($valor_con_desc, 2)
                ];
            }

            // TotalIVA USD = suma de ValorTotalImp redondeados
            $total_iva_con_descuento_usd = 0.00;
            foreach ($impuestos_usd as $imp) {
                $total_iva_con_descuento_usd += floatval($imp["ValorTotalImp"]);
            }

            $total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;

            // =====================================================
            // IMPUESTOS EN VES
            // ValorTotalImp VES = BaseImponibleImp VES × alícuota
            // Esto garantiza que la API valide: Base × 16% = Valor
            // =====================================================
            $impuestos_ves = [];
            foreach ($impuestos_usd as $imp) {
                $base_usd = floatval(str_replace(',', '.', $imp["BaseImponibleImp"]));
                $alicuota = floatval(str_replace(',', '.', $imp["AlicuotaImp"]));

                // Base VES redondeada primero
                $base_ves  = round($base_usd * $tasa_cambio, 2);
                // Valor VES calculado DESDE la base VES (no desde IVA USD × tasa)
                $valor_ves = round($base_ves * ($alicuota / 100), 2);

                $impuestos_ves[] = [
                    "CodigoTotalImp"   => $imp["CodigoTotalImp"],
                    "AlicuotaImp"      => $imp["AlicuotaImp"],
                    "BaseImponibleImp" => formatearNumero($base_ves, 2),
                    "ValorTotalImp"    => formatearNumero($valor_ves, 2)
                ];
            }

            // =====================================================
            // TOTALES EN VES
            // =====================================================
            $total_gravado_ves       = round($total_gravado_con_descuento_usd * $tasa_cambio, 2);
            $total_exento_ves        = round($total_exento_con_descuento_usd  * $tasa_cambio, 2);
            $subtotal_ves            = round($subtotal_con_descuento_usd       * $tasa_cambio, 2);
            $monto_descuento_ves     = round($descuento_global_usd             * $tasa_cambio, 2);
            $subtotal_antes_desc_ves = round($subtotal_usd                     * $tasa_cambio, 2);

            // TotalIVA VES = suma de ValorTotalImp VES (calculados desde base VES)
            // De esta forma TotalIVA == sum(ImpuestosSubtotal.ValorTotalImp) siempre
            $total_iva_ves = 0.0;
            foreach ($impuestos_ves as $imp) {
                $total_iva_ves += floatval($imp["ValorTotalImp"]);
            }
            $total_iva_ves = round($total_iva_ves, 2);

            // TotalAPagar VES desde subtotal + iva corregidos
            $total_pagar_ves = round($subtotal_ves + $total_iva_ves, 2);

            // =====================================================
            // ESTRUCTURA JSON FINAL (DATOS DE PRUEBA)
            // =====================================================
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento"               => "01",
                            "NumeroDocumento"             => $pedido[0]->fact_num, // número de prueba
                            "TipoProveedor"               => null,
                            "TipoTransaccion"             => null,
                            "NumeroPlanillaImportacion"   => null,
                            "NumeroExpedienteImportacion" => null,
                            "SerieFacturaAfectada"        => null,
                            "NumeroFacturaAfectada"       => null,
                            "FechaFacturaAfectada"        => null,
                            "MontoFacturaAfectada"        => null,
                            "ComentarioFacturaAfectada"   => null,
                            "RegimenEspTributacion"       => null,
                            "FechaEmision"                => $fecha_actual,
                            "FechaVencimiento"            => $fecha_actual,
                            "HoraEmision"                 => $hora_actual,
                            "Anulado"                     => false,
                            "TipoDePago"                  => substr($pedido[0]->forma_pag, 0, 16),
                            "Serie"                       => "",
                            "Sucursal"                    => "",
                            "TipoDeVenta"                 => "Interna",
                            "Moneda"                      => "USD"
                        ],
                        "Vendedor" => [
                            "Codigo"    => $pedido[0]->co_ven,
                            "Nombre"    => $pedido[0]->ven_des,
                            "NumCajero" => $pedido[0]->co_ven,
                        ],
                        "Comprador" => [
                            "TipoIdentificacion"   => $tipo_id_cli,
                            "NumeroIdentificacion" => $num_id_cli,
                            "RazonSocial"          => $pedido[0]->cli_des,
                            "Direccion"            => $pedido[0]->direc1,
                            "Ubigeo"               => null,
                            "Pais"                 => "VE",
                            "Notificar"            => null,
                            "Telefono"             => [$pedido[0]->telefonos],
                            "Correo"               => [
                                $pedido[0]->email,
                                $pedido[0]->correo_vendedor
                            ],
                            "OtrosEnvios" => null,
                        ],
                        "SujetoRetenido" => null,
                        "Tercero"        => null,
                        "Totales" => [
                            "NroItems"               => (string)count($items),
                            "MontoGravadoTotal"      => formatearNumero($total_gravado_ves, 2),
                            "MontoExentoTotal"       => formatearNumero($total_exento_ves, 2),
                            "Subtotal"               => formatearNumero($subtotal_ves, 2),
                            "TotalIVA"               => formatearNumero2($total_iva_ves, 2),
                            "MontoTotalConIVA"       => formatearNumero($total_pagar_ves, 2),
                            "TotalAPagar"            => formatearNumero($total_pagar_ves, 2),
                            "TotalDescuento"         => formatearNumero($monto_descuento_ves, 2),
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_antes_desc_ves, 2),
                            "MontoEnLetras"          => "",
                            "ListaDescBonificacion"  => [
                                [
                                    "descDescuento"  => "Descuento global",
                                    "montoDescuento" => formatearNumero($monto_descuento_ves, 2)
                                ]
                            ],
                            "ImpuestosSubtotal" => $impuestos_ves,
                            "FormasPago" => [
                                [
                                    "Descripcion" => "TRANSFERENCIA BANCARIA",
                                    "Fecha"       => $fecha_actual,
                                    "Forma"       => "03",
                                    "Monto"       => formatearNumero($total_pagar_ves, 2),
                                    "Moneda"      => "VES",
                                    "TipoCambio"  => "1.0000"
                                ]
                            ]
                        ],
                        "TotalesOtraMoneda" => [
                            "Moneda"                 => "USD",
                            "TipoCambio"             => formatearNumero($tasa_cambio, 4),
                            "MontoGravadoTotal"      => formatearNumero($total_gravado_con_descuento_usd, 2),
                            "MontoExentoTotal"       => formatearNumero($total_exento_con_descuento_usd, 2),
                            "Subtotal"               => formatearNumero($subtotal_con_descuento_usd, 2),
                            "TotalAPagar"            => formatearNumero($total_pagar_usd, 2),
                            "TotalIVA"               => formatearNumero2($total_iva_con_descuento_usd, 2),
                            "MontoTotalConIVA"       => formatearNumero($total_pagar_usd, 2),
                            "TotalDescuento"         => formatearNumero($descuento_global_usd, 2),
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_usd, 2),
                            "MontoEnLetras"          => "",
                            "ListaDescBonificacion"  => [
                                [
                                    "descDescuento"  => "Descuento global",
                                    "montoDescuento" => formatearNumero($descuento_global_usd, 2)
                                ]
                            ],
                            "ImpuestosSubtotal" => $impuestos_usd,
                            "FormasPago" => [
                                [
                                    "Descripcion" => "TRANSFERENCIA BANCARIA",
                                    "Fecha"       => $fecha_actual,
                                    "Forma"       => "03",
                                    "Monto"       => formatearNumero($total_pagar_usd, 2),
                                    "Moneda"      => "USD",
                                    "TipoCambio"  => "1.0000"
                                ]
                            ]
                        ]
                    ],
                    "DetallesItems"     => $arr_items,
                    "DetallesRetencion" => null,
                    "Viajes"            => null,
                    "InfoAdicional" => [
                        ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                        ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                        ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
                    ],
                    "GuiaDespacho" => null,
                    "Transporte"   => null,
                    "EsLote"       => null,
                    "EsMinimo"     => null
                ]
            ];

            // =====================================================
            // DEBUG
            // =====================================================
            $debug_data = [
                'subtotal_original_usd'           => $subtotal_usd,
                'descuento_global_usd'            => $descuento_global_usd,
                'factor_descuento'                => $factor_descuento,
                'total_gravado_con_descuento_usd' => $total_gravado_con_descuento_usd,
                'total_exento_con_descuento_usd'  => $total_exento_con_descuento_usd,
                'total_iva_con_descuento_usd'     => $total_iva_con_descuento_usd,
                'subtotal_con_descuento_usd'      => $subtotal_con_descuento_usd,
                'total_pagar_usd'                 => $total_pagar_usd,
                'tasa_cambio'                     => $tasa_cambio,
                'total_gravado_ves'               => $total_gravado_ves,
                'total_iva_ves'                   => $total_iva_ves,
                'total_pagar_ves'                 => $total_pagar_ves,
                // Validaciones clave - deben coincidir
                'CHECK_TotalIVA_ves'              => $total_iva_ves,
                'CHECK_ValorTotalImp_G_ves'       => isset($impuestos_ves[0]) ? $impuestos_ves[0]["ValorTotalImp"] : 'N/A',
                'CHECK_Base_x_16pct'             => isset($impuestos_ves[0])
                    ? round(floatval($impuestos_ves[0]["BaseImponibleImp"]) * 0.16, 2)
                    : 'N/A',
            ];
            file_put_contents('factura_digital_debug_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT));
            file_put_contents('factura_digital_'       . $fact_num . '.json', json_encode($documento,  JSON_PRETTY_PRINT));

            // =====================================================
            // ENVÍO A LA API
            // =====================================================
            try {
                $api      = new TfhkaApiData($api_user, $api_pass);
                $token    = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);

                $resultado = $response->resultado ?? null;
                $codigo    = $response->codigo    ?? null;
                $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

                if ($resultado && !empty($resultado->numeroControl)) {
                    $numero_control = $resultado->numeroControl;
                    $link           = $resultado->urlConsulta ?? null;
                    $objeto_factura = new DocumentosData();
                    $objeto_factura->setFacturaDocum($fact_num, $numero_control, 'FACT', $link);
                    $objeto_factura->addDocumentoURL($fact_num, 'FACT', $link, 1);
                    $status   = 'success';
                    $msgFinal = ($codigo == "201")
                        ? "Documento Duplicado: Sincronizado correctamente."
                        : "Documento procesado con éxito.";
                } else {
                    $status   = 'error';
                    $msgFinal = "No se recibió número de control: " . $mensaje;
                }

                $result = [
                    'status'  => $status,
                    'message' => $msgFinal,
                    'data'    => $response
                ];

            } catch (Exception $e) {
                $result = [
                    'status'  => 'error',
                    'message' => 'Error crítico: ' . $e->getMessage()
                ];
            }

            header("Content-Type: application/json");
            echo json_encode($result);
        }


if ($accion == 1) { // EMITIR FACTURA

    // 1. Obtener el ID
    $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;

    if ($fact_num == 0) {
        echo json_encode(array('status' => 'error', 'message' => 'ID de factura no proporcionado'));
        exit;
    }
   // $fact_num = "2288";
    // 2. Consultar Datos
    $pedido_obj = new FacturaData();
    $pedido = $pedido_obj->GetFacturaCliente($fact_num);
    $items  = $pedido_obj->GetRenglonFacturaCliente($fact_num);
  // 3. Credenciales
                    $api_user = 'uolltyfnwhqn_tfhka';
                    $api_pass = '4S+W4@@G.JNW';
    // Tasa de cambio: VES por 1 USD
    $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0)
        ? floatval($pedido[0]->tasa)
        : 0.00;

    if ($tasa_cambio <= 0) {
        header('Content-Type: application/json', true, 400);
        echo json_encode([
            'status'  => 'error',
            'message' => 'La factura no tiene tasa de cambio válida (BCV). Asigne una tasa antes de emitir.',
            'fact_num' => $fact_num
        ]);
        exit;
    }

    // Porcentaje de descuento global (viene de la BD)
    $porc_desc = isset($pedido[0]->porc_desc) 
        ? floatval($pedido[0]->porc_desc) 
        : 0.00;

    // 4. Fecha y hora
    $fecha_actual = date('d/m/Y');
    $hora_actual  = date('h:i:s a');

    // Limpieza RIF
    $rif_limpio  = str_replace(["-", "_"], "", $pedido[0]->rif);
    $tipo_id_cli = substr($rif_limpio, 0, 1);
    $num_id_cli  = substr($rif_limpio, 1);

    // Función de formateo
    function formatearNumero($numero, $decimales = 2) {
        return number_format($numero, $decimales, '.', '');
    }

    // =====================================================
    // ACUMULADORES
    // =====================================================
    $total_gravado_usd = 0.00;
    $total_exento_usd  = 0.00;
    $subtotal_usd      = 0.00;

    $arr_items         = [];
    $arr_impuestos_usd = [];
    $nro_linea         = 1;
    $tasa_iva_general  = 16.00;

    // =====================================================
    // ITERAR ITEMS
    // =====================================================
    foreach ($items as $it) {
        $precio_usd    = floatval($it->prec_vta);
        $cantidad      = floatval($it->cant_desp);
        $base_item_usd = $cantidad * $precio_usd;

        $iva_item_usd = 0.00;
        $tasa_item    = 0.00;
        $cod_imp      = "E";

        if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
            $tasa_item    = $tasa_iva_general;
            $iva_item_usd = round($base_item_usd * ($tasa_item / 100), 2);
            $cod_imp      = "G";
            $total_gravado_usd += $base_item_usd;
        } else {
            $total_exento_usd += $base_item_usd;
        }

        $subtotal_usd += $base_item_usd;

        // Agrupar impuestos en USD
        $key_tasa = (string)$tasa_item;
        if (!isset($arr_impuestos_usd[$key_tasa])) {
            $arr_impuestos_usd[$key_tasa] = [
                "CodigoTotalImp"   => $cod_imp,
                "AlicuotaImp"      => $tasa_item,
                "BaseImponibleImp" => 0.00,
                "ValorTotalImp"    => 0.00
            ];
        }
        $arr_impuestos_usd[$key_tasa]["BaseImponibleImp"] += $base_item_usd;
        $arr_impuestos_usd[$key_tasa]["ValorTotalImp"]    += $iva_item_usd;

        // Construir ítem
        $arr_items[] = [
            "NumeroLinea"            => (string)$nro_linea,
            "CodigoCIIU"             => "0198",
            "CodigoPLU"              => $it->co_art,
            "IndicadorBienoServicio" => "1",
            "Descripcion"            => $it->art_des,
            "Cantidad"               => formatearNumero($cantidad, 2),
            "UnidadMedida"           => "UNI",
            "PrecioUnitario"         => formatearNumero($precio_usd, 2),
            "PrecioItem"             => formatearNumero($base_item_usd, 2),
            "CodigoImpuesto"         => $cod_imp,
            "TasaIVA"                => formatearNumero($tasa_item, 2),
            "ValorIVA"               => formatearNumero($iva_item_usd, 2),
            "ValorTotalItem"         => formatearNumero($base_item_usd + $iva_item_usd, 2),
            "InfoAdicionalItem"      => [
                ["campo" => "Marca", "valor" => $it->marca]
            ]
        ];

        $nro_linea++;
    }

    // =====================================================
    // TOTALES EN VES (calcular todo desde VES para evitar errores de redondeo)
    // =====================================================
    
    // 1. Convertir subtotal USD a VES
    $subtotal_antes_desc_ves = round($subtotal_usd * $tasa_cambio, 2);
    
    // 2. Calcular descuento DIRECTAMENTE en VES
    $monto_descuento_ves = 0.00;
    if ($porc_desc > 0 && $porc_desc <= 100) {
        $monto_descuento_ves = round($subtotal_antes_desc_ves * ($porc_desc / 100), 2);
    }
    
    // 3. Subtotal con descuento en VES
    $subtotal_ves = round($subtotal_antes_desc_ves - $monto_descuento_ves, 2);
    
    // 4. Distribuir el descuento proporcionalmente entre gravado y exento
    $total_gravado_usd_sin_desc = $total_gravado_usd;
    $total_exento_usd_sin_desc = $total_exento_usd;
    
    if ($subtotal_antes_desc_ves > 0) {
        $factor_gravado = $total_gravado_usd / $subtotal_usd;
        $factor_exento = $total_exento_usd / $subtotal_usd;
        
        $monto_descuento_gravado_ves = round($monto_descuento_ves * $factor_gravado, 2);
        $monto_descuento_exento_ves = round($monto_descuento_ves * $factor_exento, 2);
        
        // Ajustar el último centavo si hay diferencia
        $diferencia = $monto_descuento_ves - ($monto_descuento_gravado_ves + $monto_descuento_exento_ves);
        $monto_descuento_gravado_ves += $diferencia;
    } else {
        $monto_descuento_gravado_ves = 0;
        $monto_descuento_exento_ves = 0;
    }
    
    // 5. Calcular gravado y exento en VES (desde VES, no desde USD)
    $total_gravado_ves_sin_desc = round($total_gravado_usd * $tasa_cambio, 2);
    $total_exento_ves_sin_desc = round($total_exento_usd * $tasa_cambio, 2);
    
    $total_gravado_ves = round($total_gravado_ves_sin_desc - $monto_descuento_gravado_ves, 2);
    $total_exento_ves = round($total_exento_ves_sin_desc - $monto_descuento_exento_ves, 2);
    
    // 6. Calcular IVA en VES (sobre base gravada YA DESCONTADA en VES)
    $total_iva_ves = round($total_gravado_ves * ($tasa_iva_general / 100), 2);
    
    // 7. Total a pagar en VES
    $total_pagar_ves = round($subtotal_ves + $total_iva_ves, 2);
    
    // =====================================================
    // IMPUESTOS EN VES
    // =====================================================
    $impuestos_ves = [];
    foreach ($arr_impuestos_usd as $imp) {
        $codigo_impuesto = $imp["CodigoTotalImp"];
        
        if ($codigo_impuesto == "G") {
            $base_ves = $total_gravado_ves;
        } else {
            $base_ves = $total_exento_ves;
        }
        
        $impuestos_ves[] = [
            "CodigoTotalImp"   => $imp["CodigoTotalImp"],
            "AlicuotaImp"      => formatearNumero(floatval($imp["AlicuotaImp"]), 2),
            "BaseImponibleImp" => formatearNumero($base_ves, 2),
            "ValorTotalImp"    => $codigo_impuesto == "G" ? formatearNumero($total_iva_ves, 2) : "0.00"
        ];
    }
    
    // =====================================================
    // TOTALES EN USD (para TotalesOtraMoneda) - Convertir DESDE VES
    // =====================================================
    $monto_descuento_usd = round($monto_descuento_ves / $tasa_cambio, 2);
    $subtotal_con_descuento_usd = round($subtotal_ves / $tasa_cambio, 2);
    $total_gravado_con_descuento_usd = round($total_gravado_ves / $tasa_cambio, 2);
    $total_exento_con_descuento_usd = round($total_exento_ves / $tasa_cambio, 2);
    $total_iva_con_descuento_usd = round($total_iva_ves / $tasa_cambio, 2);
    $total_pagar_usd = round($total_pagar_ves / $tasa_cambio, 2);
    
    // Impuestos en USD
    $impuestos_usd = [];
    foreach ($impuestos_ves as $imp) {
        $impuestos_usd[] = [
            "CodigoTotalImp"   => $imp["CodigoTotalImp"],
            "AlicuotaImp"      => $imp["AlicuotaImp"],
            "BaseImponibleImp" => formatearNumero(floatval($imp["BaseImponibleImp"]) / $tasa_cambio, 2),
            "ValorTotalImp"    => formatearNumero(floatval($imp["ValorTotalImp"]) / $tasa_cambio, 2)
        ];
    }

    // =====================================================
    // ESTRUCTURA JSON FINAL
    // =====================================================
    $documento = [
        "documentoElectronico" => [
            "Encabezado" => [
                "IdentificacionDocumento" => [
                    "TipoDocumento"               => "01",
                     "NumeroDocumento"             => $pedido[0]->fact_num, // número de prueba
                    "TipoProveedor"               => null,
                    "TipoTransaccion"             => null,
                    "NumeroPlanillaImportacion"   => null,
                    "NumeroExpedienteImportacion" => null,
                    "SerieFacturaAfectada"        => null,
                    "NumeroFacturaAfectada"       => null,
                    "FechaFacturaAfectada"        => null,
                    "MontoFacturaAfectada"        => null,
                    "ComentarioFacturaAfectada"   => null,
                    "RegimenEspTributacion"       => null,
                    "FechaEmision"                => $fecha_actual,
                    "FechaVencimiento"            => $fecha_actual,
                    "HoraEmision"                 => $hora_actual,
                    "Anulado"                     => false,
                    "TipoDePago"                  => substr($pedido[0]->forma_pag, 0, 16),
                    "Serie"                       => "",
                    "Sucursal"                    => "",
                    "TipoDeVenta"                 => "Interna",
                    "Moneda"                      => "USD"
                ],
                "Vendedor" => [
                    "Codigo"    => $pedido[0]->co_ven,
                    "Nombre"    => $pedido[0]->ven_des,
                    "NumCajero" => $pedido[0]->co_ven,
                ],
                "Comprador" => [
                    "TipoIdentificacion"   => $tipo_id_cli,
                    "NumeroIdentificacion" => $num_id_cli,
                    "RazonSocial"          => $pedido[0]->cli_des,
                    "Direccion"            => $pedido[0]->direc1,
                    "Ubigeo"               => null,
                    "Pais"                 => "VE",
                    "Notificar"            => null,
                    "Telefono"             => [$pedido[0]->telefonos],
                    "Correo"               => [
                        $pedido[0]->email,
                        $pedido[0]->correo_vendedor
                    ],
                    "OtrosEnvios" => null,
                ],
                "SujetoRetenido" => null,
                "Tercero"        => null,
                "Totales" => [
                    "NroItems"               => (string)count($items),
                    "MontoGravadoTotal"      => formatearNumero($total_gravado_ves, 2),
                    "MontoExentoTotal"       => formatearNumero($total_exento_ves, 2),
                    "Subtotal"               => formatearNumero($subtotal_ves, 2),
                    "TotalIVA"               => formatearNumero($total_iva_ves, 2),
                    "MontoTotalConIVA"       => formatearNumero($total_pagar_ves, 2),
                    "TotalAPagar"            => formatearNumero($total_pagar_ves, 2),
                    "TotalDescuento"         => $porc_desc > 0 ? formatearNumero($monto_descuento_ves, 2) : "0.00",
                    "SubtotalAntesDescuento" => formatearNumero($subtotal_antes_desc_ves, 2),
                    "MontoEnLetras"          => "",
                    "ListaDescBonificacion"  => $porc_desc > 0 ? [
                        [
                            "descDescuento"  => "Descuento " . formatearNumero($porc_desc, 2) . "%",
                            "montoDescuento" => formatearNumero($monto_descuento_ves, 2)
                        ]
                    ] : [],
                    "ImpuestosSubtotal" => $impuestos_ves,
                    "FormasPago" => [
                        [
                            "Descripcion" => "TRANSFERENCIA BANCARIA",
                            "Fecha"       => $fecha_actual,
                            "Forma"       => "03",
                            "Monto"       => formatearNumero($total_pagar_ves, 2),
                            "Moneda"      => "VES",
                            "TipoCambio"  => "1.0000"
                        ]
                    ]
                ],
                "TotalesOtraMoneda" => [
                    "Moneda"                 => "USD",
                    "TipoCambio"             => formatearNumero($tasa_cambio, 4),
                    "MontoGravadoTotal"      => formatearNumero($total_gravado_con_descuento_usd, 2),
                    "MontoExentoTotal"       => formatearNumero($total_exento_con_descuento_usd, 2),
                    "Subtotal"               => formatearNumero($subtotal_con_descuento_usd, 2),
                    "TotalAPagar"            => formatearNumero($total_pagar_usd, 2),
                    "TotalIVA"               => formatearNumero($total_iva_con_descuento_usd, 2),
                    "MontoTotalConIVA"       => formatearNumero($total_pagar_usd, 2),
                    "TotalDescuento"         => $porc_desc > 0 ? formatearNumero($monto_descuento_usd, 2) : "0.00",
                    "SubtotalAntesDescuento" => formatearNumero($subtotal_usd, 2),
                    "MontoEnLetras"          => "",
                    "ListaDescBonificacion"  => $porc_desc > 0 ? [
                        [
                            "descDescuento"  => "Descuento " . formatearNumero($porc_desc, 2) . "%",
                            "montoDescuento" => formatearNumero($monto_descuento_usd, 2)
                        ]
                    ] : [],
                    "ImpuestosSubtotal" => $impuestos_usd,
                    "FormasPago" => [
                        [
                            "Descripcion" => "TRANSFERENCIA BANCARIA",
                            "Fecha"       => $fecha_actual,
                            "Forma"       => "03",
                            "Monto"       => formatearNumero($total_pagar_usd, 2),
                            "Moneda"      => "USD",
                            "TipoCambio"  => "1.0000"
                        ]
                    ]
                ]
            ],
            "DetallesItems"     => $arr_items,
            "DetallesRetencion" => null,
            "Viajes"            => null,
            "InfoAdicional" => [
                ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
            ],
            "GuiaDespacho" => null,
            "Transporte"   => null,
            "EsLote"       => null,
            "EsMinimo"     => null
        ]
    ];

    // =====================================================
    // DEBUG
    // =====================================================
    $debug_data = [
        'tasa_cambio'                     => $tasa_cambio,
        'porcentaje_descuento'            => $porc_desc,
        'subtotal_usd'                    => $subtotal_usd,
        'subtotal_antes_desc_ves'         => $subtotal_antes_desc_ves,
        'monto_descuento_ves'             => $monto_descuento_ves,
        'monto_descuento_gravado_ves'     => $monto_descuento_gravado_ves,
        'monto_descuento_exento_ves'      => $monto_descuento_exento_ves,
        'total_gravado_ves'               => $total_gravado_ves,
        'total_exento_ves'                => $total_exento_ves,
        'suma_gravado_exento_ves'         => $total_gravado_ves + $total_exento_ves,
        'subtotal_ves'                    => $subtotal_ves,
        'coinciden_ves'                   => ($total_gravado_ves + $total_exento_ves) == $subtotal_ves ? 'SI' : 'NO',
        'total_iva_ves'                   => $total_iva_ves,
        'total_pagar_ves'                 => $total_pagar_ves,
        'verificacion_5porciento'         => round($subtotal_antes_desc_ves * 0.05, 2),
        'diferencia_con_debug'            => round($subtotal_antes_desc_ves * 0.05, 2) - $monto_descuento_ves,
    ];
    file_put_contents('factura_digital_debug_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT));
    file_put_contents('factura_digital_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT));

    // =====================================================
    // ENVÍO A LA API
    // =====================================================
    try {
        $api      = new TfhkaApiData($api_user, $api_pass);
        $token    = $api->obtenerToken();
        $response = $api->emitirFactura($token, $documento);

        $resultado = $response->resultado ?? null;
        $codigo    = $response->codigo    ?? null;
        $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

        if ($resultado && !empty($resultado->numeroControl)) {
            $numero_control = $resultado->numeroControl;
            $link           = $resultado->urlConsulta ?? null;
            $objeto_factura = new DocumentosData();
            $total_pagar_VES =  $total_pagar_ves;
            $objeto_factura->setFacturaDocum($fact_num, $numero_control, 'FACT', $link, $total_pagar_VES);
            $objeto_factura->addDocumentoURL($fact_num, 'FACT', $link, 1);
            $status   = 'success';
            $msgFinal = ($codigo == "201")
                ? "Documento Duplicado: Sincronizado correctamente."
                : "Documento procesado con éxito.";
        } else {
            $status   = 'error';
            $msgFinal = "No se recibió número de control: " . $mensaje;
        }

        $result = [
            'status'  => $status,
            'message' => $msgFinal,
            'data'    => $response
        ];

    } catch (Exception $e) {
        $result = [
            'status'  => 'error',
            'message' => 'Error crítico: ' . $e->getMessage()
        ];
    }

    header("Content-Type: application/json");
    echo json_encode($result);
}            

                
        if ($accion == 99999999999999999999999999999999999) { // EMITIR FACTURA

            // 1. Obtener el ID
            $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;

            if ($fact_num == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'ID de factura no proporcionado'));
                exit;
            }
        
            // 2. Consultar Datos
            $pedido_obj = new FacturaData();
            $pedido = $pedido_obj->GetFacturaCliente($fact_num);
            $items  = $pedido_obj->GetRenglonFacturaCliente($fact_num);

            // 3. Credenciales
                    $api_user = 'uolltyfnwhqn_tfhka';
                    $api_pass = '4S+W4@@G.JNW';

            // Tasa de cambio: VES por 1 USD
            $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0)
                ? floatval($pedido[0]->tasa)
                : 0.00;

            // Porcentaje de descuento global (viene de la BD)
            $porc_desc = isset($pedido[0]->porc_desc) 
                ? floatval($pedido[0]->porc_desc) 
                : 0.00;

            // 4. Fecha y hora
            $fecha_actual = date('d/m/Y');
            $hora_actual  = date('h:i:s a');

            // Limpieza RIF
            $rif_limpio  = str_replace(["-", "_"], "", $pedido[0]->rif);
            $tipo_id_cli = substr($rif_limpio, 0, 1);
            $num_id_cli  = substr($rif_limpio, 1);

            // Función de formateo
            function formatearNumero($numero, $decimales = 2) {
                return number_format($numero, $decimales, '.', '');
            }

            // =====================================================
            // ACUMULADORES
            // =====================================================
            $total_gravado_usd = 0.00;
            $total_exento_usd  = 0.00;
            $subtotal_usd      = 0.00;

            $arr_items         = [];
            $arr_impuestos_usd = [];
            $nro_linea         = 1;
            $tasa_iva_general  = 16.00;

            // =====================================================
            // ITERAR ITEMS
            // =====================================================
            foreach ($items as $it) {
                $precio_usd    = floatval($it->prec_vta);
                $cantidad      = floatval($it->cant_desp);
                $base_item_usd = $cantidad * $precio_usd;

                $iva_item_usd = 0.00;
                $tasa_item    = 0.00;
                $cod_imp      = "E";

                if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
                    $tasa_item    = $tasa_iva_general;
                    $iva_item_usd = round($base_item_usd * ($tasa_item / 100), 2);
                    $cod_imp      = "G";
                    $total_gravado_usd += $base_item_usd;
                } else {
                    $total_exento_usd += $base_item_usd;
                }

                $subtotal_usd += $base_item_usd;

                // Agrupar impuestos en USD
                $key_tasa = (string)$tasa_item;
                if (!isset($arr_impuestos_usd[$key_tasa])) {
                    $arr_impuestos_usd[$key_tasa] = [
                        "CodigoTotalImp"   => $cod_imp,
                        "AlicuotaImp"      => $tasa_item,
                        "BaseImponibleImp" => 0.00,
                        "ValorTotalImp"    => 0.00
                    ];
                }
                $arr_impuestos_usd[$key_tasa]["BaseImponibleImp"] += $base_item_usd;
                $arr_impuestos_usd[$key_tasa]["ValorTotalImp"]    += $iva_item_usd;

                // Construir ítem
                $arr_items[] = [
                    "NumeroLinea"            => (string)$nro_linea,
                    "CodigoCIIU"             => "0198",
                    "CodigoPLU"              => $it->co_art,
                    "IndicadorBienoServicio" => "1",
                    "Descripcion"            => $it->art_des,
                    "Cantidad"               => formatearNumero($cantidad, 2),
                    "UnidadMedida"           => "UNI",
                    "PrecioUnitario"         => formatearNumero($precio_usd, 2),
                    "PrecioItem"             => formatearNumero($base_item_usd, 2),
                    "CodigoImpuesto"         => $cod_imp,
                    "TasaIVA"                => formatearNumero($tasa_item, 2),
                    "ValorIVA"               => formatearNumero($iva_item_usd, 2),
                    "ValorTotalItem"         => formatearNumero($base_item_usd + $iva_item_usd, 2),
                    "InfoAdicionalItem"      => [
                        ["campo" => "Marca", "valor" => $it->marca]
                    ]
                ];

                $nro_linea++;
            }

            // =====================================================
            // APLICAR DESCUENTO POR PORCENTAJE SOBRE EL SUBTOTAL
            // =====================================================
            $factor_descuento = 1;
            $monto_descuento_usd = 0.00;
            
            if ($porc_desc > 0 && $porc_desc <= 100) {
                $factor_descuento = 1 - ($porc_desc / 100);
                $monto_descuento_usd = round($subtotal_usd * ($porc_desc / 100), 2);
            }

            // Calcular subtotal con descuento PRIMERO
            $subtotal_con_descuento_usd = round($subtotal_usd * $factor_descuento, 2);
            
            // Distribuir el descuento proporcionalmente
            if ($subtotal_usd > 0) {
                // Calcular proporción de cada componente respecto al subtotal
                $total_gravado_con_descuento_usd = round($subtotal_con_descuento_usd * ($total_gravado_usd / $subtotal_usd), 2);
                $total_exento_con_descuento_usd = $subtotal_con_descuento_usd - $total_gravado_con_descuento_usd;
            } else {
                $total_gravado_con_descuento_usd = 0;
                $total_exento_con_descuento_usd = 0;
            }

            // =====================================================
            // IMPUESTOS USD CON DESCUENTO APLICADO
            // =====================================================
            $impuestos_usd = [];
            foreach ($arr_impuestos_usd as $imp) {
                $codigo_impuesto = $imp["CodigoTotalImp"];
                
                if ($codigo_impuesto == "G") {
                    $base_con_desc = $total_gravado_con_descuento_usd;
                } else {
                    $base_con_desc = $total_exento_con_descuento_usd;
                }
                
                // Calcular IVA sobre la base ya descontada
                $valor_con_desc = round($base_con_desc * ($imp["AlicuotaImp"] / 100), 2);

                $impuestos_usd[] = [
                    "CodigoTotalImp"   => $imp["CodigoTotalImp"],
                    "AlicuotaImp"      => formatearNumero($imp["AlicuotaImp"], 2),
                    "BaseImponibleImp" => formatearNumero($base_con_desc, 2),
                    "ValorTotalImp"    => formatearNumero($valor_con_desc, 2)
                ];
            }

            // TotalIVA USD = suma de ValorTotalImp
            $total_iva_con_descuento_usd = 0.00;
            foreach ($impuestos_usd as $imp) {
                $total_iva_con_descuento_usd += floatval($imp["ValorTotalImp"]);
            }
            $total_iva_con_descuento_usd = round($total_iva_con_descuento_usd, 2);

            // Total a pagar USD = Subtotal con descuento + IVA
            $total_pagar_usd = round($subtotal_con_descuento_usd + $total_iva_con_descuento_usd, 2);

            // =====================================================
            // IMPUESTOS EN VES
            // =====================================================
            $impuestos_ves = [];
            foreach ($impuestos_usd as $imp) {
                $base_usd = floatval($imp["BaseImponibleImp"]);
                $alicuota = floatval($imp["AlicuotaImp"]);

                // Base VES redondeada primero
                $base_ves  = round($base_usd * $tasa_cambio, 2);
                // Valor VES calculado DESDE la base VES
                $valor_ves = round($base_ves * ($alicuota / 100), 2);

                $impuestos_ves[] = [
                    "CodigoTotalImp"   => $imp["CodigoTotalImp"],
                    "AlicuotaImp"      => formatearNumero($alicuota, 2),
                    "BaseImponibleImp" => formatearNumero($base_ves, 2),
                    "ValorTotalImp"    => formatearNumero($valor_ves, 2)
                ];
            }

            // =====================================================
            // TOTALES EN VES
            // =====================================================
            $subtotal_ves = round($subtotal_con_descuento_usd * $tasa_cambio, 2);
            $monto_descuento_ves = round($monto_descuento_usd * $tasa_cambio, 2);
            $subtotal_antes_desc_ves = round($subtotal_usd * $tasa_cambio, 2);
            
            // Distribuir en VES usando la misma proporción que en USD
            if ($subtotal_ves > 0) {
                $total_gravado_ves = round($subtotal_ves * ($total_gravado_con_descuento_usd / $subtotal_con_descuento_usd), 2);
                $total_exento_ves = $subtotal_ves - $total_gravado_ves;
            } else {
                $total_gravado_ves = 0;
                $total_exento_ves = 0;
            }

            // TotalIVA VES = suma de ValorTotalImp VES
            $total_iva_ves = 0.0;
            foreach ($impuestos_ves as $imp) {
                $total_iva_ves += floatval($imp["ValorTotalImp"]);
            }
            $total_iva_ves = round($total_iva_ves, 2);

            // TotalAPagar VES = Subtotal con descuento + IVA
            $total_pagar_ves = round($subtotal_antes_desc_ves - $monto_descuento_ves + $total_iva_ves, 2);

            // =====================================================
            // ESTRUCTURA JSON FINAL
            // =====================================================
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento"               => "01",
                            "NumeroDocumento"             => $pedido[0]->fact_num, // número de prueba
                            "TipoProveedor"               => null,
                            "TipoTransaccion"             => null,
                            "NumeroPlanillaImportacion"   => null,
                            "NumeroExpedienteImportacion" => null,
                            "SerieFacturaAfectada"        => null,
                            "NumeroFacturaAfectada"       => null,
                            "FechaFacturaAfectada"        => null,
                            "MontoFacturaAfectada"        => null,
                            "ComentarioFacturaAfectada"   => null,
                            "RegimenEspTributacion"       => null,
                            "FechaEmision"                => $fecha_actual,
                            "FechaVencimiento"            => $fecha_actual,
                            "HoraEmision"                 => $hora_actual,
                            "Anulado"                     => false,
                            "TipoDePago"                  => substr($pedido[0]->forma_pag, 0, 16),
                            "Serie"                       => "",
                            "Sucursal"                    => "",
                            "TipoDeVenta"                 => "Interna",
                            "Moneda"                      => "USD"
                        ],
                        "Vendedor" => [
                            "Codigo"    => $pedido[0]->co_ven,
                            "Nombre"    => $pedido[0]->ven_des,
                            "NumCajero" => $pedido[0]->co_ven,
                        ],
                        "Comprador" => [
                            "TipoIdentificacion"   => $tipo_id_cli,
                            "NumeroIdentificacion" => $num_id_cli,
                            "RazonSocial"          => $pedido[0]->cli_des,
                            "Direccion"            => $pedido[0]->direc1,
                            "Ubigeo"               => null,
                            "Pais"                 => "VE",
                            "Notificar"            => null,
                            "Telefono"             => [$pedido[0]->telefonos],
                            "Correo"               => [
                                $pedido[0]->email,
                                $pedido[0]->correo_vendedor
                            ],
                            "OtrosEnvios" => null,
                        ],
                        "SujetoRetenido" => null,
                        "Tercero"        => null,
                        "Totales" => [
                            "NroItems"               => (string)count($items),
                            "MontoGravadoTotal"      => formatearNumero($total_gravado_ves, 2),
                            "MontoExentoTotal"       => formatearNumero($total_exento_ves, 2),
                            "Subtotal"               => formatearNumero($subtotal_ves, 2),
                            "TotalIVA"               => formatearNumero($total_iva_ves, 2),
                            "MontoTotalConIVA"       => formatearNumero($total_pagar_ves, 2),
                            "TotalAPagar"            => formatearNumero($total_pagar_ves, 2),
                            "TotalDescuento"         => $porc_desc > 0 ? formatearNumero($monto_descuento_ves, 2) : "0.00",
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_antes_desc_ves, 2),
                            "MontoEnLetras"          => "",
                            "ListaDescBonificacion"  => $porc_desc > 0 ? [
                                [
                                    "descDescuento"  => "Descuento " . formatearNumero($porc_desc, 2) . "%",
                                    "montoDescuento" => formatearNumero($monto_descuento_ves, 2)
                                ]
                            ] : [],
                            "ImpuestosSubtotal" => $impuestos_ves,
                            "FormasPago" => [
                                [
                                    "Descripcion" => "TRANSFERENCIA BANCARIA",
                                    "Fecha"       => $fecha_actual,
                                    "Forma"       => "03",
                                    "Monto"       => formatearNumero($total_pagar_ves, 2),
                                    "Moneda"      => "VES",
                                    "TipoCambio"  => "1.0000"
                                ]
                            ]
                        ],
                        "TotalesOtraMoneda" => [
                            "Moneda"                 => "USD",
                            "TipoCambio"             => formatearNumero($tasa_cambio, 4),
                            "MontoGravadoTotal"      => formatearNumero($total_gravado_con_descuento_usd, 2),
                            "MontoExentoTotal"       => formatearNumero($total_exento_con_descuento_usd, 2),
                            "Subtotal"               => formatearNumero($subtotal_con_descuento_usd, 2),
                            "TotalAPagar"            => formatearNumero($total_pagar_usd, 2),
                            "TotalIVA"               => formatearNumero($total_iva_con_descuento_usd, 2),
                            "MontoTotalConIVA"       => formatearNumero($total_pagar_usd, 2),
                            "TotalDescuento"         => $porc_desc > 0 ? formatearNumero($monto_descuento_usd, 2) : "0.00",
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_usd, 2),
                            "MontoEnLetras"          => "",
                            "ListaDescBonificacion"  => $porc_desc > 0 ? [
                                [
                                    "descDescuento"  => "Descuento " . formatearNumero($porc_desc, 2) . "%",
                                    "montoDescuento" => formatearNumero($monto_descuento_usd, 2)
                                ]
                            ] : [],
                            "ImpuestosSubtotal" => $impuestos_usd,
                            "FormasPago" => [
                                [
                                    "Descripcion" => "TRANSFERENCIA BANCARIA",
                                    "Fecha"       => $fecha_actual,
                                    "Forma"       => "03",
                                    "Monto"       => formatearNumero($total_pagar_usd, 2),
                                    "Moneda"      => "USD",
                                    "TipoCambio"  => "1.0000"
                                ]
                            ]
                        ]
                    ],
                    "DetallesItems"     => $arr_items,
                    "DetallesRetencion" => null,
                    "Viajes"            => null,
                    "InfoAdicional" => [
                        ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                        ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                        ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
                    ],
                    "GuiaDespacho" => null,
                    "Transporte"   => null,
                    "EsLote"       => null,
                    "EsMinimo"     => null
                ]
            ];

            // =====================================================
            // DEBUG
            // =====================================================
            $debug_data = [
                'porcentaje_descuento'            => $porc_desc,
                'subtotal_original_usd'           => $subtotal_usd,
                'monto_descuento_usd'             => $monto_descuento_usd,
                'factor_descuento'                => $factor_descuento,
                'total_gravado_con_descuento_usd' => $total_gravado_con_descuento_usd,
                'total_exento_con_descuento_usd'  => $total_exento_con_descuento_usd,
                'suma_gravado_exento_usd'         => $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd,
                'subtotal_con_descuento_usd'      => $subtotal_con_descuento_usd,
                'coinciden_usd'                   => ($total_gravado_con_descuento_usd + $total_exento_con_descuento_usd) == $subtotal_con_descuento_usd ? 'SI' : 'NO',
                'total_iva_con_descuento_usd'     => $total_iva_con_descuento_usd,
                'total_pagar_usd'                 => $total_pagar_usd,
                'tasa_cambio'                     => $tasa_cambio,
                'total_gravado_ves'               => $total_gravado_ves,
                'total_exento_ves'                => $total_exento_ves,
                'suma_gravado_exento_ves'         => $total_gravado_ves + $total_exento_ves,
                'subtotal_ves'                    => $subtotal_ves,
                'coinciden_ves'                   => ($total_gravado_ves + $total_exento_ves) == $subtotal_ves ? 'SI' : 'NO',
                'total_iva_ves'                   => $total_iva_ves,
                'total_pagar_ves'                 => $total_pagar_ves,
                'monto_descuento_ves'             => $monto_descuento_ves,
                'subtotal_antes_desc_ves'         => $subtotal_antes_desc_ves,
                'verificacion_total'              => $subtotal_antes_desc_ves - $monto_descuento_ves + $total_iva_ves,
            ];
            file_put_contents('factura_digital_debug_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT));
            file_put_contents('factura_digital_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT));

            // =====================================================
            // ENVÍO A LA API
            // =====================================================
            try {
                $api      = new TfhkaApiData($api_user, $api_pass);
                $token    = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);

                $resultado = $response->resultado ?? null;
                $codigo    = $response->codigo    ?? null;
                $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

                if ($resultado && !empty($resultado->numeroControl)) {
                    $numero_control = $resultado->numeroControl;
                    $link           = $resultado->urlConsulta ?? null;
                    $objeto_factura = new DocumentosData();
                  //  $objeto_factura->setFacturaDocum($fact_num, $numero_control, 'FACT', $link);
                    $campo_factura_telefono =  $total_pagar_ves;
                    $objeto_factura->setFacturaDocum($fact_num, $numero_control, 'FACT', $link, $campo_factura_telefono);

                    // tengo q enviar  el tota a pagar setFacturaDocum ->  $total_pagar_ves

                    /*  public function setFacturaDocum($fact_num, $numero_control,$tipo_doc,$urlConsulta,$campo_factura_telefono) {
                                try {
                                

                                    
                                        $sql = "UPDATE docum_cc  SET numcon = '$numero_control' WHERE nro_doc  = '$fact_num' and  tipo_doc ='$tipo_doc'";

                                    
                                        $result = Executor::doitEx($sql);
                                        
                                        $sql = "UPDATE factura  SET numcon = '$numero_control',  telefono = '$campo_factura_telefono' WHERE fact_num  = '$fact_num'";
                                    
                                        $result = Executor::doitEx($sql);
                                
                                
                                } catch (Exception $e) {
                                
                                }
                            }*/


                    $objeto_factura->addDocumentoURL($fact_num, 'FACT', $link, 1);
                    $status   = 'success';
                    $msgFinal = ($codigo == "201")
                        ? "Documento Duplicado: Sincronizado correctamente."
                        : "Documento procesado con éxito.";
                } else {
                    $status   = 'error';
                    $msgFinal = "No se recibió número de control: " . $mensaje;
                }

                $result = [
                    'status'  => $status,
                    'message' => $msgFinal,
                    'data'    => $response
                ];

            } catch (Exception $e) {
                $result = [
                    'status'  => 'error',
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
                $api_user = "uolltyfnwhqn_tfhka";
                $api_pass = '4S+W4@@G.JNW';

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

        
        if ($accion == 23042026) { // EMITIR NOTA DE CRÉDITO por DEvolucion

            // 1. Obtener el ID
            $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
            $factura_afectada_num = isset($_POST['factura_afectada']) ? $_POST['factura_afectada'] : 0;
            $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : 'Nota de Crédito';
            $ncr_num = isset($_POST['ncr_num']) ? $_POST['ncr_num'] : 0;

            if ($fact_num == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'ID de nota de crédito no proporcionado'));
                exit;
            }

            /*$fact_num = '118';
            $factura_afectada_num = '2225';
            $ncr_num = '22250001199';*/


            // 2. Consultar Datos de la Nota de Crédito
            $pedido_obj = new FacturaData();
            $pedido = $pedido_obj->GetFacturaClienteNotaCreditoDev($fact_num);
            $items = $pedido_obj->GetRenglonFacturaClienteNotaCreditoDev($fact_num);
            
            // 3. Consultar datos de la factura afectada (original)
            $factura_afectada = $pedido_obj->GetFacturaOriginal($factura_afectada_num);
            
            if (!$factura_afectada || count($factura_afectada) == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'Factura afectada no encontrada'));
                exit;
            }

           
             // 3. Credenciales
            $api_user = 'uolltyfnwhqn_tfhka';
            $api_pass = '4S+W4@@G.JNW';
            

            // Tasa de cambio
            $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 0.00;
            
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
            function formatearNumero2($numero, $decimales = 2) {
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
                
                // IVA (VALOR POSITIVO) - USAR round() COMO EN LA FACTURA
                $iva_item_usd = 0.00;
                $tasa_item = 0.00;
                $cod_imp = "E";

                if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
                    $tasa_item = $tasa_iva_general;
                    // ¡CORREGIDO! Usar round() como en la factura original
                    $iva_item_usd = round($base_item_usd * ($tasa_item / 100), 2);
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

            // =====================================================
            // APLICAR DESCUENTO GLOBAL - IGUAL QUE LA FACTURA
            // =====================================================
            $factor_descuento = 1;
            if ($subtotal_usd > 0 && $descuento_global_usd > 0) {
                $factor_descuento = 1 - ($descuento_global_usd / $subtotal_usd);
            }

            $total_gravado_con_descuento_usd = $total_gravado_usd * $factor_descuento;
            $total_exento_con_descuento_usd = $total_exento_usd * $factor_descuento;
            $subtotal_con_descuento_usd = $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd;

            // =====================================================
            // IMPUESTOS USD CON DESCUENTO - IGUAL QUE LA FACTURA
            // =====================================================
            $impuestos_usd = [];
            foreach ($arr_impuestos_usd as $imp) {
                $base_con_desc = $imp["BaseImponibleImp"] * $factor_descuento;
                // ¡CORREGIDO! Usar round() como en la factura original
                $valor_con_desc = round($base_con_desc * ($imp["AlicuotaImp"] / 100), 2);

                $impuestos_usd[] = [
                    "CodigoTotalImp" => $imp["CodigoTotalImp"],
                    "AlicuotaImp" => formatearNumero($imp["AlicuotaImp"], 2),
                    "BaseImponibleImp" => formatearNumero($base_con_desc, 2),
                    "ValorTotalImp" => formatearNumero($valor_con_desc, 2)
                ];
            }

            // TotalIVA USD = suma de ValorTotalImp redondeados (IGUAL QUE FACTURA)
            $total_iva_con_descuento_usd = 0.00;
            foreach ($impuestos_usd as $imp) {
                $total_iva_con_descuento_usd += floatval($imp["ValorTotalImp"]);
            }

            $total_pagar_usd = $subtotal_con_descuento_usd + $total_iva_con_descuento_usd;

            // =====================================================
            // IMPUESTOS EN VES - IGUAL QUE LA FACTURA
            // =====================================================
            $impuestos_ves = [];
            foreach ($impuestos_usd as $imp) {
                $base_usd = floatval(str_replace(',', '.', $imp["BaseImponibleImp"]));
                $alicuota = floatval(str_replace(',', '.', $imp["AlicuotaImp"]));

                // Base VES redondeada primero
                $base_ves = round($base_usd * $tasa_cambio, 2);
                // Valor VES calculado DESDE la base VES (no desde IVA USD × tasa)
                $valor_ves = round($base_ves * ($alicuota / 100), 2);

                $impuestos_ves[] = [
                    "CodigoTotalImp" => $imp["CodigoTotalImp"],
                    "AlicuotaImp" => $imp["AlicuotaImp"],
                    "BaseImponibleImp" => formatearNumero($base_ves, 2),
                    "ValorTotalImp" => formatearNumero($valor_ves, 2)
                ];
            }

            // =====================================================
            // TOTALES EN VES - IGUAL QUE LA FACTURA
            // =====================================================
            $total_gravado_ves = round($total_gravado_con_descuento_usd * $tasa_cambio, 2);
            $total_exento_ves = round($total_exento_con_descuento_usd * $tasa_cambio, 2);
            $subtotal_ves = round($subtotal_con_descuento_usd * $tasa_cambio, 2);
            $monto_descuento_ves = round($descuento_global_usd * $tasa_cambio, 2);
            $subtotal_antes_desc_ves = round($subtotal_usd * $tasa_cambio, 2);

            // TotalIVA VES = suma de ValorTotalImp VES (IGUAL QUE FACTURA)
            $total_iva_ves = 0.0;
            foreach ($impuestos_ves as $imp) {
                $total_iva_ves += floatval($imp["ValorTotalImp"]);
            }
            $total_iva_ves = round($total_iva_ves, 2);

            // TotalAPagar VES desde subtotal + iva corregidos
            $total_pagar_ves = round($subtotal_ves + $total_iva_ves, 2);
            
            // Monto de la factura afectada (original) - VALOR POSITIVO
            $monto_factura_afectada_usd = abs(isset($factura_afectada[0]->total_api_facturacion) ? floatval($factura_afectada[0]->total_api_facturacion) : 0);
            
            // =====================================================
            // ESTRUCTURA PARA NOTA DE CRÉDITO (VALORES POSITIVOS)
            // =====================================================
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento" => "02", // Nota de Crédito
                            "NumeroDocumento" => $ncr_num,
                            "TipoProveedor" => null,
                            "TipoTransaccion" => "02", // Complemento
                            "NumeroPlanillaImportacion" => null,
                            "NumeroExpedienteImportacion" => null,
                            // Campos de la factura afectada (obligatorios para NC/ND)
                            "SerieFacturaAfectada" => "",
                            "NumeroFacturaAfectada" => $factura_afectada[0]->fact_num,
                            "FechaFacturaAfectada" => $fecha_factura_afectada,
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
                            "Correo" => [                                
                                $pedido[0]->email,
                                $pedido[0]->correo_vendedor                                
                            ],
                            "OtrosEnvios" => null
                        ],
                        "SujetoRetenido" => null,
                        "Tercero" => null,
                        "Totales" => [
                            "NroItems" => (string)count($items),
                            "MontoGravadoTotal" => formatearNumero($total_gravado_ves, 2),
                            "MontoExentoTotal" => formatearNumero($total_exento_ves, 2),
                            "Subtotal" => formatearNumero($subtotal_ves, 2),
                            "TotalIVA" => formatearNumero2($total_iva_ves, 2),
                            "MontoTotalConIVA" => formatearNumero($total_pagar_ves, 2),
                            "TotalAPagar" => formatearNumero($total_pagar_ves, 2),
                            "TotalDescuento" => $descuento_global_usd != 0 ? formatearNumero($monto_descuento_ves, 2) : null,
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_antes_desc_ves, 2),
                            "MontoEnLetras" => "",
                            "ListaDescBonificacion" => $descuento_global_usd != 0 ? [
                                [
                                    "descDescuento" => "Descuento global",
                                    "montoDescuento" => formatearNumero($monto_descuento_ves, 2)
                                ]
                            ] : null,
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
                            "TotalIVA" => formatearNumero2($total_iva_con_descuento_usd, 2),
                            "MontoTotalConIVA" => formatearNumero($total_pagar_usd, 2),
                            "TotalDescuento" => $descuento_global_usd != 0 ? formatearNumero($descuento_global_usd, 2) : null,
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_usd, 2),
                            "MontoEnLetras" => "",
                            "ListaDescBonificacion" => $descuento_global_usd != 0 ? [
                                [
                                    "descDescuento" => "Descuento global",
                                    "montoDescuento" => formatearNumero($descuento_global_usd, 2)
                                ]
                            ] : null,
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
                        ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                        ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                        ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
                    ],
                    "GuiaDespacho" => null,
                    "Transporte" => null,
                    "EsLote" => null,
                    "EsMinimo" => null
                ]
            ];

            // Debug data mejorado
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
                'factor_descuento' => $factor_descuento,
                'total_gravado_original_usd' => $total_gravado_usd,
                'total_exento_original_usd' => $total_exento_usd,
                'subtotal_con_descuento_usd' => $subtotal_con_descuento_usd,
                'total_gravado_con_descuento_usd' => $total_gravado_con_descuento_usd,
                'total_exento_con_descuento_usd' => $total_exento_con_descuento_usd,
                'total_iva_con_descuento_usd' => $total_iva_con_descuento_usd,
                'total_pagar_usd' => $total_pagar_usd,
                
                // Totales en VES (valores positivos)
                'tasa_cambio' => $tasa_cambio,
                'subtotal_ves' => $subtotal_ves,
                'total_gravado_ves' => $total_gravado_ves,
                'total_exento_ves' => $total_exento_ves,
                'total_iva_ves' => $total_iva_ves,
                'total_pagar_ves' => $total_pagar_ves,
                'monto_descuento_ves' => $monto_descuento_ves,
                
                // Validaciones clave
                'CHECK_TotalIVA_ves' => $total_iva_ves,
                'CHECK_ValorTotalImp_G_ves' => isset($impuestos_ves[0]) ? $impuestos_ves[0]["ValorTotalImp"] : 'N/A',
                'CHECK_Base_x_16pct' => isset($impuestos_ves[0])
                    ? round(floatval($impuestos_ves[0]["BaseImponibleImp"]) * 0.16, 2)
                    : 'N/A',
                
                // Items
                'cantidad_items' => count($arr_items),
                
                // Impuestos
                'impuestos_usd' => $impuestos_usd,
                'impuestos_ves' => $impuestos_ves
            ];

            file_put_contents('debug_nota_credito_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            file_put_contents('nota_credito_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            try {
                $api = new TfhkaApiData($api_user, $api_pass);
                $token = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);

                // Extraer datos de la respuesta
                $resultado = $response->resultado ?? null;
                $codigo    = $response->codigo    ?? null;
                $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

                // Lógica de Sincronización
                if ($resultado && !empty($resultado->numeroControl)) {
                    $numero_control = $resultado->numeroControl;
                    
                    $objeto_factura = new DocumentosData();
                    $respuesta_db = $objeto_factura->setFacturaDevolucion($fact_num, $numero_control, 'FACT');
                    $link = $resultado->urlConsulta ?? null;
                    $respuesta_db = $objeto_factura->addDocumentoURL($fact_num,'DEV',$link,1);
                    
                    $status = 'success';
                    $msgFinal = ($codigo == "201") ? "Documento Duplicado: Sincronizado correctamente." : "Documento procesado con éxito.";
                } else {
                    $status = 'error';
                    $msgFinal = "No se recibió número de control: " . $mensaje;
                }

                $result = [
                    'status'  => $status,
                    'message' => $msgFinal,
                    'data'    => $response
                ];

            } catch (Exception $e) {
                $result = [
                    'status'  => 'error',
                    'message' => 'Error crítico: ' . $e->getMessage()
                ];
            }

            header("Content-Type: application/json");
            echo json_encode($result);
        }




        if ($accion == 3) { // EMITIR NOTA DE CRÉDITO por DEvolucion

            // 1. Obtener el ID
            $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
            $factura_afectada_num = isset($_POST['factura_afectada']) ? $_POST['factura_afectada'] : 0;
            $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : 'Nota de Crédito';
            $ncr_num = isset($_POST['ncr_num']) ? $_POST['ncr_num'] : 0;

            if ($fact_num == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'ID de nota de crédito no proporcionado'));
                exit;
            }

        


            // 2. Consultar Datos de la Nota de Crédito
            $pedido_obj = new FacturaData();
            $pedido = $pedido_obj->GetFacturaClienteNotaCreditoDev($ncr_num);
            $items = $pedido_obj->GetRenglonFacturaClienteNotaCreditoDev($ncr_num);
            
            // 3. Consultar datos de la factura afectada (original)
            $factura_afectada = $pedido_obj->GetFacturaOriginal($factura_afectada_num);
            
            if (!$factura_afectada || count($factura_afectada) == 0) {
                echo json_encode(array('status' => 'error', 'message' => 'Factura afectada no encontrada'));
                exit;
            }

             // 3. Credenciales
                $api_user = "uolltyfnwhqn_tfhka";
                $api_pass = '4S+W4@@G.JNW';

            // Tasa de cambio
            $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 0.00;
            
            // Porcentaje de descuento global (IGUAL QUE FACTURA)
            $porc_desc = isset($pedido[0]->porc_desc) ? floatval($pedido[0]->porc_desc) : 0.00;
            
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
            function formatearNumero2($numero, $decimales = 2) {
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
                    $iva_item_usd = round($base_item_usd * ($tasa_item / 100), 2);
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

            // =====================================================
            // APLICAR DESCUENTO - IGUAL QUE FACTURA (PORCENTAJE)
            // =====================================================
            $factor_descuento = 1;
            $monto_descuento_usd = 0.00;
            
            if ($porc_desc > 0 && $porc_desc <= 100) {
                $factor_descuento = 1 - ($porc_desc / 100);
                $monto_descuento_usd = round($subtotal_usd * ($porc_desc / 100), 2);
            }

            // Calcular subtotal con descuento PRIMERO
            $subtotal_con_descuento_usd = round($subtotal_usd * $factor_descuento, 2);
            
            // Distribuir el descuento proporcionalmente
            if ($subtotal_usd > 0) {
                $total_gravado_con_descuento_usd = round($subtotal_con_descuento_usd * ($total_gravado_usd / $subtotal_usd), 2);
                $total_exento_con_descuento_usd = $subtotal_con_descuento_usd - $total_gravado_con_descuento_usd;
            } else {
                $total_gravado_con_descuento_usd = 0;
                $total_exento_con_descuento_usd = 0;
            }

            // =====================================================
            // IMPUESTOS USD CON DESCUENTO - IGUAL QUE FACTURA
            // =====================================================
            $impuestos_usd = [];
            foreach ($arr_impuestos_usd as $imp) {
                $codigo_impuesto = $imp["CodigoTotalImp"];
                
                if ($codigo_impuesto == "G") {
                    $base_con_desc = $total_gravado_con_descuento_usd;
                } else {
                    $base_con_desc = $total_exento_con_descuento_usd;
                }
                
                $valor_con_desc = round($base_con_desc * ($imp["AlicuotaImp"] / 100), 2);

                $impuestos_usd[] = [
                    "CodigoTotalImp" => $imp["CodigoTotalImp"],
                    "AlicuotaImp" => formatearNumero($imp["AlicuotaImp"], 2),
                    "BaseImponibleImp" => formatearNumero($base_con_desc, 2),
                    "ValorTotalImp" => formatearNumero($valor_con_desc, 2)
                ];
            }

            // TotalIVA USD
            $total_iva_con_descuento_usd = 0.00;
            foreach ($impuestos_usd as $imp) {
                $total_iva_con_descuento_usd += floatval($imp["ValorTotalImp"]);
            }
            $total_iva_con_descuento_usd = round($total_iva_con_descuento_usd, 2);

            // Total a pagar USD
            $total_pagar_usd = round($subtotal_con_descuento_usd + $total_iva_con_descuento_usd, 2);

            // =====================================================
            // IMPUESTOS EN VES - IGUAL QUE FACTURA
            // =====================================================
            $impuestos_ves = [];
            foreach ($impuestos_usd as $imp) {
                $base_usd = floatval(str_replace(',', '.', $imp["BaseImponibleImp"]));
                $alicuota = floatval(str_replace(',', '.', $imp["AlicuotaImp"]));

                // Base VES redondeada primero
                $base_ves = round($base_usd * $tasa_cambio, 2);
                // Valor VES calculado DESDE la base VES
                $valor_ves = round($base_ves * ($alicuota / 100), 2);

                $impuestos_ves[] = [
                    "CodigoTotalImp" => $imp["CodigoTotalImp"],
                    "AlicuotaImp" => $imp["AlicuotaImp"],
                    "BaseImponibleImp" => formatearNumero($base_ves, 2),
                    "ValorTotalImp" => formatearNumero($valor_ves, 2)
                ];
            }

            // =====================================================
            // TOTALES EN VES - IGUAL QUE FACTURA
            // =====================================================
            $subtotal_ves = round($subtotal_con_descuento_usd * $tasa_cambio, 2);
            $monto_descuento_ves = round($monto_descuento_usd * $tasa_cambio, 2);
            $subtotal_antes_desc_ves = round($subtotal_usd * $tasa_cambio, 2);
            
            // Distribuir en VES usando la misma proporción que en USD
            if ($subtotal_ves > 0 && $subtotal_con_descuento_usd > 0) {
                $total_gravado_ves = round($subtotal_ves * ($total_gravado_con_descuento_usd / $subtotal_con_descuento_usd), 2);
                $total_exento_ves = $subtotal_ves - $total_gravado_ves;
            } else {
                $total_gravado_ves = 0;
                $total_exento_ves = 0;
            }

            // TotalIVA VES = suma de ValorTotalImp VES
            $total_iva_ves = 0.0;
            foreach ($impuestos_ves as $imp) {
                $total_iva_ves += floatval($imp["ValorTotalImp"]);
            }
            $total_iva_ves = round($total_iva_ves, 2);

            // TotalAPagar VES - IGUAL QUE FACTURA
            $total_pagar_ves = round($subtotal_antes_desc_ves - $monto_descuento_ves + $total_iva_ves, 2);
            
            // Monto de la factura afectada (original) - VALOR POSITIVO
            $monto_factura_afectada_usd = abs(isset($factura_afectada[0]->total_api_facturacion) ? floatval($factura_afectada[0]->total_api_facturacion) : 0);
            
            // =====================================================
            // ESTRUCTURA PARA NOTA DE CRÉDITO (VALORES POSITIVOS)
            // =====================================================
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento" => "02", // Nota de Crédito
                            "NumeroDocumento" =>  $fact_num,
                            "TipoProveedor" => null,
                            "TipoTransaccion" => "02", // Complemento
                            "NumeroPlanillaImportacion" => null,
                            "NumeroExpedienteImportacion" => null,
                            // Campos de la factura afectada (obligatorios para NC/ND)
                            "SerieFacturaAfectada" => "",
                            "NumeroFacturaAfectada" => $factura_afectada[0]->fact_num,
                            "FechaFacturaAfectada" => $fecha_factura_afectada,
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
                            "Correo" => [                                
                                $pedido[0]->email,
                                $pedido[0]->correo_vendedor                                
                            ],
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
                            "TotalDescuento" => $porc_desc > 0 ? formatearNumero($monto_descuento_ves, 2) : "0.00",
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_antes_desc_ves, 2),
                            "MontoEnLetras" => "",
                            "ListaDescBonificacion" => $porc_desc > 0 ? [
                                [
                                    "descDescuento" => "Descuento " . formatearNumero($porc_desc, 2) . "%",
                                    "montoDescuento" => formatearNumero($monto_descuento_ves, 2)
                                ]
                            ] : [],
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
                            "TotalDescuento" => $porc_desc > 0 ? formatearNumero($monto_descuento_usd, 2) : "0.00",
                            "SubtotalAntesDescuento" => formatearNumero($subtotal_usd, 2),
                            "MontoEnLetras" => "",
                            "ListaDescBonificacion" => $porc_desc > 0 ? [
                                [
                                    "descDescuento" => "Descuento " . formatearNumero($porc_desc, 2) . "%",
                                    "montoDescuento" => formatearNumero($monto_descuento_usd, 2)
                                ]
                            ] : [],
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
                        ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                        ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                        ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
                    ],
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
                'porcentaje_descuento' => $porc_desc,
                
                // Totales en USD
                'subtotal_original_usd' => $subtotal_usd,
                'monto_descuento_usd' => $monto_descuento_usd,
                'factor_descuento' => $factor_descuento,
                'total_gravado_con_descuento_usd' => $total_gravado_con_descuento_usd,
                'total_exento_con_descuento_usd' => $total_exento_con_descuento_usd,
                'suma_gravado_exento_usd' => $total_gravado_con_descuento_usd + $total_exento_con_descuento_usd,
                'subtotal_con_descuento_usd' => $subtotal_con_descuento_usd,
                'coinciden_usd' => ($total_gravado_con_descuento_usd + $total_exento_con_descuento_usd) == $subtotal_con_descuento_usd ? 'SI' : 'NO',
                'total_iva_con_descuento_usd' => $total_iva_con_descuento_usd,
                'total_pagar_usd' => $total_pagar_usd,
                
                // Totales en VES
                'tasa_cambio' => $tasa_cambio,
                'total_gravado_ves' => $total_gravado_ves,
                'total_exento_ves' => $total_exento_ves,
                'suma_gravado_exento_ves' => $total_gravado_ves + $total_exento_ves,
                'subtotal_ves' => $subtotal_ves,
                'coinciden_ves' => ($total_gravado_ves + $total_exento_ves) == $subtotal_ves ? 'SI' : 'NO',
                'total_iva_ves' => $total_iva_ves,
                'total_pagar_ves' => $total_pagar_ves,
                'monto_descuento_ves' => $monto_descuento_ves,
                'subtotal_antes_desc_ves' => $subtotal_antes_desc_ves,
                'verificacion_total_ves' => round($subtotal_antes_desc_ves - $monto_descuento_ves + $total_iva_ves, 2),
                
                // Impuestos
                'impuestos_usd' => $impuestos_usd,
                'impuestos_ves' => $impuestos_ves
            ];

            file_put_contents('debug_nota_credito_' . $fact_num . '.json', json_encode($debug_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            file_put_contents('nota_credito_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            try {
                $api = new TfhkaApiData($api_user, $api_pass);
                $token = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);

                // Extraer datos de la respuesta
                $resultado = $response->resultado ?? null;
                $codigo    = $response->codigo    ?? null;
                $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

                // Lógica de Sincronización
                if ($resultado && !empty($resultado->numeroControl)) {
                    $numero_control = $resultado->numeroControl;
                    
                    $objeto_factura = new DocumentosData();
                    $total_pagar_VES =  $total_pagar_ves;
                    $objeto_factura->setFacturaDevolucion($fact_num, $numero_control, 'N/CR');
                    $link = $resultado->urlConsulta ?? null;
                    $respuesta_db = $objeto_factura->addDocumentoURL($fact_num,'DEV',$link,1);
                    
                    $status = 'success';
                    $msgFinal = ($codigo == "201") ? "Documento Duplicado: Sincronizado correctamente." : "Documento procesado con éxito.";
                } else {
                    $status = 'error';
                    $msgFinal = "No se recibió número de control: " . $mensaje;
                }

                $result = [
                    'status'  => $status,
                    'message' => $msgFinal,
                    'data'    => $response
                ];

            } catch (Exception $e) {
                $result = [
                    'status'  => 'error',
                    'message' => 'Error crítico: ' . $e->getMessage()
                ];
            }

            header("Content-Type: application/json");
            echo json_encode($result);
        }





        if ($accion == 4) { // EMITIR NOTA DE DÉBITO

            // 1. Datos iniciales
            $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
            $factura_afectada_num = isset($_POST['factura_afectada']) ? $_POST['factura_afectada'] : 0;
            $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : 'Incremento de valor';

            $pedido_obj = new FacturaData();
            $pedido = $pedido_obj->GetFacturaCliente($fact_num);
            $items = $pedido_obj->GetRenglonFacturaCliente($fact_num);
            $factura_afectada = $pedido_obj->GetFacturaCliente($factura_afectada_num);

            // 2. Configuración
            $api_user = "uolltyfnwhqn_tfhka";
            $api_pass = '4S+W4@@G.JNW';
            $tasa_cambio = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0) ? floatval($pedido[0]->tasa) : 352.7063;
            $serie_fiscal = ""; 

            function formatearNum($n, $d = 2) {
                return number_format($n, $d, '.', '');
            }

            // 3. Acumuladores para Cálculos
            $total_gravado_ves = 0.00;
            $total_exento_ves = 0.00;
            $total_iva_ves = 0.00;
            
            $total_gravado_usd = 0.00;
            $total_exento_usd = 0.00;
            $total_iva_usd = 0.00;

            $arr_items = [];
            $nro_linea = 1;

            foreach ($items as $it) {
                $cantidad = abs(floatval($it->cant_desp));
                $precio_usd = abs(floatval($it->prec_vta));
                $precio_ves = $precio_usd * $tasa_cambio;
                
                $base_item_ves = $cantidad * $precio_ves;
                $base_item_usd = $cantidad * $precio_usd;
                
                $iva_item_ves = 0.00;
                $iva_item_usd = 0.00;
                $tasa_item = 0.00;
                $cod_imp = "E";

                if (isset($it->tipo_imp) && $it->tipo_imp == '1') {
                    $tasa_item = 16.00;
                    $cod_imp = "G";
                    $iva_item_ves = $base_item_ves * ($tasa_item / 100);
                    $iva_item_usd = $base_item_usd * ($tasa_item / 100);
                    
                    $total_gravado_ves += $base_item_ves;
                    $total_gravado_usd += $base_item_usd;
                    $total_iva_ves += $iva_item_ves;
                    $total_iva_usd += $iva_item_usd;
                } else {
                    $total_exento_ves += $base_item_ves;
                    $total_exento_usd += $base_item_usd;
                }

                $arr_items[] = [
                    "NumeroLinea" => (string)$nro_linea,
                    "CodigoPLU" => $it->co_art,
                    "IndicadorBienoServicio" => "1",
                    "Descripcion" => $it->art_des,
                    "Cantidad" => formatearNum($cantidad, 2),
                    "UnidadMedida" => "UNI",
                    "PrecioUnitario" => formatearNum($precio_ves, 2),
                    "PrecioItem" => formatearNum($base_item_ves, 2),
                    "CodigoImpuesto" => $cod_imp,
                    "TasaIVA" => formatearNum($tasa_item, 2),
                    "ValorIVA" => formatearNum($iva_item_ves, 2),
                    "ValorTotalItem" => formatearNum($base_item_ves + $iva_item_ves, 2)
                ];
                $nro_linea++;
            }

            $total_pagar_ves = $total_gravado_ves + $total_exento_ves + $total_iva_ves;
            $total_pagar_usd = $total_gravado_usd + $total_exento_usd + $total_iva_usd;

            // 4. Construcción del Objeto Final
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento" => "03",
                            "NumeroDocumento" => (string)$pedido[0]->fact_num,
                            "TipoTransaccion" => "01",
                            "SerieFacturaAfectada" => "",
                            "NumeroFacturaAfectada" => (string)$factura_afectada[0]->fact_num,
                            "FechaFacturaAfectada" => date('d/m/Y', strtotime($factura_afectada[0]->fec_emis)),
                            "MontoFacturaAfectada" => formatearNum(abs($factura_afectada[0]->tot_neto), 2),
                            "ComentarioFacturaAfectada" => $comentario,
                            "FechaEmision" => date('d/m/Y'),
                            "FechaVencimiento" => date('d/m/Y'),
                            "HoraEmision" => date('h:i:s a'),
                            "TipoDePago" => "Inmediato",
                            "Serie" => $serie_fiscal,
                            "TipoDeVenta" => "Interna",
                            "Moneda" => "BSD"
                        ],
                        "Comprador" => [
                            "TipoIdentificacion" => substr(str_replace(["-", "_"], "", $pedido[0]->rif), 0, 1),
                            "NumeroIdentificacion" => substr(str_replace(["-", "_"], "", $pedido[0]->rif), 1),
                            "RazonSocial" => $pedido[0]->cli_des,
                            "Direccion" => $pedido[0]->direc1,
                            "Pais" => "VE"
                        ],
                        "Totales" => [
                            "NroItems" => (string)count($items),
                            "MontoGravadoTotal" => formatearNum($total_gravado_ves, 2),
                            "MontoExentoTotal" => formatearNum($total_exento_ves, 2),
                            "Subtotal" => formatearNum($total_gravado_ves + $total_exento_ves, 2),
                            "TotalIVA" => formatearNum($total_iva_ves, 2),
                            "MontoTotalConIVA" => formatearNum($total_pagar_ves, 2),
                            "TotalAPagar" => formatearNum($total_pagar_ves, 2),
                            "ImpuestosSubtotal" => [
                                ["CodigoTotalImp" => "G", "AlicuotaImp" => "16.00", "BaseImponibleImp" => formatearNum($total_gravado_ves, 2), "ValorTotalImp" => formatearNum($total_iva_ves, 2)],
                                ["CodigoTotalImp" => "E", "AlicuotaImp" => "0.00", "BaseImponibleImp" => formatearNum($total_exento_ves, 2), "ValorTotalImp" => "0.00"]
                            ],
                            // SOLUCIÓN AL ERROR 1015 y 1016:
                            "FormasPago" => [
                                [
                                    "Descripcion" => "Transferencia",
                                    "Fecha" => date('d/m/Y'),
                                    "Forma" => "03", // 03 suele ser Transferencia
                                    "Monto" => formatearNum($total_pagar_ves, 2),
                                    "Moneda" => "BSD",
                                    "TipoCambio" => "0.0000"
                                ]
                            ]
                        ],
                        "TotalesOtraMoneda" => [
                            "Moneda" => "USD",
                            "TipoCambio" => formatearNum($tasa_cambio, 4),
                            "MontoGravadoTotal" => formatearNum($total_gravado_usd, 2),
                            "MontoExentoTotal" => formatearNum($total_exento_usd, 2),
                            "Subtotal" => formatearNum($total_gravado_usd + $total_exento_usd, 2),
                            "TotalIVA" => formatearNum($total_iva_usd, 2),
                            "MontoTotalConIVA" => formatearNum($total_pagar_usd, 2),
                            "TotalAPagar" => formatearNum($total_pagar_usd, 2),
                            "ImpuestosSubtotal" => [
                                ["CodigoTotalImp" => "G", "AlicuotaImp" => "16.00", "BaseImponibleImp" => formatearNum($total_gravado_usd, 2), "ValorTotalImp" => formatearNum($total_iva_usd, 2)],
                                ["CodigoTotalImp" => "E", "AlicuotaImp" => "0.00", "BaseImponibleImp" => formatearNum($total_exento_usd, 2), "ValorTotalImp" => "0.00"]
                            ]
                        ]
                    ],
                    "DetallesItems" => $arr_items
                ]
            ];

            // 5. Envío a API
            try {
                $api = new TfhkaApiData($api_user, $api_pass);
                $token = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);
                $objeto_factura = new FacturaData();
                $respuesta_2 = $objeto_factura->guardarRespuestaApi($fact_num,$numero_control,'N/DB');
                header("Content-Type: application/json");
                echo json_encode(['status' => 'success', 'data' => $response]);
            } catch (Exception $e) {
                header("Content-Type: application/json");
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }




        if ($accion == 5) { // EMITIR NOTA DE CRÉDITO ADMINISTRATIVA

            // 1. Obtener IDs
            $fact_num             = isset($_POST['fact_num'])         ? $_POST['fact_num']         : 0;
            $factura_afectada_num = isset($_POST['factura_afectada']) ? $_POST['factura_afectada'] : 0;
            $comentario           = isset($_POST['comentario'])        ? $_POST['comentario']        : 'Descuento Pronto Pago';

         
            // 2. Consultar Datos
            $pedido_obj       = new FacturaData();
            $pedido           = $pedido_obj->GetFacturaClienteNotas($fact_num);
            $factura_afectada = $pedido_obj->GetFacturaOriginal($factura_afectada_num);

            // 3. Montos — todos vienen en BOLÍVARES desde la BD
            // Se eliminó la condición $es_usd: factor siempre es 1


            $monto_excento_orig = floatval($pedido[0]->exento);
            $tot_bruto_orig     = floatval($pedido[0]->tot_bruto);
            $tot_iva_orig       = floatval($pedido[0]->iva);

            $tasa_cambio        = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0)
                                ? floatval($pedido[0]->tasa)
                                : 1.00;

            if (!function_exists('formatear')) {
                function formatear($num) { return number_format((float)$num, 2, '.', ''); }
            }
            if (!function_exists('formatear4')) {
                function formatear4($num) { return number_format((float)$num, 4, '.', ''); }
            }

            $fecha_actual = date('d/m/Y');
            $hora_actual  = date('h:i:s a');
        

            if(($tot_iva_orig>0.00 ) && ($monto_excento_orig>0.00)){
                                        
                                    // --- CÁLCULOS EN VES (los datos ya están en VES, factor = 1) ---
                            $base_ves       = round($tot_bruto_orig, 2);        // ya en VES
                            $iva_ves        = round($base_ves * 0.16, 2);       // IVA sobre base VES
                            $total_item_ves = $base_ves + $iva_ves;

                            // --- CÁLCULOS EN USD (dividimos VES / tasa) ---
                            $base_usd = round($base_ves / $tasa_cambio, 2);
                            $iva_usd  = round($base_usd * 0.16, 2);            // IVA sobre base USD (no dividir iva_ves)
                            $total_item_usd = $base_usd + $iva_usd;

                            // Items
                            $arr_items = [];

                            // Item 1: Gravado
                            $arr_items[] = [
                                "NumeroLinea"            => "1",
                                "CodigoCIIU"             => "0198",
                                "CodigoPLU"              => "NCR-01",
                                "IndicadorBienoServicio" => "1",
                                "Descripcion"            => "DESCUENTO PRONTO PAGO (G)",
                                "Cantidad"               => "1.00",
                                "UnidadMedida"           => "UNI",
                                "PrecioUnitario"         => formatear($base_ves),
                                "PrecioItem"             => formatear($base_ves),
                                "CodigoImpuesto"         => "G",
                                "TasaIVA"                => "16.00",
                                "ValorIVA"               => formatear($iva_ves),
                                "ValorTotalItem"         => formatear($total_item_ves)
                            ];

                            // Item 2: Exento (si aplica)
                            $acumulado_exento_ves = 0.00;
                            $exento_usd           = 0.00;
                            if ($monto_excento_orig > 0) {
                                $exento_ves_item  = round($monto_excento_orig, 2);  // ya en VES
                                $acumulado_exento_ves = $exento_ves_item;
                                $exento_usd       = round($exento_ves_item / $tasa_cambio, 2);

                                $arr_items[] = [
                                    "NumeroLinea"            => "2",
                                    "CodigoCIIU"             => "0198",
                                    "CodigoPLU"              => "NCR-02",
                                    "IndicadorBienoServicio" => "1",
                                    "Descripcion"            => "DESCUENTO PRONTO PAGO (E)",
                                    "Cantidad"               => "1.00",
                                    "UnidadMedida"           => "UNI",
                                    "PrecioUnitario"         => formatear($exento_ves_item),
                                    "PrecioItem"             => formatear($exento_ves_item),
                                    "CodigoImpuesto"         => "E",
                                    "TasaIVA"                => "0.00",
                                    "ValorIVA"               => "0.00",
                                    "ValorTotalItem"         => formatear($exento_ves_item)
                                ];
                            }

                            // Totales VES
                            $subtotal_ves    = $base_ves + $acumulado_exento_ves;
                            $total_final_ves = $subtotal_ves + $iva_ves;

                            // Totales USD
                                    $subtotal_usd    = $base_usd + $exento_usd;
                                    $total_final_usd = $subtotal_usd + $iva_usd;


            }elseif(($monto_excento_orig>0.00) && ($tot_iva_orig==0) ){

                $arr_items = [];
                $exento_ves_item      = round($monto_excento_orig, 2);
                $acumulado_exento_ves = $exento_ves_item;

               
                $base_ves       = 0.00;
                $iva_ves        = 0.00;
                $total_item_ves = $exento_ves_item;  // el total del item es solo el exento

                $subtotal_ves    = $acumulado_exento_ves;   // ✅ solo exento, sin duplicar
                $total_final_ves = $subtotal_ves;           // sin IVA

                $base_usd       = 0.00;
                $iva_usd        = 0.00;
                $exento_usd     = round($exento_ves_item / $tasa_cambio, 2);

                $subtotal_usd    = $exento_usd;
                $total_final_usd = $subtotal_usd;


                $arr_items[] = [
                    "NumeroLinea"            => "1",
                    "CodigoCIIU"             => "0198",
                    "CodigoPLU"              => "NCR-01",
                    "IndicadorBienoServicio" => "1",
                    "Descripcion"            => "DESCUENTO PRONTO PAGO (E)",
                    "Cantidad"               => "1.00",
                    "UnidadMedida"           => "UNI",
                    "PrecioUnitario"         => formatear($exento_ves_item.".00"),
                    "PrecioItem"             => formatear($exento_ves_item.".00"),
                    "CodigoImpuesto"         => "E",
                    "TasaIVA"                => "0.00",
                    "ValorIVA"               => "0.00",
                    "ValorTotalItem"         => formatear($exento_ves_item.".00")
                ];
            
          

            }elseif(($tot_iva_orig>0.00)){
                      
                                     // --- CÁLCULOS EN VES (los datos ya están en VES, factor = 1) ---
                        $base_ves       = round($tot_bruto_orig, 2);        // ya en VES
                        $iva_ves        = round($base_ves * 0.16, 2);       // IVA sobre base VES
                        $total_item_ves = $base_ves + $iva_ves;

                        // --- CÁLCULOS EN USD (dividimos VES / tasa) ---
                        $base_usd = round($base_ves / $tasa_cambio, 2);
                        $iva_usd  = round($base_usd * 0.16, 2);            // IVA sobre base USD (no dividir iva_ves)
                        $total_item_usd = $base_usd + $iva_usd;

                        // Items
                        $arr_items = [];

                        // Item 1: Gravado
                        $arr_items[] = [
                            "NumeroLinea"            => "1",
                            "CodigoCIIU"             => "0198",
                            "CodigoPLU"              => "NCR-01",
                            "IndicadorBienoServicio" => "1",
                            "Descripcion"            => "DESCUENTO PRONTO PAGO (G)",
                            "Cantidad"               => "1.00",
                            "UnidadMedida"           => "UNI",
                            "PrecioUnitario"         => formatear($base_ves),
                            "PrecioItem"             => formatear($base_ves),
                            "CodigoImpuesto"         => "G",
                            "TasaIVA"                => "16.00",
                            "ValorIVA"               => formatear($iva_ves),
                            "ValorTotalItem"         => formatear($total_item_ves)
                        ];

                        // Item 2: Exento (si aplica)
                        $acumulado_exento_ves = 0.00;
                        $exento_usd           = 0.00;
                        
                            $acumulado_exento_ves = 0.00;
                            $exento_usd       = 0.00;
                    

                        // Totales VES
                        $subtotal_ves    = $base_ves + 0;
                        $total_final_ves = $subtotal_ves + $iva_ves;

                            // Totales USD
                                $subtotal_usd    = $base_usd + $exento_usd;
                                $total_final_usd = $subtotal_usd + $iva_usd;



            }

             // 4. Documento
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento"             => "02",
                            "NumeroDocumento"           => (string)$fact_num,
                            "TipoProveedor"             => null,
                            "TipoTransaccion"           => "02",
                            "SerieFacturaAfectada"      => "",
                            "NumeroFacturaAfectada"     => (string)$factura_afectada[0]->fact_num,
                            "FechaFacturaAfectada"      => date('d/m/Y', strtotime($factura_afectada[0]->fec_emis)),
                            "MontoFacturaAfectada"      => formatear($factura_afectada[0]->tot_neto),
                            "ComentarioFacturaAfectada" => $comentario,
                            "FechaEmision"              => $fecha_actual,
                            "FechaVencimiento"          => $fecha_actual,
                            "HoraEmision"               => $hora_actual,
                            "Anulado"                   => false,
                            "TipoDePago"                => "INMEDIATO",
                            "Serie"                     => "",
                            "Sucursal"                  => "",
                            "TipoDeVenta"               => "Interna",
                            "Moneda"                    => "VES"
                        ],
                        "Vendedor" => [
                            "Codigo"    => $pedido[0]->co_ven,
                            "Nombre"    => $pedido[0]->ven_des,
                            "NumCajero" => $pedido[0]->co_ven,
                        ],

                        "Comprador" => [
                            "TipoIdentificacion"   => substr(str_replace("-", "", $pedido[0]->rif), 0, 1),
                            "NumeroIdentificacion" => substr(str_replace("-", "", $pedido[0]->rif), 1),
                            "RazonSocial"          => $pedido[0]->cli_des,
                            "Direccion"            => $pedido[0]->direc1,
                            "Pais"                 => "VE",
                            "Telefono"             => [$pedido[0]->telefonos ?? "0000000"],
                            "Correo"               => [
                                $pedido[0]->email,
                                $pedido[0]->correo_vendedor
                            ]
                        ],
                        "Totales" => [
                            "NroItems"               => (string)count($arr_items),
                            "MontoGravadoTotal"      => formatear($base_ves),
                            "MontoExentoTotal"       => formatear($acumulado_exento_ves),
                            "Subtotal"               => formatear($subtotal_ves),
                            "TotalIVA"               => formatear($iva_ves),
                            "MontoTotalConIVA"       => formatear($total_final_ves),
                            "TotalAPagar"            => formatear($total_final_ves),
                            "TotalDescuento"         => "0.00",
                            "SubtotalAntesDescuento" => formatear($subtotal_ves),
                            "MontoEnLetras"          => "",
                            "ListaDescBonificacion"  => [
                                ["descDescuento" => "Sin descuento", "montoDescuento" => "0.00"]
                            ],
                            "ImpuestosSubtotal" => [
                                [
                                    "CodigoTotalImp"   => "G",
                                    "AlicuotaImp"      => "16.00",
                                    "BaseImponibleImp" => formatear($base_ves),
                                    "ValorTotalImp"    => formatear($iva_ves)  // base_ves × 16% ✓
                                ]
                            ],
                            "FormasPago" => [
                                [
                                    "Fecha"      => $fecha_actual,
                                    "Forma"      => "01",
                                    "Monto"      => formatear($total_final_ves),
                                    "Moneda"     => "VES",
                                    "TipoCambio" => "0.0000"
                                ]
                            ]
                        ],
                        "TotalesOtraMoneda" => [
                            "Moneda"                 => "USD",
                            "TipoCambio"             => formatear4($tasa_cambio),
                            "MontoGravadoTotal"      => formatear($base_usd),
                            "MontoExentoTotal"       => formatear($exento_usd),
                            "Subtotal"               => formatear($subtotal_usd),
                            "TotalIVA"               => formatear($iva_usd),
                            "MontoTotalConIVA"       => formatear($total_final_usd),
                            "TotalAPagar"            => formatear($total_final_usd),
                            "TotalDescuento"         => "0.00",
                            "SubtotalAntesDescuento" => formatear($subtotal_usd),
                            "MontoEnLetras"          => "",
                            "ImpuestosSubtotal" => [
                                [
                                    "CodigoTotalImp"   => "G",
                                    "AlicuotaImp"      => "16.00",
                                    "BaseImponibleImp" => formatear($base_usd),
                                    "ValorTotalImp"    => formatear($iva_usd)  // base_usd × 16% ✓
                                ]
                            ],
                            "FormasPago" => [
                                [
                                    "Fecha"      => $fecha_actual,
                                    "Forma"      => "01",
                                    "Monto"      => formatear($total_final_usd),
                                    "Moneda"     => "USD",
                                    "TipoCambio" => "1.0000"
                                ]
                            ]
                        ]
                    ],
                    "DetallesItems"     => $arr_items,
                    "DetallesRetencion" => null,
                    "Viajes"            => null,
                    "InfoAdicional"     => [],
                    "GuiaDespacho"      => null,
                    "Transporte"        => null,
                    "InfoAdicional" => [
                        ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                        ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                        ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
                    ],
                    "EsLote"            => null,
                    "EsMinimo"          => null
                ]
            ];
          
            file_put_contents('factura_nota_credito_debug_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT));
    
            // 3. Credenciales
            $api_user = API_USER_TFHKA;
            $api_pass = API_PASS_TFHKA;


            try {
                $api      = new TfhkaApiData($api_user, $api_pass);
                $token    = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);

                $resultado = $response->resultado ?? null;
                $codigo    = $response->codigo    ?? null;
                $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

                if ($resultado && !empty($resultado->numeroControl)) {
                    $numero_control = $resultado->numeroControl;
                    $objeto_factura = new DocumentosData();
                    $objeto_factura->setFacturaNotaCreditoAdmin($fact_num, $numero_control, 'FACT');
                    $link = $resultado->urlConsulta ?? null;
                    $objeto_factura->addDocumentoURL($fact_num, 'N/CR', $link, 0);
                    $status   = 'success';
                    $msgFinal = ($codigo == "201") ? "Documento Duplicado: Sincronizado correctamente." : "Documento procesado con éxito.";
                } else {
                    $status   = 'error';
                    $msgFinal = "No se recibió número de control: " . $mensaje;
                }

                $result = ['status' => $status, 'message' => $msgFinal, 'data' => $response];

            } catch (Exception $e) {
                $result = ['status' => 'error', 'message' => 'Error crítico: ' . $e->getMessage()];
            }

            header("Content-Type: application/json");
            echo json_encode($result);

        }



        // =====================================================


        
        if ($accion == 6) { // EMITIR NOTA DE DEBITO ADMINISTRATIVA

            // 1. Obtener IDs
            $fact_num             = isset($_POST['fact_num'])         ? $_POST['fact_num']         : 0;
            $factura_afectada_num = isset($_POST['factura_afectada']) ? $_POST['factura_afectada'] : 0;
            $comentario           = isset($_POST['comentario'])        ? $_POST['comentario']        : 'Descuento Pronto Pago';

         
            // 2. Consultar Datos
            $pedido_obj       = new FacturaData();
            $pedido           = $pedido_obj->GetFacturaClienteNotasDebito($fact_num);
            $factura_afectada = $pedido_obj->GetFacturaOriginal($factura_afectada_num);

            // 3. Montos — todos vienen en BOLÍVARES desde la BD
            // Se eliminó la condición $es_usd: factor siempre es 1


            $monto_excento_orig = floatval($pedido[0]->exento);
            $tot_bruto_orig     = floatval($pedido[0]->tot_bruto);
            $tot_iva_orig       = floatval($pedido[0]->iva);

            $tasa_cambio        = (isset($pedido[0]->tasa) && $pedido[0]->tasa > 0)
                                ? floatval($pedido[0]->tasa)
                                : 1.00;

            if (!function_exists('formatear')) {
                function formatear($num) { return number_format((float)$num, 2, '.', ''); }
            }
            if (!function_exists('formatear4')) {
                function formatear4($num) { return number_format((float)$num, 4, '.', ''); }
            }

            $fecha_actual = date('d/m/Y');
            $hora_actual  = date('h:i:s a');
        

            if(($tot_iva_orig>0.00 ) && ($monto_excento_orig>0.00)){
                                        
                                    // --- CÁLCULOS EN VES (los datos ya están en VES, factor = 1) ---
                            $base_ves       = round($tot_bruto_orig, 2);        // ya en VES
                            $iva_ves        = round($base_ves * 0.16, 2);       // IVA sobre base VES
                            $total_item_ves = $base_ves + $iva_ves;

                            // --- CÁLCULOS EN USD (dividimos VES / tasa) ---
                            $base_usd = round($base_ves / $tasa_cambio, 2);
                            $iva_usd  = round($base_usd * 0.16, 2);            // IVA sobre base USD (no dividir iva_ves)
                            $total_item_usd = $base_usd + $iva_usd;

                            // Items
                            $arr_items = [];

                            // Item 1: Gravado
                            $arr_items[] = [
                                "NumeroLinea"            => "1",
                                "CodigoCIIU"             => "0198",
                                "CodigoPLU"              => "NCR-01",
                                "IndicadorBienoServicio" => "1",
                                "Descripcion"            => "DIFERENCIAL CAMBIARIO (G)",
                                "Cantidad"               => "1.00",
                                "UnidadMedida"           => "UNI",
                                "PrecioUnitario"         => formatear($base_ves),
                                "PrecioItem"             => formatear($base_ves),
                                "CodigoImpuesto"         => "G",
                                "TasaIVA"                => "16.00",
                                "ValorIVA"               => formatear($iva_ves),
                                "ValorTotalItem"         => formatear($total_item_ves)
                            ];

                            // Item 2: Exento (si aplica)
                            $acumulado_exento_ves = 0.00;
                            $exento_usd           = 0.00;
                            if ($monto_excento_orig > 0) {
                                $exento_ves_item  = round($monto_excento_orig, 2);  // ya en VES
                                $acumulado_exento_ves = $exento_ves_item;
                                $exento_usd       = round($exento_ves_item / $tasa_cambio, 2);

                                $arr_items[] = [
                                    "NumeroLinea"            => "2",
                                    "CodigoCIIU"             => "0198",
                                    "CodigoPLU"              => "NCR-02",
                                    "IndicadorBienoServicio" => "1",
                                    "Descripcion"            => "DIFERENCIAL CAMBIARIO (E)",
                                    "Cantidad"               => "1.00",
                                    "UnidadMedida"           => "UNI",
                                    "PrecioUnitario"         => formatear($exento_ves_item),
                                    "PrecioItem"             => formatear($exento_ves_item),
                                    "CodigoImpuesto"         => "E",
                                    "TasaIVA"                => "0.00",
                                    "ValorIVA"               => "0.00",
                                    "ValorTotalItem"         => formatear($exento_ves_item)
                                ];
                            }

                            // Totales VES
                            $subtotal_ves    = $base_ves + $acumulado_exento_ves;
                            $total_final_ves = $subtotal_ves + $iva_ves;

                            // Totales USD
                                    $subtotal_usd    = $base_usd + $exento_usd;
                                    $total_final_usd = $subtotal_usd + $iva_usd;


            }elseif(($monto_excento_orig>0.00) && ($tot_iva_orig==0) ){

                $arr_items = [];
                $exento_ves_item      = round($monto_excento_orig, 2);
                $acumulado_exento_ves = $exento_ves_item;

               
                $base_ves       = 0.00;
                $iva_ves        = 0.00;
                $total_item_ves = $exento_ves_item;  // el total del item es solo el exento

                $subtotal_ves    = $acumulado_exento_ves;   // ✅ solo exento, sin duplicar
                $total_final_ves = $subtotal_ves;           // sin IVA

                $base_usd       = 0.00;
                $iva_usd        = 0.00;
                $exento_usd     = round($exento_ves_item / $tasa_cambio, 2);

                $subtotal_usd    = $exento_usd;
                $total_final_usd = $subtotal_usd;


                $arr_items[] = [
                    "NumeroLinea"            => "1",
                    "CodigoCIIU"             => "0198",
                    "CodigoPLU"              => "NCR-01",
                    "IndicadorBienoServicio" => "1",
                    "Descripcion"            => "DIFERENCIAL CAMBIARIO (E)",
                    "Cantidad"               => "1.00",
                    "UnidadMedida"           => "UNI",
                    "PrecioUnitario"         => formatear($exento_ves_item.".00"),
                    "PrecioItem"             => formatear($exento_ves_item.".00"),
                    "CodigoImpuesto"         => "E",
                    "TasaIVA"                => "0.00",
                    "ValorIVA"               => "0.00",
                    "ValorTotalItem"         => formatear($exento_ves_item.".00")
                ];
            
          

            }elseif(($tot_iva_orig>0.00)){
                      
                                     // --- CÁLCULOS EN VES (los datos ya están en VES, factor = 1) ---
                        $base_ves       = round($tot_bruto_orig, 2);        // ya en VES
                        $iva_ves        = round($base_ves * 0.16, 2);       // IVA sobre base VES
                        $total_item_ves = $base_ves + $iva_ves;

                        // --- CÁLCULOS EN USD (dividimos VES / tasa) ---
                        $base_usd = round($base_ves / $tasa_cambio, 2);
                        $iva_usd  = round($base_usd * 0.16, 2);            // IVA sobre base USD (no dividir iva_ves)
                        $total_item_usd = $base_usd + $iva_usd;

                        // Items
                        $arr_items = [];

                        // Item 1: Gravado
                        $arr_items[] = [
                            "NumeroLinea"            => "1",
                            "CodigoCIIU"             => "0198",
                            "CodigoPLU"              => "NCR-01",
                            "IndicadorBienoServicio" => "1",
                            "Descripcion"            => "DIFERENCIAL CAMBIARIO (G)",
                            "Cantidad"               => "1.00",
                            "UnidadMedida"           => "UNI",
                            "PrecioUnitario"         => formatear($base_ves),
                            "PrecioItem"             => formatear($base_ves),
                            "CodigoImpuesto"         => "G",
                            "TasaIVA"                => "16.00",
                            "ValorIVA"               => formatear($iva_ves),
                            "ValorTotalItem"         => formatear($total_item_ves)
                        ];

                        // Item 2: Exento (si aplica)
                        $acumulado_exento_ves = 0.00;
                        $exento_usd           = 0.00;
                        
                            $acumulado_exento_ves = 0.00;
                            $exento_usd       = 0.00;
                    

                        // Totales VES
                        $subtotal_ves    = $base_ves + 0;
                        $total_final_ves = $subtotal_ves + $iva_ves;

                            // Totales USD
                                $subtotal_usd    = $base_usd + $exento_usd;
                                $total_final_usd = $subtotal_usd + $iva_usd;



            }

             // 4. Documento
            $documento = [
                "documentoElectronico" => [
                    "Encabezado" => [
                        "IdentificacionDocumento" => [
                            "TipoDocumento"             => "03",
                            "NumeroDocumento"           => (string)$fact_num,
                            "TipoProveedor"             => null,
                            "TipoTransaccion"           => "02",
                            "SerieFacturaAfectada"      => "",
                            "NumeroFacturaAfectada"     => (string)$factura_afectada[0]->fact_num,
                            "FechaFacturaAfectada"      => date('d/m/Y', strtotime($factura_afectada[0]->fec_emis)),
                            "MontoFacturaAfectada"      => formatear($factura_afectada[0]->tot_neto),
                            "ComentarioFacturaAfectada" => $comentario,
                            "FechaEmision"              => $fecha_actual,
                            "FechaVencimiento"          => $fecha_actual,
                            "HoraEmision"               => $hora_actual,
                            "Anulado"                   => false,
                            "TipoDePago"                => "INMEDIATO",
                            "Serie"                     => "",
                            "Sucursal"                  => "",
                            "TipoDeVenta"               => "Interna",
                            "Moneda"                    => "VES"
                        ],
                        "Vendedor" => [
                            "Codigo"    => $pedido[0]->co_ven,
                            "Nombre"    => $pedido[0]->ven_des,
                            "NumCajero" => $pedido[0]->co_ven,
                        ],

                        "Comprador" => [
                            "TipoIdentificacion"   => substr(str_replace("-", "", $pedido[0]->rif), 0, 1),
                            "NumeroIdentificacion" => substr(str_replace("-", "", $pedido[0]->rif), 1),
                            "RazonSocial"          => $pedido[0]->cli_des,
                            "Direccion"            => $pedido[0]->direc1,
                            "Pais"                 => "VE",
                            "Telefono"             => [$pedido[0]->telefonos ?? "0000000"],
                            "Correo"               => [
                                $pedido[0]->email,
                                $pedido[0]->correo_vendedor
                            ]
                        ],
                        "Totales" => [
                            "NroItems"               => (string)count($arr_items),
                            "MontoGravadoTotal"      => formatear($base_ves),
                            "MontoExentoTotal"       => formatear($acumulado_exento_ves),
                            "Subtotal"               => formatear($subtotal_ves),
                            "TotalIVA"               => formatear($iva_ves),
                            "MontoTotalConIVA"       => formatear($total_final_ves),
                            "TotalAPagar"            => formatear($total_final_ves),
                            "TotalDescuento"         => "0.00",
                            "SubtotalAntesDescuento" => formatear($subtotal_ves),
                            "MontoEnLetras"          => "",
                            "ListaDescBonificacion"  => [
                                ["descDescuento" => "Sin descuento", "montoDescuento" => "0.00"]
                            ],
                            "ImpuestosSubtotal" => [
                                [
                                    "CodigoTotalImp"   => "G",
                                    "AlicuotaImp"      => "16.00",
                                    "BaseImponibleImp" => formatear($base_ves),
                                    "ValorTotalImp"    => formatear($iva_ves)  // base_ves × 16% ✓
                                ]
                            ],
                            "FormasPago" => [
                                [
                                    "Fecha"      => $fecha_actual,
                                    "Forma"      => "01",
                                    "Monto"      => formatear($total_final_ves),
                                    "Moneda"     => "VES",
                                    "TipoCambio" => "0.0000"
                                ]
                            ]
                        ],
                        "TotalesOtraMoneda" => [
                            "Moneda"                 => "USD",
                            "TipoCambio"             => formatear4($tasa_cambio),
                            "MontoGravadoTotal"      => formatear($base_usd),
                            "MontoExentoTotal"       => formatear($exento_usd),
                            "Subtotal"               => formatear($subtotal_usd),
                            "TotalIVA"               => formatear($iva_usd),
                            "MontoTotalConIVA"       => formatear($total_final_usd),
                            "TotalAPagar"            => formatear($total_final_usd),
                            "TotalDescuento"         => "0.00",
                            "SubtotalAntesDescuento" => formatear($subtotal_usd),
                            "MontoEnLetras"          => "",
                            "ImpuestosSubtotal" => [
                                [
                                    "CodigoTotalImp"   => "G",
                                    "AlicuotaImp"      => "16.00",
                                    "BaseImponibleImp" => formatear($base_usd),
                                    "ValorTotalImp"    => formatear($iva_usd)  // base_usd × 16% ✓
                                ]
                            ],
                            "FormasPago" => [
                                [
                                    "Fecha"      => $fecha_actual,
                                    "Forma"      => "01",
                                    "Monto"      => formatear($total_final_usd),
                                    "Moneda"     => "USD",
                                    "TipoCambio" => "1.0000"
                                ]
                            ]
                        ]
                    ],
                    "DetallesItems"     => $arr_items,
                    "DetallesRetencion" => null,
                    "Viajes"            => null,
                    "InfoAdicional"     => [],
                    "GuiaDespacho"      => null,
                    "Transporte"        => null,
                    "InfoAdicional" => [
                        ["campo" => "TransporteCliente",       "valor" => $pedido[0]->des_tran],
                        ["campo" => "ZonaCliente",             "valor" => $pedido[0]->zon_des],
                        ["campo" => "DireccionEntregaCliente", "valor" => $pedido[0]->ent_fact],
                    ],
                    "EsLote"            => null,
                    "EsMinimo"          => null
                ]
            ];
          
            file_put_contents('factura_nota_credito_debug_' . $fact_num . '.json', json_encode($documento, JSON_PRETTY_PRINT));
    
            // 3. Credenciales
            $api_user = API_USER_TFHKA;
            $api_pass = API_PASS_TFHKA;


            try {
                $api      = new TfhkaApiData($api_user, $api_pass);
                $token    = $api->obtenerToken();
                $response = $api->emitirFactura($token, $documento);

                $resultado = $response->resultado ?? null;
                $codigo    = $response->codigo    ?? null;
                $mensaje   = $response->mensaje   ?? 'Sin mensaje de respuesta';

                if ($resultado && !empty($resultado->numeroControl)) {
                    $numero_control = $resultado->numeroControl;
                    $objeto_factura = new DocumentosData();
                    $objeto_factura->setFacturaNotaDebitoAdmin($fact_num, $numero_control, 'FACT');
                    $link = $resultado->urlConsulta ?? null;
                    $objeto_factura->addDocumentoURL($fact_num, 'N/DB', $link, 0);
                    $status   = 'success';
                    $msgFinal = ($codigo == "201") ? "Documento Duplicado: Sincronizado correctamente." : "Documento procesado con éxito.";
                } else {
                    $status   = 'error';
                    $msgFinal = "No se recibió número de control: " . $mensaje;
                }

                $result = ['status' => $status, 'message' => $msgFinal, 'data' => $response];

            } catch (Exception $e) {
                $result = ['status' => 'error', 'message' => 'Error crítico: ' . $e->getMessage()];
            }

            header("Content-Type: application/json");
            echo json_encode($result);

        }

        


       
}

if ($tipo == 3) { // FACTURACIÓN ELECTRÓNICA TFHKA

    

        if ($accion == 1) { // ANULAR FACTURA 

                // 1. Obtener el ID de la factura a anular
                $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
                $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : "Sin motivo especificado";
                $tipo_documento = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : "tipo de documento";
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
                $api_user = "uolltyfnwhqn_tfhka";
                $api_pass = '4S+W4@@G.JNW';

                // 4. Datos para la anulación
                $serie = ""; // Si no usas series, enviar cadena vacía
               // $tipo_documento = "01"; // 01 = Factura
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
        
        if ($accion == 3) { // ANULAR NOTA DE DEBITO POR DEVOLUCION 

                // 1. Obtener el ID de la factura a anular
                $fact_num = isset($_POST['fact_num']) ? $_POST['fact_num'] : 0;
                $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : "Sin motivo especificado";
                $tipo_documento = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : "tipo de documento";
                //echo "Factura a anular: " . $fact_num . "\n"; // Debug ID
               // echo "Motivo: " . $motivo . "\n"; // Debug motivo
               // echo "Tipo de documento: " . $tipo_documento . "\n"; // Debug tipo_documento

                if ($fact_num == 0) {
                    echo json_encode(array('status' => 'error', 'message' => 'ID de factura no proporcionado'));
                    exit;
                }


           
                // 3. Credenciales
                $api_user = "uolltyfnwhqn_tfhka";
                $api_pass = '4S+W4@@G.JNW';

                // 4. Datos para la anulación
                $serie = ""; // Si no usas series, enviar cadena vacía
               // $tipo_documento = "01"; // 01 = Factura
                $numero_documento = $fact_num;

                        
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
        
        
        



}

if($tipo==4){      

        if($accion==1){
             if($datos==1){  
               $s = isset($_GET['s']) ? $_GET['s'] : 1; // 1: Pendientes, 2: Pagadas
                $data = new DocumentosData(); 
                $result=[];            
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataFacturas($s);
                        break;
                }                
                header("Content-Type: application/json");
                echo json_encode($result);
               
            } 
        }
        if($accion==2){
             if($datos==1){  
               $s = isset($_GET['s']) ? $_GET['s'] : 1; // 1: Pendientes, 2: Pagadas
                $data = new DocumentosData(); 
                $result=[];            
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataNotas($s);
                        break;
                }                
                header("Content-Type: application/json");
                echo json_encode($result);
               
            } 
        }
        if($accion==3){
             if($datos==1){  
               $s = isset($_GET['s']) ? $_GET['s'] : 1; // 1: Pendientes, 2: Pagadas
                $data = new DocumentosData(); 
                $result=[];            
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataNotasDevolciones($s);
                        break;
                }                
                header("Content-Type: application/json");
                echo json_encode($result);
               
            } 
        }

        if($accion==4){
             if($datos==1){  
               $s = isset($_GET['s']) ? $_GET['s'] : 1; // 1: Pendientes, 2: Pagadas
                $data = new DocumentosData(); 
                $result=[];            
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataNCRAdministrativas($s);
                        break;
                }                
                header("Content-Type: application/json");
                echo json_encode($result);
               
            } 
        }

        if($accion==5){
             if($datos==1){  
               $s = isset($_GET['s']) ? $_GET['s'] : 1; // 1: Pendientes, 2: Pagadas
                $data = new DocumentosData(); 
                $result=[];            
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $result = $data->getDataNDBAdministrativas($s);
                        break;
                }                
                header("Content-Type: application/json");
                echo json_encode($result);
               
            } 
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
                        $result = $data->getDataFacturasDocumentos($tipo_doc);
                        break;
                }
                
                header("Content-Type: application/json");
                echo json_encode($result);
                //var_dump($result);
            } 
        }


        if($accion==10){
            if($datos==1){ 
               $clase = $_GET['c'];     
               $tipo_doc =$_GET['tipo_doc'];      
                
               $data = new $clase(); 
               $result=[];
               //echo $filtro;
               switch($_SERVER["REQUEST_METHOD"]) {
                   case "GET":
                       $result = $data->getDataFacturasNotasCreditoDev($tipo_doc);
                       break;
               }
               
               header("Content-Type: application/json");
               echo json_encode($result);
               //var_dump($result);
           } 
        }

       if($accion==11){
            if($datos==1){ 
            $clase = $_GET['c'];     
            $tipo_doc =$_GET['tipo_doc'];      
                
            $data = new $clase(); 
            $result=[];
            //echo $filtro;
            switch($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $result = $data->getDataFacturasDocumentosNotas($tipo_doc);
                    break;
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            //var_dump($result);
            } 
        }


        
}


if ($tipo == 7) { // DESCARGAR DOCUMENTOS  

        if ($accion == 4) { // DESCARGAR DOCUMENTO
            
            // 1. Obtener parámetros del POST (JSON)
            $input = json_decode(file_get_contents('php://input'), true);
            
            $serie = isset($input['serie']) ? $input['serie'] : null;
            $tipoDocumento = isset($input['tipoDocumento']) ? $input['tipoDocumento'] : "01";
            $numeroDocumento = isset($input['numeroDocumento']) ? $input['numeroDocumento'] : "";
            $tipoArchivo = isset($input['tipoArchivo']) ? $input['tipoArchivo'] : "pdf";
            
            // Validaciones
            if (empty($numeroDocumento)) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Número de documento no proporcionado'
                ]);
                exit;
            }
            
            if (!preg_match('/^(01|02|03|04|05|06|07)$/', $tipoDocumento)) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Tipo de documento inválido'
                ]);
                exit;
            }
            
            // 2. Credenciales (mismas que en anulación)
            // 3. Credenciales
                $api_user = "uolltyfnwhqn_tfhka";
                $api_pass = '4S+W4@@G.JNW';
            
            // 3. Construir datos para la descarga
            $descarga_data = [
                "serie" => $serie,
                "tipoDocumento" => $tipoDocumento,
                "numeroDocumento" => $numeroDocumento,
                "tipoArchivo" => $tipoArchivo
            ];
            
            // Debug
            file_put_contents('descarga_' . $numeroDocumento . '.json', 
                json_encode($descarga_data, JSON_PRETTY_PRINT));
            
            try {
                // 4. Obtener token (mismo método que anulación)
                $api = new TfhkaApiData($api_user, $api_pass);
                $token = $api->obtenerToken();
                
                // 5. Llamar al endpoint de descarga
                $response = $api->descargarDocumento($token, $descarga_data);
                
                $result = [
                    'status' => 'success',
                    'message' => 'Documento descargado correctamente.',
                    'data' => $response
                ];
                
            } catch (Exception $e) {
                $result = [
                    'status' => 'error',
                    'message' => 'Error al descargar documento: ' . $e->getMessage()
                ];
            }
            
            header("Content-Type: application/json");
            echo json_encode($result);
            exit;
        }   

}


?>