(function ($, Drupal) {
  Drupal.behaviors.uspshrdemoUserMenu = {
    attach: function (context, settings) {
      $('.region-global-myaccount-top', context).click (
        function(e) {
          e.preventDefault();
          e.stopPropagation();
          $('.user-menu-global').show();
        }
      );
      $(window).click(function(e) {
        $('.user-menu-global').hide();
      });
    }
  };
})(jQuery, Drupal);
