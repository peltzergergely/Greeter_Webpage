$(document).ready(function(){
	$('.search_icon').hover(function(){
		$(this).toggleClass('search_icon_hover');
	});
	
	$('.sms').hover(function(){
		$(this).toggleClass('sms_hover');
	});
	
	$('.filter_box').hover(function(){
		$(this).toggleClass('filter_box_hover');
	});
	
	$('.lang').hover(function(){
		$(this).toggleClass('lang_hover');
	});
	
	$('.submit_sms').hover(function(){
		$(this).toggleClass('submit_sms_hover');
	})
});