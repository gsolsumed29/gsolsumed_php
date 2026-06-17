     <!-- BEGIN: Content-->
  <div class="app-content content ">
  <input type="hidden" id="idPolizaData" value ="<?php echo $_GET['id']; ?>">
 <div class="content-overlay"></div>
 <div class="header-navbar-shadow"></div>
 <div class="content-wrapper container-xxl p-0">
     <div class="content-header row">
         <div class="content-header-left col-md-9 col-12 mb-2">
             <div class="row breadcrumbs-top">
                 <div class="col-12">
                     <h2 class="content-header-title float-start mb-0">Archivos</h2>
                     <div class="breadcrumb-wrapper">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item"><a href="./">Home</a>
                             </li>
                             <li class="breadcrumb-item"><a href="index.php?view=polizas"> Membresias</a>
                             </li>
                             <li class="breadcrumb-item active"><a href="index.php?view=tipo&id=<?php echo $_GET['id']; ?>" id="numeroPoliza-media2"></a>
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
        <input type="hidden" id="dataMedia" class="dataMedia" value=''>
         <!-- Basic table -->
         <section id="basic-datatable">
             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <table class="datatables-basic-media table" id="archivosMedia">
                             <thead>
                                 <tr>
                                    
                                     <th></th>
                                     <th></th>
                                     <th></th>
                                     <th>Media</th>
                                     <th>Tipo</th>                                  
                                     <th>Año</th>  
                                     <th>correo</th>                                         
                                     <th></th>
                                 </tr>
                             </thead>
                         </table>
                     </div>
                 </div>
             </div>
           
         </section>
         <!--/ Basic table -->


     <!-- Create New Folder Modal Starts-->
     <div class="modal fade" id="new-folder-modal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="numeroPoliza-media3"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="post" action="#" enctype="multipart/form-data">
                                       
                                            
                                            <input type="hidden" class="form-control poliza-media" id="poliza-media" name="poliza-media" value ="<?php echo $_GET['id']; ?>">
                                            <input type="hidden" class="form-control numeroPoliza-media" id="numeroPoliza-media" name="numeroPoliza-media">
                                      
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-email">Tipo de documento </label>
                                            <select class="form-select tipo-media" id="tipo-media" name="tipo-media">                                          
                                                <option value= "1"> Membresia </option>	 
                                                <option value= "2"> Identificación / Pasaporte </option>	 
                                                <option value= "3"> Rif </option>	 	 
                                                <option value= "4"> Certificacion de nacimiento </option>	
                                               
                                                <option value= "5"> Otros </option>	 	 	                                  
                                            </select>
                                        </div>     
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-email">Documento</label>
                                            <input type="file" accept="application/pdf" class="form-control archivo-media" name="archivo-media" id="archivo-media"><br>
                                                    <p>Solo se permiten archivos en formato .PDF <br> que no excedan los 2mb</p>
                                        </div>    
                                        <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Fecha * </label>
                                        <input type="text" id="ano-media" class="form-control flatpickr-basic flatpickr-input active ano-media" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div> 
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary me-1 data-submit" id="upload2" >Cargar</button>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Create New Folder Modal Ends -->

 

     </div>
 </div>
</div>
<!-- END: Content-->
