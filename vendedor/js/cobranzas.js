function cargarTablaFacturasCliente() {
  //04122025 - Versión mejorada con cache, filtros y animaciones
  var datatables_basic_facturas = $('.dataTablesFacturas');
  var groupColumn = 15;
  let cacheData = null;
  let currentFilter = 'all'; // 'all', 'vencidas', 'por_vencer'
  let isLoading = false;

  // Función para mostrar/ocultar loader
  function showLoader(show = true) {
    if (show) {
      $('.dataTablesFacturas').css('opacity', '0.5');
      $('.loader-container').show();
    } else {
      $('.dataTablesFacturas').css('opacity', '1');
      $('.loader-container').hide();
    }
  }

  // Función para obtener datos (con cache)
  async function obtenerDatosFacturas() {
    if (cacheData && !isLoading) {
      return cacheData;
    }

    showLoader(true);
    isLoading = true;
    
    try {
      let dataFacturas = $('.dataFacturas').val();
      let arrayFacturas = JSON.parse(dataFacturas);
      cacheData = arrayFacturas;
      return arrayFacturas;
    } catch (error) {
      console.error('Error al cargar datos:', error);
      throw error;
    } finally {
      showLoader(false);
      isLoading = false;
    }
  }

  // Función para filtrar datos
  function filtrarDatos(datos, filtro) {
    if (filtro === 'all') return datos;
    
    const hoy = new Date();
    return datos.filter(factura => {
      const fecVenc = new Date(factura.fec_venc);
      const diasDiff = Math.ceil((fecVenc - hoy) / (1000 * 60 * 60 * 24));
      
      if (filtro === 'vencidas') {
        return diasDiff < 0;
      } else if (filtro === 'por_vencer') {
        return diasDiff >= 0 && diasDiff <= 5;
      }
      return true;
    });
  }

  if (datatables_basic_facturas.length) {
    // Destruir tabla existente si existe
    if ($.fn.DataTable.isDataTable(datatables_basic_facturas)) {
      datatables_basic_facturas.DataTable().destroy();
    }

    // Obtener datos (con cache)
    obtenerDatosFacturas().then(arrayFacturas => {
      var dt_basic = datatables_basic_facturas.DataTable({
        scrollY: 'calc(100vh - 300px)',
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: {
          header: true,
          footer: false
        },
        data: arrayFacturas,
        columns: [
          { data: 'responsive_id' },
          { data: 'nro_doc' },
          { data: 'serie_fact_num' },
          { data: 'dato6' },
          { data: 'saldo' },
          { data: 'monto_transito' },
          { data: 'co_cli' },
          { data: 'fec_emis' },
          { data: 'fec_venc' },
          { data: 'tipo_doc' },
          { data: 'tasa' },
          { data: 'saldo2' },
          { data: 'saldo3' },
          { data: 'dato4' },
          { data: 'dato1' },
          { data: 'cli_des' },
          { data: '' }
        ],
        columnDefs: [
          {
            className: 'control',
            orderable: false,
            responsivePriority: 2,
            targets: 0
          },
          { visible: false, targets: groupColumn },
          {
            targets: 1,
            visible: true,
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esAdelanto) {
                return (
                  '<div class="form-check">' +
                    '<input class="form-check-input dt-checkboxes facturas" type="checkbox" disabled ' +
                    'title="Este documento es un adelanto y no puede ser seleccionado" />' +
                    '<label class="form-check-label"></label>' +
                  '</div>'
                );
              } else {
                return (
                  `<div class="form-check"> 
                    <input class="form-check-input dt-checkboxes facturas ${full['nro_doc']}"
                      type="checkbox" ${full['nro_doc']}="${full['saldo2']}" 
                      data-${full['nro_doc']}="${full['saldo3']}" 
                      data-cocli${full['nro_doc']}="${full['co_cli']}" 
                      data-clides${full['nro_doc']}="${full['cli_des']}" 
                      data-clicond${full['nro_doc']}="${full['dato7']}" 
                      data-clicondm${full['nro_doc']}="${full['dato8']}" 
                      data-factipo${full['nro_doc']}="${full['dato9']}" 
                      data-montoimp${full['nro_doc']}="${full['dato10']}" 
                      data-montotransito${full['nro_doc']}="${full['monto_transito']}" 
                      value="${full['nro_doc']}" id="checkbox${data}" />
                    <label class="form-check-label" for="checkbox${data}"></label>
                  </div>`
                );
              }
            }
          },
          {
            targets: 2,
            title: 'Nº Documento',
            width: '10%',
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esAdelanto) {
                return (
                  '<div class="d-flex align-items-center">' +
                    '<span class="me-1">' + data + '</span>' +
                    '<span class="badge bg-warning" title="Adelanto - No puede ser seleccionado">ADEL</span>' +
                  '</div>'
                );
              }
              return data;
            }
          },
          {
            targets: 3,
            title: 'Forma',
            width: '10%',
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esNotaCredito) {
                return '<span class="badge rounded-pill bg-info" title=""></span>';
              } else if (esAdelanto) {
                return '<span class="badge rounded-pill bg-warning" title="Adelanto">Adelanto</span>';
              }
              
              var $status_number = full['dato6'];
              var $status = {
                0: { title: 'BS.D', class: 'badge-light-warning' },
                1: { title: 'USD', class: ' badge-light-success' }
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
            targets: 4,
            title: 'Saldo USD',
            width: '10%',
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esNotaCredito) {
                return (
                  '<span class="badge rounded-pill bg-danger" title="Abono a su saldo">' +
                  data + '</span>'
                );
              } else if (esAdelanto) {
                return (
                  '<span class="badge rounded-pill bg-danger" title="Adelanto">' +
                  data + '</span>'
                );
              }
              
              var status_number = full['saldo'];           
              return (
                '<span class="badge rounded-pill badge-light-success">' +
                status_number +'</span>'
              );
            }
          },
          {
            targets: 5,
            title: 'Por conciliar',
            width: '10%',
            render: function (data, type, full, meta) {
              var status_number = full['monto_transito'];           
              return (
                '<span class="badge rounded-pill badge-light-info">' +
               status_number +'</span>'
              );
            }
          },
          {
            targets: 6,
            width: '15%',
            title: 'Datos del cliente',
            visible: false,
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
            targets: 7,
            title: 'Fechas',
            width: '15%',
            render: function (data, type, full, meta) {
              const fecEmis = full['fec_emis'] || '';
              const fecVenc = full['fec_venc'] || '';
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esNotaCredito || esAdelanto) {
                return `
                  <div class="d-flex flex-column">
                    <div><small>Emisión:</small> ${fecEmis}</div>
                    <div><small>Referencia:</small> ${esNotaCredito ? 'Nota de Crédito' : 'Adelanto'}</div>
                  </div>
                `;
              }
              
              const hoy = new Date();
              const venc = new Date(fecVenc);
              const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
              
              let claseVenc = '';
              if (diasDiff < 0) claseVenc = 'text-danger';
              else if (diasDiff <= 5) claseVenc = 'text-warning';
              
              return `
                <div class="d-flex flex-column">
                  <div><small>EMISIÓN:</small> ${fecEmis}</div>
                  <div><small>VTO:</small> <span class="${claseVenc}">${fecVenc}</span></div>
                </div>
              `;
            }
          },
          {
            targets: 8,
            title: 'Fecha vencimiento',
            width: '25%',
            visible: false,
          },
          {
            targets: 9,
            title: 'Tipo',
            width: '5%',
            render: function (data, type, full, meta) {
              const tipoDoc = data || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              return data;
            }
          },
          {
            targets: 10,
            title: 'Tasa',
            width: '10%',
            render: function (data, type, full, meta) {
              var status_number = full['tasa'];           
              return (
                '<span class="badge rounded-pill badge-light-success">' +
               status_number +'</span>'
              );
            }
          },
          {
            targets: 11,
            visible: false
          },
          {
            targets: 12,
            visible: false
          },
          {
            targets: 13,
            title: 'Estatus',
            width: '10%',
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              let formaHTML = '';
              if (esNotaCredito) {
                formaHTML = '<span class="badge bg-info">N/Crédito</span>';
              } else if (esAdelanto) {
                formaHTML = '<span class="badge bg-warning">Adelanto</span>';
              } else {
                const formaNum = full['dato6'];
                const formas = {
                  0: { title: 'BS.D', class: 'badge-warning' },
                  1: { title: 'USD', class: 'badge-success' }
                };
                formaHTML = `<span class="badge ${formas[formaNum]?.class || 'badge-secondary'}">${formas[formaNum]?.title || 'N/A'}</span>`;
              }
              
              if (esNotaCredito || esAdelanto) {
                return `
                  <div class="d-flex flex-column gap-1">
                    ${formaHTML}
                    <span class="badge bg-secondary">No aplica vencimiento</span>
                  </div>
                `;
              }
              
              const dias = parseInt(full['dato4']) || 0;
              let estado = '';
              let clase = '';
              
              if (dias >= 0) {
                estado = 'Vencida';
                clase = 'bg-danger';
              } else if (dias >= -4 && dias <= -1) {
                estado = 'Próxima a vencer';
                clase = 'bg-warning';
              } else if (dias <= -5) {
                estado = 'Vigente';
                clase = 'bg-success';
              }
              
              const condicionHTML = `<span class="badge ${clase}">${estado}</span>`;
              
              return `
                <div class="d-flex flex-column gap-1">
                  ${formaHTML}
                  ${condicionHTML}
                </div>
              `;
            }
          },
          {
            targets: 14,
            title: 'Estatus',
            visible: false,
            width: '5%',
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
            targets: 1,
            orderable: false,
            responsivePriority: 3,
            render: function (data, type, full, meta) {
              return (`<div class="form-check"> <input class="form-check-input dt-checkboxes facturas ${full['nro_doc']}"
                 type="checkbox" ${full['nro_doc']}="${full['saldo2']}" data-${full['nro_doc']}="${full['saldo3']}" 
                 data-cocli${full['nro_doc']}="${full['co_cli']}" data-clides${full['nro_doc']}="${full['cli_des']}" 
                 data-clicond${full['nro_doc']}="${full['dato7']}" data-clicondm${full['nro_doc']}="${full['dato8']}" 
                 data-factipo${full['nro_doc']}="${full['dato9']}" 
                 data-montotransito${full['nro_doc']}="${full['monto_transito']}" 
                 value="${full['nro_doc']}" id="checkbox${data}" /><label class="form-check-label" for="checkbox${data}"></label></div>`);
            }
          },
          {
            targets: -1,
            title: 'Acciones',
            orderable: false,
            render: function (data, type, full, meta) {
              const tipoFiscal = full['dato9'] || '';
              const esAgenteRetencion = full['dato7'] == 1;
              const tieneIVA = tipoFiscal == 1;
              const montoTransito = parseFloat(full['monto_transito'] || 0);
              const retencionCargada = full['dato11'] != 0;
              
              const aplicaRetencion = tipoFiscal == 1 && esAgenteRetencion && tieneIVA && !retencionCargada;
              
              if (aplicaRetencion) {
                return (
                  '<div class="d-inline-flex">' +
                  '<a href="javascript:;" class="btn btn-icon btn-sm btn-outline-primary btn-retencion-sin-deposito" ' +
                  'data-factura-id="' + full['nro_doc'] + '" ' +
                  'title="Retención sin depósito">' +
                  feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                  '</a>' +
                  '</div>'
                );
              }
              
              if (retencionCargada) {
                return (
                  '<div class="d-inline-flex">' +
                  '<a href="javascript:;" class="btn btn-icon btn-sm btn-outline-success" ' +
                  'title="Retencion cargada N°:'+ full['dato11']+'" disabled>' +
                  feather.icons['check'].toSvg({ class: 'font-small-4' }) +
                  '</a>' +
                  '</div>'
                );
              }
              
              return (
                '<div class="d-inline-flex">' +
                '<a href="javascript:;" class="btn btn-icon btn-sm btn-outline-secondary" ' +
                'title="No aplica para retención" disabled>' +
                feather.icons['minus'].toSvg({ class: 'font-small-4' }) +
                '</a>' +
                '</div>'
              );
            }
          },
          {
            responsivePriority: 1,
            targets: 4
          }
        ],
        order: [[6, 'desc']],
        dom: '<"card-header card-header-buttons border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 10,
        lengthMenu: [7, 10, 25, 50, 75, 100],

        drawCallback: function (settings) {
          var api = this.api();
          var rows = api.rows().nodes();
          var last = null;
          var groupTotals = {};
        
          // Función para normalizar números con diferentes formatos
          function parseNumber(value) {
            if (typeof value === 'number') return value;
            if (!value) return 0;
            
            // Convertir a string si no lo es
            value = String(value);
            
            // Eliminar espacios en blanco
            value = value.trim();
            
            // Si tiene coma como separador decimal (formato europeo)
            if (value.indexOf(',') !== -1 && value.indexOf('.') === -1) {
              // Formato: 153,12 -> 153.12
              return parseFloat(value.replace(',', '.'));
            }
            // Si tiene punto como separador de miles y coma como decimal (formato europeo completo)
            else if (value.indexOf(',') !== -1 && value.indexOf('.') !== -1) {
              // Formato: 1.523,45 -> 1523.45
              return parseFloat(value.replace(/\./g, '').replace(',', '.'));
            }
            // Si tiene punto como separador decimal (formato americano)
            else if (value.indexOf('.') !== -1) {
              // Formato: 1523.45 -> 1523.45
              return parseFloat(value.replace(/,/g, ''));
            }
            
            // Si no tiene separadores, intentar convertir directamente
            return parseFloat(value) || 0;
          }
        
          // Función para formatear números al estilo del saldo (punto decimal, coma para miles)
          function formatNumber(num) {
            return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          }
        
          // Obtener todos los datos de la tabla
          var tableData = api.rows().data().toArray();
          
          // Calcular los totales por grupo (todas las facturas del cliente)
          tableData.forEach(function(rowData) {
            if (rowData && rowData.cli_des) {
              const group = rowData.cli_des;
              
              if (!groupTotals[group]) {
                groupTotals[group] = {
                  count: 0,
                  saldoTotal: 0,
                  montoTransitoTotal: 0,
                  saldoTotalBs: 0
                };
              }
              
              // Usar la función parseNumber para normalizar los valores
              const saldo = parseNumber(rowData.saldo);
              const montoTransito = parseNumber(rowData.monto_transito);
              const saldoBs = parseNumber(rowData.saldo2);
              
              groupTotals[group].count++;
              groupTotals[group].saldoTotal += saldo;
              groupTotals[group].montoTransitoTotal += montoTransito;
              groupTotals[group].saldoTotalBs += saldoBs;
            }
          });
        
          // Variables para rastrear el grupo actual
          var currentGroup = null;
          var groupStartRow = null;
          var groupRowIndices = [];
          
          // Recorrer todas las filas para identificar grupos
          for (var i = 0; i < rows.length; i++) {
            var rowData = api.row(rows[i]).data();
            
            if (rowData && rowData.cli_des) {
              var group = rowData.cli_des;
              
              // Si cambió el grupo
              if (group !== currentGroup) {
                // Si había un grupo anterior, agregar su última fila
                if (currentGroup !== null && groupRowIndices.length > 0) {
                  // La última fila del grupo anterior es la última en groupRowIndices
                  var lastRowIndex = groupRowIndices[groupRowIndices.length - 1];
                  
                  // Insertar fila de total DESPUÉS de la última factura del grupo
                  var totalData = groupTotals[currentGroup];
                  if (totalData) {
                    // Calcular el resultado y determinar la clase de color
                    const resultado = totalData.saldoTotal - totalData.montoTransitoTotal;
                    let resultClass = resultado >= 0 ? "text-success" : "text-danger";
                    
                    const totalRow = `
                      <tr class="total-row bg-light">
                        <td colspan="1"></td>
                        <td colspan="1" class="text-center"><strong>Total(${totalData.count} docs)</strong></td>
                        <td colspan="1"></td>
                        <td><strong class="text-success">${formatNumber(totalData.saldoTotal)} USD</strong></td>
                        <td><strong class="text-info">${formatNumber(totalData.montoTransitoTotal)} USD</strong></td>
                        <td colspan="3"></td>
                        <td><strong class="${resultClass} fs-5">${formatNumber(resultado)} USD</strong></td>
                        <td colspan="5"></td>
                      </tr>
                    `;
                    
                    $(rows[lastRowIndex]).after(totalRow);
                  }
                }
                
                // Empezar nuevo grupo
                currentGroup = group;
                groupRowIndices = [i]; // Reiniciar con la primera fila
                
                // Insertar fila de grupo ANTES de la primera factura
                $(rows[i]).before(
                  '<tr class="group">' +
                    '<td colspan="1">' +
                      '<div class="form-check">' +
                        '<input class="form-check-input group-checkbox" type="checkbox" data-group="' + group + '">' +
                        '<label class="form-check-label"></label>' +
                      '</div>' +
                    '</td>' +
                    '<td colspan="13">' + group + '</td>' +
                  '</tr>'
                );
              } else {
                // Mismo grupo, agregar índice
                groupRowIndices.push(i);
              }
            }
          }
          
          // No olvidar el último grupo
          if (currentGroup !== null && groupRowIndices.length > 0) {
            var lastRowIndex = groupRowIndices[groupRowIndices.length - 1];
            var totalData = groupTotals[currentGroup];
            
            if (totalData) {
              // Calcular el resultado y determinar la clase de color
              const resultado = totalData.saldoTotal - totalData.montoTransitoTotal;
              let resultClass = resultado >= 0 ? "text-success" : "text-danger";
              
              const totalRow = `
                <tr class="total-row bg-light">
                  <td colspan="1"></td>
                  <td colspan="1" class="text-center"><strong>Total(${totalData.count} docs)</strong></td>
                  <td colspan="1"></td>
                  <td><strong class="text-success">${formatNumber(totalData.saldoTotal)} USD</strong></td>
                  <td><strong class="text-info">${formatNumber(totalData.montoTransitoTotal)} USD</strong></td>
                  <td colspan="2"></td>
                  <td><strong class="${resultClass} fs-5">${formatNumber(resultado)} USD</strong></td>
                  <td colspan="6"></td>
                </tr>
              `;
              
              $(rows[lastRowIndex]).after(totalRow);
            }
          }
        },
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-relief-primary dropdown-toggle me-2',
            text: feather.icons['chevron-down'].toSvg({ class: 'font-small-4 me-50' }) + 'Acciones',
            buttons: [
        
                                {
                text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Reportar',
                className: 'pagar_facturas dropdown-item',
                action: function (e, dt, node, config) {
                    // Llamar directamente a la función de pago
                procesarFacturasButton();
                }
                },
                            {
                text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }) + 'Filtrar',
                className: 'dropdown-item',
                attr: {
                  'data-bs-toggle': 'modal',
                  'data-bs-target': '#FiltroBuscarFacturas'
                }
              },
              {
                extend: 'collection',
                className: 'dropdown-item',
                text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
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
                ]
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
                return '';
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
        
        dt_basic.rows().every(function() {
          var rowData = this.data();
          if (rowData.cli_des === group) {
            var rowNode = this.node();
            const checkbox = $(rowNode).find('.dt-checkboxes.facturas:not(:disabled)');
            checkbox.prop('checked', isChecked);
          }
        });
      });

      // Manejar cambios en checkboxes individuales
      $(document).on('change', '.dt-checkboxes.facturas:not(:disabled)', function() {
        var row = $(this).closest('tr');
        var rowData = dt_basic.row(row).data();
        var group = rowData.cli_des;
        
        var groupRow = row.prevAll('tr.group:first');
        while(groupRow.length && groupRow.find('.group-checkbox').data('group') !== group) {
          groupRow = groupRow.prevAll('tr.group:first');
        }
        
        if(groupRow.length) {
          var groupCheckbox = groupRow.find('.group-checkbox');
          
          var totalInGroup = 0;
          var checkedInGroup = 0;
          
          dt_basic.rows().every(function() {
            var data = this.data();
            if(data.cli_des === group) {
              var checkbox = $(this.node()).find('.dt-checkboxes.facturas:not(:disabled)');
              if (checkbox.length > 0) {
                totalInGroup++;
                if(checkbox.prop('checked')) {
                  checkedInGroup++;
                }
              }
            }
          });
          
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

      // Manejar el evento click para retención sin depósito
      $(document).on('click', '.btn-retencion-sin-deposito', function() {
        const facturaId = $(this).data('factura-id');
        const factura = obtenerDatosFacturaPorId(facturaId);
        
        if (!factura) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron obtener los datos de la factura.'
          });
          return;
        }
        
        if (factura.tipo_fiscal != 1) {
          Swal.fire({
            icon: 'warning',
            title: 'No aplicable',
            text: 'Esta factura no aplica para retención sin depósito.'
          });
          return;
        }
        
        generarModalRetencionIndividual(factura);
        $("#modalRetencionSinDeposito").modal("show");
      });

      // Manejar el botón de pago de facturas
    function procesarFacturasButton() {
        const arrayFacturas = obtenerFacturasSeleccionadas();
        
        if (arrayFacturas.length === 0) {
          mostrarAlertaAdelanto();
          return;
        }

        if (tieneMontoTransito(arrayFacturas)) {
          mostrarAlertaMontoTransito(arrayFacturas, function(continuar) {
            if (continuar) {
              procesarFacturas(arrayFacturas);
            }
          });
          return;
        }

        procesarFacturas(arrayFacturas);
    }

      // Funciones auxiliares (manteniendo las existentes)
      function obtenerFacturasSeleccionadas() {
        const facturasSeleccionadas = [];
        
        $("input[type=checkbox].facturas:checked").each(function() {
          const facturaId = $(this).val();
          const $elemento = $("." + facturaId);
          
          const facturaData = {
            id: facturaId,
            monto: parseFloat($elemento.attr(facturaId)) || 0,
            montoBs: parseFloat($elemento.attr('data-' + facturaId)) || 0,
            co_cli: $elemento.attr('data-cocli' + facturaId) || '',
            cli_des: $elemento.attr('data-clides' + facturaId) || '',
            cli_cond: $elemento.attr('data-clicond' + facturaId) || '',
            tipo_fiscal: $elemento.attr('data-factipo' + facturaId) || '',
            monto_transito: parseFloat($elemento.attr('data-montotransito' + facturaId)) || 0
          };
          
          facturasSeleccionadas.push(facturaData);
        });
        
        return facturasSeleccionadas;
      }

      function procesarFacturas(arrayFacturas) {
        const resultado = procesarFacturasSeleccionadas(arrayFacturas);
        if (resultado.error) {
          mostrarErrorFacturas(resultado.mensaje);
          return;
        }

        const { co_cli, cli_des, cli_cond, saldo, saldoBs } = resultado;

        if (cli_cond == 1) {
          preguntarRegistroRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des);
        } else {
          redireccionarSinRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs);
        }
      }

      function procesarFacturasSeleccionadas(arrayFacturas) {
        let saldo = 0.00;
        let saldoBs = 0.00;
        let co_cli_anterior = null;
        let primer_co_cli = null;
        let co_cli = "";
        let cli_des = "";
        let cli_cond = "";
        let facturas_con_error = [];

        for (let i = 0; i < arrayFacturas.length; i++) {
          const factura = arrayFacturas[i];
          
          const monto = factura.monto;
          const monto2 = factura.montoBs;
          co_cli = factura.co_cli;
          cli_des = factura.cli_des;
          cli_cond = factura.cli_cond;

          if (i === 0) {
            co_cli_anterior = co_cli;
            primer_co_cli = co_cli;
          } else if (co_cli !== co_cli_anterior) {
            facturas_con_error.push({
              factura: factura.id,
              co_cli: co_cli,
              esperado: primer_co_cli
            });
          }

          saldo = parseFloat((saldo + monto).toFixed(2));
          saldoBs = parseFloat((saldoBs + monto2).toFixed(2));
        }

        if (facturas_con_error.length > 0) {
          let mensaje = "Error: Se encontraron facturas de clientes diferentes:\n";
          facturas_con_error.forEach(function(error) {
            mensaje += `Factura ${error.factura}: co_cli=${error.co_cli} (debería ser ${error.esperado})\n`;
          });
          return { error: true, mensaje: mensaje };
        }

        return {
          error: false,
          co_cli: co_cli,
          cli_des: cli_des,
          cli_cond: cli_cond,
          saldo: saldo,
          saldoBs: saldoBs
        };
      }

      function generarTablaRetenciones(facturas, saldoTotal, saldoTotalBs, co_cli, cli_des) {
        let tablaHTML = ``;
        let tieneFacturasNoFiscales = false;

        facturas.forEach((factura, index) => {
          let facturaProcesada = factura.id.toString().trim();
          facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
          
          const esFiscal = factura.tipo_fiscal === '1';
          const esAplicableRetencion = esFiscal && factura.cli_cond == 1;
          
          if (!esFiscal) {
            tieneFacturasNoFiscales = true;
          }
          
          tablaHTML += `
            <tr class="${esAplicableRetencion ? '' : 'table-secondary'}">
              <td>${facturaProcesada}</td>
              <td>
                ${esAplicableRetencion ? 
                  `<input type="text" class="form-control num_retencion" name="num_retencion${index}" required>` : 
                  `<span class="badge bg-warning">No aplica retención</span>`
                }
              </td>
              <td>
                ${esAplicableRetencion ? 
                  `
                   <div class="input-group">
                  <span class="input-group-text">BS</span>
                  <input type="number" class="form-control monto-retencion-bs" name="monto_retencion_bs_${index}" step="0.01" min="0.01" 
                         max="${saldoTotalBs}" required> 
              </div>` : 
                  `<span class="text-muted">N/A</span>`
                }
              </td>
              <td>
                ${esAplicableRetencion ? 
                  `<input type="text" class="form-control flatpickr-basic flatpickr-input fecha_retencion" 
                        name="fecha_retencion${index}" placeholder="YYYY-MM-DD">` : 
                  `<span class="text-muted">N/A</span>`
                }
              </td>
              <td>
                ${esFiscal ? 
                  `<span class="badge bg-success">Aplicable</span>` : 
                  `<span class="badge bg-danger">Excenta</span>`
                }
              </td>
            </tr>`;
        });

        $('.tablaRetencion').html(tablaHTML);

        $('.fecha_retencion').flatpickr({
          dateFormat: 'Y-m-d',
          allowInput: true,
          defaultDate: new Date(),
          maxDate: new Date(),
        });

        $('#procesarRetencionesBtn').off('click').on('click', function() {
          procesarRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
        });
      }

      function procesarRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs) {
        let retenciones = [];
        const retencionesPendientes = [];
        let hayErrores = false;
        let indiceFactura = 0;

        $('.tablaRetenciones tbody tr').each(function() {
          const $fila = $(this);
          
          if (indiceFactura >= facturas.length) {
            return false;
          }

          const factura = facturas[indiceFactura];
          indiceFactura++;

          const esAplicableRetencion = factura.tipo_fiscal === '1' && factura.cli_cond == 1;
          
          if (!esAplicableRetencion) {
            $fila.addClass('table-info');
            return true;
          }

          const numRetencion = $fila.find('.num_retencion').val().trim();
          const montoBs = parseFloat($fila.find('.monto-retencion-bs').val());
          const fechaRetencion = $fila.find('.fecha_retencion').val().trim();
          
          if (!numRetencion || isNaN(montoBs) || montoBs <= 0 || !fechaRetencion) {
            hayErrores = true;
            $fila.addClass('table-danger');
            return true;
          }

          let numFactura = factura.id.toString().trim();
          numFactura = numFactura.startsWith('50') ? 'NF' + numFactura.substring(2) : numFactura;
          
          retencionesPendientes.push({
            $fila: $fila,
            datos: {
              factura: numFactura,
              numRetencion: numRetencion,
              montoBs: montoBs,
              fechaRetencion: fechaRetencion,
              tipoFiscal: factura.tipo_fiscal
            }
          });
        });

        if (hayErrores) {
          Swal.fire({
            icon: 'error',
            title: 'Error de datos',
            text: 'Por favor, corrige los errores en las retenciones marcadas en rojo.',
          });
          return;
        }

        if (retencionesPendientes.length === 0 && facturas.length > 0) {
          Swal.fire({
            icon: 'info',
            title: 'Sin retenciones aplicables',
            text: 'No hay facturas fiscales seleccionadas que apliquen para retención.',
          });
          return;
        }

        let solicitudesPendientes = retencionesPendientes.length;
        let totalAcumulado = 0;

        if (solicitudesPendientes === 0) {
          redireccionarConRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
          return;
        }

        retencionesPendientes.forEach(retencionPendiente => {
          obtenerTasaRetenciones(
            retencionPendiente.datos.fechaRetencion,
            retencionPendiente.datos.montoBs,
            function(montoCalculado) {
              retencionPendiente.datos.montoDolares = montoCalculado;
              retenciones.push(retencionPendiente.datos);
              
              totalAcumulado += montoCalculado;
              solicitudesPendientes--;
              
              retencionPendiente.$fila.addClass('table-success');
              
              if (solicitudesPendientes === 0) {
                setSessionData('monto_retencion', {
                  monto: totalAcumulado,
                  montobs: totalAcumulado     
                });
                
                try {
                  localStorage.setItem('retencionesArray', JSON.stringify({
                    fechaProceso: new Date().toISOString(),
                    totalRetenciones: retenciones.length,
                    totalMontoBs: retenciones.reduce((sum, r) => sum + r.montoBs, 0),
                    retenciones: retenciones
                  }));
          
                  redireccionarConRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
                } catch (e) {
                  console.error('Error al guardar retenciones:', e);
                  Swal.fire({
                    icon: 'error',
                    title: 'Error de almacenamiento',
                    text: 'No se pudieron guardar las retenciones. Intente nuevamente.',
                  });
                }
              }
            }
          );
        });
      }

      function procesarRetencionIndividual() {
        const facturaId = $('#factura_id_retencion').val();
        const factura = obtenerDatosFacturaPorId(facturaId);
        
        if (!factura) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron obtener los datos de la factura.'
          });
          return;
        }
        
        const numRetencion = $('.num_retencion_sd').val().trim();
        const montoBs = parseFloat($('.monto-retencion-bs-sd').val());
        const tasaRetencion = parseFloat($('.tasa_retencion_sd').val());
        const fechaRetencion = $('.fecha_retencion_sd').val().trim();
        const archivo = $('.facturas_documento_sd')[0].files[0];
        
        if (!numRetencion || isNaN(montoBs) || montoBs <= 0 || !fechaRetencion || isNaN(tasaRetencion)) {
          Swal.fire({
            icon: 'error',
            title: 'Datos incompletos',
            text: 'Por favor, complete todos los campos obligatorios.',
            confirmButtonColor: '#0343a5',
            confirmButtonText: 'Aceptar'
          });
          return;
        }
        
        const retencionData = {
          factura: factura.id,
          factura_id: factura.id,
          numRetencion: numRetencion,
          montoBs: montoBs,
          tasaRetencion: tasaRetencion,
          fechaRetencion: fechaRetencion,
          co_cli: factura.co_cli,
          cli_des: factura.cli_des,
          tipo_fiscal: factura.tipo_fiscal,
          tasa_configurada: parseFloat(factura.cli_condm) || 75,
          monto_base: parseFloat(factura.montoImp) || 0,
          monto_maximo: parseFloat(factura.montoBs) || 0
        };
        
        const formData = new FormData();
        formData.append('retenciones', JSON.stringify([retencionData]));
        formData.append('datos', '4');
        
        if (archivo) {
          formData.append('documento[]', archivo);
        }
        
        fetch('../admin/index.php?action=pago&tipo=1&accion=1&datos=4', {
          method: 'POST',
          body: formData    
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Retención registrada',
              text: 'La retención se ha registrado correctamente sin depósito asociado.',
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
              $("#modalRetencionSinDeposito").modal("hide");
              cargarTablaFacturasCliente();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message,
              confirmButtonColor: '#0343a5',
              confirmButtonText: 'Aceptar'
            });
          }
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor.',
            confirmButtonColor: '#0343a5',
            confirmButtonText: 'Aceptar'
          });
        });
      }

      function mostrarError(titulo, mensaje) {
        Swal.fire({
          icon: 'error',
          title: titulo,
          text: mensaje,
          confirmButtonColor: '#0343a5',
          confirmButtonText: 'Aceptar'
        });
      }

      function tieneMontoTransito(arrayFacturas) {
        for (let i = 0; i < arrayFacturas.length; i++) {
          const factura = arrayFacturas[i];
          const montoTransito = factura.monto_transito || 0;
          
          if (montoTransito > 0.01) {
            return true;
          }
        }
        return false;
      }

      function mostrarAlertaMontoTransito(arrayFacturas, callback) {
        let facturasConTransito = [];
        
        for (let i = 0; i < arrayFacturas.length; i++) {
          const factura = arrayFacturas[i];
          const montoTransito = factura.monto_transito || 0;
          
          if (montoTransito > 0.01) {
            facturasConTransito.push({
              factura: factura.id,
              monto: montoTransito
            });
          }
        }
        
        let mensaje = "Las siguientes facturas tienen montos en tránsito:<br><br>";
        facturasConTransito.forEach(function(item) {
          let facturaProcesada = item.factura.toString().trim();
          facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
          mensaje += `<strong>Factura ${facturaProcesada}:</strong> ${item.monto.toFixed(2)} USD.<br>`;
        });
        
        mensaje += "<br>¿Deseas continuar con el proceso?";

        Swal.fire({
          title: 'Montos en Tránsito Detectados',
          html: mensaje,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0343a5',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, continuar',
          cancelButtonText: 'No, cancelar',
          focusConfirm: false,
          customClass: { htmlContainer: 'text-left' }
        }).then((result) => {
          callback(result.isConfirmed);
        });
      }

      function mostrarAlertaAdelanto() {
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
          customClass: { htmlContainer: 'text-center' }
        }).then((result) => {
          if (result.isConfirmed) {
            $(".modalPagoAdelantos").modal("show");
          }
        });
      }

      function mostrarErrorFacturas(mensaje) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: mensaje
        });
      }

      function preguntarRegistroRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des) {
        const facturasAplicanRetencion = arrayFacturas.filter(factura => {
          return factura.cli_cond == 1 && factura.tipo_fiscal === '1';
        });
        
        if (facturasAplicanRetencion.length === 0) {
          redireccionarSinRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs);
          return;
        }
        
        Swal.fire({
          title: '¿Información?',
          html: `
            <div style="text-align: center;">
              <p>Este cliente es un contribuyente especial.</p>
              <p>Se han seleccionado ${facturasAplicanRetencion.length} factura(s) que aplican para retención.</p>
              <p>¿Deseas registrar <strong>Retenciones</strong> para estas facturas?</p>
              <small class="text-muted">
                Facturas aplicables: ${facturasAplicanRetencion.map(f => f.id).join(', ')}
              </small>
            </div>
          `,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0343a5',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, registrar',
          cancelButtonText: 'No, continuar',
          focusConfirm: false,
          customClass: { htmlContainer: 'text-center' },
          allowOutsideClick: false,
          allowEscapeKey: false
        }).then((result) => {
          if (result.isConfirmed) {
            generarTablaRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des);
            $(".modalAgenteRetencion").modal("show");
          } else {
            redireccionarSinRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs);
          }
        });
      }

      function redireccionarConRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs) {
        $(".modalAgenteRetencion").modal("hide");
        Swal.fire({
          icon: 'success',
          title: 'Retenciones registradas',
          text: 'Las retenciones se han cargado correctamente',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = buildUrl('index.php', {
            view: 'reportepago',
            facturas_cancelar: arrayFacturas.map(f => f.id),
            facturas_cliente_codigo: co_cli,
            facturas_cliente_2: cli_des,
            facturas_saldo: saldo.toFixed(2),
            facturas_saldo_bs: saldoBs.toFixed(2),
            con_retenciones: 1
          });
        });
      }

      function redireccionarSinRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs) {
        const params = new URLSearchParams({
          view: 'reportepago',
          facturas_cancelar: arrayFacturas.map(f => f.id),
          facturas_cliente_codigo: co_cli,
          facturas_cliente_2: cli_des,
          facturas_saldo: saldo.toFixed(2),
          facturas_saldo_bs: saldoBs.toFixed(2)
        });

        window.location.href = `index.php?${params.toString()}`;
      }

      function obtenerDatosFacturaPorId(facturaId) {
        try {
          facturaId = facturaId.toString();
          
          const $checkbox = $(`input.facturas[value="${facturaId}"]`);
          if ($checkbox.length === 0) return null;
          
          const dataAttributes = {};
          $.each($checkbox[0].attributes, function() {
            if (this.name.startsWith('data-')) {
              const key = this.name.replace('data-', '');
              dataAttributes[key] = this.value;
            }
          });
          
          const regularAttributes = {};
          $.each($checkbox[0].attributes, function() {
            if (!this.name.startsWith('data-') && this.name !== 'type' && this.name !== 'class') {
              regularAttributes[this.name] = this.value;
            }
          });
          
          return {
            id: facturaId,
            monto: parseFloat(regularAttributes[facturaId] || 0),
            montoBs: parseFloat(dataAttributes[facturaId] || 0),
            montoImp: parseFloat(dataAttributes['montoimp' + facturaId] || 0),
            co_cli: dataAttributes['cocli' + facturaId] || '',
            cli_des: dataAttributes['clides' + facturaId] || '',
            cli_cond: dataAttributes['clicond' + facturaId] || '',
            cli_condm: dataAttributes['clicondm' + facturaId] || '75',
            tipo_fiscal: dataAttributes['factipo' + facturaId] || '',
            monto_transito: parseFloat(dataAttributes['montotransito' + facturaId] || 0),
            nro_doc: facturaId,
            serie_fact_num: $checkbox.closest('tr').find('td:eq(2)').text() || facturaId
          };
        } catch (error) {
          console.error('Error al obtener datos de la factura:', error);
          return null;
        }
      }

      function generarModalRetencionIndividual(factura) {
        let facturaProcesada = factura.id.toString().trim();
        facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
        
        const montoBase = parseFloat(factura.montoImp) || 0;
        const montoMaximo = parseFloat(factura.montoBs) || 0;
        const tasaRetencionCliente = parseFloat(factura.cli_condm) || 0;
        const tasaRetencion = tasaRetencionCliente > 0 ? tasaRetencionCliente / 100 : 0.75;
        const montoRetencionCalculado = montoBase * tasaRetencion;
        
        const contenido = `
          <div class="alert alert-info">
            <h6 class="mb-0 mt-1"><strong>Base imponible:</strong> ${montoBase.toFixed(2)} BS</h6>
            <h6 class="mb-0"><strong>Tasa de retención del cliente:</strong> ${tasaRetencionCliente}%</h6>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Factura</label>
              <input type="text" class="form-control" value="${facturaProcesada}" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Cliente</label>
              <input type="text" class="form-control" value="${factura.co_cli} - ${factura.cli_des}" readonly>
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Número de Retención *</label>
              <input type="text" class="form-control num_retencion_sd" required placeholder="Ej: RET-2023-001">
            </div>
            <div class="col-md-4">
                 <label class="form-label">Monto Retención (BS) *</label>
                <div class="input-group">
                    <span class="input-group-text">BS</span>
                    <input type="number" class="form-control monto-retencion-bs-sd" step="0.01" min="0.01" 
                          max="${montoMaximo.toFixed(2)}" required 
                          value="${montoRetencionCalculado.toFixed(2)}">
                </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Fecha Retención *</label>
              <input type="text" class="form-control flatpickr-basic fecha_retencion_sd" placeholder="YYYY-MM-DD" required>
            </div>
          </div>
          
          <div class="row mb-3 d-none">
            <div class="col-md-6">
              <label class="form-label">Tasa de Retención (%) *</label>
              <input type="number" class="form-control tasa_retencion_sd" step="0.01" min="0" max="100" 
                    value="${tasaRetencionCliente}" required>
            </div>
          </div>
          
          <input type="hidden" id="factura_id_retencion" value="${factura.id}">
          <input type="hidden" id="monto_base_retencion" value="${montoBase}">
          <input type="hidden" id="monto_maximo_retencion" value="${montoMaximo}">
        `;
        
        $('#contenidoRetencionSinDeposito').html(contenido);
        
        $('.fecha_retencion_sd').flatpickr({
          dateFormat: 'Y-m-d',
          allowInput: true,
          defaultDate: new Date(),
          maxDate: new Date(),
          locale: {
            firstDayOfWeek: 1,
            weekdays: {
              shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
              longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
            },
            months: {
              shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
              longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            }
          }
        });
        
        $('#procesarRetencionSinDepositoBtn').off('click').on('click', function() {
          procesarRetencionIndividual();
        });
      }

      function filtrarTablaActual() {
        if (!$.fn.DataTable.isDataTable('.dataTablesFacturas')) return;
        
        const dt = $('.dataTablesFacturas').DataTable();
        const datosFiltrados = filtrarDatos(cacheData, currentFilter);
        
        dt.clear();
        dt.rows.add(datosFiltrados);
        dt.draw();
      }

      function refrescarDatos() {
        cacheData = null; // Invalidar cache
        currentFilter = 'all'; // Restablecer filtro
        
        // Restablecer los filtros del formulario a sus valores por defecto
        $('.comboClientesFactura').val(0);
        $('.tipo_documento').val('NO');
        $('.finicio').val('');
        $('.ffinal').val('');
        
        // Recargar datos con los parámetros por defecto
        cargarDataFacturas('NO','NO','NO','NO','NO','NO');
      }

    // AÑADIR ESTOS BOTONES DE FILTRO SI NO EXISTEN
    if (!$('.filtro-container').length) {
      const filtroContainer = $('<div class="btn-group filtro-container" role="group">').insertBefore(dt_basic.table().container().querySelector('.dt-action-buttons'));
      
      const filtroButtons = [
        {
          text: feather.icons['list'].toSvg({ class: 'me-50 font-small-4' }) + 'Todas',
          className: 'btn btn-relief-info',
          action: function() {
            currentFilter = 'all';
            filtrarTablaActual(); // Filtra datos ya cargados
          }
        },
        {
          text: feather.icons['clock'].toSvg({ class: 'me-50 font-small-4' }) + 'Por vencer',
          className: 'btn btn-relief-warning',
          action: function() {
            currentFilter = 'por_vencer';
            filtrarTablaActual(); // Filtra datos ya cargados
          }
        },
        {
          text: feather.icons['x-circle'].toSvg({ class: 'me-50 font-small-4' }) + 'Vencidas',
          className: 'btn btn-relief-danger',
          action: function() {
            currentFilter = 'vencidas';
            filtrarTablaActual(); // Filtra datos ya cargados
          }
        }
      ];

      filtroButtons.forEach(btn => {
        const $btn = $('<button>')
          .addClass(btn.className)
          .html(btn.text)
          .on('click', btn.action);
        filtroContainer.append($btn);
      });
    }

    }).catch(error => {
      console.error('Error al cargar la tabla:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudieron cargar los datos de la tabla'
      });
    });
  }
}


