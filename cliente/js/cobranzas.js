/**
 * Formatea una fecha de YYYY-MM-DD a DD/MM/YYYY
 */
function formatFechaGlobal(fecha) {
  if (!fecha) return '';
  
  // Si ya tiene formato DD/MM/YYYY, devolverla tal cual
  if (fecha.includes('/')) return fecha;

  // Esperamos formato YYYY-MM-DD
  const partes = fecha.split('-');
  if (partes.length === 3) {
    // Devolvemos DD/MM/YYYY
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
  }
  
  return fecha; // Fallback
}

function cargarTablaFacturasCliente() {
  var datatables_basic_facturas = $('.dataTablesFacturas');
  
  let cacheData = null;
  let currentFilter = 'all'; 
  let isLoading = false;

  // --- DEFINICIÓN DE ICONOS SVG ---
  const svgMenu = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-50"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';
  const svgFilter = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-50"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>';
  const svgCheck = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-50"><polyline points="20 6 9 17 4 12"></polyline></svg>';
  const svgFile = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-50"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>';
  const svgClipboard = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-50"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';




  // Función para mostrar/ocultar loader
  function showLoader(show = true) {
    if (show) {
      $('.loader-container').show();
    } else {
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

    // --- FUNCIÓN AUXILIAR PARA ESTILO DE BOTONES DE FILTRO ---
    // Función global para ser llamada desde los botones de DataTables
    window.actualizarEstiloBotonesFiltro = function(activeNode) {
        $('.btn-filtro-rapido').removeClass('btn-primary').addClass('btn-outline-secondary');
        $(activeNode).removeClass('btn-outline-secondary').addClass('btn-primary');
    };

    // Obtener datos (con cache)
    obtenerDatosFacturas().then(arrayFacturas => {
      
     
    

      var dt_basic = datatables_basic_facturas.DataTable({
        scrollY: 'calc(100vh - 300px)',
        scrollX: true,
        scrollCollapse: true,
          responsive: true ,// <-- ESTA ES LA LÍNEA MÁGICA
        fixedHeader: {
          header: true,
          footer: false
        },
        data: arrayFacturas,
        columns: [
          { data: 'responsive_id' },  // 0
          { data: 'nro_doc' }, // 1
          { data: 'serie_fact_num' }, // 2
          { data: 'dato6' }, // 3
          { data: 'saldo' }, // 4
          { data: 'monto_transito' }, // 5
          { data: 'co_cli' }, // 6
          { data: 'fec_emis' }, // 7
          { data: 'fec_venc' }, // 8
          { data: 'tipo_doc' }, // 9
          { data: 'tasa' }, // 10
          { data: 'saldo2' }, // 11
          { data: 'saldo3' }, // 12
          { data: 'dato4' }, // 13
          { data: 'dato1' }, // 14
          { data: 'cli_des' }, // 15
          { data: 'sucursal' }  // 16
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
            visible: true,
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esAdelanto) {
                return (
                  '<input class="dt-checkboxes facturas" type="checkbox" disabled ' +
                  'title="Este documento es un adelanto y no puede ser seleccionado" />'
                );
              } else {
                return (
                  `<input class="dt-checkboxes facturas ${full['nro_doc']}"
                    type="checkbox" ${full['nro_doc']}="${full['saldo2']}" 
                    data-${full['nro_doc']}="${full['saldo3']}" 
                    data-cocli${full['nro_doc']}="${full['co_cli']}" 
                    data-clides${full['nro_doc']}="${full['cli_des']}" 
                    data-clicond${full['nro_doc']}="${full['dato7']}" 
                    data-clicondm${full['nro_doc']}="${full['dato8']}" 
                    data-factipo${full['nro_doc']}="${full['dato9']}" 
                    data-montoimp${full['nro_doc']}="${full['dato10']}" 
                    data-montotransito${full['nro_doc']}="${full['monto_transito']}" 
                    value="${full['nro_doc']}" id="checkbox${data}" />`
                );
              }
            }
          },
          {
            targets: 2,
            title: 'Nº Documento',
            width: '20%',
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esAdelanto) {
                return (
                  `<span>${data}</span> <span title="Adelanto - No puede ser seleccionado">ADEL</span>`
                );
              }
              return data;
            }
          },
          {
            targets: 3,
            title: 'Forma',
            width: '10%',
            visible: false,
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esNotaCredito) {
                return '<span></span>';
              } else if (esAdelanto) {
                return '<span>Adelanto</span>';
              }
              
              var $status_number = full['dato6'];
              var $status = {
                0: { title: 'BS.D' },
                1: { title: 'USD' }
              };
              if (typeof $status[$status_number] === 'undefined') {
                return data;
              }
              return $status[$status_number].title;
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
                return `<span title="Abono a su saldo">${data}</span>`;
              } else if (esAdelanto) {
                return `<span title="Adelanto">${data}</span>`;
              }
              
              var status_number = formatoEuropeo(full['saldo']);           
              return status_number;
            }
          },
          {
            targets: 5,
            title: 'Por conciliar',
            width: '10%',
            render: function (data, type, full, meta) {
              var status_number =  formatoEuropeo(full['monto_transito']);           
              return status_number;
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
                <div>
                  <span>${co_cli}</span>
                  <div>
                    <span><strong>Razón social:</strong> ${cli_des}</span>
                  </div>
                </div>
              `;
            }
          },
         {
            targets: 7,
            title: 'Fecha emisión',
            width: '15%',
            render: function (data, type, full, meta) {
              const fecEmis = full['fec_emis'] || '';
              const fecVenc = full['fec_venc'] || '';
              
              const fecEmisFormat = formatFechaGlobal(fecEmis);
              const fecVencFormat = formatFechaGlobal(fecVenc);

              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esNotaCredito || esAdelanto) {
                return `
                  <div>
                    <div><small>Emisión:</small> ${fecEmisFormat}</div>
                    <div><small>Referencia:</small> ${esNotaCredito ? 'Nota de Crédito' : 'Adelanto'}</div>
                  </div>
                `;
              }
              
              const hoy = new Date();
              const venc = new Date(fecVenc);
              const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
              
              let classVenc = 'text-success';
              if (diasDiff < 0) classVenc = 'text-danger'; 
              else if (diasDiff <= 5) classVenc = 'text-warning';
              
              return `
                <div>              
                  <div><small>EMITIDA:</small> ${fecEmisFormat}</div>
                </div>
              `;
            }
          },
          {
            targets: 8,
            title: 'Fecha vencimiento',
            width: '15%',
                render: function (data, type, full, meta) {
              const fecEmis = full['fec_emis'] || '';
              const fecVenc = full['fec_venc'] || '';
              
              const fecEmisFormat = formatFechaGlobal(fecEmis);
              const fecVencFormat = formatFechaGlobal(fecVenc);

              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              if (esNotaCredito || esAdelanto) {
                return `
                  <div>
                    <div><small>Emisión:</small> ${fecVencFormat}</div>
                    <div><small>Referencia:</small> ${esNotaCredito ? 'Nota de Crédito' : 'Adelanto'}</div>
                  </div>
                `;
              }
              
              const hoy = new Date();
              const venc = new Date(fecVenc);
              const diasDiff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
              
              let classVenc = 'text-success';
              if (diasDiff < 0) classVenc = 'text-danger'; 
              else if (diasDiff <= 5) classVenc = 'text-warning';
              
              return `
                <div>
                  <div><small>VENCE:</small> <span class="${classVenc}">${fecVencFormat}</span></div>                
                </div>
              `;
            }
          },
          {
            targets: 9,
            title: 'Tipo',
            width: '5%',
                  visible: false,
            render: function (data, type, full, meta) {
              return data;
            }
          },
          {
            targets: 10,
            title: 'Tasa',
            width: '10%',
            render: function (data, type, full, meta) {
              var status_number = full['tasa'];           
              return status_number;
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
              visible: false,
            width: '10%',
            render: function (data, type, full, meta) {
              const tipoDoc = full['tipo_doc'] || '';
              const esNotaCredito = tipoDoc.toUpperCase().includes('N/CR');
              const esAdelanto = tipoDoc.toUpperCase().includes('ADEL');
              
              let formaHTML = '';
              if (esNotaCredito) {
                formaHTML = '<span>N/Crédito</span>';
              } else if (esAdelanto) {
                formaHTML = '<span>Adelanto</span>';
              } else {
                const formaNum = full['dato6'];
                const formas = {
                  0: { title: 'BS.D' },
                  1: { title: 'USD' }
                };
                formaHTML = `<span>${formas[formaNum]?.title || 'N/A'}</span>`;
              }
              
              if (esNotaCredito || esAdelanto) {
                return `
                  <div>
                    ${formaHTML}
                    <span>No aplica vencimiento</span>
                  </div>
                `;
              }
              
              const dias = parseInt(full['dato4']) || 0;
              let estado = '';
              
              if (dias >= 0) {
                estado = 'Vencida';
              } else if (dias >= -4 && dias <= -1) {
                estado = 'Próxima a vencer';
              } else if (dias <= -5) {
                estado = 'Vigente';
              }
              
              const condicionHTML = `<span>${estado}</span>`;
              
              return `
                <div>
                  ${formaHTML}
                  ${condicionHTML}
                </div>
              `;
            }
          },
          {
            targets: 14,
            title: 'Estatus',
            visible: true,
            width: '5%',
            render: function (data, type, full, meta) {
              var $status_number = full['dato1'];
              var $status = {
                0: { title: 'Pendiente' },
                1: { title: 'Por conciliar' }
              };
              if (typeof $status[$status_number] === 'undefined') {
                return data;
              }
              return $status[$status_number].title;
            }
          },
           {
            targets: 15,
            title: 'Cliente',
            visible: false,
            width: '5%',
            render: function (data, type, full, meta) {
              var $status_number = full['cli_des'];
               return $status_number;
            }
          },
         
          {
            targets: -1,
            title: 'IVA',
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
                  `<a href="javascript:;" class="btn-retencion-sin-deposito" 
                    data-factura-id="${full['nro_doc']}" 
                    title="Retención sin depósito">
                    Retención
                  </a>`
                );
              }
              
              if (retencionCargada) {
                return (
                  `<a href="javascript:;" 
                    title="Retencion cargada N°:${full['dato11']}" disabled>
                    Cargada
                  </a>`
                );
              }
              
             return (
                `<a href="javascript:;" 
                  title="No aplica para retención" disabled>
                  N/A
                </a>`
              );
            }
          },
          {
            responsivePriority: 1,
            targets: 4
          }
        ],
      order: [[8, 'desc']],
      // --- NUEVO DOM ---
      dom: '<"d-flex justify-content-between align-items-center mb-3"<""><"dt-action-buttons ms-auto"B>><"d-flex justify-content-between align-items-center mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i>ss<"col-sm-12 col-md-6"p>>',
      // ----------------
      displayLength: 10,
        lengthMenu: [7, 10, 25, 50, 75, 100],

        drawCallback: function (settings) {
           // Callback vacío
        },

        // --- CONFIGURACIÓN UNIFICADA DE BOTONES ---
        buttons: [
          // 1. FILTROS RÁPIDOS (Integrados aquí)
          {
            text: svgFilter + ' Todas',
            className: 'btn btn-sm btn-primary btn-filtro-rapido  me-1', // Inicia activo (all)
            action: function (e, dt, node, config) {
                currentFilter = 'all';
                filtrarTablaActual();
                actualizarEstiloBotonesFiltro(node);
            }
          },
          {
            text: svgFilter + ' Por vencer',
            className: 'btn btn-sm btn-outline-secondary btn-filtro-rapido  me-1',
            action: function (e, dt, node, config) {
                currentFilter = 'por_vencer';
                filtrarTablaActual();
                actualizarEstiloBotonesFiltro(node);
            }
          },
          {
            text: svgFilter + ' Vencidas',
            className: 'btn btn-sm btn-outline-secondary btn-filtro-rapido  me-1',
            action: function (e, dt, node, config) {
                currentFilter = 'vencidas';
                filtrarTablaActual();
                actualizarEstiloBotonesFiltro(node);
            }
          },

          {
            text: svgCheck + ' Reportar',
            className: 'btn btn-sm btn-primary  me-1',
            action: function (e, dt, node, config) {
                currentFilter = 'vencidas';
                 procesarFacturasButton();
            }
          },
          // Separador visual (espaciador a la derecha de los filtros)
       
          // 2. ACCIONES PRINCIPALES (Dropdown)
        
        ],

            /*   
            <div class="dropdown">
                <button class="btn btn-gray dropdown-toggle me-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown button
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><h6 class="dropdown-header">Dropdown header</h6></li>
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            */
        responsive: {
              details: {
                display: $.fn.dataTable.Responsive.display.modal({
                  header: function (row) {
                    var data = row.data();
                    return ''; // Puedes poner un título aquí si quieres
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

      // --- LÓGICA DE RESTRICCIÓN POR TIPO DE FACTURA (dato9) ---
      $(document).on('change', '.dt-checkboxes.facturas', function() {
          var $allCheckboxes = $('.dt-checkboxes.facturas');
          var selectedTypes = new Set();
          
          $allCheckboxes.filter(':checked').each(function() {
              var id = $(this).val();
              var type = $(this).attr('data-factipo' + id); 
              if(type) selectedTypes.add(type);
          });

          if (selectedTypes.size > 1) {
              $(this).prop('checked', false);
              selectedTypes.clear();
              $allCheckboxes.filter(':checked').each(function() {
                  var id = $(this).val();
                  var type = $(this).attr('data-factipo' + id);
                  if(type) selectedTypes.add(type);
              });
          }

          var activeType = null;
          if (selectedTypes.size === 1) {
              activeType = selectedTypes.values().next().value;
          }

          $allCheckboxes.each(function() {
              var $cb = $(this);
              if ($cb.prop('checked')) {
                  $cb.prop('disabled', false);
                  $cb.removeAttr('title');
                  return;
              }

              var id = $(this).val();
              var currentType = $(this).attr('data-factipo' + id);

              if (activeType) {
                  if (currentType !== activeType) {
                      $cb.prop('disabled', true);
                      $cb.attr('title', activeType == 1 ? 'No puede seleccionar facturas exentas junto a facturas con IVA' : 'No puede seleccionar facturas con IVA junto a facturas exentas');
                  } else {
                      $cb.prop('disabled', false);
                      $cb.removeAttr('title');
                  }
              } else {
                  $cb.prop('disabled', false);
                  $cb.removeAttr('title');
              }
          });
          // --- MEJORA: CÁLCULO Y ACTUALIZACIÓN (TRANSITO + REPORTAR) ---
          let totalSeleccionado = 0;       // Total final a reportar
          let totalSeleccionadoBs = 0;    // Total final a reportar BS
          
          // Variables para la sección de Tránsito
          let totalTransito = 0;          // Suma total en tránsito USD
          let totalTransitoBs = 0;       // Suma total en tránsito BS

          // Recorremos solo los checkboxes habilitados y marcados
          $allCheckboxes.filter(':checked:not(:disabled)').each(function() {
              const id = $(this).val();
              
              // 1. Obtener valores originales
              let montoUSD = parseFloat($(this).attr(id)) || 0;           
              let montoBs = parseFloat($(this).attr('data-' + id)) || 0; 
              let montoTransito = parseFloat($(this).attr('data-montotransito' + id)) || 0;

              // 2. Sumar al TOTAL EN TRÁNSITO
              if (montoTransito > 0) {
                  totalTransito += montoTransito;
                  
                  if (montoUSD > 0) {
                      let tasaFactura = montoBs / montoUSD;
                      let transitoBsCalc = montoTransito * tasaFactura;
                      totalTransitoBs += transitoBsCalc;
                  }
              }

              // 3. Calcular valores finales para REPORTAR (RESTANDO tránsito)
              let montoFinalUSD = montoUSD;
              let montoFinalBs = montoBs;

              if (montoTransito > 0) {
                  montoFinalUSD = montoUSD - montoTransito;
                  if (montoFinalUSD < 0) montoFinalUSD = 0;

                  if (montoUSD > 0) {
                      let tasaFactura = montoBs / montoUSD;
                      let descuentoBs = montoTransito * tasaFactura;
                      montoFinalBs = montoBs - descuentoBs;
                      if (montoFinalBs < 0) montoFinalBs = 0;
                  } else {
                      montoFinalBs = 0;
                  }
              }

              totalSeleccionado += montoFinalUSD;
              totalSeleccionadoBs += montoFinalBs;
          });

          const $card = $('#invoice-summary-card');

          // --- ACTUALIZAR SECCIÓN TRÁNSITO ---
          // Solo mostramos los valores si existen, dejamos en 0.00 si no
          $card.find('#transit-amount-display').text(
              '$' + formatoEuropeo(totalTransito)
          );
          $card.find('#transit-amount-display-bs').text(
              'Bs ' + formatoEuropeo(totalTransitoBs)
          );
          // ---------------------------------

          // --- ACTUALIZAR SECCIÓN REPORTAR ---
          $card.find('#total-amount-display').text(
              '$' + formatoEuropeo(totalSeleccionado)
          );
          $card.find('#total-amount-display-bs').text(
              'Bs ' + formatoEuropeo(totalSeleccionadoBs)
          );
          // ---------------------------------

          // Control de visibilidad: Mostrar la tarjeta si hay algo que reportar O algo en tránsito
          if (totalSeleccionado > 0 || totalSeleccionadoBs > 0 || totalTransito > 0 || totalTransitoBs > 0) {
              $card.fadeIn();
          } else {
              $card.fadeOut();
          }
          // ---------------------------------------------------
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
        
        let tipo_fiscal_anterior = null;
        let primer_tipo_fiscal = null;

        for (let i = 0; i < arrayFacturas.length; i++) {
          const factura = arrayFacturas[i];
          
          const monto = factura.monto;
          const monto2 = factura.montoBs;
          co_cli = factura.co_cli;
          cli_des = factura.cli_des;
          cli_cond = factura.cli_cond;
          const tipo_fiscal = factura.tipo_fiscal;

          if (i === 0) {
            co_cli_anterior = co_cli;
            primer_co_cli = co_cli;
            tipo_fiscal_anterior = tipo_fiscal;
            primer_tipo_fiscal = tipo_fiscal;
          } else {
            if (co_cli !== co_cli_anterior) {
              facturas_con_error.push({
                factura: factura.id,
                error: `Factura ${factura.id} pertenece a otro cliente (${co_cli})`,
                detalle: 'Cliente diferente'
              });
            }
            
            if (tipo_fiscal !== primer_tipo_fiscal) {
               const tipoTexto = tipo_fiscal == '6' ? 'Exenta' : 'Con IVA';
               const tipoTextoPrimero = primer_tipo_fiscal == '6' ? 'Exenta' : 'Con IVA';
               
               facturas_con_error.push({
                 factura: factura.id,
                 error: `Factura ${factura.id} es ${tipoTexto} y las anteriores son ${tipoTextoPrimero}`,
                 detalle: 'Mezcla de tipos de factura'
               });
            }
          }

          saldo = parseFloat((saldo + monto).toFixed(2));
          saldoBs = parseFloat((saldoBs + monto2).toFixed(2));
        }

        if (facturas_con_error.length > 0) {
          let mensaje = "Error de validación en la selección:\n\n";
          facturas_con_error.forEach(function(error) {
            mensaje += `• ${error.error}\n`;
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
                  `<input type="text" class="num_retencion" name="num_retencion${index}" required>` : 
                  `<span>No aplica retención</span>`
                }
              </td>
              <td>
                ${esAplicableRetencion ? 
                  `
                   <div>
                  <span>BS</span>
                  <input type="number" class="monto-retencion-bs" name="monto_retencion_bs_${index}" step="0.01" min="0.01" 
                         max="${saldoTotalBs}" required> 
              </div>` : 
                  `<span>N/A</span>`
                }
              </td>
              <td>
                ${esAplicableRetencion ? 
                  `<input type="text" class="flatpickr-basic flatpickr-input fecha_retencion" 
                        name="fecha_retencion${index}" placeholder="YYYY-MM-DD">` : 
                  `<span>N/A</span>`
                }
              </td>
              <td>
                ${esFiscal ? 
                  `<span>Aplicable</span>` : 
                  `<span>Excenta</span>`
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
        console.log('Archivo seleccionado:', archivo);
        console.log('Datos de retención:', {
          numRetencion,
          montoBs,  
          tasaRetencion,  
          fechaRetencion
        });
        if (!numRetencion || isNaN(montoBs) || montoBs <= 0 || !fechaRetencion || isNaN(tasaRetencion)) {
          Swal.fire({
            icon: 'error',
            title: 'Datos incompletos',
            text: 'Por favor, complete todos los campos obligatorios.',
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
        
        fetch('../admin/index.php?action=mpago&tipo=1&accion=1&datos=4', {
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
             //$("#modalRetencionSinDeposito").modal("hide");
            //  cargarTablaFacturasCliente();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message,
              confirmButtonText: 'Aceptar'
            });
          }
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor.',
            confirmButtonText: 'Aceptar'
          });
        });
      }

      function mostrarError(titulo, mensaje) {
        Swal.fire({
          icon: 'error',
          title: titulo,
          text: mensaje,
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
          confirmButtonText: 'Sí, continuar',
          cancelButtonText: 'No, cancelar',
          focusConfirm: false
        }).then((result) => {
          callback(result.isConfirmed);
        });
      }

      function mostrarAlertaAdelanto() {
        Swal.fire({
          title: 'Información',
          text: 'No ha seleccionado facturas a reportar.',
          icon: 'info',
          confirmButtonText: 'Aceptar'
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
            <div>
              <p>Este cliente es un contribuyente especial.</p>
              <p>Se han seleccionado ${facturasAplicanRetencion.length} factura(s) que aplican para retención.</p>
              <p>¿Deseas registrar <strong>Retenciones</strong> para estas facturas?</p>
              <small>
                Facturas aplicables: ${facturasAplicanRetencion.map(f => f.id).join(', ')}
              </small>
            </div>
          `,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, registrar',
          cancelButtonText: 'No, continuar',
          focusConfirm: false,
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
          
          <div class="row mb-3 d-none">
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
        cacheData = null;
        currentFilter = 'all';
        
        $('.comboClientesFactura').val(0);
        $('.tipo_documento').val('NO');
        $('.finicio').val('');
        $('.ffinal').val('');
        
        cargarDataFacturas('NO','NO','NO','NO','NO','NO');
      }

      // --- ELIMINADO EL BLOQUE DE INSERCIÓN MANUAL DE BOTONES ---
      // Los botones ahora están integrados en la configuración 'buttons' de DataTables arriba.

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



// Función genérica para mostrar datos de localStorage en elementos HTML
function mostrarDatosLocalStorage() {
    // Mostrar exchange rate
    try {
        const miObjeto = JSON.parse(localStorage.getItem('change_rate'));
        if (miObjeto) {
            $('#textChangeRate').text(miObjeto.exchangeRate);
        }
    } catch(e) {
        console.error('Error al parsear JSON de localStorage:', e);
    }
    
    // Mostrar fecha actual
    const hoy = new Date();
    const opciones = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    
    // Formato: "20 de febrero de 2026"
    const fechaFormateada = hoy.toLocaleDateString('es-ES', opciones);
    
    // Si quieres formato "20/02/2026"
    const fechaSimple = hoy.toLocaleDateString('es-ES'); // 20/02/2026
    
    // Si quieres formato "20-02-2026"
    const dia = String(hoy.getDate()).padStart(2, '0');
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const año = hoy.getFullYear();
    const fechaGuiones = `${dia}-${mes}-${año}`;
    
    // Muestra la fecha en el elemento que elijas
    $('#textChangeRateDay').text(fechaFormateada); // Cambia 'fechaHoy' por el ID de tu elemento HTML
}



$(window,document,$).ready(function(){


  cargarDataFacturas('NO','NO','NO','NO','NO','NO');
  mostrarDatosLocalStorage();

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
function actualizarTarjetasResumen(datosFacturas) {
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    
    let totalGeneral = 0;
    let totalPorVencer = 0;
    let totalVencidas = 0;
    
    let countGeneral = 0;
    let countPorVencer = 0;
    let countVencidas = 0;
    
    datosFacturas.forEach(factura => {
        const saldo = parseFloat(factura.saldo.toString().replace(',', '.')) || 0;
        totalGeneral += saldo;
        countGeneral++;
        
        const fechaVenc = new Date(factura.fec_venc);
        fechaVenc.setHours(0, 0, 0, 0);
        const diasDiff = Math.ceil((fechaVenc - hoy) / (1000 * 60 * 60 * 24));
        
        if (diasDiff < 0) {
            totalVencidas += saldo;
            countVencidas++;
        } else if (diasDiff <= 5) {
            totalPorVencer += saldo;
            countPorVencer++;
        }
    });
    
    // Actualizar primera tarjeta (Total)
    const $totalCard = $('.col-xl-2:eq(0)');
    $totalCard.find('h3').text(formatoEuropeo(totalGeneral));
    $totalCard.find('p').html(`<small>${countGeneral} documento(s)</small>`);
    
    // Actualizar segunda tarjeta (Por vencer)
    const $porVencerCard = $('.col-xl-2:eq(1)');
    $porVencerCard.find('h3').text(formatoEuropeo(totalPorVencer));
    $porVencerCard.find('p').html(`<small>${countPorVencer} documento(s)</small>`);
    
    // Actualizar tercera tarjeta (Vencido)
    const $vencidasCard = $('.col-xl-2:eq(2)');
    $vencidasCard.find('h3').text(formatoEuropeo(totalVencidas));
    $vencidasCard.find('p').html(`<small>${countVencidas} documento(s)</small>`);
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
        url: '../admin/index.php?action=cliente&tipo=1&accion=getFacturasCliente&datos=3&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro='+$filtro+
        '&filtro2='+$filtro2+'&filtro3='+$filtro3+'&filtro4='+$filtro4+'&filtro5='+$filtro5,
    }).done(function(data) { 

         // ACTUALIZAR TARJETAS DE RESUMEN
            actualizarTarjetasResumen(data);
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

function setSessionData(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}
