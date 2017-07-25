jQuery(document).ready(function(){
    
    var tclapsEnablement = function(){
        var btn = jQuery("#btn-tclap");
        var post_id = btn.data("post_id");
        var tclapped = Cookies.getJSON('tclaps');
        if (!tclapped) tclapped = {};

        function init(){
            if(btn.length >0){
                if (tclapped[post_id])
                {
                    btn.attr("disabled","disabled");
                }
                else{
                    btn.click(enableClick);
                }
            }
        }

        function enableClick(e)
        {
            var $this = jQuery(this);
            e.preventDefault();
            var thumbs = $this.find(".fa.fa-thumbs-up");
            var spinner = $this.find(".fa.fa-spinner");
            if (!tclapped[post_id]){
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
                        tclapped[post_id] = true;
                        Cookies.set('tclaps', tclapped, { expires: 14 });
                    }
                    else{
                        $this.removeAttr("disabled");
                        console.log('tclap error on server.');
                    }

                }).always(function(){
                    showSpinner(false);
                });
            }

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
        }      
        init(); 
    };

    tclapsEnablement();
});