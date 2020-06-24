(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      jQuery(document).ready(function() {
        var $userMenu = jQuery('.user-menu-global');
        jQuery('.field--name-user-picture', context).hover(
          function () {
            $userMenu.show();//hover on
          },
          function () {
            $userMenu.hide();//hover off
          }
        );
      });
    }
  };
})(jQuery, Drupal);
