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
                                                        <div class="detail-amt subtotal"></div>
                                                    </li>                                                    
                                                    <li class="price-detail">
                                                        <div class="detail-title">Impuesto</div>
                                                        <div class="detail-amt impuesto"></div>
                                                    </li>                                                   
                                                   
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title detail-total">Total</div>
                                                        <div class="detail-amt fw-bolder text-success total">total</div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-primary w-100 mb-75 btn-next place-order">Siguiente</button>
                                                <button type="button" class="btn btn-danger w-100  mb-75 btn-next place-order anularPedidoCarrito">Anular Pedido</button>
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
                                                <label class="form-label" for="select2-basic">Cliente</label>
                                                <select class="select2 form-select comboClientes" id="select2-basic-comboClientes">
                                                        <option value="0">Seleccione cliente</option>
                                                </select>
                                                
                                          
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-2">
                                                    <label class="form-label" cfor="checkout-number">Rif:</label>
                                                    <input type="text" id="rif" class="form-control rif" name="rif" placeholder="" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">

                                            <div class="mb-2">
                                            <div class="form-floating mb-0">
                                                <textarea data-length="55" class="form-control char-textarea direccion" id="textarea-counter" rows="3" placeholder="Counter" style="height: 100px" disabled></textarea>
                                                <label for="textarea-counter">Dirección:</label>
                                            </div>
                                            <small class="textarea-counter-value float-end"><span class="char-count">0</span> / 55 </small>
                                            </div>
                                            
                                               
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-2">
                                                    <label class="form-label" cfor="checkout-landmark">Telefonos:</label>
                                                    <input type="text" id="telefonos" class="form-control telefonos" name="telefonos" placeholder="" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-2">
                                                    <label class="form-label" cfor="checkout-landmark">Email:</label>
                                                    <input type="email" id="email" class="form-control email" name="email" placeholder="" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                               
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
                                                        <div class="detail-amt subtotal2"></div>
                                                    </li>                                                    
                                                    <li class="price-detail">
                                                        <div class="detail-title">Impuesto</div>
                                                        <div class="detail-amt impuesto2"></div>
                                                    </li>                                                   
                                                 
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title detail-total">Total</div>
                                                        <div class="detail-amt fw-bolder text-success total2">total</div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-primary w-100 mb-75 btn-next place-order">Siguiente</button>
                                                <button type="button" class="btn btn-danger w-100  mb-75 btn-next place-order anularPedidoCarrito">Anular Pedido</button>
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
                                                <select class="select2 form-select comboFormasPago" id="select2-basic-comboFormasPago">
                                                        <option value="0">Seleccione forma</option>
                                                </select>
                                                
                                                <hr class="my-2" />
                                              
                                                <label class="form-label" for="select2-basic">Tipo de Facturaciòn  </label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fiscal" id="fiscal" value="FISCAL" checked />
                                                    <label class="form-check-label" for="inlineRadio1">Fiscal</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fiscal" id="fiscal" value="NO FISCAL" />
                                                    <label class="form-check-label" for="inlineRadio2">No fiscal</label>
                                                </div>
                                          
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
                                                        <div class="detail-amt subtotal3"></div>
                                                    </li>                                                    
                                                    <li class="price-detail">
                                                        <div class="detail-title">Impuesto</div>
                                                        <div class="detail-amt impuesto3"></div>
                                                    </li>                                                   
                                                 
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div class="detail-title detail-total">Total</div>
                                                        <div class="detail-amt fw-bolder text-success total3">total</div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-primary w-100 mb-75 btn-next place-order registrarPedido">Finalizar Pedido</button>
                                                <button type="button" class="btn btn-danger w-100  mb-75 btn-next place-order anularPedidoCarrito">Anular Pedido</button>
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