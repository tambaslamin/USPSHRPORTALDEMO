jQuery(document).ready(function() {
    jQuery('.field--name-user-picture a').hover(function () {
        jQuery('.user-menu-global').show();//hover on
    });
    jQuery(document).mouseup(function(e) {
        var container = jQuery(".user-menu-global");
        if (!".user-menu-global".is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
    });
});
