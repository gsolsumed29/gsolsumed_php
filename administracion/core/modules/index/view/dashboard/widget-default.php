
<!-- BEGIN: Content-->
<div class="app-content content i_dashboard">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard content -->
            <div class="row match-height">                  
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card">  <a href="index.php?view=cxc&estatus=2">
                                <div class="card-header">
                                    <div>
                                       <h5 class="fw-bolder mb-0">Ver</h5>
                                        <p class="card-text" style="font-size : 20px;font-weight: 800 !important;">Próximas a vencer</p>
                                          
                                    </div>
                                    <div class="avatar bg-default p-50 m-2">
                                        <div class="avatar-content">
                                         <i data-feather='alert-circle'  class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                        
                            <div class="card">  <a href="index.php?view=cxc&estatus=3">
                                <div class="card-header">
                                    <div>
                                  <h5 class="fw-bolder mb-0">Ver</h5>
                                        <p class="card-text" style="font-size : 20px;font-weight: 800 !important;">Vencidas entre 1 - 3 días</p>
                                    </div>
                                    <div class="avatar bg-warning p-50 m-2">
                                        <div class="avatar-content">
                                        <i data-feather='alert-circle'  class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">                       
                            <div class="card">  
                                <a href="index.php?view=cxc&estatus=4">
                                    <div class="card-header">
                                        <div>
                                    <h5 class="fw-bolder mb-0">Ver</h5>
                                        <p class="card-text" style="font-size : 20px;font-weight: 800 !important;">Vencidas entre 4 - 10 días</p>
                                        </div>
                                        <div class="avatar bg-danger p-50 m-2">
                                            <div class="avatar-content">
                                            <i data-feather='alert-circle'  class="font-medium-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>     
                        
                        
               <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card">  <a href="index.php?view=cxc&estatus=6">
                                <div class="card-header">
                                    <div>
                                       <h5 class="fw-bolder mb-0">Ver</h5>
                                        <p class="card-text" style="font-size : 20px;font-weight: 800 !important;">Facturas por vencer hoy</p>                                          
                                    </div>
                                    <div class="avatar bg-success p-50 m-2">
                                        <div class="avatar-content">
                                         <i data-feather='alert-circle'  class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12">                       
                            <div class="card bg-danger text-white"  >  
                                <a href="index.php?view=cxc&estatus=5" style='color:white; ' >
                                    <div class="card-header">
                                        <div>
                                    <h5 class="fw-bolder mb-0" style='color:white; '>Ver</h5>
                                        <p class="card-text" style="font-size : 20px;font-weight: 800 !important;">Vencidas a 10 días O más </p>
                                        </div>
                                        <div class="avatar bg-info p-50 m-2">
                                            <div class="avatar-content">
                                            <i data-feather='alert-circle'  class="font-medium-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>                    
            

            

            </div>
          
                            <div class="row">
                        <div class="col-md-6 col-lg-5">
                            <div class="card text-center mb-3">
                                <div class="card-body">
                                    <h4 class="card-title">Mensaje de recordatorio</h4>
                                    <p class="card-text" style="font-size : 20px;font-weight: 800 !important;">Para clientes cuyas facturas estan proximas a vencer. (2 dias)</p>
                                    <button type="button" class="btn btn-primary btnSendSMSMasivo" id="btnSendSMSMasivo">
                                        <i data-feather="smartphone"></i> <span class="btn-text">   Enviar SMS</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
    </div>
</div>
<!-- END: Content-->

