
function estadisticaDetallada(mes,total,filtro){
    var options = {
      series: [{
      text: '2022',
      data: total
    }, {
      text: '2023',
      data: total
    }],
      chart: {
      type: 'bar',
      height: 430
    },
    plotOptions: {
      bar: {
        horizontal: false,
        dataLabels: {
          position: 'top',
        },
      }
    },
    dataLabels: {
      enabled: false,
      offsetX: -6,
      style: {
        fontSize: '12px',
        colors: ['#fff']
      }
    },
    stroke: {
      show: true,
      width: 1,
      colors: ['#fff']
    },
    tooltip: {
      shared: true,
      intersect: false
    },
    xaxis: {
      categories: mes,
    },
    };
    $("#chart").empty();
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

 
}
function cargarTablaUsers(){
  var dt_basic_table_users = $('.datatables-basic-users');   
    assetPath = '../app-assets/';
  if (dt_basic_table_users.length) {
    
    let dataUsuarios =  $('.dataUsers').val();
    //console.log(dataUsuarios);
    let arrayUsuarios = "";
    arrayUsuarios = JSON.parse(dataUsuarios);
    var dt_basic = dt_basic_table_users.DataTable({
     data : arrayUsuarios,
      columns: [    
        
        { data: 'responsive_id' },//0
        { data: 'id' },    //1
        { data: 'id' },//2
        { data: 'name' },//3
        { data: 'email' },//4
        { data: 'rol' }, // 5      
        { data: 'lastLogin' },//6
        { data: 'created' },//7
        { data: 'image' },  //8
        { data: 'isTrue' },  //9     
        { data: 'status' },     //10
        { data: '' }     //11
          
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          targets: 2,
          visible: false
        },
        {
          targets: 1,
          visible: false
        },   
        {
          targets: 7,
          visible: false
        },
       
        {
          targets: 8,
          visible: false
        },
          
        {
          targets: 9,
          visible: false
        },
        {
          targets: 10,
          visible: false
        },
       
      /*
        {
          targets: 10,
          visible: false
        },*/
       
        
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },
        {   // Actions
          targets: -1,
          title: 'Acciones',
          orderable: false,
          render: function (data, type, full, meta) {

            return (
              '<div class="d-inline-flex">' +
              '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +          
              '<a href="javascript:cambiarClave('+full['id']+');" class="'+full['id']+' dropdown-item " >' +
              feather.icons['key'].toSvg({ class: 'font-small-4 me-50' }) +
              'Cambiar Clave</a>' +
              '<a href="javascript:desactivarUser('+full['id']+');" class="'+full['id']+' dropdown-item">' +
              feather.icons['alert-octagon'].toSvg({ class: 'font-small-4 me-50' }) +
              'Bloquear</a>' +
              '<a href="javascript:activarUser('+full['id']+');" class="'+full['id']+' dropdown-item">' +
              feather.icons['pocket'].toSvg({ class: 'font-small-4 me-50' }) +
              'Desbloquear</a>' +
              '<a href="javascript:borrarUser('+full['id']+');" class="'+full['id']+' dropdown-item">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +
              '</div>' +
              '</div>'
            );
            
            
           
          }
         }, 
        {
          // Label
          targets: 5,
          render: function (data, type, full, meta) {
            var $status_number = full['rol'];
            var $status = {
              1: { title: 'Administrador', class: 'badge-light-success' },
              2: { title: 'Empleado', class: ' badge-light-danger' },
              3: { title: 'Secretaria(o)', class: 'badge-light-warning' }
              
            
            };
            if (typeof $status[$status_number] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $status[$status_number].class +
              '">' +
              $status[$status_number].title +
              '</span>'
            );
          }
        },

        {
          // Label
          targets: 11,
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              0: { title: 'Inactivo', class: ' badge-light-danger' },
              1: { title: 'Activo', class: 'badge-light-success' }
              
            
            };
            if (typeof $status[$status_number] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $status[$status_number].class +
              '">' +
              $status[$status_number].title +
              '</span>'
            );
          }
        },
       
       
        {
        
        }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        },
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }),
          className: 'create-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modals-slide-in'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del Usuario';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIdx +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ resultados",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando resultados _START_-_END_ de  _TOTAL_",
        "sInfoEmpty": "Mostrando resultados del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      }

      
    });
    
    
    
    $('.data-submit-usuario').on('click', function () {
      var $email = $('.add-new-record-usuario .email').val().toUpperCase(),       
        $co_ven = $('.add-new-record-usuario .comboVendedoresUsuario').val(),

        $rol = $('.add-new-record-usuario .userLevel').val(),
        $contrasena = $('.add-new-record-usuario .contrasena').val(),      
        $confirmContrasena = $('.add-new-record-usuario .confirmContrasena').val()

      if (($email != '') && ($rol!='')  && ($co_ven!='') && ($confirmContrasena!='')  && ($contrasena!='')) { 
        
          if($contrasena == $confirmContrasena){
           // console.log('Guardare');
            if(($contrasena.length)>=6){
            //  console.log('Guardare');
           
         
           
         
            var tipo = 1;
            var accion = 1;
            var datos =1;
                $.ajax({
                    url: '../admin/index.php?action=user', 
                    type:'POST',
                    data:{email : $email,rol:$rol,co_ven:$co_ven,confirmContrasena:$confirmContrasena,tipo:tipo,accion:accion,datos:datos},
                    success:function(response){
                      var i = 0;
                      var tope =response.length;  
                      if(tope == 1){ 
                        for (var i = 0; i < tope; i++) {               
                             
                          dt_basic.row
                          .add({
      
                            responsive_id : 0,
                            id: response[i].id,
                            id:  response[i].id,
                            name: response[i].name,
                            email:response[i].email,
                            rol: response[i].rol,
                      
                            lastLogin: response[i].lastLogin,

                            created: response[i].created,
                            image: response[i].image,
                            isTrue: response[i].isTrue,
                            status: response[i].status
                          
                              
                          })
                          .draw();
                          
                          
                          
                          
                          $('.add-new-record-usuario .nombre').val('');
                          $('.add-new-record-usuario .email').val('');
                          $('.add-new-record-usuario .contrasena').val('');
                           $('.add-new-record-usuario .confirmContrasena').val('');
                        
                        //count++;
                        $('.modal').modal('hide');
                          } 
                        } 
                        if(tope == 2){
                          Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El correo electrónico que esta intentando registrar, ya esta asociado a otro registro!'
                          
                          })
                          // console.log(response)
                       
                        }
                       
                    }
                });
              }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'La contraseña a guardar debe ser mayor a 6 dígitos'
                
                })
              }
          }else{
 
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Las contraseñas deben ser iguales'
            
            })
          }
     
       
      
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
        
        })
      }
    });
    // borrar usuario
    $('.datatables-basic-users tbody').on('click', '.delete-record', function (e) {
      $('.dtr-modal').hide();
     let id = e.target.classList[0];
     console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que eliminará definitivamente al usuario.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
           //  pagar();
           borrarUser(id);
           dt_basic.row($(this).parents('tr')).remove().draw();
       
        }
      })
   


    });

      // desactivar usaurio
    $('.datatables-basic-users tbody').on('click', '.desactivar-record', function (e) {
      $('.dtr-modal').hide();
        let id = e.target.classList[0];
       console.log(id);
         e.preventDefault();
         Swal.fire({
           title: '¿Deseas desactivar?',
           text: "Tenga en cuenta que desactivara temporalmente el acceso a la plataforma al usuario.",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Si',
           cancelButtonText: 'No'
         }).then((result) => {
           if (result.isConfirmed) {
              //  pagar();
              desactivarUser(id);
              //dt_basic.row($(this).parents('tr')).remove().draw();
          
           }
         })
      
   
   
       });
    // activar usuario
    $('.datatables-basic-users tbody').on('click', '.activar-record', function (e) {
      $('.dtr-modal').hide();
      let id = e.target.classList[0];
     console.log(id);
       e.preventDefault();
       Swal.fire({
         title: '¿Deseas activar?',
         text: "Tenga en cuenta que activará  el acceso a la plataforma al usuario.",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Si',
         cancelButtonText: 'No'
       }).then((result) => {
         if (result.isConfirmed) {
            //  pagar();
            activarUser(id);
            dt_basic.row($(this).parents('tr')).update({status :1}).draw();
           
           // dt_basic.row($(this).parents('tr')).remove().draw();
        
         }
       })
    
 
 
     });
    $('div.head-label').html('<h6 class="mb-0">Usuarios registrados</h6>');
  }

}
function cargarTablaVendedores(){
  var dt_basic_table_vendedores = $('.datatables-basic-vendedor');   
    assetPath = '../app-assets/';
  if (dt_basic_table_vendedores.length) {
    
    let dataVendedores =  $('.dataVendedores').val();
    //console.log(dataUsuarios);
    let arrayVendedores = "";
    arrayVendedores = JSON.parse(dataVendedores);
    var dt_basic = dt_basic_table_vendedores.DataTable({
     data : arrayVendedores,
      columns: [    
        
        { data: 'responsive_id' },//0
        { data: 'co_ven' },    //1
        { data: 'co_ven' },//2
        { data: 'ven_des' }
          
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          targets: 2,
          visible: false
        },
        {
          targets: 1,
          visible: false
        },      

     
      
    /*
        {
          targets: 10,
          visible: false
        },*/
       
        
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },
     
      

     
       
       
        {
        
        }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [           
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [3] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: [3] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        }
       
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del vendedor';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIdx +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ resultados",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando resultados _START_-_END_ de  _TOTAL_",
        "sInfoEmpty": "Mostrando resultados del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      }

      
    });
    
    
    
    $('.data-submit').on('click', function () {
      var $nombre = $('.add-new-record .nombre').val().toUpperCase(),
        $nombreUsuario = $('.add-new-record .nombreUsuario').val().toUpperCase(),
        $confirmContrasena = $('.add-new-record .confirmContrasena').val(),
        $userLevel = $('.add-new-record .userLevel').val(),
        $idReferido = $('.add-new-record .sucursal').val(),
        $sucursal = $('.sucursal option:selected').html(),
        $contrasena = $('.add-new-record .contrasena').val()
       // console.log(sucursal);
/*
        let cuenta = ($('.add-new-record .banco').val()).length;
        let $banco=0;
        if(cuenta >=6){
          $banco = $bancoData.substring(0, 2);
        }else{
          $banco = $bancoData.substring(0, 1);
        }
        let $codigo = $bancoData.substring(1, 5)
        */
        // console.log($codigo);
      if (($nombreUsuario != '') && ($nombre!='') && ($confirmContrasena!='')  && ($contrasena!='')) { 
        
          if($contrasena == $confirmContrasena){
            console.log('Guardare');
            var tipo = 1;
            var accion = 1;
            var datos =1;
                $.ajax({
                    url: '../admin/index.php?action=user', 
                    type:'POST',
                    data:{nombre : $nombre,nombreUsuario:$nombreUsuario,idReferido:$idReferido,confirmContrasena:$confirmContrasena,userLevel:$userLevel,tipo:tipo,accion:accion,datos:datos},
                    success:function(response){
                      var i = 0;
                      var tope =response.length;  
                      if(tope == 1){ 
                        for (var i = 0; i < tope; i++) {               
                             
                          dt_basic.row
                          .add({
                           
                            responsive_id : 0,
                            id: response[i].id,
                            id:  response[i].id,
                            nombre: response[i].nombre,
                            nombreUsuario:response[i].nombreUsuario,
                            userLevel: response[i].userLevel,
                            ultimoLogin: response[i].ultimoLogin,

                            created: response[i].created,
                            image: response[i].image,
                            password: response[i].password,
                            idReferido: response[i].idReferido,
                            confirmacion: 1,
                            estatus: 1
                              
                          })
                          .draw();
                          
                          
                          
                          
                          $('.add-new-record .nombre').val('');
                          $('.add-new-record .nombreUsuario').val('');
                          $('.add-new-record .contrasena').val('');
                           $('.add-new-record .confirmContrasena').val('');
                        
                        //count++;
                        $('.modal').modal('hide');
                          } 
                        } 
                        if(tope == 2){
                          Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El correo electrónico que esta intentando registrar, ya esta asociado a otro registro!'
                          
                          })
                          // console.log(response)
                       
                        }
                       
                    }
                });
          }else{
 
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Las contraseñas deben ser iguales'
            
            })
          }
     
       
      
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
        
        })
      }
    });
  
    // Delete Record
    $('.datatables-basic-users tbody').on('click', '.delete-record', function (e) {
     let id = e.target.classList[0];
     console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que eliminará definitivamente al usuario.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
           //  pagar();
           borrarUser(id);
           dt_basic.row($(this).parents('tr')).remove().draw();
       
        }
      })
   


    });
    $('div.head-label').html('<h6 class="mb-0">Usuarios registrados</h6>');
  }

}
function cargarTablaClientes(){
  var dt_basic_table_clientes = $('.datatables-basic-clientes');   
    assetPath = '../app-assets/';
  if (dt_basic_table_clientes.length) {
    
    let dataClientes =  $('.dataClientes').val();
    //console.log(dataUsuarios);
    let arrayClientes = "";
    arrayClientes = JSON.parse(dataClientes);
    var dt_basic = dt_basic_table_clientes.DataTable({
     data : arrayClientes,
      columns: [    
        //c.co_cli, c.rif, c.cli_des, c.telefonos, c.email, c.direc1, c.dir_ent2, t.des_tipo 
        { data: 'responsive_id' },//0
        { data: 'co_cli' },    //1
        { data: 'co_cli' },//2
        { data: 'rif' },//4
        { data: 'cli_des' },//3     
        { data: 'telefonos' }, // 5      
        { data: 'direc1' },//6
        { data: 'dir_ent2' },  //7   
        { data: 'email' },//8
        { data: 'des_tipo' },  //9    
        { data: '' }     //10
          
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          targets: 2,
          visible: false
        },
        {
          targets: 1,
          visible: false
        },     
        {
          targets: 7,
          visible: false
        },      
        
       
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },
        {   // Actions
          targets: -1,
          title: 'Acciones',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-flex">' +
              '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +              
             
              '<a href="javascript:;" class="'+full['id']+' dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +
              '</div>' +
              '</div>'
            );
          }
         }, 
        {
          // Label
          targets: 5,
          render: function (data, type, full, meta) {
            var $status_number = full['rol'];
            var $status = {
              1: { title: 'Administrador', class: 'badge-light-success' },
              2: { title: 'Vendedor', class: ' badge-light-danger' },
              3: { title: 'Usuario', class: 'badge-light-info' }
              
            
            };
            if (typeof $status[$status_number] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $status[$status_number].class +
              '">' +
              $status[$status_number].title +
              '</span>'
            );
          }
        },

        {
          // Label
          targets: 10,
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              1: { title: 'Activo', class: 'badge-light-success' },
              2: { title: 'Inactivo', class: ' badge-light-danger' },
              3: { title: 'Suspendido', class: 'badge-light-info' }
              
            
            };
            if (typeof $status[$status_number] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $status[$status_number].class +
              '">' +
              $status[$status_number].title +
              '</span>'
            );
          }
        },
       
       
        {
        
        }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        },
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }),
          className: 'create-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modals-slide-in'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del cliente';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIdx +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ resultados",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando resultados _START_-_END_ de  _TOTAL_",
        "sInfoEmpty": "Mostrando resultados del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      }

      
    });
    
    
    
    $('.data-submit').on('click', function () {
      var $nombre = $('.add-new-record .nombre').val().toUpperCase(),
        $nombreUsuario = $('.add-new-record .nombreUsuario').val().toUpperCase(),
        $confirmContrasena = $('.add-new-record .confirmContrasena').val(),
        $userLevel = $('.add-new-record .userLevel').val(),
        $idReferido = $('.add-new-record .sucursal').val(),
        $sucursal = $('.sucursal option:selected').html(),
        $contrasena = $('.add-new-record .contrasena').val()
       // console.log(sucursal);
/*
        let cuenta = ($('.add-new-record .banco').val()).length;
        let $banco=0;
        if(cuenta >=6){
          $banco = $bancoData.substring(0, 2);
        }else{
          $banco = $bancoData.substring(0, 1);
        }
        let $codigo = $bancoData.substring(1, 5)
        */
        // console.log($codigo);
      if (($nombreUsuario != '') && ($nombre!='') && ($confirmContrasena!='')  && ($contrasena!='')) { 
        
          if($contrasena == $confirmContrasena){
            console.log('Guardare');
            var tipo = 1;
            var accion = 1;
            var datos =1;
                $.ajax({
                    url: '../admin/index.php?action=user', 
                    type:'POST',
                    data:{nombre : $nombre,nombreUsuario:$nombreUsuario,idReferido:$idReferido,confirmContrasena:$confirmContrasena,userLevel:$userLevel,tipo:tipo,accion:accion,datos:datos},
                    success:function(response){
                      var i = 0;
                      var tope =response.length;  
                      if(tope == 1){ 
                        for (var i = 0; i < tope; i++) {               
                             
                          dt_basic.row
                          .add({
                           
                            responsive_id : 0,
                            id: response[i].id,
                            id:  response[i].id,
                            nombre: response[i].nombre,
                            nombreUsuario:response[i].nombreUsuario,
                            userLevel: response[i].userLevel,
                            ultimoLogin: response[i].ultimoLogin,

                            created: response[i].created,
                            image: response[i].image,
                            password: response[i].password,
                            idReferido: response[i].idReferido,
                            confirmacion: 1,
                            estatus: 1
                              
                          })
                          .draw();
                          
                          
                          
                          
                          $('.add-new-record .nombre').val('');
                          $('.add-new-record .nombreUsuario').val('');
                          $('.add-new-record .contrasena').val('');
                           $('.add-new-record .confirmContrasena').val('');
                        
                        //count++;
                        $('.modal').modal('hide');
                          } 
                        } 
                        if(tope == 2){
                          Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El correo electrónico que esta intentando registrar, ya esta asociado a otro registro!'
                          
                          })
                          // console.log(response)
                       
                        }
                       
                    }
                });
          }else{
 
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Las contraseñas deben ser iguales'
            
            })
          }
     
       
      
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
        
        })
      }
    });
  
    // Delete Record
    $('.datatables-basic-users tbody').on('click', '.delete-record', function (e) {
     let id = e.target.classList[0];
     console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que eliminará definitivamente al usuario.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
           //  pagar();
           borrarUser(id);
           dt_basic.row($(this).parents('tr')).remove().draw();
       
        }
      })
   


    });
    $('div.head-label').html('<h6 class="mb-0">Clientes registrados</h6>');
  }

}

