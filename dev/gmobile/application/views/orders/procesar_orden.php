<?php
                $user = $this->session->userdata('user');
                extract($user);
                $igual=$codfactura.'~'.$cod_art.'~'.$numlinea;
        $formato_examen=$this->orders_model->formato_examen($cod_art);
        $idfor = $formato_examen->IDFor;
        $filas1 = $formato_examen->nombre;
        $calculo = $formato_examen->calculo;
        if($calculo ==''){ $calculo='function calculo(){}';}

        $etiquetas_for=$this->orders_model->etiquetas($idfor);
        $vista_for=$this->orders_model->vista_for($idfor);

            ?>
<script type="text/javascript">
        document.getElementById('<?php echo $filas1; ?>').focus();
    
<?php
  echo $calculo;
?>


var isCtrl = false;
document.onkeyup=function(e){
if(e.which == 17) isCtrl=false;
}
document.onkeydown=function(e){
if(e.which == 17) isCtrl=true;
if(e.which == 83 && isCtrl == true) {
// acción para CTRL+S y evitar que ejecute la acción propia del navegador
//enviar(form2);
//activarCarga();
//validar_resultados();
return false;
}
}
//document.getElementById('campo1').focus();
 //activarCarga();
  //document.getElementById('campo1').focus();
</script>
<style type="text/css">
<!--
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}

input:focus {
    border-width: 0.001cm;
        background-color:#FAFD28;
        }
select:focus {
    border-width: 0.001cm;
        background-color:#FAFD28;
        }        
