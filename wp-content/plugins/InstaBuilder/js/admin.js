jQuery(document).ready(function($){
	upload_img_url(jQuery);

	jQuery('#opl_template').change(function(){
		var option = jQuery("option:selected", this).val();
		var html = '';
		jQuery('#opl_color').attr('disabled', 'disabled');

		var data = {
				action: 'opl_get_color',
				template : option,
				type : 'get_color'
			};

		jQuery.post(ajaxurl, data, function(response) {
			var color = response.split(",");
			for ( i = 0; i < color.length; i++ ) {
				html += '<option value="' + color[i] + '">' + ucwords(color[i]) + '</option>';
			}
			jQuery('#opl_color').html(html);
			jQuery('#opl_color').removeAttr('disabled');		
		});
	});

	jQuery('#opl_smart_page').change(function(){
		var option = jQuery("option:selected", this).val();
		var _squeeze_id = jQuery('#opl_post_id').val();
		var data = {
				action: 'opl_smart_url',
				page_id : option,
				squeeze_id : _squeeze_id,
				type : 'get_smart_url'
			};

		jQuery('#opl_smart_redir').val('Processing...');
		jQuery.post(ajaxurl, data, function(response) {
			if ( response != 'failed' )
				jQuery('#opl_smart_redir').val(response);
		});
	});

	jQuery('#opl_logo_type').change(function(){
		if ( jQuery("option:selected", this).val() == 'text' ) {
			jQuery('.opl-image-logo').hide();
			jQuery('.opl-text-logo').show();
		} else {
			jQuery('.opl-image-logo').show();
			jQuery('.opl-text-logo').hide();
		}
	}).change();

	jQuery('#opl_video_insert').change(function(){
		video_type(jQuery, jQuery("option:selected", this));
	}).change();

	jQuery('#opl_under_content').change(function(){
		under_video(jQuery, jQuery("option:selected", this));
	}).change();

	jQuery('#opl_type').change(function(){
		if ( jQuery("option:selected", this).val() == 'video' ) {
			jQuery('.opl-video-page').show();
			jQuery('.opl-squeeze').hide();
			video_type(jQuery, jQuery('#opl_video_insert'));
			under_video(jQuery, jQuery('#opl_under_content'));
			jQuery('.opl-oto').show();
			jQuery('.opl-single-property').hide();
			jQuery('.opl-launch-navi-tab').hide();
			if ( jQuery('#opl_oto').is(":checked") )
				jQuery('.opl-oto-property').show();
			else
				jQuery('.opl-oto-property').hide();
		} else if ( jQuery("option:selected", this).val() == 'front' || jQuery("option:selected", this).val() == 'optin' ) {
			jQuery('.opl-video-page').hide();
			jQuery('.opl-squeeze').show();
			jQuery('.opl-oto').hide();
			jQuery('.opl-single-property').hide();
			jQuery('.opl-launch-navi-tab').hide();
			if ( jQuery('#opl_smart_optin').is(":checked") )
				jQuery('.opl-smart-optin').show();
			else
				jQuery('.opl-smart-optin').hide();
		} else if ( jQuery("option:selected", this).val() == 'launch' ) {
			jQuery('.opl-video-page').hide();
			jQuery('.opl-squeeze').hide();
			jQuery('.opl-oto').hide();
			jQuery('.opl-single-property').show();
			jQuery('.opl-launch-navi-tab').show();
		} else {
			jQuery('.opl-video-page').hide();
			jQuery('.opl-squeeze').hide();
			jQuery('.opl-oto').show();
			jQuery('.opl-single-property').show();
			jQuery('.opl-launch-navi-tab').hide();
			if ( jQuery('#opl_oto').is(":checked") )
				jQuery('.opl-oto-property').show();
			else
				jQuery('.opl-oto-property').hide();

		}
	}).change();

	// OTO Settings
	jQuery('#opl_oto').click(function(){
		if ( this.checked == true )
			jQuery('.opl-oto-property').show();
		else
			jQuery('.opl-oto-property').hide();
	});

	if ( jQuery('#opl_oto').is(":checked") )
		jQuery('.opl-oto-property').show();
	else
		jQuery('.opl-oto-property').hide();

	// Smart Optin Page
	jQuery('#opl_smart_optin').click(function(){
		if ( this.checked == true )
			jQuery('.opl-smart-optin').show();
		else
			jQuery('.opl-smart-optin').hide();
	});

	if ( jQuery('#opl_smart_optin').is(":checked") )
		jQuery('.opl-smart-optin').show();
	else
		jQuery('.opl-smart-optin').hide();

	// Facebook Auto-Post Disable
	jQuery('#opl_fb_msg_disable').click(function(){
		if ( this.checked == true ) {
			jQuery('#opl_fb_msg').attr('readonly', 'readonly');
			jQuery('#opl_fb_msg').css({'background-color' : '#E5E5E5', 'color' : '#C2C2C2'});
		} else {
			jQuery('#opl_fb_msg').removeAttr('readonly');
			jQuery('#opl_fb_msg').css({'background-color' : '#FFFFFF', 'color' : '#212121'});
		}
	});

	if ( jQuery('#opl_fb_msg_disable').is(":checked") ) {
		jQuery('#opl_fb_msg').attr('readonly', 'readonly');
		jQuery('#opl_fb_msg').css({'background-color' : '#E5E5E5', 'color' : '#C2C2C2'});
	} else {
		jQuery('#opl_fb_msg').removeAttr('readonly');
		jQuery('#opl_fb_msg').css({'background-color' : '#FFFFFF', 'color' : '#212121'});
	}

	// Advanced Optin Fields
	jQuery('#opl_fields_mode').change(function(){
		if ( jQuery("option:selected", this).val() == 'advanced' ) {
			jQuery('.opl-advanced-form').show();
			jQuery('.opl-simple-form').hide();
		} else {
			jQuery('.opl-advanced-form').hide();
			jQuery('.opl-simple-form').show();
		}
	}).change();

	// Body Background Settings
	jQuery('#opl_bodybg').click(function(){
		if ( this.checked == true )
			jQuery('.body-bg-property').show();
		else
			jQuery('.body-bg-property').hide();
	});

	if ( jQuery('#opl_bodybg').is(":checked") )
		jQuery('.body-bg-property').show();
	else
		jQuery('.body-bg-property').hide();

	jQuery('#opl_bodybg_repeat').change(function(){
		if ( jQuery("option:selected", this).val() == 'no-repeat' ) {
			jQuery('#opl-bodybg-size').show();
		} else {
			jQuery('#opl-bodybg-size').hide();
		}
	}).change();

	// Header Background Settings
	jQuery('#opl_headerbg').click(function(){
		if ( this.checked == true )
			jQuery('.header-bg-property').show();
		else
			jQuery('.header-bg-property').hide();
	});

	if ( jQuery('#opl_headerbg').is(":checked") )
		jQuery('.header-bg-property').show();
	else
		jQuery('.header-bg-property').hide();


	// Manual Subscribe 
	jQuery('#opl_subs_method_manual').click(function(){
		if ( this.checked == true ) {
			jQuery('.opl-manual').show();
			if ( jQuery("#opl_fields_mode").val() == 'advanced' ) {
				jQuery('.opl-advanced-form').show();
				jQuery('.opl-simple-form').hide();
			} else {
				jQuery('.opl-advanced-form').hide();
				jQuery('.opl-simple-form').show();
			}
			button_type(jQuery, jQuery('input:radio[name=opl_btn_type]:checked'));
		} else {
			jQuery('.opl-optin-btn').hide();
			jQuery('.opl-premade-btn').hide();
			jQuery('.opl-text-btn').hide();
			jQuery('.opl-custom-btn').hide();
			jQuery('.opl-manual').hide();
		}
	});

	if ( jQuery('#opl_subs_method_manual').is(":checked") ) {
		jQuery('.opl-manual').show();
		if ( jQuery("#opl_fields_mode").val() == 'advanced' ) {
			jQuery('.opl-advanced-form').show();
			jQuery('.opl-simple-form').hide();
		} else {
			jQuery('.opl-advanced-form').hide();
			jQuery('.opl-simple-form').show();
		}
		button_type(jQuery, jQuery('input:radio[name=opl_btn_type]:checked'));
	} else {
		jQuery('.opl-optin-btn').hide();
			jQuery('.opl-premade-btn').hide();
			jQuery('.opl-text-btn').hide();
			jQuery('.opl-custom-btn').hide();
		jQuery('.opl-manual').hide();
	}

	// Facebook Subscribe 
	jQuery('#opl_subs_method_fb').click(function(){
		if ( this.checked == true )
			jQuery('.opl-fb-property').show();
		else
			jQuery('.opl-fb-property').hide();
	});

	if ( jQuery('#opl_subs_method_fb').is(":checked") ) {
		jQuery('.opl-fb-property').show();
	} else {
		jQuery('.opl-fb-property').hide();
	}

	// Button Type
	jQuery("input:radio[name=opl_btn_type]").click(function(){
    		button_type(jQuery, jQuery(this));
	});
 
	var btn = jQuery('input:radio[name=opl_btn_type]:checked');
	button_type(jQuery, btn);

	jQuery('#opl-add-graphic').click(function(){
		var imgurl = jQuery('#opl_insert_graphic').val();
		window.send_to_editor('<img src="' + imgurl + '" border="0" />');
		return false;
	});

	jQuery('#opl_insert_graphic').change(function(){
		var graphic = jQuery("option:selected", this).val();
		jQuery('#opl-graphic-preview').html('<img src="' + graphic + '" border="0" />');
	});

	jQuery('#opl_insert_sc').change(function(){
		var option = jQuery("option:selected", this).val();

		if ( option != '' ) {
			jQuery('.opl-sc-property').hide();
			jQuery('.' + option).show();
			jQuery('.opl-sc-btn').show();
		} else {
			jQuery('.opl-sc-property').hide();
			jQuery('.opl-sc-btn').hide();
		}
	});

	// Viral Share
	jQuery('#opl_viral_fb').click(function(){
		if ( this.checked == true )
			jQuery('.opl-fb-viral').show();
		else
			jQuery('.opl-fb-viral').hide();
	});

	if ( jQuery('#opl_viral_fb').is(":checked") )
		jQuery('.opl-fb-viral').show();
	else
		jQuery('.opl-fb-viral').hide();

	jQuery('#opl_viral_tw').click(function(){
		if ( this.checked == true )
			jQuery('.opl-tw-viral').show();
		else
			jQuery('.opl-tw-viral').hide();
	});

	if ( jQuery('#opl_viral_tw').is(":checked") ) {
		jQuery('.opl-tw-viral').show();
	} else {
		jQuery('.opl-tw-viral').hide();
	}

	$('.bwst-atab').each(function(){
		var $this = jQuery(this);
		$this.click(function(e){
			var old_id = $this.parent().find('.nav-tab-active').attr('rel');
			var new_id = $this.attr('rel');
			$('#' + old_id).hide();
			$('#' + new_id).show();
			$this.parent().find('.nav-tab-active').removeClass('nav-tab-active');
			$this.addClass('nav-tab-active');
			
			e.preventDefault();
		});
	});

	$('.js-empty-field').each(function(){
		var $this = $(this);
		$this.click(function(e){
			$this.parent().remove();
		});
	});

	$('.dest-weight').each(function(){
		var $this = $(this);
		$this.keyup(function(){
			if ( $this.val() == 0 )
				$this.val(1);
		});
	});

	jQuery('.js-url-field').each(function(){
		var $this = jQuery(this);
		$this.click(function(){
			if ( confirm("Are you sure you want to remove this page from this campaign?") ) {
				$this.parent().find('.remove-url-loader').show();
				$this.hide();
				var _sid = $this.parent().find('#dest_urls_id').attr('value');
				var data = {
						action: 'opl_remove_url',
						sid : _sid,
						type : 'remove_url'
					};

				jQuery.post(ajaxurl, data, function(response) {
					if ( response == 'deleted' ) {
						$this.parent().remove();
					} else {
						$this.parent().find('.remove-url-loader').hide();
						$this.show();
						alert("Failed to delete URL. Please try again.");
					}
				});
			}
		});
	});

	jQuery('.opl-add-launch').click(function(e){
		var $this = jQuery(this);

		$this.attr('disabled', 'disabled');
		jQuery('.launch-item-loader').show();
		var _num = jQuery('#opl-launch-num').val();
		var ln = parseInt(_num) + 1;
		var data = {
				action: 'opl_add_launch',
				launch_num : ln,
				type : 'add_launch_item'
			};

		jQuery.post(ajaxurl, data, function(response) {
			$this.removeAttr('disabled');
			jQuery('.launch-item-loader').hide();
			jQuery('#opl-launch-items').append(response);
			jQuery('#opl-launch-num').val(ln);
			upload_img_url(jQuery);

			remove_launch_item(jQuery);
		});

		e.preventDefault();
	});

	remove_launch_item(jQuery);

});