function cargarTablaArticulos(){
  var dt_basic_table_articulos = $('.datatables-basic-articulos');   
    assetPath = '../app-assets/';
  if (dt_basic_table_articulos.length) {
    
    let dataArticulos =  $('.dataArticulos').val();
    //console.log(dataArticulos);
    let arrayArticulos = "";
    arrayArticulos = JSON.parse(dataArticulos);
    var dt_basic = dt_basic_table_articulos.DataTable({
     data : arrayArticulos,
      columns: [    
        //responsive_id co_art art_des prec_vta1

        { data: 'responsive_id' },//0
        { data: 'co_art' },    //1
        { data: 'co_art' },//2
        { data: 'art_des' },//3
        { data: 'stock_act' },//4     
        { data: 'prec_vta1' },//5     
     
          
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          targets: 2,
          visible: false
        },
        {
          targets: 1,
          visible: false
        },      
        
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },
        

         {
          // Label
          targets: 4,
          render: function (data, type, full, meta) {
            var $status_number = full['stock_act'];                 
           if($status_number=='0,00'){
            return (
              '<span class="badge rounded-pill badge-light-danger  ">Agotado</span>'
            );
           }else{
            return (
            '<span class="badge rounded-pill badge-light-info  ">'+$status_number+'</span>'
            );
           }
           
          }
        },

        {
          // Label
          targets: 5,
          render: function (data, type, full, meta) {
            var $status_number = full['prec_vta1'];                 
           if($status_number=='0,00'){
            return (
              '<span class="badge rounded-pill badge-light-danger  ">'+$status_number+'</span>'
            );
           }else{
            return (
            '<span class="badge rounded-pill badge-light-success  ">'+$status_number+'</span>'
            );
           }
           
          }
        },
       
        {
        
        }
      ],
      order: [[2, 'asc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        },
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }),
          className: 'create-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modals-slide-in'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del Producto';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIdx +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ resultados",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando resultados _START_-_END_ de  _TOTAL_",
        "sInfoEmpty": "Mostrando resultados del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      }

      
    });
    

    $('div.head-label').html('<h6 class="mb-0">Articulos en inventario</h6>');
  }

}
function cargarTablaPedidos(){
  var dt_basic_table_pedidos = $('.datatables-basic-pedidos');   
    assetPath = '../app-assets/';
  if (dt_basic_table_pedidos.length) {
    
    let dataPedidos =  $('.dataPedidos').val();
    //console.log(dataArticulos);
    let arrayPedidos = "";
    arrayPedidos = JSON.parse(dataPedidos);
    var dt_basic = dt_basic_table_pedidos.DataTable({
     data : arrayPedidos,
      columns: [    
        //responsive_id co_art art_des prec_vta1
    
      
        { data: 'responsive_id' },//0
        { data: 'fact_num' },    //1
        { data: 'fact_num' },//2
        { data: 'fact_num' },//3
        { data: 'saldo' },//4
        { data: 'fec_emis' },//5  
        { data: 'forma_pag' },//6    
        { data: 'tot_bruto' },//7  
        { data: 'tot_neto' },//8     
        { data: 'iva' },//9    
        { data: '' },//  18  
       
          
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
       
        {
          targets: 1,
          visible: false
        },      
        {
          targets: 2,
          visible: false
        },   
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          width: '80px',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center col-actions">' +
              '<a class="me-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Enviar">' +
              feather.icons['send'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +
              '<a class="me-25" href="index.php?view=factura&fact_num='+full['fact_num']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +
              '<div class="dropdown">' +
              '<a class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +
              '<a href="#" class="dropdown-item">' +
              feather.icons['download'].toSvg({ class: 'font-small-4 me-50' }) +
              'Descargar</a>' +
              '<a href="index.php?view=factura_edt&fact_num='+full['fact_num']+'" class="dropdown-item">' +
              feather.icons['edit'].toSvg({ class: 'font-small-4 me-50' }) +
              'Editar</a>' +
              '<a href="#" class="dropdown-item">' +
              feather.icons['trash'].toSvg({ class: 'font-small-4 me-50' }) +
              'Anular</a>' +              
              '</div>' +
              '</div>' +
              '</div>'
            );
          }
        }, 
       
        {
        
        }
      ],
      order: [[2, 'asc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del Producto';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIdx +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ resultados",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando resultados _START_-_END_ de  _TOTAL_",
        "sInfoEmpty": "Mostrando resultados del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      }

      
    });
    

    $('div.head-label').html('<h6 class="mb-0">Listado de pedidos</h6>');
  }

}



