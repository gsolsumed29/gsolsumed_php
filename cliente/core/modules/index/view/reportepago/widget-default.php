
 <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
        <div class="col-md-12 col-lg-10">
            <div class="row row-cols-1">
                <div class="overflow-hidden d-slider1 ">
                    <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                        <div class="card-body">
                            <div class="progress-widget">
                                <div id="circle-progress-01" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="90" data-type="percent">
                                <svg class="card-slie-arrow icon-24" width="24"  viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                </svg>
                                </div>
                                <div class="progress-detail">
                                <p  class="mb-2">Saldo</p>
                                <h4 class="counter" id="totalAdeudado" >    $<?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                        <div class="card-body">
                            <div class="progress-widget">
                                <div id="circle-progress-02" class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                </svg>
                                </div>
                                <div class="progress-detail">
                                <p  class="mb-2">Reportado</p>
                                <h4 class="counter" id="totalPagado">$0,00</h4>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                        <div class="card-body">
                            <div class="progress-widget">
                                <div id="circle-progress-03" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                </svg>
                                </div>
                                <div class="progress-detail">
                                <p  class="mb-2">Restante</p>
                                <h4 class="counter" id="saldoRestante">$<?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                    </li>
                  
                    </ul>
                  
                </div>
            </div>
        </div>
        <div class="col-xl-2"  data-aos="fade-up" data-aos-delay="100">
                <div class="card">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-itmes-center">
                        <div>
                            <div class="p-3 rounded ">
                               <a href="">
                                   <svg fill="#1daa61" class="icon-46" width="46"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 915.066 915.067" xml:space="preserve" transform="matrix(1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="1.830132"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M71.733,461.546c8.3,17.1,31.9,19.1,42.9,3.5l92-129.9c11.2-15.8,0.9-37.8-18.4-39.399l-25-2c17.7-37.2,42.6-70.8,73.5-99 c44-40.101,98.6-67.4,158-79c85.3-16.601,172,0.2,244.4,47.3c60.2,39.2,104.4,95.6,127.301,161.4 c8.1,23.199,32,36.899,56.1,32.199l1-0.2c29.5-5.8,47.2-36.3,37.2-64.699c-12.2-34.601-29-67.4-50.2-97.9 c-31.1-44.3-70-82-116-112s-96.6-50.6-150.5-61.5c-55.8-11.2-112.701-11.399-169-0.399c-77.5,15.199-148.9,50.899-206.5,103.399 c-49.3,44.9-87,100.5-110,162.101l-31.5-2.5c-19.3-1.5-32.9,18.399-24.5,35.8L71.733,461.546z"></path> <path d="M800.333,449.946l-92,129.9c-11.2,15.8-0.899,37.8,18.4,39.4l25,2c-17.7,37.199-42.601,70.8-73.5,99 c-44,40.1-98.601,67.399-158,79c-85.3,16.6-172-0.2-244.401-47.301c-60.2-39.199-104.4-95.6-127.3-161.399 c-8.1-23.2-32-36.9-56.1-32.2l-1,0.2c-29.5,5.8-47.2,36.3-37.2,64.7c12.2,34.6,29,67.399,50.2,97.899 c31.1,44.4,70.1,82.2,116.1,112.101c46,30,96.6,50.6,150.5,61.5c28.2,5.699,56.7,8.5,85.2,8.5c27.9,0,55.9-2.7,83.8-8.2 c77.5-15.101,149-50.9,206.6-103.3c49.301-44.9,86.9-100.5,109.9-162.101l31.5,2.5c19.3,1.5,32.9-18.399,24.5-35.8l-69.2-142.8 C835.033,436.446,811.333,434.446,800.333,449.946z"></path> <path d="M456.533,171.546c-19.3,0-35,15.7-35,35v46.1h-82.1c-19.301,0-35,15.7-35,35v168.2c0,19.3,15.699,35,35,35h82.1v98.2 h-67.8c-19.3,0-35,15.7-35,35s15.7,35,35,35h67.8v46.1c0,19.3,15.7,35,35,35c19.3,0,35-15.7,35-35v-46.1h78.5 c19.3,0,35-15.7,35-35v-168.2c0-19.3-15.7-35-35-35h-78.5v-98.2h63.8c19.3,0,35-15.699,35-35c0-19.3-15.7-35-35-35h-63.8v-46.1 C491.533,187.247,475.934,171.546,456.533,171.546z M421.533,420.846h-47.1v-98.2h47.1V420.846z M535.133,490.846v98.2h-43.6 v-98.2H535.133z"></path> </g> </g> </g></svg>
                                                                             
                                </a>       
                            </div>
                        </div>
                        <div>
                            <h3 id ="textChangeRate">0</h3>
                            <p id ="textChangeRateDay" style="font-size : 10px" >0</p>
                       
                    </div>
                    </div>
                </div>
                </div>
             </div> 
                        <div class="col-xl-12 col-md-12 col-12">
                                <div class="form-section">
                                         <h3 class="d-none"><?php echo $_GET['facturas_cliente_codigo'] . '- ' . $_GET['facturas_cliente_2']  ?></h3>
                                      <input class="dataPagosRealizados" data-cliente="<?php echo $_GET['facturas_cliente_2'] ?>" type="hidden" id="dataPagosRealizados" value="">
                                        <p id= "PagosRealizados"></p>
                                </div>

                                <div class="form-section">
                                    <section id="basic-datatable">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                        
                                                    <table class="dataTablesPagosRealizados table" id="dataTablesPagosRealizados">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>                                                       
                                                                <th></th>
                                                                <th></th>                                                     
                                                                <th></th>                                                    
                                                                <th></th>  
                                                                <th></th> 
                                                                <th></th>   
                                                                <th></th>                                                                                   
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </section>  
                                </div>   
                              <div class="form-section">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                        <div>
                                            <button class="btn btn-custom btn-warning" id="btnModalAgregarPagos" data-bs-toggle="modal" data-bs-target="#modalPagoFacturas">
                                                <i class="fas fa-plus"></i> Agregar Pago
                                            </button>
                                            <button class="btn btn-custom btn-success ms-2 btnConfirmarPago" id="btnConfirmarPago">
                                                <i class="fas fa-check"></i> Confirmar Pago
                                            </button>
                                        </div>
                                        <a href="index.php?view=facturas" class="btn btn-custom btn-danger">
                                            <i class="fas fa-arrow-left"></i> Volver
                                        </a>
                                    </div>
                                </div>
                        </div>
                        <!-- Invoice Edit Left ends -->

                     
        </div>
      </div>




<div class="modal fade modalPagoFacturas modalPagoFacturas_reporte" id="modalPagoFacturas" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
               
                
                <div class="table-responsive ">
                  <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Documentos</th>
                                <th>Total USD</th>
                                <th class="">Total BS.D</th>
                                <th>Tasa BCV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold" id="facturas_cancelar_text" data-facturas="<?php echo $_GET['facturas_cancelar'] ?>"></td>
                                <td class="text-success fw-bold" id="facturas_saldo_text" data-facturasu ="<?php echo $_GET['facturas_saldo'] ?>" ><?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?></td>
                                <td class="text-primary fw-bold" id="facturas_saldo_text_bsd" data-facturasb="<?php echo $_GET['facturas_saldo']*$_SESSION['tasa'] ?>" ></td>
                                <td class="text-danger fw-bold" id ="tasa_cambio" data-tasa="<?php echo $_SESSION['tasa']?>"><?php echo number_format($_SESSION['tasa'], 2, '.', '') ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-hover d-none" id="tablaRetenciones">
                        <thead class="table-primary">
                            <tr>
                                <th>Documentos</th>
                                <th>Numero Retención</th>
                                <th class="">Total BS.D</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Las filas se generarán dinámicamente -->
                        </tbody>
                    </table>


                </div>
                
                <form id="addNewAddressForm" class="row gy-1 gx-2">
                    <input type="hidden" class="form-control facturas_cancelar" id="facturas_cancelar" value="<?php echo $_GET['facturas_cancelar'] ?>" />
                    <input type="hidden" id="facturas_cliente_codigo" class="form-control facturas_cliente_codigo" value="<?php echo $_GET['facturas_cliente_codigo'] ?>"/>
                    <input type="hidden" class="form-control facturas_cliente" id="facturas_cliente" value="<?php echo htmlspecialchars($_GET['facturas_cliente_2'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" class="form-control facturas_saldo" id="facturas_saldo" value="<?php echo $_GET['facturas_saldo'] ?>">
                    <input type="hidden" class="form-control facturas_saldo_bs" id="facturas_saldo_bs" value="<?php echo $_GET['facturas_saldo_bs'] ?>">
                    
                    
                    <div class="col-12 col-md-6 fecha" id="fecha">
                        <label class="form-label" for="basic-icon-default-date">Fecha de pago *</label>                                               
                        <input type="text" id="fp-default" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">                                                   
                    </div>

                    
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalAddressFirstName">Método de pago *</label>
                        <select class="select2 form-select facturas_metodo" id="select2-basic-1" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                       
                            <option value="DEP">Transferencia</option>                                                           
                                                                   
                        </select>
                    </div>
                    
                    <div class="col-12 col-md-6 banco" id="banco" style="display:none">
                        <label class="form-label" for="modalAddressLastName">Banco *</label>
                        <select class="select2 form-select facturas_banco" id="facturas_banco" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                               
                        </select>
                    </div>
                    
                    <div class="col-12 col-md-6 cuenta" id="cuenta" style="display:none">
                        <label class="form-label" for="modalAddressCountry">Cuenta *</label>
                        <select class="select2 form-select facturas_cuenta" id="facturas_cuenta" name="facturas_cuenta" disabled aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                              
                        </select>
                    </div>

              
                    <div class="col-12 col-md-12 referencia" id="referencia" style="display:none">                    
                     
                    
                    <label class="form-label" for="modalAddressAddress1">Referencia * </label>
                     <p class="fw-bolder">Debe escribir la referencia en su totalidad.</p>
            
                       <!-- <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_referencia" id="facturas_referencia" name ="facturas_referencia" aria-label="$12000" />-->
                     <div class="input-group input-group-aligned">
                                <input type="text" class="form-control facturas_referencia" id="facturas_referencia" name ="facturas_referencia"  aria-describedby="REF: 123456798">
                                <button class="btn btn btn-primary btnBuscarReferencia" id="btnBuscarReferencia" type="button">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                </svg>                            
                                </button>
                            </div>
                    </div>
                    
                    <div class="col-12 col-md-6 caja" id="caja" style="display:none">
                        <label class="form-label" for="basic-icon-default-date">Caja *</label>                                               
                        <select class="select2 form-select facturas_caja" id="facturas_caja" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                                     
                        </select>                                                   
                    </div>                      
                  

            
                    <div class="col-12 col-md-6 monto montoAbonoUSD" id="monto" style="display:none">
                        <label class="form-label" for="dollars">Monto abono Dólares (USD) *</label>
                        <input class="form-control facturas_monto money-usd text-success fw-bold" type="text" id="dollars" disabled placeholder="Ingrese cantidad en $">
                    </div>


                    <div class="col-12 col-md-6 monto montoAbonoBs" id="monto" style="display:none">
                        <label class="form-label" for="pesos">Monto abono Bolívares (BS.D) *</label>
                        <input class="form-control facturas_monto_bs money-bs text-primary fw-bold" type="text" id="pesos" disabled placeholder="Ingrese cantidad en BS.D">
                    </div>
                    
                                    
                    <div class="col-12 col-md-6 monto d-none" id="monto">
                        <label class="form-label" for="basic-icon-default-date">Deuda en BS.D *</label>       
                        <input class="form-control monto_calculado_bs" id="monto_calculado_bs" type="text" value="" disabled>            
                    </div>
                    
                    <div class="col-12 col-md-6 monto d-none" id="monto">
                        <label class="form-label" for="basic-icon-default-date">Deuda en USD *</label>       
                        <input class="form-control monto_calculado" id="monto_calculado" data-saldo="<?php echo $_GET['facturas_saldo'] ?>" type="text" value="<?php echo $_GET['facturas_saldo'] ?>" disabled>  
                       
                    </div>                                
                    <input class="form-control monto_calculado_retenciones d-none" id="monto_calculado_retenciones" data-saldor="" type="text">                              
                   
                    <div class="col-12 col-md-12 fecha" id="fecha">
                        <div class="upload-section">
                            <div class="drop-zone" id="drop-zone">                             
                                <p id="drop-zone-text">Arrastra tus archivos aquí o haz clic para seleccionar</p>
                                <div class="browse-btn">Seleccionar archivos</div>
                            </div>                            
                            <input type="file" id="file-input" class="file-input facturas_documento"  accept=".jpg,.jpeg,.png,.gif,.pdf" multiple>    
                        </div>                        
                        <div id="preview-section" class="preview-section hidden">                          
                            <div id="selected-files" class="selected-files"></div>
                        </div>                        
                    </div>

                    
                        <!-- Tu textarea de observación sigue igual -->
                        <div class="col-12 col-md-12 fecha" id="fecha">
                            <label class="form-label" for="basic-icon-default-date">Observación *</label>                                               
                            <textarea class="form-control facturas_observacion" rows="2" id="facturas_observacion" name="facturas_observacion" placeholder="Escribe alguna observación"></textarea>                                           
                        </div>
               
                    
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-1 mt-2 btnPagarFacturas"> <i data-feather='save'></i>  Guardar</button>
                        <button type="reset" class="btn btn-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather='x-circle'></i>   Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




