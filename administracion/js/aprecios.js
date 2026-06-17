
function cargarTablaPreciosComparacion(data){
 // console.log(data);
  const dt_basic_table_articulos = $('.datatables-basic-articulos');   
  const groupColumn = 2; // Columna de descripción del artículo para agrupar

  if (!dt_basic_table_articulos.length) return;
  
  // Destruir instancia previa si existe
  if ($.fn.DataTable.isDataTable(dt_basic_table_articulos)) {
    dt_basic_table_articulos.DataTable().destroy();
  }
  


  // Transformar los datos para tener una fila por cada artículo-proveedor
  const datosTransformados = transformarDatosParaTabla(data);

  var dt_basic = dt_basic_table_articulos.DataTable({
  scrollY: 'calc(100vh - 300px)',
  scrollX: true,
  scrollCollapse: true,
  fixedHeader: {
    header: true,
    footer: false
  },
  data: datosTransformados,
  columns: [    
    { data: 'responsive_id' }, // 0
    { data: 'checkbox' },       // 1 - Nueva columna para checkbox
    { data: 'co_art' },         // 2   
    { data: 'art_des' },        // 3 - Columna para agrupar
    { data: 'co_art_prov' },    // 4    
    { data: 'proveedor_info' }, // 5 - Código y nombre del proveedor
    { data: 'credito_usd' },    // 6
    { data: 'contado_usd' },    // 7
    { data: 'credito_bs' },     // 8
    { data: 'contado_bs' }      // 9
  ],
  columnDefs: [
    {
      className: 'control', orderable: false, responsivePriority: 2, targets: 0
    },
    { 
      // Checkbox column
      targets: 1,
      title: '<input type="checkbox" id="select-all-checkbox" class="form-check-input">',
      orderable: false,
      searchable: false,
      width: '3%',
      className: 'text-center'
    },
    { visible: false, targets: 3 }, // Ocultar columna de agrupamiento
    { targets: 2, title: 'Código', width: '8%', visible: false },  
    { targets: 3, title: 'Descripción', width: '22%' }, 
    { targets: 4, title: 'Código Proveedor', width: '8%', visible: false },
    {
      targets: 5,
      title: 'Proveedor',
      width: '27%',
      render: function (data, type, full, meta) {
        return data; 
      }
    },
    { targets: 6, title: 'Crédito <span class="text-primary">USD</span>', width: '10%', className: 'text-center price-column', visible: false },
    { targets: 7, title: 'Contado <span class="text-primary">USD</span>', width: '10%', className: 'text-center price-column', visible: false },
    { targets: 8, title: 'Crédito <span class="text-success">Bs.D</span>', width: '10%', className: 'text-center price-column' },
    { targets: 9, title: 'Contado <span class="text-success">Bs.D</span>', width: '10%', className: 'text-center price-column' }
  ],
  order: [[3, 'asc']],
   dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    displayLength: 10,
    lengthMenu: [7, 10, 25, 50, 75, 100],
    // MEJORA: Botón de visibilidad de columnas
    buttons: [
        {
            text: feather.icons['edit'].toSvg({ class: 'font-small-4 me-50' }) + 'Actualizar Precios Seleccionados',
            className: 'btn btn-relief-warning ms-1',
            action: function (e, dt, node, config) {
              mostrarModalActualizarPrecios();
            },
            init: function (api, node, config) { 
              $(node).removeClass('btn-secondary'); 
            }
          },
          
          {
            text: feather.icons['check-square'].toSvg({ class: 'font-small-4 me-50' }) + 'Seleccionados (<span id="contador-seleccionados">0</span>)',
            className: 'btn btn-relief-info ms-1',
            action: function (e, dt, node, config) {
              mostrarSeleccionados();
            },
            init: function (api, node, config) { 
              $(node).removeClass('btn-secondary'); 
            }
          },
 
     {
    // INICIO: Botón personalizado para visibilidad de columnas
    extend: 'collection',
    className: 'btn btn-relief-secondary dropdown-toggle',
    text: feather.icons['eye'].toSvg({ class: 'font-small-4 me-50' }) + '',
    buttons: [
      {
        text: 'Crédito USD',
        className: 'dropdown-item toggle-visibility-btn',
        action: function (e, dt, node, config) {
          e.stopPropagation(); // Previene que el menú se cierre
          const column = dt.column(5); // Índice de la columna "Crédito USD"
          column.visible(!column.visible());
          $(node).toggleClass('active'); // Marca como activo/inactivo
        }
      },
      {
        text: 'Contado USD',
        className: 'dropdown-item toggle-visibility-btn',
        action: function (e, dt, node, config) {
          e.stopPropagation();
          const column = dt.column(6); // Índice de la columna "Contado USD"
          column.visible(!column.visible());
          $(node).toggleClass('active');
        }
      },
      {
        text: 'Crédito Bs.D',
        className: 'dropdown-item toggle-visibility-btn',
        action: function (e, dt, node, config) {
          e.stopPropagation();
          const column = dt.column(7); // Índice de la columna "Crédito Bs.D"
          column.visible(!column.visible());
          $(node).toggleClass('active');
        }
      },
      {
        text: 'Contado Bs.D',
        className: 'dropdown-item toggle-visibility-btn',
        action: function (e, dt, node, config) {
          e.stopPropagation();
          const column = dt.column(8); // Índice de la columna "Contado Bs.D"
          column.visible(!column.visible());
          $(node).toggleClass('active');
        }
      }
    ],
    init: function (api, node, config) {
      $(node).removeClass('btn-secondary');
      $(node).parent().removeClass('btn-group');
      setTimeout(function () {
        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
      }, 50);
    }
    // FIN: Botón personalizado
  },
     {
      text: (feather?.icons['search']?.toSvg({ class: 'me-50 font-small-4' }) || '+') + 'Filtrar',
      className: 'btnComparar btn-relief-success',
      attr: { 'data-bs-toggle': 'modal', 'data-bs-target': '#modalComparar' },
      init: function (api, node, config) { $(node).removeClass('btn-secondary'); }
    } ,
    {
    // INICIO: Botón personalizado para visibilidad de columnas
    extend: 'collection',
    className: 'btn btn-relief-primary dropdown-toggle',
    text: feather.icons['save'].toSvg({ class: 'font-small-4 me-50' }) + 'Cargar Precios',
    buttons: [
       {
        // --- CAMBIO 1: Abrir Modal de Crédito USD ---
        text: 'Registro individual',
        className: 'dropdown-item',
        action: function (e, dt, node, config) {
          e.stopPropagation(); // Previene que el menú se cierre
          // Abre el modal con el ID correspondiente
          $('#modalAddPrecios').modal('show'); 
        }
      },
      {
        // --- CAMBIO 2: Abrir Modal de Contado USD ---
        text: 'Procesar lotes',
        className: 'dropdown-item',
        action: function (e, dt, node, config) {
          e.stopPropagation();
          // Abre el otro modal
          $('#modalAddPreciosLotes').modal('show');
        }
      },
    ],
    init: function (api, node, config) {
      $(node).removeClass('btn-secondary');
      $(node).parent().removeClass('btn-group');
      setTimeout(function () {
        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
      }, 50);
    }
    // FIN: Botón personalizado
  }
   
  ],
    // MEJORA: drawCallback mejorado para resaltar precios y hacer grupos clickeables
    drawCallback: function (settings) {
      var api = this.api(); 
      var rows = api.rows({ page: 'current' }).nodes(); 
      var last = null;

      // --- Lógica para resaltar el mejor precio ---
      var groups = {};
      api.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
        if (!groups[group]) groups[group] = [];
        groups[group].push(api.row(i));
      });

      for (const groupName in groups) {
        const groupRows = groups[groupName];
        let minValues = { credito_usd: Infinity, contado_usd: Infinity, credito_bs: Infinity, contado_bs: Infinity };
        
        // Encontrar los valores mínimos
        groupRows.forEach(row => {
          const data = row.data();
          minValues.credito_usd = Math.min(minValues.credito_usd, parseFloat(data.credito_usd) || Infinity);
          minValues.contado_usd = Math.min(minValues.contado_usd, parseFloat(data.contado_usd) || Infinity);
          minValues.credito_bs = Math.min(minValues.credito_bs, parseFloat(data.credito_bs) || Infinity);
          minValues.contado_bs = Math.min(minValues.contado_bs, parseFloat(data.contado_bs) || Infinity);
        });

        // Aplicar la clase 'best-price' a las celdas ganadoras
        groupRows.forEach(row => {
          const data = row.data();
          const node = row.node();
          const cells = $(node).find('td');
          if (parseFloat(data.credito_usd) === minValues.credito_usd) $(cells[5]).addClass('best-price');
          if (parseFloat(data.contado_usd) === minValues.contado_usd) $(cells[6]).addClass('best-price');
          if (parseFloat(data.credito_bs) === minValues.credito_bs) $(cells[7]).addClass('best-price');
          if (parseFloat(data.contado_bs) === minValues.contado_bs) $(cells[8]).addClass('best-price');
        });
      }

      // --- Lógica para crear filas de grupo clickeables ---
      api.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
        if (last !== group) { 
          const groupRow = `<tr class="group" data-group-name="${group}">
            <td colspan="9" class="fw-bold ps-4">
              <span class="group-icon"></span>${group}
            </td>
          </tr>`;
          $(rows).eq(i).before(groupRow);

          // Marcar las filas de datos con el nombre del grupo para poder colapsarlas
          $(rows).filter(function(index) {
            return api.row(index).data().art_des === group;
          }).attr('data-group-name', group);

          last = group; 
        }
      });
    },
    responsive: { 
      details: { 
        display: $.fn.dataTable.Responsive.display.modal({ header: function (row) { return 'Detalles del producto'; } }), 
        type: 'column', 
        renderer: function (api, rowIdx, columns) { 
          const data = columns.map(col => { 
            return col.title !== '' ? `<tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>` : ''; 
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
      "oPaginate": { "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior" } 
    },
    deferRender: true,
    // MEJORA: Añadir clase para el efecto hover y zebra striping
    // (El zebra striping suele venir por defecto con DataTables + Bootstrap)
    initComplete: function() {
        dt_basic_table_articulos.addClass('dataTables-hover');
         inicializarEventosSeleccion(); // ← Añadir esta línea
    }
  });

  // MEJORA: Event listener para colapsar/expandir grupos
  $('#dt_basic_table_articulos tbody').off('click', 'tr.group').on('click', 'tr.group', function () {
    const name = $(this).data('group-name');
    const rowsToToggle = dt_basic.rows().nodes().filter(function () {
        return $(this).data('group-name') === name;
    });
    
    $(this).toggleClass('collapsed');
    $(rowsToToggle).toggleClass('hidden');
  });
}


// Función para manejar la selección/deselección de todos los checkboxes
function manejarSeleccionTotal() {
  const selectAllCheckbox = $('#select-all-checkbox');
  const checkboxesIndividuales = $('.select-articulo');
  
  selectAllCheckbox.on('change', function() {
    const isChecked = $(this).prop('checked');
    checkboxesIndividuales.prop('checked', isChecked);
    actualizarContador();
  });
  
  checkboxesIndividuales.on('change', function() {
    const totalCheckboxes = checkboxesIndividuales.length;
    const checkedCheckboxes = $('.select-articulo:checked').length;
    
    if (checkedCheckboxes === totalCheckboxes) {
      selectAllCheckbox.prop('checked', true);
    } else if (checkedCheckboxes === 0) {
      selectAllCheckbox.prop('checked', false);
    } else {
      selectAllCheckbox.prop('indeterminate', true);
    }
    
    actualizarContador();
  });
}

// Función para actualizar el contador de seleccionados
function actualizarContador() {
  const contador = $('.select-articulo:checked').length;
  $('#contador-seleccionados').text(contador);
  
  // Habilitar/deshabilitar botones según selección
  const btnActualizar = $('.btn-relief-warning');
  if (contador > 0) {
    btnActualizar.prop('disabled', false);
  } else {
    btnActualizar.prop('disabled', true);
  }
}

// Función para mostrar el modal con artículos seleccionados
function mostrarSeleccionados() {
  const seleccionados = [];
  
  $('.select-articulo:checked').each(function() {
    seleccionados.push({
      id: $(this).attr('id'),
      co_art: $(this).data('co-art'),
      art_des: $(this).data('art-des'),
      co_prov: $(this).data('co-prov'),
      prov_des: $(this).data('prov-des'),
      co_art_prov: $(this).data('co-art-prov')
    });
  });
  
  if (seleccionados.length === 0) {
    Swal.fire({
      icon: 'warning',
      title: 'Sin selección',
      text: 'No hay artículos seleccionados.',
      confirmButtonColor: '#3085d6'
    });
    return;
  }
  
  // Puedes mostrar esta información en un modal o consola
  console.log('Artículos seleccionados:', seleccionados);
  
  Swal.fire({
    title: 'Artículos Seleccionados',
    html: `
      <div class="text-start">
        <p>Total seleccionados: <strong>${seleccionados.length}</strong></p>
        <ul class="list-group" style="max-height: 300px; overflow-y: auto;">
          ${seleccionados.map(item => `
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong>${item.co_art}</strong><br>
                <small>${item.art_des}</small><br>
                <small class="text-muted">Proveedor: ${item.prov_des}</small>
              </div>
              <span class="badge bg-primary rounded-pill">${item.co_art_prov}</span>
            </li>
          `).join('')}
        </ul>
      </div>
    `,
    showConfirmButton: true,
    confirmButtonText: 'Cerrar',
    confirmButtonColor: '#3085d6',
    width: '600px'
  });
}

// Función para mostrar el modal de actualización de precios
function mostrarModalActualizarPrecios() {
  const seleccionados = [];
  
  $('.select-articulo:checked').each(function() {
    seleccionados.push({
      id: $(this).attr('id'),
      co_art: $(this).data('co-art'),
      art_des: $(this).data('art-des'),
      co_prov: $(this).data('co-prov'),
      prov_des: $(this).data('prov-des'),
      co_art_prov: $(this).data('co-art-prov')
    });
  });
  
  if (seleccionados.length === 0) {
    Swal.fire({
      icon: 'warning',
      title: 'Sin selección',
      text: 'Seleccione al menos un artículo para actualizar.',
      confirmButtonColor: '#3085d6'
    });
    return;
  }
  
  // Construir el contenido del modal
  let contenidoHTML = `
    <div class="row g-3" id="articulos-precios-container">
  `;
  
  seleccionados.forEach((item, index) => {
    contenidoHTML += `
      <div class="col-12" data-art-id="${item.id}">
        <div class="card border">
          <div class="card-body p-3">
            <div class="row align-items-center">
              <div class="col-md-4">
                <h6 class="mb-1">${item.art_des}</h6>
                <p class="mb-0 text-muted small">
                  <strong>Código:</strong> ${item.co_art}<br>
                  <strong>Proveedor:</strong> ${item.prov_des}<br>
                  <strong>Código Proveedor:</strong> ${item.co_art_prov}
                </p>
              </div>
              <div class="col-md-8">
                <div class="row g-2">
                  <div class="col-sm-3">
                    <label class="form-label small mb-1">Crédito USD</label>
                    <input type="number" class="form-control form-control-sm precio-nuevo" 
                           data-tipo="credito_usd" 
                           placeholder="0.00" 
                           step="0.01" min="0">
                  </div>
                  <div class="col-sm-3">
                    <label class="form-label small mb-1">Contado USD</label>
                    <input type="number" class="form-control form-control-sm precio-nuevo" 
                           data-tipo="contado_usd" 
                           placeholder="0.00" 
                           step="0.01" min="0">
                  </div>
                  <div class="col-sm-3">
                    <label class="form-label small mb-1">Crédito Bs.D</label>
                    <input type="number" class="form-control form-control-sm precio-nuevo" 
                           data-tipo="credito_bs" 
                           placeholder="0.00" 
                           step="0.01" min="0">
                  </div>
                  <div class="col-sm-3">
                    <label class="form-label small mb-1">Contado Bs.D</label>
                    <input type="number" class="form-control form-control-sm precio-nuevo" 
                           data-tipo="contado_bs" 
                           placeholder="0.00" 
                           step="0.01" min="0">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
  });
  
  contenidoHTML += `</div>`;
  
  // Mostrar el modal
  Swal.fire({
    title: 'Actualizar Precios',
    html: contenidoHTML,
    showCancelButton: true,
    confirmButtonText: 'Guardar Cambios',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    width: '900px',
    showLoaderOnConfirm: true,
    preConfirm: () => {
      return guardarPreciosActualizados(seleccionados);
    },
    allowOutsideClick: () => !Swal.isLoading()
  });
}

// Función para guardar los precios actualizados
async function guardarPreciosActualizados(articulos) {
  const cambios = [];
  
  articulos.forEach(item => {
    const container = $(`[data-art-id="${item.id}"]`);
    const inputs = container.find('.precio-nuevo');
    
    const precioCambios = {};
    let tieneCambios = false;
    
    inputs.each(function() {
      const valor = $(this).val();
      const tipo = $(this).data('tipo');
      
      if (valor && valor !== '0') {
        precioCambios[tipo] = parseFloat(valor);
        tieneCambios = true;
      }
    });
    
    if (tieneCambios) {
      cambios.push({
        co_art: item.co_art,
        co_prov: item.co_prov,
        co_art_prov: item.co_art_prov,
        cambios: precioCambios
      });
    }
  });
  
  if (cambios.length === 0) {
    Swal.showValidationMessage('No hay cambios para guardar');
    return false;
  }
  
  try {
    // Aquí debes implementar la llamada AJAX a tu backend
    // Ejemplo:
    /*
    const response = await fetch('/api/actualizar-precios-lote', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ cambios })
    });
    
    if (!response.ok) {
      throw new Error('Error en la actualización');
    }
    
    const result = await response.json();
    */
    
    // Simulación de éxito (remover en producción)
    console.log('Cambios a enviar:', cambios);
    
    return {
      success: true,
      message: `Se actualizaron ${cambios.length} artículos correctamente.`,
      data: cambios
    };
    
  } catch (error) {
    Swal.showValidationMessage(`Error: ${error.message}`);
    return false;
  }
}

// Inicializar eventos después de cargar la tabla
function inicializarEventosSeleccion() {
  setTimeout(() => {
    manejarSeleccionTotal();
    actualizarContador();
  }, 500);
}
function transformarDatosParaTabla(datosOriginales) {
  const datosTransformados = [];
  
  // Asegúrate de recibir el índice correctamente
  datosOriginales.forEach((articulo, index) => {  // ← Agrega el parámetro 'index' aquí
    const fechaFormateada = articulo.fecha ? new Date(articulo.fecha).toLocaleDateString() : 'N/A';

    const proveedorInfoHtml = `
      <div class="text-wrap">
        <span class="fw-bold">${articulo.co_art_prov} - ${articulo.prov_des || articulo.co_prov}</span>
        <br>
        <strong class="text-bold">Fecha de ingreso: ${fechaFormateada}</strong>
      </div>
    `;

    // Añadir un ID único para cada fila
    const uniqueId = `art_${articulo.co_art}_${index}_${index}`;
    
    // Crear checkbox HTML
    const checkboxHtml = `
      <div class="form-check">
        <input type="checkbox" class="form-check-input select-articulo" 
               id="${uniqueId}" 
               data-co-art="${articulo.co_art}"
               data-art-des="${articulo.art_des}"
               data-co-prov="${index}"
               data-prov-des="${index}"
               data-co-art-prov="${articulo.co_art_prov}">
        <label class="form-check-label" for="${uniqueId}"></label>
      </div>
    `;

    const filaTransformada = {
      responsive_id: uniqueId,
      checkbox: checkboxHtml,
      co_art: articulo.co_art, 
      art_des: articulo.art_des, 
      co_art_prov: articulo.co_art_prov, 
      co_prov: index,
      prov_des: index, 
      proveedor_info: proveedorInfoHtml
    };
    
    const tiposPrecio = [
      { tipo: 'credito_usd', precio_principal: articulo.prec_vta1, precio_proveedor: articulo.prec_vta1_pv, moneda: 'USD' },
      { tipo: 'contado_usd', precio_principal: articulo.prec_vta2, precio_proveedor: articulo.prec_vta2_pv, moneda: 'USD' },
      { tipo: 'credito_bs', precio_principal: articulo.prec_vta3, precio_proveedor: articulo.prec_vta3_pv, moneda: 'VES' },
      { tipo: 'contado_bs', precio_principal: articulo.prec_vta4, precio_proveedor: articulo.prec_vta4_pv, moneda: 'VES' }
    ];
    
    tiposPrecio.forEach(tipo => {
      const precioPrincipal = parseFloat(tipo.precio_principal || 0);
      const precioProveedor = parseFloat(tipo.precio_proveedor || 0);
      
      let precioHTML = '';

      if (precioPrincipal > 0 && precioProveedor > 0) {
        const formattedPrincipal = formatVenezuelanCurrency(precioPrincipal, tipo.moneda);
        const formattedProveedor = formatVenezuelanCurrency(precioProveedor, tipo.moneda);
        
        let porcentajeDiff = ((precioProveedor - precioPrincipal) / precioPrincipal) * 100;
        let displayDiff = 0;
        if (precioProveedor < precioPrincipal) {
            displayDiff = Math.abs(porcentajeDiff);
        } else if (precioProveedor > precioPrincipal) {
            displayDiff = -Math.abs(porcentajeDiff);
        }
        const diffStr = `${displayDiff >= 0 ? '+' : ''}${displayDiff.toFixed(1)}%`;
        
        let principalClass = 'fw-bold';
        let proveedorClass = 'fw-bold';
        let diffClass = '';
        
        if (precioProveedor < precioPrincipal) {
          principalClass += ' text-danger';
          proveedorClass += ' text-success';
          diffClass = 'text-danger';
        } else if (precioPrincipal < precioProveedor) {
          principalClass += ' text-success';
          proveedorClass += ' text-danger';
          diffClass = 'text-success';
        } else {
          principalClass += ' text-success'; 
          proveedorClass += ' text-success';
        }
        
        precioHTML = `
          <div class="d-flex align-items-stretch h-100">
            <div class="flex-grow-1 d-flex flex-column align-items-start justify-content-center py-2 px-3" style="background-color: #f2f6ff; border-radius: 0.25rem 0 0 0.25rem;">
              <span class="${principalClass}">${formattedPrincipal}</span>
              ${displayDiff !== 0 ? `<small class="${diffClass}" style="font-weight: 500;">(${diffStr})</small>` : ''}
            </div>
            <div class="flex-grow-1 d-flex align-items-center justify-content-end py-2 px-3" style="border-left: 1px solid rgba(0,0,0,0.07); border-radius: 0 0.25rem 0.25rem 0;">
              <span class="${proveedorClass}">${formattedProveedor}</span>
            </div>
          </div>
        `;
      } else {
        precioHTML = '<div class="text-center p-2">N/A</div>';
      }
      
      filaTransformada[tipo.tipo] = precioHTML;
    });

    datosTransformados.push(filaTransformada);
  });
  
  return datosTransformados;
}

// FUNCIÓN PARA FILTRAR DATOS PARA EXPORTACIÓN - SIN CAMBIOS
function filtrarDatosParaExportacion(datosTransformados) {
  return datosTransformados.filter(fila => {
    try {
      const tiposPrecio = ['credito_usd', 'contado_usd', 'credito_bs', 'contado_bs'];
      return tiposPrecio.some(tipo => {
        const precioHTML = fila[tipo.tipo] || '';
        const matchPrincipal = precioHTML.match(/<span[^>]*>([^<]+)<\/span>/g);
        if (!matchPrincipal || matchPrincipal.length < 2) return false;
        const precioPrincipalText = $(matchPrincipal[0]).text();
        const precioProveedorText = $(matchPrincipal[1]).text();
        const precioPrincipal = extraerNumeroDeTexto(precioPrincipalText);
        const precioProveedor = extraerNumeroDeTexto(precioProveedorText);
        return precioPrincipal > 0 && precioProveedor > 0 && precioProveedor > precioPrincipal;
      });
    } catch (error) { console.error('Error filtrando fila:', error, fila); return false; }
  });
}

// FUNCIÓN AUXILIAR PARA EXTRAER NÚMERO DE TEXTO - SIN CAMBIOS
function extraerNumeroDeTexto(texto) {
  if (!texto || texto === 'No aplica') return 0;
  const match = texto.match(/(\d{1,3}(,\d{3})*(\.\d+)?)/);
  if (match) { return parseFloat(match[1].replace(/,/g, '')); }
  return 0;
}

// Función auxiliar para formatear moneda - SIN CAMBIOS
function formatVenezuelanCurrency(amount, currency) {
  if (amount === 0) return '0.00';
  if (currency === 'USD') { return `USD ${parseFloat(amount).toFixed(2)}`; } 
  else { return `Bs.D ${parseFloat(amount).toFixed(2)}`; }
}



