


<!doctype html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Grupo Solsumed, CA</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="core/assets/images/favicon.ico">      

      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="core/assets/css/core/libs.min.css">
      
      
      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="core/assets/css/hope-ui.min.css?v=4.0.0">
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="core/assets/css/custom.min.css?v=4.0.0">
      
      <!-- Dark Css -->
      <link rel="stylesheet" href="core/assets/css/dark.min.css">
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="core/assets/css/customizer.min.css">
      
      <!-- RTL Css -->
      <link rel="stylesheet" href="core/assets/css/rtl.min.css">

       <!-- Añadir Swiper CSS para el carrusel -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
      
      <style>
         /* Estilos para el spinner de carga */
               .login-spinner {
                     display: none;
                     text-align: center;
                     margin-top: 1rem;
                     opacity: 0;
                     transition: opacity 0.3s ease;
               }
               
               .login-spinner.active {
                     display: block;
                     opacity: 1;
               }


               
        /* Estilos para el contenedor de mensajes */
        .login-message-container {
            margin-bottom: 1rem;
            border-radius: 0.357rem;
            padding: 0.8rem 1rem;
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .login-message-container.error {
            background-color: rgba(248, 215, 218, 0.9);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .login-message-container.success {
            background-color: rgba(212, 237, 218, 0.9);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .login-message-container.warning {
            background-color: rgba(255, 243, 205, 0.9);
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .login-message-container.info {
            background-color: rgba(209, 236, 241, 0.9);
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .login-message-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        .login-message-icon {
            margin-right: 0.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

      </style>
         <style>

            
        /* Estilos para el banner interactivo */
        .banner-slider {
            height: 100%;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            position: relative;
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 6s ease;
        }

        .swiper-slide-active img {
            transform: scale(1.1);
        }

        .slide-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 3rem 2rem;
            background: linear-gradient(to top, rgba(6, 89, 214, 0.8), transparent);
            color: white;
            transform: translateY(100%);
            transition: transform 0.8s ease;
            z-index: 10;
        }

        .swiper-slide-active .slide-content {
            transform: translateY(0);
        }

        .slide-content h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: white;
        }

        .slide-content p {
            font-size: 1rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .slide-btn {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: #007FFF;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .slide-btn:hover {
            background: transparent;
            border-color: white;
            color: white;
        }

        /* Navegación del slider */
        .swiper-button-prev,
        .swiper-button-next {
            color: white;
            background: rgba(0, 127, 255, 0.3);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            background: rgba(0, 127, 255, 0.8);
        }

        .swiper-button-prev:after,
        .swiper-button-next:after {
            font-size: 1.2rem;
        }

        /* Paginación */
        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: white;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #007FFF;
            transform: scale(1.2);
        }

        /* Ajustes responsive */
        @media (max-width: 768px) {
            .slide-content h3 {
                font-size: 1.2rem;
            }
            
            .slide-content p {
                font-size: 0.8rem;
            }
            
            .slide-btn {
                padding: 0.3rem 1rem;
                font-size: 0.8rem;
            }
            
            .swiper-button-prev,
            .swiper-button-next {
                width: 30px;
                height: 30px;
            }
        }

  #loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ffffff;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease, visibility 0.5s;
}

/* Contenedor del spinner y texto */
.spinner-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px; /* Espacio entre la animaciòn y el texto */
}

/* Estilos del Logo SVG */
.spinner-logo {
    width: 120px; /* Ajusta el tamao segùn tu imagen */
    height: auto;
    animation: pulseLogo 1.5s ease-in-out infinite;
}

@keyframes pulseLogo {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

/* Mantenemos la animaciòn de los anillos (del còdigo anterior) */
.spinner-wrapper {
    position: relative;
    width: 60px;
    height: 60px;
}

.spinner-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 4px solid transparent;
    border-top-color: #004c99;
    animation: spin 1s linear infinite;
}

.spinner-ring::before {
    content: "";
    position: absolute;
    top: 8px;
    left: 8px;
    right: 8px;
    bottom: 8px;
    border-radius: 50%;
    border: 4px solid transparent;
    border-top-color: #15e1dd;
    animation: spin 2s linear infinite reverse;
}

.spinner-ring::after {
    content: "";
    position: absolute;
    top: 24px;
    left: 24px;
    right: 24px;
    bottom: 24px;
    border-radius: 50%;
    background-color: #99b5da;
    animation: pulse 1.5s ease-in-out infinite;
}

.loading-text {
    margin-top: 10px;
    font-size: 0.5rem;
    font-weight: 400;
    color: #004c99;
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;
    animation: fadeIn 1.5s ease-in-out;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes pulse {
    0% { transform: scale(0.5); opacity: 0.5; }
    50% { transform: scale(1); opacity: 1; }
    100% { transform: scale(0.5); opacity: 0.5; }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
    </style>
  </head>
 <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
 <div class="loader" id="loading">
    <div class="spinner-container">
        <!-- AQUÌ INSERTA EL CÒDIGO SVG DE TU ISOTIPO COMPLETO -->
        <!-- Pega aquì todo el contenido del archivo "logo.svg" dentro de la etiqueta img -->
        
        
        <!-- Animaciòn de los anillos por detrès del logo -->
        <div class="spinner-wrapper">
            <div class="spinner-ring"></div>
        </div>
        
        <div class="loading-text"> <p class ="align-text-center "> Grupo solsumed <br> Unidos por tu salud </p></div>
    </div>
</div>
    
    
      <div class="wrapper">
      <section class="login-content">
         <div class="row m-0 align-items-center bg-white vh-100">            
            <div class="col-md-6 d-md-block d-none bg-primary p-0 m-0 vh-100 overflow-hidden position-relative">
                <!-- Banner interactivo con Swiper -->
                <div class="banner-slider">
                    <div class="swiper-container banner-swiper">
                        <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="assets/media/1_back.png" alt="Distribución de insumos médicos">
                                    <div class="slide-content">
                                        <h3>Somos Grupo Solsumed</h3>
                                        <p>Distribuidores e importadores de insumos médicos en Venezuela representantes oficiales de la marca Bialy en Venezuela.</p>
                                        <a href="https://www.instagram.com/bialyvzla/" class="slide-btn" >@Bialy</a>
                                    </div>
                                </div>

                                <!-- Slide 2 - Enfocado en equipos médicos especializados -->
                                <div class="swiper-slide">
                                    <img src="assets/media/1_back.png" alt="Equipos médicos especializados">
                                    <div class="slide-content">
                                        <h3>Insumos Médicos de Alta Calidad</h3>
                                        <p>Equipamos al sector salud con suministros esenciales para optimizar el diagnóstico y asegurar un cuidado del paciente con los más altos estándares.</p>
                                        <a href="https://gruposolsumed.com/catalogo" target="_blank" class="slide-btn">Catálogos</a>
                                    </div>
                                </div>

                                <!-- Slide 3 - Enfocado en alianzas estratégicas -->
                                <div class="swiper-slide">
                                    <img src="assets/media/1_back.png" alt="Alianzas con el sector salud">
                                    <div class="slide-content">
                                        <h3>Compromiso Logístico de Alcance Nacional</h3>
                                        <p>Nuestra sólida red de distribución asegura el abastecimiento oportuno de insumos médicos en cada rincón del país, garantizando continuidad en la atención de salud.</p>
                                        <a href="#" class="slide-btn">Ver</a>
                                    </div>
                                </div>

                                <!-- Slide 4 - Enfocado en servicio y entrega -->
                                <div class="swiper-slide">
                                    <img src="assets/media/1_back.png" alt="Entrega oportuna">
                                    <div class="slide-content">
                                        <h3>Aliados Estratégicos en el Sector Salud</h3>
                                        <p>Somos el enlace de confianza para laboratorios, casas médicas y farmacias, asegurando el abastecimiento de insumos medicos.</p>
                                        <a href="https://gruposolsumed.com/contacto" class="slide-btn">Contáctanos</a>
                                    </div>
                                </div>

                                <!-- Slide 5 - Enfocado en variedad de productos -->
                                <div class="swiper-slide">
                                    <img src="assets/media/1_back.png" alt="Amplio portafolio de insumos">
                                    <div class="slide-content">
                                        <h3>Contamos con un amplio Portafolio de Insumos Médicos</h3>
                                        <p>Desde materiales de curación básicos hasta insumos de alta especialidad, ofrecemos soluciones completas para satisfacer todas las necesidades operativas de su institución.</p>
                                        <a href="#" class="slide-btn">Explorar productos</a>
                                    </div>
                                </div>
                            
                         
                        </div>
                        
                        <!-- Botones de navegación -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        
                        <!-- Paginación -->
                        <div class="swiper-pagination"></div>
                        
                        <!-- Barra de progreso -->
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>   
         <div class="col-md-6">
               <div class="row justify-content-center">
                  <div class="col-md-10">
                     <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                        <div class="card-body">
                           <a href="./" class="navbar-brand d-flex align-items-center mb-3" style="justify-content: center">
                              
                              <!--Logo start-->
                              <div class="logo-main">
                                  <div class="logo-normal">
                                     
                 <img src="app-assets/images/pages/logo_texto_grupo_solsumed.webp" alt="Logo Grupo solsumed" class="img-fluid" style="max-width: 300px;">
                                  </div>
                     </div>
            
                                                        
                              </div>
                              <!--logo End-->                                      
                           </a>
                         
                           <p class="text-center">Ingresa los datos para entrar en tu cuenta.</p>

                           <!-- Contenedor para mensajes -->
                           <div id="login-message-container" class="login-message-container">
                              <div class="login-message-title">
                                 <span class="login-message-icon"></span>
                                 <span class="login-message-title-text"></span>
                              </div>
                              <div class="login-message-text"></div>
                           </div>


                           <form class="auth-login-form" id="loginform" action="#" method="POST">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="user" class="form-label">Usuario / Cliente</label>
                                       <input type="text" class="form-control" id="login-email" aria-describedby="user" placeholder=" ">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="password" class="form-label">Contraseña</label>
                                       <input type="password" class="form-control" id="login-password" aria-describedby="password" placeholder=" ">
                                    </div>
                                 </div>
                                 <div class="col-lg-12 d-flex justify-content-between">
                                    <div class="form-check mb-3">
                                       <input type="checkbox" class="form-check-input" id="customCheck1">
                                       <label class="form-check-label" for="customCheck1">Recuerdame</label>
                                    </div>
                                    <a href="index.php?view=forgot">¿Olvidaste tu contraseña?</a>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-center">
                                 <button type="submit" class="btn btn-primary" id="login-button">Iniciar Sesión</button>
                              </div>  
                              <!-- Spinner de carga -->
                              <div class="login-spinner" id="loginSpinner">
                                 <div class="spinner-border text-primary" role="status">
                                       <span class="visually-hidden">Cargando...</span>
                                 </div>
                                 <p class="mt-2">Verificando credenciales...</p>
                              </div>                           
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sign-bg">
                 <svg width="206" height="234" viewBox="0 0 206 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <mask id="mask0_146_2" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="206" height="234">
                  <rect y="9.15527e-05" width="206" height="233.221" fill="#ECF3FD"/>
                  </mask>
                  <g mask="url(#mask0_146_2)">
                  <path d="M119.686 -25.7873C120.813 -26.3448 121.201 -26.238 121.797 -25.1361C122.461 -23.8071 123.063 -22.3913 123.557 -20.9702C125.652 -14.6634 125.798 -8.19896 124.273 -1.67413C121.366 10.9288 114.54 21.1672 104.229 29.3343C102.027 31.0541 99.6275 32.5112 97.1618 33.8459C75.098 45.7893 52.9917 57.7556 30.928 69.699C24.7637 73.0357 20.403 77.8765 18.2777 84.4096C15.6402 92.4336 16.6821 99.9435 21.9119 106.559C24.56 109.927 28.2574 111.884 32.6013 112.698C45.1178 115.105 57.6768 117.489 70.1932 119.896C77.0754 121.236 83.978 122.513 90.8381 123.813C94.2792 124.483 96.3783 127.041 96.2805 130.313C96.2118 132.725 95.1062 134.643 92.9176 135.88C91.5368 136.68 90.1544 137.376 88.7515 138.135C75.7003 145.2 62.6491 152.265 49.6404 159.306C47.3022 160.572 47.1814 161.06 48.609 163.189C50.8948 166.701 54.191 169.033 58.0756 170.624C65.4555 173.595 73.1337 173.766 80.9535 172.066C84.2012 171.364 87.2908 170.166 90.2241 168.578C105.273 160.432 120.365 152.263 135.414 144.116C144.98 138.939 149.576 128.746 146.714 118.686C144.966 112.613 140.992 108.115 135.75 104.726C132.544 102.662 129.008 101.41 125.203 100.778C107.662 97.9249 90.1641 95.0484 72.6456 92.2358C70.7755 91.9288 69.1383 91.443 67.9553 89.867C66.203 87.5437 66.5984 84.1107 68.9265 82.2172C69.4979 81.7496 70.1135 81.3636 70.7512 81.0184C85.3328 73.1252 99.9145 65.232 114.496 57.3389C116.877 56.0502 119.397 55.4249 122.102 55.6493C134.425 56.6833 146.298 59.1214 157.505 64.0842C163.205 66.5923 168.569 69.4938 173.054 73.8203C175.842 76.533 178.099 79.5856 180.018 82.927C182.864 87.9825 185.691 93.1018 188.41 98.2263C191.062 103.228 193.587 108.3 195.41 113.698C200.746 129.649 198.286 144.701 188.393 158.922C182.671 167.138 175.377 173.566 166.47 178.335C147.231 188.591 95.9885 216.698 89.3517 219.974C66.9957 231.073 40.0655 225.598 24.9316 206.983C22.9855 204.606 21.2723 202.05 19.8143 199.357C4.06266 170.258 -11.7536 141.141 -27.4627 112.019C-39.3652 90.3351 -33.2438 62.8525 -13.1954 46.8813C-10.5068 44.7399 -4.66721 41.2095 -4.66721 41.2095C-4.66721 41.2095 119.473 -25.6723 119.686 -25.7873Z" fill="#007FFF" fill-opacity="0.03"/>
                  </g>
                  </svg>
               </div>
            </div>

         
           
         </div>
      </section>
      </div>
     <!-- BEGIN: Vendor JS-->
      
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- END Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
<!-- Asegúrate de que jQuery está cargado primero (ya lo tienes) -->

<!-- Agrega el plugin de validación -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<!-- A veces es necesario agregar los métodos adicionales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>



    <!-- Library Bundle Script -->
    <script src="core/assets/js/core/libs.min.js"></script>
    
    <!-- External Library Bundle Script -->
    <script src="core/assets/js/core/external.min.js"></script>
    

    
    <!-- mapchart Script -->
    <script src="core/assets/js/charts/vectore-chart.js"></script>

    
    
    <!-- fslightbox Script -->
    <script src="core/assets/js/plugins/fslightbox.js"></script>
    
    <!-- Settings Script -->
    <script src="core/assets/js/plugins/setting.js"></script>
    
    <!-- Slider-tab Script -->
    <script src="core/assets/js/plugins/slider-tabs.js"></script>
    

    
    <!-- AOS Animation Plugin-->
    
    <!-- App Script -->
    <script src="core/assets/js/hope-ui.js" defer></script>    
    <script src="core/assets/js/index.js" ></script>
    <script>
     // Inicializar el slider
         document.addEventListener('DOMContentLoaded', function() {
        // Ocultar el loader después de 2 segundos
        setTimeout(function() {
            document.getElementById('loading').style.opacity = '0';
            setTimeout(function() {
                document.getElementById('loading').style.visibility = 'hidden';
            }, 500);
        }, 2000);

        // Inicializar Swiper
        const swiper = new Swiper('.banner-swiper', {
            // Opciones del slider
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            speed: 1000,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            
            // Navegación
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            
            // Paginación
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            
            // Scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
                hide: true,
            },
            
            // Keyboard control
            keyboard: {
                enabled: true,
            },
            
            // Mousewheel control
            mousewheel: {
                invert: false,
            },
            
            // Parallax effect
            parallax: true,
        });

        // Pausar autoplay cuando el mouse está sobre el slider
        const bannerSlider = document.querySelector('.banner-slider');
        bannerSlider.addEventListener('mouseenter', function() {
            swiper.autoplay.stop();
        });
        
        bannerSlider.addEventListener('mouseleave', function() {
            swiper.autoplay.start();
        });
        });

    </script>
  </body>
</html>