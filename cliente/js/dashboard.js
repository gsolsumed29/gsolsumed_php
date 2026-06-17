// ============================================
// DASHBOARD INDICADORES - Carga dinámica
// ============================================

// Variables globales para indicadores
let indicadoresData = {
    comprasRealizadas: 0,
    cantidadUnidades: 0,
    facturasPorVencer: 0,
    facturasVencidas: 0,
    // Datos adicionales para tendencias
    tendenciaCompras: 0,      // Porcentaje de cambio
    tendenciaUnidades: 0,
    tendenciaPorVencer: 0,
    tendenciaVencidas: 0
};

// ============================================
// VARIABLES GLOBALES PARA SALDOS
// ============================================
let saldoData = {
    // Saldos por rangos
    rango03: 0,
    rango47: 0,
    rango815: 0,
    rango1630: 0,
    rango31: 0,
    
    // Totales
    totalSaldo: 0,
    totalDocs: 0,
    diasCredito: 0,
    
    // Resúmenes
    saldosPorVencer: 0,
    saldosVencidos: 0,
    docsPorVencer: 0,
    docsVencidos: 0,
    
    // Datos del cliente (estáticos por ahora)
    estadoCliente: 'ACTIVO - CLIENTE AL DÍA',
    segmento: 'AMARILLO',
    limiteCredito: 67008.99,
    depositoGarantia: 0,
    asesor: {
        nombre: 'Grupo solsumed',
        telefono: '0251-273.28.66',
        email: 'ventas@gruposolsumed.com'
    }
};


// ============================================
// FUNCIÓN PRINCIPAL - Cargar indicadores
// ============================================
function loadIndicadoresDashboard() {
    // Mostrar estado de carga
    mostrarIndicadoresLoading();
    
   /* $.ajax({
        url: '../admin/index.php?action=cliente&tipo=1&accion=getIndicadoresDashboard&datos=1&c=ClienteData&a=1&t=indicadores',
        method: 'GET',
        dataType: 'text',
        success: function (response) {
           // console.log('Respuesta del servidor (indicadores):', response.substring(0, 500));
            
            try {
                const respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                const datos = respuesta.data ? respuesta.data[0] : respuesta;
                
                if (datos) {
                    procesarDatosIndicadores(datos);
                    actualizarUIIndicadores();
                } else {
                    console.log('No hay datos de indicadores, cargando ejemplo');
                    loadIndicadoresMock();
                }
            } catch (e) {
                console.error('Error al parsear JSON de indicadores:', e);
                loadIndicadoresMock();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la petición AJAX (indicadores):', error);
            loadIndicadoresMock();
        }
    });*/
}

// ============================================
// FUNCIÓN PARA PROCESAR LOS DATOS
// ============================================
function procesarDatosIndicadores(data) {
    indicadoresData = {
        comprasRealizadas: parseInt(data.compras_realizadas) || parseInt(data.total_compras) || 0,
        cantidadUnidades: parseInt(data.cantidad_unidades) || parseInt(data.total_unidades) || 0,
        facturasPorVencer: parseInt(data.facturas_por_vencer) || parseInt(data.docs_por_vencer) || 0,
        facturasVencidas: parseInt(data.facturas_vencidas) || parseInt(data.docs_vencidos) || 0,
        // Tendencias (opcional)
        tendenciaCompras: parseFloat(data.tendencia_compras) || 0,
        tendenciaUnidades: parseFloat(data.tendencia_unidades) || 0,
        tendenciaPorVencer: parseFloat(data.tendencia_por_vencer) || 0,
        tendenciaVencidas: parseFloat(data.tendencia_vencidas) || 0
    };
    
   // console.log('Indicadores procesados:', indicadoresData);
}

// ============================================
// FUNCIÓN PARA MOSTRAR LOADING
// ============================================
function mostrarIndicadoresLoading() {
    // Card 1 - Compras realizadas
    $('#card-compras').find('h1').html(`
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    `);
    
    // Card 2 - Cantidad unidades
    $('#card-unidades').find('h1').html(`
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    `);
    
    // Card 3 - Facturas por vencer
    $('#card-por-vencer').find('h1').html(`
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    `);
    
    // Card 4 - Facturas vencidas
    $('#card-vencidas').find('h1').html(`
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    `);
}

// ============================================
// FUNCIÓN PARA ACTUALIZAR UI
// ============================================
function actualizarUIIndicadores() {
    // Formatear números grandes
    const formatNumber = (num) => {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toLocaleString('es-VE');
    };
    
    // Card 1 - Compras realizadas
    $('#card-compras').find('h1').text(formatNumber(indicadoresData.comprasRealizadas));
    actualizarBadgeTendencia('#card-compras', indicadoresData.tendenciaCompras);
    
    // Card 2 - Cantidad unidades
    $('#card-unidades').find('h1').text(formatNumber(indicadoresData.cantidadUnidades));
    actualizarBadgeTendencia('#card-unidades', indicadoresData.tendenciaUnidades);
    
    // Card 3 - Facturas por vencer
    $('#card-por-vencer').find('h1').text(formatNumber(indicadoresData.facturasPorVencer));
    actualizarBadgeTendencia('#card-por-vencer', indicadoresData.tendenciaPorVencer);
    
    // Card 4 - Facturas vencidas
    $('#card-vencidas').find('h1').text(formatNumber(indicadoresData.facturasVencidas));
    actualizarBadgeTendencia('#card-vencidas', indicadoresData.tendenciaVencidas, true);
    
    // Efecto de animación
    $('.card h1').addClass('animate__animated animate__fadeIn');
}

// ============================================
// FUNCIÓN PARA ACTUALIZAR BADGE DE TENDENCIA
// ============================================
function actualizarBadgeTendencia(selector, tendencia, isInverse = false) {
    const $badge = $(selector).find('.badge');
    
    if (tendencia === 0) {
        $badge.removeClass('bg-success bg-danger').addClass('bg-secondary');
        $badge.find('span').text('');
        $badge.find('svg').hide();
        return;
    }
    
    const isPositive = isInverse ? tendencia < 0 : tendencia > 0;
    
    if (isPositive) {
        $badge.removeClass('bg-danger bg-secondary').addClass('bg-success');
        $badge.find('svg').show().attr('fill', 'currentColor');
    } else {
        $badge.removeClass('bg-success bg-secondary').addClass('bg-danger');
        // Rotar icono para indicar bajada
        $badge.find('svg').show().css('transform', 'rotate(180deg)');
    }
    
    $badge.find('span').text(Math.abs(tendencia).toFixed(1) + '%');
}

// ============================================
// FUNCIÓN DE RESPALDO - DATOS DE EJEMPLO
// ============================================
function loadIndicadoresMock() {
    //console.log('Cargando indicadores de ejemplo (modo respaldo)');
    
    const mockData = {
        compras_realizadas: 0,
        cantidad_unidades: 0,
        facturas_por_vencer: 0,
        facturas_vencidas: 0,
        tendencia_compras: 0,
        tendencia_unidades: 0,
        tendencia_por_vencer: 0,
        tendencia_vencidas: 0
    };
    
    procesarDatosIndicadores(mockData);
    actualizarUIIndicadores();
    
 
}




function inicializarSelectorSucursales() {
    // Verificar si existe el modal
    if ($('#modalSucursales').length === 0) {
        console.log('Modal no encontrado');
        return;
    }
    
    // Si no hay datos de sesión o no hay sucursales, salir
    if (!datosSesion || datosSesion.cantidad === 0) {
        console.log('No hay sucursales disponibles');
        return;
    }
    
    console.log('Sucursales disponibles:', datosSesion.cantidad);
    
    // Evento para los botones de seleccionar sucursal
    $('.btn-seleccionar-sucursal').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Obtener datos de los atributos data-
        var sucursal = {
            co_cli_sucursal: $(this).data('co-cli-sucursal'),
            sucursal: $(this).data('sucursal-nombre'),
            rif_sucursal: $(this).data('rif-sucursal'),
            matriz: $(this).data('matriz'),
            rif_matriz: $(this).data('rif-matriz'),
            co_cli_matriz: $(this).data('co-cli-matriz')
        };
        
        console.log('Botón click - Sucursal:', sucursal);
        
        if (sucursal.co_cli_sucursal) {
            // Cerrar modal correctamente
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalSucursales'));
            if (modal) {
                modal.hide();
            } else {
                $('#modalSucursales').modal('hide');
            }
            
            // Pequeño retraso para asegurar que el modal se cierre
            setTimeout(function() {
                seleccionarSucursal(sucursal);
            }, 300);
        }
    });
    
    // Evento para las tarjetas
    $('.sucursal-card').off('click').on('click', function(e) {
        // Evitar que se active si se hizo clic en el botón
        if ($(e.target).closest('.btn-seleccionar-sucursal').length) {
            return;
        }
        
        // Obtener datos de los atributos data-
        var sucursal = {
            co_cli_sucursal: $(this).data('co-cli-sucursal'),
            sucursal: $(this).data('sucursal-nombre'),
            rif_sucursal: $(this).data('rif-sucursal'),
            matriz: $(this).data('matriz'),
            rif_matriz: $(this).data('rif-matriz'),
            co_cli_matriz: $(this).data('co-cli-matriz')
        };
        
        console.log('Tarjeta click - Sucursal:', sucursal);
        
        if (sucursal.co_cli_sucursal) {
            // Cerrar modal correctamente
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalSucursales'));
            if (modal) {
                modal.hide();
            } else {
                $('#modalSucursales').modal('hide');
            }
            
            // Pequeño retraso para asegurar que el modal se cierre
            setTimeout(function() {
                seleccionarSucursal(sucursal);
            }, 300);
        }
    });
    
    // Verificar si hay una sucursal previamente seleccionada
    cargarSucursalGuardada();
    
    // Evento cuando se abre el modal
    $('#modalSucursales').on('shown.bs.modal', function() {
        console.log('Modal abierto');
        resaltarSucursalSeleccionada();
    });
    
    // Evento para el botón liberar
    $('#btn-liberar-sucursal').off('click').on('click', function() {
        liberarSucursal();
    });
}

