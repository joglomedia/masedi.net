jQuery(document).ready( function($) {

// close postboxes that should be closed
$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
// postboxes setup
postboxes.add_postbox_toggles('<?php echo $this->nonPostHook; ?>');

jQuery.fn.opseoURLValidation = function() {

	var msg = '';
	var title = 1;
	var url = 1;

	if(jQuery.trim($('#nonpost-title').val()).length == 0) { title = 0; msg = '<p><strong>Error:</strong> Title is required.</p>'; }

	if(jQuery.trim($('#nonpost-url').val()).length == 0) { url = 0; msg += '<p><strong>Error:</strong> URL is required.</p>'; }

	if( title == 0 || url == 0)
	{
		$('#opseo-url-error').html(msg)
		$('#opseo-url-error').show();
		return false;
	}

};

// Categories Select Box Change
jQuery('#opseo-categories-select').change(function() {

	// Update URL
	jQuery('#nonpost-url').val(jQuery.trim(jQuery('#opseo-categories-select option:selected').val()));

	// Update Title
	jQuery('#nonpost-title').val(jQuery.trim(jQuery('#opseo-categories-select option:selected').attr('title')) + ' (Category)');

});

// Archives Select Box Change
jQuery('#opseo-archives-select').change(function() {

	// Update URL
	jQuery('#nonpost-url').val(jQuery.trim(jQuery('#opseo-archives-select option:selected').val()));

	// Update Title
	jQuery('#nonpost-title').val(jQuery.trim(jQuery('#opseo-archives-select option:selected').text()) + ' (Archive)');

});

jQuery('#categorieslinkminus').hide();
jQuery('#archiveslinkminus').hide();
jQuery('#opseocategories').hide();
jQuery('#opseoarchives').hide();

jQuery.fn.toggleOPSEOURL = function(state) {

	// Categories Show
	if(state == 1)
	{
		jQuery('#categorieslinkplus').hide();
		jQuery('#categorieslinkminus').show();
		jQuery('#opseocategories').show();

		jQuery('#archiveslinkminus').hide();
		jQuery('#opseoarchives').hide();
		jQuery('#archiveslinkplus').show();
	}
	// Categories Hide
	else if(state == 0)
	{
		jQuery('#categorieslinkminus').hide();
		jQuery('#opseocategories').hide();
		jQuery('#categorieslinkplus').show();

		jQuery('#archiveslinkplus').show();
		jQuery('#archiveslinkminus').hide();
		jQuery('#opseoarchives').hide();
	}
	// Archives Show
	else if(state == 3)
	{
		jQuery('#archiveslinkplus').hide();
		jQuery('#archiveslinkminus').show();
		jQuery('#opseoarchives').show();

		jQuery('#categorieslinkminus').hide();
		jQuery('#opseocategories').hide();
		jQuery('#categorieslinkplus').show();
	}
	// Archives Hide
	else if(state == 2)
	{
		jQuery('#archiveslinkminus').hide();
		jQuery('#opseoarchives').hide();
		jQuery('#archiveslinkplus').show();

		jQuery('#categorieslinkplus').show();
		jQuery('#categorieslinkminus').hide();
		jQuery('#opseocategories').hide();
	}
};

});