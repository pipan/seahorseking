function ImageViewer(){
	this.image = 0;
	this.padding = 50;
	
	this.getImage = function(){
		return $('.gallery-view:eq(' + this.image + ') img');
	}
	this.getView = function(){
		return $('.gallery-view:eq(' + this.image + ')');
	}
	this.show = function(){
		if (this.image >= 0){
			var src = $(this.getImage()).prop('src');
			$('#image-viewer > img').attr('src', src);
			this.center();
		}
	};
	this.start = function(image){
		this.image = image;
		$('#popup-bg').show();
		$('#image-viewer').show();
		this.show();
	};
	this.end = function(){
		$('#popup-bg').hide();
		$('#image-viewer').hide();
	};
	this.next = function(){
		this.image++;
		if (this.image >= $('.gallery-view').length){
			this.image = 0;
		}
		this.show();
	};
	this.previous = function(){
		this.image--;
		if (this.image < 0){
			this.image = $('.gallery-view').length - 1;
		}
		this.show();
	};
	this.center = function(){
		$('#image-viewer > img').css({width: 'auto', height: 'auto'});
		width = $('#image-viewer > img').width();
		height = $('#image-viewer > img').height();
		if (height + 2 * this.padding > $(window).height()){
			shrink = ($(window).height() - 2 * this.padding) / height; 
			height *= shrink;
			width *= shrink;
		}
		if (width + 2 * this.padding > $(window).width()){
			shrink = ($(window).width() - 2 * this.padding) / width; 
			height *= shrink;
			width *= shrink;
		}
		$('#image-viewer > img').css({width: width, height: height});
		$('#image-viewer').css({left: (($(window).width() - width) / 2), top: (($(window).height() - height) / 2)});
	};
}

var viewer = new ImageViewer();
/*
$(document).ready(function(){
	$(".gallery-view").click({image: this}, viewer.start);
});
*/