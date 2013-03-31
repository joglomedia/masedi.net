;(function($){
	$(document).ready(function(){
		$('.fancybox').fancybox({
			'type': 'iframe',
			'width': '75%',
			'height': '75%'
		});
		$('.cc_getlist').click(function(){
			cc_mail_list();	
		});
		$('#cc_custom_select').change(function(){
			$('#cc_custom2').hide();
			var num = $(this).val();
			var i = 1;
			while(i<=num){
				$('#cc_custom'+i).show();
				i++;
			}
			$('.customf').val(i - 1);
		});
		$('#cc_custom1').change(function(){
			val = $(this).val();
			$('.custom1').val(val);
		});
		$('#cc_custom2').change(function(){
			val = $(this).val();
			$('.custom2').val(val);
		});
	});
	function cc_mail_list(){
		$('.mailing-ajax-waiting').show();
		var api_id = $('.cc_apikey').val();
		var username = $('.cc_username').val();
		var secret = $('.cc_usersecret').val();
		var data = {
			action: 'popup_domination_mailing_client',
			provider: 'cc',
			token_key: api_id,
			username : username,
			user_secret : secret
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('.mailing-ajax-waiting').hide();
			$('.mailingfeedback').empty();
			$('.mailingfeedback').append(response);
			$('#form .provider').val('cc');
			$('#form .apikey').val(api_id);
			$('#form .username').val(username);
			$('#form .password').val($('.cc_password').val());
			$('#form .apiextra').val($('.cc_usersecret').val());
			var list = $('.mailing_lists').val();
			$('.listid').val(list);
		});
	}
})(jQuery);