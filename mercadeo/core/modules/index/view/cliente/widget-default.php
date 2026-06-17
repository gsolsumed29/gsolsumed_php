    <!-- BEGIN: Content-->
    <div class="app-content content  m_visitas" id="perfilCLiente">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Cliente</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=visitas">Clientes</a>
                                    </li>
                                    <li class="breadcrumb-item active"> Ficha del cliente
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                       
                    
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-2">
                            <!-- account -->
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <i data-feather="user" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Identificación</span>
                                </a>
                            </li>
                            <!--
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?view=cliente_1">
                                    <i data-feather="lock" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Security</span>
                                </a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?view=cliente_2">
                                    <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Billings &amp; Plans</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?view=cliente_3">
                                    <i data-feather="bell" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Notifications</span>
                                </a>
                            </li>
                            -->
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?view=cliente_1&co_cli=<?php  echo $_GET['co_cli']?>">
                                    <i data-feather="users" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Encuesta</span>

                                  
                                </a>
                            </li>
                                <li class="nav-item">
                                <a class="nav-link" href="index.php?view=cliente_2&co_cli=<?php  echo $_GET['co_cli']?>">
                                    <i data-feather="file-text" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Visita</span>
                                </a>
                            </li>
                        </ul>

             <div class="card">
                <div class="card-header bg-primary border-bottom py-2">
                    <h4 class="card-title text-white mb-0">Perfil del Cliente</h4>
                </div>
                <div class="card-body p-1">
                    <form class="validate-form">
                        <!-- Información Empresarial -->
                        <div class="mb-1">
                            <h5 class="text-primary mb-1"><i data-feather="briefcase" class="me-1"></i> Información Empresarial</h5>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Razón Social</label>
                                    <input type="hidden" id="co_cli" value="<?php echo $_GET['co_cli']?>">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control form-control-sm" id="cli_des" name="cli_des" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">RIF</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i data-feather='hash'></i></span>
                                        <input type="text" class="form-control form-control-sm" id="cli_rif" name="cli_rif" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="mb-1">
                            <h5 class="text-primary mb-1"><i data-feather="mail" class="me-1"></i> Contacto</h5>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Correo <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i data-feather="mail"></i></span>
                                        <input type="email" class="form-control form-control-sm" id="cli_email" name="cli_email" placeholder="correo@empresa.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i data-feather="phone"></i></span>
                                        <span class="input-group-text py-0">+58</span>
                                        <input type="text" class="form-control form-control-sm phone-number-mask" id="cli_telefono" name="cli_telefono" placeholder="4241234567">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ubicación -->
                        <div class="mb-1">
                            <h5 class="text-primary mb-1"><i data-feather="map-pin" class="me-1"></i> Ubicación</h5>
                            <div class="row g-2 mb-2">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Dirección Fiscal</label>
                                    <textarea class="form-control form-control-sm" rows="1" id="cli_direccion" name="cli_direccion" disabled></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Dirección de Despacho <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" rows="1" id="cli_direccion_despacho" name="cli_direccion_despacho"></textarea>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Estado</label>
                                    <select class="form-select form-select-sm select2 cli_estado" id="cli_estado" name="cli_estado">
                                        <option value="0">Seleccione...</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Municipio</label>
                                    <select class="form-select form-select-sm select2 cli_municipio" id="cli_municipio" name="cli_municipio" disabled>
                                        <option value="0">Seleccione...</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Parroquia</label>
                                    <select class="form-select form-select-sm select2 cli_parroquia" id="cli_parroquia" name="cli_parroquia" disabled>
                                        <option value="0">Seleccione...</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Ciudad</label>
                                    <select class="form-select form-select-sm select2 cli_ciudad" id="cli_ciudad" name="cli_ciudad" disabled>
                                        <option value="0">Seleccione...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contactos Clave -->
                        <div class="">
                            <h5 class="text-primary mb-1"><i data-feather="users" class="me-1"></i> Contactos Clave</h5>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Responsable <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="cli_responsable" name="cli_responsable">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Cumpleaños <span class="text-danger">*</span></label>
                                    <input type="text" id="cli_responsable_fecha" class="form-control form-control-sm flatpickr-basic" placeholder="YYYY-MM-DD" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Aniversario empresa <span class="text-danger">*</span></label>
                                    <input type="text" id="cli_aniversario_fecha" class="form-control form-control-sm flatpickr-basic" placeholder="YYYY-MM-DD" readonly>
                                </div>
                                <div class="col-md-4 d-none">
                                    <label class="form-label fw-bold">Propietario  <span class="text-danger">*</span></label>
                                    <input type="text" id="cli_propietario_fecha" class="form-control form-control-sm flatpickr-basic" placeholder="YYYY-MM-DD" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Compras <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="cli_responable_compras" name="cli_responable_compras">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Cumpleaños Compras <span class="text-danger">*</span></label>
                                    <input type="text" id="cli_responsable_compras_fecha" class="form-control form-control-sm flatpickr-basic" placeholder="YYYY-MM-DD" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end border-top pt-2 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary me-2">
                                <i data-feather="x" class="me-1"></i> Cancelar
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" id="btnActualizarCliente">
                                <i data-feather="save" class="me-1"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                      
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->