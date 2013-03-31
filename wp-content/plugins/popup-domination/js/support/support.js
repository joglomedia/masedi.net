/**
* support.js
*
* Javascript which is used in the Support panel in the admin panels. 
*/
;(function($){
	var list_count = 0, tmpimg, to_show = '', still_over = false, last_checked = [], tempchange = false;
	$(document).ready(function(){
		if($('#popup_domination_container .notices .message').text().length > 2){
			$('#popup_domination_container .notices').fadeIn('slow').delay(8000).fadeOut('slow');
		}
		if($('#popup_domination_form_submit input[type="submit"]').attr('disabled') == 'disabled'){
			$('input[disabled]').parent().find('div').click(function(){
         	      alert('You have not checked your PopUp Name, please head back to the top and do so.');
        	});
        }else{
        	$('input[disabled]').parent().find('div').remove();
        }
        
        $('#popup_domination_tabs a').click(function(){
	    	var value = $('#popup_domination_tabs .selected').attr('href');
	    	if (value === "#support"){
	    		$('#popup_domination_form_submit input[name="send-email"]').show();
	    	} else {
		    	$('#popup_domination_form_submit input[name="send-email"]').hide();
	    	}
	    });
	    
	    $('input.required, textarea.required').each(function(){
	    	$(this).blur(function(){
		   		if ($(this).val().length == 0){
		    		$(this).addClass('input-error');	
		    	} else {
		    		$(this).removeClass('input-error');
		    	}
	    	});
	    });
	    
	    $('input[name="email"]').blur(function(){
	    	var email = $(this).val();
	    	if (!validateEmail($.trim(email))){
	    		$(this).addClass('input-error');
	    	} else {
	    		$(this).removeClass('input-error');
	    	}
	    });
	    
	    $('#popup_domination_form').submit(function(e){
	    	if ($('.input-error').length == 0){
	    		console.log();
	    		if (requiredEmpty()){
	    			e.preventDefault();
	    		}
	    	} else {
	    		e.preventDefault();
	    	}
	    });
	    
	    /*
	    *	Check's for empty inputs
	    */
	    function requiredEmpty(){
	    	var empty = false;
	    	$('input.required, textarea.required').each(function(){
	    		if ($(this).val().length === 0){
	    			$(this).addClass('input-error');
	    			empty = true;
    			}
	    	});
	    	return empty;
	    }
    });
    
    /*
    *	Check for email address. Checks for spaces, @ symbol and valid domain name
    */
    function validateEmail(email){
    	if (email.indexOf(' ') >= 0 || email.length == 0)
    		return false;
    	var parts = email.split('@');
    	if (parts.length != 2)
    		return false;
    	var check = parts[1].split('.');
    	if (check.length < 2)
    		return false;
    	return true;
    }
    
    
})(jQuery);