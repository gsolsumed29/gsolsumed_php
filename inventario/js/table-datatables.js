
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


function cargarTablaFacturasDespachos() {

  var datatables_basic_facturas = $('.datatables-basic-facturas');
  var currentFactNum = ''; // Variable para almacenar el número de factura actual

  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataDespachos = $('.dataDespachos').val();
    let arrayDespachos = "";
    arrayDespachos = JSON.parse(dataDespachos);
    
    var dt_basic = datatables_basic_facturas.DataTable({
      data: arrayDespachos,
      columns: [
        { data: 'responsive_id' },
        { data: 'dato1' },
        { data: 'dato4' },
        { data: 'dato2' },
        { data: 'dato3' },
        { data: 'dato5' },
        { data: '' }
      ],
      columnDefs: [
        {
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          title: 'N°',
          width: '10px',
          targets: 1,
          visible: true
        },
        {
          title: 'Razón social',
          width: '50%',
          targets: 2,
          visible: true
        },
        {
          title: 'Fecha de chequeo',
          width: '10%',
          targets: 3,
          visible: true
        },
        {
          title: 'Preparado por',
          width: '20%',
          targets: 4,
          visible: true
        },           
        {
          title: 'Estatus del despacho',
          width: '10%',
          targets: 5,
          visible: true,
           render: function (data, type, full, meta) {
            var $status_number = full['dato5'];
            var $status = {
              1: { title: 'ENPAQUETADO', class: 'badge-light-primary' },
              2: { title: 'EN TRANSITO', class: ' badge-light-success' },
              3: { title: 'ENTREGADO', class: ' badge-light-danger' },
              4: { title: 'DEVUELTO', class: ' badge-light-warning' },
              0: { title: 'ELIMINADO', class: ' badge-light-info' }
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
          responsivePriority: 1,
          targets: 2
        },
        {   // Actions
          targets: -1,
          title: 'Acciones',
          width: '20%',
          orderable: false,
          render: function(data, type, full, meta) {
            var fact_num = full['dato1'].trim();
            var estatus = full['dato5'];
            
            // Determinar si los botones deben estar habilitados
            var isEnabled = (estatus === '1'); // Solo habilitado cuando estatus es 1 (Empaquetado)
            
            // Clases para botones habilitados vs deshabilitados
            var devolverClass = isEnabled ? 'btn btn-sm btn-warning me-1' : 'btn btn-sm btn-secondary me-1 disabled';
            var eliminarClass = isEnabled ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-secondary disabled';
            
            // Tooltips para explicar por qué están deshabilitados
            var tooltipText = !isEnabled ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="Solo disponible para pedidos empaquetados"' : '';
            
            return (
              '<div class="d-inline-flex">' +
                '<button ' + tooltipText + ' class="' + devolverClass + ' devolver" data-fact-num="' + fact_num + '">' +
                  feather.icons['corner-up-left'].toSvg({ class: 'font-small-4' }) +
                '</button>' +
                '<button ' + tooltipText + ' class="' + eliminarClass + ' eliminar" data-fact-num="' + fact_num + '">' +
                  feather.icons['trash'].toSvg({ class: 'font-small-4' }) +
                '</button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[3, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 10,
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
              exportOptions: { columns: [2, 3, 4, 5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'portrait',
              exportOptions: { columns: [2, 3, 4, 5] }
            }
          ],
          init: function(api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function() {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function(row) {
              var data = row.data();
              return 'Detalles de la factura';
            }
          }),
          type: 'column',
          renderer: function(api, rowIdx, columns) {
            var data = $.map(columns, function(col, i) {
              return col.title !== '' ?
                '<tr data-dt-row="' +
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
                '</tr>' :
                '';
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
        }
      },
      createdRow: function(row, data, dataIndex) {
        // Inicializar tooltips para esta fila
        $('[data-bs-toggle="tooltip"]', row).tooltip();
      }
    });

      $('div.head-label').html('<h6 class="mb-0">Depachos realizados</h6>');
    
    // Event Listeners para los botones
    $(document).on('click', '.devolver:not(.disabled)', function(e) {
      e.preventDefault();
      currentFactNum = $(this).data('fact-num');
      $('#devolucionFactNum').text(currentFactNum);
      $('#motivoDevolucion').val(''); // Limpiar textarea
      $('#modalDevolucion').modal('show');
    });

    $(document).on('click', '.eliminar:not(.disabled)', function(e) {
      e.preventDefault();
      currentFactNum = $(this).data('fact-num');
      $('#eliminacionFactNum').text(currentFactNum);
      $('#motivoEliminacion').val(''); // Limpiar textarea
      $('#modalEliminacion').modal('show');
    });

    // Confirmar Devolución
    $('#confirmarDevolucion').on('click', function() {
      var motivo = $('#motivoDevolucion').val().trim();
      
      if (!motivo) {
        alert('Por favor, ingrese el motivo de la devolución.');
        return;
      }

      realizarDevolucion(currentFactNum, motivo);
    });

    // Confirmar Eliminación
    $('#confirmarEliminacion').on('click', function() {
      var motivo = $('#motivoEliminacion').val().trim();
      
      if (!motivo) {
        alert('Por favor, ingrese el motivo de la eliminación.');
        return;
      }

      realizarEliminacion(currentFactNum, motivo);
    });

    // Inicializar tooltips
    $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('show');
    }).on('mouseleave', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('hide');
    });
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

function cargarTablaFacturasDespacho(){
  var dataTablesFacturasDespachar = $('.dataTablesFacturasDespachar');   
    
  if (dataTablesFacturasDespachar.length) {
    if ($.fn.DataTable.isDataTable(dataTablesFacturasDespachar)) {
      dataTablesFacturasDespachar.DataTable().destroy();
      dataTablesFacturasDespachar.empty();
    }
    
    let dataFacturasDespacho = $('.dataFacturasDespacho').val();
    
    try {
      dataFacturasDespacho = JSON.parse(dataFacturasDespacho);
    } catch (e) {
      console.error('Error parsing JSON data:', e);
      return;
    }

    var dt_basic = dataTablesFacturasDespachar.DataTable({
      data: dataFacturasDespacho,
      columns: [    
        { 
          data: 'fact_num',
          className: 'text-center fw-bold'
        },
          { 
          data: 'dato1',
          className: 'text-center fw-bold'
        },
        { 
          data: null,
          className: 'text-center'
        }
      ],
      columnDefs: [
        {
          targets: 0,
          title: 'N° Factura',
          width: '40%',
          responsivePriority: 1
        },
          {
          targets: 1,
          title: 'Fecha de emisión',
          width: '30%',
          orderable: false,
          searchable: false
     
        },
        {
          targets: 2,
          title: 'Acción',
          width: '30%',
          orderable: false,
          searchable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex justify-content-center">' +
              '<button class="btn btn-success btn-sm btn-despachar" data-fact-num="' + full.fact_num + '">' +
              feather.icons['truck'].toSvg({ 
                class: 'font-medium-1',
                width: '16px',
                height: '16px'
              }) +
              ' <span class="d-none d-sm-inline">Despachar</span>' +
              '</button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[0, 'desc']],
      
      // DOM SIN información (i) y paginador centrado
      dom: `
        <"row mb-3"
          <"col-sm-12 col-md-6"l>
          <"col-sm-12 col-md-6"f>
        >
        <"row"
          <"col-sm-12"tr>
        >
        <"row mt-3"
          <"col-sm-12"p>
        >
      `,
      
      displayLength: 6,
      lengthMenu: [5, 6, 10, 15],
      
      // Deshabilitar información
      info: false,
      
      search: {
        return: true,
        smart: false
      },
      
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return '<h5 class="modal-title">Detalles - Factura: ' + data.fact_num + '</h5>';
            }
          }),
          type: 'column',
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: 'table'
          })
        }
      },

      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ facturas",
        "sZeroRecords": "No se encontraron facturas",
        "sEmptyTable": "No hay facturas para despachar",
        "sInfo": "", // Vacío ya que deshabilitamos info
        "sInfoEmpty": "",
        "sInfoFiltered": "",
        "sSearch": "Buscar factura:",
        "sSearchPlaceholder": "Ingrese número de factura...",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        }
      },

      pageLength: 6,
      pagingType: "simple_numbers",
      scrollX: false,
      autoWidth: true,
      searching: true,
      processing: true
    });

    // Event handlers
    dataTablesFacturasDespachar.off('click', '.btn-despachar').on('click', '.btn-despachar', function(e) {
      e.preventDefault();
      var factNum = $(this).data('fact-num');
      despacharFactura(factNum);
    });

    // Ajustar después de renderizar
    setTimeout(function() {
      dt_basic.columns.adjust().responsive.recalc();
      $('.dataTables_filter input').attr('placeholder', 'Buscar por número de factura...');
    }, 300);
  }
}
function despacharFactura(factNum) {
  console.log('Despachando factura:', factNum);
  
  // Asegurarnos que factNum sea tratado como string
  var factNumStr = String(factNum || ''); // Convierte a string, maneja null/undefined
  var codigoConsulta;
  
  // Transformar NF a 500 para la consulta
  if (factNumStr.startsWith('NF')) {
    // Reemplazar "NF" por "500" y mantener los números siguientes
    var numeros = factNumStr.substring(2); // Obtener todo después de "NF"
    codigoConsulta = '50' + numeros;
  } else {
    codigoConsulta = factNumStr;
  }
  
  // Ejemplo con SweetAlert2 para mejor experiencia en modal
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title: '¿Despachar factura?',
      text: 'Va a despachar la factura: ' + factNumStr,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, despachar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#198754'
    }).then((result) => {
      if (result.isConfirmed) {
        setTimeout(function() {
          window.location.href = 'index.php?view=fverificacion&s=0&fact_num=' + codigoConsulta + '&fact_num_text=' + factNumStr;
        }, 1000);
      }
    });
  } else {
    // Fallback si SweetAlert2 no está disponible
    if (confirm('¿Despachar factura: ' + factNumStr + '?')) {
      setTimeout(function() {
        window.location.href = 'index.php?view=fverificacion&s=0&fact_num=' + codigoConsulta + '&fact_num_text=' + factNumStr;
      }, 1000);
    }
  }
}


