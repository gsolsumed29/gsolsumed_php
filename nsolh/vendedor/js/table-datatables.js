
function cargarTablaPedidos(){
  
  var dt_basic_table_pedidos = $('.datatables-basic-pedidos');   
    assetPath = '../app-assets/';
  if (dt_basic_table_pedidos.length) {
    dt_basic_table_pedidos.DataTable().destroy();
    let dataPedidos =  $('.dataPedidos').val();
    //console.log(dataArticulos);
    let arrayPedidos = "";
    arrayPedidos = JSON.parse(dataPedidos);
    var dt_basic = dt_basic_table_pedidos.DataTable({
     data : arrayPedidos,
      columns: [    
        //responsive_id reci_num fec_emis des_gennomi  
        
        
        
        { data: 'responsive_id' },//0
        { data: 'reci_num' },    //1
        { data: 'reci_num' },//2
        { data: 'reci_num' },//3
    
        { data: 'fec_emis' },//4  
        { data: 'des_gennomi' },//5
        { data: '' },// 6  
       
          
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
          targets: 3,
          width: '10%'
          
        },
            
        
        
        {
          responsivePriority: 1,
          targets: 3
        },

      
        {
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="index.php?view=nomina&reci_num='+full['reci_num']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +                       
              '</div>' +
              '</div>' +
              '</div>'
            );
          }
        }, 
       
        {
        
        }
      ],
      order: [[4, 'desc']],
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
              exportOptions: { columns: [3, 4, 5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5] }
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
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Buscar',
          className: 'pagar_facturas btn btn-relief-primary',
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
      order: [[4, 'desc']],
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
    


  }

}
function cargarTablaDocumentos(){
  
  var dt_basic_table_documentos = $('.datatables-basic-documentos');   
   
  if (dt_basic_table_documentos.length) {
    dt_basic_table_documentos.DataTable().destroy();
    let dataDocumentos =  $('.dataDocumentos').val();
    //console.log(dataArticulos);
    let arrayDocumentos = "";
    arrayDocumentos = JSON.parse(dataDocumentos);
    var dt_basic = dt_basic_table_documentos.DataTable({
     data : arrayDocumentos,
      columns: [    
        //responsive_id reci_num fec_emis des_gennomi  
        
        
        
        { data: 'responsive_id' },//0

        { data: 'tipo' },    //1
        { data: 'asunto' },//2
        { data: 'fechaEmision' },//3       
        { data: 'estatus' },//4 
        { data: 'id' },             
        { data: '' },// 5  
       
          
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
          targets: 5,
          visible: false
        },
        {
          targets: 3,
          title: ' Fecha Emisión'
        },
        {
          // Label
          targets: 1,
          title: 'Tipo de documento',
          width: '30px',
          render: function (data, type, full, meta) {
            var $opcion_estado = full['tipo'];
            var $estatus = {
              1: { title: 'Constancia trabajo', class: 'badge-light-success' },
              2: { title: 'Otro documento', class: ' badge-light-info' }


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
          // Label
          targets: 4,
          title: 'Estatus',
          width: '30px',
          render: function (data, type, full, meta) {
            var $opcion_estado = full['estatus'];
            var $estatus = {
              1: { title: 'En Tramites', class: 'badge-light-info' },
              2: { title: 'Aprobada', class: ' badge-light-success' },
              3: { title: 'Rechazada', class: ' badge-light-danger' }


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

      
        {
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            var estatus = full['estatus'];
            var tipo = full['tipo'];
            var documento ="";
            if((estatus ==1) || (estatus ==3)){
              return (
                '<div class="d-flex align-items-center col-actions">' +             
                '<a class="me-25" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="No disponible">' +
                feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
                '</a>' +                       
                '</div>' +
                '</div>' +
                '</div>'
              );
            }
            
            if(estatus ==2){
              if(tipo==1)documento="rptCTrabajo";
              return (
                '<div class="d-flex align-items-center col-actions">' +             
                '<a class="me-25" href="index.php?view='+documento+'&fechaEmision='+full['fechaEmision']+'&id='+full['id']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
                feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
                '</a>' +                       
                '</div>' +
                '</div>' +
                '</div>'
              );

            }

         
          }
        }, 
       
        {
        
        }
      ],
      order: [[5, 'desc']],
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
              exportOptions: { columns: [1, 2, 3] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [1, 2, 3] }
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
      order: [[5, 'desc']],
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
    


  }

}

$(window,document,$).ready(function(){
  'use strict';


var sidebarShop = $('.sidebar-shop'),
btnCart = $('.btn-cart'),
overlay = $('.body-content-overlay'),
sidebarToggler = $('.shop-sidebar-toggler'),
sortingDropdown = $('.dropdown-sort .dropdown-item'),
sortingText = $('.dropdown-toggle .active-sorting'),
removeItem = $('.remove-card')

$('.btnEditUsuario').on('click', function () {
  var $nombre = $('.frmEditUsuario .txtEditUsuarioNombre').val().toUpperCase(),
    $nombreUsuario = $('.frmEditUsuario .txtEditUsuarioNombreUsuario').val().toUpperCase(),
    $confirmContrasena = $('.frmEditUsuario .txtEditUsuarioReContrasena').val(),   
    $contrasena = $('.frmEditUsuario .txtEditUsuarioContrasena').val(),
    $id = $('.frmEditUsuario .txtEditUsuarioIdUsuario').val()
 
    if(($confirmContrasena != '') && ($contrasena != '')){   
    if ($contrasena == $confirmContrasena) {
      //console.log('Guardare');
      var tipo = 1;
      var accion = 2;
      var datos = 1;
      $.ajax({
        url: '../admin/index.php?action=user',
        type: 'POST',
        data: { id:$id,nombre: $nombre, nombreUsuario: $nombreUsuario, confirmContrasena: $confirmContrasena, tipo: tipo, accion: accion, datos: datos },
        success: function (response) {
         
          if (response == 1) {
                 
                let timerInterval
                Swal.fire({
                  title: 'Actualizacion exitosa!',
                  html: 'Saliendo del sistema, Deberá ingresar nuevamente con sus datos.',
                  timer: 3000,
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
                    salir();
                  }
                })
              
             
              
           
          }
          if (response == 2) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El nombre de usuario que esta intentando registrar, ya esta asociado a otro registro!'

            })
            // //console.log(response)

          }

        }
      });
    } else {

      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Las contraseñas deben ser iguales'

      })
    }

  } else {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'

    })
  }
  


 
});


$("#cmbAddPersonalConstanciaTipo").on('change', function () {
  $("#cmbAddPersonalConstanciaTipo option:selected").each(function () {
    let elegido = $(this).val();
   // console.log(elegido);
    if (elegido == 1) {
      $('.frmDirigidoA').attr("style", "display:none");
    $('.textAreaAddPersonalConstanciaAsunto').val('');
      //$('.frmCiviL').prop({  style: false   });
    }
    if (elegido == 2) {
      $('.frmDirigidoA').prop({ style: false });
      //$('.frmCiviL').attr("style","display:none");
    }

    if (elegido == 0) {
      $('.frmDirigidoA').attr("style", "display:none");
      $('.textAreaAddPersonalConstanciaAsunto').val('');
      // $('.frmCiviL').attr("style","display:none");
    }


  });
});


