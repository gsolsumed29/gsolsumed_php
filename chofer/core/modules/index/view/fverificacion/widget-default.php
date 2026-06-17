    <!-- BEGIN: Content-->
    <?php         

        // Sanitizar los parámetros GET
        $status = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
        $fact_num = filter_input(INPUT_GET, 'fact_num', FILTER_SANITIZE_NUMBER_INT);
        $fac_num_text = $_GET['fact_num_text'];
      $objeto_factura = New FacturaData();          
      $result = $objeto_factura->GetFacturaDespacho($fact_num,$status);     
    ?> 
    <div class="app-content content " id="datosFacturaChequear">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Factura </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                 
                                  
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="invoice-preview-wrapper">
                    <div class="row invoice-preview" >
                     <!-- Invoice -->
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                        <div>
                                            <input type="hidden" class="fact_num" id="fact_num" value="<?php echo $fact_num; ?>" >
                                            <h4 class="card-text mb-25">Factura N° : <?php  echo   $fac_num_text ?></4>
                                           
                                           
                                        </div>
                                        
                                       <div class="invoice-number-date mt-md-0 mt-2 d-flex justify-content-end">
                                       <div class="search-container">
                                        <input type="text" 
                                            id="buscarProductoInput" 
                                            class="search-input" 
                                            placeholder="Buscar por código..." 
                                            
                                            style="cursor: pointer;" />
                                        <button class="btn btn-primary search-btn" type="button">
                                            <i data-feather='search'></i> Buscar
                                        </button>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            <!-- Invoice Description starts -->
                            <div class="table-responsive px-3">
                                <table class="table mb-2" id="tablaDespacho">
                                    <thead>
                                        <tr> 
                                            <th class="py-2 align-middle">#</th>
                                            <th class="py-2 align-middle">Código</th>
                                            <th class="py-2 align-middle">Descripción</th>
                                            <th class="py-2 align-middle text-center">Marca</th>
                                            <th class="py-2 align-middle text-center">Facturado</th>
                                            <th class="py-2 align-middle text-center">Despacho</th>
                                        </tr>
                                    </thead>
                                    <tbody id="filaFacturaDetalles">
                                                                     
                                    </tbody>
                                </table>
                            </div>

                            
                       

                            <!-- Invoice Note starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="fw-bold"></span>
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Note ends -->
                        </div>
                    </div>
                    <!-- /Invoice -->


               <!-- Invoice Edit Right starts -->
         <div class="content-header-right col-12">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="row align-items-center g-3">
                        <!-- Selector de preparadores -->
                        <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        
                            <select class="form-select preparador-select" id="co_preparador"> 
                                <option value="" disabled selected>Seleccionar preparador</option>
                                <option value="">-- Todos los preparadores --</option>
                                <option value="CARLOS CORDERO - 14.335.022">CARLOS CORDERO - 14.335.022</option>
                                <option value="DAVID LINARES - 25.894.766">DAVID LINARES - 25.894.766</option>
                                <option value="FRANCISCO DELGADO - 19.105.405">FRANCISCO DELGADO - 19.105.405</option>
                                <option value="FRANCISCO NIETO - 19.106.048">FRANCISCO NIETO - 19.106.048</option>
                                <option value="GABRIEL DUGARTE - 28.204.975">GABRIEL DUGARTE - 28.204.975</option>
                                <option value="GUSTAVO SARMIENTO - 18.950.566">GUSTAVO SARMIENTO - 18.950.566</option>
                                <option value="IVAN TIMAURE - 25.570.502">IVAN TIMAURE - 25.570.502</option>
                                <option value="JESUS OCANTO - 26.904.745">JESUS OCANTO - 26.904.745</option>
                                <option value="JOHAN JIMENEZ - 18.862.591">JOHAN JIMENEZ - 18.862.591</option>
                                <option value="JOSE MENDOZA - 30.196.147">JOSE MENDOZA - 30.196.147</option>
                                <option value="LUIS HERNANDEZ - 22.186.961">LUIS HERNANDEZ - 22.186.961</option>
                                <option value="MANUEL BLANCO - 32.260.208">MANUEL BLANCO - 32.260.208</option>
                                <option value="OMAR LEON - 12.025.986">OMAR LEON - 12.025.986</option>  
                                
                                <option value="EMERSON CARRILLO - 25.149.669">EMERSON CARRILLO - 25.149.669</option>
                                <option value="GERARDO CORDERO - 9.612.869">GERARDO CORDERO - 9.612.869</option>  

                                <option value="DARWIN ESCALONA- 17.227.687">DARWIN ESCALONA- 17.227.687</option>
                                <option value="RANDARD PINTO - 16.001.234">RANDARD PINTO - 16.001.234</option>  

                                <option value="JEAN SUAREZ- 15.004.889">JEAN SUAREZ- 15.004.889</option>
                                <option value="DANYER VARGAS - 20.923.215">DANYER VARGAS - 20.923.215</option>  

                                
                            </select>
                        </div>
                    
                        <!-- Contador de items -->
                       <!-- <div class="col-xl-4 col-lg-5 col-md-6 col-12">
                        
                            <div id="contador-items" class="d-flex align-items-center justify-content-center p-1 border rounded bg-light">
                                <i class="bi bi-box-seam me-2 text-primary"></i>
                                <span id="item-count" class="fw-bold">0</span> items
                            </div>
                        </div> -->

                            <!-- Botón de volver -->
                        <div class="col-xl-2 col-lg-3 col-md-6 col-6">
                            <div class="d-grid gap-2">
                                <a href="./" class="btn btn-danger d-flex align-items-center justify-content-center">
                                    <i data-feather='chevron-left'></i> Volver
                                </a>
                            </div>
                        </div>
                

                        <!-- Botón de confirmación -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success d-flex align-items-center btnEnviarDespacho justify-content-center" id="btnEnviarDespacho" disabled>
                                    <i data-feather='check-circle'></i>     
                                </button>
                            </div>
                        </div>

                    
                     
                    </div>
                </div>
            </div>
        </div>
        <!-- Invoice Edit Right ends -->
                                                <!-- Invoice Edit Right ends -->
                        <!-- /Invoice Actions -->
                    </div>
                </section>

               

              

            </div>
        </div>
    </div>
