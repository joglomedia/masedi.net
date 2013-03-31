;(function($){
	$(document).ready(function(){
		$('#popup_domination_promote').change(function(){
			promote();
		})
	})

	function promote(){
		var checked = $('#popup_domination_promote').is(':checked');
		if(checked == true){
			$('#popup_domination_clickbank').removeAttr('disabled');
		}else{
			$('#popup_domination_clickbank').attr('disabled','disabled');
		}
	}

})(jQuery);