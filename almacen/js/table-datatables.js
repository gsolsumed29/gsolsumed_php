
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
             confirmButtonColor: '#1750a7',
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
  var currentFactNum = '';

  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataDespachos = $('.dataDespachos').val();
    let arrayDespachos = JSON.parse(dataDespachos);

    var dt_basic = datatables_basic_facturas.DataTable({
      data: arrayDespachos,
      // CAMBIO 1: Se elimina la última columna del botón de acordeón.
      // Ahora hay 8 columnas en total.
      columns: [
        { 
          data: null,
          render: function (data, type, row, meta) {
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        { data: 'dato7' }, 
        { data: 'dato4' }, 
        { data: 'dato2' }, 
        { data: 'dato3' }, 
        { data: 'dato6' },  
        { data: 'dato5' }
      ],
      columnDefs: [
        {
          title: '#',
          width: '30px',
          orderable: false,
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
          title: 'Verificado por',
          width: '20%',
          targets: 5,
          visible: true
        },
        {
          title: 'Estatus del despacho',
          width: '10%',
          targets: 6,
          visible: false,
          render: function (data, type, full, meta) {
            var $status_number = full['dato5'];
            var $status = {
              1: { title: 'VERIFICADO', class: 'badge-light-primary' },
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
        }
     
        // CAMBIO 3: Se elimina por completo el 'columnDef' del botón de acordeón.
      ],
      order: [[3, 'desc']], // El índice de la columna de fecha sigue siendo 3
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
              exportOptions: { columns: [2, 3, 4, 5] } // Índices ajustados
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'portrait',
              exportOptions: { columns: [2, 3, 4, 5] } // Índices ajustados
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
          className: 'btn btn-relief-success',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalBuscarDespacho'
          },
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
      // CAMBIO 4: Añadimos un cursor de puntero a las filas para indicar que son clicables.
      createdRow: function(row, data, dataIndex) {
        $(row).css('cursor', 'pointer');
        $('[data-bs-toggle="tooltip"]', row).tooltip();
      }
    });

    $('div.head-label').html('<h6 class="mb-0">Despachos realizados</h6>');

    // Event Listeners para los botones (sin cambios)
    $(document).on('click', '.devolver:not(.disabled)', function(e) {
      e.preventDefault();
      currentFactNum = $(this).data('fact-num');
      $('#devolucionFactNum').text(currentFactNum);
      $('#motivoDevolucion').val('');
      $('#modalDevolucion').modal('show');
    });

    $(document).on('click', '.eliminar:not(.disabled)', function(e) {
      e.preventDefault();
      currentFactNum = $(this).data('fact-num');
      $('#eliminacionFactNum').text(currentFactNum);
      $('#motivoEliminacion').val('');
      $('#modalEliminacion').modal('show');
    });

    // CAMBIO 5: Nuevo event listener para el clic en la fila.
    dt_basic.on('click', 'tbody tr', function(e) {
      // Si el clic fue en un botón (o dentro de uno), no hacemos nada.
      if ($(e.target).closest('button').length) {
        return;
      }

      const row = $(this); // Fila de DataTables que fue clickeada
      const data = dt_basic.row(this).data(); // Obtenemos los datos de la fila
      const factNum = data.dato1;
      
      // Verificar si ya hay detalles mostrados
      const existingDetails = row.next('.details-row');
      if (existingDetails.length > 0) {
        // Si ya existen detalles, solo los ocultamos/mostramos
        existingDetails.toggle();
        return;
      }
      
      $.ajax({
        url: '../admin/index.php?action=entrega&tipo=1&accion=2&datos=4&c=VehiculoData&t=factura&fact_num=' + factNum, 
        method: 'GET',
        data: { fact_num: factNum },
        success: function(response) {
            console.log(response);
        
            // Verificar si la respuesta es válida y tiene datos
            if (!response || response.length === 0 || !response[0].renglones || response[0].renglones.length === 0) {
                const detailsRow = $('<tr>').addClass('details-row bg-light');
                const detailsCell = $('<td>').attr('colspan', row.find('td').length);
                detailsCell.html('<div class="p-3 text-center">No se encontraron detalles de productos para esta factura.</div>');
                detailsRow.append(detailsCell);
                row.after(detailsRow);
                return;
            }
    
            // Obtener datos importantes del primer objeto
            const info = response[0];
            const coLote = info.co_lote || 'Sin asignar';
            const fechaDespacho = info.fecha_despacho || 'Sin fecha registrada';
            const fechaImpresion = info.fecha_impresion_etiqueta || 'Sin etiqueta impresa';
    
            const detailsRow = $('<tr>').addClass('details-row');
            const detailsCell = $('<td>').attr('colspan', row.find('td').length).addClass('p-0');
            
            let detailsContent = `
                <div class="p-3">
                    <!-- Información del lote y fechas -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                                        </div>
                                        <div class="col mr-3">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Lote</div>
                                            <div class="h6 mb-0 text-gray-600">${coLote}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                        </div>
                                        <div class="col mr-3">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Fecha Despacho</div>
                                            <div class="h6 mb-0 text-gray-600">${fechaDespacho}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-print fa-2x text-gray-300"></i>
                                        </div>
                                        <div class="col mr-3">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Etiqueta Impresa</div>
                                            <div class="h6 mb-0 text-gray-600">${fechaImpresion}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Tabla de productos -->
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered">
                            <thead class="table-light"><tr><th>Producto</th><th class="text-center">Cantidad</th></tr></thead>
                            <tbody>
            `;
            
            // Acceder al primer objeto del array y luego a renglones
            response[0].renglones.forEach(function(producto) {
                let nombre = producto.dato1 || 'N/A';
                let cantidad = parseFloat(producto.dato2) || 0;
                
                // Solo agregar filas con datos válidos
                if (nombre !== 'N/A' && cantidad > 0) {
                    detailsContent += `<tr><td>${nombre}</td><td class="text-center">${cantidad}</td></tr>`;
                }
            });
            
            detailsContent += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            
            detailsCell.html(detailsContent);
            detailsRow.append(detailsCell);
            
            row.after(detailsRow);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los detalles:', error);
            const detailsRow = $('<tr>').addClass('details-row bg-light');
            const detailsCell = $('<td>').attr('colspan', row.find('td').length);
            detailsCell.html('<div class="p-3 text-center text-danger">Error al cargar los detalles. Intente de nuevo.</div>');
            detailsRow.append(detailsCell);
            row.after(detailsRow);
        }
    });
    });

    // Confirmar Devolución (sin cambios)
    $('#confirmarDevolucion').on('click', function() {
      var motivo = $('#motivoDevolucion').val().trim();
      if (!motivo) {
        alert('Por favor, ingrese el motivo de la devolución.');
        return;
      }
      realizarDevolucion(currentFactNum, motivo);
    });

    // Confirmar Eliminación (sin cambios)
    $('#confirmarEliminacion').on('click', function() {
      var motivo = $('#motivoEliminacion').val().trim();
      if (!motivo) {
        alert('Por favor, ingrese el motivo de la eliminación.');
        return;
      }
      realizarEliminacion(currentFactNum, motivo);
    });

    // Inicializar tooltips (sin cambios)
    $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('show');
    }).on('mouseleave', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('hide');
    });
  }
}

// Funciones auxiliares para las acciones
function realizarDevolucion(factura, motivo) {
  // Lógica para realizar la devolución
  console.log(`Devolviendo factura ${factura}: ${motivo}`);
  // Aquí iría tu llamada AJAX para procesar la devolución
}