$('.btnAddPersonalConstancia').on('click', function (e) {
  var $tipo = $('.frmAddPersonalConstancia .cmbAddPersonalConstanciaTipo').val()
  var $asunto = $('.frmAddPersonalConstancia .textAreaAddPersonalConstanciaAsunto').val()
if($asunto ==""){
  $asunto=0;
}
  if ($tipo != '0') {
    
    var tipo = 1;
    var accion = 1;
    var datos = 1;
    $.ajax({
      url: 'admin/index.php?action=personal',
      type: 'POST',
      data: { asunto: $asunto,tipo: tipo, accion: accion, datos: datos },
      success: function (response) {

        if (response == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Bien',
            text: 'Ha solicitado correctamente una constancia, debe esperar a que sea aprobada, '
          }),
            $('.frmAddPersonalConstancia .textAreaAddPersonalConstanciaAsunto').val('');
          //count++;
          $('.modalAddPersonalConstancia').modal('hide');

          //cargarDataZodis('NO');

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



$('.filtrarTopVendidos').on('change', function () {

  var filtrarTopVendidos = $('.filtrarTopVendidos').val();

 // console.log(label);
  var c = filtrarTopVendidos.split('').length;
  //alert(c);
  if(c==24){
    /*
    Swal.fire({
      icon: 'success',
      title: 'Estamos cargando su grafico',
      text: c
    
    });*/

    cargarGraficoTopMes(filtrarTopVendidos);
  }else{
  
  }
  
});  

if ($('.topMes').length) {
  cargarGraficoTopMes('NO');
}

if ($('.chartdiv_dashboard_1').length) {

  estadisticasMes_tablero();
}
if ($('.chartdiv_dashboard_2').length) {

  estadisticasMes_tablero_linea();
}
if ($('#dashboard').length) {
  $('#dashboard').ready(function() {
    //graficoFacturaciones();
    
    return false; 
  });
} else {
  // no existe
}

if ($('.m_dashboard').length) {
  resaltarMenu('.i_dashboard');
}
if ($('.m_clientes').length) {
  resaltarMenu('.i_clientes');
}
if ($('.m_articulos').length) {
  resaltarMenu('.i_articulos');
}
if ($('.m_cuentas').length) {
  resaltarMenu('.i_cuentas');
}

if ($('.m_adelantos').length) {
  resaltarMenu('.i_adelantos');
}
if ($('.m_cobros').length) {
  resaltarMenu('.i_cobros');
}

if ($('.m_pedido').length) {
  resaltarMenu('.i_pedido');
}
if ($('.m_pedidos').length) {
  resaltarMenu('.i_pedidos');
}
if ($('.m_aprobaciones').length) {
  resaltarMenu('.i_aprobaciones');
}

if ($('.m_facturaciones').length) {
  resaltarMenu('.i_facturaciones');
}

if ($('.m_visitas').length) {
  resaltarMenu('.i_visitas');
}

if ($('.m_reportexva').length) {
  resaltarMenu('.i_reportexva');
}

if ($('.m_reportexvl').length) {
  resaltarMenu('.i_reportexvl');
}



if ($('.user2').length) {  // revisar tiempo de inactividad
  setInterval(chequearSession, 60000);

}

if ($('.localizacion').length) { 
  if(navigator.geolocation){
    var success = function(position){
    var latitud = position.coords.latitude,
        longitud = position.coords.longitude;
        $('.lat').html(latitud);
        $('.lon').html(longitud);
    }

    navigator.geolocation.getCurrentPosition(success, function(msg){
    console.error( msg );
    });
    }

}

if ($('.categories-list').length) {  

  cargarDataLinea();
}

if ($('.content-body').length) {  

  cargarDataEmpresaDetalles();
}

if ($('.datosVendedor').length) {  

  cargarDataVendedor();
}

if ($('.cart-item-count').length) {  
  contarPedido();
}

if ($('.topVendidos').length) {  

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
  cargarDataPedidos(0,'NO');
  cargarDataFacturaciones(0,'NO');
  cargarDataVisitas();
  cargarDataCuentasPorCobrar();

  cargarDataAprobaciones(0,'NO');

  cargarDataDocumentos('NO');
  
  if ($('.reportexva').length) {

    estadisticasMes('NO');
    cargarDataMeses('NO');

  }

  if ($('.reportexvl').length) {

    estadisticasMesLinea('NO');
    cargarDataMesesLinea('NO');

  }
// listar clientes nos facturados

  $('.noFacturados').on('click', function (e) { 
   console.log('No facturatos');
    cargarDataNoFacturados();    
});



 // graficoReporteXA('Enero',1.00);

  // Metodos q cargan las tablas diferentes tablas
 // estadisticas cuadros resumen();
// Metodos asociados a los botones que haran acciones de insersion dentro de la base de datos

$('.anularPedidoCarrito').on('click', function (e) { 
    anularPedidoCarrito();    
});

$('.cargarPedidos').on('click', function (e) {
  var $status = $('.status').val();
  var $rango = $('.rango').val();
  console.log($status);
  console.log($rango);
  
      if($status!='NO'){
        if($rango!=' '){
          cargarDataPedidos($status,$rango);
          $('#modals-slide-in').modal('hide')
        }else{
          cargarDataPedidos($status,'NO');
          $('#modals-slide-in').modal('hide')
        }
          
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Debe elegir al menos un criterio de busqueda!'
        
        })
      }

});

$('.cargarFacturaciones').on('click', function (e) {
  var $status = $('.status').val();
  var $rango = $('.rango').val();
  console.log($status);
  console.log($rango);
  
      if($status!='NO'){
        if($rango!=' '){
          cargarDataFacturaciones($status,$rango);
          $('#modals-slide-in').modal('hide')
        }else{
          cargarDataFacturaciones($status,'NO');
          $('#modals-slide-in').modal('hide')
        }
          
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Debe elegir al menos un criterio de busqueda!'
        
        })
      }

});

$('.cargarAprobaciones').on('click', function (e) {
  var $status = $('.status').val();
  var $rango = $('.rango').val();
  console.log($status);
  console.log($rango);
  
      if($status!='NO'){
        if($rango!=' '){
          cargarDataAprobaciones($status,$rango);
          $('#modals-slide-in').modal('hide')
        }else{
          cargarDataAprobaciones($status,'NO');
          $('#modals-slide-in').modal('hide')
        }
          
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Debe elegir al menos un criterio de busqueda!'
        
        })
      }

});

$('.comboLineas').on('change', function () {
  var $filtro = $('.comboLineas').val();
  if($filtro==0){
    $('.ecommerceProducts').empty();
    paginar(1,1);
  }else{
    $('.ecommerceProducts').empty();
    cargarDataProductos($filtro,1);
  }
 
  
}); 
 
