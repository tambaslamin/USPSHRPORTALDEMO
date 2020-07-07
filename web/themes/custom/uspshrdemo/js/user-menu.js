(function ($, Drupal) {
  Drupal.behaviors.uspshrdemoUserMenu = {
    attach: function (context, settings) {
      $(window).click(function(e) {
        $('.user-menu-global').hide();
      });
      $('.region-global-myaccount-top', context).hover (
        function(e) {
          $('.user-menu-global').css("display", "block");
          $('#superfish-account-accordion').removeClass("sf-hidden");
          $('#superfish-account-accordion').css("display", "block");
          $('#superfish-account-accordion').css("position", "relative");
        }
      );
    }
  };
})(jQuery, Drupal);
