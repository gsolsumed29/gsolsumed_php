function mostrarFacturas(rowIndex) {
  // 1. Acceder a la tabla y obtener los datos de la fila
  var table = $('.datatables-basic-cuentas').DataTable();
  var data = table.row(rowIndex).data();

  if (!data) {
      console.error("No se encontraron datos");
      return;
  }

  // 2. El campo 'facturas_detalle' ya es un string JSON gracias a PHP
  // Lo parseamos a objeto JavaScript
  var facturas = JSON.parse(data.facturas_detalle || "[]");

  // 3. Limpiar y llenar la tabla
  var tbody = document.getElementById('filaFactura');
  tbody.innerHTML = "";

  if (facturas.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay facturas pendientes.</td></tr>';
  } else {
      facturas.forEach(function(factura) {
          var fila = '<tr>' +
              '<td>' + factura.nro + '</td>' +
              '<td>' + factura.nro_doc + '</td>' +
              '<td>' + factura.tipo_doc + '</td>' +
              '<td>' + factura.saldo + '</td>' +
              '<td>' + factura.fec_emis + '</td>' +
                 '<td>' + factura.fec_venc + '</td>' +
              '<td>' + factura.dato3 + '</td>' + // Dias vencidos
              '</tr>';
          tbody.innerHTML += fila;
      });
  }

  // 4. Abrir modal
  var myModal = new bootstrap.Modal(document.getElementById('modalDetalleFacturaInterna'));
  myModal.show();
}