$('.comboClientesFactura').on('change', function () {
  var $co_cli = $('.comboClientesFactura').val();
    cargarDataFacturas($co_cli);
  
});   

$('.comboClientesAdelantos').on('change', function () {
  var $co_cli = $('.comboClientesAdelantos').val();
    cargarDataAdelantos($co_cli);
  
});   

$(".facturas_metodo").on('change', function () {
  $(".facturas_metodo option:selected").each(function () {
     let elegido=$(this).val();
     // console.log(elegido);        
      if(elegido=='EF'){
        $('.banco').attr("style","display:none");
        $('.cuenta').attr("style","display:none");
        $('.referencia').attr("style","display:none");
        $('.caja').attr("style","display:");      
      }
      if((elegido=='DEP') || (elegido=='CH')){
        $('.banco').attr("style","display:");
        $('.cuenta').attr("style","display:");
        $('.referencia').attr("style","display:");
        $('.caja').attr("style","display:none");         
      }

      if(elegido=='NO'){
        $('.banco').attr("style","display:none");
        $('.cuenta').attr("style","display:none");
        $('.caja').attr("style","display:none"); 
        $('.referencia').attr("style","display:none");     
      }
  });
});

$("#facturas_banco").on('change', function () {
  $("#facturas_banco option:selected").each(function () {
     let elegido=$(this).val();
      //console.log(elegido);
      if(elegido==0){
        $('#facturas_cuenta').empty();
        $('#facturas_cuenta').html('<option>Seleccione</option>');
        $('#facturas_cuenta').prop('disabled', true);       
      }else{
        $('#facturas_cuenta').empty();         
        cargarCuenta(elegido);
        $('#facturas_cuenta').prop('disabled', false);
      }
    
  });
});

$('.filtrarMeses').on('change', function () {

  var filtroMeses = $('.filtrarMeses').val();

 // console.log(label);
  var c = filtroMeses.split('').length;
  //alert(c);
  if(c==24){
    /*
    Swal.fire({
      icon: 'success',
      title: 'Estamos cargando su grafico',
      text: c
    
    });*/
    estadisticasMes(filtroMeses);
    cargarDataMeses(filtroMeses);

  }else{
  
  }
  
});    

$('.filtrarMesesLinea').on('change', function () {

  var filtroMeses = $('.filtrarMesesLinea').val();

 // console.log(label);
  var c = filtroMeses.split('').length;
  //alert(c);
  if(c==24){
    /*
    Swal.fire({
      icon: 'success',
      title: 'Estamos cargando su grafico',
      text: c
    
    });*/
    estadisticasMesLinea(filtroMeses);
    cargarDataMesesLinea(filtroMeses);

  }else{
  
  }
  
}); 


$('.search-code').keyup(function(){ 
  //console.log('A buscar y filtrar');
  let $filtro = $('.search-code').val().trim();
  if(!$filtro ==""){
    //console.log('con algo');
    $('.ecommerceProducts').empty();
    $('.search-name').val('');
    cargarDataProductos($filtro,2);
  }else{
    $('.ecommerceProducts').empty();
    paginar(1,1);
  }
})


$('.search-name').keyup(function(){ 
  //console.log('A buscar y filtrar');
  let $filtro = $('.search-name').val().trim();
  if(!$filtro ==""){
    //console.log('con algo');
    $('.ecommerceProducts').empty();
    $('.search-code').val('');
    cargarDataProductos($filtro,1);
  }else{
    $('.ecommerceProducts').empty();
    paginar(1,1);
  }
})


if ($('.cuentasPorCobrar').length) {
  console.log('Cuentas por Cobrar');
 //contarRegistroCart();
  cuentasPorCobrar();

}

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
     
if ($('.pagination-pedido').length) {
  var datos ='01';
  var cuenta = 0;
  var articulosxpagina=$('.NUM_ITEMS_BY_PAGE').text();
  contarRegistros(datos).then(
    
    function(datosDevueltos){
   
      if ($(window).width() < 768) {
        dynamicPagination(5);
      } else {
        dynamicPagination(10);
      }
   
      function dynamicPagination(visiblePages) {
        cuenta= datosDevueltos[0].co_art;
        var pagina = Math.ceil(cuenta/articulosxpagina);
        // default pagination
        $('.page1-links').twbsPagination({
          totalPages: pagina,
          visiblePages: visiblePages,
          prev: 'Prev',
          first: null,
          last: null,
          startPage: 1,
          onPageClick: function (event, page) {
            paginar(page,1);
           
            $('.pagination').find('li').addClass('page-item');
            $('.pagination').find('a').addClass('page-link');
          }
        });
      }
     
  }, function(errorLanzado){
     console.log(errorLanzado);
});

}
// Paginacion del grid de articulos (carrtito de compra)
         
if ($('.pagination-cart').length) {
  contarRegistroCart(); 
}
// Paginacion del grid de articulos (carrtito de compra)

/// Cargar los combos de la aplicacion
if ($('.comboClientesFactura').length) {
  cargarComboFacturas('.comboClientesFactura');

}

/// Cargar los combos de la aplicacion
if ($('.comboClientesAdelantos').length) {
  cargarComboFacturas('.comboClientesAdelantos');

}

/**************** */

