jQuery(document).ready(function(){
    jQuery("#btn-tclap").click(function (e) {
        e.preventDefault();
        post_id = jQuery(this).attr("data-post_id")
        var $this = jQuery(this);
        var thumbs = $this.find(".fa.fa-thumbs-up");
        var spinner = $this.find(".fa.fa-spinner");
        $this.attr("disabled","disabled");
        showSpinner(true);
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: {
                action: "my_user_tclap",
                post_id: post_id
            }
        }).done(function(response){
            if (response.data.type ==='success'){
                $this.find('.tclap-counter').html(response.data.tclaps);
                $this.attr("disabled","disabled");
            }
            else{
                $this.removeAttr("disabled");
                console.log('tclap error on server.');
            }

        }).always(function(){
            showSpinner(false);
        });

        function showSpinner(show)
        {
            if (show){
                thumbs.hide()
                spinner.show();
            }
            else{
                thumbs.show();
                spinner.hide();
            }
        }
  });
});