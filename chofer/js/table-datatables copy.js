

function cargarTablaFacturasCliente(){

  var datatables_basic_facturas = $('.datatables-basic-facturas');

  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataFacturas =  $('.dataFacturas').val();
    let arrayFacturas = "";
    arrayFacturas = JSON.parse(dataFacturas);
    var dt_basic = datatables_basic_facturas.DataTable({
      data : arrayFacturas,
      columns: [
        //nro_doc saldo fec_emis tipo_doc
        { data: 'responsive_id' },//0
        { data: 'dato1' },//1
        { data: 'dato1' }, //2
        { data: 'dato2' },//3
        { data: 'dato3' },//4
        { data: 'dato4' },//5
        { data: '' }//6
    
       
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
          targets: 5,
          visible: false
        },
        {
          targets: 3,
          visible: false
        },
           
        {   // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            var fact_num = full['dato1'].trim();
            var dato4 = full['dato4'].trim();
            return (
              '<div class="d-inline-flex">' +                   
              '<a class="btn btn-relief-primary  me-1" href="javascript:seleccionar(\''+fact_num+'\',\''+dato4+'\');" data-bs-toggle="tooltip" data-bs-placement="top" title="Despachar">' +
              feather.icons['truck'].toSvg({ class: 'font-small-4 me-50' }) +
              '</a>' +  
              '</a>' +         
              
              '</div>' +
              '</div>'
            );
          }
         }, 
     
        {
          responsivePriority: 1,
          targets: 2
        }
      ],
      order: [[3, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
           
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
              exportOptions: { columns: [2,3, 4] }
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
          className: ' btn btn-relief-info',
          
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalBuscarFactura'
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
              return 'Detalles de la factura';
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
   
  
   


    $('div.head-label').html('<h6 class="mb-0">Facturacion</h6>');
  }
  
}



function cargarTablaFacturasClienteDevolucion(){

  var datatables_basic_facturas = $('.datatables-basic-facturas');

  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataFacturas =  $('.dataFacturas').val();
    let arrayFacturas = "";
    arrayFacturas = JSON.parse(dataFacturas);
    var dt_basic = datatables_basic_facturas.DataTable({
      data : arrayFacturas,
      columns: [
        //nro_doc saldo fec_emis tipo_doc
        { data: 'responsive_id' },//0
        { data: 'dato1' },//1
        { data: 'dato1' }, //2
        { data: 'dato2' },//3
        { data: '' }//4
    
       
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
           
        {   // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            var fact_num = full['dato1'].trim();
            return (
              '<div class="d-inline-flex">' +                   
             
              '<a href="#" class="'+fact_num+' dropdown-item devolver">' +
              feather.icons['corner-up-left'].toSvg({ class: 'font-small-4 me-50' }) +
              'Devolver</a>' +  
              '</div>' +
              '</div>'
            );
          }
         }, 
      
        {
          responsivePriority: 1,
          targets: 2
        }
      ],
      order: [[3, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
           
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
              orientation: 'landscape',
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
    
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de la factura';
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
   
  
   
      // desactivar usaurio
      $('.datatables-basic-facturas tbody').on('click', '.devolver', function (e) {
        $('.dtr-modal').hide();
          let id = e.target.classList[0];
         console.log(id);
           e.preventDefault();
           Swal.fire({
             title: '¿Deseas devolver?',
             text: "Tenga en cuenta que hara una devolución de una factura.",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si',
             cancelButtonText: 'No'
           }).then((result) => {
             if (result.isConfirmed) {
                //  pagar();
               devolverFactura(id);
               dt_basic.row($(this).parents('tr')).remove().draw();
            
             }
           })
        
     
     
         });



    $('div.head-label').html('<h6 class="mb-0">Facturacion</h6>');
  }
  
}


function cargarTablaFacturasDespachos(){

  var datatables_basic_facturas = $('.datatables-basic-facturas');

  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataDespachos =  $('.dataDespachos').val();
    let arrayDespachos = "";
    arrayDespachos = JSON.parse(dataDespachos);
    var dt_basic = datatables_basic_facturas.DataTable({
  
      data : arrayDespachos,
      columns: [
        //nro_doc saldo fec_emis tipo_doc
        { data: 'responsive_id' },//0
        { data: 'dato1' },//1
        { data: 'dato4' }, //2
        { data: 'dato1' },//3
        { data: 'dato2' },//4
        { data: 'dato3' }//5
    
       
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
          targets: 4,
          visible: false
        },
        {
          responsivePriority: 1,
          targets: 2
        }
      ],
      order: [[3, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
           
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4, 5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'portrait',
              exportOptions: { columns: [2,3, 4, 5] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          },
          
          
        },
        {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Buscar',
          className: ' btn btn-relief-info',
          
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
              return 'Detalles de la factura';
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
   




    $('div.head-label').html('<h6 class="mb-0">Depachos realizados</h6>');
  }
  
}


function cargarTablaVentaxArticulos(){
  var datatables_basic_ventas_articulos = $('.datatables-basic-ventas-articulos');

  if (datatables_basic_ventas_articulos.length) {
    datatables_basic_ventas_articulos.DataTable().destroy();
    let dataVentasArticulos =  $('.dataVentasxArticulo').val();
    let arrayVentasArticulos = "";
    arrayVentasArticulos = JSON.parse(dataVentasArticulos);
    var dt_basic = datatables_basic_ventas_articulos.DataTable({
      data : arrayVentasArticulos,
      columns: [
       
        { data: 'responsive_id' },//0
        { data: 'dato1' },//1
        { data: 'dato1' }, //2
        { data: 'dato2' },//3       
        { data: 'ene' },//4
        { data: 'feb' },  //5
        { data: 'mar' },//6
        { data: 'abr' },//7
        { data: 'may' },//8
        { data: 'jun' },//9
        { data: 'jul' },//10
        { data: 'ago' },//11
        { data: 'sep' },//12
        { data: 'oct' },//13
        { data: 'nov' },//14
        { data: 'dic' }//15
        
    
       
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
          responsivePriority: 1,
          targets: 4
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
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [          
           
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4,5,6,7,8,9,10,11,12,13,14,15] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
              exportOptions: { columns: [2, 3, 4,5,6,7,8,9,10,11,12,13,14,15] }
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
              return 'Detalles del reporte';
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
   
    $('div.head-label').html('<h6 class="mb-0">Reporte detallado de ventas por articulos</h6>');
  }
  
}

function cargarTablaVentaxLinea(){
  var datatables_basic_ventas_linea = $('.datatables-basic-ventas-linea');

  if (datatables_basic_ventas_linea.length) {
    datatables_basic_ventas_linea.DataTable().destroy();
    let dataVentasLineas =  $('.dataVentasxLinea').val();
    let arrayVentasLineas = "";
    arrayVentasLineas = JSON.parse(dataVentasLineas);
    var dt_basic = datatables_basic_ventas_linea.DataTable({
      data : arrayVentasLineas,
      columns: [
       
        { data: 'responsive_id' },//0
        { data: 'dato1' },//1
        { data: 'dato1' }, //2
        { data: 'dato2' },//3       
        { data: 'ene' },//4
        { data: 'feb' },  //5
        { data: 'mar' },//6
        { data: 'abr' },//7
        { data: 'may' },//8
        { data: 'jun' },//9
        { data: 'jul' },//10
        { data: 'ago' },//11
        { data: 'sep' },//12
        { data: 'oct' },//13
        { data: 'nov' },//14
        { data: 'dic' }//15
        
    
       
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
          responsivePriority: 1,
          targets: 4
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
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [          
           
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4,5,6,7,8,9,10,11,12,13,14,15] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
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
              return 'Detalles del reporte';
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
   
    $('div.head-label').html('<h6 class="mb-0">Reporte detallado de ventas por articulos</h6>');
  }
  
}

function cargarTablaAdelantosCliente(){

  var datatables_basic_adelantos = $('.datatables-basic-adelantos');

  if (datatables_basic_adelantos.length) {
    datatables_basic_adelantos.DataTable().destroy();
    let dataAdelantos =  $('.dataAdelantos').val();
    let arrayAdelantos = "";
    arrayAdelantos = JSON.parse(dataAdelantos);
    var dt_basic = datatables_basic_adelantos.DataTable({
      data : arrayAdelantos,
      columns: [
        //nro_doc saldo fec_emis tipo_doc
        { data: 'responsive_id' },//0
        { data: 'nro_doc' },//1
        { data: 'nro_doc' }, //2
        { data: 'saldo' },//3       
        { data: 'fec_emis' },//4
        { data: '' }     //6

      

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
          
      
        {   // Actions
          targets: -1,
          title: 'Acciones',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-flex">' +                   
             
              '<a href="javascript:;" class="'+full['nro_doc']+' dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +
              '</div>' +
              '</div>'
            );
          }
         }, 
       
      
        {
          responsivePriority: 1,
          targets: 4
        }
      ],
      order: [[4, 'asc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
           
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
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Agregar Adelanto',
          className: 'pagar_facturas btn btn-relief-primary',
          /*
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modals-slide-in'
          },*/
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
              return 'Detalles de la factura';
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
   
    $('.pagar_facturas').click(function(){      
      let arrayFacturas = [];     
      let cliente="";
      let co_cliente="";

      $("input[type=checkbox]:checked").each(function (e) {  
          arrayFacturas.push($(this).val());
      });
      var tope =arrayFacturas.length;


        cliente = $('.comboClientesAdelantos option:selected').html().trim();
        co_cliente=$('.comboClientesAdelantos').val();
  
        $('.facturas_cliente').val(cliente);
     
        let date = new Date(); 
        var fecha =date.getFullYear()+ '-' + ( date.getMonth() + 1 ) + '-' + date.getDate();
        //console.log(fecha);
     
        $('.facturas_cliente_codigo').val(co_cliente);
      
        $('.facturas_fecha').val(fecha);
        $(".modalPagoFacturas").modal("show");       

     


    });
    
       // Delete Record
       $('.datatables-basic-adelantos tbody').on('click', '.delete-record', function (e) {
        let id = e.target.classList[0];
         console.log(id);
         e.preventDefault();
         Swal.fire({
           title: '¿Deseas Eliminar?',
           text: "Tenga en cuenta que eliminará definitivamentela el adelanto .",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Si',
           cancelButtonText: 'No'
         }).then((result) => {
           if (result.isConfirmed) {
              //  pagar();
              borrarAdelanto(id);
              dt_basic.row($(this).parents('tr')).remove().draw();
          
           }
         })
      
   
   
       });



    $('div.head-label').html('<h6 class="mb-0">Adelantos</h6>');
  }
  
}

function cargarTablaCaducidadCliente(){
  var datatables_basic_caducidad = $('.datatables-basic-caducidad');

 
    let dataCaducidad =  $('.dataCaducidad').val();
    let arrayCaducidad = "";
    arrayCaducidad = JSON.parse(dataCaducidad);
    var dt_basic = datatables_basic_caducidad.DataTable({
      data : arrayCaducidad,
      columns: [
        //nro_doc saldo fec_emis tipo_doc
        { data: 'responsive_id' },//0
        { data: 'co_inventario' },//1
        { data: 'co_inventario' }, //2
        { data: 'co_art' },//3
        { data: 'fec_emis' },//4   
        { data: 'tipo' },//5   
     
        { data: 'status' },//6
        { data: 'co_cli' },//7
        { data: '' }     //8

      

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
          className: 'codigo'
        },
        {
          targets: 7,
          className: 'co_cli'
        },
        {
          // Label
          targets: 5,
          width: '20px',
          render: function (data, type, full, meta) {
            var $status_number = full['tipo'];
            var $status = {             
              1: { title: 'Inventario', class: ' badge-light-success' },
              2: { title: 'Devolución', class: 'badge-light-danger' }
              
            
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
          width: '20px',
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {             
              1: { title: 'Activa', class: ' badge-light-success' },
              2: { title: 'Inactiva', class: 'badge-light-danger' }
              
            
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
      
        {   // Actions
          targets: -1,
          title: 'Acciones',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-flex">' +                   
              '<a  href="javascript:verInventario(\''+full['co_inventario']+'\');" class="'+full['co_inventario']+' dropdown-item">' +
              feather.icons['edit'].toSvg({ class: 'font-small-4 me-50' }) +
              '</a>' +
              '<a "javascript:borrarInventario(\''+full['co_inventario']+'\');" class="'+full['co_inventario']+' dropdown-item delete-record-inventario">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              '</a>' +
              '</div>' +
              '</div>'
            );
          }
         }, 
       
      
        {
          responsivePriority: 1,
          targets: 4
        }
      ],
      order: [[4, 'asc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
           
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
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Agregar entrada',
          className: 'agregar_caducidad btn btn-relief-primary',
          /*
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modals-slide-in'
          },*/
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
              return 'Detalles de la factura';
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
   
    $('.agregar_caducidad').click(function(){      
     
      let cliente="";
      let co_cliente="";




        cliente = $('.comboClientesCaducidad option:selected').html().trim();
        co_cliente=$('.comboClientesCaducidad').val();
  
        $('.caducidad_cliente').val(cliente);
     
       
        //console.log(fecha);
     
        $('.codigo_cliente_caducidad').val(co_cliente);
      
       // $('.facturas_fecha').val(fecha);
        $(".modalPagoFacturas").modal("show");       

     


    });
    
       // Delete Record
       $('.datatables-basic-caducidad tbody').on('click', '.delete-record-inventario', function (e) {
        let id = 0;
        let co_cli ='';
        $(this).parents("tr").find(".codigo").each(function(){
          id=$(this).html();
        });
        $(this).parents("tr").find(".co_cli").each(function(){
          co_cli=$(this).html();
        });
        //let id = e.target.classList[0];
         console.log(co_cli);
         e.preventDefault();
         Swal.fire({
           title: '¿Deseas Eliminar?',
           text: "Tenga en cuenta que eliminará definitivamente la información.",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Si',
           cancelButtonText: 'No'
         }).then((result) => {
           if (result.isConfirmed) {
              //  pagar();
              borrarInventario(id,co_cli);
              //dt_basic.row($(this).parents('tr')).remove().draw();
          
           }
         })
      
   
   
       });



    $('div.head-label').html('<h6 class="mb-0">Fechas de caducidad</h6>');
  
  
}

function cargarTablaCuentasPorCobrar(){
  var dt_basic_table_cuentas = $('.datatables-basic-cuentas');   
    assetPath = '../app-assets/';
  if (dt_basic_table_cuentas.length) {
    
    let dataCuentasPorCobrar =  $('.dataCuentasPorCobrar').val();
    //console.log(dataArticulos);
    let arrayCuentas = "";
    arrayCuentas = JSON.parse(dataCuentasPorCobrar);
    var dt_basic = dt_basic_table_cuentas.DataTable({
     data : arrayCuentas,
      columns: [    
        //responsive_id co_art art_des prec_vta1
      
        { data: 'responsive_id' },//0
        { data: 'co_cli' },    //1
        { data: 'co_cli' },//2
        { data: 'cli_des' },//3
        { data: 'rif' },//4
        { data: 'saldo' },//5          
        { data: '' },//  6 
       
          
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
          responsivePriority: 1,
          targets: 3
        },

        {
          // Label
          targets: 5,
          width: '20px',
          render: function (data, type, full, meta) {
            var $status_number = full['saldo'];
        //console.log($status_number);
          if($status_number<0){
            return (             
              '<span class="badge rounded-pill bg-success ">'+$status_number+'</span>'
            );
          }else{
            return (
              '<span class="badge rounded-pill  bg-danger ">'+$status_number+'</span>'
            );
          }
           
           
          }
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
              '<a class="me-25" href="javascript:facturas(\''+co_cli+'\');" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +                    
              '</div>' +
              '</div>'
            );
          }
        }, 
       
        {
        
        },
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
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3,4,5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3,4,5] }
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
              return 'Detalles';
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
removeItem = $('.remove-card');



if ($('#datosFacturaChequear').length) {
  let fact_num =$('#fact_num').val();
  
facturaDetalles(fact_num);

  

}


// Navegación con teclado entre inputs
$(document).on('keydown', '.cantidad-input', function(e) {
    // Tecla Tab - navegación normal
    if (e.key === 'Tab') {
        // La navegación con Tab es automática, solo asegurar que la fila se pinte
        setTimeout(() => {
            const inputConFoco = $('.cantidad-input:focus');
            if (inputConFoco.length > 0) {
                $('.fila-producto').removeClass('fila-en-foco');
                inputConFoco.closest('tr').addClass('fila-en-foco');
            }
        }, 10);
    }
    
    // Teclas de flecha para navegación vertical
    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        e.preventDefault();
        navegarInputsVerticalmente(e.key === 'ArrowDown');
    }
});

function navegarInputsVerticalmente(haciaAbajo) {
    const inputActual = $('.cantidad-input:focus');
    if (inputActual.length === 0) return;
    
    const inputs = $('.cantidad-input');
    const currentIndex = inputs.index(inputActual);
    let nuevoIndex;
    
    if (haciaAbajo) {
        nuevoIndex = Math.min(currentIndex + 1, inputs.length - 1);
    } else {
        nuevoIndex = Math.max(currentIndex - 1, 0);
    }
    
    if (nuevoIndex !== currentIndex) {
        inputs.eq(nuevoIndex).focus().select();
    }
}

// Auto-seleccionar el texto del input cuando recibe foco
$(document).on('click', '.cantidad-input', function() {
    $(this).select();
});

// También seleccionar texto al recibir foco por tabulación
$(document).on('focus', '.cantidad-input', function() {
    setTimeout(() => {
        $(this).select();
    }, 10);
});


    // Procesar despacho
    $('#btnDespachar').click(function() {
        const articulosDespacho = [];
        let despachoCompleto = true;
        
        $('tr[data-co-art]').each(function() {
            const coArt = $(this).data('co-art');
            const cantidadPedida = parseInt($(this).find('.cantidad-pedida').text());
            const cantidadDespacho = parseInt($(this).find('.cantidad-despacho').val()) || 0;
            
            articulosDespacho.push({
                co_art: coArt,
                cantidad_pedida: cantidadPedida,
                cantidad_despacho: cantidadDespacho
            });
            
            if (cantidadDespacho === 0) {
                despachoCompleto = false;
            }
        });
        
        if (!despachoCompleto) {
            if (!confirm('Algunos artículos tienen cantidad 0. ¿Desea continuar con el despacho parcial?')) {
                return;
            }
        }
        
        // Aquí enviarías los datos al servidor
        console.log('Datos a enviar:', articulosDespacho);
        
        // Simular envío
        alert('Despacho procesado correctamente. Revise la consola para ver los datos.');
        
        // Aquí iría tu llamada AJAX real:
        /*
        $.ajax({
            url: 'procesar_despacho.php',
            method: 'POST',
            data: { 
                factura: $('#facturaNumero').val(),
                articulos: articulosDespacho 
            },
            success: function(response) {
                alert('Despacho procesado correctamente');
            },
            error: function() {
                alert('Error al procesar el despacho');
            }
        });
        */
    });


// Cuando el modal se muestra completamente
            $('#modalBuscarFactura').on('shown.bs.modal', function () {
                // Enfocar el campo de entrada
                $('#inputCodigoFactura').focus();
                
                // Opcional: seleccionar cualquier texto existente
                $('#inputCodigoFactura').select();
            });
            
            // Limpiar el campo cuando el modal se cierra
            $('#modalBuscarFactura').on('hidden.bs.modal', function () {
                $('#inputCodigoFactura').val('');
            });
            


$('.btnBuscarFactura').on('click', function (e) { 
  var $fac_nun = $('#inputCodigoFactura').val(); 
 
      if(($fac_nun!='')){  
          cargarDataFactura($fac_nun);
          $('#modalBuscarFactura').modal('hide')
      
          
      }else{
        Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Debe ingresar un código de factura válido',
                        confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Aceptar'
                    });
            $('#inputCodigoFactura').focus();
      }

});

$('.cargarDespachos').on('click', function (e) { 
  var $finicio = $('.finicio').val(); 
  var $ffinal = $('.ffinal').val(); 
      if(($finicio!='') && ($ffinal!='') ){
        var $filtro =$finicio+'/'+$ffinal;
          cargarDataDespachos($filtro);
          $('#modals-slide-in').modal('hide')
      
          
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Debe elegir al menos un criterio de busqueda!'
        
        })
      }

});

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

if ($('.m_marcadores').length) {
  resaltarMenu('.i_marcadores');
}




if ($('.categories-list').length) {  

  cargarDataLinea();
}
/*
if ($('.content-body').length) {  

  cargarDataEmpresaDetalles();
}*/

if ($('.datosVendedor').length) {  

  cargarDataVendedor();
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
  cargarDataArticulos('NO');
  cargarDataClientes();
  cargarDataVendedores();
  cargarDataPedidos(0,'NO');
  cargarDataFacturaciones(0,'NO');
  cargarDataVisitas();
  cargarDataCuentasPorCobrar();
  cargarDataFacturas('4','NO','NO','NO','NO');
  cargarDataAprobaciones(0,'NO');

  cargarDataDespachos('NO');

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
 


$('.comboClientesInventario').on('change', function () { 
  var $co_cli = $('.comboClientesInventario').val();
    cargarDataListaProductos($co_cli);

});   

$('.comboClientesAdelantos').on('change', function () {
  var $co_cli = $('.comboClientesAdelantos').val();
    cargarDataAdelantos($co_cli);
  
});   


$('.comboClientesCaducidad').on('change', function () {
  var $co_cli = $('.comboClientesCaducidad').val();
  cargarDataCaducidad($co_cli);
  
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
   



         
if ($('.pagination-cart').length) {
  contarRegistroCart(); 
}
// Paginacion del grid de articulos (carrtito de compra)

/// Cargar los combos de la aplicacion
if ($('.comboDespachoZonas').length) {
  cargarComboZonas('.comboDespachoZonas');

}

if ($('.comboClientesInventario').length) {
  cargarComboFacturas('.comboClientesInventario');

}


/// Cargar los combos de la aplicacion
if ($('.comboClientesAdelantos').length) {
  cargarComboFacturas('.comboClientesAdelantos');

}

if ($('.comboClientesCaducidad').length) {
  cargarComboFacturas('.comboClientesCaducidad');

}

if ($('.comboArticulosCaducidad').length) {
  cargarComboArticulos('.comboArticulosCaducidad');

}

if ($('.comboArticulosInventario').length) {
  cargarComboArticulos('.comboArticulosInventario');

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

if ($('.comboCategorias').length) {
  cargarComboCategorias('.comboCategorias');
}

if ($('.comboCategoriasGenerar').length) {
  cargarComboCategorias('.comboCategoriasGenerar');
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

if ($('.comboClientesFactura').length) {
  cargarComboClientesDespachos('.comboClientesFactura');
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

$('.AgregarInventario').on('click', function () {

  Swal.fire({
    title: '¿Deseas registrar estos datos?',
    text: "Tenga en cuenta que guardara toda  esta información",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {

    /*          
  codigo_cliente_caducidad
  comboArticulosCaducidad
  caducidad_cantidad
  fecha_venc*/
  var inputsFechas = $('input[name^=fechas_co_art]');
  var inputsArticulos = $('input[name^=co_arts]');
  var inputsCantidades = $('input[name^=cants]');
  var selectOpciones = $('select[name^=options]');

  var $fact_nun = $('#facturaNumero').html() 
  var list = {
    'datos' :[]
  };
  
  var j = 0;
  for (j=0; j<inputsFechas.length; j++) {
    if (inputsFechas[j].value != '') {
    
       list.datos.push({
    "co_art": inputsArticulos[j].value,
    "fec_ven":  inputsFechas[j].value,
    "cant":  inputsCantidades[j].value,
    "option" : selectOpciones[j].value
  });
    }
  }

  var tope=list.datos.length;
  if(tope!= 0){
  var data = JSON.stringify(list); // aqui tienes la lista de objetos en Json
 // var obj = JSON.parse(json); //Parsea el Json al objeto anterior.
 // console.log(data);

   
                        $.ajax({
                          url: '../admin/index.php?action=inventario&tipo=1&accion=2&datos=1&fact_nun='+$fact_nun, 
                            type:'POST',  
                            data:{datos:data},                      
                            dataType : 'json',      
                             beforeSend: function () {
      
                              // Info Type
                              toastr['info']('👋 Estamos procesando su requerimiento.', 'Info!', {
                                closeButton: true,
                                tapToDismiss: false
                              });
                                                  },                                       
                                  complete: function() {
                                    toastr['success']('👋 Se ha completado su solicitud.', 'Success!', {
                                      closeButton: true,
                                      tapToDismiss: false,
                                      rtl: isRtl
                                    });
                               },
                                 
                            success:function(response){
        
                              if(response=='1'){
                                Swal.fire({
                                  icon: 'success',
                                  title: 'Bien..',
                                  text: 'Se ha realizado el inventario exitosamente!'
                                
                                })
                                
                              }else{
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'No hemmos podido realizar el inventario, verifique e intente nuevamente!'
                                
                                })
                              }
                                        
                            }
                        });      
                      }else{
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Debes elegir la fecha de vencimiento del articulo!'
                        
                        })
                      }
 

    
      
 


    }
  })

});

$('.AgregarInventario2').on('click', function () {
  var inputsTipos = $('input[name^=tipo_d]');
  var inputsFechas = $('input[name^=fechas_co_art]');
  var inputsArticulos = $('input[name^=co_arts]');
  var inputsCantidades = $('input[name^=cants]');

  var inputsFechas_d = $('input[name^=fechas_co_art_d]');
  var inputsArticulos_d = $('input[name^=co_arts_d]');
  var inputsCantidades_d = $('input[name^=cants_d]');

    Swal.fire({
      title: '¿Deseas registrar estos datos?',
      text: "Tenga en cuenta que guardara toda  esta información",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
  
      /*          
    codigo_cliente_caducidad
    comboArticulosCaducidad
    caducidad_cantidad
    fecha_venc*/
  
  
    var $co_cli = $('#codigoCliente').html() 
    var list = {
      'datos' :[]
    }; 
    
    var j = 0;
    for (j=0; j<inputsTipos.length; j++) {

        if ((inputsFechas[j].value != '') && (inputsCantidades[j].value != '')){
          list.datos.push({
       "co_art": inputsArticulos[j].value,
       "fec_ven":  inputsFechas[j].value,
       "cant":  inputsCantidades[j].value,
       "tipo": inputsTipos[j].value
     });
       }

      
   
    }

    
    //console.log(list);
    var tope=list.datos.length;
if(tope!= 0){


    var data = JSON.stringify(list); // aqui tienes la lista de objetos en Json
   // var obj = JSON.parse(json); //Parsea el Json al objeto anterior.



                          $.ajax({
                            url: '../admin/index.php?action=inventario&tipo=1&accion=3&datos=1&co_cli='+$co_cli, 
                              type:'POST',  
                              data:{datos:data},                      
                              dataType : 'json',      
                               beforeSend: function () {
      
                                // Info Type
                                toastr['info']('👋 Estamos procesando su requerimiento.', 'Info!', {
                                  closeButton: true,
                                  tapToDismiss: false
                                });
                                                    },
                                    complete: function() {
                                      toastr['success']('👋 Se ha completado su solicitud.', 'Success!', {
                                        closeButton: true,
                                        tapToDismiss: false
                                      });
                                 },
                              success:function(response){
          
                                if(response=='1'){
                                  Swal.fire({
                                    icon: 'success',
                                    title: 'Bien..',
                                    text: 'Se ha realizado el inventario exitosamente!'
                                  
                                  }),
                                  $('#filaFacturas').empty();   
                                  $('#filaFacturasDevolucion').empty();   
                                  $("#facturaDespacho").addClass("d-none");  
                                  $("#facturaDespachoDevolucion").addClass("d-none");  
                            
                               
                                }else{
                                  Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No hemmos podido realizar el inventario, verifique e intente nuevamente!'
                                  
                                  }),
                                  $('#filaFacturas').empty();   
                                  $('#filaFacturasDevolucion').empty();   
                                
                                }
                                          
                              }
                          });      
                          
   
  
      
                        }else{
                          Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debes escribir la cantidad de articulos y su fecha de vencimiento!'
                          
                          })
                        }
   
  
  
      }
    })
  


});

$('.AgregarDevolucion').on('click', function () {
  var inputsFechas = $('input[name^=fechas_co_art]');
  var inputsArticulos = $('input[name^=co_arts]');
  var inputsCantidades = $('input[name^=cants]');

  

    Swal.fire({
      title: '¿Deseas registrar estos datos?',
      text: "Tenga en cuenta que guardará toda  esta información",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
  
      /*          
    codigo_cliente_caducidad
    comboArticulosCaducidad
    caducidad_cantidad
    fecha_venc*/
  
  
    var $co_cli = $('#codigoCliente').html() 
    var list = {
      'datos' :[]
    };
    
    var j = 0;
    for (j=0; j<inputsFechas.length; j++) {
      if ((inputsFechas[j].value != '') && (inputsCantidades[j].value != '')){
         list.datos.push({
      "co_art": inputsArticulos[j].value,
      "fec_ven":  inputsFechas[j].value,
      "cant":  inputsCantidades[j].value
    });
      }
    }
   // console.log(list);
    var tope=list.datos.length;
if(tope!= 0){


    var data = JSON.stringify(list); // aqui tienes la lista de objetos en Json
   // var obj = JSON.parse(json); //Parsea el Json al objeto anterior.



                          $.ajax({
                            url: '../admin/index.php?action=inventario&tipo=1&accion=3&datos=2&co_cli='+$co_cli, 
                              type:'POST',  
                              data:{datos:data},                      
                              dataType : 'json',   
                               beforeSend: function () {
      
                                // Info Type
                                toastr['info']('👋 Estamos procesando su requerimiento.', 'Info!', {
                                  closeButton: true,
                                  tapToDismiss: false
                                });
                                                    },   
                                    complete: function() {
                                      toastr['success']('👋 Se ha completado su solicitud.', 'Success!', {
                                        closeButton: true,
                                        tapToDismiss: false
                                      });
                                 },                 
                              success:function(response){
          
                                if(response=='1'){
                                  Swal.fire({
                                    icon: 'success',
                                    title: 'Bien..',
                                    text: 'Se ha realizado la devolución exitosamente!'
                                  
                                  }),
                                  $('#filaFacturas').empty();   
                                
                                  $("#facturaDespacho").addClass("d-none");  
                                 
                                }else{
                                  Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No hemmos podido realizar la devolución, verifique e intente nuevamente!'
                                  
                                  }),
                                  $('#filaFacturas').empty();   
                              
                                }
                                          
                              }
                          });      
                          
   
  
      
                        }else{
                          Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debes escribir la cantidad de articulos y su fecha de vencimiento!'
                          
                          })
                        }
   
  
  
      }
    })
  


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


/*if ($('.dataEmpresa').length) {
  cargarDataEmpresa();

}*/

$('.cargarDespachos').on('click', function (e) { 
    var $finicio = $('.finicio').val(); 
    var $ffinal = $('.ffinal').val();
    var $zona = $('#comboDespachoZonas').val();
    var $cliente = $('#comboClientesFactura').val();
    
    // Validar que las fechas sean obligatorias
    if(!$finicio || !$ffinal) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Las fechas de inicio y final son obligatorias!'
        });
        return;
    }
    
    // Convertir fechas a objetos Date para comparación
    var fechaInicio = new Date($finicio);
    var fechaFinal = new Date($ffinal);
    var fechaActual = new Date();
    
    // Validar que la fecha de inicio no sea mayor a la fecha final
    if(fechaInicio > fechaFinal) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La fecha de inicio no puede ser mayor a la fecha final!'
        });
        return;
    }
    
    // Validar que las fechas no sean mayores a la actual
    if(fechaInicio > fechaActual || fechaFinal > fechaActual) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No se pueden seleccionar fechas mayores a la actual!'
        });
        return;
    }
    
    // Determinar el tipo de búsqueda (1, 2, 3, 4)
    var $tipoBusqueda = 0;
    var $co_zona = 0;
    var $co_cli = 0;
    
    if($zona && $zona !== '0' && $cliente && $cliente !== '0') {
        // Búsqueda por zona Y cliente
        $tipoBusqueda = 1;
        $co_zona = $zona;
        $co_cli = $cliente;
    } else if($zona && $zona !== '0') {
        // Búsqueda solo por zona
        $tipoBusqueda = 2;
        $co_zona = $zona;
    } else if($cliente && $cliente !== '0') {
        // Búsqueda solo por cliente
        $tipoBusqueda = 3;
        $co_cli = $cliente;
    } else {
        // Búsqueda solo por fechas
        $tipoBusqueda = 7;
    }
    
    // Llamar a la función con los parámetros separados
    cargarDataFacturas($tipoBusqueda, $co_zona, $co_cli, $finicio, $ffinal);
    $('#modalBuscarFactura').modal('hide');
});



