<body class="welcome">
    <span id="splash-overlay" class="splash"></span>
  <span id="welcome" class="z-depth-4"></span>

  <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card" style="padding: 1.25rem;background-color: rgba(255,255,255,.8);">
                    <img src="<?php echo base_url(); ?>images/logomorteros.png" style="position: relative; left:15%; top: -10px; width: 70%;">
                    <div class="card-body">
                        <form id="form-login" method="POST" action="<?php echo base_url(); ?>user/login">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" autocomplete="off" required="yes">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña" required="yes">
                            </div>

                            <div class="form-check mb-3">
                                <label class="form-check-label">
                                    <input type="checkbox" name="remember" class="form-check-input">
                                    Recuérdame
                                </label>
                            </div>

                            <div class="row">
                                <div class="col pr-2">
                                    <button type="submit" class="btn btn-block btn-morado">Iniciar sesión</button>
                                </div>
                                <div class="col pl-2">
                                    <a class="btn btn-block btn-link" style="color: #4000FF;" href="javascript:btn_password();">Se te olvidó tu contraseña</a>
                                </div>
                            </div>
                        </form>
                        <?php
                if($this->session->flashdata('error')){
                    ?>
                    <div class="alert alert-danger text-center" style="margin-top:20px;">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                    <?php
                }
            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inicio de cambio de empresa-->
          <div class="modal fade bd-example-modal-sm" id="cambiar_pass" tabindex="-1" role="dialog" aria-labelledby="modalcambiar_bd" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcambiar_pass">Buscar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body4">
                    <div class="card-body" style="padding: 1.25rem;">
                        <form id="formulario_cliente" name="formulario_cliente" method="post">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="nrif">RIF/CI</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="nrif" name="nrif" placeholder="V-" style="text-transform: uppercase;">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="nemail">Correo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-at"></i></div>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="nemail" name="nemail" placeholder="name@example.com" >
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="nusu">Usuario</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="nusu" name="nusu" placeholder="Usuario" style="text-transform: uppercase;">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="npass1">Nueva Contrase&ntilde;a</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-key"></i></div>
                            </div>
                            <input type="password" class="form-control form-control-sm" id="npass1" name="npass1" placeholder="" >
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="npass2">Repetir Nueva Contrase&ntilde;a</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-key"></i></div>
                            </div>
                            <input type="password" class="form-control form-control-sm" id="npass2" name="npass2" placeholder="" >
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        </div>

                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>-->
                    <button type="button" class="btn btn-primary" id="btnaddcli" onclick="cambiar_pass();"><i class="fa fa-save"></i> Cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de cambio de empresa-->

    <script type="text/javascript">
        window.onload = function() {
            setTimeout(function() {
                var audio = new Audio('<?php echo base_url(); ?>audio/chimes.wav');
            audio.play();
            //reset();
            }, 4000);
            setTimeout(function() {
                document.getElementById("username").focus();
            }, 5000);
        }
    </script>