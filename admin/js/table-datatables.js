
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
        { data: 'bio' }, // 6
        { data: 'data1' }, // 7 /// nombre del almacen
        { data: 'data2' }, // 8 /// nombre del almacen
        { data: 'lastLogin' },//9
        { data: 'created' },//10
        { data: 'image' },  //11
        { data: 'isTrue' },  //12      
        { data: 'status' },     //13
        { data: '' }     //14
          
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
          targets: 10,
          visible: false
        },
        {
          targets: 11,
          visible: false
        },
        {
          targets: 12,
          visible: false
        },/*
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
            
            
            /*
            return (
              '<div class="d-inline-flex">' +
              '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +              
             
              '<a href="javascript:ocultar();" class="'+full['id']+' dropdown-item desactivar-record">' +
              feather.icons['alert-octagon'].toSvg({ class: 'font-small-4 me-50' }) +
              'Bloquear</a>' +
              '<a href="javascript:ocultar();" class="'+full['id']+' dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +
              '</div>' +
              '</div>'
            );*/
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
              3: { title: 'Gerente', class: 'badge-light-info' },
              4: { title: 'Despachador', class: 'badge-light-warning' },
              5: { title: 'Secretaria', class: 'badge-light-primary' },
              6: { title: 'Despachador general', class: 'badge-light-primary' }
              
            
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
          targets: 6,
          render: function (data, type, full, meta) {
            var $status_number = full['bio'];
            var $status = {
              1: { title: 'Precios tipo 1', class: 'badge-light-info' },
              2: { title: 'Precios tipo 2', class: ' badge-light-info' },
              3: { title: 'Precios tipo 3', class: ' badge-light-info' }
              
            
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
          targets: 13,
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
    
    
    
    $('.btnAddUser').on('click', function () {
      var $email = $('.add-new-record-usuario .email').val().toUpperCase(),       
        $co_ven = $('.add-new-record-usuario .comboVendedoresUsuario').val(),
        $co_alma = $('.add-new-record-usuario .comboAlmacen').val(),
        $rol = $('.add-new-record-usuario .userLevel').val(),
        $bio = $('.add-new-record-usuario .userPrecio').val(),
        $contrasena = $('.add-new-record-usuario .contrasena').val(),
        $co_sub = $('.add-new-record-usuario .comboAlmacenesUsuario').val(),
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
                    data:{co_alma:$co_alma,co_sub:$co_sub,email : $email,rol:$rol,co_ven:$co_ven,confirmContrasena:$confirmContrasena,bio:$bio,tipo:tipo,accion:accion,datos:datos},
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
                            bio: response[i].bio,
                            data1: response[i].data1,
                            data2: response[i].data2,
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
        { data: 'ven_des' },//3
        { data: 'direc1' },//4
        { data: 'telefonos' }, // 5
        { data: 'comision' },//6
        { data: 'email' },//7            
        { data: 'status' }
          
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
          targets: 6,
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
          targets: 8,
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              0: { title: 'Activo', class: 'badge-light-success' },
              1: { title: 'Inactivo', class: ' badge-light-danger' },
              2: { title: 'Suspendido', class: 'badge-light-info' }
              
            
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


function cargarTablaTipos(data) {
  var datatablesTipos = $('.datatablesTipos');
  if (datatablesTipos.length) {
    datatablesTipos.DataTable().destroy();
    var dt_basic = datatablesTipos.DataTable({
      data: data,
      columns: [

        { data: 'responsive_id' },//0
        { data: 'id' },    //1 
        { data: 'tipo' },//2      
        { data: 'estatus' },//3
        { data: '' }     //4

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
          title: 'Tipo'
        },

 
        {
          // Label
          targets: 3,
          title: 'Estatus',
          width: '30px',
          render: function (data, type, full, meta) {
            var $opcion_estado = full['status'];
            var $estatus = {
              0: { title: 'Desactivado', class: 'badge-light-danger' },
              1: { title: 'Activo', class: ' badge-light-success' }


            };
            if (typeof $estatus[$opcion_estado] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $estatus[$opcion_estado].class +
              '">' +
              $estatus[$opcion_estado].title +
              '</span>'
            );
          }
        },


        {
          responsivePriority: 1,
          targets: 3
        },

        {   // Actions
          targets: -1,
          title: 'Acciones',
          orderable: false,
          width: '30px',
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-flex">' +
              '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +
              '<a href="javascript:editarTipo(\'' + full['id'] + '\');"  class="dropdown-item edit-record">' +
              feather.icons['edit'].toSvg({ class: 'font-small-4 me-50' }) +
              'Editar</a>' +
             
           
              '</div>' +
              '</div>'
            );
          }
        }


      ],
      order: [[1, 'asc']],
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
              exportOptions: { columns: [2, 3] }
            },

            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3] }
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
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Agregar nuevo',
          className: 'create-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddTipo'
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
              return 'Detalles Tipo';
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



    // Delete Record
    $('.datatablesTipos tbody').on('click', '.delete-record', function (e) {
      let id = e.target.classList[0];
      //console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que solo deshabitará  para efectos de registo, no sera una eliminacion completa",
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
          var accion = 4;
          var datos = 1;
          $.ajax({
            url: '../admin/index.php?action=tipos',
            type: 'post',
            data: { tipo: tipo, accion: accion, datos: datos, id: id },
            success: function (response) {
              //alert(response);
              if (response == 1) {
                Swal.fire({
                  icon: 'success',
                  text: 'Tipo desactivado con éxito.'
                }),
                  cargarDataTipos('NO');
              } else {
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



    });
    // Delete Record
    $('.datatablesTipos tbody').on('click', '.activar-record', function (e) {
      let id = e.target.classList[0];
      //console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Activar?',
        text: "Tenga en cuenta que Activarà para efectos de registo",
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
          var datos = 1;
          $.ajax({
            url: '../admin/index.php?action=tipos',
            type: 'post',
            data: { tipo: tipo, accion: accion, datos: datos, id: id },
            success: function (response) {
              //alert(response);
              if (response == 1) {
                Swal.fire({
                  icon: 'success',
                  text: 'Tipo Activado con éxito.'
                }),
                  cargarDataTipos('NO');
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Hubo un error al Activar.'
                })
              }

            }
          });


        }
      })



    });

    // $('div.head-label').html('<h6 class="mb-0">Entidades bancarias registradas</h6>');
  }

}