$('.guardarFechaDespacho').on('click', function () {
  //console.log('guardare');
  


  var $co_cli = $('.co_cli').val(),
    $fact_nun = $('.fact_nun').val(),
    $confirmFechaDespacho = $('.confirmFechaDespacho').val()


  
  if (($confirmFechaDespacho != '')) { 
   
       despachar($co_cli,$fact_nun,$confirmFechaDespacho)
  
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Existe un error en los datos suministrados, verifiquelos e intente nuevamente!'
    
    })
  }
});

//////////////// CArrito de compras //////////////////////



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

function cargarDataArticulos($categoria){
  if ($('#dataArticulos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=59&t=art&filtro='+$categoria, 
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
    url: '../admin/index.php?action=combos&c=PedidoData&a=13&t=pedidos&status='+$status+'&rango='+$rango, 
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
   
function cargarDataFacturas($tipoBusqueda, $co_zona, $co_cli, $finicio, $ffinal){
   
  if ($('#dataFacturas').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=65&c=FacturaData&t=factura&busqueda='+$tipoBusqueda+'&fechaInicio='+$finicio+'&fechaFin='+$ffinal+'&co_zona='+$co_zona+'&co_cli='+$co_cli,
}).done(function(facturas) { 
  var cadena = JSON.stringify(facturas);
  $('.dataFacturas').attr("value",cadena);
  
    cargarTablaFacturasCliente();
  

  /*
  if($status=='1'){
    cargarTablaFacturasClienteDevolucion();
  }
*/


});
  }
}

function cargarDataDespachos($filtro){
  
  if ($('#dataDespachos').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=96&c=FacturaData&t=factura&filtro='+$filtro,
}).done(function(despachos) { 
  var cadena = JSON.stringify(despachos);
  $('.dataDespachos').attr("value",cadena);
    cargarTablaFacturasDespachos();
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


function cargarDataCaducidad($co_cli){
  
  var datatables_basic_caducidad = $('.datatables-basic-caducidad');

  if (datatables_basic_caducidad.length) {
    datatables_basic_caducidad.DataTable().destroy();
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=61&c=InventarioData&t=jm_inventario&co_cli='+$co_cli+'&filtro=0',
}).done(function(caducidad) { 
  var cadena = JSON.stringify(caducidad);
  $('.dataCaducidad').attr("value",'');
  $('.dataCaducidad').attr("value",cadena);
  cargarTablaCaducidadCliente();


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

function cargarComboZonas(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=95&t=factura', 
}).done(function(zonas) { 
  var i = 0;
  var tope =zonas.length;
  for (var i = 0; i < tope; i++) {    
    
    $(combo).prepend('<option value = '+zonas[i].co_zon+'>'+zonas[i].zon_des+'</option>')
  }  
});
}
}

function cargarComboFacturas(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=97&t=factura', 
}).done(function(dataVendedores) { 
  var i = 0;
  var tope =dataVendedores.length;
  for (var i = 0; i < tope; i++) {    
    
    $(combo).prepend('<option value = '+dataVendedores[i].co_cli+'>'+dataVendedores[i].cli_des+'</option>')
  }  
});
}
}

