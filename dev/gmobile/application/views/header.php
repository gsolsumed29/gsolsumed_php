<body>
	<?php
				$user = $this->session->userdata('user');
				extract($user);
                $empbd=$this->session->userdata('empbd');
                $co_ven = $this->session->userdata('co_ven');
                $menu=$this->users_model->get_menu($idusuario);
			?>
	<body class="bg-light">
        
    <nav class="navbar navbar-expand navbar-dark barrav9">
        <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
        <a class="navbar-brand" href="<?php echo base_url(); ?>">GMobile</a><h5 class="modal-title" style="color: #FFFFFF" id="titlemodule"> </h5>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
               <!-- <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-envelope"></i> 5</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-bell"></i> 3</a></li>-->
                <li class="nav-item dropdown">
                    <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown" style="color: #FFFFFF"><i class="fa fa-user"></i> </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                        <a href="#" class="dropdown-item"><span class="badge badge-primary"><i class="fa fa-user"></i> <?php echo $nombre;?></span></a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:btn_cambiarbd();" class="dropdown-item"><i class="fas fa-building"></i> Cambiar empresa</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url(); ?>user/logout" class="dropdown-item"><i class="fas fa-power-off"></i> Desconectar</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar sidebar-dark sidebarv9">
            <ul class="list-unstyled">
                <li class="active"><a href="<?php echo base_url(); ?>home"><i class="fa fa-fw fa-tachometer-alt"></i> DASHBOARD (<?php echo $empbd; ?>) - <?php echo trim($co_ven);?></a></li>
                <?php 
                $m=1;
                foreach($menu as $rowm){
                    echo '<li>';
                    echo '<a href="#sm_base'.$m.'" data-toggle="collapse">';
                    echo '<i class="fas '.$rowm->icon.'"></i> ';
                    echo $rowm->menu;
                    echo '</a>';
                    $submenu=$this->users_model->get_submenu($idusuario,$rowm->id_menu);
                    if(count($submenu) > 0){ echo '<ul id="sm_base'.$m.'" class="list-unstyled collapse">'; 
                    foreach($submenu as $rows){ 
                        echo '<li><a href="'.base_url().''.$rows->url.'">'.$rows->submenu.'</a></li>';
                         }
                         echo '</ul>';
                         }
                    echo '</li>';
                    $m++;
                }?> 
                
               
            </ul>
        </div>
