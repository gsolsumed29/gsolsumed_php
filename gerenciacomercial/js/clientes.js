
function cargarTablaClientesVisitados(data) {

  var dt_basic_table_clientes_visitas = $('.dataTablesVisitasClientes');

  if (dt_basic_table_clientes_visitas.length) {

    // Mover la lógica de filtros si es necesario, pero parece estar bien.
    $('input.dt-input').on('keyup', function () {
      filterColumn($(this).attr('data-column'), $(this).val());
    });



    // --- MEJORA 1: Crear un Modal para Exportación en Móvil ---
    // Añadir este HTML a tu página (idealmente al final del body)
    if ($('#exportModal').length === 0) {
        $('body').append(`
            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalLabel">Exportar Reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <button class="btn btn-outline-primary mb-2 export-btn" data-export="print">
                                ${feather.icons['printer'].toSvg({ class: 'me-50' })} Imprimir
                            </button>
                            <button class="btn btn-outline-success mb-2 export-btn" data-export="excel">
                                ${feather.icons['file'].toSvg({ class: 'me-50' })} Excel
                            </button>
                            <button class="btn btn-outline-danger mb-2 export-btn" data-export="pdf">
                                ${feather.icons['clipboard'].toSvg({ class: 'me-50' })} PDF
                            </button>
                            <button class="btn btn-outline-secondary export-btn" data-export="copy">
                                ${feather.icons['copy'].toSvg({ class: 'me-50' })} Copiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }

    var dt_adv_filter = dt_basic_table_clientes_visitas.DataTable({
      scrollY: 'calc(100vh - 320px)', // Ajustado para dar más espacio
      scrollX: true,
      scrollCollapse: true,
      fixedHeader: {
        header: true,
        footer: false
      },
      data: data,
      columns: [
        { data: 'responsive_id' }, // 0
        { data: 'dato3' },        // 1
        { data: 'cli_des' },      // 2
        { data: 'rif' },          // 3
        { data: 'telefonos' },    // 4
        { data: 'email' },        // 5
        { data: 'dato6' },        // 6
        { data: 'dato4' },        // 7
        { data: 'dato5' },        // 8
        { data: 'direc1' },       // 9
        { data: 'dato1' }
      ],
      columnDefs: [
        {
          className: 'control',
          orderable: false,
          targets: 0,
          responsivePriority: 2 // Control de responsive tiene alta prioridad
        },
        { 
          data: null, // Nueva columna para el numerador
          className: 'text-center',
          width: '40px',
          orderable: false,
          searchable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return meta.row + 1; // Numerador de fila
          }
        },
        // --- MEJORA 2: Ajustar Prioridad de Columnas ---
        // El nombre del cliente es lo más importante
        {
          // --- NUEVA DEFINICIÓN PARA EL NOMBRE ---
          targets: 2, // Columna 'cli_des'
          responsivePriority: 1,
         
          render: function (data, type, full, meta) {
              // Envuelve el nombre en un span con una clase para poder seleccionarlo
              // y un estilo que indica que es interactivo.
              return `<span class="candidate-name-link text-primary fw-bold" style="cursor: pointer;">${data}</span>`;
          }
      },
        // El RIF es importante, pero menos que el nombre
       
        {
          targets: 5,
          visible: false
        },
        {
          targets: 4,
          visible: false
        },
        {
          targets: 9,
          visible: false
        },
        {
          targets: 3,
          visible: false
        },
        {
          targets: 7,
          visible: false
        },
        {
          targets: 8,
          visible: false
        }
      ],
      // --- MEJORA 4: DOM más flexible y contenedor para botones ---
      // Usamos una estructura de filas/columnas de Bootstrap
      // '<"row"<"col-12 mb-2" <"head-label">> <"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
      dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle d-none d-md-inline-flex', // Ocultar en móvil
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + ' Exportar',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + ' Imprimir',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:last-child)' }, // Exportar todo menos la última columna (Acciones)
              title: 'Reporte de Candidatos - ' + new Date().toLocaleDateString()
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + ' Excel',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:last-child)' },
              title: 'Reporte de Candidatos',
              filename: 'reporte_candidatos_' + new Date().toISOString().slice(0, 10)
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + ' PDF',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:last-child)' },
              orientation: 'landscape',
              pageSize: 'A4',
              title: 'Reporte de Candidatos - ' + new Date().toLocaleDateString(),
              filename: 'reporte_candidatos_' + new Date().toISOString().slice(0, 10),
              customize: function (doc) {
                doc.defaultStyle.fontSize = 8;
                doc.styles.tableHeader.fontSize = 9;
                doc.content[0].text = 'Reporte de Candidatos - ' + new Date().toLocaleDateString();
                doc.content[0].alignment = 'center';
                doc.content[0].margin = [0, 0, 0, 10];
              }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + ' Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: ':not(:last-child)' },
              title: 'Reporte de Candidatos'
            }
          ]
        },
        {
          // Botón que se ve solo en móvil
          text: feather.icons['share-2'].toSvg({ class: 'font-medium-1 me-50' }) + 'Exportar',
          className: 'btn btn-primary d-md-none', // Solo visible en móvil
          action: function (e, dt, node, config) {
            // Al hacer clic, abre el modal que creamos
            var exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
            exportModal.show();
          }
        }
      ],
      // --- MEJORA 6: Paginación más simple para móvil ---
      pagingType: 'simple_numbers', // Más limpio que 'full_numbers'
      orderCellsTop: true,
      displayLength: 10,
      lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ], // Simplificado
      language: {
        // ... (tu configuración de idioma está bien)
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
      // --- MEJORA 7: Estilizar el modal de detalles responsivos ---
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de: ' + data.cli_des;
            }
          }),
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              // No mostrar la columna de acciones ni la de control en el modal
              if (col.title === '' || col.title === 'Acciones') {
                return '';
              }
              return `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                        <td class="fw-bold">${col.title}:</td>
                        <td>${col.data}</td>
                      </tr>`;
            }).join('');
            
            // Usamos clases de tabla de Bootstrap para un mejor estilo
            return data ? $('<table class="table table-striped table-bordered"/>').append($('<tbody/>').append(data)) : false;
          }
        }
      }
    });

    // Mover los botones de DataTables a nuestro contenedor personalizado
    dt_adv_filter.buttons().container().appendTo('#export-container');

    // Poner el título
    $('div.head-label').html('<h5 class="mb-0">Datos de los candidatos</h5>');

    // --- Lógica para los botones del modal de exportación en móvil ---
    $('.export-btn').on('click', function() {
        var exportType = $(this).data('export');
        // Dispara el evento de clic del botón real de DataTables
        dt_adv_filter.button(0).add(0, exportType).trigger();
        // Cierra el modal
        bootstrap.Modal.getInstance(document.getElementById('exportModal')).hide();
    });


          // --- LÓGICA DE PULSACIÓN LARGA (LONG-PRESS) ---

      // Variable para controlar el temporizador
      let pressTimer;
      let isLongPress = false;

      // Función para mostrar y rellenar el modal
      function mostrarFichaCandidato(data) {
          // Rellenar los campos del modal con los datos del candidato
          $('#ficha-nombre-completo').text(data.cli_des || 'N/A');
          $('#ficha-rif').text(data.rif || 'N/A');
          $('#ficha-telefonos').text(data.telefonos || 'N/A');
          $('#ficha-email').text(data.email || 'N/A');
          $('#ficha-direccion').text(data.direc1 || 'N/A');
          $('#ficha-dato1').text(data.dato1 || 'N/A');
          $('#ficha-dato2').text(data.dato2 || 'N/A');
          $('#ficha-dato3').text(data.dato3 || 'N/A');
          $('#ficha-dato4').text(data.dato4 || 'N/A');
          $('#ficha-dato5').text(data.dato5 || 'N/A');

          // Configurar el botón de visitar con el enlace correcto
          const visitUrl = `index.php?view=cliente&co_cli=${data.co_cli}&cand_des=${encodeURIComponent(data.cli_des)}`;
          $('#ficha-boton-visitar').attr('href', visitUrl);

                // --- LÍNEA CLAVE AÑADIDA ---
          // Almacenar los datos completos en el modal para usarlos después
          $('#modalFichaCandidato').data('candidatoData', data);

          // Mostrar el modal
          const modalFicha = new bootstrap.Modal(document.getElementById('modalFichaCandidato'));
          modalFicha.show();
      }

      // Usamos delegación de eventos para que funcione en filas nuevas (paginación, etc.)
      dt_basic_table_clientes_visitas.on('mousedown touchstart', '.candidate-name-link', function(e) {
          // Prevenir el menú contextual en móvil
          e.preventDefault();
          
          const $link = $(this);
          isLongPress = false;

          // Iniciar el temporizador
          pressTimer = setTimeout(function() {
              isLongPress = true;
              // Obtener los datos de la fila usando la API de DataTables
              const rowData = dt_adv_filter.row($link.closest('tr')).data();
              if (rowData) {
                  mostrarFichaCandidato(rowData);
              }
          }, 500); // 500ms para la pulsación larga
      });

      // Al soltar el botón/touch
      dt_basic_table_clientes_visitas.on('mouseup touchend mouseleave', '.candidate-name-link', function(e) {
          // Limpiar el temporizador
          clearTimeout(pressTimer);
          
          // Si fue una pulsación larga, prevenimos el comportamiento del click normal
          if (isLongPress) {
              e.stopPropagation();
          }
      });

      // Opcional: Añadir feedback visual durante la pulsación larga
      dt_basic_table_clientes_visitas.on('touchstart', '.candidate-name-link', function() {
          $(this).addClass('active');
      });
      dt_basic_table_clientes_visitas.on('touchend mouseleave', '.candidate-name-link', function() {
          $(this).removeClass('active');
      });

      // --- LÓGICA PARA COMPARTIR POR WHATSAPP ---

  }
}



function cargarTable($filtro) {
  if ($('#dataClientesvisitas').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=cliente&tipo=1&accion=11&datos=2&c=ClienteData&a=1&t=clientes&filtro='+$filtro, 
}).done(function(datos) { 

  //console.log('Datos recibidos:', datos); // Depuración: Ver los datos recibidos
  cargarTablaClientesVisitados(datos);


});
  }
}



$(window,document,$).ready(function(){
  'use strict';


    cargarTable('NO');



});