function cargarComboArticulos(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=62&t=art', 
}).done(function(dataArticulos) { 
  var i = 0;
  var tope =dataArticulos.length;
  for (var i = 0; i < tope; i++) {    
    
    $(combo).prepend('<option value = '+dataArticulos[i].co_art+'>'+dataArticulos[i].art_des+'</option>')
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


function cargarComboClientesDespacho(combo){
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
                  positionClass: 'toast-bottom-right',
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
                  <h6 class="item-price">Precio ($): ${pre}</h6>
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
  $('.subtotal').html(subTotal.toFixed(2));
  $('.total').html(total.toFixed(2));
 

  $('.totalArticulos2').html(totalArticulos);
  $('.subtotal2').html(subTotal.toFixed(2));
  $('.total2').html(total.toFixed(2));
 

  $('.totalArticulos3').html(totalArticulos);
  $('.subtotal3').html(subTotal.toFixed(2));
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
    $('#cuentasPorCobrar').html(cuentas[i].dato1);   
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

function factura($fact_nun){
  //console.log($co_cli);

  $('.filaFacturas').empty();   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=96&c=FacturaData&t=factura&fact_nun='+$fact_nun+'&filtro=0', 
}).done(function(facturas) {  
  //console.log(facturas);
  var i = 0;
  var tope =facturas.length;
  var contenido="";
  var contenido2="";
  if(tope>=1){   
   
    for (var i = 0; i < tope; i++) { 
      
      co_art=facturas[i].dato1;
      art_des=facturas[i].dato2;
      total_art=facturas[i].dato3;
      cli_des=facturas[i].dato4;
      fec_venc=facturas[i].dato6;
      opcion=facturas[i].dato7;

      contenido=`<div class="col-sm-3">
        <label class="col-form-label" for="first-name">${co_art} - ${art_des} </label><br>
      </div>
      <div class="col-sm-3">
      <input type="number" id="1${co_art}" value ='${total_art}' class="form-control"  name="cants[]" >
      </div>
      <div class="col-sm-3">
      
        <input type="date" id="fp-default" value ='${fec_venc}' class="form-control flatpickr-basic flatpickr-input active"  name="fechas_co_art[]" placeholder="YYYY-MM-DD">
        <input type="hidden" id="1${co_art}" value ='${co_art}' class="form-control" name="co_arts[]" placeholder="">
    
      </div>
      
      `; 

      if(opcion == '1'){
        contenido2=`<div class="col-sm-3">
        <select class="select2 form-select " id="select2-basic-" name="options[]">
        <option value="1" selected>Inventario</option>
        <option value="2">Devolucion</option>
        </select></div>`; 
      }else{
        contenido2=`<div class="col-sm-3">
        <select class="select2 form-select " id="select2-basic-" name="options[]">
        <option value="1" >Inventario</option>
        <option value="2"selected>Devolucion</option>
        </select></div>`; 
      }

     
      /*
      contenido=`<tr>
      <td>${fact_nun}</td>
      <td>${tipo_doc}</td>
      <td>${saldo}</span></td>
      <td>${fec_emis}</td>
      <td>${fec_emis}</td>
      </tr>`;   */

    
    }  
    $('.cli_des').html(cli_des);
    //console.log($fact_nun);
    $('.facturaNumero').html($fact_nun);
    
  $(".dataFactura").modal("show");
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Vaya...',
      text: 'Esta Factura : '+$fact_nun+', aun esta en proceso de despacho.'
    
    })       
  }
 
});

}

