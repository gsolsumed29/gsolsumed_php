function cargarTablaVentasxDia(){
  var dt_basic_table_pedidos = $('.datatablesVentasDia');   
    assetPath = '../app-assets/';
  if (dt_basic_table_pedidos.length) {
    dt_basic_table_pedidos.DataTable().destroy();
    let dataPedidos =  $('.dataVentasxDia').val();
    //console.log(dataArticulos);
    let arrayPedidos = "";
    arrayPedidos = JSON.parse(dataPedidos);
    var dt_basic = dt_basic_table_pedidos.DataTable({
     data : arrayPedidos,
      columns: [    
       //fec_emis tot_neto costo kilos util 
    
      
        { data: 'responsive_id' },//0
        { data: 'fec_emis' },    //1
        { data: 'tot_neto' },//2
        { data: 'dato2' },//3
        { data: 'dato1' },//4
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
          responsivePriority: 1,
          targets: 3
        },
  
      
     
       
        {
        
        }
      ],
      order: [[1, 'desc']],
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
              exportOptions: { columns: [1,2,3,4,5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
              exportOptions: { columns: [1,2,3,4,5] }
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
            'data-bs-target': '#filtroVentasMes'
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
      order: [[1, 'desc']],
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
    $('div.head-label').html('<h3 class="mb-0">Ventas del Mes</h3>');
  }
  
}
function cargarTablaCobrosMes(){
  var dt_basic_table_cobros_mes = $('.datatables-basic-cobros-mes');   
  if (dt_basic_table_cobros_mes.length) {
    dt_basic_table_cobros_mes.DataTable().destroy();
    let dataCobrosMes =  $('.dataCobrosMes').val();
    //console.log(dataArticulos);
    let arrayCobrosMes = "";
    arrayCobrosMes = JSON.parse(dataCobrosMes);
   // console.log(arrayCobrosMes);
    var dt_basic = dt_basic_table_cobros_mes.DataTable({
     data : arrayCobrosMes,
      columns: [    
     
      // fec_cob
      // tot_cobro
      
        { data: 'responsive_id' },//0
        { data: 'fec_cob' },    //1
        { data: 'tot_cobro' }
       
       
          
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
          responsivePriority: 1,
          targets: 2
        },
  
      
     
       
        {
        
        }
      ],
      order: [[1, 'desc']],
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
              exportOptions: { columns: [1,2] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
              exportOptions: { columns: [1,2] }
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
      order: [[1, 'desc']],
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
   // $('div.head-label').html('<h3 class="mb-0">Cobros del més</h3>');
  }
  
}
function cargarTablaArticuloFoco(){
  var dt_basic_table_articulos_foco = $('.datatables-basic-articulo-foco');   
  if (dt_basic_table_articulos_foco.length) {
    dt_basic_table_articulos_foco.DataTable().destroy();
    let dataArticulosFoco =  $('.dataArticulosFoco').val();
    //console.log(dataArticulos);
    let arrayCobrosMes = "";
    arrayCobrosMes = JSON.parse(dataArticulosFoco);
   // console.log(arrayCobrosMes);
    var dt_basic_articulos_foco = dt_basic_table_articulos_foco.DataTable({
     data : arrayCobrosMes,
      columns: [    
     
      // fec_cob
      // tot_cobro
      
        { data: 'responsive_id' },//0
        { data: 'art_des' },    //1
        { data: 'tot_meta' },    //1
        { data: 'total_art' },    //1
        { data: 'porc_alc' }
       
       
          
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
          responsivePriority: 1,
          targets: 2
        },
  
      
     
       
        {
        
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
        {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Buscar',
          className: 'pagar_facturas btn btn-relief-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#filtroArticulosFoco'
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
      order: [[1, 'desc']],
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
   // $('div.head-label').html('<h3 class="mb-0">Articulos en Foco</h3>');
  }
  
}
function cargarTablaArticuloVolumen(){
  var dt_basic_table_articulos_volumen = $('.datatables-basic-articulo-volumen');   
  if (dt_basic_table_articulos_volumen.length) {
    dt_basic_table_articulos_volumen.DataTable().destroy();
    let dataArticulosVolumen =  $('.dataArticulosVolumen').val();
    //console.log(dataArticulos);
    let arrayCobrosMes = "";
    arrayCobrosMes = JSON.parse(dataArticulosVolumen);
   // console.log(arrayCobrosMes);
    var dt_basic = dt_basic_table_articulos_volumen.DataTable({
     data : arrayCobrosMes,
      columns: [    
     
      // fec_cob
      // tot_cobro
      
        { data: 'responsive_id' },//0
        { data: 'art_des' },    //1
        { data: 'tot_meta' },    //1
        { data: 'total_art' },    //1
        { data: 'porc_alc' }
       
       
          
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
          responsivePriority: 1,
          targets: 2
        },
  
      
     
       
        {
        
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
        {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Buscar',
          className: 'pagar_facturas btn btn-relief-primary',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#filtroArticulosVolumen'
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
      order: [[1, 'desc']],
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
    //$('div.head-label').html('<h3 class="mb-0">Articulos en Foco</h3>');
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
function graficoReporteXA(meses){

  am4core.ready(function() {
    
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart3D);
    
    // Add data
    chart.data = meses;

    // Create axes
    let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "mes";
    categoryAxis.renderer.labels.template.rotation = 270;
    categoryAxis.renderer.labels.template.hideOversized = false;
    categoryAxis.renderer.minGridDistance = 20;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.verticalCenter = "middle";
    categoryAxis.tooltip.label.rotation = 270;
    categoryAxis.tooltip.label.horizontalCenter = "right";
    categoryAxis.tooltip.label.verticalCenter = "middle";
    
    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.title.text = "";
    valueAxis.title.fontWeight = "bold";
    
    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries3D());
    series.dataFields.valueY = "valor";
    series.dataFields.categoryX = "mes";
    series.name = "Ventas";
    series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;
    
    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;
    columnTemplate.stroke = am4core.color("#FFFFFF");
    
    columnTemplate.adapter.add("fill", function(fill, target) {
      return chart.colors.getIndex(target.dataItem.index);
    })
    
    columnTemplate.adapter.add("stroke", function(stroke, target) {
      return chart.colors.getIndex(target.dataItem.index);
    })
    
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.lineX.strokeOpacity = 0;
    chart.cursor.lineY.strokeOpacity = 0;

    chart.cursor.behavior = "none"
        
    }); // end am4core.ready()

}

function graficoReporteXATablero(meses,grafico){

  am4core.ready(function() {
    
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create(grafico, am4charts.XYChart3D);
    
    // Add data
    chart.data = meses;

    // Create axes
    let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "mes";
    categoryAxis.renderer.labels.template.rotation = 270;
    categoryAxis.renderer.labels.template.hideOversized = false;
    categoryAxis.renderer.minGridDistance = 20;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.verticalCenter = "middle";
    categoryAxis.tooltip.label.rotation = 270;
    categoryAxis.tooltip.label.horizontalCenter = "right";
    categoryAxis.tooltip.label.verticalCenter = "middle";
    
    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.title.text = "";
    valueAxis.title.fontWeight = "bold";
    
    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries3D());
    series.dataFields.valueY = "valor";
    series.dataFields.categoryX = "mes";
    series.name = "Ventas";
    series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;
    
    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;
    columnTemplate.stroke = am4core.color("#FFFFFF");
    
    columnTemplate.adapter.add("fill", function(fill, target) {
      return chart.colors.getIndex(target.dataItem.index);
    })
    
    columnTemplate.adapter.add("stroke", function(stroke, target) {
      return chart.colors.getIndex(target.dataItem.index);
    });

  
    
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.lineX.strokeOpacity = 0;
    chart.cursor.lineY.strokeOpacity = 0;

    chart.cursor.behavior = "none"
    
    }); // end am4core.ready()

    

}

function graficoReporteXLTablero(meses,grafico){
  //console.log(meses);
  am4core.ready(function() {
    
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create(grafico, am4charts.XYChart3D);

    // Add data
    chart.data = meses;

    // Create axes
    let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "mes";
    categoryAxis.renderer.labels.template.rotation = 270;
    categoryAxis.renderer.labels.template.hideOversized = false;
    categoryAxis.renderer.minGridDistance = 20;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.verticalCenter = "middle";
    categoryAxis.tooltip.label.rotation = 270;
    categoryAxis.tooltip.label.horizontalCenter = "right";
    categoryAxis.tooltip.label.verticalCenter = "middle";
    
    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.title.text = "";
    valueAxis.title.fontWeight = "bold";
    
    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries3D());
    series.dataFields.valueY = "valor";
    series.dataFields.categoryX = "mes";
    series.name = "Ventas";
    series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;
    
    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;
    columnTemplate.stroke = am4core.color("#FFFFFF");
    
    columnTemplate.adapter.add("fill", function(fill, target) {
      return chart.colors.getIndex(target.dataItem.index);
    })
    
    columnTemplate.adapter.add("stroke", function(stroke, target) {
      return chart.colors.getIndex(target.dataItem.index);
    })
    
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.lineX.strokeOpacity = 0;
    chart.cursor.lineY.strokeOpacity = 0;
    chart.cursor.behavior = "none"

    
    }); // end am4core.ready()

}

function graficoTopMes(topVendidos,topVendidosTabla){

  am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiv_Top", am4charts.PieChart);


chart.data = topVendidos;

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "valor";
series.dataFields.category = "articulo";

// this creates initial animation
series.hiddenState.properties.opacity = 1;
series.hiddenState.properties.endAngle = -90;
series.hiddenState.properties.startAngle = -90;

chart.legend = new am4charts.Legend();
//console.log(topVendidosTabla);

}

function graficoTopMenosMesUnidades(topMenosVendidos){

  am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiv_Top_Menos_unidades", am4charts.PieChart);


chart.data = topMenosVendidos;

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "valor";
series.dataFields.category = "articulo";

// this creates initial animation
series.hiddenState.properties.opacity = 1;
series.hiddenState.properties.endAngle = -90;
series.hiddenState.properties.startAngle = -90;

chart.legend = new am4charts.Legend();
}

function graficoTopMayorUtil(topMayorUtil){

  am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiv_Top_Mayor_Util", am4charts.PieChart);


chart.data = topMayorUtil;

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "valor";
series.dataFields.category = "articulo";

// this creates initial animation
series.hiddenState.properties.opacity = 1;
series.hiddenState.properties.endAngle = -90;
series.hiddenState.properties.startAngle = -90;

chart.legend = new am4charts.Legend();
}
function graficoTopMenorUtil(topMenorUtil){

  am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiv_Top_Menor_Util", am4charts.PieChart);


chart.data = topMenorUtil;

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "valor";
series.dataFields.category = "articulo";

// this creates initial animation
series.hiddenState.properties.opacity = 1;
series.hiddenState.properties.endAngle = -90;
series.hiddenState.properties.startAngle = -90;

chart.legend = new am4charts.Legend();
}

function cargarTablaClientesNoFacturados(){
  var dt_basic_table_clientes = $('.datatables-basic-clientes');   
    
  if (dt_basic_table_clientes.length) {
    dt_basic_table_clientes.DataTable().destroy();
    let dataClientes =  $('.dataNoFacturados').val();
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
        { data: 'co_cli' },//2
        { data: 'cli_des' },//3  
        { data: 'dato1' },//4
        { data: 'dato2' }//5
     
      
       
       
      
       
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
        
        }
      ],
      order: [[5, 'asc']],
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
              exportOptions: { columns: [2,3, 4, 5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4, 5] }
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
          "sNext": "&nbsp;",
          "sPrevious": "&nbsp;"
        },
      }

      
    });
    
   // $('div.head-label').html('<h6 class="mb-0">Listado de clientes no facturados</h6>');
    
 
  }

}

function estadisticasFacturaciones(promedio){

  var $goalStrokeColor2 = '#51e5a8';
  var $strokeColor = '#ebe9f1';
  var $textHeadingColor = '#5e5873';


  var $goalOverviewChart = document.querySelector('#goal-overview-radial-bar-chart');

  var goalOverviewChart;

   var goalOverviewChartOptions;



  //------------ Goal Overview Chart ------------
  //---------------------------------------------
  goalOverviewChartOptions = {
    chart: {
      height: 245,
      type: 'radialBar',
      sparkline: {
        enabled: true
      },
      dropShadow: {
        enabled: true,
        blur: 3,
        left: 1,
        top: 1,
        opacity: 0.1
      }
    },
    colors: [$goalStrokeColor2],
    plotOptions: {
      radialBar: {
        offsetY: -10,
        startAngle: -150,
        endAngle: 150,
        hollow: {
          size: '77%'
        },
        track: {
          background: $strokeColor,
          strokeWidth: '50%'
        },
        dataLabels: {
          name: {
            show: false
          },
          value: {
            color: $textHeadingColor,
            fontSize: '2.86rem',
            fontWeight: '600'
          }
        }
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        type: 'horizontal',
        shadeIntensity: 0.5,
        gradientToColors: [window.colors.solid.success],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100]
      }
    },
    series: [promedio],
    stroke: {
      lineCap: 'round'
    },
    grid: {
      padding: {
        bottom: 30
      }
    }
  };
  goalOverviewChart = new ApexCharts($goalOverviewChart, goalOverviewChartOptions);
  goalOverviewChart.render();

}

function estadisticaDetallada(mes,total){
    var options = {
      series: [{
      name: "Saldo de ventas",
      data: total
    }],
      chart: {
      type: 'bar',
      height: 430
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
       
        dataLabels: {
          position: 'top', // top, center, bottom

        },
      },
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val + "$";
      },
      offsetY: -20,
      style: {
        fontSize: '12px',
        colors: ["#ffffff"]
      }
    },
    crosshairs: {
      fill: {
        type: 'gradient',
        gradient: {
          colorFrom: '#D8E3F0',
          colorTo: '#BED1E6',
          stops: [0, 100],
          opacityFrom: 0.4,
          opacityTo: 0.5,
        }
      }
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    tooltip: {
      shared: true,
      intersect: false
    },
    xaxis: {
      categories: mes,
    },
    title: {
      text: 'Reporte de ventas por Articulo',
      floating: true,
      offsetY: 330,
      align: 'center',
      style: {
        color: '#444'
      }
    }
    };
    $("#chart").empty();
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

 
}

function estadisticaDetalladaLinea(mes,total){
  var options = {
    series: [{
    name: "Saldo de ventas",
    data: total
  }],
    chart: {
    type: 'bar',
    height: 430
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
     
      dataLabels: {
        position: 'top', // top, center, bottom

      },
    },
  },
  dataLabels: {
    enabled: true,
    formatter: function (val) {
      return val + "$";
    },
    offsetY: -20,
    style: {
      fontSize: '12px',
      colors: ["#ffffff"]
    }
  },
  crosshairs: {
    fill: {
      type: 'gradient',
      gradient: {
        colorFrom: '#D8E3F0',
        colorTo: '#BED1E6',
        stops: [0, 100],
        opacityFrom: 0.4,
        opacityTo: 0.5,
      }
    }
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  tooltip: {
    shared: true,
    intersect: false
  },
  xaxis: {
    categories: mes,
  },
  title: {
    text: 'Reporte de ventas por Linea',
    floating: true,
    offsetY: 330,
    align: 'center',
    style: {
      color: '#444'
    }
  }
  };
  $("#chart").empty();
  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();


}

function cargarTablaFacturasCliente() {
  var datatables_basic_facturas = $('.dataTablesFacturas');
  var groupColumn = 13;
  
  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataFacturas = $('.dataFacturas').val();
    let arrayFacturas = "";
    arrayFacturas = JSON.parse(dataFacturas);
    
    var dt_basic = datatables_basic_facturas.DataTable({
      data: arrayFacturas,
      columns: [
        { data: 'responsive_id' }, //0
        { data: 'nro_doc' }, //1
        { data: 'serie_fact_num' }, //2> Nº Documento
        { data: 'saldo' }, //3 Saldo     
        { data: 'co_cli' }, //4 Cliente
        { data: 'fec_emis' }, //5 Fecha Emisión
        { data: 'fec_venc' }, //6 Fecha Emisión
        { data: 'tipo_doc' }, //7 Tipo Documento
        { data: 'tasa' }, //8 Tasa
        { data: 'saldo2' }, //9
        { data: 'saldo3' }, //10
        { data: 'dato3' }, //11 Dias de retraso
        { data: 'dato1' }, //12 status
        { data: 'cli_des' } //13 Cliente
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        { visible: false, targets: groupColumn },
        {
          targets: 1,
          visible: true
        },
        {
          targets: 2,
          title: 'Nº Documento',
          width: '10%'
        },  
        {
          targets: 3,
          title: 'Saldo $',
          width: '10%'
        }, 
        {
          targets: 4,
          width: '15%',
          title: 'Datos del cliente',
          render: function (data, type, full, meta) {
            const cli_des = full['cli_des'] || 'No especificado'; 
            const co_cli = full['co_cli'] || 'No especificado';     
            return `
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                ${co_cli}
                </button>
                <ul class="dropdown-menu">
                  <li><span class="dropdown-item"><strong>Razón social:</strong> ${cli_des}</span></li>                
                </ul>
              </div>
            `;
          }
        },
        {
          targets: 5,
          title: 'Fecha emisión',
          width: '20%'
        },  
        {
          targets: 6,
          title: 'Fecha vencimiento',
          width: '20%'
        },  
        {
          targets: 7,
          title: 'Tipo',
          width: '5%'
        },  
        {
          targets: 8,
          title: 'Tasa',
          width: '10%'
        },  
        {
          targets: 9,
          visible: false
        },  
        {
          targets: 10,
          visible: false
        },  
        {
          targets: 11,
          title: 'Dias',
          width: '10%'
        },  
        {
          // Label
          targets: 12,
          title: 'Estatus',
          render: function (data, type, full, meta) {
            var $status_number = full['dato1'];
            var $status = {
              0: { title: 'Pendiente', class: 'badge-light-danger' },
              1: { title: 'Por conciliar', class: ' badge-light-warning' }
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
          // For Checkboxes
          targets: 1,
          orderable: false,
          responsivePriority: 3,
          render: function (data, type, full, meta) {
            return (`<div class="form-check"> <input class="form-check-input dt-checkboxes facturas ${full['nro_doc']}"
               type="checkbox" ${full['nro_doc']}="${full['saldo2']}" data-${full['nro_doc']}="${full['saldo3']}" 
               data-cocli${full['nro_doc']}="${full['co_cli']}" data-clides${full['nro_doc']}="${full['cli_des']}" 
               value="${full['nro_doc']}" id="checkbox${data}" /><label class="form-check-label" for="checkbox${data}"></label></div>`);
          }
        },
        {
          responsivePriority: 1,
          targets: 4
        }
      ],
      order: [[groupColumn, 'asc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      drawCallback: function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;

        api
          .column(groupColumn, { page: 'current' })
          .data()
          .each(function (group, i) {
            if (last !== group) {
              $(rows)
                .eq(i)
                .before(
                  '<tr class="group">' +
                    '<td colspan="1">' +
                      '<div class="form-check">' +
                        '<input class="form-check-input group-checkbox" type="checkbox" data-group="' + group + '">' +
                        '<label class="form-check-label"></label>' +
                      '</div>' +
                    '</td>' +
                    '<td colspan="9">' + group + '</td>' +
                  '</tr>'
                );

              last = group;
            }
          });
      },
      buttons: [   
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Registrar',
          className: 'pagar_facturas btn btn-relief-primary',        
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }, 
        {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }),
          className: 'btn btn-relief-info',  
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#FiltroBuscarFacturas'
          },      
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        },   
        {
          extend: 'collection',
          className: 'btn btn-relief-success dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }),
          buttons: [
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4, 5, 8] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'letter',
              exportOptions: { columns: [2,3, 4, 5, 8] }
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
              return 'Detalles del documento ';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== ''
                ? '<tr data-dt-row="' + col.rowIdx + '" data-dt-column="' + col.columnIndex + '">' +
                    '<td>' + col.title + ':' + '</td> ' +
                    '<td>' + col.data + '</td>' +
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

    // Manejar click en checkbox de grupo
    $(document).on('click', '.group-checkbox', function() {
      var group = $(this).data('group');
      var isChecked = $(this).prop('checked');
      
      // Buscar todas las filas de este grupo y marcar/desmarcar sus checkboxes
      dt_basic.rows().every(function() {
        var rowData = this.data();
        if (rowData.cli_des === group) {
          var rowNode = this.node();
          $(rowNode).find('.dt-checkboxes.facturas').prop('checked', isChecked);
        }
      });
    });

    // Manejar cambios en checkboxes individuales para actualizar el estado del grupo
    $(document).on('change', '.dt-checkboxes.facturas', function() {
      var row = $(this).closest('tr');
      var rowData = dt_basic.row(row).data();
      var group = rowData.cli_des;
      
      // Encontrar la fila de grupo correspondiente
      var groupRow = row.prevAll('tr.group:first');
      while(groupRow.length && groupRow.find('.group-checkbox').data('group') !== group) {
        groupRow = groupRow.prevAll('tr.group:first');
      }
      
      if(groupRow.length) {
        var groupCheckbox = groupRow.find('.group-checkbox');
        
        // Contar checkboxes en este grupo
        var totalInGroup = 0;
        var checkedInGroup = 0;
        
        dt_basic.rows().every(function() {
          var data = this.data();
          if(data.cli_des === group) {
            totalInGroup++;
            if($(this.node()).find('.dt-checkboxes.facturas').prop('checked')) {
              checkedInGroup++;
            }
          }
        });
        
        // Actualizar estado del checkbox del grupo
        if (checkedInGroup === 0) {
          groupCheckbox.prop('checked', false);
          groupCheckbox.prop('indeterminate', false);
        } else if (checkedInGroup === totalInGroup) {
          groupCheckbox.prop('checked', true);
          groupCheckbox.prop('indeterminate', false);
        } else {
          groupCheckbox.prop('checked', false);
          groupCheckbox.prop('indeterminate', true);
        }
      }
    });

    // Order by the grouping
    $('.dt-row-grouping tbody').on('click', 'tr.group', function(e) {
      // Solo cambiar el orden si no se hizo click en el checkbox
      if (!$(e.target).is('.group-checkbox, .group-checkbox *')) {
        var currentOrder = dt_basic.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
          dt_basic.order([groupColumn, 'desc']).draw();
        } else {
          dt_basic.order([groupColumn, 'asc']).draw();
        }
      }
    });
   
    $('.pagar_facturas').click(function(){      
      let arrayFacturas = [];   
      let arrayFacturas_costo = [];    
      let cliente="";
      let co_cliente="";

     $("input[type=checkbox].facturas:checked").each(function() {  
    arrayFacturas.push($(this).val());
    });
      var tope = arrayFacturas.length;

      if(tope >= 1){
        let saldo = 0.00;
        let monto = 0.00;   
        let monto2 = 0.00;   
        let factura = 0;  
        let saldoBs = 0.00;  
        var co_cli_anterior = null;
        var facturas_con_error = [];
        var primer_co_cli = null;

        for (var i = 0; i < tope; i++) { 
          factura = arrayFacturas[i];
          monto = parseFloat(($("."+arrayFacturas[i]+"").attr(factura)));
          monto2 = parseFloat(($("."+arrayFacturas[i]+"").attr('data-'+factura)));
          co_cli = $("."+arrayFacturas[i]+"").attr('data-cocli'+factura);
          cli_des = $("."+arrayFacturas[i]+"").attr('data-clides'+factura);
          
          if (i === 0) {
              co_cli_anterior = co_cli;
              primer_co_cli = co_cli;
          } 
          else if (co_cli !== co_cli_anterior) {
              facturas_con_error.push({
                  factura: factura,
                  co_cli: co_cli,
                  esperado: primer_co_cli
              });
          }
          
          saldo = parseFloat((saldo + monto).toFixed(2));
          saldoBs = parseFloat((saldoBs + monto2).toFixed(2));         
        }

        if (facturas_con_error.length > 0) {
          var mensaje = "Error: Se encontraron facturas con co_cli diferente:\n";
          facturas_con_error.forEach(function(error) {
              mensaje += `Factura ${error.factura}: co_cli=${error.co_cli} (debería ser ${error.esperado})\n`;
          });
          
          alert(mensaje);
          return false;
        } else {
          $(location).attr('href','index.php?view=reportepago&facturas_cancelar='+
              arrayFacturas+'&facturas_cliente_codigo='+co_cli+
              '&facturas_cliente_2='+cli_des+'&facturas_saldo='+saldo.toFixed(2)+'&facturas_saldo_bs='+saldoBs.toFixed(2));  
        }
      } else {
        Swal.fire({
          title: '¿Información?',
          html: `
              <div style="text-align: center;">
                  <p>No se ha elegido ninguna factura para reportar pago.</p>
                  <p>¿Deseas registrar un <strong>ADELANTO</strong>? 💰</p>
              </div>
          `,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0343a5',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, adelantar',
          cancelButtonText: 'No, cancelar',
          focusConfirm: false,
          customClass: {
              htmlContainer: 'text-center'
          }
        }).then((result) => {
          if (result.isConfirmed) {
              $(".modalPagoAdelantos").modal("show");
          }
        });
      }
    });
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

  var datatables_basic_adelantos = $('.dataTablesAdelantos');

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
             
              '<a href="javascript:;" class="'+full['nro_doc']+' dropdown-item btnDelAdelanto">' +
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
          text: feather.icons['corner-up-left'].toSvg({ class: ' font-small-4 me-50' }) + 'Buscar ',
          className: 'btnVolver_2 btn btn-relief-danger me-2',
            init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }        
        },
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
          className: 'btn btn-relief-primary btnAddAdelantos',
          
          /*attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalPagoAdelantos'
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
              return 'Detalles del adelanto';
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
       $('.dataTablesAdelantos tbody').on('click', '.btnDelAdelanto', function (e) {
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


      $('.btnAddAdelantos').click(function(){     
      
      let cliente="";
      let co_cliente="";        
      cliente = $('.comboClientesFactura option:selected').html().trim();
      co_cliente=$('.comboClientesFactura').val();
  
        $('.facturas_cliente_adelantos').html(cliente);
        $('.facturas_cliente_adelantos2').val(cliente);      
        $('.facturas_cliente_codigo').val(co_cliente);     
        $('.modalPagoAdelantos').modal('show');      
    

    });





    $('div.head-label').html('<h6 class="mb-0">Adelantos</h6>');
  }
  
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
            
              '<a class="me-25" href="index.php?action=reporte&tipo=4&co_cli='+co_cli+'" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar">' +
              feather.icons['download'].toSvg({ class: 'font-medium-2 text-body' }) +
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

function cargarTablaClientes(){
  var dt_basic_table_clientes = $('.datatables-basic-clientes');   
  // Advanced Filter table
  if (dt_basic_table_clientes.length) {
    
  $('input.dt-input').on('keyup', function () {
    filterColumn($(this).attr('data-column'), $(this).val());
  });

    let dataClientes =  $('.dataClientes').val();
    //console.log(dataUsuarios);
    let arrayClientes = "";
    arrayClientes = JSON.parse(dataClientes);
    var dt_adv_filter = dt_basic_table_clientes.DataTable({
      data : arrayClientes,
      columns: [
        { data: 'responsive_id' },//0
        { data: 'co_cli' },    //1
        { data: 'co_cli' },//2
        { data: 'cli_des' },//3  
        { data: 'rif' },//4
        { data: 'saldo_p' }, //5
        { data: 'ultima_f' },//6
        { data: 'mont_cre' },  //7   
        { data: 'plaz_pag' }, //8  
        { data: 'direc1' },//9
        { data: 'telefonos' }, // 10      
        { data: 'email' },//11  
        { data: 'dir_ent2' },  //12 
        { data: 'des_tipo' }  //13  
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
          targets: 12,
          visible: false
        },  
        {
          targets: 13,
          visible: false
        },            
        
        {
          responsivePriority: 1,
          targets: 3
        },
       
        {
          // Label
          targets: 5,
          render: function (data, type, full, meta) {
            var $status_number = full['saldo_p'];
          
          if($status_number=='0,00'){
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
          // Label
          targets: 6,
          render: function (data, type, full, meta) {
            var $status_number = full['ultima_f'];
            var $status = {
              0: { title: 'No ha facturado', class: 'badge-light-danger' }           
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

function cargarTablaArticulos(){
  var dt_basic_table_articulos = $('.datatables-basic-articulos');   
    assetPath = '../app-assets/';
  if (dt_basic_table_articulos.length) {
    dt_basic_table_articulos.DataTable().destroy();
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
        { data: 'prec_vta2' }//6     
          
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
          targets: 6,
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
           // console.log($status_number);
            let prec_vta1 = parseFloat($status_number)           
           if($status_number=='0,00'){
            return (
              '<span class="badge rounded-pill badge-light-danger  ">'+prec_vta1.toFixed(2)+'</span>'
            );
           }else{
            return (
            '<span class="badge rounded-pill badge-light-success  ">'+prec_vta1.toFixed(2)+'</span>'
            );
           }
           
          }
        },
        {
          // Label
          targets: 6,
          render: function (data, type, full, meta) {
            var $status_number = full['prec_vta2'];     
            let prec_vta2 = parseFloat($status_number)                     
           if($status_number=='0,00'){
            return (
              '<span class="badge rounded-pill badge-light-danger  ">'+prec_vta2.toFixed(2)+'</span>'
            );
           }else{
            return (
            '<span class="badge rounded-pill badge-light-danger  ">'+prec_vta2.toFixed(2)+'</span>'
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
          text: feather.icons['search'].toSvg({ class: ' font-small-4 me-50' }) + 'Filtrar articulos ',
          className: ' btn btn-relief-info me-2',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalFiltroArticulos'
          },
            init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }        
        },
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
           
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4, 5, 8] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'letter',
               exportOptions: { columns: [2,3, 4, 5, 8] }
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
          text: feather.icons['file-text'].toSvg({ class: 'me-50 font-small-4' }) + 'Generar lista',
          className: ' btn btn-relief-danger btnGenrarListaPDF',
         attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalGenerarLista'
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
              return 'Detalles del producto';
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
    

  }

}

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
        //responsive_id co_art art_des prec_vta1
    
      
        { data: 'responsive_id' },//0
        { data: 'fact_num' },    //1
        { data: 'fact_num' },//2
        { data: 'fact_num' },//3
        { data: 'dato1' },//4
        { data: 'fec_emis' },//5  
        { data: 'forma_pag' },//6    
        { data: 'tot_bruto' },//7  
        { data: 'tot_neto' },//8     
        { data: 'iva' },//9    
        { data: 'status' },//10  
        { data: '' },//  11 
       
          
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
          targets: 4,
          width: '70%'
          
        },   
        {
          targets: 5,
          width: '10%'
          
        },    
        {
          targets: 6,
          visible: false
        },   
        {
          targets: 7,
          visible: false
        },   
        {
          targets: 8,
          width: '10%'
          
        },   
        {
          targets: 9,
          visible: false
        },   
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },

        {
          // Label
          targets: 10,
          width: '20px',
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              0: { title: 'Sin procesar', class: 'badge-light-warning' },
              1: { title: 'Parcialmente', class: ' badge-light-info' },
              2: { title: 'Procesado', class: 'badge-light-success' }
              
            
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
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="index.php?view=factura&fact_num='+full['fact_num']+'&s='+full['status']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
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

function cargarTablaFacturaciones(){
  var dt_basic_table_facturaciones = $('.datatables-basic-facturaciones');   
    assetPath = '../app-assets/';
  if (dt_basic_table_facturaciones.length) {
    dt_basic_table_facturaciones.DataTable().destroy();
    let dataFacturaciones =  $('.dataFacturaciones').val();
    //console.log(dataArticulos);
    let arrayFacturaciones = "";
    arrayFacturaciones = JSON.parse(dataFacturaciones);
    var dt_basic = dt_basic_table_facturaciones.DataTable({
     data : arrayFacturaciones,
      columns: [    
        //responsive_id co_art art_des prec_vta1
    
      
        { data: 'responsive_id' },//0
        { data: 'fact_num' },    //1
        { data: 'fact_num' },//2
        { data: 'fact_num' },//3
        { data: 'dato1' },//4
        { data: 'fec_emis' },//5  
        { data: 'forma_pag' },//6    
        { data: 'tot_bruto' },//7  
        { data: 'tot_neto' },//8     
        { data: 'iva' },//9    
        { data: 'status' },//10  
        { data: '' },//  11 
       
          
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
          targets: 10,
          visible: false
        },  
        {
          targets: 3,
          width: '10%'
          
        },  
        {
          targets: 4,
          width: '70%'
          
        },   
        {
          targets: 5,
          width: '10%'
          
        },    
        {
          targets: 6,
          visible: false
        },   
        {
          targets: 7,
          visible: false
        },   
        {
          targets: 8,
          width: '10%'
          
        },   
        {
          targets: 9,
          visible: false
        },   
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },

        {
          // Label
          targets: 10,
          width: '20px',
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              0: { title: 'Sin procesar', class: 'badge-light-warning' },
              1: { title: 'Parcialmente', class: ' badge-light-info' },
              2: { title: 'Procesado', class: 'badge-light-success' }
              
            
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
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="index.php?view=facturacion&fact_num='+full['fact_num']+'&s='+full['status']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
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

function cargarTablaVisitas(){
  var dt_basic_table_visitas = $('.datatables-basic-visitas');   
    assetPath = '../app-assets/';
  if (dt_basic_table_visitas.length) {
    
    let dataVisitas =  $('.dataVisitas').val();
    //console.log(dataUsuarios);
    let arrayVisitas = "";
    arrayVisitas = JSON.parse(dataVisitas);
    var dt_basic = dt_basic_table_visitas.DataTable({
     data : arrayVisitas,
      columns: [    
        
        { data: 'responsive_id' },//0
        { data: 'co_vis' },    //1
        { data: 'co_vis' },//2
        { data: 'dato1' },//3
        { data: 'fecha' },//4
        { data: 'des_vis' },//5
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
             
              '<a href="javascript:;" class="'+full['co_vis']+' dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +
              '</div>' +
              '</div>'
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
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }),
          className: 'create-new btn btn-relief-primary',
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
              return 'Detalles visita';
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
    
    
    
    $('.data-submit-visita').on('click', function () {
      var $co_cli= $('#co_cli').val(); 
        $des_vis =   $('.des_vis option:selected').html();
        $lat =$('.lat').html();
        $lon =$('.lon').html();
      if (($co_cli != '') && ($des_vis!='Seleccione')) { 
          if(($lat!='0') && ($lon!='0')){      
            var tipo = 1;
            var accion = 1;
            var datos =1;
                $.ajax({
                    url: '../admin/index.php?action=visitas', 
                    type:'POST',
                    data:{lat:$lat,lon:$lon,co_cli:$co_cli,des_vis:$des_vis,tipo:tipo,accion:accion,datos:datos},
                    success:function(response){
                      var i = 0;
                      var tope =response.length;  
                      if(tope == 1){ 
                        for (var i = 0; i < tope; i++) {              
                          
                          dt_basic.row
                          .add({                            
                            responsive_id : 0,
                            co_vis: response[i].co_vis,
                            dato1:  response[i].dato1,
                            fecha: response[i].fecha,
                            des_vis:response[i].des_vis              
                          })
                          .draw();
                          
                          
                      
                        
                        //count++;
                        $('.modal').modal('hide');
                          } 
                        } 
                      
                       
                    }
                });
                
        
              }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Debe habilitar el uso de la posicion GPS para poder guardar la ubicacion!'
                
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
    $('.datatables-basic-visitas tbody').on('click', '.delete-record', function (e) {
     let id = e.target.classList[0];
     console.log(id);
      e.preventDefault();
      Swal.fire({
        title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que eliminará definitivamentela visita .",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
           //  pagar();
           borrarVisita(id);
           dt_basic.row($(this).parents('tr')).remove().draw();
       
        }
      })
   


    });

    $('div.head-label').html('<h6 class="mb-0">Visitas realizadas</h6>');
  }

}

function cargarTablaAprobaciones(){
  var dt_basic_table_aprobaciones = $('.datatables-basic-aprobaciones');   
    assetPath = '../app-assets/';
  if (dt_basic_table_aprobaciones.length) {
    dt_basic_table_aprobaciones.DataTable().destroy();
    let dataAprobaciones =  $('.dataAprobaciones').val();
    //console.log(dataArticulos);
    let arrayAprobaciones = "";
    arrayAprobaciones = JSON.parse(dataAprobaciones);
    var dt_basic = dt_basic_table_aprobaciones.DataTable({
     data : arrayAprobaciones,
      columns: [    
        //responsive_id co_art art_des prec_vta1
    
      
        { data: 'responsive_id' },//0
        { data: 'fact_num' },    //1
        { data: 'fact_num' },//2
        { data: 'fact_num' },//3
        { data: 'dato1' },//4
        { data: 'fec_emis' },//5  
        { data: 'forma_pag' },//6    
        { data: 'tot_bruto' },//7  
        { data: 'tot_neto' },//8     
        { data: 'iva' },//9    
        { data: 'status' },//10  
        { data: '' },//  11 
       
          
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
          targets: 4,
          width: '70%'
          
        },   
        {
          targets: 5,
          width: '10%'
          
        },    
        {
          targets: 6,
          visible: false
        },   
        {
          targets: 7,
          visible: false
        },   
        {
          targets: 8,
          width: '10%'
          
        },   
        {
          targets: 9,
          visible: false
        },   
        
        
        
        {
          responsivePriority: 1,
          targets: 3
        },

        {
          // Label
          targets: 10,
          width: '20px',
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              0: { title: 'Sin procesar', class: 'badge-light-warning' },
              1: { title: 'Parcialmente', class: ' badge-light-info' },
              2: { title: 'Procesado', class: 'badge-light-success' }
              
            
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
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="index.php?view=facturaAprobacion&fact_num='+full['fact_num']+'&s='+full['status']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
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
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="index.php?view=cliente&co_cli='+full['co_cli']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
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


function cargarTablaPagos(){
  var dt_basic_table_facturaciones = $('.dataTablesPagos');   
    
  if (dt_basic_table_facturaciones.length) {
    dt_basic_table_facturaciones.DataTable().destroy();
    let dataPagos =  $('.dataPagos').val();
    //console.log(dataArticulos);
    let arrayFacturaciones = "";
    arrayFacturaciones = JSON.parse(dataPagos);
    var dt_basic = dt_basic_table_facturaciones.DataTable({
     data : arrayFacturaciones,
      columns: [    
      /* responsive_id id nro_doc forma_pag ref_ban monto monto_bs fec_tran estatus */

        { data: 'responsive_id' },//0
        { data: 'id' },    //1
        { data: 'nro_doc' },//2
        { data: 'forma_pag' },//3
        { data: 'ref_ban' },//4
        { data: 'monto' },//5  
        { data: 'monto_bs' },//6    
        { data: 'fec_tran' },//7  
        { data: 'estatus' },//8       
        { data: '' },//9 
       
          
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
           title: 'N° Documento',
          visible: true
        },      
        {
          targets: 3,
           title: 'Forma de Pago',
          width: '10%'
          
        },  
        {
          targets: 4,
          title: 'Referencia Bancaria',
          render: function (data, type, full, meta) {
            // Asumiendo que tu data tiene estos campos (si no, ajusta los nombres)
            const tipo = full['dato4'];
           

            if(tipo=='1'){
              const ref_ban = full['dato1'] || 'No especificado';
              const banco = full['dato2'] || 'No especificado';        
              const numeroCuenta = full['dato3'] || 'No especificado';

              return `
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                ${ref_ban}
                </button>
                <ul class="dropdown-menu">
                  <li><span class="dropdown-item"><strong>Banco:</strong> ${banco}</span></li>                
                  <li><span class="dropdown-item"><strong>N° Cuenta:</strong> ${numeroCuenta}</span></li>
                </ul>
              </div>
            `;
          }else{
              const efectivo = full['dato1'] || 'No especificado';
              const caja = full['dato2'] || 'No especificado';        
              const caja2 = full['dato3'] || 'No especificado';
            return `
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              ${efectivo}
              </button>
              <ul class="dropdown-menu">
                <li><span class="dropdown-item"><strong>N° Caja:</strong> ${caja}</span></li>                
                <li><span class="dropdown-item"><strong>N° Otro dato:</strong> ${caja2}</span></li>
              </ul>
            </div>
          `;
          }
            }
           
        },
        {
          targets: 5,
           title: 'Monto',
          width: '10%'
          
        },    
        {
          targets: 6,
           title: 'Monto Bs.D',
          visible: true
        },   
        {
          targets: 7,
           title: 'Fecha de Transacción',
          visible: true
        },   
        {
          responsivePriority: 1,
          targets: 3
        },

        {
          // Label
          targets: 8,
          width: '20px',
          title: 'Estatus',
          render: function (data, type, full, meta) {
             const estatus = full['estatus'];
             //console.log(estatus);
             if(estatus=='1'){
              return (
              '<span class="badge rounded-pill badge-light-info">Por conciliar</span>'
            );
             }else{
            return `
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
             Pago conciliado
              </button>
              <ul class="dropdown-menu">
                <li><span class="dropdown-item"><strong>N° Cobro :</strong> ${estatus}</span></li>                
                
              </ul>
            </div>
          `;
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
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              //'<a class="me-25" href="index.php?view=facturacion&fact_num='+full['id']+'&s='+full['status']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
               '<a class="me-25" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
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
          text: feather.icons['corner-up-left'].toSvg({ class: ' font-small-4 me-50' }) + 'Buscar ',
          className: 'btnVolver_pago btn btn-relief-danger me-2',
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
        
    $('.btnVolver_pago').on('click', function (e) {

      $('#pagos').attr("style","display:none");       
      $('#busqueda').show();    
      $('.dataTablesPagos').val("0");     
      $('.dataTablesPagos').select2();
      $('.dataTablesPagos').select2('destroy');      
      $('#pagos').removeClass('col-lg-12').addClass('col-lg-8');   

    });
  }

}

function cargarTablaPagosRealizados($facturas){
  var dt_basic_table_facturaciones = $('.dataTablesPagosRealizados');   
    
  if (dt_basic_table_facturaciones.length) {
    dt_basic_table_facturaciones.DataTable().destroy();
    let dataPagos =  $('.dataPagosRealizados').val();
    //console.log(dataArticulos);
    let arrayFacturaciones = "";
    arrayFacturaciones = JSON.parse(dataPagos);
    var dt_basic = dt_basic_table_facturaciones.DataTable({
     data : arrayFacturaciones,
      columns: [   
 
        { data: 'responsive_id' },//0
        { data: 'id' },    //1
        { data: 'ref_ban' },//2
        { data: 'forma_pag' },//3  
        { data: 'fec_tran' },//4
        { data: 'monto' },//5
        { data: 'monto_bs' },//6     
        { data: '' },//7       
          
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
          title: 'ID',
          visible: false
        },
        {
          targets: 2,
          title: 'Referencia',
          visible: true
        },      
        {
          targets: 3,
           title: 'Metodo de Pago',
          visible: true
        },      
        {
          targets: 4,
           title: 'Fecha de Transacción',
          visible: true
          
        },  
        {
        targets: 5,
          title: 'Monto $',
        visible: true,
        render: function (data, type, full, meta) {
          let monto = full['monto'];
          let montodolares = Number(monto).toFixed(2);
          
          if(Number(montodolares) < 0) {
            return '<span class="badge rounded-pill bg-danger">'+montodolares+'</span>';
          } else {
            return '<span class="badge rounded-pill bg-success">'+montodolares+'</span>';
          }
        }
      },
        
        {
        targets: 6,
        title: 'Monto en Bs.D',
        visible: true,
        render: function (data, type, full, meta) {
          let monto = full['monto_bs'];
          let montobs = Number(monto).toFixed(2);
          
          if(Number(montobs) < 0) {
            return '<span class="badge rounded-pill bg-danger">'+montobs+'</span>';
          } else {
            return '<span class="badge rounded-pill bg-warning">'+montobs+'</span>';
          }
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
            return (
              '<div class="d-flex align-items-center col-actions">' +             
               '<a href="javascript:;" class="'+full['id']+' '+full['monto']+' dropdown-item delete-record">' +
              feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
              'Borrar</a>' +                  
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
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4, 5, 6] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2,3, 4, 5, 6] }
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
              return 'Detalles del Pago';
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
        
   

       // Delete Record
    $('.dataTablesPagosRealizados tbody').on('click', '.delete-record', function (e) {
     let id = e.target.classList[0];
     let  monto = e.target.classList[1];


  //console.log(monto);
     e.preventDefault();
      Swal.fire({
         title: '¿Deseas Eliminar?',
        text: "Tenga en cuenta que Eliminará éste reporte de pago definitivamente del sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
           //  pagar();
            borrarPagosRealizados(id,monto);
       
        
       
        }
      })

    
   


    });

      $('div.head-label').html('<h3 class="mb-0" id="co_cli">Relación de documentos a conciliar</h3>');
  }

}


function cargarTablaCandidatos(){
  var dataTablesCandidatos = $('.dataTablesCandidatos');   
  // Advanced Filter table
  if (dataTablesCandidatos.length) {
    
  $('input.dt-input').on('keyup', function () {
    filterColumn($(this).attr('data-column'), $(this).val());
  });

    let dataClientes =  $('.dataClientes').val();
    //console.log(dataUsuarios);
    let arrayClientes = "";
    arrayClientes = JSON.parse(dataClientes);
    var dt_adv_filter = dataTablesCandidatos.DataTable({
      data : arrayClientes,
      columns: [
        { data: 'responsive_id' },//0
        { data: 'id' },    //1        
        { data: 'cand_des' },//2 
        { data: 'rif' },//3      
        { data: 'direc1' },//4
        { data: 'telefonos' }, // 5      
        { data: 'email' },//6    
        
        { data: '' }  //7 
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
          visible: true
        },   

        {
          targets: 3,
          visible: true
        },  
       {
          targets: 4,
          visible: true
        },
         {
          targets: 5,
          visible: true
        },
         {
          targets: 6,
          visible: true
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
              '<a class="me-25" href="index.php?view=facturaAprobacion&fact_num='+full['fact_num']+'&s='+full['status']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +                       
              '</div>' +
              '</div>' +
              '</div>'
            );
          }
        }, 
      ],
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      orderCellsTop: true,
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['cand_des'];
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


$(window,document,$).ready(function(){
  'use strict';


    var sidebarShop = $('.sidebar-shop'),
    btnCart = $('.btn-cart'),
    overlay = $('.body-content-overlay'),
    sidebarToggler = $('.shop-sidebar-toggler'),
    sortingDropdown = $('.dropdown-sort .dropdown-item'),
    sortingText = $('.dropdown-toggle .active-sorting'),
    removeItem = $('.remove-card')

    cargarDataVentasxDia('NO','NO');
    cargarDataArticuloFoco('NO','NO');
    // Initialize and add the map
// para filtrar los datos de facturas para reporte de pagos
$('.btnConsultarClientes').on('click', function (e) {
  var $co_cli = $('.comboClientesFactura').val();
  var $finicio = $('.finicio').val();
  var $ffinal = $('.ffinal').val();
 
  if($co_cli==0){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir un Cliente!'
    })
  }else if(($('.finicio').val().length == 0) || ($('.ffinal').val().length == 0)){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    })
  }else{
    cargarDataFacturas($co_cli,'NO',$finicio,$ffinal);
    $('#FiltroBuscarFacturas').modal('hide');
  }
});


    if ($('#perfilCLiente').length) {
    // console.log('perfilCliente');
      let co_cli= $('#co_cli').val();  
      perfilCliente(co_cli);
    // localizacionData(co_cli);
    }



if ($('#IndicadorVentasxPeriodo').length) { 
   var $co_ven = $('.identificacion').text(); 
     $('#estatusIndicadores').html("Més actual"); 
   cargarIndicadorVentasxPeriodo($co_ven,'NO','NO','NO','1');
}
if ($('#IndicadorClientesFacturados').length) { 
   var $co_ven = $('.identificacion').text();  
   cargarIndicadorClientesFacturados($co_ven,'NO','NO','NO','2');
}
if ($('#IndicadorCobranzasMes').length) { 
   var $co_ven = $('.identificacion').text();  
   cargarIndicadorCobranzasMes($co_ven,'NO','NO','NO','3');
}
if ($('#IndicadorClientesNuevos').length) { 
   var $co_ven = $('.identificacion').text();  
   cargarIndicadorClientesNuevos($co_ven,'NO','NO','NO','4');
}

// Función para el link "Mes anterior"
$('#filtrarIndicadoresActual').on('click', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del link
    
          if ($('#IndicadorVentasxPeriodo').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorVentasxPeriodo($co_ven,'NO','NO','NO','1');
      }
      if ($('#IndicadorClientesFacturados').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorClientesFacturados($co_ven,'NO','NO','NO','2');
      }
      if ($('#IndicadorCobranzasMes').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorCobranzasMes($co_ven,'NO','NO','NO','3');
      }
      if ($('#IndicadorClientesNuevos').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorClientesNuevos($co_ven,'NO','NO','NO','4');
      }

      $('#estatusIndicadores').html("Més actual");


});

// Función para el link "Mes anterior"
$('#filtrarIndicadoresMes').on('click', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del link
    
    // Ejecutar las funciones para el mes anterior
    if ($('#IndicadorVentasxPeriodo').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorVentasxPeriodo($co_ven, 'NO', 'SI', 'NO', '1');
    }
    if ($('#IndicadorClientesFacturados').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorClientesFacturados($co_ven, 'NO', 'SI', 'NO', '2');
    }
    if ($('#IndicadorCobranzasMes').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorCobranzasMes($co_ven, 'NO', 'SI', 'NO', '3');
    }
    if ($('#IndicadorClientesNuevos').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorClientesNuevos($co_ven, 'NO', 'SI', 'NO', '4');
    }

      $('#estatusIndicadores').html("Més anterior");


});

// Función para el link "Año anterior"
$('#filtrarIndicadoresAnio').on('click', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del link
    
    // Ejecutar las funciones para el año anterior
    if ($('#IndicadorVentasxPeriodo').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorVentasxPeriodo($co_ven, 'NO', 'NO', 'SI', '1');
    }
    if ($('#IndicadorClientesFacturados').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorClientesFacturados($co_ven, 'NO', 'NO', 'SI', '2');
    }
    if ($('#IndicadorCobranzasMes').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorCobranzasMes($co_ven, 'NO', 'NO', 'SI', '3');
    }
    if ($('#IndicadorClientesNuevos').length) { 
        var $co_ven = $('.identificacion').text();  
        cargarIndicadorClientesNuevos($co_ven, 'NO', 'NO', 'SI', '4');
    }

       $('#estatusIndicadores').html("Año anterior");

});





if ($('.modalPagoFacturas_reporte').length) {
  // Tipo de cambio
  let exchangeRate = parseFloat($('#rate').data('rate')) || 1;
  
  // Guardar el valor original del monto calculado
  let montoCalculadoOriginal = $('#monto_calculado').data('saldo');
  let montoTemporal = montoCalculadoOriginal; // Variable temporal para almacenar cambios
  
  console.log('Monto original:', montoCalculadoOriginal);
  console.log('Tasa:', exchangeRate);

   $('#facturasSaldoBs').text((montoCalculadoOriginal*exchangeRate).toFixed(2));
    $('#monto_calculado').val(montoCalculadoOriginal);
     $('#monto_calculado_bs').val((montoCalculadoOriginal*exchangeRate).toFixed(2));



  // Validación para solo números reales
  $('#pesos, #dollars').on('input', function() {
      let validValue = $(this).val().replace(/[^0-9.]/g, '');
      let parts = validValue.split('.');
      if (parts.length > 2) {
          validValue = parts[0] + '.' + parts.slice(1).join('');
      }
      $(this).val(validValue);
  });

  // Función para actualizar el monto mostrado
  const actualizarMontoMostrado = () => {
      $('#monto_calculado').val(montoTemporal);
      $('#monto_calculado_bs').val((montoTemporal*exchangeRate).toFixed(2));
  };

  // Conversión de pesos a dólares
  $('#pesos').on('input', function() {
      let pesosValue = parseFloat($(this).val());
      
      if (!isNaN(pesosValue)) {
          let dollarsValue = pesosValue / exchangeRate;
          $('#dollars').val(dollarsValue.toFixed(2));
          
          // Actualizar el monto temporal
          montoTemporal = montoCalculadoOriginal - dollarsValue;
      } else {
          $('#dollars').val('');
          // Restaurar el monto original cuando no hay valor
          montoTemporal = montoCalculadoOriginal;
      }
      
      actualizarMontoMostrado();
  });

  // Conversión de dólares a pesos
  $('#dollars').on('input', function() {
      let dollarsValue = parseFloat($(this).val());
      
      if (!isNaN(dollarsValue)) {
          let pesosValue = dollarsValue * exchangeRate;
          $('#pesos').val(pesosValue.toFixed(2));
          
          // Actualizar el monto temporal
          montoTemporal = montoCalculadoOriginal - dollarsValue;
      } else {
          $('#pesos').val('');
          // Restaurar el monto original cuando no hay valor
          montoTemporal = montoCalculadoOriginal;
      }
      
      actualizarMontoMostrado();
  });

  // Inicializar con el valor original
  actualizarMontoMostrado();
}


if ($('.modalPagoAdelantos').length) {
  // Tipo de cambio
  let exchangeRate = parseFloat($('#rate').data('rate')) || 1;
  
  // Validación para solo números reales
  $('#pesos, #dollars').on('input', function() {
      let validValue = $(this).val().replace(/[^0-9.]/g, '');
      let parts = validValue.split('.');
      if (parts.length > 2) {
          validValue = parts[0] + '.' + parts.slice(1).join('');
      }
      $(this).val(validValue);
  });

  // Conversión de pesos a dólares
  $('#pesos').on('input', function() {
      let pesosValue = parseFloat($(this).val());
      
      if (!isNaN(pesosValue)) {
          let dollarsValue = pesosValue / exchangeRate;
          $('#dollars').val(dollarsValue.toFixed(2));
      } else {
          $('#dollars').val('');
      }
  });

  // Conversión de dólares a pesos
  $('#dollars').on('input', function() {
      let dollarsValue = parseFloat($(this).val());
      
      if (!isNaN(dollarsValue)) {
          let pesosValue = dollarsValue * exchangeRate;
          $('#pesos').val(pesosValue.toFixed(2));
      } else {
          $('#pesos').val('');
      }
  });
}

$('.btnConfirmarPago').on('click', function (e) {
  
  e.preventDefault();
  Swal.fire({
     title: '¿Deseas confirmar?',
        text: "Tenga en cuenta que está confirmando los pagos recibidos, los mismos estarán sometidos a una revisión por parte del departamento de crédito y cobranza.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          var $fact_num = $('.facturas_cancelar_filtro').text(),
     
          $co_cli = $('.facturas_cliente_codigo').val(),   
          $cli_des = $('.facturas_cliente').val(),
          $monto_cob = $('.totalAcumulado').text(),
          $ven_des = $('.user-name').text()
          console.log($fact_num);
          if (($fact_num != '') ) { 

     
             var tipo = 1;
             var accion = 1; 
             var datos =2;
                 $.ajax({
                     url: '../admin/index.php?action=pago', 
                     type:'POST',
                     data:{ven_des:$ven_des,monto_cob:$monto_cob,cli_des:$cli_des,co_cli :$co_cli,fact_num:$fact_num,tipo:tipo,accion:accion,datos:datos},
                     success:function(response){
                    //alert(response);
                       var i = 0;
                       var tope =response.length;   
                     //  console.log(tope);                 
                         if(tope == 1){ 
                              
                           Swal.fire({
                             icon: 'success',
                             title: 'Bien...',
                             text: 'Reporte de pago enviado exitosamente...'
                           
                           }),                               
                           
                          redireccionar('index.php?view=cobros');
                         } 
                         if(tope == 2){
                       
                           Swal.fire({
                             icon: 'error',
                             title: 'Oops...',
                             text: 'Ha ocurrido un error!'
                           
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

$('.btnActualiarCliente').on('click', function (e) {
  
        let cli_telefono = $('#cli_telefono').val();     
        let cli_parroquia = $('#cli_parroquia').val();
        let cli_sector = $('#cli_sector').val();
        let cli_email = $('#cli_email').val();
        let co_cli = $('#co_cli').val();
        
        // Validar cada campo y preparar mensaje de error
        let errorMessage = '';
        
        if (cli_email == 0) {
          errorMessage += '<b>• Debes escribir el correo del cliente</b><br>';
        }
         if (cli_parroquia == 0) {
          errorMessage += '<b>• Debes seleccionar la parroquia</b><br>';
        }
        if (cli_telefono == 0) {
          errorMessage += '<b>• Debes escribir el número de telefono<br>';
        }
        if (cli_sector == 0) {
          errorMessage += '<b>• Debes escribir la ciudad</b><br>';
        }
        
        if (errorMessage === '') {
          
          e.preventDefault();
             Swal.fire({
          title: '¿Deseas actualizar?',
              text: "Tenga en cuenta que esta actualizado los datos del cliente.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si',
              cancelButtonText: 'No'
            }).then((result) => {
              if (result.isConfirmed) {           
              
          
                  var tipo = 1;
                  var accion =2; 
                  var datos =2;
                      $.ajax({
                          url: '../admin/index.php?action=cliente', 
                          type:'POST',
                          data:{cli_telefono:cli_telefono,cli_parroquia:cli_parroquia,cli_sector:cli_sector,cli_email:cli_email,tipo:tipo,accion:accion,datos:datos},
                          success:function(response){
                          alert(response);
                            var i = 0;
                            var tope =response.length;   
                          //  console.log(tope);                 
                              if(tope == 1){ 
                                    
                                Swal.fire({
                                  icon: 'success',
                                  title: 'Bien...',
                                  text: 'Datos del cliente actualizados correctamente.'
                                
                                })                               
                                
                                //redireccionar('index.php?view=pedidos&s=0');
                              } 
                              if(tope == 2){
                            
                                /*Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Ha ocurrido un error en la edición de los datos!'
                                
                                })*/
                                // console.log(response)
                              
                              }
                              
                          }
                      });
              
      
       
        }
      })


        } else {

          // Mostrar mensaje de error con los campos faltantes
          Swal.fire({
            icon: 'error',
            title: 'Campos requeridos',
            html: 'Faltan los siguientes datos:<br>' + errorMessage,
          });


          $(".modalClientes").modal("show");
        }

  /*
  e.preventDefault();
  Swal.fire({
     title: '¿Deseas actualizar?',
        text: "Tenga en cuenta que esta actualizado los datos del cliente.",
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
    
             var tipo = 1;
             var accion = 4; 
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
      */
});


$('#btnModalClientes').on('click', function (e) {

    $('#select2-basic-comboFormaPagoFiltros').val('0');
    $('#select2-basic-comboFacturacionFiltros').val('0');

    $('.comboClientesFiltros').empty(); 
    cargarComboClientesPrecio('.comboClientesFiltros');

    $('#modalClientes').modal('show') ;   

});

$('.btnGuardarVisita').on('click', function (e) {
  
  e.preventDefault();
  Swal.fire({
     title: '¿Deseas confirmar?',
        text: "Tenga en cuenta que está confirmando los pagos recibidos",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
           var valores = $('.comboLineas').val();
            var textos = $('.comboLineas').find('option:selected').map(function() {
                return $('.comboLineas').text();
            }).get();
        
       
          if (($fact_num != '') ) { 

            //console.log('anulare pedido 2');
     
             var tipo = 1;
             var accion = 1; // anular pedido
             var datos =2;
                 $.ajax({
                     url: '../admin/index.php?action=pago', 
                     type:'POST',
                     data:{ven_des:$ven_des,monto_cob:$monto_cob,cli_des:$cli_des,co_cli :$co_cli,fact_num:$fact_num,tipo:tipo,accion:accion,datos:datos},
                     success:function(response){
                    //alert(response);
                       var i = 0;
                       var tope =response.length;   
                     //  console.log(tope);                 
                         if(tope == 1){ 
                              
                           Swal.fire({
                             icon: 'success',
                             title: 'Bien...',
                             text: 'Reporte de pago enviado exitosamente...'
                           
                           }),                               
                           
                          redireccionar('index.php?view=cobros');
                         } 
                         if(tope == 2){
                       
                           Swal.fire({
                             icon: 'error',
                             title: 'Oops...',
                             text: 'Ha ocurrido un error!'
                           
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


$('.cargarDataClientesAltos').on('click', function (e) {
  
  var $finicio = $('.finicioClientesAltos').val();
  var $ffinal = $('.ffinalClientesAltos').val();
 
  if(($('.finicioClientesAltos').val().length == 0) || ($('.ffinalClientesAltos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   
    cargarTablaTopMasMenosPagos($finicio,$ffinal,'1');
  
    $('#filtroClientesAltos').modal('hide')
  }
});


$('.cargarDataClientesBajos').on('click', function (e) {

  var $finicio = $('.finicioClientesBajos').val();
  var $ffinal = $('.ffinalClientesBajos').val();

  if(($('.finicioClientesBajos').val().length == 0) || ($('.ffinalClientesBajos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{

    cargarTablaTopMasMenosPagos($finicio,$ffinal,'0');
  
    $('#filtroClientesBajos').modal('hide')
  }
});

$('.cargarDataArticuloFoco').on('click', function (e) {
 
  var $finicio = $('.finicioMasVendidos').val();
  var $ffinal = $('.ffinalMasVendidos').val();

  if(($('.finicioMasVendidos').val().length == 0) || ($('.ffinalMasVendidos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{

    cargarDataArticuloFoco($finicio,$ffinal);
  
    $('#filtroArticulosFoco').modal('hide')
  }   
  });


  $('.cargarDataArticuloVolumen').on('click', function (e) {
 
    var $finicio = $('.finicioMasVolumen').val();
    var $ffinal = $('.ffinalMasVolumen').val();
    var $co_ven = $('.identificacion').text();  
  
    if(($('.finicioMasVolumen').val().length == 0) || ($('.ffinalMasVolumen').val().length == 0)){ 
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Debes elegir siempre Fecha de Inicio y Final!'
      
      })
    }else{
  
      cargarDataArticuloVolumen($co_ven,'NO',$finicio,$ffinal);
    
      $('#filtroArticulosVolumen').modal('hide')
    }   
    });

$('.cargarDataVentasPorDia').on('click', function (e) {
  var $finicio = $('.finicio').val();
  var $ffinal = $('.ffinal').val();
  if(($('.finicio').val().length == 0) || ($('.ffinal').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   
    cargarDataVentasxDia($finicio,$ffinal);
  
    $('#filtroVentasMes').modal('hide')
  }   
});

$('.cargarDataCobrosMes').on('click', function (e) {

  var $finicio = $('.finicio').val();
  var $ffinal = $('.ffinal').val();

  if(($('.finicio').val().length == 0) || ($('.ffinal').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   // console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarDataCobrosMes($finicio,$ffinal);
  
    $('#modals-slide-in').modal('hide')
  }   
  });

$('.cargarDataMasVendidos').on('click', function (e) {

  var $finicio = $('.finicioMasVendidos').val();
  var $ffinal = $('.ffinalMasVendidos').val();
 
  if(($('.finicioMasVendidos').val().length == 0) || ($('.ffinalMasVendidos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   
    cargarGraficoTopMes($finicio,$ffinal,'1');
  
    $('#filtroMasVendidos').modal('hide')
  }
});

$('.cargarDataMenosVendidos').on('click', function (e) {
 
  var $finicio = $('.finicioMenosVendidos').val();
  var $ffinal = $('.ffinalMenosVendidos').val();
  
  if(($('.finicioMenosVendidos').val().length == 0) || ($('.ffinalMenosVendidos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{

    cargarGraficoTopMes($finicio,$ffinal,'0');
  
    $('#filtroMenosVendidos').modal('hide')
  }
});
  

$('.cargarDataMayorUtilidad').on('click', function (e) {
 
  var $finicio = $('.finicioMayorUtilidad').val();
  var $ffinal = $('.ffinalMayorUtilidad').val();
 
  if(($('.finicioMayorUtilidad').val().length == 0) || ($('.ffinalMayorUtilidad').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   
    cargarGraficoTopMayorMenorUtil($finicio,$ffinal,'1');
  
    $('#filtroMayorUtilidad').modal('hide')
  }
});

$('.cargarDataMenorUtilidad').on('click', function (e) {
 
  var $finicio = $('.finicioMenorUtilidad').val();
  var $ffinal = $('.ffinalMenorUtilidad').val();
 
  if(($('.finicioMenorUtilidad').val().length == 0) || ($('.ffinalMenorUtilidad').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   
    cargarGraficoTopMayorMenorUtil($finicio,$ffinal,'0');
  
    $('#filtroMenorUtilidad').modal('hide')
  }
});

$('.cargarDataClientesAltos').on('click', function (e) {
 
  var $finicio = $('.finicioClientesAltos').val();
  var $ffinal = $('.ffinalClientesAltos').val();
  
  if(($('.finicioClientesAltos').val().length == 0) || ($('.ffinalClientesAltos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   
    cargarTablaTopMasMenosClientes($finicio,$ffinal,'1');
  
    $('#filtroClientesAltos').modal('hide')
  }
});


$('.cargarDataClientesBajos').on('click', function (e) {
 
  var $finicio = $('.finicioClientesBajos').val();
  var $ffinal = $('.ffinalClientesBajos').val();
  
  if(($('.finicioClientesBajos').val().length == 0) || ($('.ffinalClientesBajos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    
    cargarTablaTopMasMenosClientes($finicio,$ffinal,'0');
  
    $('#filtroClientesBajos').modal('hide')
  }
});

if ($('.tablaTopMasClientes').length) {
  
  cargarTablaTopMasMenosClientes('NO','NO','1');
}
if ($('.tablaTopMenosClientes').length) {
 
  cargarTablaTopMasMenosClientes('NO','NO','0');
}

if ($('.topMes').length) {
  cargarGraficoTopMes('NO','NO','1');
}

if ($('.topMes').length) {
  cargarGraficoTopMes('NO','NO','1');
}




if ($('.topMesUnidadesMenos').length) {
  cargarGraficoTopMes('NO','NO','0');
}

if ($('.topMayorUtilidad').length) {

  cargarGraficoTopMayorMenorUtil('NO','NO','1');
}
if ($('.topMenorUtilidad').length) {
 
  cargarGraficoTopMayorMenorUtil('NO','NO','0');
}

if ($('.chartdiv_dashboard_1').length) {

  estadisticasMes_tablero();
}
if ($('.chartdiv_dashboard_2').length) {

  estadisticasMes_tablero_linea();
}
if ($('#indicadores').length) {
  $('#indicadores').ready(function() {
    var $co_ven = $('.identificacion').text();
    //console.log($co_ven);
    graficoFacturaciones($co_ven,'NO','NO');
    
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

if ($('.m_pagos').length) {
  resaltarMenu('.i_pagos');
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

if ($('.m_visitas_cantidato').length) {
  resaltarMenu('.i_visitas_candidato');
}


if ($('.m_reportexva').length) {
  resaltarMenu('.i_reportexva');
}

if ($('.m_reportexvl').length) {
  resaltarMenu('.i_reportexvl');
}



/*if ($('.user2').length) {  // revisar tiempo de inactividad
  setInterval(chequearSession, 60000);

}*/

if (document.querySelector('.localizacion')) {
  const getLocation = async () => {
    if (!('geolocation' in navigator)) {
      console.error('Geolocation is not supported by your browser');
      return;
    }

    try {
      const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
      });

      const { latitude: latitud, longitude: longitud } = position.coords;
      
      document.querySelector('.lat').textContent = latitud;
      document.querySelector('.lon').textContent = longitud;
      
    } catch (error) {
      console.error('Error getting location:', error.message);
      // Handle errors (e.g., permission denied, timeout)
    }
  };

  getLocation();
}

if ($('.comboLineas').length) {  
 cargarDataComboLineas('.comboLineas', 1);
}


if ($('#comboClientes').length) {
  cargarDataComboFiltros('.comboClientes', 1);
}


if ($('#comboClientes').length) {
  cargarDataComboFiltros('.comboClientes', 1);
}


if ($('.content-body').length) {  

  //cargarDataEmpresaDetalles();
  // REFACTORIZAR ESTO DEV. JORGE FLORES
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
   // console.log("Pulse pedir");
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


  cargarDataFacturas('NO','NO','NO','NO');

  cargarDataCuentasPorCobrar();
  cargarDataCobrosMes('NO','NO');
  cargarDataVisitas();
  cargarDataClientesVisitas();
  cargarDataAprobaciones(0,'NO');

  cargarDataCobros('NO','NO');

  cargarDataPagosRealizados();

  if ($('.reportexva').length) {

    estadisticasMes('NO');
    cargarDataMeses('NO');

  }

  if ($('.reportexvl').length) {

    estadisticasMesLinea('NO');
    cargarDataMesesLinea('NO');

  }
// listar clientes nos facturados



$('.anularPedidoCarrito').on('click', function (e) { 
  setSessionData('datosCLiente', {
    cliente_des: '0',
    tipo_precio: '0',
    cliente_facturacion: '0',
    cliente_forma: '0',
    cliente_status: 0

});
    anularPedidoCarrito();    
});


$('.cargarArticulos').on('click', function (e) {
  var $lineas = $('.comboTipoPrecios').val();
  //console.log($categorias);
 // categorias pasan a ser filtradas por co_lin
  
      if($lineas!='NO'){
       
        cargarDataArticulos($lineas);
          $('#modals-slide-in').modal('hide')
    
          
      }else{
        cargarDataArticulos('NO');
          $('#modals-slide-in').modal('hide')
      }

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
/*
$('.comboLineas').on('change', function () {
  var $filtro = $('.comboLineas').val();
  if($filtro==0){
    $('.ecommerceProducts').empty();
    paginar(1,1);
  }else{
    $('.ecommerceProducts').empty();
    cargarDataProductos($filtro,1);
  }
 
  
}); */

 

$('.btnSeleccionarCliente').on('click', function (e) {
  
        let cli_precio = $('.comboClientesFiltros').val();

        let cli_des = $('select[name="comboClientesFiltros"] option:selected').text();
        let co_cli = $('.comboClientesFiltros').find('option:selected').data('cocli');
        let cli_facturacion = $('.comboFacturacionFiltros').val();
        let cli_pago = $('.comboFormaPagoFiltros').val();
        
        // Validar cada campo y preparar mensaje de error
        let errorMessage = '';
        
        if (cli_precio == 0) {
          errorMessage += '<b>• Debes seleccionar un cliente</b><br>';
        }
        if (cli_facturacion == 0) {
          errorMessage += '<b>• Debes seleccionar un tipo de facturación</b><br>';
        }
        if (cli_pago == 0) {
          errorMessage += '<b>• Debes seleccionar un método de pago</b><br>';
        }
        
        if (errorMessage === '') {
          // Todos los campos están seleccionados
          var datos ='01';
          var cuenta = 0;
          contarRegistros(datos).then(
            function(datosDevueltos){
              cuenta= datosDevueltos[0].co_art;
            $('.search-results').html(cuenta);
          }, function(errorLanzado){
             console.log(errorLanzado);
        });
        setSessionData('datosCLiente', {
          cliente_des: '0',
          tipo_precio: '0',
          cliente_facturacion: 0,
          cliente_forma: 0,
          cliente_status: 0

      });
          anularPedidoCarrito(1);    
          $(".modalClientes").modal("hide");

        
          setSessionData('datosCLiente', {
            cliente_des: cli_des,
            co_cli: co_cli,
            tipo_precio:cli_precio,
            cliente_facturacion: Number(cli_facturacion),
            cliente_forma:Number(cli_pago),
            cliente_status: 1

        });
          $('.cliente_des').html(cli_des);
         // seleccionarCliente(cli_des, cli_precio, cli_facturacion, cli_pago);
          $('.ecommerceProducts').empty();
       
          paginar(1,1,cli_precio,cli_facturacion,cli_pago);         
           
          $('#shop-search').removeAttr('disabled');
          $('#search-code').prop('disabled', false);  
          $('#paginationStatus').removeClass('d-none');
        } else {
          // Mostrar mensaje de error con los campos faltantes
          Swal.fire({
            icon: 'error',
            title: 'Campos requeridos',
            html: 'Faltan los siguientes datos:<br><br>' + errorMessage,
          });
          $(".modalClientes").modal("show");
        }
});

$('.comboClientesPagos').on('change', function () {
  var $co_cli = $('.comboClientesPagos').val();

     if($co_cli != '0' ){
      $('#pagos').attr("style","display:");     
      $('#busqueda').hide();
      $('#pagos').removeClass('col-lg-8').addClass('col-lg-12');
      cargarDataPagos($co_cli);     
    
  }else{

    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir el tipo de documento!'
    
    })

  }
 
   
  
});   
/*
$('.comboClientesFactura').on('change', function () {
  var $co_cli = $('.comboClientesFactura').val();
  var $tipo  = $('.cmbTipoDocumento').val();
  if($tipo != 0 ){
    if($tipo == 1 ){
      $('#cobros').attr("style","display:");
      $('#adelantos').attr("style","display:none");     
      $('#busqueda').hide();
      $('#adelantos, #cobros').removeClass('col-lg-8').addClass('col-lg-12');
      cargarDataFacturas($co_cli);
      
    }else{  
      $('#cobros').attr("style","display:none");
      $('#adelantos').attr("style","display:");
      $('#busqueda').hide();
      $('#adelantos, #cobros').removeClass('col-lg-8').addClass('col-lg-12');
      cargarDataAdelantos($co_cli); 
    }
  }else{

    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir el tipo de documento!'
    
    })

  }
 
   
  
});  */ 

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
        $('.foto').attr("style","display:");     
      }
      if((elegido=='DEP') || (elegido=='CH')){
        $('.banco').attr("style","display:");
        $('.cuenta').attr("style","display:");
        $('.referencia').attr("style","display:");
        $('.caja').attr("style","display:none"); 
        $('.foto').attr("style","display:");             
      }

      if(elegido=='NO'){
        $('.banco').attr("style","display:none");
        $('.cuenta').attr("style","display:none");
        $('.caja').attr("style","display:none"); 
        $('.referencia').attr("style","display:none");
        $('.foto').attr("style","display:none");          
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


$('.search-code').on('click', function (e) { 
 
  let $filtro = $('.search-product').val().trim();
  let $filtro2 = 0;
  //console.log($filtro2);
  if(!$filtro ==""){
    if(!$filtro2 =="0"){

    //console.log('con algo');
    $('.ecommerceProducts').empty();

    const cliente = getSessionData('datosCLiente');
    var tipo_precio = cliente.tipo_precio;
    var facturacion = cliente.cliente_facturacion;
    var pago =cliente.cliente_forma;

    console.log(tipo_precio);
    console.log(facturacion);     
    console.log(pago);
   
    cargarDataProductos($filtro,2,tipo_precio,facturacion,pago);


    }else{
      // cargar filtro con las 2 variables
      let $filtroCompuesto = $filtro+'/'+$filtro2;
    $('.ecommerceProducts').empty();

    const cliente = getSessionData('datosCLiente');
    var tipo_precio = cliente.tipo_precio;
    var facturacion = cliente.cliente_facturacion;
    var pago = cliente.cliente_forma;

    console.log(tipo_precio);
    console.log(facturacion);
    console.log(pago);

    cargarDataProductos($filtro,2,tipo_precio,facturacion,pago);
    }
  }else{
    $('.ecommerceProducts').empty();
    const cliente = getSessionData('datosCLiente');
    let tipo_precio = cliente.tipo_precio;
    let facturacion = cliente.cliente_facturacion;
    let pago =  cliente.cliente_forma;

    console.log(tipo_precio);
    console.log(facturacion);
    console.log(pago);
    
    paginar(1,1,tipo_precio,facturacion,pago);         
   
  }
})





if ($('.cuentasPorCobrar').length) {  
  cuentasPorCobrar();

}

if ($('.totalAcumulado').length) {
 
  estadoCuentaPagosRealizados();

}

/*if ($('.search-results').length) {
  var datos ='01';
  var cuenta = 0;
  contarRegistros(datos).then(
    function(datosDevueltos){
      cuenta= datosDevueltos[0].co_art;
    $('.search-results').html(cuenta);
  }, function(errorLanzado){
     console.log(errorLanzado);
});

}*/
// Paginacion del grid de articulos (pedido)
 
if ($('.pagination-pedido').length) {
  var datos ='01';
  var cuenta = 0;
  var articulosxpagina=$('.NUM_ITEMS_BY_PAGE').text();
  const cliente = getSessionData('datosCLiente');
  if (cliente) {
    var clienteStatus =cliente.cliente_status;
  }else{
    console.log('No tengo datos en el Localstorage');
  }
 

  //console.log(clienteStatus);
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
            
          if(clienteStatus==1){
            const cliente = getSessionData('datosCLiente');
            let tipo_precio = cliente.tipo_precio;
            let facturacion = cliente.cliente_facturacion;
            let pago =  cliente.cliente_forma;
            $('.cliente_des').html(cliente.cliente_des);
            paginar(page,1,tipo_precio,facturacion,pago); 

            $('.pagination').find('li').addClass('page-item');
            $('.pagination').find('a').addClass('page-link');
            $('#shop-search').removeAttr('disabled');
            $('#shop-code').removeAttr('disabled');
            $('#paginationStatus').removeClass('d-none');

          }else{           

            $('#paginationStatus').addClass('d-none');
            $('#shop-search').attr('disabled', 'disabled');
            $('#search-code').attr('disabled', 'disabled');
            $("#modalClientes").modal("show");

          }
           
          }
        });
      }
     
  }, function(errorLanzado){
    // console.log(errorLanzado);
});

}
// Paginacion del grid de articulos (carrtito de compra)
         
if ($('.pagination-cart').length) {
  contarRegistroCart(); 
}
// Paginacion del grid de articulos (carrtito de compra)

/// Cargar los combos de la aplicacion
if ($('.comboClientesFactura').length) {
  cargarComboClientesCobro('.comboClientesFactura');

}

if ($('.comboClientesFacturaAdelantar').length) {
  cargarComboClientesCobro('.comboClientesFacturaAdelantar');

}


if ($('.comboClientesPagos').length) {
  cargarComboClientes('.comboClientesPagos');

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

if ($('.comboCategorias').length) {
  cargarComboCategorias('.comboCategorias');
}

if ($('.comboTipoPrecios').length) {
  cargarComboTiposPrecios('.comboTipoPrecios');
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
  cargarComboClientesData('.comboClientes');
}

if ($('.comboClientesFiltros').length) {
  cargarComboClientesPrecio('.comboClientesFiltros');
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

$('.gestionPagos').on('click', function () {
  //console.log('guardare');
  
  var $facturas_cancelar = $('.facturas_cancelar').val(),
    $facturas_cliente_codigo = $('.facturas_cliente_codigo').val(),
    $facturas_cliente_2 = $('.facturas_cliente_2').val(),
    $facturas_saldo = $('.facturas_saldo').val(),
    $facturas_saldo_bs = $('.facturas_saldo_bs').val()

    $(location).attr('href','index.php?view=reportepago&facturas_cancelar='+
      $facturas_cancelar+'&facturas_cliente_codigo='+$facturas_cliente_codigo+
      '&facturas_cliente_2='+$facturas_cliente_2+'&facturas_saldo='+$facturas_saldo+'&facturas_saldo_bs='+$facturas_saldo_bs);        
          

});

  $('.btnPagarFacturas').on('click', function () {

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
    $monto_cob_bs = $('.facturas_monto_bs').val(),
    $facturas =  $('.facturas_cancelar').val(),
    $forma_pag =  $('.facturas_metodo').val(), 
    $co_ban =  $('.facturas_banco').val(), 
    $co_cuenta =  $('.facturas_cuenta').val(),
    $co_caja =  $('.facturas_caja').val(),
  // $moneda =  $('.facturas_moneda').val(),
    $facturas_saldo =  $('.facturas_saldo').val(),
    $facturas_saldo_bs =  $('.facturas_saldo_bs').val(),
    $moneda = "0",
    files = $('.facturas_documento')[0].files[0],
    $ref_ban =  $('.facturas_referencia').val(),
    ven_des = $('.user-name').text()

    
  if (($monto_cob != '') && ($monto_cob_bs != '') && ($fec_emis != '') &&  ($forma_pag != 'NO') &&  ($moneda != 'NO') ) {       
        if($forma_pag == 'EF'){
            if($co_caja!='NO'){
            

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
                    var moneda_des = "0";

                      $co_ban ='0';
                      $co_cuenta='0';
                      $ref_ban='0';
                      var tipo = 1;
                      var accion = 1;
                      var datos =1;
                      formData.append('file',files); 
                          $.ajax({
                            url: '../admin/index.php?action=pago&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                            '&monto_cob_bs='+$monto_cob_bs+'&monto_cob='+$monto_cob+'&facturas='+$facturas+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
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
                                /* 
                                $(location).attr('href','index.php?view=reportepago&facturas_cancelar='+
                                  $facturas+'&facturas_cliente_codigo='+$co_cli+
                                  '&facturas_cliente_2='+$cli_des+'&facturas_saldo='+$facturas_saldo+'&facturas_saldo_bs='+$facturas_saldo_bs);  
                                */

                                cargarDataPagosRealizados();
                                estadoCuentaPagosRealizados();
                                  $(".modalPagoFacturas").modal("hide");
                                  $('#addNewAddressForm')[0].reset();
                                    $('.select2').val('NO').trigger('change');
                                    $('.facturas_metodo').val('NO').trigger('change');
                                    $('.banco, .cuenta, .referencia, .caja').hide();
                                    $('.monto_calculado').val($('.monto_calculado').data('saldo'));
                                    $('.monto_calculado_bs').val('');
                                    $('.flatpickr-basic').val('').removeAttr('value');
                                }else{
                              Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No hemos podido registrar su pago, verifique e intente nuevamente!'
                              
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
                text: 'Debes elegir la caja asignada para el pago!'
              
              })
            }

        }else{

          if(($co_ban!='NO') && ($monto_cob_bs != '') && ($monto_cob != '') && ($co_cuenta!='NO')  && ($ref_ban!='') ){
          
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

                var   moneda_des = "0";

                  $co_caja='0';
                  var tipo = 1;
                  var accion = 1;
                  var datos =1;
                  formData.append('file',files);
                      $.ajax({
                        url: '../admin/index.php?action=pago&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                        '&monto_cob_bs='+$monto_cob_bs+'&monto_cob='+$monto_cob+'&facturas='+$facturas+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
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
                            /* $(location).attr('href','index.php?view=reportepago&facturas_cancelar='+
                              $facturas+'&facturas_cliente_codigo='+$co_cli+
                              '&facturas_cliente_2='+$cli_des+'&facturas_saldo='+$facturas_saldo+'&facturas_saldo_bs='+$facturas_saldo_bs);  */      
                              cargarDataPagosRealizados();
                              estadoCuentaPagosRealizados();
                                  $(".modalPagoFacturas").modal("hide");
                                  $('#addNewAddressForm')[0].reset();
                                  $('.select2').val('NO').trigger('change');
                                  $('.facturas_metodo').val('NO').trigger('change');
                                  $('.banco, .cuenta, .referencia, .caja').hide();
                                  $('.monto_calculado').val($('.monto_calculado').data('saldo'));
                                  $('.monto_calculado_bs').val('');
                                  $('.flatpickr-basic').val('').removeAttr('value');
                            
                            }
                              if(response=='3'){
                                  Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'El numero de referencia que ha proporcionado ya existe, verifique e intente nuevamente!'
                                  
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

$('.btnPagarAdelanto').on('click', function () {

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


  
  var $co_cli = $('.comboClientesFacturaAdelantar').val(),       
  $fec_emis = $('.facturas_fecha').val(),
  $cli_des =  $('.comboClientesFacturaAdelantar option:selected').text(),
  $monto_cob = $('.facturas_monto').val(),
  $monto_cob_bs = $('.facturas_monto_bs').val(),
  $forma_pag =  $('.facturas_metodo').val(), 
  $co_ban =  $('.facturas_banco').val(), 
  $co_cuenta =  $('.facturas_cuenta').val(),
  $co_caja =  $('.facturas_caja').val(),

  //$moneda =  $('.facturas_moneda').val(),
  $moneda='0',
  files = $('.facturas_documento')[0].files[0],
  $ref_ban =  $('.facturas_referencia').val(),
  ven_des = $('.user-name').text() 
 // console.log($fec_emis);
 // console.log($forma_pag);

  
if (($monto_cob != '') && ($co_cuenta != '') && ($fec_emis != '') &&  ($forma_pag != 'NO') &&  ($moneda != 'NO') ) {       
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
              
                    var banco_des ="no";
                    var cuenta_des="no";
                    var caja_des = $('.facturas_caja option:selected').html().trim();
                    var moneda_des = "0";

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
                          '&datos='+datos+'&cli_des='+$cli_des+'&ven_des='+ven_des+'&banco_des='+banco_des+'&cuenta_des='+cuenta_des+'&caja_des='+caja_des+'&moneda_des='+moneda_des+'&monto_cob_bs='+$monto_cob_bs, 
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
                                $(location).attr('href','index.php?view=cobros');
                                
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
                                  
                var banco_des =$('.facturas_banco option:selected').html().trim();
                var cuenta_des=$('.facturas_cuenta option:selected').html().trim();
                var caja_des = "no";            
                var moneda_des = "0";

                var tipo = 1;
                var accion = 1;
                var datos =1;
                formData.append('file',files);
                    $.ajax({
                      url: '../admin/index.php?action=adelanto&moneda='+$moneda+'&co_cuenta='+$co_cuenta+'&ref_ban='+$ref_ban+'&co_cli='+$co_cli+'&fec_emis='+$fec_emis+
                      '&monto_cob='+$monto_cob+'&forma_pag='+$forma_pag+'&co_ban='+$co_ban+'&co_caja='+$co_caja+'&tipo='+tipo+'&accion='+accion+
                      '&datos='+datos+'&cli_des='+$cli_des+'&ven_des='+ven_des+'&banco_des='+banco_des+'&cuenta_des='+cuenta_des+'&caja_des='+caja_des+'&moneda_des='+moneda_des+'&monto_cob_bs='+$monto_cob_bs, 
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
                             $(location).attr('href','index.php?view=cobros');
                           
                          }   
                         if(response=='3'){
                                  Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'El numero de referencia que ha proporcionado ya existe, verifique e intente nuevamente!'
                                  
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

$('.btnRegistrarPedido').on('click', function () {

    const cliente = getSessionData('datosCLiente');
    var tipo_precio = cliente.tipo_precio;
    var facturacion = cliente.cliente_facturacion;
    var pago =cliente.cliente_forma;

    // Recoger todos los valores necesarios
    const formData = {
        saldo: $('.total3').text(),
        co_cli: $('.co_cli').val(),
        cli_des: $('.cli_des').val(),
        co_ven: $('.identificacion').text(),
        co_us: $('.co_us').text(),
        co_alma: $('.co_alma').text(),
        co_almaa: $('.almacen').text(), // Sub-almacen
        co_tran: $('.comboTransporte').val(),
        forma_pag: $('.comboFormasPago').val(),
        tipoFactura: $('.factura').val(),
        total_neto: $('.total3').text(),
        total_b: $('.subtotal3').text(),
        iva: $('.impuesto3').text(),
        observacion: $('.observacion').val() + ' - ' + $('.factura').val(),
        total_art: $('.totalArticulos3').text(),
        mont_comi: $('.mont_comi').val(),
        tipo_precio: tipo_precio,
        facturacion: facturacion,
        pago: pago
    };

    // Validaciones
    const errors = validateFormData(formData);
    
    if (errors.length > 0) {
        showValidationErrors(errors);
        return;
    }

    if (formData.mont_comi === 'NO') {
        Swal.fire({
            icon: 'error',
            title: 'Tipo de pago requerido',
            text: 'Debes seleccionar el tipo de pago correspondiente!'
        });
        $('.mont_comi').focus();
        return;
    }

    confirmOrderRegistration(formData);
});

// Funciones auxiliares
function validateFormData(data) {
    const errors = [];
    
    if (!data.saldo || data.saldo === '') errors.push('El saldo no puede estar vacío');
    if (data.co_cli === '0') errors.push('Debes seleccionar un cliente');
    if (data.co_ven === '0') errors.push('El vendedor no está definido');
    if (data.co_tran === '0') errors.push('Debes seleccionar un transporte');
    if (data.forma_pag === '0') errors.push('Debes seleccionar una forma de pago');
    if (data.observacion.length > 60) errors.push('La observación no puede exceder los 60 caracteres');
    
    return errors;
}

function showValidationErrors(errors) {
    let errorMessage = 'Por favor corrige los siguientes errores:<br><ul>';
    errors.forEach(error => {
        errorMessage += `<li>${error}</li>`;
    });
    errorMessage += '</ul>';
    
    Swal.fire({
        icon: 'error',
        title: 'Error en los datos',
        html: errorMessage
    });
}

function confirmOrderRegistration(formData) {
 


    Swal.fire({
        title: '¿Deseas registrar el pedido?',
        text: "Tenga en cuenta que realizará un pedido por los artículos seleccionados.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const total_bruto = parseFloat(formData.saldo) - parseFloat(formData.iva);
            const params = new URLSearchParams({
                action: 'pedido',
                co_us: formData.co_us,
                tipo: 1,
                accion: 1,
                datos: 1,
                saldo: formData.saldo,
                co_cli: formData.co_cli,
                cli_des: formData.cli_des,
                co_ven: formData.co_ven,
                co_alma: formData.co_alma,
                co_almaa: formData.co_almaa,
                co_tran: formData.co_tran,
                forma_pag: formData.forma_pag,
                total_bruto: total_bruto,
                total_neto: formData.total_neto,
                iva: formData.iva,
                tipoFactura: formData.tipoFactura,
                total_art: formData.total_art,
                mont_comi: formData.mont_comi,
                observacion: formData.observacion,
                tipo_precio: formData.tipo_precio,
                facturacion: formData.facturacion,
                pago: formData.pago
                
            });

            return fetch(`../admin/index.php?${params.toString()}`)
                .then(response => {
                    if (!response.ok) throw new Error(response.statusText);
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error en la solicitud: ${error}`);
                });
        }
    }).then(result => {
        if (result.isConfirmed) {
            handleRegistrationResponse(result.value);
        }
    });
}

function handleRegistrationResponse(responseCode) {
    const messages = {
        1: 'Se ha registrado su pedido',
        4: 'Se ha generado una orden de aprobación'
    };

    if (messages[responseCode]) {
 
      setSessionData('datosCLiente', {
        cliente_des: '0',
        tipo_precio: '0',
        cliente_facturacion: '0',
        cliente_forma: '0',
        cliente_status: 0

    });
        Swal.fire({
            title: messages[responseCode],
            html: 'Por favor, espere unos segundos mientras se registra su información.',
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => Swal.showLoading(),
            willClose: () => window.location = 'index.php?view=pedido'
        });

        // DEV. JORGE FLORES
    }
}

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

function cargarDataCandidatos(){
  if ($('#dataCandidatos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=CandidatosData&a=1&t=jm_candidatos_encuesta', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataCandidatos').attr("value",cadena);
  cargarTablaCandidatos();


});
  }
}

function cargarDataClientesVisitas(){
  if ($('#dataClientesVisitas').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=111&t=clientes', 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataClientesVisitas').attr("value",cadena);
  cargarTablaClientesVisitas();


});
  }
}



// Cargar Data de los clientes no facturados en el periodo
function cargarDataNoFacturados($co_ven,$finicio,$ffinal){
  if ($('#dataNoFacturados').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=78&t=factura&co_ven='+$co_ven+'&fechaI='+$finicio+'&fechaF='+$ffinal, 
}).done(function(data) { 
  var cadena = JSON.stringify(data);
  $('.dataNoFacturados').attr("value",cadena);

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

function cargarDataPagosRealizados(){
  if ($('#dataPagosRealizados').length) {    

     const $rango = $('.facturas_cancelar').val();   
    const $status ="";
   
 $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=99998&t=jm_reportar_pago&status='+$status+'&rango='+$rango, 
}).done(function(data) { 
  var cadena = JSON.stringify(data);
  $('.dataPagosRealizados').attr("value",cadena);  
  cargarTablaPagosRealizados();

});
  }
}

function cargarDataCobros($status,$rango){
  if ($('#dataCobros').length) {    
 $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=PagoRegData&a=99999&t=jm_reportar_pago&status='+$status+'&rango='+$rango, 
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataCobros').attr("value",cadena);  
  cargarTablaCobros();

});
  }
}

function cargarDataFacturas($co_cli,$filtro,$filtro2,$filtro3 ){
  //const $co_cli = 'NO';
  if ($('#dataFacturas').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=16&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro='+$filtro+'&filtro2='+$filtro2+'&filtro3='+$filtro3,
}).done(function(data) { 
 // console.log(data);
  var cadena = JSON.stringify(data);
  $('.dataFacturas').attr("value",cadena);
  cargarTablaFacturasCliente();


});
  }
}

function cargarDataPagos($co_cli){  
  if ($('#dataPagos').length) {   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=99999&c=FacturaData&t=factura&rango='+$co_cli+'&filtro=0',
  }).done(function(data) { 
 // console.log(data);
  var cadena = JSON.stringify(data);
  $('.dataPagos').attr("value",cadena);
  cargarTablaPagos();
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
    let $co_cli =$('#co_cli').val();   
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

// metodos para llenar las tablas

// metodos para llenar los combos



function cargarComboClientesCobro(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=155&t=factura', 
}).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {    
    
    $(combo).prepend('<option value = '+data[i].co_cli+'>'+data[i].cli_des+'</option>')
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
    }).done(function(data) { 
      var i = 0;
      var tope =data.length;
      for (var i = 0; i < tope; i++) {

        $(combo).prepend('<option value = '+data[i].co_cli+'>'+data[i].rif+'-'+data[i].cli_des+'</option>');
      
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
   $(combo).prepend('<option selected value="0">Seleccionar</option>');

  if ($(combo).length) {

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=999&t=cliente', 
}).done(function(data) { 

 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option data-cocli= "'+data[i].co_cli+'" value = '+data[i].tipo_precio+'>'+data[i].co_cli+' - '+data[i].cli_des+'</option>');
  
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

function graficoFacturaciones($co_ven,$finicio,$ffinal){
  cargarDataNoFacturados($co_ven,$finicio,$ffinal);    
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=32&t=facturas&co_ven='+$co_ven+'&fechaI='+$finicio+'&fechaF='+$ffinal, 
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

  const cliente = getSessionData('datosCLiente');
  let tipo_precio = cliente.tipo_precio;
  let facturacion = cliente.cliente_facturacion;
  let pago =  cliente.cliente_forma;


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
            data:{tipo_precio:tipo_precio,facturacion:facturacion,pago:pago,qty:$qty,co_art:$co_art,almacen:$almacen,tipo:tipo,accion:accion,datos:datos},
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
             /* Swal.fire({
                icon: 'success',
                title: 'Bien..',
                text: 'Se ha anulado el pedido del carrito por completo!'
              
              });*/
        

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
function cargarDataProductos(filtro, almacen, tipo_precio, facturacion, pago) {
    console.log('Parámetros:', { filtro, almacen, tipo_precio, facturacion, pago });

  $.ajax({
    type: "GET",    
     url: `../admin/index.php?action=combos&a=4&c=ArticuloData&t=art&filtro=${filtro}&almacen=${almacen}&tipo_precio=${tipo_precio}&facturacion=${facturacion}&pago=${pago}`,
  
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
      tipo_art =productos[i].tipo_art
      media =productos[i].media
      marca =productos[i].marca
      contenido=`<div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-4">
      <div class=" card ecommerce-card">  
          <div class="center-img p-3">
            <div class="item-img text-center" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                <img class="img-fluid card-img-top" src="${media}" alt="${co_art} - ${str}" style="max-height: 160px; width: auto; object-fit: contain;">
            </div>
        </div>
      <div class="card-body">
          <div class="item-wrapper">
              <div class="item-rating">
             <h6 class="item-price">Marca : ${marca}</h6>
              </div>
              <div>
                  <h6 class="item-price">Precio : ${pre}</h6>
              </div>
          </div>
          <h6 class="item-name">
              <a class="text-body" href="#">${str}-(${co_art}-(${uni}))</a>
              <span class="card-text">Disponible en Stock : <a href="#" class="company-name"> ${sto} -  ${tipo_art}</a></span>
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
        <button type="button" id="${co_art}"  onClick ="pedir('${co_art}','${almacen}')" class="btn btn-primary mt-1 btn-cart ${co_art} ${almacen}">
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

function paginar(pagina,almacen,tipo_precio,facturacion,pago){
  
//console.log(pagina);
  var dataString = 'page='+pagina+'&almacen='+almacen+'&tipo_precio='+tipo_precio+'&facturacion='+facturacion+'&pago='+pago;
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
      tipo_art =data[i].tipo_art
      media =data[i].media
      marca =data[i].marca
      contenido=`<div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-4">
      <div class="card ecommerce-card">    
      <div class ="center-img">
      <div class="item-img text-center">
     
            <img class="img-fluid card-img-top" src="${media}" alt="${co_art} - ${str}">
      </div>    
      </div>   
      <div class="card-body">
          <div class="item-wrapper">
              <div class="item-rating">
                 <h6 class="item-price">Marca : ${marca}</h6>
              </div>
              <div>
                  <h6 class="item-price">Precio ($): ${pre}</h6>
              </div>
          </div>
          <h6 class="item-name">
          <a class="text-body" href="#">${str}-(${co_art}-(${uni}))</a>
              <span class="card-text">Disponible en Stock : <a href="#" class="company-name"> ${sto} -  ${tipo_art}</a></span>
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
      marca =data[i].marca
      contenido=`<div class="col-4">
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

  //carrito16


  //carrito16
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
    marca =data[i].marca


   // console.log('Total iva de los articulos->'+ivaArt);

    contenido=`<div class="col-4 ">
    <div class="card ecommerce-card"> 
      <div class="card-body text-center">

        <div class="item-name">
          <h7 class="mb-0"><a href="#" class="text-body">${art_des}-(${co_art}-(${uni}))</a></h7>
          <h7 class="mb-0"><a href="#" class="text-body">Marca: ${marca}</a></h7>
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

function calcularDescuento(a) {
  let descuento = 0;
  
  switch (true) {
    case (a >= 300 && a <= 500):
      descuento = 2;
      break;
    case (a > 500 && a <= 2000):
      descuento = 3;
      break;
    case (a > 2000):
      descuento = 5;
      break;
    default:
      descuento = 0; // Para valores menores a 300
  }
  
  const montoDescuento = a * (descuento / 100);
  const total = a - montoDescuento;
  
  return {
    montoOriginal: a,
    porcentajeDescuento: descuento,
    montoDescuento: montoDescuento,
    totalAPagar: total
  };
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
   let descuento = 0;
   let leyenda='';


  let tipo_precio_descuento = $('.tipo_precio_descuento').val();
  let tipo_facturacion_descuento = $('.tipo_facturacion_descuento').val();
  if(tipo_precio_descuento==3){
        if(tipo_facturacion_descuento==1){
          if(totalGlobal2!=0){
              let a = total;
            switch (true) {
            case (a >= 300 && a <= 500):
                descuento = total*0.02;
                leyenda='2%';
              total = total -descuento;
          
              break;
            case (a > 500 && a <= 2000):
                  descuento = total*0.03;
                   leyenda='3%';
              total = total -descuento;
              break;
            case (a >= 2000):
                 descuento = total*0.05;
                  leyenda='5%';
              total = total -descuento;
            default:
              //descuento = 0; // Para valores menores a 300
          }
          }else{


             let a = total;
            switch (true) {
            case (a >= 300 && a <= 500):
                descuento = total*0.02;
                leyenda='2%';
              total = total -descuento;
          
              break;
            case (a > 500 && a <= 2000):
                  descuento = total*0.03;
                   leyenda='3%';
              total = total -descuento;
              break;
            case (a >= 2000):
                 descuento = total*0.05;
                  leyenda='5%';
              total = total -descuento;
            default:
              //descuento = 0; // Para valores menores a 300
          }
              
          }
        
         
         

        }else{
              let a = total;         
              switch (true) {
                case (a >= 300 && a <= 500):
                    descuento = total*0.02;
                    leyenda='2%';
                  total = total -descuento;
              
                  break;
                case (a > 500 && a <= 2000):
                      descuento = total*0.03;
                      leyenda='3%';
                  total = total -descuento;
                  break;
                case (a >= 2000):
                    descuento = total*0.05;
                      leyenda='5%';
                  total = total -descuento;
                default:
                  //descuento = 0; // Para valores menores a 300
              }
        }

 }

 $('.impuesto').html(totalGlobal2.toFixed(2));
 $('.impuesto2').html(totalGlobal2.toFixed(2));
 $('.impuesto3').html(totalGlobal2.toFixed(2));

  $('.descuento').html('('+leyenda+') '+descuento.toFixed(2));
  $('.descuento2').html('('+leyenda+') '+descuento.toFixed(2));
  $('.descuento3').html('('+leyenda+') '+descuento.toFixed(2));
  
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
  
  const cliente = getSessionData('datosCLiente');
  if (cliente) {
    $('#txtcli_des').val(cliente.cliente_des);
    $('#cli_des').val(cliente.cliente_des);
 
    $('#txtco_cli').val(cliente.co_cli);
    $('#co_cli').val(cliente.co_cli);
    let tipo = cliente.tipo_precio;
    if(tipo==1){
      $('.comboFormasPago').append('<option value="'+tipo+'">CREDITO 1</option>');    
    }
    if(tipo==2){
      $('.comboFormasPago').append('<option value="'+tipo+'">CREDITO 2</option>');    
    }
    if(tipo==3){
      $('.comboFormasPago').append('<option value="'+tipo+'">CONTADO</option>');    
    }
    if(tipo==4){
      $('.comboFormasPago').append('<option value="'+tipo+'">ESPECIAL</option>');    
    }

 



 
}

   
  
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


function estadoCuentaPagosRealizadosBTN(){ 
  let $rango =$('.facturas_cancelar_filtro').data('facturas');
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=99997&c=FacturaData&t=factura&rango='+$rango+'&status=0', 
}).done(function(data) {  
  var i = 0;
  var tope =data.length;
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {  
      let total_acumulado =  data[0].total_acumulado;    
    $('#totalAcumulado').html(total_acumulado);
    // Tipo de cambio
    let exchangeRate = parseFloat($('#rate').data('rate')) || 1;  
    // Guardar el valor original del monto calculado
    let  montoCalculadoOriginal= $('#monto_calculado').data('saldo');
    let restoPagos =montoCalculadoOriginal-total_acumulado;
    if(restoPagos ==0){

        $('#pesos').val((restoPagos*exchangeRate).toFixed(2));
        $('#dollars').val(restoPagos.toFixed(2));
        $('#btnModalAgregarPagos').attr('disabled', 'disabled');
        
      
    }else{

        $('#pesos').val((restoPagos*exchangeRate).toFixed(2));
        $('#dollars').val(restoPagos.toFixed(2));
        $('#btnModalAgregarPagos').removeAttr('disabled');

      
    }   
    
    }  
  }else{
  }
});
}


function estadoCuentaPagosRealizados(){ 
  let $rango =$('.totalAcumulado').data('facturas');
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=99997&c=FacturaData&t=factura&rango='+$rango+'&status=0', 
}).done(function(data) {  
  var i = 0;
  var tope =data.length;
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {  
      let total_acumulado =  data[0].total_acumulado;    
    $('#totalAcumulado').html(total_acumulado);
    // Tipo de cambio
    let exchangeRate = parseFloat($('#rate').data('rate')) || 1;  
    // Guardar el valor original del monto calculado
    let  montoCalculadoOriginal= $('#monto_calculado').data('saldo');
    let restoPagos =montoCalculadoOriginal-total_acumulado;
    if(restoPagos ==0){

        $('#pesos').val((restoPagos*exchangeRate).toFixed(2));
        $('#dollars').val(restoPagos.toFixed(2));
        $('#btnModalAgregarPagos').attr('disabled', 'disabled');
        $('#btnConfirmarPago').removeAttr('disabled');
        Swal.fire({
        icon: 'info',
        title: 'Vaya...',
        text: 'Ya has registrado el maximo monto de pagos a conciliar para la() factura(s) seleccionadas.'   
       })  
      
    }else{

        $('#pesos').val((restoPagos*exchangeRate).toFixed(2));
        $('#dollars').val(restoPagos.toFixed(2));
         $('#btnConfirmarPago').attr('disabled', 'disabled');
      $('#btnModalAgregarPagos').removeAttr('disabled');
      
    }   
    
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
}).done(function(data) {  
  var i = 0;
  var tope =data.length;
  var contenido ="";
  //console.log(lineas);
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
      $('.comboLineas').append('<option value="'+data[i].dato2+'">'+data[i].dato3+'</option>');    
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

function cargarDataComboLineas($combo,$filtro){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=25&c=ArticuloData&t=art', 
}).done(function(data) {  
  var i = 0;
  var tope =data.length;
  var contenido ="";
  if(tope>=1){   
    for (var i = 0; i < tope; i++) { 
      $($combo).append('<option value="'+data[i].dato2+'">'+data[i].dato3+'</option>');    
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


/*function chequearSession(){
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
}*/


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

//eliminar adelanto
function borrarAdelanto(id){
 // alert(id);
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
            text: 'Datos del adelanto eliminados con exito!.'            
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

/*function seleccionarCliente(cli_des,precio,dato1,dato2){
  
  var tipo = 1;
  var accion = 1;
  var datos =1;

  $.ajax({
    url: '../admin/index.php?action=cliente', 
    type:'GET',
    data:{tipo:tipo,accion:accion,datos:datos,cli_des:cli_des,precio:precio,facturacion:dato1,pago:dato2},
    success:function(response){
    $('.cliente_des').html(response);
    }
});


}*/


//eliminar la visita
function resaltarMenu(componente){
$(componente).addClass('active');
}


function estadisticasMes_tablero(){


  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=47&t=factura', 
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
//console.log(mesesData);
 //estadisticaDetallada(arrMeses,arrValores);
  graficoReporteXATablero(mesesData,'graficoXA');

}
});  

}

function estadisticasMes_tablero_linea(){  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=46&t=factura', 
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
//console.log(mesesData);
 //estadisticaDetallada(arrMeses,arrValores);
 graficoReporteXLTablero(mesesData,'graficoXL');

}
});  

}

function cargarGraficoTopMes($finicio,$ffinal,$estado){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=68&t=factura&finicio='+$finicio+'&ffinal='+$ffinal+'&estado='+$estado, 
  }).done(function(topVendidos) { 
  if($estado=='1'){
    console.log(topVendidos);
    if (topVendidos.length === 0){
      $('.chartdiv_top').empty();
    $('.topMes').html('<h4>No hay movimientos registrados en este rango o mès</h3>');
    $('.tablaTopVendidos').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMes').empty();
   $('.tablaTopVendidos').empty();
   
    var cadena = JSON.stringify(topVendidos);
    const valor0= topVendidos[0].dato2;
    const valor1= topVendidos[1].dato2;
    const valor2= topVendidos[2].dato2;
    const varlor3= topVendidos[3].dato2;
    const valor4= topVendidos[4].dato2;
  
  
  
  
    const articulo0= topVendidos[0].dato1;
    const articulo1= topVendidos[1].dato1;
    const articulo2= topVendidos[2].dato1;
    const articulo3= topVendidos[3].dato1;
    const articulo4= topVendidos[4].dato1;
  
  
    const utilidad0= topVendidos[0].dato3;
    const  utilidad1= topVendidos[1].dato3;
    const  utilidad2= topVendidos[2].dato3;
    const  utilidad3= topVendidos[3].dato3;
    const  utilidad4= topVendidos[4].dato3;
  
  
  
  
  let topVendidosPastel =[{
  'articulo' : articulo0,
  'valor' : valor0
  },
  {
  'articulo' : articulo1,
  'valor' :valor1
  },
  {
  'articulo' : articulo2,
  'valor' :valor2
  },
  {
  'articulo' : articulo3,
  'valor' :varlor3
  },
  {
  'articulo' : articulo4,
  'valor' :valor4
  }
  
  
  ];
  
  
  let topVendidosTabla =[{
    'responsive_id' : '',
    'articulo' : articulo0,
    'valor' : valor0,
    'utilidad' : utilidad0
    },
    {
      'responsive_id' : '',
    'articulo' : articulo1,
    'valor' :valor1,
    'utilidad' : utilidad1
    },
    {
      'responsive_id' : '',
    'articulo' : articulo2,
    'valor' :valor2,
    'utilidad' : utilidad2
    },
    {
      'responsive_id' : '',
    'articulo' : articulo3,
    'valor' :varlor3,
    'utilidad' : utilidad3
    },
    {
      'responsive_id' : '',
    'articulo' : articulo4,
    'valor' :valor4,
    'utilidad' : utilidad4
    }
  
    
    ];
    var contenido=""
    var tope =topVendidosTabla.length;
    for (var i = 0; i < tope; i++) {
      art_des=topVendidosTabla[i].articulo;
      total_art=topVendidosTabla[i].valor;
      util=topVendidosTabla[i].utilidad; 
  
   
   contenido=`<div class="transaction-item">
   <div class="d-flex">
   <img src="../app-assets/images/icons/unidad.png" class="rounded me-1" height="30" alt="Google Chrome">
       <div class="transaction-percentage">
           <h6 class="transaction-title">${art_des}</h6>
           <h5><strong>${total_art}</strong></h5>
       </div>
   </div>
   <div class="fw-bolder text-success">${util}%</div>
  </div>`;      
  $('.tablaTopVendidos').append(contenido);   
    }
  
  graficoTopMes(topVendidosPastel);
    }

  }else{
    if (topVendidos.length === 0){
      $('.chartdiv_Top_Menos_unidades').empty();
    $('.topMesUnidadesMenos').html('<h4>No hay movimientos registrados en este rango o mès</h4>');
    $('.tablaTopMenosVendidos').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMesUnidadesMenos').empty();
   $('.tablaTopMenosVendidos').empty();
    const valor0= topVendidos[0].dato2;
    const valor1= topVendidos[1].dato2;
    const valor2= topVendidos[2].dato2;
    const varlor3= topVendidos[3].dato2;
    const valor4= topVendidos[4].dato2;
  
  
    
  
    const articulo0= topVendidos[0].dato1;
    const articulo1= topVendidos[1].dato1;
    const articulo2= topVendidos[2].dato1;
    const articulo3= topVendidos[3].dato1;
    const articulo4= topVendidos[4].dato1;
  


      
    const utilidad0= topVendidos[0].dato3;
    const  utilidad1= topVendidos[1].dato3;
    const  utilidad2= topVendidos[2].dato3;
    const  utilidad3= topVendidos[3].dato3;
    const  utilidad4= topVendidos[4].dato3;
  
  
   
  let topMenosVendidosPastel =[{
  'articulo' : articulo0,
  'valor' : valor0
  },
  {
  'articulo' : articulo1,
  'valor' :valor1
  },
  {
  'articulo' : articulo2,
  'valor' :valor2
  },
  {
  'articulo' : articulo3,
  'valor' :varlor3
  },
  {
  'articulo' : articulo4,
  'valor' :valor4
  }


  ];

  let topMenosVendidosTabla =[{
    'responsive_id' : '',
    'articulo' : articulo0,
    'valor' : valor0,
    'utilidad' : utilidad0
    },
    {
      'responsive_id' : '',
    'articulo' : articulo1,
    'valor' :valor1,
    'utilidad' : utilidad1
    },
    {
      'responsive_id' : '',
    'articulo' : articulo2,
    'valor' :valor2,
    'utilidad' : utilidad2
    },
    {
      'responsive_id' : '',
    'articulo' : articulo3,
    'valor' :varlor3,
    'utilidad' : utilidad3
    },
    {
      'responsive_id' : '',
    'articulo' : articulo4,
    'valor' :valor4,
    'utilidad' : utilidad4
    }

    
    ];
    var contenido=""
    var tope =topMenosVendidosTabla.length;
    for (var i = 0; i < tope; i++) {
      art_des=topMenosVendidosTabla[i].articulo;
      total_art=topMenosVendidosTabla[i].valor;
      util=topMenosVendidosTabla[i].utilidad; 
  
   
   contenido=`<div class="transaction-item">
   <div class="d-flex">
   <img src="../app-assets/images/icons/unidad.png" class="rounded me-1" height="30" alt="Google Chrome">
       <div class="transaction-percentage">
           <h6 class="transaction-title">${art_des}</h6>
           <h5><strong>${total_art}</strong></h5>
       </div>
   </div>
   <div class="fw-bolder text-success">${util}%</div>
  </div>`;      
  $('.tablaTopMenosVendidos').append(contenido);   
    }
  
    graficoTopMenosMesUnidades(topMenosVendidosPastel);
    }

  }
   
  });  
  
  
}

function cargarDataVentasxDia($finicio,$ffinal){
  if ($('#dataVentasxDia').length) {  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=67&t=factura&finicio='+$finicio+'&ffinal='+$ffinal, 
  }).done(function(ventasxdia) { 
  var cadena = JSON.stringify(ventasxdia);
  $('.dataVentasxDia').attr("value",cadena);
  cargarTablaVentasxDia();
  
  });
  }
}

function cargarGraficoTopMayorMenorUtil($finicio,$ffinal,$estado){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=69&estado=1&t=factura&finicio='+$finicio+'&ffinal='+$ffinal+'&estado='+$estado, 
   
  }).done(function(topMayorMenorUtil) { 
  if($estado=='1'){
    if (topMayorMenorUtil.length === 0){
      $('.chartdiv_Top_Mayor_Util').empty();
    $('.topMayorUtilidad').html('<h4>No hay movimientos registrados en este rango o més</h4>');
    $('.tablaTopMayorUtil').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMayorUtilidad').empty();
   $('.tablaTopMayorUtil').empty();
    const valor0= topMayorMenorUtil[0].dato2;
    const valor1= topMayorMenorUtil[1].dato2;
    const valor2= topMayorMenorUtil[2].dato2;
    const varlor3= topMayorMenorUtil[3].dato2;
    const valor4= topMayorMenorUtil[4].dato2;
  

    
  
    const articulo0= topMayorMenorUtil[0].dato1;
    const articulo1= topMayorMenorUtil[1].dato1;
    const articulo2= topMayorMenorUtil[2].dato1;
    const articulo3= topMayorMenorUtil[3].dato1;
    const articulo4= topMayorMenorUtil[4].dato1;


      
    const utilidad0= topMayorMenorUtil[0].dato3;
    const  utilidad1= topMayorMenorUtil[1].dato3;
    const  utilidad2= topMayorMenorUtil[2].dato3;
    const  utilidad3= topMayorMenorUtil[3].dato3;
    const  utilidad4= topMayorMenorUtil[4].dato3;

  
   
  let topMayorUtilPastel =[{
  'articulo' : articulo0,
  'valor' : valor0
  },
  {
  'articulo' : articulo1,
  'valor' :valor1
  },
  {
  'articulo' : articulo2,
  'valor' :valor2
  },
  {
  'articulo' : articulo3,
  'valor' :varlor3
  },
  {
  'articulo' : articulo4,
  'valor' :valor4
  }
 

  ];

  let topMayorUtilTabla =[{
    'responsive_id' : '',
    'articulo' : articulo0,
    'valor' : valor0,
    'utilidad' : utilidad0
    },
    {
      'responsive_id' : '',
    'articulo' : articulo1,
    'valor' :valor1,
    'utilidad' : utilidad1
    },
    {
      'responsive_id' : '',
    'articulo' : articulo2,
    'valor' :valor2,
    'utilidad' : utilidad2
    },
    {
      'responsive_id' : '',
    'articulo' : articulo3,
    'valor' :varlor3,
    'utilidad' : utilidad3
    },
    {
      'responsive_id' : '',
    'articulo' : articulo4,
    'valor' :valor4,
    'utilidad' : utilidad4
    }
   
    
  ];
    var contenido=""
    var tope =topMayorUtilTabla.length;
    for (var i = 0; i < tope; i++) {
      art_des=topMayorUtilTabla[i].articulo;
      total_art=topMayorUtilTabla[i].valor;
      util=topMayorUtilTabla[i].utilidad; 
  
   
   contenido=`<div class="transaction-item">
   <div class="d-flex">
   <img src="../app-assets/images/icons/unidad.png" class="rounded me-1" height="30" alt="Google Chrome">
       <div class="transaction-percentage">
           <h6 class="transaction-title">${art_des}</h6>
           <h5><strong>${total_art}</strong></h5>
       </div>
   </div>
   <div class="fw-bolder text-success">${util}%</div>
  </div>`;      
  $('.tablaTopMayorUtil').append(contenido);   
    }
  
    graficoTopMayorUtil(topMayorUtilPastel);
    }

  }else{
    if (topMayorMenorUtil.length === 0){
      $('.chartdiv_Top_Menor_Util').empty();
    $('.topMenorUtilidad').html('<h4>No hay movimientos registrados en este rango o mès</h4>');
    $('.tablaTopMenorUtil').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMenorUtilidad').empty();
  
    const valor0= topMayorMenorUtil[0].dato2;
    const valor1= topMayorMenorUtil[1].dato2;
    const valor2= topMayorMenorUtil[2].dato2;
    const varlor3= topMayorMenorUtil[3].dato2;
    const valor4= topMayorMenorUtil[4].dato2;
  

    
  
    const articulo0= topMayorMenorUtil[0].dato1;
    const articulo1= topMayorMenorUtil[1].dato1;
    const articulo2= topMayorMenorUtil[2].dato1;
    const articulo3= topMayorMenorUtil[3].dato1;
    const articulo4= topMayorMenorUtil[4].dato1;
  
 

      
    const utilidad0= topMayorMenorUtil[0].dato3;
    const  utilidad1= topMayorMenorUtil[1].dato3;
    const  utilidad2= topMayorMenorUtil[2].dato3;
    const  utilidad3= topMayorMenorUtil[3].dato3;
    const  utilidad4= topMayorMenorUtil[4].dato3;
  

  
   
  let topMenosUtilidadPastel =[{
  'articulo' : articulo0,
  'valor' : valor0
  },
  {
  'articulo' : articulo1,
  'valor' :valor1
  },
  {
  'articulo' : articulo2,
  'valor' :valor2
  },
  {
  'articulo' : articulo3,
  'valor' :varlor3
  },
  {
  'articulo' : articulo4,
  'valor' :valor4
  }
 

  ];

  let topMenosUtilidadTabla =[{
    'responsive_id' : '',
    'articulo' : articulo0,
    'valor' : valor0,
    'utilidad' : utilidad0
    },
    {
      'responsive_id' : '',
    'articulo' : articulo1,
    'valor' :valor1,
    'utilidad' : utilidad1
    },
    {
      'responsive_id' : '',
    'articulo' : articulo2,
    'valor' :valor2,
    'utilidad' : utilidad2
    },
    {
      'responsive_id' : '',
    'articulo' : articulo3,
    'valor' :varlor3,
    'utilidad' : utilidad3
    },
    {
      'responsive_id' : '',
    'articulo' : articulo4,
    'valor' :valor4,
    'utilidad' : utilidad4
    }
   
    
    ];
    var contenido=""
    var tope =topMenosUtilidadTabla.length;
    for (var i = 0; i < tope; i++) {
      art_des=topMenosUtilidadTabla[i].articulo;
      total_art=topMenosUtilidadTabla[i].valor;
      util=topMenosUtilidadTabla[i].utilidad; 
  
   
   contenido=`<div class="transaction-item">
   <div class="d-flex">
   <img src="../app-assets/images/icons/unidad.png" class="rounded me-1" height="30" alt="Google Chrome">
       <div class="transaction-percentage">
           <h6 class="transaction-title">${art_des}</h6>
           <h5><strong>${total_art}</strong></h5>
       </div>
   </div>
   <div class="fw-bolder text-success">${util}%</div>
  </div>`;      
  $('.tablaTopMenorUtil').append(contenido);   
    }
  
    graficoTopMenorUtil(topMenosUtilidadPastel);
    }
  }
   
  });  
  
  

}

function cargarTablaTopMasMenosClientes($finicio,$ffinal,$estado){
  
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=70&t=factura&finicio='+$finicio+'&ffinal='+$ffinal+'&estado='+$estado, 

  }).done(function(topMasMenosCliente) { 
    if (topMasMenosCliente.length === 0){
     if($estado=='1'){
      $('.tablaTopMasClientes').empty();
      contenido=`<div class="transaction-item">
       <div class="d-flex">
       
               <h4 class="transaction-title">No hay registros guardados en este período</h4>
          
      </div>`;      
      $('.tablaTopMasClientes').append(contenido);   

     }else{
      $('.tablaTopMenosClientes').empty();
      contenido=`<div class="transaction-item">
      <div class="d-flex">
      
              <h4 class="transaction-title">No hay registros guardados en este período</h4>
         
     </div>`;      
     $('.tablaTopMenosClientes').append(contenido);   
     }


    }else{ 
      const valor0= topMasMenosCliente[0].dato2;
    const valor1= topMasMenosCliente[1].dato2;
    const valor2= topMasMenosCliente[2].dato2;
    const varlor3= topMasMenosCliente[3].dato2;
    const valor4= topMasMenosCliente[4].dato2;
  
    
  
    const articulo0= topMasMenosCliente[0].dato1;
    const articulo1= topMasMenosCliente[1].dato1;
    const articulo2= topMasMenosCliente[2].dato1;
    const articulo3= topMasMenosCliente[3].dato1;
    const articulo4= topMasMenosCliente[4].dato1;


      
    const utilidad0= topMasMenosCliente[0].dato3;
    const  utilidad1= topMasMenosCliente[1].dato3;
    const  utilidad2= topMasMenosCliente[2].dato3;
    const  utilidad3= topMasMenosCliente[3].dato3;
    const  utilidad4= topMasMenosCliente[4].dato3;
  
    let topMasMenosClientesTabla =[{
      'responsive_id' : '',
      'articulo' : articulo0,
      'valor' : valor0,
      'utilidad' : utilidad0
      },
      {
        'responsive_id' : '',
      'articulo' : articulo1,
      'valor' :valor1,
      'utilidad' : utilidad1
      },
      {
        'responsive_id' : '',
      'articulo' : articulo2,
      'valor' :valor2,
      'utilidad' : utilidad2
      },
      {
        'responsive_id' : '',
      'articulo' : articulo3,
      'valor' :varlor3,
      'utilidad' : utilidad3
      },
      {
        'responsive_id' : '',
      'articulo' : articulo4,
      'valor' :valor4,
      'utilidad' : utilidad4
      }
     
      
      ];

      if($estado=='1'){
        $('.tablaTopMasClientes').empty();
        var contenido=""
        var tope =topMasMenosClientesTabla.length;
        for (var i = 0; i < tope; i++) {
          cli_des=topMasMenosClientesTabla[i].articulo;
          total_art=topMasMenosClientesTabla[i].valor;
          util=topMasMenosClientesTabla[i].utilidad; 
      
       
       contenido=`<div class="transaction-item">
       <div class="d-flex">
       <img src="../app-assets/images/icons/smas.png" class="rounded me-1" height="50" alt="smas">
           <div class="transaction-percentage">
               <h6 class="transaction-title">${cli_des}</h6>
               <h5><strong>${total_art}</strong></h5>
           </div>
       </div>
       <div class="fw-bolder text-success">${util}%</div>
      </div>`;      
      $('.tablaTopMasClientes').append(contenido);   
        }
      
       }else{
        $('.tablaTopMenosClientes').empty();
        var contenido=""
        var tope =topMasMenosClientesTabla.length;
        for (var i = 0; i < tope; i++) {
          cli_des=topMasMenosClientesTabla[i].articulo;
          total_art=topMasMenosClientesTabla[i].valor;
          util=topMasMenosClientesTabla[i].utilidad; 
      
       
       contenido=`<div class="transaction-item">
       <div class="d-flex">
       <img src="../app-assets/images/icons/smenos.png" class="rounded me-1" height="50" alt="smenos">
           <div class="transaction-percentage">
               <h6 class="transaction-title">${cli_des}</h6>
               <h5><strong>${total_art}</strong></h5>
           </div>
       </div>
       <div class="fw-bolder text-success">${util}%</div>
      </div>`;      
      $('.tablaTopMenosClientes').append(contenido);   
        }
      
       }    
    }
  });  
  
  
}


function cargarDataCobrosMes($finicio,$ffinal){
  if ($('#dataCobrosMes').length) {  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=74&t=pedidos&finicio='+$finicio+'&ffinal='+$ffinal, 
  }).done(function(cobrosMes) { 
  var cadena = JSON.stringify(cobrosMes);
  $('.dataCobrosMes').attr("value",cadena);
  cargarTablaCobrosMes();
  
  });
  }
}


function cargarDataArticuloFoco($finicio,$ffinal){
  if ($('#dataArticulosFoco').length) {  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=75&t=pedidos&finicio='+$finicio+'&ffinal='+$ffinal, 
  }).done(function(articulosFoco) { 
  var cadena = JSON.stringify(articulosFoco);
  $('.dataArticulosFoco').attr("value",cadena);
  cargarTablaArticuloFoco();
  var i = 0;
  var totalFoco =0.00;

var tope =articulosFoco.length;
//console.log(tope);
if(tope ==0){
  $('.totalFoco').html("0.00");
}else{

  for (var i = 0; i < tope; i++) {
    totalFoco = totalFoco + articulosFoco[i].porc_alc;
  }
  //console.log(totalFoco);
  
  $('.totalFoco').html(parseFloat(totalFoco/i).toFixed(2));
}

  
  
  });
  }
}



function cargarTablaTopMasMenosPagos($finicio,$ffinal,$estado){
  
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=76&t=factura&finicio='+$finicio+'&ffinal='+$ffinal+'&estado='+$estado, 

  }).done(function(topMasMenosCliente) { 
    if (topMasMenosCliente.length === 0){
      if($estado=='1'){
        $('.tablaTopMasPagos').empty();
        contenido=`<div class="transaction-item">
         <div class="d-flex">
         
                 <h4 class="transaction-title">No hay registros guardados en este período</h4>
            
        </div>`;      
        $('.tablaTopMasPagos').append(contenido);   
  
       }else{
        $('.tablaTopMenosPagos').empty();
        contenido=`<div class="transaction-item">
        <div class="d-flex">
        
                <h4 class="transaction-title">No hay registros guardados en este período</h4>
           
       </div>`;      
       $('.tablaTopMenosPagos').append(contenido);   
       }


    }else{ 
      const valor0= topMasMenosCliente[0].dato2;
    const valor1= topMasMenosCliente[1].dato2;
    const valor2= topMasMenosCliente[2].dato2;
    const varlor3= topMasMenosCliente[3].dato2;
    const valor4= topMasMenosCliente[4].dato2;
  
    
  
    const articulo0= topMasMenosCliente[0].dato1;
    const articulo1= topMasMenosCliente[1].dato1;
    const articulo2= topMasMenosCliente[2].dato1;
    const articulo3= topMasMenosCliente[3].dato1;
    const articulo4= topMasMenosCliente[4].dato1;


      
    const utilidad0= topMasMenosCliente[0].dato3;
    const  utilidad1= topMasMenosCliente[1].dato3;
    const  utilidad2= topMasMenosCliente[2].dato3;
    const  utilidad3= topMasMenosCliente[3].dato3;
    const  utilidad4= topMasMenosCliente[4].dato3;
  
    let topMasMenosClientesTabla =[{
      'responsive_id' : '',
      'articulo' : articulo0,
      'valor' : valor0,
      'utilidad' : utilidad0
      },
      {
        'responsive_id' : '',
      'articulo' : articulo1,
      'valor' :valor1,
      'utilidad' : utilidad1
      },
      {
        'responsive_id' : '',
      'articulo' : articulo2,
      'valor' :valor2,
      'utilidad' : utilidad2
      },
      {
        'responsive_id' : '',
      'articulo' : articulo3,
      'valor' :varlor3,
      'utilidad' : utilidad3
      },
      {
        'responsive_id' : '',
      'articulo' : articulo4,
      'valor' :valor4,
      'utilidad' : utilidad4
      }
     
      
      ];

      if($estado=='1'){
        $('.tablaTopMasPagos').empty();
        var contenido=""
        var tope =topMasMenosClientesTabla.length;
        for (var i = 0; i < tope; i++) {
          cli_des=topMasMenosClientesTabla[i].articulo;
          total_art=topMasMenosClientesTabla[i].valor;
          util=topMasMenosClientesTabla[i].utilidad; 
      
       
       contenido=`<div class="transaction-item">
       <div class="d-flex">
       <img src="../app-assets/images/icons/smas.png" class="rounded me-1" height="50" alt="smas">
           <div class="transaction-percentage">
               <h6 class="transaction-title">${cli_des}</h6>
            
           </div>
       </div>
       <div class="fw-bolder text-success">${util}</div>
      </div>`;      
      $('.tablaTopMasPagos').append(contenido);   
        }
      
       }else{
        $('.tablaTopMenosPagos').empty();
        var contenido=""
        var tope =topMasMenosClientesTabla.length;
        for (var i = 0; i < tope; i++) {
          cli_des=topMasMenosClientesTabla[i].articulo;
          total_art=topMasMenosClientesTabla[i].valor;
          util=topMasMenosClientesTabla[i].utilidad; 
      
       
       contenido=`<div class="transaction-item">
       <div class="d-flex">
       <img src="../app-assets/images/icons/smenos.png" class="rounded me-1" height="50" alt="smenos">
           <div class="transaction-percentage">
               <h6 class="transaction-title">${cli_des}</h6>
             
           </div>
       </div>
       <div class="fw-bolder text-danger">${util}</div>
      </div>`;      
      $('.tablaTopMenosPagos').append(contenido);   
        }
      
       }    
    }
  });  
  
  
}

function cargarDataArticuloVolumen($co_ven,$co_zona,$finicio,$ffinal){
  if ($('#dataArticulosVolumen').length) {  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=79&t=pedidos&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
  }).done(function(articulosVolumen) { 
  var cadena = JSON.stringify(articulosVolumen);
  $('.dataArticulosVolumen').attr("value",cadena);
  cargarTablaArticuloVolumen();
  var i = 0;
  var totalVolumen =0.00;

var tope =articulosVolumen.length;
if(tope ==0){
  $('.totalVolumen').html("0.00");
}else{
  for (var i = 0; i < tope; i++) {
    totalVolumen = totalVolumen + articulosVolumen[i].porc_alc;
  }
  
  $('.totalVolumen').html(parseFloat(totalVolumen/i).toFixed(2));
}


  });
  }
}

function cargarComboZona(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=66&t=art', 
  }).done(function(dataZonas) { 
  var i = 0;
  var tope =dataZonas.length;
  for (var i = 0; i < tope; i++) {
  
    $(combo).prepend('<option value = '+dataZonas[i].dato2+'>'+dataZonas[i].dato3+'</option>');
  
  }  
  });
  }
  }

  
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




function localizacionData($co_cli){
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=112&c=ClienteData&t=clientes&filtro='+$co_cli, 
}).done(function(localizacion) {  
 // console.log(localizacion);
  var i = 0;
  var tope =localizacion.length;
  var contenido="";
  if(tope>=1){   
 
  //$('#localizacionData').html(localizacion[0].localizacion); 
  //$('#clienteFoto').attr("src",localizacion[0].foto);
 
  }else{
    $('.localizacionData').html('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50168.835269095696!2d-69.46563067832028!3d10.0669582!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e8765e1130bb645%3A0x67ddb48847cf22d7!2sgrupo%20solsumed%2C%20c.a.!5e1!3m2!1ses!2sve!4v1726709943488!5m2!1ses!2sve" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'); 
   
  } 
});

}


function perfilCliente($co_cli){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=1123&c=ClienteData&t=clientes&filtro='+$co_cli, 
}).done(function(data) {  
  //console.log(perfil);
  var i = 0;
  var tope =data.length;
  var contenido="";
  if(tope>=1){  

    for (var i = 0; i < tope; i++) { 
      $('#cli_des').val(data[i].cli_des);      
      $('#cli_rif').val(data[i].rif);
      $('#cli_telefono').val(data[i].telefonos);
      $('#cli_email').val(data[i].email);
       $('#cli_direccion').val(data[i].direc1);
   }  

 
  }else{
  
   
  }
 
});

}


function cargarDataRenglonPagos($filtro){
  //console.log($fact_nun);
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=199&c=FacturaData&t=factura&filtro='+$filtro, 
}).done(function(data) {  
  //console.log(facturas);
 /* var i = 0;
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
  }*/
 
});
}

function borrarPagosRealizados(id,monto){

      var tipo = 1;
        
      var accion = 3; // eliminar reglon de pago
             var datos =2;
                 $.ajax({
                     url: '../admin/index.php?action=pago', 
                     type:'POST',
                     data:{monto:monto,id:id,tipo:tipo,accion:accion,datos:datos},
                     success:function(response){
                     
                      if(response==1){
                        Swal.fire({
                          icon: 'success',
                          title: 'Bien...',
                          text: 'Reporte de pago eliminado exitosamente.'
                        
                        }),
                         
                                cargarDataPagosRealizados();
                              estadoCuentaPagosRealizados();

                      
                     // estadoCuentaPagosRealizados();
                      }else{
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Huno un error al eliminar !'
                        
                        })
                      }
                                  
                        
                     }
                 });   
}



function getSessionData(key) {
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : null;
}

function setSessionData(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

