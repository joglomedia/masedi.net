;(function($){

	$(document).ready(function(){
		$('.thedeletebutton').click(function(){
			if(confirm('You are about to DELETE a campaign, are you sure?')){
				var id = $(this).attr('id');
				var name = $(this).attr('title');
				ajax_delete(id);
				ajax_analytic_delete(name);
			}
		})

	});
	
	
	function ajax_analytic_delete(name){
		var data = {
			action: 'popup_domination_delete_camp',
			table: popup_domination_delete_stats,
			id: name,
			column: 'Campname'
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
		});
	}
	
	function ajax_delete(id){
		var data = {
			action: 'popup_domination_delete_camp',
			table: popup_domination_delete_table,
			id: id
		};
		jQuery.post(popup_domination_admin_ajax, data, function(response) {
			$('#camprow_'+id).fadeOut();
		});
	}
	
})(jQuery);