function cargarTablaCuentasPorCobrar() {
  var dt_basic_table_cuentas = $('.datatables-basic-cuentas');
  assetPath = '../app-assets/';

  if (dt_basic_table_cuentas.length) {
      // Destruir si existe para reinicializar
      if ($.fn.DataTable.isDataTable(dt_basic_table_cuentas)) {
          dt_basic_table_cuentas.DataTable().destroy();
      }

      let dataCuentasPorCobrar = $('.dataCuentasPorCobrar').val();
      let arrayCuentas = "";
      arrayCuentas = JSON.parse(dataCuentasPorCobrar);

      var dt_basic = dt_basic_table_cuentas.DataTable({
        
          data: arrayCuentas,
          // SE ACTUALIZARON LAS COLUMNAS
          columns: [
            { data: 'responsive_id' }, // 0
            { data: 'co_cli' },        // 1 (Oculta)
            { data: 'co_cli' },        // 2 (Código visible)
            { data: 'cli_des' },       // 3 (Cliente)
            { data: 'tipo_cliente' },   // 4 (Cliente)
            { data: 'rif' },           // 5 (Rif)
            { data: 'responsable' },   // 6 (Responsable)
            { data: 'telefonos' },     // 7 (Teléfonos)
            { data: 'saldo' },         // 8 (Saldo)
            { data: 'des_ven' },       // 9 (Saldo)
            { data: '' }               // 10 (Acciones)
        ],
          columnDefs: [
              {
                  // Responsive Control
                  className: 'control',
                  orderable: false,
                  responsivePriority: 2,
                  targets: 0
              },
              {
                  // Ocultar ID original
                  targets: 1,
                  visible: false
              },
              {
                  // Columna Código
                  targets: 2,
                  visible: true
              },
                {
    // Columna Cliente - Versión optimizada
    targets: 3,
    responsivePriority: 1,
    width: '40%',
    render: function (data, type, full, meta) {
        var $name = full['cli_des'] || '';
        var $email = full['rif'] || '';
        var $image = full['avatar'];
        
        // Para ordenamiento y búsqueda usamos el nombre completo
        if (type === 'sort' || type === 'filter') {
            return $name;
        }
        
        // Para visualización, truncamos con tooltip si es necesario
        var needsTooltip = $name.length > 45;
        var displayName = needsTooltip ? $name.substring(0, 42) + '...' : $name;
        var tooltipAttr = needsTooltip ? ' title="' + $name.replace(/"/g, '&quot;') + '"' : '';
        
        var stateNum = Math.floor(Math.random() * 6),
            states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'],
            $state = states[stateNum],
            $initials = $name.match(/\b\w/g) || [];
        $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
        
        if ($image) {
            var $output = '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" width="32" height="32">';
        } else {
            $output = '<div class="avatar-content">' + $initials + '</div>';
        }
        
        var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : ' ';
        
        var $rowOutput =
            '<div class="d-flex justify-content-left align-items-start">' + // Cambiado a align-items-start
            '<div class="avatar-wrapper me-50">' +
            '<div class="avatar' + colorClass + '">' + $output + '</div>' +
            '</div>' +
            '<div class="d-flex flex-column" style="min-width: 0; flex: 1;">' +
            '<h6 class="user-name mb-0" ' + tooltipAttr + 
            ' style="white-space: normal; word-break: break-word; line-height: 1.3; font-size: 0.95rem;">' +
            displayName + 
            '</h6>' +
            '<small class="text-muted" style="font-size: 0.8rem; word-break: break-word;">' +
            $email +
            '</small>' +
            '</div>' +
            '</div>';
        return $rowOutput;
    }
},
   
              {
                  // Columna Rif
                  targets: 4,
                  visible: true,
                  width: '10%'
              },
                         {
          // Client name and Service
          targets: 6,
          responsivePriority: 2,
          width: '30%',
          render: function (data, type, full, meta) {
            var $name = full['responsable'],
              $email = full['telefonos'],
              $image = full['avatar'],
              stateNum = Math.floor(Math.random() * 6),
              states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'],
              $state = states[stateNum],
              $name = full['responsable'],
              $initials = $name.match(/\b\w/g) || [];
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            if ($image) {
              // For Avatar image
              var $output =
                '<img  src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" width="32" height="32">';
            } else {
              // For Avatar badge
              $output = '<div class="avatar-content">' + $initials + '</div>';
            }
            // Creates full output for row
            var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : ' ';

            var $rowOutput =
              '<div class="d-flex justify-content-left align-items-center">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar' +
              colorClass +
              'me-50">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<h6 class="user-name text-truncate mb-0">' +
              $name +
              '</h6>' +
              '<small class="text-truncate text-muted">' +
              $email +
              '</small>' +
              '</div>' +
              '</div>';
            return $rowOutput;
          }
        },
              {
                  // Columna Teléfonos (NUEVA)
                  targets: 7,
                  visible: false,
                  width: '10%'
              },    
        
              {
                  // Columna Saldo (Badge colores)
                  // Target actualizado de 5 a 7
                  targets: 8,
                  width: '10%',
                  render: function (data, type, full, meta) {
                      var $status_number = full['saldo'];
                      // Nota: El saldo viene como string "245,75". Para comparar numéricamente mejor limpiarlo
                      // Si es solo visual, tu lógica anterior funciona, pero cuidado con el formato de miles.
                      // Asumiré que tu lógica anterior de <0 es correcta para tu contexto.
                      if (parseFloat($status_number.replace(',','.')) < 0) {
                          return (
                              '<span class="badge rounded-pill bg-success ">' + $status_number + '</span>'
                          );
                      } else {
                          return (
                              '<span class="badge rounded-pill  bg-danger ">' + $status_number + '</span>'
                          );
                      }
                  }
              },
              {
                  // Columna Teléfonos (NUEVA)
                  targets: 9,
                  visible: true,
                  width: '250px'
              },
         {
              // ACCIONES (Botones)
              targets: -1,
              title: 'Acciones',
              width: '25%', // Aumentamos el ancho para 4 botones
              orderable: false,
              render: function (data, type, full, meta) {
                  var rowIndex = meta.row;
                  var telefono = full['telefonos'].trim().replace(/'/g, "\\'");
                  var co_cli = full['co_cli'].trim().replace(/'/g, "\\'");
                  var cli_des = full['cli_des'].trim().replace(/'/g, "\\'");

                  return (
                      '<div class="d-flex align-items-center col-actions">' +
                      
                      // 1. BOTÓN OJO (Facturas)
                      '<a class="me-25" href="javascript:mostrarFacturas(' + rowIndex + ');" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Facturas">' +
                      feather.icons['eye'].toSvg({ class: 'font-medium-2 text-body' }) +
                      '</a>' +

                      // 2. BOTÓN USUARIO (Cliente)
                      '<a class="me-25" href="javascript:verDetallesCliente(' + rowIndex + ');" data-bs-toggle="tooltip" data-bs-placement="top" title="Datos Cliente">' +
                      feather.icons['user'].toSvg({ class: 'font-medium-2 text-info' }) +
                      '</a>' +

                      // 3. BOTÓN MENSAJE
                      '<a class="me-25" href="javascript:abrirModalMensaje(\'' + co_cli + '\');" data-bs-toggle="tooltip" data-bs-placement="top" title="Enviar Mensaje">' +
                      feather.icons['message-square'].toSvg({ class: 'font-medium-2 text-success' }) +
                      '</a>' +
                      
                      // 4. NUEVO BOTÓN REPORTAR LLAMADA
                      '<a class="me-25" href="javascript:abrirModalReporteLlamada(' + rowIndex + ');" data-bs-toggle="tooltip" data-bs-placement="top" title="Reportar Llamada">' +
                      feather.icons['phone-call'].toSvg({ class: 'font-medium-2 text-primary' }) +
                      '</a>' +
                      
                      '</div>'
                  );
              }
          }
          ],
          // Ordenamiento por Saldo (índice actualizado a 7)
          order: [[8, 'desc']], 
          dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 50,
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
                          // Actualizamos índices de exportación (2:Codigo, 3:Cliente, 4:Rif, 5:Resp, 6:Tel, 7:Saldo)
                          exportOptions: { columns: [2, 3, 4, 5, 6, 7,8] }
                      },
                      {
                          extend: 'pdf',
                          text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                          className: 'dropdown-item',
                          orientation: 'landscape',
                          exportOptions: { columns: [2, 3, 4, 5, 6, 7,8] }
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

            // Después de inicializar DataTable, añade:
      dt_basic_table_cuentas.on('draw.dt', function() {
          // Reinicializar tooltips de Bootstrap si usas la opción 2
          if (typeof bootstrap !== 'undefined') {
              var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
              tooltipTriggerList.map(function (tooltipTriggerEl) {
                  return new bootstrap.Tooltip(tooltipTriggerEl);
              });
          }
      });
      
      // Re-inicializar iconos feather para los botones recién creados
      feather.replace();
  }
}

// Función para abrir el modal de Detalles del Cliente
function verDetallesCliente(rowIndex) {
  // 1. Acceder a la instancia de la tabla
  var table = $('.datatables-basic-cuentas').DataTable();
  
  // 2. Obtener los datos de la fila específica usando el índice
  var data = table.row(rowIndex).data();

  // 3. Llenar el modal con esos datos
  if (data) {
      $('#detCoCli').text(data.co_cli);
      $('#detCliDes').text(data.cli_des);
      $('#detRif').text(data.rif);
      $('#detResponsable').text(data.responsable);
      $('#detTelefonos').text(data.telefonos);
      $('#detSaldo').text(data.saldo);

      // 4. Abrir el modal
      var myModal = new bootstrap.Modal(document.getElementById('modalDetallesCliente'));
      myModal.show();
  } else {
      console.error("No se encontraron datos para la fila " + rowIndex);
  }
}

function abrirModalMensaje(co_cli) {
  // 1. Instanciar la tabla
  var table = $('.datatables-basic-cuentas').DataTable();
  
  // 2. Buscar la fila que coincida con el co_cli
  var row = table.row(function(idx, data, node) {
      return data.co_cli == co_cli;
  });

  // 3. Obtener los datos de esa fila
  var data = row.data();

  if (!data) {
      console.error("No se encontraron datos para el cliente: " + co_cli);
      return;
  }

  var cliente = data.cli_des.trim();
  var saldoTotal = data.saldo;
  var telefonos = data.telefonos;
  
  // 4. Limpiar mensaje anterior
  $('#msgTexto').val('');
  $('#msgNombreCliente').val(cliente);
  
  // 5. Limpieza de Teléfonos
  var listaNumeros = telefonos.split(/[\s,\-;\/\.]+/); 
  var arrayFinal = [];
  
  listaNumeros.forEach(function(num) {
      var temp = num.replace(/[\s\-\(\)]/g, '').trim();
      if (temp.length > 3 && /\d/.test(temp)) {
          if(temp.startsWith('0')){
              temp = '58' + temp.substring(1);
          }
          arrayFinal.push(temp);
      }
  });
  $('#msgNumero').val(arrayFinal.join(';'));

  // -----------------------------------------------------------
  // LÓGICA: Obtener estatus y generar mensaje según el filtro
  // -----------------------------------------------------------
  
  var estatus = $('#estatus').val(); // Obtener el valor del estatus del input hidden
  var facturas = JSON.parse(data.facturas_detalle || "[]");
  var maxDias = 0;

  if (facturas.length > 0) {
      facturas.forEach(function(factura) {
          var dias = parseInt(factura.dato3 || 0);
          if (dias > maxDias) {
              maxDias = dias;
          }
      });
  }

  // Generar mensaje según el estatus
  var mensajeGenerado = "GRUPO SOLSUMED OCCIDENTE ";


  //GRUPO SOLSUMED OCCIDENTE: No pierda su DESCUENTO. Posee un saldo por vencer de $978,22. Pague hoy y disfrute su beneficio de pronto pago. Ahorre y evite recargos.
  
  switch(estatus) {
      case '2': // Facturas por vencer en 2 días
          mensajeGenerado += "No pierda su DESCUENTO. Posee un saldo por vencer de " + saldoTotal +" USD. Pague hoy y disfrute su beneficio de pronto pago. Ahorre y evite recargos. ";
          break;
      case '3': // Facturas vencidas entre 1 y 3 días
          mensajeGenerado +=  "Posee un saldo vencido de " + saldoTotal + " USD. Su pago oportuno protege su record crediticio y proximos despachos.";
          break;
      case '4': // Facturas vencidas entre 4 y 10 días
          mensajeGenerado +=  "Posee un saldo vencido de " + saldoTotal + " USD. Su pago oportuno protege su record crediticio y proximos despachos.";
          break;
      case '5': // Facturas vencidas entre 11 o más días
          mensajeGenerado +=  "Posee un saldo vencido de " + saldoTotal + " USD. Su pago oportuno protege su record crediticio y proximos despachos.";
          break;
      case '6': // Facturas que vencen hoy
      mensajeGenerado += "No pierda su DESCUENTO. Posee un saldo por vencer de " + saldoTotal +" USD. Pague hoy y disfrute su beneficio de pronto pago. Ahorre y evite recargos. ";
          break;
      default: // Caso general (estatus 0 o 1)
        /*  if (maxDias > 0) {
              mensajeGenerado += "Presenta facturas vencidas. ";
          } else {
              mensajeGenerado += "Le recordamos la importancia de mantener sus pagos al día. ";
          }*/
  }
 

  $('#msgTexto').val(mensajeGenerado);
  // -----------------------------------------------------------

  // 6. Abrir modal
  var myModal = new bootstrap.Modal(document.getElementById('modalEnviarMensaje'));
  myModal.show();
}

// Función para enviar WhatsApp
function enviarWhatsApp() {
  var telefono = $('#msgNumero').val().trim();
  var mensaje = $('#msgTexto').val().trim();

  if (!telefono) {
      alert("Por favor ingrese un número telefónico");
      return;
  }

  // Codificar mensaje para URL
  var url = "https://wa.me/" + telefono + "?text=" + encodeURIComponent(mensaje);
  
  // Abrir en nueva pestaña
  window.open(url, '_blank');
}

// Función para enviar SMS (Depende de la plataforma, normalmente abre el cliente de correo o app nativa)
// Nota: En web no se puede enviar un SMS directamente sin un backend (Twilio, etc).
// Esta función abre el enlace 'sms:' del navegador.
function enviarSMS() {
  
  var telefono = $('#msgNumero').val().trim();
  var mensaje = $('#msgTexto').val().trim();

        
            // --- Configuración de Caracteres Prohibidos (Regex) ---
            // Basado en la documentación: ' ¡ ¿ \ º | { } [ ] ` ^ Ü € ? $ # á é í ó ú ñ
            // Añadimos las vocales mayúsculas acentuadas por seguridad
            const regexProhibidos = /['¡¿\\º|{}\[\]`^Ü€?$#áéíóúüÁÉÍÓÚÜñÑ]/g;

            // --- Función para limpiar texto ---
            function limpiarTexto(texto) {
                return texto.replace(regexProhibidos, '');
            }

            // --- Evento: Escribir Mensaje (Validación y Limpieza) ---
            $('#msgTexto').on('input', function() {
                let valor = $(this).val();
                let limpio = limpiarTexto(valor);
                let longitud = limpio.length;

                // Si hubo cambio (se eliminó un carácter prohibido)
                if (valor !== limpio) {
                    $(this).val(limpio);
                    // Mostrar advertencia visual
                    $('#prohibited-warning').addClass('show');
                    setTimeout(() => { $('#prohibited-warning').removeClass('show'); }, 2000);
                }

                // Actualizar contador
                $('#charCounter').text(longitud + ' / 160');
                
                // Cambiar color si pasa el límite (visual feedback, aunque maxlength lo limita)
                if (longitud >= 150) {
                    $('#charCounter').addClass('danger');
                } else {
                    $('#charCounter').removeClass('danger');
                }
            });

        
}

// MODULO PARA REPORTE DE LLAMADA
// Variable global para almacenar datos temporales
let datosClienteActual = null;

// Función para abrir el modal de reporte de llamada
function abrirModalReporteLlamada(rowIndex) {
    var table = $('.datatables-basic-cuentas').DataTable();
    var data = table.row(rowIndex).data();
    
    if (!data) {
        console.error("No se encontraron datos");
        return;
    }
    
    // Guardar datos para uso posterior
    datosClienteActual = data;
    
    // Llenar datos básicos del cliente
    $('#llamadaCliDes').val(data.cli_des || '');
    $('#llamadaResponsable').val(data.responsable || '');
    
    // Limpiar y llenar select de números telefónicos
    var selectNumeros = $('#llamadaNumeroContactado');
    selectNumeros.empty();
    selectNumeros.append('<option value="">Seleccione el número marcado</option>');
    
    if (data.telefonos) {
        // Dividir por posibles separadores
        var telefonos = data.telefonos.split(/[\s,\-;\/\.]+/);
        telefonos.forEach(function(tel) {
            var telLimpio = tel.replace(/[\s\-\(\)]/g, '').trim();
            if (telLimpio.length > 3 && /\d/.test(telLimpio)) {
                selectNumeros.append('<option value="' + telLimpio + '">' + telLimpio + '</option>');
            }
        });
    }
    
    // =========================================================
    // OBTENER LA FACTURA CON MÁS DÍAS DE RETRASO
    // =========================================================
    var facturaInfo = '';
    var maxDias = 0;
    var facturaMax = null;
    
    if (data.facturas_detalle) {
        try {
            var facturas = JSON.parse(data.facturas_detalle || "[]");
            
            if (facturas.length > 0) {
                facturas.forEach(function(factura) {
                    var dias = parseInt(factura.dato3 || 0);
                    if (dias > maxDias) {
                        maxDias = dias;
                        facturaMax = factura;
                    }
                });
                
                if (facturaMax) {
                    facturaInfo = facturaMax.nro_doc + ' - ' + maxDias + ' días';
                }
            }
        } catch (e) {
            console.error("Error al parsear facturas:", e);
        }
    }
    
    // Si no hay facturas o hubo error, mostrar mensaje
    if (!facturaInfo) {
        facturaInfo = 'No hay facturas vencidas';
    }
    
    // Mostrar la información de la factura (necesitas agregar un elemento en el modal)
    // Si no tienes un elemento, puedes agregarlo al modal. Por ejemplo:
    if ($('#facturaInfo').length === 0) {
        // Si no existe, agregarlo dinámicamente
        $('#formReporteLlamada').prepend(
            '<div class="alert alert-info mb-1" id="facturaInfo">' +
            '<strong>Factura con mayor retraso:</strong> ' + facturaInfo +
            '</div>'
        );
    } else {
        $('#facturaInfo').html('<strong>Factura con mayor retraso:</strong> ' + facturaInfo);
    }
    
    // =========================================================
    
    // Resetear campos del formulario
    $('#formReporteLlamada')[0].reset();
    
    // Restaurar valores del cliente
    $('#llamadaCliDes').val(data.cli_des || '');
    $('#llamadaResponsable').val(data.responsable || '');
    
    // Ocultar campo de compromiso inicialmente
    $('#compromisoDiv').hide();
    
    // Inicializar Flatpickr si existe
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#llamadaCompromisoFecha', {
            dateFormat: 'Y-m-d',
            minDate: 'today',
            allowInput: true
        });
        
        flatpickr('#llamadaSeguimientoFecha', {
            dateFormat: 'Y-m-d',
            minDate: 'today',
            allowInput: true
        });
    }
    
    // Ocultar campo de seguimiento inicialmente
    $('#seguimientoFechaDiv').hide();
    
    // Evento para mostrar/ocultar campo de compromiso según estado de llamada
    $('#llamadaEstado').off('change').on('change', function() {
        var estadoSeleccionado = $(this).val();
        
        if (estadoSeleccionado === 'PROMETE_PAGO') {
            $('#compromisoDiv').slideDown();
            // Opcional: Enfocar el campo de monto
            $('#llamadaCompromisoMonto').focus();
        } else {
            $('#compromisoDiv').slideUp();
            // Limpiar campos de compromiso si se oculta
            $('#llamadaCompromisoMonto').val('');
            $('#llamadaCompromisoFecha').val('');
        }
    });
    
    // Evento para mostrar/ocultar campo de seguimiento
    $('#llamadaRequiereSeguimiento').off('change').on('change', function() {
        if ($(this).is(':checked')) {
            $('#seguimientoFechaDiv').slideDown();
            // Si no hay fecha seleccionada, sugerir 3 días después
            if (!$('#llamadaSeguimientoFecha').val()) {
                var fecha = new Date();
                fecha.setDate(fecha.getDate() + 3);
                var fechaStr = fecha.toISOString().split('T')[0];
                $('#llamadaSeguimientoFecha').val(fechaStr);
            }
        } else {
            $('#seguimientoFechaDiv').slideUp();
        }
    });
    
    // Contador de caracteres para observaciones
    $('#llamadaObservaciones').off('input').on('input', function() {
        var len = $(this).val().length;
        $('#obsCounter').text(len + '/500');
        if (len >= 450) {
            $('#obsCounter').addClass('text-danger');
        } else {
            $('#obsCounter').removeClass('text-danger');
        }
        
        // Limitar a 500 caracteres
        if (len > 500) {
            $(this).val($(this).val().substring(0, 500));
            $('#obsCounter').text('500/500');
        }
    });
    
    // Abrir modal
    var myModal = new bootstrap.Modal(document.getElementById('modalReporteLlamada'));
    myModal.show();
    
    // Actualizar iconos feather
    feather.replace();
}
// También modificar la función guardarReporteLlamada para validar compromiso cuando sea necesario
function guardarReporteLlamada() {
    // Validar campos requeridos
    if (!$('#llamadaCliDes').val()) {
        alert('Error: No hay información del cliente');
        return;
    }
    
    if (!$('#llamadaNumeroContactado').val()) {
        alert('Por favor seleccione el número contactado');
        return;
    }
    
    var estadoLlamada = $('#llamadaEstado').val();
    
    // Validar que si seleccionó PROMETE_PAGO, debe ingresar monto y fecha
    if (estadoLlamada === 'PROMETE_PAGO') {
        if (!$('#llamadaCompromisoMonto').val()) {
            alert('Por favor ingrese el monto comprometido');
            $('#llamadaCompromisoMonto').focus();
            return;
        }
        if (!$('#llamadaCompromisoFecha').val()) {
            alert('Por favor seleccione la fecha de compromiso');
            $('#llamadaCompromisoFecha').focus();
            return;
        }
    }
    
    // Obtener la factura con mayor retraso
    var facturaMayorRetraso = '';
    if (datosClienteActual && datosClienteActual.facturas_detalle) {
        try {
            var facturas = JSON.parse(datosClienteActual.facturas_detalle || "[]");
            var maxDias = 0;
            var facturaMax = null;
            
            facturas.forEach(function(factura) {
                var dias = parseInt(factura.dato3 || 0);
                if (dias > maxDias) {
                    maxDias = dias;
                    facturaMax = factura;
                }
            });
            
            if (facturaMax) {
                facturaMayorRetraso = facturaMax.nro_doc;
                maximoDias = maxDias; // Guardar el máximo para usarlo en el mensaje o lógica adicional

            }
        } catch (e) {
            console.error("Error al parsear facturas:", e);
        }
    }

      console.log('Factura con mayor retraso:', facturaMayorRetraso);
    
    // Recopilar datos del formulario
    var datosLlamada = {
        co_cli: datosClienteActual ? datosClienteActual.co_cli : '',
        cli_des: $('#llamadaCliDes').val(),
        responsable: $('#llamadaResponsable').val(),
        fecha_hora_llamada: new Date().toISOString().slice(0,19).replace('T',' '),
        fecha_posible_respuesta: $('#llamadaCompromisoFecha').val() || null,
        fecha_seguimiento: $('#llamadaSeguimientoFecha').val() || null,
        tipo_requerimiento: $('#llamadaTipo').val(),
        estado_llamada: estadoLlamada,
        numero_contactado: $('#llamadaNumeroContactado').val(),
        requiere_seguimiento: $('#llamadaRequiereSeguimiento').is(':checked') ? 1 : 0,
        monto_comprometido: $('#llamadaCompromisoMonto').val() || null,
        observaciones: $('#llamadaObservaciones').val(),
        dato_extra1: facturaMayorRetraso, // Guardar factura con mayor retraso
        dato_extra2: maximoDias,
        dato_extra3: '',
        estatus: 1,
        co_ven: datosClienteActual ? datosClienteActual.co_ven : ''
    };
    
    console.log('Enviando datos:', datosLlamada);
    
    // Enviar al servidor
    $.ajax({
           url: '../admin/index.php?action=llamadas&accion=create',
        type: 'POST',
        data: datosLlamada,
        dataType: 'json',
        beforeSend: function() {
            $('.btn-primary').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Guardando...');
        },
        success: function(response) {
            if (response.success) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalReporteLlamada'));
                modal.hide();
                
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.message || 'Llamada registrada correctamente');
                } else {
                    alert('✅ ' + (response.message || 'Llamada registrada correctamente'));
                }
                
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Error: ' + response.message);
                } else {
                    alert('❌ Error: ' + response.message);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log('Respuesta:', xhr.responseText);
            
            let errorMsg = 'Error de conexión';
            try {
                let resp = JSON.parse(xhr.responseText);
                errorMsg = resp.message || errorMsg;
            } catch(e) {}
            
            if (typeof toastr !== 'undefined') {
                toastr.error(errorMsg);
            } else {
                alert('❌ ' + errorMsg);
            }
        },
        complete: function() {
            $('.btn-primary').prop('disabled', false).html('<i data-feather="save"></i> Guardar Reporte');
            feather.replace();
        }
    });
}


// Función auxiliar para obtener usuario actual
function obtenerUsuarioActual() {
    // Intenta obtener de varias fuentes
    var usuario = $('#usuario_actual').val() || 
                  (typeof usuarioSistema !== 'undefined' ? usuarioSistema : null) ||
                  localStorage.getItem('usuario') ||
                  'SISTEMA';
    return usuario;
}

$(window,document,$).ready(function(){
'use strict';


$('#btnSendSMS').on('click', function(e) {
    e.preventDefault();

    // Obtener valores
    const telefonos = $('#msgNumero').val().trim();
    const texto = $('#msgTexto').val().trim();
    const $btn = $('#btnSendSMS');
    
    // Validación simple
    if (!telefonos || !texto) {
        Swal.fire('Error', 'Por favor complete todos los campos.', 'error');
        return;
    }

    // Estado de carga del botón
    $btn.prop('disabled', true);
    $btn.find('.btn-text').text('Enviando...');
    $btn.find('.spinner-border').removeClass('d-none');

    // --- PETICIÓN AJAX AL BACKEND ---
    $.ajax({
        url: '../admin/index.php?action=sms',
        type: 'POST',
        dataType: 'json',
        data: {
            telefonos: telefonos,
            texto: texto
        },
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    html: `<strong>${response.mensaje}</strong><br><small>Los mensajes están siendo procesados.</small>`,
                });

                // --- NUEVO: CERRAR MODAL ---
                var modalEl = document.getElementById('modalEnviarMensaje');
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                // -----------------------------

                // Nota: La restauración del botón se maneja en el bloque 'complete' abajo,
                // por lo que no es necesario duplicarla aquí, pero la he dejado tal cual la tenías.
            } else {
                // Mostrar errores devueltos por el backend
                let errorMsg = response.mensaje || 'Ocurrió un error desconocido.';
                if (response.alertas) {
                    errorMsg += `<br><small>${response.alertas.join('<br>')}</small>`;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el Envío',
                    html: errorMsg
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire('Error Crítico', 'No se pudo conectar con el servidor. Revise la consola para más detalles.', 'error');
        },
        complete: function() {
            // Restaurar botón siempre (éxito o error)
            $btn.prop('disabled', false);
            $btn.find('.btn-text').text('Enviar SMS');
            $btn.find('.spinner-border').addClass('d-none');
        }
    });
});


$('#btnSendSMSMasivo').on('click', function(e) {
    e.preventDefault();

    const $btn = $('#btnSendSMSMasivo');
    
  

    // Estado de carga del botón
    $btn.prop('disabled', true);
    $btn.find('.btn-text').text('Enviando...');
    $btn.find('.spinner-border').removeClass('d-none');

    // --- PETICIÓN AJAX AL BACKEND ---
    $.ajax({
        url: '../admin/index.php?action=sms2',
        type: 'POST',
        dataType: 'json',
        data: {
            telefonos: 1,
            texto: 1
        },
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    html: `<strong>${response.mensaje}</strong><br><small>Los mensajes están siendo procesados.</small>`,
                });

                // --- NUEVO: CERRAR MODAL ---
                var modalEl = document.getElementById('modalEnviarMensaje');
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                // -----------------------------

                // Nota: La restauración del botón se maneja en el bloque 'complete' abajo,
                // por lo que no es necesario duplicarla aquí, pero la he dejado tal cual la tenías.
            } else {
                // Mostrar errores devueltos por el backend
                let errorMsg = response.mensaje || 'Ocurrió un error desconocido.';
                if (response.alertas) {
                    errorMsg += `<br><small>${response.alertas.join('<br>')}</small>`;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el Envío',
                    html: errorMsg
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire('Error Crítico', 'No se pudo conectar con el servidor. Revise la consola para más detalles.', 'error');
        },
        complete: function() {
            // Restaurar botón siempre (éxito o error)
            $btn.prop('disabled', false);
            $btn.find('.btn-text').text('Enviar SMS');
            $btn.find('.spinner-border').addClass('d-none');
        }
    });
});



