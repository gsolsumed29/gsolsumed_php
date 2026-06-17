
<table id="result_search_cli" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>RIF</th>
                    <th>NOMBRE</th>
                    <th class="actions">Acci&oacute;n</th>
                </tr>
                </thead>
                <tbody>
                	<?php 

                        foreach($clientes as $row1){ ?>
                        	<tr data-toggle="tooltip" title="" data-original-title="<?php echo trim($row1->cli_des); ?>" onclick="seleccionar_cli('<?php echo trim($row1->rif);?>');">
                    <td><?php echo trim($row1->co_cli); ?></td>
                    <td><?php echo trim($row1->rif); ?></td>
                    <td><?php echo trim($row1->cli_des); ?></td>
                    
                    <td>
                    	<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Seleccionar" onclick="seleccionar_cli('<?php echo trim($row1->rif);?>');"><i class="fa fa-share"></i></button>
                    </td>
                </tr>
                           <?php
                        }
                        ?>
                
                
                </tbody>
            </table>
       