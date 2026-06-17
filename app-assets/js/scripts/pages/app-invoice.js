
$(function () {
  'use strict';

  var applyChangesBtn = $('.btn-apply-changes'),
    discount,
    tax1,
    tax2,
    discountInput,
    tax1Input,
    tax2Input,
    sourceItem = $('.source-item'),
    btnAddNewItem = $('.btn-add-new ')
  






  // Repeater init
  if (sourceItem.length) {

    sourceItem.repeater({
      show: function () {
        $(this).slideDown();
      },
      hide: function (e) {
        $(this).slideUp();
      }
    });
  }


  // On tax change update it's value
  function updateValue(listener, el) {
    listener.closest('.repeater-wrapper').find(el).text(listener.val());
  }

  // Apply item changes btn
  if (applyChangesBtn.length) {
    $(document).on('click', '.btn-apply-changes', function (e) {
      var $this = $(this);
      tax1Input = $this.closest('.dropdown-menu').find('#tax-1-input');
      tax2Input = $this.closest('.dropdown-menu').find('#tax-2-input');
      discountInput = $this.closest('.dropdown-menu').find('#discount-input');
      tax1 = $this.closest('.repeater-wrapper').find('.tax-1');
      tax2 = $this.closest('.repeater-wrapper').find('.tax-2');
      discount = $('.discount');

      if (tax1Input.val() !== null) {
        updateValue(tax1Input, tax1);
      }

      if (tax2Input.val() !== null) {
        updateValue(tax2Input, tax2);
      }

      if (discountInput.val().length) {
        var finalValue = discountInput.val() <= 100 ? discountInput.val() : 100;
        $this
          .closest('.repeater-wrapper')
          .find(discount)
          .text(finalValue + '%');
      }
    });
  }

  if (btnAddNewItem.length) {
    btnAddNewItem.on('click', function () {
      if (feather) {
        // featherSVG();
        feather.replace({ width: 14, height: 14 });
      }
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  }
});
