(function ($, Drupal) {
  Drupal.behaviors.uspshrdemoUserMenu = {
    attach: function (context, settings) {
      $(window).click(function(e) {
        $('.user-menu-global').hide();
      });
      $('.region-global-myaccount-top', context).hover (
        function(e) {
          $('.user-menu-global').css("display", "block");
        }
      );
    }
  };
})(jQuery, Drupal);