function seleccionarSucursal(sucursal) {
    console.log('Seleccionando sucursal:', sucursal);
    
    // Validar que los datos sean correctos
    if (!sucursal || !sucursal.co_cli_sucursal) {
        console.error('Datos de sucursal inválidos');
        return;
    }
    
    // Mostrar información de la sucursal seleccionada
    actualizarInfoSucursal(sucursal);
    
    // Guardar en sessionStorage (convertir a string manualmente)
    try {
        sessionStorage.setItem('sucursal_seleccionada', JSON.stringify(sucursal));
    } catch (e) {
        console.error('Error guardando en sessionStorage:', e);
    }
    
    // Guardar en variable global
    window.sucursalActiva = sucursal;
    
    // Guardar en el backend mediante AJAX
    guardarSucursalSeleccionada(sucursal.co_cli_sucursal);
    
    // Mostrar el botón de liberar
    $('#btn-liberar-sucursal').fadeIn();
    
    // Disparar evento personalizado
    $(document).trigger('sucursalCambiada', [sucursal]);
    
    // Mostrar notificación de éxito
    mostrarNotificacionExito(sucursal);
    
    // RECARGAR LOS SALDOS CON LA NUEVA SUCURSAL
    if ($('#saldo-card').length) {
        console.log('Recargando saldos para sucursal seleccionada');
        loadSaldosCliente();
    }
}

function actualizarInfoSucursal(sucursal) {
    var $infoSpan = $('#sucursal-seleccionada-info');
    
    var htmlInfo = '<span class="text-success">' +
                   '<i class="fas fa-check-circle me-1"></i>' +
                   'Sucursal activa: <strong>' + (sucursal.sucursal || '') + '</strong> ' +
                   '(' + (sucursal.rif_sucursal || '') + ')' +
                   ' <a href="#" class="text-danger ms-2" id="liberar-desde-info" title="Liberar sucursal">' +
                   '<i class="fas fa-times-circle"></i>' +
                   '</a>' +
                   '</span>';
    
    $infoSpan.html(htmlInfo);
    
    // Evento para liberar desde el link en la info
    $('#liberar-desde-info').off('click').on('click', function(e) {
        e.preventDefault();
        liberarSucursal();
    });
    
    
}

function cargarSucursalGuardada() {
    var sucursalGuardada = sessionStorage.getItem('sucursal_seleccionada');
    
    if (sucursalGuardada) {
        try {
            var sucursal = JSON.parse(sucursalGuardada);
            
            // Verificar que la sucursal todavía existe en la lista
            var existe = false;
            if (datosSesion && datosSesion.sucursales) {
                existe = datosSesion.sucursales.some(function(s) {
                    return s.co_cli_sucursal === sucursal.co_cli_sucursal;
                });
            }
            
            if (existe) {
                seleccionarSucursal(sucursal);
            } else {
                sessionStorage.removeItem('sucursal_seleccionada');
            }
        } catch (e) {
            console.error('Error al recuperar sucursal guardada:', e);
            sessionStorage.removeItem('sucursal_seleccionada');
        }
    } else {
        // Si no hay sucursal guardada pero el cliente tiene sucursales
        if (datosSesion && datosSesion.cantidad > 0) {
            console.log('Cliente con sucursales - mostrando total consolidado por defecto');
            if ($('#saldo-card').length) {
                loadSaldosCliente();
            }
        }
    }
}

function guardarSucursalSeleccionada(coCliSucursal) {
    $.ajax({
        url: 'guardar_sucursal_session.php',
        type: 'POST',
        data: { 
            accion: 'seleccionar',
            sucursal: coCliSucursal 
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Sucursal guardada en sesión');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar sucursal:', error);
        }
    });
}

function liberarSucursal() {
    // Mostrar confirmación
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Liberar sucursal?',
            text: 'Se eliminará la selección actual de sucursal',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, liberar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                ejecutarLiberacion();
            }
        });
    } else {
        if (confirm('¿Liberar sucursal? Se eliminará la selección actual')) {
            ejecutarLiberacion();
        }
    }
}

function ejecutarLiberacion() {
    // Limpiar información
    $('#sucursal-seleccionada-info').html('No hay sucursal seleccionada');
    
    // Eliminar badge si existe
    $('#sucursal-activa-badge').remove();
    
    // Ocultar botón liberar
    $('#btn-liberar-sucursal').fadeOut();
    
    // Limpiar sessionStorage
    sessionStorage.removeItem('sucursal_seleccionada');
    
    // Limpiar variable global
    window.sucursalActiva = null;
    
    // Guardar en backend que se liberó la sucursal
    liberarSucursalEnBackend();
    
    // Disparar evento personalizado
    $(document).trigger('sucursalLiberada', []);
    
    // Mostrar notificación
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Sucursal liberada',
            text: 'Puedes seleccionar otra sucursal cuando lo necesites',
            timer: 2000,
            showConfirmButton: false
        });
    }
    
    // RECARGAR SALDOS CON TOTAL CONSOLIDADO
    if ($('#saldo-card').length) {
        console.log('Recargando saldos consolidados');
        loadSaldosCliente();
    }
}

function liberarSucursalEnBackend() {
    $.ajax({
        url: 'guardar_sucursal_session.php',
        type: 'POST',
        data: { 
            accion: 'liberar'
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Sucursal liberada en sesión');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al liberar sucursal:', error);
        }
    });
}

function mostrarNotificacionExito(sucursal) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Sucursal seleccionada',
            html: 'Has seleccionado: <strong>' + (sucursal.sucursal || '') + '</strong>',
            timer: 2000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    }
}

function resaltarSucursalSeleccionada() {
    var sucursalGuardada = sessionStorage.getItem('sucursal_seleccionada');
    
    if (sucursalGuardada) {
        try {
            var sucursal = JSON.parse(sucursalGuardada);
            
            // Quitar resaltado de todas las tarjetas
            $('.sucursal-card').removeClass('border-primary selected-sucursal');
            
            // Resaltar la tarjeta de la sucursal seleccionada
            $('.sucursal-card').each(function() {
                var coCliSucursal = $(this).data('co-cli-sucursal');
                if (coCliSucursal === sucursal.co_cli_sucursal) {
                    $(this).addClass('border-primary selected-sucursal');
                }
            });
        } catch (e) {
            console.error('Error al resaltar sucursal:', e);
        }
    }
}

// Función para obtener la sucursal activa
function getSucursalActiva() {
    return window.sucursalActiva || null;
}

// Función para verificar si hay sucursal seleccionada
function haySucursalSeleccionada() {
    return window.sucursalActiva !== null && window.sucursalActiva !== undefined;
}

// Función para forzar la selección de sucursal
function forzarSeleccionSucursal() {
    if (!haySucursalSeleccionada() && datosSesion && datosSesion.cantidad > 0) {
        $('#modalSucursales').modal('show');
    }
}









// ============================================
// FUNCIÓN PARA CARGAR SALDOS DEL CLIENTE
// ============================================
// ============================================
// FUNCIÓN PARA CARGAR SALDOS DEL CLIENTE
// ============================================

