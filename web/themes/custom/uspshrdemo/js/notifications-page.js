(function ($, Drupal) {
  Drupal.behaviors.notificationsPage = {
    attach: function (context, settings) {

      // Expand actions.
      $('.toggle-actions', context).click(
        function(e) {
          if ($(this).parents('.notification-row').hasClass('actions-open')) {
            $(this).parents('.notification-row').removeClass('actions-open'); // close actions
          }
          else {
            $(this).parents('.notification-row').addClass('actions-open'); // open actions
          }
        }
      );
      

      // Archive.
      $('.btn.notification-archive', context).click(
        function(e) {
          var data_id = $(this).parent().attr('data-id');
          $('.notification-items[data-id="' + data_id + '"]').removeClass('unread');
        }
      );

      // Remove.
      $('.btn.notification-remove', context).click(
        function(e) {
          var data_id = $(this).parent().attr('data-id');
          $('.notification-items[data-id="' + data_id + '"]').remove();
        }
      );
      
    }
  };
})(jQuery, Drupal);