function remove_launch_item($) {
	$('.remove-launch-item').each(function(){
		var dis = $(this);
		dis.click(function(e){
			var _num = $('#opl-launch-num').val();
			var ln = parseInt(_num) - 1;

			$('#opl-launch-num').val(ln);
			dis.parent().parent().parent().fadeOut("medium").remove();

			e.preventDefault();
		});
	});
}

function button_type($, name) {
	if ( name.val() == 'premade' ) {
		$('.opl-custom-btn').hide();
		$('.opl-text-btn').hide();
		$('.opl-premade-btn').show();
	} else if ( name.val() == 'text' ) {
		$('.opl-custom-btn').hide();
		$('.opl-text-btn').show();
		$('.opl-premade-btn').hide();
	} else if ( name.val() == 'upload' ) {
		$('.opl-custom-btn').show();
		$('.opl-text-btn').hide();
		$('.opl-premade-btn').hide();
	}
}

function under_video($, name) {
	if ( name.val() == 'order' ) {
		$('.opl-under').show();
		$('.opl-under-optin').hide();
		$('.opl-under-content').hide();
		$('.opl-under-buy').show();
	} else if ( name.val() == 'optin' ) {
		$('.opl-under-buy').hide();
		$('.opl-under-optin').show();
		$('.opl-under-content').hide();
		$('.opl-under').show();
	} else if ( name.val() == 'content' ) {
		$('.opl-under-buy').hide();
		$('.opl-under-optin').hide();
		$('.opl-under-content').show();
		$('.opl-under').show();
	} else if ( name.val() == 'combo1' ) {
		$('.opl-under-buy').show();
		$('.opl-under-optin').hide();
		$('.opl-under-content').show();
		$('.opl-under').show();
	} else if ( name.val() == 'combo2' ) {
		$('.opl-under-buy').hide();
		$('.opl-under-optin').show();
		$('.opl-under-content').show();
		$('.opl-under').show();
	} else if ( name.val() == 'nothing' ) {
		$('.opl-under-optin').hide();
		$('.opl-under-buy').hide();
		$('.opl-under-content').hide();
		$('.opl-under').hide();
	}
}

