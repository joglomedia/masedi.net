;(function($){
	$(document).ready(function(){
		cur_hash = get_hash(document.location.hash);
		if(cur_hash === 'htmlform'){
			$('#form .disable-name').hide();
		}
		if(cur_hash == '' || cur_hash == ' '){
			if(typeof provider != 'undefined' && provider != '' && provider!= ' '){
				$('#popup_domination_tabs a').each(function(){
					listalt = $(this).attr('alt');
					if(listalt == provider || provider == 'form' && listalt == 'other'){
						id = get_hash($(this).attr('href'));
						window.location.hash = id;
						
						init_tabs();
					}
				});
			}else{
				id = 'mailchimp';
				window.location.hash = id;
				init_tabs();
			}
		}else{
			init_tabs();
		}
		change_selects();
		if($('#popup_domination_container .notices .message').text().length > 2){
			$('#popup_domination_container .notices').fadeIn('slow').delay(8000).fadeOut('slow');
		}
		$('#landingpage').change(function(){
			$('#landingurl').attr('disabled',($(this).is(':not(:checked)')));
		});
		
		
		
			
			
		$('#popup_domination_formhtml').change(function(){
			var nameval = $('#popup_domination_name_box_selected').val('');
			var emailval = $('#popup_domination_email_box_selected').val('');
			var custom1val = $('#popup_domination_custom1_box_selected').val('');
			var custom2val = $('#popup_domination_custom2_box_selected').val('');
			change_selects();
		});
		
		$('.custom_num').change(function(){
			customnum = parseInt($(this).val());	
			if(customnum < 1){
				$('.custom2').val('').css('display','none');
				$('.custom1').val('').css('display','none');
			}
			if(customnum == 1){
				$('.custom2').val('').css('display','none');
			}
			if(customnum > 1){
				$('.custom1').css('display','block');
				$('.custom2').css('display','block');
			}
		});
		
		$('#popup_domination_email_box, #popup_domination_name_box').change(function(){ check_select(this) });
		
		$('.fancybox').fancybox({
			'type': 'iframe',
			'width': '75%',
			'height': '75%'
		});
		
		$('#landingpage').change(function(){
			if ($('#landingpage').attr('checked') == 'checked') {
				var redirect = $('#landingurl').val();
		       	$('.redirecturl').val(redirect);
		    }else{
		    	$('.redirecturl').val('');
		    }
	    });
	    
	    $('.landingpage #landingurl').blur(function(){
	    	var url = $(this).val();
	    	$('#form .redirecturl').val(url);
	    })

	
		$('#select_provider').change(function(){
			$('.custom1').val('');
			$('.custom2').val('');
			$('.provider_divs div').fadeOut();
			$('.provider_divs').fadeIn();
			var provider = $(this).val();
			$('.mailingfeedback').empty();
			$('.other').fadeOut();
			$('div .'+provider).delay(300).fadeIn();
			$('#form .mailingfeedback').fadeIn();
			$('#form input[type="submit"]').fadeIn();
			if(provider === 'other'){
				$('.apisubmit').fadeOut();
			}else{
				$('.apisubmit').fadeIn();
			}
		});
		
		$('#popup_domination_tabs a').click(function(){
			var provider = $(this).attr('alt');
			if(provider === 'other'){
				$('.apisubmit').fadeOut();
				$('#form .disable-name').hide();
			}else{
				$('.apisubmit').fadeIn();
				$('#form .disable-name').show();
			}
			if(provider == 'other'){
				$('#popup_domination_tab_api .disable-name').hide();
			}else{
				$('#popup_domination_tab_api .disable-name').show();
			}
			$(".custom_num option[value='0']").attr('selected', 'selected');
			$('.custom1').hide();
			$('.custom2').hide();
			$('#cc_custom1').hide();
			$('#cc_custom2').hide();
		})
		
		$('#nm_emailadd').change(function(){
			$('.custom1').val('');
			$('.custom2').val('');
			$('.provider_divs div').fadeOut();
			$('.provider_divs').fadeIn();
			var provider = $(this).val();
			$('.mailingfeedback').empty();
			$('.other').fadeOut();
			$('div .'+provider).delay(300).fadeIn();
			$('#form .mailingfeedback').fadeIn();
			$('#form input[type="submit"]').fadeIn();
			if(provider === 'other'){
				$('.apisubmit').fadeOut();
				$('#form p').hide();
				$('#form input').hide();
			}else{
				$('.apisubmit').fadeIn();
				$('#form p').show();
				$('#form input').show();
			}
		});
		
		$('#nm_emailadd').change(function(){
			$('.provider').val('nm');
			var email = $('#nm_emailadd').val();
			$('.apikey').val(email);
			$('#form').prepend('<input type="hidden" name="listsid" value="' + popup_domination_url  + 'inc/email.php" />');
		});
	
		$('.mc_getlist').click(function(){
			mc_mail_list();	
		});
		
		$('.cm_getlist').click(function(){
			cm_mail_list();	
		});
		
		$('.aw_getlist').click(function(){
			aw_mail_list();	
		});
		
		$('.ic_getlist').click(function(){
			ic_mail_list();	
		});
		
		$('.cc_getlist').click(function(){
			cc_mail_list();	
		});
		
		$('.gr_getlist').click(function(){
			gr_mail_list();	
		});
		
		$('.other form').submit(function(){
			$('#form .provider').val('other');
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
		
		
		$('#landingurl').change(function(){
			var redirecturl = $(this).val();
			$('.redirecturl').val(redirecturl);
		})
		
		$('#landingpage').change(function(){
			var checkcheck = $(this).attr('checked');
			if(checkcheck == 'checked'){
				$('#landingurl').change(function(){
					var redirecturl = $(this).val();
					$('.redirecturl').val(redirecturl);
				});
			}
		});
		
		$('#cc_custom1').change(function(){
			val = $(this).val();
			$('.custom1').val(val);
		})
		$('#cc_custom2').change(function(){
			val = $(this).val();
			$('.custom2').val(val);
		})
		$('#cm_custom_select, #aw_custom_select').change(function(){
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
		$('#gr_custom_select').change(function(){
			$('.custom1, .custom2').hide();
			var num = $(this).val();
			var i = 1;
			while(i<=num){
				$('.custom'+i).show();
				i++;
			}
			$('.customf').val(i - 1);
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
		$('#ic_custom_select').change(function(){
			$('.custom1, .custom2').hide();
			var num = $(this).val();
			var i = 1;
			while(i<=num){
				$('.custom'+i).show();
				i++;
			}
			$('.customf').val(i - 1);
		});
		
		$('.aweber_cookieclear').click(function(){
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
		
		$('.mailing_lists').live("change",function(){
			$('.listname').val($(this).find("option:selected").text());
		});
		
		$('.apisubmit').live('click', function(){
			var listval = $('.mailing_lists option:selected').val();
			if( $('.listname').val().length === 0 ) {
				$('.listname').val($('.mailing_lists').find('option:selected').html());
			}
		});
		
		$('.getlist').click(function(){
			$('.popdom-inner-sidebar form .custom1, .popdom-inner-sidebar form .custom2, .popdom-inner-sidebar form .apikey, .popdom-inner-sidebar form .username, .popdom-inner-sidebar form .password, .popdom-inner-sidebar form .apiextra, .popdom-inner-sidebar form .listname, .popdom-inner-sidebar form .customf, .popdom-inner-sidebar form .listid').val('');
			var provider = $('.tab-menu .selected').attr('alt');
			$('.popdom-inner-sidebar form .provider').val(provider);
			if(provider == 'aw'){
				$('#form .disablename').hide();
				$('#form p').hide();
			}else{
				$('#form .disablename').show();
				$('#form p').show();
			}
		});
		
	});
	
	function hide(){
		$('.popdom_contentbox_inside .waiting').hide();
	}
	
	function set_cookie(name,value,date){
		var str = popup_domination_url;
		var str2 = str.split(website_url+'/');
		var f = str2[1];
		window.document.cookie = [name+'='+escape(value),'expires='+date.toUTCString(),'path=/'+f+'inc/'].join('; ');
	};
	
	function multiple_fields(){
		var num_extra_inputs = custominputs.numfields;
		var i = 1;
		if(num_extra_inputs == 0){
			$('#popup_domination_field_custom' + i +'_default').remove();
			$('.popup_domination_custom_inputs').empty();
		}else{
			var checkforinputs = $('.popup_domination_custom_inputs > p').size();
			if(checkforinputs <= num_extra_inputs){
				while(i<=num_extra_inputs){
					$('.popup_domination_custom_inputs').append('<p><label for="popup_domination_custom'+(i)+'_box"><strong>Custom Field '+(i)+':</strong></label><select id="popup_domination_custom'+(i)+'_box" name="popup_domination[custom'+(i)+'_box]"></select><input type="hidden" id="popup_domination_custom'+(i)+'_box_selected" value=""/></p>');
					change_selects();
					i++;
				}
			}
		}
	}
	
	function change_selects(){
		var num_extra_inputs = numfields;
		$('#popup_domination_name_box option, #popup_domination_email_box option').remove();
		var tags = ['a','iframe','frame','frameset','script'], reg, val = $('#popup_domination_formhtml').val(),
			hdn = $('#popup_domination_hdn_div2'), action = $('#popup_domination_action'), hdn2 = $('#popup_domination_hdn_div');
	    action.val('');
		if($.trim(val) == '')
			return false;
		hdn2.html('');
		hdn.html('');
		for(var i=0;i<5;i++){
			reg = new RegExp('<'+tags[i]+'([^<>+]*[^\/])>.*?</'+tags[i]+'>', "gi");
			val = val.replace(reg,'');
			
			reg = new RegExp('<'+tags[i]+'([^<>+]*)>', "gi");
			val = val.replace(reg,'');
		}
		var tmpval;
		try {
			tmpval = decodeURIComponent(val);
		} catch(err){
			tmpval = val;
		}
		hdn.html(tmpval);
		var nameval = $('#popup_domination_name_box_selected').val();
		var emailval = $('#popup_domination_email_box_selected').val();
		var custom1 = $('#popup_domination_custom1_box_selected').val();
		var custom2 = $('#popup_domination_custom2_box_selected').val();
		
		if(typeof nameval != 'undefined' && nameval.length > 1){
			$('#popup_domination_name_box').append('<option value="'+nameval+'">'+nameval+'</option>');
		}if(typeof emailval != 'undefined' && emailval.length > 1){
			$('#popup_domination_email_box').append('<option value="'+emailval+'">'+emailval+'</option>');
		}if(typeof custom1 != 'undefined' && custom1.length > 1){
			$('#popup_domination_custom1_box').append('<option value="'+custom1+'">'+custom1+'</option>');
		}if(typeof custom2 != 'undefined' && custom2.length > 1){
			$('#popup_domination_custom2_box').append('<option value="'+custom2+'">'+custom2+'</option>');
		}else{
			$(':text',hdn).each(function(){
				var name = $(this).attr('name'),
					name_selected = name == $('#popup_domination_name_box_selected').val() ? ' selected="selected"' : '', 
					email_selected = name == $('#popup_domination_email_box_selected').val() ? ' selected="selected"' : '';
				$('#popup_domination_name_box').append('<option value="'+name+'"'+name_selected+'>'+name+'</option>');
				$('#popup_domination_email_box').append('<option value="'+name+'"'+email_selected+'>'+name+'</option>');
				for(i=1;i<=num_extra_inputs;i++){
					holdval = $('#popup_domination_custom'+i+'_box_selected').val();
					$('#popup_domination_custom'+i+'_box').append('<option value="'+name+'"'+name_selected+'>'+name+'</option>');
				}
			});
			$(':input',hdn).each(function(){
				if(typeof $(this).attr('name') != 'undefined'){
					hdn2.append($('<input type="hidden" name="field_name[]" />').val($(this).attr('name')));
					hdn2.append($('<input type="hidden" name="field_vals[]" />').val($(this).val()));
				}
			});
		}
		var hiddentmp = '';
		$(':input',hdn).each(function(){
			if(typeof $(this).attr('name') != 'undefined'){
				if($(this).attr('type') == 'hidden'){
					hiddentmp += '<input type="hidden" name="'+$(this).attr('name')+'" value="'+$(this).val()+'" />';
					
				}
			}
		});
		$('.hidden_fields').val(hiddentmp);
		$('img',hdn).each(function(){
			hdn2.append($('<input type="hidden" name="field_img[]" />').val($(this).attr('src')));
		});
		check_select('#popup_domination_name_box');
		action.val($('form',hdn).attr('action'));
		hdn.html('');
	};
	
	function check_select(elem){
		num_extra_inputs = 0;
		var id = 'popup_domination_email_box';
		if($(elem).attr('id') == id)
			id = 'popup_domination_name_box';
		var val1 = $(elem).val(), val2 = $('#'+id).val();
		if(val1 == val2){
			$('option:not([value="'+val1+'"]):eq(0)','#'+id).attr('selected',true);
		}
	};
	
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
	function get_hash(str){
		if(str.indexOf('#') !== -1)
			return str.split('#').pop();
		return str;
	};
	function init_tabs(startup){
		var linestart = true;
		var thislink = '';
		cur_hash = get_hash(document.location.hash);
		var elem = $('#popup_domination_tabs a'), cur_hash = get_hash(document.location.hash);
		elem.each(function(){
			var hash = get_hash($(this).attr('href'));
			if($('#popup_domination_tab_'+hash).length > 0){
				$(this).click(function(){
					$('.mailingfeedback').empty();
					var id = get_hash($(this).attr('href'));
					if(id == 'htmlform'){
						$('.apisubmit').hide();
						$('#landingurl').attr('disabled','disabled');
						$('#landingpage').attr('disabled','disabled');
					
					}else{
						$('.apisubmit').show();
						$('#landingurl').removeAttr('disabled');
						$('#landingpage').removeAttr('disabled');
					}
					id = '#popup_domination_tab_'+id;
					$(id).show();
					$('#popup_domination_container div[id^="popup_domination_tab_"]:not('+id+'):visible').toggle();
					
					$(id+':not(:visible)').toggle();
					$('.selected').removeClass('selected');
					$(this).addClass('selected');
					return false;
				});
			}
		});
		if(cur_hash != ''){
			var elem2 = elem.filter('[href$="#'+cur_hash+'"]');
			if(elem2.length > 0){
				elem2.click();
				return;
			}
		}
		elem.filter(':eq(0)').click();
	};

})(jQuery);