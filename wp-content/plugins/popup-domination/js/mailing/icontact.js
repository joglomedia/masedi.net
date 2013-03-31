;(function($){
	$(document).ready(function(){
		$('#popup_domination_tab_icontact .required').each(function(){
			$(this).blur(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
				} else {
					$(this).removeClass('input-error');
				}
			});
		});
		$('.ic_getlist').click(function(){
			var error = false;
			$('#popup_domination_tab_icontact .required').each(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
				}
			});
			$('#popup_domination_tab_icontact .input-error').each(function(){
				error = true;
			});
			if (!error){
				ic_mail_list();
			} else {
				alert('Please fill in the missing fields');
				return false;
			}
		});
	});
	function ic_mail_list(){
		$('.mailing-ajax-waiting').show();
		var api_id = $('#ic_apikey').val();
		var password = $('#ic_password').val();
		var username = $('#ic_username').val();
		var data = {
			action: 'popup_domination_mailing_client',
			provider: 'ic',
			apikey: api_id,
			password : password,
			username : username
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('.mailing-ajax-waiting').hide();
			$('.mailingfeedback').empty();
			$('.mailingfeedback').append(response);
			$('#form .provider').val('ic');
			$('#form .apikey').val(api_id);
			$('#form .username').val(username);
			$('#form .password').val(password);
			var list = $('.mailing_lists').val();
			$('.listid').val(list);
		});
	}
})(jQuery);