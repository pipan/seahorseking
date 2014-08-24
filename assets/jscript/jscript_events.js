//events
$(document).ready(function() {
	//see height of content
	if ($("#menu").height() > $("#content").height()){
		$("#content").height($("#menu").height());
	}
    //scroll event
    $(document).scroll(function() {
        if ($(document).scrollTop() == 0){
        	effect = is_scroll_effect();
            scroll_hide();
            if (effect){
            	$(document).scrollTop(75);
            }
            
        }
        else{
        	effect = is_scroll_effect();
        	if ($(document).scrollTop() > 75){
        		scroll_show();
        		if (!effect){
                	$(document).scrollTop(1);
                }
        	}
        }
    });
});

is_scroll_effect = function(){
	if ($(".scroll")[0]){
		return true;
	}
	return false;
};
scroll_show = function(){
    $(".scroll-effect").addClass("scroll");
};
scroll_hide = function(){
    $(".scroll-effect").removeClass("scroll");
};

function change_font(elem){
	document.getElementById('main').style.fontFamily = elem.value; 
}