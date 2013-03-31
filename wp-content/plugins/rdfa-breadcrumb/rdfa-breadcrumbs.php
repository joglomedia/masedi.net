<?php
/**
 * Plugin Name: RDFa Breadcrumb
 * Plugin URI: http://wordpress.org/extends/plugins/rdfa-breadcrumb
 * Description: RDFa Breadcrumb outputs fully customizable breadcrumb path. This plugin has inbuild RDFa markup, so google rich snippet will show breadcrumbs in search results.
 * Version: 2.2
 * Author: Mallikarjun Yawalkar
 * Author URI: http://profiles.wordpress.org/user/yawalkarm
 * License: GPL2
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 * 
 * @package RDFa Breadcrumb
 * @Version 2.2
 * @author Mallikarjun Yawalkar <mhyawalkar@gmail.com>
 * @copyright Copyright (c) 2011-2012, Mallikarjun Yawalkar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


/**
 * Shows a breadcrumb for all types of pages.
 *
 * @since 1.0
 * @param array $args
 * @return string
 */

 function rdfa_breadcrumb() {

	/* Set up the arguments for the breadcrumb. */

	$opts = get_option("rdfa_options");	

	$args = array(
		'prefix' 		=> $opts['prefix'],
		'suffix' 		=> $opts['suffix'],
		'title' 		=> $opts['title'], //__( ' ', 'rdfa-breadcrumb' ),
		'home_title' 		=> $opts['home_title'], //__( 'Home', 'rdfa-breadcrumb' ),
		'separator'		=> $opts['separator'],
		'front_page' 		=> false,
		'show_blog' 		=> false,
		'singular_post_taxonomy'=> 'category',
		'echo' 			=> true
	);

	if ( is_front_page() && !$args['front_page'] )
		return apply_filters( 'rdfa_breadcrumb', false );

	/* Format the title. */
	$title = ( !empty( $args['title'] ) ? '<span class="breadcrumbs-title">' . $args['title'] . '</span>': '' );

	$separator = ( !empty( $args['separator'] ) ) ? "<span class='separator'>{$args['separator']}</span>" : "<span class='separator'>/</span>";

	/* Get the items. */
	$items = rdfa_breadcrumb_get_items( $args );
	
	$breadcrumbs = '<!-- RDFa Breadcrumbs Plugin by Mallikarjun Yawalkar -->';
	$breadcrumbs .= '<div class="breadcrumb breadcrumbs"><div class="rdfa-breadcrumb"><div xmlns:v="http://rdf.data-vocabulary.org/#">';
	$breadcrumbs .= $args['prefix'];
	$breadcrumbs .= $title;
	$breadcrumbs .= join( " {$separator} ", $items );
	$breadcrumbs .= $args['suffix'];
	$breadcrumbs .= '</div></div></div>';
	$breadcrumbs .= '<!-- RDFa Breadcrumbs Plugin by Mallikarjun Yawalkar -->';

	$breadcrumbs = apply_filters( 'rdfa_breadcrumb', $breadcrumbs );

	if ( !$args['echo'] )
		return $breadcrumbs;
	else
		echo $breadcrumbs;
}

/**
 * Gets the items for the RDFa Breadcrumb.
 *
 * @since 0.4
 */
