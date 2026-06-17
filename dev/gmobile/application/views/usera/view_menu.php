<div class="card-body">
    <ul class="list-group">
            
                  <?php 
                $m=0;
                $comillas="'";
                foreach($menu as $rowm){ 
                    echo '<li class="list-group-item active">';
                    $validar_menu=$this->usera_model->validar_menu($idusuario,$rowm->id_menu);
                    if($validar_menu->si > 0){ 
                        echo '<input type="checkbox" name="checkbox_menu" id="checkbox_menu" onchange="cambiarmenu(this.value,'.$comillas.$idusuario.$comillas.',this)" value="'.$rowm->id_menu.'" style="border:0" checked>'; 
                    }else{ 
                        echo '<input type="checkbox" name="checkbox_menu" id="checkbox_menu" onchange="cambiarmenu(this.value,'.$comillas.$idusuario.$comillas.',this)" value="'.$rowm->id_menu.'" style="border:0">';
                    } 
                    echo $rowm->menu;
                    echo '</li>';
                    $submenu=$this->usera_model->get_submenu($rowm->id_menu);
                    foreach($submenu as $rows){ 
                        echo '<li class="list-group-item">';
                        $validar_submenu=$this->usera_model->validar_submenu($idusuario,$rowm->id_menu,$rows->id_submenu);
                    if($validar_submenu->si > 0){ 
                        echo '<input type="checkbox" name="checkbox_submenu" id="checkbox_submenu" onchange="cambiarsubmenu(this.value,'.$comillas.$idusuario.$comillas.','.$rowm->id_menu.',this)" value="'.$rows->id_submenu.'" style="border:0" checked>'; 
                    }else{ 
                        echo '<input type="checkbox" name="checkbox_submenu" id="checkbox_submenu" onchange="cambiarsubmenu(this.value,'.$comillas.$idusuario.$comillas.','.$rowm->id_menu.',this)" value="'.$rows->id_submenu.'" style="border:0">';
                    } 
                        echo $rows->submenu;
                        echo '</li>';
                    }
                }?> 
                </ul>
          </div>