function cargarDataFacturas($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5){
      //const $co_cli = 'NO';
      if ($('#dataFacturas').length) {
        const exchangeRate = parseFloat($('#rate').data('rate')) || 1;
        setSessionData('change_rate', {
            exchangeRate: exchangeRate,
            exchangeRateR :exchangeRate          
          });
      $.ajax({
        type: "GET",
        url: '../admin/index.php?action=combos&a=16&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro='+$filtro+
        '&filtro2='+$filtro2+'&filtro3='+$filtro3+'&filtro4='+$filtro4+'&filtro5='+$filtro5,
    }).done(function(data) { 
    // console.log(data);
      var cadena = JSON.stringify(data);
      $('.dataFacturas').attr("value",cadena);
      if (localStorage.getItem('retencionesArray') !== null) {
          localStorage.removeItem('retencionesArray');
      } else {
        // console.log('RMn,.')
      }

      if (localStorage.getItem('monto_retencion') !== null) {
          localStorage.removeItem('monto_retencion');
      
      } else {
        //console.log('RMn,.')
      }

      cargarTablaFacturasCliente();

    });
      }
}



$(window,document,$).ready(function(){
  cargarDataFacturas('NO','NO','NO','NO','NO','NO');


  $('.btnConsultarClientes').on('click', function (e) {
  //04122025
  var $co_cli = $('.comboClientesFactura').val();
  var $tipo_documento = $('.tipo_documento').val();
  var $finicio = $('.finicio').val();
  var $ffinal = $('.ffinal').val();
 
  if($co_cli == 0){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir un Cliente!'
    });
    return;
  }
  
  if(($finicio.length == 0) || ($ffinal.length == 0)){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    });
    return;
  }
  
  // Si el tipo de documento no se ha seleccionado, pasar "TODOS"
  // Si está seleccionado, pasar el valor directamente
 // var tipoDocParam = ($tipo_documento == "NO") ? "TODOS" : $tipo_documento;
  //04122025
  // Llamar a la función con los parámetros en el orden correcto
  cargarDataFacturas($co_cli, 'NO', $finicio, $ffinal, $tipo_documento, 'NO');
  $('#FiltroBuscarFacturas').modal('hide');
});

});

function cargarDataFacturas($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5){
      //const $co_cli = 'NO';
      if ($('#dataFacturas').length) {
        const exchangeRate = parseFloat($('#rate').data('rate')) || 1;
        setSessionData('change_rate', {
            exchangeRate: exchangeRate,
            exchangeRateR :exchangeRate          
          });
      $.ajax({
        type: "GET",
        url: '../admin/index.php?action=combos&a=16&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro='+$filtro+
        '&filtro2='+$filtro2+'&filtro3='+$filtro3+'&filtro4='+$filtro4+'&filtro5='+$filtro5,
    }).done(function(data) { 
    // console.log(data);
      var cadena = JSON.stringify(data);
      $('.dataFacturas').attr("value",cadena);
      if (localStorage.getItem('retencionesArray') !== null) {
          localStorage.removeItem('retencionesArray');
      } else {
        // console.log('RMn,.')
      }

      if (localStorage.getItem('monto_retencion') !== null) {
          localStorage.removeItem('monto_retencion');
      
      } else {
        //console.log('RMn,.')
      }

      cargarTablaFacturasCliente();

    });
      }
}