function calcularTotalConsolidado(sucursales) {
  console.log('Calculando total consolidado de', sucursales.length, 'sucursales');
  
  let consolidado = {
      rango03: 0,
      rango47: 0,
      rango815: 0,
      rango1630: 0,
      rango31: 0,
      total_saldo: 0,
      total_docs: 0,
      dias_credito: 15, // Valor por defecto
      saldos_por_vencer: 0,
      saldos_vencidos: 0,
      docs_por_vencer: 0,
      docs_vencidos: 0
  };
  
  $.each(sucursales, function(index, sucursal) {
      consolidado.rango03 += parseFloat(sucursal.rango03) || 0;
      consolidado.rango47 += parseFloat(sucursal.rango47) || 0;
      consolidado.rango815 += parseFloat(sucursal.rango815) || 0;
      consolidado.rango1630 += parseFloat(sucursal.rango1630) || 0;
      consolidado.rango31 += parseFloat(sucursal.rango31) || 0;
      consolidado.total_saldo += parseFloat(sucursal.total_saldo) || 0;
      consolidado.total_docs += parseInt(sucursal.total_docs) || 0;
      consolidado.saldos_por_vencer += parseFloat(sucursal.saldos_por_vencer) || 0;
      consolidado.saldos_vencidos += parseFloat(sucursal.saldos_vencidos) || 0;
      consolidado.docs_por_vencer += parseInt(sucursal.docs_por_vencer) || 0;
      consolidado.docs_vencidos += parseInt(sucursal.docs_vencidos) || 0;
  });
  
  console.log('Total consolidado calculado:', consolidado);
  return consolidado;
}
function loadSaldosCliente() {
  // Mostrar estado de carga
  mostrarSaldosLoading();
  
  // Obtener la sucursal activa si existe
  var coCliSucursal = '';
  var rifSucursales = ''; // Para enviar múltiples RIFs
  var tieneSucursales = datosSesion && datosSesion.sucursales && datosSesion.sucursales.length > 0;
  
  if (tieneSucursales && haySucursalSeleccionada()) {
      // Caso 1: Hay sucursales y el usuario seleccionó una específica
      var sucursalActiva = getSucursalActiva();
      if (sucursalActiva && sucursalActiva.co_cli_sucursal) {
          coCliSucursal = sucursalActiva.co_cli_sucursal;
          console.log('Cargando saldos para sucursal específica:', coCliSucursal);
      }
  } else if (tieneSucursales && !haySucursalSeleccionada()) {
      // Caso 2: Hay sucursales pero no hay selección - enviar TODOS los RIFs
      console.log('Cliente con sucursales - enviando todos los RIFs para total consolidado');
      
      // Extraer todos los RIFs de sucursales del arreglo datosSesion
      var rifs = [];
      $.each(datosSesion.sucursales, function(index, sucursal) {
          if (sucursal.co_cli_sucursal) {
              rifs.push(sucursal.co_cli_sucursal);
          }
      });
      
      // Unir los RIFs con coma para enviarlos como parámetro
      rifSucursales = rifs.join(',');
      console.log('RIFs enviados:', rifSucursales);
      
      coCliSucursal = 'TODAS';
  } else {
      // Caso 3: Cliente sin sucursales
      console.log('Cliente sin sucursales - mostrando saldo único');
      coCliSucursal = 'UNICO';
  }
  
  // Construir URL con los parámetros necesarios
  let url = '../admin/index.php?action=cliente&tipo=1&accion=getSaldosClientes&datos=1&c=ClienteData&a=1&t=saldo';
  
  if (coCliSucursal) {
      url += '&ss=' + encodeURIComponent(coCliSucursal);
  }
  
  if (rifSucursales) {
      url += '&rifs=' + encodeURIComponent(rifSucursales);
  }
  
  console.log('URL completa:', url);
  
  $.ajax({
      url: url,
      method: 'GET',
      dataType: 'text',
      success: function (response) {
          try {
              const respuesta = typeof response === 'string' ? JSON.parse(response) : response;
              
              if (respuesta.success && respuesta.data) {
                  // Procesar según el caso
                  if (coCliSucursal && coCliSucursal !== 'TODAS' && coCliSucursal !== 'UNICO') {
                      // Caso: sucursal específica - buscar en el array
                      const sucursalEspecifica = respuesta.data.find(s => s.co_cli_sucursal === coCliSucursal);
                      if (sucursalEspecifica) {
                          procesarDatosSaldos(sucursalEspecifica);
                          saldoData.sucursal_especifica = true;
                      } else {
                          // Si no encuentra, usar el primer elemento
                          procesarDatosSaldos(respuesta.data[0]);
                      }
                  } else if (coCliSucursal === 'TODAS') {
                      // Caso: total consolidado - sumar todas las sucursales
                      const consolidado = calcularTotalConsolidado(respuesta.data);
                      procesarDatosSaldos(consolidado);
                      saldoData.total_consolidado = true;
                      saldoData.cantidad_sucursales = respuesta.data.length;
                  } else {
                      // Caso: cliente único - usar el primer elemento
                      procesarDatosSaldos(respuesta.data[0]);
                  }
                  
                  actualizarUI();
              } else {
                  console.log('No hay datos de saldo, cargando ejemplo');
                  loadSaldosClienteMock();
              }
          } catch (e) {
              console.error('Error al parsear JSON de saldos:', e);
              loadSaldosClienteMock();
          }
      },
      error: function (xhr, status, error) {
          console.error('Error en la petición AJAX (saldos):', error);
          loadSaldosClienteMock();
      }
  });
}

// ============================================
// FUNCIÓN PARA PROCESAR LOS DATOS DE SALDOS
// ============================================
function procesarDatosSaldos(data) {
  saldoData = {
      // Saldos por rangos
      rango03: parseFloat(data.rango03) || 0,
      rango47: parseFloat(data.rango47) || 0,
      rango815: parseFloat(data.rango815) || 0,
      rango1630: parseFloat(data.rango1630) || 0,
      rango31: parseFloat(data.rango31) || 0,
      
      // Totales
      totalSaldo: parseFloat(data.total_saldo) || 0,
      totalDocs: parseInt(data.total_docs) || 0,
      diasCredito: parseInt(data.dias_credito) || 15,
      
      // Resúmenes
      saldosPorVencer: parseFloat(data.saldos_por_vencer) || 0,
      saldosVencidos: parseFloat(data.saldos_vencidos) || 0,
      docsPorVencer: parseInt(data.docs_por_vencer) || 0,
      docsVencidos: parseInt(data.docs_vencidos) || 0,
      
      // Metadata (se agregarán según el caso)
      sucursal_especifica: false,
      total_consolidado: false,
      cantidad_sucursales: 1,
      
      // Datos estáticos del cliente
      estadoCliente: 'ACTIVO - CLIENTE AL DÍA',
      segmento: 'AMARILLO',
      limiteCredito: 67008.99,
      depositoGarantia: 0,
      asesor: {
          nombre: 'Grupo solsumed',
          telefono: '0251-273.28.66',
          email: 'ventas@gruposolsumed.com'
      }
  };
  
  console.log('Saldos procesados:', saldoData);
}
// ============================================
// FUNCIÓN PARA MOSTRAR LOADING
// ============================================
function mostrarSaldosLoading() {
    $('#saldo-card').find('.card-body').html(`
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2 text-muted">Cargando saldos del cliente...</p>
        </div>
    `);
}