$(document).ready(function(){
  'use strict';
  
var sidebarShop = $('.sidebar-shop'),
btnCart = $('.btn-cart'),
overlay = $('.body-content-overlay'),
sidebarToggler = $('.shop-sidebar-toggler'),
sortingDropdown = $('.dropdown-sort .dropdown-item'),
sortingText = $('.dropdown-toggle .active-sorting'),
removeItem = $('.remove-card')

if ($('.user').length) {  
  setInterval(chequearSession, 60000);
}



if ($('.cart-item-count').length) {  
  contarPedido();
}


if ($('.topVendidos').length) {  
  //Top de los productos mas vendidos
  topVendidos();
}


if ($('.factura').length) {  
  //Top de los productos mas vendidos
  $('.descargar').on('click', function(){
        const $elementoParaConvertir = document.getElementById('factura'); //
        html2pdf()
            .set({
                margin: 0.5,
                filename: 'documento.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3, 
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "in",
                    format: "a4",
                    orientation: 'portrait' // landscape o portrait
                }
            })
            .from($elementoParaConvertir)
            .save()
            .catch(err => console.log(err));
          });

}


 if (btnCart.length) {
  btnCart.on('click', function (e) {
    console.log("Pulse pedir");
    /*
    
    */
  });
}

  // Metodos q cargan las tablas diferentes tablas
  cargarDataUsers();
  cargarDataArticulos();
  cargarDataClientes();
  cargarDataVendedores();
  cargarDataPedidos();
  // Metodos q cargan las tablas diferentes tablas
 // estadisticas cuadros resumen();

$('.filtrarMeses').on('change', function () {

  var filtroMeses = $('.filtrarMeses').val();
  var vendedores = $('.comboVendedores').val();
  var label = $('.comboVendedores').text();
  console.log(label);
  var c = filtroMeses.split('').length;
  //alert(c);
  if(c==24){
    /*
    Swal.fire({
      icon: 'success',
      title: 'Estamos cargando su grafico',
      text: c
    
    });*/
    estadisticasMes(filtroMeses,vendedores);
  }else{
  
  }
  
});    

$('.search-product').keyup(function(){ 
  //console.log('A buscar y filtrar');
  let $filtro = $('.search-product').val().trim();
  $('.ecommerceProducts').html('<div class="loading">Un momento por favor...</div>');
  $('.ecommerceProducts').empty();
  cargarDataProductos($filtro,1);
  /*
  var textob=document.getElementById('txtbusca').value;
 var parametroscorreo=document.getElementById('correoy').value;
 datos="correo="+parametroscorreo+"&textoe="+textob;
        $.ajax({
          url:'procesoajax.php',
          type:'POST',
          data:datos,
        })
        .done(function(res){
            $('#respuestabusqueda').html(res)
              
        });
*/
})


if ($('.search-results').length) {
  var datos ='01';
  var cuenta = 0;
  contarRegistros(datos).then(
    function(datosDevueltos){
      cuenta= datosDevueltos[0].co_art;
    $('.search-results').html(cuenta);
  }, function(errorLanzado){
     console.log(errorLanzado);
});

}
// Paginacion del grid de articulos (pedido)
$('.pagination-pedido li a').on('click', function(){
  $('.ecommerceProducts').html('<div class="loading">Un momento por favor...</div>');

  var page = $(this).attr('data');		
  var dataString = 'page='+page;

  $.ajax({
      type: "GET",
      url: "ajax.php",
      data: dataString,
      success: function(data) {
          $('.items').fadeIn(2000).html(data);
          $('.pagination-pedido li').removeClass('active');
          $('.pagination-pedido li a[data="'+page+'"]').parent().addClass('active');
      }
  });
  return false;
});  

if ($('.pagination-pedido').length) {
  var datos ='01';
  var cuenta = 0;
  var articulosxpagina=$('.NUM_ITEMS_BY_PAGE').text();
 var contenido="";
  contarRegistros(datos).then(
    function(datosDevueltos){
      cuenta= datosDevueltos[0].co_art;
      var pagina = Math.ceil(cuenta/articulosxpagina);
      for (var i = 1; i <= pagina; i++) {
        var class_active=" ";
        if (i == 1) {
          class_active = 'active';
        }
      contenido=`<li class="page-item ${class_active}"><a class="page-link" href="#" onClick=paginar(${i},'${datos}') data="${i}">${i}</a></li>`;
      $('.pagination-pedido').append(contenido);
      }
    
  }, function(errorLanzado){
     console.log(errorLanzado);
});

}
// Paginacion del grid de articulos (carrtito de compra)
$('.pagination-cart li a').on('click', function(){
  $('.carritoItems').html('<div class="loading">Un momento por favor...</div>');

  var page = $(this).attr('data');		
  var dataString = 'page='+page;

  $.ajax({
      type: "GET",
      url: "ajax.php",
      data: dataString,
      success: function(data) {
          $('.items').fadeIn(2000).html(data);
          $('.pagination-pedido li').removeClass('active');
          $('.pagination-pedido li a[data="'+page+'"]').parent().addClass('active');
      }
  });
  return false;
});          
if ($('.pagination-cart').length) {
  contarRegistroCart(); 
}
// Paginacion del grid de articulos (carrtito de compra)

if ($('.ecommerceProducts').length) {
  
  var $filtro ='0';
  var $almacen ='01';
  var articulosxpagina=$('.NUM_ITEMS_BY_PAGE').text();

  cargarDataProductos($filtro,$almacen,articulosxpagina);

}

/// Cargar los combos de la aplicacion
if ($('.comboVendedores').length) {
  cargarCombo('.comboVendedores');

}
if ($('.comboAlmacen').length) {
  cargarComboAlma('.comboAlmacen');

}
if ($('.comboTransporte').length) {
  cargarComboTransporte('.comboTransporte');
}
if ($('.comboFormasPago').length) {
  cargarComboFormasDePago('.comboFormasPago');
}
if ($('.comboClientes').length) {
  cargarComboClientes('.comboClientes');
}

$(".comboClientes").on('change', function () {
  $(".comboClientes option:selected").each(function () {
     let elegido=$(this).val();
    console.log(elegido);  
          
      if(elegido!="seleccione"){
        
          cargarDataCliente(elegido); 
      }else{

      }
      
    
    
  });
});

if ($('.comboVendedoresUsuario').length) {
  cargarCombo('.comboVendedoresUsuario');

}
if ($('.comboAlmacenesUsuario').length) {
  cargarComboAlmacenes('.comboAlmacenesUsuario');

}
/// Cargar los combos de la aplicacion

// Metodos asociados a los botones que haran acciones de insersion dentro de la base de datos
$('.registrarPedido').on('click', function () {
  var $saldo = $('.total3').text(),       
    $co_cli = $('.comboClientes').val(),
    $co_ven = $('.identificacion').text(),
    $co_alma = $('.co_alma').text(),
    $co_almaa = $('.almacen').text(),//Sub-almacen
    $co_tran = $('.comboTransporte').val(),
    $forma_pag = $('.comboFormasPago').val(),
    $tipoFactura = $("input[type=radio][name=fiscal]:checked").val(),   
    $total_neto = $('.total3').text(),
    $total_b = $('.subtotal3').text(),
    $iva = $('.impuesto3').text(),
    $total_art= $('.totalArticulos3').text()
    //$tipoFactura = $('.comboFormasPago').val(),
    
  if (($saldo != '') && ($co_cli!='0')  && ($co_ven!='0') && ($co_tran!='0')  && ($forma_pag!='0')) {    
        var $total_bruto = $saldo-$iva;

        var tipo = 1;
        var accion = 1;
        var datos =1;
            $.ajax({
                url: '../admin/index.php?action=pedido', 
                type:'POST',
                data:{total_art:$total_art,co_almaa:$co_almaa,iva:$iva,co_alma:$co_alma,saldo:$saldo,co_cli:$co_cli,co_ven:$co_ven,co_tran:$co_tran,forma_pag:$forma_pag,total_bruto:$total_bruto,
                  total_neto:$total_neto,tipoFactura:$tipoFactura,tipo:tipo,accion:accion,datos:datos},
                success:function(response){
                  if(response=='1'){
                    Swal.fire({
                      icon: 'success',
                      title: 'Bien..',
                      text: 'Se ha registrado el pedido exitosamente!'
                    
                    })
                    $('.carritoItems').empty();
                    $('.pagination-cart').empty();
                    cargarDataFactura()
                    cargarDataCarrito();
                    contarPedido();
                    cargarDataFactura();
                    contarRegistroCart();

                  }else{
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'No hemos podido registrar su pedido, verifique e intente nuevamente!'
                    
                    })
                  }
                            
                }
            });
            
    
 
   
  
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
    
    })
  }
});
// Metodos asociados a los botones que haran acciones de insersion dentro de la base de datos

