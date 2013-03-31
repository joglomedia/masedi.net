<?php
/**
 * WPNuke Theme Functions
 *
 * Theme file which loads all theme functions.
 *
 * @author 		WPNuke
 * @category 	WPNuke/Inc
 * @package 	Vacancy
 * @version     1.0
 */

/**
 * This function return Options Framework option setting
 *
 * @param string $name option name
 * @param string $default
 * @return $option
 */
if (! function_exists('wpnuke_get_option')) {
	function wpnuke_get_option($name, $default = false) {
		$config = get_option( 'optionsframework' );

		if ( ! isset( $config['id'] ) ) return $default;

		$options = get_option( $config['id'] );

		if ( isset( $options[$name] ) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}

/**
 * This function update the Options Framework option setting
 *
 * @param string $name option name
 * @param string $new_value option new value
 * @param string $default
 * @return $option
 */
if (! function_exists('wpnuke_update_option')) {
	function wpnuke_update_option($name, $new_value) {
		$config = get_option( 'optionsframework' );
		
		if ( ! isset( $config['id'] ) ) {
			// This gets the theme name from the stylesheet (lowercase and without spaces)
			$themename = get_option( 'stylesheet' );
			$themename = preg_replace("/\W/", "_", strtolower($themename) );
			$config['id'] = $themename;
		}

		$options = get_option( $config['id'] );

		if ( $new_value != $options[$name] )
			$options[$name] = $new_value;
			
		return update_option( $config['id'], $options );
	}
}

/** This code copied and modified from Woocommerce **/

if ( ! function_exists( 'wpnuke_get_page_id' ) ) {

	/**
	 * WPNuke page IDs
	 *
	 * retrieve page ids - used for myaccount, change_password, blog, company, etc
	 *
	 * returns -1 if no page is found
	 *
	 * @access public
	 * @param string $page
	 * @return int
	 */
	function wpnuke_get_page_id( $page ) {
		$page = apply_filters('wpnuke_get_' . $page . '_page_id', wpnuke_get_option($page . '_page_id'));
		return ( $page ) ? $page : -1;
	}
}
/** END of copied code **/


// Register Javascripts

//wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.1.min.js', array(), '2.6.1', false);
//wp_register_script('modernizr', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '2.1', false);


/*
wp_register_script('wpnuke_custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0');
wp_register_script('wpnuke_prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), '3.1.3');
wp_register_script('wpnuke_tools', get_template_directory_uri() . '/js/jquery.tools.min.js', array('jquery'), '1.2.6');
wp_register_script('wpnuke_nivo', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery'), '2.5.2');
wp_register_script('wpnuke_accordion', get_template_directory_uri() . '/js/jquery.elegantAccordion.min.js', array('jquery'), '1.0');
wp_register_script('wpnuke_cycle', get_template_directory_uri() . '/js/jquery.cycle.all.js', array('jquery'), '2.9995');
wp_register_script('wpnuke_caroufredsel', get_template_directory_uri() . '/js/jquery.carouFredSel-5.6.1-packed.js', array('jquery'), '5.6.1');
*/

function wpnuke_theme_styles() { 
// Register the style like this for a theme:  
// (First the unique name for the style (custom-style) then the src, 
// then dependencies and ver no. and media type)
wp_register_style( 'normalize-style', get_template_directory_uri() . '/styles/normalize.css', array(), '', 'all' );
wp_register_style( 'flexslider-style', get_template_directory_uri() . '/styles/normalize.css', array(), '', 'all' );

// enqueing:
wp_enqueue_style( 'normalize-style' );
}
//add_action('wp_enqueue_scripts', 'wpnuke_theme_styles');

// Add Favicon
function wpnuke_favicon(){
	echo '<link rel="shortcut icon" href="' . wpnuke_get_option('favicon') . '" />' . "\n";
}
add_action('wp_head', 'wpnuke_favicon');

// Login Logo
function wpnuke_custom_login() {
	echo '<style type="text/css">
	h1 a { background-image:url('. wpnuke_get_option('login_logo') . ') !important; margin-bottom: 10px; background-size:auto 90px !important; height:90px !important; }
	</style>
	<script type="text/javascript">window.onload = function(){document.getElementById("login").getElementsByTagName("a")[0].href = "'. home_url() . '";document.getElementById("login").getElementsByTagName("a")[0].title = "Go to site";}</script>';
}
add_action('login_head', 'wpnuke_custom_login');

// Add rel prettyPhoto to WP Gallery
function wpnuke_prettyphoto_rel ($content) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto['.$post->ID.']"$6>$7</a>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
add_filter('the_content', 'wpnuke_prettyphoto_rel', 12);
add_filter('get_comment_text', 'wpnuke_prettyphoto_rel');

function wpnuke_failed_login () {
    return 'The login information you have entered is incorrect.';
}
add_filter ( 'login_errors', 'wpnuke_failed_login' );

// Get The First Image from The Post
function wpnuke_get_first_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches[1][0];

	if (empty($first_img)){ //Defines a default image
		$first_img = "/images/default.jpg";
	}

	return $first_img;
}

// Dropdown Category for Custom Search filter
class Category_Dropdown_Walker extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
	// Overwrite existing predefined function
	
	function start_lvl(&$output, $depth, $args) {
		if ('dropdown' != $args['style']) return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<select class=''>\n";
	}
	
	function end_lvl(&$output, $depth, $args) {
		if ('dropdown' != $args['style']) return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</select>\n";
	}

	function start_el(&$output, $category, $depth, $args) {
		$pad = str_repeat('&nbsp;', $depth * 3);
		$cat_name = apply_filters('list_cats', $category->name, $category);
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\"";
		
		if ($category->term_id == $args['selected'])
			$output .= ' selected="selected"';
		
		$output .= '>';
		$output .= $pad.$cat_name;
		
		if ($args['show_count'])
		$output .= '&nbsp;&nbsp;('. $category->count .')';
		
		if ($args['show_last_update']) {
			$format = 'Y-m-d';
			$output .= '&nbsp;&nbsp;' . gmdate($format, $category->last_update_timestamp);
		}
		
		$output .= "</option>\n";
	}
	
	function end_el(&$output, $category, $depth, $args) {
	
	}
}