$(window,document,$).ready(function(){
  'use strict';


$('#buscarProductoInput').focus().select();
    





// Agregar este CSS para resaltar el campo con error
const estiloError = `
    <style>
        .campo-error {
            border: 2px solid #ff3860 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 56, 96, 0.25) !important;
        }
    </style>
`;
$('head').append(estiloError);


// Evento del botón de búsqueda
$('.btnBuscarFactura').on('click', buscarFactura);



// Evento del botón de búsqueda

// Y REEMPLÁZALA POR ESTA:
$('#btnBuscarFactura_seleccionada').on('click', function() {
  // 1. Obtenemos el valor del input en el momento del clic
  let filtro = 'no';

  // 2. Validamos que el campo no esté vacío (opcional pero recomendado)
  if (filtro === "") {
      alert("Por favor, ingrese un número de factura o dato a buscar.");
      return; // Detenemos la ejecución si no hay nada que buscar
  }
  $("#modalBuscarFactura_seleccionada").modal("show");
  // 3. Llamamos a tu función principal con el valor obtenido
  cargarDataFacturaDespacho_seleccionada(filtro);
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
if ($('.m_despachos_consulta').length) {
  resaltarMenu('.i_despachos_consulta');
}
  cargarDataDespachos('NO');


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



function cargarDataDespachos($filtro){
  
  if ($('#dataDespachos').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=despacho&tipo=1&accion=2&datos=1&c=FacturaData&t=factura&filtro='+$filtro,
}).done(function(despachos) { 
  var cadena = JSON.stringify(despachos);
  $('.dataDespachos').attr("value",cadena);
    cargarTablaFacturasDespachos();
});
  }
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
}//eliminar la visita
function resaltarMenu(componente){
$(componente).addClass('active');
}
//eliminar la visita
function cargarDataFacturaDespacho($fact_nun){

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
function cargarDataFacturaDespacho_seleccionada(filtro) {
  console.log("Buscando facturas con el filtro:", filtro);
  
  $.ajax({
      url: '../admin/index.php?action=facturacion&c=FacturaData&tipo=1&accion=3&datos=1&filtro=' + filtro,
      type: "GET",
      beforeSend: function() {
          // Opcional: Mostrar un indicador de carga en la tabla
          $('#dataTablesFacturasDespachar tbody').html('<tr><td colspan="3" class="text-center">Cargando...</td></tr>');
      },
      success: function(data) {
          // Guardamos los datos en el campo oculto como antes
          $('.dataFacturasDespacho').attr("value", JSON.stringify(data));
          
          // Llamamos a la función que redibuja la tabla
          cargarTablaFacturasDespacho();
      },
      error: function() {
          // Manejo de errores
          $('#dataTablesFacturasDespachar tbody').html('<tr><td colspan="3" class="text-center text-danger">Error al cargar los datos.</td></tr>');
      }
  });
}

// --- NUEVOS MANEJADORES DE EVENTOS ---

// 1. Evento para el botón de buscar DENTRO del modal
$('#btnBuscarPorMes').on('click', function() {
  // Obtenemos el mes seleccionado del dropdown
  let mesSeleccionado = $('#mesFiltro').val();
  
  // Llamamos a la función principal con el filtro seleccionado
  cargarDataFacturaDespacho_seleccionada(mesSeleccionado);
});


// --- EJEMPLO: Botón que ABRE el modal (debes tener uno en tu página principal) ---
// Supongamos que tienes un botón en tu página como este:
// <button type="button" class="btn btn-primary" id="btnAbrirModalFacturas">
//     Seleccionar Factura
// </button>

$('#btnAbrirModalFacturas').on('click', function() {
  // 1. Mostramos el modal
  $("#modalBuscarFactura_seleccionada").modal("show");

  // 2. Cargamos los datos del mes actual por defecto
  // La opción "Mes Actual" en el select tiene el valor "no"
  cargarDataFacturaDespacho_seleccionada("no");
});
// Función reusable para buscar factura
function buscarFactura() {
  var $fac_num = $('#inputCodigoFactura').val().trim().toUpperCase();
  var errorMessage = '';
  var codigoConsulta = $fac_num; // Variable para el código que se enviará a la consulta
  
  // Validaciones
  if ($fac_num === '') {
      errorMessage = 'Debe ingresar un código de factura válido';
  } else if (!/^(NF\d*|\d+)$/.test($fac_num)) {
      errorMessage = 'Formato inválido. Use: NF + números o solo números';
  } else if ($fac_num.startsWith('N') && !$fac_num.startsWith('NF')) {
      errorMessage = 'Si ingresa "N", debe seguir con "F" (ej: NF123)';
  }
  
  // Manejo de errores
  if (errorMessage) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: errorMessage,
          confirmButtonColor: '#0343a5',
          confirmButtonText: 'Aceptar'
      });
      $('#inputCodigoFactura').focus();
      return false;
  }
  
  // Transformar NF a 500 para la consulta
  if ($fac_num.startsWith('NF')) {
      // Reemplazar "NF" por "500" y mantener los números siguientes
      var numeros = $fac_num.substring(2); // Obtener todo después de "NF"
      codigoConsulta = '500' + numeros;
  }
  
  //console.log('Input original:', $fac_num);
  //console.log('Código para consulta:', codigoConsulta);
  
  // Éxito - enviar el código transformado a la consulta
  cargarDataFacturaDespacho(codigoConsulta);
  $('#modalBuscarFactura').modal('hide');
  return true;
}
// Función para realizar la devolución vía AJAX
function realizarDevolucion(factNum, motivo) {
  $.ajax({
    url: '../admin/index.php?action=despacho&tipo=1&accion=3&datos=1',
    type: 'POST',
    data: {
      fact_num: factNum,
      motivo: motivo
    },
    beforeSend: function() {
      $('#confirmarDevolucion').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
    },
    success: function(response) {
      try {
        var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
        
        if (jsonResponse.success) {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: jsonResponse.message || 'Despacho devuelto exitosamente',
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true
          }).then(() => {
         
               setTimeout(function() {
                        window.location.href = 'index.php?view=despachos';
                    }, 1000); // 2000 milisegundos = 2 segundos
           
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: jsonResponse.message || 'Error al devolver el despacho',
            confirmButtonText: 'Entendido'
          });
        }
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error al procesar la respuesta del servidor',
          confirmButtonText: 'Entendido'
        });
      }
    },
    error: function(xhr) {
      var errorMessage = 'Error de conexión con el servidor';
      if (xhr.responseJSON && xhr.responseJSON.message) {
        errorMessage = xhr.responseJSON.message;
      } else if (xhr.statusText) {
        errorMessage = 'Error: ' + xhr.statusText;
      }
      
      Swal.fire({
        icon: 'error',
        title: 'Error de conexión',
        text: errorMessage,
        confirmButtonText: 'Entendido'
      });
    },
    complete: function() {
      $('#confirmarDevolucion').prop('disabled', false).text('Confirmar Devolución');
    }
  });
}

