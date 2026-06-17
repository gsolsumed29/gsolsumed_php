(function (window, undefined) {
  'use strict';

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
                            const content = Swal.getContent()
                            if (content) {
                              const b = content.querySelector('b')
                              if (b) {
                                b.textContent = Swal.getTimerLeft()
                              }
                            }
                          }, 100)
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                          //console.log('I was closed by the timer'),
                          window.location = "admin/"
                        }
                      })
                     
                  }
                 
                  if(response == 2){
                    let timerInterval
                      Swal.fire({
                        title: 'Acceso concedido',
                        html: 'Bienvenido .',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                          timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                              const b = content.querySelector('b')
                              if (b) {
                                b.textContent = Swal.getTimerLeft()
                              }
                            }
                          }, 100)
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                         // console.log('I was closed by the timer'),
                          window.location = "vendedor/"
                        }
                      })                     
                  }       

                  if(response ==3){
                    let timerInterval
                      Swal.fire({
                        title: 'Acceso concedido',
                        html: 'Bienvenido.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                          timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                              const b = content.querySelector('b')
                              if (b) {
                                b.textContent = Swal.getTimerLeft()
                              }
                            }
                          }, 100)
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                         // console.log('I was closed by the timer'),
                          window.location = "secretaria/"
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

                  if(response ==4){
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

  if ($('.content-body').length) {  
    //Top de los productos mas vendidos
    cargarDataEmpresa();
  }


  $('#sendRecoveryLink').on('click', function(e) {
    e.preventDefault();

    var email = $('#forgot-email').val();
    var form = $('#forgotPasswordForm')[0];

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // Mostrar alerta de carga
    Swal.fire({
        title: 'Enviando...',
        text: 'Por favor, espera mientras reestablecemos tu contraseña.',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // --- LLAMADA AJAX REAL ---
    $.ajax({
      url: 'admin/index.php?action=users&tipo=1&accion=3&datos=1', 
        type: 'POST',
        dataType: 'json', // Esperamos una respuesta JSON
        data: {
            accion: 3,        // La acción que tu PHP espera
            email: email      // El email del usuario
        },
        success: function(response) {
            // Ocultar el modal de recuperación
            $('#forgotPasswordModal').modal('hide');

            if (response.status === 'success') {
                // Sanitizar la contraseña antes de mostrarla (buena práctica)
                var safePassword = response.new_password.replace(/</g, "&lt;").replace(/>/g, "&gt;");

                // Mostrar mensaje de éxito con la nueva contraseña
                Swal.fire({
                    icon: 'success',
                    title: '¡Contraseña recuperada!',
                    // Usamos 'html' para renderizar las etiquetas
                    html: 'Hemos reestablecido la contraseña para el usuario: <b>' + email + '</b><br>La nueva contraseña es: <b>' + safePassword + '</b>',
                    confirmButtonText: 'Aceptar'
                });
              } else {
                // ESTE BLOQUE CAPTURARÁ EL NUEVO MENSAJE DE ERROR
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message, // Mostrará "El correo electrónico no está registrado..."
                    confirmButtonText: 'Aceptar'
                });
            }

            // Limpiar el formulario
            $('#forgotPasswordForm').removeClass('was-validated').trigger('reset');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Ocultar el modal
            $('#forgotPasswordModal').modal('hide');
            
            // Mostrar error de comunicación
            Swal.fire({
                icon: 'error',
                title: 'Error de Comunicación',
                text: 'No se pudo contactar con el servidor. Por favor, inténtalo de nuevo.',
                confirmButtonText: 'Aceptar'
            });
            console.error("AJAX Error:", textStatus, errorThrown);
        }
    });
});

// Limpiar el estado de validación al cerrar el modal
$('#forgotPasswordModal').on('hidden.bs.modal', function () {
    $(this).find('form').removeClass('was-validated').trigger('reset');
});

})(window);


function cargarDataEmpresa(){
  
  $.ajax({
    type: "GET",
    url: 'admin/index.php?action=combos&a=1&c=EmpresaData&t=empresa', 
}).done(function(empresa) {  
  var i = 0;
  var tope =empresa.length;
  var src='';
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
    $('#name').html(empresa[i].name);
    $('#name2').html(empresa[i].name);
    $('#email').val(empresa[i].email);
    $('#telefonos').val(empresa[i].telefonos);
    $('#rif').val(empresa[i].rif);
    $('#direccion').html(empresa[i].dir);
    src= " ../admin/storage/logo/"+empresa[i].image;
    //console.log(src);
    $('#empresa-img').attr("src",src); 
    
    }  
  }else{
  }
  //alert(tope);
});
}