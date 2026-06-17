  <!-- BEGIN: Content-->
  <?php
    $estatus  = isset($_GET['estatus']) ? $_GET['estatus'] : '0';
    if($estatus == 2){
        $leyenda = "Facturas por vencer en 2 días";
    }elseif($estatus == 3){
        $leyenda = "Facturas vencidas entre 1 y 3 días";
    }elseif($estatus == 4){
        $leyenda = "Facturas vencidas entre 4 y 10 días";
    }elseif($estatus == 5){
        $leyenda = "Facturas vencidas entre 11 o más días";
    }elseif($estatus == 6){
        $leyenda = "Facturas que vencen hoy";
    }
  ?>
  <div class="app-content content cuentasPorCobrar">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Cuentas </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Dasboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#"><?php echo $leyenda ?> </a>
                                    </li>
                                   
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-4 col-12">
                    <div class="mb-1 breadcrumb-right">
                   
                    </div>
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                  
                </div>
                <input type="hidden" id="estatus" class="estatus" value='<?php echo $estatus ?>'>
               <input type="hidden" id="dataCuentasPorCobrar" class="dataCuentasPorCobrar" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic-cuentas table">
                                <thead>
                                    <tr>
                                        <!-- Columna 0: Responsiva (DEBE ESTAR, aunque vacía) -->
                                        <th></th>
                                        
                                        <!-- Columna 1: ID Oculto -->
                                        <th></th>
                                        
                                        <!-- Columna 2: Código -->
                                        <th>Código</th>
                                        
                                        <!-- Columna 3: Cliente -->
                                        <th>Cliente</th>
                                        <!-- Columna 3: Cliente -->
                                        <th>Tipo</th>
                                        <!-- Columna 4: Rif -->
                                        <th>Rif</th>
                                        
                                        <!-- Columna 5: Responsable -->
                                        <th>Responsable</th>
                                        
                                        <!-- Columna 6: Teléfonos -->
                                        <th>Teléfonos</th>
                                        
                                        <!-- Columna 7: Saldo -->
                                        <th>Saldo</th>

                                          <!-- Columna 8: Saldo -->
                                        <th>Vendedor</th>
                                        
                                        <!-- Columna 9: Acciones -->
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </section>
              

        

            </div>
        </div>
    </div>
    <!-- END: Content-->