/**
 * App Calendar - Aplicación de Calendario
 * 
 * Este archivo contiene la funcionalidad completa de una aplicación de calendario
 * utilizando FullCalendar junto con jQuery. Incluye la creación, edición, 
 * eliminación y filtrado de eventos.
 * 
 * La aplicación ahora interactúa con una base de datos a través de llamadas AJAX
 * para obtener, crear, actualizar y eliminar eventos.
 */

'use-strict';

// ========================================
// CONFIGURACIÓN INICIAL Y VARIABLES GLOBALES
// ========================================

// Soporte para RTL (Right-to-Left) para idiomas que se escriben de derecha a izquierda
var direction = 'ltr', // Por defecto left-to-right (izquierda a derecha)
  assetPath = '../../../app-assets/'; // Ruta a los recursos del proyecto

// ========================================
// VARIABLES PARA SEGUIMIENTO DE VISITAS (GLOBALES)
// ========================================
let visitTrackingData = {}; // Almacenar estado de visitas por evento
const VISIT_STATUS = {
    PENDING: 'pendiente',
    VISITED: 'visitado',
    NOT_VISITED: 'no_visitado'
};

// Verificar si el HTML tiene configuración RTL
if ($('html').data('textdirection') == 'rtl') {
  direction = 'rtl'; // Cambiar dirección a derecha a izquierda
}

// Verificar si se está usando el framework Laravel
if ($('body').attr('data-framework') === 'laravel') {
  assetPath = $('body').attr('data-asset-path'); // Actualizar ruta de recursos para Laravel
}

// URLs para diferentes operaciones CRUD
const API_URLS = {
  fetch: '../admin/index.php?action=combos&c=ClienteData&a=1&t=clientes',
  add: '../admin/index.php?action=combos&c=ClienteData&a=1&t=clientes',
  update: '../admin/index.php?action=combos&c=ClienteData&a=1&t=clientes',
  delete: '../admin/index.php?action=combos&c=ClienteData&a=1&t=clientes'
};

// ========================================
// MANEJO DE EVENTOS DE UI (INTERFAZ DE USUARIO)
// ========================================

// Evento para mostrar la barra lateral al hacer clic en el botón de toggle
$(document).on('click', '.fc-sidebarToggle-button', function (e) {
  $('.app-calendar-sidebar, .body-content-overlay').addClass('show');
});

// Evento para ocultar la barra lateral al hacer clic en la superposición
$(document).on('click', '.body-content-overlay', function (e) {
  $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
});

// ========================================
// INICIALIZACIÓN DEL CALENDARIO CUANDO EL DOM ESTÁ CARGADO
// ========================================

