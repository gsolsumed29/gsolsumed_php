<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php  echo APP_NOMBRE ?>">
    <meta name="keywords" content="admin, dashboard , responsive, web app">
    <meta name="author" content="Soluciones Jm">
    <title><?php  echo APP_NOMBRE ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/logo.png">
   <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/page-auth.css">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-wizard.css">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/extensions/ext-component-sweet-alerts.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
  
<?php 
	

?>
       <!-- BEGIN: Content-->
       <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                     <!-- Vertical Wizard -->
                <section class="vertical-wizard">
                    <div class="bs-stepper vertical vertical-wizard-example">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#account-details-vertical" role="tab" id="account-details-vertical-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">1</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Detalles conexion</span>
                                        <span class="bs-stepper-subtitle">Configurar detalles de la conexion</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#personal-info-vertical" role="tab" id="personal-info-vertical-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">2</span>
                                    <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Detalles empresa</span>
                                        <span class="bs-stepper-subtitle">Configurar detalles de la empresa</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#address-step-vertical" role="tab" id="address-step-vertical-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">3</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Identidad</span>
                                        <span class="bs-stepper-subtitle">Logo</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#social-links-vertical" role="tab" id="social-links-vertical-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">4</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Finalizar</span>
                                        <span class="bs-stepper-subtitle"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <div id="account-details-vertical" class="content" role="tabpanel" aria-labelledby="account-details-vertical-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Account Details</h5>
                                    <small class="text-muted">Enter Your Account Details.</small>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-username">Username</label>
                                        <input type="text" id="vertical-username" class="form-control" placeholder="johndoe" />
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-email">Email</label>
                                        <input type="email" id="vertical-email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 form-password-toggle col-md-6">
                                        <label class="form-label" for="vertical-password">Password</label>
                                        <input type="password" id="vertical-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    </div>
                                    <div class="mb-1 form-password-toggle col-md-6">
                                        <label class="form-label" for="vertical-confirm-password">Confirm Password</label>
                                        <input type="password" id="vertical-confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-prev" disabled>
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="personal-info-vertical" class="content" role="tabpanel" aria-labelledby="personal-info-vertical-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Personal Info</h5>
                                    <small>Enter Your Personal Info.</small>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-first-name">First Name</label>
                                        <input type="text" id="vertical-first-name" class="form-control" placeholder="John" />
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-last-name">Last Name</label>
                                        <input type="text" id="vertical-last-name" class="form-control" placeholder="Doe" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-country">Country</label>
                                        <select class="select2 w-100" id="vertical-country">
                                            <option label=" "></option>
                                            <option>UK</option>
                                            <option>USA</option>
                                            <option>Spain</option>
                                            <option>France</option>
                                            <option>Italy</option>
                                            <option>Australia</option>
                                        </select>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-language">Language</label>
                                        <select class="select2 w-100" id="vertical-language" multiple>
                                            <option>English</option>
                                            <option>French</option>
                                            <option>Spanish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="address-step-vertical" class="content" role="tabpanel" aria-labelledby="address-step-vertical-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Address</h5>
                                    <small>Enter Your Address.</small>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-address">Address</label>
                                        <input type="text" id="vertical-address" class="form-control" placeholder="98  Borough bridge Road, Birmingham" />
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-landmark">Landmark</label>
                                        <input type="text" id="vertical-landmark" class="form-control" placeholder="Borough bridge" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="pincode2">Pincode</label>
                                        <input type="text" id="pincode2" class="form-control" placeholder="658921" />
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="city2">City</label>
                                        <input type="text" id="city2" class="form-control" placeholder="Birmingham" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="social-links-vertical" class="content" role="tabpanel" aria-labelledby="social-links-vertical-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Social Links</h5>
                                    <small>Enter Your Social Links.</small>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-twitter">Twitter</label>
                                        <input type="text" id="vertical-twitter" class="form-control" placeholder="https://twitter.com/abc" />
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-facebook">Facebook</label>
                                        <input type="text" id="vertical-facebook" class="form-control" placeholder="https://facebook.com/abc" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-google">Google+</label>
                                        <input type="text" id="vertical-google" class="form-control" placeholder="https://plus.google.com/abc" />
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="vertical-linkedin">Linkedin</label>
                                        <input type="text" id="vertical-linkedin" class="form-control" placeholder="https://linkedin.com/abc" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-success btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /Vertical Wizard -->
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- END: Content-->
    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>

    <script src="app-assets/js/core/app.js"></script>
    <script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="app-assets/vendors/js/extensions/polyfill.min.js"></script>
  
    <!-- END: Theme JS-->
    <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <script src="app-assets/js/scripts/pages/page-auth-login.js"></script>
    <script src="app-assets/js/scripts/forms/form-wizard.js"></script>
    <!-- END: Page JS-->

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