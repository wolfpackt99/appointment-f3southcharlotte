jQuery(document).ready(function (Cookies) {
    'use strict';
    var tclapsEnablement = function () {
        var btn = jQuery("#btn-tclap");
        var post_id = btn.data("post_id");
        var tclapped = Cookies.getJSON('tclaps');
        var date = {};

        function enableClick(e) {
            var $this = jQuery(this);
            e.preventDefault();
            var thumbs = $this.find(".fa.fa-thumbs-up");
            var spinner = $this.find(".fa.fa-spinner");

            function showSpinner(show) {
                if (show) {
                    thumbs.hide();
                    spinner.show();
                } else {
                    thumbs.show();
                    spinner.hide();
                }
            }

            if (!tclapped[post_id]) {
                $this.attr("disabled", "disabled");
                showSpinner(true);
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: myAjax.ajaxurl,
                    data: {
                        action: "my_user_tclap",
                        post_id: post_id
                    }
                }).done(function (response) {
                    if (response.data.type === 'success') {
                        $this.find('.tclap-counter').html(response.data.tclaps);
                        $this.attr("disabled", "disabled");
                        tclapped[post_id] = true;
                        Cookies.set('tclaps', tclapped, {
                            expires: new Date(tclapped.thedate)
                        });
                    } else {
                        $this.removeAttr("disabled");
                    }
                }).always(function () {
                    showSpinner(false);
                });
            }
        }

        function init() {
            date = new Date();
            date.setDate(date.getDate() + 7);
            if (!tclapped) {
                tclapped = {};
                tclapped.thedate = date;
            }
            if (!tclapped.thedate) {
                tclapped.thedate = date;
            }
            if (btn.length > 0) {
                if (tclapped[post_id]) {
                    btn.attr("disabled", "disabled");
                } else {
                    btn.click(enableClick);
                }
            }
        }

        init();
    };

    tclapsEnablement();
}(Cookies));