document.addEventListener('DOMContentLoaded', function () {
  // ========================================
  // VARIABLES Y REFERENCIAS A ELEMENTOS DOM
  // ========================================
  
  var calendarEl = document.getElementById('calendar'), // Elemento contenedor del calendario
    eventToUpdate, // Variable para almacenar el evento que se está actualizando
    sidebar = $('#add-new-sidebar'), // Barra lateral para editar eventos (actualizado para usar el ID del modal)
    calendarsColor = { // Colores asociados a cada tipo de calendario
      '1': 'primary',  // Clientes
      '2': 'danger'    // Candidatos
    },
    eventForm = $('.event-form'), // Formulario de evento
    addEventBtn = $('.add-event-btn'), // Botón para añadir evento
    cancelBtn = $('.btn-cancel'), // Botón para cancelar
    updateEventBtn = $('.update-event-btn'), // Botón para actualizar evento
    toggleSidebarBtn = $('.btn-toggle-sidebar'), // Botón para alternar barra lateral
    eventTitle = $('#title'), // Campo de título del evento
    cantidad = $('#cantidad'), // Campo de título del evento
    eventLabel = $('#select-label'), // Selector de etiqueta/categoría
    startDate = $('#start-date'), // Selector de fecha de inicio
    endDate = $('#end-date'), // Selector de fecha de fin
    eventUrl = $('#event-url'), // Campo de URL del evento
    eventGuests = $('#event-guests'), // Selector de invitados
    eventLocation = $('#event-location'), // Campo de ubicación
    allDaySwitch = $('.allDay-switch'), // Interruptor para evento de día completo
    selectAll = $('.select-all'), // Checkbox para seleccionar todos los filtros
    calEventFilter = $('.calendar-events-filter'), // Contenedor de filtros de eventos
    filterInput = $('.input-filter'), // Inputs de filtro
    btnDeleteEvent = $('.btn-delete-event'), // Botón para eliminar evento
    calendarEditor = $('#event-description-editor'); // Editor de descripción del evento

  // ========================================
  // EVENTOS DE INTERFAZ
  // ========================================

  // Variable para almacenar los datos de los clientes y no volver a pedirlos
  let clientesData = null;

  // Referencias a los elementos del DOM
  const dynamicFieldsContainer = $('#dynamic-fields-container');
  const cantidadContainer = $('#cantidad-container');
  const clienteContainer = $('#cliente-container');
  const selectCliente = $('#select-cliente');

  // Inicializar Select2 para el selector de clientes (se mantendrá oculto hasta que se necesite)
  if (selectCliente.length) {
    selectCliente.select2({
      dropdownParent: selectCliente.parent(),
      placeholder: 'Seleccione uno o más clientes...',
      allowClear: true,
      width: '100%',
      multiple: true
    });
  }

  // Evento que se dispara cuando se cambia la selección en "Dirijido a"
  eventLabel.on('change', function() {
    const selectedValue = $(this).val();

    // Limpiar valores anteriores
    cantidad.val('');
    selectCliente.val(null).trigger('change');

    if (selectedValue === '1') { // Si es "Clientes"
      cantidadContainer.addClass('d-none');
      clienteContainer.removeClass('d-none');
      dynamicFieldsContainer.removeClass('d-none');

      // Cargar clientes solo si no han sido cargados antes
      if (clientesData === null) {
        // Mostrar indicador de carga
        selectCliente.prop('disabled', true).html('<option>Cargando...</option>');

        $.ajax({
          url: '../admin/index.php?action=combos&c=ClienteData&a=1&t=clientes', // URL para obtener clientes
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            // Guardar los datos para no volver a pedirlos
            clientesData = response;

            // Poblar el select
            populateClienteSelect(clientesData);
          },
          error: function(xhr, status, error) {
            toastr.error('Error al cargar la lista de clientes: ' + error);
            // En caso de error, dejar el select vacío
            selectCliente.html('<option value="">Error al cargar</option>');
          },
          complete: function() {
            // Quitar indicador de carga
            selectCliente.prop('disabled', false);
          }
        });
      } else {
        // Si ya tenemos los datos, solo aseguramos que el select esté poblado
        populateClienteSelect(clientesData);
      }

    } else if (selectedValue === '2') { // Si es "Candidatos"
      clienteContainer.addClass('d-none');
      cantidadContainer.removeClass('d-none');
      dynamicFieldsContainer.removeClass('d-none');
    } else { // Si no hay selección (estado inicial)
      dynamicFieldsContainer.addClass('d-none');
    }
  });

  // Función para poblar el select de clientes
  function populateClienteSelect(clientes) {
    // Limpiar opciones anteriores excepto el placeholder
    selectCliente.empty().append('<option value="">Seleccione uno o más clientes...</option>');
    
    if (clientes && clientes.length > 0) {
      clientes.forEach(function(cliente) {
        // Asumimos que el objeto cliente tiene 'id' y 'nombre' (ajusta si es diferente)
        const option = new Option(cliente.cli_des, cliente.co_cli, false, false);
        selectCliente.append(option);
      });
    }
    selectCliente.trigger('change'); // Refrescar Select2
  }
  
  // Evento para mostrar la barra lateral al hacer clic en el botón de añadir evento
  $('.add-event button').on('click', function (e) {
    sidebar.addClass('show');
    sidebar.modal('show');
    $('.sidebar-left').removeClass('show');
    $('.app-calendar .body-content-overlay').addClass('show');
  });

  // ========================================
  // CONFIGURACIÓN DE SELECT2 PARA CAMPOS DE SELECCIÓN
  // ========================================
  
  // Configuración del selector de etiquetas con Select2
  if (eventLabel.length) {
    // Función para renderizar las viñetas de colores en las opciones
    function renderBullets(option) {
      if (!option.id) {
        return option.text;
      }
      var $bullet =
        "<span class='bullet bullet-" +
        $(option.element).data('label') +
        " bullet-sm me-50'> " +
        '</span>' +
        option.text;

      return $bullet;
    }
    
    // Inicialización de Select2 para el selector de etiquetas
    eventLabel.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select value',
      dropdownParent: eventLabel.parent(),
      templateResult: renderBullets,
      templateSelection: renderBullets,
      minimumResultsForSearch: -1, // Deshabilitar búsqueda
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  // Configuración del selector de invitados con Select2
  if (eventGuests.length) {
    // Función para renderizar los avatares de los invitados
    function renderGuestAvatar(option) {
      if (!option.id) {
        return option.text;
      }

      var $avatar =
        "<div class='d-flex flex-wrap align-items-center'>" +
        "<div class='avatar avatar-sm my-0 me-50'>" +
        "<span class='avatar-content'>" +
        "<img src='" +
        assetPath +
        'images/avatars/' +
        $(option.element).data('avatar') +
        "' alt='avatar' />" +
        '</span>' +
        '</div>' +
        option.text +
        '</div>';

      return $avatar;
    }
    
    // Inicialización de Select2 para el selector de invitados
    eventGuests.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select value',
      dropdownParent: eventGuests.parent(),
      closeOnSelect: false, // No cerrar al seleccionar
      templateResult: renderGuestAvatar,
      templateSelection: renderGuestAvatar,
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  // ========================================
  // CONFIGURACIÓN DE DATE PICKERS
  // ========================================
  
  // Configuración del selector de fecha de inicio con Flatpickr
  if (startDate.length) {
    var start = startDate.flatpickr({
      enableTime: true, // Habilitar selección de hora
      altFormat: 'Y-m-dTH:i:S', // Formato alternativo
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  // Configuración del selector de fecha de fin con Flatpickr
  if (endDate.length) {
    var end = endDate.flatpickr({
      enableTime: true, // Habilitar selección de hora
      altFormat: 'Y-m-dTH:i:S', // Formato alternativo
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  // ========================================
  // FUNCIÓN PARA VERIFICAR SI ES FECHA PASADA
  // ========================================
  function isPastDate(date) {
    return moment(date).startOf('day').isBefore(moment().startOf('day'));
  }

  // ========================================
  // FUNCIONES DE SEGUIMIENTO DE VISITAS
  // ========================================
  
  // Actualizar estado de visita
  function updateVisitStatus(eventId, status, eventObj) {
    // Actualizar en memoria
    visitTrackingData[eventId] = status;
    
    // Actualizar en el objeto del evento (extendedProps)
    if (eventObj) {
      eventObj.setExtendedProp('visitStatus', status);
    }
    
    // Enviar a la base de datos
    $.ajax({
      url: '../admin/index.php?action=cliente&tipo=1&accion=100&datos=1&c=ClienteData&a=1&t=clientes',
      type: 'POST',
      data: {
        event_id: eventId,
        visit_status: status,
        visit_date: moment().format('YYYY-MM-DD HH:mm:ss')
      },
      dataType: 'json',
      success: function(response) {
        toastr.success('Estado de visita actualizado correctamente');
        
        // Recargar el modal para mostrar el nuevo estado
        setTimeout(function() {
          if (eventObj) {
            $('#viewEventModal').modal('hide');
            // Simular clic en el evento para recargar el modal
            eventClick({ event: eventObj });
          }
        }, 500);
      },
      error: function(xhr, status, error) {
        toastr.error('Error al actualizar estado de visita: ' + error);
        console.error('Error al actualizar visita:', xhr.responseText);
      }
    });
  }

  // Actualizar observación de visita
  function updateVisitObservation(eventId, observation, eventObj) {
    // Actualizar en el objeto del evento
    if (eventObj) {
      eventObj.setExtendedProp('observations', observation);
    }
    
    // Enviar a la base de datos
    $.ajax({
      url: '../admin/index.php?action=cliente&tipo=1&accion=101&datos=1&c=ClienteData&a=1&t=clientes',
      type: 'POST',
      data: {
        event_id: eventId,
        observation: observation,
        update_date: moment().format('YYYY-MM-DD HH:mm:ss')
      },
      dataType: 'json',
      success: function(response) {
        toastr.success('Observación guardada correctamente');
      },
      error: function(xhr, status, error) {
        toastr.error('Error al guardar observación: ' + error);
        console.error('Error al guardar observación:', xhr.responseText);
      }
    });
  }

  // Cargar estados de visita desde la base de datos
  function loadVisitStatuses() {
    $.ajax({
      url: '../admin/index.php?action=cliente&tipo=1&accion=102&datos=1&c=ClienteData&a=1&t=clientes',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success && response.data) {
          // Formatear datos para visitTrackingData
          response.data.forEach(function(item) {
            visitTrackingData[item.event_id] = item.visit_status;
          });
         // console.log('Estados de visita cargados:', visitTrackingData);
        }
      },
      error: function(xhr, status, error) {
      //  console.error('Error al cargar estados de visita:', error);
      }
    });
  }

  // ========================================
  // FUNCIÓN DE MANEJO DE CLIC EN EVENTO
  // ========================================
  
  function eventClick(info) {
    eventToUpdate = info.event; // Almacenar el evento clickeado
    console.log('Evento seleccionado para visualización/edición:', eventToUpdate);
    
    // Verificar que el evento tiene datos
    if (!eventToUpdate) {
      toastr.error('Error: No se pudo cargar la información del evento');
      return;
    }
    
    // Determinar si es fecha pasada
    var eventDate = eventToUpdate.start;
    var isPast = isPastDate(eventDate);
    var eventType = eventToUpdate.extendedProps.calendar;
    var typeText = eventType === '1' ? 'Cliente' : (eventType === '2' ? 'Candidato' : 'Otro');
    
    // Mostrar el modal de visualización
    $('#viewEventModal').modal('show');
    
    // Llenar el modal con los datos del evento
    $('#viewTitle').text(eventToUpdate.title || 'Sin título');
    $('#viewStartDate').text(eventToUpdate.start ? moment(eventToUpdate.start).format('DD/MM/YYYY HH:mm') : 'No definida');
    $('#viewEndDate').text(eventToUpdate.end ? moment(eventToUpdate.end).format('DD/MM/YYYY HH:mm') : 'No definida');
    $('#viewLocation').text(eventToUpdate.extendedProps.location || 'No especificada');
    $('#viewDescription').text(eventToUpdate.extendedProps.detalles || eventToUpdate.extendedProps.description || 'Sin descripción');
    $('#viewType').text(typeText);
    
    // MOSTRAR INFORMACIÓN DE ESTADO DE VISITA
    var eventId = eventToUpdate.id;
    var visitStatus = visitTrackingData[eventId] || VISIT_STATUS.PENDING;
    
    // Crear sección de seguimiento de visita
    var trackingHtml = `
      <div class="mt-3 p-2 border rounded ${isPast ? 'bg-light' : ''}">
        <h6 class="mb-2">
          <i class="fas fa-clipboard-check me-1"></i> 
          Seguimiento de Visita
          ${!isPast ? '<span class="badge bg-warning ms-2">Pendiente (fecha futura)</span>' : ''}
        </h6>
        
        ${isPast ? `
          <div class="visit-tracking-options">
            <p class="mb-2"><strong>Estado actual:</strong> 
              <span class="visit-status-badge ${visitStatus}">
                ${visitStatus === VISIT_STATUS.VISITED ? '✅ Visitado' : 
                  visitStatus === VISIT_STATUS.NOT_VISITED ? '❌ No visitado' : 
                  '⏳ Sin registrar'}
              </span>
            </p>
            
            <div class="btn-group w-100" role="group">
              <button type="button" class="btn btn-success btn-sm mark-visited-btn ${visitStatus === VISIT_STATUS.VISITED ? 'active' : ''}" 
                      ${visitStatus === VISIT_STATUS.VISITED ? 'disabled' : ''}>
                <i class="fas fa-check-circle me-1"></i> Marcar Visitado
              </button>
              <button type="button" class="btn btn-danger btn-sm mark-not-visited-btn ${visitStatus === VISIT_STATUS.NOT_VISITED ? 'active' : ''}"
                      ${visitStatus === VISIT_STATUS.NOT_VISITED ? 'disabled' : ''}>
                <i class="fas fa-times-circle me-1"></i> Marcar No Visitado
              </button>
            </div>
            
            <div class="mt-2 visit-observation" style="${visitStatus === VISIT_STATUS.PENDING ? 'display:none;' : ''}">
              <label for="visitObservation" class="form-label small">Observaciones:</label>
              <textarea class="form-control form-control-sm" id="visitObservation" rows="2" 
                        placeholder="Agregar observaciones...">${eventToUpdate.extendedProps.observations || ''}</textarea>
              <button class="btn btn-primary btn-sm mt-2 save-observation-btn">Guardar Observación</button>
            </div>
          </div>
        ` : `
          <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle me-1"></i> 
            El seguimiento solo está disponible para fechas pasadas.
          </div>
        `}
      </div>
    `;
    
    // Insertar o reemplazar la sección de seguimiento
    if ($('#visit-tracking-section').length) {
      $('#visit-tracking-section').html(trackingHtml);
    } else {
      $('#viewExtraInfo').after(`<div id="visit-tracking-section">${trackingHtml}</div>`);
    }
    
    // Mostrar información adicional según el tipo de evento
    if (eventType === '1' && eventToUpdate.extendedProps.clientes) {
      var clientesText = eventToUpdate.extendedProps.clientes.map(cliente => cliente.id).join(', ');
      $('#viewExtraInfo').html('<strong>Clientes:</strong> ' + clientesText);
    } else if (eventType === '2' && eventToUpdate.extendedProps.candidatos) {
      var cantidadText = eventToUpdate.extendedProps.candidatos[0].cantidad;
      $('#viewExtraInfo').html('<strong>Número de candidatos:</strong> ' + cantidadText);
    } else {
      $('#viewExtraInfo').html('');
    }
    
    // ========================================
    // EVENTOS PARA SEGUIMIENTO DE VISITAS
    // ========================================
    
    // Marcar como visitado
    $(document).off('click', '.mark-visited-btn').on('click', '.mark-visited-btn', function() {
      var eventId = eventToUpdate.id;
      updateVisitStatus(eventId, VISIT_STATUS.VISITED, eventToUpdate);
    });
    
    // Marcar como no visitado
    $(document).off('click', '.mark-not-visited-btn').on('click', '.mark-not-visited-btn', function() {
      var eventId = eventToUpdate.id;
      updateVisitStatus(eventId, VISIT_STATUS.NOT_VISITED, eventToUpdate);
    });
    
    // Guardar observación
    $(document).off('click', '.save-observation-btn').on('click', '.save-observation-btn', function() {
      var observation = $('#visitObservation').val();
      var eventId = eventToUpdate.id;
      updateVisitObservation(eventId, observation, eventToUpdate);
    });
    
    // Configurar el botón de compartir por WhatsApp
    $('#shareWhatsAppBtn').off('click').on('click', function() {
      var visitStatusText = visitTrackingData[eventId] || VISIT_STATUS.PENDING;
      var statusEmoji = visitStatusText === VISIT_STATUS.VISITED ? '✅' : 
                       visitStatusText === VISIT_STATUS.NOT_VISITED ? '❌' : '⏳';
      var statusText = visitStatusText === VISIT_STATUS.VISITED ? 'Visitado' : 
                      visitStatusText === VISIT_STATUS.NOT_VISITED ? 'No visitado' : 'Pendiente';
      
      var message = encodeURIComponent(
        "📅 *Evento: " + eventToUpdate.title + "*\n" +
        "📋 Tipo: " + typeText + "\n" +
        "🗓️ Inicio: " + moment(eventToUpdate.start).format('DD/MM/YYYY HH:mm') + "\n" +
        (eventToUpdate.end ? "🏁 Fin: " + moment(eventToUpdate.end).format('DD/MM/YYYY HH:mm') + "\n" : "") +
        (eventToUpdate.extendedProps.location ? "📍 Ubicación: " + eventToUpdate.extendedProps.location + "\n" : "") +
        (eventToUpdate.extendedProps.description ? "📝 Descripción: " + eventToUpdate.extendedProps.detalles + "\n" : "") +
        "📊 *Estado de visita:* " + statusEmoji + " " + statusText
      );
      
      window.open('https://wa.me/?text=' + message, '_blank');
    });
    
    // Configurar los botones de editar y eliminar (solo para fechas no pasadas)
    $('#editEventBtn').off('click').on('click', function() {
      if (isPast) {
        toastr.error('No se pueden editar eventos de fechas pasadas');
        $('#viewEventModal').modal('hide');
        return;
      }
      
      // Resto del código de edición...
      $('#viewEventModal').modal('hide');
      sidebar.modal('show');
      addEventBtn.addClass('d-none');
      cancelBtn.removeClass('d-none');
      updateEventBtn.removeClass('d-none');
      btnDeleteEvent.removeClass('d-none');

      // Rellenar el formulario con los datos del evento
      eventTitle.val(eventToUpdate.title);
      start.setDate(eventToUpdate.start, true, 'Y-m-d');
      eventToUpdate.allDay === true ? allDaySwitch.prop('checked', true) : allDaySwitch.prop('checked', false);
      eventToUpdate.end !== null
        ? end.setDate(eventToUpdate.end, true, 'Y-m-d')
        : end.setDate(eventToUpdate.start, true, 'Y-m-d');
      sidebar.find(eventLabel).val(eventToUpdate.extendedProps.calendar).trigger('change');
      
      if (eventType === '1' && eventToUpdate.extendedProps.clientes) {
        var clientesIds = eventToUpdate.extendedProps.clientes.map(cliente => cliente.id);
        selectCliente.val(clientesIds).trigger('change');
      } else if (eventType === '2' && eventToUpdate.extendedProps.candidatos) {
        cantidad.val(eventToUpdate.extendedProps.candidatos[0].cantidad);
      }
      
      eventToUpdate.extendedProps.location !== undefined ? eventLocation.val(eventToUpdate.extendedProps.location) : null;
      eventToUpdate.extendedProps.guests !== undefined
        ? eventGuests.val(eventToUpdate.extendedProps.guests).trigger('change')
        : null;
      eventToUpdate.extendedProps.description !== undefined
        ? calendarEditor.val(eventToUpdate.extendedProps.description)
        : null;

      btnDeleteEvent.off('click').on('click', function () {
        removeEvent(eventToUpdate.id);
      });
    });
    
    $('#deleteEventBtn').off('click').on('click', function() {
      if (isPast) {
        toastr.error('No se pueden eliminar eventos de fechas pasadas');
        $('#viewEventModal').modal('hide');
        return;
      }
      
      $('#viewEventModal').modal('hide');
      removeEvent(eventToUpdate.id);
    });
  }

  // Función para modificar el botón de toggle de la barra lateral
  function modifyToggler() {
    $('.fc-sidebarToggle-button')
      .empty()
      .append(feather.icons['menu'].toSvg({ class: 'ficon' }));
  }

  // Función para obtener los calendarios seleccionados en los filtros
  function selectedCalendars() {
    var selected = [];
    $('.calendar-events-filter input:checked').each(function () {
      selected.push($(this).attr('data-value'));
    });
    return selected;
  }

  // ========================================
  // OBTENCIÓN DE EVENTOS DESDE BASE DE DATOS
  // ========================================
  
  // Función para obtener eventos desde la base de datos a través de AJAX
  function fetchEvents(info, successCallback, failureCallback) {
    // Obtener los calendarios seleccionados
    var calendars = selectedCalendars();
    
    $.ajax({
      url: '../admin/index.php?action=cliente&tipo=1&accion=99&datos=1&c=ClienteData&a=1&t=clientes',
      type: 'GET',
      data: {
        calendars: calendars
      },
      dataType: 'json',
      success: function(response) {
        try {
          if (Array.isArray(response)) {
            var formattedEvents = response.map(function(event) {
              return {
                id: event.id,
                title: event.descripcion,
                start: event.inicio,
                end: event.fin || event.inicio,
                allDay: true,
                url: event.url || '',
                extendedProps: {
                  calendar: event.tipo,
                  location: event.direc1 || '',
                  guests: [],
                  description: event.descripcion,
                  detalles: event.detalles,
                  visitStatus: event.visit_status || VISIT_STATUS.PENDING,
                  observations: event.observations || ''
                }
              };
            });
            
            successCallback(formattedEvents);
          } else if (response.success && Array.isArray(response.events)) {
            var formattedEvents = response.events.map(function(event) {
              return {
                id: event.id,
                title: event.descripcion,
                start: event.inicio,
                end: event.fin || event.inicio,
                allDay: event.all_day === 1 || event.all_day === true,
                url: event.url || '',
                extendedProps: {
                  calendar: event.tipo,
                  location: event.direc1 || '',
                  guests: event.guests || [],
                  description: event.descripcion,
                  detalles: event.detalles,
                  visitStatus: event.visit_status || VISIT_STATUS.PENDING,
                  observations: event.observations || ''
                }
              };
            });
            
            successCallback(formattedEvents);
          } else {
            console.error('Formato de respuesta inesperado:', response);
            toastr.error('Error al cargar los eventos: Formato de respuesta inesperado');
            if (failureCallback) failureCallback();
          }
        } catch (error) {
          console.error('Error al procesar la respuesta:', error);
          toastr.error('Error al procesar los eventos: ' + error.message);
          if (failureCallback) failureCallback();
        }
      },
      error: function(xhr, status, error) {
        toastr.error('Error de conexión al cargar los eventos: ' + error);
        console.error('Error al cargar eventos:', xhr.responseText);
        if (failureCallback) failureCallback();
      }
    });
  }

  // ========================================
  // CONFIGURACIÓN DE FULLCALENDAR
  // ========================================
  
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es', 
    events: fetchEvents,
    editable: false,
    dragScroll: false,
    dayMaxEvents: 2,
    eventResizableFromStart: false,
    customButtons: {
      sidebarToggle: {
        text: 'Sidebar'
      }
    },
    headerToolbar: {
      start: 'sidebarToggle, prev,next, title',
      end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    direction: direction,
    initialDate: new Date(),
    navLinks: true,
    eventClassNames: function ({ event: calendarEvent }) {
      const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
      return ['bg-light-' + colorName];
    },
dayCellDidMount: function(info) {
    var date = info.date;
    var dateStr = moment(date).format('YYYY-MM-DD');
    var today = moment().startOf('day');
    var cellDate = moment(date).startOf('day');
    
    // SOLO mostrar botón si es HOY o DÍA PASADO
    var isPast = cellDate.isBefore(today);
    var isToday = cellDate.isSame(today, 'day');
    
    // ✅ MOSTRAR SOLO EN DÍAS PASADOS O HOY
    // ❌ NO MOSTRAR EN DÍAS FUTUROS
    if (isPast || isToday) {
        
        // Crear el botón de consulta
        var consultBtn = document.createElement('button');
        consultBtn.className = 'btn btn-sm btn-link p-0 day-consult-btn';
        consultBtn.setAttribute('data-date', dateStr);
        consultBtn.setAttribute('title', isToday ? 'Ver visitas de hoy' : 'Ver visitas de este día');
        consultBtn.setAttribute('aria-label', 'Consultar visitas');
        
        // Estilo del botón
        consultBtn.style.cssText = `
            position: absolute;
            top: 2px;
            right: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: ${isToday ? '#28a745' : '#6c757d'};
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            z-index: 10;
            font-size: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s;
        `;
        
        // Icono diferente
        consultBtn.innerHTML = isToday ? '🔍' : '📋';
        
        // Hover effect
        consultBtn.onmouseover = function() { 
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.15)';
        };
        consultBtn.onmouseout = function() { 
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        };
        
        // Evento click del botón
        consultBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            loadDailyVisits(date);
            return false;
        };
        
        // Agregar el botón a la celda
        info.el.style.position = 'relative';
        info.el.appendChild(consultBtn);
        
        // Agregar indicador de día consultable
        info.el.classList.add('consultable-day');
        if (isToday) {
            info.el.classList.add('today-consultable');
        }
    }
},
    dateClick: function (info) {
        var selectedDate = moment(info.date);
        var today = moment().startOf('day');
        
        // IMPORTANTE: Verificar si el clic fue en el botón de consulta
        if (info.jsEvent.target.classList.contains('day-consult-btn') ||
            info.jsEvent.target.closest('.day-consult-btn')) {
            // El clic ya fue manejado por el botón, no hacer nada aquí
            return;
        }
        
        // Comportamiento normal para crear eventos
        if (selectedDate.isBefore(today)) {
            toastr.error('No se pueden crear eventos en fechas pasadas');
            return;
        }
        
        var date = moment(info.date).format('YYYY-MM-DD');
        resetValues();
        sidebar.modal('show');
        addEventBtn.removeClass('d-none');
        cancelBtn.removeClass('d-none');
        updateEventBtn.addClass('d-none');
        btnDeleteEvent.addClass('d-none');
        startDate.val(date);
        endDate.val(date);
    },


    eventClick: function (info) {
      eventClick(info);
    },
    datesSet: function () {
      modifyToggler();
    },
    viewDidMount: function () {
      modifyToggler();
    }
  });

  // Renderizar el calendario
  calendar.render();

  // Cargar estados de visita
  loadVisitStatuses();

  // Modificar el botón de toggle
  modifyToggler();

  // ========================================
  // VALIDACIÓN DEL FORMULARIO
  // ========================================
  
  if (eventForm.length) {
    eventForm.validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        if (eventForm.valid()) {
          sidebar.modal('hide');
        }
      },
      title: {
        required: true
      },
      rules: {
        'start-date': { required: true },
        'end-date': { required: true }
      },
      messages: {
        'start-date': { required: 'Start Date is required' },
        'end-date': { required: 'End Date is required' }
      }
    });
  }

  // ========================================
  // EVENTOS DE BOTONES
  // ========================================
  
  if (toggleSidebarBtn.length) {
    toggleSidebarBtn.on('click', function () {
      cancelBtn.removeClass('d-none');
    });
  }

  // ========================================
  // FUNCIONES DE MANEJO DE EVENTOS (CRUD)
  // ========================================

  function updateEvent(eventData) {
    var loadingToast = toastr.info('Actualizando evento...');
    
    var serverData = {
      id: eventData.id,
      descripcion: eventData.title,
      inicio: eventData.start,
      fin: eventData.end,
      tipo: eventData.extendedProps.calendar,
      estatus: '1'
    };
    
    $.ajax({
      url: API_URLS.update,
      type: 'POST',
      data: serverData,
      dataType: 'json',
      success: function(response) {
        toastr.remove(loadingToast);
        
        try {
          var success = false;
          
          if (Array.isArray(response)) {
            success = response.length > 0;
          } else if (response.success !== undefined) {
            success = response.success;
          } else if (response.id) {
            success = true;
          }
          
          if (success) {
            var propsToUpdate = ['id', 'title', 'url'];
            var extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];
            updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            toastr.success('Evento actualizado correctamente');
          } else {
            toastr.error('Error al actualizar el evento: La operación no fue exitosa');
          }
        } catch (error) {
          console.error('Error al procesar la respuesta:', error);
          toastr.error('Error al procesar la respuesta del servidor: ' + error.message);
        }
      },
      error: function(xhr, status, error) {
        toastr.remove(loadingToast);
        toastr.error('Error de conexión al actualizar el evento: ' + error);
        console.error('Error al actualizar evento:', xhr.responseText);
      }
    });
  }

  function removeEvent(eventId) {
    if (!confirm('¿Está seguro de que desea eliminar este evento?')) {
      return;
    }
    
    var loadingToast = toastr.info('Eliminando evento...');
    
    $.ajax({
      url: API_URLS.delete,
      type: 'POST',
      data: { id: eventId },
      dataType: 'json',
      success: function(response) {
        toastr.remove(loadingToast);
        
        try {
          var success = false;
          
          if (Array.isArray(response)) {
            success = response.length > 0;
          } else if (response.success !== undefined) {
            success = response.success;
          } else if (response.id) {
            success = true;
          }
          
          if (success) {
            removeEventInCalendar(eventId);
            sidebar.modal('hide');
            if (typeof viewModal !== 'undefined') viewModal.modal('hide');
            $('.event-sidebar').removeClass('show');
            $('.app-calendar .body-content-overlay').removeClass('show');
            toastr.success('Evento eliminado correctamente');
          } else {
            toastr.error('Error al eliminar el evento: La operación no fue exitosa');
          }
        } catch (error) {
          console.error('Error al procesar la respuesta:', error);
          toastr.error('Error al procesar la respuesta del servidor: ' + error.message);
        }
      },
      error: function(xhr, status, error) {
        toastr.remove(loadingToast);
        toastr.error('Error de conexión al eliminar el evento: ' + error);
        console.error('Error al eliminar evento:', xhr.responseText);
      }
    });
  }

  const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
    const existingEvent = calendar.getEventById(updatedEventData.id);

    for (var index = 0; index < propsToUpdate.length; index++) {
      var propName = propsToUpdate[index];
      existingEvent.setProp(propName, updatedEventData[propName]);
    }

    existingEvent.setDates(updatedEventData.start, updatedEventData.end, { allDay: updatedEventData.allDay });

    for (var index = 0; index < extendedPropsToUpdate.length; index++) {
      var propName = extendedPropsToUpdate[index];
      existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
    }
  };

  function removeEventInCalendar(eventId) {
    calendar.getEventById(eventId).remove();
  }

  // ========================================
  // EVENTOS DE FORMULARIO
  // ========================================
  
  function addEvent(serverData) {
    var loadingToast = toastr.info('Guardando evento...');
    
    $.ajax({
      url: '../admin/index.php?action=cliente&tipo=1&accion=98&datos=1&c=ClienteData&a=1&t=clientes',
      type: 'POST',
      data: serverData,
      dataType: 'json',
      success: function(response) {
        toastr.remove(loadingToast);
        
        try {
          if (response.success) {
            if (response.id) {
              serverData.id = response.id;
            }
            
            toastr.success('Evento guardado correctamente');
            calendar.refetchEvents();
            resetValues();
          } else {
            toastr.error(response.message || 'Error al guardar el evento');
          }
        } catch (error) {
          console.error('Error al procesar la respuesta:', error);
          toastr.error('Error al procesar la respuesta del servidor: ' + error.message);
        }
      },
      error: function(xhr, status, error) {
        toastr.remove(loadingToast);
        toastr.error('Error de conexión al guardar el evento: ' + error);
        console.error('Error al guardar evento:', xhr.responseText);
      }
    });
  }

  $(addEventBtn).on('click', function (e) {
    e.preventDefault();
    
    if (eventForm.valid()) {
      const selectedType = eventLabel.val();
      let extraData = {};

      if (selectedType === '1') {
        const selectedClientes = selectCliente.val();
        if (!selectedClientes || selectedClientes.length === 0) {
          toastr.error('Por favor, seleccione al menos un cliente.');
          return;
        }
        extraData.clientes = selectedClientes.map(id => ({ id: id }));
      } else if (selectedType === '2') {
        const cantidadValue = cantidad.val();
        if (!cantidadValue || cantidadValue <= 0) {
          toastr.error('Por favor, ingrese un número de candidatos válido.');
          return;
        }
        extraData.candidatos = [{ cantidad: cantidadValue }];
      }

      var serverData = {
        descripcion: calendarEditor.val() || 'N/A',
        inicio: startDate.val(),
        fin: startDate.val(),
        tipo_v: selectedType,
        estatus: '1',
        ...extraData 
      };
      
      addEvent(serverData);
      
      sidebar.modal('hide');
      $('.event-sidebar').removeClass('show');
      $('.app-calendar .body-content-overlay').removeClass('show');
    }
  });

  updateEventBtn.on('click', function (e) {
    e.preventDefault();
    
    if (eventForm.valid()) {
      var eventData = {
        id: eventToUpdate.id,
        title: sidebar.find(eventTitle).val(),
        start: sidebar.find(startDate).val(),
        end: sidebar.find(endDate).val(),
        url: eventUrl.val(),
        extendedProps: {
          location: eventLocation.val(),
          guests: eventGuests.val(),
          calendar: eventLabel.val(),
          description: calendarEditor.val()
        },
        display: 'block',
        allDay: allDaySwitch.prop('checked')
      };

      updateEvent(eventData);
      
      sidebar.modal('hide');
      $('.event-sidebar').removeClass('show');
      $('.app-calendar .body-content-overlay').removeClass('show');
    }
  });

  // ========================================
  // FUNCIONES AUXILIARES
  // ========================================
  
  function resetValues() {
    endDate.val('');
    eventUrl.val('');
    startDate.val('');
    eventTitle.val('');
    eventLocation.val('');
    allDaySwitch.prop('checked', false);
    eventGuests.val('').trigger('change');
    calendarEditor.val('');
    
    cantidad.val('');
    selectCliente.val(null).trigger('change');
    
    dynamicFieldsContainer.addClass('d-none');
    clienteContainer.addClass('d-none');
    cantidadContainer.addClass('d-none');
    
    eventLabel.val(null).trigger('change');
  }

  sidebar.on('hidden.bs.modal', function () {
    resetValues();
  });

  $('.btn-toggle-sidebar').on('click', function () {
    btnDeleteEvent.addClass('d-none');
    updateEventBtn.addClass('d-none');
    addEventBtn.removeClass('d-none');
    $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
  });

  // ========================================
  // FUNCIONALIDAD DE FILTROS
  // ========================================
  
  if (selectAll.length) {
    selectAll.on('change', function () {
      var $this = $(this);

      if ($this.prop('checked')) {
        calEventFilter.find('input').prop('checked', true);
      } else {
        calEventFilter.find('input').prop('checked', false);
      }
      calendar.refetchEvents();
    });
  }

  if (filterInput.length) {
    filterInput.on('change', function () {
      $('.input-filter:checked').length < calEventFilter.find('input').length
        ? selectAll.prop('checked', false)
        : selectAll.prop('checked', true);
      calendar.refetchEvents();
    });
  }
