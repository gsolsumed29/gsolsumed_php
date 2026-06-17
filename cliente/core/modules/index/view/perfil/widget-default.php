<!-- BEGIN: Content-->
<div class="container-fluid content-inner mt-n5 py-0" id="perfilCLiente">  <!-- Corregido 'conatiner' a 'container' -->
    <div class="row">
        <div class="col-lg-12">
           <div class="card">
                <div class="card-body">
                   <div class="d-flex flex-wrap align-items-center justify-content-between">
                      <div class="d-flex flex-wrap align-items-center">
                         <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                            <img src="assets/images/avatars/01.png" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                         </div>
                         <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                            <h4 class="me-2 h4">Perfil</h4>
                            <span id="header-client-name"></span>
                         </div>
                      </div>
                      <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                         <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" href="#profile-feed" role="tab" aria-selected="false">Perfil</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile-activity" role="tab" aria-selected="false">Direcciones</a>
                         </li>
                      </ul>
                   </div>
                </div>
           </div>
        </div>
      
        <div class="col-lg-8">
           <div class="profile-content tab-content">
             <!-- PESTAÑA 1: PERFIL (Datos Organizacionales y Contacto) -->
             <div id="profile-feed" class="tab-pane fade active show">
                <div class="card">
                   <div class="card-header">
                      <div class="header-title">
                         <h4 class="card-title">Organizacionales | Contacto</h4>
                      </div>
                   </div>
                   <div class="card-body">
                      <div class="new-user-info">
                         <form>
                            <!-- Código oculto para referencia -->
                            <input type="hidden" id="co_cli" name="co_cli" value="<?php echo $_SESSION['identidad'] ?? ''; ?>">

                            <div class="row">
                               <!-- Razón Social -->
                               <div class="form-group col-md-12">
                                  <label class="form-label" for="cli_des">Razón Social:</label>
                                  <input type="text" class="form-control" id="cli_des" name="cli_des" >
                               </div>
                               
                               <!-- Código y RIF -->
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="co_cli_view">Código:</label>
                                  <!-- Usamos un ID diferente para la visualización para no duplicar el hidden, o el mismo si el JS lo llena -->
                                  <input type="text" class="form-control" id="co_cli_view" name="co_cli_view" disabled value="<?php echo $_SESSION['nombre'] ?? ''; ?>">
                               </div>
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_rif">RIF:</label>
                                  <input type="text" class="form-control" id="cli_rif" name="cli_rif" >
                               </div>

                               <!-- Contacto Principal -->
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_email">Email:</label>
                                  <input type="email" class="form-control" id="cli_email" name="cli_email" placeholder="correo@empresa.com">
                               </div>
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_telefono">Teléfono:</label>
                                  <input type="text" class="form-control" id="cli_telefono" name="cli_telefono" placeholder="+58 424...">
                               </div>

                               <hr class="my-3">

                               <!-- Responsables y Fechas -->
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_responsable">Responsable:</label>
                                  <input type="text" class="form-control" id="cli_responsable" name="cli_responsable">
                               </div>
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_responsable_fecha">Cumpleaños Responsable:</label>
                                     <input type="text" id="cli_responsable_fecha" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">       
                              
                               </div>

                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_aniversario_fecha">Aniversario Empresa:</label>
                                     <input type="text" id="cli_aniversario_fecha" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">       
                                 
                               </div>
                               
                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_responable_compras">Responsable Compras:</label>
                                  <input type="text" class="form-control" id="cli_responable_compras" name="cli_responable_compras">
                               </div>

                               <div class="form-group col-md-6">
                                  <label class="form-label" for="cli_responsable_compras_fecha">Cumpleaños Compras:</label>
                                     <input type="text" id="cli_responsable_compras_fecha" class="form-control flatpickr-basic facturas_fecha flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">       
                                 
                               </div>
                            </div>
                            
                            <button type="button" class="btn btn-primary" id="btnActualizarCliente">Guardar Cambios</button>
                         </form>
                      </div>
                   </div>
                </div>
             </div>

             <!-- PESTAÑA 2: DIRECCIONES (Ubicación) -->
             <div id="profile-activity" class="tab-pane fade">
                <div class="card">
                   <div class="card-header d-flex justify-content-between">
                      <div class="header-title">
                         <h4 class="card-title">Fiscal | Entrega | Ubicación</h4>
                      </div>
                   </div>
                   <div class="card-body">
                      <form>
                        <div class="row">

                             <!-- División Geográfica -->
                            <div class="form-group col-md-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select cli_estado" id="cli_estado" name="cli_estado">
                                    <option value="0">Seleccione...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Municipio</label>
                                <select class="form-select cli_municipio" id="cli_municipio" name="cli_municipio">
                                    <option value="0">Seleccione...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Parroquia</label>
                                <select class="form-select cli_parroquia" id="cli_parroquia" name="cli_parroquia">
                                    <option value="0">Seleccione...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Ciudad</label>
                                <select class="form-select cli_ciudad" id="cli_ciudad" name="cli_ciudad">
                                    <option value="0">Seleccione...</option>
                                </select>
                            </div>

                            <!-- Dirección Fiscal -->
                            <div class="form-group col-12 mb-3">
                                <label class="form-label fw-bold">Dirección Fiscal</label>
                                <textarea class="form-control" rows="2" id="cli_direccion" name="cli_direccion"></textarea>
                            </div>

                            <!-- Dirección Despacho -->
                            <div class="form-group col-12 mb-3">
                                <label class="form-label fw-bold">Dirección de Despacho</label>
                                <textarea class="form-control" rows="2" id="cli_direccion_despacho" name="cli_direccion_despacho"></textarea>
                            </div>

                       
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