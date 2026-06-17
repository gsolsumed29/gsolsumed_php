
<table id="result_search_cli" style="position: relative; margin-left: 0;margin-top: 0;" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Descripcion</th>
                    <th style="text-align: right;">Cantidad</th>
                    <th style="text-align: right;">Precio</th>
                    <th style="text-align: right;">Importe</th>
                </tr>
                </thead>
                <tbody>
                	<?php 
                        foreach($detallado as $row){ ?>
                        	<tr >
                                <td><?php echo trim($row->co_art); ?></td>
                                <td style="text-align: right;"><?php echo number_format($row->total_art,2,',','.'); ?></td>
                                <td style="text-align: right;"><?php echo number_format($row->prec_vta,2,',','.'); ?></td>
                                <td style="text-align: right;"><?php echo number_format($row->reng_neto,2,',','.'); ?></td>
                            </tr>
                            <tr >
                                <td colspan="4"><?php echo trim($row->art_des); ?></td>
                                
                            </tr>
                           <?php
                        }
                        ?>
                
                
                </tbody>
            </table>
        