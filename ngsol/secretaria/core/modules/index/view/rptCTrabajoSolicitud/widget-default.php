 <!-- BEGIN: Content-->
    <div class="app-content content rptCTrabajo">
        <input type="hidden" id="cod_emp" class="cod_emp" value ="<?php echo $_GET['cod_emp'] ?>">
        <?php
              $objeto_empleado = New VendedorData();    
              $result2 = $objeto_empleado->getDataEmpleadoSolicitud($_GET['cod_emp']);   
            ?>
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Solicitudes </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=solicitudes&filtro=1">Solicitudes</a>
                                    </li>
                                    <li class="breadcrumb-item active"><?php echo $result2[0]->nombre_completo; ?>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>    
        </div>
            <div class="content-body">
                <section class="invoice-preview-wrapper" >
                    <div class="row invoice-preview">
                        <!-- Invoice -->
                        
                        <div class="col-xl-10 col-md-12 col-12" id="anexo1p" >
                            <div class="card invoice-preview-card">
                            <div class="text-center">
                                               
                                                                                       
                                </div>
                                <div class="card-body invoice-padding pb-0">
                                    <!-- Header starts -->
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                        <div>
                                            <p class="card-text mb-25">U.E. Colegio "San Pedro"</p>
                                            <p class="card-text mb-25">Inscrito en el Ministerio del Poder Popular para la Educación</p>
                                            <p class="card-text mb-25">Código S0786D1303</p>
                                            <p class="card-text mb-0">Carrera 19 Nª 56-26 Teléfono: 0251-442.61.01</p>
                                            <p class="card-text mb-0">Barquisimeto - Estado Lara</p>
                                            <p class="card-text mb-0">Rif. J08506096-0</p>
                                        </div>
                                        <div class="mt-md-0 mt-2">
                                            <h4 class="invoice-title ">Documento Nro. <b class="idSolicitud"><?php echo $_GET['id'];?></b></h4>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Emitida: <?php echo $_GET['fechaEmision'] ?></p>
                                               
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                </div>

                                                        
                            <?php 
                       

                             function fechaCastellano ($fecha) {
                                $fecha = substr($fecha, 0, 10);
                                $numeroDia = date('d', strtotime($fecha));
                                $dia = date('l', strtotime($fecha));
                                $mes = date('F', strtotime($fecha));
                                $anio = date('Y', strtotime($fecha));
                                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                              $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                                return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
                              }

                           
                            
                            ?>
                                <!-- Invoice Description starts -->
                                <div class="text-center">
                                                <p class="invoice-date-title">CONSTANCIA</p>
                                                                                       
                                </div>
                               <br><br>
                               <div class="card-body invoice-padding pb-0">
                                    <!-- Header starts -->
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                        <div>
                                            <p class="card-text mb-25"> La suscrita ADMINISTRADORA de la U.E. Colegio "San Pedro" LIC. MARIA YSABEL SALAS, 
                                                por medio de la presente hace constar que el(la) ciudadano(a): <?php echo $result2[0]->nombre_completo; ?>, titular de la 
                                                Cédula de Identidad Nª <?php echo $result2[0]->ci;?>, presta sus servicios en este plantel como: <?php echo $result2[0]->des_cargo;?>,
                                                desde el  <?php echo  $result2[0]->fecha_ing;?>, y devenga ingresos promedios mensuales de BS. <?php echo "Falta sacar sueldo promedio mensual"?>

                                            </p>
                                          <br><br>
                                          <p class="card-text mb-25">
                                            Constancia que se expide a petición de la parte interesada en Baquisimeto, el <?php echo fechaCastellano($_GET['fechaEmision']); ?><?php //echo $fechaLetras; ?>
                                                                                         
                                            </p>
                                        </div>
                                       
                                     
                                    </div>
                                    <!-- Header ends -->
                                </div>
                                <br><br><br>
                                <div class="text-center ">
                                                <p class="invoice-date-title mb-25">LIC.MARIA YSABEL SALAS</p>
                                                <p class="invoice-date-title mb-25">ADMINISTRADORA</p>              
                                         </div>
                                         <br><br><br>
                             
                            </div>
                        </div>
                        <!-- /Invoice -->

                        <!-- Invoice Actions -->
                        <div class="col-xl-2 col-md-12 col-12 invoice-actions mt-md-0 mt-2">
                            <div class="card">
                                <div class="card-body">
                                <button type="button" class="btn btn-relief-success  aprobarSolicitud w-100 mb-75"> <i data-feather='check'></i>  Aprobar </button>
                                <button type="button" class="btn btn-relief-danger  denegarSolicitud w-100 mb-75"> <i data-feather='x'></i>  Denegar </button>
                                    <a href="index.php?action=anexo1&fecha=<?php echo $fecha;?> " target="_blank" class="btn btn-relief-info w-100 mb-75">
                                    <i data-feather='printer'></i>
                                    Generar pdf
                                            </a>    
                                                              
                                </div>
                            </div>
                        </div>
                        <!-- /Invoice Actions -->
                    </div>
                </section>

              
           

            </div>
        </div>
    </div>
    <!-- END: Content-->