function cargarTablaParametros(data) {
  var datatablesParametros = $('.datatablesParametros');
  if (datatablesParametros.length) {
    datatablesParametros.DataTable().destroy();
    var dt_basic = datatablesParametros.DataTable({
      data: data,
      columns: [



        { data: 'responsive_id' },//0
        { data: 'id' },    //1 
        { data: 'tipo' },//2
        { data: 'ven_des' },//3
        { data: 'valor' },//4
        { data: 'finicio' },//5
        { data: 'ffinal' },//6
        { data: 'estatus' },//7
        { data: 'co_ven' },//8
        { data: '' }     //9

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
          title: 'TIPO'
        },
        {
          targets: 8,
          visible: false
        },
        {
          targets: 3,
          title: 'VENDEDOR'
        },
        {
          targets: 4,
          title: 'VALOR'
        },
          {
          targets: 5,
          title: 'FECHA DE INICIO'
        },
        {
          targets: 6,
          title: 'FECHA FINAL'
        },
       
        {
          // Label
          targets: 7,
          title: 'Estatus',
          width: '30px',
          render: function (data, type, full, meta) {
            var $opcion_estado = full['estatus'];
            var $estatus = {
              0: { title: 'Desactivado', class: 'badge-light-danger' },
              1: { title: 'Activo', class: ' badge-light-success' }


            };
            if (typeof $estatus[$opcion_estado] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $estatus[$opcion_estado].class +
              '">' +
              $estatus[$opcion_estado].title +
              '</span>'
            );
          }
        },


        {
          responsivePriority: 1,
          targets: 3
        },

        {   // Actions
          targets: -1,
          title: 'Acciones',
          orderable: false,
          width: '30px',
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-flex">' +
              '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
              feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +             
              '<a href="javascript:;" class="' + full['id'] + ' dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +            
              '</div>' +
              '</div>'
            );
          }
        }


      ],
      order: [[1, 'asc']],
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
              exportOptions: { columns: [2, 3] }
            },

            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3] }
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
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Agregar nuevo',
          className: 'create-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddMarca'
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
              return 'Detalles MARCA';
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


    // Delete Record
    $('.datatablesMarcas tbody').on('click', '.delete-record', function (e) {
      let id = e.target.classList[0];
      //console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que solo deshabitará  para efectos de registo, no sera una eliminacion completa",
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
          var accion = 4;
          var datos = 1;
          $.ajax({
            url: '../admin/index.php?action=marcas',
            type: 'post',
            data: { tipo: tipo, accion: accion, datos: datos, id: id },
            success: function (response) {
              //alert(response);
              if (response == '1') {
                Swal.fire({
                  icon: 'success',
                  text: 'Marca desactivada con éxito.'
                }),
                  cargarDataMarcas('NO');
              } else {
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



    });
    // Delete Record
    $('.datatablesMarcas tbody').on('click', '.activar-record', function (e) {
      let id = e.target.classList[0];
      //console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Activar?',
        text: "Tenga en cuenta que Activarà para efectos de registo",
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
          var datos = 1;
          $.ajax({
            url: '../admin/index.php?action=marcas',
            type: 'post',
            data: { tipo: tipo, accion: accion, datos: datos, id: id },
            success: function (response) {
              //alert(response);
              if (response == 1) {
                Swal.fire({
                  icon: 'success',
                  text: 'Marca Activada con éxito.'
                }),
                  cargarDataMarcas('NO');
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Hubo un error al Activar.'
                })
              }

            }
          });


        }
      })



    });

    // $('div.head-label').html('<h6 class="mb-0">Entidades bancarias registradas</h6>');
  }

}


