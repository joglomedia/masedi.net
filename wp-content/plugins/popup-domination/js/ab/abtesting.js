/**
* Abtesting.js
*
* Javascript which is used in the A/B Split campaign admin panel.
*/

;(function($){
	$(document).ready(function(){
		init_tabs();
		if($('#popup_domination_container .notices .message').text().length > 2){
			$('#popup_domination_container .notices').fadeIn('slow').delay(8000).fadeOut('slow');
		}
		if($('input[disabled]').length){
		$('input[disabled]').parent().find('div').click(function(){
               alert('You have not checked your PopUp Name, please head back to the top and do so.');
        });
        }else{
        	$('input[disabled]').parent().find('div').empty();
        }
		$('#popup_domination_show_everywhere').change(function(){
			if($(this).is(':checked')){
				last_checked = [];
				$('.page_list :checkbox:not(#popup_domination_show_everywhere):checked').each(function(){
					last_checked.push($(this));
					$(this).attr('checked',false);
				});
			} else {
				if(last_checked.length > 0){
					$.each(last_checked,function(){
						$(this).attr('checked',true);
					});
				} else {
					$.each(popup_domination_show_backup.opts,function(){
						$('#popup_domination_show_'+this).attr('checked',true);
					});
					$.each(popup_domination_show_backup.catids,function(){
						$('#catid_'+this).attr('checked',true);
					});
					$.each(popup_domination_show_backup.pageids,function(){
						$('#pageid_'+this).attr('checked',true);
					});
					if(popup_domination_show_backup.caton != ''){
						$('#popup_domination_show_caton').val(popup_domination_show_backup.caton);
					}
				}
			}
		});
		$('.page_list :checkbox:not(#popup_domination_show_everywhere)').change(function(){
			if($(this).is(':checked')){
				$('#popup_domination_show_everywhere').attr('checked',false);
			}
		});
		$('.checkname').click(function(){
			checkcampname();
		});
	})
	function checkcampname(){
		$('#popup_domination_tabs .campaign-name-box .error').hide();
		$('#popup_domination_tabs .campaign-name-box .confirm').hide();
		var name = $('#campname').val();
		$('#popup_domination_tabs .campaign-name-box .waiting').show();
		var data = {
			action: 'popup_domination_check_name',
			name: name,
			type: 'ab'
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('#popup_domination_tabs .campaign-name-box .waiting').hide();
			response = $.trim(response);
			if(response != 'false'){
				if(response == popup_domination_campaign_id){
					$('#campname').addClass('name_confirm');
					$('.removeme').hide();
					$('.savecamp').removeAttr('disabled');
				}else{
					$('#campname').addClass('name_error');
					$('.savecamp').attr('disabled','disabled');
				}
			}else{
				$('#campname').addClass('name_confirm');
				$('.savecamp').removeAttr('disabled');
				$('.removeme').hide();
			}
		});
	}
	function get_hash(str){
		if(str.indexOf('#') !== -1)
			return str.split('#').pop();
		return str;
	};
	function init_tabs(){
		var linestart = true;
		var elem = $('#popup_domination_tabs a'), cur_hash = get_hash(document.location.hash);
		height2 = $('#popup_domination_container div[id^="popup_domination_tab_"]' +cur_hash+ ' .the_content_box').outerHeight (true);
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
						$('.selected').removeClass('selected')
						$(this).addClass('selected')
						var id = get_hash($(this).attr('href'));
						$('#popup_domination_form_submit').toggle((id!='advanced_view'));
						$('#popup_domination_current_version').toggle((id!='advanced_view'));
						if(id!='advanced_view'){
							$('#popup_domination_tab_advanced_view:visible').toggle();
						}
						if(id == 'results'){
							if(linestart == true){
								line_graph();
								linestart = false;
							}
						}
						id = '#popup_domination_tab_'+id;
						$('#popup_domination_container div[id^="popup_domination_tab_"]:not('+id+'):visible').toggle();
						$(id+':not(:visible)').toggle();
						height2 = $('div[id^="popup_domination_tab_"]' +id+ ' .the_content_box').outerHeight(true);
						$('.the_content_box').parent().css('min-height',height2);
						return false;
					});
				}

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
	function line_graph(){
		$(document).ready(function(){
			$('.chart-one').graphs( {
				type: 'line',
		 		data: '#data-table-two',
		 		container: '.chart-one'
		 	})
		})
	}
})(jQuery);