if ($('.detallesFactura').length) {
  //cargarDataFactura();

}

if ($('.carritoItems').length) {
  cargarDataCarrito();

}

if ($('.dataCorreo').length) {
  cargarDataCorreo();

}


if ($('.dataEmpresa').length) {
  cargarDataEmpresa();

}


$('.guardar').on('click', function () {
  //console.log('guardare');

  
  var $id = $('.id').val(),
    $contrasena = $('.contrasena').val(),
    $confirmContrasena = $('.confirmContrasena').val()
  if (($contrasena != '') && ($confirmContrasena!='')) { 
      if($confirmContrasena==$contrasena){
        if(($contrasena.length)>=6){
       // console.log('Guardare 2');
        var tipo = 1;
        var accion = 6;
        var datos =1;
            $.ajax({
                url: '../admin/index.php?action=user', 
                type:'POST',
                data:{id:$id,confirmContrasena:$confirmContrasena,tipo:tipo,accion:accion,datos:datos},
                success:function(response){
               //alert(response);
                  var i = 0;
                  var tope =response.length;   
                //  console.log(tope);                 
                    if(tope == 1){ 
                         
                      Swal.fire({
                        icon: 'success',
                        title: 'Bien...',
                        text: 'Ha cambiado exitosamente la clave del usaurio.'
                      
                      }),   
                      $('.id').val('');                            
                      $('.contrasena').val('');
                      $('.confirmContrasena').val('');
                    } 
                    if(tope == 2){
                  
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ha ocurrido un error en la edición de los datos!'
                      
                      })
                      // console.log(response)
                   
                    }
                   
                }
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'La contraseña a guardar debe ser mayor a 6 dígitos'
            
            })
          }
      }else{

        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Las contraseñas deben ser iguales'
        
        })
      }

    
         
          
 
   
  
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
    
    })
  }
});