function rdfa_breadcrumb_get_items( $args ) {
	global $wp_query;

	$item = array();

	$show_on_front = get_option( 'show_on_front' );

	/* Front page. */
	if ( is_front_page() ) {
		$item['last'] = $args['home_title'];
	}

	/* Link to front page. */
	if ( !is_front_page() )
		$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'. home_url( '/' ) .'" class="home">' . $args['home_title'] . '</a></span>';

	/* If bbPress is installed and we're on a bbPress page. */
	if ( function_exists( 'is_bbpress' ) && is_bbpress() )
		$item = array_merge( $item, rdfa_breadcrumb_get_bbpress_items() );

	/* If viewing a home/post page. */
	elseif ( is_home() ) {
		$home_page = get_page( $wp_query->get_queried_object_id() );
		$item = array_merge( $item, rdfa_breadcrumb_get_parents( $home_page->post_parent ) );
		$item['last'] = get_the_title( $home_page->ID );
	}

	/* If viewing a singular post. */
	elseif ( is_singular() ) {

		$post = $wp_query->get_queried_object();
		$post_id = (int) $wp_query->get_queried_object_id();
		$post_type = $post->post_type;

		$post_type_object = get_post_type_object( $post_type );

		if ( 'post' === $wp_query->post->post_type && $args['show_blog'] ) {
			$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a></span>';
		}

		if ( 'page' !== $wp_query->post->post_type ) {

			/* If there's an archive page, add it. */
			if ( function_exists( 'get_post_type_archive_link' ) && !empty( $post_type_object->has_archive ) )
				$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a></span>';

			if ( isset( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) && is_taxonomy_hierarchical( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) ) {
				$terms = wp_get_object_terms( $post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"] );
				$item = array_merge( $item, rdfa_breadcrumb_get_term_parents( $terms[0], $args["singular_{$wp_query->post->post_type}_taxonomy"] ) );
			}

			elseif ( isset( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) )
				$item[] = get_the_term_list( $post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"], '', ', ', '' );
		}

		if ( ( is_post_type_hierarchical( $wp_query->post->post_type ) || 'attachment' === $wp_query->post->post_type ) && $parents = rdfa_breadcrumb_get_parents( $wp_query->post->post_parent ) ) {
			$item = array_merge( $item, $parents );
		}

		$item['last'] = get_the_title();
	}

	/* If viewing any type of archive. */
	else if ( is_archive() ) {

		if ( is_category() || is_tag() || is_tax() ) {

			$term = $wp_query->get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );

			if ( ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) && $parents = rdfa_breadcrumb_get_term_parents( $term->parent, $term->taxonomy ) )
				$item = array_merge( $item, $parents );

			$item['last'] = $term->name;
		}

		else if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {
			$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );
			$item['last'] = $post_type_object->labels->name;
		}

		else if ( is_date() ) {

			if ( is_day() )
				$item['last'] = __( 'Archives for ', 'rdfa-breadcrumb' ) . get_the_time( 'F j, Y' );

			elseif ( is_month() )
				$item['last'] = __( 'Archives for ', 'rdfa-breadcrumb' ) . single_month_title( ' ', false );

			elseif ( is_year() )
				$item['last'] = __( 'Archives for ', 'rdfa-breadcrumb' ) . get_the_time( 'Y' );
		}

		else if ( is_author() )
			$item['last'] = __( 'Archives by: ', 'rdfa-breadcrumb' ) . get_the_author_meta( 'display_name', $wp_query->post->post_author );
	}

	/* If viewing search results. */
	else if ( is_search() )
		$item['last'] = __( 'Search results for "', 'rdfa-breadcrumb' ) . stripslashes( strip_tags( get_search_query() ) ) . '"';

	/* If viewing a 404 error page. */
	else if ( is_404() )
		$item['last'] = __( 'Page Not Found', 'rdfa-breadcrumb' );

	return apply_filters( 'rdfa_breadcrumb_items', $item );
}

/**
 * Gets the items for the breadcrumb item if bbPress is installed.
 *
 * @since 0.4
 *
 * @param array $args Mixed arguments for the menu.
 * @return array List of items to be shown in the item.
 */