// Función para realizar la eliminación vía AJAX
function realizarEliminacion(factNum, motivo) {
  // Usar SweetAlert en lugar de confirm nativo
  Swal.fire({
    title: '¿Está absolutamente seguro?',
    text: "Esta acción no se puede deshacer. Todos los datos relacionados serán eliminados permanentemente.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '../admin/index.php?action=despacho&tipo=1&accion=4&datos=1',
        type: 'POST',
        data: {
          fact_num: factNum,
          motivo: motivo
        },
        beforeSend: function() {
          $('#confirmarEliminacion').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Eliminando...');
        },
        success: function(response) {
          try {
            var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            
            if (jsonResponse.success) {
              Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: jsonResponse.message || 'Despacho eliminado exitosamente',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
              }).then(() => {
               
             setTimeout(function() {
                        window.location.href = 'index.php?view=despachos';
                    }, 1000); // 2000 milisegundos = 2 segundos
                
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jsonResponse.message || 'Error al eliminar el despacho',
                confirmButtonText: 'Entendido'
              });
            }
          } catch (e) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error al procesar la respuesta del servidor',
              confirmButtonText: 'Entendido'
            });
          }
        },
        error: function(xhr) {
          var errorMessage = 'Error de conexión con el servidor';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          } else if (xhr.statusText) {
            errorMessage = 'Error: ' + xhr.statusText;
          }
          
          Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: errorMessage,
            confirmButtonText: 'Entendido'
          });
        },
        complete: function() {
          $('#confirmarEliminacion').prop('disabled', false).text('Confirmar Eliminación');
        }
      });
    }
  });
}