$('.data-submit-correo').on('click', function () {

  var $text = $('.text').val(),
    $smtp = $('.smtp').val(),
    $password = $('.password').val(),
    $host = $('.host').val(),
    $port = $('.port').val()


  if (($text != '') && ($smtp!='') && ($password!='')  && ($host!='') && ($port!='') ) { 

       //console.log('Guardare 2');
        var tipo = 1;
        var accion = 3;
        var datos =1;
            $.ajax({
                url: '../admin/index.php?action=empresa', 
                type:'POST',
                data:{text:$text,smtp:$smtp,password:$password,host:$host,port:$port,tipo:tipo,accion:accion,datos:datos},
                success:function(response){
               //alert(response);
                  var i = 0;
                  var tope =response.length;   
                //  console.log(tope);                 
                    if(tope == 1){ 
                         
                      Swal.fire({
                        icon: 'success',
                        title: 'Bien...',
                        text: 'Los datos para el uso del correo fueron editados exitosamente.'
                      
                      }),                                     
                      
                      cargarDataCorreo();
                    } 
                    if(tope == 2){
                  
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ha ocurrido un error en la edición de los datos!'
                      
                      })
                      // console.log(response)
                   
                    }
                   
                }
            });
         
          
 
   
  
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
    
    })
  }
});



$('.enviarCorreo').on('click', function (e) {
  let media ='';
  let correo='';
  e.preventDefault();
  Swal.fire({
    title: '¿Deseas enviar?',
    text: "Esta es una prueba de envio de correo electronico.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
     let timerInterval
     Swal.fire({
       title: 'Enviando',
       html: 'Por favor, espere unos segundo mientras se esta enviando el correo, el tiempo de respuesta dependera de la velocidad de su conexión.',
       timer: 3000,
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
        // console.log('I was closed by the timer')
       }
     })

       //  pagar();
      
       enviarCorreo(media,correo);
      
   
    }
  })
});


$('.data-submit-empresa').on('click', function () {
  //console.log('guardare');
  
  var $name = $('.update-record-empresa .name').val(),
    $email = $('.update-record-empresa .email').val(),
    $telefonos = $('.update-record-empresa .telefonos').val(),
    $rif = $('.update-record-empresa .rif').val(),
    $email_ventas = $('.update-record-empresa .email_ventas').val(),
    $email_cobros = $('.update-record-empresa .email_cobros').val(),
    $direccion = $('.update-record-empresa .direccion').val()

  

  if (($name != '') && ($email!='') && ($telefonos!='')  && ($rif!='') && ($direccion!='') && ($email_ventas!='') && ($email_cobros!='') ) { 

       //console.log('Guardare 2');
        var tipo = 1;
        var accion = 2;
        var datos =1;
            $.ajax({
                url: '../admin/index.php?action=empresa', 
                type:'POST',
                data:{email_cobros:$email_cobros,email_ventas:$email_ventas,name : $name,email:$email,telefonos:$telefonos,rif:$rif,direccion:$direccion,tipo:tipo,accion:accion,datos:datos},
                success:function(response){
               //alert(response);
                  var i = 0;
                  var tope =response.length;   
                //  console.log(tope);                 
                    if(tope == 1){ 
                         
                      Swal.fire({
                        icon: 'success',
                        title: 'Bien...',
                        text: 'Los datos de la empresa fueron editados exitosamente.'
                      
                      }),                                     
                      
                      cargarDataEmpresa();
                    } 
                    if(tope == 2){
                  
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ha ocurrido un error en la edición de los datos!'
                      
                      })
                      // console.log(response)
                   
                    }
                   
                }
            });
         
          
 
   
  
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
    
    })
  }
});

//////////////// CArrito de compras //////////////////////


if ($('body').attr('data-framework') === 'laravel') {
  var url = $('body').attr('data-asset-path');
  checkout = url + 'app/ecommerce/checkout';
}


if (sortingDropdown.length) {
  sortingDropdown.on('click', function () {
    var $this = $(this);
    var selectedLang = $this.text();
    sortingText.text(selectedLang);
  });
}


if (sidebarToggler.length) {
  sidebarToggler.on('click', function () {
    sidebarShop.toggleClass('show');
    overlay.toggleClass('show');
    $('body').addClass('modal-open');
  });
}

if (overlay.length) {
  overlay.on('click', function (e) {
    sidebarShop.removeClass('show');
    overlay.removeClass('show');
    $('body').removeClass('modal-open');
  });
}


if (btnCart.length) {
  btnCart.on('click', function (e) {
    var $this = $(this),
      addToCart = $this.find('.add-to-cart');
    if (addToCart.length > 0) {
      e.preventDefault();
    }
    addToCart.text('View In Cart').removeClass('add-to-cart').addClass('view-in-cart');
    $this.attr('href', checkout);
    toastr['success']('', 'Agregado al carrito 🛒', {
      closeButton: true,
      tapToDismiss: false
    });
  });
}

});

// metodos para llenar las tablas

function cargarDataClientes(){
  if ($('#dataClientes').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=1&t=clientes', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataClientes').attr("value",cadena);
  cargarTablaClientes();


});
  }
}

function cargarDataVendedores(){
  if ($('#dataVendedores').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=VendedorData&a=1&t=vendedor', 
}).done(function(vendedores) { 
  var cadena = JSON.stringify(vendedores);
  $('.dataVendedores').attr("value",cadena);
  cargarTablaVendedores();


});
  }
}

function cargarDataUsers(){
  if ($('#dataUsers').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=UserData&a=1&t=user', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataUsers').attr("value",cadena);
  cargarTablaUsers();


});
  }
}

function cargarDataArticulos(){
  if ($('#dataArticulos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=1&t=art', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataArticulos').attr("value",cadena);
  cargarTablaArticulos();


});
  }
}

function cargarDataPedidos(){
  if ($('#dataPedidos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=PedidoData&a=1&t=pedidos', 
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataPedidos').attr("value",cadena);
  cargarTablaPedidos();


});
  }
}

// metodos para llenar las tablas

// metodos para llenar los combos
function cargarCombo(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=VendedorData&a=1&t=vendedor', 
}).done(function(dataVendedores) { 
  var i = 0;
  var tope =dataVendedores.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataVendedores[i].co_ven+'>'+dataVendedores[i].ven_des+'</option>');
  
  }  
});
}
}
function cargarComboAlma(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=AlmacenData&a=1&t=almacen', 
}).done(function(dataAlmas) { 
  var i = 0;
  var tope =dataAlmas.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataAlmas[i].co_alma+'>'+dataAlmas[i].alma_des+'</option>');
  
  }  
});
}
}
function cargarComboAlmacenes(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=SubData&a=1&t=sub_alma', 
}).done(function(dataAlmacenes) { 
  var i = 0;
  var tope =dataAlmacenes.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataAlmacenes[i].co_sub+'>'+dataAlmacenes[i].des_sub+'</option>');
  
  }  
});
}
}
function cargarComboTransporte(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=TransporteData&a=1&t=transpor', 
}).done(function(dataTransportes) { 
  var i = 0;
  var tope =dataTransportes.length;
  for (var i = 0; i < tope; i++) {
    $(combo).prepend('<option value = '+dataTransportes[i].co_tran+'>'+dataTransportes[i].des_tran+'</option>');
  }  
});
}
}
function cargarComboFormasDePago(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FormaPagoData&a=1&t=condicio', 
}).done(function(dataFormasPago) { 
  var i = 0;
  var tope =dataFormasPago.length;
  for (var i = 0; i < tope; i++) {
    $(combo).prepend('<option value = '+dataFormasPago[i].co_cond+'>'+dataFormasPago[i].cond_des+'</option>');
  }  
});
}
}
function cargarComboClientes(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=1&t=cliente', 
}).done(function(dataClientes) { 
  var i = 0;
  var tope =dataClientes.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataClientes[i].co_cli+'>'+dataClientes[i].rif+'-'+dataClientes[i].cli_des+'</option>');
  
  }  
});
}
}
// metodos para llenar los combos

