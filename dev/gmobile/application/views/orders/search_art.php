<style type="text/css">
    .zoomTool {
        position: relative;
width: 100%;
  background-color: #212121c2!important;
  padding: 0px;
  border-radius: 2px;
  margin-left: auto;
  margin-right: auto;
  display: inline-block;
  border-bottom-right-radius:calc(.25rem - 1px);
 border-bottom-left-radius:calc(.25rem - 1px)

}

.zoomTool button {

  background-color: transparent;
  outline: none;
  border: none;
  height: 40px;
  width: 30.33%;
  border-radius: 2px;
  transition: .2s;
  cursor: pointer;
  color: #FFFFFF;
  font-weight: bold;

}

.zoomTool button:hover {

  background-color: rgba(209, 209, 209, 0.53);

}
</style>
<!--<div class="card-body">-->
                    <?php 
                    $tipo_precio=$this->orders_model->tipo_precio($cliente);
                    $i=1;
                        foreach($articulos as $row1){
                          $cantidad=$this->orders_model->get_cantidad(trim($row1->co_art),$codfacturatmp);
                        if($i == 1){
                            echo '<div class="form-row">';
                        }
                        if ($i == 5) {
                            echo '</div>';
                            $i=1;
                            echo '<div class="form-row">';
                        } ?>
                                    <div class="card" style="width: 11.5rem; padding: 0px; " >
                                        <!--<img class="card-img-top" src="<?php echo base_url(); ?>images/350x150.png" alt="Card image cap">-->
                                        <div class="card-body" style="height: auto; padding: 0.10rem;">
                                            <br>
                                            <center><p data-toggle="tooltip" data-original-title="C&oacute;digo"><b><?php echo trim($row1->co_art);?></b></p></center>
                                            <hr>
                                            <center><p data-toggle="tooltip" data-original-title="Descripci&oacute;n"><?php echo trim($row1->art_des).' (Stock: '.number_format($row1->stock_act,2,',','.').')';?></p></center>
                                            <?php if($tipo_precio->tipo == 1){
                                              //precio 1
                                              ?><center><p data-toggle="tooltip" data-original-title="Precio"><b><?php echo number_format($row1->prec_vta1,2,',','.'); ?></b></p></center><?php
                                            }elseif ($tipo_precio->tipo == 2) {
                                              //precio 2
                                              ?><center><p data-toggle="tooltip" data-original-title="Precio"><b><?php echo number_format($row1->prec_vta2,2,',','.'); ?></b></p></center><?php
                                            }elseif ($tipo_precio->tipo == 3) {
                                              //precio 3
                                              ?><center><p data-toggle="tooltip" data-original-title="Precio"><b><?php echo number_format($row1->prec_vta3,2,',','.'); ?></b></p></center><?php
                                            }elseif ($tipo_precio->tipo == 4) {
                                              //precio 4
                                              ?><center><p data-toggle="tooltip" data-original-title="Precio"><b><?php echo number_format($row1->prec_vta4,2,',','.'); ?></b></p></center><?php
                                            }elseif ($tipo_precio->tipo == 5) {
                                              //precio 5
                                              ?><center><p data-toggle="tooltip" data-original-title="Precio"><b><?php echo number_format($row1->prec_vta5,2,',','.'); ?></b></p></center><?php
                                            }else{
                                              //precio 1
                                              ?><center><p data-toggle="tooltip" data-original-title="Precio"><b><?php echo number_format($row1->prec_vta1,2,',','.'); ?></b></p></center><?php
                                            } ?>
                                            
                                        </div>
                                        <div class="zoomContainner">
                                            <div class="zoomTool">
                                                <button class="zoomOut" type="button" name="button" onclick="seleccionar_art('<?php echo trim($row1->co_art);?>','zoomOut');"><i class="fas fa-minus"></i></button>
                                                <!--input type="text" class="zoomReset" id="conteo-<?php echo trim($row1->co_art);?>" name="conteo-<?php echo trim($row1->co_art);?>" value="<?php echo number_format($cantidad->total_art,0,',','.'); ?>"-->
                                                <button class="zoomReset" type="button" name="button" id="conteo-<?php echo trim($row1->co_art);?>" onclick="mod_art_cant('<?php echo trim($row1->co_art);?>');"><?php echo number_format($cantidad->total_art,0,',','.'); ?></button>
                                                <button class="zoomIn" type="button" name="button" onclick="seleccionar_art('<?php echo trim($row1->co_art);?>','zoomIn');"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                           <?php $i++;
                        }
                        ?>
          <!--</div>-->

          <script type="text/javascript">

              //parent.document.getElementById('bdescripcion').focus(); 
              //console.log('si');
          </script>