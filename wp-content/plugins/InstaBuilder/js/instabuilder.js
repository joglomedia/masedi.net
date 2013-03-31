jQuery(document).ready(function($){
	$('ul.opl-tab-titles').each(function(){
		$("li:first-child", this).addClass('opl-selected');
	});

	$('.opl-tab').each(function(){
		var $this = $(this);
		$this.click(function(e){
			var tab_id = '#' + $this.attr('rel');
			$this.parent().parent().find('.opl-selected').removeClass('opl-selected');
			$this.parent().addClass('opl-selected');
			$this.parent().parent().parent().find('.opl-tab-content').hide();
			$(tab_id).fadeIn();
			e.preventDefault();
		});
	});
});