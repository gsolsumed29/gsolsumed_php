<!DOCTYPE html>
<html>
<head>
    <title></title>
<script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
    <script type="text/javascript">
        function to_start(){
        tm=window.setInterval('contador()',1500);
    }
    function to_stop(){
        window.clearInterval(tm);
    } 
    var cont = '<?php echo $valor;?>';
function contador(){
    var contador = document.getElementById("contador1");
    contador.value = cont;
    cliente_new('V',cont)
    cont++;
}
function cliente_new(nac,cedula){
    // ajax adding data to database
    $.ajax({
    data: {"nacionalidad" : nac, "cedula" : cedula},
    type: "POST",
    dataType: "json",
    url: "http://190.9.132.68/index.php/welcome/saime",
})
 .done(function( data, textStatus, jqXHR ) {
     if ( console && console.log ) {
         //console.log( "La solicitud se ha completado correctamente." );
         //var  datos=data[0];
         if(data){
         console.log(data[0].cedula);
         add_saime(data[0].origen,data[0].cedula,data[0].primer_nombre,data[0].segundo_nombre,data[0].primer_apellido,data[0].segundo_apellido,data[0].fecha_nacimiento,data[0].nacionalidad,data[0].pais_origen,data[0].sexo,data[0].naturalizado,data[0].id,data[0].fecha_registro);
     }
     }
 })
 .fail(function( jqXHR, textStatus, errorThrown ) {
     if ( console && console.log ) {
         console.log( "La solicitud a fallado: " +  textStatus + " jqXHR: " + errorThrown);
     }
}); 
}  
function add_saime(origen,cedula,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,fecha_nacimiento,nacionalidad,pais_origen,sexo,naturalizado,id,fecha_registro){
    
    var url;
    url = "http://192.168.1.4/codeigniter_ad/invoice/add_saime/"+origen+"/"+cedula+"/"+primer_nombre+"/"+segundo_nombre+"/"+primer_apellido+"/"+segundo_apellido+"/"+fecha_nacimiento+"/"+nacionalidad+"/"+pais_origen+"/"+sexo+"/"+naturalizado+"/"+id+"/"+fecha_registro;
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        //data: $('#form_art').serialize(),
        dataType: 'JSON',
        success: function (data) {
        // success callback -- replace the div's innerHTML with
        // the response from the server.
        //$('#frame_resultado_bart').html(html);
        if(data.success) //if success close modal and reload ajax table
            {
        console.log('add');
        //consultar();
    }else{
        console.log('error');
    }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log('Error adding / update data');
 
        }
    });
           
        }
    </script>
</head>
<body >
saime load data <input type="text" id="contador1" name="contador1">
<input type="button" name="btn" value="Start" onclick="to_start();">

<input type="button" name="btn" value="Stop" onclick="to_stop();">
<script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
<script type="text/javascript">

</script>
</body>
</html>