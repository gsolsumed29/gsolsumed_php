
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
      // --- INICIO DE CAMBIOS ---
      // 1. Se agregó una nueva columna al principio para el número de fila
      columns: [
        { 
          data: null, // No usa datos del array original
          render: function (data, type, row, meta) {
            // Calcula el número de fila considerando la paginación
            // meta.settings._iDisplayStart es el índice del primer elemento de la página actual
            // meta.row es el índice de la fila dentro de la página actual (0, 1, 2...)
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        { data: 'responsive_id' }, 
        { data: 'dato7' }, 
        { data: 'dato4' }, 
        { data: 'dato2' }, 
        { data: 'dato3' }, 
        { data: 'dato6' },  
        { data: 'dato5' },  
        { data: '' } 
      ],
      // --- FIN DE CAMBIOS ---
      columnDefs: [
        // --- INICIO DE CAMBIOS ---
        // 2. Se actualizó el índice de todos los 'targets' porque se agregó una columna
        // 3. Se agregó una nueva definición para la columna de número de fila (targets: 0)
        {
          title: '#', // Título para la nueva columna
          width: '30px', // Un ancho fijo pequeño
          orderable: false, // No se puede ordenar por número de fila
          targets: 0
        },
        {
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 1 // Antes era 0
        },
        {
          title: 'N°',
          width: '10px',
          targets: 2, // Antes era 1
          visible: true
        },
        {
          title: 'Razón social',
          width: '50%',
          targets: 3, // Antes era 2
          visible: true
        },
        {
          title: 'Fecha de chequeo',
          width: '10%',
          targets: 4, // Antes era 3
          visible: true
        },
          {
          title: 'Verificado por',
          width: '20%',
          targets: 6, // Antes era 5
          visible: true
        },           
        {
          title: 'Preparado por',
          width: '20%',
          targets: 5, // Antes era 4
          visible: true
        },           
        {
          title: 'Estatus del despacho',
          width: '10%',
          targets: 7, // Antes era 6
          visible: true,
           render: function (data, type, full, meta) {
            var $status_number = full['dato5'];
            var $status = {
              1: { title: 'EMPAQUETADO', class: 'badge-light-primary' },
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
          targets: 3 // Antes era 2
        },
        {   // Actions
          targets: -1, // Este no necesita cambio porque se refiere a la última columna
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
        // --- FIN DE CAMBIOS ---
      ],
      order: [[4, 'desc']], // Se actualizó el índice de ordenación por el cambio de columnas (antes era 3)
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
              exportOptions: { columns: [3, 4, 5, 6] } // Índices actualizados
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'portrait',
              exportOptions: { columns: [3, 4, 5, 6] } // Índices actualizados
            }
          ],
          init: function(api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function() {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        },
            {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Buscar',
          className: 'btn btn-relief-primary',
          
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalBuscarDespacho'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
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

function cargarTablaFacturasEmpaquetado() {
  let facturasSeleccionadas = [];
  let clienteActual = null;
  let loteIdGlobal = null; // Variable para almacenar el número de lote global

  var datatables_basic_facturas = $('.datatables-basic-facturas');

  if (datatables_basic_facturas.length) {
      if ($.fn.dataTable.isDataTable('.datatables-basic-facturas')) {
          datatables_basic_facturas.DataTable().destroy();
      }

      // Asegúrate de que los datos se están cargando correctamente
      let dataDespachos = $('.dataDespachosEmpaquetar').val();
      
      // Verifica si hay datos
      if (!dataDespachos) {
          console.error('No se encontraron datos en el campo dataDespachosEmpaquetar');
          return;
      }
      
      let arrayDespachos;
      try {
          arrayDespachos = JSON.parse(dataDespachos);
      } catch (e) {
          console.error('Error al parsear los datos JSON:', e);
          return;
      }
      
      // Verifica que el array tenga datos
      if (!arrayDespachos || arrayDespachos.length === 0) {
          console.warn('El array de despachos está vacío');
          // Puedes mostrar un mensaje al usuario
          datatables_basic_facturas.html('<p>No hay datos de despachos disponibles</p>');
          return;
      }

      // Imprime los datos en consola para depuración
      console.log('Datos de despachos:', arrayDespachos);

      var dt_basic = datatables_basic_facturas.DataTable({
          data: arrayDespachos,
          // Modifica las columnas de la tabla para incluir más datos del cliente
          columns: [
              { // Columna de checkbox
                  // CAMBIO 1: Se elimina el checkbox de "Seleccionar Todo" del título.
                  title: 'Seleccionar',
                  data: null,
                  orderable: false,
                  className: 'text-center',
                  render: function (data, type, row, meta) {
                      return '<input type="checkbox" class="form-check-input select-invoice" data-invoice=\'' + 
                             JSON.stringify({
                                 numero_factura: row['factura_serie'] || row['dato7'],
                                 nombre_cliente: row['cliente_nombre'] || row['dato4'],
                                 fecha_despacho: row['factura_fecha_despacho'] || row['dato2'],
                                 direccion_cliente: row['cliente_direccion'] || 'Dirección no disponible',
                                 codigo_cliente: row['cliente_codigo'] || 'N/A',
                                 ciudad_cliente: row['cliente_ciudad'] || 'N/A',
                                 zip_cliente: row['cliente_zip'] || 'N/A',
                                 telefonos_cliente: row['cliente_telefonos'] || 'N/A',
                                 zona_cliente: row['cliente_zona'] || 'N/A'
                             }) + '\'>';
                  }
              },
              { // Columna # (Contador)
                  title: '#',
                  data: null,
                  render: function (data, type, row, meta) {
                      return meta.settings._iDisplayStart + meta.row + 1;
                  }
              },
              { data: 'responsive_id' }, 
              { 
                  // Columna del número de factura con interactividad
                  title: 'N° Factura',
                  data: null,
                  render: function (data, type, full, meta) {
                      const numeroFactura = full['factura_serie'] || full['dato7'] || 'N/A';
                      return `<span class="invoice-number-link text-primary fw-bold" style="cursor: pointer;">${numeroFactura}</span>`;
                  }
              }, 
              { 
                  // Columna del nombre del cliente
                  title: 'Razón social',
                  data: null,
                  render: function (data, type, full, meta) {
                      const nombreCliente = full['cliente_nombre'] || full['dato4'] || 'N/A';
                      const codigoCliente = full['cliente_codigo'] || 'N/A';
                      return `
                          <div>
                              <strong>${nombreCliente}</strong>
                              <br><small class="text-muted">Código: ${codigoCliente}</small>
                          </div>
                      `;
                  },
                  visible: true
              }, 
              { 
                  // Columna de dirección completa del cliente
                  title: 'Dirección',
                  data: null,
                  render: function (data, type, full, meta) {
                      const direccion = full['cliente_direccion'] || 'N/A';
                      const ciudad = full['cliente_ciudad'] || 'N/A';
                      const zona = full['cliente_zona'] || 'N/A';
                      const zip = full['cliente_zip'] || 'N/A';
                      
                      return `
                          <div>
                              <div>${direccion}</div>
                              <small class="text-muted">${ciudad}, ${zona}</small>
                              <br><small class="text-muted">ZIP: ${zip}</small>
                          </div>
                      `;
                  },
                  visible: true
              },
              { 
                  // Columna de contacto del cliente
                  title: 'Contacto',
                  data: null,
                  render: function (data, type, full, meta) {
                      const telefonos = full['cliente_telefonos'] || 'N/A';
                      return `
                          <div>
                              <i class="fas fa-phone me-1"></i> ${telefonos}
                          </div>
                      `;
                  },
                  visible: true
              },
              { 
                  // Columna de fecha de despacho
                  title: 'Fecha de chequeo',
                  data: null,
                  render: function (data, type, full, meta) {
                      return full['factura_fecha_despacho'] || full['dato2'] || 'N/A';
                  }
              }, 
              { 
                  // Columna de preparado por
                  title: 'Preparado por',
                  data: null,
                  render: function (data, type, full, meta) {
                      return full['despacho_preparado_por'] || full['dato3'] || 'N/A';
                  },
                  visible: false
              }, 
              { 
                  // Columna de verificado por
                  title: 'Verificado por',
                  data: null,
                  render: function (data, type, full, meta) {
                      return full['despacho_verificado_por'] || full['dato6'] || 'N/A';
                  },
                  visible: false
              },  
              { 
                  // Columna de estatus
                  title: 'Estatus del despacho',
                  data: null,
                  render: function (data, type, full, meta) {
                      const statusNumber = full['factura_estatus'] || full['dato5'];
                      var $status = {
                          1: { title: 'EMPAQUETADO', class: 'badge-light-primary' },
                          2: { title: 'EN TRANSITO', class: ' badge-light-success' },
                          3: { title: 'ENTREGADO', class: ' badge-light-danger' },
                          4: { title: 'DEVUELTO', class: ' badge-light-warning' },
                          0: { title: 'ELIMINADO', class: ' badge-light-info' }
                      };
                      if (typeof $status[statusNumber] === 'undefined') {
                          return statusNumber || 'N/A';
                      }
                      return (
                          '<span class="badge rounded-pill ' +
                          $status[statusNumber].class +
                          '">' +
                          $status[statusNumber].title +
                          '</span>'
                      );
                  },
                  visible: false
              }
          ],
          columnDefs: [
              {
                  className: 'control',
                  orderable: false,
                  responsivePriority: 2,
                  targets: 2
              },
              {
                  width: '10px',
                  targets: 3,
                  visible: true,
                  responsivePriority: 1
              },
              {
                  width: '20%',
                  targets: 4,
                  visible: true
              },
              {
                  width: '30%',
                  targets: 5,
                  visible: true
              },
              {
                  width: '15%',
                  targets: 6,
                  visible: true
              },
              {
                  width: '10%',
                  targets: 7,
                  visible: true
              },
              {
                  width: '20%',
                  targets: 8,
                  visible: false
              },           
              {
                  width: '20%',
                  targets: 9,
                  visible: false
              },           
              {
                  width: '10%',
                  targets: 10,
                  visible: false
              },
              {
                  responsivePriority: 3,
                  targets: 7
              }
          ],
          order: [[5, 'desc']],
          dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 10,
          lengthMenu: [7, 10, 25, 50, 75, 100],
          responsive: true,
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
                          orientation: 'portrait',
                          exportOptions: { columns: [3, 4, 5, 6, 7] }
                      }
                  ],
                  init: function(api, node, config) {
                      $(node).removeClass('btn-secondary');
                      $(node).parent().removeClass('btn-group');
                      setTimeout(function() {
                          $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                      }, 50);
                  }
              },
             
              {
                  text: feather.icons['package'].toSvg({ class: 'me-50 font-small-4' }) + 'Generar',
                  className: 'btn btn-relief-success btn-generar-etiquetas-seleccionadas',
                  init: function (api, node, config) {
                      $(node).removeClass('btn-secondary');
                  }
              }
          ],
          language: {
              "sProcessing": "Procesando...",
              "sLengthMenu": "Mostrar _MENU_ resultados",
              "sZeroRecords": "No se encontraron resultados",
              "sEmptyTable": "Ningún dato disponible en esta tabla",
              "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
              "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
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
          initComplete: function() {
              // Mostrar información de depuración
              console.log('DataTable inicializado con ' + arrayDespachos.length + ' registros');
          }
      });

      $('div.head-label').html('<h6 class="mb-0">Depachos realizados</h6>');
  
      // --- INICIO DE LOS EVENT LISTENERS ---

      // CAMBIO 2: Se elimina completamente el event listener para "Seleccionar Todas"
      // Evento para seleccionar/deseleccionar todas las facturas
      /*
      $('#selectAllInvoices').on('change', function() {
          // ... todo este bloque se elimina
      });
      */

      // Evento para seleccionar/deseleccionar una factura individual
      $('.datatables-basic-facturas tbody').on('change', '.select-invoice', function() {
          const invoiceData = JSON.parse($(this).attr('data-invoice'));
          const isChecked = $(this).prop('checked');
          
          if (isChecked) {
              if (facturasSeleccionadas.length === 0) {
                  clienteActual = invoiceData.nombre_cliente;
                  facturasSeleccionadas.push(invoiceData);
              } else if (clienteActual === invoiceData.nombre_cliente) {
                  facturasSeleccionadas.push(invoiceData);
              } else {
                  $(this).prop('checked', false);
                  
                  Swal.fire({
                      icon: 'warning',
                      title: 'Factura de cliente diferente',
                      text: `Ya ha seleccionado facturas de "${clienteActual}". Solo puede seleccionar facturas del mismo cliente.`,
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Entendido'
                  });
              }
          } else {
              facturasSeleccionadas = facturasSeleccionadas.filter(factura => 
                  factura.numero_factura !== invoiceData.numero_factura
              );
              
              if (facturasSeleccionadas.length === 0) {
                  clienteActual = null;
              }
          }
          
          // CAMBIO 3: Se elimina la lógica que actualizaba el checkbox "Seleccionar Todos"
          /*
          const totalInvoices = $('.select-invoice').length;
          const selectedInvoices = $('.select-invoice:checked').length;
          
          if (selectedInvoices === 0) {
              $('#selectAllInvoices').prop('checked', false).prop('indeterminate', false);
          } else if (selectedInvoices === totalInvoices) {
              $('#selectAllInvoices').prop('checked', true).prop('indeterminate', false);
          } else {
              $('#selectAllInvoices').prop('indeterminate', true);
          }
          */
      });
      
      // Evento para generar etiquetas con facturas seleccionadas
      $('.btn-generar-etiquetas-seleccionadas').on('click', function() {
          if (facturasSeleccionadas.length === 0) {
              Swal.fire({
                  icon: 'info',
                  title: 'Sin facturas seleccionadas',
                  text: 'Por favor, seleccione al menos una factura para generar etiquetas.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              return;
          }
          
          const nombresFacturas = facturasSeleccionadas.map(f => f.numero_factura).join(', ');
          $('#infoFactura').text(`Facturas seleccionadas: ${nombresFacturas} - Cliente: ${clienteActual}`);
          $('#numPaquetes').val(1);
          $('#modalConfigurarPaquete').modal('show');
      });

      $('#btnGenerarPreview').on('click', function() {
        const numPaquetes = parseInt($('#numPaquetes').val());
        if (isNaN(numPaquetes) || numPaquetes < 1) {
            Swal.fire({
                icon: 'error',
                title: 'Número de paquetes inválido',
                text: 'Por favor, ingrese un número de paquetes válido.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
            return;
        }
    
        $('#modalConfigurarPaquete').modal('hide');
        const $contenedor = $('#contenedorEtiquetas');
        $contenedor.empty();
        
        // Generar un número aleatorio único para este lote de etiquetas
        // MODIFICACIÓN: Solo generar un nuevo loteId si no existe uno global
        if (!loteIdGlobal) {
            loteIdGlobal = 'LOT-' + Date.now() + '-' + Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        }
        
        // Usamos una sola columna para que se vea como un apilado de papel.
        $contenedor.html('<div class="row g-3"></div>'); 
        const $row = $contenedor.find('.row');
        
        for (let i = 1; i <= numPaquetes; i++) {
            const qrCodeId = `qrcode-${i}`;
            const barcodeId = `barcode-${i}`;
            const nombresFacturas = facturasSeleccionadas.map(f => f.numero_factura).join(', ');
            
            // Obtener datos del cliente de la primera factura seleccionada
            const cliente = facturasSeleccionadas[0];
            
            // MANTENEMOS EL ESTILO ORIGINAL DE LA TARJETA (CARD) PERO CON LOS NUEVOS DATOS
            const etiquetaHTML = `
                <div class="col-12 etiqueta-para-imprimir">
                    <div class="card invoice-container border-primary h-100">
                        <div class="card-header bg-primary text-white py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark">Paquete ${i} de ${numPaquetes}</span>
                                
                            </div>
                            <div class="company-info small mt-1 text-center">
                              <strong>GRUPO SOLSUMED, C.A.</strong>
                            <p class="mb-0">Tel: 0424-5670633 / 0424-5885591 / 0251-2732866 | RIF: J-50096706-3</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="parties-container mb-3">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <h6 class="text-primary">Destinatario:</h6>
                                        <p class="mb-1"><strong>${cliente.nombre_cliente}</strong></p>
                                        <p class="mb-1 small">Código: ${cliente.codigo_cliente}</p>
                                        <p class="small text-muted mb-1">${cliente.direccion_cliente}</p>
                                        <p class="small text-muted mb-1">${cliente.ciudad_cliente}, ${cliente.zona_cliente}</p>
                                        <p class="small text-muted mb-1">ZIP: ${cliente.zip_cliente}</p>
                                        <p class="mb-0 small"><i class="fas fa-phone"></i> ${cliente.telefonos_cliente}</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <h6 class="text-primary">Remitente:</h6>
                                        <p class="mb-1"><strong>GRUPO SOLSUMED, C.A.</strong></p>
                                        <p class="mb-1 small text-muted">BARQUISIMETO, ESTADO LARA.</p>
                                        <p class="mb-1 small text-muted">Tel: 0424-5670633</p>
                                        <div class="qr-section text-center mt-2">
                                            <div id="${qrCodeId}" class="qr-code-placeholder d-inline-block p-2 border border-2 border-dashed rounded"></div>
                                            <p class="small text-muted mt-2 mb-0">Código de Seguimiento</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="details-section mb-3">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>N° de Facturas:</span>
                                            <strong>${nombresFacturas}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>Fecha de Despacho:</span>
                                            <strong>${cliente.fecha_despacho}</strong>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Código de barras -->
                            <div class="barcode-section text-center">
                                <svg id="${barcodeId}" class="barcode-placeholder"></svg>
                               
                            </div>
                        </div>
                        <div class="card-footer bg-light py-2">
                            <p class="small text-muted mb-0 text-center">Manéjese con cuidado. | <strong>FRÁGIL</strong> | Este documento no tiene validez fiscal. | TRANSPORTE INTERNO </p>
                        </div>
                    </div>
                </div>
            `;
    
            $row.append(etiquetaHTML);
    
            // Generar el código QR y de barras después de agregar el HTML al DOM
            setTimeout(() => {
                const facturasQR = facturasSeleccionadas.map(f => f.numero_factura).join('-');
                new QRCode(document.getElementById(qrCodeId), {
                    text: `${facturasQR}-${i}`,
                    width: 80, // Un poco más grande para que se vea bien en la card
                    height: 80,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
    
                JsBarcode(document.getElementById(barcodeId), loteIdGlobal, {
                    format: "CODE128",
                    width: 1.5,
                    height: 30,
                    displayValue: true,
                    fontSize: 10,
                    margin: 5
                });
            }, 100);
        }
    
        $('#modalPreviewEtiqueta').modal('show');
    });


      $('#btnImprimirEtiquetas').off('click').on('click', async function(e) {
          e.preventDefault();
          
          const numPaquetes = parseInt($('#numPaquetes').val());
          
          if (facturasSeleccionadas.length === 0) {
              Swal.fire({
                  icon: 'error',
                  title: 'Sin facturas seleccionadas',
                  text: 'Error: No se ha seleccionado ninguna factura. Por favor, seleccione una de la tabla.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

          if (isNaN(numPaquetes) || numPaquetes < 1) {
              Swal.fire({
                  icon: 'error',
                  title: 'Número de paquetes inválido',
                  text: 'Por favor, ingrese un número de paquetes válido en el campo correspondiente.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

          const $btn = $(this);
          const originalHtml = $btn.html();
          $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando PDF...').prop('disabled', true);

          try {
              await generarPDFNotasEntrega(facturasSeleccionadas, numPaquetes);
          } catch (error) {
              console.error('Error al generar el PDF:', error);
              Swal.fire({
                  icon: 'error',
                  title: 'Error al generar PDF',
                  text: 'Ocurrió un error al generar el PDF. Revise la consola para más detalles.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
          } finally {
              $btn.html(originalHtml).prop('disabled', false);
              if (typeof feather !== 'undefined') {
                  feather.replace();
              }
          }
      });

      $('#btnImprimirEtiquetasPrint').off('click').on('click', async function(e) {
          e.preventDefault();
          
          const numPaquetes = parseInt($('#numPaquetes').val());
          
          if (facturasSeleccionadas.length === 0) {
              Swal.fire({
                  icon: 'error',
                  title: 'Sin facturas seleccionadas',
                  text: 'Error: No se ha seleccionado ninguna factura. Por favor, seleccione una de la tabla.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

          if (isNaN(numPaquetes) || numPaquetes < 1) {
              Swal.fire({
                  icon: 'error',
                  title: 'Número de paquetes inválido',
                  text: 'Por favor, ingrese un número de paquetes válido en el campo correspondiente.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

          imprimirDirectamente(facturasSeleccionadas, numPaquetes);
      });

      // --- LÓGICA DE PULSACIÓN LARGA (LONG-PRESS) ---
      let pressTimer;
      let isLongPress = false;

      function mostrarFichaFactura(data) {
          // Usar campos descriptivos o genéricos según disponibilidad
          $('#ficha-numero-factura').text(data.factura_serie || data.dato7 || 'N/A');
          $('#ficha-nombre-cliente').text(data.cliente_nombre || data.dato4 || 'N/A');
          $('#ficha-codigo-cliente').text(data.cliente_codigo || 'N/A');
          $('#ficha-direccion').text(data.cliente_direccion || 'N/A');
          $('#ficha-ciudad').text(data.cliente_ciudad || 'N/A');
          $('#ficha-zona').text(data.cliente_zona || 'N/A');
          $('#ficha-zip').text(data.cliente_zip || 'N/A');
          $('#ficha-telefonos').text(data.cliente_telefonos || 'N/A');
          $('#ficha-fecha-chequeo').text(data.factura_fecha_despacho || data.dato2 || 'N/A');
          $('#ficha-preparado-por').text(data.despacho_preparado_por || data.dato3 || 'N/A');
          $('#ficha-verificado-por').text(data.despacho_verificado_por || data.dato6 || 'N/A');
          
          // Usar campo descriptivo o genérico para el estatus
          const statusNumber = data.factura_estatus || data.dato5;
          var $status = {
              1: { title: 'EMPAQUETADO', class: 'badge-light-primary' },
              2: { title: 'EN TRANSITO', class: ' badge-light-success' },
              3: { title: 'ENTREGADO', class: ' badge-light-danger' },
              4: { title: 'DEVUELTO', class: ' badge-light-warning' },
              0: { title: 'ELIMINADO', class: ' badge-light-info' }
          };
          if (typeof $status[statusNumber] !== 'undefined') {
              $('#ficha-estatus').html(
                  '<span class="badge rounded-pill ' +
                  $status[statusNumber].class +
                  '">' +
                  $status[statusNumber].title +
                  '</span>'
              );
          } else {
              $('#ficha-estatus').text(statusNumber || 'N/A');
          }

          const invoiceData = {
              numero_factura: data.factura_serie || data.dato7,
              nombre_cliente: data.cliente_nombre || data.dato4,
              fecha_despacho: data.factura_fecha_despacho || data.dato2,
              direccion_cliente: data.cliente_direccion || 'Dirección no disponible',
              codigo_cliente: data.cliente_codigo || 'N/A',
              ciudad_cliente: data.cliente_ciudad || 'N/A',
              zona_cliente: data.cliente_zona || 'N/A',
              zip_cliente: data.cliente_zip || 'N/A',
              telefonos_cliente: data.cliente_telefonos || 'N/A'
          };
          
          $('#ficha-boton-generar').attr('data-invoice', JSON.stringify(invoiceData));
          $('#modalFichaFactura').data('facturaData', data);

          const modalFicha = new bootstrap.Modal(document.getElementById('modalFichaFactura'));
          modalFicha.show();
      }

      $('.datatables-basic-facturas').on('mousedown touchstart', '.invoice-number-link', function(e) {
          e.preventDefault();
          
          const $link = $(this);
          isLongPress = false;

          pressTimer = setTimeout(function() {
              isLongPress = true;
              const rowData = dt_basic.row($link.closest('tr')).data();
              if (rowData) {
                  mostrarFichaFactura(rowData);
              }
          }, 500);
      });

      $('.datatables-basic-facturas').on('mouseup touchend mouseleave', '.invoice-number-link', function(e) {
          clearTimeout(pressTimer);
          
          if (isLongPress) {
              e.stopPropagation();
          }
      });

      $('.datatables-basic-facturas').on('touchstart', '.invoice-number-link', function() {
          $(this).addClass('active');
      });
      $('.datatables-basic-facturas').on('touchend mouseleave', '.invoice-number-link', function() {
          $(this).removeClass('active');
      });

      // Evento para el botón de generar etiqueta desde el modal de detalles
      $('#ficha-boton-generar').on('click', function() {
          const invoiceData = JSON.parse($(this).attr('data-invoice'));
          facturasSeleccionadas = [invoiceData];
          clienteActual = invoiceData.nombre_cliente;
          
          bootstrap.Modal.getInstance(document.getElementById('modalFichaFactura')).hide();
          
          $('#infoFactura').text(`Factura N°: ${invoiceData.numero_factura} - Cliente: ${invoiceData.nombre_cliente}`);
          $('#numPaquetes').val(1);
          $('#modalConfigurarPaquete').modal('show');
      });

      // --- FUNCIÓN PARA GENERAR EL PDF ---
      async function generarPDFNotasEntrega(facturasSeleccionadas, numPaquetes) {
          if (typeof window.jspdf === 'undefined' || typeof window.html2canvas === 'undefined') {
              Swal.fire({
                  icon: 'error',
                  title: 'Librerías faltantes',
                  text: 'Error: Las librerías jsPDF y html2canvas son necesarias. Por favor, inclúyalas.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              return;
          }
          
          const { jsPDF } = window.jspdf;
          const doc = new jsPDF('p', 'mm', 'a4');

          const $tempContainer = $('<div id="temp-pdf-container"></div>').css({
              position: 'absolute',
              left: '-9999px',
              top: '-9999px',
              width: '210mm',
              padding: '10mm',
              boxSizing: 'border-box',
              backgroundColor: '#fff',
              fontFamily: 'sans-serif'
          });
          $('body').append($tempContainer);

          for (let i = 1; i <= numPaquetes; i++) {
              const qrCodeId = `qrcode-pdf-${i}`;
              const nombresFacturas = facturasSeleccionadas.map(f => f.numero_factura).join(', ');
              
              // Obtener datos del cliente de la primera factura seleccionada
              const cliente = facturasSeleccionadas[0];
              
              const etiquetaHTML = `
                  <div class="invoice-container">
                      <header class="invoice-header">
                          <h1>NOTA DE ENTREGA</h1>
                          <div class="company-info">
                              <strong>GRUPO SOLSUMED, C.A.</strong>
                              <p>Tel: +584245670633 | RIF: J-50096706-3</p>
                          </div>
                      </header>
                      <main class="invoice-body">
                          <div class="parties-container">
                              <div class="party-block recipient-block">
                                  <h4>Destinatario:</h4>
                                  <p><strong>${cliente.nombre_cliente}</strong></p>
                                  <p>Código: ${cliente.codigo_cliente}</p>
                                  <p>${cliente.direccion_cliente}</p>
                                  <p>${cliente.ciudad_cliente}, ${cliente.zona_cliente}</p>
                                  <p>ZIP: ${cliente.zip_cliente}</p>
                                  <p>Tel: ${cliente.telefonos_cliente}</p>
                              </div>
                              <div class="party-block sender-block">
                                  <h4>Remitente:</h4>
                                  <p><strong>GRUPO SOLSUMED, C.A.</strong></p>
                                  <p>BARQUISIMETO, ESTADO LARA</p>
                                  <p>Tel: 0424-5670633</p>
                              </div>
                          </div>
                          <div class="details-section">
                              <div class="detail-item"><span>N° de Facturas:</span><strong>${nombresFacturas}</strong></div>
                              <div class="detail-item"><span>Fecha de Despacho:</span><strong>${cliente.fecha_despacho}</strong></div>
                              <div class="detail-item"><span>Cantidad de Paquetes:</span><strong>${i} / ${numPaquetes}</strong></div>
                          </div>
                          <div class="qr-section">
                              <div id="${qrCodeId}" class="qr-code-placeholder"></div>
                              <p class="qr-caption">Código de Seguimiento</p>
                          </div>
                      </main>
                      <footer class="invoice-footer">
                          <p>FRAGIL  | TRANSPORTE INTERNO </p>
                      </footer>
                  </div>
              `;

              $tempContainer.html(etiquetaHTML);

              const facturasQR = facturasSeleccionadas.map(f => f.numero_factura).join('-');
              new QRCode(document.getElementById(qrCodeId), {
                  text: `${facturasQR}-${i}`,
                  width: 120,
                  height: 120,
                  colorDark: "#000000",
                  colorLight: "#ffffff",
                  correctLevel: QRCode.CorrectLevel.H
              });

              await new Promise(resolve => setTimeout(resolve, 500)); 

              const canvas = await html2canvas($tempContainer[0], {
                  scale: 2,
                  useCORS: true,
                  logging: false
              });

              const imgData = canvas.toDataURL('image/png');
              const imgWidth = 190;
              const pageHeight = 297;
              const imgHeight = (canvas.height * imgWidth) / canvas.width;
              let heightLeft = imgHeight;

              let position = 10;

              doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
              heightLeft -= pageHeight;

              while (heightLeft >= 0) {
                  position = heightLeft - imgHeight;
                  doc.addPage();
                  doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                  heightLeft -= pageHeight;
              }
              
              if (i < numPaquetes) {
                  doc.addPage();
              }
          }

          $tempContainer.remove();

          const fileName = `Notas_Entrega_Facturas_${facturasSeleccionadas.map(f => f.numero_factura).join('-')}.pdf`;
          doc.save(fileName);
      }

function imprimirDirectamente(facturasSeleccionadas, numPaquetes) {
  if (typeof QRCode === 'undefined') {
      Swal.fire({
          icon: 'error',
          title: 'Librería faltante',
          text: 'Error: La librería QRCode.js es necesaria.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Entendido'
      });
      return;
  }
  
  // Verificar si la librería JsBarcode está disponible
  if (typeof JsBarcode === 'undefined') {
      Swal.fire({
          icon: 'error',
          title: 'Librería faltante',
          text: 'Error: La librería JsBarcode.js es necesaria para generar códigos de barras.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Entendido'
      });
      return;
  }

  // MODIFICACIÓN: Usar el loteIdGlobal si existe, de lo contrario generar uno nuevo
  const loteId = loteIdGlobal || ('LOT-' + Date.now() + '-' + Math.floor(Math.random() * 10000).toString().padStart(4, '0'));
  
  const iframe = document.createElement('iframe');
  iframe.style.position = 'absolute';
  iframe.style.left = '-9999px';
  iframe.style.top = '-9999px';
  iframe.id = 'iframe-impresion';
  document.body.appendChild(iframe);

  const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

  let allLabelsHTML = '';
  for (let i = 1; i <= numPaquetes; i++) {
      const qrCodeId = `qrcode-print-${i}`;
      const barcodeId = `barcode-print-${i}`;
      const pageBreakClass = (i < numPaquetes) ? 'page-break' : '';
      const nombresFacturas = facturasSeleccionadas.map(f => f.numero_factura).join(', ');
      
      // Obtener datos del cliente de la primera factura seleccionada
      const cliente = facturasSeleccionadas[0];
      
      // HTML de la etiqueta con el QR incrustado en el remitente
      allLabelsHTML += `
          <div class="label-container ${pageBreakClass}">
              <header class="label-header">
                  <div class="company-info">
                      <strong>GRUPO SOLSUMED, C.A.</strong>
                      <p>Tel: 0424-5670633 / 0424-5885591 / 0251-2732866</p>
                      <p>RIF: J-50096706-3</p>
                  </div>
              </header>
              
              <main class="label-body">
                  <div class="content-grid">
                      <section class="destination-block">
                          <h2>DESTINO:</h2>
                          <p class="recipient-name">${cliente.nombre_cliente}</p>
                          <p class="recipient-code">Código: ${cliente.codigo_cliente}</p>
                          <p class="recipient-address">${cliente.direccion_cliente}</p>
                          <p class="recipient-location">${cliente.ciudad_cliente}, ${cliente.zona_cliente}</p>
                          <p class="recipient-zip">ZIP: ${cliente.zip_cliente}</p>
                          <p class="recipient-phone"><i class="fas fa-phone"></i> ${cliente.telefonos_cliente}</p>
                      </section>
                      
                      <!-- Sección de remitente con el QR incrustado -->
                      <section class="sender-block">
                          <h2>REMITENTE:</h2>
                          <p><strong>GRUPO SOLSUMED, C.A.</strong></p>
                          <p>BARQUISIMETO, ESTADO LARA</p>
                          <p>Tel: 0424-5670633</p>
                          <!-- QR Code incrustado aquí -->
                          <div class="qr-section">
                              <div id="${qrCodeId}" class="qr-code-placeholder"></div>
                          </div>
                      </section>
                  </div>
                  
                  <div class="details-block">
                      <div><span>FACTURA(S):</span> <strong>${nombresFacturas}</strong></div>
                      <div><span>FECHA:</span> <strong>${cliente.fecha_despacho}</strong></div>
                      <div><span>BULTO:</span> <strong>${i} / ${numPaquetes}</strong></div>
                     
                      <div><span>LOTE ID:</span> <strong>${loteId}</strong></div>
                  </div>
                  
                  <!-- Código de barras se mantiene en la parte inferior centrada -->
                  <div class="barcode-section">
                      <svg id="${barcodeId}" class="barcode-placeholder"></svg>
                     
                  </div>
              </main>
              
              <footer class="label-footer">
                  <p>Manéjese con cuidado.</p> <strong>FRÁGIL</strong>
              </footer>
          </div>
      `;
  }

  // CSS ajustado para la nueva ubicación del QR
  const printStyles = `
      <style>
          @page {
              size: 100mm 150mm;
              margin: 5mm;
          }
          body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
              background-color: #fff;
          }
          .label-container {
              width: 90mm;
              height: 140mm;
              padding: 5mm;
              display: flex;
              flex-direction: column;
              font-size: 10px;
              box-sizing: border-box;
          }
          .page-break {
              page-break-after: always;
          }

          .label-header {
              text-align: center;
              border-bottom: 2px solid #000;
              padding-bottom: 3mm;
              margin-bottom: 3mm;
          }
          .company-info strong {
              font-size: 12px;
          }
          .company-info p {
              margin: 1px 0;
              font-size: 8px;
          }

          .label-body {
              flex-grow: 1;
              display: flex;
              flex-direction: column;
          }
          .content-grid {
              display: flex;
              gap: 3mm;
              margin-bottom: 3mm;
          }
          .destination-block, .sender-block {
              flex: 1;
              border: 1px solid #555;
              padding: 2mm;
              display: flex;
              flex-direction: column;
          }
          .destination-block h2, .sender-block h2 {
              margin: 0 0 2mm 0;
              font-size: 10px;
              text-align: center;
              background-color: #f0f0f0;
              padding: 1mm;
              border-bottom: 1px solid #555;
              flex-shrink: 0; /* Evita que el encabezado se encoja */
          }
          .recipient-name {
              font-weight: bold;
              font-size: 11px;
              margin: 0 0 1mm 0;
              text-align: center;
          }
          .recipient-code {
              font-size: 9px;
              margin: 0 0 1mm 0;
              text-align: center;
              font-style: italic;
          }
          .recipient-address, .recipient-location, .recipient-zip, .recipient-phone, .sender-block p {
              font-size: 9px;
              margin: 0 0 1mm 0;
              text-align: center;
          }
          
          /* Estilos para el QR dentro del bloque remitente */
          .qr-section {
              text-align: center;
              margin-top: auto; /* Empuja el QR hacia la parte inferior del bloque remitente */
              padding-top: 2mm; /* Crea la separación solicitada */
          }
          .qr-code-placeholder {
              display: inline-block;
              border: 1px dashed #ccc;
          }
          
          .details-block {
              margin-bottom: 3mm;
              font-size: 10px;
              border: 1px solid #ccc;
              padding: 2mm;
          }
          .details-block div {
              display: flex;
              justify-content: space-between;
              margin-bottom: 1mm;
          }
          .details-block div:last-child {
              margin-bottom: 0;
          }
          .details-block span {
              font-weight: bold;
          }

          /* Estilos para el código de barras en la parte inferior centrada */
          .barcode-section {
              text-align: center;
              margin-top: auto;
              margin-bottom: 2mm;
          }
          .barcode-placeholder {
              display: inline-block;
          }
          
          .code-label {
              font-size: 8px;
              margin-top: 1mm;
              margin-bottom: 0;
          }

          .label-footer {
              text-align: center;
              font-size: 8px;
              color: #666;
              border-top: 1px solid #ccc;
              padding-top: 2mm;
          }
      </style>
  `;

  iframeDoc.open();
  iframeDoc.write(`
      <!DOCTYPE html>
      <html>
          <head>
              <title>Imprimir Etiquetas</title>
              ${printStyles}
          </head>
          <body>
              ${allLabelsHTML}
          </body>
      </html>
  `);
  iframeDoc.close();

  setTimeout(() => {
      for (let i = 1; i <= numPaquetes; i++) {
          const qrCodeId = `qrcode-print-${i}`;
          const barcodeId = `barcode-print-${i}`;
          const qrElement = iframeDoc.getElementById(qrCodeId);
          const barcodeElement = iframeDoc.getElementById(barcodeId);
          
          if (qrElement) {
              const facturasQR = facturasSeleccionadas.map(f => f.numero_factura).join('-');
              new QRCode(qrElement, {
                  text: `${facturasQR}-${i}`,
                  width: 80,
                  height: 80,
                  colorDark: "#000000",
                  colorLight: "#ffffff",
                  correctLevel: QRCode.CorrectLevel.H
              });
          }
          
          if (barcodeElement) {
              // Generar código de barras con el ID del lote, más pequeño
              JsBarcode(barcodeElement, loteId, {
                  format: "CODE128",
                  width: 1.2,
                  height: 25,
                  displayValue: true,
                  fontSize: 8,
                  margin: 2
              });
          }
      }

      // Preparar datos para enviar por AJAX
      const paquetes = [];
      
      for (let i = 1; i <= numPaquetes; i++) {
          const cliente = facturasSeleccionadas[0];
          
          const paquete = {
              numero_paquete: i,
              total_paquetes: numPaquetes,
              facturas: facturasSeleccionadas.map(f => f.numero_factura),
              nombre_cliente: cliente.nombre_cliente,
              codigo_cliente: cliente.codigo_cliente,
              direccion_cliente: cliente.direccion_cliente,
              ciudad_cliente: cliente.ciudad_cliente,
              zona_cliente: cliente.zona_cliente,
              zip_cliente: cliente.zip_cliente,
              telefonos_cliente: cliente.telefonos_cliente,
              fecha_despacho: cliente.fecha_despacho,
              qr_data: facturasSeleccionadas.map(f => f.numero_factura).join('-') + '-' + i,
              lote_id: loteId
          };
          
          paquetes.push(paquete);
      }
      
      const etiquetasData = {
          paquetes: paquetes,
          total_paquetes: numPaquetes,
          total_facturas: facturasSeleccionadas.length,
          
          lote_id: loteId,
          fecha_impresion: new Date().toISOString(),
          usuario: $('#usuario_actual').val() || 'Sistema'
      };

      // Enviar datos por AJAX antes de imprimir
      $.ajax({
         url: '../admin/index.php?action=empaquetado&tipo=1&accion=2&datos=2', 
          type: 'POST',
          data: {
              etiquetas: JSON.stringify(etiquetasData)
          },
          dataType: 'json',
          success: function(response) {
              if (response.success) {
                  console.log('Etiquetas guardadas correctamente:', response.message);
                  
                  // CAMBIO 4: Añadimos un listener para el evento 'afterprint' del iframe.
                  // Este evento se dispara después de que el cuadro de diálogo de impresión se cierra.
                  iframe.contentWindow.addEventListener('afterprint', function() {
                      // Mostramos el mensaje de éxito con los datos del servidor
                      Swal.fire({
                          icon: 'success',
                          title: '¡Proceso Completado!',
                          html: `
                              <p>${response.message}</p>
                              <p><strong>ID de Empaquetado:</strong> ${response.id_empaquetado}</p>
                              <p><strong>Total Paquetes:</strong> ${response.total_paquetes}</p>
                              <p><strong>Total Facturas:</strong> ${response.total_facturas}</p>
                          `,
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'Aceptar'
                      }).then((result) => {
                          // Una vez que el usuario cierra el Swal, recargamos la página completa
                          if (result.isConfirmed) {
                             // Redirigir a la página de reporte de pagos
                      window.location.href = 'index.php?view=empaquetado';
                          }
                      });
                      
                      // Limpiamos el iframe después de usarlo
                      document.body.removeChild(iframe);
                  });

                  // Iniciamos la impresión
                  iframe.contentWindow.print();

              } else {
                  console.error('Error al guardar etiquetas:', response.message);
                  Swal.fire({
                      icon: 'warning',
                      title: 'Advertencia',
                      text: 'Las etiquetas se imprimirán, pero hubo un error al guardar los datos. Por favor, contacte al administrador.',
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Entendido'
                  });
                  
                  // Imprimir de todas formas
                  iframe.contentWindow.print();
                  // Limpiamos el iframe
                  setTimeout(() => {
                      document.body.removeChild(iframe);
                  }, 1000);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error en la llamada AJAX:', error);
              Swal.fire({
                  icon: 'warning',
                  title: 'Advertencia',
                  text: 'Las etiquetas se imprimirán, pero no se pudieron guardar los datos. Por favor, contacte al administrador.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Entendido'
              });
              
              // Imprimir de todas formas
              iframe.contentWindow.print();
              // Limpiamos el iframe
              setTimeout(() => {
                  document.body.removeChild(iframe);
              }, 1000);
          }
      });
  }, 500);
}
  }
}


function cargarTablaEmbarques() {
  var datatables_basic_embarques = $('.datatables-basic-embarques');
  var currentEmbarqueId = ''; // Variable para almacenar el ID del embarque actual

  if (datatables_basic_embarques.length) {
    datatables_basic_embarques.DataTable().destroy();
    let dataEmbarques = $('.dataEmbarques').val();
    let arrayEmbarques = "";
    arrayEmbarques = JSON.parse(dataEmbarques);
    
    var dt_basic = datatables_basic_embarques.DataTable({
      data: arrayEmbarques,
      columns: [
        { 
          data: null,
          render: function (data, type, row, meta) {
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        { data: 'responsive_id' }, 
        { data: 'carga_id' }, 
        { data: 'vehiculo_nombre' }, 
        { data: 'chofer_nombre' }, 
        { data: 'ayudante_nombre' }, 
        { data: 'zona_nombre' },  
        { data: 'total_paquetes' },  
        { data: 'fecha_carga' },
        { data: 'estatus' },
        { data: '' } 
      ],
      columnDefs: [
        {
          title: '#',
          width: '30px',
          orderable: false,
          targets: 0
        },
        {
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 1
        },
        {
          title: 'ID',
          width: '10px',
          targets: 2,
          visible: true
        },
        {
          title: 'Vehículo',
          width: '15%',
          targets: 3,
          visible: true
        },
        {
          title: 'Chofer',
          width: '15%',
          targets: 4,
          visible: true
        },
        {
          title: 'Ayudante',
          width: '15%',
          targets: 5,
          visible: true
        },
        {
          title: 'Zona',
          width: '15%',
          targets: 6,
          visible: true
        },
        {
          title: 'Total Paquetes',
          width: '10%',
          targets: 7,
          visible: true
        },
        {
          title: 'Fecha de Carga',
          width: '15%',
          targets: 8,
          visible: true,
          render: function(data, type, full, meta) {
            // Formatear la fecha
            if (data) {
              var date = new Date(data);
              return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
            }
            return '';
          }
        },
        {
          title: 'Estatus',
          width: '10%',
          targets: 9,
          visible: true,
          render: function (data, type, full, meta) {
            var $status_number = full['estatus'];
            var $status = {
              1: { title: 'PREPARADO', class: 'badge-light-primary' },
              2: { title: 'EN RUTA', class: 'badge-light-success' },
              3: { title: 'ENTREGADO', class: 'badge-light-danger' },
              4: { title: 'DEVUELTO', class: 'badge-light-warning' },
              0: { title: 'CANCELADO', class: 'badge-light-info' }
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
          targets: 3
        },
        {   // Actions
          targets: -1,
          title: 'Acciones',
          width: '20%',
          orderable: false,
          render: function(data, type, full, meta) {
            var embarqueId = full['carga_id'];
            var estatus = full['estatus'];
            
            // Determinar si los botones deben estar habilitados
            var isEnabled = (estatus === '1'); // Solo habilitado cuando estatus es 1 (Preparado)
            
            // Clases para botones habilitados vs deshabilitados
            var detallesClass = 'btn btn-sm btn-primary me-1';
            var lotesClass = 'btn btn-sm btn-info me-1';
            var reporteClass = 'btn btn-sm btn-success me-1';
            var cancelarClass = isEnabled ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-secondary disabled';
            
            // Tooltips para explicar por qué están deshabilitados
            var tooltipText = !isEnabled ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="Solo disponible para embarques preparados"' : '';
            
            return (
              '<div class="d-inline-flex">' +
                '<button class="' + detallesClass + ' detalles" data-embarque-id="' + embarqueId + '">' +
                  feather.icons['eye'].toSvg({ class: 'font-small-4' }) +
                '</button>' +
               
              
                '<button ' + tooltipText + ' class="' + cancelarClass + ' cancelar" data-embarque-id="' + embarqueId + '">' +
                  feather.icons['x-circle'].toSvg({ class: 'font-small-4' }) +
                '</button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[8, 'desc']], // Ordenar por fecha de carga
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
              exportOptions: { columns: [2, 3, 4, 5, 6, 7, 8, 9] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'portrait',
              exportOptions: { columns: [2, 3, 4, 5, 6, 7, 8, 9] }
            }
          ],
          init: function(api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function() {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        },
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Nuevo Embarque',
          className: 'btn btn-relief-primary btnAgregarEmbarque',
          attr: {
            'href': 'index.php?view=embarco',
           
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function(row) {
              var data = row.data();
              return 'Detalles del Embarque #' + data.carga_id;
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

    $('div.head-label').html('<h6 class="mb-0">Embarques realizados</h6>');
  
    // Event Listeners para los botones
    $(document).on('click', '.detalles', function(e) {
      e.preventDefault();
      currentEmbarqueId = $(this).data('embarque-id');
      cargarDetallesEmbarque(currentEmbarqueId);
      $('#modalDetallesEmbarque').modal('show');
    });

    $(document).on('click', '.lotes', function(e) {
      e.preventDefault();
      currentEmbarqueId = $(this).data('embarque-id');
      cargarLotesEmbarque(currentEmbarqueId);
      $('#modalLotesEmbarque').modal('show');
    });

    $(document).on('click', '.reporte', function(e) {
      e.preventDefault();
      currentEmbarqueId = $(this).data('embarque-id');
      generarReporteEmbarque(currentEmbarqueId);
    });

    $(document).on('click', '.cancelar:not(.disabled)', function(e) {
      e.preventDefault();
      currentEmbarqueId = $(this).data('embarque-id');
      $('#cancelacionEmbarqueId').text(currentEmbarqueId);
      $('#motivoCancelacion').val(''); // Limpiar textarea
      $('#modalCancelacionEmbarque').modal('show');
    });

    // Confirmar Cancelación
    $('#confirmarCancelacion').on('click', function() {
      var motivo = $('#motivoCancelacion').val().trim();
      
      if (!motivo) {
        alert('Por favor, ingrese el motivo de la cancelación.');
        return;
      }

      realizarCancelacionEmbarque(currentEmbarqueId, motivo);
    });

    // Inicializar tooltips
    $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('show');
    }).on('mouseleave', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('hide');
    });
  }
}

// Funciones auxiliares para manejar las acciones
function cargarDetallesEmbarque(embarqueId) {
  // Implementar la lógica para cargar los detalles del embarque
  $.ajax({
    url: '../admin/index.php?action=embarque&a=detalles&id=' + embarqueId,
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data.success) {
        // Llenar el modal con los detalles del embarque
        $('#detalleVehiculo').text(data.embarque.vehiculo_nombre);
        $('#detalleChofer').text(data.embarque.chofer_nombre);
        $('#detalleAyudante').text(data.embarque.ayudante_nombre);
        $('#detalleZona').text(data.embarque.zona_nombre);
        $('#detalleTotalPaquetes').text(data.embarque.total_paquetes);
        $('#detalleFechaCarga').text(new Date(data.embarque.fecha_carga).toLocaleString());
      } else {
        alert('Error al cargar los detalles del embarque');
      }
    },
    error: function() {
      alert('Error al comunicarse con el servidor');
    }
  });
}

function cargarLotesEmbarque(embarqueId) {
  // Implementar la lógica para cargar los lotes del embarque
  $.ajax({
    url: '../admin/index.php?action=embarque&a=lotes&id=' + embarqueId,
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data.success) {
        // Limpiar tabla de lotes
        $('#tablaLotes tbody').empty();
        
        // Agregar lotes a la tabla
        data.lotes.forEach(function(lote) {
          const fila = `
            <tr>
              <td>${lote.loteID}</td>
              <td>${lote.cantidad_paquetes}</td>
              <td>${lote.facturas}</td>
              <td>${lote.cli_des}</td>
            </tr>
          `;
          $('#tablaLotes tbody').append(fila);
        });
      } else {
        alert('Error al cargar los lotes del embarque');
      }
    },
    error: function() {
      alert('Error al comunicarse con el servidor');
    }
  });
}

function generarReporteEmbarque(embarqueId) {
  // Implementar la lógica para generar el reporte del embarque
  window.open('../admin/index.php?action=embarque&a=reporte&id=' + embarqueId, '_blank');
}

function realizarCancelacionEmbarque(embarqueId, motivo) {
  // Implementar la lógica para cancelar el embarque
  $.ajax({
    url: '../admin/index.php?action=embarque&a=cancelar',
    type: 'POST',
    data: {
      id: embarqueId,
      motivo: motivo
    },
    dataType: 'json',
    success: function(data) {
      if (data.success) {
        $('#modalCancelacionEmbarque').modal('hide');
        alert('Embarque cancelado exitosamente');
        // Recargar la tabla
        location.reload();
      } else {
        alert('Error al cancelar el embarque: ' + data.message);
      }
    },
    error: function() {
      alert('Error al comunicarse con el servidor');
    }
  });
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
$('#btnBuscarFactura_seleccionada').on('click', cargarDataFacturaDespacho_seleccionada);


$('.cargarDespachos').on('click', function (e) { 
    e.preventDefault(); // Previene cualquier comportamiento por defecto del botón

    // 1. Obtener los valores de los campos del formulario
    var $co_verificador = $('.comboVerificadores').val();   
    var $finicio = $('.finicio').val(); 
    var $ffinal = $('.ffinal').val(); 

    // --- INICIO DE LAS VALIDACIONES ---

    // Validación 1: Asegurarse de que ambas fechas estén seleccionadas
    if ($finicio === '' || $ffinal === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Fechas requeridas',
            text: 'Debe seleccionar tanto la fecha de inicio como la fecha final.'
        });
        return; // Detiene la ejecución de la función
    }

    // Validación 2: Asegurarse de que la fecha de inicio sea menor que la fecha final
    // Convertimos las cadenas de texto a objetos Date para una comparación correcta
    var fechaInicioDate = new Date($finicio);
    var fechaFinalDate = new Date($ffinal);

    if (fechaInicioDate > fechaFinalDate) {
        Swal.fire({
            icon: 'error',
            title: 'Rango de fechas incorrecto',
            text: 'La fecha de inicio debe ser obligatoriamente anterior a la fecha final.'
        });
        return; // Detiene la ejecución de la función
    }

    // Validación 3: Asegurarse de que se haya seleccionado un verificador
    // Aunque tu HTML tiene una opción por defecto, esta validación es una buena práctica
    if ($co_verificador === '' || $co_verificador === null) {
        Swal.fire({
            icon: 'warning',
            title: 'Verificador requerido',
            text: 'Debe seleccionar un verificador de la lista.'
        });
        return; // Detiene la ejecución de la función
    }

    // --- FIN DE LAS VALIDACIONES ---

    // Si todas las validaciones pasan, se procede con la lógica original
    var $filtro = $finicio + '/' + $ffinal + '/' + $co_verificador ;
    
    // Aquí podrías incluir el verificador en el filtro si tu backend lo necesita, por ejemplo:
    // var $filtro = $co_verificador + '/' + $finicio + '/' + $ffinal;
    
    cargarDataDespachos($filtro);
    
    // Corrección: Se cierra el modal correcto
    $('#modalBuscarDespacho').modal('hide');
});


if ($('.comboVerificadores').length) {
  cargarComboVerificadoresData('.comboVerificadores');

}


if ($('.m_dashboard').length) {
  resaltarMenu('.i_dashboard');
}
if ($('.m_clientes').length) {
  resaltarMenu('.i_clientes');
}
if ($('.m_despachos_consulta').length) {
  resaltarMenu('.i_despachos_consulta');
}

if ($('.m_embarcos_consulta').length) {
  resaltarMenu('.i_embarcos_consulta');
}
  cargarDataDespachos('NO');
  cargarDataDespachosEmpaquetar('NO');


  cargarDataEmbarques('NO',1);

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





});



function redireccionar($direccion){
  $(location).attr('href',$direccion);
}

function cargarComboVerificadoresData(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=vendedores&tipo=1&accion=1&datos=2&c=VendedorData&t=cliente', 
}).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {
    $(combo).prepend('<option value = '+data[i].dato1+'>'+data[i].dato2+'</option>');
  
  }  
});
}
}


function cargarDataDespachos($filtro){
  
  if ($('#dataDespachos').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=despacho&tipo=1&accion=2&datos=2&c=FacturaData&t=factura&filtro='+$filtro,
}).done(function(despachos) { 
  var cadena = JSON.stringify(despachos);
  $('.dataDespachos').attr("value",cadena);
    cargarTablaFacturasDespachos();
});
  }
}


/**
 * Carga los datos de los embarques desde el servidor y los almacena
 * en un campo oculto para luego ser usados por la tabla.
 * @param {string} filtro - Parámetro de filtro para la consulta (opcional).
 */
function cargarDataEmbarques(filtro) {
  
  // Verificamos que el campo oculto donde guardaremos los datos exista
  if ($('#dataEmbarques').length) {
   
    $.ajax({
      type: "GET",
      // CAMBIO 1: URL actualizada para obtener los datos de la tabla de cargas/embarques
      // Usamos los parámetros que apuntan a la clase VehiculoData y su método getAllCargas()
      url: '../admin/index.php?action=embarco&tipo=1&accion=2&datos=2&c=VehiculoData&a=1&t=carga&filtro=' + filtro,
      dataType: 'json', // Es buena práctica especificar el tipo de dato esperado
    }).done(function(embarques) { 
      // Convertimos el array de objetos PHP a una cadena JSON para el campo oculto
      var cadena = JSON.stringify(embarques);
      
      // CAMBIO 2: Guardamos los datos en el campo oculto correcto para embarques
      $('.dataEmbarques').attr("value", cadena);
      
      // CAMBIO 3: Llamamos a la función que inicializa la tabla de embarques
      cargarTablaEmbarques();
    }).fail(function(jqXHR, textStatus, errorThrown) {
      // Manejo de errores en caso de que la petición AJAX falle
      console.error("Error al cargar los datos de embarques:", textStatus, errorThrown);
      // Opcional: Mostrar una notificación al usuario
      Swal.fire({
        icon: 'error',
        title: 'Error de Carga',
        text: 'No se pudieron cargar los datos de los embarques. Por favor, intente de nuevo.',
      });
    });
  }
}



function cargarDataDespachosEmpaquetar($filtro){
  
  if ($('#dataDespachosEmpaquetar').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=despacho&tipo=1&accion=2&datos=2&c=FacturaData&t=factura&filtro='+$filtro,
}).done(function(despachos) { 
  var cadena = JSON.stringify(despachos);
  $('.dataDespachosEmpaquetar').attr("value",cadena);
    cargarTablaFacturasEmpaquetado();
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


function cargarDataFacturaDespacho_seleccionada(){
   let $fact_nun =0;

  
      $.ajax({
        url: '../admin/index.php?action=facturacion&c=FacturaData&tipo=1&accion=3&datos=1', 
         type: "GET",
  
        success:function(data){
                var data = JSON.stringify(data);
                $('.dataFacturasDespacho').attr("value",data);
                cargarTablaFacturasDespacho();                                           
             $("#modalBuscarFactura_seleccionada").modal("show");

           
        }
    });  
}   
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


//0416 445 73 79