// ============================================
// FUNCIÓN PARA ACTUALIZAR UI DE SALDOS
// ============================================
// ============================================
// FUNCIÓN PARA ACTUALIZAR UI DE SALDOS (VERSIÓN COMPACTA CON EXPANDIR)
// ============================================
// ============================================
// FUNCIÓN PARA ACTUALIZAR UI DE SALDOS (VERSIÓN COMPACTA CON EXPANDIR)
// ============================================
function actualizarUI() {
  const formatter = new Intl.NumberFormat('es-VE', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});

    const tieneSucursales = datosSesion && datosSesion.sucursales && datosSesion.sucursales.length > 0;
    const sucursalActiva = getSucursalActiva();
    const mostrandoSucursal = saldoData.sucursal_especifica && sucursalActiva;
    const mostrandoTotal = saldoData.total_consolidado;

    let badgeInfo = '';
    if (mostrandoSucursal) {
        badgeInfo = `<span class="badge bg-info ms-2" style="font-size: 10px;" title="${sucursalActiva.rif_sucursal}">
                        <i class="fas fa-store me-1"></i>${sucursalActiva.sucursal.substring(0, 20)}...
                    </span>`;
    } else if (mostrandoTotal) {
        badgeInfo = `<span class="badge bg-primary ms-2" style="font-size: 10px;" title="Total de ${saldoData.cantidad_sucursales} sucursales">
                       Total consolidado (${saldoData.cantidad_sucursales} sucursales)
                    </span>`;
    }
    
    // Actualizar elementos del DOM
    $('#saldo-card').find('.card-body').html(`
        <div class="d-flex align-items-center justify-content-center p-3">
            <div class="d-flex flex-column text-center align-items-center justify-content-between w-100">
                
                <!-- Cabecera con título y días de crédito -->
                <div class="mb-2 w-100">
                    <h4 class="mb-0">Estado de cuenta <br> ${badgeInfo}</h4>
                   <!-- <small class="text-muted">Días de crédito: ${saldoData.diasCredito}</small> -->
                </div>

                <!-- Saldo Total -->
                <div class="mb-2">
                    <small class="text-muted text-uppercase">Saldo Total</small>
                    <h1 class="text-primary fw-bold" style="font-size: 2.2rem;">
                        ${formatter.format(saldoData.totalSaldo)}
                    </h1>
                    <span class="badge bg-info">${saldoData.totalDocs} documento(s)</span>
                </div>
                
                <!-- Botón para expandir/colapsar con icono de ojo -->
                <button class="btn btn-sm btn-outline-secondary px-3 mb-2 d-flex align-items-center gap-2" id="btnExpandirSaldo" style="border-radius: 20px;">
                    <span id="iconoOjo">
                        <!-- Ojo abierto (por defecto) -->
                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z" fill="currentColor"/>
                            <path d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <span id="textoBoton">Ver detalles</span>
                </button>
                
                <!-- Contenido expandible (oculto inicialmente) -->
                <div id="detallesSaldo" style="display: none; width: 100%;">
                    <hr class="my-2">
                    
                    <!-- Indicadores principales -->
                    <div class="d-flex justify-content-center w-100 mb-2">
                        <div class="d-flex gap-2" style="max-width: 100%; width: 100%;">
                            <div class="flex-fill">
                                <div class="p-2 border rounded text-center ${saldoData.saldosVencidos > 0 ? '' : 'bg-light'}" 
                                     style="min-width: 0; width: 100%;">
                                    <small class="text-muted d-block">Por vencer</small>
                                    <h5 class="mb-0 text-warning">${formatter.format(saldoData.saldosPorVencer)}</h5>
                                    <small class="text-muted">${saldoData.docsPorVencer} doc(s)</small>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="p-2 border rounded text-center ${saldoData.saldosVencidos > 0 ? 'bg-danger bg-opacity-10' : 'bg-light'}"
                                     style="min-width: 0; width: 100%;">
                                    <small class="text-muted d-block">Vencidas</small>
                                    <h5 class="mb-0 text-danger">${formatter.format(saldoData.saldosVencidos)}</h5>
                                    <small class="text-muted">${saldoData.docsVencidos} doc(s)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Desglose por antigüedad -->
                    <div class="w-100 mb-2">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">0-3 días:</span>
                            <span class="fw-bold">${formatter.format(saldoData.rango03)}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">4-7 días:</span>
                            <span class="fw-bold">${formatter.format(saldoData.rango47)}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">8-15 días:</span>
                            <span class="fw-bold">${formatter.format(saldoData.rango815)}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">16-30 días:</span>
                            <span class="fw-bold">${formatter.format(saldoData.rango1630)}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between small mb-2 text-danger fw-bold">
                            <span class="text-muted">31+ días:</span>
                            <span class="fw-bold text-danger">${formatter.format(saldoData.rango31)}</span>
                        </div>
                        
                        <!-- Barra de progreso -->
                        ${saldoData.totalSaldo > 0 ? `
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar bg-warning" 
                                 style="width: ${(saldoData.saldosPorVencer / saldoData.totalSaldo) * 100}%">
                            </div>
                            <div class="progress-bar bg-danger" 
                                 style="width: ${(saldoData.saldosVencidos / saldoData.totalSaldo) * 100}%">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between small mt-1">
                            <span><span class="badge bg-warning" style="font-size: 0.6rem;">&nbsp;</span> Por vencer</span>
                            <span><span class="badge bg-danger" style="font-size: 0.6rem;">&nbsp;</span> Vencidas</span>
                        </div>
                        ` : ''}
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex gap-2 w-100">
                        <a href="index.php?view=facturas" class="btn btn-info text-white flex-fill rounded-pill btn-sm d-flex align-items-center justify-content-center gap-1">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.9964 8.37513H17.7618C15.7911 8.37859 14.1947 9.93514 14.1911 11.8566C14.1884 13.7823 15.7867 15.3458 17.7618 15.3484H22V15.6543C22 19.0136 19.9636 21 16.5173 21H7.48356C4.03644 21 2 19.0136 2 15.6543V8.33786C2 4.97862 4.03644 3 7.48356 3H16.5138C19.96 3 21.9964 4.97862 21.9964 8.33786V8.37513ZM6.73956 8.36733H12.3796H12.3831H12.3902C12.8124 8.36559 13.1538 8.03019 13.152 7.61765C13.1502 7.20598 12.8053 6.87318 12.3831 6.87491H6.73956C6.32 6.87664 5.97956 7.20858 5.97778 7.61852C5.976 8.03019 6.31733 8.36559 6.73956 8.36733Z" fill="currentColor"/>
                                <path opacity="0.4" d="M16.0374 12.2966C16.2465 13.2478 17.0805 13.917 18.0326 13.8996H21.2825C21.6787 13.8996 22 13.5715 22 13.166V10.6344C21.9991 10.2297 21.6787 9.90077 21.2825 9.8999H17.9561C16.8731 9.90338 15.9983 10.8024 16 11.9102C16 12.0398 16.0128 12.1695 16.0374 12.2966Z" fill="currentColor"/>
                                <circle cx="18" cy="11.8999" r="1" fill="currentColor"/>
                            </svg>                            
                            Pagar
                        </a>
                       
                    </div>
                </div>
            </div>
        </div>
    `);
    
    // Agregar evento al botón de expandir
    $('#btnExpandirSaldo').off('click').on('click', function() {
        const $detalles = $('#detallesSaldo');
        const $btn = $(this);
        const $iconoOjo = $('#iconoOjo');
        const $textoBoton = $('#textoBoton');
        
        if ($detalles.is(':visible')) {
            // Colapsar - Ojo abierto
            $detalles.slideUp(300);
            $iconoOjo.html(`
                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z" fill="currentColor"/>
                    <path d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z" fill="currentColor"/>
                </svg>
            `);
            $textoBoton.text('Ver detalles');
            $btn.css('background-color', '').css('color', '');
        } else {
            // Expandir - Ojo cerrado
            $detalles.slideDown(300);
            $iconoOjo.html(`
                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12C20 12 18 8 12 8C6 8 4 12 4 12C4 12 6 16 12 16C18 16 20 12 20 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <path d="M3 3L21 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                </svg>
            `);
            $textoBoton.text('Ocultar detalles');
            $btn.css('background-color', '#e9ecef').css('color', '#000');
        }
    });
}

