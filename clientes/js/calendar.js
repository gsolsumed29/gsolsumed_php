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
  // FUNCIONES DE MANEJO DE EVENTOS
  // ========================================
  
// Función para manejar el clic en un evento del calendario
function eventClick(info) {
    eventToUpdate = info.event; // Almacenar el evento clickeado
    
 

    // Mostrar el modal de visualización en lugar de la barra lateral
    $('#viewEventModal').modal('show');
    
    // Llenar el modal con los datos del evento
    $('#viewTitle').text(eventToUpdate.title);
    $('#viewStartDate').text(moment(eventToUpdate.start).format('DD/MM/YYYY HH:mm'));
    $('#viewEndDate').text(eventToUpdate.end ? moment(eventToUpdate.end).format('DD/MM/YYYY HH:mm') : 'No definida');
    $('#viewLocation').text(eventToUpdate.extendedProps.location || 'No especificada');
    $('#viewDescription').text(eventToUpdate.extendedProps.description || 'Sin descripción');
    
    // Determinar el tipo de evento según el calendario
    var eventType = eventToUpdate.extendedProps.calendar;
    var typeText = eventType === '1' ? 'Cliente' : (eventType === '2' ? 'Candidato' : 'Otro');
    $('#viewType').text(typeText);
    
    // Mostrar información adicional según el tipo de evento
    if (eventType === '1' && eventToUpdate.extendedProps.clientes) {
        // Si es un evento de clientes, mostrar los clientes seleccionados
        var clientesText = eventToUpdate.extendedProps.clientes.map(cliente => cliente.id).join(', ');
        $('#viewExtraInfo').html('<strong>Clientes:</strong> ' + clientesText);
    } else if (eventType === '2' && eventToUpdate.extendedProps.candidatos) {
        // Si es un evento de candidatos, mostrar el número de candidatos
        var cantidadText = eventToUpdate.extendedProps.candidatos[0].cantidad;
        $('#viewExtraInfo').html('<strong>Número de candidatos:</strong> ' + cantidadText);
    } else {
        $('#viewExtraInfo').html('');
    }
    
    // Configurar el botón de compartir por WhatsApp
    $('#shareWhatsAppBtn').off('click').on('click', function() {
        // Formatear el mensaje para WhatsApp
        var message = encodeURIComponent(
            "📅 *Evento: " + eventToUpdate.title + "*\n" +
            "📋 Tipo: " + typeText + "\n" +
            "🗓️ Inicio: " + moment(eventToUpdate.start).format('DD/MM/YYYY HH:mm') + "\n" +
            (eventToUpdate.end ? "🏁 Fin: " + moment(eventToUpdate.end).format('DD/MM/YYYY HH:mm') + "\n" : "") +
            (eventToUpdate.extendedProps.location ? "📍 Ubicación: " + eventToUpdate.extendedProps.location + "\n" : "") +
            (eventToUpdate.extendedProps.description ? "📝 Descripción: " + eventToUpdate.extendedProps.description : "")
        );
        
        // Abrir WhatsApp con el mensaje
        window.open('https://wa.me/?text=' + message, '_blank');
    });
    
    // Configurar los botones de editar y eliminar
    $('#editEventBtn').off('click').on('click', function() {
        // Cerrar el modal de visualización
        $('#viewEventModal').modal('hide');
        
        // Abrir la barra lateral de edición
        sidebar.modal('show');
        addEventBtn.addClass('d-none'); // Ocultar botón de añadir
        cancelBtn.removeClass('d-none'); // Mostrar botón de cancelar
        updateEventBtn.removeClass('d-none'); // Mostrar botón de actualizar
        btnDeleteEvent.removeClass('d-none'); // Mostrar botón de eliminar

        // Rellenar el formulario con los datos del evento
        eventTitle.val(eventToUpdate.title);
        start.setDate(eventToUpdate.start, true, 'Y-m-d');
        eventToUpdate.allDay === true ? allDaySwitch.prop('checked', true) : allDaySwitch.prop('checked', false);
        eventToUpdate.end !== null
            ? end.setDate(eventToUpdate.end, true, 'Y-m-d')
            : end.setDate(eventToUpdate.start, true, 'Y-m-d');
        sidebar.find(eventLabel).val(eventToUpdate.extendedProps.calendar).trigger('change');
        
        // Rellenar los campos dinámicos según el tipo de evento
        if (eventType === '1' && eventToUpdate.extendedProps.clientes) {
            // Si es un evento de clientes, seleccionar los clientes
            var clientesIds = eventToUpdate.extendedProps.clientes.map(cliente => cliente.id);
            selectCliente.val(clientesIds).trigger('change');
        } else if (eventType === '2' && eventToUpdate.extendedProps.candidatos) {
            // Si es un evento de candidatos, establecer la cantidad
            cantidad.val(eventToUpdate.extendedProps.candidatos[0].cantidad);
        }
        
        eventToUpdate.extendedProps.location !== undefined ? eventLocation.val(eventToUpdate.extendedProps.location) : null;
        eventToUpdate.extendedProps.guests !== undefined
            ? eventGuests.val(eventToUpdate.extendedProps.guests).trigger('change')
            : null;
        eventToUpdate.extendedProps.description !== undefined
            ? calendarEditor.val(eventToUpdate.extendedProps.description)
            : null;

        // Configurar el evento de eliminación
        btnDeleteEvent.off('click').on('click', function () {
            // Eliminar evento a través de AJAX
            removeEvent(eventToUpdate.id);
        });
    });
    
    $('#deleteEventBtn').off('click').on('click', function() {
        // Cerrar el modal de visualización
        $('#viewEventModal').modal('hide');
        
        // Eliminar evento a través de AJAX
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
    
    // Realizar llamada AJAX para obtener eventos desde la base de datos
    $.ajax({
         url: '../admin/index.php?action=cliente&tipo=1&accion=99&datos=1&c=ClienteData&a=1&t=clientes',
      type: 'GET',
      data: {
        calendars: calendars // Enviar filtros de calendarios seleccionados
      },
      dataType: 'json',
      success: function(response) {
        try {
          // Verificar si la respuesta es un array (formato actual del servidor)
          if (Array.isArray(response)) {
            
            // Formatear los eventos según la estructura esperada por FullCalendar
            var formattedEvents = response.map(function(event) {
              // Mapear los campos del formato del servidor al formato esperado por FullCalendar
              return {
                id: event.id,
                title: event.descripcion,
                start: event.inicio,
                end: event.fin || event.inicio, // Si no hay fecha de fin, usar la de inicio
                allDay: true, // Por defecto, eventos de día completo
                url: event.url || '',
                extendedProps: {

                  calendar: event.tipo, // Usar el campo 'tipo' como calendario
                  location: event.direc1 || '',
                  guests: [],
                  description: event.descripcion
                }
              };
            });
            
            // Devolver los eventos formateados a FullCalendar
            successCallback(formattedEvents);
          } 
          // Si la respuesta tiene el formato esperado con success y events
          else if (response.success && Array.isArray(response.events)) {
            // Formatear los eventos según la estructura esperada por FullCalendar
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
                  description: event.descripcion
                }
              };
            });
            
            // Devolver los eventos formateados a FullCalendar
            successCallback(formattedEvents);
          } 
          // Si la respuesta tiene un formato inesperado
          else {
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
        // Mostrar mensaje de error si la llamada AJAX falló
        toastr.error('Error de conexión al cargar los eventos: ' + error);
        console.error('Error al cargar eventos:', xhr.responseText);
        if (failureCallback) failureCallback();
      }
    });
  }

  // ========================================
  // CONFIGURACIÓN DE FULLCALENDAR
  // ========================================
  
