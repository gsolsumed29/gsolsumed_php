  <!-- BEGIN: Content-->
  <div class="app-content content ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Usuarios</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=users">Usuarios</a>
                                    </li>
                                    <li class="breadcrumb-item active">Listado
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <!--
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i class="me-1" data-feather="check-square"></i><span class="align-middle">Todo</span></a><a class="dropdown-item" href="app-chat.html"><i class="me-1" data-feather="message-square"></i><span class="align-middle">Chat</span></a><a class="dropdown-item" href="app-email.html"><i class="me-1" data-feather="mail"></i><span class="align-middle">Email</span></a><a class="dropdown-item" href="app-calendar.html"><i class="me-1" data-feather="calendar"></i><span class="align-middle">Calendar</span></a></div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                    <div class="col-12 data">

                    </div>
                </div>
               <input type="hidden" id="dataUsers" class="dataUsers" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-users table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>                                           
                                            <th>Apellidos y nombres</th>
                                            <th>Usuario</th>
                                            <th>Privilegios</th>
                                            <th>Correo corporativo</th>
                                            <th>Almacén</th>
                                            <th>Sucursal</th>
                                            <th>Última sesión</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>                                         
                                                                                                                      
                                            <th>Estatus</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  <!-- Modal -->
                                            <div class="modal fade text-start modal-warning" id="warning" tabindex="-1" aria-labelledby="myModalLabel140" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel140">Cambiar Contraseña</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body flex-grow-1">
                                                          <p>Tenga en cuenta que al cambiar la contraseña de este usuario, perdera acceso a nuestra plataforma.</p>
                                                          <input type="hidden" class="form-control  id" name="id" id="id" />
                                                     
                                                        <div class="mb-1">
                                                            <label class="form-label" for="basic-icon-default-email">Contraseña</label>
                                                            <input type="text" class="form-control  contrasena" name="contrasena" placeholder="***********" id="contrasena" />
                                                        </div>      
                                                        <div class="mb-1">
                                                            <label class="form-label" for="basic-icon-default-email">Confirmar contraseña</label>
                                                            <input type="text" class="form-control  confirmContrasena" name="confirmContrasena" placeholder="***********" id="confirmContrasena"  />
                                                        </div> 
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-relief-warning guardar" data-bs-dismiss="modal"><i data-feather='save'></i> Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                      <!-- Modal to add new record -->
                      <div class="modal modal-slide-in fade" id="modals-slide-in">
                        <div class="modal-dialog sidebar-sm">
                            <form class="add-new-record-usuario modal-content pt-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Datos del Usuario</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Privilegios</label>
                                        <select class="form-select userLevel" id="userLevel" name="userLevel">                                           
                                            <option value="2">Vendedor</option>    
                                            <option value="3">Gerente</option>     
                                            <option value="4">Despacho</option>  
                                            <option value="5">Secretaria</option>  
                                            <option value="6">Despacho general</option>   
                                                     
                                            <option value="11">Compras</option>  
                                            <option value="12">Ventas</option>    
                                            <option value="13">Administracion</option>   
                                            <option value="14">Gerencia</option>                                                               
                                        </select>
                                    </div>     
                                   
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Sucursal</label>
                                        <select class="select2 form-select comboAlmacen" id="select2-basic-comboAlmacen">                                               
                                        </select>
                                    </div>   
                                      
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Almacén</label>
                                        <select class="select2 form-select comboAlmacenesUsuario" id="select2-basic-almacen">                                               
                                        </select>
                                    </div>   
                                    
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Vendedor</label>
                                        <select class="select2 form-select comboVendedoresUsuario" id="select2-basic">                                               
                                        </select>
                                    </div>   
                                    <div class="mb-1 d-none">
                                        <label class="form-label" for="basic-icon-default-email">Precios</label>
                                        <select class="form-select userPrecio" id="userPrecio" name="userPrecio">                                           
                                            <option value="1">Precios Tipo 1</option>    
                                            <option value="2">Precios Tipo 2</option>  
                                            <option value="3">Precios Tipo 3</option>                                                      
                                        </select>
                                    </div>     
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Usuario</label>
                                        <input type="text" class="form-control  email" name="email" placeholder="usuario" id="email" />
                                    </div>   

                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Contraseña</label>
                                        <input type="text" class="form-control  contrasena" name="contrasena" placeholder="***********" id="contrasena" />
                                    </div>      
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Confirmar contraseña</label>
                                        <input type="text" class="form-control  confirmContrasena" name="confirmContrasena" placeholder="***********" id="confirmContrasena"  />
                                    </div>      
                                                     
                                  
                                    <button type="button" class="btn btn-relief-primary btnAddUser me-1"> <i data-feather='save'></i> Guardar</button>
                                    <button type="reset" class="btn btn-relief-danger" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->


         

        

            </div>
        </div>
    </div>
    <!-- END: Content-->