// ========================================
// FUNCIÓN PARA CARGAR VISITAS DE UN DÍA ESPECÍFICO
// ========================================
function loadDailyVisits(date) {
    // Mostrar el modal
    $('#dailyVisitsModal').modal('show');
    
    // Formatear la fecha para mostrar
    var formattedDate = moment(date).format('dddd, DD [de] MMMM [de] YYYY');
    var dateForAPI = moment(date).format('YYYY-MM-DD');

    var cellDate = moment(date).startOf('day');
    var today = moment().startOf('day');
    
    // VALIDACIÓN EXTRA: No permitir consultar días futuros
    if (cellDate.isAfter(today)) {
        toastr.warning('Las visitas futuras se verán cuando el día llegue', 'Día no disponible');
        return;
    }
    
    
    // Actualizar el encabezado del modal
    $('#selectedDateDisplay').html(`<i class="fas fa-calendar-alt me-1"></i> ${formattedDate}`);
    $('#selectedDateSummary').html('Cargando visitas...');
    
    // Mostrar spinner en la tabla
    $('#dailyVisitsTableBody').html(`
        <tr>
            <td colspan="6" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2">Buscando visitas para este día...</p>
            </td>
        </tr>
    `);
    
    // Obtener el vendedor actual (debes pasar esta variable desde PHP)
    var vendedor = window.NOMBRE_VENDEDOR || 'Vendedor';
    
    // Llamada AJAX para obtener las visitas del día
    $.ajax({
        url: '../admin/index.php?action=cliente&tipo=1&accion=103&datos=1&c=ClienteData&a=1&t=clientes',
        type: 'GET',
        data: {
            fecha: dateForAPI,
            co_ven: window.CODIGO_VENDEDOR || ''
        },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                renderDailyVisitsTable(response.data, dateForAPI);
                
                // Actualizar resumen
                var total = response.data.length;
                var visitados = response.data.filter(v => v.visit_status === 'visitado').length;
                var noVisitados = response.data.filter(v => v.visit_status === 'no_visitado').length;
                var pendientes = response.data.filter(v => v.visit_status === 'pendiente' || !v.visit_status).length;
                
                $('#selectedDateSummary').html(`
                    <span class="badge bg-secondary me-2">Total: ${total}</span>
                    <span class="badge bg-success me-2">Visitados: ${visitados}</span>
                    <span class="badge bg-danger me-2">No visitados: ${noVisitados}</span>
                    <span class="badge bg-warning">Pendientes: ${pendientes}</span>
                `);
            } else {
                // No hay visitas para este día
                $('#dailyVisitsTableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay visitas programadas para este día</h5>
                            <p class="text-muted mb-0">Selecciona otra fecha o crea una nueva visita</p>
                        </td>
                    </tr>
                `);
                
                $('#selectedDateSummary').html(`
                    <span class="text-muted">No hay visitas programadas</span>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar visitas diarias:', error);
            $('#dailyVisitsTableBody').html(`
                <tr>
                    <td colspan="6" class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                        <h5>Error al cargar las visitas</h5>
                        <p>${error}</p>
                    </td>
                </tr>
            `);
            
            $('#selectedDateSummary').html(`
                <span class="text-danger">Error al cargar los datos</span>
            `);
        }
    });
}