function estadisticasMes(filtroMeses,vendedores){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=3&t=factura&filtro='+filtroMeses+'&p='+vendedores, 
}).done(function(meses) { 

 // var cadena = JSON.stringify(meses);
  
  //$('.dataMeses').attr("value",cadena);

 //console.log(cadena_check);
 if (meses.length === 0){Swal.fire({
  icon: 'info',
  title: 'Oops...',
  text: 'Lo sentimos, no existen facturaciones en este rango de fechas!'

});}else{ 
  
  var i = 0;
  var tope =meses.length;
  let mes = [];
  let total = [];
  for (var i = 0; i < tope; i++) {

    mes[i]=meses[i].dato2;
    total[i]=meses[i].dato1;
  
  }  

  //console.log(mes);
  estadisticaDetallada(mes,total);}
}); 
}

function cargarDataCorreo(){
  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=19&c=EmpresaData&t=empresa', 
}).done(function(correo) {  
  var i = 0;
  var tope =correo.length;
  var src='';
  if(tope>=1){   	

    for (var i = 0; i < tope; i++) { 
    $('#text').html(correo[i].text);
    $('#smtp').val(correo[i].smtp);
    $('#password').val(correo[i].password);
    $('#host').val(correo[i].host);
    $('#port').val(correo[i].port);
    
    }  
  }else{
  }
  //alert(tope);
});
}


function cargarDataEmpresa(){
  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=1&c=EmpresaData&t=empresa', 
}).done(function(empresa) {  
  var i = 0;
  var tope =empresa.length;
  var src='';
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
    $('#name').val(empresa[i].name);
    $('#name_label').html(empresa[i].name);
    $('#email').val(empresa[i].email);
    $('#email_ventas').val(empresa[i].email_ventas);
    $('#email_cobros').val(empresa[i].email_cobros);
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

function contarRegistros (datos){
  // La primera diferencia es que no se le pasa un callback,
  // La función devuelve una Promise
  return new Promise(function(resolver, rechazar){
    jQuery.ajax({
      type: "GET",
      url: '../admin/index.php?action=combos&c=ArticuloData&a=5&t=art&almacen='+datos, 
      success : function(data){resolver(data)},
      error : function(error){rechazar(error)}
    });
  });
}

function contarRegistroCart(){

  var datos ='01';
 // var cuenta = 0;
  //var articulosxpagina=$('.NUM_ITEMS_BY_PAGE').text();
 var contenido="";
    $.ajax({
      type: "GET",
      url: '../admin/index.php?action=combos&a=10&c=CarritoData&t=art',
    }).done(function(data) {  
      var tope = data.length;
     //console.log(tope);
      var pagina = Math.ceil(tope/6);
      //console.log(pagina);
      for (var i = 1; i <= pagina; i++) {
        var class_active=" ";
        if (i == 1) {
          class_active = 'active';
        }
      contenido=`<li class="page-item ${class_active}"><a class="page-link" href="#" onClick=paginar_cart(${i},'${datos}') data="${i}">${i}</a></li>`;
      $('.pagination-cart').append(contenido);
      }
    
});
}


function remover($rowId,){
removerCarrito($rowId);

  $('.'+$rowId+'').remove();
  toastr['error']('', 'Articulo Removido 🗑️', {
    closeButton: true,
    tapToDismiss: false
  });
  $('.carritoItems').empty();
  $('.pagination-cart').empty();
  cargarDataFactura()
  cargarDataCarrito();
  contarPedido();
  cargarDataFactura();
  contarRegistroCart();

}
  
function pedir($co_art,$almacen){
  var $qty = $('.'+$co_art+'').val();
  if($qty == 0){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir o escribir el numero de articulos que deseas pedir!'
    
    })

  }else{

    var tipo = 1;
    var accion = 1;
    var datos =1;
        $.ajax({
            url: '../admin/index.php?action=carrito', 
            type:'POST',
            data:{qty:$qty,co_art:$co_art,almacen:$almacen,tipo:tipo,accion:accion,datos:datos},
            success:function(response){

              if(response==1){
                toastr['success']('', 'Articulo agregado 🛒', {
                  closeButton: true,
                  tapToDismiss: false
                });
                $('.qty').val('0');
                contarPedido()
              }
              if(response==3){
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'La cantidad a pedir no existe dentro de nuestro inventario!'
                
                })
                $('.qty').val('0');
              }
            
              
            }
        });

  }
  //console.log($co_art);
  //console.log($almacen);
       
               
  

}

function removerCarrito($rowId){

  var tipo = 1;
  var accion = 3;
  var datos =1;
      $.ajax({
          url: '../admin/index.php?action=carrito', 
          type:'POST',
          data:{id:$rowId,tipo:tipo,accion:accion,datos:datos},
          success:function(response){                              
          }
      });
}
function updateQtyCarrito($rowId,$qty,$co_art){

// restar un articulo del carrito(especificamente la cantidad del articulo)

  var tipo = 1;
  var accion = 2;
  var datos =1;
      $.ajax({
          url: '../admin/index.php?action=carrito', 
          type:'POST',
          data:{co_art:$co_art,rowId:$rowId,qty:$qty,tipo:tipo,accion:accion,datos:datos},
          success:function(response){  

            if(response==1){
            
              $('.carritoItems').empty();
              $('.pagination-cart').empty();
              cargarDataFactura()
              cargarDataCarrito();
              contarPedido();
              cargarDataFactura();
              contarRegistroCart(); 
             
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La cantidad a pedir no existe dentro de nuestro inventario!'
              
              })
              
              $('.'+$rowId+'').val(response);
            } 
                                    
          }
      });

}

function cargarDataProductos($filtro,$almacen,articulosxpagina){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=4&c=ArticuloData&t=art&filtro='+$filtro+'&almacen='+$almacen, 
}).done(function(productos) {  
  var i = 0;
  var tope =productos.length;
  var contenido=""
  var co_art = "";
  var str ="";
  var pre ="";
  var sto="";
  var uni="";
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {
      co_art=productos[i].co_art;
      str=productos[i].art_des;
      pre=productos[i].prec_vta1; 
      sto =productos[i].stock_act
      uni =productos[i].suni_venta

      contenido=`<div class="col-6  "><div class=" card ecommerce-card">      
      <div class="card-body">
          <div class="item-wrapper">
              <div class="item-rating">
            
              </div>
              <div>
                  <h6 class="item-price">Precio : ${pre}</h6>
              </div>
          </div>
          <h6 class="item-name">
              <a class="text-body" href="#">${str}-(${co_art}-(${uni}))</a>
              <span class="card-text">Disponible en Stock : <a href="#" class="company-name"> ${sto}</a></span>
          </h6>
           <div class="item-quantity">
          <div class="quantity-counter-wrapper text-center">
          <div class="input-group bootstrap-touchspin mx-auto">
          <input type="number" class="touchspin-min-max form-control qty ${co_art} "
              data-bts-step="1" data-bts-decimals="0" value="0"
              id="${co_art}" name="${co_art} required">
          </div>
          </div>
        </div>
      </div>
        <div class="item-options text-center">
        <button type="button" id="${co_art}"  onClick ="pedir('${co_art}','${$almacen}')" class="btn btn-primary mt-1 btn-cart ${co_art} ${$almacen}">
        <i data-feather="shopping-cart"></i>
        <span class="add-to-cart">Pedir</span>
        </button>        
      </div></div>`;      
      $('#ecommerce-products').prepend(contenido);   
    }  
    var touchspinValue = $('.touchspin-min-max'),
    counterMin = 0,
    counterMax = 10000;
    touchspinValue
      .TouchSpin({
        min: counterMin,
        max: counterMax,
        buttondown_txt: feather.icons['minus'].toSvg(),
        buttonup_txt: feather.icons['plus'].toSvg()
      })
      .on('touchspin.on.startdownspin', function () {
        var $this = $(this);
        $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
        if ($this.val() == counterMin) {
          $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
        }
      })
      .on('touchspin.on.startupspin', function () {
        var $this = $(this);
        $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
        if ($this.val() == counterMax) {
          $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
        }
      });
  }else{
  }
  //alert(tope);
});
}

