;(function($){
	$(document).ready(function(){
		if ($('.provider').val() == 'nm'){
			$('.connect-mailing-list').hide();
			$('.mailing-list').hide();
		} else {
			$('.connect-mailing-list').show();
			$('.mailing-list').show();
		}
		
		
		$('#popup_domination_tab_email .required').each(function(){
			$(this).blur(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
					alert('Please fill in your email address.');
					return false;
				} else {
					$(this).removeClass('input-error');
				}
			});
		});
		
		$('#nm_emailadd').change(function(){
			$('.provider').val('nm');
			var email = $(this).val();
			$('.apikey').val(email);
			$('#form').prepend('<input type="hidden" name="listsid" value="' + popup_domination_url  + 'inc/email.php" />');
		});
		
		$('#nm_custom_select').change(function(){
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
})(jQuery);