// ========================================
// FUNCIÓN PARA RENDERIZAR LA TABLA DE VISITAS
// ========================================
function renderDailyVisitsTable(visitas, fecha) {
    var html = '';
    
    if (visitas.length === 0) {
        html = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay visitas para este día</h5>
                </td>
            </tr>
        `;
    } else {
        visitas.forEach(function(visita, index) {
            // Determinar el badge de estado
            var statusBadge = '';
            var statusIcon = '';
            
            if (visita.visit_status === 'visitado') {
                statusBadge = '<span class="badge bg-success">✅ Visitado</span>';
                statusIcon = 'text-success';
            } else if (visita.visit_status === 'no_visitado') {
                statusBadge = '<span class="badge bg-danger">❌ No visitado</span>';
                statusIcon = 'text-danger';
            } else {
                statusBadge = '<span class="badge bg-warning text-dark">⏳ Pendiente</span>';
                statusIcon = 'text-warning';
            }
            
            // Formatear la hora
            var hora = visita.hora || 'N/A';
            if (visita.inicio) {
                hora = moment(visita.inicio).format('HH:mm');
            }
            
            // Observaciones
            var observaciones = visita.observations || visita.observaciones || '';
            if (observaciones.length > 30) {
                observaciones = observaciones.substring(0, 30) + '...';
            }
            
            html += `
                <tr class="visit-row" data-event-id="${visita.event_id || visita.id}" style="cursor: pointer;">
                    <td class="text-center align-middle">${index + 1}</td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-lg me-2 ${statusIcon}"></i>
                            <div>
                                <strong>${visita.cliente_nombre || visita.cliente || 'N/A'}</strong>
                                <br>
                                <small class="text-muted">Código: ${visita.cliente_codigo || visita.co_cli || '-'}</small>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div>
                            <strong>${visita.titulo || visita.descripcion || 'Sin título'}</strong>
                            <br>
                            <small class="text-muted">${visita.tipo_texto || (visita.tipo === '1' ? 'Cliente' : 'Candidato') || 'Evento'}</small>
                        </div>
                    </td>
                    <td class="align-middle text-center">${statusBadge}</td>
                    <td class="align-middle text-center">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-clock me-1"></i> ${hora}
                        </span>
                    </td>
                    <td class="align-middle">
                        ${observaciones ? 
                            `<span title="${visita.observations || visita.observaciones}">
                                <i class="fas fa-comment me-1 text-info"></i> ${observaciones}
                            </span>` : 
                            '<span class="text-muted fst-italic">Sin observaciones</span>'
                        }
                    </td>
                </tr>
            `;
        });
    }
    
    $('#dailyVisitsTableBody').html(html);
    
    // Agregar evento click a cada fila para ver detalle del evento
    $('.visit-row').on('click', function() {
        var eventId = $(this).data('event-id');
        
        // Buscar el evento en el calendario
        var event = calendar.getEventById(eventId.toString());
        
        if (event) {
            // Cerrar modal de visitas diarias
            $('#dailyVisitsModal').modal('hide');
            
            // Abrir modal de detalle del evento
            setTimeout(function() {
                eventClick({ event: event });
            }, 500);
        } else {
            toastr.info('El evento no está disponible en la vista actual');
        }
    });
}

function marcarDiasConVisitas(eventos) {
    var visitasPorDia = {};
    var today = moment().startOf('day');
    
    eventos.forEach(function(evento) {
        var fecha = moment(evento.inicio).format('YYYY-MM-DD');
        if (!visitasPorDia[fecha]) {
            visitasPorDia[fecha] = 0;
        }
        visitasPorDia[fecha]++;
    });
    
    // Agregar clase y contador SOLO a días consultables
    setTimeout(function() {
        $('.fc-daygrid-day').each(function() {
            // Verificar si el día tiene el botón de consulta
            if (!$(this).hasClass('consultable-day')) {
                return; // Saltar días futuros
            }
            
            var fechaAttr = $(this).data('date');
            if (!fechaAttr) {
                var ariaLabel = $(this).attr('aria-label');
                if (ariaLabel) {
                    var match = ariaLabel.match(/\d{1,2} de \w+ de \d{4}/);
                    if (match) {
                        fechaAttr = moment(match[0], 'D de MMMM de YYYY', 'es').format('YYYY-MM-DD');
                    }
                }
            }
            
            if (fechaAttr && visitasPorDia[fechaAttr]) {
                $(this).addClass('has-visits');
                
                // Agregar contador de visitas
                var contador = $(this).find('.visit-count');
                if (contador.length === 0) {
                    var badge = $(document.createElement('span'));
                    badge.addClass('visit-count');
                    badge.text(visitasPorDia[fechaAttr]);
                    $(this).css('position', 'relative').append(badge);
                }
            }
        });
    }, 500);
}
  // ========================================
  // MANEJO DE CIERRE DE MODALES
  // ========================================
  
  $('.close').on('click', function() {
    $(this).closest('.modal').modal('hide');
  });
  
  $('[data-dismiss="modal"]').on('click', function() {
    $(this).closest('.modal').modal('hide');
  });
});