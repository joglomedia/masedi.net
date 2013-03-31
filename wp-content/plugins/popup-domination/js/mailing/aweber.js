;(function($){
	$(document).ready(function(){
		$('.aw_getlist').click(function(){
			aw_mail_list();	
		});
		$('#popup_domination_tab_aweber .aweber_cookieclear').click(function(){
			$('.popdom_contentbox_inside .waiting').show();
			var str = popup_domination_url;
			var str2 = str.split(website_url+'/');
			var f = str2[1];
			var data = {
				action: 'popup_domination_aweber_cookies',
				wpurl: f,
				wpnonce: $('#_wpnonce').val()
			};
			jQuery.post(popup_domination_admin_ajax, data, function(response) {
				$('.popdom_contentbox_inside .waiting').hide();
			});
		});
		function aw_mail_list(){
			$('.mailing-ajax-waiting').show();
			var api_id = $('#aw_apikey').val();
			var client_id = $('#aw_clientid').val();
			var data = {
				action: 'popup_domination_mailing_client',
				provider: 'aw',
				token_key: api_id,
				token_secret : client_id
			};
			jQuery.post(popup_domination_admin_ajax, data, function(response) {
				$('.mailing-ajax-waiting').hide();
				$('.mailingfeedback').empty();
				$('.mailingfeedback').append(response);
				$('#form .provider').val('aw');
				$('#form .apikey').val(api_id);
				$('#form .apiextra').val($('#aw_clientid').val());
				var list = $('.mailing_lists').val();
				$('.listid').val(list);
			});
		}
	});
	
})(jQuery);