<!-- Teclado Virtual Personalizado -->
<div id="customKeyboard" class="custom-keyboard" style="display: none;">
    <div class="keyboard-container">
        <div class="keyboard-header">
            <span class="keyboard-title" id="keyboardTitle">Teclado de Cantidades</span>
            <button class="btn btn-sm btn-outline-secondary" onclick="ocultarTeclado()">
                X <!-- Texto simple en lugar de icono -->
            </button>
        </div>
        
        <!-- Teclado para Búsqueda -->
        <div id="keyboardSearch" class="keyboard-mode">
             <div class="keyboard-row">
                <button class="keyboard-key" data-value="1">1</button>
                <button class="keyboard-key" data-value="2">2</button>
                <button class="keyboard-key" data-value="3">3</button>
            </div>
            <div class="keyboard-row">
                <button class="keyboard-key" data-value="4">4</button>
                <button class="keyboard-key" data-value="5">5</button>
                <button class="keyboard-key" data-value="6">6</button>
            </div>
            <div class="keyboard-row">
                <button class="keyboard-key" data-value="7">7</button>
                <button class="keyboard-key" data-value="8">8</button>
                <button class="keyboard-key" data-value="9">9</button>
            </div>
            <div class="keyboard-row">
                
             
                <button class="keyboard-key" id="keyClearSearch">C</button>
                   <button class="keyboard-key" data-value="0">0</button>
                <button class="keyboard-key btn-success" id="keySearchEnter">BUSCAR</button>
            </div>
        </div>

        <!-- Teclado para Cantidades -->
        <div id="keyboardQuantity" class="keyboard-mode" style="display: none;">
            <div class="keyboard-row">
                <button class="keyboard-key" data-value="1">1</button>
                <button class="keyboard-key" data-value="2">2</button>
                <button class="keyboard-key" data-value="3">3</button>
            </div>
            <div class="keyboard-row">
                <button class="keyboard-key" data-value="4">4</button>
                <button class="keyboard-key" data-value="5">5</button>
                <button class="keyboard-key" data-value="6">6</button>
            </div>
            <div class="keyboard-row">
                <button class="keyboard-key" data-value="7">7</button>
                <button class="keyboard-key" data-value="8">8</button>
                <button class="keyboard-key" data-value="9">9</button>
            </div>
            <div class="keyboard-row">
                <button class="keyboard-key quick-action" data-action="clear">C</button>
                <button class="keyboard-key" data-value="0">0</button>
                <button class="keyboard-key" id="keyBackspaceQuantity">⌫</button>
            </div>
            <div class="keyboard-row">
                <button class="keyboard-key quick-action btn-max" data-action="max">MÁX</button>
                <button class="keyboard-key quick-action btn-half" data-action="half">MITAD</button>
                <button class="keyboard-key btn-success" id="keyQuantityEnter">LISTO</button>
            </div>
        </div>
    </div>
</div>


 
    <!-- END: Content-->