if ($('.facturas_banco').length) {
  cargarComboBancos('.facturas_banco');
}
if ($('.facturas_caja').length) {
  cargarComboCajas('.facturas_caja');
}
if ($('.facturas_cuenta').length) {
  cargarComboCuentas('.facturas_cuenta');
}
//******************** */

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
$('.PagarFacturas').on('click', function () {

  Swal.fire({
    title: '¿Deseas acusar pago?',
    text: "Tenga en cuenta que acusara un pago por las facturas seleccionadas.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
    
  var formData = new FormData();
  var $co_cli = $('.facturas_cliente_codigo').val(),
         
  $fec_emis = $('.facturas_fecha').val(),
  $cli_des = $('.facturas_cliente').val(),
  $monto_cob = $('.facturas_monto').val(),
  $facturas =  $('.facturas_cancelar').val(),
  $forma_pag =  $('.facturas_metodo').val(), 
  $co_ban =  $('.facturas_banco').val(), 
  $co_cuenta =  $('.facturas_cuenta').val(),
  $co_caja =  $('.facturas_caja').val(),
  $moneda =  $('.facturas_moneda').val(),
  $moneda =  $('.facturas_moneda').val(),
  files = $('.facturas_documento')[0].files[0],
  $ref_ban =  $('.facturas_referencia').val(),
  ven_des = $('.user-name').text()
 

  
if (($monto_cob != '') && ($fec_emis != '') &&  ($forma_pag != 'NO') &&  ($moneda != 'NO') ) {       
      if($forma_pag == 'EF'){
          if($co_caja!='NO'){
            if (typeof files!=='undefined'){ 
         
              let timerInterval
              Swal.fire({
                title: 'Registrando',
                html: 'Por favor, espere unos segundos mientras se esta registrando el pago, el tiempo de respuesta dependera de la velocidad de su conexión.',
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
            
                if (result.dismiss === Swal.DismissReason.timer) {
             
                    const separar = $facturas.split("-");
                  
                   var  banco_des ="no";
                    var cuenta_des="no";
                   var caja_des = $('.facturas_caja option:selected').html().trim();
                    var moneda_des = $('.facturas_moneda option:selected').html().trim();

                    $co_ban ='0';
                    $co_cuenta='0';
                    $ref_ban='0';
                    var tipo = 1;
                    var accion = 1;
                    var datos =1;
                    formData.append('file',files); 
                        $.ajax({
                          url: '../admin/index.php?action=pago&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                          '&monto_cob='+$monto_cob+'&facturas='+$facturas+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
                          '&datos='+datos+'&cli_des='+$cli_des+'&banco_des='+banco_des+'&cuenta_des='+cuenta_des+'&caja_des='+caja_des+'&moneda_des='+moneda_des+'&ven_des='+ven_des, 
                            type:'POST',
                            data:formData,
                            contentType: false,
                            processData: false,
                            success:function(response){
        
                              if(response=='1'){
                                Swal.fire({
                                  icon: 'success',
                                  title: 'Bien..',
                                  text: 'Se ha registrado el pago exitosamente!'
                                
                                }),
                                $(location).attr('href','index.php?view=cobros');
                                
                              }else{
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'No hemos podido registrar su pago , verifique e intente nuevamente!'
                                
                                })
                              }
                                        
                            }
                        });            
         
                }
              })
           
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes Adjuntar un documento que valide el pago de la factura!'
              
              })
            }
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Debes elegir la caja asignada para el pago!'
            
            })
          }

      }else{

        if(($co_ban!='NO') && ($co_cuenta!='NO')  && ($ref_ban!='') ){
          if (typeof files!=='undefined'){  
            let timerInterval
            Swal.fire({
              title: 'Registrando',
              html: 'Por favor, espere unos segundos mientras se esta registrando el pago, el tiempo de respuesta dependera de la velocidad de su conexión.',
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
             
              if (result.dismiss === Swal.DismissReason.timer) {
                
                
               var  banco_des =$('.facturas_banco option:selected').html().trim();
               var  cuenta_des=$('.facturas_cuenta option:selected').html().trim();
               var  caja_des = "no";

              var   moneda_des = $('.facturas_moneda option:selected').html().trim();

                $co_caja='0';
                var tipo = 1;
                var accion = 1;
                var datos =1;
                formData.append('file',files);
                    $.ajax({
                      url: '../admin/index.php?action=pago&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                      '&monto_cob='+$monto_cob+'&facturas='+$facturas+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
                      '&datos='+datos+'&cli_des='+$cli_des+'&banco_des='+banco_des+'&cuenta_des='+cuenta_des+'&caja_des='+caja_des+'&moneda_des='+moneda_des+'&ven_des='+ven_des, 
                      type:'POST',
                      data:formData,
                      contentType: false,
                      processData: false,
                        success:function(response){
                          if(response=='1'){
                            Swal.fire({
                              icon: 'success',
                              title: 'Bien..',
                              text: 'Se ha registrado el pago exitosamente!'
                            
                            }),
                            $(location).attr('href','index.php?view=cobros');
                           
                          }else{
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'No hemos podido registrar su pago , verifique e intente nuevamente!'
                            
                            })
                          }
                                    
                        }
                    });        
              }
            })
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Debes Adjuntar un documento que valide el pago de la factura!'
            
            })
          }
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes completar todos los datos referentes al banco!'
          
          })
        }
      }

}else{
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
  
  })
}
}
  })
});


$('.PagarAdelanto').on('click', function () {

  Swal.fire({
    title: '¿Deseas acusar adelanto?',
    text: "Tenga en cuenta que acusara un pago  de adelanto.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
    
  //facturas_cancelar facturas_cliente_codigo facturas_monto facturas_metodo facturas_banco facturas_cuenta 
  //facturas_caja facturas_fecha facturas_observacion
  var formData = new FormData();
  var $co_cli = $('.facturas_cliente_codigo').val(),       
  $fec_emis = $('.facturas_fecha').val(),
  $cli_des = $('.facturas_cliente').val(),
  $monto_cob = $('.facturas_monto').val(),

  $forma_pag =  $('.facturas_metodo').val(), 
  $co_ban =  $('.facturas_banco').val(), 
  $co_cuenta =  $('.facturas_cuenta').val(),
  $co_caja =  $('.facturas_caja').val(),
  $moneda =  $('.facturas_moneda').val(),
  $moneda =  $('.facturas_moneda').val(),
  files = $('.facturas_documento')[0].files[0],
  $ref_ban =  $('.facturas_referencia').val(),
  ven_des = $('.user-name').text()
 // console.log($fec_emis);
 // console.log($forma_pag);

  
if (($monto_cob != '') && ($fec_emis != '') &&  ($forma_pag != 'NO') &&  ($moneda != 'NO') ) {       
      if($forma_pag == 'EF'){
          if($co_caja!='NO'){
            if (typeof files!=='undefined'){    

              let timerInterval
              Swal.fire({
                title: 'Registrando',
                html: 'Por favor, espere unos segundos mientras se esta registrando el adelanto, el tiempo de respuesta dependera de la velocidad de su conexión.',
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
              
                 
                    $co_ban ='0';
                    $co_cuenta='0';
                    $ref_ban='0';
                    var tipo = 1;
                    var accion = 1;
                    var datos =1;
                    formData.append('file',files);
                        $.ajax({
                          url: '../admin/index.php?action=adelanto&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                          '&monto_cob='+$monto_cob+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
                          '&datos='+datos+'&cli_des='+$cli_des+'&ven_des='+ven_des, 
                            type:'POST',
                            data:formData,
                            contentType: false,
                            processData: false,
                            success:function(response){
        
                              if(response=='1'){
                                Swal.fire({
                                  icon: 'success',
                                  title: 'Bien..',
                                  text: 'Se ha registrado el adelanto exitosamente!'
                                
                                }),
                                $(location).attr('href','index.php?view=adelantos');
                                
                              }else{
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'No hemos podido registrar su adelanto, verifique e intente nuevamente!'
                                
                                })
                              }
                                        
                            }
                        });            
         
                }
              })
           
              }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Debes Adjuntar un documento que valide el adelanto!'
                
                })
              }
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Debes elegir la caja asignada para el adelanto!'
            
            })
          }

      }else{

        if(($co_ban!='NO') && ($co_cuenta!='NO')  && ($ref_ban!='') ){
          if (typeof files!=='undefined'){  
            
            let timerInterval
            Swal.fire({
              title: 'Registrando',
              html: 'Por favor, espere unos segundos mientras se esta registrando el pago, el tiempo de respuesta dependera de la velocidad de su conexión.',
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
                $co_caja='0';
                var tipo = 1;
                var accion = 1;
                var datos =1;
                formData.append('file',files);
                    $.ajax({
                      url: '../admin/index.php?action=adelanto&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                      '&monto_cob='+$monto_cob+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
                      '&datos='+datos+'&cli_des='+$cli_des+'&ven_des='+ven_des, 
                      type:'POST',
                      data:formData,
                      contentType: false,
                      processData: false,
                        success:function(response){
                          if(response=='1'){
                            Swal.fire({
                              icon: 'success',
                              title: 'Bien..',
                              text: 'Se ha registrado el adelanto exitosamente!'
                            
                            }),
                            $(location).attr('href','index.php?view=adelantos');
                           
                          }else{
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'No hemos podido registrar su adelanto, verifique e intente nuevamente!'
                            
                            })
                          }
                                    
                        }
                    });        
              }
            })
    
          
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes Adjuntar un documento que valide el pago!'
              
              })
    
            }
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes completar todos los datos referentes al banco!'
          
          })

        }

      }

      
 

  }else{
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
  
    })
}
   
    }
  })

});