-->
</style>
<style type="text/css">
      .cargandose_loader {
  display: inline-block;
  position: absolute;
    top: 30%;
    left: 40%;
  width: 64px;
  height: 64px;
}
.cargandose_loader:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #fff;
  border-color: #ccc transparent #ccc transparent;
  animation: cargandose_loader 1.2s linear infinite;
}
@keyframes cargandose_loader {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

    </style>
<div class="card-body">
      <table width="100%" style="margin-top: -20px;">
        <tr><td>
<font color="#210B61" style="font-family: Trebuchet MS; font-weight:bold; text-align: left; "> PACIENTE: <?php
                foreach($paciente as $row0){ 
                 echo $row0->nombre;
                 echo ' - SEXO: ';
                 echo $row0->sexo;
             }
             ?> </font> </td><td>

              <select id="cboExamen" name="cboExamen" class="comboGrande" onchange="cambiar_examen();">
              <!--<option value="0">Todas las Categorias</option>-->
                <?php
                foreach($examenes as $row1){ 
                  $rr=$row1->codfactura.'~'.$row1->codigo.'~'.$row1->numlinea;
                  ?> 
                <option value="<?php echo $rr;?>" <?php if($igual == $rr){ echo 'selected'; } ?> ><?php echo $row1->codigo.' - '.$row1->nom_exa; ?></option>
                <?php 
                } ?>        
                </select>
              </td></tr></table>
              <hr style="margin-top: -1px;">
<div id="formulario_new1">
    <form id="form_procesar" name="form_procesar"  method="post" >
        
        <?php
                foreach($etiquetas_for as $etiquetas){
                    $Nom_eti=$etiquetas->Nom_eti;
                    $posXE=$etiquetas->PosX;
                    $posYE=$etiquetas->PosY;
                    $anchoE=$etiquetas->Ancho_eti;
                    $altoE=$etiquetas->Alto_eti;
                    $NegE=$etiquetas->NegFue_eti;
                    $TamE=$etiquetas->TamFue_eti;
                    if($NegE == 'True'){
                        $NegE1="bold";
                    }else{
                        $NegE1="normal";
                    }
                    $TamE1=abs(str_replace(",", ".", $TamE)).'pt';
                    $anchoE1=abs(str_replace(",", ".", $anchoE)).'cm';
                    $altoE1=abs(str_replace(",", ".", $altoE)).'cm';
                    $posYE=(abs(str_replace(",", ".", $posYE) + 2.5) );
                    $posYE1=abs(str_replace(",", ".", $posYE)).'cm';
                    $posXE1=abs(str_replace(",", ".", $posXE)).'cm';
                    $color='transparent';
                    echo "<div id='etiqueta1' style=' color: #000; font-family: Trebuchet MS; font-weight:".$NegE1."; font-size: ".$TamE1."; position: absolute; background-color: ".$color.";  width: ".$anchoE1."; height: ".$altoE1.";  left: ".$posXE1."; top: ".$posYE1.";' >";
                    if($NegE == 'True'){
                        echo '<b>'.utf8_encode($Nom_eti).'</b>';
                    }else{
                        echo $Nom_eti;
                    }
                    echo "</div>";
                }

        ?>
        <?php
                foreach($vista_for as $vista){
                    $tipoe=$vista->tipo;
                    if($tipoe == 'C'){ //inicio de la impresion de los campos
                        $IDCam=$vista->id;    
                        $Nom_cam=$vista->nombre;
                        $posXC=$vista->PosX;
                        $posYC=$vista->PosY;
                        $anchoC=$vista->Ancho;
                        $altoC=$vista->Alto;
                        $typeC=$vista->type;
                        $TamC=$vista->tam;
                        $NegC=$vista->neg;
                        $DefC=$vista->valor;
                        $TabC=$vista->tab;
                        $ForC=$vista->formato;
                        //sacar tamaño de las fuente
                        $TamC1=abs(str_replace(",", ".", $TamC)).'pt';
                        $anchoC1=abs(str_replace(",", ".", $anchoC)).'cm';
                        $altoC1=abs(str_replace(",", ".", $altoC)).'cm';
                        $posYC=(abs(str_replace(",", ".", $posYC) + 2.5) );
                        $posYC1=abs(str_replace(",", ".", $posYC)).'cm';
                        $posXC1=abs(str_replace(",", ".", $posXC)).'cm';
                        $colorC='#ff0000';
                        if($NegC == 'True'){
                            $NegC1="bold";
                        }else{
                            $NegC1="normal";
                        }
                        $typeC1='text';
                        $Nom_campo='campo-'.$IDCam;
                        echo '<script type="text/javascript">
                            document.getElementById("'.$Nom_campo.'").tabIndex = "'.$TabC.'";
                        </script>';
                        if($filas1 == $Nom_campo){
                        echo "<input type=".$typeC1." id=".$Nom_campo." name=".$Nom_campo." onkeyup='calculo()' style='font-family: Trebuchet MS; font-weight:".$NegC1."; position: absolute; width:".$anchoC1."; height:".$altoC1."; left:".$posXC1."; top:".$posYC1.";' value=\"$DefC\" autofocus>";
                        //fin de la imprecion de los campos
                        }else{
                            echo "<input type=".$typeC1." id=".$Nom_campo." name=".$Nom_campo." onkeyup='calculo()' style='font-family: Trebuchet MS; font-weight:".$NegC1."; position: absolute; width:".$anchoC1."; height:".$altoC1."; left:".$posXC1."; top:".$posYC1.";' value=\"$DefC\">";
                        //fin de la imprecion de los campos
                        }
                    }else{ //inicio de la impresion de los select
                        $id_lis=$vista->id;     
                        $Nom_lis=$vista->nombre;
                        $posXL=$vista->PosX;
                        $posYL=$vista->PosY;
                        $anchoL=$vista->Ancho;
                        $altoL=0;
                        $valorL=$vista->valor;
                        $TamL=$vista->tam;
                        $NegL=$vista->neg;
                        $TabL=$vista->tab;
                        if($NegL == 'True'){
                            $NegL1="bold";
                        }else{
                            $NegL1="normal";
                        }
                        //sacar tamaño de las fuente
                        $TamL1=abs(str_replace(",", ".", $TamL)).'pt';
                        $anchoL1=abs(str_replace(",", ".", $anchoL)).'cm';$altoL1=abs(str_replace(",", ".", $altoL)).'cm';
                        $posYL=(abs(str_replace(",", ".", $posYL) + 2.5) );
                        $posYL1=abs( str_replace(",", ".", $posYL)).'cm';
                        $posXL1=abs(str_replace(",", ".", $posXL)).'cm';
                        $colorC='#ff0000';
                        $typeL='text';
                        $Nom_select='select-'.$id_lis;
                        ?>
                        <script type="text/javascript">
                            document.getElementById("<?php echo $Nom_select;?>").tabIndex = "<?php echo $TabL;?>";
                        </script>
                        <?php
                        echo "<select id=".$Nom_lis." name=".$Nom_select." style='font-family: Trebuchet MS; font-weight:".$NegL1."; position: absolute; width: ".$anchoL1."; left: ".$posXL1."; top: ".$posYL1.";'>";
                        $array = explode(",", $valorL);
                        for ($i=0; $i<sizeof($array); $i++){
                            echo "<option value=\"$array[$i]\">". $array[$i] .'</option>';
                        }
                        echo '</select>';
                    }
                }

        ?>
        <input type="hidden" id="codfactura" name="codfactura" value="<?php echo $codfactura; ?>">
        <input type="hidden" id="codexamen" name="codexamen" value="<?php echo $cod_art; ?>">
        <input type="hidden" id="numlinea" name="numlinea" value="<?php echo $numlinea; ?>">
        <input type="hidden" id="idusuario" name="idusuario" value="<?php echo $idusuario; ?>">
        <input type="hidden" id="validame" name="validame" value="0">
        <input type="hidden" id="modulo" name="modulo" value="2">
    </form>
</div>
<div id="cargandose" style="display: none;"><div class="cargandose_loader"></div></div>
          </div>

    <script type="text/javascript">
        //$('body').on('keydown', 'input, select, textarea', function(e) {
        $('#formulario_new1').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        //focusable = document.getElementById('form_procesar').find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            //form.submit();
            validar_resultados();
        }
        return false;
    }
});

$('#procesar_muestra').on('shown.bs.modal', function () {
    $('#<?php echo $filas1; ?>').focus();
}) 
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$("#procesar_muestra").on("shown.bs.modal", function() {
 $(document).off('focusin.bs.modal');
});
    </script>