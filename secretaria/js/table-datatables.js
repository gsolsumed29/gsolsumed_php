

function cargarTablaClientesVisitas(){
  var dt_basic_table_clientes_visitas = $('.datatables-basic-clientes-visitas');   
  // Advanced Filter table
  if (dt_basic_table_clientes_visitas.length) {
    
  $('input.dt-input').on('keyup', function () {
    filterColumn($(this).attr('data-column'), $(this).val());
  });

    let dataClientesVisitas =  $('.dataClientesVisitas').val();
    //console.log(dataUsuarios);
    let arrayClientes = "";
    arrayClientes = JSON.parse(dataClientesVisitas);
    var dt_adv_filter = dt_basic_table_clientes_visitas.DataTable({
      data : arrayClientes,
      columns: [
        { data: 'responsive_id' },//0
        { data: 'co_cli' },    //1
        { data: 'co_cli' },//2
        { data: 'cli_des' },//3  
        { data: 'rif' },//4    
        { data: 'telefonos' }, // 6     
        { data: '' }//  8 
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
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            var co_cli = full['co_cli'].trim();
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="javascript:localizacion(\''+co_cli+'\');" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['map-pin'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>'  +                       
              '</div>' +
              '</div>' +
              '</div>'
            );
          }
        }, 
       
       
        {
        
        }
      ],
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      orderCellsTop: true,
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['cli_des'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
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

            return data ? $('<table class="table"/><tbody />').append(data) : false;
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
  }
}
function filterColumn(i, val) {
  if (i == 5) {
    var startDate = $('.start_date').val(),
      endDate = $('.end_date').val();
    if (startDate !== '' && endDate !== '') {
      filterByDate(i, startDate, endDate); // We call our filter function
    }

    $('.dt-advanced-search').dataTable().fnDraw();
  } else {
    $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();
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

  
if ($('.ecommerceProducts').length) {
 // console.log('Abre modal');
  $("#modalClientes").modal("show");
}

if ($('.comboClientesZonas').length) {
  cargarComboZonas('.comboClientesZonas');

}

if($('.comboZonaClientesFacturados').length) {
  cargarComboZona('.comboZonaClientesFacturados');
}

if ($('.tablaTopMasPagos').length) {
 
  cargarTablaTopMasMenosPagos('NO','NO','1');
}


if ($('.tablaTopMenosPagos').length) {
  cargarTablaTopMasMenosPagos('NO','NO','0');
}
if ($('.dataArticulosVolumen').length) {
  var $co_ven = $('.identificacion').text();  
  cargarDataArticuloVolumen($co_ven,'NO','NO','NO');
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


if ($('#comboClientes').length) {
  cargarDataComboFiltros('.comboClientes', 1);
}



if ($('.content-body').length) {  

  cargarDataEmpresaDetalles();
}



  // Metodos q cargan las tablas diferentes tablas
  
  cargarDataVisitas();
  cargarDataClientesVisitas();





if ($('.dataEmpresa').length) {
  cargarDataEmpresa();

}



if ($('body').attr('data-framework') === 'laravel') {
  var url = $('body').attr('data-asset-path');
  checkout = url + 'app/ecommerce/checkout';
}


$('.guardarLocalizacion').on('click', function () {
  let formData = new FormData();
  let $co_cli = $('.co_cli').val(),
    $localizacion = $('#localizacion').val()   
  let files1 = $('#foto')[0].files[0];

  //console.log( $localizacion)   
 
  if (( $localizacion != '')) {
    if (typeof files1 !== 'undefined') {
      formData.append('file1', files1);
     
      $.ajax({
        url: '../admin/index.php?action=cliente&co_cli='+$co_cli+'&localizacion=' + $localizacion + '&tipo=1&accion=2&datos=1',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {

          if (response == '1') {
            Swal.fire({
              icon: 'success',
              title: 'Bien',
              text: 'Se ha Guardado correctamente'
            }),
            $('.localizacion').val('')
         
            //count++;
            $('.cliente_localizacion').modal('hide');

           // cargarDataArmamentos($idPersonal);

          }
          

        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Debes elegir una  imagen del local para guardar'

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

function cargarDataClientesVisitas(){
  if ($('#dataClientesVisitas').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=1111&t=clientes', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataClientesVisitas').attr("value",cadena);
  cargarTablaClientesVisitas();


});
  }
}


function cargarDataVisitas(){
  if ($('#dataVisitas').length) {
    let $co_cli =$('#co_cli').text();   
   // console.log($co_cli);
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=VisitasData&a=2&t=visitas&filtro='+$co_cli, 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataVisitas').attr("value",cadena);
  cargarTablaVisitas();


});
  }
}



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

function cargarComboCategorias(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=25&t=art', 
}).done(function(dataCategorias) { 
  var i = 0;
  var tope =dataCategorias.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataCategorias[i].dato2+'>'+dataCategorias[i].dato3+'</option>');
  
  }  
});
}
}

function cargarComboTiposPrecios(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=98&t=art', 
}).done(function(tipoPrecios) { 
  var i = 0;
  var tope =tipoPrecios.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+tipoPrecios[i].dato2+'>'+tipoPrecios[i].dato3+'</option>');
  
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


function cargarComboClientesData(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=111&t=cliente', 
}).done(function(dataClientes) { 
  var i = 0;
  var tope =dataClientes.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataClientes[i].co_cli+'>'+dataClientes[i].rif+'-'+dataClientes[i].cli_des+'</option>');
  
  }  
});
}
}

function cargarComboClientesPrecio(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=999&t=cliente', 
}).done(function(dataClientes) { 
  var i = 0;
  var tope =dataClientes.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataClientes[i].tipo_precio+'>'+dataClientes[i].co_cli+'-'+dataClientes[i].cli_des+'</option>');
  
  }  
});
}
}
// metodos para llenar los combos


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

function cargarDataComboFiltros($combo,$filtro){
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
      $($combo).append('<option value="'+lineas[i].dato2+'">'+lineas[i].dato3+'</option>');    
    }  
    
  }else{
  }
  //alert(tope);
});
}

function localizacion($co_cli){
  //console.log($co_cli);
  $('.co_cli').val(''); 
  $('.localizacion').val(''); 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=112&c=ClienteData&t=clientes&filtro='+$co_cli, 
}).done(function(localizacion) {  
 // console.log(localizacion);
  var i = 0;
  var tope =localizacion.length;
  var contenido="";
  if(tope>=1){   
  $('.co_cli').val($co_cli); 
  $('.localizacion').val(localizacion[0].localizacion); 
  
  $(".cliente_localizacion").modal("show");
  }else{
  $('.co_cli').val($co_cli);   
  $(".cliente_localizacion").modal("show");
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
function resaltarMenu(componente){
$(componente).addClass('active');
}