function paginar(pagina,almacen){

  var dataString = 'page='+pagina+'&almacen='+almacen;
  $('#ecommerce-products').empty();
  $.ajax({
      type: "GET",
      url: '../admin/index.php?action=paginar', 
      data: dataString,
      success: function(data) {
        console.log(data);

        var i = 0;
  var tope =data.length;
  var contenido=""
  var co_art = "";
  var str ="";
  var pre ="";
  var sto="";
  var uni="";
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {
      co_art=data[i].co_art;
      str=data[i].art_des;
      pre=data[i].prec_vta1; 
      sto =data[i].stock_act
      uni =data[i].suni_venta

      contenido=`<div class="col-6  "><div class="card ecommerce-card">      
      <div class="card-body">
          <div class="item-wrapper">
              <div class="item-rating">
            
              </div>
              <div>
                  <h6 class="item-price">Precio : ${pre}</h6>
              </div>
          </div>
          <h6 class="item-name">
          <a class="text-body" href="#">${str}-(${co_art}-(${uni}))</a>
              <span class="card-text">Disponible en Stock : <a href="#" class="company-name"> ${sto}</a></span>
          </h6>
         
      </div>
        <div class="item-options text-center">
          <a href="#" onClick ="pedir('${co_art}','${almacen}')" class="btn btn-primary btn-cart">
          <i data-feather="shopping-cart"></i>
       <span class="add-to-cart">Pedir</span>
      </a>
     
  </div></div>`;      
      $('#ecommerce-products').prepend(contenido);   
    }  
  var touchspinValue = $('.touchspin-min-max'),
    counterMin = 0,
    counterMax = 10000;
    touchspinValue
      .TouchSpin({
        min: counterMin,
        max: counterMax,
        buttondown_txt: feather.icons['minus'].toSvg(),
        buttonup_txt: feather.icons['plus'].toSvg()
      })
      .on('touchspin.on.startdownspin', function () {
        var $this = $(this);
        $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
        if ($this.val() == counterMin) {
          $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
        }
      })
      .on('touchspin.on.startupspin', function () {
        var $this = $(this);
        $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
        if ($this.val() == counterMax) {
          $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
        }
      });
    $('.pagination-pedido li').removeClass('active');
    $('.pagination-pedido li a[data="'+pagina+'"]').parent().addClass('active');
  }else{
  }
        /*
       // 
          $('#ecommerce-products').fadeIn(2000).html(data);
          $('.pagination-pedido li').removeClass('active');
          $('.pagination-pedido li a[data="'+pagina+'"]').parent().addClass('active');
          */
      }
  });
  return false;
}


function paginar_cart(pagina,almacen){

  var dataString = 'page='+pagina+'&almacen='+almacen;
  $('.carritoItems').empty();
  $.ajax({
      type: "GET",
      url: '../admin/index.php?action=paginar_cart', 
      data: dataString,
      success: function(data) {
        //console.log(data);

       //console.log(data)
 var i = 0;
 var tope =data.length;
//console.log(tope)
 var contenido=""
 var art_des = "";
 var prec_vta1 ="";
 var rowid ="";
 var qty="";
 var subtotal="";
 var ivaArt =0.00;
 var totalIva=0.00;
 var uni="";
 //console.log(tope);
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {
      art_des=data[i].art_des;
      co_art=data[i].co_art;
      prec_vta1=data[i].prec_vta1; 
      rowid =data[i].rowid;
      qty=data[i].qty;     
      subtotal =data[i].subtotal;    
      uni =data[i].suni_venta;    
      ivaArt = qty*data[i].impuesto;
      contenido=`<div class="col-6  ">
      <div class="card ecommerce-card">
   
        <div class="card-body text-center">

          <div class="item-name">
          <h7 class="mb-0"><a href="#" class="text-body">${art_des}-(${co_art}-(${uni}))</a></h7>
            <span class="badge bg-primary">C/U: ${prec_vta1}</span>
            <p></p>
            <input type="hidden" id="${rowid}" value ="${rowid}">
          </div> 
  
          <div class="item-quantity">
          <div class="quantity-counter-wrapper text-center">
          <div class="input-group bootstrap-touchspin mx-auto">
          <input type="number" class="touchspin-min-max form-control ${co_art} ${rowid}"
              data-bts-step="1" data-bts-decimals="0" value="${qty}"
              id="${co_art}" name="${co_art}">
          </div>
          </div>
          </div>

          <div class="item-name text-center">
            <div class="item-cost">
            <span class="badge bg-success ">Sub Total:${subtotal}</span>
            <p></p>
            </div>
          </div>
          </div>

          <div class="item-options ">          
            <button type="button" id="removeCard${rowid}" onClick="remover('${rowid}')" class="btn btn-primary mt-1 remove-card>">
              <i data-feather="x" class="align-middle me-25"></i>
              <span>Remover</span>
            </button>     
          </div>
      </div>
    </div>
    </div>`;      
      $('.carritoItems').fadeIn(2000).append(contenido);   
      totalIva= totalIva+ivaArt;
      var totalIvaGlobal=totalIva.toFixed(2); 
      cargarDataFactura(totalIvaGlobal);
    }  
   
  
     ///console.log('Total iva de todos los articulos del carrito->'+totalIva);
  var touchspinValue = $('.touchspin-min-max'),
  counterMin = 0,
  counterMax = 10000;
  touchspinValue
    .TouchSpin({
      min: counterMin,
      max: counterMax,
      buttondown_txt: feather.icons['minus'].toSvg(),
      buttonup_txt: feather.icons['plus'].toSvg()
    })
    .on('touchspin.on.startdownspin', function (e) {
      var $this = $(this);
      var $qty = $(this).val();
      let $row = e.target.classList[3];
      let $co_art = e.target.classList[2];    
      updateQtyCarrito($row,$qty,$co_art);
    })
    .on('touchspin.on.startupspin', function (e) {
      var $this = $(this);
      var $qty = $(this).val();
      let $row = e.target.classList[3];
      let $co_art = e.target.classList[2];
      updateQtyCarrito($row,$qty,$co_art);
    });
  
    $('.pagination-cart li').removeClass('active');
    $('.pagination-cart li a[data="'+pagina+'"]').parent().addClass('active');
  }else{
  }
        /*
       // 
          $('#ecommerce-products').fadeIn(2000).html(data);
          $('.pagination-pedido li').removeClass('active');
          $('.pagination-pedido li a[data="'+pagina+'"]').parent().addClass('active');
          */
      }
  });
  return false;
}