// Crear instancia de FullCalendar
var calendar = new FullCalendar.Calendar(calendarEl, {
  initialView: 'dayGridMonth', // Vista inicial: mes
  locale: 'es', 
  events: fetchEvents, // Función para obtener eventos
  editable: false, // Cambiar a false para desactivar edición de eventos
  dragScroll: false, // Cambiar a false para desactivar desplazamiento al arrastrar
  dayMaxEvents: 2, // Máximo de eventos a mostrar por día
  eventResizableFromStart: false, // Cambiar a false para desactivar redimensionamiento
  
  // Añadir esta función para deshabilitar fechas pasadas
  validRange: {
    start: moment().format('YYYY-MM-DD') // Solo permitir fechas desde hoy en adelante
  },
  
  customButtons: { // Botones personalizados
    sidebarToggle: {
      text: 'Sidebar'
    }
  },
  headerToolbar: { // Configuración de la barra de herramientas
    start: 'sidebarToggle, prev,next, title',
    end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
  },
  direction: direction, // Dirección (LTR o RTL)
  initialDate: new Date(), // Fecha inicial
  navLinks: true, // Permitir navegación haciendo clic en días/semanas
  eventClassNames: function ({ event: calendarEvent }) { // Clases CSS para eventos
    const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
    return ['bg-light-' + colorName];
  },
  dateClick: function (info) { // Evento al hacer clic en una fecha
    // Verificar si la fecha seleccionada es anterior a hoy
    var selectedDate = moment(info.date);
    var today = moment().startOf('day'); // Inicio del día actual
    
    if (selectedDate.isBefore(today)) {
      // Mostrar mensaje de error si la fecha es anterior a hoy
      toastr.error('No se pueden crear eventos en fechas pasadas');
      return; // No continuar con la apertura del formulario
    }
    
    var date = moment(info.date).format('YYYY-MM-DD');
    resetValues(); // Resetear valores del formulario
    sidebar.modal('show'); // Mostrar barra lateral
    addEventBtn.removeClass('d-none'); // Mostrar botón de añadir
    cancelBtn.removeClass('d-none'); // Mostrar botón de cancelar
    updateEventBtn.addClass('d-none'); // Ocultar botón de actualizar
    btnDeleteEvent.addClass('d-none'); // Ocultar botón de eliminar
    startDate.val(date); // Establecer fecha de inicio
    endDate.val(date); // Establecer fecha de fin
  },
  eventClick: function (info) { // Evento al hacer clic en un evento
    eventClick(info);
  },
  datesSet: function () { // Evento al cambiar las fechas visibles
    modifyToggler();
  },
  viewDidMount: function () { // Evento al montar una vista
    modifyToggler();
  }
});
  // Renderizar el calendario
  calendar.render();
  // Modificar el botón de toggle de la barra lateral
  modifyToggler();

  // ========================================
  // VALIDACIÓN DEL FORMULARIO
  // ========================================
  
  // Configurar validación del formulario de evento
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
  
  // Evento para el botón de toggle de la barra lateral
  if (toggleSidebarBtn.length) {
    toggleSidebarBtn.on('click', function () {
      cancelBtn.removeClass('d-none');
    });
  }

  // ========================================
  // FUNCIONES DE MANEJO DE EVENTOS (CRUD) CON AJAX
  // ========================================
  


  // Función para actualizar un evento existente a través de AJAX
  function updateEvent(eventData) {
    // Mostrar indicador de carga
    var loadingToast = toastr.info('Actualizando evento...');
    
    // Preparar los datos en el formato esperado por el servidor
    var serverData = {
      id: eventData.id,
      descripcion: eventData.title,
      inicio: eventData.start,
      fin: eventData.end,
      tipo: eventData.extendedProps.calendar,
      estatus: '1'
    };
    
    // Realizar llamada AJAX para actualizar el evento en la base de datos
    $.ajax({
      url: API_URLS.update,
      type: 'POST',
      data: serverData,
      dataType: 'json',
      success: function(response) {
        // Ocultar indicador de carga
        toastr.remove(loadingToast);
        
        try {
          var success = false;
          
          // Si la respuesta es un array (formato actual del servidor)
          if (Array.isArray(response)) {
            success = response.length > 0;
          } 
          // Si la respuesta tiene el formato esperado con success
          else if (response.success !== undefined) {
            success = response.success;
          }
          // Si la respuesta es un objeto simple
          else if (response.id) {
            success = true;
          }
          
          if (success) {
            // Actualizar el evento en el calendario
            var propsToUpdate = ['id', 'title', 'url'];
            var extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];
            updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            
            // Mostrar mensaje de éxito
            toastr.success('Evento actualizado correctamente');
          } else {
            // Mostrar mensaje de error
            toastr.error('Error al actualizar el evento: La operación no fue exitosa');
          }
        } catch (error) {
          console.error('Error al procesar la respuesta:', error);
          toastr.error('Error al procesar la respuesta del servidor: ' + error.message);
        }
      },
      error: function(xhr, status, error) {
        // Ocultar indicador de carga
        toastr.remove(loadingToast);
        
        // Mostrar mensaje de error
        toastr.error('Error de conexión al actualizar el evento: ' + error);
        console.error('Error al actualizar evento:', xhr.responseText);
      }
    });
  }

  // Función para eliminar un evento a través de AJAX