$('.registrarPedido').on('click', function () {

  var $saldo = $('.total3').text(),       
    $co_cli = $('.comboClientes').val(),
    $cli_des = $('.comboClientes option:selected').html(),
    $co_ven = $('.identificacion').text(),
    $co_alma = $('.co_alma').text(),
    $co_almaa = $('.almacen').text(),//Sub-almacen
    $co_tran = $('.comboTransporte').val(),
    $forma_pag = $('.comboFormasPago').val(),
    $tipoFactura = $("input[type=radio][name=fiscal]:checked").val(),   
    $total_neto = $('.total3').text(),
    $total_b = $('.subtotal3').text(),
    $iva = $('.impuesto3').text(),
    $observacion = $('.observacion').val(),
    $total_art= $('.totalArticulos3').text()
    //$tipoFactura = $('.comboFormasPago').val(),
    $observacion=$observacion+$tipoFactura;
    var $cantidad=$observacion.length;
    
    if (($saldo != '') && ($co_cli!='0')  && ($co_ven!='0') && ($co_tran!='0')  && ($forma_pag!='0') && ($cantidad<=60)) { 

      Swal.fire({

        title: '¿Deseas registrar el pedido?',
        text: "Tenga en cuenta que realizarà un pedido por los articulos seleccionados.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        showLoaderOnConfirm: true,
        
          preConfirm: tipo => {
            var saldo = $('.total3').text(),       
            co_cli = $('.comboClientes').val(),
            cli_des = $('.comboClientes option:selected').html(),
            co_ven = $('.identificacion').text(),
            co_alma = $('.co_alma').text(),
            co_almaa = $('.almacen').text(),//Sub-almacen
            co_tran = $('.comboTransporte').val(),
            forma_pag = $('.comboFormasPago').val(),
            tipoFactura = $("input[type=radio][name=fiscal]:checked").val(),   
            total_neto = $('.total3').text(),
            total_b = $('.subtotal3').text(),
            iva = $('.impuesto3').text(),
            observacion = $('.observacion').val(),
            total_art= $('.totalArticulos3').text()
            //$tipoFactura = $('.comboFormasPago').val(),
            observacion=observacion+tipoFactura;
      
            tipoFactura = observacion;
                  var tipo = 1;
                  var accion = 1;
                  var datos =1; 
                  var total_bruto = saldo-iva;
            return fetch(`../admin/index.php?action=pedido&tipo=${tipo}&accion=${accion}&datos=${datos}&saldo=${saldo}&co_cli=${co_cli}&cli_des=${cli_des}&co_ven=${co_ven}&co_alma=${co_alma}&
            co_almaa=${co_almaa}&co_tran=${co_tran}&forma_pag=${forma_pag}&total_bruto=${total_bruto}&total_neto=${total_neto}&iva=${iva}&tipoFactura=${tipoFactura}&total_art=${total_art}`)
              .then(response => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          }
        }).then(result => {
          console.log(result);
          
          if (result.isConfirmed) {
              if(result.value==1){
                let timerInterval
                Swal.fire({
                  title: 'Se ha registrado su pedido',
                  html: 'Por favor, espere unos segundos mientras se esta registrando su información, el tiempo de respuesta dependera de la velocidad de su conexión.',
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
               
                  if (result.dismiss === Swal.DismissReason.timer) {
      
                    window.location ='index.php?view=pedido';
            }
            })
              }
      
              if(result.value==4){
                let timerInterval
                Swal.fire({
                  title: 'Se ha generado una orden de aprovación',
                  html: 'Por favor, espere unos segundos mientras se esta registrando su información, el tiempo de respuesta dependera de la velocidad de su conexión.',
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
               
                  if (result.dismiss === Swal.DismissReason.timer) {
      
                    window.location ='index.php?view=pedido';
            }
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

$('.anularPedido').on('click', function (e) {
  e.preventDefault();
  Swal.fire({
     title: '¿Deseas Anular?',
        text: "Tenga en cuenta que Anulará éste pedido,más no será eliminado del sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          var $fact_num = $('.fact_num_anular').text()
          if (($fact_num != '') ) { 

            //console.log('anulare pedido 2');
     
             var tipo = 1;
             var accion = 4; // anular pedido
             var datos =1;
                 $.ajax({
                     url: '../admin/index.php?action=pedido', 
                     type:'POST',
                     data:{fact_num:$fact_num,tipo:tipo,accion:accion,datos:datos},
                     success:function(response){
                    //alert(response);
                       var i = 0;
                       var tope =response.length;   
                     //  console.log(tope);                 
                         if(tope == 1){ 
                              
                           Swal.fire({
                             icon: 'success',
                             title: 'Bien...',
                             text: 'Pedido anulado exitosamente.'
                           
                           }),                               
                           
                          redireccionar('index.php?view=pedidos&s=0');
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
       
        }
      })


});

$('.eliminarPedido').on('click', function (e) {
  e.preventDefault();
  Swal.fire({
     title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que Eliminará éste pedido definitivamente del sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          var $fact_num = $('.fact_num_eliminar').text()
          if (($fact_num != '') ) { 
 
     
             var tipo = 1;
             var accion = 3; // eliminar pedido
             var datos =1;
                 $.ajax({
                     url: '../admin/index.php?action=pedido', 
                     type:'POST',
                     data:{fact_num:$fact_num,tipo:tipo,accion:accion,datos:datos},
                     success:function(response){
                    //alert(response);
                       var i = 0;
                       var tope =response.length;   
                     //  console.log(tope);                 
                         if(tope == 1){ 
                              
                           Swal.fire({
                             icon: 'success',
                             title: 'Bien...',
                             text: 'Pedido eliminado exitosamente.'
                           
                           }),                                   
                           
                          redireccionar('index.php?view=pedidos&s=0');
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
       
        }
      })


});


$('.eliminarAprobacion').on('click', function (e) {
  e.preventDefault();
  Swal.fire({
     title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que Eliminará éste pedido definitivamente del sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          var $fact_num = $('.fact_num_eliminar').text()
          if (($fact_num != '') ) { 
 
     
             var tipo = 1;
             var accion = 3; // eliminar pedido
             var datos =1;
                 $.ajax({
                     url: '../admin/index.php?action=aprobacion', 
                     type:'POST',
                     data:{fact_num:$fact_num,tipo:tipo,accion:accion,datos:datos},
                     success:function(response){
                    //alert(response);
                       var i = 0;
                       var tope =response.length;   
                     //  console.log(tope);                 
                         if(tope == 1){ 
                              
                           Swal.fire({
                             icon: 'success',
                             title: 'Bien...',
                             text: 'Aprobación anulada exitosamente.'
                           
                           }),                                   
                           
                          redireccionar('index.php?view=aprobaciones&s=0');
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
       
        }
      })


});


if ($('.detallesFactura').length) {
  //cargarDataFactura();

}

if ($('.carritoItems').length) {
  cargarDataCarrito();

}


if ($('.dataEmpresa').length) {
  cargarDataEmpresa();

}


$('.data-submit-empresa').on('click', function () {
  //console.log('guardare');
  
  var $name = $('.update-record-empresa .name').val(),
    $email = $('.update-record-empresa .email').val(),
    $telefonos = $('.update-record-empresa .telefonos').val(),
    $rif = $('.update-record-empresa .rif').val(),
    $direccion = $('.update-record-empresa .direccion').val()

    console.log($name);
    console.log($telefonos);    console.log($email);    console.log($rif);    console.log($direccion);

  if (($name != '') && ($email!='') && ($telefonos!='')  && ($rif!='') && ($direccion!='') ) { 

       console.log('Guardare 2');
        var tipo = 1;
        var accion = 2;
        var datos =1;
            $.ajax({
                url: '../admin/index.php?action=empresa', 
                type:'POST',
                data:{name : $name,email:$email,telefonos:$telefonos,rif:$rif,direccion:$direccion,tipo:tipo,accion:accion,datos:datos},
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

function redireccionar($direccion){
  $(location).attr('href',$direccion);
}
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


// Cargar Data de los clientes no facturados en el periodo
function cargarDataNoFacturados(){
  if ($('#dataNoFacturados').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=50&t=factura', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataNoFacturados').attr("value",cadena);
  $('.noFacturadosTable').prop('style', 'display:yes');
  cargarTablaClientesNoFacturados();


});
  }
}
// ***************************************

function cargarDataCuentasPorCobrar(){
  if ($('#dataCuentasPorCobrar').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=15&t=factura', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataCuentasPorCobrar').attr("value",cadena);
  cargarTablaCuentasPorCobrar();


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

function cargarDataPedidos($status,$rango){
  if ($('#dataPedidos').length) {  
  
 $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=NominaData&a=13&t=snrecibo&status='+$status+'&rango='+$rango, 
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataPedidos').attr("value",cadena);
  cargarTablaPedidos();


});
  }
}

function cargarDataFacturaciones($status,$rango){
  if ($('#dataFacturaciones').length) {  
  
 $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=13&t=factura&status='+$status+'&rango='+$rango, 
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataFacturaciones').attr("value",cadena);
  cargarTablaFacturaciones();


});
  }
}

function cargarDataAprobaciones($status,$rango){
  if ($('#dataAprobaciones').length) {  
  
 $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=CotizacionData&a=13&t=cotiz_c&status='+$status+'&rango='+$rango, 
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataAprobaciones').attr("value",cadena);
  cargarTablaAprobaciones();


});
  }
}

function cargarDataFacturas($co_cli){
  
  if ($('#dataFacturas').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=16&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0',
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataFacturas').attr("value",cadena);
  cargarTablaFacturasCliente();


});
  }
}

function cargarDataMeses($filtro){
  
  if ($('#dataVentasxArticulo').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=23&c=FacturaData&t=factura&rango='+$filtro+'&filtro=0',
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataVentasxArticulo').attr("value",cadena);
  cargarTablaVentaxArticulos();


});
  }
}

function cargarDataMesesLinea($filtro){
  
  if ($('#dataVentasxLinea').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=27&c=FacturaData&t=factura&rango='+$filtro+'&filtro=0',
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataVentasxLinea').attr("value",cadena);
  cargarTablaVentaxLinea();


});
  }
}

function cargarDataAdelantos($co_cli){
  
  if ($('#dataAdelantos').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=20&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0',
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataAdelantos').attr("value",cadena);
  cargarTablaAdelantosCliente();


});
  }
}

function cargarDataVisitas(){
  if ($('#dataVisitas').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=VisitasData&a=1&t=visitas', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataVisitas').attr("value",cadena);
  cargarTablaVisitas();


});
  }
}

// metodos para llenar las tablas

// metodos para llenar los combos

function cargarComboFacturas(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=15&t=factura', 
}).done(function(dataVendedores) { 
  var i = 0;
  var tope =dataVendedores.length;
  for (var i = 0; i < tope; i++) {    
    
    $(combo).prepend('<option value = '+dataVendedores[i].co_cli+'>'+dataVendedores[i].cli_des+'</option>')
  }  
});
}
}

function cargarComboBancos(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=BancoData&a=1&t=bancos', 
}).done(function(dataBancos) { 
  var i = 0;
  var tope =dataBancos.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataBancos[i].co_ban+'>'+dataBancos[i].des_ban+'</option>');
  
  }  
});
}
}