function cargarDataCarrito(){  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=6&c=CarritoData&t=art',
}).done(function(data) {  
 //console.log(data)
 var i = 0;
 var tope =data.length;
//console.log(tope)
 var contenido=""
 var art_des = "";
 var prec_vta1 ="";
 var rowid ="";
 var qty="";
 var subtotal="";
 var ivaArt =0.00;
 var totalIva=0.00;
 var uni ="";
 //console.log(tope);
 if(tope>=1){   
  for (var i = 0; i < tope; i++) {
    art_des=data[i].art_des;
    prec_vta1=data[i].prec_vta1; 
    rowid =data[i].rowid;
    qty=data[i].qty;     
    subtotal =data[i].subtotal;    
    co_art=data[i].co_art;
    uni=data[i].suni_venta;
    ivaArt = qty*data[i].impuesto;
   // console.log('Total iva de los articulos->'+ivaArt);

    contenido=`<div class="col-6  ">
    <div class="card ecommerce-card"> 
      <div class="card-body text-center">

        <div class="item-name">
          <h7 class="mb-0"><a href="#" class="text-body">${art_des}-(${co_art}-(${uni}))</a></h7>
          <span class="badge bg-primary">C/U: ${prec_vta1}</span>
          <p></p>
          <input type="hidden" id="${rowid}" value ="${rowid}">
        </div> 

          <div class="item-quantity">
            <div class="quantity-counter-wrapper text-center">
              <div class="input-group bootstrap-touchspin mx-auto">
                <input type="number" class="touchspin-min-max form-control ${co_art} ${rowid}"
                  data-bts-step="1" data-bts-decimals="0" value="${qty}"
                  id="${co_art}" name="${co_art}">
              </div>
            </div>
          </div>

        <div class="item-name text-center">
          <div class="item-cost">
          <span class="badge bg-success ">Sub Total: ${subtotal}</span>
          <p></p>
          </div>
        </div>
        </div>

        <div class="item-options ">        
          <button type="button" id="removeCard${rowid}" onClick="remover('${rowid}')" class="btn btn-primary mt-1 remove-card>">
            <i data-feather="x" class="align-middle me-25"></i>
            <span>Remover</span>
          </button>     
        </div>
    </div>
  </div>
   </div>`;      
  //console.log(contenido);
    $('.carritoItems').append(contenido);   
    totalIva= totalIva+ivaArt;
    var totalIvaGlobal=totalIva.toFixed(2); 
    cargarDataFactura(totalIvaGlobal);
  }  
  ///console.log('Total iva de todos los articulos del carrito->'+totalIva);
  var touchspinValue = $('.touchspin-min-max'),
  counterMin = 0,
  counterMax = 10000;
  touchspinValue
    .TouchSpin({
      min: counterMin,
      max: counterMax,
      buttondown_txt: feather.icons['minus'].toSvg(),
      buttonup_txt: feather.icons['plus'].toSvg()
    })
    .on('touchspin.on.startdownspin', function (e) {
      var $this = $(this);
      var $qty = $(this).val();
      let $row = e.target.classList[3];
      let $co_art = e.target.classList[2];
      updateQtyCarrito($row,$qty,$co_art);
      
    })
    .on('touchspin.on.startupspin', function (e) {
      var $this = $(this);
      var $qty = $(this).val();
      let $row = e.target.classList[3];
      let $co_art = e.target.classList[2];
      updateQtyCarrito($row,$qty,$co_art);
      //console.log(respuesta);
     
    });
  
  $('.carritoLleno').attr("style","display:");  
  $('.carritoVacio').attr("style","display:none");     
  //$('.pagination-pedido li').removeClass('active');
  //$('.pagination-pedido li a[data="'+pagina+'"]').parent().addClass('active');
}else{
  $('.carritoLleno').attr("style","display:none");  
  $('.carritoVacio').attr("style","display:");     
}

});
}


function cargarDataCliente($filtro){  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=2&c=ClienteData&t=cliente&filtro='+$filtro,
}).done(function(data) {  
 //console.log(data)
 var i = 0;
 var tope =data.length;
//console.log(tope)

//console.log(tope);
 if(tope>=1){   
  for (var i = 0; i < tope; i++) {    
    $('.rif').val(data[i].rif);
    $('.direccion').html(data[i].direc1);
    $('.telefonos').val(data[i].telefonos);
    $('.email').val(data[i].email);  
    
     
  }  
  
}else{

}

});
}


function cargarDataFactura(totalIvaGlobal){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=8&c=CarritoData&t=art',
}).done(function(data) { 
  //console.log(data); 
  const separar = data.split("-");
  let totalArticulos =separar[0];
  let total = separar[1];

  let subTotal =total-totalIvaGlobal;
 

 $('.impuesto').html(totalIvaGlobal);
 $('.impuesto2').html(totalIvaGlobal);
 $('.impuesto3').html(totalIvaGlobal);
  //var $subTotal = $sub_total
  $('.totalArticulos').html(totalArticulos);
  $('.subtotal').html(subTotal.toFixed(2));
  $('.total').html(total);
 

  $('.totalArticulos2').html(totalArticulos);
  $('.subtotal2').html(subTotal.toFixed(2));
  $('.total2').html(total);
 

  $('.totalArticulos3').html(totalArticulos);
  $('.subtotal3').html(subTotal.toFixed(2));
  $('.total3').html(total);
  
   
  
});
}

function contarPedido(){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=7&c=CarritoData&t=art',
}).done(function(data) {  

if(data>=1){
  $('.cart-item-count').attr("style","display:");     
  $('.cart-item-count').html(data);
}else{
  $('.cart-item-count').attr("style","display:none");     
  $('.cart-item-count').html("");
}
});
}

//funcion para traerme los productos mas vendidos
function topVendidos(){  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=11&c=ArticuloData&t=art',
}).done(function(data) {  
 //console.log(data)
 var i = 0;
 var tope =data.length;
//console.log(tope)
 var contenido=""

 var art_des = "";
 var co_art ="";
 var dato1 ="";

 //console.log(tope);
 if(tope>=1){   
  for (var i = 0; i < tope; i++) {
    art_des=data[i].art_des;
    co_art=data[i].co_art; 
    dato1 =data[i].dato1;
     

    contenido=` <div class="browser-states">
    <div class="d-flex flex-row">
    <i class="me-50 data-feather='box'></i>
        <h6 class="align-self-center mb-0">${art_des}</h6>
    </div>
    <div class="d-flex align-items-center">
        <div class="fw-bold text-body-heading me-1">${dato1}</div>
        <div class="state-chart-primary"></div>
    </div>
  </div>`;      
  //console.log(contenido);
    $('.topVendidos').append(contenido);   
  }  
 
}
});
}

function borrarUser(id){

  Swal.fire({
    title: '¿Deseas Eliminar?',
    text: "Tenga en cuenta que eliminará definitivamente al usuario.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
      var tipo = 1;
      var accion = 3;
      var datos =1;
      $.ajax({
        url: '../admin/index.php?action=user', 
        type:'post',
        data:{tipo:tipo,accion:accion,datos:datos,id:id},
        success:function(response){
         //alert(response);
            if(response == 1){      
              Swal.fire({
                icon: 'success',           
                text: 'Usuario eliminado con éxito.'            
              });
              let dt_basic_table_users = $('.datatables-basic-users');
              dt_basic_table_users.DataTable().destroy();
              
              cargarDataUsers()
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Hubo un error al desactivar.'            
              })
            }
           
        }
    });
   
    }
  })

}

function desactivarUser(id){

  Swal.fire({
    title: '¿Deseas desactivar?',
    text: "Tenga en cuenta que desactivara temporalmente el acceso a la plataforma al usuario.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
      var tipo = 1;
      var accion = 4;
      var datos =1;
      $.ajax({
        url: '../admin/index.php?action=user', 
        type:'post',
        data:{tipo:tipo,accion:accion,datos:datos,id:id},
        success:function(response){
         //alert(response);
            if(response == 1){      
              Swal.fire({
                icon: 'success',           
                text: 'Usuario desactivado con éxito.'            
              })
             // cargarDataUsers()
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Hubo un error al desactivar.'            
              })
            }
           
        }
    });
   
    }
  })

}


function activarUser(id){
  Swal.fire({
    title: '¿Deseas activar?',
    text: "Tenga en cuenta que activará  el acceso a la plataforma al usuario.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
           //  pagar();
           var tipo = 1;
           var accion = 5;
           var datos =1;
           $.ajax({
             url: '../admin/index.php?action=user', 
             type:'post',
             data:{tipo:tipo,accion:accion,datos:datos,id:id},
             success:function(response){
             //alert(response);
                 if(response == 1){      
                   Swal.fire({
                     icon: 'success',           
                     text: 'Usuario activado con éxito.'            
                   })
                   //cargarDataUsers()
                 }else{
                   Swal.fire({
                     icon: 'error',
                     title: 'Oops...',
                     text: 'Hubo un error al activado.'            
                   })
                 }
               
         }
     });
   
    }
  })
}

function cambiarClave(id){
  $("#id").val(id);

  $("#warning").modal("show");
 
  
}

function enviarCorreo(media,correo){
  var tipo = 1;
  var accion = 1;
  var datos =1;
  $.ajax({
    url: '../admin/index.php?action=enviar', 
    type:'post',
    data:{tipo:tipo,accion:accion,datos:datos,correo:correo,media:media},
    success:function(response){

      
        if(response == 1){  

          Swal.fire({
            icon: 'success',           
            text: 'Prueba de correo exitosa.'            
          })
          //window.location = "index.php?view=polizas"           

        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Hubo un error al enviar.'            
          })
        }
       
    }
});
}

function chequearSession(){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=salir_tiempo',
}).done(function(data) {  

  if(data == 1){  

    Swal.fire({
      icon: 'info',           
      text: 'Voy a salir, su tiempo de inactividad es mayor a 5min.'            
    })
    window.location = "../";           
  }
});
}




