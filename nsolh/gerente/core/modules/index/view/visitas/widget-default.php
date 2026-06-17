  <!-- BEGIN: Content-->
  <div class="app-content content ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Visitas</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=visitas">Visitas</a>
                                    </li>
                                    <li class="breadcrumb-item active">Clientes visitados
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
               <input type="hidden" id="dataVisitas" class="dataVisitas" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-visitas table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>                                           
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Descripción</th>
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
                            <form class="add-new-record-visita modal-content pt-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Datos de la visita</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                      
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Cliente</label>
                                        <select class="select2 form-select comboClientes" id="select2-basic">                                               
                                        </select>
                                    </div>   
                                   
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Motivo</label>
                                        <select class="form-select des_vis" id="des_vis" name="des_vis">    
                                        <option value="NO">Seleccione</option>                                           
                                            <option value="1">Si compro</option>    
                                            <option value="2">No compro</option>   
                                            <option value="3">Ya fue visitado</option> 
                                            <option value="4">Tiene suficiente inventario</option>   
                                            <option value="5">Existen otras ofertas</option>                                                
                                        </select>
                                    </div>     
                                 
                                    
                                  
                                  
                                  
                                    <button type="button" class="btn btn-primary data-submit-visita me-1">Guardar</button>
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