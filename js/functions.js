jQuery(document).ready(function(){
    jQuery("#btn-tclap").click(function () {
        post_id = jQuery(this).attr("data-post_id")
        var $this = jQuery(this);

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
            }
            else{
                console.log('tclap error on server.');
            }
        })
  });
});