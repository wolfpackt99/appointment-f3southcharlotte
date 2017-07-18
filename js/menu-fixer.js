if(!window.HashChangeEvent)(function(){
	var lastURL=document.URL;
	window.addEventListener("hashchange",function(event){
		Object.defineProperty(event,"oldURL",{enumerable:true,configurable:true,value:lastURL});
		Object.defineProperty(event,"newURL",{enumerable:true,configurable:true,value:document.URL});
		lastURL=document.URL;
	});
}());

jQuery(document).ready(function() {
    function locationHashChanged() {
        addHighlight();
    }

    window.onhashchange = locationHashChanged;
    function addHighlight(){

        jQuery("#menu-main li").removeClass("active").each(function(i,item){
            var $this = jQuery(item);
            if ($this.find("a").attr("href") == window.location){
                $this.addClass("active");
            }
        });
    }
    addHighlight();
});