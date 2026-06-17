    <!-- BEGIN: Content-->
    <?php 
    $status =$_GET['s'];
      $fact_num=$_GET['fact_num'];
      $objeto_factura = New FacturaData();          
      $result = $objeto_factura->GetFactura($fact_num,$status);
      //var_dump($result);
      if(!empty($result)){
     
        
        
    ?>
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Factura </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=facturaciones">Facturaciones</a>
                                    </li>
                                  
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="invoice-preview-wrapper">
                    <div class="row invoice-preview" >
                        <!-- Invoice -->
                        <div class="col-xl-9 col-md-8 col-12" >
                            <div class="card invoice-preview-card">
                                <div class="card-body invoice-padding pb-0">
                                    <!-- Header starts -->
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    
                                        <div class="mt-md-0 mt-2">
                                            <h4 class="invoice-title">
                                                Pedido
                                                <span class="invoice-number">#<?php echo $fact_num?></span>
                                            </h4>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Fecha de Emisiòn:</p>
                                                <p class="invoice-date"><?php echo substr($result[0]->fec_emis,0,10); ?></p>
                                            </div>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Fecha de vencimiento:</p>
                                                <p class="invoice-date"><?php echo substr($result[0]->fec_venc,0,10); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                </div>

                                <hr class="invoice-spacing" />

                                <!-- Address and Contact starts -->
                                <div class="card-body invoice-padding pt-0">
                                    <div class="row invoice-spacing">
                                        <div class="col-xl-10 p-0">
                                            <h6 class="mb-2">Pedido a :</h6>
                                            <h6 class="mb-25"></h6>
                                            <p class="card-text mb-25"><?php echo $result[0]->dato1; ?></p>
                                            <p class="card-text mb-25"><?php echo $result[0]->dato4; ?></p>
                                            <p class="card-text mb-25"><?php echo $result[0]->dato3; ?></p>
                                            <p class="card-text mb-0"><?php echo $result[0]->dato2; ?></p>
                                        </div>
                                        <div class="col-xl-2 p-0 mt-xl-0 mt-2">
                                            <h6 class="mb-2">Detalles del Pago:</h6>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class="pe-1">Sub Total:</td>
                                                        <td><span class="fw-bold"><?php echo $result[0]->tot_bruto; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-1">Iva:</td>
                                                        <td><?php echo $result[0]->iva; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-1">Total:</td>
                                                        <td><?php echo $result[0]->tot_neto; ?></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address and Contact ends -->

                                <!-- Invoice Description starts -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr><th class="py-1">Codigo</th>
                                                <th class="py-1">Descripcion del articulo</th>
                                                <th class="py-1">Cantidad</th>
                                                <th class="py-1">Precio</th>
                                                <th class="py-1">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                             $result2 = $objeto_factura->GetRenglonFactura($fact_num);
                                            $totalArticulos = 0;
                                           // var_dump( $result);
                                           foreach($result2 as $dato){
                                            $co_art = $dato->co_art;
                                            $nombre = $dato->dato1;
                                            $cantidad=  $dato->dato2;
                                            $precio=  $dato->dato3;
                                            $total = $cantidad * $precio;
                                            $totalArticulos = $totalArticulos + $cantidad;
                                            ?>
                                              
                                                <tr class="border-bottom">
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25"><?php echo  $co_art ?></p>
                                                    
                                                </td>
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25"><?php echo  $nombre ?></p>
                                                    
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php echo  $cantidad?></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php echo number_format($precio, 2, ',', '.');?></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"><?php echo number_format($total, 2, ',', '.');?></span>
                                                </td>
                                            </tr>
                                            

                                            <?php
                                           }
                                            ?>                                       
                                           
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-body invoice-padding pb-0">
                                    <div class="row invoice-sales-total-wrapper">
                                        <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                            <p class="card-text mb-0">
                                                <span class="fw-bold">Vendedor:</span> <span class="ms-75"><?php echo $_SESSION['nombre'] ?></span>
                                            </p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                            <div class="invoice-total-wrapper">
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Sub Total:</p>
                                                    <p class="invoice-total-amount"><?php echo $result[0]->tot_bruto; ?></p>
                                                </div>                                               
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Iva:</p>
                                                    <p class="invoice-total-amount"><?php echo $result[0]->iva; ?></p>
                                                </div>
                                                <hr class="my-50" />
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Total:</p>
                                                    <p class="invoice-total-amount"><?php echo $result[0]->tot_neto; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Description ends -->

                                <hr class="invoice-spacing" />

                                <!-- Invoice Note starts -->
                                <div class="card-body invoice-padding pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="fw-bold">Nota:</span>
                                            <span>Fue un placer trabajar con usted y su equipo. Esperamos que nos tenga en cuenta para futuros Pedidos
                                                 ¡Gracias!</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Note ends -->
                            </div>
                        </div>
                        <!-- /Invoice -->

                        <!-- Invoice Actions -->
                        <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                            <div class="card">
                                <div class="card-body">                                    
                                <a class="btn btn-relief-success w-100 mb-75" href="index.php?action=reporte&tipo=5&fact_num=<?php echo $fact_num; ?>&status=<?php echo $status; ?>" target="_blank"> <i data-feather='file-text'></i> Generar Pdf </a>                                  
                              
                                 </div>         
                              
                            </div>
                        </div>
                        <!-- /Invoice Actions -->
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
                                        Este pedido de  <strong>Articulos</strong> no esta lleno correctamente
                                    </p>
                                    <a class="btn-icon btn btn-success" href="./">Volver al home</a>
                                    
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