function removeEvent(eventId) {
  // Confirmar eliminación
  if (!confirm('¿Está seguro de que desea eliminar este evento?')) {
    return;
  }
  
  // Mostrar indicador de carga
  var loadingToast = toastr.info('Eliminando evento...');
  
  // Realizar llamada AJAX para eliminar el evento de la base de datos
  $.ajax({
    url: API_URLS.delete,
    type: 'POST',
    data: {
      id: eventId
    },
    dataType: 'json',
    success: function(response) {
      // Ocultar indicador de carga
      toastr.remove(loadingToast);
      
      try {
        var success = false;
        
        // Si la respuesta es un array (formato actual del servidor)
        if (Array.isArray(response)) {
          success = response.length > 0;
        } 
        // Si la respuesta tiene el formato esperado con success
        else if (response.success !== undefined) {
          success = response.success;
        }
        // Si la respuesta es un objeto simple
        else if (response.id) {
          success = true;
        }
        
        if (success) {
          // Eliminar el evento del calendario
          removeEventInCalendar(eventId);
          
          // Cerrar cualquier modal abierto
          sidebar.modal('hide');
          viewModal.modal('hide');
          $('.event-sidebar').removeClass('show');
          $('.app-calendar .body-content-overlay').removeClass('show');
          
          // Mostrar mensaje de éxito
          toastr.success('Evento eliminado correctamente');
        } else {
          // Mostrar mensaje de error
          toastr.error('Error al eliminar el evento: La operación no fue exitosa');
        }
      } catch (error) {
        console.error('Error al procesar la respuesta:', error);
        toastr.error('Error al procesar la respuesta del servidor: ' + error.message);
      }
    },
    error: function(xhr, status, error) {
      // Ocultar indicador de carga
      toastr.remove(loadingToast);
      
      // Mostrar mensaje de error
      toastr.error('Error de conexión al eliminar el evento: ' + error);
      console.error('Error al eliminar evento:', xhr.responseText);
    }
  });
}

  // Función para actualizar un evento en el calendario (UI)
  const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
    const existingEvent = calendar.getEventById(updatedEventData.id);

    // Actualizar propiedades básicas del evento
    for (var index = 0; index < propsToUpdate.length; index++) {
      var propName = propsToUpdate[index];
      existingEvent.setProp(propName, updatedEventData[propName]);
    }

    // Actualizar fechas del evento
    existingEvent.setDates(updatedEventData.start, updatedEventData.end, { allDay: updatedEventData.allDay });

    // Actualizar propiedades extendidas del evento
    for (var index = 0; index < extendedPropsToUpdate.length; index++) {
      var propName = extendedPropsToUpdate[index];
      existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
    }
  };

  // Función para eliminar un evento del calendario (UI)
  function removeEventInCalendar(eventId) {
    calendar.getEventById(eventId).remove();
  }

  // ========================================
  // EVENTOS DE FORMULARIO
  // ========================================
  