function cargarComboCuentas(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=CuentaData&a=1&t=cuentas', 
}).done(function(dataCuentas) { 
  var i = 0;
  var tope =dataCuentas.length;
  for (var i = 0; i < tope; i++) {
    
    
    $(combo).prepend('<option value = '+dataCuentas[i].cod_cta+'>'+dataCuentas[i].num_cta+'</option>');
  
  }  
});
}
}

function cargarComboCajas(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=CajaData&a=1&t=cajas', 
}).done(function(dataCajas) { 
  var i = 0;
  var tope =dataCajas.length;
  for (var i = 0; i < tope; i++) {   
    $(combo).prepend('<option value = '+dataCajas[i].cod_caja+'>'+dataCajas[i].descrip+'</option>');
  }  
});
}
}

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

function cargarCuenta(idTipo){
  var id = idTipo;
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&t=cuentas&c=CuentaData&a=18&id='+id, 
}).done(function(cuentas) {  
  //alert(categorias);
  $('#facturas_cuenta').html('<option value = "0">Seleccione</option>');
  //console.log(cuentas);
  var i = 0;
  var tope =cuentas.length;
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {   
     

    $('#facturas_cuenta').append('<option value = '+cuentas[i].cod_cta+'>'+cuentas[i].num_cta+'</option>');
  
    }  
  }else{
    $('#facturas_cuenta').html('<option value = "0">Seleccione</option>');
  }
  //alert(tope);
});
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

