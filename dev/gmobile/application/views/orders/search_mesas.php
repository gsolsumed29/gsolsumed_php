<div class="card-body">
<table id="result_search_cli" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th class="actions">Acci&oacute;n</th>
                </tr>
                </thead>
                <tbody>
                	<?php 
                        foreach($mesas as $row1){ ?>
                        	<tr data-toggle="tooltip" title="" data-original-title="<?php echo trim($row1->nombre); ?>">
                    <td><?php echo trim($row1->codigo); ?></td>
                    <td><?php echo trim($row1->nombre); ?></td>
                    
                    <td>
                    	<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Seleccionar" onclick="seleccionar_mesa('<?php echo trim($row1->codigo);?>','<?php echo trim($row1->nombre);?>');"><i class="fa fa-share"></i></button>
                    </td>
                </tr>
                           <?php
                        }
                        ?>
                
                
                </tbody>
            </table>
          </div>