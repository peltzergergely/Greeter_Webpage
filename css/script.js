$(document).ready(function(){
	$(".submit_sms").click(function () {

		$header = $(this);
		//getting the next element
		$content = $header.next();
		//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
		$content.slideToggle(function () {
			//execute this after slideToggle is done
			//change text of header based on visibility of content div
			});
		});
	
/*		$(".add_item").click(function () {

		$header = $(this);
		//getting the next element
		$content = $header.next();
		//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
		$content.slideToggle(function () {
			//execute this after slideToggle is done
			//change text of header based on visibility of content div
			});
		});
		
	$(".edit_button").click(function () {

		$header = $(this);
		//getting the next element
		$content = $header.next();
		//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
		$content.slideToggle(function () {
			//execute this after slideToggle is done
			//change text of header based on visibility of content div
			});
		});
	
		$(".add_item").click(function () {

		$header = $(this);
		//getting the next element
		$content = $header.next();
		//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
		$content.slideToggle(function () {
			//execute this after slideToggle is done
			//change text of header based on visibility of content div
			});
		});*/
		
		// --------------------- WEBPAGE SUBMIT FORM ---------------------
		
		$(".submit_web").click(function () {

		$header = $(this);
		//getting the next element
		$content = $header.next();
		//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
		$content.slideToggle(function () {
			//execute this after slideToggle is done
			//change text of header based on visibility of content div
			});
		});
	
		
		
		
(function($) {
    $.fn.flash_message = function(options) {
      
      options = $.extend({
        text: 'Done',
        time: 1000,
        how: 'before',
        class_name: ''
      }, options);
      
      return $(this).each(function() {
        if( $(this).parent().find('.flash_message').get(0) )
          return;
        
        var message = $('<span />', {
          'class': 'flash_message ' + options.class_name,
          text: options.text
        }).hide().fadeIn('fast');
        
        $(this)[options.how](message);
        
        message.delay(options.time).fadeOut('normal', function() {
          $(this).remove();
        });
        
      });
    };
})(jQuery);

$('.add-item').click(function() {

    $('#status-area').flash_message({
        text: 'Köszönjük!',
        how: 'append'
    });
	
});
});