function estadisticasMes(filtroMeses){
   
      $.ajax({
        type: "GET",
        url: '../admin/index.php?action=combos&c=FacturaData&a=26&t=factura&filtro='+filtroMeses, 
    }).done(function(meses) { 
    
     if (meses.length === 0){Swal.fire({
      icon: 'info',
      title: 'Oops...',
      text: 'Lo sentimos, no existen facturaciones en este rango de fechas!'
    
    });}else{ 
        const ene= meses[0].ene;
        const feb= meses[0].feb;
        const mar= meses[0].mar;
        const abr= meses[0].abr;
        const may= meses[0].may;
        const jun= meses[0].jun;
        const jul= meses[0].jul;
        const ago= meses[0].ago;
        const sep= meses[0].sep;
        const oct= meses[0].oct;
        const nov= meses[0].nov;
        const dic= meses[0].dic;
      //console.log(meses);
     // const arrMeses = ['Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
     // const arrValores = [meses[0].ene, meses[0].feb, meses[0].mar,meses[0].abr,meses[0].may,meses[0].jun,meses[0].jul,meses[0].ago,meses[0].sep,meses[0].oct,meses[0].nov,meses[0].dic];
    let mesesData =[{
      'mes' : 'Enero',
      'valor' : ene
    },
    {
      'mes' : 'Febrero',
      'valor' :feb
    },
    {
      'mes' : 'Marzo',
      'valor' :mar
    },
    {
      'mes' : 'Abril',
      'valor' :abr
    },
    {
      'mes' : 'Mayo',
      'valor' :may
    },
    {
      'mes' : 'Junio',
      'valor' :jun
    },
    {
      'mes' : 'Julio',
      'valor' :jul
    },
    {
      'mes' : 'Agosto',
      'valor' :ago
    },
    {
      'mes' : 'Septiembre',
      'valor' :sep
    },
    {
      'mes' : 'Octubre',
      'valor' :oct
    },
    {
      'mes' : 'Noviembre',
      'valor' :nov
    },{
      'mes' : 'Diciembre',
      'valor' :dic
    }];
    console.log(mesesData);
     //estadisticaDetallada(arrMeses,arrValores);
      graficoReporteXA(mesesData);
    
    }
    });  


}

function graficoFacturaciones(){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=32&t=facturas', 
}).done(function(facturaciones) { 
  let totalClientes=facturaciones[2];
  let totalFacturado =facturaciones[0];
  let totalNoFacturado=0;
  let promedio =0;

  promedio = (totalFacturado/totalClientes)*100;
  //console.log(promedio);

  //totalClientes
 // clientesFacturados
 $('.totalClientes').html(facturaciones[2]);
 $('.clientesFacturados').html(facturaciones[0]);
 estadisticasFacturaciones(promedio.toFixed(2));
}); 
}