function video_type($, name) {
	if ( name.val() == 'hosted' ) {
		$('.opl-video').show();
		$('.opl-embed').hide();
		$('.opl-vidurl').show();
	} else if ( name.val() == 'embed' ) {
		$('.opl-video').show();
		$('.opl-embed').show();
		$('.opl-vidurl').hide();
	} else {
		$('.opl-video').hide();
	}
}

function ucwords(str) {
	return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
		return $1.toUpperCase();
	});
}

function upload_img_url($) {
	$('.opl_upload_button').each(function(){
		var clickedObject = $(this);
		var clickedID = $(this).attr('id');
		var actionURL = ajaxurl;

		new AjaxUpload(clickedID, {
			action: actionURL,
			name: clickedID, // File upload name
			data: { // Additional data to send
					action: 'opl_upload',
					type: 'upload',
					data: clickedID
			      },
			autoSubmit: true, // Submit file after selection
			responseType: false,
			onChange: function(file, extension){},
			onSubmit: function(file, extension){
				clickedObject.text('Uploading'); // change button text, when user selects file	
				this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
				interval = window.setInterval(function(){
					var text = clickedObject.text();
					if (text.length < 13) {
						clickedObject.text(text + '.'); 
					} else { clickedObject.text('Uploading'); }
				}, 200);
			},
			
			onComplete: function(file, response) {
				   
				window.clearInterval(interval);
				clickedObject.text('Upload Image');	
				this.enable(); // enable upload button
					
				// If there was an error
				if ( response.search('Upload Error') > -1) {
					var buildReturn = '<span class="upload-error">' + response + '</span>';
					$(".upload-error").remove();
					clickedObject.parent().after(buildReturn);
				} else {
				
					$(".upload-error").remove();
					clickedObject.next('span').fadeIn();
					clickedObject.parent().find('.uploaded_url').val(response);
				}
			}
		});
	});
}
