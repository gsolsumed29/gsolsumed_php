<div class="card-body">
                	<?php 
                    $i=1;
                        foreach($articulos as $row1){
                        if($i == 1){
                            echo '<div class="form-row">';
                        }
                        if ($i == 5) {
                            echo '</div>';
                            $i=1;
                            echo '<div class="form-row">';
                        } ?>
                                    <div class="card" style="width: 8.3rem;" data-toggle="tooltip" data-original-title="<?php echo $row1->art_des;?>" ondblclick="seleccionar_art3('<?php echo trim($row1->co_art);?>');">
                                        <img class="card-img-top" src="<?php echo base_url(); ?>images/350x150.png" alt="Card image cap">
                                        <div class="card-body">
                                            <p><?php echo $row1->art_des;?></p>
                                        </div>
                                    </div>
                           <?php $i++;
                        }
                        ?>
          </div>
          <script type="text/javascript">
             
          </script>