jQuery(document).ready(function() {

	jQuery('#onpageseo-copyscape-loader').hide();

		jQuery('#check-copyscape-scores').click(function(){

		if(jQuery('#opseo-copyscape-confirm').val() == 1)
		{
			if(!confirm('This will perform a Copyscape search and cost you one credit. Continue?'))
			{
				return false;
			}
		}

		jQuery('#onpageseo-copyscape-loader').show();
		jQuery('#onpageseo-copyscape-results').hide();

		var data = {
			action: 'onpageseo_copyscape',
			content: document.getElementById('content').value
		};

		jQuery.post(ajaxurl, data, function(response) {
			if(response)
			{
				jQuery('#onpageseo-copyscape-results').html(response);
				jQuery('#onpageseo-copyscape-loader').hide();
				jQuery('#onpageseo-copyscape-results').show();

				jQuery('#allcopyscaperesults').val(jQuery('#onpageseo-copyscape-results').html());
				jQuery('#updatedcopyscaperesults').val('1');

				// Update Balance
				jQuery(this).opseoCopyScapeBalance();
			}
		});

		return false;
	});



	jQuery.fn.opseoCopyScapeBalance = function() {

		var data = {
			action: 'onpageseo_copyscape_balance'
		};

		jQuery.post(ajaxurl, data, function(response) {
			if(response)
			{
				jQuery('#onpageseo-copyscape-balance').html(response);
			}
		});

		return false;
	};


	jQuery('#save-seo-report').click(function(){

		jQuery('<form action="admin.php?page=onpageseo-manage-keywords" method="post" target="_blank"><textarea name="opseo-ajax-content" id="opseo-ajax-content">'+jQuery('#myOnPageContent').html()+'</textarea><input type="hidden" name="onpageseo_save_report" value="1" />').appendTo('body').submit().remove();
	});


	jQuery('#onpageseoreportloader').hide();

	jQuery('#display-seo-report-button').click(function(){

		if(jQuery('#nonpost-url').val() !== undefined) {
			jQuery('#onpageseo-analyze-url').val(jQuery('#nonpost-url').val());
		}

		jQuery('#onpageseoreportloader').show();

		var data = {
			action: 'onpageseo_seo_report',
			opseopostid: document.getElementById('onpageseo-post-id').value,
			opseotype: document.getElementById('onpageseo-analyze-type').value,
			opseourl: document.getElementById('onpageseo-analyze-url').value
		};

		jQuery.post(ajaxurl, data, function(response) {
			if(response)
			{
				jQuery('#myOnPageContent').html(response);
				jQuery('#display-seo-report').click();
				jQuery('#onpageseoreportloader').hide();
			}
		});


	});

});