// ========================================
// FUNCIÓN addEvent CORREGIDA
// ========================================
function addEvent(serverData) { // Ahora recibe serverData directamente
    // Mostrar indicador de carga
    var loadingToast = toastr.info('Guardando evento...');
    
    // Ya no necesitamos preparar los datos aquí, vienen listos en serverData
    
    // Realizar llamada AJAX para guardar el evento en la base de datos
    $.ajax({
       url: '../admin/index.php?action=cliente&tipo=1&accion=98&datos=1&c=ClienteData&a=1&t=clientes',
       type: 'POST',
       data: serverData, // <-- Usamos el serverData que recibimos como parámetro
       dataType: 'json',
       success: function(response) {
            // Ocultar indicador de carga
            toastr.remove(loadingToast);
            
            try {
                if (response.success) {
                    // Si el servidor devolvió un ID, lo usamos para añadir el evento al calendario
                    if (response.id) {
                        serverData.id = response.id; // Añadimos el ID al objeto
                    }
                    
                    // Formateamos el evento para FullCalendar
                    var newEventForCalendar = {
                        id: serverData.id || 'temp_' + Date.now(), // Usar ID del servidor o uno temporal
                        title: serverData.descripcion,
                        start: serverData.inicio,
                        end: serverData.fin,
                        allDay: true,
                        extendedProps: {
                            calendar: serverData.tipo,
                            description: serverData.descripcion,
                            // Guardamos los datos extra para poder mostrarlos después
                            ...(serverData.clientes && { clientes: serverData.clientes }),
                            ...(serverData.candidatos && { candidatos: serverData.candidatos })
                        }
                    };

                    // Añadir el evento al calendario
                  //  calendar.addEvent(newEventForCalendar);
                    
                    // Mostrar mensaje de éxito
                    toastr.success('Evento guardado correctamente');
                    
                    // Recargar eventos para asegurar sincronización
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
            // Ocultar indicador de carga
            toastr.remove(loadingToast);
            
            // Mostrar mensaje de error
            toastr.error('Error de conexión al guardar el evento: ' + error);
            console.error('Error al guardar evento:', xhr.responseText);
        }
    });
}

// ========================================
// EVENTO DE BOTÓN CORREGIDO
// ========================================
 $(addEventBtn).on('click', function (e) {
    e.preventDefault();
    
    if (eventForm.valid()) {
        const selectedType = eventLabel.val();
        let extraData = {};

        if (selectedType === '1') { // Clientes
            const selectedClientes = selectCliente.val();
            if (!selectedClientes || selectedClientes.length === 0) {
                toastr.error('Por favor, seleccione al menos un cliente.');
                return;
            }
            // Convertir a arreglo de objetos
            extraData.clientes = selectedClientes.map(id => ({ id: id }));
        } else if (selectedType === '2') { // Candidatos
            const cantidadValue = cantidad.val();
            if (!cantidadValue || cantidadValue <= 0) {
                toastr.error('Por favor, ingrese un número de candidatos válido.');
                return;
            }
            // Convertir a arreglo con un solo elemento
            extraData.candidatos = [{ cantidad: cantidadValue }];
        }

        // Preparamos los datos para el servidor en la variable serverData
        var serverData = {
            descripcion: calendarEditor.val() || 'N/A',
            inicio: startDate.val(),
            fin: startDate.val(), // Aseguramos que fin tenga un valor
            tipo_v: selectedType,
            estatus: '1',
            // Usamos los datos extra que recolectamos
            ...extraData 
        };
      
        //console.log('Datos enviados al servidor:', serverData);
        
        // <-- CAMBIO CLAVE: Llamamos a addEvent con serverData -->
        addEvent(serverData);
      
        // Cerrar la barra lateral
       sidebar.modal('hide');

        $('.event-sidebar').removeClass('show');
        $('.app-calendar .body-content-overlay').removeClass('show');
    }
});

  // Evento para actualizar un evento existente
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

      // Actualizar el evento a través de AJAX
      updateEvent(eventData);
      
      // Cerrar la barra lateral
      sidebar.modal('hide');
      $('.event-sidebar').removeClass('show');
      $('.app-calendar .body-content-overlay').removeClass('show');
    }
  });

  // ========================================
  // FUNCIONES AUXILIARES
  // ========================================
  
