<div class="card-body">
<form id="formulario_cobro" name="formulario_cobro" method="post">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="ccodfactura">Factura</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="ccodfactura" name="ccodfactura" placeholder="0" readonly="yes" value="<?php echo $facturas;?>">
            </div>
        </div>
        <div class="col-md-8 mb-3">
            <label for="ccliente">Cliente</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="ccliente" name="ccliente" placeholder="Cliente" readonly="yes">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="ctotal">Total Facturado</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm precio" id="ctotal" name="ctotal" placeholder="0" readonly="yes">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="csaldo">Saldo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm precio" id="csaldo" name="csaldo" placeholder="0" readonly="yes">
            </div>
        </div>
    
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="cpagar">Monto a Cancelar</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm precio" id="cpagar" name="cpagar" placeholder="0" >
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="cpendiente">Pendiente</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                </div>
                <input type="text" style="text-align: right;" class="form-control form-control-sm" id="cpendiente" name="cpendiente" placeholder="0" readonly="yes">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="cfpago">Forma de pago</label>
            <div class="input-group">
            <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-list"></i></div>
                    </div>
                    <select class="form-control form-control-sm" id="cfpago" name="cfpago">
                        <?php 
                        foreach($fpago as $row){ 
                            echo '<option value="'.$row->codigo.'">'.$row->descripcion.'</option>';
                        }
                        ?>
                    </select>
                </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="cdocumento">Nº Documento</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="cdocumento" name="cdocumento" placeholder="Nº Documento">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="cfecha">Fecha</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm datepicker" id="cfecha" name="cfecha" value="<?php echo date('d-m-Y');?>" placeholder="dd-mm-yyyy">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="cbanco">Banco</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                </div>
                <select class="form-control" id="cbanco" name="cbanco">
                        <option value="">Seleccione..</option>
                        <?php 
                        foreach($bancos as $row){ 
                            echo '<option value="'.$row->co_ban.'">'.$row->des_ban.'</option>';
                        }
                        ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="cobserva">Observaci&oacute;n</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-address-card"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" id="cobserva" name="cobserva" placeholder="Observaci&oacute;n" >
            </div>
        </div>
    </div>
    <input type="hidden" id="ccodcliente" name="ccodcliente" value="0">
    <input type="hidden" id="cpagar2" name="cpagar2" value="0">
    <input type="hidden" id="csaldo2" name="csaldo2" value="0">
</form>
</div>