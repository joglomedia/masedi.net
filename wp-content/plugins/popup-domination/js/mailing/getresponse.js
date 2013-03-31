;(function($){
	$(document).ready(function(){
		$('#popup_domination_tab_getresponce .required').each(function(){
			$(this).blur(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
				} else {
					$(this).removeClass('input-error');
				}
			});
		});
		$('.gr_getlist').click(function(){
			var error = false;
			$('#popup_domination_tab_getresponce .required').each(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
				}
			});
			$('#popup_domination_tab_getresponce .input-error').each(function(){
				error = true;
			});
			if (!error){
				gr_mail_list();
			} else {
				alert('Please fill in your API Key.');
				return false;
			}
		});
	});
	function gr_mail_list(){
		$('.mailing-ajax-waiting').show();
		var api_id = $('#gr_apikey').val();
		var data = {
			action: 'popup_domination_mailing_client',
			api_key: api_id,
			provider: 'gr'
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('.mailing-ajax-waiting').hide();
			$('.mailingfeedback').empty();
			$('.mailingfeedback').append(response);
			$('#form .provider').val('gr');
			$('#form .apikey').val(api_id);
			var list = $('.mailing_lists').val();
			$('.listid').val(list);
		});
	}
})(jQuery);