<?php
$user = $this->session->userdata('user');
                extract($user);
                $co_ven = $this->session->userdata('co_ven');
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
                    <th><input type="checkbox" onclick="marcar(this);" id="marco" /> Todos</th>
                    <th>Fecha</th>
                    <th style="text-align: right;">Monto</th>
                    <th style="text-align: right;">Saldo</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=1;
                    $b=0;
                    $adelantos=0;
                    $facturas=0;
                    $adelantoss=0;
                    $facturass=0;
                        foreach($cxc as $row){ ?>
                            <tr data-toggle="tooltip" title="" data-original-title="<?php echo trim($row->tipo_doc).' / '.trim($row->serie).''.trim($row->fact); ?>">
                                <td>
                        <?php
                        if($row->tipo_doc == 'ADEL' OR $row->tipo_doc == 'N/CR' OR $row->tipo_doc == 'ISLR' OR $row->tipo_doc == 'AJNM' OR $row->tipo_doc == 'AJNA'){
                            $adelantos=($adelantos + $row->monto_net);
                            $adelantoss=($adelantoss + $row->saldo);
                        }else{
                            $facturas=($facturas + $row->monto_net);
                            $facturass=($facturass + $row->saldo);
                        $var=$row->tipo_doc.'~'.$row->nro_doc;
                            
                                echo "<input type=\"hidden\" size=\"40\" name=\"nombre$i\" value=\"$var\">";
                                echo "<input type=\"checkbox\" class=\"checkbox1\" name=\"seleccion$i\" value=\"$row->nro_doc\">";
                                $b++;
                                $i++;
                            }
                        ?>
                    </td>
                                <td><?php echo trim($row->tipo_doc).' / '.trim($row->serie).''.trim($row->fact).'<br>'.trim($row->fec_emis); ?></td>
                                <td style="text-align: right;<?php if($row->tipo_doc == 'ADEL' OR $row->tipo_doc == 'N/CR' OR $row->tipo_doc == 'ISLR' OR $row->tipo_doc == 'AJNM' OR $row->tipo_doc == 'AJNA'){ echo 'color:#088A08;'; }else{ echo 'color:#DF0101;'; } ?>"><?php echo number_format($row->monto_net,2,',','.'); ?></td>
                                <td style="text-align: right;"><?php echo number_format($row->saldo,2,',','.'); ?></td>
                            </tr>
                           <?php
                        }
                        ?>
                <tr>
                    <th colspan="2" style="text-align: right;">Totales</th>
                    <th style="text-align: right;<?php if(($adelantos - $facturas) > 0){ echo 'color:#088A08;'; }else{ echo 'color:#DF0101;'; } ?>"><?php echo number_format(($adelantos - $facturas),2,',','.'); ?></th>
                    <th style="text-align: right;<?php if(($adelantoss - $facturass) > 0){ echo 'color:#088A08;'; }else{ echo 'color:#DF0101;'; } ?>"><?php echo number_format(($adelantoss - $facturass),2,',','.'); ?></th>
                </tr>
                
                </tbody>
            </table>
            <input type="hidden" id="cant" name="cant" value="<?php echo $b;?>">
            <input type="hidden" id="idusuario" name="idusuario" value="<?php echo $co_ven; ?>">
        </form>
          </div>