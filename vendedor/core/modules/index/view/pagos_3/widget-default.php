  <!-- BEGIN: Content-->
    <div class="app-content content  m_pagos">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Pagos </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=cobros">Cobros</a>
                                    </li>
                                    <li class="breadcrumb-item active"> <span class="s" id="s" style="display:none"><?php echo $_GET['s']?></span> Pagos realizados
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="content-body">             
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                     <!-- Developer Meetup Card -->
                        <div class="col-lg-6 col-md-6 col-12" id="busqueda" style="display:"  >
                            <div class="card card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                                </div>
                                <div class="card-body"> 
                                    
                                            <select class="select2 form-select comboClientesPagos" id="select2-basic-comboClientesPagos" name="comboClientesPagos" style="width:100%">
                                                        <option value="0" selected>Seleccione cliente</option>
                                            </select>
                                    
                                </div>
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                     
                        <!-- Company Table Card -->
                        <div class="col-lg-8 col-12" id="pagos" style="display:none" >
                            <input class="dataPagos" type="hidden" id="dataPagos" value="">
                      
                            <!-- Basic table -->
                            <section id="basic-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <table class="dataTablesPagos table" id="dataTablesPagos">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>                                                       
                                                        <th></th>
                                                        <th></th>                                                     
                                                        <th></th>                                                    
                                                        <th></th>   
                                                        <th></th> 
                                                        <th></th>                                                                                   
                                                        <th></th>      
                                                        <th></th>          
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
                </section>

            </div>
        </div>
    </div>

