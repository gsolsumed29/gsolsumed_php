$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      var email = $("#login-email").val().trim();
      var password = $("#login-password").val().trim();

      if( email != "" && password != "" ){
          $.ajax({
              url: 'admin/index.php?action=login', 
              type:'post',
              data:{email:email,password:password},
              success:function(response){
               //alert(response);
              // console.log(response);
                  if(response == 1){
                    let timerInterval
                      Swal.fire({
                        title: 'Acceso concedido',
                        html: 'Bienvenido Administrador.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                          timerInterval = setInterval(() => {
                         
                           
                          }, 100)
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                       
                          // window.location = "admin/"
                        }
                      })
                     
                  }
                 
                  if(response == 2){
                    let timerInterval
                      Swal.fire({
                        title: 'Acceso concedido',
                        html: 'Bienvenido Vendedor.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                          timerInterval = setInterval(() => {
                            
                          }, 100)
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                       
                        //  window.location = "vendedor/"
                        }
                      })                     
                  }       

                  if(response ==3){
                    let timerInterval
                      Swal.fire({
                        title: 'Acceso concedido',
                        html: 'Bienvenido Gerente.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                          timerInterval = setInterval(() => {
                           
                          }, 100)
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                     
                         // window.location = "gerente/"
                        }
                      })                     
                  }            
                 
                  if(response == 0){
                    Swal.fire({
                      title: 'Error!',
                      text: ' Datos de usuario inválidos!',
                      icon: 'error',
                      customClass: {
                        confirmButton: 'btn btn-primary'
                      },
                      buttonsStyling: false
                    })
                  }

                  if(response == 4){
                    Swal.fire({
                      title: 'Error!',
                      text: ' Su usuario ha sido desactivado, Por favor comuniquese con su administrador!',
                      icon: 'error',
                      customClass: {
                        confirmButton: 'btn btn-primary'
                      },
                      buttonsStyling: false
                    })
                  }

                 
              }
          });
      }
    }
  });
  $('#loginform').validate({
    rules: {
      'login-email': {
        required: true
      },
      'login-password': {
        required: true,
        minlength: 5
      }
    },
    messages: {
      'login-email': {
        required: "Por favor un usuario válido"
     
      },
      'login-password': {
        required: "Por favor escriba su contraseña",
        minlength: "Tu contraseña debe ser de al menos de 6 caracteres"
      }
},
   
  });
});
