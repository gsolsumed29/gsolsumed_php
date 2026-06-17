<div class="app-content content buscarDatosUsuario">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Usuario</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=users">Usuarios</a>
                                    </li>
                                    <li class="breadcrumb-item active">Datos del usuario
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
               
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Detalles de la cuenta</h4>
                            </div>
                            <div class="card-body py-2 my-25">
                               
                              
                                <form class="validate-form mt-2 pt-50 frmEditUsuario" action="#">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">Nombre</label>
                                            <input type="hidden" class="form-control txtEditUsuarioIdUsuario" id="txtEditUsuarioIdUsuario" name="txtEditUsuarioIdUsuario" placeholder="" value="<?php echo $_SESSION['identidad']?>"  />
                                            <input type="text" disabled class="form-control txtEditUsuarioNombre" id="txtEditUsuarioNombre" name="txtEditUsuarioNombre" placeholder="" value="<?php echo $_SESSION['nombre'] ?>"  data-msg="Por favor, escriba el nombre" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountLastName">Nombre de Usuario</label>
                                            <input type="text" disabled  class="form-control txtEditUsuarioNombreUsuario" id="txtEditUsuarioNombreUsuario" name="txtEditUsuarioNombreUsuario" placeholder="" value="<?php echo $_SESSION['nombreUsuario'] ?>" data-msg="Por favor, escriba el usuario" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">Password</label>
                                            <input type="text" class="form-control txtEditUsuarioContrasena" id="txtEditUsuarioContrasena" name="txtEditUsuarioContrasena" placeholder="*********"  />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountOrganization">Re-Password</label>
                                            <input type="text" class="form-control txtEditUsuarioReContrasena" id="txtEditUsuarioReContrasena" name="txtEditUsuarioReContrasena" placeholder="************"  />
                                        </div>


                                   
                                     
                                       
                                        
                                        <div class="col-12 col-sm-6 mb-1">
                                            <button type="button" class="btn btn-primary mt-1 me-1 btnEditUsuario">Guardar</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>