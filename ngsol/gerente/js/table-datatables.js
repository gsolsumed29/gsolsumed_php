
function graficoReporteXA(meses,grafico){

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

function graficoReporteXL(meses,grafico){
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

function graficoTopMes(topVendidos){

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
      { data: 'nro_doc' },//1
      { data: 'nro_doc' }, //2
      { data: 'saldo' },//3       
      { data: 'fec_emis' },//4
      { data: 'tipo_doc' },  //5
      { data: 'saldo2' },//6
      { data: 'dato1' },//7
      
  
     
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
        targets: 6,
        visible: false
      },
      {
        // Label
        targets: 7,
        render: function (data, type, full, meta) {
          var $status_number = full['dato1'];
          var $status = {
            0: { title: 'Sin Pago', class: 'badge-light-danger' },
            1: { title: 'Revisando Pago', class: ' badge-light-warning' }
            
          
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
        
            return (`<div class="form-check"> <input class="form-check-input dt-checkboxes facturas ${full['nro_doc']}" type="checkbox" ${full['nro_doc']}="${full['saldo2'].toFixed(4)}" value="${full['nro_doc']}" id="checkbox${data} /><label class="form-check-label" for="checkbox${data}"></label></div>`);
          
          
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
        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Agregar Pago',
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

    if(tope>=1){
      cliente = $('.comboClientesFactura option:selected').html().trim();
      co_cliente=$('.comboClientesFactura').val();

      $('.facturas_cliente').val(cliente);
    
      var contenido ='';
      var saldo=0.00;
      var monto=0.00;   
      //console.log(arrayFacturas);
      for (var i = 0; i < tope; i++) { 
        monto=parseFloat(($("."+arrayFacturas[i]+"").attr(arrayFacturas[i])));
        //console.log(monto);
        saldo=saldo+monto;
        contenido+=arrayFacturas[i];

        contenido +='-';
       
      }
      let date = new Date(); 
      var fecha =date.getFullYear()+ '-' + ( date.getMonth() + 1 ) + '-' + date.getDate();
      //console.log(fecha);
      $('.facturas_cancelar').val(arrayFacturas);
      $('.facturas_cliente_codigo').val(co_cliente);
      $('.facturas_saldo').val(saldo.toFixed(4));
      $('.facturas_monto').val(saldo.toFixed(4));
      $('.facturas_fecha').val(fecha);
      $(".modalPagoFacturas").modal("show");       

    }else{

      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Debes seleccionar al menos un documento para acusar pago!'
      
      })
    }
   


  });
  
 



  $('div.head-label').html('<h6 class="mb-0">Documentos del cliente</h6>');
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

function cargarTablaCuentasPorCobrar(){
var dt_basic_table_cuentas = $('.datatables-basic-cuentas');   
  assetPath = '../app-assets/';
if (dt_basic_table_cuentas.length) {
  dt_basic_table_cuentas.DataTable().destroy();
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
      { data: 'saldo' }//5  

     /* { data: '' }*/
     
        
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
        visible: true,
        width: '10%'
      },   
      {
        targets: 3,
        visible: true,
        width: '30%'
      },   
      {
        targets: 4,
        visible: true,
        width: '10%'
      },   
      
      
      {
        responsivePriority: 1,
        targets: 3
      },

      {
        // Label
        targets: 5,
        width: '10%',
        render: function (data, type, full, meta) {
          var $status_number = full['saldo'];

        if($status_number<0){
          return (             
            '<span class="badge rounded-pill bg-success ">'+$status_number.toFixed(2)+'</span>'
          );
        }else{
          return (
            '<span class="badge rounded-pill  bg-danger ">'+$status_number.toFixed(2)+'</span>'
          );
        }
         
         
        }
      },
      /*
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
     */
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

function cargarTablaAnalisisVCTO(){
  var dt_basic_table_vcto = $('.datatables-basic-vcto');   
    assetPath = '../app-assets/';
  if (dt_basic_table_vcto.length) {
    dt_basic_table_vcto.DataTable().destroy();
    let dataAnalisisVCTO =  $('.dataAnalisisVCTO').val();
    //console.log(dataArticulos);
    let arrayCuentas = "";
    arrayCuentas = JSON.parse(dataAnalisisVCTO);
    var dt_basic = dt_basic_table_vcto.DataTable({
     data : arrayCuentas,
      columns: [    
        //responsive_id co_art art_des prec_vta1
      
        { data: 'responsive_id' },//0
        { data: 'co_cli' },    //1
        { data: 'co_cli' },//2
        { data: 'cli_des' },//3
        { data: 'dato1' },//4
        { data: 'dato2' },//5
        { data: 'dato3' },//6
        { data: 'dato4' },//7
        { data: 'dato5' }//8
  
       /* { data: '' }*/
       
          
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
          responsivePriority: 1,
          targets: 3
        },
  

        /*
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
       */
        {
        
        },
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
              exportOptions: { columns: [2,3, 4, 5] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
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
      { data: 'prec_vta1' }//5     
   
        
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
            extend: 'excel',
            text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
            className: 'dropdown-item',
            exportOptions: { columns: [2,3, 4, 5] }
          },
          {
            extend: 'pdf',
            text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
            className: 'dropdown-item',
            orientation: 'landscape',
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
      { data: 'dato2' },    //1
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
        width: '30px',
        orderable: false,
        render: function (data, type, full, meta) {
          return (
            '<div class="d-flex align-items-center col-actions">' +             
            '<a class="me-25" href="index.php?view=factura&fact_num='+full['fact_num']+'&s='+full['status']+'&co_ven='+full['dato2']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
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
    var $co_cli = $('.add-new-record-visita .comboClientes').val().toUpperCase(),       
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



if ($('#generarAnexo').length) { 
/*
  document.addEventListener("DOMContentLoaded", () => {
    // Escuchamos el click del botón
    const $boton = document.querySelector("#generarAnexo");
    $boton.addEventListener("click", () => {
        const $elementoParaConvertir = document.getElementById('reporteGerencial');
        
        html2pdf()
            .set({
                margin: 0.5,
                filename: valorDado+'.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3, // A mayor escala, mejores gráficos, pero más peso
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
});
*/
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



if ($('.content-body').length) {  
//Top de los productos mas vendidos
cargarDataEmpresaDetalles();
}

if ($('.datosVendedor').length) {  
//Top de los productos mas vendidos
cargarDataVendedor();
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
cargarDataPedidos(0,'NO','NO');
cargarDataVisitas();
cargarDataCuentasPorCobrar('NO','NO');

cargarDataAnalisisVCTO('NO');

cargarDataGerencial('NO','0',0);


if ($('.reportexva').length) {

  estadisticasMes('NO','NO');
  cargarDataMeses('NO','NO');

}

if ($('.chartdiv_dashboard_1').length) {

  estadisticasMes_tablero();
}
if ($('.chartdiv_dashboard_2').length) {

  estadisticasMes_tablero_linea();
}
if ($('.topMes').length) {
  cargarGraficoTopMes('NO');
}
if ($('.reportexvl').length) {

  estadisticasMesLinea('NO','NO');
  cargarDataMesesLinea('NO','NO');

}

// Metodos q cargan las tablas diferentes tablas
// estadisticas cuadros resumen();
// Metodos asociados a los botones que haran acciones de insersion dentro de la base de datos

$('.anularPedidoCarrito').on('click', function (e) { 
  anularPedidoCarrito();    
});


$('.cargarPedidos').on('click', function (e) {
var $status = $('.status').val();
var $rango = $('.rango').val();
var $vendedor = $('.comboVendedores').val();
//console.log($status);
//console.log($rango);
//console.log($vendedor );
    if($status!='NO'){
      if($rango!=' '){
        if($vendedor!='NO'){
          cargarDataPedidos($status,$rango,$vendedor);
          $('#modals-slide-in').modal('hide')
        }else{
          cargarDataPedidos($status,$rango,$vendedor);
          $('#modals-slide-in').modal('hide')
        }
       
      }else{
        cargarDataPedidos($status,'NO','NO');
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


$('.cargarCuentas').on('click', function (e) { 
  var $rango = $('.rango').val();
  var $vendedor = $('.comboVendedores').val();

        if($vendedor!='NO'){
          if($rango!=''){
            cuentasPorCobrar($rango,$vendedor);
            cargarDataCuentasPorCobrar($rango,$vendedor);
            console.log('si=vendedor ! si=rango')
            $('#modals-slide-in').modal('hide')

          }else{
            cuentasPorCobrar('NO',$vendedor);
            cargarDataCuentasPorCobrar('NO',$vendedor);
            console.log('si=vendedor ! no=rango')
            $('#modals-slide-in').modal('hide')
          }
        
        }else{
          if($rango!=''){
            cuentasPorCobrar($rango,'NO');
            cargarDataCuentasPorCobrar($rango,'NO');
  
            $('#modals-slide-in').modal('hide')

          }else{
            cuentasPorCobrar('NO',$vendedor);
            cargarDataCuentasPorCobrar('NO',$vendedor);
      
            $('#modals-slide-in').modal('hide')
          }
        
        }
      
 
       
  
  });

$('.cargarCuentasAnalisis').on('click', function (e) {  
    var $vendedor = $('.comboVendedores').val();
  
   
            if($vendedor!='NO'){
              cargarDataAnalisisVCTO($vendedor);
              
             
    
              $('#modals-slide-in').modal('hide')
  
            }else{
            
              cargarDataAnalisisVCTO('NO');
             // console.log('si=vendedor ! no=rango')
              $('#modals-slide-in').modal('hide')
            }         
            
   
         
    
});
  

$('.cargarGerencial').on('click', function (e) {
  var $co_alma = $('.comboSucursal').val();
  var $rango = $('.rango').val();

  //var $costo = $('.comboCosto').val();
  var $costo=0.00;
  //console.log($status);
  console.log($rango);
 // console.log($vendedor );
 
        if($rango!=''){
           console.log('Con rango');
            cargarDataGerencial($co_alma,$rango,$costo);
            $('#modals-slide-in').modal('hide')    
         
        }else{
          $rango='0';
          console.log('sin rango');
            cargarDataGerencial($co_alma,$rango,$costo);
            $('#modals-slide-in').modal('hide')
        }
          
    
  
  });
  


$('.comboClientesFactura').on('change', function () {
var $co_cli = $('.comboClientesFactura').val();
var $co_ven = $('.comboVendedoresFactura').val();
  cargarDataFacturas($co_cli,$co_ven);

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
  var vendedores = $('.comboVendedores').val();
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

    estadisticasMes(filtroMeses,vendedores);
    cargarDataMeses(vendedores,filtroMeses);
  }else{
  
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


$("#comboVendedoresFactura").on('change', function () {
  $("#comboVendedoresFactura option:selected").each(function () {
     let elegido=$(this).val();
      //console.log(elegido);
      if(elegido==0){
        $('#comboClientesFactura').empty();
        $('#comboClientesFactura').html('<option>Seleccione cliente</option>');
        $('#comboClientesFactura').prop('disabled', true);       
      }else{
        $('#comboClientesFactura').empty();         
        cargarClientes(elegido);
        $('#comboClientesFactura').prop('disabled', false);
      }
    
  });
  });



$('.filtrarMesesLinea').on('change', function () {

  var filtroMeses = $('.filtrarMesesLinea').val();
  var vendedores = $('.comboVendedores').val();
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

    estadisticasMesLinea(filtroMeses,vendedores);
    cargarDataMesesLinea(vendedores,filtroMeses);
  }else{
  
  }
  
});  

$('.search-product').keyup(function(){ 
//console.log('A buscar y filtrar');
let $filtro = $('.search-product').val().trim();
$('.ecommerceProducts').html('<div class="loading">Un momento por favor...</div>');
$('.ecommerceProducts').empty();
cargarDataProductos($filtro,1);
})


if ($('.cuentasPorCobrar').length) {
//console.log('Cuentas por Cobrar');
//contarRegistroCart();
cuentasPorCobrar('NO','NO');

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
var contenido="";
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
          //console.log("Nueo");
          $('.pagination').find('li').addClass('page-item');
          $('.pagination').find('a').addClass('page-link');
        }
      });
    }
    /*
    cuenta= datosDevueltos[0].co_art;
    var pagina = Math.ceil(cuenta/articulosxpagina);
    console.log(pagina);
    for (var i = 1; i <= pagina; i++) {

        var class_active=" ";
        if (i == 1) {
          class_active = 'active';
        }
      contenido=`<li class="page-item ${class_active}"><a class="page-link" href="#" onClick=paginar(${i},'${datos}') data="${i}">${i}</a></li>`;
      $('.pagination-pedido').append(contenido);
   
      }*/
  
}, function(errorLanzado){
   console.log(errorLanzado);
});

}
// Paginacion del grid de articulos (carrtito de compra)
       
if ($('.pagination-cart').length) {
contarRegistroCart(); 
}
// Paginacion del grid de articulos (carrtito de compra)



if ($('.comboSucursal').length) {
  cargarComboSucursal('.comboSucursal');
  }

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

if ($('.comboVendedoresFactura').length) {
  cargarCombo('.comboVendedoresFactura');
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
  
//facturas_cancelar facturas_cliente_codigo facturas_monto facturas_metodo facturas_banco facturas_cuenta 
//facturas_caja facturas_fecha facturas_observacion
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
$ref_ban =  $('.facturas_referencia').val() 
// console.log($fec_emis);
// console.log($forma_pag);


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
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
              // console.log($facturas);
                  const separar = $facturas.split("-");
                  // console.log(separar);
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
                        '&datos='+datos+'&cli_des='+$cli_des+'&banco_des='+banco_des+'&cuenta_des='+cuenta_des+'&caja_des='+caja_des+'&moneda_des='+moneda_des, 
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
                                text: 'No hemos podido registrar su pedido, verifique e intente nuevamente!'
                              
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
            /* Read more about handling dismissals below */
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
                    '&datos='+datos+'&cli_des='+$cli_des+'&banco_des='+banco_des+'&cuenta_des='+cuenta_des+'&caja_des='+caja_des+'&moneda_des='+moneda_des, 
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
                            text: 'No hemos podido registrar su pedido, verifique e intente nuevamente!'
                          
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
$ref_ban =  $('.facturas_referencia').val() 
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
                        '&datos='+datos+'&cli_des='+$cli_des, 
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
                    '&datos='+datos+'&cli_des='+$cli_des, 
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
Swal.fire({
  title: '¿Deseas registrar el pedido?',
  text: "Tenga en cuenta que realizarà un pedido por los articulos seleccionados.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si',
  cancelButtonText: 'No'
}).then((result) => {
  if (result.isConfirmed) {
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
  $total_art= $('.totalArticulos3').text()
  //$tipoFactura = $('.comboFormasPago').val(),
  
if (($saldo != '') && ($co_cli!='0')  && ($co_ven!='0') && ($co_tran!='0')  && ($forma_pag!='0')) {    
    let timerInterval
            Swal.fire({
              title: 'Registrando su pedido',
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
      var $total_bruto = $saldo-$iva;

      var tipo = 1;
      var accion = 1;
      var datos =1;
          $.ajax({
              url: '../admin/index.php?action=pedido', 
              type:'POST',
              data:{cli_des:$cli_des,total_art:$total_art,co_almaa:$co_almaa,iva:$iva,co_alma:$co_alma,saldo:$saldo,co_cli:$co_cli,co_ven:$co_ven,co_tran:$co_tran,forma_pag:$forma_pag,total_bruto:$total_bruto,
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
                  
                  cargarDataFactura();
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
          
        }
        })

 

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
                         
                         redireccionar();
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
                           text: 'Pedido anulado exitosamente.'
                         
                         }),                                   
                         
                        redireccionar();
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

function redireccionar(){
$(location).attr('href','index.php?view=pedidos&s=0');
}
// metodos para llenar las tablas

function cargarDataClientes(){
if ($('#dataClientes').length) {
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&c=ClienteData&a=21&t=clientes', 
}).done(function(usuarios) { 
var cadena = JSON.stringify(usuarios);
$('.dataClientes').attr("value",cadena);
cargarTablaClientes();


});
}
}

function cargarDataAnalisisVCTO($co_ven){
  if ($('#dataAnalisisVCTO').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=51&t=factura&co_ven='+$co_ven, 
  }).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataAnalisisVCTO').attr("value",cadena);
  cargarTablaAnalisisVCTO();
  });
  }
  }

function cargarDataCuentasPorCobrar($filtro,$co_ven){
if ($('#dataCuentasPorCobrar').length) {
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&c=FacturaData&a=48&t=factura&co_ven='+$co_ven+'&filtro='+$filtro, 
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

function cargarDataPedidos($status,$rango,$co_ven){
if ($('#dataPedidos').length) {  
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&c=PedidoData&a=33&t=pedidos&status='+$status+'&rango='+$rango+'&co_ven='+$co_ven, 
}).done(function(pedidos) { 
var cadena = JSON.stringify(pedidos);
$('.dataPedidos').attr("value",cadena);
cargarTablaPedidos();

});
}
}


function cargarDataGerencial($co_alma,$rango,$costo){
  if ($('.rgerencial').length) {  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=40&t=factura&co_alma='+$co_alma+'&rango='+$rango+'&costo='+$costo, 
  }).done(function(datosGerenciales) { 
   // console.log(datosGerenciales);
    var i = 0;
      var tope =datosGerenciales.length;
      for (var i = 0; i < tope; i++) {
        
        const totalFacturacionPeriodo = datosGerenciales[0];
      
        const totalDevoluciones =datosGerenciales[1];
        const totalVentas = totalFacturacionPeriodo -totalDevoluciones;
        const costoVentaMercancia =datosGerenciales[3];
        const costoVentaMercanciaDevoluciones =datosGerenciales[4];
        const totalCostoVenta = costoVentaMercancia -costoVentaMercanciaDevoluciones;
        const utilidadBrutaVenta = totalVentas -totalCostoVenta;
        const gastos =datosGerenciales[5];
        const ajustesPorFaltantesInventario =datosGerenciales[6];
        const ajustesPorTomaDeInventario =datosGerenciales[7];
        const totalUtilidadNeta = utilidadBrutaVenta - gastos - ajustesPorFaltantesInventario - ajustesPorTomaDeInventario;
        const cajas =datosGerenciales[8];
        const bancos =datosGerenciales[9];
        const inventarios =datosGerenciales[10];
        const cuentasXCobrar =datosGerenciales[11];
        const totalActivos =cajas+bancos+inventarios+cuentasXCobrar;
        const cuentasXPagar =datosGerenciales[12];
        const gastosPorPagar =datosGerenciales[13];
        const totalPosicionMonetaria =totalActivos - cuentasXPagar - gastosPorPagar;

        $('.totalFacturacionPeriodo').html(totalFacturacionPeriodo.toFixed(2));
        $('.totalDevoluciones').html(totalDevoluciones.toFixed(2));   
        $('.totalVentas').html('<b>'+totalVentas.toFixed(2)+'</b>');
        $('.costoVentaMercancia').html(costoVentaMercancia.toFixed(2));
        $('.costoVentaMercanciaDevoluciones').html(costoVentaMercanciaDevoluciones.toFixed(2));
        $('.totalCostoVenta').html('<b>'+totalCostoVenta.toFixed(2)+'</b>');
        $('.utilidadBrutaVenta').html(utilidadBrutaVenta.toFixed(2));
        $('.gastos').html(gastos.toFixed(2));
        $('.ajustesPorFaltantesInventario').html(ajustesPorFaltantesInventario.toFixed(2));
        $('.ajustesPorTomaDeInventario').html(ajustesPorTomaDeInventario.toFixed(2));

        $('.totalUtilidadNeta').html('<b>'+totalUtilidadNeta.toFixed(2)+'</b>');
        $('.cajas').html(cajas.toFixed(2));
        $('.bancos').html(bancos.toFixed(2));
        
        $('.inventarios').html(inventarios.toFixed(2));
        $('.cuentasXCobrar').html(cuentasXCobrar.toFixed(2));
        $('.totalActivos_1').html(totalActivos.toFixed(2));
        $('.totalActivos_2').html(totalActivos.toFixed(2));

        $('.cuentasXPagar').html(cuentasXPagar.toFixed(2));
        $('.gastosPorPagar').html(gastosPorPagar.toFixed(2));

        $('.totalPosicionMonetaria').html('<b>'+totalPosicionMonetaria.toFixed(2)+'</b>');

        if(totalFacturacionPeriodo<=0){
          $('.totalFacturacionPeriodo').removeClass('text-success');
          $('.totalFacturacionPeriodo').addClass('text-danger');

        }else{
          $('.totalFacturacionPeriodo').removeClass('text-danger');
          $('.totalFacturacionPeriodo').addClass('text-success');
        }
        
        if(totalDevoluciones<=0){
          $('.totalDevoluciones').removeClass('text-success');
          $('.totalDevoluciones').addClass('text-danger');
        }else{
          $('.totalDevoluciones').removeClass('text-danger');
          $('.totalDevoluciones').addClass('text-success');
        }
        if(costoVentaMercancia<=0){
          $('.costoVentaMercancia').removeClass('text-success');
          $('.costoVentaMercancia').addClass('text-danger');
        }else{
          $('.costoVentaMercancia').removeClass('text-danger');
          $('.costoVentaMercancia').addClass('text-success');
        }
        if(costoVentaMercanciaDevoluciones<=0){
          $('.costoVentaMercanciaDevoluciones').removeClass('text-success');
          $('.costoVentaMercanciaDevoluciones').addClass('text-danger');
        }else{
          $('.costoVentaMercanciaDevoluciones').removeClass('text-danger');
          $('.costoVentaMercanciaDevoluciones').addClass('text-success');
        }
        if(utilidadBrutaVenta<=0){
          $('.utilidadBrutaVenta').removeClass('text-success');
          $('.utilidadBrutaVenta').addClass('text-danger');
        }else{
          $('.utilidadBrutaVenta').removeClass('text-danger');
          $('.utilidadBrutaVenta').addClass('text-success');
        }
        if(gastos<=0){
          $('.gastos').removeClass('text-success');
          $('.gastos').addClass('text-danger');
        }else{
          $('.gastos').removeClass('text-danger');
          $('.gastos').addClass('text-success');
        }
        if(ajustesPorFaltantesInventario<=0){
          $('.ajustesPorFaltantesInventario').removeClass('text-success');
          $('.ajustesPorFaltantesInventario').addClass('text-danger');
        }else{
          $('.ajustesPorFaltantesInventario').removeClass('text-danger');
          $('.ajustesPorFaltantesInventario').addClass('text-success');
        }
        if(ajustesPorTomaDeInventario<=0){
          $('.ajustesPorTomaDeInventario').removeClass('text-success');
          $('.ajustesPorTomaDeInventario').addClass('text-danger');
        }else{
          $('.ajustesPorTomaDeInventario').removeClass('text-danger');
          $('.ajustesPorTomaDeInventario').addClass('text-success');
        }
        if(cajas<=0){
          $('.cajas').removeClass('text-success');
          $('.cajas').addClass('text-danger');
        }else{
          $('.cajas').removeClass('text-danger');
          $('.cajas').addClass('text-success');
        }
        if(bancos<=0){
          $('.bancos').removeClass('text-success');
          $('.bancos').addClass('text-danger');
        }else{
          $('.bancos').removeClass('text-danger');
          $('.bancos').addClass('text-success');
        }
        if(inventarios<=0){
          $('.inventarios').removeClass('text-success');
          $('.inventarios').addClass('text-danger');
        }else{
          $('.inventarios').removeClass('text-danger');
          $('.inventarios').addClass('text-success');
        }
        if(cuentasXCobrar<=0){
          $('.cuentasXCobrar').removeClass('text-success');
          $('.cuentasXCobrar').addClass('text-danger');
        }else{
          $('.cuentasXCobrar').removeClass('text-danger');
          $('.cuentasXCobrar').addClass('text-success');
        }

        if(totalActivos<=0){
          $('.totalActivos_1').removeClass('text-success');
          $('.totalActivos_1').addClass('text-danger');
        }else{
          $('.totalActivos_1').removeClass('text-danger');
          $('.totalActivos_1').addClass('text-success');
        }


        if(totalActivos<=0){
          $('.totalActivos_2').removeClass('text-success');
          $('.totalActivos_2').addClass('text-danger');
        }else{
          $('.totalActivos_2').removeClass('text-danger');
          $('.totalActivos_2').addClass('text-success');
        }


        if(cuentasXPagar<=0){
          $('.cuentasXPagar').removeClass('text-success');
          $('.cuentasXPagar').addClass('text-danger');
        }else{
          $('.cuentasXPagar').removeClass('text-danger');
          $('.cuentasXPagar').addClass('text-success');
        }

        if(gastosPorPagar<=0){
          $('.gastosPorPagar').removeClass('text-success');
          $('.gastosPorPagar').addClass('text-danger');
        }else{
          $('.gastosPorPagar').removeClass('text-danger');
          $('.gastosPorPagar').addClass('text-success');
        }

        if(totalPosicionMonetaria<=0){
          $('.totalPosicionMonetaria').removeClass('text-success');
          $('.totalPosicionMonetaria').addClass('text-danger');
        }else{
          $('.totalPosicionMonetaria').removeClass('text-danger');
          $('.totalPosicionMonetaria').addClass('text-success');
        }
      }   
   
   //1- totalFacturacionPeriodo -
   //2- totalDevoluciones -
   //3- totalVentas -
   //4- costoVentaMercancia -
   //5- costoVentaMercanciaDevoluciones -
   //6- totalCostoVenta -
   //7- utilidadBrutaVenta -
   //8- gastos - 
   //9- ajustesPorFaltantesInventario -
   //10- ajustesPorTomaDeInventario -
   //11- totalUtilidadNeta -

   //12- cajas -
   //13- bancos - 
   //14- inventarios -
   //15- cuentasXCobrar -
   //16- totalActivos -

 //  totalActivos
//cuentasXPagar

                                        
//gastosPorPagar
//totalPosicionMonetaria

  });
  }
  }

function cargarDataFacturas($co_cli,$co_ven){

if ($('#dataFacturas').length) {
 
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&a=41&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0&co_ven='+$co_ven,
}).done(function(pedidos) { 
var cadena = JSON.stringify(pedidos);
$('.dataFacturas').attr("value",cadena);
cargarTablaFacturasCliente();


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

function cargarComboSucursal(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=SucursalData&a=1&t=almacen', 
  }).done(function(dataSucursales) { 
  var i = 0;
  var tope =dataSucursales.length;
  for (var i = 0; i < tope; i++) {
  
    $(combo).prepend('<option value = '+dataSucursales[i].co_alma+'>'+dataSucursales[i].alma_des+'</option>');
  
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

function cargarClientes(idTipo){
  var id = idTipo;
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&t=cuentas&c=ClienteData&a=18&id='+id, 
  }).done(function(clientes) {  
  //alert(categorias);
  $('#comboClientesFactura').html('<option value = "0">Seleccione</option>');
  //console.log(cuentas);
  var i = 0;
  var tope =clientes.length;
  if(tope>=1){   
    for (var i = 0; i < tope; i++) {   
     
  
    $('#comboClientesFactura').append('<option value = '+clientes[i].co_cli+'>'+clientes[i].cli_des+'</option>');
  
    }  
  }else{
    $('#comboClientesFactura').html('<option value = "0">Seleccione cliente</option>');
  }
  //alert(tope);
  });
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

function cargarGraficoTopMes($filtro){
 
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&c=FacturaData&a=43&t=factura&filtro='+$filtro, 
}).done(function(topVendidos) { 
  if (topVendidos.length === 0){
    $('.chartdiv_top').empty();
  $('.topMes').html('<h4>No hay movimientos registrados en este rango o mès</h3>');
  
  }else{ 
 // console.log(topVendidos);
 $('.topMes').empty();
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

graficoTopMes(topVendidosPastel);
  }
});  


}

function estadisticasMes(filtroMeses,co_ven){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=29&t=factura&filtro='+filtroMeses+'&co_ven='+co_ven, 
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
  graficoReporteXA(mesesData,'graficoXA');

}
});  

}

function estadisticasMes_tablero(){


  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=42&t=factura', 
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
  graficoReporteXA(mesesData,'graficoXA');

}
});  

}

function estadisticasMes_tablero_linea(){  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=44&t=factura', 
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
 graficoReporteXL(mesesData,'graficoXL');

}
});  

}

