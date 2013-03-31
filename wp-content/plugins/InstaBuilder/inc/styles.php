<?php

if ( !function_exists('is_plugin_active') )
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !is_plugin_active('ultimate-tinymce/main.php') && !is_plugin_active('ultimate-tinymce/ultimate-tinymce/main.php') ) {
	if ( defined('PT_REL_SCRIPTS') || defined('PVM_PATH') )
		add_filter('mce_buttons_4', 'opl_mce_buttons');
	else
		add_filter('mce_buttons_3', 'opl_mce_buttons');
}

function opl_mce_buttons( $buttons ) {
    	array_push( $buttons, 'styleselect', 'fontselect', 'fontsizeselect', 'separator');
    	return $buttons;
}

add_filter( 'tiny_mce_before_init', 'opl_mce_before_init' );
function opl_mce_before_init( $settings ) {
    	$style_formats = array(
    			array(
        				'title' => 'Drop Caps Red',
        				'inline' => 'span',
        				'classes' => 'ez-dc-red'
        			),
        		array(
        				'title' => 'Drop Caps Yellow',
        				'inline' => 'span',
        				'classes' => 'ez-dc-yellow'
        			),
        		array(
        				'title' => 'Drop Caps Green',
        				'inline' => 'span',
        				'classes' => 'ez-dc-green'
        			),
        		array(
        				'title' => 'Drop Caps Blue',
        				'inline' => 'span',
        				'classes' => 'ez-dc-blue'
        			),
        		array(
        				'title' => 'Drop Caps Purple',
        				'inline' => 'span',
        				'classes' => 'ez-dc-purple'
        			),
        		array(
        				'title' => 'Drop Caps Black',
        				'inline' => 'span',
        				'classes' => 'ez-dc-black'
        			),
        		array(
        				'title' => 'Drop Caps Orange',
        				'inline' => 'span',
        				'classes' => 'ez-dc-orange'
        			),
        		array(
        				'title' => 'Drop Caps Pink',
        				'inline' => 'span',
        				'classes' => 'ez-dc-pink'
        			),
        			
    			array(
        				'title' => 'Text Highlight Red',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#f51f29',
										'color' => '#FFFFFF'
							)
        			),
        		array(
        				'title' => 'Text Highlight Yellow',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#fdf957'
							)
        			),
        		array(
        				'title' => 'Text Highlight Green',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#99e32a'
							)
        			),
        		array(
        				'title' => 'Text Highlight Blue',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#38b4fc',
										'color' => '#FFFFFF'
							)
        			),
        		array(
        				'title' => 'Text Highlight Purple',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#891fcc',
										'color' => '#FFFFFF'
							)
        			),
        		array(
        				'title' => 'Text Highlight Black',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#111111',
										'color' => '#FFFFFF'
							)
        			),
        		array(
        				'title' => 'Text Highlight Orange',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#fbab27'
							)
        			),
        		array(
        				'title' => 'Text Highlight Pink',
        				'inline' => 'span',
        				'styles' => array(
        								'padding' => '0 4px',
										'backgroundColor' => '#da0764',
										'color' => '#FFFFFF'
							)
        			),
        		
        		array(
        				'title' => 'Text Shadow Dark',
        				'inline' => 'span',
        				'classes' => 'ez-shadow-dark'
        			),
        		array(
        				'title' => 'Text Shadow Light',
        				'inline' => 'span',
        				'classes' => 'ez-shadow-light'
        			),
        		array(
        				'title' => 'Text Shadow Grey',
        				'inline' => 'span',
        				'classes' => 'ez-shadow-grey'
        			),
        			
        		array(
        				'title' => 'Box Title Blue',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-blue'
        			),
        		array(
        				'title' => 'Box Title Green',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-green'
        			),
				array(
        				'title' => 'Box Title Red',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-red'
        			),
				array(
        				'title' => 'Box Title Yellow',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-yellow'
        			),
				array(
        				'title' => 'Box Title Grey',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-grey'
        			),
				array(
        				'title' => 'Box Title Brown',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-brown'
        			),
        		array(
        				'title' => 'Box Title Black',
        				'inline' => 'span',
        				'classes' => 'ez-boxtitle-black'
        			),
        			
				array(
        				'title' => 'Simple Box Blue',
        				'block' => 'div',
        				'classes' => 'simple-blue-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Simple Box Green',
        				'block' => 'div',
        				'classes' => 'simple-green-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Simple Box Red',
        				'block' => 'div',
        				'classes' => 'simple-red-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Simple Box Yellow',
        				'block' => 'div',
        				'classes' => 'simple-yellow-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Simple Box Grey',
        				'block' => 'div',
        				'classes' => 'simple-grey-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Simple Box Brown',
        				'block' => 'div',
        				'classes' => 'simple-brown-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
        		array(
        				'title' => 'Simple Box White',
        				'block' => 'div',
        				'classes' => 'simple-white-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
        			
        		array(
        				'title' => 'Rounded Box Blue',
        				'block' => 'div',
        				'classes' => 'rounded-blue-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Rounded Box Green',
        				'block' => 'div',
        				'classes' => 'rounded-green-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Rounded Box Red',
        				'block' => 'div',
        				'classes' => 'rounded-red-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Rounded Box Yellow',
        				'block' => 'div',
        				'classes' => 'rounded-yellow-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Rounded Box Grey',
        				'block' => 'div',
        				'classes' => 'rounded-grey-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Rounded Box Brown',
        				'block' => 'div',
        				'classes' => 'rounded-brown-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
        		array(
        				'title' => 'Rounded Box White',
        				'block' => 'div',
        				'classes' => 'rounded-white-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '5px auto 20px auto'
        				)
        			),
        			
				array(
        				'title' => 'Dashed Box Blue',
        				'block' => 'div',
        				'classes' => 'dashed-blue-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Dashed Box Green',
        				'block' => 'div',
        				'classes' => 'dashed-green-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Dashed Box Red',
        				'block' => 'div',
        				'classes' => 'dashed-red-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Dashed Box Yellow',
        				'block' => 'div',
        				'classes' => 'dashed-yellow-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Dashed Box Grey',
        				'block' => 'div',
        				'classes' => 'dashed-grey-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Dashed Box Brown',
        				'block' => 'div',
        				'classes' => 'dashed-brown-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
        		array(
        				'title' => 'Dashed Box White',
        				'block' => 'div',
        				'classes' => 'dashed-white-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
        				
				array(
        				'title' => 'Fancy Box Blue',
        				'block' => 'div',
        				'classes' => 'fancy-blue-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
        		array(
        				'title' => 'Fancy Box Green',
        				'block' => 'div',
        				'classes' => 'fancy-green-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Fancy Box Red',
        				'block' => 'div',
        				'classes' => 'fancy-red-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Fancy Box Yellow',
        				'block' => 'div',
        				'classes' => 'fancy-yellow-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Fancy Box Grey',
        				'block' => 'div',
        				'classes' => 'fancy-grey-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
				array(
        				'title' => 'Fancy Box Brown',
        				'block' => 'div',
        				'classes' => 'fancy-brown-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
        		array(
        				'title' => 'Fancy Box White',
        				'block' => 'div',
        				'classes' => 'fancy-white-box',
						'wrapper' => true,
						'styles' => array(
        					'width' => '70%',
        					'margin' => '0px auto 20px auto'
        				)
        			),
        		array(
    					'title' => ' Bullet List',
    					'selector' => 'ul',
    					'classes' => 'bullet-bullet'
    				),
    			array(
    					'title' => 'Check List #1',
    					'selector' => 'ul',
    					'classes' => 'bullet-check'
    				),
    			array(
    					'title' => 'Check List #2',
    					'selector' => 'ul',
    					'classes' => 'bullet-check2'
    				),
    			array(
    					'title' => 'Green Arrow List',
    					'selector' => 'ul',
    					'classes' => 'bullet-arrow1'
    				),
    			array(
    					'title' => 'Blue Arrow List',
    					'selector' => 'ul',
    					'classes' => 'bullet-arrow2'
    				),
        		array(
    					'title' => 'Plus List',
    					'selector' => 'ul',
    					'classes' => 'bullet-plus'
    				),
    			array(
    					'title' => 'Star List',
    					'selector' => 'ul',
    					'classes' => 'bullet-star'
    				),
    			array(
    					'title' => 'Busy List',
    					'selector' => 'ul',
    					'classes' => 'bullet-busy'
    				),
    			array(
    					'title' => 'Cross List',
    					'selector' => 'ul',
    					'classes' => 'bullet-cross'
    				),
    			array(
    					'title' => 'Folder List',
    					'selector' => 'ul',
    					'classes' => 'bullet-folder'
    				),
    			array(
    					'title' => 'Thumb List',
    					'selector' => 'ul',
    					'classes' => 'bullet-thumb'
    				),
    			array(
    					'title' => 'Heart List',
    					'selector' => 'ul',
    					'classes' => 'bullet-heart'
    				),
    			array(
    					'title' => 'Lock List',
    					'selector' => 'ul',
    					'classes' => 'bullet-lock'
    				),
    			array(
    					'title' => 'Help List',
    					'selector' => 'ul',
    					'classes' => 'bullet-help'
    				),
    			array(
    					'title' => 'Info List',
    					'selector' => 'ul',
    					'classes' => 'bullet-info'
    				),
   		);

    	$settings['style_formats'] = json_encode( $style_formats );

		$fonts = ''.
				'Arial=arial,helvetica,sans-serif;'.
        		'Arial Black=arial black,arial bold,arial,sans-serif;'.
        		'Arial Narrow=arial narrow,arial,helvetica neue,helvetica, sans-serif;'.
        		'Georgia=georgia,times new roman,times,serif;'.
        		'Impact=impact,charcoal, sans-serif;'.
        		'Lucida Grande=lucida grande,lucida sans unicode,sans-serif;'.
        		'Tahoma=tahoma,geneva,sans-serif;'.
        		'Times New Roman=times new roman,times,georgia,serif;'.
        		'Trebuchet MS=trebuchet ms,lucida grande,lucida sans,arial,sans-serif;'.
        		'Verdana=verdana,sans-serif;'.
        		
				'Arvo=Arvo,sans-serif;'.
				'Cabin=Cabin,sans-serif;'.
				'Covered By Your Grace=Covered By Your Grace,cursive;'.
				'Droid Sans=Droid Sans,sans-serif;'.
				'Droid Serif=Droid Serif,serif;'.
				'Open Sans=Open Sans,sans-serif;'.
				'PT Sans=PT Sans,sans-serif;'.
				'Rock Salt=Rock Salt,cursive;'.
				'Ubuntu=Ubuntu,sans-serif;'.
				'Vollkorn=Vollkorn,serif;'.
        		'';
				
		$fonts_css = ''.
					'http://fonts.googleapis.com/css?family=Arvo,'.
					'http://fonts.googleapis.com/css?family=Cabin,'.
					'http://fonts.googleapis.com/css?family=Covered+By+Your+Grace,'.
					'http://fonts.googleapis.com/css?family=Droid+Sans,'.
					'http://fonts.googleapis.com/css?family=Droid+Serif,'.
					'http://fonts.googleapis.com/css?family=Open+Sans,'.
					'http://fonts.googleapis.com/css?family=PT+Sans,'.
					'http://fonts.googleapis.com/css?family=Rock+Salt,'.
					'http://fonts.googleapis.com/css?family=Ubuntu,'.
					'http://fonts.googleapis.com/css?family=Vollkorn,'.
					OPL_URL . 'css/instabuilder.css'.
					'';
					
		if ( defined('PT_REL_SCRIPTS') )
			$fonts_css .= ',' . PT_REL_SCRIPTS . '/tinymce/css/pt-mce.css';
		
		$settings['theme_advanced_fonts'] = $fonts;
		$settings['content_css'] = $fonts_css;
		
    	return $settings;
}