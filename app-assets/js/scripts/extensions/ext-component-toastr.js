/*=========================================================================================
	File Name: ext-component-toastr.js
	Description: Toastr notifications
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var isRtl = $('html').attr('data-textdirection') === 'rtl',
    typeSuccess = $('#type-success'),
    typeInfo = $('#type-info'),
    typeWarning = $('#type-warning'),
   
    positionTopLeft = $('#position-top-left'),
    positionTopCenter = $('#position-top-center'),
    positionTopRight = $('#position-top-right'),
    positionTopFull = $('#position-top-full'),
    positionBottomLeft = $('#position-bottom-left'),
    positionBottomCenter = $('#position-bottom-center'),
    positionBottomRight = $('#position-bottom-right'),
    positionBottomFull = $('#position-bottom-full'),
    progressBar = $('#progress-bar'),
    clearToastBtn = $('#clear-toast-btn'),
    fastDuration = $('#fast-duration'),
    slowDuration = $('#slow-duration'),
    toastrTimeout = $('#timeout'),
    toastrSticky = $('#sticky'),
    slideToast = $('#slide-toast'),
    fadeToast = $('#fade-toast'),
    clearToastObj;

  // Success Type
  typeSuccess.on('click', function () {
    toastr['success']('👋 Jelly-o macaroon brownie tart ice cream croissant jelly-o apple pie.', 'Success!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });



  // Error Type
  typeError.on('click', function () {
    toastr['error']('👋 Jelly-o marshmallow marshmallow cotton candy dessert candy.', 'Error!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });


});