function verInventario($co_inventario){
  //console.log($co_cli);

  $('#filaFactura').empty();   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=63&c=InventarioData&t=jm_inventario&co_inventario='+$co_inventario, 
}).done(function(inventarios) {  
  var i = 0;
  var tope =inventarios.length;
  if(tope>=1){   
   
    for (var i = 0; i < tope; i++) { 
      //codigo_inventario tipo_inventario_editar comboArticulosInventario inventario_cantidad fecha_venc_inventario   

      let tipo = inventarios[i].tipo;
      $('.tipo_inventario_editar > option[value="'+tipo+'"]').attr('selected', 'selected');

      let co_art = inventarios[i].co_art;
      $('#select2-basic-comboArticulosInventario > option[value="'+co_art+'"]').attr('selected', 'selected');

      $('.inventario_cantidad').val(inventarios[i].cantidad);

      $('.fecha_venc_inventario').val(inventarios[i].fec_ven);
  
      $('.codigo_inventario').val($co_inventario);

    }  

  $(".modalInventario").modal("show");
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Vaya...',
      text: 'No hay inventario registrado.'
    
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
function borrarInventario(co_inventario,$co_cli){

  var tipo = 1;
  var accion = 3;
  var datos =1;
  $.ajax({
    url: '../admin/index.php?action=inventario', 
    type:'GET',
    data:{tipo:tipo,accion:accion,datos:datos,co_inventario:co_inventario},
    success:function(response){
     //alert(response);
        if(response == 1){      
          Swal.fire({
            icon: 'success',           
            text: 'Datos d eliminados con exito!.'            
          }),
         // $('.modalPagoFacturas').modal('hide'),
          cargarDataCaducidad($co_cli);
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





function cargarDataListaProductos($co_cli){
  //console.log($co_cli);

  $('#filaFacturas').empty();   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=98&c=ArticuloData&t=art', 
     beforeSend: function () {
      
  // Info Type
  toastr['info']('👋 Estamos procesando su requerimiento.', 'Info!', {
    closeButton: true,
    tapToDismiss: false
  });
                      },
}).done(function(articulos) {  
  //console.log(facturas);
  var i = 0;
  var tope =articulos.length;
  var contenido="";
  var contenido2="";
  if(tope>=1){   
   
    for (var i = 0; i < tope; i++) { 

   
      
      co_art=articulos[i].co_art;
      art_des=articulos[i].art_des;
   

      contenido=`<div class="col-sm-6">
        <label class="col-form-label" for="first-name"><b>${co_art} - ${art_des}</b></label><br>
      </div>
      <div class="col-sm-2">
      <input type="number" id="1${co_art}" value ='' class="form-control" name="cants[]" placeholder="">
      </div>
      <div class="col-sm-4">
      
        <input type="date" id="fp-default" value ='' class="form-control  flatpickr-basic flatpickr-input active"  name="fechas_co_art[]" placeholder="YYYY-MM-DD">
        <input type="hidden" id="1${co_art}" value ='${co_art}' class="form-control" name="co_arts[]" placeholder="">
        <input type="hidden" id="1d${co_art}" value ='1' class="form-control" name="tipo_d[]" placeholder="">
       
      </div>`; 
      /*
      contenido=`<tr>
      <td>${fact_nun}</td>
      <td>${tipo_doc}</td>
      <td>${saldo}</span></td>
      <td>${fec_emis}</td>
      <td>${fec_emis}</td>
      </tr>`;   */
      $('#filaFacturas').prepend(contenido);  
      
      contenido2=`<div class="col-sm-6">
        <label class="col-form-label" for="first-name"><b>${co_art} - ${art_des}</b></label><br>
      </div>
      <div class="col-sm-2">
      <input type="number" id="1${co_art}" value ='' class="form-control" name="cants[]" placeholder="">
      </div>
      <div class="col-sm-4">
      
        <input type="date" id="fp-default" value ='' class="form-control  flatpickr-basic flatpickr-input active"  name="fechas_co_art[]" placeholder="YYYY-MM-DD">
        <input type="hidden" id="1${co_art}" value ='${co_art}' class="form-control" name="co_arts[]" placeholder="">
        <input type="hidden" id="1d${co_art}" value ='2' class="form-control" name="tipo_d[]" placeholder="">
      </div>`; 
      $('#filaFacturasDevolucion').prepend(contenido2); 
    }  
      //console.log($fact_nun);
    $('#codigoCliente').html($co_cli);
    $("#facturaDespacho").removeClass("d-none");
    $("#facturaDespachoDevolucion").removeClass("d-none");
    

    
  }else{
    Swal.fire({
      icon: 'info',
      title: 'Vaya...',
      text: 'No hemos encontrado ese numero de factura en nuestra base de  datos'
    }),
   
    $("#facturaDespacho").addClass("d-none");   
  }
 
});

}
/*
function despacharFactura(id){

  Swal.fire({
    title: '¿Deseas despachar?',
    text: "Tenga en cuenta q esta despachando  la factura asignada a este cliente.",
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
        url: '../admin/index.php?action=facturacion', 
        type:'post',
        data:{tipo:tipo,accion:accion,datos:datos,id:id},
        success:function(response){
         //alert(response);
            if(response == 1){      
              Swal.fire({
                icon: 'success',           
                text: 'Despacho realizado con  éxito.'            
              })
             // cargarDataUsers()
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Hubo un error al despachar.'            
              })
            }
           
        }
    });
   
    }
  })

}*/

function devolverFactura(id){
  var tipo = 1;
  var accion = 5;
  var datos =1;
  $.ajax({
    url: '../admin/index.php?action=facturacion', 
    type:'post',
    data:{tipo:tipo,accion:accion,datos:datos,id:id},
    success:function(response){
     //alert(response);
        if(response == 1){      
          Swal.fire({
            icon: 'success',           
            text: 'Factura devuelta con éxito.'            
          })
         // cargarDataUsers()
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Hubo un error al realizar la devolución.'            
          })
        }
       
    }
});
}

function seleccionar(id,dias){
  var co_cli= $('.comboClientesFactura').val();
  var nivel = $('.nivel').html();
  if(nivel==6){

  $('.co_cli').val(co_cli);  
  $('.fact_nun').val(id);  
  $(".establecerFecha").modal("show");


  }else{

    despachar(co_cli,id,dias);

  }

         
        
}


function despachar(co_cli,id,dias){
 /* console.log(co_cli);
  console.log(id);
  console.log(dias);*/
       
        
         var tipo = 1;
         var accion = 4;
         var datos =1;
         $.ajax({
           url: '../admin/index.php?action=facturacion', 
           type:'post',
           data:{tipo:tipo,accion:accion,datos:datos,id:id,dias:dias},
           success:function(response){
            //alert(response);
               if(response == 1){      
                 Swal.fire({
                   icon: 'success',           
                   text: 'Despacho realizado con  éxito.'            
                 })
                cargarDataFacturas(co_cli,0);
                //$('.dtr-modal-display').hide();
               }else{
                 Swal.fire({
                   icon: 'error',
                   title: 'Oops...',
                   text: 'Hubo un error al despachar.'            
                 })
               }
              
           }
       });
                 
 
    
  
  }


//eliminar la visita
function cargarDataFactura($fact_nun){

      var tipo = 1;
      var accion = 2;
      var datos =1;
      $.ajax({
        url: '../admin/index.php?action=facturacion', 
        type:'post',
        data:{tipo:tipo,accion:accion,datos:datos,fact_nun:$fact_nun},
        success:function(response){
         //alert(response);
            if(response == 1){      
              Swal.fire({
                icon: 'success',           
                text: 'Se ha encontrado la Factura, procedemos a realizar su despacho.'   ,
                 confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Aceptar'         
              })
                     setTimeout(function() {
                        window.location.href = 'index.php?view=fverificacion&s=0&fact_num='+$fact_nun;
                    }, 1000); // 2000 milisegundos = 2 segundos
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No se ha podido encontrar la factura, por favor verifique.',
                 confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Aceptar'            
              })
            }
           
        }
    });
   

}
      


    // Cargar datos en la tabla
    function cargarDatosFactura(numeroFactura, datos) {
        $('#numeroFactura').text(numeroFactura);
        $('#tablaContainer').removeClass('d-none');
        $('#mensajeVacio').addClass('d-none');
        
        const tbody = $('#tablaDespacho tbody');
        tbody.empty();
        
        let totalPedido = 0;
        
        $.each(datos, function(index, articulo) {
            totalPedido += parseInt(articulo.cantidad);
            
            const fila = `
                <tr class="border-bottom" data-co-art="${articulo.co_art}">
                    <td class="py-2 align-middle">
                        <span class="fw-bold">${articulo.co_art}</span>
                    </td>
                    <td class="py-2 align-middle">
                        <span>${articulo.nombre}</span>
                    </td>
                    <td class="py-2 align-middle text-center">
                        <span>${articulo.marca}</span>
                    </td>
                    <td class="py-2 align-middle text-end">
                        <span class="cantidad-pedida">${articulo.cantidad}</span>
                    </td>
                    <td class="py-2 align-middle text-end">
                        <input type="number" class="form-control form-control-sm cantidad-despacho" 
                               value="0" min="0" max="${articulo.cantidad}" 
                               data-max="${articulo.cantidad}"
                               style="width: 80px; display: inline-block;">
                    </td>
                    <td class="py-2 align-middle text-center">
                        <button class="btn btn-sm btn-success btn-despachar-todo" 
                                data-cantidad="${articulo.cantidad}">
                            Despachar Todo
                        </button>
                    </td>
                </tr>
            `;
            
            tbody.append(fila);
        });
        
    }

function facturaDetalles($fact_nun){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=998877&c=FacturaData&t=factura&fact_num='+$fact_nun, 
  }).done(function(data) {  
    var i = 0;
    var tope = data.length;
    var contenido = "";
    
    if(tope >= 1){   
      for (var i = 0; i < tope; i++) { 
        let co_art = data[i].co_art;
        let nombre = data[i].dato1;
        let cantidad = data[i].dato2; // Esta es la cantidad máxima permitida
        let precio = data[i].dato3;
        let marca = data[i].dato4;

        const esBialy = marca.toLowerCase() === 'bialy';
        let estiloDescripcion = esBialy ? 'style="color: #ff6b00; font-weight: bold;"' : '';
        
        let inputId = 'cantidad_' + i;
        
        contenido = `<tr class="fila-producto" data-co-art="${co_art}" data-cantidad-maxima="${cantidad}">
          <td class="py-2 align-middle text-center">${co_art}</td>
          <td class="py-2 align-middle text-center">${nombre}</td>
          <td class="py-2 align-middle text-center">${marca}</td>
          <td class="py-2 align-middle text-center cantidad-maxima">${cantidad}</td>
          <td class="py-2 align-middle text-center">
            <input type="number" 
                   id="${inputId}" 
                   class="form-control form-control-sm cantidad-input" 
                   value="0" 
                   data-co-art="${co_art}"
                   data-cantidad-maxima="${cantidad}"
                   style="width: 80px; margin: 0 auto;">
          </td>
        </tr>`;   
        
        $('#filaFacturaDetalles').prepend(contenido);   
      }  
      
      agregarEventListeners();
    }
  });
}
function agregarEventListeners() {
  // Evento cuando un input recibe el foco
  $('.cantidad-input').on('focus', function() {
    // Remover la clase de foco de todas las filas
    $('.fila-producto').removeClass('fila-en-foco');
    
    // Agregar la clase de foco a la fila actual
    const fila = $(this).closest('tr');
    fila.addClass('fila-en-foco');
    
    // Asegurar que los estilos de validación se mantengan
    if (fila.hasClass('fila-excedida')) {
      fila.addClass('fila-en-foco fila-excedida');
    } else if (fila.hasClass('fila-faltante')) {
      fila.addClass('fila-en-foco fila-faltante');
    } else if (fila.hasClass('fila-correcta')) {
      fila.addClass('fila-en-foco fila-correcta');
    }
  });
  
  // Evento cuando un input pierde el foco
  $('.cantidad-input').on('blur', function() {
    const fila = $(this).closest('tr');
    
    // Remover la clase de foco después de un pequeño delay
    setTimeout(() => {
      if (!$('.cantidad-input').is(':focus')) {
        fila.removeClass('fila-en-foco');
      }
    }, 100);
    
    let valor = $(this).val();
    let cantidadMaxima = $(this).data('cantidad-maxima');
    validarCantidad($(this), valor, cantidadMaxima);
  });
  
  // Evento para cuando cambia el valor de cualquier input de cantidad
  $('.cantidad-input').on('change', function() {
    let valor = $(this).val();
    let coArt = $(this).data('co-art');
    let cantidadMaxima = $(this).data('cantidad-maxima');
    
    validarCantidad($(this), valor, cantidadMaxima);
  });
  
  // Evento para cuando se presiona Enter
  $('.cantidad-input').on('keypress', function(e) {
    if (e.which === 13) { // Tecla Enter
      e.preventDefault();
      let valor = $(this).val();
      let cantidadMaxima = $(this).data('cantidad-maxima');
      validarCantidad($(this), valor, cantidadMaxima);
      
      // Mover al siguiente input o quitar el foco
      moverAlSiguienteInput($(this));
    }
  });
  
  // Validación en tiempo real para evitar valores negativos
  $('.cantidad-input').on('input', function() {
    let valor = $(this).val();
    if (valor < 0) {
      $(this).val(0);
    }
  });
  
  // También manejar clics en la fila para enfocar el input
  $('.fila-producto').on('click', function(e) {
    // Solo si no se hizo clic en un input directamente
    if (!$(e.target).is('input')) {
      $(this).find('.cantidad-input').focus().select();
    }
  });
}

