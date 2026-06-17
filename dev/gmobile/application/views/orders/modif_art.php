<?php foreach($articulos as $row1){ ?>
<div class="form-row">
                    &nbsp;&nbsp;&nbsp;
                <div class="input-group col-md-4 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="mcodigo" name="mcodigo" placeholder="Codigo" value="<?php echo trim($row1->co_art);?>">
                </div>
                <div class="input-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm" id="mdescripcion" name="mdescripcion" placeholder="Descripcion" value="<?php echo trim($row1->art_des);?>">
                </div>
                </div>
                <div class="form-row">
                    &nbsp;&nbsp;&nbsp;
                <div class="input-group col-md-5 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-list"></i></div>
                    </div>
                    <select class="form-control" id="mprecio" name="mprecio">
                        <option value="<?php echo $row1->prec_vta;?>"><?php echo number_format($row1->prec_vta,2,',','.');?> (Actual)</option>
                        ?>
                    </select>
                </div>
                <div class="input-group col-md-3 mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-sort-amount-up"></i></div>
                    </div>
                    <input type="number" class="form-control form-control-sm" id="mcantidad" name="mcantidad" placeholder="0,00" value="<?php echo $row1->total_art;?>" min="1" max="1000" maxlength="5">
                </div>
                
                 <input type="hidden" name="mnuli" id="mnuli" value="<?php echo $row1->reng_num;?>">
            </div>
            <?php } ?>