// Improve WordPress Custom Menu
class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'. esc_attr($class_names) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= ! empty($item->target)	 ? ' target="' . esc_attr($item->target	) .'"' : '';
		$attributes .= ! empty($item->xfn)		? ' rel="'	. esc_attr($item->xfn		) .'"' : '';
		$attributes .= ! empty($item->url)		? ' href="'   . esc_attr($item->url		) .'"' : '';

		$prepend = '';
		$append = '';
		$description  = ! empty($item->description) ? '<br><span>'.esc_attr($item->description).'</span>' : '';

		if ($depth != 0)
		{
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters('the_title', $item->title, $item->ID).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

// Remove additional 10px width on WordPress Caption
function wpnuke_cleaner_caption($output, $attr, $content) {
	if (is_feed())
		return $output;
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);
	$attr = shortcode_atts($defaults, $attr);
	if (1 > $attr['width'] || empty($attr['caption']))
		return $content;
	$attributes = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '');
	$attributes .= ' class="wp-caption ' . esc_attr($attr['align']) . '"';
	$attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';
	$output = '<div' . $attributes .'>';
	$output .= do_shortcode($content);
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';
	$output .= '</div>';
	return $output;
}
add_filter('img_caption_shortcode', 'wpnuke_cleaner_caption', 10, 3);

// Remove elements from the header
function wpnuke_generator() {
	return '<meta name="generator" content="WPNuke.com" />';
}
add_filter('the_generator', 'wpnuke_generator');

// Remove some header meta
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// Custom Gravatar
add_filter('avatar_defaults', 'wpnuke_gravatar');
function wpnuke_gravatar ($avatar_defaults) {
	$myavatar = wpnuke_get_option('gravatar');
	$avatar_defaults[$myavatar] = "WPNuke";
	return $avatar_defaults;
}

/** Custom Theme Functions **/
/**
 * Display or retrieve the HTML dropdown list of categories.
 *
 * Default Wordpress dropdown categories with little modification
 *
 * @since 2.1.0
 *
 * @param string|array $args Optional. Override default arguments.
 * @return string HTML content only if 'echo' argument is 0.
 */