// ============================================
// FUNCIÓN DE RESPALDO - SALDOS DE EJEMPLO
// ============================================
function loadSaldosClienteMock() {
  console.log('Cargando saldos de ejemplo (modo respaldo)');
  
  const mockData = {
      rango03: 0.00,
      rango47: 0.00,
      rango815: 0.00,
      rango1630: 0.00,
      rango31: 0.00,
      total_saldo: 0.00,
      total_docs: 0,
      dias_credito: 15,
      saldos_por_vencer: 0.00,
      saldos_vencidos: 0.00,
      docs_por_vencer: 0,
      docs_vencidos: 0
  };
  
  procesarDatosSaldos(mockData);
  actualizarUI();
  
  setTimeout(() => {
      $('#saldo-card').find('.badge.bg-success').after(
          '<span class="badge bg-warning ms-1" style="font-size: 10px;">Ejemplo</span>'
      );
  }, 100);
}

  // ============================================
  // FUNCIÓN PARA CARGAR MARCAS
  // ============================================
  function loadBrandsSlider() {
    $.ajax({
      url: '../admin/index.php?action=marcas&tipo=1&accion=2&datos=1&c=MarcaData&a=1&t=marca',
      method: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('#brands-slider').html(
          '<li class="swiper-slide text-center p-3"><span class="text-muted">Cargando marcas...</span></li>'
        );
      },
      success: function (marcas) {
        $('#brands-slider').empty();
        if (marcas && marcas.length > 0) {
          $.each(marcas, function (index, marca) {
            const slideItem = createBrandCard(marca, index);
            $('#brands-slider').append(slideItem);
          });
          initBrandsSwiper();
          if (typeof AOS !== 'undefined') {
            AOS.refresh();
          }
        } else {
          $('#brands-slider').html(
            '<li class="swiper-slide text-center p-3"><span class="text-muted">No hay marcas disponibles</span></li>'
          );
        }
      },
      error: function (xhr, status, error) {
        console.error('Error al cargar marcas:', error);
        $('#brands-slider').html(
          '<li class="swiper-slide text-center p-3"><span class="text-danger">Error al cargar las marcas</span></li>'
        );
      }
    });
  }

  // ============================================
  // FUNCIÓN PARA CARGAR TODOS LOS PRODUCTOS
  // ============================================
  function loadProductsSlider() {
    // Mostrar loading
    $('#products-slider').html(`
      <div class="text-center p-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-2 text-muted">Cargando productos destacados...</p>
      </div>
    `);

    $.ajax({
      url: '../admin/index.php?action=articulos&tipo=1&accion=2&datos=1&c=ArticuloData&a=1&t=art&filtro=SI&marca=0',
      method: 'GET',
      dataType: 'text',
      success: function (response) {
     //   console.log('Respuesta del servidor (productos):', response.substring(0, 500));
        
        $('#products-slider').empty();
        
        try {
          const productos = typeof response === 'string' ? JSON.parse(response) : response;
          
          if (productos && Array.isArray(productos) && productos.length > 0) {
            const productosMostrar = productos.slice(0, 20);
            
            $.each(productosMostrar, function (index, producto) {
              const productItem = createProductCard(producto, index);
              $('#products-slider').append(productItem);
            });
            
            setTimeout(() => {
              initProductsOwlCarousel('#products-slider');
            }, 100);
            
            if (typeof AOS !== 'undefined') {
              setTimeout(() => AOS.refresh(), 200);
            }
          } else {
            console.log('No hay productos, cargando datos de ejemplo');
            loadProductsSliderMock();
          }
        } catch (e) {
          console.error('Error al parsear JSON:', e);
          loadProductsSliderMock();
        }
      },
      error: function (xhr, status, error) {
        console.error('Error en la petición AJAX:', error);
        loadProductsSliderMock();
      }
    });
  }


  // #2DCCD3

  // ============================================
  // FUNCIÓN PARA CARGAR PRODUCTOS BIALY
  // ============================================
  function loadBialyProductsSlider() {
    // Mostrar loading
    $('#bialy-products-slider').html(`
      <div class="text-center p-5">
        <div class="spinner-border text-success" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-2 text-muted">Cargando productos BIALY...</p>
      </div>
    `);

    $.ajax({
      url: '../admin/index.php?action=articulos&tipo=1&accion=2&datos=1&c=ArticuloData&a=1&t=art&filtro=NO&marca=05',
      method: 'GET',
      dataType: 'text',
      success: function (response) {
        //console.log('Respuesta del servidor (productos BIALY):', response.substring(0, 500));
        
        $('#bialy-products-slider').empty();
        
        try {
          const productos = typeof response === 'string' ? JSON.parse(response) : response;
          
          if (productos && Array.isArray(productos) && productos.length > 0) {
            // Filtrar solo productos de la marca BIALY
            const productosBialy = productos.filter(producto => {
              const marca = producto.des_col ? producto.des_col.trim().toUpperCase() : '';
              return marca.includes('BIALY');
            });
            
        //    console.log(`Encontrados ${productosBialy.length} productos de BIALY`);
            
            if (productosBialy.length > 0) {
              // Mostrar todos los productos BIALY
              $.each(productosBialy, function (index, producto) {
                const productItem = createProductCard(producto, index);
                $('#bialy-products-slider').append(productItem);
              });
            } else {
              console.log('No hay productos BIALY, cargando datos de ejemplo');
              loadBialyProductsSliderMock();
            }
          } else {
            loadBialyProductsSliderMock();
          }
        } catch (e) {
          console.error('Error al parsear JSON:', e);
          loadBialyProductsSliderMock();
        }
        
        // Inicializar el carrusel después de cargar
        setTimeout(() => {
          initBialyOwlCarousel();
        }, 100);
        
        if (typeof AOS !== 'undefined') {
          setTimeout(() => AOS.refresh(), 200);
        }
      },
      error: function (xhr, status, error) {
        console.error('Error en la petición AJAX (BIALY):', error);
        loadBialyProductsSliderMock();
        
        setTimeout(() => {
          initBialyOwlCarousel();
        }, 100);
      }
    });
  }

  // ============================================
  // FUNCIÓN PARA CARGAR PRODUCTOS EN DESCUENTO
  // ============================================
  function loadDescuentoProductsSlider() {
    // Mostrar loading
    $('#descuento-products-slider').html(`
      <div class="text-center p-5">
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-2 text-muted">Cargando productos en descuento...</p>
      </div>
    `);

    $.ajax({
      url: '../admin/index.php?action=articulos&tipo=1&accion=2&datos=1&c=ArticuloData&a=1&t=art&filtro=SI&marca=0',
      method: 'GET',
      dataType: 'text',
      success: function (response) {
      //  console.log('Respuesta del servidor (productos en descuento):', response.substring(0, 500));
        
        $('#descuento-products-slider').empty();
        
        try {
          const productos = typeof response === 'string' ? JSON.parse(response) : response;
          
          if (productos && Array.isArray(productos) && productos.length > 0) {
            // Filtrar productos con descuento (donde prec_vta1 < prec_vta2 o similar)
            // Asumiendo que tienen descuento si prec_vta2 existe y es menor que prec_vta1
            const productosDescuento = productos.filter(producto => {
              // Consideramos que tiene descuento si:
              // 1. Tiene prec_vta2 y es diferente de prec_vta1
              // 2. O tiene prec_vta3 o prec_vta4 con valores
              // 3. O simplemente tomamos algunos aleatorios para demostración
              const precio1 = producto.prec_vta1 || 0;
              const precio2 = producto.prec_vta2 || 0;
              const precio3 = producto.prec_vta3 || 0;
              const precio4 = producto.prec_vta4 || 0;
              
              return (precio2 > 0 && precio2 < precio1) || 
                     (precio3 > 0 && precio3 < precio1) || 
                     (precio4 > 0 && precio4 < precio1) ||
                     // También incluimos algunos productos con stock alto para demostración
                     (producto.stock_act > 1000 && producto.prec_vta1 > 5);
            });
            
           // console.log(`Encontrados ${productosDescuento.length} productos en descuento`);
            
            if (productosDescuento.length > 0) {
              // Mostrar primeros 20 productos en descuento
              const productosMostrar = productosDescuento.slice(0, 20);
              
              $.each(productosMostrar, function (index, producto) {
                // Calcular porcentaje de descuento
                const precioOriginal = producto.prec_vta2 || producto.prec_vta1;
                const precioDescuento = producto.prec_vta1;
                const descuento = precioOriginal > 0 ? Math.round((1 - precioDescuento / precioOriginal) * 100) : 0;
                
                const productItem = createDescuentoProductCard(producto, index, descuento);
                $('#descuento-products-slider').append(productItem);
              });
            } else {
              console.log('No hay productos en descuento, cargando datos de ejemplo');
              loadDescuentoProductsSliderMock();
            }
          } else {
            loadDescuentoProductsSliderMock();
          }
        } catch (e) {
          console.error('Error al parsear JSON:', e);
          loadDescuentoProductsSliderMock();
        }
        
        // Inicializar el carrusel después de cargar
        setTimeout(() => {
          initDescuentoOwlCarousel();
        }, 100);
        
        if (typeof AOS !== 'undefined') {
          setTimeout(() => AOS.refresh(), 200);
        }
      },
      error: function (xhr, status, error) {
        console.error('Error en la petición AJAX (DESCUENTO):', error);
        loadDescuentoProductsSliderMock();
        
        setTimeout(() => {
          initDescuentoOwlCarousel();
        }, 100);
      }
    });
  }

  // ============================================
  // FUNCIÓN DE RESPALDO - PRODUCTOS DE EJEMPLO
  // ============================================
  function loadProductsSliderMock() {
    console.log('Cargando productos de ejemplo (modo respaldo)');
    
    const productosEjemplo = [
      {
        "co_art": "AD-0001",
        "art_des": "ADHESIVO MICROPORE 2\" 10 YDS COLOR BLANCO",
        "stock_act": 2513,
        "prec_vta1": 2.26,
        "des_col": "3M",
        "lin_des": "ADHESIVO"
      },
      {
        "co_art": "AD-0003",
        "art_des": "ADHESIVO TRANSPORE 3\" 10 YDS COLOR BLANCO",
        "stock_act": 344,
        "prec_vta1": 6.12,
        "des_col": "3M",
        "lin_des": "ADHESIVO"
      },
      {
        "co_art": "CAT-0002",
        "art_des": "CATETER ENDOVENOSO #18G",
        "stock_act": 7659,
        "prec_vta1": 0.86,
        "des_col": "SMITHS-MEDICAL",
        "lin_des": "CATETER"
      },
      {
        "co_art": "CAT-0003",
        "art_des": "CATETER ENDOVENOSO #20G",
        "stock_act": 14483,
        "prec_vta1": 0.86,
        "des_col": "SMITHS-MEDICAL",
        "lin_des": "CATETER"
      },
      {
        "co_art": "CH-0001",
        "art_des": "CUTIMED SORBACT 10 CM X 10 CM",
        "stock_act": 104,
        "prec_vta1": 21.34,
        "des_col": "BSN",
        "lin_des": "CUIDADO DE HERIDA"
      },
      {
        "co_art": "EQ-0004",
        "art_des": "BRAZALETE P/TENSIOMETRO ANEROIDE 2 VIAS",
        "stock_act": 4725,
        "prec_vta1": 4.94,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "MQD-0208",
        "art_des": "GASA ESTERIL 4\" X 4\" CAJA 25 SOBRES",
        "stock_act": 76592,
        "prec_vta1": 1.87,
        "des_col": "BIALY",
        "lin_des": "MEDICO QUIRURGICO DESCARTABLE"
      },
      {
        "co_art": "SUT-0135",
        "art_des": "VICRYL 0 J340 70CM 1/2 36MM AC NO CORTANTE",
        "stock_act": 1958,
        "prec_vta1": 16.99,
        "des_col": "BIALY",
        "lin_des": "SUTURA Y MALLA"
      }
    ];
    
    $('#products-slider').empty();
    
    $.each(productosEjemplo, function (index, producto) {
      const productItem = createProductCard(producto, index);
      $('#products-slider').append(productItem);
    });
    
    setTimeout(() => {
      initProductsOwlCarousel('#products-slider');
    }, 100);
    
    if ($('.card .card-title').first().length) {
      $('.card .card-title').first().html('Hola, te puede interesar... <span class="badge bg-warning ms-2" style="font-size: 12px;">Datos de ejemplo</span>');
    }
    
    if (typeof AOS !== 'undefined') {
      setTimeout(() => AOS.refresh(), 200);
    }
  }

  // ============================================
  // FUNCIÓN DE RESPALDO - PRODUCTOS BIALY DE EJEMPLO
  // ============================================
  function loadBialyProductsSliderMock() {
    console.log('Cargando productos BIALY de ejemplo (modo respaldo)');
    
    const productosBialyEjemplo = [
      {
        "co_art": "EQ-0004",
        "art_des": "BRAZALETE P/TENSIOMETRO ANEROIDE 2 VIAS",
        "stock_act": 4725,
        "prec_vta1": 4.94,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "EQ-0005",
        "art_des": "BRAZALETE P/TENSIOMETRO DIGITAL 1 VIA",
        "stock_act": 3945,
        "prec_vta1": 4.71,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "EQ-0013",
        "art_des": "PERILLA PARA TENSIOMETRO ANEROIDE",
        "stock_act": 3224,
        "prec_vta1": 2.76,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "EQ-0014",
        "art_des": "REGULADOR DE OXIGENO",
        "stock_act": 3039,
        "prec_vta1": 29.41,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "EQ-0017",
        "art_des": "TENSIOMETRO DIGITAL BRAZO PREMIUN",
        "stock_act": 874,
        "prec_vta1": 25.88,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "MQD-0208",
        "art_des": "GASA ESTERIL 4\" X 4\" CAJA 25 SOBRES",
        "stock_act": 76592,
        "prec_vta1": 1.87,
        "des_col": "BIALY",
        "lin_des": "MEDICO QUIRURGICO DESCARTABLE"
      },
      {
        "co_art": "MQD-0209",
        "art_des": "COMPRESA DE LAPARATOMIA ESTERIL 18\" X 18\"",
        "stock_act": 101406,
        "prec_vta1": 1.41,
        "des_col": "BIALY",
        "lin_des": "MEDICO QUIRURGICO DESCARTABLE"
      },
      {
        "co_art": "MQD-0210",
        "art_des": "BOLSA RECOLECTORA ORINA 2000ML C/VALVULA",
        "stock_act": 468,
        "prec_vta1": 8.82,
        "des_col": "BIALY",
        "lin_des": "MEDICO QUIRURGICO DESCARTABLE"
      },
      {
        "co_art": "MEC-0001",
        "art_des": "MEDIAS ANTIEMBOLICAS MUSLO 15-20MMHG TALLA S",
        "stock_act": 1293,
        "prec_vta1": 12.53,
        "des_col": "BIALY",
        "lin_des": "MEDIA DE COMPRESION"
      },
      {
        "co_art": "MEC-0002",
        "art_des": "MEDIAS ANTIEMBOLICAS MUSLO 15-20MMHG TALLA M",
        "stock_act": 1210,
        "prec_vta1": 12.53,
        "des_col": "BIALY",
        "lin_des": "MEDIA DE COMPRESION"
      },
      {
        "co_art": "SUT-0135",
        "art_des": "VICRYL 0 J340 70CM 1/2 36MM AC NO CORTANTE",
        "stock_act": 1958,
        "prec_vta1": 16.99,
        "des_col": "BIALY",
        "lin_des": "SUTURA Y MALLA"
      },
      {
        "co_art": "SUT-0136",
        "art_des": "VICRYL 1 J341 70CM 1/2 36MM AC NO CORTANTE",
        "stock_act": 3528,
        "prec_vta1": 17.65,
        "des_col": "BIALY",
        "lin_des": "SUTURA Y MALLA"
      }
    ];
    
    $('#bialy-products-slider').empty();
    
    $.each(productosBialyEjemplo, function (index, producto) {
      const productItem = createProductCard(producto, index);
      $('#bialy-products-slider').append(productItem);
    });
    
    // Mostrar indicador de que son datos de ejemplo
    if ($('#bialy-products-slider').closest('.card').find('.card-title').length) {
      $('#bialy-products-slider').closest('.card').find('.card-title').html('Productos Bialy <span class="badge bg-warning ms-2" style="font-size: 12px;">Datos de ejemplo</span>');
    }
  }

  // ============================================
  // FUNCIÓN DE RESPALDO - PRODUCTOS DESCUENTO DE EJEMPLO
  // ============================================
  function loadDescuentoProductsSliderMock() {
    console.log('Cargando productos en descuento de ejemplo (modo respaldo)');
    
    const productosDescuentoEjemplo = [
      {
        "co_art": "EQ-0017",
        "art_des": "TENSIOMETRO DIGITAL BRAZO PREMIUN C/BATERIA",
        "stock_act": 874,
        "prec_vta1": 22.99,
        "prec_vta2": 25.88,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "AD-0001",
        "art_des": "ADHESIVO MICROPORE 2\" 10 YDS COLOR BLANCO",
        "stock_act": 2513,
        "prec_vta1": 1.99,
        "prec_vta2": 2.26,
        "des_col": "3M",
        "lin_des": "ADHESIVO"
      },
      {
        "co_art": "CAT-0168",
        "art_des": "CATETER ENDOVENOSO #18G (CAJA 100 UNDS)",
        "stock_act": 47461,
        "prec_vta1": 0.25,
        "prec_vta2": 0.32,
        "des_col": "BIALY",
        "lin_des": "CATETER"
      },
      {
        "co_art": "MQD-0208",
        "art_des": "GASA ESTERIL 4\" X 4\" CAJA 25 SOBRES 2 UNDS C/U",
        "stock_act": 76592,
        "prec_vta1": 1.50,
        "prec_vta2": 1.87,
        "des_col": "BIALY",
        "lin_des": "MEDICO QUIRURGICO DESCARTABLE"
      },
      {
        "co_art": "MEC-0001",
        "art_des": "MEDIAS ANTIEMBOLICAS MUSLO 15-20MMHG TALLA S",
        "stock_act": 1293,
        "prec_vta1": 10.99,
        "prec_vta2": 12.53,
        "des_col": "BIALY",
        "lin_des": "MEDIA DE COMPRESION"
      },
      {
        "co_art": "CH-0009",
        "art_des": "TEGADERM FILM 6CM X 7CM SOBRE 1 UND",
        "stock_act": 1654,
        "prec_vta1": 0.45,
        "prec_vta2": 0.55,
        "des_col": "3M",
        "lin_des": "CUIDADO DE HERIDA"
      },
      {
        "co_art": "SUT-0135",
        "art_des": "VICRYL 0 J340 70CM 1/2 36MM AC NO CORTANTE",
        "stock_act": 1958,
        "prec_vta1": 14.99,
        "prec_vta2": 16.99,
        "des_col": "BIALY",
        "lin_des": "SUTURA Y MALLA"
      },
      {
        "co_art": "EQ-0093",
        "art_des": "ESTETOSCOPIO DOBLE CAMPANA",
        "stock_act": 2056,
        "prec_vta1": 4.49,
        "prec_vta2": 5.29,
        "des_col": "BIALY",
        "lin_des": "EQUIPO Y REHABILITACION"
      },
      {
        "co_art": "LIQ-0046",
        "art_des": "SOLUCION FISIOLOGICA 0.9% 500 ML",
        "stock_act": 3283,
        "prec_vta1": 1.25,
        "prec_vta2": 1.79,
        "des_col": "IPS PHARMA",
        "lin_des": "SOLUCION Y LIQUIDO"
      },
      {
        "co_art": "MQD-0433",
        "art_des": "JERINGA 3 CC 21G 1 1/2\" CAJA 100 UNDS",
        "stock_act": 3843,
        "prec_vta1": 2.99,
        "prec_vta2": 3.34,
        "des_col": "BIALY",
        "lin_des": "MEDICO QUIRURGICO DESCARTABLE"
      },
      {
        "co_art": "SOP-0059",
        "art_des": "FAJA ABDOMINAL POST-OPERATORIA TALLA S-M",
        "stock_act": 1417,
        "prec_vta1": 11.99,
        "prec_vta2": 14.12,
        "des_col": "BIALY",
        "lin_des": "SOPORTE"
      },
      {
        "co_art": "MEC-0005",
        "art_des": "MEDIAS DE COMPRESION 20-30MMHG AL MUSLO TALLA S",
        "stock_act": 1811,
        "prec_vta1": 9.99,
        "prec_vta2": 11.59,
        "des_col": "BIALY",
        "lin_des": "MEDIA DE COMPRESION"
      }
    ];
    
    $('#descuento-products-slider').empty();
    
    $.each(productosDescuentoEjemplo, function (index, producto) {
      // Calcular porcentaje de descuento
      const precioOriginal = producto.prec_vta2 || producto.prec_vta1;
      const precioDescuento = producto.prec_vta1;
      const descuento = Math.round((1 - precioDescuento / precioOriginal) * 100);
      
      const productItem = createDescuentoProductCard(producto, index, descuento);
      $('#descuento-products-slider').append(productItem);
    });
    
    // Mostrar indicador de que son datos de ejemplo
    if ($('#descuento-products-slider').closest('.card').find('.card-title').length) {
      $('#descuento-products-slider').closest('.card').find('.card-title').html('Productos en descuento <span class="badge bg-warning ms-2" style="font-size: 12px;">Datos de ejemplo</span>');
    }
  }

  // ============================================
  // FUNCIÓN PARA CREAR TARJETA DE MARCA
  // ============================================
  function createBrandCard(marca, index) {
    const delay = 700 + (index * 50);
    const nombre = marca.des_col ? marca.des_col.trim() : 'Marca';
    const codigo = marca.co_col || '';
    const bgColor = generateBrandColor(codigo || nombre);
    
    return `
    <li class="swiper-slide card card-slide" 
        data-aos="fade-up" 
        data-aos-delay="${delay}" 
        style="padding: 0; overflow: hidden; height: 80px; border-radius: 8px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      <div class="card-body d-flex align-items-center justify-content-center" 
           style="padding: 10px; width: 100%; height: 100%; background: ${bgColor};">
        <span class="brand-name text-center" 
              style="font-size: 13px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.2; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
          <a style="font-size: 13px; font-weight: 700; color: #fff; text-decoration: none;" 
             href="index.php?view=pedido&cc=${codigo}">
            ${nombre}
          </a>
        </span>
      </div>
    </li>
    `;
  }

  // ============================================
  // FUNCIÓN PARA CREAR TARJETA DE PRODUCTO (NORMAL)
  // ============================================
