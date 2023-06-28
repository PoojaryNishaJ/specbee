(function ($, Drupal, drupalSettings) {

  $(document).ready(function() {

    var checkbox = $('#edit-check');
    var temporaryAddressFields = $('.form-item-temporary');

    checkbox.on('change', function() {
          if ($(this).is(':checked')) {
        temporaryAddressFields.hide();
      } else {

        temporaryAddressFields.show();
      }
    });
  });

    $.fn.datacheck = function() {
      alert("working");
      $("#custom-user-details-form").submit();
  };

    Drupal.behaviors.MyModuleBehavior = {
      attach: function(context, settings) {
          // get color_body value with "drupalSettings.mymodule.color_body"
          var color_body = drupalSettings.nishaj_exercise.color_body;
          alert(color_body)
          $('body').css('background', color_body);
      }
  };

  Drupal.behaviors.customModuleBehavior = {
    attach: function (context, settings) {
      var customVariable = drupalSettings.nishaj_exercise.customVariable;

      console.log(customVariable);
    }
  };

  })(jQuery, Drupal, drupalSettings);