function realizarEliminacion(factura, motivo) {
  // Lógica para realizar la eliminación
  console.log(`Eliminando factura ${factura}: ${motivo}`);
  // Aquí iría tu llamada AJAX para procesar la eliminación
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
  
  // Variable global para la URL base del QR
  const QR_BASE_URL = 'https://app.grupo-solsumed.com/index.php?view=chofer&lot=';

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
      

      // Imprime los datos en consola para depuración
    //  console.log('Datos de despachos:', arrayDespachos);

      var dt_basic = datatables_basic_facturas.DataTable({
          data: arrayDespachos,
          // --- INICIO: MODIFICACIÓN DEL ARRAY `columns` ---
          // 1. Se eliminó la columna "Estado Impresión" de aquí (su posición original).
          // 2. Se añadió al final, después de "Fecha de chequeo".
          columns: [
           // Reemplaza la definición de la columna del checkbox con esta versión:
          { // Columna de checkbox
              title: 'Seleccionar',
              data: null,
              orderable: false,
              className: 'text-center',
              render: function (data, type, row, meta) {
                  // Guardar los datos en un objeto global usando el índice de la fila
                  if (!window.facturasData) {
                      window.facturasData = {};
                  }
                  
                  window.facturasData[meta.row] = {
                      numero_factura: row['factura_serie'] || row['dato7'],
                      nombre_cliente: row['cliente_nombre'] || row['dato4'],
                      fecha_despacho: row['factura_fecha_despacho'] || row['dato2'],
                      direccion_cliente: row['cliente_direccion'] || 'Dirección no disponible',
                      codigo_cliente: row['cliente_codigo'] || 'N/A',
                      ciudad_cliente: row['cliente_ciudad'] || 'N/A',
                      zip_cliente: row['cliente_zip'] || 'N/A',
                      telefonos_cliente: row['cliente_telefonos'] || 'N/A',
                      zona_cliente: row['cliente_zona'] || 'N/A',
                      transporte: row['despacho_transporte'] || 'N/A',
                      co_ven : row['co_ven'] || 'N/A',
                      telefono_vendedor : row['telefono_vendedor'] || '0424-5670633',
                  };
                  
                  // Solo guardamos el índice en el atributo data
                  return '<input type="checkbox" class="form-check-input select-invoice" data-index="' + meta.row + '">';
              }
          },
              { // Columna # (Contador)
                  title: '#',
                  data: null,
                  visible: false,
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
                               ${telefonos}
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
              // --- INICIO: NUEVA COLUMNA MOVIDA AQUÍ ---
              {
                  title: 'Estado Impresión',
                  data: null, // Usamos null y render para mayor robustez
                  className: 'text-center',
                  visible: false,
                  orderable: true, // <-- CAMBIO 1: Ahora es ordenable
                  render: function(data, type, row, meta) {
                      if (row.hasOwnProperty('EstadoRegistro')) {
                          const estado = row.EstadoRegistro;
                          if (estado == 1) {
                              return '<span class="badge bg-success">Impreso</span>';
                          } else if (estado == 0) {
                              return '<span class="badge bg-warning">No Impreso</span>';
                          }
                      }
                      return '<span class="badge bg-secondary">Desconocido</span>';
                  }
              },
              // --- FIN: NUEVA COLUMNA ---
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
          // --- INICIO: MODIFICACIÓN DE `columnDefs` ---
          // Todos los índices se decrementaron en 1 porque quitamos una columna del principio.
          columnDefs: [
              {
                  className: 'control',
                  orderable: false,
                  responsivePriority: 2,
                  targets: 2 // Antes era 3
              },
              {
                  width: '10px',
                  targets: 3, // Antes era 4
                  visible: true,
                  responsivePriority: 1
              },
              {
                  width: '20%',
                  targets: 4, // Antes era 5
                  visible: true
              },
              {
                  width: '30%',
                  targets: 5, // Antes era 6
                  visible: true
              },
              {
                  width: '15%',
                  targets: 6, // Antes era 7
                  visible: true
              },
              {
                  width: '10%',
                  targets: 7, // Antes era 8
                  visible: true
              },
              {
                  width: '20%',
                  targets: 9, // Antes era 10
                  visible: false
              },           
              {
                  width: '20%',
                  targets: 10, // Antes era 11
                  visible: false
              },           
              {
                  width: '10%',
                  targets: 11, // Antes era 12
                  visible: false
              },
              {
                  responsivePriority: 3,
                  targets: 6 // Antes era 7
              }
          ],
          // --- FIN: MODIFICACIÓN DE `columnDefs` ---
          // --- INICIO: MODIFICACIÓN DE `order` ---
          // El índice de la columna de fecha también cambió.
          order: [[7, 'desc']], // Antes era [[8, 'desc']]
          // --- FIN: MODIFICACIÓN DE `order` ---
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
                          // --- INICIO: MODIFICACIÓN DE `exportOptions` ---
                          exportOptions: { columns: [3, 4, 5, 6, 7, 8] } // Índices actualizados
                      },
                      {
                          extend: 'pdf',
                          text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                          className: 'dropdown-item',
                          orientation: 'portrait',
                          // --- INICIO: MODIFICACIÓN DE `exportOptions` ---
                          exportOptions: { columns: [3, 4, 5, 6, 7, 8] } // Índices actualizados
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
                text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Filtrar',
                className: ' btn btn-relief-success',
                
                attr: {
                  'data-bs-toggle': 'modal',
                  'data-bs-target': '#modalBuscarDespacho'
                },
                init: function (api, node, config) {
                  $(node).removeClass('btn-secondary');
                }
              },

              {
                text: feather.icons['package'].toSvg({ class: 'me-50 font-small-4' }) + 'Generar',
                className: 'btn btn-relief-primary btn-generar-etiquetas-seleccionadas',
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
              //console.log('DataTable inicializado con ' + arrayDespachos.length + ' registros');
          }
      });

      $('div.head-label').html('<h6 class="mb-0">Depachos realizados</h6>');
  
      // --- INICIO DE LOS EVENT LISTENERS ---
      // (El resto de tu código de eventos permanece igual)
      // ... (Todo el código desde aquí hasta el final de la función no necesita cambios)
      // ...
      
      // Función para formatear la fecha
      function formatearFecha(fechaString) {
          // Crear un objeto Date a partir del string
          const fecha = new Date(fechaString);
          
          // Opciones para formatear la fecha
          const opciones = {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
          };
          
          // Formatear la fecha según las opciones y el idioma español
          return fecha.toLocaleDateString('es-ES', opciones);
      }
      
      // Función para procesar la selección de factura
      function procesarSeleccionFactura(invoiceData, checkbox) {
          if (facturasSeleccionadas.length === 0) {
              clienteActual = invoiceData.nombre_cliente;
              facturasSeleccionadas.push(invoiceData);
          } else if (clienteActual === invoiceData.nombre_cliente) {
              facturasSeleccionadas.push(invoiceData);
          } else {
              checkbox.prop('checked', false);
              
              Swal.fire({
                  icon: 'warning',
                  title: 'Factura de cliente diferente',
                  text: `Ya ha seleccionado facturas de "${clienteActual}". Solo puede seleccionar facturas del mismo cliente.`,
                  confirmButtonColor: '#1750a7',
                  confirmButtonText: 'Entendido'
              });
          }
      }

     $('.datatables-basic-facturas tbody').on('change', '.select-invoice', function() {
    const checkbox = $(this);
    const index = parseInt(checkbox.attr('data-index'));
    const invoiceData = window.facturasData[index];
    const isChecked = checkbox.prop('checked');
    
    if (isChecked) {
        // Verificar si la factura ya tiene etiquetas impresas
        $.ajax({
            url: '../admin/index.php?action=embarco&c=PaqueteData&t=jm_paquetes_reg&tipo=1&accion=2&datos=3&filtro='+invoiceData.numero_factura,
            method: 'GET',
            success: function(response) {
                let cuenta = response.length;
                if (cuenta >= 1) {
                    // La factura ya tiene etiquetas impresas
                    const fechaFormateada = formatearFecha(response[0].fecha_impresion);
                    
                    // Extraer todos los códigos de lote si hay múltiples
                    let lotesInfo = '';
                    if (cuenta === 1) {
                        lotesInfo = `Lote: <strong>${response[0].lote_id || response[0].id_lote || 'N/A'}</strong>`;
                    } else {
                        const lotes = response.map(item => item.lote_id || item.id_lote || 'N/A').join(', ');
                        lotesInfo = `Lotes: <strong>${lotes}</strong>`;
                    }
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Factura con etiquetas impresas',
                        html: `
                            La factura <strong>${invoiceData.numero_factura}</strong> ya tiene etiquetas impresas.<br>
                            ${lotesInfo}<br>
                            Fecha de impresión: ${fechaFormateada}.<br><br>
                            ¿Desea volver a imprimir?
                        `,
                        showCancelButton: true,
                        confirmButtonColor: '#1750a7',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, volver a imprimir',
                        cancelButtonText: 'No, cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            procesarSeleccionFactura(invoiceData, checkbox);
                        } else {
                            checkbox.prop('checked', false);
                        }
                    });
                } else {
                    procesarSeleccionFactura(invoiceData, checkbox);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al verificar etiquetas:', error);
                Swal.fire({
                    icon: 'warning',
                    title: 'No se pudo verificar',
                    text: 'No se pudo verificar si la factura ya tiene etiquetas impresas. Puede continuar, pero verifique manualmente.',
                    confirmButtonColor: '#1750a7',
                    confirmButtonText: 'Entendido'
                });
                procesarSeleccionFactura(invoiceData, checkbox);
            }
        });
    } else {
        facturasSeleccionadas = facturasSeleccionadas.filter(factura => 
            factura.numero_factura !== invoiceData.numero_factura
        );
        
        if (facturasSeleccionadas.length === 0) {
            clienteActual = null;
        }
    }
});
      // Evento para generar etiquetas con facturas seleccionadas
      $('.btn-generar-etiquetas-seleccionadas').on('click', function() {
          if (facturasSeleccionadas.length === 0) {
              Swal.fire({
                  icon: 'info',
                  title: 'Sin facturas seleccionadas',
                  text: 'Por favor, seleccione al menos una factura para generar etiquetas.',
                  confirmButtonColor: '#1750a7',
                  confirmButtonText: 'Entendido'
              });
              return;
          }
          
          const nombresFacturas = facturasSeleccionadas.map(f => f.numero_factura).join(', ');
          $('#infoFactura').text(`${nombresFacturas}`);
          $('#infoFactura_cliente').text(`Cliente: ${clienteActual}`);
          $('#numPaquetes').val(1);
          $('#modalConfigurarPaquete').modal('show');
      });

      $('#btnGenerarPreview').on('click', function() {
        const numPaquetes = parseInt($('#numPaquetes').val());
        const despachador = $('#despachado').val();
      //  console.log('Número de paquetes solicitado:', numPaquetes);
        console.log('Despachador seleccionado:', despachador);
        if (isNaN(numPaquetes) || numPaquetes < 1 ||  despachador=='NO'  ){
            Swal.fire({
                icon: 'error',
                title: 'Número de paquetes inválido o  emisior de la etiqueta no seleccionado',
                text: 'Por favor, ingrese un número de paquetes válido y seleccione el emisior de la etiqueta.',
                confirmButtonColor: '#1750a7',
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
      // Dentro del bucle for en el evento #btnGenerarPreview
      const etiquetaHTML = `
        <div class="col-12 etiqueta-para-imprimir">
            <div class="card invoice-container border-primary h-100" style="background-color: #f5f5f5;">
                <div class="card-header bg-primary text-white py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-dark">Paquete ${i} de ${numPaquetes}</span>
                    </div>
                    <div class="company-info small mt-1 text-center">
                        <strong>&nbsp;</strong>
                        <strong class="d-block mt-1">&nbsp;</strong>
                        <p class="mb-0">&nbsp;</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <h6 class="text-primary mb-2">Destinatario:</h6>
                            <p class="mb-1"><strong>${cliente.nombre_cliente}</strong></p>
                            <p class="mb-1 small">Código: ${cliente.codigo_cliente}</p>
                            <p class="small text-muted mb-1">${cliente.direccion_cliente}</p>
                            <p class="small text-muted mb-1">${cliente.ciudad_cliente}, ${cliente.zona_cliente}</p>
                            <p class="small text-muted mb-1">ZIP: ${cliente.zip_cliente}</p>
                            <p class="mb-0 small"><i class="fas fa-phone"></i> ${cliente.telefonos_cliente}</p>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h6 class="text-primary mb-2">Remitente:</h6>
                            <p class="mb-1"><strong>GRUPO SOLSUMED, C.A.</strong></p>
                            <p class="mb-1 small text-muted">BARQUISIMETO, ESTADO LARA.</p>
                            <p class="mb-1 small text-muted">Tel: 0424-5670633</p>
                            <div class="qr-section text-center mt-2">
                                <div id="${qrCodeId}" class="qr-code-placeholder d-inline-block p-2 border border-2 border-dashed rounded"></div>
                                <p class="small text-muted mt-2 mb-0">SCAN FOR DETAILS</p>
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
                            <div class="col-12 col-md-6 mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>FECHA IMPRESIÓN:</span>
                                    <strong>${formatDate(new Date())} ${getCurrentTime()}</strong>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>LOTE ID:</span>
                                    <strong>${loteIdGlobal}</strong>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>Transporte:</span>
                                    <strong>${cliente.transporte}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Código de barras -->
                    <div class="barcode-section text-center mb-3">
                        <svg id="${barcodeId}" class="barcode-placeholder"></svg>
                    </div>
                    
                    <!-- Imagen de la empresa -->
                    <div class="text-center mt-3">
                        <img src="../app-assets/images/icons/flogo.webp" alt="Logo" style="max-width: 100%; max-height: 80px; object-fit: contain;">
                    </div>
                </div>
                <div class="card-footer bg-danger text-white py-2">
                    <p class="mb-0 text-center fw-bold">! FRÁGIL !</p>
                </div>
            </div>
        </div>
    `;
            $row.append(etiquetaHTML);
    
            // Generar el código QR y de barras después de agregar el HTML al DOM
            setTimeout(() => {
                // MODIFICACIÓN: Usar el número de lote en el QR en lugar de las facturas
                new QRCode(document.getElementById(qrCodeId), {
                    text: `${QR_BASE_URL}${loteIdGlobal}-${i}`,
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
function formatDate(date) {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

function getCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
}

      $('#btnImprimirEtiquetas').off('click').on('click', async function(e) {
          e.preventDefault();
          
          const numPaquetes = parseInt($('#numPaquetes').val());
          
          if (facturasSeleccionadas.length === 0) {
              Swal.fire({
                  icon: 'error',
                  title: 'Sin facturas seleccionadas',
                  text: 'Error: No se ha seleccionado ninguna factura. Por favor, seleccione una de la tabla.',
                  confirmButtonColor: '#1750a7',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

          if (isNaN(numPaquetes) || numPaquetes < 1) {
              Swal.fire({
                  icon: 'error',
                  title: 'Número de paquetes inválido',
                  text: 'Por favor, ingrese un número de paquetes válido en el campo correspondiente.',
                  confirmButtonColor: '#1750a7',
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
                  confirmButtonColor: '#1750a7',
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
            const despachador = $('#despachado').val(); // Obtener el valor del despachador

          
          if (facturasSeleccionadas.length === 0) {
              Swal.fire({
                  icon: 'error',
                  title: 'Sin facturas seleccionadas',
                  text: 'Error: No se ha seleccionado ninguna factura. Por favor, seleccione una de la tabla.',
                  confirmButtonColor: '#1750a7',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

         if (isNaN(numPaquetes) || numPaquetes < 1 || despachador == 'NO') {
              Swal.fire({
                  icon: 'error',
                  title: 'Número de paquetes inválido o emisor de la etiqueta no seleccionado',
                  text: 'Por favor, ingrese un número de paquetes válido y seleccione el emisor de la etiqueta.',
                  confirmButtonColor: '#1750a7',
                  confirmButtonText: 'Entendido'
              });
              return;
          }

            imprimirDirectamente(facturasSeleccionadas, numPaquetes, despachador);
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
           $('#ficha-transporte').text(data.despacho_transporte || 'N/A');
          
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
                  confirmButtonColor: '#1750a7',
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

          // Asegurarse de que loteIdGlobal esté definido
          if (!loteIdGlobal) {
              loteIdGlobal = 'LOT-' + Date.now() + '-' + Math.floor(Math.random() * 10000).toString().padStart(4, '0');
          }

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
                    <div class="detail-item"><span>N° de Lote:</span><strong>${loteIdGlobal}</strong></div>
                    <!-- Agregamos el campo de transporte -->
                    <div class="detail-item"><span>Transporte:</span><strong>${cliente.transporte}</strong></div>
                       <div class="detail-item"><span>Detalle:</span><strong>${cliente.datos_vendedor}</strong></div>
                </div>
                <div class="qr-section">
                    <div id="${qrCodeId}" class="qr-code-placeholder"></div>
                    <p class="qr-caption">Código de Seguimiento</p>
                </div>
            </main>
            <footer class="invoice-footer">
                <p>FRAGIL  </p>
            </footer>
        </div>
    `;

              $tempContainer.html(etiquetaHTML);

              // MODIFICACIÓN: Usar el número de lote en el QR en lugar de las facturas
              new QRCode(document.getElementById(qrCodeId), {
                  text: `${QR_BASE_URL}${loteIdGlobal}-${i}`,
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

          const fileName = `Notas_Entrega_Lote_${loteIdGlobal}.pdf`;
          doc.save(fileName);
      }

     // Modificar la función imprimirDirectamente
    function imprimirDirectamente(facturasSeleccionadas, numPaquetes, despachador) {
        if (typeof QRCode === 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Librería faltante',
                text: 'Error: La librería QRCode.js es necesaria.',
                confirmButtonColor: '#1750a7',
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
                confirmButtonColor: '#1750a7',
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
      
        // Funciones auxiliares para formatear fecha y obtener hora actual
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }
      
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }
      
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
                          <strong>GRUPO SOLSUMED OCCIDENTE, C.A</strong>
                          <p>Tel: 0424-5885591 / 0251-2732866</p>
                          <p>RIF: J-50784504-4</p>
                      </div>
                  </header>
                  
                  <main class="label-body">
                      <div class="content-grid">
                          <section class="destination-block">
                                <div class="barcode-section">
                                <svg id="${barcodeId}" class="barcode-placeholder"></svg>
                                  </div>
                              <p class="recipient-name">${cliente.nombre_cliente}</p>
                          
                              <p class="recipient-address">${cliente.direccion_cliente}</p>
                                 <p class="recipient-address">Ciudad / Zona</p>
                              <p class="recipient-location"> ${cliente.ciudad_cliente}, ${cliente.zona_cliente}</p>
                            
                              <p class="recipient-phone">${cliente.telefonos_cliente}</p>
                          </section>
                    
                      
                      </div>
                      
                      <div class="details-block">
                      
                          <div>REFERENCIA(S):<strong>${nombresFacturas}</strong></div>
                          <div>FECHA IMPRESIÓN: <strong>${formatDate(new Date())} / ${getCurrentTime()}</strong></div>                               
                          <div>TRANSPORTE: <strong>${cliente.transporte}</strong></div>
                          <!-- Añadir esta línea para mostrar el despachador -->
                          <div>DETALLE: <strong>${despachador} / ${cliente.co_ven } / ${cliente.telefono_vendedor } </strong></div>
      
                      </div>
                        <div class="qr-section">
                            <div class="qr-and-counter">
                                <div id="${qrCodeId}" class="qr-code-placeholder"></div>
                                <p class="recipient-name-bulto">${i} / ${numPaquetes}</p> 
                            </div>
                        </div>                 
          
                  </main>
                  
                  <footer class="label-footer">
                  <img src="../app-assets/images/icons/flogo.webp" alt="Logo" style="max-width: 100%; max-height: 40px; object-fit: contain;">
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
            }
            .label-container {
                width: 90mm;qr-section
                height: 140mm;
                padding: 0mm;
                display: flex;
                flex-direction: column;
                font-size: 10px;
                border: 1px solid #000000ff;
            }
            .page-break {
                page-break-after: always;
            }
      
            .label-header {
                text-align: center;
                border: 1px solid #000000ff;
              
            }
            .company-info strong {
                font-size: 16px;
            }
      
        
            .company-info p {
                margin: 1px 0;
                font-size: 10px;
            }
      
            .label-body {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }
            .content-grid {
                display: flex;
                gap: 3mm;
               
            }
            .destination-block, .sender-block {
                flex: 1;
                border: 1px solid #000000ff;
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
                border-bottom: 1px solid #000000ff;
                flex-shrink: 0;
            }
            .recipient-name {
                font-weight: bold;
                font-size: 18px;
                margin: 0 0 1mm 0;
                text-align: center;
            }
      
              .recipient-name-bulto {
                font-weight: bold;
                font-size: 36px;
                margin: 0 0 1mm 0;
                text-align: center;
                padding-top: 1mm;
            }
      
            
              .recipient-name-fragil {
                font-weight: bold;
                font-size: 26px;
                margin: 0 0 1mm 0;
                text-align: center;
                /* CAMBIO AÑADIDO: Espaciado entre letras para la palabra FRÁGIL */
                letter-spacing: 12px;
            }
      
          
            .recipient-code {
                font-size: 9px;
                margin: 0 0 1mm 0;
                text-align: center;
                font-style: italic;
            }
            .recipient-address, .recipient-location, .recipient-zip, .sender-block p {
                font-size: 12px;
                margin: 0 0 1mm 0;
                text-align: center;
            }

            .recipient-phone {
              font-weight: bold;   
              font-size: 14px;
            padding-top: 1mm;
                margin: 0 0 1mm 0;
                text-align: center;
            }
            /* Estilos para contenedor de QR y contador juntos */
            .qr-and-counter {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10mm; /* Aumentado el espacio entre elementos */
                margin-top: 5mm; /* Añadido margen superior para bajar la posición */
                margin-bottom: 5mm; /* Añadido margen inferior para separar de otros elementos */
            }
      
            .qr-and-counter .qr-code-placeholder {
                flex: 0 0 auto;
            }
      
            .qr-and-counter .recipient-name-bulto {
                flex: 0 0 auto;
                margin: 0;
                padding-left: 5mm; /* Añadido padding izquierdo para mayor separación */
            }
            
            .details-block {
              
                font-size: 14px;
                border: 1px solid #000000ff;
              
            }

            .qr-section{            
           
              border: 1px solid #000000ff;           
            }


       

            .details-block div {
                display: flex;
                justify-content: space-between;
               
            }
            .details-block div:last-child {
                margin-bottom: 1px;
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
                border: 1px solid #000000ff;
              
            }

            /* --- FIN: NUEVOS ESTILOS --- */
            
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
            // ... (el resto del código de la función permanece igual)
            for (let i = 1; i <= numPaquetes; i++) {
                const qrCodeId = `qrcode-print-${i}`;
                const barcodeId = `barcode-print-${i}`;
                const qrElement = iframeDoc.getElementById(qrCodeId);
                const barcodeElement = iframeDoc.getElementById(barcodeId);
                
                if (qrElement) {
                    // MODIFICACIÓN: Usar el número de lote en el QR en lugar de las facturas
                    new QRCode(qrElement, {
                        text: `${QR_BASE_URL}${loteId}-${i}`,
                        width: 100,
                        height: 100,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.L
                    });
                }
                
                if (barcodeElement) {
                    // Generar código de barras con el ID del lote, más pequeño
                    JsBarcode(barcodeElement, loteId, {
                        format: "CODE128",
                        width: 1,
                        height: 20,
                        displayValue: true,
                        fontSize: 14,
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
                    qr_data: `${QR_BASE_URL}${loteId}-${i}`,
                    lote_id: loteId,
                    // Añadir el despachador a los datos del paquete
                    preparado_por: despachador
                };
                
                paquetes.push(paquete);
            }
            
            const etiquetasData = {
                paquetes: paquetes,
                total_paquetes: numPaquetes,
                total_facturas: facturasSeleccionadas.length,
                lote_id: loteId,
                fecha_impresion: new Date().toISOString(),
                usuario: $('#usuario_actual').val() || 'Sistema',
                // Añadir el despachador a los datos generales
                despachador: despachador
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
                        // Este evento se dispara después de que el cuadro de diálogo de impresión se cierre.
                        iframe.contentWindow.addEventListener('afterprint', function() {
                            // Mostramos el mensaje de éxito con los datos del servidor
                            Swal.fire({
                                icon: 'success',
                                title: '¡Proceso Completado!',
                                html: `
                                    <p>${response.message}</p>
                                    <p><strong>ID de Empaquetado:</strong> ${response.id_empaquetado}</p>
                                    <p><strong>Total Bultos:</strong> ${response.total_paquetes}</p>
                                    <p><strong>Total Facturas:</strong> ${response.total_facturas}</p>
                                    <p><strong>Preparado por:</strong> ${despachador}</p>
                                `,
                                confirmButtonColor: '#1750a7',
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
                            confirmButtonColor: '#1750a7',
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
                        confirmButtonColor: '#1750a7',
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
  var actualizacionAutomatica; // Variable para almacenar el intervalo de actualización

  if (datatables_basic_embarques.length) {
    // Destruir la instancia anterior si existe para evitar errores de reinicialización
    if ($.fn.dataTable.isDataTable('.datatables-basic-embarques')) {
        datatables_basic_embarques.DataTable().destroy();
    }

    let dataEmbarques = $('.dataEmbarques').val();
    let arrayEmbarques = JSON.parse(dataEmbarques);
     // --- NUEVO: Función auxiliar para determinar el estatus efectivo ---


    function getEffectiveStatus(data) {
        const totalLotes = parseInt(data['lotes_totales']) || 0;
        const lotesEntregados = parseInt(data['lotes_entregados']) || 0;

        // Si todos los lotes están entregados, el estatus es 'ENTREGADO'
        if (totalLotes > 0 && lotesEntregados >= totalLotes) {
            return { title: 'ENTREGADO', class: 'badge-light-success' };
        }

        // De lo contrario, usar el estatus original de la base de datos
        var $status = {
            1: { title: 'EN TRÁNSITO', class: 'badge-light-warning' },
            2: { title: 'EN RUTA', class: 'badge-light-info' }, // Cambié a un color más neutro
            3: { title: 'ENTREGADO', class: 'badge-light-success' },
            4: { title: 'DEVUELTO', class: 'badge-light-danger' },
            0: { title: 'CANCELADO', class: 'badge-light-secondary' }
        };
        return $status[data.estatus] || { title: 'DESCONOCIDO', class: 'badge-light-dark' };
    }

    // --- MEJORA 1: Crear un Modal para Exportación en Móvil ---
    if ($('#exportModalEmbarques').length === 0) {
        $('body').append(`
            <div class="modal fade" id="exportModalEmbarques" tabindex="-1" aria-labelledby="exportModalEmbarquesLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalEmbarquesLabel">Exportar Reporte de Embarques</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <button class="btn btn-outline-primary mb-2 export-btn-embarques" data-export="print">
                                ${feather.icons['printer'].toSvg({ class: 'me-50' })} Imprimir
                            </button>
                            <button class="btn btn-outline-success mb-2 export-btn-embarques" data-export="excel">
                                ${feather.icons['file'].toSvg({ class: 'me-50' })} Excel
                            </button>
                            <button class="btn btn-outline-danger mb-2 export-btn-embarques" data-export="pdf">
                                ${feather.icons['clipboard'].toSvg({ class: 'me-50' })} PDF
                            </button>
                            <button class="btn btn-outline-secondary export-btn-embarques" data-export="copy">
                                ${feather.icons['copy'].toSvg({ class: 'me-50' })} Copiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    
    if ($('#modalFichaEmbarque').length === 0) {
        $('body').append(`
            <div class="modal fade" id="modalFichaEmbarque" tabindex="-1" aria-labelledby="modalFichaEmbarqueLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalFichaEmbarqueLabel">Detalles del Embarque</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Información General</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr><td class="fw-bold" style="width: 40%;">ID:</td><td id="ficha-embarque-id">-</td></tr>
                                        <tr><td class="fw-bold">Fecha de Carga:</td><td id="ficha-embarque-fecha">-</td></tr>
                                        <tr><td class="fw-bold">Estatus:</td><td id="ficha-embarque-estatus">-</td></tr>
                                        <!-- MODIFICACIÓN: Cambiar etiquetas de "Bultos" a "Lotes" -->
                                        <tr><td class="fw-bold">Total Lotes:</td><td id="ficha-embarque-lotes">-</td></tr>
                                        <tr><td class="fw-bold">Lotes Entregados:</td><td id="ficha-embarque-entregados">-</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Vehículo y Personal</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr><td class="fw-bold" style="width: 40%;">Vehículo:</td><td id="ficha-embarque-vehiculo">-</td></tr>
                                        <tr><td class="fw-bold">Chofer:</td><td id="ficha-embarque-chofer">-</td></tr>
                                        <tr><td class="fw-bold">Ayudante:</td><td id="ficha-embarque-ayudante">-</td></tr>
                                        <tr><td class="fw-bold">Zona:</td><td id="ficha-embarque-zona">-</td></tr>
                                    </table>
                                </div>
                            </div>
                            <!-- MEJORA: Agregar barra de progreso -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary">Progreso de Entrega</h6>
                                    <div class="progress mb-2" style="height: 20px;">
                                        <div class="progress-bar" id="ficha-embarque-progreso" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                    <!-- MODIFICACIÓN: Cambiar texto descriptivo de "bultos" a "lotes" -->
                                    <small class="text-muted" id="ficha-embarque-progreso-texto">0 de 0 lotes entregados (0%)</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="ms-auto">
                             
                             
                                <button type="button" class="btn btn-success" id="ficha-boton-whatsapp">${feather.icons['message-circle'].toSvg({ class: 'font-small-4 me-50' })} WhatsApp</button>
                                <button type="button" class="btn btn-primary me-1" id="ficha-boton-detalles">${feather.icons['eye'].toSvg({ class: 'font-small-4 me-50' })} Ver Detalles</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    
    var dt_basic = datatables_basic_embarques.DataTable({
      scrollY: 'calc(100vh - 320px)',
      scrollX: true,
      scrollCollapse: true,
      fixedHeader: {
        header: true,
        footer: false
      },
      data: arrayEmbarques,
      columns: [
        { 
          data: null,
          render: function (data, type, row, meta) {
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        { data: 'responsive_id' }, 
        {
          title: 'ID',
          data: null,
          render: function (data, type, full, meta) {
            return `<span class="embarque-id-link text-primary fw-bold" style="cursor: pointer;">${full.carga_id}</span>`;
          }
        }, 

          {
            title: 'Tipo',
            data: 'tipo_transporte', // <-- Ajusta este nombre si es necesario
            render: function(data, type, row, meta) {
                if (!data) return 'N/A';
                const tipo = data.toLowerCase();
                if (type === 'export' || type === 'sort') {
                    return tipo.charAt(0).toUpperCase() + tipo.slice(1);
                }
                if (tipo === '2') {
                    return '<span class="badge bg-primary">Interno</span>';
                } else if (tipo === 'externo') {
                    return '<span class="badge bg-info">Externo</span>';
                }
                return '<span class="badge bg-secondary">' + data + '</span>';
            },
            visible: true,
            width: '80px'
        },
        { 
          title: 'Vehículo y Personal',
          data: null,
          render: function (data, type, full, meta) {
            const vehiculo = full['vehiculo_nombre'] || 'N/A';
            const chofer = full['chofer_nombre'] || 'N/A';
            const ayudante = full['ayudante_nombre'] || 'N/A';
            const zona = full['zona_nombre'] || 'N/A';
            
            return `
              <div>
                <div class="fw-bold">${vehiculo}</div>
                <small class="text-muted">Chofer: ${chofer}</small>
                <br><small class="text-muted">Ayudante: ${ayudante}</small>
                <br><small class="text-muted">Zona: ${zona}</small>
              </div>
            `;
          },
          visible: true
        },
          { 
              title: 'Lotes, Fecha y Estatus',
              data: null,
              render: function (data, type, full, meta) {
                const totalLotes = parseInt(full['lotes_totales']) || 0;
                const lotesEntregados = parseInt(full['lotes_entregados']) || 0;
                const fechaCarga = full['fecha_carga'];
                
                // MODIFICACIÓN: Usar la nueva función para obtener el estatus correcto
                const statusInfo = getEffectiveStatus(full);
                const statusBadge = `<span class="badge rounded-pill ${statusInfo.class}">${statusInfo.title}</span>`;
                
                const porcentaje = totalLotes > 0 ? Math.round((lotesEntregados / totalLotes) * 100) : 0;
                
                let fechaFormateada = '';
                if (fechaCarga) {
                  var date = new Date(fechaCarga);
                  fechaFormateada = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                } else {
                  fechaFormateada = 'N/A';
                }
                
                return `
                  <div>
                    <div class="fw-bold">Entregados: ${lotesEntregados}/${totalLotes}</div>
                    <div class="progress mb-1" style="height: 15px;">
                        <div class="progress-bar ${porcentaje === 100 ? 'bg-success' : 'bg-primary'}" role="progressbar" style="width: ${porcentaje}%" aria-valuenow="${porcentaje}" aria-valuemin="0" aria-valuemax="100">${porcentaje}%</div>
                    </div>
                    <small class="text-muted">Fecha: ${fechaFormateada}</small>
                    <br><div class="mt-1">${statusBadge}</div>
                  </div>
                `;
              },
              visible: true
            }
      ],
       columnDefs: [
        { title: '#', width: '30px', orderable: false, targets: 0 },
        { className: 'control', orderable: false, responsivePriority: 2, targets: 1 },
        { title: 'ID', width: '10px', targets: 2, visible: true },
        // NUEVO: Definición para la nueva columna
        { title: 'Tipo', width: '80px', targets: 3, orderable: true },
        { title: 'Vehículo y Personal', width: '45%', targets: 4, visible: true, responsivePriority: 1 },
        { title: 'Lotes, Fecha y Estatus', width: '45%', targets: 5, visible: true }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle d-none d-md-inline-flex',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + ' Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              title: 'Reporte de Embarques - ' + new Date().toLocaleDateString()
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              title: 'Reporte de Embarques',
              filename: 'reporte_embarques_' + new Date().toISOString().slice(0, 10)
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'PDF',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              orientation: 'landscape',
              pageSize: 'A4',
              title: 'Reporte de Embarques - ' + new Date().toLocaleDateString(),
              filename: 'reporte_embarques_' + new Date().toISOString().slice(0, 10),
              customize: function (doc) {
                doc.defaultStyle.fontSize = 8;
                doc.styles.tableHeader.fontSize = 9;
                doc.content[0].text = 'Reporte de Embarques - ' + new Date().toLocaleDateString();
                doc.content[0].alignment = 'center';
                doc.content[0].margin = [0, 0, 0, 10];
              }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              title: 'Reporte de Embarques'
            }
          ]
        },
        
        {
          text: feather.icons['share-2'].toSvg({ class: 'font-medium-1 me-50' }) + 'Exportar',
          className: 'btn btn-primary d-md-none',
          action: function (e, dt, node, config) {
            var exportModal = new bootstrap.Modal(document.getElementById('exportModalEmbarques'));
            exportModal.show();
          }
        },  {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Buscar',
          className: 'btn btn-relief-success',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalBuscarDespacho'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      pagingType: 'simple_numbers',
      displayLength: 10,
      lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
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
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del Embarque #' + data.carga_id;
            }
          }),
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              if (col.title === '' || col.title === 'Acciones') {
                return '';
              }
              return `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                        <td class="fw-bold">${col.title}:</td>
                        <td>${col.data}</td>
                      </tr>`;
            }).join('');
            
            return data ? $('<table class="table table-striped table-bordered"/>').append($('<tbody/>').append(data)) : false;
          }
        }
      },
      createdRow: function(row, data, dataIndex) {
        $('[data-bs-toggle="tooltip"]', row).tooltip();
      }
    });

    $(dt_basic.table().container()).addClass('embarques-datatable-wrapper');
    dt_basic.buttons().container().appendTo('#export-container-embarques');
    $('div.head-label').html('<h6 class="mb-0">Embarques realizados</h6>');

    $('.export-btn-embarques').on('click', function() {
        var exportType = $(this).data('export');
        dt_basic.button(0).add(0, exportType).trigger();
        bootstrap.Modal.getInstance(document.getElementById('exportModalEmbarques')).hide();
    });

    function actualizarTablaEmbarques() {
        $('div.head-label').html('<h6 class="mb-0">Embarques realizados <i class="fas fa-spinner fa-spin"></i></h6>');
        let filtro = 'NO';
        $.ajax({
            url: '../admin/index.php?action=embarco&tipo=1&accion=2&datos=2&c=VehiculoData&a=1&t=carga&filtro=' + filtro,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let datosParaActualizar = null;
                if (response && Array.isArray(response.data)) {
                    datosParaActualizar = response.data;
                } else if (Array.isArray(response)) {
                    datosParaActualizar = response;
                } else if (response && response.carga && Array.isArray(response.carga)) {
                    datosParaActualizar = response.carga;
                }

                if (datosParaActualizar) {
                    dt_basic.clear();
                    dt_basic.rows.add(datosParaActualizar);
                    dt_basic.draw();
                    $('div.head-label').html('<h6 class="mb-0">Embarques realizados</h6>');
                    toastr.info('La tabla ha sido actualizada', 'Actualización automática');
                } else {
                    console.error("Error: La respuesta de la API no contiene un array de datos válido.", response);
                    toastr.error('El formato de los datos recibidos es incorrecto. Revisa la consola para más detalles.', 'Error de Actualización');
                    $('div.head-label').html('<h6 class="mb-0">Embarques realizados</h6>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la llamada AJAX para actualizar la tabla:", {
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                $('div.head-label').html('<h6 class="mb-0">Embarques realizados</h6>');
                toastr.error('No se pudo conectar con el servidor para actualizar la tabla.', 'Error de Conexión');
            }
        });
    }
    
    function configurarActualizacionAutomatica() {
        if (actualizacionAutomatica) {
            clearInterval(actualizacionAutomatica);
        }
        actualizacionAutomatica = setInterval(actualizarTablaEmbarques, 75000);
    }
    
    configurarActualizacionAutomatica();

    let pressTimer;
    let isLongPress = false;

    function mostrarFichaEmbarque(data) {
        let fechaFormateada = '';
        if (data.fecha_carga) {
            var date = new Date(data.fecha_carga);
            fechaFormateada = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        } else {
            fechaFormateada = 'N/A';
        }
        
        // MODIFICACIÓN: Usar la nueva función para obtener el estatus correcto
        const statusInfo = getEffectiveStatus(data);
        const statusBadge = `<span class="badge rounded-pill ${statusInfo.class}">${statusInfo.title}</span>`;
        
        const totalLotes = parseInt(data.lotes_totales) || 0;
        const lotesEntregados = parseInt(data.lotes_entregados) || 0;
        const porcentaje = totalLotes > 0 ? Math.round((lotesEntregados / totalLotes) * 100) : 0;
        
        $('#ficha-embarque-id').text(data.carga_id || 'N/A');
        $('#ficha-embarque-fecha').text(fechaFormateada);
        $('#ficha-embarque-estatus').html(statusBadge);
        $('#ficha-embarque-lotes').text(totalLotes);
        $('#ficha-embarque-entregados').text(lotesEntregados);
        $('#ficha-embarque-vehiculo').text(data.vehiculo_nombre || 'N/A');
        $('#ficha-embarque-chofer').text(data.chofer_nombre || 'N/A');
        $('#ficha-embarque-ayudante').text(data.ayudante_nombre || 'N/A');
        $('#ficha-embarque-zona').text(data.zona_nombre || 'N/A');
        
        const progressBar = $('#ficha-embarque-progreso');
        const colorClass = porcentaje === 100 ? 'bg-success' : 'bg-primary';
        
        progressBar.removeClass('bg-primary bg-success').addClass(colorClass).css('width', porcentaje + '%').attr('aria-valuenow', porcentaje).text(porcentaje + '%');
        $('#ficha-embarque-progreso-texto').text(`${lotesEntregados} de ${totalLotes} lotes entregados (${porcentaje}%)`);

        const reportUrl = `index.php?view=embarque_reportes&carga_id=${data.carga_id}`;
        $('#ficha-boton-reportes').attr('href', reportUrl);

        const embarqueId = data.carga_id;
        const estatus = data.estatus;
        const isEnabled = (estatus === '1');

        $('#ficha-boton-detalles').attr('data-embarque-id', embarqueId);
        $('#ficha-boton-cancelar').attr('data-embarque-id', embarqueId);

        if (isEnabled) {
            $('#ficha-boton-cancelar').removeClass('btn-secondary disabled').addClass('btn-danger').removeAttr('data-bs-toggle data-bs-placement title');
        } else {
            $('#ficha-boton-cancelar').removeClass('btn-danger').addClass('btn-secondary disabled').attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Solo disponible para embarques preparados');
        }
        $('#ficha-boton-cancelar').tooltip('dispose').tooltip();
        $('#modalFichaEmbarque').data('embarqueData', data);
        const modalFicha = new bootstrap.Modal(document.getElementById('modalFichaEmbarque'));
        modalFicha.show();
    }

    datatables_basic_embarques.on('mousedown touchstart', '.embarque-id-link', function(e) {
        e.preventDefault();
        const $link = $(this);
        isLongPress = false;
        pressTimer = setTimeout(function() {
            isLongPress = true;
            const rowData = dt_basic.row($link.closest('tr')).data();
            if (rowData) {
                mostrarFichaEmbarque(rowData);
            }
        }, 500);
    });

    datatables_basic_embarques.on('mouseup touchend mouseleave', '.embarque-id-link', function(e) {
        clearTimeout(pressTimer);
        if (isLongPress) {
            e.stopPropagation();
        }
    });

    datatables_basic_embarques.on('touchstart', '.embarque-id-link', function() {
        $(this).addClass('active');
    });
    datatables_basic_embarques.on('touchend mouseleave', '.embarque-id-link', function() {
        $(this).removeClass('active');
    });

    $('#ficha-boton-detalles').on('click', function() {
        const embarqueId = $(this).data('embarque-id');

        window.location.href = 'index.php?view=rembarco&id='+embarqueId;
        //console.log('Acción: Ver detalles del embarque', embarqueId);
    });

  

   // MODIFICACIÓN: Actualizar el mensaje de WhatsApp para usar la nueva lógica de estatus
    $('#ficha-boton-whatsapp').on('click', function() {
        const data = $('#modalFichaEmbarque').data('embarqueData');
        if (data) {
            let fechaFormateada = '';
            if (data.fecha_carga) {
                var date = new Date(data.fecha_carga);
                fechaFormateada = date.toLocaleDateString();
            } else {
                fechaFormateada = 'N/A';
            }
            
            // MODIFICACIÓN: Usar la nueva función para obtener el estatus correcto
            const statusInfo = getEffectiveStatus(data);
            
            const totalLotes = parseInt(data.lotes_totales) || 0;
            const lotesEntregados = parseInt(data.lotes_entregados) || 0;
            const porcentaje = totalLotes > 0 ? Math.round((lotesEntregados / totalLotes) * 100) : 0;
            
            const mensaje = `*Información del Embarque*\n\n` +
                           `*ID:* ${data.carga_id}\n` +
                           `*Tipo:* ${(data.tipo_transporte || 'N/A').charAt(0).toUpperCase() + (data.tipo_transporte || 'N/A').slice(1)}\n` + // NUEVO
                           `*Vehículo:* ${data.vehiculo_nombre}\n` +
                           `*Chofer:* ${data.chofer_nombre}\n` +
                           `*Ayudante:* ${data.ayudante_nombre}\n` +
                           `*Zona:* ${data.zona_nombre}\n` +
                           `*Total Lotes:* ${totalLotes}\n` +
                           `*Lotes Entregados:* ${lotesEntregados} (${porcentaje}%)\n` +
                           `*Fecha:* ${fechaFormateada}\n` +
                           `*Estatus:* ${statusInfo.title}`; // MODIFICACIÓN
            
            const mensajeCodificado = encodeURIComponent(mensaje);
            window.open(`https://wa.me/?text=${mensajeCodificado}`, '_blank');
        }
    });

    $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('show');
    }).on('mouseleave', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('hide');
    });
    
    $(window).on('beforeunload', function() {
        if (actualizacionAutomatica) {
            clearInterval(actualizacionAutomatica);
        }
    });
  }
}


function cargarTablaFacturasEntregas() {
  var datatables_basic_facturas = $('.datatables-basic-entregas');
  var currentFactNum = ''; // Variable para almacenar el número de factura actual

  if (datatables_basic_facturas.length) {
    // Destruir la instancia anterior si existe para evitar errores de reinicialización
    if ($.fn.dataTable.isDataTable('.datatables-basic-entregas')) {
        datatables_basic_facturas.DataTable().destroy();
    }
    
    let dataDespachos = $('.dataEntregas').val();
    let arrayDespachos = JSON.parse(dataDespachos);
    
    // --- MEJORA 1: Crear un Modal para Exportación en Móvil ---
    if ($('#exportModalFacturas').length === 0) {
        $('body').append(`
            <div class="modal fade" id="exportModalFacturas" tabindex="-1" aria-labelledby="exportModalFacturasLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalFacturasLabel">Exportar Reporte de Facturas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <button class="btn btn-outline-primary mb-2 export-btn-facturas" data-export="print">
                                ${feather.icons['printer'].toSvg({ class: 'me-50' })} Imprimir
                            </button>
                            <button class="btn btn-outline-success mb-2 export-btn-facturas" data-export="excel">
                                ${feather.icons['file'].toSvg({ class: 'me-50' })} Excel
                            </button>
                            <button class="btn btn-outline-danger mb-2 export-btn-facturas" data-export="pdf">
                                ${feather.icons['clipboard'].toSvg({ class: 'me-50' })} PDF
                            </button>
                            <button class="btn btn-outline-secondary export-btn-facturas" data-export="copy">
                                ${feather.icons['copy'].toSvg({ class: 'me-50' })} Copiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    
    // --- MEJORA 2: Crear Modal de Ficha para Detalles ---
    if ($('#modalFichaFactura').length === 0) {
        $('body').append(`
            <div class="modal fade" id="modalFichaFactura" tabindex="-1" aria-labelledby="modalFichaFacturaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalFichaFacturaLabel">Detalles del lote</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Información General</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr><td class="fw-bold" style="width: 40%;">N° Lote:</td><td id="ficha-factura-num">-</td></tr>
                                        <tr><td class="fw-bold">Código Cliente:</td><td id="ficha-factura-codigo">-</td></tr>
                                        <tr><td class="fw-bold">Razón Social:</td><td id="ficha-factura-razon">-</td></tr>
                                        <tr><td class="fw-bold">Estatus:</td><td id="ficha-factura-estatus">-</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Información Adicional</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr><td class="fw-bold" style="width: 40%;">Fecha embarque:</td><td id="ficha-factura-fecha-armado">-</td></tr>
                                        <tr><td class="fw-bold">Fecha Entrega:</td><td id="ficha-factura-fecha-entrega">-</td></tr>
                                        <tr><td class="fw-bold">Embarcado por:</td><td id="ficha-factura-persona">-</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="ms-auto">
                                <!-- Botón de Eliminar -->
                                <button type="button" class="btn btn-danger me-1" id="ficha-boton-eliminar">${feather.icons['trash'].toSvg({ class: 'font-small-4 me-50' })} Eliminar</button>
                                
                                <!-- NUEVO BOTÓN DE CONFIRMAR DESPACHO -->
                                <button type="button" class="btn btn-success me-1" id="ficha-boton-confirmar-despacho">
                                    ${feather.icons['check-circle'].toSvg({ class: 'font-small-4 me-50' })} Confirmar Despacho
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    
    var dt_basic = datatables_basic_facturas.DataTable({
      scrollY: 'calc(100vh - 320px)',
      scrollX: true,
      scrollCollapse: true,
      fixedHeader: {
        header: true,
        footer: false
      },
      data: arrayDespachos,
      columns: [
        { 
          data: null,
          render: function (data, type, row, meta) {
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        { data: 'responsive_id' }, 
        {
          title: 'N° Lote',
          data: null,
          render: function (data, type, full, meta) {
            return `<span class="factura-num-link text-primary fw-bold" style="cursor: pointer;">${full.co_lote}</span>`;
          }
        }, 
        { 
          title: 'Cliente',
          data: null,
          render: function (data, type, full, meta) {
            return `<div class="fw-bold">${full.co_cli} - ${full.cli_des}</div>`;
          }
        },
        {
          title: 'Fechas y Estatus',
          data: null,
          render: function (data, type, full, meta) {
            // Fecha de armado del lote
            let fechaArmado = full.fecha_armado || '';
            let fechaArmadoFormateada = '';
            
            if (fechaArmado) {
              var date = new Date(fechaArmado);
              fechaArmadoFormateada = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
            } else {
              fechaArmadoFormateada = 'N/A';
            }
            
            // Fecha de entrega
            let fechaEntrega = full.dato_extra1 || '';
            let entregaBadge = '';
            
            if (!fechaEntrega || fechaEntrega.trim() === '0') {
              entregaBadge = '<span class="badge rounded-pill badge-light-danger">EN TRÁNSITO</span>';
            } else {
              entregaBadge = `<span class="badge rounded-pill badge-light-success">${fechaEntrega}</span>`;
            }
            
            // Estatus
            var $status = full.estatus;
            var $status_info = {
              '': { title: 'EN TRÁNSITO', class: 'badge-light-warning' },
              '2': { title: 'ENTREGADO', class: 'badge-light-success' },
              '3': { title: 'DEVUELTO', class: 'badge-light-danger' },
              '4': { title: 'ELIMINADO', class: 'badge-light-info' }
            };
            
            var statusBadge = '';
            if (typeof $status_info[$status] !== 'undefined') {
              statusBadge = '<span class="badge rounded-pill ' + $status_info[$status].class + '">' + $status_info[$status].title + '</span>';
            }
            
            return `
              <div>
                <div class="fw-bold">EMBARCADO: ${fechaArmadoFormateada}</div>
                <div class="fw-bold">ENTREGADO: ${fechaEntrega || 'N/A'}</div>
                <div class="mt-1">${statusBadge}</div>
              </div>
            `;
          }
        },
        { 
          title: 'Transporte',
          data: 'transporte',
          render: function (data, type, full, meta) {
            return `<div>${data || 'N/A'}</div>`;
          }
        }
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
          title: 'N° Lote',
          width: '25%',
          targets: 2,
          visible: true
        },
        {
          title: 'Cliente',
          width: '30%',
          targets: 3,
          visible: true,
          responsivePriority: 1
        },
        {
          title: 'Fechas y Estatus',
          width: '25%',
          targets: 4,
          visible: true
        },
        {
          title: 'Transporte',
          width: '20%',
          targets: 5,
          visible: true
        }
      ],
      order: [[2, 'desc']], // Ordenar por N° Lote por defecto
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle d-none d-md-inline-flex',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + ' Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              title: 'Reporte de Facturas - ' + new Date().toLocaleDateString()
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              title: 'Reporte de Facturas',
              filename: 'reporte_facturas_' + new Date().toISOString().slice(0, 10)
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'PDF',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              orientation: 'landscape',
              pageSize: 'A4',
              title: 'Reporte de Facturas - ' + new Date().toLocaleDateString(),
              filename: 'reporte_facturas_' + new Date().toISOString().slice(0, 10),
              customize: function (doc) {
                doc.defaultStyle.fontSize = 8;
                doc.styles.tableHeader.fontSize = 9;
                doc.content[0].text = 'Reporte de Facturas - ' + new Date().toLocaleDateString();
                doc.content[0].alignment = 'center';
                doc.content[0].margin = [0, 0, 0, 10];
              }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:first-child)' },
              title: 'Reporte de Facturas'
            }
          ]
        },
        {
          text: feather.icons['share-2'].toSvg({ class: 'font-medium-1 me-50' }) + 'Exportar',
          className: 'btn btn-primary d-md-none',
          action: function (e, dt, node, config) {
            var exportModal = new bootstrap.Modal(document.getElementById('exportModalFacturas'));
            exportModal.show();
          }
        }
      ],
      pagingType: 'simple_numbers',
      displayLength: 10,
      lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, 100] ],
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
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de la Factura #' + data.co_lote;
            }
          }),
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              if (col.title === '' || col.title === 'Acciones') {
                return '';
              }
              return `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                        <td class="fw-bold">${col.title}:</td>
                        <td>${col.data}</td>
                      </tr>`;
            }).join('');
            
            return data ? $('<table class="table table-striped table-bordered"/>').append($('<tbody/>').append(data)) : false;
          }
        }
      },
      createdRow: function(row, data, dataIndex) {
        $('[data-bs-toggle="tooltip"]', row).tooltip();
      }
    });

    // --- MEJORA 3: Agregar la clase contenedora única para estilos aislados ---
    $(dt_basic.table().container()).addClass('facturas-datatable-wrapper');

    // Poner el título
    $('div.head-label').html('<h6 class="mb-0">Despachos realizados</h6>');

    // --- Lógica para los botones del modal de exportación en móvil ---
    $('.export-btn-facturas').on('click', function() {
        var exportType = $(this).data('export');
        dt_basic.button(0).add(0, exportType).trigger();
        bootstrap.Modal.getInstance(document.getElementById('exportModalFacturas')).hide();
    });

    // --- LÓGICA DE PULSACIÓN LARGA (LONG-PRESS) ---
    let pressTimer;
    let isLongPress = false;

    function mostrarFichaFactura(data) {
        var $status = data.estatus;
        var $status_info = {
          '': { title: 'SIN ENTREGAR', class: 'badge-light-danger' },
          '2': { title: 'ENTREGADO', class: 'badge-light-success' },
          '3': { title: 'DEVUELTO', class: 'badge-light-warning' },
          '4': { title: 'ELIMINADO', class: 'badge-light-info' }
        };
        
        var statusBadge = '';
        if (typeof $status_info[$status] !== 'undefined') {
          statusBadge = '<span class="badge rounded-pill ' + $status_info[$status].class + '">' + $status_info[$status].title + '</span>';
        }
        
        // Formatear fecha de armado
        let fechaArmadoFormateada = '';
        if (data.fecha_armado) {
          var date = new Date(data.fecha_armado);
          fechaArmadoFormateada = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        } else {
          fechaArmadoFormateada = 'N/A';
        }
        
        $('#ficha-factura-num').text(data.co_lote || 'N/A');
        $('#ficha-factura-codigo').text(data.co_cli || 'N/A');
        $('#ficha-factura-razon').text(data.cli_des || 'N/A');
        $('#ficha-factura-estatus').html(statusBadge);
        $('#ficha-factura-fecha-armado').text(fechaArmadoFormateada);
        $('#ficha-factura-fecha-entrega').text(data.dato_extra1 || 'N/A');
        $('#ficha-factura-persona').text(data.persona_des || 'N/A');

        const reportUrl = `index.php?view=factura_reportes&factura_num=${data.co_lote}`;
        $('#ficha-boton-reportes').attr('href', reportUrl);

        const loteNum = data.co_lote;
        const estatus = data.estatus;
        const isEnabled = (estatus === ''); // Solo habilitado si está sin entregar

        // Configurar el botón de confirmar despacho
        const $botonConfirmarDespacho = $('#ficha-boton-confirmar-despacho');
        if (isEnabled) {
            $botonConfirmarDespacho.removeClass('btn-secondary disabled').addClass('btn-success').removeAttr('data-bs-toggle data-bs-placement title');
        } else {
            $botonConfirmarDespacho.addClass('btn-secondary disabled')
                .attr('data-bs-toggle', 'tooltip')
                .attr('data-bs-placement', 'top')
                .attr('title', 'Solo disponible para facturas pendientes de entrega');
        }
        $botonConfirmarDespacho.tooltip('dispose').tooltip();

        $('#modalFichaFactura').data('facturaData', data);

        const modalFicha = new bootstrap.Modal(document.getElementById('modalFichaFactura'));
        modalFicha.show();
    }

    // --- Listener para el nuevo target (.factura-num-link) ---
    datatables_basic_facturas.on('mousedown touchstart', '.factura-num-link', function(e) {
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

    datatables_basic_facturas.on('mouseup touchend mouseleave', '.factura-num-link', function(e) {
        clearTimeout(pressTimer);
        if (isLongPress) {
            e.stopPropagation();
        }
    });

    datatables_basic_facturas.on('touchstart', '.factura-num-link', function() {
        $(this).addClass('active');
    });
    datatables_basic_facturas.on('touchend mouseleave', '.factura-num-link', function() {
        $(this).removeClass('active');
    });

    // --- EVENT LISTENERS PARA LOS BOTONES DE ACCIÓN EN EL MODAL ---
   /* $('#ficha-boton-eliminar').on('click', function() {
        const facturaNum = $(this).data('fact-num');
        if (!$(this).hasClass('disabled')) {
            // Usar SweetAlert2 en lugar de alert
            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea eliminar la factura ${facturaNum}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí iría la lógica para eliminar la factura
                    console.log(`Eliminando factura: ${facturaNum}`);
                    // Ejemplo de actualización de la tabla después de eliminar
                    dt_basic.ajax.reload();
                    
                    // Mostrar mensaje de éxito con SweetAlert2
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: `La factura ${facturaNum} ha sido eliminada.`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    }); */

  
    // NUEVO BOTÓN DE CONFIRMAR DESPACHO
    $('#ficha-boton-confirmar-despacho').on('click', function() {
      const data = $('#modalFichaFactura').data('facturaData');
      if (data && data.estatus === '') { // Solo permitir si está sin entregar
          const loteId = data.co_lote;
          let deliveryNotes = 'ALMACEN';
          // Confirmación visual
          Swal.fire({
              title: 'Confirmar Despacho',
              text: `¿Confirma la entrega del despacho ${loteId}?`,
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#28a745',
              cancelButtonColor: '#6c757d',
              confirmButtonText: 'Sí, confirmar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Realizar la llamada AJAX para actualizar el estado
                  $.ajax({
                    type: "POST",
                    url: '../admin/index.php?action=despacho&tipo=1&accion=1&datos=3&c=VehiculoData&a=1&t=jm_despacho_lotes',
                    data: {
                        loteId: loteId+'-1',
                        notas: deliveryNotes,
                        confirmado: 1
                    },
                    dataType: 'json',
                      beforeSend: function() {
                          // Opcional: Mostrar indicador de carga
                          const $boton = $('#ficha-boton-confirmar-despacho');
                          $boton.prop('disabled', true);
                          
                          // Usar una función segura para obtener el ícono de spinner
                          const spinnerIcon = getFeatherIcon('spinner') || 
                                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>';
                          
                          $boton.html(spinnerIcon + ' Procesando...');
                      },
                      success: function(response) {
                                
                        if (response.success) {
                          // Mostrar mensaje de éxito
                          Swal.fire({
                              icon: 'success',
                              title: '¡Entrega Confirmada!',
                              text: 'La entrega ha sido registrada exitosamente',
                              confirmButtonText: 'Aceptar',
                              confirmButtonColor: '#2c9aff',
                              allowOutsideClick: false
                          }).then((result) => {
                              if (result.isConfirmed) {
                                  // --- INICIO DE LA MODIFICACIÓN ---
                                  
                                  // Redirigir al usuario a la página principal
                                // Actualizar la tabla
                                   //  dt_basic.ajax.reload();
                                    // Cerrar el modal
                                   $('#modalFichaFactura').modal('hide');

                                   window.location.href = 'index.php?view=entregas';
                                  // --- FIN DE LA MODIFICACIÓN ---
                              }
                          });
                      } else {
                          // Mostrar mensaje de error
                          Swal.fire({
                              icon: 'error',
                              title: 'Error al confirmar',
                              text: response.message || 'No se pudo procesar la confirmación. Intente nuevamente.',
                              confirmButtonText: 'Aceptar',
                              confirmButtonColor: '#2c9aff'
                          });
                      }
                    },
                      error: function(xhr, status, error) {
                          alert('Error al comunicarse con el servidor: ' + error);
                      },
                      complete: function() {
                          // Restaurar el botón
                          const $boton = $('#ficha-boton-confirmar-despacho');
                          $boton.prop('disabled', false);
                          
                          // Restaurar el texto original del botón
                          $boton.html(feather.icons['check-circle'].toSvg({ class: 'font-small-4 me-50' }) + ' Confirmar Despacho');
                      }
                  });
              }
          });
      }
    });

  // Función auxiliar para obtener íconos de Feather de forma segura
  function getFeatherIcon(iconName) {
      if (feather && feather.icons && feather.icons[iconName]) {
          return feather.icons[iconName].toSvg({ class: 'animate-spin font-small-4 me-50' });
      }
      return null;
  }

    // Inicializar tooltips
    $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('show');
    }).on('mouseleave', '[data-bs-toggle="tooltip"]', function() {
      $(this).tooltip('hide');
    });
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
    var $filtro = $finicio;
    var $filtro2 = $ffinal;
    
    // Aquí podrías incluir el verificador en el filtro si tu backend lo necesita, por ejemplo:
    // var $filtro = $co_verificador + '/' + $finicio + '/' + $ffinal;
    
    cargarDataDespachos($filtro,$filtro2,$co_verificador);
    
    // Corrección: Se cierra el modal correcto
    $('#modalBuscarDespacho').modal('hide');
});


$('.cargarEmbarcos').on('click', function (e) { 
    e.preventDefault(); // Previene cualquier comportamiento por defecto del botón

    
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
   

    // --- FIN DE LAS VALIDACIONES ---

    // Si todas las validaciones pasan, se procede con la lógica original
    var $filtro = $finicio;
    var $filtro2 = $ffinal;
    
    // Aquí podrías incluir el verificador en el filtro si tu backend lo necesita, por ejemplo:
    // var $filtro = $co_verificador + '/' + $finicio + '/' + $ffinal;
    
    cargarDataEmbarques($filtro,$filtro2);
    
    // Corrección: Se cierra el modal correcto
    $('#modalBuscarDespacho').modal('hide');
});



$('.buscarVerificaciones').on('click', function (e) { 
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
  var $filtro = $finicio;
  var $filtro2 = $ffinal;
  
  // Aquí podrías incluir el verificador en el filtro si tu backend lo necesita, por ejemplo:
  // var $filtro = $co_verificador + '/' + $finicio + '/' + $ffinal;
  
  cargarDataDespachosEmpaquetar($filtro,$filtro2,$co_verificador);
  
  // Corrección: Se cierra el modal correcto
  $('#modalBuscarDespacho').modal('hide');
});


$('.cargarEntregas').on('click', function (e) { 
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
    
    cargarDataEntregas($filtro);
    
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

if ($('.m_entregas_consulta').length) {

  resaltarMenu('.i_entregas_consulta');
}

if ($('.m_embarcos_consulta').length) {
  resaltarMenu('.i_embarcos_consulta');
}
  cargarDataDespachos('NO','NO','NO');
  cargarDataDespachosEmpaquetar('NO','NO','NO');

 cargarDataEntregas('NO');
  cargarDataEmbarques('NO','NO');

/// Cargar los combos de la aplicacion

// Metodos asociados a los botones que haran acciones de insersion dentro de la base de datos

$('.AgregarInventario').on('click', function () {

  Swal.fire({
    title: '¿Deseas registrar estos datos?',
    text: "Tenga en cuenta que guardara toda  esta información",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#1750a7',
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
      confirmButtonColor: '#1750a7',
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
      confirmButtonColor: '#1750a7',
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


function cargarDataDespachos($filtro,$filtro2,$co_verificador){
  
  if ($('#dataDespachos').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=despacho&tipo=1&accion=2&datos=3&c=FacturaData&t=factura&filtro='+$filtro+'&verificador='+$co_verificador+'&filtro2='+$filtro2,
}).done(function(despachos) { 
  var cadena = JSON.stringify(despachos);
  $('.dataDespachos').attr("value",cadena);
    cargarTablaFacturasDespachos();
});
  }
}

function cargarDataEntregas($filtro){
  
  if ($('#dataEntregas').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=entrega&tipo=1&accion=2&datos=2&c=PaqueteData&t=factura&filtro='+$filtro,
}).done(function(despachos) { 
  var cadena = JSON.stringify(despachos);
  $('.dataEntregas').attr("value",cadena);
    cargarTablaFacturasEntregas();
});
  }
}



/**
 * Carga los datos de los embarques desde el servidor y los almacena
 * en un campo oculto para luego ser usados por la tabla.
 * @param {string} filtro - Parámetro de filtro para la consulta (opcional).
 */


function cargarDataEmbarques(filtro,filtro2) {
  
  // Verificamos que el campo oculto donde guardaremos los datos exista
  if ($('#dataEmbarques').length) {
   
    $.ajax({
      type: "GET",
      // CAMBIO 1: URL actualizada para obtener los datos de la tabla de cargas/embarques
      // Usamos los parámetros que apuntan a la clase VehiculoData y su método getAllCargas()
      url: '../admin/index.php?action=embarco&tipo=1&accion=2&datos=2&c=VehiculoData&a=1&t=carga&filtro=' + filtro+'&filtro2='+filtro2,
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



function cargarDataDespachosEmpaquetar($filtro,$filtro2,$co_verificador){
  
  if ($('#dataDespachosEmpaquetar').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=despacho&tipo=1&accion=2&datos=2&c=FacturaData&t=factura&filtro='+$filtro+'&filtro2='+$filtro2+'&co_verificador='+$co_verificador,
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
    cancelButtonColor: '#1750a7',
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
