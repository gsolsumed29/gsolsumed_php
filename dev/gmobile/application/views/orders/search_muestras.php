<?php
                $user = $this->session->userdata('user');
                extract($user);
            ?>
<script type="text/javascript">
    function marcar(source) 
    {
        checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
        {
            if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
            {
                if(document.getElementById("marco").checked){
                    checkboxes[i].checked=1;
                }else{
                    checkboxes[i].checked=0;
                }
                //checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
            }
        }
    }
</script>
<div class="card-body">
    <form id="formulario_muestra" name="formulario_muestra" method="post">
<table id="result_search_cli" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th class="actions"><input type="checkbox" onclick="marcar(this);" id="marco" /> Todos</th>
                </tr>
                </thead>
                <tbody>
                	<?php 
                    $i=1;
                    $b=0;
                        foreach($muestras as $row1){ ?>
                        	<tr data-toggle="tooltip" title="" data-original-title="<?php echo $row1->Nom_exa; ?>">
                    <td><?php echo $row1->codigo; ?></td>
                    <td><?php echo $row1->Nom_exa; ?></td>
                    
                    <td>
                        <?php
                        $var=$row1->codfactura.'~'.$row1->codigo;
                            if($row1->status == 0){
                                echo "<input type=\"hidden\" size=\"40\" name=\"nombre$i\" value=\"$var\">";
                                echo "<input type=\"checkbox\" class=\"checkbox1\" name=\"seleccion$i\" value=\"si\">";
                                $b++;
                                $i++;
                            }else{
                                echo "Muestra Tomada";
                            }
                        ?>
                    </td>
                </tr>
                           <?php
                           
                        }
                        ?>
                
                
                </tbody>
            </table>
            <input type="hidden" id="cant" name="cant" value="<?php echo $b;?>">
            <input type="hidden" id="idusuario" name="idusuario" value="<?php echo $idusuario; ?>">
        </form>
          </div>