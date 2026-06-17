  <!-- BEGIN: Content-->
    <div class="app-content content m_adelantos ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Promotores </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=caducidad">Caducidad</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Listado
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                <div class="row match-height">
                     <!-- Developer Meetup Card -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                                </div>
                                <div class="card-body">
                                  
                                          
                                            <select class="select2 form-select comboClientesCaducidad" id="select2-basic-comboClientesCaducidad">
                                                        <option value="0">Seleccione cliente</option>
                                            </select>
                                                
                                    
                                </div>
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-8 col-12">
                        <input class="dataCaducidad" type="hidden" id="dataCaducidad" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="datatables-basic-caducidad table" id="facturas">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                       
                                                        <th>Nº Inventario</th>
                                                        <th>Articulo</th>
                                                        <th>Fecha Emision</th>
                                                        <th>Tipo</th>
                                                        <th>Estatus</th>
                                                        <th>Co_cli</th>
                                                        <th></th>
                                                   
                                                                           
                                                        
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal to add new record -->
                                <div class="modal modal-slide-in fade modalPagoFacturas" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Datos</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                              
                                                <div class="mb-1 d-none">
                                                    <label class="form-label" for="basic-icon-default-post">Codigo cliente</label>
                                                    <input type="text" id="codigo_cliente_caducidad" class="form-control codigo_cliente_caducidad"  aria-label="codigo_cliente_caducidad" disabled/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Cliente</label>
                                                    <input type="text" id="caducidad_cliente" class="form-control caducidad_cliente"  aria-label="caducidad_cliente" disabled/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-email">Tipo de inventario</label>
                                                    <select class="form-select tipo_inventario" id="tipo_inventario" name="tipo_inventario">                                                                                   
                                                        <option value="1">Inventario</option>    
                                                        <option value="2">Devolución</option>                                                                                               
                                                    </select>
                                                </div>     
                                 
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Articulo</label>
                                                    <select class="select2 form-select comboArticulosCaducidad" id="select2-basic-comboArticulosCaducidad" name="comboArticulosCaducidad">
                                                        <option value="0">Seleccione Articulo</option>
                                                    </select>                                                
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Cantidad</label>
                                                    <div class="input-group input-group-merge mb-2">
                                                       
                                                        <input type="number" class="form-control caducidad_cantidad"   id="caducidad_cantidad" aria-label="caducidad_cantidad" >
                                                      
                                                    </div>
                                                </div>


                                                <div class="mb-1 d-none">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha elaboracion</label>
                                                    <input type="text" id="fp-default" class="form-control flatpickr-basic fecha_elab flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                </div>
                                                
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha vencimiento</label>
                                                    <input type="text" id="fp-default" class="form-control flatpickr-basic fecha_venc flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                </div>
                                               

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit AgregarInventario me-1" ><i data-feather='save'></i> Guardar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='slash'></i> Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal modal-slide-in fade modalInventario" id="modals-slide-in">
                                    <div class="modal-dialog sidebar-sm">
                                        <form class="add-new-record modal-content pt-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                            <div class="modal-header mb-1">
                                                <h5 class="modal-title" id="exampleModalLabel">Datos</h5>
                                            </div>
                                            <div class="modal-body flex-grow-1">                                              
                                                <div class="mb-1 d-none">
                                                    <label class="form-label" for="basic-icon-default-post">Codigo inventario</label>
                                                    <input type="text" id="codigo_inventario" class="form-control codigo_inventario"  aria-label="codigo_inventario" disabled/>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-email">Tipo de inventario</label>
                                                    <select class="form-select tipo_inventario_editar" id="tipo_inventario_editar" name="tipo_inventario_editar">                                                                                   
                                                        <option value="1">Inventario</option>    
                                                        <option value="2">Devolución</option>                                                                                               
                                                    </select>
                                                </div>     
                                 
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Articulo</label>
                                                    <select class="select2 form-select comboArticulosInventario" id="select2-basic-comboArticulosInventario">
                                                       
                                                    </select>                                                
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-post">Cantidad</label>
                                                    <div class="input-group input-group-merge mb-2">
                                                       
                                                        <input type="number" class="form-control inventario_cantidad"   id="inventario_cantidad" aria-label="inventario_cantidad" >
                                                      
                                                    </div>
                                                </div>                                             
                                                
                                                <div class="mb-1">
                                                    <label class="form-label" for="basic-icon-default-date">Fecha vencimiento</label>
                                                    <input type="text" id="fp-default" class="form-control flatpickr-basic fecha_venc_inventario flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                </div>
                                               

                                              
                                                <button type="button" class="btn btn-relief-primary data-submit editarInventario me-1"><i data-feather='save'></i> Editar</button>
                                                <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='slash'></i> Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                            <!--/ Basic table -->
                        </div>
                        <!--/ Company Table Card -->

                       
                     
              

                    </div>

                
                   
                </section>
              
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->