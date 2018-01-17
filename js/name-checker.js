jQuery(document).ready(function () {
    'use strict';
    var label = jQuery("label:contains('F3 Name')");
    //label.append(" (<a href='#' id='nameChecker'>check availability</a>)");
    jQuery("#nameChecker").click(function () {
        var btn = jQuery(this);
        query(btn);
    });

    function query(btn) {
        var txtbox = jQuery("input[name='F3NAME']");
        jQuery.get('https://f3sclt.apphb.com/newsletter/findsimilar', {
                name: txtbox.val()
            })
            .success(function (data) {
                jQuery("#nameWarning").remove();
                var ul = "<div id='nameWarning' class='alert alert-warning' style='margin-top: 10px;'>";
                var parent = btn.parent(".form-group");
                parent.removeClass("has-success has-warning");
                if (data.length === 0) {
                    ul += "name is available";
                } else {
                    ul += "<p>Found matches:</p><ul>";
                    jQuery.each(data, function (i, item) {
                        ul += "<li>" + item.F3Name + " - " + item.FirstName + "</li>";
                    });
                    ul += "</ul>";
                }
                ul += "</div>";
                txtbox.after(ul);
            });
    }
});