// Manejador del botón de aplicar filtro
$('.btnFiltroComparacion').on('click', function(e) {
  e.preventDefault();
  
  // Obtener valores del formulario
  const productoId = $('#co_art_comparacion').val();
  const proveedoresIds = $('#co_prov_comparacion').val();
  let proveedoresIdsStr = '';
  // Validar selección
  if (!productoId) {
      Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Debe seleccionar un producto'
      });
      return;
  }

// Comprobamos si el arreglo tiene elementos
if (proveedoresIds.length > 0) {
  console.log("tiene elementos");
    // Si tiene elementos, los unimos en una cadena separada por comas
   proveedoresIdsStr = proveedoresIds.join(',');
} else {
  console.log("esta vacio");
    // Si está vacío, asignamos el valor por defecto
    proveedoresIdsStr = 'NO';
}
  
  
  // Petición AJAX
  $.ajax({
     url: '../admin/index.php?action=articulos&tipo=1&accion=3&c=ArticuloData&a=59&t=art&filtro='+productoId+'&filtro2='+proveedoresIdsStr, 
      method: 'GET',     
      success: function(response) {
          cargarTablaPreciosComparacion(response);
          $('#modalComparar').modal('hide');
      },
      error: function(xhr, status, error) {
          console.error('Error en la petición:', error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error al procesar la solicitud'
          });
      }
  });
});

