(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      jQuery(document).ready(function () {
        jQuery(".vertical-tabs__menu-item").click(function (){
          if (jQuery(".vertical-tabs__menu-item.first").hasClass("is-selected")) {
            jQuery(".profile .field--name-user-picture").show();
          } else {
            jQuery(".profile .field--name-user-picture").hide();
          }
        });
      });
    }
  };
})(jQuery, Drupal);
