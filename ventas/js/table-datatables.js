


$(window,document,$).ready(function(){
'use strict';





});


//eliminar la visita
function borrarAdelanto(id){

var tipo = 1;
var accion = 3;
var datos =1;
$.ajax({
  url: '../admin/index.php?action=adelanto', 
  type:'GET',
  data:{tipo:tipo,accion:accion,datos:datos,id:id},
  success:function(response){
   //alert(response);
      if(response == 1){      
        Swal.fire({
          icon: 'success',           
          text: 'Datos de la visita eliminados con exito!.'            
        })
       // cargarDataUsers()
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Hubo un error al eliminar.'            
        })
      }
     
  }
});


}