function rdfa_breadcrumb_get_bbpress_items( $args = array() ) {

	$item = array();

	$post_type_object = get_post_type_object( bbp_get_forum_post_type() );

	if ( !empty( $post_type_object->has_archive ) && !bbp_is_forum_archive() )
		$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_post_type_archive_link( bbp_get_forum_post_type() ) . '">' . bbp_get_forum_archive_title() . '</a></span>';

	if ( bbp_is_forum_archive() )
		$item[] = bbp_get_forum_archive_title();

	elseif ( bbp_is_topic_archive() )
		$item[] = bbp_get_topic_archive_title();

	elseif ( bbp_is_single_view() )
		$item[] = bbp_get_view_title();

	elseif ( bbp_is_single_topic() ) {

		$topic_id = get_queried_object_id();

		$item = array_merge( $item, rdfa_breadcrumb_get_parents( bbp_get_topic_forum_id( $topic_id ) ) );

		if ( bbp_is_topic_split() || bbp_is_topic_merge() || bbp_is_topic_edit() )
			$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . bbp_get_topic_permalink( $topic_id ) . '">' . bbp_get_topic_title( $topic_id ) . '</a></span>';
		else
			$item[] = bbp_get_topic_title( $topic_id );

		if ( bbp_is_topic_split() )
			$item[] = __( 'Split', 'rdfa-breadcrumb' );

		elseif ( bbp_is_topic_merge() )
			$item[] = __( 'Merge', 'rdfa-breadcrumb' );

		elseif ( bbp_is_topic_edit() )
			$item[] = __( 'Edit', 'rdfa-breadcrumb' );
	}

	elseif ( bbp_is_single_reply() ) {

		$reply_id = get_queried_object_id();

		$item = array_merge( $item, rdfa_breadcrumb_get_parents( bbp_get_reply_topic_id( $reply_id ) ) );

		if ( !bbp_is_reply_edit() ) {
			$item[] = bbp_get_reply_title( $reply_id );

		} else {
			$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . bbp_get_reply_url( $reply_id ) . '">' . bbp_get_reply_title( $reply_id ) . '</a></span>';
			$item[] = __( 'Edit', 'rdfa-breadcrumb' );
		}

	}

	elseif ( bbp_is_single_forum() ) {

		$forum_id = get_queried_object_id();
		$forum_parent_id = bbp_get_forum_parent( $forum_id );

		if ( 0 !== $forum_parent_id)
			$item = array_merge( $item, rdfa_breadcrumb_get_parents( $forum_parent_id ) );

		$item[] = bbp_get_forum_title( $forum_id );
	}

	elseif ( bbp_is_single_user() || bbp_is_single_user_edit() ) {

		if ( bbp_is_single_user_edit() ) {
			$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . bbp_get_user_profile_url() . '">' . bbp_get_displayed_user_field( 'display_name' ) . '</a></span>';
			$item[] = __( 'Edit' );
		} else {
			$item[] = bbp_get_displayed_user_field( 'display_name' );
		}
	}

	return apply_filters( 'rdfa_breadcrumb_get_bbpress_items', $item, $args );
}

/**
 * Gets parent pages of any post type.
 *
 * @since 0.1
 * @param int $post_id ID of the post whose parents we want.
 * @param string $separator.
 * @return string $html String of parent page links.
 */
function rdfa_breadcrumb_get_parents( $post_id = '', $separator = '/' ) {

	$parents = array();

	if ( $post_id == 0 )
		return $parents;

	while ( $post_id ) {
		$page = get_page( $post_id );
		$parents[]  = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a></span>';
		$post_id = $page->post_parent;
	}

	if ( $parents )
		$parents = array_reverse( $parents );

	return $parents;
}

/**
 * Searches for term parents of hierarchical taxonomies.
 *
 * @since 0.1
 * @param int $parent_id The ID of the first parent.
 * @param object|string $taxonomy The taxonomy of the term whose parents we want.
 * @return string $html String of links to parent terms.
 */
