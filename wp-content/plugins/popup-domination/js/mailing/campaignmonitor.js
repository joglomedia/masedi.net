;(function($){
	$(document).ready(function(){
		$('#popup_domination_tab_campaignmonitor .required').each(function(){
			$(this).blur(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
				} else {
					$(this).removeClass('input-error');
				}
			});
		});
		
		$('.cm_getlist').click(function(){
			var error = false;
			$('#popup_domination_tab_campaignmonitor .required').each(function(){
				if ($(this).val().length == 0) {
					$(this).addClass('input-error');
				} else {
					$(this).removeClass('input-error');
				}
			});
			$('#popup_domination_tab_campaignmonitor .input-error').each(function(){
				error = true;
			});
			if (!error){
				cm_mail_list();
			} else {
				alert('Please fill in your ClientID and API Key');
				return false;
			}
		});
		
		
		$('#cm_custom_select').change(function(){
			$('.cm .cm_custom_fields').empty();
			$('.custom1, .custom2').hide();
			var num = $(this).val();
			var i = 1;
			while(i<=num){
				$('.custom'+i).show();
				i++;
			}
			$('.customf').val(i - 1);
		});
	});
	function cm_mail_list(){
		$('.mailing-ajax-waiting').show();
		var api_id = $('#cm_apikey').val();
		var client_id = $('#cm_clientid').val();
		var data = {
			action: 'popup_domination_mailing_client',
			api_key: api_id,
			client_id : client_id,
			provider: 'cm'
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('.mailing-ajax-waiting').hide();
			$('.mailingfeedback').empty();
			$('.mailingfeedback').append(response);
			$('#form .provider').val('cm');
			$('#form .apiextra').val(client_id);
			$('#form .apikey').val(api_id);
			var list = $('.mailing_lists').val();
			$('.listid').val(list);
		});
	}
})(jQuery);