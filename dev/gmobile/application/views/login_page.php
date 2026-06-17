<!DOCTYPE html>
<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>SACI | Sistama Administrativo</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">

    <style type="text/css">
    	.panel-heading {
    padding: 5px 15px;
}

.panel-footer {
	padding: 1px 15px;
	color: #A0A0A0;
}

.profile-img {
	width: 96px;
	height: 96px;
	margin: 0 auto 10px;
	display: block;
	-moz-border-radius: 50%;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}
    </style>
</head>
<body>  
	<div class="container" style="margin-top:40px">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong> Inicia sesión para continuar</strong>
					</div>
					<div class="panel-body">
						<form method="POST" action="<?php echo base_url(); ?>index.php/user/login">
							<fieldset>
								<div class="row">
									<div class="center-block">
										<img class="profile-img"
											src="<?php echo base_url(); ?>login/img/photo.jpg?sz=120" alt="">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-10  col-md-offset-1 ">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span> 
												<input class="form-control" placeholder="Usuario" name="username" id="username" type="text" required="yes" autocomplete="off" autofocus>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
												<input class="form-control" placeholder="Contraseña" name="pass" id="pass" type="password" value=""  required="yes">
											</div>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="Iniciar">
										</div>
									</div>
								</div>
							</fieldset>
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
					<div class="panel-footer ">
						No tienes una cuenta! <a href="#" onClick=""> Registrate aquí </a>
					</div>
                </div>
			</div>
		</div>
	</div>
</body>
</html>
