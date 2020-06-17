jQuery(document).ready(function($) {
    $('.field--name-user-picture a').hover(function () {
        $('.user-menu-global').show();//hover on
    });
    jQuery(document).mouseup(function(e) {
        var container = $(".user-menu-global");
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
    });
});