$(document).ready(function(){
  'use strict';

      // Configurar fecha mínima como hoy
    var today = new Date();
    var config = {
        locale: 'es',
        dateFormat: 'd/m/Y',
        minDate: today,
        allowInput: false
    };
    
    // Inicializar los datepickers
    $('.finicio').flatpickr(config);
    $('.ffinal').flatpickr(config);
  
var sidebarShop = $('.sidebar-shop'),
btnCart = $('.btn-cart'),
overlay = $('.body-content-overlay'),
sidebarToggler = $('.shop-sidebar-toggler'),
sortingDropdown = $('.dropdown-sort .dropdown-item'),
sortingText = $('.dropdown-toggle .active-sorting');

  //////////////////////TIPOS /////////////////////////
  $('.btnAddTipo').on('click', function () {
    //alert('add tipo');
    var $caracteristica = $('.txtAddTipo').val() 
   
    if (($caracteristica != '')) {

      var tipo = 1;
      var accion = 1;
      var datos = 1;
      $.ajax({
        url: '../admin/index.php?action=tipos',
        type: 'POST',
        data: { caracteristica: $caracteristica, tipo: tipo, accion: accion, datos: datos },

          beforeSend: function() {
              let timerInterval
                      Swal.fire({
                        title: 'Guardando',
                        html: 'Registrando datos...',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading();                  
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        
                })
         },
        success: function (response) {

          if (response == '1') {
            Swal.fire({
              icon: 'success',
              title: 'Bien',
              text: 'Se ha Guardado correctamente'
            }),
              $('.txtAddTipo').val('');
            //count++;
            $('.modalAddTipo').modal('hide');    
            cargarDataTipos('NO');

          }
            if (response == 2) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El nombre del Tipo que desea registrar, ya esta asociado a otro registro!'

            })
            // console.log(response)

          }
       

        }
      });


    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'

      })
    }
  });

  $('.btnEditTipo').on('click', function (e) {
    var $caracteristica = $('.frmEditTipo .txtEditTipo').val(),   
      $id = $('.frmEditTipo .txtEditIdTipo').val()
    //console.log($redi);

    if (($caracteristica != '')) {

      var tipo = 1;
      var accion = 3;
      var datos = 1;
      $.ajax({
        url: '../admin/index.php?action=tipos',
        type: 'POST',
        data: { id: $id, caracteristica: $caracteristica, tipo: tipo, accion: accion, datos: datos },
        success: function (response) {
          if (response == '1') {
            Swal.fire({
              icon: 'success',
              title: 'Bien',
              text: 'Se ha actualizado correctamente'
            }),
              $('.frmEditTipo .txtEditTipo').val('');
            $('.frmEditTipo .txtEditIdTipo').val('');
            //count++;
            $('.modalEditTipo').modal('hide');

            cargarDataTipos('NO');

          }
          if (response == '2') {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El nombre del  TIPO que desea registrar, ya esta asociado a otro registro!'

            })
            // console.log(response)

          }
          if (response == '3') {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'error.! Hubo un problema al guardar'

            })
            // console.log(response)

          }

        }
      });


    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'

      })
    }
  });
  //////////////////////////////////////////////////////////



  //////////////////////TIPOS /////////////////////////
  $('.btnAddParametro').on('click', function () {
    //alert('add tipo');
    var $caracteristica = $('.txtAddTipo').val() 
   
    if (($caracteristica != '')) {

      var tipo = 1;
      var accion = 1;
      var datos = 1;
      $.ajax({
        url: '../admin/index.php?action=tipos',
        type: 'POST',
        data: { caracteristica: $caracteristica, tipo: tipo, accion: accion, datos: datos },

          beforeSend: function() {
              let timerInterval
                      Swal.fire({
                        title: 'Guardando',
                        html: 'Registrando datos...',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading();                  
                        },
                        willClose: () => {
                          clearInterval(timerInterval)
                        }
                      }).then((result) => {
                        /* Read more about handling dismissals below */
                        
                })
         },
        success: function (response) {

          if (response == '1') {
            Swal.fire({
              icon: 'success',
              title: 'Bien',
              text: 'Se ha Guardado correctamente'
            }),
              $('.txtAddTipo').val('');
            //count++;
            $('.modalAddTipo').modal('hide');    
            cargarDataTipos('NO');

          }
            if (response == 2) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El nombre del Tipo que desea registrar, ya esta asociado a otro registro!'

            })
            // console.log(response)

          }
       

        }
      });


    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'

      })
    }
  });



