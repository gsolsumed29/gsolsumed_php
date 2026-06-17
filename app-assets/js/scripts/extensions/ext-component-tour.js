/*=========================================================================================
	File Name: tour.js
	Description: tour
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var startBtn = $('#tour');
  function setupTour(tour) {
    var backBtnClass = 'btn btn-sm btn-outline-primary',
      nextBtnClass = 'btn btn-sm btn-primary btn-next';
      tour.addStep({
        title: 'Menú Principal',
        text: 'Representa la totalidad de las funciones del sistema, en él podemos encontrar todos los accesos a las diferentes funciones tales como : Pólizas, Contratos, Clientes, Pagos.',
        attachTo: { element: '.main-menu', on: 'bottom' },
        buttons: [
          {
            action: tour.cancel,
            classes: backBtnClass,
            text: 'Saltar'
          },
         
          {
            text: 'Siguiente',
            classes: nextBtnClass,
            action: tour.next
          }
        ]
      });
      tour.addStep({
      title: 'Menú secundario',
      text: 'Se presenta como una alternativa rápida para realizar tareas que ameritan una mayor agilidad y capacidad de respuesta  de izquierda a derecha podemos identificarlos como :<br> Agregar cliente <br> Agregar póliza de vehiculos <br> Agregar póliza de inmueble <br>Agregar póliza de otro | vida <br> Agregar póliza de patrimonio <br> Agregar póliza personal ',
      attachTo: { element: '.navbar', on: 'bottom' },
      buttons: [
        {
          action: tour.cancel,
          classes: backBtnClass,
          text: 'Saltar'
        },
        {
          text: 'Atras',
          classes: backBtnClass,
          action: tour.back
        },
        {
          text: 'Siguiente',
          classes: nextBtnClass,
          action: tour.next
        }
      ]
    });

    tour.addStep({
      title: 'Notificaciones',
      text: 'Las notificaciones, solo apareceran si la fecha acordada en el contrato, corresponde con la fecha actual del sistema.',
      attachTo: { element: '.dropdown-notification', on: 'bottom' },
      buttons: [
        {
          action: tour.cancel,
          classes: backBtnClass,
          text: 'Saltar'
        },
        {
          text: 'Atras',
          classes: backBtnClass,
          action: tour.back
        },
        {
          text: 'Siguiente',
          classes: nextBtnClass,
          action: tour.next
        }
      ]
    });
    tour.addStep({
      title: 'Espacio de trabajo',
      text: 'Como su nombre lo indica, es un area donde se realizan la totalidad de funciones, en éste, podemos realizar tareas de registro, modificación, búsqueda y eliminacion de todo el contenido referente a pólizas, contratos,pagos.',
      attachTo: { element: '#basic-tour .card', on: 'top' },
      buttons: [
        {
          text: 'Saltar',
          classes: backBtnClass,
          action: tour.cancel
        },
        {
          text: 'Atras',
          classes: backBtnClass,
          action: tour.back
        },
        {
          text: 'Siguiente',
          classes: nextBtnClass,
          action: tour.next
        }
      ]
    });
    
    tour.addStep({
      title: 'Pie de página',
      text: 'Tiene como función mostrar al usuario información relevante a la organización.',
      attachTo: { element: '.footer', on: 'top' },
      buttons: [
        {
          text: 'Atras',
          classes: backBtnClass,
          action: tour.back
        },
        {
          text: 'Finalizar',
          classes: nextBtnClass,
          action: tour.cancel
        }
      ]
    });

   

    return tour;
  }

  if (startBtn.length) {
    startBtn.on('click', function () {
      var tourVar = new Shepherd.Tour({
        defaultStepOptions: {
          classes: 'shadow-md bg-purple-dark',
          scrollTo: false,
          cancelIcon: {
            enabled: true
          }
        },
        useModalOverlay: true
      });

      setupTour(tourVar).start();
    });
  }
});
