;(function($){
	$(document).ready(function(){
		$('#popup_domination_active a').live('click',function(){
			var opts = {"action":'popup_domination_activation',
						"todo":$(this).attr('class'),
						"_wpnonce": $('#_wpnonce').val(),
						"_wp_http_referer": $('input[name="_wp_http_referer"]').val()};
			$.get(popup_domination_admin_ajax,opts,activate,'json');
			return false;
		});
		$('.spacing').hover(function(){
			$(this).children('.slider').stop().animate({left:'0%'},{queue:false,duration:150});
		},function(){
			$(this).children('.slider').stop().animate({left:'100%'},{queue:false,duration:150});
		});
		
		$('.help').click(function(){
			$(this).parent().find('.popdom_contentbox_inside').toggle('height');
		});
		$('#message').css('margin-top','30px').css('width','920px');
		$('#message:visible').delay(6000).fadeOut();
	
	});
	function activate(resp){
		var path = popup_domination_url;
		if(resp.error){
			alert(resp.error);
		} else if(resp.active){
				var txt = '<img src="'+path+'css/images/off.png" alt="off" width="6" height="6" />', class1 = 'inactive', txt2 = '<img src="'+path+'css/images/on.png" alt="on" width="6" height="6" />', class2 = 'turn-on', txt3 = 'Inactive', txt4 = 'Active',txt5 = 'TURN ON', txt6 = 'TURN OFF';
			if(resp.active == 'Y'){
				txt = '<img src="'+path+'css/images/on.png" alt="on" width="6" height="6" />';
				txt2 = '<img src="'+path+'css/images/off.png" alt="off" width="6" height="6" />';
				txt3 = 'Active';
				txt4 = 'Inactive';
				txt5 = 'TURN OFF';
				txt6 = 'TURN ON';
				class1 = 'active';
				class2 = 'turn-off';
			}
			$('#popup_domination_active').html('<span class="wording"><span class="'+class1+'">'+txt+'</span> PopUp Domination is '+txt3+' </span><div class="popup_domination_activate_button"><div class="border">'+txt2+'<a href="#activation" class="'+class2+'">'+txt5+'</a></div></div> <img class="waiting" style="display:none;" src="'+path+'css/images/wpspin_light.gif" alt="" />');
		} else {
			alert(resp);
		}
		$('#popup_domination_active .waiting').hide();
	};
	
})(jQuery);