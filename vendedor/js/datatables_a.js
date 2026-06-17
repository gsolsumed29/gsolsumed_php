
/*function cargarTablaFacturasCliente() {
  var datatables_basic_facturas = $('.dataTablesFacturas');
  var groupColumn = 15;
  
  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataFacturas = $('.dataFacturas').val();
    let arrayFacturas = "";
    arrayFacturas = JSON.parse(dataFacturas);
    
    var dt_basic = datatables_basic_facturas.DataTable({
       scrollY: 'calc(100vh - 300px)', // Ajusta según tu diseño
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: {
          header: true,
          footer: false
        },
      data: arrayFacturas,
      columns: [
        { data: 'responsive_id' }, //0
        { data: 'nro_doc' }, //1
        { data: 'serie_fact_num' }, //2> Nº Documento
        { data: 'dato6' }, // 3 Forma
        { data: 'saldo' }, //4 Saldo     
        { data: 'monto_transito' }, //5 Saldo     
        { data: 'co_cli' }, //6 Cliente
        { data: 'fec_emis' }, //7 Fecha Emisión
        { data: 'fec_venc' }, //8 Fecha Emisión
        { data: 'tipo_doc' }, //9 Tipo Documento
        { data: 'tasa' }, //10 Tasa
        { data: 'saldo2' }, //11
        { data: 'saldo3' }, //12
        { data: 'dato4' }, //13 Dias de retraso
        { data: 'dato1' }, //14 status
        { data: 'cli_des' } //15 Cliente
       
      //14 Cliente
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
          visible: true,
          render: function (data, type, full, meta) {
            // Verificar si es un adelanto (ADEL)
            const tipoDoc = full['tipo_doc'] || '';
            const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
            
            if (esAdelanto) {
              // Para adelantos, no mostrar checkbox y añadir tooltip informativo
              return (
                '<div class="form-check">' +
                  '<input class="form-check-input dt-checkboxes facturas" type="checkbox" disabled ' +
                  'title="Este documento es un adelanto y no puede ser seleccionado" />' +
                  '<label class="form-check-label"></label>' +
                '</div>'
              );
            } else {
              // Para facturas normales y notas de crédito, mostrar checkbox normal
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
              // Resaltar adelantos con un badge informativo
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
              // Para notas de crédito, mostrar información diferente
              return '<span class="badge rounded-pill bg-info" title=""></span>';
            } else if (esAdelanto) {
              // Para adelantos, mostrar información diferente
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
            let dataNumber =0;
            if (esNotaCredito) {
             
              // Para notas de crédito, el saldo suele ser negativo (abono)
              return (
                '<span class="badge rounded-pill bg-danger" title="Abono a su saldo">' +
                data + '</span>'
              );
            } else if (esAdelanto) {
          
              // Para adelantos
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
          title: 'Fecha emisión',
          width: '20%'
        },  
        {
          targets: 8,
          title: 'Fecha vencimiento',
          width: '20%'
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
        title: 'Condicion',
        width: '10%',
        render: function (data, type, full, meta) {
          const dias = parseInt(data) || 0;
         // console.log(dias);
          let estado = '';
          let clase = '';
          
            if (dias >= 0) {
                estado = 'Vencida';
                clase = 'badge-light-danger';
            } else if (dias >= -4 && dias <= -1) {
                estado = 'Próxima a vencer';
                clase = 'badge-light-warning';
            } else if (dias <= -5) {
                estado = 'Vigente';
                clase = 'badge-light-success';
            }
          
          return `
            <div class="d-flex justify-content-between align-items-center">
           
              <span class="badge rounded-pill ${clase}">${estado}</span>
            </div>
          `;
        }
      },
        {
          // Label
          targets: 14,
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
               data-clicond${full['nro_doc']}="${full['dato7']}" data-clicondm${full['nro_doc']}="${full['dato8']}" 
               data-factipo${full['nro_doc']}="${full['dato9']}" 
               data-montotransito${full['nro_doc']}="${full['monto_transito']}" 
               value="${full['nro_doc']}" id="checkbox${data}" /><label class="form-check-label" for="checkbox${data}"></label></div>`);
          }
        },

        {
          responsivePriority: 1,
          targets: 4
        }
      ],
      order: [[6, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 10,
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
                    '<td colspan="13">' + group + '</td>' +
                  '</tr>'
                );

              last = group;
            }
          });
      },
      buttons: [   
       
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Reportar',
          className: 'pagar_facturas btn btn-relief-primary',        
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }, 
        {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' })+'Filtrar',
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

   // Manejar click en checkbox de grupo - MODIFICADO para excluir notas de crédito y adelantos
   $(document).on('click', '.group-checkbox', function() {
    var group = $(this).data('group');
    var isChecked = $(this).prop('checked');
    
    // Buscar todas las filas de este grupo y marcar/desmarcar sus checkboxes (solo facturas seleccionables)
    dt_basic.rows().every(function() {
      var rowData = this.data();
      if (rowData.cli_des === group) {
        var rowNode = this.node();
        const checkbox = $(rowNode).find('.dt-checkboxes.facturas:not(:disabled)');
        checkbox.prop('checked', isChecked);
      }
    });
  });

  // Manejar cambios en checkboxes individuales para actualizar el estado del grupo
  $(document).on('change', '.dt-checkboxes.facturas:not(:disabled)', function() {
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
      
      // Contar checkboxes seleccionables en este grupo
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
 
   
     $('.pagar_facturas').click(function() {
        // Obtener facturas seleccionadas
        const arrayFacturas = obtenerFacturasSeleccionadas();
        
        // Validar si hay facturas seleccionadas
        if (arrayFacturas.length === 0) {
            mostrarAlertaAdelanto();
            return;
        }

        // Verificar si hay facturas con monto en tránsito
        if (tieneMontoTransito(arrayFacturas)) {
            mostrarAlertaMontoTransito(arrayFacturas, function(continuar) {
                if (continuar) {
                    procesarFacturas(arrayFacturas);
                }
            });
            return;
        }

        // Si no hay montos en tránsito, procesar normalmente
        procesarFacturas(arrayFacturas);
    });

    // Nueva función para obtener facturas seleccionadas con sus datos completos
    function obtenerFacturasSeleccionadas() {
        const facturasSeleccionadas = [];
        
        $("input[type=checkbox].facturas:checked").each(function() {
            const facturaId = $(this).val();
            const $elemento = $("." + facturaId);
            
            // Obtener todos los datos relevantes de la factura
            const facturaData = {
                id: facturaId,
                monto: parseFloat($elemento.attr(facturaId)) || 0,
                montoBs: parseFloat($elemento.attr('data-' + facturaId)) || 0,
                co_cli: $elemento.attr('data-cocli' + facturaId) || '',
                cli_des: $elemento.attr('data-clides' + facturaId) || '',
                cli_cond: $elemento.attr('data-clicond' + facturaId) || '',
                tipo_fiscal: $elemento.attr('data-factipo' + facturaId) || '', // 1 = fiscal, 6 = no fiscal
                monto_transito: parseFloat($elemento.attr('data-montotransito' + facturaId)) || 0
            };
            
            facturasSeleccionadas.push(facturaData);
        });
        
        return facturasSeleccionadas;
    }

    // Función modificada para procesar facturas con datos completos
    function procesarFacturas(arrayFacturas) {
        const resultado = procesarFacturasSeleccionadas(arrayFacturas);
        if (resultado.error) {
            mostrarErrorFacturas(resultado.mensaje);
            return;
        }

        // Asignar valores obtenidos
        const { co_cli, cli_des, cli_cond, saldo, saldoBs } = resultado;

        // Manejar contribuyente especial
        if (cli_cond == 1) {
            preguntarRegistroRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des);
        } else {
            redireccionarSinRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs);
        }
    }

    // Función modificada para procesar facturas seleccionadas
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
            let mensaje = "Error: Se encontraron facturas con co_cli diferente:\n";
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

    // Función modificada para generar tabla de retenciones con validación fiscal
    function generarTablaRetenciones(facturas, saldoTotal, saldoTotalBs, co_cli, cli_des) {
        let tablaHTML = ``;
        let tieneFacturasNoFiscales = false;

        facturas.forEach((factura, index) => {
            let facturaProcesada = factura.id.toString().trim();
            facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
            
            const esFiscal = factura.tipo_fiscal === '1'; // 1 = fiscal, 6 = no fiscal
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
                            `<input type="number" class="form-control monto-retencion-bs" 
                                  name="monto_retencion_bs_${index}" step="0.01" min="0" 
                                  max="${saldoTotalBs}" required>` : 
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
                            `<span class="badge bg-success">Fiscal</span>` : 
                            `<span class="badge bg-danger">No Fiscal</span>`
                        }
                    </td>
                </tr>`;
        });

        // Agregar advertencia si hay facturas no fiscales
        if (tieneFacturasNoFiscales) {
            tablaHTML = `${tablaHTML}`;
        } else {
            tablaHTML = `${tablaHTML}`;
        }

        $('.tablaRetencion').html(tablaHTML);

        // Inicializar Flatpickr solo para los campos aplicables
        $('.fecha_retencion').flatpickr({
            dateFormat: 'Y-m-d',
            allowInput: true,
            defaultDate: new Date(),
            maxDate: new Date(),
        });

        // Evento para procesar retenciones
        $('#procesarRetencionesBtn').off('click').on('click', function() {
            procesarRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
        });
    }

    // Función modificada para procesar retenciones (solo facturas fiscales)
  // Función modificada para procesar retenciones (solo facturas fiscales)
  function procesarRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs) {
    let retenciones = [];
    const retencionesPendientes = [];
    let hayErrores = false;
    let indiceFactura = 0; // Contador separado para las facturas

    $('.tablaRetenciones tbody tr').each(function() {
        const $fila = $(this);
        
        // Verificar que tenemos una factura correspondiente
        if (indiceFactura >= facturas.length) {
            return false; // Salir del loop si no hay más facturas
        }

        const factura = facturas[indiceFactura];
        indiceFactura++; // Incrementar el contador de facturas

        const esAplicableRetencion = factura.tipo_fiscal === '1' && factura.cli_cond == 1;
        
        // Si no aplica retención, saltar esta fila
        if (!esAplicableRetencion) {
            $fila.addClass('table-info');
            return true; // Continuar con la siguiente iteración
        }

        const numRetencion = $fila.find('.num_retencion').val().trim();
        const montoBs = parseFloat($fila.find('.monto-retencion-bs').val());
        const fechaRetencion = $fila.find('.fecha_retencion').val().trim();
        
        // Validación robusta
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

    // Si hay errores, no continuar
    if (hayErrores) {
        Swal.fire({
            icon: 'error',
            title: 'Error de datos',
            text: 'Por favor, corrige los errores en las retenciones marcadas en rojo.',
        });
        return;
    }

    // Si no hay retenciones pendientes pero hay facturas, mostrar mensaje
    if (retencionesPendientes.length === 0 && facturas.length > 0) {
        Swal.fire({
            icon: 'info',
            title: 'Sin retenciones aplicables',
            text: 'No hay facturas fiscales seleccionadas que apliquen para retención.',
        });
        return;
    }

    // Procesar cada retención con su tasa
    let solicitudesPendientes = retencionesPendientes.length;
    let totalAcumulado = 0;

    if (solicitudesPendientes === 0) {
        // Si no hay retenciones para procesar, redireccionar directamente
        redireccionarConRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
        return;
    }

    retencionesPendientes.forEach(retencionPendiente => {
        obtenerTasaRetenciones(
            retencionPendiente.datos.fechaRetencion,
            retencionPendiente.datos.montoBs,
            function(montoCalculado) {
                // Agregar el monto en dólares y guardar en el array final
                retencionPendiente.datos.montoDolares = montoCalculado;
                retenciones.push(retencionPendiente.datos);
                
                // Acumular el monto calculado
                totalAcumulado += montoCalculado;
                solicitudesPendientes--;
                
                // Marcar la fila como procesada
                retencionPendiente.$fila.addClass('table-success');
                
                // Si todas las solicitudes han terminado, actualizar el input
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
        
                        // Redireccionar después de guardar
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

    // Función para verificar si hay montos en tránsito
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

    // Función para mostrar alerta de monto en tránsito
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

    // Función para mostrar alerta de adelanto
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

    // Función para mostrar error en facturas
    function mostrarErrorFacturas(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: mensaje
        });
    }

    // Función para preguntar por registro de retenciones
    function preguntarRegistroRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des) {
      Swal.fire({
        title: '¿Información?',
        html: `
            <div style="text-align: center;">
                <p>Este cliente es un contribuyente especial.</p>
                <p>¿Deseas registrar <strong>Retenciones</strong>?</p>
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

    // Función para redireccionar con retenciones
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

    // Función para redireccionar sin retenciones
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
  }
}*/
/*=======================================================================================*/


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
        { data: 'cli_des' },//2  
        { data: 'saldo_p' }, //3
        { data: 'ultima_f' },//4       
        { data: 'direc1' }//5     
        
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

        /*
        {
          targets: 13,
          visible: false
        },   */        
        
        {
          responsivePriority: 1,
          targets: 3
        },


          {
          targets:2,
          width: '40%',
          title: 'Razón social',
          visible: true,
          render: function (data, type, full, meta) {
            const cli_des = full['cli_des'] || 'No especificado'; 
              const rif = full['rif'] || 'No especificado';    
           const telefonos = full['telefonos'] || 'No especificado';    
           const email = full['email'] || 'No especificado';       
            return `
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                ${cli_des}
                </button>
                <ul class="dropdown-menu">
                  <li><span class="dropdown-item"><strong>Rif:</strong> ${rif}</span></li>           
                  <li><span class="dropdown-item"><strong>Teléfonos:</strong> ${telefonos}</span></li>           
                  <li><span class="dropdown-item"><strong>Email:</strong> ${email}</span></li>   
                        
                </ul>
              </div>
            `;
          }
        },


         {
          targets: 4,
          width: '20%',
          title: 'Estado negociación',
          visible: true,
          render: function (data, type, full, meta) {
            const ultima_f = full['ultima_f'] || 'No especificado'; 
           const mont_cre = full['mont_cre'] || 'No especificado';    
           const plaz_pag = full['plaz_pag'] || 'No especificado';  
           const tipo_cliente = full['des_tipo'] || 'No especificado';    
            return `
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                ${ultima_f}
                </button>
                <ul class="dropdown-menu">
                  <li><span class="dropdown-item"><strong>Monto de crédito:</strong> ${mont_cre}</span></li>           
                  <li><span class="dropdown-item"><strong>Plazo:</strong> ${plaz_pag}</span></li>   
                  <li><span class="dropdown-item"><strong>Tipo cliente:</strong> ${tipo_cliente}</span></li>             
                </ul>
              </div>
            `;
          }
        },

        {
          targets: 5,
          width: '30%',
          title: 'Dirección',
          visible: true,
          render: function (data, type, full, meta) {
            const direc1 = full['direc1'] || 'No especificado'; 
            const direc2 = full['direc2'] || 'No especificado';     
            return `
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dirección
                </button>
                <ul class="dropdown-menu">
                  <li><span class="dropdown-item"><strong>Dirección:</strong> ${direc1}</span></li>   
                  <li><span class="dropdown-item"><strong>Despacho:</strong> ${direc2}</span></li>                
                </ul>
              </div>
            `;
          }
        },
       
        {
          // Label
          targets: 3,
            width: '20%',
          title: 'Saldo (USD)',
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
        { data: 'art_des' },//2
        { data: 'stock_act' },//3    
        { data: 'prec_vta1' },//4    
        { data: 'prec_vta2'},//5 
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
          title: 'Codigo',
          width: '10%'
        },  
        {
          targets: 2,
          title: 'Descripcion',
          width: '50%'
        }, 
           
        
        {
          responsivePriority: 1,
          targets: 3
        },
        
         {
          // Label
          targets: 3,
            title: 'En estock',
          width: '10%',
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
          targets: 4,
          title: 'Precio $',
          width: '10%',
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
           targets: 5,
          title: 'Precio BS.D',
          width: '10%',
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
              feather.icons['eye'].toSvg({ class: 'font-small-4 me-50' }) +
              'ver</a>' +
              '</div>' +
              '</div>'
            );
          }
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

      scrollY: 'calc(100vh - 300px)', // Ajusta según tu diseño
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: {
          header: true,
          footer: false
        },

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
         scrollY: 'calc(100vh - 300px)', // Ajusta según tu diseño
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: {
          header: true,
          footer: false
        },
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
        displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
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

