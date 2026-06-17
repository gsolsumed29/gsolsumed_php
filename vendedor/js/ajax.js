$(function() {
  
  $('#salir').on('click', function(e) {
    e.preventDefault();
      clearSession()
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


function removeSessionData(key) {
  localStorage.removeItem(key);
}

// Limpiar toda la sesión
function clearSession() {
  localStorage.clear();
}