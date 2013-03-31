/**
* Admin_lightbox.js
*
* Javascript which is used in the Campaigns panel in the admin panels. 
*/
;(function($){
	$('#popup_domination_container .notices').hide();
	var list_count = 0, tmpimg, to_show = '', still_over = false, last_checked = [], tempchange = false;
	$(document).ready(function(){
		if($('#popup_domination_container .notices .message').text().length > 2){
			$('#popup_domination_container .notices').fadeIn('slow').delay(8000).fadeOut('slow');
		}
		multiple_fields();
				
		if($('input[disabled]').length){
		
		$('input[disabled]').parent().find('div').click(function(){
               alert('You have not checked your PopUp Name, please head back to the top and do so.');
        });
        
        }else{
        	$('input[disabled]').parent().find('div').remove();
        }
		
		$('#popup_domination_disable_name').change(function(){
			$('#popup_domination_name_box').attr('disabled',($(this).is(':checked')));
			$('#popup_domination_name_box_selected').attr('disabled',($(this).is(':checked')));
		});
		$('#popup_domination_template').change(function(){
			$('#popup_domination_preview .preview').css('background-image','');
			set_template(true);
			multiple_fields();
		});
		set_template(false);
		$('#popup_domination_formhtml').change(change_selects);
		change_selects();
		$('#popup_domination_listitems a[href$="#addnew"]').click(function(){
			$('#popup_domination_listitems ul').append('<li><input type="text" name="list_item[]" value=""> <a href="#delete" class="thedeletebutton remove_list_item">Delete</a><div class="clear"></div></li>');
			refresh_list_icons();
			return false;
		});
		$('#popup_domination_listitems a[href$="#delete"]').live('click',function(){
			$(this).parent().remove();
			refresh_list_icons();
			return false;
		});
		$('#popup_domination_email_box, #popup_domination_name_box').change(function(){ check_select(this) });
		$('#popup_domination_active a').live('click',function(){
			var opts = {"action":'popup_domination_activation',
						"todo":$(this).attr('class'),
						"_wpnonce": $('#_wpnonce').val(),
						"_wp_http_referer": $('input[name="_wp_http_referer"]').val()};
			$.get(popup_domination_admin_ajax,opts,activate,'json');
			return false;
		});
		$('#popup_domination_tab_schedule a.button').click(function(){
			var waiting = $('#popup_domination_tab_schedule .waiting');
			waiting.show();
			var id = $('.campaigncookieid').val();
			var opts = {"action":'popup_domination_clear_cookie',
						"_wpnonce": $('#_wpnonce').val(),
						"id": id,
						"_wp_http_referer": $('input[name="_wp_http_referer"]').val()};
			$.get(popup_domination_admin_ajax+'?rand='+(Math.random()*555),opts,function(resp){
				waiting.hide();
			},'json');
			return false;
		});
		refresh_list_icons();
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
		$('#popup_domination_tab_schedule .show_opts :radio').change(function(){
			$('#popup_domination_tab_schedule .show_opts :text').attr('disabled',true);
			if($(this).is(':checked')){
				$(this).parent().parent().find(':text').attr('disabled',false);
			}
		});
		
		if($('.show_opts input[type="radio"]')[0].checked == true){
			id = $('input[type="radio"]').attr('id');
		}else{
			id = '';
		}
		$('.show_opts input[type="radio"]').change(function(){
			id = $(this).attr('id');
		    if ($('input#'+id)[0].checked == true) {
		   		$('.toggle').fadeOut('fast');
		   		$('.'+id).fadeIn('fast');
	    	}
	    	
		});
		
		$('.checkname').click(function(){
			checkcampname();
		});
		
		var buttoncolor = $('#popup_domination_btn_color_selected').val();
		$('#popup_domination_btn_color').val(buttoncolor);
	});
	
	function multiple_fields(){
		var custominputs = popup_domination_tpl_info[$('#popup_domination_template').val()];
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
	
	function checkcampname(){
		$('#popup_domination_tabs .campaign-name-box .error').hide();
		$('#popup_domination_tabs .campaign-name-box .confirm').hide();
		var name = $('#campname').val();
		$('#popup_domination_tabs .campaign-name-box .waiting').show();
		var data = {
			action: 'popup_domination_check_name',
			name: name,
			type: 'campaign'
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('#campname').removeClass();
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
	
	function refresh_list_icons(){
		$('#popup_domination_listitems li')
			.filter(':lt('+list_count+')')
				.removeClass('over')
				.find('span.toomany')
					.remove()
				.end()
			.end()
			.filter(':gt('+(list_count-1)+')')
				.addClass('over')
				.find('.toomany')
					.remove()
				.end()
				.append('<span class="toomany">(this bullet is over the limit and will not be included)</span>');
	};
	function set_max_msg(obj){
		var maxc = parseInt($(obj).data('maxc')), fieldtype = $(obj).data('fieldtype');
		var length = $(fieldtype,obj).val().length;
		var elem;
		var txt = ' Recommended '+maxc, classname = 'green', msg = 'remaining <span>'+(maxc-length)+'</span>';
		if(length > maxc){
			classname = 'red';
			msg = 'hmm, you\'re over the limit, it might look bad';
		}
		var html = '<span class="recommended"><span class="'+classname+'">'+txt+'</span> <span class="note"> - '+msg+'</span>'+((fieldtype=='textarea')?'<br />':'')+'</span>';
		if($('.recommended',obj).length > 0){
			$('.recommended',obj).replaceWith(html);
		} else {
			if(fieldtype == 'textarea'){
				elem = $('textarea',obj);
				elem.after(html);
			} else {
				elem = $(fieldtype,obj);
				elem.after(html);
			}
		}
		
	};
	function set_max(obj,fieldtype,maxc){
		obj = $(obj);
		obj.data('fieldtype',fieldtype);
		obj.data('maxc',maxc);
		var elem = $(fieldtype,obj);
		elem.bind('keydown keyup keypress', function(){ set_max_msg($(this).parent()) })
			.bind('focus paste', function(){ var tmpobj = $(this).parent(); setTimeout(function(){set_max_msg(tmpobj)},10)});
		set_max_msg(obj);
	};
	function unset_max(obj,fieldtype){
		obj = $(obj);
		obj.removeData('fieldtype')
			.removeData('maxc');
		var elem = $(fieldtype,obj);
		elem.unbind('keydown')
			.unbind('keyup')
			.unbind('keypress')
			.unbind('focus')
			.unbind('paste');
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
	function check_select(elem){
		num_extra_inputs = 0;
		var id = 'popup_domination_email_box';
		if($(elem).attr('id') == id)
			id = 'popup_domination_name_box';
		var val1 = $(elem).val(), val2 = $('#'+id).val();
		if(val1 == val2){
			$('option:not([value="'+val1+'"]):eq(0)','#'+id).attr('selected',true);
		}
		custominputs = popup_domination_tpl_info[$('#popup_domination_template').val()];
		num_extra_inputs = custominputs.numfields;
		if($('#popup_domination_inputs_num').length == 0){
			$('.popup_domination_custom_inputs').append('<input type="hidden" id="popup_domination_inputs_num" name="popup_domination[custom_fields]" value="'+num_extra_inputs+'" />');
		}else{
			$('#popup_domination_inputs_num').val(num_extra_inputs);
		}
		for(i=1;i<=num_extra_inputs;i++){
			holdval = $('#popup_domination_custom'+i+'_box_selected').val();
			$('#popup_domination_custom'+i+'_box').append('<option selected="selected" value="'+holdval+'">'+holdval+'</option>');
			
		}		
	};
	function init_upload(field){
		var elem = $('#popup_domination_field_'+field);
		new AjaxUpload($(elem).find('a[href$="#upload_file"]'),{
			action: popup_domination_admin_ajax,
			name: 'userfile',
			data: {
				action: 'popup_domination_file_upload',
				type: 'upload',
				data: 'userfile',
				fieldid: field,
				template: $('#popup_domination_template').val(),
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('input[name="_wp_http_referer"]').val()
			},
			onSubmit : function(file , ext){
				var err = $('#popup_domination_field_'+field+'_error');
				if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))){
					err.html('<strong>Upload Error:</strong> Invalid file extension')
						.filter(':not(:visible)').toggle();
					return false;
				} else {
					err.html('').filter(':visible').toggle();
					elem.find('.waiting:not(:visible)').toggle();
				}
        	},
			onComplete: function(file, resp) {
				elem.find('.waiting:visible').toggle();
				var txtfield = elem.find('input'), err = $('#popup_domination_field_'+field+'_error')
					btns = $('#popup_domination_field_'+field+'_field_btns');
				resp = resp.split('|');
				if(resp[0] == 'error'){
					err.html(resp[1]).filter(':not(:visible)').toggle();
					btns.filter(':visible').toggle();
					txtfield.val('');
				} else {
					btns.filter(':not(:visible)').toggle();
					err.html('').filter(':visible').toggle();
					txtfield.val(resp[0]);
				}
			}
		});
	};
	
	function set_real_image(img){
		$('#popup_domination_preview .preview').css('background-image','url(\''+img+'\')');
	};
	function set_preview(img,width,height){
		to_show = popup_domination_theme_url+img;
		var elem = $('#popup_domination_preview .preview');
		tmpimg = new Image();
		tmpimg.src = to_show;
		elem.css({"background-repeat":'no-repeat', "background-position":'center center', "width":width+'px', "height":height+'px'});
		if(tmpimg.complete){
			set_real_image(tmpimg.src);
		} else {
			elem.css('background-image',"url('images/wpspin_light.gif')");
			$(tmpimg).load(function(){
				var src = $(this).attr('src');
				if(src == to_show)
					set_real_image($(this).attr('src'))
			});
		}
	};
	function show_preview(elem){
		if(elem.length > 0 && elem.data('preview')){
			var size = elem.data('preview_size');
			set_preview(elem.data('preview'),size[0],size[1]);
		}
	};
	function set_template(tempchange){
		var theme = null;
		theme = popup_domination_tpl_info[$('#popup_domination_template').val()];
		$('#popup_domination_tab_template_fields p .tpl_name').text($('#popup_domination_template :selected').text());
		$('.extra_fields').val(theme.numfields);
		if(theme.colors && theme.colors.length > 0){
			var elem = $('.popup_color #popup_domination_color_selected').val();
			if(tempchange){
				$('#popup_domination_color_selected').empty();
				$.each(theme.colors, function(index, value){
					$('#popup_domination_color_selected').append('<option class="'+value.options+'">'+value.name+'</option>');
					$('#popup_domination_color_selected option:first').attr('selected','selected');
					var val = $('#popup_domination_color_selected').val();
					$.each(theme.colors, function(index, value){
						if(val == value.name){
							if(value.preview && theme.preview_size){
								set_preview(value.preview,theme.preview_size[0],theme.preview_size[1]);
							}
						}
					});
				});
				
				$('#popup_domination_btn_color').empty();
				$.each(theme.button_colors, function(index, value){
					$('#popup_domination_btn_color').append('<option class="'+value.options+'">'+value.name+'</option>');
					$('#popup_domination_btn_color option:first').attr('selected','selected');
					var val = $('#popup_domination_color_selected').val();
					$.each(theme.button_colors, function(index, value){
						if(val == value.name){
							if(value.preview && theme.preview_size){
								set_preview(value.preview,theme.preview_size[0],theme.preview_size[1]);
							}
						}
					});
				});
			}
			$('#popup_domination_color_selected').change(function(){
				val = $(this).val();
				$.each(theme.colors, function(index, value){
					if(val == value.name){
						if(value.preview && theme.preview_size){
							set_preview(value.preview,theme.preview_size[0],theme.preview_size[1]);
						}
					}
				});
			});
			
			var buttoncolor = $('#popup_domination_btn_color_selected').val();
			$('#popup_domination_btn_color option').each(function(){
				$(this).removeAttr('selected');
				if($(this).val() == buttoncolor){
					$(this).attr('selected','selected');
					$('#popup_domination_btn_color').val(buttoncolor);
				}
			});
			
			$('#popup_domination_colors_container:not(:visible)').toggle();
		} else {
			if(theme.preview_image && theme.preview_size){
				var size = theme.preview_size;
				$('#popup_domination_preview .preview').css({"background-image":'url(\''+popup_domination_theme_url+theme.preview_image+'\')',
															 "width":size[0]+'px',
															 "height":size[1]+'px'});				
			}
			$('#popup_domination_colors_container:visible').toggle();
		}
		if(theme.fields && theme.fields.length > 0){
			var lastelem = null, tpltab = $('#popup_domination_tab_template_fields .inside .elements'), str;
			tpltab.find('p').hide();
			$.each(theme.fields,function(){
				str = '';
				var elem = tpltab.find('#popup_domination_field_'+this.opts.id), fieldtype = 'input';
				if(this.opts.type == 'textarea')
					fieldtype = 'textarea';
				if(elem.length == 0){
					elem = $('<p id="popup_domination_field_'+this.opts.id+'"></p>')
								.append('<label for="popup_domination_field_'+this.opts.id+'_field"><strong>'+this.name+':</strong></label>');
					if(this.opts.type == 'textarea'){
						elem.append(str+'<br /><textarea cols="60" rows="5" name="popup_domination_fields['+this.opts.id+']" id="popup_domination_field_'+this.opts.id+'_field"></textarea>');
					} else if(this.opts.type == 'image'){
						elem.append('<input type="text" name="popup_domination_fields['+this.opts.id+']" id="popup_domination_field_'+this.opts.id+'_field" /> Resizes to: (max width: '+this.opts.max_w+', max height: '+this.opts.max_h+') <a href="#upload_file" class="button">Upload file</a><span id="popup_domination_field_'+this.opts.id+'_field_btns" style="display:none"> | <a href="#remove" class="button">Remove</a></span> <img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" /> <span id="popup_domination_field_'+this.opts.id+'_error" style="display:none"></span><br />Want to create a stunning eCover design to put here? Check out <a href="http://nanacast.com/vp/95449/69429/" target="_blank">eCover Creator 3D</a>.');
					} else if(this.opts.type == 'video'){
						elem.append('<input type="'+this.opts.type+'" name="popup_domination_fields['+this.opts.id+']" id="popup_domination_field_'+this.opts.id+'_field" />'+str+'<br/>Looking for an AWESOME video player? Check out <a href="http://popdom.webactix.hop.clickbank.net/" target="_blank">Easy Video Player 2.0</a>.');
					} else {
						elem.append('<input type="'+this.opts.type+'" name="popup_domination_fields['+this.opts.id+']" id="popup_domination_field_'+this.opts.id+'_field" />'+str);
					}
					if(lastelem === null){
						tpltab.prepend(elem);
					} else {
						lastelem.after(elem);
					}
					lastelem = elem;
				} else {
					var val = elem.find(fieldtype).val();
					if(lastelem === null){
						tpltab.prepend(elem);
					} else {
						lastelem.after(elem);
					}
					elem.filter(':not(:visible)').toggle();
					lastelem = elem;
				}
				if(this.opts.max){
					set_max(elem,fieldtype,this.opts.max);
				} else {
					unset_max(elem,fieldtype);
				}
				if(this.opts.type != 'image'){
					elem = elem.find(fieldtype);
					if(elem.val() == '' && this.opts.default_val){
						elem.val(this.opts.default_val);
					}
				} else {
					init_upload(this.opts.id);
					$('#popup_domination_field_'+this.opts.id+'_field_btns a[href$="#remove"]').click(function(){
						var span = $(this).parent();
						span.parent().find('input').val('');
						span.hide();
						return false;
					});
				}
			});
		}
		list_count = theme.list_count;
		$('#list_allowed_size span').text(list_count);
		var height = $('.popdom-inner-sidebar').outerHeight(true);
		$('.popdom-inner-sidebar').parent().css('min-height',height);
		
	};
	function change_selects(){
		custominputs = popup_domination_tpl_info[$('#popup_domination_template').val()];
		num_extra_inputs = custominputs.numfields;
		for(i=1;i<=num_extra_inputs;i++){
			$('#popup_domination_custom'+i+'_box option').remove();
		}	
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
		$('img',hdn).each(function(){
			hdn2.append($('<input type="hidden" name="field_img[]" />').val($(this).attr('src')));
		});
		check_select('#popup_domination_name_box');
		action.val($('form',hdn).attr('action'));
		hdn.html('');
	};
})(jQuery);