<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="jmobile ver 1.0">
    <meta name="keywords" content="admin, dashboard , responsive, web app">
    <meta name="author" content="Soluciones Jm">
    <title id="name2"></title>
    <link rel="apple-touch-icon" href="../app-assets/images/ico/logo.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/jstree.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/wizard/bs-stepper.min.css">

    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/tether-theme-arrows.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/tether.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/shepherd.min.css">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/semi-dark-layout.css">
 <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/form-wizard.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">

    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/app-file-manager.css">
    <!-- END: Page CSS-->
    <!-- BEGIN: Page CSS-->

    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/extensions/ext-component-toastr.css">

    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/pickers/form-pickadate.css">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/extensions/ext-component-sweet-alerts.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/page-profile.css">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/app-invoice.css">
    <!--<link rel="stylesheet" type="text/css" href="../app-assets/css/pages/app-invoice-print.css"> -->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/extensions/ext-component-sliders.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/app-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/form-wizard.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static   menu-collapsed user localizacion" data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">        
        <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                    <li>
                        <!-- Logo responsivo que reemplaza el nombre de usuario -->
                        <a href="#" class="logo-link">
                            <img  src="../app-assets/images/ico/logo_nav_bar.webp"
                                alt="Logo de la empresa" 
                                class="brand-logo"
                                id="brand-logo">
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">

                <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modals-slide-in-configuracion" title="Configuracion"><i class="ficon" data-feather='settings'></i></a></li> -->
                
                   
                    <li class="nav-item"><a href="index.php?view=pedido" class="nav-link"><i class="ficon" data-feather='plus-circle'></i></a></li>
                    <li class="nav-item"><a href="index.php?view=realizar" class="nav-link"><i class="ficon" data-feather="shopping-cart"></i><span class="badge rounded-pill bg-primary badge-up cart-item-count" style="display:none"></span></a></li>
                    
                </li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?php  if(isset($_SESSION['nombre'])){
            echo $_SESSION['nombre'];
        }else{
        Action::execute("salir",array());
        }?></span><span class="user-status"><?php  echo $_SESSION['nombreUsuario']?></span><span class="badge rounded-pill bg-primary badge-up identificacion" ><?php  echo $_SESSION['identidad']?> </span></div><span class="avatar"><img class="round" src="../app-assets/images/portrait/small/admin.png" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                            <a class="dropdown-item" href="#" style="display:none">
                             <i class="me-50" data-feather='circle'></i><span class="co_alma" ><?php  echo $_SESSION['co_alma']?></span>
                            </a>   
                            <a class="dropdown-item" href="#">
                             <i class="me-50" data-feather='user'></i><span class="" ><?php  echo $_SESSION['nombre']?></span>
                             </a>   
                            <span class="lon" style="display:none">0</span>
                            <span class="lat" style="display:none">0</span>
                            <a class="dropdown-item" href="#" style="display:none">
                             <i class="me-50" data-feather='circle'></i><span class="almacen"><?php  echo $_SESSION['almacen']?></span>
                            </a>    
                                               
                            <a class="dropdown-item"  href="javascript:void(0)"  id ="salir">
                                <i class="me-50" data-feather="power"></i> Salir
                            </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="./">
                    <img class="logo_aurora_layaut" src="../app-assets/images/ico/logo_solo.png" alt="jmobile ver 1.0">
                        
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item i_dashboard"><a class="d-flex align-items-center" href="./"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Inicio</span></a>    
                </li>
                <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Menú</span><i data-feather="more-horizontal"></i>
                </li>
             
             



                
                <!--
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='trending-up'></i><span class="menu-title text-truncate" data-i18n="User">Cotizacion</span></a>
                    <ul class="menu-content">
                        <li class="i_visitas"><a class="d-flex align-items-center" href="index.php?view=visitas"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Nueva</span></a>
                        </li>                      
                    </ul>
                </li>
                 -->
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='calendar'></i><span class="menu-title text-truncate" data-i18n="User">Visitas</span></a>
                    <ul class="menu-content">
                        <li class="i_visitas"><a class="d-flex align-items-center" href="index.php?view=visitas"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Consultar</span></a>
                        </li>                      
                       
                    </ul>
                </li>
                
               
                
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

          <?php 
  // puedo cargar otras funciones iniciales
  // dentro de la funcion donde cargo la vista actual
  // como por ejemplo cargar el corte actual
if(isset($_SESSION["logged_in"])){
  View::load("dashboard");
}else{
  Action::execute("salir",array());
}
?>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

  <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2023<a class="ms-25" href="#" target="_blank">Soluciones Jm</a><span class="d-none d-sm-inline-block">, Reservados todos los derechos</span></span><span class="float-md-end d-none d-md-block">jmobile ver 3.0</span></p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->         
   
    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
    <script src="../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="../app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    
    <!-- END: Theme JS-->
    <script src="../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <!-- BEGIN: Page JS-->
    <!--<script src="../app-assets/js/scripts/pages/dashboard-ecommerce.js"></script> -->
    <script src="../app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="../app-assets/vendors/js/forms/cleave/addons/cleave-phone.ve.js"></script>

    <script src="../app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="../app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="../app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="../app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="../app-assets/vendors/js/pagination/jquery.bootpag.min.js"></script>
    <script src="../app-assets/vendors/js/pagination/jquery.twbsPagination.min.js"></script>
    <script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page JS-->
        <!-- BEGIN: Page Vendor JS-->

    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/forms/form-select2.js"></script>
    <!-- END: Page JS-->
    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/forms/pickers/form-pickers.js"></script>
    <script src="../app-assets/js/scripts/forms/form-input-mask.js"></script>
    <!-- END: Page JS-->
    <script src="js/ajax.js"></script>
    <script src="js/html.js"></script>
    <!-- TODOS LOS DATABLES -->
        <!-- BEGIN: Page Vendor JS-->

    <script src="../app-assets/vendors/js/charts/chart.min.js"></script>

    <script src="../app-assets/vendors/js/extensions/tether.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/shepherd.min.js"></script>
    <script src="../app-assets/js/scripts/forms/form-wizard.js"></script>
    <!-- END: Page Vendor JS-->
        <!-- BEGIN: Page JS-->
    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/extensions/ext-component-tour.js"></script>
    <script src="../app-assets/vendors/js/extensions/wNumb.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/nouislider.min.js"></script>
    <script src="../app-assets/js/scripts/pages/app-file-manager.js"></script>

    <script src="../app-assets/vendors/js/amCharts/core.js"></script>
    <script src="../app-assets/vendors/js/amCharts/charts.js"></script>
    <script src="../app-assets/vendors/js/amCharts/themes/animated.js"></script>

    <script src="js/table-datatables.js"></script>
    <script src="../app-assets/js/scripts/forms/form-number-input.js"></script>
    <script src="../app-assets/js/scripts/pages/app-ecommerce-checkout.js"></script>
    <script src="../app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
   
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })  
    </script>

</body>
<!-- END: Body-->

</html>