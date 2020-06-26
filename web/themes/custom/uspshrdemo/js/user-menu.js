(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      jQuery(document).ready(function() {
        jQuery('.region-global-myaccount-top .field--name-user-picture', context).hover(
          function () {
            jQuery('.user-menu-global').show();//hover on
          },
          function () {
            jQuery('.user-menu-global').hide();//hover off
          }
        );
      });
    }
  };
})(jQuery, Drupal);
