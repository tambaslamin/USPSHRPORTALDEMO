/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.uspshrdemo = {
    attach: function (context, settings) {
      // megamenu mobile
      jQuery(".navbar-toggler").click(function () {
        jQuery("ul.sf-menu.sf-accordion").toggleClass("sf-hidden");
        jQuery("ul.sf-menu.sf-accordion").toggleClass("sf-expanded");
      });
    }
  };

})(jQuery, Drupal);