// ============================================
// FUNCIÓN PARA CREAR TARJETA DE PRODUCTO (NORMAL) CON IMAGEN
// ============================================
function createProductCard(producto, index) {
    const delay = index * 100;
    const codigo = producto.co_art || '';
    const nombre = producto.art_des || 'Producto sin nombre';
    const marca = producto.des_col ? producto.des_col.trim() : 'GENERICO';
    const linea = producto.lin_des ? producto.lin_des.trim() : 'SIN LÍNEA';
    const stock = producto.stock_act || 0;
    const precio = producto.prec_vta1 || 0;
    
    // Formatear precio en USD
    const precioFormateado = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(precio);
    
    // Determinar color según la marca
    const badgeColor = getBadgeColor(marca);
    
       // Determinar color y texto del stock
    const stockConfig = getStockConfig(stock);
    
    // Crear iniciales para el placeholder (por si la imagen no carga)
    const iniciales = nombre
        .split(' ')
        .map(word => word.charAt(0))
        .slice(0, 2)
        .join('')
        .toUpperCase();
    
    // Construir la URL de la imagen
    // Puedes ajustar esta ruta según donde almacenes las imágenes
   // const imagenUrl = `../admin/storage/items/${codigo}.png`; // Asumiendo que las imágenes tienen el código como nombre
     const imagenUrl ='../admin/storage/items/default.webp';
    return `
    <div class="item">
        <div class="product__item wow fadeInUp" 
             data-wow-duration="1500ms" 
             data-wow-delay="${delay}ms"
             style="position: relative; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); height: 100%; display: flex; flex-direction: column; border: 1px solid #f0f0f0; transition: all 0.3s;">
            
            <!-- Badge de stock bajo -->
            ${stock < 10 && stock > 0 ? `
            <span style="position: absolute; top: 10px; left: 10px; background: #CF142B; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; z-index: 3; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                ¡Últimas ${stock}!
            </span>
            ` : ''}
            
            <!-- Badge de agotado -->
            ${stock === 0 ? `
            <span style="position: absolute; top: 10px; left: 10px; background: #6c757d; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; z-index: 3; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                AGOTADO
            </span>
            ` : ''}
            
            <!-- Badge de marca -->
            <span style="position: absolute; top: 10px; right: 10px; background: ${badgeColor}; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; z-index: 3; box-shadow: 0 2px 4px rgba(0,0,0,0.2); max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                ${marca}
            </span>
            
                 
         <!-- Imagen del producto -->
          <div class="product__item__image" style="height: 180px; background: #ffffff; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #eee; position: relative; overflow: hidden;">
              <img src="${imagenUrl}" 
                  alt="${nombre}"
                  class="product-image"
                  onerror="this.style.display='none'; this.parentElement.innerHTML += '<div class=\'image-placeholder\' style=\'width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, #FF5722 0%, #FF9800 100%);\'><span style=\'color:white; font-size:36px; font-weight:700; text-shadow:2px 2px 4px rgba(0,0,0,0.3); letter-spacing:2px;\'>${iniciales}</span></div>';"
                  style="width: 100%; height: 100%; object-fit: contain; display: block; transition: transform 0.5s ease;">
          </div>
            
            <!-- Contenido del producto -->
            <div class="product__item__content" style="padding: 16px; flex: 1; display: flex; flex-direction: column;">
                
                <!-- Línea del producto -->
                <span style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block; font-weight: 600;">
                    ${linea}
                </span>
                
                <!-- Nombre del producto -->
                <h4 class="product__item__title" 
                    style="font-size: 14px; margin-bottom: 8px; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; font-weight: 600; color: #2c3e50;" 
                    title="${nombre}">
                    <a href="index.php?view=producto&codigo=${codigo}" 
                       style="color: #2c3e50; text-decoration: none; transition: color 0.3s;">
                        ${nombre}
                    </a>
                </h4>
                
                <!-- Código del producto -->
                <span style="font-size: 11px; color: #adb5bd; margin-bottom: 8px; display: block;">
                    <i class="fas fa-barcode" style="margin-right: 4px;"></i> ${codigo}
                </span>
                
                <!-- Precio 
                <div class="product__item__price" style="font-weight: 700; color: #0143A4; font-size: 20px; margin-bottom: 12px; letter-spacing: -0.5px;">
                    ${precioFormateado}
                </div>
                -->
                
                <!-- Stock disponible -->
                <div style="font-size: 12px; color: ${stock > 0 ? '#2DCCD3' : '#dc3545'}; margin-bottom: 12px; display: block; align-items: center;">
                    <i class="fas fa-box" style="margin-right: 6px;"></i> 
                   <span style="background: ${stockConfig.color}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 700;">
                        ${stockConfig.texto} ${stock > 0 ? stock : ''}
                    </span>
                </div>
                   <div style="margin-top: 8px; text-align: center; font-size: 12px; color: #6c757d; font-style: italic;">
                    Consulte disponibilidad con su asesor
                </div>
                
                <!-- Botón de agregar
                <button class="btn btn-sm" 
                        onclick="addToCart('${codigo}', '${nombre.replace(/'/g, "\\'")}', ${precio})"
                        style="width: 100%; font-size: 13px; padding: 10px; border-radius: 8px; 
                               background: ${stock > 0 ? (marca.includes('BIALY') ? '#2DCCD3' : '#0143A4') : '#e9ecef'}; 
                               border: none; 
                               color: ${stock > 0 ? 'white' : '#6c757d'}; 
                               font-weight: 600;
                               transition: all 0.3s;
                               cursor: ${stock > 0 ? 'pointer' : 'not-allowed'};"
                        ${stock === 0 ? 'disabled' : ''}
                        onmouseover="this.style.background='${stock > 0 ? (marca.includes('BIALY') ? '#28a8af' : '#002B6A') : '#e9ecef'}';"
                        onmouseout="this.style.background='${stock > 0 ? (marca.includes('BIALY') ? '#2DCCD3' : '#0143A4') : '#e9ecef'}';">
                   <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z" fill="currentColor"></path>                            </svg>                        
                    ${stock === 0 ? 'AGOTADO' : 'AGREGAR AL CARRITO'}
                </button> -->
            </div>
        </div>
    </div>
    `;
}

  // ============================================
  // FUNCIÓN PARA CREAR TARJETA DE PRODUCTO EN DESCUENTO
  // ============================================
