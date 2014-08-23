//events
$(document).ready(function() {
    //scroll event
    $(document).scroll(function() {
        if ($(document).scrollTop() == 0){
            scroll_hide();
        }
        else{
        	if ($(document).height() - $(window).height() > 75){
        		scroll_show();
        	}
        }
    });
});

scroll_show = function(){
    $(".scroll-effect").addClass("scroll");
};
scroll_hide = function(){
    $(".scroll-effect").removeClass("scroll");
};

function change_font(elem){
	document.getElementById('main').style.fontFamily = elem.value; 
}