$('.btnGuardarParametroValor').on('click', function (e) {
    // Obtener valores de los campos
    var $vendedor = $('.comboVendedoresUsuario').val();
    var $indicador = $('.comboVendedoresIndicador').val();
    var $valor = $('.txtAddValor').val();
    var $fechaInicio = $('.finicio').val();
    var $fechaFinal = $('.ffinal').val();
    
    // Validar campos
    var errores = [];
    
    if (!$vendedor || $vendedor === '') {
        errores.push('Debe seleccionar un vendedor');
    }
    
    if (!$indicador || $indicador === '') {
        errores.push('Debe seleccionar un indicador');
    }
    
    if (!$valor || $valor <= 0) {
        errores.push('Debe ingresar un valor válido mayor a 0');
    }
    
    if (!$fechaInicio || $fechaInicio === '') {
        errores.push('Debe seleccionar una fecha de inicio');
    }
    
    if (!$fechaFinal || $fechaFinal === '') {
        errores.push('Debe seleccionar una fecha final');
    }
    
    // Validar que la fecha final sea posterior a la fecha de inicio
    if ($fechaInicio && $fechaFinal) {
        // Convertir fechas al formato correcto para comparación (dd/mm/yyyy)
        var partesInicio = $fechaInicio.split('/');
        var partesFinal = $fechaFinal.split('/');
        
        // Crear objetos Date (año, mes-1, día)
        var inicio = new Date(partesInicio[2], partesInicio[1] - 1, partesInicio[0]);
        var fin = new Date(partesFinal[2], partesFinal[1] - 1, partesFinal[0]);
        
        // Validar que la fecha final sea mayor que la fecha de inicio
        if (fin < inicio) {
            errores.push('La fecha final no puede ser anterior a la fecha de inicio');
        }
    }
    
    // Si hay errores, mostrarlos con SweetAlert2
    if (errores.length > 0) {
        // Crear mensaje de error con lista
        var mensajeError = 'Por favor, corrija los siguientes errores:<br>';
        errores.forEach(function(error) {
            mensajeError += '<b>• ' + error + '</b><br>';
        });
        
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            html: mensajeError,
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#0343a5'
        });
        
        return false;
    }
    
    // Si todos los campos son válidos, proceder con AJAX
    var accion = 1; // Suponiendo que 1 es para agregar
    var datos = 2;
    
    $.ajax({
        url: '../admin/index.php?action=parametros',
        type: 'POST',
        data: { 
            vendedor: $vendedor, 
            indicador: $indicador, 
            valor: $valor, 
            fechaInicio: $fechaInicio, 
            fechaFinal: $fechaFinal, 
            accion: accion, 
            datos: datos 
        },
        success: function (response) {
            if (response == '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Se ha guardado correctamente',
                    confirmButtonColor: '#0343a5'
                });
                
                // Limpiar campos
                $('.comboVendedoresUsuario').val('').trigger('change');
                $('.comboVendedoresIndicador').val('').trigger('change');
                $('.txtAddValor').val('');
                $('.finicio').val('');
                $('.ffinal').val('');
                
                // Cerrar modal
                $('#modalAddMarca').modal('hide');
                
                // Recargar datos si es necesario
                cargarDataParametros('NO');
            }
            else if (response == '2') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El parámetro que desea registrar ya existe!',
                    confirmButtonColor: '#0343a5'
                });
            }
            else if (response == '3') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al guardar. Intente nuevamente.',
                    confirmButtonColor: '#0343a5'
                });
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Respuesta inesperada del servidor: ' + response,
                    confirmButtonColor: '#0343a5'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Intente nuevamente.',
                confirmButtonColor: '#0343a5'
            });
        }
    });
});
  //////////////////////////////////////////////////////////





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
  cargarDataTipos('NO');
  cargarDataParametros('NO');


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

