<!-- BEGIN: Content-->
<div class="app-content content generadorEtiquetas">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Generador de Etiquetas</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Despacho</a></li>
                                <li class="breadcrumb-item active">Generador de Etiquetas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
           <div class="row">
                  
                </div>
               <input type="hidden" id="dataDespachosEmpaquetar" class="dataDespachosEmpaquetar" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-facturas table">
                                    <thead>
                                        <tr> <th></th>        
                                           
                                            <th></th>                                           
                                            <th></th> 
                                            <th></th>                   
                                            <th></th>
                                            <th></th>                                        
                                            <th></th>  
                                            <th></th>                                          
                                            <th></th>   
                                            <th></th>            <th></th>               <th></th>             
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->
            </section>

            <!-- Modal 1: Configurar Paquetes -->
            <div class="modal fade" id="modalConfigurarPaquete" tabindex="-1" aria-labelledby="modalConfigurarPaqueteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalConfigurarPaqueteLabel">Configurar Paquetes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="infoFactura" class="form-label">Factura Seleccionada:</label>
                                <p id="infoFactura" class="fw-bold"></p>
                                <p id="infoFactura_cliente" class="fw-bold"></p>
                            </div>

                            <div class="">
                                <label for="numPaquetes" class="form-label">Número de Paquetes</label>
                                <input type="number" class="form-control" id="numPaquetes" min="1" value="1">
                                <small class="text-muted">Especifique en cuántos paquetes se distribuyó la mercancía de esta factura.</small>
                            </div>

                            <div class="">
                                <label for="despachado" class="form-label">Emisor de etiqueta</label>
                                    <select class="form-select despachado" id="despachado"> 
                                            <option value="NO"  selected>Seleccionar emisor</option>
                                            <option value="01">CARLOS CORDERO - 14.335.022</option>
                                            <option value="02">CARLOS PERAZA - 20.540.775</option>
                                            <option value="03">DANYER VARGAS - 20.923.215</option>
                                            <option value="04">DAVID LINARES - 25.894.766</option>
                                            <option value="05">DARWIN ESCALONA - 17.227.687</option>
                                            <option value="22">DEIBI VARGAS - 20.922.790</option>  
                                            <option value="06">EMERSON CARRILLO - 25.149.669</option>
                                            <option value="07">FRANCISCO DELGADO - 19.105.405</option>
                                            <option value="08">FRANCISCO NIETO - 19.106.048</option>
                                            <option value="09">FRANCOI AMARO - 11.784.811</option>
                                            <option value="10">GABRIEL DUGARTE - 28.204.975</option>
                                            <option value="11">GERARDO CORDERO - 9.612.869</option>
                                            <option value="12">GUSTAVO SARMIENTO - 18.950.566</option>
                                            <option value="13">IVAN TIMAURE - 25.570.502</option>
                                            <option value="14">JEAN SUAREZ - 15.004.889</option>
                                            <option value="15">JESUS OCANTO - 26.904.745</option>
                                            <option value="16">JOHAN JIMENEZ - 18.862.591</option>
                                            <option value="17">JOSE MENDOZA - 30.196.147</option>
                                            <option value="18">LUIS HERNANDEZ - 22.186.961</option>
                                            <option value="19">MANUEL BLANCO - 32.260.208</option>
                                            <option value="20">OMAR LEON - 12.025.986</option>
                                            <option value="21">RANDARD PINTO - 16.001.234</option>                                            
                                    </select>
                                <small class="text-muted">Especifique cual será el emisor de estas etiquetas.</small>
                            </div>




                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="btnGenerarPreview"> Vista Previa</button>
                        </div>
                    </div>
                </div>
            </div>



            
  <!-- Modal 2: Vista Previa de Notas de Entrega -->
<div class="modal fade" id="modalPreviewEtiqueta" tabindex="-1" aria-labelledby="modalPreviewEtiquetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-papel modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content papel-contenido">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPreviewEtiquetaLabel">Vista Previa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contenedorEtiquetas">
                <!-- Las notas de entrega se generarán aquí dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnImprimirEtiquetasPrint">
                    <i data-feather="printer"></i> Imprimir(s)
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="loteIdActual" value="">

    </div>
</div>
<!-- END: Content-->

<!-- Modal Ficha Factura -->
<div class="modal fade" id="modalFichaFactura" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Información de la Factura</h6>
                        <p><strong>Número:</strong> <span id="ficha-numero-factura"></span></p>
                        <p><strong>Fecha de Chequeo:</strong> <span id="ficha-fecha-chequeo"></span></p>
                        <p><strong>Estatus:</strong> <span id="ficha-estatus"></span></p>
                        <p><strong>Preparado por:</strong> <span id="ficha-preparado-por"></span></p>
                        <p><strong>Verificado por:</strong> <span id="ficha-verificado-por"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Información del Cliente</h6>
                        <p><strong>Nombre:</strong> <span id="ficha-nombre-cliente"></span></p>
                        <p><strong>Código:</strong> <span id="ficha-codigo-cliente"></span></p>
                        <p><strong>Dirección:</strong> <span id="ficha-direccion"></span></p>
                        <p><strong>Ciudad:</strong> <span id="ficha-ciudad"></span></p>
                        <p><strong>Zona:</strong> <span id="ficha-zona"></span></p>
                        <p><strong>Código Postal:</strong> <span id="ficha-zip"></span></p>
                        <p><strong>Teléfonos:</strong> <span id="ficha-telefonos"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
               
            </div>
        </div>
    </div>
</div>




                                 <!-- Modal to add new record -->
                                 <div class="modal modal-slide-in fade" id="modalBuscarDespacho">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Criterios de búsqueda</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                                  
                                            
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Verificador</label>
                                                    <div class="position-relative" data-select2-id="45">
                                                    <select class="select2  form-select border-0 shadow-none bg-transparent pe-0 comboVerificadores" id="comboVerificadores">   
                                                        <option value="NO">Todos</option>                                        
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                                    <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                                </div>
                                                   
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                                <button type="button" class="btn btn-relief-primary buscarVerificaciones me-1"> <i data-feather='search'></i> Consultar</button>


                                            </div>
                                        </form>
                                    </div>
                                </div>