// Función para mover al siguiente input automáticamente
function moverAlSiguienteInput(inputActual) {
    const inputs = $('.cantidad-input');
    const currentIndex = inputs.index(inputActual);
    
    if (currentIndex < inputs.length - 1) {
        // Mover al siguiente input
        inputs.eq(currentIndex + 1).focus().select();
    } else {
        // Estamos en el último input, quitar el foco
        inputActual.blur();
    }
}
// Función para validar la cantidad ingresada y pintar toda la fila
function validarCantidad(inputElement, cantidadIngresada, cantidadMaxima) {
  // Convertir a números
  cantidadIngresada = parseInt(cantidadIngresada) || 0;
  cantidadMaxima = parseInt(cantidadMaxima) || 0;
  
  // Obtener la fila completa
  const fila = inputElement.closest('tr');
  
  // Remover clases anteriores de validación
  fila.removeClass('fila-excedida fila-faltante fila-correcta');
  inputElement.removeClass('input-excedido input-faltante input-correcto');
  
  if (cantidadIngresada > cantidadMaxima) {
    // Excede la cantidad - ROJO (toda la fila)
    fila.addClass('fila-excedida');
    inputElement.addClass('input-excedido');
  } else if (cantidadMaxima - cantidadIngresada >= 1) {
    // Faltan entre 2 y 5 - AMARILLO (toda la fila)
    fila.addClass('fila-faltante');
    inputElement.addClass('input-faltante');
  } else if (cantidadIngresada === cantidadMaxima) {
    // Cantidad exacta - VERDE (toda la fila)
    fila.addClass('fila-correcta');
    inputElement.addClass('input-correcto');
  } else {
    // Cantidad dentro del rango pero no en los casos especiales
    // Solo remover las clases, no agregar ninguna
    fila.removeClass('fila-excedida fila-faltante fila-correcta');
    inputElement.removeClass('input-excedido input-faltante input-correcto');
  }
}

