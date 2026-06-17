  <!-- BEGIN: Content-->
  <div class="app-content content ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Pólizas</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=polizas">Pólizas</a>
                                    </li>
                                    <li class="breadcrumb-item active">Otros varios
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
                        <p>Pólizas de otros varios</p>
                     
                        
                    </div>
                </div>
               <input type="hidden" id="dataPolizasOtros" class="dataPolizasOtros" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-polizas-otros table">
                                    <thead>
                                        <tr>
                                           
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Número</th>
                                            <th>Cliente</th>
                                            <th>Cédula</th>
                                            <th>Código</th>
                                            <th>Titulo</th>
                                            <th>Descripción</th>
                                            <th></th>           
                                            <th></th>           
                                            <th>Aseguradora</th>                                           
                                            <th>Sucursal</th>                                                                                                                     
                                            <th>Estatus</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal to add new record -->
                    <div class="modal modal-slide-in fade" id="modals-slide-in">
                        <div class="modal-dialog sidebar-sm">
                            <form class="add-new-record modal-content pt-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Nuevo registro</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Nombre y apellido</label>
                                        <input type="text" class="form-control  nombre" name="nombre" placeholder="" id="nombre" />
                                    </div> 
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Correo eléctronico</label>
                                        <input type="email" class="form-control  nombreUsuario" name="nombreUsuario" placeholder="usuario@gmail.com" id="nombreUsuario" />
                                    </div>     
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Sucursal</label>
                                        <select class="form-select sucursal" id="sucursal" name="sucursal">                                           
                                           
                                        </select>
                                    </div>      
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Privilegios</label>
                                        <select class="form-select userLevel" id="userLevel" name="userLevel">                                           
                                            <option value="2">Secretaria</option>
                                            <option value="3">Usuario</option>
                                        </select>
                                    </div>      
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Contraseña</label>
                                        <input type="text" class="form-control  contrasena" name="contrasena" placeholder="***********" id="contrasena" />
                                    </div>      
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Confirmar contraseña</label>
                                        <input type="text" class="form-control  confirmContrasena" name="confirmContrasena" placeholder="***********" id="confirmContrasena" />
                                    </div>      
                                                     
                                  
                                    <button type="button" class="btn btn-primary data-submit me-1">Guardar</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
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