/**
* page.js
*
* jQuery file used in every page of PopUp Domination
*/
;(function($){
	$(document).ready(function(){
		$('.noscript').each(function(){
			$(this).css('display', 'none');
		});
	});
	
	$(document).ready(function(){
		init_tabs();
		$('#popup_domination_active a').live('click',function(){
			var opts = {"action":'popup_domination_activation',
						"todo":$(this).attr('class'),
						"_wpnonce": $('#_wpnonce').val(),
						"_wp_http_referer": $('input[name="_wp_http_referer"]').val()};
			$.get(popup_domination_admin_ajax,opts,activate,'json');
			return false;
		});
		
		function checkInputs(){
			$('#popup_domination_container input.required, #popup_domination_container textarea.required').each(function(){
				if ($(this).val().length == 0){
					$(this).addClass('input-error');
				} else {
					$(this).removeClass('input-error');
				}
			});
		}
	});
	function get_hash(str){
		if(str.indexOf('#') !== -1)
			return str.split('#').pop();
		return str;
	};
	function activate(resp){
		var path = popup_domination_url;
		if(resp.error){
			alert(resp.error);
		} else if(resp.active){
			var txt = '<img src="'+path+'images/off.png" alt="off" width="6" height="6" />', class1 = 'inactive', txt2 = '<img src="'+path+'images/on.png" alt="on" width="6" height="6" />', class2 = 'turn-on', txt3 = 'Inactive', txt4 = 'Active',txt5 = 'TURN ON', txt6 = 'TURN OFF';
			if(resp.active == 'Y'){
				txt = '<img src="'+path+'images/on.png" alt="on" width="6" height="6" />';
				txt2 = '<img src="'+path+'images/off.png" alt="off" width="6" height="6" />';
				txt3 = 'Active';
				txt4 = 'Inactive';
				txt5 = 'TURN OFF';
				txt6 = 'TURN ON';
				class1 = 'active';
				class2 = 'turn-off';
			}
			$('#popup_domination_active').html('<span class="wording"><span class="'+class1+'">'+txt+'</span> PopUp Domination is '+txt3+' </span><div class="popup_domination_activate_button"><div class="border">'+txt2+'<a href="#activation" class="'+class2+'">'+txt5+'</a></div></div> <img class="waiting" style="display:none;" src="'+path+'/images/wpspin_light.gif" alt="" />');
		} else {
			alert(resp);
		}
		$('#popup_domination_active .waiting').hide();
	};
	function init_tabs(){
		var elem = $('#popup_domination_tabs a'), cur_hash = get_hash(document.location.hash);
		height2 = $('#popup_domination_container div[id^="popup_domination_tab_"]' +cur_hash+ ' .the_content_box').outerHeight(true);
		$('.the_content_box').parent().css('min-height',height2);
		elem.each(function(){
			var hash = get_hash($(this).attr('href'));
			if(hash == 'preview'){
				$(this).click(function(){
					do_preview();
					return false;
				});
			} else {
				if($('#popup_domination_tab_'+hash).length > 0){
					$(this).click(function(){
						
						$('.icon').removeClass('selected');
						$(this).addClass('selected');
						var id = get_hash($(this).attr('href'));
						$('#popup_domination_form_submit').toggle((id!='advanced_view'));
						$('#popup_domination_current_version').toggle((id!='advanced_view'));
						if(id!='advanced_view'){
							$('#popup_domination_tab_advanced_view:visible').toggle();
						}
						id = '#popup_domination_tab_'+id;
						$('#popup_domination_container div[id^="popup_domination_tab_"]:not('+id+'):visible').toggle();
						$(id+':not(:visible)').toggle();
						height2 = $('div[id^="popup_domination_tab_"]' +id+ ' .the_content_box').outerHeight(true);
						$('.the_content_box').parent().css('min-height',height2);
						return false;
					});
				}
				$('.popup_domination_check_updates_link a').click(function(){
					var waiting = $('#popup_domination_tab_schedule .waiting');
					waiting.show();
					$('#popup_domination_container div[id^="popup_domination_tab_"]:visible').toggle();
					height2 = $('#popup_domination_tab_check_updates .the_content_box').outerHeight(true);
					$('.the_content_box').parent().css('min-height',height2);
					$('#popup_domination_tab_check_updates').show();
					var opts = {"action":'popup_domination_check_updates',
								"_wpnonce": $('#_wpnonce').val(),
								"_wp_http_referer": $('input[name="_wp_http_referer"]').val()};
					$.get(popup_domination_admin_ajax+'?rand='+(Math.random()*555),opts,function(resp){
						waiting.hide();
					},'json');
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
	
	function do_preview(){
		window.open('','preview_popup','');
		
		var elem = $('#popup_domination_form');
		var action = elem.attr('action');
		elem.attr('action',popup_domination_admin_ajax+'?action=popup_domination_preview')
			.attr('target','preview_popup')
			.submit()
			.attr('action',action)
			.removeAttr('target');
	};
})(jQuery);