    <!-- BEGIN: Content-->
    <?php 
     
      $objeto_empleado = New VendedorData();    
      $result2 = $objeto_empleado->GetDataEmpleado();  
      $reci_num=$_GET['reci_num'];
      $objeto_nomina = New NominaData();          
      $result = $objeto_nomina->GetNomina($reci_num);
    //  var_dump($result2);
      if(!empty($result)){
     
    
    ?>

        <!-- BEGIN: Content-->
        <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Recibos</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Recibos</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=nominas">Nomina</a>
                                    </li>
                                    <li class="breadcrumb-item active">Detalles
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                                
                   <a href="index.php?action=reporte&tipo=1&reci_num=<?php echo $reci_num; ?>&status=1" target="_blank" class="btn btn-danger w-100 btn-download-invoice mb-75">Generar PDF</a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="invoice-preview-wrapper">
                    <div class="row invoice-preview">
                        <!-- Invoice -->
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="card invoice-preview-card">
                                <div class="table-responsive">
                                        <table class="table" >
                                            <thead>
                                                <tr>
                                                    <td class="py-1"><img src="../app-assets/images/logo/logo_recibo.jpg"  style="width:100px;heght:100x" alt="logo_colegio"></th>
                                                    <td class="py-1" style="text-align:right"> <h2>RECIBO DE PAGO NOMINA</h2> </td>
                                                    <td class="py-1" style="text-align:right"> <h2>N° RECIBO:  <b><?php  echo  $reci_num; ?></b></h2></td>
                                                    
                                                </tr>
                                            </thead>
                                        
                                        </table>
                                </div>
                                <div class="table-responsive">
                                        <table class="table" style="text-align:center" >
                                            <thead>
                                                <tr>
                                                    <td class="py-1"> Fecha:  <b><?php echo $result[0]->fec_emis; ?></b></td>
                                                    <td class="py-1" >Periodo desde: <b><?php echo $result[0]->fec_ini; ?></b>  </td>
                                                    <td class="py-1"> Hasta: <b><?php echo $result[0]->fec_fin; ?>  </b></td>
                                                    
                                                </tr>
                                            </thead>                                        
                                        </table>
                                </div>                
                                <div class="table-responsive">
                                    <table class="table"   >
                                        <thead>
                                            <tr>
                                                <td class="py-1"  style="text-align:left">Trabajador: <b><?php echo $result2[0]->cod_emp."-".$result2[0]->nombre_completo?></b> <br>
                                                Departamento: <b><?php echo $result[0]->des_depart?></b>  <br>
                                                Categoría: <b><?php echo "0" ?></b>  </td>
                                                <td class="py-1">Cédula:  <b><?php echo $result2[0]->ci?></b><br>
                                                Cargo: <b><?php echo $result2[0]->des_cargo?></b><br> 
                                            
                                               Sueldo mensual: <b><?php echo $result[0]->SueldoMensVar?>&nbsp;BsD</b> </td>
                                                <td class="py-1"  style="text-align:right">Fecha de Ingreso: <b><?php echo $result2[0]->fecha_ing?></b>  <br>
                                                &nbsp; <br>
                                                Sueldo diario: <b><?php echo $result[0]->Sueldo_diario?>&nbsp;BsD</b> </td>
                                              
                                            </tr>
                                         
                                        </thead>
                                    </table>

                                    <table class="table" style="text-align:center" >
                                        <thead>
                                            <tr>
                                                <th class="py-1">Codigo</th>
                                                <th class="py-1" >Descripción</th>
                                                <th class="py-1">Valor auxiliar</th>
                                                <th class="py-1">Asignaciones</th>
                                                <th class="py-1">Deducciones</th>
                                                <th class="py-1">Neto a cobrar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php    
                                          $totalAsignaciones=0;
                                          $totalDeducciones=0;
                                        $totalArticulos = 0;
                                           //var_dump( $result2);
                                           foreach($result as $dato){
                                            $co_conce = $dato->co_conce;
                                            $des_conce = $dato->des_conce;                                           
                                            $valor_auxiliar=  $dato->auxi_num.''.$dato->auxi_cha;
                                            $tipo =  $dato->tipo;    
                                          
                                          // number_format($r['monto'], 2, ',', '.'); 
                                    

                                            /*$precio=  $dato->dato3;
                                            $total = $cantidad * $precio;
                                            $totalArticulos = $totalArticulos + $cantidad;*/
                                            ?>
                                            <tr>                                                 
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php  echo $co_conce?></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php  echo $des_conce?></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php  echo $valor_auxiliar?></span>
                                                </td>
                                                <?php 
                                                if($tipo ==3) {
                                                    $monto =   $dato->monto*-1; 
                                                    $totalDeducciones =  $totalDeducciones+$monto;
                                                ?>
                                                <td class="py-1">
                                                    <span class="fw-bold"></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php  echo  number_format($monto, 2, ',', '.');?>&nbsp;BsD</span>
                                                </td>
                                                <?php
                                                }else{
                                                    $monto =  $dato->monto;
                                                    $totalAsignaciones = $totalAsignaciones+$monto;
                                                ?>

                                                <td class="py-1">
                                                    <span class="fw-bold"><?php  echo  number_format($monto, 2, ',', '.');?>&nbsp;BsD</span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"></span>
                                                </td>
                                                <?php
                                                }
                                                ?>
                                              
                                                <td class="py-1">
                                                    <span class="fw-bold"></span>
                                                </td>
                                            </tr>
                                           <?php } ?>

                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="table-responsive" style =" table-layout: fixed; width: 100%;">
                                        <table class="table" style="text-align:center" >
                                            <thead>
                                                <tr>
                                                    <td class="py-1" style="  width: 40%;height:100px; word-wrap: break-word;"> Recibí conforme: _________________________________________</b></td>
                                                    <td class="py-1" style="  width: 60%;height:100px; word-wrap: break-word;" >
                                                        <table class="table" style="text-align:center" >                                           
                                                            <tr style=" border: 3px solid; ">
                                                                <td class="py-1" style=" width: 30%; word-wrap: break-word;"> Total Trabajador:</td>
                                                                <td class="py-1" style=" width: 25%; word-wrap: break-word;"> <b><?php echo number_format($totalAsignaciones, 2, ',', '.'); ?>&nbsp;BsD</b></td>
                                                                <td class="py-1" style=" width: 25%; word-wrap: break-word;"> <b><?php echo number_format($totalDeducciones, 2, ',', '.'); ?>&nbsp;BsD</b></td>
                                                                <td class="py-1" style=" width: 20%; word-wrap: break-word;"><b><?php echo number_format($totalAsignaciones+$totalDeducciones, 2, ',', '.'); ?>&nbsp;BsD</b></td>
                                                            </tr>     
                                                            <tr>
                                                                <td class="py-1" style=" width: 30%; word-wrap: break-word;text-align:left" colspan="4"> Banco: <b> <?php echo $result2[0]->des_ban?></b> <br>
                                                                Cuenta : <b> <?php echo $result2[0]->cta_banc1?></b>
                                                                </td>
                                                              
                                                        </table>                                     
                                                    </td>
                                                </tr>

                                            </thead>                                        
                                        </table>
                                </div>    



                            </div>
                        </div>
                        <!-- /Invoice -->


                    </div>
                </section>

         

             
            </div>
        </div>
    </div>

    <?php 
      }else{
        ?>
        
        <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
            <div class="row match-height carritoVacio">
                    <!-- Congratulations Card -->
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-congratulations">
                            <div class="card-body text-center">
                               
                              
                                <div class="avatar avatar-xl bg-info shadow">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award font-large-1"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-1 text-white">Lo Sentimos,</h1>
                                    <p class="card-text m-auto w-75">
                                        Existe un error en esta   <strong>Nómina</strong> Por favor verifique e intente nuevamente.
                                    </p>
                                    <a class="btn-icon btn btn-success" href="index.php?view=nominas">Volver</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Congratulations Card -->

                  
                </div>

               

              

            </div>
        </div>
    </div>
        
        
        <?php
      }
    ?>
    <!-- END: Content-->