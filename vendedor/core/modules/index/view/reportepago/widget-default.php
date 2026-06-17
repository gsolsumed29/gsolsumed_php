
 
    <div class="app-content content " id="PagosRealizados">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Reportar pagos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=cobros">Cobros</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:">reportar</span> 
                                    </li>
                                </ol>
                            </div>
                          
                        </div>
                    </div>
                </div>
                 <div class="content-header-right text-md-end col-md-3 col-12 d-md-block">
                    <div class="mb-1 breadcrumb-right">
                     
                    </div>
                </div>        
            </div>      
             <input class="dataPagosRealizados" data-cliente="<?php echo $_GET['facturas_cliente_2'] ?>" type="hidden" id="dataPagosRealizados" value="">
            <div class="content-body pagosRealizados">

            

                <section class="invoice-edit-wrapper">
                    <div class="row invoice-edit">
                        <!-- Invoice Edit Left starts -->
                        <div class="col-xl-12 col-md-12 col-12">
                                <div class="form-section">
                                         <h3><?php echo $_GET['facturas_cliente_codigo'] . '- ' . $_GET['facturas_cliente_2']  ?></h3>
                                    <div class="accordion" id="resumenAcordeon">
                                        <div class="accordion-item border">
                                            <h2 class="accordion-header" id="headingResumen">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResumen" aria-expanded="false" aria-controls="collapseResumen">
                                                    <i data-feather="pie-chart" class="accordion-icon me-2"></i>
                                                    Resumen de Pagos
                                                </button>
                                            </h2>
                                            <div id="collapseResumen" class="accordion-collapse collapse" aria-labelledby="headingResumen" data-bs-parent="#resumenAcordeon">
                                                <div class="accordion-body">
                                                    <div class="status-display">
                                                        <div class="row g-3">
                                                            <!-- Tarjeta Total Adeudado -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="status-card adeudado">
                                                                    <div class="status-header">
                                                                        <div class="status-icon">
                                                                            <i data-feather='tag'></i>
                                                                        </div>
                                                                        <span class="status-title">Total Adeudado</span>
                                                                    </div>
                                                                    <div class="status-value" id="totalAdeudado">
                                                                        $<?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Tarjeta Total Pagado -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="status-card pagado">
                                                                    <div class="status-header">
                                                                        <div class="status-icon">
                                                                        <i data-feather='check-circle'></i>
                                                                        </div>
                                                                        <span class="status-title">Total Pagado</span>
                                                                    </div>
                                                                    <div class="status-value" id="totalPagado">$0.00</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Tarjeta Saldo Restante -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="status-card restante">
                                                                    <div class="status-header">
                                                                        <div class="status-icon">
                                                                            <i data-feather='credit-card'></i>
                                                                        </div>
                                                                        <span class="status-title">Saldo Restante</span>
                                                                    </div>
                                                                    <div class="status-value" id="saldoRestante">
                                                                        $<?php echo number_format($_GET['facturas_saldo'], 2, ',', '.') ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <button class="btn btn-custom btn-warning-custom" id="btnModalAgregarPagos" data-bs-toggle="modal" data-bs-target="#modalPagoFacturas">
                                                <i class="fas fa-plus"></i> Agregar Pago
                                            </button>
                                            <button class="btn btn-custom btn-success-custom ms-2 btnConfirmarPago" id="btnConfirmarPago">
                                                <i class="fas fa-check"></i> Confirmar Pago
                                            </button>
                                        </div>
                                        <a href="index.php?view=cobros" class="btn btn-custom btn-danger-custom">
                                            <i class="fas fa-arrow-left"></i> Volver
                                        </a>
                                    </div>
                                </div>
                        </div>
                        <!-- Invoice Edit Left ends -->

                     
                    </div>

                 
                 
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade modalPagoFacturas modalPagoFacturas_reporte" id="modalPagoFacturas" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Detalles del pago</h1>
                
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
                                <td class="text-info fw-bold" id ="tasa_cambio" data-tasa="<?php echo $_SESSION['tasa']?>"><?php echo number_format($_SESSION['tasa'], 2, '.', '') ?></td>
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
                            <option value="EF">EFECTIVO</option>
                            <option value="DEP">DEPOSITO</option>                                                           
                                                                   
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
                     <p class="fw-bolder">Para separar las referencias, se debe separar con comas(,).</p>
            
                       <!-- <input type="text" id="basic-icon-default-salary" class="form-control dt-salary facturas_referencia" id="facturas_referencia" name ="facturas_referencia" aria-label="$12000" />-->
                     <div class="input-group input-group-aligned">
                                <input type="text" class="form-control facturas_referencia" id="facturas_referencia" name ="facturas_referencia"  aria-describedby="REF: 123456798">
                                <button class="btn btn-outline-primary btnBuscarReferencia" id="btnBuscarReferencia" type="button">
                                    <i data-feather="search"></i>
                                </button>
                            </div>
                    </div>
                    
                    <div class="col-12 col-md-6 caja" id="caja" style="display:none">
                        <label class="form-label" for="basic-icon-default-date">Caja *</label>                                               
                        <select class="select2 form-select facturas_caja" id="facturas_caja" aria-hidden="true">
                            <option value="NO">Seleccionar</option>                                                                                                     
                        </select>                                                   
                    </div>                      
                  

                    <div class="col-12 col-md-6 monto montoAbonoBs" id="monto" style="display:none">
                        <label class="form-label" for="pesos">Monto abono Bolívares (BS.D) *</label>
                        <input class="form-control facturas_monto_bs money-bs" type="text" id="pesos" disabled placeholder="Ingrese cantidad en BS.D">
                    </div>
                    
                    <div class="col-12 col-md-6 monto montoAbonoUSD" id="monto" style="display:none">
                        <label class="form-label" for="dollars">Monto abono Dólares (USD) *</label>
                        <input class="form-control facturas_monto money-usd" type="text" id="dollars" disabled placeholder="Ingrese cantidad en $">
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

                                        <!-- <<< INICIO: BLOQUE DE FRASES PREDEFINIDAS EN ACORDEÓN >>> -->
                        <div class="col-12 col-md-12">
                            <div class="accordion" id="frasesAcordeon">
                                <div class="accordion-item border">
                                    <h2 class="accordion-header" id="headingFrases">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFrases" aria-expanded="false" aria-controls="collapseFrases">
                                            <i data-feather="chevron-down" class="accordion-icon me-2"></i>
                                            Frases rápidas (Haz clic para agregar)
                                        </button>
                                    </h2>
                                    <div id="collapseFrases" class="accordion-collapse collapse" aria-labelledby="headingFrases" data-bs-parent="#frasesAcordeon">
                                        <div class="accordion-body p-2">
                                            <div class="frases-predefinidas-container p-2 border rounded bg-light">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <!-- He eliminado draggable="true" ya que no se usa -->
                                                    <span class="badge bg-primary frase-predefinida" style="cursor: pointer !important;">APLICAR 5% DE DESCUENTO POR PAGO A TIEMPO.</span>
                                                    <span class="badge bg-info frase-predefinida"  style="cursor: pointer !important;">APLICAR 10% DE DESCUENTO POR PAGO A TIEMPO.</span>
                                                    <span class="badge bg-success frase-predefinida"  style="cursor: pointer !important;">APLICAR 15% DE DESCUENTO POR PAGO A TIEMPO.</span>
                                                    <span class="badge bg-warning frase-predefinida"  style="cursor: pointer !important;">APLICAR 20% DE DESCUENTO POR PAGO A TIEMPO.</span>
                                                    <span class="badge bg-secondary frase-predefinida"  style="cursor: pointer !important;">APLICAR GIF CARD DE REGALO.</span>
                                                    <span class="badge bg-dark frase-predefinida"  style="cursor: pointer !important;">APLICAR NOTA DE CRÉDITO.</span>
                                                    <span class="badge bg-danger frase-predefinida"  style="cursor: pointer !important;">APLICAR SALDO A FAVOR.</span>
                                                    <span class="badge bg-primary frase-predefinida"  style="cursor: pointer !important;">SE ENVIA RETENCIÓN POR CORREO.</span>
                                                    <span class="badge bg-secondary frase-predefinida"  style="cursor: pointer !important;">EMITIR NOTA DE DÉBITO POR DIFERENCIAL CAMBIARIO.</span>
                                                    <span class="badge bg-info frase-predefinida"  style="cursor: pointer !important;">EMITIR NOTA DE CREDITO  DEL 15% DE DESCUENTO POR PAGO A TIEMPO.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <<< FIN: BLOQUE DE FRASES PREDEFINIDAS EN ACORDEÓN >>> -->

                        <!-- Tu textarea de observación sigue igual -->
                        <div class="col-12 col-md-12 fecha" id="fecha">
                            <label class="form-label" for="basic-icon-default-date">Observación *</label>                                               
                            <textarea class="form-control facturas_observacion" rows="2" id="facturas_observacion" name="facturas_observacion" placeholder="Haz clic en una frase para reemplazar el contenido..."></textarea>                                           
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