if ($('.comboVendedoresIndicador').length) {
  cargarComboIndicadores('.comboVendedoresIndicador');
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


$('.btnActualizarEmpres').on('click', function () {

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



$('.btnEnviarCorreo').on('click', function (e) {
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

function cargarDataTipos($filtro) {
  if ($('#dataTipos').length) {
    $.ajax({
      type: "GET",
      url: '../admin/index.php?action=tipos&tipo=1&accion=2&datos=1&c=TipoData&a=1&t=tipo',
    }).done(function (data) {
      cargarTablaTipos(data);

    });
  }
}

function cargarDataParametros($filtro) {
  if ($('#dataParametros').length) {
    $.ajax({
      type: "GET",
      url: '../admin/index.php?action=parametros&tipo=1&accion=2&datos=1&c=ParametroData&a=1&t=jm_indicador',
    }).done(function (data) {

      cargarTablaParametros(data);

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
}).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+data[i].co_ven+'>'+data[i].ven_des+'</option>');
  
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


function cargarComboIndicadores(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=IndicadorData&a=1&t=jm_type', 
  }).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {
    $(combo).prepend('<option value = '+data[i].dato1+'>'+data[i].dato2+'</option>');  
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

function editarTipo($id) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=tipos&tipo=1&accion=2&datos=2&c=TipoData&a=1&t=tipo&d=' + $id,
  }).done(function (data) {
    // console.log(tipo);
    var i = 0;
    var tope = data.length;
    var caracteristica = '0';
    var tipos = '';
    for (var i = 0; i < tope; i++) {
      tipos = data[i].tipo; 
     
      $('.frmEditTipo .txtEditTipo').val(tipos),
        $('.frmEditTipo .txtEditIdTipo').val($id)
    
      // $('.frmEditTipo .txtEditIdTipo').val($id)
    }

    $(".modalEditTipo").modal("show");
  });

}
