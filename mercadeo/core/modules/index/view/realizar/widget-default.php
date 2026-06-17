    <!-- BEGIN: Content-->
    <div class="app-content content ecommerce-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Pedido</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=pedido">Pedido</a>
                                    </li>
                                    <li class="breadcrumb-item active">Completar Pedido
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="content-body">
                
                <div class="bs-stepper checkout-tab-steps carritoLleno" style="display:none">
                    <!-- Wizard starts -->
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#step-cart" role="tab" id="step-cart-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">
                                    <i data-feather="shopping-cart" class="font-medium-3"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Carrito</span>
                                    <span class="bs-stepper-subtitle">Articulos</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#step-address" role="tab" id="step-address-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">
                                    <i data-feather="home" class="font-medium-3"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Cliente</span>
                                    <span class="bs-stepper-subtitle">Datos del cliente</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#step-payment" role="tab" id="step-payment-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">
                                    <i data-feather="credit-card" class="font-medium-3"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Pagos</span>
                                    <span class="bs-stepper-subtitle">Datos del pago y otros</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!-- Wizard ends -->

                    <div class="bs-stepper-content">
                        <!-- Checkout Place order starts -->
                        <div id="step-cart" class="content" role="tabpanel" aria-labelledby="step-cart-trigger">
                            <div id="place-order" class="list-view product-checkout">
                                <!-- Checkout Place Order Left starts -->
                                <section  class="grid-view ">
                                <div class="checkout-items ">   
                                    <div class="row carritoItems">                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination pagination-cart justify-content-center mt-2">
                                                   
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </section>
                                
                                <section>
                                <div class="checkout-options">
                                    <div class="card">
                                        <div class="card-body">
                                            <label class="section-label form-label mb-1">Nota de entrega</label>
                                           
                                            <div class="price-details detallesFactura">
                                                <h6 class="price-title">Detalles</h6>
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title">Total de articulos</div>
                                                        <div class="detail-amt totalArticulos text-info"></div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div class="detail-title">Sub Total</div>
                                                        <div class="detail-amt subtotal">0</div>
                                                    </li>                                                    
                                                    <li class="price-detail">
                                                        <div class="detail-title">Impuesto</div>
                                                        <div class="detail-amt impuesto">0</div>
                                                    </li>                                                   
                                                    <li class="price-detail">
                                                        <div class="detail-title">Descuento</div>
                                                        <div class="detail-amt descuento">0</div>
                                                    </li>    
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title detail-total">Total</div>
                                                        <div class="detail-amt fw-bolder text-success total">0</div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-info w-100 mb-75 btn-next place-order">Siguiente  <i data-feather='arrow-right-circle'></i></button>
                                                <button type="button" class="btn btn-danger w-100  mb-75 btn-next place-order anularPedidoCarrito"><i data-feather='x-circle'></i> Anular Pedido</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Checkout Place Order Right ends -->
                                </div>
                                </section>
                              
                                
                                    
                               
                 
                            </div>                                    
                        </div>
                        <!-- Checkout Customer Address Starts -->
                        <div id="step-address" class="content" role="tabpanel" aria-labelledby="step-address-trigger">
                            <form id="checkout-address" class="list-view product-checkout">
                                <!-- Checkout Customer Address Left starts -->
                                <div class="card">
                                    <div class="card-header flex-column align-items-start">
                                        <h4 class="card-title">Datos del cliente</h4>
                                        <p class="card-text text-muted mt-25">Identificacion y direcciónes</p>
                                    </div>
                                    <div class="card-body">
                                       <div class="row">                                            
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-2">
                                                    <label class="form-label" cfor="checkout-number">Nombre :</label>
                                                    <input type="text" class="form-control txtcli_des" name="txtcli_des" id ="txtcli_des" disabled  />
                                                    <input type="hidden" name ="cli_des" class="form-control cli_des"  id ="cli_des" name="cli_des"   />
                                                </div>
                                            </div>

                                             <div class="col-md-6 col-sm-12">
                                                <div class="mb-2">
                                                    <label class="form-label" cfor="checkout-number">Rif :</label>
                                                    <input type="text" class="form-control txtco_cli" name="txtco_cli"  disabled   id ="txtco_cli"  />
                                                    <input type="hidden" name ="co_cli" class="form-control co_cli" name="co_cli"    id ="co_cli" />
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- Checkout Customer Address Left ends -->

                                <div class="checkout-options">
                                    <div class="card">
                                        <div class="card-body">
                                            <label class="section-label form-label mb-1">Nota de entrega</label>
                                           
                                            <div class="price-details detallesFactura">
                                                <h6 class="price-title">Detalles</h6>
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title">Total de articulos</div>
                                                        <div class="detail-amt totalArticulos2 text-info"></div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div class="detail-title">Sub Total</div>
                                                        <div class="detail-amt subtotal2">0</div>
                                                    </li>                                                    
                                                    <li class="price-detail">
                                                        <div class="detail-title">Impuesto</div>
                                                        <div class="detail-amt impuesto2">0</div>
                                                    </li>  
                                                    <li class="price-detail">
                                                        <div class="detail-title">Descuento</div>
                                                        <div class="detail-amt descuento2">0</div>
                                                    </li>                                                     
                                                 
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title detail-total">Total</div>
                                                        <div class="detail-amt fw-bolder text-success total2">0</div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-info w-100 mb-75 btn-next place-order">Siguiente <i data-feather='arrow-right-circle'></i></button>
                                                <button type="button" class="btn btn-danger w-100  mb-75 btn-next place-order anularPedidoCarrito"><i data-feather='x-circle'></i> Anular Pedido</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Checkout Place Order Right ends -->
                                </div>
                            </form>
                            
                        </div>


                        <div id="step-payment" class="content" role="tabpanel" aria-labelledby="step-payment-trigger">
                            <form id="checkout-payment" class="list-view product-checkout" onsubmit="return false;">
                                <div class="payment-type">
                                   <div class="card">
                                        <div class="card-header flex-column align-items-start">
                                            <h4 class="card-title">Pago y más</h4>
                                            <p class="card-text text-muted mt-25">Lea cuidadosamente y elija los datos</p>
                                        </div>
                                        <div class="card-body">
                                           
                                                <label class="form-label" for="select2-basic">Transporte</label>
                                                <select class="select2 form-select comboTransporte" id="select2-basic-comboTransporte">
                                                        <option value="0">Seleccione transporte</option>
                                                </select>
                                          
                                          
                                                <hr class="my-2" />
                                                <label class="form-label" for="select2-basic">Forma de Pago</label>
                                                <select class="select2 form-select comboFormasPago" id="select2-basic-comboFormasPago" disabled>
                                                     
                                                </select>
                                              
                                                
                                                <hr class="my-2" />
                                              <?php 
                                                $tipoFacturacion=0;
                                                if($_SESSION['cliente_facturacion']==1){
                                                        $tipoFacturacion ="<FISCAL>";
                                                }else{
                                                        $tipoFacturacion ="<NOTA DE DESPACHO>";
                                                }
                                              ?>
                                                <input type="hidden" name ="tipo_precio_descuento" class="form-control tipo_precio_descuento" name="tipo_precio_descuento"   value ="<?php echo $_SESSION['tipo_precio']; ?>"/>
                                                  <input type="hidden" name ="tipo_facturacion_descuento" class="form-control tipo_facturacion_descuento" name="tipo_facturacion_descuento"   value ="<?php echo $_SESSION['cliente_facturacion']; ?>"/>
                                                <label class="form-label" for="select2-basic">Tipo de Facturación  </label>
                                                    <input type="text" class="form-control txtfactura" name="txtfactura"  disabled   value ="<?php echo $tipoFacturacion;   ?>"/>
                                                    <input type="hidden" name ="factura" class="form-control factura" name="factura"   value ="<?php echo $_SESSION['cliente_facturacion']; ?>"/>
                                                <div class ="d-none">
                                                <hr class="my-2" />
                                                    <label class="form-label" for="basic-icon-default-email">Tipo de pago</label>
                                                <select class="form-select mont_comi" id="mont_comi" name="mont_comi">    
                                                    <option value="NO">Seleccione</option>                                           
                                                    <option value="1" selected>Dolares americanos ($)</option>    
                                                    <option value="2">Bolivares (BS.D)</option>   
                                                                                        
                                                </select>
                                                </div>
                                                <hr class="my-2" />                                             
                                                    <label class="form-label" for="select2-basic">Observación  </label>

                                               
                                                    <textarea data-length="50" class="form-control char-textarea observacion" id="textarea-counter" rows="3" placeholder="Detalles del pedido" style="height: 100px"></textarea>
                                                    <small class="textarea-counter-value float-end"><span class="char-count">0</span> / 50 </small>
                                               
                                                   
                                              
                                                  
                                              
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="amount-payable checkout-options">
                                     <div class="card">
                                        <div class="card-body">
                                            <label class="section-label form-label mb-1">Nota de entrega</label>
                                           
                                            <div class="price-details detallesFactura">
                                                <h6 class="price-title">Detalles</h6>
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title">Total de articulos</div>
                                                        <div class="detail-amt totalArticulos3 text-info"></div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div class="detail-title">Sub Total</div>
                                                        <div class="detail-amt subtotal3">0</div>
                                                    </li>                                                    
                                                    <li class="price-detail">
                                                        <div class="detail-title">Impuesto</div>
                                                        <div class="detail-amt impuesto3">0</div>
                                                    </li>  
                                                    <li class="price-detail">
                                                        <div class="detail-title">Descuento</div>
                                                        <div class="detail-amt descuento3">0</div>
                                                    </li>                                                               
                                                 
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title detail-total">Total</div>
                                                        <div class="detail-amt fw-bolder text-success total3">0</div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-primary w-100 mb-75 btn-next place-order btnRegistrarPedido">Finalizar Pedido <i data-feather='save'></i></button>
                                                <button type="button" class="btn btn-danger w-100  mb-75 btn-next place-order anularPedidoCarrito"><i data-feather='x-circle'></i> Anular Pedido</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- </div> -->
                       </div>

                             
                              
                     
                    </div>
                </div>
                </div>

                <div class="row match-height carritoVacio" style="display:none">
                    <!-- Congratulations Card -->
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-congratulations">
                            <div class="card-body text-center">
                               
                              
                                <div class="avatar avatar-xl bg-info shadow">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award font-large-1"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-1 text-white">Lo Sentimos,</h1>
                                    <p class="card-text m-auto w-75">
                                        Ya no posees <strong>Articulos</strong> listados en tu carrito de pedidos
                                    </p>
                                    <a class="btn-icon btn btn-success" href="index.php?view=pedido">Volver a pedir</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Congratulations Card -->

                  
                </div>

                  
                                    
            </div>
        </div>
    </div>
    <!-- END: Content-->