function wpnuke_dropdown_categories( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 
		'show_option_none' => '',
		'orderby' => 'id', 
		'order' => 'ASC',
		'show_count' => 0,
		'hide_empty' => 1, 
		'child_of' => 0,
		'exclude' => '', 
		'echo' => 1,
		'selected' => 0, 
		'hierarchical' => 0,
		'name' => 'cat', 
		'id' => '',
		'class' => 'postform', 
		'depth' => 0,
		'tab_index' => 0, 
		'taxonomy' => 'category',
		'hide_if_empty' => false
	);

	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;

	// Back compat.
	if ( isset( $args['type'] ) && 'link' == $args['type'] ) {
		_deprecated_argument( __FUNCTION__, '3.0', '' );
		$args['taxonomy'] = 'link_category';
	}

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
		$r['pad_counts'] = true;
	}

	extract( $r );

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 )
		$tab_index_attribute = " tabindex=\"$tab_index\"";

	$categories = get_terms( $taxonomy, $r );
	$name = esc_attr( $name );
	$class = esc_attr( $class );
	$id = $id ? esc_attr( $id ) : $name;

	if ( ! $r['hide_if_empty'] || ! empty($categories) )
		$output = "<select name='$name' id='$id' class='$class' $tab_index_attribute>\n";
	else
		$output = '';

	if ( empty($categories) && ! $r['hide_if_empty'] && !empty($show_option_none) ) {
		$show_option_none = apply_filters( 'list_cats', $show_option_none );
		$output .= "\t<option value='-1' selected='selected'>$show_option_none</option>\n";
	}

	if ( ! empty( $categories ) ) {

		if ( $show_option_all ) {
			$show_option_all = apply_filters( 'list_cats', $show_option_all );
			$selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
		}

		if ( $show_option_none ) {
			$show_option_none = apply_filters( 'list_cats', $show_option_none );
			$selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
		}

		if ( $hierarchical )
			$depth = $r['depth'];  // Walk the full depth.
		else
			$depth = -1; // Flat.

		$output .= wpnuke_walk_category_dropdown_tree( $categories, $depth, $r );
	}

	if ( ! $r['hide_if_empty'] || ! empty($categories) )
		$output .= "</select>\n";

	$output = apply_filters( 'wp_dropdown_cats', $output );

	if ( $echo )
		echo $output;

	return $output;
}

/**
 * Retrieve HTML dropdown (select) content for category list.
 *
 * @uses Walker_CategoryDropdown to create HTML dropdown content.
 * @since 2.1.0
 * @see Walker_CategoryDropdown::walk() for parameters and return description.
 */
function wpnuke_walk_category_dropdown_tree() {
	$args = func_get_args();
	// the user's options are the third parameter
	if ( empty($args[2]['walker']) || !is_a($args[2]['walker'], 'Walker') )
		$walker = new WPNuke_Walker_CategoryDropdown;
	else
		$walker = $args[2]['walker'];

	return call_user_func_array(array( &$walker, 'walk' ), $args );
}

/**
 * Create HTML dropdown list of Categories.
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class WPNuke_Walker_CategoryDropdown extends Walker_CategoryDropdown  {
	// Overwrite existing functions
	
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int $depth Depth of category. Used for padding.
	 * @param array $args Uses 'selected' and 'show_count' keys, if they exist.
	 */
	function start_el( &$output, $category, $depth, $args, $id = 0 ) {
		$pad = str_repeat('&nbsp;', $depth * 3);

		$cat_name = apply_filters('list_cats', $category->name, $category);
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\"";
		if ( $category->term_id == $args['selected'] )
			$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
			$output .= '&nbsp;&nbsp;('. $category->count .')';
		$output .= "</option>\n";
	}
}

/*
 * Generate related post by post tags and category
 */
function wpnuke_generate_related_post($count=5) {
		global $post;
		$orig_post = $post;
		$tags = wp_get_post_tags($post->ID);
		$cats = '';
		
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=> $count, // Number of related posts that will be shown.
				'caller_get_posts'=>1
			);
			$my_query = new WP_Query( $args );
			if( $my_query->have_posts() ) {
				
				$results .= "<ul>";
				
				while( $my_query->have_posts() ) {
				$my_query->the_post();
				$results .="<li><a href=\"" .get_permalink(). "\" rel=\"bookmark\" title=\"" .get_the_title(). "\">" .get_the_title(). "</a></li>";
				}
				
				$results .= "</ul>";
			}
		}
		$post = $orig_post;
		wp_reset_query();
		
	return $results;
}

/* 
 * Insert related post tag code 
 * usage: [insertrelatedpost title="Related Articles" align="left" count="5"]
 */
function wpnuke_insert_related_post($atts) {
	$count = $atts['count']; if (empty($count)){$count=5;}
	$title = trim($atts['title']); if (empty($title)){$title="Related Articles";}
	$style = $atts['align']; if (empty($style)){$style="left";}
	$html = "";
	
	/* Check if exist Contextual Related Post plugin */
	if (function_exists("ald_crp")) {
		$html = "<div id=\"innerrelatedposts\" class=\"align" .$style. "\">" .ald_crp('is_widget=0'). "</div>";
	} else {
		$html = "<div id=\"innerrelatedposts\" class=\"align" .$style. "\"><h3>" .$title. "</h3>
		" .wpnuke_generate_related_post($count). "</div>";
	}
	
	return $html;
}
add_shortcode('insertrelatedpost', 'wpnuke_insert_related_post');

?>