function estadisticasMesLinea(filtroMeses){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=28&t=factura&filtro='+filtroMeses, 
}).done(function(meses) { 

 if (meses.length === 0){Swal.fire({
  icon: 'info',
  title: 'Oops...',
  text: 'Lo sentimos, no existen facturaciones en este rango de fechas!'

});}else{ 
    const ene= meses[0].ene;
    const feb= meses[0].feb;
    const mar= meses[0].mar;
    const abr= meses[0].abr;
    const may= meses[0].may;
    const jun= meses[0].jun;
    const jul= meses[0].jul;
    const ago= meses[0].ago;
    const sep= meses[0].sep;
    const oct= meses[0].oct;
    const nov= meses[0].nov;
    const dic= meses[0].dic;
  //console.log(meses);
 // const arrMeses = ['Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
 // const arrValores = [meses[0].ene, meses[0].feb, meses[0].mar,meses[0].abr,meses[0].may,meses[0].jun,meses[0].jul,meses[0].ago,meses[0].sep,meses[0].oct,meses[0].nov,meses[0].dic];
let mesesData =[{
  'mes' : 'Enero',
  'valor' : ene
},
{
  'mes' : 'Febrero',
  'valor' :feb
},
{
  'mes' : 'Marzo',
  'valor' :mar
},
{
  'mes' : 'Abril',
  'valor' :abr
},
{
  'mes' : 'Mayo',
  'valor' :may
},
{
  'mes' : 'Junio',
  'valor' :jun
},
{
  'mes' : 'Julio',
  'valor' :jul
},
{
  'mes' : 'Agosto',
  'valor' :ago
},
{
  'mes' : 'Septiembre',
  'valor' :sep
},
{
  'mes' : 'Octubre',
  'valor' :oct
},
{
  'mes' : 'Noviembre',
  'valor' :nov
},{
  'mes' : 'Diciembre',
  'valor' :dic
}];
console.log(mesesData);
 //estadisticaDetallada(arrMeses,arrValores);
  graficoReporteXA(mesesData);

}
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
  cargarDataFactura();
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


function anularPedidoCarrito(){
  var tipo = 1;
  var accion = 4;
  var datos =1;
      $.ajax({
          url: '../admin/index.php?action=carrito', 
          type:'POST',
          data:{tipo:tipo,accion:accion,datos:datos},
          success:function(response){
            if(response=='1'){
              Swal.fire({
                icon: 'success',
                title: 'Bien..',
                text: 'Se ha anulado el pedido del carrito por completo!'
              
              });
             
              cargarDataCarrito();
              contarPedido();
              cargarDataFactura();
              contarRegistroCart();
            
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No hemos podido eliminar el pedido del carrito, verifique e intente nuevamente!'
              
              })
            }
            
          }
      });
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
 //console.log('cargarDataProductos');
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

      contenido=`<div class="col-6"><div class=" card ecommerce-card">      
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
    $('#ecommerce-pagination-pedido').attr("style","display:none");
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'No existen artículos en nuestro inventario!'
    
    });
  

  }
  //alert(tope);
});
}

function paginar(pagina,almacen){
//console.log(pagina);
  var dataString = 'page='+pagina+'&almacen='+almacen;
  $('#ecommerce-products').empty();
  $('#ecommerce-pagination-pedido').attr("style","display:");
  $.ajax({
      type: "GET",
      url: '../admin/index.php?action=paginar', 
      data: dataString,
      success: function(data) {
      // console.log(data);

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

      contenido=`<div class="col-6 "><div class="card ecommerce-card">      
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
          <a href="#" onClick ="pedir('${co_art}','${almacen}')" class="btn btn-primary btn-cart">
          <i data-feather="shopping-cart"></i>
       <span class="add-to-cart">Pedir</span>
      </a>
     
  </div></div>`;      
      $('#ecommerce-products').append(contenido);   
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
      contenido=`<div class="col-6">
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

    contenido=`<div class="col-6 ">
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
  let subTotal = parseFloat(separar[1]);
  let totalGlobal2 =parseFloat(totalIvaGlobal)
  let total =subTotal+totalGlobal2;
 

 $('.impuesto').html(totalIvaGlobal);
 $('.impuesto2').html(totalIvaGlobal);
 $('.impuesto3').html(totalIvaGlobal);
  //var $subTotal = $sub_total
  $('.totalArticulos').html(totalArticulos);
  $('.subtotal').html(subTotal);
  $('.total').html(total.toFixed(2));
 

  $('.totalArticulos2').html(totalArticulos);
  $('.subtotal2').html(subTotal);
  $('.total2').html(total.toFixed(2));
 

  $('.totalArticulos3').html(totalArticulos);
  $('.subtotal3').html(subTotal);
  $('.total3').html(total.toFixed(2));
  
   
  
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

function cuentasPorCobrar(){ 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=14&c=FacturaData&t=factura', 
}).done(function(cuentas) {  
  var i = 0;
  var tope =cuentas.length;
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {       
    $('#cuentasPorCobrar').html(cuentas[i].dato1.toFixed(2));   
    }  
  }else{
  }
});
}


function cargarDataVendedor(){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=12&c=VendedorData&t=vendedor', 
}).done(function(vendedor) {  
  var i = 0;
  var tope =vendedor.length;
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
    $('#nombre').val(vendedor[i].ven_des);
    $('#direccion').val(vendedor[i].direc1);
    $('#telefono').val(vendedor[i].telefonos);
    $('#correo').val(vendedor[i].email);    
    }  
  }else{
  }
  //alert(tope);
});
}

function cargarDataLinea(){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=25&c=ArticuloData&t=art', 
}).done(function(lineas) {  
  var i = 0;
  var tope =lineas.length;
  var contenido ="";
  //console.log(lineas);
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
      $('.comboLineas').append('<option value="'+lineas[i].dato2+'">'+lineas[i].dato3+'</option>');    
    }  
    
  }else{
  }
  //alert(tope);
});
}

function facturas($co_cli){
  //console.log($co_cli);

  $('#filaFactura').empty();   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=16&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0', 
}).done(function(facturas) {  
  //console.log(facturas);
  var i = 0;
  var tope =facturas.length;
  var contenido="";
  if(tope>=1){   
   
    for (var i = 0; i < tope; i++) { 
      fact_nun=facturas[i].nro_doc;
      saldo=facturas[i].saldo;
      fec_emis=facturas[i].fec_emis;
      tipo_doc=facturas[i].tipo_doc;
      monto_net=facturas[i].dato2;
      dias=facturas[i].dato3;
      
      contenido=`<tr>
      <td><a href="javascript:facturaDetalles('${fact_nun}','${$co_cli}','${saldo}','${monto_net}');">${fact_nun}</a></td>
      <td>${tipo_doc}</td>
      <td><span class="badge rounded-pill badge-light-primary me-1"><a href="javascript:facturaDetalles('${fact_nun}','${$co_cli}','${saldo}','${monto_net}');">${saldo}</a></span></td>
      <td><a href="javascript:facturaDetalles('${fact_nun}','${$co_cli}','${saldo}','${monto_net}');">${fec_emis}</a></td>
      <td>${dias}</td>
      </tr>`;   
      $('#filaFactura').prepend(contenido);   
    }  

  $(".facturas").modal("show");
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Vaya...',
      text: 'El cliente cuyo codigo es : '+$co_cli+' No posee facturas pendientes.'
    
    })       
  }
 
});

}

function facturasPorCobrar($co_cli){
  //console.log($co_cli);

  $('#filaFactura').empty();   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=16&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0', 
}).done(function(facturas) {  
  //console.log(facturas);
  var i = 0;
  var tope =facturas.length;
  var contenido="";
  if(tope>=1){   
   
    for (var i = 0; i < tope; i++) { 
      fact_nun=facturas[i].nro_doc;
      saldo=facturas[i].saldo;
      fec_emis=facturas[i].fec_emis;
      tipo_doc=facturas[i].tipo_doc;

      
      contenido=`<tr>
      <td>${fact_nun}</td>
      <td>${tipo_doc}</td>
      <td>${saldo}</span></td>
      <td>${fec_emis}</td>
      <td>${fec_emis}</td>
      </tr>`;   
      $('#filaFactura').prepend(contenido);   
    }  

  $(".facturas").modal("show");
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Vaya...',
      text: 'El cliente cuyo codigo es : '+$co_cli+' No posee facturas pendientes.'
    
    })       
  }
 
});

}



function facturaDetalles($fact_nun,$co_cli,$saldo,$monto_net){
  //console.log($fact_nun);
  $(".facturas").modal("hide");
  $('#filaFacturaDetalles').empty();   

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=17&c=FacturaData&t=factura&fact_num='+$fact_nun+'&co_cli='+$co_cli, 
}).done(function(facturas) {  
  //console.log(facturas);
  var i = 0;
  var tope =facturas.length;
  var contenido="";
  if(tope>=1){   
   
    for (var i = 0; i < tope; i++) { 
      co_art=facturas[i].co_art;
      art_des=facturas[i].art_des;
      precio=facturas[i].precio;
      total_art=facturas[i].total_art;
      reng_neto=facturas[i].reng_neto;

      contenido=`<tr>
      <td>${co_art}</td>
      <td><span class="badge rounded-pill badge-light-primary me-1">${art_des}</span></td>
      <td>${total_art}</td>
      <td>${precio}</td>
      <td>${reng_neto}</td>
      </tr>`;   
      $('#filaFacturaDetalles').prepend(contenido);   
    }  
    $(".facturaNumero").html('Factura N° : '+$fact_nun+'    |   Saldo: '+$saldo + '    |   Neto: '+$monto_net)
  $(".facturasDetalles").modal("show");
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Vaya...',
      text: 'El cliente cuyo codigo es : '+$co_cli+' No posee facturas pendientes.'
    
    })       
  }
 
});



}


function cargarDataEmpresaDetalles(){
  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=1&c=EmpresaData&t=empresa', 
}).done(function(empresa) {  
  var i = 0;
  var tope =empresa.length;
  var src='';
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
    $('#name').html(empresa[i].name);
    $('#name2').html(empresa[i].name);
    $('#email').html(empresa[i].email);
    $('#telefonos').html(empresa[i].telefonos);
    $('#rif').html(empresa[i].rif);
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


//eliminar la visita
function borrarVisita(id){

      var tipo = 1;
      var accion = 3;
      var datos =1;
      $.ajax({
        url: '../admin/index.php?action=visitas', 
        type:'post',
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


//eliminar la visita
function resaltarMenu(componente){
$(componente).addClass('active');
}





function cargarDataDocumentos($filtro) {
  if ($('#dataDocumentos').length) {
    $.ajax({
      type: "GET",
      url: 'admin/index.php?action=personal&tipo=1&accion=2&datos=1&c=ReporteData&a=1&t=jm_solicitudes_personal',
    }).done(function (data) {

      var cadena = JSON.stringify(data);
      $('.dataDocumentos').attr("value",cadena);

      cargarTablaDocumentos();

    });
  }
}

