<div class="card-body">
    <ul class="list-group">
            
                  <?php 
                $m=0;
                $comillas="'";
                foreach($empresas as $row){ 
                    echo '<li class="list-group-item ">';
                    echo '<table style="width:100%;"><tr><td>';
                    $validar_menu=$this->usera_model->validar_empresa($idusuario,$row->idemp);
                    if($validar_menu->si > 0){ 
                        echo '<input type="checkbox" name="checkbox_menu" id="checkbox_menu" onchange="asigemp2(this.value,'.$comillas.$idusuario.$comillas.',this)" value="'.$row->idemp.'" style="border:0" checked>'; 
                    }else{ 
                        echo '<input type="checkbox" name="checkbox_menu" id="checkbox_menu" onchange="asigemp2(this.value,'.$comillas.$idusuario.$comillas.',this)" value="'.$row->idemp.'" style="border:0">';
                    } 
                    //echo '&nbsp;&nbsp;'.$row->empresa;
                    echo '</td><td><input type="text" class="form-control" id="idemp" name="idemp" placeholder="Empresa" value="'.$row->empresa.'" data-toggle="tooltip" title="" data-original-title="Empresa" readonly></td>';

                    echo '<td><div class="input-group">
                                <input type="text" class="form-control" id="cvendedor" name="cvendedor" placeholder="Vendedor" value="'.trim($row->co_ven).'" data-toggle="tooltip" title="" data-original-title="Vendedor" ><div class="input-group-append">
                                    <button type="button" class="btn btn-success" id="btnsavecven" onclick="cambiar_vendedor('.$comillas.$idusuario.$comillas.','.$comillas.$row->idemp.$comillas.');" data-toggle="tooltip" data-original-title="Guardar Codigo del Vendedor"><i class="fa fa-play-circle"></i></button>
                                </div></div></td></tr></table>';
                    echo '</li>';

                }?> 
                </ul>
          </div>