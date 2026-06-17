<script src="<?php echo base_url(); ?>bootadmin-master/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>bootadmin-master/js/bootadmin.min.js"></script>
    <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
    <script type="text/javascript">
        function btn_password(){
    
        $('#modalcambiar_pass').text('Gestionar Contraseña');
        $('#bemp_bd').focus(); 
        $('#cambiar_pass').modal({show:true});       
    
}

function cambiar_pass(){
            if(validaForm()){
            document.getElementById("btnaddcli").style.display="none";
            var url = "<?php echo base_url(); ?>user/updatepass";
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formulario_cliente').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.success) //if success close modal and reload ajax table
            {
                $('#cambiar_pass').modal('hide');
                operacion();
                    $("#nrif").val('');
                    $("#nusu").val('');
                    $("#npass1").val('');
                    $("#npass2").val('');
                    $("#nemail").val('');
                    document.getElementById("btnaddcli").style.display="inherit";
            }else{
                error_msg(data.message);
                document.getElementById("btnaddcli").style.display="inherit";
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            error_msg('Error adding / update data');
            document.getElementById("btnaddcli").style.display="inherit";
 
        }
    });

        }    
        }

    function validaForm(){
    // Campos de texto
    if($("#nrif").val() == ""){
        error_msg("El campo RIF no puede estar vacío.");
        $("#nrif").focus();
        return false;
    }

    if($("#npass1").val() == ""){
        error_msg("El campo Contraseña no puede estar vacío.");
        $("#npass1").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }

    if($("#npass2").val() == ""){
        error_msg("El campo Contraseña no puede estar vacío.");
        $("#npass2").focus();
        return false;
    }

    if($("#npass1").val() != $("#npass2").val()){
        error_msg("El campo Contraseña no concuerdan.");
        $("#npass2").focus();
        return false;
    }

    if($("#nusu").val() == ""){
        error_msg("El campo Usuario no puede estar vacío.");
        $("#nusu").focus();
        return false;
    }

    if($("#nemail").val() == ""){
        error_msg("El campo Email no puede estar vacío.");
        $("#nemail").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }

    if($("#nemail").val() != ""){
        var valor=$("#nemail").val();
        if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(valor)){
   //alert("La dirección de email " + valor + " es correcta.");
   document.getElementById('nemail').style.borderColor="#ced4da";
  } else {
   //alert("La dirección de email es incorrecta.");
   error_msg('El email NO es correcto');
    document.getElementById('nemail').style.borderColor="#FF0000";
    document.getElementById('nemail').focus();
    $("#nemail").focus(); 
        return false;
  }
        
    }

    
  
        return true; // Si todo está correcto
}

     function operacion(){
            reset();
            alertify.success('<center>Operación Realizada con Exito!<br> <i class="fa fa-check-circle"></i></center>');
            return false;
        }

        function noexiste(cliente){
            reset();
            alertify.alertas = alertify.extend("alertas");
            alertify.alertas('<center>No existe ningun '+cliente+' con ese RIF.<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }
        function yaexiste(art){
            reset();
            alertify.error('<center>Ya Existe '+art+'.<br> <i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        } 
        function exito_msg(msg){
            reset();
            alertify.success(''+msg+'<br><center><i class="fa fa-check-circle"></i></center>');
            return false;
        }
        function error_msg(msg){
            reset();
            alertify.error(''+msg+'<br><center><i class="fa fa-exclamation-triangle"></i></center>');
            return false;
        }  
</script>
    <!--<script src="../alert/lib/jquery-1.9.1.js"></script>-->
    <script src="<?php echo base_url(); ?>alert/lib/alertify.min.js" type="text/javascript"></script>
    <script>
        function reset () {
            $("#toggleCSS").attr("href", "../alert/themes/alertify.default.css");
            alertify.set({
                labels : {
                    ok     : "OK",
                    cancel : "Cancel"
                },
                delay : 5000,
                buttonReverse : false,
                buttonFocus   : "ok"
            });
        }

        // ==============================
        
    </script>
</body>
</html>


