  <!-- BEGIN: Content-->
  <div class="app-content content ">
 <?php
   $tipo_doc= $_GET['tipo_doc']; 
   if($tipo_doc ==1){

   $tipo_doc_msg = "FACTURAS";

   }elseif($tipo_doc ==2){
     $tipo_doc_msg = "NOTAS";
   }elseif($tipo_doc ==3){
     $tipo_doc_msg = "NOTAS DE CRÉDITO";
   }elseif($tipo_doc ==4){
    $tipo_doc_msg = "NOTAS DE DÉBITO";
   }elseif($tipo_doc ==5){
    $tipo_doc_msg = "ANULACIONES";
   }
  
  ?>
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Documentos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="./">Documentos</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <?php echo $tipo_doc_msg; ?>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
               
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                  
                </div>
                <input type="hidden" id="tipo_doc" class="tipo_doc" value='<?php echo $tipo_doc; ?>'>
               <input type="hidden" id="dataDocumentos" class="dataDocumentos" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="dataTableDocumentos table">
                                    <thead>
                                       <tr> 
                                            <th></th>  <!-- Checkbox para selección -->
                                            <th>Nº Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha Emisión</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Saldo BS.D</th>
                                            <th>Saldo USD</th>
                                            <th>Tasa</th>
                                            <th>Estatus</th>
                                            <th>IVA</th>
                                            <th>Contrib. Esp.</th>
                                            <th></th>  <!-- Acciones -->    <th></th>  <!-- Acciones -->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
                <!--/ Basic table -->


         
        

            </div>
        </div>
    </div>
    <!-- END: Content-->