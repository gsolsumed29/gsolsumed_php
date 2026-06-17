function cargarTablaArticulos(){
  const dt_basic_table_articulos = $('.datatables-basic-articulos');   
  
  // Verificar consistencia de columnas
  const columnasHTML = dt_basic_table_articulos.find('thead th').length;
  const columnasJS = 6; // Reducimos a 6 columnas principales

  if (columnasHTML !== columnasJS) {
      console.error(`Error: HTML tiene ${columnasHTML} columnas pero JS define ${columnasJS}`);
      console.error('Por favor, ajusta el HTML o la configuración JavaScript');
      return;
  }

  if (!dt_basic_table_articulos.length) return;
  
  // Destruir instancia previa si existe
  if ($.fn.DataTable.isDataTable(dt_basic_table_articulos)) {
    dt_basic_table_articulos.DataTable().destroy();
  }
  
  // Obtener y parsear datos de forma segura
  const dataArticulos = $('.dataArticulos').val();
  let arrayArticulos = [];
  
  try {
    arrayArticulos = JSON.parse(dataArticulos || '[]');
  } catch (e) {
    console.error('Error parsing articles data:', e);
    return;
  }

  // Configuración de DataTable
  var dt_basic = dt_basic_table_articulos.DataTable({
    data: arrayArticulos,
    columns: [    
      { data: 'responsive_id' }, // 0
      { data: 'co_art' },        // 1   
      { data: 'art_des' },       // 2
      { data: 'co_art_prov' },   // 3    
      { data: 'co_prov' },       // 4
      { data: 'precios' }        // 5 - Columna unificada para precios
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
          title: 'Código',
          width: '10%'
      },  
      {
          targets: 2,
          title: 'Descripción',
          width: '30%'
      }, 
      {
          targets: 3,
          title: 'Código Proveedor',
          width: '8%',
    
      },
      {
          targets: 4,
          title: 'Proveedor',
          width: '10%',
          render: function (data, type, full, meta) {
              const coProv = full['co_prov'] || '';
              const provDes = full['prov_des'] || coProv;
              return `<span class="text-wrap">${provDes}</span>`;
          }
      },
      {
          targets: 5,
          title: 'Precios (Principal vs Proveedor)',
          width: '34%',
          render: function (data, type, full, meta) {
              return generarHTMLPrecios(full);
          }
      }
    ],
    order: [[2, 'asc']],
    dom: `
      <"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>>
      <"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>
      t
      <"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>
    `,
    displayLength: 10,
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [   
      {
        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Agregar',
        className: 'btnAddPrecio btn-relief-primary',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#modalAddPrecios'
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
            return 'Detalles del producto';
          }
        }),
        type: 'column',
        renderer: function (api, rowIdx, columns) {
          const data = columns.map(col => {
            return col.title !== '' ? `
              <tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}">
                <td>${col.title}:</td>
                <td>${col.data}</td>
              </tr>
            ` : '';
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
    deferRender: true
  });
}


// Función auxiliar para generar el HTML de precios con comparación CORREGIDA
function generarHTMLPrecios(full) {
  // Precios principales
  const prec_vta1 = parseFloat(full['prec_vta1'] || 0);
  const prec_vta2 = parseFloat(full['prec_vta2'] || 0);
  const prec_vta3 = parseFloat(full['prec_vta3'] || 0);
  const prec_vta4 = parseFloat(full['prec_vta4'] || 0);
  
  // Precios del proveedor
  const prec_vta1_pv = parseFloat(full['prec_vta1_pv'] || 0);
  const prec_vta2_pv = parseFloat(full['prec_vta2_pv'] || 0);
  const prec_vta3_pv = parseFloat(full['prec_vta3_pv'] || 0);
  const prec_vta4_pv = parseFloat(full['prec_vta4_pv'] || 0);
  
  // Función para comparar precios y aplicar estilos CORREGIDA
  function formatearPrecio(precio, precioPv, moneda) {
    const precioFormateado = formatVenezuelanCurrency(precio, moneda);
    
    // Si el precio del proveedor es 0, mostrar "No aplica"
    if (precioPv === 0) {
      return `
        <div class="text-center">
          <div class="fw-bold ${precio === 0 ? 'text-muted' : 'text-dark'}">${precioFormateado}</div>
          <div class="text-muted small">No aplica</div>
        </div>
      `;
    }
    
    // Si el precio principal es 0 pero el del proveedor no
    if (precio === 0 && precioPv > 0) {
      const precioPvFormateado = formatVenezuelanCurrency(precioPv, moneda);
      return `
        <div class="text-center">
          <div class="fw-bold text-dark">${precioFormateado}</div>
          <div class="text-danger fw-bold small">${precioPvFormateado}</div>
          <div class="text-xs text-muted">+∞%</div>
        </div>
      `;
    }
    
    const precioPvFormateado = formatVenezuelanCurrency(precioPv, moneda);
    const diferencia = precioPv - precio;
    
    // Cálculo CORREGIDO del porcentaje
    let porcentajeDiferencia = 0;
    if (precio > 0) {
      porcentajeDiferencia = (diferencia / precio) * 100;
    }
    
    let estiloPrincipal = 'fw-bold text-dark'; // Precio principal siempre en negro
    let estiloProveedor = 'small';
    let indicadorPorcentaje = '';
    
    if (diferencia > 0) {
      // Precio del proveedor está POR ENCIMA (ROJO)
      estiloProveedor += ' text-danger fw-bold';
      indicadorPorcentaje = `<div class="text-xs text-danger">+${Math.abs(porcentajeDiferencia).toFixed(1)}%</div>`;
    } else if (diferencia < 0) {
      // Precio del proveedor está POR DEBAJO (AMARILLO/NARANJA)
      estiloProveedor += ' text-warning fw-bold';
      indicadorPorcentaje = `<div class="text-xs text-warning">-${Math.abs(porcentajeDiferencia).toFixed(1)}%</div>`;
    } else {
      // Precios iguales (VERDE)
      estiloProveedor += ' text-success';
      if (precio > 0) {
        indicadorPorcentaje = `<div class="text-xs text-success">0.0%</div>`;
      }
    }
    
    return `
      <div class="text-center">
        <div class="${estiloPrincipal}">${precioFormateado}</div>
        <div class="${estiloProveedor}">${precioPvFormateado}</div>
        ${indicadorPorcentaje}
      </div>
    `;
  }

  return `
    <div class="row g-1 text-center">
      <div class="col-3 border-end">
        <small class="text-muted d-block">Crédito USD</small>
        ${formatearPrecio(prec_vta1, prec_vta1_pv, 'USD')}
      </div>
      <div class="col-3 border-end">
        <small class="text-muted d-block">Contado USD</small>
        ${formatearPrecio(prec_vta2, prec_vta2_pv, 'USD')}
      </div>
      <div class="col-3 border-end">
        <small class="text-muted d-block">Crédito Bs.D</small>
        ${formatearPrecio(prec_vta3, prec_vta3_pv, 'VES')}
      </div>
      <div class="col-3">
        <small class="text-muted d-block">Contado Bs.D</small>
        ${formatearPrecio(prec_vta4, prec_vta4_pv, 'VES')}
      </div>
    </div>
  `;
}

// Función de formateo de moneda
function formatVenezuelanCurrency(amount, currency) {
  if (amount === 0) return '0.00';
  
  if (currency === 'USD') {
    return 'USD ' + amount.toFixed(2);
  } else {
    return 'USD ' + amount.toFixed(2);
  }
}

$(window,document,$).ready(function(){
'use strict';


cargarDataArticulos('NO');


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
                        $('#form-agregar-articulo')[0].reset();
                        $('#modalAddPrecios').modal('hide');
                        
                        // Recargar la tabla de precios
                       cargarDataArticulos('NO');
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
  cargarComboArticulos('.co_art');
}

    if ($('.co_prov').length) {
  cargarComboProveedores('.co_prov');
}


});

function cargarDataArticulos($filtro){
  if ($('#dataArticulos').length) {
  $.ajax({
    type: "GET",
    url: '../admin/index.php?action=articulos&tipo=1&accion=3&c=ArticuloData&a=59&t=art&filtro='+$filtro, 
}).done(function(data) { 
  var cadena = JSON.stringify(data);
  $('.dataArticulos').attr("value",cadena);
  cargarTablaArticulos();


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

    $(combo).prepend('<option value = '+data[i].co_art+'>'+data[i].art_des+'</option>');
  
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