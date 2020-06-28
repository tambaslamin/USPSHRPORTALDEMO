(function ($, Drupal) {
  Drupal.behaviors.uspshrdemoUserMenu = {
    attach: function (context, settings) {
      $('.region-global-myaccount-top', context).hover(
        function(e) {
          $('.user-menu-global').show(); //hover on
        },
        function(e) {
          $('.user-menu-global').hide(); //hover off
        }
      );
    }
  };
})(jQuery, Drupal);
