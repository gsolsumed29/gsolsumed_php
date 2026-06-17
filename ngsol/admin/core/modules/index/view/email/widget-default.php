 <!-- BEGIN: Content-->
 <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Empresa</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Detalles de la empresa </a>
                                    </li>
                                    <li class="breadcrumb-item active"> Correo electrónico
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-2">
                           
                           
                         

                        <!-- profile -->
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Configuracion del Correo</h4>
                            </div>
                            <div class="card-body ">
                              
                                <!-- form -->
                                <form class="update-record-empresa mt-2 pt-50">
                                    <div class="row dataCorreo">
                                       
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountOrganization">Texto</label>
                                            <textarea class="form-control text" id="text" name="text" rows="3" placeholder=""></textarea>
                                        </div>        
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountLastName">Smtp</label>
                                            <input type="email" class="form-control smtp" id="smtp" name="smtp" placeholder="" value="" data-msg="" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountLastName">Password</label>
                                            <input type="text" class="form-control password" id="password" name="password" placeholder="" value="" data-msg="" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">Host</label>
                                            <input type="text" class="form-control host" id="host" name="host" placeholder="" value="" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">Puerto</label>
                                            <input type="text" class="form-control port" id="port" name="port" placeholder="" value="" />
                                        </div>
                                                                         
                                        <div class="col-12">
                                            <button type="button" class="btn btn-relief-primary mt-1 me-1 data-submit-correo"> <i data-feather='save'></i> Guardar Cambios</button>
                                            <button type="button" class="btn btn-relief-info mt-1 me-1 enviarCorreo"> <i data-feather='wifi'></i> Probar envio</button>
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
    <!-- END: Content-->