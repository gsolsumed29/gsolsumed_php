  <!-- BEGIN: Content-->
  <?php
    $estatus  = isset($_GET['estatus']) ? $_GET['estatus'] : '0';
    if($estatus == 2){
        $leyenda = "Facturas por vencer en 2 días";
    }elseif($estatus == 3){
        $leyenda = "Facturas vencidas entre 1 y 3 días";
    }elseif($estatus == 4){
        $leyenda = "Facturas vencidas entre 4 y 10 días";
    }elseif($estatus == 5){
        $leyenda = "Facturas vencidas entre 11 o más días";
    }elseif($estatus == 6){
        $leyenda = "Facturas que vencen hoy";
    }
  ?>
  <div class="app-content content cuentasPorCobrar">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Cuentas </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Dasboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#"><?php echo $leyenda ?> </a>
                                    </li>
                                   
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-4 col-12">
                    <div class="mb-1 breadcrumb-right">
                        <!-- Botón de filtrar existente -->
                        <a class="btn btn-info waves-effect waves-float waves-light" data-bs-toggle='modal' data-bs-target='#modals-slide-in'>
                            <i data-feather='search'></i> Filtrar
                        </a>
                        
                    
                        
                        <a class="btn btn-success waves-effect waves-float waves-light cuentasPorCobrar" id="cuentasPorCobrar">
                            <i data-feather='refresh-cw'></i> Actualizar
                        </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                  
                </div>
                <input type="hidden" id="estatus" class="estatus" value='<?php echo $estatus ?>'>
               <input type="hidden" id="dataCuentasPorCobrar" class="dataCuentasPorCobrar" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-cuentas table">
                                <thead>
                                    <tr>
                                        <!-- Columna 0: Responsiva (DEBE ESTAR, aunque vacía) -->
                                        <th></th>
                                        
                                        <!-- Columna 1: ID Oculto -->
                                        <th></th>
                                        
                                        <!-- Columna 2: Código -->
                                        <th>Código</th>
                                        
                                        <!-- Columna 3: Cliente -->
                                        <th>Cliente</th>
                                        <!-- Columna 3: Cliente -->
                                        <th>Tipo</th>
                                        <!-- Columna 4: Rif -->
                                        <th>Rif</th>
                                        
                                        <!-- Columna 5: Responsable -->
                                        <th>Responsable</th>
                                        
                                        <!-- Columna 6: Teléfonos -->
                                        <th>Teléfonos</th>
                                        
                                        <!-- Columna 7: Saldo -->
                                        <th>Saldo</th>

                                          <!-- Columna 8: Saldo -->
                                        <th>Vendedor</th>
                                        
                                        <!-- Columna 9: Acciones -->
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
              
                                            <div class="modal fade facturas" id="modalDetalleFacturaInterna" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Cuentas por cobrar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" id="table-hover-row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                     
                                                                        <div class="card-body">
                                                                           
                                                                        </div>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover .table-dark text-center">
                                                                                <thead>
                                                                                    <tr> 
                                                                                        <th>#</th>
                                                                                        <th>N° Documento</th>
                                                                                        <th>Tipo Doc</th>
                                                                                        <th>Saldo</th>
                                                                                        <th>Fecha Emisión</th>
                                                                                        <th>Fecha Vcto</th>
                                                                                        <th>Dias vencidos</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="filaFactura">
                                                                                  
                                                                              
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-relief-primary" data-bs-dismiss="modal"><i data-feather='x-circle'></i> Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade facturasDetalles" id="sdsa" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title facturaNumero" id="exampleModalCenterTitle"> </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" id="table-hover-row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                     
                                                                        <div class="card-body">
                                                                           
                                                                        </div>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Codigo</th>
                                                                                        <th>Articulo</th>
                                                                                        <th>Cantidad</th>
                                                                                        <th>Precio</th>
                                                                                        <th>Neto</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="filaFacturaDetalles">
                                                                                  
                                                                              
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-relief-primary" data-bs-dismiss="modal"><i data-feather='x-circle'></i> Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>         

                                                            <!-- Modal to add new record -->
                                            <div class="modal modal-slide-in fade filtrar" id="modals-slide-in">
                                                <div class="modal-dialog sidebar-sm">
                                                    <form class="add-new-record modal-content pt-0">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                                        <div class="modal-header mb-1">
                                                            <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                                        </div>
                                                        <div class="modal-body flex-grow-1">     

                                                        <div class="mb-1">
                                                                <label class="form-label" for="basic-icon-default-date">Vendedor</label>
                                                                <div class="position-relative" data-select2-id="45">
                                                                <select class="select2  form-select border-0 shadow-none bg-transparent pe-0 comboVendedores" id="select2-basic">   
                                                                <option value="NO">Todos</option>                                        
                                                                </select>
                                                                </div>
                                                            </div>                                                       
                                                        
                                                        
                                                            <div class="mb-4">
                                                                <label class="form-label" for="basic-icon-default-date">Fecha</label>
                                                                <input type="text" id="fp-range" class="form-control flatpickr-range rango" placeholder="Seleccione Rango" />
                                                            </div>
                                                        
                                                        
                                                        
                                                            <button type="button" class="btn btn-relief-primary data-submit cargarCuentas me-1"> <i data-feather='search'></i> Consultar</button>
                                                            <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"><i data-feather='x-circle'></i>   Cancelar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>         

                                            <!-- NUEVO MODAL: Detalles del Cliente -->
                                            <div class="modal fade" id="modalDetallesCliente" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Información del Cliente</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless table-sm">
                                                                    <tbody>
                                                                        <tr><td><strong>Código:</strong></td><td id="detCoCli"></td></tr>
                                                                        <tr><td><strong>Cliente:</strong></td><td id="detCliDes"></td></tr>
                                                                        <tr><td><strong>RIF:</strong></td><td id="detRif"></td></tr>
                                                                        <tr><td><strong>Responsable:</strong></td><td id="detResponsable"></td></tr>
                                                                        <tr><td><strong>Teléfonos:</strong></td><td id="detTelefonos"></td></tr>
                                                                        <!-- Puedes agregar más campos si existen en tu JSON -->
                                                                        <tr><td><strong>Saldo:</strong></td><td id="detSaldo"></td></tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- NUEVO MODAL: Enviar Mensaje (WhatsApp/SMS) -->
                                            <div class="modal fade" id="modalEnviarMensaje" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Enviar Mensaje</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-1">
                                                                <label class="form-label">Para (Cliente)</label>
                                                                <input type="text" class="form-control" id="msgNombreCliente" readonly>
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label">Número Telefónico</label>
                                                                <input type="text" class="form-control" id="msgNumero">
                                                                <small class="text-muted">Asegúrese de incluir el código de país (ej: 58424...)</small>
                                                            </div>
                                                            <div class="mb-1">
                                                                <label class="form-label">Mensaje</label>
                                                                <textarea class="form-control" id="msgTexto" rows="4" placeholder="."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success" onclick="enviarWhatsApp()">
                                                                <i data-feather="message-square"></i> WhatsApp
                                                            </button>
                                                            <button type="button" class="btn btn-primary" id="btnSendSMS">
                                                               <i data-feather="smartphone"></i> <span class="btn-text">   Enviar SMS</span>
                                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                            </button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <!-- MODAL: Reporte de Llamada (Slide-in desde la derecha) -->
                                            <div class="modal modal-slide-in fade" id="modalReporteLlamada" tabindex="-1" aria-hidden="true">
                                                   <div class="modal-dialog sidebar-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header  mb-1">
                                                            <h5 class="modal-title">Reportar Llamada</h5>
                                                                  <!-- Información de factura con mayor retraso -->
                                                           

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                          <div class="modal-body flex-grow-1">     
                                                            <form id="formReporteLlamada">     
                                                                
                                                               <div class="mb-1">      
                                                                    <div class="alert alert-info mb-1" id="facturaInfo" >
                                                                    <strong>Factura con mayor retraso:</strong> 
                                                                </div>                                                                                      
                                                                </div>
                                                                                   
                                                                <div class="mb-1">      
                                                                        <label class="form-label">Cliente *</label>
                                                                        <input type="text" class="form-control" id="llamadaCliDes" readonly>                                                                   
                                                                </div>
                                                                <div class="mb-1">      
                                                                        <label class="form-label">Responsable *</label>
                                                                        <input type="text" class="form-control" id="llamadaResponsable" readonly>                                                                   
                                                                </div>

                                                          
                                                                 <div class="mb-1">
                                                                    <label class="form-label">Número Contactado</label>
                                                                    <select class="form-select" id="llamadaNumeroContactado">
                                                                        <option value="">Seleccione el número marcado</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label">Tipo de Llamada</label>
                                                                    <select class="form-select" id="llamadaTipo">
                                                                        <option value="GESTION_COBRO">Gestión de Cobro</option>
                                                                        <option value="RECORDATORIO">Recordatorio de Pago</option>
                                                                        <option value="NEGOCIACION">Negociación</option>
                                                                        <option value="CONFIRMACION">Confirmación de Datos</option>
                                                                        <option value="OTRO">Otro</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label">Estado de la Llamada</label>
                                                                    <select class="form-select" id="llamadaEstado">
                                                                        <option value="REALIZADA">Realizada - Contacto Exitoso</option>
                                                                        <option value="NO_CONTESTA">No Contesta</option>
                                                                        <option value="OCUPADO">Ocupado</option>
                                                                        <option value="NUMERO_INCORRECTO">Número Incorrecto</option>
                                                                        <option value="BUZON">Buzón de Voz</option>
                                                                        <option value="PROMETE_PAGO">Promete Pago</option>
                                                                        <option value="RECHAZADA">Rechazada/No quiere pagar</option>
                                                                    </select>
                                                                </div>
                                                               <div class="mb-1" id="compromisoDiv" style="display: none;">
                                                                    <label class="form-label">Compromiso de Pago</label>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control" id="llamadaCompromisoMonto" placeholder="Monto comprometido">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control flatpickr-date" id="llamadaCompromisoFecha" placeholder="Fecha compromiso">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                 <div class="mb-1">
                                                                        <label class="form-label">Observaciones / Notas</label>
                                                                        <textarea class="form-control" id="llamadaObservaciones" rows="4" placeholder="Detalle de la conversación..."></textarea>
                                                                        <small class="text-muted">Máximo 500 caracteres</small>
                                                                        <div class="text-end"><span id="obsCounter">0/500</span></div>
                                                                    </div>
                                                                    
                                                                    <div class="mb-1">
                                                                        <label class="form-label">¿Requiere seguimiento?</label>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" id="llamadaRequiereSeguimiento">
                                                                            <label class="form-check-label" for="llamadaRequiereSeguimiento">
                                                                                Sí, programar recordatorio
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <div class="mb-1" id="seguimientoFechaDiv" style="display: none;">
                                                                                        <label class="form-label">Fecha de seguimiento</label>
                                                                                        <input type="text" class="form-control flatpickr-date" id="llamadaSeguimientoFecha">
                                                                                    </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i data-feather="x"></i> Cancelar
                                                            </button>
                                                            <button type="button" class="btn btn-primary" onclick="guardarReporteLlamada()">
                                                                <i data-feather="save"></i> Guardar Reporte
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


        

            </div>
        </div>
    </div>
    <!-- END: Content-->