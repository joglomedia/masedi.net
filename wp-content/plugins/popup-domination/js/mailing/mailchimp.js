;(function($){
	$(document).ready(function(){
		$('#mc_apikey').blur(function(){
			if ($(this).val().length == 0){
				$(this).addClass('input-error');
			} else {
				$(this).removeClass('input-error');
			}
		});
		$('#popup_domination_tab_mailchimp .mc_getlist').click(function(){
			var error = false;
			if ($('#mc_apikey').val().length == 0){
				$('#mc_apikey').addClass('input-error');
			}
			$('#popup_domination_tab_mailchimp .input-error').each(function(){
				error = true;
			});
			if (!error){
				mc_mail_list();
			} else {
				alert('Please fill in your API key.');
				return false;
			}
		});
	});
	function mc_mail_list(){
		$('.mailing-ajax-waiting').show();
		var api_id = $('#mc_apikey').val();
		var data = {
			action: 'popup_domination_mailing_client',
			api_key: api_id,
			provider: 'mc'
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('.mailing-ajax-waiting').hide();
			$('.mailingfeedback').empty();
			$('.mailingfeedback').append(response);
			$('#form .provider').val('mc');
			$('#form .apikey').val(api_id);
			var list = $('.mailing_lists').val();
			$('.listid').val(list);
		});
	}
})(jQuery);