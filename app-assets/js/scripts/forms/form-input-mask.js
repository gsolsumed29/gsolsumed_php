/*=========================================================================================
        File Name: form-input-mask.js
        Description: Input Masks
        ----------------------------------------------------------------------------------------
        Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
        Author: Pixinvent
        Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var creditCard = $('.credit-card-mask'),
    phoneMask = $('.phone-number-mask'),
    dateMask = $('.date-mask'),
    timeMask = $('.time-mask'),
    numeralMask = $('.numeral-mask'),
    numeralMaskcliente = $('.numeral-mask-cliente'),
    numeralMaskvida = $('.numeral-mask-vida'),
    blockMask = $('.block-mask'),
    delimiterMask = $('.delimiter-mask'),
    customDelimiter = $('.custom-delimiter-mask'),
    prefixMask = $('.prefix-mask');

  // Credit Card
  if (creditCard.length) {
    creditCard.each(function () {
      new Cleave(creditCard, {
        creditCard: true
      });
    });
  }

  // Phone Number
  if (phoneMask.length) {
    new Cleave(phoneMask, {
      phone: true,
      phoneRegionCode: 'US'
    });
  }

  // Date
  if (dateMask.length) {
    new Cleave(dateMask, {
      date: true,
      delimiter: '-',
      datePattern: ['Y', 'm', 'd']
    });
  }

  // Time
  if (timeMask.length) {
    new Cleave(timeMask, {
      time: true,
      timePattern: ['h', 'm', 's']
    });
  }

  //Numeral
  if (numeralMask.length) {
    new Cleave(numeralMask, {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });
  }

    //Numeral
    if (numeralMaskcliente.length) {
      new Cleave(numeralMaskcliente, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
      });
    }

     //Numeral
     if (numeralMaskvida.length) {
      new Cleave(numeralMaskvida, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
      });
    }

  //Block
  if (blockMask.length) {
    new Cleave(blockMask, {
      blocks: [4, 3, 3],
      uppercase: true
    });
  }

  // Delimiter
  if (delimiterMask.length) {
    new Cleave(delimiterMask, {
      delimiter: '·',
      blocks: [3, 3, 3],
      uppercase: true
    });
  }

  // Custom Delimiter
  if (customDelimiter.length) {
    new Cleave(customDelimiter, {
      delimiters: ['.', '.', '-'],
      blocks: [3, 3, 3, 2],
      uppercase: true
    });
  }

  // Prefix
  if (prefixMask.length) {
    new Cleave(prefixMask, {
      prefix: '+63',
      blocks: [3, 3, 3, 4],
      uppercase: true
    });
  }
});
