;(function($){
	var timer;
	$(document).ready(function(){
		max_zindex();
		if(popup_domination_center && popup_domination_center == 'Y')
			init_center();
		$('a[href$="#open"]').click(function(){
			clearTimeout(timer);
			$('#popup_domination_lightbox_wrapper').fadeIn('fast');
			return false;
		});
		if(popup_domination_defaults){
			var defaults = popup_domination_defaults;
			for(var i in defaults){
				if($.trim(defaults[i]) != ''){
					$('#popup_domination_lightbox_wrapper form :text[name="'+i+'"]')
						.data('default_value',defaults[i])
						.focus(function(){
							var $this = $(this);
							if($this.val() == $this.data('default_value'))
								$this.val('');
						}).blur(function(){
							var $this = $(this);
							if($this.val() == '')
								$this.val($this.data('default_value'));
						});
				}
			}
		}
		$('#popup_domination_lightbox_close').click(function(){
			close_box();
			return false;
		});
		$('#popup_domination_lightbox_wrapper form').submit(function(){
			var checked = true;
			$('#popup_domination_lightbox_wrapper :text').each(function(){
				var $this = $(this), val = $this.val();
				if($this.data('default_value') && val == $this.data('default_value')){
					if(checked)
						$this.val('').focus();
					checked = false;
				}
				if(val == ''){
					checked = false;
				}
			});
			if(checked){
				close_box();
				return true;
			}
			return false;
		});
	});
	function center_it(){
		$('.popup-dom-lightbox-wrapper .lightbox-main').css({
			position:'absolute',
			left: ($(window).width() - $('.popup-dom-lightbox-wrapper .lightbox-main').outerWidth())/2,
			top: ($(window).height() - $('.popup-dom-lightbox-wrapper .lightbox-main').outerHeight())/2
		});
	}
	function init_center(){
		center_it();
		$(window).resize(center_it);
	};
	function max_zindex(){
		var maxz = 0;
		$('body *').each(function(){
			var cur = parseInt($(this).css('z-index'));
			maxz = cur > maxz ? cur : maxz;
		});
		$('#popup_domination_lightbox_wrapper').css('z-index',maxz+10);
	};
	function close_box(){
		$('#popup_domination_lightbox_wrapper').fadeOut('fast');
	};
})(jQuery);