function estadisticasMesLinea(filtroMeses,co_ven){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=31&t=factura&filtro='+filtroMeses+'&co_ven='+co_ven, 
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
  graficoReporteXA(mesesData,'graficoXL');

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
console.log('cargarDataProductos');
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

    contenido=`<div class="col col-xs-6 col-sm-4"><div class=" card ecommerce-card">      
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

    contenido=`<div class="col col-xs-6 col-sm-4"><div class="card ecommerce-card">      
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
    contenido=`<div class="col-6 col-xs-6 col-sm-4">
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

  contenido=`<div class="col-6 col-xs-6 col-sm-4">
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

function cuentasPorCobrar($filtro,$co_ven){ 
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&a=49&c=FacturaData&t=factura&filtro='+$filtro+'&co_ven='+$co_ven, 
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

    
    contenido=`<tr>
    <td><a href="javascript:facturaDetalles('${fact_nun}','${$co_cli}','${saldo}');">${fact_nun}</a></td>
    <td>${tipo_doc}</td>
    <td><span class="badge rounded-pill badge-light-primary me-1"><a href="javascript:facturaDetalles('${fact_nun}','${$co_cli});">${saldo}</a></span></td>
    <td><a href="javascript:facturaDetalles('${fact_nun}','${$co_cli}','${saldo}');">${fec_emis}</a></td>
  
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
 
function facturaDetalles($fact_nun,$co_cli,$saldo){
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

    contenido=`<tr>
    <td>${co_art}</td>
    <td><span class="badge rounded-pill badge-light-primary me-1">${art_des}</span></td>
    <td>${total_art}</td>
    <td>${precio}</td>

    </tr>`;   
    $('#filaFacturaDetalles').prepend(contenido);   
  }  
  $(".facturaNumero").html('Factura N° : '+$fact_nun+'    |   Saldo: '+$saldo)
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

function cargarDataMeses($co_ven,$filtro){
  
  if ($('#dataVentasxArticulo').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=24&c=FacturaData&t=factura&rango='+$filtro+'&co_ven='+$co_ven,
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataVentasxArticulo').attr("value",cadena);
  cargarTablaVentaxArticulos();


});
  }
}

function cargarDataMesesLinea($co_ven,$filtro){
  
  if ($('#dataVentasxLinea').length) {
   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=30&c=FacturaData&t=factura&rango='+$filtro+'&co_ven='+$co_ven,
}).done(function(pedidos) { 
  var cadena = JSON.stringify(pedidos);
  $('.dataVentasxLinea').attr("value",cadena);
  cargarTablaVentaxLinea();


});
  }
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