// Función para validar TODOS los inputs
function validarTodasLasCantidades() {
  $('.cantidad-input').each(function() {
    let valor = $(this).val();
    let cantidadMaxima = $(this).data('cantidad-maxima');
    validarCantidad($(this), valor, cantidadMaxima);
  });
}

// Función para obtener todos los valores de los inputs
function obtenerValoresInputs() {
  let valores = [];
  $('.cantidad-input').each(function() {
    valores.push({
      co_art: $(this).data('co-art'),
      cantidad: $(this).val()
    });
  });
  return valores;
}

// Función para establecer valores específicos
function establecerCantidad(co_art, cantidad) {
  $(`.cantidad-input[data-co-art="${co_art}"]`).val(cantidad);
}

// Función para resetear todos los inputs
function resetearInputs() {
  $('.cantidad-input').val(0);
}






// Función para búsqueda en tiempo real (opcional)
$('#buscarProductoInput').on('input', function() {
    const searchTerm = $(this).val().trim().toLowerCase();
    
    if (searchTerm.length > 2) {
        // Opcional: búsqueda automática después de 3 caracteres
        buscarProducto();
    }
});

// Función para navegar entre productos con flechas (opcional)
$('#buscarProductoInput').on('keydown', function(e) {
    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        e.preventDefault();
        navegarProductos(e.key === 'ArrowDown');
    }
});

