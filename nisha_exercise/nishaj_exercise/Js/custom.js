(function ($, Drupal) {
    Drupal.behaviors.customFormBehavior = {
      attach: function (context, settings) {
        $(document).ready(function () {
          $('.address-checkbox', context).change(function() {
            var isPermanentChecked = $('#edit-permanent-address', context).is(':checked');
            var isTemporaryChecked = $('#edit-temporary-address', context).is(':checked');

            if (isPermanentChecked) {
              $('.form-item-temporary-address', context).hide();
              $('.form-item-permanent-address', context).show();
            }

            if (isTemporaryChecked) {
              $('.form-item-permanent-address', context).hide();
              $('.form-item-temporary-address', context).show();
            }
          });
        });
      }
    };
  })(jQuery, Drupal);

  (function ($, Drupal) {

    $.fn.datacheck = function() {
        alert(" form working");
        $(".custom_form_user_details").submit();
    };

}(jQuery, Drupal));

// (function($, Drupal, drupalSettings) {
//   Drupal.behaviors.MyModuleBehavior = {
//       attach: function(context, settings) {
//           // get color_body value with "drupalSettings.mymodule.color_body"
//           var color_body = drupalSettings.nishaj_exercise.color_body;
//           alert(color_body)
//           $('body').css('background', color_body);
//       }
//   };
// })(jQuery, Drupal, drupalSettings);

(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.customModuleBehavior = {
    attach: function (context, settings) {
      var customVariable = drupalSettings.nishaj_exercise.customVariable;

      console.log(customVariable);
    }
  };
})(jQuery, Drupal, drupalSettings);