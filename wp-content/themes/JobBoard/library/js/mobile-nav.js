jQuery = jQuery.noConflict();
jQuery(document).ready(function() {
    <!--jQuery("blockquote").before('<span class="before_quote"></span>').after('<span class="after_quote"></span>');-->

	if(jQuery('.menu-header ul li.current-menu-item a').html() == null) {
		jQuery('.currentmenu span').html('Navigation');
	}/*  else {
		jQuery('.currentmenu span').html(jQuery('.menu-header ul li.current-menu-item a').html());
	} */
    jQuery('.currentmenu,.currentmenu span').click(function(){
		jQuery(this).parent().find('.menu-header').slideToggle('slow', function() {});
		jQuery(this).parent().find('div.menu').slideToggle('slow', function() {});
	});

});