// ============================================

// ============================================
// FUNCIÓN AUXILIAR PARA CONFIGURACIÓN DE STOCK
// ============================================
function getStockConfig(stock) {
    if (stock === 0) {
        return {
            color: '#6c757d',
            texto: 'AGOTADO'
        };
    } else if (stock < 10) {
        return {
            color: '#CF142B',
            texto: '¡ÚLTIMAS!'
        };
    } else if (stock < 50) {
        return {
            color: '#FFA500',
            texto: 'STOCK BAJO'
        };
    } else if (stock < 100) {
        return {
            color: '#17a2b8',
            texto: 'DISPONIBLE'
        };
    } else {
        return {
            color: '#28a745',
            texto: 'ALTO STOCK'
        };
    }
}
// FUNCIÓN PARA CREAR TARJETA DE PRODUCTO EN DESCUENTO CON IMAGEN
// ============================================
function createDescuentoProductCard(producto, index, descuento = 0) {
    const delay = index * 100;
    const codigo = producto.co_art || '';
    const nombre = producto.art_des || 'Producto sin nombre';
    const marca = producto.des_col ? producto.des_col.trim() : 'GENERICO';
    const linea = producto.lin_des ? producto.lin_des.trim() : 'SIN LÍNEA';
    const stock = producto.stock_act || 0;
    const precioActual = producto.prec_vta1 || 0;
    const precioOriginal = producto.prec_vta2 || producto.prec_vta1 || 0;
    const descuentoCalculado = descuento || (precioOriginal > 0 ? Math.round((1 - precioActual / precioOriginal) * 100) : 0);
    
    // Formatear precios en USD
    const precioActualFormateado = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(precioActual);
    
    const precioOriginalFormateado = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(precioOriginal);
    
    // Determinar color según la marca
    const badgeColor = getBadgeColor(marca);

       // Determinar color y texto del stock
    const stockConfig = getStockConfig(stock);
    
    // Crear iniciales para el placeholder
    const iniciales = nombre
        .split(' ')
        .map(word => word.charAt(0))
        .slice(0, 2)
        .join('')
        .toUpperCase();
    
    // Construir la URL de la imagen
 // const imagenUrl = producto.imagen || '../admin/storage/items/default.webp';
    const imagenUrl ='../admin/storage/items/default.webp';
    return `
    <div class="item">
        <div class="product__item wow fadeInUp" 
             data-wow-duration="1500ms" 
             data-wow-delay="${delay}ms"
             style="position: relative; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); height: 100%; display: flex; flex-direction: column; border: 1px solid #f0f0f0; transition: all 0.3s;">
            
            <!-- Badge de DESCUENTO -->
            ${descuentoCalculado > 0 ? `
            <span style="position: absolute; top: 10px; left: 10px; background: #FF5722; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 3; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                -${descuentoCalculado}% OFF
            </span>
            ` : ''}
            
          
            
            <!-- Badge de marca -->
            <span style="position: absolute; top: 10px; right: 10px; background: ${badgeColor}; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; z-index: 3; box-shadow: 0 2px 4px rgba(0,0,0,0.2); max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                ${marca}
            </span>
            
         <!-- Imagen del producto -->
          <div class="product__item__image" style="height: 180px; background: #ffffff; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #eee; position: relative; overflow: hidden;">
              <img src="${imagenUrl}" 
                  alt="${nombre}"
                  class="product-image"
                  onerror="this.style.display='none'; this.parentElement.innerHTML += '<div class=\'image-placeholder\' style=\'width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, #FF5722 0%, #FF9800 100%);\'><span style=\'color:white; font-size:36px; font-weight:700; text-shadow:2px 2px 4px rgba(0,0,0,0.3); letter-spacing:2px;\'>${iniciales}</span></div>';"
                  style="width: 100%; height: 100%; object-fit: contain; display: block; transition: transform 0.5s ease;">
          </div>
            
            <!-- Contenido del producto -->
            <div class="product__item__content" style="padding: 16px; flex: 1; display: flex; flex-direction: column;">
                
                <!-- Línea del producto -->
                <span style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block; font-weight: 600;">
                    ${linea}
                </span>
                
                <!-- Nombre del producto -->
                <h4 class="product__item__title" 
                    style="font-size: 14px; margin-bottom: 8px; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; font-weight: 600; color: #2c3e50;" 
                    title="${nombre}">
                    <a href="index.php?view=producto&codigo=${codigo}" 
                       style="color: #2c3e50; text-decoration: none; transition: color 0.3s;">
                        ${nombre}
                    </a>
                </h4>
                
                <!-- Código del producto -->
                <span style="font-size: 11px; color: #adb5bd; margin-bottom: 8px; display: block;">
                    <i class="fas fa-barcode" style="margin-right: 4px;"></i> ${codigo}
                </span>
                
                <!-- Precios: Original tachado y actual destacado 
                <div style="margin-bottom: 12px;">
                    <span style="font-size: 14px; color: #6c757d; text-decoration: line-through; margin-right: 8px;">
                        ${precioOriginalFormateado}
                    </span>
                    <span style="font-weight: 800; color: #FF5722; font-size: 22px; letter-spacing: -0.5px;">
                        ${precioActualFormateado}
                    </span>
                </div>
                 -->
                <!-- Stock disponible -->
                <div style="font-size: 12px; color: ${stock > 0 ? '#2DCCD3' : '#dc3545'}; margin-bottom: 12px; display: block; align-items: center;">
                    <i class="fas fa-box" style="margin-right: 6px;"></i> 
                   <span style="background: ${stockConfig.color}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 700;">
                        ${stockConfig.texto} ${stock > 0 ? stock : ''}
                    </span>
                </div>
                   <div style="margin-top: 8px; text-align: center; font-size: 12px; color: #6c757d; font-style: italic;">
                    Consulte disponibilidad con su asesor
                </div>
                <!-- Botón de agregar 
                <button class="btn btn-sm" 
                        onclick="addToCart('${codigo}', '${nombre.replace(/'/g, "\\'")}', ${precioActual})"
                        style="width: 100%; font-size: 13px; padding: 10px; border-radius: 8px; 
                               background: ${stock > 0 ? '#FF5722' : '#e9ecef'}; 
                               border: none; 
                               color: ${stock > 0 ? 'white' : '#6c757d'}; 
                               font-weight: 700;
                               transition: all 0.3s;
                               cursor: ${stock > 0 ? 'pointer' : 'not-allowed'};"
                        ${stock === 0 ? 'disabled' : ''}
                        onmouseover="this.style.background='${stock > 0 ? '#E64A19' : '#e9ecef'}';"
                        onmouseout="this.style.background='${stock > 0 ? '#FF5722' : '#e9ecef'}';">
                      <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z" fill="currentColor"></path>                            </svg>                        
                    ${stock === 0 ? 'AGOTADO' : 'APROVECHAR OFERTA'}
                </button>  -->
            </div>
        </div>
    </div>
    `;
}

  // ============================================
  // FUNCIÓN PARA OBTENER COLOR SEGÚN LA MARCA
  // ============================================
  function getBadgeColor(marca) {
    const marcaTrim = (marca || '').trim().toUpperCase();
    
    const colores = {
      '3M': '#0143A4',
      'BSN': '#0143A4',
      'PHARMAPLAST': '#0143A4',
      'BIALY': '#2DCCD3',
      'SMITHS-MEDICAL': '#0143A4',
      'JOHNSON & JOHNSON': '#0143A4',
      'JHONSON & JHONSON': '#0143A4',
      'KAREMAX': '#0143A4',
      'MC MEDICAL': '#0143A4',
      'GROSSMED': '#0143A4',
      'ALNA': '#0143A4',
      'MED-AID': '#0143A4',
      'DEMETECH': '#0143A4',
      'GENERICO': '#0143A4'
    };
    
    for (let [key, color] of Object.entries(colores)) {
      if (marcaTrim.includes(key)) {
        return color;
      }
    }
    
    let hash = 0;
    for (let i = 0; i < marca.length; i++) {
      hash = marca.charCodeAt(i) + ((hash << 5) - hash);
    }
    const coloresDefault = ['#0143A4', '#0143A4', '#0143A4', '#0143A4', '#0143A4', '#0143A4', '#0143A4', '#0143A4'];
    return coloresDefault[Math.abs(hash) % coloresDefault.length];
  }

  // ============================================
  // FUNCIÓN PARA AGREGAR AL CARRITO
  // ============================================
  window.addToCart = function(codigo, nombre, precio) {
    console.log('Producto agregado al carrito:', { codigo, nombre, precio });
    
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'success',
        title: '¡Producto agregado!',
        text: `${nombre} se agregó al carrito`,
        showConfirmButton: false,
        timer: 1500,
        position: 'top-end',
        toast: true
      });
    } else {
      alert(`✅ Producto agregado: ${nombre}`);
    }
  };

  // ============================================
  // GENERAR COLOR ÚNICO PARA CADA MARCA
  // ============================================
  function generateBrandColor(code) {
    const colors = [
      '#00A8E8', '#4BC7D2', '#0143A4', '#FFCC00', '#CF142B', 
      '#28A745', '#6C757D', '#17A2B8', '#6610F2', '#E83E8C'
    ];
    
    let hash = 0;
    for (let i = 0; i < code.length; i++) {
      hash = code.charCodeAt(i) + ((hash << 5) - hash);
    }
    return colors[Math.abs(hash) % colors.length];
  }

  // ============================================
  // INICIALIZAR SWIPER PARA MARCAS
  // ============================================
  function initBrandsSwiper() {
    if (typeof Swiper === 'undefined') {
      console.error('Swiper no está cargado');
      return;
    }
    
    new Swiper('.d-slider1', {
      slidesPerView: 2,
      spaceBetween: 10,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        576: { slidesPerView: 3, spaceBetween: 15 },
        768: { slidesPerView: 4, spaceBetween: 15 },
        992: { slidesPerView: 5, spaceBetween: 20 },
        1200: { slidesPerView: 6, spaceBetween: 20 }
      }
    });
  }

  // ============================================
  // INICIALIZAR OWL CAROUSEL PARA PRODUCTOS
  // ============================================
  function initProductsOwlCarousel(selector = '.product-page__carousel') {
    if (typeof $.fn.owlCarousel === 'undefined') {
      console.warn('OwlCarousel no está cargado, usando fallback...');
      initSwiperForProducts(selector);
      return;
    }
    
    initOwlCarousel(selector);
  }



  function initOwlCarousel(selector = '.product-page__carousel') {
    try {
      $(selector).owlCarousel('destroy');
    } catch(e) {
      // Ignorar error si no existe
    }
    
    $(selector).owlCarousel({
      items: 1,
      margin: 15,
      loop: true,
      smartSpeed: 700,
      nav: false,
      navText: [
        '<span class="icon-arrow-left"></span>',
        '<span class="icon-arrow-right"></span>'
      ],
      dots: true,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1,
          nav: true,
          dots: false,
          margin: 10
        },
        576: {
          items: 2,
          dots: false,
          margin: 15
        },
        768: {
          items: 3,
          dots: false,
          margin: 15
        },
        992: {
          items: 4,
          dots: false,
          margin: 20
        },
        1200: {
          items: 6,
          dots: false,
          margin: 20
        }
      }
    });
  }

  // ============================================
  // INICIALIZAR OWL CAROUSEL PARA PRODUCTOS BIALY
  // ============================================
  function initBialyOwlCarousel() {
    initProductsOwlCarousel('#bialy-products-slider');
  }

  // ============================================
  // INICIALIZAR OWL CAROUSEL PARA PRODUCTOS DESCUENTO
  // ============================================
  function initDescuentoOwlCarousel() {
    initProductsOwlCarousel('#descuento-products-slider');
  }

  // ============================================
  // FALLBACK: USAR SWIPER PARA PRODUCTOS
  // ============================================
  function initSwiperForProducts(selector = '.product-page__carousel') {
    if (typeof Swiper === 'undefined') {
      console.error('Swiper no está disponible');
      return;
    }
    
    new Swiper(selector, {
      slidesPerView: 1,
      spaceBetween: 15,
      loop: true,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        576: { slidesPerView: 2, spaceBetween: 15 },
        768: { slidesPerView: 3, spaceBetween: 15 },
        992: { slidesPerView: 4, spaceBetween: 20 },
        1200: { slidesPerView: 6, spaceBetween: 20 }
      }
    });
  }





