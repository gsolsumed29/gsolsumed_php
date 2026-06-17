$(function() {/*
  if ($('#dataBancos').length) {
    $('#dataBancos').ready(function() {
      //cargarDataBancos();
          return false;
   
    });
  } else {
    //alert('no existo')
  }
  */
  if ($('#dashboard').length) {
    $('#dashboard').ready(function() {     
var isRtl = $('html').attr('data-textdirection') === 'rtl';


       
   
    });
  } else {
  }
    //
  $('#salir').on('click', function(e) {
    e.preventDefault();
 
       salir();
  
  });


  
});

function salir(){
  $.ajax({
    url: '../admin/index.php?action=desloguear', 
    type:'post',
    data:{},
    success:function(response){
     //alert(response);
        if(response == 1){      
                window.location = "../"           
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Hubo un error al desloguear!'            
          })
        }
       
    }
});
}