function cargarTablaFacturasCliente() {
  var datatables_basic_facturas = $('.dataTablesFacturas');
  var groupColumn = 15;
  
  if (datatables_basic_facturas.length) {
    datatables_basic_facturas.DataTable().destroy();
    let dataFacturas = $('.dataFacturas').val();
    let arrayFacturas = "";
    arrayFacturas = JSON.parse(dataFacturas);
    
    var dt_basic = datatables_basic_facturas.DataTable({
       scrollY: 'calc(100vh - 300px)', // Ajusta según tu diseño
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: {
          header: true,
          footer: false
        },
      data: arrayFacturas,
      columns: [
        { data: 'responsive_id' }, //0
        { data: 'nro_doc' }, //1
        { data: 'serie_fact_num' }, //2> Nº Documento
        { data: 'dato6' }, // 3 Forma
        { data: 'saldo' }, //4 Saldo     
        { data: 'monto_transito' }, //5 Saldo     
        { data: 'co_cli' }, //6 Cliente
        { data: 'fec_emis' }, //7 Fecha Emisión
        { data: 'fec_venc' }, //8 Fecha Emisión
        { data: 'tipo_doc' }, //9 Tipo Documento
        { data: 'tasa' }, //10 Tasa
        { data: 'saldo2' }, //11
        { data: 'saldo3' }, //12
        { data: 'dato4' }, //13 Dias de retraso
        { data: 'dato1' }, //14 status
        { data: 'cli_des' } //15 Cliente
       
      //14 Cliente
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
          visible: true,
          render: function (data, type, full, meta) {
            // Verificar si es un adelanto (ADEL)
            const tipoDoc = full['tipo_doc'] || '';
            const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
            
            if (esAdelanto) {
              // Para adelantos, no mostrar checkbox y añadir tooltip informativo
              return (
                '<div class="form-check">' +
                  '<input class="form-check-input dt-checkboxes facturas" type="checkbox" disabled ' +
                  'title="Este documento es un adelanto y no puede ser seleccionado" />' +
                  '<label class="form-check-label"></label>' +
                '</div>'
              );
            } else {
              // Para facturas normales y notas de crédito, mostrar checkbox normal
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
              // Resaltar adelantos con un badge informativo
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
              // Para notas de crédito, mostrar información diferente
              return '<span class="badge rounded-pill bg-info" title=""></span>';
            } else if (esAdelanto) {
              // Para adelantos, mostrar información diferente
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
            let dataNumber =0;
            if (esNotaCredito) {
             
              // Para notas de crédito, el saldo suele ser negativo (abono)
              return (
                '<span class="badge rounded-pill bg-danger" title="Abono a su saldo">' +
                data + '</span>'
              );
            } else if (esAdelanto) {
          
              // Para adelantos
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
          title: 'Fecha emisión',
          width: '20%'
        },  
        {
          targets: 8,
          title: 'Fecha vencimiento',
          width: '20%'
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
        title: 'Condicion',
        width: '10%',
        render: function (data, type, full, meta) {
          const dias = parseInt(data) || 0;
         // console.log(dias);
          let estado = '';
          let clase = '';
          
            if (dias >= 0) {
                estado = 'Vencida';
                clase = 'badge-light-danger';
            } else if (dias >= -4 && dias <= -1) {
                estado = 'Próxima a vencer';
                clase = 'badge-light-warning';
            } else if (dias <= -5) {
                estado = 'Vigente';
                clase = 'badge-light-success';
            }
          
          return `
            <div class="d-flex justify-content-between align-items-center">
           
              <span class="badge rounded-pill ${clase}">${estado}</span>
            </div>
          `;
        }
      },
        {
          // Label
          targets: 14,
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
               data-clicond${full['nro_doc']}="${full['dato7']}" data-clicondm${full['nro_doc']}="${full['dato8']}" 
               data-factipo${full['nro_doc']}="${full['dato9']}" 
               data-montotransito${full['nro_doc']}="${full['monto_transito']}" 
               value="${full['nro_doc']}" id="checkbox${data}" /><label class="form-check-label" for="checkbox${data}"></label></div>`);
          }
        },

        {
          responsivePriority: 1,
          targets: 4
        }
      ],
      order: [[6, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 10,
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
                    '<td colspan="13">' + group + '</td>' +
                  '</tr>'
                );

              last = group;
            }
          });
      },
      buttons: [   
                  // Agregar este botón junto a los demás botones
          {
            text: feather.icons['file-text'].toSvg({ class: 'me-50 font-small-4' }) + 'Retención sin depósito',
            className: 'retencion_sin_deposito btn btn-relief-warning',
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
            }
          },
       
        {
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Reportar',
          className: 'pagar_facturas btn btn-relief-primary',        
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }, 
        {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' })+'Filtrar',
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

   // Manejar click en checkbox de grupo - MODIFICADO para excluir notas de crédito y adelantos
   $(document).on('click', '.group-checkbox', function() {
    var group = $(this).data('group');
    var isChecked = $(this).prop('checked');
    
    // Buscar todas las filas de este grupo y marcar/desmarcar sus checkboxes (solo facturas seleccionables)
    dt_basic.rows().every(function() {
      var rowData = this.data();
      if (rowData.cli_des === group) {
        var rowNode = this.node();
        const checkbox = $(rowNode).find('.dt-checkboxes.facturas:not(:disabled)');
        checkbox.prop('checked', isChecked);
      }
    });
  });

  // Manejar cambios en checkboxes individuales para actualizar el estado del grupo
  $(document).on('change', '.dt-checkboxes.facturas:not(:disabled)', function() {
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
      
      // Contar checkboxes seleccionables en este grupo
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
 
   
$('.pagar_facturas').click(function() {
        // Obtener facturas seleccionadas
        const arrayFacturas = obtenerFacturasSeleccionadas();
        
        // Validar si hay facturas seleccionadas
        if (arrayFacturas.length === 0) {
            mostrarAlertaAdelanto();
            return;
        }

        // Verificar si hay facturas con monto en tránsito
        if (tieneMontoTransito(arrayFacturas)) {
            mostrarAlertaMontoTransito(arrayFacturas, function(continuar) {
                if (continuar) {
                    procesarFacturas(arrayFacturas);
                }
            });
            return;
        }

        // Si no hay montos en tránsito, procesar normalmente
        procesarFacturas(arrayFacturas);
});

  $('.retencion_sin_deposito').click(function() {
    // Obtener facturas seleccionadas
    const arrayFacturas = obtenerFacturasSeleccionadas();
    
    // Validar si hay facturas seleccionadas
    if (arrayFacturas.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Sin selección',
        text: 'Por favor, seleccione al menos una factura para aplicar retención sin depósito.'
      });
      return;
    }

    // Verificar que al menos una factura sea de contribuyente especial y fiscal
    const facturasAplicables = arrayFacturas.filter(f => {
      // Verificar si es contribuyente especial (cli_cond == 1) y fiscal (tipo_fiscal == 1)
      return f.cli_cond == 1 && f.tipo_fiscal == 1;
    });

    if (facturasAplicables.length === 0) {
      // Mostrar qué facturas no son aplicables y por qué
      const facturasNoAplicables = arrayFacturas.map(f => {
        let razon = '';
        if (f.cli_cond != 1) razon = 'No es contribuyente especial';
        else if (f.tipo_fiscal != 1) razon = 'No es factura fiscal';
        else razon = 'No aplica para retención';
        
        return {id: f.id, razon: razon};
      });

      let mensaje = 'Ninguna factura seleccionada aplica para retención sin depósito:<br><ul>';
      facturasNoAplicables.forEach(f => {
        let facturaProcesada = f.id.toString().trim();
        facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
        mensaje += `<b>${facturaProcesada}: ${f.razon}</b>`;
      });
      mensaje += '';

      Swal.fire({
        icon: 'error',
        title: 'Facturas no aplicables',
        html: mensaje
      });
      return;
    }

    // Filtrar solo las facturas aplicables para el proceso
    const facturasParaProcesar = arrayFacturas.filter(f => f.cli_cond == 1 && f.tipo_fiscal == 1);

    // Mostrar modal para retenciones sin depósito
    generarTablaRetencionesSinDeposito(facturasParaProcesar);
    $("#modalRetencionSinDeposito").modal("show"); // Asegúrate de que el ID del modal coincida
  });

    // Nueva función para obtener facturas seleccionadas con sus datos completos
    function obtenerFacturasSeleccionadas() {
        const facturasSeleccionadas = [];
        
        $("input[type=checkbox].facturas:checked").each(function() {
            const facturaId = $(this).val();
            const $elemento = $("." + facturaId);
            
            // Obtener todos los datos relevantes de la factura
            const facturaData = {
                id: facturaId,
                monto: parseFloat($elemento.attr(facturaId)) || 0,
                montoBs: parseFloat($elemento.attr('data-' + facturaId)) || 0,
                co_cli: $elemento.attr('data-cocli' + facturaId) || '',
                cli_des: $elemento.attr('data-clides' + facturaId) || '',
                cli_cond: $elemento.attr('data-clicond' + facturaId) || '',
                tipo_fiscal: $elemento.attr('data-factipo' + facturaId) || '', // 1 = fiscal, 6 = no fiscal
                monto_transito: parseFloat($elemento.attr('data-montotransito' + facturaId)) || 0
            };
            
            facturasSeleccionadas.push(facturaData);
        });
        
        return facturasSeleccionadas;
    }

    // Función modificada para procesar facturas con datos completos
    function procesarFacturas(arrayFacturas) {
        const resultado = procesarFacturasSeleccionadas(arrayFacturas);
        if (resultado.error) {
            mostrarErrorFacturas(resultado.mensaje);
            return;
        }

        // Asignar valores obtenidos
        const { co_cli, cli_des, cli_cond, saldo, saldoBs } = resultado;

        // Manejar contribuyente especial
        if (cli_cond == 1) {
            preguntarRegistroRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des);
        } else {
            redireccionarSinRetenciones(arrayFacturas, co_cli, cli_des, saldo, saldoBs);
        }
    }

    // Función modificada para procesar facturas seleccionadas
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
            let mensaje = "Error: Se encontraron facturas con co_cli diferente:\n";
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

    // Función modificada para generar tabla de retenciones con validación fiscal
    function generarTablaRetenciones(facturas, saldoTotal, saldoTotalBs, co_cli, cli_des) {
        let tablaHTML = ``;
        let tieneFacturasNoFiscales = false;

        facturas.forEach((factura, index) => {
            let facturaProcesada = factura.id.toString().trim();
            facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
            
            const esFiscal = factura.tipo_fiscal === '1'; // 1 = fiscal, 6 = no fiscal
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
                            `<input type="number" class="form-control monto-retencion-bs" 
                                  name="monto_retencion_bs_${index}" step="0.01" min="0" 
                                  max="${saldoTotalBs}" required>` : 
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
                            `<span class="badge bg-success">Fiscal</span>` : 
                            `<span class="badge bg-danger">No Fiscal</span>`
                        }
                    </td>
                </tr>`;
        });

        // Agregar advertencia si hay facturas no fiscales
        if (tieneFacturasNoFiscales) {
            tablaHTML = `${tablaHTML}`;
        } else {
            tablaHTML = `${tablaHTML}`;
        }

        $('.tablaRetencion').html(tablaHTML);

        // Inicializar Flatpickr solo para los campos aplicables
        $('.fecha_retencion').flatpickr({
            dateFormat: 'Y-m-d',
            allowInput: true,
            defaultDate: new Date(),
            maxDate: new Date(),
        });

        // Evento para procesar retenciones
        $('#procesarRetencionesBtn').off('click').on('click', function() {
            procesarRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
        });
    }

    // Función modificada para procesar retenciones (solo facturas fiscales)
  // Función modificada para procesar retenciones (solo facturas fiscales)
  function procesarRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs) {
    let retenciones = [];
    const retencionesPendientes = [];
    let hayErrores = false;
    let indiceFactura = 0; // Contador separado para las facturas

    $('.tablaRetenciones tbody tr').each(function() {
        const $fila = $(this);
        
        // Verificar que tenemos una factura correspondiente
        if (indiceFactura >= facturas.length) {
            return false; // Salir del loop si no hay más facturas
        }

        const factura = facturas[indiceFactura];
        indiceFactura++; // Incrementar el contador de facturas

        const esAplicableRetencion = factura.tipo_fiscal === '1' && factura.cli_cond == 1;
        
        // Si no aplica retención, saltar esta fila
        if (!esAplicableRetencion) {
            $fila.addClass('table-info');
            return true; // Continuar con la siguiente iteración
        }

        const numRetencion = $fila.find('.num_retencion').val().trim();
        const montoBs = parseFloat($fila.find('.monto-retencion-bs').val());
        const fechaRetencion = $fila.find('.fecha_retencion').val().trim();
        
        // Validación robusta
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

    // Si hay errores, no continuar
    if (hayErrores) {
        Swal.fire({
            icon: 'error',
            title: 'Error de datos',
            text: 'Por favor, corrige los errores en las retenciones marcadas en rojo.',
        });
        return;
    }

    // Si no hay retenciones pendientes pero hay facturas, mostrar mensaje
    if (retencionesPendientes.length === 0 && facturas.length > 0) {
        Swal.fire({
            icon: 'info',
            title: 'Sin retenciones aplicables',
            text: 'No hay facturas fiscales seleccionadas que apliquen para retención.',
        });
        return;
    }

    // Procesar cada retención con su tasa
    let solicitudesPendientes = retencionesPendientes.length;
    let totalAcumulado = 0;

    if (solicitudesPendientes === 0) {
        // Si no hay retenciones para procesar, redireccionar directamente
        redireccionarConRetenciones(facturas, co_cli, cli_des, saldoTotal, saldoTotalBs);
        return;
    }

    retencionesPendientes.forEach(retencionPendiente => {
        obtenerTasaRetenciones(
            retencionPendiente.datos.fechaRetencion,
            retencionPendiente.datos.montoBs,
            function(montoCalculado) {
                // Agregar el monto en dólares y guardar en el array final
                retencionPendiente.datos.montoDolares = montoCalculado;
                retenciones.push(retencionPendiente.datos);
                
                // Acumular el monto calculado
                totalAcumulado += montoCalculado;
                solicitudesPendientes--;
                
                // Marcar la fila como procesada
                retencionPendiente.$fila.addClass('table-success');
                
                // Si todas las solicitudes han terminado, actualizar el input
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
        
                        // Redireccionar después de guardar
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

    // Función para verificar si hay montos en tránsito
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

    // Función para mostrar alerta de monto en tránsito
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

    // Función para mostrar alerta de adelanto
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

    // Función para mostrar error en facturas
    function mostrarErrorFacturas(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: mensaje
        });
    }

    // Función para preguntar por registro de retenciones
    function preguntarRegistroRetenciones(arrayFacturas, saldo, saldoBs, co_cli, cli_des) {
      Swal.fire({
        title: '¿Información?',
        html: `
            <div style="text-align: center;">
                <p>Este cliente es un contribuyente especial.</p>
                <p>¿Deseas registrar <strong>Retenciones</strong>?</p>
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

    // Función para redireccionar con retenciones
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

    // Función para redireccionar sin retenciones
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

    function generarTablaRetencionesSinDeposito(facturas) {
      let tablaHTML = `
        <div class="alert alert-info">
          <h6>Retención sin depósito asociado</h6>
          <p>Esta funcionalidad permite registrar retenciones sin vincularlas a un depósito específico.</p>
        </div>
        <table class="table table-striped tablaRetencionesSinDeposito">
          <thead>
            <tr>
              <th>Factura</th>
              <th>Número de Retención</th>
              <th>Monto Retención (BS)</th>
              <th>Fecha Retención</th>
              <th>Subir Archivo</th>
            </tr>
          </thead>
          <tbody>`;

      facturas.forEach((factura, index) => {
        let facturaProcesada = factura.id.toString().trim();
        facturaProcesada = facturaProcesada.startsWith('50') ? 'NF' + facturaProcesada.substring(2) : facturaProcesada;
        
        tablaHTML += `
          <tr>
            <td>${facturaProcesada}</td>
            <td>
              <input type="text" class="form-control num_retencion_sd" 
                    name="num_retencion_sd_${index}" required>
            </td>
            <td>
              <input type="number" class="form-control monto-retencion-bs-sd" 
                    name="monto_retencion_bs_sd_${index}" step="0.01" min="0" 
                    max="${factura.montoBs}" required>
            </td>
            <td>
              <input type="text" class="form-control flatpickr-basic fecha_retencion_sd" 
                    name="fecha_retencion_sd_${index}" placeholder="YYYY-MM-DD">
            </td>
            <td>
              <input type="file" class="form-control archivo_retencion_sd" 
                    name="archivo_retencion_sd_${index}" accept=".pdf,.jpg,.jpeg,.png">
            </td>
          </tr>`;
      });

      tablaHTML += `</tbody></table>`;
      
      $('#contenidoRetencionSinDeposito').html(tablaHTML);

      // Inicializar Flatpickr
      $('.fecha_retencion_sd').flatpickr({
        dateFormat: 'Y-m-d',
        allowInput: true,
        defaultDate: new Date(),
        maxDate: new Date(),
      });

      // Configurar el botón de procesar
      $('#procesarRetencionSinDepositoBtn').off('click').on('click', function() {
        procesarRetencionSinDeposito(facturas);
      });
    }

    function procesarRetencionSinDeposito(facturas) {
      let retenciones = [];
      let hayErrores = false;
      let archivos = new FormData();

      $('.tablaRetencionesSinDeposito tbody tr').each(function(index) {
        const $fila = $(this);
        const numRetencion = $fila.find('.num_retencion_sd').val().trim();
        const montoBs = parseFloat($fila.find('.monto-retencion-bs-sd').val());
        const fechaRetencion = $fila.find('.fecha_retencion_sd').val().trim();
        const archivo = $fila.find('.archivo_retencion_sd')[0].files[0];
        
        // Validaciones
        if (!numRetencion || isNaN(montoBs) || montoBs <= 0 || !fechaRetencion) {
          hayErrores = true;
          $fila.addClass('table-danger');
          return;
        }

        // Validar que el monto no exceda el saldo de la factura
        if (montoBs > facturas[index].montoBs) {
          hayErrores = true;
          $fila.addClass('table-danger');
          Swal.fire({
            icon: 'error',
            title: 'Monto excedido',
            text: `El monto de retención para la factura ${facturas[index].id} excede el saldo disponible.`
          });
          return;
        }

        // Preparar datos de la retención
        let numFactura = facturas[index].id.toString().trim();
        numFactura = numFactura.startsWith('50') ? 'NF' + numFactura.substring(2) : numFactura;
        
        retenciones.push({
          factura: numFactura,
          factura_id: facturas[index].id,
          numRetencion: numRetencion,
          montoBs: montoBs,
          fechaRetencion: fechaRetencion,
          co_cli: facturas[index].co_cli,
          cli_des: facturas[index].cli_des
        });

        // Agregar archivo al FormData si existe
        if (archivo) {
          archivos.append(`archivo_retencion_${index}`, archivo);
          archivos.append(`factura_archivo_${index}`, facturas[index].id);
        }
      });

      if (hayErrores) {
        Swal.fire({
          icon: 'error',
          title: 'Error en los datos',
          text: 'Por favor, complete correctamente todos los campos requeridos.'
        });
        return;
      }

      // Agregar datos de retenciones al FormData
      archivos.append('retenciones', JSON.stringify(retenciones));
      archivos.append('tipo', 'sin_deposito');

      // Mostrar carga
      Swal.fire({
        title: 'Procesando retenciones',
        text: 'Por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Enviar datos al servidor
      $.ajax({
        url: 'procesar_retencion_sin_deposito.php',
        type: 'POST',
        data: archivos,
        processData: false,
        contentType: false,
        success: function(response) {
          Swal.close();
          try {
            const result = JSON.parse(response);
            if (result.success) {
              Swal.fire({
                icon: 'success',
                title: 'Retenciones registradas',
                text: 'Las retenciones se han registrado correctamente sin depósito asociado.',
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                $(".modalRetencionSinDeposito").modal("hide");
                // Recargar la tabla para reflejar los cambios
                datatables_basic_facturas.DataTable().ajax.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message || 'Ocurrió un error al procesar las retenciones.'
              });
            }
          } catch (e) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error inesperado al procesar la respuesta del servidor.'
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor. Intente nuevamente.'
          });
        }
      });
    }
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
        { data: 'serie_fact_num' },//2
        { data: 'nro_doc' },//3
        { data: 'dato5' },//4
        { data: 'forma_pag' },//5
        { data: 'ref_ban' },//6
        { data: 'monto' },//7
        { data: 'monto_bs' },//8   
        { data: 'fec_tran' },//9  
        { data: 'estatus' },//10       
        { data: '' },//11
       
          
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
          visible: false
        },       
        {
          targets: 5,
           title: 'Forma de Pago',
          width: '10%'
          
        },  
        {
          targets: 4,
          width: '15%',
          title: 'Datos del cliente',
          render: function (data, type, full, meta) {
            const cli_des = full['dato6'] || 'No especificado'; 
            const co_cli = full['dato5'] || 'No especificado';     
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
          targets: 6,
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
          targets: 7,
           title: 'Monto',
          width: '10%'
          
        },    
        {
          targets: 8,
           title: 'Monto Bs.D',
          visible: true
        },   
        {
          targets: 9,
           title: 'Fecha de Transacción',
          visible: true
        },   
        {
          responsivePriority: 1,
          targets: 3
        },

        {
          // Label
          targets: 10,
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
      order: [[9, 'desc']],
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
             {
          text: feather.icons['search'].toSvg({ class: 'me-50 font-small-4' }),
          className: 'btn btn-relief-info',  
         /* attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#FiltroBuscarFacturas'
          }, */     
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
              return '';
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

function cargarTablaPagosRealizados($cliente) {
  var dt_basic_table_facturaciones = $('.dataTablesPagosRealizados');   

    
  if (dt_basic_table_facturaciones.length) {
    // Destruir tabla existente si hay una
    if ($.fn.DataTable.isDataTable(dt_basic_table_facturaciones)) {
      dt_basic_table_facturaciones.DataTable().destroy();
    }
    
    // Obtener datos de pagos
    let dataPagos = $('.dataPagosRealizados').val();
    let arrayFacturaciones = JSON.parse(dataPagos);
    
    // Configuración de DataTable
    var dt_basic = dt_basic_table_facturaciones.DataTable({
      data: arrayFacturaciones,
      columns: [   
        { data: 'responsive_id' },
        { data: 'id' },
        { data: 'ref_ban' },
        { data: 'forma_pag' },  
        { data: 'fec_emis' },
        { data: 'monto' },
        { data: 'monto_bs' },
        { data: 'archivos' },
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
          visible: true,
          responsivePriority: 1
        },      
        {
          targets: 4,
          title: 'Fecha de Transacción',
          visible: true
        },  
        {
          targets: 5,
          title: 'Monto USD',
          visible: true,
          render: function (data, type, full, meta) {
            let monto = full['monto_cob'];
            let montodolares = Number(monto).toFixed(2);
            return Number(montodolares) < 0 
              ? '<span class="badge rounded-pill bg-danger">'+montodolares+'</span>'
              : '<span class="badge rounded-pill bg-success">'+montodolares+'</span>';
          }
        },
        {
          targets: 6,
          title: 'Monto BS.D',
          visible: true,
          render: function (data, type, full, meta) {
            let monto = full['monto_cob_bs'];
            let montobs = Number(monto).toFixed(2);
            return Number(montobs) < 0 
              ? '<span class="badge rounded-pill bg-danger">'+montobs+'</span>'
              : '<span class="badge rounded-pill bg-warning">'+montobs+'</span>';
          }
        },
        {
          targets: 7,
          title: 'Comprobantes',
          visible: true,
          orderable: false,
          render: function (data, type, full, meta) {
            // Verificar si hay archivos
            if (!full.archivos || full.archivos.length === 0) {
              return '<span class="text-muted">Sin comprobantes</span>';
            }
            
            // Crear contenedor para miniaturas
            let html = '<div class="comprobantes-container" style="display: flex; flex-wrap: wrap; gap: 5px;">';
            
            // Mostrar hasta 3 miniaturas + indicador si hay más
            const maxVisible = 3;
            const totalArchivos = full.archivos.length;
            
            for (let i = 0; i < Math.min(totalArchivos, maxVisible); i++) {
              const archivo = full.archivos[i];
              
              if (archivo.esPDF) {
                // Para PDF: mostrar icono de documento con función para abrir PDF
                html += `
                  <div class="pdf-thumbnail" 
                       style="width: 50px; height: 50px; background: #f8f9fa; border: 1px solid #dee2e6; 
                              border-radius: 0.25rem; display: flex; flex-direction: column; 
                              align-items: center; justify-content: center; cursor: pointer;"
                       onclick="abrirPDF('${archivo.datos}', '${archivo.nombre.replace(/'/g, "\\'")}')"
                       title="${archivo.nombre} (PDF) - Click para ver">
                    <i class="fas fa-file-pdf" style="font-size: 20px; color: #dc3545;"></i>
                    <small style="font-size: 8px; color: #6c757d;">PDF</small>
                  </div>
                `;
              } else {
                // Para imágenes: mostrar miniatura con lightbox
                html += `
                  <a href="${archivo.datos}" class="enlace-imagen" 
                     data-lightbox="comprobantes-${full.id}" 
                     data-title="Comprobante ${i+1} de ${totalArchivos} - ${archivo.nombre}">
                    <img src="${archivo.datos}" class="img-thumbnail" 
                         style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                         title="${archivo.nombre}">
                  </a>
                `;
              }
            }
            
            // Si hay más de 3 archivos, mostrar indicador
            if (totalArchivos > maxVisible) {
              html += `
                <div class="mas-comprobantes" style="width: 50px; height: 50px; background: #f8f9fa; 
                     display: flex; align-items: center; justify-content: center; border: 1px solid #dee2e6; 
                     border-radius: 0.25rem; cursor: pointer;" 
                     title="Ver todos los comprobantes" 
                     onclick="mostrarTodosComprobantes(${full.id})">
                  +${totalArchivos - maxVisible}
                </div>
              `;
            }
            
            html += '</div>';
            return html;
          }
        },
        {
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            return `
              <div class="d-flex align-items-center col-actions">
                <a href="javascript:;" data-id="${full.id}" class=" btn btn-danger dropdown-item eliminar-pago btn-action-movil" style="cursor: pointer;width: auto;">
                  ${feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' })}                  
                </a>
              </div>
            `;
          }
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
              exportOptions: { columns: [2, 3, 4, 5, 6, 7] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4, 5, 6, 7] }
            }
          ]
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              return 'Detalles del Pago';
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              if (!col.title) return '';
              
              if (col.title === 'Acciones') {
                return `
                  <tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}">
                    <td>${col.title}:</td>
                    <td>
                      <a href="javascript:;" data-id="${api.row(rowIdx).data().id}" 
                         class="btn btn-sm btn-danger eliminar-pago btn-action-movil">
                        Eliminar Pago
                      </a>
                    </td>
                  </tr>
                `;
              }
              
              // Mostrar todos los comprobantes en la vista responsive
              if (col.title === 'Comprobantes') {
                const fullData = api.row(rowIdx).data();
                if (!fullData.archivos || fullData.archivos.length === 0) {
                  return `
                    <tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}">
                      <td>${col.title}:</td>
                      <td>Sin comprobantes</td>
                    </tr>
                  `;
                }
                
                let comprobantesHtml = '<div style="display: flex; flex-direction: column; gap: 10px;">';
                fullData.archivos.forEach((archivo, index) => {
                  if (archivo.esPDF) {
                    comprobantesHtml += `
                      <div>
                        <a href="javascript:void(0)" onclick="abrirPDF('${archivo.datos.replace(/'/g, "\\'")}', '${archivo.nombre.replace(/'/g, "\\'")}')"
                           style="display: block; margin-bottom: 5px; text-decoration: none; cursor: pointer;">
                          <i class="fas fa-file-pdf" style="color: #dc3545; margin-right: 5px;"></i>
                          Comprobante ${index + 1}: ${archivo.nombre} (PDF)
                        </a>
                        <small class="text-muted">Haga clic para ver el PDF</small>
                      </div>
                    `;
                  } else {
                    comprobantesHtml += `
                      <div>
                        <a href="${archivo.datos}" target="_blank" 
                           style="display: block; margin-bottom: 5px;">
                          Comprobante ${index + 1}: ${archivo.nombre}
                        </a>
                        <img src="${archivo.datos}" 
                             style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                      </div>
                    `;
                  }
                });
                comprobantesHtml += '</div>';
                
                return `
                  <tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}">
                    <td>${col.title}:</td>
                    <td>${comprobantesHtml}</td>
                  </tr>
                `;
              }
              
              return `
                <tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}">
                  <td>${col.title}:</td>
                  <td>${col.data}</td>
                </tr>
              `;
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
      }
    });
        
    // Delegación de eventos para eliminar pagos
    $(document).on('click', '.eliminar-pago, .btn-action-movil', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const id = $(this).data('id');
        const $btn = $(this);
        
        if ($btn.hasClass('procesando')) return;
        $btn.addClass('procesando');
        
        Swal.fire({
            title: '¿Eliminar este pago?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#0343a5',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false
        }).then((result) => {
            $btn.removeClass('procesando');
            
            if (result.isConfirmed) {
                // Obtener tabla DataTable
                var table = $('.dataTablesPagosRealizados').DataTable();
                
                // Cerrar modal responsive si está abierto
                if (table.responsive.hasHidden()) {
                    $('.dtr-modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    table.responsive.recalc();
                }
                
                // Actualizar datos
                const pagosRegistrados = JSON.parse(localStorage.getItem('pagosRegistrados')) || [];
                const nuevosPagos = pagosRegistrados.filter(pago => pago.id !== id);
                localStorage.setItem('pagosRegistrados', JSON.stringify(nuevosPagos));
                
                // Recargar tabla
                cargarDataPagosRealizados();
                estadoCuentaPagosRealizados();
                
                Swal.fire(
                    'Eliminado!',
                    'El pago ha sido eliminado.',
                    'success'
                );
            }
        });
    });

    // Inicializar lightbox para las imágenes
    $(document).on('click', '.enlace-imagen', function(e) {
      e.preventDefault();
    });

    $('div.head-label').html('<h3 class="mb-0">'+$cliente+'</h3>');
  }
}

// Función para abrir PDF en una nueva ventana/pestaña
function abrirPDF(dataURL, nombreArchivo) {
  // Crear una ventana nueva
  const ventanaPDF = window.open('', '_blank');
  
  // Crear contenido HTML para visualizar el PDF
  const htmlContent = `
    <!DOCTYPE html>
    <html>
    <head>
      
      <style>
        body { margin: 0; padding: 20px; background: #f4f4f4; }
        .container { max-width: 100%; margin: 0 auto; }
        .header { background: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .pdf-viewer { width: 100%; height: calc(100vh - 100px); border: none; background: white; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .download-btn { background: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; margin-right: 10px; }
        .close-btn { background: #6c757d; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
                 <button class="download-btn" onclick="descargarPDF()">Descargar PDF</button>
          <button class="close-btn" onclick="window.close()">Cerrar</button>
        </div>
        <iframe class="pdf-viewer" src="${dataURL}"></iframe>
      </div>
      <script>
        function descargarPDF() {
          const link = document.createElement('a');
          link.href = '${dataURL}';
          link.download = '${nombreArchivo}';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }
      </script>
    </body>
    </html>
  `;
  
  // Escribir el contenido en la nueva ventana
  ventanaPDF.document.write(htmlContent);
  ventanaPDF.document.close();
}

// Función alternativa para abrir PDF (método más simple)
function abrirPDFAlternativo(dataURL, nombreArchivo) {
  // Crear enlace temporal para descargar/abrir
  const link = document.createElement('a');
  link.href = dataURL;
  link.target = '_blank';
  link.download = nombreArchivo;
  
  // Simular click
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

// Función para mostrar todos los comprobantes
function mostrarTodosComprobantes(id) {
  // Obtener los datos del pago
  const pagosRegistrados = JSON.parse(localStorage.getItem('pagosRegistrados')) || [];
  const pago = pagosRegistrados.find(p => p.id === id);
  
  if (!pago || !pago.archivos || pago.archivos.length === 0) {
    Swal.fire('Info', 'No hay comprobantes para mostrar', 'info');
    return;
  }
  
  // Crear contenido para el modal
  let contenidoModal = '<div style="max-height: 70vh; overflow-y: auto;">';
  
  pago.archivos.forEach((archivo, index) => {
    if (archivo.esPDF) {
      contenidoModal += `
        <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
          <h5>Comprobante ${index + 1}: ${archivo.nombre} (PDF)</h5>
          <button onclick="abrirPDF('${archivo.datos.replace(/'/g, "\\'")}', '${archivo.nombre.replace(/'/g, "\\'")}')"
                  style="background: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-file-pdf"></i> Ver PDF
          </button>
        </div>
      `;
    } else {
      contenidoModal += `
        <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
          <h5>Comprobante ${index + 1}: ${archivo.nombre}</h5>
          <img src="${archivo.datos}" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px;">
        </div>
      `;
    }
  });
  
  contenidoModal += '</div>';
  
  // Mostrar modal con todos los comprobantes
  Swal.fire({
    title: `Todos los comprobantes (${pago.archivos.length})`,
    html: contenidoModal,
    width: '90%',
    confirmButtonText: 'Cerrar'
  });
}

// Función para mostrar todos los comprobantes en un modal
function mostrarTodosComprobantes(idPago) {
  // Obtener datos del pago
  const pagosRegistrados = JSON.parse(localStorage.getItem('pagosRegistrados')) || [];
  const pago = pagosRegistrados.find(p => p.id === idPago);
  
  if (!pago || !pago.archivos || pago.archivos.length === 0) return;
  
  // Crear contenido del modal
  let modalContent = `
    <div class="modal fade" id="modalComprobantes${idPago}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Comprobantes de Pago - Referencia: ${pago.ref_ban || 'N/A'}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="comprobantes-gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
  `;
  
  pago.archivos.forEach((archivo, index) => {
    modalContent += `
      <div class="comprobante-item text-center">
        <a href="${archivo.datos}" data-lightbox="comprobantes-modal-${idPago}" data-title="${archivo.nombre}">
          <img src="${archivo.datos}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: contain;">
        </a>
        <div class="mt-2 small text-truncate" title="${archivo.nombre}">
          ${archivo.nombre}
        </div>
      </div>
    `;
  });
  
  modalContent += `
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  `;
  
  // Agregar modal al DOM si no existe
  if (!$(`#modalComprobantes${idPago}`).length) {
    $('body').append(modalContent);
  }
  
  // Mostrar modal
  $(`#modalComprobantes${idPago}`).modal('show');
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


function cargarTablaClientesCandidatos(){
  var dt_basic_table_clientes_visitas = $('.datatables-basic-clientes-candidatos');   
  // Advanced Filter table
  if (dt_basic_table_clientes_visitas.length) {
    
  $('input.dt-input').on('keyup', function () {
    filterColumn($(this).attr('data-column'), $(this).val());
  });

    let dataClientesCandidatos =  $('.dataClientesCandidatos').val();
    //console.log(dataUsuarios);
    let arrayClientes = "";
    arrayClientes = JSON.parse(dataClientesCandidatos);
    var dt_adv_filter = dt_basic_table_clientes_visitas.DataTable({
         scrollY: 'calc(100vh - 300px)', // Ajusta según tu diseño
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: {
          header: true,
          footer: false
        },
      data : arrayClientes,
      columns: [
        { data: 'responsive_id' },//0
        { data: 'co_cli' },    //1     
        { data: 'cli_des' },//2 
        { data: 'rif' },//3    
        { data: 'telefonos' }, // 4     
        { data: 'email' }, // 5    
        { data: 'direc1' }, // 6
        { data: '' }//  6 
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
          // Actions
          targets: -1,
          title: 'Acciones',
          width: '20px',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +                       
              '</div>' +
              '</div>' +
              '</div>'
            );

              /*return (
              '<div class="d-flex align-items-center col-actions">' +             
              '<a class="me-25" href="index.php?view=cliente&co_cli='+full['co_cli']+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">' +
              feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
              '</a>' +                       
              '</div>' +
              '</div>' +
              '</div>'
            );*/
          }
        }, 
       
       
        {
        
        }
      ],
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      orderCellsTop: true,
        displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
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


$(window,document,$).ready(function(){
  'use strict';
  
  cargarDataUsers();
  cargarDataArticulos('NO');
  cargarDataClientes();
  cargarDataVendedores();
  cargarDataPedidos(0,'NO');
  cargarDataFacturaciones(0,'NO');
  eliminarPagosRegistrados();

  cargarDataClientesCandidatos();

  cargarDataFacturas('NO','NO','NO','NO','NO','NO');

  cargarDataPagos('NO','NO','NO','NO','NO','NO');

  cargarDataCuentasPorCobrar();
  cargarDataCobrosMes('NO','NO');
  cargarDataVisitas();
  cargarDataClientesVisitas();
  cargarDataAprobaciones(0,'NO');

  cargarDataCobros('NO','NO');

  cargarDataPagosRealizados();
  
  cargarDataVentasxDia('NO','NO');
  cargarDataArticuloFoco('NO','NO');

  if ($('.reportexva').length) {

    estadisticasMes('NO');
    cargarDataMeses('NO');

  }

  if ($('.reportexvl').length) {

    estadisticasMesLinea('NO');
    cargarDataMesesLinea('NO');

  }

$('#btnModalAgregarPagos').on('click', function (e) {
    // Obtener el valor de las retenciones    
    
    $('#modalPagoFacturas').modal('show');
});


  if ($('#PagosRealizados').length) {
        var facturas = $('#facturas_cancelar_text').data('facturas');
      //console.log(facturas);
      // Convertir a array y limpiar los valores
      if (typeof facturas === 'string') {
          facturas = facturas.split(',').map(f => f.trim()).filter(f => f !== '');
      } else if (!Array.isArray(facturas)) {
          facturas = [facturas];
      }

      // Procesar las facturas disponibles
      if (facturas.length > 0) {
          var procesadas = facturas.map(function(f) {
              f = f.toString().trim(); // Asegurar que es string
              return f.startsWith('50') ? 'NF' + f.substring(2) : f;
          });
          
          $('#facturas_cancelar_text').text(procesadas.join(', '));
      } else {
          $('#facturas_cancelar_text').text('Datos insuficientes');
      }

  
  }


  if($('#perfilCLiente').length){

        const AppState = {
          stream: null,
          photoDataUrl: '',
          locationData: {
              latitude: null,
              longitude: null,
              accuracy: null,
              timestamp: null
          }
      };

      // Inicialización de la aplicación
      function initializeApp() {
          setupEventListeners();
         
      }

      // Configuración de event listeners
      function setupEventListeners() {
        
          $('#getLocation').on('click', handleGetLocation);
        
          $(window).on('beforeunload', handleWindowUnload);
      }

   


      // Manejador para obtener ubicación
      function handleGetLocation() {
          getCurrentPosition()
              .then(position => {
                  AppState.locationData = {
                      latitude: position.coords.latitude,
                      longitude: position.coords.longitude,
                      accuracy: position.coords.accuracy,
                      timestamp: new Date(position.timestamp).toLocaleString()
                  };
                  
                  updateLocationUI(AppState.locationData);
                  $('#saveData').prop('disabled', false);
                  showStatus('Ubicación obtenida correctamente', 'success');
              })
              .catch(handleGeolocationError);
      }

      // Función para obtener posición actual
      function getCurrentPosition() {
          return new Promise((resolve, reject) => {
              if (!navigator.geolocation) {
                  reject(new Error('Geolocalización no soportada'));
                  return;
              }
              
              navigator.geolocation.getCurrentPosition(
                  resolve,
                  reject,
                  { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
              );
          });
      }

      // Manejador de errores de geolocalización
      function handleGeolocationError(error) {
          const errorMessages = {
              1: 'El usuario denegó el permiso de geolocalización',
              2: 'La información de ubicación no está disponible',
              3: 'La solicitud de geolocalización ha caducado',
              default: 'Ocurrió un error desconocido'
          };
          
          showStatus('Error de geolocalización: ' + (errorMessages[error.code] || errorMessages.default), 'error');
      }

      // Actualizar UI con datos de ubicación
      function updateLocationUI(location) {
          $('#latitude').text(location.latitude);
          $('#longitude').text(location.longitude);
          $('#accuracy').text(location.accuracy);
          $('#timestamp').text(location.timestamp);
      }

      // Manejador para guardar datos
      function handleSaveData() {
          if (!validateDataBeforeSave()) return;
          
          const photoData = AppState.photoDataUrl.split(',')[1];
          const locationData = AppState.locationData;
          
          saveDataToServer(photoData, locationData)
              .then(response => {
                  if (response.success) {
                      showStatus('Datos guardados correctamente', 'success');
                  } else {
                      showStatus('Error al guardar: ' + response.message, 'error');
                  }
              })
              .catch(error => {
                  showStatus('Error de conexión: ' + error, 'error');
              });
      }

      // Validar datos antes de guardar
      function validateDataBeforeSave() {
                  
          if (!AppState.locationData.latitude) {
              showStatus('Primero debes obtener la ubicación', 'error');
              return false;
          }
          
          return true;
      }

     

      // Manejador para cuando se cierra la ventana
      function handleWindowUnload() {
          if (AppState.stream) {
              AppState.stream.getTracks().forEach(track => track.stop());
          }
      }

      // Mostrar mensaje de estado
      function showStatus(message, type) {
          $('#statusMessage')
              .removeClass('success error')
              .addClass(type)
              .text(message);
      }

      // Iniciar la aplicación
      initializeApp();

  }
    if($('#perfilCandidato').length){

        const AppState = {
          stream: null,
          photoDataUrl: '',
          locationData: {
              latitude: null,
              longitude: null,
              accuracy: null,
              timestamp: null
          }
      };

      // Inicialización de la aplicación
      function initializeApp() {
          setupEventListeners();
         
      }

      // Configuración de event listeners
      function setupEventListeners() {
        
          $('#getLocation').on('click', handleGetLocation);
        
          $(window).on('beforeunload', handleWindowUnload);
      }

   


      // Manejador para obtener ubicación
      function handleGetLocation() {
        //alert('hola');
          getCurrentPosition()
              .then(position => {
                  AppState.locationData = {
                      latitude: position.coords.latitude,
                      longitude: position.coords.longitude,
                      accuracy: position.coords.accuracy,
                      timestamp: new Date(position.timestamp).toLocaleString()
                  };
                  
                  updateLocationUI(AppState.locationData);
                  $('#saveData').prop('disabled', false);
                  showStatus('Ubicación obtenida correctamente', 'success');
              })
              .catch(handleGeolocationError);
      }

      // Función para obtener posición actual
      function getCurrentPosition() {
          return new Promise((resolve, reject) => {
              if (!navigator.geolocation) {
                  reject(new Error('Geolocalización no soportada'));
                  return;
              }
              
              navigator.geolocation.getCurrentPosition(
                  resolve,
                  reject,
                  { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
              );
          });
      }

      // Manejador de errores de geolocalización
      function handleGeolocationError(error) {
          const errorMessages = {
              1: 'El usuario denegó el permiso de geolocalización',
              2: 'La información de ubicación no está disponible',
              3: 'La solicitud de geolocalización ha caducado',
              default: 'Ocurrió un error desconocido'
          };
          
          showStatus('Error de geolocalización: ' + (errorMessages[error.code] || errorMessages.default), 'error');
      }

      // Actualizar UI con datos de ubicación
      function updateLocationUI(location) {
          $('#latitude').text(location.latitude);
          $('#longitude').text(location.longitude);
          $('#accuracy').text(location.accuracy);
          $('#timestamp').text(location.timestamp);
      }

      // Manejador para guardar datos
      function handleSaveData() {
          if (!validateDataBeforeSave()) return;
          
          const photoData = AppState.photoDataUrl.split(',')[1];
          const locationData = AppState.locationData;
          
          saveDataToServer(photoData, locationData)
              .then(response => {
                  if (response.success) {
                      showStatus('Datos guardados correctamente', 'success');
                  } else {
                      showStatus('Error al guardar: ' + response.message, 'error');
                  }
              })
              .catch(error => {
                  showStatus('Error de conexión: ' + error, 'error');
              });
      }

      // Validar datos antes de guardar
      function validateDataBeforeSave() {
                  
          if (!AppState.locationData.latitude) {
              showStatus('Primero debes obtener la ubicación', 'error');
              return false;
          }
          
          return true;
      }

     

      // Manejador para cuando se cierra la ventana
      function handleWindowUnload() {
          if (AppState.stream) {
              AppState.stream.getTracks().forEach(track => track.stop());
          }
      }

      // Mostrar mensaje de estado
      function showStatus(message, type) {
          $('#statusMessage')
              .removeClass('success error')
              .addClass(type)
              .text(message);
      }

      // Iniciar la aplicación
      initializeApp();

  }
  
    var sidebarShop = $('.sidebar-shop'),
    btnCart = $('.btn-cart'),
    overlay = $('.body-content-overlay'),
    sidebarToggler = $('.shop-sidebar-toggler'),
    sortingDropdown = $('.dropdown-sort .dropdown-item'),
    sortingText = $('.dropdown-toggle .active-sorting'),
    removeItem = $('.remove-card');
    

$('.btnConsultarClientes').on('click', function (e) {
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
  var tipoDocParam = ($tipo_documento == "NO") ? "TODOS" : $tipo_documento;
  
  // Llamar a la función con los parámetros en el orden correcto
  cargarDataFacturas($co_cli, tipoDocParam, $finicio, $ffinal, 'NO', 'NO');
  $('#FiltroBuscarFacturas').modal('hide');
});



$('.btnConsultarClientesPagos').on('click', function (e) {
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
    cargarDataPagos($co_cli,'NO',$finicio,$ffinal,'NO','NO');
    $('#FiltroBuscarFacturas').modal('hide');
  }
});


if ($('#perfilCLiente').length) {
    // console.log('perfilCliente');
      let co_cli= $('#co_cli').val();  
      perfilCliente(co_cli);
    // localizacionData(co_cli);
}

$(".facturas_fecha").flatpickr({
    dateFormat: "Y-m-d",
    defaultDate: "today",
    maxDate: "today",
    onChange: function(selectedDates, dateStr, instance) {
    
        obtenerTasa(dateStr);
        
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDates[0] > today) {
            alert("¡Error! No se permiten fechas futuras. Se ajustará a hoy.");
            instance.setDate(today);
        }
    }
});



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



if ($('.modalPagoAdelantos').length) {
  // Tipo de cambio
  const change_rate = getSessionData('change_rate');
    // Tipo de cambio
  let exchangeRate = parseFloat(change_rate.exchangeRate)
  
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
 

$('.btnActualiarCliente_14082025').on('click', function (e) {
  
        let cli_telefono = $('#cli_telefono').val();     
        let cli_parroquia = $('#cli_parroquia').val();
        let cli_sector = $('#cli_sector').val();
        let cli_email = $('#cli_email').val();
        let co_cli = $('#co_cli').val();
        
     
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

$('#btnBuscarReferencia').on('click', function (e) {

    let referencia = $('#facturas_referencia').val().trim(); // .trim() elimina espacios en blan
    if(referencia ==''){
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debe escribir el numero de referencia a buscar, Recuerde que para agregar varias, debe colocar coma(,).'    
     })
     $('.facturas_referencia').focus();
    }else{
          let status = buscarDataReferencia(referencia);
    }
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

if ($('.m_visitas_cantidatos').length) {
  resaltarMenu('.i_visitas_candidatos');
}



if ($('.m_reportexva').length) {
  resaltarMenu('.i_reportexva');
}

if ($('.m_reportexvl').length) {
  resaltarMenu('.i_reportexvl');
}



/************************************** */
if ($('.comboLineas_mayor').length) {  
 cargarDataComboLineas('.comboLineas_mayor', 1);
}
if ($('.comboLineas_menor').length) {  
 cargarDataComboLineas('.comboLineas_menor', 1);
}

/************************ */

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
  //11082025
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


$('.comboClientesAdelantos').on('change', function () {
  var $co_cli = $('.comboClientesAdelantos').val();
    cargarDataAdelantos($co_cli);
  
});   

$(".facturas_metodo").on('change', function () {
  $(".facturas_metodo option:selected").each(function () {
     let elegido=$(this).val();
     // console.log(elegido);        
      if(elegido=='EF'){
        $('.facturas_referencia').val('0');
        $('.banco').attr("style","display:none");
        $('.cuenta').attr("style","display:none");
        $('.referencia').attr("style","display:none");
        $('.caja').attr("style","display:");      
        $('.foto').attr("style","display:");


        $('.montoAbonoBs').attr("style","display:");      
        $('.montoAbonoUSD').attr("style","display:"); 
        $('#pesos').removeAttr('disabled');
        $('#dollars').removeAttr('disabled');   
      }
      if((elegido=='DEP') || (elegido=='CH')){
        $('.banco').attr("style","display:");
        $('.cuenta').attr("style","display:");
        $('.referencia').attr("style","display:");
        $('.caja').attr("style","display:none"); 
        $('.foto').attr("style","display:");    
        
        $('.montoAbonoBs').attr("style","display:none");      
        $('.montoAbonoUSD').attr("style","display:none"); 
        $('#pesos').removeAttr('disabled');
        $('#dollars').removeAttr('disabled');   
      }

      if(elegido=='NO'){
        $('.banco').attr("style","display:none");
        $('.cuenta').attr("style","display:none");
        $('.caja').attr("style","display:none"); 
        $('.referencia').attr("style","display:none");
        $('.foto').attr("style","display:none");  
            $('.facturas_referencia').val('0');
                
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

    //console.log(tipo_precio);
   // console.log(facturacion);     
   // console.log(pago);
   
    cargarDataProductos($filtro,2,tipo_precio,facturacion,pago);


    }else{
      // cargar filtro con las 2 variables
      let $filtroCompuesto = $filtro+'/'+$filtro2;
    $('.ecommerceProducts').empty();

    const cliente = getSessionData('datosCLiente');
    var tipo_precio = cliente.tipo_precio;
    var facturacion = cliente.cliente_facturacion;
    var pago = cliente.cliente_forma;

    //console.log(tipo_precio);
    //console.log(facturacion);
    //console.log(pago);

    cargarDataProductos($filtro,2,tipo_precio,facturacion,pago);
    }
  }else{
    $('.ecommerceProducts').empty();
    const cliente = getSessionData('datosCLiente');
    let tipo_precio = cliente.tipo_precio;
    let facturacion = cliente.cliente_facturacion;
    let pago =  cliente.cliente_forma;

  //  console.log(tipo_precio);
   // console.log(facturacion);
   // console.log(pago);
    
    paginar(1,1,tipo_precio,facturacion,pago);         
   
  }
})





if ($('.cuentasPorCobrar').length) {  
  cuentasPorCobrar();

}

if ($('.totalAcumulado').length) {
 
  estadoCuentaPagosRealizados();

}

 
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




if ($('#cli_estado').length) {
    cargarComboEstados('.cli_estado', 0);
}

//cargarComboCiudades

  $("#cli_estado").on('change', function () {
    $("#cli_estado option:selected").each(function () {
      let elegido = $(this).val();
      ////console.log(elegido);
      if (elegido == 0) {

         $('#cli_ciudad').empty();
        $('#cli_ciudad').prop('disabled', true);
        $('#cli_ciudad').html('<option value="0">Seleccione</option>');

        $('#cli_municipio').empty();
        $('#cli_municipio').prop('disabled', true);
        $('#cli_municipio').html('<option value="0">Seleccione</option>');

        $('#cli_parroquia').empty();
        $('#cli_parroquia').prop('disabled', true);
        $('#cli_parroquia').html('<option value="0">Seleccione</option>');
      } else {
        $('#cli_municipio').empty();
        cargarComboMunicipios(".cli_municipio", elegido);
        $('#cli_municipio').html('<option value="0">Seleccione</option>');
        $('#cli_municipio').prop('disabled', false);


        $('#cli_ciudad').empty();
        cargarComboCiudades(".cli_ciudad", elegido);
        $('#cli_ciudad').html('<option value="0">Seleccione</option>');
        $('#cli_ciudad').prop('disabled', false);


        $('#cli_parroquia').empty();
        $('#cli_parroquia').prop('disabled', true);
        $('#cli_parroquia').html('<option value="0">Seleccione</option>');
      }

    });
  });

  $("#cli_municipio").on('change', function () {
    $("#cli_municipio option:selected").each(function () {
      let elegido = $(this).val();
      ////console.log(elegido);
      if (elegido == 0) {
        $('#cli_parroquia').empty();
        $('#cli_parroquia').prop('disabled', true);
        $('#cli_parroquia').html('<option value="0">Seleccione</option>');

      } else {
        $('#cli_parroquia').empty();
        cargarComboParroquias(".cli_parroquia", elegido);
        $('#cli_parroquia').html('<option value="0">Seleccione</option>');
        $('#cli_parroquia').prop('disabled', false);
      }

    });
  });


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
  cargarComboCategorias('.comboTipoPrecios');
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
/*
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
          

});*/

$('.btnConfirmarPago').on('click', async function() {
  // Validar que hay pagos en localStorage
  const pagosRegistrados = JSON.parse(localStorage.getItem('pagosRegistrados') || '[]');
  const retencionesArray = JSON.parse(localStorage.getItem('retencionesArray') || '[]');
  
  if (pagosRegistrados.length === 0) {
      await Swal.fire({
          icon: 'error',
          title: 'No hay pagos pendientes',
          text: 'No hay pagos registrados para enviar al servidor',
          confirmButtonText: 'Entendido'
      });
      return;
  }

  // Verificar si hay archivos (imágenes o PDFs) en los pagos
  const pagosConArchivos = pagosRegistrados.filter(pago => 
      pago.archivoData || pago.facturas_documento || pago.archivo
  );

  if (pagosConArchivos.length === 0) {
      // Si no hay archivos, proceder con el envío normal
      await enviarPagos(pagosRegistrados,retencionesArray);
      return;
  }

  // Mostrar confirmación para pagos con archivos
  const { isConfirmed } = await Swal.fire({
      title: '¿Enviar pagos con documentos adjuntos?',
      html: `Se enviarán <b>${pagosRegistrados.length}</b> pago(s) con documentos adjuntos para su procesamiento.<br>
            <span class="text-warning">Este proceso puede tomar más tiempo debido a los archivos adjuntos.</span>`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#0343a5',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, enviar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {
          return enviarPagosConArchivos(pagosRegistrados);
      }
  });

  if (!isConfirmed) return;
});

// Función para enviar pagos con archivos adjuntos
async function enviarPagosConArchivos(pagosRegistrados) {
  try {
      // Mostrar carga mientras se procesa
      Swal.fire({
          title: 'Preparando documentos',
          html: 'Procesando imágenes y PDFs adjuntos...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
      });

      // Preparar FormData para enviar archivos
      const formData = new FormData();
      
      // Procesar cada pago y agregar archivos si existen
      const pagosParaEnviar = [];
      
      for (let i = 0; i < pagosRegistrados.length; i++) {
          const pago = { ...pagosRegistrados[i] };
          
          // Si el pago tiene un archivo en formato base64, convertirlo a Blob
          if (pago.archivoData) {
              try {
                  const blob = base64ToBlob(pago.archivoData, pago.tipoArchivo || 'image/jpeg');
                  formData.append(`archivo_${i}`, blob, pago.nombreArchivo || `documento_${i}`);
                  
                  // Eliminar el dato base64 del objeto pago para reducir tamaño
                  delete pago.archivoData;
                  delete pago.tipoArchivo;
                  delete pago.nombreArchivo;
              } catch (error) {
                  console.error('Error procesando archivo:', error);
                  // Continuar con el envío sin el archivo
              }
          }
          
          // Si el pago tiene facturas_documento (input file)
          if (pago.facturas_documento && pago.facturas_documento.length > 0) {
              try {
                  for (let j = 0; j < pago.facturas_documento.length; j++) {
                      const archivo = pago.facturas_documento[j];
                      if (archivo && archivo instanceof File) {
                          formData.append(`factura_${i}_${j}`, archivo);
                      }
                  }
                  // Eliminar los archivos del objeto pago
                  delete pago.facturas_documento;
              } catch (error) {
                  console.error('Error procesando facturas:', error);
              }
          }
          
          // Si el pago tiene un campo archivo (File object)
          if (pago.archivo && pago.archivo instanceof File) {
              formData.append(`archivo_pago_${i}`, pago.archivo);
              delete pago.archivo;
          }
          
          pagosParaEnviar.push(pago);
      }
      
      // Agregar los datos de pago como JSON
      formData.append('pagos', JSON.stringify(pagosParaEnviar));
      formData.append('conArchivos', 'true');

      // Enviar datos por AJAX con FormData
      const response = await enviarDatosAlServidor(formData);

      if (response.success) {
          // Limpiar localStorage si el servidor respondió correctamente
          localStorage.removeItem('pagosRegistrados');
          
          await Swal.fire({
              icon: 'success',
              title: 'Pagos enviados',
              text: response.message || 'Los pagos y documentos se han enviado correctamente',
              confirmButtonColor: '#0343a5',
              confirmButtonText: 'Aceptar'
          });

          // Redirigir a la página de reporte de pagos
          window.location.href = 'index.php?view=cobros';
          
      } else {
          throw new Error(response.message || 'Error al procesar los pagos con archivos');
      }
  } catch (error) {
      await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.message || 'Ocurrió un error al enviar los pagos con documentos al servidor',
          confirmButtonText: 'Entendido'
      });
      console.error('Error:', error);
  }
}

// Función para enviar pagos sin archivos (versión original)
// Función para enviar pagos sin archivos (versión modificada)
async function enviarPagos(pagosRegistrados, retenciones) {
  // Mostrar confirmación
  const { isConfirmed } = await Swal.fire({
      title: '¿Enviar pagos a crédito y cobranza?',
      text: "Se enviarán todos los pagos pendientes para su procesamiento.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#0343a5',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, enviar',
      cancelButtonText: 'Cancelar'
  });

  if (!isConfirmed) return;

  // Mostrar carga mientras se procesa
  Swal.fire({
      title: 'Enviando pagos',
      html: 'Por favor espere...',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
  });

  try {
      // Enviar datos por AJAX (sin archivos)
      const response = await $.ajax({
          url: '../admin/index.php?action=pago&tipo=1&accion=1&datos=2',
          type: 'POST',
          dataType: 'json',
          data: {
              pagos: JSON.stringify(pagosRegistrados),
              retenciones: JSON.stringify(retenciones), // Se añade el array de retenciones
              conArchivos: 'false'
          }
      });

      if (response.success) {
          // Limpiar localStorage si el servidor respondió correctamente
          localStorage.removeItem('pagosRegistrados');
          
          await Swal.fire({
              icon: 'success',
              title: 'Pagos enviados',
              text: response.message || 'Los pagos se han enviado correctamente',
              confirmButtonColor: '#0343a5',
              confirmButtonText: 'Aceptar'
          });

          // Redirigir a la página de reporte de pagos
          window.location.href = 'index.php?view=cobros';
          
      } else {
          throw new Error(response.message || 'Error al procesar los pagos');
      }
  } catch (error) {
      await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.message || 'Ocurrió un error al enviar los pagos al servidor',
          confirmButtonText: 'Entendido'
      });
      console.error('Error:', error);
  }
}
// Función para enviar datos al servidor con FormData
async function enviarDatosAlServidor(formData) {
  return new Promise((resolve, reject) => {
      $.ajax({
          url: '../admin/index.php?action=pago&tipo=1&accion=1&datos=2',
          type: 'POST',
          data: formData,
          processData: false,  // Importante: no procesar los datos
          contentType: false,  // Importante: no establecer contentType
          success: function(response) {
              try {
                  // Intentar parsear la respuesta como JSON
                  const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                  resolve(jsonResponse);
              } catch (e) {
                  // Si falla el parseo, devolver como texto
                  resolve({ 
                      success: true, 
                      message: response 
                  });
              }
          },
          error: function(xhr, status, error) {
              reject(new Error(error || 'Error de conexión'));
          }
      });
  });
}

// Función auxiliar para convertir base64 a Blob
function base64ToBlob(base64, contentType = '', sliceSize = 512) {
  try {
      const byteCharacters = atob(base64);
      const byteArrays = [];

      for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
          const slice = byteCharacters.slice(offset, offset + sliceSize);
          const byteNumbers = new Array(slice.length);
          
          for (let i = 0; i < slice.length; i++) {
              byteNumbers[i] = slice.charCodeAt(i);
          }
          
          const byteArray = new Uint8Array(byteNumbers);
          byteArrays.push(byteArray);
      }
      
      return new Blob(byteArrays, { type: contentType });
  } catch (error) {
      console.error('Error converting base64 to Blob:', error);
      throw new Error('Formato de archivo inválido');
  }
}

// Función para verificar si un pago tiene archivos adjuntos
function pagoTieneArchivos(pago) {
  return !!(pago.archivoData || 
            (pago.facturas_documento && pago.facturas_documento.length > 0) || 
            (pago.archivo && pago.archivo instanceof File));
}


$('.btnPagarFacturas').on('click', async function () {
    // Función para generar ID autoincremental
    function generarNuevoID() {
        const pagosPrevios = JSON.parse(localStorage.getItem('pagosRegistrados') || '[]');
        if (pagosPrevios.length === 0) return 1;
        const maxID = pagosPrevios.reduce((max, pago) => Math.max(max, pago.id || 0), 0);
        return maxID + 1;
    }



    // DEBUG: Verificar archivos antes de procesar
    console.log('=== INICIANDO PROCESO DE PAGO ===');


    // Mostrar confirmación inicial
    const { isConfirmed } = await Swal.fire({
        title: '¿Deseas acusar pago?',
        text: "Tenga en cuenta que acusará un pago por las facturas seleccionadas.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0343a5',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, continuar',
        cancelButtonText: 'Cancelar'
    });

    if (!isConfirmed) {
        console.log('Proceso cancelado por el usuario');
        return;
    }

    // Validar campos requeridos básicos
    const camposRequeridos = [
        { selector: '.facturas_cliente_codigo', nombre: 'Cliente' },
        { selector: '.facturas_fecha', nombre: 'Fecha de emisión' },
        { selector: '.facturas_monto', nombre: 'Monto a cobrar' },
        { selector: '.facturas_monto_bs', nombre: 'Monto en bolívares' },
        { selector: '.facturas_cancelar', nombre: 'Facturas a cancelar' },
        { selector: '.facturas_metodo', nombre: 'Método de pago' }
    ];

    for (const campo of camposRequeridos) {
        const valor = $(campo.selector).val();
        if (!valor || valor === 'NO') {
            await Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: `El campo ${campo.nombre} no puede estar vacío`,
                confirmButtonText: 'Entendido'
            });
            $(campo.selector).focus();
            return false;
        }
    }

    // Validar montos - deben ser mayor o igual a 0.01
    const monto = parseFloat($('.facturas_monto').val());
    const montoBs = parseFloat($('.facturas_monto_bs').val());
    
    if (isNaN(monto) || monto < 0.01) {
        await Swal.fire({
            icon: 'error',
            title: 'Monto inválido',
            text: 'El monto a cobrar debe ser mayor o igual a 0.01',
            confirmButtonText: 'Entendido'
        });
        $('.facturas_monto').focus();
        return false;
    }

    if (isNaN(montoBs) || montoBs < 0.01) {
        await Swal.fire({
            icon: 'error',
            title: 'Monto inválido',
            text: 'El monto en bolívares debe ser mayor o igual a 0.01',
            confirmButtonText: 'Entendido'
        });
        $('.facturas_monto_bs').focus();
        return false;
    }

    // Validar campos según método de pago seleccionado
    const metodoPago = $('.facturas_metodo').val();
    
    if (metodoPago === 'EF') { // Efectivo
        if (!$('.facturas_caja').val() || $('.facturas_caja').val() === 'NO') {
            await Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Debe seleccionar una caja para pagos en efectivo',
                confirmButtonText: 'Entendido'
            });
            $('.facturas_caja').focus();
            return false;
        }
    } 
    else if (metodoPago === 'DEP' || metodoPago === 'CH') { // Depósito o Cheque
        const camposBanco = [
            { selector: '.facturas_banco', nombre: 'Banco' },
            { selector: '.facturas_cuenta', nombre: 'Cuenta' },
            { selector: '.facturas_referencia', nombre: 'Referencia' }
        ];

        for (const campo of camposBanco) {
            const valor = $(campo.selector).val();
            if (!valor || valor === 'NO') {
                await Swal.fire({
                    icon: 'error',
                    title: 'Campo requerido',
                    text: `El campo ${campo.nombre} es requerido para pagos por ${metodoPago === 'DEP' ? 'depósito' : 'cheque'}`,
                    confirmButtonText: 'Entendido'
                });
                $(campo.selector).focus();
                return false;
            }
        }
    }

   
    // OBTENER SOLO LOS NUEVOS ARCHIVOS del componente
    const archivosSeleccionados = window.obtenerArchivosPago ? window.obtenerArchivosPago() : [];
    
    // Validar que hay archivos nuevos
    if (archivosSeleccionados.length === 0) {
        await Swal.fire({
            icon: 'error',
            title: 'Comprobante requerido',
            text: 'Debe adjuntar al menos un comprobante de pago para continuar',
            confirmButtonText: 'Entendido'
        });
        return false;
    }

    // Validar tipos de archivo permitidos - USAMOS LA COPIA
    const archivosValidos = archivosSeleccionados.every(file => {
        const esImagen = file.type.startsWith('image/');
        const esPDF = file.type === 'application/pdf';
        return esImagen || esPDF;
    });

    if (!archivosValidos) {
        await Swal.fire({
            icon: 'error',
            title: 'Tipo de archivo no válido',
            text: 'Solo se permiten imágenes (JPG, PNG, GIF, etc.) y archivos PDF',
            confirmButtonText: 'Entendido'
        });
        return false;
    }

    // Obtener todos los valores del formulario
    const obtenerValorCampo = (selector) => $(selector).val() || '0';
    const obtenerTextoSeleccionado = (selector) => $(`${selector} option:selected`).text() || '0';

    // Generar el nuevo ID autoincremental
    const nuevoID = generarNuevoID();

    const pagoData = {
        responsive_id: '',
        id: nuevoID,
        co_cli: obtenerValorCampo('.facturas_cliente_codigo'),
        fec_emis: obtenerValorCampo('.facturas_fecha'),
        cli_des: obtenerValorCampo('.facturas_cliente'),
        monto_cob: obtenerValorCampo('.facturas_monto'),
        monto_cob_bs: obtenerValorCampo('.facturas_monto_bs'),
        facturas: obtenerValorCampo('.facturas_cancelar'),
        forma_pag: obtenerValorCampo('.facturas_metodo'),
        co_ban: obtenerValorCampo('.facturas_banco'),
        co_cuenta: obtenerValorCampo('.facturas_cuenta'),
        co_caja: obtenerValorCampo('.facturas_caja'),
        ref_ban: obtenerValorCampo('.facturas_referencia'),
        ven_des: $('.user-name').text().trim(),
        facturas_saldo: obtenerValorCampo('.facturas_saldo'),
        facturas_saldo_bs: obtenerValorCampo('.facturas_saldo_bs'),
        moneda: "0",
        observacion: obtenerValorCampo('.facturas_observacion'),
        banco_des: obtenerTextoSeleccionado('.facturas_banco'),
        cuenta_des: obtenerTextoSeleccionado('.facturas_cuenta'),
        caja_des: obtenerTextoSeleccionado('.facturas_caja'),
        moneda_des: "0",
        fecha_registro: new Date().toISOString()
    };

    // Función para procesar diferentes tipos de archivos
    function procesarArchivos(files, callback) {
        const archivosProcesados = [];
        let archivosPendientes = files.length;
        
        if (files.length === 0) {
            callback([]);
            return;
        }
        
        files.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const archivoProcesado = {
                    nombre: file.name,
                    tipo: file.type,
                    datos: e.target.result,
                    esPDF: file.type === 'application/pdf',
                    esImagen: file.type.startsWith('image/')
                };
                
                archivosProcesados.push(archivoProcesado);
                archivosPendientes--;
                
                // Actualizar progreso en el SweetAlert
                if (Swal.isVisible()) {
                    const procesados = files.length - archivosPendientes;
                    Swal.getHtmlContainer().innerHTML = 
                        `Procesando ${procesados} de ${files.length} archivos...<br>
                         <small>${file.name}</small>`;
                }
                
                if (archivosPendientes === 0) {
                    callback(archivosProcesados);
                }
            };
            
            reader.onerror = function(error) {
                console.error('Error al procesar archivo:', file.name, error);
                archivosPendientes--;
                
                if (archivosPendientes === 0) {
                    callback(archivosProcesados);
                }
            };
            
            // Leer el archivo según su tipo
            if (file.type === 'application/pdf') {
                reader.readAsDataURL(file);
            } else if (file.type.startsWith('image/')) {
                reader.readAsDataURL(file);
            } else {
                reader.readAsDataURL(file);
            }
        });
    }

    // Mostrar carga mientras se procesan los archivos
    Swal.fire({
        title: 'Procesando archivos',
        html: `Procesando 0 de ${archivosSeleccionados.length} archivos...`,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    // Procesar múltiples archivos - USAMOS LA COPIA
    procesarArchivos(archivosSeleccionados, async function(archivosProcesados) {
        pagoData.archivos = archivosProcesados;
        pagoData.tiposArchivos = archivosProcesados.map(archivo => 
            archivo.esPDF ? 'PDF' : 'Imagen'
        );

        try {
            // Guardar en LocalStorage
            const pagosPrevios = JSON.parse(localStorage.getItem('pagosRegistrados') || '[]');
            pagosPrevios.push(pagoData);
            localStorage.setItem('pagosRegistrados', JSON.stringify(pagosPrevios));

            // Mostrar éxito con resumen de archivos
            const resumenArchivos = archivosProcesados.reduce((acc, archivo) => {
                const tipo = archivo.esPDF ? 'PDF' : 'Imagen';
                acc[tipo] = (acc[tipo] || 0) + 1;
                return acc;
            }, {});

            const mensajeResumen = Object.entries(resumenArchivos)
                .map(([tipo, cantidad]) => `${cantidad} ${tipo}${cantidad > 1 ? 's' : ''}`)
                .join(', ');

            // LIMPIAR COMPLETAMENTE ANTES DE MOSTRAR ÉXITO
            limpiarFormularioPagoCompletamente();

            await Swal.fire({
                icon: 'success',
                title: 'Pago cargado',
                html: `El pago se ha cargado correctamente con:<br>
                       <strong>${mensajeResumen}</strong>`,
                confirmButtonColor: '#0343a5',
                confirmButtonText: 'Aceptar'
            });

            // Cerrar modal
            $('.modalPagoFacturas').modal('hide');
            
            // Actualizar interfaz
            if (typeof cargarDataPagosRealizados === 'function') {
                cargarDataPagosRealizados();
            }
            if (typeof estadoCuentaPagosRealizados === 'function') {
                estadoCuentaPagosRealizados();
            }
          if (window.limpiarArchivosPago) {
                window.limpiarArchivosPago(); // Limpiar solo los archivos nuevos
            }
           

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al guardar el pago: ' + error.message
            });
            console.error('Error al guardar pago:', error);
        }
    });
});

function limpiarFormularioPagoCompletamente() {
    // 1. Limpiar input de archivos
    $('.facturas_documento').val('');
    
    // 2. Limpiar contenedor de archivos seleccionados
    $('#selected-files').empty();
    
    // 3. Restablecer texto del área de drop
    $('#drop-zone p').text('Arrastra una o más imágenes/PDF aquí o haz clic para seleccionar');
    
    // 4. Limpiar vista previa
    $('.file-preview').remove();
    
    // 5. Resetear formulario
    $('#addNewAddressForm')[0].reset();
    
    // 6. Resetear selects
    $('.select2').val('NO').trigger('change');
    
    // 7. Forzar un cambio de evento para limpiar cualquier estado interno
    $('.facturas_documento').trigger('change');
}

// Limpiar completamente el modal cuando se cierre
$('.modalPagoFacturas').on('hidden.bs.modal', function () {
    console.log('Modal cerrado - limpiando estado residual');
    limpiarFormularioPagoCompletamente();
    
    // Forzar garbage collection de archivos
    if (window.archivosSeleccionados) {
        window.archivosSeleccionados = [];
    }
});

// Limpiar cuando se abra el modal (por si acaso)
$('.modalPagoFacturas').on('show.bs.modal', function () {
    console.log('Modal abierto - limpiando estado inicial');
    limpiarFormularioPagoCompletamente();
});


$('.btnPagarAdelanto').on('click', async function () {
    // Mostrar confirmación inicial
    const { isConfirmed } = await Swal.fire({
        title: '¿Deseas acusar adelanto?',
        text: "Tenga en cuenta que acusará un pago de adelanto.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0343a5',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, continuar',
        cancelButtonText: 'Cancelar'
    });

    if (!isConfirmed) return;

    // Validar campos requeridos básicos
    const camposRequeridos = [
        { selector: '.comboClientesFacturaAdelantar', nombre: 'Cliente' },
        { selector: '.facturas_fecha', nombre: 'Fecha' },
        { selector: '.facturas_monto', nombre: 'Monto' },
        { selector: '.facturas_monto_bs', nombre: 'Monto en bolívares' },
        { selector: '.facturas_metodo', nombre: 'Método de pago' }
    ];

    for (const campo of camposRequeridos) {
        // Validar montos - deben ser mayor o igual a 0.01
        if (campo.selector === '.facturas_monto') {
            const monto = parseFloat($(campo.selector).val());
            if (isNaN(monto) || monto < 0.01) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Monto inválido',
                    text: 'El monto a cobrar debe ser mayor o igual a 0.01',
                    confirmButtonText: 'Entendido'
                });
                $(campo.selector).focus();
                return false;
            }
        }

        if (campo.selector === '.facturas_monto_bs') {
            const montoBs = parseFloat($(campo.selector).val());
            if (isNaN(montoBs) || montoBs < 0.01) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Monto inválido',
                    text: 'El monto en bolívares debe ser mayor o igual a 0.01',
                    confirmButtonText: 'Entendido'
                });
                $(campo.selector).focus();
                return false;
            }
        }

        const valor = $(campo.selector).val();
        if (!valor || valor === 'NO') {
            await Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: `El campo ${campo.nombre} no puede estar vacío`,
                confirmButtonText: 'Entendido'
            });
            $(campo.selector).focus();
            return false;
        }
    }

    // Validar campos según método de pago seleccionado
    const metodoPago = $('.facturas_metodo').val();
    
    if (metodoPago === 'EF') { // Efectivo
        if (!$('.facturas_caja').val() || $('.facturas_caja').val() === 'NO') {
            await Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Debe seleccionar una caja para pagos en efectivo',
                confirmButtonText: 'Entendido'
            });
            $('.facturas_caja').focus();
            return false;
        }
    } 
    else { // Depósito o Cheque
        const camposBanco = [
            { selector: '.facturas_banco', nombre: 'Banco' },
            { selector: '.facturas_cuenta', nombre: 'Cuenta' },
            { selector: '.facturas_referencia', nombre: 'Referencia' }
        ];

        for (const campo of camposBanco) {
            const valor = $(campo.selector).val();
            if (!valor || (campo.selector !== '.facturas_referencia' && valor === 'NO')) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Campo requerido',
                    text: `El campo ${campo.nombre} es requerido para pagos por ${metodoPago === 'DEP' ? 'depósito' : 'cheque'}`,
                    confirmButtonText: 'Entendido'
                });
                $(campo.selector).focus();
                return false;
            }
        }
    }

    // Validar archivo adjunto (obligatorio)
    const fileInput = $('.facturas_documento')[0];
    if (fileInput.files.length === 0) {
        await Swal.fire({
            icon: 'error',
            title: 'Comprobante requerido',
            text: 'Debe adjuntar al menos un comprobante de pago para continuar',
            confirmButtonText: 'Entendido'
        });
        $('.facturas_documento').click();
        return false;
    }

    // Obtener todos los valores del formulario
    const $co_cli = $('.comboClientesFacturaAdelantar').val();
    const $fec_emis = $('.facturas_fecha').val();
    const $cli_des = $('.comboClientesFacturaAdelantar option:selected').text();
    const $monto_cob = $('.facturas_monto').val();
    const $monto_cob_bs = $('.facturas_monto_bs').val();
    const $forma_pag = $('.facturas_metodo').val();
    const $co_ban = $('.facturas_banco').val();
    const $co_cuenta = $('.facturas_cuenta').val();
    const $co_caja = $('.facturas_caja').val();
    const $moneda = '0';
     const $observacion = $('.facturas_observacion').val();
    const $ref_ban = $('.facturas_referencia').val();
    const ven_des = $('.user-name').text();
    const files = $('.facturas_documento')[0].files[0];

    // Determinar valores según método de pago
    let banco_des = "no";
    let cuenta_des = "no";
    let caja_des = "no";
    let moneda_des = "0";

    if ($forma_pag === 'EF') {
        caja_des = $('.facturas_caja option:selected').html().trim();
    } else {
        banco_des = $('.facturas_banco option:selected').html().trim();
        cuenta_des = $('.facturas_cuenta option:selected').html().trim();
    }

    // Preparar datos para envío
    const formData = new FormData();
    formData.append('file', files);

    // Mostrar carga mientras se procesa
    let timerInterval;
    Swal.fire({
        title: 'Registrando',
        html: 'Por favor, espere unos segundos mientras se está registrando el adelanto, el tiempo de respuesta dependerá de la velocidad de su conexión.',
        timer: 3000,
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            timerInterval = setInterval(() => {}, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    });

    // Esperar a que termine el timer de la alerta
    await new Promise(resolve => setTimeout(resolve, 3000));

    // Realizar la petición AJAX
    try {
        const response = await $.ajax({
            url: `../admin/index.php?action=adelanto&moneda=${$moneda}&co_cuenta=${$co_cuenta}&ref_ban=${$ref_ban}&co_cli=${$co_cli}&fec_emis=${$fec_emis}&monto_cob=${$monto_cob}&forma_pag=${$forma_pag}&co_ban=${$co_ban}&co_caja=${$co_caja}&tipo=1&accion=1&datos=1&cli_des=${encodeURIComponent($cli_des)}&ven_des=${encodeURIComponent(ven_des)}&banco_des=${encodeURIComponent(banco_des)}&cuenta_des=${encodeURIComponent(cuenta_des)}&caja_des=${encodeURIComponent(caja_des)}&observacion=${encodeURIComponent($observacion)}&moneda_des=${moneda_des}&monto_cob_bs=${$monto_cob_bs}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false
        });

        if (response.success) {
          // Limpiar localStorage si el servidor respondió correctamente
      //    localStorage.removeItem('pagosRegistrados');
          
          await Swal.fire({
              icon: 'success',
              title: 'Pagos enviados',
              text: response.message || 'Los pagos y documentos correspondientes al adelanto, se han enviado correctamente',
              confirmButtonColor: '#0343a5',
              confirmButtonText: 'Aceptar'
          });
  
          // Redirigir a la página de reporte de pagos
          window.location.href = 'index.php?view=cobros';
          
      } else {
          throw new Error(response.message || 'Error al procesar los pagos con archivos');
      }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No hemos podido registrar su adelanto, verifique e intente nuevamente!'
        });
        console.error('Error:', error);
    }
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




   $('#btnActualizarCliente').click(function() {
        // Obtener valores de los campos
        let co_cli = $('#co_cli').val();
        let cli_des = $('#cli_des').val();
        let cli_rif = $('#cli_rif').val();
        let cli_email = $('#cli_email').val();
        let cli_telefono = $('#cli_telefono').val();
        let cli_direccion = $('#cli_direccion').val();
        let cli_direccion_despacho = $('#cli_direccion_despacho').val();
        let cli_estado = $('#cli_estado').val();
        let cli_municipio = $('#cli_municipio').val();
        let cli_parroquia = $('#cli_parroquia').val();
        let cli_ciudad = $('#cli_ciudad').val();
        let cli_responsable = $('#cli_responsable').val();
        let cli_responsable_fecha = $('#cli_responsable_fecha').val();
        let cli_aniversario_fecha = $('#cli_aniversario_fecha').val();
        let cli_propietario_fecha = $('#cli_propietario_fecha').val();
        let cli_responable_compras = $('#cli_responable_compras').val();
        let cli_responsable_compras_fecha = $('#cli_responsable_compras_fecha').val();

        // Validar campos obligatorios
        let errors = [];
        
      //  if (!cli_email) errors.push('<b>Correo electrónico</b>');
       // if (!cli_telefono) errors.push('<b>Teléfono de contacto</b>');
        if (!cli_direccion_despacho) errors.push('<b>Dirección de despacho</b>');
        if (cli_estado == '0') errors.push('<b>Estado</b>');
        if (cli_municipio == '0') errors.push('<b>Municipio</b>');
        if (cli_parroquia == '0') errors.push('<b>Parroquia</b>');
        if (cli_ciudad == '0') errors.push('<b>Ciudad</b>');
        

        // Mostrar errores si hay campos vacíos
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Campos obligatorios faltantes',
                html: 'Por favor complete los siguientes campos obligatorios:<br><br>-' + errors.join('<br>- '),
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // Crear objeto con los datos
        let formData = {
            co_cli: co_cli,
            cli_des: cli_des,
            cli_rif: cli_rif,
            cli_email: cli_email,
            cli_telefono: cli_telefono,
            cli_direccion: cli_direccion,
            cli_direccion_despacho: cli_direccion_despacho,
            cli_estado: cli_estado,
            cli_municipio: cli_municipio,
            cli_parroquia: cli_parroquia,
            cli_ciudad: cli_ciudad,
            cli_responsable: cli_responsable,
            cli_responsable_fecha: cli_responsable_fecha,
            cli_aniversario_fecha: cli_aniversario_fecha,
            cli_propietario_fecha: cli_propietario_fecha,
            cli_responable_compras: cli_responable_compras,
            cli_responsable_compras_fecha: cli_responsable_compras_fecha
        };

        // Enviar datos por AJAX
        $.ajax({
            url: '../admin/index.php?action=cliente&tipo=1&accion=3&datos=1',  // Ruta a tu script PHP           
            type: 'POST',          
            data: {co_cli: co_cli,
            cli_des: cli_des,
            cli_rif: cli_rif,
            cli_email: cli_email,
            cli_telefono: cli_telefono,
            cli_direccion: cli_direccion,
            cli_direccion_despacho: cli_direccion_despacho,
            cli_estado: cli_estado,
            cli_municipio: cli_municipio,
            cli_parroquia: cli_parroquia,
            cli_ciudad: cli_ciudad,
            cli_responsable: cli_responsable,
            cli_responsable_fecha: cli_responsable_fecha,
            cli_aniversario_fecha: cli_aniversario_fecha,
            cli_propietario_fecha: cli_propietario_fecha,
            cli_responable_compras: cli_responable_compras,
            cli_responsable_compras_fecha: cli_responsable_compras_fecha},
           

            beforeSend: function() {
                // Mostrar loader o mensaje de carga
                $('#btnActualizarCliente').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Datos actualizados correctamente',
                        confirmButtonText: 'Aceptar'
                    });                    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Ocurrió un error al actualizar los datos',
                        confirmButtonText: 'Entendido'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error en la comunicación con el servidor: ' + error,
                    confirmButtonText: 'Entendido'
                });
            },
            complete: function() {
                $('#btnActualizarCliente').prop('disabled', false).text('Actualizar');
            }
        });
    });


     $('body').on('click', '#btnGuardarCandidato', function() {
    (async () => { 
    // Obtener valores de los campos
    let cli_des = $('#cli_des').val();
    let cli_rif = $('#cli_rif').val();
    let cli_email = $('#cli_email').val();
    let cli_telefono = $('#cli_telefono').val();
    let cli_direccion = $('#cli_direccion').val();
    let cli_direccion_despacho = $('#cli_direccion_despacho').val();
    let cli_estado = $('#cli_estado').val();
    let cli_municipio = $('#cli_municipio').val();
    let cli_parroquia = $('#cli_parroquia').val();
    let cli_ciudad = $('#cli_ciudad').val();

    let lat =$('#latitude').text();
    let lon =$('#longitude').text();
    let acc = $('#accuracy').text();
    let fecha=$('#timestamp').text();

    // Validar campos obligatorios
    let errors = [];
    if (!cli_des) errors.push('<b>Razón social</b>');
    if (!cli_rif) errors.push('<b>Rif</b>');

    if (cli_estado == '0') errors.push('<b>Estado</b>');
    if (cli_municipio == '0') errors.push('<b>Municipio</b>');
    if (cli_parroquia == '0') errors.push('<b>Parroquia</b>');
    if (cli_ciudad == '0') errors.push('<b>Ciudad</b>');
    

    // Mostrar errores si hay campos vacíos
    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Campos obligatorios faltantes',
            html: 'Por favor complete los siguientes campos obligatorios:<br><br>-' + errors.join('<br>- '),
          confirmButtonColor: '#0343a5',
            confirmButtonText: 'Entendido'
        });
        return false;
    }

       // 3. Validación de ubicación GPS (opcional)
                if ($('#latitude').text() === 'No disponible') {
                    const { isConfirmed: confirmLocation } = await Swal.fire({
                        title: 'Ubicación requerida',
                        text: "No se ha capturado la ubicación GPS. ¿Desea intentarlo ahora?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0343a5',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Obtener ubicación',
                        cancelButtonText: 'Continuar sin ubicación'
                    });

                    if (confirmLocation) {
                        $('#getLocation').click();
                        return;
                    }
                }
    

    // Crear objeto con los datos
    let formData = {
        cli_des: cli_des,
        cli_rif: cli_rif,
        cli_email: cli_email,
        cli_telefono: cli_telefono,
        cli_direccion: cli_direccion,
        cli_direccion_despacho: cli_direccion_despacho,
        cli_estado: cli_estado,
        cli_municipio: cli_municipio,
        cli_parroquia: cli_parroquia,
        cli_ciudad: cli_ciudad,
        lat: lat,
        lon: lon,   
        acc: acc,
        fecha: fecha
    };

    // Enviar datos por AJAX
    $.ajax({
        url: '../admin/index.php?action=cliente&tipo=1&accion=5&datos=1',  // Ruta a tu script PHP (probablemente diferente para crear)
        type: 'POST',          
        data: formData,
        beforeSend: function() {
            // Mostrar loader o mensaje de carga
            $('#btnGuardarCandidato').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');
        },
        success: function(response) {
           if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Error de verificación',
                    confirmButtonColor: '#0343a5',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    // Opcional: Limpiar formulario o redirigir después de guardar
                    // $('.validate-form')[0].reset();
                });                    
            }
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message || 'Datos guardados correctamente',
                    confirmButtonColor: '#0343a5',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    // Opcional: Limpiar formulario o redirigir después de guardar
                     $('.validate-form')[0].reset();

                      setTimeout(function() {
                        window.location.href = 'index.php?view=candidatos&s=0';
                    }, 1000); // 2000 milisegundos = 2 segundos

                });                    
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error al guardar los datos',
                    confirmButtonColor: '#0343a5',
                    confirmButtonText: 'Entendido'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error en la comunicación con el servidor: ' + error,
                confirmButtonColor: '#0343a5',
                confirmButtonText: 'Entendido'
            });
        },
        complete: function() {
            $('#btnGuardarCandidato').prop('disabled', false).html('<i data-feather="save" class="me-1"></i> Guardar');
            // Re-inicializar iconos Feather si es necesario
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
    });
        })();
});



if ($('.preguntasEncuesta').length) {
    const co_cli = $('#co_cli').val() || '';
    cargarPreguntasDinamicas(co_cli);

}

if ($('.modalPagoFacturas_reporte').length) {

  let montoRetencion = 0.00;
  
  // Tipo de cambio
  
  const change_rate = getSessionData('change_rate');
  const monto_rete = getSessionData('monto_retencion');
    if (monto_rete && monto_rete.monto) {
        montoRetencion = parseFloat(monto_rete.monto);
      }
  // Tipo de cambio

  let exchangeRate = parseFloat(change_rate.exchangeRate);


  // Guardar el valor original del monto calculado
  let montoCalculadoOriginal = $('#monto_calculado').data('saldo');
 montoCalculadoOriginal = montoCalculadoOriginal - montoRetencion;
  let montoTemporal = montoCalculadoOriginal; // Variable temporal para almacenar cambios
  
    console.log('Monto original:', montoCalculadoOriginal);
    console.log('Tasa:', exchangeRate);
    console.log('Monto retencion:', montoRetencion);

    $('#facturasSaldoBs').text((montoCalculadoOriginal*exchangeRate).toFixed(2));
    $('#monto_calculado').val(montoCalculadoOriginal);
    $('#monto_calculado_bs').val((montoCalculadoOriginal*exchangeRate).toFixed(2));

    $('#facturas_saldo_text').text((montoCalculadoOriginal).toFixed(2));


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
      const change_rate = getSessionData('change_rate');

      // Tipo de cambio
      let exchangeRate = parseFloat(change_rate.exchangeRate)
    
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
      const change_rate = getSessionData('change_rate');

      // Tipo de cambio
      let exchangeRate = parseFloat(change_rate.exchangeRate)
    
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
// final del jquery
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



function cargarDataClientesCandidatos(){
  if ($('#dataClientesCandidatos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ClienteData&a=1112&t=clientes', 
}).done(function(datos) { 
  var cadena = JSON.stringify(datos);
  $('.dataClientesCandidatos').attr("value",cadena);
  cargarTablaClientesCandidatos();


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
}).done(function(data) { 
  var cadena = JSON.stringify(data);
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
    let $cliente = $('.dataPagosRealizados').data('cliente');
    //console.log($cliente);
    const exchangeRate = parseFloat($('#rate').data('rate')) || 1;

     const $rango = $('.facturas_cancelar').val();   
    const $status ="";

    const pagosRegistrados = JSON.parse(localStorage.getItem('pagosRegistrados')) || [];
    setSessionData('change_rate', {
      exchangeRate: exchangeRate
     
    });
  var cadena = JSON.stringify(pagosRegistrados);
  $('.dataPagosRealizados').attr("value",cadena);  
  cargarTablaPagosRealizados($cliente);


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

function cargarDataPagos($co_cli,$filtro,$filtro2,$filtro3,$filtro4,$filtro5){  
  if ($('#dataPagos').length) {   
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&a=99999&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0&filtro2='+$filtro2+
    '&filtro3='+$filtro3+'&filtro4='+$filtro4+'&filtro5='+$filtro5,
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
}).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+data[i].dato2+'>'+data[i].dato3+'</option>');
  
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
  //console.log('cargar combo clientes precio');
  let tipo_ven = $('#tipo_ven').data('tipo');
  
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
    const change_rate = getSessionData('change_rate');

    // Tipo de cambio
    let exchangeRate = parseFloat(change_rate.exchangeRate)
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

function estadoCuentaPagosRealizados() {
  let $rango = $('.totalAcumulado').data('facturas');
  let TotalmontoConvertido = 0.00;
  let montoConvertido = 0.00;
  let tasaRenciones = 0.00;
  // Get payments from localStorage
  let pagosRegistrados = JSON.parse(localStorage.getItem('pagosRegistrados')) || [];
  let total_acumulado = 0;

  // Calculate accumulated amounts
  pagosRegistrados.forEach(pago => {
    total_acumulado += parseFloat(pago.monto_cob) || 0;
  });

  // Get retentions data from localStorage
  const retencionesData = JSON.parse(localStorage.getItem('retencionesArray')) || {
    retenciones: [],
    totalMontoBs: 0,
    totalRetenciones: 0
  };
  if (retencionesData.retenciones && retencionesData.retenciones.length > 0) {
    // Populate retentions table using jQuery
    const $tbody = $('#tablaRetenciones tbody');
    $tbody.empty(); // Clear existing rows
    $('#tablaRetenciones').removeClass('d-none');
  
    // Variable para acumular el total
    let totalAcumulado = 0;
    let solicitudesPendientes = retencionesData.retenciones.length;
    
    // Si no hay retenciones, establecer valor en 0 y salir
    if (solicitudesPendientes === 0) {
    
      return;
    }
  
    // Procesar cada retención
    $.each(retencionesData.retenciones, function(index, retencion) {
      const $row = $('<tr>').html(`
        <td class="fw-bold" data-documento="${retencion.factura}">${retencion.factura}</td>
        <td class="text-danger fw-bold" data-numero="${retencion.numRetencion}">${retencion.numRetencion}</td>
        <td class="text-danger fw-bold" data-montobs="${retencion.montoBs}"> - ${parseFloat(retencion.montoBs).toFixed(2)}</td>
        <td class="text-info fw-bold" data-fecha="${retencion.fechaRetencion}">${retencion.fechaRetencion}</td>
      `);
  
      $tbody.append($row);
      
      // Obtener tasa para esta retención
      obtenerTasaRetenciones(
        retencion.fechaRetencion, 
        retencion.montoBs,
        function(montoCalculado) {
          // Acumular el monto calculado
          totalAcumulado += montoCalculado;
          solicitudesPendientes--;
          
          // Si todas las solicitudes han terminado, actualizar el input
          if (solicitudesPendientes === 0) {
           
                setSessionData('monto_retencion', {
                monto: totalAcumulado,
                montobs :totalAcumulado     
                });
            // monto retenciones localstorage

            

          }
        }
      );
    });
  } 


  if (pagosRegistrados.length >= 1) {  
    $('#totalAcumulado').html(total_acumulado.toFixed(2));


    let montoRetencion = 0.00;
    const monto_rete = getSessionData('monto_retencion');
  if (monto_rete && monto_rete.monto) {
        montoRetencion = parseFloat(monto_rete.monto);
      }

    const change_rate = getSessionData('change_rate');
    let exchangeRate = parseFloat(change_rate.exchangeRate);
    let montoCalculadoOriginal_1 = $('#monto_calculado').data('saldo');
      let montoCalculadoOriginal = montoCalculadoOriginal_1 - montoRetencion;
    //console.log(montoCalculadoOriginal);
    let restoPagos = montoCalculadoOriginal - total_acumulado;
    //console.log(restoPagos);
    
    if (restoPagos == 0) {
      $('#pesos').val((restoPagos * exchangeRate).toFixed(2));
      $('#dollars').val(restoPagos.toFixed(2));
      $('#btnModalAgregarPagos').attr('disabled', 'disabled');
      
      Swal.fire({
        icon: 'info',
        title: 'Vaya...',
        text: 'Ya has registrado el maximo monto de pagos a conciliar para las factura(s) seleccionadas.'   
      });  
    } else {
      $('#pesos').val((restoPagos * exchangeRate).toFixed(2));
      $('#dollars').val(restoPagos.toFixed(2));
      $('#facturas_saldo_text').html(formatNumber(restoPagos));
      $('#facturas_saldo_text_bsd').html(formatNumber((restoPagos * exchangeRate)));
      $('.montoAbonoBs').hide();      
      $('.montoAbonoUSD').hide(); 
      $('#btnModalAgregarPagos').removeAttr('disabled');
    }
  } else {  
    
 const change_rate = getSessionData('change_rate');
    let exchangeRate = parseFloat(change_rate.exchangeRate);
    let montoRetencion = 0.00;
  const monto_rete = getSessionData('monto_retencion');
  if (monto_rete && monto_rete.monto) {
    montoRetencion = parseFloat(monto_rete.monto);
  }

    let restoPagos = parseFloat($('#facturas_saldo').val());
    let restoconretencion = restoPagos-montoRetencion;
//    let restoPagosbs = parseFloat($('#facturas_saldo_bs').val());
    $('#facturas_saldo_text').html(formatNumber(restoconretencion));
    $('#facturas_saldo_text_bsd').html(formatNumber(restoconretencion*exchangeRate));

    $('#totalAcumulado').html('0.00');
    $('#btnModalAgregarPagos').removeAttr('disabled');
    $('#pesos').val('0.00');
    $('#dollars').val('0.00');
    $('.montoAbonoBs').hide();      
    $('.montoAbonoUSD').hide(); 
  }
 
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
      $('#cli_direccion_despacho').val(data[i].dir_ent2);
      $('#cli_responsable').val(data[i].dato1);




    // Verificar si hay datos
    if (data[0].id_estado) {
        // Habilitar todos los combos
        $('#cli_estado, #cli_municipio, #cli_parroquia, #cli_ciudad').prop('disabled', false);
        
        // Limpiar y agregar las opciones con los datos recibidos
        $('#cli_estado').prepend('<option value="'+data[0].id_estado+'" selected>'+data[0].estado+'</option>');
        $('#cli_municipio').prepend('<option value="'+data[0].id_municipio+'" selected>'+data[0].municipio+'</option>');
        $('#cli_parroquia').prepend('<option value="'+data[0].id_parroquia+'" selected>'+data[0].parroquia+'</option>');
        $('#cli_ciudad').prepend('<option value="'+data[0].id_ciudad+'" selected>'+data[0].ciudad+'</option>');

        
      $('#cli_responsable_fecha').val(data[i].fechaNacimientoResponsable);
      $('#cli_aniversario_fecha').val(data[i].empresaAniversario);
      $('#cli_propietario_fecha').val(data[i].fechaNacimientoPropietario);
      $('#cli_responable_compras').val(data[i].responsableCompras);
      $('#cli_responsable_compras_fecha').val(data[i].fechaNacimientoResponsableCompras);

    } else {
        // No hay datos: deshabilitar todos excepto estado
        $('#cli_estado').prop('disabled', false).val(''); // Habilitar y limpiar selección
        $('#cli_municipio, #cli_parroquia, #cli_ciudad').prop('disabled', true).val(''); // Deshabilitar y limpiar
        
        // Opcional: Limpiar las opciones existentes si es necesario
        // $('#cli_municipio, #cli_parroquia, #cli_ciudad').empty();
    }




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

function obtenerTasa(fechaSeleccionada) {
    // Mostrar indicador de carga si es necesario
   
    $.ajax({
        type: "GET",
        url: '../admin/index.php?action=combos&a=1109&c=FacturaData&t=factura&fecha='+fechaSeleccionada,      
        success: function(response) {           
            if(response && response.length > 0 && response[0].tasa_v && response[0].tasa_r) {
                // Caso: Se encontraron tasas válidas
                var tasa = response[0].tasa_v;
                var tasa_r = response[0].tasa_r;
                var montoDolares = parseFloat($('#facturas_saldo_text').text());
                var montoBolivares = parseFloat(montoDolares * tasa_r).toFixed(2);
                
              
                
                $('#tasa_cambio').html(tasa).data('tasa_r', tasa_r);
                $('#facturas_saldo_text_bsd').html(formatNumber(montoBolivares));
              
                setSessionData('change_rate', {
                    exchangeRate: tasa_r
                });
            } else {
                // Caso: No se encontraron tasas válidas
               // console.warn("No se encontraron tasas para la fecha seleccionada. Estableciendo valores a cero.");
                establecerValoresPorDefecto();
            }
            
            // Resetear campos de entrada en ambos casos
            $('#pesos').val(0.00);
            $('#dollars').val(0.00);
        },
        error: function(xhr, status, error) {
            // Ocultar indicador de carga     
            console.error("Error en la solicitud AJAX:", status, error);
            // En caso de error, también establecer valores por defecto
            establecerValoresPorDefecto();
            $('#pesos').val(0.00);
            $('#dollars').val(0.00);
        }
    });
}  
  // Función modificada para aceptar un callback
function obtenerTasaRetenciones(fechaSeleccionada, montoBS, callback) {
    $.ajax({
      type: "GET",
      url: '../admin/index.php?action=combos&a=1109&c=FacturaData&t=factura&fecha=' + fechaSeleccionada,      
      success: function(response) {           
        if(response && response.length > 0 && response[0].tasa_v && response[0].tasa_r) {
          // Calcular monto con la tasa encontrada
          var tasa_r = response[0].tasa_r;
          var montoCalculadoRetenciones = montoBS / tasa_r;
          callback(montoCalculadoRetenciones);
        } else {
          // Si no hay tasa disponible, usar 0
          callback(0);
        }
      },
      error: function(xhr, status, error) {
        // En caso de error, usar 0
        callback(0);
      }
    });
}

// Función auxiliar para establecer valores por defecto
function establecerValoresPorDefecto() {
    $('#tasa_cambio').html('0').data('tasa_r', 0);
    $('#facturas_saldo_text_bsd').html('0.00');
    
    setSessionData('change_rate', {
        exchangeRate: 0
    });
}


function buscarDataReferencia(referencia) {
    $.ajax({
        type: "GET",
        url: '../admin/index.php?action=combos&c=FuncionesData&a=10000009&tabla=reng_tip&campo=num_doc&dato=' + referencia, 
    }).done(function(data) { 
        var referenciasConciliadas = [];
        
        // Recorrer todos los resultados para encontrar referencias conciliadas (id = 1)
        for (var i = 0; i < data.length; i++) {
            if (data[i].id == '1') {
                referenciasConciliadas.push(data[i].referencia); // Asumiendo que hay un campo 'referencia'
            }
        }
        
        // Si hay referencias conciliadas, mostrar mensaje con todas ellas
        if (referenciasConciliadas.length > 0) {
            // Crear mensaje con todas las referencias conciliadas
            var mensaje = 'Las siguientes referencias bancarias ya fueron conciliadas y registradas:\n';
            mensaje += referenciasConciliadas.join(', ');
            
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: mensaje.replace(/\n/g, '<br>')
            });
            
            $('#facturas_referencia').val('');      
            $('#pesos').prop('disabled', false);  
            $('#dollars').prop('disabled', false);  
        } else {
            // Si no hay referencias conciliadas, habilitar campos normalmente
            $('.montoAbonoBs').attr("style", "display:");      
            $('.montoAbonoUSD').attr("style", "display:"); 
            $('#pesos').removeAttr('disabled');
            $('#dollars').removeAttr('disabled');   
        }
    }).fail(function(error) {
        console.error('Error en la consulta AJAX:', error);
        // Manejar error si es necesario
    });   
}



function cargarComboEstados($combo, $filtro) {
  //console.log($combo);
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=selects&tipo=1&accion=1&datos=1&c=SelectsData&a=1&t=estados',
  }).done(function (data) {
    var i = 0;
    var tope = data.length;
    for (var i = 0; i < tope; i++) {
      $($combo).append('<option value = ' + data[i].id + '>' + data[i].data + '</option>');

    }

  });
}

function cargarComboMunicipios($combo, filtro) {
  var id = filtro;
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=selects&tipo=1&accion=1&datos=2&c=SelectsData&a=1&t=jm_municipios&d=' + id + '&cp=m.id_estado',
  }).done(function (data) {

    $($combo).html('<option value = "0">Seleccione</option>');
    //console.log(categorias);
    var i = 0;
    var tope = data.length;
    if (tope >= 1) {
      for (var i = 0; i < tope; i++) {
        $($combo).append('<option value = ' + data[i].id + '>' + data[i].data + '</option>');
      }
    } else {
      $($combo).html('<option value = "0">No existen Municipios asociados</option>');
    }
    //alert(tope);
  });
}



function cargarComboCiudades($combo, filtro) {
  var id = filtro;
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=selects&tipo=1&accion=1&datos=4&c=SelectsData&a=1&t=jm_ciudades&d=' + id + '&cp=m.id_estado',
  }).done(function (data) {

    $($combo).html('<option value = "0">Seleccione</option>');
    //console.log(categorias);
    var i = 0;
    var tope = data.length;
    if (tope >= 1) {
      for (var i = 0; i < tope; i++) {
        $($combo).append('<option value = ' + data[i].id + '>' + data[i].data + '</option>');
      }
    } else {
      $($combo).html('<option value = "0">No existen Ciudades asociados</option>');
    }
    //alert(tope);
  });
}

function cargarComboParroquias($combo, filtro) {
  var id = filtro;
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=selects&tipo=1&accion=1&datos=3&c=SelectsData&a=1&t=jm_parroquias&d=' + id + '&cp=e.id_municipio',
  }).done(function (data) {

    $($combo).html('<option value = "0">Seleccione</option>');
    //console.log(categorias);
    var i = 0;
    var tope = data.length;
    if (tope >= 1) {
      for (var i = 0; i < tope; i++) {
        $($combo).append('<option value = ' + data[i].id + '>' + data[i].data + '</option>');
      }
    } else {
      $($combo).html('<option value = "0">No existen Parroquias asociados</option>');
    }
    //alert(tope);
  });
}


function eliminarPagosRegistrados() {
  if ($('#PagosRealizados').length) {
  if (localStorage.getItem('pagosRegistrados') !== null) {
      localStorage.removeItem('pagosRegistrados');
      console.log('Variable eliminada correctamente.');
  } else {
      //console.log('La variable no existe en el localStorage.');
  }
}
}


function formatNumber(number, decimals = 2) {
  return parseFloat(number).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


function validarRIF(event) {
    const input = event.target;
    let valor = input.value.toUpperCase();
    const key = event.key;
    
    // Permitir teclas de control (backspace, delete, flechas, etc.)
    if (event.ctrlKey || event.altKey || 
        key === 'Backspace' || key === 'Delete' || 
        key === 'ArrowLeft' || key === 'ArrowRight' ||
        key === 'Tab') {
        return true;
    }
    
    // Si el campo está vacío, solo permitir letras válidas
    if (valor.length === 0) {
        const keyUpper = key.toUpperCase();
        if (!'CEGJPV'.includes(keyUpper)) {
            event.preventDefault();

             Swal.fire({
              icon: 'info',
              title: 'Tips...',
              text: 'El primer carácter debe ser una de las letras: C, E, G, J, P, V'
            
             }) 
         //   alert('El primer carácter debe ser una de las letras: C, E, G, J, P, V');
            return false;
        }
        // Convertir a mayúscula
        event.preventDefault();
        input.value = keyUpper;
        return false;
    }
    
    // Si ya hay contenido, solo permitir números
    if (!/[\d]/.test(key)) {
        event.preventDefault();
          Swal.fire({
              icon: 'info',
              title: 'Tips...',
              text: 'Después de la letra inicial, solo se permiten números'
            
             }) 
        
        return false;
    }
    
    return true;
}


function buildUrl(baseUrl, params) {
    const urlParams = new URLSearchParams();
    
    for (const key in params) {
        if (params[key] !== null && params[key] !== undefined) {
            urlParams.append(key, params[key]);
        }
    }
    
    return `${baseUrl}?${urlParams.toString()}`;
}