function navegarProductos(siguiente) {
    const filas = $('.fila-producto');
    const filaActual = $('.fila-seleccionada');
    
    if (filaActual.length === 0) {
        if (filas.length > 0) {
            // Seleccionar primera o última fila
            const filaSeleccionar = siguiente ? filas.first() : filas.last();
            seleccionarFila(filaSeleccionar);
        }
        return;
    }
    
    const indexActual = filas.index(filaActual);
    let nuevoIndex;
    
    if (siguiente) {
        nuevoIndex = (indexActual + 1) % filas.length;
    } else {
        nuevoIndex = (indexActual - 1 + filas.length) % filas.length;
    }
    
    seleccionarFila(filas.eq(nuevoIndex));
}

function seleccionarFila(fila) {
    $('.fila-producto').removeClass('fila-seleccionada');
    fila.addClass('fila-seleccionada');
    
    fila[0].scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
    
    fila.find('.cantidad-input').focus().select();
}

function buscarProducto() {
    const codigoBuscado = $('#buscarProductoInput').val().trim();
    
    if (!codigoBuscado) {
        alert('Por favor ingrese un código para buscar');
        return;
    }
    
    // Remover highlights anteriores de selección y foco
    $('.fila-producto').removeClass('fila-seleccionada fila-en-foco');
    
    // Buscar la fila que coincida con el código
    const filaEncontrada = $(`tr[data-co-art="${codigoBuscado}"]`);
    
    if (filaEncontrada.length > 0) {
        // Agregar clases de selección y foco
        filaEncontrada.addClass('fila-seleccionada fila-en-foco');
        
        // Hacer scroll a la fila
        filaEncontrada[0].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        
        // Enfocar el input de cantidad de esa fila
        const inputCantidad = filaEncontrada.find('.cantidad-input');
        if (inputCantidad.length > 0) {
            inputCantidad.focus();
            inputCantidad.select();
            
            // Validar la cantidad actual al enfocar
            let valor = inputCantidad.val();
            let cantidadMaxima = inputCantidad.data('cantidad-maxima');
            validarCantidad(inputCantidad, valor, cantidadMaxima);
        }
    } else {
        alert('No se encontró ningún producto con el código: ' + codigoBuscado);
        $('#buscarProductoInput').focus();
    }
}


// Obtener resumen de validaciones
function obtenerResumenValidaciones() {
    let resumen = {
        excedidas: $('.fila-excedida').length,
        faltantes: $('.fila-faltante').length,
        correctas: $('.fila-correcta').length,
        normales: $('.fila-producto').length - ($('.fila-excedida').length + $('.fila-faltante').length + $('.fila-correcta').length)
    };
    
    return resumen;
}

// Mostrar estadísticas en consola o en la interfaz
function mostrarEstadisticas() {
    const resumen = obtenerResumenValidaciones();
    console.log('📊 Estadísticas de validación:');
    console.log('❌ Filas excedidas:', resumen.excedidas);
    console.log('⚠️  Filas faltantes:', resumen.faltantes);
    console.log('✅ Filas correctas:', resumen.correctas);
    console.log('📋 Filas normales:', resumen.normales);
}