$('body').on('click', '#btnAddPrecio', function() {
    (async () => { 
        // Obtener valores de los campos del modal
        let co_art = $('#select-articulo-modal').val();
        let co_prov = $('#select-proveedor-modal').val();
        let codigo_proveedor = $('#input-codigo-proveedor').val();
        let prec_vta1 = $('#input-precio1').val();
        let prec_vta2 = $('#input-precio2').val();
        let prec_vta3 = $('#input-precio3').val();
        let prec_vta4 = $('#input-precio4').val();

        // Validar campos obligatorios - SOLO artículo, proveedor y prec_vta1
        let errors = [];
        if (!co_art) errors.push('<b>Artículo</b>');
        if (!co_prov) errors.push('<b>Proveedor</b>');
      

        // Validar que los precios no sean negativos (pueden ser 0 o vacíos)
        if (prec_vta1 && parseFloat(prec_vta1) < 0) errors.push('<b>Precio 1</b> (no puede ser negativo)');
        if (prec_vta2 && parseFloat(prec_vta2) < 0) errors.push('<b>Precio 2</b> (no puede ser negativo)');
        if (prec_vta3 && parseFloat(prec_vta3) < 0) errors.push('<b>Precio 3</b> (no puede ser negativo)');
        if (prec_vta4 && parseFloat(prec_vta4) < 0) errors.push('<b>Precio 4</b> (no puede ser negativo)');

        // Mostrar errores si hay campos vacíos o valores negativos
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validación fallida',
                html: 'Se encontraron los siguientes errores:<br><br>- ' + errors.join('<br>- '),
                confirmButtonColor: '#0343a5',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // Validar que los precios sean números válidos (si tienen valor)
        let preciosInvalidos = [];
        if (prec_vta1 && prec_vta1 !== '' && isNaN(parseFloat(prec_vta1))) preciosInvalidos.push('Precio 1');
        if (prec_vta2 && prec_vta2 !== '' && isNaN(parseFloat(prec_vta2))) preciosInvalidos.push('Precio 2');
        if (prec_vta3 && prec_vta3 !== '' && isNaN(parseFloat(prec_vta3))) preciosInvalidos.push('Precio 3');
        if (prec_vta4 && prec_vta4 !== '' && isNaN(parseFloat(prec_vta4))) preciosInvalidos.push('Precio 4');

        if (preciosInvalidos.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Precios inválidos',
                html: 'Los siguientes precios contienen valores no numéricos:<br><br>- ' + preciosInvalidos.join('<br>- '),
                confirmButtonColor: '#0343a5',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // Procesar los precios: si están vacíos, convertirlos a 0
        prec_vta1 = prec_vta1 === '' ? '0' : prec_vta1;
        prec_vta2 = prec_vta2 === '' ? '0' : prec_vta2;
        prec_vta3 = prec_vta3 === '' ? '0' : prec_vta3;
        prec_vta4 = prec_vta4 === '' ? '0' : prec_vta4;

        // Confirmación antes de guardar
        const confirmacion = await Swal.fire({
            title: '¿Confirmar registro?',
            html: `¿Está seguro de que desea agregar los precios para este artículo?<br><br>
                    <strong>Artículo:</strong> ${$('#select-articulo-modal option:selected').text()}<br>
                    <strong>Código ref:</strong> ${codigo_proveedor || 'No especificado'}<br>
                    <strong>Proveedor:</strong> ${$('#select-proveedor-modal option:selected').text()}<br>
                    <strong>Precio 1:</strong> $${parseFloat(prec_vta1).toFixed(2)}<br>
                    <strong>Precio 2:</strong> $${parseFloat(prec_vta2).toFixed(2)}<br>
                    <strong>Precio 3:</strong> $${parseFloat(prec_vta3).toFixed(2)}<br>
                    <strong>Precio 4:</strong> $${parseFloat(prec_vta4).toFixed(2)}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0343a5',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        });

        if (!confirmacion.isConfirmed) {
            return false;
        }

        // Crear objeto con los datos del formulario
        let formData = {
            co_art: co_art,
            co_prov: co_prov,
            codigo_proveedor: codigo_proveedor || '',
            prec_vta1: parseFloat(prec_vta1),
            prec_vta2: parseFloat(prec_vta2),
            prec_vta3: parseFloat(prec_vta3),
            prec_vta4: parseFloat(prec_vta4),
            fecha_registro: new Date().toISOString().split('T')[0] // Fecha actual en formato YYYY-MM-DD
        };

        // Enviar datos por AJAX
        $.ajax({
            url: '../admin/index.php?action=articulos&tipo=1&accion=5&datos=1',
            type: 'POST',          
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                // Mostrar loader o mensaje de carga
                $('#btnAddPrecio').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Precios guardados correctamente',
                        confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        // Limpiar formulario y cerrar modal

                        resetearFormularioModal();
                      
                        $('#modalAddPrecios').modal('hide');
                        
                        // Recargar la tabla de precios
                       cargarDataPreciosComparacion('NO','NO');
                    });                    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Ocurrió un error al guardar los precios',
                        confirmButtonColor: '#0343a5',
                        confirmButtonText: 'Entendido'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Ocurrió un error en la comunicación con el servidor: ' + error,
                    confirmButtonColor: '#0343a5',
                    confirmButtonText: 'Entendido'
                });
            },
            complete: function() {
                $('#btnAddPrecio').prop('disabled', false).html('<i data-feather="plus" class="me-1"></i> Agregar Artículo');
                // Re-inicializar iconos Feather si es necesario
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }
        });
    })();
});
  

if ($('.co_art').length) {


    $('#select-articulo-modal').select2({
        // Habilítalo para que funcione con modales de Bootstrap
        dropdownParent: $('#modalAddPrecios'), // <-- ¡IMPORTANTE! Reemplaza '#id-de-tu-modal' con el ID real de tu modal
      // theme: 'bootstrap-5', 
         width: '100%', // Asegura que ocupe todo el ancho del contenedor

        // --- CONFIGURACIÓN DE MENSAJES ---
        language: {
            inputTooShort: function() {
                // Mensaje cuando el usuario no ha escrito los caracteres mínimos
                return "Por favor, ingresa 2 o más caracteres para buscar";
            },
            searching: function() {
                // Mensaje mientras se realiza la búsqueda AJAX
                return "Buscando...";
            },
            noResults: function() {
                // Mensaje cuando no hay resultados
                return "No se encontraron artículos";
            },
            errorLoading: function() {
                // Mensaje si hay un error en la llamada AJAX
                return "No se pudieron cargar los datos";
            }
        },

        // --- CONFIGURACIÓN DE BÚSQUEDA ---
        placeholder: 'Buscar artículo...',
        allowClear: true,
        minimumInputLength: 2, // Debe coincidir con el mensaje de 'inputTooShort'
        ajax: {
            url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=1&t=art&datos=1', // Tu URL de la API
            dataType: 'json',
            delay: 250, // Esperar 250ms después de escribir para hacer la petición
            data: function (params) {
                // `params.term` es el texto que el usuario ha escrito
                return {
                    search: params.term, // Enviamos el término de búsqueda al servidor
                    // page: params.page // Descomenta si necesitas paginación
                };
            },
            processResults: function (data) {
                // `data` es el JSON que devuelve tu servidor.
                // Select2 espera un formato específico: { results: [ {id: ..., text: ...} ] }
                var resultados = $.map(data, function (item) {
                    return {
                        id: item.co_art,
                        text: item.art_des + ' ( ' + item.des_col + ' )'
                    };
                });

                return {
                    results: resultados
                };
            },
            cache: true
        }
    });

  //cargarComboArticulos('.co_art');
}

if ($('.i_articulo_ficha').length) {
  $('#select-articulo-ficha').select2({
      // Tu configuración existente...
      width: '100%',
      language: {
          inputTooShort: function() {
              return "Por favor, ingresa 2 o más caracteres para buscar";
          },
          searching: function() {
              return "Buscando...";
          },
          noResults: function() {
              return "No se encontraron artículos";
          },
          errorLoading: function() {
              return "No se pudieron cargar los datos";
          }
      },
      placeholder: 'Buscar artículo...',
      allowClear: true,
      minimumInputLength: 2,
      ajax: {
          url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=11&t=art&datos=1',
          dataType: 'json',
          delay: 250,
          data: function(params) {
              return {
                  search: params.term
              };
          },
          processResults: function(data) {
              var resultados = $.map(data, function(item) {
                  return {
                      id: item.co_art,
                      text: item.art_des + ' ( ' + item.des_col + ' )'
                  };
              });
              return {
                  results: resultados
              };
          },
          cache: true
      }
  });

  // 2. AGREGAMOS EL EVENTO DE SELECCIÓN AL SELECT2
  $('#select-articulo-ficha').on('select2:select', function(e) {
      const codigoSeleccionado = e.params.data.id; // Obtenemos el co_art del artículo seleccionado
      
      // Actualizamos la lista de códigos para que solo contenga el artículo seleccionado
      listaCodigos = [codigoSeleccionado];
      indiceCodigoActual = 0;
      esBusquedaActiva = true;
      terminoBusquedaActual = '';
      
      // Cargamos los datos del artículo seleccionado
      cargarArticulo(codigoSeleccionado);
  });

  // 3. Evento para limpiar la búsqueda (si se deselecciona)
  $('#select-articulo-ficha').on('select2:unselect', function(e) {
      restablecerListaCompleta();
  });
}

if ($('.co_prov').length) {

     $('#select-proveedor-modal').select2({
        // Habilítalo para que funcione con modales de Bootstrap
        dropdownParent: $('#modalAddPrecios'), // <-- ¡IMPORTANTE! Reemplaza '#id-de-tu-modal' con el ID real de tu modal
      // theme: 'bootstrap-5', 
         width: '100%', // Asegura que ocupe todo el ancho del contenedor

        // --- CONFIGURACIÓN DE MENSAJES ---
        language: {
            inputTooShort: function() {
                // Mensaje cuando el usuario no ha escrito los caracteres mínimos
                return "Por favor, ingresa 2 o más caracteres para buscar";
            },
            searching: function() {
                // Mensaje mientras se realiza la búsqueda AJAX
                return "Buscando...";
            },
            noResults: function() {
                // Mensaje cuando no hay resultados
                return "No se encontraron proveedores";
            },
            errorLoading: function() {
                // Mensaje si hay un error en la llamada AJAX
                return "No se pudieron cargar los datos";
            }
        },

        // --- CONFIGURACIÓN DE BÚSQUEDA ---
        placeholder: 'Buscar proveedor...',
        allowClear: true,
        minimumInputLength: 2, // Debe coincidir con el mensaje de 'inputTooShort'
        ajax: {
               url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=4&t=art&datos=2', 
            dataType: 'json',
            delay: 250, // Esperar 250ms después de escribir para hacer la petición
            data: function (params) {
                // `params.term` es el texto que el usuario ha escrito
                return {
                    search: params.term, // Enviamos el término de búsqueda al servidor
                    // page: params.page // Descomenta si necesitas paginación
                };
            },
            processResults: function (data) {
                // `data` es el JSON que devuelve tu servidor.
                // Select2 espera un formato específico: { results: [ {id: ..., text: ...} ] }
                var resultados = $.map(data, function (item) {
                    return {
                        id: item.co_prov,
                        text: item.prov_des + ' ( ' + item.co_prov + ' )'


                        

                    };
                });

                return {
                    results: resultados
                };
            },
            cache: true
        }
    });

 // cargarComboProveedores('.co_prov');
}


if ($('.co_art').length) {
    $('#select-articulo-modal').select2({
        // Habilítalo para que funcione con modales de Bootstrap
        dropdownParent: $('#modalAddPrecios'), // <-- ¡IMPORTANTE! Reemplaza '#id-de-tu-modal' con el ID real de tu modal
      // theme: 'bootstrap-5', 
         width: '100%', // Asegura que ocupe todo el ancho del contenedor

        // --- CONFIGURACIÓN DE MENSAJES ---
        language: {
            inputTooShort: function() {
                // Mensaje cuando el usuario no ha escrito los caracteres mínimos
                return "Por favor, ingresa 2 o más caracteres para buscar";
            },
            searching: function() {
                // Mensaje mientras se realiza la búsqueda AJAX
                return "Buscando...";
            },
            noResults: function() {
                // Mensaje cuando no hay resultados
                return "No se encontraron artículos";
            },
            errorLoading: function() {
                // Mensaje si hay un error en la llamada AJAX
                return "No se pudieron cargar los datos";
            }
        },

        // --- CONFIGURACIÓN DE BÚSQUEDA ---
        placeholder: 'Buscar artículo...',
        allowClear: true,
        minimumInputLength: 2, // Debe coincidir con el mensaje de 'inputTooShort'
        ajax: {
            url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=1&t=art&datos=1', // Tu URL de la API
            dataType: 'json',
            delay: 250, // Esperar 250ms después de escribir para hacer la petición
            data: function (params) {
                // `params.term` es el texto que el usuario ha escrito
                return {
                    search: params.term, // Enviamos el término de búsqueda al servidor
                    // page: params.page // Descomenta si necesitas paginación
                };
            },
            processResults: function (data) {
                // `data` es el JSON que devuelve tu servidor.
                // Select2 espera un formato específico: { results: [ {id: ..., text: ...} ] }
                var resultados = $.map(data, function (item) {
                    return {
                        id: item.co_art,
                        text: item.art_des + ' ( ' + item.des_col + ' )'
                    };
                });

                return {
                    results: resultados
                };
            },
            cache: true
        }
    });
      //cargarComboArticulos('.co_art');
}


if ($('.co_prov_comparacion').length) {

     $('#co_prov_comparacion').select2({
        // Habilítalo para que funcione con modales de Bootstrap
        dropdownParent: $('#modalComparar'), // <-- ¡IMPORTANTE! Reemplaza '#id-de-tu-modal' con el ID real de tu modal
      // theme: 'bootstrap-5', 
         width: '100%', // Asegura que ocupe todo el ancho del contenedor

        // --- CONFIGURACIÓN DE MENSAJES ---
        language: {
            inputTooShort: function() {
                // Mensaje cuando el usuario no ha escrito los caracteres mínimos
                return "Por favor, ingresa 2 o más caracteres para buscar";
            },
            searching: function() {
                // Mensaje mientras se realiza la búsqueda AJAX
                return "Buscando...";
            },
            noResults: function() {
                // Mensaje cuando no hay resultados
                return "No se encontraron proveedores";
            },
            errorLoading: function() {
                // Mensaje si hay un error en la llamada AJAX
                return "No se pudieron cargar los datos";
            }
        },

        // --- CONFIGURACIÓN DE BÚSQUEDA ---
        placeholder: 'Buscar proveedor...',
        allowClear: true,
        minimumInputLength: 2, // Debe coincidir con el mensaje de 'inputTooShort'
        ajax: {
               url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=4&t=art&datos=2', 
            dataType: 'json',
            delay: 250, // Esperar 250ms después de escribir para hacer la petición
            data: function (params) {
                // `params.term` es el texto que el usuario ha escrito
                return {
                    search: params.term, // Enviamos el término de búsqueda al servidor
                    // page: params.page // Descomenta si necesitas paginación
                };
            },
            processResults: function (data) {
                // `data` es el JSON que devuelve tu servidor.
                // Select2 espera un formato específico: { results: [ {id: ..., text: ...} ] }
                var resultados = $.map(data, function (item) {
                    return {
                        id: item.co_prov,
                        text: item.prov_des + ' ( ' + item.co_prov + ' )'


                        

                    };
                });

                return {
                    results: resultados
                };
            },
            cache: true
        }
    });

 // cargarComboProveedores('.co_prov');
}

/// Cargar los combos de la aplicacion
if ($('.co_prov_comparacion').length) {
cargarComboFacturas('.co_prov_comparacion');

}

if ($('.co_art_comparacion').length) {
    $('#co_art_comparacion').select2({
        // Habilítalo para que funcione con modales de Bootstrap
        dropdownParent: $('#modalComparar'), // <-- ¡IMPORTANTE! Reemplaza '#id-de-tu-modal' con el ID real de tu modal
      // theme: 'bootstrap-5', 
         width: '100%', // Asegura que ocupe todo el ancho del contenedor

        // --- CONFIGURACIÓN DE MENSAJES ---
        language: {
            inputTooShort: function() {
                // Mensaje cuando el usuario no ha escrito los caracteres mínimos
                return "Por favor, ingresa 2 o más caracteres para buscar";
            },
            searching: function() {
                // Mensaje mientras se realiza la búsqueda AJAX
                return "Buscando...";
            },
            noResults: function() {
                // Mensaje cuando no hay resultados
                return "No se encontraron artículos";
            },
            errorLoading: function() {
                // Mensaje si hay un error en la llamada AJAX
                return "No se pudieron cargar los datos";
            }
        },

        // --- CONFIGURACIÓN DE BÚSQUEDA ---
        placeholder: 'Buscar artículo...',
        allowClear: true,
        minimumInputLength: 2, // Debe coincidir con el mensaje de 'inputTooShort'
        ajax: {
            url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=1&t=art&datos=1', // Tu URL de la API
            dataType: 'json',
            delay: 250, // Esperar 250ms después de escribir para hacer la petición
            data: function (params) {
                // `params.term` es el texto que el usuario ha escrito
                return {
                    search: params.term, // Enviamos el término de búsqueda al servidor
                    // page: params.page // Descomenta si necesitas paginación
                };
            },
            processResults: function (data) {
                // `data` es el JSON que devuelve tu servidor.
                // Select2 espera un formato específico: { results: [ {id: ..., text: ...} ] }
                var resultados = $.map(data, function (item) {
                    return {
                        id: item.co_art,
                        text: item.art_des + ' ( ' + item.des_col + ' )'
                    };
                });

                return {
                    results: resultados
                };
            },
            cache: true
        }
    });
      //cargarComboArticulos('.co_art');
}



if ($('.content-body').length) {  
//Top de los productos mas vendidos
//cargarDataEmpresaDetalles();
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



// Metodos q cargan las tablas diferentes tablas
cargarDataUsers();
cargarDataPreciosComparacion('NO','NO');
cargarDataClientes();
cargarDataVendedores();
cargarDataPedidos(0,'NO','NO');
// se esta usando 
cargarDataVentasxDia('NO','NO','NO','NO');

cargarDataCobrosMes('NO','NO','NO','NO');
cargarDataArticuloFoco('NO','NO','NO','NO');

cargarDataArticuloVolumen('NO','NO','NO','NO');
/* fin se esta usando  */
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
  cargarGraficoTopMes('NO','NO','NO','NO');
}

if ($('.topMesUnidades').length) {
  console.log('topMesUnidadess');
  cargarGraficoTopMesUnidades('NO');
}

if ($('.topMesUnidadesMenos').length) {
  console.log('topMesUnidadesMenos');
  cargarGraficoTopMesUnidadesMenos('NO','NO','NO','NO');
}



if ($('.topMayorUtilidad').length) {
  console.log('topMayorUtilidad');
  cargarGraficoTopMayorUtil('NO','NO','NO','NO');
}
if ($('.topMenorUtilidad').length) {
  console.log('topMenorUtilidad');
  cargarGraficoTopMenorUtil('NO','NO','NO','NO');
}

if ($('.tablaTopMasClientes').length) {
  //console.log('tablaTopMasClientes');
  cargarTablaTopMasMenosClientes('NO','NO','NO','NO','1');
}
if ($('.tablaTopMasClientes').length) {
  //console.log('tablaTopMenosClientes');
  cargarTablaTopMasMenosClientes('NO','NO','NO','NO','0');
}

if ($('.tablaTopMasPagos').length) {
  //console.log('tablaTopMasClientes');
  cargarTablaTopMasMenosPagos('NO','NO','NO','NO','1');
}
if ($('.tablaTopMenosPagos').length) {
  //console.log('tablaTopMenosClientes');
  cargarTablaTopMasMenosPagos('NO','NO','NO','NO','0');
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


$('.cargarDataVentasPorDia').on('click', function (e) {
var $co_zona =$('.comboZona').val();
var $finicio = $('.finicio').val();
var $ffinal = $('.ffinal').val();
var $co_ven = $('.comboVendedores').val();
if(($('.finicio').val().length == 0) || ($('.ffinal').val().length == 0)){ 
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Debes elegir siempre Fecha de Inicio y Final!'
  
  })
}else{
  console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
  cargarDataVentasxDia($co_ven,$co_zona,$finicio,$ffinal);

  $('#modals-slide-in').modal('hide')
}   
});

$('.cargarDataCobrosMes').on('click', function (e) {
  var $co_zona =$('.comboZona').val();
  var $finicio = $('.finicio').val();
  var $ffinal = $('.ffinal').val();
  var $co_ven = $('.comboVendedores').val();
  if(($('.finicio').val().length == 0) || ($('.ffinal').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   // console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarDataCobrosMes($co_ven,$co_zona,$finicio,$ffinal);
  
    $('#modals-slide-in').modal('hide')
  }   
  });

  $('.cargarDataArticuloFoco').on('click', function (e) {
    var $co_zona =$('.comboZonaMasVendidos').val();
    var $finicio = $('.finicioMasVendidos').val();
    var $ffinal = $('.ffinalMasVendidos').val();
    var $co_ven = $('.comboVendedoresMasVendidos').val();
    if(($('.finicioMasVendidos').val().length == 0) || ($('.ffinalMasVendidos').val().length == 0)){ 
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Debes elegir siempre Fecha de Inicio y Final!'
      
      })
    }else{
     //console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
      cargarDataArticuloFoco($co_ven,$co_zona,$finicio,$ffinal);
    
      $('#filtroArticulosFoco').modal('hide')
    }   
    });


    $('.cargarDataArticuloVolumen').on('click', function (e) {
      var $co_zona =$('.comboZonaArticuloVolumen').val();
      var $finicio = $('.finicioArticuloVolumen').val();
      var $ffinal = $('.ffinalArticuloVolumen').val();
      var $co_ven = $('.comboVendedoresArticuloVolumen').val();
      if(($('.finicioArticuloVolumen').val().length == 0) || ($('.ffinalArticuloVolumen').val().length == 0)){ 
          Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Debes elegir siempre Fecha de Inicio y Final!'
        
        })
      }else{
  
        cargarDataArticuloVolumen($co_ven,$co_zona,$finicio,$ffinal);
      
        $('#filtroArticulosVolumen').modal('hide')
      }   
      });


$('.cargarDataMasVendidos').on('click', function (e) {
  var $co_zona =$('.comboZonaMasVendidos').val();
  var $finicio = $('.finicioMasVendidos').val();
  var $ffinal = $('.ffinalMasVendidos').val();
  var $co_ven = $('.comboVendedoresMasVendidos').val();
  if(($('.finicioMasVendidos').val().length == 0) || ($('.ffinalMasVendidos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarGraficoTopMes($co_ven,$co_zona,$finicio,$ffinal);
  
    $('#filtroMasVendidos').modal('hide')
  }
});

$('.cargarDataMenosVendidos').on('click', function (e) {
  var $co_zona =$('.comboZonaMenosVendidos').val();
  var $finicio = $('.finicioMenosVendidos').val();
  var $ffinal = $('.ffinalMenosVendidos').val();
  var $co_ven = $('.comboVendedoresMenosVendidos').val();
  if(($('.finicioMenosVendidos').val().length == 0) || ($('.ffinalMenosVendidos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarGraficoTopMesUnidadesMenos($co_ven,$co_zona,$finicio,$ffinal);
  
    $('#filtroMenosVendidos').modal('hide')
  }
});



$('.cargarDataMayorUtilidad').on('click', function (e) {
  var $co_zona =$('.comboZonaMayorUtilidad').val();
  var $finicio = $('.finicioMayorUtilidad').val();
  var $ffinal = $('.ffinalMayorUtilidad').val();
  var $co_ven = $('.comboVendedoresMayorUtilidad').val();
  if(($('.finicioMayorUtilidad').val().length == 0) || ($('.ffinalMayorUtilidad').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarGraficoTopMayorUtil($co_ven,$co_zona,$finicio,$ffinal);
  
    $('#filtroMayorUtilidad').modal('hide')
  }
});

$('.cargarDataMenorUtilidad').on('click', function (e) {
  var $co_zona =$('.comboZonaMenorUtilidad').val();
  var $finicio = $('.finicioMenorUtilidad').val();
  var $ffinal = $('.ffinalMenorUtilidad').val();
  var $co_ven = $('.comboVendedoresMenorUtilidad').val();
  if(($('.finicioMenorUtilidad').val().length == 0) || ($('.ffinalMenorUtilidad').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarGraficoTopMenorUtil($co_ven,$co_zona,$finicio,$ffinal);
  
    $('#filtroMenorUtilidad').modal('hide')
  }
});



$('.cargarDataClientesAltos').on('click', function (e) {
  var $co_zona =$('.comboZonaClientesAltos').val();
  var $finicio = $('.finicioClientesAltos').val();
  var $ffinal = $('.ffinalClientesAltos').val();
  var $co_ven = $('.comboVendedoresClientesAltos').val();
  if(($('.finicioClientesAltos').val().length == 0) || ($('.ffinalClientesAltos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   // console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarTablaTopMasMenosClientes($co_ven,$co_zona,$finicio,$ffinal,'1');
  
    $('#filtroClientesAltos').modal('hide')
  }
});


$('.cargarDataClientesBajos').on('click', function (e) {
  var $co_zona =$('.comboZonaClientesBajos').val();
  var $finicio = $('.finicioClientesBajos').val();
  var $ffinal = $('.ffinalClientesBajos').val();
  var $co_ven = $('.comboVendedoresClientesBajos').val();
  if(($('.finicioClientesBajos').val().length == 0) || ($('.ffinalClientesBajos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    //console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarTablaTopMasMenosClientes($co_ven,$co_zona,$finicio,$ffinal,'0');
  
    $('#filtroClientesBajos').modal('hide')
  }
});


$('.cargarDataPagosAltos').on('click', function (e) {
  var $co_zona =$('.comboZonaClientesAltos').val();
  var $finicio = $('.finicioClientesAltos').val();
  var $ffinal = $('.ffinalClientesAltos').val();
  var $co_ven = $('.comboVendedoresClientesAltos').val();
  if(($('.finicioClientesAltos').val().length == 0) || ($('.ffinalClientesAltos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
   // console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarTablaTopMasMenosPagos($co_ven,$co_zona,$finicio,$ffinal,'1');
  
    $('#filtroClientesAltos').modal('hide')
  }
});


$('.cargarDataPagosBajos').on('click', function (e) {
  var $co_zona =$('.comboZonaClientesBajos').val();
  var $finicio = $('.finicioClientesBajos').val();
  var $ffinal = $('.ffinalClientesBajos').val();
  var $co_ven = $('.comboVendedoresClientesBajos').val();
  if(($('.finicioClientesBajos').val().length == 0) || ($('.ffinalClientesBajos').val().length == 0)){ 
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })
  }else{
    //console.log($co_ven + ' - ' +$co_zona +' - '+$finicio+' - '+$ffinal);
    cargarTablaTopMasMenosPagos($co_ven,$co_zona,$finicio,$ffinal,'0');
  
    $('#filtroClientesBajos').modal('hide')
  }
});


$('.cargarDataClientesFacturados').on('click', function (e) { 
  var $co_zona =$('.comboZonaClientesFacturados').val();
  var $co_ven = $('.comboVendedoresClientesFacturados').val();
  var $finicio = $('.finicioClientesFacturados').val();
  var $ffinal = $('.ffinalClientesFacturados').val();
  if(($('.finicioClientesFacturados').val().length == 0) || ($('.ffinalClientesFacturados').val().length == 0)){ 

    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debes elegir siempre Fecha de Inicio y Final!'
    
    })

  }else{

    cargarDataNoFacturados($co_ven,$co_zona,$finicio,$ffinal);
    graficoFacturaciones($co_ven,$co_zona,$finicio,$ffinal);
    
      $('#filtroClientesFacturados').modal('hide')
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


$('.filtrarTopVendidosUnidades').on('change', function () {

  var filtrarTopVendidos = $('.filtrarTopVendidosUnidades').val();

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

    cargarGraficoTopMesUnidades(filtrarTopVendidos);
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
let $filtro = $('.estatus').val().trim();
cuentasPorCobrar('NO','NO',$filtro);
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

if($('.comboVendedores').length) {
cargarCombo('.comboVendedores');
}

if($('.comboZona').length) {
  cargarComboZona('.comboZona');
}

if($('.comboZonaClientesFacturados').length) {
  cargarComboZona('.comboZonaClientesFacturados');
}

if($('.comboVendedoresMasVendidos').length) {
  cargarCombo('.comboVendedoresMasVendidos');
  }
  if($('.comboVendedoresArticuloVolumen').length) {
    cargarCombo('.comboVendedoresArticuloVolumen');
    }
if($('.comboVendedoresMenosVendidos').length) {
    cargarCombo('.comboVendedoresMenosVendidos');
}
if($('.comboVendedoresMayorUtilidad').length) {
  cargarCombo('.comboVendedoresMayorUtilidad');
}
if($('.comboVendedoresMenorUtilidad').length) {
  cargarCombo('.comboVendedoresMenorUtilidad');
}

if($('.comboVendedoresClientesAltos').length) {
  cargarCombo('.comboVendedoresClientesAltos');
}
if($('.comboVendedoresClientesBajos').length) {
  cargarCombo('.comboVendedoresClientesBajos');
}

if($('.comboVendedoresClientesFacturados').length) {
  cargarCombo('.comboVendedoresClientesFacturados');
}


/// todos los combos de zonas
if($('.comboZonaMasVendidos').length) {
  cargarComboZona('.comboZonaMasVendidos');
}

if($('.comboZonaArticuloVolumen').length) {
  cargarComboZona('.comboZonaArticuloVolumen');
}

if($('.comboZonaMenosVendidos').length) {
  cargarComboZona('.comboZonaMenosVendidos');
}
/// zona mayor y menor utilidad
if($('.comboZonaMayorUtilidad').length) {
  cargarComboZona('.comboZonaMayorUtilidad');
}
if($('.comboZonaMenorUtilidad').length) {
  cargarComboZona('.comboZonaMenorUtilidad');
}
/// zona mayor y menor utilidad
// zona clientes altos y bajos
if($('.comboZonaClientesAltos').length) {
  cargarComboZona('.comboZonaClientesAltos');
}
if($('.comboZonaClientesBajos').length) {
  cargarComboZona('.comboZonaClientesBajos');
}
// zona clientes altos y bajos

if ($('.comboVendedoresFactura').length) {
  cargarCombo('.comboVendedoresFactura');
  }

if ($('.comboAlmacen').length) {
cargarComboAlma('.comboAlmacen');

}

if ($('.comboCategorias').length) {
  cargarComboCategorias('.comboCategorias');
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



if ($('.detallesFactura').length) {
//cargarDataFactura();

}

if ($('.carritoItems').length) {
cargarDataCarrito();

}


if ($('.dataEmpresa').length) {
cargarDataEmpresa();

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

function cargarDataCuentasPorCobrar($filtro,$co_ven){

if ($('#dataCuentasPorCobrar').length) {
  var $estado = $('#estatus').val();
 // console.log(estado);
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=facturacion&c=FacturaData&tipo=1&accion=8&t=factura&co_ven='+$co_ven+'&filtro='+$filtro+'&estado='+$estado, 
}).done(function(usuarios) { 
var cadena = JSON.stringify(usuarios);
$('.dataCuentasPorCobrar').attr("value",cadena);
cargarTablaCuentasPorCobrar();
});
}
}

function cargarDataAnalisisVCTO($co_ven){
  if ($('#dataAnalisisVCTO').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=57&t=factura&co_ven='+$co_ven, 
  }).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataAnalisisVCTO').attr("value",cadena);
  cargarTablaAnalisisVCTO();
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

function cargarDataVentasxDia($co_ven,$co_zona,$finicio,$ffinal){
  if ($('#dataVentasxDia').length) {  
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=61&t=pedidos&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
  }).done(function(ventasxdia) { 
  var cadena = JSON.stringify(ventasxdia);
  $('.dataVentasxDia').attr("value",cadena);
  cargarTablaVentasxDia();

  var i = 1;
  var totalPeso =0.00;
  var totalMonto =0.00;

var tope =ventasxdia.length;
for (var i = 1; i < tope; i++) {
  totalPeso = totalPeso + ventasxdia[i].dato1;
  totalMonto = totalMonto + ventasxdia[i].tot_neto;
}

  $('.totalMonto').html('Total Monto : '+parseFloat(totalMonto).toFixed(2));
  $('.totalPeso').html(' Total de Kilos : '+parseFloat(totalPeso).toFixed(2));
  
  });
  }
  }

  function cargarDataCobrosMes($co_ven,$co_zona,$finicio,$ffinal){
    if ($('#dataCobrosMes').length) {  
    $.ajax({
      type: "GET",
      url: '../admin/index.php?action=combos&c=FacturaData&a=71&t=pedidos&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
    }).done(function(cobrosMes) { 
    var cadena = JSON.stringify(cobrosMes);
    $('.dataCobrosMes').attr("value",cadena);
    cargarTablaCobrosMes();
    
    });
    }
    }

    
  function cargarDataArticuloFoco($co_ven,$co_zona,$finicio,$ffinal){
    if ($('#dataArticulosFoco').length) {  
    $.ajax({
      type: "GET",
      url: '../admin/index.php?action=combos&c=FacturaData&a=73&t=pedidos&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
    }).done(function(articulosFoco) { 
    var cadena = JSON.stringify(articulosFoco);
    $('.dataArticulosFoco').attr("value",cadena);

    cargarTablaArticuloFoco();

    var i = 1;
    var totalFoco =0.00;

  var tope =articulosFoco.length;
  for (var i = 1; i < tope; i++) {
    totalFoco = totalFoco + articulosFoco[i].porc_alc;
  }

    $('.totalFoco').html(parseFloat(totalFoco/i).toFixed(2));
    });
    }
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
      var i = 1;
      var totalVolumen =0.00;
  
    var tope =articulosVolumen.length;
    for (var i = 1; i < tope; i++) {
      totalVolumen = totalVolumen + articulosVolumen[i].porc_alc;
    }
  
      $('.totalVolumen').html(parseFloat(totalVolumen/i).toFixed(2));
      
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

function cargarComboCategorias(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=ArticuloData&a=98&t=art', 
}).done(function(dataCategorias) { 
  var i = 0;
  var tope =dataCategorias.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+dataCategorias[i].dato2+'>'+dataCategorias[i].dato3+'</option>');
  
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
function cargarGraficoTopMesUnidadesMenos($co_ven,$co_zona,$finicio,$ffinal){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=62&t=factura&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
    //url: '../admin/index.php?action=combos&c=FacturaData&a=62&t=factura&filtro='+$filtro, 
  }).done(function(topVendidos) { 
    if (topVendidos.length === 0){
      $('.chartdiv_Top_Menos_unidades').empty();
    $('.topMesUnidadesMenos').html('<h4>No hay movimientos registrados en este rango o mès</h4>');
    $('.tablaTopMenosVendidos').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMesUnidadesMenos').empty();
  
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
  });  
  
  
}
function cargarGraficoTopMayorUtil($co_ven,$co_zona,$finicio,$ffinal){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=63&estado=1&t=factura&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
   
  }).done(function(topMayorUtil) { 
    if (topMayorUtil.length === 0){
      $('.chartdiv_Top_Mayor_Util').empty();
    $('.topMayorUtilidad').html('<h4>No hay movimientos registrados en este rango o mès</h4>');
    $('.tablaTopMayorUtil').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMayorUtilidad').empty();
   $('.tablaTopMayorUtil').empty();
    const valor0= topMayorUtil[0].dato2;
    const valor1= topMayorUtil[1].dato2;
    const valor2= topMayorUtil[2].dato2;
    const varlor3= topMayorUtil[3].dato2;
    const valor4= topMayorUtil[4].dato2;
  

    
  
    const articulo0= topMayorUtil[0].dato1;
    const articulo1= topMayorUtil[1].dato1;
    const articulo2= topMayorUtil[2].dato1;
    const articulo3= topMayorUtil[3].dato1;
    const articulo4= topMayorUtil[4].dato1;


      
    const utilidad0= topMayorUtil[0].dato3;
    const  utilidad1= topMayorUtil[1].dato3;
    const  utilidad2= topMayorUtil[2].dato3;
    const  utilidad3= topMayorUtil[3].dato3;
    const  utilidad4= topMayorUtil[4].dato3;

  
   
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
  });  
  
  

}


function cargarGraficoTopMenorUtil($co_ven,$co_zona,$finicio,$ffinal){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=63&estado=0&t=factura&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
  }).done(function(topMenosUtilidad) { 
    if (topMenosUtilidad.length === 0){
      $('.chartdiv_Top_Menor_Util').empty();
    $('.topMenorUtilidad').html('<h4>No hay movimientos registrados en este rango o mès</h4>');
    $('.tablaTopMenorUtil').empty();
    }else{ 
   // console.log(topVendidos);
   $('.topMenorUtilidad').empty();
  
    const valor0= topMenosUtilidad[0].dato2;
    const valor1= topMenosUtilidad[1].dato2;
    const valor2= topMenosUtilidad[2].dato2;
    const varlor3= topMenosUtilidad[3].dato2;
    const valor4= topMenosUtilidad[4].dato2;
  

    
  
    const articulo0= topMenosUtilidad[0].dato1;
    const articulo1= topMenosUtilidad[1].dato1;
    const articulo2= topMenosUtilidad[2].dato1;
    const articulo3= topMenosUtilidad[3].dato1;
    const articulo4= topMenosUtilidad[4].dato1;
  
 

      
    const utilidad0= topMenosUtilidad[0].dato3;
    const  utilidad1= topMenosUtilidad[1].dato3;
    const  utilidad2= topMenosUtilidad[2].dato3;
    const  utilidad3= topMenosUtilidad[3].dato3;
    const  utilidad4= topMenosUtilidad[4].dato3;
  

  
   
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
  });  
  
  
}

function cargarGraficoTopMesUnidades($filtro){
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=56&t=factura&filtro='+$filtro, 
  }).done(function(topVendidos) { 
    if (topVendidos.length === 0){
      $('.chartdiv_top_unidades').empty();
    $('.topMesUnidades').html('<h4>No hay movimientos registrados en este rango o mès</h4>');
    
    }else{ 
   // console.log(topVendidos);
   $('.topMesUnidades').empty();
  
    const valor0= topVendidos[0].dato2;
    const valor1= topVendidos[1].dato2;
    const valor2= topVendidos[2].dato2;
    const varlor3= topVendidos[3].dato2;
    const valor4= topVendidos[4].dato2;
  
    const valor5= topVendidos[5].dato2;
    const valor6= topVendidos[6].dato2;
    
  
    const articulo0= topVendidos[0].dato1;
    const articulo1= topVendidos[1].dato1;
    const articulo2= topVendidos[2].dato1;
    const articulo3= topVendidos[3].dato1;
    const articulo4= topVendidos[4].dato1;
  
    const articulo5= topVendidos[5].dato1;
    const articulo6= topVendidos[6].dato1;
   
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
  ,
  {
  'articulo' : articulo5,
  'valor' :valor5
  }
  ,
  {
  'articulo' : articulo6,
  'valor' :valor6
  }

  ];
  
  graficoTopMesUnidades(topVendidosPastel);
    }
  });  
  
  
}

function cargarTablaTopMasMenosClientes($co_ven,$co_zona,$finicio,$ffinal,$estado){
  
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=64&t=factura&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal+'&estado='+$estado, 

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
function cargarTablaTopMasMenosPagos($co_ven,$co_zona,$finicio,$ffinal,$estado){
  
 
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=72&t=factura&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal+'&estado='+$estado, 

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
       <div class="fw-bolder text-success">${util}</div>
      </div>`;      
      $('.tablaTopMenosPagos').append(contenido);   
        }
      
       }    
    }
  });  
  
  
}

function cargarGraficoTopMes($co_ven,$co_zona,$finicio,$ffinal){
 
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&c=FacturaData&a=43&t=factura&co_ven='+$co_ven+'&co_zona='+$co_zona+'&finicio='+$finicio+'&ffinal='+$ffinal, 
  //url: '../admin/index.php?action=combos&c=FacturaData&a=43&t=factura&filtro='+$filtro, 
}).done(function(topVendidos) { 

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

});
}else{ 
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
    url: '../admin/index.php?action=combos&c=FacturaData&a=99&t=factura', 
}).done(function(meses) { 

 if (meses.length === 0){Swal.fire({
  icon: 'info',
  title: 'Oops...',
  text: 'Lo sentimos, no existen facturaciones en este rango de fechas!'

});}else{ 
   /* const ene= meses[0].ene;
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
*/
console.log(meses);

const mesesData =meses.slice(0,12);
const mesesData2 =meses.slice(13,25);
console.log(mesesData);
console.log(mesesData2);
   // const mesesData = ['2022',meses[0].ene, meses[0].feb, meses[0].mar,meses[0].abr,meses[0].may,meses[0].jun,meses[0].jul,meses[0].ago,meses[0].sep,meses[0].oct,meses[0].nov,meses[0].dic];
    //const mesesData2 = ['2023',meses[0].ene, meses[0].feb, meses[0].mar,meses[0].abr,meses[0].may,meses[0].jun,meses[0].jul,meses[0].ago,meses[0].sep,meses[0].oct,meses[0].nov,meses[0].dic];

  graficoReporteXA(mesesData,mesesData2,'graficoXA');

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

function cuentasPorCobrar($filtro,$co_ven,$estatus){ 
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&a=49&c=FacturaData&t=factura&filtro='+$filtro+'&co_ven='+$co_ven+'&estatus='+$estatus, 
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

function facturas($co_cli){
//console.log($co_cli);

$('#filaFactura').empty();   
$.ajax({
  type: "GET",
  url: '../admin/index.php?action=combos&a=55&c=FacturaData&t=factura&co_cli='+$co_cli+'&filtro=0', 
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

function graficoFacturaciones($co_ven,$co_zona,$fechaI,$fechaF){

  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=77&t=facturas&co_ven='+$co_ven+'&fechaI='+$fechaI+'&fechaF='+$fechaF+'&co_zona='+$co_zona, 
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

function cargarDataNoFacturados($co_ven,$co_zona,$fechaI,$fechaF){
  if ($('#dataNoFacturados').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=combos&c=FacturaData&a=78&t=factura&co_ven='+$co_ven+'&fechaI='+$fechaI+'&fechaF='+$fechaF+'&co_zona='+$co_zona, 
}).done(function(usuarios) { 
  var cadena = JSON.stringify(usuarios);
  $('.dataNoFacturados').attr("value",cadena);
  $('.noFacturadosTable').prop('style', 'display:yes');
  cargarTablaClientesNoFacturados();


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


function cargarDataPreciosComparacion($filtro,$filtro2){
  if ($('#dataArticulos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=articulos&tipo=1&accion=3&c=ArticuloData&a=59&t=art&filtro='+$filtro+'&filtro2='+$filtro2, 
}).done(function(data) { 
  var cadena = JSON.stringify(data);
  $('.dataArticulos').attr("value",cadena);
  cargarTablaPreciosComparacion(data);


});
  }
}




function cargarComboArticulos(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=1&t=art&datos=1', 
}).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+data[i].co_art+'>'+data[i].art_des+'( ' +data[i].des_col+ ' )</option>');
  
  }  
});
}
}


function cargarComboProveedores(combo){
  if ($(combo).length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=articulos&c=ArticuloData&tipo=1&accion=4&t=art&datos=2', 
}).done(function(data) { 
  var i = 0;
  var tope =data.length;
  for (var i = 0; i < tope; i++) {

    $(combo).prepend('<option value = '+data[i].co_prov+'>'+data[i].prov_des+'</option>');
  
  }  
});
}
}


// Función para resetear el modal
function resetearFormularioModal() {
    // Resetear el formulario
    $('#form-agregar-articulo')[0].reset();
    
    // Resetear selects si es necesario
    $('#select-articulo-modal').val('').trigger('change');
    $('#select-proveedor-modal').val('').trigger('change');
    
    // Limpiar validaciones visuales
    $('.is-invalid').removeClass('is-invalid');
    $('.error-message').remove();
}

