/*
 * jQuery functions
 * Written by WPNuke
 *
 * Built for use with the jQuery library
 * http://jquery.com
 *
 * Version 1.0
 *
 * Left .js uncompressed so it's easier to customize
 */
jQuery(document).ready(function(){
	jQuery('#posts-filter').delegate('.editinline', 'click', function(){
		var tag_id = jQuery(this).closest('tr').attr('id');
		var wpn_company_slogan = jQuery('.job_company_slogan', '#'+tag_id).text();
		var wpn_company_phone = jQuery('.job_company_phone', '#'+tag_id).text();
		var wpn_company_email = jQuery('.job_company_email', '#'+tag_id).text();
		var wpn_company_url = jQuery('.job_company_url', '#'+tag_id).text();
		
		jQuery(':input[name="job_company_slogan"]', '.inline-edit-row').val(wpn_company_slogan);
		jQuery(':input[name="job_company_phone"]', '.inline-edit-row').val(wpn_company_phone);
		jQuery(':input[name="job_company_email"]', '.inline-edit-row').val(wpn_company_email);
		jQuery(':input[name="job_company_url"]', '.inline-edit-row').val(wpn_company_url);
		
		if(jQuery('#'+tag_id+' .active-yes').length != 0){
			jQuery("select option[value='yes']", '.inline-edit-row').attr("selected", "selected");
		}else{
			jQuery("select option[value='no']", '.inline-edit-row').attr("selected", "selected");
		}
	});
});