function rdfa_breadcrumb_get_term_parents( $parent_id = '', $taxonomy = '', $separator = '/' ) {

	$html = array();
	$parents = array();

	if ( empty( $parent_id ) || empty( $taxonomy ) )
		return $parents;

	while ( $parent_id ) {
		$parent = get_term( $parent_id, $taxonomy );
		$parents[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a></span>';
		$parent_id = $parent->parent;
	}

	if ( $parents )
		$parents = array_reverse( $parents );

	return $parents;
}

/**
 * Try to add automatically to Hybrid, Thematic, Thesis and Genesis
 *
 * @since 0.1
 * @return string
 */
function setup_rdfa_breadcrumb() {

	/* Hybrid */
	remove_action( 'hybrid_before_content', 'hybrid_breadcrumb' );
	add_action( 'hybrid_before_content', 'rdfa_breadcrumb' );

	/* Thematic */
	add_action( 'thematic_belowheader','rdfa_breadcrumb' );

	/* Thesis */
	add_action( 'thesis_hook_before_content','rdfa_breadcrumb' );

	/* Genesis */
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	add_action( 'genesis_before_loop', 'rdfa_breadcrumb' );
}

function create_menu() {
	//Add s main menu
	$page = add_menu_page('RDFa Breadcrumbs','RDFa Crumbs','administrator',__FILE__,'rdfa_breadcrumb_settings',plugins_url('/bc.png',__FILE__));

	add_action( 'admin_print_styles-' . $page, 'rdfa_admin_styles' );
	
}

function rdfa_admin_styles() {
	wp_enqueue_style( 'jquery_style' );

	wp_enqueue_script( 'rdfa-jquery' );
	wp_enqueue_script( 'rdfa-jquery-ui' );
	wp_enqueue_script( 'rdfa-jquery-accord' );
}

function rdfa_breadcrumb_settings() {
	//Settings page for RDFa Breadcrumb

	$opt = array(
		'prefix' 		=> '<p>',
		'suffix' 		=> '</p>',
		'title' 		=> __( ' ', 'rdfa-breadcrumb' ),
		'home_title' 		=> __( 'Home', 'rdfa-breadcrumb' ),
		'separator'		=> '&raquo',
		'front_page' 		=> false,
		'show_blog' 		=> false,
		'singular_post_taxonomy'=> 'category',
		'echo' 			=> true
	);
	
	add_option("rdfa_options",$opt);
	
	$args = get_option('rdfa_options');

	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div><h2>RDFa Breadcrumb</h2>
	<div style="width:68%; float:left;">
		<div id="accordion">
			<h3><a href="#">RDFa Breadcrumbs Options</a></h3>
			<div>
			<form method="POST" action="">
			<?php wp_nonce_field('rdfa_breadcrumb_option'); ?>		
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Prefix', 'rdfa-breadcrumb'); ?></th>
					<td><input type="text" name="prefix" value="<?php echo $args['prefix'];?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Suffix', 'rdfa-breadcrumb'); ?></th>
					<td><input type="text" name="suffix" value="<?php echo $args['suffix'];?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Title', 'rdfa-breadcrumb'); ?></th>
					<td><input type="text" name="title" value="<?php echo $args['title'];?>" /></td>
				</tr>			
				<tr valign="top">
					<th scope="row"><?php _e('Home Title', 'rdfa-breadcrumb'); ?></th>
					<td><input type="text" name="home_title" value="<?php echo $args['home_title'];?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Breadcrumb Seperator', 'rdfa-breadcrumb'); ?></th>
					<td><input type="text" name="separator" value="<?php echo $args['separator'];?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"></th>
					<td><input type="submit" name="submit" value="<?php _e('Update Options', 'rdfa-breadcrumb');?>" class="button-primary" /></td>
				</tr>			
			</table>
			</form>
			</div>
		</div>
		<div id="accordion2">
			<h3><a href="#">Donation Please!</a></h3>
			<div>
			<?php 
				$siteurl = get_option('siteurl');
				$donate = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/btn_donate.gif';			
			?>
				<p align="justify">We develop & support all of our plugins for free. If you use this plugin and find it useful please consider a donation as a token of your appreciation.</p>
				<p align="center"><a href="https://www.paypal.com/cgi-bin/webscr&business=nitiny892@gmail.com&cmd=_donations&item_name=Friends+of+Mallikarjun+Yawalkar"><img src="<?php echo $donate;?>" align="center" /></a></p>
			</div>
		</div>
	</div>
	<div style="width:30%; float:right;">
		<div id="accordion1">
			<h3><a href="#">RDFa Support</a></h3>
			<div>
				<p align="justify">RDFa Breadcrumb Plugin Support is available at Wordpress.org.</p>
				<p><button class="button-primary"><a href="http://wordpress.org/support/plugin/rdfa-breadcrumb" style="color:#FFFFFF; text-decoration:none;">RDFa Support Forum</a></button></p>
			</div>
		</div>
		<div id="accordion3">
			<h3><a href="#">Subscribe on Facebook</a></h3>
			<div>
				<p><div class="fb-subscribe" data-href="https://www.facebook.com/yawalkar.nitin" data-show-faces="true" data-width="280"></div></p>
			</div>
		</div>
		<div id="accordion4">
			<h3><a href="#">Other Plugins by Me</a></h3>
			<div>
				<ul type="square">
					<li><a href="http://wordpress.org/extend/plugins/facebook-subscriber-widget/" style="text-decoration:none;">Facebook Subscriber Widget</a></li>
					<li><a href="http://wordpress.org/extend/plugins/google-authorship-widget/" style="text-decoration:none;">Google Authorship Widget</a></li>
					<li><a href="http://wordpress.org/extend/plugins/google-add-to-circle/" style="text-decoration:none;">Google Add to Circle</a></li>
					<li><a href="http://wordpress.org/extend/plugins/df-pagination/" style="text-decoration:none;">DF-Pagination</a></li>
					<li><a href="http://wordpress.org/extend/plugins/admin-menu-tamplate-plugin/" style="text-decoration:none;">Admin Menu Blank Template Plugin</a></li>
				</ul>
			</div>
		</div>		
	</div>
</div>					
<?php
	if(isset($_POST['submit'])) {

	check_admin_referer('rdfa_breadcrumb_option');
		
		foreach(array('prefix','suffix','title','home_title','separator') as $option) {
			if(isset($_POST[$option])) {
				$args[$option] = $_POST[$option];
			}
		}
			if(update_option('rdfa_options',$args)) {
				echo '<div class="updated"><p>' . __('Success! Your changes were successfully saved!', 'rdfa-breadcrumb') . '</p></div>';
				echo '<script language="javascript">window.location.reload( true );</script>';
			} else {
				echo '<div class="error"><p>' . __('Sorry, But Your Changes Are Not Saved!', 'rdfa-breadcrumb') . '</p></div>';
			}
		$args = get_option('rdfa_options');
	}
}

function rdfa_styles() {
	wp_register_style( 'jquery_style', plugins_url('/css/rdfa-breadcrumb/rdfa_breadcrumb.css', __FILE__) );

	wp_register_script( 'rdfa-jquery', plugins_url('/js/jquery.js', __FILE__) ); 
	wp_register_script( 'rdfa-jquery-ui', plugins_url('/js/jquery-ui.js', __FILE__) );
	wp_register_script( 'rdfa-jquery-accord', plugins_url('/js/accord.js', __FILE__) ); 
}

// Add settings link on plugin page
function rdfa_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=rdfa-breadcrumb/rdfa-breadcrumbs.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'rdfa_settings_link' );

add_action( 'admin_init', 'rdfa_styles' );
add_action( 'init', 'setup_rdfa_breadcrumb' );
add_action( 'admin_menu', 'create_menu' );
?>
<?php 
/* Translation*/
if(!function_exists('rdfa_breadcrumb_translatation')){
	function rdfa_breadcrumb_translatation(){
		// Load localization file
		load_plugin_textdomain('rdfa-breadcrumb',false,'/'.dirname( plugin_basename( __FILE__ ) ) .'/lang/');
	}
}
add_action('plugins_loaded', 'rdfa_breadcrumb_translatation' );
?>