$(window, document, $).ready(function () {
  'use strict';

  // ============================================
  // SLIDER DE MARCAS - Carga dinámica con AJAX
  // ============================================
  if ($('#brands-slider').length) {
    loadBrandsSlider();
  }

  // ============================================
  // SLIDER DE PRODUCTOS DESTACADOS
  // ============================================
  if ($('#products-slider').length) {
    loadProductsSlider();
  }

  // ============================================
  // SLIDER DE PRODUCTOS BIALY
  // ============================================
  if ($('#bialy-products-slider').length) {
    loadBialyProductsSlider();
  }

  // ============================================
  // SLIDER DE PRODUCTOS EN DESCUENTO
  // ============================================
  if ($('#descuento-products-slider').length) {
    loadDescuentoProductsSlider();
  }

  if ($('#saldo-card').length) {
    loadSaldosCliente();
  }



// Cargar indicadores si existen las cards
    if ($('#card-compras').length || $('#card-unidades').length) {
        loadIndicadoresDashboard();
    }

    inicializarSelectorSucursales();
    
     
    // Evento cuando se abre el modal
    $('#modalSucursales').on('shown.bs.modal', function() {
        console.log('Modal de sucursales abierto');
        resaltarSucursalSeleccionada();
    });
    
    // Evento para el botón liberar sucursal
    $('#btn-liberar-sucursal').on('click', function() {
        liberarSucursal();
    });



});