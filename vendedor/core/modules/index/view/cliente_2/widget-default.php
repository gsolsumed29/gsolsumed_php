<!-- BEGIN: Content-->
<div class="app-content content  m_clientes_c2" id="perfilCLiente">
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
                                <li class="breadcrumb-item">
                                    <a href="./">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="index.php?view=visitas">Clientes</a>
                                </li>
                                <li class="breadcrumb-item active">Encuesta</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right"></div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-2">
                        <!-- account -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?view=cliente&co_cli=<?php echo $_GET['co_cli'] ?>">
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
                            <a class="nav-link " href="index.php?view=cliente_1&co_cli=<?php  echo $_GET['co_cli']?>">
                               <i data-feather="users" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Encuesta</span>
                            </a>
                        </li>

                         </li>
                                <li class="nav-item">
                                <a class="nav-link active"  href="#">
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
                                    <label class="form-label fw-bold">Quien lo recibió?<span class="text-danger">*</span></label>
                                 
                                    <div class="input-group input-group">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control form-control" id="cli_recibe_visita" name="cli_recibe_visita" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
                                    <div class="input-group input-group">
                                        <span class="input-group-text"><i data-feather="phone"></i></span>
                                        <span class="input-group-text py-0">+58</span>
                                        <input type="text" class="form-control form-control-sm phone-number-mask" id="cli_telefono_visita" maxlength="12" name="cli_telefono_visita" placeholder="4241234567">
                                    </div>
                                </div>

                                   <div class="col-md-12">           
                                    <label class="form-label fw-bold">Obrservación</label>
                                    <textarea class="form-control form-control" rows="3" id="cli_observacion_visita" name="cli_observacion_visita" ></textarea>
                                </div>
                            </div>
                        </div>

                               <!-- Ubicación -->
                        <div class="mb-1">
                            <h5 class="text-primary mb-1"><i data-feather="map-pin" class="me-1"></i> Ubicación</h5>
                           
                            <div class="row g-2">
                              
                           

                                <div class="mb-1 photo-section">
                                    <div class="photo-icon">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <label for="fotoPuntoVenta">
                                        <h5>Fotografía del punto de venta o producto en estantería</h5>
                                        <p class="text-muted">Haga clic para seleccionar una foto</p>
                                    </label>
                                    <input type="file" class="fotoPuntoVenta" id="fotoPuntoVenta" accept="image/*" style="display: none;">
                                    
                                    <!-- Contenedor para la previsualización -->
                                    <div id="previewContainer" class="mt-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Vista previa</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <img id="previewImage" src="#" alt="Vista previa" class="img-fluid rounded" style="max-height: 200px;">
                                                <div class="mt-2">
                                                    <button type="button" id="removePhoto" class="btn btn-sm btn-outline-danger">
                                                         <i data-feather="trash" class="me-1"> </i> Eliminar foto
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Mensaje de estado -->
                                    <div id="photoStatus" class="alert alert-info mt-2" style="display: none;"></div>
                                </div>

                                              
                                <div class="mb-2 " >
                                    <label class="form-label fw-semibold">Ubicación GPS</label>
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body ">
                                            <div class="d-flex align-items-center mb-2 justify-content-center">
                                            
                                                <button type="button" id="getLocation" class="btn btn-outline-primary btn-sm">
                                                    <i data-feather="crosshair" class="me-1"></i> Obtener Ubicación
                                                </button>
                                            </div>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="bg-light p-1 rounded">
                                                        <strong class="d-block text-muted small">Latitud</strong>
                                                        <span id="latitude" class="fw-semibold">No disponible</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="bg-light p-1 rounded">
                                                        <strong class="d-block text-muted small">Longitud</strong>
                                                        <span id="longitude" class="fw-semibold">No disponible</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="bg-light p-1 rounded">
                                                        <strong class="d-block text-muted small">Precisión</strong>
                                                        <span id="accuracy" class="fw-semibold">No disponible</span> metros
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="bg-light p-1 rounded">
                                                        <strong class="d-block text-muted small">Hora</strong>
                                                        <span id="timestamp" class="fw-semibold">No disponible</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div id="statusMessage" class="mt-3 alert alert-info d-none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Botones -->
                        <div class="d-flex justify-content-end border-top pt-2 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary me-2">
                                <i data-feather="x" class="me-1"></i> Cancelar
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" id="btnRegistrarVisitaCliente">
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