// Función para resetear los valores del formulario
function resetValues() {
   
//  console.log('Reseteando valores del formulario');
  endDate.val('');
  eventUrl.val('');
  startDate.val('');
  eventTitle.val('');
  eventLocation.val('');
  allDaySwitch.prop('checked', false);
  eventGuests.val('').trigger('change');
  calendarEditor.val('');
  
  // Limpiar campos dinámicos
  cantidad.val('');
  selectCliente.val(null).trigger('change');
  
  // Ocultar campos dinámicos
  dynamicFieldsContainer.addClass('d-none');
  clienteContainer.addClass('d-none');
  cantidadContainer.addClass('d-none');
  
  // Resetear selector de etiquetas
  eventLabel.val(null).trigger('change');
}


sidebar.on('hidden.bs.modal', function () {
    resetValues();
});

  // Evento para ocultar la barra lateral izquierda si la derecha está abierta
  $('.btn-toggle-sidebar').on('click', function () {
    btnDeleteEvent.addClass('d-none');
    updateEventBtn.addClass('d-none');
    addEventBtn.removeClass('d-none');
    $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
  });

  // ========================================
  // FUNCIONALIDAD DE FILTROS
  // ========================================
  
  // Evento para seleccionar/deseleccionar todos los filtros
  if (selectAll.length) {
    selectAll.on('change', function () {
      var $this = $(this);

      if ($this.prop('checked')) {
        calEventFilter.find('input').prop('checked', true);
      } else {
        calEventFilter.find('input').prop('checked', false);
      }
      calendar.refetchEvents(); // Recargar eventos con los filtros aplicados
    });
  }

  // Evento para cambiar filtros individuales
  if (filterInput.length) {
    filterInput.on('change', function () {
      // Actualizar estado del checkbox "seleccionar todo"
      $('.input-filter:checked').length < calEventFilter.find('input').length
        ? selectAll.prop('checked', false)
        : selectAll.prop('checked', true);
      calendar.refetchEvents(); // Recargar eventos con los filtros aplicados
    });
  }
});


// Añade este código después de la inicialización del calendario
 $(document).ready(function() {
  // Manejar el cierre del modal con el botón X
  $('.close').on('click', function() {
    $(this).closest('.modal').modal('hide');
  });
  
  // Manejar el cierre del modal con el botón "Cerrar"
  $('[data-dismiss="modal"]').on('click', function() {
    $(this).closest('.modal').modal('hide');
  });
});


